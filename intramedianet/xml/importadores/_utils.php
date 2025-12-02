<?php

require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
// require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );
// require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

set_time_limit(0);

// Debug
if (!function_exists("_d")) {
    function _d($val) {
        echo "<pre>";
        print_r($val);
        echo "</pre>";
    }
}

// Guardar Log
if (!function_exists("logprop")) {
    function logprop($user, $id, $ref, $action) {
        global $database_inmoconn, $inmoconn;
        
        $query_rsProp = "INSERT INTO `properties_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '".$user."', '".$id."', '".$ref."', '".$action."', '".date("Y-m-d H:i:s")."')";
        $rsProp = mysqli_query($inmoconn,$query_rsProp) or die(mysqli_error());
    }
}

// Generar referencia
if (!function_exists("getRef")) {
    function getRef($pref) {
        global $database_inmoconn, $inmoconn;
        set_time_limit(0);
        $rnd_id = '';
        $rnd_id = rand(11111,99999);
        $rnd_id = ($pref != '')?$pref.'-'.$rnd_id:$rnd_id;
        
        $query_rsProperty = "SELECT id_prop FROM properties_properties WHERE referencia_prop = '".$rnd_id."' ";
        $rsProperty = mysqli_query($inmoconn,$query_rsProperty) or die(mysqli_error() . '<hr>' . $query_rsProperty);
        $row_rsProperty = mysqli_fetch_assoc($rsProperty);
        $totalRows_rsProperty = mysqli_num_rows($rsProperty);
        if ($totalRows_rsProperty > 0) {
            getRef($pref);
        } else {
            if ($rnd_id == '' && $rnd_id == null) {
                getRef($pref);
            } else {
                return $rnd_id;
            }
        }
    }
}

// Obtener Proveedor
if (!function_exists("getProveedor")) {
    function getProveedor($id) {
        global $database_inmoconn, $inmoconn;
        
        $query_rsproveedor = "SELECT * FROM xml WHERE id_xml = '" . $id . "'";
        $rsproveedor = mysqli_query($inmoconn,$query_rsproveedor) or die(mysqli_error());
        $row_rsproveedor = mysqli_fetch_assoc($rsproveedor);
        $totalRows_rsproveedor = mysqli_num_rows($rsproveedor);
        return $row_rsproveedor;
    }
}

// Comprobar si una propiedad existe
if (!function_exists("checkPropertyExits")) {
    function checkPropertyExits($ref, $prov) {
        global $database_inmoconn, $inmoconn, $propID, $propPrice;
        
        $query_rsPropertyExits = "SELECT * FROM properties_properties WHERE ref_xml_prop = '".mysqli_real_escape_string($inmoconn,trim($ref))."' AND xml_xml_prop = '".$prov."'";
        $rsPropertyExits = mysqli_query($inmoconn,$query_rsPropertyExits) or die(mysqli_error());
        $row_rsPropertyExits = mysqli_fetch_assoc($rsPropertyExits);
        $totalRows_rsPropertyExits = mysqli_num_rows($rsPropertyExits);
        if($totalRows_rsPropertyExits == 0) {
            return false;
        }
        $propID = $row_rsPropertyExits['id_prop'];
        $propPrice = $row_rsPropertyExits['preci_reducidoo_prop'];
        return true;
    }
}

// Obtener Desactivados
if (!function_exists("getDesactivados")) {
    function getDesactivados($id) {
        global $database_inmoconn, $inmoconn;
        
        $query_rsDesactivados = "SELECT id_prop FROM properties_properties WHERE xml_xml_prop = '".$id."' AND activado_prop = '0'";
        $rsDesactivados = mysqli_query($inmoconn,$query_rsDesactivados) or die(mysqli_error());
        $row_rsDesactivados = mysqli_fetch_assoc($rsDesactivados);
        $totalRows_rsDesactivados = mysqli_num_rows($rsDesactivados);
        $propDesc = array();
        do {
            if ($row_rsDesactivados['id_prop'] != '') {
                array_push($propDesc, $row_rsDesactivados['id_prop']);
            }
        } while ($row_rsDesactivados = mysqli_fetch_assoc($rsDesactivados));
        return $propDesc;
    }
}

