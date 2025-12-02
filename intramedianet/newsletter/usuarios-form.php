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

$query_rsTowns = "SELECT id_cts, category_".$lang_adm."_cts, usr FROM newsletter_categories LEFT JOIN newsletter_usr_cat ON (newsletter_usr_cat.cat=id_cts AND newsletter_usr_cat.usr='0123456789') ORDER BY category_".$lang_adm."_cts";
$rsTowns = mysqli_query($inmoconn, $query_rsTowns) or die(mysqli_error());
$row_rsTowns = mysqli_fetch_assoc($rsTowns);
$totalRows_rsTowns = mysqli_num_rows($rsTowns);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_usr", false, "text", "", "", "", "");
$formValidation->addField("email_usr", true, "text", "", "", "", "");
$formValidation->addField("lang_usr", true, "text", "", "", "", "");
$formValidation->addField("date_usr", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_DeleteDetail3 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("newsletter_usr_cat");
  $tblDelObj->setFieldName("usr");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail3 trigger

//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("newsletter_usr_cat");
  $mtm->setPkName("usr");
  $mtm->setFkName("cat");
  $mtm->setFkReference("mtm");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany trigger

// Make an insert transaction instance
$ins_newsletter_users = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_newsletter_users);
// Register triggers
$ins_newsletter_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_newsletter_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_newsletter_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_newsletter_users->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// Add columns
$ins_newsletter_users->setTable("newsletter_users");
$ins_newsletter_users->addColumn("nombre_usr", "STRING_TYPE", "POST", "nombre_usr");
$ins_newsletter_users->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$ins_newsletter_users->addColumn("lang_usr", "STRING_TYPE", "POST", "lang_usr");
$ins_newsletter_users->addColumn("date_usr", "DATE_TYPE", "POST", "date_usr", "{NOW}");
$ins_newsletter_users->setPrimaryKey("id_usr", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_newsletter_users = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_newsletter_users);
// Register triggers
$upd_newsletter_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_newsletter_users->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_newsletter_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_newsletter_users->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// Add columns
$upd_newsletter_users->setTable("newsletter_users");
$upd_newsletter_users->addColumn("nombre_usr", "STRING_TYPE", "POST", "nombre_usr");
$upd_newsletter_users->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$upd_newsletter_users->addColumn("lang_usr", "STRING_TYPE", "POST", "lang_usr");
$upd_newsletter_users->addColumn("date_usr", "DATE_TYPE", "POST", "date_usr");
$upd_newsletter_users->setPrimaryKey("id_usr", "NUMERIC_TYPE", "GET", "id_usr");

