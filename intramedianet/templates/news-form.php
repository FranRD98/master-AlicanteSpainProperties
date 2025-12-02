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

// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("name_en_tmpl", true, "text", "", "", "", "");
$formValidation->addField("name_es_tmpl", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_templates = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_templates);
// Register triggers
$ins_templates->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_templates->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_templates->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");

// Add columns
$ins_templates->setTable("templates");
$ins_templates->addColumn("name_en_tmpl", "STRING_TYPE", "POST", "name_en_tmpl");
$ins_templates->addColumn("name_es_tmpl", "STRING_TYPE", "POST", "name_es_tmpl");
$ins_templates->addColumn("week_tmpl", "CHECKBOX_1_0_TYPE", "POST", "week_tmpl", "0");
foreach($languages as $value) {
  $ins_templates->addColumn("subject_".$value."_tmpl", "STRING_TYPE", "POST", "subject_".$value."_tmpl");
  $ins_templates->addColumn("content_".$value."_tmpl", "STRING_TYPE", "POST", "content_".$value."_tmpl");
}
$ins_templates->setPrimaryKey("id_tmpl", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_templates = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_templates);
// Register triggers
$upd_templates->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_templates->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_templates->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");

// Add columns
$upd_templates->setTable("templates");
$upd_templates->addColumn("name_en_tmpl", "STRING_TYPE", "POST", "name_en_tmpl");
$upd_templates->addColumn("name_es_tmpl", "STRING_TYPE", "POST", "name_es_tmpl");
$upd_templates->addColumn("week_tmpl", "CHECKBOX_1_0_TYPE", "POST", "week_tmpl");
foreach($languages as $value) {
  $upd_templates->addColumn("subject_".$value."_tmpl", "STRING_TYPE", "POST", "subject_".$value."_tmpl");
  $upd_templates->addColumn("content_".$value."_tmpl", "STRING_TYPE", "POST", "content_".$value."_tmpl");
}
$upd_templates->setPrimaryKey("id_tmpl", "NUMERIC_TYPE", "GET", "id_tmpl");

// Make an instance of the transaction object
$del_templates = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_templates);
// Register triggers
$del_templates->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_templates->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_templates->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_templates->setTable("templates");
$del_templates->setPrimaryKey("id_tmpl", "NUMERIC_TYPE", "GET", "id_tmpl");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstemplates = $tNGs->getRecordset("templates");
$row_rstemplates = mysqli_fetch_assoc($rstemplates);
$totalRows_rstemplates = mysqli_num_rows($rstemplates);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

  <link rel="stylesheet" href="/intramedianet/includes/assets/css/bootstrap-tagsinput.css">

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_templates" class="id_field" value="<?php if(isset($row_rstemplates['kt_pk_templates'])) echo KT_escapeAttribute($row_rstemplates['kt_pk_templates']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-file-lines"></i> <?php if (@$_GET['id_tmpl'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Landing Page'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_tmpl'] == "") { ?>
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

                    <div class="col-lg-9">
                        <div class="card position-relative">
                            <div class="card-body">
                                <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_collaborators_categories", "name_en_tmpl" ) !='' ) { ?>has-error
                                    <?php } ?>">
                                    <label for="name_en_tmpl" class="form-label required">
                                        <?php __('Nombre'); ?>:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" height="15"></span>
                                        <input type="text" name="name_en_tmpl" id="name_en_tmpl" value="<?php echo KT_escapeAttribute($row_rstemplates['name_en_tmpl']); ?>" size="32" maxlength="255" class="form-control required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("properties_collaborators_categories", "name_en_tmpl"); ?>
                                </div>
                                <div class="<?php if($tNGs->displayFieldError(" properties_collaborators_categories", "name_es_tmpl" ) !='' ) { ?>has-error
                                    <?php } ?>">
                                    <label for="name_es_tmpl" class="form-label required">
                                        <?php __('Nombre'); ?>:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" height="15"></span>
                                        <input type="text" name="name_es_tmpl" id="name_es_tmpl" value="<?php echo KT_escapeAttribute($row_rstemplates['name_es_tmpl']); ?>" size="32" maxlength="255" class="form-control required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("properties_collaborators_categories", "name_es_tmpl"); ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card position-relative">
                            <div class="card-body">
                                <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                    <input type="checkbox" name="week_tmpl" id="week_tmpl" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rstemplates['week_tmpl']),"1"))) {echo "checked" ;} ?>>
                                    <label class="form-check-label" for="week_tmpl">
                                        <?php __('Email semanal'); ?></label>
                                    <?php echo $tNGs->displayFieldError("news", "week_tmpl"); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Plantilla'); ?></h4>
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

                                        <div class="mb-4">
                                            <label for="subject_<?php echo $value; ?>_tmpl" class="form-label"><?php __('Asunto'); ?>:</label>
                                            <input type="text" name="subject_<?php echo $value; ?>_tmpl" id="subject_<?php echo $value; ?>_tmpl" value="<?php echo KT_escapeAttribute($row_rstemplates['subject_'.$value.'_tmpl']); ?>" size="32" maxlength="255" class="form-control required" required>
                                            <?php echo $tNGs->displayFieldError("news", "subject_".$value."_tmpl"); ?>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="subject_"
                                                            data-fields-suf="_tmpl"
                                                            data-tab="title"
                                                        ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                                <br>
                                            <?php endif ?>
                                        </div>

                                        <br class="d-md-none">
                                        <br class="d-md-none">

                                        <textarea name="content_<?php echo $value; ?>_tmpl" id="content_<?php echo $value; ?>_tmpl" rows="5" class="wysiwyg mt-5"><?php echo KT_escapeAttribute($row_rstemplates['content_'.$value.'_tmpl']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("news", "content_".$lang_adm."__tmpl"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end mb-4">
                                            <?php foreach ($languages as $langx): ?>
                                                <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                        data-from="<?php echo $value; ?>"
                                                        data-to="<?php echo $langx; ?>"
                                                        data-fields-pref="content_"
                                                        data-fields-suf="_tmpl"
                                                        data-tab="conten"
                                                    ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            </div>
                                            <br>
                                        <?php endif ?>

                                        <br>

                                        <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4" role="alert">
                                            <i class="fa-regular fa-circle-info label-icon"></i><?php __('Inserte {{PROPERTY}} para mostrar las propiedad o propiedades'); ?><br><?php __('insert_client_mail'); ?>
                                        </div>

                                    </div>
                                    <?php } ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var idtemplates = '<?php echo $templates_id; ?>';
    </script>

    <script src="/intramedianet/templates/_js/templates-form.js" type="text/javascript"></script>

</body>
</html>
