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



// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("find_rep", true, "text", "", "", "", "");
$formValidation->addField("replace_rep", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_xml_replace = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_xml_replace);
// Register triggers
$ins_xml_replace->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_xml_replace->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_xml_replace->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_xml_replace->setTable("xml_replace");
$ins_xml_replace->addColumn("find_rep", "STRING_TYPE", "POST", "find_rep");
$ins_xml_replace->addColumn("replace_rep", "STRING_TYPE", "POST", "replace_rep");
$ins_xml_replace->setPrimaryKey("id_rep", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_xml_replace = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_xml_replace);
// Register triggers
$upd_xml_replace->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_xml_replace->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_xml_replace->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_xml_replace->setTable("xml_replace");
$upd_xml_replace->addColumn("find_rep", "STRING_TYPE", "POST", "find_rep");
$upd_xml_replace->addColumn("replace_rep", "STRING_TYPE", "POST", "replace_rep");
$upd_xml_replace->setPrimaryKey("id_rep", "NUMERIC_TYPE", "GET", "id_rep");

// Make an instance of the transaction object
$del_xml_replace = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_xml_replace);
// Register triggers
$del_xml_replace->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_xml_replace->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_xml_replace->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_xml_replace->setTable("xml_replace");
$del_xml_replace->setPrimaryKey("id_rep", "NUMERIC_TYPE", "GET", "id_rep");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsxml_replace = $tNGs->getRecordset("xml_replace");
$row_rsxml_replace = mysqli_fetch_assoc($rsxml_replace);
$totalRows_rsxml_replace = mysqli_num_rows($rsxml_replace);
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
        <h1 class="pull-left"><i class="fa fa-cloud-download"></i> <span><?php __('Importar'); ?> XML</span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <?php if (@$_GET['id_rep'] == "") { ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success btn-sm" />
            <?php } else { ?>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm" />
            <input type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 btn btn-danger btn-sm" />
            <?php } ?>
            <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-sm" />
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php if (@$_GET['id_rep'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php __('Texto'); ?></h3>
                </div>

                <div class="panel-body">

                    <div class="form-group <?php if($tNGs->displayFieldError("xml_replace", "find_rep") != '') { ?>has-error<?php } ?>">
                        <label for="find_rep"><?php __('Buscar'); ?>:</label>
                        <input type="text" name="find_rep" id="find_rep" value="<?php echo KT_escapeAttribute($row_rsxml_replace['find_rep']); ?>" size="32" maxlength="255" class="form-control required">
                        <?php echo $tNGs->displayFieldError("xml_replace", "find_rep"); ?>
                    </div>

                    <div class="form-group <?php if($tNGs->displayFieldError("xml_replace", "replace_rep") != '') { ?>has-error<?php } ?>">
                        <label for="replace_rep"><?php __('Reemplazar'); ?>:</label>
                        <input type="text" name="replace_rep" id="replace_rep" value="<?php echo KT_escapeAttribute($row_rsxml_replace['replace_rep']); ?>" size="32" maxlength="255" class="form-control required">
                        <?php echo $tNGs->displayFieldError("xml_replace", "replace_rep"); ?>
                    </div>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <input type="hidden" name="kt_pk_xml_replace" class="id_field" value="<?php echo KT_escapeAttribute($row_rsxml_replace['kt_pk_xml_replace']); ?>" />

    </form>

<?php include("../includes/inc.footer.php"); ?>

</body>
</html>
