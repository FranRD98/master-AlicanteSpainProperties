<?php
// ini_set(display_errors, 1);
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
include( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/phpthumb/ThumbLib.inc.php');

function AddWatermarkImage($image) {
	$pathInfo = pathinfo($image);
	$path = '/media/images/properties';
	// $paths['filePath'] = $pathInfo['dirname'];
	// $paths['fileExt'] = $pathInfo['extension'];
	// $paths['fileBasename'] = $pathInfo['filename'] ? $pathInfo['filename'] : substr($fileName ,0,strrpos($fileName ,'.'));
	// $paths['fileSrc'] = $path . '' . $fileName;
	// $paths['cachePath'] = $path. 'thumbnails/';
	// $cachedName = $paths['fileBasename'] . '_ww';
	// $cachedName .= '.' . $paths['fileExt'];
	// $cachedPath = $paths['cachePath'] . $cachedName;
	// list($ancho, $alto, $tipo, $atributos) = getimagesize($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/' . $image);

	// if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath)) {
	// 	$thumb = PhpThumbFactory::create($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/' . $image);
	// 	$thumb->resize('1024', '800');
	// 	// $watermark = PhpThumbFactory::create($_SERVER["DOCUMENT_ROOT"] . '/media/images/website/watermark.png');
	// 	// $thumb->addWatermark($watermark, 'center', 50, 0, 0);
	// 	$thumb->save($_SERVER["DOCUMENT_ROOT"] . $cachedPath);
	// }

	return 'http://' . $_SERVER['HTTP_HOST'] . $path . '/' . $image;
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($inmoconn,$theValue) : mysqli_escape_string($theValue);

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


$query_rsProperties = "
SELECT
	properties_properties.id_prop,
	properties_properties.updated_prop,
	properties_properties.vista360_prop,
	properties_properties.referencia_prop,
	properties_properties.preci_reducidoo_prop,
	properties_status.slug_sta,
	types.types_en_typ,
	properties_types.types_en_typ as partyp,
	ubiflow_type_prop,
	towns.name_en_loc4,
	properties_loc4.name_en_loc4 as partown,
	areas1.name_en_loc3,
	properties_loc3.name_en_loc3 as pararea,
	areas1.id_loc3,
	towns.ciudad_ubiflow_loc4,
	towns.cp_ubiflow_loc4,
	properties_loc3.id_loc3,
	properties_properties.habitaciones_prop,
	properties_properties.direccion_gp_prop,
	properties_properties.lat_long_gp_prop,
	properties_properties.energia_prop,
	properties_properties.suma_prop,
	properties_properties.gastos_prop,
	properties_properties.aseos_prop,
	properties_properties.aseos2_prop,
	properties_properties.piscina_prop,
	properties_properties.m2_prop,
	properties_properties.m2_parcela_prop,
	properties_properties.construccion_prop,
	properties_properties.orientacion_prop,
	properties_properties.m2_balcon_prop,
	properties_properties.piscina_prop,
	properties_properties.plazas_garaje_prop,
	properties_properties.parking_prop,
	properties_properties.descripcion_de_prop,
	properties_properties.descripcion_da_prop,
	properties_properties.descripcion_en_prop,
	properties_properties.descripcion_es_prop,
	properties_properties.descripcion_fi_prop,
	properties_properties.descripcion_fr_prop,
	properties_properties.descripcion_is_prop,
	properties_properties.descripcion_nl_prop,
	properties_properties.descripcion_no_prop,
	properties_properties.descripcion_ru_prop,
	properties_properties.descripcion_se_prop,
	properties_properties.descripcion_zh_prop,
	rightmove_locations.id_rml,
	rightmove_locations.loc1_code_rml,
	rightmove_locations.loc1_rml,
	rightmove_locations.loc2_rml,
	rightmove_locations.loc3_rml,
	rightmove_locations.loc4_rml,
		CASE WHEN properties_properties.titulo_xml_da_prop != '' THEN properties_properties.titulo_xml_da_prop ELSE properties_properties.titulo_da_prop END AS titulo_da_prop,
		CASE WHEN properties_properties.titulo_xml_de_prop != '' THEN properties_properties.titulo_xml_de_prop ELSE properties_properties.titulo_de_prop END AS titulo_de_prop,
    CASE WHEN properties_properties.titulo_xml_en_prop != '' THEN properties_properties.titulo_xml_en_prop ELSE properties_properties.titulo_en_prop END AS titulo_en_prop,
    CASE WHEN properties_properties.titulo_xml_es_prop != '' THEN properties_properties.titulo_xml_es_prop ELSE properties_properties.titulo_es_prop END AS titulo_es_prop,
    CASE WHEN properties_properties.titulo_xml_fi_prop != '' THEN properties_properties.titulo_xml_fi_prop ELSE properties_properties.titulo_fi_prop END AS titulo_fi_prop,
    CASE WHEN properties_properties.titulo_xml_fr_prop != '' THEN properties_properties.titulo_xml_fr_prop ELSE properties_properties.titulo_fr_prop END AS titulo_fr_prop,
    CASE WHEN properties_properties.titulo_xml_is_prop != '' THEN properties_properties.titulo_xml_is_prop ELSE properties_properties.titulo_is_prop END AS titulo_is_prop,
    CASE WHEN properties_properties.titulo_xml_nl_prop != '' THEN properties_properties.titulo_xml_nl_prop ELSE properties_properties.titulo_nl_prop END AS titulo_nl_prop,
    CASE WHEN properties_properties.titulo_xml_no_prop != '' THEN properties_properties.titulo_xml_no_prop ELSE properties_properties.titulo_no_prop END AS titulo_no_prop,
    CASE WHEN properties_properties.titulo_xml_ru_prop != '' THEN properties_properties.titulo_xml_ru_prop ELSE properties_properties.titulo_ru_prop END AS titulo_ru_prop,
    CASE WHEN properties_properties.titulo_xml_se_prop != '' THEN properties_properties.titulo_xml_se_prop ELSE properties_properties.titulo_se_prop END AS titulo_se_prop,
    CASE WHEN properties_properties.titulo_xml_zh_prop != '' THEN properties_properties.titulo_xml_zh_prop ELSE properties_properties.titulo_zh_prop END AS titulo_zh_prop,
	operacion_prop
FROM
	properties_loc4 towns
	LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
	LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
	LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
	LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
	LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
	LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
	LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
	LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
	LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
	LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
	LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
	LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
	LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
WHERE
	properties_properties.activado_prop = 1
	AND export_ubiflow_prop = 1
	AND vendido_prop = 0
    AND alquilado_prop = 0
	AND reservado_prop = 0
	AND descripcion_en_prop != ''
	AND ubiflow_type_prop != ''
";

$rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

//

// echo $query_rsProperties;
// aa();

// header('Content-type: text/xml; charset=iso-8859-1', true);
$ret = '<?xml version="1.0" encoding="iso-8859-1"?'.'>';

$ret .= "<client>";
$ret .= "<advertiserAddress>";
$ret .= "<voirie><![CDATA[".$ubiflowAddressStreet."]]></voirie>";
$ret .= "<code_postal><![CDATA[".$ubiflowAddressCP."]]></code_postal>";
$ret .= "<ville><![CDATA[".$ubiflowAddressVille."]]></ville>";
$ret .= "<pays><![CDATA[".$ubiflowAddressCountry."]]></pays>";
$ret .= "</advertiserAddress>";
do {
$ret .= "<annonce>";

$ret .= "<reference><![CDATA[" . $row_rsProperties['referencia_prop'] . "]]></reference>";

// Título
$ret .= "<titre><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_en_prop']))). "]]></titre>";
if( @$row_rsProperties['titulo_da_prop'] != "" ) $ret .= "<titre_danois><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_da_prop']))). "]]></titre_danois>";
if( @$row_rsProperties['titulo_de_prop'] != "" ) $ret .= "<titre_allemand><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_de_prop']))). "]]></titre_allemand>";
if( @$row_rsProperties['titulo_en_prop'] != "" ) $ret .= "<titre_anglais><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_en_prop']))). "]]></titre_anglais>";
if( @$row_rsProperties['titulo_es_prop'] != "" ) $ret .= "<titre_espagnol><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_es_prop']))). "]]></titre_espagnol>";
if( @$row_rsProperties['titulo_fr_prop'] != "" ) $ret .= "<titre_fr><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_fr_prop']))). "]]></titre_fr>";
if( @$row_rsProperties['titulo_ru_prop'] != "" ) $ret .= "<titre_russe><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_ru_prop']))). "]]></titre_russe>";
if( @$row_rsProperties['titre_neerlandais'] != "" ) $ret .= "<titre_neerlandais><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode($row_rsProperties['titulo_nl_prop']))). "]]></titre_neerlandais>";
// Descripción
$ret .= "<texte><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_en_prop'])))). "]]></texte>";
if( @$row_rsProperties['descripcion_da_prop'] != "" ) $ret .= "<texte_danois><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_da_prop'])))). "]]></texte_danois>";
if( @$row_rsProperties['descripcion_de_prop'] != "" ) $ret .= "<texte_allemand><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_de_prop'])))). "]]></texte_allemand>";
if( @$row_rsProperties['descripcion_en_prop'] != "" ) $ret .= "<texte_anglais><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_en_prop'])))). "]]></texte_anglais>";
if( @$row_rsProperties['descripcion_es_prop'] != "" ) $ret .= "<texte_espagnol><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_es_prop'])))). "]]></texte_espagnol>";
if( @$row_rsProperties['descripcion_fr_prop'] != "" ) $ret .= "<texte_fr><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_fr_prop'])))). "]]></texte_fr>";
if( @$row_rsProperties['descripcion_ru_prop'] != "" ) $ret .= "<texte_russe><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_ru_prop'])))). "]]></texte_russe>";
if( @$row_rsProperties['descripcion_nl_prop'] != "" ) $ret .= "<texte_neerlandais><![CDATA[" . preg_replace('/&/', '&amp;',strip_tags(utf8_decode(str_replace('&nbsp;', ' ', $row_rsProperties['descripcion_nl_prop'])))). "]]></texte_neerlandais>";

