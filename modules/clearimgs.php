<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

$path = $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties';

$files = array_diff(scandir($path), array('.', '..', 'thumbnails'));

// FALTA HACER QUE COMPRUEBE LOS planos y las imagenes privadas

$i = 1;

foreach (array_reverse($files) as $file) {

    set_time_limit(0);

    $query_rsImagenes = "SELECT * FROM properties_images WHERE image_img = '".$file."'";
    $rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());
    $row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
    $totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

    if ($totalRows_rsImagenes == 0) {
        echo $query_rsImagenes;
        echo "<br>";
        echo $i++ . ' - ';
        echo $path . '/' . $file;
        // unlink($path . '/' . $file);
        echo "<hr>";
        // if ($i == 2) {
        //     die();
        // }
    }

}


?>
