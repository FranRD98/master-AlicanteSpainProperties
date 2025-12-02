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

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/phpthumb/ThumbLib.inc.php');

function AddWatermarkImage($image, $imgName) {

    $image = preg_replace('/\?.*/', '', $image);

    $pathInfo = pathinfo($image);
    $path = '/media/images/properties/';
    $paths['filePath'] = $pathInfo['dirname'];
    $paths['fileExt'] = $pathInfo['extension'];
    $paths['fileBasename'] = $pathInfo['filename'] ? $pathInfo['filename'] : substr($fileName ,0,strrpos($fileName ,'.'));
    $paths['fileSrc'] = $path . '' . $fileName;
    $paths['cachePath'] = '/xml/openinmo/';
    $cachedName = $imgName;
    // $cachedName .= '.' . $paths['fileExt'];
    $cachedPath = $paths['cachePath'] . $cachedName;
    // list($ancho, $alto, $tipo, $atributos) = getimagesize($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/' . $image);

    if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath)) {
        $thumb = PhpThumbFactory::create($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/' . $image);
        $thumb->resize('1024', '800');
        // $watermark = PhpThumbFactory::create($_SERVER["DOCUMENT_ROOT"] . '/media/images/website/watermark.png');
        // $thumb->addWatermark($watermark, 'center', 50, 0, 0);
        $thumb->save($_SERVER["DOCUMENT_ROOT"] . $cachedPath);
    }

    return 'http://' . $_SERVER['HTTP_HOST'] . $cachedPath;

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Slug
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function clean($title) {
	$title = strip_tags($title);
	$title = remove_accents($title);


	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);

	$title = str_replace('%', '', $title);

	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}

	}

	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = str_replace('.', '-', $title);
	$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}

function cleanTrad($title) {
	$title = strip_tags($title);
	$title = remove_accents($title);


	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);

	$title = str_replace('%', '', $title);

	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}

	}

	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = str_replace('.', '_', $title);
	$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
	$title = preg_replace('/\s+/', '_', $title);
	$title = preg_replace('|-+|', '_', $title);
	$title = trim($title, '-');

	return $title;
}

function seems_utf8($str) {
	$length = strlen($str);
	for ($i=0; $i < $length; $i++) {
		$c = ord($str[$i]);
		if ($c < 0x80) $n = 0; # 0bbbbbbb
		elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
		elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
		elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
		elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
		elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
		else return false; # Does not match any model
		for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
			if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
				return false;
		}
	}
	return true;
}

function remove_accents($string) {
	if ( !preg_match('/[\x80-\xff]/', $string) )
		return $string;

	if (seems_utf8($string)) {
		$chars = array(
		// Decompositions for Latin-1 Supplement
		chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
		chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
		chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
		chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
		chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
		chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
		chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
		chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
		chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
		chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
		chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
		chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
		chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
		chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
		chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
		chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
		chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
		chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
		chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
		chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
		chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
		chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
		chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
		chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
		chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
		chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
		chr(195).chr(182) => 'o', chr(195).chr(182) => 'o',
		chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
		chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
		chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
		chr(195).chr(191) => 'y',
		// Decompositions for Latin Extended-A
		chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
		chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
		chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
		chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
		chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
		chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
		chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
		chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
		chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
		chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
		chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
		chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
		chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
		chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
		chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
		chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
		chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
		chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
		chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
		chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
		chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
		chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
		chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
		chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
		chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
		chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
		chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
		chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
		chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
		chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
		chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
		chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
		chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
		chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
		chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
		chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
		chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
		chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
		chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
		chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
		chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
		chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
		chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
		chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
		chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
		chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
		chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
		chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
		chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
		chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
		chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
		chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
		chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
		chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
		chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
		chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
		chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
		chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
		chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
		chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
		chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
		chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
		chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
		chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
		// Decompositions for Latin Extended-B
		chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
		chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
		// Euro Sign
		chr(226).chr(130).chr(172) => 'E',
		// GBP (Pound) Sign
		chr(194).chr(163) => '');

		$string = strtr($string, $chars);
	} else {
		// Assume ISO-8859-1 if not UTF-8
		$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
			.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
			.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
			.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
			.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
			.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
			.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
			.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
			.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
			.chr(252).chr(253).chr(255);

		$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

		$string = strtr($string, $chars['in'], $chars['out']);
		$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
		$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
		$string = str_replace($double_chars['in'], $double_chars['out'], $string);
	}

	return $string;
}

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


