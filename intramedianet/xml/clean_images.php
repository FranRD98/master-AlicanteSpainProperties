<?php

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    $hostname_inmoconn = "localhost";
    $database_inmoconn = "castle";
    $username_inmoconn = "root";
    $password_inmoconn = "3657";
} else {
    $hostname_inmoconn = "localhost";
    $database_inmoconn = "castleg_db";
    $username_inmoconn = "castleg_usr";
    $password_inmoconn = "oLpbMOcc";
}

if ($_SERVER['SCRIPT_NAME'] != '/check.php') {
    $inmoconn = mysqli_connect($hostname_inmoconn, $username_inmoconn, $password_inmoconn, $database_inmoconn) or trigger_error(mysqli_error(),E_USER_ERROR);
}


$rResult = mysqli_query($inmoconn, "SET NAMES 'utf8'");

date_default_timezone_set('Europe/Madrid');

$path = $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties';

$files = array_diff(scandir($path), array('.', '..', 'thumbnails'));

$i = 1;

foreach (array_reverse($files) as $file) {

    set_time_limit(0);

    
    $query_rsImagenes = "SELECT * FROM properties_images WHERE image_img = '".$file."'";
    $rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());
    $row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
    $totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

    
    
    $query_rsImagenesPriv = "SELECT * FROM properties_images_priv WHERE image_img = '".$file."'";
    $rsImagenesPriv = mysqli_query($inmoconn, $query_rsImagenesPriv) or die(mysqli_error());
    $row_rsImagenesPriv = mysqli_fetch_assoc($rsImagenesPriv);
    $totalRows_rsImagenesPriv = mysqli_num_rows($rsImagenesPriv);

    
    $query_rsPlanos = "SELECT * FROM properties_planos WHERE image_img = '".$file."'";
    $rsPlanos = mysqli_query($inmoconn, $query_rsPlanos) or die(mysqli_error());
    $row_rsPlanos = mysqli_fetch_assoc($rsPlanos);
    $totalRows_rsPlanos = mysqli_num_rows($rsPlanos);

    if ($totalRows_rsImagenes == 0 && $totalRows_rsImagenesPriv == 0 && $totalRows_rsPlanos == 0) {
        foreach (glob($path . "/thumbnails/" . pathinfo($file, PATHINFO_FILENAME) . "*") as $nombre_fichero) {
            unlink($nombre_fichero);
        }
        unlink($path . '/' . $file);
        // if ($i++ == 50) {
        //     die();
        // }
    }

}


?>
