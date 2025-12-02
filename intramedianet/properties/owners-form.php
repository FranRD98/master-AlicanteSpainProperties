<?php
// Cargamos la conexión a MySql
include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// Cargamos los idiomas de la administración
include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');

// Load the common classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

// Load the tNG classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

// Load the KT_back class
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

if (!isset($_GET['id_pro'])) {
    
    $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'properties_owner_files'";
    $rsNextIncrement = mysqli_query($inmoconn,$query_rsNextIncrement) or die(mysqli_error());
    $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

    $ownerId = $row_rsNextIncrement['Auto_increment'];
} else {
    $ownerId = $_GET['id_pro'];
}

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        /*
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);
        */

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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_pro", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger


$query_rsFiles = "SELECT * FROM properties_owner_files WHERE owner_fil = '".$ownerId."' ";
$rsFiles = mysqli_query($inmoconn,$query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);


$query_rsStatus = "SELECT * FROM properties_owner_states ORDER BY category_".$lang_adm."_sts ASC";
$rsStatus = mysqli_query($inmoconn,$query_rsStatus) or die(mysqli_error());
$row_rsStatus = mysqli_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysqli_num_rows($rsStatus);


$query_rsColaboradores = "SELECT * FROM properties_collaborators ORDER BY nombre_comercial_col ASC";
$rsColaboradores = mysqli_query($inmoconn,$query_rsColaboradores) or die(mysqli_error());
$row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores);
$totalRows_rsColaboradores = mysqli_num_rows($rsColaboradores);


$query_rsCaptado = "SELECT * FROM properties_owner_captado ORDER BY category_".$lang_adm."_cap ASC";
$rsCaptado = mysqli_query($inmoconn,$query_rsCaptado) or die(mysqli_error());
$row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
$totalRows_rsCaptado = mysqli_num_rows($rsCaptado);


$query_rsSources = "SELECT * FROM properties_owner_sources ORDER BY category_".$lang_adm."_sts ASC";
$rsSources = mysqli_query($inmoconn,$query_rsSources) or die(mysqli_error());
$row_rsSources = mysqli_fetch_assoc($rsSources);
$totalRows_rsSources = mysqli_num_rows($rsSources);


$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct FROM citas_categories ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn,$query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);


$query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsusuarios = mysqli_query($inmoconn,$query_rsusuarios) or die(mysqli_error());
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);


$query_rsclientes = "SELECT nombre_cli, apellidos_cli, id_cli FROM properties_client ORDER BY nombre_cli, apellidos_cli";
$rsclientes = mysqli_query($inmoconn,$query_rsclientes) or die(mysqli_error());
$row_rsclientes = mysqli_fetch_assoc($rsclientes);
$totalRows_rsclientes = mysqli_num_rows($rsclientes);


$query_rsvendor = "SELECT nombre_pro, apellidos_pro, id_pro FROM properties_owner ORDER BY nombre_pro, apellidos_pro";
$rsvendor = mysqli_query($inmoconn,$query_rsvendor) or die(mysqli_error());
$row_rsvendor = mysqli_fetch_assoc($rsvendor);
$totalRows_rsvendor = mysqli_num_rows($rsvendor);


$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

$query_rsNationalities = "SELECT id_ncld, nacionalidad_".$lang_adm."_ncld FROM nacionalidades ORDER BY nacionalidad_".$lang_adm."_ncld";
$rsNationalities = mysqli_query($inmoconn,$query_rsNationalities) or die(mysqli_error());
$row_rsNationalities = mysqli_fetch_assoc($rsNationalities);
$totalRows_rsNationalities = mysqli_num_rows($rsNationalities);

$query_rsTemplates = "SELECT * FROM templates WHERE week_tmpl = 0 ORDER BY name_".$lang_adm."_tmpl ASC";
$rsTemplates = mysqli_query($inmoconn,$query_rsTemplates) or die(mysqli_error());
$row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
$totalRows_rsTemplates = mysqli_num_rows($rsTemplates);


$where_id_pro = "";
if(isset($_GET['id_pro'])){
    $where_id_pro = "AND contact_tsk = '".$_GET['id_pro']."'";
}

$query_rsTasks = "
SELECT SQL_CALC_FOUND_ROWS
  (SELECT nombre_usr FROM users WHERE id_usr  = admin_tsk) as admin_tsk,
  subject_tsk,
  date_due_tsk,
  priority_tsk,
  property_tsk,
  (SELECT categorias_".$lang_adm."_cat as cat FROM tasks_categories WHERE id_cat = status_tsk) as status_tsk,
  status_tsk as status_tsk2,
  case contact_type_tsk
      when '1' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-male\"></i> ', nombre_cnt, apellidos_cnt) FROM contactos WHERE id_cnt = contact_tsk)
      when '2' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-users\"></i> ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = contact_tsk)
      when '3' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-key\"></i> ', nombre_pro, apellidos_pro) FROM properties_owner WHERE id_pro = contact_tsk)
      when '' then ''
  end as contact_type_tsk,
  id_tsk
FROM tasks
WHERE contact_type_tsk = 3 ".$where_id_pro."
 ORDER BY id_tsk DESC
";
$rsTasks = mysqli_query($inmoconn,$query_rsTasks) or die(mysqli_error());
$row_rsTasks = mysqli_fetch_assoc($rsTasks);
$totalRows_rsTasks = mysqli_num_rows($rsTasks);

