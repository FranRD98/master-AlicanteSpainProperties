<?php

// CARGAMOS DICCIONARIOS DE FOTOCASA
$fotocasaFields = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/fotocasaFields.php');
$fotocasaLanguages = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_Language.php');
$fotocasaFileType = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_FileType.php');
$fotocasaPropertyContactInfoType = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_PropertyContactInfoType.php');

function fotocasaBulkExportProperty(){
    global $languages, $database_inmoconn, $inmoconn, $method, $fotocasaDatos, $row_rsFotocasaProperty, $export_fotocasa_fields_prop, $fotocasaFields, $fotocasaLanguages, $fotocasaFileType, $fotocasaPropertyContactInfoType;
    if(
        ( !isset($export_fotocasa_fields_prop["TransactionTypeId"]) || $export_fotocasa_fields_prop["TransactionTypeId"] == "") ||
        ( !isset($export_fotocasa_fields_prop["TypeId"]) || $export_fotocasa_fields_prop["TypeId"] == "") ||
        ( !isset($export_fotocasa_fields_prop["PropertyStatusId"]) || $export_fotocasa_fields_prop["PropertyStatusId"] == "") ||
        ( $row_rsFotocasaProperty['m2_prop'] == "" && $row_rsFotocasaProperty['m2_parcela_prop'] == "" ) ||
        ( $row_rsFotocasaProperty['preci_reducidoo_prop'] == "" ) ||
        ( $row_rsFotocasaProperty['referencia_prop'] == "" ) ||
        ( $row_rsFotocasaProperty['lat_long_gp_prop'] == "" ) ||
        (!isset($fotocasaDatos["api_key"]) || $fotocasaDatos["api_key"] == "") ||
        (!isset($fotocasaDatos["address_visibility"]) || $fotocasaDatos["address_visibility"] == "")
        // || (!isset($fotocasaDatos["agent_id"]) || $fotocasaDatos["agent_id"] == "")
    ){
        $result = array();
        $result["Code"] = "";
        $result["Message"] =
        "Tipo de transacción = ".@(bool)$export_fotocasa_fields_prop["TransactionTypeId"].
        " | Tipo de propiedad = ".@(bool)$export_fotocasa_fields_prop["TypeId"].
        " | Status de propiedad = ".@(bool)$export_fotocasa_fields_prop["PropertyStatusId"].
        " | M2 = ".@(bool)$row_rsFotocasaProperty['m2_prop'].
        " | Precio = ".@(bool)$row_rsFotocasaProperty['preci_reducidoo_prop'].
        " | Referencia = ".@(bool)$row_rsFotocasaProperty['referencia_prop'].
        " | Latitud y Longitud = ".@(bool)$row_rsFotocasaProperty['lat_long_gp_prop'];
        $result["StatusCode"] = "002";
        return $result;
    }

    // PROCESAMOS LAS FEATURES DEL FORM
    $featureArray = array();
    $originalFeatureArray = $export_fotocasa_fields_prop["PropertyFeature"];
    foreach ($export_fotocasa_fields_prop["PropertyFeature"] as $key => $value) {
        unset($export_fotocasa_fields_prop["PropertyFeature"][$key]);
        if( $value != "" && (isset($fotocasaFields[$key]["showOn"]["TypeId"]) &&  in_array($export_fotocasa_fields_prop["TypeId"],$fotocasaFields[$key]["showOn"]["TypeId"]) ) || (isset($fotocasaFields[$key]["showOn"]["TransactionTypeId"]) &&  in_array($export_fotocasa_fields_prop["TransactionTypeId"],$fotocasaFields[$key]["showOn"]["TransactionTypeId"]) ) ){
            switch ($fotocasaFields[$key]["type"]) {
                case 'text':
                    $featureType = "TextValue";
                break;
                case 'bool':
                    $featureType = "BoolValue";
                    $value = boolval($value);
                break;
                default:
                    $featureType = "DecimalValue";
                    $value = (int)$value;
                break;
            }
            $featureArray[] = array(
                "FeatureId" => $key,
                $featureType => $value,
                "LanguageId" => (int)$fotocasaLanguages["es"],
            );
        }
    }
    $export_fotocasa_fields_prop["PropertyFeature"] = $featureArray;

    // AÑADIMOS FEATURES A MANO
    foreach ($languages as $lg) {
        if ($row_rsFotocasaProperty['descripcion_xml_'.$lg.'_prop'] != '') {
            $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN ABREVIADA
                "FeatureId" => 2,
                "TextValue" => substr(htmlentities(strip_tags($row_rsFotocasaProperty['descripcion_xml_'.$lg.'_prop'])), 0, 300)."...",
                "LanguageId" => (int)$fotocasaLanguages[$lg],
            );
            $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN EXTENDIDA
                "FeatureId" => 3,
                "TextValue" => trim(preg_replace('/\s+/', ' ', htmlentities(strip_tags($row_rsFotocasaProperty['descripcion_xml_'.$lg.'_prop'])))),
                "LanguageId" => (int)$fotocasaLanguages[$lg],
            );
        } else {
            $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN ABREVIADA
                "FeatureId" => 2,
                "TextValue" => substr(htmlentities(strip_tags($row_rsFotocasaProperty['descripcion_'.$lg.'_prop'])), 0, 300)."...",
                "LanguageId" => (int)$fotocasaLanguages[$lg],
            );
            // $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN EXTENDIDA
                "FeatureId" => 3,
                "TextValue" => trim(preg_replace('/\s+/', ' ', htmlentities(strip_tags($row_rsFotocasaProperty['descripcion_'.$lg.'_prop'])))),
                "LanguageId" => (int)$fotocasaLanguages[$lg],
            );
        }
    }
    // AÑADIMOS SUPERFICIE DEPENDIENDO DE SI HAY METROS DE LA CASA O LA PARCELA
    if( $row_rsFotocasaProperty['m2_prop'] && $row_rsFotocasaProperty['m2_prop'] != ""){
        $supm2 = $row_rsFotocasaProperty['m2_prop'];
    } else {
        $supm2 = $row_rsFotocasaProperty['m2_parcela_prop'];
    }
    $export_fotocasa_fields_prop["PropertyFeature"][] = array( // SUPERFICIE
        "FeatureId" => 1,
        "DecimalValue" => (float)$supm2,
        "LanguageId" => (int)$fotocasaLanguages["es"],
    );
    // CALIFICACIÓN ENERGÉTICA
    if( $row_rsFotocasaProperty['energia_prop'] && $row_rsFotocasaProperty['energia_prop'] != ""){
        switch ($row_rsFotocasaProperty['energia_prop']) {
            case 'A':
                $calEnerg = 1;
                break;
            case 'B':
                $calEnerg = 2;
                break;
            case 'C':
                $calEnerg = 3;
                break;
            case 'D':
                $calEnerg = 4;
                break;
            case 'E':
                $calEnerg = 5;
                break;
            case 'F':
                $calEnerg = 6;
                break;
            case 'G':
                $calEnerg = 7;
                break;
            default:
                $calEnerg = 0;
                break;
        }
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
            "FeatureId" => 323,
            "DecimalValue" => (int)$calEnerg,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    } else {
        // $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
        //     "FeatureId" => 323,
        //     "DecimalValue" => 8,
        //     "LanguageId" => (int)$fotocasaLanguages["es"],
        // );
    }

    if ($calEnerg >=1 && $calEnerg <= 7) {
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
            "FeatureId" => 327,
            "DecimalValue" => 1,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    } else {
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
            "FeatureId" => 327,
            "DecimalValue" => 2,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }

    if( $row_rsFotocasaProperty['emisiones_prop'] && $row_rsFotocasaProperty['emisiones_prop'] != ""){
        switch ($row_rsFotocasaProperty['emisiones_prop']) {
            case 'A':
                $calEnerg = 1;
                break;
            case 'B':
                $calEnerg = 2;
                break;
            case 'C':
                $calEnerg = 3;
                break;
            case 'D':
                $calEnerg = 4;
                break;
            case 'E':
                $calEnerg = 5;
                break;
            case 'F':
                $calEnerg = 6;
                break;
            case 'G':
                $calEnerg = 7;
                break;
            default:
                $calEnerg = 0;
                break;
        }
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
            "FeatureId" => 324,
            "DecimalValue" => (int)$calEnerg,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    } else {
        // $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
        //     "FeatureId" => 324,
        //     "DecimalValue" => 8,
        //     "LanguageId" => (int)$fotocasaLanguages["es"],
        // );
    }


    if ($calEnerg >=1 && $calEnerg <= 7) {
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
            "FeatureId" => 327,
            "DecimalValue" => 1,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    } else {
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // CALIFICACIÓN ENERGÉTICA
            "FeatureId" => 327,
            "DecimalValue" => 2,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }


    // ORIENTACIÓN
    if( $row_rsFotocasaProperty['orientacion_prop'] && $row_rsFotocasaProperty['orientacion_prop'] != ""){
        switch ($row_rsFotocasaProperty['orientacion_prop']) {
            case 'o-ne':
                $orient = 1;
                break;
            case 'o-o':
                $orient = 2;
                break;
            case 'o-n':
                $orient = 3;
                break;
            case 'o-so':
                $orient = 4;
                break;
            case 'o-e':
                $orient = 5;
                break;
            case 'o-se':
                $orient = 6;
                break;
            case 'o-no':
                $orient = 7;
                break;
            case 'o-s':
                $orient = 8;
                break;
            default:
                $orient = 3;
                break;
        }
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // ORIENTACIÓN
            "FeatureId" => 28,
            "DecimalValue" => (int)$orient,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }
    // HABITACIONES
    $export_fotocasa_fields_prop["PropertyFeature"][] = array( // HABITACIONES
        "FeatureId" => 11,
        "DecimalValue" => (int)$row_rsFotocasaProperty['habitaciones_prop'],
        "LanguageId" => (int)$fotocasaLanguages["es"],
    );
    // BAÑOS
    $export_fotocasa_fields_prop["PropertyFeature"][] = array( // BAÑOS
        "FeatureId" => 12,
        "DecimalValue" => (int)$row_rsFotocasaProperty['aseos_prop'],
        "LanguageId" => (int)$fotocasaLanguages["es"],
    );
    // ASEOS
    $export_fotocasa_fields_prop["PropertyFeature"][] = array( // ASEOS
        "FeatureId" => 13,
        "DecimalValue" => (int)$row_rsFotocasaProperty['aseos2_prop'],
        "LanguageId" => (int)$fotocasaLanguages["es"],
    );

    // Añadimos Features condicionales
    // PARKING
    if(
        ($row_rsFotocasaProperty['parking_prop'] && $row_rsFotocasaProperty['parking_prop'] != "") ||
        ($row_rsFotocasaProperty['plazas_garaje_prop'] && $row_rsFotocasaProperty['plazas_garaje_prop'] != "" && $row_rsFotocasaProperty['plazas_garaje_prop'] != 0 )
    ){
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // PARKING
            "FeatureId" => 23,
            "BoolValue" => true,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }
    // PISCINA
    if( $row_rsFotocasaProperty['piscina_prop'] && $row_rsFotocasaProperty['piscina_prop'] != "" ){
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // PISCINA
            "FeatureId" => 25,
            "BoolValue" => true,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }
    // TERRAZA
    if ( !isset($originalFeatureArray["27"]) ){
        if( $row_rsFotocasaProperty['m2_balcon_prop'] && $row_rsFotocasaProperty['m2_balcon_prop'] != "" ){
            $export_fotocasa_fields_prop["PropertyFeature"][] = array( // TERRAZA
                "FeatureId" => 27,
                "BoolValue" => true,
                "LanguageId" => (int)$fotocasaLanguages["es"],
            );
        }
    }
    // ARMARIOS
    if ( !isset($originalFeatureArray["258"]) ){
        if( $row_rsFotocasaProperty['armarios_empotrados_prop'] && $row_rsFotocasaProperty['armarios_empotrados_prop'] != "" && $row_rsFotocasaProperty['armarios_empotrados_prop'] != 0 ){
            $export_fotocasa_fields_prop["PropertyFeature"][] = array( // ARMARIOS
                "FeatureId" => 258,
                "BoolValue" => true,
                "LanguageId" => (int)$fotocasaLanguages["es"],
            );
        }
    }
    // ETIQUETAS
    // Vistas al mar ID 1 = Feature 315
    $query_rsTags = "SELECT properties_property_tag.property FROM properties_property_tag WHERE properties_property_tag.tag= 1 AND properties_property_tag.property='".$row_rsFotocasaProperty['id_prop']."' LIMIT 1";
    $rsTags = mysqli_query($inmoconn,$query_rsTags) or die(mysqli_error());
    $row_rsTags = mysqli_fetch_assoc($rsTags);
    if( $row_rsTags ){
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // ARMARIOS
            "FeatureId" => 315,
            "BoolValue" => true,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }
    // Cerca del mar ID 2 = Feature 284
    $query_rsTags = "SELECT properties_property_tag.property FROM properties_property_tag WHERE properties_property_tag.tag= 2 AND properties_property_tag.property='".$row_rsFotocasaProperty['id_prop']."' LIMIT 1";
    $rsTags = mysqli_query($inmoconn,$query_rsTags) or die(mysqli_error());
    $row_rsTags = mysqli_fetch_assoc($rsTags);
    if( $row_rsTags ){
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // ARMARIOS
            "FeatureId" => 284,
            "BoolValue" => true,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }

    // AÑADIMOS CAMPOS CONCRETOS QUE NO SON FEATURES
    // Pasamos el valor a INTEGER
    $export_fotocasa_fields_prop["TypeId"] = (int)$export_fotocasa_fields_prop["TypeId"];
    $export_fotocasa_fields_prop["PropertyStatusId"] = (int)$export_fotocasa_fields_prop["PropertyStatusId"];
    $export_fotocasa_fields_prop["ExpirationCauseId"] = (int)$export_fotocasa_fields_prop["ExpirationCauseId"];
    $export_fotocasa_fields_prop["IsPromotion"] = isset($export_fotocasa_fields_prop["IsPromotion"]) ? boolval($export_fotocasa_fields_prop["IsPromotion"]): false;
    $export_fotocasa_fields_prop["PromotionType"] = isset($export_fotocasa_fields_prop["PromotionType"]) ? (int)$export_fotocasa_fields_prop["PromotionType"]: 0;
    // ShowSurface - Mostrar datos de superficie, es requerido
    $export_fotocasa_fields_prop = array("ShowSurface" => true) + $export_fotocasa_fields_prop;

    // PropertyAddress
    $query_rsLocation = "SELECT
            properties_loc4.name_es_loc4,
            properties_loc3.name_es_loc3,
            properties_loc2.name_es_loc2,
            properties_loc1.name_es_loc1
        FROM properties_loc4
        INNER JOIN properties_loc3 ON properties_loc3.id_loc3 = properties_loc4.loc3_loc4
        INNER JOIN properties_loc2 ON properties_loc2.id_loc2 = properties_loc3.loc2_loc3
        INNER JOIN properties_loc1 ON properties_loc1.id_loc1 = properties_loc2.loc1_loc2
        WHERE properties_loc4.id_loc4 = ".$row_rsFotocasaProperty['localidad_prop']."
        LIMIT 1";
    $rsLocation = mysqli_query($inmoconn,$query_rsLocation) or die(mysqli_error() . '<hr>' . $query_rsLocation);
    $row_rsLocation = mysqli_fetch_assoc($rsLocation);

    // PropertyAddress
    $latLong = explode(", ",$row_rsFotocasaProperty['lat_long_gp_prop']);
    $ppaddress = array(
        "CountryId" => 724, // ESPAÑA
        "y" => $latLong[0],
        "x" => $latLong[1],
        "VisibilityModeId" => $fotocasaDatos["address_visibility"],
    );
    if( $row_rsLocation["name_es_loc4"] == $row_rsLocation["name_es_loc3"] ){
        $ppaddress["Zone"] = $row_rsLocation["name_es_loc3"].", ".$row_rsLocation["name_es_loc2"]; // Zona, Población, Provincia
    } else {
        $ppaddress["Zone"] = $row_rsLocation["name_es_loc4"].", ".$row_rsLocation["name_es_loc3"].", ".$row_rsLocation["name_es_loc2"]; // Zona, Población, Provincia
    }
    if( $row_rsFotocasaProperty['direccion_gp_prop'] && $row_rsFotocasaProperty['direccion_gp_prop'] != "" ){
        $ppaddress["Street"] = $row_rsFotocasaProperty['direccion_gp_prop'];
    }
    $export_fotocasa_fields_prop = array("PropertyAddress" => array(
        $ppaddress
    )) + $export_fotocasa_fields_prop;
    // END PropertyAddress
    // PropertyTransaction
    $propertyTransactionArr = array(
        "TransactionTypeId" => (int)$export_fotocasa_fields_prop["TransactionTypeId"],
        "Price" => (float) $row_rsFotocasaProperty['preci_reducidoo_prop'],
        "PriceM2" => (float)((int)$row_rsFotocasaProperty['preci_reducidoo_prop'] / $supm2),
        "CurrencyId" => 1,
        "ShowPrice" => true,
    );
    // if(isset($export_fotocasa_fields_prop["PaymentPeriodicityId"]) && $export_fotocasa_fields_prop["PaymentPeriodicityId"] != "" && $export_fotocasa_fields_prop["TransactionTypeId"] != 1 && $export_fotocasa_fields_prop["TransactionTypeId"] != 4){
    //     $propertyTransactionArr["PaymentPeriodicityId"] = (int)$export_fotocasa_fields_prop["PaymentPeriodicityId"];
    // }
    $export_fotocasa_fields_prop = array("PropertyTransaction" => array($propertyTransactionArr)) + $export_fotocasa_fields_prop;
    unset($export_fotocasa_fields_prop["TransactionTypeId"]);
    // END PropertyTransaction

    // CONTACT INFO
    // ContactTypeId
    $export_fotocasa_fields_prop = array("ContactTypeId" => $fotocasaDatos["contact_type"] ) + $export_fotocasa_fields_prop;
    // ContactName
    if( isset($fotocasaDatos["contact_name"]) &&  $fotocasaDatos["contact_name"] != ""){
        $export_fotocasa_fields_prop = array("ContactName" => $fotocasaDatos["contact_name"] ) + $export_fotocasa_fields_prop;
    }
    // PropertyContactInfo
    if( isset($fotocasaDatos["contact_info"]) &&  $fotocasaDatos["contact_info"] != ""){
        $contactArr = array();
        foreach ($fotocasaDatos["contact_info"] as $key => $value) {
            if( $value != "" ){
                $contactArr[] = array(
                    "TypeId" => (int)$fotocasaPropertyContactInfoType[$key],
                    "Value" => $value,
                    "ValueTypeId" => $fotocasaDatos["contact_type"],
                );
            }
        }
        $export_fotocasa_fields_prop = array("PropertyContactInfo" => $contactArr ) + $export_fotocasa_fields_prop;
    }

    // PropertyUser $fotocasaDatos["agent_id"]
    // $export_fotocasa_fields_prop = array("PropertyUser" => array( array("UserId" => (int)$fotocasaDatos["agent_id"], "IsPrincipal" => true ) ) ) + $export_fotocasa_fields_prop;

    // PropertyPublications: Por defecto exporta al id 1 que son Fotocasa, Vibbo y Milanuncios (si está contratado)
    $export_fotocasa_fields_prop = array("PropertyPublications" => array( array("PublicationId" => 1, "PublicationTypeId" => 2 ) ) ) + $export_fotocasa_fields_prop;

    // AgencyReference = Referencia de la prop
    $export_fotocasa_fields_prop = array("AgencyReference" => str_replace("/", "-", $row_rsFotocasaProperty['referencia_prop']) ) + $export_fotocasa_fields_prop;
    // ExternalId = Id de la prop
    $export_fotocasa_fields_prop = array("ExternalId" => $row_rsFotocasaProperty['id_prop']) + $export_fotocasa_fields_prop;

    // ELIMINAMOS CAMPOS SI SE ENCUENTRAN VACÍOS
    if( isset($export_fotocasa_fields_prop["SubTypeId"]) && $export_fotocasa_fields_prop["SubTypeId"] == "" ){
        unset($export_fotocasa_fields_prop["SubTypeId"]);
    } else {
        $export_fotocasa_fields_prop["SubTypeId"] = (int) $export_fotocasa_fields_prop["SubTypeId"];
    }
    if( isset($export_fotocasa_fields_prop["IsNewConstruction"]) && $export_fotocasa_fields_prop["IsNewConstruction"] == "" ){
        unset($export_fotocasa_fields_prop["IsNewConstruction"]);
    } else if ( isset($export_fotocasa_fields_prop["IsNewConstruction"]) && $export_fotocasa_fields_prop["IsNewConstruction"] != "") {
        $export_fotocasa_fields_prop["IsNewConstruction"] = boolval($export_fotocasa_fields_prop["IsNewConstruction"]);
    }
    if( isset($export_fotocasa_fields_prop["ExpirationCauseId"]) && $export_fotocasa_fields_prop["ExpirationCauseId"] == ""  || $export_fotocasa_fields_prop["PropertyStatusId"] != 4){
        unset($export_fotocasa_fields_prop["ExpirationCauseId"]);
    }
    if( !isset($export_fotocasa_fields_prop["IsPromotion"]) || $export_fotocasa_fields_prop["IsPromotion"] == "" ){
        unset($export_fotocasa_fields_prop["PromotionType"]);
    }

    $export_fotocasa_fields_prop["PropertyDocument"] = array();
    // EXPORTAR IMÁGENES
        $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$row_rsFotocasaProperty['id_prop']."' ORDER BY order_img";
        $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
        $totalRows_rsImages = mysqli_num_rows($rsImages);

        if( $totalRows_rsImages > 0 ) {
            $imagesArr = array();
            while ( $row_rsImages = mysqli_fetch_assoc($rsImages) ) {
                $imgArr = array(
                    "TypeId" => 1,
                    "Visible" => 1,
                    "SortingId" => $row_rsImages["order_img"],
                );
                // AÑADIMOS EL ALT COMO DESCRIPCIÓN SI existente
                if( isset($row_rsImages["alt_es_img"]) && $row_rsImages["alt_es_img"] != "" ) {
                    $imgArr["Description"] = $row_rsImages["alt_es_img"];
                }
                if ( preg_match("/https?:/", $row_rsImages["image_img"]) ){
                    $imgArr["Url"] = $row_rsImages["image_img"];
                } else {
                    $imgArr["Url"] = 'https://'.$_SERVER['SERVER_NAME'].'/media/images/properties/'.$row_rsImages["image_img"];
                }
                $ext = strtolower(pathinfo($row_rsImages['image_img'], PATHINFO_EXTENSION));
                if( $ext == "." || $ext == ""){
                    $size = getimagesize($row_rsImages['image_img']);
                    $ext = strtolower(str_replace('.','',image_type_to_extension($size[2])));
                }
                if( !isset($fotocasaFileType[$ext]) ){
                    continue;
                }
                $imgArr["FileTypeId"] = $fotocasaFileType[$ext];
                $export_fotocasa_fields_prop["PropertyDocument"][] = $imgArr;
            };
        }
    // EXPORTAR PLANOS
        $query_rsPlanos = "SELECT * FROM properties_planos WHERE property_img = '".$row_rsFotocasaProperty['id_prop']."' ORDER BY order_img";
        $rsPlanos = mysqli_query($inmoconn,$query_rsPlanos) or die(mysqli_error());
        $totalRows_rsPlanos = mysqli_num_rows($rsPlanos);

        if( $totalRows_rsPlanos > 0 ) {
            while ( $row_rsPlanos = mysqli_fetch_assoc($rsPlanos) ) {
                $imgArr = array(
                    "TypeId" => 23,
                    "Visible" => 1,
                    "SortingId" => $row_rsPlanos["order_img"],
                );
                // AÑADIMOS EL ALT COMO DESCRIPCIÓN SI existente
                if( isset($row_rsPlanos["alt_es_img"]) && $row_rsPlanos["alt_es_img"] != "" ) {
                    $imgArr["Description"] = $row_rsPlanos["alt_es_img"];
                }
                if ( preg_match("/https?:/", $row_rsPlanos["image_img"]) ){
                    $imgArr["Url"] = $row_rsPlanos["image_img"];
                } else {
                    $imgArr["Url"] = 'https://'.$_SERVER['SERVER_NAME'].'/media/images/propertiesplanos/'.$row_rsPlanos["image_img"];
                }
                $ext = strtolower(pathinfo($row_rsPlanos['image_img'], PATHINFO_EXTENSION));
                if( $ext == "." || $ext == ""){
                    $size = getimagesize($row_rsPlanos['image_img']);
                    $ext = strtolower(str_replace('.','',image_type_to_extension($size[2])));
                }
                if( !isset($fotocasaFileType[$ext]) ){
                    continue;
                }
                $imgArr["FileTypeId"] = $fotocasaFileType[$ext];
                $export_fotocasa_fields_prop["PropertyDocument"][] = $imgArr;
            };
        }
    //
    // echo json_encode($export_fotocasa_fields_prop);
    // exit;
    // echo "<br />";
    // echo "<pre>";
    // var_dump($export_fotocasa_fields_prop);
    // echo "</pre>";
    // exit;

    if($method == "insert"){
        $result = FotocasaAPI::insertProperty($fotocasaDatos["api_key"] ,json_encode($export_fotocasa_fields_prop));
        return $result;
    } else if($method == "update"){
        $result = FotocasaAPI::updateProperty($fotocasaDatos["api_key"] ,json_encode($export_fotocasa_fields_prop));
        return $result;
    }
}
