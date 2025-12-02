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


$query_rsTipos = "
SELECT

  CASE WHEN properties_types.types_".$lang_adm."_typ IS NOT NULL THEN properties_types.types_".$lang_adm."_typ ELSE types.types_".$lang_adm."_typ END AS types_".$lang_adm."_typ,
  CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS id_type

FROM  properties_properties
    INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0

GROUP BY id_type

ORDER BY types_".$lang_adm."_typ
";
$rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsSales = "SELECT * FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsSales = mysqli_query($inmoconn,$query_rsSales) or die(mysqli_error());
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);


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

// 
// $query_rscategorias = "
// SELECT subcategories.id_ct,
//   CONCAT(news_categories.category_".$lang_adm."_ct, ' &raquo; ', subcategories.category_".$lang_adm."_ct) as cat
// FROM news_categories subcategories INNER JOIN news_categories ON subcategories.parent_ct = news_categories.id_ct
// WHERE subcategories.type_ct = 1
// ORDER BY news_categories.category_".$lang_adm."_ct ASC, subcategories.category_".$lang_adm."_ct ASC
// ";
// $rscategorias = mysqli_query($inmoconn,$query_rscategorias) or die(mysqli_error());
// $row_rscategorias = mysqli_fetch_assoc($rscategorias);
// $totalRows_rscategorias = mysqli_num_rows($rscategorias);


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

// 
// $query_rsnews_categories = "SELECT news_categories.id_ct, news_categories.category_".$lang_adm."_ct, news_categories.parent_ct, news_news_categories.new FROM news_categories LEFT JOIN news_news_categories ON (news_news_categories.cat=news_categories.id_ct AND news_news_categories.new=0123456789) WHERE (news_categories.parent_ct = 0 OR news_categories.parent_ct is NULL) AND type_ct = 1 ORDER BY news_categories.orden_ct ASC";
// $rsnews_categories = mysqli_query($inmoconn,$query_rsnews_categories) or die(mysqli_error() .'<hr>' . $query_rsnews_categories);
// $row_rsnews_categories = mysqli_fetch_assoc($rsnews_categories);
// $totalRows_rsnews_categories = mysqli_num_rows($rsnews_categories);

// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
// $formValidation->addField("categoria_nws", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields($tNG) {
  $tNG->addColumn("type_nws", "NUMERIC_TYPE", "EXPRESSION", "100");
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
  $mtm->setTable("news_news_categories");
  $mtm->setPkName("new");
  $mtm->setFkName("cat");
  $mtm->setFkReference("mtm");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("news_news_categories");
  $tblDelObj->setFieldName("new");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

// function getChildsCats($num,$par,$cnt1,$prod,$prof=0) {


//     global $database_inmoconn, $inmoconn, $sel, $lang_adm;

//     
//     $query_rsmenu = "SELECT * FROM news_categories WHERE parent_ct  = ".$num." ORDER BY category_".$lang_adm."_ct ASC";
//     $rsmenu = mysqli_query($inmoconn,$query_rsmenu) or die(mysqli_error());
//     $row_rsmenu = mysqli_fetch_assoc($rsmenu);
//     $totalRows_rsmenu = mysqli_num_rows($rsmenu);

//     
//     $query_rsSub = "SELECT * FROM news_news_categories  WHERE cat=123456789 ";
//     $rsSub = mysqli_query($inmoconn,$query_rsSub) or die(mysqli_error());
//     $row_rsSub = mysqli_fetch_assoc($rsSub);
//     $totalRows_rsSub = mysqli_num_rows($rsSub);


//     $cad = '';
//     for($i=0; $i <= $prof; $i++){
//         $cad .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//     }

//     $ret = '';
//     $sel = '';
//     do {
//                 if($row_rsmenu['id_ct']!='') {
//   if ($totalRows_rsmenu>0) {
//     $nested_query_rsSub = str_replace("123456789", $row_rsmenu['id_ct'], $query_rsSub);
//     mysqli_select_db($database_inmoconn);
//     $rsSub = mysqli_query($inmoconn,$nested_query_rsSub) or die(mysqli_error());
//     $row_rsSub = mysqli_fetch_assoc($rsSub);
//     $totalRows_rsSub = mysqli_num_rows($rsSub);
//     $nested_sw = false;
//     if (isset($row_rsSub) && is_array($row_rsSub)) {
//       do { //Nested repeat
//         if ($row_rsSub['new'] == $prod) {
//         $sel = "checked";
//         break;
//         }

