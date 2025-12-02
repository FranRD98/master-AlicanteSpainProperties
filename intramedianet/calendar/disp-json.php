<?php require_once('../../Connections/inmoconn.php');

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

//session_start();

/*
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
*/
$comercial='';
if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info') {
    if ($_SESSION['kt_login_level'] == 9) {
        if (!isset($_GET['users_com'])) {
            $comercial = '';
        } else {
            $comercial = "WHERE user_ct IN (".implode(',', $_GET['users_com']).")";
        }
    } else {
        $comercial = "WHERE user_ct = '".$_SESSION['kt_login_id']."'";
    }
}

$texto = ''; 
if ($_GET['textflds'] != '') {
    $startQRY = '';
    if ($comercial == '') {
        $startQRY = 'WHERE';
    } else {
        $startQRY = 'AND';
    }
    $texto = " " .$startQRY . " (
        category_".$_GET['lang']."_ct LIKE '%" . $_GET['textflds'] . "%'
        OR nombre_cli LIKE '%" . $_GET['textflds'] . "%'
        OR apellidos_cli LIKE '%" . $_GET['textflds'] . "%'
        OR nombre_usr LIKE '%" . $_GET['textflds'] . "%'
        OR notas_ct LIKE '%" . $_GET['textflds'] . "%'
        OR lugar_ct LIKE '%" . $_GET['textflds'] . "%'
        OR titulo_ct LIKE '%" . $_GET['textflds'] . "%'
        ";

    
    $query_rsRefs = "SELECT referencia_prop, id_prop FROM properties_properties WHERE referencia_prop LIKE '%".$_GET['textflds']."%'";
    $rsRefs = mysqli_query($inmoconn,$query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
    $row_rsRefs = mysqli_fetch_assoc($rsRefs);
    $totalRows_rsRefs = mysqli_num_rows($rsRefs);

    do {
        $texto .= " OR FIND_IN_SET('".$row_rsRefs['id_prop']."', property_ct) ";
    } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));

    $texto .= ")";
}


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
    properties_client.apellidos_cli,
    properties_owner.id_pro,
    properties_owner.nombre_pro,
    properties_owner.apellidos_pro
FROM citas
    LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
    LEFT OUTER JOIN users ON citas.user_ct = users.id_usr
    LEFT OUTER JOIN properties_client ON citas.users_ct = properties_client.id_cli
   LEFT OUTER JOIN properties_owner ON citas.vendedores_ct = properties_owner.id_pro
$comercial
$texto
";

if ($_SESSION['kt_login_level'] == 9) {
    if (!isset($_GET['users_com'])) {
        $comercial = 'WHERE date_due_tsk != \'\'';
    } else {
        $comercial = "WHERE tasks.admin_tsk IN (".implode(',', $_GET['users_com']).") AND date_due_tsk != ''";
    }
} else {
    $comercial = "WHERE tasks.admin_tsk = '".$_SESSION['kt_login_id']."' AND date_due_tsk != ''";
}

$texto = '';
if ($_GET['textflds'] != '') {
    $startQRY = '';
    if ($comercial == '') {
        $startQRY = 'WHERE';
    } else {
        $startQRY = 'AND';
    }
    $texto = " " .$startQRY . " (
        tasks_categories.categorias_".$_GET['lang']."_cat LIKE '%" . $_GET['textflds'] . "%'
        OR tasks.subject_tsk LIKE '%" . $_GET['textflds'] . "%'
        )";
}



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
//     $texto
// )
// ";
$query_Recordset1 .= " ORDER BY inicio_ct";
$Recordset1 = mysqli_query($inmoconn,$query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$events = array();

function addRefs($ids)
{
    global $database_inmoconn, $inmoconn;

    if ($ids == '') {
        return '';
    }

    // FIX BUG CALENDARIO
    if ($ids[0] == ',') {
        $ids = substr($ids, 1);
    }

    
    $query_rsRefs = "SELECT referencia_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
    $rsRefs = mysqli_query($inmoconn,$query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
    $row_rsRefs = mysqli_fetch_assoc($rsRefs);
    $totalRows_rsRefs = mysqli_num_rows($rsRefs);

    $ret = array();

    do {
        array_push($ret, $row_rsRefs['referencia_prop']);
    } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));


    return implode(', ', $ret);
}

function addRefsIds($ids)
{
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

function safeValue($data, $default = ''){
    if($data)
     $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data !== null ? $data : $default;
}

$events = array();
do {
    $title = safeValue($row_Recordset1['titulo_ct']) . ' - ' . safeValue($row_Recordset1['nombre_usr']);

    if ($row_Recordset1['nombre_cli'] != '' || $row_Recordset1['nombre_cli'] != '') {
        $title .= ' | ' . safeValue($row_Recordset1['nombre_cli']) . ' ' . safeValue($row_Recordset1['apellidos_cli']);
    }

    if ($row_Recordset1['nombre_pro'] != '' || $row_Recordset1['nombre_pro'] != '') {
        $title .= ' | ' . safeValue($row_Recordset1['nombre_pro']) . ' ' . safeValue($row_Recordset1['apellidos_pro']);
    }
    if ($row_Recordset1['property_ct'] != '') {
        $title .= ' | ' . safeValue(addRefs($row_Recordset1['property_ct']));
    }
    if ($row_Recordset1['lugar_ct'] != '') {
        $title .= ' | ' . safeValue($row_Recordset1['lugar_ct']);
    }

    $editable = true;

    if ($row_Recordset1['color_ct'] == $eventBgColor) {
        $editable = false;
    }

    array_push($events, array(
        'id' => safeValue($row_Recordset1['id_ct']),
        'title' => $title,
        'start' => safeValue($row_Recordset1['inicio_ct']),
        'end' => safeValue($row_Recordset1['final_ct']),
        'backgroundColor' => safeValue($row_Recordset1['color_ct']),
        'borderColor' => safeValue($row_Recordset1['color_ct']),
        'textColor' => '#000',
        'allDay' => false,
        'category' => safeValue($row_Recordset1['category_'.$_GET['lang'].'_ct']),
        'property' => safeValue(addRefs($row_Recordset1['property_ct'])),
        'ref' => safeValue(addRefs($row_Recordset1['property_ct'])),
        'ids' => safeValue(addRefsIds($row_Recordset1['property_ct'])),
        'user' => safeValue($row_Recordset1['nombre_usr']),
        'idn' => safeValue($row_Recordset1['id_cli']),
        'usern' => safeValue($row_Recordset1['nombre_cli']),
        'usera' => safeValue($row_Recordset1['apellidos_cli']),
        'idv' => safeValue($row_Recordset1['id_pro']),
        'userv' => safeValue($row_Recordset1['nombre_pro']),
        'userva' => safeValue($row_Recordset1['apellidos_pro']),
        'titulo' => safeValue($row_Recordset1['titulo_ct']),
        'lugar' => safeValue($row_Recordset1['lugar_ct']),
        'inicio' => safeValue(date("d-m-Y H:i", strtotime($row_Recordset1['inicio_ct']))),
        'final' => safeValue(date("d-m-Y H:i", strtotime($row_Recordset1['final_ct']))),
        'notas' => safeValue($row_Recordset1['notas_ct']),
        'editable' => $editable
    ));
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));



// echo "<pre>";
// print_r($events);
// echo "</pre>";


echo json_encode($events);
//mysqli_free_result($Recordset1);
