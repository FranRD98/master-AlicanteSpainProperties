<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/phpthumb/ThumbLib.inc.php');

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

$property_id = $_GET["id_prop"];
$ids = explode(',', $_GET['ids']);

if (file_exists("../../media/files/properties/".$property_id."_images.zip")) {
    unlink("../../media/files/properties/".$property_id."_images.zip");
}

ini_set("max_execution_time", 0);
$zip = new ZipArchive();

if ($zip->open("../../media/files/properties/".$property_id."_images.zip", ZIPARCHIVE::CREATE) !== TRUE) {
    die ("Could not open archive");
}

foreach ($ids as $key => $id) {

	$query_rsImagen = "SELECT * FROM properties_images_priv WHERE `properties_images_priv`.`id_img` = '".$id."'";
	$rsImagen = mysqli_query($inmoconn, $query_rsImagen) or die(mysqli_error());
	$row_rsImagen = mysqli_fetch_assoc($rsImagen);

	$img = $row_rsImagen['image_img'];
	$prop = $row_rsImagen['property_img'];

    if(!preg_match('/https?:\/\//', $img)){
	    $filExtens = pathinfo("../../media/images/propertiesprv/".$img, PATHINFO_EXTENSION);

		if ($filExtens == 'blm' || $filExtens == 'jpg' || $filExtens == 'jpeg' || $filExtens == 'gif' || $filExtens == 'JPG' || $filExtens == 'JPEG' || $filExtens == 'GIF' || $filExtens == 'png' || $filExtens == 'PNG') {
	        $zip->addFile("../../media/images/propertiesprv/".$img, $img) or die ("ERROR: Could not add file: $key");
	    }
	} else {
        $img = preg_replace('/\?.*/', '', $img);
        $filExtens = pathinfo($img, PATHINFO_EXTENSION);

        $pathInfo = pathinfo($img);
		if ($filExtens == 'blm' || $filExtens == 'jpg' || $filExtens == 'jpeg' || $filExtens == 'gif' || $filExtens == 'JPG' || $filExtens == 'JPEG' || $filExtens == 'GIF' || $filExtens == 'png' || $filExtens == 'PNG') {
	        $zip->addFromString($pathInfo['basename'], file_get_contents($img)) or die ("ERROR: Could not add file: $key");
	    }
    }
}
$zip->close();

echo "../../media/files/properties/".$property_id."_images.zip";

?>
