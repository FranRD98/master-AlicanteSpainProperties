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

$totalRows_rsMenu = 0;
if(isset($rsMenu))
    $totalRows_rsMenu = mysqli_num_rows($rsMenu);

// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("category_".$value."_ct", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("citas");
  $tblFldObj->setFieldName("categoria_ct");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay citas que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("type_ct", "NUMERIC_TYPE", "EXPRESSION", "2");
  return $tNG->getError();
}
//end addFields trigger

// Make an insert transaction instance
$ins_citas_categories = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_citas_categories);
// Register triggers
$ins_citas_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_citas_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_citas_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// $ins_citas_categories->registerTrigger("BEFORE", "addFields", 10);
// Add columns
$ins_citas_categories->setTable("citas_categories");
foreach($languages as $value) {
  $ins_citas_categories->addColumn("category_".$value."_ct", "STRING_TYPE", "POST", "category_".$value."_ct");
}
$ins_citas_categories->addColumn("color_ct", "STRING_TYPE", "POST", "color_ct", "#ddd");
$ins_citas_categories->addColumn("reporte_ct", "CHECKBOX_1_0_TYPE", "POST", "reporte_ct", "0");
$ins_citas_categories->setPrimaryKey("id_ct", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_citas_categories = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_citas_categories);
// Register triggers
$upd_citas_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_citas_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_citas_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_citas_categories->setTable("citas_categories");
foreach($languages as $value) {
  $upd_citas_categories->addColumn("category_".$value."_ct", "STRING_TYPE", "POST", "category_".$value."_ct");
}
$upd_citas_categories->addColumn("color_ct", "STRING_TYPE", "POST", "color_ct");
$upd_citas_categories->addColumn("reporte_ct", "CHECKBOX_1_0_TYPE", "POST", "reporte_ct");
$upd_citas_categories->setPrimaryKey("id_ct", "NUMERIC_TYPE", "GET", "id_ct");

// Make an instance of the transaction object
$del_citas_categories = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_citas_categories);
// Register triggers
$del_citas_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_citas_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_citas_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_citas_categories->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
// Add columns
$del_citas_categories->setTable("citas_categories");
$del_citas_categories->setPrimaryKey("id_ct", "NUMERIC_TYPE", "GET", "id_ct");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscitas_categories = $tNGs->getRecordset("citas_categories");
$row_rscitas_categories = mysqli_fetch_assoc($rscitas_categories);
$totalRows_rscitas_categories = mysqli_num_rows($rscitas_categories);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_citas_categories" class="id_field" value="<?php if(isset($row_rscitas_categories['kt_pk_citas_categories'])) echo KT_escapeAttribute($row_rscitas_categories['kt_pk_citas_categories']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-calendar-lines"></i> <a href="calendario.php"><?php echo __('Calendario'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php if (@$_GET['id_ct'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Categoría'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_ct'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Categoría'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>

                                        <div class="mb-4">
                                            <label for="category_<?php echo $value; ?>_ct" class="form-label required"><?php __('Categoría'); ?>:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" height="15"></span>
                                                    <input type="text" class="form-control required" name="category_<?php echo $value; ?>_ct"" id="category_<?php echo $value; ?>_ct"" value="<?php echo KT_escapeAttribute($row_rscitas_categories['category_'.$value.'_ct']); ?>" required>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                <?php echo $tNGs->displayFieldError("custom", "alt_".$value."_img"); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("news_categories", "category_".$value."_ct"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end mb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="category_"
                                                            data-fields-suf="_ct"
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

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group <?php if($tNGs->displayFieldError("citas_categories", "color_ct") != '') { ?>has-error<?php } ?>">
                                            <label for="color_ct"><?php __('Color'); ?>:</label>
                                            <input type="text" name="color_ct" id="color_ct" value="<?php echo KT_escapeAttribute($row_rscitas_categories['color_ct']); ?>" size="32" maxlength="255" class="form-control colorpicker required">
                                          <?php echo $tNGs->displayFieldError("citas_categories", "color_ct"); ?>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                            <input type="checkbox" name="reporte_ct" id="reporte_ct" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rscitas_categories['reporte_ct']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="reporte_ct"><?php __('Mostrar en reporte'); ?></label>
                                            <?php echo $tNGs->displayFieldError("news", "reporte_ct"); ?>
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
