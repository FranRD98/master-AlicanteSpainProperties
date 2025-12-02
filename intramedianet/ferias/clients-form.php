<?php

    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);

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
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$lang_adm.'.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/gdpr.php');


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


// $query_rsTipos = "
// SELECT
//   CASE WHEN properties_types.types_".$lang_adm."_typ IS NOT NULL THEN properties_types.types_".$lang_adm."_typ ELSE types.types_".$lang_adm."_typ END AS types_".$lang_adm."_typ,
//   CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS id_typ
// FROM  properties_properties
//     INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
//     LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
// GROUP BY id_typ
// ORDER BY types_".$lang_adm."_typ
// ";
$query_rsTipos = "
SELECT
  types_".$lang_adm."_typ,
  id_typ
FROM properties_types
GROUP BY id_typ
ORDER BY types_".$lang_adm."_typ
";
$rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsFiles = "SELECT * FROM properties_client_files WHERE client_fil = '".$clientId."' ";
$rsFiles = mysqli_query($inmoconn,$query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);


$query_rsSales = "SELECT * FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsSales = mysqli_query($inmoconn,$query_rsSales) or die(mysqli_error());
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);

// 
// $query_rsStatus = "SELECT * FROM properties_client_states ORDER BY category_".$lang_adm."_sts ASC";
// $rsStatus = mysqli_query($inmoconn,$query_rsStatus) or die(mysqli_error());
// $row_rsStatus = mysqli_fetch_assoc($rsStatus);
// $totalRows_rsStatus = mysqli_num_rows($rsStatus);

// 
// $query_rsCaptado = "SELECT * FROM properties_client_captado ORDER BY category_".$lang_adm."_cap ASC";
// $rsCaptado = mysqli_query($inmoconn,$query_rsCaptado) or die(mysqli_error());
// $row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
// $totalRows_rsCaptado = mysqli_num_rows($rsCaptado);


$query_rsSources = "SELECT * FROM properties_client_sources WHERE active_fair_sts = 1 ORDER BY id_sts desc,  category_en_sts ASC";
$rsSources = mysqli_query($inmoconn,$query_rsSources) or die(mysqli_error());
$row_rsSources = mysqli_fetch_assoc($rsSources);
$totalRows_rsSources = mysqli_num_rows($rsSources);

// 
// $query_rsColaboradores = "SELECT * FROM properties_collaborators ORDER BY nombre_comercial_col ASC";
// $rsColaboradores = mysqli_query($inmoconn,$query_rsColaboradores) or die(mysqli_error());
// $row_rsColaboradores = mysqli_fetch_assoc($rsColaboradores);
// $totalRows_rsColaboradores = mysqli_num_rows($rsColaboradores);

// 
// $query_rsTemplates = "SELECT * FROM templates ORDER BY name_".$lang_adm."_tmpl ASC";
// $rsTemplates = mysqli_query($inmoconn,$query_rsTemplates) or die(mysqli_error());
// $row_rsTemplates = mysqli_fetch_assoc($rsTemplates);
// $totalRows_rsTemplates = mysqli_num_rows($rsTemplates);


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
$rsparent1 = mysqli_query($inmoconn,$query_rsparent1) or die(mysqli_error() . '<hr>' . $query_rsparent1);
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
$rsparent2 = mysqli_query($inmoconn,$query_rsparent2) or die(mysqli_error() . '<hr>' . $query_rsparent2);
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

GROUP BY id
ORDER BY `name` ASC
";
$rsparent3 = mysqli_query($inmoconn,$query_rsparent3) or die(mysqli_error());
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
$rsparent4 = mysqli_query($inmoconn,$query_rsparent4) or die(mysqli_error());
$row_rsparent4 = mysqli_fetch_assoc($rsparent4);
$totalRows_rsparent4 = mysqli_num_rows($rsparent4);


$query_rsReferencias = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias = mysqli_query($inmoconn,$query_rsReferencias) or die(mysqli_error());
$row_rsReferencias = mysqli_fetch_assoc($rsReferencias);
$totalRows_rsReferencias = mysqli_num_rows($rsReferencias);


$query_rsReferencias2 = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias2 = mysqli_query($inmoconn,$query_rsReferencias2) or die(mysqli_error());
$row_rsReferencias2 = mysqli_fetch_assoc($rsReferencias2);
$totalRows_rsReferencias2 = mysqli_num_rows($rsReferencias2);


$query_rsReferencias3 = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias3 = mysqli_query($inmoconn,$query_rsReferencias3) or die(mysqli_error());
$row_rsReferencias3 = mysqli_fetch_assoc($rsReferencias3);
$totalRows_rsReferencias3 = mysqli_num_rows($rsReferencias3);


$query_rsOpciones = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features ORDER BY name ASC";
$rsOpciones = mysqli_query($inmoconn,$query_rsOpciones) or die(mysqli_error());
$row_rsOpciones = mysqli_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysqli_num_rows($rsOpciones);


$query_rsOpciones2 = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features_priv ORDER BY name ASC";
$rsOpciones2 = mysqli_query($inmoconn,$query_rsOpciones2) or die(mysqli_error());
$row_rsOpciones2 = mysqli_fetch_assoc($rsOpciones2);
$totalRows_rsOpciones2 = mysqli_num_rows($rsOpciones2);


$query_rsTags = "SELECT id_tag as id, tag_".$lang_adm."_tag as name FROM properties_tags ORDER BY name ASC";
$rsTags = mysqli_query($inmoconn,$query_rsTags) or die(mysqli_error());
$row_rsTags = mysqli_fetch_assoc($rsTags);
$totalRows_rsTags = mysqli_num_rows($rsTags);

// 
// $query_rsConsultasProp = "
// SELECT properties_enquiries.id_cons,
//   (SELECT referencia_prop FROM properties_properties WHERE id_prop = inmueble_cons) AS inmueble_cons,
//   inmueble_cons AS idprop,
//   properties_enquiries.comentario_consas,
//   properties_enquiries.fecha_cons,
//   properties_enquiries.read_cons,
//   properties_enquiries.client_cons
// FROM properties_enquiries
// WHERE properties_enquiries.client_cons = '".$_GET['id_cli']."' AND properties_enquiries.client_cons != ''
// ORDER BY properties_enquiries.fecha_cons DESC
// ";
// $rsConsultasProp = mysqli_query($inmoconn,$query_rsConsultasProp) or die(mysqli_error());
// $row_rsConsultasProp = mysqli_fetch_assoc($rsConsultasProp);
// $totalRows_rsConsultasProp = mysqli_num_rows($rsConsultasProp);


$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct FROM citas_categories ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn,$query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);


$query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 7 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsusuarios = mysqli_query($inmoconn,$query_rsusuarios) or die(mysqli_error());
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);


$query_rsclientes = "SELECT nombre_cli, apellidos_cli, id_cli FROM properties_client ORDER BY nombre_cli, apellidos_cli";
$rsclientes = mysqli_query($inmoconn,$query_rsclientes) or die(mysqli_error());
$row_rsclientes = mysqli_fetch_assoc($rsclientes);
$totalRows_rsclientes = mysqli_num_rows($rsclientes);


$query_rsvendor = "SELECT nombre_pro, apellidos_pro, id_pro FROM properties_owner ORDER BY nombre_pro, apellidos_pro";
$rsvendor = mysqli_query($inmoconn,$query_rsvendor) or die(mysqli_error());
$row_rsvendor = mysqli_fetch_assoc($rsvendor);
$totalRows_rsvendor = mysqli_num_rows($rsvendor);


$query_rsPool = "SELECT pool_".$lang_adm."_pl as pool, id_pl FROM properties_pool ORDER BY pool ASC";
$rsPool = mysqli_query($inmoconn,$query_rsPool) or die(mysqli_error());
$row_rsPool = mysqli_fetch_assoc($rsPool);
$totalRows_rsPool = mysqli_num_rows($rsPool);


$query_rsParking = "SELECT parking_".$lang_adm."_prk as parking, id_prk FROM properties_parking ORDER BY parking ASC";
$rsParking = mysqli_query($inmoconn,$query_rsParking) or die(mysqli_error());
$row_rsParking = mysqli_fetch_assoc($rsParking);
$totalRows_rsParking = mysqli_num_rows($rsParking);


$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

  
  $query_rsNationalities = "SELECT id_ncld, nacionalidad_".$lang_adm."_ncld FROM nacionalidades ORDER BY nacionalidad_".$lang_adm."_ncld";
  $rsNationalities = mysqli_query($inmoconn,$query_rsNationalities) or die(mysqli_error());
  $row_rsNationalities = mysqli_fetch_assoc($rsNationalities);
  $totalRows_rsNationalities = mysqli_num_rows($rsNationalities);