$query_rsXML = "SELECT * FROM xml_export WHERE uid_exp = '".$_GET['f']."'";
$rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error());
$row_rsXML = mysqli_fetch_assoc($rsXML);
$totalRows_rsXML = mysqli_num_rows($rsXML);


$query_rsProperties = "

SELECT properties_properties.id_prop,
	properties_properties.updated_prop,
	properties_properties.operacion_prop,
	properties_properties.referencia_prop,
	properties_properties.preci_reducidoo_prop,
	properties_status.slug_sta,
	properties_status.status_en_sta,
    CASE WHEN properties_types.types_en_typ IS NOT NULL THEN properties_types.types_en_typ ELSE types.types_en_typ END AS partyp,
    CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS id_typ,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province,
	CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS partown,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS pararea,
	properties_properties.habitaciones_prop,
	properties_properties.aseos_prop,
	properties_properties.piscina_prop,
	properties_properties.inserted_xml_prop,
	properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.m2_balcon_prop,
    properties_properties.construccion_prop,
	properties_properties.lat_long_gp_prop,
	CASE WHEN properties_properties.descripcion_xml_en_prop != '' THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
	CASE WHEN properties_properties.descripcion_xml_es_prop != '' THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
	CASE WHEN properties_properties.descripcion_xml_de_prop != '' THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
	CASE WHEN properties_properties.descripcion_xml_nl_prop != '' THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
	CASE WHEN properties_properties.descripcion_xml_fr_prop != '' THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
	CASE WHEN properties_properties.descripcion_xml_da_prop != '' THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
	CASE WHEN properties_properties.descripcion_xml_ru_prop != '' THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop

	FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
	    INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
	    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
	    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
	    INNER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
	    INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND properties_properties.immowelt_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0

GROUP BY id_prop ORDER BY id_prop DESC

";
$rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

// echo $query_rsProperties;
// aa();

// // // // // // // // // // // // // // // // // // // // // // // // // // // //
// objektart
// wohnung -> apartamento
// haus -> casa
// grundstueck -> terreno
// buero_praxen -> oficina
// einzelhandel -> comercio
// gastgewerbe -> hostelería
// hallen_lager_prod -> almacén
// land_und_forstwirtschaft -> tierra y silvicultura
// freizeitimmobilie_gewerblich -> comercio ocio
// zinshaus_renditeobjekt -> casa de producción
// sonstige -> otro
// // // // // // // // // // // // // // // // // // // // // // // // // // // //

