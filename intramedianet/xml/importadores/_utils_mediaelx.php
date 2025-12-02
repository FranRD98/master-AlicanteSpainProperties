<?php

// Comprobamos si ha cargado el xml correctamente
if (!function_exists("checkXMLmediaelx")) {
    function checkXMLmediaelx($xml) {
        $kyero_version = $xml->xml_mediaelx->feed_version;
        $first_id = $xml->property->id;
        if ($kyero_version == '' || $first_id == '') {
            return false;
        }
        return true;
    }
}

// Comprobamos si la propiedad tiene los campos necesarios
if (!function_exists("checkPropertyMediaelx")) {
    function checkPropertyMediaelx($xml) {
        global $kyero_version;
        $first_id = (string)$xml->id;
        $ref = (string)$xml->ref;
        $price = (string)$xml->price;
        $price_freq = (string)$xml->price_freq;
        if ($kyero_version == '3') {
            $type = (string)$xml->type;
        } else {
            $type = (string)$xml->type->en;
        }
        $town = $xml->town;
        $province = $xml->province;
        if (
            trim($first_id) == '' ||
            trim($ref) == '' ||
            trim($price) == '' ||
            trim($price_freq) == '' ||
            trim($type) == '' ||
            trim($town) == '' ||
            trim($province) == ''
        ) {
            return false;
        }
        return true;
    }
}

// Obtener el status de la propiedad
if (!function_exists("getStatusMediaelx")) {
    function getStatusMediaelx($status, $new_build) {
        global $statusID;
        switch (trim($status)) {
            case 'sale':
                $statusID = "1";
                break;
            case 'new_build':
                $statusID = "2";
                break;
            case 'week':
                $statusID = "3";
                break;
            case 'month':
                $statusID = "4";
                break;
            default:
                $statusID = "1";
                break;
        }
        if ($new_build == '1') {
            $statusID = "2";
        }
        return $statusID;
    }
}

// Procesamos pool
if (!function_exists("setPoolProp")) {
    function setPoolProp($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $poolID, $newTypeArray, $autotraduccion;

        if ( $type['en'] == '' ) {
            return null;
        }
        
        $query_rsPool = "SELECT id_pl, pool_en_pl FROM properties_pool WHERE LOWER(pool_en_pl) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$type['en']))) . "'";
        $rsPool = mysqli_query($inmoconn,$query_rsPool) or die(mysqli_error() . '<hr>' . $query_rsPool);
        $row_rsPool = mysqli_fetch_assoc($rsPool);
        $totalRows_rsPool = mysqli_num_rows($rsPool);
        if($totalRows_rsPool == 0){
            $query = "INSERT INTO properties_pool SET ";
            $x=0;
            foreach($type as $key => $value) {
                if ((string)$value != '') {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "pool_".$key."_pl = '".mysqli_real_escape_string($inmoconn,trim((string)$value))."'";
                }
            }
            
            $rsPoolInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $poolID = (int)$id;
            // array_push($newTypeArray, $type);
            return trim($poolID);
        } else{
            $poolID = (int)$row_rsPool['id_pl'];
            return $poolID;
        }
    }
}

// Procesamos parking
if (!function_exists("setParkingProp")) {
    function setParkingProp($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $parkingID, $newTypeArray, $autotraduccion;

        if ( $type['en'] == '' ) {
            return null;
        }
        
        $query_rsparking = "SELECT id_prk, parking_en_prk FROM properties_parking WHERE LOWER(parking_en_prk) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$type['en']))) . "'";
        $rsparking = mysqli_query($inmoconn,$query_rsparking) or die(mysqli_error() . '<hr>' . $query_rsparking);
        $row_rsparking = mysqli_fetch_assoc($rsparking);
        $totalRows_rsparking = mysqli_num_rows($rsparking);
        if($totalRows_rsparking == 0){
            $query = "INSERT INTO properties_parking SET ";
            $x=0;
            foreach($type as $key => $value) {
                if ((string)$value != '') {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "parking_".$key."_prk = '".mysqli_real_escape_string($inmoconn,trim((string)$value))."'";
                }
            }
            
            $rsparkingInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $parkingID = (int)$id;
            // array_push($newTypeArray, $type);
            return trim($parkingID);
        } else{
            $parkingID = (int)$row_rsparking['id_prk'];
            return $parkingID;
        }
    }
}