// Desactivar inmuebles desactivados
if (!function_exists("setDesactivados")) {
    function setDesactivados($ids) {
        global $database_inmoconn, $inmoconn;
        if (!empty($ids)) {
            foreach ($ids as $key => $value) {
                if ($value != '') {
                    
                    $query_rsinm = "UPDATE properties_properties  SET activado_prop = '0' WHERE id_prop = '".$value."'";
                    $rsinm = mysqli_query($inmoconn,$query_rsinm) or die(mysqli_error());
                }
            }
        }
    }
}

// Desactivar todos los inmuebles
if (!function_exists("deacticateAllProps")) {
    function deacticateAllProps($prov) {
        global $database_inmoconn, $inmoconn;
        
        $query_rsinm = "UPDATE properties_properties  SET activado_prop = '0' WHERE xml_xml_prop = '".$prov."'";
        $rsinm = mysqli_query($inmoconn,$query_rsinm) or die(mysqli_error());
    }
}

// Obtener XML
if (!function_exists("getXML")) {
    function getXML($url) {
        set_time_limit(0);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");
        $data = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($data);
        return $xml;
    }
}

// Reporta un error de en importación
if (!function_exists("reportError")) {
    function reportError($id) {
        global $database_inmoconn, $inmoconn, $inline_errors,$fromMail;
        
        $query_rsProv = "SELECT * FROM xml WHERE id_xml = '" . $id . "'";
        $rsProv = mysqli_query($inmoconn,$query_rsProv) or die(mysqli_error());
        $row_rsProv = mysqli_fetch_assoc($rsProv);
        $totalRows_rsProv = mysqli_num_rows($rsProv);
        $subject = 'Error importing XML/Error importando XML: ' . $row_rsProv['site_xml'];
        $html = "<p>It is not possible to load the XML file with the url: <a href=\"" . $row_rsProv['xml_url_xml'] . "\" target=\"_blank\">" . $row_rsProv['xml_url_xml'] . "</a></p>";
        $html .= "<p>No es posible cargar el archivo XML con la url: <a href=\"" . $row_rsProv['xml_url_xml'] . "\" target=\"_blank\">" . $row_rsProv['xml_url_xml'] . "</a></p>";
        $html .= "<p><a href=\"https://" . $_SERVER['HTTP_HOST'] . "/intramedianet/xml/proveedores-form.php?id_xml=" . $row_rsProv['id_xml'] . "\" class=\"btn btn-primary\" target=\"_blank\">View agent/Ver agente</a></p>";
        if ($inline_errors == 1) {
            echo $html;
        } else {
            sendAppEmail($fromMail, '', '', '', $subject, $html);
        }
    }
}

// Procesamos pais
if (!function_exists("setCountry")) {
    function setCountry($country) {
        global $database_inmoconn, $inmoconn, $allLanguages, $language, $countryID;
        
        $query_rsCountry = "SELECT id_loc1, name_en_loc1 FROM properties_loc1 WHERE  LOWER(name_en_loc1) = LOWER('" .$country . "')";
        $rsCountry = mysqli_query($inmoconn,$query_rsCountry) or die(mysqli_error());
        $row_rsCountry = mysqli_fetch_assoc($rsCountry);
        $totalRows_rsCountry = mysqli_num_rows($rsCountry);
        if($totalRows_rsCountry == 0){
            $query = "INSERT INTO properties_loc1 SET ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "name_".$value."_loc1 = '" .$country . "'";
            }
            
            $rsCountryInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $countryID = $id;
            return trim($country);
        } else{
            $countryID = $row_rsCountry['id_loc1'];
            return $row_rsCountry['name_en_loc1'];
        }
    }
}

