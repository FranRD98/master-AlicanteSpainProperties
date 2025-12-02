<?php
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

$colname_rsImg = mysqli_real_escape_string($inmoconn,$colname_rsImg);

$query_rsImg = sprintf("SELECT * FROM properties_client_files WHERE id_fil = %s", GetSQLValueString($colname_rsImg, "int"));
$rsImg = mysqli_query($inmoconn, $query_rsImg) or die(mysqli_error());
$row_rsImg = mysqli_fetch_assoc($rsImg);
$totalRows_rsImg = mysqli_num_rows($rsImg);



// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_inmoconn);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Custom1");
$customTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
//$customTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../modules/contactar/{GET.lang}/contactar/?s=ok");
// Set custom transaction SQL
$set  = '';
$num = count($languages);
$i = 1;
foreach($languages as $value) {
  $nom = "name_fil";
   $set  .= "`".$nom."` =  '".$_POST[$nom]."'";
  if($i++ < $num) {
    $set  .= " , ";
  }

}

$customTransaction->setSQL("UPDATE  `properties_client_files` SET  name_fil = '". $_POST['name_fil']."'  WHERE  `properties_client_files`.`id_fil` = ".$_POST['p']." LIMIT 1 ;");
// Add columns
$customTransaction->addColumn("name_fil", "STRING_TYPE", "POST", "name_fil", $row_rsImg['name_fil']);
// End of custom transaction instance

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
    <div class="mb-2 <?php if($tNGs->displayFieldError("custom", "name_fil") != '') { ?>error<?php } ?>">
        <label for="name_fil" class="form-label"><?php __('Nombre'); ?>:</label>
        <div class="controls">
            <input type="text" name="name_fil" id="name_fil" value="<?php echo KT_escapeAttribute($row_rscustom['name_fil']); ?>" size="32" maxlength="255" class="form-control">
          <?php echo $tNGs->displayFieldError("custom", "name_fil"); ?>
        </div>
    </div>
</div>
<input type="hidden" name="KT_Custom1" id="KT_Custom1" value="1" />
<?php
mysqli_free_result($rsImg);
?>
