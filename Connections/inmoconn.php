<?php
$executionStartTime = microtime(true);

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

session_start();
/**
 * REV. 5
 */

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    $hostname_inmoconn = "localhost";
    $database_inmoconn = "master";
    $username_inmoconn = "root";
    $password_inmoconn = "root";
} else {
    $hostname_inmoconn = "localhost";
    $database_inmoconn = "php8_mediaelx_db";
    $username_inmoconn = "php8_mediaelx_usr";
    $password_inmoconn = "0072khQ%s";
}

if ($_SERVER['SCRIPT_NAME'] != '/check.php') {
    // Conexión MySQLi
    $inmoconn = new mysqli($hostname_inmoconn, $username_inmoconn, $password_inmoconn, $database_inmoconn);


    // Verificar la conexión
    if ($inmoconn->connect_error) {
        die("Conexión fallida: " . $inmoconn->connect_error);
    }
}

// Establecer el conjunto de caracteres a utf8mb4
$inmoconn->set_charset('utf8mb4');

date_default_timezone_set('Europe/Madrid');

function simpleSanitize($string)
{
    global $inmoconn; // Importante para usar mysqli_real_escape_string

    return htmlspecialchars($inmoconn->real_escape_string(strip_tags(str_replace("\n", "", $string))));
}

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/letsinmo.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/idiomas.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/traducciones.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/imagenes.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/import-xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/export-xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/mapas.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/metas.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/banner.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/email.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/newsletter.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/recaptcha.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/exchange.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/bar-responsiva.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/niveles.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/propiedades.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/secciones.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/chatgpt.php');
//customizaciones como: online viewings, buscador header, menú desplegable escritorio, tipo de galerías...
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/datos-cli.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/pdf.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/galerias.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/ferias.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/gdpr.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/llms.php');

// Mapping
// $mapping_prov = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/provincias.json'), true);
// $mapping_town = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/ciudades.json'), true);
// $mapping_area = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/areas.json'), true);
// $mapping_types = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/tipos.json'), true);

// echo $mapping_prov[3]['names']['es'];

// echo "<pre>";
// print_r($mapping_prov);
// echo "</pre>";

// echo "<pre>";
// print_r($mapping_town);
// echo "</pre>";

// echo "<pre>";
// print_r($mapping_area);
// echo "</pre>";

// echo "<pre>";
// print_r($mapping_types);
// echo "</pre>";
