<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

// Cargamos las urls
include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



$query_rsXML = "SELECT * FROM xml_export WHERE id_exp = '".$_GET['id']."'";
$rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error());
$row_rsXML = mysqli_fetch_assoc($rsXML);
$totalRows_rsXML = mysqli_num_rows($rsXML);

$tipo = '';
if ($row_rsXML['type_exp'] != '' && trim($row_rsXML['type_exp']) != ',') {
  $tipo = ' AND tipo_prop IN ('.$row_rsXML['type_exp'].')';
}

$tipox = '';
if ($row_rsXML['type_ex_exp'] != '' && trim($row_rsXML['type_ex_exp']) != ',') {
  $tipox = ' AND tipo_prop NOT IN ('.$row_rsXML['type_ex_exp'].')';
}

$prov = '';
if ($row_rsXML['province_exp'] != '' && trim($row_rsXML['province_exp']) != ',') {
  $prov = ' AND (properties_loc2.parent_loc2 IN ('.$row_rsXML['province_exp'].') OR province1.id_loc2 IN ('.$row_rsXML['province_exp'].'))';
}

$provx = '';
if ($row_rsXML['province_ex_exp'] != '' && trim($row_rsXML['province_ex_exp']) != ',') {
  $provx = ' AND (properties_loc2.parent_loc2 NOT IN ('.$row_rsXML['province_ex_exp'].') OR province1.id_loc2 NOT IN ('.$row_rsXML['province_ex_exp'].'))';
}

$town = '';
if ($row_rsXML['town_exp'] != '' && trim($row_rsXML['town_exp']) != ',') {
  $town = ' AND (properties_loc3.parent_loc3 IN ('.$row_rsXML['town_exp'].') OR areas1.id_loc3 IN ('.$row_rsXML['town_exp'].'))';
}

$townx = '';
if ($row_rsXML['town_ex_exp'] != '' && trim($row_rsXML['town_ex_exp']) != ',') {
  $townx = ' AND (properties_loc3.parent_loc3 NOT IN ('.$row_rsXML['town_ex_exp'].') OR areas1.id_loc3 NOT IN ('.$row_rsXML['town_ex_exp'].'))';
}

$oper = '';
if ($row_rsXML['operation_exp'] != '') {
  $oper = ' AND operacion_prop IN ('.$row_rsXML['operation_exp'].')';
}

$operx = '';
if ($row_rsXML['operation_ex_exp'] != '') {
  $operx = ' AND operacion_prop NOT IN ('.$row_rsXML['operation_ex_exp'].')';
}

$beds = '';
if ($row_rsXML['beds_exp'] != '') {
  $val = explode(';', $row_rsXML['beds_exp']);
  $beds = ' AND habitaciones_prop >= '.$val[0].' AND habitaciones_prop <= '.$val[1].' ';
}

$baths = '';
if ($row_rsXML['baths_exp'] != '') {
  $val = explode(';', $row_rsXML['baths_exp']);
  $baths = ' AND aseos_prop >= '.$val[0].' AND aseos_prop <= '.$val[1].' ';
}

$price = '';
if ($row_rsXML['price_exp'] != '' && $row_rsXML['price_exp'] != 0) {
  $val = explode(';', $row_rsXML['price_exp']);
  $max = ($val[1] == '1000000')?'1000000000000':$val[1];
  $price = ' AND preci_reducidoo_prop >= '.$val[0].' AND preci_reducidoo_prop <= '.$max.' ';
}

$xml = '';
if ($row_rsXML['xml_exp'] == 0) {
  $xml = ' AND (xml_xml_prop IS NULL OR xml_xml_prop = \'\') ';
}

$kyero = '';
if ($row_rsXML['kyero_xml'] == 1) {
  $kyero = ' AND export_kyero_prop = 1 ';
}

$refs = '';
if ($row_rsXML['kyero_xml'] == 1 || $row_rsXML['xml_exp'] == 1) {
    if ($row_rsXML['ref_exp'] != '') {
        $refs .= ' OR id_prop IN ('.$row_rsXML['ref_exp'].')';
    }
} else {
    if ($row_rsXML['ref_exp'] != '') {
        $refs .= ' AND id_prop IN ('.$row_rsXML['ref_exp'].')';
        $xml = '';
    }
}

if ($row_rsXML['ref_ex_exp'] != '') {
    $refs .= ' AND id_prop NOT IN ('.$row_rsXML['ref_ex_exp'].')';
}

mysqli_select_db($inmoconn,$database_inmoconn); $limit='';
$query_rsPropertiesKyero = "

SELECT properties_properties.id_prop

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1
".$tipo ."
".$tipox ."
".$prov ."
".$provx ."
".$town ."
".$townx ."
".$oper ."
".$operx ."
".$beds ."
".$baths ."
".$price ."
".$xml ."
".$kyero."
".$refs."

GROUP BY id_prop

".$limit."

";
$rsPropertiesKyero = mysqli_query($inmoconn,$query_rsPropertiesKyero) or die(mysqli_error() .'<hr>'.$query_rsPropertiesKyero);
$row_rsPropertiesKyero = mysqli_fetch_assoc($rsPropertiesKyero);
$totalRows_rsPropertiesKyero = mysqli_num_rows($rsPropertiesKyero);

// echo $query_rsPropertiesKyero;
// echo "<hr>";

$theIdsKyero = array();

do {
if(isset($row_rsPropertiesKyero['id_prop']))
  array_push($theIdsKyero, $row_rsPropertiesKyero['id_prop']);

} while ($row_rsPropertiesKyero = mysqli_fetch_assoc($rsPropertiesKyero));

// echo "<pre>";
echo count($theIdsKyero);
// echo "</pre>";

mysqli_free_result($rsPropertiesKyero);
?>
