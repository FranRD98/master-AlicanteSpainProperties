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

if (!isset($_GET['id_cli'])) {
  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'properties_client'";
  $rsNextIncrement = mysqli_query($inmoconn,$query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);
  $clientId = $row_rsNextIncrement['Auto_increment'];
} else {
  $clientId = $_GET['id_cli'];
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  
  mysqli_real_escape_string($inmoconn,$theValue);
  
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
$rsTipos = mysqli_query($inmoconn, $query_rsTipos ) or die(mysqli_error());
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

$query_rsStatus = "SELECT * FROM properties_client_states ORDER BY category_".$lang_adm."_sts ASC";
$rsStatus = mysqli_query($inmoconn,$query_rsStatus) or die(mysqli_error());
$row_rsStatus = mysqli_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysqli_num_rows($rsStatus);

$query_rsCaptado = "SELECT * FROM properties_client_captado ORDER BY category_".$lang_adm."_cap ASC";
$rsCaptado = mysqli_query($inmoconn,$query_rsCaptado) or die(mysqli_error());
$row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
$totalRows_rsCaptado = mysqli_num_rows($rsCaptado);

$query_rsSources = "SELECT * FROM properties_client_sources ORDER BY category_".$lang_adm."_sts ASC";
$rsSources = mysqli_query($inmoconn,$query_rsSources) or die(mysqli_error());
$row_rsSources = mysqli_fetch_assoc($rsSources);
$totalRows_rsSources = mysqli_num_rows($rsSources);

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
FROM 
    properties_loc4 towns
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
FROM 
    properties_loc4 towns
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
WHERE 
    areas1.parent_loc3 IS NULL
GROUP BY id
ORDER BY `name` ASC";

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

$query_rsNationalities = "SELECT id_ncld, nacionalidad_".$lang_adm."_ncld FROM nacionalidades ORDER BY nacionalidad_".$lang_adm."_ncld";
$rsNationalities = mysqli_query($inmoconn,$query_rsNationalities) or die(mysqli_error());
$row_rsNationalities = mysqli_fetch_assoc($rsNationalities);
$totalRows_rsNationalities = mysqli_num_rows($rsNationalities);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_cli", true, "text", "", "", "", "");
$formValidation->addField("apellidos_cli", true, "text", "", "", "", "");
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
if (isset($_POST['b_ocultos_cli']) && $_POST['b_ocultos_cli'] != '' ) {
  $_POST['b_ocultos_cli'] = implode(',', $_POST['b_ocultos_cli']);
}

// Make an insert transaction instance
$ins_properties_client = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_client);
// Register triggers
$ins_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_client->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_client->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
// Add columns
$ins_properties_client->setTable("properties_client");
$ins_properties_client->addColumn("nombre_cli", "STRING_TYPE", "POST", "nombre_cli");
$ins_properties_client->addColumn("apellidos_cli", "STRING_TYPE", "POST", "apellidos_cli");
$ins_properties_client->addColumn("direccion_cli", "STRING_TYPE", "POST", "direccion_cli");
$ins_properties_client->addColumn("telefono_fijo_cli", "STRING_TYPE", "POST", "telefono_fijo_cli");
$ins_properties_client->addColumn("telefono_movil_cli", "STRING_TYPE", "POST", "telefono_movil_cli");
$ins_properties_client->addColumn("email_cli", "STRING_TYPE", "POST", "email_cli");
$ins_properties_client->addColumn("skype_cli", "STRING_TYPE", "POST", "skype_cli");
$ins_properties_client->addColumn("como_nos_conocio_cli", "STRING_TYPE", "POST", "como_nos_conocio_cli");
$ins_properties_client->addColumn("captado_por_cli", "STRING_TYPE", "POST", "captado_por_cli");
$ins_properties_client->addColumn("fecha_alta_cli", "DATE_TYPE", "POST", "fecha_alta_cli");
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
$ins_properties_client->addColumn("b_precio_desde_cli", "STRING_TYPE", "POST", "b_precio_desde_cli");
$ins_properties_client->addColumn("b_precio_hasta_cli", "STRING_TYPE", "POST", "b_precio_hasta_cli");
$ins_properties_client->addColumn("b_opciones_cli", "STRING_TYPE", "POST", "b_opciones_cli");
$ins_properties_client->addColumn("b_opciones2_cli", "STRING_TYPE", "POST", "b_opciones2_cli");
$ins_properties_client->addColumn("b_ocultos_cli", "STRING_TYPE", "POST", "b_ocultos_cli");
$ins_properties_client->addColumn("nie_cli", "STRING_TYPE", "POST", "nie_cli");
$ins_properties_client->addColumn("pasaporte_cli", "STRING_TYPE", "POST", "pasaporte_cli");
$ins_properties_client->addColumn("residencia_fiscal_cli", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_cli", "0");
$ins_properties_client->addColumn("nacionalidad_cli", "STRING_TYPE", "POST", "nacionalidad_cli");
$ins_properties_client->addColumn("notas_cli", "STRING_TYPE", "POST", "notas_cli");
$ins_properties_client->addColumn("b_orientacion_cli", "STRING_TYPE", "POST", "b_orientacion_cli");
$ins_properties_client->addColumn("puntuacion_cli", "STRING_TYPE", "POST", "puntuacion_cli", "0");
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
// Add columns
$upd_properties_client->setTable("properties_client");
$upd_properties_client->addColumn("nombre_cli", "STRING_TYPE", "POST", "nombre_cli");
$upd_properties_client->addColumn("apellidos_cli", "STRING_TYPE", "POST", "apellidos_cli");
$upd_properties_client->addColumn("direccion_cli", "STRING_TYPE", "POST", "direccion_cli");
$upd_properties_client->addColumn("telefono_fijo_cli", "STRING_TYPE", "POST", "telefono_fijo_cli");
$upd_properties_client->addColumn("telefono_movil_cli", "STRING_TYPE", "POST", "telefono_movil_cli");
$upd_properties_client->addColumn("email_cli", "STRING_TYPE", "POST", "email_cli");
$upd_properties_client->addColumn("skype_cli", "STRING_TYPE", "POST", "skype_cli");
$upd_properties_client->addColumn("como_nos_conocio_cli", "STRING_TYPE", "POST", "como_nos_conocio_cli");
$upd_properties_client->addColumn("captado_por_cli", "STRING_TYPE", "POST", "captado_por_cli");
$upd_properties_client->addColumn("fecha_alta_cli", "DATE_TYPE", "POST", "fecha_alta_cli");
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
$upd_properties_client->addColumn("b_ocultos_cli", "STRING_TYPE", "POST", "b_ocultos_cli");
$upd_properties_client->addColumn("nie_cli", "STRING_TYPE", "POST", "nie_cli");
$upd_properties_client->addColumn("pasaporte_cli", "STRING_TYPE", "POST", "pasaporte_cli");
$upd_properties_client->addColumn("residencia_fiscal_cli", "CHECKBOX_1_0_TYPE", "POST", "residencia_fiscal_cli");
$upd_properties_client->addColumn("user_cli", "STRING_TYPE", "CURRVAL","user_cli");
$upd_properties_client->addColumn("nacionalidad_cli", "STRING_TYPE", "POST", "nacionalidad_cli");
$upd_properties_client->addColumn("notas_cli", "STRING_TYPE", "POST", "notas_cli");
$upd_properties_client->addColumn("b_orientacion_cli", "STRING_TYPE", "POST", "b_orientacion_cli");
$upd_properties_client->addColumn("puntuacion_cli", "STRING_TYPE", "POST", "puntuacion_cli");
$upd_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE", "GET", "id_cli");

// Make an instance of the transaction object
$del_properties_client = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_client);
// Register triggers
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_properties_client->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
// Add columns
$del_properties_client->setTable("properties_client");
$del_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE", "GET", "id_cli");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_client = $tNGs->getRecordset("properties_client");
$row_rsproperties_client = mysqli_fetch_assoc($rsproperties_client);
$totalRows_rsproperties_client = mysqli_num_rows($rsproperties_client);
$row_rsproperties_client=array();

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1 d-none d-md-block"><i class="fa-regular fa-magnifying-glass"></i> <?php echo __('Búsqueda avanzada'); ?>: <?php __('Clientes'); ?></h4>
                    <div class="flex-shrink-0">
                        <?php if ($_SESSION['kt_login_level'] == 9): ?>
                        <a href="#" class="btn btn-primary btn-sm me-2 downoutlook d-none d-md-inline-block"><i class="fa-regular fa-file-csv me-1"></i> <?php __('Descargar para Outlook'); ?> </a>
                        <a href="#" class="btn btn-primary btn-sm downcsv"><i class="fa-regular fa-file-excel me-1"></i> <?php __('Descargar para Excel'); ?> </a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">

                    <?php echo $tNGs->getErrorMsg(); ?>

                    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nombre_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="nombre_cli" class="form-label"><?php __('Nombre'); ?>:</label>
                                    <input type="text" name="nombre_cli" id="nombre_cli" value="<?php if(isset($row_rsproperties_client['nombre_cli'])) echo KT_escapeAttribute($row_rsproperties_client['nombre_cli']); ?>" size="32" maxlength="255" class="form-control">
                                      <?php echo $tNGs->displayFieldError("properties_client", "nombre_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "apellidos_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="apellidos_cli" class="form-label"><?php __('Apellidos'); ?>:</label>
                                    <input type="text" name="apellidos_cli" id="apellidos_cli" value="<?php if(isset($row_rsproperties_client['apellidos_cli'])) echo KT_escapeAttribute($row_rsproperties_client['apellidos_cli']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("properties_client", "apellidos_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "nie_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="nie_cli" class="form-label"><?php __('NIE'); ?>:</label>
                                    <input type="text" name="nie_cli" id="nie_cli" value="<?php if(isset($row_rsproperties_client['nie_cli'])) echo KT_escapeAttribute($row_rsproperties_client['nie_cli']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("properties_client", "nie_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "pasaporte_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="pasaporte_cli" class="form-label"><?php __('Pasaporte'); ?>:</label>
                                    <input type="text" name="pasaporte_cli" id="pasaporte_cli" value="<?php if(isset($row_rsproperties_client['pasaporte_cli'])) echo KT_escapeAttribute($row_rsproperties_client['pasaporte_cli']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("properties_client", "pasaporte_cli"); ?>
                                </div>

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

                                <div class="mb-4">
                                    <label for="idioma_cli" class="form-label"><?php __('Idioma'); ?>:</label>
                                    <select name="idioma_cli" id="idioma_cli" class="form-select">
                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
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

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "telefono_fijo_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="telefono_fijo_cli" class="form-label"><?php __('Teléfono'); ?>:</label>
                                    <input type="text" name="telefono_fijo_cli" id="telefono_fijo_cli" value="<?php if(isset($row_rsproperties_client['telefono_fijo_cli'])) echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo_cli']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("properties_client", "telefono_fijo_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "telefono_movil_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="telefono_movil_cli" class="form-label"><?php __('Móvil'); ?>:</label>
                                    <input type="text" name="telefono_movil_cli" id="telefono_movil_cli" value="<?php if(isset($row_rsproperties_client['telefono_movil_cli'])) echo KT_escapeAttribute($row_rsproperties_client['telefono_movil_cli']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("properties_client", "telefono_movil_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "direccion_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="direccion_cli" class="form-label"><?php __('Dirección'); ?>:</label>
                                    <input type="text" name="direccion_cli" id="direccion_cli" value="<?php if(isset($row_rsproperties_client['direccion_cli'])) echo KT_escapeAttribute($row_rsproperties_client['direccion_cli']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("properties_client", "direccion_cli"); ?>
                                </div>

                                <?php /* ?>
                                <div class="checkbox">
                                  <label>
                                      <input  <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client['residencia_fiscal_cli']),"1"))) {echo "checked";} ?> type="checkbox" name="residencia_fiscal_cli" id="residencia_fiscal_cli" value="1" class="onoffbtn" />
                                      <?php __('Residencia fiscal'); ?>
                                  </label>
                                </div>
                                <?php */ ?>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-2 <?php if($tNGs->displayFieldError("properties_client", "puntuacion_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="puntuacion_cli" class="form-label"><?php __('Puntuación'); ?>:</label>
                                    <div>
                                        <div id="raterreset" class="align-middle mt-2"></div>
                                        <span class="clear-rating"></span>
                                        <button type="button" id="raterreset-button" class="btn btn-soft-danger btn-sm ms-2 mt-2"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                    <input type="hidden" name="puntuacion_cli" id="puntuacion_cli" value="" size="32" maxlength="255" class="form-control rating">
                                    <?php echo $tNGs->displayFieldError("properties_properties", "puntuacion_cli"); ?>
                                </div>

                                <br>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "fecha_alta_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="fecha_alta_cli" class="form-label" class="form-label"><?php __('Añadido'); ?>:</label>
                                    <input type="text" name="fecha_alta_cli" id="fecha_alta_cli" value="<?php if(isset($row_rsproperties_client['fecha_alta_cli'])) echo KT_formatDate($row_rsproperties_client['fecha_alta_cli']); ?>" size="32" maxlength="255" class="form-control" data-provider="flatpickr" data-date-format="d-m-Y">
                                    <?php echo $tNGs->displayFieldError("properties_client", "fecha_alta_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "email_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="email_cli" class="form-label" class="form-label"><?php __('Email'); ?>:</label>
                                    <input type="text" name="email_cli" id="email_cli" value="<?php if(isset($row_rsproperties_client['email_cli'])) echo KT_escapeAttribute($row_rsproperties_client['email_cli']); ?>" size="32" maxlength="255" class="form-control">
                                    <?php echo $tNGs->displayFieldError("properties_client", "email_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "skype_cli") != '') { ?>has-error<?php } ?>">
                                     <label for="skype_cli" class="form-label" class="form-label"><?php __('Skype'); ?>:</label>
                                     <input type="text" name="skype_cli" id="skype_cli" value="<?php if(isset($row_rsproperties_client['skype_cli'])) echo KT_escapeAttribute($row_rsproperties_client['skype_cli']); ?>" size="32" maxlength="255" class="form-control">
                                     <?php echo $tNGs->displayFieldError("properties_client", "skype_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "status_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="status_cli" class="form-label" class="form-label"><?php __('Estatus'); ?>:</label>
                                    <div class="controls">
                                        <select name="status_cli" id="status_cli" class="select2">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php do { ?>
                                            <option value="<?php echo $row_rsStatus ['id_sts']?>"<?php if ( isset($row_rsproperties_client['status_cli']) && !(strcmp($row_rsStatus ['id_sts'], $row_rsproperties_client['status_cli']))) {echo "SELECTED";} ?>><?php echo $row_rsStatus ['category_'.$lang_adm.'_sts']?></option>
                                            <?php } while ($row_rsStatus  = mysqli_fetch_assoc($rsStatus ));
                                              $rows = mysqli_num_rows($rsStatus );
                                              if($rows > 0) {
                                                  mysqli_data_seek($rsStatus , 0);
                                                $row_rsStatus  = mysqli_fetch_assoc($rsStatus );
                                              } ?>
                                        </select>
                                        <?php echo $tNGs->displayFieldError("properties_client", "status_cli"); ?>
                                    </div>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "captado_por2_cli") != '') { ?>has-error<?php } ?>">
                                <label for="captado_por2_cli" class="form-label" class="form-label"><?php __('Captado por'); ?>:</label>
                                    <select name="captado_por2_cli" id="captado_por2_cli" class="select2">
                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                        <?php do { ?>
                                        <option value="<?php echo $row_rsCaptado ['id_cap']?>"><?php echo $row_rsCaptado ['category_'.$lang_adm.'_cap']?></option>
                                        <?php } while ($row_rsCaptado  = mysqli_fetch_assoc($rsCaptado ));
                                          $rows = mysqli_num_rows($rsCaptado );
                                          if($rows > 0) {
                                              mysqli_data_seek($rsCaptado , 0);
                                            $row_rsCaptado  = mysqli_fetch_assoc($rsCaptado );
                                          } ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("properties_client", "captado_por2_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "como_nos_conocio_cli") != '') { ?>has-error<?php } ?>">
                                <label for="como_nos_conocio_cli" class="form-label" class="form-label"><?php __('Cómo nos conoció'); ?>:</label>
                                    <select name="como_nos_conocio_cli" id="como_nos_conocio_cli" class="select2">
                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                        <?php do { ?>
                                        <option value="<?php echo $row_rsSources['id_sts']?>"><?php echo $row_rsSources['category_'.$lang_adm.'_sts']?></option>
                                        <?php } while ($row_rsSources = mysqli_fetch_assoc($rsSources));
                                          $rows = mysqli_num_rows($rsSources);
                                          if($rows > 0) {
                                              mysqli_data_seek($rsSources, 0);
                                            $row_rsSources = mysqli_fetch_assoc($rsSources);
                                          } ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("properties_client", "como_nos_conocio_cli"); ?>
                                </div>

                                <div class=" mb-4<?php if($tNGs->displayFieldError("properties_client", "visited_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="visited_cli" class="form-label" class="form-label"><?php __('Inmuebles visitados'); ?>:</label>
                                    <input type="text" class="select2references" id="visited_cli" name="visited_cli[]" value="" tabindex="-1">
                                    <?php echo $tNGs->displayFieldError("properties_client", "visited_cli"); ?>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">

                                      <div class="mb-4">
                                        <label for="atendido_cli" class="form-label"><?php __('Atendido'); ?>:</label>
                                        <div>
                                          <select name="atendido_cli" id="atendido_cli" class="select2">
                                            <option value=""><?php echo $lang['Todos']; ?></option>
                                            <option value="0"><?php echo $lang['No']; ?></option>
                                            <option value="1"><?php echo $lang['Sí']; ?></option>
                                          </select>
                                        </div>
                                      </div>

                                  </div>
                                  <div class="col-md-6">

                                      <div class="mb-4">
                                        <label for="ha_comprado_cli" class="form-label"><?php __('Ha comprado'); ?>:</label>
                                        <div>
                                          <select name="ha_comprado_cli" id="ha_comprado_cli" class="select2">
                                            <option value=""><?php echo $lang['Todos']; ?></option>
                                            <option value="0"><?php echo $lang['No']; ?></option>
                                            <option value="1"><?php echo $lang['Sí']; ?></option>
                                          </select>
                                        </div>
                                      </div>

                                  </div>
                                </div>

                                <?php /* ?>
                                <div class="row">
                                  <div class="col-md-6">

                                      <div class="form-group <?php if($tNGs->displayFieldError("properties_client", "captado_por_cli") != '') { ?>has-error<?php } ?>">
                                        <label for="captado_por_cli" class="form-label" class="form-label"><?php __('Captado por'); ?>:</label>
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

                                  </div>
                                  <div class="col-md-6">
                                <?php */ ?>

                            </div>

                        </div>

                        <legend class="fs-3 border-bottom"><?php __('Criterios de búsqueda'); ?></legend>

                          <div class="row" id="search-fields">

                            <div class="col-md-6">

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_sale_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="b_sale_cli" class="form-label"><?php __('Operación'); ?>:</label>
                                    <select name="b_sale_cli[]" id="b_sale_cli" multiple class="select2">
                                        <?php do {
                                          $vals = array();
                                          if(isset($row_rsproperties_client['b_sale_cli']))
                                            $vals = explode(',', $row_rsproperties_client['b_sale_cli']); 
                                        ?>
                                        <option value="<?php echo $row_rsSales['id_sta']?>"><?php echo $row_rsSales['status_'.$lang_adm.'_sta']?></option>
                                        <?php } while ($row_rsSales = mysqli_fetch_assoc($rsSales ));
                                          $rows = mysqli_num_rows($rsSales );
                                          if($rows > 0) {
                                              mysqli_data_seek($rsSales , 0);
                                            $row_rsSales = mysqli_fetch_assoc($rsSales );
                                          } ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("properties_client", "b_sale_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_type_cli") != '') { ?>has-error<?php } ?>">
                                      <label for="b_type_cli" class="form-label"><?php __('Tipo'); ?>:</label>
                                      <select name="b_type_cli[]" id="b_type_cli" multiple class="select2">
                                        <?php
                                        do {
                                          $vals = array();
                                          if(isset($row_rsproperties_client['b_type_cli']))
                                            $vals = explode(',', $row_rsproperties_client['b_type_cli']);
                                        ?>
                                        <option value="<?php echo $row_rsTipos['id_type'] ?>"><?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?></option>
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

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_loc1_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="b_loc1_cli" class="form-label"><?php __('País'); ?>:</label>
                                    <select name="b_loc1_cli[]" id="b_loc1_cli" multiple class="select2">
                                      <?php do {
                                        $vals = array();
                                        if(isset($row_rsproperties_client['b_loc1_cli']))
                                          $vals = explode(',', $row_rsproperties_client['b_loc1_cli']);
                                      ?>
                                      <option value="<?php echo $row_rsparent1['id'] ?>" ><?php echo $row_rsparent1['name'] ?></option>
                                      <?php } while ($row_rsparent1 = mysqli_fetch_assoc($rsparent1)); ?>
                                    </select>
                                      <?php echo $tNGs->displayFieldError("properties_client", "b_loc1_cli"); ?>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_loc2_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="b_loc2_cli" class="form-label"><?php __('Provincia'); ?>:</label>
                                    <select name="b_loc2_cli[]" id="b_loc2_cli" multiple class="select2">
                                      <?php do {
                                        $vals = array();
                                        if(isset($row_rsproperties_client['b_loc2_cli']))
                                          $vals = explode(',', $row_rsproperties_client['b_loc2_cli']);
                                      ?>
                                      <option value="<?php echo $row_rsparent2['id'] ?>" ><?php echo $row_rsparent2['name'] ?></option>
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
                                      <option value="<?php echo $row_rsparent3['id'] ?>" ><?php echo $row_rsparent3['name'] ?></option>
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
                                      <option value="<?php echo $row_rsparent4['id'] ?>" ><?php echo $row_rsparent4['name'] ?></option>
                                      <?php } while ($row_rsparent4 = mysqli_fetch_assoc($rsparent4)); ?>
                                    </select>
                                      <?php echo $tNGs->displayFieldError("properties_client", "b_loc4_cli"); ?>
                                </div>

                                <div class="row">

                                  <div class="col-md-6">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_precio_desde_cli") != '') { ?>has-error<?php } ?>">
                                          <label for="b_precio_desde_cli" class="form-label"><?php __('Precio desde'); ?>:</label>
                                          <input type="text" name="b_precio_desde_cli" id="b_precio_desde_cli" value="<?php if(isset($row_rsproperties_client['b_precio_desde_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_precio_desde_cli']); ?>" size="32" maxlength="255" class="form-select">
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_precio_desde_cli"); ?>
                                      </div>

                                      <div class="mt-n3 text-muted"><?php __('Sin puntos ni comas ni símbolos €') ?></div>

                                  </div>

                                  <div class="col-md-6">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_precio_hasta_cli") != '') { ?>has-error<?php } ?>">
                                          <label for="b_precio_hasta_cli" class="form-label"><?php __('Precio hasta'); ?>:</label>
                                          <input type="text" name="b_precio_hasta_cli" id="b_precio_hasta_cli" value="<?php if(isset($row_rsproperties_client['b_precio_hasta_cli'])) echo KT_escapeAttribute($row_rsproperties_client['b_precio_hasta_cli']); ?>" size="32" maxlength="255" class="form-select">
                                          <?php echo $tNGs->displayFieldError("properties_client", "b_precio_hasta_cli"); ?>
                                      </div>

                                  </div>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_beds_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="b_beds_cli" class="form-label"><?php __('Habitaciones'); ?>:</label>
                                    <div class="controls">
                                        <select name="b_beds_cli" id="b_beds_cli" class="select2">
                                            <option value="" <?php if ( isset($row_rsproperties_client['b_beds_cli']) && !(strcmp("", $row_rsproperties_client['b_beds_cli']))) {echo "selected=\"selected\"";} ?>><?php echo $lang['Todos']; ?></option>
                                            <?php
                                            for ($i=1; $i < 100; $i++) {
                                            ?>
                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                            <?php
                                              }
                                            ?>
                                        </select>
                                        <?php echo $tNGs->displayFieldError("properties_client", "b_beds_cli"); ?>
                                    </div>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_baths_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="b_baths_cli" class="form-label"><?php __('Aseos'); ?>:</label>
                                    <div class="controls">
                                        <select name="b_baths_cli" id="b_baths_cli" class="select2">
                                            <option value="" ><?php echo $lang['Todos']; ?></option>
                                            <?php
                                            for ($i=1; $i < 100; $i++) {
                                            ?>
                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                            <?php
                                              }
                                            ?>
                                        </select>
                                        <?php echo $tNGs->displayFieldError("properties_client", "b_baths_cli"); ?>
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
                                      <option value="<?php echo $row_rsOpciones['id'] ?>"><?php echo $row_rsOpciones['name'] ?></option>
                                      <?php } while ($row_rsOpciones = mysqli_fetch_assoc($rsOpciones)); ?>
                                    </select>
                                      <?php echo $tNGs->displayFieldError("properties_client", "b_opciones_cli"); ?>
                                  </div>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_opciones2_cli") != '') { ?>has-error<?php } ?>">
                                  <label for="b_opciones2_cli" class="form-label"><?php __('Características privadas'); ?>:</label>
                                  <div class="controls">
                                    <select name="b_opciones2_cli[]" id="b_opciones2_cli" multiple class="select2">
                                      <?php do {
                                        $vals = array();
                                        if(isset($row_rsproperties_client['b_opciones2_cli']))
                                          $vals = explode(',', $row_rsproperties_client['b_opciones2_cli']);
                                      ?>
                                      <?php if ($totalRows_rsOpciones2 > 0): ?>
                                      <option value="<?php echo $row_rsOpciones2['id'] ?>" ><?php echo $row_rsOpciones2['name'] ?></option>
                                      <?php endif ?>
                                      <?php } while ($row_rsOpciones2 = mysqli_fetch_assoc($rsOpciones2)); ?>
                                    </select>
                                      <?php echo $tNGs->displayFieldError("properties_client", "b_opciones2_cli"); ?>
                                  </div>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_tags_cli") != '') { ?>error<?php } ?>">
                                  <label for="b_tags_cli" class="form-label"><?php __('Etiquetas'); ?>:</label>
                                  <div>
                                    <select name="b_tags_cli[]" id="b_tags_cli" multiple class="select2">
                                      <?php do {
                                        $vals = array();
                                        if(isset($row_rsproperties_client['b_tags_cli']))
                                          $vals = explode(',', $row_rsproperties_client['b_tags_cli']);
                                      ?>
                                      <option value="<?php echo $row_rsTags['id'] ?>"><?php echo $row_rsTags['name'] ?></option>
                                      <?php } while ($row_rsTags = mysqli_fetch_assoc($rsTags)); ?>
                                    </select>
                                      <?php echo $tNGs->displayFieldError("properties_client", "b_tags_cli"); ?>
                                  </div>
                                </div>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_ref_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="b_ref_cli" class="form-label"><?php __('Referencia'); ?>:</label>
                                    <select name="b_ref_cli[]" id="b_ref_cli" multiple class="select2">
                                      <?php do {
                                        $vals = array();
                                        if(isset($row_rsproperties_client['b_ref_cli']))
                                          $vals = explode(',', $row_rsproperties_client['b_ref_cli']);
                                        if($row_rsReferencias['name'] != '') { ?>
                                      <option value="<?php echo $row_rsReferencias['name'] ?>"><?php echo $row_rsReferencias['name'] ?></option>
                                      <?php } } while ($row_rsReferencias = mysqli_fetch_assoc($rsReferencias)); ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("properties_client", "b_ref_cli"); ?>
                                </div>

                                <?php if ($actUsuarios == 1) { ?>

                                <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "favs") != '') { ?>has-error<?php } ?>">
                                    <label for="favs" class="form-label"><?php __('Favoritos'); ?>:</label>
                                    <select name="favs[]" id="favs" multiple class="select2">
                                      <?php
                                        $query_rsFavs = "SELECT * FROM users_favorites WHERE user= '".KT_escapeAttribute($row_rsproperties_client['user_cli'])."' GROUP BY user, property ORDER BY id";
                                        $rsFavs = mysqli_query($inmoconn,$query_rsFavs) or die(mysqli_error());
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

                                <!-- <div class="form-group <?php if($tNGs->displayFieldError("properties_client", "b_ocultos_cli") != '') { ?>has-error<?php } ?>">
                                    <label for="b_ocultos_cli" class="form-label"><?php __('Ocultos'); ?>:</label>
                                    <select name="b_ocultos_cli[]" id="b_ocultos_cli" multiple class="select2">
                                      <?php do {
                                        $vals = array();
                                        if(isset($row_rsproperties_client['b_ocultos_cli']))
                                          $vals = explode(',', $row_rsproperties_client['b_ocultos_cli']); ?>
                                      <option value="<?php echo $row_rsReferencias3['name'] ?>" <?php if (in_array($row_rsReferencias3['name'], $vals)) {echo "SELECTED";} ?>><?php echo $row_rsReferencias3['name'] ?></option>
                                      <?php } while ($row_rsReferencias3 = mysqli_fetch_assoc($rsReferencias3)); ?>
                                    </select>
                                    <?php echo $tNGs->displayFieldError("properties_client", "b_ocultos_cli"); ?>
                                </div> -->

                            </div>

                        </div>

                    </form>

                      <legend class="fs-3 border-bottom"><?php __('Clientes'); ?></legend>

                      <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                          <thead class="table-light">
                              <tr>
                                  <th><?php __('Nombre'); ?></th>
                                  <th><?php __('Apellidos'); ?></th>
                                  <th><?php __('Email'); ?></th>
                                  <th><?php __('Teléfono'); ?></th>
                                  <th><?php __('Móvil'); ?></th>
                                  <th><?php __('Captado por'); ?></th>
                                  <th><?php __('Puntuación'); ?></th>
                                  <th><?php __('Estatus'); ?></th>
                                  <?php if($actUsuarios == 1) { ?>
                                  <th><?php __('Favoritos'); ?></th>
                                  <?php } ?>
                                  <th><?php __('Atendido'); ?></th>
                                  <th id="actionsOrder">
                                      <div class="row">
                                          <div class="col-xs-8" id="col-1">

                                          </div>
                                          <div class="col-xs-4" id="col-2">

                                          </div>
                                      </div>
                                  </th>
                              </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php if($actUsuarios == 1) { ?>
                                <td colspan="11" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                <?php } else { ?>
                                <td colspan="10" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var numCols = <?php echo ($actUsuarios == 1)?10:9; ?>;
    var numColsAtendido = <?php echo ($actUsuarios == 1)?9:8; ?>;
    </script>

    <script src="_js/clients-search.js?id=<?php echo time(); ?>" type="text/javascript"></script>

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

    if (document.querySelector('#raterreset')) {
        var starRatingreset = raterJs({
            starSize: 22,
            rating: 0,
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
    </script>

</body>
</html>
