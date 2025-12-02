<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');


$rResult = mysqli_query($inmoconn, "SET NAMES 'utf8'");

//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


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
 
$query_rsEmails = "SELECT * FROM mail_queue ORDER BY `date` ASC LIMIT 50";
$rsEmails = mysqli_query($inmoconn,$query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);

?>
<?php



do {

    sendAppEmail($row_rsEmails['tom'], '', '', '', $row_rsEmails['subject'], $row_rsEmails['message']);

    $query_rsDelete = "DELETE FROM `mail_queue` WHERE `mail_queue`.`id` = '".$row_rsEmails['id']."' LIMIT 1";
    $rsDelete = mysqli_query($inmoconn, $query_rsDelete) or die(mysqli_error());


} while ($row_rsEmails = mysqli_fetch_assoc($rsEmails));


mysqli_free_result($rsEmails);
?>
