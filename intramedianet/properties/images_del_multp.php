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

$ids = explode(',', $_GET['ids']);

foreach ($ids as $id) {


$query_rsImagen = "SELECT * FROM properties_images_priv WHERE `properties_images_priv`.`id_img` = '".$id."'";
$rsImagen = mysqli_query($inmoconn,$query_rsImagen) or die(mysqli_error());
$row_rsImagen = mysqli_fetch_assoc($rsImagen);

$img = $row_rsImagen['image_img'];
$imgid = $row_rsImagen['id_img'];
$prop = $row_rsImagen['property_img'];


$query_rsImagenes = "DELETE FROM `properties_images_priv` WHERE `properties_images_priv`.`id_img` = '".$id."' LIMIT 1;";
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());

$ord = 1;

if(!preg_match('/https?:\/\//', $img)){


	if(unlink('../../media/images/propertiesprv/'.$img)) {
		array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/" . $imgid . "_*"));

		
		$query_rsImagenes = "SELECT * FROM `properties_images_priv` WHERE property_img = ".$prop." ORDER BY order_img ASC";
		$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
		$row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
		$totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

		do {

			
			$query_rsUpdate1 = "UPDATE `properties_images_priv` SET `order_img` = '".$ord++."' WHERE `id_img` = ".$row_rsImagenes['id_img']."";
			$rsUpdate1 = mysqli_query($inmoconn,$query_rsUpdate1) or die(mysqli_error());

		} while ($row_rsImagenes = mysqli_fetch_assoc($rsImagenes));

		echo 'ok';
	}

} else {

	$path = explode('/', $img);
	$filename=$path[count($path)-1];
	$filename= explode('.', $filename);
	$filename= $filename[0].'.'.$filename[1];

	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/" . $imgid . "_*"));

		
		$query_rsImagenes = "SELECT * FROM `properties_images_priv` WHERE property_img = ".$prop." ORDER BY order_img ASC";
		$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
		$row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
		$totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

		do {

			
			$query_rsUpdate1 = "UPDATE `properties_images_priv` SET `order_img` = '".$ord++."' WHERE `id_img` = ".$row_rsImagenes['id_img']."";
			$rsUpdate1 = mysqli_query($inmoconn,$query_rsUpdate1) or die(mysqli_error());

		} while ($row_rsImagenes = mysqli_fetch_assoc($rsImagenes));

	echo 'ok';

}

}

?>
