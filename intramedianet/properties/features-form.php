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

$row_rsMenu = array(); $totalRows_rsMenu = 0;
if(isset($_GET['id_feat'])){
    $query_rsMenu = "SELECT id_feat, feature_".$lang_adm."_feat as feat FROM properties_features WHERE parent_feat IS NULL AND id_feat != '".$_GET['id_feat']."' ORDER BY feature_".$lang_adm."_feat ASC";
    $rsMenu = mysqli_query($inmoconn,$query_rsMenu) or die(mysqli_error());
    $row_rsMenu = mysqli_fetch_assoc($rsMenu);
    $totalRows_rsMenu = mysqli_num_rows($rsMenu);
}
// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("feature_".$value."_feat", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_property_feature");
  $tblDelObj->setFieldName("feature");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail trigger

// Make an insert transaction instance
$ins_properties_features = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_features);
// Register triggers
$ins_properties_features->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_features->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_features->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_properties_features->setTable("properties_features");
if($mapeo == 1) {
$ins_properties_features->addColumn("parent_feat", "NUMERIC_TYPE", "POST", "parent_feat");
}
foreach($languages as $value) {
$ins_properties_features->addColumn("feature_".$value."_feat", "STRING_TYPE", "POST", "feature_".$value."_feat");
}
// $ins_properties_features->addColumn("first_feat", "CHECKBOX_1_0_TYPE", "POST", "first_feat", "0");
$ins_properties_features->setPrimaryKey("id_feat", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_features = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_features);
// Register triggers
$upd_properties_features->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_features->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_features->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_properties_features->setTable("properties_features");
if($mapeo == 1) {
$upd_properties_features->addColumn("parent_feat", "NUMERIC_TYPE", "POST", "parent_feat");
}
foreach($languages as $value) {
  $upd_properties_features->addColumn("feature_".$value."_feat", "STRING_TYPE", "POST", "feature_".$value."_feat");
}
// $upd_properties_features->addColumn("first_feat", "CHECKBOX_1_0_TYPE", "POST", "first_feat");
$upd_properties_features->setPrimaryKey("id_feat", "NUMERIC_TYPE", "GET", "id_feat");

// Make an instance of the transaction object
$del_properties_features = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_features);
// Register triggers
$del_properties_features->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_features->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_features->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_features->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
// Add columns
$del_properties_features->setTable("properties_features");
$del_properties_features->setPrimaryKey("id_feat", "NUMERIC_TYPE", "GET", "id_feat");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_features = $tNGs->getRecordset("properties_features");
$row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
$totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);

$mapeo = 0;

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_features" class="id_field" value="<?php if(isset($row_rsproperties_features['kt_pk_properties_features'])) echo KT_escapeAttribute($row_rsproperties_features['kt_pk_properties_features']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-list-check"></i> <?php if (@$_GET['id_feat'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Característica'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_feat'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Características privadas'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>

                                        <div class="mb-4">
                                            <label for="feature_<?php echo $value; ?>_feat" class="form-label required"><?php __('Característica'); ?>:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" height="15"></span>
                                                    <input type="text" class="form-control required" name="feature_<?php echo $value; ?>_feat"" id="feature_<?php echo $value; ?>_feat"" value="<?php echo KT_escapeAttribute($row_rsproperties_features['feature_'.$value.'_feat']); ?>" required>
                                                <?php echo $tNGs->displayFieldError("custom", "alt_".$value."_img"); ?>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_features", "feature_".$value."_feat"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end mb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="feature_"
                                                            data-fields-suf="_feat"
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

                                <?php if($mapeo == 1) { ?>

                                <hr>

                                <div class="form-group <?php if($tNGs->displayFieldError("properties_features", "parent_feat") != '') { ?>error<?php } ?>">
                                    <label for="parent_feat"><?php __('Mostrar en'); ?>:</label>
                                    <select name="parent_feat" id="parent_feat" class="select-control select2">
                                      <option value="" <?php if (!(strcmp('', $row_rsproperties_features['parent_feat']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php do {  ?>
                                      <option value="<?php echo $row_rsMenu['id_feat']?>"<?php if (!(strcmp($row_rsMenu['id_feat'], $row_rsproperties_features['parent_feat']))) {echo "SELECTED";} ?>><?php echo $row_rsMenu['feat']?></option>
                                      <?php
                                      } while ($row_rsMenu = mysqli_fetch_assoc($rsMenu));
                                      $rows = mysqli_num_rows($rsMenu);
                                      if($rows > 0) {
                                      mysqli_data_seek($rsMenu, 0);
                                      $row_rsMenu = mysqli_fetch_assoc($rsMenu);
                                      }
                                      ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("properties_features", "parent_feat"); ?>
                                </div>

                                <?php } ?>

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
