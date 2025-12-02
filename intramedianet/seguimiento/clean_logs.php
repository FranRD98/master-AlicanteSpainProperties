<?php
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

$query_rsIDS = "SELECT prop_id_log FROM properties_log GROUP BY prop_id_log";
$rsIDS = mysqli_query($inmoconn,$query_rsIDS) or die(mysqli_error());
$row_rsIDS = mysqli_fetch_assoc($rsIDS);
$totalRows_rsIDS = mysqli_num_rows($rsIDS);

do {
    if (isImported($row_rsIDS['prop_id_log'])) {
        $query_rsEntradas = "SELECT id_log FROM properties_log WHERE prop_id_log = '" . $row_rsIDS['prop_id_log'] . "' ORDER BY id_log DESC";
        $rsEntradas = mysqli_query($inmoconn, $query_rsEntradas) or die(mysqli_error());
        $row_rsEntradas = mysqli_fetch_assoc($rsEntradas);
        $totalRows_rsEntradas = mysqli_num_rows($rsEntradas);
        if ($totalRows_rsEntradas > 10) {
            $i = 1;
            do {
                if ($i++ > 10) {
                    $query_rsDelete = "DELETE FROM properties_log WHERE id_log = '" . $row_rsEntradas['id_log'] . "'";
                    $rsDelete = mysqli_query($inmoconn, $query_rsDelete) or die(mysqli_error());
                }
            } while ($row_rsEntradas = mysqli_fetch_assoc($rsEntradas));
        }
    }
} while ($row_rsIDS = mysqli_fetch_assoc($rsIDS));

function isImported($id) {
    global $database_inmoconn, $inmoconn;
    $query_rsprop = "SELECT user_prop FROM properties_properties WHERE id_prop = '" . $id . "'";
    $rsprop = mysqli_query($inmoconn, $query_rsprop) or die(mysqli_error());
    $row_rsprop = mysqli_fetch_assoc($rsprop);
    $totalRows_rsprop = mysqli_num_rows($rsprop);
    return ($row_rsprop['user_prop'] == 0)?true:false;
}


$query_rsDelete = "DELETE FROM properties_log_2 WHERE date_log < DATE_SUB(CURDATE(), INTERVAL 12 MONTH)";
$rsDelete = mysqli_query($query_rsDelete, $inmoconn) or die(mysqli_error());


?>