// Procesamos kitchens
if (!function_exists("setKitchensProp")) {
    function setKitchensProp($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $kitchensID, $newTypeArray, $autotraduccion;

        if ( $type['en'] == '' ) {
            return null;
        }
        
        $query_rskitchen = "SELECT id_kchn, kitchen_en_kchn FROM properties_kitchen WHERE LOWER(kitchen_en_kchn) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$type['en']))) . "'";
        $rskitchen = mysqli_query($inmoconn,$query_rskitchen) or die(mysqli_error() . '<hr>' . $query_rskitchen);
        $row_rskitchen = mysqli_fetch_assoc($rskitchen);
        $totalRows_rskitchen = mysqli_num_rows($rskitchen);
        if($totalRows_rskitchen == 0){
            $query = "INSERT INTO properties_kitchen SET ";
            $x=0;
            foreach($type as $key => $value) {
                if ((string)$value != '') {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "kitchen_".$key."_kchn = '".mysqli_real_escape_string($inmoconn,trim((string)$value))."'";
                }
            }
            
            $rskitchenInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $kitchensID = (int)$id;
            // array_push($newTypeArray, $type);
            return trim($kitchensID);
        } else{
            $kitchensID = (int)$row_rskitchen['id_kchn'];
            return $kitchensID;
        }
    }
}

// Procesamos conditions
if (!function_exists("setConditionProp")) {
    function setConditionProp($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $conditionID, $newTypeArray, $autotraduccion;

        if ( $type['en'] == '' ) {
            return null;
        }
        
        $query_rsCondition = "SELECT id_cond, condition_en_cond FROM properties_condition WHERE LOWER(condition_en_cond) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$type['en']))) . "'";
        $rsCondition = mysqli_query($inmoconn,$query_rsCondition) or die(mysqli_error() . '<hr>' . $query_rsCondition);
        $row_rsCondition = mysqli_fetch_assoc($rsCondition);
        $totalRows_rsCondition = mysqli_num_rows($rsCondition);
        if($totalRows_rsCondition == 0){
            $query = "INSERT INTO properties_condition SET ";
            $x=0;
            foreach($type as $key => $value) {
                if ((string)$value != '') {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "condition_".$key."_cond = '".mysqli_real_escape_string($inmoconn,trim((string)$value))."'";
                }
            }
            
            $rsConditionInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $conditionID = (int)$id;
            // array_push($newTypeArray, $type);
            return trim($conditionID);
        } else{
            $conditionID = (int)$row_rsCondition['id_cond'];
            return $conditionID;
        }
    }
}

// Procesamos floor
if (!function_exists("setFloorProp")) {
    function setFloorProp($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $floorID, $newTypeArray, $autotraduccion;

        if ( $type['en'] == '' ) {
            return null;
        }
        
        $query_rsFloor = "SELECT id_plnt, planta_en_plnt FROM properties_planta WHERE LOWER(planta_en_plnt) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$type['en']))) . "'";
        $rsFloor = mysqli_query($inmoconn,$query_rsFloor) or die(mysqli_error() . '<hr>' . $query_rsFloor);
        $row_rsFloor = mysqli_fetch_assoc($rsFloor);
        $totalRows_rsFloor = mysqli_num_rows($rsFloor);
        if($totalRows_rsFloor == 0){
            $query = "INSERT INTO properties_planta SET ";
            $x=0;
            foreach($type as $key => $value) {
                if ((string)$value != '') {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "planta_".$key."_plnt = '".mysqli_real_escape_string($inmoconn,trim((string)$value))."'";
                }
            }
            
            $rsFloorInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $floorID = (int)$id;
            // array_push($newTypeArray, $type);
            return trim($floorID);
        } else{
            $floorID = (int)$row_rsFloor['id_plnt'];
            return $floorID;
        }
    }
}

// Procesamos tipos
if (!function_exists("setTypePropMediaelx")) {
    function setTypePropMediaelx($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $typeID, $newTypeArray, $autotraduccion;

        if ( $type['en'] == '' ) {
            return null;
        }
        
        $query_rsType = "SELECT id_typ, types_en_typ FROM properties_types WHERE LOWER(types_en_typ) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$type['en']))) . "'";
        $rsType = mysqli_query($inmoconn,$query_rsType) or die(mysqli_error() . '<hr>' . $query_rsType);
        $row_rsType = mysqli_fetch_assoc($rsType);
        $totalRows_rsType = mysqli_num_rows($rsType);
        if($totalRows_rsType == 0){
            $query = "INSERT INTO properties_types SET ";
            $x=0;
            foreach($type as $key => $value) {
                if ((string)$value != '') {
                    if($x++ > 0){
                        $query .= ", ";
                    }
                    $query .= "types_".$key."_typ = '".mysqli_real_escape_string($inmoconn,trim((string)$value))."'";
                }
            }
            
            $rsTypeInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $typeID = $id;
            array_push($newTypeArray, $type['en']);
            return trim($typeID);
        } else{
            $typeID = $row_rsType['id_typ'];
            return $row_rsType['types_en_typ'];
        }
    }
}

