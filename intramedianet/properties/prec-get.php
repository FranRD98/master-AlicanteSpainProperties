<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');
// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');
// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/lang_' . $_GET['lang'] . '.php');

$query_rsPrecios = "
SELECT * FROM `properties_prices` WHERE `id_prc` = '".$_GET['id']."'";
$rsPrecios = mysqli_query($inmoconn, $query_rsPrecios) or die(mysqli_error());
$row_rsPrecios = mysqli_fetch_assoc($rsPrecios);
$totalRows_rsPrecios = mysqli_num_rows($rsPrecios);

echo date("d-m-Y",strtotime($row_rsPrecios['from_prc'])) .'@' . date("d-m-Y",strtotime($row_rsPrecios['to_prc'])) .'@' . $row_rsPrecios['price_prc']  .'@' . $row_rsPrecios['id_prc']  ;

?>