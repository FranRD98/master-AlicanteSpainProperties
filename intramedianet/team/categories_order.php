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
$restrict->Execute();
//End Restrict Access To Page
?><?php
include_once( $_SERVER['DOCUMENT_ROOT']."/Connections/inmoconn.php" );


// sleep(5);

$i = 1;

//End Restrict Access To Page
foreach (explode(',', $_GET['order']) as $item) {

$query_rsUpdate = "UPDATE `teams` SET `order_tms` = ". ($i++) ." WHERE `id_tms` = ".$item." LIMIT 1;";
$rsUpdate = mysqli_query($inmoconn, $query_rsUpdate) or die(mysqli_error());

}
