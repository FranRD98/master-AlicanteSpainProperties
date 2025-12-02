<?php require_once('../../Connections/inmoconn.php'); ?><?php
// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page
?><?php
include_once( $_SERVER['DOCUMENT_ROOT']."/Connections/inmoconn.php" );

$i = 1;

//End Restrict Access To Page
foreach (explode(',', $_GET['order']) as $item) {

$query_rsImagenes = "UPDATE `news_categories_videos` SET `order_vid` = ". $i++ ." WHERE `id_vid` = ".$item." LIMIT 1;";
$rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());

}


 ?>
