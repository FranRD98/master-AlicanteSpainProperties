<?php

$weblanguages = array();

if (in_array('en', $languages)) {
    array_push($weblanguages, 'en');
}
if (in_array('es', $languages)) {
    array_push($weblanguages, 'es');
}
if (in_array('fr', $languages)) {
    array_push($weblanguages, 'fr');
}
if (in_array('de', $languages)) {
    array_push($weblanguages, 'de');
}
if (in_array('nl', $languages)) {
    array_push($weblanguages, 'nl');
}

$languages = $weblanguages;

if(
    ( !isset($export_fotocasa_fields_prop["TransactionTypeId"]) || $export_fotocasa_fields_prop["TransactionTypeId"] == "") ||
    ( !isset($export_fotocasa_fields_prop["TypeId"]) || $export_fotocasa_fields_prop["TypeId"] == "") ||
    ( !isset($export_fotocasa_fields_prop["PropertyStatusId"]) || $export_fotocasa_fields_prop["PropertyStatusId"] == "") ||
    ( $tNG->getColumnValue('m2_prop') == "" && $tNG->getColumnValue('m2_parcela_prop') == "" ) ||
    ( $tNG->getColumnValue('preci_reducidoo_prop') == "" ) ||
    ( $tNG->getColumnValue('referencia_prop') == "" ) ||
    ( $tNG->getColumnValue('lat_long_gp_prop') == "" ) ||
    (!isset($fotocasaDatos["api_key"]) || $fotocasaDatos["api_key"] == "") ||
    (!isset($fotocasaDatos["address_visibility"]) || $fotocasaDatos["address_visibility"] == "")
    // || (!isset($fotocasaDatos["agent_id"]) || $fotocasaDatos["agent_id"] == "")
){

    return;
}