function getObjektart($id) {

    switch ($id) {
        // apartamento
        case 1: // Apartamento
        case 86: // Piso
        case 94: // Top floor apartment
            switch ($id) {
                case 94:
                    $attr = 'DACHGESCHOSS="1"';
                    break;

                default:
                    $attr = 'ETAGE="1"';
                    break;
            }
            $objektart = '<wohnung ' . $attr . ' />';
         break;
        // casa
        case 5: // Villa *
        case 7: // Townhouse **
        case 10: // Country House ***
        case 64: // Luxury country villa *
        case 65: // House with income ****
        case 81: // House-ground-floor ****
        case 83: // Semi-Detached Villa *****
        case 107: // Triplex ****
        case 110: // Casa de Pueblo ****
        case 113: // Property ****
        case 114: // Detached ****
        case 115: // Detached Country House ***
        case 116: // Cave House ****
        case 119: // Chalet / Villa *
            switch ($id) {
                case 5: // *
                case 119:
                case 64:
                    $attr = 'VILLA';
                    break;
                case 7: // **
                    $attr = 'REIHENHAUS';
                    break;
                case 10: // ***
                case 115:
                    $attr = 'CHALET';
                    break;
                case 65: // ****
                case 81:
                case 107:
                case 110:
                case 113:
                case 114:
                case 116:
                    $attr = 'STADTHAUS';
                    break;
                case 83: // *****
                case 114:
                    $attr = 'DOPPELHAUSHAELFTE';
                    break;

                default:
                    $attr = 'ETAGE';
                    break;
            }
            $objektart = '<haus haustyp="' . $attr . '"/>';
         break;
        // terreno
        case 14: // Land
        case 104: // Plot of land
            $objektart = '<grundstueck/>';
         break;
        // oficina
        case 0:
            $objektart = '<buero_praxen/>';
         break;
        // comercio
        case 16: // Commercial
        case 88: // Commercial Property
        case 102: // CommercialProperties
        case 118: // Commertial Unit
            $objektart = '<einzelhandel EINZELHANDELSLADEN="1"/>';
         break;
        // gastgewerbe
        case 0:
            $objektart = '<gastgewerbe/>';
         break;
        // almacén
        case 0:
            $objektart = '<hallen_lager_prod/>';
         break;
        // tierra y silvicultura
        case 0:
            $objektart = '<land_und_forstwirtschaft/>';
         break;
        // comercio ocio
        case 0:
            $objektart = '<freizeitimmobilie_gewerblich/>';
         break;
        // casa de producción ???
        case 0:
        $objektart = '<zinshaus_renditeobjekt/>';
         break;

        default:
            $objektart = '<sonstige/>';
            break;
    }

    return $objektart;

}

// header('Content-type: text/xml; charset=UTF-8', true);
$return =  '<?xml version="1.0" encoding="UTF-8"?'.'>';

$ids = array();

