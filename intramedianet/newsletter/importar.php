<?php
// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

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

$query_rscategorias = "SELECT id_cts, category_".$lang_adm."_cts as cat FROM newsletter_categories ORDER BY category_".$lang_adm."_cts";
$rscategorias = mysqli_query($inmoconn, $query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("csv", true, "", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand
function Trigger_FileDelete(&$tNG) {
  @unlink("uploads/csv.csv");
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("csv");
  //$uploadObj->setDbFieldName("csv");
  $uploadObj->setFolder("uploads");
  $uploadObj->setMaxSize(0);
  $uploadObj->setAllowedExtensions("txt, csv");
  $uploadObj->setRename("custom");
  $uploadObj->setRenameRule("csv.csv");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger


// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_inmoconn);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Custom1");
$customTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$customTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "importar.php?u=ok&c={POST.cat}&l={POST.lang}");
$customTransaction->registerTrigger("AFTER", "Trigger_FileUpload", 97);
$customTransaction->registerTrigger("BEFORE", "Trigger_FileDelete", 98);
// Add columns
$customTransaction->addColumn("csv", "FILE_TYPE", "FILES", "csv");
// End of custom transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysqli_fetch_assoc($rscustom);
$totalRows_rscustom = mysqli_num_rows($rscustom);



class utf8encode_filter extends php_user_filter
{
  function filter($in, $out, &$consumed, $closing)
  {
    while ($bucket = stream_bucket_make_writeable($in)) {
      $bucket->data = mb_convert_encoding($bucket->data, 'UTF-8', 'ISO-8859-1');
      $consumed += $bucket->datalen;
      stream_bucket_append($out, $bucket);
    }
    return PSFS_PASS_ON;
  }
}

stream_filter_register("utf8encode", "utf8encode_filter")
  or die("Failed to register filter");


if($_GET['u'] == 'ok') {

$row = 1;
if (($handle = fopen('uploads/csv.csv', "r")) !== FALSE) {
stream_filter_prepend($handle, "utf8encode");
while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
        $num = count($data);
        $row++;
        $datos = explode(';', $data[0]);
    $query_import = "INSERT INTO  newsletter_users (id_usr ,nombre_usr ,email_usr, lang_usr,date_usr) VALUES (NULL ,  '".$datos[0]."',  '".$datos[1]."', '".$_GET['l']."', '".date("Y-m-d H:i:s")."')";
    $import = mysqli_query($inmoconn, $query_import);
    $id = mysqli_insert_id($inmoconn);

    $query_import = "INSERT INTO  newsletter_usr_cat (id, usr ,cat) VALUES (NULL ,'".$id."',  '".$_GET['c']."')";
    $import = mysqli_query($inmoconn,$query_import);
    // $query_import = "INSERT INTO  usuario_categoria (usuario ,categoria) VALUES ('".$id."',  '12')";
    // $import = mysqli_query($query_import, $inmoconn);
    // echo $data[0] .'<hr>';
    }
    fclose($handle);
  header("Location: importar.php?t=ok");
}

}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-envelope-o"></i> <span><?php __('Newsletter'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="index.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Importar Usuarios'); ?></h3>
                </div>

                <div class="panel-body">

                    <?php echo $tNGs->getErrorMsg(); ?>

                    <?php if (@$_GET['t'] == "ok") { ?>
                    <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <?php __('Se han insertado todos los usuarios') ?>
                    </div>
                    <?php } ?>

                    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data" class="validate">

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">
                                  <label for="cat"><?php __('Categoría'); ?>:</label>
                                  <select name="cat" id="cat" class="form-control required">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php
                                      do {
                                      ?>
                                      <option value="<?php echo $row_rscategorias['id_cts']?>"><?php echo $row_rscategorias['cat']?></option>
                                      <?php
                                      } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                        $rows = mysqli_num_rows($rscategorias);
                                        if($rows > 0) {
                                            mysqli_data_seek($rscategorias, 0);
                                          $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                        }
                                      ?>
                                   </select>

                                    <?php echo $tNGs->displayFieldError("news", "cat"); ?>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                  <label for="lang"><?php __('Idioma'); ?>:</label>
                                    <select name="lang" id="lang" class="form-control required">
                                      <option value="" ><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php

                                      $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino');

                                      foreach ($idiomas as $key => $value) {
                                          if (in_array($key, $languages)) {

                                            echo '<option value="'.$key.'">'.$value.'</option>';

                                          }
                                      }

                                       ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                  <label for="csv"><?php __('CSV'); ?>:</label>
                                  <input type="file" name="csv" id="csv" size="32" class="form-control" />
                                </div>

                            </div>

                        </div>

                        <hr>

                        <input type="submit" name="KT_Custom1" id="KT_Custom1" value="<?php __('Importar') ?>" class="btn btn-success" />

                        <hr>

                        <p><?php __('El archivo tiene que tener la extensión txt o csv y tener el siguiente formato') ?>:</p>

                        <table class="table table-striped table-bordered">
                            <tr>
                                <td><?php __('Nombre') ?> 1;email@email.com</td>
                            </tr>
                            <tr>
                                <td><?php __('Nombre') ?> 2;email@email2.com</td>
                            </tr>
                            <tr>
                                <td><?php __('Nombre') ?> 3;email@email3.com</td>
                            </tr>
                        </table>

                    </form>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
