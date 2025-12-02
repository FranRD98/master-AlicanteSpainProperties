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
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

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

if (!isset($_GET['id_cli'])) {

  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'properties_client'";
  $rsNextIncrement = mysqli_query($inmoconn,$query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

  $clientId = $row_rsNextIncrement['Auto_increment'];

} else {

  $clientId = $_GET['id_cli'];

}

if (!function_exists("GetSQLValueString")) 
{
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
  {
    
    $theValue = mysqli_real_escape_string($inmoconn,$theValue);

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

function limpiarTelefono($telefono) {
    if(isset($telefono)){
    // Remover el carácter de suma y los espacios en blanco
    $telefono = str_replace('+', '', $telefono); // Elimina el signo de suma
    $telefono = str_replace(' ', '', $telefono); // Elimina los espacios en blanco
    }
    return $telefono;
}



$query_rsTipos = "
SELECT
  CASE WHEN properties_types.types_".$lang_adm."_typ IS NOT NULL THEN properties_types.types_".$lang_adm."_typ ELSE types.types_".$lang_adm."_typ END AS types_".$lang_adm."_typ,
  CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS id_typ
FROM  properties_properties
    INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
GROUP BY id_typ
ORDER BY types_".$lang_adm."_typ
";
$rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsFiles = "SELECT * FROM properties_client_files WHERE client_fil = '".$clientId."' ";
$rsFiles = mysqli_query($inmoconn ,$query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);


$query_rsSales = "SELECT * FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsSales = mysqli_query($inmoconn ,$query_rsSales) or die(mysqli_error());
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);


$query_rsStatus = "SELECT * FROM properties_client_states ORDER BY category_".$lang_adm."_sts ASC";
$rsStatus = mysqli_query($inmoconn ,$query_rsStatus) or die(mysqli_error());
$row_rsStatus = mysqli_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysqli_num_rows($rsStatus);


$query_rsCaptado = "SELECT * FROM properties_client_captado ORDER BY category_".$lang_adm."_cap ASC";
$rsCaptado = mysqli_query($inmoconn ,$query_rsCaptado) or die(mysqli_error());
$row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
$totalRows_rsCaptado = mysqli_num_rows($rsCaptado);


$query_rsSources = "SELECT * FROM properties_client_sources ORDER BY category_".$lang_adm."_sts ASC";
$rsSources = mysqli_query($inmoconn ,$query_rsSources) or die(mysqli_error());
$row_rsSources = mysqli_fetch_assoc($rsSources);
$totalRows_rsSources = mysqli_num_rows($rsSources);


$query_rsColaboradores = "SELECT * FROM properties_collaborators ORDER BY nombre_comercial_col ASC";
$rsColaboradores = mysqli_query($inmoconn ,$query_rsColaboradores) or die(mysqli_error());
$row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores);
$totalRows_rsColaboradores = mysqli_num_rows($rsColaboradores);


$query_rsTemplates = "SELECT * FROM templates WHERE week_tmpl = 0 ORDER BY name_".$lang_adm."_tmpl ASC";
$rsTemplates = mysqli_query($inmoconn ,$query_rsTemplates) or die(mysqli_error());
$row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
$totalRows_rsTemplates = mysqli_num_rows($rsTemplates);


$query_rsparent1 = "
SELECT properties_loc1.id_loc1 AS id,
  properties_loc1.name_".$lang_adm."_loc1 AS `name`
FROM properties_properties INNER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
INNER JOIN properties_loc3 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3
 INNER JOIN properties_loc2 ON properties_loc3.loc2_loc3 = properties_loc2.id_loc2
 INNER JOIN properties_loc1 ON properties_loc2.loc1_loc2 = properties_loc1.id_loc1
GROUP BY properties_loc1.id_loc1
ORDER BY `name` ASC
";
$rsparent1 = mysqli_query($inmoconn ,$query_rsparent1) or die(mysqli_error() . '<hr>' . $query_rsparent1);
$row_rsparent1 = mysqli_fetch_assoc($rsparent1);
$totalRows_rsparent1 = mysqli_num_rows($rsparent1);


$query_rsparent2 = "
SELECT
    CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS name,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id


    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
GROUP BY id
ORDER BY `name` ASC
";
$rsparent2 = mysqli_query($inmoconn ,$query_rsparent2) or die(mysqli_error() . '<hr>' . $query_rsparent2);
$row_rsparent2 = mysqli_fetch_assoc($rsparent2);
$totalRows_rsparent2 = mysqli_num_rows($rsparent2);


$query_rsparent3 = "
 SELECT

    CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS name,
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

    WHERE areas1.parent_loc3 IS NULL
GROUP BY id
ORDER BY `name` ASC
";
$rsparent3 = mysqli_query($inmoconn ,$query_rsparent3) or die(mysqli_error());
$row_rsparent3 = mysqli_fetch_assoc($rsparent3);
$totalRows_rsparent3 = mysqli_num_rows($rsparent3);


$query_rsparent4 = "
 SELECT
    CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS name,
    CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END AS id

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
GROUP BY id
ORDER BY name ASC
";
$rsparent4 = mysqli_query($inmoconn ,$query_rsparent4) or die(mysqli_error());
$row_rsparent4 = mysqli_fetch_assoc($rsparent4);
$totalRows_rsparent4 = mysqli_num_rows($rsparent4);


$query_rsReferencias = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias = mysqli_query($inmoconn ,$query_rsReferencias) or die(mysqli_error());
$row_rsReferencias = mysqli_fetch_assoc($rsReferencias);
$totalRows_rsReferencias = mysqli_num_rows($rsReferencias);


$query_rsReferencias2 = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias2 = mysqli_query($inmoconn ,$query_rsReferencias2) or die(mysqli_error());
$row_rsReferencias2 = mysqli_fetch_assoc($rsReferencias2);
$totalRows_rsReferencias2 = mysqli_num_rows($rsReferencias2);


$query_rsReferencias3 = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias3 = mysqli_query($inmoconn ,$query_rsReferencias3) or die(mysqli_error());
$row_rsReferencias3 = mysqli_fetch_assoc($rsReferencias3);
$totalRows_rsReferencias3 = mysqli_num_rows($rsReferencias3);


$query_rsOpciones = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features ORDER BY name ASC";
$rsOpciones = mysqli_query($inmoconn ,$query_rsOpciones) or die(mysqli_error());
$row_rsOpciones = mysqli_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysqli_num_rows($rsOpciones);


$query_rsOpciones2 = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features_priv ORDER BY name ASC";
$rsOpciones2 = mysqli_query($inmoconn ,$query_rsOpciones2) or die(mysqli_error());
$row_rsOpciones2 = mysqli_fetch_assoc($rsOpciones2);
$totalRows_rsOpciones2 = mysqli_num_rows($rsOpciones2);


$query_rsTags = "SELECT id_tag as id, tag_".$lang_adm."_tag as name FROM properties_tags ORDER BY name ASC";
$rsTags = mysqli_query($inmoconn ,$query_rsTags) or die(mysqli_error());
$row_rsTags = mysqli_fetch_assoc($rsTags);
$totalRows_rsTags = mysqli_num_rows($rsTags);


if(isset($_GET['id_cli'])){
    $query_rsConsultasProp = "
        SELECT properties_enquiries.id_cons,
        (SELECT referencia_prop FROM properties_properties WHERE id_prop = inmueble_cons) AS inmueble_cons,
        inmueble_cons AS idprop,
        properties_enquiries.comentario_consas,
        properties_enquiries.fecha_cons,
        properties_enquiries.read_cons,
        properties_enquiries.client_cons
        FROM properties_enquiries
        WHERE properties_enquiries.client_cons = '".$_GET['id_cli']."' AND properties_enquiries.client_cons != ''
        ORDER BY properties_enquiries.fecha_cons DESC
    ";
    $rsConsultasProp = mysqli_query($inmoconn ,$query_rsConsultasProp) or die(mysqli_error());
    $row_rsConsultasProp = mysqli_fetch_assoc($rsConsultasProp);
    $totalRows_rsConsultasProp = mysqli_num_rows($rsConsultasProp);
}else{
    $row_rsConsultasProp = array();
    $totalRows_rsConsultasProp = 0;
}


$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct FROM citas_categories ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn ,$query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);


$query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 7 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsusuarios = mysqli_query($inmoconn ,$query_rsusuarios) or die(mysqli_error());
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);


$query_rsclientes = "SELECT nombre_cli, apellidos_cli, id_cli FROM properties_client ORDER BY nombre_cli, apellidos_cli";
$rsclientes = mysqli_query($inmoconn ,$query_rsclientes) or die(mysqli_error());
$row_rsclientes = mysqli_fetch_assoc($rsclientes);
$totalRows_rsclientes = mysqli_num_rows($rsclientes);


$query_rsvendor = "SELECT nombre_pro, apellidos_pro, id_pro FROM properties_owner ORDER BY nombre_pro, apellidos_pro";
$rsvendor = mysqli_query($inmoconn ,$query_rsvendor) or die(mysqli_error());
$row_rsvendor = mysqli_fetch_assoc($rsvendor);
$totalRows_rsvendor = mysqli_num_rows($rsvendor);


$query_rsPool = "SELECT pool_".$lang_adm."_pl as pool, id_pl FROM properties_pool ORDER BY pool ASC";
$rsPool = mysqli_query($inmoconn ,$query_rsPool) or die(mysqli_error());
$row_rsPool = mysqli_fetch_assoc($rsPool);
$totalRows_rsPool = mysqli_num_rows($rsPool);


$query_rsParking = "SELECT parking_".$lang_adm."_prk as parking, id_prk FROM properties_parking ORDER BY parking ASC";
$rsParking = mysqli_query($inmoconn ,$query_rsParking) or die(mysqli_error());
$row_rsParking = mysqli_fetch_assoc($rsParking);
$totalRows_rsParking = mysqli_num_rows($rsParking);


$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = mysqli_query($inmoconn ,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

$query_rsratings = "SELECT property FROM cli_prop_rate WHERE client = '".$_GET['id_cli']."'";
$rsratings = mysqli_query($inmoconn,$query_rsratings) or die(mysqli_error());
$row_rsratings = mysqli_fetch_assoc($rsratings);
$totalRows_rsratings = mysqli_num_rows($rsratings);


$query_rsNationalities = "SELECT id_ncld, nacionalidad_".$lang_adm."_ncld FROM nacionalidades ORDER BY nacionalidad_".$lang_adm."_ncld";
$rsNationalities = mysqli_query($inmoconn ,$query_rsNationalities) or die(mysqli_error());
$row_rsNationalities = mysqli_fetch_assoc($rsNationalities);
$totalRows_rsNationalities = mysqli_num_rows($rsNationalities);

foreach ($languages as $idm) {

    $query_rsNews[$idm] = "SELECT title_".$idm."_nws, id_nws FROM news WHERE type_nws = 1 AND content_".$idm."_nws != '' ORDER BY title_".$idm."_nws";
    $rsNews[$idm] = mysqli_query($inmoconn,$query_rsNews[$idm]) or die(mysqli_error());
    $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);

    $query_rsProm[$idm] = "SELECT title_".$idm."_nws, id_nws FROM news WHERE type_nws = 999 AND content_".$idm."_nws != '' ORDER BY title_".$idm."_nws";
    $rsProm[$idm] = mysqli_query($inmoconn,$query_rsProm[$idm]) or die(mysqli_error());
    $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);

    $query_rsCities[$idm] = "SELECT title_".$idm."_nws, id_nws FROM news WHERE type_nws = 6 AND content_".$idm."_nws != '' ORDER BY title_".$idm."_nws";
    $rsCities[$idm] = mysqli_query($inmoconn,$query_rsCities[$idm]) or die(mysqli_error());
    $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
}

$query_rscosta = "SELECT id_cst, coast_".$lang_adm."_cst as costa FROM properties_coast WHERE coast_".$lang_adm."_cst IS NOT NULL ORDER BY coast_".$lang_adm."_cst ASC";
$rscosta = mysqli_query($inmoconn ,$query_rscosta) or die(mysqli_error() . '<hr>' . $query_rscosta);
$row_rscosta = mysqli_fetch_assoc($rscosta);
$totalRows_rscosta = mysqli_num_rows($rscosta);

if ($actFerias == 1) 
{
  //Ferias
  
  $query_rsFairs = "SELECT feria_cli, id_cli FROM properties_client WHERE id_cli = '" . $_GET['id_cli'] . "' ";
  $rsFairs = mysqli_query($inmoconn ,$query_rsFairs) or die(mysqli_error());
  $row_rsFairs = mysqli_fetch_assoc($rsFairs);
  $totalRows_rsFairs = mysqli_num_rows($rsFairs);
}


function addRefs($ids) {

  global $database_inmoconn, $inmoconn;

  if ($ids == '') {
    return '';
  }

  
  $query_rsRefs = "SELECT referencia_prop, id_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
  $rsRefs = mysqli_query($inmoconn ,$query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
  $row_rsRefs = mysqli_fetch_assoc($rsRefs);
  $totalRows_rsRefs = mysqli_num_rows($rsRefs);

  $ret = array();

  do {

    array_push($ret, '<a href="/intramedianet/properties/properties-form.php?id_prop='.$row_rsRefs['id_prop'].'" target="_blank" class="btn btn-soft-primary btn-sm">'.$row_rsRefs['referencia_prop'].'</a>');

  } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));


  return implode(' ', $ret);

}

function loguser($user, $id, $ref, $action) {

    global $database_inmoconn, $inmoconn;

    
    $query_rsProp = "INSERT INTO `properties_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '".$user."', '".$id."', '".$ref."', '".$action."', '".date("Y-m-d H:i:s")."')";
    $rsProp = mysqli_query($inmoconn ,$query_rsProp) or die(mysqli_error());


}

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_cli", true, "text", "", "", "", "");
// $formValidation->addField("nombre2_cli", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect(&$tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("clients-form.php?id_cli=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_client_files");
  $tblDelObj->setFieldName("client_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/clients/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  global $lang, $database_inmoconn, $inmoconn;


  $query_rsclientes = "SELECT nombre_cli, apellidos_cli, id_cli FROM properties_client WHERE (email_cli = '" . $tNG->getColumnValue('email_cli') . "' OR skype_cli = '" . $tNG->getColumnValue('email_cli') . "')  AND archived_cli = 1 ";
  $rsclientes = mysqli_query($inmoconn ,$query_rsclientes) or die(mysqli_error());
  $row_rsclientes = mysqli_fetch_assoc($rsclientes);
  $totalRows_rsclientes = mysqli_num_rows($rsclientes);


  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("properties_client");
  $tblFldObj->addFieldName("email_cli");
  if ($totalRows_rsclientes > 0) {
    $tblFldObj->setErrorMsg($lang['Cliente archivado'] . ": {email_cli}");
  } else {
    $tblFldObj->setErrorMsg($lang['Registro duplicado'] . ": {email_cli}");
  }


  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

//start Trigger_CheckUnique2 trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique2(&$tNG) {
  global $lang;
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("properties_client");
  $tblFldObj->addFieldName("telefono_fijo_cli");
  $tblFldObj->setErrorMsg("The <b>Buyer</b> already exists (Phone): {telefono_fijo_cli}");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique2 trigger


//start Trigger_CheckUnique3 trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique3(&$tNG) {
  global $lang;
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("properties_client");
  $tblFldObj->addFieldName("telefono_movil_cli");
  $tblFldObj->setErrorMsg("The <b>Buyer</b> already exists (Phone 2): {telefono_movil_cli}");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique3 trigger

if (isset($_POST['b_sale_cli']) && $_POST['b_sale_cli'] != '' ) {
  $_POST['b_sale_cli'] = implode(',', $_POST['b_sale_cli']);
}
if (isset($_POST['b_type_cli']) && $_POST['b_type_cli'] != '' ) {
  $_POST['b_type_cli'] = implode(',', $_POST['b_type_cli']);
}
if (isset($_POST['b_loc1_cli']) && $_POST['b_loc1_cli'] != '' ) {
  $_POST['b_loc1_cli'] = implode(',', $_POST['b_loc1_cli']);
}
if (isset($_POST['b_loc2_cli']) && $_POST['b_loc2_cli'] != '' ) {
  $_POST['b_loc2_cli'] = implode(',', $_POST['b_loc2_cli']);
}
if (isset($_POST['b_loc3_cli']) && $_POST['b_loc3_cli'] != '' ) {
  $_POST['b_loc3_cli'] = implode(',', $_POST['b_loc3_cli']);
}
if (isset($_POST['b_loc4_cli']) && $_POST['b_loc4_cli'] != '' ) {
  $_POST['b_loc4_cli'] = implode(',', $_POST['b_loc4_cli']);
}
if (isset($_POST['b_ref_cli']) && $_POST['b_ref_cli'] != '' ) {
  $_POST['b_ref_cli'] = implode(',', $_POST['b_ref_cli']);
}
if (isset($_POST['b_opciones_cli']) && $_POST['b_opciones_cli'] != '' ) {
  $_POST['b_opciones_cli'] = implode(',', $_POST['b_opciones_cli']);
}
if (isset($_POST['b_opciones2_cli']) && $_POST['b_opciones2_cli'] != '' ) {
  $_POST['b_opciones2_cli'] = implode(',', $_POST['b_opciones2_cli']);
}
if (isset($_POST['b_tags_cli']) && $_POST['b_tags_cli'] != '' ) {
  $_POST['b_tags_cli'] = implode(',', $_POST['b_tags_cli']);
}
if (isset($_POST['b_ocultos_cli']) && $_POST['b_ocultos_cli'] != '' ) {
  $_POST['b_ocultos_cli'] = implode(',', $_POST['b_ocultos_cli']);
}
if (isset($_POST['visited_cli']) && $_POST['visited_cli'] != '' ) {
  $_POST['visited_cli'] = implode(',', $_POST['visited_cli']);
}
if (isset($_POST['b_pool_cli']) && $_POST['b_pool_cli'] != '' ) {
  $_POST['b_pool_cli'] = implode(',', $_POST['b_pool_cli']);
}
if (isset($_POST['b_parking_cli']) && $_POST['b_parking_cli'] != '' ) {
  $_POST['b_parking_cli'] = implode(',', $_POST['b_parking_cli']);
}
if (isset($_POST['b_costa_cli']) && $_POST['b_costa_cli'] != '' ) {
  $_POST['b_costa_cli'] = implode(',', $_POST['b_costa_cli']);
}

//start Trigger_AddToNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_AddToNewsletter(&$tNG) {
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaClients;
    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    if ($_POST['newsletter_cli'] == 1) {
        if ($_POST['email_cli'] != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $acumba->addSubscriber($acumbamailIdListaClients[$_POST['idioma_cli']], array(
              'email'  => $_POST['email_cli'],
              'nombre'  => $_POST['nombre_cli']
            ));
        }
    } else {
        
        $query_rsClint = "SELECT * FROM properties_client WHERE id_cli = '".$_GET['id_cli']."'";
        $rsClint = mysqli_query($inmoconn ,$query_rsClint) or die(mysqli_error());
        $row_rsClint = mysqli_fetch_assoc($rsClint);
        $totalRows_rsClint = mysqli_num_rows($rsClint);
        $email = $row_rsClint['email_cli'];
        if ($email != '') {
            $acumba = new AcumbamailAPI($keyAcumbamail);
            $miembros = $acumba->searchSubscriber($email);
            foreach ($miembros as $key => $value) {
                if ($acumbamailIdListaClients[$_POST['idioma_cli']] == $value['list_id']) {
                    $acumba = new AcumbamailAPI($keyAcumbamail);
                    $acumba->deleteSubscriber($acumbamailIdListaClients[$_POST['idioma_cli']], $value['email']);
                }
            }
        }
    }
}
//end Trigger_AddToNewsletter trigger

//start Trigger_DeletFromNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_DeletFromNewsletter(&$tNG) {
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaClients;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    
    $query_rsClint = "SELECT * FROM properties_client WHERE id_cli = '".$_GET['id_cli']."'";
    $rsClint = mysqli_query($inmoconn ,$query_rsClint) or die(mysqli_error());
    $row_rsClint = mysqli_fetch_assoc($rsClint);
    $totalRows_rsClint = mysqli_num_rows($rsClint);

    $email = $row_rsClint['email_cli'];
    $idioma = $row_rsClint['idioma_cli'];

    if ($email != '') {
        $acumba = new AcumbamailAPI($keyAcumbamail);
        $miembros = $acumba->searchSubscriber($email);
        foreach ($miembros as $key => $value) {
            if ($acumbamailIdListaClients[$idioma] == $value['list_id']) {
                $acumba = new AcumbamailAPI($keyAcumbamail);
                $acumba->deleteSubscriber($acumbamailIdListaClients[$idioma], $value['email']);
            }
        }
    }
}
//end Trigger_DeletFromNewsletter trigger


//start addFields trigger
//remove this line if you want to edit the code by hand
function addFields(&$tNG) {
  global $_SESSION;
  $tNG->addColumn("user_cli", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("fecha_alta_cli", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  if ($_SESSION['kt_login_level'] == 7) {
      $tNG->addColumn("atendido_por_cli", "NUMERIC_TYPE", "EXPRESSION", $_SESSION['kt_login_id']);
  }
  return $tNG->getError();
}
//end addFields trigger

//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog(&$tNG) {

  global $_SESSION;

  logBuyer($_SESSION['kt_login_id'], $tNG->getColumnValue('id_cli'), $tNG->getColumnValue('nombre_cli') . ' ' . $tNG->getColumnValue('apellidos_cli'), '1');

}
//end addLog trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog(&$tNG) {

  global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT * FROM properties_client WHERE id_cli = ".$_GET['id_cli'];
  $rsProp = mysqli_query($inmoconn ,$query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);


  logBuyer($_SESSION['kt_login_id'], $row_rsProp['id_cli'], $row_rsProp['nombre_cli'] . ' ' . $row_rsProp['apellidos_cli'], 2);

}
//end editLog trigger