// Procesamos provincia
if (!function_exists("setProvince")) {
    function setProvince($province, $country) {
        global $database_inmoconn, $inmoconn, $allLanguages, $language, $provinceID, $newProvArray;
        $province = mysqli_real_escape_string($inmoconn,trim($province));
        
        $query_rsProvince = "SELECT id_loc2, name_en_loc2 FROM properties_loc2 WHERE  LOWER(name_en_loc2) = '" . strtolower($province) . "' AND loc1_loc2 = '" . $country . "'";
        $rsProvince = mysqli_query($inmoconn,$query_rsProvince) or die(mysqli_error());
        $row_rsProvince = mysqli_fetch_assoc($rsProvince);
        $totalRows_rsProvince = mysqli_num_rows($rsProvince);
        if($totalRows_rsProvince == 0){
            $query = "INSERT INTO properties_loc2 SET ";
            $query .= "loc1_loc2 = '".$country."', ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "name_".$value."_loc2 = '" . $province . "'";
            }
            
            $rsProvinceInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $provinceID = $id;
            array_push($newProvArray, $province);
            return trim($province);
        } else{
            $provinceID = $row_rsProvince['id_loc2'];
            return $row_rsProvince['name_en_loc2'];
        }
    }
}

// Procesamos costas
if (!function_exists("setCostaProp")) {
    function setCostaProp($costa) {
        global $database_inmoconn, $inmoconn, $allLanguages, $costaID, $newTypeArray, $autotraduccion;
        if (trim($costa) != '') {
            $costa = mysqli_real_escape_string($inmoconn,trim($costa));
            
            $query_rsCosta = "SELECT id_cst, coast_en_cst FROM properties_coast WHERE LOWER(coast_en_cst) = '" . strtolower($costa) . "'";
            $rsCosta = mysqli_query($inmoconn,$query_rsCosta) or die(mysqli_error());
            $row_rsCosta = mysqli_fetch_assoc($rsCosta);
            $totalRows_rsCosta = mysqli_num_rows($rsCosta);
            if($totalRows_rsCosta == 0){
                $query = "INSERT INTO properties_coast SET ";
                $x=0;
                foreach($allLanguages as $value) {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "coast_".$value."_cst = '".$costa."'";
                }
                
                $rsCostaInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                $id = @mysqli_insert_id($inmoconn);
                $costaID = $id;
                return trim($id);
            } else{
                $coastID = $row_rsCosta['id_cst'];
                return $row_rsCosta['id_cst'];
            }
        } else {
            return '';
        }
    }
}

// Procesamos ciudad
if (!function_exists("setTown")) {
    function setTown($town, $province, $provinceName) {
        global $database_inmoconn, $inmoconn, $allLanguages, $language, $townID, $newTownArray;
        $town = mysqli_real_escape_string($inmoconn,trim($town));
        
        $query_rsCity = "SELECT id_loc3, name_en_loc3 FROM properties_loc3 WHERE  LOWER(name_en_loc3) = '" . strtolower($town) . "' AND loc2_loc3 = '" . $province . "'";
        $rsCity = mysqli_query($inmoconn,$query_rsCity) or die(mysqli_error());
        $row_rsCity = mysqli_fetch_assoc($rsCity);
        $totalRows_rsCity = mysqli_num_rows($rsCity);
        if($totalRows_rsCity == 0){
            $query = "INSERT INTO properties_loc3 SET ";
            $query .= "loc2_loc3 = '".$province."', ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "name_".$value."_loc3 = '".$town."'";
            }
            
            $rsCityInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $townID = $id;
            array_push($newTownArray, $provinceName . ' -> ' . $town);
            return trim($town);
        } else{
            $townID = $row_rsCity['id_loc3'];
            return $row_rsCity['name_en_loc3'];
        }
    }
}