$query_rscosta = "SELECT id_cst, coast_".$lang_adm."_cst as costa FROM properties_coast WHERE coast_".$lang_adm."_cst IS NOT NULL ORDER BY coast_".$lang_adm."_cst ASC";
$rscosta = mysqli_query($inmoconn,$query_rscosta) or die(mysqli_error() . '<hr>' . $query_rscosta);
$row_rscosta = mysqli_fetch_assoc($rscosta);
$totalRows_rscosta = mysqli_num_rows($rscosta);

function addRefs($ids) 
{

  global $database_inmoconn, $inmoconn;

  if ($ids == '') 
  {
      return '';
  }

  
  $query_rsRefs = "SELECT referencia_prop, id_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
  $rsRefs = mysqli_query($inmoconn,$query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
  $row_rsRefs = mysqli_fetch_assoc($rsRefs);
  $totalRows_rsRefs = mysqli_num_rows($rsRefs);

  $ret = array();

  do 
  {

    array_push($ret, '<a href="/intramedianet/properties/properties-form.php?id_prop='.$row_rsRefs['id_prop'].'" target="_blank" class="btn btn-soft-primary btn-sm">'.$row_rsRefs['referencia_prop'].'</a>');

  } 
  while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));


  return implode(' ', $ret);

}

function loguser($user, $id, $ref, $action) {

    global $database_inmoconn, $inmoconn;

    
    $query_rsProp = "INSERT INTO `properties_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '".$user."', '".$id."', '".$ref."', '".$action."', '".date("Y-m-d H:i:s")."')";
    $rsProp = mysqli_query($inmoconn,$query_rsProp) or die(mysqli_error());


}

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_cli", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect($tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("clients-form.php?id_cli=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand

function Trigger_SendEmail($tNG) {

    global $fromMail, $lang_adm, $_POST, $nombreEmpresa;

    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '../../includes/mailtemplates/welcome_'.$_POST['idioma_cli'].'_cli.html');
    $html = ob_get_contents();
    ob_end_clean();

    $subject = 'Beste bezoeker van de ' . $nombreEmpresa . ' stand';

    if (sendAppEmail(array($_POST['email_cli'] => $_POST['nombre_cli']), array($_POST['skype_cli'] => $_POST['nombre2_cli']), '', array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), $subject, $html)) {
      return true;
    }
    else {
      return false;
    }

}


function Trigger_SendEmail2($tNG){
  global $fromMail, $lang_adm;
  $email_cli = $tNG->getColumnValue("email_cli");
  $nombre_cli = $tNG->getColumnValue("nombre_cli");
  $nameTemplate = "template_semanal.html";
  $html = getBodyWelcome($nameTemplate, $nombre_cli);
  $subject = __("Bienvenido", true). " | " . $_SERVER['HTTP_HOST'];
  if (sendAppEmail(array($email_cli => $nombre_cli), '', array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), $subject, $html)) {
      return true;
  } else {
      return false;
  }

}

function Trigger_DeleteDetail2($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_client_files");
  $tblDelObj->setFieldName("client_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/clients/");
  return $tblDelObj->Execute();
}


//end Trigger_DeleteDetail2 trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique($tNG) {
  global $lang, $database_inmoconn, $inmoconn;

  
  $query_rsclientes = "SELECT nombre_cli, apellidos_cli, id_cli FROM properties_client WHERE email_cli = '" . $tNG->getColumnValue('email_cli') . "'  AND archived_cli = 1 ";
  $rsclientes = mysqli_query($inmoconn,$query_rsclientes) or die(mysqli_error());
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