function addRefs($ids)
{
    global $database_inmoconn, $inmoconn;

    if ($ids == '') {
        return '';
    }

    
    $query_rsRefs = "SELECT referencia_prop, id_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
    $rsRefs = mysqli_query($inmoconn,$query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
    $row_rsRefs = mysqli_fetch_assoc($rsRefs);
    $totalRows_rsRefs = mysqli_num_rows($rsRefs);

    $ret = array();

    do {
        array_push($ret, '<a href="/intramedianet/properties/properties-form.php?id_prop='.$row_rsRefs['id_prop'].'" target="_blank" class="btn btn-soft-primary btn-sm">'.$row_rsRefs['referencia_prop'].'</a>');
    } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));


    return implode(' ', $ret);
}

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect(&$tNG)
{
    $redObj = new tNG_Redirect($tNG);
    $redObj->setURL("owners-form.php?id_pro=".$tNG->getPrimaryKeyValue()."&u=ok");
    $redObj->setKeepURLParams(false);
    return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2(&$tNG)
{
    $tblDelObj = new tNG_DeleteDetailRec($tNG);
    $tblDelObj->setTable("properties_owner_files");
    $tblDelObj->setFieldName("owner_fil");
    $tblDelObj->addFile("{file_fil}", "../../media/files/owners/");
    return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG)
{
    global $lang;
    $tblFldObj = new tNG_CheckUnique($tNG);
    $tblFldObj->setTable("properties_owner");
    $tblFldObj->addFieldName("email_pro");
    $tblFldObj->setErrorMsg($lang['Registro duplicado'] . ": {email_pro}");
    return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

//start Trigger_AddToNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_AddToNewsletter(&$tNG)
{
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaOwners;
    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    if ($_POST['newsletter_pro'] == 1) {
        if ($_POST['email_pro'] != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $acumba->addSubscriber($acumbamailIdListaOwners[$_POST['idioma_pro']], array(
              'email'  => $_POST['email_pro'],
              'nombre'  => $_POST['nombre_pro']
            ));
        }
    } else {
        
        $query_rsClint = "SELECT * FROM properties_owner WHERE id_pro = '".$_GET['id_pro']."'";
        $rsClint = mysqli_query($inmoconn,$query_rsClint) or die(mysqli_error());
        $row_rsClint = mysqli_fetch_assoc($rsClint);
        $totalRows_rsClint = mysqli_num_rows($rsClint);
        $email = $row_rsClint['email_pro'];
        if ($email != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $miembros = $acumba->searchSubscriber($email);
            foreach ($miembros as $key => $value) {
                if ($acumbamailIdListaOwners[$_POST['idioma_pro']] == $value['list_id']) {
                    $acumba = new AcumbamailAPI($keyAcumbamail);
                    $acumba->deleteSubscriber($acumbamailIdListaOwners[$_POST['idioma_pro']], $value['email']);
                }
            }
        }
    }
}
//end Trigger_AddToNewsletter trigger

//start Trigger_DeletFromNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_DeletFromNewsletter(&$tNG)
{
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaOwners;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    
    $query_rsClint = "SELECT * FROM properties_owner WHERE id_pro = '".$_GET['id_pro']."'";
    $rsClint = mysqli_query($inmoconn,$query_rsClint) or die(mysqli_error());
    $row_rsClint = mysqli_fetch_assoc($rsClint);
    $totalRows_rsClint = mysqli_num_rows($rsClint);

    $email = $row_rsClint['email_pro'];
    $idioma = $row_rsClint['idioma_pro'];

    if ($email != '') {
        $acumba = new AcumbamailAPI($keyAcumbamail);
        $miembros = $acumba->searchSubscriber($email);
        foreach ($miembros as $key => $value) {
            if ($acumbamailIdListaOwners[$idioma] == $value['list_id']) {
                $acumba = new AcumbamailAPI($keyAcumbamail);
                $acumba->deleteSubscriber($acumbamailIdListaOwners[$idioma], $value['email']);
            }
        }
    }
}
//end Trigger_DeletFromNewsletter trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG)
{
    $tNG->addColumn("user_pro", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
    $tNG->addColumn("fecha_alta_pro", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
    return $tNG->getError();
}
//end addFields trigger

if(isset($_POST["worker"]) && is_array($_POST["worker"])) {
    $_POST["workers_pro"] = implode("@@@@@@", $_POST["worker"]);
}
//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog(&$tNG)
{
    global $_SESSION;

    logVendor($_SESSION['kt_login_id'], $tNG->getColumnValue('id_pro'), $tNG->getColumnValue('nombre_pro') . ' ' . $tNG->getColumnValue('apellidos_pro'), '1');
}
//end addLog trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog(&$tNG)
{
    global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

    
    $query_rsProp = "SELECT * FROM properties_owner WHERE id_pro = ".$_GET['id_pro'];
    $rsProp = mysqli_query($inmoconn,$query_rsProp) or die(mysqli_error());
    $row_rsProp = mysqli_fetch_assoc($rsProp);
    $totalRows_rsProp = mysqli_num_rows($rsProp);


    logVendor($_SESSION['kt_login_id'], $row_rsProp['id_pro'], $row_rsProp['nombre_pro'] . ' ' . $row_rsProp['apellidos_pro'], 2);
}
//end editLog trigger

//start deleteLog trigger
//remove this line if you want to edit the code by hand
function deleteLog(&$tNG)
{
    global $_SESSION, $_GET, $database_inmoconn, $inmoconn;

    
    $query_rsProp = "SELECT * FROM properties_owner WHERE id_pro = ".$_GET['id_pro'];
    $rsProp = mysqli_query($inmoconn,$query_rsProp) or die(mysqli_error());
    $row_rsProp = mysqli_fetch_assoc($rsProp);
    $totalRows_rsProp = mysqli_num_rows($rsProp);

    logVendor($_SESSION['kt_login_id'], $row_rsProp['id_pro'], $row_rsProp['nombre_pro'] . ' ' . $row_rsProp['apellidos_pro'], '5');
}
//end deleteLog trigger

// Make an insert transaction instance
$ins_properties_owner = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_owner);
// Register triggers
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_owner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_owner->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
$ins_properties_owner->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// $ins_properties_owner->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
$ins_properties_owner->registerTrigger("BEFORE", "addFields", 10);
$ins_properties_owner->registerTrigger("AFTER", "addLog", 10);
if ($actMailchimp == 1) {
    $ins_properties_owner->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
// Add columns
$ins_properties_owner->setTable("properties_owner");
$ins_properties_owner->addColumn("nombre_pro", "STRING_TYPE", "POST", "nombre_pro");
$ins_properties_owner->addColumn("apellidos_pro", "STRING_TYPE", "POST", "apellidos_pro");
$ins_properties_owner->addColumn("direccion_pro", "STRING_TYPE", "POST", "direccion_pro");
$ins_properties_owner->addColumn("telefono_fijo_pro", "STRING_TYPE", "POST", "telefono_fijo_pro");
$ins_properties_owner->addColumn("telefono_movil_pro", "STRING_TYPE", "POST", "telefono_movil_pro");
$ins_properties_owner->addColumn("email_pro", "STRING_TYPE", "POST", "email_pro");
$ins_properties_owner->addColumn("skype_pro", "STRING_TYPE", "POST", "skype_pro");
$ins_properties_owner->addColumn("como_nos_conocio_pro", "STRING_TYPE", "POST", "como_nos_conocio_pro");
$ins_properties_owner->addColumn("captado_por_pro", "STRING_TYPE", "POST", "captado_por_pro");
$ins_properties_owner->addColumn("fecha_alta_pro", "DATE_TYPE", "POST", "fecha_alta_pro", "{NOW}");
$ins_properties_owner->addColumn("next_call_pro", "DATE_TYPE", "POST", "next_call_pro");
$ins_properties_owner->addColumn("historial_pro", "STRING_TYPE", "POST", "historial_pro");
$ins_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$ins_properties_owner->addColumn("nie2_pro", "STRING_TYPE", "POST", "nie2_pro");
$ins_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$ins_properties_owner->addColumn("pasaporte2_pro", "STRING_TYPE", "POST", "pasaporte2_pro");
$ins_properties_owner->addColumn("keyholder_pro", "CHECKBOX_1_0_TYPE", "POST", "keyholder_pro", "0");
$ins_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$ins_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$ins_properties_owner->addColumn("residencia_fiscal_pro", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_pro", "0");
$ins_properties_owner->addColumn("reporte_prop", "CHECKBOX_1_0_TYPE", "POST", "reporte_prop", "1");
$ins_properties_owner->addColumn("nacionalidad_pro", "STRING_TYPE", "POST", "nacionalidad_pro");
$ins_properties_owner->addColumn("notas_pro", "STRING_TYPE", "POST", "notas_pro");
$ins_properties_owner->addColumn("energia_pro", "CHECKBOX_1_0_TYPE", "POST", "energia_pro", "0");
if ($actMailchimp == 1) {
    $ins_properties_owner->addColumn("newsletter_pro", "CHECKBOX_1_0_TYPE", "POST", "newsletter_pro", "0");
}
$ins_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
$ins_properties_owner->addColumn("type_pro", "STRING_TYPE", "POST", "type_pro", "1");
$ins_properties_owner->addColumn("workers_pro", "STRING_TYPE", "POST", "workers_pro");
$ins_properties_owner->addColumn("idioma_pro", "STRING_TYPE", "POST", "idioma_pro");
$ins_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_owner = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_owner);
// Register triggers
$upd_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_properties_owner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "/intramedianet/properties/owners.php");
$upd_properties_owner->registerConditionalTrigger("{POST.KT_Update2} != \"\"", "END", "Trigger_Redirect", 90);
$upd_properties_owner->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
$upd_properties_owner->registerTrigger("BEFORE", "editLog", 10);
if ($actMailchimp == 1) {
    $upd_properties_owner->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
// Add columns
$upd_properties_owner->setTable("properties_owner");
$upd_properties_owner->addColumn("nombre_pro", "STRING_TYPE", "POST", "nombre_pro");
$upd_properties_owner->addColumn("apellidos_pro", "STRING_TYPE", "POST", "apellidos_pro");
$upd_properties_owner->addColumn("direccion_pro", "STRING_TYPE", "POST", "direccion_pro");
$upd_properties_owner->addColumn("telefono_fijo_pro", "STRING_TYPE", "POST", "telefono_fijo_pro");
$upd_properties_owner->addColumn("telefono_movil_pro", "STRING_TYPE", "POST", "telefono_movil_pro");
$upd_properties_owner->addColumn("email_pro", "STRING_TYPE", "POST", "email_pro");
$upd_properties_owner->addColumn("skype_pro", "STRING_TYPE", "POST", "skype_pro");
$upd_properties_owner->addColumn("como_nos_conocio_pro", "STRING_TYPE", "POST", "como_nos_conocio_pro");
$upd_properties_owner->addColumn("captado_por_pro", "STRING_TYPE", "POST", "captado_por_pro");
$upd_properties_owner->addColumn("fecha_alta_pro", "DATE_TYPE", "POST", "fecha_alta_pro");
$upd_properties_owner->addColumn("next_call_pro", "DATE_TYPE", "POST", "next_call_pro");
$upd_properties_owner->addColumn("historial_pro", "STRING_TYPE", "POST", "historial_pro");
$upd_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$upd_properties_owner->addColumn("nie2_pro", "STRING_TYPE", "POST", "nie2_pro");
$upd_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$upd_properties_owner->addColumn("pasaporte2_pro", "STRING_TYPE", "POST", "pasaporte2_pro");
$upd_properties_owner->addColumn("keyholder_pro", "CHECKBOX_1_0_TYPE", "POST", "keyholder_pro");
$upd_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$upd_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$upd_properties_owner->addColumn("residencia_fiscal_pro", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_pro");
$upd_properties_owner->addColumn("reporte_prop", "CHECKBOX_1_0_TYPE", "POST", "reporte_prop");
$upd_properties_owner->addColumn("nacionalidad_pro", "STRING_TYPE", "POST", "nacionalidad_pro");
$upd_properties_owner->addColumn("notas_pro", "STRING_TYPE", "POST", "notas_pro");
$upd_properties_owner->addColumn("energia_pro", "CHECKBOX_1_0_TYPE", "POST", "energia_pro");
if ($actMailchimp == 1) {
    $upd_properties_owner->addColumn("newsletter_pro", "CHECKBOX_1_0_TYPE", "POST", "newsletter_pro");
}
$upd_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
$upd_properties_owner->addColumn("type_pro", "STRING_TYPE", "POST", "type_pro");
$upd_properties_owner->addColumn("workers_pro", "STRING_TYPE", "POST", "workers_pro");
$upd_properties_owner->addColumn("idioma_pro", "STRING_TYPE", "POST", "idioma_pro");
$upd_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE", "GET", "id_pro");

// Make an instance of the transaction object
$del_properties_owner = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_owner);
// Register triggers
$del_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../intramedianet/properties/owners.php?KT_back=1");
$del_properties_owner->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
$del_properties_owner->registerTrigger("BEFORE", "deleteLog", 99);
if ($actMailchimp == 1) {
    $del_properties_owner->registerTrigger("AFTER", "Trigger_DeletFromNewsletter", 10);
}
// Add columns
$del_properties_owner->setTable("properties_owner");
$del_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE", "GET", "id_pro");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_owner = $tNGs->getRecordset("properties_owner");
$row_rsproperties_owner = mysqli_fetch_assoc($rsproperties_owner);
$totalRows_rsproperties_owner = mysqli_num_rows($rsproperties_owner);

if(isset($_GET['id_pro'])){
$query_rsUpdate = "
SELECT
updated_pro
FROM properties_owner
WHERE id_pro = '".$_GET['id_pro']."'
";
$rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());
$row_rsUpdate = mysqli_fetch_assoc($rsUpdate);
$totalRows_rsUpdate = mysqli_num_rows($rsUpdate);
}else{
    $row_rsUpdate = array();
    $totalRows_rsUpdate = 0;
}

$query_rsEmails = "
    SELECT
    properties_log_mails_props.id_log,
    GROUP_CONCAT(properties_properties.id_prop) as id_prop,
    GROUP_CONCAT(properties_properties.referencia_prop) as referencia_prop,
    properties_log_mails_props.type_log,
    (SELECT nombre_usr FROM users WHERE id_usr = usr_log) AS usr_log,
    properties_log_mails_props.text_log,
    properties_log_mails_props.date_log
    FROM properties_log_mails_props
    LEFT OUTER JOIN properties_properties ON properties_log_mails_props.prop_id_log = properties_properties.id_prop
    WHERE email_log = '".$row_rsproperties_owner['email_pro']."'
    GROUP BY date_log
    ORDER BY date_log DESC
";
$rsEmails = mysqli_query($inmoconn,$query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);

if(isset($_GET['id_pro'])){
    $query_rsHistorial = "
    SELECT
    users.nombre_usr,
    properties_owner_log.referencia_log,
    properties_owner_log.action_log,
    properties_owner_log.date_log,
    properties_owner_log.id_log
    FROM properties_owner_log LEFT OUTER JOIN users ON properties_owner_log.user_log = users.id_usr
    WHERE prop_id_log = '".$_GET['id_pro']."'
    ORDER BY date_log DESC
    ";
    $rsHistorial = mysqli_query($inmoconn,$query_rsHistorial) or die(mysqli_error());
    $row_rsHistorial = mysqli_fetch_assoc($rsHistorial);
    $totalRows_rsHistorial = mysqli_num_rows($rsHistorial);
}else{
    $row_rsHistorial = array();
    $totalRows_rsHistorial = 0;
}

if(isset($_GET['id_pro'])){
$query_rsEvents = "
SELECT citas.id_ct,
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
  citas_categories.category_".$lang_adm."_ct as cat,
  users.nombre_usr,
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
WHERE vendedores_ct = '".$_GET['id_pro']."'
 ORDER BY inicio_ct DESC
";
$rsEvents = mysqli_query($inmoconn,$query_rsEvents) or die(mysqli_error());
$row_rsEvents = mysqli_fetch_assoc($rsEvents);
$totalRows_rsEvents = mysqli_num_rows($rsEvents);
}else{
    $row_rsEvents = array();
    $totalRows_rsEvents = 0;
}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_owner_captado" class="id_field" value="<?php if(isset($row_rsproperties_owner['kt_pk_properties_owner'])) echo KT_escapeAttribute($row_rsproperties_owner['kt_pk_properties_owner']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <!-- <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-house-person-leave"></i> <?php echo __('Propietarios'); ?></h4> -->

                        <div class="flex-md-grow-1 d-md-block" id="tabs-header-fix">

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills card-header-pills" role="tablist" id="proptabs">
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary active" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabowner" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Propietario'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabnotes" role="tab" aria-selected="true">
                                        <?php __('Notas'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabprops" role="tab" aria-selected="true">
                                        <?php __('Propiedades'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabsend" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Enviar'); ?> <?php __('Email'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabinfo" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Informes'); ?>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        <div class="flex-grow-1 prop-nav-sep d-none d-md-flex text-white"><i class="fa-regular fa-pipe mx-5"></i></div>

                        <div class="flex-md-shrink-0 d-md-block">
                            <?php if (@$_GET['id_pro'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="mt-2 mt-md-0 btn btn-success btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?></span></button>
                                <button type="submit" name="KT_Insert2" id="KT_Insert2" class="mt-2 mt-md-0 btn btn-primary btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?> <?php echo $lang['y Seguir Editando'] ?></span></button>
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php __("Guardar"); ?></span></button>
                                <button type="submit" name="KT_Update2" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-primary btn-sm"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                                <button type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 mt-2 mt-md-0 btn btn-danger btn-sm"><i class="fa-regular fa-trash-can fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Delete_FB"); ?></span></button>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="mt-2 mt-md-0 btn btn-soft-primary btn-sm"><i class="fa-regular fa-chevron-left fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>
                        </div>
                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <?php if (isset($_GET['u']) && $_GET['u'] == 'ok') { ?>
                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-check label-icon"></i> <?php echo $lang['El propietario se ha guardado correctamente'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="tab-cont">

                    <div class="tab-content">

                        <div class="tab-pane active" id="tabowner">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Propietario'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "type_pro") != '') { ?>has-error<?php } ?>">
                                                <label for="type_pro" class="form-label"><?php __('Tipo'); ?>:</label>
                                                <select name="type_pro" id="type_pro" class="form-control required" required>
                                                    <option value="1"<?php if (isset($row_rsproperties_owner['type_pro']) && !(strcmp(1, $row_rsproperties_owner['type_pro']))) {
                                                        echo "SELECTED";
                                                    } ?>><?php __('Particular'); ?></option>
                                                    <option value="2"<?php if (isset($row_rsproperties_owner['type_pro']) && !(strcmp(2, $row_rsproperties_owner['type_pro']))) {
                                                        echo "SELECTED";
                                                    } ?>><?php __('Constructor'); ?></option>
                                                    <option value="3"<?php if (isset($row_rsproperties_owner['type_pro']) && !(strcmp(3, $row_rsproperties_owner['type_pro']))) {
                                                        echo "SELECTED";
                                                    } ?>><?php __('Banco'); ?></option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                <?php echo $tNGs->displayFieldError("properties_owner", "type_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nombre_pro") != '') { ?>error<?php } ?>">
                                                <label for="nombre_pro" class="form-label" id="nameprom"><?php __('Nombre'); ?>:</label>
                                                <input type="text" name="nombre_pro" id="nombre_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['nombre_pro']); ?>" size="32" maxlength="255" class="form-control required" required>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                <?php echo $tNGs->displayFieldError("properties_owner", "nombre_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-2 mb-md-4 <?php if($tNGs->displayFieldError("properties_owner", "apellidos_pro") != '') { ?>error<?php } ?>" id="surnameprom">
                                                <label for="apellidos_pro" class="form-label"><?php __('Apellidos'); ?>:</label>
                                                <input type="text" name="apellidos_pro" id="apellidos_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['apellidos_pro']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_owner", "apellidos_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <?php if ($actMailchimp == 1): ?>
                                            <div class="form-check form-switch form-switch-lg mt-4 mb-4 mb-md-0" dir="ltr">
                                                <input type="checkbox" name="newsletter_pro" id="newsletter_pro" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner['newsletter_pro']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="newsletter_pro"><?php __('Añadir a la newsletter'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_owner", "newsletter_pro"); ?>
                                            </div>
                                            <?php endif ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="workers">
                                                <div class="input_fields_wrap row">
                                                    <h5 class="text-uppercase border-bottom"><?php __('Persona de Contacto'); ?></h5>
                                                    <?php 
                                                        if(isset($row_rsproperties_owner['workers_pro']))
                                                            $workers = explode('@@@@@@', $row_rsproperties_owner['workers_pro']);
                                                        else
                                                            $workers = array();
                                                    ?>
                                                    <?php if(isset($workers[0]) && $workers[0] != '') { ?>
                                                        <?php foreach ($workers as $worker) { ?>
                                                            <div class="col-md-3">
                                                                <div class="mb-4">
                                                                    <textarea name="worker[]" rows="4" class="form-control"><?php echo $worker; ?></textarea>
                                                                    <a href="#" class="remove_field btn btn-danger btn-sm ms-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-trash-can"></i></a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <button class="add_field_button btn btn-primary btn-sm"><i class="fa-regular fa-plus"></i> <?php __('Añadir Persona de Contacto'); ?></button><br><br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "email_pro") != '') { ?>error<?php } ?>">
                                              <label for="email_pro" class="form-label"><?php __('Email'); ?>:</label>
                                                  <input type="text" name="email_pro" id="email_pro" value="<?php if($row_rsproperties_owner['email_pro']) echo trim(KT_escapeAttribute($row_rsproperties_owner['email_pro'])); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_owner", "email_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "fecha_alta_pro") != '') { ?>error<?php } ?>">
                                              <label for="fecha_alta_pro" class="form-label"><?php __('Añadido'); ?>:</label>
                                                  <input type="text" name="fecha_alta_pro" id="fecha_alta_pro" value="<?php if($row_rsproperties_owner['fecha_alta_pro']) echo KT_formatDate($row_rsproperties_owner['fecha_alta_pro']); ?>" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y">
                                                  <?php echo $tNGs->displayFieldError("properties_owner", "fecha_alta_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-2 mb-md-4">
                                                <label for="updated_pro" class="form-label"><?php __('Última actualización'); ?>:</label>
                                                <input type="text" name="updated_pro" id="updated_pro" value="<?php if(isset($row_rsUpdate['updated_pro'])) echo KT_formatDate($row_rsUpdate['updated_pro']); ?>" size="32" maxlength="255" class="form-control datepick" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-switch form-switch-lg mt-4 mb-4 mb-md-0" dir="ltr">
                                                <input type="checkbox" name="reporte_prop" id="reporte_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner['reporte_prop']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="reporte_prop"><?php __('Enviar Reporte'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_owner", "reporte_prop"); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "telefono_fijo_pro") != '') { ?>error<?php } ?>">
                                                <label for="telefono_fijo_pro" class="form-label"><?php __('Teléfono'); ?>:</label>
                                                <input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['telefono_fijo_pro']); ?>" size="32" maxlength="255" class="form-control number">
                                                <?php echo $tNGs->displayFieldError("properties_owner", "telefono_fijo_pro"); ?>
                                                 <a href="https://api.whatsapp.com/send/?phone=<?php echo KT_escapeAttribute($row_rsproperties_owner['telefono_fijo_pro']); ?>" class="btn btn-success btn-sm ms-2" style="border-radius: 0 0 5px 5px;" target="blank"><i class="fa-brands fa-whatsapp"></i> Whatsapp</a> <small class="text-muted"><?php __('Sin + con prefijo del país y sin espacios'); ?></small>
                                             </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "telefono_movil_pro") != '') { ?>error<?php } ?>">
                                                <label for="telefono_movil_pro" class="form-label"><?php __('Móvil'); ?>:</label>
                                                <input type="text" name="telefono_movil_pro" id="telefono_movil_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['telefono_movil_pro']); ?>" size="32" maxlength="255" class="form-control number">
                                                <?php echo $tNGs->displayFieldError("properties_owner", "telefono_movil_pro"); ?>
                                                 <a href="https://api.whatsapp.com/send/?phone=<?php echo KT_escapeAttribute($row_rsproperties_owner['telefono_movil_pro']); ?>" class="btn btn-success btn-sm ms-2" style="border-radius: 0 0 5px 5px;" target="blank"><i class="fa-brands fa-whatsapp"></i> Whatsapp</a> <small class="text-muted"><?php __('Sin + con prefijo del país y sin espacios'); ?></small>
                                             </div>
                                         </div>
                                        <div class="col-md-6">
                                            <div class="<?php if($tNGs->displayFieldError("properties_owner", "next_call_pro") != '') { ?>error<?php } ?>">
                                                <label for="next_call_pro" class="form-label"><?php __('Próxima llamada'); ?>:</label>
                                                    <input type="text" name="next_call_pro" id="next_call_pro" value="<?php echo KT_formatDate($row_rsproperties_owner['next_call_pro']); ?>" size="32" maxlength="255" class="form-control datepick2">
                                                    <?php echo $tNGs->displayFieldError("properties_owner", "next_call_pro"); ?>
                                            </div>

                                            <button class="btn btn-danger btn-sm btn-add-next-call ms-2" style="border-radius: 0 0 5px 5px;" data-futur=""><?php __('No llamar'); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+7 days", time())) ?>"><?php echo str_replace('%s', '7', __('Añadir %s días', true)); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+15 days", time())) ?>"><?php echo str_replace('%s', '15', __('Añadir %s días', true)); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2 d-none d-md-inline-block" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+30 days", time())) ?>"><?php echo str_replace('%s', '30', __('Añadir %s días', true)); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2 d-none d-md-inline-block" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+60 days", time())) ?>"><?php echo str_replace('%s', '60', __('Añadir %s días', true)); ?></button>
                                        </div>
                                    </div>

                                    <div class="row mt-4 mt-md-0">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nacionalidad_pro") != '') { ?>has-error<?php } ?>">
                                                <label for="nacionalidad_pro" class="form-label"><?php __('Nacionalidad'); ?>:</label>
                                                <select name="nacionalidad_pro" id="nacionalidad_pro" class="form-select">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>


                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsNationalities['id_ncld'] ?>" <?php if (isset($row_rsproperties_owner['nacionalidad_pro']) && !(strcmp($row_rsNationalities['id_ncld'], $row_rsproperties_owner['nacionalidad_pro']))) {
                                                        echo "SELECTED";
                                                    } ?>><?php echo $row_rsNationalities['nacionalidad_'.$lang_adm.'_ncld'] ?></option>
                                                    <?php } while ($row_rsNationalities = mysqli_fetch_assoc($rsNationalities));
                                                    $rows = mysqli_num_rows($rsNationalities);
                                                    if($rows > 0) {
                                                    mysqli_data_seek($rsNationalities, 0);
                                                    $row_rsNationalities = mysqli_fetch_assoc($rsNationalities);
                                                    } ?>
                                                </select>


                                                  <?php echo $tNGs->displayFieldError("properties_owner", "nacionalidad_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "idioma_pro") != '') { ?>has-error<?php } ?>">
                                                <label for="idioma_pro" class="form-label"><?php __('Idioma'); ?>:</label>
                                                <select name="idioma_pro" id="idioma_pro" class="form-select required" required>
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php
                                                    if ($lang_adm == 'es') {
                                                        $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                                    } else {
                                                        $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                                    }
                                                    foreach ($languages as $value) {
                                                        $selected = (!(strcmp($value, $row_rsproperties_owner['idioma_pro'])))?" SELECTED":"";
                                                        echo '<option value="'.$value.'"'.$selected.'>'.$idiomas[$value].'</option>';
                                                    }
        ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                <?php echo $tNGs->displayFieldError("properties_owner", "idioma_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mt-3 mb-4 mb-md-0">
                                                <div class="col-md-4">
                                                    <a href="javascript:void(0);" class="add-cita btn btn-primary w-100"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir cita'); ?></a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="/intramedianet/calendar/calendario.php" class="btn btn-primary w-100 mt-3 mt-md-0" target="_blank"><i class="fa-regular fa-calendar-days me-1"></i> <?php __('Calendario'); ?></a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="/intramedianet/tasks/tasks-form.php?idu=<?php echo $row_rsproperties_owner['id_pro'] ?>&t=3" target="_blank" class="add-citax btn btn-primary w-100 mt-3 mt-md-0"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir tarea'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nie_pro") != '') { ?>error<?php } ?>">
                                                <label for="nie_pro" class="form-label"><?php __('NIE'); ?>:</label>
                                                <input type="text" name="nie_pro" id="nie_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['nie_pro']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_owner", "nie_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nie2_pro") != '') { ?>error<?php } ?>">
                                               <label for="nie2_pro" class="form-label"><?php __('NIE'); ?> 2:</label>
                                               <input type="text" name="nie2_pro" id="nie2_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['nie2_pro']); ?>" size="32" maxlength="255" class="form-control">
                                               <?php echo $tNGs->displayFieldError("properties_owner", "nie2_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "pasaporte_pro") != '') { ?>error<?php } ?>">
                                               <label for="pasaporte_pro" class="form-label"><?php __('Pasaporte'); ?>:</label>
                                               <input type="text" name="pasaporte_pro" id="pasaporte_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['pasaporte_pro']); ?>" size="32" maxlength="255" class="form-control">
                                               <?php echo $tNGs->displayFieldError("properties_owner", "pasaporte_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "pasaporte2_pro") != '') { ?>error<?php } ?>">
                                              <label for="pasaporte2_pro" class="form-label"><?php __('Pasaporte'); ?> 2:</label>
                                                  <input type="text" name="pasaporte2_pro" id="pasaporte2_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['pasaporte2_pro']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_owner", "pasaporte2_pro"); ?>
                                            </div></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                              <div class="col">

                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "status_pro") != '') { ?>has-error<?php } ?>">
                                                      <label for="status_pro" class="form-label"><?php __('Estatus'); ?>:</label>
                                                      <select name="status_pro" id="status_pro" class="select2">
                                                          <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                          <?php do { ?>
                                                          <option value="<?php echo $row_rsStatus ['id_sts']?>"<?php if (isset($row_rsproperties_owner['status_pro']) && !(strcmp($row_rsStatus ['id_sts'], $row_rsproperties_owner['status_pro']))) {
                                                              echo "SELECTED";
                                                          } ?>><?php echo $row_rsStatus ['category_'.$lang_adm.'_sts']?></option>
                                                          <?php } while ($row_rsStatus  = mysqli_fetch_assoc($rsStatus));
                                                                $rows = mysqli_num_rows($rsStatus);
                                                                if($rows > 0) {
                                                                mysqli_data_seek($rsStatus, 0);
                                                                $row_rsStatus  = mysqli_fetch_assoc($rsStatus);
                                                                } ?>
                                                      </select>
                                                      <?php echo $tNGs->displayFieldError("properties_owner", "status_pro"); ?>
                                                  </div>

                                              </div>
                                              <div class="col-md-2 d-none d-md-block">
                                                  <br>
                                                  <a href="#" class="btn btn-success w-100 add-status"><i class="fa-regular fa-plus"></i><!--  <?php __('Añadir Estatus'); ?> --></a>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                              <div class="col">

                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "captado_por_pro") != '') { ?>has-error<?php } ?>">
                                                  <label for="captado_por_pro" class="form-label"><?php __('Captado por'); ?>:</label>
                                                      <select name="captado_por_pro" id="captado_por_pro" class="select2">
                                                          <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                          <?php do { ?>
                                                          <option value="<?php echo $row_rsCaptado ['id_cap']?>"<?php if ($row_rsproperties_owner['captado_por_pro'] && !(strcmp($row_rsCaptado ['id_cap'], $row_rsproperties_owner['captado_por_pro']))) {
                                                              echo "SELECTED";
                                                          } ?>><?php echo $row_rsCaptado ['category_'.$lang_adm.'_cap']?></option>
                                                          <?php } while ($row_rsCaptado  = mysqli_fetch_assoc($rsCaptado));
                                                                $rows = mysqli_num_rows($rsCaptado);
                                                                if($rows > 0) {
                                                                mysqli_data_seek($rsCaptado, 0);
                                                                $row_rsCaptado  = mysqli_fetch_assoc($rsCaptado);
                                                                } ?>
                                                      </select>
                                                      <?php echo $tNGs->displayFieldError("properties_owner", "captado_por_pro"); ?>
                                                  </div>

                                              </div>
                                              <div class="col-md-2 d-none d-md-block">
                                                  <br>
                                                  <a href="#" class="btn btn-success w-100 add-captado"><i class="fa-regular fa-plus"></i><!--  <?php __('Añadir Captado por'); ?> --></a>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                              <div class="col">
                                                  <div class="mb-2 <?php if($tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro") != '') { ?>has-error<?php } ?>">
                                                      <label for="como_nos_conocio_pro" class="form-label"><?php __('Cómo nos conoció'); ?>:</label>
                                                      <div class="controls">
                                                          <select name="como_nos_conocio_pro" id="como_nos_conocio_pro" class="select2">
                                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                              <?php do { ?>
                                                              <option value="<?php echo $row_rsSources['id_sts']?>"<?php if (isset($row_rsproperties_owner['como_nos_conocio_pro']) && !(strcmp($row_rsSources['id_sts'], $row_rsproperties_owner['como_nos_conocio_pro']))) {
                                                                  echo "SELECTED";
                                                              } ?>><?php echo $row_rsSources['category_'.$lang_adm.'_sts']?></option>
                                                              <?php } while ($row_rsSources = mysqli_fetch_assoc($rsSources));
                                                                $rows = mysqli_num_rows($rsSources);
                                                                if($rows > 0) {
                                                                mysqli_data_seek($rsSources, 0);
                                                                $row_rsSources = mysqli_fetch_assoc($rsSources);
                                                                } ?>
                                                          </select>
                                                          <?php echo $tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro"); ?>
                                                      </div>
                                                  </div>

                                              </div>
                                              <div class="col-md-2 d-none d-md-block">
                                                  <br>
                                                  <a href="#" class="btn btn-success w-100 add-source"><i class="fa-regular fa-plus"></i><!--  <?php __('Añadir Origen'); ?> --></a>
                                              </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4 mt-md-0">
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "skype_pro") != '') { ?>error<?php } ?>">
                                              <label for="skype_pro" class="form-label"><?php __('Partner Portal / Dropbox'); ?>:</label>
                                                  <input type="text" name="skype_pro" id="skype_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['skype_pro']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_owner", "skype_pro"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "direccion_pro") != '') { ?>error<?php } ?>">
                                              <label for="direccion_pro" class="form-label"><?php __('Dirección'); ?>:</label>
                                                  <input type="text" name="direccion_pro" id="direccion_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['direccion_pro']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_owner", "direccion_pro"); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php /* ?>

                                        <div class="card">
                                            <div class="card-body bg-light">
                                                <div class="checkbox">
                                                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                                                        <input type="checkbox" name="keyholder_pro" id="keyholder_pro" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner['keyholder_pro']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="keyholder_pro"><?php __('Solicitar llave'); ?></label>
                                                        <?php echo $tNGs->displayFieldError("properties_owner", "keyholder_pro"); ?>
                                                    </div>
                                                </div>
                                                <div id="keytxt" <?php if($row_rsproperties_owner['keyholder_pro'] != '1') { ?>style="display: none"<?php } ?>>
                                                    <div class="mt-4 <?php if($tNGs->displayFieldError("properties_owner", "keyholder_name_pro") != '') { ?>error<?php } ?>">
                                                        <label for="keyholder_name_pro" class="form-label"><?php __('Nombre'); ?>:</label>
                                                        <input type="text" name="keyholder_name_pro" id="keyholder_name_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['keyholder_name_pro']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_owner", "keyholder_name_pro"); ?>
                                                    </div>
                                                      <div class="mt-4 <?php if($tNGs->displayFieldError("properties_owner", "keyholder_tel_pro") != '') { ?>error<?php } ?>">
                                                          <label for="keyholder_tel_pro" class="form-label"><?php __('Teléfono'); ?>:</label>
                                                          <input type="text" name="keyholder_tel_pro" id="keyholder_tel_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['keyholder_tel_pro']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_owner", "keyholder_tel_pro"); ?>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($_GET['id_pro'] != ''): ?>
                                            <hr>
                                            <a href="/intramedianet/gdpr/owners.php?id=<?php echo $_GET['id_pro']; ?>" target="_blank" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="bottom"  title="<?php __('Recuerde guardar el propietario para ver los ultimos datos'); ?>">
                                                <i class="fa-regular fa-signature"></i> GDPR
                                            </a>
                                        <?php endif ?>

                                        <div class="checkbox">
                                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                                <input type="checkbox" name="residencia_fiscal_pro" id="residencia_fiscal_pro" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner['residencia_fiscal_pro']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="residencia_fiscal_pro"><?php __('Residencia fiscal'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_owner", "residencia_fiscal_pro"); ?>
                                            </div>
                                        </div>

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro") != '') { ?>error<?php } ?>">
                                          <label for="como_nos_conocio_pro"><?php __('Cómo nos conoció'); ?>:</label>
                                              <input type="text" name="como_nos_conocio_pro" id="como_nos_conocio_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['como_nos_conocio_pro']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro"); ?>
                                        </div>

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_owner", "captado_por_pro") != '') { ?>error<?php } ?>">
                                          <label for="captado_por_pro"><?php __('Captado por'); ?>:</label>
                                              <?php if($_SESSION['kt_login_level'] != 8) { ?>
                                              <input type="text" name="captado_por_pro" id="captado_por_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['captado_por_pro']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php } else { ?>
                                              <input type="hidden" name="captado_por_pro" id="captado_por_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['captado_por_pro']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo KT_escapeAttribute($row_rsproperties_owner['captado_por_pro']); ?>
                                              <?php } ?>
                                              <?php echo $tNGs->displayFieldError("properties_owner", "captado_por_pro"); ?>
                                        </div>

                                        <div class="checkbox mb-4">
                                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                                <input type="checkbox" name="energia_pro" id="energia_pro" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner['energia_pro']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="energia_pro"><?php __('Certificación energética'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_owner", "energia_pro"); ?>
                                            </div>
                                        </div>

                                    <?php */ ?>

                                    <div class="row">
                                        <div class="col-md-12">

                                            <legend class="border-bottom"><?php __('Archivos'); ?></legend>

                                            <small><i class="fa-regular fa-file fa-fw"></i> <?php __('Extensiones permitidas'); ?>: rar, txt, zip, doc, pdf, csv, xls, rtf, sxw, odt, docx, xlsx, ppt <?php __('y'); ?> mov.</small>
                                            <br>
                                            <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de los archivos, arrastre y suelte el archivo en la ubicación deseada'); ?>.</small>

                                            <hr>

                                            <div id="file-order-loading"></div>
                                            <ul class="thumbnails nested-sortable-file-" id="file-list">
                                                <?php if($totalRows_rsFiles > 0) { ?>
                                                <?php do { ?>
                                                    <li class="pull-left" id="order_<?php echo $row_rsFiles['id_fil'] ?>" data-id="<?php echo $row_rsFiles['id_fil'] ?>">
                                                        <div class="img-thumbnail pull-left">
                                                            <a href="/media/files/owners/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br><small><?php echo $row_rsFiles['file_fil']; ?></small></a>
                                                            <p class="text-center">
                                                            <a href="#" class="btn btn-success btn-sm edit-name" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-pencil"></i></a>
                                                            <a href="/intramedianet/properties/ofiles_del.php" data-id="<?php echo $row_rsFiles['id_fil'] ?>" class="btn btn-danger btn-sm del-fil"><i class="fa-regular fa-trash-can"></i></a>
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <?php } while ($row_rsFiles = mysqli_fetch_assoc($rsFiles)); ?>
                                                <?php } ?>
                                            </ul>

                                            <?php if ($actColaboradores == 1): ?>
                                                <!-- <hr>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <select name="colbrs" id="colbrs" class="form-select">
                                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                            <?php do { ?>
                                                            <option value="<?php echo $row_rsColaboradores['email_col']?>"><?php echo $row_rsColaboradores['nombre_comercial_col']?></option>
                                                            <?php } while ($row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores));
                                                    $rows = mysqli_num_rows($rsColaboradores);
                                                    if($rows > 0) {
                                                        mysqli_data_seek($rsColaboradores, 0);
                                                        $row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores);
                                                    } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="#" class="btn btn-success w-100 sendfiles mt-4 mt-md-0"><i class="fa-regular fa-paper-plane"></i> <?php __('Enviar'); ?></a>
                                                    </div>
                                                </div> -->
                                            <?php endif ?>
                                            <hr>
                                            <div class="multi_files"></div>

                                        </div>
                                    </div>

                                </div><!-- end card-body -->
                            </div>

                        </div>

                        <div class="tab-pane" id="tabnotes">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Notas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="form-group <?php if($tNGs->displayFieldError("properties_owner", "historial_pro") != '') { ?>has-error<?php } ?>">
                                        <textarea type="text" name="historial_pro" id="historial_pro" cols="50" rows="20" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_owner['historial_pro']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("properties_owner", "historial_pro"); ?>
                                        <a href="#" class="btn btn-success btn-sm addHist float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                                    </div>

                                </div><!-- end card-body -->
                            </div>

                            <?php /* ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Notas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="form-group <?php if($tNGs->displayFieldError("properties_owner", "notas_pro") != '') { ?>has-error<?php } ?>">
                                        <label for="notas_pro"><?php __('Notas'); ?>:</label>
                                        <textarea type="text" name="notas_pro" id="notas_pro" cols="50" rows="20" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_owner['notas_pro']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("properties_owner", "notas_pro"); ?>
                                        <a href="#" class="btn btn-success addNot btn-sm float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                                    </div>

                                </div><!-- end card-body -->
                            </div>
                            <?php */ ?>
                        </div>

                        <div class="tab-pane" id="tabprops">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Propiedades'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <table class="table table-striped table-bordered records-tables-simple align-middle" id="records-tables">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Imágen'); ?></th>
                                          <th><?php __('Referencia'); ?></th>
                                          <th><?php __('Operación'); ?></th>
                                          <th><?php __('Tipo'); ?></th>
                                          <th><?php __('Ciudad'); ?></th>
                                          <th><?php __('Zona'); ?></th>
                                          <th><?php __('Precio'); ?></th>
                                          <th><?php __('Activado'); ?></th>
                                          <th><?php __('Propietario'); ?></th>
                                          <th><?php __('Teléfono'); ?></th>
                                          <th id="actions" style="min-width: 150px !important;">
                                              <div class="row">
                                                  <div class="col-6" id="col-1">

                                                  </div>
                                                  <div class="col-6" id="col-2">

                                                  </div>
                                              </div>
                                          </th>
                                        </tr>
                                        <tr>
                                            <td>
                                            <input type="text" name="image_img" id="image_img" style="display: none">
                                            <input type="text" name="image_img" id="image_img" style="display: none">
                                            </td>
                                            <td><input type="text" name="referencia_prop" id="referencia_prop" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="status_en_sta" id="status_en_sta" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="types_en_typ" id="types_en_typ" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="town_en_twn" id="town_en_twn" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="zona_en_twn" id="zona_en_twn" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="precio" id="precio" class="form-control form-control-sm"></td>
                                            <td><input type="hidden" name="activado_prop" id="activado_prop" class="form-control form-control-sm">
                                                <select name="activado_prop_sel" id="activado_prop_sel" class="form-select form-select-sm">
                                                    <option value=""><?php __('Todos'); ?></option>
                                                    <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                    <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                               </select>
                                           </td>
                                            <td><input type="text" name="nombre_prox" id="nombre_prox" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="telefono_fijo_prox" id="telefono_fijo_prox" class="form-control form-control-sm"></td>
                                            <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td colspan="11" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                        </tr>
                                      </tbody>
                                    </table>

                                </div><!-- end card-body -->
                            </div>

                        </div>

                        <div class="tab-pane" id="tabsend">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Enviar'); ?> <?php __('Email'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group>">
                                                <label for="txt" class="form-label"><?php __('Texto'); ?>:</label>
                                                <select name="txt" id="txt" class="form-select">
                                                    <option value=""><?php __('Seleccione uno'); ?>...</option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsTemplates['id_tmpl']?>"><?php echo $row_rsTemplates['name_'.$lang_adm.'_tmpl']?></option>
                                                    <?php } while ($row_rsTemplates = mysqli_fetch_assoc($rsTemplates));
                                                      $rows = mysqli_num_rows($rsTemplates);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsTemplates, 0);
                                                        $row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
                                                      } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group>">
                                                <label for="ref" class="form-label"><?php __('Referencia'); ?>:</label>
                                                <input type="text" class="select2references3" id="ref" name="ref" value="" tabindex="-1">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group" class="form-label">
                                                <br>
                                                <a href="#" class="btn btn-info btn-block btn-txt"><?php __('Aplicar'); ?></a>
                                                <a href="/intramedianet/templates/news.php" target="_blank" class="btn btn-primary"><?php __('Plantillas correo'); ?></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="subjectSM" class="form-label"><?php __('Asunto'); ?>:</label>
                                        <input type="text" name="subjectSM" id="subjectSM" class="form-control required">
                                    </div>

                                    <div class="form-group">
                                        <label for="email_cli" class="form-label"><?php __('Mensaje'); ?>:</label>
                                        <textarea name="messagemail" id="messagemail" cols="30" rows="15" class="form-control required wysiwyg"></textarea>
                                    </div>

                                    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4" role="alert">
                                        <i class="fa-regular fa-circle-info label-icon"></i><?php __('insert_client_mail'); ?>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <input type="text" name="ccoEml" id="ccoEml" value="" size="32" maxlength="255" class="form-control" placeholder="CCO">

                                        </div>

                                        <div class="col-md-8">

                                            <a href="#" class="btn btn-primary btnsendemail"><i class="fa-regular fa-paper-plane me-1"></i> <?php echo $lang['Enviar Respuesta/Email'] ?></a>
                                            <a href="#" class="btn btn-success btnwhatsapp mt-4 mt-md-0" target="_blank"><i class="fa-brands fa-whatsapp me-1"></i> <?php echo $lang['Enviar'] ?>: WhatsApp</a>

                                        </div>

                                    </div>

                                </div><!-- end card-body -->
                            </div>

                        </div>

                        <div class="tab-pane" id="tabinfo">

                            <?php if ($totalRows_rsTasks > 0 && $actTasks == 1) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Tareas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered records-tables-simple align-middle" id="tasks-table">
                                            <thead class="table-light">
                                            <tr>
                                              <th><?php __('Propietario de la tarea'); ?></th>
                                              <th><?php __('Asunto'); ?></th>
                                              <th><?php __('Propiedad'); ?></th>
                                              <th><?php __('Fecha de vencimiento'); ?></th>
                                              <th><?php __('Prioridad'); ?></th>
                                              <th><?php __('Status'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php do { ?>
                                              <tr>
                                                <td><?php echo $row_rsTasks['admin_tsk']; ?></td>
                                                <td><?php echo $row_rsTasks['subject_tsk']; ?></td>
                                                <td><?php echo addRefs($row_rsTasks['property_tsk']); ?></td>
                                                <td data-sort="<?php echo $row_rsTasks['date_due_tsk'] ?>"><?php echo date("d-m-Y", strtotime($row_rsTasks['date_due_tsk'])); ?></td>
                                                <td><?php __($row_rsTasks['priority_tsk']); ?></td>
                                                <td><?php echo $row_rsTasks['status_tsk']; ?></td>
                                              </tr>
                                              <?php } while ($row_rsTasks = mysqli_fetch_assoc($rsTasks)); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                            <?php if ($totalRows_rsEvents > 0 && $actCalendar == 1) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Eventos'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered records-tables-simple3 align-middle" id="events-table">
                                            <thead class="table-light">
                                            <tr>
                                              <th><?php __('Título'); ?></th>
                                              <th><?php __('Categoría'); ?></th>
                                              <th><?php __('Fecha inicio'); ?></th>
                                              <th><?php __('Fecha final'); ?></th>
                                              <th><?php __('Propiedades'); ?></th>
                                              <th><?php __('Administrador'); ?></th>
                                              <th><?php __('Lugar'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php do { ?>
                                              <tr>
                                                <td><?php echo $row_rsEvents['titulo_ct']; ?></td>
                                                <td><span class="badge bg-primary" style="background: <?php echo $row_rsEvents['color_ct']; ?> !important;"><?php echo $row_rsEvents['cat']; ?></span></td>
                                                <td data-sort="<?php echo $row_rsEvents['inicio_ct'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEvents['inicio_ct'])); ?></td>
                                                <td data-sort="<?php echo $row_rsEvents['final_ct'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEvents['final_ct'])); ?></td>
                                                <td><?php echo addRefs($row_rsEvents['property_ct']); ?></td>
                                                <td><?php echo $row_rsEvents['nombre_usr']; ?></td>
                                                <td><?php echo $row_rsEvents['lugar_ct']; ?></td>
                                              </tr>
                                              <?php } while ($row_rsEvents = mysqli_fetch_assoc($rsEvents)); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                            <?php if ($totalRows_rsEmails > 0) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Seguimiento de envios'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered records-tables-simple align-middle" id="emails-table">
                                            <thead class="table-light">
                                            <tr>
                                              <th><?php __('Administrador'); ?></th>
                                              <th><?php __('Enviado'); ?></th>
                                              <th style="width: 140px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php do { ?>
                                              <tr>
                                              <td><?php echo $row_rsEmails['usr_log']; ?></td>
                                              <td data-sort="<?php echo $row_rsEmails['date_log'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEmails['date_log'])); ?></td>
                                              <td class="text-nowrap"><a href="" class="btn btn-primary btn-sm view-mail-cont" data-id="<?php echo $row_rsEmails['id_log']; ?>"><i class="fa-regular fa-eye me-1"></i> <?php __('View message'); ?></a></td>
                                              </tr>
                                              <?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails)); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                            <?php if ($totalRows_rsHistorial > 0) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Seguimiento de cambios'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-bordered align-middle align-middle" id="history-table" width="100%">
                                            <thead class="table-light">
                                                <tr>
                                                  <th><?php __('Usuario'); ?></th>
                                                  <th><?php __('Acción'); ?></th>
                                                  <th><?php __('Fecha'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php do { ?>
                                              <tr>
                                                  <td><?php echo $row_rsHistorial['nombre_usr']; ?></td>
                                                  <td><?php
                                                  switch ($row_rsHistorial['action_log']) {
                                                      case '1':
                                                          echo '<span class="badge bg-success">'.__('Añadido', true) . '</span>';
                                                          break;
                                                      case '2':
                                                          echo '<span class="badge bg-info">'.__('Editado', true) . '</span>';
                                                          break;
                                                      case '5':
                                                          echo '<span class="badge bg-danger">'.__('Borrado', true) . '</span>';
                                                          break;
                                                  }
                                                    ?></td>
                                                  <td data-sort="<?php echo $row_rsHistorial['date_log'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsHistorial['date_log'])); ?></td>
                                              </tr>
                                              <?php } while ($row_rsHistorial = mysqli_fetch_assoc($rsHistorial)); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var idOwner = '<?php echo $ownerId; ?>';
    var oTable;
    var selected =  new Array();
    var strFieldSubject = '<?php __('El campo asunto es requerido') ?>';
    var strFieldMessage = '<?php __('El campo mensaje es requerido') ?>';


    $('.btn-add-next-call').click(function(e) {
        e.preventDefault();
        $('#next_call_pro').val($(this).data('futur'));
    });

    $('#type_pro').change(function(event) {
      if ($(this).val() == 3) {
        $('#nameprom').html('<?php __('Banco'); ?>');
        $('#workers').show();
        $('#surnameprom').hide();
        $('#nie_pro-cont').hide();
        $('#nie2_pro-cont').hide();
        $('#pasaporte_pro-cont').hide();
        $('#pasaporte2_pro-cont').hide();
        $('#nacionalidad_pro-cont').hide();
        $('#holder-cont').hide();
      } else if ($(this).val() == 2) {
        $('#nameprom').html('<?php __('Constructor'); ?>');
        $('#workers').show();
        $('#surnameprom').hide();
        $('#nie_pro-cont').hide();
        $('#nie2_pro-cont').hide();
        $('#pasaporte_pro-cont').hide();
        $('#pasaporte2_pro-cont').hide();
        $('#nacionalidad_pro-cont').hide();
        $('#holder-cont').hide();
      } else {
        $('#nameprom').html('<?php __('Nombre'); ?>');
        $('#workers').hide();
        $('#surnameprom').show();
        $('#nie_pro-cont').show();
        $('#nie2_pro-cont').show();
        $('#pasaporte_pro-cont').show();
        $('#pasaporte2_pro-cont').show();
        $('#nacionalidad_pro-cont').show();
        $('#holder-cont').show();
      }
    }).change();

    $(document).ready(function() {
        var max_fields      = 15; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="col-md-3"><div class="mb-4"><textarea name="worker[]" rows="4" class="form-control"></textarea><a href="#" class="remove_field btn btn-danger btn-sm ms-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-trash-can"></i></a></div></div>'); //add input box
            }
        });

        $(document).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
    </script>

    <script src="_js/owners-form.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <script>
        var intr_sub = new Array();
        var intr_txt = new Array();

        <?php do { ?>
          <?php foreach ($languages as $langval): ?>
          intr_sub['<?php echo $langval ?><?php echo $row_rsTemplates['id_tmpl']?>'] = "<?php echo mysqli_real_escape_string($inmoconn, $row_rsTemplates['subject_'.$langval.'_tmpl']); ?>";
          intr_txt['<?php echo $langval ?><?php echo $row_rsTemplates['id_tmpl']?>'] = "<?php echo mysqli_real_escape_string($inmoconn, $row_rsTemplates['content_'.$langval.'_tmpl']); ?>";

          <?php endforeach ?>
        <?php } while ($row_rsTemplates = mysqli_fetch_assoc($rsTemplates));
        $rows = mysqli_num_rows($rsTemplates);
        if($rows > 0) {
            mysqli_data_seek($rsTemplates, 0);
          $row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
        } ?>



        $('.btn-txt').click(function(e) {
            e.preventDefault();
            // if ($('#txt').val() == '') {
            //     alert('<?php __('Seleccione un texto'); ?>');
            //     $('#txt').focus();
            //     return false;
            // }
            $('#subjectSM').val(intr_sub[$('#idioma_pro').val()+$('#txt').val()]);
            var txt = intr_txt[$('#idioma_pro').val()+$('#txt').val()];
            $('#messagemail').redactor('source.setCode', txt.replace('{{PROPERTY}}', '{{PROPERTY-' + $('#ref').val() + '}}'));
            return false;
        });

        $('.btn-txt2').click(function(e) {
            e.preventDefault();
            if ($('#txt2').val() == '') {
                alert('<?php __('Seleccione un texto'); ?>');
                $('#txt2').focus();
                return false;
            }
            var txt = intr_txt[$('#idioma_pro').val()+$('#txt2').val()].replace('{{PROPERTY}}', '');
            $('#comment').redactor('source.setCode', txt);
            return false;
        });
    </script>

    <script>
          $(document).on('click', '.sendfiles', function(e) {

          e.preventDefault();

          var ids = [];

          $('.sendfile').each(function( index ) {
            if ($( this ).is(":checked")) {
              ids.push($( this ).val());
            }
          });

          if (ids.toString() != '' && $('#colbrs').val() != '') {
            if (confirm('<?php __('Are you sure want to send the selected files?'); ?>')) {
            $.get('files_send2.php?ids=' + ids.toString() + '&email=' + $('#colbrs').val() + '&id_pro=<?php echo $ownerId; ?>', function(data) {
                if (data == 'ok') {
                    alert('<?php __('Los archivos se han enviado correctamente.'); ?>');
                }
            });
          }

          }
        });
    </script>

    <div id="myModal2" class="modal fade" tabindex="-1" aria-labelledby="myModal2Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModal2Label"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar nombres'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="loadingfrm"></div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal5" class="modal fade" tabindex="-1" aria-labelledby="myModal5Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModal5Label"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir Estatus'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                      <div class="mb-4">
                          <label for="category_en_sts" class="form-label"><?php __('Estatus'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_en_sts" id="category_en_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="category_es_sts" class="form-label"><?php __('Estatus'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_es_sts" id="category_es_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal6" class="modal fade" tabindex="-1" aria-labelledby="myModal6Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModal6Label"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir Captado por'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                      <div class="mb-4">
                          <label for="category_en_cap" class="form-label"><?php __('Captado por'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_en_cap" id="category_en_cap" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="category_es_cap" class="form-label"><?php __('Captado por'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_es_cap" id="category_es_cap" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModalSource" class="modal fade" tabindex="-1" aria-labelledby="myModalSourceLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalSourceLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir Origen'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                      <div class="mb-4">
                          <label for="category_en_sts" class="form-label"><?php __('Origen'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_en_sts" id="category_en_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="category_es_sts" class="form-label"><?php __('Origen'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_es_sts" id="category_es_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal" class="modal fade" data-bs-focus="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir cita'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form method="post" id="form10" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate>
                <div class="modal-body bg-light">

                      <div class="row">
                          <div class="col-md-7">
                              <div class="mb-2">
                                  <label for="titulo_ct"><?php __('Título'); ?>:</label>
                                  <input type="text" name="titulo_ct" id="titulo_ct" value="" size="32" maxlength="255" class="form-control required" required>
                                  <div class="invalid-feedback">
                                      <?php __('Este campo es obligatorio.'); ?>
                                  </div>
                                  <input type="hidden" name="id_ct" id="id_ct" value="">
                              </div>
                              <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="inicio_ct"><?php __('Fecha inicio'); ?>:</label>
                                        <input type="text" name="inicio_ct" id="inicio_ct" value="" size="32" maxlength="255" class="form-control datepicktime required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="final_ct"><?php __('Fecha final'); ?>:</label>
                                        <input type="text" name="final_ct" id="final_ct" value="" size="32" maxlength="255" class="form-control datepicktime required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="categoria_ct"><?php __('Categoría'); ?>:</label>
                                            <select name="categoria_ct" id="categoria_ct" class="form-select required" required>
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                do {
                                                    ?>
                                                <option value="<?php echo $row_rscategorias['id_ct']?>"><?php echo $row_rscategorias['category_'.$lang_adm.'_ct']?></option>
                                                <?php
                                                } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                                $rows = mysqli_num_rows($rscategorias);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rscategorias, 0);
                                                    $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                        </div>

                                  </div>
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="user_ct"><?php __('Usuario'); ?>:</label>
                                            <select name="user_ct" id="user_ct" class="required select2" required>
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                do {
                                                    ?>
                                                <option value="<?php echo $row_rsusuarios['id_usr']?>"<?php if (!(strcmp($row_rsusuarios['id_usr'], $_SESSION['kt_login_id']))) {
                                                    echo " SELECTED";
                                                } ?>><?php echo $row_rsusuarios['nombre_usr']?></option>
                                                <?php
                                                } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                                $rows = mysqli_num_rows($rsusuarios);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsusuarios, 0);
                                                    $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                        </div>

                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="users_ct"><?php __('Clientex'); ?>:</label>
                                            <select name="users_ct" id="users_ct" class="select2">
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                do {
                                                    ?>
                                                <option value="<?php echo $row_rsclientes['id_cli']?>"><?php echo $row_rsclientes['nombre_cli']?> <?php echo $row_rsclientes['apellidos_cli']?></option>
                                                <?php
                                                } while ($row_rsclientes = mysqli_fetch_assoc($rsclientes));
                                                $rows = mysqli_num_rows($rsclientes);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsclientes, 0);
                                                    $row_rsclientes = mysqli_fetch_assoc($rsclientes);
                                                }
                                                ?>
                                            </select>
                                        </div>

                                  </div>
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="vendedores_ct"><?php __('Propietario'); ?>:</label>
                                            <select name="vendedores_ct" id="vendedores_ct" class="select2">
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                do {
                                                ?>
                                                <option value="<?php echo $row_rsvendor['id_pro']?>" <?php if ($_GET['id_pro'] == $row_rsvendor['id_pro']): ?>selected<?php endif ?>><?php echo $row_rsvendor['nombre_pro']?> <?php echo $row_rsvendor['apellidos_pro']?></option>
                                                <?php
                                                } while ($row_rsvendor = mysqli_fetch_assoc($rsvendor));
                                                  $rows = mysqli_num_rows($rsvendor);
                                                  if($rows > 0) {
                                                      mysqli_data_seek($rsvendor, 0);
                                                    $row_rsvendor = mysqli_fetch_assoc($rsvendor);
                                                  }
                                                ?>
                                            </select>
                                        </div>

                                  </div>
                              </div>

                              <div class="mb-2">
                                  <label for="property_ct"><?php __('Propiedades'); ?>:</label>
                                  <select name="property_ct[]" id="property_ct" multiple class="select2">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php
                                      do {
                                        $vals = array();
                                        if(isset($row_rsproperties_client['property_ct']))
                                          $vals = explode(',', $row_rsproperties_client['property_ct']);
                                        ?>
                                      <option value="<?php echo $row_rspropiedad['id_prop']?>" <?php if (in_array($row_rspropiedad['id_prop'], $vals)) {
                                          echo "selected=\"selected\"";
                                      } ?>><?php echo $row_rspropiedad['referencia_prop']?></option>
                                      <?php
                                      } while ($row_rspropiedad = mysqli_fetch_assoc($rspropiedad));
                                      $rows = mysqli_num_rows($rspropiedad);
                                      if($rows > 0) {
                                          mysqli_data_seek($rspropiedad, 0);
                                          $row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
                                      }
                                      ?>
                                  </select>
                              </div>

                              <div class="mb-2">
                                  <label for="lugar_ct"><?php __('Lugar'); ?>:</label>
                                  <input type="text" name="lugar_ct" id="lugar_ct" value="" size="32" maxlength="255" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-5">
                              <div class="form-group">
                                  <label for="notas_ct"><?php __('Notas'); ?>:</label>
                                  <textarea name="notas_ct" id="notas_ct" cols="40" rows="19" class="form-control"></textarea>
                              </div>
                              <a href="#" class="btn btn-success btn-sm addHistCit float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" id="btn-close-save" name="KT_Insert1"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar y guardar'); ?>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm mt-4" id="btn-close"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar'); ?>
                    </a>
                </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
      $('.btnsendwhatsapp').click(function(e) {
          e.preventDefault();
          if ($('#telefono_fijo_pro').val() == '') {
              alert(Nophone);
              return false;
          }
          if (!confirm(cliMailConf)) {
            return false;
          }
          sendLang = 'en';
          if ($('#idioma_cli').val() != '') {
            sendLang = $('#idioma_cli').val();
          }
          var values = Array();
          var priceRegex = /([0-9]+)/;
          for (var i = 0; i < selected.length; i++) {
              // var match = selected[i].match(priceRegex);
              // values.push(match[1]);
              values.push(selected[i]);
          }
          values = values.join(',');

          var url =  "clients-whatsapp.php?ids="+values+'&phone='+$('#telefono_fijo_pro').val()+'&comment='+encodeURIComponent($('#comment').val().replace( /\r?\n/g, "<br>" ))+'&lang=' + sendLang;

          window.open(url, "whatsapp");
      });
      $('.btnwhatsapp').click(function(e) {
        e.preventDefault();
        if (!$('#telefono_fijo_pro').val()) {
            alert(Nophone);
            return false;
        }
        if ($('#messagemail').val() == '') {
            alert(strFieldMessage);
            return false;
        }
        sendLang = 'en';
        if ($('#idioma_cli').val() != '') {
          sendLang = $('#idioma_cli').val();
        }
        if (!confirm(cliMailConf)) {
          return false;
        }

        var values = Array();
        var priceRegex = /([0-9]+)/;
        for (var i = 0; i < selected.length; i++) {
            // var match = selected[i].match(priceRegex);
            // values.push(match[1]);
            values.push(selected[i]);
        }
        values = values.join(',');

        var url =  "get-links2.php?ids="+values+'&phone='+$('#telefono_fijo_pro').val()+'&comment='+encodeURIComponent($('#messagemail').val())+'&lang=' + sendLang;

        window.open(url, "whatsapp");
      });

      $('.select2references3').select2({
          multiple:true,
          ajax: {
          url: function (params) {
              return '/intramedianet/properties/properties-references-select.php?q=' + params;
          },
          dataType: 'json',
          delay: 250,
          results: function (data, params) {
              return {
                  results: data.results
              };
          },
          // cache: true,
          },
          placeholder: '',
          minimumInputLength: 3,
      });

      $(document).on("click", ".view-mail-cont", function(e) {
          //user click on remove text
          e.preventDefault();

          $.get('view-mensa-prop.php?id=' + $(this).data('id'), function(data) {
              $('#mail-text').html(data);
              $('#myModal3').modal('show');
          });
      });
    </script>

    <div id="myModal3" class="modal  fade" tabindex="-1" aria-labelledby="myModal3Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="mail-text"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