$ret .= "<date_saisie>" . $row_rsProperties['updated_prop'] . "</date_saisie>";

if( @$row_rsProperties['vista360_prop'] != "" ) $ret .= "<visite_virtuelle>" . $row_rsProperties['vista360_prop'] . "</visite_virtuelle>";

if( @$ubiflowContactName != "" ) $ret .= "<contact_a_afficher>".$ubiflowContactName."</contact_a_afficher>";
if( @$ubiflowContactEmail != "" ) $ret .= "<email_a_afficher>".$ubiflowContactEmail."</email_a_afficher>";
if( @$ubiflowContactPhone != "" ) $ret .= "<telephone_a_afficher>".$ubiflowContactPhone."</telephone_a_afficher>";

$ret .= "<url_formulaire_rdv>https://".$_SERVER['HTTP_HOST'].propURL($row_rsProperties['id_prop'], 'en')."</url_formulaire_rdv>";

$ret .= "<photos>";

	
	$query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 10";
	$rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
	$row_rsImages = mysqli_fetch_assoc($rsImages);
	$totalRows_rsImages = mysqli_num_rows($rsImages);
	$x = 1;
	do {

        if($row_rsImages['image_img'] != 'Array') {
        if(preg_match('/http/', $row_rsImages['image_img'])) {
            $ret .= "<photo>" . ($row_rsImages['image_img']) . "</photo>";
        } else {
            $ret .= "<photo>" . AddWatermarkImage($row_rsImages['image_img']) . "</photo>";
        }
        }


} while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));
$ret .= "</photos>";

