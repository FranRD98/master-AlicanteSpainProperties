<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

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
// $restrict->Execute();
//End Restrict Access To Page

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsproveedor = "-1";
if (isset($_GET['p'])) {
  $colname_rsproveedor = $_GET['p'];
}

$colname_rsproveedor = mysqli_real_escape_string($inmoconn, $colname_rsproveedor);


$query_rsproveedor = sprintf("SELECT * FROM xml WHERE id_xml = %s", GetSQLValueString($colname_rsproveedor, "int"));
$rsproveedor = mysqli_query($inmoconn, $query_rsproveedor) or die(mysqli_error());
$row_rsproveedor = mysqli_fetch_assoc($rsproveedor);
$totalRows_rsproveedor = mysqli_num_rows($rsproveedor);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
<style type="text/css">
p {
  font-size: 14px;
  font-weight: bold;
  color: #060;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  padding: 0 0 10px 0;
}
ul.stats-tabs {
  margin: 0;
  padding: 0;
}
ul.stats-tabs li {
  float: left;
  margin: 0 15px 0 0;
  padding: 0 15px 0 0;
  list-style:none;
  border-right: 1px solid #ccc;
}
ul.stats-tabs li:last-child {
  margin: 0;
  padding: 0;
  border: none;
}
ul.stats-tabs li div {
  display: block;
  float: left;
  font-size: 18px;
  font-weight: bold;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  color: #444;
}
ul.stats-tabs li div span {
  display: block;
  margin-top: 2px;
  font-size: 13px;
  font-weight: normal;
  color: #777;
  text-transform: uppercase;
}
.btn-primary {
    color: #fff;
    background-color: #1e2225;
    border-color: #0e1011
    outline: 0;
    -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125)
    background-image: none
    display: inline-block;
    margin-bottom: 0;
    font-weight: 400;
    text-align: center;
    cursor: pointer;
    border: 1px solid transparent;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    border-radius: 0;
    -ms-user-select: none;
    user-select: none;
    vertical-align: middle;
    text-decoration: none;
}
</style>
</head>

<body>

<?php

switch ($row_rsproveedor['tipo_xml']) {
    case 1:
        $tipo = "Kyero";
        break;
    case 2:
        $tipo = "Mediaelx";
        break;
    case 3:
        $tipo = "Inmovilla";
        break;
    case 5:
        $tipo = "Resales";
        break;
    case 6:
        $tipo = "Redsp";
        break;
    case 7:
        $tipo = "Habihub";
        break;
}

$inline_errors = 1;

include_once("importadores/_utils.php");
include_once("importadores/_utils_kyero.php");
include_once("importadores/_utils_mediaelx.php");
include_once("importadores/_utils_inmovilla.php");
include_once("importadores/_utils_resales.php");
include_once("importadores/_utils_redsp.php");
include_once("importadores/_utils_habihub.php");
include_once("importadores/".$tipo.".php");

array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
// generateMapping();

if ($autotraduccion == 1) {
   include($_SERVER["DOCUMENT_ROOT"] . "/intramedianet/translate/auto-translate.php");
   generateMapping();
}

?>



</body>
</html>
