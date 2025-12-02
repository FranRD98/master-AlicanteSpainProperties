<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

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

$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct, parent_ct FROM news_categories WHERE type_ct = 1 AND (parent_ct = 0 OR parent_ct IS NULL) ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn, $query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);

function getChildsCats($num,$par,$prof=0) {

    global $database_inmoconn, $inmoconn, $lang_adm;

    $query_rsmenu = "SELECT * FROM news_categories WHERE parent_ct  = ".$num." ORDER BY category_".$lang_adm."_ct ASC";
    $rsmenu = mysqli_query($inmoconn,$query_rsmenu) or die(mysqli_error() . '<hr>' . $query_rsmenu);
    $row_rsmenu = mysqlii_fetch_assoc($rsmenu);
    $totalRows_rsmenu = mysqli_num_rows($rsmenu);
    $cad = '';
    for($i=0; $i <= $prof; $i++){
        $cad .= '&#8212; &#8212;';
    }

    $ret = '';
    do {
        if($row_rsmenu['id_ct']!='') {
            $sel = (!(strcmp($row_rsmenu['id_ct'], $par)))? "SELECTED":"";
            $ret .= '<option value="'.$row_rsmenu['id_ct'].'" '.$sel.'> '.$cad.' '.$row_rsmenu["category_".$lang_adm."_ct"].'</option>';
            $ret .= getChildsCats($row_rsmenu['id_ct'],$par,$prof+1);
        }
    } while ($row_rsmenu = mysqli_fetch_assoc($rsmenu));
    mysqli_free_result ($rsmenu);
    return( $ret );
}


// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("category_".$value."_ct", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("news");
  $tblFldObj->setFieldName("categoria_nws");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay noticias que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

//start Trigger_CheckDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail2(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("news");
  $tblFldObj->setFieldName("parent_ct");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay categorías que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail2 trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("type_ct", "NUMERIC_TYPE", "EXPRESSION", "1");
  return $tNG->getError();
}
//end addFields trigger

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand
function Trigger_SetOrderColumn(&$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("orden_ct");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

// Make an insert transaction instance
$ins_news_categories = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_news_categories);
// Register triggers
$ins_news_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_news_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_news_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_news_categories->registerTrigger("BEFORE", "addFields", 10);
$ins_news_categories->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
// Add columns
$ins_news_categories->setTable("news_categories");
$ins_news_categories->addColumn("parent_ct", "NUMERIC_TYPE", "POST", "parent_ct", 0);
foreach($languages as $value) {
  $ins_news_categories->addColumn("category_".$value."_ct", "STRING_TYPE", "POST", "category_".$value."_ct");
  $ins_news_categories->addColumn("descripcion_".$value."_ct", "STRING_TYPE", "POST", "descripcion_".$value."_ct");
  $ins_news_categories->addColumn("title_".$value."_ct", "STRING_TYPE", "POST", "title_".$value."_ct");
  $ins_news_categories->addColumn("description_".$value."_ct", "STRING_TYPE", "POST", "description_".$value."_ct");
  $ins_news_categories->addColumn("keywords_".$value."_ct", "STRING_TYPE", "POST", "keywords_".$value."_ct");
}
$ins_news_categories->setPrimaryKey("id_ct", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_news_categories = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_news_categories);
// Register triggers
$upd_news_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_news_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_news_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_news_categories->setTable("news_categories");
$upd_news_categories->addColumn("parent_ct", "NUMERIC_TYPE", "POST", "parent_ct");
foreach($languages as $value) {
  $upd_news_categories->addColumn("category_".$value."_ct", "STRING_TYPE", "POST", "category_".$value."_ct");
  $upd_news_categories->addColumn("descripcion_".$value."_ct", "STRING_TYPE", "POST", "descripcion_".$value."_ct");
  $upd_news_categories->addColumn("title_".$value."_ct", "STRING_TYPE", "POST", "title_".$value."_ct");
  $upd_news_categories->addColumn("description_".$value."_ct", "STRING_TYPE", "POST", "description_".$value."_ct");
  $upd_news_categories->addColumn("keywords_".$value."_ct", "STRING_TYPE", "POST", "keywords_".$value."_ct");
}
$upd_news_categories->setPrimaryKey("id_ct", "NUMERIC_TYPE", "GET", "id_ct");

