<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php' );

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
$rscategorias = mysqli_query($inmoconn, $query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);

mysqli_select_db($inmoconn,$database_inmoconn);
$query_rsproperties = "SELECT referencia_prop, id_prop FROM properties_properties WHERE activado_prop=1 ORDER BY referencia_prop";
$rsproperties = mysqli_query($inmoconn,$query_rsproperties) or die(mysqli_error());
$row_rsproperties = mysqli_fetch_assoc($rsproperties);
$totalRows_rsproperties = mysqli_num_rows($rsproperties);

foreach ($languages as $idm) {
    
    $query_rsNews[$idm] = "SELECT title_".$idm."_nws, id_nws FROM news WHERE type_nws = 1 AND content_".$idm."_nws != '' ORDER BY title_".$idm."_nws";
    $rsNews[$idm] = mysqli_query($inmoconn,$query_rsNews[$idm]) or die(mysqli_error());
    $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);

    $query_rsProm[$idm] = "SELECT title_".$idm."_nws, id_nws FROM news WHERE type_nws = 999 AND content_".$idm."_nws != '' ORDER BY title_".$idm."_nws";
    $rsProm[$idm] = mysqli_query($inmoconn,$query_rsProm[$idm]) or die(mysqli_error());
    $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);

    $query_rsCities[$idm] = "SELECT title_".$idm."_nws, id_nws FROM news WHERE type_nws = 6 AND content_".$idm."_nws != '' ORDER BY title_".$idm."_nws";
    $rsCities[$idm] = mysqli_query($inmoconn,$query_rsCities[$idm]) or die(mysqli_error());
    $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
}

/*
function _d($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}
    */

$listaf = array();
$acumba = new AcumbamailAPI($keyAcumbamail);

$listas = $acumba->getLists();
if($listas){
krsort($listas);
    foreach ($listas as $key => $value) {
        $datos = $acumba->getListStats($key);
        $listaf[$key]['name'] = $value['name'];
        $listaf[$key]['description'] = $value['description'];
        $listaf[$key]['total'] = $datos['total_subscribers'] - $datos['unsubscribed_subscribers'] - $datos['hard_bounced_subscribers'] - $datos['spam_subscribers'];
    }
}
// _d($listaf);
// die();
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>



