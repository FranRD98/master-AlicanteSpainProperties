<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

function getNumber($str){
    preg_match("/([0-9]+[\.,]?)+/",$str,$matches);
    return $matches[0];
}

function genRef($pref, $num) {

  $length = 5;

  $num = getNumber($num)+ 1;

  $chars = strlen($num);

  // $ret = str_repeat('0', ($length - $chars));

  return $pref . $num;

}


$query_rsReviewPropsUsrs = "SELECT * FROM prop_user WHERE id_prp = '".$_GET['id_prp']."' ORDER BY fecha_prp";
$rsReviewPropsUsrs = mysqli_query($inmoconn,$query_rsReviewPropsUsrs) or die(mysqli_error());
$row_rsReviewPropsUsrs = mysqli_fetch_assoc($rsReviewPropsUsrs);
$totalRows_rsReviewPropsUsrs = mysqli_num_rows($rsReviewPropsUsrs);


$query_rsMaxPrefRev = "SELECT referencia_prop FROM `properties_properties` WHERE `referencia_prop` REGEXP '^R[0-9]+' AND referencia_prop != 'R727611' AND referencia_prop != 'R727610' ORDER BY REPLACE(referencia_prop, 'R', '') + 0 DESC";
$rsMaxPrefRev = mysqli_query($inmoconn,$query_rsMaxPrefRev) or die(mysqli_error());
$row_rsMaxPrefRev = mysqli_fetch_assoc($rsMaxPrefRev);
$totalRows_rsMaxPrefRev = mysqli_num_rows($rsMaxPrefRev);


$query_rsMaxPrefAlq = "SELECT referencia_prop FROM `properties_properties` WHERE `referencia_prop` REGEXP '^A[0-9]+' ORDER BY REPLACE(referencia_prop, 'A', '') + 0 DESC";
$rsMaxPrefAlq = mysqli_query($inmoconn,$query_rsMaxPrefAlq) or die(mysqli_error());
$row_rsMaxPrefAlq = mysqli_fetch_assoc($rsMaxPrefAlq);
$totalRows_rsMaxPrefAlq = mysqli_num_rows($rsMaxPrefAlq);

$maxR = genRef('R', $row_rsMaxPrefRev['referencia_prop']);
$maxA = genRef('A', $row_rsMaxPrefAlq['referencia_prop']);

$valores = array('11', '14', '5', '');

if (in_array($row_rsInsertOwner['estado_prp'], $valores) ) {
  $referencia = $maxR;
} else{
  $referencia = $maxA;
}


$query_rsInsertOwner = "
INSERT INTO properties_owner (nombre_pro, apellidos_pro, direccion_pro)
VALUES ('".$row_rsInsertOwner['name_prp']."', '".$row_rsInsertOwner['nemail_prp']."', '".$row_rsInsertOwner['phone_prp']."');
";
$rsInsertOwner = mysqli_query($inmoconn,$query_rsInsertOwner) or die(mysqli_error());

$owner_id = mysqli_insert_id($inmoconn);

$notas = '';

if ($row_rsReviewPropsUsrs['piscina_prp'] != '') {
    $notas = "Pool: " . $row_rsReviewPropsUsrs['piscina_prp'] . "\n\n";
}

if ($row_rsReviewPropsUsrs['tiempo_prp'] != '') {
    $notas = "Timing: " . $row_rsReviewPropsUsrs['tiempo_prp'] . "\n\n";
}

if ($row_rsReviewPropsUsrs['consulta_prp'] != '') {
    $notas = "Consult: " . mysqli_real_escape_string($inmoconn,$row_rsReviewPropsUsrs['consulta_prp']) . "\n\n";
}


$query_rsInserProperty = "
INSERT INTO properties_properties (referencia_prop, operacion_prop, tipo_prop, localidad_prop, owner_prop, direccion_prop, cp_prop, habitaciones_prop, aseos_prop, m2_prop, m2_parcela_prop, preci_reducidoo_prop, notas_prop, inserted_xml_prop, updated_prop)
VALUES ('".$referencia."', '".$row_rsReviewPropsUsrs['estado_prp']."', '".$row_rsReviewPropsUsrs['tipo_prp']."', '".$row_rsReviewPropsUsrs['zona_prp']."', '".$owner_id."', '".$row_rsReviewPropsUsrs['direccion_prp']."', '".$row_rsReviewPropsUsrs['cp_prp']."', '".$row_rsReviewPropsUsrs['habitaciones_prp']."', '".$row_rsReviewPropsUsrs['banos_prp']."', '".$row_rsReviewPropsUsrs['m2_prp']."', '".$row_rsReviewPropsUsrs['m2p_prp']."', '".$row_rsReviewPropsUsrs['precio_prp']."', '".$notas."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');
";
$rsInserProperty = mysqli_query($inmoconn,$query_rsInserProperty) or die(mysqli_error() . '<hr>' . $query_rsInserProperty);

$property_id = mysqli_insert_id($inmoconn);

$images = explode(',', $row_rsReviewPropsUsrs['imagenes_prp']);

$imgOrd = 1;
foreach ($images as $value) {

    $query = "INSERT INTO properties_images SET ";

    $query .= "property_img = '".$property_id."',";
    $query .= "image_img = '".str_replace("'","\'", $value)."', ";
    $query .= "image_img2 = '".str_replace("'","\'", $value)."', ";
    $query .= "active_img = '1', ";
    $query .= "order_img = '".$imgOrd++."'";

    
    $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());

    rename($_SERVER["DOCUMENT_ROOT"] . "/media/images/list-properties/" . $value, $_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/" . $value);

}


$query_rsReviewPropsUsrs = "DELETE FROM `prop_user` WHERE id_prp = '".$_GET['id_prp']."'";
$rsReviewPropsUsrs = mysqli_query($inmoconn,$query_rsReviewPropsUsrs) or die(mysqli_error());

header("Location: properties-form.php?id_prop=" . $property_id);




?>