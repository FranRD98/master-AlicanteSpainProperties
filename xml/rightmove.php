<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/phpthumb/ThumbLib.inc.php');
function htmlentitiesOutsideHTMLTags ($htmlText)
{
    $matches = Array();
    $sep = '###HTMLTAG###';

    preg_match_all("@<[^>]*>@", $htmlText, $matches);
    $tmp = preg_replace("@(<[^>]*>)@", $sep, $htmlText);
    if(isset($tmp))
        $tmp = explode($sep, $tmp);
    else
        $tmp = aaray();
    
    for ($i=0; $i<count($tmp); $i++)
        $tmp[$i] = htmlentities($tmp[$i]);

    $tmp = join($sep, $tmp);

    for ($i=0; $i<count($matches[0]); $i++)
        $tmp = preg_replace("@$sep@", $matches[0][$i], $tmp, 1);

    return $tmp;
}
function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return '';
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function AddWatermarkImage($image, $imgName)
{
    $image = preg_replace('/\?.*/', '', $image);

    $pathInfo = pathinfo($image);
    $path = '/media/images/properties/';
    $paths['filePath'] = $pathInfo['dirname'];
    $paths['fileExt'] = $pathInfo['extension'];
    $paths['fileBasename'] = $pathInfo['filename'] ? $pathInfo['filename'] : substr($fileName, 0, strrpos($fileName, '.'));
    $paths['fileSrc'] = $path . '' . $fileName;
    $paths['cachePath'] = '/xml/rightmove/';
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

SELECT properties_properties.*,
    rightmove_locations.id_rml,
    rightmove_locations.loc1_code_rml,
    rightmove_locations.loc1_rml,
    rightmove_locations.loc2_rml,
    rightmove_locations.loc3_rml,
    rightmove_locations.loc4_rml,
    rightmove_tipos.id_rmt,
    rightmove_tipos.tipo_rmt,
    properties_status.id_sta,
    lat_long_gp_prop,
    properties_status.status_en_sta
FROM properties_properties LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
     LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
     LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_rightmove_prop = 1 AND descripcion_en_prop != '' AND rightmove_tipo_prop != '' AND id_rml != '' AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0

LIMIT " . $rightmoveLimit . "

";
$rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

if ($totalRows_rsProperties > 0) {
    $return = '';


    $return .=  "#HEADER#\n";
    $return .=  "VERSION : 3i\n";
    $return .=  "EOF : '|'\n";
    $return .=  "EOR : '~'\n\n";

    $return .=  "#DEFINITION#\n";
    $return .=  "AGENT_REF|HOUSE_NAME_NUMBER|STREET_NAME|OS_TOWN_CITY|OS_REGION|ZIPCODE|COUNTRY_CODE|FEATURE1|FEATURE2|FEATURE3|FEATURE4|FEATURE5|FEATURE6|FEATURE7|FEATURE8|FEATURE9|FEATURE10|EXACT_LATITUDE|EXACT_LONGITUDE|SUMMARY|DESCRIPTION|CREATE_DATE|UPDATE_DATE|BRANCH_ID|STATUS_ID|BEDROOMS|PRICE|PRICE_QUALIFIER|NEW_HOME_FLAG|PROP_SUB_ID|DISPLAY_ADDRESS|PUBLISHED_FLAG|TRANS_TYPE_ID|MEDIA_IMAGE_00|MEDIA_IMAGE_01|MEDIA_IMAGE_02|MEDIA_IMAGE_03|MEDIA_IMAGE_04|MEDIA_IMAGE_05|MEDIA_IMAGE_06|MEDIA_IMAGE_07|MEDIA_IMAGE_08|MEDIA_IMAGE_09|MEDIA_IMAGE_10|MEDIA_IMAGE_11|MEDIA_IMAGE_12|MEDIA_IMAGE_13|MEDIA_IMAGE_14|MEDIA_IMAGE_15|MEDIA_IMAGE_16|MEDIA_IMAGE_17|MEDIA_IMAGE_18|MEDIA_IMAGE_19|MEDIA_IMAGE_20|MEDIA_IMAGE_21|MEDIA_IMAGE_22|MEDIA_IMAGE_23|MEDIA_IMAGE_24|MEDIA_IMAGE_25|MEDIA_IMAGE_26|MEDIA_IMAGE_27|MEDIA_IMAGE_28|MEDIA_IMAGE_29|MEDIA_IMAGE_30|MEDIA_IMAGE_31|MEDIA_IMAGE_32|MEDIA_IMAGE_33|MEDIA_IMAGE_34|MEDIA_IMAGE_35|MEDIA_IMAGE_36|MEDIA_IMAGE_37|MEDIA_IMAGE_38|MEDIA_IMAGE_39|MEDIA_FLOOR_PLAN_00|MEDIA_FLOOR_PLAN_01|MEDIA_FLOOR_PLAN_02|MEDIA_FLOOR_PLAN_03|MEDIA_FLOOR_PLAN_04|MEDIA_FLOOR_PLAN_05|MEDIA_FLOOR_PLAN_06|MEDIA_FLOOR_PLAN_07|MEDIA_FLOOR_PLAN_08|MEDIA_FLOOR_PLAN_09|MEDIA_VIRTUAL_TOUR_00|~\n\n";

    $return .=  "#DATA#\n";


    do {
        set_time_limit(0);
        $latlong = array();
        if(isset($row_rsProperties['lat_long_gp_prop']))
            $latlong = explode(',', $row_rsProperties['lat_long_gp_prop']);

        if ($row_rsProperties['direccion_prop']) {
            $calle = $row_rsProperties['direccion_prop'];
        } else {
            $calle = $row_rsProperties['loc4_rml'].' '.$row_rsProperties['loc2_rml'];
        } ;

        $return .= $rightmoveBranchId . '_' . str_replace(['.', ' ', '/'], '', $row_rsProperties['referencia_prop']). '|';  // Número de agente AGENT_REF
$return .= str_replace(['.', ' '], '', $row_rsProperties['referencia_prop']). '|'; // Referencia debe ser el nombre de la casa HOUSE_NAME_NUMBER
$return .= substr($calle, 0, 100) . '|'; // Calle STREET_NAME
$return .= $row_rsProperties['loc4_rml'] . '|'; // Ciudad OS_TOWN_CITY
$return .= $row_rsProperties['loc2_rml'] . '|'; // Región OS_REGION
$return .= '|'; // Zipcode ZIPCODE
$return .= $row_rsProperties['loc1_code_rml'] . '|'; // Código país COUNTRY_CODE

        $query_rsproperties_features = "SELECT features.feature_en_feat FROM properties_property_feature INNER JOIN properties_features features ON properties_property_feature.feature = features.id_feat LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
WHERE properties_property_feature.property = '".$row_rsProperties['id_prop']."' LIMIT 10";
        $rsproperties_features = mysqli_query($inmoconn,$query_rsproperties_features) or die(mysqli_error());
        $row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
        $totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);
        if ($totalRows_rsproperties_features > 0) {
            do {
                $return .= $row_rsproperties_features['feature_en_feat'] . '|'; // Feature
            } while ($row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features));
        }
        $numFeat =  10 - $totalRows_rsproperties_features;
        if ($numFeat > 0) {
            for ($i=1; $i <= $numFeat; $i++) {
                $return .= '|'; // Feature FEATURE1
            }
        }

        $return .=  $latlong[0] . '|'; // Latitud EXACT_LATITUDE
$return .=  $latlong[1] . '|'; // Longitud EXACT_LONGITUDE

$return .= mysqli_real_escape_string($inmoconn,htmlentities(htmlentities(trim(str_replace(array("\r\n", "˚"), " ", preg_replace('/((\b\w+\b.*?){30}).*$/s','$1',strip_tags($row_rsProperties['descripcion_en_prop']))))))).'|'; // Sumario SUMMARY
$return .= mysqli_real_escape_string($inmoconn,str_replace(array("\r\n", "\r", "˚"), " ", $row_rsProperties['descripcion_en_prop']))  . '|'; // Descripción DESCRIPTION
$return .= '|'; // Creado CREATE_DATE $row_rsProperties['inserted_xml_prop'] .
$return .= '|'; // Actualizado UPDATE_DATE $row_rsProperties['updated_prop'] .
$return .= $rightmoveBranchId . '|'; // Branch ID BRANCH_ID
$return .= '0|'; // Status STATUS_ID
$return .= $row_rsProperties['habitaciones_prop'] . '|'; // Habitaciones BEDROOMS
$return .= $row_rsProperties['preci_reducidoo_prop'] . '|'; // Precio PRICE
$return .= '0|'; // precio Qualifier PRICE_QUALIFIER
if ($row_rsProperties['operacion_prop'] == '2') {
    $return .= 'Y|'; // Obra nueva NEW_HOME_FLAG
} else {
    $return .= '|'; // Obra nueva NEW_HOME_FLAG
}
        $return .= $row_rsProperties['rightmove_tipo_prop'] . '|'; // Tipo PROP_SUB_ID
$return .= $row_rsProperties['loc4_rml'] . '|'; // Mostrar dirección DISPLAY_ADDRESS
$return .= '1|'; // Publicar PUBLISHED_FLAG
// $return .= '1|'; // Estatus
$return .= '1|'; // TRANS_TYPE_ID


        $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 40";
        $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
        $row_rsImages = mysqli_fetch_assoc($rsImages);
        $totalRows_rsImages = mysqli_num_rows($rsImages);

        $x = 0;
        do {
            set_time_limit(0);
            if ($x < 10) {
                $num = '0' . $x;
            } else {
                $num = $x;
            }

            $ext = pathinfo($row_rsImages['image_img'], PATHINFO_EXTENSION);

            $imgName = $rightmoveBranchId . '_' . str_replace(['.', ' ', '-'], '', $row_rsProperties['referencia_prop']). '_IMG_' . $num . '.' . $ext;

            if ($row_rsImages['image_img'] != 'Array' && $row_rsImages['image_img'] != '') {
                if (preg_match('/https?:\/\//', $row_rsImages['image_img'])) { //COGER LAS IMÁGENES DE PROPIEDADES IMPORTADAS

                    if ($row_rsProperties['exportado_rightmove_prop'] == 0) {
                        $remote_file_contents = file_get_contents($row_rsImages['image_img']);

                        $local_file_path = $_SERVER["DOCUMENT_ROOT"] . '/xml/rightmove/' . $imgName;

                        file_put_contents($local_file_path, $remote_file_contents);
                    }
                } else {
                    if ($row_rsProperties['exportado_rightmove_prop'] == 0) {
                        AddWatermarkImage($row_rsImages['image_img'], $imgName);
                    }
                }
            }

            $return .= $imgName . '|'; // imagen
            $x++;
        } while ($row_rsImages  = mysqli_fetch_assoc($rsImages));

        $resto = 40-$totalRows_rsImages;
        $k = 1;
        while ($k <= $resto) {
            $return .= "|";
            $k++;
        }


        // Planos
        
        $query_rsImages = "SELECT * FROM properties_planos WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 10";
        $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
        $row_rsImages = mysqli_fetch_assoc($rsImages);
        $totalRows_rsImages = mysqli_num_rows($rsImages);

        $x = 0;
        do {
            if ($row_rsImages['image_img'] != '') {
                        set_time_limit(0);
                        if ($x < 10) {
                            $num = '0' . $x;
                        } else {
                            $num = $x;
                        }

                        $ext = pathinfo($row_rsImages['image_img'], PATHINFO_EXTENSION);

                        $imgName = $rightmoveBranchId . '_' . str_replace(['.', ' ', '-'], '', $row_rsProperties['referencia_prop']). '_FLP_' . $num . '.' . $ext;

                        if (preg_match('/https?:\/\//', $row_rsImages['image_img'])) { //COGER LAS IMÁGENES DE PROPIEDADES IMPORTADAS
                            $remote_file_contents = file_get_contents($row_rsImages['image_img']);

                            $local_file_path = $_SERVER["DOCUMENT_ROOT"] . '/xml/rightmove/' . $imgName;

                            file_put_contents($local_file_path, $remote_file_contents);
                        } else {
                            copy($_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesplanos/' . $row_rsImages['image_img'], $_SERVER["DOCUMENT_ROOT"] . '/xml/rightmove/' . $imgName);
                        }

                        $return .= $imgName . '|'; // imagen
                        // $return .= $row_rsImages['alt_en_img'] . '|'; // Alt
                        $x++;
                        }
        } while ($row_rsImages  = mysqli_fetch_assoc($rsImages));

        $resto = 10-$totalRows_rsImages;
        $k = 1;
        while ($k <= $resto) {
            $return .= "|";
            $k++;
        }

        
        $query_rsVideos = "SELECT * FROM properties_videos WHERE property_vid = '".$row_rsProperties['id_prop']."' ORDER BY order_vid LIMIT 1";
        $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
        $row_rsVideos = mysqli_fetch_assoc($rsVideos);
        $totalRows_rsVideos = mysqli_num_rows($rsVideos);
        $return .= get_string_between($row_rsVideos['video_vid'], 'src="', '"') . '|'; // IGNORAR MEDIA_IMAGE_00
        $return .= "~\n";

        
        $query_rsImagenes = "UPDATE `properties_properties` SET `exportado_rightmove_prop` = '1' WHERE `id_prop` = ".$row_rsProperties['id_prop']." LIMIT 1;";
        $rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
    } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));

    $return .=  "#END#\n";

    $newfile = "rightmove/".$rightmoveBranchId.".blm";
    $file = fopen($newfile, "w");
    fwrite($file, iconv("UTF-8", "Windows-1252//IGNORE", $return));
    fclose($file);

    if (file_exists($rightmoveBranchId.".zip")) {
        unlink($rightmoveBranchId.".zip");
    }

    ini_set("max_execution_time", 0);
    $zip = new ZipArchive();
    if ($zip->open($rightmoveBranchId."_".date("Y")."".date("m")."".date("d")."01.zip", ZIPARCHIVE::CREATE) !== true) {
        die("Could not open archive");
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($_SERVER["DOCUMENT_ROOT"] . '/xml/rightmove/'));

    foreach ($iterator as $key => $value) {
        $filExtens = pathinfo($key, PATHINFO_EXTENSION);

        if ($filExtens == 'blm' || $filExtens == 'jpg' || $filExtens == 'jpeg' || $filExtens == 'gif' || $filExtens == 'JPG' || $filExtens == 'JPEG' || $filExtens == 'GIF' || $filExtens == 'png' || $filExtens == 'PNG') {
            $zip->addFile(realpath($key), str_replace($_SERVER["DOCUMENT_ROOT"] . '/xml/rightmove/', "", $key)) or die("ERROR: Could not add file: $key");
        }
    }

    $zip->close();

    array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/xml/rightmove/*"));

    if (!isset($_GET['debug_error'])) {
        include "inc/SFTP.php";
        $ftp = new SFTP($rightmoveFTP, $rightmoveFTPuser, $rightmoveFTPpass);
        if ($ftp->connect()) {
            $ftp->cd('live/upload');
            if ($ftp->put($rightmoveBranchId."_".date("Y")."".date("m")."".date("d")."01.zip", $rightmoveBranchId."_".date("Y")."".date("m")."".date("d")."01.zip")) {
                array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/xml/*.zip"));
            }
        }
    } else {
        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename=$rightmoveBranchId.'_".date("Y")."".date("m")."".date("d")."01.zip'");
        header('Content-Length: ' . filesize($zipname));
        header("Location: ".$rightmoveBranchId."_".date("Y")."".date("m")."".date("d")."01.zip");
    }
} // End if ($totalRows_rsProperties > 0) {


mysqli_free_result($rsProperties);

die();
