<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/vendor/autoload.php');

function htmlentitiesOutsideHTMLTags ($htmlText)
{
    $matches = Array();
    $sep = '###HTMLTAG###';

    preg_match_all("@<[^>]*>@", $htmlText, $matches);
    $tmp = preg_replace("@(<[^>]*>)@", $sep, $htmlText);
    $tmp = explode($sep, $tmp);

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

function sendRightmove($strJSON, $strURL, $strCertFile, $strCertPass, $boolDebug = false) {
    $resCurl = curl_init();

    if($boolDebug){
        curl_setopt($resCurl, CURLOPT_VERBOSE, 1);
    }

    curl_setopt($resCurl, CURLOPT_URL, $strURL);
    curl_setopt($resCurl, CURLOPT_CERTINFO, 1);
    curl_setopt($resCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($resCurl, CURLOPT_FAILONERROR, 1);
    curl_setopt($resCurl, CURLOPT_SSLCERT, $strCertFile);
    curl_setopt($resCurl, CURLOPT_SSLCERTTYPE, 'PEM');
    curl_setopt($resCurl, CURLOPT_SSLCERTPASSWD, $strCertPass);
    curl_setopt($resCurl, CURLOPT_POST, 1);
    curl_setopt($resCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($resCurl, CURLOPT_POSTFIELDS, $strJSON);
    $strResponse = curl_exec($resCurl);

    return json_decode($strResponse);
}

$query_rsFotocasaProperty = "

SELECT *
FROM properties_properties
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_rightmove_prop = 1 AND descripcion_en_prop != '' AND export_rightmove_fields_prop != '' AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0


";
$rsFotocasaProperty = mysqli_query($inmoconn, $query_rsFotocasaProperty) or die(mysqli_error());
$row_rsFotocasaProperty = mysqli_fetch_assoc($rsFotocasaProperty);
$totalRows_rsFotocasaProperty = mysqli_num_rows($rsFotocasaProperty);

if ($totalRows_rsFotocasaProperty > 0) {

    do {

        $export_rightmove_fields_prop = json_decode($row_rsFotocasaProperty['export_rightmove_fields_prop'], true);


        $query_rsRMlocs = "SELECT * FROM rightmove_locations WHERE id_rml = '" . $export_rightmove_fields_prop['location'] . "'";
        $rsRMlocs = mysqli_query($inmoconn, $query_rsRMlocs) or die(mysqli_error());
        $row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs);
        $totalRows_rsRMlocs = mysqli_num_rows($rsRMlocs);

        $jsonRightmove = array();

        $jsonRightmove['network']['network_id'] = $rightmoveNetworkId;
        $jsonRightmove['branch']['branch_id'] = $rightmoveBranchId;
        $jsonRightmove['branch']['channel'] = 1;

        $jsonRightmove['property']['agent_ref'] = $row_rsFotocasaProperty['referencia_prop'];
        $jsonRightmove['property']['published'] = true;
        $jsonRightmove['property']['property_type'] = $export_rightmove_fields_prop['type'];
        $jsonRightmove['property']['os_status'] = ($export_rightmove_fields_prop['statuses'] > 0)?(int)$export_rightmove_fields_prop['statuses']:1;

        if ($row_rsFotocasaProperty['operacion_prop'] == $rightmove_ew_build_id) {
            $jsonRightmove['property']['new_home'] = true;
        }
        $jsonRightmove['property']['create_date'] = date('d-m-Y H:i:s', strtotime($row_rsFotocasaProperty['inserted_xml_prop']));
        $jsonRightmove['property']['update_date'] = date('d-m-Y H:i:s', strtotime($row_rsFotocasaProperty['updated_prop']));

        $jsonRightmove['property']['address']['country_code'] = $row_rsRMlocs['loc1_code_rml'];
        $jsonRightmove['property']['address']['region'] = $row_rsRMlocs['loc2_rml'];
        $jsonRightmove['property']['address']['sub_region'] = $row_rsRMlocs['loc3_rml'];
        $jsonRightmove['property']['address']['town_city'] = $row_rsRMlocs['loc4_rml'];

        $latLong = explode(",",$row_rsFotocasaProperty['lat_long_gp_prop']);
        $jsonRightmove['property']['address']['latitude'] = trim($latLong[0]);
        $jsonRightmove['property']['address']['longitude'] = trim($latLong[1]);


        $jsonRightmove['property']['price_information']['price'] = (int)$row_rsFotocasaProperty['preci_reducidoo_prop'];
        $jsonRightmove['property']['price_information']['os_price_qualifier'] = ($export_rightmove_fields_prop['pricequalifiers'] > 0)?(int)$export_rightmove_fields_prop['pricequalifiers']:0;
        if ($row_rsFotocasaProperty['titulo_en_prop'] != '') {
            $jsonRightmove['property']['details']['summary'] = $row_rsFotocasaProperty['titulo_en_prop'];
        } else {
            if ($row_rsFotocasaProperty['descripcion_xml_en_prop'] != '') {
                $jsonRightmove['property']['details']['summary'] = substr(strip_tags($row_rsFotocasaProperty['descripcion_xml_en_prop']), 0, 300)."...";
            } else {
                $jsonRightmove['property']['details']['summary'] = substr(strip_tags($row_rsFotocasaProperty['descripcion_en_prop']), 0, 300)."...";
            }
        }
        if ($row_rsFotocasaProperty['descripcion_xml_en_prop'] != '') {
            $jsonRightmove['property']['details']['description'] =  strip_tags($row_rsFotocasaProperty['descripcion_xml_en_prop']);
        } else {
            $jsonRightmove['property']['details']['description'] =  strip_tags($row_rsFotocasaProperty['descripcion_en_prop']);
        }

        $query_rsFotocasaProperty_features = "
        SELECT features.feature_en_feat,
                properties_features.feature_en_feat as parfeat
            FROM properties_property_feature INNER JOIN properties_features features ON properties_property_feature.feature = features.id_feat
                 LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
            WHERE properties_property_feature.property = '".$row_rsFotocasaProperty['id_prop']."'

            UNION


        SELECT features.feature_en_feat,
                properties_features_priv.feature_en_feat as parfeat
            FROM properties_property_feature_priv INNER JOIN properties_features_priv features ON properties_property_feature_priv.feature = features.id_feat
                 LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
            WHERE properties_property_feature_priv.property = '".$row_rsFotocasaProperty['id_prop']."'

            LIMIT 10
        ";
        $rsFotocasaProperty_features = mysqli_query($inmoconn, $query_rsFotocasaProperty_features) or die(mysqli_error());
        $row_rsFotocasaProperty_features = mysqli_fetch_assoc($rsFotocasaProperty_features);
        $totalRows_rsFotocasaProperty_features = mysqli_num_rows($rsFotocasaProperty_features);
        if($totalRows_rsFotocasaProperty_features > 0) {
            do {
                if($row_rsFotocasaProperty_features['parfeat'] != '' || $row_rsFotocasaProperty_features['feature_en_feat'] != '') {
                    if ($row_rsFotocasaProperty_features['parfeat'] == null) {
                        $jsonRightmove['property']['details']['features'][] = strip_tags(preg_replace('/&/', '&amp;', $row_rsFotocasaProperty_features['feature_en_feat']));
                    } else {
                        $jsonRightmove['property']['details']['features'][] = strip_tags(preg_replace('/&/', '&amp;', $row_rsFotocasaProperty_features['parfeat']));
                    }

                }
            } while ($row_rsFotocasaProperty_features = mysqli_fetch_assoc($rsFotocasaProperty_features));
        }
        $jsonRightmove['property']['details']['bedrooms'] = ((int)$row_rsFotocasaProperty['habitaciones_prop'] > 0)?(int)$row_rsFotocasaProperty['habitaciones_prop']:0;
        if ((int)$row_rsFotocasaProperty['aseos_prop'] > 0) {
            $jsonRightmove['property']['details']['bathrooms'] = (int)$row_rsFotocasaProperty['aseos_prop'];
        }
        if ((int)$row_rsFotocasaProperty['construccion_prop'] > 0) {
            $jsonRightmove['property']['details']['year_built'] = (int)$row_rsFotocasaProperty['construccion_prop'];
        }
        if ((int)$row_rsFotocasaProperty['m2_prop'] > 0) {
            $jsonRightmove['property']['details']['internal_area'] = (int)$row_rsFotocasaProperty['m2_prop'];
            $jsonRightmove['property']['details']['internal_area_unit'] = ($export_rightmove_fields_prop['dimensionunits'] > 0)?(int)$export_rightmove_fields_prop['dimensionunits']:2;
        }
        if ((int)$row_rsFotocasaProperty['m2_parcela_prop'] > 0) {
            $jsonRightmove['property']['details']['land_area'] = (int)$row_rsFotocasaProperty['m2_parcela_prop'];
            $jsonRightmove['property']['details']['land_area_unit'] = ($export_rightmove_fields_prop['areaunits'] > 0)?(int)$export_rightmove_fields_prop['areaunits']:2;
        }
        if ((int)$export_rightmove_fields_prop['entrancefloors'] > 0) {
            $jsonRightmove['property']['details']['entrance_floor'] = (int)$export_rightmove_fields_prop['entrancefloors'];
        }
        if ((int)$export_rightmove_fields_prop['conditions'] > 0) {
            $jsonRightmove['property']['details']['condition'] = (int)$export_rightmove_fields_prop['conditions'];
        }
        foreach ($export_rightmove_fields_prop['accessibilites'] as $value) {
            $jsonRightmove['property']['details']['accessibilites'][] =  $value;
        }
        if ((int)$row_rsFotocasaProperty['piscina_prop'] == 1) {
            $jsonRightmove['property']['details']['private_pool'] = true;
        }
        if ((int)$row_rsFotocasaProperty['piscina_prop'] == 2) {
            $jsonRightmove['property']['details']['communal_pool'] = true;
        }
        if ((int)$export_rightmove_fields_prop['commercialuseclasses'] > 0) {
            $jsonRightmove['property']['details']['comm_use_class1'] = (int)$export_rightmove_fields_prop['commercialuseclasses'];
        }

        foreach ($export_rightmove_fields_prop['checkboxes'] as $key => $value) {
            if ($value == 1) {
                $jsonRightmove['property']['details'][$key] = true;
            }
        }


        $query_rsImages = "SELECT id_img, image_img FROM properties_images WHERE property_img = '".$row_rsFotocasaProperty['id_prop']."' ORDER BY order_img";
        $rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
        $row_rsImages = mysqli_fetch_assoc($rsImages);
        $totalRows_rsImages = mysqli_num_rows($rsImages);
        $x = 0;
        do {
            $jsonRightmove['property']['media'][$x]['media_type'] = 1;
            if (preg_match('/https?:\/\//', $row_rsImages['image_img'])) {
                $jsonRightmove['property']['media'][$x]['media_url'] = $row_rsImages['image_img'];
            } else {
                $jsonRightmove['property']['media'][$x]['media_url'] = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/properties/' . $row_rsImages['image_img'];
            }
            $jsonRightmove['property']['media'][$x]['sort_order'] = $x + 1;
            $x++;
        } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));


        $query_rsImages = "SELECT * FROM properties_planos WHERE property_img = '".$row_rsFotocasaProperty['id_prop']."' ORDER BY order_img";
        $rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
        $row_rsImages = mysqli_fetch_assoc($rsImages);
        $totalRows_rsImages = mysqli_num_rows($rsImages);

        do {
            if ($row_rsImages['image_img'] != '') {

                $jsonRightmove['property']['media'][$x]['media_type'] = 2;
                if (preg_match('/https?:\/\//', $row_rsImages['image_img'])) {
                    $jsonRightmove['property']['media'][$x]['media_url'] = $row_rsImages['image_img'];
                } else {
                    $jsonRightmove['property']['media'][$x]['media_url'] = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/propertiesplanos/' . $row_rsImages['image_img'];
                }
                $jsonRightmove['property']['media'][$x]['sort_order'] = $x + 1;
                $x++;
            }
        } while ($row_rsImages  = mysqli_fetch_assoc($rsImages));


        $query_rsVideos = "SELECT * FROM properties_360 WHERE property_360 = '".$row_rsFotocasaProperty['id_prop']."' ORDER BY order_360 LIMIT 1";
        $rsVideos = mysqli_query($inmoconn, $query_rsVideos) or die(mysqli_error());
        $row_rsVideos = mysqli_fetch_assoc($rsVideos);
        $totalRows_rsVideos = mysqli_num_rows($rsVideos);

        do {
            if ($row_rsVideos['image_img'] != '') {

                $jsonRightmove['property']['media'][$x]['media_type'] = 4;
                $jsonRightmove['property']['media'][$x]['media_url'] = get_string_between($row_rsVideos['video_360'], 'src="', '"');
                $jsonRightmove['property']['media'][$x]['sort_order'] = $x + 1;
                $x++;
            }
        } while ($row_rsVideos  = mysqli_fetch_assoc($rsVideos));

        $jsonRightmove['principal']['principal_email_address'] = $fromMail;
        $jsonRightmove['property']['auto_email_when_live'] = false;
        $jsonRightmove['property']['auto_email_updates'] = false;

        $json = json_encode($jsonRightmove);

        // echo $json  . "<hr>";

        $result =  sendRightmove($json, 'https://adfapi.rightmove.co.uk/v1/property/overseassendpropertydetails', $rightmove_cert, $rightmove_cert_password, false);

        echo "<b>" . $row_rsFotocasaProperty['referencia_prop'] . "</b><br>";
        echo "<pre>";
        // echo json_encode($jsonRightmove, JSON_PRETTY_PRINT);
        print_r($result);
        echo "</pre>";
        echo "<hr>";

    } while ($row_rsFotocasaProperty = mysqli_fetch_assoc($rsFotocasaProperty));

}