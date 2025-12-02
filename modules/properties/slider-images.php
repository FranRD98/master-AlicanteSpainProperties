<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.imagesize.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/smarty/Smarty.class.php');

$smarty = new Smarty;

$id_prop = sanitizeInput($_GET["id_prop"]);
$alt = sanitizeInput($_GET["alt"]);
$width = sanitizeInput($_GET["width"]);
$height = sanitizeInput($_GET["height"]);
$url = sanitizeInput($_GET["url"]);

$images = getRecords("
    SELECT id_img
    FROM  properties_images
    WHERE  property_img = '".$id_prop."'
    ORDER BY order_img
");

$data = array();
$data["slides"] = "";
$data["id"] = $id_prop;

if($images[0] != NULL){
    foreach ($images as $key => $image) {
        if ($key != 0){
            $data["slides"] .= "<div class='slide'><a href='".$url."'><img src='/media/images/properties/thumbnails/".$image["id_img"]."_md.jpg' class='img-fluid' alt='".$alt."'></a></div>";
        }
    }
} else {
    echo NULL;
}

echo json_encode($data);

?>