// Procesamos tags
if (!function_exists("setTagsProp")) {
    function setTagsProp($tag) {
        global $database_inmoconn, $inmoconn, $allLanguages, $tagID, $autotraduccion;
        
        $query_rsPool = "SELECT id_tag, tag_en_tag FROM properties_tags WHERE LOWER(tag_en_tag) = '" . strtolower(trim((string)$tag->en)) . "'";
        $rsPool = mysqli_query($inmoconn,$query_rsPool) or die(mysqli_error());
        $row_rsPool = mysqli_fetch_assoc($rsPool);
        $totalRows_rsPool = mysqli_num_rows($rsPool);
        if($totalRows_rsPool == 0){
            $query = "INSERT INTO properties_tags SET ";
            $query .= "tag_ca_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->ca))."',";
            $query .= "tag_da_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->da))."',";
            $query .= "tag_de_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->de))."',";
            $query .= "tag_en_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->en))."',";
            $query .= "tag_es_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->es))."',";
            $query .= "tag_fi_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->fi))."',";
            $query .= "tag_fr_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->fr))."',";
            $query .= "tag_is_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->is))."',";
            $query .= "tag_nl_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->nl))."',";
            $query .= "tag_no_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->no))."',";
            $query .= "tag_ru_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->ru))."',";
            $query .= "tag_se_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->se))."',";
            $query .= "tag_zh_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->zh))."',";
            $query .= "tag_pl_tag = '".mysqli_real_escape_string($inmoconn,trim((string)$tag->pl))."',";
            $query .= "color_tag = '#000',";
            $query .= "text_color_tag = '#fff'";
            
            $rsPoolInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $tagID = $id;
            return trim((string)$tag->en);
        } else{
            $tagID = $row_rsPool['id_tag'];
            return $tagID;
        }
    }
}

// Procesamos tags
if (!function_exists("setFeaturesProp")) {
    function setFeaturesProp($feature) {
        global $database_inmoconn, $inmoconn, $allLanguages, $featureID, $autotraduccion;
        
        $query_rsPool = "SELECT id_feat, feature_en_feat FROM properties_features_priv WHERE LOWER(feature_en_feat) = '" . mysqli_real_escape_string($inmoconn, strtolower(trim((string)$feature->en))) . "'";

        $rsPool = mysqli_query($inmoconn,$query_rsPool) or die(mysqli_error());
        $row_rsPool = mysqli_fetch_assoc($rsPool);
        $totalRows_rsPool = mysqli_num_rows($rsPool);
        if($totalRows_rsPool == 0){
            $query = "INSERT INTO properties_features_priv SET ";
            $query .= "feature_ca_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->ca))."',";
            $query .= "feature_da_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->da))."',";
            $query .= "feature_de_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->de))."',";
            $query .= "feature_en_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->en))."',";
            $query .= "feature_es_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->es))."',";
            $query .= "feature_fi_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->fi))."',";
            $query .= "feature_fr_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->fr))."',";
            $query .= "feature_is_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->is))."',";
            $query .= "feature_nl_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->nl))."',";
            $query .= "feature_no_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->no))."',";
            $query .= "feature_ru_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->ru))."',";
            $query .= "feature_se_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->se))."',";
            $query .= "feature_zh_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->zh))."',";
            $query .= "feature_pl_feat = '".mysqli_real_escape_string($inmoconn,trim((string)$feature->pl))."'";
            
            $rsPoolInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $id = @mysqli_insert_id($inmoconn);
            $featureID = $id;

            return trim((string)$feature->en);
        }
        else
        {
            $featureID = $row_rsPool['id_feat'];
            return $featureID;
        }
    }
}


