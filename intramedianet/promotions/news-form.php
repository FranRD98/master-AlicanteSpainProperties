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


$query_rsFiles = "SELECT * FROM news_files WHERE news_fil = '".$news_id."' ORDER BY order_fil";
$rsFiles = mysqli_query($inmoconn,$query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);


$query_Recordset2 = "
 SELECT DISTINCT

    properties_loc1.name_".$lang_adm."_loc1 ,
    CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS name_".$lang_adm."_loc2,
    CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS name_".$lang_adm."_loc3,
    CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS name_".$lang_adm."_loc4,
    CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END AS id_loc4

FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

ORDER BY name_".$lang_adm."_loc1, name_".$lang_adm."_loc2, name_".$lang_adm."_loc3, name_".$lang_adm."_loc4 ASC

";
$Recordset2 = mysqli_query($inmoconn,$query_Recordset2) or die(mysqli_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);



$query_rsZonas = "
 SELECT DISTINCT

    properties_loc1.name_".$lang_adm."_loc1 ,
    CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS name_".$lang_adm."_loc2,
    CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS name_".$lang_adm."_loc3,
    CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS name_".$lang_adm."_loc4,
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id_loc3

FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

GROUP BY id_loc3

ORDER BY name_".$lang_adm."_loc1, name_".$lang_adm."_loc2, name_".$lang_adm."_loc3, name_".$lang_adm."_loc4 ASC
";
$rsZonas = mysqli_query($inmoconn,$query_rsZonas) or die(mysqli_error());
$row_rsZonas = mysqli_fetch_assoc($rsZonas);
$totalRows_rsZonas = mysqli_num_rows($rsZonas);

$query_rsproperties_features = "SELECT properties_features_priv.id_feat, properties_features_priv.feature_".$lang_adm."_feat, properties_features_priv.feature_en_feat AS feat, promotions_promotions_feature.promotion FROM properties_features_priv LEFT JOIN promotions_promotions_feature ON (promotions_promotions_feature.feature=properties_features_priv.id_feat AND promotions_promotions_feature.promotion=0123456789) ORDER BY properties_features_priv.feature_".$lang_adm."_feat ASC";
$rsproperties_features = mysqli_query($inmoconn, $query_rsproperties_features) or die(mysqli_error());
$row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
$totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);

$query_rsTags = "SELECT properties_tags.id_tag, properties_tags.tag_".$lang_adm."_tag, promotions_promotions_tag.promotion FROM properties_tags LEFT JOIN promotions_promotions_tag ON (promotions_promotions_tag.tag=properties_tags.id_tag AND promotions_promotions_tag.promotion=0123456789) ORDER BY properties_tags.tag_".$lang_adm."_tag ASC";
$rsTags = mysqli_query($inmoconn, $query_rsTags) or die(mysqli_error());
$row_rsTags = mysqli_fetch_assoc($rsTags);
$totalRows_rsTags = mysqli_num_rows($rsTags);


$query_rsProvincias = "
 SELECT DISTINCT

    properties_loc1.name_".$lang_adm."_loc1 ,
    CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS name_".$lang_adm."_loc2,
    CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS name_".$lang_adm."_loc3,
    CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS name_".$lang_adm."_loc4,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id_loc2

FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

GROUP BY id_loc2

