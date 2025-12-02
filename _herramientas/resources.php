<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/vendor/autoload.php' );

require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_en.php");

$translate = new TranslateClient([
    'key' => $translateApiKey
]);

// Sueco en google es sv en vez de se como lo piden los clientes

$str = "<?php\n";
foreach ($langStr as $key => $value) {
    $translation = $translate->translate($value, [
        'target' => 'nl',
        'source' => 'en',
    ]);
    $str .= "\$langStr['" . $key . "'] = '" . ucfirst($translation['text']) . "';\n";
}
$str .= "?>";
echo ($str);

