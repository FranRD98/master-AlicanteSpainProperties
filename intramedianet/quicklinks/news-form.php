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


$query_rscosta = "SELECT id_cst, coast_".$lang_adm."_cst as costa FROM properties_coast WHERE coast_".$lang_adm."_cst IS NOT NULL ORDER BY coast_".$lang_adm."_cst ASC";
$rscosta = mysqli_query($inmoconn,$query_rscosta) or die(mysqli_error() . '<hr>' . $query_rscosta);
$row_rscosta = mysqli_fetch_assoc($rscosta);
$totalRows_rscosta = mysqli_num_rows($rscosta);


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


$query_rsOpciones = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features ORDER BY name ASC";
$rsOpciones = mysqli_query($inmoconn,$query_rsOpciones) or die(mysqli_error());
$row_rsOpciones = mysqli_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysqli_num_rows($rsOpciones);


$query_rsTags = "SELECT id_tag as id, tag_".$lang_adm."_tag as name FROM properties_tags ORDER BY name ASC";
$rsTags = mysqli_query($inmoconn,$query_rsTags) or die(mysqli_error());
$row_rsTags = mysqli_fetch_assoc($rsTags);
$totalRows_rsTags = mysqli_num_rows($rsTags);


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

// Start trigger
$formValidation = new tNG_FormValidation();
foreach($languages as $value) {
$formValidation->addField("categoria_nws", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  $tNG->addColumn("type_nws", "NUMERIC_TYPE", "EXPRESSION", "4");
  return $tNG->getError();
}
//end addFields trigger

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("news_fotos");
  $tblDelObj->setFieldName("noticia_img");
  $tblDelObj->addFile("{imagen_img}", "../../media/images/news/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail trigger

//start Trigger_DeleteDetail3 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail3(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("news_videos");
  $tblDelObj->setFieldName("news_vid");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail3 trigger

//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany(&$tNG) {
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

  include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

  global $database_inmoconn, $inmoconn, $language, $languages, $actCostas;
  
  $query_rsLandings = "SELECT * FROM news WHERE type_nws = 4";
  $rsLandings = mysqli_query($inmoconn,$query_rsLandings) or die(mysqli_error());
  $row_rsLandings = mysqli_fetch_assoc($rsLandings);
  $totalRows_rsLandings = mysqli_num_rows($rsLandings);

  $newText = '';

  do {

    foreach($languages as $value) {
      if ($row_rsLandings['title_'.$value.'_nws'] != '') {


         $prov = '';
         if ($actCostas == 1)
         {
            if ($row_rsLandings['quick_costa_nws'] != '') 
            {
                $parts = explode(',', $row_rsLandings['quick_costa_nws']);
                foreach ($parts as $part) {
                    $prov .= '&coast\%5B\%5D=' . $part;
                }
            }
        }
        else 
        {
          if ($row_rsLandings['quick_province_nws'] != '') {
              $parts = explode(',', $row_rsLandings['quick_province_nws']);
              foreach ($parts as $part) {
                  $prov .= '&lopr\%5B\%5D=' . $part;
              }
          }
        }

        $tw = '';
        if ($row_rsLandings['quick_town_nws'] != '') {
            $parts = explode(',', $row_rsLandings['quick_town_nws']);
            foreach ($parts as $part) {
                $tw .= '&loct\%5B\%5D=' . $part;
            }
        }

        $loc = '';
        if ($row_rsLandings['quick_location_nws'] != '') {
            $parts = explode(',', $row_rsLandings['quick_location_nws']);
            foreach ($parts as $part) {
                $loc .= '&lozn\%5B\%5D=' . $part;
            }
        }

        $typ = '';
        if ($row_rsLandings['quick_type_nws'] != '') {
            $parts = explode(',', $row_rsLandings['quick_type_nws']);
            foreach ($parts as $part) {
                $typ .= '&tp\%5B\%5D=' . $part;
            }
        }

        $sta = '';
        if ($row_rsLandings['quick_status_nws'] != '') {
            $parts = explode(',', $row_rsLandings['quick_status_nws']);
            foreach ($parts as $part) {
                $sta .= '&st\%5B\%5D=' . $part;
            }
        }

        $features = '';
        if ($row_rsLandings['quick_features_nws'] != '') {
            $parts = explode(',', $row_rsLandings['quick_features_nws']);
            foreach ($parts as $part) {
                $features .= '&features\%5B\%5D=' . $part;
            }
        }

        $tags = '';
        if ($row_rsLandings['quick_tags_nws'] != '') {
            $parts = explode(',', $row_rsLandings['quick_tags_nws']);
            foreach ($parts as $part) {
                $tags .= '&tags\%5B\%5D=' . $part;
            }
        }

        $prds = '';
        if ($row_rsLandings['quick_price_from_nws'] != '') {
            $prds .= '&prds=' . $row_rsLandings['quick_price_from_nws'];
        }

        $prhs = '';
        if ($row_rsLandings['quick_price_up_to_nws'] != '') {
            $prhs .= '&prhs=' . $row_rsLandings['quick_price_up_to_nws'];
        }

        if ($language == $value) {
            $newText .= "\nRewriteRule ^".slug($row_rsLandings['title_'.$value.'_nws']).".html$ ".$urlStr["properties"][$value]."/?lang=".$value."&idquick=".$row_rsLandings['id_nws']."".$prov."".$loc."".$tw."".$typ."".$sta."".$features."".$tags."".$prds."".$prhs." [L,QSA]";
        } else {
            $newText .= "\nRewriteRule ^".$value."/".slug($row_rsLandings['title_'.$value.'_nws']).".html$ ".$urlStr["properties"][$value]."/?lang=".$value."&idquick=".$row_rsLandings['id_nws']."".$prov."".$loc."".$tw."".$typ."".$sta."".$features."".$tags."".$prds."".$prhs." [L,QSA]";
        }

      }
    }

  } while ($row_rsLandings = mysqli_fetch_assoc($rsLandings));

  $filename = $_SERVER["DOCUMENT_ROOT"] . '/.htaccess';
  $htaccess = file_get_contents($filename);

  $htaccess = replaceTags('## quicklinks','## end quicklinks', $newText . "\n", $htaccess);
  file_put_contents($filename, $htaccess);

  return true;
}
//end Trigger_UpdateHtaccess trigger

//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache(&$tNG) {
    return array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
}
//end removeCache trigger

