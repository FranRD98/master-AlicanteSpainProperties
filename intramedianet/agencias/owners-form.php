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

$ownerId = null;
if (!isset($_GET['id_cnt'])) {

  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'contactos_files'";
  $rsNextIncrement = mysqli_query($inmoconn, $query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);
  if(isset($row_rsNextIncrement['Auto_increment']))
    $ownerId = $row_rsNextIncrement['Auto_increment'];

} else {

  $ownerId = $_GET['id_cnt'];

}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_cnt", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger



//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect(&$tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("owners-form.php?id_cnt=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("contactos_files");
  $tblDelObj->setFieldName("owner_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/owners/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  global $lang;
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("contactos");
  $tblFldObj->addFieldName("email_cnt");
  $tblFldObj->setErrorMsg($lang['Registro duplicado'] . ": {email_cnt}");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

//start Trigger_AddToNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_AddToNewsletter(&$tNG) {
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaAgency;
    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    if ($_POST['newsletter_cnt'] == 1) {
        if ($_POST['email1_cnt'] != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $acumba->addSubscriber($acumbamailIdListaAgency[$_POST['idioma_cnt']], array(
              'email'  => $_POST['email1_cnt'],
              'nombre'  => $_POST['nombre_cnt']
            ));
        }
    } else {
        
        $query_rsClint = "SELECT * FROM agencias WHERE id_cnt = '".$_GET['id_cnt']."'";
        $rsClint = mysqli_query($inmoconn,$query_rsClint) or die(mysqli_error());
        $row_rsClint = mysqli_fetch_assoc($rsClint);
        $totalRows_rsClint = mysqli_num_rows($rsClint);
        $email = $row_rsClint['email1_cnt'];
        if ($email != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $miembros = $acumba->searchSubscriber($email);
            foreach ($miembros as $key => $value) {
                if ($acumbamailIdListaAgency[$_POST['idioma_cnt']] == $value['list_id']) {
                    $acumba = new AcumbamailAPI($keyAcumbamail);
                    $acumba->deleteSubscriber($acumbamailIdListaAgency[$_POST['idioma_cnt']], $value['email']);
                }
            }
        }
    }
}
//end Trigger_AddToNewsletter trigger

//start Trigger_DeletFromNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_DeletFromNewsletter(&$tNG) {
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaAgency;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');

    $query_rsClint = "SELECT * FROM agencias WHERE id_cnt = '".$_GET['id_cnt']."'";
    $rsClint = mysqli_query($inmoconn,$query_rsClint) or die(mysqli_error());
    $row_rsClint = mysqli_fetch_assoc($rsClint);
    $totalRows_rsClint = mysqli_num_rows($rsClint);

    $email = $row_rsClint['email1_cnt'];
    $idioma = $row_rsClint['idioma_cnt'];

    if ($email != '') {
        $acumba = new AcumbamailAPI($keyAcumbamail);
        $miembros = $acumba->searchSubscriber($email);
        foreach ($miembros as $key => $value) {
            if ($acumbamailIdListaAgency[$idioma] == $value['list_id']) {
                $acumba = new AcumbamailAPI($keyAcumbamail);
                $acumba->deleteSubscriber($acumbamailIdListaAgency[$idioma], $value['email']);
            }
        }
    }
}
//end Trigger_DeletFromNewsletter trigger