// Procesamos ciudad
if (!function_exists("setTown2")) {
    function setTown2($town, $province, $provinceName, $costa) {
        global $database_inmoconn, $inmoconn, $allLanguages, $language, $townID, $newTownArray;
        $town = mysqli_real_escape_string($inmoconn,trim($town));
        
        $query_rsCity = "SELECT id_loc3, name_en_loc3 FROM properties_loc3 WHERE  LOWER(name_en_loc3) = '" . strtolower($town) . "' AND loc2_loc3 = '" . $province . "'";
        $rsCity = mysqli_query($inmoconn,$query_rsCity) or die(mysqli_error());
        $row_rsCity = mysqli_fetch_assoc($rsCity);
        $totalRows_rsCity = mysqli_num_rows($rsCity);
        $costaID = '';
        if ($costa != '') {
            $costaID = setCostaProp($costa);
            if($totalRows_rsCity == 0){
                $query = "INSERT INTO properties_loc3 SET ";
                if ($costaID != '') {
                    $query .= "coast_loc3 = ".$costaID.", ";
                }
                $query .= "loc2_loc3 = '".$province."', ";
                $x=0;
                foreach($allLanguages as $value) {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "name_".$value."_loc3 = '".$town."'";
                }
                
                $rsCityInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
                $id = @mysqli_insert_id($inmoconn);
                $townID = $id;
                array_push($newTownArray, $provinceName . ' -> ' . $town);
                return trim($town);
            } else{
                $query = "UPDATE properties_loc3 SET ";
                $query .= "coast_loc3 = ".$costaID." ";
                $query .= "WHERE id_loc3 = '".$row_rsCity['id_loc3']."' ";
                
                $rsCityInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
                $townID = $row_rsCity['id_loc3'];
                return $row_rsCity['name_en_loc3'];
            }
        }
    }
}

// Procesamos zonas
if (!function_exists("setZone")) {
    function setZone($zone, $province, $provinceName, $town, $townName) {
        global $database_inmoconn, $inmoconn, $allLanguages, $language, $zoneID, $newZoneArray;
        if (trim($zone) == '') {
           $zone = trim($townName);
        }
        $zone = mysqli_real_escape_string($inmoconn,trim($zone));
        
        $query_rsZone = "SELECT id_loc4, name_en_loc4 FROM properties_loc4 WHERE  LOWER(name_en_loc4) = '" . strtolower($zone) . "' AND loc3_loc4 = '" . $town . "'";
        $rsZone = mysqli_query($inmoconn,$query_rsZone) or die(mysqli_error());
        $row_rsZone = mysqli_fetch_assoc($rsZone);
        $totalRows_rsZone = mysqli_num_rows($rsZone);
        if($totalRows_rsZone == 0){
            $query = "INSERT INTO properties_loc4 SET ";
            $query .= "loc3_loc4 = '".$town."', ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "name_".$value."_loc4 = '".$zone."'";
            }
            
            $rsZoneInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $zoneID = $id;
            array_push($newZoneArray, $provinceName . ' -> ' .  $townName . ' -> ' . $zone);
            return trim($zone);
        } else{
            $zoneID = $row_rsZone['id_loc4'];
            return $row_rsZone['name_en_loc4'];
        }
    }
}

// Procesamos tipos
if (!function_exists("setTypeProp")) {
    function setTypeProp($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $typeID, $newTypeArray, $autotraduccion;
        $type = mysqli_real_escape_string($inmoconn,trim($type));
        
        $query_rsType = "SELECT id_typ, types_en_typ FROM properties_types WHERE LOWER(TRIM(types_en_typ)) = '" . strtolower(trim($type)) . "'";
        $rsType = mysqli_query($inmoconn,$query_rsType) or die(mysqli_error() . '<hr>' . $query_rsType);
        $row_rsType = mysqli_fetch_assoc($rsType);
        $totalRows_rsType = mysqli_num_rows($rsType);
        if($totalRows_rsType == 0){
            $query = "INSERT INTO properties_types SET ";
            if ($autotraduccion == 1) {
               $query .= "types_en_typ = '".$type."'";
            } else {
                $x=0;
                foreach($allLanguages as $value) {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "types_".$value."_typ = '".$type."'";
                }
            }
            
            $rsTypeInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $typeID = $id;
            array_push($newTypeArray, $type);
            return trim($type);
        } else{
            $typeID = $row_rsType['id_typ'];
            return $row_rsType['types_en_typ'];
        }
    }
}