if (isset($_POST['quick_status_nws']) && $_POST['quick_status_nws'] != '' ) {
  $_POST['quick_status_nws'] = implode(',', $_POST['quick_status_nws']);
}
if (isset($_POST['quick_features_nws']) && $_POST['quick_features_nws'] != '' ) {
  $_POST['quick_features_nws'] = implode(',', $_POST['quick_features_nws']);
}
if (isset($_POST['quick_tags_nws']) && $_POST['quick_tags_nws'] != '' ) {
  $_POST['quick_tags_nws'] = implode(',', $_POST['quick_tags_nws']);
}
if (isset($_POST['quick_type_nws']) && $_POST['quick_type_nws'] != '' ) {
  $_POST['quick_type_nws'] = implode(',', $_POST['quick_type_nws']);
}
if (isset($_POST['quick_town_nws']) && $_POST['quick_town_nws'] != '' ) {
  $_POST['quick_town_nws'] = implode(',', $_POST['quick_town_nws']);
}
if (isset($_POST['quick_location_nws']) && $_POST['quick_location_nws'] != '' ) {
  $_POST['quick_location_nws'] = implode(',', $_POST['quick_location_nws']);
}
if (isset($_POST['quick_province_nws']) && $_POST['quick_province_nws'] != '' ) {
  $_POST['quick_province_nws'] = implode(',', $_POST['quick_province_nws']);
}
if (isset($_POST['quick_costa_nws']) && $_POST['quick_costa_nws'] != '' ) {
  $_POST['quick_costa_nws'] = implode(',', $_POST['quick_costa_nws']);
}

// var_dump($_POST);
// die();

