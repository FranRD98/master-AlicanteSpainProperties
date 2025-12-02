<?php
// Para pasar al traductor de pago, renombrar este archivo a translate.php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/vendor/autoload.php' );

require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;

$texto = $_POST['text'];
// $texto = strip_tags($texto);
$texto = str_replace('{image-left}', '##1##', $texto);
$texto = str_replace('{image-right}', '##2##', $texto);
$texto = str_replace('{image-pan}', '##3##', $texto);
$texto = str_replace('{image}', '##4##', $texto);

$translate = new TranslateClient([
    'key' => $translateApiKey
]);

$from = ($_POST['from'] == 'se')?'sv':$_POST['from'];
$to = ($_POST['to'] == 'se')?'sv':$_POST['to'];

$translation = $translate->translate($texto, [
    'target' => $to,
    'source' => $from,
]);

$texto = $translation['text'];

$texto = str_replace('##1##', '{image-left}', $texto);
$texto = str_replace('## 1 ##', '{image-left}', $texto);
$texto = str_replace('##2##', '{image-right}', $texto);
$texto = str_replace('## 2 ##', '{image-right}', $texto);
$texto = str_replace('##3##', '{image-pan}', $texto);
$texto = str_replace('## 3 ##', '{image-pan}', $texto);
$texto = str_replace('##4##', '{image}', $texto);
$texto = str_replace('## 4 ##', '{image}', $texto);

$texto_from = array('</ P>','</ DIV>','</ A>','</ STRONG>','</ B>','</ I>','</ U>');
$texto_to = array('</p>','</div>','</a>','</strong>','</b>','</i>','</u>');
$texto = str_replace($texto_from, $texto_to, $texto);

echo $texto;
?>
