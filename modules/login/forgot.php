<?php
// Cargamos la conexión a MySql
// include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/modules/init.php');

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

//require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');


// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");


// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("email_usr", true, "text", "email", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger



//start Trigger_ForgotPasswordCheckEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_ForgotPasswordCheckEmail($tNG) {
  return Trigger_ForgotPassword_CheckEmail($tNG);
}
//end Trigger_ForgotPasswordCheckEmail trigger


//start Trigger_ForgotPassword_Email trigger
//remove this line if you want to edit the code by hand
function Trigger_ForgotPassword_Email($tNG) {

  global $fromMail, $lang, $langStr;

  $password_usr = $tNG->getColumnValue("kt_login_password");
  $email_usr = $tNG->getColumnValue("email_usr");
  $link = $_SERVER['HTTP_HOST']."/login/";
  $nameTemplate = "template_semanal.html";
  $html = getBodyForgotUser($nameTemplate,$email_usr,$password_usr,$link);
  $subject = strtolower($_SERVER['HTTP_HOST']) . " | " . $langStr["Tus nuevos datos de acceso"];

  if (sendAppEmail(array($email_usr => $email_usr), '', array($fromMail => $fromMail), array($fromMail => $fromMail), $subject, $html)) {
      return true;
  } else {
      return false;
  }
}
//end Trigger_ForgotPassword_Email trigger


// Make an update transaction instance
$forgotpass_transaction = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($forgotpass_transaction);
// Register triggers
$forgotpass_transaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$forgotpass_transaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$forgotpass_transaction->registerTrigger("BEFORE", "Trigger_ForgotPasswordCheckEmail", 20);
$forgotpass_transaction->registerTrigger("AFTER", "Trigger_ForgotPassword_Email", 1);
$forgotpass_transaction->registerTrigger("END", "Trigger_Default_Redirect", 99, $urlStart . "login/?info=FORGOT");
// Add columns
$forgotpass_transaction->setTable("users");
$forgotpass_transaction->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$forgotpass_transaction->setPrimaryKey("email_usr", "STRING_TYPE", "POST", "email_usr");


// Execute all the registered transactions
$tNGs->executeTransactions();


// Get the transaction recordset
$rsusers = $tNGs->getRecordset("users");
$row_rsusers = mysqli_fetch_assoc($rsusers);
$totalRows_rsusers = mysqli_num_rows($rsusers);

if ($tNGs->getErrorMsg() != '') {
  $smarty->assign("error1", ''.$tNGs->getErrorMsg().'');
}
?>