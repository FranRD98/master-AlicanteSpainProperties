<?php require_once('../../Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');


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

$colname_Recordset1 = "-1";
if (isset($_GET['p'])) {
    $colname_Recordset1 = $_GET['p'];
}

$colname_Recordset1 = mysqli_real_escape_string($inmoconn,$colname_Recordset1);

$query_Recordset1 = sprintf("SELECT * FROM properties_disponibilidad WHERE property_disp = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysqli_query($inmoconn,$query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$events = array();

do {
    $status = ($row_Recordset1['privado_disp'] == 1)?$lang['Privado']:$lang['Público'];

    array_push($events, array(
            'id' => $row_Recordset1['id_disp'],
            'title' => date("d-m-Y", strtotime($row_Recordset1['inicio_disp'])) . " - " . date("d-m-Y", strtotime($row_Recordset1['final_disp'])) . " (" . $status . ") " ,
            'start' => $row_Recordset1['inicio_disp'],
            'end' => $row_Recordset1['final_disp']		));
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));


    echo json_encode($events);

mysqli_free_result($Recordset1);
