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
$formValidation->addField("category_en_cap", true, "text", "", "", "", "");
$formValidation->addField("category_es_cap", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("properties_client");
  $tblFldObj->setFieldName("status_cli");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay registros que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("type_cap", "NUMERIC_TYPE", "EXPRESSION", "1");
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
$ins_properties_client_captado = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_client_captado);
// Register triggers
$ins_properties_client_captado->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_client_captado->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
// $ins_properties_client_captado->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_client_captado->registerTrigger("END", "Trigger_return_id", 99);
// Add columns
$ins_properties_client_captado->setTable("properties_client_captado");
$ins_properties_client_captado->addColumn("category_en_cap", "STRING_TYPE", "POST", "category_en_cap");
$ins_properties_client_captado->addColumn("category_es_cap", "STRING_TYPE", "POST", "category_es_cap");
// $ins_properties_client_captado->addColumn("category_fr_cap", "STRING_TYPE", "POST", "category_fr_cap");
$ins_properties_client_captado->setPrimaryKey("id_cap", "NUMERIC_TYPE");


// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_client_captado = $tNGs->getRecordset("properties_client_captado");
$row_rsproperties_client_captado = mysqli_fetch_assoc($rsproperties_client_captado);
$totalRows_rsproperties_client_captado = mysqli_num_rows($rsproperties_client_captado);

if ($tNGs->getErrorMsg() != '') {
  echo $tNGs->getErrorMsg();
} else {
  echo $id;
}
?>