//Guardar propiedad
if (!function_exists("savePropertyData")) {
    function savePropertyData($query, $update, $features = array(), $images = array(), $plans = array(), $videos = array(), $views360 = array(), $documents = array(), $tags = array()) {
        global $database_inmoconn, $inmoconn, $in_database, $proveedor, $propID, $newFeatArray, $allLanguages, $numInsert, $numUpdated, $refInm, $actionUpdateProp, $autotraduccion;
        set_time_limit(0);
        // Añadimos el inmueble

        $rsPropertyInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
        if ($update) {
            $propertyID = $propID;
            logprop('1', $propertyID, $refInm, $actionUpdateProp);
            $numUpdated++;
        } else {
            $id = @mysqli_insert_id($inmoconn);
            $propertyID = $id;
            logprop('1', $propertyID, $refInm, '1');
            $numInsert++;
        }

        $query_rsDeletekPropFeature = "DELETE FROM properties_property_tag WHERE  property = '".$propertyID."'";
        $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
        if (!empty($tags)) {
            foreach($tags as $tag) {
                if ((string)$tag > 0) {
                    $query = "INSERT INTO properties_property_tag SET ";
                    $query .= "property = '".$propertyID."',";
                    $query .= "tag = '".$tag."'";
                    mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }
        }

        // Añadimos las features
        if (!$in_database || $proveedor['up_caracteristicas_xml'] == 1) {
            
            $query_rsDeletekPropFeature = "DELETE FROM properties_property_feature_priv WHERE  property = '".$propertyID."'";
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($features)) {
                foreach($features->feature as $feature) {
                    set_time_limit(0);
                    $feature = mysqli_real_escape_string($inmoconn,trim((string)$feature));
                    
                    $query_rsFeature = "SELECT id_feat, feature_en_feat FROM properties_features_priv WHERE  LOWER(feature_en_feat) = '".strtolower($feature)."'";
                    $rsFeature = mysqli_query($inmoconn,$query_rsFeature) or die(mysqli_error() . '<hr>' . $query_rsFeature );
                    $row_rsFeature = mysqli_fetch_assoc($rsFeature);
                    $totalRows_rsFeature = mysqli_num_rows($rsFeature);
                    if ($totalRows_rsFeature == 0) {
                        $query = "INSERT INTO properties_features_priv SET ";
                        if ($autotraduccion == 1) {
                           $query .= "feature_en_feat = '".$feature."'";
                        } else {
                            $x=0;
                            foreach($allLanguages as $value) {
                                if($x++ > 0){
                                    $query .= ", ";
                                }
                                $query .= "feature_".$value."_feat = '".$feature."'";
                            }
                        }
                        
                        $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        $id = @mysqli_insert_id($inmoconn);
                        $featureID = $id;
                        array_push($newFeatArray, $feature);
                    } else {
                        $featureID = $row_rsFeature['id_feat'];
                    }
                    if($featureID != ''){
                        $query = "INSERT INTO properties_property_feature_priv SET ";
                        $query .= "property = '".$propertyID."',";
                        $query .= "feature = '".$featureID."'";
                        
                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    }
                }
            }
        }
        // Añadimos las imagenes
        if (!$in_database || $proveedor['up_imagenes_xml'] == 1) {
            $imgOrd = 1;
            $query = "UPDATE properties_images SET ";
            $query .= "active_img = '0'  WHERE property_img = '".$propertyID."'";
            
            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $kyeroURLs = array(
                'https://kyero.cloudimg.io/crop/400x300/q82/',
                'https://kyero.cloudimg.io/s/crop/400x300/',
                '?NO_CHECKSUM&env=production',
                '?NO_CHECKSUM'
            );
            if (!empty($images->image->url)) {
                foreach($images->image as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, '', $image->url);
                    
                    $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$propertyID."' AND image_img2 = '".trim($image)."'";
                    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                    $row_rsImages = mysqli_fetch_assoc($rsImages);
                    $totalRows_rsImages = mysqli_num_rows($rsImages);
                    if($totalRows_rsImages == 0){
                        $query = "INSERT INTO properties_images SET ";
                        $query .= "property_img = '".$propertyID."',";
                        $query .= "image_img = '".trim($image)."', ";
                        $query .= "image_img2 = '".trim($image)."', ";
                        $query .= "active_img = '1', ";
                        $query .= "procesada_img = '0', ";
                        $query .= "order_img = '".$imgOrd."'";
                        
                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                    } else {
                        $query = "UPDATE properties_images SET ";
                        $query .= "active_img = '1',  ";
                        $query .= "order_img = '".$imgOrd."'";
                        $query .= "WHERE property_img = '".$propertyID."' AND image_img2 = '".trim($image)."'";
                        
                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, $row_rsImages['id_img']); // /intramedianet/includes/resources/translate.php
                    }
                    $imgOrd++;
                }
            }
            $queryDeleteDisabledImages = "DELETE FROM properties_images WHERE active_img = '0' AND property_img = '".$propertyID."' ";
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());

            // PLANOS
            $imgOrd = 1;
            $fileOrd = 1;
            $query = "UPDATE properties_planos SET ";
            $query .= "active_img = '0'  WHERE property_img = '".$propertyID."'";

            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $kyeroURLs = array(
                'https://kyero.cloudimg.io/crop/400x300/q82/',
                'https://kyero.cloudimg.io/s/crop/400x300/',
                '?NO_CHECKSUM&env=production',
                '?NO_CHECKSUM'
            );
            if (!empty($plans->plan->url)) {
                foreach($images->plans as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, '', $image->url);

                    $query_rsImages = "SELECT * FROM properties_planos WHERE property_img = '".$propertyID."' AND image_img2 = '".trim($image)."'";
                    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                    $row_rsImages = mysqli_fetch_assoc($rsImages);
                    $totalRows_rsImages = mysqli_num_rows($rsImages);
                    if($totalRows_rsImages == 0){
                        $query = "INSERT INTO properties_planos SET ";
                        $query .= "property_img = '".$propertyID."',";
                        $query .= "image_img = '".trim($image)."', ";
                        $query .= "image_img2 = '".trim($image)."', ";
                        $query .= "active_img = '1', ";
                        $query .= "procesada_img = '0', ";
                        $query .= "order_img = '".$imgOrd."'";

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                    } else {
                        $query = "UPDATE properties_planos SET ";
                        $query .= "active_img = '1',  ";
                        $query .= "order_img = '".$imgOrd."'";
                        $query .= "WHERE property_img = '".$propertyID."' AND image_img2 = '".trim($image)."'";

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, $row_rsImages['id_img']); // /intramedianet/includes/resources/translate.php
                    }
                    $imgOrd++;
                }
            }

            $queryDeleteFilePlans = "DELETE FROM properties_files WHERE property_fil = '".$propertyID."' AND file_fil LIKE 'http%' ";
            mysqli_query($inmoconn,$queryDeleteFilePlans) or die(mysqli_error());

            if (!empty($plans->plan->url)) {
                foreach($plans->plan as $image) {
                    if (!preg_match('/.pdf/i', $image->url)) {
                        set_time_limit(0);
                        $image = str_replace($kyeroURLs, '', $image->url);

                        $query_rsImages = "SELECT * FROM properties_planos WHERE property_img = '".$propertyID."' AND image_img2 = '".trim($image)."'";
                        $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                        $row_rsImages = mysqli_fetch_assoc($rsImages);
                        $totalRows_rsImages = mysqli_num_rows($rsImages);
                        if($totalRows_rsImages == 0){
                            $query = "INSERT INTO properties_planos SET ";
                            $query .= "property_img = '".$propertyID."',";
                            $query .= "image_img = '".trim($image)."', ";
                            $query .= "image_img2 = '".trim($image)."', ";
                            $query .= "active_img = '1', ";
                            $query .= "procesada_img = '0', ";
                            $query .= "order_img = '".$imgOrd."'";

                            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                            // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                        } else {
                            $query = "UPDATE properties_planos SET ";
                            $query .= "active_img = '1',  ";
                            $query .= "order_img = '".$imgOrd."'";
                            $query .= "WHERE property_img = '".$propertyID."' AND image_img2 = '".trim($image)."'";

                            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                            // generateThumbnails($image, $row_rsImages['id_img']); // /intramedianet/includes/resources/translate.php
                        }
                        $imgOrd++;
                    } else {
                        set_time_limit(0);
                        $query = "INSERT INTO properties_files SET ";
                        $query .= "property_fil = '".$propertyID."',";
                        $query .= "file_fil = '".trim($image->url)."', ";
                        $query .= "order_fil = '".$fileOrd."'";
                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        $fileOrd++;
                    }
                }
            }
            $queryDeleteDisabledImages = "DELETE FROM properties_planos WHERE active_img = '0' AND property_img = '".$propertyID."' ";
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());

            // Añadimos las videos
            $query_rsDeletekPropFeature = "DELETE FROM properties_videos WHERE  property_vid = '".$propertyID."'";
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($videos)) {
                $i = 1;
                foreach($videos->video_url as $video) {
                    set_time_limit(0);
                    if ($video != '' && $video != 'r') {
                        $video = explode('v=', $video);
                        $video = $video[1];
                        $query = "INSERT INTO properties_videos SET ";
                        $query .= "video_vid = '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/".$video."\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', ";
                        $query .= "order_vid = '".$i++."', ";
                        $query .= "property_vid = '".$propertyID."'";

                        $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    }
                }
            }

            // Añadimos las 360
            $query_rsDeletekPropFeature = "DELETE FROM properties_360 WHERE  property_360 = '".$propertyID."'";
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($views360)) {
                $i = 1;
                foreach($views360->virtual_tour_url as $view360) {
                    set_time_limit(0);
                    $query = "INSERT INTO properties_360 SET ";
                    $query .= "video_360 = '<iframe width=\"560\" height=\"315\" src=\"".$view360."\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', ";
                    $query .= "order_360 = '".$i++."', ";
                    $query .= "property_360 = '".$propertyID."'";

                    $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }

            // Añadimos las archivos
            $docOrd = 1;
            $queryDeleteFiles = "DELETE FROM properties_datos_files WHERE property_fil = '".$propertyID."' AND file_fil LIKE 'http%' ";
            mysqli_query($inmoconn,$queryDeleteFiles) or die(mysqli_error());
            if (!empty($documents)) {
                foreach($documents->document as $document) {
                    set_time_limit(0);
                    $query = "INSERT INTO properties_datos_files SET ";
                        $query .= "property_fil = '".$propertyID."',";
                        $query .= "file_fil = '".trim($document->url)."'";

                    $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    $docOrd++;
                }
            }

        }
    }
}

