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

$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct, parent_ct FROM news_categories WHERE type_ct = 10 AND parent_ct = 0 ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn, $query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);

function getChildsCats($num,$par,$prof=0) {

    global $database_inmoconn, $inmoconn, $lang_adm;

    $query_rsmenu = "SELECT * FROM news_categories WHERE parent_ct  = ".$num." ORDER BY category_".$lang_adm."_ct ASC";
    $rsmenu = mysqli_query($inmoconn, $query_rsmenu) or die(mysqli_error() . '<hr>' . $query_rsmenu);
    $row_rsmenu = mysqli_fetch_assoc($rsmenu);
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
  $tNG->addColumn("type_ct", "NUMERIC_TYPE", "EXPRESSION", "10");
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

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="form-horizontalx validate">

        <div id="second-nav">
            <h1 class="pull-left"><i class="fa fa-commenting-o"></i> <span><?php __('Noticias'); ?></span></h1>
            <div class="btn-toolbar pull-right" role="toolbar">
            <?php if (@$_GET['id_ct'] == "") { ?>
                <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success btn-sm" />
            <?php } else { ?>
                <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm" />
                <input type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 btn btn-danger btn-sm" />
            <?php } ?>
            <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-sm" />
            </div>
        </div>

        <div id="main-content">

            <div class="container-fluid">

                <?php echo $tNGs->getErrorMsg(); ?>

                <div class="row-fix-fluid">

                    <div class="tab-lat">

                        <ul class="nav nav-pills nav-stacked tabs-lats clearfix">
                              <li class="active"><a href="#general" data-toggle="tab"><?php __('General'); ?></a></li>
                              <li><a href="#descripcion" data-toggle="tab"><?php __('Descipción'); ?></a></li>
                              <li><a href="#buscadores" data-toggle="tab"><?php __('Buscadores'); ?></a></li>
                        </ul>

                    </div>

                    <div class="tab-cont">

                        <div class="tab-content">

                            <div class="tab-pane active" id="general">

                                <div class="panel panel-primary">

                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php __('General'); ?></h3>
                                    </div>

                                    <div class="panel-body">

                                        <div class="form-group <?php if($tNGs->displayFieldError("news_categories", "parent_ct") != '') { ?>has-error<?php } ?>">
                                            <label for="parent_ct"><?php __('Pertenece a'); ?>:</label>
                                            <select name="parent_ct" id="parent_ct" class="form-control">
                                                  <option value="0"><?php echo NXT_getResource("Select one..."); ?></option>
                                                  <?php
                                                  do {
                                                  ?>
                                                  <option value="<?php echo $row_rscategorias['id_ct']?>"<?php if (!(strcmp($row_rscategorias['id_ct'], $row_rsnews_categories['parent_ct']))) {echo "SELECTED";} ?>><?php echo $row_rscategorias['category_'.$lang_adm.'_ct']?></option>
                                                  <?php
                                                  if($row_rscategorias['id_ct'] != '') {
                                                    echo getChildsCats($row_rscategorias['id_ct'],$row_rsnews_categories['parent_ct']);
                                                  } ?>
                                                  <?php
                                                  } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                                    $rows = mysqli_num_rows($rscategorias);
                                                    if($rows > 0) {
                                                        mysqli_data_seek($rscategorias, 0);
                                                      $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                                    }
                                                  ?>
                                             </select>
                                            <?php echo $tNGs->displayFieldError("news_categories", "parent_ct"); ?>
                                        </div>

                                        <hr>

                                        <?php foreach($languages as $value) {  ?>

                                        <div class="form-group <?php if($tNGs->displayFieldError("news_categories", "category_".$value."_ct") != '') { ?>has-error<?php } ?>">
                                          <label for="category_<?php echo $value; ?>_ct"><?php __('Categoría'); ?>:</label>
                                          <div class="input-group">
                                              <span class="input-group-addon"><img src="../includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt=""></span>
                                              <input type="text" name="category_<?php echo $value; ?>_ct" id="category_<?php echo $value; ?>_ct" value="<?php echo KT_escapeAttribute($row_rsnews_categories['category_'.$value.'_ct']); ?>" size="32" maxlength="255" class="form-control required">
                                          </div>
                                          <?php if ($traduccion_textos == 1): ?>
                                                  <div class="pull-right">
                                                  <?php foreach ($languages as $langx): ?>
                                                      <?php if ($langx != $value): ?>
                                                          <button type="button" class="btn btn-primary btn-xs btn-translate"
                                                              data-from="<?php echo $value; ?>"
                                                              data-to="<?php echo $langx; ?>"
                                                              data-fields-pref="category_"
                                                              data-fields-suf="_ct"
                                                              data-tab="seox"
                                                          ><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $langx; ?>.png"></button>
                                                      <?php endif ?>
                                                  <?php endforeach ?>
                                                  </div>
                                                  <br>
                                              <?php endif ?>
                                            <?php echo $tNGs->displayFieldError("news_categories", "category_".$value."_ct"); ?>
                                        </div>

                                        <?php } ?>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="descripcion">

                                <div class="panel panel-primary">

                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php __('Descipción'); ?></h3>
                                    </div>

                                    <div class="panel-body">

                                        <ul id="myDescTab" class="nav nav-tabs">
                                            <?php foreach($languages as $value) { ?>
                                            <li class="<?php if($value == $language) { ?>active<?php } ?>"><a href="#<?php echo $value; ?>Desc" data-toggle="tab" id="conten<?php echo $value; ?>"><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt=""></a></li>
                                            <?php } ?>
                                        </ul>
                                        <div id="myDescTabContent" class="tab-content">
                                            <?php foreach($languages as $value) { ?>
                                            <div class="tab-pane fade in <?php if($value == $language) { ?>active<?php } ?>" id="<?php echo $value; ?>Desc">
                                                <textarea name="descripcion_<?php echo $value; ?>_ct" id="descripcion_<?php echo $value; ?>_ct" cols="50" rows="20" class="wysiwyg"><?php echo KT_escapeAttribute($row_rsnews_categories['descripcion_'.$value.'_ct']); ?></textarea>
                                                <div class="text-count"></div>
                                                <?php if ($traduccion_textos == 1): ?>
                                                    <div class="pull-right">
                                                    <?php foreach ($languages as $langx): ?>
                                                        <?php if ($langx != $value): ?>
                                                            <button type="button" class="btn btn-primary btn-xs btn-translate"
                                                                data-from="<?php echo $value; ?>"
                                                                data-to="<?php echo $langx; ?>"
                                                                data-fields-pref="descripcion_"
                                                                data-fields-suf="_ct"
                                                                data-tab="conten"
                                                            ><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $langx; ?>.png"></button>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                    </div>
                                                    <br>
                                                <?php endif ?>
                                                <?php echo $tNGs->displayFieldError("news_categories", "descripcion_".$lang_adm."_ct"); ?> <br>
                                            </div>
                                            <?php } ?>
                                            <br>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="buscadores">

                                <div class="panel panel-primary">

                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php __('Buscadores'); ?></h3>
                                    </div>

                                    <div class="panel-body">

                                        <ul id="myMetaTab" class="nav nav-tabs">
                                            <?php foreach($languages as $value) { ?>
                                            <li class="<?php if($value == $language) { ?>active<?php } ?>"><a href="#<?php echo $value; ?>Meta" data-toggle="tab" id="seo<?php echo $value; ?>"><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt=""></a></li>
                                            <?php } ?>
                                        </ul>

                                        <div id="myMetaTabContent" class="tab-content">
                                            <?php foreach($languages as $value) { ?>
                                            <div class="tab-pane fade in <?php if($value == $language) { ?>active<?php } ?>" id="<?php echo $value; ?>Meta">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="form-group <?php if($tNGs->displayFieldError("news_categories", "title_<?php echo $value; ?>_ct") != '') { ?>has-error<?php } ?>">
                                                            <label for="title_<?php echo $value; ?>_ct"><?php __('Title'); ?>:</label>
                                                            <input type="text" maxlength="55" name="title_<?php echo $value; ?>_ct" id="title_<?php echo $value; ?>_ct" value="<?php echo KT_escapeAttribute($row_rsnews_categories['title_'.$value.'_ct']); ?>" size="32" class="form-control textcountseo">
                                                            <?php if ($traduccion_textos == 1): ?>
                                                                <div class="pull-right">
                                                                <?php foreach ($languages as $langx): ?>
                                                                    <?php if ($langx != $value): ?>
                                                                        <button type="button" class="btn btn-primary btn-xs btn-translate"
                                                                            data-from="<?php echo $value; ?>"
                                                                            data-to="<?php echo $langx; ?>"
                                                                            data-fields-pref="title_"
                                                                            data-fields-suf="_ct"
                                                                            data-tab="seo"
                                                                        ><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $langx; ?>.png"></button>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                                </div>
                                                                <br>
                                                            <?php endif ?>
                                                            <?php echo $tNGs->displayFieldError("news_categories", "title_<?php echo $value; ?>_ct"); ?>
                                                        </div>
                                                        <div class="form-group <?php if($tNGs->displayFieldError("news_categories", "description_<?php echo $value; ?>_ct") != '') { ?>has-error<?php } ?>">
                                                            <label for="description_<?php echo $value; ?>_ct"><?php __('Description'); ?>:</label>
                                                            <textarea maxlength="155" name="description_<?php echo $value; ?>_ct" id="description_<?php echo $value; ?>_ct" cols="50" rows="5" class="form-control textcountseo"><?php echo KT_escapeAttribute($row_rsnews_categories['description_'.$value.'_ct']); ?></textarea>
                                                            <?php if ($traduccion_textos == 1): ?>
                                                                <div class="pull-right">
                                                                <?php foreach ($languages as $langx): ?>
                                                                    <?php if ($langx != $value): ?>
                                                                        <button type="button" class="btn btn-primary btn-xs btn-translate"
                                                                            data-from="<?php echo $value; ?>"
                                                                            data-to="<?php echo $langx; ?>"
                                                                            data-fields-pref="description_"
                                                                            data-fields-suf="_ct"
                                                                            data-tab="seo"
                                                                        ><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $langx; ?>.png"></button>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                                </div>
                                                                <br>
                                                            <?php endif ?>
                                                            <?php echo $tNGs->displayFieldError("news_categories", "description_<?php echo $value; ?>_ct"); ?>
                                                        </div>
                                                        <div class="form-group <?php if($tNGs->displayFieldError("news_categories", "keywords_<?php echo $value; ?>_ct") != '') { ?>has-error<?php } ?>">
                                                            <label for="keywords_<?php echo $value; ?>_ct"><?php __('Keywords'); ?>:</label>
                                                            <textarea name="keywords_<?php echo $value; ?>_ct" id="keywords_<?php echo $value; ?>_ct" cols="50" rows="5" class="form-control"><?php echo KT_escapeAttribute($row_rsnews_categories['keywords_'.$value.'_ct']); ?></textarea>
                                                            <?php if ($traduccion_textos == 1): ?>
                                                                <div class="pull-right">
                                                                <?php foreach ($languages as $langx): ?>
                                                                    <?php if ($langx != $value): ?>
                                                                        <button type="button" class="btn btn-primary btn-xs btn-translate"
                                                                            data-from="<?php echo $value; ?>"
                                                                            data-to="<?php echo $langx; ?>"
                                                                            data-fields-pref="keywords_"
                                                                            data-fields-suf="_ct"
                                                                            data-tab="seo"
                                                                        ><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png"> <i class="fa fa-arrow-right" aria-hidden="true"></i> <img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $langx; ?>.png"></button>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                                </div>
                                                                <br>
                                                            <?php endif ?>
                                                            <?php echo $tNGs->displayFieldError("news_categories", "keywords_<?php echo $value; ?>_ct"); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div> <!--/.container-fluid -->

        </div> <!--#main-content -->

        <input type="hidden" name="kt_pk_news_categories" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnews_categories['kt_pk_news_categories']); ?>" />

        </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
