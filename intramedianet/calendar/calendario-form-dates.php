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

// Make an update transaction instance
$upd_citas = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_citas);
// Register triggers
$upd_citas->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "id_ct");
$upd_citas->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);

// Add columns
$upd_citas->setTable("citas");
  $upd_citas->addColumn("inicio_ct", "DATE_TYPE",  "GET", "inicio_ct");
  $upd_citas->addColumn("final_ct", "DATE_TYPE",  "GET", "final_ct");
$upd_citas->setPrimaryKey("id_ct", "NUMERIC_TYPE", "GET", "id_ct");

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