// Make an insert transaction instance
$ins_news = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_news);
// Register triggers
$ins_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_news->registerTrigger("BEFORE", "addFields", 10);
$ins_news->registerTrigger("AFTER", "Trigger_UpdateHtaccess", 97);
$ins_news->registerTrigger("AFTER", "removeCache", 10);
// $ins_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// Add columns
$ins_news->setTable("news");
$ins_news->addColumn("date_nws", "DATE_TYPE", "POST", "date_nws", "".date("d-m-Y")."");
$ins_news->addColumn("activate_nws", "CHECKBOX_1_0_TYPE", "POST", "activate_nws", "1");
$ins_news->addColumn("destacado_nws", "CHECKBOX_1_0_TYPE", "POST", "destacado_nws", "0");
foreach($languages as $value) {
  $ins_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $ins_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $ins_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $ins_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $ins_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
}
$ins_news->addColumn("quick_location_nws", "STRING_TYPE", "POST", "quick_location_nws");
$ins_news->addColumn("quick_type_nws", "STRING_TYPE", "POST", "quick_type_nws");
$ins_news->addColumn("quick_status_nws", "STRING_TYPE", "POST", "quick_status_nws");
$ins_news->addColumn("quick_features_nws", "STRING_TYPE", "POST", "quick_features_nws");
$ins_news->addColumn("quick_tags_nws", "STRING_TYPE", "POST", "quick_tags_nws");
$ins_news->addColumn("quick_price_from_nws", "NUMERIC_TYPE", "POST", "quick_price_from_nws");
$ins_news->addColumn("quick_price_up_to_nws", "NUMERIC_TYPE", "POST", "quick_price_up_to_nws");
$ins_news->addColumn("quick_town_nws", "STRING_TYPE", "POST", "quick_town_nws");
$ins_news->addColumn("quick_province_nws", "STRING_TYPE", "POST", "quick_province_nws");
 if ($actCostas == 1)
 {
    $ins_news->addColumn("quick_costa_nws", "STRING_TYPE", "POST", "quick_costa_nws");
 }

