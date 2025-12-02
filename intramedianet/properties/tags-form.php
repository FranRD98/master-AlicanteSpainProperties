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

  $theValue = mysqli_real_escape_string($inmoconn,$theValue);

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
foreach($languages as $value) {
$formValidation->addField("tag_".$value."_tag", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_property_tag");
  $tblDelObj->setFieldName("tag");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail trigger

// Make an insert transaction instance
$ins_properties_tags = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_tags);
// Register triggers
$ins_properties_tags->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_tags->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_tags->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_properties_tags->setTable("properties_tags");
$ins_properties_tags->addColumn("color_tag", "STRING_TYPE", "POST", "color_tag", "#000000");
$ins_properties_tags->addColumn("text_color_tag", "STRING_TYPE", "POST", "text_color_tag", "#ffffff");
foreach($languages as $value) {
$ins_properties_tags->addColumn("tag_".$value."_tag", "STRING_TYPE", "POST", "tag_".$value."_tag");
}
// $ins_properties_tags->addColumn("first_tag", "CHECKBOX_1_0_TYPE", "POST", "first_tag", "0");
$ins_properties_tags->setPrimaryKey("id_tag", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_tags = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_tags);
// Register triggers
$upd_properties_tags->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_tags->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_tags->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_properties_tags->setTable("properties_tags");
$upd_properties_tags->addColumn("color_tag", "STRING_TYPE", "POST", "color_tag");
$upd_properties_tags->addColumn("text_color_tag", "STRING_TYPE", "POST", "text_color_tag");
foreach($languages as $value) {
  $upd_properties_tags->addColumn("tag_".$value."_tag", "STRING_TYPE", "POST", "tag_".$value."_tag");
}
// $upd_properties_tags->addColumn("first_tag", "CHECKBOX_1_0_TYPE", "POST", "first_tag");
$upd_properties_tags->setPrimaryKey("id_tag", "NUMERIC_TYPE", "GET", "id_tag");

// Make an instance of the transaction object
$del_properties_tags = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_tags);
// Register triggers
$del_properties_tags->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_tags->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_tags->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_tags->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
// Add columns
$del_properties_tags->setTable("properties_tags");
$del_properties_tags->setPrimaryKey("id_tag", "NUMERIC_TYPE", "GET", "id_tag");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_tags = $tNGs->getRecordset("properties_tags");
$row_rsproperties_tags = mysqli_fetch_assoc($rsproperties_tags);
$totalRows_rsproperties_tags = mysqli_num_rows($rsproperties_tags);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_tags" class="id_field" value="<?php if(isset($row_rsproperties_tags['kt_pk_properties_tags'])) echo KT_escapeAttribute($row_rsproperties_tags['kt_pk_properties_tags']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-tags"></i> <?php if (@$_GET['id_tag'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Etiquetas'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_tag'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Etiquetas'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>

                                        <div class="mb-4">
                                            <label for="tag_<?php echo $value; ?>_tag" class="form-label required"><?php __('Etiqueta'); ?>:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" height="15"></span>
                                                <input type="text" class="form-control required" name="tag_<?php echo $value; ?>_tag"" id="tag_<?php echo $value; ?>_tag"" value="<?php echo KT_escapeAttribute($row_rsproperties_tags['tag_'.$value.'_tag']); ?>" required>
                                                <?php echo $tNGs->displayFieldError("custom", "alt_".$value."_img"); ?>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_tags", "tag_".$value."_tag"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end mb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="tag_"
                                                            data-fields-suf="_tag"
                                                            data-tab="category"
                                                        ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                                <br>
                                            <?php endif ?>
                                        </div>

                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <!-- Color Picker -->

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_tags", "color_tag") != '') { ?>has-error<?php } ?>">
                                            <label for="color_tag" class="form-label"><?php __('Fondo'); ?>:</label>
                                            <input type="color" name="color_tag" id="color_tag" value="<?php echo KT_escapeAttribute($row_rsproperties_tags['color_tag']); ?>" size="32" maxlength="255" class="form-control form-control-color w-100 required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                          <?php echo $tNGs->displayFieldError("properties_tags", "color_tag"); ?>
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_tags", "text_color_tag") != '') { ?>has-error<?php } ?>">
                                            <label for="text_color_tag" class="form-label"><?php __('Texto'); ?>:</label>
                                            <input type="color" name="text_color_tag" id="text_color_tag" value="<?php echo KT_escapeAttribute($row_rsproperties_tags['text_color_tag']); ?>" size="32" maxlength="255" class="form-control form-control-color w-100 required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                          <?php echo $tNGs->displayFieldError("properties_tags", "text_color_tag"); ?>
                                        </div>

                                    </div>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
