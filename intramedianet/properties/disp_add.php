<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("property_disp", true, "numeric", "", "", "", "");
$formValidation->addField("inicio_disp", true, "date", "", "", "", "");
$formValidation->addField("final_disp", true, "date", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_properties_disponibilidad = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_disponibilidad);
// Register triggers
$ins_properties_disponibilidad->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "p");
$ins_properties_disponibilidad->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
// Add columns
$ins_properties_disponibilidad->setTable("properties_disponibilidad");
$ins_properties_disponibilidad->addColumn("privado_disp", "NUMERIC_TYPE", "GET", "privado_disp");
$ins_properties_disponibilidad->addColumn("property_disp", "NUMERIC_TYPE", "GET", "p");
$ins_properties_disponibilidad->addColumn("inicio_disp", "DATE_TYPE", "GET", "i");
$ins_properties_disponibilidad->addColumn("final_disp", "DATE_TYPE", "GET", "f");
$ins_properties_disponibilidad->setPrimaryKey("id_disp", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_disponibilidad = $tNGs->getRecordset("properties_disponibilidad");
$row_rsproperties_disponibilidad = mysqli_fetch_assoc($rsproperties_disponibilidad);
$totalRows_rsproperties_disponibilidad = mysqli_num_rows($rsproperties_disponibilidad);
?>
<?php
	if($tNGs->getErrorMsg() == '') {
		echo 'ok';
	}
?>
