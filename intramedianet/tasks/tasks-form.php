<?php
date_default_timezone_set('Europe/Madrid');


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


if ($_SESSION['kt_login_level'] < 9) {
$query_rsAdminis = "SELECT nombre_usr, id_usr FROM users WHERE id_usr  = '" . $_SESSION['kt_login_id'] . "' ORDER BY nombre_usr";
} else {
$query_rsAdminis = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 10 ORDER BY nombre_usr";
}

$rsAdminis = mysqli_query($inmoconn,$query_rsAdminis) or die(mysqli_error());
$row_rsAdminis = mysqli_fetch_assoc($rsAdminis);
$totalRows_rsAdminis = mysqli_num_rows($rsAdminis);


$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);


$query_rsTasksCats = "SELECT id_cat, categorias_".$lang_adm."_cat as cat FROM tasks_categories ORDER BY categorias_".$lang_adm."_cat";
$rsTasksCats = mysqli_query($inmoconn,$query_rsTasksCats) or die(mysqli_error());
$row_rsTasksCats = mysqli_fetch_assoc($rsTasksCats);
$totalRows_rsTasksCats = mysqli_num_rows($rsTasksCats);

function getAdmin($id) {

    global $database_inmoconn, $inmoconn;

    $query_rsAdminis = "SELECT nombre_usr, id_usr FROM users WHERE id_usr  = '".$id."' ORDER BY nombre_usr";
    $rsAdminis = mysqli_query($inmoconn,$query_rsAdminis) or die(mysqli_error());
    $row_rsAdminis = mysqli_fetch_assoc($rsAdminis);
    $totalRows_rsAdminis = mysqli_num_rows($rsAdminis);

    return $row_rsAdminis['nombre_usr'];
}

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("admin_tsk", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("created_by_tsk", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("created_by_date_tsk", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  $tNG->addColumn("modified_by_tsk", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("modified_by_date_tsk", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  return $tNG->getError();
}
//end addFields trigger

//start addFields2 trigger
//remove this line if you want to edit the code by hand
function addFields2(&$tNG) {
  $tNG->addColumn("modified_by_tsk", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("modified_by_date_tsk", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  return $tNG->getError();
}
//end addFields2 trigger

if (isset($_POST['property_tsk']) && $_POST['property_tsk'] != '' ) {
  $_POST['property_tsk'] = implode(',', $_POST['property_tsk']);
}

// Make an insert transaction instance
$ins_tasks = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_tasks);
// Register triggers
$ins_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_tasks->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_tasks->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_tasks->registerTrigger("BEFORE", "addFields", 10);

// Add columns
$ins_tasks->setTable("tasks");
$ins_tasks->addColumn("admin_tsk", "NUMERIC_TYPE", "POST", "admin_tsk");
$ins_tasks->addColumn("subject_tsk", "STRING_TYPE", "POST", "subject_tsk");
$ins_tasks->addColumn("date_due_tsk", "DATE_TYPE",  "POST", "date_due_tsk");
$ins_tasks->addColumn("priority_tsk", "STRING_TYPE", "POST", "priority_tsk");
$ins_tasks->addColumn("status_tsk", "NUMERIC_TYPE", "POST", "status_tsk");
$ins_tasks->addColumn("property_tsk", "STRING_TYPE", "POST", "property_tsk");
$ins_tasks->addColumn("description_tsk", "STRING_TYPE", "POST", "description_tsk");
$ins_tasks->addColumn("contact_type_tsk", "STRING_TYPE", "POST", "contact_type_tsk");
$ins_tasks->addColumn("contact_tsk", "STRING_TYPE", "POST", "contact_tsk");
$ins_tasks->setPrimaryKey("id_tsk", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_tasks = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_tasks);
// Register triggers
$upd_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_tasks->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_tasks->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_tasks->registerTrigger("BEFORE", "addFields2", 10);

// Add columns
$upd_tasks->setTable("tasks");
$upd_tasks->addColumn("admin_tsk", "NUMERIC_TYPE", "POST", "admin_tsk");
$upd_tasks->addColumn("subject_tsk", "STRING_TYPE", "POST", "subject_tsk");
$upd_tasks->addColumn("date_due_tsk", "DATE_TYPE",  "POST", "date_due_tsk");
$upd_tasks->addColumn("priority_tsk", "STRING_TYPE", "POST", "priority_tsk");
$upd_tasks->addColumn("status_tsk", "STRING_TYPE", "POST", "status_tsk");
$upd_tasks->addColumn("property_tsk", "STRING_TYPE", "POST", "property_tsk");
$upd_tasks->addColumn("description_tsk", "STRING_TYPE", "POST", "description_tsk");
$upd_tasks->addColumn("contact_type_tsk", "STRING_TYPE", "POST", "contact_type_tsk");
$upd_tasks->addColumn("contact_tsk", "STRING_TYPE", "POST", "contact_tsk");
$upd_tasks->addColumn("created_by_tsk", "STRING_TYPE", "CURRVAL", "created_by_tsk");
$upd_tasks->addColumn("created_by_date_tsk", "STRING_TYPE", "CURRVAL", "created_by_date_tsk");
$upd_tasks->addColumn("modified_by_tsk", "STRING_TYPE", "CURRVAL", "modified_by_tsk");
$upd_tasks->addColumn("modified_by_date_tsk", "STRING_TYPE", "CURRVAL", "modified_by_date_tsk");

$upd_tasks->setPrimaryKey("id_tsk", "NUMERIC_TYPE", "GET", "id_tsk");

// Make an instance of the transaction object
$del_tasks = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_tasks);
// Register triggers
$del_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_tasks->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_tasks->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_tasks->setTable("tasks");
$del_tasks->setPrimaryKey("id_tsk", "NUMERIC_TYPE", "GET", "id_tsk");

// Execute all the registered transactions
$tNGs->executeTransactions();


// Get the transaction recordset
$rstasks = $tNGs->getRecordset("tasks");

$row_rstasks = mysqli_fetch_assoc($rstasks);
$totalRows_rstasks = mysqli_num_rows($rstasks);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

  <style>
      .emailc div, .phonec div {
        padding: 5px 0;
      }
  </style>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_tasks" class="id_field" value="<?php if(isset($row_rstasks['kt_pk_tasks'])) echo KT_escapeAttribute($row_rstasks['kt_pk_tasks']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-tasks"></i> <?php if (@$_GET['id_tsk'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Tarea'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_tsk'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Tarea'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-12">

                                        <?php if (@$_GET['id_tsk'] != "") { ?>
                                        <!-- <div class="form-group">

                                            <div class="col-sm-2"></div>
                                            <div class="">

                                                <b>Created by:</b> <?php echo getAdmin($row_rstasks['created_by_tsk']); ?> -  <?php echo KT_formatDate($row_rstasks['created_by_date_tsk']); ?>
                                                |
                                                <b>Updated by:</b> <?php echo getAdmin($row_rstasks['modified_by_tsk']); ?> -  <?php echo KT_formatDate($row_rstasks['modified_by_date_tsk']); ?>
                                                <hr>

                                            </div>

                                        </div> -->
                                        <?php } ?>

                                        <div class="row">
                                            <div class="col-lg-3">

                                                <div class="mb-4">
                                                    <label for="admin_tsk" class="form-label required"><?php __('Propietario de la tarea'); ?>:</label>
                                                    <div class="">
                                                        <select name="admin_tsk" id="admin_tsk" class="required select2" required>
                                                            <!-- <option value=""><?php echo NXT_getResource("Select one..."); ?></option> -->
                                                            <?php
                                                            do {
                                                              $selected = '';
                                                              if (@$_GET['id_tsk'] == "") {
                                                                  if (!(strcmp($row_rsAdminis['id_usr'], $_SESSION['kt_login_id']))) {
                                                                      $selected =  " SELECTED";
                                                                  }
                                                              } else {
                                                                if ($row_rsAdminis['id_usr'] == $row_rstasks['admin_tsk']) {
                                                                    $selected =  " SELECTED";
                                                                }
                                                              }
                                                            ?>
                                                            <option value="<?php echo $row_rsAdminis['id_usr']?>"<?php echo $selected; ?>><?php echo $row_rsAdminis['nombre_usr']?></option>
                                                            <?php
                                                            } while ($row_rsAdminis = mysqli_fetch_assoc($rsAdminis));
                                                              $rows = mysqli_num_rows($rsAdminis);
                                                              if($rows > 0) {
                                                                  mysqli_data_seek($rsAdminis, 0);
                                                                $row_rsAdminis = mysqli_fetch_assoc($rsAdminis);
                                                              }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">

                                                <div class="mb-4">
                                                    <label for="priority_tsk" class="form-label required"><?php __('Prioridad'); ?>:</label>
                                                    <div class="">
                                                        <select name="priority_tsk" id="priority_tsk" class="form-select required" required>
                                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                            <option value="Normal" <?php if (!(strcmp('Normal', $row_rstasks['priority_tsk']))) {echo "SELECTED";} ?>><?php __('Normal'); ?></option>
                                                            <option value="Low" <?php if (!(strcmp('Low', $row_rstasks['priority_tsk']))) {echo "SELECTED";} ?>><?php __('Low'); ?></option>
                                                            <option value="High" <?php if (!(strcmp('High', $row_rstasks['priority_tsk']))) {echo "SELECTED";} ?>><?php __('High'); ?></option>
                                                            <!-- <option value="Highest" <?php if (!(strcmp('Highest', $row_rstasks['priority_tsk']))) {echo "SELECTED";} ?>><?php __('Highest'); ?></option> -->
                                                            <!-- <option value="Lowest" <?php if (!(strcmp('Lowest', $row_rstasks['priority_tsk']))) {echo "SELECTED";} ?>><?php __('Lowest'); ?></option> -->
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">

                                                <div class="mb-4">
                                                    <label for="status_tsk" class="form-label"><?php __('Estado'); ?>:</label>
                                                    <div class="">
                                                        <select name="status_tsk" id="status_tsk" class="form-select">
                                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>

                                                            <?php
                                                            do {
                                                            ?>
                                                            <option value="<?php echo $row_rsTasksCats['id_cat']?>"<?php if (!(strcmp($row_rsTasksCats['id_cat'], $row_rstasks['status_tsk']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsTasksCats['cat']?></option>
                                                            <?php
                                                            } while ($row_rsTasksCats = mysqli_fetch_assoc($rsTasksCats ));
                                                              $rows = mysqli_num_rows($rsTasksCats );
                                                              if($rows > 0) {
                                                                  mysqli_data_seek($rsTasksCats , 0);
                                                                $row_rsTasksCats = mysqli_fetch_assoc($rsTasksCats );
                                                              }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">

                                                <div class="mb-4">
                                                    <label for="date_due_tsk" class="form-label"><?php __('Fecha de vencimiento'); ?>:</label>
                                                    <div class="">
                                                        <input type="text" name="date_due_tsk" id="date_due_tsk" value="<?php if(KT_formatDate($row_rstasks['date_due_tsk']) != '00-00-0000') { echo KT_formatDate($row_rstasks['date_due_tsk']); } ?>" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label for="subject_tsk" class="form-label required"><?php __('Asunto'); ?>:</label>
                                                    <div class="">
                                                        <input type="text" name="subject_tsk" id="subject_tsk" value="<?php if(isset($row_rstasks['subject_tsk'])) echo $row_rstasks['subject_tsk'] ?>" size="32" maxlength="255" class="form-control required" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2">

                                                <select name="contact_type_tsk" id="contact_type_tsk" class="form-select" style="direction: rtl;">
                                                    <option value="1" <?php if (isset($row_rstasks['contact_type_tsk']) && !(strcmp('1', $row_rstasks['contact_type_tsk']))) {echo "SELECTED";} ?>><?php __('Contacto'); ?></option>
                                                    <option value="2" <?php if (isset($row_rstasks['contact_type_tsk']) && !(strcmp('2', $row_rstasks['contact_type_tsk']))) {echo "SELECTED";} ?>><?php __('Cliente'); ?></option>
                                                    <option value="3" <?php if (isset($row_rstasks['contact_type_tsk']) && !(strcmp('3', $row_rstasks['contact_type_tsk']))) {echo "SELECTED";} ?>><?php __('Propietario'); ?></option>
                                                </select>

                                            </div>
                                            <div class="col-lg-10 mt-4 mt-md-0">

                                                <select name="contact_tsk" id="contact_tsk" class="form-select mb-1">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                </select>
                                                <div class="emailc"></div>
                                                <div class="phonec"></div>

                                            </div>
                                        </div>

                                        <div class="mb-4 mt-4 mt-md-0">
                                            <label for="property_tsk" class="form-label"><?php __('Propiedad'); ?>:</label>
                                            <div class="">
                                                <select name="property_tsk[]" id="property_tsk" multiplexx class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php
                                                    do {
                                                      $vals = explode(',', $row_rstasks['property_tsk']);
                                                    ?>
                                                    <option value="<?php echo $row_rspropiedad['id_prop']; ?>" <?php if(in_array($row_rspropiedad['id_prop'], $vals)) { ?> SELECTED<?php } ?>><?php echo $row_rspropiedad['referencia_prop']?></option>
                                                    <?php
                                                    } while ($row_rspropiedad = mysqli_fetch_assoc($rspropiedad));
                                                      $rows = mysqli_num_rows($rspropiedad);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rspropiedad, 0);
                                                        $row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
                                                      }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="">
                                            <label for="description_tsk" class="form-label"><?php __('Descripción'); ?>:</label>
                                            <div class="">
                                                <textarea name="description_tsk" id="description_tsk" cols="30" rows="25" class="form-control"><?php if(isset($row_rstasks['description_tsk'])) echo $row_rstasks['description_tsk'] ?></textarea>
                                            </div>
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

    <script>
    <?php if (isset($_GET['t']) && $_GET['t'] != ''): ?>
        var tip = '<?php echo $_GET['t']; ?>';
    <?php else: ?>
        var tip = '<?php echo $row_rstasks['contact_type_tsk']; ?>';
    <?php endif ?>

    <?php if (isset($_GET['idu']) && $_GET['idu'] != ''): ?>
        var sel = '<?php echo $_GET['idu']; ?>';
    <?php else: ?>
        var sel = '<?php echo $row_rstasks['contact_tsk']; ?>';
    <?php endif ?>
    </script>

    <script src="_js/tasks-form.js" type="text/javascript"></script>



</body>
</html>
