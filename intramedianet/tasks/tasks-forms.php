<?php
date_default_timezone_set('Europe/Madrid');


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

$query_rsAdminis = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsAdminis = mysqli_query($inmoconn, $query_rsAdminis) or die(mysqli_error());
$row_rsAdminis = mysqli_fetch_assoc($rsAdminis);
$totalRows_rsAdminis = mysqli_num_rows($rsAdminis);

$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

function getAdmin($id) {

    global $database_inmoconn, $inmoconn;

    $query_rsAdminis = "SELECT nombre_usr, id_usr FROM users WHERE id_usr  = '".$id."' ORDER BY nombre_usr";
    $rsAdminis = mysqli_query($inmoconn, $query_rsAdminis) or die(mysqli_error());
    $row_rsAdminis = mysqli_fetch_assoc($rsAdminis);
    $totalRows_rsAdminis = mysqli_num_rows($rsAdminis);

    return $row_rsAdminis['nombre_usr'];
}

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("created_by_tsk", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("created_by_date_tsk", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  $tNG->addColumn("modified_by_tsk", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("modified_by_date_tsk", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  return $tNG->getError();
}
//end addFields trigger

//start addFields2 trigger
//remove this line if you want to edit the code by hand
function addFields2(&$tNG) {
  $tNG->addColumn("modified_by_tsk", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("modified_by_date_tsk", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  return $tNG->getError();
}
//end addFields2 trigger

if (isset($_POST['property_tsk']) && $_POST['property_tsk'] != '' ) {
  $_POST['property_tsk'] = implode(',', $_POST['property_tsk']);
}

// Make an insert transaction instance
$ins_tasks = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_tasks);
// Register triggers
$ins_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_Insert1");
$ins_tasks->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_tasks->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_tasks->registerTrigger("BEFORE", "addFields", 10);

// Add columns
$ins_tasks->setTable("tasks");
$ins_tasks->addColumn("admin_tsk", "NUMERIC_TYPE", "GET", "admin_tsk");
$ins_tasks->addColumn("subject_tsk", "STRING_TYPE", "GET", "subject_tsk");
$ins_tasks->addColumn("date_due_tsk", "DATE_TYPE",  "GET", "date_due_tsk");
$ins_tasks->addColumn("priority_tsk", "STRING_TYPE", "GET", "priority_tsk");
$ins_tasks->addColumn("status_tsk", "STRING_TYPE", "GET", "status_tsk");
$ins_tasks->addColumn("property_tsk", "STRING_TYPE", "GET", "property_tsk");
$ins_tasks->addColumn("description_tsk", "STRING_TYPE", "GET", "description_tsk");
$ins_tasks->addColumn("contact_type_tsk", "STRING_TYPE", "GET", "contact_type_tsk");
$ins_tasks->addColumn("contact_tsk", "STRING_TYPE", "GET", "contact_tsk");
$ins_tasks->setPrimaryKey("id_tsk", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_tasks = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_tasks);
// Register triggers
$upd_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_Update1");
$upd_tasks->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_tasks->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_tasks->registerTrigger("BEFORE", "addFields2", 10);

// Add columns
$upd_tasks->setTable("tasks");
$upd_tasks->addColumn("admin_tsk", "NUMERIC_TYPE", "GET", "admin_tsk");
$upd_tasks->addColumn("subject_tsk", "STRING_TYPE", "GET", "subject_tsk");
$upd_tasks->addColumn("date_due_tsk", "DATE_TYPE",  "GET", "date_due_tsk");
$upd_tasks->addColumn("priority_tsk", "STRING_TYPE", "GET", "priority_tsk");
$upd_tasks->addColumn("status_tsk", "STRING_TYPE", "GET", "status_tsk");
$upd_tasks->addColumn("property_tsk", "STRING_TYPE", "GET", "property_tsk");
$upd_tasks->addColumn("description_tsk", "STRING_TYPE", "GET", "description_tsk");
$upd_tasks->addColumn("contact_type_tsk", "STRING_TYPE", "GET", "contact_type_tsk");
$upd_tasks->addColumn("contact_tsk", "STRING_TYPE", "GET", "contact_tsk");
$upd_tasks->addColumn("created_by_tsk", "STRING_TYPE", "CURRVAL");
$upd_tasks->addColumn("created_by_date_tsk", "STRING_TYPE", "CURRVAL");
$upd_tasks->addColumn("modified_by_tsk", "STRING_TYPE", "CURRVAL");
$upd_tasks->addColumn("modified_by_date_tsk", "STRING_TYPE", "CURRVAL");

$upd_tasks->setPrimaryKey("id_tsk", "NUMERIC_TYPE", "GET", "id_tsk");

// Make an instance of the transaction object
$del_tasks = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_tasks);
// Register triggers
$del_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_tasks->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_tasks->setTable("tasks");
$del_tasks->setPrimaryKey("id_tsk", "NUMERIC_TYPE", "GET", "id_tsk");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstasks = $tNGs->getRecordset("tasks");
$row_rstasks = mysqli_fetch_assoc($rstasks);
$totalRows_rstasks = mysqli_num_rows($rstasks);

if ($tNGs->getErrorMsg() == '') {
  echo "ok";
} else {
  echo $tNGs->getErrorMsg();
}
?>