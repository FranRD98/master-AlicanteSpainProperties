<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

$colname_Recordset1 = "-1";
if (isset($_GET['p'])) {
  $colname_Recordset1 = simpleSanitize($_GET['p']);
}
$query_Recordset1 = "SELECT id_disp, inicio_disp, final_disp    FROM properties_disponibilidad    WHERE property_disp = ".simpleSanitize(($_GET['p']))." AND privado_disp = 0 ORDER BY inicio_disp ASC";
$Recordset1 = mysqli_query($inmoconn, $query_Recordset1) or die(mysqli_error() .'<hr>' .$query_Recordset1);
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$events = array();

do {

	array_push($events, array(
			'id' => $row_Recordset1['id_disp'],
      'title' => '',
      // 'title' => date("d-m-Y", strtotime($row_Recordset1['inicio_disp'])) . " → " . date("d-m-Y", strtotime($row_Recordset1['final_disp'])),
			'start' => $row_Recordset1['inicio_disp'],
			'end' => $row_Recordset1['final_disp']		));

} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));


	echo json_encode($events);

mysqli_free_result($Recordset1);
?>