// Make an instance of the transaction object
$del_newsletter_users = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_newsletter_users);
// Register triggers
$del_newsletter_users->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_newsletter_users->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_newsletter_users->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_newsletter_users->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
// Add columns
$del_newsletter_users->setTable("newsletter_users");
$del_newsletter_users->setPrimaryKey("id_usr", "NUMERIC_TYPE", "GET", "id_usr");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnewsletter_users = $tNGs->getRecordset("newsletter_users");
$row_rsnewsletter_users = mysqli_fetch_assoc($rsnewsletter_users);
$totalRows_rsnewsletter_users = mysqli_num_rows($rsnewsletter_users);
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
                <?php if (@$_GET['id_usr'] == "") { ?>
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
                        <h3 class="panel-title"><?php if (@$_GET['id_usr'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php __('Usuario'); ?></h3>
                    </div>

                    <div class="panel-body">

                        <?php echo $tNGs->getErrorMsg(); ?>

                        <div class="row">

                            <div class="col-sm-6">

                                <div class="form-group <?php if($tNGs->displayFieldError("newsletter_users", "date_usr") != '') { ?>error<?php } ?>">
                                  <label for="date_usr"><?php __('Añadido'); ?>:</label>
                                  <input type="text" name="date_usr" id="date_usr" value="<?php echo KT_formatDate($row_rsnewsletter_users['date_usr']); ?>" size="32" maxlength="255" class="form-control required datepick">
                                    <?php echo $tNGs->displayFieldError("newsletter_users", "date_usr"); ?>
                                </div>

                                <div class="form-group <?php if($tNGs->displayFieldError("newsletter_users", "nombre_usr") != '') { ?>error<?php } ?>">
                                  <label for="nombre_usr"><?php __('Nombre'); ?>:</label>
                                  <input type="text" name="nombre_usr" id="nombre_usr" value="<?php echo KT_escapeAttribute($row_rsnewsletter_users['nombre_usr']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("newsletter_users", "nombre_usr"); ?>
                                </div>

                                <div class="form-group <?php if($tNGs->displayFieldError("newsletter_users", "email_usr") != '') { ?>error<?php } ?>">
                                  <label for="email_usr"><?php __('Email'); ?>:</label>
                                  <input type="text" name="email_usr" id="email_usr" value="<?php echo KT_escapeAttribute($row_rsnewsletter_users['email_usr']); ?>" size="32" maxlength="255" class="form-control required email">
                                    <?php echo $tNGs->displayFieldError("newsletter_users", "email_usr"); ?>
                                </div>

                                <div class="form-group <?php if($tNGs->displayFieldError("newsletter_users", "lang_usr") != '') { ?>error<?php } ?>">
                                  <label for="lang_usr"><?php __('Idioma'); ?>:</label>
                                  <select name="lang_usr" id="lang_usr" class="form-control required">
                                    <option value="" <?php if (!(strcmp('', $row_rsnewsletter_users['lang_usr']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                    <?php

                                    if ($lang_adm == 'en') {
                                       $idiomas = array('ca' => 'Catalán', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Noruego', 'pt' => 'Norwegian', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese');
                                     } else {
                                       $idiomas = array('ca' => 'Catalan', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino');
                                     }

                                    foreach ($idiomas as $key => $value) {
                                        if (in_array($key, $languages)) {

                                          $sel = (!(strcmp($key, $row_rsnewsletter_users['lang_usr'])))?' SELECTED':'';
                                          echo '<option value="'.$key.'"'.$sel.'>'.$value.'</option>';

                                        }
                                    }

                                     ?>
                                  </select>
                                  <?php echo $tNGs->displayFieldError("newsletter_users", "lang_usr"); ?>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <legend><?php __('Categorías'); ?></legend>


                                                  <?php
                                  $cnt2 = 0;
                                ?>
                                                  <?php
                                  if ($totalRows_rsTowns>0) {
                                    $nested_query_rsTowns = str_replace("0123456789", $row_rsnewsletter_users['id_usr'], $query_rsTowns);
                                    $rsTowns = mysqli_query($inmoconn,$nested_query_rsTowns) or die(mysqli_error());
                                    $row_rsTowns = mysqli_fetch_assoc($rsTowns);
                                    $totalRows_rsTowns = mysqli_num_rows($rsTowns);
                                    $nested_sw = false;
                                    if (isset($row_rsTowns) && is_array($row_rsTowns)) {
                                      do { //Nested repeat
                                    ?>

                                        <div class="checkbox">
                                            <label>
                                                <input  <?php if ($row_rsTowns['usr'] != "") {?> checked<?php }?> type="checkbox" name="mtm_<?php echo $row_rsTowns['id_cts']; ?>" id="mtm_<?php echo $row_rsTowns['id_cts']; ?>" value="1" class="onoffbtn" />
                                                <?php echo $row_rsTowns['category_'.$lang_adm.'_cts']; ?>
                                            </label>
                                        </div> <!-- /.form-group -->

                                        <hr class="hr-cats">

                                      <?php
                                      } while ($row_rsTowns = mysqli_fetch_assoc($rsTowns)); //Nested move next
                                    }
                                  }
                                ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div> <!--/.container-fluid -->

        </div> <!--#main-content -->

        <input type="hidden" name="kt_pk_newsletter_users" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnewsletter_users['kt_pk_newsletter_users']); ?>" />

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
