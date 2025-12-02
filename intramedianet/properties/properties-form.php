<?php
// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

tNG_deleteThumbnails('../../media/images/properties/thumbnails/', '680', '');

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

if (isset($_POST['preci_reducidoo_prop']) && $_POST['preci_reducidoo_prop'] != '') {
    $_POST['preci_reducidoo_prop'] = str_replace(array('.', ','), '', $_POST['preci_reducidoo_prop']);
}
if (isset($_POST['precio_prop']) && $_POST['precio_prop'] != '') {
    $_POST['precio_prop'] = str_replace(array('.', ','), '', $_POST['precio_prop']);
}

function clientexits($email) {

    global $database_inmoconn, $inmoconn;

    
    $query_rsClients = "SELECT * FROM properties_client WHERE email_cli = '$email'";
    $rsClients = mysqli_query($inmoconn, $query_rsClients) or die(mysqli_error());
    $row_rsClients = mysqli_fetch_assoc($rsClients);
    $totalRows_rsClients = mysqli_num_rows($rsClients);

    if ($totalRows_rsClients == 0) {
        return false;
    } else {
        return $row_rsClients['id_cli'];
    }
}

// if (isset($_POST['KT_Update1']) || isset($_POST['KT_Update2'])) {
//     echo "<pre>";
//     print_r($_POST);
//     echo "</pre>";
// }

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return mb_convert_encoding($d, 'UTF-8', 'ISO-8859-1');
    }
    return $d;
}

function encryptIt($idCli, $encryptionKey = 'DLusjkq6kkzRUbY7TVc7YH2RcT2')
{
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    $encryption_iv = substr(hash('sha256', $_SERVER['HTTP_HOST']), 0, 16);
    $encryption_key = substr(hash('sha256', $encryptionKey), 0, 16);

    $encrypted = openssl_encrypt($idCli, $ciphering, $encryption_key, $options, $encryption_iv);

    // Base64 URL-safe: replace +/ with -_ and remove = padding
    return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
}

if (!isset($_GET['id_prop'])) {

  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'properties_properties'";
  $rsNextIncrement = mysqli_query($inmoconn, $query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);
  
  $query_rsMaxImgs = "SELECT MAX(property_img) as max FROM properties_images";
  $rsMaxImgs = mysqli_query($inmoconn, $query_rsMaxImgs) or die(mysqli_error());
  $row_rsMaxImgs = mysqli_fetch_assoc($rsMaxImgs);
  
  $query_rsMaxVideos = "SELECT MAX(property_vid) as max FROM properties_videos";
  $rsMaxVideos = mysqli_query($inmoconn, $query_rsMaxVideos) or die(mysqli_error());
  $row_rsMaxVideos = mysqli_fetch_assoc($rsMaxVideos);
  
  $query_rsMaxFiles = "SELECT MAX(property_fil) as max FROM properties_files";
  $rsMaxFiles = mysqli_query($inmoconn, $query_rsMaxFiles) or die(mysqli_error());
  $row_rsMaxFiles = mysqli_fetch_assoc($rsMaxFiles);

  $property_id = $row_rsNextIncrement['Auto_increment'];

  if ($property_id == $row_rsMaxImgs['max']) {
      $property_id = $row_rsNextIncrement['Auto_increment'] + 1;
  }

  if ($property_id == $row_rsMaxFiles['max']) {
      $property_id = $row_rsNextIncrement['Auto_increment'] + 1;
  }

  if (!isset($_POST['KT_Insert1']) && !isset($_POST['KT_Insert2']) && !isset($_POST['KT_Update1']) && !isset($_POST['KT_Update1'])) {
		
		$query_rsMaxProps = "
		SELECT properties_images.id_img
		FROM properties_images LEFT OUTER JOIN properties_properties ON properties_images.property_img = properties_properties.id_prop
		WHERE properties_properties.id_prop IS NULL";
		$rsMaxProps = mysqli_query($inmoconn, $query_rsMaxProps) or die(mysqli_error());
		$row_rsMaxProps = mysqli_fetch_assoc($rsMaxProps);
		$totalRows_rsMaxProps = mysqli_num_rows($rsMaxProps);

		if ($totalRows_rsMaxProps > 0) {
			do {
				mysqli_query($inmoconn, "DELETE FROM properties_images WHERE id_img  = ".$row_rsMaxProps['id_img']."") or die(mysqli_error());
			} while ($row_rsMaxProps = mysqli_fetch_assoc($rsMaxProps));
		}
	}


} else {

  $property_id = $_GET['id_prop'];

}

$property_id = $_GET['id_prop'];

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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


$query_rsTasks = "
SELECT SQL_CALC_FOUND_ROWS
  (SELECT nombre_usr FROM users WHERE id_usr  = admin_tsk) as admin_tsk,
  subject_tsk,
  date_due_tsk,
  priority_tsk,
  property_tsk,
  (SELECT categorias_".$lang_adm."_cat as cat FROM tasks_categories WHERE id_cat = status_tsk) as status_tsk,
  status_tsk as status_tsk2,
  case contact_type_tsk
      when '1' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-male\"></i> ', nombre_cnt, apellidos_cnt) FROM contactos WHERE id_cnt = contact_tsk)
      when '2' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-users\"></i> ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = contact_tsk)
      when '3' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-key\"></i> ', nombre_pro, apellidos_pro) FROM properties_owner WHERE id_pro = contact_tsk)
      when '' then ''
  end as contact_type_tsk,
  id_tsk
FROM tasks
WHERE  property_tsk = '".$property_id."'
 ORDER BY id_tsk DESC
";
$rsTasks = mysqli_query($inmoconn, $query_rsTasks) or die(mysqli_error());
$row_rsTasks = mysqli_fetch_assoc($rsTasks);
$totalRows_rsTasks = mysqli_num_rows($rsTasks);


$query_rsTipos = "SELECT types_".$lang_adm."_typ, id_typ, parent_typ FROM properties_types ORDER BY types_".$lang_adm."_typ";
$rsTipos = mysqli_query($inmoconn, $query_rsTipos) or die(mysqli_error());
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsSales = "SELECT * FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsSales = mysqli_query($inmoconn, $query_rsSales) or die(mysqli_error());
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);


$query_rsZonas = "SELECT * FROM news WHERE type_nws = 6 ORDER BY title_".$lang_adm."_nws ASC";
$rsZonas = mysqli_query($inmoconn, $query_rsZonas) or die(mysqli_error());
$row_rsZonas = mysqli_fetch_assoc($rsZonas);
$totalRows_rsZonas = mysqli_num_rows($rsZonas);


$query_rsStatus = "SELECT * FROM properties_owner_states ORDER BY category_".$lang_adm."_sts ASC";
$rsStatus = mysqli_query($inmoconn, $query_rsStatus) or die(mysqli_error());
$row_rsStatus = mysqli_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysqli_num_rows($rsStatus);


$query_rsColaboradores = "SELECT * FROM properties_collaborators ORDER BY nombre_comercial_col ASC";
$rsColaboradores = mysqli_query($inmoconn, $query_rsColaboradores) or die(mysqli_error());
$row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores);
$totalRows_rsColaboradores = mysqli_num_rows($rsColaboradores);


$query_Recordset2 = "SELECT DISTINCT properties_loc4.id_loc4, properties_loc4.parent_loc4, properties_loc1.name_".$lang_adm."_loc1, properties_loc2.name_".$lang_adm."_loc2, properties_loc3.name_".$lang_adm."_loc3, properties_loc4.name_".$lang_adm."_loc4 FROM (((properties_loc3 LEFT JOIN properties_loc2 ON properties_loc2.id_loc2=properties_loc3.loc2_loc3) LEFT JOIN properties_loc1 ON properties_loc1.id_loc1=properties_loc2.loc1_loc2) RIGHT OUTER JOIN properties_loc4 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3) ORDER BY properties_loc1.name_".$lang_adm."_loc1 ASC, properties_loc2.name_".$lang_adm."_loc2 ASC, properties_loc3.name_".$lang_adm."_loc3 ASC";
$Recordset2 = mysqli_query($inmoconn, $query_Recordset2) or die(mysqli_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);


$query_rsproperties_features = "SELECT properties_features.id_feat, properties_features.feature_".$lang_adm."_feat, properties_property_feature.property FROM properties_features LEFT JOIN properties_property_feature ON (properties_property_feature.feature=properties_features.id_feat AND properties_property_feature.property=0123456789) ORDER BY order_feat ASC";
$rsproperties_features = mysqli_query($inmoconn, $query_rsproperties_features) or die(mysqli_error());
$row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
$totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);


$query_rsproperties_features_priv = "SELECT properties_features_priv.id_feat, properties_features_priv.feature_".$lang_adm."_feat, properties_property_feature_priv.property FROM properties_features_priv LEFT JOIN properties_property_feature_priv ON (properties_property_feature_priv.feature=properties_features_priv.id_feat AND properties_property_feature_priv.property=0123456789) ORDER BY order_feat ASC";
$rsproperties_features_priv = mysqli_query($inmoconn, $query_rsproperties_features_priv) or die(mysqli_error());
$row_rsproperties_features_priv = mysqli_fetch_assoc($rsproperties_features_priv);
$totalRows_rsproperties_features_priv = mysqli_num_rows($rsproperties_features_priv);


$query_rsTags = "SELECT properties_tags.id_tag, properties_tags.tag_".$lang_adm."_tag, properties_property_tag.property FROM properties_tags LEFT JOIN properties_property_tag ON (properties_property_tag.tag=properties_tags.id_tag AND properties_property_tag.property=0123456789) ORDER BY properties_tags.tag_".$lang_adm."_tag ASC";
$rsTags = mysqli_query($inmoconn, $query_rsTags) or die(mysqli_error());
$row_rsTags = mysqli_fetch_assoc($rsTags);
$totalRows_rsTags = mysqli_num_rows($rsTags);

// if (!isset($_GET['id_prop'])) {
// 	
// 	mysqli_query($inmoconn, "DELETE FROM properties_images WHERE property_img = '".$property_id."'") or die(mysqli_error());
// }

$query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$property_id."' ORDER BY order_img";
$rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
$row_rsImages = mysqli_fetch_assoc($rsImages);
$totalRows_rsImages = mysqli_num_rows($rsImages);


$query_rsImagesPDF = "SELECT * FROM properties_images WHERE property_img = '".$property_id."' ORDER BY order_pdf_img";
$rsImagesPDF = mysqli_query($inmoconn, $query_rsImagesPDF) or die(mysqli_error());
$row_rsImagesPDF = mysqli_fetch_assoc($rsImagesPDF);
$totalRows_rsImagesPDF = mysqli_num_rows($rsImagesPDF);


$query_rsImagesp = "SELECT * FROM properties_images_priv WHERE property_img = '".$property_id."' ORDER BY order_img";
$rsImagesp = mysqli_query($inmoconn, $query_rsImagesp) or die(mysqli_error());
$row_rsImagesp = mysqli_fetch_assoc($rsImagesp);
$totalRows_rsImagesp = mysqli_num_rows($rsImagesp);


$query_rsPlanos = "SELECT * FROM properties_planos WHERE property_img = '".$property_id."' ORDER BY order_img";
$rsPlanos = mysqli_query($inmoconn, $query_rsPlanos) or die(mysqli_error());
$row_rsPlanos = mysqli_fetch_assoc($rsPlanos);
$totalRows_rsPlanos = mysqli_num_rows($rsPlanos);


$query_rsVideos = "SELECT * FROM properties_videos WHERE property_vid = '".$property_id."' ORDER BY order_vid";
$rsVideos = mysqli_query($inmoconn, $query_rsVideos) or die(mysqli_error());
$row_rsVideos = mysqli_fetch_assoc($rsVideos);
$totalRows_rsVideos = mysqli_num_rows($rsVideos);


$query_rs360 = "SELECT * FROM properties_360 WHERE property_360 = '".$property_id."' ORDER BY order_360";
$rs360 = mysqli_query($inmoconn, $query_rs360) or die(mysqli_error());
$row_rs360 = mysqli_fetch_assoc($rs360);
$totalRows_rs360 = mysqli_num_rows($rs360);


$query_rsFiles = "SELECT * FROM properties_files WHERE property_fil = '".$property_id."' ORDER BY order_fil";
$rsFiles = mysqli_query($inmoconn, $query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);


$query_rsFiles2 = "SELECT * FROM properties_datos_files WHERE property_fil = '".$property_id."' ";
$rsFiles2 = mysqli_query($inmoconn, $query_rsFiles2) or die(mysqli_error());
$row_rsFiles2 = mysqli_fetch_assoc($rsFiles2);
$totalRows_rsFiles2 = mysqli_num_rows($rsFiles2);


$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("7");

$sWhere = '';

if ($isLoggedIn1->Execute()) {
    $sWhere = ' WHERE user_pro = \''.$_SESSION['kt_login_id'].'\' ';
}


$query_rsOwner = "SELECT * FROM properties_owner $sWhere ORDER BY nombre_pro, apellidos_pro ASC";
$rsOwner = mysqli_query($inmoconn, $query_rsOwner) or die(mysqli_error());
$row_rsOwner = mysqli_fetch_assoc($rsOwner);
$totalRows_rsOwner = mysqli_num_rows($rsOwner);


$query_rsAdmin = "SELECT * FROM users WHERE id_usr = '".$_SESSION['kt_login_id']."'";
$rsAdmin = mysqli_query($inmoconn, $query_rsAdmin) or die(mysqli_error());
$row_rsAdmin = mysqli_fetch_assoc($rsAdmin);
$totalRows_rsAdmin = mysqli_num_rows($rsAdmin);


$query_rsBajadas = "SELECT * FROM properties_bajada WHERE prop_baj = '".$property_id."' ORDER BY date_baj DESC";
$rsBajadas = mysqli_query($inmoconn, $query_rsBajadas) or die(mysqli_error());
$row_rsBajadas = mysqli_fetch_assoc($rsBajadas);
$totalRows_rsBajadas = mysqli_num_rows($rsBajadas);


$query_rsRMlocs = "SELECT * FROM rightmove_locations WHERE loc4_rml != '' ORDER BY id_rml ASC";
$rsRMlocs = mysqli_query($inmoconn, $query_rsRMlocs) or die(mysqli_error());
$row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs);
$totalRows_rsRMlocs = mysqli_num_rows($rsRMlocs);


$query_rsRMtipo = "SELECT * FROM rightmove_tipos ORDER BY id_rmt ASC";
$rsRMtipo = mysqli_query($inmoconn, $query_rsRMtipo) or die(mysqli_error());
$row_rsRMtipo = mysqli_fetch_assoc($rsRMtipo);
$totalRows_rsRMtipo = mysqli_num_rows($rsRMtipo);


$query_rsArchived = "SELECT * FROM properties_archived ORDER BY types_".$lang_adm."_arc ASC";
$rsArchived = mysqli_query($inmoconn, $query_rsArchived) or die(mysqli_error());
$row_rsArchived = mysqli_fetch_assoc($rsArchived);
$totalRows_rsArchived = mysqli_num_rows($rsArchived);


$query_rsPrianTipos = "SELECT * FROM prian_types ORDER BY type_typ ASC";
$rsPrianTipos = mysqli_query($inmoconn, $query_rsPrianTipos) or die(mysqli_error());
$row_rsPrianTipos = mysqli_fetch_assoc($rsPrianTipos);
$totalRows_rsPrianTipos = mysqli_num_rows($rsPrianTipos);


$query_rsPrianPaises = "SELECT * FROM prian_paises ORDER BY nombre_ps ASC";
$rsPrianPaises = mysqli_query($inmoconn, $query_rsPrianPaises) or die(mysqli_error());
$row_rsPrianPaises = mysqli_fetch_assoc($rsPrianPaises);
$totalRows_rsPrianPaises = mysqli_num_rows($rsPrianPaises);


$query_rsPrianRegions = "SELECT * FROM prian_regions ORDER BY nombre_rgn ASC";
$rsPrianRegions = mysqli_query($inmoconn, $query_rsPrianRegions) or die(mysqli_error());
$row_rsPrianRegions = mysqli_fetch_assoc($rsPrianRegions);
$totalRows_rsPrianRegions = mysqli_num_rows($rsPrianRegions);


$query_rsPrianCities = "SELECT * FROM prian_cities ORDER BY nombre_cts ASC";
$rsPrianCities = mysqli_query($inmoconn, $query_rsPrianCities) or die(mysqli_error());
$row_rsPrianCities = mysqli_fetch_assoc($rsPrianCities);
$totalRows_rsPrianCities = mysqli_num_rows($rsPrianCities);


$query_rsUFtypes = "SELECT * FROM ubiflow_types ORDER BY id_typu ASC";
$rsUFtypes = mysqli_query($inmoconn, $query_rsUFtypes) or die(mysqli_error());
$row_rsUFtypes = mysqli_fetch_assoc($rsUFtypes);
$totalRows_rsUFtypes = mysqli_num_rows($rsUFtypes);


$query_rsPool = "SELECT pool_".$lang_adm."_pl as pool, id_pl FROM properties_pool ORDER BY pool ASC";
$rsPool = mysqli_query($inmoconn, $query_rsPool) or die(mysqli_error());
$row_rsPool = mysqli_fetch_assoc($rsPool);
$totalRows_rsPool = mysqli_num_rows($rsPool);


$query_rsParking = "SELECT parking_".$lang_adm."_prk as parking, id_prk FROM properties_parking ORDER BY parking ASC";
$rsParking = mysqli_query($inmoconn, $query_rsParking) or die(mysqli_error());
$row_rsParking = mysqli_fetch_assoc($rsParking);
$totalRows_rsParking = mysqli_num_rows($rsParking);


$query_rsKitchen = "SELECT kitchen_".$lang_adm."_kchn as kitchen, id_kchn FROM properties_kitchen ORDER BY kitchen ASC";
$rsKitchen = mysqli_query($inmoconn, $query_rsKitchen) or die(mysqli_error());
$row_rsKitchen = mysqli_fetch_assoc($rsKitchen);
$totalRows_rsKitchen = mysqli_num_rows($rsKitchen);


$query_rsCondition = "SELECT condition_".$lang_adm."_cond as estado, id_cond FROM properties_condition ORDER BY estado ASC";
$rsCondition = mysqli_query($inmoconn, $query_rsCondition) or die(mysqli_error());
$row_rsCondition = mysqli_fetch_assoc($rsCondition);
$totalRows_rsCondition = mysqli_num_rows($rsCondition);


$query_rsPlanta = "SELECT planta_".$lang_adm."_plnt as planta, id_plnt FROM properties_planta ORDER BY planta ASC";
$rsPlanta = mysqli_query($inmoconn, $query_rsPlanta) or die(mysqli_error());
$row_rsPlanta = mysqli_fetch_assoc($rsPlanta);
$totalRows_rsPlanta = mysqli_num_rows($rsPlanta);


$query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsusuarios = mysqli_query($inmoconn, $query_rsusuarios) or die(mysqli_error());
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);


$query_rsTeam = "SELECT * FROM teams ORDER BY nombre_tms";
$rsTeam = mysqli_query($inmoconn, $query_rsTeam) or die(mysqli_error());
$row_rsTeam = mysqli_fetch_assoc($rsTeam);
$totalRows_rsTeam = mysqli_num_rows($rsTeam);


$query_rsEvents = "
SELECT citas.id_ct,
  citas.categoria_ct,
  citas.user_ct,
  citas.users_ct,
  citas.property_ct,
  citas.inicio_ct,
  citas.final_ct,
  citas.titulo_ct,
  citas.lugar_ct,
  citas.notas_ct,
  citas_categories.color_ct,
  citas_categories.category_".$lang_adm."_ct as cat,
  users.nombre_usr,
  properties_client.nombre_cli,
  properties_client.apellidos_cli
FROM citas LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
   LEFT OUTER JOIN users ON citas.user_ct = users.id_usr
   LEFT OUTER JOIN properties_client ON citas.users_ct = properties_client.id_cli
WHERE FIND_IN_SET ('".$_GET['id_prop']."', property_ct)
 ORDER BY inicio_ct DESC
";
// echo $query_rsEvents;
$rsEvents = mysqli_query($inmoconn, $query_rsEvents) or die(mysqli_error());
$row_rsEvents = mysqli_fetch_assoc($rsEvents);
$totalRows_rsEvents = mysqli_num_rows($rsEvents);


if ($actPromociones == 1)
{
    
    $query_rsPromociones = " SELECT title_".$lang_adm."_nws, id_nws FROM news where type_nws = 999 ";
    $rsPromociones = mysqli_query($inmoconn, $query_rsPromociones) or die(mysqli_error());
    $row_rsPromociones = mysqli_fetch_assoc($rsPromociones);
    $totalRows_rsPromociones = mysqli_num_rows($rsPromociones);
}




function addRefs($ids) {

  global $database_inmoconn, $inmoconn;

  if ($ids == '') {
    return '';
  }

  
  $query_rsRefs = "SELECT referencia_prop, id_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
  $rsRefs = mysqli_query($inmoconn, $query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
  $row_rsRefs = mysqli_fetch_assoc($rsRefs);
  $totalRows_rsRefs = mysqli_num_rows($rsRefs);

  $ret = array();

  do {

    array_push($ret, '<a href="/intramedianet/properties/properties-form.php?id_prop='.$row_rsRefs['id_prop'].'" target="_blank" class="btn btn-default btn-xs">'.$row_rsRefs['referencia_prop'].'</a>');

  } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));


  return implode(' ', $ret);

}

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("referencia_prop", true, "text", "", "", "", "");
if( isset($_GET["id_prop"]) && $_GET["id_prop"] != "" && $_GET["id_prop"] != 0 ){
    $formValidation->addField("operacion_prop", true, "text", "", "", "", "");
    $formValidation->addField("tipo_prop", true, "text", "", "", "", "");
    $formValidation->addField("localidad_prop", true, "text", "", "", "", "");
}
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("properties_property_feature");
  $mtm->setPkName("property");
  $mtm->setFkName("feature");
  $mtm->setFkReference("mtm");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany trigger

//start Trigger_Default_ManyToMany2 trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany2($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("properties_property_feature_priv");
  $mtm->setPkName("property");
  $mtm->setFkName("feature");
  $mtm->setFkReference("mtm2");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany2 trigger

//start Trigger_Default_ManyToMany3 trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany3($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("properties_property_tag");
  $mtm->setPkName("property");
  $mtm->setFkName("tag");
  $mtm->setFkReference("mtm3");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany3 trigger

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail($tNG) {

  global $database_inmoconn, $inmoconn;

  
  $query_rsXML = "SELECT * FROM properties_images WHERE property_img = '".$tNG->getColumnValue('id_prop')."'";
  $rsXML = mysqli_query($inmoconn, $query_rsXML) or die(mysqli_error() . '<hr>' . $query_rsXML);
  $row_rsXML = mysqli_fetch_assoc($rsXML);
  $totalRows_rsXML = mysqli_num_rows($rsXML);

  do {

    if (isset($row_rsXML['image_img']) && $row_rsXML['image_img'] != '') {

      array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/" . $row_rsXML['id_img'] . "_*"));
      unlink($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/" . $row_rsXML['image_img'] . "");

      
      $query_rsDelIMG = "DELETE FROM properties_images WHERE id_img = '".$row_rsXML['id_img']."'";
      $rsDelIMG = mysqli_query($inmoconn, $query_rsDelIMG) or die(mysqli_error() . '<hr>' . $query_rsDelIMG);

    }

  } while ($row_rsXML = mysqli_fetch_assoc($rsXML));

  return true;
}
//end Trigger_DeleteDetail trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2($tNG){
    $tblDelObj = new tNG_DeleteDetailRec($tNG);
    $tblDelObj->setTable("properties_files");
    $tblDelObj->setFieldName("property_fil");
    // $tblDelObj->addFile("{file_fil}", "../../media/files/properties/");
    return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

//start Trigger_DeleteDetail4 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail4($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_datos_files");
  $tblDelObj->setFieldName("property_fil");
  // $tblDelObj->addFile("{file_fil}", "../../media/files/data/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail4 trigger

//start Trigger_DeleteDetail5 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail5($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_views");
  $tblDelObj->setFieldName("property_vws");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail5 trigger

//start Trigger_DeleteDetail3 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail3($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_videos");
  $tblDelObj->setFieldName("property_vid");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail3 trigger

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect($tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("properties-form.php?id_prop=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields($tNG) {
  $tNG->addColumn("user_prop", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("inserted_xml_prop", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  return $tNG->getError();
}
//end addFields trigger

function logprop($user, $id, $ref, $action) {

    global $database_inmoconn, $inmoconn;

    
    $query_rsProp = "INSERT INTO `properties_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '" . $user . "', '" . $id . "', '" . mysqli_real_escape_string($inmoconn, $ref) . "', '" . $action . "', '" . date("Y-m-d H:i:s") . "')";
    $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());


}

//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog($tNG) {

  global $_SESSION;

  logprop($_SESSION['kt_login_id'], $tNG->getColumnValue('id_prop'), $tNG->getColumnValue('referencia_prop'), '1');

}
//end addLog trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog($tNG) {

  global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT referencia_prop, id_prop, preci_reducidoo_prop FROM properties_properties WHERE id_prop = ".$_GET['id_prop'];
  $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);

  if ($row_rsProp['preci_reducidoo_prop'] == $_POST['preci_reducidoo_prop']) {
    $action = '2';
  }
 if ($row_rsProp['preci_reducidoo_prop'] > $_POST['preci_reducidoo_prop']) {
    $action = '3';
  }
 if ($row_rsProp['preci_reducidoo_prop'] < $_POST['preci_reducidoo_prop']) {
    $action = '4';
  }


  logprop($_SESSION['kt_login_id'], $row_rsProp['id_prop'], $row_rsProp['referencia_prop'], $action);

}
//end editLog trigger

//start deleteLog trigger
//remove this line if you want to edit the code by hand
function deleteLog($tNG) {

  global $_SESSION, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT referencia_prop, id_prop FROM properties_properties WHERE id_prop = ".$_GET['id_prop'];
  $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);

  logprop($_SESSION['kt_login_id'], $row_rsProp['id_prop'], $row_rsProp['referencia_prop'], '5');

}
//end deleteLog trigger

//start Trigger_SetOldPrice trigger
//remove this line if you want to edit the code by hand
function Trigger_SetOldPrice($tNG) {
  global $_POST, $_SESSION, $oldprice, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT preci_reducidoo_prop, id_prop FROM properties_properties WHERE id_prop = ".$tNG->getColumnValue('id_prop');
  $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);

  $_SESSION['oldprice'] = $row_rsProp['preci_reducidoo_prop'];
}
//end Trigger_SetOldPrice trigger

//start Trigger_SendMails trigger
//remove this line if you want to edit the code by hand
function Trigger_SendMails($tNG) {

    global $_POST, $_SESSION, $oldprice, $database_inmoconn, $inmoconn, $mailColor;


  
  $query_rsProp = "SELECT preci_reducidoo_prop, id_prop FROM properties_properties WHERE id_prop = ".$tNG->getColumnValue('id_prop');
  $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);

  // echo "<hr>";
  // echo $row_rsProp['preci_reducidoo_prop'];
  // echo "<hr>";
  // echo $_POST['preci_reducidoo_prop'];
  // echo "<hr><pre>";
  // print_r($_POST);
  // echo "</pre><hr>";

  if($_SESSION['oldprice'] > $_POST['preci_reducidoo_prop']) {

    
    $query_rsInt = "SELECT * FROM  `properties_bajada` WHERE prop_baj = '".$row_rsProp['id_prop']."'";
    $rsInt = mysqli_query($inmoconn, $query_rsInt) or die(mysqli_error());
    $row_rsInt = mysqli_fetch_assoc($rsInt);
    $totalRows_rsInt = mysqli_num_rows($rsInt);

    do {

    $idVal = $row_rsProp['id_prop'];

    if($idVal != '' && $row_rsInt['name_baj'] != '') {

        include( $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/properties/bajada-send.php");

      }

    } while ($row_rsInt = mysqli_fetch_assoc($rsInt));

  }

}
//end Trigger_SendMails trigger

//start addFields2 trigger
//remove this line if you want to edit the code by hand
function addFields2($tNG) {

    global $database_inmoconn, $inmoconn;
  // $tNG->addColumn("exportado_rightmove_prop", "STRING_TYPE", "EXPRESSION", "0");
  
    $query_rsProp = "UPDATE `properties_properties` SET exportado_rightmove_prop = '0', exportado_idealista_prop = '0', exportado_zoopla_prop = '0' WHERE id_prop = '".$tNG->getColumnValue('id_prop')."'";
    $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
  return $tNG->getError();
}
//end addFields2 trigger

//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache($tNG) {
    return array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
}
//end removeCache trigger

//start Trigger_Fotocasa_Fields trigger
//remove this line if you want to edit the code by hand
function Trigger_Fotocasa_Fields($tNG) {
    $tNG->setColumnValue( 'export_fotocasa_fields_prop', json_encode( $tNG->getColumnValue('export_fotocasa_fields_prop') ) );
}
//end Trigger_Fotocasa_Fields trigger

//start Trigger_Rightmove_Fields trigger
//remove this line if you want to edit the code by hand
function Trigger_Rightmove_Fields(&$tNG) {
    $tNG->setColumnValue( 'export_rightmove_fields_prop', json_encode( $tNG->getColumnValue('export_rightmove_fields_prop') ) );
}
//end Trigger_Rightmove_Fields trigger

//start Trigger_Idealista_Fields trigger
//remove this line if you want to edit the code by hand
function Trigger_Idealista_Fields($tNG) {
    $tNG->setColumnValue( 'idealista_fields_prop', json_encode( $tNG->getColumnValue('idealista_fields_prop') ) );
}
//end Trigger_Idealista_Fields trigger

//start Trigger_Yaencontre_Fields trigger
//remove this line if you want to edit the code by hand
function Trigger_Yaencontre_Fields($tNG) {
    $tNG->setColumnValue( 'export_yaencontre_fields_prop', json_encode( $tNG->getColumnValue('export_yaencontre_fields_prop') ) );
}
//end Trigger_Yaencontre_Fields trigger

//start Trigger_Fotocasa_Update trigger
//remove this line if you want to edit the code by hand
function Trigger_Fotocasa_Update($tNG) {

    global $database_inmoconn, $inmoconn, $languages, $fotocasaDatos;
    // CARGAMOS CLASE PARA LA API
    include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/FotocasaAPI.php');

    // Comprobamos si la propiedad existe ya en Fotocasa
    $method = "insert";
    $result = FotocasaAPI::getPublicationProperty($fotocasaDatos["api_key"]);
    $result = json_decode($result,1);
    foreach ( $result as $key => $prop) {
        if( $prop["ExternalId"] == $tNG->getColumnValue('id_prop') ) {
            $method = "update";
        }
    }

    // Si se ha marcado Fotocasa, insertamos/actualizamos.
    if ( $tNG->getColumnValue('export_fotocasa_prop') ==  1 &&
         $tNG->getColumnValue('activado_prop') == 1 &&
         ($tNG->getColumnValue('vendido_prop') == 0 || $tNG->getColumnValue('vendido_prop') == NULL) &&
         ($tNG->getColumnValue('reservado_prop') == 0 || $tNG->getColumnValue('reservado_prop') == NULL) &&
         ($tNG->getColumnValue('alquilado_prop') == 0 || $tNG->getColumnValue('alquilado_prop') == NULL)
    ) {
        $export_fotocasa_fields_prop = json_decode($tNG->getColumnValue('export_fotocasa_fields_prop'), true);
        $result = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/fotocasaExportProperty.php');
        if( $result["Code"] == "Error_110"){
            $method = "update";
            $export_fotocasa_fields_prop = json_decode($tNG->getColumnValue('export_fotocasa_fields_prop'), true);
            $result = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/fotocasaExportProperty.php');
        }
        if( $result ){
            $_SESSION['fc_status'] = $result;
        }
    } else if( $method == "update") { // Si se ha desmarcado, desactivado, vendido o reservado y existe, desactivamos en Fotocasa.
        $result = FotocasaAPI::deleteProperty( (int)$tNG->getColumnValue('id_prop'), $fotocasaDatos["api_key"]);
        // $result = FotocasaAPI::deletePropertyByPortal( (int)$tNG->getColumnValue('id_prop'), 1, $fotocasaDatos["api_key"]);
        $_SESSION['fc_status'] = $result;
    }

}
//end Trigger_Fotocasa_Update trigger

