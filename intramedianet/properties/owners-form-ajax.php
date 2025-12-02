<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

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
  $rsNextIncrement = mysqli_query($inmoconn, $query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);
  $ownerId = $row_rsNextIncrement['Auto_increment'];

} else {

  $ownerId = $_GET['id_pro'];

}

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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_pro", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

$query_rsFiles = "SELECT * FROM properties_owner_files WHERE owner_fil = '".$ownerId."' ";
$rsFiles = mysqli_query($inmoconn, $query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect($tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("owners-form.php?id_pro=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_owner_files");
  $tblDelObj->setFieldName("owner_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/owners/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

$id= 0;

//start Trigger_return_id trigger
//remove this line if you want to edit the code by hand
function Trigger_return_id($tNG) {

  global $id;

  $id = $tNG->getPrimaryKeyValue();
}
//end Trigger_return_id trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields($tNG) {
  $tNG->addColumn("user_pro", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("fecha_alta_pro", "STRING_TYPE", "EXPRESSION", date("Y-m-d H:i:s"));
  return $tNG->getError();
}
//end addFields trigger

if(isset($_POST["worker"]) && is_array($_POST["worker"])) {
    $_POST["workers_pro"] = implode("@@@@@@", $_POST["worker"]);
}

//start Trigger_AddToNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_AddToNewsletter($tNG) {
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaOwners;
    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    if ($_POST['newsletter_pro'] == 1) {
        if ($_POST['email_pro'] != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $acumba->addSubscriber($acumbamailIdListaOwners[$_POST['idioma_pro']], array('email'  => $_POST['email_pro']));
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
                    $acumba->deleteSubscriber($acumbamailIdListaOwners[$_POST['idioma_pro']], $value['id']);
                }
            }
        }
    }
}
//end Trigger_AddToNewsletter trigger

//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog($tNG) {

  global $_SESSION;

  logVendor($_SESSION['kt_login_id'], $tNG->getColumnValue('id_pro'), $tNG->getColumnValue('nombre_pro') . ' ' . $tNG->getColumnValue('apellidos_pro'), '1');

}
//end addLog trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique($tNG) {
  global $lang;
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("properties_owner");
  $tblFldObj->addFieldName("email_pro");
  $tblFldObj->setErrorMsg($lang['Registro duplicado'] . ": {email_pro}");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog($tNG) {

  global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT * FROM properties_owner WHERE id_pro = ".$_GET['id_pro'];
  $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);


  logVendor($_SESSION['kt_login_id'], $row_rsProp['id_pro'], $row_rsProp['nombre_pro'] . ' ' . $row_rsProp['apellidos_pro'], 2);

}
//end editLog trigger


// Make an insert transaction instance
$ins_properties_owner = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_owner);
// Register triggers
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_owner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
// $ins_properties_owner->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
$ins_properties_owner->registerTrigger("END", "Trigger_return_id", 99);
$ins_properties_owner->registerTrigger("BEFORE", "addFields", 10);
$ins_properties_owner->registerTrigger("AFTER", "addLog", 10);
$ins_properties_owner->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
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
$ins_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$ins_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$ins_properties_owner->addColumn("keyholder_pro", "STRING_TYPE", "POST", "keyholder_pro");
$ins_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$ins_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$ins_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
$ins_properties_owner->addColumn("type_pro", "STRING_TYPE", "POST", "type_pro", "1");
$ins_properties_owner->addColumn("workers_pro", "STRING_TYPE", "POST", "workers_pro");
$ins_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_owner = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_owner);
// Register triggers
$upd_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_properties_owner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
// $upd_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// $upd_properties_owner->registerConditionalTrigger("{POST.KT_Update2} != \"\"", "END", "Trigger_Redirect", 90);
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
$upd_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$upd_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$upd_properties_owner->addColumn("keyholder_pro", "CHECKBOX_1_0_TYPE", "POST", "keyholder_pro");
$upd_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$upd_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$upd_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
$upd_properties_owner->addColumn("type_pro", "STRING_TYPE", "POST", "type_pro");
$upd_properties_owner->addColumn("workers_pro", "STRING_TYPE", "POST", "workers_pro");
$upd_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE", "GET", "id_pro");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_owner = $tNGs->getRecordset("properties_owner");
$row_rsproperties_owner = mysqli_fetch_assoc($rsproperties_owner);
$totalRows_rsproperties_owner = mysqli_num_rows($rsproperties_owner);


if ($tNGs->getErrorMsg() != '') {

  
  $query_rsIdProp = "SELECT id_pro FROM properties_owner WHERE email_pro = '".$_POST['email_pro']."' ";
  $rsIdProp = mysqli_query($inmoconn, $query_rsIdProp) or die(mysqli_error());
  $row_rsIdProp = mysqli_fetch_assoc($rsIdProp);
  $totalRows_rsIdProp = mysqli_num_rows($rsIdProp);

  if ($totalRows_rsIdProp != '') {
    echo $row_rsIdProp['id_pro'];
  }

  echo $tNGs->getErrorMsg();
} else {

    if (isset($_GET['id_pro']) && $_GET['id_pro'] != '') {
      echo $_GET['id_pro'];
    } else {
      echo $id;
    }


}

?>
