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

$query_rsSales = "SELECT * FROM properties_status ORDER BY slug_sta ASC";
$rsSales = mysqli_query($inmoconn,$query_rsSales) or die(mysqli_error());
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);

// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("status_".$value."_sta", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("properties_properties");
  $tblFldObj->setFieldName("operacion_prop");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay inmuebles que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache(&$tNG) {
    return array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
}
//end removeCache trigger

// Make an insert transaction instance
$ins_properties_status = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_status);
// Register triggers
$ins_properties_status->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_status->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_status->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_status->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$ins_properties_status->setTable("properties_status");
$ins_properties_status->addColumn("slug_sta", "STRING_TYPE", "POST", "slug_sta");
foreach($languages as $value) {
$ins_properties_status->addColumn("status_".$value."_sta", "STRING_TYPE", "POST", "status_".$value."_sta");
}
$ins_properties_status->setPrimaryKey("id_sta", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_status = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_status);
// Register triggers
$upd_properties_status->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_status->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_status->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_properties_status->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$upd_properties_status->setTable("properties_status");
$upd_properties_status->addColumn("slug_sta", "STRING_TYPE", "POST", "slug_sta");
foreach($languages as $value) {
  $upd_properties_status->addColumn("status_".$value."_sta", "STRING_TYPE", "POST", "status_".$value."_sta");
}
$upd_properties_status->setPrimaryKey("id_sta", "NUMERIC_TYPE", "GET", "id_sta");

// Make an instance of the transaction object
$del_properties_status = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_status);
// Register triggers
$del_properties_status->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_status->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_status->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_status->registerTrigger("AFTER", "removeCache", 10);
// $del_properties_status->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
// Add columns
$del_properties_status->setTable("properties_status");
$del_properties_status->setPrimaryKey("id_sta", "NUMERIC_TYPE", "GET", "id_sta");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_status = $tNGs->getRecordset("properties_status");
$row_rsproperties_status = mysqli_fetch_assoc($rsproperties_status);
$totalRows_rsproperties_status = mysqli_num_rows($rsproperties_status);


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_status" class="id_field" value="<?php if(isset($row_rsproperties_status['kt_pk_properties_status'])) echo KT_escapeAttribute($row_rsproperties_status['kt_pk_properties_status']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-money-bill"></i> <?php if (@$_GET['id_sta'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Operación'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_sta'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Operaciones'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>

                                        <div class="mb-4">
                                            <label for="status_<?php echo $value; ?>_sta" class="form-label required"><?php __('Operación'); ?>:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" height="15"></span>
                                                    <input type="text" class="form-control required" name="status_<?php echo $value; ?>_sta"" id="status_<?php echo $value; ?>_sta"" value="<?php echo KT_escapeAttribute($row_rsproperties_status['status_'.$value.'_sta']); ?>" required>
                                                <?php echo $tNGs->displayFieldError("custom", "alt_".$value."_img"); ?>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_staes", "status_".$value."_sta"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end mb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="status_"
                                                            data-fields-suf="_sta"
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

                                <hr>

                                <div class="form-group <?php if($tNGs->displayFieldError("properties_status", "slug_sta") != '') { ?>has-error<?php } ?>">
                                    <label for="slug_sta" class="form-label"><?php __('Operación'); ?>:</label>
                                    <select name="slug_sta" id="slug_sta" class="select2 required" required>
                                        <option value="" <?php if (isset($row_rsproperties_status['slug_sta']) && !(strcmp("", $row_rsproperties_status['slug_sta']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                        <option value="sale"<?php if (isset($row_rsproperties_status['slug_sta']) && !(strcmp('sale', $row_rsproperties_status['slug_sta']))) {echo "selected=\"selected\"";} ?>>sale - <?php __('sale'); ?></option>
                                        <option value="new_build"<?php if (isset($row_rsproperties_status['slug_sta']) && !(strcmp('new_build', $row_rsproperties_status['slug_sta']))) {echo "selected=\"selected\"";} ?>>new_build - <?php __('new_build'); ?></option>
                                        <option value="week"<?php if (isset($row_rsproperties_status['slug_sta']) && !(strcmp('week', $row_rsproperties_status['slug_sta']))) {echo "selected=\"selected\"";} ?>>week - <?php __('week'); ?></option>
                                        <option value="month"<?php if (isset($row_rsproperties_status['slug_sta']) && !(strcmp('month', $row_rsproperties_status['slug_sta']))) {echo "selected=\"selected\"";} ?>>month - <?php __('month'); ?></option>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("slug_sta", "slug_sta"); ?>
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