$ret .= "<bien>";
$ret .= "<code_type>" . $row_rsProperties['ubiflow_type_prop'] . "</code_type>";
$ret .= "<code_postal_reel>" . $row_rsProperties['cp_ubiflow_loc4'] . "</code_postal_reel>";
$ret .= "<code_postal_internet>" . $row_rsProperties['cp_ubiflow_loc4'] . "</code_postal_internet>";
$ret .= "<ville_reel>" . $row_rsProperties['ciudad_ubiflow_loc4'] . "</ville_reel>";
$ret .= "<ville_internet>" . $row_rsProperties['ciudad_ubiflow_loc4'] . "</ville_internet>";
$ret .= "<code_insee>" . $row_rsProperties['cp_ubiflow_loc4'] . "</code_insee>";
$ret .= "<communiquer_adresse_exacte>" . $ubiflowMostrarDireccion . "</communiquer_adresse_exacte>";
$ret .= "<adresse><![CDATA[" . utf8_decode($row_rsProperties['direccion_gp_prop']) . "]]></adresse>";

$latlong = preg_split('/\,/', $row_rsProperties['lat_long_gp_prop']);
if ($row_rsProperties['lat_long_gp_prop'] != '') {
	$ret .= "<latitude>".$latlong[0]."</latitude>";
	$ret .= "<longitude>".$latlong[1]."</longitude>";
}

