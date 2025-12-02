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
$formValidation->addField("nacionalidad_en_ncld", true, "text", "", "", "", "");
$formValidation->addField("nacionalidad_es_ncld", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_property_plnt");
  $tblDelObj->setFieldName("tag");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail trigger

// Make an insert transaction instance
$ins_nacionalidades = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_nacionalidades);
// Register triggers
$ins_nacionalidades->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_nacionalidades->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_nacionalidades->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_nacionalidades->setTable("nacionalidades");
$ins_nacionalidades->addColumn("nacionalidad_en_ncld", "STRING_TYPE", "POST", "nacionalidad_en_ncld");
$ins_nacionalidades->addColumn("nacionalidad_es_ncld", "STRING_TYPE", "POST", "nacionalidad_es_ncld");
// $ins_nacionalidades->addColumn("first_plnt", "CHECKBOX_1_0_TYPE", "POST", "first_plnt", "0");
$ins_nacionalidades->setPrimaryKey("id_ncld", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_nacionalidades = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_nacionalidades);
// Register triggers
$upd_nacionalidades->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_nacionalidades->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_nacionalidades->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_nacionalidades->setTable("nacionalidades");
$upd_nacionalidades->addColumn("nacionalidad_en_ncld", "STRING_TYPE", "POST", "nacionalidad_en_ncld");
$upd_nacionalidades->addColumn("nacionalidad_es_ncld", "STRING_TYPE", "POST", "nacionalidad_es_ncld");
// $upd_nacionalidades->addColumn("first_plnt", "CHECKBOX_1_0_TYPE", "POST", "first_plnt");
$upd_nacionalidades->setPrimaryKey("id_ncld", "NUMERIC_TYPE", "GET", "id_ncld");

// Make an instance of the transaction object
$del_nacionalidades = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_nacionalidades);
// Register triggers
$del_nacionalidades->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_nacionalidades->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_nacionalidades->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// $del_nacionalidades->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
// Add columns
$del_nacionalidades->setTable("nacionalidades");
$del_nacionalidades->setPrimaryKey("id_ncld", "NUMERIC_TYPE", "GET", "id_ncld");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnacionalidades = $tNGs->getRecordset("nacionalidades");
$row_rsnacionalidades = mysqli_fetch_assoc($rsnacionalidades);
$totalRows_rsnacionalidades = mysqli_num_rows($rsnacionalidades);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>



    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_nacionalidades" class="id_field" value="<?php if(isset($row_rsnacionalidades['kt_pk_nacionalidades'])) echo KT_escapeAttribute($row_rsnacionalidades['kt_pk_nacionalidades']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-earth-americas"></i> <?php if (@$_GET['id_ncld'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Nacionalidad'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_ncld'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Nacionalidades'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="mb-4 <?php if($tNGs->displayFieldError("nacionalidades", "nacionalidad_en_ncld") != '') { ?>has-error<?php } ?>">
                                    <label for="nacionalidad_en_ncld" class="form-label required"><?php __('Nacionalidad'); ?>:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" height="15"></span>
                                            <input type="text" class="form-control required" name="nacionalidad_en_ncld"" id="nacionalidad_en_ncld"" value="<?php echo KT_escapeAttribute($row_rsnacionalidades['nacionalidad_en_ncld']); ?>" required>
                                        <?php echo $tNGs->displayFieldError("custom", "nacionalidad_en_ncld"); ?>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("nacionalidades", "nacionalidad_en_ncld"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("nacionalidades", "nacionalidad_es_ncld") != '') { ?>has-error<?php } ?>">
                                    <label for="nacionalidad_es_ncld" class="form-label required"><?php __('Nacionalidad'); ?>:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" height="15"></span>
                                            <input type="text" class="form-control required" name="nacionalidad_es_ncld"" id="nacionalidad_es_ncld"" value="<?php echo KT_escapeAttribute($row_rsnacionalidades['nacionalidad_es_ncld']); ?>" required>
                                        <?php echo $tNGs->displayFieldError("custom", "nacionalidad_es_ncld"); ?>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("nacionalidades", "nacionalidad_es_ncld"); ?>
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
