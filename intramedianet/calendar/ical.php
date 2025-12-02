<?php require_once('../../Connections/inmoconn.php');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

$comercial = "WHERE user_ct = '".$_SESSION['kt_login_id']."'";

$query_Recordset1 = "
SELECT
    citas.id_ct,
    citas.categoria_ct,
    citas.user_ct,
    citas.users_ct,
    citas.property_ct,
    citas.inicio_ct,
    citas.final_ct,
    citas.titulo_ct,
    citas.lugar_ct,
    citas.notas_ct,
    citas_categories.color_ct,
    citas_categories.category_".$_GET['lang']."_ct,
    users.nombre_usr,
    properties_client.id_cli,
    properties_client.nombre_cli,
    properties_client.apellidos_cli
FROM citas
    LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
    LEFT OUTER JOIN users ON citas.user_ct = users.id_usr
    LEFT OUTER JOIN properties_client ON citas.users_ct = properties_client.id_cli
";

$comercial = "WHERE tasks.admin_tsk = '".$_SESSION['kt_login_id']."' AND date_due_tsk != ''";


// $query_Recordset1 .= "
// UNION (
//     SELECT
//         tasks.id_tsk AS id_ct,
//         tasks.status_tsk AS categoria_ct,
//         tasks.admin_tsk AS user_ct,
//         '' AS users_ct,
//         '' AS property_ct,
//         tasks.date_due_tsk AS inicio_ct,
//         tasks.date_due_tsk AS final_ct,
//         tasks.subject_tsk AS titulo_ct,
//         '' AS lugar_ct,
//         tasks.description_tsk AS notas_ct,
//         '".$eventBgColor."' AS color_ct,
//         tasks_categories.categorias_".$_GET['lang']."_cat AS category_".$_GET['lang']."_ct,
//         '' AS nombre_usr,
//         '' AS id_cli,
//         '' AS nombre_cli,
//         '' AS apellidos_cli
//     FROM tasks
//         LEFT OUTER JOIN tasks_categories ON tasks.status_tsk = tasks_categories.id_cat
//         LEFT OUTER JOIN users ON tasks.admin_tsk = users.id_usr
// )
// ";
$query_Recordset1 .= " ORDER BY inicio_ct";
$Recordset1 = mysqli_query($inmoconn, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

// Variables used in this script:
//   $summary     - text title of the event
//   $datestart   - the starting date (in seconds since unix epoch)
//   $dateend     - the ending date (in seconds since unix epoch)
//   $address     - the event's address
//   $uri         - the URL of the event (add http://)
//   $description - text description of the event
//   $filename    - the name of this file for saving (e.g. my-event-name.ics)


header('Content-type: text/calendar; charset=utf-8');
// header('Content-Disposition: attachment; filename=' . $filename);

function dateToCal($timestamp) {
  $date = new DateTime(date("Y-m-d h:i:s", $timestamp), new DateTimeZone('Europe/Madrid'));
  if ((bool)$date->format('I') == 1) {
    return date('Ymd\THis\Z', strtotime("-2 hour", $timestamp));
  } else {
    return date('Ymd\THis\Z', strtotime("-1 hour", $timestamp));
  }
}

function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}

?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
<?php do { ?>
BEGIN:VEVENT
DTEND:<?php echo dateToCal(strtotime($row_Recordset1['final_ct'])); ?><?php echo "\n" ?>
UID:<?php echo $row_Recordset1['id_ct']; ?><?php echo "\n" ?>
DTSTAMP:<?php echo dateToCal(time()); ?><?php echo "\n" ?>
LOCATION:<?php echo escapeString($row_Recordset1['lugar_ct']); ?><?php echo "\n" ?>
DESCRIPTION:<?php echo escapeString(str_replace(array("\r\n", "\r"), " ", $row_Recordset1['notas_ct'])); ?><?php echo "\n" ?>
URL;VALUE=URI:<?php echo ''; ?><?php echo "\n" ?>
SUMMARY:<?php echo escapeString($row_Recordset1['nombre_usr'] . ' - ' . $row_Recordset1['titulo_ct'] . ' - ' . $row_Recordset1['nombre_cli'] . ' ' . $row_Recordset1['apellidos_cli']); ?><?php echo "\n" ?>
DTSTART:<?php echo dateToCal(strtotime($row_Recordset1['inicio_ct'])); ?><?php echo "\n" ?>
END:VEVENT
<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
END:VCALENDAR
