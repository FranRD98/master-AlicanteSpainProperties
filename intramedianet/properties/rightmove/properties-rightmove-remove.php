<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/vendor/autoload.php');

global $database_inmoconn, $inmoconn;
$query_rsFotocasaProperty = "SELECT * FROM `properties_properties` WHERE id_prop = '" . $tNG->getColumnValue('id_prop') . "'";
$rsFotocasaProperty = mysqli_query($inmoconn, $query_rsFotocasaProperty) or die(mysqli_error());
$row_rsFotocasaProperty = mysqli_fetch_assoc($rsFotocasaProperty);

$query_rsRMlocs = "SELECT * FROM rightmove_locations WHERE id_rml != '" . $export_rightmove_fields_prop['location'] . "'";
$rsRMlocs = mysqli_query($inmoconn, $query_rsRMlocs) or die(mysqli_error());
$row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs);
$totalRows_rsRMlocs = mysqli_num_rows($rsRMlocs);

$jsonRightmove = array();

$jsonRightmove['network']['network_id'] = $rightmoveNetworkId;
$jsonRightmove['branch']['branch_id'] = $rightmoveBranchId;
$jsonRightmove['branch']['channel'] = 1;
$jsonRightmove['property']['agent_ref'] = $tNG->getColumnValue('referencia_prop');
$jsonRightmove['property']['removal_reason'] = 7;
$jsonRightmove['property']['transaction_date'] = date('d-m-Y');

echo json_encode($jsonRightmove);