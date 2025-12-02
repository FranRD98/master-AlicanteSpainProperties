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

if (!isset($_GET['id_nws'])) {

  
  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'news'";
  $rsNextIncrement = mysqli_query($inmoconn,$query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

  $news_id = $row_rsNextIncrement['Auto_increment'];

} else {

  $news_id = $_GET['id_nws'];

}


$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct FROM news_categories WHERE type_ct = 2 ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn,$query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);


$query_rsImages = "SELECT * FROM news_fotos WHERE noticia_img = '".$news_id."' ORDER BY orden_img";
$rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
$row_rsImages = mysqli_fetch_assoc($rsImages);
$totalRows_rsImages = mysqli_num_rows($rsImages);


$query_rsVideos = "SELECT * FROM news_videos WHERE news_vid = '".$news_id."' ORDER BY order_vid";
$rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
$row_rsVideos = mysqli_fetch_assoc($rsVideos);
$totalRows_rsVideos = mysqli_num_rows($rsVideos);

// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("categoria_nws", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields($tNG) {
  $tNG->addColumn("type_nws", "NUMERIC_TYPE", "EXPRESSION", "2");
  return $tNG->getError();
}
//end addFields trigger

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("news_fotos");
  $tblDelObj->setFieldName("noticia_img");
  $tblDelObj->addFile("{imagen_img}", "../../media/images/news/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail trigger

//start Trigger_DeleteDetail3 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail3($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("news_videos");
  $tblDelObj->setFieldName("news_vid");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail3 trigger

//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("news_news_towns");
  $mtm->setPkName("news");
  $mtm->setFkName("town");
  $mtm->setFkReference("mtm");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany trigger

function replaceTags($startPoint, $endPoint, $newText, $source) {
    return preg_replace('@('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')@si', '$1'.$newText.'$3', $source);
}

//start Trigger_UpdateLLMS trigger
//remove this line if you want to edit the code by hand
function Trigger_UpdateLLMS(&$tNG) {

  include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

  global $database_inmoconn, $inmoconn, $language, $languages, $actCostas;

  $query_rsPages = "SELECT * FROM news WHERE type_nws = 2 AND llms_name_nws != '' AND llms_url_nws != '' AND llms_descripcion_nws != ''";
  $rsPages = mysqli_query($inmoconn,$query_rsPages) or die(mysqli_error());
  $row_rsPages = mysqli_fetch_assoc($rsPages);
  $totalRows_rsPages = mysqli_num_rows($rsPages);

  $newText = "";

  if ($totalRows_rsPages > 0) {
      do {

        $newText .= "\n- [" . $row_rsPages['llms_name_nws'] . "](" . $row_rsPages['llms_url_nws'] . "): \n";
        $newText .= $row_rsPages['llms_descripcion_nws'];

      } while ($row_rsPages = mysqli_fetch_assoc($rsPages));
  }

  $filename = $_SERVER["DOCUMENT_ROOT"] . '/llms.txt';
  $llms = file_get_contents($filename);

  $llms = replaceTags('## Páginas','---', $newText . "\n", $llms);
  file_put_contents($filename, $llms);

  return true;
}
//end Trigger_UpdateLLMS trigger

// Make an insert transaction instance
$ins_news = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_news);
// Register triggers
$ins_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_news->registerTrigger("BEFORE", "addFields", 10);
$ins_news->registerTrigger("AFTER", "Trigger_UpdateLLMS", 97);
// $ins_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// Add columns
$ins_news->setTable("news");
$ins_news->addColumn("llms_name_nws", "STRING_TYPE", "POST", "llms_name_nws");
$ins_news->addColumn("llms_url_nws", "STRING_TYPE", "POST", "llms_url_nws");
$ins_news->addColumn("llms_descripcion_nws", "STRING_TYPE", "POST", "llms_descripcion_nws");
// $ins_news->addColumn("categoria_nws", "NUMERIC_TYPE", "POST", "categoria_nws");
foreach($languages as $value) {
  $ins_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $ins_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $ins_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $ins_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $ins_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
}
$ins_news->setPrimaryKey("id_nws", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_news = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_news);
// Register triggers
$upd_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_news->registerTrigger("AFTER", "Trigger_UpdateLLMS", 97);
// $upd_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// Add columns
$upd_news->setTable("news");
$upd_news->addColumn("llms_name_nws", "STRING_TYPE", "POST", "llms_name_nws");
$upd_news->addColumn("llms_url_nws", "STRING_TYPE", "POST", "llms_url_nws");
$upd_news->addColumn("llms_descripcion_nws", "STRING_TYPE", "POST", "llms_descripcion_nws");
// $upd_news->addColumn("categoria_nws", "NUMERIC_TYPE", "POST", "categoria_nws");
foreach($languages as $value) {
  $upd_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $upd_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $upd_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $upd_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $upd_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
}
$upd_news->setPrimaryKey("id_nws", "NUMERIC_TYPE", "GET", "id_nws");