//start Trigger_Fotocasa_Delete trigger
//remove this line if you want to edit the code by hand
function Trigger_Fotocasa_Delete($tNG) {

    global $database_inmoconn, $inmoconn, $languages, $fotocasaDatos;
    // CARGAMOS CLASE PARA LA API
    include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/FotocasaAPI.php');

    $result = FotocasaAPI::getPublicationProperty($fotocasaDatos["api_key"]);
    $result = json_decode($result,1);
    foreach ( $result as $key => $prop) {
        if( $prop["ExternalId"] == $tNG->getColumnValue('id_prop') ) {
            $resutl = FotocasaAPI::deleteProperty( (int)$tNG->getColumnValue('id_prop'), $fotocasaDatos["api_key"]);
            // $resutl = FotocasaAPI::deletePropertyByPortal( (int)$tNG->getColumnValue('id_prop'), 1, $fotocasaDatos["api_key"]);
            $_SESSION['fc_status'] = $result;
        }
    }
}
//end Trigger_Fotocasa_Delete trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  global $lang, $database_inmoconn, $inmoconn;
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("properties_properties");
  $tblFldObj->addFieldName("referencia_prop");
  $tblFldObj->setErrorMsg("Registro duplicado: {referencia_prop}");

  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

function sendRightmove($strJSON, $strURL, $strCertFile, $strCertPass, $boolDebug = false) {
    $resCurl = curl_init();

    if($boolDebug){
        curl_setopt($resCurl, CURLOPT_VERBOSE, 1);
    }

    curl_setopt($resCurl, CURLOPT_URL, $strURL);
    curl_setopt($resCurl, CURLOPT_CERTINFO, 1);
    curl_setopt($resCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($resCurl, CURLOPT_FAILONERROR, 1);
    curl_setopt($resCurl, CURLOPT_SSLCERT, $strCertFile);
    curl_setopt($resCurl, CURLOPT_SSLCERTTYPE, 'PEM');
    curl_setopt($resCurl, CURLOPT_SSLCERTPASSWD, $strCertPass);
    curl_setopt($resCurl, CURLOPT_POST, 1);
    curl_setopt($resCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($resCurl, CURLOPT_POSTFIELDS, $strJSON);
    $strResponse = curl_exec($resCurl);

    return json_decode($strResponse);
}

//start Trigger_Rightmove_Update trigger
//remove this line if you want to edit the code by hand
function Trigger_Rightmove_Update(&$tNG) {

    global $database_inmoconn, $inmoconn, $languages, $rightmoveDatos, $rightmoveNetworkId, $rightmoveBranchId, $rightmove_ew_build_id, $rightmove_cert, $rightmove_cert_password;

    if ( $tNG->getColumnValue('export_rightmove_prop') ==  1 &&
         $tNG->getColumnValue('activado_prop') == 1 &&
         ($tNG->getColumnValue('vendido_prop') == 0 || $tNG->getColumnValue('vendido_prop') == NULL) &&
         ($tNG->getColumnValue('reservado_prop') == 0 || $tNG->getColumnValue('reservado_prop') == NULL) &&
         ($tNG->getColumnValue('alquilado_prop') == 0 || $tNG->getColumnValue('alquilado_prop') == NULL)
     ) {
        $export_rightmove_fields_prop = json_decode($tNG->getColumnValue('export_rightmove_fields_prop'), true);
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/properties-rightmove.php');
        $json = ob_get_contents();
        ob_end_clean();

        // echo $json;

        $result =  sendRightmove($json, 'https://adfapi.rightmove.co.uk/v1/property/overseassendpropertydetails', $rightmove_cert, $rightmove_cert_password, false);

        if ($result->success == 1) {
          $_SESSION['fc_statusRightmove'] = $result->message;
        } else {
          $_SESSION['fc_statusRightmove'] = $result->message;
        }
    } else {

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/properties-rightmove-get.php');
        $json = ob_get_contents();
        ob_end_clean();

        $result =  sendRightmove($json, 'https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist', $rightmove_cert, $rightmove_cert_password, false);

        $deleteProp = 0;

        foreach ($result->property as $value) {
            if ($tNG->getColumnValue('referencia_prop') == $value->agent_ref) {
                $deleteProp = 1;
            }
        }

        if ($deleteProp == 1) {

            $export_rightmove_fields_prop = json_decode($tNG->getColumnValue('export_rightmove_fields_prop'), true);

            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/properties-rightmove-remove.php');
            $json = ob_get_contents();
            ob_end_clean();

            $result =  sendRightmove($json, 'https://adfapi.rightmove.co.uk/v1/property/removeproperty', $rightmove_cert, $rightmove_cert_password, false);

            if ($result->success == 1) {
              $_SESSION['fc_statusRightmove'] = $result->message;
            } else {
              $_SESSION['fc_statusRightmove'] = $result->message;
            }
        }
    }
}
//end Trigger_Fotocasa_Update trigger

//start Trigger_Rightmove_Delete trigger
//remove this line if you want to edit the code by hand
function Trigger_Rightmove_Delete(&$tNG) {

    global $database_inmoconn, $inmoconn, $languages, $rightmoveDatos, $rightmoveNetworkId, $rightmoveBranchId, $rightmove_ew_build_id, $rightmove_cert, $rightmove_cert_password;

    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/properties-rightmove-get.php');
    $json = ob_get_contents();
    ob_end_clean();

    $result =  sendRightmove($json, 'https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist', $rightmove_cert, $rightmove_cert_password, false);

    $deleteProp = 0;

    foreach ($result->property as $value) {
        if ($tNG->getColumnValue('referencia_prop') == $value->agent_ref) {
            $deleteProp = 1;
        }
    }

    if ($deleteProp == 1) {

        $export_rightmove_fields_prop = json_decode($tNG->getColumnValue('export_rightmove_fields_prop'), true);

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/properties-rightmove-remove.php');
        $json = ob_get_contents();
        ob_end_clean();

        $result =  sendRightmove($json, 'https://adfapi.rightmove.co.uk/v1/property/removeproperty', $rightmove_cert, $rightmove_cert_password, false);

        if ($result->success == 1) {
          $_SESSION['fc_statusRightmove'] = $result->message;
        } else {
          $_SESSION['fc_statusRightmove'] = $result->message;
        }
    }

}
//end Trigger_Rightmove_Delete trigger

if (isset($_POST['habitaciones_prop']) && $_POST['habitaciones_prop'] == '') {
    $_POST['habitaciones_prop'] = 0;
}

if ( isset($_POST['aseos_prop']) && $_POST['aseos_prop'] == '') {
    $_POST['aseos_prop'] = 0;
}

if ( isset($_POST['aseos2_prop']) && $_POST['aseos2_prop'] == '') {
    $_POST['aseos2_prop'] = 0;
}

if (isset($_POST['cocinas_prop']) && $_POST['cocinas_prop'] == '') {
    $_POST['cocinas_prop'] = 0;
}

// Make an insert transaction instance
$ins_properties_properties = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_properties);
// Register triggers
$ins_properties_properties->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_properties->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_properties->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_properties->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_properties->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// $ins_properties_properties->registerTrigger("AFTER", "Trigger_Default_ManyToMany2", 50);
$ins_properties_properties->registerTrigger("AFTER", "Trigger_Default_ManyToMany3", 50);
if ($expFotoCasa == 1) {
    $ins_properties_properties->registerTrigger("BEFORE", "Trigger_Fotocasa_Fields", 10);
    $ins_properties_properties->registerTrigger("AFTER", "Trigger_Fotocasa_Update", 60);
}
if ($expIdealista == 1) {
    $ins_properties_properties->registerTrigger("BEFORE", "Trigger_Idealista_Fields", 10);
}
if ($expYaencontre == 1) {
    $ins_properties_properties->registerTrigger("BEFORE", "Trigger_Yaencontre_Fields", 10);
}
if ($expRightmove == 1) {
    $ins_properties_properties->registerTrigger("BEFORE", "Trigger_Rightmove_Fields", 7);
    $ins_properties_properties->registerTrigger("AFTER", "Trigger_Rightmove_Update", 60);
}
$ins_properties_properties->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
$ins_properties_properties->registerTrigger("BEFORE", "addFields", 10);
$ins_properties_properties->registerTrigger("AFTER", "addLog", 10);
$ins_properties_properties->registerTrigger("AFTER", "removeCache", 90);
$ins_properties_properties->registerTrigger("BEFORE", "Trigger_CheckUnique", 15);

// Add columns
$ins_properties_properties->setTable("properties_properties");
$ins_properties_properties->addColumn("referencia_prop", "STRING_TYPE", "POST", "referencia_prop");
$ins_properties_properties->addColumn("tipo_prop", "NUMERIC_TYPE", "POST", "tipo_prop");
$ins_properties_properties->addColumn("operacion_prop", "NUMERIC_TYPE", "POST", "operacion_prop");
$ins_properties_properties->addColumn("localidad_prop", "NUMERIC_TYPE", "POST", "localidad_prop");
$ins_properties_properties->addColumn("m2_prop", "NUMERIC_TYPE", "POST", "m2_prop");
$ins_properties_properties->addColumn("m2_utiles_prop", "NUMERIC_TYPE", "POST", "m2_utiles_prop");
$ins_properties_properties->addColumn("m2_parcela_prop", "NUMERIC_TYPE", "POST", "m2_parcela_prop");
$ins_properties_properties->addColumn("m2_balcon_prop", "NUMERIC_TYPE", "POST", "m2_balcon_prop");
$ins_properties_properties->addColumn("m2_terraza_prop", "NUMERIC_TYPE", "POST", "m2_terraza_prop");
$ins_properties_properties->addColumn("m2_garaje_prop", "NUMERIC_TYPE", "POST", "m2_garaje_prop");
$ins_properties_properties->addColumn("m2_sotano_prop", "NUMERIC_TYPE", "POST", "m2_sotano_prop");
$ins_properties_properties->addColumn("m2_fachada_prop", "NUMERIC_TYPE", "POST", "m2_fachada_prop");
$ins_properties_properties->addColumn("m2_solarium_prop", "NUMERIC_TYPE", "POST", "m2_solarium_prop");
$ins_properties_properties->addColumn("habitaciones_prop", "NUMERIC_TYPE", "POST", "habitaciones_prop", "0");
$ins_properties_properties->addColumn("aseos_prop", "NUMERIC_TYPE", "POST", "aseos_prop", "0");
$ins_properties_properties->addColumn("aseos2_prop", "NUMERIC_TYPE", "POST", "aseos2_prop", "0");
$ins_properties_properties->addColumn("cocinas_prop", "NUMERIC_TYPE", "POST", "cocinas_prop", "0");
$ins_properties_properties->addColumn("cocinas_prop", "NUMERIC_TYPE", "POST", "cocinas_prop", "0");
$ins_properties_properties->addColumn("cocinas_prop", "NUMERIC_TYPE", "POST", "cocinas_prop", "0");
$ins_properties_properties->addColumn("estado_prop", "NUMERIC_TYPE", "POST", "estado_prop", "0");
$ins_properties_properties->addColumn("terrazas_prop", "NUMERIC_TYPE", "POST", "terrazas_prop", "0");
$ins_properties_properties->addColumn("salones_prop", "NUMERIC_TYPE", "POST", "salones_prop", "0");
$ins_properties_properties->addColumn("precio_prop", "NUMERIC_TYPE", "POST", "precio_prop");
$ins_properties_properties->addColumn("preci_reducidoo_prop", "NUMERIC_TYPE", "POST", "preci_reducidoo_prop");
$ins_properties_properties->addColumn("units_prop", "NUMERIC_TYPE", "POST", "units_prop", "0");
$ins_properties_properties->addColumn("destacado_prop", "CHECKBOX_1_0_TYPE", "POST", "destacado_prop");
$ins_properties_properties->addColumn("oferta_prop", "CHECKBOX_1_0_TYPE", "POST", "oferta_prop");
$ins_properties_properties->addColumn("tv_prop", "CHECKBOX_1_0_TYPE", "POST", "tv_prop");
$ins_properties_properties->addColumn("activado_prop", "CHECKBOX_1_0_TYPE", "POST", "activado_prop", "1");
$ins_properties_properties->addColumn("force_hide_prop", "CHECKBOX_1_0_TYPE", "POST", "force_hide_prop", "1");
$ins_properties_properties->addColumn("vendido_prop", "CHECKBOX_1_0_TYPE", "POST", "vendido_prop");
$ins_properties_properties->addColumn("vendido_tag_prop", "CHECKBOX_1_0_TYPE", "POST", "vendido_tag_prop");
$ins_properties_properties->addColumn("alquilado_prop", "CHECKBOX_1_0_TYPE", "POST", "alquilado_prop");
$ins_properties_properties->addColumn("nuevo_prop", "DATE_TYPE", "POST", "nuevo_prop");
$ins_properties_properties->addColumn("entraga_date_prop", "DATE_TYPE", "POST", "entraga_date_prop");
$ins_properties_properties->addColumn("piscina_prop", "STRING_TYPE", "POST", "piscina_prop");
$ins_properties_properties->addColumn("parking_prop", "STRING_TYPE", "POST", "parking_prop");
$ins_properties_properties->addColumn("ascensor_prop", "CHECKBOX_1_0_TYPE", "POST", "ascensor_prop", "0");
$ins_properties_properties->addColumn("construccion_prop", "STRING_TYPE", "POST", "construccion_prop");
$ins_properties_properties->addColumn("energia_prop", "STRING_TYPE", "POST", "energia_prop");
$ins_properties_properties->addColumn("emisiones_prop", "STRING_TYPE", "POST", "emisiones_prop");
$ins_properties_properties->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$ins_properties_properties->addColumn("direccion_agen_prop", "STRING_TYPE", "POST", "direccion_agen_prop");
$ins_properties_properties->addColumn("lat_long_gp_prop", "STRING_TYPE", "POST", "lat_long_gp_prop");
$ins_properties_properties->addColumn("zoom_gp_prop", "STRING_TYPE", "POST", "zoom_gp_prop", "16");
$ins_properties_properties->addColumn("direccion_prop", "STRING_TYPE", "POST", "direccion_prop");
$ins_properties_properties->addColumn("puertas_prop", "STRING_TYPE", "POST", "puertas_prop");
$ins_properties_properties->addColumn("plantas_prop", "STRING_TYPE", "POST", "plantas_prop");
$ins_properties_properties->addColumn("viviendas_prop", "STRING_TYPE", "POST", "viviendas_prop");
$ins_properties_properties->addColumn("planta_prop", "STRING_TYPE", "POST", "planta_prop");
$ins_properties_properties->addColumn("salas_prop", "STRING_TYPE", "POST", "salas_prop");
$ins_properties_properties->addColumn("armarios_empotrados_prop", "STRING_TYPE", "POST", "armarios_empotrados_prop");
$ins_properties_properties->addColumn("plazas_garaje_prop", "STRING_TYPE", "POST", "plazas_garaje_prop");
$ins_properties_properties->addColumn("notas_prop", "STRING_TYPE", "POST", "notas_prop");
$ins_properties_properties->addColumn("precio_propie_prop", "STRING_TYPE", "POST", "precio_propie_prop");
$ins_properties_properties->addColumn("comision_prop", "STRING_TYPE", "POST", "comision_prop");
$ins_properties_properties->addColumn("comision_agent_prop", "STRING_TYPE", "POST", "comision_agent_prop");
$ins_properties_properties->addColumn("referencia_catrastal_prop", "STRING_TYPE", "POST", "referencia_catrastal_prop");
$ins_properties_properties->addColumn("precio_venta_prop", "STRING_TYPE", "POST", "precio_venta_prop");
$ins_properties_properties->addColumn("suma_prop", "STRING_TYPE", "POST", "suma_prop");
$ins_properties_properties->addColumn("export_inmoco_prop", "CHECKBOX_1_0_TYPE", "POST", "export_inmoco_prop", "0");
$ins_properties_properties->addColumn("commission_prop", "STRING_TYPE", "POST", "commission_prop");
$ins_properties_properties->addColumn("dev_commission_prop", "STRING_TYPE", "POST", "dev_commission_prop");
$ins_properties_properties->addColumn("garden_m2_prop", "NUMERIC_TYPE", "POST", "garden_m2_prop");
$ins_properties_properties->addColumn("solarium_prop", "CHECKBOX_1_0_TYPE", "POST", "solarium_prop", "0");
$ins_properties_properties->addColumn("gastos_prop", "STRING_TYPE", "POST", "gastos_prop");
$ins_properties_properties->addColumn("llaves_prop", "CHECKBOX_1_0_TYPE", "POST", "llaves_prop", "0");
$ins_properties_properties->addColumn("cartel_prop", "CHECKBOX_1_0_TYPE", "POST", "cartel_prop", "0");
$ins_properties_properties->addColumn("cita_prop", "CHECKBOX_1_0_TYPE", "POST", "cita_prop", "0");
$ins_properties_properties->addColumn("owner_prop", "NUMERIC_TYPE", "POST", "owner_prop", "0");
$ins_properties_properties->addColumn("watermark_prop", "CHECKBOX_1_0_TYPE", "POST", "watermark_prop", "0");
$ins_properties_properties->addColumn("hipoteca_prop", "CHECKBOX_1_0_TYPE", "POST", "hipoteca_prop", "0");
$ins_properties_properties->addColumn("entidad_prop", "STRING_TYPE", "POST", "entidad_prop");
$ins_properties_properties->addColumn("pendiente_prop", "STRING_TYPE", "POST", "pendiente_prop");
$ins_properties_properties->addColumn("bogado_prop", "STRING_TYPE", "POST", "bogado_prop");
$ins_properties_properties->addColumn("abogado_telefono_prop", "STRING_TYPE", "POST", "abogado_telefono_prop");
$ins_properties_properties->addColumn("alcayata_prop", "STRING_TYPE", "POST", "alcayata_prop");
$ins_properties_properties->addColumn("llave_txt_prop", "STRING_TYPE", "POST", "llave_txt_prop");
$ins_properties_properties->addColumn("keyholder_prop", "CHECKBOX_1_0_TYPE", "POST", "keyholder_prop", "0");
$ins_properties_properties->addColumn("keyholder_name_prop", "STRING_TYPE", "POST", "keyholder_name_prop");
$ins_properties_properties->addColumn("keyholder_tel_prop", "STRING_TYPE", "POST", "keyholder_tel_prop");
$ins_properties_properties->addColumn("alarm_prop", "CHECKBOX_1_0_TYPE", "POST", "alarm_prop", "0");
$ins_properties_properties->addColumn("alarm_code_prop", "STRING_TYPE", "POST", "alarm_code_prop");
$ins_properties_properties->addColumn("distance_beach_prop", "STRING_TYPE", "POST", "distance_beach_prop");
$ins_properties_properties->addColumn("distance_beach_med_prop", "STRING_TYPE", "POST", "distance_beach_med_prop");
$ins_properties_properties->addColumn("distance_airport_prop", "STRING_TYPE", "POST", "distance_airport_prop");
$ins_properties_properties->addColumn("distance_airport_med_prop", "STRING_TYPE", "POST", "distance_airport_med_prop");
$ins_properties_properties->addColumn("distance_amenities_prop", "STRING_TYPE", "POST", "distance_amenities_prop");
$ins_properties_properties->addColumn("distance_amenities_med_prop", "STRING_TYPE", "POST", "distance_amenities_med_prop");
$ins_properties_properties->addColumn("cp_prop", "STRING_TYPE", "POST", "cp_prop", "0");
$ins_properties_properties->addColumn("direccion_gpp_prop", "STRING_TYPE", "POST", "direccion_gpp_prop");
$ins_properties_properties->addColumn("lat_long_gpp_prop", "STRING_TYPE", "POST", "lat_long_gpp_prop");
$ins_properties_properties->addColumn("zoom_gpp_prop", "STRING_TYPE", "POST", "zoom_gpp_prop", "16");
$ins_properties_properties->addColumn("dropbox_prop", "STRING_TYPE", "POST", "dropbox_prop");
// $ins_properties_properties->addColumn("num_com_mail_prop", "STRING_TYPE", "POST", "num_com_mail_prop");
$ins_properties_properties->addColumn("distance_golf_prop", "STRING_TYPE", "POST", "distance_golf_prop");
$ins_properties_properties->addColumn("distance_golf_med_prop", "STRING_TYPE", "POST", "distance_golf_med_prop");
$ins_properties_properties->addColumn("orientacion_prop", "STRING_TYPE", "POST", "orientacion_prop");
$ins_properties_properties->addColumn("rightmove_loc_prop", "NUMERIC_TYPE", "POST", "rightmove_loc_prop");
$ins_properties_properties->addColumn("rightmove_tipo_prop", "NUMERIC_TYPE", "POST", "rightmove_tipo_prop");
$ins_properties_properties->addColumn("zonas_prop", "NUMERIC_TYPE", "POST", "zonas_prop");
$ins_properties_properties->addColumn("vista360_prop", "STRING_TYPE", "POST", "vista360_prop");
$ins_properties_properties->addColumn("viewing_arrange_prop", "CHECKBOX_1_0_TYPE", "POST", "viewing_arrange_prop", "0");
$ins_properties_properties->addColumn("applicant_interested_no_meeting_prop", "CHECKBOX_1_0_TYPE", "POST", "applicant_interested_no_meeting_prop", "0");
$ins_properties_properties->addColumn("sale_in_progress_prop", "CHECKBOX_1_0_TYPE", "POST", "sale_in_progress_prop", "0");
$ins_properties_properties->addColumn("precio_desde_prop", "CHECKBOX_1_0_TYPE", "POST", "precio_desde_prop", "0");
if ($actChatGPT == 1) {
$ins_properties_properties->addColumn("chatgpt_prompt_prop", "STRING_TYPE", "POST", "chatgpt_prompt_prop");
}
if ($showTeam == 1) {
$ins_properties_properties->addColumn("atendido_por_prop", "NUMERIC_TYPE", "POST", "atendido_por_prop");
}
$ins_properties_properties->addColumn("captado_prop", "NUMERIC_TYPE", "POST", "captado_prop");
if($actArchivadoEn == 1) {
$ins_properties_properties->addColumn("archived_prop", "NUMERIC_TYPE", "POST", "archived_prop");
}
if ($actRemoteWeb1 == 1) {
$ins_properties_properties->addColumn("show_web1_prop", "CHECKBOX_1_0_TYPE", "POST", "show_web1_prop", "0");
}
if ($actRemoteWeb2 == 1) {
$ins_properties_properties->addColumn("show_web2_prop", "CHECKBOX_1_0_TYPE", "POST", "show_web2_prop", "0");
}
if ($expKyero == 1) {
$ins_properties_properties->addColumn("export_kyero_prop", "CHECKBOX_1_0_TYPE", "POST", "export_kyero_prop", "0");
}
if ($expMimove == 1) {
$ins_properties_properties->addColumn("export_mimove_prop", "CHECKBOX_1_0_TYPE", "POST", "export_mimove_prop", "0");
$ins_properties_properties->addColumn("export_mimove_type_prop", "STRING_TYPE", "POST", "export_mimove_type_prop");
$ins_properties_properties->addColumn("export_mimove_parking_prop", "STRING_TYPE", "POST", "export_mimove_parking_prop");
}
if ($expRightmove == 1) {
$ins_properties_properties->addColumn("export_rightmove_prop", "CHECKBOX_1_0_TYPE", "POST", "export_rightmove_prop", "0");
$ins_properties_properties->addColumn("export_rightmove_fields_prop", "STRING_TYPE", "POST", "export_rightmove_fields_prop");
}
if ($expFotoCasa == 1) {
$ins_properties_properties->addColumn("export_fotocasa_prop", "CHECKBOX_1_0_TYPE", "POST", "export_fotocasa_prop", "0");
$ins_properties_properties->addColumn("export_fotocasa_fields_prop", "STRING_TYPE", "POST", "export_fotocasa_fields_prop");
}
if ($expZoopla == 1) {
$ins_properties_properties->addColumn("export_zoopla_prop", "CHECKBOX_1_0_TYPE", "POST", "export_zoopla_prop", "0");
}
if ($expThinkSpain == 1) {
$ins_properties_properties->addColumn("export_thinkspain_prop", "CHECKBOX_1_0_TYPE", "POST", "export_thinkspain_prop", "0");
}
if ($expHemnet == 1) {
$ins_properties_properties->addColumn("export_hemnet_prop", "CHECKBOX_1_0_TYPE", "POST", "export_hemnet_prop", "0");
}
if ($expUbiflow == 1) {
$ins_properties_properties->addColumn("export_ubiflow_prop", "CHECKBOX_1_0_TYPE", "POST", "export_ubiflow_prop", "0");
$ins_properties_properties->addColumn("ubiflow_type_prop", "STRING_TYPE", "POST", "ubiflow_type_prop");
}
if ($expGreenAcres == 1) {
$ins_properties_properties->addColumn("export_green_prop", "CHECKBOX_1_0_TYPE", "POST", "export_green_prop", "0");
}
if ($expAPITS == 1) {
$ins_properties_properties->addColumn("expport_APITS_prop", "CHECKBOX_1_0_TYPE", "POST", "expport_APITS_prop", "0");
}
if ($expCostadelHome == 1) {
$ins_properties_properties->addColumn("expport_CostadelHome_prop", "CHECKBOX_1_0_TYPE", "POST", "expport_CostadelHome_prop", "0");
}
if ($expSpainHouses == 1) {
$ins_properties_properties->addColumn("expport_SpainHomes_prop", "CHECKBOX_1_0_TYPE", "POST", "expport_SpainHomes_prop", "0");
}
if ($expPrian == 1) {
$ins_properties_properties->addColumn("export_prian_prop", "CHECKBOX_1_0_TYPE", "POST", "export_prian_prop", "0");
$ins_properties_properties->addColumn("prian_tipo_prop", "NUMERIC_TYPE", "POST", "prian_tipo_prop");
$ins_properties_properties->addColumn("prian_pais_prop", "NUMERIC_TYPE", "POST", "prian_pais_prop");
$ins_properties_properties->addColumn("prian_region_prop", "NUMERIC_TYPE", "POST", "prian_region_prop");
$ins_properties_properties->addColumn("prian_ciudad_prop", "NUMERIC_TYPE", "POST", "prian_ciudad_prop");
}
if ($expHabitaclia == 1) {
$ins_properties_properties->addColumn("export_habitaclia_prop", "CHECKBOX_1_0_TYPE", "POST", "export_habitaclia_prop", "0");
}
if ($expMediaelx == 1) {
$ins_properties_properties->addColumn("export_mediaelx_prop", "CHECKBOX_1_0_TYPE", "POST", "export_mediaelx_prop", "0");
}
if ($expFacebook == 1) {
$ins_properties_properties->addColumn("export_facebook_prop", "CHECKBOX_1_0_TYPE", "POST", "export_facebook_prop", "0");
}
if ($expMLSMediaelx == 1) {
$ins_properties_properties->addColumn("export_mlsmediaelx_prop", "CHECKBOX_1_0_TYPE", "POST", "export_mlsmediaelx_prop", "0");
}
if ($expTodoPisoAlicante == 1) {
$ins_properties_properties->addColumn("export_todopisoalicante_prop", "CHECKBOX_1_0_TYPE", "POST", "export_todopisoalicante_prop", "0");
}
if ($expPisos == 1) {
$ins_properties_properties->addColumn("export_pisos_prop", "CHECKBOX_1_0_TYPE", "POST", "export_pisos_prop", "0");
}
if ($expFacilisimo == 1) {
$ins_properties_properties->addColumn("export_facilisimo_prop", "CHECKBOX_1_0_TYPE", "POST", "export_facilisimo_prop", "0");
}
if ($expIdealista == 1) {
$ins_properties_properties->addColumn("idealista_prop", "CHECKBOX_1_0_TYPE", "POST", "idealista_prop", "0");
$ins_properties_properties->addColumn("idealista_fields_prop", "STRING_TYPE", "POST", "idealista_fields_prop");
}
if ($expYaencontre == 1) {
$ins_properties_properties->addColumn("export_yaencontre_prop", "CHECKBOX_1_0_TYPE", "POST", "export_yaencontre_prop", "0");
$ins_properties_properties->addColumn("export_yaencontre_fields_prop", "STRING_TYPE", "POST", "export_yaencontre_fields_prop");
}
// $ins_properties_properties->addColumn("show_direccion_prop", "CHECKBOX_1_0_TYPE", "POST", "show_direccion_prop", "0");
$ins_properties_properties->addColumn("show_house_prop", "CHECKBOX_1_0_TYPE", "POST", "show_house_prop", "0");
$ins_properties_properties->addColumn("iva_prop", "CHECKBOX_1_0_TYPE", "POST", "iva_prop", "0");
$ins_properties_properties->addColumn("iva_porc_prop", "NUMERIC_TYPE", "POST", "iva_porc_prop", "10");
foreach($languages as $value) {
$ins_properties_properties->addColumn("titulo_".$value."_prop", "STRING_TYPE", "POST", "titulo_".$value."_prop");
$ins_properties_properties->addColumn("descripcion_".$value."_prop", "STRING_TYPE", "POST", "descripcion_".$value."_prop");
$ins_properties_properties->addColumn("descripcion_xml_".$value."_prop", "STRING_TYPE", "POST", "descripcion_xml_".$value."_prop");
$ins_properties_properties->addColumn("title_".$value."_prop", "STRING_TYPE", "POST", "title_".$value."_prop");
$ins_properties_properties->addColumn("description_".$value."_prop", "STRING_TYPE", "POST", "description_".$value."_prop");
$ins_properties_properties->addColumn("keywords_".$value."_prop", "STRING_TYPE", "POST", "keywords_".$value."_prop");
}
for ($i=1; $i <= 12; $i++) {
  $ins_properties_properties->addColumn("precio_".$i."_prop", "STRING_TYPE", "POST", "precio_".$i."_prop");
}

if ($actPromociones == 1)
{
    $ins_properties_properties->addColumn("promocion_prop", "NUMERIC_TYPE", "POST", "promocion_prop");
}

$ins_properties_properties->setPrimaryKey("id_prop", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_properties = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_properties);

// Register triggers
$upd_properties_properties->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_properties->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_properties_properties->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_properties->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../intramedianet/properties/properties.php?KT_back=1");
$upd_properties_properties->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// $upd_properties_properties->registerTrigger("AFTER", "Trigger_Default_ManyToMany2", 50);
$upd_properties_properties->registerTrigger("AFTER", "Trigger_Default_ManyToMany3", 50);
$upd_properties_properties->registerTrigger("AFTER", "addFields2", 1);
if ($expFotoCasa == 1) {
$upd_properties_properties->registerTrigger("BEFORE", "Trigger_Fotocasa_Fields", 10);
$upd_properties_properties->registerTrigger("AFTER", "Trigger_Fotocasa_Update", 60);
}
if ($expIdealista == 1) {
    $upd_properties_properties->registerTrigger("BEFORE", "Trigger_Idealista_Fields", 10);
}
if ($expYaencontre == 1) {
    $upd_properties_properties->registerTrigger("BEFORE", "Trigger_Yaencontre_Fields", 10);
}
if ($expRightmove == 1) {
$upd_properties_properties->registerTrigger("BEFORE", "Trigger_Rightmove_Fields", 10);
$upd_properties_properties->registerTrigger("AFTER", "Trigger_Rightmove_Update", 60);
}
$upd_properties_properties->registerConditionalTrigger("{POST.KT_Update2} != \"\"", "AFTER", "Trigger_Redirect", 90);
$upd_properties_properties->registerTrigger("BEFORE", "Trigger_SetOldPrice", 50);
$upd_properties_properties->registerTrigger("AFTER", "Trigger_SendMails", 60);
$upd_properties_properties->registerTrigger("BEFORE", "editLog", 10);
$upd_properties_properties->registerTrigger("AFTER", "removeCache", 90);
$upd_properties_properties->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$upd_properties_properties->setTable("properties_properties");
$upd_properties_properties->addColumn("referencia_prop", "STRING_TYPE", "POST", "referencia_prop");
$upd_properties_properties->addColumn("tipo_prop", "NUMERIC_TYPE", "POST", "tipo_prop");
$upd_properties_properties->addColumn("operacion_prop", "NUMERIC_TYPE", "POST", "operacion_prop");
$upd_properties_properties->addColumn("localidad_prop", "NUMERIC_TYPE", "POST", "localidad_prop");
$upd_properties_properties->addColumn("m2_prop", "NUMERIC_TYPE", "POST", "m2_prop");
$upd_properties_properties->addColumn("m2_utiles_prop", "NUMERIC_TYPE", "POST", "m2_utiles_prop");
$upd_properties_properties->addColumn("m2_parcela_prop", "NUMERIC_TYPE", "POST", "m2_parcela_prop");
$upd_properties_properties->addColumn("m2_balcon_prop", "NUMERIC_TYPE", "POST", "m2_balcon_prop");
$upd_properties_properties->addColumn("m2_terraza_prop", "NUMERIC_TYPE", "POST", "m2_terraza_prop");
$upd_properties_properties->addColumn("m2_garaje_prop", "NUMERIC_TYPE", "POST", "m2_garaje_prop");
$upd_properties_properties->addColumn("m2_sotano_prop", "NUMERIC_TYPE", "POST", "m2_sotano_prop");
$upd_properties_properties->addColumn("m2_fachada_prop", "NUMERIC_TYPE", "POST", "m2_fachada_prop");
$upd_properties_properties->addColumn("m2_solarium_prop", "NUMERIC_TYPE", "POST", "m2_solarium_prop");
$upd_properties_properties->addColumn("habitaciones_prop", "NUMERIC_TYPE", "POST", "habitaciones_prop");
$upd_properties_properties->addColumn("aseos_prop", "NUMERIC_TYPE", "POST", "aseos_prop");
$upd_properties_properties->addColumn("aseos2_prop", "NUMERIC_TYPE", "POST", "aseos2_prop");
$upd_properties_properties->addColumn("cocinas_prop", "NUMERIC_TYPE", "POST", "cocinas_prop");
$upd_properties_properties->addColumn("estado_prop", "NUMERIC_TYPE", "POST", "estado_prop");
$upd_properties_properties->addColumn("terrazas_prop", "NUMERIC_TYPE", "POST", "terrazas_prop");
$upd_properties_properties->addColumn("salones_prop", "NUMERIC_TYPE", "POST", "salones_prop");
$upd_properties_properties->addColumn("precio_prop", "NUMERIC_TYPE", "POST", "precio_prop");
$upd_properties_properties->addColumn("preci_reducidoo_prop", "NUMERIC_TYPE", "POST", "preci_reducidoo_prop");
$upd_properties_properties->addColumn("units_prop", "NUMERIC_TYPE", "POST", "units_prop");
$upd_properties_properties->addColumn("destacado_prop", "CHECKBOX_1_0_TYPE", "POST", "destacado_prop");
$upd_properties_properties->addColumn("oferta_prop", "CHECKBOX_1_0_TYPE", "POST", "oferta_prop");
$upd_properties_properties->addColumn("tv_prop", "CHECKBOX_1_0_TYPE", "POST", "tv_prop");
$upd_properties_properties->addColumn("activado_prop", "CHECKBOX_1_0_TYPE", "POST", "activado_prop");
$upd_properties_properties->addColumn("force_hide_prop", "CHECKBOX_1_0_TYPE", "POST", "force_hide_prop");
$upd_properties_properties->addColumn("vendido_prop", "CHECKBOX_1_0_TYPE", "POST", "vendido_prop");
$upd_properties_properties->addColumn("vendido_tag_prop", "CHECKBOX_1_0_TYPE", "POST", "vendido_tag_prop");
$upd_properties_properties->addColumn("alquilado_prop", "CHECKBOX_1_0_TYPE", "POST", "alquilado_prop");
$upd_properties_properties->addColumn("reservado_prop", "CHECKBOX_1_0_TYPE", "POST", "reservado_prop");
$upd_properties_properties->addColumn("nuevo_prop", "DATE_TYPE", "POST", "nuevo_prop");
$upd_properties_properties->addColumn("entraga_date_prop", "STRING_TYPE", "POST", "entraga_date_prop");
$upd_properties_properties->addColumn("piscina_prop", "STRING_TYPE", "POST", "piscina_prop");
$upd_properties_properties->addColumn("parking_prop", "STRING_TYPE", "POST", "parking_prop");
$upd_properties_properties->addColumn("ascensor_prop", "CHECKBOX_1_0_TYPE", "POST", "ascensor_prop");
$upd_properties_properties->addColumn("construccion_prop", "STRING_TYPE", "POST", "construccion_prop");
$upd_properties_properties->addColumn("energia_prop", "STRING_TYPE", "POST", "energia_prop");
$upd_properties_properties->addColumn("emisiones_prop", "STRING_TYPE", "POST", "emisiones_prop");
$upd_properties_properties->addColumn("direccion_gp_prop", "STRING_TYPE", "POST", "direccion_gp_prop");
$upd_properties_properties->addColumn("direccion_agen_prop", "STRING_TYPE", "POST", "direccion_agen_prop");
$upd_properties_properties->addColumn("lat_long_gp_prop", "STRING_TYPE", "POST", "lat_long_gp_prop");
$upd_properties_properties->addColumn("zoom_gp_prop", "STRING_TYPE", "POST", "zoom_gp_prop");
$upd_properties_properties->addColumn("direccion_prop", "STRING_TYPE", "POST", "direccion_prop");
$upd_properties_properties->addColumn("puertas_prop", "STRING_TYPE", "POST", "puertas_prop");
$upd_properties_properties->addColumn("plantas_prop", "STRING_TYPE", "POST", "plantas_prop");
$upd_properties_properties->addColumn("viviendas_prop", "STRING_TYPE", "POST", "viviendas_prop");
$upd_properties_properties->addColumn("planta_prop", "STRING_TYPE", "POST", "planta_prop");
$upd_properties_properties->addColumn("salas_prop", "STRING_TYPE", "POST", "salas_prop");
$upd_properties_properties->addColumn("armarios_empotrados_prop", "STRING_TYPE", "POST", "armarios_empotrados_prop");
$upd_properties_properties->addColumn("plazas_garaje_prop", "STRING_TYPE", "POST", "plazas_garaje_prop");
$upd_properties_properties->addColumn("notas_prop", "STRING_TYPE", "POST", "notas_prop");
$upd_properties_properties->addColumn("precio_propie_prop", "STRING_TYPE", "POST", "precio_propie_prop");
$upd_properties_properties->addColumn("comision_prop", "STRING_TYPE", "POST", "comision_prop");
$upd_properties_properties->addColumn("comision_agent_prop", "STRING_TYPE", "POST", "comision_agent_prop");
$upd_properties_properties->addColumn("referencia_catrastal_prop", "STRING_TYPE", "POST", "referencia_catrastal_prop");
$upd_properties_properties->addColumn("precio_venta_prop", "STRING_TYPE", "POST", "precio_venta_prop");
$upd_properties_properties->addColumn("suma_prop", "STRING_TYPE", "POST", "suma_prop");
$upd_properties_properties->addColumn("export_inmoco_prop", "CHECKBOX_1_0_TYPE", "POST", "export_inmoco_prop");
$upd_properties_properties->addColumn("commission_prop", "STRING_TYPE", "POST", "commission_prop");
$upd_properties_properties->addColumn("dev_commission_prop", "STRING_TYPE", "POST", "dev_commission_prop");
$upd_properties_properties->addColumn("garden_m2_prop", "NUMERIC_TYPE", "POST", "garden_m2_prop");
$upd_properties_properties->addColumn("solarium_prop", "CHECKBOX_1_0_TYPE", "POST", "solarium_prop");
$upd_properties_properties->addColumn("gastos_prop", "STRING_TYPE", "POST", "gastos_prop");
$upd_properties_properties->addColumn("llaves_prop", "CHECKBOX_1_0_TYPE", "POST", "llaves_prop");
$upd_properties_properties->addColumn("cartel_prop", "CHECKBOX_1_0_TYPE", "POST", "cartel_prop");
$upd_properties_properties->addColumn("cita_prop", "CHECKBOX_1_0_TYPE", "POST", "cita_prop");
$upd_properties_properties->addColumn("owner_prop", "NUMERIC_TYPE", "POST", "owner_prop");
$upd_properties_properties->addColumn("watermark_prop", "CHECKBOX_1_0_TYPE", "POST", "watermark_prop");
$upd_properties_properties->addColumn("hipoteca_prop", "CHECKBOX_1_0_TYPE", "POST", "hipoteca_prop");
$upd_properties_properties->addColumn("entidad_prop", "STRING_TYPE", "POST", "entidad_prop");
$upd_properties_properties->addColumn("pendiente_prop", "STRING_TYPE", "POST", "pendiente_prop");
$upd_properties_properties->addColumn("bogado_prop", "STRING_TYPE", "POST", "bogado_prop");
$upd_properties_properties->addColumn("abogado_telefono_prop", "STRING_TYPE", "POST", "abogado_telefono_prop");
$upd_properties_properties->addColumn("alcayata_prop", "STRING_TYPE", "POST", "alcayata_prop");
$upd_properties_properties->addColumn("llave_txt_prop", "STRING_TYPE", "POST", "llave_txt_prop");
$upd_properties_properties->addColumn("keyholder_prop", "CHECKBOX_1_0_TYPE", "POST", "keyholder_prop");
$upd_properties_properties->addColumn("keyholder_name_prop", "STRING_TYPE", "POST", "keyholder_name_prop");
$upd_properties_properties->addColumn("keyholder_tel_prop", "STRING_TYPE", "POST", "keyholder_tel_prop");
$upd_properties_properties->addColumn("alarm_prop", "CHECKBOX_1_0_TYPE", "POST", "alarm_prop", "0");
$upd_properties_properties->addColumn("alarm_code_prop", "STRING_TYPE", "POST", "alarm_code_prop");
$upd_properties_properties->addColumn("distance_beach_prop", "STRING_TYPE", "POST", "distance_beach_prop");
$upd_properties_properties->addColumn("distance_airport_prop", "STRING_TYPE", "POST", "distance_airport_prop");
$upd_properties_properties->addColumn("distance_amenities_prop", "STRING_TYPE", "POST", "distance_amenities_prop");
$upd_properties_properties->addColumn("distance_beach_med_prop", "STRING_TYPE", "POST", "distance_beach_med_prop");
$upd_properties_properties->addColumn("distance_airport_med_prop", "STRING_TYPE", "POST", "distance_airport_med_prop");
$upd_properties_properties->addColumn("distance_amenities_med_prop", "STRING_TYPE", "POST", "distance_amenities_med_prop");
$upd_properties_properties->addColumn("direccion_gpp_prop", "STRING_TYPE", "POST", "direccion_gpp_prop");
$upd_properties_properties->addColumn("lat_long_gpp_prop", "STRING_TYPE", "POST", "lat_long_gpp_prop");
$upd_properties_properties->addColumn("zoom_gpp_prop", "STRING_TYPE", "POST", "zoom_gpp_prop");
$upd_properties_properties->addColumn("dropbox_prop", "STRING_TYPE", "POST", "dropbox_prop");
$upd_properties_properties->addColumn("cp_prop", "STRING_TYPE", "POST", "cp_prop");
// $upd_properties_properties->addColumn("num_com_mail_prop", "STRING_TYPE", "POST", "num_com_mail_prop");
$upd_properties_properties->addColumn("distance_golf_prop", "STRING_TYPE", "POST", "distance_golf_prop");
$upd_properties_properties->addColumn("distance_golf_med_prop", "STRING_TYPE", "POST", "distance_golf_med_prop");
$upd_properties_properties->addColumn("orientacion_prop", "STRING_TYPE", "POST", "orientacion_prop");
$upd_properties_properties->addColumn("rightmove_loc_prop", "NUMERIC_TYPE", "POST", "rightmove_loc_prop");
$upd_properties_properties->addColumn("rightmove_tipo_prop", "NUMERIC_TYPE", "POST", "rightmove_tipo_prop");
$upd_properties_properties->addColumn("zonas_prop", "NUMERIC_TYPE", "POST", "zonas_prop");
$upd_properties_properties->addColumn("vista360_prop", "STRING_TYPE", "POST", "vista360_prop");
$upd_properties_properties->addColumn("viewing_arrange_prop", "CHECKBOX_1_0_TYPE", "POST", "viewing_arrange_prop");
$upd_properties_properties->addColumn("applicant_interested_no_meeting_prop", "CHECKBOX_1_0_TYPE", "POST", "applicant_interested_no_meeting_prop");
$upd_properties_properties->addColumn("sale_in_progress_prop", "CHECKBOX_1_0_TYPE", "POST", "sale_in_progress_prop");
$upd_properties_properties->addColumn("precio_desde_prop", "CHECKBOX_1_0_TYPE", "POST", "precio_desde_prop");
if ($actChatGPT == 1) {
$upd_properties_properties->addColumn("chatgpt_prompt_prop", "STRING_TYPE", "POST", "chatgpt_prompt_prop");
}
if ($showTeam == 1) {
$upd_properties_properties->addColumn("atendido_por_prop", "NUMERIC_TYPE", "POST", "atendido_por_prop");
}
$upd_properties_properties->addColumn("captado_prop", "NUMERIC_TYPE", "POST", "captado_prop");
if($actArchivadoEn == 1) {
$upd_properties_properties->addColumn("archived_prop", "NUMERIC_TYPE", "POST", "archived_prop");
}
if ($actRemoteWeb1 == 1) {
$upd_properties_properties->addColumn("show_web1_prop", "CHECKBOX_1_0_TYPE", "POST", "show_web1_prop");
}
if ($actRemoteWeb2 == 1) {
$upd_properties_properties->addColumn("show_web2_prop", "CHECKBOX_1_0_TYPE", "POST", "show_web2_prop");
}
if ($expKyero == 1) {
$upd_properties_properties->addColumn("export_kyero_prop", "CHECKBOX_1_0_TYPE", "POST", "export_kyero_prop");
}
if ($expMimove == 1) {
$upd_properties_properties->addColumn("export_mimove_prop", "CHECKBOX_1_0_TYPE", "POST", "export_mimove_prop");
$upd_properties_properties->addColumn("export_mimove_type_prop", "STRING_TYPE", "POST", "export_mimove_type_prop");
$upd_properties_properties->addColumn("export_mimove_parking_prop", "STRING_TYPE", "POST", "export_mimove_parking_prop");
}
if ($expRightmove == 1) {
$upd_properties_properties->addColumn("export_rightmove_prop", "CHECKBOX_1_0_TYPE", "POST", "export_rightmove_prop");
$upd_properties_properties->addColumn("export_rightmove_fields_prop", "STRING_TYPE", "POST", "export_rightmove_fields_prop");
}
if ($expFotoCasa == 1) {
$upd_properties_properties->addColumn("export_fotocasa_prop", "CHECKBOX_1_0_TYPE", "POST", "export_fotocasa_prop");
$upd_properties_properties->addColumn("export_fotocasa_fields_prop", "STRING_TYPE", "POST", "export_fotocasa_fields_prop");
}
if ($expZoopla == 1) {
$upd_properties_properties->addColumn("export_zoopla_prop", "CHECKBOX_1_0_TYPE", "POST", "export_zoopla_prop");
}
if ($expThinkSpain == 1) {
$upd_properties_properties->addColumn("export_thinkspain_prop", "CHECKBOX_1_0_TYPE", "POST", "export_thinkspain_prop");
}
if ($expHemnet == 1) {
$upd_properties_properties->addColumn("export_hemnet_prop", "CHECKBOX_1_0_TYPE", "POST", "export_hemnet_prop");
}
if ($expUbiflow == 1) {
$upd_properties_properties->addColumn("export_ubiflow_prop", "CHECKBOX_1_0_TYPE", "POST", "export_ubiflow_prop");
$upd_properties_properties->addColumn("ubiflow_type_prop", "STRING_TYPE", "POST", "ubiflow_type_prop");
}
if ($expGreenAcres == 1) {
$upd_properties_properties->addColumn("export_green_prop", "CHECKBOX_1_0_TYPE", "POST", "export_green_prop");
}
if ($expAPITS == 1) {
$upd_properties_properties->addColumn("expport_APITS_prop", "CHECKBOX_1_0_TYPE", "POST", "expport_APITS_prop");
}
if ($expCostadelHome == 1) {
$upd_properties_properties->addColumn("expport_CostadelHome_prop", "CHECKBOX_1_0_TYPE", "POST", "expport_CostadelHome_prop");
}
if ($expSpainHouses == 1) {
$upd_properties_properties->addColumn("expport_SpainHomes_prop", "CHECKBOX_1_0_TYPE", "POST", "expport_SpainHomes_prop");
}
if ($expPrian == 1) {
$upd_properties_properties->addColumn("export_prian_prop", "CHECKBOX_1_0_TYPE", "POST", "export_prian_prop");
$upd_properties_properties->addColumn("prian_tipo_prop", "NUMERIC_TYPE", "POST", "prian_tipo_prop");
$upd_properties_properties->addColumn("prian_pais_prop", "NUMERIC_TYPE", "POST", "prian_pais_prop");
$upd_properties_properties->addColumn("prian_region_prop", "NUMERIC_TYPE", "POST", "prian_region_prop");
$upd_properties_properties->addColumn("prian_ciudad_prop", "NUMERIC_TYPE", "POST", "prian_ciudad_prop");
}
if ($expHabitaclia == 1) {
$upd_properties_properties->addColumn("export_habitaclia_prop", "CHECKBOX_1_0_TYPE", "POST", "export_habitaclia_prop");
}
if ($expMediaelx == 1) {
$upd_properties_properties->addColumn("export_mediaelx_prop", "CHECKBOX_1_0_TYPE", "POST", "export_mediaelx_prop");
}
if ($expFacebook == 1) {
$upd_properties_properties->addColumn("export_facebook_prop", "CHECKBOX_1_0_TYPE", "POST", "export_facebook_prop");
}
if ($expMLSMediaelx == 1) {
$upd_properties_properties->addColumn("export_mlsmediaelx_prop", "CHECKBOX_1_0_TYPE", "POST", "export_mlsmediaelx_prop");
}
if ($expTodoPisoAlicante == 1) {
$upd_properties_properties->addColumn("export_todopisoalicante_prop", "CHECKBOX_1_0_TYPE", "POST", "export_todopisoalicante_prop");
}
if ($expPisos == 1) {
$upd_properties_properties->addColumn("export_pisos_prop", "CHECKBOX_1_0_TYPE", "POST", "export_pisos_prop");
}
if ($expFacilisimo == 1) {
$upd_properties_properties->addColumn("export_facilisimo_prop", "CHECKBOX_1_0_TYPE", "POST", "export_facilisimo_prop");
}
if ($expIdealista == 1) {
$upd_properties_properties->addColumn("idealista_prop", "CHECKBOX_1_0_TYPE", "POST", "idealista_prop");
$upd_properties_properties->addColumn("idealista_fields_prop", "STRING_TYPE", "POST", "idealista_fields_prop");
}
if ($expYaencontre == 1) {
$upd_properties_properties->addColumn("export_yaencontre_prop", "CHECKBOX_1_0_TYPE", "POST", "export_yaencontre_prop");
$upd_properties_properties->addColumn("export_yaencontre_fields_prop", "STRING_TYPE", "POST", "export_yaencontre_fields_prop");
}
// $upd_properties_properties->addColumn("show_direccion_prop", "CHECKBOX_1_0_TYPE", "POST", "show_direccion_prop");
$upd_properties_properties->addColumn("show_house_prop", "CHECKBOX_1_0_TYPE", "POST", "show_house_prop");
$upd_properties_properties->addColumn("iva_prop", "CHECKBOX_1_0_TYPE", "POST", "iva_prop");
$upd_properties_properties->addColumn("iva_porc_prop", "NUMERIC_TYPE", "POST", "iva_porc_prop");
foreach($languages as $value) {
$upd_properties_properties->addColumn("titulo_".$value."_prop", "STRING_TYPE", "POST", "titulo_".$value."_prop");
$upd_properties_properties->addColumn("descripcion_".$value."_prop", "STRING_TYPE", "POST", "descripcion_".$value."_prop");
$upd_properties_properties->addColumn("descripcion_xml_".$value."_prop", "STRING_TYPE", "POST", "descripcion_xml_".$value."_prop");
$upd_properties_properties->addColumn("title_".$value."_prop", "STRING_TYPE", "POST", "title_".$value."_prop");
$upd_properties_properties->addColumn("description_".$value."_prop", "STRING_TYPE", "POST", "description_".$value."_prop");
$upd_properties_properties->addColumn("keywords_".$value."_prop", "STRING_TYPE", "POST", "keywords_".$value."_prop");
}
for ($i=1; $i <= 12; $i++) {
  $upd_properties_properties->addColumn("precio_".$i."_prop", "STRING_TYPE", "POST", "precio_".$i."_prop");
}

if ($actPromociones == 1)
{
    $upd_properties_properties->addColumn("promocion_prop", "NUMERIC_TYPE", "POST", "promocion_prop");
}

$upd_properties_properties->setPrimaryKey("id_prop", "NUMERIC_TYPE", "GET", "id_prop");

// Make an instance of the transaction object
$del_properties_properties = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_properties);
// Register triggers
$del_properties_properties->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_properties->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_properties->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../intramedianet/properties/properties.php?KT_back=1");
$del_properties_properties->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
$del_properties_properties->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
$del_properties_properties->registerTrigger("BEFORE", "Trigger_DeleteDetail3", 99);
$del_properties_properties->registerTrigger("BEFORE", "Trigger_DeleteDetail4", 99);
$del_properties_properties->registerTrigger("BEFORE", "Trigger_DeleteDetail5", 99);
$del_properties_properties->registerTrigger("BEFORE", "deleteLog", 99);
$del_properties_properties->registerTrigger("AFTER", "removeCache", 10);
if ($expFotoCasa == 1) {
    $del_properties_properties->registerTrigger("BEFORE", "Trigger_Fotocasa_Delete", 10);
}
if ($expRightmove == 1) {
    $del_properties_properties->registerTrigger("AFTER", "Trigger_Rightmove_Delete", 10);
}
// Add columns
$del_properties_properties->setTable("properties_properties");
$del_properties_properties->setPrimaryKey("id_prop", "NUMERIC_TYPE", "GET", "id_prop");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset

