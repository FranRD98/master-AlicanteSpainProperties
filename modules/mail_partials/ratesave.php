<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$langVal.".php");

// Cargamos las urls
include_once($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");
// error_reporting(E_ALL);
// ini_set("display_errors", 1);


function encryptIt($idCli, $encryptionKey = 'DLusjkq6kkzRUbY7TVc7YH2RcT2')
{
    global $_SERVER;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_key = $_SERVER['HTTP_HOST'];
    $encryption_iv = $_SERVER['HTTP_HOST'];

    $encryption = openssl_encrypt($idCli, $ciphering,
            $encryption_key, $options, $encryption_iv);
    return $encryption;
}

$id = $_GET['id_cli'];
$prop = $_GET['id_prop'];
$rate = $_GET['rate'];
$location = $_GET['location'];
$type = $_GET['type'];
$price = $_GET['price'];
$bedrooms = $_GET['bedrooms'];
$other = $_GET['other'];
$query_rsClientes = "SELECT * FROM properties_client WHERE id_cli = '$id'";
$rsClientes = mysqli_query($inmoconn,$query_rsClientes) or die(mysqli_error());
$row_rsClientes = mysqli_fetch_assoc($rsClientes);
$totalRows_rsClientes = mysqli_num_rows($rsClientes);


if ($totalRows_rsClientes) {
    $query_rsClientes = "
    INSERT INTO cli_prop_rate SET
    client = '$id',
    property = '$prop',
    rate = '$rate',
    location = '$location',
    type = '$type',
    price = '$price',
    bedrooms = '$bedrooms',
    other = '$other' ";
    $rsClientes = mysqli_query($inmoconn,$query_rsClientes) or die(mysqli_error());
}

echo "ok";


?>