// Make an insert transaction instance
$ins_contactos = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_contactos);
// Register triggers
$ins_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_contactos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contactos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
if ($actMailchimp == 1) {
$ins_contactos->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
// Add columns
$ins_contactos->setTable("agencias");
$ins_contactos->addColumn("nombre_cnt", "STRING_TYPE", "POST", "nombre_cnt");
// $ins_contactos->addColumn("apellidos_cnt", "STRING_TYPE", "POST", "apellidos_cnt");
$ins_contactos->addColumn("cif_cnt", "STRING_TYPE", "POST", "cif_cnt");
$ins_contactos->addColumn("idioma_cnt", "STRING_TYPE", "POST", "idioma_cnt");
$ins_contactos->addColumn("email1_cnt", "STRING_TYPE", "POST", "email1_cnt");
// $ins_contactos->addColumn("email2_cnt", "STRING_TYPE", "POST", "email2_cnt");
// $ins_contactos->addColumn("email3_cnt", "STRING_TYPE", "POST", "email3_cnt");
$ins_contactos->addColumn("direccion_cnt", "STRING_TYPE", "POST", "direccion_cnt");
$ins_contactos->addColumn("referencia_cnt", "STRING_TYPE", "POST", "referencia_cnt");
$ins_contactos->addColumn("telefono1_cnt", "STRING_TYPE", "POST", "telefono1_cnt");
$ins_contactos->addColumn("telefono2_cnt", "STRING_TYPE", "POST", "telefono2_cnt");
if ($actMailchimp == 1) {
    $ins_contactos->addColumn("newsletter_cnt", "CHECKBOX_1_0_TYPE", "POST", "newsletter_cnt", "0");
}
// $ins_contactos->addColumn("telefono3_cnt", "STRING_TYPE", "POST", "telefono3_cnt");
$ins_contactos->addColumn("web_cnt", "STRING_TYPE", "POST", "web_cnt");
$ins_contactos->addColumn("notas_cnt", "STRING_TYPE", "POST", "notas_cnt");
$ins_contactos->setPrimaryKey("id_cnt", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contactos = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_contactos);
// Register triggers
$upd_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_contactos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contactos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
if ($actMailchimp == 1) {
$upd_contactos->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
// Add columns
$upd_contactos->setTable("agencias");
$upd_contactos->addColumn("nombre_cnt", "STRING_TYPE", "POST", "nombre_cnt");
// $upd_contactos->addColumn("apellidos_cnt", "STRING_TYPE", "POST", "apellidos_cnt");
$upd_contactos->addColumn("cif_cnt", "STRING_TYPE", "POST", "cif_cnt");
$upd_contactos->addColumn("idioma_cnt", "STRING_TYPE", "POST", "idioma_cnt");
$upd_contactos->addColumn("email1_cnt", "STRING_TYPE", "POST", "email1_cnt");
// $upd_contactos->addColumn("email2_cnt", "STRING_TYPE", "POST", "email2_cnt");
// $upd_contactos->addColumn("email3_cnt", "STRING_TYPE", "POST", "email3_cnt");
$upd_contactos->addColumn("direccion_cnt", "STRING_TYPE", "POST", "direccion_cnt");
$upd_contactos->addColumn("referencia_cnt", "STRING_TYPE", "POST", "referencia_cnt");
$upd_contactos->addColumn("telefono1_cnt", "STRING_TYPE", "POST", "telefono1_cnt");
$upd_contactos->addColumn("telefono2_cnt", "STRING_TYPE", "POST", "telefono2_cnt");
if ($actMailchimp == 1) {
    $upd_contactos->addColumn("newsletter_cnt", "CHECKBOX_1_0_TYPE", "POST", "newsletter_cnt");
}
// $upd_contactos->addColumn("telefono3_cnt", "STRING_TYPE", "POST", "telefono3_cnt");
$upd_contactos->addColumn("web_cnt", "STRING_TYPE", "POST", "web_cnt");
$upd_contactos->addColumn("notas_cnt", "STRING_TYPE", "POST", "notas_cnt");
$upd_contactos->setPrimaryKey("id_cnt", "NUMERIC_TYPE", "GET", "id_cnt");

// Make an instance of the transaction object
$del_contactos = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_contactos);
// Register triggers
$del_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_contactos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_contactos->registerTrigger("BEFORE", "Trigger_DeletFromNewsletter", 10);
// Add columns
$del_contactos->setTable("agencias");
$del_contactos->setPrimaryKey("id_cnt", "NUMERIC_TYPE", "GET", "id_cnt");

// Execute all the registered transactions
$tNGs->executeTransactions();


// Get the transaction recordset
$rscontactos = $tNGs->getRecordset("agencias");
$row_rscontactos = mysqli_fetch_assoc($rscontactos);
$totalRows_rscontactos = mysqli_num_rows($rscontactos);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-id-card-clip"></i> <?php if (@$_GET['id_cnt'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Agencia'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_cnt'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="btn btn-success btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?></span></button>
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                                <button type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 btn btn-danger btn-sm"><i class="fa-regular fa-trash-can fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Delete_FB"); ?></span></button>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-chevron-left fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>
                        </div>
                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "referencia_cnt") != '') { ?>error<?php } ?>">
                                        <label for="referencia_cnt"><?php __('Nombre de agencia'); ?>:</label>
                                        <input type="text" name="referencia_cnt" id="referencia_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['referencia_cnt']); ?>" size="32" maxlength="255" class="form-control required">
                                        <?php echo $tNGs->displayFieldError("contactos", "referencia_cnt"); ?>
                                    </div>


                                    <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "nombre_cnt") != '') { ?>error<?php } ?>">
                                        <label for="nombre_cnt"><?php __('Persona de Contacto'); ?>:</label>
                                        <input type="text" name="nombre_cnt" id="nombre_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['nombre_cnt']); ?>" size="32" maxlength="255" class="form-control required">
                                        <?php echo $tNGs->displayFieldError("contactos", "nombre_cnt"); ?>
                                    </div>

                                    <!-- <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "apellidos_cnt") != '') { ?>error<?php } ?>">
                                        <label for="apellidos_cnt"><?php __('Apellidos'); ?>:</label>
                                        <input type="text" name="apellidos_cnt" id="apellidos_cnt" value="<?php //echo KT_escapeAttribute($row_rscontactos['apellidos_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("contactos", "apellidos_cnt"); ?>
                                    </div> -->


                                    <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "telefono1_cnt") != '') { ?>error<?php } ?>">
                                        <label for="telefono1_cnt"><?php __('Teléfono'); ?> / Whatsapp:</label>
                                        <input type="text" name="telefono1_cnt" id="telefono1_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['telefono1_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("contactos", "telefono1_cnt"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "telefono2_cnt") != '') { ?>error<?php } ?>">
                                        <label for="telefono2_cnt"><?php __('Móvil'); ?> / Whatsapp:</label>
                                        <input type="text" name="telefono2_cnt" id="telefono2_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['telefono2_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("contactos", "telefono2_cnt"); ?>
                                    </div>

                                     <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "email1_cnt") != '') { ?>error<?php } ?>">
                                      <label for="email1_cnt"><?php __('Email'); ?>:</label>
                                          <input type="text" name="email1_cnt" id="email1_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['email1_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("contactos", "email1_cnt"); ?>
                                    </div>

                                     <!-- <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "email2_cnt") != '') { ?>error<?php } ?>">
                                      <label for="email2_cnt"><?php __('Email'); ?> 2:</label>
                                          <input type="text" name="email2_cnt" id="email2_cnt" value="<?php //echo KT_escapeAttribute($row_rscontactos['email2_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("contactos", "email2_cnt"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "telefono3_cnt") != '') { ?>error<?php } ?>">
                                        <label for="telefono3_cnt"><?php __('Teléfono'); ?> 3:</label>
                                        <input type="text" name="telefono3_cnt" id="telefono3_cnt" value="<?php //echo KT_escapeAttribute($row_rscontactos['telefono3_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("contactos", "telefono3_cnt"); ?>
                                    </div> -->

                                     <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "idioma_cnt") != '') { ?>has-error<?php } ?>">
                                              <label for="idioma_cnt"><?php __('Idioma'); ?>:</label>
                                              <select name="idioma_cnt" id="idioma_cnt" class="form-control required">
                                                  <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                  <?php
                                                  if ($lang_adm == 'es') {
                                                      $idiomas = array('da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'tr' => 'Türk');
                                                  } else {
                                                      $idiomas = array('da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'tr' => 'Türk');
                                                  }
                                                  foreach ($languages as $value) {
                                                      $selected = (!(strcmp($value, $row_rscontactos['idioma_cnt'])))?" SELECTED":"";
                                                      echo '<option value="'.$value.'"'.$selected.'>'.$idiomas[$value].'</option>';
                                                  }
                                                  ?>
                                              </select>
                                              <?php echo $tNGs->displayFieldError("properties_client", "idioma_cnt"); ?>
                                          </div>

                                     <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "cif_cnt") != '') { ?>error<?php } ?>">
                                        <label for="cif_cnt"><?php __('CIF'); ?>:</label>
                                        <input type="text" name="cif_cnt" id="cif_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['cif_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("contactos", "cif_cnt"); ?>
                                    </div>

                                </div>



                                <div class="col-md-6">

                                    <?php if ($actMailchimp == 1): ?>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                     

                                             <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                                  <input type="checkbox" name="newsletter_cnt" id="newsletter_cnt" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rscontactos['newsletter_cnt']),"1"))) {echo "checked";} ?>>
                                                  <label class="form-check-label" for="destacado_prop"><?php __('Añadir a la newsletter'); ?></label>
                                                  
                                              </div>

                                        </div> 
                                        
                                    </div>
                                    <br>
                                    <?php endif ?>
                                   <!--  <div class="form-group <?php if($tNGs->displayFieldError("contactos", "email3_cnt") != '') { ?>error<?php } ?>">
                                      <label for="email3_cnt"><?php __('Email'); ?> 3:</label>
                                          <input type="text" name="email3_cnt" id="email3_cnt" value="<?php //echo KT_escapeAttribute($row_rscontactos['email3_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("contactos", "email3_cnt"); ?>
                                    </div> -->

                                   


                                    <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "direccion_cnt") != '') { ?>error<?php } ?>">
                                      <label for="direccion_cnt"><?php __('Dirección'); ?>:</label>
                                          <input type="text" name="direccion_cnt" id="direccion_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['direccion_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("contactos", "direccion_cnt"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "web_cnt") != '') { ?>error<?php } ?>">
                                      <label for="web_cnt"><?php __('Web'); ?>:</label>
                                          <input type="text" name="web_cnt" id="web_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['web_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("contactos", "web_cnt"); ?>
                                    </div>


                                            <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "notas_cnt") != '') { ?>has-error<?php } ?>">

                                                <label for="notas_cnt"><?php __('Notas'); ?>:</label>
                                                <textarea type="text" name="notas_cnt" id="notas_cnt" cols="50" rows="8" class="form-control"><?php echo KT_escapeAttribute($row_rscontactos['notas_cnt']); ?></textarea>
                                                <?php echo $tNGs->displayFieldError("properties_client", "notas_cnt"); ?>
                                                <hr>
                                                <a href="#" class="btn btn-success addNot pull-right"><?php __('Añadir fecha'); ?></a>
                                            </div>


                                </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="kt_pk_contactos" class="id_field" value="<?php if(isset($row_rscontactos['kt_pk_contactos'])) echo KT_escapeAttribute($row_rscontactos['kt_pk_contactos']); ?>" />

    </form>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var idOwner = '<?php echo $ownerId; ?>';
    var oTable;
    var selected =  new Array();


    $('.addNot').click(function (e){
        e.preventDefault();
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        day = (day > 9)?day:'0'+day;
        month = (month > 9)?month:'0'+month;
        hour = (hour > 9)?hour:'0'+hour;
        minutes = (minutes > 9)?minutes:'0'+minutes;
        $('#notas_cnt').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n"+$('#notas_cnt').val());
    });

    </script>

    <script src="_js/owners-form.js" type="text/javascript"></script>



<div id="myModal2" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4><?php __('Editar nombres'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="loadingfrm"></div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success" data-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
      </div>
    </div>
  </div>
</div>

<div id="myModal5" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4><?php __('Añadir Estatus'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="mb-4">
            <label for="category_en_sts"><?php __('Estatus'); ?>:</label>
            <div class="input-group">
              <span class="input-group-addon"><img src="../includes/assets/img/flags-langs/en.png" alt=""></span>
              <input type="text" name="category_en_sts" id="category_en_sts" value="" size="32" maxlength="255" class="form-control required">
            </div>
        </div>
        <div class="mb-4">
            <label for="category_es_sts"><?php __('Estatus'); ?>:</label>
            <div class="input-group">
              <span class="input-group-addon"><img src="../includes/assets/img/flags-langs/es.png" alt=""></span>
              <input type="text" name="category_es_sts" id="category_es_sts" value="" size="32" maxlength="255" class="form-control required">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success" data-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
      </div>
    </div>
  </div>
</div>





</body>
</html>
