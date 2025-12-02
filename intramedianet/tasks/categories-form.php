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

if(isset($rsMenu))
    $totalRows_rsMenu = mysqli_num_rows($rsMenu);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("categorias_es_cat", true, "text", "", "", "", "");
$formValidation->addField("categorias_en_cat", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("tasks");
  $tblFldObj->setFieldName("status_tsk");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay tareas que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

// Make an insert transaction instance
$ins_tasks_categories = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_tasks_categories);
// Register triggers
$ins_tasks_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_tasks_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_tasks_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_tasks_categories->setTable("tasks_categories");
$ins_tasks_categories->addColumn("categorias_es_cat", "STRING_TYPE", "POST", "categorias_es_cat");
$ins_tasks_categories->addColumn("categorias_en_cat", "STRING_TYPE", "POST", "categorias_en_cat");
$ins_tasks_categories->setPrimaryKey("id_cat", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_tasks_categories = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_tasks_categories);
// Register triggers
$upd_tasks_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_tasks_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_tasks_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_tasks_categories->setTable("tasks_categories");
$upd_tasks_categories->addColumn("categorias_es_cat", "STRING_TYPE", "POST", "categorias_es_cat");
$upd_tasks_categories->addColumn("categorias_en_cat", "STRING_TYPE", "POST", "categorias_en_cat");
$upd_tasks_categories->setPrimaryKey("id_cat", "NUMERIC_TYPE", "GET", "id_cat");

// Make an instance of the transaction object
$del_tasks_categories = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_tasks_categories);
// Register triggers
$del_tasks_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_tasks_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_tasks_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_tasks_categories->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
// Add columns
$del_tasks_categories->setTable("tasks_categories");
$del_tasks_categories->setPrimaryKey("id_cat", "NUMERIC_TYPE", "GET", "id_cat");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstasks_categories = $tNGs->getRecordset("tasks_categories");
$row_rstasks_categories = mysqli_fetch_assoc($rstasks_categories);
$totalRows_rstasks_categories = mysqli_num_rows($rstasks_categories);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_tasks_categories" class="id_field" value="<?php if(isset($row_rstasks_categories['kt_pk_tasks_categories'])) echo KT_escapeAttribute($row_rstasks_categories['kt_pk_tasks_categories']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-list"></i> <?php echo __('Estado'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_cat'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Estado'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="mb-4 <?php if($tNGs->displayFieldError("tasks_categories", "categorias_en_cat") != '') { ?>has-error<?php } ?>">
                                    <label for="categorias_en_cat" class="form-label required"><?php __('Estado'); ?>:</label>
                                    <div class="input-group">
                                      <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                                      <input type="text" name="categorias_en_cat" id="categorias_en_cat" value="<?php echo KT_escapeAttribute($row_rstasks_categories['categorias_en_cat']); ?>" size="32" maxlength="255" class="form-control required" required>
                                      <div class="invalid-feedback">
                                          <?php __('Este campo es obligatorio.'); ?>
                                      </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("tasks_categories", "categorias_en_cat"); ?>
                                </div>


                                <div class="form-group <?php if($tNGs->displayFieldError("tasks_categories", "categorias_es_cat") != '') { ?>has-error<?php } ?>">
                                    <label for="categorias_es_cat" class="form-label required"><?php __('Estado'); ?>:</label>
                                    <div class="input-group">
                                      <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                                      <input type="text" name="categorias_es_cat" id="categorias_es_cat" value="<?php echo KT_escapeAttribute($row_rstasks_categories['categorias_es_cat']); ?>" size="32" maxlength="255" class="form-control required" required>
                                      <div class="invalid-feedback">
                                          <?php __('Este campo es obligatorio.'); ?>
                                      </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("tasks_categories", "categorias_es_cat"); ?>
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