ORDER BY name_".$lang_adm."_loc1, name_".$lang_adm."_loc2 ASC
";
$rsProvincias = mysqli_query($inmoconn,$query_rsProvincias) or die(mysqli_error());
$row_rsProvincias = mysqli_fetch_assoc($rsProvincias);
$totalRows_rsProvincias = mysqli_num_rows($rsProvincias);

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
  $tNG->addColumn("type_nws", "NUMERIC_TYPE", "EXPRESSION", "999");
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

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand
function Trigger_SetOrderColumn(&$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("order_nws");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

//start Trigger_Default_ManyToMany2 trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany2($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("promotions_promotions_feature");
  $mtm->setPkName("promotion");
  $mtm->setFkName("feature");
  $mtm->setFkReference("mtm2");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany2 trigger

//start Trigger_Default_ManyToMany3 trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany3($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("promotions_promotions_tag");
  $mtm->setPkName("promotion");
  $mtm->setFkName("tag");
  $mtm->setFkReference("mtm3");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany3 trigger

//start Trigger_DeleteDetail5 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail5($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("promotions_promotions_feature");
  $tblDelObj->setFieldName("promotion");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail5 trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("promotions_promotions_tag");
  $tblDelObj->setFieldName("promotion");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

// Make an insert transaction instance
$ins_news = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_news);
// Register triggers
$ins_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_news->registerTrigger("BEFORE", "addFields", 10);
$ins_news->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany2", 50);
$ins_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany3", 50);
// Add columns
$ins_news->setTable("news");
// $ins_news->addColumn("categoria_nws", "NUMERIC_TYPE", "POST", "categoria_nws");

$ins_news->addColumn("quick_town_nws", "STRING_TYPE", "POST", "quick_town_nws");
$ins_news->addColumn("quick_province_nws", "STRING_TYPE", "POST", "quick_province_nws");
// $ins_news->addColumn("quick_price_from_nws", "NUMERIC_TYPE", "POST", "quick_price_from_nws");
// $ins_news->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$ins_news->addColumn("lat_long_gp_prop", "STRING_TYPE", "POST", "lat_long_gp_prop");
$ins_news->addColumn("zoom_gp_prop", "STRING_TYPE", "POST", "zoom_gp_prop");
$ins_news->addColumn("activate_nws", "CHECKBOX_1_0_TYPE", "POST", "activate_nws");

foreach($languages as $value) {
  $ins_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $ins_news->addColumn("titulo_prom_".$value."_nws", "STRING_TYPE", "POST", "titulo_prom_".$value."_nws");
  $ins_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $ins_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $ins_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $ins_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
}
$ins_news->addColumn("destacado_nws", "CHECKBOX_1_0_TYPE", "POST", "destacado_nws", "0");
$ins_news->addColumn("destacado_propm_nws", "CHECKBOX_1_0_TYPE", "POST", "destacado_propm_nws", "0");
$ins_news->setPrimaryKey("id_nws", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_news = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_news);
// Register triggers
$upd_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany2", 50);
$upd_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany3", 50);
// Add columns
$upd_news->setTable("news");
// $upd_news->addColumn("categoria_nws", "NUMERIC_TYPE", "POST", "categoria_nws");
foreach($languages as $value) {
  $upd_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $upd_news->addColumn("titulo_prom_".$value."_nws", "STRING_TYPE", "POST", "titulo_prom_".$value."_nws");
  $upd_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $upd_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $upd_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $upd_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
}
$upd_news->addColumn("destacado_nws", "CHECKBOX_1_0_TYPE", "POST", "destacado_nws");
$upd_news->addColumn("destacado_propm_nws", "CHECKBOX_1_0_TYPE", "POST", "destacado_propm_nws");
// $upd_news->addColumn("quick_price_from_nws", "NUMERIC_TYPE", "POST", "quick_price_from_nws");
$upd_news->addColumn("quick_town_nws", "STRING_TYPE", "POST", "quick_town_nws");
$upd_news->addColumn("quick_province_nws", "STRING_TYPE", "POST", "quick_province_nws");

// $upd_news->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$upd_news->addColumn("lat_long_gp_prop", "STRING_TYPE", "POST", "lat_long_gp_prop");
$upd_news->addColumn("zoom_gp_prop", "STRING_TYPE", "POST", "zoom_gp_prop");
$upd_news->addColumn("activate_nws", "CHECKBOX_1_0_TYPE", "POST", "activate_nws");

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
$del_news->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
$del_news->registerTrigger("BEFORE", "Trigger_DeleteDetail5", 99);
// Add columns
$del_news->setTable("news");
$del_news->setPrimaryKey("id_nws", "NUMERIC_TYPE", "GET", "id_nws");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnews = $tNGs->getRecordset("news");
$row_rsnews = mysqli_fetch_assoc($rsnews);
$totalRows_rsnews = mysqli_num_rows($rsnews);

