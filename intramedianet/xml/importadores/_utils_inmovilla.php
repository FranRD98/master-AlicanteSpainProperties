<?php

// Comprobamos si ha cargado el xml correctamente
if (!function_exists("checkXMLInmovilla")) {
    function checkXMLInmovilla($xml) {
        $first_id = $xml->propiedad->id;
        if ($first_id == '') {
            return false;
        }
        return true;
    }
}


// Comprobamos si la propiedad tiene los campos necesarios
if (!function_exists("checkPropertyINMV")) {
    function checkPropertyINMV($xml) {


        $first_id = (string)$xml->id;
        $ref = (string)$xml->ref;
        $price = (string)$xml->precioinmo;
        $price_freq = (string)$xml->accion;
        $town = (string)$xml->ciudad;
        $province = (string)$xml->provincia;

        return true;

        if (
            ($first_id) == '' ||
            ($ref) == '' ||
            ($price) == '' ||
            ($price_freq) == '' ||
            ($type) == '' ||
            ($town) == '' ||
            ($province) == ''
        ) {
            // echo "string";
            return false;
        }
        return true;
    }
}

// Obtener el status de la propiedad
if (!function_exists("getStatusInmovilla")) {
    function getStatusInmovilla($status, $conservacion) {
        global $statusID;
        switch (trim($status)) {
            case 'Vender':
                $statusID = "1";
                break;
            // case 'new_build':
            //     $statusID = "2";
            //     break;
            // case 'week':
            //     $statusID = "3";
            //     break;
            case 'Alquilar':
                $statusID = "4";
                break;
            default:
                $statusID = "1";
                break;
        }

        if($conservacion == "Obra Nueva") 
        {
            $statusID = "2";
        }

        return $statusID;
    }
}


// Procesamos tipos
if (!function_exists("setTypePropINMV")) {
    function setTypePropINMV($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $typeID, $newTypeArray, $autotraduccion;
        $type = mysqli_real_escape_string($inmoconn, trim($type));

        $query_rsType = "SELECT id_typ, types_es_typ FROM properties_types WHERE LOWER(types_es_typ) = '" . strtolower($type) . "'";
        $rsType = mysqli_query($inmoconn, $query_rsType) or die(mysqli_error());
        $row_rsType = mysqli_fetch_assoc($rsType);
        $totalRows_rsType = mysqli_num_rows($rsType);
        if($totalRows_rsType == 0){
            $query = "INSERT INTO properties_types SET ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "types_".$value."_typ = '".$type."'";
            }
            
            $rsTypeInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $typeID = $id;
            array_push($newTypeArray, $type);
            return trim($type);
        } else{
            $typeID = $row_rsType['id_typ'];
            return $row_rsType['types_es_typ'];
        }
    }
}


// Procesamos planta
if (!function_exists("setPlantaPropINMV")) {
    function setPlantaPropINMV($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $plantaID, $newTypeArray, $autotraduccion;
        $type = mysqli_real_escape_string($inmoconn, trim($type));
        
        $query_rsType = "SELECT id_plnt, planta_es_plnt FROM properties_planta WHERE LOWER(planta_es_plnt) = '" . strtolower($type) . "'";
        $rsType = mysqli_query($inmoconn,$query_rsType) or die(mysqli_error());
        $row_rsType = mysqli_fetch_assoc($rsType);
        $totalRows_rsType = mysqli_num_rows($rsType);
        if($totalRows_rsType == 0) {
            $query = "INSERT INTO properties_planta SET ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "planta_".$value."_plnt = '".$type."'";
            }
            
            $rsTypeInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $plantaID = $id;
            array_push($newTypeArray, $type);

            
            // return trim($type);
            return $plantaID;
        } 
        else
        {
            $plantaID = $row_rsType['id_plnt'];

            return $plantaID;
            // return $row_rsType['planta_es_plnt'];
        }
    }
}


// Procesamos condition
if (!function_exists("setConditionPropINMV")) {
    function setConditionPropINMV($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $condID, $newTypeArray, $autotraduccion;
        $type = mysqli_real_escape_string($inmoconn, trim($type));
        
        $query_rsType = "SELECT id_cond, condition_es_cond FROM properties_condition WHERE LOWER(condition_es_cond) = '" . strtolower($type) . "'";
        $rsType = mysqli_query($inmoconn,$query_rsType) or die(mysqli_error());
        $row_rsType = mysqli_fetch_assoc($rsType);
        $totalRows_rsType = mysqli_num_rows($rsType);
        if($totalRows_rsType == 0){
            $query = "INSERT INTO properties_condition SET ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "condition_".$value."_cond = '".$type."'";
            }
            
            $rsTypeInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $condID = $id;
            array_push($newTypeArray, $type);
            return trim($type);
        } else{
            $condID = $row_rsType['id_cond'];
            return $row_rsType['condition_es_cond'];
        }
    }
}


//Guardar propiedad
if (!function_exists("savePropertyDataINMV")) {
    function savePropertyDataINMV($query, $update, $features, $images, $video) {
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

        if ($video != '') {

            $query_rsDeletekPropFeature = "DELETE FROM properties_videos WHERE  property_vid = '".$propertyID."'";
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());

            
            $query_rsVideos = "INSERT INTO `properties_videos` SET `properties_videos`.`property_vid` = '".$propertyID."'  , `properties_videos`.`video_vid` = '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/".mysqli_real_escape_string($inmoconn,$video)."\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',  `properties_videos`.`order_vid` = '1';";
            $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
        }

        // Añadimos las features
        if (!$in_database || $proveedor['up_caracteristicas_xml'] == 1) {
            
            $query_rsDeletekPropFeature = "DELETE FROM properties_property_feature_priv WHERE  property = '".$propertyID."'";
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($features)) {
                foreach($features as $feature) {
                    set_time_limit(0);
                    $feature = mysqli_real_escape_string($inmoconn,trim((string)$feature));
                    
                    $query_rsFeature = "SELECT id_feat, feature_es_feat FROM properties_features_priv WHERE  LOWER(feature_es_feat) = '".strtolower($feature)."'";
                    $rsFeature = mysqli_query($inmoconn,$query_rsFeature) or die(mysqli_error() . '<hr>' . $query_rsFeature );
                    $row_rsFeature = mysqli_fetch_assoc($rsFeature);
                    $totalRows_rsFeature = mysqli_num_rows($rsFeature);
                    if ($totalRows_rsFeature == 0) {
                        $query = "INSERT INTO properties_features_priv SET ";
                        $x=0;
                        foreach($allLanguages as $value) {
                            if($x++ > 0){
                                $query .= ", ";
                            }
                            $query .= "feature_".$value."_feat = '".$feature."'";
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
            $query .= "active_img = '0' ";
            "WHERE property_img = '".$propertyID."'";
            
            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $kyeroURLs = array(
                'https://kyero.cloudimg.io/crop/400x300/q82/',
                'https://kyero.cloudimg.io/s/crop/400x300/',
                '?NO_CHECKSUM&env=production',
                '?NO_CHECKSUM'
            );
            if (!empty($images)) {
                foreach($images as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, '', $image);
                    
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
        }
    }
}
