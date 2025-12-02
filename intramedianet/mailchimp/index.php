<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );

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


$query_rscategorias = "SELECT category_".$lang_adm."_cts, id_cts FROM newsletter_categories ORDER BY category_".$lang_adm."_cts";
$rscategorias = mysqli_query($inmoconn,$query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);


$query_rsproperties = "SELECT referencia_prop, id_prop FROM properties_properties WHERE activado_prop=1 ORDER BY referencia_prop";
$rsproperties = mysqli_query($inmoconn,$query_rsproperties) or die(mysqli_error());
$row_rsproperties = mysqli_fetch_assoc($rsproperties);
$totalRows_rsproperties = mysqli_num_rows($rsproperties);


$query_rsNews = "SELECT title_".$lang_adm."_nws, id_nws FROM news WHERE type_nws = 1 AND content_".$lang_adm."_nws != '' ORDER BY title_".$lang_adm."_nws";
$rsNews = mysqli_query($inmoconn,$query_rsNews) or die(mysqli_error());
$row_rsNews = mysqli_fetch_assoc($rsNews);
$totalRows_rsNews = mysqli_num_rows($rsNews);

$MailChimp = new MailChimp($keyMailchimp);
$listas = $MailChimp->get('lists', array(
    'count' => 100,
    'sort_field' => 'date_created',
    'sort_dir' => 'ASC'
));
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
            <a href="/intramedianet/mailchimp/segments.php" class="btn btn-primary btn-sm"><?php __('Listas'); ?></a>
            <a href="/intramedianet/mailchimp/pendientes.php" class="btn btn-primary btn-sm"><?php __('Mensajes pendientes'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Enviar'); ?> <?php __('Newsletter'); ?></h3>
                </div>

                <div class="panel-body">

                    <div class="progess"></div>

                    <form method="post" id="form1" action="index.php" class="validate">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <input type="text" name="subject" id="subject" value="" size="32" maxlength="255" class="form-control required" placeholder="<?php __('Asunto'); ?>">
                                </div>

                                <div class="form-group">
                                    <textarea name="message" id="message" cols="50" rows="20" class="wysiwyg required" placeholder="<?php __('Mensaje'); ?>"></textarea>
                                    <div class="text-count"></div>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="lang"><?php __('Idioma'); ?>:</label>
                                    <select name="lang" id="lang" class="form-control">
                                        <?php
                                        if ($lang_adm == 'es') {
                                            $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino');
                                        } else {
                                            $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese');
                                        }
                                        foreach ($languages as $value) {
                                            echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <hr>

                                <div class="form-group">
                                  <label for="lista"><?php __('Listas'); ?>:</label>
                                    <select name="lista" id="lista" class="form-control">
                                    <option value="<?php echo $mailchimpIdListaClients ?>"><?php __('Clientes'); ?></option>
                                    <option value="<?php echo $mailchimpIdListaOwners ?>"><?php __('Propietarios'); ?></option>
                                    <option value="<?php echo $mailchimpIdListaWebsite ?>"><?php __('Website'); ?></option>
                                    </select>
                                </div>

                                <hr>

											<p class="bg-info" style="padding: 10px;">
												<?php __('Si marca la casilla'); ?> <b><?php __('Enviar Test a'); ?></b>, <?php __('NO se enviará la newsletter a la lista seleccionada'); ?>
											</p>

											<div class="form-group">
                                    <label>
                                    	<input type="checkbox" name="test" id="test" value="1"> <?php __('Enviar Test a'); ?></label>
                                    	<input type="text" name="testmail" id="testmail" value="<?php echo $_SESSION['kt_login_user'] ?>" size="32" maxlength="255" class="form-control">
                                      <br>
                                    <label><input type="checkbox" name="schedule" id="schedule" value="1"> <?php __('Programar envío'); ?></label>
                                    <input type="text" name="schedule_ct" id="schedule_ct" value="" size="32" maxlength="255" class="form-control datetimepicker" disabled >
                                </div>

                                <hr>

                                <div class="form-group">
                                  <label for="props"><?php __('Inmuebles'); ?>:</label>
                                  <div class="controls">
                                      <select name="props[]" id="props" class="select2" multiple>
                                      <?php do { ?>
                                      <option value="<?php echo $row_rsproperties['id_prop']?>"><?php echo $row_rsproperties['referencia_prop']?></option>
                                      <?php
                                      } while ($row_rsproperties = mysqli_fetch_assoc($rsproperties));
                                        $rows = mysqli_num_rows($rsproperties);
                                        if($rows > 0) {
                                            mysqli_data_seek($rsproperties, 0);
                                          $row_rsproperties = mysqli_fetch_assoc($rsproperties);
                                        }
                                      ?>
                                       </select>
                                  </div>
                                </div>

                                <hr>

                                <div class="form-group">
                                  <label for="news"><?php __('Noticias'); ?>:</label>
                                      <select name="news[]" id="news" class="select2" multiple>
                                      <?php
                                      do {
                                      ?>
                                      <option value="<?php echo $row_rsNews['id_nws']?>"><?php echo $row_rsNews['title_'.$lang_adm.'_nws']?></option>
                                      <?php
                                      } while ($row_rsNews = mysqli_fetch_assoc($rsNews));
                                        $rows = mysqli_num_rows($rsNews);
                                        if($rows > 0) {
                                            mysqli_data_seek($rsNews, 0);
                                          $row_rsNews = mysqli_fetch_assoc($rsNews);
                                        }
                                      ?>
                                       </select>

                                </div>

                                <button type="Submit" id="send-newsletter" class="btn btn-success btl-large btn-block"><?php __('Enviar Newsletter'); ?></button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script type="text/javascript">
      var AppLang = "<?php echo $lang_adm; ?>";
    </script>

    <script src="_js/newsletter-send.js" type="text/javascript"></script>

</body>
</html>
