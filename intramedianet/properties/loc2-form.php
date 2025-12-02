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


$query_rsparent1 = "SELECT id_loc1, name_".$lang_adm."_loc1 as country FROM properties_loc1 WHERE id_loc1 = '".$_GET['NxT_id_loc1']."' ORDER BY name_".$lang_adm."_loc1 ASC";
$rsparent1 = mysqli_query($inmoconn, $query_rsparent1) or die(mysqli_error());
$row_rsparent1 = mysqli_fetch_assoc($rsparent1);
$totalRows_rsparent1 = mysqli_num_rows($rsparent1);


$query_rsMenu = "SELECT id_loc2, name_".$lang_adm."_loc2 as feat FROM properties_loc2 WHERE parent_loc2 IS NULL AND id_loc2 != '".$_GET['id_loc2']."' ORDER BY name_".$lang_adm."_loc2 ASC";
$rsMenu = mysqli_query($inmoconn, $query_rsMenu) or die(mysqli_error());
$row_rsMenu = mysqli_fetch_assoc($rsMenu);
$totalRows_rsMenu = mysqli_num_rows($rsMenu);

// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("name_".$value."_loc2", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("properties_loc3");
  $tblFldObj->setFieldName("loc2_loc3");
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
$ins_properties_loc2 = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_loc2);
// Register triggers
$ins_properties_loc2->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_loc2->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_loc2->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_loc2->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$ins_properties_loc2->setTable("properties_loc2");
$ins_properties_loc2->addColumn("loc1_loc2", "NUMERIC_TYPE", "GET", "NxT_id_loc1");
if($mapeo == 1) {
$ins_properties_loc2->addColumn("parent_loc2", "NUMERIC_TYPE", "POST", "parent_loc2");
}
foreach($languages as $value) {
$ins_properties_loc2->addColumn("name_".$value."_loc2", "STRING_TYPE", "POST", "name_".$value."_loc2");
}
$ins_properties_loc2->setPrimaryKey("id_loc2", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_loc2 = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_loc2);
// Register triggers
$upd_properties_loc2->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_loc2->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_loc2->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_properties_loc2->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$upd_properties_loc2->setTable("properties_loc2");
if($mapeo == 1) {
$upd_properties_loc2->addColumn("parent_loc2", "NUMERIC_TYPE", "POST", "parent_loc2");
}
foreach($languages as $value) {
  $upd_properties_loc2->addColumn("name_".$value."_loc2", "STRING_TYPE", "POST", "name_".$value."_loc2");
}
$upd_properties_loc2->setPrimaryKey("id_loc2", "NUMERIC_TYPE", "GET", "id_loc2");

// Make an instance of the transaction object
$del_properties_loc2 = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_loc2);
// Register triggers
$del_properties_loc2->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_loc2->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_loc2->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_loc2->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
$del_properties_loc2->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$del_properties_loc2->setTable("properties_loc2");
$del_properties_loc2->setPrimaryKey("id_loc2", "NUMERIC_TYPE", "GET", "id_loc2");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_loc2 = $tNGs->getRecordset("properties_loc2");
$row_rsproperties_loc2 = mysqli_fetch_assoc($rsproperties_loc2);
$totalRows_rsproperties_loc2 = mysqli_num_rows($rsproperties_loc2);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_loc2" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproperties_loc2['kt_pk_properties_loc2']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-earth-europe"></i> <?php if (@$_GET['id_loc2'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Localización'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_loc2'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Provincias'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb p-3 py-2 bg-light">
                                        <li class="breadcrumb-item"><a href="/intramedianet/properties/loc1.php"><i class="fa-regular fa-earth-europe"></i> <?php echo $row_rsparent1['country'] ?></a></li>
                                        <li class="breadcrumb-item"><a href="/intramedianet/properties/loc2.php?NxT_id_loc1=<?php echo $_GET['NxT_id_loc1'] ?>"><?php echo __('Provincias') ?></a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?php if (@$_GET['id_loc2'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php __('Provincia'); ?></li>
                                    </ol>
                                </nav>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>

                                        <div class="mb-4">
                                            <label for="name_<?php echo $value; ?>_loc2" class="form-label required"><?php __('Provincia'); ?>:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" height="15"></span>
                                                <input type="text" class="form-control required" name="name_<?php echo $value; ?>_loc2"" id="name_<?php echo $value; ?>_loc2"" value="<?php echo KT_escapeAttribute($row_rsproperties_loc2['name_'.$value.'_loc2']); ?>" required>
                                                <?php echo $tNGs->displayFieldError("custom", "alt_".$value."_img"); ?>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_loc2", "name_".$value."_loc2"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end mb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="name_"
                                                            data-fields-suf="_loc2"
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

                                <div class="<?php if($tNGs->displayFieldError("properties_loc2", "parent_loc2") != '') { ?>has-error<?php } ?>">
                                    <label for="parent_loc2" class="form-label"><?php __('Mostrar en'); ?>:</label>
                                    <select name="parent_loc2" id="parent_loc2" class="select2">
                                      <option value="" <?php if (!(strcmp('', $row_rsproperties_loc2['parent_loc2']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php do {  ?>
                                      <option value="<?php echo $row_rsMenu['id_loc2']?>"<?php if (!(strcmp($row_rsMenu['id_loc2'], $row_rsproperties_loc2['parent_loc2']))) {echo "SELECTED";} ?>><?php echo $row_rsMenu['feat']?></option>
                                      <?php
                                      } while ($row_rsMenu = mysqli_fetch_assoc($rsMenu));
                                      $rows = mysqli_num_rows($rsMenu);
                                      if($rows > 0) {
                                      mysqli_data_seek($rsMenu, 0);
                                      $row_rsMenu = mysqli_fetch_assoc($rsMenu);
                                      }
                                      ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("properties_loc2", "parent_loc2"); ?>
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
