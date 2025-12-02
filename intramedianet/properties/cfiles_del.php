<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

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


$query_rsImagen = "SELECT * FROM properties_client_files WHERE `properties_client_files`.`id_fil` = '".$_GET['id']."'";
$rsImagen = mysqli_query($inmoconn,$query_rsImagen) or die(mysqli_error());
$row_rsImagen = mysqli_fetch_assoc($rsImagen);

$img = $row_rsImagen['file_fil'];


$query_rsImagenes = "DELETE FROM `properties_client_files` WHERE `properties_client_files`.`id_fil` = '".$_GET['id']."' LIMIT 1;";
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());

if(unlink('../../media/files/clients/'.$img)) {
	echo 'ok';
}

?>