// Make an instance of the transaction object
$del_news_categories = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_news_categories);
// Register triggers
$del_news_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_news_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_news_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// $del_news_categories->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
// $del_news_categories->registerTrigger("BEFORE", "Trigger_CheckDetail2", 40);
// Add columns
$del_news_categories->setTable("news_categories");
$del_news_categories->setPrimaryKey("id_ct", "NUMERIC_TYPE", "GET", "id_ct");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnews_categories = $tNGs->getRecordset("news_categories");
$row_rsnews_categories = mysqli_fetch_assoc($rsnews_categories);
$totalRows_rsnews_categories = mysqli_num_rows($rsnews_categories);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_news_categories" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnews_categories['kt_pk_news_categories']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-newspaper"></i> <a href="news.php"><?php echo __('Noticias'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php if (@$_GET['id_ct'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Categoría'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_ct'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Categoría'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>

                                        <div class="mb-4">
                                            <label for="category_<?php echo $value; ?>_ct" class="form-label required"><?php __('Categoría'); ?>:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" height="15"></span>
                                                    <input type="text" class="form-control required" name="category_<?php echo $value; ?>_ct"" id="category_<?php echo $value; ?>_ct"" value="<?php echo KT_escapeAttribute($row_rsnews_categories['category_'.$value.'_ct']); ?>" required>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                <?php echo $tNGs->displayFieldError("custom", "alt_".$value."_img"); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("news_categories", "category_".$value."_ct"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end mb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="category_"
                                                            data-fields-suf="_ct"
                                                            data-tab="category"
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
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Descripción'); ?></h4>
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

                                        <textarea name="descripcion_<?php echo $value; ?>_ct" id="descripcion_<?php echo $value; ?>_ct" rows="5" class="wysiwyg mt-5"><?php echo KT_escapeAttribute($row_rsnews_categories['descripcion_'.$value.'_ct']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("news_categories", "descripcion_".$lang_adm."__ct"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end mb-4">
                                            <?php foreach ($languages as $langx): ?>
                                                <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                        data-from="<?php echo $value; ?>"
                                                        data-to="<?php echo $langx; ?>"
                                                        data-fields-pref="descripcion_"
                                                        data-fields-suf="_ct"
                                                        data-tab="descripcion"
                                                    ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            </div>
                                            <br>
                                        <?php endif ?>

                                        <br class="d-md-none">
                                        <br class="d-md-none">

                                        <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4" role="alert">
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

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news_categories", "title_".$value."_ct") != '') { ?>error<?php } ?>">
                                            <label for="title_<?php echo $value; ?>_ct" class="form-label"><?php __('Title'); ?>:</label>
                                                <input type="text" maxlength="55" name="title_<?php echo $value; ?>_ct" id="title_<?php echo $value; ?>_ct" value="<?php echo KT_escapeAttribute($row_rsnews_categories['title_'.$value.'_ct']); ?>" size="32" class="form-control textcountseo">
                                                <?php if ($traduccion_textos == 1): ?>
                                                    <div class="float-end mb-4">
                                                    <?php foreach ($languages as $langx): ?>
                                                        <?php if ($langx != $value): ?>
                                                            <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                                data-from="<?php echo $value; ?>"
                                                                data-to="<?php echo $langx; ?>"
                                                                data-fields-pref="title_"
                                                                data-fields-suf="_ct"
                                                                data-tab="seo"
                                                            ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                    </div>
                                                    <br>
                                                <?php endif ?>
                                              <?php echo $tNGs->displayFieldError("news_categories", "title_".$value."_ct"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news_categories", "description_".$value."_ct") != '') { ?>error<?php } ?>">
                                          <label for="description_<?php echo $value; ?>_ct" class="form-label"><?php __('Description'); ?>:</label>
                                              <textarea maxlength="155" name="description_<?php echo $value; ?>_ct" id="description_<?php echo $value; ?>_ct" cols="50" rows="5" class="form-control textcountseo"><?php echo KT_escapeAttribute($row_rsnews_categories['description_'.$value.'_ct']); ?></textarea>
                                              <?php if ($traduccion_textos == 1): ?>
                                                  <div class="float-end">
                                                  <?php foreach ($languages as $langx): ?>
                                                      <?php if ($langx != $value): ?>
                                                          <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                              data-from="<?php echo $value; ?>"
                                                              data-to="<?php echo $langx; ?>"
                                                              data-fields-pref="description_"
                                                              data-fields-suf="_ct"
                                                              data-tab="seo"
                                                          ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                      <?php endif ?>
                                                  <?php endforeach ?>
                                                  </div>
                                                  <br>
                                              <?php endif ?>
                                            <?php echo $tNGs->displayFieldError("news_categories", "description_".$value."_ct"); ?>
                                        </div>

                                        <div class="<?php if($tNGs->displayFieldError("news_categories", "keywords_".$value."_ct") != '') { ?>error<?php } ?>">
                                          <label for="keywords_<?php echo $value; ?>_ct" class="form-label"><?php __('Keywords'); ?>:</label>
                                              <textarea name="keywords_<?php echo $value; ?>_ct" id="keywords_<?php echo $value; ?>_ct" cols="50" rows="5" class="form-control"><?php echo KT_escapeAttribute($row_rsnews_categories['keywords_'.$value.'_ct']); ?></textarea>
                                              <?php if ($traduccion_textos == 1): ?>
                                                  <div class="float-end">
                                                  <?php foreach ($languages as $langx): ?>
                                                      <?php if ($langx != $value): ?>
                                                          <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                              data-from="<?php echo $value; ?>"
                                                              data-to="<?php echo $langx; ?>"
                                                              data-fields-pref="keywords_"
                                                              data-fields-suf="_ct"
                                                              data-tab="seo"
                                                          ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                      <?php endif ?>
                                                  <?php endforeach ?>
                                                  </div>
                                                  <br>
                                              <?php endif ?>
                                            <?php echo $tNGs->displayFieldError("news_categories", "keywords_".$value."_ct"); ?>
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

</body>
</html>
