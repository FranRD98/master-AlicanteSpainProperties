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

  mysqli_real_escape_string($inmoconn, $theValue);

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
$formValidation->addField("apellidos_pro", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

$query_rsFiles = "SELECT * FROM properties_owner_files WHERE owner_fil = '".$ownerId."' ";
$rsFiles = mysqli_query($inmoconn,$query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);

$query_rsStatus = "SELECT * FROM properties_owner_states ORDER BY category_".$lang_adm."_sts ASC";
$rsStatus = mysqli_query($inmoconn,$query_rsStatus) or die(mysqli_error());
$row_rsStatus = mysqli_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysqli_num_rows($rsStatus);

$query_rsCaptado = "SELECT * FROM properties_owner_captado ORDER BY category_".$lang_adm."_cap ASC";
$rsCaptado = mysqli_query($inmoconn,$query_rsCaptado) or die(mysqli_error());
$row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
$totalRows_rsCaptado = mysqli_num_rows($rsCaptado);


$query_rsSources = "SELECT * FROM properties_owner_sources ORDER BY category_".$lang_adm."_sts ASC";
$rsSources = mysqli_query($inmoconn,$query_rsSources) or die(mysqli_error());
$row_rsSources = mysqli_fetch_assoc($rsSources);
$totalRows_rsSources = mysqli_num_rows($rsSources);


$query_rsNationalities = "SELECT id_ncld, nacionalidad_".$lang_adm."_ncld FROM nacionalidades ORDER BY nacionalidad_".$lang_adm."_ncld";
$rsNationalities = mysqli_query($inmoconn,$query_rsNationalities) or die(mysqli_error());
$row_rsNationalities = mysqli_fetch_assoc($rsNationalities);
$totalRows_rsNationalities = mysqli_num_rows($rsNationalities);

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect(&$tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("owners-form.php?id_pro=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_owner_files");
  $tblDelObj->setFieldName("owner_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/owners/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

// Make an insert transaction instance
$ins_properties_owner = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_owner);
// Register triggers
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_owner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_owner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_owner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_owner->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
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
$ins_properties_owner->addColumn("fecha_alta_pro", "DATE_TYPE", "POST", "fecha_alta_pro");
$ins_properties_owner->addColumn("historial_pro", "STRING_TYPE", "POST", "historial_pro");
$ins_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$ins_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$ins_properties_owner->addColumn("keyholder_pro", "CHECKBOX_1_0_TYPE", "POST", "keyholder_pro", "0");
$ins_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$ins_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$ins_properties_owner->addColumn("residencia_fiscal_pro", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_pro", "0");
$ins_properties_owner->addColumn("reporte_prop", "CHECKBOX_1_0_TYPE", "POST", "reporte_prop", "1");
$ins_properties_owner->addColumn("nacionalidad_pro", "STRING_TYPE", "POST", "nacionalidad_pro");
$ins_properties_owner->addColumn("notas_pro", "STRING_TYPE", "POST", "notas_pro");
$ins_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
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
$upd_properties_owner->addColumn("fecha_alta_pro", "DATE_TYPE", "POST", "fecha_alta_pro");
$upd_properties_owner->addColumn("historial_pro", "STRING_TYPE", "POST", "historial_pro");
$upd_properties_owner->addColumn("nie_pro", "STRING_TYPE", "POST", "nie_pro");
$upd_properties_owner->addColumn("pasaporte_pro", "STRING_TYPE", "POST", "pasaporte_pro");
$upd_properties_owner->addColumn("keyholder_pro", "CHECKBOX_1_0_TYPE", "POST", "keyholder_pro");
$upd_properties_owner->addColumn("keyholder_name_pro", "STRING_TYPE", "POST", "keyholder_name_pro");
$upd_properties_owner->addColumn("keyholder_tel_pro", "STRING_TYPE", "POST", "keyholder_tel_pro");
$upd_properties_owner->addColumn("residencia_fiscal_pro", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_pro");
$upd_properties_owner->addColumn("reporte_prop", "CHECKBOX_1_0_TYPE", "POST", "reporte_prop");
$upd_properties_owner->addColumn("nacionalidad_pro", "STRING_TYPE", "POST", "nacionalidad_pro");
$upd_properties_owner->addColumn("notas_pro", "STRING_TYPE", "POST", "notas_pro");
$upd_properties_owner->addColumn("status_pro", "STRING_TYPE", "POST", "status_pro");
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
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1 d-none d-md-block"><i class="fa-regular fa-magnifying-glass"></i> <?php echo __('Búsqueda avanzada'); ?>: <?php __('Propietarios'); ?></h4>
                    <div class="flex-shrink-0">
                        <?php if ($_SESSION['kt_login_level'] == 9): ?>
                        <a href="#" class="btn btn-primary btn-sm me-2 downoutlook d-none d-md-inline-block"><i class="fa-regular fa-file-csv me-1"></i> <?php __('Descargar para Outlook'); ?> </a>
                        <a href="#" class="btn btn-primary btn-sm downcsv"><i class="fa-regular fa-file-excel me-1"></i> <?php __('Descargar para Excel'); ?> </a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">

                    <?php echo $tNGs->getErrorMsg(); ?>

                    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="mb-4">
                                        <label for="type_pro" class="form-label"><?php __('Tipo'); ?>:</label>
                                        <select name="type_pro" id="type_pro" class="form-select">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="1"><?php __('Particular'); ?></option>
                                            <option value="2"><?php __('Constructor'); ?></option>
                                            <option value="3"><?php __('Banco'); ?></option>
                                        </select>
                                        <?php echo $tNGs->displayFieldError("properties_owner", "type_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nombre_pro") != '') { ?>error<?php } ?>">
                                        <label for="nombre_pro" class="form-label"><?php __('Nombre'); ?>:</label>
                                        <input type="text" name="nombre_pro" id="nombre_pro" value="<?php if(isset($row_rsproperties_owner['nombre_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['nombre_pro']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("properties_owner", "nombre_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "apellidos_pro") != '') { ?>error<?php } ?>">
                                        <label for="apellidos_pro" class="form-label"><?php __('Apellidos'); ?>:</label>
                                        <input type="text" name="apellidos_pro" id="apellidos_pro" value="<?php if(isset($row_rsproperties_owner['apellidos_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['apellidos_pro']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("properties_owner", "apellidos_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "telefono_fijo_pro") != '') { ?>error<?php } ?>">
                                        <label for="telefono_fijo_pro" class="form-label"><?php __('Teléfono'); ?>:</label>
                                        <input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" value="<?php if(isset($row_rsproperties_owner['telefono_fijo_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['telefono_fijo_pro']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("properties_owner", "telefono_fijo_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "telefono_movil_pro") != '') { ?>error<?php } ?>">
                                        <label for="telefono_movil_pro" class="form-label"><?php __('Móvil'); ?>:</label>
                                        <input type="text" name="telefono_movil_pro" id="telefono_movil_pro" value="<?php if(isset($row_rsproperties_owner[''])) echo KT_escapeAttribute($row_rsproperties_owner['telefono_movil_pro']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("properties_owner", "telefono_movil_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nie_pro") != '') { ?>error<?php } ?>">
                                        <label for="nie_pro" class="form-label"><?php __('NIE'); ?>:</label>
                                        <input type="text" name="nie_pro" id="nie_pro" value="<?php if(isset($row_rsproperties_owner['nie_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['nie_pro']); ?>" size="32" maxlength="255" class="form-control">
                                        <?php echo $tNGs->displayFieldError("properties_owner", "nie_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nie2_pro") != '') { ?>error<?php } ?>">
                                       <label for="nie2_pro" class="form-label"><?php __('NIE'); ?> 2:</label>
                                       <input type="text" name="nie2_pro" id="nie2_pro" value="<?php if(isset($row_rsproperties_owner['nie2_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['nie2_pro']); ?>" size="32" maxlength="255" class="form-control">
                                       <?php echo $tNGs->displayFieldError("properties_owner", "nie2_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "pasaporte_pro") != '') { ?>error<?php } ?>">
                                       <label for="pasaporte_pro" class="form-label"><?php __('Pasaporte'); ?>:</label>
                                       <input type="text" name="pasaporte_pro" id="pasaporte_pro" value="<?php if(isset($row_rsproperties_owner['pasaporte_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['pasaporte_pro']); ?>" size="32" maxlength="255" class="form-control">
                                       <?php echo $tNGs->displayFieldError("properties_owner", "pasaporte_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "pasaporte2_pro") != '') { ?>error<?php } ?>">
                                      <label for="pasaporte2_pro" class="form-label"><?php __('Pasaporte'); ?> 2:</label>
                                          <input type="text" name="pasaporte2_pro" id="pasaporte2_pro" value="<?php if(isset($row_rsproperties_owner['pasaporte2_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['pasaporte2_pro']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("properties_owner", "pasaporte2_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "nacionalidad_pro") != '') { ?>has-error<?php } ?>">
                                        <label for="nacionalidad_pro" class="form-label"><?php __('Nacionalidad'); ?>:</label>
                                        <select name="nacionalidad_pro" id="nacionalidad_pro" class="form-select">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>


                                            <?php do { ?>
                                            <option value="<?php echo $row_rsNationalities['id_ncld'] ?>" <?php if ( isset($row_rsproperties_owner['nacionalidad_pro']) && !(strcmp($row_rsNationalities['id_ncld'], $row_rsproperties_owner['nacionalidad_pro']))) {echo "SELECTED";} ?>><?php echo $row_rsNationalities['nacionalidad_'.$lang_adm.'_ncld'] ?></option>
                                            <?php } while ($row_rsNationalities = mysqli_fetch_assoc($rsNationalities));
                                            $rows = mysqli_num_rows($rsNationalities );
                                            if($rows > 0) {
                                                mysqli_data_seek($rsNationalities , 0);
                                              $row_rsNationalities = mysqli_fetch_assoc($rsNationalities );
                                            } ?>
                                        </select>


                                          <?php echo $tNGs->displayFieldError("properties_owner", "nacionalidad_pro"); ?>
                                    </div>

                                    <div class="mb-4">
                                        <label for="idioma_pro" class="form-label"><?php __('Idioma'); ?>:</label>
                                        <select name="idioma_pro" id="idioma_pro" class="form-select">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php
                                            if ($lang_adm == 'es') {
                                                $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino');
                                            } else {
                                                $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese');
                                            }
                                            foreach ($languages as $value) {
                                                echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "status_pro") != '') { ?>has-error<?php } ?>">
                                        <label for="status_pro" class="form-label"><?php __('Estatus'); ?>:</label>
                                        <select name="status_pro" id="status_pro" class="select2">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php do { ?>
                                            <option value="<?php echo $row_rsStatus ['id_sts']?>"<?php if (isset($row_rsproperties_owner['status_pro']) && !(strcmp($row_rsStatus ['id_sts'], $row_rsproperties_owner['status_pro']))) {echo "SELECTED";} ?>><?php echo $row_rsStatus ['category_'.$lang_adm.'_sts']?></option>
                                            <?php } while ($row_rsStatus  = mysqli_fetch_assoc($rsStatus ));
                                              $rows = mysqli_num_rows($rsStatus );
                                              if($rows > 0) {
                                                  mysqli_data_seek($rsStatus , 0);
                                                $row_rsStatus  = mysqli_fetch_assoc($rsStatus );
                                              } ?>
                                        </select>
                                        <?php echo $tNGs->displayFieldError("properties_owner", "status_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "fecha_alta_pro") != '') { ?>error<?php } ?>">
                                      <label for="fecha_alta_pro" class="form-label"><?php __('Añadido'); ?>:</label>
                                          <input type="text" name="fecha_alta_pro" id="fecha_alta_pro" value="<?php if(isset($row_rsproperties_owner['fecha_alta_pro'])) echo KT_formatDate($row_rsproperties_owner['fecha_alta_pro']); ?>" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y">
                                          <?php echo $tNGs->displayFieldError("properties_owner", "fecha_alta_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "email_pro") != '') { ?>error<?php } ?>">
                                      <label for="email_pro" class="form-label"><?php __('Email'); ?>:</label>
                                          <input type="text" name="email_pro" id="email_pro" value="<?php if(isset($row_rsproperties_owner['email_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['email_pro']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("properties_owner", "email_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "skype_pro") != '') { ?>error<?php } ?>">
                                      <label for="skype_pro" class="form-label"><?php __('Partner Portal / Dropbox'); ?>:</label>
                                          <input type="text" name="skype_pro" id="skype_pro" value="<?php if(isset($row_rsproperties_owner['skype_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['skype_pro']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("properties_owner", "skype_pro"); ?>
                                    </div>

                                    <hr>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "direccion_pro") != '') { ?>error<?php } ?>">
                                      <label for="direccion_pro" class="form-label"><?php __('Dirección'); ?>:</label>
                                          <input type="text" name="direccion_pro" id="direccion_pro" value="<?php if(isset($row_rsproperties_owner['direccion_pro'])) echo KT_escapeAttribute($row_rsproperties_owner['direccion_pro']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("properties_owner", "direccion_pro"); ?>
                                    </div>

                                    <div class="form-check form-switch form-switch-lg pt-1" dir="ltr">
                                        <input type="checkbox" name="residencia_fiscal_pro" id="residencia_fiscal_pro" value="1" class="form-check-input" <?php if (isset($row_rsnews['residencia_fiscal_pro']) && !(strcmp(KT_escapeAttribute($row_rsnews['residencia_fiscal_pro']),"1"))) {echo "checked";} ?>>
                                        <label class="form-check-label" for="residencia_fiscal_pro"><?php __('Residencia fiscal web'); ?></label>
                                        <?php echo $tNGs->displayFieldError("news", "residencia_fiscal_pro"); ?>
                                    </div>

                                    <hr>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro") != '') { ?>error<?php } ?>">
                                      <label for="como_nos_conocio_pro" class="form-label"><?php __('Cómo nos conoció'); ?>:</label>
                                      <select name="como_nos_conocio_pro" id="como_nos_conocio_pro" class="select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php do { ?>
                                              <option value="<?php echo $row_rsSources['id_sts']?>"><?php echo $row_rsSources['category_'.$lang_adm.'_sts']?></option>
                                              <?php } while ($row_rsSources = mysqli_fetch_assoc($rsSources));
                                                $rows = mysqli_num_rows($rsSources);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsSources, 0);
                                                  $row_rsSources = mysqli_fetch_assoc($rsSources);
                                                } ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_owner", "como_nos_conocio_pro"); ?>
                                    </div>

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner", "captado_por_pro") != '') { ?>error<?php } ?>">
                                      <label for="captado_por_pro" class="form-label"><?php __('Captado por'); ?>:</label>
                                          <select name="captado_por_pro" id="captado_por_pro" class="select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php do { ?>
                                              <option value="<?php echo $row_rsCaptado ['id_cap']?>"><?php echo $row_rsCaptado ['category_'.$lang_adm.'_cap']?></option>
                                              <?php } while ($row_rsCaptado  = mysqli_fetch_assoc($rsCaptado ));
                                                $rows = mysqli_num_rows($rsCaptado );
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsCaptado , 0);
                                                  $row_rsCaptado  = mysqli_fetch_assoc($rsCaptado );
                                                } ?>
                                          </select>
                                    </div>

                                    <hr>

                                    <div class="form-check form-switch form-switch-lg pt-1 mb-3 mb-md-0" dir="ltr">
                                        <input type="checkbox" name="energia_pro" id="energia_pro" value="1" class="form-check-input" <?php if (isset($row_rsnews['energia_pro']) && !(strcmp(KT_escapeAttribute($row_rsnews['energia_pro']),"1"))) {echo "checked";} ?>>
                                        <label class="form-check-label" for="energia_pro"><?php __('Certificación energética'); ?></label>
                                        <?php echo $tNGs->displayFieldError("news", "energia_pro"); ?>
                                    </div>

                                </div>

                            </div>

                            <legend><?php __('Propietarios'); ?></legend>

                               <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                                   <thead class="table-light">
                                        <tr>
                                            <th><?php __('Nombre'); ?></th>
                                            <th><?php __('Apellidos'); ?></th>
                                            <th><?php __('Email'); ?></th>
                                            <th><?php __('Teléfono'); ?></th>
                                            <th><?php __('Móvil'); ?></th>
                                            <th><?php __('operación'); ?></th>
                                            <th><?php __('Añadido'); ?></th>
                                            <th id="actions" style="min-width: 150px !important;">
                                                <div class="row">
                                                    <div class="col-6" id="col-1">

                                                    </div>
                                                    <div class="col-6" id="col-2">

                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <input type="hidden" name="kt_pk_properties_owner" class="id_field" value="<?php if(isset($row_rsproperties_owner['kt_pk_properties_owner'])) echo KT_escapeAttribute($row_rsproperties_owner['kt_pk_properties_owner']); ?>" />

                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var numCols = 7;
    </script>

    <script src="_js/owners-search.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
