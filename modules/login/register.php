<?php

  //ini_set('display_errors', 1);
  //error_reporting(E_ALL);

// Cargamos la conexión a MySql
// include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

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

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail($tNG) {

    global $langStr, $fromMail, $lang, $inmoconn, $_POST;
    $telefono = mysqli_real_escape_string($inmoconn, $_POST['telefono_fijo_cli']);
    if (strpos($telefono, '8') !== 0) 
    {
      $email_usr = $tNG->getColumnValue("email_usr");
      $name_usr = $tNG->getColumnValue("nombre_usr");
      $pass = $tNG->getColumnValue("password_usr");
      $nameTemplate = "template_semanal.html";
      $link = $_SERVER['HTTP_HOST']."/login/";
      $html = getBodyNewUser($nameTemplate,$email_usr,$pass,$link,$subject);
      $subject = strtolower($_SERVER['HTTP_HOST']) . " | " . $langStr["Tus datos de acceso"];

      if (sendAppEmail(array($email_usr => $name_usr), '', array($fromMail => $fromMail), array($fromMail => $fromMail), $subject, $html)) {
          return true;
      } else {
          return false;
      }
    }
    else 
    {
      $myThrowError = new tNG_ThrowError($tNG);
      $myThrowError->setErrorMsg("No se puede crear la cuenta ");
      $myThrowError->setField("password_usr");
      $myThrowError->setFieldErrorMsg("No se puede crear la cuenta ");
      return $myThrowError->Execute();
    }

}
//end Trigger_SendEmail trigger

function Trigger_SendEmailCopy($tNG) {

    global $langStr, $fromMail, $lang, $inmoconn, $_POST;
    $telefono = mysqli_real_escape_string($inmoconn,$_POST['telefono_fijo_cli']);

    if (strpos($telefono, '8') !== 0)
    {
      $email_usr = $tNG->getColumnValue("email_usr");
      $name_usr = $tNG->getColumnValue("nombre_usr");
      
      $nameTemplate = "template_semanal.html";
      $html = getBodyNewUserCopy($nameTemplate,$email_usr,$name_usr);
      
      $subject = strtolower($_SERVER['HTTP_HOST']) . " | " . $langStr["Tus datos de acceso"];

      if (sendAppEmail(array($fromMail => $fromMail), '', array($fromMail => $fromMail), array($fromMail => $fromMail), $subject, $html)) {
          return true;
      } else {
          return false;
      }
    }
    else
    {
      $myThrowError = new tNG_ThrowError($tNG);
      $myThrowError->setErrorMsg("No se puede crear la cuenta ");
      $myThrowError->setField("password_usr");
      $myThrowError->setFieldErrorMsg("No se puede crear la cuenta ");
      return $myThrowError->Execute();

    }


}

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

  global $database_inmoconn, $inmoconn, $_POST, $lang;

  $telefono = sanitizeInput($_POST['telefono_fijo_cli']);
  $telefono = mysqli_real_escape_string($inmoconn,$telefono);

  if (strpos($telefono, '8') === 0)
  {
      $myThrowError = new tNG_ThrowError($tNG);
      $myThrowError->setErrorMsg("No se puede crear la cuenta ");
      $myThrowError->setField("password_usr");
      $myThrowError->setFieldErrorMsg("No se puede crear la cuenta ");
      return $myThrowError->Execute();
  }
  else 
  {
    
      $email = mysqli_real_escape_string($inmoconn,$_POST['email_usr']);
      $email = sanitizeAndValidateEmail($email);  

      $query_rsTipos = "SELECT * FROM properties_client WHERE email_cli = ?";
      $stmt = $inmoconn->prepare($query_rsTipos);
      $stmt->bind_param('s', $email);
      $stmt->execute();
      $rsTipos = $stmt->get_result();
      $totalRows_rsTipos = $rsTipos->num_rows;

      $user_cli = $tNG->getColumnValue('id_usr');
      $como_nos_conocio_cli = 3; // or whatever value
      $usuario_cli = 1;

      if($totalRows_rsTipos == 0){
          
        $query_rsInsert = "
          INSERT INTO properties_client SET
          `user_cli`= ?,
          `nombre_cli`= ?,
          `apellidos_cli`= ?,
          `telefono_fijo_cli`= ?,
          `email_cli`= ?,
          `idioma_cli`= ?,
          `fecha_alta_cli`= ?,
          `como_nos_conocio_cli`= ?,
          `usuario_cli`= ?
        ";

        $stmt = $inmoconn->prepare($query_rsInsert);  
        $nombre_cli = sanitizeInput($_POST['nombre_usr']);
        $apellidos_cli = sanitizeInput($_POST['apellidos_cli']);
        $fecha_alta_cli = date("Y-m-d h:i:s");

        $stmt->bind_param('issssssis', $user_cli, $nombre_cli, $apellidos_cli, $telefono, $email, $lang, $fecha_alta_cli, $como_nos_conocio_cli, $usuario_cli);
        $stmt->execute();
        
      } else {

        $query_rsInsert = "
            UPDATE properties_client SET
            `user_cli`= ?,
            `como_nos_conocio_cli`= ?,
            `archived_cli`= ?,
            `usuario_cli`= ?
            WHERE email_cli = ?
        ";

        $stmt = $inmoconn->prepare($query_rsInsert);
        $archived_cli = 0;
        $stmt->bind_param('iiiss', $user_cli, $como_nos_conocio_cli, $archived_cli, $usuario_cli, $email);
        $stmt->execute();

      }


      return true;
  }

}
//end Trigger_addClient trigger

