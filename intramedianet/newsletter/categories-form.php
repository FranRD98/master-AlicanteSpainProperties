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
foreach($languages as $value) {
$formValidation->addField("category_".$value."_cts", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_DeleteDetail3 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("newsletter_usr_cat");
  $tblDelObj->setFieldName("cat");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail3 trigger

// Make an insert transaction instance
$ins_newsletter_categories = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_newsletter_categories);
// Register triggers
$ins_newsletter_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_newsletter_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_newsletter_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_newsletter_categories->setTable("newsletter_categories");
foreach($languages as $value) {
$ins_newsletter_categories->addColumn("category_".$value."_cts", "STRING_TYPE", "POST", "category_".$value."_cts");
}
$ins_newsletter_categories->setPrimaryKey("id_cts", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_newsletter_categories = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_newsletter_categories);
// Register triggers
$upd_newsletter_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_newsletter_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_newsletter_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_newsletter_categories->setTable("newsletter_categories");
foreach($languages as $value) {
  $upd_newsletter_categories->addColumn("category_".$value."_cts", "STRING_TYPE", "POST", "category_".$value."_cts");
}
$upd_newsletter_categories->setPrimaryKey("id_cts", "NUMERIC_TYPE", "GET", "id_cts");

// Make an instance of the transaction object
$del_newsletter_categories = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_newsletter_categories);
// Register triggers
$del_newsletter_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_newsletter_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_newsletter_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_newsletter_categories->registerTrigger("BEFORE", "Trigger_DeleteDetail", 40);
// Add columns
$del_newsletter_categories->setTable("newsletter_categories");
$del_newsletter_categories->setPrimaryKey("id_cts", "NUMERIC_TYPE", "GET", "id_cts");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnewsletter_categories = $tNGs->getRecordset("newsletter_categories");
$row_rsnewsletter_categories = mysqli_fetch_assoc($rsnewsletter_categories);
$totalRows_rsnewsletter_categories = mysqli_num_rows($rsnewsletter_categories);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">

        <div id="second-nav">
            <h1 class="pull-left"><i class="fa fa-envelope-o"></i> <span><?php __('Newsletter'); ?></span></h1>
            <div class="btn-toolbar pull-right" role="toolbar">
                <?php if (@$_GET['id_cts'] == "") { ?>
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success btn-sm" />
                <?php } else { ?>
                  <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm" />
                  <input type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 btn btn-danger btn-sm" />
                <?php } ?>
                <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-default btn-sm" />
            </div>
        </div>

        <div id="main-content">

            <div class="container-fluid">

                <div class="panel panel-primary">

                    <div class="panel-heading">
                        <h3 class="panel-title"><?php if (@$_GET['id_cts'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php __('Categoría'); ?></h3>
                    </div>

                    <div class="panel-body">

                        <?php echo $tNGs->getErrorMsg(); ?>

                        <?php foreach($languages as $value) {  ?>
                        <div class="form-group <?php if($tNGs->displayFieldError("newsletter_categories", "category_".$value."_cts") != '') { ?>has-error<?php } ?>">
                          <label for="category_<?php echo $value; ?>_cts"><?php __('Categoría'); ?>:</label>
                            <div class="input-group">
                              <span class="input-group-addon"><img src="../includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt=""></span>
                              <input type="text" name="category_<?php echo $value; ?>_cts" id="category_<?php echo $value; ?>_cts" value="<?php echo KT_escapeAttribute($row_rsnewsletter_categories['category_'.$value.'_cts']); ?>" size="32" maxlength="255" class="form-control required">
                            </div>
                            <?php echo $tNGs->displayFieldError("newsletter_categories", "category_".$value."_cts"); ?>
                        </div>
                        <?php } ?>

                    </div>

                </div>

            </div> <!--/.container-fluid -->

        </div> <!--#main-content -->

        <input type="hidden" name="kt_pk_newsletter_categories" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnewsletter_categories['kt_pk_newsletter_categories']); ?>" />

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
