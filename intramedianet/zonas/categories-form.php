<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

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

// if (isset($_POST)) {
//     echo "<pre>";
//     print_r($_POST);
//     echo "</pre>";
// }



  if (!isset($_GET['id_ct']))
  {

    
    $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'news_categories'";
    $rsNextIncrement = mysqli_query($inmoconn,$query_rsNextIncrement) or die(mysqli_error());
    $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

    $cat_id = $row_rsNextIncrement['Auto_increment'];

  } else {

    $cat_id = $_GET['id_ct'];

  }

$row_rsImages = array();
$totalRows_rsImages = 0;
if(isset($_GET['id_ct'])){
  $query_rsImages = "SELECT * FROM zonas_images WHERE zona_img = '".$_GET['id_ct']."' ORDER BY order_img";
  $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
  $row_rsImages = mysqli_fetch_assoc($rsImages);
  $totalRows_rsImages = mysqli_num_rows($rsImages);
}

$query_Recordset2 = "
 SELECT DISTINCT

    properties_loc1.name_".$lang_adm."_loc1 ,
    CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS name_".$lang_adm."_loc2,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id_loc2,
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

WHERE 1=1

GROUP BY CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END

ORDER BY name_".$lang_adm."_loc1, name_".$lang_adm."_loc2, name_".$lang_adm."_loc3, name_".$lang_adm."_loc4 ASC

";

// WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

$Recordset2 = mysqli_query($inmoconn,$query_Recordset2) or die(mysqli_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_rsVideos = "SELECT * FROM news_categories_videos WHERE news_vid = '".$cat_id."' ORDER BY order_vid";
$rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
$row_rsVideos = mysqli_fetch_assoc($rsVideos);
$totalRows_rsVideos = mysqli_num_rows($rsVideos);

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
  $tblFldObj->setFieldName("categoria_ct");
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
  $tNG->addColumn("type_ct", "NUMERIC_TYPE", "EXPRESSION", "6");
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


function replaceTags($startPoint, $endPoint, $newText, $source) {
    return preg_replace('@('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')@si', '$1'.$newText.'$3', $source);
}

function slug($str, $options = array())
{

    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
  $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

  $defaults = array(
    'delimiter' => '-',
    'limit' => null,
    'lowercase' => true,
    'replacements' => array(),
    'transliterate' => true,
  );

  // Merge options
  $options = array_merge($defaults, $options);

  $char_map = array(
    // Latin
    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
    'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
    'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
    'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
    'ß' => 'ss',
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
    'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
    'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
    'ÿ' => 'y',

    // Latin symbols
    '©' => '(c)',

    // Greek
    'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
    'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
    'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
    'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
    'Ϋ' => 'Y',
    'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
    'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
    'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
    'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
    'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

    // Turkish
    'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
    'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

    // Russian
    'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
    'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
    'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
    'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
    'Я' => 'Ya',
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
    'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
    'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
    'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
    'я' => 'ya',

    // Ukrainian
    'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
    'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

    // Czech
    'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
    'Ž' => 'Z',
    'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
    'ž' => 'z',

    // Polish
    'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
    'Ż' => 'Z',
    'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
    'ż' => 'z',

    // Latvian
    'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
    'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
    'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
    'š' => 's', 'ū' => 'u', 'ž' => 'z'
  );

  // Make custom replacements
  $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

  // Transliterate characters to ASCII
  if ($options['transliterate']) {
    $str = str_replace(array_keys($char_map), $char_map, $str);
  }

  // Replace non-alphanumeric characters with our delimiter
  $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

  // Remove duplicate delimiters
  $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

  // Truncate slug to max. characters
  $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

  // Remove delimiter from ends
  $str = trim($str, $options['delimiter']);

  return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;

}

//start Trigger_UpdateHtaccess trigger
//remove this line if you want to edit the code by hand
function Trigger_UpdateHtaccess(&$tNG) {

  global $database_inmoconn, $inmoconn, $language, $languages;
  
  $query_rsLandings = "SELECT * FROM news_categories WHERE type_ct = 6";
  $rsLandings = mysqli_query($inmoconn,$query_rsLandings) or die(mysqli_error());
  $row_rsLandings = mysqli_fetch_assoc($rsLandings);
  $totalRows_rsLandings = mysqli_num_rows($rsLandings);

  $newText = '';

  do {

    foreach($languages as $value) {
      if ($row_rsLandings['category_'.$value.'_ct'] != '') {
          if ($value == $language) {
              $newText .= "\nRewriteRule ^".slug($row_rsLandings['category_'.$value.'_ct']).".html$ properties/?lang=".$value."&zon=".$row_rsLandings['id_ct']." [L,QSA]";
          } else {
              $newText .= "\nRewriteRule ^".$value."/".slug($row_rsLandings['category_'.$value.'_ct']).".html$ properties/?lang=".$value."&zon=".$row_rsLandings['id_ct']." [L,QSA]";
          }

      }
    }

  } while ($row_rsLandings = mysqli_fetch_assoc($rsLandings));

  // echo $newText;
  // aa();
  //var_dump($newText); die;

  $filename = $_SERVER["DOCUMENT_ROOT"] . '/.htaccess';
  $htaccess = file_get_contents($filename);

  $htaccess = replaceTags('## zonas','## end zonas', $newText . "\n", $htaccess);
  file_put_contents($filename, $htaccess);

  // aa();

  return true;
}
//end Trigger_UpdateHtaccess trigger

//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache(&$tNG) {
    return array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
}
//end removeCache trigger

