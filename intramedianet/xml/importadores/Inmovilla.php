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
    $plantaID = '';
    $condID = '';
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
    if (!checkXMLInmovilla($xml)) {
        reportError($_GET['p']);
    } else { // Procesamos el xml

        deacticateAllProps($_GET['p']);


        $i = 1;

        foreach ($xml->propiedad as $property) {
            set_time_limit(0);

            // echo $i++ . ' | ';
            // El inmueble tiene los datos necesarios
            if (checkPropertyINMV($property)) {

                $propID = '';

                $in_database = checkPropertyExits($property->ref, $_GET['p']);

                $countryName = setCountry('Spain');
                $provinceName = setProvince((string)$property->provincia, $countryID);
                $townName = setTown((string)$property->ciudad, $provinceID, $provinceName);
                $zoneName = setZone((string)$property->zona, $provinceID, $provinceName, $townID, $townName);
                $typeName = setTypePropINMV($property->tipo_ofer);
                $plantaID = setPlantaPropINMV($property->planta);;
                $condID = setConditionPropINMV($property->conservacion);;
                $statusID = getStatusInmovilla((string)$property->accion, $property->conservacion);

                $query = "INSERT INTO properties_properties SET ";
                if ($in_database) {
                    $query = "UPDATE properties_properties SET ";
                }
                $query .= "id_inmovilla_prop = '".mysqli_real_escape_string($inmoconn,trim((int)$property->id))."', ";
                if (!$in_database) {
                    $query .= "referencia_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->ref))."', ";
                    $query .= "inserted_xml_prop = '".(string)$property->fechaact."', ";
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

                
                $precioCompra = (int)$property->precioinmo;
                $precioAlquiler = (int)$property->precioalq;

                if((int)$property->aconsultar == 1)
                {
                    //consultar precio
                    $precioCompra = $precioAlquiler = 0;
                }

                if ($statusID == 1 || $statusID == 2) 
                {
                    if (!$in_database || $proveedor['up_precio_xml'] == 1) {
                        $query .= "preci_reducidoo_prop = '".$precioCompra."', ";
                    }
                } else {
                    if (!$in_database || $proveedor['up_precio_xml'] == 1) {
                        $query .= "preci_reducidoo_prop = '".$precioAlquiler."', ";
                    }
                }


                if (!$in_database || $proveedor['up_m2_xml'] == 1) {
                    $query .= "m2_prop = '".(int)$property->m_cons."', ";
                }

                if (!$in_database || $proveedor['up_m2_t_xml'] == 1) {
                    $query .= "m2_parcela_prop = '".(int)$property->m_parcela."', ";
                }

                $query .= "m2_balcon_prop = '".(int)$property->m_terraza."', ";

                if (!$in_database || $proveedor['up_habitaciones_xml'] == 1) {
                    $query .= "habitaciones_prop = '".((int)$property->habdobles + (int)$property->habitaciones)."', ";
                }

                $query .= "destacado_prop = '".(int)$property->destacado."', ";  // Descoemnatr si quieren importar los destacados


                //la ficha de la propiedad tiene varios estados en inmovilla.
                 switch ((int)$property->estadoficha)  
                 {
                    case 7: //reservada
                        $query .= "reservado_prop = '1', ";
                        //Valores por defecto. 
                        $query .= "vendido_prop = '0', ";
                        $query .= "alquilado_prop = '0', ";
                    break;
                    case 2: //alquilada
                        $query .= "alquilado_prop = '1', ";
                        //Valores por defecto. 
                        $query .= "vendido_prop = '0', ";
                        $query .= "reservado_prop = '0', ";
                    break;
                    case 3: //vendida
                        $query .= "vendido_prop = '1', ";
                        //Valores por defecto. 
                        $query .= "alquilado_prop = '0', ";
                        $query .= "reservado_prop = '0', ";
                    break;
                    default:
                        //Valores por defecto. 
                        $query .= "vendido_prop = '0', ";
                        $query .= "alquilado_prop = '0', ";
                        $query .= "reservado_prop = '0', ";
                    break;
                }


                $query .= "construccion_prop = '".(int)$property->antiguedad."', ";

                if (!$in_database || $proveedor['up_aseos_xml'] == 1) {
                    $query .= "aseos_prop = '".(int)$property->banyos."', ";
                    $query .= "aseos2_prop = '".(int)$property->aseos."', ";
                }

                $lat = mysqli_real_escape_string($inmoconn,trim((float)$property->latitud));
                $long = mysqli_real_escape_string($inmoconn,trim((float)$property->altitud));
                if (($lat != '' && $lat != 0) && ($long != '' && $long != 0)) {
                    $query .= "lat_long_gp_prop = '".$lat.",".$long."', ";
                }

                if((int)$property->piscina_com == 0 && (int)$property->piscina_prop == 0) 
                {
                    $query .= "piscina_prop = NULL, ";
                }
                else 
                {
                    //Inmovilla permite tener piscina comunitaria y piscina privada al mismo tiempo. Se produce un error al insertar en nuestro sistema.
                    //Si tiene las 2 opciones nos vamos a quedar solamente con piscina_prop

                    if ((int)$property->piscina_prop != 0 && (int)$property->piscina_com != 0 ) 
                    {
                        $query .= "piscina_prop = '1', ";
                    }
                    else 
                    {
                        if ((int)$property->piscina_prop != 0) {
                            $query .= "piscina_prop = '1', ";
                        }
                        if ((int)$property->piscina_com != 0) {
                            $query .= "piscina_prop = '2', ";
                        }
                    }
                }

                $query .= "energia_prop = '".mysqli_real_escape_string($inmoconn,(string)$property->energialetra)."', ";

                if((int)$property->plaza_gara != 0)
                {
                    // <plaza_gara> Tipo de plaza
                    
                    // 0. sin garaje
                    // 1. Garaje opcional  -> parkin_prop = 2
                    // 2. garaje incluido -> parking_prop = 1

                    if((int)$property->plaza_gara == 2)
                    {
                        $query .= "parking_prop = 1, ";
                    }
                    else 
                    {
                        if((int)$property->plaza_gara == 1)
                        {
                            $query .= "parking_prop = 2, "; //parking opcional
                        }
                    }

                    // <nplazasparking> Numero de plazas
                    if((int)$property->nplazasparking > 0)
                    {
                        $query .= "plazas_garaje_prop = '".(int)$property->nplazasparking."' , ";
                    }
                    else 
                    {
                        $query .= "plazas_garaje_prop = NULL, ";
                    }
                }
                else 
                {
                    $query .= "plazas_garaje_prop = NULL, ";
                    $query .= "parking_prop = NULL, ";
                }

                $query .= "cp_prop = '".(int)$property->cp."', ";

                if (!$in_database || $proveedor['up_descripcion_xml'] == 1) {
                    $query .= "descripcion_es_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip1))."', ";
                    $query .= "titulo_es_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo1))."', ";

                    $query .= "descripcion_en_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip2))."', ";
                    $query .= "titulo_en_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo2))."', ";

                    $query .= "descripcion_de_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip3))."', ";
                    $query .= "titulo_de_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo3))."', ";

                    $query .= "descripcion_fr_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip4))."', ";
                    $query .= "titulo_fr_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo4))."', ";

                    $query .= "descripcion_nl_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip5))."', ";
                    $query .= "titulo_nl_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo5))."', ";

                    $query .= "descripcion_no_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip6))."', ";
                    $query .= "titulo_no_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo6))."', ";

                    $query .= "descripcion_ru_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip7))."', ";
                    $query .= "titulo_ru_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo7))."', ";

                    $query .= "descripcion_se_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip9))."', ";
                    $query .= "titulo_se_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo9))."', ";

                    $query .= "descripcion_fi_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip10))."', ";
                    $query .= "titulo_fi_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo10))."', ";

                    $query .= "descripcion_zh_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip11))."', ";
                    $query .= "titulo_zh_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo11))."', ";

                    $query .= "descripcion_pl_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->descrip17))."', ";
                    $query .= "titulo_pl_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->titulo17))."', ";
                }

                $query .= "distance_beach_prop = '".(int)$property->distmar."', ";
                $query .= "distance_beach_med_prop = 'Mts', ";

                $query .= "planta_prop = '".(int)$plantaID."', ";

                $query .= "estado_prop = '".(int)$condID."', ";

                $query .= "gastos_prop = '".(int)$property->gastos_com."', ";

                $query .= "vista360_prop = '".(string)$property->tour."', ";

                $energy = mysqli_real_escape_string($inmoconn,trim((string)$property->energialetra));
                if ($energy != '') {
                }
                $query .= "xml_xml_prop = '".$_GET['p']."', ";
                $query .= "ref_xml_prop = '".mysqli_real_escape_string($inmoconn,trim((string)$property->ref))."', ";
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

                $imagesProp = array();

                if ((int) $property->numfotos > 0) {
                    for ($r=1; $r <= $property->numfotos ; $r++) {
                        $n = 'foto' . $r;
                        array_push($imagesProp, (string)$property->$n);
                    }
                }

                $featuresINMV = array();

                if ((int)$property->salon == 1) { array_push($featuresINMV, 'Salón'); }
                if ((int)$property->adaptadominus == 1) { array_push($featuresINMV, 'Adaptado para minusválidos'); }
                if ((int)$property->airecentral == 1) { array_push($featuresINMV, 'Aire acondicionado central'); }
                if ((int)$property->aire_con == 1) { array_push($featuresINMV, 'Aire acondicionado'); }
                if ((int)$property->alarma == 1) { array_push($featuresINMV, 'Alarma'); }
                if ((int)$property->alarmaincendio == 1) { array_push($featuresINMV, 'Alarma incendio'); }
                if ((int)$property->alarmarobo == 1) { array_push($featuresINMV, 'Alarma robo'); }
                if ((int)$property->arma_empo == 1) { array_push($featuresINMV, 'Armarios empotrados'); }
                if ((int)$property->ascensor == 1) { array_push($featuresINMV, 'Ascensor'); }
                if ((int)$property->balcon == 1) { array_push($featuresINMV, 'Balcón'); }
                if ((int)$property->bar == 1) { array_push($featuresINMV, 'Bar'); }
                if ((int)$property->barbacoa == 1) { array_push($featuresINMV, 'Barbacoa'); }
                if ((int)$property->cajafuerte == 1) { array_push($featuresINMV, 'Caja fuerte'); }
                if ((int)$property->calefacentral == 1) { array_push($featuresINMV, 'Calefacción central'); }
                if ((int)$property->calefaccion == 1) { array_push($featuresINMV, 'Calefacción'); }
                if ((int)$property->chimenea == 1) { array_push($featuresINMV, 'Chimenea'); }
                if ((int)$property->descalcificador == 1) { array_push($featuresINMV, 'Descalcificador'); }
                if ((int)$property->despensa == 1) { array_push($featuresINMV, 'Despensa'); }
                if ((int)$property->diafano == 1) { array_push($featuresINMV, 'Diáfano'); }
                if ((int)$property->electro == 1) { array_push($featuresINMV, 'Electrodomesticos'); }
                if ((int)$property->esquina == 1) { array_push($featuresINMV, 'Esquina'); }
                if ((int)$property->galeria == 1) { array_push($featuresINMV, 'Galería'); }
                if ((int)$property->garajedoble == 1) { array_push($featuresINMV, 'Garaje doble'); }
                if ((int)$property->gimnasio == 1) { array_push($featuresINMV, 'Gimnasio'); }
                if ((int)$property->gasciudad == 1) { array_push($featuresINMV, 'Gas ciudad'); }
                if ((int)$property->hidromasaje == 1) { array_push($featuresINMV, 'Hidromasaje'); }
                if ((int)$property->jacuzzi == 1) { array_push($featuresINMV, 'Jacuzzi'); }
                if ((int)$property->lavanderia == 1) { array_push($featuresINMV, 'Lavandería'); }
                if ((int)$property->linea_tlf == 1) { array_push($featuresINMV, 'Teléfono'); }
                if ((int)$property->luminoso == 1) { array_push($featuresINMV, 'Luminoso'); }
                if ((int)$property->luz == 1) { array_push($featuresINMV, 'Luz'); }
                if ((int)$property->muebles == 1) { array_push($featuresINMV, 'Amueblado'); }
                if ((int)$property->parking == 1) { array_push($featuresINMV, 'Parking'); }
                if ((int)$property->patio == 1) { array_push($featuresINMV, 'Patio'); }
                if ((int)$property->preinstaacc == 1) { array_push($featuresINMV, 'Preinstalación aire acondicionado'); }
                if ((int)$property->primera_line == 1) { array_push($featuresINMV, 'Primera línea'); }
                if ((int)$property->puerta_blin == 1) { array_push($featuresINMV, 'Puerta blindada'); }
                if ((int)$property->satelite == 1) { array_push($featuresINMV, 'Satelite'); }
                if ((int)$property->sauna == 1) { array_push($featuresINMV, 'Sauna'); }
                if ((int)$property->solarium == 1) { array_push($featuresINMV, 'Solarium'); }
                if ((int)$property->sotano == 1) { array_push($featuresINMV, 'Sotano'); }
                if ((int)$property->buhardilla == 1) { array_push($featuresINMV, 'Buhardilla'); }
                if ((int)$property->pergola == 1) { array_push($featuresINMV, 'Pergola'); }
                if ((int)$property->tv == 1) { array_push($featuresINMV, 'TV'); }
                if ((int)$property->terraza == 1) { array_push($featuresINMV, 'Terraza'); }
                if ((int)$property->terrazaacris == 1) { array_push($featuresINMV, 'Terraza acristalada'); }
                if ((int)$property->todoext == 1) { array_push($featuresINMV, 'Todo exterior'); }
                if ((int)$property->trastero == 1) { array_push($featuresINMV, 'Trastero'); }
                if ((int)$property->urbanizacion == 1) { array_push($featuresINMV, 'Urbanización'); }
                if ((int)$property->video_port == 1) { array_push($featuresINMV, 'Video portero'); }
                if ((int)$property->cocina_inde == 1) { array_push($featuresINMV, 'Cocina independiente'); }
                if ((int)$property->rural == 1) { array_push($featuresINMV, 'Rural'); }
                if ((int)$property->costa == 1) { array_push($featuresINMV, 'Costa'); }
                if ((int)$property->vallado == 1) { array_push($featuresINMV, 'Vallado'); }
                if ((int)$property->autobuses == 1) { array_push($featuresINMV, 'Autobuses'); }
                if ((int)$property->centros_comerciales == 1) { array_push($featuresINMV, 'Centros comerciales'); }
                if ((int)$property->tranvia == 1) { array_push($featuresINMV, 'Tranvía'); }
                if ((int)$property->zonas_infantiles == 1) { array_push($featuresINMV, 'Zonas infantiles'); }
                if ((int)$property->colegios == 1) { array_push($featuresINMV, 'Colegios'); }
                if ((int)$property->arboles == 1) { array_push($featuresINMV, 'Arboles'); }
                if ((int)$property->hospitales == 1) { array_push($featuresINMV, 'Hospitales'); }
                if ((int)$property->tren == 1) { array_push($featuresINMV, 'Tren'); }
                if ((int)$property->metro == 1) { array_push($featuresINMV, 'Metro'); }
                if ((int)$property->golf == 1) { array_push($featuresINMV, 'Golf'); }
                if ((int)$property->vestuarios == 1) { array_push($featuresINMV, 'Vestuarios'); }
                if ((int)$property->vistasalmar == 1) { array_push($featuresINMV, 'Vistas al mar'); }
                if ((int)$property->exclu == 1) { array_push($featuresINMV, 'Exclusiva'); }
                if ((int)$property->montana == 1) { array_push($featuresINMV, 'Montaña'); }
                if ((int)$property->bombafriocalor == 1) { array_push($featuresINMV, 'Bomba frio calor'); }
                if ((int)$property->apartseparado == 1) { array_push($featuresINMV, 'Apartamento separado'); }

                // echo $query;
                // echo "<hr>";


                savePropertyDataINMV($query, $in_database, $featuresINMV, $imagesProp, (string)$property->video1);
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

        showReportImp($xml->propiedad, $numInsert, $numUpdated, getDesactivados($_GET['p']));
    }
}

