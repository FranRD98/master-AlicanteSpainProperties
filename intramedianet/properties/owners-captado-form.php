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



// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("category_en_cap", true, "text", "", "", "", "");
$formValidation->addField("category_es_cap", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("properties_client");
  $tblFldObj->setFieldName("status_cli");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay registros que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("type_cap", "NUMERIC_TYPE", "EXPRESSION", "1");
  return $tNG->getError();
}
//end addFields trigger

// Make an insert transaction instance
$ins_properties_owner_captado = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_owner_captado);
// Register triggers
$ins_properties_owner_captado->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_owner_captado->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_owner_captado->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_properties_owner_captado->setTable("properties_owner_captado");
$ins_properties_owner_captado->addColumn("category_en_cap", "STRING_TYPE", "POST", "category_en_cap");
$ins_properties_owner_captado->addColumn("category_es_cap", "STRING_TYPE", "POST", "category_es_cap");
// $ins_properties_owner_captado->addColumn("category_fr_cap", "STRING_TYPE", "POST", "category_fr_cap");
$ins_properties_owner_captado->setPrimaryKey("id_cap", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_owner_captado = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_owner_captado);
// Register triggers
$upd_properties_owner_captado->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_owner_captado->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_owner_captado->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_properties_owner_captado->setTable("properties_owner_captado");
$upd_properties_owner_captado->addColumn("category_en_cap", "STRING_TYPE", "POST", "category_en_cap");
$upd_properties_owner_captado->addColumn("category_es_cap", "STRING_TYPE", "POST", "category_es_cap");
// $upd_properties_owner_captado->addColumn("category_fr_cap", "STRING_TYPE", "POST", "category_fr_cap");
$upd_properties_owner_captado->setPrimaryKey("id_cap", "NUMERIC_TYPE", "GET", "id_cap");

// Make an instance of the transaction object
$del_properties_owner_captado = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_owner_captado);
// Register triggers
$del_properties_owner_captado->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_owner_captado->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_owner_captado->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_owner_captado->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
// Add columns
$del_properties_owner_captado->setTable("properties_owner_captado");
$del_properties_owner_captado->setPrimaryKey("id_cap", "NUMERIC_TYPE", "GET", "id_cap");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_owner_captado = $tNGs->getRecordset("properties_owner_captado");
$row_rsproperties_owner_captado = mysqli_fetch_assoc($rsproperties_owner_captado);
$totalRows_rsproperties_owner_captado = mysqli_num_rows($rsproperties_owner_captado);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_owner_captado" class="id_field" value="<?php if(isset($row_rsproperties_owner_captado['kt_pk_properties_owner_captado'])) echo KT_escapeAttribute($row_rsproperties_owner_captado['kt_pk_properties_owner_captado']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-user-tie"></i> <?php echo __('Captado por'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_cap'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Captado por'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_owner_captado", "category_en_cap") != '') { ?>has-error<?php } ?>">
                                    <label for="category_en_cap" class="form-label required"><?php __('Captado por'); ?>:</label>
                                    <div class="input-group">
                                      <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                                      <input type="text" name="category_en_cap" id="category_en_cap" value="<?php echo KT_escapeAttribute($row_rsproperties_owner_captado['category_en_cap']); ?>" size="32" maxlength="255" class="form-control required" required>
                                      <div class="invalid-feedback">
                                          <?php __('Este campo es obligatorio.'); ?>
                                      </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("properties_owner_captado", "category_en_cap"); ?>
                                </div>


                                <div class="form-group <?php if($tNGs->displayFieldError("properties_owner_captado", "category_es_cap") != '') { ?>has-error<?php } ?>">
                                    <label for="category_es_cap" class="form-label required"><?php __('Captado por'); ?>:</label>
                                    <div class="input-group">
                                      <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                                      <input type="text" name="category_es_cap" id="category_es_cap" value="<?php echo KT_escapeAttribute($row_rsproperties_owner_captado['category_es_cap']); ?>" size="32" maxlength="255" class="form-control required" required>
                                      <div class="invalid-feedback">
                                          <?php __('Este campo es obligatorio.'); ?>
                                      </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("properties_owner_captado", "category_es_cap"); ?>
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
