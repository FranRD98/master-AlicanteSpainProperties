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
    if (!checkXMLREDSP($xml)) {
        reportError($_GET['p']);
    } else { // Procesamos el xml

        deacticateAllProps($_GET['p']);

        // Obtenemos laversión del xml kyero
        $kyero_version = 3;

        $i = 1;

        foreach ($xml->property as $property) {
            set_time_limit(0);
            // echo $i++ . ' | ';
            // El inmueble tiene los datos necesarios
            if (checkPropertyREDSP($property)) {

                $typeValue = ($kyero_version == '3')?(string)$property->type:(string)$property->type->en;

                $propID = '';

                $in_database = checkPropertyExits($property->ref, $_GET['p']);

                $countryName = (empty((string)$property->country)) ? setCountry('Spain') : setCountry((string)$property->country);
                $provinceName = setProvince((string)$property->address->province, $countryID);
                $townName = setTown2((string)$property->address->town, $provinceID, $provinceName, (string)$property->costa);
                $zoneName = setZone((string)$property->address->location_detail_1, $provinceID, $provinceName, $townID, $townName);
                $typeName = setTypeProp((string)$property->type);
                $statusID = getStatusKyero((string)$property->price_freq, (string)$property->new_build);

                $refInm = getRef($proveedor['ref_prefix_xml']);

                if ($refInm == '') {
                    $refInm = getRef($proveedor['ref_prefix_xml']);
                }

                $query = "INSERT INTO properties_properties SET ";
                if ($in_database) {
                    $query = "UPDATE properties_properties SET ";
                }
                if (!$in_database) {
                    $query .= "referencia_prop = '" . mysqli_real_escape_string($inmoconn, trim($refInm)) . "', ";
                    $query .= "inserted_xml_prop = '" . date("Y-m-d H:i:s") . "', ";
                }
                if (!$in_database || $proveedor['up_ciudad_xml'] == 1) {
                    $query .= "localidad_prop = '" . $zoneID . "', ";
                }
                if (!$in_database || $proveedor['up_operacion_xml'] == 1) {
                    $query .= "operacion_prop = '" . $statusID . "', ";
                }
                if (!$in_database || $proveedor['up_tipo_xml'] == 1) {
                    $query .= "tipo_prop = '" . $typeID . "', ";
                }
                if (!$in_database || $proveedor['up_precio_xml'] == 1) {
                    $query .= "preci_reducidoo_prop = '" . (int)$property->price . "', ";
                }
                if (!$in_database || $proveedor['up_m2_xml'] == 1) {
                    $query .= "m2_prop = '" . (int)$property->surface_area->surface_area->built_m2 . "', ";
                    $query .= "m2_utiles_prop = '" . (int)$property->surface_area->usable_living_area_m2 . "', ";
                    $query .= "m2_balcon_prop = '" . (int)$property->surface_area->terrace_m2 . "', ";
                    $query .= "m2_solarium_prop = '" . (int)$property->surface_area->solarium_area_m2 . "', ";
                    $query .= "garden_m2_prop = '" . (int)$property->surface_area->garden_m2 . "', ";
                }
                if (!$in_database || $proveedor['up_m2_t_xml'] == 1) {
                    $query .= "m2_parcela_prop = '" . (int)$property->surface_area->plot_m2 . "', ";
                }
                if (!$in_database || $proveedor['up_habitaciones_xml'] == 1) {
                    $query .= "habitaciones_prop = '" . (int)$property->beds . "', ";
                }
                if (!$in_database || $proveedor['up_aseos_xml'] == 1) {
                    $query .= "aseos_prop = '" . (int)$property->baths . "', ";
                }
                if (!$in_database || $proveedor['up_pool_t_xml'] == 1) {
                    $piscina  = '';
                    if ((int)$property->pools->pool == 1) {
                        $piscina = "piscina_prop = '1', ";
                    }
                    if ((int)$property->pools->communal_pool == 1) {
                        $piscina = "piscina_prop = '2', ";
                    }
                    if ((int)$property->pools->private_pool == 1) {
                        $piscina = "piscina_prop = '3', ";
                    }
                    if ((int)$property->pools->pool == 1 || (int)$property->pools->communal_pool == 1 || (int)$property->pools->private_pool == 1) {
                        $query .= $piscina;
                    }
                }
                if (!$in_database || $proveedor['up_descripcion_xml'] == 1) 
                {
                   foreach($allLanguages as $value)
                   {
                       if ($value == 'se') {
                           $query .= "descripcion_" . $value . "_prop = '" . mysqli_real_escape_string($inmoconn, trim((string)$property->desc->sv)) . "', ";
                           if ($property->title->sv != '')
                           {
                                $query .= "titulo_" . $value . "_prop = '" . mysqli_real_escape_string($inmoconn, trim((string)$property->title->sv)) . "', "; //títulos de las propiedades
                           }
                       } else {
                           $query .= "descripcion_" . $value . "_prop = '" . mysqli_real_escape_string($inmoconn, trim((string)$property->desc->$value)) . "', ";
                           if ($property->title->$value != '')
                           {
                                $query .= "titulo_" . $value . "_prop = '" . mysqli_real_escape_string($inmoconn, trim((string)$property->title->$value)) . "', "; //títulos de las propiedades
                           }
                       }
                   }
                }

                $query .= "construccion_prop = '" .  (int)$property->year_build  . "', ";
                $query .= "entraga_date_prop = '" .  (string)$property->delivery_date  . "', ";

                $query .= "dev_ref_prop = '" .  (string)$property->development_ref  . "', ";

                $query .= "planta_prop = '" .  (int)$property->floor  . "', ";
                $query .= "plantas_prop = '" .  (int)$property->number_of_floors  . "', ";

                $address = (string)$property->address->address_detail . ', ' . (string)$property->address->address_number . ', ' . (string)$property->address->postal_code . ', ' . (string)$property->address->town . ', ' . (string)$property->address->province . '';
                $query .= "direccion_prop = '" . mysqli_real_escape_string($inmoconn, $address) . "', ";
                $query .= "cp_prop = '" . (string)$property->address->postal_code . "', ";

                switch ((string)$property->orientation) {
                    case 'North':
                        $orientation = 'o-n';
                        break;
                    case 'South':
                        $orientation = 'o-s';
                        break;
                    case 'East':
                        $orientation = 'o-e';
                        break;
                    case 'West':
                        $orientation = 'o-o';
                        break;
                    case 'SouthEast':
                        $orientation = 'o-se';
                        break;
                    case 'SouthWest':
                        $orientation = 'o-so';
                        break;
                    case 'NorthEast':
                        $orientation = 'o-ne';
                        break;
                    case 'NorthWest':
                        $orientation = 'o-no';
                        break;
                }
                
                if ((int)$property->distances->distance_to_beach_m > 0) {
                    $query .= "distance_beach_prop = '" . (int)$property->distances->distance_to_beach_m . "', ";
                    $query .= "distance_beach_med_prop = 'Mts', ";
                }
                if ((int)$property->distances->distance_airport_m > 0) {
                    $query .= "distance_airport_prop = '" . (int)$property->distances->distance_airport_m . "', ";
                    $query .= "distance_airport_med_prop = 'Mts', ";
                }
                if ((int)$property->distances->distance_golf_m > 0) {
                    $query .= "distance_golf_prop = '" . (int)$property->distances->distance_golf_m . "', ";
                    $query .= "distance_golf_med_prop = 'Mts', ";
                }
                if ((int)$property->distances->distance_amenities_m > 0) {
                    $query .= "distance_amenities_prop = '" . (int)$property->distances->distance_amenities_m . "', ";
                    $query .= "distance_amenities_med_prop = 'Mts', ";
                }

                $query .= "restr_man_contr_prop = '". (int)$property->mandatory_contract ."', ";
                $query .= "restr_web_prop = '". (int)$property->website ."', ";
                $query .= "restr_nat_port_prop = '". (int)$property->national_portals ."', ";
                $query .= "restr_int_port_prop = '". (int)$property->international_portals ."', ";
                $query .= "restr_social_prop = '". (int)$property->social_networks ."', ";
                $query .= "restr_int_cli_prop = '". (int)$property->only_intl_clients ."', ";

                $lat = mysqli_real_escape_string($inmoconn, trim((float)$property->location->latitude));
                $long = mysqli_real_escape_string($inmoconn, trim((float)$property->location->longitude));
                if (($lat != '' && $lat != 0) && ($long != '' && $long != 0)) {
                    $query .= "lat_long_gp_prop = '" . $lat . "," . $long . "', ";
                }
                $energy = mysqli_real_escape_string($inmoconn, trim((string)$property->energy_rating->consumption));
                if ($energy != '') {
                    $query .= "energia_prop = '" . $energy . "', ";
                }
                $emissions = mysqli_real_escape_string($inmoconn, trim((string)$property->energy_rating->emissions));
                if ($emissions != '') {
                    $query .= "emisiones_prop = '" . $emissions . "', ";
                }
                $query .= "xml_xml_prop = '" . $_GET['p'] . "', ";
                $query .= "ref_xml_prop = '" . mysqli_real_escape_string($inmoconn, trim((string)$property->ref)) . "', ";
                $query .= "url_xml_prop = '" . mysqli_real_escape_string($inmoconn, trim((string)$property->url->en)) . "', ";
                if ((int)$property->website == 1) {
                    $query .= "force_hide_prop = '1', ";
                }
                $query .= "activado_prop = '1' ";
                if ($in_database) {
                    $query .= "WHERE ref_xml_prop = '" . (string)$property->ref . "' AND xml_xml_prop = '" . $_GET['p'] . "'";
                }

                // Features
                if ((int)$property->features->Air_Conditioning == 1) { $property->extra_features->feature[] = 'Air conditioning'; }
                if ((int)$property->features->Appliances == 1) { $property->extra_features->feature[] = 'Appliances'; }
                if ((int)$property->features->Armored_Door == 1) { $property->extra_features->feature[] = 'Armored door'; }
                if ((int)$property->features->bbq == 1) { $property->extra_features->feature[] = 'Barbecue'; }
                if ((int)$property->features->corner == 1) { $property->extra_features->feature[] = 'Corner'; }
                if ((int)$property->features->coworking == 1) { $property->extra_features->feature[] = 'Coworking'; }
                if ((int)$property->features->domotics == 1) { $property->extra_features->feature[] = 'Domotics'; }
                if ((int)$property->features->electric_blinds == 1) { $property->extra_features->feature[] = 'Electric blinds'; }
                if ((int)$property->features->furnished == 1) { $property->extra_features->feature[] = 'Furnished'; }
                if ((int)$property->features->games_room == 1) { $property->extra_features->feature[] = 'Games room'; }
                if ((int)$property->features->garden == 1) { $property->extra_features->feature[] = 'Garden'; }
                if ((int)$property->features->gated == 1) { $property->extra_features->feature[] = 'Gated'; }
                if ((int)$property->features->gym == 1) { $property->extra_features->feature[] = 'Gym'; }
                if ((int)$property->features->heating == 1) { $property->extra_features->feature[] = 'Heating'; }
                if ((int)$property->features->jacuzzi == 1) { $property->extra_features->feature[] = 'Jacuzzi'; }
                if ((int)$property->features->laundry_room == 1) { $property->extra_features->feature[] = 'Laundry room'; }
                if ((int)$property->features->lift == 1) { $property->extra_features->feature[] = 'lift'; }
                if ((int)$property->features->patio == 1) { $property->extra_features->feature[] = 'Patio'; }
                if ((int)$property->features->safe_box == 1) { $property->extra_features->feature[] = 'Safe box'; }
                if ((int)$property->features->solarium == 1) { $property->extra_features->feature[] = 'Solarium'; }
                if ((int)$property->features->spa == 1) { $property->extra_features->feature[] = 'Spa'; }
                if ((int)$property->features->storage == 1) { $property->extra_features->feature[] = 'Storage'; }

                $tagsREDSP = array();

                if ((int)$property->key_ready == 1) { array_push($tagsREDSP, 16); }
                if ((int)$property->off_plan == 1) { array_push($tagsREDSP, 6); }
                if ((int)$property->category->golf == 1) { array_push($tagsREDSP, 3); }
                if ((int)$property->category->beach == 1) { array_push($tagsREDSP, 2); }
                if ((int)$property->category->countryside == 1) { array_push($tagsREDSP, 7); }
                if ((int)$property->category->first_line == 1) { array_push($tagsREDSP, 8); }
                if ((int)$property->category->urban == 1) { array_push($tagsREDSP, 9); }
                if ((int)$property->views->sea_views == 1) { array_push($tagsREDSP, 1); }
                if ((int)$property->views->village_views == 1) { array_push($tagsREDSP, 11); }
                if ((int)$property->views->garden_views == 1) { array_push($tagsREDSP, 12); }
                if ((int)$property->views->pool_views == 1) { array_push($tagsREDSP, 13); }
                if ((int)$property->views->open_views == 1) { array_push($tagsREDSP, 14); }
                if ((int)$property->views->mountain_views == 1) { array_push($tagsREDSP, 15); }

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
                savePropertyData($query, $in_database, $property->extra_features, $property->images, $tagsREDSP);
                if ($desactivar_desactivados == 1) {
                    setDesactivados($propiedades_desactivadas);
                }
            }
        }
        updateProvStatus($_GET['p'], (int)count($xml->property), (int)$numInsert + (int)$numUpdated);
        fixImagesOrder();
        sendMappingData();

        $query_rsPropsDel = "SELECT id_prop, referencia_prop FROM properties_properties WHERE xml_xml_prop = '" . $_GET['p'] . "' AND activado_prop = 0";
        $rsPropsDel = mysqli_query($inmoconn,$query_rsPropsDel) or die(mysqli_error() . '<hr>' . $query_rsPropsDel);
        $row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel);
        $totalRows_rsPropsDel = mysqli_num_rows($rsPropsDel);

        if ($totalRows_rsPropsDel > 0) {

            do {

                $query_rsXMLfea = "DELETE FROM properties_property_feature_priv WHERE property = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . '<hr>' . $query_rsXMLfea);


                $query_rsXMLfea = "DELETE FROM properties_property_tag WHERE property = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . '<hr>' . $query_rsXMLfea);


                $query_rsXMLfea = "DELETE FROM properties_360 WHERE property_360 = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


                $query_rsXMLfea = "DELETE FROM properties_videos WHERE property_vid = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


                $query_rsXMLfea = "DELETE FROM properties_log WHERE prop_id_log = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


                $query_rsXMLfea = "DELETE FROM properties_log_2 WHERE prop_id_log = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());

                // logprop('0', $row_rsPropsDel['id_prop'], $row_rsPropsDel['referencia_prop'], '5');

                if ($expFotoCasa == 1) {
                    include_once($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/FotocasaAPI.php');

                    $result = FotocasaAPI::getPublicationProperty($fotocasaDatos["api_key"]);
                    $result = json_decode($result,1);
                    foreach ( $result as $key => $prop) {
                        if( $prop["ExternalId"] == $row_rsPropsDel['id_prop'] ) {
                            $result = FotocasaAPI::deletePropertyByPortal( (int)$row_rsPropsDel['id_prop'], 1, $fotocasaDatos["api_key"]);
                            $_SESSION['fc_status'] = $result;
                        }
                    }
                }

                $query_rsXML = "SELECT * FROM properties_images WHERE property_img = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error() . '<hr>' . $query_rsXML);
                $row_rsXML = mysqli_fetch_assoc($rsXML);
                $totalRows_rsXML = mysqli_num_rows($rsXML);

                do {

                    array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/" . $row_rsXML['id_img'] . "_*"));


                    $query_rsDelIMG = "DELETE FROM properties_images WHERE id_img = '" . $row_rsXML['id_img'] . "'";
                    $rsDelIMG = mysqli_query($inmoconn,$query_rsDelIMG) or die(mysqli_error() . '<hr>' . $query_rsDelIMG);

                } while ($row_rsXML = mysqli_fetch_assoc($rsXML));

                $query_rsXMLprop = "DELETE FROM properties_properties WHERE id_prop = '" . $row_rsPropsDel['id_prop'] . "'";
                $rsXMLprop = mysqli_query($inmoconn, $query_rsXMLprop) or die(mysqli_error() . '<hr>' . $query_rsXMLprop);

            } while ($row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel));

            array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));

        }

        showReportImp($xml->property, $numInsert, $numUpdated, getDesactivados($_GET['p']));
    }
}

