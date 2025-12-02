<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Cargamos la conexión a MySql
include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

function rip_tags($string)
{
    $string = preg_replace('/<[^>]*>/', ' ', $string);
    $string = str_replace("\r", '', $string);    // --- replace with empty space
    $string = str_replace("\n", ' ', $string);   // --- replace with space
    $string = str_replace("\t", ' ', $string);   // --- replace with space
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
    return $string;
}

function toSlug($string)
{
    if (function_exists('iconv')) {
        $string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    }
    $string = preg_replace("/[^a-zA-Z0-9 -]/", "", $string);
    $string = strtolower($string);
    $string = str_replace(" ", "-", $string);
    return str_replace('--', '-', $string);
}

$query_idealistaCheck = "

SELECT

    properties_properties.id_prop

    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        INNER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
        INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND idealista_prop = 1 AND

    properties_properties.vendido_prop = 0 AND
    properties_properties.vendido_tag_prop = 0 AND
    properties_properties.reservado_prop = 0 AND
    properties_properties.alquilado_prop = 0 AND
    properties_properties.force_hide_prop != 1 AND
    properties_properties.exportado_idealista_prop = 0

AND (descripcion_en_prop != '' OR descripcion_de_prop != '' OR descripcion_fr_prop != '' OR descripcion_ru_prop != '' OR descripcion_se_prop != '' OR descripcion_nl_prop != '' OR descripcion_es_prop != '')


 GROUP BY properties_properties.id_prop
";
$idealistaCheck = mysqli_query($inmoconn,$query_idealistaCheck) or die(mysqli_error());
$row_idealistaCheck = mysqli_fetch_assoc($idealistaCheck);
$totalRows_idealistaCheck = mysqli_num_rows($idealistaCheck);

if ($totalRows_idealistaCheck  == 0) {
    die();
}

$query_idealista = "

SELECT

    properties_properties.id_prop,
    properties_properties.referencia_prop,
    properties_properties.preci_reducidoo_prop,
    properties_properties.gastos_prop,
    properties_status.id_sta,
    properties_properties.direccion_prop,
    plantas_prop,
    name_en_loc1,
    CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS pararea,
    properties_properties.lat_long_gp_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != '' THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_en_prop != '' THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != '' THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != '' THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != '' THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    CASE WHEN properties_properties.descripcion_xml_se_prop != '' THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != '' THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    types.types_en_typ,
    types.id_typ,
    properties_status.status_en_sta,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS partown,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.construccion_prop,
    properties_properties.orientacion_prop,
    properties_properties.piscina_prop,
    properties_properties.tipo_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.energia_prop,
    properties_properties.updated_prop,
    properties_types.types_en_typ as partyp,
    towns.name_en_loc4,
    operacion_prop,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province,
    areas1.name_en_loc3,
    areas1.id_loc3,
    properties_loc3.id_loc3,
    idealista_fields_prop

    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        INNER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
        INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND idealista_prop = 1 AND

    properties_properties.vendido_prop = 0 AND
    properties_properties.vendido_tag_prop = 0 AND
    properties_properties.reservado_prop = 0 AND
    properties_properties.alquilado_prop = 0 AND
    properties_properties.force_hide_prop != 1

AND (descripcion_en_prop != '' OR descripcion_de_prop != '' OR descripcion_fr_prop != '' OR descripcion_ru_prop != '' OR descripcion_se_prop != '' OR descripcion_nl_prop != '' OR descripcion_es_prop != '')


 GROUP BY properties_properties.id_prop
";
$idealista = mysqli_query($inmoconn,$query_idealista) or die(mysqli_error());
$row_idealista = mysqli_fetch_assoc($idealista);
$totalRows_idealista = mysqli_num_rows($idealista);

$n = 1;
$n2 = 1;