//start deleteLog trigger
//remove this line if you want to edit the code by hand
function deleteLog(&$tNG) {

  global $_SESSION, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT * FROM properties_client WHERE id_cli = ".$_GET['id_cli'];
  $rsProp = mysqli_query($inmoconn ,$query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);

  logBuyer($_SESSION['kt_login_id'], $row_rsProp['id_cli'], $row_rsProp['nombre_cli'] . ' ' . $row_rsProp['apellidos_cli'], '5');

}
//end deleteLog trigger

//start Trigger_SendMails trigger
//remove this line if you want to edit the code by hand
function Trigger_SendMails(&$tNG) {

    global $_POST, $_SESSION, $oldprice, $database_inmoconn, $inmoconn, $mailColor, $langStr, $lang_adm, $nombreEmpresa, $direccionEmpresa, $urlstart, $urlStr;

    $query_rsCli = "SELECT atendido_por_cli, id_cli FROM properties_client WHERE id_cli = ".$tNG->getColumnValue('id_cli');
    $rsCli = mysqli_query($inmoconn,$query_rsCli) or die(mysqli_error());
    $row_rsCli = mysqli_fetch_assoc($rsCli);
    $totalRows_rsCli = mysqli_num_rows($rsCli);

  if($_SESSION['atendido_por_cli'] != $_POST['atendido_por_cli'] && $_POST['atendido_por_cli'] != '') {

      $query_rsUpdateDate = "UPDATE properties_client SET updated_cli = '" . date("Y-m-d H:i:s") . "' WHERE id_cli = " . $tNG->getColumnValue('id_cli');
      $rsUpdateDate = mysqli_query($inmoconn, $query_rsUpdateDate) or die(mysqli_error());

      $query_rsUserSend = "SELECT nombre_usr, email_usr, id_usr FROM users WHERE id_usr = ".$_POST['atendido_por_cli'];
      $rsUserSend = mysqli_query($inmoconn,$query_rsUserSend) or die(mysqli_error());
      $row_rsUserSend = mysqli_fetch_assoc($rsUserSend);
      $totalRows_rsUserSend = mysqli_num_rows($rsUserSend);

      if ($totalRows_rsUserSend > 0) {

        include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$lang_adm.".php");

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
        $html = ob_get_contents();
        ob_end_clean();

        $body  = '';
        $body .= '<!-- Título -->';
        $body .= '<tr>';
            $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
                $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                    $body .= '<h1 style="color: #222; font-size: 24px;">';
                        $body .= 'Se te ha asignado a un comprador / You have been assigned to a buyer';
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                        $body .= '<p>Hola <strong>'.@$row_rsUserSend['nombre_usr'].'</strong> / Hi <strong>'.@$row_rsUserSend['nombre_usr'].'</strong> </p>';
                        $body .= '<p>Se te ha asignado a un comprador / You have been assigned to a buyer</p>';
                        $body .= '<table border="0" cellpadding="15" cellspacing="0" class="templateButton" style="border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;background-color: #000000;border: 0;border-collapse: separate !important;">
                                      <tr>
                                          <td valign="middle" class="templateButtonContent">
                                              <div mc:edit="std_content01">
                                                  <a href="https://'.$_SERVER['HTTP_HOST'] . '/intramedianet/properties/clients-form.php?id_cli=' . $tNG->getColumnValue('id_cli') . '" target="_blank" style="color: #fbe022;font-family: Arial;font-size: 20px;font-weight: 400;letter-spacing: -.5px;line-height: 100%;text-align: center;text-decoration: none;text-transform: uppercase;text-decoration: none; color: #fff;">Ver comprador / View buyer</a>
                                              </div>
                                          </td>
                                      </tr>
                                  </table>';
                    $body .= '</div>';
                $body .= '</div>';
            $body .= '</td>';
        $body .= '</tr>';

        $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
        $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
        $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.';

        $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
        $html = preg_replace('/{CONTENT}/', $body , $html);
        $html = preg_replace('/{FOOTER}/', $footer, $html);
        $html = preg_replace('/{COLOR}/', $mailColor, $html);
        $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

        $subject = 'Se te ha asignado a un comprador / You have been assigned to a buyer - ' . $_SERVER['HTTP_HOST'];

        sendAppEmail($row_rsUserSend['email_usr'], '', '', '', $subject, $html);

      }

  }

}
//end Trigger_SendMails trigger

//start Trigger_SetOldValues trigger
//remove this line if you want to edit the code by hand
function Trigger_SetOldValues(&$tNG) {
  global $_POST, $_SESSION, $oldprice, $database_inmoconn, $inmoconn;

  $query_rsCli = "SELECT atendido_por_cli, id_cli FROM properties_client WHERE id_cli = ".$tNG->getColumnValue('id_cli');
  $rsCli = mysqli_query($inmoconn,$query_rsCli) or die(mysqli_error());
  $row_rsCli = mysqli_fetch_assoc($rsCli);
  $totalRows_rsCli = mysqli_num_rows($rsCli);

  $_SESSION['atendido_por_cli'] = $row_rsCli['atendido_por_cli'];
}
//end Trigger_SetOldValues trigger