if( @($row_rsProperties['m2_prop'] != "" && $row_rsProperties['m2_prop'] > 0 ) ) {
	$ret .= "<surface>" . number_format($row_rsProperties['m2_prop'], 0,'','') . "</surface>";
	if( @($row_rsProperties['m2_parcela_prop'] != "" && $row_rsProperties['m2_parcela_prop'] > 0) ) {
		$ret .= "<spc>" . number_format($row_rsProperties['m2_prop'], 0,'','') . "</spc>";
		$ret .= "<surface_terrain>" . number_format($row_rsProperties['m2_parcela_prop'], 0,'','') . "</surface_terrain>";
	}
} else if( @($row_rsProperties['m2_parcela_prop'] != "" && $row_rsProperties['m2_parcela_prop'] > 0) ) {
	$ret .= "<surface>" . number_format($row_rsProperties['m2_parcela_prop'], 0,'','') . "</surface>";
	$ret .= "<surface_terrain>" . number_format($row_rsProperties['m2_parcela_prop'], 0,'','') . "</surface_terrain>";
}

if( @($row_rsProperties['construccion_prop'] != "") ) $ret .= "<annee_construction>" . number_format($row_rsProperties['construccion_prop'], 0,'','') . "</annee_construction>";
if( @($row_rsProperties['habitaciones_prop'] != "" && $row_rsProperties['habitaciones_prop'] > 0)) $ret .= "<nb_chambres>" . $row_rsProperties['habitaciones_prop'] . "</nb_chambres>";
if( @($row_rsProperties['aseos_prop'] != "" && $row_rsProperties['aseos_prop'] > 0)) $ret .= "<nb_salles_de_bain>" . $row_rsProperties['aseos_prop'] . "</nb_salles_de_bain>";
if( @($row_rsProperties['aseos2_prop'] != "" && $row_rsProperties['aseos2_prop'] > 0)) {
	$ret .= "<nb_wc>" . $row_rsProperties['aseos2_prop'] . "</nb_wc>";
	$ret .= "<wc_independant>1</wc_independant>";
	$ret .= "<nb_wc_independants>" . $row_rsProperties['aseos2_prop'] . "</nb_wc_independants>";
}

if( @($row_rsProperties['m2_balcon_prop'] != "" && $row_rsProperties['m2_balcon_prop'] > 0)) $ret .= "<terrasse>true</terrasse>";
if( @(($row_rsProperties['plazas_garaje_prop'] != "" && $row_rsProperties['plazas_garaje_prop'] > 0) || ($row_rsProperties['parking_prop'] != "" && $row_rsProperties['parking_prop'] > 0))) $ret .= "<garage>true</garage>";
if( @($row_rsProperties['plazas_garaje_prop'] != "" && $row_rsProperties['plazas_garaje_prop'] > 0)) $ret .= "<places_garages>".$row_rsProperties['plazas_garaje_prop']."</places_garages>";
if( @($row_rsProperties['piscina_prop'] != "" && $row_rsProperties['piscina_prop'] > 0)) $ret .= "<piscine>true</piscine>";

