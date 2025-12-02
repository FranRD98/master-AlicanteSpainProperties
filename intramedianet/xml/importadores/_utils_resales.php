<?php

// Comprobamos si ha cargado el xml correctamente
if (!function_exists("checkXMLcustom")) {
    function checkXMLcustom($xml) {
        $kyero_version = $xml->resalesonline->feed_version;
        $first_id = $xml->property->id;

        if ($kyero_version == '' || $first_id == '') {
            return false;
        }
        return true;
    }
}

// Comprobamos si la propiedad tiene los campos necesarios
if (!function_exists("checkPropertyCustom")) {
    function checkPropertyCustom($xml) {
        // global $kyero_version;
        $first_id = (string)$xml->id;
        $ref = (string)$xml->ref;
        $price = (string)$xml->price;
        // $price_freq = (string)$xml->price_freq;
        $town = $xml->town;
        $province = $xml->province;
        $type = (string)$xml->type->uk;

        if (
            trim($first_id) == '' ||
            trim($ref) == '' ||
            trim($price) == '' ||
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
if (!function_exists("getStatusCustom")) {
    function getStatusCustom($status, $new_build) {
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

// Procesamos tipos

        // <type>
        //     <uk>Villa</uk>
        //     <es>Villa</es>
        // </type>
        // <subtype>
        //     <uk>Detached</uk>
        //     <es>Independiente</es>
        // </subtype>

if (!function_exists("setTypePropCustom")) {
    function setTypePropCustom($type, $subtype) {
        global $database_inmoconn, $inmoconn, $allLanguages, $typeID, $newTypeArray, $autotraduccion;
        

        $tipo_en = (string)$type->uk;

        $query_rsType = "SELECT id_typ, types_en_typ FROM properties_types WHERE LOWER(types_en_typ) = '" . strtolower($tipo_en) . "'";

        // echo $query_rsType;
        //  echo '<hr>';
         
        $rsType = mysqli_query($inmoconn,$query_rsType) or die(mysqli_error());
        $row_rsType = mysqli_fetch_assoc($rsType);
        $totalRows_rsType = mysqli_num_rows($rsType);
        if($totalRows_rsType == 0){
            $query = "INSERT INTO properties_types SET ";
            if ($autotraduccion == 1) {
               $query .= "types_en_typ = '".$tipo_en."'";
            } else {
                $x=0;
                foreach($allLanguages as $value) {
                    if($x++ > 0)
                    {
                        $query .= ", ";
                    }
                    if($value == 'en')
                    {
                        $query .= "types_en_typ = '".$tipo_en."'";
                    }
                    else 
                    {
                        $query .= "types_".$value."_typ = '".$type->$value."'";
                    }

                    
                }
            }

            // echo '<hr>';
            // echo $query;

            // die(4);

            
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
if (!function_exists("savePropertyDataCustom")) {
    function savePropertyDataCustom($query, $update, $features = array(), $images = array()) {
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

        // Añadimos las features
        if (!$in_database || $proveedor['up_caracteristicas_xml'] == 1) 
        {
            
            $query_rsDeletekPropFeature = "DELETE FROM properties_property_feature_priv WHERE  property = '".$propertyID."'";
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($features)) 
            {

                foreach($features->category as $categoria)
                {
                    //categorías 1, 7 y 14 del XML
                    if($categoria->name->uk == 'Setting' || $categoria->name->uk == 'Category' || $categoria->name->uk == 'Features' ) 
                    {
                        
                        foreach($categoria->value as $feature)
                        {
                            set_time_limit(0);

                                $feature->uk = mysqli_real_escape_string($inmoconn, trim((string)$feature->uk));
                                
                                $query_rsFeature = "SELECT id_feat, feature_en_feat FROM properties_features_priv WHERE  LOWER(feature_en_feat) = '".strtolower($feature->uk)."'";
                                $rsFeature = mysqli_query($inmoconn,$query_rsFeature) or die(mysqli_error() . '<hr>' . $query_rsFeature );
                                $row_rsFeature = mysqli_fetch_assoc($rsFeature);
                                $totalRows_rsFeature = mysqli_num_rows($rsFeature);

                                if ($totalRows_rsFeature == 0) 
                                {

                                    $query = "INSERT INTO properties_features_priv SET ";
                                    if ($autotraduccion == 1) {
                                       $query .= "feature_en_feat = '".$feature->uk."'";
                                    } 
                                    else 
                                    {
                                        $x=0;
                                        foreach($allLanguages as $value) 
                                        {
                                            if($x++ > 0)
                                            {
                                                $query .= ", ";
                                            }
                                            if($value == 'en')
                                            {
                                                $query .= "feature_en_feat = '".$feature->uk."'";
                                            } 
                                            else
                                            {
                                                $query .= "feature_".$value."_feat = '".$feature->$value."'";
                                            } 
                                            
                                        }
                                    }

                                    
                                    $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                                    $id = @mysqli_insert_id($inmoconn);
                                    $featureID = $id;
                                    array_push($newFeatArray, $feature->uk);
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
        }
    }
}


