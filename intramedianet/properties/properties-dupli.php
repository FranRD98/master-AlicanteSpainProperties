<?php

set_time_limit(0);

ini_set('display_errors', 0);
error_reporting(E_ALL);

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



// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

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



if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($inmoconn,$theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (isset($_GET['id_prop']) && $_GET['id_prop'] != '') {

	function duplicateRow( $id ){

    global $database_inmoconn, $inmoconn;
    
    $sql = "SHOW COLUMNS FROM properties_properties";
  	$qColumnNames = mysqli_query($inmoconn,$sql) or die("mysql error | " . $sql);
  	$numColumns = mysqli_num_rows($qColumnNames);

  	for ($x = 0;$x < $numColumns;$x++){
  	$colname[] = mysqli_fetch_row($qColumnNames);
  	}

    // echo "<pre>";
    // print_r($colname);
    // echo "</pre>";

    // unset($colname[37]);
    // unset($colname[38]);
    // unset($colname[39]);
    // unset($colname[40]);
    // unset($colname[41]);
    // unset($colname[43]);
    // unset($colname[44]);
    // unset($colname[45]);
    // unset($colname[46]);
    // unset($colname[47]);
    // unset($colname[48]);
    // unset($colname[49]);
    // unset($colname[50]);
    // unset($colname[51]);
    // unset($colname[52]);

  	$sql = "SELECT * FROM properties_properties WHERE id_prop = '$id'";
    $rs = mysqli_query($inmoconn,$sql) or die("mysql error | " . $sql);
  	$row = mysqli_fetch_row($rs);
  	$sql = "INSERT INTO properties_properties SET ";
  	for($i=1;$i<count($colname);$i++){//i set to 1 to preclude the id field

      if ($colname[$i][0] != '') {

        switch (trim($colname[$i][0])) {
          case 'referencia_prop':
            $sql .= "`".$colname[$i][0]."`  =  '".mysqli_real_escape_string($inmoconn, $row[$i] ) . "-D', ";
            break;
          case 'activado_prop':
            $sql .= "`".$colname[$i][0]."`  =  '0', ";
            break;
          case 'destacado_prop':
            $sql .= "`".$colname[$i][0]."`  =  '0', ";
            break;
          case 'oferta_prop':
            $sql .= "`".$colname[$i][0]."`  =  '0', ";
            break;
          case 'vendido_prop':
            $sql .= "`".$colname[$i][0]."`  =  '0', ";
            break;
          case 'alquilado_prop':
            $sql .= "`".$colname[$i][0]."`  =  '0', ";
            break;
          case 'reservado_prop':
            $sql .= "`".$colname[$i][0]."`  =  '0', ";
            break;
          case 'updated_prop':
            $sql .= "";
            break;
          case 'inserted_xml_prop':
            $sql .= "";
            break;
          case 'xml_xml_prop':
            $sql .= "";
            break;
          case 'user_prop':
            $sql .= "`".$colname[$i][0]."`  =  '" . $_SESSION['kt_login_id'] . "', ";
            break;
          default:
            if(is_null($row[$i])){
              $sql .= "`".$colname[$i][0]."`  =  NULL, \n";
            } else {
              $sql .= "`".$colname[$i][0]."`  =  '".mysqli_real_escape_string($inmoconn, $row[$i] ) . "', \n";
            }
            break;
        }

      }

  	}
    $sql .= " updated_prop = NOW(),";// we need the new record to have a new timestamp
    $sql .= " inserted_xml_prop = NOW()";// we need the new record to have a new timestamp
    mysqli_query($inmoconn,$sql) or die(mysqli_error() . " | <br><br> " . $sql);
  	$sql = "SELECT MAX(id_prop) FROM properties_properties";
  	$res = mysqli_query($inmoconn,$sql) or die(mysqli_error() . " | <br><br> " . $sql);
  	$row = mysqli_fetch_row($res);
  	return $row[0];//gives the new ID from auto incrementing
	}

}

$prop = duplicateRow( $_GET['id_prop'] );

if ($prop != '') {

  
  $query_rsRegistros = "SELECT * FROM properties_property_feature WHERE property = '".$_GET['id_prop']."'";
  $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
  $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
  $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

  if ($totalRows_rsRegistros > 0) {

    do {

      
      $query_rsInsert = "INSERT INTO `properties_property_feature`  (`property`, `feature`) VALUES ('$prop', '".$row_rsRegistros['feature']."')";
      $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

  }

}

if ($prop != '') {

  
  $query_rsRegistros = "SELECT * FROM properties_property_feature_priv WHERE property = '".$_GET['id_prop']."'";
  $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
  $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
  $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

  if ($totalRows_rsRegistros > 0) {

    do {

      
      $query_rsInsert = "INSERT INTO `properties_property_feature_priv`  (`property`, `feature`) VALUES ('$prop', '".$row_rsRegistros['feature']."')";
      $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

  }

}

if ($prop != '') {

  
  $query_rsRegistros = "SELECT * FROM properties_property_tag WHERE property = '".$_GET['id_prop']."'";
  $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
  $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
  $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

  if ($totalRows_rsRegistros > 0) {

    do {

      
      $query_rsInsert = "INSERT INTO `properties_property_tag`  (`property`, `tag`) VALUES ('$prop', '".$row_rsRegistros['tag']."')";
      $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

  }

}

if ($prop != '') {

  
  $query_rsRegistros = "SELECT * FROM properties_360 WHERE property_360 = '".$_GET['id_prop']."'";
  $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
  $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
  $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

  if ($totalRows_rsRegistros > 0) {

    do {

      
      $query_rsInsert = "INSERT INTO `properties_360`  (`id_360`, `property_360`, `video_360`, `order_360`) VALUES (NULL, '$prop', '".$row_rsRegistros['video_360']."', '".$row_rsRegistros['order_360']."')";
      $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

  }

}

if ($prop != '') {

  
  $query_rsRegistros = "SELECT * FROM properties_videos WHERE property_vid = '".$_GET['id_prop']."'";
  $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
  $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
  $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

  if ($totalRows_rsRegistros > 0) {

    do {

      
      $query_rsInsert = "INSERT INTO `properties_videos`  (`id_vid`, `property_vid`, `video_vid`, `order_vid`) VALUES (NULL, '$prop', '".$row_rsRegistros['video_vid']."', '".$row_rsRegistros['order_vid']."')";
      $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

  }

}


if ($duplicaFilesPros == 1) {
    if ($prop != '') {

      
      $query_rsRegistros = "SELECT * FROM properties_images WHERE property_img = '".$_GET['id_prop']."'";
      $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
      $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
      $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

      if ($totalRows_rsRegistros > 0) {

        do {

            set_time_limit(0);

            if (preg_match('/https?:\/\//', $row_rsRegistros['image_img'])) {
                
                $query_rsInsert = "INSERT INTO `properties_images`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, '$prop', '".$row_rsRegistros['image_img']."', '".$row_rsRegistros['order_img']."')";
                $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());
                generateThumbnails($row_rsRegistros['image_img'], mysqli_insert_id($inmoconn));
            } else {
                $ext = pathinfo($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/'.$row_rsRegistros['image_img'], PATHINFO_EXTENSION);
                $newname = uniqid('d').''. uniqid().'.'.$ext;
                copy($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/'.$row_rsRegistros['image_img'], $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/'.$newname);
                
                $query_rsInsert = "INSERT INTO `properties_images`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, '$prop', '".$newname."', '".$row_rsRegistros['order_img']."')";
                $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());
                $sizesIMGS = array('xl', 'lg', 'md', 'sm');
                foreach ($sizesIMGS as $sizesIMG) {
                    $newnameTHB = mysqli_insert_id($inmoconn).'_'. $sizesIMG.'.jpg';
                    copy($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsRegistros['id_img'].'_'.$sizesIMG.'.jpg', $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$newnameTHB);
                }
                // generateThumbnails($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/' . $newname, mysqli_insert_id($inmoconn), 'properties');
            }
            $query_rsUpdate = "UPDATE `properties_images` SET procesada_img = 1 WHERE id_img = ".mysqli_insert_id($inmoconn).";";
            $rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());

        } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

      }

    }

    if ($prop != '') {

      
      $query_rsRegistros = "SELECT * FROM properties_planos WHERE property_img = '".$_GET['id_prop']."'";
      $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
      $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
      $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

      if ($totalRows_rsRegistros > 0) {

        do {

          set_time_limit(0);

            if ($row_rsRegistros['image_img'] != '') {
                $ext = pathinfo('../../media/images/propertiesplanos/'.$row_rsRegistros['image_img'], PATHINFO_EXTENSION);
                $newname = uniqid('d').''. uniqid().'.'.$ext;
                copy('../../media/images/propertiesplanos/'.$row_rsRegistros['image_img'], '../../media/images/propertiesplanos/'.$newname);
                
                $query_rsInsert = "INSERT INTO `properties_planos`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, '$prop', '".$newname."', '".$row_rsRegistros['order_img']."')";
                $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());
                $sizesIMGS = array('xl', 'lg', 'md', 'sm');
                foreach ($sizesIMGS as $sizesIMG) {
                    $newnameTHB = mysqli_insert_id($inmoconn).'_'. $sizesIMG.'.jpg';
                    copy($_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesplanos/thumbnails/'.$row_rsRegistros['id_img'].'_'.$sizesIMG.'.jpg', $_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesplanos/thumbnails/'.$newnameTHB);
                }
                // generateThumbnails($_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesplanos/' . $newname, mysqli_insert_id($inmoconn), 'propertiesplanos');

            }

        } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

      }

    }

    if ($prop != '') {

      
      $query_rsRegistros = "SELECT * FROM properties_images_priv WHERE property_img = '".$_GET['id_prop']."'";
      $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
      $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
      $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

      if ($totalRows_rsRegistros > 0) {

        do {

          set_time_limit(0);

            if ($row_rsRegistros['image_img'] != '') {
                $ext = pathinfo('../../media/images/propertiesprv/'.$row_rsRegistros['image_img'], PATHINFO_EXTENSION);
                $newname = uniqid('d').''. uniqid().'.'.$ext;
                copy('../../media/images/propertiesprv/'.$row_rsRegistros['image_img'], '../../media/images/propertiesprv/'.$newname);
                
                $query_rsInsert = "INSERT INTO `properties_images_priv`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, '$prop', '".$newname."', '".$row_rsRegistros['order_img']."')";
                $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());
                generateThumbnails($_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesprv/' . $newname, mysqli_insert_id($inmoconn), 'propertiesprv');
            }

        } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

      }

    }


    if ($prop != '') {

      
      $query_rsRegistros = "SELECT * FROM properties_files WHERE property_fil = '".$_GET['id_prop']."'";
      $rsRegistros = mysqli_query($inmoconn,$query_rsRegistros) or die(mysqli_error());
      $row_rsRegistros = mysqli_fetch_assoc($rsRegistros);
      $totalRows_rsRegistros = mysqli_num_rows($rsRegistros);

      if ($totalRows_rsRegistros > 0) {

        do {

          set_time_limit(0);

          $ext = pathinfo('../../media/files/properties/'.$row_rsRegistros['file_fil'], PATHINFO_EXTENSION);

          $newname = uniqid('d').''. uniqid().'.'.$ext;

          $ext = strrpos($row_rsRegistros['file_fil'], '.');
          $fileName_a = substr($row_rsRegistros['file_fil'], 0, $ext);
          $fileName_b = substr($row_rsRegistros['file_fil'], $ext);

          $count = 1;
          while (file_exists('../../media/files/properties/' . $fileName_a . '_' . $count . $fileName_b))
            $count++;

          $newname = $fileName_a . '_' . $count . $fileName_b;


          copy('../../media/files/properties/'.$row_rsRegistros['file_fil'], '../../media/files/properties/'.$newname);

          
          $query_rsInsert = "INSERT INTO `properties_files`  (`id_fil`, `property_fil`, `file_fil`, `name_es_fil`, `name_en_fil`, `name_is_fil`, `name_ru_fil`) VALUES (NULL, '$prop', '".$newname."', '".$row_rsRegistros['name_es_fil']."', '".$row_rsRegistros['name_en_fil']."', '".$row_rsRegistros['name_is_fil']."', '".$row_rsRegistros['name_ru_fil']."')";
          $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

        } while ($row_rsRegistros = mysqli_fetch_assoc($rsRegistros));

      }

    }
}


header("Location: /intramedianet/properties/properties-form.php?id_prop=".$prop."&u=ok");

mysqli_free_result($rsRegistros);
?>
