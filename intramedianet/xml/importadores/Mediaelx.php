<?php

if ($_GET['d'] == 'ok') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}


if (isset($_GET['p'])) {

    // Variables
    $countryID = '';
    $provinceID = '';
    $townID = '';
    $zoneID = '';
    $typeID = '';
    $statusID = '';
    $poolID = '';
    $parkingID = '';
    $kitchensID = '';
    $conditionID = '';
    $floorID = '';
    $tagID = '';
    $featureID= '';
    $refInm = '';
    $propPrice = '';
    $numInsert = 0;
    $numUpdated = 0;
    $newProvArray = array();
    $newTownArray = array();
    $newZoneArray = array();
    $newTypeArray = array();
    $newFeatArray = array();

    /* @group Seleccionamos el proveedor */
    $proveedor = getProveedor($_GET['p']);

    /* @group Obtenemos las propiedades desactivadas para desactivarlas despues */
    $propiedades_desactivadas = getDesactivados($_GET['p']);

    /* @group Obtenemos el xml */
    $xml = getXML($proveedor['xml_url_xml']);

    /* @group Comprobamos si es un xml válido */
    if (!checkXMLmediaelx($xml)) {
        reportError($_GET['p']);
    } else { // Procesamos el xml

        deacticateAllProps($_GET['p']);

        // Obtenemos laversión del xml kyero
        $kyero_version = ($xml->xml_mediaelx->feed_version == 3)?3:2;

        $i = 1;

        foreach ($xml->property as $property) {
            set_time_limit(0);
            // echo $i++ . ' | ';
            // El inmueble tiene los datos necesarios
            if (checkPropertyMediaelx($property)) {

                $propID = '';

                $in_database = checkPropertyExits($property->ref, $_GET['p']);

                $countryName = (empty((string)$property->country)) ? setCountry('Spain') : setCountry((string)$property->country);
                $provinceName = setProvince((string)$property->province, $countryID);
                if ($property->costa != '') {
                     $townName = setTown2((string)$property->town, $provinceID, $provinceName, (string)$property->costa);
                } else {
                    $townName = setTown((string)$property->town, $provinceID, $provinceName);
                }
                $zoneName = setZone((string)$property->location_detail, $provinceID, $provinceName, $townID, $townName);
                $typeName = setTypePropMediaelx((array)$property->type);
                if (isset($property->pool) && !empty(trim((string)$property->pool)))  {
                    $poolID = setPoolProp((array)$property->pool);
                }
                $parkingID = setParkingProp((array)$property->parking);
                $kitchensID = setKitchensProp((array)$property->kitchens);
                $conditionID = setConditionProp((array)$property->condition);
                $floorID = setFloorProp((array)$property->floor);
                $statusID = getStatusMediaelx((string)$property->price_freq, (string)$property->new_build);

               $refInm = getRef($proveedor['ref_prefix_xml']);

               if ($refInm == '') {
                   $refInm = getRef($proveedor['ref_prefix_xml']);
               }

                $query = "INSERT INTO properties_properties SET ";
                if ($in_database) {
                    $query = "UPDATE properties_properties SET ";
                }
                if (!$in_database) {
                    $query .= "referencia_prop = '".mysqli_real_escape_string($inmoconn,trim($refInm))."', ";
                    $query .= "inserted_xml_prop = '".date("Y-m-d H:i:s")."', ";
                }
                if (!$in_database || $proveedor['up_ciudad_xml'] == 1) {
                    $query .= "localidad_prop = '".$zoneID."', ";
                }
                if (!$in_database || $proveedor['up_operacion_xml'] == 1) {
                    $query .= "operacion_prop = '".$statusID."', ";
                }
                if (!$in_database || $proveedor['up_tipo_xml'] == 1) {
                    $query .= "tipo_prop = '".$typeID."', ";
                }
                if (!$in_database || $proveedor['up_precio_xml'] == 1) {
                    $query .= "preci_reducidoo_prop = '".(int)$property->price."', ";
                    $query .= "precio_prop = '".(int)$property->price_old."', ";
                    $query .= "precio_desde_prop = '".(int)$property->price_from."', ";
                }
                if ((int)$property->price_m_1 > 0) {
                    $query .= "precio_1_prop = '".(int)$property->price_m_1."', ";
                }
                if ((int)$property->price_m_2 > 0) {
                    $query .= "precio_2_prop = '".(int)$property->price_m_2."', ";
                }
                if ((int)$property->price_m_3 > 0) {
                    $query .= "precio_3_prop = '".(int)$property->price_m_3."', ";
                }
                if ((int)$property->price_m_4 > 0) {
                    $query .= "precio_4_prop = '".(int)$property->price_m_4."', ";
                }
                if ((int)$property->price_m_5 > 0) {
                    $query .= "precio_5_prop = '".(int)$property->price_m_5."', ";
                }
                if ((int)$property->price_m_6 > 0) {
                    $query .= "precio_6_prop = '".(int)$property->price_m_6."', ";
                }
                if ((int)$property->price_m_7 > 0) {
                    $query .= "precio_7_prop = '".(int)$property->price_m_7."', ";
                }
                if ((int)$property->price_m_8 > 0) {
                    $query .= "precio_8_prop = '".(int)$property->price_m_8."', ";
                }
                if ((int)$property->price_m_9 > 0) {
                    $query .= "precio_9_prop = '".(int)$property->price_m_9."', ";
                }
                if ((int)$property->price_m_10 > 0) {
                    $query .= "precio_10_prop = '".(int)$property->price_m_10."', ";
                }
                if ((int)$property->price_m_11 > 0) {
                    $query .= "precio_11_prop = '".(int)$property->price_m_11."', ";
                }
                if ((int)$property->price_m_12 > 0) {
                    $query .= "precio_12_prop = '".(int)$property->price_m_12."', ";
                }
                if (!$in_database || $proveedor['up_m2_xml'] == 1) {
                    $query .= "m2_prop = '".(int)$property->surface_area->built."', ";
                    $query .= "m2_utiles_prop = '".(int)$property->surface_area->usable."', ";
                }
                if (!$in_database || $proveedor['up_m2_t_xml'] == 1) {
                    $query .= "m2_parcela_prop = '".(int)$property->surface_area->plot."', ";
                    $query .= "m2_balcon_prop = '".(int)$property->surface_area->terrace."', ";
                    $query .= "garden_m2_prop = '".(int)$property->surface_area->garden."', ";
                    $query .= "m2_solarium_prop = '".(int)$property->surface_area->solarium."', ";
                }
                if (!$in_database || $proveedor['up_habitaciones_xml'] == 1) {
                    $query .= "habitaciones_prop = '".(int)$property->beds."', ";
                }
                if (!$in_database || $proveedor['up_aseos_xml'] == 1) {
                    $query .= "aseos_prop = '".(int)$property->baths."', ";
                    $query .= "aseos2_prop = '".(int)$property->wc."', ";
                }
                if ((int)$poolID > 0) {
                    $query .= "piscina_prop = '".(int)$poolID."', ";
                }
                if ((int)$parkingID > 0) {
                    $query .= "parking_prop = '".(int)$parkingID."', ";
                }
                if ((int)$kitchensID > 0) {
                    $query .= "cocinas_prop = '".(int)$kitchensID."', ";
                }
                if ((int)$conditionID > 0) {
                    $query .= "estado_prop = '".(int)$conditionID."', ";
                }
                if ((int)$floorID > 0) {
                    $query .= "planta_prop = '".(int)$floorID."', ";
                }
                if ((string)$property->v360 != '') {
                    $query .= "vista360_prop = '".(string)$property->v360."', ";
                }
                if ((string)$property->orientation!= '') {
                    $query .= "orientacion_prop = 'o-".(string)$property->orientation."', ";
                }
                $query .= "solarium_prop = '".(int)$property->solarium."', ";

                $query .= "armarios_empotrados_prop = '".(int)$property->wardrobes."', ";
                $query .= "plazas_garaje_prop = '".(int)$property->parking_places."', ";
                $query .= "comision_agent_prop = '".(int)$property->comision."', ";
                $query .= "suma_prop = '".(int)$property->suma."', ";
                $query .= "gastos_prop = '".(int)$property->community."', ";
                $query .= "referencia_catrastal_prop = '".(int)$property->catrastal_reference."', ";

                $query .= "distance_beach_prop = '".(int)$property->distance_beach."', ";
                $query .= "distance_beach_med_prop = '".(string)$property->distance_beach_med."', ";

                $query .= "distance_airport_prop = '".(int)$property->distance_airport."', ";
                $query .= "distance_airport_med_prop = '".(string)$property->distance_airport_med."', ";

                $query .= "distance_golf_prop = '".(int)$property->distance_golf."', ";
                $query .= "distance_golf_med_prop = '".(string)$property->distance_golf_med."', ";

                $query .= "distance_amenities_prop = '".(int)$property->distance_amenities."', ";
                $query .= "distance_amenities_med_prop = '".(string)$property->distance_amenities_med."', ";

                if (!$in_database || $proveedor['up_descripcion_xml'] == 1) {
                    foreach($allLanguages as $value) {
                            $query .= "descripcion_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->desc->$value))."', ";
                            $query .= "titulo_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->title->$value))."', ";
                    }
                }
                $lat = mysqli_real_escape_string($inmoconn,trim((float)$property->location->latitude));
                $long = mysqli_real_escape_string($inmoconn,trim((float)$property->location->longitude));
                if ($lat != '' && $lat != 0 && $long != '' && $long != 0) {
                    $query .= "lat_long_gp_prop = '".$lat.",".$long."', ";
                    $query .= "direccion_agen_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->location->address))."', ";
                    $query .= "zoom_gp_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->location->zoom))."', ";
                }
                $energy = mysqli_real_escape_string($inmoconn,trim((string)$property->energy));
                if ($energy != '') {
                    $query .= "energia_prop = '".$energy."', ";
                }
                $year_build = mysqli_real_escape_string($inmoconn,trim((string)$property->year_build));
                if ($year_build != '') {
                    $query .= "construccion_prop = '".$year_build."', ";
                }
                $query .= "xml_xml_prop = '".$_GET['p']."', ";
                $query .= "ref_xml_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->ref))."', ";
                $query .= "url_xml_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->url->en))."', ";
                $query .= "activado_prop = '1' ";
                if ($in_database) {
                    $query .= "WHERE ref_xml_prop = '".(string)$property->ref."' AND xml_xml_prop = '".$_GET['p']."'";
                }
                $actionUpdateProp = '';
                if ($in_database) {
                     if ($propPrice == (int)$property->price) {
                       $actionUpdateProp = '2';
                     }
                    if ($propPrice > (int)$property->price) {
                       $actionUpdateProp = '3';
                     }
                    if ($propPrice < (int)$property->price) {
                       $actionUpdateProp = '4';
                     }
                }
                savePropertyDataMediaelx($query, $in_database, $property->features->feature, $property->images, $property->plans, $property->videos, $property->views360, $property->prices_days, $property->availabity, $property->tags->tag);
                if ($desactivar_desactivados == 1) {
                    setDesactivados($propiedades_desactivadas);
                }
            }
        }
        updateProvStatus($_GET['p'], (int)count($xml->property), (int)$numInsert + (int)$numUpdated);
        fixImagesOrder();
        sendMappingData();

        $query_rsPropsDel = "SELECT id_prop, referencia_prop FROM properties_properties WHERE xml_xml_prop = '".$_GET['p']."' AND activado_prop = 0";
        $rsPropsDel = mysqli_query($inmoconn,$query_rsPropsDel) or die(mysqli_error() . '<hr>' . $query_rsPropsDel);
        $row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel);
        $totalRows_rsPropsDel = mysqli_num_rows($rsPropsDel);

        if ($totalRows_rsPropsDel > 0) {

            do {

                $query_rsXMLfea = "DELETE FROM properties_property_feature_priv WHERE property = '".$row_rsPropsDel['id_prop']."'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . '<hr>' . $query_rsXMLfea);


                $query_rsXMLfea = "DELETE FROM properties_property_tag WHERE property = '".$row_rsPropsDel['id_prop']."'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . '<hr>' . $query_rsXMLfea);


                $query_rsXMLfea = "DELETE FROM properties_360 WHERE property_360 = '".$row_rsPropsDel['id_prop']."'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


                $query_rsXMLfea = "DELETE FROM properties_videos WHERE property_vid = '".$row_rsPropsDel['id_prop']."'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


                $query_rsXMLfea = "DELETE FROM properties_log WHERE prop_id_log = '".$row_rsPropsDel['id_prop']."'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


                $query_rsXMLfea = "DELETE FROM properties_log_2 WHERE prop_id_log = '".$row_rsPropsDel['id_prop']."'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());

                // logprop('0', $row_rsPropsDel['id_prop'], $row_rsPropsDel['referencia_prop'], '5');

                if ($expFotoCasa == 1) {
                    include_once($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/FotocasaAPI.php');

                    $result = FotocasaAPI::getPublicationProperty($fotocasaDatos["api_key"]);
                    $result = json_decode($result,1);
                    foreach ( $result as $key => $prop) {
                        if( $prop["ExternalId"] == $row_rsPropsDel['id_prop'] ) {
                            $resutl = FotocasaAPI::deletePropertyByPortal( (int)$row_rsPropsDel['id_prop'], 1, $fotocasaDatos["api_key"]);
                            $_SESSION['fc_status'] = $result;
                        }
                    }
                }

                $query_rsXML = "SELECT * FROM properties_images WHERE property_img = '".$row_rsPropsDel['id_prop']."'";
                $rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error() . '<hr>' . $query_rsXML);
                $row_rsXML = mysqli_fetch_assoc($rsXML);
                $totalRows_rsXML = mysqli_num_rows($rsXML);

                do {

                    array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/" . $row_rsXML['id_img'] . "_*"));


                    $query_rsDelIMG = "DELETE FROM properties_images WHERE id_img = '".$row_rsXML['id_img']."'";
                    $rsDelIMG = mysqli_query($inmoconn,$query_rsDelIMG) or die(mysqli_error() . '<hr>' . $query_rsDelIMG);

                } while ($row_rsXML = mysqli_fetch_assoc($rsXML));

                $query_rsXMLprop = "DELETE FROM properties_properties WHERE id_prop = '".$row_rsPropsDel['id_prop']."'";
                $rsXMLprop = mysqli_query($inmoconn, $query_rsXMLprop) or die(mysqli_error() . '<hr>' . $query_rsXMLprop);

            } while ($row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel));

            array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));

        }

        showReportImp($xml->property, $numInsert, $numUpdated, getDesactivados($_GET['p']));
    }
}