header("Content-type: application/json; charset=utf-8");
$Content .= '{';
if ($totalRows_idealista > 0 || $totalRows_idealistaNB > 0) {
    $Content .= '"customerCountry": "' . $idealistaCustomerCountry . '",';
    $Content .= '"customerCode": "' . $idealistaCustomerCode . '",';
    $Content .= '"customerReference": "' . $idealistaCustomerReference . '",';
    $Content .= '"customerSendDate": "' . date("Y/m/d H:i:s") . '",';
    $Content .= '"customerContact":';
    $Content .= '{';
    $Content .= '"contactEmail": "' . $idealistaContactEmail . '",';
    $Content .= '"contactPrimaryPhonePrefix": "' . $idealistaContactPrimaryPhonePrefix . '",';
    $Content .= '"contactPrimaryPhoneNumber": "' . $idealistaContactPrimaryPhoneNumber . '"';
    if ($idealistaContactSecondaryPhonePrefix != '') {
        $Content .= ',"contactSecondaryPhonePrefix": "' . $idealistaContactSecondaryPhonePrefix . '",';
    }
    if ($idealistaContactSecondaryPhoneNumber != '') {
        $Content .= '"contactSecondaryPhoneNumber": "' . $idealistaContactSecondaryPhoneNumber . '"';
    }
    $Content .= '},';
    if ($totalRows_idealista > 0) {
        $Content .= '"customerProperties": [';
        do {
                $fieldsJSN = json_decode($row_idealista['idealista_fields_prop']);
            if (
                (($fieldsJSN->featuresType != 'land' && $fieldsJSN->featuresType != 'garage' && $fieldsJSN->featuresType != 'land_urban' && $fieldsJSN->featuresType != 'land_countrybuildable' && $fieldsJSN->featuresType != 'land_countrynonbuildable')  )
                ||

                (($fieldsJSN->featuresType == 'land' || $fieldsJSN->featuresType == 'garage' || $fieldsJSN->featuresType == 'land_urban' || $fieldsJSN->featuresType == 'land_countrybuildable' || $fieldsJSN->featuresType == 'land_countrynonbuildable') && $row_idealista['m2_parcela_prop'] > 0 )
            ) {

                if ($fieldsJSN->operationType  != '') {
                    if ($fieldsJSN->IsNewConstruction != 1) {
                        if ($n++ > 1) {
                            $Content .= ',';
                        }
                        $lat = array();
                        $lat1 = '';
                        $lat2 = '';
                        if(isset($row_idealista['lat_long_gp_prop'])){
                            $lat = explode(',', $row_idealista['lat_long_gp_prop']);
                            $lat1 = str_replace(' ', '', $lat[0]);
                            $lat2 = str_replace(' ', '', $lat[1]);
                        }

                        switch ($row_idealista['orientacion_prop']) {
                            case 'o-n':
                                $orientacion = ['false', 'false', 'true', 'false'];
                            break;
                            case 'o-ne':
                                $orientacion = ['true', 'false', 'true', 'false'];
                            break;
                            case 'o-e':
                                $orientacion = ['true', 'true', 'false', 'false'];
                            break;
                            case 'o-se':
                                $orientacion = ['true', 'false', 'false', 'true'];
                            break;
                            case 'o-s':
                                $orientacion = ['false', 'false', 'false', 'true'];
                            break;
                            case 'o-so':
                                $orientacion = ['false', 'true', 'false', 'true'];
                            break;
                            case 'o-o':
                                $orientacion = ['false', 'true', 'false', 'false'];
                            break;
                            case 'o-no':
                                $orientacion = ['false', 'true', 'true', 'false'];
                            break;
                            default:
                                $orientacion = ['false', 'false', 'false', 'false'];
                            break;
                        }

                        $Content .= '{';
                        $Content .= '"propertyCode": "' . $row_idealista['id_prop'] . '",';
                        $Content .= '"propertyReference": "' . $row_idealista['referencia_prop'] . '",';
                        $Content .= '"propertyOperation":';
                        $Content .= '{';
                        $Content .= '"operationType": "' . $fieldsJSN->operationType . '",';
                        if ((int)$row_idealista['preci_reducidoo_prop'] > 0) {
                            $Content .= '"operationPrice": ' . (int)$row_idealista['preci_reducidoo_prop'] . '';
                        } else {
                            $Content .= '"operationPrice": 1, ';
                            $Content .= '"ShowPrice": false';
                        }
                        if ($row_idealista['gastos_prop'] > 0) {
                            $Content .= ',"operationPriceCommunity": "' .  (int)($row_idealista['gastos_prop']) . '"';
                        }
                        $Content .= '},';
                        $Content .= '"propertyContact":';
                        $Content .= '{';
                        $Content .= '"contactEmail": "' . $idealistaContactEmail . '",';
                        $Content .= '"contactPrimaryPhonePrefix": "' . $idealistaContactPrimaryPhonePrefix . '",';
                        $Content .= '"contactPrimaryPhoneNumber": "' . $idealistaContactPrimaryPhoneNumber . '"';
                        if ($idealistaContactSecondaryPhonePrefix != '') {
                            $Content .= ',"contactSecondaryPhonePrefix": "' . $idealistaContactSecondaryPhonePrefix . '"';
                        }
                        if ($idealistaContactSecondaryPhoneNumber != '') {
                            $Content .= ',"contactSecondaryPhoneNumber": "' . $idealistaContactSecondaryPhoneNumber . '"';
                        }
                        $Content .= '},';
                        $Content .= '"propertyAddress":';
                        $Content .= '{';
                        $Content .= '"addressVisibility": "hidden",';
                        $Content .= '"addressStreetName": "' . $fieldsJSN->addressCalle . '",';
                        $Content .= '"addressStreetNumber": "' . $fieldsJSN->addressNumero . '",';
                        if ($fieldsJSN->addressPlanta  > 0) {
                            $Content .= '"addressFloor": "' . $fieldsJSN->addressPlanta . '",';
                        } else {
                            // $Content .= '"addressFloor": "bj",';
                        }
                        $Content .= '"addressPostalCode": "' . $fieldsJSN->addressPostalCode . '",';
                        $Content .= '"addressTown": "' . $fieldsJSN->addressLocalidad . '",';
                        $Content .= '"addressCountry": "Spain"';
                        if ($lat1 != '' && $lat2 != '') {
                            $Content .= ', ';
                            $Content .= '"addressCoordinatesPrecision": "moved",';
                            $Content .= '"addressCoordinatesLatitude": ' . $lat1 . ',';
                            $Content .= '"addressCoordinatesLongitude": ' . $lat2 . '';
                        }
                        $Content .= '},';
                        $foundDesc = 0;
                        $Content .= '"propertyDescriptions": [';
                        if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', (string)$row_idealista['descripcion_es_prop']))))))))) != '') {
                            $Content .= '{';
                            $Content .= '"descriptionLanguage": "spanish",';
                            $Content .= '"descriptionText": "' . str_replace(array("\r\n", "\r", "\n"), "", rip_tags(str_replace('"', '&quot;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' \n', nl2br((string)$row_idealista['descripcion_es_prop'])))))))))) . '"';
                            $Content .= '}';
                            $foundDesc = 1;
                        }
                        if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', (string)$row_idealista['descripcion_en_prop']))))))))) != '') {
                            if ($foundDesc == 1) {
                                $Content .= ',';
                            } else {
                                $foundDesc = 1;
                            }
                            $Content .= '{';
                            $Content .= '"descriptionLanguage": "english",';
                            $Content .= '"descriptionText": "' . str_replace(array("\r\n", "\r", "\n"), "", rip_tags(str_replace('"', '&quot;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' \n', nl2br((string)$row_idealista['descripcion_en_prop'])))))))))) . '"';
                            $Content .= '}';
                        }
                        if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', (string)$row_idealista['descripcion_de_prop']))))))))) != '') {
                            if ($foundDesc == 1) {
                                $Content .= ',';
                            } else {
                                $foundDesc = 1;
                            }
                            $Content .= '{';
                            $Content .= '"descriptionLanguage": "german",';
                            $Content .= '"descriptionText": "' . str_replace(array("\r\n", "\r", "\n"), "", rip_tags(str_replace('"', '&quot;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' \n', nl2br((string)$row_idealista['descripcion_de_prop'])))))))))) . '"';
                            $Content .= '}';
                        }
                        if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', (string)$row_idealista['descripcion_fr_prop']))))))))) != '') {
                            if ($foundDesc == 1) {
                                $Content .= ',';
                            } else {
                                $foundDesc = 1;
                            }
                            $Content .= '{';
                            $Content .= '"descriptionLanguage": "french",';
                            $Content .= '"descriptionText": "' . str_replace(array("\r\n", "\r", "\n"), "", rip_tags(str_replace('"', '&quot;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' \n', nl2br((string)$row_idealista['descripcion_fr_prop'])))))))))) . '"';
                            $Content .= '}';
                        }
                        if ((rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', (string)$row_idealista['descripcion_ru_prop'])))))))))) != '') {
                            if ($foundDesc == 1) {
                                $Content .= ',';
                            } else {
                                $foundDesc = 1;
                            }
                            $Content .= '{';
                            $Content .= '"descriptionLanguage": "russian",';
                            $Content .= '"descriptionText": "' . str_replace(array("\r\n", "\r", "\n"), "", rip_tags(str_replace('"', '&quot;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' \n', nl2br((string)$row_idealista['descripcion_ru_prop'])))))))))) . '"';
                            $Content .= '}';
                        }
                        if ((rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', (string)$row_idealista['descripcion_se_prop'])))))))))) != '') {
                            if ($foundDesc == 1) {
                                $Content .= ',';
                            } else {
                                $foundDesc = 1;
                            }
                            $Content .= '{';
                            $Content .= '"descriptionLanguage": "swedish",';
                            $Content .= '"descriptionText": "' . str_replace(array("\r\n", "\r", "\n"), "", rip_tags(str_replace('"', '&quot;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' \n', nl2br((string)$row_idealista['descripcion_se_prop'])))))))))) . '"';
                            $Content .= '}';
                        }
                        if ((rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', (string)$row_idealista['descripcion_nl_prop'])))))))))) != '') {
                            if ($foundDesc == 1) {
                                $Content .= ',';
                            } else {
                                $foundDesc = 1;
                            }
                            $Content .= '{';
                            $Content .= '"descriptionLanguage": "dutch",';
                            $Content .= '"descriptionText": "' . str_replace(array("\r\n", "\r", "\n"), "", rip_tags(str_replace('"', '&quot;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' \n', nl2br((string)$row_idealista['descripcion_nl_prop'])))))))))) . '"';
                            $Content .= '}';
                        }
                        $Content .= '],';
                        $Content .= '"propertyImages": [';
                        $i=1;
                        
                        $query_idealista_galeria = "SELECT properties_images.image_img FROM properties_images WHERE properties_images.property_img=".$row_idealista['id_prop']." ORDER BY properties_images.order_img ASC";
                        $idealista_galeria = mysqli_query($inmoconn,$query_idealista_galeria) or die(mysqli_error());
                        $row_idealista_galeria = mysqli_fetch_assoc($idealista_galeria);
                        $totalRows_idealista_galeria = mysqli_num_rows($idealista_galeria);

                        $query_idealista_galeria_plans = "SELECT properties_planos.image_img FROM properties_planos WHERE properties_planos.property_img=".$row_idealista['id_prop']." ORDER BY properties_planos.order_img ASC";
                        $idealista_galeria_plans = mysqli_query($inmoconn,$query_idealista_galeria_plans) or die(mysqli_error());
                        $row_idealista_galeria_plans = mysqli_fetch_assoc($idealista_galeria_plans);
                        $totalRows_idealista_galeria_plans = mysqli_num_rows($idealista_galeria_plans);

                        if ($totalRows_idealista_galeria > 0) {
                            do {
                                if ($row_idealista_galeria['image_img'] != '') {
                                    $Content .= '{';
                                    $Content .= '"imageOrder": ' . $i . ',';
                                    if (preg_match('/https?:\/\//', $row_idealista_galeria['image_img'])) {
                                        $Content .= '"imageUrl": "' . trim($row_idealista_galeria['image_img']) . '"';
                                    } else {
                                        $Content .= '"imageUrl": "' . $_SERVER['REQUEST_SCHEME'] . '://'.$_SERVER['HTTP_HOST'].'/media/images/properties/' . $row_idealista_galeria['image_img'] . '"';
                                    }
                                    $Content .= '}';
                                    if ($totalRows_idealista_galeria != $i++ || $totalRows_idealista_galeria_plans > 0) {
                                        $Content .= ',';
                                    }
                                }
                            } while (($row_idealista_galeria = mysqli_fetch_assoc($idealista_galeria)));
                        }

                        if ($totalRows_idealista_galeria_plans > 0) {
                            do {
                                if ($row_idealista_galeria_plans['image_img'] != '') {
                                    $Content .= '{';
                                    $Content .= '"imageLabel": "plan",';
                                    $Content .= '"imageOrder": ' . $i . ',';
                                    if (preg_match('/https?:\/\//', $row_idealista_galeria_plans['image_img'])) {
                                        $Content .= '"imageUrl": "' . trim($row_idealista_galeria_plans['image_img']) . '"';
                                    } else {
                                        $Content .= '"imageUrl": "' . $_SERVER['REQUEST_SCHEME'] . '://'.$_SERVER['HTTP_HOST'].'/media/images/propertiesplanos/' . $row_idealista_galeria_plans['image_img'] . '"';
                                    }
                                    $Content .= '}';
                                    if (($totalRows_idealista_galeria_plans + $totalRows_idealista_galeria) != $i++) {
                                        $Content .= ',';
                                    }
                                }
                            } while (($row_idealista_galeria_plans = mysqli_fetch_assoc($idealista_galeria_plans)));
                        }
                        $Content .= '],';
                        $Content .= '"propertyFeatures": {';
                        // $Content .= '"featuresType": "flat",';
                        if ($fieldsJSN->featuresType != 'land' && $fieldsJSN->featuresType != 'land_urban' && $fieldsJSN->featuresType != 'land_countrybuildable' && $fieldsJSN->featuresType != 'land_countrynonbuildable') {
                        if ($row_idealista['m2_prop'] > 0) {
                            $metr = explode(',', $row_idealista['m2_prop']);
                            $Content .= '"featuresAreaConstructed": ' . (int)$metr[0] . ',';
                            $Content .= '"featuresAreaUsable": ' . (int)$metr[0] . ',';
                        }
                        }
                        if ($fieldsJSN->featuresWindowsLocation != '') {
                            $Content .= '"featuresWindowsLocation": "' . $fieldsJSN->featuresWindowsLocation . '",';
                        }
                        if ($fieldsJSN->featuresConservation != '') {
                            $Content .= '"featuresConservation": "' . $fieldsJSN->featuresConservation . '",';
                        }
                        if ($row_idealista['operacion_prop'] == 3) {
                            $Content .= '"featuresSeasonalRental": true, ';
                        }
                        if ($fieldsJSN->featuresType == 'land' || $fieldsJSN->featuresType == 'land_urban' || $fieldsJSN->featuresType == 'land_countrybuildable' || $fieldsJSN->featuresType == 'land_countrynonbuildable') {
                            if ($row_idealista['m2_parcela_prop'] > 0) {
                                $Content .= '"featuresAreaPlot": ' . (int)$row_idealista['m2_parcela_prop'] . ',';
                            }
                        }

                        if ($fieldsJSN->featuresType != 'land' && $fieldsJSN->featuresType != 'land_urban' && $fieldsJSN->featuresType != 'land_countrybuildable' && $fieldsJSN->featuresType != 'land_countrynonbuildable') {

                            $habita = ($row_idealista['habitaciones_prop'] > 0)?$row_idealista['habitaciones_prop']:0;
                            $banos = ($row_idealista['aseos_prop'] > 0)?$row_idealista['aseos_prop']:0;

                            $Content .= '"featuresBedroomNumber": ' . $habita . ',';
                            $Content .= '"featuresBathroomNumber": ' . $banos . ',';

                        }

                        if ($row_idealista['construccion_prop'] > 0) {
                            preg_match('/[0-9]{4}/', $row_idealista['construccion_prop'], $year);
                            if ($year[0] != '') {
                                $Content .= '"featuresBuiltYear": ' . $year[0] . ',';
                            }
                        }
                        if ($fieldsJSN->featuresHeating != '') {
                            $Content .= '"featuresHeating": "' . $fieldsJSN->featuresHeating . '",';
                        }
                        $orientations = ['featuresOrientationEast', 'featuresOrientationWest', 'featuresOrientationNorth', 'featuresOrientationSouth'];
                        $or = 0;
                        foreach ($orientations as $name) {
                            $Content .= '"' . $name . '": ' . $orientacion[$or++] . ',';
                        }

                        if ($fieldsJSN->featuresType != 'land' && $fieldsJSN->featuresType != 'land_urban' && $fieldsJSN->featuresType != 'land_countrybuildable' && $fieldsJSN->featuresType != 'land_countrynonbuildable') {
                            if ($row_idealista['energia_prop'] != '0' && $row_idealista['energia_prop'] != '') {
                                $Content .= '"featuresEnergyCertificateRating": "' . $row_idealista['energia_prop'] . '",';
                            } else {
                                $Content .= '"featuresEnergyCertificateRating": "inProcess",';
                            }
                        }
                        foreach ($fieldsJSN->PropertyFeature as $key => $value) {
                            $valueTXT = ($value == 1)?'true':'"'.$value.'"';
                            if ($key != 'featuresBalcony' && $key != 'featuresConditionedAir' && $key != 'featuresHeating' && $key != 'featuresParkingAutomaticDoor' && $key != 'featuresTerrace' && $key != 'featuresType' && $key != 'featuresWardrobes' && $key != 'featuresBuildingAdapted' && $key != 'featuresEmergencyExit' && $key != 'featuresEquippedKitchen' && $key != 'featuresParkingPlaceCovered' && $key != 'featuresHotWater' && $key != 'featuresParkingPlaceCovered') {
                                if ($value == 1) {
                                    $Content .= '"' . $key . '": ' . $valueTXT . ', ';
                                }
                            }
                            if ($key == 'featuresBalcony' && $valueTXT  != '') {
                                $Content .= '"featuresBalcony": true, ';
                            }
                            if ($key == 'featuresConditionedAir' && $valueTXT  != '') {
                                $Content .= '"featuresConditionedAir": true, ';
                            }
                            if ($key == 'featuresParkingAutomaticDoor' && $valueTXT  != '') {
                                $Content .= '"featuresParkingAutomaticDoor": true, ';
                            }
                            if ($key == 'featuresTerrace' && $valueTXT  != '') {
                                $Content .= '"featuresTerrace": true, ';
                            }
                            if ($key == 'featuresWardrobes' && $valueTXT  != '') {
                                $Content .= '"featuresWardrobes": true, ';
                            }
                            if ($key == 'featuresBuildingAdapted' && $valueTXT  != '') {
                                $Content .= '"featuresBuildingAdapted": true, ';
                            }
                            if ($key == 'featuresEmergencyExit' && $valueTXT  != '') {
                                $Content .= '"featuresEmergencyExit": true, ';
                            }
                            if ($key == 'featuresEquippedKitchen' && $valueTXT  != '') {
                                $Content .= '"featuresEquippedKitchen": true, ';
                            }
                            if ($key == 'featuresParkingPlaceCovered' && $valueTXT  != '') {
                                $Content .= '"featuresParkingPlaceCovered": true, ';
                            }
                            if ($key == 'featuresHotWater' && $valueTXT  != '') {
                                $Content .= '"featuresHotWater": true, ';
                            }
                            // if ($key == 'featuresHeating' && $valueTXT  != '') {
                            //     $Content .= '"featuresHeating": true, ';
                            // }
                        }
                        $Content .= '"featuresType": "' . $fieldsJSN->featuresType . '"';
                        $Content .= '},';
                        $Content .= '"propertyUrl": "' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '' . propURL($row_idealista['id_prop'], $language) . '"';
                        $Content .= '}';
                    }
                }
            }
            $query_rsImagenes = "UPDATE `properties_properties` SET `exportado_idealista_prop` = '1' WHERE `id_prop` = ".$row_idealista['id_prop']." LIMIT 1;";
            $rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
        } while ($row_idealista = mysqli_fetch_assoc($idealista));
        $rows = mysqli_num_rows($idealista);
        if ($rows > 0) {
            mysqli_data_seek($idealista, 0);
            $row_idealista = mysqli_fetch_assoc($idealista);
        }
        $Content .= ']';
    }




    // $Content .= ',"customerNewDevelopments": [';

    // if ($totalRows_idealista > 0) {
    //     do {
    //         $fieldsJSN = json_decode($row_idealista['idealista_fields_prop']);

    //         if ($fieldsJSN->operationType  != '') {
    //             if ($fieldsJSN->IsNewConstruction == 1) {
    //                 if ($n2++ > 1) {
    //                     $Content .= ',';
    //                 }

    //                 $lat = explode(',', $row_idealista['lat_long_gp_prop']);
    //                 $lat1 = str_replace(' ', '', $lat[0]);
    //                 $lat2 = str_replace(' ', '', $lat[1]);

    //                 switch ($row_idealista['orientacion_prop']) {
    //                 case 'o-n':
    //                     $orientacion = ['false', 'false', 'true', 'false'];
    //                 break;
    //                 case 'o-ne':
    //                     $orientacion = ['true', 'false', 'true', 'false'];
    //                 break;
    //                 case 'o-e':
    //                     $orientacion = ['true', 'true', 'false', 'false'];
    //                 break;
    //                 case 'o-se':
    //                     $orientacion = ['true', 'false', 'false', 'true'];
    //                 break;
    //                 case 'o-s':
    //                     $orientacion = ['false', 'false', 'false', 'true'];
    //                 break;
    //                 case 'o-so':
    //                     $orientacion = ['false', 'true', 'false', 'true'];
    //                 break;
    //                 case 'o-o':
    //                     $orientacion = ['false', 'true', 'false', 'false'];
    //                 break;
    //                 case 'o-no':
    //                     $orientacion = ['false', 'true', 'true', 'false'];
    //                 break;
    //                 default:
    //                     $orientacion = ['false', 'false', 'false', 'false'];
    //                 break;
    //             }

    //                 $Content .= '{';
    //                 $Content .= '"propertyCode": "' . $row_idealista['id_prop'] . '",';
    //                 $Content .= '"propertyReference": "' . $row_idealista['referencia_prop'] . '",';
    //                 $Content .= '"propertyOperation":';
    //                 $Content .= '{';
    //                 $Content .= '"operationType": "' . $fieldsJSN->operationType . '",';
    //                 $Content .= '"operationPrice": ' . $row_idealista['preci_reducidoo_prop'] . '';
    //                 if ($row_idealista['gastos_prop'] > 0) {
    //                     $Content .= ',"operationPriceCommunity": ' . ($row_idealista['gastos_prop']) . '';
    //                 }
    //                 $Content .= '},';
    //                 $Content .= '"propertyContact":';
    //                 $Content .= '{';
    //                 $Content .= '"contactEmail": "' . $idealistaContactEmail . '",';
    //                 $Content .= '"contactPrimaryPhonePrefix": "' . $idealistaContactPrimaryPhonePrefix . '",';
    //                 $Content .= '"contactPrimaryPhoneNumber": "' . $idealistaContactPrimaryPhoneNumber . '"';
    //                 if ($idealistaContactSecondaryPhonePrefix != '') {
    //                     $Content .= ',"contactSecondaryPhonePrefix": "' . $idealistaContactSecondaryPhonePrefix . '"';
    //                 }
    //                 if ($idealistaContactSecondaryPhoneNumber != '') {
    //                     $Content .= ',"contactSecondaryPhoneNumber": "' . $idealistaContactSecondaryPhoneNumber . '"';
    //                 }
    //                 $Content .= '},';
    //                $Content .= '"propertyAddress":';
    //                $Content .= '{';
    //                $Content .= '"addressVisibility": "hidden",';
    //                $Content .= '"addressStreetName": "' . $fieldsJSN->addressCalle . '",';
    //                $Content .= '"addressStreetNumber": "' . $fieldsJSN->addressNumero . '",';
    //                if ($fieldsJSN->addressPlanta  > 0) {
    //                    $Content .= '"addressFloor": "' . $fieldsJSN->addressPlanta . '",';
    //                } else {
    //                    // $Content .= '"addressFloor": "bj",';
    //                }
    //                $Content .= '"addressPostalCode": "' . $fieldsJSN->addressPostalCode . '",';
    //                $Content .= '"addressTown": "' . $fieldsJSN->addressLocalidad . '",';
    //                $Content .= '"addressCountry": "Spain"';
    //                if ($lat1 != '' && $lat2 != '') {
    //                    $Content .= ', ';
    //                    $Content .= '"addressCoordinatesPrecision": "moved",';
    //                    $Content .= '"addressCoordinatesLatitude": ' . $lat1 . ',';
    //                    $Content .= '"addressCoordinatesLongitude": ' . $lat2 . '';
    //                }
    //                 $Content .= '},';
    //                 $foundDesc = 0;
    //                 $Content .= '"propertyDescriptions": [';
    //                 if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_es_prop']))))))))) != '') {
    //                     $Content .= '{';
    //                     $Content .= '"descriptionLanguage": "spanish",';
    //                     $Content .= '"descriptionText": "' . rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_es_prop']))))))))) . '"';
    //                     $Content .= '}';
    //                     $foundDesc = 1;
    //                 }
    //                 if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_en_prop']))))))))) != '') {
    //                     if ($foundDesc == 1) {
    //                         $Content .= ',';
    //                     } else {
    //                         $foundDesc = 1;
    //                     }
    //                     $Content .= '{';
    //                     $Content .= '"descriptionLanguage": "english",';
    //                     $Content .= '"descriptionText": "' . rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_en_prop']))))))))) . '"';
    //                     $Content .= '}';
    //                 }
    //                 if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_de_prop']))))))))) != '') {
    //                     if ($foundDesc == 1) {
    //                         $Content .= ',';
    //                     } else {
    //                         $foundDesc = 1;
    //                     }
    //                     $Content .= '{';
    //                     $Content .= '"descriptionLanguage": "german",';
    //                     $Content .= '"descriptionText": "' . rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_de_prop']))))))))) . '"';
    //                     $Content .= '}';
    //                 }
    //                 if (rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_fr_prop']))))))))) != '') {
    //                     if ($foundDesc == 1) {
    //                         $Content .= ',';
    //                     } else {
    //                         $foundDesc = 1;
    //                     }
    //                     $Content .= '{';
    //                     $Content .= '"descriptionLanguage": "french",';
    //                     $Content .= '"descriptionText": "' . rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_fr_prop']))))))))) . '"';
    //                     $Content .= '}';
    //                 }
    //                 if ((rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_ru_prop'])))))))))) != '') {
    //                     if ($foundDesc == 1) {
    //                         $Content .= ',';
    //                     } else {
    //                         $foundDesc = 1;
    //                     }
    //                     $Content .= '{';
    //                     $Content .= '"descriptionLanguage": "russian",';
    //                     $Content .= '"descriptionText": "' . rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_ru_prop']))))))))) . '"';
    //                     $Content .= '}';
    //                 }
    //                 if ((rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_se_prop'])))))))))) != '') {
    //                     if ($foundDesc == 1) {
    //                         $Content .= ',';
    //                     } else {
    //                         $foundDesc = 1;
    //                     }
    //                     $Content .= '{';
    //                     $Content .= '"descriptionLanguage": "swedish",';
    //                     $Content .= '"descriptionText": "' . rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_se_prop']))))))))) . '"';
    //                     $Content .= '}';
    //                 }
    //                 if ((rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_nl_prop'])))))))))) != '') {
    //                     if ($foundDesc == 1) {
    //                         $Content .= ',';
    //                     } else {
    //                         $foundDesc = 1;
    //                     }
    //                     $Content .= '{';
    //                     $Content .= '"descriptionLanguage": "dutch",';
    //                     $Content .= '"descriptionText": "' . rip_tags(str_replace('"', '&quot;', str_replace('\\', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />', ' ', str_replace('</p>', ' </p>', $row_idealista['descripcion_nl_prop']))))))))) . '"';
    //                     $Content .= '}';
    //                 }
    //                 $Content .= '],';
    //                 $Content .= '"propertyImages": [';
    //                 $i=1;
    //                 
    //                 $query_idealista_galeria = "SELECT properties_images.image_img FROM properties_images WHERE properties_images.property_img=".$row_idealista['id_prop']." ORDER BY properties_images.order_img ASC";
    //                 $idealista_galeria = mysqli_query($inmoconn,$query_idealista_galeria) or die(mysqli_error());
    //                 $row_idealista_galeria = mysqli_fetch_assoc($idealista_galeria);
    //                 $totalRows_idealista_galeria = mysqli_num_rows($idealista_galeria);
    //                 if ($totalRows_idealista_galeria > 0) {
    //                     do {
    //                         if ($row_idealista_galeria['image_img'] != '') {
    //                             $Content .= '{';
    //                             $Content .= '"imageOrder": ' . $i . ',';
    //                             if (preg_match('/https?:\/\//', $row_idealista_galeria['image_img'])) {
    //                                 $Content .= '"imageUrl": "' . trim($row_idealista_galeria['image_img']) . '"';
    //                             } else {
    //                                 $Content .= '"imageUrl": "' . $_SERVER['REQUEST_SCHEME'] . '://'.$_SERVER['HTTP_HOST'].'/media/images/properties/' . $row_idealista_galeria['image_img'] . '"';
    //                             }
    //                             $Content .= '}';
    //                             if ($totalRows_idealista_galeria != $i++) {
    //                                 $Content .= ',';
    //                             }
    //                         }
    //                     } while (($row_idealista_galeria = mysqli_fetch_assoc($idealista_galeria)));
    //                 }
    //                 $Content .= '],';
    //                 $Content .= '"propertyFeatures": {';
    //                 // $Content .= '"featuresType": "flat",';
    //                 if ($row_idealista['m2_prop'] > 0) {
    //                     $metr = explode(',', $row_idealista['m2_prop']);
    //                     // $Content .= '"featuresAreaConstructed": ' . $metr[0] . ',';
    //                     // $Content .= '"featuresAreaUsable": ' . $metr[0] . ',';
    //                 }
    //                 if ($fieldsJSN->featuresWindowsLocation != '') {
    //                     $Content .= '"featuresWindowsLocation": "' . $fieldsJSN->featuresWindowsLocation . '",';
    //                 }
    //                 if ($fieldsJSN->featuresConservation != '') {
    //                     $Content .= '"featuresConservation": "' . $fieldsJSN->featuresConservation . '",';
    //                 }
    //                 if ($row_idealista['habitaciones_prop'] > 0) {
    //                     $Content .= '"featuresBedroomNumber": ' . $row_idealista['habitaciones_prop'] . ',';
    //                 }
    //                 if ($row_idealista['aseos_prop'] > 0) {
    //                     $Content .= '"featuresBathroomNumber": ' . $row_idealista['aseos_prop'] . ',';
    //                 }
    //                 $Content .= '"featuresNewDevelopmentType": "new_building",';
    //                 if ($row_idealista['construccion_prop'] > 0) {
    //                     preg_match('/[0-9]{4}/', $row_idealista['construccion_prop'], $year);
    //                     $Content .= '"featuresBuiltYear": ' . $year[0] . ',';
    //                 }
    //                 $orientations = ['featuresOrientationEast', 'featuresOrientationWest', 'featuresOrientationNorth', 'featuresOrientationSouth'];
    //                 $or = 0;
    //                 foreach ($orientations as $name) {
    //                     $Content .= '"' . $name . '": ' . $orientacion[$or++] . ',';
    //                 }
    //                 if ($row_idealista['energia_prop'] != 0 && $row_idealista['energia_prop'] != '') {
    //                     $Content .= '"featuresEnergyCertificateRating": "' . $row_idealista['energia_prop'] . '",';
    //                 } else {
    //                     $Content .= '"featuresEnergyCertificateRating": "inProcess",';
    //                 }
    //                 foreach ($fieldsJSN->PropertyFeature as $key => $value) {
    //                     $valueTXT = ($value == 1)?'true':'"'.$value.'"';
    //                     if ($key != 'featuresBalcony' && $key != 'featuresConditionedAir' && $key != 'featuresHeating' && $key != 'featuresParkingAutomaticDoor' && $key != 'featuresTerrace' && $key != 'featuresType' && $key != 'featuresWardrobes' && $key != 'featuresBuildingAdapted' && $key != 'featuresEmergencyExit' && $key != 'featuresEquippedKitchen' && $key != 'featuresParkingPlaceCovered' && $key != 'featuresHotWater' && $key != 'featuresParkingPlaceCovered') {
    //                         if ($value == 1) {
    //                             $Content .= '"' . $key . '": ' . $valueTXT . ', ';
    //                         }
    //                     }
    //                     if ($key == 'featuresBalcony' && $valueTXT  != '') {
    //                         $Content .= '"featuresBalcony": true, ';
    //                     }
    //                     if ($key == 'featuresConditionedAir' && $valueTXT  != '') {
    //                         $Content .= '"featuresConditionedAir": true, ';
    //                     }
    //                     if ($key == 'featuresParkingAutomaticDoor' && $valueTXT  != '') {
    //                         $Content .= '"featuresParkingAutomaticDoor": true, ';
    //                     }
    //                     if ($key == 'featuresTerrace' && $valueTXT  != '') {
    //                         $Content .= '"featuresTerrace": true, ';
    //                     }
    //                     if ($key == 'featuresWardrobes' && $valueTXT  != '') {
    //                         $Content .= '"featuresWardrobes": true, ';
    //                     }
    //                     if ($key == 'featuresBuildingAdapted' && $valueTXT  != '') {
    //                         $Content .= '"featuresBuildingAdapted": true, ';
    //                     }
    //                     if ($key == 'featuresEmergencyExit' && $valueTXT  != '') {
    //                         $Content .= '"featuresEmergencyExit": true, ';
    //                     }
    //                     if ($key == 'featuresEquippedKitchen' && $valueTXT  != '') {
    //                         $Content .= '"featuresEquippedKitchen": true, ';
    //                     }
    //                     if ($key == 'featuresParkingPlaceCovered' && $valueTXT  != '') {
    //                         $Content .= '"featuresParkingPlaceCovered": true, ';
    //                     }
    //                     if ($key == 'featuresHotWater' && $valueTXT  != '') {
    //                         $Content .= '"featuresHotWater": true, ';
    //                     }
//                         if ($key == 'featuresHeating' && $valueTXT  != '') {
//                              $Content .= '"featuresHeating": true, ';
//                         }
    //                 }
    //                 if ($fieldsJSN->featuresHeating != '') {
    //                     $Content .= '"featuresHeating": ' . $fieldsJSN->featuresHeating . ', ';
    //                 }
    //                 $Content .= '"featuresNewDevelopmentName": "' . $row_idealista['referencia_prop'] . '"';
    //                 $Content .= '},';
    //                 $Content .= '"featuresType": "promo",';
    //                 $Content .= '"propertyUrl": "' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '' . propURL($row_idealista['id_prop'], $language) . '"';
    //                 $Content .= '}';
    //             }
    //         }
    //     } while ($row_idealista = mysqli_fetch_assoc($idealista));
    // }
    // $Content .= ']';
}
$Content .="}";

echo $Content;
// die();

function is_JSON($args) {
    json_decode($args);
    return (json_last_error()===JSON_ERROR_NONE);
}

if (!is_JSON($Content)) {

    $subject = 'Error en JSON idealista de la web ' . $_SERVER['SERVER_NAME'];

    $mensaHTML = '';
    $mensaHTML .= "<p>Fecha: " . date("d-m-Y H:i") . "</p>";
    $mensaHTML .= "<p>Dominio: " . $_SERVER['SERVER_NAME'] . "</p>";
    $mensaHTML .= "<p>Servidor: " . $_SERVER['SERVER_ADDR'] . "</p>";
    $mensaHTML .= "<p>URL: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "</p>";

    sendAppEmail(array('correo@mediaelx.net' => 'Mediaelx'), '', '', '', $subject, $mensaHTML);
    die();
}

$newfile=$idealistaFILEname . ".json";
$file = fopen($newfile, "w");
fwrite($file, $Content);
fclose($file);

include "inc/SFTP.php";

$ftp = new SFTP($idealistaFTP, $idealistaFTPuser, $idealistaFTPpass);

if ($ftp->connect()) {
    if ($ftp->put($idealistaFILEname . ".json", '' .$idealistaFILEname . ".json")) {
        $ftp->chmod(0777, $idealistaFILEname . ".json");
    }
}
