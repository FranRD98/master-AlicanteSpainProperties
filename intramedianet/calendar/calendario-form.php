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

// Start trigger
$formValidation = new tNG_FormValidation();

$tNGs->prepareValidation($formValidation);
// End trigger





// Make an insert transaction instance
$ins_citas = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_citas);
// Register triggers
$ins_citas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_Insert1");
$ins_citas->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
// $ins_citas->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");


if (isset($_GET['property_ct']) && $_GET['property_ct'] != '' ) {
  $_GET['property_ct'] = implode(',', array_filter($_GET['property_ct']));
}

// Add columns
$ins_citas->setTable("citas");
  $ins_citas->addColumn("categoria_ct", "NUMERIC_TYPE", "GET", "categoria_ct");
  $ins_citas->addColumn("user_ct", "NUMERIC_TYPE", "GET", "user_ct");
  $ins_citas->addColumn("users_ct", "NUMERIC_TYPE", "GET", "users_ct");
  $ins_citas->addColumn("vendedores_ct", "NUMERIC_TYPE", "GET", "vendedores_ct");
  $ins_citas->addColumn("property_ct", "STRING_TYPE", "GET", "property_ct");
  $ins_citas->addColumn("inicio_ct", "DATE_TYPE",  "GET", "inicio_ct");
  $ins_citas->addColumn("final_ct", "DATE_TYPE",  "GET", "final_ct");
  $ins_citas->addColumn("titulo_ct", "STRING_TYPE",  "GET", "titulo_ct");
  $ins_citas->addColumn("lugar_ct", "STRING_TYPE", "GET", "lugar_ct");
  $ins_citas->addColumn("notas_ct", "STRING_TYPE", "GET", "notas_ct");
$ins_citas->setPrimaryKey("id_ct", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_citas = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_citas);
// Register triggers
$upd_citas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_Update1");
$upd_citas->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
// $upd_citas->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");

// Add columns
$upd_citas->setTable("citas");
  $upd_citas->addColumn("categoria_ct", "NUMERIC_TYPE", "GET", "categoria_ct");
  $upd_citas->addColumn("user_ct", "NUMERIC_TYPE", "GET", "user_ct");
  $upd_citas->addColumn("users_ct", "NUMERIC_TYPE", "GET", "users_ct");
  $upd_citas->addColumn("vendedores_ct", "NUMERIC_TYPE", "GET", "vendedores_ct");
  $upd_citas->addColumn("property_ct", "STRING_TYPE", "GET", "property_ct");
  $upd_citas->addColumn("inicio_ct", "DATE_TYPE",  "GET", "inicio_ct");
  $upd_citas->addColumn("final_ct", "DATE_TYPE",  "GET", "final_ct");
  $upd_citas->addColumn("titulo_ct", "STRING_TYPE",  "GET", "titulo_ct");
  $upd_citas->addColumn("lugar_ct", "STRING_TYPE", "GET", "lugar_ct");
  $upd_citas->addColumn("notas_ct", "STRING_TYPE", "GET", "notas_ct");
$upd_citas->setPrimaryKey("id_ct", "NUMERIC_TYPE", "GET", "id_ct");

// Make an instance of the transaction object
$del_citas = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_citas);
// Register triggers
$del_citas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_Delete1");
$del_citas->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
// $del_citas->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");

// Add columns
$del_citas->setTable("citas");
$del_citas->setPrimaryKey("id_ct", "NUMERIC_TYPE", "GET", "id_ct");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscitas = $tNGs->getRecordset("citas");
$row_rscitas = mysqli_fetch_assoc($rscitas);
$totalRows_rscitas = mysqli_num_rows($rscitas);

if ($tNGs->getErrorMsg() == '') {
  echo "ok";
} else {
  echo $tNGs->getErrorMsg();
}

?>
