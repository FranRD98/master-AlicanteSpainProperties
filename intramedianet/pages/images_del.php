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

$query_rsImagen = "SELECT * FROM news_fotos WHERE `news_fotos`.`id_img` = '".$_GET['id']."'";
$rsImagen = mysqli_query($inmoconn,$query_rsImagen) or die(mysqli_error());
$row_rsImagen = mysqli_fetch_assoc($rsImagen);

$img = $row_rsImagen['imagen_img'];

$query_rsImagenes = "DELETE FROM `news_fotos` WHERE `news_fotos`.`id_img` = '".$_GET['id']."' LIMIT 1;";
$rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());



if(isset($img) && !preg_match('/https?:\/\//', $img)){ 

	if(unlink('../../media/images/news/'.$img)) {
		tNG_deleteThumbnails('../../media/images/news/thumbnails/', $img, '');
		echo 'ok';
	}

} else {

	$path = explode('/', $img);
	$filename=$path[count($path)-1];
	$filename= explode('.', $filename);
	$filename= $filename[0].'.'.$filename[1];

	tNG_deleteThumbnails('../../media/images/news/thumbnails/', $filename, '');
	echo 'ok';

}

?>