$return .= '<openimmo>';
    $return .= '<anbieter>';
    do {
        $return .= '<immobilie>';
        $return .= '<objektkategorie>';
            $return .= '<nutzungsart WOHNEN="true" GEWERBE="false"/>';
            $return .= '<vermarktungsart KAUF="true" MIETE_PATCH="false"/>';
            $return .= '<objektart>';
            $return .= getObjektart($row_rsProperties['id_typ']);
            $return .= '</objektart>';
        $return .= '</objektkategorie>';
        $return .= '<geo>';
            $return .= '<ort>' . $row_rsProperties['partown'] . '</ort>';
            $latlong = preg_split('/\,/', $row_rsProperties['lat_long_gp_prop']);
            if ($row_rsProperties['lat_long_gp_prop'] != '') {
                $return .= '<geokoordinaten BREITENGRAD="' . trim((string)$latlong[0]) . '" LAENGENGRAD="' . trim((string)$latlong[1]) . '" />';
            }
            $return .= '<bundesland>' . $row_rsProperties['province'] . '></bundesland>';
            $return .= '<land ISO_LAND="ES" />';
        $return .= '</geo>';
        $return .= '<kontaktperson>';
            $return .= '<name>Sven Müller-Nicolai</name>';
            $return .= '<email_zentrale>sven@completespanishproperty.com</email_zentrale>';
            $return .= '<tel_zentrale>+49 15127554857</tel_zentrale>';
            $return .= '<firma>Complete Spanish Property</firma>';
            $return .= '<zusatzfeld>Calle Gauss, N.3 / Elche</zusatzfeld>';
            $return .= '<land ISO_LAND="ES" />';
            $return .= '<ort>Cdad. Quesada</ort>';
            $return .= '<plz>03203</plz>';
            $return .= '<url>https://completespanishproperty.eu</url>';
        $return .= '</kontaktperson>';
        $return .= '<preise>';
            $return .= '<kaufpreis>' . $row_rsProperties['preci_reducidoo_prop'] . '</kaufpreis>';
            $return .= '<kaufpreisnetto>' . $row_rsProperties['preci_reducidoo_prop'] . '</kaufpreisnetto>';
            $return .= '<kaufpreisbrutto>' . $row_rsProperties['preci_reducidoo_prop'] . '</kaufpreisbrutto>';
            $return .= '<waehrung ISO_WAEHRUNG="EUR" />';
        $return .= '</preise>';
        $return .= '<flaechen>';
            $return .= '<anzahl_zimmer>' . $row_rsProperties['habitaciones_prop'] . '</anzahl_zimmer>';
            $return .= '<anzahl_schlafzimmer>' . $row_rsProperties['habitaciones_prop'] . '</anzahl_schlafzimmer>';
            $return .= '<anzahl_badezimmer>' . $row_rsProperties['aseos_prop'] . '</anzahl_badezimmer>';
            $return .= '<gesamtflaeche>' . $row_rsProperties['m2_prop'] . '</gesamtflaeche>';
            $return .= '<wohnflaeche>' . $row_rsProperties['m2_prop'] . '</wohnflaeche>';
            $return .= '<nutzflaeche>' . $row_rsProperties['m2_prop'] . '</nutzflaeche>';
            $return .= '<grundstuecksflaeche>' . $row_rsProperties['m2_parcela_prop'] . '</grundstuecksflaeche>';
            $return .= '<balkon_terrasse_flaeche>' . $row_rsProperties['m2_balcon_prop'] . '</balkon_terrasse_flaeche>';
        $return .= '</flaechen>';
        $return .= '<zustand_angaben>';
            $return .= '<baujahr>' . $row_rsProperties['construccion_prop'] . '</baujahr>';
        $return .= '</zustand_angaben>';
        $return .= '<freitexte>';
            $return .= '<objektbeschreibung><![CDATA[ ' . strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_de_prop'])) . ' ]]></objektbeschreibung>';
        $return .= '</freitexte>';
        $return .= '<anhaenge>';
            
            $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 10";
            $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
            $row_rsImages = mysqli_fetch_assoc($rsImages);
            $totalRows_rsImages = mysqli_num_rows($rsImages);
            do {
                $ext = pathinfo($row_rsImages['image_img'], PATHINFO_EXTENSION);
                $imgName = md5($row_rsImages['image_img']) . '.' . $ext;
                if ($row_rsImages['image_img'] != 'Array'  && ( !isset($_GET["dev"]) || $_GET["dev"] != 1) ) {
                    if(preg_match('/https?:\/\//', $row_rsImages['image_img'])) {
                        $remote_file_contents = file_get_contents($row_rsImages['image_img']);
                        $local_file_path = $_SERVER["DOCUMENT_ROOT"] . '/xml/openinmo/' . $imgName;
                        file_put_contents($local_file_path, $remote_file_contents);
                    } else {
                        AddWatermarkImage($row_rsImages['image_img'], $imgName);
                    }
                }
                $return .= '<anhang location="EXTERN" gruppe="BILD">';
                    $return .= '<anhangtitel/>';
                    $return .= '<daten>';
                        $return .= '<pfad>' . $imgName . '</pfad>';
                    $return .= '</daten>';
                $return .= '</anhang>';
            } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));
        $return .= '</anhaenge>';
        $return .= '<verwaltung_techn>';
            $return .= '<objektnr_intern>' . $row_rsProperties['referencia_prop'] . '</objektnr_intern>';
            $return .= '<objektnr_extern>' . $row_rsProperties['referencia_prop'] . '</objektnr_extern>';
        $return .= '</verwaltung_techn>';
        $return .= '<ausstattung>';
            
            $query_rsprops_feats = "SELECT
            CASE WHEN features.feature_en_feat IS NOT NULL THEN properties_features.feature_en_feat ELSE features.feature_en_feat  END AS feature_en_feat,
            CASE WHEN features.id_feat IS NOT NULL THEN properties_features.id_feat ELSE features.id_feat  END AS id_feat
            FROM properties_property_feature INNER JOIN properties_features features ON properties_property_feature.feature = features.id_feat
                 RIGHT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
            WHERE properties_property_feature.property = '".$row_rsProperties['id_prop']."'
            ";
            $rsprops_feats = mysqli_query($inmoconn,$query_rsprops_feats) or die(mysqli_error());
            $row_rsprops_feats = mysqli_fetch_assoc($rsprops_feats);
            $totalRows_rsprops_feats = mysqli_num_rows($rsprops_feats);
            $aireacon = false;
            if ($row_rsProperties['piscina_prop'] == '1') {
                $return .= '<swimmingpool/>';
            }
            do {
                if((string)$row_rsprops_feats['feature_en_feat'] != '') {
                    if ($row_rsprops_feats['id_feat'] == '2033') {
                        $return .= '<kamin/>';
                    }
                    if ($row_rsprops_feats['id_feat'] == '849') {
                        $return .= '<fahrstuhl PERSONEN="1" />';
                    }
                    if (in_array($row_rsprops_feats['id_feat'], array(30,39,134,135,226,260,281,297,351,374,395,449,472,525,544,553,559,571,624,876,1016,1055,1946,2049,2072))) {
                        if ($aireacon == false) {
                            $aireacon = true;
                            $return .= '<klimatisiert/>';
                        }
                    }
                }
            } while ($row_rsprops_feats = mysqli_fetch_assoc($rsprops_feats));
        $return .= '</ausstattung>';
        $return .= '</immobilie>';
        $return .= '<openimmo_anid>CSPP-18</openimmo_anid>';
        $return .= '<firma>Complete Spanish Property</firma>';
    } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));
    $return .= '</anbieter>';
