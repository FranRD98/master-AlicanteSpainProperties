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

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');


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

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords($tNG) {
  $myThrowError = new tNG_ThrowError($tNG);
  $myThrowError->setErrorMsg(__("No se puede crear la cuenta.", true));
  $myThrowError->setField("password_usr");
  $myThrowError->setFieldErrorMsg(__("Las dos contraseñas no coinciden.", true));
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
/*
function Trigger_SendEmail($tNG) {
  global $fromMail, $lang_adm;
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom($fromMail);
  $emailObj->setTo("{email_usr}");
  $emailObj->setCC("");
  $emailObj->setBCC("");
  $emailObj->setSubject(strtolower($_SERVER['HTTP_HOST']) . " | " . __("Tus datos de acceso", true));
  //FromFile method
  $emailObj->setContentFile("../../includes/mailtemplates/welcome_" . $lang_adm . ".html");
  $emailObj->setEncoding("UTF-8");
  $emailObj->setFormat("HTML/Text");
  $emailObj->setImportance("High");
  return $emailObj->Execute();
}
*/

function Trigger_SendEmail2($tNG){
    global $fromMail, $lang_adm;
    $email_usr = $tNG->getColumnValue("email_usr");
    $pass = $tNG->getColumnValue("password_usr");
    $nameTemplate = "template_semanal.html";
    $link = $_SERVER['HTTP_HOST']."/login/";
    $html = getBodyNewUser($nameTemplate,$email_usr,$pass,$link);

    $name_usr = $tNG->getColumnValue("nombre_usr");
    $subject = strtolower($_SERVER['HTTP_HOST']) . " | " . __("Tus datos de acceso", true);
    if (sendAppEmail(array($email_usr => $name_usr), '', array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), $subject, $html)) {
        return true;
    } else {
        return false;
    }

}
//end Trigger_SendEmail trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields($tNG) {
  $tNG->addColumn("registrationdate_usr", "DATE_TYPE", "EXPRESSION", "{NOW_DT}");
  return $tNG->getError();
}
//end addFields trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_usr", true, "text", "", "", "", "");
$formValidation->addField("email_usr", true, "text", "email", "", "", "");
$formValidation->addField("password_usr", true, "text", "", "", "", "");
$formValidation->addField("nivel_usr", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword($tNG) {
  return Trigger_UpdatePassword_CheckOldPassword($tNG);
}
//end Trigger_CheckOldPassword trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand
function Trigger_FileDelete($tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../../media/images/users/");
  $deleteObj->setDbFieldName("image_usr");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand
function Trigger_ImageUpload($tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("image_usr");
  $uploadObj->setDbFieldName("image_usr");
  $uploadObj->setFolder("../../media/images/users/");
  $uploadObj->setMaxSize(0);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("custom");
  $uploadObj->setRenameRule("{id_usr}.{KT_ext}");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

// Make an insert transaction instance
$ins_users = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_users);
// Register triggers
$ins_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_users->registerConditionalTrigger("{POST.password_usr} != {POST.re_password_usr}", "BEFORE", "Trigger_CheckPasswords", 50);
$ins_users->registerTrigger("BEFORE", "addFields", 10);

if (isset($_POST['activar_usr']) && $_POST['activar_usr'] == 1) {
  $ins_users->registerTrigger("AFTER", "Trigger_SendEmail2", 98);
}
// Add columns
$ins_users->setTable("users");
$ins_users->addColumn("nombre_usr", "STRING_TYPE", "POST", "nombre_usr");
$ins_users->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$ins_users->addColumn("password_usr", "STRING_TYPE", "POST", "password_usr");
$ins_users->addColumn("nivel_usr", "NUMERIC_TYPE", "POST", "nivel_usr");
$ins_users->addColumn("activar_usr", "CHECKBOX_1_0_TYPE", "POST", "activar_usr", "1");
foreach($languages as $value) {
    $ins_users->addColumn("firma_".$value."_usr", "STRING_TYPE", "POST", "firma_".$value."_usr");
}
$ins_users->setPrimaryKey("id_usr", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_users = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_users);
// Register triggers
$upd_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_users->registerConditionalTrigger("{POST.password_usr} != {POST.re_password_usr}", "BEFORE", "Trigger_CheckPasswords", 50);
// $upd_users->registerTrigger("BEFORE", "Trigger_CheckOldPassword", 60);

// Add columns
$upd_users->setTable("users");
$upd_users->addColumn("nombre_usr", "STRING_TYPE", "POST", "nombre_usr");
$upd_users->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$upd_users->addColumn("password_usr", "STRING_TYPE", "POST", "password_usr");
$upd_users->addColumn("nivel_usr", "NUMERIC_TYPE", "POST", "nivel_usr");
$upd_users->addColumn("activar_usr", "CHECKBOX_1_0_TYPE", "POST", "activar_usr");
$upd_users->setPrimaryKey("id_usr", "NUMERIC_TYPE", "GET", "id_usr");

// Make an instance of the transaction object
$del_users = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_users);
// Register triggers
$del_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_users->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_users->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_users->setTable("users");
$del_users->setPrimaryKey("id_usr", "NUMERIC_TYPE", "GET", "id_usr");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsusers = $tNGs->getRecordset("users");
$row_rsusers = mysqli_fetch_assoc($rsusers);
$totalRows_rsusers = mysqli_num_rows($rsusers);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include("../includes/inc.head.php"); ?>

</head>

<body>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-users"></i> <?php if (@$_GET['id_usr'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php if ($lang_adm == 'es'): ?><?php __('Usuario'); ?> Website<?php else: ?>Website <?php __('Usuario'); ?><?php endif ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_usr'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="btn btn-success btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?></span></button>
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                                <button type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 btn btn-danger btn-sm"><i class="fa-regular fa-trash-can fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Delete_FB"); ?></span></button>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-chevron-left fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="mb-3">
                                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                                <input type="checkbox" name="activar_usr" id="activar_usr" value="1" class="form-check-input" <?php if (isset($row_rsusers['activar_usr']) && !(strcmp(KT_escapeAttribute($row_rsusers['activar_usr']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="activar_usr"><?php __('Activar la cuenta'); ?></label>
                                                <?php echo $tNGs->displayFieldError("users", "activar_usr"); ?>
                                            </div>
                                        </div>

                                        <input type="hidden" name="nivel_usr" id="nivel_usr" value="1">

                                        <div class="mb-3 <?php if($tNGs->displayFieldError("users", "nombre_usr") != '') { ?>has-error<?php } ?>">
                                            <label for="nombre_usr" class="form-label"><?php __('Nombre'); ?></label>
                                            <input type="text" name="nombre_usr" id="nombre_usr" value="<?php if(isset($row_rsusers['nombre_usr'])) echo KT_escapeAttribute($row_rsusers['nombre_usr']); ?>" size="32" maxlength="255" class="form-control required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("users", "nombre_usr"); ?>
                                        </div>

                                        <div class="mb-3 <?php if($tNGs->displayFieldError("users", "email_usr") != '') { ?>has-error<?php } ?>">
                                            <label for="email_usr" class="form-label"><?php __('Email'); ?></label>
                                            <input type="email" name="email_usr" id="email_usr" value="<?php if(isset($row_rsusers['email_usr'])) echo KT_escapeAttribute($row_rsusers['email_usr']); ?>" size="32" maxlength="255" class="form-control email required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Por favor, escribe una dirección de correo válida.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("users", "email_usr"); ?>
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div id="pwd-container">

                                            <div class="mb-3 <?php if($tNGs->displayFieldError("users", "password_usr") != '') { ?>has-error<?php } ?>">

                                                <label class="form-label <?php if (@$_GET['id_usr'] == "") { ?>required<?php } ?>" for="password-input"><?php __('Contraseña'); ?></label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" name="password_usr" id="password-input" value="" size="32" maxlength="255" class="form-control pe-5 password-input required" placeholder="<?php __('Contraseña'); ?>" <?php if (@$_GET['id_usr'] == "") { ?>required<?php } ?>>
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    <div class="invalid-feedback">
                                                        <?php __('Este campo es obligatorio.'); ?>
                                                    </div>
                                                    <?php echo $tNGs->displayFieldError("users", "password_usr"); ?>
                                                </div>
                                                <div class="row">
                                                  <div class="col-lg-4">
                                                      <button type="button" name="KT_Cancel1" class="btn btn-soft-primary btn-sm pass-generator w-100"><i class="fa-regular fa-key fa-fw me-1"></i> <?php echo _('Generar'); ?></button>
                                                  </div>
                                                  <div class="col-lg-8">
                                                      <div class="pwstrength_viewport_progress mt-2"></div>
                                                  </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="mb-3 <?php if($tNGs->displayFieldError("users", "re_password_usr") != '') { ?>has-error<?php } ?>">
                                            <label for="re_password_usr" class="form-label"><?php __('Confirmar contraseña'); ?>:</label>
                                            <input type="password" name="re_password_usr" id="re_password_usr" value="" size="32" maxlength="255" class="form-control <?php if (@$_GET['id_usr'] == "") { ?>required<?php } ?>" <?php if (@$_GET['id_usr'] == "") { ?>required<?php } ?>>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("users", "re_password_usr"); ?>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="kt_pk_users" class="id_field" value="<?php if(isset($row_rsusers['kt_pk_users'])) echo KT_escapeAttribute($row_rsusers['kt_pk_users']); ?>" />

    </form>

<?php include("../includes/inc.footer.php"); ?>

<!-- password-addon init -->
<script src="/intramedianet/includes/assets/js/pages/password-addon.init.js"></script>

</body>
</html>
