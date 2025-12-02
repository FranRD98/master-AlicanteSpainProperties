<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

if (preg_match('/{{PROPERTY-([\d|,]+)}}/', $_GET['comment'], $matches)) {
    $ids = explode(",",$matches[1]);
    $langVal = $_GET['lang'];
    $propertiesContent ="";
    foreach ($ids as $id) {
        $propertiesContent.= " \n https://" . $_SERVER['HTTP_HOST'] . propURL($id, $_GET['lang']) . " \n";
    }
    $text = preg_replace('/{{PROPERTY-([\d|,]+)}}/', $propertiesContent, $_GET['comment']);
} else {
    $text = $_GET['comment'];
}

header("location: https://wa.me/" . $_GET['phone'] . "/?text=" . urlencode($text));
die();

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";
