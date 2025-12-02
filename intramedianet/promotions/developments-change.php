<?php
set_time_limit(0);

// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

if ($_GET['v'] == 2) {
    $query_rsPaises = "INSERT INTO  `queue_developsments` SET  promotion =  '".$_GET['id_prop']."';";
    mysqli_query($inmoconn, $query_rsPaises) or die(mysqli_error());
}

$query_rsPaises = "UPDATE  `news` SET  `".$_GET['s']."` =  '".$_GET['v']."' WHERE  `id_nws` ='".$_GET['id_prop']."';";

if (mysqli_query($inmoconn,$query_rsPaises)) {
    if($_GET['v'] == 0) {
        echo '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
    } else {
        echo '<div class="text-center mt-1"><i class="fa-solid fa-spinner fa-spin-pulse fs-4 fw-bolder"></i></div>';
    }
} else {
    die(mysqli_error());
}