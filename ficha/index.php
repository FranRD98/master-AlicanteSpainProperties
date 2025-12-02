<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

$codigo=$_GET["codigo"];

$soyinmo=substr($codigo,0,strpos($codigo,"_"));

$datofe=substr($codigo,strpos($codigo,"_")+1,strlen($codigo));

$query_rsProp = "SELECT id_prop FROM properties_properties WHERE id_inmovilla_prop = '" . $datofe . "'";
$rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
$row_rsProp = mysqli_fetch_assoc($rsProp);
$totalRows_rsProp = mysqli_num_rows($rsProp);

if ($totalRows_rsProp > 0) {
    header("Location: " . propURL($row_rsProp['id_prop'], 'es'));
    die();
} else {
    header("Location: /");
}