if (isset($_POST['provinces_ct']) && $_POST['provinces_ct'] != '' ) {
  $_POST['provinces_ct'] = implode(',', $_POST['provinces_ct']);
}

// Make an insert transaction instance
$ins_news_categories = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_news_categories);
// Register triggers
$ins_news_categories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_news_categories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_news_categories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_news_categories->registerTrigger("BEFORE", "addFields", 10);
$ins_news_categories->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_news_categories->registerTrigger("AFTER", "Trigger_UpdateHtaccess", 97);
$ins_news_categories->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$ins_news_categories->setTable("news_categories");
$ins_news_categories->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$ins_news_categories->addColumn("lat_long_gp_prop", "STRING_TYPE", "POST", "lat_long_gp_prop");
$ins_news_categories->addColumn("zoom_gp_prop", "STRING_TYPE", "POST", "zoom_gp_prop");
$ins_news_categories->addColumn("provinces_ct", "STRING_TYPE", "POST", "provinces_ct");
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
$upd_news_categories->registerTrigger("AFTER", "Trigger_UpdateHtaccess", 97);
$upd_news_categories->registerTrigger("AFTER", "removeCache", 10);
// Add columns
$upd_news_categories->setTable("news_categories");
$upd_news_categories->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$upd_news_categories->addColumn("lat_long_gp_prop", "STRING_TYPE", "POST", "lat_long_gp_prop");
$upd_news_categories->addColumn("zoom_gp_prop", "STRING_TYPE", "POST", "zoom_gp_prop");
$upd_news_categories->addColumn("provinces_ct", "STRING_TYPE", "POST", "provinces_ct");
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
$del_news_categories->registerTrigger("AFTER", "removeCache", 10);
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

        <input type="hidden" name="kt_pk_news_categories" class="id_field" value="<?php if(isset($row_rsnews_categories['kt_pk_news_categories'])) echo KT_escapeAttribute($row_rsnews_categories['kt_pk_news_categories']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-location-dot"></i> <a href="news.php"><?php echo __('Zonas'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php if (@$_GET['id_ct'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Costa'); ?></h4>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Inmuebles'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group <?php if($tNGs->displayFieldError("news_categories", "provinces_ct") != '') { ?>error<?php } ?>">
                                            <label for="provinces_ct" class="form-label"><?php __('Añadir inmuebles del area'); ?>:</label>
                                                  <select name="provinces_ct[]" id="provinces_ct" class="select2" multiple="">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php do {
                                                $vals = explode(',', $row_rsnews_categories['provinces_ct']);
                                              ?>
                                              <option value="<?php echo $row_Recordset2['id_loc2']; ?>" <?php if(in_array($row_Recordset2['id_loc2'], $vals)) {echo "SELECTED";} ?>><?php echo $row_Recordset2['name_'.$lang_adm.'_loc2']; ?></option>

                                                <?php
                                                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                                                $rows = mysqli_num_rows($Recordset2);
                                                if($rows > 0) {
                                                mysqli_data_seek($Recordset2, 0);
                                                $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                                                }
                                                ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                <?php echo $tNGs->displayFieldError("news_categories", "provinces_ct"); ?>
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
                                            <label for="category_<?php echo $value; ?>_ct" class="form-label"><?php __('Costa'); ?>:</label>
                                            <input type="text" name="category_<?php echo $value; ?>_ct" id="category_<?php echo $value; ?>_ct" value="<?php echo KT_escapeAttribute($row_rsnews_categories['category_'.$value.'_ct']); ?>" size="32" maxlength="255" class="form-control">
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
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

                                        <br class="d-mnd-none">
                                        <br class="d-mnd-none">

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

                                <ul class="thumbnails clearfix nested-sortablez" id="imagesz-list">

                                <?php if($totalRows_rsImages > 0) { ?>

                                <?php do { ?>

                                <?php if($row_rsImages['image_img'] != '') { ?>

                                <li class="pull-left" id="order_<?php echo $row_rsImages['id_img'] ?>" data-id="<?php echo $row_rsImages['id_img'] ?>">

                                <div class="img-thumbnail pull-left">
                                  <?php echo showThumbnail($row_rsImages['image_img'], '/media/images/zonas/', 150, 100); ?>
                                  <p class="text-center"><a href="#" class="btn btn-success btn-sm edit-alt" data-id="<?php echo $row_rsImages['id_img'] ?>"><i class="fa-regular fa-pencil"></i></a> <a href="imagesz_del.php" data-id="<?php echo $row_rsImages['id_img'] ?>" class="btn btn-danger btn-sm del-img"><i class="fa-regular fa-trash-can"></i></a>

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
                                              <p class="text-center"><a href="/intramedianet/zonas/videos_del2.php" data-id="<?php echo $row_rsVideos['id_vid'] ?>" class="btn btn-danger btn-sm del-vid"><i class="fa-regular fa-trash-can"></i></a></p>
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

                                    <a href="#" class="btn btn-success btn-sm float-end mt-2" id="addVid2"  data-id="<?php echo $cat_id; ?>"><?php __('Añadir vídeo'); ?></a>

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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Google Maps'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-5">

                                      <div class="pb-md-4 <?php if($tNGs->displayFieldError("properties_properties", "direccion_gp_prop") != '') { ?>has-error<?php } ?>">
                                          <label class="form-label">&nbsp;</label>
                                          <a href="https://www.google.es/maps" target="_blank" class="btn btn-info w-100"><i class="fa-regular fa-map-location-dot"></i> <?php __('Ir a Google Maps'); ?></a>
                                      </div>

                                    </div> <!--/.col-md-7 -->

                                    <div class="col-md-4">

                                        <div class="mb-4 mb-md-0 <?php if($tNGs->displayFieldError("news_categories", "lat_long_gp_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="lat_long_gp_prop" class="form-label"><?php __('Latitud y longitud'); ?>:</label>
                                            <div class="input-group">
                                                <input type="text" name="lat_long_gp_prop" id="lat_long_gp_prop" value="<?php echo KT_escapeAttribute($row_rsnews_categories['lat_long_gp_prop']); ?>" size="32" maxlength="255" class="form-control comp_lat_lng">
                                                <button class="btn btn-primary btn-copy-latlong" type="button" onclick="copyToClipboard('#lat_long_gp_prop')"><i class="fa-regular fa-clipboard"></i></button>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("news_categories", "lat_long_gp_prop"); ?>
                                        </div>

                                    </div> <!--/.col-md-3 -->

                                    <div class="col-md-3">

                                        <div class="form-group <?php if($tNGs->displayFieldError("news_categories", "zoom_gp_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="zoom_gp_prop" class="form-label"><?php __('Zoom'); ?>:</label>
                                            <input type="text" name="zoom_gp_prop" id="zoom_gp_prop" value="<?php echo KT_escapeAttribute($row_rsnews_categories['zoom_gp_prop']); ?>" size="32" maxlength="255" class="form-control zoom_gp_prop">
                                            <?php echo $tNGs->displayFieldError("news_categories", "zoom_gp_prop"); ?>
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
                                                  <div class="float-end mb-4">
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

    <script>

    idNews = '<?php echo $cat_id ?>';

    $(".multi_images").pluploadQueue({
      runtimes : 'html5,flash,silverlight,html4',
      url : '/intramedianet/zonas/imagesz_upload.php?id_ct=' + idNews,
      max_file_size : '100mb',
      unique_names : true,
      multiple_queues: true,
      // browse_button : 'pickfiles',
      preinit : attachCallbacks,
      dragdrop: true,
      filters : {
        mime_types: [
          {title : "Image files", extensions : "jpg,jpeg,gif,png"}
        ]
      },
      resize : {width : 1920, height : 1280, quality : 90},
      flash_swf_url : '../includes/assets/swf/Moxie.swf',
      silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
    });

    function attachCallbacks(uploader) {
        uploader.bind('FileUploaded', function(Up, File, Response) {
        if( (uploader.total.uploaded + 1) == uploader.files.length) {
            $.get("imagesz_list.php?id_ct=" + idNews, function(data) {
            if(data != '') {
                $('#imagesz-list').html(data);
            }
            });
        }
        });
    }

    $(document).on('click', '.edit-alt', function(e) {
      e.preventDefault();
      tb = $(this);
      $('#myModal').modal('show').on('shown.bs.modal', function () {
        $.get('imagesz_alts.php', { p: tb.attr('data-id') }, function(data) {
          $('#myModal .loadingfrm').css('background', '#fff').html(data);
        });
      }).on('hide.bs.modal', function () {
        var altsVals = $('#myModal :input').serialize();
        $.get('imagesz_alts.php?' + altsVals,  function(data) {
          $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
          $.get("imagesz_list.php?id_ct=" + idNews, function(data) {
            if(data != '') {
              $('#imagesz-list').html(data);
            }
          });
        });
      });
    });

    var nestedSortablesHandlesz = [].slice.call(document.querySelectorAll('.nested-sortablez'));
    if (nestedSortablesHandlesz) {
        Array.from(nestedSortablesHandlesz).forEach(function (nestedSortHandlez){
            sortable = new Sortable(nestedSortHandlez, {
                // handle: '.handle',
                // group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                var order = sortable.toArray();
                $('#img-order-loading').css({ width: $('#images-list').outerWidth(), height: $('#images-list').outerHeight() + 5 }).fadeIn();
                    $.get("imagesz_order.php?order="+order, function(data) {
                        $('#img-order-loading').fadeOut();
                    });
                }
            });
        });
    }


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

    <script>
    //  ============================================================================
    //  === Videos Add
    //  ============================================================================

    $('#addVid2').click(function (e){
        tb = $(this);
        e.preventDefault();
        if($('#video').val() != ''){
            $.get('videos_add2.php', { p: tb.attr('data-id'), vid: $('#video').val() }, function(data) {
                $('#videos-list').append(data);
                $('#video').val('');
            });
        }
    });

    //  ============================================================================
    //  === Videos Order
    //  ============================================================================

    var nestedSortablesVideo = [].slice.call(document.querySelectorAll('.nested-sortable-video'));
    if (nestedSortablesVideo) {
        Array.from(nestedSortablesVideo).forEach(function (nestedSortVideo){
            sortableVid = new Sortable(nestedSortVideo, {
                // handle: '.handle',
                // group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                var order = sortableVid.toArray();
                $('#video-order-loading').css({ width: $('#videos-list').outerWidth(), height: $('#videos-list').outerHeight() + 5 }).fadeIn();
                    $.get("videos_order2.php?order="+order, function(data) {
                        $('#video-order-loading').fadeOut();
                    });
                }
            });
        });
    }
    </script>

</body>
</html>
