<?php require_once('../../Connections/inmoconn.php');

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

//session_start();

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

$comercial='';
if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info') {
    $comercial = "WHERE user_ct = '".$_SESSION['kt_login_id']."'";
}

$query_Recordset1 = "
SELECT citas.id_ct,
  citas.categoria_ct,
  citas.user_ct,
  citas.users_ct,
  citas.vendedores_ct,
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
  properties_client.apellidos_cli,
  properties_owner.id_pro,
  properties_owner.nombre_pro,
  properties_owner.apellidos_pro
FROM citas LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
   LEFT OUTER JOIN users ON citas.user_ct = users.id_usr
   LEFT OUTER JOIN properties_client ON citas.users_ct = properties_client.id_cli
   LEFT OUTER JOIN properties_owner ON citas.vendedores_ct = properties_owner.id_pro
    $comercial
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
//         users.nombre_usr,
//         '' AS id_cli,
//         '' AS nombre_cli,
//         '' AS apellidos_cli
//     FROM tasks
//         LEFT OUTER JOIN tasks_categories ON tasks.status_tsk = tasks_categories.id_cat
//         LEFT OUTER JOIN users ON tasks.admin_tsk = users.id_usr
//     $comercial
// )
// ";
$query_Recordset1 .= " ORDER BY inicio_ct";
$Recordset1 = mysqli_query($inmoconn,$query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$events = array();

function addRefs($ids) {

  global $database_inmoconn, $inmoconn;

  if ($ids == '') {
    return '';
  }

  // FIX BUG CALENDARIO
  if ($ids[0] == ',') {
      $ids = substr($ids, 1);
  }

  $query_rsRefs = "SELECT referencia_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
  $rsRefs = mysqli_query($inmoconn, $query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
  $row_rsRefs = mysqli_fetch_assoc($rsRefs);
  $totalRows_rsRefs = mysqli_num_rows($rsRefs);

  $ret = array();

  do {

    array_push($ret, $row_rsRefs['referencia_prop']);

  } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));


  return implode(', ', $ret);

}

function addRefsIds($ids) {

  global $database_inmoconn, $inmoconn;

  if ($ids == '') {
    return '';
  }

  // FIX BUG CALENDARIO
  if ($ids[0] == ',') {
      $ids = substr($ids, 1);
  }

  $query_rsRefs = "SELECT id_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
  $rsRefs = mysqli_query($inmoconn,$query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
  $row_rsRefs = mysqli_fetch_assoc($rsRefs);
  $totalRows_rsRefs = mysqli_num_rows($rsRefs);

  $ret = array();

  do {

    array_push($ret, $row_rsRefs['id_prop']);

  } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));


  return implode(', ', $ret);

}

do {

    $title = $row_Recordset1['titulo_ct'] . ' - ' . $row_Recordset1['nombre_usr'];

    if ($row_Recordset1['nombre_cli'] != '' || $row_Recordset1['nombre_cli'] != '') {
        $title .= ' | ' . $row_Recordset1['nombre_cli'] . ' ' . $row_Recordset1['apellidos_cli'] . '';
    }

    if ($row_Recordset1['nombre_pro'] != '' || $row_Recordset1['nombre_pro'] != '') {
        $title .= ' | ' . $row_Recordset1['nombre_pro'] . ' ' . $row_Recordset1['apellidos_pro'] . '';
    }
    if ($row_Recordset1['property_ct'] != '') {
        $title .= ' | ' . addRefs($row_Recordset1['property_ct']) . '';
    }
    if ($row_Recordset1['lugar_ct'] != '') {
        $title .= ' | ' . $row_Recordset1['lugar_ct'] . '';
    }

    $editable = true;

    if ($row_Recordset1['color_ct'] == $eventBgColor) {
        $editable = false;
    }

    array_push($events, array(
        'id' => $row_Recordset1['id_ct'],
        'title' => $title,
        'start' => $row_Recordset1['inicio_ct'],
        'end' => $row_Recordset1['final_ct'],
      'backgroundColor' => $row_Recordset1['color_ct'],
      'borderColor' => $row_Recordset1['color_ct'],
      'textColor' => '#000',
      'allDay' => false,
      'category' => $row_Recordset1['category_'.$_GET['lang'].'_ct'],
      'property' => addRefs($row_Recordset1['property_ct']),
      'ref' => addRefs($row_Recordset1['property_ct']),
      'ids' => addRefsIds($row_Recordset1['property_ct']),
      'user' => $row_Recordset1['nombre_usr'],
      'idn' => $row_Recordset1['id_cli'],
      'usern' => $row_Recordset1['nombre_cli'],
      'usera' => $row_Recordset1['apellidos_cli'],
      'idv' => $row_Recordset1['id_pro'],
      'userv' => $row_Recordset1['nombre_pro'],
      'userva' => $row_Recordset1['apellidos_pro'],
      'titulo' => $row_Recordset1['titulo_ct'],
      'lugar' => $row_Recordset1['lugar_ct'],
      'inicio' => date("d-m-Y H:i", strtotime($row_Recordset1['inicio_ct'])),
      'final' => date("d-m-Y H:i", strtotime($row_Recordset1['final_ct'])),
      'notas' => $row_Recordset1['notas_ct'],
      'editable' => $editable
  ));

} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));


// echo "<pre>";
// print_r($events);
// echo "</pre>";


    echo json_encode($events);

mysqli_free_result($Recordset1);
?>