// Make an instance of the transaction object
$del_news = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_news);
// Register triggers
$del_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_news->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_news->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
$del_news->registerTrigger("BEFORE", "Trigger_DeleteDetail3", 99);
$del_news->registerTrigger("AFTER", "Trigger_UpdateLLMS", 97);
// Add columns
$del_news->setTable("news");
$del_news->setPrimaryKey("id_nws", "NUMERIC_TYPE", "GET", "id_nws");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnews = $tNGs->getRecordset("news");
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

        <input type="hidden" name="kt_pk_news" class="id_field" value="<?php if(isset($row_rsnews['kt_pk_news'])) echo KT_escapeAttribute($row_rsnews['kt_pk_news']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-memo"></i> <?php if (@$_GET['id_nws'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Página'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_nws'] == "") { ?>
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
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Buscadores'); ?></h4>
                                </div>
                                <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <?php foreach($languages as $value) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langseo-<?php echo $value; ?>" role="tab" aria-selected="true">
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
                                            <a class="nav-link <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langseo-<?php echo $value; ?>" role="tab" aria-selected="true">
                                                <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>
                                    <div class="tab-pane <?php if($value == $language) { ?>active<?php } ?>" id="langseo-<?php echo $value; ?>" role="tabpanel">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "titlew_".$value."_nws") != '') { ?>error<?php } ?>">
                                            <label for="titlew_<?php echo $value; ?>_nws" class="form-label"><?php __('Title'); ?>:</label>
                                                <input type="text" maxlength="55" name="titlew_<?php echo $value; ?>_nws" id="titlew_<?php echo $value; ?>_nws" value="<?php echo KT_escapeAttribute($row_rsnews['titlew_'.$value.'_nws']); ?>" size="32" class="form-control textcountseo">
                                                <?php if ($traduccion_textos == 1): ?>
                                                    <div class="float-end mb-4">
                                                    <?php foreach ($languages as $langx): ?>
                                                        <?php if ($langx != $value): ?>
                                                            <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                                data-from="<?php echo $value; ?>"
                                                                data-to="<?php echo $langx; ?>"
                                                                data-fields-pref="titlew_"
                                                                data-fields-suf="_nws"
                                                                data-tab="seo"
                                                            ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                    </div>
                                                    <br>
                                                <?php endif ?>
                                              <?php echo $tNGs->displayFieldError("news", "titlew_".$value."_nws"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "description_".$value."_nws") != '') { ?>error<?php } ?>">
                                          <label for="description_<?php echo $value; ?>_nws" class="form-label"><?php __('Description'); ?>:</label>
                                              <textarea maxlength="155" name="description_<?php echo $value; ?>_nws" id="description_<?php echo $value; ?>_nws" cols="50" rows="5" class="form-control textcountseo"><?php echo KT_escapeAttribute($row_rsnews['description_'.$value.'_nws']); ?></textarea>
                                              <?php if ($traduccion_textos == 1): ?>
                                                  <div class="float-end mb-4">
                                                  <?php foreach ($languages as $langx): ?>
                                                      <?php if ($langx != $value): ?>
                                                          <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                              data-from="<?php echo $value; ?>"
                                                              data-to="<?php echo $langx; ?>"
                                                              data-fields-pref="description_"
                                                              data-fields-suf="_nws"
                                                              data-tab="seo"
                                                          ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                      <?php endif ?>
                                                  <?php endforeach ?>
                                                  </div>
                                                  <br>
                                              <?php endif ?>
                                            <?php echo $tNGs->displayFieldError("news", "description_".$value."_nws"); ?>
                                        </div>

                                        <div class="<?php if($tNGs->displayFieldError("news", "keywords_".$value."_nws") != '') { ?>error<?php } ?>">
                                          <label for="keywords_<?php echo $value; ?>_nws" class="form-label"><?php __('Keywords'); ?>:</label>
                                              <textarea name="keywords_<?php echo $value; ?>_nws" id="keywords_<?php echo $value; ?>_nws" cols="50" rows="5" class="form-control"><?php echo KT_escapeAttribute($row_rsnews['keywords_'.$value.'_nws']); ?></textarea>
                                              <?php if ($traduccion_textos == 1): ?>
                                                  <div class="float-end">
                                                  <?php foreach ($languages as $langx): ?>
                                                      <?php if ($langx != $value): ?>
                                                          <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                              data-from="<?php echo $value; ?>"
                                                              data-to="<?php echo $langx; ?>"
                                                              data-fields-pref="keywords_"
                                                              data-fields-suf="_nws"
                                                              data-tab="seo"
                                                          ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                      <?php endif ?>
                                                  <?php endforeach ?>
                                                  </div>
                                                  <br>
                                              <?php endif ?>
                                            <?php echo $tNGs->displayFieldError("news", "keywords_".$value."_nws"); ?>
                                        </div>

                                    </div>
                                    <?php } ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Indexación para inteligencia artificial'); ?> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $languageLLMS; ?>.svg" alt="" class="border rounded-circle" height="20"></h4>
                                </div>
                                <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="mb-4">
                                    <label for="llms_name_nws" class="form-label"><?php __('Nombre'); ?>:</label>
                                    <input type="text" name="llms_name_nws" id="llms_name_nws" value="<?php echo KT_escapeAttribute($row_rsnews['llms_name_nws']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("news", "llms_name_nws"); ?>
                                </div>

                                <div class="mb-4">
                                    <label for="llms_url_nws" class="form-label"><?php __('URL'); ?>:</label>
                                    <input type="url" name="llms_url_nws" id="llms_url_nws" value="<?php echo KT_escapeAttribute($row_rsnews['llms_url_nws']); ?>" size="32" maxlength="255" class="form-control url" placeholder="https://">
                                    <?php echo $tNGs->displayFieldError("news", "llms_url_nws"); ?>
                                </div>

                                <div class="<?php if($tNGs->displayFieldError("news", "llms_descripcion_nws") != '') { ?>error<?php } ?>">
                                  <label for="llms_descripcion_nws" class="form-label"><?php __('Descripción'); ?>:</label>
                                      <textarea name="llms_descripcion_nws" id="llms_descripcion_nws" cols="50" rows="5" class="form-control"><?php echo KT_escapeAttribute($row_rsnews['llms_descripcion_nws']); ?></textarea>
                                    <?php echo $tNGs->displayFieldError("news", "llms_descripcion_nws"); ?>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Textos'); ?></h4>
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
                                            <label for="title_<?php echo $value; ?>_nws" class="form-label"><?php __('Titular'); ?>:</label>
                                            <input type="text" name="title_<?php echo $value; ?>_nws" id="title_<?php echo $value; ?>_nws" value="<?php echo KT_escapeAttribute($row_rsnews['title_'.$value.'_nws']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("news", "title_".$value."_nws"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end mb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="title_"
                                                            data-fields-suf="_nws"
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

                                        <textarea name="content_<?php echo $value; ?>_nws" id="content_<?php echo $value; ?>_nws" rows="5" class="wysiwyg mt-5"><?php echo KT_escapeAttribute($row_rsnews['content_'.$value.'_nws']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("news", "content_".$lang_adm."__nws"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end mb-4">
                                            <?php foreach ($languages as $langx): ?>
                                                <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                        data-from="<?php echo $value; ?>"
                                                        data-to="<?php echo $langx; ?>"
                                                        data-fields-pref="content_"
                                                        data-fields-suf="_nws"
                                                        data-tab="conten"
                                                    ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            </div>
                                            <br>
                                        <?php endif ?>

                                        <br>

                                        <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert">
                                            <i class="fa-regular fa-circle-info label-icon"></i>{image}: <?php __('Imagen a tamaño real'); ?> | {image-left}: <?php __('Imagen alineada a la izquierda'); ?> | {image-right}: <?php __('Imagen alineada a la derecha'); ?> | {image-pan}: <?php __('Imagen panorámica'); ?>
                                        </div>

                                    </div>
                                    <?php } ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Imágenes'); ?></h4>
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
                                  <?php echo showThumbnail($row_rsImages['imagen_img'], '/media/images/news/', 150, 100); ?>
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

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Vídeos'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de las fotos, arrastre y suelte la fotos en la ubicación deseada'); ?>.</small>

                                <hr>

                                <div id="video-order-loading"></div>

                                <ul class="thumbnails clearfix nested-sortable-video" id="videos-list">

                                    <?php if($totalRows_rsVideos > 0) { ?>

                                        <?php do { ?>

                                        <li class="pull-left" id="order_<?php echo $row_rsVideos['id_vid'] ?>" data-id="<?php echo $row_rsVideos['id_vid'] ?>">

                                            <div class="img-thumbnail pull-left" style="width: 250px;">

                                              <?php


                                              $youtube = str_replace("\\\"","\"",$row_rsVideos['video_vid']) ;
                                              $ancho = 300;

                                              preg_match('/width="([0-9]+)"/', $youtube, $coincidencias);
                                              $proporcion = $coincidencias[1] / $ancho;

                                              if ($proporcion) {
                                                preg_match('/height="([0-9]+)"/', $youtube, $coincidencias);
                                                $height = round($coincidencias[1] / $proporcion);

                                                $youtube = preg_replace('/width="([0-9]+)"/', 'width="100%"', $youtube);
                                                $youtube = preg_replace('/height="([0-9]+)"/', '', $youtube);
                                              } else {
                                                $youtube = 'ERROR';
                                              } ?>


                                              <?php echo $youtube; ?>
                                              <p class="text-center"><a href="/intramedianet/news/videos_del.php" data-id="<?php echo $row_rsVideos['id_vid'] ?>" class="btn btn-danger btn-sm del-vid"><i class="fa-regular fa-trash-can"></i></a></p>
                                            </div>

                                        </li>

                                        <?php } while ($row_rsVideos = mysqli_fetch_assoc($rsVideos)); ?>

                                    <?php } ?>

                                </ul>

                                <hr>

                                  <div class="well well-sm clearfix">

                                    <div class="form-group">
                                      <label for="video" class="form-label">Vídeo:</label>
                                        <textarea type="text" name="video" id="video" cols="5" rows="3" class="form-control"></textarea>
                                    </div> <!-- /.form-group -->

                                    <a href="#" class="btn btn-success btn-sm float-end mt-2" id="addVid"  data-id="<?php echo $news_id; ?>"><?php __('Añadir vídeo'); ?></a>

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
var idNews = '<?php echo $news_id; ?>';
</script>

<script src="/intramedianet/pages/_js/pages-form.js" type="text/javascript"></script>

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
