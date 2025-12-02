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


$query_rsTipos = "SELECT types_".$lang_adm."_typ, id_typ FROM properties_types WHERE parent_typ IS NULL ORDER BY types_".$lang_adm."_typ";
$rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsProvincias = "SELECT name_".$lang_adm."_loc2, id_loc2 FROM properties_loc2 WHERE parent_loc2 IS NULL ORDER BY name_".$lang_adm."_loc2";
$rsProvincias = mysqli_query($inmoconn,$query_rsProvincias) or die(mysqli_error());
$row_rsProvincias = mysqli_fetch_assoc($rsProvincias);
$totalRows_rsProvincias = mysqli_num_rows($rsProvincias);


$query_rsCiudades = "SELECT name_".$lang_adm."_loc3, id_loc3 FROM properties_loc3 WHERE parent_loc3 IS NULL ORDER BY name_".$lang_adm."_loc3";
$rsCiudades = mysqli_query($inmoconn,$query_rsCiudades) or die(mysqli_error());
$row_rsCiudades = mysqli_fetch_assoc($rsCiudades);
$totalRows_rsCiudades = mysqli_num_rows($rsCiudades);


$query_rsStatus = "SELECT id_sta, status_".$lang_adm."_sta FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsStatus = mysqli_query($inmoconn,$query_rsStatus) or die(mysqli_error());
$row_rsStatus = mysqli_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysqli_num_rows($rsStatus);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("name_exp", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("uid_exp", "STRING_TYPE", "EXPRESSION", "" . uniqid() . "");
  return $tNG->getError();
}
//end addFields trigger

if (isset($_POST['type_exp'])) {
	$_POST['type_exp'] = implode(',', $_POST['type_exp']);
}
if (isset($_POST['province_exp'])) {
	$_POST['province_exp'] = implode(',', $_POST['province_exp']);
}
if (isset($_POST['town_exp'])) {
	$_POST['town_exp'] = implode(',', $_POST['town_exp']);
}
if (isset($_POST['operation_exp'])) {
	$_POST['operation_exp'] = implode(',', $_POST['operation_exp']);
}

if (isset($_POST['type_ex_exp'])) {
  $_POST['type_ex_exp'] = implode(',', $_POST['type_ex_exp']);
}
if (isset($_POST['province_ex_exp'])) {
  $_POST['province_ex_exp'] = implode(',', $_POST['province_ex_exp']);
}
if (isset($_POST['town_ex_exp'])) {
  $_POST['town_ex_exp'] = implode(',', $_POST['town_ex_exp']);
}
if (isset($_POST['operation_ex_exp'])) {
  $_POST['operation_ex_exp'] = implode(',', $_POST['operation_ex_exp']);
}
if (isset($_POST['ref_exp'])) {
  $_POST['ref_exp'] = implode(',', $_POST['ref_exp']);
}
if (isset($_POST['ref_ex_exp'])) {
  $_POST['ref_ex_exp'] = implode(',', $_POST['ref_ex_exp']);
}