if (!function_exists("savePropertyDataMediaelx")) {
    function savePropertyDataMediaelx($query, $update, $features = array(), $images = array(), $plans = array(), $videos = array(), $views360 = array(), $prices_days = array(), $availabity = array(), $tags = array()) {
        global $database_inmoconn, $inmoconn, $in_database, $proveedor, $propID, $newFeatArray, $allLanguages, $numInsert, $numUpdated, $refInm, $actionUpdateProp, $autotraduccion, $tagID;
        set_time_limit(0);
        // Añadimos el inmueble
        
        $rsPropertyInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query_rsPropertyInsert);
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
            if (!empty($images->image->url)) {
                foreach($images->image as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, '', $image->url);
                    
                    $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$propertyID."' AND image_img2 = '".$image."'";
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
                        $query .= "WHERE property_img = '".$propertyID."' AND image_img2 = '".$image."'";
                        
                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, $row_rsImages['id_img']); // /intramedianet/includes/resources/translate.php
                    }
                    $imgOrd++;
                }
            }
            $queryDeleteDisabledImages = "DELETE FROM properties_images WHERE active_img = '0' AND property_img = '".$propertyID."' ";
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());
        }

        // Añadimos las Disponibilidad
        
        $query_rsDeletekPropFeature = "DELETE FROM properties_disponibilidad WHERE  property_disp = '".$propertyID."'";
        $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
        if (!empty($availabity)) {
            foreach($availabity->availabity_reg as $availabity) {
                set_time_limit(0);
                $query = "INSERT INTO properties_disponibilidad SET ";
                $query .= "inicio_disp = '".$availabity->from."', ";
                $query .= "final_disp = '".$availabity->to."', ";
                $query .= "privado_disp = '".$availabity->from."', ";
                $query .= "property_disp = '".$propertyID."'";
                
                $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            }
        }

        // Añadimos las precios_dias
        
        $query_rsDeletekPropFeature = "DELETE FROM properties_prices WHERE  property_prc = '".$propertyID."'";
        $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
        if (!empty($availabity)) {
            foreach($availabity->availabity_reg as $availabity) {
                set_time_limit(0);
                $query = "INSERT INTO properties_prices SET ";
                $query .= "from_prc = '".$availabity->from."', ";
                $query .= "to_prc = '".$availabity->to."', ";
                $query .= "price_prc = '".$availabity->price."', ";
                $query .= "property_prc = '".$propertyID."'";
                
                $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
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

        // Añadimos las videos
        
        $query_rsDeletekPropFeature = "DELETE FROM properties_videos WHERE  property_vid = '".$propertyID."'";
        $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
        if (!empty($videos)) {
            $i = 1;
            foreach($videos->video_url as $video) {
                set_time_limit(0);
                if ($video != '' && $video != 'r') {
                    $query = "INSERT INTO properties_videos SET ";
                    $query .= "video_vid = '<iframe width=\"560\" height=\"315\" src=\"".$video."\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', ";
                    $query .= "order_vid = '".$i++."', ";
                    $query .= "property_vid = '".$propertyID."'";
                    
                    $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }
        }

        // Añadimos las imagenes
        $imgOrd = 1;
        $query = "UPDATE properties_planos SET ";
        $query .= "active_img = '0' ";
        "WHERE property_img = '".$propertyID."'";
        
        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
        $kyeroURLs = array(
            'https://kyero.cloudimg.io/crop/400x300/q82/',
            'https://kyero.cloudimg.io/s/crop/400x300/',
            '?NO_CHECKSUM&env=production',
            '?NO_CHECKSUM'
        );
        if (!empty($plans->plan->url)) {
            foreach($plans->plan as $plan) {
                set_time_limit(0);
                $plan = str_replace($kyeroURLs, '', $plan->url);
                
                $query_rsImages = "SELECT * FROM properties_planos WHERE property_img = '".$propertyID."' AND image_img2 = '".$plan."'";
                $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                $row_rsImages = mysqli_fetch_assoc($rsImages);
                $totalRows_rsImages = mysqli_num_rows($rsImages);
                if($totalRows_rsImages == 0){
                    $query = "INSERT INTO properties_planos SET ";
                    $query .= "property_img = '".$propertyID."',";
                    $query .= "image_img = '".trim($plan)."', ";
                    $query .= "image_img2 = '".trim($plan)."', ";
                    $query .= "active_img = '1', ";

                    $query .= "order_img = '".$imgOrd."'";
                    
                    $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    // generateThumbnails($plan, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                } else {
                    $query = "UPDATE properties_planos SET ";
                    $query .= "active_img = '1',  ";
                    $query .= "order_img = '".$imgOrd."'";
                    $query .= "WHERE property_img = '".$propertyID."' AND image_img2 = '".$plan."'";
                    
                    $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    // generateThumbnails($image, $row_rsImages['id_img']); // /intramedianet/includes/resources/translate.php
                }
                $imgOrd++;
            }
            $queryDeleteDisabledImages = "DELETE FROM properties_planos WHERE active_img = '0' AND property_img = '".$propertyID."' ";
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());
        }

        // Añadimos las features
        if (!$in_database || $proveedor['up_caracteristicas_xml'] == 1)
        {
            
            $queryDeleteDisabledImages = "DELETE FROM properties_property_feature_priv WHERE  property = '".$propertyID."' ";
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());

            foreach ($features as $feature)
            {
                setFeaturesProp($feature);
                $query = "INSERT INTO properties_property_feature_priv SET ";
                $query .= "property = '".$propertyID."',";
                $query .= "feature = '".$featureID."'";
                
                $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            }
        }

        // tags

        
        $queryDeleteDisabledImages = "DELETE FROM properties_property_tag WHERE property = '".$propertyID."' ";
        mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());

        foreach ($tags as $tag) {
            setTagsProp($tag);
            $query = "INSERT INTO properties_property_tag SET ";
            $query .= "property = '".$propertyID."',";
            $query .= "tag = '".$tagID."'";
            
            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
        }
    }
}
