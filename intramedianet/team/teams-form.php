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
$restrict->addLevel("6");
$restrict->addLevel("5");
$restrict->Execute();
//End Restrict Access To Page

if (!isset($_GET['id_tms'])) {

  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'teams'";
  $rsNextIncrement = mysqli_query($inmoconn, $query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

  $teams_id = $row_rsNextIncrement['Auto_increment'];

} else {

  $teams_id = $_GET['id_tms'];

}

$query_rsImages = "SELECT * FROM teams_fotos WHERE noticia_img = '".$teams_id."' ORDER BY orden_img";
$rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
$row_rsImages = mysqli_fetch_assoc($rsImages);
$totalRows_rsImages = mysqli_num_rows($rsImages);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_tms", true, "text", "", "", "", "");
$formValidation->addField("email_tms", true, "text", "email", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand
function Trigger_SetOrderColumn(&$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("order_tms");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

if (isset($_POST['idiomas_tms']) && $_POST['idiomas_tms'] != '' ) {
  $_POST['idiomas_tms'] = implode(',', $_POST['idiomas_tms']);
}

// Make an insert transaction instance
$ins_teams = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_teams);
// Register triggers
$ins_teams->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_teams->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_teams->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_teams->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
// Add columns
$ins_teams->setTable("teams");
$ins_teams->addColumn("nombre_tms", "STRING_TYPE", "POST", "nombre_tms");
$ins_teams->addColumn("telefono_tms", "STRING_TYPE", "POST", "telefono_tms");
$ins_teams->addColumn("email_tms", "STRING_TYPE", "POST", "email_tms");
$ins_teams->addColumn("idiomas_tms", "STRING_TYPE", "POST", "idiomas_tms");
$ins_teams->addColumn("activate_tms", "CHECKBOX_1_0_TYPE", "POST", "activate_tms", "1");
foreach($languages as $value) {
    $ins_teams->addColumn("cargo_".$value."_tms", "STRING_TYPE", "POST", "cargo_".$value."_tms");
    $ins_teams->addColumn("bio_".$value."_tms", "STRING_TYPE", "POST", "bio_".$value."_tms");
}
$ins_teams->setPrimaryKey("id_tms", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_teams = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_teams);
// Register triggers
$upd_teams->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_teams->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_teams->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// $upd_teams->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
// Add columns
$upd_teams->setTable("teams");
$upd_teams->addColumn("nombre_tms", "STRING_TYPE", "POST", "nombre_tms");
$upd_teams->addColumn("telefono_tms", "STRING_TYPE", "POST", "telefono_tms");
$upd_teams->addColumn("email_tms", "STRING_TYPE", "POST", "email_tms");
$upd_teams->addColumn("idiomas_tms", "STRING_TYPE", "POST", "idiomas_tms");
$upd_teams->addColumn("activate_tms", "CHECKBOX_1_0_TYPE", "POST", "activate_tms");
foreach($languages as $value) {
    $upd_teams->addColumn("cargo_".$value."_tms", "STRING_TYPE", "POST", "cargo_".$value."_tms");
    $upd_teams->addColumn("bio_".$value."_tms", "STRING_TYPE", "POST", "bio_".$value."_tms");
}
$upd_teams->setPrimaryKey("id_tms", "NUMERIC_TYPE", "GET", "id_tms");

// Make an instance of the transaction object
$del_teams = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_teams);
// Register triggers
$del_teams->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_teams->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_teams->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_teams->setTable("teams");
$del_teams->setPrimaryKey("id_tms", "NUMERIC_TYPE", "GET", "id_tms");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsteams = $tNGs->getRecordset("teams");
$row_rsteams = mysqli_fetch_assoc($rsteams);
$totalRows_rsteams = mysqli_num_rows($rsteams);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-address-card"></i> <?php if (@$_GET['id_tms'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Equipo'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_tms'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="btn btn-success btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?></span></button>
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                                <button type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 btn btn-danger btn-sm"><i class="fa-regular fa-trash-can fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Delete_FB"); ?></span></button>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-chevron-left fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>
                        </div>
                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <div class="row">
                    <div class="col-lg-6">

                        <div class="card position-relative">
                            <div class="card-body">

                                <div class="mb-4">
                                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                                        <input type="checkbox" name="activate_tms" id="activate_tms" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsteams['activate_tms']),"1"))) {echo "checked";} ?>>
                                        <label class="form-check-label" for="activate_tms"><?php __('Mostrar en la web'); ?></label>
                                        <?php echo $tNGs->displayFieldError("teams", "activate_tms"); ?>
                                    </div>
                                </div>

                                <div class="mb-3 <?php if($tNGs->displayFieldError("teams", "nombre_tms") != '') { ?>has-error<?php } ?>">
                                    <label for="nombre_tms" class="form-label"><?php __('Nombre'); ?></label>
                                    <input type="text" name="nombre_tms" id="nombre_tms" value="<?php echo KT_escapeAttribute($row_rsteams['nombre_tms']); ?>" size="32" maxlength="255" class="form-control required" required>
                                    <div class="invalid-feedback">
                                        <?php __('Este campo es obligatorio.'); ?>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("teams", "nombre_tms"); ?>
                                </div>

                                <div class="mb-3 <?php if($tNGs->displayFieldError("teams", "telefono_tms") != '') { ?>has-error<?php } ?>">
                                    <label for="telefono_tms" class="form-label"><?php __('Teléfono'); ?></label>
                                    <input type="text" name="telefono_tms" id="telefono_tms" value="<?php echo KT_escapeAttribute($row_rsteams['telefono_tms']); ?>" size="32" maxlength="255" class="form-control required" required>
                                    <div class="invalid-feedback">
                                        <?php __('Este campo es obligatorio.'); ?>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("teams", "telefono_tms"); ?>
                                </div>

                                <div class="mb-3 <?php if($tNGs->displayFieldError("teams", "email_tms") != '') { ?>has-error<?php } ?>">
                                    <label for="email_tms" class="form-label"><?php __('Email'); ?></label>
                                    <input type="email" name="email_tms" id="email_tms" value="<?php echo KT_escapeAttribute($row_rsteams['email_tms']); ?>" size="32" maxlength="255" class="form-control required" required>
                                    <div class="invalid-feedback">
                                        <?php __('Este campo es obligatorio.'); ?>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("teams", "email_tms"); ?>
                                </div>



                                <div class="form-group <?php if($tNGs->displayFieldError("teams", "idiomas_tms") != '') { ?>has-error<?php } ?>">
                                    <?php 
                                    $lang_team = array();
                                    if(isset($row_rsteams['idiomas_tms']))
                                        $lang_team = explode(",", $row_rsteams['idiomas_tms']); 
                                    ?>
                                    <label for="idiomas_tms[]" class="form-label"><?php __('Idiomas'); ?></label>
                                    <select name="idiomas_tms[]" id="idiomas_tms" class="select2" multiple="multiple">
                                      <?php
                                        if ($lang_adm == 'es') {
                                            $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco', 'ro' => 'Rumano', 'ua' => 'Ucraniano');
                                        } else {
                                            $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish', 'ro' => 'Romanian', 'ua' => 'Ukrainian');
                                        }
                                      foreach($idiomas as $key => $value) { ?>
                                          <option value="<?php echo $key; ?>" <?php if (in_array($key,$lang_team)) {echo "SELECTED";} ?>><?php echo $value; ?></option>
                                      <?php } ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("teams", "idiomas_tms"); ?>
                                </div>

                            </div>
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Cargo'); ?></h4>
                                </div>
                                <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <?php foreach($languages as $value) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langcargo-<?php echo $value; ?>" role="tab" aria-selected="true">
                                                    <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">

                                <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                                    <?php foreach($languages as $value) { ?>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langcargo-<?php echo $value; ?>" role="tab" aria-selected="true">
                                                <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>
                                    <div class="tab-pane <?php if($value == $language) { ?>active<?php } ?>" id="langcargo-<?php echo $value; ?>" role="tabpanel">
                                        <textarea name="cargo_<?php echo $value; ?>_tms" id="cargo_<?php echo $value; ?>_tms" rows="5" class="form-control"><?php echo KT_escapeAttribute($row_rsteams['cargo_'.$value.'_tms']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("teams", "cargo_".$lang_adm."_tms"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end mb-4">
                                            <?php foreach ($languages as $langx): ?>
                                                <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                        data-from="<?php echo $value; ?>"
                                                        data-to="<?php echo $langx; ?>"
                                                        data-fields-pref="cargo_"
                                                        data-fields-suf="_tms"
                                                        data-tab="cargo"
                                                    ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            </div>
                                            <br>
                                        <?php endif ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Descripción'); ?></h4>
                                </div>
                                <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <?php foreach($languages as $value) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langbio-<?php echo $value; ?>" role="tab" aria-selected="true">
                                                    <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">

                                <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                                    <?php foreach($languages as $value) { ?>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langbio-<?php echo $value; ?>" role="tab" aria-selected="true">
                                                <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>
                                    <div class="tab-pane <?php if($value == $language) { ?>active<?php } ?>" id="langbio-<?php echo $value; ?>" role="tabpanel">
                                        <textarea name="bio_<?php echo $value; ?>_tms" id="bio_<?php echo $value; ?>_tms" rows="5" class="form-control"><?php echo KT_escapeAttribute($row_rsteams['bio_'.$value.'_tms']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("teams", "bio_".$lang_adm."_tms"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end mb-4">
                                            <?php foreach ($languages as $langx): ?>
                                                <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                        data-from="<?php echo $value; ?>"
                                                        data-to="<?php echo $langx; ?>"
                                                        data-fields-pref="bio_"
                                                        data-fields-suf="_tms"
                                                        data-tab="bio"
                                                    ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            </div>
                                            <br>
                                        <?php endif ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Fotografía'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <small><i class="fa-regular fa-image fa-fw"></i> <?php __('Extensiones permitidas'); ?>: jpg, gif <?php __('y'); ?> png.</small>
                                <br>
                                <small><i class="fa-regular fa-asterisk text-danger fa-fw"></i> <?php __('No se han añadido los textos para el SEO'); ?> </small>
                                <br>
                                <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de las fotos, arrastre y suelte la fotos en la ubicación deseada'); ?>.</small>

                                <hr>

                                <div id="img-order-loading"></div>

                                <ul class="thumbnails clearfix nested-sortable" id="images-list">

                                <?php if($totalRows_rsImages > 0) { ?>

                                <?php do { ?>

                                <?php if($row_rsImages['imagen_img'] != '') { ?>

                                <li class="pull-left" id="order_<?php echo $row_rsImages['id_img'] ?>" data-id="<?php echo $row_rsImages['id_img'] ?>">

                                <div class="img-thumbnail pull-left">
                                  <?php echo showThumbnail($row_rsImages['imagen_img'], '/media/images/teams/', 150, 100); ?>
                                  <p class="text-center"><a href="#" class="btn btn-success btn-sm edit-alt" data-id="<?php echo $row_rsImages['id_img'] ?>"><i class="fa-regular fa-pencil"></i></a> <a href="images_del.php" data-id="<?php echo $row_rsImages['id_img'] ?>" class="btn btn-danger btn-sm del-img"><i class="fa-regular fa-trash-can"></i></a>

                                    <?php $altDisp = false; ?>

                                    <?php

                                      foreach($languages as $value) {

                                        if($row_rsImages['alt_'.$value.'_img'] == '') {

                                          $altDisp = true;

                                        }
                                      }
                                    ?>


                                    <?php if($altDisp == true) { ?>
                                    <i class="fa-regular fa-asterisk text-danger"></i>
                                    <?php } ?></p>
                                </div>

                                </li>

                                <?php } ?>

                                <?php } while ($row_rsImages = mysqli_fetch_assoc($rsImages)); ?>

                                <?php } ?>

                                </ul>

                                <hr style="clear: both">

                                <div class="multi_images"></div>


                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="kt_pk_teams" class="id_field" value="<?php if(isset($row_rsteams['kt_pk_teams'])) echo KT_escapeAttribute($row_rsteams['kt_pk_teams']); ?>" />

    </form>

<?php include("../includes/inc.footer.php"); ?>

<script>
var idTeams = '<?php echo $teams_id; ?>';
</script>

<script src="/intramedianet/team/_js/teams-form.js" type="text/javascript"></script>

<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar texto alternativo'); ?></h5>
                <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body bg-light">
                <div class="loadingfrm"></div>
            </div>
            <div class="modal-footer bg-soft-primary">
                <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>