if (isset($_POST['b_tags_cli']) && $_POST['b_tags_cli'] != '' ) {
  $_POST['b_tags_cli'] = implode(',', $_POST['b_tags_cli']);
}
if (isset($_POST['b_ocultos_cli']) && $_POST['b_ocultos_cli'] != '' ) {
  $_POST['b_ocultos_cli'] = implode(',', $_POST['b_ocultos_cli']);
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
function Trigger_AddToNewsletter($tNG) {
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
        $rsClint = mysqli_query($inmoconn,$query_rsClint) or die(mysqli_error());
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
function Trigger_DeletFromNewsletter($tNG) {
    global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyAcumbamail, $acumbamailIdListaClients;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
    
    $query_rsClint = "SELECT * FROM properties_client WHERE id_cli = '".$_GET['id_cli']."'";
    $rsClint = mysqli_query($inmoconn,$query_rsClint) or die(mysqli_error());
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
function addFields($tNG) {
  global $_SESSION;
  $tNG->addColumn("user_cli", "NUMERIC_TYPE", "EXPRESSION", "{SESSION.kt_login_id}");
  $tNG->addColumn("fecha_alta_cli", "DATE_TYPE", "EXPRESSION", date("d-m-Y H:i:s"));
  $tNG->addColumn("feria_cli", "CHECKBOX_1_0_TYPE", "EXPRESSION", "1");
  $tNG->addColumn("send_props_cli", "CHECKBOX_1_0_TYPE", "EXPRESSION", "1");


  if ($_SESSION['kt_login_level'] == 7 || $_SESSION['kt_login_level'] == 8) {
      $tNG->addColumn("atendido_por_cli", "NUMERIC_TYPE", "EXPRESSION", $_SESSION['kt_login_id']);
  }
  return $tNG->getError();
}
//end addFields trigger

//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog($tNG) {

  global $_SESSION;

  logBuyer($_SESSION['kt_login_id'], $tNG->getColumnValue('id_cli'), $tNG->getColumnValue('nombre_cli') . ' ' . $tNG->getColumnValue('apellidos_cli'), '1');

}
//end addLog trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog($tNG) {

  global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT * FROM properties_client WHERE id_cli = ".$_GET['id_cli'];
  $rsProp = mysqli_query($inmoconn,$query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);


  logBuyer($_SESSION['kt_login_id'], $row_rsProp['id_cli'], $row_rsProp['nombre_cli'] . ' ' . $row_rsProp['apellidos_cli'], 2);

}
//end editLog trigger

//start deleteLog trigger
//remove this line if you want to edit the code by hand
function deleteLog($tNG) {

  global $_SESSION, $_GET, $database_inmoconn, $inmoconn;

  
  $query_rsProp = "SELECT * FROM properties_client WHERE id_cli = ".$_GET['id_cli'];
  $rsProp = mysqli_query($inmoconn,$query_rsProp) or die(mysqli_error());
  $row_rsProp = mysqli_fetch_assoc($rsProp);
  $totalRows_rsProp = mysqli_num_rows($rsProp);

  logBuyer($_SESSION['kt_login_id'], $row_rsProp['id_cli'], $row_rsProp['nombre_cli'] . ' ' . $row_rsProp['apellidos_cli'], '5');

}
//end deleteLog trigger

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
if ($actMailchimp == 1) {
    $ins_properties_client->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
}
$ins_properties_client->registerTrigger("AFTER", "Trigger_SendEmail2", 98);
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
$ins_properties_client->addColumn("telefono_fijo2_cli", "STRING_TYPE", "POST", "telefono_fijo2_cli");
// $ins_properties_client->addColumn("telefono_movil_cli", "STRING_TYPE", "POST", "telefono_movil_cli");
$ins_properties_client->addColumn("email_cli", "STRING_TYPE", "POST", "email_cli");
$ins_properties_client->addColumn("situation_cli", "STRING_TYPE", "POST", "situation_cli");
$ins_properties_client->addColumn("mortgage_location_cli", "STRING_TYPE", "POST", "mortgage_location_cli");
$ins_properties_client->addColumn("percentage_mortgage_cli", "STRING_TYPE", "POST", "percentage_mortgage_cli");
$ins_properties_client->addColumn("mortgage_amount_cli", "STRING_TYPE", "POST", "mortgage_amount_cli");
$ins_properties_client->addColumn("current_gross_cli", "STRING_TYPE", "POST", "current_gross_cli");
$ins_properties_client->addColumn("current_partner_cli", "STRING_TYPE", "POST", "current_partner_cli");
$ins_properties_client->addColumn("resources_cli", "STRING_TYPE", "POST", "resources_cli");
$ins_properties_client->addColumn("skype_cli", "STRING_TYPE", "POST", "skype_cli");
$ins_properties_client->addColumn("como_nos_conocio_cli", "STRING_TYPE", "POST", "como_nos_conocio_cli");
// $ins_properties_client->addColumn("captado_por_cli", "STRING_TYPE", "POST", "captado_por_cli");
// $ins_properties_client->addColumn("captado_por2_cli", "STRING_TYPE", "POST", "captado_por2_cli");
$ins_properties_client->addColumn("fecha_alta_cli", "DATE_TYPE", "POST", "fecha_alta_cli", "{NOW}");
$ins_properties_client->addColumn("birthday_cli", "DATE_TYPE", "POST", "birthday_cli");
$ins_properties_client->addColumn("birthday2_cli", "DATE_TYPE", "POST", "birthday2_cli");
// $ins_properties_client->addColumn("next_call_cli", "DATE_TYPE", "POST", "next_call_cli");
$ins_properties_client->addColumn("extrainfo_cli", "STRING_TYPE", "POST", "extrainfo_cli");
// $ins_properties_client->addColumn("status_cli", "STRING_TYPE", "POST", "status_cli");
// $ins_properties_client->addColumn("b_loc1_cli", "STRING_TYPE", "POST", "b_loc1_cli");
$ins_properties_client->addColumn("b_loc2_cli", "STRING_TYPE", "POST", "b_loc2_cli");
$ins_properties_client->addColumn("b_loc3_cli", "STRING_TYPE", "POST", "b_loc3_cli");
// $ins_properties_client->addColumn("b_loc4_cli", "STRING_TYPE", "POST", "b_loc4_cli");
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
$ins_properties_client->addColumn("current_home_cli", "STRING_TYPE", "POST", "current_home_cli");
// $ins_properties_client->addColumn("b_opciones_cli", "STRING_TYPE", "POST", "b_opciones_cli");
// $ins_properties_client->addColumn("b_opciones2_cli", "STRING_TYPE", "POST", "b_opciones2_cli");
// $ins_properties_client->addColumn("b_tags_cli", "STRING_TYPE", "POST", "b_tags_cli");
$ins_properties_client->addColumn("b_pool_cli", "STRING_TYPE", "POST", "b_pool_cli");
$ins_properties_client->addColumn("b_parking_cli", "STRING_TYPE", "POST", "b_parking_cli");
$ins_properties_client->addColumn("b_m2_desde_cli", "STRING_TYPE", "POST", "b_m2_desde_cli");
$ins_properties_client->addColumn("b_m2_hasta_cli", "STRING_TYPE", "POST", "b_m2_hasta_cli");
// $ins_properties_client->addColumn("b_m2p_desde_cli", "STRING_TYPE", "POST", "b_m2p_desde_cli");
// $ins_properties_client->addColumn("b_m2p_hasta_cli", "STRING_TYPE", "POST", "b_m2p_hasta_cli");
if ($_SESSION['kt_login_level'] != 7 && $_SESSION['kt_login_level'] != 8) {
  $ins_properties_client->addColumn("atendido_por_cli", "STRING_TYPE", "POST", "atendido_por_cli");
}
// if ($actSaveSearch == 1)
// {
//     $ins_properties_client->addColumn("usuario_cli", "CHECKBOX_1_0_TYPE", "POST", "usuario_cli", "0"); /////// AÑADIR DB BUSQUEDAS
// }

// $ins_properties_client->addColumn("b_ocultos_cli", "STRING_TYPE", "POST", "b_ocultos_cli");
$ins_properties_client->addColumn("nie_cli", "STRING_TYPE", "POST", "nie_cli");
$ins_properties_client->addColumn("pasaporte_cli", "STRING_TYPE", "POST", "pasaporte_cli");
$ins_properties_client->addColumn("residencia_fiscal_cli", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_cli", "0");
// $ins_properties_client->addColumn("ha_comprado_cli", "CHECKBOX_1_0_TYPE", "POST", "ha_comprado_cli", "0");
// $ins_properties_client->addColumn("ref_comprado_cli", "STRING_TYPE", "POST", "ref_comprado_cli");
// if ($actMailchimp == 1) {
//     $ins_properties_client->addColumn("newsletter_cli", "CHECKBOX_1_0_TYPE", "POST", "newsletter_cli", "1");
// }
$ins_properties_client->addColumn("mortgage_cli", "CHECKBOX_1_0_TYPE", "POST", "mortgage_cli", "0");
$ins_properties_client->addColumn("financing_cli", "CHECKBOX_1_0_TYPE", "POST", "financing_cli", "0");

// $ins_properties_client->addColumn("atendido_cli", "CHECKBOX_1_0_TYPE", "POST", "atendido_cli", "1");
// $ins_properties_client->addColumn("archived_cli", "CHECKBOX_1_0_TYPE", "POST", "archived_cli", "0");
// $ins_properties_client->addColumn("send_props_cli", "CHECKBOX_1_0_TYPE", "POST", "send_props_cli", "1");
$ins_properties_client->addColumn("nacionalidad_cli", "STRING_TYPE", "POST", "nacionalidad_cli");
$ins_properties_client->addColumn("notas_cli", "STRING_TYPE", "POST", "notas_cli");
// $ins_properties_client->addColumn("b_orientacion_cli", "STRING_TYPE", "POST", "b_orientacion_cli");
// $ins_properties_client->addColumn("puntuacion_cli", "STRING_TYPE", "POST", "puntuacion_cli", "0");
// $ins_properties_client->addColumn("visited_cli", "STRING_TYPE", "POST", "visited_cli");
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

$ins_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_client = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_client);
// Register triggers
$upd_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_properties_client->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../intramedianet/ferias/clients.php?KT_back=1");
$upd_properties_client->registerConditionalTrigger("{POST.KT_Update2} != \"\"", "END", "Trigger_Redirect", 90);
$upd_properties_client->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
$upd_properties_client->registerTrigger("BEFORE", "editLog", 10);
// if ($actMailchimp == 1) {
//     $upd_properties_client->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
// }
// Add columns
$upd_properties_client->setTable("properties_client");
$upd_properties_client->addColumn("nombre_cli", "STRING_TYPE", "POST", "nombre_cli");
$upd_properties_client->addColumn("nombre2_cli", "STRING_TYPE", "POST", "nombre2_cli");
$upd_properties_client->addColumn("apellidos_cli", "STRING_TYPE", "POST", "apellidos_cli");
$upd_properties_client->addColumn("apellidos2_cli", "STRING_TYPE", "POST", "apellidos2_cli");
$upd_properties_client->addColumn("direccion_cli", "STRING_TYPE", "POST", "direccion_cli");
$upd_properties_client->addColumn("telefono_fijo_cli", "STRING_TYPE", "POST", "telefono_fijo_cli");
$upd_properties_client->addColumn("telefono_fijo2_cli", "STRING_TYPE", "POST", "telefono_fijo2_cli");
// $upd_properties_client->addColumn("telefono_movil_cli", "STRING_TYPE", "POST", "telefono_movil_cli");
$upd_properties_client->addColumn("email_cli", "STRING_TYPE", "POST", "email_cli");
$upd_properties_client->addColumn("skype_cli", "STRING_TYPE", "POST", "skype_cli");
$upd_properties_client->addColumn("situation_cli", "STRING_TYPE", "POST", "situation_cli");
$upd_properties_client->addColumn("mortgage_location_cli", "STRING_TYPE", "POST", "mortgage_location_cli");
$upd_properties_client->addColumn("percentage_mortgage_cli", "STRING_TYPE", "POST", "percentage_mortgage_cli");
$upd_properties_client->addColumn("mortgage_amount_cli", "STRING_TYPE", "POST", "mortgage_amount_cli");
$upd_properties_client->addColumn("current_gross_cli", "STRING_TYPE", "POST", "current_gross_cli");
$upd_properties_client->addColumn("current_partner_cli", "STRING_TYPE", "POST", "current_partner_cli");
$upd_properties_client->addColumn("resources_cli", "STRING_TYPE", "POST", "resources_cli");
$upd_properties_client->addColumn("como_nos_conocio_cli", "STRING_TYPE", "POST", "como_nos_conocio_cli");
// $upd_properties_client->addColumn("captado_por_cli", "STRING_TYPE", "POST", "captado_por_cli");
// $upd_properties_client->addColumn("captado_por2_cli", "STRING_TYPE", "POST", "captado_por2_cli");
$upd_properties_client->addColumn("fecha_alta_cli", "DATE_TYPE", "POST", "fecha_alta_cli");
$upd_properties_client->addColumn("birthday_cli", "DATE_TYPE", "POST", "birthday_cli");
$upd_properties_client->addColumn("birthday2_cli", "DATE_TYPE", "POST", "birthday2_cli");
// $upd_properties_client->addColumn("next_call_cli", "DATE_TYPE", "POST", "next_call_cli");
$upd_properties_client->addColumn("extrainfo_cli", "STRING_TYPE", "POST", "extrainfo_cli");
// $upd_properties_client->addColumn("status_cli", "STRING_TYPE", "POST", "status_cli");
// $upd_properties_client->addColumn("b_loc1_cli", "STRING_TYPE", "POST", "b_loc1_cli");
$upd_properties_client->addColumn("b_loc2_cli", "STRING_TYPE", "POST", "b_loc2_cli");
$upd_properties_client->addColumn("b_loc3_cli", "STRING_TYPE", "POST", "b_loc3_cli");
// $upd_properties_client->addColumn("b_loc4_cli", "STRING_TYPE", "POST", "b_loc4_cli");
$upd_properties_client->addColumn("b_sale_cli", "STRING_TYPE", "POST", "b_sale_cli");
$upd_properties_client->addColumn("b_type_cli", "STRING_TYPE", "POST", "b_type_cli");
$upd_properties_client->addColumn("b_beds_cli", "STRING_TYPE", "POST", "b_beds_cli");
$upd_properties_client->addColumn("b_baths_cli", "STRING_TYPE", "POST", "b_baths_cli");
$upd_properties_client->addColumn("b_ref_cli", "STRING_TYPE", "POST", "b_ref_cli");
$upd_properties_client->addColumn("b_precio_desde_cli", "STRING_TYPE", "POST", "b_precio_desde_cli");
$upd_properties_client->addColumn("b_precio_hasta_cli", "STRING_TYPE", "POST", "b_precio_hasta_cli");
$upd_properties_client->addColumn("current_home_cli", "STRING_TYPE", "POST", "current_home_cli");
// $upd_properties_client->addColumn("b_opciones_cli", "STRING_TYPE", "POST", "b_opciones_cli");
// $upd_properties_client->addColumn("b_opciones2_cli", "STRING_TYPE", "POST", "b_opciones2_cli");
// $upd_properties_client->addColumn("b_tags_cli", "STRING_TYPE", "POST", "b_tags_cli");
$upd_properties_client->addColumn("b_pool_cli", "STRING_TYPE", "POST", "b_pool_cli");
$upd_properties_client->addColumn("b_parking_cli", "STRING_TYPE", "POST", "b_parking_cli");
$upd_properties_client->addColumn("b_m2_desde_cli", "STRING_TYPE", "POST", "b_m2_desde_cli");
$upd_properties_client->addColumn("b_m2_hasta_cli", "STRING_TYPE", "POST", "b_m2_hasta_cli");
// $upd_properties_client->addColumn("b_m2p_desde_cli", "STRING_TYPE", "POST", "b_m2p_desde_cli");
// $upd_properties_client->addColumn("b_m2p_hasta_cli", "STRING_TYPE", "POST", "b_m2p_hasta_cli");


if ($actCostas == 1) 
{
    $upd_properties_client->addColumn("b_costa_cli", "STRING_TYPE", "POST", "b_costa_cli");
}
if ($_SESSION['kt_login_level'] != 7 && $_SESSION['kt_login_level'] != 8) {
  $upd_properties_client->addColumn("atendido_por_cli", "STRING_TYPE", "POST", "atendido_por_cli");
}
// if ($actSaveSearch == 1)
// {
//     $upd_properties_client->addColumn("usuario_cli", "CHECKBOX_1_0_TYPE", "POST", "usuario_cli"); /////// AÑADIR DB BUSQUEDAS
// }

$upd_properties_client->addColumn("mortgage_cli", "CHECKBOX_1_0_TYPE", "POST", "mortgage_cli");
$upd_properties_client->addColumn("financing_cli", "CHECKBOX_1_0_TYPE", "POST", "financing_cli");

// $upd_properties_client->addColumn("b_ocultos_cli", "STRING_TYPE", "POST", "b_ocultos_cli");
$upd_properties_client->addColumn("nie_cli", "STRING_TYPE", "POST", "nie_cli");
$upd_properties_client->addColumn("pasaporte_cli", "STRING_TYPE", "POST", "pasaporte_cli");
$upd_properties_client->addColumn("residencia_fiscal_cli", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_cli");
// $upd_properties_client->addColumn("ha_comprado_cli", "CHECKBOX_1_0_TYPE", "POST", "ha_comprado_cli", "0");
// $upd_properties_client->addColumn("ref_comprado_cli", "STRING_TYPE", "POST", "ref_comprado_cli");
if ($actMailchimp == 1) {
    $upd_properties_client->addColumn("newsletter_cli", "CHECKBOX_1_0_TYPE", "POST", "newsletter_cli");
}
// $upd_properties_client->addColumn("atendido_cli", "CHECKBOX_1_0_TYPE", "POST", "atendido_cli");
// $upd_properties_client->addColumn("archived_cli", "CHECKBOX_1_0_TYPE", "POST", "archived_cli");
// $upd_properties_client->addColumn("send_props_cli", "CHECKBOX_1_0_TYPE", "POST", "send_props_cli");
$upd_properties_client->addColumn("user_cli", "STRING_TYPE", "CURRVAL", "user_cli");
$upd_properties_client->addColumn("nacionalidad_cli", "STRING_TYPE", "POST", "nacionalidad_cli");
$upd_properties_client->addColumn("notas_cli", "STRING_TYPE", "POST", "notas_cli");
// $upd_properties_client->addColumn("b_orientacion_cli", "STRING_TYPE", "POST", "b_orientacion_cli");
// $upd_properties_client->addColumn("puntuacion_cli", "STRING_TYPE", "POST", "puntuacion_cli");
// $upd_properties_client->addColumn("visited_cli", "STRING_TYPE", "POST", "visited_cli");
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

$upd_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE", "GET", "id_cli");

// Make an instance of the transaction object
$del_properties_client = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_client);
// Register triggers
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../intramedianet/ferias/clients.php?KT_back=1");
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


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <link href="../../css/website.css" rel="stylesheet">

  <?php include("../includes/inc.head.php"); ?>

  <style>

    body 
    {
        padding: 0 !important;
    }

      #emails-table_filter label {
        background: #efefef;
        padding: 10px;
      }
      #emails-table_filter input {
        min-width: 400px;
        max-width: 100%;
      }
      .footer
      {
         display:none !important;
      }
      .main-content
      {
          margin-left: 0 !important;
      }
      .container 
      {
          max-width: 1320px;
      }
      .card 
      {
        border: 0;
        box-shadow: none;
      }
    .card-header-fix.sticky 
    {
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1003;
        border-radius: 0 0 0 10px;
        border-left: 1px solid var(--vz-border-color);
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
    }
    .card-header-fix .btn-success
    {
        min-width: 150px;
    }

    @media (max-width: 720px) 
    {
        .card-body
        {
          padding-left: 0;
          padding-right: 0;
        }
        .card-header
        {
            padding: 8px 6px;
        }
    }

