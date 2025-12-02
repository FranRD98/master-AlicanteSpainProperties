<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

$lastUpdateFile = $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/_cache/last-update-plans.txt';

if (!file_exists($lastUpdateFile) || strtotime('+1 minutes',filemtime($lastUpdateFile)) < strtotime("now") || !filesize($lastUpdateFile)) {
    // Cargamos la conexión a MySql
    require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

    // Cargamos los idiomas de la administración
    require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

    set_time_limit(0);

    global $database_inmoconn, $inmoconn;
    $query_rsImagenes = "
        SELECT
            id_img,
            TRIM(REPLACE(REPLACE(image_img, '\r', ''), '\n', '')) as image_img,
            TRIM(REPLACE(REPLACE(image_img2, '\r', ''), '\n', '')) as image_img2,
            properties_planos.property_img
        FROM `properties_planos`
        WHERE procesada_img = 0
        ORDER BY id_img ASC
    ";
    $rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
    $row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
    $totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

    if ($totalRows_rsImagenes > 0) {
        do {
            if (preg_match('/https?:\/\//', $row_rsImagenes['image_img'])) {
                generateThumbnails($row_rsImagenes['image_img'], $row_rsImagenes['id_img'], 'propertiesplanos');
            } else {
                generateThumbnails($_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesplanos/' . $row_rsImagenes['image_img'], $row_rsImagenes['id_img'], 'propertiesplanos');
            }
            $query_rsUserTrad = "
            UPDATE  `properties_planos` SET
              `procesada_img` = '1'
              WHERE id_img = '".$row_rsImagenes['id_img']."'
            ";
            $rsUserTrad = mysqli_query($inmoconn,$query_rsUserTrad) or die(mysqli_error());
            file_put_contents($lastUpdateFile, date("d-m-Y H:i:s"));
        } while ($row_rsImagenes = mysqli_fetch_assoc($rsImagenes));
    }
}

die();