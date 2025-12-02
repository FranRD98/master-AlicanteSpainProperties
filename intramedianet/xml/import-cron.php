<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

@session_start();

include_once("importadores/_utils.php");
include_once("importadores/_utils_kyero.php");
include_once("importadores/_utils_mediaelx.php");
include_once("importadores/_utils_inmovilla.php");
include_once("importadores/_utils_resales.php");
include_once("importadores/_utils_redsp.php");
include_once("importadores/_utils_habihub.php");


$query_rsproveedor = "SELECT * FROM xml WHERE activate_xml = 1 AND (DATE(updated_xml) < (NOW() - INTERVAL 1 DAY) OR updated_xml = '' OR updated_xml IS NULL)  ORDER BY RAND()";
$rsproveedor = mysqli_query($inmoconn, $query_rsproveedor) or die(mysqli_error());
$row_rsproveedor = mysqli_fetch_assoc($rsproveedor);
$totalRows_rsproveedor = mysqli_num_rows($rsproveedor);

if ($totalRows_rsproveedor > 0) {
    do {
        switch ($row_rsproveedor['tipo_xml']) {
            case 1:
                $tipo = "Kyero";
            break;
            case 2:
                $tipo = "Mediaelx";
            break;
            case 3:
                $tipo = "Inmovilla";
            break;
            case 5:
                $tipo = "Resales";
            break;
            case 6:
                $tipo = "Redsp";
            break;
            case 7:
                $tipo = "Habihub";
            break;
        }
        $inline_errors = 0;
        $_GET['p'] = $row_rsproveedor['id_xml'];
        include("importadores/".$tipo.".php");
    } while ($row_rsproveedor = mysqli_fetch_assoc($rsproveedor));
    array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
    // generateMapping();
}

if ($autotraduccion == 1) {
   include($_SERVER["DOCUMENT_ROOT"] . "/intramedianet/translate/auto-translate.php");
   // generateMapping();
}



?>
