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
$formValidation->addField("types_en_arc", true, "text", "", "", "", "");
$formValidation->addField("types_es_arc", true, "text", "", "", "", "");
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
  $tNG->addColumn("type_arc", "NUMERIC_TYPE", "EXPRESSION", "1");
  return $tNG->getError();
}
//end addFields trigger

// Make an insert transaction instance
$ins_properties_archived = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_archived);
// Register triggers
$ins_properties_archived->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_archived->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_archived->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_properties_archived->setTable("properties_archived");
$ins_properties_archived->addColumn("types_en_arc", "STRING_TYPE", "POST", "types_en_arc");
$ins_properties_archived->addColumn("types_es_arc", "STRING_TYPE", "POST", "types_es_arc");
$ins_properties_archived->setPrimaryKey("id_arc", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_archived = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_archived);
// Register triggers
$upd_properties_archived->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_archived->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_archived->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_properties_archived->setTable("properties_archived");
$upd_properties_archived->addColumn("types_en_arc", "STRING_TYPE", "POST", "types_en_arc");
$upd_properties_archived->addColumn("types_es_arc", "STRING_TYPE", "POST", "types_es_arc");
$upd_properties_archived->setPrimaryKey("id_arc", "NUMERIC_TYPE", "GET", "id_arc");

// Make an instance of the transaction object
$del_properties_archived = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_archived);
// Register triggers
$del_properties_archived->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_archived->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_archived->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_archived->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
// Add columns
$del_properties_archived->setTable("properties_archived");
$del_properties_archived->setPrimaryKey("id_arc", "NUMERIC_TYPE", "GET", "id_arc");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_archived = $tNGs->getRecordset("properties_archived");
$row_rsproperties_archived = mysqli_fetch_assoc($rsproperties_archived);
$totalRows_rsproperties_archived = mysqli_num_rows($rsproperties_archived);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_archived" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproperties_archived['kt_pk_properties_archived']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-box-archive"></i> <?php if (@$_GET['id_arc'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Archivado en'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_arc'] == "") { ?>
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

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_collaborators_categories", "types_en_arc") != '') { ?>has-error<?php } ?>">
                                    <label for="types_en_arc" class="form-label required"><?php __('Archivado en'); ?>:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" height="15"></span>
                                        <input type="text" name="types_en_arc" id="types_en_arc" value="<?php echo KT_escapeAttribute($row_rsproperties_archived['types_en_arc']); ?>" size="32" maxlength="255" class="form-control required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("properties_collaborators_categories", "types_en_arc"); ?>
                                </div>


                                <div class="<?php if($tNGs->displayFieldError("properties_collaborators_categories", "types_es_arc") != '') { ?>has-error<?php } ?>">
                                    <label for="types_es_arc" class="form-label required"><?php __('Archivado en'); ?>:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" height="15"></span>
                                        <input type="text" name="types_es_arc" id="types_es_arc" value="<?php echo KT_escapeAttribute($row_rsproperties_archived['types_es_arc']); ?>" size="32" maxlength="255" class="form-control required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("properties_collaborators_categories", "types_es_arc"); ?>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

                    </div>
                </div>

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
