<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/vendor/autoload.php' );

require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;

$translate = new TranslateClient([
    'key' => $translateApiKey
]);


// $languages = array('da','de','en','es','fi','fr','is','nl','no','ru','se','zh');
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/idiomas.php' );
//pilla los idiomas de la web actual

$idiomaFrase = 'en';
$txt = 'premium-selection';

if(isset($_GET['url']) && $_GET['url'] != '')
{
    $txt = $_GET['url']; //le pasamos por get la url que queremos
}


foreach ($languages as $lang) {
    switch ($lang) {
        case 'se':
            $langTr = 'sv';
            break;
        case 'zh':
            $langTr = 'en';
            break;
        default:
            $langTr = $lang;
            break;
    }

    if($lang == $idiomaFrase)
    {
        echo '\'' . $idiomaFrase . '\' => \'' . clean($txt) . '\',';
        echo "<br>";
    }
    else
    {
         $translation = $translate->translate($txt, [
            'target' => $langTr,
            'source' => 'en',
        ]);
        echo '\'' . $lang . '\' => \'' . clean($translation['text']) . '\',';
        echo "<br>";
    }

   
}

?>
