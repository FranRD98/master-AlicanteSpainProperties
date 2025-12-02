<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);


// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

function _d($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

$MailChimp = new MailChimp($keyMailchimp);
$result = $MailChimp->delete('lists/' . $_GET['id']);

// _d($result);

header("Location: listas.php");

?>