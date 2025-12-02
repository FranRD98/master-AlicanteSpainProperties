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

$json = explode(',', $_GET['order'], true);

$i = 1;

// function getChildrens($parent, $childrens) {
//     global $i, $database_inmoconn, $inmoconn;
//     foreach ($childrens as $key => $value) {
//         $query_rsImagenes = "UPDATE `news_categories` SET parent_ct = ". $parent  .", orden_ct = ". $i++  ." WHERE `id_ct` = '".$value['id']."' LIMIT 1;";
//         $rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());
//         getChildrens($value['id'], $value['children']);
//     }
// }

foreach (explode(',', $_GET['order']) as $item) {

    $query_rsImagenes = "UPDATE `news_categories` SET parent_ct = 0, orden_ct = ". ($i++) ." WHERE `id_ct` = ".$item." LIMIT 1;";
    $rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());

}

 ?>