</style>

</head>

<body class="bg-white">

    <?php include("../includes/inc.header.php"); ?>

     <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.topbar-reduced.php' ); ?>

     <div class="container custom-form px-0">

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_client" class="id_field" value="<?php if(isset($row_rsproperties_client['kt_pk_properties_client'])) echo KT_escapeAttribute($row_rsproperties_client['kt_pk_properties_client']); ?>" />

        <div class="row">
            <div class="col-lg-12">


                <div class="card position-relative">
                    <div style="justify-content: space-between;" class="card-header align-items-center d-flex card-header-fix">
                        <!-- <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-house-person-return"></i> <?php echo __('Clientes'); ?></h4> -->

                        <!-- <div class="flex-md-grow-1 d-md-block" id="tabs-header-fix">


                        </div> -->

                        <div class="flex-md-shrink-0 d-md-block">
                            <?php if (@$_GET['id_cli'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="mt-2 mt-md-0 btn btn-success" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-2"></i><span class="d-inline-block"> <?php __("Guardar"); ?></span></button>
                                <!-- <button type="submit" name="KT_Insert2" id="KT_Insert2" class="mt-2 mt-md-0 btn btn-primary btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?> <?php echo $lang['y Seguir Editando'] ?></span></button> -->
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-success"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-inline-block"> <?php __("Guardar"); ?></span></button>
                                <!-- <button type="submit" name="KT_Update2" value="<?php echo NXT_getResource("Update_FB"); ?>" class="mt-2 mt-md-0 btn btn-primary btn-sm"><i class="fa-regular fa-floppy-disk-circle-arrow-right fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button> -->
                                <button type="submit" name="KT_Delete1" id="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 mt-2 mt-md-0 btn btn-danger"><i class="fa-regular fa-trash-can fa-fw me-1"></i><span class="d-none d-md-inline-block">  <?php echo NXT_getResource("Delete_FB"); ?></span></button>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="mt-2 mt-md-0 px-4 btn btn-soft-primary"><i class="fa-regular fa-chevron-left fa-fw me-1"></i><span class="d-none d-md-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>

             

                        </div>

                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>



                <div class="tab-cont">

                    <div class="tab-content">

                        <div class="tab-pane active" id="tabbuyer">

                            <div class="card position-relative">
                                <!-- <div class="card-header align-items-center d-flex">
                                    <div class="flex-grow-1 oveflow-hidden">
                                        <h4 class="card-title mb-0 flex-grow-1"><?php __('Cliente'); ?></h4>
                                    </div>
                                </div> -->
                                <div class="card-body">

                                  <div class="row">

                                     <div class="col-md-6">
                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "como_nos_conocio_cli") != '') { ?>has-error<?php } ?>">
                                            <label for="como_nos_conocio_cli" class="form-label"><?php __('Cómo nos conoció'); ?>:</label>
                                            <div class="controls">
                                                <select name="como_nos_conocio_cli" id="como_nos_conocio_cli" class="select2">
                                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                    <?php do { ?>
                                                    <option value="<?php echo $row_rsSources['id_sts']?>"<?php if (isset($row_rsproperties_client['como_nos_conocio_cli']) && !(strcmp($row_rsSources['id_sts'], $row_rsproperties_client['como_nos_conocio_cli']))) {echo "SELECTED";} ?>>
                                                      <?php echo $row_rsSources['category_en_sts']?></option>
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
                                      <?php 
                                        if ($_SESSION['kt_login_level'] > 8): ?>
                                        <div class="col-md-6">

                                              <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "atendido_por_cli") != '') { ?>has-error<?php } ?>">
                                                  <label for="atendido_por_cli" class="form-label"><?php __('Agente'); ?>:</label>
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
                                        <?php else: ?>
                                          <input type="hidden" name="atendido_por_cli" id="atendido_por_cli" value="<?php echo $row_rsproperties_client['atendido_por_cli'] ?>">
                                        <?php endif ?>

                                      <hr class="mt-2 mb-4">

                                      <div class="col-md-6 col-xl-3">
                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nombre_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="nombre_cli" class="form-label"><?php __('Nombre'); ?>:</label>
                                              <input type="text" name="nombre_cli" id="nombre_cli" value="<?php if(isset($row_rsproperties_client['nombre_cli'])) echo KT_escapeAttribute($row_rsproperties_client['nombre_cli']); ?>" size="32" maxlength="255" class="form-control required" required>
                                              <div class="invalid-feedback">
                                                  <?php __('Este campo es obligatorio.'); ?>
                                              </div>
                                                <?php echo $tNGs->displayFieldError("properties_client", "nombre_cli"); ?>
                                          </div>
                                      </div>
                                      <div class="col-md-6 col-xl-3">
                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "apellidos_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="apellidos_cli" class="form-label"><?php __('Apellidos'); ?>:</label>
                                              <input type="text" name="apellidos_cli" id="apellidos_cli" value="<?php if(isset($row_rsproperties_client['apellidos_cli'])) echo KT_escapeAttribute($row_rsproperties_client['apellidos_cli']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("properties_client", "apellidos_cli"); ?>
                                          </div>
                                      </div>

                                      <div class="col-md-6 col-xl-3">
                                           <div class="mb-md-2 mb-lg-4 <?php if($tNGs->displayFieldError("properties_client", "telefono_fijo_cli") != '') { ?>has-error<?php } ?>">
                                            <label for="telefono_fijo_cli" class="form-label"><?php __('Teléfono'); ?>:</label>
                                            <input type="text" name="telefono_fijo_cli" id="telefono_fijo_cli" value="<?php if(isset($row_rsproperties_client['telefono_fijo_cli'])) echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo_cli']); ?>" size="32" maxlength="255" class="form-control number">
                                            <?php echo $tNGs->displayFieldError("properties_client", "telefono_fijo_cli"); ?>
                                            <!-- <a href="https://api.whatsapp.com/send/?phone=<?php echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo_cli']); ?>" class="btn btn-success btn-sm ms-2 d-inline-block" style="border-radius: 0 0 5px 5px;" target="blank">Whatsapp</a> <small class="text-muted"><?php __('Sin + con prefijo del país y sin espacios'); ?></small> -->
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6 col-xl-3">
                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "email_cli") != '') { ?>has-error<?php } ?>">
                                            <label for="email_cli" class="form-label"><?php __('Email'); ?>:</label>
                                            <input type="text" name="email_cli" id="email_cli" value="<?php if(isset($row_rsproperties_client['email_cli'])) echo trim(KT_escapeAttribute($row_rsproperties_client['email_cli'])); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_client", "email_cli"); ?>
                                        </div>
                                      </div>

                                       

                                  </div>

                                  <div class="row">
                                      
                                      <hr class="my-4">

                                        <div class="col-md-6 col-xl-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nombre2_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="nombre2_cli" class="form-label"><?php __('Nombre'); ?> 2:</label>
                                                <input type="text" name="nombre2_cli" id="nombre2_cli" value="<?php if(isset($row_rsproperties_client['nombre2_cli'])) echo KT_escapeAttribute($row_rsproperties_client['nombre2_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <div class="invalid-feedback">
                                                    <?php __('Este campo es obligatorio.'); ?>
                                                </div>
                                                  <?php echo $tNGs->displayFieldError("properties_client", "nombre2_cli"); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "apellidos2_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="apellidos2_cli" class="form-label"><?php __('Apellidos'); ?> 2:</label>
                                                <input type="text" name="apellidos2_cli" id="apellidos2_cli" value="<?php if(isset($row_rsproperties_client['apellidos2_cli'])) echo KT_escapeAttribute($row_rsproperties_client['apellidos2_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                <?php echo $tNGs->displayFieldError("properties_client", "apellidos2_cli"); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-3">
                                           <div class="mb-md-2 mb-lg-4 <?php if($tNGs->displayFieldError("properties_client", "telefono_fijo2_cli") != '') { ?>has-error<?php } ?>">
                                            <label for="telefono_fijo2_cli" class="form-label"><?php __('Teléfono'); ?> 2:</label>
                                            <input type="text" name="telefono_fijo2_cli" id="telefono_fijo2_cli" value="<?php if(isset($row_rsproperties_client['telefono_fijo2_cli'])) echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo2_cli']); ?>" size="32" maxlength="255" class="form-control number">
                                            <?php echo $tNGs->displayFieldError("properties_client", "telefono_fijo2_cli"); ?>
                                            <!-- <a href="https://api.whatsapp.com/send/?phone=<?php echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo2_cli']); ?>" class="btn btn-success btn-sm ms-2 d-inline-block" style="border-radius: 0 0 5px 5px;" target="blank">Whatsapp</a> <small class="text-muted"><?php __('Sin + con prefijo del país y sin espacios'); ?></small> -->
                                        </div>
                                      </div>

                                      <div class="col-md-6 col-xl-3">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "skype_cli") != '') { ?>has-error<?php } ?>">
                                              <label for="skype_cli" class="form-label"><?php __('Skype'); ?>:</label>
                                              <input type="text" name="skype_cli" id="skype_cli" value="<?php if(isset($row_rsproperties_client['skype_cli'])) echo trim(KT_escapeAttribute($row_rsproperties_client['skype_cli'])); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("properties_client", "skype_cli"); ?>
                                          </div>
                                        </div>

                                       

                                        <hr class="my-4">

                                  </div>

                                     <div class="row">
                                         <div class="col-lg-6">
                                           
                                              <div class="row">
                                                <div class="col-md-6">
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
                                                              $selected = '';
                                                              if(isset($row_rsproperties_client['idioma_cli']))
                                                                $selected = (!(strcmp($value, $row_rsproperties_client['idioma_cli'])))?" SELECTED":"";
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
                                                <div class="col-md-6">
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


                                                   <div class="col-md-6">
                                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nie_cli") != '') { ?>has-error<?php } ?>">
                                                          <label for="nie_cli" class="form-label"><?php __('NIE'); ?>:</label>
                                                          <input type="text" name="nie_cli" id="nie_cli" value="<?php if(isset($row_rsproperties_client['nie_cli'])) echo KT_escapeAttribute($row_rsproperties_client['nie_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_client", "nie_cli"); ?>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "pasaporte_cli") != '') { ?>has-error<?php } ?>">
                                                          <label for="pasaporte_cli" class="form-label"><?php __('Pasaporte'); ?>:</label>
                                                          <input type="text" name="pasaporte_cli" id="pasaporte_cli" value="<?php if(isset($row_rsproperties_client['pasaporte_cli'])) echo KT_escapeAttribute($row_rsproperties_client['pasaporte_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                          <?php echo $tNGs->displayFieldError("properties_client", "pasaporte_cli"); ?>
                                                      </div>
                                                  </div>
                                               
                                            </div>

                                         </div>
                                         <div class="col-lg-6">

                                            <div class="row">
                                                <div class="col-lg-12 col-lg-6">
                                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "direccion_cli") != '') { ?>has-error<?php } ?>">
                                                        <label for="direccion_cli" class="form-label"><?php __('Dirección'); ?>:</label>
                                                        <input type="text" name="direccion_cli" id="direccion_cli" value="<?php if(isset($row_rsproperties_client['direccion_cli'])) echo KT_escapeAttribute($row_rsproperties_client['direccion_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                        <?php echo $tNGs->displayFieldError("properties_client", "direccion_cli"); ?>
                                                    </div>
                                                </div>
                                               
                                            </div>

                                         </div>

                                          <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "comment_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="comment_cli" class="form-label"><?php __('Extra Info'); ?>:</label>
                                                      <input type="text" name="comment_cli" id="comment_cli" value="<?php if(isset($row_rsproperties_client['comment_cli'])) echo trim(KT_escapeAttribute($row_rsproperties_client['comment_cli'])); ?>" size="32" maxlength="255" class="form-control">
                                                      <?php echo $tNGs->displayFieldError("properties_client", "comment_cli"); ?>
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "fecha_alta_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="fecha_alta_cli" class="form-label"><?php __('Añadido'); ?>:</label>
                                                      <input type="text" name="fecha_alta_cli" id="fecha_alta_cli" value="<?php if(isset($row_rsproperties_client['fecha_alta_cli'])) echo KT_formatDate($row_rsproperties_client['fecha_alta_cli']); ?>" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                                                      <?php echo $tNGs->displayFieldError("properties_client", "fecha_alta_cli"); ?>
                                                  </div>
                                              </div>
                                               <div class="col-md-3 mt-3 mb-2">
                                            
                                                  <div class="form-check form-switch form-switch-lg pt-0 mt-md-2" dir="ltr">
                                                      <input type="checkbox" name="mortgage_cli" id="mortgage_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['mortgage_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['mortgage_cli']),"1"))) {echo "checked";} ?>>
                                                      <label class="form-check-label" for="mortgage_cli"><?php __('Hipoteca'); ?></label>
                                                      <?php echo $tNGs->displayFieldError("properties_client", "mortgage_cli"); ?>
                                                  </div>
                                                  
                                              </div>
                                     </div>

                                     <div class="row" id="mortgage_data" <?php if (isset($row_rsproperties_client['mortgage_cli']) && (strcmp(KT_escapeAttribute($row_rsproperties_client['mortgage_cli']),"1"))) { echo 'style="display: none;" '; }  ?> >
                                        


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
                                                  <input type="text" name="current_home_cli" id="current_home_cli" value="<?php if(isset($row_rsproperties_client['current_home_cli'])) echo KT_escapeAttribute($row_rsproperties_client['current_home_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "current_home_cli"); ?>
                                              </div>
                                              <div class="text-muted mt-n4 mb-1"><?php __('Sin puntos ni comas ni símbolos €') ?></div>
                                        </div>

                                        <div class="col-md-12 pb-4">
                                            <div class="form-check form-switch form-switch-lg pt-0 mt-md-2" dir="ltr">
                                                  <input type="checkbox" name="financing_cli" id="financing_cli" value="1" class="form-check-input" <?php if (isset($row_rsproperties_client['financing_cli']) && !(strcmp(KT_escapeAttribute($row_rsproperties_client['financing_cli']),"1"))) {echo "checked";} ?>>
                                                  <label class="form-check-label" for="financing_cli"><?php __('Financing options required?'); ?></label>
                                                  <?php echo $tNGs->displayFieldError("properties_client", "financing_cli"); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "mortgage_location_cli") != '') { ?>has-error<?php } ?>">

                                              <label for="mortgage_location_cli" class="form-label"><?php __('Mortgage in'); ?>:</label>

                                              <input type="text" placeholder="<?php __('Spain'); ?>, <?php __('Netherlands'); ?>, ... " name="mortgage_location_cli" id="mortgage_location_cli" value="<?php if(isset($row_rsproperties_client['mortgage_location_cli'])) echo KT_escapeAttribute($row_rsproperties_client['mortgage_location_cli']); ?>" size="32" maxlength="255" class="form-control">

                                  

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

                                        <div class="col-md-6 col-xl-3">
                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "birthday_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="birthday_cli" class="form-label"><?php __('Cumpleaños'); ?>:</label>
                                                <input type="text" name="birthday_cli" id="birthday_cli" value="<?php if(isset($row_rsproperties_client['birthday_cli'])) echo KT_formatDate($row_rsproperties_client['birthday_cli']); ?>" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                                                <?php echo $tNGs->displayFieldError("properties_client", "birthday_cli"); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-xl-3">
                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "birthday2_cli") != '') { ?>has-error<?php } ?>">
                                                <label for="birthday2_cli" class="form-label"> <?php __('Partners Birthday'); ?>:</label>
                                                <input type="text" name="birthday2_cli" id="birthday2_cli" value="<?php if(isset($row_rsproperties_client['birthday2_cli'])) echo KT_formatDate($row_rsproperties_client['birthday2_cli']); ?>" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                                                <?php echo $tNGs->displayFieldError("properties_client", "birthday2_cli"); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "mortgage_amount_cli") != '') { ?>has-error<?php } ?>">
                                                  <label for="mortgage_amount_cli" class="form-label"><?php __('Current mortgage amount in euro  (in euro)'); ?>:</label>
                                                  <input type="text" name="mortgage_amount_cli" id="mortgage_amount_cli" value="<?php if(isset($row_rsproperties_client['mortgage_amount_cli'])) echo KT_escapeAttribute($row_rsproperties_client['mortgage_amount_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "mortgage_amount_cli"); ?>
                                              </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "current_gross_cli") != '') { ?>has-error<?php } ?>">
                                                  <label for="current_gross_cli" class="form-label"><?php __('Current gross mortgage/rental burden'); ?>:</label>
                                                  <input type="text" name="current_gross_cli" id="current_gross_cli" value="<?php if(isset($row_rsproperties_client['current_gross_cli'])) echo KT_escapeAttribute($row_rsproperties_client['current_gross_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "current_gross_cli"); ?>
                                              </div>
                                        </div>
                                        <div class="col-12 pt-2 pb-4">
                                                <div class="text-muted mt-n4 mb-1"><?php __('Sin puntos ni comas ni símbolos €') ?></div>
                                              </div>

                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "current_partner_cli") != '') { ?>has-error<?php } ?>">
                                                  <label for="current_partner_cli" class="form-label"><?php __('Gross income partner'); ?>:</label>
                                                  <input type="text" name="current_partner_cli" id="current_partner_cli" value="<?php if(isset($row_rsproperties_client['current_partner_cli'])) echo KT_escapeAttribute($row_rsproperties_client['current_partner_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "current_partner_cli"); ?>
                                              </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "resources_cli") != '') { ?>has-error<?php } ?>">
                                                  <label for="resources_cli " class="form-label"><?php __('Available own resources (in euro)'); ?>:</label>
                                                  <input type="text" name="resources_cli" id="resources_cli" value="<?php if(isset($row_rsproperties_client['resources_cli'])) echo KT_escapeAttribute($row_rsproperties_client['resources_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "resources_cli"); ?>
                                              </div>
                                        </div>
                                        <div class="col-12 pt-2 pb-4">
                                                <div class="text-muted mt-n4 mb-1"><?php __('Sin puntos ni comas ni símbolos €') ?></div>
                                              </div>

                                     </div>
                                   
                        

                                    <div class="row">
                                      <div class="col-12">

                                        <div class="card-header px-0 align-items-center d-flex">
                                            <div class="flex-grow-1 oveflow-hidden">
                                                <h4 class="card-title mb-0 flex-grow-1 pt-1">
                                                    <!-- <?php __('Criterios de búsqueda'); ?> -->
                                                </h4>
                                            </div>
                                        </div>
                                        
                                        <div class="card-body px-0">

                                            <div class="row" id="search-fields">


                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_sale_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="b_sale_cli" class="form-label"><?php __('Operación'); ?>:</label>
                                                      <select name="b_sale_cli[]" id="b_sale_cli" multiple class="select2">
                                                          <?php do {
                                                            $vals = array();
                                                            if(isset($row_rsproperties_client['b_sale_cli']))
                                                            $vals = explode(',', $row_rsproperties_client['b_sale_cli']); ?>
                                                          <option value="<?php echo $row_rsSales['id_sta']?>"<?php if (in_array($row_rsSales['id_sta'], $vals)) {echo "selected=\"selected\"";} ?>><?php echo $row_rsSales['status_'.$lang_adm.'_sta']?></option>
                                                          <?php } while ($row_rsSales = mysqli_fetch_assoc($rsSales ));
                                                            $rows = mysqli_num_rows($rsSales );
                                                            if($rows > 0) {
                                                                mysqli_data_seek($rsSales , 0);
                                                              $row_rsSales = mysqli_fetch_assoc($rsSales );
                                                            } ?>
                                                      </select>
                                                      <?php echo $tNGs->displayFieldError("properties_client", "b_sale_cli"); ?>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
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
                                              </div>
                                              

                                              <div class="col-12">
                                                <h4 class="mt-3 mb-4 main-title">
                                                  <?php __('Dónde quieres comprar'); ?>
                                                </h4>
                                              </div>
                                              <?php if($actCostas == 1):?>
                                                <div class="col-md-6">
                                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_costa_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="b_costa_cli" class="form-label"><?php __('Costa'); ?>:</label>
                                                      <select name="b_costa_cli[]" id="b_costa_cli" multiple class="select2">
                                                        <?php do {
                                                          $vals = explode(',', $row_rsproperties_client['b_costa_cli']);
                                                        ?>
                                                        <option value="<?php echo $row_rscosta['id_cst']?>" <?php if (in_array($row_rscosta['id_cst'], $vals)) {echo "SELECTED";} ?>>
                                                          <?php echo $row_rscosta['costa']?> 
                                                        </option>
                                                        <?php } while ($row_rscosta = mysqli_fetch_assoc($rscosta)); ?>
                                                      </select>
                                                        <?php echo $tNGs->displayFieldError("properties_client", "b_costa_cli"); ?>
                                                    </div>
                                                  </div>
                                              <?php endif?>
                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($actCostas == 1) { echo ' d-none '; }?> <?php if($tNGs->displayFieldError("properties_client", "b_loc2_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="b_loc2_cli" class="form-label"><?php __('Provincia'); ?> / <?php __('Costa'); ?>:</label>
                                                      <select name="b_loc2_cli[]" id="b_loc2_cli" multiple class="select2">
                                                        <?php do {
                                                          $vals = explode(',', $row_rsproperties_client['b_loc2_cli']);
                                                        ?>
                                                        <option value="<?php echo $row_rsparent2['id'] ?>" <?php if (in_array($row_rsparent2['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsparent2['name'] ?></option>
                                                        <?php } while ($row_rsparent2 = mysqli_fetch_assoc($rsparent2)); ?>
                                                      </select>
                                                        <?php echo $tNGs->displayFieldError("properties_client", "b_loc2_cli"); ?>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_loc3_cli") != '') { ?>has-error<?php } ?>">
                                                      <label for="b_loc3_cli" class="form-label"><?php __('Ciudad'); ?>:</label>
                                                      <select name="b_loc3_cli[]" id="b_loc3_cli" multiple class="select2">
                                                        <?php do {
                                                          $vals = explode(',', $row_rsproperties_client['b_loc3_cli']);
                                                        ?>
                                                        <option value="<?php echo $row_rsparent3['id'] ?>" <?php if (in_array($row_rsparent3['id'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsparent3['name'] ?></option>
                                                        <?php } while ($row_rsparent3 = mysqli_fetch_assoc($rsparent3)); ?>
                                                      </select>
                                                        <?php echo $tNGs->displayFieldError("properties_client", "b_loc3_cli"); ?>
                                                  </div>
                                              </div>
                                              
                   

                                              <div class="col-12">
                                                <h4 class="mt-3 mb-4 main-title">
                                                  <?php __('Presupuesto'); ?>
                                                </h4>
                                                <div class="row pb-3">

                                                    <div class="col-md-6">
                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_precio_desde_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="b_precio_desde_cli" class="form-label"><?php __('Precio desde'); ?>:</label>
                                                            <input type="text" name="b_precio_desde_cli" id="b_precio_desde_cli" value="<?php if(isset($row_rsproperties_client['b_precio_desde_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_precio_desde_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                              <?php echo $tNGs->displayFieldError("properties_client", "b_precio_desde_cli"); ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_precio_hasta_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="b_precio_hasta_cli" class="form-label"><?php __('Precio hasta'); ?>:</label>
                                                            <input type="text" name="b_precio_hasta_cli" id="b_precio_hasta_cli" value="<?php if(isset($row_rsproperties_client['b_precio_hasta_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_precio_hasta_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                            <?php echo $tNGs->displayFieldError("properties_client", "b_precio_hasta_cli"); ?>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 pt-2">
                                                      <div class="text-muted mt-n4 mb-1"><?php __('Sin puntos ni comas ni símbolos €') ?></div>
                                                    </div>

                                                  </div>
                                              </div>
                                               
                                              <hr>

                                              <div class="col-md-12">

                                                <h4 class="mt-3 mb-4 main-title">
                                                    <?php __('Características Principales'); ?>
                                                </h4>

                                                <div class="row">

                                                     <div class="col-md-6 col-lg-3">

                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_m2_desde_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="b_m2_desde_cli" class="form-label"><?php __('M<sup>2</sup> desde'); ?>:</label>
                                                            <input type="text" name="b_m2_desde_cli" id="b_m2_desde_cli" value="<?php if(isset($row_rsproperties_client['b_m2_desde_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_m2_desde_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                              <?php echo $tNGs->displayFieldError("properties_client", "b_m2_desde_cli"); ?>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 col-lg-3">

                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_m2_hasta_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="b_m2_hasta_cli" class="form-label"><?php __('M<sup>2</sup> hasta'); ?>:</label>
                                                            <input type="text" name="b_m2_hasta_cli" id="b_m2_hasta_cli" value="<?php echo KT_escapeAttribute($row_rsproperties_client['b_m2_hasta_cli']); ?>" size="32" maxlength="255" class="form-control">
                                                            <?php echo $tNGs->displayFieldError("properties_client", "b_m2_hasta_cli"); ?>
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="col-md-6 col-lg-3">
                                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_beds_cli") != '') { ?>has-error<?php } ?>">
                                                          <label for="b_beds_cli" class="form-label"><?php __('Habitaciones'); ?>:</label>
                                                          <div class="controls">
                                                              <select name="b_beds_cli" id="b_beds_cli" class="select2">
                                                                  <option value="" <?php if (!(strcmp("", $row_rsproperties_client['b_beds_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $lang['Todos']; ?></option>
                                                                  <?php
                                                                  for ($i=1; $i < 100; $i++) {
                                                                  ?>
                                                                  <option value="<?php echo $i?>"<?php if (!(strcmp($i, $row_rsproperties_client['b_beds_cli']))) {echo "SELECTED";} ?>><?php echo $i?></option>
                                                                  <?php
                                                                    }
                                                                  ?>
                                                              </select>
                                                              <?php echo $tNGs->displayFieldError("properties_client", "b_beds_cli"); ?>
                                                          </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-3">
                                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_baths_cli") != '') { ?>has-error<?php } ?>">
                                                            <label for="b_baths_cli" class="form-label"><?php __('Aseos'); ?>:</label>
                                                            <div class="controls">
                                                                <select name="b_baths_cli" id="b_baths_cli" class="select2">
                                                                    <option value="" <?php if (!(strcmp("", $row_rsproperties_client['b_baths_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $lang['Todos']; ?></option>
                                                                    <?php
                                                                    for ($i=1; $i < 100; $i++) {
                                                                    ?>
                                                                    <option value="<?php echo $i?>"<?php if (!(strcmp($i, $row_rsproperties_client['b_baths_cli']))) {echo "SELECTED";} ?>><?php echo $i?></option>
                                                                    <?php
                                                                      }
                                                                    ?>
                                                                </select>
                                                                <?php echo $tNGs->displayFieldError("properties_client", "b_baths_cli"); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                  </div>
                                                  <div class="row pt-4">
                                                      <div class="col-md-6">
                                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_pool_cli") != '') { ?>has-error<?php } ?>">
                                                              <label for="b_pool_cli" class="form-label"><?php __('Piscina'); ?>:</label>
                                                              <select name="b_pool_cli[]" id="b_pool_cli" class="select2" multiple="multiple">
                                                                  <?php
                                                                  do {
                                                                  ?>
                                                                  <option value="<?php echo $row_rsPool['id_pl']?>"<?php if (!(strcmp($row_rsPool['id_pl'], $row_rsproperties_client['b_pool_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPool['pool']?></option>
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

                                                      </div> <!--/.col-md-6 -->

                                                      <div class="col-md-6">
                                                          <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_parking_cli") != '') { ?>has-error<?php } ?>">
                                                              <label for="b_parking_cli" class="form-label"><?php __('Parking'); ?>:</label>
                                                              <select name="b_parking_cli[]" id="b_parking_cli" class="select2" multiple="multiple">
                                                                  <?php
                                                                  do {
                                                                  ?>
                                                                  <option value="<?php echo $row_rsParking['id_prk']?>"<?php if (!(strcmp($row_rsParking['id_prk'], $row_rsproperties_client['b_parking_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsParking['parking']?></option>
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

                                                      </div> <!--/.col-md-6 -->

                                                      <div class="col-12">
                                                        
                                                        <label for="extrainfo_cli" class="form-label"><?php __('Información adicional'); ?>:</label>

                                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_client", "extrainfo_cli") != '') { ?>has-error<?php } ?>">
                                                            <textarea type="text" name="extrainfo_cli" id="extrainfo_cli" cols="50" rows="5" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_client['extrainfo_cli']); ?></textarea>
                                                            <?php echo $tNGs->displayFieldError("properties_client", "extrainfo_cli"); ?>
                                                           
                                                        </div>

                                                      </div>
                                                  </div>
                                                  
                                                </div>

                                              </div>

                                        </div><!-- end card-body -->

                                      </div>
                                    </div>

                                    <div class="row">

                                      <hr>

                                      

                                        <div class="col-md-12">

                                          <legend class="border-bottom"><?php __('Archivos'); ?></legend>

                                          <small><i class="fa-regular fa-file fa-fw"></i> <?php __('Extensiones permitidas'); ?>: rar, txt, zip, doc, pdf, csv, xls, rtf, sxw, odt, docx, xlsx, ppt, jpg, jpeg, png <?php __('y'); ?> mov.</small>
                                          <br>
                                          <!-- <small><i class="fa-regular fa-arrows-maximize fa-fw"></i> <?php __('Para cambiar el orden de los archivos, arrastre y suelte el archivo en la ubicación deseada'); ?>.</small> -->

                                          <hr>

                                          <div id="file-order-loading"></div>
                                          <ul class="thumbnails nested-sortable-file-" id="file-list">
                                              <?php if($totalRows_rsFiles > 0) { ?>
                                              <?php do { ?>
                                                  <li class="pull-left" id="order_<?php echo $row_rsFiles['id_fil'] ?>" data-id="<?php echo $row_rsFiles['id_fil'] ?>">
                                                      <div class="img-thumbnail pull-left">

                                                          <?php 
                                                          $info = pathinfo($row_rsFiles['file_fil']);
                                                          $extension = $info['extension'];

                                                  
                                                          if ($info['extension'] == 'jpg' || $info['extension'] == 'jpeg' || $info['extension'] == 'png') 
                                                          {
                                                          ?>
                                                              <a href="/media/files/clients/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="d-inline-block">
                                                                <img class="img-fluid" src="/media/files/clients/<?php echo $row_rsFiles['file_fil']; ?>">
                                                              </a> 
                                                          <?php 
                                                          }
                                                          else
                                                          {
                                                          ?>
                                                              <a href="/media/files/clients/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br><small><?php echo $row_rsFiles['file_fil']; ?></small></a>
                                                          <?php
                                                          }
                                                          ?>
                                                          <p class="text-center">
                                                          <!-- <a href="#" class="btn btn-success btn-sm edit-name" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-pencil"></i></a> -->
                                                          <a href="/intramedianet/properties/cfiles_del.php" data-id="<?php echo $row_rsFiles['id_fil'] ?>" class="btn btn-danger btn-sm del-fil"><i class="fa-regular fa-trash-can"></i></a>
                                                          </p>
                                                      </div>
                                                  </li>
                                                  <?php } while ($row_rsFiles = mysqli_fetch_assoc($rsFiles)); ?>
                                              <?php } ?>
                                          </ul>

                                          <?php if ($actColaboradores == 1): ?>
                                              <hr>
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
                                              </div>
                                          <?php endif ?>
                                          <hr>
                                          <div class="multi_files"></div>

                                        </div>
                                    </div>

              


                                     <div>
                                        <label class="checkcontainer my-4">
                                            <span class="tag-name">

                                                <?php echo $langStr["Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad"]; ?>

                                            </span>
                                            <input type="checkbox" name="lpd" id="lpd" class="required" />
                                            <span class="checkmark"></span>

                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                        </label>
                                    </div>



                                    <div class="gdpr">
                                      <?php echo $texto_formularios_GDPR;?>
                                    </div>


                                </div><!-- end card-body -->
                            </div>


                        </div>


                    </div>

                </div>

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

    </div>

    <script>
    var strSearch = '<?php __('Buscar') ?>';
    var strFieldSubject = '<?php __('El campo asunto es requerido') ?>';
    var strFieldMessage = '<?php __('El campo mensaje es requerido') ?>';
    var idClient = '<?php echo $clientId; ?>';
    var oTable;
    var selected =  new Array();
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

    </script>


    <script src="_js/clients-form.js?id=<?php echo time() ?>" type="text/javascript"></script>

<script>


// Si cambia el checkbox de idealista muestra el formulario
$('#mortgage_cli').change(function(e) {
  e.preventDefault();
  if ($(this).is(':checked') == true) 
  {
    $('#mortgage_data').fadeIn('slow');
  } 
  else
  {
    $('#mortgage_data').fadeOut('slow');
  }
});


    $(document).on("click",".view-mail-cont", function(e){ //user click on remove text
        e.preventDefault();

        $.get('view-mensa.php?id=' + $(this).data('id'), function(data) {
             $('#mail-text').html(data);
             $('#myModal3').modal('show');
        });
    });


    var flatpickrExamples = document.querySelectorAll("[data-provider]");
    Array.from(flatpickrExamples).forEach(function (item) {
      if (item.getAttribute("data-provider") == "flatpickr") {
        var dateData = {};
        var isFlatpickerVal = item.attributes;
        if (isFlatpickerVal["data-date-format"])
          dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        if (isFlatpickerVal["data-enable-time"]) {
          (dateData.enableTime = true),
          (dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString() + " H:i");
        }
        if (isFlatpickerVal["data-enable-time-24hr"]) {
          (dateData.time_24hr = true)
        }
        if (isFlatpickerVal["data-altFormat"]) {
          (dateData.altInput = true),
          (dateData.altFormat = isFlatpickerVal["data-altFormat"].value.toString());
        }
        if (isFlatpickerVal["data-minDate"]) {
          dateData.minDate = isFlatpickerVal["data-minDate"].value.toString();
          dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-maxDate"]) {
          dateData.maxDate = isFlatpickerVal["data-maxDate"].value.toString();
          dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-deafult-date"]) {
          dateData.defaultDate = isFlatpickerVal["data-deafult-date"].value.toString();
          dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-multiple-date"]) {
          dateData.mode = "multiple";
          dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-range-date"]) {
          dateData.mode = "range";
          dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-inline-date"]) {
          (dateData.inline = true),
          (dateData.defaultDate = isFlatpickerVal["data-deafult-date"].value.toString());
          dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-disable-date"]) {
          var dates = [];
          dates.push(isFlatpickerVal["data-disable-date"].value);
          dateData.disable = dates.toString().split(",");
        }
        if (isFlatpickerVal["data-week-number"]) {
          var dates = [];
          dates.push(isFlatpickerVal["data-week-number"].value);
          dateData.weekNumbers = true;
        }
        if (applang == 'es') {
          dateData.locale = 'es';
        }
        flatpickr(item, dateData);
      } else if (item.getAttribute("data-provider") == "timepickr") {
        var timeData = {};
        var isTimepickerVal = item.attributes;
        if (isTimepickerVal["data-time-basic"]) {
          (timeData.enableTime = true),
          (timeData.noCalendar = true),
          (timeData.dateFormat = "H:i");
        }
        if (isTimepickerVal["data-time-hrs"]) {
          (timeData.enableTime = true),
          (timeData.noCalendar = true),
          (timeData.dateFormat = "H:i"),
          (timeData.time_24hr = true);
        }
        if (isTimepickerVal["data-min-time"]) {
          (timeData.enableTime = true),
          (timeData.noCalendar = true),
          (timeData.dateFormat = "H:i"),
          (timeData.minTime = isTimepickerVal["data-min-time"].value.toString());
        }
        if (isTimepickerVal["data-max-time"]) {
          (timeData.enableTime = true),
          (timeData.noCalendar = true),
          (timeData.dateFormat = "H:i"),
          (timeData.minTime = isTimepickerVal["data-max-time"].value.toString());
        }
        if (isTimepickerVal["data-default-time"]) {
          (timeData.enableTime = true),
          (timeData.noCalendar = true),
          (timeData.dateFormat = "H:i"),
          (timeData.defaultDate = isTimepickerVal["data-default-time"].value.toString());
        }
        if (isTimepickerVal["data-time-inline"]) {
          (timeData.enableTime = true),
          (timeData.noCalendar = true),
          (timeData.defaultDate = isTimepickerVal["data-time-inline"].value.toString());
          timeData.inline = true;
        }
        flatpickr(item, timeData);
      }
    });
</script>

    <div id="myModal3" class="modal  fade" tabindex="-1" aria-labelledby="myModal3Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="mail-text"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



</body>



</html>