// Make an insert transaction instance
$ins_xml_export = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_xml_export);
// Register triggers
$ins_xml_export->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_xml_export->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_xml_export->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_xml_export->registerTrigger("BEFORE", "addFields", 10);
// Add columns
$ins_xml_export->setTable("xml_export");
$ins_xml_export->addColumn("name_exp", "STRING_TYPE", "POST", "name_exp");
$ins_xml_export->addColumn("limit_exp", "STRING_TYPE", "POST", "limit_exp", "0");
$ins_xml_export->addColumn("type_exp", "STRING_TYPE", "POST", "type_exp");
$ins_xml_export->addColumn("type_ex_exp", "STRING_TYPE", "POST", "type_ex_exp");
$ins_xml_export->addColumn("province_exp", "STRING_TYPE", "POST", "province_exp");
$ins_xml_export->addColumn("province_ex_exp", "STRING_TYPE", "POST", "province_ex_exp");
$ins_xml_export->addColumn("town_exp", "STRING_TYPE", "POST", "town_exp");
$ins_xml_export->addColumn("town_ex_exp", "STRING_TYPE", "POST", "town_ex_exp");
$ins_xml_export->addColumn("operation_exp", "STRING_TYPE", "POST", "operation_exp");
$ins_xml_export->addColumn("operation_ex_exp", "STRING_TYPE", "POST", "operation_ex_exp");
$ins_xml_export->addColumn("beds_exp", "STRING_TYPE", "POST", "beds_exp");
$ins_xml_export->addColumn("baths_exp", "STRING_TYPE", "POST", "baths_exp");
$ins_xml_export->addColumn("price_exp", "STRING_TYPE", "POST", "price_exp");
$ins_xml_export->addColumn("ref_exp", "STRING_TYPE", "POST", "ref_exp");
$ins_xml_export->addColumn("ref_ex_exp", "STRING_TYPE", "POST", "ref_ex_exp");
$ins_xml_export->addColumn("xml_exp", "CHECKBOX_1_0_TYPE", "POST", "xml_exp", "0");
if ($actWatermark == 1) {
$ins_xml_export->addColumn("watermark_exp", "CHECKBOX_1_0_TYPE", "POST", "watermark_exp", "0");
}
if ($expKyero == 1) {
$ins_xml_export->addColumn("kyero_xml", "CHECKBOX_1_0_TYPE", "POST", "kyero_xml", "0");
}
$ins_xml_export->setPrimaryKey("id_exp", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_xml_export = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_xml_export);
// Register triggers
$upd_xml_export->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_xml_export->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_xml_export->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_xml_export->setTable("xml_export");
$upd_xml_export->addColumn("name_exp", "STRING_TYPE", "POST", "name_exp");
$upd_xml_export->addColumn("limit_exp", "STRING_TYPE", "POST", "limit_exp");
$upd_xml_export->addColumn("type_exp", "STRING_TYPE", "POST", "type_exp");
$upd_xml_export->addColumn("type_ex_exp", "STRING_TYPE", "POST", "type_ex_exp");
$upd_xml_export->addColumn("province_exp", "STRING_TYPE", "POST", "province_exp");
$upd_xml_export->addColumn("province_ex_exp", "STRING_TYPE", "POST", "province_ex_exp");
$upd_xml_export->addColumn("town_exp", "STRING_TYPE", "POST", "town_exp");
$upd_xml_export->addColumn("town_ex_exp", "STRING_TYPE", "POST", "town_ex_exp");
$upd_xml_export->addColumn("operation_exp", "STRING_TYPE", "POST", "operation_exp");
$upd_xml_export->addColumn("operation_ex_exp", "STRING_TYPE", "POST", "operation_ex_exp");
$upd_xml_export->addColumn("beds_exp", "STRING_TYPE", "POST", "beds_exp");
$upd_xml_export->addColumn("baths_exp", "STRING_TYPE", "POST", "baths_exp");
$upd_xml_export->addColumn("price_exp", "STRING_TYPE", "POST", "price_exp");
$upd_xml_export->addColumn("ref_exp", "STRING_TYPE", "POST", "ref_exp");
$upd_xml_export->addColumn("ref_ex_exp", "STRING_TYPE", "POST", "ref_ex_exp");
$upd_xml_export->addColumn("xml_exp", "CHECKBOX_1_0_TYPE", "POST", "xml_exp");
if ($actWatermark == 1) {
$upd_xml_export->addColumn("watermark_exp", "CHECKBOX_1_0_TYPE", "POST", "watermark_exp");
}
if ($expKyero == 1) {
$upd_xml_export->addColumn("kyero_xml", "CHECKBOX_1_0_TYPE", "POST", "kyero_xml");
}
$upd_xml_export->setPrimaryKey("id_exp", "NUMERIC_TYPE", "GET", "id_exp");