//       } while ($row_rsSub = mysqli_fetch_assoc($rsSub)); //Nested move next
//     }
//   }


//             $ret .= '<div class="checkbox"><label>'.$cad.'<input id="mtm_'.$row_rsmenu['id_ct'].'" name="mtm_'.$row_rsmenu['id_ct'].'" type="checkbox" value="1" '.$sel.' class="onoffbtn" />  '.$row_rsmenu["category_".$lang_adm."_ct"].'</label></div><hr class="hr-cats">';
//             $ret .= getChildsCats($row_rsmenu['id_ct'],$row_rsmenu['parent_ct'],$cnt1,$prod,$prof+1);
//                 }
//     } while ($row_rsmenu = mysqli_fetch_assoc($rsmenu));
//     mysqli_free_result ($rsmenu);
//     return( $ret );
// }

//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache($tNG) {
    return array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
}
//end removeCache trigger

// if (isset($_POST['quick_town_nws'])) {
//   echo "<pre>";
//   print_r($_POST);
//   echo "</pre>";
//   die();
// }

// if (isset($_POST['quick_location_nws']) && $_POST['quick_location_nws'] != '' ) {
//   $_POST['quick_location_nws'] = implode(',', $_POST['quick_location_nws']);
// }
// if (isset($_POST['quick_type_nws']) && $_POST['quick_type_nws'] != '' ) {
//   $_POST['quick_type_nws'] = implode(',', $_POST['quick_type_nws']);
// }
// if (isset($_POST['quick_town_nws']) && $_POST['quick_town_nws'] != '' ) {
//   $_POST['quick_town_nws'] = implode(',', $_POST['quick_town_nws']);
// }
// if (isset($_POST['quick_province_nws']) && $_POST['quick_province_nws'] != '' ) {
//   $_POST['quick_province_nws'] = implode(',', $_POST['quick_province_nws']);
// }
// if (isset($_POST['quick_status_nws']) && $_POST['quick_status_nws'] != '' ) {
//   $_POST['quick_status_nws'] = implode(',', $_POST['quick_status_nws']);
// }

// Make an insert transaction instance
$ins_news = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_news);
// Register triggers
$ins_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_news->registerTrigger("BEFORE", "addFields", 10);
// $ins_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
$ins_news->registerTrigger("AFTER", "removeCache", 10);

// Add columns
$ins_news->setTable("news");
// $ins_news->addColumn("quick_location_nws", "STRING_TYPE", "POST", "quick_location_nws");
// $ins_news->addColumn("quick_type_nws", "STRING_TYPE", "POST", "quick_type_nws");
// $ins_news->addColumn("quick_status_nws", "STRING_TYPE", "POST", "quick_status_nws");
// $ins_news->addColumn("quick_town_nws", "STRING_TYPE", "POST", "quick_town_nws");
// $ins_news->addColumn("quick_province_nws", "STRING_TYPE", "POST", "quick_province_nws");
$ins_news->addColumn("date_nws", "DATE_TYPE", "POST", "date_nws", "".date("d-m-Y H:i:s")."");
$ins_news->addColumn("activate_nws", "CHECKBOX_1_0_TYPE", "POST", "activate_nws", "1");
$ins_news->addColumn("finished_nws", "CHECKBOX_1_0_TYPE", "POST", "finished_nws", "0");
$ins_news->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$ins_news->addColumn("typevent_nws", "NUMERIC_TYPE", "POST", "typevent_nws");

foreach($languages as $value) {
  $ins_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $ins_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $ins_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $ins_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $ins_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
  $ins_news->addColumn("tags_".$value."_nws", "STRING_TYPE", "POST", "tags_".$value."_nws");
  $ins_news->addColumn("location_".$value."_nws", "STRING_TYPE", "POST", "location_".$value."_nws");
}
$ins_news->setPrimaryKey("id_nws", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_news = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_news);
// Register triggers
$upd_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// $upd_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
$upd_news->registerTrigger("AFTER", "removeCache", 10);

// Add columns
$upd_news->setTable("news");
// $upd_news->addColumn("quick_location_nws", "STRING_TYPE", "POST", "quick_location_nws");
// $upd_news->addColumn("quick_type_nws", "STRING_TYPE", "POST", "quick_type_nws");
// $upd_news->addColumn("quick_status_nws", "STRING_TYPE", "POST", "quick_status_nws");
// $upd_news->addColumn("quick_town_nws", "STRING_TYPE", "POST", "quick_town_nws");
// $upd_news->addColumn("quick_province_nws", "STRING_TYPE", "POST", "quick_province_nws");
$upd_news->addColumn("date_nws", "DATE_TYPE", "POST", "date_nws");
$upd_news->addColumn("activate_nws", "CHECKBOX_1_0_TYPE", "POST", "activate_nws");
$upd_news->addColumn("finished_nws", "CHECKBOX_1_0_TYPE", "POST", "finished_nws");
$upd_news->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$upd_news->addColumn("typevent_nws", "NUMERIC_TYPE", "POST", "typevent_nws");

