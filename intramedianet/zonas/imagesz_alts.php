<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

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
$tNGs->prepareValidation($formValidation);
// End trigger

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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

$colname_rsImg = "-1";
if (isset($_GET['p'])) {
  $colname_rsImg = $_GET['p'];
}

$colname_rsImg = mysqli_real_escape_string($inmoconn, $colname_rsImg);

$query_rsImg = sprintf("SELECT * FROM zonas_images WHERE id_img = %s", GetSQLValueString($colname_rsImg, "int"));
$rsImg = mysqli_query($inmoconn,$query_rsImg) or die(mysqli_error());
$row_rsImg = mysqli_fetch_assoc($rsImg);
$totalRows_rsImg = mysqli_num_rows($rsImg);



// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_inmoconn);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_Custom1");
$customTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
//$customTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../modules/contactar/{GET.lang}/contactar/?s=ok");
// Set custom transaction SQL
$set  = '';
$num = count($languages);
$i = 1;
foreach($languages as $value) {
  $nom = "alt_".$value."_img";
   $set  .= "`".$nom."` =  '".mysqli_real_escape_string($inmoconn,$_GET[$nom])."'";
  if($i++ < $num) {
    $set  .= " , ";
  }

}

$set2 = '';
if(isset($_GET['destacada_img']) && $_GET['destacada_img'] == 1){
  $set2 .= ", destacada_img = 1";
}
else{
  $set2 .= ", destacada_img = 0";
}


$customTransaction->setSQL("UPDATE  `zonas_images` SET  ". $set. $set2 ."  WHERE  `zonas_images`.`id_img` = ".$_GET['p']." LIMIT 1 ;");
// Add columns
foreach($languages as $value) {
  $customTransaction->addColumn("alt_".$value."_img", "STRING_TYPE", "GET", "alt_".$value."_img", $row_rsImg['alt_'.$value.'_img']);
}

$customTransaction->addColumn("destacada_img", "CHECKBOX_1_0_TYPE", "GET", "destacada_img", $row_rsImg['destacada_img']);

// End of custom transaction instance

$query_rsfoto = "SELECT id_img, zona_img from zonas_images WHERE id_img = ".$_GET['p'];
$rsrsfoto = mysqli_query($inmoconn,$query_rsfoto) or die(mysqli_error());
$row_rsfoto = mysqli_fetch_assoc($rsrsfoto);


// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysqli_fetch_assoc($rscustom);
$totalRows_rscustom = mysqli_num_rows($rscustom);
?>
<?php
  echo $tNGs->getErrorMsg();
?>
<div class="bg-light">
    <?php foreach($languages as $value) {  ?>
    <div class="mb-2 <?php if($tNGs->displayFieldError("custom", "alt_".$value."_img") != '') { ?>has-error<?php } ?>">
        <div class="input-group">
            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" height="15"></span>
            <?php if($value == 'ru') { ?>
                <input type="text" class="form-control" name="alt_<?php echo $value; ?>_img" id="alt_<?php echo $value; ?>_img" value="<?php echo $row_rsImg['alt_'.$value.'_img']; ?>">
            <?php } else { ?>
                <input type="text" class="form-control" name="alt_<?php echo $value; ?>_img" id="alt_<?php echo $value; ?>_img" value="<?php echo KT_escapeAttribute($row_rsImg['alt_'.$value.'_img']); ?>">
            <?php } ?>
            <?php echo $tNGs->displayFieldError("custom", "alt_".$value."_img"); ?>
        </div>
    </div>
    <?php } ?>




    <div class="row">
      <div class="col-12">
         <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
            <input type="checkbox" name="destacada_img" id="destacada_img" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rscustom['destacada_img']),"1"))) {echo "checked";} ?> >

            <label class="form-check-label" for="destacada_img"><?php __('Foto de principal'); ?></label>
            <?php echo $tNGs->displayFieldError("custom", "destacada_img"); ?>
        </div>

        <!-- <div class="card p-2 bg-white mt-3">
          <small><i class="fa-regular fa-image fa-fw"></i> <strong><?php __('Foto Panorámica'); ?>:</strong> 1920 * 1080px</small>
        </div> -->

      </div>
    </div>

    <input type="hidden" name="p" id="p" value="<?php echo $_GET['p'] ?>" />
    <input type="hidden" name="nw" id="nw" value="<?php echo $row_rsfoto['zona_img'] ?>" />
    <input type="hidden" name="KT_Custom1" id="KT_Custom1" value="1" />

</div>
<?php
mysqli_free_result($rsImg);
?>