// Make an instance of the transaction object
$del_xml_export = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_xml_export);
// Register triggers
$del_xml_export->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_xml_export->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_xml_export->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_xml_export->setTable("xml_export");
$del_xml_export->setPrimaryKey("id_exp", "NUMERIC_TYPE", "GET", "id_exp");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsxml_export = $tNGs->getRecordset("xml_export");
$row_rsxml_export = mysqli_fetch_assoc($rsxml_export);
$totalRows_rsxml_export = mysqli_num_rows($rsxml_export);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include("../includes/inc.head.php"); ?>

    <link rel="stylesheet" href="/intramedianet/includes/assets/_custom/vendor/ion.rangeSlider/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="/intramedianet/includes/assets/_custom/vendor/ion.rangeSlider/css/ion.rangeSlider.skinNice.css">

    <style>
    .select2-container-multi .select2-choices {
        height: auto!important;
        max-height: 1000px!important;
    }
    </style>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_xml_export" class="id_field" value="<?php if(isset($row_rsxml_export['kt_pk_xml_export'])) echo KT_escapeAttribute($row_rsxml_export['kt_pk_xml_export']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-file-export"></i> <?php if (@$_GET['id_exp'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('XML'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_exp'] == "") { ?>
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
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('XML'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "name_exp") != '') { ?>has-error<?php } ?>">
                                            <label cfor="name_exp" class="form-label"><?php __('Nombre'); ?>:</label>
                                            <input type="text" name="name_exp" id="name_exp" value="<?php echo KT_escapeAttribute($row_rsxml_export['name_exp']); ?>" size="32" maxlength="255" class="form-control required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("xml_export", "name_exp"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "limit_exp") != '') { ?>has-error<?php } ?>">
                                            <label cfor="limit_exp" class="form-label"><?php __('Propiedades a mostrar'); ?>:</label>
                                            <input type="text" name="limit_exp" id="limit_exp" value="<?php echo KT_escapeAttribute($row_rsxml_export['limit_exp']); ?>" size="32" maxlength="255" class="form-control required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("xml_export", "limit_exp"); ?>
                                            <samll class="help-block d-block opacity-50 mt-1"><?php __('0 muestra todos los inmuebles'); ?></samll>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mt-3">
                                            <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                                <input type="checkbox" name="xml_exp" id="xml_exp" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsxml_export['xml_exp']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="xml_exp"><?php __('Añadir inmuebles importados'); ?></label>
                                                <?php echo $tNGs->displayFieldError("news", "xml_exp"); ?>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                                <input type="checkbox" name="kyero_xml" id="kyero_xml" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsxml_export['kyero_xml']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="kyero_xml" style="width: 90%;"><?php __('Añadir inmuebles marcados como exportar a Kyero'); ?></label>
                                                <?php echo $tNGs->displayFieldError("news", "kyero_xml"); ?>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                                <input type="checkbox" name="watermark_exp" id="watermark_exp" value="1" class="form-check-input" <?php if (isset($row_rsxml_export['watermark_exp']) && !(strcmp(KT_escapeAttribute($row_rsxml_export['watermark_exp']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="watermark_exp"><?php __('Marca de agua'); ?></label>
                                                <?php echo $tNGs->displayFieldError("news", "watermark_exp"); ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "type_exp") != '') { ?>has-error<?php } ?>">
                                          <label cfor="type_exp" class="form-label"><?php __('Incluir estos'); ?> <?php __('Tipos'); ?>:</label>
                                              <select name="type_exp[]" id="type_exp"  multiple="multiple" class="select-control select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php

                                              $typVals = explode(',', $row_rsxml_export['type_exp']);

                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsTipos['id_typ']?>"<?php if (in_array($row_rsTipos['id_typ'], $typVals)) {echo "SELECTED";} ?>><?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?></option>
                                              <?php
                                              } while ($row_rsTipos = mysqli_fetch_assoc($rsTipos));
                                                $rows = mysqli_num_rows($rsTipos);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsTipos, 0);
                                                  $row_rsTipos = mysqli_fetch_assoc($rsTipos);
                                                }
                                              ?>
                                               </select>

                                            <?php echo $tNGs->displayFieldError("xml_export", "type_exp"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                              <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "type_ex_exp") != '') { ?>has-error<?php } ?>">
                                                <label cfor="type_ex_exp" class="form-label"><?php __('Excluir estos'); ?> <?php __('Tipos'); ?>:</label>
                                                    <select name="type_ex_exp[]" id="type_ex_exp"  multiple="multiple" class="select-control select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php

                                                    $typVals = explode(',', $row_rsxml_export['type_ex_exp']);

                                                    do {
                                                    ?>
                                                    <option value="<?php echo $row_rsTipos['id_typ']?>"<?php if (in_array($row_rsTipos['id_typ'], $typVals)) {echo "SELECTED";} ?>><?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?></option>
                                                    <?php
                                                    } while ($row_rsTipos = mysqli_fetch_assoc($rsTipos));
                                                      $rows = mysqli_num_rows($rsTipos);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsTipos, 0);
                                                        $row_rsTipos = mysqli_fetch_assoc($rsTipos);
                                                      }
                                                    ?>
                                                     </select>

                                                  <?php echo $tNGs->displayFieldError("xml_export", "type_ex_exp"); ?>
                                              </div>

                                          </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "province_exp") != '') { ?>has-error<?php } ?>">
                                          <label cfor="province_exp" class="form-label"><?php __('Incluir estos'); ?> <?php __('Provincias'); ?>:</label>
                                              <select name="province_exp[]" id="province_exp"  multiple="multiple" class="select-control select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php

                                              $proVals = explode(',', $row_rsxml_export['province_exp']);

                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsProvincias['id_loc2']?>"<?php if (in_array($row_rsProvincias['id_loc2'], $proVals)) {echo "SELECTED";} ?>><?php echo $row_rsProvincias['name_'.$lang_adm.'_loc2']?></option>
                                              <?php
                                              } while ($row_rsProvincias = mysqli_fetch_assoc($rsProvincias));
                                                $rows = mysqli_num_rows($rsProvincias);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsProvincias, 0);
                                                  $row_rsProvincias = mysqli_fetch_assoc($rsProvincias);
                                                }
                                              ?>
                                               </select>

                                            <?php echo $tNGs->displayFieldError("xml_export", "province_exp"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "province_ex_exp") != '') { ?>has-error<?php } ?>">
                                          <label cfor="province_ex_exp" class="form-label"><?php __('Excluir estos'); ?> <?php __('Provincias'); ?>:</label>
                                              <select name="province_ex_exp[]" id="province_ex_exp"  multiple="multiple" class="select-control select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php

                                              $proVals = explode(',', $row_rsxml_export['province_ex_exp']);

                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsProvincias['id_loc2']?>"<?php if (in_array($row_rsProvincias['id_loc2'], $proVals)) {echo "SELECTED";} ?>><?php echo $row_rsProvincias['name_'.$lang_adm.'_loc2']?></option>
                                              <?php
                                              } while ($row_rsProvincias = mysqli_fetch_assoc($rsProvincias));
                                                $rows = mysqli_num_rows($rsProvincias);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsProvincias, 0);
                                                  $row_rsProvincias = mysqli_fetch_assoc($rsProvincias);
                                                }
                                              ?>
                                               </select>

                                            <?php echo $tNGs->displayFieldError("xml_export", "province_ex_exp"); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "town_exp") != '') { ?>has-error<?php } ?>">
                                          <label cfor="town_exp" class="form-label"><?php __('Incluir estos'); ?> <?php __('Ciudades'); ?>:</label>
                                              <select name="town_exp[]" id="town_exp"  multiple="multiple" class="select-control select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php

                                              $proVals = explode(',', $row_rsxml_export['town_exp']);

                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsCiudades['id_loc3']?>"<?php if (in_array($row_rsCiudades['id_loc3'], $proVals)) {echo "SELECTED";} ?>><?php echo $row_rsCiudades['name_'.$lang_adm.'_loc3']?></option>
                                              <?php
                                              } while ($row_rsCiudades = mysqli_fetch_assoc($rsCiudades));
                                                $rows = mysqli_num_rows($rsCiudades);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsCiudades, 0);
                                                  $row_rsCiudades = mysqli_fetch_assoc($rsCiudades);
                                                }
                                              ?>
                                               </select>

                                            <?php echo $tNGs->displayFieldError("xml_export", "name_exp"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "town_ex_exp") != '') { ?>has-error<?php } ?>">
                                          <label cfor="town_ex_exp" class="form-label"><?php __('Excluir estos'); ?> <?php __('Ciudades'); ?>:</label>
                                              <select name="town_ex_exp[]" id="town_ex_exp"  multiple="multiple" class="select-control select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php

                                              $proVals = explode(',', $row_rsxml_export['town_ex_exp']);

                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsCiudades['id_loc3']?>"<?php if (in_array($row_rsCiudades['id_loc3'], $proVals)) {echo "SELECTED";} ?>><?php echo $row_rsCiudades['name_'.$lang_adm.'_loc3']?></option>
                                              <?php
                                              } while ($row_rsCiudades = mysqli_fetch_assoc($rsCiudades));
                                                $rows = mysqli_num_rows($rsCiudades);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsCiudades, 0);
                                                  $row_rsCiudades = mysqli_fetch_assoc($rsCiudades);
                                                }
                                              ?>
                                               </select>

                                            <?php echo $tNGs->displayFieldError("xml_export", "town_ex_exp"); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "operation_exp") != '') { ?>has-error<?php } ?>">
                                          <label cfor="operation_exp" class="form-label"><?php __('Incluir estos'); ?> <?php __('Operaciones'); ?>:</label>
                                              <select name="operation_exp[]" id="operation_exp"  multiple="multiple" class="select-control select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php

                                              $proVals = explode(',', $row_rsxml_export['operation_exp']);

                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsStatus['id_sta']?>"<?php if (in_array($row_rsStatus['id_sta'], $proVals)) {echo "SELECTED";} ?>><?php echo $row_rsStatus['status_'.$lang_adm.'_sta']?></option>
                                              <?php
                                              } while ($row_rsStatus = mysqli_fetch_assoc($rsStatus));
                                                $rows = mysqli_num_rows($rsStatus);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsStatus, 0);
                                                  $row_rsStatus = mysqli_fetch_assoc($rsStatus);
                                                }
                                              ?>
                                               </select>

                                            <?php echo $tNGs->displayFieldError("xml_export", "operation_exp"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "operation_ex_exp") != '') { ?>has-error<?php } ?>">
                                          <label cfor="operation_ex_exp" class="form-label"><?php __('Excluir estos'); ?> <?php __('Operaciones'); ?>:</label>
                                              <select name="operation_ex_exp[]" id="operation_ex_exp"  multiple="multiple" class="select-control select2">
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php

                                              $proVals = explode(',', $row_rsxml_export['operation_ex_exp']);

                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsStatus['id_sta']?>"<?php if (in_array($row_rsStatus['id_sta'], $proVals)) {echo "SELECTED";} ?>><?php echo $row_rsStatus['status_'.$lang_adm.'_sta']?></option>
                                              <?php
                                              } while ($row_rsStatus = mysqli_fetch_assoc($rsStatus));
                                                $rows = mysqli_num_rows($rsStatus);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsStatus, 0);
                                                  $row_rsStatus = mysqli_fetch_assoc($rsStatus);
                                                }
                                              ?>
                                               </select>

                                            <?php echo $tNGs->displayFieldError("xml_export", "operation_ex_exp"); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "ref_exp") != '') { ?>has-error<?php } ?>">
                                            <label for="ref_exp" class="form-label"><?php __('Incluir estos'); ?> <?php __('Referencias'); ?>:</label>
                                            <input type="text" class="form-control select2references" id="ref_exp" name="ref_exp[]" value="" tabindex="-1">
                                              <?php echo $tNGs->displayFieldError("xml_export", "ref_exp"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "ref_ex_exp") != '') { ?>has-error<?php } ?>">
                                            <label for="ref_ex_exp" class="form-label"><?php __('Excluir estos'); ?> <?php __('Referencias'); ?>:</label>
                                            <input type="text" class="form-control select2references2" id="ref_ex_exp" name="ref_ex_exp[]" value="" tabindex="-1">
                                              <?php echo $tNGs->displayFieldError("xml_export", "ref_ex_exp"); ?>
                                        </div>

                                    </div>
                                </div>

                                <hr class="mb-4">

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "beds_exp") != '') { ?>has-error<?php } ?>">
                                            <label cfor="beds_exp" class="form-label"><?php __('Habitaciones'); ?>:</label>
                                              <?php
                                              $val = explode(',', $row_rsxml_export['beds_exp']); 
                                              if(!empty($val)){
                                                $vmin= (!isset($val[0]) && $val[0] == '')?0:$val[0];
                                                $vmax= (isset($val[1]) && $val[1] !== '')?$val[1]:30;
                                              }else{
                                                $vmin=0;$vmax=30;
                                              }
                                               ?>
                                                <input type="hidden" name="beds_exp" id="beds_exp" data-min="0" data-max="30" data-vmin="<?php echo $vmin; ?>" data-vmax="<?php echo $vmax; ?>" value="<?php echo ($row_rsxml_export['beds_exp'] == '')?'0,30':KT_escapeAttribute($row_rsxml_export['beds_exp']); ?>" size="32" maxlength="255">
                                                <?php echo $tNGs->displayFieldError("xml_export", "beds_exp"); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "baths_exp") != '') { ?>has-error<?php } ?>">
                                            <label cfor="baths_exp" class="form-label"><?php __('Aseos'); ?>:</label>
                                              <?php
                                              $val = explode(',', $row_rsxml_export['baths_exp']);
                                              $vmin= ($val[0] == '')?0:$val[0];
                                              $vmax= (isset($val[1]) && $val[1] !== '')?$val[1]:30;
                                               ?>
                                                <input type="hidden" name="baths_exp" id="baths_exp" data-min="0" data-max="30" data-vmin="<?php echo $vmin; ?>" data-vmax="<?php echo $vmax; ?>" value="<?php echo ($row_rsxml_export['baths_exp'] == '')?'0,30':KT_escapeAttribute($row_rsxml_export['baths_exp']); ?>" size="32" maxlength="255">
                                                <?php echo $tNGs->displayFieldError("xml_export", "baths_exp"); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("xml_export", "price_exp") != '') { ?>has-error<?php } ?>">
                                            <label cfor="price_exp" class="form-label"><?php __('Precio'); ?>:</label>
                                              <?php
                                              $val = explode(',', $row_rsxml_export['price_exp']);
                                              $vmin= ($val[0] == '')?0:$val[0];
                                              $vmax= (isset($val[1]) && $val[1] !== '')?$val[1]:1000000;
                                               ?>
                                                <input type="hidden" name="price_exp" id="price_exp" data-min="0" data-max="1000000" data-vmin="<?php echo $vmin; ?>" data-vmax="<?php echo $vmax; ?>" value="<?php echo ($row_rsxml_export['price_exp'] == '')?'0,1000000':KT_escapeAttribute($row_rsxml_export['price_exp']); ?>" size="32" maxlength="255">
                                                <?php echo $tNGs->displayFieldError("xml_export", "price_exp"); ?>
                                        </div>

                                    </div>
                                </div>

                                <br style="clear:both;">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                    <i class="fa-regular fa-info-circle label-icon"></i> <?php __('Si selecciona 1000000, tambien se enviarán los inmuebles que sobrepasen esa cantidad'); ?>.
                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </form>

  <?php include("../includes/inc.footer.php"); ?>

  <script src="/intramedianet/includes/assets/_custom/vendor/ion.rangeSlider/js/ion.rangeSlider.js"></script>

  <script type="text/javascript">

    $("#beds_exp").ionRangeSlider({
        type: "double",
        grid: true,
        min: $('#beds_exp').data('min'),
        max: $('#beds_exp').data('max')
    });

    $("#baths_exp").ionRangeSlider({
        type: "double",
        grid: true,
        min: $('#baths_exp').data('min'),
        max: $('#baths_exp').data('max')
    });

    $("#price_exp").ionRangeSlider({
        type: "double",
        grid: true,
        min: $('#price_exp').data('min'),
        max: $('#price_exp').data('max'),
        step: 1000,
        postfix: " €"
    });


    $('.select2references').select2({
        multiple:true,
        ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-references-select.php?q=' + params;
        },
        dataType: 'json',
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        // cache: true,
        },
        placeholder: '',
        minimumInputLength: 3,
    });
    $('.select2references2').select2({
        multiple:true,
        ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-references-select.php?q=' + params;
        },
        dataType: 'json',
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        // cache: true,
        },
        placeholder: '',
        minimumInputLength: 3,
    });
    <?php if ($row_rsxml_export['ref_exp'] != ''): ?>
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/intramedianet/properties/properties-references-select-multiple.php?q=<?php echo $row_rsxml_export['ref_exp'] ?>'
    }).done(function (data) {
        $(".select2references").select2('data', data);
    });
    <?php endif ?>
    <?php if ($row_rsxml_export['ref_ex_exp'] != ''): ?>
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/intramedianet/properties/properties-references-select-multiple.php?q=<?php echo $row_rsxml_export['ref_ex_exp'] ?>'
    }).done(function (data) {
        $(".select2references2").select2('data', data);
    });
    <?php endif ?>
</script>

</body>
</html>