</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex">
                    <div class="flex-grow-1 oveflow-hidden">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-envelopes-bulk"></i> <?php echo __('Newsletter'); ?></h4>
                    </div>
                    <!-- <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li role="presentation" class="nav-item">
                                <a class="nav-link active" href="#properties" role="tab" id="properties-tab" data-bs-toggle="tab" aria-controls="properties">
                                    <i class="fa-regular fa-buildings"></i> <b><?php __('Enviar'); ?>: <?php __('Inmuebles'); ?></b>
                                </a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a class="nav-link" href="#property" id="property-tab" role="tab" data-bs-toggle="tab" aria-controls="property" aria-expanded="true">
                                    <i class="fa-regular fa-buildings"></i> <b><?php __('Enviar'); ?>: <?php __('Inmueble'); ?></b>
                                </a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a class="nav-link" href="#news" role="tab" id="news-tab" data-bs-toggle="tab" aria-controls="news">
                                    <i class="fa-regular fa-newspaper"></i> <b><?php __('Enviar'); ?>: <?php __('Noticias'); ?></b>
                                </a>
                            </li>
                        </ul>
                    </div> -->
                </div>

                <div class="card-body">

                  <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                      <li role="presentation" class="nav-item w-100">
                          <a class="nav-link active" href="#properties" role="tab" id="properties-tab" data-bs-toggle="tab" aria-controls="properties">
                              <i class="fa-regular fa-buildings"></i> <b><?php __('Enviar'); ?>: <?php __('Inmuebles'); ?></b>
                          </a>
                      </li>
                      <li role="presentation" class="nav-item w-100">
                          <a class="nav-link" href="#property" id="property-tab" role="tab" data-bs-toggle="tab" aria-controls="property" aria-expanded="true">
                              <i class="fa-regular fa-buildings"></i> <b><?php __('Enviar'); ?>: <?php __('Inmueble'); ?></b>
                          </a>
                      </li>
                      <li role="presentation" class="nav-item w-100">
                          <a class="nav-link" href="#news" role="tab" id="news-tab" data-bs-toggle="tab" aria-controls="news">
                              <i class="fa-regular fa-newspaper"></i> <b><?php __('Enviar'); ?>: <?php __('Noticias'); ?></b>
                          </a>
                      </li>
                  </ul>

                    <div class="progess"></div>

                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="properties" aria-labelledby="properties-tab">

                            <form method="post" id="form1" action="index.php" class="needs-validation" novalidate>
                              <div class="row">
                                  <div class="col-md-6">
                                    <br>
                                      <div class="mb-4">
                                          <input type="text" name="subject" id="subject1" value="" size="32" maxlength="255" class="form-control required" placeholder="<?php __('Asunto'); ?>" required>
                                          <div class="invalid-feedback">
                                              <?php __('Este campo es obligatorio.'); ?>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <textarea name="message" id="message1" cols="50" rows="30" class="wysiwyg required" placeholder="<?php __('Mensaje'); ?>"></textarea>
                                          <div class="text-count"></div>
                                      </div>
                                      <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4" role="alert">
                                          <i class="fa-regular fa-circle-info label-icon"></i> <?php __('insert_client_mail_acumba'); ?>
                                      </div>
                                      <br>
                                      <div class="row">
                                          <div class="col-md-12">
                                              <legend class="fs-4"><?php __('Listas'); ?></legend>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <?php 
                                          if($listaf){
                                          foreach ($listaf as $key => $value) { 
                                          ?>
                                          <div class="col-md-6">
                                              <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                                <input type="checkbox" name="lista[]" id="lista1_<?php echo $key ?>" value="<?php echo $key ?>" class="form-check-input" <?php if (!(strcmp(  KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                                  <label class="form-check-label" for="lista1_<?php echo $key ?>"><?php echo $value['name'] ?></label>
                                              </div>
                                          </div>
                                          <?php }}else{
                                            echo '<div class="col-md-6"><div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3"><i class="fa-regular fa-circle-info label-icon"></i> Sin listas creadas</div></div>';
                                          } ?>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="lang1" class="form-label">
                                                      <?php __('Idioma'); ?>:</label>
                                                  <select name="lang" id="lang1" class="form-select">
                                                      <?php
                                                      if ($lang_adm == 'es') {
                                                          $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                                      } else {
                                                          $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                                      }
                                                      foreach ($languages as $value) {
                                                          echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                                      }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group mt-n2">
                                                  <label class="form-label mt-4 mt-md-0">
                                                        <div class="form-check form-switch form-switch-sm pt-2" dir="ltr">
                                                          <input type="checkbox" name="schedule" id="schedule1" value="1" class="form-check-input" <?php if (isset($row_rsnews['activate_nws']) && !(strcmp(  KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                                            <label class="form-check-label" for="schedule1"><?php __('Programar envío'); ?></label>
                                                        </div>
                                                  </label>
                                                  <input type="text" name="schedule_ct" id="schedule_ct1" value="" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y" data-enable-time data-enable-time-24hr disabled >
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row mt-4">
                                        <div class="col-md-12">
                                          <br>
                                          <div class="dd ddp">
                                            <ol class="dd-list"></ol>
                                          </div>
                                          <br>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="props1" class="form-label"><?php __('Inmuebles'); ?>:</label>
                                                <div class="controls">
                                                    <select name="props[]" id="props1" class="select2">
                                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                        <?php do { ?>
                                                        <option value="<?php echo $row_rsproperties['id_prop']?>">
                                                            <?php echo $row_rsproperties['referencia_prop']?>
                                                        </option>
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
                                        </div>
                                        <div class="col-md-3">
                                          <div class="controls">
                                            <div class="form-group">
                                              <br>
                                              <div class="controls">
                                                <button type="button" class="btn btn-primary w-100 selprop1"><?php __('Seleccionar'); ?></button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4" role="alert">
                                            <i class="fa-regular fa-circle-info label-icon"></i> <?php __('Selecciona 1, 3, 5 o más propiedades (número impar) para que la newsletter se vea correctamente. <br>Se mostrará 1 propiedad destacada y después 2 por fila; con números pares quedará un hueco vacío.'); ?>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <br>
                                          <div class="dd ddn">
                                            <ol class="dd-list"></ol>
                                          </div>
                                          <br>
                                        </div>
                                      </div>
                                      <?php foreach ($languages as $idm): ?>
                                      <div class="row noticias1" id="news_<?php echo $idm ?>">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="news1_<?php echo $idm ?>" class="form-label"><?php __('Noticias'); ?>:</label>
                                                <select name="news1_<?php echo $idm ?>" id="news1_<?php echo $idm ?>" class="select2" <?php if ($actNoticias == 0): ?>disabled<?php endif ?>>
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsNews[$idm]['id_nws']?>">
                                                        <?php echo $row_rsNews[$idm]['title_'.$idm.'_nws']?>
                                                    </option>
                                                    <?php
                                                    } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                                                      $rows = mysqli_num_rows($rsNews[$idm]);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsNews[$idm], 0);
                                                        $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                                                      }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="controls">
                                            <div class="form-group">
                                              <br>
                                              <div class="controls">
                                                <button type="button" class="btn btn-primary w-100 selnews1" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <?php endforeach ?>
                                      <?php if ($actPromociones == 1): ?>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <br>
                                          <div class="dd ddpr">
                                            <ol class="dd-list"></ol>
                                          </div>
                                          <br>
                                        </div>
                                      </div>
                                      <?php foreach ($languages as $idm): ?>
                                      <div class="row promociones1" id="prom_<?php echo $idm ?>">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="prom1_<?php echo $idm ?>" class="form-label"><?php __('Promociones'); ?>:</label>
                                                <select name="prom1_<?php echo $idm ?>" id="prom1_<?php echo $idm ?>" class="select2" <?php if ($actPromociones == 0): ?>disabled<?php endif ?>>
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsProm[$idm]['id_nws']?>">
                                                        <?php echo $row_rsProm[$idm]['title_'.$idm.'_nws']?>
                                                    </option>
                                                    <?php
                                                    } while ($row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]));
                                                      $rows = mysqli_num_rows($rsProm[$idm]);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsProm[$idm], 0);
                                                        $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);
                                                      }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="controls">
                                            <div class="form-group">
                                              <br>
                                              <div class="controls">
                                                <button type="button" class="btn btn-primary w-100 selprom1" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <?php endforeach ?>
                                      <?php endif ?>
                                      <?php if ($actZonas == 1): ?>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <br>
                                          <div class="dd ddc">
                                            <ol class="dd-list"></ol>
                                          </div>
                                          <br>
                                        </div>
                                      </div>
                                      <?php foreach ($languages as $idm): ?>
                                      <div class="row ciudades1" id="ciu_<?php echo $idm ?>">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="ciu1_<?php echo $idm ?>" class="form-label"><?php __('Áreas'); ?>:</label>
                                                <select name="ciu1_<?php echo $idm ?>" id="ciu1_<?php echo $idm ?>" class="select2" <?php if ($actZonas == 0): ?>disabled<?php endif ?>>
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsCities[$idm]['id_nws']?>">
                                                        <?php echo $row_rsCities[$idm]['title_'.$idm.'_nws']?>
                                                    </option>
                                                    <?php
                                                    } while ($row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]));
                                                      $rows = mysqli_num_rows($rsCities[$idm]);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsCities[$idm], 0);
                                                        $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
                                                      }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="controls">
                                            <div class="form-group">
                                              <br>
                                              <div class="controls">
                                                <button type="button" class="btn btn-primary w-100 selciu1" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <?php endforeach ?>
                                      <?php endif ?>
                                      <hr>
                                      <div class="row">
                                          <div class="col-md-12">
                                            <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
                                              <button type="Submit" id="send-newsletter1" class="btn btn-success btl-large w-100"><?php __('Enviar Newsletter'); ?></button>
                                            <?php else: ?>
                                              <button type="Submit" id="send-newsletter1" class="btn btn-light btl-large w-100" disabled><?php __('Enviar Newsletter'); ?></button>
                                            <?php endif ?>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </form>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="property" aria-labelledby="property-tab">

                            <form method="post" id="form2" action="index.php" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <input type="text" name="subject" id="subject2" value="" size="32" maxlength="255" class="form-control required" placeholder="<?php __('Asunto'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="message" id="message2" cols="50" rows="30" class="wysiwyg required" placeholder="<?php __('Mensaje'); ?>"></textarea>
                                            <div class="text-count"></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <legend class="fs-4"><?php __('Listas'); ?></legend>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php foreach ($listaf as $key => $value) { ?>
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                                      <input type="checkbox" name="lista[]" id="lista2_<?php echo $key ?>" value="<?php echo $key ?>" class="form-check-input" <?php if (!(strcmp(  KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="lista2_<?php echo $key ?>"><?php echo $value['name'] ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lang2" class="form-label"><?php __('Idioma'); ?>:</label>
                                                    <select name="lang" id="lang2" class="form-control">
                                                        <?php
                                                        if ($lang_adm == 'es') {
                                                            $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                                        } else {
                                                            $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                                        }
                                                        foreach ($languages as $value) {
                                                            echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-md-6">
                                                  <div class="form-group mt-n2">
                                                      <label class="form-label mt-4 mt-md-0">
                                                            <div class="form-check form-switch form-switch-sm pt-2" dir="ltr">
                                                              <input type="checkbox" name="schedule" id="schedule2" value="1" class="form-check-input" <?php if (isset($row_rsnews['activate_nws']) && !(strcmp(  KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                                                <label class="form-check-label" for="schedule2"><?php __('Programar envío'); ?></label>
                                                            </div>
                                                      </label>
                                                      <input type="text" name="schedule_ct" id="schedule_ct2" value="" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y" data-enable-time data-enable-time-24hr disabled >
                                                  </div>
                                              </div>
                                        </div>
                                        <div class="row mt-4">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label for="props1" class="form-label"><?php __('Inmueble'); ?>:</label>
                                                  <div class="controls">
                                                      <select name="props[]" id="props1" class="select2">
                                                          <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                          <?php do { ?>
                                                          <option value="<?php echo $row_rsproperties['id_prop']?>">
                                                              <?php echo $row_rsproperties['referencia_prop']?>
                                                          </option>
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
                                          </div>
                                        </div>
                                      <div class="row mt-4">
                                          <div class="col-md-12">
                                            <br>
                                            <div class="dd ddn2">
                                              <ol class="dd-list"></ol>
                                            </div>
                                            <br>
                                          </div>
                                        </div>
                                        <?php foreach ($languages as $idm): ?>
                                        <div class="row noticias2" id="news2_<?php echo $idm ?>">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <label for="news2_<?php echo $idm ?>" class="form-label"><?php __('Noticias'); ?>:</label>
                                                  <select name="news2_<?php echo $idm ?>" id="news2_<?php echo $idm ?>" class="select2" <?php if ($actNoticias == 0): ?>disabled<?php endif ?>>
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsNews[$idm]['id_nws']?>">
                                                          <?php echo $row_rsNews[$idm]['title_'.$idm.'_nws']?>
                                                      </option>
                                                      <?php
                                                      } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                                                        $rows = mysqli_num_rows($rsNews[$idm]);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsNews[$idm], 0);
                                                          $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="controls">
                                              <div class="form-group">
                                                <br>
                                                <div class="controls">
                                                  <button type="button" class="btn btn-primary w-100 selnews2" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php endforeach ?>
                                        <?php if ($actPromociones == 1): ?>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <br>
                                            <div class="dd ddpr2">
                                              <ol class="dd-list"></ol>
                                            </div>
                                            <br>
                                          </div>
                                        </div>
                                        <?php foreach ($languages as $idm): ?>
                                        <div class="row promociones2" id="prom2_<?php echo $idm ?>">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <label for="prom2_<?php echo $idm ?>" class="form-label"><?php __('Promociones'); ?>:</label>
                                                  <select name="prom2_<?php echo $idm ?>" id="prom2_<?php echo $idm ?>" class="select2" <?php if ($actPromociones == 0): ?>disabled<?php endif ?>>
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsProm[$idm]['id_nws']?>">
                                                          <?php echo $row_rsProm[$idm]['title_'.$idm.'_nws']?>
                                                      </option>
                                                      <?php
                                                      } while ($row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]));
                                                        $rows = mysqli_num_rows($rsProm[$idm]);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsProm[$idm], 0);
                                                          $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="controls">
                                              <div class="form-group">
                                                <br>
                                                <div class="controls">
                                                  <button type="button" class="btn btn-primary w-100 selprom2" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                        <?php if ($actZonas == 1): ?>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <br>
                                            <div class="dd ddc2">
                                              <ol class="dd-list"></ol>
                                            </div>
                                            <br>
                                          </div>
                                        </div>
                                        <?php foreach ($languages as $idm): ?>
                                        <div class="row ciudades2" id="ciu2_<?php echo $idm ?>">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <label for="ciu2_<?php echo $idm ?>" class="form-label"><?php __('Áreas'); ?>:</label>
                                                  <select name="ciu2_<?php echo $idm ?>" id="ciu2_<?php echo $idm ?>" class="select2" <?php if ($actZonas == 0): ?>disabled<?php endif ?>>
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsCities[$idm]['id_nws']?>">
                                                          <?php echo $row_rsCities[$idm]['title_'.$idm.'_nws']?>
                                                      </option>
                                                      <?php
                                                      } while ($row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]));
                                                        $rows = mysqli_num_rows($rsCities[$idm]);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsCities[$idm], 0);
                                                          $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="controls">
                                              <div class="form-group">
                                                <br>
                                                <div class="controls">
                                                  <button type="button" class="btn btn-primary w-100 selciu2" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                        <hr>
                                        <div class="row">
                                          <div class="col-md-12">
                                              <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
                                                <button type="Submit" id="send-newsletter2" class="btn btn-success btl-large w-100"><?php __('Enviar Newsletter'); ?></button>
                                              <?php else: ?>
                                                <button type="button" id="send-newsletter2" class="btn btn-light btl-large w-100" disabled><?php __('Enviar Newsletter'); ?></button>
                                              <?php endif ?>

                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="news" aria-labelledby="news-tab">

                            <form method="post" id="form3" action="index.php" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <input type="text" name="subject" id="subject3" value="" size="32" maxlength="255" class="form-control required" placeholder="<?php __('Asunto'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="message" id="message3" cols="50" rows="30" class="wysiwyg required" placeholder="<?php __('Mensaje'); ?>"></textarea>
                                            <div class="text-count"></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <legend><?php __('Listas'); ?></legend>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php foreach ($listaf as $key => $value) { ?>
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                                      <input type="checkbox" name="lista[]" id="lista3_<?php echo $key ?>" value="<?php echo $key ?>" class="form-check-input" <?php if (!(strcmp(  KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="lista3_<?php echo $key ?>"><?php echo $value['name'] ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lang3" class="form-label"><?php __('Idioma'); ?>:</label>
                                                    <select name="lang" id="lang3" class="form-control">
                                                        <?php
                                                        if ($lang_adm == 'es') {
                                                            $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                                        } else {
                                                            $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                                        }
                                                        foreach ($languages as $value) {
                                                            echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-md-6">
                                                  <div class="form-group mt-n2">
                                                      <label class="form-label mt-4 mt-md-0">
                                                            <div class="form-check form-switch form-switch-sm pt-2" dir="ltr">
                                                              <input type="checkbox" name="schedule" id="schedule3" value="1" class="form-check-input" <?php if (isset($row_rsnews['activate_nws']) && !(strcmp(  KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                                                <label class="form-check-label" for="schedule3"><?php __('Programar envío'); ?></label>
                                                            </div>
                                                      </label>
                                                      <input type="text" name="schedule_ct" id="schedule_ct3" value="" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y" data-enable-time data-enable-time-24hr disabled >
                                                  </div>
                                              </div>
                                        </div>
                                        <div class="row mt-4">
                                          <div class="col-md-12">
                                            <br>
                                            <div class="dd ddn3">
                                              <ol class="dd-list"></ol>
                                            </div>
                                            <br>
                                          </div>
                                        </div>
                                        <?php foreach ($languages as $idm): ?>
                                        <div class="row noticias3" id="news3_<?php echo $idm ?>">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <label for="news3_<?php echo $idm ?>" class="form-label"><?php __('Noticias'); ?>:</label>
                                                  <select name="news3_<?php echo $idm ?>" id="news3_<?php echo $idm ?>" class="select2" <?php if ($actNoticias == 0): ?>disabled<?php endif ?>>
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsNews[$idm]['id_nws']?>">
                                                          <?php echo $row_rsNews[$idm]['title_'.$idm.'_nws']?>
                                                      </option>
                                                      <?php
                                                      } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                                                        $rows = mysqli_num_rows($rsNews[$idm]);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsNews[$idm], 0);
                                                          $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="controls">
                                              <div class="form-group">
                                                <br>
                                                <div class="controls">
                                                  <button type="button" class="btn btn-primary w-100 selnews3" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php endforeach ?>
                                        <?php if ($actPromociones == 1): ?>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <br>
                                            <div class="dd ddpr3">
                                              <ol class="dd-list"></ol>
                                            </div>
                                            <br>
                                          </div>
                                        </div>
                                        <?php foreach ($languages as $idm): ?>
                                        <div class="row promociones3" id="prom3_<?php echo $idm ?>">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <label for="prom3_<?php echo $idm ?>" class="form-label"><?php __('Promociones'); ?>:</label>
                                                  <select name="prom3_<?php echo $idm ?>" id="prom3_<?php echo $idm ?>" class="select2" <?php if ($actPromociones == 0): ?>disabled<?php endif ?>>
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsProm[$idm]['id_nws']?>">
                                                          <?php echo $row_rsProm[$idm]['title_'.$idm.'_nws']?>
                                                      </option>
                                                      <?php
                                                      } while ($row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]));
                                                        $rows = mysqli_num_rows($rsProm[$idm]);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsProm[$idm], 0);
                                                          $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="controls">
                                              <div class="form-group">
                                                <br>
                                                <div class="controls">
                                                  <button type="button" class="btn btn-primary w-100 selprom3" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                        <?php if ($actZonas == 1): ?>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <br>
                                            <div class="dd ddc3">
                                              <ol class="dd-list"></ol>
                                            </div>
                                            <br>
                                          </div>
                                        </div>
                                        <?php foreach ($languages as $idm): ?>
                                        <div class="row ciudades3" id="ciu3_<?php echo $idm ?>">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <label for="ciu3_<?php echo $idm ?>" class="form-label"><?php __('Áreas'); ?>:</label>
                                                  <select name="ciu3_<?php echo $idm ?>" id="ciu3_<?php echo $idm ?>" class="select2" <?php if ($actZonas == 0): ?>disabled<?php endif ?>>
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsCities[$idm]['id_nws']?>">
                                                          <?php echo $row_rsCities[$idm]['title_'.$idm.'_nws']?>
                                                      </option>
                                                      <?php
                                                      } while ($row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]));
                                                        $rows = mysqli_num_rows($rsCities[$idm]);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsCities[$idm], 0);
                                                          $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="controls">
                                              <div class="form-group">
                                                <br>
                                                <div class="controls">
                                                  <button type="button" class="btn btn-primary w-100 selciu3" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                        <hr>
                                        <div class="row">
                                          <div class="col-md-12">
                                              <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
                                                <button type="Submit" id="send-newsletter3" class="btn btn-success btl-large w-100"><?php __('Enviar Newsletter'); ?></button>
                                              <?php else: ?>
                                                <button type="Submit" id="send-newsletter3" class="btn btn-light btl-large w-100" disabled><?php __('Enviar Newsletter'); ?></button>
                                              <?php endif ?>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script type="text/javascript">
      var AppLang = "<?php echo $lang_adm; ?>";
    </script>

    <!-- <script src="_js/newsletter-send.js" type="text/javascript"></script> -->

    <script type="text/javascript">
    $('.selprop1').click(function(e) {
        var val = $('#props1').find(':selected').val();
        var text = $('#props1').find(':selected').text();
        if (val != '') {
            $('.ddp .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propslist1[]" value="' + val + '"></div></li>');
            $('#props1').val(null).trigger('change');
        }
    });
    $(document).on('click', '.delproplist1', function(e) {
        $(this).closest('li').fadeOut('slow', function() {
            $(this).closest('li').remove();
        });
    });
    $('.ddp').nestable({
        group: 1
    });

    $('#lang1').change(function(e) {
        var idm = $(this).val();
        $('.noticias1').hide();
        $('#news_' + idm).show();
        $('.ddn .dd-list').html('');
        $('#news1_' + idm).val(null).trigger('change');

        $('.promociones1').hide();
        $('#prom_' + idm).show();
        $('.ddpr .dd-list').html('');
        $('#prom1_' + idm).val(null).trigger('change');

        $('.ciudades1').hide();
        $('#ciu_' + idm).show();
        $('.ddc .dd-list').html('');
        $('#ciu1_' + idm).val(null).trigger('change');
    }).change();

    $('.selnews1').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#news1_' + lang).find(':selected').val();
        var text = $('#news1_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddn .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsnews1[]" value="' + val + '"></div></li>');
            $('#news1_' + lang).val(null).trigger('change');
        }
    });
    $('.ddn').nestable({
        group: 1
    });

    $('.selprom1').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#prom1_' + lang).find(':selected').val();
        var text = $('#prom1_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddpr .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsprom1[]" value="' + val + '"></div></li>');
            $('#prom1_' + lang).val(null).trigger('change');
        }
    });
    $('.ddpr').nestable({
        group: 1
    });

    $('.selciu1').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#ciu1_' + lang).find(':selected').val();
        var text = $('#ciu1_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddc .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsciu1[]" value="' + val + '"></div></li>');
            $('#ciu1_' + lang).val(null).trigger('change');
        }
    });
    $('.ddc').nestable({
        group: 1
    });

    $('#form1').submit(function(e) {
        e.preventDefault();
        // if ($(this).valid()) {
            $('.progess').html('<div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-info label-icon"></i> ' + mailchimpMens1 + '</div>');
            $.ajax({
                type: "GET",
                url: "send.php?"+$(this).serialize(),
                cache: false
            }).done(function( data ) {
                if (data == 'lista') {
                    $('.progess').html('<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-exclamation label-icon"></i> ' + newsletterMens3 + '</div>');
                }
                if (data == 'ok') {
                    $('.progess').html('<div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-check label-icon"></i> ' + mailchimpmens2 + '</div>');
                }
            });
        // }
    });

    $('#lang2').change(function(e) {
        var idm = $(this).val();
        $('.noticias2').hide();
        $('#news2_' + idm).show();
        $('.ddn2 .dd-list').html('');
        $('#news2_' + idm).val(null).trigger('change');

        $('.promociones2').hide();
        $('#prom2_' + idm).show();
        $('.ddpr2 .dd-list').html('');
        $('#prom2_' + idm).val(null).trigger('change');

        $('.ciudades2').hide();
        $('#ciu2_' + idm).show();
        $('.ddc2 .dd-list').html('');
        $('#ciu2_' + idm).val(null).trigger('change');
    }).change();

    $('.selnews2').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#news2_' + lang).find(':selected').val();
        var text = $('#news2_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddn2 .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsnews2[]" value="' + val + '"></div></li>');
            $('#news2_' + lang).val(null).trigger('change');
        }
    });
    $('.ddn2').nestable({
        group: 1
    });

    $('.selprom2').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#prom2_' + lang).find(':selected').val();
        var text = $('#prom2_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddpr2 .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsprom2[]" value="' + val + '"></div></li>');
            $('#prom2_' + lang).val(null).trigger('change');
        }
    });
    $('.ddpr2').nestable({
        group: 1
    });

    $('.selciu2').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#ciu2_' + lang).find(':selected').val();
        var text = $('#ciu2_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddc2 .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsciu2[]" value="' + val + '"></div></li>');
            $('#ciu2_' + lang).val(null).trigger('change');
        }
    });
    $('.ddc2').nestable({
        group: 1
    });

    $('#form2').submit(function(e) {
        e.preventDefault();
        // if ($(this).valid()) {
            $('.progess').html('<div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-info label-icon"></i> ' + mailchimpMens1 + '</div>');
            $.ajax({
                type: "GET",
                url: "send.php?"+$(this).serialize(),
                cache: false
            }).done(function( data ) {
                if (data == 'lista') {
                    $('.progess').html('<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-exclamation label-icon"></i> ' + newsletterMens3 + '</div>');
                }
                if (data == 'ok') {
                    $('.progess').html('<div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-check label-icon"></i> ' + mailchimpmens2 + '</div>');
                }
            });
        // }
    });

    $('#lang3').change(function(e) {
        var idm = $(this).val();
        $('.noticias3').hide();
        $('#news3_' + idm).show();
        $('.ddn3 .dd-list').html('');
        $('#news3_' + idm).val(null).trigger('change');

        $('.promociones3').hide();
        $('#prom3_' + idm).show();
        $('.ddpr3 .dd-list').html('');
        $('#prom3_' + idm).val(null).trigger('change');

        $('.ciudades3').hide();
        $('#ciu3_' + idm).show();
        $('.ddn3 .dd-list').html('');
        $('#ciu3_' + idm).val(null).trigger('change');
    }).change();

    $('.selnews3').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#news3_' + lang).find(':selected').val();
        var text = $('#news3_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddn3 .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsnews3[]" value="' + val + '"></div></li>');
            $('#news3_' + lang).val(null).trigger('change');
        }
    });
    $('.ddn3').nestable({
        group: 1
    });

    $('.selprom3').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#prom3_' + lang).find(':selected').val();
        var text = $('#prom3_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddpr3 .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsprom3[]" value="' + val + '"></div></li>');
            $('#prom3_' + lang).val(null).trigger('change');
        }
    });
    $('.ddpr3').nestable({
        group: 1
    });

    $('.selciu3').click(function(e) {
        var lang = $(this).data('lang');
        var val = $('#ciu3_' + lang).find(':selected').val();
        var text = $('#ciu3_' + lang).find(':selected').text();
        if (val != '') {
            $('.ddc3 .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsciu3[]" value="' + val + '"></div></li>');
            $('#ciu3_' + lang).val(null).trigger('change');
        }
    });
    $('.ddc3').nestable({
        group: 1
    });

    $('#form3').submit(function(e) {
        e.preventDefault();
        // if ($(this).valid()) {
            $('.progess').html('<div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-info label-icon"></i> ' + mailchimpMens1 + '</div>');
            $.ajax({
                type: "GET",
                url: "send.php?"+$(this).serialize(),
                cache: false
            }).done(function( data ) {
                if (data == 'lista') {
                    $('.progess').html('<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-exclamation label-icon"></i> ' + newsletterMens3 + '</div>');
                }
                if (data == 'ok') {
                    $('.progess').html('<div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert"><i class="fa-regular fa-circle-check label-icon"></i> ' + mailchimpmens2 + '</div>');
                }
            });
        // }
    });

    $("#schedule1").change(function(e){
        $("#schedule_ct1").attr("disabled",!$("#schedule1").prop('checked'));
    });

    $("#schedule2").change(function(e){
        $("#schedule_ct2").attr("disabled",!$("#schedule2").prop('checked'));
    });

    $("#schedule3").change(function(e){
        $("#schedule_ct3").attr("disabled",!$("#schedule3").prop('checked'));
    });

    // $('.datetimepicker').datetimepicker({
    //     lang: AppLang,
    //     format:'d-m-Y H:i',
    //     step: 15,
    // });
    </script>

</body>
</html>
