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

if (!isset($_GET['id_pro'])) {

  
  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'properties_owner_files'";
  $rsNextIncrement = mysqli_query($inmoconn, $query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

  $ownerId = $row_rsNextIncrement['Auto_increment'];

} else {

  $ownerId = $_GET['id_pro'];

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
$formValidation->addField("nombre_pro", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger


$query_rsFiles = "SELECT * FROM properties_owner_files WHERE owner_fil = '".$ownerId."' ";
$rsFiles = mysqli_query($inmoconn, $query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);


$query_rsStatus = "SELECT * FROM properties_owner_states ORDER BY category_".$lang_adm."_sts ASC";
$rsStatus = mysqli_query($inmoconn, $query_rsStatus) or die(mysqli_error());
$row_rsStatus = mysqli_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysqli_num_rows($rsStatus);

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect($tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("owners-form.php?id_pro=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_owner_files");
  $tblDelObj->setFieldName("owner_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/owners/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields($tNG) {
  $tNG->addColumn("user_cli", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  return $tNG->getError();
}
//end addFields trigger

if(isset($_POST["worker"]) && is_array($_POST["worker"])) {
    $_POST["workers_pro"] = implode("@@@@@@", $_POST["worker"]);
  } else {
}

//start Trigger_AddToNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_AddToNewsletter($tNG) {
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaOwners;
    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    if ($_POST['newsletter_pro'] == 1) {
        if ($_POST['email_pro'] != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $acumba->addSubscriber($acumbamailIdListaOwners[$_POST['idioma_pro']], array('email'  => $_POST['email_pro']));
        }
    } else {
        
        $query_rsClint = "SELECT * FROM properties_owner WHERE id_pro = '".$_GET['id_pro']."'";
        $rsClint = mysqli_query($inmoconn, $query_rsClint) or die(mysqli_error());
        $row_rsClint = mysqli_fetch_assoc($rsClint);
        $totalRows_rsClint = mysqli_num_rows($rsClint);
        $email = $row_rsClint['email_pro'];
        if ($email != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $miembros = $acumba->searchSubscriber($email);
            foreach ($miembros as $key => $value) {
                if ($acumbamailIdListaOwners[$_POST['idioma_pro']] == $value['list_id']) {
                    $acumba = new AcumbamailAPI($keyAcumbamail);
                    $acumba->deleteSubscriber($acumbamailIdListaOwners[$_POST['idioma_pro']], $value['id']);
                }
            }
        }
    }
}
//end Trigger_AddToNewsletter trigger

//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog($tNG) {

  global $_SESSION;

  logVendor($_SESSION['kt_login_id'], $tNG->getColumnValue('id_pro'), $tNG->getColumnValue('nombre_pro') . ' ' . $tNG->getColumnValue('apellidos_pro'), '1');

}
//end addLog trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog($tNG) {

  global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

  $query_rsProp = "SELECT * FROM properties_owner WHERE id_pro = ".$_GET['id_pro'];
  $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);


  logVendor($_SESSION['kt_login_id'], $row_rsProp['id_pro'], $row_rsProp['nombre_pro'] . ' ' . $row_rsProp['apellidos_pro'], 2);

}
//end editLog trigger

//start deleteLog trigger
//remove this line if you want to edit the code by hand
function deleteLog($tNG) {

  global $_SESSION, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT * FROM properties_owner WHERE id_pro = ".$_GET['id_pro'];
  $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);

  logVendor($_SESSION['kt_login_id'], $row_rsProp['id_pro'], $row_rsProp['nombre_pro'] . ' ' . $row_rsProp['apellidos_pro'], '5');

}
//end deleteLog trigger