// CARGAMOS DICCIONARIOS DE FOTOCASA
$fotocasaFields = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/fotocasaFields.php');
$fotocasaLanguages = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_Language.php');
$fotocasaFileType = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_FileType.php');
$fotocasaPropertyContactInfoType = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_PropertyContactInfoType.php');

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
    if ($tNG->getColumnValue('descripcion_xml_'.$lg.'_prop') != '') {
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN ABREVIADA
            "FeatureId" => 2,
            "TextValue" =>  substr(htmlentities(strip_tags($tNG->getColumnValue('descripcion_xml_'.$lg.'_prop'))), 0, 300)."...",
            "LanguageId" => (int)$fotocasaLanguages[$lg],
        );
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN EXTENDIDA
            "FeatureId" => 3,
            "TextValue" => trim(preg_replace('/\s+/', ' ', htmlentities(strip_tags($tNG->getColumnValue('descripcion_xml_'.$lg.'_prop'))))),
            "LanguageId" => (int)$fotocasaLanguages[$lg],
        );
    } else {
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN ABREVIADA
            "FeatureId" => 2,
            "TextValue" =>  substr(htmlentities(strip_tags($tNG->getColumnValue('descripcion_'.$lg.'_prop'))), 0, 300)."...",
            "LanguageId" => (int)$fotocasaLanguages[$lg],
        );
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // DESCIPCIÓN EXTENDIDA
            "FeatureId" => 3,
            "TextValue" => trim(preg_replace('/\s+/', ' ', htmlentities(strip_tags($tNG->getColumnValue('descripcion_'.$lg.'_prop'))))),
            "LanguageId" => (int)$fotocasaLanguages[$lg],
        );
    }
}
// AÑADIMOS SUPERFICIE DEPENDIENDO DE SI HAY METROS DE LA CASA O LA PARCELA
if( $tNG->getColumnValue('m2_prop') && $tNG->getColumnValue('m2_prop') != ""){
    $supm2 = $tNG->getColumnValue('m2_prop');
} else {
    $supm2 = $tNG->getColumnValue('m2_parcela_prop');
}
$export_fotocasa_fields_prop["PropertyFeature"][] = array( // SUPERFICIE
    "FeatureId" => 1,
    "DecimalValue" => (float)$supm2,
    "LanguageId" => (int)$fotocasaLanguages["es"],
);
// CALIFICACIÓN ENERGÉTICA
if( $tNG->getColumnValue('energia_prop') && $tNG->getColumnValue('energia_prop') != ""){
    switch ($tNG->getColumnValue('energia_prop')) {
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

if( $tNG->getColumnValue('emisiones_prop') && $tNG->getColumnValue('emisiones_prop') != ""){
    switch ($tNG->getColumnValue('emisiones_prop')) {
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
if( $tNG->getColumnValue('orientacion_prop') && $tNG->getColumnValue('orientacion_prop') != ""){
    switch ($tNG->getColumnValue('orientacion_prop')) {
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
    "DecimalValue" => (int)$tNG->getColumnValue('habitaciones_prop'),
    "LanguageId" => (int)$fotocasaLanguages["es"],
);
// BAÑOS
$export_fotocasa_fields_prop["PropertyFeature"][] = array( // BAÑOS
    "FeatureId" => 12,
    "DecimalValue" => (int)$tNG->getColumnValue('aseos_prop'),
    "LanguageId" => (int)$fotocasaLanguages["es"],
);
// ASEOS
$export_fotocasa_fields_prop["PropertyFeature"][] = array( // ASEOS
    "FeatureId" => 13,
    "DecimalValue" => (int)$tNG->getColumnValue('aseos2_prop'),
    "LanguageId" => (int)$fotocasaLanguages["es"],
);

// Añadimos Features condicionales
// PARKING
if(
    ($tNG->getColumnValue('parking_prop') && $tNG->getColumnValue('parking_prop') != "") ||
    ($tNG->getColumnValue('plazas_garaje_prop') && $tNG->getColumnValue('plazas_garaje_prop') != "" && $tNG->getColumnValue('plazas_garaje_prop') != 0 )
){
    $export_fotocasa_fields_prop["PropertyFeature"][] = array( // PARKING
        "FeatureId" => 23,
        "BoolValue" => true,
        "LanguageId" => (int)$fotocasaLanguages["es"],
    );
}
// PISCINA
if( $tNG->getColumnValue('piscina_prop') && $tNG->getColumnValue('piscina_prop') != "" ){
    $export_fotocasa_fields_prop["PropertyFeature"][] = array( // PISCINA
        "FeatureId" => 25,
        "BoolValue" => true,
        "LanguageId" => (int)$fotocasaLanguages["es"],
    );
}
// TERRAZA
if ( !isset($originalFeatureArray["27"]) ){
    if( $tNG->getColumnValue('m2_balcon_prop') && $tNG->getColumnValue('m2_balcon_prop') != "" ){
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // TERRAZA
            "FeatureId" => 27,
            "BoolValue" => true,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }
}
// ARMARIOS
if ( !isset($originalFeatureArray["258"]) ){
    if( $tNG->getColumnValue('armarios_empotrados_prop') && $tNG->getColumnValue('armarios_empotrados_prop') != "" && $tNG->getColumnValue('armarios_empotrados_prop') != 0 ){
        $export_fotocasa_fields_prop["PropertyFeature"][] = array( // ARMARIOS
            "FeatureId" => 258,
            "BoolValue" => true,
            "LanguageId" => (int)$fotocasaLanguages["es"],
        );
    }
}
// ETIQUETAS
// Vistas al mar ID 1 = Feature 315
$query_rsTags = "SELECT properties_property_tag.property FROM properties_property_tag WHERE properties_property_tag.tag= 1 AND properties_property_tag.property='".$tNG->getColumnValue('id_prop')."' LIMIT 1";
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
$query_rsTags = "SELECT properties_property_tag.property FROM properties_property_tag WHERE properties_property_tag.tag= 2 AND properties_property_tag.property='".$tNG->getColumnValue('id_prop')."' LIMIT 1";
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
$export_fotocasa_fields_prop["IsPromotion"] = boolval($export_fotocasa_fields_prop["IsPromotion"]);
$export_fotocasa_fields_prop["PromotionType"] = (int)$export_fotocasa_fields_prop["PromotionType"];
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
    WHERE properties_loc4.id_loc4 = ".$tNG->getColumnValue('localidad_prop')."
    LIMIT 1";
$rsLocation = mysqli_query($inmoconn,$query_rsLocation) or die(mysqli_error() . '<hr>' . $query_rsLocation);
$row_rsLocation = mysqli_fetch_assoc($rsLocation);

// PropertyAddress
$latLong = explode(",",$tNG->getColumnValue('lat_long_gp_prop'));
$ppaddress = array(
    "CountryId" => 724, // ESPAÑA
    "y" => trim($latLong[0]),
    "x" => trim($latLong[1]),
    "VisibilityModeId" => $fotocasaDatos["address_visibility"],
);
if( $row_rsLocation["name_es_loc4"] == $row_rsLocation["name_es_loc3"] ){
    $ppaddress["Zone"] = $row_rsLocation["name_es_loc3"].", ".$row_rsLocation["name_es_loc2"]; // Zona, Población, Provincia
} else {
    $ppaddress["Zone"] = $row_rsLocation["name_es_loc4"].", ".$row_rsLocation["name_es_loc3"].", ".$row_rsLocation["name_es_loc2"]; // Zona, Población, Provincia
}
if( $tNG->getColumnValue('direccion_gp_prop') && $tNG->getColumnValue('direccion_gp_prop') != "" ){
    $ppaddress["Street"] = $tNG->getColumnValue('direccion_gp_prop');
}
$export_fotocasa_fields_prop = array("PropertyAddress" => array(
    $ppaddress
)) + $export_fotocasa_fields_prop;
// END PropertyAddress
// PropertyTransaction
$propertyTransactionArr = array(
    "TransactionTypeId" => (int)$export_fotocasa_fields_prop["TransactionTypeId"],
    "Price" => (float) $tNG->getColumnValue('preci_reducidoo_prop'),
    "PriceM2" => (float)((int)$tNG->getColumnValue('preci_reducidoo_prop') / $supm2),
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
$export_fotocasa_fields_prop = array("AgencyReference" => str_replace("/", "-", $tNG->getColumnValue('referencia_prop')) ) + $export_fotocasa_fields_prop;
// ExternalId = Id de la prop
$export_fotocasa_fields_prop = array("ExternalId" => $tNG->getColumnValue('id_prop')) + $export_fotocasa_fields_prop;

// ELIMINAMOS CAMPOS SI SE ENCUENTRAN VACÍOS
if( isset($export_fotocasa_fields_prop["SubTypeId"]) && $export_fotocasa_fields_prop["SubTypeId"] == "" ){
    unset($export_fotocasa_fields_prop["SubTypeId"]);
} else {
    $export_fotocasa_fields_prop["SubTypeId"] = (int) $export_fotocasa_fields_prop["SubTypeId"];
}
if( isset($export_fotocasa_fields_prop["IsNewConstruction"]) && $export_fotocasa_fields_prop["IsNewConstruction"] == "" ){
    unset($export_fotocasa_fields_prop["IsNewConstruction"]);
} else {
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
    $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$tNG->getColumnValue('id_prop')."' ORDER BY order_img";
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
    $query_rsPlanos = "SELECT * FROM properties_planos WHERE property_img = '".$tNG->getColumnValue('id_prop')."' ORDER BY order_img";
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
// EXPORTAR VIDEOS
    $query_rsVideos = "SELECT * FROM properties_videos WHERE property_vid = '".$tNG->getColumnValue('id_prop')."' ORDER BY order_vid";
    $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
    $totalRows_rsVideos = mysqli_num_rows($rsVideos);

    if( $totalRows_rsVideos > 0 ) {
        while ( $row_rsVideos = mysqli_fetch_assoc($rsVideos) ) {
            $imgArr = array(
                "TypeId" => 8,
                "Visible" => 1,
                "SortingId" => $row_rsVideos["order_vid"],
            );
            $imgArr["Description"] = "video youtube";
            preg_match_all('/<iframe[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $row_rsVideos['video_vid'], $result);
            $video = explode('&', $result['src'][0]);
            $imgArr["Url"] = str_replace("embed/","watch?v=", str_replace("?rel=0","", $video[0]));
            $imgArr["FileTypeId"] = 17;
            $export_fotocasa_fields_prop["PropertyDocument"][] = $imgArr;
        };
    }
// EXPORTAR 360
    $query_rs360 = "SELECT * FROM properties_360 WHERE property_360 = '".$tNG->getColumnValue('id_prop')."' ORDER BY order_360";
    $rs360 = mysqli_query($inmoconn,$query_rs360) or die(mysqli_error());
    $totalRows_rs360 = mysqli_num_rows($rs360);

    if( $totalRows_rs360 > 0 ) {
        while ( $row_rs360 = mysqli_fetch_assoc($rs360) ) {
            $imgArr = array(
                "TypeId" => 7,
                "Visible" => 1,
                "SortingId" => $row_rs360["order_360"],
            );
            $imgArr["Description"] = "tourvirtual";
            preg_match_all('/<iframe[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $row_rs360['video_360'], $result);
            $imgArr["Url"] = str_replace("embed/","watch?v=", str_replace("?rel=0","", $result['src'][0]));
            $imgArr["FileTypeId"] = 17;
            $imgArr["RoomTypeId"] = 7;
            $export_fotocasa_fields_prop["PropertyDocument"][] = $imgArr;
        };
    }
//
// echo "<br />";
// echo "<pre>";
// var_dump($export_fotocasa_fields_prop);
// echo "</pre>";
// echo json_encode(utf8ize($export_fotocasa_fields_prop));
// exit;

// if ($_SERVER['REMOTE_ADDR'] == '109.107.124.124') {
//     echo json_encode(utf8ize($export_fotocasa_fields_prop));
//     die();
// }


if($method == "insert"){
    $result = FotocasaAPI::insertProperty($fotocasaDatos["api_key"] ,json_encode($export_fotocasa_fields_prop));
    // $result = FotocasaAPI::insertProperty($fotocasaDatos["api_key"] ,json_encode(utf8ize($export_fotocasa_fields_prop)));
    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
    // die();
    return $result;
} else if($method == "update"){
    $result = FotocasaAPI::updateProperty($fotocasaDatos["api_key"] ,json_encode($export_fotocasa_fields_prop));
    // $result = FotocasaAPI::updateProperty($fotocasaDatos["api_key"] ,json_encode(utf8ize($export_fotocasa_fields_prop)));
    return $result;
}
