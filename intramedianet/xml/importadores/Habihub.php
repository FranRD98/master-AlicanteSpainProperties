<?php
if ($_GET['d'] == 'ok') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

if (isset($_GET['p'])) {

    // Variables
    $countryID = '';
    $provinceID = '';
    $provinceName = '';
    $townID = '';
    $zoneName = '';
    $zoneID = '';
    $typeID = '';
    $statusID = '';
    $refInm = '';
    $propPrice = '';
    $conditionID = '';
    $promotionID = '';
    $ownerID = '';
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

    // echo "<pre>";
    // print_r($xml);
    // echo "</pre>";
    // die();

    /* @group Comprobamos si es un xml válido */
    if (!checkXMLHabihub($xml)) {
        reportError($_GET['p']);
    } else { // Procesamos el xml

        deacticateAllProps($_GET['p']);

        // Obtenemos laversión del xml kyero
        $kyero_version = ($xml->kyero->feed_version == 3)?3:2;

        $i = 1;

        foreach ($xml->property as $property) {
            set_time_limit(0);
            // echo $i++ . ' | ';
            // El inmueble tiene los datos necesarios
            if (checkPropertykyero($property)) {

                $typeValue = ($kyero_version == '3')?(string)$property->type:(string)$property->type->en;

                $propID = '';

                $in_database = checkPropertyExits($property->ref, $_GET['p']);

                $countryName = (empty((string)$property->country)) ? setCountry('Spain') : setCountry((string)$property->country);
                $provinceName = setProvince((string)$property->province, $countryID);
                $townName = setTown((string)$property->town, $provinceID, $provinceName);
                $zoneName = setZone((string)$property->location_detail, $provinceID, $provinceName, $townID, $townName);
                $typeName = setTypeProp($typeValue);
                $statusID = getStatusKyero((string)$property->price_freq, (string)$property->new_build);
                $conditionID = setConditionPropHabihub((string)$property->status);
                $ownerID = setOwnerHabihub((array)$property->development_company);
                $promotionID = setPromotionHabihub((string)$property->development_name, (string)$provinceName, (string)$townName, $property);

                $refInm = getRef($proveedor['ref_prefix_xml']);

                if ($refInm == '') {
                    $refInm = getRef($proveedor['ref_prefix_xml']);
                }

                $query = "INSERT INTO properties_properties SET \n";
                if ($in_database) {
                    $query = "UPDATE properties_properties SET \n";
                }
                if (!$in_database) {
                    $query .= "referencia_prop = '".mysqli_real_escape_string($inmoconn,trim($refInm))."', \n";
                    $query .= "inserted_xml_prop = '".date("Y-m-d H:i:s")."', \n";
                }
                $query .= "promocion_prop = '".$promotionID."', \n";
                if (!$in_database || $proveedor['up_ciudad_xml'] == 1) {
                    $query .= "localidad_prop = '".$zoneID."', \n";
                }
                if (!$in_database || $proveedor['up_operacion_xml'] == 1) {
                    $query .= "operacion_prop = '".$statusID."', \n";
                }
                if (!$in_database || $proveedor['up_tipo_xml'] == 1) {
                    $query .= "tipo_prop = '".$typeID."', \n";
                }
                if (!$in_database || $proveedor['up_precio_xml'] == 1) {
                    $query .= "preci_reducidoo_prop = '".(int)$property->price."', \n";
                }
                if (!$in_database || $proveedor['up_m2_xml'] == 1) {
                    $query .= "m2_prop = '".(int)$property->surface_area->built."', \n";
                    $query .= "m2_balcon_prop = '".(int)$property->surface_area->terrace."', \n";
                }
                if (!$in_database || $proveedor['up_m2_t_xml'] == 1) {
                    $query .= "m2_parcela_prop = '".(int)$property->surface_area->plot."', \n";
                }
                if (!$in_database || $proveedor['up_habitaciones_xml'] == 1) {
                    $query .= "habitaciones_prop = '".(int)$property->beds."', \n";
                }
                if (!$in_database || $proveedor['up_aseos_xml'] == 1) {
                    $query .= "aseos_prop = '".(int)$property->baths."', \n";
                }
                if (!$in_database || $proveedor['up_pool_t_xml'] == 1) {
                    $query .= "piscina_prop = '".(int)$property->pool."', \n";
                }
                if (!$in_database || $proveedor['up_descripcion_xml'] == 1) 
                {
                   foreach($allLanguages as $value)
                   {
                       if ($value == 'se') {
                           if ((string)$property->desc->sv != '') {
                                $query .= "descripcion_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->desc->sv))."', \n";
                           }
                           if ((string)$property->seo->metadescription->sv != '') {
                                $query .= "description_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->metadescription->sv))."', \n";
                           }
                           if ($property->seo->h1->sv != '') {
                                $query .= "titulo_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->h1->sv))."', \n";
                           } else {
                                $query .= "titulo_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->title->sv))."', \n";
                           }
                           if ($property->seo->title->sv != '') {
                                $query .= "title_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->title->sv))."', \n";
                           }
                       } else {
                           if ((string)$property->desc->$value != '') {
                                $query .= "descripcion_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->desc->$value))."', \n";
                           }
                           if ((string)$property->seo->metadescription->$value != '') {
                                $query .= "description_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->metadescription->$value))."', \n";
                           }
                           if ((string)$property->seo->h1->$value != '') {
                                $query .= "titulo_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->h1->$value))."', \n";
                           } else {
                                $query .= "titulo_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->title->$value))."', \n";
                           }
                           if ((string)$property->seo->title->$value != '') {
                                $query .= "title_".$value."_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->title->$value))."', \n";
                           }
                       }
                   }
                }

                $distancebeach = (int)$property->distances->beach;
                if (!$in_database && $distancebeach > 0) {
                    $query .= "distance_beach_prop = '".$distancebeach."', \n";
                    $query .= "distance_beach_med_prop = 'Mts', \n";
                }

                $airport = (int)$property->distances->airport;
                if (!$in_database && $airport > 0) {
                    $query .= "distance_airport_prop = '".$airport."', \n";
                    $query .= "distance_airport_med_prop = 'Mts', \n";
                }

                $golf = (int)$property->distances->golf;
                if (!$in_database && $golf > 0) {
                    $query .= "distance_golf_prop = '".$golf."', \n";
                    $query .= "distance_golf_med_prop = 'Mts', \n";
                }

                $green_areas = (int)$property->distances->green_areas;
                if (!$in_database && $green_areas > 0) {
                    $query .= "distance_amenities_prop = '".$green_areas."', \n";
                    $query .= "distance_amenities_med_prop = 'Mts', \n";
                }

                $key_date = trim((string)$property->key_date);
                if ($key_date != '') {
                    if (strpos($key_date, '-') !== false) {
                        $query .= "entraga_date_prop = '" . date("d-m-Y", strtotime($key_date)) . "', \n";
                    } else {
                        $query .= "entraga_date_prop = '" . $key_date . "', \n";
                    }
                }

                $lat = mysqli_real_escape_string($inmoconn,trim((float)$property->location->latitude));
                $long = mysqli_real_escape_string($inmoconn,trim((float)$property->location->longitude));
                if (($lat != '' && $lat != 0) && ($long != '' && $long != 0)) {
                    $query .= "lat_long_gp_prop = '".$lat.",".$long."', \n";
                }
                $address = mysqli_real_escape_string($inmoconn,trim((string)$property->location->address));
                if ($address != '') {
                    $query .= "direccion_prop = '".$address."', \n";
                }
                $energy = mysqli_real_escape_string($inmoconn,trim((string)$property->energy_rating->consumption));
                if ($energy != '') {
                    $query .= "energia_prop = '".$energy."', \n";
                }
                $emisiones = mysqli_real_escape_string($inmoconn,trim((string)$property->energy_rating->emissions));
                if ($emisiones != '') {
                    $query .= "emisiones_prop = '".$emisiones."', \n";
                }
                $query .= "dev_commission_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->commission->type)) . ' - ' . mysqli_real_escape_string($inmoconn,trim((string)$property->commission->quantity))."', \n";
                $units = mysqli_real_escape_string($inmoconn,trim((int)$property->units));
                if ($units != '') {
                    $query .= "units_prop = '".$units."', \n";
                }
                if ((int)$conditionID > 0) {
                    $query .= "estado_prop = '".(int)$conditionID."', \n";
                }
                if ((int)$ownerID > 0) {
                    $query .= "owner_prop = '".(int)$ownerID."', \n";
                }
                $query .= "xml_xml_prop = '".$_GET['p']."', \n";
                $query .= "ref_xml_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->ref))."', \n";
                $query .= "url_xml_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->url->en))."', \n";
                $query_rsHide = "SELECT id_prop, referencia_prop, force_hide_prop FROM properties_properties WHERE ref_xml_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->ref))."'";
                $rsHide = mysqli_query($inmoconn,$query_rsHide) or die(mysqli_error() . '<hr>' . $query_rsHide);
                $row_rsHide = mysqli_fetch_assoc($rsHide);
                $totalRows_rsHide = mysqli_num_rows($rsHide);

                if ($row_rsHide['force_hide_prop'] == 1) {
                    $query .= "force_hide_prop = '1', \n";
                } else {
                    if ((int)$property->restrictions->website == 0) {
                        $query .= "force_hide_prop = '0', \n";
                    } else {
                        $query .= "force_hide_prop = '1', \n";
                    }
                }
                $query .= "activado_prop = '1', \n";
                $query .= "restr_web_prop = '".(int)$property->restrictions->website."', \n";
                $query .= "restr_nat_port_prop = '".(int)$property->restrictions->national_portals."', \n";
                $query .= "restr_int_port_prop = '".(int)$property->restrictions->international_portals."', \n";
                $query .= "id_habihub_prop = '".(int)$property->id."' \n";
                if ($in_database) {
                    $query .= "WHERE ref_xml_prop = '".(string)$property->ref."' AND xml_xml_prop = '".$_GET['p']."'";
                }

                $tagsHabihub = array();

                if (in_array('Key ready', (array)$property->tags->tag)) {array_push($tagsHabihub, 5);}
                if (in_array('Open views', (array)$property->tags->tag)) {array_push($tagsHabihub, 14);}
                if (in_array('Off plan', (array)$property->tags->tag)) {array_push($tagsHabihub, 6);}
                if (in_array('Beach', (array)$property->tags->tag)) {array_push($tagsHabihub, 2);}
                if (in_array('Golf', (array)$property->tags->tag)) {array_push($tagsHabihub, 3);}
                if (in_array('Village views', (array)$property->tags->tag)) {array_push($tagsHabihub, 11);}
                if (in_array('Mountain views', (array)$property->tags->tag)) {array_push($tagsHabihub, 15);}
                if (in_array('Sea views', (array)$property->tags->tag)) {array_push($tagsHabihub, 1);}
                if (in_array('First line', (array)$property->tags->tag)) {array_push($tagsHabihub, 8);}

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

                savePropertyData($query, $in_database, $property->features, $property->images, $property->plans, $property->videos, $property->views360, $property->documents, $tagsHabihub);
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