// Make an insert transaction instance
$ins_properties_owner = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_owner);
// Register triggers
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_owner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_owner->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
$ins_properties_owner->registerTrigger("BEFORE", "addFields", 10);
$ins_properties_owner->registerTrigger("AFTER", "addLog", 10);
// Add columns
$ins_properties_owner->setTable("properties_owner");
$ins_properties_owner->addColumn("nombre_pro", "STRING_TYPE", "POST", "nombre_pro");
$ins_properties_owner->addColumn("apellidos_pro", "STRING_TYPE", "POST", "apellidos_pro");
$ins_properties_owner->addColumn("direccion_pro", "STRING_TYPE", "POST", "direccion_pro");
$ins_properties_owner->addColumn("telefono_fijo_pro", "STRING_TYPE", "POST", "telefono_fijo_pro");
$ins_properties_owner->addColumn("telefono_movil_pro", "STRING_TYPE", "POST", "telefono_movil_pro");
$ins_properties_owner->addColumn("email_pro", "STRING_TYPE", "POST", "email_pro");
$ins_properties_owner->addColumn("skype_pro", "STRING_TYPE", "POST", "skype_pro");
$ins_properties_owner->addColumn("como_nos_conocio_pro", "STRING_TYPE", "POST", "como_nos_conocio_pro");
$ins_properties_owner->addColumn("captado_por_pro", "STRING_TYPE", "POST", "captado_por_pro");
$ins_properties_owner->addColumn("fecha_alta_pro", "DATE_TYPE", "POST", "fecha_alta_pro", "{NOW}");
$ins_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$ins_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$ins_properties_owner->addColumn("keyholder_pro", "CHECKBOX_1_0_TYPE", "POST", "keyholder_pro", "0");
$ins_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$ins_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$ins_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
$ins_properties_owner->addColumn("type_pro", "STRING_TYPE", "POST", "type_pro", "1");
$ins_properties_owner->addColumn("workers_pro", "STRING_TYPE", "POST", "workers_pro");
$ins_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_owner = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_owner);
// Register triggers
$upd_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_properties_owner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_properties_owner->registerConditionalTrigger("{POST.KT_Update2} != \"\"", "END", "Trigger_Redirect", 90);
$upd_properties_owner->registerTrigger("BEFORE", "editLog", 10);
if ($actMailchimp == 1) {
    $upd_properties_owner->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
// Add columns
$upd_properties_owner->setTable("properties_owner");
$upd_properties_owner->addColumn("nombre_pro", "STRING_TYPE", "POST", "nombre_pro");
$upd_properties_owner->addColumn("apellidos_pro", "STRING_TYPE", "POST", "apellidos_pro");
$upd_properties_owner->addColumn("direccion_pro", "STRING_TYPE", "POST", "direccion_pro");
$upd_properties_owner->addColumn("telefono_fijo_pro", "STRING_TYPE", "POST", "telefono_fijo_pro");
$upd_properties_owner->addColumn("telefono_movil_pro", "STRING_TYPE", "POST", "telefono_movil_pro");
$upd_properties_owner->addColumn("email_pro", "STRING_TYPE", "POST", "email_pro");
$upd_properties_owner->addColumn("skype_pro", "STRING_TYPE", "POST", "skype_pro");
$upd_properties_owner->addColumn("como_nos_conocio_pro", "STRING_TYPE", "POST", "como_nos_conocio_pro");
$upd_properties_owner->addColumn("captado_por_pro", "STRING_TYPE", "POST", "captado_por_pro");
$upd_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$upd_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$upd_properties_owner->addColumn("keyholder_pro", "CHECKBOX_1_0_TYPE", "POST", "keyholder_pro");
$upd_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$upd_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$upd_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
$upd_properties_owner->addColumn("type_pro", "STRING_TYPE", "POST", "type_pro");
$upd_properties_owner->addColumn("workers_pro", "STRING_TYPE", "POST", "workers_pro");
$upd_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE", "GET", "id_pro");

// Make an instance of the transaction object
$del_properties_owner = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_owner);
// Register triggers
$del_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_owner->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
// Add columns
$del_properties_owner->setTable("properties_owner");
$del_properties_owner->setPrimaryKey("id_pro", "NUMERIC_TYPE", "GET", "id_pro");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_owner = $tNGs->getRecordset("properties_owner");
$row_rsproperties_owner = mysqli_fetch_assoc($rsproperties_owner);
$totalRows_rsproperties_owner = mysqli_num_rows($rsproperties_owner);
?>


      <div class="row bg-light">

        <div class="col-md-4">

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "type_pro") != '') { ?>has-error<?php } ?>">
              <label for="type_pro" class="form-label"><?php __('Tipo'); ?>:</label>
              <select name="type_pro" id="type_pro" class="form-select">
                  <option value="1"<?php if (isset($row_rsproperties_owner['type_pro']) && !(strcmp(1, $row_rsproperties_owner['type_pro']))) {echo "SELECTED";} ?>><?php __('Particular'); ?></option>
                  <option value="2"<?php if (isset($row_rsproperties_owner['type_pro']) && !(strcmp(2, $row_rsproperties_owner['type_pro']))) {echo "SELECTED";} ?>><?php __('Constructor'); ?></option>
                  <option value="3"<?php if (isset($row_rsproperties_owner['type_pro']) && !(strcmp(3, $row_rsproperties_owner['type_pro']))) {echo "SELECTED";} ?>><?php __('Banco'); ?></option>
              </select>
              <?php echo $tNGs->displayFieldError("properties_owner", "type_pro"); ?>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nombre_pro") != '') { ?>error<?php } ?>">
              <label for="nombre_pro" class="form-label" id="nameprom"><?php __('Nombre'); ?>:</label>
              <input type="text" name="nombre_pro" id="nombre_pro" value="<?php if(isset($row_rsproperties_owner['nombre_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['nombre_pro']); ?>" size="32" maxlength="255" class="form-control required">
              <?php echo $tNGs->displayFieldError("properties_owner", "nombre_pro"); ?>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "apellidos_pro") != '') { ?>error<?php } ?>" id="surnameprom">
              <label for="apellidos_pro" class="form-label"><?php __('Apellidos'); ?>:</label>
              <input type="text" name="apellidos_pro" id="apellidos_pro" value="<?php if(isset($row_rsproperties_owner['apellidos_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['apellidos_pro']); ?>" size="32" maxlength="255" class="form-control">
              <?php echo $tNGs->displayFieldError("properties_owner", "apellidos_pro"); ?>
          </div>

          <div id="workers">
              <div class="input_fields_wrap">
                  <label><?php __('Persona de Contacto'); ?></label>
                  <?php
                  $workers = array();
                  if(isset($row_rsproperties_owner['workers_pro'])) 
                    $workers = explode('@@@@@@', $row_rsproperties_owner['workers_pro']);

                  ?>
                  <?php if(isset($workers[0]) && $workers[0] != '') { ?>
                      <?php foreach ($workers as $worker) { ?>
                      <div class="mb-4">
                          <textarea name="worker[]" rows="4" class="form-control"><?php echo $worker; ?></textarea>
                          <a href="#" class="remove_field btn btn-danger btn-xs">Eliminar</a>
                      </div>
                      <?php } ?>
                  <?php } ?>
              </div>
              <button class="add_field_button btn btn-primary btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir Persona de Contacto'); ?></button><br><br>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "telefono_fijo_pro") != '') { ?>error<?php } ?>">
            <label for="telefono_fijo_pro" class="form-label"><?php __('Teléfono'); ?>:</label>
            <div class="controls">
                <input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" value="<?php if(isset($row_rsproperties_owner['telefono_fijo_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['telefono_fijo_pro']); ?>" size="32" maxlength="255" class="form-control">
                <?php echo $tNGs->displayFieldError("properties_owner", "telefono_fijo_pro"); ?>
            </div>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "telefono_movil_pro") != '') { ?>error<?php } ?>">
            <label for="telefono_movil_pro" class="form-label"><?php __('Móvil'); ?>:</label>
            <div class="controls">
                <input type="text" name="telefono_movil_pro" id="telefono_movil_pro" value="<?php if(isset($row_rsproperties_owner['telefono_movil_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['telefono_movil_pro']); ?>" size="32" maxlength="255" class="form-control">
                <?php echo $tNGs->displayFieldError("properties_owner", "telefono_movil_pro"); ?>
            </div>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nie_pro") != '') { ?>error<?php } ?>">
            <label for="nie_pro" class="form-label"><?php __('NIE'); ?>:</label>
            <div class="controls">
                <input type="text" name="nie_pro" id="nie_pro" value="<?php if(isset($row_rsproperties_owner['nie_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['nie_pro']); ?>" size="32" maxlength="255" class="form-control">
                <?php echo $tNGs->displayFieldError("properties_owner", "nie_pro"); ?>
            </div>
          </div>

        </div>

        <div class="col-md-4">

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "status_pro") != '') { ?>error<?php } ?>">
              <label for="status_pro" class="form-label"><?php __('Estatus'); ?>:</label>
              <div class="controls">
                  <select name="status_pro" id="status_pro" class="form-select chosen">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php
                      do {
                      ?>
                      <option value="<?php echo $row_rsStatus ['id_sts']?>"<?php if (isset($row_rsproperties_owner['status_pro']) && !(strcmp($row_rsStatus ['id_sts'], $row_rsproperties_owner['status_pro']))) {echo "SELECTED";} ?>><?php echo $row_rsStatus ['category_'.$lang_adm.'_sts']?></option>
                      <?php
                      } while ($row_rsStatus  = mysqli_fetch_assoc($rsStatus ));
                        $rows = mysqli_num_rows($rsStatus );
                        if($rows > 0) {
                            mysqli_data_seek($rsStatus , 0);
                          $row_rsStatus  = mysqli_fetch_assoc($rsStatus );
                        }
                      ?>
                  </select>
                  <?php echo $tNGs->displayFieldError("properties_owner", "status_pro"); ?>
              </div>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "pasaporte_pro") != '') { ?>error<?php } ?>">
            <label for="pasaporte_pro" class="form-label"><?php __('Pasaporte'); ?>:</label>
            <div class="controls">
                <input type="text" name="pasaporte_pro" id="pasaporte_pro" value="<?php if(isset($row_rsproperties_owner['pasaporte_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['pasaporte_pro']); ?>" size="32" maxlength="255" class="form-control">
                <?php echo $tNGs->displayFieldError("properties_owner", "pasaporte_pro"); ?>
            </div>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "email_pro") != '') { ?>error<?php } ?>">
            <label for="email_pro" class="form-label"><?php __('Email'); ?>:</label>
            <div class="controls">
                <input type="text" name="email_pro" id="email_pro" value="<?php if(isset($row_rsproperties_owner['email_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['email_pro']); ?>" size="32" maxlength="255" class="form-control">
                <?php echo $tNGs->displayFieldError("properties_owner", "email_pro"); ?>
            </div>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "skype_pro") != '') { ?>error<?php } ?>">
            <label for="skype_pro" class="form-label"><?php __('Skype'); ?>:</label>
            <div class="controls">
                <input type="text" name="skype_pro" id="skype_pro" value="<?php if(isset($row_rsproperties_owner['skype_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['skype_pro']); ?>" size="32" maxlength="255" class="form-control">
                <?php echo $tNGs->displayFieldError("properties_owner", "skype_pro"); ?>
            </div>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "direccion_pro") != '') { ?>error<?php } ?>">
            <label for="direccion_pro" class="form-label"><?php __('Dirección'); ?>:</label>
            <div class="controls">
                <input type="text" name="direccion_pro" id="direccion_pro" value="<?php if(isset($row_rsproperties_owner['direccion_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['direccion_pro']); ?>" size="32" maxlength="255" class="form-control">
                <?php echo $tNGs->displayFieldError("properties_owner", "direccion_pro"); ?>
            </div>
          </div>

        </div>

        <div class="col-md-4">

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro") != '') { ?>has-error<?php } ?>">
              <label for="como_nos_conocio_pro" class="form-label"><?php __('Cómo nos conoció'); ?>:</label>
              <div class="controls">
                  <select name="como_nos_conocio_pro" id="como_nos_conocio_pro" class="form-select">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php
                      
                      $query_rsSources = "SELECT * FROM properties_owner_sources ORDER BY category_".$lang_adm."_sts ASC";
                      $rsSources = mysqli_query($inmoconn, $query_rsSources) or die(mysqli_error());
                      $row_rsSources = mysqli_fetch_assoc($rsSources);
                      $totalRows_rsSources = mysqli_num_rows($rsSources);
                      do { ?>
                      <option value="<?php echo $row_rsSources['id_sts']?>"<?php if (isset($row_rsproperties_owner['como_nos_conocio_pro']) && !(strcmp($row_rsSources['id_sts'], $row_rsproperties_owner['como_nos_conocio_pro']))) {echo "SELECTED";} ?>><?php echo $row_rsSources['category_'.$lang_adm.'_sts']?></option>
                      <?php } while ($row_rsSources = mysqli_fetch_assoc($rsSources));
                        $rows = mysqli_num_rows($rsSources);
                        if($rows > 0) {
                            mysqli_data_seek($rsSources, 0);
                          $row_rsSources = mysqli_fetch_assoc($rsSources);
                        } ?>
                  </select>
                  <?php echo $tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro"); ?>
              </div>
          </div>

          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "captado_por_pro") != '') { ?>has-error<?php } ?>">
          <label for="captado_por_pro" class="form-label"><?php __('Captado por'); ?>:</label>
              <select name="captado_por_pro" id="captado_por_pro" class="form-select">
                  <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                  <?php
                  
                  $query_rsCaptado = "SELECT * FROM properties_owner_captado ORDER BY category_".$lang_adm."_cap ASC";
                  $rsCaptado = mysqli_query($inmoconn, $query_rsCaptado) or die(mysqli_error());
                  $row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
                  $totalRows_rsCaptado = mysqli_num_rows($rsCaptado);
                  do { ?>
                  <option value="<?php echo $row_rsCaptado ['id_cap']?>"<?php if (isset($row_rsproperties_owner['captado_por_pro']) && !(strcmp($row_rsCaptado ['id_cap'], $row_rsproperties_owner['captado_por_pro']))) {echo "SELECTED";} ?>><?php echo $row_rsCaptado ['category_'.$lang_adm.'_cap']?></option>
                  <?php } while ($row_rsCaptado  = mysqli_fetch_assoc($rsCaptado ));
                    $rows = mysqli_num_rows($rsCaptado );
                    if($rows > 0) {
                        mysqli_data_seek($rsCaptado , 0);
                      $row_rsCaptado  = mysqli_fetch_assoc($rsCaptado );
                    } ?>
              </select>
              <?php echo $tNGs->displayFieldError("properties_owner", "captado_por_pro"); ?>
          </div>

            <div class="card">
              <div class="card-body bg-soft-primary">
                  <div class="row">
                    <div class="col-md-12">

                      <div class="form-check form-switch form-switch-md" dir="ltr">
                          <input type="checkbox" name="keyholder_pro" id="keyholder_pro" value="1" class="form-check-input" <?php if (isset($row_rsproperties_owner['keyholder_pro']) && !(strcmp(KT_escapeAttribute($row_rsproperties_owner['keyholder_pro']),"1"))) {echo "checked";} ?>>
                          <label class="form-check-label" for="keyholder_pro"><?php __('Solicitar llave'); ?></label>
                          <?php echo $tNGs->displayFieldError("properties_owner", "keyholder_pro"); ?>
                      </div>

                        <div id="keytxt">

                          <div class="mb-4 mt-3 <?php if($tNGs->displayFieldError("properties_owner", "keyholder_name_pro") != '') { ?>error<?php } ?>">
                              <label for="keyholder_name_pro" class="form-label"><?php __('Nombre'); ?>:</label>
                              <div class="controls">
                                  <input type="text" name="keyholder_name_pro" id="keyholder_name_pro" value="<?php if(isset($row_rsproperties_owner['keyholder_name_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['keyholder_name_pro']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_owner", "keyholder_name_pro"); ?>
                              </div>
                          </div>

                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "keyholder_tel_pro") != '') { ?>error<?php } ?>">
                              <label for="keyholder_tel_pro" class="form-label"><?php __('Teléfono'); ?>:</label>
                              <div class="controls">
                                  <input type="text" name="keyholder_tel_pro" id="keyholder_tel_pro" value="<?php if(isset($row_rsproperties_owner['keyholder_tel_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['keyholder_tel_pro']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_owner", "keyholder_tel_pro"); ?>
                              </div>
                          </div>

                        </div>

                    </div>
                </div>
              </div>
            </div>

        </div>

      </div>

<script>
  var elems = Array.prototype.slice.call(document.querySelectorAll('.onoffbtn'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html, { size: 'small' });
    });
</script>


</body>
</html>
