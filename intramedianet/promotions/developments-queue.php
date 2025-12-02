<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

$lastUpdateFile = $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/_cache/last-update-desc.txt';

if (!file_exists($lastUpdateFile) || strtotime('+2 minutes',filemtime($lastUpdateFile)) < strtotime("now") || !filesize($lastUpdateFile)) {

    function getRecords($sql) {
        global $database_inmoconn, $inmoconn, $_GET;
        $query_rsSelect = $sql;
        $rsSelect = mysqli_query($inmoconn,$query_rsSelect) or die(mysqli_error() . '<hr>' . $query_rsSelect);
        $row_rsSelect = mysqli_fetch_assoc($rsSelect);
        $totalRows_rsSelect = mysqli_num_rows($rsSelect);
        $ret = array();
        do {
            array_push($ret, $row_rsSelect);
        } while ($row_rsSelect = mysqli_fetch_assoc($rsSelect));
        mysqli_free_result($rsSelect);
        return $ret;
    }

    require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

    require_once($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');

    $query_rsDevelopments = "SELECT * FROM  `queue_developsments`";
    $rsDevelopments = mysqli_query($inmoconn,$query_rsDevelopments) or die(mysqli_error());
    $row_rsDevelopments = mysqli_fetch_assoc($rsDevelopments);
    $totalRows_rsDevelopments = mysqli_num_rows($rsDevelopments);

    do {

        $images = getRecords("
            SELECT * FROM news_fotos
            WHERE imagen_img LIKE 'http%' AND noticia_img = '" . $row_rsDevelopments['promotion'] . "'
            ORDER BY id_img ASC
        ");

        foreach ($images as $image) {
            $namefile = uniqid($image['id_img'] . '_').".jpg";
            if ($file = file_get_contents_curl($image['imagen_img'])) {
                if (file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/".$namefile."", $file)) {
                    $query = "UPDATE news_fotos SET ";
                    $query .= "imagen_img = '" . $namefile . "' ";
                    $query .= "WHERE id_img = '".$image['id_img']."'";
                    mysqli_query($inmoconn, $query) or die(mysqli_error($inmoconn));
                    file_put_contents($lastUpdateFile, date("d-m-Y H:i:s"));
                }
            }
            $query_rsUpdate = "UPDATE  `news` SET  `activate_nws` =  '1' WHERE  `id_nws` ='" . $row_rsDevelopments['promotion'] . "'";
            mysqli_query($inmoconn, $query_rsUpdate) or die(mysqli_error($inmoconn));

            $query_rsUpdate = "DELETE FROM `queue_developsments`WHERE `id` ='" . $row_rsDevelopments['id'] . "'";
            mysqli_query($inmoconn, $query_rsUpdate) or die(mysqli_error($inmoconn));
        }

    } while ($row_rsDevelopments = mysqli_fetch_assoc($rsDevelopments));

}