function getPromotor($id) {
    global $inmoconn;

    $query_rsProperties = "SELECT * FROM properties_properties WHERE promocion_prop = '".$id."' AND promocion_prop > 0";
    $rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
    $row_rsProperties = mysqli_fetch_assoc($rsProperties);
    $totalRows_rsProperties = mysqli_num_rows($rsProperties);

    if ($row_rsProperties['owner_prop'] > 0) {
        return $row_rsProperties['owner_prop'];
    }

    return '';
}

function getAlerts($id) {
    global $inmoconn;

    $query_rsProperties = "SELECT * FROM properties_properties WHERE promocion_prop = '".$id."' AND (restr_web_prop = 1 OR restr_nat_port_prop = 1 OR restr_int_port_prop = 1 OR restr_man_contr_prop = 1 OR restr_social_prop = 1 OR restr_int_cli_prop = 1) AND promocion_prop > 0";
    $rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
    $row_rsProperties = mysqli_fetch_assoc($rsProperties);
    $totalRows_rsProperties = mysqli_num_rows($rsProperties);

    if ($totalRows_rsProperties > 0) {
        return 1;
    }

    return '';
}
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
                        <!-- <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-house-person-leave"></i> <?php echo __('Propietarios'); ?></h4> -->

                        <div class="flex-md-grow-1 d-md-block" id="tabs-header-fix">

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills card-header-pills" role="tablist" id="proptabs">
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary active" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabpromo" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Promoción'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabprops" role="tab" aria-selected="true">
                                        <?php __('Propiedades'); ?>
                                    </a>
                                </li>
                                <?php $promotor = getPromotor($news_id); ?>
                                <?php if ($promotor > 0): ?>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" href="/intramedianet/properties/owners-form.php?id_pro=<?php echo $promotor ?>" target="_blank">
                                        <?php __('Banco'); ?>
                                    </a>
                                </li>
                                <?php endif ?>
                            </ul>

                        </div>

                        <div class="flex-grow-1 prop-nav-sep d-none d-md-flex text-white"><i class="fa-regular fa-pipe mx-5"></i></div>

                        <div class="flex-md-shrink-0 d-md-block">
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
                </div>

                <div class="col">
                    <?php if (getAlerts($news_id) == 1) { ?>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                            <i class="fa-regular fa-circle-exclamation label-icon"></i>
                            <p class="my-1"><b><?php __('Esta promoción tiene inmuebles con restricciones'); ?></b></p>
                        </div>
                        <?php unset($_SESSION['fc_statusRightmove']); ?>
                    <?php } ?>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <div class="tab-cont">

                    <div class="tab-content">

                        <div class="tab-pane active" id="tabpromo">
                            <!-- <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Promoción'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body"> -->

                                     <div class="row">
                                         <div class="col-lg-12">
                                             <div class="card position-relative">

                                                 <div class="card-body">
                                                     <div class="row">
                                                         <div class="col-lg-3">

                                                             <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                                                   <input type="checkbox" name="destacado_nws" id="destacado_nws" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['destacado_nws']),"1"))) {echo "checked";} ?>>
                                                                   <label class="form-check-label" for="destacado_nws">
                                                                     <?php __('Vendido'); ?></label>
                                                                   <?php echo $tNGs->displayFieldError("news", "destacado_nws"); ?>
                                                               </div>

                                                         </div>
                                                         <div class="col-lg-3">

                                                             <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                                                   <input type="checkbox" name="activate_nws" id="activate_nws" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                                                   <label class="form-check-label" for="activate_nws">
                                                                     <?php __('Activar la propiedad'); ?></label>
                                                                   <?php echo $tNGs->displayFieldError("news", "activate_nws"); ?>
                                                               </div>

                                                         </div>
                                                         <div class="col-lg-3">

                                                             <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                                                   <input type="checkbox" name="destacado_propm_nws" id="destacado_propm_nws" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['destacado_propm_nws']),"1"))) {echo "checked";} ?>>
                                                                   <label class="form-check-label" for="destacado_propm_nws">
                                                                     <?php __('Destacar la promoción'); ?></label>
                                                                   <?php echo $tNGs->displayFieldError("news", "destacado_propm_nws"); ?>
                                                               </div>

                                                         </div>
                                                     </div>
                                                 </div>

                                             </div>
                                         </div>
                                     </div>

                                     <div class="row">
                                         <div class="col-lg-12">
                                             <div class="card position-relative">
                                                 <div class="card-body">
                                                     <div class="row">

                                                         <div class="col-lg-6">

                                                             <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_province_nws") != '') { ?>has-error<?php } ?>">
                                                                 <label for="quick_province_nws"><?php __('Provincia'); ?>:</label>
                                                                 <input type="text" name="quick_province_nws" id="quick_province_nws" value="<?php if (@$_GET['id_prop'] == "" && $row_rsnews['quick_province_nws'] == '') { ?><?php echo $row_rsAdmin ['prefix_ref_usr'] ?><?php } ?><?php echo KT_escapeAttribute($row_rsnews['quick_province_nws']); ?>" size="32" maxlength="255" class="form-control">
                                                                 <?php echo $tNGs->displayFieldError("news", "quick_province_nws"); ?>
                                                             </div>

                                                         </div>
                                                         <div class="col-lg-6">

                                                             <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_town_nws") != '') { ?>has-error<?php } ?>">
                                                                 <label for="quick_town_nws"><?php __('Ciudad'); ?>:</label>
                                                                 <input type="text" name="quick_town_nws" id="quick_town_nws" value="<?php if (@$_GET['id_prop'] == "" && $row_rsnews['quick_town_nws'] == '') { ?><?php echo $row_rsAdmin ['prefix_ref_usr'] ?><?php } ?><?php echo KT_escapeAttribute($row_rsnews['quick_town_nws']); ?>" size="32" maxlength="255" class="form-control">
                                                                 <?php echo $tNGs->displayFieldError("news", "quick_town_nws"); ?>
                                                             </div>

                                                         </div>

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
                                                                 <label for="titulo_prom_<?php echo $value; ?>_nws" class="form-label"><?php __('Titular'); ?> Website:</label>
                                                                 <input type="text" name="titulo_prom_<?php echo $value; ?>_nws" id="titulo_prom_<?php echo $value; ?>_nws" value="<?php echo KT_escapeAttribute($row_rsnews['titulo_prom_'.$value.'_nws']); ?>" size="32" maxlength="255" class="form-control">
                                                                 <?php echo $tNGs->displayFieldError("news", "titulo_prom_".$value."_nws"); ?>
                                                                 <?php if ($traduccion_textos == 1): ?>
                                                                     <div class="float-end mb-4">
                                                                     <?php foreach ($languages as $langx): ?>
                                                                         <?php if ($langx != $value): ?>
                                                                             <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                                                 data-from="<?php echo $value; ?>"
                                                                                 data-to="<?php echo $langx; ?>"
                                                                                 data-fields-pref="titulo_prom_"
                                                                                 data-fields-suf="_nws"
                                                                                 data-tab="titulo_prom"
                                                                             ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                                         <?php endif ?>
                                                                     <?php endforeach ?>
                                                                     </div>
                                                                     <br>
                                                                 <?php endif ?>
                                                             </div>

                                                             <br class="d-md-none">
                                                             <br class="d-md-none">

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

                                     <div class="card position-relative">
                                         <div class="card-header align-items-center d-flex">
                                             <div class="flex-grow-1 oveflow-hidden">
                                                 <h4 class="card-title mb-0 flex-grow-1"><?php __('Etiquetas'); ?></h4>
                                             </div>
                                         </div>
                                         <div class="card-body">

                                             <div class="row">

                                                 <?php
                                                 $cnt3 = 0;
                                                 if ($totalRows_rsnews>0) {
                                                 $nested_query_rsTags = str_replace("123456789", $row_rsnews['id_nws'], $query_rsTags);

                                                 $rsTags = mysqli_query($inmoconn, $nested_query_rsTags) or die(mysqli_error());
                                                 $row_rsTags = mysqli_fetch_assoc($rsTags);
                                                 $totalRows_rsTags = mysqli_num_rows($rsTags);
                                                 $nested_sw = false;
                                                 if (isset($row_rsTags) && is_array($row_rsTags)) {
                                                   do { //Nested repeat
                                                 ?>
                                                     <div class="col-md-3">
                                                         <div class="form-check form-switch form-switch-md mt-4" dir="ltr">
                                                             <input type="checkbox" name="mtm3_<?php echo $row_rsTags['id_tag']; ?>" id="mtm3_<?php echo $row_rsTags['id_tag']; ?>" value="1" class="form-check-input" <?php if ($row_rsTags['promotion'] != "") {?> checked<?php }?>>
                                                             <label class="form-check-label" for="mtm3_<?php echo $row_rsTags['id_tag']; ?>"><?php echo $row_rsTags['tag_'.$lang_adm.'_tag']; ?></label>
                                                         </div>
                                                     </div> <!--/.col-md-4 -->
                                                     <?php
                                                   $cnt3++;
                                                   if ($cnt3%4 == 0) {
                                                     echo '</div> <!--/.row --><div class="row">';
                                                   }
                                                 ?>
                                                     <?php
                                                   } while ($row_rsTags = mysqli_fetch_assoc($rsTags)); //Nested move next
                                                 }
                                               }
                                             ?>

                                             </div> <!--/.row -->

                                         </div><!-- end card-body -->
                                     </div>

                                     <div class="card position-relative">
                                        <div class="card-header align-items-center d-flex">
                                            <div class="flex-grow-1 oveflow-hidden">
                                                <h4 class="card-title mb-0 flex-grow-1"><?php __('Características'); ?></h4>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="row">

                                            <?php
                                                $cnt2 = 0;
                                                if ($totalRows_rsnews>0) {
                                                $nested_query_rsproperties_features = str_replace("123456789", $row_rsnews['id_nws'], $query_rsproperties_features);

                                                $rsproperties_features = mysqli_query($inmoconn, $nested_query_rsproperties_features) or die(mysqli_error());
                                                $row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
                                                $totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);
                                                $nested_sw = false;
                                                if (isset($row_rsproperties_features) && is_array($row_rsproperties_features)) {
                                                  do { //Nested repeat
                                                    $fatHab = ['Parking', 'Elevator', 'Community pool', 'Community garage', 'Community gym', 'Community garden', 'Community spa', 'Safe urbanization', 'Playground', 'City views', 'Mountain views', 'Sea views', 'Frontline beach', 'Near sea', 'School', 'Green areas', 'Golf', 'Hospital', 'Solarium', 'Private garage:', 'Private parking:', 'Private pool', 'Gym', 'Spa', 'Kitchen:', 'Air conditioner', 'Pre-air conditioner', 'Home automation', 'Floor heating', 'Alarm', 'Built-in cabinets', 'Garden', 'Basement', 'Storage room'];
                                                    if (in_array($row_rsproperties_features['feat'], $fatHab)) {
                                                ?>
                                                    <div class="col-md-4">

                                                        <div class="form-check form-switch form-switch-md my-2" dir="ltr">
                                                            <input type="checkbox" name="mtm2_<?php echo $row_rsproperties_features['id_feat']; ?>" id="mtm2_<?php echo $row_rsproperties_features['id_feat']; ?>" value="1" <?php if ($row_rsproperties_features['promotion'] != "") {?> checked<?php }?> class="form-check-input">
                                                            <label class="form-check-label" for="mtm2_<?php echo $row_rsproperties_features['id_feat']; ?>"><?php echo $row_rsproperties_features['feature_'.$lang_adm.'_feat']; ?></label>
                                                            <?php echo $tNGs->displayFieldError("properties_properties", "solarium_prop"); ?>
                                                        </div>

                                                    </div> <!--/.col-md-4 -->
                                                    <?php
                                                  $cnt2++;
                                                  if ($cnt2%3 == 0) {
                                                    echo '</div> <!--/.row --><div class="row">';
                                                  }
                                                ?>
                                                    <?php
                                                    }
                                                  } while ($row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features)); //Nested move next
                                                }
                                              }
                                            ?>

                                            </div> <!--/.row -->

                                        </div><!-- end card-body -->
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

                                    <div class="row">
                                         <div class="col-lg-12">

                                             <div class="card position-relative">
                                                 <div class="card-header align-items-center d-flex">
                                                     <div class="flex-grow-1 oveflow-hidden">
                                                         <h4 class="card-title mb-0 flex-grow-1"><?php __('Archivos'); ?></h4>
                                                     </div>
                                                 </div>
                                                 <div class="card-body">

                                                     <small><i class="fa-regular fa-file fa-fw"></i> <?php __('Extensiones permitidas'); ?>: rar, txt, zip, doc, pdf, csv, xls, rtf, sxw, odt, docx, xlsx, ppt <?php __('y'); ?> mov.</small>
                                                     <br>
                                                     <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de los archivos, arrastre y suelte el archivo en la ubicación deseada'); ?>.</small>

                                                     <hr>

                                                     <div id="file-order-loading"></div>
                                                     <ul class="thumbnails nested-sortable-file" id="file-list">
                                                         <?php if($totalRows_rsFiles > 0) { ?>
                                                         <?php do { ?>
                                                             <li class="pull-left" id="order_<?php echo $row_rsFiles['id_fil'] ?>" data-id="<?php echo $row_rsFiles['id_fil'] ?>">
                                                                 <div class="img-thumbnail pull-left">
                                                                     <a href="/media/files/news/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br><small><?php echo $row_rsFiles['file_fil']; ?></small></a>
                                                                     <p class="text-center">
                                                                     <?php if($row_rsFiles['lang_fil'] != '') { ?>
                                                                     <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $row_rsFiles['lang_fil']; ?>.svg" alt="" class="float-start rounded mt-0" style="height: 25px;"/>
                                                                     <?php } ?>
                                                                     <a href="#" class="btn btn-success btn-sm edit-name" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-pencil"></i></a>
                                                                     <a href="#" class="btn btn-info btn-sm edit-lang" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-language"></i></a>
                                                                     <a href="files_del.php" data-id="<?php echo $row_rsFiles['id_fil'] ?>" class="btn btn-danger btn-sm del-fil"><i class="fa-regular fa-trash-can"></i></a>
                                                                     </p>
                                                                 </div>
                                                             </li>
                                                             <?php } while ($row_rsFiles = mysqli_fetch_assoc($rsFiles)); ?>
                                                         <?php } ?>
                                                     </ul>
                                                     <hr>
                                                     <div class="multi_files"></div>


                                                 </div>
                                             </div>

                                         </div>
                                     </div>


                                     <div class="row">
                                         <div class="col-lg-12">

                                             <div class="card position-relative">
                                                 <div class="card-header align-items-center d-flex">
                                                     <div class="flex-grow-1 oveflow-hidden">
                                                         <h4 class="card-title mb-0 flex-grow-1"><?php __('Google Maps'); ?></h4>
                                                     </div>
                                                 </div>
                                                 <div class="card-body">

                                                     <div class="row">

                                                         <div class="col-md-6">

                                                             <div class="pb-md-4 <?php if ($tNGs->displayFieldError("properties_properties", "direccion_gp_prop") != '') { ?>has-error<?php } ?>">
                                                                 <label class="form-label">&nbsp;</label>
                                                                 <a href="https://www.google.es/maps" target="_blank" class="btn btn-info w-100"><i class="fa-regular fa-map-location-dot"></i> <?php __('Ir a Google Maps'); ?></a>
                                                             </div>

                                                         </div> <!--/.col-md-7 -->

                                                         <div class="col-md-3">

                                                             <div class="mb-4 mb-md-0 <?php if ($tNGs->displayFieldError("news", "lat_long_gp_prop") != '') { ?>has-error<?php } ?>">
                                                                 <label for="lat_long_gp_prop" class="form-label"><?php __('Latitud y longitud'); ?>:</label>
                                                                 <div class="input-group">
                                                                     <input type="text" name="lat_long_gp_prop" id="lat_long_gp_prop" value="<?php echo KT_escapeAttribute($row_rsnews['lat_long_gp_prop']); ?>" size="32" maxlength="255" class="form-control comp_lat_lng">
                                                                     <button class="btn btn-primary btn-copy-latlong" type="button" onclick="copyToClipboard('#lat_long_gp_prop')"><i class="fa-regular fa-clipboard"></i></button>
                                                                 </div>
                                                                 <?php echo $tNGs->displayFieldError("news", "lat_long_gp_prop"); ?>
                                                             </div>

                                                         </div> <!--/.col-md-3 -->

                                                         <div class="col-md-3">

                                                             <div class="form-group <?php if ($tNGs->displayFieldError("news", "zoom_gp_prop") != '') { ?>has-error<?php } ?>">
                                                                 <label for="zoom_gp_prop" class="form-label"><?php __('Zoom'); ?>:</label>
                                                                 <input type="text" name="zoom_gp_prop" id="zoom_gp_prop" value="<?php echo KT_escapeAttribute($row_rsnews['zoom_gp_prop']); ?>" size="32" maxlength="255" class="form-control zoom_gp_prop">
                                                                 <?php echo $tNGs->displayFieldError("news", "zoom_gp_prop"); ?>
                                                             </div>

                                                         </div> <!--/.col-md-2 -->

                                                     </div> <!--/.row -->

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

                                <!-- </div>
                            </div> -->
                        </div>

                        <div class="tab-pane" id="tabprops">
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Inmuebles'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <table class="table table-striped table-bordered records-tables-simple align-middle" id="records-tables">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Imágen'); ?></th>
                                          <th><?php __('Referencia'); ?></th>
                                          <th><?php __('Operación'); ?></th>
                                          <th><?php __('Tipo'); ?></th>
                                          <th><?php __('Ciudad'); ?></th>
                                          <th><?php __('Zona'); ?></th>
                                          <th><?php __('Precio'); ?></th>
                                          <th><?php __('Activado'); ?></th>
                                          <th><?php __('Propietario'); ?></th>
                                          <th><?php __('Teléfono'); ?></th>
                                          <th id="actions" style="min-width: 150px !important;">
                                              <div class="row">
                                                  <div class="col-6" id="col-1">

                                                  </div>
                                                  <div class="col-6" id="col-2">

                                                  </div>
                                              </div>
                                          </th>
                                        </tr>
                                        <tr>
                                            <td>
                                            <input type="text" name="image_img" id="image_img" style="display: none">
                                            <input type="text" name="image_img" id="image_img" style="display: none">
                                            </td>
                                            <td><input type="text" name="referencia_prop" id="referencia_prop" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="status_en_sta" id="status_en_sta" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="types_en_typ" id="types_en_typ" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="town_en_twn" id="town_en_twn" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="zona_en_twn" id="zona_en_twn" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="precio" id="precio" class="form-control form-control-sm"></td>
                                            <td><input type="hidden" name="activado_prop" id="activado_prop" class="form-control form-control-sm">
                                                <select name="activado_prop_sel" id="activado_prop_sel" class="form-select form-select-sm">
                                                    <option value=""><?php __('Todos'); ?></option>
                                                    <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                    <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                               </select>
                                           </td>
                                            <td><input type="text" name="nombre_prox" id="nombre_prox" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="telefono_fijo_prox" id="telefono_fijo_prox" class="form-control form-control-sm"></td>
                                            <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td colspan="11" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                        </tr>
                                      </tbody>
                                    </table>

                                </div>
                            </div>
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

    <script>

    g_Map = $('#g_map');

    if($('.comp_lat_lng').val()  == '') {
        g_Map.gmap3({
          action: 'init',
          options:{
            center  : [40.463667, -3.749220],
            zoom    : 6
          },
          events: {
            zoom_changed: function(marker){
              $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom());
            }
          },
          callback: function(){
            $('#search_on_map').click(function(){
              $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom());
              // $('#gmap_search').val('');
               drop_marker_search();
               return false;
            })
          }
        });
    } else {
        var latLng_array = $('.comp_lat_lng').val().split(',');
        var zoomVal = ($('.zoom_gp_prop').val() == '')?16:$('.zoom_gp_prop').val()*1;
        g_Map.gmap3({
          action: 'init',
              options:{
                center  : latLng_array,
                zoom    : zoomVal
              },
              events: {
                zoom_changed: function(marker){
                  $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom());
                }
              }
          },
          {
            action: 'clear',
            name:'marker'
          },
          {
            action: 'addMarker',
            latLng: latLng_array,
            marker: {
              events: {
              dragend: function(marker){
                marker_callback(marker);
                g_Map.gmap3('get').panTo(marker.position);
              }
            },
            options: { draggable: true },
            callback: function(){
              $('#search_on_map').click(function(){
                drop_marker_search();
                return false;
                });
              }
            }
          }
        );
    }

    function marker_callback(marker) {
      $('.comp_lat_lng').val(marker.position.lat().toFixed(6)+', '+marker.position.lng().toFixed(6));

      $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom());
      g_Map.gmap3({
          action: 'getAddress',
          latLng: marker.getPosition(),
          callback: function(results){
              $('.comp_address').val(results[0].formatted_address);
          }
      });

    };

    function drop_marker_search() {
      var search_query = $('#gmap_search').val();
      if(search_query != ''){
        g_Map.gmap3(
          {
            action: 'clear',
            name: 'marker'
          },
          {   action: 'addMarker',
            address: search_query,
            map: {
              center:true,
              zoom: 15
            },
            marker: {
              events: {
                dragend: function(marker){
                  marker_callback(marker);
                  g_Map.gmap3('get').panTo(marker.position);
                }
              },
              callback: function(marker){
                if(marker){
                  $('#msgSM').html('<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmArras + '</div>');
                  marker_callback(marker);
                } else {
                  $('#msgSM').html('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmNoFound + '</div>');

                }
              },
              options: { draggable: true }
            }
          }
        )
      } else {
        $('#msgSM').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmIntrud + '</div>');
      }
    }
    </script>

<script src="/intramedianet/promotions/_js/pages-form.js?id=<?php echo time(); ?>" type="text/javascript"></script>

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

    <div id="myModal2" class="modal fade" tabindex="-1" aria-labelledby="myModal2Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModal2Label"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar nombres'); ?></h5>
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

    <div id="myModalLang" class="modal fade" tabindex="-1" aria-labelledby="myModalLangLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLangLabel"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar idioma'); ?></h5>
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
