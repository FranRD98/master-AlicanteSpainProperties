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
$formValidation->addField("image_ban", true, "", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand
function Trigger_FileDelete($tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../../media/images/banner/");
  $deleteObj->setDbFieldName("image_ban");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand
function Trigger_ImageUpload($tNG) {
  global $actBannerWidht, $actBannerHeight;
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("image_ban");
  $uploadObj->setDbFieldName("image_ban");
  $uploadObj->setFolder("../../media/images/banner/");
  $uploadObj->setResize("false", $actBannerWidht, $actBannerHeight);
  $uploadObj->setMaxSize(0);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("custom");
  $uploadObj->setRenameRule("banner_{id_ban}.{KT_ext}");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand
function Trigger_SetOrderColumn($tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("orden_ban");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache($tNG) {
    return array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
}
//end removeCache trigger

// Make an insert transaction instance
$ins_banners = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_banners); 
// Register triggers
$ins_banners->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_banners->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_banners->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_banners->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
//$ins_banners->registerTrigger("AFTER", "removeCache", 10);
$ins_banners->registerTrigger("AFTER", "Trigger_ImageUpload", 97);


// Add columns
$ins_banners->setTable("banners");
$ins_banners->addColumn("image_ban", "FILE_TYPE", "FILES", "image_ban");
 
foreach($languages as $value) {
  $ins_banners->addColumn("caption_".$value."_ban", "STRING_TYPE", "POST", "caption_".$value."_ban");
  $ins_banners->addColumn("description_".$value."_ban", "STRING_TYPE", "POST", "description_".$value."_ban");
  $ins_banners->addColumn("url_".$value."_ban", "STRING_TYPE", "POST", "url_".$value."_ban");
}
$ins_banners->setPrimaryKey("id_ban", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_banners = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_banners);
// Register triggers
$upd_banners->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_banners->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_banners->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_banners->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
$upd_banners->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$upd_banners->setTable("banners");
$upd_banners->addColumn("image_ban", "FILE_TYPE", "FILES", "image_ban");
foreach($languages as $value) {
  $upd_banners->addColumn("caption_".$value."_ban", "STRING_TYPE", "POST", "caption_".$value."_ban");
  $upd_banners->addColumn("description_".$value."_ban", "STRING_TYPE", "POST", "description_".$value."_ban");
  $upd_banners->addColumn("url_".$value."_ban", "STRING_TYPE", "POST", "url_".$value."_ban");
}
$upd_banners->setPrimaryKey("id_ban", "NUMERIC_TYPE", "GET", "id_ban");

// Make an instance of the transaction object
$del_banners = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_banners);
// Register triggers
$del_banners->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_banners->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_banners->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_banners->registerTrigger("AFTER", "Trigger_FileDelete", 98);
$del_banners->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$del_banners->setTable("banners");
$del_banners->setPrimaryKey("id_ban", "NUMERIC_TYPE", "GET", "id_ban");

// Execute all the registered transactions
$tNGs->executeTransactions();

//var_dump($tNGs); die;
// Get the transaction recordset
$rsnews = $tNGs->getRecordset("banners");
$row_rsnews = mysqli_fetch_assoc($rsnews);
$totalRows_rsnews = mysqli_num_rows($rsnews);
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
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-images"></i> <?php if (isset($_GET['id_ban']) && $_GET['id_ban'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Banner'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (!isset($_GET['id_ban']) || $_GET['id_ban'] == "") { ?>
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
                    <?php if ($actBannerTxt == 0 && $actBannerDesc == 0 && $actBannerUrl == 0): ?>
                        <div class="col-lg-12">
                    <?php else: ?>
                        <div class="col-lg-6">
                    <?php endif ?>
                        <div class="card position-relative">
                            <div class="card-body">

                                <div class="form-group <?php if($tNGs->displayFieldError("banners", "image_ban") != '') { ?>error<?php } ?>">
                                    <label for="image_ban" class="form-label"><?php __('Imagen'); ?>:</label>
                                    <?php if (@$_GET['id_ban'] != "") { ?>
                                    <img src="/media/images/banner/<?php echo KT_escapeAttribute($row_rsnews['image_ban']); ?>?<?php echo time(); ?>" alt="" class="rounded img-fluid mb-4">
                                    <?php } ?>
                                    <input type="file" name="image_ban" id="image_ban" size="32" class="form-control <?php if (@$_GET['id_ban'] == ""): ?>required<?php endif ?>" <?php if (@$_GET['id_ban'] == ""): ?>required<?php endif ?>/>
                                    <div class="invalid-feedback">
                                        <?php __('Este campo es obligatorio.'); ?>
                                    </div>
                                    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-4" role="alert">
                                        <i class="fa-regular fa-info-circle label-icon"></i> <?php echo '<b>' . $lang['Las imágenes han de medir:'] . '</b> ' . $actBannerWidht . 'x' . $actBannerHeight . 'px'; ?>
                                    </div>
                                    <?php echo $tNGs->displayFieldError("banners", "image_ban"); ?>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <?php if($actBannerTxt == 1 || $actBannerUrl == 1 || $actBannerDesc == 1) { ?>
                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Textos'); ?></h4>
                                </div>
                                <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <?php foreach($languages as $value) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#banner-<?php echo $value; ?>" role="tab" aria-selected="true">
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
                                            <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#banner-<?php echo $value; ?>" role="tab" aria-selected="true">
                                                <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>
                                    <div class="tab-pane <?php if($value == $language) { ?>active<?php } ?>" id="banner-<?php echo $value; ?>" role="tabpanel">

                                        <?php if($actBannerTxt == 1) { ?>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("banners", "caption_".$value."_ban") != '') { ?>error<?php } ?>">
                                          <label for="caption_<?php echo $value; ?>_ban" class="form-label"><?php __('Texto'); ?>:</label>
                                          <input type="text" maxlength="55" name="caption_<?php echo $value; ?>_ban" id="caption_<?php echo $value; ?>_ban" value="<?php echo KT_escapeAttribute($row_rsnews['caption_'.$value.'_ban']); ?>" size="32" class="form-control">
                                          <?php if ($traduccion_textos == 1): ?>
                                              <div class="float-end mb-4">
                                              <?php foreach ($languages as $langx): ?>
                                                  <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                          data-from="<?php echo $value; ?>"
                                                          data-to="<?php echo $langx; ?>"
                                                          data-fields-pref="caption_"
                                                          data-fields-suf="_ban"
                                                          data-tab="banner"
                                                      ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                  <?php endif ?>
                                              <?php endforeach ?>
                                              </div>
                                              <br>
                                          <?php endif ?>
                                          <?php echo $tNGs->displayFieldError("banners", "caption_".$value."_ban"); ?>
                                        </div>

                                        <?php } ?>

                                        <?php if($actBannerDesc == 1) { ?>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("banners", "description_".$value."_ban") != '') { ?>error<?php } ?>">
                                          <label for="description_<?php echo $value; ?>_ban" class="form-label"><?php __('Descipción'); ?>:</label>
                                          <textarea maxlength="155" name="description_<?php echo $value; ?>_ban" id="description_<?php echo $value; ?>_ban" cols="30" rows="10" class="form-control"><?php echo KT_escapeAttribute($row_rsnews['description_'.$value.'_ban']); ?></textarea>
                                          <?php if ($traduccion_textos == 1): ?>
                                              <div class="float-end mb-4">
                                              <?php foreach ($languages as $langx): ?>
                                                  <?php if ($langx != $value): ?>
                                                      <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                          data-from="<?php echo $value; ?>"
                                                          data-to="<?php echo $langx; ?>"
                                                          data-fields-pref="description_"
                                                          data-fields-suf="_ban"
                                                          data-tab="banner"
                                                      ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                  <?php endif ?>
                                              <?php endforeach ?>
                                              </div>
                                              <br>
                                          <?php endif ?>
                                            <?php echo $tNGs->displayFieldError("banners", "description_".$value."_ban"); ?>
                                        </div>

                                        <?php } ?>

                                        <?php if($actBannerUrl == 1) { ?>

                                        <div class="form-group <?php if($tNGs->displayFieldError("banners", "url_".$value."_ban") != '') { ?>error<?php } ?>">
                                          <label for="url_<?php echo $value; ?>_ban" class="form-label"><?php __('URL'); ?>:</label>
                                          <input type="url" name="url_<?php echo $value; ?>_ban" id="url_<?php echo $value; ?>_ban" value="<?php echo KT_escapeAttribute($row_rsnews['url_'.$value.'_ban']); ?>" size="32" maxlength="255" class="form-control url" placeholder="https://">
                                          <div class="invalid-feedback">
                                              <?php __('Por favor, escribe una URL válida.'); ?>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("banners", "url_".$value."_ban"); ?>
                                        </div>

                                        <?php } ?>

                                    </div>
                                    <?php } ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>
                        <?php }  ?>

                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="kt_pk_banners" class="id_field" value="<?php if(isset($row_rsnews['kt_pk_banners'])) echo KT_escapeAttribute($row_rsnews['kt_pk_banners']); ?>" />

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
