<?php
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');
// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("9");
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

if(isset($_GET['from_prc']))
    $desde = date('Y-m-d', strtotime($_GET['from_prc']));
if(isset($_GET['to_prc']))
$hasta = date('Y-m-d', strtotime($_GET['to_prc']));

if(isset($_GET['KT_Insert1']) && $_GET['KT_Insert1'] == '1') {


    $query_rsVideos = "
    INSERT INTO `properties_prices`
    (`id_prc`, `property_prc`, `from_prc`, `to_prc`, `price_prc`)
    VALUES
    (NULL, '".$_GET['id_prop']."', '".$desde."', '".$hasta."', '".$_GET['price_prc']."')
    ;";
    $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());

    echo 'ok';

}
if(isset($_GET['KT_Update1']) && $_GET['KT_Update1'] == '1') {

    $query_rsVideos = "
    UPDATE `properties_prices` SET
    `property_prc` = '".$_GET['id_prop']."', `from_prc` = '".$desde."', `to_prc` = '".$hasta."', `price_prc` = '".$_GET['price_prc']."' WHERE `id_prc` = '".$_GET['id']."'";

    $rsVideos = mysqli_query($inmoconn, $query_rsVideos) or die(mysqli_error());

    echo 'ok';

}
if(isset($_GET['KT_Delete1']) && $_GET['KT_Delete1'] == '1') {

    $query_rsVideos = "
    DELETE FROM `properties_prices` WHERE `id_prc` = '".$_GET['id']."'
    ;";
    $rsVideos = mysqli_query($inmoconn, $query_rsVideos) or die(mysqli_error());

    echo 'ok';

}



?>