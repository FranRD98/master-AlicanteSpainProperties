<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

$lastUpdateFile = $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/_cache/last-update.txt';

if (!file_exists($lastUpdateFile) || strtotime('+1 minutes',filemtime($lastUpdateFile)) < strtotime("now") || !filesize($lastUpdateFile)) {
    // Cargamos la conexión a MySql
    require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

    // Cargamos los idiomas de la administración
    require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

    set_time_limit(0);

    $query_rsInt = "SELECT id_prop FROM  `properties_properties` WHERE activado_prop = '1'";
    $rsInt = mysqli_query($inmoconn,$query_rsInt) or die(mysqli_error());
    $row_rsInt = mysqli_fetch_assoc($rsInt);
    $totalRows_rsInt = mysqli_num_rows($rsInt);

    $ids = array();

    do {

        array_push($ids, $row_rsInt['id_prop']);

    } while ($row_rsInt = mysqli_fetch_assoc($rsInt));

    global $database_inmoconn, $inmoconn;

    $query_rsImagenes = "
        SELECT
            properties_images.id_img,
            TRIM(REPLACE(REPLACE(image_img, '\r', ''), '\n', '')) as image_img,
            TRIM(REPLACE(REPLACE(image_img2, '\r', ''), '\n', '')) as image_img2,
            properties_images.property_img
        FROM `properties_images`
        WHERE procesada_img = 0
        ORDER BY IF(property_img IN (".implode(',', $ids)."), 0, 1), IF(order_img = 1, 0, 1), id_img ASC
    ";
    $rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
    $row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
    $totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

    if ($totalRows_rsImagenes > 0) {
        // echo "<hr>";
        // echo $row_rsImagenes['image_img'];
        // echo "<hr>";
        do {
            if (preg_match('/https?:\/\//', $row_rsImagenes['image_img'])) {
                generateThumbnails($row_rsImagenes['image_img'], $row_rsImagenes['id_img']);
            } else {
                generateThumbnails($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/' . $row_rsImagenes['image_img'], $row_rsImagenes['id_img']);
            }
            $query_rsUserTrad = "
            UPDATE  `properties_images` SET
              `procesada_img` = '1'
              WHERE id_img = '".$row_rsImagenes['id_img']."'
            ";
            $rsUserTrad = mysqli_query($inmoconn,$query_rsUserTrad) or die(mysqli_error());
            file_put_contents($lastUpdateFile, date("d-m-Y H:i:s"));
        } while ($row_rsImagenes = mysqli_fetch_assoc($rsImagenes));
    }
}




die();
