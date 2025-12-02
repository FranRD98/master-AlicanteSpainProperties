<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

$path = $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails';

$files = array_diff(scandir($path), array('.', '..'));

// FALTA HACER QUE COMPRUEBE LOS planos y las imagenes privadas

$i = 1;

// foreach (array_reverse($files) as $file) {
foreach (($files) as $file) {

    set_time_limit(0);

    if (preg_match('/(.*)_sm\./', $file) || preg_match('/_md\./', $file) || preg_match('/_lg\./', $file) || preg_match('/_xl\./', $file)) {

        if (preg_match('/[0-9]+/', $file, $outputSM)) {
            $query_rsImagenes = "SELECT * FROM properties_images WHERE id_img = '".$outputSM[0]."'";
            $rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());
            $row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
            $totalRows_rsImagenes = mysqli_num_rows($rsImagenes);
            if ($totalRows_rsImagenes == 0) {
                if($file != '') {
                    echo $outputSM[0];
                    echo "<br>";
                    echo $query_rsImagenes;
                    echo "<br>";
                    echo $file;
                    echo "<br>";
                    echo $path . '/' . $file;
                    // unlink($path . '/' . $file);
                    echo "<hr>";
                }
                if ($i++ == 20) {
                   die();
                }
            }
        }


    }



    // mysqli_select_db($database_inmoconn, $inmoconn);
    // $query_rsImagenes = "SELECT * FROM properties_images WHERE image_img = '".$file."'";
    // $rsImagenes = mysqli_query($query_rsImagenes, $inmoconn) or die(mysqli_error());
    // $row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
    // $totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

    // if ($totalRows_rsImagenes == 0) {
    //     echo $query_rsImagenes;
    //     echo "<br>";
    //     echo $i++ . ' - ';
    //     echo $path . '/' . $file;
    //     unlink($path . '/' . $file);
    //     echo "<hr>";
    //     // if ($i == 2) {
    //     //     die();
    //     // }
    // }

}


?>