// Actualizar datos ultima importación del provvedor
if (!function_exists("updateProvStatus")) {
    function updateProvStatus($proveedor, $xml, $added) {
        global $database_inmoconn, $inmoconn;
        $query = "UPDATE xml SET ";
        $query .= "updated_xml = '".date("Y-m-d H:i:s")."',";
        $query .= "total_xml = '".$xml."',";
        $query .= "total_imp_xml = '".$added."'";
        $query .= "WHERE id_xml = '".$proveedor."'";
        
        mysqli_query($inmoconn,$query) or die(mysqli_error());
    }
}

// Ajustamos el orden de as imagenes
if (!function_exists("fixImagesOrder")) {
    function fixImagesOrder() {
        global $database_inmoconn, $inmoconn;
        
        $query_rsInmuebles = "SELECT * FROM `properties_images` GROUP BY property_img ORDER BY property_img";
        $rsInmuebles = mysqli_query($inmoconn,$query_rsInmuebles) or die(mysqli_error());
        $row_rsInmuebles = mysqli_fetch_assoc($rsInmuebles);
        $totalRows_rsInmuebles = mysqli_num_rows($rsInmuebles);
        if ($totalRows_rsInmuebles > 0) {
            do {
                $ord = 1;
                
                $query_rsImagenes = "SELECT * FROM `properties_images` WHERE property_img = ".$row_rsInmuebles['property_img']." ORDER BY order_img ASC";
                $rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
                $row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
                $totalRows_rsImagenes = mysqli_num_rows($rsImagenes);
                do {
                    
                    $query_rsUpdate1 = "UPDATE `properties_images` SET `order_img` = '".$ord++."' WHERE `id_img` = ".$row_rsImagenes['id_img']."";
                    $rsUpdate1 = mysqli_query($inmoconn,$query_rsUpdate1) or die(mysqli_error());
                } while ($row_rsImagenes = mysqli_fetch_assoc($rsImagenes));
            } while ($row_rsInmuebles = mysqli_fetch_assoc($rsInmuebles));
        }
    }
}

