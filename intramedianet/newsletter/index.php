<?php
// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

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

$query_rsproperties = "SELECT referencia_prop, id_prop FROM properties_properties ORDER BY referencia_prop";
$rsproperties = mysqli_query($inmoconn, $query_rsproperties) or die(mysqli_error());
$row_rsproperties = mysqli_fetch_assoc($rsproperties);
$totalRows_rsproperties = mysqli_num_rows($rsproperties);

$query_rsNews = "SELECT title_".$language."_nws, id_nws FROM news WHERE title_".$language."_nws != ''  AND content_".$language."_nws != '' AND type_nws = 1 ORDER BY title_".$language."_nws";
$rsNews = mysqli_query($inmoconn, $query_rsNews) or die(mysqli_error());
$row_rsNews = mysqli_fetch_assoc($rsNews);
$totalRows_rsNews = mysqli_num_rows($rsNews);

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
            <a href="/intramedianet/newsletter/usuarios.php" class="btn btn-primary btn-sm"><?php __('Usuarios'); ?></a>
            <a href="/intramedianet/newsletter/importar.php" class="btn btn-primary btn-sm"><?php __('Importar Usuarios'); ?></a>
            <a href="/intramedianet/newsletter/categories.php" class="btn btn-primary btn-sm"><?php __('Categorías'); ?></a>
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
                                    <label for="langs"><?php __('Idiomas'); ?>:</label>
                                    <select name="langs" id="langs" class="form-control">
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

                                <div class="form-group">
                                    <label for="cats"><?php __('Categoría'); ?>:</label>
                                    <select name="cats[]" id="cats" class="required select2" multiple>
                                    <?php
                                    do {
                                    ?>
                                    <option value="<?php echo $row_rscategorias['id_cts']?>"><?php echo $row_rscategorias['category_'.$lang_adm.'_cts']?></option>
                                    <?php
                                    } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                      $rows = mysqli_num_rows($rscategorias);
                                      if($rows > 0) {
                                          mysqli_data_seek($rscategorias, 0);
                                        $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                      }
                                    ?>
                                     </select>

                                     <div class="well well-sm well-newsletter">
                                        <i class="icon icon-user"></i> <b><span class="total-users">0</span></b> <?php __('Usuarios'); ?>
                                     </div>
                                  </div>

                                  <hr>

                                  <div class="form-group">
                                    <label for="props"><?php __('Inmuebles'); ?>:</label>
                                    <select name="props[]" id="props" class="select2" multiple>
                                    <?php
                                    do {
                                    ?>
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

                                  <div class="form-group">
                                    <label for="news"><?php __('Noticias'); ?>:</label>
                                    <select name="news[]" id="news" class="select2" multiple>
                                    <?php
                                    do {
                                    ?>
                                    <option value="<?php echo $row_rsNews['id_nws']?>"><?php echo $row_rsNews['title_'.$language.'_nws']?></option>
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

    <script>



    </script>

    <script src="_js/newsletter-send.js" type="text/javascript"></script>

</body>
</html>
