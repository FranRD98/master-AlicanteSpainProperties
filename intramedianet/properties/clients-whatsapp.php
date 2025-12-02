<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

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

session_start();

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

$text = '';

$ids = explode(',', $_GET['ids']);

for ($i=0; $i < count($ids); $i++) {

    $text .= 'https://' . $_SERVER['HTTP_HOST'] . propURL($ids[$i], $_GET['lang']) . "\n";
}

$text .= str_replace("<br>", "\n", $_GET['comment']);

// echo "location: https://wa.me/" . $_GET['phone'] . "/?text=" . $text;

header("location: https://wa.me/" . $_GET['phone'] . "/?text=" . urlencode($text));
die();