$rsproperties_properties = $tNGs->getRecordset("properties_properties");
$row_rsproperties_properties = mysqli_fetch_assoc($rsproperties_properties);
$totalRows_rsproperties_properties = mysqli_num_rows($rsproperties_properties);

$query_rsHistorial = "
SELECT
users.nombre_usr,
properties_log.referencia_log,
properties_log.action_log,
properties_log.date_log,
properties_log.id_log
FROM properties_log LEFT OUTER JOIN users ON properties_log.user_log = users.id_usr
WHERE referencia_log = '".$row_rsproperties_properties['referencia_prop']."'
ORDER BY date_log DESC
";
$rsHistorial = mysqli_query($inmoconn, $query_rsHistorial) or die(mysqli_error());
$row_rsHistorial = mysqli_fetch_assoc($rsHistorial);
$totalRows_rsHistorial = mysqli_num_rows($rsHistorial);
// (SELECT CONCAT_WS(nombre_cli, ' ', apellidos_cli, ' <br><small>', email_log, '</small>') FROM properties_client WHERE email_cli = email_log) as



$query_rsVisitas = "
SELECT
    id_cli,
    nombre_cli,
    apellidos_cli
FROM properties_client
WHERE FIND_IN_SET('".$row_rsproperties_properties['referencia_prop']."', visited_cli)
";
$rsVisitas = mysqli_query($inmoconn, $query_rsVisitas) or die(mysqli_error() . '<hr>' . $query_rsVisitas);
$row_rsVisitas = mysqli_fetch_assoc($rsVisitas);
$totalRows_rsVisitas = mysqli_num_rows($rsVisitas);


$query_rsEmails = "
SELECT
properties_log_mails.id_log,
(SELECT CONCAT_WS('', nombre_cli, ' ', apellidos_cli, ' <br><small>', email_cli, '</small>') FROM properties_client WHERE email_cli = email_log LIMIT 1) as email_log,
properties_log_mails.type_log,
properties_log_mails.result_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log LIMIT 1) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
WHERE prop_id_log = '".$row_rsproperties_properties['id_prop']."'
ORDER BY date_log DESC
";
$rsEmails = mysqli_query($inmoconn, $query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);


$query_rsInfoProp = "
SELECT
  site_xml,
  tipo_xml,
  properties_properties.ref_xml_prop,
  properties_properties.inserted_xml_prop,
  properties_properties.updated_prop,
  dev_ref_prop,
  restr_man_contr_prop,
  restr_web_prop,
  restr_nat_port_prop,
  restr_int_port_prop,
  restr_social_prop,
restr_int_cli_prop
FROM properties_properties
LEFT JOIN xml ON properties_properties.xml_xml_prop = id_xml
WHERE properties_properties.id_prop = '" . $_GET['id_prop'] . "'
";
$rsInfoProp = mysqli_query($inmoconn, $query_rsInfoProp) or die(mysqli_error());
$row_rsInfoProp = mysqli_fetch_assoc($rsInfoProp);
$totalRows_rsInfoProp = mysqli_num_rows($rsInfoProp);
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $protocol = 'https://';
}
else {
    $protocol = 'http://';
}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>
<?php include("../includes/inc.head.php"); ?>

<style>
    .ref_prop {
        float: right;
    }
