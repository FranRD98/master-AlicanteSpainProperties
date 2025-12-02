<?php require_once('../../Connections/inmoconn.php');

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
  $colname_Recordset1 = $_GET['p'];
}
$query_Recordset1 = "
SELECT *
FROM citas WHERE id_ct = ".$_GET['id']."";
$Recordset1 = mysqli_query($inmoconn,$query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$events = array();

do {

  array_push($events, array(
      'id_ct' => $row_Recordset1['id_ct'],
      'categoria_ct' => $row_Recordset1['categoria_ct'],
      'user_ct' => $row_Recordset1['user_ct'],
      'users_ct' => $row_Recordset1['users_ct'],
      'vendedores_ct' => $row_Recordset1['vendedores_ct'],
      'property_ct' => $row_Recordset1['property_ct'],
      'inicio_ct' => date("d-m-Y H:i", strtotime($row_Recordset1['inicio_ct'])),
      'final_ct' => date("d-m-Y H:i", strtotime($row_Recordset1['final_ct'])),
      'titulo_ct' => $row_Recordset1['titulo_ct'],
      'lugar_ct' => $row_Recordset1['lugar_ct'],
      'notas_ct' => $row_Recordset1['notas_ct']
  ));

} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));


  echo json_encode($events);

mysqli_free_result($Recordset1);
?>