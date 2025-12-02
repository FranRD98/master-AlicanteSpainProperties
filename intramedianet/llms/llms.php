<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

$_GET['id'] = 1;

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

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$lang_adm.'.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');


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
$formValidation->addField("name", true, "text", "", "", "", "");
$formValidation->addField("description", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

function replaceTags($startPoint, $endPoint, $newText, $source) {
    return preg_replace('@('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')@si', '$1'.$newText.'$3', $source);
}

//start Trigger_UpdateLLMS trigger
//remove this line if you want to edit the code by hand
function Trigger_UpdateLLMS(&$tNG) {

  include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

  global $database_inmoconn, $inmoconn, $language, $languages, $actCostas;

  $filename = $_SERVER["DOCUMENT_ROOT"] . '/llms.txt';
  $llms = file_get_contents($filename);

  $llms = replaceTags('# ','>', $tNG->getColumnValue('name') . "\n", $llms);
  file_put_contents($filename, $llms);

  $llms = replaceTags('> ',"---\n##", $tNG->getColumnValue('description') . "\n", $llms);
  file_put_contents($filename, $llms);





  // $query_rsPages = "SELECT * FROM news WHERE type_nws = 2 AND llms_name_nws != '' AND llms_url_nws != '' AND llms_descripcion_nws != ''";
  // $rsPages = mysqli_query($inmoconn,$query_rsPages) or die(mysqli_error());
  // $row_rsPages = mysqli_fetch_assoc($rsPages);
  // $totalRows_rsPages = mysqli_num_rows($rsPages);

  // $newText = "";

  // if ($totalRows_rsPages > 0) {
  //     do {

  //       $newText .= "\n- [" . $row_rsPages['llms_name_nws'] . "](" . $row_rsPages['llms_url_nws'] . "): \n";
  //       $newText .= $row_rsPages['llms_descripcion_nws'];

  //     } while ($row_rsPages = mysqli_fetch_assoc($rsPages));
  // }

  // $filename = $_SERVER["DOCUMENT_ROOT"] . '/llms.txt';
  // $llms = file_get_contents($filename);

  // $llms = replaceTags('## Páginas','---', $newText . "\n", $llms);
  // file_put_contents($filename, $llms);

  return true;
}
//end Trigger_UpdateLLMS trigger

// Make an update transaction instance
$upd_llms = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_llms);
// Register triggers
$upd_llms->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_llms->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_llms->registerTrigger("END", "Trigger_Default_Redirect", 99, "llms.php?u=ok");
$upd_llms->registerTrigger("AFTER", "Trigger_UpdateLLMS", 97);
// Add columns
$upd_llms->setTable("llms");
$upd_llms->addColumn("name", "STRING_TYPE", "POST", "name");
$upd_llms->addColumn("description", "STRING_TYPE", "POST", "description");
$upd_llms->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsllms = $tNGs->getRecordset("llms");
$row_rsllms = mysqli_fetch_assoc($rsllms);
$totalRows_rsllms = mysqli_num_rows($rsllms);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include("../includes/inc.head.php"); ?>

</head>

<body>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <form method="post" id="form" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate>

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-microchip-ai"></i> <?php echo __('Info IA'); ?></h4>
                        <div class="flex-shrink-0">
                            <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i> <span class="d-none d-lg-inline-block"><?php echo NXT_getResource("Update_FB"); ?></span></button>
                        </div>
                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <?php if (isset($_GET['u']) && $_GET['u'] == 'ok') { ?>
                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-check label-icon"></i> <?php echo $lang['Los datos se ha guardado correctamente'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-body">

                                <div class="mb-4 <?php if($tNGs->displayFieldError("llms", "name") != '') { ?>has-error<?php } ?>">
                                    <label for="name" class="form-label"><?php __('Nombre de la inmobiliaria'); ?></label>
                                    <input type="text" name="name" id="name" value="<?php if(isset($row_rsllms['name'])) echo KT_escapeAttribute($row_rsllms['name']); ?>" size="32" maxlength="255" class="form-control required" required>
                                    <div class="invalid-feedback">
                                        <?php __('Este campo es obligatorio.'); ?>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("llms", "name"); ?>
                                </div>

                                <div class="<?php if($tNGs->displayFieldError("llms", "description") != '') { ?>has-error<?php } ?>">
                                    <label for="description" class="form-label"><?php __('Descripcion de la empresa'); ?></label>
                                    <textarea name="description" id="description" rows="10" class="form-control required"><?php echo KT_escapeAttribute($row_rsllms['description']); ?></textarea>
                                    <div class="invalid-feedback">
                                        <?php __('Este campo es obligatorio.'); ?>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("llms", "description"); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="kt_pk_llms" class="id_field" value="<?php if(isset($row_rsllms['kt_pk_llms'])) echo KT_escapeAttribute($row_rsllms['kt_pk_llms']); ?>" />

    </form>

<?php include("../includes/inc.footer.php"); ?>

</body>
</html>