$ins_news->setPrimaryKey("id_nws", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_news = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_news);
// Register triggers
$upd_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_news->registerTrigger("AFTER", "Trigger_UpdateHtaccess", 97);
$upd_news->registerTrigger("AFTER", "removeCache", 10);
// $upd_news->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// Add columns
$upd_news->setTable("news");
$upd_news->addColumn("date_nws", "DATE_TYPE", "POST", "date_nws");
$upd_news->addColumn("activate_nws", "CHECKBOX_1_0_TYPE", "POST", "activate_nws");
$upd_news->addColumn("destacado_nws", "CHECKBOX_1_0_TYPE", "POST", "destacado_nws");
foreach($languages as $value) {
  $upd_news->addColumn("title_".$value."_nws", "STRING_TYPE", "POST", "title_".$value."_nws");
  $upd_news->addColumn("content_".$value."_nws", "STRING_TYPE", "POST", "content_".$value."_nws");
  $upd_news->addColumn("titlew_".$value."_nws", "STRING_TYPE", "POST", "titlew_".$value."_nws");
  $upd_news->addColumn("description_".$value."_nws", "STRING_TYPE", "POST", "description_".$value."_nws");
  $upd_news->addColumn("keywords_".$value."_nws", "STRING_TYPE", "POST", "keywords_".$value."_nws");
}
$upd_news->addColumn("quick_location_nws", "STRING_TYPE", "POST", "quick_location_nws");
$upd_news->addColumn("quick_type_nws", "STRING_TYPE", "POST", "quick_type_nws");
$upd_news->addColumn("quick_status_nws", "STRING_TYPE", "POST", "quick_status_nws");
$upd_news->addColumn("quick_features_nws", "STRING_TYPE", "POST", "quick_features_nws");
$upd_news->addColumn("quick_tags_nws", "STRING_TYPE", "POST", "quick_tags_nws");
$upd_news->addColumn("quick_price_from_nws", "NUMERIC_TYPE", "POST", "quick_price_from_nws");
$upd_news->addColumn("quick_price_up_to_nws", "NUMERIC_TYPE", "POST", "quick_price_up_to_nws");
$upd_news->addColumn("quick_town_nws", "STRING_TYPE", "POST", "quick_town_nws");
$upd_news->addColumn("quick_province_nws", "STRING_TYPE", "POST", "quick_province_nws");

 if ($actCostas == 1)
 {
    $upd_news->addColumn("quick_costa_nws", "STRING_TYPE", "POST", "quick_costa_nws");
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
$del_news->registerTrigger("AFTER", "Trigger_UpdateHtaccess", 97);
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


</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_news" class="id_field" value="<?php if(isset($row_rsnews['kt_pk_news'])) echo KT_escapeAttribute($row_rsnews['kt_pk_news']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-link"></i> <?php if (@$_GET['id_nws'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Quicklinks'); ?></h4>
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

                                  <div class="col-lg-3">

                                      <div class="<?php if($tNGs->displayFieldError("teams", "date_nws") != '') { ?>has-error<?php } ?>">
                                          <label for="date_nws" class="form-label"><?php __('Fecha'); ?></label>
                                          <input type="text" name="date_nws" id="date_nws" value="<?php echo KT_formatDate($row_rsnews['date_nws']); ?>" size="32" maxlength="255" class="form-control required" data-provider="flatpickr" data-date-format="d-m-Y" required>
                                          <div class="invalid-feedback">
                                              <?php __('Este campo es obligatorio.'); ?>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("news", "date_nws"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-1">

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mt-3">
                                          <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                              <input type="checkbox" name="activate_nws" id="activate_nws" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['activate_nws']),"1"))) {echo "checked";} ?>>
                                              <label class="form-check-label" for="activate_nws"><?php __('Mostrar en la web'); ?></label>
                                              <?php echo $tNGs->displayFieldError("news", "activate_nws"); ?>
                                          </div>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mt-3">
                                          <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                              <input type="checkbox" name="destacado_nws" id="destacado_nws" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['destacado_nws']),"1"))) {echo "checked";} ?>>
                                              <label class="form-check-label" for="destacado_nws"><?php __('Destacado'); ?></label>
                                              <?php echo $tNGs->displayFieldError("news", "destacado_nws"); ?>
                                          </div>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Inmuebles'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <?php if ($actCostas == 1): ?>
                                      
                                      <div class="col-lg-4">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_costa_nws") != '') { ?>has-error<?php } ?>">
                                        
                                                
                                                 <label for="quick_costa_nws"><?php __('Costa'); ?> </label>
                                               
                                                <select name="quick_costa_nws[]" id="quick_costa_nws" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">

                                                  <?php 
                                                  $vals = explode(',', $row_rsnews['quick_costa_nws']);

                                                  do 
                                                  {  
                                                    ?>
              
                                                      <option value="<?php echo $row_rscosta['id_cst']; ?>"<?php if (in_array($row_rscosta['id_cst'], $vals)) {echo "SELECTED";} ?>>
                                                        <?php echo $row_rscosta['costa']?> 
                                                      </option>

                                                    <?php
                                                    } while ($row_rscosta = mysqli_fetch_assoc($rscosta));
                                                    $rows = mysqli_num_rows($rscosta);
                                                    if($rows > 0) {
                                                    mysqli_data_seek($rscosta, 0);
                                                    $row_rscosta = mysqli_fetch_assoc($rscosta);
                                                    }
                                                    ?>
                                                  </select>

                                                <?php echo $tNGs->displayFieldError("news", "quick_costa_nws"); ?>
                                          </div>

                                      </div>

                                    <?php endif ?>

                                      <div class="col-lg-4 <?php if ($actCostas == 1) { echo 'd-none'; } ?> " >

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_province_nws") != '') { ?>has-error<?php } ?>">
                                              <label for="quick_province_nws"><?php __('Provincia'); ?>:</label>
                                              <select name="quick_province_nws[]" id="quick_province_nws" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                  <?php
                                                  do {
                                                    $vals = explode(',', $row_rsnews['quick_province_nws']);
                                                  ?>
                                                  <option value="<?php echo $row_rsProvincias['id_loc2']?>"<?php if (in_array($row_rsProvincias['id_loc2'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsProvincias['name_'.$lang_adm.'_loc1']; ?> &raquo; <?php echo $row_rsProvincias['name_'.$lang_adm.'_loc2']; ?></option>
                                                  <?php
                                                  } while ($row_rsProvincias = mysqli_fetch_assoc($rsProvincias ));
                                                  $rows = mysqli_num_rows($rsProvincias );
                                                  if($rows > 0) {
                                                  mysqli_data_seek($rsProvincias , 0);
                                                  $row_rsProvincias = mysqli_fetch_assoc($rsProvincias );
                                                  }
                                                  ?>
                                              </select>
                                              <?php echo $tNGs->displayFieldError("news", "quick_province_nws"); ?>
                                          </div>

                                      </div>

                                    
                                    
                                    <div class="col-lg-4">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_town_nws") != '') { ?>has-error<?php } ?>">
                                            <label for="quick_town_nws"><?php __('Ciudad'); ?>:</label>
                                            <select name="quick_town_nws[]" id="quick_town_nws" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                <?php
                                                do {
                                                  $vals = explode(',', $row_rsnews['quick_town_nws']);
                                                ?>
                                                <option value="<?php echo $row_rsZonas['id_loc3']?>"<?php if (in_array($row_rsZonas['id_loc3'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsZonas['name_'.$lang_adm.'_loc1']; ?> &raquo; <?php echo $row_rsZonas['name_'.$lang_adm.'_loc2']; ?> &raquo; <?php echo $row_rsZonas['name_'.$lang_adm.'_loc3']; ?></option>
                                                <?php
                                                } while ($row_rsZonas = mysqli_fetch_assoc($rsZonas ));
                                                $rows = mysqli_num_rows($rsZonas );
                                                if($rows > 0) {
                                                mysqli_data_seek($rsZonas , 0);
                                                $row_rsZonas = mysqli_fetch_assoc($rsZonas );
                                                }
                                                ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("news", "quick_town_nws"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_location_nws") != '') { ?>has-error<?php } ?>">
                                          <label for="quick_location_nws"><?php __('Zona'); ?>:</label>
                                                <select name="quick_location_nws[]" id="quick_location_nws" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                  <?php
                                                  do {
                                                      $vals = explode(',', $row_rsnews['quick_location_nws']);
                                                  ?>
                                                  <option value="<?php echo $row_Recordset2['id_loc4']?>" <?php if (in_array($row_Recordset2['id_loc4'], $vals)) {echo "SELECTED";} ?>><?php echo $row_Recordset2['name_'.$lang_adm.'_loc1']; ?> &raquo; <?php echo $row_Recordset2['name_'.$lang_adm.'_loc2']; ?> &raquo; <?php echo $row_Recordset2['name_'.$lang_adm.'_loc3']; ?> &raquo; <?php echo $row_Recordset2['name_'.$lang_adm.'_loc4']; ?></option>
                                                  <?php
                                                  } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                                                  $rows = mysqli_num_rows($Recordset2);
                                                  if($rows > 0) {
                                                  mysqli_data_seek($Recordset2, 0);
                                                  $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                                                  }
                                                  ?>
                                              </select>
                                              <?php echo $tNGs->displayFieldError("news", "quick_location_nws"); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_type_nws") != '') { ?>has-error<?php } ?>">
                                            <label for="quick_type_nws"><?php __('Tipo'); ?>:</label>
                                            <div>
                                                <select name="quick_type_nws[]" id="quick_type_nws" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                    <?php
                                                    do {
                                                      $vals = explode(',', $row_rsnews['quick_type_nws']);
                                                    ?>
                                                    <option value="<?php echo $row_rsTipos['id_type'] ?>" <?php if (in_array($row_rsTipos['id_type'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?></option>
                                                    <?php
                                                    } while ($row_rsTipos = mysqli_fetch_assoc($rsTipos));
                                                      $rows = mysqli_num_rows($rsTipos);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsTipos, 0);
                                                        $row_rsTipos = mysqli_fetch_assoc($rsTipos);
                                                      }
                                                    ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("news", "quick_type_nws"); ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_status_nws") != '') { ?>has-error<?php } ?>">
                                            <label for="quick_status_nws"><?php __('Operación'); ?>:</label>
                                            <div>
                                                <select name="quick_status_nws[]" id="quick_status_nws" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                    <?php
                                                    do {
                                                      $vals = explode(',', $row_rsnews['quick_status_nws']);
                                                    ?>
                                                    <option value="<?php echo $row_rsSales['id_sta']?>" <?php if (in_array($row_rsSales['id_sta'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsSales['status_'.$lang_adm.'_sta']?></option>
                                                    <?php
                                                    } while ($row_rsSales = mysqli_fetch_assoc($rsSales ));
                                                      $rows = mysqli_num_rows($rsSales );
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsSales , 0);
                                                        $row_rsSales = mysqli_fetch_assoc($rsSales );
                                                      }
                                                    ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("news", "quick_status_nws"); ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_features_nws") != '') { ?>error<?php } ?>">
                                          <label for="quick_features_nws"><?php __('Opciones'); ?>:</label>
                                          <div>
                                            <select name="quick_features_nws[]" id="quick_features_nws" multiple class="select2" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                              <?php do {
                                                $vals = explode(',', $row_rsnews['quick_features_nws']);
                                              ?>
                                              <option value="<?php echo $row_rsOpciones['id'] ?>" <?php if (in_array($row_rsOpciones['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsOpciones['name'] ?></option>
                                              <?php } while ($row_rsOpciones = mysqli_fetch_assoc($rsOpciones)); ?>
                                            </select>
                                              <?php echo $tNGs->displayFieldError("news", "quick_features_nws"); ?>
                                          </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_tags_nws") != '') { ?>error<?php } ?>">
                                         <label for="quick_tags_nws"><?php __('Etiquetas'); ?>:</label>
                                          <div>
                                           <select name="quick_tags_nws[]" id="quick_tags_nws" multiple class="select2" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                            <?php do {
                                              $vals = explode(',', $row_rsnews['quick_tags_nws']);
                                            ?>
                                            <option value="<?php echo $row_rsTags['id'] ?>" <?php if (in_array($row_rsTags['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsTags['name'] ?></option>
                                            <?php } while ($row_rsTags = mysqli_fetch_assoc($rsTags)); ?>
                                          </select>
                                            <?php echo $tNGs->displayFieldError("news", "quick_tags_nws"); ?>
                                          </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">

                                         <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_price_from_nws") != '') { ?>error<?php } ?>">
                                          <label for="quick_price_from_nws"><?php __('Precio desde'); ?>:</label>
                                          <div>
                                              <input type="text" name="quick_price_from_nws" id="quick_price_from_nws" value="<?php echo KT_escapeAttribute($row_rsnews['quick_price_from_nws']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("news", "quick_price_from_nws"); ?>
                                          </div>
                                        </div>

                                        <small class="help-block d-block position-relative mt-n4 opacity-50"><?php __('Sin puntos ni comas ni símbolos €') ?></small>

                                    </div>
                                    <div class="col-lg-4">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("news", "quick_price_up_to_nws") != '') { ?>error<?php } ?>">
                                            <label for="quick_price_up_to_nws"><?php __('Precio hasta'); ?>:</label>
                                            <div>
                                                <input type="text" name="quick_price_up_to_nws" id="quick_price_up_to_nws" value="<?php echo KT_escapeAttribute($row_rsnews['quick_price_up_to_nws']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("news", "quick_price_up_to_nws"); ?>
                                            </div>
                                          </div>

                                          <small class="help-block d-block position-relative mt-n4 opacity-50"><?php __('Sin puntos ni comas ni símbolos €') ?></small>

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
                                            <label for="title_<?php echo $value; ?>_nws" class="form-label"><?php __('Titular'); ?>:</label>
                                            <input type="text" name="title_<?php echo $value; ?>_nws" id="title_<?php echo $value; ?>_nws" value="<?php echo KT_escapeAttribute($row_rsnews['title_'.$value.'_nws']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("news", "title_".$value."_nws"); ?>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
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

    <script src="/intramedianet/landing/_js/landings-form.js?id=<?php echo time(); ?>" type="text/javascript"></script>

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