// Make an insert transaction instance
$ins_properties_client = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_client);
// Register triggers
$ins_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_client->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_client->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
$ins_properties_client->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
$ins_properties_client->registerTrigger("BEFORE", "Trigger_CheckUnique2", 30);
$ins_properties_client->registerTrigger("BEFORE", "Trigger_CheckUnique3", 30);
if ($actMailchimp == 1) {
    $ins_properties_client->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
$ins_properties_client->registerTrigger("BEFORE", "addFields", 10);
$ins_properties_client->registerTrigger("AFTER", "addLog", 10);
// Add columns
$ins_properties_client->setTable("properties_client");
$ins_properties_client->addColumn("nombre_cli", "STRING_TYPE", "POST", "nombre_cli");
$ins_properties_client->addColumn("nombre2_cli", "STRING_TYPE", "POST", "nombre2_cli");
$ins_properties_client->addColumn("apellidos_cli", "STRING_TYPE", "POST", "apellidos_cli");
$ins_properties_client->addColumn("apellidos2_cli", "STRING_TYPE", "POST", "apellidos2_cli");
$ins_properties_client->addColumn("direccion_cli", "STRING_TYPE", "POST", "direccion_cli");
$ins_properties_client->addColumn("telefono_fijo_cli", "STRING_TYPE", "POST", "telefono_fijo_cli");
$ins_properties_client->addColumn("telefono_movil_cli", "STRING_TYPE", "POST", "telefono_movil_cli");
$ins_properties_client->addColumn("email_cli", "STRING_TYPE", "POST", "email_cli");
$ins_properties_client->addColumn("skype_cli", "STRING_TYPE", "POST", "skype_cli");
$ins_properties_client->addColumn("como_nos_conocio_cli", "STRING_TYPE", "POST", "como_nos_conocio_cli");
// $ins_properties_client->addColumn("captado_por_cli", "STRING_TYPE", "POST", "captado_por_cli");
$ins_properties_client->addColumn("captado_por2_cli", "STRING_TYPE", "POST", "captado_por2_cli");
$ins_properties_client->addColumn("fecha_alta_cli", "DATE_TYPE", "POST", "fecha_alta_cli", "{NOW}");
$ins_properties_client->addColumn("next_call_cli", "DATE_TYPE", "POST", "next_call_cli");
$ins_properties_client->addColumn("historial_cli", "STRING_TYPE", "POST", "historial_cli");
$ins_properties_client->addColumn("status_cli", "STRING_TYPE", "POST", "status_cli");
$ins_properties_client->addColumn("b_loc1_cli", "STRING_TYPE", "POST", "b_loc1_cli");
$ins_properties_client->addColumn("b_loc2_cli", "STRING_TYPE", "POST", "b_loc2_cli");
$ins_properties_client->addColumn("b_loc3_cli", "STRING_TYPE", "POST", "b_loc3_cli");
$ins_properties_client->addColumn("b_loc4_cli", "STRING_TYPE", "POST", "b_loc4_cli");
$ins_properties_client->addColumn("b_sale_cli", "STRING_TYPE", "POST", "b_sale_cli");
$ins_properties_client->addColumn("b_type_cli", "STRING_TYPE", "POST", "b_type_cli");
$ins_properties_client->addColumn("b_beds_cli", "STRING_TYPE", "POST", "b_beds_cli");
$ins_properties_client->addColumn("b_baths_cli", "STRING_TYPE", "POST", "b_baths_cli");
$ins_properties_client->addColumn("b_ref_cli", "STRING_TYPE", "POST", "b_ref_cli");
if ($actCostas == 1) 
{
  $ins_properties_client->addColumn("b_costa_cli", "STRING_TYPE", "POST", "b_costa_cli");
}
$ins_properties_client->addColumn("b_precio_desde_cli", "STRING_TYPE", "POST", "b_precio_desde_cli");
$ins_properties_client->addColumn("b_precio_hasta_cli", "STRING_TYPE", "POST", "b_precio_hasta_cli");
$ins_properties_client->addColumn("b_opciones_cli", "STRING_TYPE", "POST", "b_opciones_cli");
$ins_properties_client->addColumn("b_opciones2_cli", "STRING_TYPE", "POST", "b_opciones2_cli");
$ins_properties_client->addColumn("b_tags_cli", "STRING_TYPE", "POST", "b_tags_cli");
$ins_properties_client->addColumn("b_pool_cli", "STRING_TYPE", "POST", "b_pool_cli");
$ins_properties_client->addColumn("b_parking_cli", "STRING_TYPE", "POST", "b_parking_cli");
$ins_properties_client->addColumn("b_m2_desde_cli", "STRING_TYPE", "POST", "b_m2_desde_cli");
$ins_properties_client->addColumn("b_m2_hasta_cli", "STRING_TYPE", "POST", "b_m2_hasta_cli");
$ins_properties_client->addColumn("b_m2p_desde_cli", "STRING_TYPE", "POST", "b_m2p_desde_cli");
$ins_properties_client->addColumn("b_m2p_hasta_cli", "STRING_TYPE", "POST", "b_m2p_hasta_cli");
if ($_SESSION['kt_login_level'] != 7) {
  $ins_properties_client->addColumn("atendido_por_cli", "STRING_TYPE", "POST", "atendido_por_cli");
}
if ($actSaveSearch == 1)
{
    $ins_properties_client->addColumn("usuario_cli", "CHECKBOX_1_0_TYPE", "POST", "usuario_cli", "0"); /////// AÑADIR DB BUSQUEDAS
}

// $ins_properties_client->addColumn("b_ocultos_cli", "STRING_TYPE", "POST", "b_ocultos_cli");
$ins_properties_client->addColumn("nie_cli", "STRING_TYPE", "POST", "nie_cli");
$ins_properties_client->addColumn("pasaporte_cli", "STRING_TYPE", "POST", "pasaporte_cli");
$ins_properties_client->addColumn("residencia_fiscal_cli", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_cli", "0");
$ins_properties_client->addColumn("ha_comprado_cli", "CHECKBOX_1_0_TYPE", "POST", "ha_comprado_cli", "0");
$ins_properties_client->addColumn("ref_comprado_cli", "STRING_TYPE", "POST", "ref_comprado_cli");
if ($actMailchimp == 1) {
    $ins_properties_client->addColumn("newsletter_cli", "CHECKBOX_1_0_TYPE", "POST", "newsletter_cli", "1");
}
$ins_properties_client->addColumn("atendido_cli", "CHECKBOX_1_0_TYPE", "POST", "atendido_cli", "1");
$ins_properties_client->addColumn("archived_cli", "CHECKBOX_1_0_TYPE", "POST", "archived_cli", "0");
$ins_properties_client->addColumn("send_props_cli", "CHECKBOX_1_0_TYPE", "POST", "send_props_cli", "0");
$ins_properties_client->addColumn("nacionalidad_cli", "STRING_TYPE", "POST", "nacionalidad_cli");
$ins_properties_client->addColumn("notas_cli", "STRING_TYPE", "POST", "notas_cli");
$ins_properties_client->addColumn("b_orientacion_cli", "STRING_TYPE", "POST", "b_orientacion_cli");
$ins_properties_client->addColumn("puntuacion_cli", "STRING_TYPE", "POST", "puntuacion_cli", "0");
$ins_properties_client->addColumn("visited_cli", "STRING_TYPE", "POST", "visited_cli");
$ins_properties_client->addColumn("idioma_cli", "STRING_TYPE", "POST", "idioma_cli");

$ins_properties_client->addColumn("b_dist_beach_val_cli", "STRING_TYPE", "POST", "b_dist_beach_val_cli");
$ins_properties_client->addColumn("b_dist_beach_from_cli", "STRING_TYPE", "POST", "b_dist_beach_from_cli");
$ins_properties_client->addColumn("b_dist_beach_to_cli", "STRING_TYPE", "POST", "b_dist_beach_to_cli");
$ins_properties_client->addColumn("b_dist_amenit_val_cli", "STRING_TYPE", "POST", "b_dist_amenit_val_cli");
$ins_properties_client->addColumn("b_dist_amenit_from_cli", "STRING_TYPE", "POST", "b_dist_amenit_from_cli");
$ins_properties_client->addColumn("b_dist_amenit_to_cli", "STRING_TYPE", "POST", "b_dist_amenit_to_cli");
$ins_properties_client->addColumn("b_dist_airport_val_cli", "STRING_TYPE", "POST", "b_dist_airport_val_cli");
$ins_properties_client->addColumn("b_dist_airport_from_cli", "STRING_TYPE", "POST", "b_dist_airport_from_cli");
$ins_properties_client->addColumn("b_dist_airport_to_cli", "STRING_TYPE", "POST", "b_dist_airport_to_cli");
$ins_properties_client->addColumn("b_dist_golf_val_cli", "STRING_TYPE", "POST", "b_dist_golf_val_cli");
$ins_properties_client->addColumn("b_dist_golf_from_cli", "STRING_TYPE", "POST", "b_dist_golf_from_cli");
$ins_properties_client->addColumn("b_dist_golf_to_cli", "STRING_TYPE", "POST", "b_dist_golf_to_cli");

$ins_properties_client->addColumn("buy_agen_cli", "CHECKBOX_1_0_TYPE", "POST", "buy_agen_cli", "0");
$ins_properties_client->addColumn("agen_cli", "STRING_TYPE", "POST", "agen_cli");
$ins_properties_client->addColumn("comment_cli", "STRING_TYPE", "POST", "comment_cli");
$ins_properties_client->addColumn("telefono_fijo2_cli", "STRING_TYPE", "POST", "telefono_fijo2_cli");

if ($actFerias == 1)
{
  $ins_properties_client->addColumn("nombre2_cli", "STRING_TYPE", "POST", "nombre2_cli");
  $ins_properties_client->addColumn("apellidos2_cli", "STRING_TYPE", "POST", "apellidos2_cli");

  $ins_properties_client->addColumn("birthday_cli", "DATE_TYPE", "POST", "birthday_cli");
  $ins_properties_client->addColumn("birthday2_cli", "DATE_TYPE", "POST", "birthday2_cli");
  $ins_properties_client->addColumn("situation_cli", "STRING_TYPE", "POST", "situation_cli");
  $ins_properties_client->addColumn("mortgage_location_cli", "STRING_TYPE", "POST", "mortgage_location_cli");
  $ins_properties_client->addColumn("percentage_mortgage_cli", "STRING_TYPE", "POST", "percentage_mortgage_cli");
  $ins_properties_client->addColumn("mortgage_amount_cli", "STRING_TYPE", "POST", "mortgage_amount_cli");
  $ins_properties_client->addColumn("current_gross_cli", "STRING_TYPE", "POST", "current_gross_cli");
  $ins_properties_client->addColumn("current_partner_cli", "STRING_TYPE", "POST", "current_partner_cli");
  $ins_properties_client->addColumn("resources_cli", "STRING_TYPE", "POST", "resources_cli");
  $ins_properties_client->addColumn("extrainfo_cli", "STRING_TYPE", "POST", "extrainfo_cli");
  $ins_properties_client->addColumn("current_home_cli", "STRING_TYPE", "POST", "current_home_cli");
  $ins_properties_client->addColumn("financing_cli", "CHECKBOX_1_0_TYPE", "POST", "financing_cli", "0");
}

$ins_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_client = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_client);
// Register triggers
$upd_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_properties_client->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_properties_client->registerConditionalTrigger("{POST.KT_Update2} != \"\"", "END", "Trigger_Redirect", 90);
$upd_properties_client->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
$upd_properties_client->registerTrigger("BEFORE", "Trigger_CheckUnique2", 30);
$upd_properties_client->registerTrigger("BEFORE", "Trigger_CheckUnique3", 30);
$upd_properties_client->registerTrigger("BEFORE", "editLog", 10);
$upd_properties_client->registerTrigger("BEFORE", "Trigger_SetOldValues", 50);
$upd_properties_client->registerTrigger("AFTER", "Trigger_SendMails", 60);
if ($actMailchimp == 1) {
    $upd_properties_client->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
// Add columns
$upd_properties_client->setTable("properties_client");
$upd_properties_client->addColumn("nombre_cli", "STRING_TYPE", "POST", "nombre_cli");
$upd_properties_client->addColumn("nombre2_cli", "STRING_TYPE", "POST", "nombre2_cli");
$upd_properties_client->addColumn("apellidos_cli", "STRING_TYPE", "POST", "apellidos_cli");
$upd_properties_client->addColumn("apellidos2_cli", "STRING_TYPE", "POST", "apellidos2_cli");
$upd_properties_client->addColumn("direccion_cli", "STRING_TYPE", "POST", "direccion_cli");
$upd_properties_client->addColumn("telefono_fijo_cli", "STRING_TYPE", "POST", "telefono_fijo_cli");
$upd_properties_client->addColumn("telefono_movil_cli", "STRING_TYPE", "POST", "telefono_movil_cli");
$upd_properties_client->addColumn("email_cli", "STRING_TYPE", "POST", "email_cli");
$upd_properties_client->addColumn("skype_cli", "STRING_TYPE", "POST", "skype_cli");
$upd_properties_client->addColumn("como_nos_conocio_cli", "STRING_TYPE", "POST", "como_nos_conocio_cli");
// $upd_properties_client->addColumn("captado_por_cli", "STRING_TYPE", "POST", "captado_por_cli");
$upd_properties_client->addColumn("captado_por2_cli", "STRING_TYPE", "POST", "captado_por2_cli");
$upd_properties_client->addColumn("fecha_alta_cli", "DATE_TYPE", "POST", "fecha_alta_cli");
$upd_properties_client->addColumn("next_call_cli", "DATE_TYPE", "POST", "next_call_cli");
$upd_properties_client->addColumn("historial_cli", "STRING_TYPE", "POST", "historial_cli");
$upd_properties_client->addColumn("status_cli", "STRING_TYPE", "POST", "status_cli");
$upd_properties_client->addColumn("b_loc1_cli", "STRING_TYPE", "POST", "b_loc1_cli");
$upd_properties_client->addColumn("b_loc2_cli", "STRING_TYPE", "POST", "b_loc2_cli");
$upd_properties_client->addColumn("b_loc3_cli", "STRING_TYPE", "POST", "b_loc3_cli");
$upd_properties_client->addColumn("b_loc4_cli", "STRING_TYPE", "POST", "b_loc4_cli");
$upd_properties_client->addColumn("b_sale_cli", "STRING_TYPE", "POST", "b_sale_cli");
$upd_properties_client->addColumn("b_type_cli", "STRING_TYPE", "POST", "b_type_cli");
$upd_properties_client->addColumn("b_beds_cli", "STRING_TYPE", "POST", "b_beds_cli");
$upd_properties_client->addColumn("b_baths_cli", "STRING_TYPE", "POST", "b_baths_cli");
$upd_properties_client->addColumn("b_ref_cli", "STRING_TYPE", "POST", "b_ref_cli");
$upd_properties_client->addColumn("b_precio_desde_cli", "STRING_TYPE", "POST", "b_precio_desde_cli");
$upd_properties_client->addColumn("b_precio_hasta_cli", "STRING_TYPE", "POST", "b_precio_hasta_cli");
$upd_properties_client->addColumn("b_opciones_cli", "STRING_TYPE", "POST", "b_opciones_cli");
$upd_properties_client->addColumn("b_opciones2_cli", "STRING_TYPE", "POST", "b_opciones2_cli");
$upd_properties_client->addColumn("b_tags_cli", "STRING_TYPE", "POST", "b_tags_cli");
$upd_properties_client->addColumn("b_pool_cli", "STRING_TYPE", "POST", "b_pool_cli");
$upd_properties_client->addColumn("b_parking_cli", "STRING_TYPE", "POST", "b_parking_cli");
$upd_properties_client->addColumn("b_m2_desde_cli", "STRING_TYPE", "POST", "b_m2_desde_cli");
$upd_properties_client->addColumn("b_m2_hasta_cli", "STRING_TYPE", "POST", "b_m2_hasta_cli");
$upd_properties_client->addColumn("b_m2p_desde_cli", "STRING_TYPE", "POST", "b_m2p_desde_cli");
$upd_properties_client->addColumn("b_m2p_hasta_cli", "STRING_TYPE", "POST", "b_m2p_hasta_cli");
if ($actCostas == 1) 
{
    $upd_properties_client->addColumn("b_costa_cli", "STRING_TYPE", "POST", "b_costa_cli");
}
if ($_SESSION['kt_login_level'] != 7) {
  $upd_properties_client->addColumn("atendido_por_cli", "STRING_TYPE", "POST", "atendido_por_cli");
}
if ($actSaveSearch == 1)
{
    $upd_properties_client->addColumn("usuario_cli", "CHECKBOX_1_0_TYPE", "POST", "usuario_cli"); /////// AÑADIR DB BUSQUEDAS
}

// $upd_properties_client->addColumn("b_ocultos_cli", "STRING_TYPE", "POST", "b_ocultos_cli");
$upd_properties_client->addColumn("nie_cli", "STRING_TYPE", "POST", "nie_cli");
$upd_properties_client->addColumn("pasaporte_cli", "STRING_TYPE", "POST", "pasaporte_cli");
$upd_properties_client->addColumn("residencia_fiscal_cli", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_cli");
$upd_properties_client->addColumn("ha_comprado_cli", "CHECKBOX_1_0_TYPE", "POST", "ha_comprado_cli", "0");
$upd_properties_client->addColumn("ref_comprado_cli", "STRING_TYPE", "POST", "ref_comprado_cli");
if ($actMailchimp == 1) {
    $upd_properties_client->addColumn("newsletter_cli", "CHECKBOX_1_0_TYPE", "POST", "newsletter_cli");
}
$upd_properties_client->addColumn("atendido_cli", "CHECKBOX_1_0_TYPE", "POST", "atendido_cli");
$upd_properties_client->addColumn("archived_cli", "CHECKBOX_1_0_TYPE", "POST", "archived_cli");
$upd_properties_client->addColumn("send_props_cli", "CHECKBOX_1_0_TYPE", "POST", "send_props_cli");
$upd_properties_client->addColumn("user_cli", "STRING_TYPE", "CURRVAL", "user_cli");
$upd_properties_client->addColumn("nacionalidad_cli", "STRING_TYPE", "POST", "nacionalidad_cli");
$upd_properties_client->addColumn("notas_cli", "STRING_TYPE", "POST", "notas_cli");
$upd_properties_client->addColumn("b_orientacion_cli", "STRING_TYPE", "POST", "b_orientacion_cli");
$upd_properties_client->addColumn("puntuacion_cli", "STRING_TYPE", "POST", "puntuacion_cli");
$upd_properties_client->addColumn("visited_cli", "STRING_TYPE", "POST", "visited_cli");
$upd_properties_client->addColumn("idioma_cli", "STRING_TYPE", "POST", "idioma_cli");

$upd_properties_client->addColumn("b_dist_beach_val_cli", "STRING_TYPE", "POST", "b_dist_beach_val_cli");
$upd_properties_client->addColumn("b_dist_beach_from_cli", "STRING_TYPE", "POST", "b_dist_beach_from_cli");
$upd_properties_client->addColumn("b_dist_beach_to_cli", "STRING_TYPE", "POST", "b_dist_beach_to_cli");
$upd_properties_client->addColumn("b_dist_amenit_val_cli", "STRING_TYPE", "POST", "b_dist_amenit_val_cli");
$upd_properties_client->addColumn("b_dist_amenit_from_cli", "STRING_TYPE", "POST", "b_dist_amenit_from_cli");
$upd_properties_client->addColumn("b_dist_amenit_to_cli", "STRING_TYPE", "POST", "b_dist_amenit_to_cli");
$upd_properties_client->addColumn("b_dist_airport_val_cli", "STRING_TYPE", "POST", "b_dist_airport_val_cli");
$upd_properties_client->addColumn("b_dist_airport_from_cli", "STRING_TYPE", "POST", "b_dist_airport_from_cli");
$upd_properties_client->addColumn("b_dist_airport_to_cli", "STRING_TYPE", "POST", "b_dist_airport_to_cli");
$upd_properties_client->addColumn("b_dist_golf_val_cli", "STRING_TYPE", "POST", "b_dist_golf_val_cli");
$upd_properties_client->addColumn("b_dist_golf_from_cli", "STRING_TYPE", "POST", "b_dist_golf_from_cli");
$upd_properties_client->addColumn("b_dist_golf_to_cli", "STRING_TYPE", "POST", "b_dist_golf_to_cli");

$upd_properties_client->addColumn("buy_agen_cli", "CHECKBOX_1_0_TYPE", "POST", "buy_agen_cli", "0");
$upd_properties_client->addColumn("agen_cli", "STRING_TYPE", "POST", "agen_cli");
$upd_properties_client->addColumn("comment_cli", "STRING_TYPE", "POST", "comment_cli");
$upd_properties_client->addColumn("telefono_fijo2_cli", "STRING_TYPE", "POST", "telefono_fijo2_cli");

if ($actFerias == 1)
{
  $upd_properties_client->addColumn("nombre2_cli", "STRING_TYPE", "POST", "nombre2_cli");
  $upd_properties_client->addColumn("apellidos2_cli", "STRING_TYPE", "POST", "apellidos2_cli");
  $upd_properties_client->addColumn("birthday_cli", "DATE_TYPE", "POST", "birthday_cli");
  $upd_properties_client->addColumn("birthday2_cli", "DATE_TYPE", "POST", "birthday2_cli");
  $upd_properties_client->addColumn("situation_cli", "STRING_TYPE", "POST", "situation_cli");
  $upd_properties_client->addColumn("mortgage_location_cli", "STRING_TYPE", "POST", "mortgage_location_cli");
  $upd_properties_client->addColumn("percentage_mortgage_cli", "STRING_TYPE", "POST", "percentage_mortgage_cli");
  $upd_properties_client->addColumn("mortgage_amount_cli", "STRING_TYPE", "POST", "mortgage_amount_cli");
  $upd_properties_client->addColumn("current_gross_cli", "STRING_TYPE", "POST", "current_gross_cli");
  $upd_properties_client->addColumn("current_partner_cli", "STRING_TYPE", "POST", "current_partner_cli");
  $upd_properties_client->addColumn("resources_cli", "STRING_TYPE", "POST", "resources_cli");
  $upd_properties_client->addColumn("extrainfo_cli", "STRING_TYPE", "POST", "extrainfo_cli");
  $upd_properties_client->addColumn("current_home_cli", "STRING_TYPE", "POST", "current_home_cli");
  $upd_properties_client->addColumn("financing_cli", "CHECKBOX_1_0_TYPE", "POST", "financing_cli");
}

$upd_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE", "GET", "id_cli");

// Make an instance of the transaction object
$del_properties_client = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_client);
// Register triggers
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../intramedianet/properties/clients.php?KT_back=1");
$del_properties_client->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
$del_properties_client->registerTrigger("BEFORE", "Trigger_DeletFromNewsletter", 10);
$del_properties_client->registerTrigger("BEFORE", "deleteLog", 99);
// Add columns
$del_properties_client->setTable("properties_client");
$del_properties_client->addColumn("email_cli", "STRING_TYPE", "POST", "email_cli");
$del_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE", "GET", "id_cli");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_client = $tNGs->getRecordset("properties_client");
$row_rsproperties_client = mysqli_fetch_assoc($rsproperties_client);
$totalRows_rsproperties_client = mysqli_num_rows($rsproperties_client);

if(isset($_GET['id_cli'])){
$query_rsUpdate = "
    SELECT
    updated_cli
    FROM properties_client
    WHERE id_cli = '".$_GET['id_cli']."'
";
$rsUpdate = $inmoconn->query($query_rsUpdate); if(!$rsUpdate) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsUpdate = mysqli_fetch_assoc($rsUpdate);
$totalRows_rsUpdate = mysqli_num_rows($rsUpdate);
}else{
    $row_rsUpdate = array();
    $totalRows_rsUpdate = 0;
}


$query_rsEmails = "
SELECT
properties_log_mails.id_log,
GROUP_CONCAT(properties_properties.id_prop) as id_prop,
GROUP_CONCAT(properties_properties.referencia_prop) as referencia_prop,
properties_log_mails.type_log,
properties_log_mails.result_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
LEFT OUTER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
WHERE email_log = '".$row_rsproperties_client['email_cli']."'  AND email_log != ''
GROUP BY date_log
ORDER BY date_log DESC
";
$rsEmails = mysqli_query($inmoconn ,$query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);

if(isset($_GET['id_cli'])){
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
WHERE users_ct = '".$_GET['id_cli']."'
 ORDER BY inicio_ct DESC
";
$rsEvents = mysqli_query($inmoconn ,$query_rsEvents) or die(mysqli_error());
$row_rsEvents = mysqli_fetch_assoc($rsEvents);
$totalRows_rsEvents = mysqli_num_rows($rsEvents);
}else{
    $row_rsEvents = array();
    $totalRows_rsEvents = 0;
}

if(isset($_GET['id_cli'])){
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
WHERE contact_type_tsk = 2 AND contact_tsk = '".$_GET['id_cli']."'
 ORDER BY id_tsk DESC
";
$rsTasks = mysqli_query($inmoconn ,$query_rsTasks) or die(mysqli_error());
$row_rsTasks = mysqli_fetch_assoc($rsTasks);
$totalRows_rsTasks = mysqli_num_rows($rsTasks);
}else{
    $row_rsTasks = array();
    $totalRows_rsTasks = 0;
}

if(isset($_GET['id_cli'])){
$query_rsHistorial = "
SELECT
users.nombre_usr,
properties_client_log.referencia_log,
properties_client_log.action_log,
properties_client_log.date_log,
properties_client_log.id_log
FROM properties_client_log LEFT OUTER JOIN users ON properties_client_log.user_log = users.id_usr
WHERE prop_id_log = '".$_GET['id_cli']."'
ORDER BY date_log DESC
";
$rsHistorial = mysqli_query($inmoconn ,$query_rsHistorial) or die(mysqli_error());
$row_rsHistorial = mysqli_fetch_assoc($rsHistorial);
$totalRows_rsHistorial = mysqli_num_rows($rsHistorial);
}else{
    $row_rsHistorial = array();
    $totalRows_rsHistorial = 0;
}


if ($actSaveSearch == 1)
{
  //////////////////////////////////////////// BUSQUEDAS


  
  $query_rsXXX = "SELECT id_usr FROM users WHERE email_usr = '".$row_rsproperties_client['email_cli']."' ";
  $rsXXX = mysqli_query($inmoconn ,$query_rsXXX) or die(mysqli_error());
  $row_rsXXX = mysqli_fetch_assoc($rsXXX);
  $totalRows_rsXXX = mysqli_num_rows($rsXXX);

  $searchs = array();
  if($row_rsXXX){
    $querySearch = "
    SELECT
        id,
        user,
        query,
        send,
        created,
        last
    FROM users_searchs
    WHERE user = '" . mysqli_real_escape_string($inmoconn,$row_rsXXX['id_usr']) . "'
    ORDER BY created DESC
    ";
    $searchs = getRecords($querySearch);
  }

  foreach ($searchs as $key => $value) {
      if ($value['query']) {
          array_push($searchs[$key], json_decode($value['query']));
      }
  }

  function getStatus($id) {
      global $lang_adm;
      $return = getRecords("
          SELECT
              status_" . $lang_adm . "_sta as ret
          FROM properties_status
          WHERE id_sta = '" . $id . "'
      ");
      return $return[0]['ret'];
  }

  function getTypeSRCH($id) {
      global $lang_adm;
      $return = getRecords("
          SELECT
              types_" . $lang_adm . "_typ as ret
          FROM properties_types
          WHERE id_typ = '" . $id . "'
      ");
      return $return[0]['ret'];
  }

  function getTypeTown($id) {
      global $lang_adm;
      $return = getRecords("
          SELECT
              name_" . $lang_adm . "_loc3 as ret
          FROM properties_loc3
          WHERE id_loc3 = '" . $id . "'
      ");
      return $return[0]['ret'];
  }

  function getTypeProv($id) {
      global $lang_adm;
      $return = getRecords("
          SELECT
              name_" . $lang_adm . "_loc2 as ret
          FROM properties_loc2
          WHERE id_loc2 = '" . $id . "'
      ");
      return $return[0]['ret'];
  }
  function getCoast($id) {
      global $lang_adm;
      $return = getRecords("
          SELECT
              coast_" . $lang_adm . "_cst as ret
          FROM properties_coast
          WHERE id_cst = '" . $id . "'
      ");
      return $return[0]['ret'];
  }
  function getTypeZone($id) {
      global $lang_adm;
      $return = getRecords("
          SELECT
              name_" . $lang_adm . "_loc4 as ret
          FROM properties_loc4
          WHERE id_loc4 = '" . $id . "'
      ");
      return $return[0]['ret'];
  }


  function getTypePool($id) {
      global $lang_adm;
      $return = getRecords("
          SELECT
              pool_" . $lang_adm . "_pl as ret
          FROM properties_pool
          WHERE id_pl = '" . $id . "'
      ");
      return $return[0]['ret'];
  }

  //////////////////////////////////////////// BUSQUEDAS END

}


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

  <style>
      #emails-table_filter label {
        background: #efefef;
        padding: 10px;
      }
      #emails-table_filter input {
        min-width: 400px;
        max-width: 100%;
      }
  </style>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_client" class="id_field" value="<?php if(isset($row_rsproperties_client['kt_pk_properties_client'])) echo KT_escapeAttribute($row_rsproperties_client['kt_pk_properties_client']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <!-- <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-house-person-return"></i> <?php echo __('Clientes'); ?></h4> -->

                        <div class="flex-md-grow-1 d-md-block" id="tabs-header-fix">

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills card-header-pills" role="tablist" id="proptabs">
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary active" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabbuyer" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Cliente'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabnotes" role="tab" aria-selected="true">
                                        <?php __('Notas'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabsearch" role="tab" aria-selected="true" id="criteriaTab">
                                        <?php __('Cruce'); ?>
                                        <span class="badge bg-info countlistnews2 d-none d-md-inline-block" style="padding-top: 5px">0</span>
                                        <span class="badge bg-success countlistint2 d-none d-md-inline-block" style="padding-top: 5px">0</span>
                                        <span class="badge bg-danger countlistintno2 d-none d-md-inline-block" style="padding-top: 5px">0</span>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" href="" id="sendmailTab">
                                        <?php __('Enviar'); ?> <?php __('Email'); ?>
                                    </a>
                                </li>
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabinfo" role="tab" aria-selected="false" tabindex="-1">
                                        <?php __('Informes'); ?>
                                    </a>
                                </li>
                                <?php if ($actSaveSearch == 1):?>
                                 <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabsearches" role="tab" aria-selected="true">
                                        <?php __('Búsquedas guardadas'); ?>
                                    </a>
                                </li>
                                <?php endif?>
                                <?php 
                                //ferias
                                if (isset($row_rsFairs['feria_cli']) && $row_rsFairs['feria_cli'] == 1): ?>         
                                <li class="nav-item mt-2 mt-md-0" role="presentation">
                                    <a class="nav-link px-2 py-1 fw-ligther border ms-2 border-primary" style="font-size: 12px!important;" data-bs-toggle="tab" href="#tabferias" role="tab" aria-selected="true">
                                        <?php __('Ferias'); ?> & <?php __('Eventos'); ?>
                                    </a>
                                </li>
                                <?php endif ?>

                            </ul>

                        </div>

                        <div class="flex-grow-1 prop-nav-sep d-none d-md-flex text-white"><i class="fa-regular fa-pipe mx-5"></i></div>

                        <div class="flex-md-shrink-0 d-md-block">
                            <?php if (@$_GET['id_cli'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="mt-2 mt-md-0 btn btn-success btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?></span></button>
                                <button type="submit" name="KT_Insert2" id="KT_Insert2" class="mt-2 mt-md-0 btn btn-primary btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?> <?php echo $lang['y Seguir Editando'] ?></span></button>
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php __("Guardar"); ?></span></button>
                                <button type="submit" name="KT_Update2" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-primary btn-sm"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                                <button type="submit" name="KT_Delete1" id="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 mt-2 mt-md-0 btn btn-danger btn-sm"><i class="fa-regular fa-trash-can fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Delete_FB"); ?></span></button>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="mt-2 mt-md-0 btn btn-soft-primary btn-sm"><i class="fa-regular fa-chevron-left fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>
                        </div>
                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <?php if (isset($_GET['u']) && $_GET['u'] == 'ok') { ?>
                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-check label-icon"></i> <?php echo $lang['El cliente se ha guardado correctamente'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <?php
                if(isset($_GET['id_cli'])){
                $query_rsNomolestar = "SELECT no_molestar_cli FROM properties_client WHERE id_cli = '".$_GET['id_cli']."'";
                $rsNomolestar = mysqli_query($inmoconn ,$query_rsNomolestar) or die(mysqli_error());
                $row_rsNomolestar = mysqli_fetch_assoc($rsNomolestar);
                if (isset($row_rsNomolestar['no_molestar_cli']) && $row_rsNomolestar['no_molestar_cli'] == 1) { ?>
                    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-exclamation label-icon"></i> <?php echo $lang['Aviso no email'] ?>
                    </div>
                <?php } }?>

                <div class="tab-cont">

                    <div class="tab-content">

                        <div class="tab-pane active" id="tabbuyer">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Cliente'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nombre_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="nombre_cli" class="form-label"><?php __('Nombre'); ?>:</label>
                                                <input type="text" name="nombre_cli" id="nombre_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['nombre_cli']); ?>" size="32" maxlength="255" class="form-control required" required>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                  <?php echo $tNGs->displayFieldError("properties_client", "nombre_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "apellidos_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="apellidos_cli" class="form-label"><?php __('Apellidos'); ?>:</label>
                                                <input type="text" name="apellidos_cli" id="apellidos_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['apellidos_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "apellidos_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-check form-switch form-switch-lg pt-0 mt-lg-4 mt-2 mb-2" dir="ltr">
                                                <input type="checkbox" name="atendido_cli" id="atendido_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['atendido_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['atendido_cli']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="atendido_cli"><?php __('Atendido'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_client", "atendido_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-check form-switch form-switch-lg pt-0 mt-lg-4 mt-2 mb-2" dir="ltr">
                                                <input type="checkbox" name="archived_cli" id="archived_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['archived_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['archived_cli']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="archived_cli"><?php __('Archivar cliente'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_client", "archived_cli"); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "telefono_fijo_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="telefono_fijo_cli" class="form-label"><?php __('Teléfono'); ?> 1:</label>
                                                <input type="number"  step="1" min="1" name="telefono_fijo_cli" id="telefono_fijo_cli" value="<?php echo KT_escapeAttribute(limpiarTelefono($row_rsproperties_client['telefono_fijo_cli'])); ?>" size="32" maxlength="255" class="form-control number">
                                                <?php echo $tNGs->displayFieldError("properties_client", "telefono_fijo_cli"); ?>
                                                <a href="https://api.whatsapp.com/send/?phone=<?php echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo_cli']); ?>" class="btn btn-success btn-sm ms-2 d-inline-block" style="border-radius: 0 0 5px 5px;" target="blank">Whatsapp</a> <small class="text-muted"><?php __('Sin + con prefijo del país y sin espacios'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "email_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="email_cli" class="form-label"><?php __('Email'); ?> 1:</label>
                                                <input type="text" name="email_cli" id="email_cli" value="<?php if(isset($row_rsproperties_client['email_cli'])) echo trim(KT_escapeAttribute($row_rsproperties_client['email_cli'])); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "email_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="row">
                                              <?php if ($actMailchimp == 1): ?>
                                               <div class="col-md-4">
                                                  
                                                  <div class="form-check form-switch form-switch-lg pt-0 mt-md-4" dir="ltr">
                                                      <input type="checkbox" name="newsletter_cli" id="newsletter_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['newsletter_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['newsletter_cli']),"1"))) {echo "checked";} ?>>
                                                      <label class="form-check-label" for="newsletter_cli"><?php __('Añadir a la newsletter'); ?></label>
                                                      <?php echo $tNGs->displayFieldError("properties_client", "newsletter_cli"); ?>
                                                  </div>
                                                  
                                              </div>
                                              <?php endif ?>
                                              <?php if ($activarMailWeekly == 1): ?>
                                              <div class="col-md-4">
                                                  
                                                  <div class="form-check form-switch form-switch-lg pt-4 mt-md-0 mb-4 mb-md-0" dir="ltr">
                                                      <input type="checkbox" name="send_props_cli" id="send_props_cli" value="1" class="form-check-input" <?php if(isset($row_rsproperties_client['send_props_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['send_props_cli']),"1"))) {echo "checked";} ?>>
                                                      <label class="form-check-label" for="send_props_cli"><?php __('Email semanal'); ?></label>
                                                      <?php echo $tNGs->displayFieldError("properties_client", "send_props_cli"); ?>
                                                  </div>
                                                  
                                              </div>
                                              <?php endif ?>
                                              <?php if ($actSaveSearch == 1):?>
                                               <div class="col-md-4">
                                                    <div class="form-check form-switch form-switch-lg pt-4 mt-md-0 mb-4 mb-md-0" dir="ltr">
                                                         <input type="checkbox" name="usuario_cli" id="usuario_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['usuario_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['usuario_cli']),"1"))) {echo "checked";} ?>>
                                                          <label class="form-check-label" for="usuario_cli"><?php __('Registrado'); ?></label>
                                                           <?php echo $tNGs->displayFieldError("properties_client", "usuario_cli"); ?>
                                                      </div>
                                                </div>
                                               <?php endif?>
                                             </div>
                                        </div>
                                        
                                    </div>


                                    <div class="row">

                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nombre2_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="nombre2_cli" class="form-label"><?php __('Nombre'); ?> 2:</label>
                                                <input type="text" name="nombre2_cli" id="nombre2_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['nombre2_cli']); ?>" size="32" maxlength="255" class="form-control"  >
                                               
                                                  <?php echo $tNGs->displayFieldError("properties_client", "nombre2_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "apellidos2_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="apellidos2_cli" class="form-label"><?php __('Apellidos'); ?> 2:</label>
                                                <input type="text" name="apellidos2_cli" id="apellidos2_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['apellidos2_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "apellidos2_cli"); ?>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "telefono_fijo2_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="telefono_fijo2_cli" class="form-label"><?php __('Teléfono'); ?> 2:</label>
                                                <input type="number"  name="telefono_fijo2_cli" id="telefono_fijo2_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo2_cli']); ?>" size="32" maxlength="255" class="form-control number">
                                                <?php echo $tNGs->displayFieldError("properties_client", "telefono_fijo2_cli"); ?>
                                                <a href="https://api.whatsapp.com/send/?phone=<?php echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo2_cli']); ?>" class="btn btn-success btn-sm ms-2 d-inline-block" style="border-radius: 0 0 5px 5px;" target="blank">Whatsapp</a> <small class="text-muted"><?php __('Sin + con prefijo del país y sin espacios'); ?></small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "skype_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="skype_cli" class="form-label"><?php __('Skype'); ?>:</label>
                                                <input type="text" name="skype_cli" id="skype_cli" value="<?php if(isset($row_rsproperties_client['skype_cli'])) echo trim(KT_escapeAttribute($row_rsproperties_client['skype_cli'])); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "skype_cli"); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="bg-light py-1 pt-4 px-4 mb-4 mt-n3 rounded-4" style="background-color: rgba(10, 179, 156, 0.1) !important;">

                                          <div class="row">
                                              <div class="col-md-3">
                                                  <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "status_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="status_cli" class="form-label"><?php __('Estatus'); ?>:</label>
                                                            <div class="controls">
                                                                <select name="status_cli" id="status_cli" class="select2">
                                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                                    <?php do { if(isset($row_rsStatus['id_sts'])){?>
                                                                    <option value="<?php echo $row_rsStatus['id_sts']?>"<?php if (isset($row_rsproperties_client['status_cli']) && !(strcmp($row_rsStatus['id_sts'], $row_rsproperties_client['status_cli']))) {echo "SELECTED";} ?>><?php echo $row_rsStatus ['category_'.$lang_adm.'_sts']?></option>
                                                                    <?php }} while ($row_rsStatus  = mysqli_fetch_assoc($rsStatus ));
                                                                      $rows = mysqli_num_rows($rsStatus );
                                                                      if($rows > 0) {
                                                                          mysqli_data_seek($rsStatus , 0);
                                                                        $row_rsStatus  = mysqli_fetch_assoc($rsStatus );
                                                                      } ?>
                                                                </select>
                                                                <?php echo $tNGs->displayFieldError("properties_client", "status_cli"); ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 d-none d-md-block">
                                                        <br>
                                                        <a href="#" class="btn btn-success w-100 btn-icon add-status"><i class="fa-regular fa-plus"></i><!--  <?php __('Añadir Estatus'); ?> --></a>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "captado_por2_cli") != '') { ?>has-error<?php } ?>">
                                                        <label for="captado_por2_cli" class="form-label"><?php __('Captado por'); ?>:</label>
                                                            <select name="captado_por2_cli" id="captado_por2_cli" class="select2">
                                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                                <?php do { ?>
                                                                <option value="<?php echo $row_rsCaptado ['id_cap']?>"<?php if (isset($row_rsproperties_client['captado_por2_cli']) && !(strcmp($row_rsCaptado ['id_cap'], $row_rsproperties_client['captado_por2_cli']))) {echo "SELECTED";} ?>><?php echo $row_rsCaptado ['category_'.$lang_adm.'_cap']?></option>
                                                                <?php } while ($row_rsCaptado  = mysqli_fetch_assoc($rsCaptado ));
                                                                  $rows = mysqli_num_rows($rsCaptado );
                                                                  if($rows > 0) {
                                                                      mysqli_data_seek($rsCaptado , 0);
                                                                    $row_rsCaptado  = mysqli_fetch_assoc($rsCaptado );
                                                                  } ?>
                                                            </select>
                                                            <?php echo $tNGs->displayFieldError("properties_client", "captado_por2_cli"); ?>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 d-none d-md-block">
                                                        <br>
                                                        <a href="#" class="btn btn-success w-100 btn-icon add-captado"><i class="fa-regular fa-plus"></i><!--  <?php __('Añadir Captado por'); ?>--></a>

                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "como_nos_conocio_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="como_nos_conocio_cli" class="form-label"><?php __('Cómo nos conoció'); ?>:</label>
                                                            <div class="controls">
                                                                <select name="como_nos_conocio_cli" id="como_nos_conocio_cli" class="select2">
                                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                                    <?php do { ?>
                                                                    <option value="<?php echo $row_rsSources['id_sts']?>"<?php if (isset($row_rsproperties_client['como_nos_conocio_cli']) && !(strcmp($row_rsSources['id_sts'], $row_rsproperties_client['como_nos_conocio_cli']))) {echo "SELECTED";} ?>><?php echo $row_rsSources['category_'.$lang_adm.'_sts']?></option>
                                                                    <?php } while ($row_rsSources = mysqli_fetch_assoc($rsSources));
                                                                      $rows = mysqli_num_rows($rsSources);
                                                                      if($rows > 0) {
                                                                          mysqli_data_seek($rsSources, 0);
                                                                        $row_rsSources = mysqli_fetch_assoc($rsSources);
                                                                      } ?>
                                                                </select>
                                                                <?php echo $tNGs->displayFieldError("properties_client", "como_nos_conocio_cli"); ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2 d-none d-md-block">
                                                        <br>
                                                        <a href="#" class="btn btn-success w-100 btn-icon add-source"><i class="fa-regular fa-plus"></i><!--  <?php __('Añadir Origen'); ?>--></a>
                                                    </div>
                                                  </div>
                                              </div>
                                              <?php if ($_SESSION['kt_login_level'] != 7): ?>
                                              <div class="col-md-3">
                                                  <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "atendido_por_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="atendido_por_cli" class="form-label"><?php __('Atendido por'); ?>:</label>
                                                            <div class="controls">
                                                                <select name="atendido_por_cli" id="atendido_por_cli" class="select2">
                                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                                    <?php do { ?>
                                                                    <option value="<?php echo $row_rsusuarios['id_usr']?>"<?php if (isset($row_rsproperties_client['atendido_por_cli']) && !(strcmp($row_rsusuarios['id_usr'], $row_rsproperties_client['atendido_por_cli']))) {echo "SELECTED";} ?>><?php echo $row_rsusuarios['nombre_usr']?></option>
                                                                    <?php } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                                                      $rows = mysqli_num_rows($rsusuarios);
                                                                      if($rows > 0) {
                                                                          mysqli_data_seek($rsusuarios, 0);
                                                                        $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                                                      } ?>
                                                                </select>
                                                                <?php echo $tNGs->displayFieldError("properties_client", "atendido_por_cli"); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                              </div>
                                              <?php else: ?>
                                                <input type="hidden" name="atendido_por_cli" id="atendido_por_cli" value="<?php echo $row_rsproperties_client['atendido_por_cli'] ?>">
                                              <?php endif ?>
                                          </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-2 <?php if($tNGs->displayFieldError("properties_client", "puntuacion_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="puntuacion_cli" class="form-label"><?php __('Puntuación'); ?>:</label>
                                                <div>
                                                    <div id="raterreset" class="align-middle mt-2"></div>
                                                    <span class="clear-rating"></span>
                                                    <button type="button" id="raterreset-button" class="btn btn-soft-danger btn-sm ms-2 mt-2"><i class="fa-regular fa-trash-can"></i></button>
                                                </div>
                                                <input type="hidden" name="puntuacion_cli" id="puntuacion_cli" value="<?php if (KT_escapeAttribute($row_rsproperties_client['puntuacion_cli']) > 0): ?><?php echo KT_escapeAttribute($row_rsproperties_client['puntuacion_cli']); ?><?php else: ?>0<?php endif ?>" size="32" maxlength="255" class="form-control rating">
                                                <?php echo $tNGs->displayFieldError("properties_properties", "puntuacion_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "comment_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="comment_cli" class="form-label"><?php __('Comentario'); ?>:</label>
                                                <input type="text" name="comment_cli" id="comment_cli" value="<?php if(isset($row_rsproperties_client['comment_cli'])) echo trim(KT_escapeAttribute($row_rsproperties_client['comment_cli'])); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "comment_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?php if($tNGs->displayFieldError("properties_client", "next_call_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="next_call_cli" class="form-label"><?php __('Próxima llamada'); ?>:</label>
                                                <input type="text" name="next_call_cli" id="next_call_cli" value="<?php echo KT_formatDate($row_rsproperties_client['next_call_cli']); ?>" size="32" maxlength="255" class="form-control datepick2" data-provider="flatpickr" data-date-format="d-m-Y">
                                                <?php echo $tNGs->displayFieldError("properties_client", "next_call_cli"); ?>
                                            </div>

                                            <button class="btn btn-danger btn-sm btn-add-next-call ms-2" style="border-radius: 0 0 5px 5px;" data-futur=""><?php __('No llamar'); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+7 days", time())) ?>"><?php echo str_replace('%s','7',__('Añadir %s días', true)); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+15 days", time())) ?>"><?php echo str_replace('%s','15',__('Añadir %s días', true)); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2 d-none d-md-inline" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+30 days", time())) ?>"><?php echo str_replace('%s','30',__('Añadir %s días', true)); ?></button>

                                            <button class="btn btn-success btn-sm btn-add-next-call ms-2 d-none d-md-inline" style="border-radius: 0 0 5px 5px;" data-futur="<?php echo date("d-m-Y", strtotime("+60 days", time())) ?>"><?php echo str_replace('%s','60',__('Añadir %s días', true)); ?></button>

                                        </div>
                                    </div>

                                    <div class="row mt-4 mt-md-0">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "fecha_alta_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="fecha_alta_cli" class="form-label"><?php __('Añadido'); ?>:</label>
                                                <input type="text" name="fecha_alta_cli" id="fecha_alta_cli" value="<?php echo KT_formatDate($row_rsproperties_client['fecha_alta_cli']); ?>" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                                                <?php echo $tNGs->displayFieldError("properties_client", "fecha_alta_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "updated_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="updated_cli" class="form-label"><?php __('Última actualización'); ?>:</label>
                                                <input type="text" name="updated_cli" id="updated_cli" value="<?php if(isset($row_rsUpdate['updated_cli'])) echo KT_formatDate($row_rsUpdate['updated_cli']); ?>" size="32" maxlength="255" class="form-control datepick" readonly>
                                                <?php echo $tNGs->displayFieldError("properties_client", "updated_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mt-4">
                                                <div class="col-md-4">
                                                    <a href="javascript:void(0);" class="add-cita btn btn-primary w-100"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir cita'); ?></a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="/intramedianet/calendar/calendario.php" class="btn btn-primary w-100 mt-3 mt-md-0" target="_blank"><i class="fa-regular fa-calendar-days me-1"></i> <?php __('Calendario'); ?></a>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="/intramedianet/tasks/tasks-form.php?idu=<?php echo $row_rsproperties_client['id_cli'] ?>&t=2" target="_blank" class="add-citax btn btn-primary w-100 mt-3 mt-md-0"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir tarea'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "idioma_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="idioma_cli" class="form-label"><?php __('Idioma'); ?>:</label>
                                                <select name="idioma_cli" id="idioma_cli" class="form-select required" required>
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php
                                                    if ($lang_adm == 'es') {
                                                        $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                                    } else {
                                                        $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                                    }
                                                    foreach ($languages as $value) {
                                                        $selected = (isset($row_rsproperties_client['idioma_cli']) && !(strcmp($value, $row_rsproperties_client['idioma_cli'])))?" SELECTED":"";
                                                        echo '<option value="'.$value.'"'.$selected.'>'.$idiomas[$value].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                <?php echo $tNGs->displayFieldError("properties_client", "idioma_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nacionalidad_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="nacionalidad_cli" class="form-label"><?php __('Nacionalidad'); ?>:</label>
                                                <select name="nacionalidad_cli" id="nacionalidad_cli" class="form-select">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsNationalities['id_ncld'] ?>" <?php if (isset($row_rsproperties_client['nacionalidad_cli']) && !(strcmp($row_rsNationalities['id_ncld'], $row_rsproperties_client['nacionalidad_cli']))) {echo "SELECTED";} ?>><?php echo $row_rsNationalities['nacionalidad_'.$lang_adm.'_ncld'] ?></option>
                                                    <?php } while ($row_rsNationalities = mysqli_fetch_assoc($rsNationalities));
                                                    $rows = mysqli_num_rows($rsNationalities );
                                                    if($rows > 0) {
                                                        mysqli_data_seek($rsNationalities , 0);
                                                      $row_rsNationalities = mysqli_fetch_assoc($rsNationalities );
                                                    } ?>
                                                </select>
                                                  <?php echo $tNGs->displayFieldError("properties_client", "nacionalidad_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3 d-none">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "telefono_movil_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="telefono_movil_cli" class="form-label"><?php __('Móvil'); ?>:</label>
                                                <input type="text" name="telefono_movil_cli" id="telefono_movil_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['telefono_movil_cli']); ?>" size="32" maxlength="255" class="form-control number">
                                                <?php echo $tNGs->displayFieldError("properties_client", "telefono_movil_cli"); ?>
                                                <a href="https://api.whatsapp.com/send/?phone=<?php echo KT_escapeAttribute($row_rsproperties_client['telefono_movil_cli']); ?>" class="btn btn-success btn-sm ms-2" style="border-radius: 0 0 5px 5px;" target="blank">Whatsapp</a> <small class="text-muted"><?php __('Sin + con prefijo del país y sin espacios'); ?></small>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nie_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="nie_cli" class="form-label"><?php __('NIE'); ?>:</label>
                                                <input type="text" name="nie_cli" id="nie_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['nie_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "nie_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "pasaporte_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="pasaporte_cli" class="form-label"><?php __('Pasaporte'); ?>:</label>
                                                <input type="text" name="pasaporte_cli" id="pasaporte_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['pasaporte_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "pasaporte_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "direccion_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="direccion_cli" class="form-label"><?php __('Dirección'); ?>:</label>
                                                <input type="text" name="direccion_cli" id="direccion_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['direccion_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "direccion_cli"); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "visited_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="visited_cli" class="form-label"><?php __('Inmuebles visitados'); ?>:</label>
                                                <input type="text" class="select2references" id="visited_cli" name="visited_cli[]" value="" tabindex="-1">
                                                  <?php echo $tNGs->displayFieldError("properties_client", "visited_cli"); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check form-switch form-switch-lg pt-0 pt-md-4 mb-4 mb-md-0" dir="ltr">
                                                <input type="checkbox" name="ha_comprado_cli" id="ha_comprado_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['ha_comprado_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['ha_comprado_cli']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="ha_comprado_cli"><?php __('Ha comprado'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_client", "ha_comprado_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "ref_comprado_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="ref_comprado_cli" class="form-label"><?php __('Referencia'); ?>:</label>
                                                <input type="text" class="select2references2" id="ref_comprado_cli" name="ref_comprado_cli" value="" tabindex="-1">
                                                  <?php echo $tNGs->displayFieldError("properties_client", "ref_comprado_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-switch form-switch-lg pt-0 pt-md-4 mb-4 mb-md-0" dir="ltr">
                                                <input type="checkbox" name="buy_agen_cli" id="buy_agen_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['buy_agen_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['buy_agen_cli']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="buy_agen_cli"><?php __('Otra agencia'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_client", "buy_agen_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "agen_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="agen_cli" class="form-label"><?php __('Nombre de la agencia'); ?>:</label>
                                                <input type="text" name="agen_cli" id="agen_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['agen_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "agen_cli"); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">

                                          <legend class="border-bottom"><?php __('Archivos'); ?></legend>

                                          <small><i class="fa-regular fa-file fa-fw"></i> <?php __('Extensiones permitidas'); ?>: rar, txt, zip, doc, pdf, csv, xls, rtf, sxw, odt, docx, xlsx, ppt <?php __('y'); ?> mov.</small>
                                          <br>
                                          <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de los archivos, arrastre y suelte el archivo en la ubicación deseada'); ?>.</small>

                                          <hr>

                                          <div id="file-order-loading"></div>
                                          <ul class="thumbnails nested-sortable-file-" id="file-list">
                                              <?php if(isset($totalRows_rsFiles) && $totalRows_rsFiles > 0) { ?>
                                              <?php do { ?>
                                                  <li class="pull-left" id="order_<?php echo $row_rsFiles['id_fil'] ?>" data-id="<?php echo $row_rsFiles['id_fil'] ?>">
                                                      <div class="img-thumbnail pull-left">
                                                          <a href="/media/files/clients/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br><small><?php echo $row_rsFiles['file_fil']; ?></small></a>
                                                          <p class="text-center">
                                                          <a href="#" class="btn btn-success btn-sm edit-name" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-pencil"></i></a>
                                                          <a href="/intramedianet/properties/cfiles_del.php" data-id="<?php echo $row_rsFiles['id_fil'] ?>" class="btn btn-danger btn-sm del-fil"><i class="fa-regular fa-trash-can"></i></a>
                                                          </p>
                                                      </div>
                                                  </li>
                                                  <?php } while ($row_rsFiles = mysqli_fetch_assoc($rsFiles)); ?>
                                              <?php } ?>
                                          </ul>

                                          <?php if ($actColaboradores == 1): ?>
                                              <!-- <hr>
                                              <div class="row">
                                                  <div class="col-md-10">
                                                      <select name="colbrs" id="colbrs" class="form-select">
                                                          <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                          <?php do { ?>
                                                          <option value="<?php echo $row_rsColaboradores['email_col']?>"><?php echo $row_rsColaboradores['nombre_comercial_col']?></option>
                                                          <?php } while ($row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores));
                                                  $rows = mysqli_num_rows($rsColaboradores);
                                                  if($rows > 0) {
                                                      mysqli_data_seek($rsColaboradores, 0);
                                                      $row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores);
                                                  } ?>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-2">
                                                      <a href="#" class="btn btn-success w-100 sendfiles mt-4 mt-md-0"><i class="fa-regular fa-paper-plane"></i> <?php __('Enviar'); ?></a>
                                                  </div>
                                              </div> -->
                                          <?php endif ?>
                                          <hr>
                                          <div class="multi_files"></div>

                                        </div>
                                    </div>

                                    <?php /* ?>
                                      <div class="form-check form-switch form-switch-lg pt-2 mb-4" dir="ltr">
                                          <input type="checkbox" name="residencia_fiscal_cli" id="residencia_fiscal_cli" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['residencia_fiscal_cli']),"1"))) {echo "checked";} ?>>
                                          <label class="form-check-label" for="residencia_fiscal_cli"><?php __('Residencia fiscal'); ?></label>
                                          <?php echo $tNGs->displayFieldError("properties_client", "residencia_fiscal_cli"); ?>
                                      </div>

                                      <?php if ($_GET['id_cli'] != ''): ?>
                                      <a href="/intramedianet/gdpr/clients.php?id=<?php echo $_GET['id_cli']; ?>" target="_blank" class="btn btn-primary w-100 mb-0"  data-toggle="tooltip" data-placement="bottom"  title="<?php __('Recuerde guardar el cliente para ver los ultimos datos'); ?>"><i class="fa-regular fa-signature me-1"></i> GDPR</a>
                                      <?php endif ?>

                                      <?php if($activarWelcomeMail == 1):?>
                                      <div class="col-md-12 mt-n2">
                                            <br>
                                                <a href="#" class="btn btn-primary w-100 btnsendWelcome mb-2"><i class="fa-regular fa-paper-plane ms-1"></i> <?php __('Welcome Mail')?></a>
                                            <?php
                                              $query_rsCli = "SELECT send_welcome_cli FROM properties_client WHERE id_cli = '".$_GET['id_cli']."'";
                                              $rsCli = mysqli_query($inmoconn ,$query_rsCli, $inmoconn);
                                              $row_rsCli = mysqli_fetch_assoc($rsCli);

                                              if($row_rsCli['send_welcome_cli'] == 1) { ?>
                                              <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                                                  <i class="fa-regular fa-circle-info label-icon"></i> <?php echo $lang['Welcome email already sent'] ?>
                                              </div>
                                              <?php } ?>

                                      </div>
                                      <?php endif?>

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "captado_por_cli") != '') { ?>has-error<?php } ?>">
                                        <label for="captado_por_cli" class="form-label"><?php __('Captado por'); ?>:</label>
                                        <div class="controls">
                                            <?php if($_SESSION['kt_login_level'] != 8) { ?>
                                            <input type="text" name="captado_por_cli" id="captado_por_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['captado_por_cli']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php } else { ?>
                                            <input type="hidden" name="captado_por_cli" id="captado_por_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['captado_por_cli']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo KT_escapeAttribute($row_rsproperties_client['captado_por_cli']); ?>
                                            <?php } ?>
                                            <?php echo $tNGs->displayFieldError("properties_client", "captado_por_cli"); ?>
                                        </div>
                                      </div>

                                    <?php */ ?>



                                </div><!-- end card-body -->
                            </div>


                        </div>

                        <div class="tab-pane" id="tabnotes">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Notas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="form-group <?php if($tNGs->displayFieldError("properties_client", "historial_cli") != '') { ?>has-error<?php } ?>">
                                        <textarea type="text" name="historial_cli" id="historial_cli" cols="50" rows="20" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_client['historial_cli']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("properties_client", "historial_cli"); ?>
                                        <a href="#" class="btn btn-success btn-sm addHist float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                                    </div>

                                </div><!-- end card-body -->
                            </div>

                            <?php /* ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Notas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="form-group <?php if($tNGs->displayFieldError("properties_client", "notas_cli") != '') { ?>has-error<?php } ?>">
                                        <label for="notas_cli" class="form-label"><?php __('Notas'); ?>:</label>
                                        <textarea type="text" name="notas_cli" id="notas_cli" cols="50" rows="20" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_client['notas_cli']); ?></textarea>
                                        <?php echo $tNGs->displayFieldError("properties_client", "notas_cli"); ?>
                                        <a href="#" class="btn btn-success addNot btn-sm float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                                    </div>

                                </div><!-- end card-body -->
                            </div>
                            <?php */ ?>

                        </div>
                        <div class="tab-pane" id="tabsearch">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <!-- <div class="float-end fs-4 mt-n1">
                                            <span class="badge bg-info countlistnews2">0</span>
                                            <span class="badge bg-success countlistint2">0</span>
                                            <span class="badge bg-danger countlistintno2">0</span>
                                        </div> -->
                                        <h4 class="card-title mb-0 flex-grow-1 pt-1">
                                          <?php __('Criterios de búsqueda'); ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row" id="search-fields">

                                      <style>
                                        .is-valid .form-control,
                                        .is-valid .form-select,
                                        .is-valid .select2-container .select2-choice,
                                        .is-valid .select2-container .select2-choice .select2-arrow b,
                                        .is-valid .select2-container .select2-choices {
                                            background-color: rgba(10, 179, 156, 0.1) !important;
                                        }

                                        .is-invalid .form-control,
                                        .is-invalid .form-select,
                                        .is-invalid .select2-container .select2-choice,
                                        .is-invalid .select2-container .select2-choice .select2-arrow b,
                                        .is-invalid .select2-container .select2-choices {
                                            background-color: rgba(220, 53, 69, 0.25) !important;
                                        }
                                      </style>

                                      <div class="col-md-6 is-valid">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_sale_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_sale_cli" class="form-label"><?php __('Operación'); ?>:</label>
                                              <select name="b_sale_cli[]" id="b_sale_cli" multiple class="select2">
                                                  <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_sale_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_sale_cli']); ?>
                                                  <option value="<?php echo $row_rsSales['id_sta']?>"<?php if (in_array($row_rsSales['id_sta'], $vals)) {echo "selected=\"selected\"";} ?>><?php echo $row_rsSales['status_'.$lang_adm.'_sta']?></option>
                                                  <?php } while ($row_rsSales = mysqli_fetch_assoc($rsSales ));
                                                    $rows = mysqli_num_rows($rsSales);
                                                    if($rows > 0) {
                                                        mysqli_data_seek($rsSales , 0);
                                                      $row_rsSales = mysqli_fetch_assoc($rsSales);
                                                    } ?>
                                              </select>
                                              <?php echo $tNGs->displayFieldError("properties_client", "b_sale_cli"); ?>
                                          </div>

                                          <?php if($actCostas == 1):?>
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_costa_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_costa_cli" class="form-label"><?php __('Costa'); ?>:</label>
                                              <select name="b_costa_cli[]" id="b_costa_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_costa_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_costa_cli']);
                                                ?>
                                                <option value="<?php echo $row_rscosta['id_cst']?>" <?php if (in_array($row_rscosta['id_cst'], $vals)) {echo "SELECTED";} ?>>
                                                  <?php echo $row_rscosta['costa']?>
                                                </option>
                                                <?php } while ($row_rscosta = mysqli_fetch_assoc($rscosta)); ?>
                                              </select>
                                                <?php echo $tNGs->displayFieldError("properties_client", "b_costa_cli"); ?>
                                            </div>
                                            <?php endif?>

                                          <div class="mb-4 <?php if($actCostas == 1) { echo ' d-none '; }?> <?php if($tNGs->displayFieldError("properties_client", "b_loc2_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_loc2_cli" class="form-label"><?php __('Provincia'); ?>:</label>
                                              <select name="b_loc2_cli[]" id="b_loc2_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc2_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_loc2_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsparent2['id'] ?>" <?php if (in_array($row_rsparent2['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsparent2['name'] ?></option>
                                                <?php } while ($row_rsparent2 = mysqli_fetch_assoc($rsparent2)); ?>
                                              </select>
                                                <?php echo $tNGs->displayFieldError("properties_client", "b_loc2_cli"); ?>
                                          </div>

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_loc3_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_loc3_cli" class="form-label"><?php __('Ciudad'); ?>:</label>
                                              <select name="b_loc3_cli[]" id="b_loc3_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc3_cli']))
                                                  $vals = explode(',', $row_rsproperties_client['b_loc3_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsparent3['id'] ?>" <?php if (in_array($row_rsparent3['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsparent3['name'] ?></option>
                                                <?php } while ($row_rsparent3 = mysqli_fetch_assoc($rsparent3)); ?>
                                              </select>
                                                <?php echo $tNGs->displayFieldError("properties_client", "b_loc3_cli"); ?>
                                          </div>

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_loc4_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_loc4_cli" class="form-label"><?php __('Zona'); ?>:</label>
                                              <select name="b_loc4_cli[]" id="b_loc4_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc4_cli']))
                                                  $vals = explode(',', $row_rsproperties_client['b_loc4_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsparent4['id'] ?>" <?php if (in_array($row_rsparent4['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsparent4['name'] ?></option>
                                                <?php } while ($row_rsparent4 = mysqli_fetch_assoc($rsparent4)); ?>
                                              </select>
                                                <?php echo $tNGs->displayFieldError("properties_client", "b_loc4_cli"); ?>
                                          </div>

                                      </div>

                                      <div class="col-md-6 is-valid">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_type_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="b_type_cli" class="form-label"><?php __('Tipo'); ?>:</label>
                                                <select name="b_type_cli[]" id="b_type_cli" multiple class="select2">
                                                  <?php
                                                  do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_type_cli']))
                                                    $vals = explode(',', $row_rsproperties_client['b_type_cli']);
                                                  ?>
                                                  <option value="<?php echo $row_rsTipos['id_typ'] ?>"<?php if (in_array($row_rsTipos['id_typ'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?></option>
                                                  <?php
                                                  } while ($row_rsTipos = mysqli_fetch_assoc($rsTipos));
                                                    $rows = mysqli_num_rows($rsTipos);
                                                    if($rows > 0) {
                                                        mysqli_data_seek($rsTipos, 0);
                                                      $row_rsTipos = mysqli_fetch_assoc($rsTipos);
                                                    }
                                                  ?>
                                              </select>
                                              <?php echo $tNGs->displayFieldError("properties_client", "b_type_cli"); ?>
                                          </div>

                                          <div class="row">

                                            <div class="col-md-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_precio_desde_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_precio_desde_cli" class="form-label"><?php __('Precio desde'); ?>:</label>
                                                    <input type="text" name="b_precio_desde_cli" id="b_precio_desde_cli" value="<?php if(isset($row_rsproperties_client['b_precio_desde_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_precio_desde_cli']); ?>" size="32" maxlength="255" class="form-control bg-success bg-opacity-10">
                                                      <?php echo $tNGs->displayFieldError("properties_client", "b_precio_desde_cli"); ?>
                                                </div>

                                                <div class="text-muted mt-n4 mb-1"><?php __('Sin puntos ni comas ni símbolos €') ?></div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_precio_hasta_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_precio_hasta_cli" class="form-label"><?php __('Precio hasta'); ?>:</label>
                                                    <input type="text" name="b_precio_hasta_cli" id="b_precio_hasta_cli" value="<?php if(isset($row_rsproperties_client['b_precio_hasta_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_precio_hasta_cli']); ?>" size="32" maxlength="255" class="form-control bg-success bg-opacity-10">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_precio_hasta_cli"); ?>
                                                </div>

                                            </div>

                                          </div>

                                          <div class="row">

                                            <div class="col-md-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_pool_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_pool_cli" class="form-label"><?php __('Piscina'); ?>:</label>
                                                    <select name="b_pool_cli[]" id="b_pool_cli" class="select2" multiple="multiple">
                                                        <?php
                                                        do {
                                                        ?>
                                                        <option value="<?php echo $row_rsPool['id_pl']?>"<?php if (isset($row_rsproperties_client['b_pool_cli']) && !(strcmp($row_rsPool['id_pl'], $row_rsproperties_client['b_pool_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPool['pool']?></option>
                                                        <?php
                                                        } while ($row_rsPool = mysqli_fetch_assoc($rsPool ));
                                                          $rows = mysqli_num_rows($rsPool );
                                                          if($rows > 0) {
                                                              mysqli_data_seek($rsPool , 0);
                                                            $row_rsPool = mysqli_fetch_assoc($rsPool );
                                                          }
                                                        ?>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_pool_cli"); ?>
                                                </div>

                                              </div>

                                            <div class="col-md-6">


                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_parking_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_parking_cli" class="form-label"><?php __('Parking'); ?>:</label>
                                                    <select name="b_parking_cli[]" id="b_parking_cli" class="select2" multiple="multiple">
                                                        <?php
                                                        do {
                                                        ?>
                                                        <option value="<?php echo $row_rsParking['id_prk']?>"<?php if (isset($row_rsproperties_client['b_parking_cli']) && !(strcmp($row_rsParking['id_prk'], $row_rsproperties_client['b_parking_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsParking['parking']?></option>
                                                        <?php
                                                        } while ($row_rsParking = mysqli_fetch_assoc($rsParking ));
                                                          $rows = mysqli_num_rows($rsParking );
                                                          if($rows > 0) {
                                                              mysqli_data_seek($rsParking , 0);
                                                            $row_rsParking = mysqli_fetch_assoc($rsParking );
                                                          }
                                                        ?>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_parking_cli"); ?>
                                                </div>

                                            </div>

                                          </div>

                                          <div class="row">

                                            <div class="col-md-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_beds_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_beds_cli" class="form-label"><?php __('Habitaciones'); ?>:</label>
                                                    <div class="controls">
                                                        <select name="b_beds_cli" id="b_beds_cli" class="select2">
                                                            <option value="" <?php if (isset($row_rsproperties_client['b_beds_cli']) && !(strcmp("", $row_rsproperties_client['b_beds_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $lang['Todos']; ?></option>
                                                            <?php
                                                            for ($i=1; $i < 100; $i++) {
                                                            ?>
                                                            <option value="<?php echo $i?>"<?php if (isset($row_rsproperties_client['b_beds_cli']) && !(strcmp($i, $row_rsproperties_client['b_beds_cli']))) {echo "SELECTED";} ?>><?php echo $i?></option>
                                                            <?php
                                                              }
                                                            ?>
                                                        </select>
                                                        <?php echo $tNGs->displayFieldError("properties_client", "b_beds_cli"); ?>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_baths_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_baths_cli" class="form-label"><?php __('Aseos'); ?>:</label>
                                                    <div class="controls">
                                                        <select name="b_baths_cli" id="b_baths_cli" class="select2">
                                                            <option value="" <?php if (isset($row_rsproperties_client['b_baths_cli']) && !(strcmp("", $row_rsproperties_client['b_baths_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $lang['Todos']; ?></option>
                                                            <?php
                                                            for ($i=1; $i < 100; $i++) {
                                                            ?>
                                                            <option value="<?php echo $i?>"<?php if (isset($row_rsproperties_client['b_baths_cli']) && !(strcmp($i, $row_rsproperties_client['b_baths_cli']))) {echo "SELECTED";} ?>><?php echo $i?></option>
                                                            <?php
                                                              }
                                                            ?>
                                                        </select>
                                                        <?php echo $tNGs->displayFieldError("properties_client", "b_baths_cli"); ?>
                                                    </div>
                                                </div>

                                            </div>

                                          </div>

                                      </div>

                                      <div class="col-md-12">

                                          <hr>
                                          <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                                              <i class="fa-regular fa-circle-exclamation label-icon"></i> <?php echo __('¡CUIDADO! Los siguientes criterios pueden limitar el nº de resultados.'); ?>
                                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>
                                          <hr>

                                      </div>

                                      <div class="col-md-6 is-invalid">

                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_loc1_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_loc1_cli" class="form-label"><?php __('País'); ?>:</label>
                                              <select name="b_loc1_cli[]" id="b_loc1_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc1_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_loc1_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsparent1['id'] ?>" <?php if (in_array($row_rsparent1['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsparent1['name'] ?></option>
                                                <?php } while ($row_rsparent1 = mysqli_fetch_assoc($rsparent1)); ?>
                                              </select>
                                                <?php echo $tNGs->displayFieldError("properties_client", "b_loc1_cli"); ?>
                                          </div>

                                          <div class="row">

                                            <div class="col-md-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_m2_desde_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_m2_desde_cli" class="form-label"><?php __('M<sup>2</sup> desde'); ?>:</label>
                                                    <input type="text" name="b_m2_desde_cli" id="b_m2_desde_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_m2_desde_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                      <?php echo $tNGs->displayFieldError("properties_client", "b_m2_desde_cli"); ?>
                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_m2_hasta_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_m2_hasta_cli" class="form-label"><?php __('M<sup>2</sup> hasta'); ?>:</label>
                                                    <input type="text" name="b_m2_hasta_cli" id="b_m2_hasta_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_m2_hasta_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_m2_hasta_cli"); ?>
                                                </div>

                                            </div>

                                          </div>

                                            <div class="row">

                                              <div class="col-md-6">

                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_m2p_desde_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="b_m2p_desde_cli" class="form-label"><?php __('M<sup>2</sup> parcela desde'); ?>:</label>
                                                      <input type="text" name="b_m2p_desde_cli" id="b_m2p_desde_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_m2p_desde_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_client", "b_m2p_desde_cli"); ?>
                                                  </div>

                                              </div>

                                              <div class="col-md-6">

                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_m2p_hasta_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="b_m2p_hasta_cli" class="form-label"><?php __('M<sup>2</sup> parcela hasta'); ?>:</label>
                                                      <input type="text" name="b_m2p_hasta_cli" id="b_m2p_hasta_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_m2p_hasta_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                      <?php echo $tNGs->displayFieldError("properties_client", "b_m2p_hasta_cli"); ?>
                                                  </div>

                                              </div>

                                            </div>

                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_opciones_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_opciones_cli" class="form-label"><?php __('Opciones'); ?>:</label>
                                              <div class="controls">
                                                <select name="b_opciones_cli[]" id="b_opciones_cli" multiple class="select2">
                                                  <?php do {
                                                      $vals = array();
                                                      if(isset($row_rsproperties_client['b_opciones_cli']))
                                                    $vals = explode(',', $row_rsproperties_client['b_opciones_cli']);
                                                  ?>
                                                  <option value="<?php echo $row_rsOpciones['id'] ?>" <?php if (in_array($row_rsOpciones['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsOpciones['name'] ?></option>
                                                  <?php } while ($row_rsOpciones = mysqli_fetch_assoc($rsOpciones)); ?>
                                                </select>
                                                  <?php echo $tNGs->displayFieldError("properties_client", "b_opciones_cli"); ?>
                                              </div>
                                            </div>

                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_opciones2_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_opciones2_cli" class="form-label"><?php __('Características privadas'); ?>:</label>
                                              <div class="controls">
                                                <select name="b_opciones2_cli[]" id="b_opciones2_cli" multiple class="select2">
                                                  <?php
                                                  if ($totalRows_rsOpciones2 > 0) {
                                                  do {
                                                      $vals = array();
                                                      if(isset($row_rsproperties_client['b_opciones2_cli']))
                                                    $vals = explode(',', $row_rsproperties_client['b_opciones2_cli']);
                                                  ?>
                                                  <option value="<?php echo $row_rsOpciones2['id'] ?>"<?php if (in_array($row_rsOpciones2['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsOpciones2['name'] ?></option>
                                                  <?php
                                              } while ($row_rsOpciones2 = mysqli_fetch_assoc($rsOpciones2));
                                          } ?>
                                                </select>
                                                  <?php echo $tNGs->displayFieldError("properties_client", "b_opciones2_cli"); ?>
                                              </div>
                                            </div>

                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_tags_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="b_tags_cli" class="form-label"><?php __('Etiquetas'); ?>:</label>
                                              <div class="controls">
                                                <select name="b_tags_cli[]" id="b_tags_cli" multiple class="select2">
                                                  <?php
                                                  if ($totalRows_rsTags > 0) {
                                                  do {
                                                      $vals = array();
                                                      if(isset($row_rsproperties_client['b_tags_cli']))
                                                    $vals = explode(',', $row_rsproperties_client['b_tags_cli']);
                                                  ?>
                                                  <option value="<?php echo $row_rsTags['id'] ?>"<?php if (in_array($row_rsTags['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsTags['name'] ?></option>
                                                  <?php
                                              } while ($row_rsTags = mysqli_fetch_assoc($rsTags));
                                          } ?>
                                                </select>
                                                  <?php echo $tNGs->displayFieldError("properties_client", "b_tags_cli"); ?>
                                              </div>
                                            </div>

                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_orientacion_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="b_orientacion_cli" class="form-label"><?php __('Orientación'); ?>:</label>
                                                <div class="controls">
                                                    <select name="b_orientacion_cli" id="b_orientacion_cli" class="select2">
                                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                        <option value="o-n"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-n', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-n') ?></option>
                                                        <option value="o-ne"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-ne', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-ne') ?></option>
                                                        <option value="o-e"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-e', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-e') ?></option>
                                                        <option value="o-se"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-se', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-se') ?></option>
                                                        <option value="o-s"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-s', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-s') ?></option>
                                                        <option value="o-so"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-so', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-so') ?></option>
                                                        <option value="o-o"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-o', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-o') ?></option>
                                                        <option value="o-no"<?php if (isset($row_rsproperties_client['b_orientacion_cli']) && !(strcmp('o-no', $row_rsproperties_client['b_orientacion_cli']))) {echo "SELECTED";} ?>><?php echo __('o-no') ?></option>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_orientacion_cli"); ?>
                                                </div>
                                            </div>





                                      </div>

                                      <div class="col-md-6 is-invalid">

                                                <br>

                                                <legend style="font-size: 16px; font-weight: bold;"><?php __('Distancia a la playa'); ?>:</legend>

                                                <div class="row">
                                                  <div class="col-md-2">
                                                      <label for="b_dist_beach_val_cli" class="form-label">&nbsp;</label>
                                                      <select name="b_dist_beach_val_cli" id="b_dist_beach_val_cli" class="form-select">
                                                          <option value="Km"<?php if (isset($row_rsproperties_client['b_dist_beach_val_cli']) && !(strcmp('Km', $row_rsproperties_client['b_dist_beach_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                          <option value="Mts"<?php if (isset($row_rsproperties_client['b_dist_beach_val_cli']) && !(strcmp('Mts', $row_rsproperties_client['b_dist_beach_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                          <option value="Mins"<?php if (isset($row_rsproperties_client['b_dist_beach_val_cli']) && !(strcmp('Mins', $row_rsproperties_client['b_dist_beach_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_beach_from_cli" class="form-label"><?php __('Desde'); ?>:</label>
                                                      <input type="text" name="b_dist_beach_from_cli" id="b_dist_beach_from_cli" value="<?php if(isset($row_rsproperties_client['b_dist_beach_from_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_dist_beach_from_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_beach_to_cli" class="form-label"><?php __('Hasta'); ?>:</label>
                                                      <input type="text" name="b_dist_beach_to_cli" id="b_dist_beach_to_cli" value="<?php if(isset($row_rsproperties_client['b_dist_beach_to_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_dist_beach_to_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                </div>

                                                <br>

                                                <legend style="font-size: 16px; font-weight: bold;"><?php __('Distancia a entretenimientos'); ?>:</legend>

                                                <div class="row">
                                                  <div class="col-md-2">
                                                      <label for="b_dist_amenit_val_cli" class="form-label">&nbsp;</label>
                                                      <select name="b_dist_amenit_val_cli" id="b_dist_amenit_val_cli" class="form-select">
                                                          <option value="Km"  <?php if(isset($row_rsproperties_client['b_dist_amenit_val_cli']) && !(strcmp('Km', $row_rsproperties_client['b_dist_amenit_val_cli'])))   {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                          <option value="Mts" <?php if(isset($row_rsproperties_client['b_dist_amenit_val_cli']) && !(strcmp('Mts', $row_rsproperties_client['b_dist_amenit_val_cli'])))  {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                          <option value="Mins"<?php if(isset($row_rsproperties_client['b_dist_amenit_val_cli']) && !(strcmp('Mins', $row_rsproperties_client['b_dist_amenit_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_amenit_from_cli" class="form-label"><?php __('Desde'); ?>:</label>
                                                      <input type="text" name="b_dist_amenit_from_cli" id="b_dist_amenit_from_cli" value="<?php if(isset($row_rsproperties_client['b_dist_amenit_from_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_dist_amenit_from_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_amenit_to_cli" class="form-label"><?php __('Hasta'); ?>:</label>
                                                      <input type="text" name="b_dist_amenit_to_cli" id="b_dist_amenit_to_cli" value="<?php if(isset($row_rsproperties_client['b_dist_amenit_to_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_dist_amenit_to_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                </div>

                                                <br>

                                                <legend style="font-size: 16px; font-weight: bold;"><?php __('Distancia al aereopuerto'); ?>:</legend>

                                                <div class="row">
                                                  <div class="col-md-2">
                                                      <label for="b_dist_airport_val_cli" class="form-label">&nbsp;</label>
                                                      <select name="b_dist_airport_val_cli" id="b_dist_airport_val_cli" class="form-select">
                                                          <option value="Km"<?php if (isset($row_rsproperties_client['b_dist_airport_val_cli']) && !(strcmp('Km', $row_rsproperties_client['b_dist_airport_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                          <option value="Mts"<?php if (isset($row_rsproperties_client['b_dist_airport_val_cli']) && !(strcmp('Mts', $row_rsproperties_client['b_dist_airport_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                          <option value="Mins"<?php if (isset($row_rsproperties_client['b_dist_airport_val_cli']) && !(strcmp('Mins', $row_rsproperties_client['b_dist_airport_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_airport_from_cli" class="form-label"><?php __('Desde'); ?>:</label>
                                                      <input type="text" name="b_dist_airport_from_cli" id="b_dist_airport_from_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_dist_airport_from_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_airport_to_cli" class="form-label"><?php __('Hasta'); ?>:</label>
                                                      <input type="text" name="b_dist_airport_to_cli" id="b_dist_airport_to_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_dist_airport_to_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                </div>

                                                <br>

                                                <legend style="font-size: 16px; font-weight: bold;"><?php __('Distancia al campo de golf'); ?></legend>

                                                <div class="row">
                                                  <div class="col-md-2">
                                                      <label for="b_dist_golf_val_cli" class="form-label">&nbsp;</label>
                                                      <select name="b_dist_golf_val_cli" id="b_dist_golf_val_cli" class="form-select">
                                                          <option value="Km"<?php if (isset($row_rsproperties_client['b_dist_golf_val_cli']) && !(strcmp('Km', $row_rsproperties_client['b_dist_golf_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Km') ?></option>
                                                          <option value="Mts"<?php if (isset($row_rsproperties_client['b_dist_golf_val_cli']) && !(strcmp('Mts', $row_rsproperties_client['b_dist_golf_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Mts') ?></option>
                                                          <option value="Mins"<?php if (isset($row_rsproperties_client['b_dist_golf_val_cli']) && !(strcmp('Mins', $row_rsproperties_client['b_dist_golf_val_cli']))) {echo "SELECTED";} ?>><?php echo __('Mins') ?></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_golf_from_cli" class="form-label"><?php __('Desde'); ?>:</label>
                                                      <input type="text" name="b_dist_golf_from_cli" id="b_dist_golf_from_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_dist_golf_from_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                  <div class="col-md-5 mt-4 mt-md-0">
                                                      <label for="b_dist_golf_to_cli" class="form-label"><?php __('Hasta'); ?>:</label>
                                                      <input type="text" name="b_dist_golf_to_cli" id="b_dist_golf_to_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_dist_golf_to_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                  </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <?php if ($actUsuarios == 1) { ?>

                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "favs") != '') { ?>has-error<?php } ?>">
                                                            <label for="favs" class="form-label"><?php __('Favoritos'); ?>:</label>
                                                            <select name="favs[]" id="favs" multiple class="select2">
                                                              <?php

                                                                $query_rsFavs = "SELECT * FROM users_favorites WHERE user= '".KT_escapeAttribute($row_rsproperties_client['user_cli'])."' GROUP BY user, property ORDER BY id";
                                                                $rsFavs = mysqli_query($inmoconn ,$query_rsFavs) or die(mysqli_error());
                                                                $row_rsFavs = mysqli_fetch_assoc($rsFavs);
                                                                $totalRows_rsFavs = mysqli_num_rows($rsFavs);
                                                                $favs = array();
                                                                do {
                                                                    array_push($favs, $row_rsFavs['property']);
                                                                } while ($row_rsFavs = mysqli_fetch_assoc($rsFavs));
                                                                do { ?>
                                                              <option value="<?php echo $row_rsReferencias2['name'] ?>" <?php if (in_array($row_rsReferencias2['id'], $favs)) {echo "SELECTED";} ?>><?php echo $row_rsReferencias2['name'] ?></option>
                                                              <?php } while ($row_rsReferencias2 = mysqli_fetch_assoc($rsReferencias2)); ?>
                                                            </select>
                                                            <?php echo $tNGs->displayFieldError("properties_client", "favs"); ?>
                                                        </div>

                                                        <?php } ?>

                                                    </div>
                                                </div>

                                                <?php /* ?><div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_ref_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_ref_cli" class="form-label"><?php __('Referencia'); ?>:</label>
                                                    <select name="b_ref_cli[]" id="b_ref_cli" multiple class="select2">
                                                      <?php do {
                                                        $vals = explode(',', $row_rsproperties_client['b_ref_cli']);
                                                        if($row_rsReferencias['name'] != '') { ?>
                                                      <option value="<?php echo $row_rsReferencias['name'] ?>" <?php if (in_array($row_rsReferencias['name'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsReferencias['name'] ?></option>
                                                      <?php } } while ($row_rsReferencias = mysqli_fetch_assoc($rsReferencias));
                                                      $rows = mysqli_num_rows($rsReferencias );
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsReferencias , 0);
                                                        $row_rsReferencias = mysqli_fetch_assoc($rsReferencias );
                                                      } ?>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_ref_cli"); ?>
                                                </div> <?php */ ?>

                                                <?php /* ?><div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_ocultos_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="b_ocultos_cli" class="form-label"><?php __('Ocultos'); ?>:</label>
                                                    <select name="b_ocultos_cli[]" id="b_ocultos_cli" multiple class="select2">
                                                      <?php do {
                                                          $vals = explode(',', $row_rsproperties_client['b_ocultos_cli']); ?>
                                                      <option value="<?php echo $row_rsReferencias3['name'] ?>" <?php if (in_array($row_rsReferencias3['name'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsReferencias3['name'] ?></option>
                                                      <?php } while ($row_rsReferencias3 = mysqli_fetch_assoc($rsReferencias3)); ?>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_ocultos_cli"); ?>
                                                </div> <?php */ ?>

                                            </div>

                                          </div>

                                          <hr>

                                          <ul class="nav nav-tabs mb-3" role="tablist">
                                              <li class="nav-item" role="presentation">
                                                  <a href="#coincidencias" aria-controls="coincidencias" role="tab" data-bs-toggle="tab" class="nav-link active">
                                                      <span class="countlistnews">0</span> <?php __('Coincidencias'); ?> | <?php __('Valoraciones'); ?>:
                                                      <span class="badge bg-success countlistint"><i class="fa-solid fa-thumbs-up"></i> 0</span>
                                                      <span class="badge bg-danger countlistintno">0</span>
                                                  </a>
                                              </li>
                                              <li class="nav-item" role="presentation">
                                                  <a href="#descartes" aria-controls="descartes" role="tab" data-bs-toggle="tab" class="nav-link">
                                                      <span class="countlistexcluded">0</span> <?php __('Excluidos'); ?>
                                                  </a>
                                              </li>
                                          </ul>
                                          <div class="tab-content">

                                              <div role="tabpanel" class="tab-pane active" id="coincidencias">

                                                  <div id="resultados">
                                                      <table class="table w-lg-100 table-striped table-bordered align-middle" id="records-tables">
                                                        <thead class="table-light">
                                                          <tr>
                                                            <th style="min-width: 60px !important;">&nbsp;</th>
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
                                                            <th><?php __('Habitaciones'); ?></th>
                                                            <th><?php __('Aseos'); ?></th>
                                                            <th><?php __('Piscina'); ?></th>
                                                            <th><?php __('Parking'); ?></th>
                                                            <th id="actionsOrder" style="min-width: 150px !important;">
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
                                                                  <button type="button" class="btn btn-success btn-sm" id="records-tables-all"><i class="fa-regular fa-square-check" aria-hidden="true"></i></button>
                                                                  <button type="button" class="btn btn-danger btn-sm" id="records-tables-none"><i class="fa-regular fa-square" aria-hidden="true"></i></button>
                                                              </td>
                                                              <td>
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
                                                              <td><input type="text" name="nombre_pro" id="nombre_pro" class="form-control form-control-sm"></td>
                                                              <td><input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" class="form-control form-control-sm"></td>
                                                              <td><input type="text" name="ddd" id="ddd" class="form-control form-control-sm"></td>
                                                              <td><input type="text" name="xxxx" id="xxxx" class="form-control form-control-sm"></td>
                                                              <td><input type="text" name="parking_prop" id="parking_prop" class="form-control form-control-sm"></td>
                                                              <td><input type="text" name="piscina_prop" id="piscina_prop" class="form-control form-control-sm"></td>
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

                                                  <hr>

                                                  <div class="row btnsendcont" id="btnsendcont">

                                                      <div class="row mb-3">
                                                        <div class="col-md-6">
                                                          <div class="form-group>">
                                                              <select name="txt2" id="txt2" class="form-control">
                                                                  <option value=""><?php __('Selecciona una plantilla'); ?>...</option>
                                                                  <?php do { ?>
                                                                  <option value="<?php echo $row_rsTemplates['id_tmpl']?>"><?php echo $row_rsTemplates['name_'.$lang_adm.'_tmpl']?></option>
                                                                  <?php } while ($row_rsTemplates = mysqli_fetch_assoc($rsTemplates));
                                                                    $rows = mysqli_num_rows($rsTemplates);
                                                                    if($rows > 0) {
                                                                        mysqli_data_seek($rsTemplates, 0);
                                                                      $row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
                                                                    } ?>
                                                              </select>
                                                          </div>
                                                        </div>
                                                          <div class="col-md-6">
                                                              <div class="form-group>">
                                                                  <a href="#" class="btn btn-info btn-block btn-txt2 d-inline-block "><?php __('Aplicar plantilla'); ?></a>
                                                                  <a href="/intramedianet/templates/news.php" target="_blank" class="btn btn-primary d-inline-block ms-2"><?php __('Plantillas correo'); ?></a>
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <hr>

                                                      <div class="form-group mb-3">
                                                          <label for="subjcrt"><?php __('Asunto'); ?>:</label>
                                                          <input type="text" name="subjcrt" id="subjcrt" value="" size="32" maxlength="255" class="form-control" placeholder="<?php __('Asunto') ?>">
                                                      </div>

                                                      <div class="col-md-12">
                                                          <div class="form-group">
                                                            <label for="email_cli"><?php __('Comentario'); ?>:</label>
                                                            <div class="controls">
                                                            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control wysiwyg"></textarea>
                                                            </div>
                                                          </div>

                                                          <hr>

                                                          <div class="row">
                                                            <div class="col-md-12">
                                                              <legend><?php __('Ordenar inmuebles'); ?></legend>
                                                              <br>
                                                              <div class="dd ddp">
                                                                <ol class="dd-list">
                                                                  <li><?php __('Selecciona inmuebles para enviar'); ?></li>
                                                                </ol>
                                                              </div>
                                                              <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4" role="alert">
                                                                  <i class="fa-regular fa-circle-info label-icon"></i> <?php __('Selecciona 1, 3, 5 o más propiedades (número impar) para que la newsletter se vea correctamente. <br>Se mostrará 1 propiedad destacada y después 2 por fila; con números pares quedará un hueco vacío.'); ?>
                                                              </div>
                                                            </div>
                                                          </div>

                                                          <hr>

                                                          <div class="row">
                                                            <div class="col-md-12">
                                                              <br>
                                                              <div class="dd ddn">
                                                                <ol class="dd-list"></ol>
                                                              </div>
                                                              <br>
                                                            </div>
                                                          </div>
                                                          <?php foreach ($languages as $idm): ?>
                                                          <div class="row noticias1" id="news_<?php echo $idm ?>">
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label for="news1_<?php echo $idm ?>" class="form-label"><?php __('Noticias'); ?>:</label>
                                                                    <select name="news1_<?php echo $idm ?>" id="news1_<?php echo $idm ?>" class="select2" <?php if ($actNoticias == 0): ?>disabled<?php endif ?>>
                                                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                                        <?php do { ?>
                                                                        <option value="<?php echo $row_rsNews[$idm]['id_nws']?>">
                                                                            <?php echo $row_rsNews[$idm]['title_'.$idm.'_nws']?>
                                                                        </option>
                                                                        <?php
                                                                        } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                                                                          $rows = mysqli_num_rows($rsNews[$idm]);
                                                                          if($rows > 0) {
                                                                              mysqli_data_seek($rsNews[$idm], 0);
                                                                            $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                                                                          }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                              <div class="controls">
                                                                <div class="form-group">
                                                                  <br>
                                                                  <div class="controls">
                                                                    <button type="button" class="btn btn-primary w-100 selnews1" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <?php endforeach ?>
                                                          <?php if ($actPromociones == 1): ?>
                                                          <div class="row">
                                                            <div class="col-md-12">
                                                              <br>
                                                              <div class="dd ddpr">
                                                                <ol class="dd-list"></ol>
                                                              </div>
                                                              <br>
                                                            </div>
                                                          </div>
                                                          <?php foreach ($languages as $idm): ?>
                                                          <div class="row promociones1" id="prom_<?php echo $idm ?>">
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label for="prom1_<?php echo $idm ?>" class="form-label"><?php __('Promociones'); ?>:</label>
                                                                    <select name="prom1_<?php echo $idm ?>" id="prom1_<?php echo $idm ?>" class="select2" <?php if ($actPromociones == 0): ?>disabled<?php endif ?>>
                                                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                                        <?php do { ?>
                                                                        <option value="<?php echo $row_rsProm[$idm]['id_nws']?>">
                                                                            <?php echo $row_rsProm[$idm]['title_'.$idm.'_nws']?>
                                                                        </option>
                                                                        <?php
                                                                        } while ($row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]));
                                                                          $rows = mysqli_num_rows($rsProm[$idm]);
                                                                          if($rows > 0) {
                                                                              mysqli_data_seek($rsProm[$idm], 0);
                                                                            $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);
                                                                          }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                              <div class="controls">
                                                                <div class="form-group">
                                                                  <br>
                                                                  <div class="controls">
                                                                    <button type="button" class="btn btn-primary w-100 selprom1" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <?php endforeach ?>
                                                          <?php endif ?>
                                                          <?php if ($actZonas == 1): ?>
                                                          <div class="row">
                                                            <div class="col-md-12">
                                                              <br>
                                                              <div class="dd ddc">
                                                                <ol class="dd-list"></ol>
                                                              </div>
                                                              <br>
                                                            </div>
                                                          </div>
                                                          <?php foreach ($languages as $idm): ?>
                                                          <div class="row ciudades1" id="ciu_<?php echo $idm ?>">
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label for="ciu1_<?php echo $idm ?>" class="form-label"><?php __('Áreas'); ?>:</label>
                                                                    <select name="ciu1_<?php echo $idm ?>" id="ciu1_<?php echo $idm ?>" class="select2" <?php if ($actZonas == 0): ?>disabled<?php endif ?>>
                                                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                                        <?php do { ?>
                                                                        <option value="<?php echo $row_rsCities[$idm]['id_nws']?>">
                                                                            <?php echo $row_rsCities[$idm]['title_'.$idm.'_nws']?>
                                                                        </option>
                                                                        <?php
                                                                        } while ($row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]));
                                                                          $rows = mysqli_num_rows($rsCities[$idm]);
                                                                          if($rows > 0) {
                                                                              mysqli_data_seek($rsCities[$idm], 0);
                                                                            $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
                                                                          }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                              <div class="controls">
                                                                <div class="form-group">
                                                                  <br>
                                                                  <div class="controls">
                                                                    <button type="button" class="btn btn-primary w-100 selciu1" data-lang="<?php echo $idm ?>"><?php __('Seleccionar'); ?></button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <?php endforeach ?>
                                                          <?php endif ?>

                                                          <hr>

                                                          <div class="row">

                                                            <div class="col-md-4">

                                                                <input type="text" name="ccoSrch" id="ccoSrch" value="" size="32" maxlength="255" class="form-control" placeholder="CCO">

                                                            </div>

                                                            <div class="col-md-8">

                                                                <a href="#" class="btn btn-primary btnsend"><?php echo $lang['Enviar'] ?> <span class="countusers">0</span> <span class="countusers2"><?php echo $lang['Inmueble']  ?></span><span class="countusers3"><?php echo $lang['Inmuebles']  ?></span></a>
                                                                <a href="#" class="btn btn-success btnsendwhatsapp">Whatsapp: <?php echo $lang['Enviar'] ?> <span class="countusers">0</span> <span class="countusers2"><?php echo $lang['Inmueble']  ?></span><span class="countusers3"><?php echo $lang['Inmuebles']  ?></span></a>

                                                            </div>

                                                          </div>
                                                      </div>
                                                  </div>

                                              </div>

                                              <div role="tabpanel" class="tab-pane" id="descartes">

                                                <div id="descartados">

                                                  <table class="table w-lg-100 table-striped table-bordered align-middle" id="records-tables2">
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
                                                        <th><?php __('Habitaciones'); ?></th>
                                                        <th><?php __('Aseos'); ?></th>
                                                        <th><?php __('Piscina'); ?></th>
                                                        <th><?php __('Parking'); ?></th>
                                                        <th id="actionsOrder" style="min-width: 150px !important;">
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
                                                          <td><input type="text" name="nombre_pro" id="nombre_pro" class="form-control form-control-sm"></td>
                                                          <td><input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" class="form-control form-control-sm"></td>
                                                          <td><input type="text" name="ddd" id="ddd" class="form-control form-control-sm"></td>
                                                          <td><input type="text" name="xxxx" id="xxxx" class="form-control form-control-sm"></td>
                                                          <td><input type="text" name="parking_prop" id="parking_prop" class="form-control form-control-sm"></td>
                                                          <td><input type="text" name="piscina_prop" id="piscina_prop" class="form-control form-control-sm"></td>
                                                          <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td colspan="10" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>

                                                </div>

                                              </div>

                                          </div>

                                </div><!-- end card-body -->
                            </div>

                        </div>
                        <div class="tab-pane" id="tabsend">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Enviar'); ?> <?php __('Email'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group>">
                                                <label for="txt" class="form-label"><?php __('Texto'); ?>:</label>
                                                <select name="txt" id="txt" class="form-select">
                                                    <option value=""><?php __('Seleccione uno'); ?>...</option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsTemplates['id_tmpl']?>"><?php echo $row_rsTemplates['name_'.$lang_adm.'_tmpl']?></option>
                                                    <?php } while ($row_rsTemplates = mysqli_fetch_assoc($rsTemplates));
                                                      $rows = mysqli_num_rows($rsTemplates);
                                                      if($rows > 0) {
                                                          mysqli_data_seek($rsTemplates, 0);
                                                        $row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
                                                      } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group>">
                                                <label for="ref" class="form-label"><?php __('Referencia'); ?>:</label>
                                                <input type="text" class="select2references3" id="ref" name="ref" value="" tabindex="-1">
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group" class="form-label">
                                                <br>
                                                <a href="#" class="btn btn-info btn-block btn-txt"><?php __('Aplicar'); ?></a>
                                                <a href="/intramedianet/templates/news.php" target="_blank" class="btn btn-primary"><?php __('Plantillas correo'); ?></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                      <label for="subjectSM" class="form-label"><?php __('Asunto'); ?>:</label>
                                      <div class="controls">
                                      <input type="text" name="subjectSM" id="subjectSM" class="form-control">
                                      </div>
                                    </div>

                                    <div class="mb-4">
                                      <label for="email_cli" class="form-label"><?php __('Mensaje'); ?>:</label>
                                      <div class="controls">
                                      <textarea name="messagemail" id="messagemail" cols="30" rows="15" class="form-control wysiwyg"></textarea>
                                      </div>
                                    </div>

                                        <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4" role="alert">
                                            <i class="fa-regular fa-circle-info label-icon"></i><?php __('insert_client_mail'); ?>
                                        </div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <input type="text" name="ccoEml" id="ccoEml" value="" size="32" maxlength="255" class="form-control" placeholder="CCO">

                                        </div>

                                        <div class="col-md-8">

                                            <a href="#" class="btn btn-primary btnsendemail"><i class="fa-regular fa-paper-plane me-1"></i> <?php echo $lang['Enviar Respuesta/Email'] ?></a>
                                            <a href="#" class="btn btn-success btnwhatsapp mt-4 mt-md-0" target="_blank"><i class="fa-brands fa-whatsapp me-1"></i> <?php echo $lang['Enviar'] ?>: WhatsApp</a>

                                        </div>

                                    </div>

                                </div><!-- end card-body -->
                            </div>

                        </div>
                        <div class="tab-pane" id="tabinfo">

                            <?php if ($totalRows_rsratings > 0) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Valoraciones'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <table class="display table table-bordered align-middle" id="records-tables-rates" width="100%">
                                        <thead class="table-light">
                                        <tr>
                                          <th><?php __('Cliente'); ?></th>
                                          <th><?php __('Propiedad'); ?></th>
                                          <th><?php __('Valoración'); ?></th>
                                          <th><?php __('Localización'); ?></th>
                                          <th><?php __('Tipo'); ?></th>
                                          <th><?php __('Precio'); ?></th>
                                          <th><?php __('Habitaciones'); ?></th>
                                          <th><?php __('Otros'); ?></th>
                                          <th><?php __('Fecha'); ?></th>
                                          <th id="actions"></th>
                                        </tr>
                                        <?php /* ?>
                                        <tr class="search-inputs-reg">
                                          <td><input type="text" name="cli" id="cli" class="form-control form-select-sm"></td>
                                          <td><input type="text" name="prop" id="prop" class="form-control form-select-sm"></td>
                                          <td><input type="hidden" name="rate" id="rate">

                                              <select name="rate_sel" id="rate_sel" class="form-select form-select-sm">
                                                  <option value=""><?php __('Todos'); ?></option>
                                                  <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                  <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                             </select>

                                          </td>
                                          <td><input type="hidden" name="loc" id="loc">

                                              <select name="loc_sel" id="loc_sel" class="form-select form-select-sm">
                                                  <option value=""><?php __('Todos'); ?></option>
                                                  <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                  <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                             </select>

                                          </td>
                                          <td><input type="hidden" name="tp" id="tp">

                                              <select name="tp_sel" id="tp_sel" class="form-select form-select-sm">
                                                  <option value=""><?php __('Todos'); ?></option>
                                                  <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                  <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                             </select>

                                          </td>
                                          <td><input type="hidden" name="pr" id="pr">

                                              <select name="pr_sel" id="pr_sel" class="form-select form-select-sm">
                                                  <option value=""><?php __('Todos'); ?></option>
                                                  <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                  <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                             </select>

                                          </td>
                                          <td><input type="hidden" name="bd" id="bd">

                                              <select name="bd_sel" id="bd_sel" class="form-select form-select-sm">
                                                  <option value=""><?php __('Todos'); ?></option>
                                                  <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                  <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                             </select>

                                          </td>
                                          <td><input type="hidden" name="od" id="od">

                                              <select name="od_sel" id="od_sel" class="form-select form-select-sm">
                                                  <option value=""><?php __('Todos'); ?></option>
                                                  <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                                  <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                             </select>

                                          </td>
                                          <td><input type="text" name="datef" id="datef" class="form-control form-select-sm"></td>
                                          <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                                        </tr>
                                        <?php */ ?>
                                      </thead>
                                      <tbody>
                                        <tr>
                                        <tr>
                                          <td colspan="10" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                        </tr>
                                      </tbody>
                                    </table>

                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                            <?php if ($totalRows_rsConsultasProp > 0) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Consultas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <?php do { ?>
                                  <div class="card bg-light">
                                      <div class="card-body">
                                          <h5 class="mb-1"><?php if($row_rsConsultasProp['read_cons'] == 0) { ?><i class="fa-regular fa-xmark text-danger"></i><?php } else { ?><i class="fa-regular fa-check text-success"></i><?php } ?> | <?php echo date("d-m-Y H:i", strtotime($row_rsConsultasProp['fecha_cons'])) ?> // <?php __('Propiedad'); ?>: <a href="/intramedianet/properties/properties-form.php?id_prop=<?php echo $row_rsConsultasProp['idprop']; ?>" target="_blank" class="btn btn-soft-primary btn-sm" style="margin: 2px"><?php echo $row_rsConsultasProp['inmueble_cons']; ?></a></h5>
                                          <p class="mb-1"><?php echo KT_FormatForList($row_rsConsultasProp['comentario_consas'], 300) ?></p>
                                          <p class="mb-0"><a href="/intramedianet/properties/enquiries-form.php?id_cons=<?php echo $row_rsConsultasProp['id_cons'] ?>&amp;KT_back=1" class="btn btn-primary btn-sm"> <?php __('Ver'); ?> </a></p>
                                      </div>

                                  </div>
                                  <?php } while ($row_rsConsultasProp = mysqli_fetch_assoc($rsConsultasProp)); ?>

                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                            <?php if ($totalRows_rsEvents > 0 && $actCalendar == 1) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Eventos'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered records-tables-simple3 align-middle" id="events-table">
                                            <thead class="table-light">
                                            <tr>
                                                <th><?php __('Título'); ?></th>
                                                <th><?php __('Categoría'); ?></th>
                                                <th><?php __('Fecha inicio'); ?></th>
                                                <th><?php __('Fecha final'); ?></th>
                                                <th><?php __('Propiedades'); ?></th>
                                                <th><?php __('Administrador'); ?></th>
                                                <th><?php __('Lugar'); ?></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php do { ?>
                                              <tr>
                                                  <td><?php echo $row_rsEvents['titulo_ct']; ?></td>
                                                  <td><span class="badge" style="background: <?php echo $row_rsEvents['color_ct']; ?>;"><?php echo $row_rsEvents['cat']; ?></span></td>
                                                  <td data-sort="<?php echo $row_rsEvents['inicio_ct'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEvents['inicio_ct'])); ?></td>
                                                  <td data-sort="<?php echo $row_rsEvents['final_ct'] ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsEvents['final_ct'])); ?></td>
                                                  <td><?php echo addRefs($row_rsEvents['property_ct']); ?></td>
                                                  <td><?php echo $row_rsEvents['nombre_usr']; ?></td>
                                                  <td><?php echo $row_rsEvents['lugar_ct']; ?></td>
                                                  <td><a href="javascript:;" class="btn btn-primary btn-sm edit-event" data-id="<?php echo $row_rsEvents['id_ct'] ?>"><i class="fa-regular fa-eye"></i></a></td>
                                              </tr>
                                              <?php } while ($row_rsEvents = mysqli_fetch_assoc($rsEvents)); ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                            <?php if ($totalRows_rsTasks > 0 && $actTasks == 1) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Tareas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered records-tables-simple4 align-middle" id="tasks-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><?php __('Propietario de la tarea'); ?></th>
                                                    <th><?php __('Asunto'); ?></th>
                                                    <th><?php __('Propiedad'); ?></th>
                                                    <th><?php __('Fecha de vencimiento'); ?></th>
                                                    <th><?php __('Prioridad'); ?></th>
                                                    <th><?php __('Status'); ?></th>
                                                    <th></th>
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
                                                  <td><a href="/intramedianet/tasks/tasks-form.php?id_tsk=<?php echo $row_rsTasks['id_tsk']; ?>&amp;KT_back=1" class="btn btn-primary btn-sm"><i class="fa-regular fa-eye"></i></a></td>
                                              </tr>
                                              <?php } while ($row_rsTasks = mysqli_fetch_assoc($rsTasks)); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card-body -->
                            </div>
                            <?php } ?>

                            <?php if ($totalRows_rsEmails > 0) { ?>
                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Seguimiento de envios'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered records-tables-simple2 align-middle" id="emails-table">
                                          <thead class="table-light">
                                            <tr>
                                                <th><?php __('Referencia'); ?></th>
                                                <th><?php __('Administrador'); ?></th>
                                                <th><?php __('Dónde'); ?></th>
                                                <th><?php __('Estado'); ?></th>
                                                <th><?php __('Enviado'); ?></th>
                                                <th style="width: 140px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php do { ?>
                                              <tr>
                                                  <td>
                                                    <?php $ids = array(); if(isset($row_rsEmails['id_prop'])) $ids = explode(',', $row_rsEmails['id_prop']); ?>
                                                    <?php $rfs = array(); if(isset($row_rsEmails['referencia_prop'])) $rfs = explode(',', $row_rsEmails['referencia_prop']); ?>
                                                    <?php $x = 0; ?>
                                                    <?php foreach ($ids as $value): ?>
                                                        <?php if ($value != ''): ?>
                                                            <a href="/intramedianet/properties/properties-form.php?id_prop=<?php echo $value; ?>" target="_blank" class="btn btn-soft-primary btn-sm" style="margin: 2px"><?php echo $rfs[$x++]; ?></a>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                  </td>
                                                  <td><?php echo $row_rsEmails['usr_log']; ?></td>
                                                  <td><?php
                                                  switch ($row_rsEmails['type_log']) {
                                                    case '1':
                                                      echo $lang['Ficha clientes'];
                                                      break;
                                                    case '2':
                                                      echo $lang['Búsqueda de inmuebles'];
                                                      break;
                                                    case '3':
                                                      echo $lang['Bajada de precio'];
                                                      break;
                                                    case '4':
                                                      echo $lang['Clientes interesados'];
                                                      break;
                                                    case '5':
                                                      echo $lang['Lista de correo'];
                                                      break;
                                                    case '6':
                                                      echo $lang['Clientes interesados'];
                                                      break;
                                                    case '7':
                                                      echo $lang['Email'];
                                                      break;
                                                    case '7':
                                                      echo $lang['Colaborador'];
                                                      break;
                                                  }
                                                  ?></td>
                                                  <td><?php
                                                  switch ($row_rsEmails['result_log']) {
                                                    case 'delivered':
                                                      echo '<span class="badge text-bg-secondary text-uppercase fz-6">' . $lang['delivered'] . '</span>';
                                                      break;
                                                    case 'opens':
                                                      echo '<span class="badge text-bg-success text-uppercase fz-6">' . $lang['opens'] . '</span>';
                                                      break;
                                                    case 'clicks':
                                                      echo '<span class="badge text-bg-secondary text-uppercase fz-6">' . $lang['clicks'] . '</span>';
                                                      break;
                                                    case 'hard_bounces':
                                                      echo '<span class="badge text-bg-danger text-uppercase fz-6">' . $lang['hard_bounces'] . '</span>';
                                                      break;
                                                    case 'soft_bounces':
                                                      echo '<span class="badge text-bg-warning text-uppercase fz-6">' . $lang['soft_bounces'] . '</span>';
                                                      break;
                                                    case 'complaints':
                                                      echo '<span class="badge text-bg-danger text-uppercase fz-6">' . $lang['complaints'] . '</span>';
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
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Seguimiento de cambios'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-bordered align-middle align-middle records-tables-simple" id="history-table" width="100%">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><?php __('Usuario'); ?></th>
                                                    <th><?php __('Acción'); ?></th>
                                                    <th><?php __('Fecha'); ?></th>
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
                        <?php if ($actFerias == 1) { ?>
                        <!-- Ferias -->
                        <div class="tab-pane" id="tabferias">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1">
                                          <?php __('Ferias'); ?> & <?php __('Eventos'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    

                                        <div class="col-lg-8">
                                          <div class="row">

                                            <div class="col-md-6">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "birthday_cli") != '') { ?>has-error<?php } ?>">
                                                  <label for="birthday_cli" class="form-label"><?php __('Cumpleaños'); ?>:</label>
                                                  <input type="text" name="birthday_cli" id="birthday_cli" value="<?php echo KT_formatDate($row_rsproperties_client['birthday_cli']); ?>" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                                                  <?php echo $tNGs->displayFieldError("properties_client", "birthday_cli"); ?>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "birthday2_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="birthday2_cli" class="form-label"> <?php __('Partners Birthday'); ?>:</label>
                                                <input type="text" name="birthday2_cli" id="birthday2_cli" value="<?php echo KT_formatDate($row_rsproperties_client['birthday2_cli']); ?>" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                                                <?php echo $tNGs->displayFieldError("properties_client", "birthday2_cli"); ?>
                                              </div>
                                          </div>

                                            <div class="col-md-6">
                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "situation_cli") != '') { ?>has-error<?php } ?>">
                                                    <label for="situation_cli" class="form-label"><?php __('Situación de vivienda actual'); ?>:</label>
                                                    <select name="situation_cli" id="situation_cli" class="form-select">
                                                        <option value="Owner House" <?php if (isset($row_rsproperties_client['situation_cli']) && !(strcmp('Owner House', $row_rsproperties_client['situation_cli']))) {echo "SELECTED";} ?>>
                                                          <?php __('Owner House'); ?> </option>
                                                        <option value="Rental House" <?php if (isset($row_rsproperties_client['situation_cli']) && !(strcmp('Rental House', $row_rsproperties_client['situation_cli']))) {echo "SELECTED";} ?>>
                                                          <?php __('Rental House'); ?> </option>
                                                    </select>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "current_home_cli") != '') { ?>has-error<?php } ?>">
                                                        <label for="current_home_cli" class="form-label"><?php __('Value of current home  (in euro)'); ?>:</label>
                                                        <input type="text" name="current_home_cli" id="current_home_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['current_home_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_client", "current_home_cli"); ?>
                                                    </div>
                                                    
                                              </div>

                                              

                                              <div class="col-md-6">
                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "mortgage_location_cli") != '') { ?>has-error<?php } ?>">

                                                    <label for="mortgage_location_cli" class="form-label"><?php __('Mortgage in'); ?>:</label>

                                                     <input type="text" placeholder="<?php __('Spain'); ?>, <?php __('Netherlands'); ?>, ... " name="mortgage_location_cli" id="mortgage_location_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['mortgage_location_cli']); ?>" size="32" maxlength="255" class="form-control">

                                                </div>
                                              </div>

                                               <div class="col-md-6">
                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "percentage_mortgage_cli") != '') { ?>has-error<?php } ?>">

                                                    <label for="percentage_mortgage_cli" class="form-label"><?php __('Amount in percentage of mortgage'); ?>:</label>
                                                    <select name="percentage_mortgage_cli" id="percentage_mortgage_cli" class="form-select">
                                                        <option value="40" <?php if (isset($row_rsproperties_client['percentage_mortgage_cli']) && !(strcmp('40', $row_rsproperties_client['percentage_mortgage_cli']))) {echo "SELECTED";} ?>>40% </option>
                                                        <option value="50" <?php if (isset($row_rsproperties_client['percentage_mortgage_cli']) && !(strcmp('50', $row_rsproperties_client['percentage_mortgage_cli']))) {echo "SELECTED";} ?>>50% </option>
                                                        <option value="60" <?php if (isset($row_rsproperties_client['percentage_mortgage_cli']) && !(strcmp('60', $row_rsproperties_client['percentage_mortgage_cli']))) {echo "SELECTED";} ?>>60% </option>
                                                        <option value="70" <?php if (isset($row_rsproperties_client['percentage_mortgage_cli']) && !(strcmp('70', $row_rsproperties_client['percentage_mortgage_cli']))) {echo "SELECTED";} ?>>70% </option>
                                                    </select>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "mortgage_amount_cli") != '') { ?>has-error<?php } ?>">
                                                        <label for="mortgage_amount_cli" class="form-label"><?php __('Current mortgage amount in euro  (in euro)'); ?>:</label>
                                                        <input type="text" name="mortgage_amount_cli" id="mortgage_amount_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['mortgage_amount_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_client", "mortgage_amount_cli"); ?>
                                                    </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "current_gross_cli") != '') { ?>has-error<?php } ?>">
                                                        <label for="current_gross_cli" class="form-label"><?php __('Current gross mortgage/rental burden'); ?>:</label>
                                                        <input type="text" name="current_gross_cli" id="current_gross_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['current_gross_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_client", "current_gross_cli"); ?>
                                                    </div>
                                              </div>
                                              
                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "current_partner_cli") != '') { ?>has-error<?php } ?>">
                                                        <label for="current_partner_cli" class="form-label"><?php __('Current gross mortgage/rental burden'); ?>:</label>
                                                        <input type="text" name="current_partner_cli" id="current_partner_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['current_partner_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_client", "current_partner_cli"); ?>
                                                    </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "resources_cli") != '') { ?>has-error<?php } ?>">
                                                        <label for="resources_cli " class="form-label"><?php __('Available own resources (in euro)'); ?>:</label>
                                                        <input type="text" name="resources_cli" id="resources_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['resources_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_client", "resources_cli"); ?>
                                                    </div>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-lg-4">

                                             <div class="form-check form-switch form-switch-lg pt-0 mt-md-2 mb-4" dir="ltr">
                                                        <input type="checkbox" name="financing_cli" id="financing_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['financing_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['financing_cli']),"1"))) {echo "checked";} ?>>
                                                        <label class="form-check-label" for="financing_cli"><?php __('Financing options required?'); ?></label>
                                                        <?php echo $tNGs->displayFieldError("properties_client", "financing_cli"); ?>
                                                  </div>

                                                        
                                            <label for="extrainfo_cli" class="form-label"><?php __('Información adicional'); ?>:</label>

                                            <div class="form-group <?php if($tNGs->displayFieldError("properties_client", "extrainfo_cli") != '') { ?>has-error<?php } ?>">
                                                <textarea type="text" name="extrainfo_cli" id="extrainfo_cli" cols="50" rows="10" class="form-control"><?php if(isset($row_rsproperties_client['extrainfo_cli'])) echo KT_escapeAttribute($row_rsproperties_client['extrainfo_cli']); ?></textarea>
                                                <?php echo $tNGs->displayFieldError("properties_client", "extrainfo_cli"); ?>
                                               
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="tab-pane" id="tabsearches">

                            <div class="card position-relative">
                                <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Búsquedas guardadas'); ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row">


                                        <?php if(isset($searchs)): ?>
                                            <?php   foreach ($searchs as $search): ?>
                                                  <div class="col-md-6">
                                                  <?php if ($search['send'] == 1): ?>
                                                    <div class="panel panel-success">
                                                  <?php else: ?>
                                                    <div class="panel panel-danger">
                                                  <?php endif ?>
                                                      <div class="panel-heading">
                                                        <div class="panel-title">
                                                          <i class="fa fa-search" aria-hidden="true"></i> <?php echo date("d-m-Y H:i", strtotime($search['created'])); ?>
                                                        </div>
                                                      </div>
                                                      <br>
                                                      <div class="panel-body">
                                                          <ul class="list-group">
                                                          <?php foreach ($search[0] as $key => $value): ?>
                                                            <?php if ($key == 'st'): ?>
                                                                <li class="list-group-item"><b><?php __('Estatus') ?>:</b>
                                                                  <?php foreach ($value as $k => $type): ?><?php if ($k > 0): ?>, <?php endif ?><?php echo getStatus($type) ?><?php endforeach ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'tp'): ?>
                                                                <li class="list-group-item"><b><?php __('Tipo') ?>:</b>
                                                                  <?php foreach ($value as $k => $type): ?><?php if ($k > 0): ?>, <?php endif ?><?php echo getTypeSRCH($type) ?><?php endforeach ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'lopr'): ?>
                                                                <li class="list-group-item"><b><?php __('Provincia') ?>:</b>
                                                                  <?php foreach ($value as $k => $type): ?><?php if ($k > 0): ?>, <?php endif ?><?php echo getTypeProv($type) ?><?php endforeach ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'coast'): ?>
                                                                <li class="list-group-item"><b><?php __('Costa') ?>:</b>
                                                                  <?php foreach ($value as $k => $type): ?><?php if ($k > 0): ?>, <?php endif ?><?php echo getCoast($type) ?><?php endforeach ?>
                                                                </li>
                                                            <?php endif ?>
                                                            
                                                            <?php if ($key == 'loct'): ?>
                                                                <li class="list-group-item"><b><?php __('Ciudad') ?>:</b>
                                                                  <?php foreach ($value as $k => $type): ?><?php if ($k > 0): ?>, <?php endif ?><?php echo getTypeTown($type) ?><?php endforeach ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'lozn'): ?>
                                                                <li class="list-group-item"><b><?php __('Zona') ?>:</b><?php foreach ($value as $k => $type): ?><?php if ($k > 0): ?>, <?php endif ?><?php echo getTypeZone($type) ?>
                                                                    <?php endforeach ?>
                                                                </li>

                                                            <?php endif ?>
                                                            <?php if ($key == 'rf'): ?>
                                                                <li class="list-group-item"><b><?php __('Referencia') ?>:</b>
                                                                  <?php echo $value; ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'bd'): ?>
                                                                <li class="list-group-item"><b><?php __('Habitaciones') ?>:</b>
                                                                  <?php echo $value; ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'bt'): ?>
                                                                <li class="list-group-item"><b><?php __('Aseos') ?>:</b>
                                                                  <?php echo $value; ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'prds'): ?>
                                                                <li class="list-group-item"><b><?php __('Precio desde') ?>:</b>
                                                                  <?php if(isset($value) && $value!='') echo number_format($value, 0, ',', '.'); ?> 
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'prhs'): ?>
                                                              <?php if ($value != ''): ?>

                                                                <li class="list-group-item"><b><?php __('Precio hasta') ?>:</b>
                                                                  <?php if(isset($value)) echo number_format($value, 0, ',', '.'); ?>
                                                                </li>
                                                              <?php endif ?>

                                                            <?php endif ?>

                                                            <?php if ($key == 'pricerange'): ?>
                                                                <?php if (isset($value) && $value != ''): ?>
                                                                    <li class="list-group-item"><b><?php __('Precio') ?>:</b>
                                                                    <?php
                                                                    switch ($value)
                                                                    {
                                                                        case '1':
                                                                           echo '0 - 40.000 €';
                                                                          break;
                                                                          case '2':
                                                                            echo '40.000 - 60.000 €';
                                                                          break;
                                                                          case '3':
                                                                             echo '60.000 - 80.000 €';
                                                                          break;
                                                                          case '4':
                                                                            echo '80.000 - 100.000 €';
                                                                          break;
                                                                          case '5':
                                                                            echo '100.000 - 125.000 €';
                                                                          break;
                                                                          case '6':
                                                                            echo '125.000 - 150.000 €';
                                                                          break;
                                                                          case '7':
                                                                            echo '150.000 - 200.000 €';
                                                                          break;
                                                                          case '8':
                                                                            echo '200.000 - 250.000 €';
                                                                          break;
                                                                          case '9':
                                                                            echo '250.000 - 300.000 €';
                                                                          break;

                                                                        default:
                                                                            echo '+300.000 €';
                                                                          break;
                                                                      }
                                                                  ?>
                                                                    </li>
                                                                <?php endif?>
                                                            <?php endif?>


                                                            <?php if ($key == 'pool'): ?>
                                                                <li class="list-group-item"><b><?php __('Piscina') ?>:</b>
                                                                  <?php echo getTypePool($value); ?>
                                                                </li>
                                                            <?php endif ?>
                                                            <?php if ($key == 'tags'): ?>
                                                                <?php foreach ($value as $k => $type): ?>
                                                                    <?php if ($type == 3): ?>
                                                                        <li class="list-group-item"><b><?php __('Golf') ?></b></li>
                                                                    <?php endif ?>
                                                                    <?php if ($type == 5): ?>
                                                                        <li class="list-group-item"><b><?php __('Primera línea') ?></b></li>
                                                                    <?php endif ?>
                                                                    <?php if ($type == 1): ?>
                                                                        <li class="list-group-item"><b><?php __('Vistas al mar') ?></b></li>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                          <?php endforeach ?>
                                                          </ul>
                                                      </div>
                                                      <br>
                                                  </div>
                                                  </div>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                    </div>

                                </div><!-- end card-body -->
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
    var strSearch = '<?php __('Buscar') ?>';
    var strFieldSubject = '<?php __('El campo asunto es requerido') ?>';
    var strFieldMessage = '<?php __('El campo mensaje es requerido') ?>';
    var idClient = '<?php echo $clientId; ?>';
    var oTable;
    var selected = new Array();

    var $pageNum_rsProperties = '<?php echo $_SESSION['pageNum_rsProperties' . $_GET['id_cli']] ?>';
    var $totalRows_rsProperties = '<?php echo $_SESSION['totalRows_rsProperties' . $_GET['id_cli']] ?>';

    var $pageNum_rsProperties2 = '<?php echo $_SESSION['pageNum_rsProperties2' . $_GET['id_cli']] ?>';
    var $totalRows_rsProperties2 = '<?php echo $_SESSION['totalRows_rsProperties2' . $_GET['id_cli']] ?>';

    var $pageNum_rsProperties3 = '<?php echo $_SESSION['pageNum_rsProperties3' . $_GET['id_cli']] ?>';
    var $totalRows_rsProperties3 = '<?php echo $_SESSION['totalRows_rsProperties3' . $_GET['id_cli']] ?>';
    </script>

    <script>
    $(document).on('click', '.btn-clnt', function(e) {
        e.preventDefault();
        $.get($(this).attr('href'), function(data) {
          getProps();
        });
    });
    $(document).on('click', '.btn-clnt2', function(e) {
        e.preventDefault();
        $.get($(this).attr('href'), function(data) {
          getProps();
        });
    });
    $('.btn-add-next-call').click(function(e) {
        e.preventDefault();
        $('#next_call_cli').val($(this).data('futur'));
    });
    </script>

    <script>
        var intr_sub = new Array();
        var intr_txt = new Array();

        <?php do { ?>
          <?php foreach ($languages as $langval): ?>
          intr_sub['<?php echo $langval ?><?php echo $row_rsTemplates['id_tmpl']?>'] = "<?php echo mysqli_real_escape_string($inmoconn,$row_rsTemplates['subject_'.$langval.'_tmpl']); ?>";
          intr_txt['<?php echo $langval ?><?php echo $row_rsTemplates['id_tmpl']?>'] = "<?php echo mysqli_real_escape_string($inmoconn, $row_rsTemplates['content_'.$langval.'_tmpl']); ?>";
          <?php endforeach ?>
        <?php } while ($row_rsTemplates = mysqli_fetch_assoc($rsTemplates));
        $rows = mysqli_num_rows($rsTemplates);
        if($rows > 0) {
            mysqli_data_seek($rsTemplates, 0);
          $row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
        } ?>



        $('.btn-txt').click(function(e) {
            e.preventDefault();
            // if ($('#txt').val() == '') {
            //     alert('<?php __('Seleccione un texto'); ?>');
            //     $('#txt').focus();
            //     return false;
            // }
            $('#subjectSM').val(intr_sub[$('#idioma_cli').val()+$('#txt').val()]);
            var txt = intr_txt[$('#idioma_cli').val()+$('#txt').val()];
            $('#messagemail').redactor('source.setCode', txt.replace('{{PROPERTY}}', '{{PROPERTY-' + $('#ref').val() + '}}'));
            return false;
        });

        $('.btn-txt2').click(function(e) {
            e.preventDefault();
            if ($('#txt2').val() == '') {
                alert('<?php __('Seleccione un texto'); ?>');
                $('#txt2').focus();
                return false;
            }
            $('#subjcrt').val(intr_sub[$('#idioma_cli').val()+$('#txt2').val()]);
            var txt = intr_txt[$('#idioma_cli').val()+$('#txt2').val()].replace('{{PROPERTY}}', '');
            $('#comment').redactor('source.setCode', txt);
            return false;
        });
    </script>

    <script src="_js/clients-form.js?id=<?php echo time() ?>" type="text/javascript"></script>

    <script>
          $(document).on('click', '.sendfiles', function(e) {

          e.preventDefault();

          var ids = [];

          $('.sendfile').each(function( index ) {
            if ($( this ).is(":checked")) {
              ids.push($( this ).val());
            }
          });

          alert(ids);

          if (ids.toString() != '' && $('#colbrs').val() != '') {
            if (confirm('<?php __('Are you sure want to send the selected files?'); ?>')) {
            $.get('files_send.php?ids=' + ids.toString() + '&email=' + $('#colbrs').val() + '&id_cli=<?php echo $clientId; ?>', function(data) {
                if (data == 'ok') {
                    alert('<?php __('Los archivos se han enviado correctamente.'); ?>');
                }
            });
          }

          }
        });
    </script>

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

    <div id="myModalSource" class="modal fade" tabindex="-1" aria-labelledby="myModalSourceLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalSourceLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir Origen'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                      <div class="mb-4">
                          <label for="category_en_sts" class="form-label"><?php __('Origen'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_en_sts" id="category_en_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="category_es_sts" class="form-label"><?php __('Origen'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_es_sts" id="category_es_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal5" class="modal fade" tabindex="-1" aria-labelledby="myModal5Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModal5Label"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir Estatus'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                      <div class="mb-4">
                          <label for="category_en_sts" class="form-label"><?php __('Estatus'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_en_sts" id="category_en_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="category_es_sts" class="form-label"><?php __('Estatus'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_es_sts" id="category_es_sts" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal6" class="modal fade" tabindex="-1" aria-labelledby="myModal6Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModal6Label"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir Captado por'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                      <div class="mb-4">
                          <label for="category_en_cap" class="form-label"><?php __('Captado por'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/en.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_en_cap" id="category_en_cap" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="category_es_cap" class="form-label"><?php __('Captado por'); ?>:</label>
                          <div class="input-group">
                            <span class="input-group-text"><img src="/intramedianet/includes/assets/imgs/flags/es.svg" alt="" style="height: 20px;"></span>
                            <input type="text" name="category_es_cap" id="category_es_cap" value="" size="32" maxlength="255" class="form-control required" required>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal" class="modal fade" data-bs-focus="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir cita'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form method="post" id="form10" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate>
                <div class="modal-body bg-light">

                      <div class="row">
                          <div class="col-md-7">
                              <div class="mb-2">
                                  <label for="titulo_ct"><?php __('Título'); ?>:</label>
                                  <input type="text" name="titulo_ct" id="titulo_ct" value="" size="32" maxlength="255" class="form-control required" required>
                                  <div class="invalid-feedback">
                                      <?php __('Este campo es obligatorio.'); ?>
                                  </div>
                                  <input type="hidden" name="id_ct" id="id_ct" value="">
                              </div>
                              <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="inicio_ct"><?php __('Fecha inicio'); ?>:</label>
                                        <input type="text" name="inicio_ct" id="inicio_ct" value="" size="32" maxlength="255" class="form-control datepicktime required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="final_ct"><?php __('Fecha final'); ?>:</label>
                                        <input type="text" name="final_ct" id="final_ct" value="" size="32" maxlength="255" class="form-control datepicktime required" required>
                                        <div class="invalid-feedback">
                                            <?php __('Este campo es obligatorio.'); ?>
                                        </div>
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="categoria_ct"><?php __('Categoría'); ?>:</label>
                                            <select name="categoria_ct" id="categoria_ct" class="form-select required" required>
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                do {
                                                    ?>
                                                <option value="<?php echo $row_rscategorias['id_ct']?>"><?php echo $row_rscategorias['category_'.$lang_adm.'_ct']?></option>
                                                <?php
                                                } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                                $rows = mysqli_num_rows($rscategorias);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rscategorias, 0);
                                                    $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                        </div>

                                  </div>
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="user_ct"><?php __('Usuario'); ?>:</label>
                                            <select name="user_ct" id="user_ct" class="required select2" required>
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                do {
                                                    ?>
                                                <option value="<?php echo $row_rsusuarios['id_usr']?>"<?php if (isset($_SESSION['kt_login_id']) && !(strcmp($row_rsusuarios['id_usr'], $_SESSION['kt_login_id']))) {
                                                    echo " SELECTED";
                                                } ?>><?php echo $row_rsusuarios['nombre_usr']?></option>
                                                <?php
                                                } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                                $rows = mysqli_num_rows($rsusuarios);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsusuarios, 0);
                                                    $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                        </div>

                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="users_ct"><?php __('Clientex'); ?>:</label>
                                            <select name="users_ct" id="users_ct" class="select2">
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                    do {
                                                ?>
                                                    <option value="<?php echo $row_rsclientes['id_cli']?>" <?php if (isset($_GET['id_cli']) && $_GET['id_cli'] == $row_rsclientes['id_cli']): ?>selected<?php endif ?>><?php echo $row_rsclientes['nombre_cli']?> <?php echo $row_rsclientes['apellidos_cli']?></option>
                                                <?php
                                                } while ($row_rsclientes = mysqli_fetch_assoc($rsclientes));
                                                $rows = mysqli_num_rows($rsclientes);
                                                if($rows > 0) {
                                                    mysqli_data_seek($rsclientes, 0);
                                                    $row_rsclientes = mysqli_fetch_assoc($rsclientes);
                                                }
                                                ?>
                                            </select>
                                        </div>

                                  </div>
                                  <div class="col-md-6">

                                        <div class="mb-2">
                                            <label for="vendedores_ct"><?php __('Propietario'); ?>:</label>
                                            <select name="vendedores_ct" id="vendedores_ct" class="select2">
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php
                                                do {
                                                if(isset($row_rsvendor['id_pro'])){
                                                ?>
                                                <option value="<?php echo $row_rsvendor['id_pro']?>" <?php if ( isset($_GET['id_pro']) && $_GET['id_pro'] == $row_rsvendor['id_pro']): ?>selected<?php endif ?>><?php echo $row_rsvendor['nombre_pro']?> <?php echo $row_rsvendor['apellidos_pro']?></option>
                                                <?php }
                                                } while ($row_rsvendor = mysqli_fetch_assoc($rsvendor));
                                                  $rows = mysqli_num_rows($rsvendor);
                                                  if($rows > 0) {
                                                      mysqli_data_seek($rsvendor, 0);
                                                    $row_rsvendor = mysqli_fetch_assoc($rsvendor);
                                                  }
                                                ?>
                                            </select>
                                        </div>

                                  </div>
                              </div>

                              <div class="mb-2">
                                  <label for="property_ct"><?php __('Propiedades'); ?>:</label>
                                  <select name="property_ct[]" id="property_ct" multiple class="select2">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <?php
                                      do {
                                        if(isset($row_rsproperties_client['property_ct']))
                                            $vals = explode(',', $row_rsproperties_client['property_ct']);
                                        else
                                            $vals = array();
                                        ?>
                                      <option value="<?php echo $row_rspropiedad['id_prop']?>" <?php if (in_array($row_rspropiedad['id_prop'], $vals)) {
                                          echo "selected=\"selected\"";
                                      } ?>><?php echo $row_rspropiedad['referencia_prop']?></option>
                                      <?php
                                      } while ($row_rspropiedad = mysqli_fetch_assoc($rspropiedad));
                                      $rows = mysqli_num_rows($rspropiedad);
                                      if($rows > 0) {
                                          mysqli_data_seek($rspropiedad, 0);
                                          $row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
                                      }
                                      ?>
                                  </select>
                              </div>

                              <div class="mb-2">
                                  <label for="lugar_ct"><?php __('Lugar'); ?>:</label>
                                  <input type="text" name="lugar_ct" id="lugar_ct" value="" size="32" maxlength="255" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-5">
                              <div class="form-group">
                                  <label for="notas_ct"><?php __('Notas'); ?>:</label>
                                  <textarea name="notas_ct" id="notas_ct" cols="40" rows="19" class="form-control"></textarea>
                              </div>
                              <a href="#" class="btn btn-success btn-sm addHistCit float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                          </div>
                      </div>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" id="btn-close-save" name="KT_Insert1"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar y guardar'); ?>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm mt-4" id="btn-close"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar'); ?>
                    </a>
                </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<script type="text/javascript">
    $('.select2references').select2({
        multiple:true,
        ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-references-select.php?q=' + params;
        },
        dataType: 'json',
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        // cache: true,
        },
        placeholder: '',
        minimumInputLength: 3,
    });
    $('.select2references2').select2({
        multiple:true,
        ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-references-select.php?q=' + params;
        },
        dataType: 'json',
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        // cache: true,
        },
        placeholder: '',
        minimumInputLength: 3,
    });
    $('.select2references3').select2({
        multiple:true,
        ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-references-select.php?q=' + params;
        },
        dataType: 'json',
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        // cache: true,
        },
        placeholder: '',
        minimumInputLength: 3,
    });
    <?php if (isset($row_rsproperties_client['visited_cli']) && $row_rsproperties_client['visited_cli'] != ''): ?>
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/intramedianet/properties/properties-references-select-multiple.php?q=<?php echo $row_rsproperties_client['visited_cli'] ?>'
    }).done(function (data) {
        $(".select2references").select2('data', data);
    });
    <?php endif ?>
    <?php if ($row_rsproperties_client['ref_comprado_cli'] != ''): ?>
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/intramedianet/properties/properties-references-select-multiple.php?q=<?php echo $row_rsproperties_client['ref_comprado_cli'] ?>'
    }).done(function (data) {
        $(".select2references2").select2('data', data);
    });
    <?php endif ?>
</script>

<script>
  $('.btnsendwhatsapp').click(function(e) {
      e.preventDefault();
      if ($('#telefono_fijo_cli').val() == '') {
          alert(Nophone);
          return false;
      }
      if (!confirm(cliMailConf)) {
        return false;
      }
      sendLang = 'en';
      if ($('#idioma_cli').val() != '') {
        sendLang = $('#idioma_cli').val();
      }
      var values = Array();
      var priceRegex = /([0-9]+)/;
      for (var i = 0; i < selected.length; i++) {
          // var match = selected[i].match(priceRegex);
          // values.push(match[1]);
          values.push(selected[i]);
      }
      values = values.join(',');

      text = $('#comment').val();
      text = text.replace( /<\/p>/g, "</p><br>");
      text = text.replace( /<br>/g, "%0a" );
      text = text.replace(/(<([^>]+)>)/gi, "");
      text = text.replace( / /g, " " );

      var url =  "clients-whatsapp.php?ids="+values+'&phone='+$('#telefono_fijo_cli').val()+'&comment='+(text)+'&lang=' + sendLang;

      window.open(url, "whatsapp");
  });
  $('.btnwhatsapp').click(function(e) {
    e.preventDefault();
    if (!$('#telefono_fijo_cli').val()) {
        alert(Nophone);
        return false;
    }
    if ($('#messagemail').val() == '') {
        alert(strFieldMessage);
        return false;
    }
    sendLang = 'en';
    if ($('#idioma_cli').val() != '') {
      sendLang = $('#idioma_cli').val();
    }
    if (!confirm(cliMailConf)) {
      return false;
    }

    var values = Array();
    var priceRegex = /([0-9]+)/;
    for (var i = 0; i < selected.length; i++) {
        // var match = selected[i].match(priceRegex);
        // values.push(match[1]);
        values.push(selected[i]);
    }
    values = values.join(',');

    var url =  "get-links2.php?ids="+values+'&phone='+$('#telefono_fijo_cli').val()+'&comment='+encodeURIComponent($('#messagemail').val())+'&lang=' + sendLang;

    window.open(url, "whatsapp");
  });
</script>

<script>
    $('.btnsendWelcome').click(function(e) {
        e.preventDefault();
        if (!isValidEmailAddress($('#email_cli').val())) {
            alert(cliMailNo);
            return false;
        }
        if (!confirm(cliMailConf)) {
          return false;
        }
        sendLang = 'en';

        if ($('#idioma_cli').val() != '') {
          sendLang = $('#idioma_cli').val();
        }
        var values = Array();
        var priceRegex = /([0-9]+)/;
        for (var i = 0; i < selected.length; i++) {
            values.push(selected[i]);
        }
        $(this).append('<div class="loadingMail">');
        values = values.join(',');
        $.ajax({
          type: "GET",
          url: "clients-send-welcome.php?ids="+values+'&email='+$('#email_cli').val()+'&lang=' + sendLang + '&nombrecli=' + $('#nombre_cli').val() + '&usr=' + idClient,
            cache: false
        }).done(function( data ) {
              if(data == 'ok') {
                alert(mensaSend);
                $('#form1 .loadingMail').remove();
              }
        });
    });

    if (document.querySelector('#raterreset')) {
        var starRatingreset = raterJs({
            starSize: 22,
            rating: <?php if (KT_escapeAttribute($row_rsproperties_client['puntuacion_cli']) > 0): ?><?php echo KT_escapeAttribute($row_rsproperties_client['puntuacion_cli']); ?><?php else: ?>0<?php endif ?>,
            element: document.querySelector("#raterreset"),
            rateCallback: function rateCallback(rating, done) {
                this.setRating(rating);
                $('#puntuacion_cli').val(rating);
                done();
            }
        });
    }
    if (document.querySelector('#raterreset-button')) {
        document.querySelector('#raterreset-button').addEventListener("click", function () {
            starRatingreset.clear();
            $('#puntuacion_cli').val('0');
        }, false);
    }

    $(document).on("click",".view-mail-cont", function(e){ //user click on remove text
        e.preventDefault();

        $.get('view-mensa.php?id=' + $(this).data('id'), function(data) {
             $('#mail-text').html(data);
             $('#myModal3').modal('show');
        });
    });
</script>

    <div id="myModal3" class="modal  fade" tabindex="-1" aria-labelledby="myModal3Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="mail-text"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<script>
  $('#idioma_cli').change(function(e) {
      var idm = $(this).val();
      $('.noticias1').hide();
      $('#news_' + idm).show();
      $('.ddn .dd-list').html('');
      $('#news1_' + idm).val(null).trigger('change');

      $('.promociones1').hide();
      $('#prom_' + idm).show();
      $('.ddpr .dd-list').html('');
      $('#prom1_' + idm).val(null).trigger('change');

      $('.ciudades1').hide();
      $('#ciu_' + idm).show();
      $('.ddc .dd-list').html('');
      $('#ciu1_' + idm).val(null).trigger('change');
  }).change();

  $('.selnews1').click(function(e) {
      var lang = $(this).data('lang');
      var val = $('#news1_' + lang).find(':selected').val();
      var text = $('#news1_' + lang).find(':selected').text();
      if (val != '') {
          $('.ddn .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsnews1[]" value="' + val + '"></div></li>');
          $('#news1_' + lang).val(null).trigger('change');
      }
  });
  $('.ddn').nestable({
      group: 1
  });
  $(document).on('click', '.delproplist1', function(e) {
      $(this).closest('li').fadeOut('slow', function() {
          $(this).closest('li').remove();
      });
  });

  $('.selprom1').click(function(e) {
      var lang = $(this).data('lang');
      var val = $('#prom1_' + lang).find(':selected').val();
      var text = $('#prom1_' + lang).find(':selected').text();
      if (val != '') {
          $('.ddpr .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsprom1[]" value="' + val + '"></div></li>');
          $('#prom1_' + lang).val(null).trigger('change');
      }
  });
  $('.ddpr').nestable({
      group: 1
  });

  $('.selciu1').click(function(e) {
      var lang = $(this).data('lang');
      var val = $('#ciu1_' + lang).find(':selected').val();
      var text = $('#ciu1_' + lang).find(':selected').text();
      if (val != '') {
          $('.ddc .dd-list').append('<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content"><a href="javascript:;" class="btn btn-danger btn-sm float-end delproplist1" style="margin-top: 7px;"><i class="fa fa-trash-can"></i></a>' + text + '<input type="hidden" name="propsciu1[]" value="' + val + '"></div></li>');
          $('#ciu1_' + lang).val(null).trigger('change');
      }
  });
  $('.ddc').nestable({
      group: 1
  });

  $(document).on('click', '.edit-event', function(e) {
    e.preventDefault();
    tb = $(this);
      $.get("/intramedianet/calendar/disp-datos.php?lang=<?php echo $lang_adm ?>&id="+tb.data('id'), function(data) {
        $('.add-cita').attr('name','KT_Update1');
        var jsonObject = $.parseJSON(data);
        $('#id_ct').val(jsonObject[0].id_ct);
        $('#categoria_ct').val(jsonObject[0].categoria_ct);
        $('#user_ct').val(jsonObject[0].user_ct);
        $('#users_ct').val(jsonObject[0].users_ct);
        $('#vendedores_ct').val(jsonObject[0].vendedores_ct);
        if (jsonObject[0].users_ct != null) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/intramedianet/properties/properties-buyers-select-single.php?q=' + jsonObject[0].users_ct
            }).then(function (data) {
              $(".select2clientes").select2('data', { id:data.id, text: data.text});
            });
        }
        if (jsonObject[0].vendedores_ct != null) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/intramedianet/properties/properties-owners-select-single.php?q=' + jsonObject[0].vendedores_ct
            }).then(function (data) {
              $(".select2vendors").select2('data', { id:data.id, text: data.text});
            });
        }
        if (jsonObject[0].property_ct != null) {
          $.ajax({
              type: 'GET',
              dataType: 'json',
              url: '/intramedianet/properties/properties-references-select-multiple.php?q=' + jsonObject[0].property_ct
          }).done(function (data) {
              $(".select2references").select2('data', data);
          });
        }
        $('#inicio_ct').val(jsonObject[0].inicio_ct);
        $('#final_ct').val(jsonObject[0].final_ct);
        $('#titulo_ct').val(jsonObject[0].titulo_ct);
        $('#lugar_ct').val(jsonObject[0].lugar_ct);
        $('#notas_ct').val(jsonObject[0].notas_ct);
        $('.select2').change();
      });
    $('#myModal').modal('show');
  });

  $(document).on("click", "#sendmailTab", function (e) { //user click on remove text
      e.preventDefault();

      $('#criteriaTab').tab('show');
      $('html, body').animate({
          scrollTop: $('#btnsendcont').offset().top - 90
      });
  });

  $(document).on("change", ".activate_nws", function (e) { //user click on remove text
      e.preventDefault();

      var ids = Array();
      var priceRegex = /([0-9]+)/;
      for (var i = 0; i < selected.length; i++) {
          ids.push(selected[i]);
      }
      ids = ids.join(',');

      $.get('/intramedianet/properties/getPropsList.php?ids=' + ids, function (data) {
          $('.ddp .dd-list').html(data);
      });
  });

  $('.ddp').nestable({
      group: 1,
  }).on('change', function() {

    var ids = Array();
    $('.propslist1Vals').each(function(index){
        ids.push($(this).val());
    });
    $('.idsselcrit').val(ids.join(','));
});
</script>

<style>
.ddp li:first-child .dd-content {
    margin-bottom: 30px;
}
.ddp li:first-child .dd-content {
    background-color: #8894a0;
}
</style>

</body>
</html>
