<?php
// Cargamos la conexión a MySql
// include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

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


//End Restrict Access To Page

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords($tNG) {

  global $langStr;

      $myThrowError = new tNG_ThrowError($tNG);
      $myThrowError->setErrorMsg($langStr["No se puede crear la cuenta."]);
      $myThrowError->setField("password_usr");
      $myThrowError->setFieldErrorMsg($langStr["Las dos contraseñas no coinciden."]);
      return $myThrowError->Execute();

}
//end Trigger_CheckPasswords trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields($tNG) {
  $tNG->addColumn("registrationdate_usr", "DATE_TYPE", "EXPRESSION", "{NOW_DT}");
  $tNG->addColumn("nivel_usr", "NUMERIC_TYPE", "EXPRESSION", "1");
  $tNG->addColumn("activar_usr", "NUMERIC_TYPE", "EXPRESSION", "1");
  return $tNG->getError();
}
//end addFields trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_usr", true, "text", "", "", "", "");
$formValidation->addField("email_usr", true, "text", "email", "", "", "");
$formValidation->addField("password_usr", true, "text", "", "", "", "");
// $formValidation->addField("lpd", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_addClient trigger
//remove this line if you want to edit the code by hand
function Trigger_addClient($tNG) {
  global $database_inmoconn, $inmoconn, $_POST;

  // Preparar la consulta SQL
  $query_rsInsert = "
      UPDATE properties_client SET
      nombre_cli = ?,
      apellidos_cli = ?,
      direccion_cli = ?,
      telefono_fijo_cli = ?,
      email_cli = ?,
      fecha_alta_cli = ?
      WHERE user_cli = ?
  ";

  // Obtener los valores de las variables
  $nombre_cli = simpleSanitize($_POST['nombre_usr']);
  $apellidos_cli = simpleSanitize($_POST['apellidos_cli']);
  $direccion_cli = simpleSanitize($_POST['direccion_cli']);
  $telefono_fijo_cli = simpleSanitize($_POST['telefono_fijo_cli']);
  $email_cli = sanitizeAndValidateEmail($_POST['email_usr']);
  $fecha_alta_cli = date("Y-m-d H:i:s");
  $user_cli = $tNG->getColumnValue('id_usr');
  
  $stmt = $inmoconn->prepare($query_rsInsert);
  $archived_cli = 0;
  $stmt->bind_param('ssssssi', $nombre_cli, $apellidos_cli, $direccion_cli, $telefono_fijo_cli, $email_cli, $fecha_alta_cli, $user_cli);
  $stmt->execute();

}

//end Trigger_addClient trigger

// Make an insert transaction instance
$ins_users = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($ins_users);
// Register triggers
$ins_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$ins_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_users->registerTrigger("END", "Trigger_Default_Redirect", 99, $urlStart . "update/?info=UPDATED");
$ins_users->registerConditionalTrigger("{POST.password_usr} != {POST.re_password_usr}", "BEFORE", "Trigger_CheckPasswords", 50);
$ins_users->registerTrigger("AFTER", "Trigger_addClient", 99);
// Add columns
$ins_users->setTable("users");
$ins_users->addColumn("nombre_usr", "STRING_TYPE", "POST", "nombre_usr");
$ins_users->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$ins_users->addColumn("password_usr", "STRING_TYPE", "POST", "password_usr");
$ins_users->setPrimaryKey("id_usr", "NUMERIC_TYPE", "SESSION", "kt_login_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsusers = $tNGs->getRecordset("users");
$row_rsusers = mysqli_fetch_assoc($rsusers);
$totalRows_rsusers = mysqli_num_rows($rsusers);

$smarty->assign("row_rsusers", $row_rsusers);

if ($tNGs->getErrorMsg() != '') {
  $smarty->assign("error1", ''.$tNGs->getErrorMsg().'');
}

if(isset($_SESSION['kt_login_id'])){
  $query = "SELECT * FROM properties_client WHERE user_cli= '".stripslashes(mysqli_real_escape_string($inmoconn, $_SESSION['kt_login_id']))."'";
  //echo $query; die;
  $propertiesFav = getRecords($query);

  $smarty->assign("prpos", $propertiesFav);
}
?>