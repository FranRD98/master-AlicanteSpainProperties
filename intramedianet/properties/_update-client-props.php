<?php

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

session_start();


if ($_GET['sec'] == 'si') {
    $table = 'cli_prop_int';
    $table2 = 'cli_prop_noint';
} else {
    $table = 'cli_prop_noint';
    $table2 = 'cli_prop_int';
}

if ($_GET['act'] == 'add') {
    $query = "INSERT INTO `".$table."`(`client`, `property`) VALUES ('".$_GET['id_cli']."', '".$_GET['id_prop']."')";
    $query2 = "DELETE FROM `".$table2."` WHERE `client`  = '".$_GET['id_cli']."' AND `property` = '".$_GET['id_prop']."'";
}

if ($_GET['act'] == 'pur') {
    $query = "DELETE FROM `".$table."` WHERE `client`  = '".$_GET['id_cli']."' AND `property` = '".$_GET['id_prop']."'";
    $query2 = "DELETE FROM `".$table2."` WHERE `client`  = '".$_GET['id_cli']."' AND `property` = '".$_GET['id_prop']."'";
}

$RS = mysqli_query($inmoconn,$query);

$RS = mysqli_query($inmoconn,$query2);

// INSERT INTO `cli_prop_int`(`id`, `client`, `property`) VALUES ([value-1],[value-2],[value-3])
// DELETE FROM `cli_prop_int` WHERE 0

// https://localhost:3000/intramedianet/properties/_update-client-props.php?act=add&sec=si&id_prop=6247&id_cli=8
// https://localhost:3000/intramedianet/properties/_update-client-props.php?act=add&sec=no&id_prop=6247&id_cli=8


?>