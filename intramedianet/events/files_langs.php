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

$query_rsImg = sprintf("SELECT * FROM news_files WHERE id_fil = %s", GetSQLValueString($colname_rsImg, "int"));
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


$customTransaction->setSQL("UPDATE  `news_files` SET  lang_fil = '". $_GET['lang_fil']."'  WHERE  `news_files`.`id_fil` = ".$_GET['p']." LIMIT 1 ;");

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

<form id="langVals" class="bg-light">

<div class="form-group <?php if($tNGs->displayFieldError("custom", "lang_fil") != '') { ?>has-error<?php } ?>">
    <label for="lang_fil"><?php __('Idioma'); ?>:</label>
    <select name="lang_fil" id="lang_fil" class="form-select required" required>
        <option value=""><?php __('Todos los idiomas'); ?></option>
        <?php
        if ($lang_adm == 'es') {
            $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
        } else {
            $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
        }
        foreach ($languages as $value) {
            $selected = (!(strcmp($value, $row_rsImg['lang_fil'])))?" SELECTED":"";
            echo '<option value="'.$value.'"'.$selected.'>'.$idiomas[$value].'</option>';
        }
        ?>
    </select>
    <?php echo $tNGs->displayFieldError("custom", "lang_fil"); ?>
</div>

  <input type="hidden" name="p" id="p" value="<?php echo $_GET['p'] ?>" />


  <input type="hidden" name="KT_Custom1" id="KT_Custom1" value="1" />

  </form>
<?php
mysqli_free_result($rsImg);
?>
