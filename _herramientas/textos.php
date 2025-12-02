<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/vendor/autoload.php' );

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;

$tr = new TranslateClient();

# Instantiates a client
$tr = new TranslateClient([
    'key' => $translateApiKey
]);

set_time_limit(0);

// $languages = array('da','de','en','es','fi','fr','is','nl','no','ru','se','zh');
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/idiomas.php' );
//pilla los idiomas de la web actual

$idiomaFrase = 'en';
$txt = 'Search by map';


if(isset($_GET['lang']) && $_GET['lang'] != '')
{
    $idiomaFrase = $_GET['lang']; //le pasamos por get el idioma origen
}

if(isset($_GET['txt']) && $_GET['txt'] != '')
{
    $txt = $_GET['txt']; //le pasamos por get el texto que queremos
}


foreach ($languages as $lang)
{
    switch ($lang) 
    {
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
        echo $idiomaFrase.':=> &nbsp;&nbsp;  $langStr["'.$txt.'"] = "'.$txt.'";';
        echo "<hr>";
    }
    else
    {
        $translation = $tr->translate($txt, ['target' => $langTr, 'source' =>  $idiomaFrase ]);
        $texto = $translation['text'];
        echo $langTr.':=> &nbsp;&nbsp;  $langStr["'.$txt.'"] = "'.$texto.'";';
        echo "<hr>";  
    }

}


?>