$tags = getPropTags($row_rsProperties['id_prop'], "en");
foreach ($tags as $keyTag => $valueTag) {
	if ( $valueTag['id_tag'] == 1 ){
		$ret .= "<vue_sur_mer>true</vue_sur_mer>";
	}
}

if( @($row_rsProperties['orientacion_prop'] != "")){
	$orientation = array( "o-e" => "este", "o-eo" => "este/oeste", "o-no" => "noreste", "o-nese" => "noreste/suroeste", "o-ne" => "noroeste", "o-nose" => "noroeste/sureste", "o-n" => "norte", "o-ns" => "norte/sur", "o-o" => "oeste", "o-s" => "sur", "o-se" => "sureste", "o-so" => "suroeste" );
	$ret .= "<exposition>" . $orientation[$row_rsProperties['orientacion_prop']] . "</exposition>";
}
if( @($row_rsProperties['suma_prop'] != "" && $row_rsProperties['suma_prop'] > 0) )  $ret .= "<taxe_fonciere>" . (int)$row_rsProperties['suma_prop'] . "</taxe_fonciere>";

if( @($row_rsProperties['energia_prop'] != "" && $row_rsProperties['energia_prop'] != "" && $row_rsProperties['energia_prop'] != 0) ) $ret .= "<diagnostiques><dpe_etiquette_conso>".$row_rsProperties['energia_prop']."</dpe_etiquette_conso></diagnostiques>";

$ret .= "</bien>";
$ret .= "<prestation>";

switch ($row_rsProperties['operacion_prop']) {
	case '4':  // Long term rental
		$ret .= "<type>L</type>";
	break;

	case '3':  // Short term rental
		$ret .= "<type>S</type>";
	break;

	case '2':  // New Build
		$ret .= "<type>H</type>";
	break;

	default: // Resale
		$ret .= "<type>V</type>";
	break;
}

$ret .= "<prix>" . $row_rsProperties['preci_reducidoo_prop'] . "</prix>";
if( @($row_rsProperties['gastos_prop'] != "" && $row_rsProperties['gastos_prop'] > 0) )  $ret .= "<charges>" . (int)$row_rsProperties['gastos_prop'] . "</charges>"; // gastos comunidad (inquilino)
$ret .= "</prestation>";
$ret .= "</annonce>";
} while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));
$ret .= "</client>";

$newfile = "ubiflow/".$ubiflowFTPuser.".xml";
$file = fopen ($newfile, "w");
fwrite($file, $ret);
fclose ($file);

if (file_exists($ubiflowFTPuser.".zip")) {
	unlink($ubiflowFTPuser.".zip");
}

ini_set("max_execution_time", 0);
$zip = new ZipArchive();
if ($zip->open($ubiflowFTPuser.".zip", ZIPARCHIVE::CREATE) !== TRUE) {
	die ("Could not open archive");
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($_SERVER["DOCUMENT_ROOT"] . '/xml/ubiflow/'));

foreach ($iterator as $key=>$value) {
    $filExtens = pathinfo($key, PATHINFO_EXTENSION);
    if ($filExtens == 'xml') {
        $zip->addFile(realpath($key), str_replace($_SERVER["DOCUMENT_ROOT"] . '/xml/ubiflow/', "", $key)) or die ("ERROR: Could not add file: $key");
    }
}

$zip->close();
//exit();
array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/xml/ubiflow/*"));

if (!isset($_GET['debug_error'])) {
    include "inc/SFTP.php";
    $ftp = new SFTP($ubiflowFTP, $ubiflowFTPuser, $ubiflowFTPpass);
    if($ftp->connect()) {
        $ftp->cd('live/upload');
        if($ftp->put($ubiflowFTPuser.".zip", $ubiflowFTPuser.".zip",FTP_BINARY)) {

            array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/xml/*.zip"));
        }
    }
} else {
    header('Content-Type: application/zip');
    header("Content-Disposition: attachment; filename=$ubiflowFTPuser.'.zip'");
    header('Content-Length: ' . filesize($zipname));
    header("Location: ".$ubiflowFTPuser.".zip");
}


mysqli_free_result($rsProperties);
echo $totalRows_rsProperties;
