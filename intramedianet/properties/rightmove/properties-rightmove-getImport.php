<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/vendor/autoload.php');

global $database_inmoconn, $inmoconn;
$query_rsFotocasaProperty = "SELECT * FROM `properties_properties` WHERE id_prop = '" . $_GET['id_prop'] . "'";
$rsFotocasaProperty = mysqli_query($inmoconn, $query_rsFotocasaProperty) or die(mysqli_error());
$row_rsFotocasaProperty = mysqli_fetch_assoc($rsFotocasaProperty);

$export_rightmove_fields_prop = json_decode($row_rsFotocasaProperty['export_rightmove_fields_prop'], true);

$query_rsRMlocs = "SELECT * FROM rightmove_locations WHERE id_rml != '" . $export_rightmove_fields_prop['location'] . "'";
$rsRMlocs = mysqli_query($inmoconn, $query_rsRMlocs) or die(mysqli_error());
$row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs);
$totalRows_rsRMlocs = mysqli_num_rows($rsRMlocs);
$jsonRightmove = array();

$jsonRightmove['network']['network_id'] = $rightmoveNetworkId;
$jsonRightmove['branch']['branch_id'] = $rightmoveBranchId;
$jsonRightmove['branch']['channel'] = 1;

echo json_encode($jsonRightmove);