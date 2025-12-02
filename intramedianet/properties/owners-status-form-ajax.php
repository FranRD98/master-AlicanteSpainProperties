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
$formValidation->addField("category_en_sts", true, "text", "", "", "", "");
$formValidation->addField("category_es_sts", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("properties_owner");
  $tblFldObj->setFieldName("status_cli");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay registros que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("type_sts", "NUMERIC_TYPE", "EXPRESSION", "1");
  return $tNG->getError();
}
//end addFields trigger

$id= 0;

//start Trigger_return_id trigger
//remove this line if you want to edit the code by hand
function Trigger_return_id(&$tNG) {

  global $id;

  $id = $tNG->getPrimaryKeyValue();
}
//end Trigger_return_id trigger

// Make an insert transaction instance
$ins_properties_owner_states = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_owner_states);
// Register triggers
$ins_properties_owner_states->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_owner_states->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
// $ins_properties_owner_states->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_owner_states->registerTrigger("END", "Trigger_return_id", 99);
// Add columns
$ins_properties_owner_states->setTable("properties_owner_states");
$ins_properties_owner_states->addColumn("category_en_sts", "STRING_TYPE", "POST", "category_en_sts");
$ins_properties_owner_states->addColumn("category_es_sts", "STRING_TYPE", "POST", "category_es_sts");
// $ins_properties_owner_states->addColumn("category_fr_sts", "STRING_TYPE", "POST", "category_fr_sts");
$ins_properties_owner_states->setPrimaryKey("id_sts", "NUMERIC_TYPE");


// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_owner_states = $tNGs->getRecordset("properties_owner_states");
$row_rsproperties_owner_states = mysqli_fetch_assoc($rsproperties_owner_states);
$totalRows_rsproperties_owner_states = mysqli_num_rows($rsproperties_owner_states);

if ($tNGs->getErrorMsg() != '') {
  echo $tNGs->getErrorMsg();
} else {
  echo $id;
}
?>