//start Trigger_recatpcha trigger
//remove this line if you want to edit the code by hand
function Trigger_recaptcha($tNG) {

  global $database_inmoconn, $inmoconn, $_POST, $_GET, $langStr, $google_captcha_sitekey, $google_captcha_privatekey ;

  if ($_POST["g-recaptcha-response"] == '') {
    $myThrowError = new tNG_ThrowError($tNG);
    $myThrowError->setErrorMsg("No se puede crear la cuenta ");
    $myThrowError->setField("password_usr");
    $myThrowError->setFieldErrorMsg("No se puede crear la cuenta ");
    return $myThrowError->Execute();
  }

  $recaptcha = $_POST["g-recaptcha-response"];
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $data = array(
      'secret' => $google_captcha_privatekey,
      'response' => $recaptcha,
      'remoteip' => $_SERVER['REMOTE_ADDR']
  );
  $options = array(
      'http' => array (
          'method' => 'POST',
          'content' => http_build_query($data)
      )
  );
  $context  = stream_context_create($options);
  $verify = file_get_contents($url, false, $context);
  $captcha_success = json_decode($verify);

  if ($captcha_success->success) {

  return true;

  } else {

    $myThrowError = new tNG_ThrowError($tNG);
    $myThrowError->setErrorMsg("No se puede crear la cuenta ");
    $myThrowError->setField("password_usr");
    $myThrowError->setFieldErrorMsg("No se puede crear la cuenta ");
    return $myThrowError->Execute();

  }
}
//end Trigger_recatpcha trigger

// Make an insert transaction instance
$ins_users = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_users);
// Register triggers
$ins_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_users->registerTrigger("END", "Trigger_Default_Redirect", 99, $urlStart . "login/?info=REGISTER");
$ins_users->registerConditionalTrigger("{POST.password_usr} != {POST.re_password_usr}", "BEFORE", "Trigger_CheckPasswords", 50);

$ins_users->registerTrigger("BEFORE", "Trigger_recaptcha", 1); 

$ins_users->registerTrigger("BEFORE", "addFields", 10);
$ins_users->registerTrigger("AFTER", "Trigger_SendEmail", 98);
$ins_users->registerTrigger("AFTER", "Trigger_SendEmailCopy", 98);
$ins_users->registerTrigger("AFTER", "Trigger_addClient", 99);
// Add columns
$ins_users->setTable("users");
$ins_users->addColumn("nombre_usr", "STRING_TYPE", "POST", "nombre_usr");
$ins_users->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$ins_users->addColumn("password_usr", "STRING_TYPE", "POST", "password_usr");
$ins_users->setPrimaryKey("id_usr", "NUMERIC_TYPE");

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