// Mostrar reporte
if (!function_exists("showReportImp")) {
    function showReportImp($num_xml, $num_ins, $num_upd, $desactv) {
        global $inline_errors, $proveedor;
        if ($inline_errors == 1) {
            $ret = '<ul class="stats-tabs">';
            $ret .= '<li><div>' . number_format(count($num_xml), 0, ',', '.') . ' <span>' . __('En el XML', true) . '</span></div></li>';
            $ret .= '<li><div>' . number_format($num_ins, 0, ',', '.') . ' <span>' . __('Añadidos', true) . '</span></div></li>';
            $ret .= '<li><div>' . number_format($num_upd, 0, ',', '.') . ' <span>' . __('Actualizados', true) . '</span></div></li>';
            $ret .= '<li><div>' . number_format(count($desactv), 0, ',', '.') . ' <span>' . __('Desactivados', true) . '</span></div></li>';
            $ret .= '<li><div>' . number_format($num_ins + $num_upd + count($desactv), 0, ',', '.') . ' <span>' . __('Total', true) . '</span></div></li>';
            $ret .= '</ul>';
            $ret .= '<div style="clear: both; display: block; padding: 10px 0;font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: bold;">';
            $ret .= __('Las imagenes se van a  descargar en segundo plano, los inmuebles irán apareciendo en la web una vez se generen las miniaturas. Esto puede llevar bastante tiempo.', true);
            $ret .= '</div>';
            echo $ret;
        } else {
            $ret = '<ul class="stats-tabs">';
            $ret .= '<li><b>' . $proveedor['site_xml'] . ' - </b>';

            $ret .= 'XML: ' . number_format(count($num_xml), 0, ',', '.') . ' <b>-</b> ';
            $ret .= __('Añadidos', true) . ': ' . number_format($num_ins, 0, ',', '.') . ' <b>-</b> ';
            $ret .= __('Actualizados', true) . ': ' . number_format($num_upd, 0, ',', '.') . ' <b>-</b> ';
            $ret .= __('Desactivados', true) . ': ' . number_format(count($desactv), 0, ',', '.') . ' <b>-</b> ';
            $ret .= __('Total', true) . ': ' . number_format($num_ins + $num_upd + count($desactv), 0, ',', '.') . ' ';
            $ret .= '</li>';
            $ret .= '</ul>';
            echo $ret;
        }
    }
}

