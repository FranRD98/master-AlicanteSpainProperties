<?php

// Comprobamos si ha cargado el xml correctamente
if (!function_exists("checkXMLHabihub")) {
    function checkXMLHabihub($xml) {
        $kyero_version = $xml->kyero->feed_version;
        $first_id = $xml->property->id;
        if ($kyero_version == '' || $first_id == '') {
            return false;
        }
        return true;
    }
}

// Comprobamos si la propiedad tiene los campos necesarios
if (!function_exists("checkPropertykyero")) {
    function checkPropertykyero($xml) {
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
if (!function_exists("getStatusKyero")) {
    function getStatusKyero($status, $new_build) {
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

// Procesamos conditions
if (!function_exists("setConditionPropHabihub")) {
    function setConditionPropHabihub($type) {
        global $database_inmoconn, $inmoconn, $allLanguages, $conditionID, $newTypeArray, $autotraduccion;

        $query_rsCondition = "SELECT id_cond, condition_en_cond FROM properties_condition WHERE LOWER(condition_en_cond) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$type))) . "'";
        $rsCondition = mysqli_query($inmoconn,$query_rsCondition) or die(mysqli_error() . '<hr>' . $query_rsCondition);
        $row_rsCondition = mysqli_fetch_assoc($rsCondition);
        $totalRows_rsCondition = mysqli_num_rows($rsCondition);
        if($totalRows_rsCondition == 0){
            $query = "INSERT INTO properties_condition SET ";
            $x=0;
            foreach($allLanguages as $value) {
                if($x++ > 0){
                    $query .= ", ";
                }
                $query .= "condition_".$value."_cond = '".mysqli_real_escape_string($inmoconn,trim((string)$type))."'";
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

// Procesamos propietario
if (!function_exists("setOwnerHabihub")) {
    function setOwnerHabihub($owner) {
        global $database_inmoconn, $inmoconn, $allLanguages, $ownerID, $newTypeArray, $autotraduccion;

        $query_rsOwner = "SELECT id_pro FROM properties_owner WHERE LOWER(email_pro) = '" . mysqli_real_escape_string($inmoconn,trim(strtolower((string)$owner['email']))) . "'";
        $rsOwner = mysqli_query($inmoconn,$query_rsOwner) or die(mysqli_error() . '<hr>' . $query_rsOwner);
        $row_rsOwner = mysqli_fetch_assoc($rsOwner);
        $totalRows_rsOwner = mysqli_num_rows($rsOwner);
        if($totalRows_rsOwner == 0){
            $query = "INSERT INTO properties_owner SET ";
            $query .= "nombre_pro = '".mysqli_real_escape_string($inmoconn,trim((string)$owner['name']))."', ";
            $query .= "email_pro = '".mysqli_real_escape_string($inmoconn,trim((string)$owner['email']))."', ";
            $query .= "telefono_fijo_pro = '".mysqli_real_escape_string($inmoconn,trim((string)str_replace('+', '', $owner['phone'])))."', ";
            $query .= "type_pro = 3, ";
            $query .= "fecha_alta_pro = '" . date("Y-m-d H:i:s") . "', ";
            $query .= "idioma_pro = 'en' ";
            $rsOwnerInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $ownerID = (int)$id;
            return $ownerID;
        } else{
            $ownerID = (int)$row_rsOwner['id_pro'];
            return $ownerID;
        }
    }
}

// Procesamos promociones
if (!function_exists("setPromotionHabihub")) {
    function setPromotionHabihub($promotion, $province, $ciudad, $property) {
        global $database_inmoconn, $inmoconn, $allLanguages, $promotionID, $newTypeArray, $autotraduccion, $language;

        $query_rsPromotion = "SELECT id_nws FROM news WHERE  LOWER(title_en_nws) = '" . mysqli_real_escape_string($inmoconn, trim(strtolower($promotion))) . "' AND type_nws = 999";
        $rsPromotion = mysqli_query($inmoconn,$query_rsPromotion) or die(mysqli_error() . '<hr>' . $query_rsPromotion);
        $row_rsPromotion = mysqli_fetch_assoc($rsPromotion);
        $totalRows_rsPromotion = mysqli_num_rows($rsPromotion);
        if($totalRows_rsPromotion == 0){
            $query = "INSERT INTO news SET ";
            foreach($allLanguages as $value) {
                $query .= "title_".$value."_nws = '" . mysqli_real_escape_string($inmoconn, trim((string)$promotion)) . "', ";
            }
            $query .= "quick_province_nws = '".mysqli_real_escape_string($inmoconn, trim((string)$province))."', ";
            $query .= "quick_town_nws = '".mysqli_real_escape_string($inmoconn, trim((string)$ciudad))."', ";
            $lat = mysqli_real_escape_string($inmoconn,trim((float)$property->location->latitude));
            $long = mysqli_real_escape_string($inmoconn,trim((float)$property->location->longitude));
            if (($lat != '' && $lat != 0) && ($long != '' && $long != 0)) {
                $query .= "lat_long_gp_prop = '".$lat.",".$long."', \n";
            }
            foreach($allLanguages as $value) {
               if ($value == 'se') {
                   if ((string)$property->desc->sv != '') {
                        $query .= "content_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->desc->sv))."', \n";
                   }
                   if ((string)$property->seo->metadescription->sv != '') {
                        $query .= "description_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->metadescription->sv))."', \n";
                   }
                   if ($property->seo->h1->sv != '') {
                        $query .= "titulo_prom_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->h1->sv))."', \n";
                   } else {
                        $query .= "titulo_prom_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->title->sv))."', \n";
                   }
                   if ($property->seo->title->sv != '') {
                        $query .= "titlew_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->title->sv))."', \n";
                   }
               } else {
                   if ((string)$property->desc->$value != '') {
                        $query .= "content_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->desc->$value))."', \n";
                   }
                   if ((string)$property->seo->metadescription->$value != '') {
                        $query .= "description_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->metadescription->$value))."', \n";
                   }
                   if ((string)$property->seo->h1->$value != '') {
                        $query .= "titulo_prom_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->h1->$value))."', \n";
                   } else {
                        $query .= "titulo_prom_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->title->$value))."', \n";
                   }
                   if ((string)$property->seo->title->$value != '') {
                        $query .= "titlew_".$value."_nws = '".mysqli_real_escape_string($inmoconn,trim((string)$property->seo->title->$value))."', \n";
                   }
                }
            }
            $query .= "activate_nws = 0, ";
            $query .= "type_nws = 999 ";
            $rsPromotionInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
            $id = @mysqli_insert_id($inmoconn);
            $promotionID = (int)$id;

            // IMAGENES
            if (!empty($property->images->image->url)) {
                $imgOrd = 1;
                foreach($property->images->image as $image) {
                    set_time_limit(0);
                    $query = "INSERT INTO news_fotos SET ";
                    $query .= "noticia_img = '".$promotionID."',";
                    $query .= "imagen_img = '".trim($image->url)."', ";
                    $query .= "orden_img = '".$imgOrd++."'";
                    mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }

            // FEATURES
            if (!empty($property->features)) {
                foreach($property->features->feature as $feature) {
                    set_time_limit(0);
                    $feature = mysqli_real_escape_string($inmoconn,trim((string)$feature));

                    if (!preg_match('/^Private garage:\s*\d+$/i', $feature) && !preg_match('/^Private parking:\s*\d+$/i', $feature) && !preg_match('/^Floor:\s*\d+$/i', $feature)) {
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
                        } else {
                            $featureID = $row_rsFeature['id_feat'];
                        }
                        if($featureID != ''){
                            $query = "INSERT INTO promotions_promotions_feature SET ";
                            $query .= "promotion = '".$promotionID."',";
                            $query .= "feature = '".$featureID."'";

                            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        }
                    }
                }

                //  TAGS
                $query = "DELETE FROM promotions_promotions_tag WHERE promotion = '".$promotionID."'";
                mysqli_query($inmoconn,$query) or die(mysqli_error());

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
                if (!empty($tagsHabihub)) {
                    foreach($tagsHabihub as $tag) {
                        if ((string)$tag > 0) {
                            $query = "INSERT INTO promotions_promotions_tag SET ";
                            $query .= "promotion = '".$promotionID."',";
                            $query .= "tag = '".$tag."'";
                            mysqli_query($inmoconn,$query) or die(mysqli_error());
                        }
                    }
                }
            }
            return $promotionID;
        } else{
            $promotionID = (int)$row_rsPromotion['id_nws'];
            return $promotionID;
        }
    }
}