foreach($languages as $value) {
  $upd_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $upd_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $upd_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $upd_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $upd_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
  $upd_news->addColumn("tags_".$value."_nws", "STRING_TYPE", "POST", "tags_".$value."_nws");
  $upd_news->addColumn("location_".$value."_nws", "STRING_TYPE", "POST", "location_".$value."_nws");
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
// $del_news->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
$del_news->registerTrigger("AFTER", "removeCache", 10);
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

  <link rel="stylesheet" href="/intramedianet/includes/assets/_custom/vendor/tagsinput/bootstrap-tagsinput.css">

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_news" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnews['kt_pk_news']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-newspaper"></i> <?php if (@$_GET['id_nws'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Evento'); ?></h4>
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
                            <div class="card-body">

                              <div class="row">

                                  <div class="col-lg-4">

                                      <div class="<?php if($tNGs->displayFieldError("teams", "date_nws") != '') { ?>has-error<?php } ?>">
                                          <label for="date_nws" class="form-label"><?php __('Fecha'); ?></label>

                                          <!-- <input type="text" name="date_nws" id="date_nws" value="<?php echo KT_formatDate($row_rsnews['date_nws']); ?>" size="32" maxlength="255" class="form-control required" data-provider="flatpickr" data-date-format="d-m-Y" required> -->


                                          <input type="text" name="date_nws" id="date_nws" value="<?php echo KT_formatDate($row_rsnews['date_nws']); ?>" size="32" maxlength="255" class="form-control datepicktime required" required>


                                          <div class="invalid-feedback">
                                              <?php __('Este campo es obligatorio.'); ?>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("news", "date_nws"); ?>
                                      </div>

                                  </div>

                                 <!--  <div class="col-lg-3">
                                  </div> -->
                                 
                                  <div class="col-lg-4 pe-lg-5">

                                         <div class="mb-4 <?php if($tNGs->displayFieldError("news", "typevent_nws") != '') { ?>has-error<?php } ?>">
                                            <label for="typevent_nws" class="form-label"><?php __('Tipo de evento'); ?>:</label>
                                            <select name="typevent_nws" id="typevent_nws" class="select2">

                                                <option value="0" ><?php echo NXT_getResource("Select one..."); ?></option>
                                       
                                                <option value="1" <?php if ($row_rsnews['typevent_nws'] == 1) {echo "selected=\"selected\"";} ?>><?php __('Online'); ?>
                                                </option>
                                                 <option value="2" <?php if ($row_rsnews['typevent_nws'] == 2) {echo "selected=\"selected\"";} ?>><?php __('Presencial'); ?>
                                                </option>
                                                
                                            </select>
                                            <?php echo $tNGs->displayFieldError("news", "typevent_nws"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-2">

                                      <div class="mt-3">
                                          <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                              <input type="checkbox" name="activate_nws" id="activate_nws" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                              <label class="form-check-label" for="activate_nws"><?php __('Mostrar en la web'); ?></label>
                                              <?php echo $tNGs->displayFieldError("news", "activate_nws"); ?>
                                          </div>
                                      </div>

                                  </div>
                                  <div class="col-lg-2">

                                      <div class="mt-3">
                                          <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                              <input type="checkbox" name="finished_nws" id="finished_nws" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['finished_nws']),"1"))) {echo "checked";} ?>>
                                              <label class="form-check-label " for="finished_nws">
                                                  <span class="text-danger"><?php __('Evento Finalizado'); ?></span>
                                              </label>
                                              <?php echo $tNGs->displayFieldError("news", "finished_nws"); ?>
                                          </div>
                                      </div>

                                  </div>
                                  <div class="col-lg-5">
                                             
                                     <label for="location_<?php echo $value; ?>_nws" class="form-label"><?php __('Dirección'); ?>:</label>
                                      <input type="text" name="location_<?php echo $value; ?>_nws" id="location_<?php echo $value; ?>_nws" value="<?php echo KT_escapeAttribute($row_rsnews['location_'.$value.'_nws']); ?>" size="32" maxlength="255" class="form-control" >

                                 </div>
                                  <div class="col-lg-7">

                                      <div class="mb-4">
                                          <label for="direccion_gp_prop" class="form-label"><?php __('URL'); ?> <?php __('Localización'); ?>:</label>
                                          <input placeholder="https://..." type="text" name="direccion_gp_prop" id="direccion_gp_prop" value="<?php echo KT_escapeAttribute($row_rsnews['direccion_gp_prop']); ?>" size="32" maxlength="255" class="form-control" >
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

                                       <div class="row">
                                         
                                         <div class="col-lg-12">
                                            <div class="mb-4">
                                              <label for="title_<?php echo $value; ?>_nws" class="form-label"><?php __('Titular'); ?>:</label>
                                              <input type="text" name="title_<?php echo $value; ?>_nws" id="title_<?php echo $value; ?>_nws" value="<?php echo KT_escapeAttribute($row_rsnews['title_'.$value.'_nws']); ?>" size="32" maxlength="255" class="form-control required" required>
                                              <?php echo $tNGs->displayFieldError("news", "title_".$value."_nws"); ?>
                                              <div class="invalid-feedback">
                                                  <?php __('Este campo es obligatorio.'); ?>
                                              </div>
                                              <?php if ($traduccion_textos == 1): ?>
                                                  <div class="float-endmb-4">
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
                                         </div>
                                         

                                       </div>

                                        
                                        <div class="mb-4">
                                            <label for="tags_<?php echo $value; ?>_nws" class="form-label"><?php __('Descripción'); ?>:</label>

                                             <textarea maxlength="512" cols="50" rows="2" class="form-control" name="tags_<?php echo $value; ?>_nws" id="tags_<?php echo $value; ?>_nws" ><?php echo KT_escapeAttribute($row_rsnews['tags_'.$value.'_nws']); ?></textarea>

                                            <?php echo $tNGs->displayFieldError("news", "tags_".$value."_nws"); ?>
                                            
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-endmb-4">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="tags_"
                                                            data-fields-suf="_nws"
                                                            data-tab="title"
                                                        ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                                <br>
                                            <?php endif ?>
                                        </div>

                                        <textarea name="content_<?php echo $value; ?>_nws" id="content_<?php echo $value; ?>_nws" rows="4" class="wysiwyg mt-5"><?php echo KT_escapeAttribute($row_rsnews['content_'.$value.'_nws']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("news", "content_".$lang_adm."__nws"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end">
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

                                        <br class="d-md-none">
                                        <br class="d-md-none">

                                        <!-- <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert">
                                            <i class="fa-regular fa-circle-info label-icon"></i>{image}: <?php __('Imagen a tamaño real'); ?> | {image-left}: <?php __('Imagen alineada a la izquierda'); ?> | {image-right}: <?php __('Imagen alineada a la derecha'); ?> | {image-pan}: <?php __('Imagen panorámica'); ?>
                                        </div> -->

                                       

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
                                <br>
                                
                                <div class="card p-2 bg-light mt-3">
                                    <p class="mb-2">
                                        <small><i class="fa-regular fa-image fa-fw"></i> <?php __('Puedes seleccionar la foto principal para mostrar en listados y cabecera del evento editandola y haciendo click sobre el check correspondiente'); ?>.</small> *
                                    </p>
                                    <p class="mb-0">
                                        <small><i class="fa-regular fa-mobile fa-fw"></i> <?php __('Puedes seleccionar una foto para dispositivos móviles editandola y haciendo click sobre el check correspondiente'); ?>.</small> *
                                    </p>
                                    <hr>
                                    <small>
                                      * <?php __('En caso contrario se usará la primera foto de la galería tanto para la vista de esctritorio como para móviles'); ?>
                                    </small>
                                </div>

                                <i class="fa fa-picture-o"></i>  

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
                                                preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $row_rsVideos['video_vid'], $match);
                                                $arr = explode(",", $match[0][1]);
                                                ?>
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="<?php echo $match[0][0]; ?>" allowfullscreen></iframe>
                                                </div>
                                                <p class="text-center mt-1">
                                                    <a href="/intramedianet/pages/videos_del.php" data-id="<?php echo $row_rsVideos['id_vid'] ?>" class="btn btn-danger btn-sm del-vid">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </a>
                                                </p>
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

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var idNews = '<?php echo $news_id; ?>';
    </script>

    <script src="/intramedianet/events/_js/news-form.js?id=<?php echo time(); ?>" type="text/javascript"></script>
 

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