// Enviar nuevos datos para mapping
if (!function_exists("sendMappingData")) {
    function sendMappingData() {
        global $newProvArray, $newTownArray, $newTypeArray, $newFeatArray, $fromMail, $textMailTempl, $mailColor;
        if ($newProvArray[0] != '' || $newTownArray[0] != '' || $newTypeArray[0] != '') {

            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
            $html = ob_get_contents();
            ob_end_clean();

            $body  = '';
            $body .= '<!-- Título -->';
            $body .= '<tr>';
                $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
                    $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                        $body .= '<h1 style="color: #222; font-size: 24px;">';
                            $body .= "New data to mapping / Nuevos datos para mapear";
                        $body .= '</h1>';
                        $body .= '<div style="color: #555; font-size: 16px;">';
                            if ($newProvArray[0] != '') {
                                $body .= '<p><b>Provinces / Provincias:</b><br>' . implode("<br>", $newProvArray) . '</p>';
                            }
                            if ($newTownArray[0] != '') {
                                $body .= '<p><b>Towns / Ciudades:</b><br>' . implode("<br>", $newTownArray) . '</p>';
                            }
                            if ($newTypeArray[0] != '') {
                                $body .= '<p><b>Types / Tipos:</b><br>' . implode("<br>", $newTypeArray) . '</p>';
                            }
                            // if ($newFeatArray[0] != '') {
                            //     $body .= '<p><b>Features / Características:</b><br>' . implode("<br>", $newFeatArray) . '</p>';
                            // }
                        $body .= '</div>';
                    $body .= '</div>';
                $body .= '</td>';
            $body .= '</tr>';

            $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
            $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
            $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';

            $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
            $html = preg_replace('/{CONTENT}/', $body , $html);
            $html = preg_replace('/{FOOTER}/', $footer, $html);
            $html = preg_replace('/{COLOR}/', $mailColor, $html);
            $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

            $subject = "New data to mapping / Nuevos datos para mapear | " . $_SERVER['HTTP_HOST'];


            sendAppEmail($fromMail, '', '', $fromMail, $subject, $html);
        }
    }
}


