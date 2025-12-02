<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

function getChatGPT($url, $fields, $fields_string) {
    set_time_limit(0);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, trim($url));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");
    $data = curl_exec($ch);
    curl_close($ch);
    echo str_replace("\"", "", $data);
}

if ($_GET['lang'] == 'es') {
    $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
} else {
    $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
}
foreach ($idiomas as $key => $value) {
    if ($value == $_GET['from']) {
        $langFrom = $key;
    }
}

$query_rsProperty = "

SELECT

properties_properties.titulo_".$langFrom."_prop as titulo_".$langFrom."_prop,
properties_properties.descripcion_".$langFrom."_prop as descripcion_".$langFrom."_prop,
properties_properties.descripcion_xml_".$langFrom."_prop as descripcion_xml_".$langFrom."_prop,
title_".$langFrom."_prop as title_".$langFrom."_prop ,
description_".$langFrom."_prop as description_".$langFrom."_prop

FROM properties_loc4 towns
LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE id_prop = '".simpleSanitize($_GET['id_prop'])."'

GROUP BY id_prop


";
$rsProperty = mysqli_query($inmoconn, $query_rsProperty) or die(mysqli_error());
$row_rsProperty = mysqli_fetch_assoc($rsProperty);
$totalRows_rsProperty = mysqli_num_rows($rsProperty);

$prompt = '';

if ($_GET['lang'] == 'es') {
    $prompt .= 'Traduce del ' . $_GET['from'] . ' al  ' . $_GET['to'] . ' y devuelve solo el texto traducido: ';
} else {
    $prompt .= 'Translate from ' . $_GET['from'] . ' to  ' . $_GET['to'] . ' and returns only the translated text: ';
}

$prompt .= $row_rsProperty[$_GET['action'] . '' . $langFrom . '_prop'];

$fields = array (
    'prompt' => urlencode($prompt),
    'api-key' => urlencode($ChatGPTApiKey),
);

foreach($fields as $key=>$value) {
    $fields_string .= $key.'='.$value.'&';
}
rtrim($fields_string, '&');

getChatGPT('https://ia.mediaelx.info/ai.php', $fields, $fields_string);