$return .= '</openimmo>';

if ( isset($_GET["dev"]) && $_GET["dev"] == 1)  {
    echo $return;
    exit;
}


$newfile = "openinmo/complete.xml";
$file = fopen ($newfile, "w");
fwrite($file, $return);
fclose ($file);

if (file_exists("442017.zip")) {
    unlink("442017.zip");
}


ini_set("max_execution_time", 0);
$zip = new ZipArchive();
if ($zip->open("442017.zip", ZIPARCHIVE::CREATE) !== TRUE) {
    die ("Could not open archive");
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($_SERVER["DOCUMENT_ROOT"] . '/xml/openinmo/'));

foreach ($iterator as $key=>$value) {

    $filExtens = pathinfo($key, PATHINFO_EXTENSION);

    if ($filExtens == 'xml' || $filExtens == 'jpg' || $filExtens == 'jpeg' || $filExtens == 'gif' || $filExtens == 'JPG' || $filExtens == 'JPEG' || $filExtens == 'GIF' || $filExtens == 'png' || $filExtens == 'PNG') {
        $zip->addFile(realpath($key), str_replace($_SERVER["DOCUMENT_ROOT"] . '/xml/openinmo/', "", $key)) or die ("ERROR: Could not add file: $key");
    }

}

$zip->close();

array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/xml/openinmo/*"));

// if (!isset($_GET['debug_error'])) {
    include "inc/SFTP.php";
    $openinmoFTP = 'ftp.immowelt.net';
    $openinmoFTPuser = 'Complete442017';
    $openinmoFTPpass = 'LdpPp9Df';
    // echo "Vamos a conectar<hr>";
    $ftp = new SFTP($openinmoFTP, $openinmoFTPuser, $openinmoFTPpass);
    if($ftp->connect()) {
        // echo "Conectado<hr>";
        if($ftp->put("442017.zip", "442017.zip", FTP_BINARY)) {
            // echo "Subido";
            array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/xml/*.zip"));
        }
    }
// } else {
    // header('Content-Type: application/zip');
    // header("Content-Disposition: attachment; filename=442017.zip'");
    // header('Content-Length: ' . filesize('442017.zip') . '');
    // header("Location: 442017.zip");
// }

// echo implode(",", ($ids));
mysqli_free_result($rsProperties);
?>
