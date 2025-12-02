<?php // Revisamos si la referencia introducida ya existe en la base de datos

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

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

/*
* SQL queries
* Get data to display
*/
$sQuery = "
SELECT referencia_prop
FROM properties_properties
WHERE referencia_prop = '".$_GET['ref']."'";

$_result = mysqli_query($inmoconn,$sQuery);
$totalRows = mysqli_num_rows($_result);

echo $totalRows;
?>