</style>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

      <input type="hidden" name="kt_pk_properties_properties" class="id_field" value="<?php if(isset($row_rsproperties_properties['kt_pk_properties_properties'])) echo KT_escapeAttribute($row_rsproperties_properties['kt_pk_properties_properties']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <!-- <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-building"></i> <?php echo __('Inmuebles'); ?></h4> -->

                        <div class="flex-md-grow-1 d-md-block pe-2" id="tabs-header-fix">

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills card-header-pills" role="tablist" id="proptabs">
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary active" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabprop" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Ficha'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabcrm" role="tab" aria-selected="true">
                                        <?php __('Privado'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabcruce" role="tab" aria-selected="true">
                                        <?php __('Cruce'); ?>
                                    </a>
                                </li>
                                <?php if($_SESSION['kt_login_level'] == 9) { ?>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabportales" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Propiedades exportadas'); ?>
                                    </a>
                                </li>
                                <?php } ?>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabrental" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Alquileres'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabinfo" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Informes'); ?>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        <div class="flex-grow-1 prop-nav-sep d-none d-md-flex text-white"><i class="fa-regular fa-pipe mx-5"></i></div>

                        <div class="flex-md-shrink-0 d-md-block">
                            <?php if (@$_GET['id_prop'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="mt-2 mt-md-0 btn btn-success btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-md-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?></span></button>
                                <button type="submit" name="KT_Insert2" id="KT_Insert2" class="mt-2 mt-md-0 btn btn-primary btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-md-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?> <?php echo $lang['y Seguir Editando'] ?></span></button>
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-md-1"></i><span class="d-none d-lg-inline-block"> <?php __("Guardar"); ?></span></button>
                                <button type="submit" name="KT_Update2" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-primary btn-sm"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-md-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                                <a href="<?php echo $protocol . '' . $_SERVER['HTTP_HOST'] . '' . propURL($_GET['id_prop'], $lang_adm); ?>" target="_blank" class="mt-2 mt-md-0 btn btn-info btn-sm btn-icon btn-preview" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php __('Previsualizar'); ?> - <?php __('Recuerde guardar el inmueble para ver los ultimos datos'); ?>"><i class="fa-regular fa-eye"></i> <span class="d-none d-lg-inline-block-"><?php echo $lang['Previsualizar'] ?></span></a>
                                <a href="/intramedianet/properties/properties-dupli.php?id_prop=<?php echo $_GET['id_prop']; ?>" class="mt-2 mt-md-0 btn btn-warning btn-sm btn-icon btn-dupli" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php __('Duplicar'); ?>"><i class="fa-regular fa-clone"></i> <span class="d-none d-lg-inline-block-"><?php __('Duplicar'); ?></span></a>
                                <?php if($_SESSION['kt_login_level'] == 9) { ?>
                                <button type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 mt-2 mt-md-0 btn btn-danger btn-sm btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php echo NXT_getResource("Delete_FB"); ?>"><i class="fa-regular fa-trash-can fa-fw"></i><span class="d-none d-lg-inline-block-"><?php echo NXT_getResource("Delete_FB"); ?></span></button>
                                <?php } ?>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="mt-2 mt-md-0 btn btn-soft-primary btn-sm"><i class="fa-regular fa-chevron-left fa-fw me-md-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>
                            <?php /* ?>
                            <?php if (@$_GET['id_prop'] != "") { ?>
                            <div class="dropdown d-inline-block">
                                <button class="mt-2 mt-md-0 btn btn-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-ellipsis align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="/reporte/<?php echo encryptIt($property_id) ?>/" class="dropdown-item edit-item-btn" target="_blank"><i class="fa-regular fa-pencil align-bottom me-1"></i> <?php __('Reporte propietario'); ?></a></li>
                                    <li><a href="#" class="dropdown-item edit-item-btn print-data"><i class="fa-regular fa-print me-1"></i> <?php __('Imprimir'); ?> <?php __('Propietario'); ?> <?php __('y'); ?> <?php __('Datos privados'); ?></a></li>
                                </ul>
                            </div>
                            <?php } ?>
                            <?php */ ?>
                        </div>
                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <!-- ALERTAS HABIHUB -->
                <?php if ($row_rsInfoProp['restr_man_contr_prop'] == 1 || $row_rsInfoProp['restr_web_prop'] == 1 || $row_rsInfoProp['restr_nat_port_prop'] == 1 || $row_rsInfoProp['restr_int_port_prop'] == 1 || $row_rsInfoProp['restr_social_prop'] == 1 || $row_rsInfoProp['restr_int_cli_prop'] == 1) { ?>
                    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-exclamation label-icon"></i>
                        <?php if ($row_rsInfoProp['restr_web_prop'] == 1): ?>
                            <p class="my-1"><b><?php __('Este inmueble no se permite mostara en la web'); ?></b></p>
                        <?php endif ?>
                        <?php if ($row_rsInfoProp['restr_nat_port_prop'] == 1): ?>
                            <p class="my-1"><b><?php __('Este inmueble no se permite mostara en portales nacionales'); ?></b></p>
                        <?php endif ?>
                        <?php if ($row_rsInfoProp['restr_int_port_prop'] == 1): ?>
                            <p class="my-1"><b><?php __('Este inmueble no se permite mostara en portales internacionales'); ?></b></p>
                        <?php endif ?>
                        <?php if ($row_rsInfoProp['restr_man_contr_prop'] == 1): ?>
                            <p class="my-1"><b><?php __('mandatory_contract'); ?></b></p>
                        <?php endif ?>
                        <?php if ($row_rsInfoProp['restr_social_prop'] == 1): ?>
                            <p class="my-1"><b><?php __('social_networks'); ?></b></p>
                        <?php endif ?>
                        <?php if ($row_rsInfoProp['restr_int_cli_prop'] == 1): ?>
                            <p class="my-1"><b><?php __('only_intl_clients'); ?></b></p>
                        <?php endif ?>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                    </div>
                    <?php unset($_SESSION['fc_statusRightmove']); ?>
                <?php } ?>

                <!-- RESPUESTA FOTOCASA -->
                <?php if (isset($_SESSION['fc_status']) && $_SESSION['fc_status'] != '') { ?>
                    <div class="alert alert-<?php if($_SESSION['fc_status']["StatusCode"] >= 300){echo "danger";}else{ echo "success";} ?> alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-<?php if($_SESSION['fc_status']["StatusCode"] >= 300){echo "exclamation";}else{ echo "check";} ?> label-icon"></i> Fotocasa: <?php echo __($_SESSION['fc_status']["Message"],1) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['fc_status']); ?>
                <?php } ?>

                <!-- RESPUESTA RIGHTMOVE -->
                <?php if ($_SESSION['fc_statusRightmove'] != '') { ?>
                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-check label-icon"></i> Rightmove: <?php echo __($_SESSION['fc_statusRightmove']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['fc_statusRightmove']); ?>
                <?php } ?>

                <?php if (isset($_GET['u']) && $_GET['u'] == 'ok') { ?>
                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-check label-icon"></i> <?php echo $lang['El inmueble se ha guardado correctamente'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <!-- Tab panes -->
                <div class="tab-content  text-muted">
                    <div class="tab-pane active" id="tabprop" role="tabpanel">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1 d-block"><?php __('Propiedad'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?>
                                      <?php if ($row_rsInfoProp['dev_ref_prop'] != ''): ?>
                                      <spam class="float-end"><?php __('REDSP development ref') ?>: <?php echo $row_rsInfoProp['dev_ref_prop']; ?></spam>
                                      <?php endif ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="card-body">

                              <?php if (@$_GET['id_prop'] != "") { ?>

                              <div class="alert bg-light py-2" role="alert">

                                  <div class="row">

                                      <div class="col-md-5">
                                          <span class="lead fs-6"><i class="fa-regular fa-calendar-clock me-1"></i> <b><?php __('Insertado'); ?>:</b>
                                          <?php echo date("d-m-Y", strtotime($row_rsInfoProp['inserted_xml_prop'])); ?></span>
                                          <i class="fa-regular fa-pipe mx-2"></i>
                                          <span class="lead fs-6"><i class="fa-regular fa-calendar-clock me-1"></i> <b><?php __('Última actualización'); ?>:</b>
                                          <?php echo date("d-m-Y", strtotime($row_rsInfoProp['updated_prop'])); ?></span>
                                      </div>

                                      <div class="col-md-7 text-md-end">
                                          <?php if ($row_rsInfoProp['site_xml'] != '') { ?>
                                          <span class="lead fs-6"><i class="fa-regular fa-file-import me-1"></i> <?php __('Importado desde'); ?> <b><?php echo $row_rsInfoProp['site_xml']; ?></b> <?php __('con referencia'); ?> <b><?php echo $row_rsInfoProp['ref_xml_prop']; ?></b></span>
                                          <?php } ?>
                                      </div>

                                  </div>

                              </div>

                              <?php } ?>

                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                          <input type="checkbox" name="activado_prop" id="activado_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['activado_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="activado_prop"><?php __('Activar la propiedad'); ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "activado_prop"); ?>
                                      </div>
                                  </div>
                                  <!--/.col-md-4 -->
                                  <div class="col-md-4">
                                      <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                          <input type="checkbox" name="vendido_prop" id="vendido_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['vendido_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="vendido_prop"><?php __('Vendido'); ?> (<?php __('Ocultar en listados y exportadores'); ?>)</label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "vendido_prop"); ?>
                                      </div>
                                  </div>
                                  <!--/.col-md-4 -->
                                  <div class="col-md-4">
                                      <div class="form-check form-switch form-switch-md pt-2 text-danger" dir="ltr">
                                          <input type="checkbox" name="force_hide_prop" id="force_hide_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['force_hide_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="force_hide_prop"><?php __('Ocultar (importada de XML)'); ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "force_hide_prop"); ?>
                                      </div>
                                  </div>
                                  <!--/.col-md-4 -->
                                  <div class="col-md-4">
                                      <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                          <input type="checkbox" name="destacado_prop" id="destacado_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['destacado_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="destacado_prop"><?php __('Destacar la propiedad'); ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "destacado_prop"); ?>
                                      </div>
                                  </div>
                                  <!--/.col-md-4 -->
                                  <?php if ($showprecioReduc == 1) { ?>
                                  <div class="col-md-4">
                                      <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                          <input type="checkbox" name="oferta_prop" id="oferta_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['oferta_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="oferta_prop"><?php __('Oferta'); ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "oferta_prop"); ?>
                                      </div>
                                  </div>
                                  <!--/.col-md-4 -->
                                  <?php } ?>
                                  <?php if ($actTV == 1): ?>
                                  <div class="col-md-4">
                                      <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                          <input type="checkbox" name="tv_prop" id="tv_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['tv_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="tv_prop"><?php __('TV'); ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "tv_prop"); ?>
                                      </div>
                                  </div>
                                  <!--/.col-md-4 -->
                                  <?php endif ?>
                                  <div class="col-md-4">
                                      <?php if ($actRemoteWeb1 == 1) { ?>
                                      <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                          <input type="checkbox" name="show_web1_prop" id="show_web1_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['show_web1_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="show_web1_prop"><?php __('Mostrar en la web'); ?>: <?php echo $remoteWebName1 ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "show_web1_prop"); ?>
                                      </div>
                                      <?php } ?>
                                  </div> <!--/.col-md-4 -->
                                  <div class="col-md-4">
                                      <?php if ($actRemoteWeb2 == 1) { ?>
                                      <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                          <input type="checkbox" name="show_web2_prop" id="show_web2_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['show_web2_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="show_web2_prop"><?php __('Mostrar en la web'); ?>: <?php echo $remoteWebName2 ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "show_web2_prop"); ?>
                                      </div>
                                      <?php } ?>
                                  </div> <!--/.col-md-4 -->
                              </div>

                              <hr>

                              <div class="row">

                                  <div class="col-lg-3">

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "referencia_prop") != '') { ?>has-error<?php } ?>">
                                        <label for="referencia_prop" class="form-label"><?php __('Referencia'); ?>:</label>
                                        <input type="text" name="referencia_prop" id="referencia_prop" value="<?php if (@$_GET['id_prop'] == "" && $row_rsproperties_properties['referencia_prop'] == '') { ?><?php echo $row_rsAdmin ['prefix_ref_usr'] ?><?php } ?><?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?>" size="32" maxlength="255" class="form-control required" required>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "referencia_prop"); ?>
                                    </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_properties", "precio_prop" ) !='' ) { ?>has-error
                                          <?php } ?>">
                                          <label for="precio_prop" class="form-label"><?php __('Precio anterior'); ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="precio_prop" id="precio_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['precio_prop']); ?>" size="32" maxlength="255" class="form-control">
                                              <span class="input-group-text">€</span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "precio_prop"); ?>
                                      </div>
                                      <small class="mt-n3 text-muted d-block mb-4"><?php __('Sin puntos ni comas 1.000 = 1000 | 0 = Consultar') ?></small>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_properties", "preci_reducidoo_prop" ) !='' ) { ?>has-error
                                          <?php } ?>">
                                          <label for="preci_reducidoo_prop" class="form-label"><?php __('Precio'); ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="preci_reducidoo_prop" id="preci_reducidoo_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['preci_reducidoo_prop']); ?>" size="32" maxlength="255" class="form-control required" required>
                                              <span class="input-group-text">€</span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "preci_reducidoo_prop"); ?>
                                      </div>
                                      <small class="mt-n3 text-muted d-block mb-4"><?php __('Sin puntos ni comas 1.000 = 1000 | 0 = Consultar') ?></small>

                                  </div>

                                  <div class="col-lg-1">

                                      <div class="form-check form-switch form-switch-sm mt-md-4 mb-4 mb-md-0" dir="ltr">
                                          <input type="checkbox" name="precio_desde_prop" id="precio_desde_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['precio_desde_prop']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="precio_desde_prop" style="line-height: 1em;"><?php echo str_replace(': ', ':<br>', __('Mostrar desde', true)); ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "precio_desde_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-2">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "units_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="units_prop" class="form-label"><?php __('Unidades'); ?>:</label>
                                          <div class="input-step full-width">
                                              <button type="button" class="minus">–</button>
                                              <input type="number" name="units_prop" id="units_prop" value="<?php if (KT_escapeAttribute($row_rsproperties_properties['units_prop']) == ''): ?>0<?php else: ?><?php echo KT_escapeAttribute($row_rsproperties_properties['units_prop']); ?><?php endif ?>" min="0" max="1000" readonly="" class="required" required>
                                              <button type="button" class="plus">+</button>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "units_prop"); ?>
                                      </div>

                                  </div>

                              </div>

                              <div class="row">

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "operacion_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="operacion_prop" class="form-label"><?php __('operación'); ?>:</label>
                                          <select name="operacion_prop" id="operacion_prop" class="required select2" required>
                                              <!-- <option value="" <?php if (isset($row_rsproperties_properties['operacion_prop']) && !(strcmp("", $row_rsproperties_properties['operacion_prop']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option> -->
                                              <?php
                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsSales['id_sta']?>"<?php if (isset($row_rsproperties_properties['operacion_prop']) && !(strcmp($row_rsSales['id_sta'], $row_rsproperties_properties['operacion_prop']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsSales['status_'.$lang_adm.'_sta']?></option>
                                              <?php
                                              } while ($row_rsSales = mysqli_fetch_assoc($rsSales));
                                                $rows = mysqli_num_rows($rsSales);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsSales , 0);
                                                  $row_rsSales = mysqli_fetch_assoc($rsSales);
                                                }
                                              ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "operacion_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "tipo_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="tipo_prop" class="form-label"><?php __('Tipo'); ?>:</label>
                                          <select name="tipo_prop" id="tipo_prop" class="required select2" required>
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php
                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsTipos['id_typ']?>"<?php if (isset($row_rsproperties_properties['tipo_prop']) && !(strcmp($row_rsTipos['id_typ'], $row_rsproperties_properties['tipo_prop']))) {echo "SELECTED";} ?> <?php if ($row_rsTipos['parent_typ'] != '') {echo "data-colortext=\"#cccccc\"";} ?>><?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?></option>
                                              <?php
                                              } while ($row_rsTipos = mysqli_fetch_assoc($rsTipos));
                                                $rows = mysqli_num_rows($rsTipos);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsTipos, 0);
                                                  $row_rsTipos = mysqli_fetch_assoc($rsTipos);
                                                }
                                              ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "tipo_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "habitaciones_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="habitaciones_prop" class="form-label required"><?php __('Habitaciones'); ?>:</label>
                                          <div class="input-step full-width">
                                              <button type="button" class="minus">–</button>
                                              <input type="number" name="habitaciones_prop" id="habitaciones_prop" value="<?php if (KT_escapeAttribute($row_rsproperties_properties['habitaciones_prop']) == ''): ?>0<?php else: ?><?php echo KT_escapeAttribute($row_rsproperties_properties['habitaciones_prop']); ?><?php endif ?>" min="0" max="1000" readonly="" class="required" required>
                                              <button type="button" class="plus">+</button>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "habitaciones_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "aseos_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="aseos_prop" class="form-label required"><?php __('Aseos'); ?>:</label>
                                          <div class="input-step full-width">
                                              <button type="button" class="minus">–</button>
                                              <input type="number" name="aseos_prop" id="aseos_prop" value="<?php if (KT_escapeAttribute($row_rsproperties_properties['aseos_prop']) == ''): ?>0<?php else: ?><?php echo KT_escapeAttribute($row_rsproperties_properties['aseos_prop']); ?><?php endif ?>" min="0" max="1000" readonly="" class="required" required>
                                              <button type="button" class="plus">+</button>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "aseos_prop"); ?>
                                      </div>

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "aseos2_prop") != '') { ?>has-error<?php } ?> d-none">
                                          <label for="aseos2_prop" class="form-label required"><?php __('Aseos2'); ?>:</label>
                                          <div class="input-step full-width">
                                              <button type="button" class="minus">–</button>
                                              <input type="number" name="aseos2_prop" id="aseos2_prop" value="<?php if (KT_escapeAttribute($row_rsproperties_properties['aseos2_prop']) == ''): ?>0<?php else: ?><?php echo KT_escapeAttribute($row_rsproperties_properties['aseos2_prop']); ?><?php endif ?>" min="0" max="1000" readonly="" class="required" required>
                                              <button type="button" class="plus">+</button>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "aseos2_prop"); ?>
                                      </div>

                                  </div>

                              </div>

                              <div class="row">

                                  <div class="<?php if ($actPromociones == 1):?> col-lg-3 <?php else:?> col-lg-6 <?php endif?>">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "localidad_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="localidad_prop" class="form-label"><?php __('Localización'); ?>:</label>
                                          <select name="localidad_prop" id="localidad_prop" class="required select2" required>
                                              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php do { ?>
                                              <option value="<?php echo $row_Recordset2['id_loc4']?>" <?php if (isset($row_rsproperties_properties['localidad_prop']) && !(strcmp($row_Recordset2['id_loc4'], $row_rsproperties_properties['localidad_prop']))) {echo "SELECTED";} ?> <?php if ($row_Recordset2['parent_loc4'] != null && $row_Recordset2['parent_loc4'] != '') {echo "data-colortext=\"#cccccc\"";} ?>><?php echo $row_Recordset2['name_'.$lang_adm.'_loc1']; ?> &raquo; <?php echo $row_Recordset2['name_'.$lang_adm.'_loc2']; ?> &raquo; <?php echo $row_Recordset2['name_'.$lang_adm.'_loc3']; ?> &raquo; <?php echo $row_Recordset2['name_'.$lang_adm.'_loc4']; ?></option>
                                              <?php
                                              } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                                              $rows = mysqli_num_rows($Recordset2);
                                              if($rows > 0) {
                                                  mysqli_data_seek($Recordset2, 0);
                                                  $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                                              }
                                              ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "localidad_prop"); ?>
                                      </div>

                                  </div>

                                  <?php if ($actPromociones == 1): ?>
                                    <div class="col-lg-3">
                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "promocion_prop") != '') { ?>has-error<?php } ?>">
                                             <label class="form-label" for="promocion_prop"><?php __('Proyecto'); ?>:</label>
                                             <select name="promocion_prop" id="promocion_prop" class="select2">
                                                   <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                   <?php
                                                   do {
                                                   ?>
                                                   <option value="<?php echo $row_rsPromociones['id_nws']?>" <?php if (isset($row_rsproperties_properties['promocion_prop']) && !(strcmp($row_rsPromociones ['id_nws'], $row_rsproperties_properties['promocion_prop']))) {echo "SELECTED";} ?>>
                                                    <?php echo $row_rsPromociones['title_'.$lang_adm.'_nws']?>
                                                    </option>
                                                   <?php
                                                 } while ($row_rsPromociones = mysqli_fetch_assoc($rsPromociones));
                                                   ?>


                                               </select>
                                         </div>
                                    </div>
                                  <?php endif ?>



                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "m2_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="m2_prop" class="form-label"><?php __('m2 construidos'); ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="m2_prop" id="m2_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['m2_prop']); ?>" size="32" maxlength="255" class="form-control">
                                              <span class="input-group-text">m<sup>2</sup></span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "m2_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "m2_utiles_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="m2_utiles_prop" class="form-label"><?php __('m2 útiles'); ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="m2_utiles_prop" id="m2_utiles_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['m2_utiles_prop']); ?>" size="32" maxlength="255" class="form-control">
                                              <span class="input-group-text">m<sup>2</sup></span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "m2_utiles_prop"); ?>
                                      </div>
                                  </div>

                              </div>

                              <div class="row">

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "energia_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="energia_prop" class="form-label"><?php __('Calificación energética'); ?>:</label>
                                          <select name="energia_prop" id="energia_prop" class="required select2">
                                              <option value=""<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>><?php __('En proceso'); ?></option>
                                              <option value="A"<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('A', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>>A</option>
                                              <option value="B"<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('B', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>>B</option>
                                              <option value="C"<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('C', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>>C</option>
                                              <option value="D"<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('D', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>>D</option>
                                              <option value="E"<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('E', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>>E</option>
                                              <option value="F"<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('F', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>>F</option>
                                              <option value="G"<?php if (isset($row_rsproperties_properties['energia_prop']) && !(strcmp('G', $row_rsproperties_properties['energia_prop']))) {echo "SELECTED";} ?>>G</option>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "energia_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "emisiones_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="emisiones_prop" class="form-label"><?php __('Emisiones'); ?>:</label>
                                          <select name="emisiones_prop" id="emisiones_prop" class="required select2">
                                              <option value=""<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>><?php __('En proceso'); ?></option>
                                              <option value="A"<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('A', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>>A</option>
                                              <option value="B"<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('B', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>>B</option>
                                              <option value="C"<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('C', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>>C</option>
                                              <option value="D"<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('D', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>>D</option>
                                              <option value="E"<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('E', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>>E</option>
                                              <option value="F"<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('F', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>>F</option>
                                              <option value="G"<?php if (isset($row_rsproperties_properties['emisiones_prop']) && !(strcmp('G', $row_rsproperties_properties['emisiones_prop']))) {echo "SELECTED";} ?>>G</option>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "emisiones_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "garden_m2_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="garden_m2_prop" class="form-label"><?php if ($lang_adm == 'es') { ?><?php __('M2'); ?> <?php __('Jardín'); ?><?php } else { ?><?php __('Jardín'); ?> <?php __('M2'); ?><?php } ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="garden_m2_prop" id="garden_m2_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['garden_m2_prop']); ?>" size="32" maxlength="255" class="form-control">
                                              <span class="input-group-text">m<sup>2</sup></span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "garden_m2_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "m2_parcela_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="m2_parcela_prop" class="form-label"><?php if ($lang_adm == 'es') { ?><?php __('M2'); ?> <?php __('Parcela'); ?><?php } else { ?><?php __('Parcela'); ?> <?php __('M2'); ?><?php } ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="m2_parcela_prop" id="m2_parcela_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['m2_parcela_prop']); ?>" size="32" maxlength="255" class="form-control">
                                              <span class="input-group-text">m<sup>2</sup></span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "m2_parcela_prop"); ?>
                                      </div>

                                  </div>

                              </div>

                              <div class="row">

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "construccion_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="construccion_prop" class="form-label"><?php __('Año de construcción'); ?>:</label>
                                          <input type="text" name="construccion_prop" id="construccion_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['construccion_prop']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("properties_properties", "construccion_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "entraga_date_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="entraga_date_prop" class="form-label"><?php __('Fecha de entrega'); ?>:</label>
                                          <input type="text" name="entraga_date_prop" id="entraga_date_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['entraga_date_prop']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("properties_properties", "entraga_date_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "m2_balcon_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="m2_balcon_prop" class="form-label"><?php if ($lang_adm == 'es') { ?><?php __('M2'); ?> <?php __('Terraza'); ?><?php } else { ?><?php __('Balcón'); ?> <?php __('M2'); ?><?php } ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="m2_balcon_prop" id="m2_balcon_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['m2_balcon_prop']); ?>" size="32" maxlength="255" class="form-control">
                                              <span class="input-group-text">m<sup>2</sup></span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "m2_balcon_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "m2_solarium_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="m2_solarium_prop" class="form-label"><?php __('M2'); ?> <?php __('Solarium'); ?>:</label>
                                          <div class="input-group">
                                              <input type="number" name="m2_solarium_prop" id="m2_solarium_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['m2_solarium_prop']); ?>" size="32" maxlength="255" class="form-control">
                                              <span class="input-group-text">m<sup>2</sup></span>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "m2_solarium_prop"); ?>
                                      </div>

                                  </div>

                              </div>

                              <div class="row">

                                  <div class="col-lg-3">

                                      <label for="distance_beach_prop" class="form-label"><?php __('Distancia a la playa'); ?>:</label>
                                      <div class="row">
                                          <div class="col-md-7">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_beach_prop") != '') { ?>has-error<?php } ?>">
                                                  <input type="number" name="distance_beach_prop" id="distance_beach_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['distance_beach_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_beach_prop"); ?>
                                              </div>
                                          </div>
                                          <div class="col-md-5">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_beach_med_prop") != '') { ?>has-error<?php } ?>">
                                                  <select name="distance_beach_med_prop" id="distance_beach_med_prop" class="form-select">
                                                      <option value="Km"<?php if (isset($row_rsproperties_properties['distance_beach_med_prop']) && !(strcmp('Km', $row_rsproperties_properties['distance_beach_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                      <option value="Mts"<?php if (isset($row_rsproperties_properties['distance_beach_med_prop']) && !(strcmp('Mts', $row_rsproperties_properties['distance_beach_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                      <option value="Mins"<?php if (isset($row_rsproperties_properties['distance_beach_med_prop']) && !(strcmp('Mins', $row_rsproperties_properties['distance_beach_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                  </select>
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_beach_med_prop"); ?>
                                              </div>
                                          </div>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <label for="distance_airport_prop" class="form-label"><?php __('Distancia al aereopuerto'); ?>:</label>
                                      <div class="row">
                                          <div class="col-md-7">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_airport_prop") != '') { ?>has-error<?php } ?>">
                                                  <input type="number" name="distance_airport_prop" id="distance_airport_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['distance_airport_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_airport_prop"); ?>
                                              </div>
                                          </div>
                                          <div class="col-md-5">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_airport_med_prop") != '') { ?>has-error<?php } ?>">
                                                  <select name="distance_airport_med_prop" id="distance_airport_med_prop" class="form-select">
                                                      <option value="Km"<?php if (isset($row_rsproperties_properties['distance_airport_med_prop']) && !(strcmp('Km', $row_rsproperties_properties['distance_airport_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                      <option value="Mts"<?php if (isset($row_rsproperties_properties['distance_airport_med_prop']) && !(strcmp('Mts', $row_rsproperties_properties['distance_airport_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                      <option value="Mins"<?php if (isset($row_rsproperties_properties['distance_airport_med_prop']) && !(strcmp('Mins', $row_rsproperties_properties['distance_airport_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                  </select>
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_airport_med_prop"); ?>
                                              </div>
                                          </div>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "piscina_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="piscina_prop" class="form-label"><?php __('Piscina'); ?>:</label>
                                          <select name="piscina_prop" id="piscina_prop" class="select2">
                                              <option value="" <?php if (isset($row_rsproperties_properties['piscina_prop']) && !(strcmp("", $row_rsproperties_properties['piscina_prop']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php
                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsPool['id_pl']?>"<?php if (isset($row_rsproperties_properties['piscina_prop']) && !(strcmp($row_rsPool['id_pl'], $row_rsproperties_properties['piscina_prop']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPool['pool']?></option>
                                              <?php
                                              } while ($row_rsPool = mysqli_fetch_assoc($rsPool ));
                                                $rows = mysqli_num_rows($rsPool );
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsPool , 0);
                                                  $row_rsPool = mysqli_fetch_assoc($rsPool );
                                                }
                                              ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "piscina_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "parking_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="parking_prop" class="form-label"><?php __('Parking'); ?>:</label>
                                          <select name="parking_prop" id="parking_prop" class="select2">
                                              <option value="" <?php if (isset($row_rsproperties_properties['parking_prop']) && !(strcmp("", $row_rsproperties_properties['parking_prop']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php
                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsParking['id_prk']?>"<?php if (isset($row_rsproperties_properties['parking_prop']) && !(strcmp($row_rsParking['id_prk'], $row_rsproperties_properties['parking_prop']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsParking['parking']?></option>
                                              <?php
                                              } while ($row_rsParking = mysqli_fetch_assoc($rsParking ));
                                                $rows = mysqli_num_rows($rsParking );
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsParking , 0);
                                                  $row_rsParking = mysqli_fetch_assoc($rsParking );
                                                }
                                              ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "parking_prop"); ?>
                                      </div>

                                  </div>

                              </div>

                              <div class="row">

                                  <div class="col-lg-3">

                                      <label for="distance_amenities_prop" class="form-label"><?php __('Distancia a entretenimientos'); ?>:</label>
                                      <div class="row">
                                          <div class="col-md-7">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_amenities_prop") != '') { ?>has-error<?php } ?>">
                                                  <input type="number" name="distance_amenities_prop" id="distance_amenities_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['distance_amenities_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_amenities_prop"); ?>
                                              </div>
                                          </div>
                                          <div class="col-md-5">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_amenities_med_prop") != '') { ?>has-error<?php } ?>">
                                                  <select name="distance_amenities_med_prop" id="distance_amenities_med_prop" class="form-select">
                                                      <option value="Km"<?php if (isset($row_rsproperties_properties['distance_amenities_med_prop']) && !(strcmp('Km', $row_rsproperties_properties['distance_amenities_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                      <option value="Mts"<?php if (isset($row_rsproperties_properties['distance_amenities_med_prop']) && !(strcmp('Mts', $row_rsproperties_properties['distance_amenities_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                      <option value="Mins"<?php if (isset($row_rsproperties_properties['distance_amenities_med_prop']) && !(strcmp('Mins', $row_rsproperties_properties['distance_amenities_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                  </select>
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_amenities_med_prop"); ?>
                                              </div>
                                          </div>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <label for="distance_golf_prop" class="form-label"><?php __('Distancia al campo de golf'); ?>:</label>
                                      <div class="row">
                                          <div class="col-md-7">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_golf_prop") != '') { ?>has-error<?php } ?>">
                                                  <input type="number" name="distance_golf_prop" id="distance_golf_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['distance_golf_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_golf_prop"); ?>
                                              </div>
                                          </div>
                                          <div class="col-md-5">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "distance_golf_med_prop") != '') { ?>has-error<?php } ?>">
                                                  <select name="distance_golf_med_prop" id="distance_golf_med_prop" class="form-select">
                                                      <option value="Km"<?php if (isset($row_rsproperties_properties['distance_golf_med_prop']) && !(strcmp('Km', $row_rsproperties_properties['distance_golf_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                      <option value="Mts"<?php if (isset($row_rsproperties_properties['distance_golf_med_prop']) && !(strcmp('Mts', $row_rsproperties_properties['distance_golf_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                      <option value="Mins"<?php if (isset($row_rsproperties_properties['distance_golf_med_prop']) &&  !(strcmp('Mins', $row_rsproperties_properties['distance_golf_med_prop']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                  </select>
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "distance_golf_med_prop"); ?>
                                              </div>
                                          </div>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "planta_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="planta_prop" class="form-label"><?php __('Planta'); ?>:</label>
                                          <select name="planta_prop" id="planta_prop" class="select2">
                                              <option value="" <?php if (isset($row_rsproperties_properties['planta_prop']) && !(strcmp("", $row_rsproperties_properties['planta_prop']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php for ($i=0; $i < 100; $i++) {  ?>
                                                  <option value="<?php echo $i; ?>"<?php if (isset($row_rsproperties_properties['planta_prop']) && !(strcmp($i, $row_rsproperties_properties['planta_prop']))) {echo "selected=\"selected\"";} ?>><?php if ($i == 0): ?><?php __('Planta Baja'); ?><?php else: ?><?php echo $i; ?><?php endif ?></option>
                                              <?php } ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "planta_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "plantas_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="plantas_prop" class="form-label"><?php __('Plantas del edificio'); ?>:</label>
                                          <select name="plantas_prop" id="plantas_prop" class="select2">
                                              <option value="" <?php if (isset($row_rsproperties_properties['plantas_prop']) && !(strcmp("", $row_rsproperties_properties['plantas_prop']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php for ($i=1; $i < 100; $i++) {  ?>
                                                  <option value="<?php echo $i; ?>"<?php if (isset($row_rsproperties_properties['plantas_prop']) && !(strcmp($i, $row_rsproperties_properties['plantas_prop']))) {echo "selected=\"selected\"";} ?>><?php echo $i; ?></option>
                                              <?php } ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "plantas_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "estado_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="estado_prop" class="form-label"><?php __('Conditions'); ?>:</label>
                                          <select name="estado_prop" id="estado_prop" class="select2">
                                              <option value="" <?php if (isset($row_rsproperties_properties['estado_prop']) && !(strcmp("", $row_rsproperties_properties['estado_prop']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php
                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsCondition['id_cond']?>"<?php if (isset($row_rsproperties_properties['estado_prop']) && !(strcmp($row_rsCondition['id_cond'], $row_rsproperties_properties['estado_prop']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsCondition['estado']?></option>
                                              <?php
                                              } while ($row_rsCondition = mysqli_fetch_assoc($rsCondition ));
                                                $rows = mysqli_num_rows($rsCondition );
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsCondition , 0);
                                                  $row_rsCondition = mysqli_fetch_assoc($rsCondition );
                                                }
                                              ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "estado_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                       <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "armarios_empotrados_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="armarios_empotrados_prop" class="form-label"><?php __('Armarios empotrados'); ?>:</label>
                                          <div class="input-step full-width">
                                              <button type="button" class="minus">–</button>
                                              <input type="number" name="armarios_empotrados_prop" id="armarios_empotrados_prop" value="<?php if (KT_escapeAttribute($row_rsproperties_properties['armarios_empotrados_prop']) == ''): ?>0<?php else: ?><?php echo KT_escapeAttribute($row_rsproperties_properties['armarios_empotrados_prop']); ?><?php endif ?>" min="0" max="1000" readonly="">
                                              <button type="button" class="plus">+</button>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "armarios_empotrados_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "cocinas_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="cocinas_prop" class="form-label"><?php __('Cocinas'); ?>:</label>
                                          <select name="cocinas_prop" id="cocinas_prop" class="select2">
                                              <option value="" <?php if (isset($row_rsproperties_properties['cocinas_prop']) && !(strcmp("", $row_rsproperties_properties['cocinas_prop']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                              <?php
                                              do {
                                              ?>
                                              <option value="<?php echo $row_rsKitchen['id_kchn']?>"<?php if (isset($row_rsproperties_properties['cocinas_prop']) && !(strcmp($row_rsKitchen['id_kchn'], $row_rsproperties_properties['cocinas_prop']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsKitchen['kitchen']?></option>
                                              <?php
                                              } while ($row_rsKitchen = mysqli_fetch_assoc($rsKitchen ));
                                                $rows = mysqli_num_rows($rsKitchen );
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsKitchen , 0);
                                                  $row_rsKitchen = mysqli_fetch_assoc($rsKitchen );
                                                }
                                              ?>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("properties_properties", "cocinas_prop"); ?>
                                      </div>

                                    </div>

                                    <div class="col-lg-3">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "orientacion_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="orientacion_prop" class="form-label"><?php __('Orientación'); ?>:</label>
                                            <select name="orientacion_prop" id="orientacion_prop" class="form-select">
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <option value="o-n"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-n', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-n') ?></option>
                                                <option value="o-ne"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-ne', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-ne') ?></option>
                                                <option value="o-e"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-e', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-e') ?></option>
                                                <option value="o-se"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-se', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-se') ?></option>
                                                <option value="o-s"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-s', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-s') ?></option>
                                                <option value="o-so"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-so', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-so') ?></option>
                                                <option value="o-o"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-o', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-o') ?></option>
                                                <option value="o-no"<?php if (isset($row_rsproperties_properties['orientacion_prop']) && !(strcmp('o-no', $row_rsproperties_properties['orientacion_prop']))) {echo "SELECTED";} ?>><?php echo __('o-no') ?></option>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "orientacion_prop"); ?>
                                        </div>

                                    </div>

                              </div>

                              <div class="bg-light py-1 pt-4 px-4 mb-4 mt-2 rounded-4" style="background-color: rgba(10, 179, 156, 0.1) !important;">

                                  <div class="row">

                                      <?php if ($showTeam == 1): ?>

                                      <div class="col-lg-3">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "atendido_por_prop") != '') { ?>has-error<?php } ?>">
                                              <label for="atendido_por_prop" class="form-label"><?php __('Agente'); ?>:</label>
                                              <div class="controls">

                                                  <select name="atendido_por_prop" id="atendido_por_prop" class="select2">
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsTeam['id_tms']?>"<?php if (isset($row_rsproperties_properties['atendido_por_prop']) && isset($row_rsTeam['id_tms']) && !(strcmp($row_rsTeam['id_tms'], $row_rsproperties_properties['atendido_por_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsTeam['nombre_tms']?></option>
                                                      <?php } while ($row_rsTeam = mysqli_fetch_assoc($rsTeam));
                                                        $rows = mysqli_num_rows($rsTeam);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsTeam, 0);
                                                          $row_rsTeam = mysqli_fetch_assoc($rsTeam);
                                                        } ?>
                                                  </select>
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "atendido_por_prop"); ?>
                                              </div>
                                          </div>

                                      </div>

                                      <?php endif ?>

                                      <div class="col-lg-3">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "captado_prop") != '') { ?>has-error<?php } ?>">
                                              <label for="captado_prop" class="form-label"><?php __('Captado por prop'); ?>:</label>
                                              <div class="controls">
                                                  <select name="captado_prop" id="captado_prop" class="select2">
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php do { ?>
                                                      <option value="<?php echo $row_rsusuarios['id_usr']?>"<?php if (isset($row_rsproperties_properties['captado_prop']) && !(strcmp($row_rsusuarios['id_usr'], $row_rsproperties_properties['captado_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsusuarios['nombre_usr']?></option>
                                                      <?php } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                                        $rows = mysqli_num_rows($rsusuarios);
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsusuarios, 0);
                                                          $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                                        } ?>
                                                  </select>
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "captado_prop"); ?>
                                              </div>
                                          </div>

                                      </div>

                                  </div>

                              </div>

                              <div class="row d-none">

                                  <div class="col-lg-3">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "plazas_garaje_prop") != '') { ?>has-error<?php } ?>">
                                          <label for="plazas_garaje_prop" class="form-label"><?php __('Plazas de garaje'); ?>:</label>
                                          <div class="input-step full-width">
                                              <button type="button" class="minus">–</button>
                                              <input type="number" name="plazas_garaje_prop" id="plazas_garaje_prop" value="<?php if (KT_escapeAttribute($row_rsproperties_properties['plazas_garaje_prop']) == ''): ?>0<?php else: ?><?php echo KT_escapeAttribute($row_rsproperties_properties['plazas_garaje_prop']); ?><?php endif ?>" min="0" max="1000" readonly="">
                                              <button type="button" class="plus">+</button>
                                          </div>
                                      </div>

                                  </div>

                              </div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <a href="/intramedianet/properties/features.php" target="_blank" class="btn btn-primary float-end btn-sm"><?php __('Características'); ?></a>
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Características'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                <?php
                                    $cnt2 = 0;
                                    if ($totalRows_rsproperties_properties>0) {
                                    $nested_query_rsproperties_features = str_replace("123456789", $row_rsproperties_properties['id_prop'], $query_rsproperties_features);
                                    
                                    $rsproperties_features = mysqli_query($inmoconn, $nested_query_rsproperties_features) or die(mysqli_error());
                                    $row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
                                    $totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);
                                    $nested_sw = false;
                                    if (isset($row_rsproperties_features) && is_array($row_rsproperties_features)) {
                                      do { //Nested repeat
                                    ?>
                                        <div class="col-md-4">

                                            <div class="form-check form-switch form-switch-md my-2" dir="ltr">
                                                <input type="checkbox" name="mtm_<?php echo $row_rsproperties_features['id_feat']; ?>" id="mtm_<?php echo $row_rsproperties_features['id_feat']; ?>" value="1" <?php if ($row_rsproperties_features['property'] != "") {?> checked<?php }?> class="form-check-input">
                                                <label class="form-check-label" for="mtm_<?php echo $row_rsproperties_features['id_feat']; ?>"><?php echo $row_rsproperties_features['feature_'.$lang_adm.'_feat']; ?></label>
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
                                      } while ($row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features)); //Nested move next
                                    }
                                  }
                                ?>

                                </div> <!--/.row -->

                            </div><!-- end card-body -->
                        </div>

                        <?php if ($actChatGPT == 1): ?>

                        <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info' || ($_SERVER["HTTP_HOST"] == 'demo.mediaelx.info' && ($_SESSION['kt_login_id'] == 47 || $_SESSION['kt_login_id'] == 48 || $_SESSION['kt_login_id'] == 49 || $_SESSION['kt_login_id'] == 238))): ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('ChatGPT'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col">

                                        <div class="alert alert-info alert-label-icon label-arrow fade show clearfix" role="alert">
                                            <i class="fa-regular fa-circle-info label-icon"></i> <?php echo __('Recuerde salvar el inmueble antes de utitizar ChatGPT'); ?>
                                        </div>

                                        <div class="alert alert-warning alert-label-icon label-arrow fade show clearfix" role="alert">
                                            <i class="fa-regular fa-circle-exclamation label-icon"></i> <?php echo __('ChatGPTAdv1'); ?>
                                        </div>

                                    </div>

                                </div> <!--/.row -->

                                <div class="row">

                                    <div class="col-6 col-md-4">
                                        <a href="javascript:;" class="btn btn-primary w-100 gratgptmodal" data-action="getText" data-bs-toggle="modal" data-bs-target="#ChatGPTModal"><i class="fa-solid fa-fw fa-message-captions me-1"></i> <?php __('Generar'); ?></a>
                                    </div>

                                    <div class="col-6 col-md-4">
                                        <a href="javascript:;" class="btn btn-primary w-100 gratgptmodal" data-action="getTrans" data-bs-toggle="modal" data-bs-target="#ChatGPTransModal"><i class="fa-regular fa-fw fa-language me-1"></i> <?php __('Traducir'); ?></a>
                                    </div>

                                </div>

                            </div><!-- end card-body -->
                        </div>

                        <?php endif ?>

                        <?php endif ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Descipción'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                                <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <?php foreach($languages as $value) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link tabdescr tabdescr-<?php echo $value; ?> <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langdescprop-<?php echo $value; ?>" role="tab" aria-selected="true" data-lang="<?php echo $value; ?>">
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
                                            <a class="nav-link tabdescr-<?php echo $value; ?> <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langdescprop-<?php echo $value; ?>" role="tab" aria-selected="true">
                                                <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>
                                    <div class="tab-pane <?php if($value == $language) { ?>active<?php } ?>" id="langdescprop-<?php echo $value; ?>" role="tabpanel">

                                        <div class="mb-4">
                                            <label for="titulo_<?php echo $value; ?>_prop" class="form-label"><?php __('Titular'); ?>/H1:</label>
                                            <input type="text" name="titulo_<?php echo $value; ?>_prop" id="titulo_<?php echo $value; ?>_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['titulo_'.$value.'_prop']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "titulo_".$value."_prop"); ?>
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
                                                            data-fields-pref="titulo_"
                                                            data-fields-suf="_prop"
                                                            data-tab="desc"
                                                        ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                                <br>
                                            <?php endif ?>
                                        </div>

                                        <br class="d-md-none">
                                        <br class="d-md-none">

                                        <textarea name="descripcion_<?php echo $value; ?>_prop" id="descripcion_<?php echo $value; ?>_prop" rows="5" class="wysiwyg mt-5"><?php echo KT_escapeAttribute($row_rsproperties_properties['descripcion_'.$value.'_prop']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "descripcion_".$lang_adm."__prop"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end">
                                            <?php foreach ($languages as $langx): ?>
                                                <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                        data-from="<?php echo $value; ?>"
                                                        data-to="<?php echo $langx; ?>"
                                                        data-fields-pref="descripcion_"
                                                        data-fields-suf="_prop"
                                                        data-tab="desc"
                                                    ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            </div>
                                            <br>
                                        <?php endif ?>

                                        <br class="d-md-none">
                                        <br class="d-md-none">

                                        <label for="descripcion_xml_<?php echo $value; ?>_prop" class="form-label mt-4"><?php __('Descipción'); ?> XML:</label>

                                        <textarea name="descripcion_xml_<?php echo $value; ?>_prop" id="descripcion_xml_<?php echo $value; ?>_prop" rows="5" class="wysiwyg mt-5"><?php echo KT_escapeAttribute($row_rsproperties_properties['descripcion_xml_'.$value.'_prop']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "descripcion_xml_".$lang_adm."__prop"); ?>
                                        <?php if ($traduccion_textos == 1): ?>
                                            <div class="float-end">
                                            <?php foreach ($languages as $langx): ?>
                                                <?php if ($langx != $value): ?>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                        data-from="<?php echo $value; ?>"
                                                        data-to="<?php echo $langx; ?>"
                                                        data-fields-pref="descripcion_xml_"
                                                        data-fields-suf="_prop"
                                                        data-tab="desc"
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

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Imágenes'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php if($actWatermark == 2) { ?>
                                <div class="form-check form-switch form-switch-lg float-end" dir="ltr">
                                    <input type="checkbox" name="watermark_prop" id="watermark_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['watermark_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['watermark_prop']),"1"))) {echo "checked";} ?>>
                                    <label class="form-check-label" for="watermark_prop"><?php __('Marca de agua'); ?></label>
                                    <?php echo $tNGs->displayFieldError("properties_properties", "watermark_prop"); ?>
                                </div>
                                 <?php } ?>

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

                                <?php if($row_rsImages['image_img'] != '') { ?>

                                <li class="pull-left" id="order_<?php echo $row_rsImages['id_img'] ?>" data-id="<?php echo $row_rsImages['id_img'] ?>">

                                <div class="img-thumbnail pull-left">
                                  <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsImages['id_img'].'_sm.jpg')) { ?>
                                      <a href="/media/images/properties/thumbnails/<?php echo $row_rsImages['id_img'] ?>_lg.jpg" data-toggle="lightbox"><img src="/media/images/properties/thumbnails/<?php echo $row_rsImages['id_img'] ?>_sm.jpg" alt="" style="width: 150px;"></a>
                                  <?php } else { ?>
                                      <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="width: 150px;">
                                  <?php } ?>

                                  <div class="text-center mt-2 mb-1">

                                      <a href="#" class="btn btn-success btn-sm edit-alt" data-id="<?php echo $row_rsImages['id_img'] ?>"><i class="fa-regular fa-pencil"></i></a> <a href="images_del.php" data-id="<?php echo $row_rsImages['id_img'] ?>" class="btn btn-danger btn-sm del-img"><i class="fa-regular fa-trash-can"></i></a>

                                      <div class="form-check form-switch form-switch-sm d-inline float-start" dir="ltr">
                                          <input type="checkbox" name="del[]" id="ck<?php echo $row_rsImages['id_img'] ?>" value="<?php echo $row_rsImages['id_img'] ?>" class="form-check-input delimgv">
                                      </div>

                                      <?php $altDisp = false; ?>

                                      <?php
                                        foreach($languages as $value) {
                                          if($row_rsImages['alt_'.$value.'_img'] == '') {
                                            $altDisp = true;
                                          }
                                        }
                                      ?>

                                      <?php if($altDisp == true) { ?>
                                      <i class="fa-regular fa-asterisk text-danger mt-1"></i>
                                      <?php } ?>

                                  </div>

                                </div>

                                </li>

                                <?php } ?>
                                <?php } while ($row_rsImages = mysqli_fetch_assoc($rsImages)); ?>
                                <?php } ?>

                                </ul><hr>

                                <a href="#" class="btn btn-danger btn-sm delimgsvar"><i class="fa-regular fa-trash-can me-1"></i> <?php __('Delete selected images'); ?></a>
                                <a href="#" class="btn btn-danger btn-sm delallimgsvar mt-2 mt-md-0"><i class="fa-regular fa-trash-can me-1"></i> <?php __('Delete all images'); ?></a>

                                <div class="float-end">
                                    <a href="#" class="btn btn-success btn-sm downloadimgsvar mt-2 mt-md-0"><i class="fa-regular fa-download me-1"></i> <?php __('Download selected images'); ?></a>
                                    <a href="#" class="btn btn-success btn-sm downloadallimgsvar mt-2 mt-md-0 mb-4 mb-md-0"><i class="fa-regular fa-download me-1"></i> <?php __('Download all images'); ?></a>
                                </div>

                                <hr style="clear: both">

                                <div class="multi_images"></div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Etiquetas'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check form-switch form-switch-md mt-4" dir="ltr">
                                            <input type="checkbox" name="vendido_tag_prop" id="vendido_tag_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['vendido_tag_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['vendido_tag_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="vendido_tag_prop"><?php __('Vendido'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "vendido_tag_prop"); ?>
                                        </div>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "vendido_tag_prop"); ?>
                                    </div>
                                    <!--/.col-md-3 -->
                                    <div class="col-md-3">
                                        <div class="form-check form-switch form-switch-md mt-4" dir="ltr">
                                            <input type="checkbox" name="alquilado_prop" id="alquilado_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['alquilado_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['alquilado_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="alquilado_prop"><?php __('Alquilado'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "alquilado_prop"); ?>
                                        </div>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "alquilado_prop"); ?>
                                    </div>
                                    <!--/.col-md-3 -->
                                    <div class="col-md-3">
                                        <div class="form-check form-switch form-switch-md mt-4" dir="ltr">
                                            <input type="checkbox" name="reservado_prop" id="reservado_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['reservado_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['reservado_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="reservado_prop"><?php __('Reservado'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "reservado_prop"); ?>
                                        </div>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "reservado_prop"); ?>
                                    </div>
                                    <!--/.col-md-3 -->
                                    <div class="col-md-3">
                                        <div class="mb-2 <?php if($tNGs->displayFieldError(" properties_properties", "nuevo_prop" ) !='' ) { ?>has-error
                                            <?php } ?>">
                                            <label for="nuevo_prop" class="form-label"><?php __('Mostrar como nuevo hasta el'); ?>:</label>
                                            <input type="text" name="nuevo_prop" id="nuevo_prop" value="<?php echo KT_formatDate($row_rsproperties_properties['nuevo_prop']); ?>" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "nuevo_prop"); ?>
                                        </div>
                                    </div>
                                    <!--/.col-md-3 -->
                                </div>
                                <!--/.row -->

                                <div class="row">

                                    <?php
                                    $cnt3 = 0;
                                    if ($totalRows_rsproperties_properties>0) {
                                    $nested_query_rsTags = str_replace("123456789", $row_rsproperties_properties['id_prop'], $query_rsTags);
                                    
                                    $rsTags = mysqli_query($inmoconn, $nested_query_rsTags) or die(mysqli_error());
                                    $row_rsTags = mysqli_fetch_assoc($rsTags);
                                    $totalRows_rsTags = mysqli_num_rows($rsTags);
                                    $nested_sw = false;
                                    if (isset($row_rsTags) && is_array($row_rsTags)) {
                                      do { //Nested repeat
                                    ?>
                                        <div class="col-md-3">
                                            <div class="form-check form-switch form-switch-md mt-4" dir="ltr">
                                                <input type="checkbox" name="mtm3_<?php echo $row_rsTags['id_tag']; ?>" id="mtm3_<?php echo $row_rsTags['id_tag']; ?>" value="1" class="form-check-input" <?php if ($row_rsTags['property'] != "") {?> checked<?php }?>>
                                                <label class="form-check-label" for="mtm3_<?php echo $row_rsTags['id_tag']; ?>"><?php echo $row_rsTags['tag_'.$lang_adm.'_tag']; ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "reservado_prop"); ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Localización'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-5">

                                        <div class="pb-md-4 <?php if($tNGs->displayFieldError("properties_properties", "direccion_gp_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="google_maps">&nbsp;&nbsp;</label>
                                            <a href="https://www.google.es/maps" id="google_maps" target="_blank" class="btn btn-info w-100"><i class="fa-regular fa-map-location-dot"></i> <?php __('Ir a Google Maps'); ?></a>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "direccion_gp_prop"); ?>
                                        </div>

                                    </div> <!--/.col-md-7 -->

                                    <div class="col-md-4">

                                        <div class="pb-md-4 <?php if($tNGs->displayFieldError("properties_properties", "lat_long_gp_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="lat_long_gp_prop"><?php __('Latitud y longitud'); ?>:</label>
                                            <div class="input-group">
                                                <input pattern="^-?\d{1,2}\.\d+\s*,\s*-?\d{1,3}\.\d+$"   type="text" name="lat_long_gp_prop" id="lat_long_gp_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['lat_long_gp_prop']); ?>" size="32" maxlength="255" placeholder="<?php __('Separadas por comas'); ?>: 32.032371,-0.663581"   title="<?php __('Separadas por comas'); ?>: 32.032371,-0.663581" class="form-control comp_lat_lng" >
                                                <button class="btn btn-primary btn-copy-latlong" type="button" onclick="copyToClipboard('#lat_long_gp_prop')"><i class="fa-regular fa-clipboard"></i></button>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "lat_long_gp_prop"); ?>
                                        </div>

                                    </div> <!--/.col-md-3 -->

                                    <div class="col-md-3">

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "zoom_gp_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="zoom_gp_prop"><?php __('Zoom'); ?>:</label>
                                            <input type="text" name="zoom_gp_prop" id="zoom_gp_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['zoom_gp_prop']); ?>" size="32" maxlength="255" class="form-control zoom_gp_prop">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "zoom_gp_prop"); ?>
                                        </div>

                                    </div> <!--/.col-md-2 -->

                                </div> <!--/.row -->

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Vídeos'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
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
                                              <p class="text-center"><a href="/intramedianet/properties/videos_del.php" data-id="<?php echo $row_rsVideos['id_vid'] ?>" class="btn btn-danger btn-sm del-vid"><i class="fa-regular fa-trash-can"></i></a></p>
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

                                    <a href="#" class="btn btn-success btn-sm float-end mt-2" id="addVid"  data-id="<?php echo $property_id; ?>"><?php __('Añadir vídeo'); ?></a>

                                </div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('360º'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "vista360_prop") != '') { ?>has-error<?php } ?>">
                                    <label for="vista360_prop" class="form-label"><?php __('Vista 360'); ?>:</label>
                                    <input type="url" name="vista360_prop" id="vista360_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['vista360_prop']); ?>" size="32" maxlength="255" class="form-control url" placeholder="https://">
                                    <?php echo $tNGs->displayFieldError("properties_properties", "vista360_prop"); ?>
                                </div>

                                <hr>

                                <small><i class="fa-regular fa-arrows-maximize fa-fw"></i>
                                    <?php __('Para cambiar el orden de las fotos, arrastre y suelte la fotos en la ubicación deseada'); ?>.</small>
                                <hr>
                                <div id="tressesenta-order-loading"></div>
                                <ul class="thumbnails clearfix nested-sortable-tressesenta" id="tressesenta-list">
                                    <?php if($totalRows_rs360 > 0) { ?>
                                    <?php do { ?>
                                    <li class="pull-left" id="order_<?php echo $row_rs360['id_360'] ?>" data-id="<?php echo $row_rs360['id_360'] ?>">
                                        <div class="img-thumbnail pull-left" style="width: 250px;">
                                            <?php
                                            $youtube = str_replace("\\\"","\"",$row_rs360['video_360']) ;
                                            $ancho = 300;

                                            preg_match('/width="([0-9]+)%?"/', $youtube, $coincidencias);
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
                                            <p class="text-center"><a href="/intramedianet/properties/360_del.php" data-id="<?php echo $row_rs360['id_360'] ?>" class="btn btn-danger btn-sm del-vid"><i class="fa-regular fa-trash-can"></i></a></p>
                                        </div>
                                    </li>
                                    <?php } while ($row_rs360 = mysqli_fetch_assoc($rs360)); ?>
                                    <?php } ?>
                                </ul>
                                <hr>
                                <div class="well well-sm clearfix">
                                    <div class="form-group">
                                        <label for="txt360" class="form-label">360º:</label>
                                        <textarea type="text" name="txt360" id="txt360" cols="5" rows="3" class="form-control"></textarea>
                                    </div> <!-- /.form-group -->
                                    <a href="#" class="btn btn-success btn-sm float-end mt-2" id="add360" data-id="<?php echo $property_id; ?>"><?php __('Añadir'); ?> 360º</a>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        <?php __('Buscadores'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <?php foreach($languages as $value) { ?>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link tabmet-<?php echo $value; ?> <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langseoprop-<?php echo $value; ?>" role="tab" aria-selected="true">
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
                                        <a class="nav-link tabmet-<?php echo $value; ?> <?php if($value == $language) { ?>active<?php } ?>" data-bs-toggle="tab" href="#langseoprop-<?php echo $value; ?>" role="tab" aria-selected="true">
                                            <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20">
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php foreach($languages as $value) { ?>
                                    <div class="tab-pane <?php if($value == $language) { ?>active<?php } ?>" id="langseoprop-<?php echo $value; ?>" role="tabpanel">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "title_<?php echo $value; ?>_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="title_<?php echo $value; ?>_prop" class="form-label"><?php __('Title'); ?>/URL:</label>
                                            <input type="text" maxlength="255" name="title_<?php echo $value; ?>_prop" id="title_<?php echo $value; ?>_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['title_'.$value.'_prop']); ?>" size="32" class="form-control counter70 textcountseo">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "title_<?php echo $value; ?>_prop"); ?>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="title_"
                                                            data-fields-suf="_prop"
                                                            data-tab="desc"
                                                        ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                                <br>
                                            <?php endif ?>
                                            <div id="title_<?php echo $value; ?>_prop_txt" class="count_chars"></div>
                                        </div>
                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "description_<?php echo $value; ?>_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="description_<?php echo $value; ?>_prop" class="form-label"><?php __('Description'); ?>:</label>
                                            <textarea name="description_<?php echo $value; ?>_prop" id="description_<?php echo $value; ?>_prop" cols="50" rows="5" class="form-control counter160 textcountseo"><?php echo KT_escapeAttribute($row_rsproperties_properties['description_'.$value.'_prop']); ?></textarea>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "description_<?php echo $value; ?>_prop"); ?>
                                            <div id="description_<?php echo $value; ?>_prop_txt" class="count_chars"></div>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="description_"
                                                            data-fields-suf="_prop"
                                                            data-tab="seo"
                                                        ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                                <br>
                                            <?php endif ?>
                                        </div>
                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "keywords_<?php echo $value; ?>_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="keywords_<?php echo $value; ?>_prop" class="form-label"><?php __('Keywords'); ?>:</label>
                                            <textarea name="keywords_<?php echo $value; ?>_prop" id="keywords_<?php echo $value; ?>_prop" cols="50" rows="5" class="form-control counter160"><?php echo KT_escapeAttribute($row_rsproperties_properties['keywords_'.$value.'_prop']); ?></textarea>
                                            <?php if ($traduccion_textos == 1): ?>
                                                <div class="float-end">
                                                <?php foreach ($languages as $langx): ?>
                                                    <?php if ($langx != $value): ?>
                                                        <button type="button" class="btn btn-soft-primary btn-sm btn-translate mt-1"
                                                            data-from="<?php echo $value; ?>"
                                                            data-to="<?php echo $langx; ?>"
                                                            data-fields-pref="keywords_"
                                                            data-fields-suf="_prop"
                                                            data-tab="seo"
                                                        ><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" height="13"> <i class="fa-solid fa-caret-right mx-1"></i> <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $langx; ?>.svg" height="13"></button>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                                <br>
                                            <?php endif ?>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "keywords_<?php echo $value; ?>_prop"); ?>
                                        </div>

                                    </div>
                                    <?php } ?>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Planos'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php if($actWatermark == 2) { ?>
                                <div class="form-check form-switch form-switch-lg float-end" dir="ltr">
                                    <input type="checkbox" name="watermark_prop" id="watermark_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['watermark_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['watermark_prop']),"1"))) {echo "checked";} ?>>
                                    <label class="form-check-label" for="watermark_prop"><?php __('Marca de agua'); ?></label>
                                    <?php echo $tNGs->displayFieldError("properties_properties", "watermark_prop"); ?>
                                </div>
                                 <?php } ?>

                                <small><i class="fa-regular fa-image fa-fw"></i> <?php __('Extensiones permitidas'); ?>: jpg, gif <?php __('y'); ?> png.</small>
                                <br>
                                <small><i class="fa-regular fa-asterisk text-danger fa-fw"></i> <?php __('No se han añadido los textos para el SEO'); ?> </small>
                                <br>
                                <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de las fotos, arrastre y suelte la fotos en la ubicación deseada'); ?>.</small>

                                <hr>

                                <div id="planos-order-loading"></div>

                                <ul class="thumbnails clearfix nested-sortable-planos" id="planos-list">

                                <?php if($totalRows_rsPlanos > 0) { ?>

                                <?php do { ?>

                                <?php if($row_rsPlanos['image_img'] != '') { ?>

                                <li class="pull-left" id="order_<?php echo $row_rsPlanos['id_img'] ?>" data-id="<?php echo $row_rsPlanos['id_img'] ?>">

                                <div class="img-thumbnail pull-left">
                                  <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesplanos/thumbnails/'.$row_rsPlanos['id_img'].'_sm.jpg')) { ?>
                                      <a href="/media/images/propertiesplanos/thumbnails/<?php echo $row_rsPlanos['id_img'] ?>_lg.jpg" data-toggle="lightbox"><img src="/media/images/propertiesplanos/thumbnails/<?php echo $row_rsPlanos['id_img'] ?>_sm.jpg" alt="" style="width: 150px;"></a>
                                  <?php } else { ?>
                                      <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="width: 150px;">
                                  <?php } ?>

                                  <div class="text-center mt-2 mb-1">

                                      <a href="#" class="btn btn-success btn-sm edit-alt" data-id="<?php echo $row_rsPlanos['id_img'] ?>"><i class="fa-regular fa-pencil"></i></a>
                                      <a href="planos_del.php" data-id="<?php echo $row_rsPlanos['id_img'] ?>" class="btn btn-danger btn-sm del-img"><i class="fa-regular fa-trash-can"></i></a>

                                      <?php $altDisp = false; ?>

                                      <?php
                                        foreach($languages as $value) {
                                          if($row_rsPlanos['alt_'.$value.'_img'] == '') {
                                            $altDisp = true;
                                          }
                                        }
                                      ?>

                                      <?php if($altDisp == true) { ?>
                                      <i class="fa-regular fa-asterisk text-danger mt-1"></i>
                                      <?php } ?>

                                  </div>

                                </div>

                                </li>

                                <?php } ?>
                                <?php } while ($row_rsPlanos = mysqli_fetch_assoc($rsPlanos)); ?>
                                <?php } ?>

                                </ul>

                                <hr style="clear: both">

                                <div class="multi_planos"></div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Archivos públicos'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
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
                                       <?php if (preg_match('/https?:/', $row_rsFiles['file_fil'])): ?>
                                           <li class="pull-left" id="order_<?php echo $row_rsFiles['id_fil'] ?>" data-id="<?php echo $row_rsFiles['id_fil'] ?>">
                                               <div class="img-thumbnail pull-left">
                                                   <a href="<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br>
                                                       <small>
                                                         <?php
                                                             $name = basename($row_rsFiles['file_fil']);
                                                             $plans['0'] = 'Planta baja';
                                                             $plans['1'] = 'Planta 1';
                                                             $plans['2'] = 'Planta 2';
                                                             $plans['3'] = 'Planta 3';
                                                             $plans['01'] = 'Planta baja + Planta 1';
                                                             $plans['012'] = 'Planta baja + Planta 1 + Planta 2';
                                                             $plans['G'] = 'Sótano';
                                                             $plans['G0'] = 'Sótano + Planta baja';
                                                             $plans['G01'] = 'Sótano + Planta baja + Planta 1';
                                                             $plans['G012'] = 'Sótano + Planta baja + Planta 1 + Planta 2';
                                                             $plans['G01S'] = 'Sótano + Planta baja + Planta 1 + Solarium';
                                                             $plans['S'] = 'Solarium';
                                                             $plans['0S'] = 'Planta baja + Solarium';
                                                             $plans['01S'] = 'Planta baja + Planta 1 + Solarium';
                                                             $plans['012S'] = 'Planta baja + Planta 1 + Planta 2 + Solarium';
                                                             $plans['P'] = 'Parcela';

                                                             echo __($plans[preg_replace("/\.[^.]+$/", "", $name)]);
                                                         ?>
                                                       </small>
                                                   </a>
                                                   <p class="text-center">
                                                   <!-- <a href="/intramedianet/properties/files_del.php" data-id="<?php echo $row_rsFiles['id_fil'] ?>" class="btn btn-danger btn-sm del-fil2"><i class="fa-regular fa-trash-can"></i></a> -->
                                                   </p>
                                               </div>
                                           </li>
                                       <?php else: ?>
                                           <li class="pull-left" id="order_<?php echo $row_rsFiles['id_fil'] ?>" data-id="<?php echo $row_rsFiles['id_fil'] ?>">
                                               <div class="img-thumbnail pull-left">
                                                   <a href="/media/files/properties/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br><small><?php echo $row_rsFiles['file_fil']; ?></small></a>
                                                   <p class="text-center">
                                                   <a href="#" class="btn btn-success btn-sm edit-name" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-pencil"></i></a>
                                                   <a href="#" class="btn btn-info btn-sm edit-lang" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-language"></i></a>
                                                   <a href="/intramedianet/properties/files_del.php" data-id="<?php echo $row_rsFiles['id_fil'] ?>" class="btn btn-danger btn-sm del-fil2"><i class="fa-regular fa-trash-can"></i></a>
                                                   </p>
                                               </div>
                                           </li>
                                       <?php endif ?>
                                       <?php } while ($row_rsFiles = mysqli_fetch_assoc($rsFiles)); ?>
                                   <?php } ?>
                                </ul>
                                <hr>
                                <div class="multi_files"></div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Imágenes'); ?> PDF: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <small><i class="fa fa-arrows-alt"></i> <?php __('Para cambiar el orden de las fotos, arrastre y suelte la fotos en la ubicación deseada'); ?>.</small>

                                <hr>

                                <div id="img-order-loadingPDF"></div>

                                <ul class="thumbnails clearfix nested-sortable-imgPDF" id="images-listPDF">

                                <?php if($totalRows_rsImagesPDF > 0) { ?>

                                <?php do { ?>

                                <?php if($row_rsImagesPDF['image_img'] != '') { ?>

                                <li class="pull-left" id="order_<?php echo $row_rsImagesPDF['id_img'] ?>"data-id="<?php echo $row_rsImagesPDF['id_img'] ?>">

                                <div class="img-thumbnail pull-left">
                                    <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsImagesPDF['id_img'].'_md.jpg')) { ?>
                                        <a href="/media/images/properties/thumbnails/<?php echo $row_rsImagesPDF['id_img'] ?>_md.jpg" data-toggle="lightbox"><img src="/media/images/properties/thumbnails/<?php echo $row_rsImagesPDF['id_img'] ?>_sm.jpg" alt="" style="height: 100px;"></a>
                                    <?php } else { ?>
                                        <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="height: 100px;">
                                    <?php } ?>
                                </div>

                                </li>

                                <?php } ?>

                                <?php } while ($row_rsImagesPDF = mysqli_fetch_assoc($rsImagesPDF)); ?>

                                <?php } ?>

                                </ul>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                    <div class="tab-pane" id="tabcrm" role="tabpanel">

                        <?php if ($actPropietarios == 1) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1 d-none d-md-inline-block"><?php __('Propietario'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    <button class="btn btn-primary btn-sm print-data d-none d-md-inline-block"><i class="fa-regular fa-print me-1"></i> <?php __('Imprimir'); ?> <?php __('Propietario'); ?> <?php __('y'); ?> <?php __('Datos privados'); ?></button>
                                    <a href="/reporte/<?php echo encryptIt($property_id) ?>/" class="btn btn-primary btn-sm" target="_blank"><i class="fa-regular fa-chart-pie me-1 mt-n2 position-relative"></i> <?php __('Reporte propietario'); ?></a>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "owner_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="owner_prop" class="form-label"><?php __('Propietario'); ?>:</label>
                                            <input type="text" class="select2owners w-100" id="owner_prop" name="owner_prop" value="<?php if(isset($row_rsproperties_properties['owner_prop'])) echo $row_rsproperties_properties['owner_prop'] ?>" tabindex="-1">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "owner_prop"); ?>
                                        </div>

                                    </div> <!--/.col-md-6 -->

                                    <div class="col-md-3">
                                        <br>
                                        <a href="javascript:void(0);" class="btn btn-success w-100 add-prop"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir propietario'); ?></a>
                                    </div> <!--/.col-md-3 -->

                                    <div class="col-md-3">
                                        <br>
                                        <a href="javascript:void(0);" class="btn btn-info w-100 edit-prop"><i class="fa-regular fa-pencil me-1"></i> <?php __('Editar propietario'); ?></a>
                                    </div> <!--/.col-md-3 -->

                                </div> <!--/.row -->

                                <div id="owner-data"></div>

                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                        <?php if($_SESSION['kt_login_level'] == 9) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Datos privados'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- <div class="row">
                                    <div class="col-md-9">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-4 <?php //if($tNGs->displayFieldError("properties_properties", "num_com_mail_prop") != '') { ?>has-error<?php //} ?>">
                                            <label for="num_com_mail_prop" class="form-label"><?php //__('Nº de comunicaciones por email'); ?>:</label>
                                            <div class="input-step full-width">
                                                <button type="button" class="minus">–</button>
                                                <input type="number" name="num_com_mail_prop" id="num_com_mail_prop" value="<?php //if (KT_escapeAttribute($row_rsproperties_properties['num_com_mail_prop']) == ''): ?>0<?php //else: ?><?php //echo KT_escapeAttribute($row_rsproperties_properties['num_com_mail_prop']); ?><?php //endif ?>" min="0" max="1000" readonly="">
                                                <button type="button" class="plus">+</button>
                                            </div>
                                            <?php //echo $tNGs->displayFieldError("properties_properties", "num_com_mail_prop"); ?>
                                        </div>
                                    </div>
                                </div> -->


                                <div class="row">
                                  <div class="col-lg-8">
                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "direccion_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="direccion_prop" class="form-label"><?php __('Dirección real vivienda'); ?>:</label>
                                            <input type="text" name="direccion_prop" id="direccion_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['direccion_prop']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "direccion_prop"); ?>
                                      </div>

                                  </div>

                                  <div class="col-lg-4">

                                    <div class="row">
                                      <div class="col-lg-6">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "suma_prop") != '') { ?>has-error<?php } ?>">
                                              <label for="suma_prop" class="form-label"><?php __('Suma/IBI'); ?>:</label>
                                              <div class="controls">
                                                  <input type="text" name="suma_prop" id="suma_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['suma_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "suma_prop"); ?>
                                              </div>
                                          </div>

                                      </div>
                                      <div class="col-lg-6">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "gastos_prop") != '') { ?>has-error<?php } ?>">
                                              <label for="gastos_prop" class="form-label"><?php __('Gastos de la comunidad'); ?>:</label>
                                              <div class="controls">
                                                  <input type="text" name="gastos_prop" id="gastos_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['gastos_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                  <?php echo $tNGs->displayFieldError("properties_properties", "gastos_prop"); ?>
                                              </div>
                                          </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>



                                <div class="row">

                                    <div class="col-md-8">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "direccion_agen_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="direccion_agen_prop" class="form-label"><?php __('Dirección para agente'); ?>:</label>
                                            <input type="text" name="direccion_agen_prop" id="direccion_agen_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['direccion_agen_prop']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "direccion_agen_prop"); ?>
                                      </div>

                                      <div class="mb-5 <?php if($tNGs->displayFieldError("properties_properties", "notas_prop") != '') { ?>has-error<?php } ?>">
                                        <label for="notas_prop" class="form-label"><?php __('Notas'); ?>:</label>
                                        <textarea name="notas_prop" id="notas_prop" cols="50" rows="10" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_properties['notas_prop']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "notas_prop"); ?>
                                        <a href="#" class="btn btn-success btn-sm addHist float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                                    </div>


                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "dropbox_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="dropbox_prop" class="form-label"><?php __('Dropbox'); ?>:</label>
                                            <input type="url" name="dropbox_prop" id="dropbox_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['dropbox_prop']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_properties", "dropbox_prop"); ?>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-7">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "bogado_prop") != '') { ?>has-error<?php } ?>">
                                              <label for="bogado_prop" class="form-label"><?php __('Abogado'); ?>:</label>
                                              <div class="controls">
                                                  <input type="text" name="bogado_prop" id="bogado_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['bogado_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "bogado_prop"); ?>
                                              </div>
                                          </div>
                                          </div>
                                          <div class="col-md-5">
                                             <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "abogado_telefono_prop") != '') { ?>has-error<?php } ?>">
                                                <label for="abogado_telefono_prop" class="form-label"><?php __('Abogado'); ?> <?php __('Teléfono'); ?>:</label>
                                                <div class="controls">
                                                    <input type="text" name="abogado_telefono_prop" id="abogado_telefono_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['abogado_telefono_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "abogado_telefono_prop"); ?>
                                                </div>
                                            </div>
                                          </div>
                                        </div>





                                        <div class="card">

                                            <div class="card-body bg-light d-none">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "precio_propie_prop") != '') { ?>has-error<?php } ?>">
                                                    <label for="precio_propie_prop" class="form-label"><?php __('Precio propietario'); ?>:</label>
                                                    <div class="controls">
                                                        <input type="text" name="precio_propie_prop" id="precio_propie_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['precio_propie_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "precio_propie_prop"); ?>
                                                    </div>
                                                </div>


                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "comision_prop") != '') { ?>has-error<?php } ?>">
                                                    <label for="comision_prop" class="form-label"><?php __('% Valor comisión'); ?>:</label>
                                                    <div class="controls">
                                                        <input type="text" name="comision_prop" id="comision_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['comision_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "comision_prop"); ?>
                                                    </div>
                                              </div>

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "iva_prop") != '') { ?>has-error<?php } ?>">
                                                      <div class="controls">
                                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                                                            <input type="checkbox" name="iva_prop" id="iva_prop" value="1" class="form-check-input mt-2" <?php if (isset($row_rsproperties_properties['iva_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['iva_prop']),"1"))) {echo "checked";} ?>>
                                                            <label class="form-check-label" for="iva_prop"><?php __('Aplicar'); ?></label>
                                                            <input type="text" name="iva_porc_prop" id="iva_porc_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['iva_porc_prop']); ?>" size="32" maxlength="255" class="form-control w-25 d-inline-block mx-2"> <?php __('% de iva'); ?>
                                                            <?php echo $tNGs->displayFieldError("properties_properties", "iva_prop"); ?>
                                                        </div>

                                                        </div>
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "iva_prop"); ?>
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "iva_porc_prop"); ?>
                                                </div>

                                                <div class="mb-4">
                                                    <a href="#" class="btn btn-success btn-sm w-100 calcPre pull-right"><i class="fa-regular fa-calculator me-1"></i> <?php __('Calcular'); ?></a>
                                                </div>

                                                <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "precio_venta_prop") != '') { ?>has-error<?php } ?>">
                                                    <label for="precio_venta_prop" class="form-label"><?php __('Precio de venta'); ?>:</label>
                                                    <div class="controls">
                                                        <input type="text" name="precio_venta_prop" id="precio_venta_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['precio_venta_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "precio_venta_prop"); ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card">



                                            <div class="card-body bg-light">

                                                <div class="checkbox">
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input type="checkbox" name="hipoteca_prop" id="hipoteca_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['hipoteca_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['hipoteca_prop']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="hipoteca_prop"><?php __('Hipoteca'); ?></label>
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "hipoteca_prop"); ?>
                                                    </div>
                                                </div>

                                                    <div id="hipotxt" <?php if($row_rsproperties_properties['hipoteca_prop'] != '1') { ?>style="display: none"<?php } ?>>

                                                    <div class="mt-4 <?php if($tNGs->displayFieldError("properties_properties", "entidad_prop") != '') { ?>has-error<?php } ?>">
                                                        <label for="entidad_prop" class="form-label"><?php __('Entidad'); ?>:</label>
                                                        <div class="controls">
                                                            <input type="text" name="entidad_prop" id="entidad_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['entidad_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "entidad_prop"); ?>
                                                        </div>
                                                    </div>

                                                    <div class="mt-4 <?php if($tNGs->displayFieldError("properties_properties", "pendiente_prop") != '') { ?>has-error<?php } ?>">
                                                        <label for="pendiente_prop" class="form-label"><?php __('Cantidad pendiente'); ?>:</label>
                                                        <div class="controls">
                                                            <input type="text" name="pendiente_prop" id="pendiente_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['pendiente_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "pendiente_prop"); ?>
                                                        </div>
                                                    </div>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="row">
                                          <div class="col-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "commission_prop") != '') { ?>has-error<?php } ?>">
                                                      <label for="commission_prop" class="form-label"><?php __('Comisión Real'); ?>:</label>
                                                      <div class="controls">
                                                          <input type="text" name="commission_prop" id="commission_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['commission_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_properties", "commission_prop"); ?>
                                                      </div>
                                                  </div>

                                          </div>
                                          <div class="col-6">

                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "comision_agent_prop") != '') { ?>has-error<?php } ?>">
                                                        <label for="comision_agent_prop" class="form-label"><?php __('Comisión Agente'); ?>:</label>
                                                        <div class="controls">
                                                            <input type="text" name="comision_agent_prop" id="comision_agent_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['comision_agent_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "comision_agent_prop"); ?>
                                                        </div>
                                                </div>

                                          </div>
                                        </div>

                                        <div class="row">


                                          <div class="col-lg-6">

                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "dev_commission_prop") != '') { ?>has-error<?php } ?>">
                                                        <label for="dev_commission_prop" class="form-label"><?php __('Comisión del contrucctor'); ?>:</label>
                                                        <div class="controls">
                                                            <input type="text" name="dev_commission_prop" id="dev_commission_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['dev_commission_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "dev_commission_prop"); ?>
                                                        </div>
                                                </div>

                                          </div>

                                          <div class="col-lg-6">

                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "referencia_catrastal_prop") != '') { ?>has-error<?php } ?>">
                                                  <label for="referencia_catrastal_prop" class="form-label"><?php __('Referencia catastral'); ?>:</label>
                                                  <div class="controls">
                                                      <input type="text" name="referencia_catrastal_prop" id="referencia_catrastal_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_catrastal_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                      <?php echo $tNGs->displayFieldError("properties_properties", "referencia_catrastal_prop"); ?>
                                                  </div>
                                              </div>

                                          </div>

                                        </div>

                                        <div class="form-check form-switch form-switch-md mb-4" dir="ltr">
                                            <input type="checkbox" name="cartel_prop" id="cartel_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['cartel_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['cartel_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="cartel_prop"><?php __('Cartel'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "cartel_prop"); ?>
                                        </div>

                                        <div class="form-check form-switch form-switch-md mb-4" dir="ltr">
                                            <input type="checkbox" name="cita_prop" id="cita_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['cita_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['cita_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="cita_prop"><?php __('Solicitar cita'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "cita_prop"); ?>
                                        </div>

                                        <div class="form-check form-switch form-switch-md mb-4" dir="ltr">
                                            <input type="checkbox" name="viewing_arrange_prop" id="viewing_arrange_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['viewing_arrange_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['viewing_arrange_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="viewing_arrange_prop"><?php __('Viewing arrange'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "viewing_arrange_prop"); ?>
                                        </div>

                                        <div class="form-check form-switch form-switch-md mb-4" dir="ltr">
                                            <input type="checkbox" name="applicant_interested_no_meeting_prop" id="applicant_interested_no_meeting_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['applicant_interested_no_meeting_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['applicant_interested_no_meeting_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="applicant_interested_no_meeting_prop"><?php __('Applicant interested no meeting'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "applicant_interested_no_meeting_prop"); ?>
                                        </div>

                                        <div class="form-check form-switch form-switch-md mb-4" dir="ltr">
                                            <input type="checkbox" name="sale_in_progress_prop" id="sale_in_progress_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['sale_in_progress_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['sale_in_progress_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="sale_in_progress_prop"><?php __('Sale in progress'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "sale_in_progress_prop"); ?>
                                        </div>

                                        <div class="form-check form-switch form-switch-md mb-4" dir="ltr">
                                            <input type="checkbox" name="show_house_prop" id="show_house_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['show_house_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['show_house_prop']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="show_house_prop"><?php __('House Available to View'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "show_house_prop"); ?>
                                        </div>

                                        <div class="card">

                                            <div class="card-body bg-light">

                                                <div class="checkbox">
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input type="checkbox" name="llaves_prop" id="llaves_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['llaves_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['llaves_prop']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="llaves_prop"><?php __('Laves'); ?></label>
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "llaves_prop"); ?>
                                                    </div>
                                                </div>

                                                <div id="llavestxt" <?php if($row_rsproperties_properties['llaves_prop'] != '1') { ?>style="display: none"<?php } ?>>

                                                    <div class="mt-4 <?php if($tNGs->displayFieldError("properties_properties", "alcayata_prop") != '') { ?>error<?php } ?>">
                                                        <label for="alcayata_prop" class="form-label"><?php __('Alcayata'); ?>:</label>
                                                        <input type="text" name="alcayata_prop" id="alcayata_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['alcayata_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "alcayata_prop"); ?>
                                                    </div>

                                                      <div class="mt-4 <?php if($tNGs->displayFieldError("properties_properties", "llave_txt_prop") != '') { ?>error<?php } ?>">
                                                          <label for="llave_txt_prop" class="form-label"><?php __('Texto'); ?>:</label>
                                                          <input type="text" name="llave_txt_prop" id="llave_txt_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['llave_txt_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_properties", "llave_txt_prop"); ?>
                                                      </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="card">

                                            <div class="card-body bg-light">

                                                <div class="checkbox">
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input type="checkbox" name="keyholder_prop" id="keyholder_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['keyholder_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['keyholder_prop']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="keyholder_prop"><?php __('Solicitar llave'); ?></label>
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "keyholder_prop"); ?>
                                                    </div>
                                                </div>

                                                <div id="keytxt" <?php if($row_rsproperties_properties['keyholder_prop'] != '1') { ?>style="display: none"<?php } ?>>

                                                    <div class="mt-4 <?php if($tNGs->displayFieldError("properties_properties", "keyholder_name_prop") != '') { ?>error<?php } ?>">
                                                        <label for="keyholder_name_prop" class="form-label"><?php __('Nombre'); ?>:</label>
                                                        <input type="text" name="keyholder_name_prop" id="keyholder_name_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['keyholder_name_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "keyholder_name_prop"); ?>
                                                    </div>

                                                      <div class="mt-4 <?php if($tNGs->displayFieldError("properties_properties", "keyholder_tel_prop") != '') { ?>error<?php } ?>">
                                                          <label for="keyholder_tel_prop" class="form-label"><?php __('Teléfono'); ?>:</label>
                                                          <input type="text" name="keyholder_tel_prop" id="keyholder_tel_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['keyholder_tel_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_properties", "keyholder_tel_prop"); ?>
                                                      </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="card">

                                            <div class="card-body bg-light">

                                                <div class="checkbox">
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input type="checkbox" name="alarm_prop" id="alarm_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['alarm_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['alarm_prop']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="alarm_prop"><?php __('Alarma'); ?></label>
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "alarm_prop"); ?>
                                                    </div>
                                                </div>

                                                <div id="alarmtxt" <?php if($row_rsproperties_properties['alarm_prop'] != '1') { ?>style="display: none"<?php } ?>>

                                                    <div class="mt-4 <?php if($tNGs->displayFieldError("properties_properties", "alarm_code_prop") != '') { ?>error<?php } ?>">
                                                        <label for="alarm_code_prop" class="form-label"><?php __('Código Alarma'); ?>:</label>
                                                        <input type="text" name="alarm_code_prop" id="alarm_code_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['alarm_code_prop']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "alarm_code_prop"); ?>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                 </div>

                                 <legend class="border-bottom"><?php __('Imágenes privadas'); ?></legend>

                                 <?php if ($actImagesPriv == 1) { ?>

                                 <small><i class="fa-regular fa-image fa-fw"></i>
                                     <?php __('Extensiones permitidas'); ?>: jpg, gif
                                     <?php __('y'); ?> png.</small>
                                 <hr>
                                 <div id="img-order-loadingp"></div>
                                 <ul class="thumbnails clearfix" id="images-listp">
                                     <?php if($totalRows_rsImagesp > 0) { ?>
                                     <?php do { ?>
                                     <?php if($row_rsImagesp['image_img'] != '') { ?>
                                     <li class="pull-left" id="order_<?php echo $row_rsImagesp['id_img'] ?>" data-id="<?php echo $row_rsImagesp['id_img'] ?>">
                                         <div class="img-thumbnail pull-left">
                                             <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/propertiesprv/thumbnails/'.$row_rsImagesp['id_img'].'_sm.jpg')) { ?>
                                             <a href="/media/images/propertiesprv/thumbnails/<?php echo $row_rsImagesp['id_img'] ?>_lg.jpg" data-toggle="lightbox"><img src="/media/images/propertiesprv/thumbnails/<?php echo $row_rsImagesp['id_img'] ?>_sm.jpg" alt="" style="width: 150px;"></a>
                                             <?php } else { ?>
                                             <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="width: 150px;">
                                             <?php } ?>
                                             <div class="text-center mt-2 mb-1">
                                                 <a href="images_delp.php" data-id="<?php echo $row_rsImagesp['id_img'] ?>" class="btn btn-danger btn-sm del-img"><i class="fa-regular fa-trash-can"></i></a>
                                             </div>
                                         </div>
                                     </li>
                                     <?php } ?>
                                     <?php } while ($row_rsImagesp = mysqli_fetch_assoc($rsImagesp)); ?>
                                     <?php } ?>
                                 </ul>
                                 <?php /* ?>
                                 <hr>
                                 <a href="#" class="btn btn-danger btn-sm delimgsvarp"><i class="fa-regular fa-trash-can me-1"></i>
                                     <?php __('Delete selected images'); ?></a>
                                 <a href="#" class="btn btn-danger btn-sm delallimgsvarp"><i class="fa-regular fa-trash-can me-1"></i>
                                     <?php __('Delete all images'); ?></a>
                                 <div class="float-end">
                                     <a href="#" class="btn btn-success btn-sm downloadimgsvarp"><i class="fa-regular fa-download me-1"></i>
                                         <?php __('Download selected images'); ?></a>
                                     <a href="#" class="btn btn-success btn-sm downloadallimgsvarp"><i class="fa-regular fa-download me-1"></i>
                                         <?php __('Download all images'); ?></a>
                                 </div>
                                 <?php */ ?>
                                 <hr style="clear: both">
                                 <div class="multi_imagesp"></div>

                                 <?php } ?>

                                 <legend class="border-bottom mt-4"><?php __('Localización privada'); ?></legend>

                                 <div class="row">

                                     <div class="col-md-5">

                                         <div class="pb-md-4 <?php if($tNGs->displayFieldError("properties_properties", "direccion_gp_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="google_maps_pri">&nbsp;&nbsp;</label>
                                            <a href="https://www.google.es/maps" id="google_maps_pri" target="_blank" class="btn btn-info w-100"><i class="fa-regular fa-map-location-dot"></i> <?php __('Ir a Google Maps'); ?></a>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "direccion_gp_prop"); ?>
                                        </div>

                                     </div> <!--/.col-md-7 -->

                                     <div class="col-md-4">

                                         <div class="pb-md-4 <?php if($tNGs->displayFieldError("properties_properties", "lat_long_gpp_prop") != '') { ?>has-error<?php } ?>">
                                             <label for="lat_long_gpp_prop"><?php __('Latitud y longitud'); ?>:</label>
                                             <div class="input-group">
                                                 <input type="text" name="lat_long_gpp_prop" id="lat_long_gpp_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['lat_long_gpp_prop']); ?>" size="32" maxlength="255" class="form-control comp_lat_lngp" >
                                                 <button class="btn btn-primary btn-copy-latlong" type="button" onclick="copyToClipboard('#lat_long_gpp_prop')"><i class="fa-regular fa-clipboard"></i></button>
                                             </div>
                                             <?php echo $tNGs->displayFieldError("properties_properties", "lat_long_gpp_prop"); ?>
                                         </div>

                                     </div> <!--/.col-md-3 -->

                                     <div class="col-md-3">

                                         <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "zoom_gpp_prop") != '') { ?>has-error<?php } ?>">
                                             <label for="zoom_gpp_prop"><?php __('Zoom'); ?>:</label>
                                             <input type="text" name="zoom_gpp_prop" id="zoom_gpp_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['zoom_gpp_prop']); ?>" size="32" maxlength="255" class="form-control zoom_gpp_prop">
                                             <?php echo $tNGs->displayFieldError("properties_properties", "zoom_gpp_prop"); ?>
                                         </div>

                                     </div> <!--/.col-md-2 -->

                                 </div> <!--/.row -->

                                 <legend class="border-bottom"><?php __('Archivos'); ?></legend>

                                 <small><i class="fa-regular fa-file fa-fw"></i> <?php __('Extensiones permitidas'); ?>: rar, txt, zip, doc, pdf, csv, xls, rtf, sxw, odt, docx, xlsx, ppt <?php __('y'); ?> mov.</small>
                                 <br>
                                 <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de los archivos, arrastre y suelte el archivo en la ubicación deseada'); ?>.</small>

                                 <hr>

                                 <div id="file-order-loading2"></div>
                                 <ul class="thumbnails nested-sortable-file-" id="file-list2">
                                     <?php if($totalRows_rsFiles2 > 0) { ?>
                                     <?php do { ?>
                                         <?php if (preg_match('/https?:/', $row_rsFiles2['file_fil'])): ?>
                                           <li class="pull-left" id="order_<?php echo $row_rsFiles2['id_fil'] ?>" data-id="<?php echo $row_rsFiles2['id_fil'] ?>">
                                               <div class="img-thumbnail pull-left">
                                                   <a href="<?php echo $row_rsFiles2['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br>
                                                       <small>
                                                         <?php
                                                             $name = basename($row_rsFiles2['file_fil']);
                                                             $name = explode('-', $name);
                                                             echo __(preg_replace("/\.[^.]+$/", "", $name[0]));
                                                         ?>
                                                       </small>
                                                   </a>
                                                   <p class="text-center">
                                                   <!-- <a href="/intramedianet/properties/files_del.php" data-id="<?php echo $row_rsFiles2['id_fil'] ?>" class="btn btn-danger btn-sm del-fil2"><i class="fa-regular fa-trash-can"></i></a> -->
                                                   </p>
                                               </div>
                                           </li>
                                         <?php else: ?>
                                           <li class="pull-left" id="order_<?php echo $row_rsFiles2['id_fil'] ?>" data-id="<?php echo $row_rsFiles2['id_fil'] ?>">
                                               <div class="img-thumbnail pull-left">
                                                   <a href="/media/files/properties/<?php echo $row_rsFiles2['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br><small><?php echo $row_rsFiles2['file_fil']; ?></small></a>
                                                   <p class="text-center">
                                                   <a href="#" class="btn btn-success btn-sm edit-name" data-id="<?php echo $row_rsFiles2['id_fil'] ?>"><i class="fa-regular fa-pencil"></i></a>
                                                   <a href="#" class="btn btn-info btn-sm edit-lang" data-id="<?php echo $row_rsFiles2['id_fil'] ?>"><i class="fa-regular fa-language"></i></a>
                                                   <a href="/intramedianet/properties/files_del.php" data-id="<?php echo $row_rsFiles2['id_fil'] ?>" class="btn btn-danger btn-sm del-fil2"><i class="fa-regular fa-trash-can"></i></a>
                                                   </p>
                                               </div>
                                           </li>
                                         <?php endif ?>
                                         <?php } while ($row_rsFiles2 = mysqli_fetch_assoc($rsFiles2)); ?>
                                     <?php } ?>
                                 </ul>
                                 <hr>
                                 <div class="multi_files2"></div>

                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                    </div>
                    <div class="tab-pane" id="tabcruce" role="tabpanel">

                        <?php if($_SESSION['kt_login_level'] == 9) { ?>
                            <?php if ($actClients == 1) { ?>
                                <div class="card position-relative">
                                    <div class="card-header align-items-center d-flex">
                                        <div class="flex-grow-1 oveflow-hidden">
                                            <h4 class="card-title mb-0 flex-grow-1"><?php __('Clientes interesados'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <button type="button" id="interesados-tab" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-arrows-rotate me-1"></i> <?php __('Recargar'); ?></button>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="alert bg-light py-2" role="alert">

                                            <?php __('Enviar propiedades a clientes que tengan el'); ?>

                                            <select name="porcen" id="porcen" class="form-select form-select-sm d-inline-block" style="width: 80px;">
                                            <?php for ($i=40; $i <= 100; $i += 10) {  ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?>%</option>
                                            <?php } ?>
                                            </select>

                                            <?php __('o más'); ?>

                                            <a href="javascript:void(0);" class="btn btn-success btn-sm" id="interesados-send-50"><i class="fa-regular fa-paper-plane me-1"></i> <?php __('Enviar'); ?></a>

                                        </div>

                                        <div id="interesados-content"></div>

                                    </div><!-- end card-body -->
                                </div>
                            <?php } ?>
                        <?php } ?>

                    </div>
                    <div class="tab-pane" id="tabportales" role="tabpanel">


                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Portalesx'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                                    <i class="fa-regular fa-circle-info label-icon"></i> <?php echo $lang['Si desea exportar a otros portales, contacte con nosotros'] ?>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expKyero == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_kyero_prop" id="export_kyero_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_kyero_prop']),"1"))) {echo "checked";} ?> <?php if ($expKyero == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_kyero_prop"><?php __('Exportar a Kyero'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_kyero_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expMediaelx == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_mediaelx_prop" id="export_mediaelx_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_mediaelx_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_mediaelx_prop']),"1"))) {echo "checked";} ?> <?php if ($expMediaelx == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_mediaelx_prop"><?php __('Exportar a Mediaelx'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_mediaelx_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expFacebook == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_facebook_prop" id="export_facebook_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_facebook_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_facebook_prop']),"1"))) {echo "checked";} ?> <?php if ($expFacebook == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_facebook_prop"><?php __('Exportar a Facebook'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_facebook_prop"); ?>
                                        </div>
                                        <hr>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expThinkSpain == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_thinkspain_prop" id="export_thinkspain_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_thinkspain_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_thinkspain_prop']),"1"))) {echo "checked";} ?> <?php if ($expThinkSpain == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_thinkspain_prop"><?php __('Exportar a Think Spain'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_thinkspain_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expHemnet == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_hemnet_prop" id="export_hemnet_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_hemnet_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_hemnet_prop']),"1"))) {echo "checked";} ?> <?php if ($expHemnet == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_hemnet_prop"><?php __('Exportar a Hemnet'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_hemnet_prop"); ?>
                                        </div>
                                        <hr>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expGreenAcres == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_green_prop" id="export_green_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_green_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_green_prop']),"1"))) {echo "checked";} ?> <?php if ($expGreenAcres == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_green_prop"><?php __('Exportar a Green Acres'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_green_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expHabitaclia == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_habitaclia_prop" id="export_habitaclia_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_habitaclia_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_habitaclia_prop']),"1"))) {echo "checked";} ?> <?php if ($expHabitaclia == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_habitaclia_prop"><?php __('Exportar a Habitaclia'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_habitaclia_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expPisos == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_pisos_prop" id="export_pisos_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_pisos_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_pisos_prop']),"1"))) {echo "checked";} ?> <?php if ($expPisos == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_pisos_prop"><?php __('Exportar a Pisos.com'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_pisos_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expTodoPisoAlicante == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_todopisoalicante_prop" id="export_todopisoalicante_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_todopisoalicante_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_todopisoalicante_prop']),"1"))) {echo "checked";} ?> <?php if ($expTodoPisoAlicante == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_todopisoalicante_prop"><?php __('Exportar a Todo Piso Alicante'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_todopisoalicante_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expAPITS == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="expport_APITS_prop" id="expport_APITS_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['expport_APITS_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['expport_APITS_prop']),"1"))) {echo "checked";} ?> <?php if ($expAPITS == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="expport_APITS_prop"><?php __('Exportar a A Place in the Sun'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "expport_APITS_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expCostadelHome == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="expport_CostadelHome_prop" id="expport_CostadelHome_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['expport_CostadelHome_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['expport_CostadelHome_prop']),"1"))) {echo "checked";} ?> <?php if ($expCostadelHome == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="expport_CostadelHome_prop"><?php __('Exportar a Costa del Home'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "expport_CostadelHome_prop"); ?>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expSpainHouses == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="expport_SpainHomes_prop" id="expport_SpainHomes_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['expport_SpainHomes_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['expport_SpainHomes_prop']),"1"))) {echo "checked";} ?> <?php if ($expSpainHouses == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="expport_SpainHomes_prop"><?php __('Exportar a Spain Homes'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "expport_SpainHomes_prop"); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expMLSMediaelx == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_mlsmediaelx_prop" id="export_mlsmediaelx_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_mlsmediaelx_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_mlsmediaelx_prop']),"1"))) {echo "checked";} ?> <?php if ($expMLSMediaelx == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_mlsmediaelx_prop"><?php __('Exportar a MLS Mediaelx'); ?> (<small class="text-muted"><?php __('Es importante rellenar los campos de piscina, parking y localización en mapa'); ?></small>)</label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_mlsmediaelx_prop"); ?>
                                        </div>
                                    </div>

                                </div>

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <div class="col-md-6">
                                    <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expInmoco == 0) { ?>style="opacity: .5;"<?php } ?>>
                                        <input type="checkbox" name="export_inmoco_prop" id="export_inmoco_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_inmoco_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_inmoco_prop']),"1"))) {echo "checked";} ?> <?php if ($expInmoco == 0) { ?>disabled<?php } ?>>
                                        <label class="form-check-label" for="export_inmoco_prop"><?php __('Exportar a Inmoco'); ?> (<small class="text-muted"><?php __('Remember: properties must have a commission field complete.'); ?></small>)</label>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "export_inmoco_prop"); ?>
                                    </div>
                                </div>

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expZoopla == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_zoopla_prop" id="export_zoopla_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_zoopla_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_zoopla_prop']),"1"))) {echo "checked";} ?> <?php if ($expZoopla == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_zoopla_prop"><?php __('Exportar a Zoopla'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_zoopla_prop"); ?>
                                        </div>

                                    </div>

                                </div>

                                <?php if ($expRightmove == 1 || $expZoopla == 1) { ?>
                                <p class="leadx"><?php __('RM1'); ?></p>
                                <p><?php __('RM2'); ?></p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "rightmove_loc_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="rightmove_loc_prop"><?php __('Localización'); ?>:</label>
                                            <div class="controls">
                                                <select name="rightmove_loc_prop" id="rightmove_loc_prop" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php
                                          do {
                                          ?>
                                                    <option value="<?php echo $row_rsRMlocs['id_rml']?>"<?php if (!(strcmp($row_rsRMlocs['id_rml'], $row_rsproperties_properties['rightmove_loc_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsRMlocs['loc1_rml']; ?> &raquo; <?php echo $row_rsRMlocs['loc2_rml']; ?> &raquo; <?php echo $row_rsRMlocs['loc3_rml']; ?> &raquo; <?php echo $row_rsRMlocs['loc4_rml']; ?></option>
                                                    <?php
                                          } while ($row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs));
                                          $rows = mysqli_num_rows($rsRMlocs);
                                          if($rows > 0) {
                                          mysqli_data_seek($rsRMlocs, 0);
                                          $row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs);
                                          }
                                          ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "rightmove_loc_prop"); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "rightmove_tipo_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="rightmove_tipo_prop"><?php __('Tipo'); ?>:</label>
                                            <div class="controls">
                                                <select name="rightmove_tipo_prop" id="rightmove_tipo_prop" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php
                                                    do {
                                                    ?>
                                                    <option value="<?php echo $row_rsRMtipo['id_rmt']?>"<?php if (!(strcmp($row_rsRMtipo['id_rmt'], $row_rsproperties_properties['rightmove_tipo_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsRMtipo['tipo_rmt']?></option>
                                                    <?php
                                                    } while ($row_rsRMtipo = mysqli_fetch_assoc($rsRMtipo));
                                                      $rows = mysqli_num_rows($rsRMtipo);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsRMtipo, 0);
                                                        $row_rsRMtipo = mysqli_fetch_assoc($rsRMtipo);
                                                      }
                                                    ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "rightmove_tipo_prop"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php } ?>

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <!-- Rightmove -->
                                <?php require($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/properties-form-rightmove.php'); ?>

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <!-- Fotocasa -->
                                <?php require($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/properties-form-fotocasa.php'); ?>
                                <!-- END Fotocasa -->

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <!-- Idealista -->
                                <?php require($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/idealista/properties-form-idealista.php'); ?>
                                <!-- END Idealista -->

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <!-- Yaencontre -->
                                <?php require($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/yaencontre/properties-form-yaencontre.php'); ?>
                                <!-- END Yaencontre -->

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md mt-4" dir="ltr" <?php if ($expFacilisimo == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_facilisimo_prop" id="export_facilisimo_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_facilisimo_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_facilisimo_prop']),"1"))) {echo "checked";} ?> <?php if ($expFacilisimo == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_facilisimo_prop"><?php __('Exportar a Facilisimo'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_facilisimo_prop"); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "cp_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="cp_prop" class="form-label"><?php __('Reqiere el código postal'); ?> <small>(<?php __('Opcional para Mimove'); ?>)</small>:</label>
                                            <div class="controls">
                                                <input type="text" name="cp_prop" id="cp_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['cp_prop']); ?>" size="32" maxlength="255" class="form-control"><?php echo $tNGs->displayFieldError("properties_properties", "cp_prop"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md mt-4" dir="ltr" <?php if ($expMimove == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_mimove_prop" id="export_mimove_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_mimove_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_mimove_prop']),"1"))) {echo "checked";} ?> <?php if ($expMimove == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_mimove_prop"><?php __('Exportar a Mimove'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_mimove_prop"); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "export_mimove_type_prop") != '') { ?>has-error<?php } ?>" <?php if ($expMimove == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <label for="export_mimove_type_prop" class="form-label"><?php __('Tipo de propiedad'); ?> <small>(<?php __('Requerido para Mimove'); ?>)</small>:</label>
                                            <div class="controls">
                                                <select name="export_mimove_type_prop" id="export_mimove_type_prop" class="form-select" <?php if ($expMimove == 0) { ?>disabled<?php } ?>>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_type_prop']) && !(strcmp("", $row_rsproperties_properties['export_mimove_type_prop']))) {echo "selected=\"selected\"";} ?> value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_type_prop']) && !(strcmp("apartment", $row_rsproperties_properties['export_mimove_type_prop']))) {echo "selected=\"selected\"";} ?> value="apartment"><?php __('Apartment'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_type_prop']) && !(strcmp("finca", $row_rsproperties_properties['export_mimove_type_prop']))) {echo "selected=\"selected\"";} ?> value="finca"><?php __('Finca'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_type_prop']) && !(strcmp("penthouse", $row_rsproperties_properties['export_mimove_type_prop']))) {echo "selected=\"selected\"";} ?> value="penthouse"><?php __('Penthouse'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_type_prop']) && !(strcmp("plot", $row_rsproperties_properties['export_mimove_type_prop']))) {echo "selected=\"selected\"";} ?> value="plot"><?php __('Plot'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_type_prop']) && !(strcmp("townhouse", $row_rsproperties_properties['export_mimove_type_prop']))) {echo "selected=\"selected\"";} ?> value="townhouse"><?php __('Townhouse'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_type_prop']) && !(strcmp("villa", $row_rsproperties_properties['export_mimove_type_prop']))) {echo "selected=\"selected\"";} ?> value="villa"><?php __('Villa'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "export_mimove_parking_prop") != '') { ?>has-error<?php } ?>" <?php if ($expMimove == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <label for="export_mimove_parking_prop" class="form-label"><?php __('Tipo de Garaje'); ?> <small>(<?php __('Opcional para Mimove'); ?>)</small>:</label>
                                            <div class="controls">
                                                <select name="export_mimove_parking_prop" id="export_mimove_parking_prop" class="form-select" <?php if ($expMimove == 0) { ?>disabled<?php } ?>>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_parking_prop']) && !(strcmp("", $row_rsproperties_properties['export_mimove_parking_prop']))) {echo "selected=\"selected\"";} ?> value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_parking_prop']) && !(strcmp("garage", $row_rsproperties_properties['export_mimove_parking_prop']))) {echo "selected=\"selected\"";} ?> value="garage"><?php __('Garage'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_parking_prop']) && !(strcmp("street", $row_rsproperties_properties['export_mimove_parking_prop']))) {echo "selected=\"selected\"";} ?> value="street"><?php __('Street'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_parking_prop']) && !(strcmp("carport", $row_rsproperties_properties['export_mimove_parking_prop']))) {echo "selected=\"selected\"";} ?> value="carport"><?php __('Carport'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_parking_prop']) && !(strcmp("private_land", $row_rsproperties_properties['export_mimove_parking_prop']))) {echo "selected=\"selected\"";} ?> value="private_land"><?php __('Private Land'); ?></option>
                                                    <option <?php if (isset($row_rsproperties_properties['export_mimove_parking_prop']) && !(strcmp("community_parking", $row_rsproperties_properties['export_mimove_parking_prop']))) {echo "selected=\"selected\"";} ?> value="community_parking"><?php __('Community Parking'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-check form-switch form-switch-md mt-4" dir="ltr" <?php if ($expUbiflow == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_ubiflow_prop" id="export_ubiflow_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_ubiflow_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_ubiflow_prop']),"1"))) {echo "checked";} ?> <?php if ($expUbiflow == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_ubiflow_prop"><?php __('Exportar a Ubiflow'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_ubiflow_prop"); ?>
                                        </div>
                                    </div>

                                    <?php if ($expUbiflow == 1) { ?>
                                    <div class="col-md-6">
                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "ubiflow_type_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="ubiflow_type_prop" class="form-label">Ubiflow <?php __('Tipo'); ?>:</label>
                                            <div class="controls">
                                                <select name="ubiflow_type_prop" id="ubiflow_type_prop" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php
                                          do {
                                          ?>
                                                    <option value="<?php echo $row_rsUFtypes['id_typu']?>"<?php if (!(strcmp($row_rsUFtypes['id_typu'], $row_rsproperties_properties['ubiflow_type_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsUFtypes['type_typu']; ?></option>
                                                    <?php
                                          } while ($row_rsUFtypes = mysqli_fetch_assoc($rsUFtypes));
                                          $rows = mysqli_num_rows($rsUFtypes);
                                          if($rows > 0) {
                                          mysqli_data_seek($rsUFtypes, 0);
                                          $row_rsUFtypes = mysqli_fetch_assoc($rsUFtypes);
                                          }
                                          ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "ubiflow_type_prop"); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>

                                <hr style="border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;">

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-check form-switch form-switch-md mt-4" dir="ltr" <?php if ($expPrian == 0) { ?>style="opacity: .5;"<?php } ?>>
                                            <input type="checkbox" name="export_prian_prop" id="export_prian_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_prian_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_prian_prop']),"1"))) {echo "checked";} ?> <?php if ($expPrian == 0) { ?>disabled<?php } ?>>
                                            <label class="form-check-label" for="export_prian_prop"><?php __('Exportar a Prian'); ?></label>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "export_prian_prop"); ?>
                                        </div>
                                        <?php if ($expPrian == 1) { ?><hr><?php } ?>
                                    </div>

                                    <?php if ($expPrian == 1) { ?>

                                    <div class="col-md-3">

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "prian_tipo_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="prian_tipo_prop" class="form-label"><?php __('Tipo'); ?>:</label>
                                            <div class="controls">
                                                <select name="prian_tipo_prop" id="prian_tipo_prop" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsPrianTipos['id_typ']?>"<?php if (!(strcmp($row_rsPrianTipos['id_typ'], $row_rsproperties_properties['prian_tipo_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsPrianTipos['type_typ']; ?></option>
                                                    <?php
                                          } while ($row_rsPrianTipos = mysqli_fetch_assoc($rsPrianTipos));
                                          $rows = mysqli_num_rows($rsPrianTipos);
                                          if($rows > 0) {
                                          mysqli_data_seek($rsPrianTipos, 0);
                                          $row_rsPrianTipos = mysqli_fetch_assoc($rsPrianTipos);
                                          }
                                          ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "prian_tipo_prop"); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "prian_pais_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="prian_pais_prop" class="form-label"><?php __('País'); ?>:</label>
                                            <div class="controls">
                                                <select name="prian_pais_prop" id="prian_pais_prop" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsPrianPaises['id_ps']?>"<?php if (!(strcmp($row_rsPrianPaises['id_ps'], $row_rsproperties_properties['prian_pais_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsPrianPaises['nombre_ps']; ?></option>
                                                    <?php
                                          } while ($row_rsPrianPaises = mysqli_fetch_assoc($rsPrianPaises));
                                          $rows = mysqli_num_rows($rsPrianPaises);
                                          if($rows > 0) {
                                          mysqli_data_seek($rsPrianPaises, 0);
                                          $row_rsPrianPaises = mysqli_fetch_assoc($rsPrianPaises);
                                          }
                                          ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "prian_pais_prop"); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "prian_region_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="prian_region_prop" class="form-label"><?php __('Provincia'); ?>:</label>
                                            <div class="controls">
                                                <select name="prian_region_prop" id="prian_region_prop" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsPrianRegions['id_rgn']?>"<?php if (!(strcmp($row_rsPrianRegions['id_rgn'], $row_rsproperties_properties['prian_region_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsPrianRegions['nombre_rgn']; ?></option>
                                                    <?php
                                          } while ($row_rsPrianRegions = mysqli_fetch_assoc($rsPrianRegions));
                                          $rows = mysqli_num_rows($rsPrianRegions);
                                          if($rows > 0) {
                                          mysqli_data_seek($rsPrianRegions, 0);
                                          $row_rsPrianRegions = mysqli_fetch_assoc($rsPrianRegions);
                                          }
                                          ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "prian_region_prop"); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_properties", "prian_ciudad_prop") != '') { ?>has-error<?php } ?>">
                                            <label for="prian_ciudad_prop" class="form-label"><?php __('Ciudad'); ?>:</label>
                                            <div class="controls">
                                                <select name="prian_ciudad_prop" id="prian_ciudad_prop" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsPrianCities['id_cts']?>"<?php if (!(strcmp($row_rsPrianCities['id_cts'], $row_rsproperties_properties['prian_ciudad_prop']))) {echo "SELECTED";} ?>><?php echo $row_rsPrianCities['nombre_cts']; ?></option>
                                                    <?php
                                          } while ($row_rsPrianCities = mysqli_fetch_assoc($rsPrianCities));
                                          $rows = mysqli_num_rows($rsPrianCities);
                                          if($rows > 0) {
                                          mysqli_data_seek($rsPrianCities, 0);
                                          $row_rsPrianCities = mysqli_fetch_assoc($rsPrianCities);
                                          }
                                          ?>
                                                </select>
                                                <?php echo $tNGs->displayFieldError("properties_properties", "prian_ciudad_prop"); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <?php } ?>

                                </div>

                            </div><!-- end card-body -->
                        </div>


                    </div>
                    <div class="tab-pane" id="tabrental" role="tabpanel">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Precios mensuales'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                <?php for ($i=1; $i <= 12; $i++) { ?>

                                <?php $mes = array('', __("Enero", true), __("Febrero", true), __("Marzo", true), __("Abril", true), __("Mayo", true), __("Junio", true), __("Julio", true), __("Agosto", true), __("Septiembre", true), __("Octubre", true), __("Noviembre", true), __("Diciembre", true),); ?>

                                <div class="col-md-3">

                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "precio_".$i."_prop") != '') { ?>has-error<?php } ?>">
                                        <label for="precio_<?php echo $i; ?>_prop" class="form-label"><?php echo $mes[$i] ?>:</label>
                                        <div class="input-group">
                                            <input type="text" name="precio_<?php echo $i; ?>_prop" id="precio_<?php echo $i; ?>_prop" value="<?php echo KT_escapeAttribute($row_rsproperties_properties['precio_'.$i.'_prop']); ?>" size="32" maxlength="255" class="form-control">
                                            <span class="input-group-text">€</span>
                                        </div>
                                        <?php echo $tNGs->displayFieldError("properties_properties", "precio_".$i."_prop"); ?>
                                    </div>

                                  </div>

                                  <?php echo ($i%4 == 0)?'</div><div class="row">':''; ?>

                                <?php } ?>
                                </div>
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                                    <i class="fa-regular fa-circle-info label-icon"></i> <?php echo $lang['Sin puntos ni comas 1.000 = 1000 | 0 = Consultar'] ?>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Precios por días'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="from_prc" class="form-label"><?php __('Fecha inicio'); ?>:</label>
                                            <input type="text" name="from_prc" id="from_prc" value="" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="to_prc" class="form-label"><?php __('Fecha final'); ?>:</label>
                                            <input type="text" name="to_prc" id="to_prc" value="" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price_prc" class="form-label"><?php __('Precio'); ?>:</label>
                                            <input type="text" name="price_prc" id="price_prc" value="" size="32" maxlength="255" class="form-control">
                                        </div>
                                        <small class="text-muted"><?php __('Sin puntos ni comas 1.000 = 1000 | 0 = Consultar'); ?></small>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <br>
                                            <input type="hidden" id="prcid" name="prcid">
                                            <button type="button" id="addBtn" class="btn btn-success"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></button>
                                            <button type="button" id="updBtn" class="btn btn-success" style="display: none;"><i class="fa-regular fa-pencil me-1"></i> <?php __('Actualizar'); ?></button>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div id="precios-tbl"></div>

                            </div><!-- end card-body -->
                        </div>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Disponibilidad'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-9">

                                        <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                                            <i class="fa-regular fa-circle-info label-icon"></i> <?php echo $lang['Pulse sobre las reservas para elimiarlas'] ?>
                                        </div>

                                        <div id="calendar"></div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="well well-sm clearfix">

                                            <div class="mb-4">
                                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                                    <input type="checkbox" name="privado_disp" id="privado_disp" value="1" class="form-check-input">
                                                    <label class="form-check-label" for="privado_disp"><?php __('Privado'); ?></label>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="inicio" class="form-label"><?php __('Fecha entrada'); ?></label>
                                                <input type="text" class="form-control" id="inicio" name="inicio" data-provider="flatpickr" data-date-format="d-m-Y">
                                            </div>

                                            <div class="mb-4">
                                                <label for="final" class="form-label"><?php __('Fecha salida'); ?></label>
                                                <input type="text" class="form-control" id="final" name="final" data-provider="flatpickr" data-date-format="d-m-Y">
                                            </div>

                                            <a href="#" class="btn btn-success pull-right w-100" id="addDisp" data-prop="<?php echo $property_id; ?>"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>

                                        </div>

                                    </div>

                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                    <div class="tab-pane" id="tabinfo" role="tabpanel">

                        <?php if ($totalRows_rsTasks > 0 && $actTasks == 1) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Tareas'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle records-tables-simple4" id="tasks-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th><?php __('Propietario de la tarea'); ?></th>
                                                <th><?php __('Asunto'); ?></th>
                                                <th><?php __('Propiedad'); ?></th>
                                                <th><?php __('Fecha de vencimiento'); ?></th>
                                                <th><?php __('Prioridad'); ?></th>
                                                <th><?php __('Status'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php do { ?>
                                            <tr>
                                                <td><?php echo $row_rsTasks['admin_tsk']; ?></td>
                                                <td><?php echo $row_rsTasks['subject_tsk']; ?></td>
                                                <td><?php echo addRefs($row_rsTasks['property_tsk']); ?></td>
                                                <td data-sort="<?php echo $row_rsTasks['date_due_tsk'] ?>"><?php echo date("d-m-Y", strtotime($row_rsTasks['date_due_tsk'])); ?></td>
                                                <td><?php __($row_rsTasks['priority_tsk']); ?></td>
                                                <td><?php echo $row_rsTasks['status_tsk']; ?></td>
                                            </tr>
                                            <?php } while ($row_rsTasks = mysqli_fetch_assoc($rsTasks)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                        <?php if ($totalRows_rsEvents > 0 && $actCalendar == 1) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Calendario'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle records-tables-simple5" id="events-tables">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Título'); ?></th>
                                          <th><?php __('Categoría'); ?></th>
                                          <th><?php __('Fecha inicio'); ?></th>
                                          <th><?php __('Fecha final'); ?></th>
                                          <th><?php __('Propiedades'); ?></th>
                                          <th><?php __('Administrador'); ?></th>
                                          <th><?php __('Lugar'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php do { ?>
                                          <tr>
                                            <td><?php echo $row_rsEvents['titulo_ct']; ?></td>
                                            <td><span class="badge bg-primary" style="background: <?php echo $row_rsEvents['color_ct']; ?>;"><?php echo $row_rsEvents['cat']; ?></span></td>
                                            <td data-sort="<?php echo $row_rsEvents['inicio_ct'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEvents['inicio_ct'])); ?></td>
                                            <td data-sort="<?php echo $row_rsEvents['final_ct'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEvents['final_ct'])); ?></td>
                                            <td><?php echo addRefs($row_rsEvents['property_ct']); ?></td>
                                            <td><?php echo $row_rsEvents['nombre_usr']; ?></td>
                                            <td><?php echo $row_rsEvents['lugar_ct']; ?></td>
                                          </tr>
                                          <?php } while ($row_rsEvents = mysqli_fetch_assoc($rsEvents)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                        <?php if ($totalRows_rsVisitas > 0) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Visitas'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle records-tables-simple4" id="visits-tables">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Cliente'); ?></th>
                                          <th style="width: 50px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php do { ?>
                                          <tr>
                                            <td><?php echo $row_rsVisitas['nombre_cli']; ?> <?php echo $row_rsVisitas['apellidos_cli']; ?></td>
                                            <td class="actions">
                                                <a href="clients-form.php?id_cli=<?php echo $row_rsVisitas['id_cli']; ?>&amp;KT_back=1" target="_blank" class="btn btn-success btn-sm"><i class="fa-regular fa-pencil"></i></a>
                                            </td>
                                          </tr>
                                          <?php } while ($row_rsVisitas = mysqli_fetch_assoc($rsVisitas)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                        <?php if ($actBajadaPrecios == 1) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Bajada Precios'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php if($totalRows_rsBajadas > 0) { ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle records-tables-simple" id="bajadas-tables">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Nombre'); ?></th>
                                          <th><?php __('Email'); ?></th>
                                          <th><?php __('Teléfono'); ?></th>
                                          <th><?php __('Añadido'); ?></th>
                                          <th class="actions">&nbsp;</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                      <?php do { ?>
                                      <tr id="<?php echo $row_rsBajadas['id_baj']; ?>">
                                        <td><?php echo $row_rsBajadas['name_baj']; ?></td>
                                        <td><?php echo $row_rsBajadas['email_baj']; ?></td>
                                        <td><?php echo $row_rsBajadas['phone_baj']; ?></td>
                                        <td data-sort="<?php echo $row_rsBajadas['date_baj'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsBajadas['date_baj'])); ?></td>
                                        <td class="text-nowrap">
                                            <a href="/intramedianet/properties/del-bajada.php?id=<?php echo $row_rsBajadas['id_baj']; ?>" class="btn btn-danger btn-sm del-bajada"><i class="fa-regular fa-trash-can me-1"></i> <?php echo NXT_getResource("Delete_FB"); ?></a>
                                            <?php if (clientexits($row_rsBajadas['email_baj']) == false) { ?>
                                                <a href="/intramedianet/properties/add-client-bajada.php?id=<?php echo $row_rsBajadas['id_baj']; ?>&r=<?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?>" class="btn btn-success btn-sm" target="_blank"><i class="fa-regular fa-user-plus me-1"></i> <?php __('Convertir en cliente'); ?></a>
                                            <?php } else { ?>
                                                <a href="/intramedianet/properties/clients-form.php?id_cli=<?php echo clientexits($row_rsBajadas['email_baj']) ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa-regular fa-eye me-1"></i> <?php __('Ver cliente'); ?></a>
                                            <?php } ?>
                                        </td>
                                      </tr>
                                      <?php } while ($row_rsBajadas = mysqli_fetch_assoc($rsBajadas)); ?>

                                      </tbody>
                                    </table>
                                </div>

                                <?php } else { ?>

                                <p class="lead"><?php __('Actualmente no hay interesados que mostrar'); ?>.</p>

                                <?php } ?>

                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                        <?php if ($totalRows_rsEmails > 0) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Envío de emails'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle records-tables-simple2" id="emails-tables">
                                      <thead class="table-light">
                                          <tr>
                                            <th><?php __('Administrador'); ?></th>
                                            <th><?php __('Cliente'); ?></th>
                                            <th><?php __('Dónde'); ?></th>
                                            <th><?php __('Estado'); ?></th>
                                            <th style="width: 150px;"><?php __('Enviado'); ?></th>
                                            <th style="width: 140px;"></th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php do { ?>
                                            <tr>
                                              <td><?php echo $row_rsEmails['usr_log']; ?></td>
                                              <td><?php echo $row_rsEmails['email_log']; ?></td>
                                              <td><?php
                                              switch ($row_rsEmails['type_log']) {
                                                case '1':
                                                  echo __('Ficha clientes');
                                                  break;
                                                case '2':
                                                  echo __('Búsqueda de inmuebles');
                                                  break;
                                                case '3':
                                                  echo __('Bajada de precio');
                                                  break;
                                                case '4':
                                                  echo __('Clientes interesados');
                                                  break;
                                                case '5':
                                                  echo __('Lista de correo');
                                                  break;
                                                case '6':
                                                  echo __('Clientes interesados');
                                                  break;
                                              }
                                              ?></td>
                                              <td><?php
                                              switch ($row_rsEmails['result_log']) {
                                                case 'delivered':
                                                  echo '<span class="badge text-bg-secondary text-uppercase fs-6">' . $lang['delivered'] . '</span>';
                                                  break;
                                                case 'opens':
                                                  echo '<span class="badge text-bg-success text-uppercase fs-6">' . $lang['opens'] . '</span>';
                                                  break;
                                                case 'clicks':
                                                  echo '<span class="badge text-bg-secondary text-uppercase fs-6">' . $lang['clicks'] . '</span>';
                                                  break;
                                                case 'hard_bounces':
                                                  echo '<span class="badge text-bg-danger text-uppercase fs-6">' . $lang['hard_bounces'] . '</span>';
                                                  break;
                                                case 'soft_bounces':
                                                  echo '<span class="badge text-bg-warning text-uppercase fs-6">' . $lang['soft_bounces'] . '</span>';
                                                  break;
                                                case 'complaints':
                                                  echo '<span class="badge text-bg-danger text-uppercase fs-6">' . $lang['complaints'] . '</span>';
                                                  break;
                                                default:
                                                  echo '-';
                                                  break;
                                              }
                                              ?></td>
                                              <td data-sort="<?php echo $row_rsEmails['date_log'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEmails['date_log'])); ?></td>
                                              <td class="text-nowrap"><a href="" class="btn btn-primary btn-sm view-mail-cont" data-id="<?php echo $row_rsEmails['id_log']; ?>"><i class="fa-regular fa-eye me-1"></i> <?php __('View message'); ?></a></td>
                                            </tr>
                                            <?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails)); ?>
                                          </tbody>
                                      </table>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                        <?php if ($totalRows_rsHistorial > 0) { ?>

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Historial'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle records-tables-simple3" id="history-table">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Usuario'); ?></th>
                                          <th><?php __('Acción'); ?></th>
                                          <th style="width: 150px;"><?php __('Fecha'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php do { ?>
                                          <tr>
                                            <td><?php echo $row_rsHistorial['nombre_usr']; ?></td>
                                            <td><?php
                                            switch ($row_rsHistorial['action_log']) {
                                              case '1':
                                                echo '<span class="badge bg-success">'.__('Añadido', true) . '</span>';
                                                break;
                                              case '2':
                                                echo '<span class="badge bg-info">'.__('Editado', true) . '</span>';
                                                break;
                                              case '3':
                                                echo '<span class="badge bg-warning">'.__('Editado: Bajada de precio', true) . '</span>';
                                                break;
                                              case '4':
                                                echo '<span class="badge bg-warning">'.__('Editado: Subida de precio', true) . '</span>';
                                                break;
                                              case '5':
                                                echo '<span class="badge bg-danger">'.__('Borrado', true) . '</span>';
                                                break;
                                            }
                                            ?></td>
                                            <td data-sort="<?php echo $row_rsHistorial['date_log'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsHistorial['date_log'])); ?></td>
                                          </tr>
                                          <?php } while ($row_rsHistorial = mysqli_fetch_assoc($rsHistorial)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- end card-body -->
                        </div>

                        <?php } ?>

                    </div>
                </div>
                <?php /* ?>
                <?php if ($xmlImport == 1) { ?>
                <div class="row d-none">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Características privadas'); ?>: <?php echo KT_escapeAttribute($row_rsproperties_properties['referencia_prop']); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                <?php
                                    $cnt2 = 0;
                                    if ($totalRows_rsproperties_properties>0) {
                                    $nested_query_rsproperties_features_priv = str_replace("123456789", $row_rsproperties_properties['id_prop'], $query_rsproperties_features_priv);
                                    
                                    $rsproperties_features_priv = mysqli_query($inmoconn, $nested_query_rsproperties_features_priv) or die(mysqli_error());
                                    $row_rsproperties_features_priv = mysqli_fetch_assoc($rsproperties_features_priv);
                                    $totalRows_rsproperties_features_priv = mysqli_num_rows($rsproperties_features_priv);
                                    $nested_sw = false;
                                    if (isset($row_rsproperties_features_priv) && is_array($row_rsproperties_features_priv)) {
                                      do { //Nested repeat
                                    ?>
                                        <div class="col-md-4">

                                            <div class="form-check form-switch form-switch-md my-2" dir="ltr">
                                                <input type="checkbox" name="mtm_<?php echo $row_rsproperties_features_priv['id_feat']; ?>" id="mtm_<?php echo $row_rsproperties_features_priv['id_feat']; ?>" value="1" <?php if ($row_rsproperties_features_priv['property'] != "") {?> checked<?php }?> class="form-check-input">
                                                <label class="form-check-label" for="mtm_<?php echo $row_rsproperties_features_priv['id_feat']; ?>"><?php echo $row_rsproperties_features_priv['feature_'.$lang_adm.'_feat']; ?></label>
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
                                      } while ($row_rsproperties_features_priv = mysqli_fetch_assoc($rsproperties_features_priv)); //Nested move next
                                    }
                                  }
                                ?>

                                </div> <!--/.row -->

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>
                <?php } ?>
                <?php */ ?>

            </div>
        </div>

        <div class="modal fade" id="ChatGPTModal" tabindex="-1" aria-labelledby="ChatGPTModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-solid fa-fw fa-message-captions me-1"></i> <?php __('Generar'); ?></h5>
                        <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info alert-label-icon label-arrow fade show clearfix" role="alert">
                                    <i class="fa-regular fa-circle-info label-icon"></i> <?php echo __('Recuerde salvar el inmueble antes de utitizar ChatGPT'); ?>
                                </div>
                                <div class="alert alert-warning alert-label-icon label-arrow fade show clearfix" role="alert">
                                    <i class="fa-regular fa-circle-exclamation label-icon"></i> <?php echo __('ChatGPTAdv1'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-2 <?php if($tNGs->displayFieldError("properties_properties", "chatgpt_prompt_prop") != '') { ?>has-error<?php } ?>">
                                    <label for="chatgpt_prompt_prop" class="form-label"><?php __('Extra prompt'); ?>:</label>
                                    <textarea name="chatgpt_prompt_prop" id="chatgpt_prompt_prop" cols="50" rows="4" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_properties['chatgpt_prompt_prop']); ?></textarea>
                                    <?php echo $tNGs->displayFieldError("properties_properties", "chatgpt_prompt_prop"); ?>
                                </div>
                            </div>
                            <div class="col-12">

                                <label for="toLng" class="form-label"><?php __('Idioma'); ?>:</label>
                                <select name="toLng" id="toLng" class="form-select required" required>
                                    <!-- <option value=""><?php echo NXT_getResource("Select one..."); ?></option> -->
                                    <?php
                                    if ($lang_adm == 'es') {
                                        $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                    } else {
                                        $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                    }
                                    foreach ($languages as $value) {
                                        echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="col-12 mb-3" id="gentextradios">

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actgpt" type="radio" role="switch" name="gptAction" id="gptAction1" value="titulo__prop" checked>
                                    <label class="form-check-label" for="gptAction1"><?php __('Título'); ?></label>
                                </div>

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actgpt" type="radio" role="switch" name="gptAction" id="gptAction2" value="descripcion__prop">
                                    <label class="form-check-label" for="gptAction2"><?php __('Descripción'); ?></label>
                                </div>

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actgpt" type="radio" role="switch" name="gptAction" id="gptAction5" value="descripcion_xml__prop">
                                    <label class="form-check-label" for="gptAction5"><?php __('Descripción'); ?> XML</label>
                                </div>

                                <?php /* ?>
                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actgpt" type="radio" role="switch" name="gptAction" id="gptAction3" value="title__prop">
                                    <label class="form-check-label" for="gptAction3"><?php __('Meta title'); ?></label>
                                </div>

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actgpt" type="radio" role="switch" name="gptAction" id="gptAction4" value="description__prop">
                                    <label class="form-check-label" for="gptAction4"><?php __('Meta description'); ?></label>
                                </div>
                                <?php */ ?>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer bg-soft-primary">
                        <a href="#" class="btn btn-success mt-4 generateTXTgpt"><?php __('Generar'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ChatGPTransModal" tabindex="-1" aria-labelledby="ChatGPTransModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-fw fa-language me-1"></i> <?php __('Traducir'); ?></h5>
                        <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info alert-label-icon label-arrow fade show clearfix" role="alert">
                                    <i class="fa-regular fa-circle-info label-icon"></i> <?php echo __('Recuerde salvar el inmueble antes de utitizar ChatGPT'); ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3" id="gentextradios">

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actransgpt" type="radio" role="switch" name="gptActionTrans" id="gptActionTrans1" value="titulo_" checked>
                                    <label class="form-check-label" for="gptActionTrans1"><?php __('Título'); ?></label>
                                </div>

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actransgpt" type="radio" role="switch" name="gptActionTrans" id="gptActionTrans2" value="descripcion_">
                                    <label class="form-check-label" for="gptActionTrans2"><?php __('Descripción'); ?></label>
                                </div>

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actransgpt" type="radio" role="switch" name="gptActionTrans" id="gptActionTrans5" value="descripcion_xml_">
                                    <label class="form-check-label" for="gptActionTrans5"><?php __('Descripción'); ?> XML</label>
                                </div>

                                <?php /* ?>
                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actransgpt" type="radio" role="switch" name="gptActionTrans" id="gptActionTrans3" value="title_">
                                    <label class="form-check-label" for="gptActionTrans3"><?php __('Meta title'); ?></label>
                                </div>

                                <div class="form-check form-switch form-switch-lg form-check-inline">
                                    <input class="form-check-input actransgpt" type="radio" role="switch" name="gptActionTrans" id="gptActionTrans4" value="description_">
                                    <label class="form-check-label" for="gptActionTrans4"><?php __('Meta description'); ?></label>
                                </div>
                                <?php */ ?>

                            </div>

                            <hr>

                            <div class="col-6">

                                <label for="fromtrans" class="form-label"><?php __('Traducir desde'); ?>:</label>
                                <select name="fromtrans" id="fromtrans" class="form-select required" required>
                                    <!-- <option value=""><?php echo NXT_getResource("Select one..."); ?></option> -->
                                    <?php
                                    if ($lang_adm == 'es') {
                                        $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                    } else {
                                        $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                    }
                                    foreach ($languages as $value) {
                                        $selected = (isset($lang_adm) && !(strcmp($value, $lang_adm)))?" SELECTED":"";
                                        echo '<option value="'.$value.'"'.$selected.'>'.$idiomas[$value].'</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-6">

                                <label for="totrans" class="form-label"><?php __('Traducir a'); ?>:</label>
                                <select name="totrans" id="totrans" class="form-select required" required>
                                    <!-- <option value=""><?php echo NXT_getResource("Select one..."); ?></option> -->
                                    <?php
                                    if ($lang_adm == 'es') {
                                        $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                    } else {
                                        $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                    }
                                    foreach ($languages as $value) {
                                        echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                    }
                                    ?>
                                </select>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer bg-soft-primary">
                        <a href="#" class="btn btn-success mt-4 generateTXTTradgpt"><?php __('Generar'); ?></a>
                    </div>
                </div>
            </div>
        </div>

    </form>



    <script>
      var checkPagdirt = 1;
    </script>

      <?php include("../includes/inc.footer.php"); ?>

      <!-- <script src="https://maps.google.com/maps/api/js?key=<?php echo $googleMapsApiKey ?>&amp;language=<?php echo $lang_adm ?>"></script> -->
      <!-- <script src="/intramedianet/includes/assets/vendor/components/gmap3/gmap3.min.js"></script> -->

      <script>
      var idProperty = '<?php echo $property_id; ?>';
      var appLang = '<?php echo $lang_adm; ?>';
      var confirmDupli = '<?php __('¿Seguro que desea duplicar este inmueble?'); ?>';
      var alertFinicio = '<?php __('Introduzca la fecha inicio'); ?>';
      var alertFfinal = '<?php __('Introduzca la fecha final'); ?>';
      var alertFmenor = '<?php __('La fecha de inicio ha de ser anterior a la fecha final'); ?>';
      var alertFprice = '<?php __('Introduzca el precio'); ?>';

  // function setCurrency (currency) {
  //   if (!currency.id) { return currency.text; }
  //   var $currency = $('<span class="glyphicon glyphicon-' + currency.element.value + '">' + currency.text + '</span>');
  //   return $currency;
  // };

      function formatResult(state) {
        if (!state.id) { return state.text; }
        var myElement = $(state.element);

        var color = $(myElement).data('colortext');
        var style ='';
        if (color != '') {
            style = ' style="color: ' + color + '"';
        }

        var markup = '<span' + style + '> ' + state.text + '</span>';

        return markup;
      };

      $(".select2custom").select2({
          templateResult: formatResult,
          escapeMarkup: function(m) {
              return m;
          }
      });

      $(document).on('click', '.delimgsvar', function(e) {

        e.preventDefault();

        if (confirm('<?php __('Are you sure want to delete the selected images?'); ?>')) {
        var ids = [];

        $('.delimgv').each(function( index ) {
          if ($( this ).is(":checked")) {
            ids.push($( this ).val());
          }
        });

        if (ids.toString() != '') {
          $.get('images_del_mult.php?ids=' + ids.toString(), function(data) {
              if (data != '') {
                  $.get("images_list.php?id_prop=" + idProperty, function(data) {
                    if(data != '') {
                        $('#images-list').html(data);
                    }
                  });
              }
          });
        }

        }
      });

      $(document).on('click', '.downloadimgsvar', function(e) {
          e.preventDefault();

          var ids = [];

          $('.delimgv').each(function( index ) {
              if ($( this ).is(":checked")) {
              ids.push($( this ).val());
              }
          });

          if (ids.toString() != '') {
              $.get('images_download_mult.php?id_prop=<?php echo $property_id; ?>&ids=' + ids.toString(), function(data) {
                  if (data != '') {
                      top.location.href = data;
                  }
              });
          }else{
              alert('<?php echo __('Please select some images'); ?>');
          }
      });
      $(document).on('click', '.downloadallimgsvar', function(e) {
          e.preventDefault();

          var ids = [];

          $('.delimgv').each(function( index ) {
              ids.push($( this ).val());
          });

          if (ids.toString() != '') {
              $.get('images_download_mult.php?id_prop=<?php echo $property_id; ?>&ids=' + ids.toString(), function(data) {
                  if (data != '') {
                      top.location.href = data;
                  }
              });
          }else{
              alert('<?php echo __('There are no images'); ?>');
          }
      });

      $(document).on('click', '.delimgsvarp', function(e) {

        e.preventDefault();

        if (confirm('<?php __('Are you sure want to delete the selected images?'); ?>')) {
        var ids = [];

        $('.delimgvp').each(function( index ) {
          if ($( this ).is(":checked")) {
            ids.push($( this ).val());
          }
        });

        if (ids.toString() != '') {
          $.get('images_del_multp.php?ids=' + ids.toString(), function(data) {
              if (data != '') {
                  $.get("images_listp.php?id_prop=" + idProperty, function(data) {
                    if(data != '') {
                        $('#images-listp').html(data);
                    }
                  });
              }
          });
        }

        }
        });

        $(document).on('click', '.downloadimgsvarp', function(e) {
          e.preventDefault();

          var ids = [];

          $('.delimgvp').each(function( index ) {
              if ($( this ).is(":checked")) {
              ids.push($( this ).val());
              }
          });

          if (ids.toString() != '') {
              $.get('images_download_multp.php?id_prop=<?php echo $property_id; ?>&ids=' + ids.toString(), function(data) {
                  if (data != '') {
                      top.location.href = data;
                  }
              });
          }else{
              alert('<?php echo __('Please select some images'); ?>');
          }
        });
        $(document).on('click', '.downloadallimgsvarp', function(e) {
          e.preventDefault();

          var ids = [];

          $('.delimgvp').each(function( index ) {
              ids.push($( this ).val());
          });

          if (ids.toString() != '') {
              $.get('images_download_multp.php?id_prop=<?php echo $property_id; ?>&ids=' + ids.toString(), function(data) {
                  if (data != '') {
                      top.location.href = data;
                  }
              });
          }else{
              alert('<?php echo __('There are no images'); ?>');
          }
        });
        </script>


      <script src="_js/properties-form.js?id=<?php echo time(); ?>" type="text/javascript"></script>
      <script src="fotocasa/_js/properties-form-fotocasa.js?id=<?php echo time(); ?>" type="text/javascript"></script>


      <script>
            $(document).on('click', '.sendfiles', function(e) {

            e.preventDefault();

            var ids = [];

            $('.sendfile').each(function( index ) {
              if ($( this ).is(":checked")) {
                ids.push($( this ).val());
              }
            });

            if (ids.toString() != '' && $('#colbrs').val() != '') {
              if (confirm('<?php __('Are you sure want to send the selected files?'); ?>')) {
              $.get('files_send3.php?ids=' + ids.toString() + '&email=' + $('#colbrs').val() + '&id_prop=<?php echo $property_id; ?>', function(data) {
                  if (data == 'ok') {
                      alert('<?php __('Los archivos se han enviado correctamente.'); ?>');
                  }
              });
            }

            }
          });
      </script>

      <script>
        $(document).on('click', '.delallimgsvar', function(e) {
            e.preventDefault();
            if (confirm('<?php __('Are you sure want to delete the selected images?'); ?>')) {
                var ids = [];
                $('.delimgv').each(function( index ) {
                    ids.push($( this ).val());
                });
                if (ids.toString() != '') {
                    $.get('images_del_mult.php?ids=' + ids.toString(), function(data) {
                        if (data != '') {
                            $.get("images_list.php?id_prop=" + idProperty, function(data) {
                                if(data != '') {
                                    $('#images-list').html(data);
                                }
                            });
                        }
                    });
                }
            }
        });
        $(document).on('click', '.delallimgsvarp', function(e) {
            e.preventDefault();
            if (confirm('<?php __('Are you sure want to delete the selected images?'); ?>')) {
                var ids = [];
                $('.delimgvp').each(function( index ) {
                    ids.push($( this ).val());
                });
                if (ids.toString() != '') {
                    $.get('images_del_multp.php?ids=' + ids.toString(), function(data) {
                        if (data != '') {
                            $.get("images_listp.php?id_prop=" + idProperty, function(data) {
                                if(data != '') {
                                    $('#images-listp').html(data);
                                }
                            });
                        }
                    });
                }
            }
        });
      </script>
      <script>

        $(document).on('change', '#myModal5 #type_pro', function(e) {
            e.preventDefault();

            if ($(this).val() == 3) {
              $('#myModal5 #nameprom').html('<?php __('Banco'); ?>');
              $('#myModal5 #workers').show();
              $('#myModal5 #surnameprom').hide();
              $('#myModal5 #nie_pro-cont').hide();
              $('#myModal5 #nie2_pro-cont').hide();
              $('#myModal5 #pasaporte_pro-cont').hide();
              $('#myModal5 #pasaporte2_pro-cont').hide();
              $('#myModal5 #nacionalidad_pro-cont').hide();
              $('#myModal5 #holder-cont').hide();
            } else if ($(this).val() == 2) {
              $('#myModal5 #nameprom').html('<?php __('Constructor'); ?>');
              $('#myModal5 #workers').show();
              $('#myModal5 #surnameprom').hide();
              $('#myModal5 #nie_pro-cont').hide();
              $('#myModal5 #nie2_pro-cont').hide();
              $('#myModal5 #pasaporte_pro-cont').hide();
              $('#myModal5 #pasaporte2_pro-cont').hide();
              $('#myModal5 #nacionalidad_pro-cont').hide();
              $('#myModal5 #holder-cont').hide();
            } else {
              $('#myModal5 #nameprom').html('<?php __('Nombre'); ?>');
              $('#myModal5 #workers').hide();
              $('#myModal5 #surnameprom').show();
              $('#myModal5 #nie_pro-cont').show();
              $('#myModal5 #nie2_pro-cont').show();
              $('#myModal5 #pasaporte_pro-cont').show();
              $('#myModal5 #pasaporte2_pro-cont').show();
              $('#myModal5 #nacionalidad_pro-cont').show();
              $('#myModal5 #holder-cont').show();
            }
        });

        $(document).on('change', '#myModal6 #type_pro', function(e) {
            e.preventDefault();

            if ($(this).val() == 3) {
              $('#myModal6 #nameprom').html('<?php __('Banco'); ?>');
              $('#myModal6 #workers').show();
              $('#myModal6 #surnameprom').hide();
              $('#myModal6 #nie_pro-cont').hide();
              $('#myModal6 #nie2_pro-cont').hide();
              $('#myModal6 #pasaporte_pro-cont').hide();
              $('#myModal6 #pasaporte2_pro-cont').hide();
              $('#myModal6 #nacionalidad_pro-cont').hide();
              $('#myModal6 #holder-cont').hide();
            } else if ($(this).val() == 2) {
              $('#myModal6 #nameprom').html('<?php __('Constructor'); ?>');
              $('#myModal6 #workers').show();
              $('#myModal6 #surnameprom').hide();
              $('#myModal6 #nie_pro-cont').hide();
              $('#myModal6 #nie2_pro-cont').hide();
              $('#myModal6 #pasaporte_pro-cont').hide();
              $('#myModal6 #pasaporte2_pro-cont').hide();
              $('#myModal6 #nacionalidad_pro-cont').hide();
              $('#myModal6 #holder-cont').hide();
            } else {
              $('#myModal6 #nameprom').html('<?php __('Nombre'); ?>');
              $('#myModal6 #workers').hide();
              $('#myModal6 #surnameprom').show();
              $('#myModal6 #nie_pro-cont').show();
              $('#myModal6 #nie2_pro-cont').show();
              $('#myModal6 #pasaporte_pro-cont').show();
              $('#myModal6 #pasaporte2_pro-cont').show();
              $('#myModal6 #nacionalidad_pro-cont').show();
              $('#myModal6 #holder-cont').show();
            }
        });

        $(document).ready(function() {
            $('#myModal5 #type_pro').change();
            $('#myModal6 #type_pro').change();
            var max_fields      = 15; //maximum input boxes allowed
            var wrapper         = $("#myModal5 .input_fields_wrap"); //Fields wrapper
            var add_button      = $("#myModal5 .add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div class="form-group"><textarea name="worker[]" rows="4" class="form-control"></textarea><a href="#" class="remove_field btn btn-danger btn-xs"><?php __('Eliminar'); ?></a></div>'); //add input box
                }
            });

            $(document).on("click","#myModal5 .remove_field", function(e){ //user click on remove text
            });

            $(document).on("click","#proptabs a", function(e){ //user click on remove text
                window.scrollTo({ top: 0, behavior: 'smooth' });
                if ($(this).attr('href') == '#tabcruce') {
                    $('#interesados-tab').click();
                }
            });

            $(document).on("click",".cruce-nav", function(e){
                e.preventDefault();
                $url = $(this).attr('href');
                $('#interesados-content').html('').addClass('loading');
                $.get($url, function(data) {
                    $('#interesados-content').removeClass('loading').html(data);
                });
            });

            $(document).on("click",".view-mail-cont", function(e){ //user click on remove text
                e.preventDefault();

                $.get('view-mensa.php?id=' + $(this).data('id'), function(data) {
                     $('#mail-text').html(data);
                     $('#myModal3').modal('show');
                });
            });

            <?php foreach($languages as $value) { ?>
                $(document).on("keyup","#titulo_<?php echo $value; ?>_prop", function(e){
                    e.preventDefault();
                    $('#title_<?php echo $value; ?>_prop').val($('#titulo_<?php echo $value; ?>_prop').val());
                });
            <?php } ?>

        });
      </script>

    <div id="myModal3" class="modal  fade" tabindex="-1" aria-labelledby="myModal3Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="mail-text"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
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
        </div><!-- /.modal-dialog modal-dialog-centered -->
    </div><!-- /.modal -->

    <div id="myModal2" class="modal fade" tabindex="-1" aria-labelledby="myModal2Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar nombres'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="loadingfrm"></div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog modal-dialog-centered -->
    </div><!-- /.modal -->

    <div id="myModal4" class="modal fade" tabindex="-1" aria-labelledby="myModal4Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar nombre'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="loadingfrm"></div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog modal-dialog-centered -->
    </div><!-- /.modal -->

    <div id="myModalLang" class="modal fade" tabindex="-1" aria-labelledby="myModalLangLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar idioma'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="loadingfrm"></div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog modal-dialog-centered -->
    </div><!-- /.modal -->

    <div id="myModal400" class="modal fade" tabindex="-1" aria-labelledby="myModal400Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir nota'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <textarea type="text" name="historial_pro2" id="historial_pro2" cols="50" rows="10" class="form-control"></textarea>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog modal-dialog-centered -->
    </div><!-- /.modal -->

    <div id="myModal6" class="modal fade" tabindex="-1" aria-labelledby="myModal6Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-pencil me-2 fs-4"></i> <?php __('Editar propietario'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="loadingfrm"></div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog modal-dialog-centered -->
    </div><!-- /.modal -->

    <div id="myModal5" class="modal fade" tabindex="-1" aria-labelledby="myModal5Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir propietario'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <form action="" method="post" id="addPropie">

                      <div class="row">

                        <div class="col-md-4">

                          <div class="mb-4">
                              <label for="type_pro" class="form-label"><?php __('Tipo'); ?>:</label>
                              <select name="type_pro" id="type_pro" class="form-select">
                                  <option value="1"><?php __('Particular'); ?></option>
                                  <option value="2"><?php __('Constructor'); ?></option>
                                  <option value="3"><?php __('Banco'); ?></option>
                              </select>
                          </div>

                          <div class="mb-4">
                            <label for="nombre_pro" class="form-label" id="nameprom"><?php __('Nombre'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="nombre_pro" id="nombre_pro" value="" size="32" maxlength="255" class="form-control required">
                            </div>
                          </div>

                          <div class="mb-4" id="surnameprom">
                            <label for="apellidos_pro" class="form-label"><?php __('Apellidos'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="apellidos_pro" id="apellidos_pro" value="" size="32" maxlength="255" class="form-control required">
                            </div>
                          </div>

                          <div id="workers">
                              <div class="input_fields_wrap">
                                  <label><?php __('Persona de Contacto'); ?></label>
                                      <div class="mb-4">
                                          <textarea name="worker[]" rows="4" class="form-control"><?php if(isset($worker)) echo $worker; ?></textarea>
                                          <a href="#" class="remove_field btn btn-danger btn-xs">Eliminar</a>
                                      </div>
                              </div>
                              <button class="add_field_button btn btn-primary btn-sm"><?php __('Añadir Persona de Contacto'); ?></button><br><br>
                          </div>

                          <div class="mb-4">
                            <label for="telefono_fijo_pro" class="form-label"><?php __('Teléfono'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" value="" size="32" maxlength="255" class="form-control">
                            </div>
                          </div>

                          <div class="mb-4">
                            <label for="telefono_movil_pro" class="form-label"><?php __('Móvil'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="telefono_movil_pro" id="telefono_movil_pro" value="" size="32" maxlength="255" class="form-control">
                            </div>
                          </div>

                          <div class="mb-4">
                            <label for="nie_pro" class="form-label"><?php __('NIE'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="nie_pro" id="nie_pro" value="" size="32" maxlength="255" class="form-control">
                            </div>
                          </div>

                        </div>

                        <div class="col-md-4">

                          <div class="mb-4">
                              <label for="status_pro" class="form-label"><?php __('Estatus'); ?>:</label>
                              <div class="controls">
                                  <select name="status_pro" id="status_pro" class="select2">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php
                                      do {
                                      ?>
                                      <option value="<?php echo $row_rsStatus ['id_sts']?>"><?php echo $row_rsStatus ['category_'.$lang_adm.'_sts']?></option>
                                      <?php
                                      } while ($row_rsStatus  = mysqli_fetch_assoc($rsStatus ));
                                        $rows = mysqli_num_rows($rsStatus );
                                        if($rows > 0) {
                                            mysqli_data_seek($rsStatus , 0);
                                          $row_rsStatus  = mysqli_fetch_assoc($rsStatus );
                                        }
                                      ?>
                                  </select>
                              </div>
                          </div>

                          <div class="mb-4">
                            <label for="pasaporte_pro" class="form-label"><?php __('Pasaporte'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="pasaporte_pro" id="pasaporte_pro" value="" size="32" maxlength="255" class="form-control">
                            </div>
                          </div>

                          <div class="mb-4">
                            <label for="email_pro" class="form-label"><?php __('Email'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="email_pro" id="email_pro" value="" size="32" maxlength="255" class="form-control">
                            </div>
                          </div>

                          <div class="mb-4">
                            <label for="skype_pro" class="form-label"><?php __('Skype'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="skype_pro" id="skype_pro" value="" size="32" maxlength="255" class="form-control">
                            </div>
                          </div>

                          <div class="mb-4">
                            <label for="direccion_pro" class="form-label"><?php __('Dirección'); ?>:</label>
                            <div class="controls">
                                <input type="text" name="direccion_pro" id="direccion_pro" value="" size="32" maxlength="255" class="form-control">
                            </div>
                          </div>

                        </div>

                        <div class="col-md-4">

                          <div class="mb-4">
                              <label for="como_nos_conocio_pro" class="form-label"><?php __('Cómo nos conoció'); ?>:</label>
                              <div class="controls">
                                  <select name="como_nos_conocio_pro" id="como_nos_conocio_pro" class="select2">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php
                                      
                                      $query_rsSources = "SELECT * FROM properties_owner_sources ORDER BY category_".$lang_adm."_sts ASC";
                                      $rsSources = mysqli_query($inmoconn, $query_rsSources) or die(mysqli_error());
                                      $row_rsSources = mysqli_fetch_assoc($rsSources);
                                      $totalRows_rsSources = mysqli_num_rows($rsSources);
                                      do { ?>
                                      <option value="<?php echo $row_rsSources['id_sts']?>"><?php echo $row_rsSources['category_'.$lang_adm.'_sts']?></option>
                                      <?php } while ($row_rsSources = mysqli_fetch_assoc($rsSources));
                                        $rows = mysqli_num_rows($rsSources);
                                        if($rows > 0) {
                                            mysqli_data_seek($rsSources, 0);
                                          $row_rsSources = mysqli_fetch_assoc($rsSources);
                                        } ?>
                                  </select>
                              </div>
                          </div>

                            <div class="mb-4">
                                <label for="captado_por_pro" class="form-label"><?php __('Captado por'); ?>:</label>
                                <div class="controls">
                                    <select name="captado_por_pro" id="captado_por_pro" class="select2">
                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                        <?php
                                        
                                        $query_rsCaptado = "SELECT * FROM properties_owner_captado ORDER BY category_".$lang_adm."_cap ASC";
                                        $rsCaptado = mysqli_query($inmoconn, $query_rsCaptado) or die(mysqli_error());
                                        $row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
                                        $totalRows_rsCaptado = mysqli_num_rows($rsCaptado);
                                        do { ?>
                                        <option value="<?php echo $row_rsCaptado['id_cap']?>"<?php if (isset($row_rsproperties_owner['captado_por_pro']) && !(strcmp($row_rsCaptado ['id_cap'], $row_rsproperties_owner['captado_por_pro']))) {echo "SELECTED";} ?>><?php echo $row_rsCaptado ['category_'.$lang_adm.'_cap']?></option>
                                        <?php } while ($row_rsCaptado  = mysqli_fetch_assoc($rsCaptado ));
                                          $rows = mysqli_num_rows($rsCaptado );
                                          if($rows > 0) {
                                              mysqli_data_seek($rsCaptado , 0);
                                            $row_rsCaptado  = mysqli_fetch_assoc($rsCaptado );
                                          } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="card">
                              <div class="card-body bg-soft-primary">
                              <div class="row">
                                <div class="col-md-12">

                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                        <input type="checkbox" name="keyholder_pro" id="keyholder_pro" value="1" class="form-check-input">
                                        <label class="form-check-label" for="keyholder_pro"><?php __('Solicitar llave'); ?></label>
                                    </div>

                                    <div id="keytxt" >

                                      <div class="mb-4" style="margin-bottom: 0;">
                                          <label for="keyholder_name_pro" class="form-label"><?php __('Nombre'); ?>:</label>
                                          <div class="controls">
                                              <input type="text" name="keyholder_name_pro" id="keyholder_name_pro" value="" size="32" maxlength="255" class="form-control">
                                          </div>
                                      </div>

                                      <div class="mb-4" style="margin-bottom: 0;">
                                          <label for="keyholder_tel_pro" class="form-label"><?php __('Teléfono'); ?>:</label>
                                          <div class="controls">
                                              <input type="text" name="keyholder_tel_pro" id="keyholder_tel_pro" value="" size="32" maxlength="255" class="form-control">
                                          </div>
                                      </div>

                                    </div>

                                </div>
                              </div>
                            </div>
                            </div>

                        </div>

                      </div>

                    </form>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog modal-dialog-centered -->
    </div><!-- /.modal -->

<script type="text/javascript">
    $('.select2owners').select2({
      ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-owners-select.php?q=' + params;
        },
        dataType: 'json',
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        cache: true,
        },
        placeholder: '',
        minimumInputLength: 3,
    });
    <?php if ($row_rsproperties_properties['owner_prop'] != ''): ?>
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/intramedianet/properties/properties-owners-select-single.php?q=<?php echo $row_rsproperties_properties['owner_prop'] ?>'
    }).then(function (data) {
      $(".select2owners").select2('data', { id:data.id, text: data.text});
      $(".select2owners").change();
    });
    <?php endif ?>
</script>

<script>
// Si cambia el checkbox de idealista muestra el formulario
$('#idealista_prop').change(function(e) {
  e.preventDefault();
  if ($(this).is(':checked') == true) {
    $('#basicIdealista').fadeIn('slow');
    var $val1 = $('#idealistaPropertyStatusId').val();
    var $val2 = $('#idealistaTransactionTypeId').val();
    var $val3 = $('#idealistaTypeId').val();
    if ( $val1 != "" && $val2 != "" && $val3 != "" ) {
      $('#featuresIdealista').fadeIn('slow');
    }
  } else{
    $('#basicIdealista, #featuresIdealista').fadeOut('slow');
  }
});
</script>

<script>
// Si cambia el checkbox de yaencontre muestra el formulario
$('#export_yaencontre_prop').change(function(e) {
  e.preventDefault();
  if ($(this).is(':checked') == true) {
    $('#basicYaencontre').fadeIn('slow');
    var $val1 = $('#yaencontrePropertyStatusId').val();
    var $val2 = $('#yaencontreTransactionTypeId').val();
    var $val3 = $('#yaencontreTypeId').val();
    if ( $val1 != "" && $val2 != "" && $val3 != "" ) {
      $('#featuresYaencontre').fadeIn('slow');
    }
  } else{
    $('#basicYaencontre, #featuresYaencontre').fadeOut('slow');
  }
});
</script>
<style>
  .g_map iframe img,
  .g_mapp iframe img {
    max-width: auto;
  }
</style>
<script>
// Si cambia el checkbox de idealista muestra el formulario
$('#export_rightmove_prop').change(function(e) {
  e.preventDefault();
  if ($(this).is(':checked') == true) {
    $('#basicRightmove').fadeIn('slow');
  }  else{
    $('#basicRightmove').fadeOut('slow');
  }
});
</script>
<!-- <script src="/intramedianet/includes/assets/js/jquery.dirty.js"></script>
<script>
$( window ).on( "load", function() {
    $("#form1").dirty("setAsClean");
});

$("#form1").dirty({
    preventLeaving: true
});
</script> -->
<script>
    $('.generateTXTgpt').click(function(e) {
        e.preventDefault();

        $('#ChatGPTModal .modal-body').append('<div class="loading">');

        $action = $(".actgpt:checked").val();
        $toLng = $("#toLng option:selected").text();
        $toLngVal = $("#toLng option:selected").val();
        $prompt = $("#chatgpt_prompt_prop").val();

        if ($action == 'titulo__prop') { // Titular
            action = 'title';
        }
        if ($action == 'descripcion__prop') { // Descripción
            action = 'description';
        }
        if ($action == 'descripcion_xml__prop') { // Descripción XML
            action = 'description';
        }
        if ($action == 'title__prop') { // Meta Title
            action = 'metatit';
        }
        if ($action == 'description__prop') { // Meta Description
            action = 'metades';
        }

        $.get("prompt.php?id_prop=<?php echo $property_id; ?>&lang=" + $toLngVal +  "&langto=" + $toLng + "&action=" + action + "&prompt=" + $prompt, function(data) {
            $field = '#' + $action.replace('__', '_' + $toLngVal + '_');

            if ($action == 'descripcion__prop' || $action == 'descripcion_xml__prop') {
                $($field).redactor('source.setCode', data);
            } else {
                $($field).val(data).keyup();
            }
            $('#ChatGPTModal .loading').remove().keyup();

            const contactTab = document.querySelector('.tabdescr-' + $toLngVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector('.tabmet-' + $toLngVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });
</script>
<script>
    $('.generateTXTTradgpt').click(function(e) {
        e.preventDefault();

        $('#ChatGPTransModal .modal-body').append('<div class="loading">');

        $action = $(".actransgpt:checked").val();
        $fromtrans = $("#fromtrans option:selected").text();
        $fromtransVal = $("#fromtrans option:selected").val();
        $totrans = $("#totrans option:selected").text();
        $totransVal = $("#totrans option:selected").val();

        $.get("prompt-trans.php?id_prop=<?php echo $property_id; ?>&lang=<?php echo $lang_adm; ?>&action=" + $action + "&from=" + $fromtrans + "&to=" + $totrans + "" , function(data) {
            $field = '#' + $action + $totransVal + '_prop';
            if ($action == 'descripcion_' || $action == 'descripcion_xml') {
                $($field).redactor('source.setCode', data);
            } else {
                $($field).val(data).keyup();
            }
            $('#ChatGPTransModal .loading').remove().keyup();

            const contactTab = document.querySelector('.tabdescr-' + $totransVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector('.tabmet-' + $totransVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });

    $('.tabdescr').click(function(e) {
        e.preventDefault();
        $('#toLng option[value="' + $(this).data('lang') + '"]').prop('selected', true);
        $('#fromtrans option[value="' + $(this).data('lang') + '"]').prop('selected', true);
    });

    $('#toLng').change(function(e) {
        const contactTab = document.querySelector('.tabdescr-' + $( "#toLng option:selected").val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector('.tabmet-' + $( "#toLng option:selected").val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $('#fromtrans option[value="' + $( "#toLng option:selected").val() + '"]').prop('selected', true);
    });

    $('#fromtrans').change(function(e) {
        const contactTab = document.querySelector('.tabdescr-' + $( "#fromtrans option:selected").val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector('.tabmet-' + $( "#fromtrans option:selected").val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $('#toLng option[value="' + $( "#fromtrans option:selected").val() + '"]').prop('selected', true);
    });
</script>
<style>
#ChatGPTModal .modal-body,
#ChatGPTransModal .modal-body {
    position: relative;
    min-height: 150px;
}
#ChatGPTModal .loading,
#ChatGPTransModal .loading {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9) url(/media/images/website/large-loading.gif) no-repeat center center;
}
</style>
</body>
</html>
