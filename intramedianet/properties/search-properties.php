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

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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
$rsTipos = $inmoconn->query($query_rsTipos); if(!$rsTipos) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsSales = "SELECT * FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsSales = $inmoconn->query($query_rsSales); if(!$rsSales) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);

 
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
$rsparent1 = $inmoconn->query($query_rsparent1); if(!$rsparent1) {die("Error en la consulta: " . $inmoconn->error);}
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
$rsparent2 = $inmoconn->query($query_rsparent2); if(!$rsparent2) {die("Error en la consulta: " . $inmoconn->error);}
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
$rsparent3 = $inmoconn->query($query_rsparent3); if(!$rsparent3) {die("Error en la consulta: " . $inmoconn->error);}
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
$rsparent4 = $inmoconn->query($query_rsparent4); if(!$rsparent4) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsparent4 = mysqli_fetch_assoc($rsparent4);
$totalRows_rsparent4 = mysqli_num_rows($rsparent4);


$query_rsReferencias = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias = $inmoconn->query($query_rsReferencias); if(!$rsReferencias) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsReferencias = mysqli_fetch_assoc($rsReferencias);
$totalRows_rsReferencias = mysqli_num_rows($rsReferencias);


$query_rsOpciones = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features ORDER BY name ASC";
$rsOpciones = $inmoconn->query($query_rsOpciones); if(!$rsOpciones) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsOpciones = mysqli_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysqli_num_rows($rsOpciones);


$query_rsOpciones2 = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features_priv ORDER BY name ASC";
$rsOpciones2 = $inmoconn->query($query_rsOpciones2); if(!$rsOpciones2) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsOpciones2 = mysqli_fetch_assoc($rsOpciones2);
$totalRows_rsOpciones2 = mysqli_num_rows($rsOpciones2);


$query_rsTags = "SELECT id_tag as id, tag_".$lang_adm."_tag as name FROM properties_tags ORDER BY name ASC";
$rsTags = $inmoconn->query($query_rsTags); if(!$rsTags) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTags = mysqli_fetch_assoc($rsTags);
$totalRows_rsTags = mysqli_num_rows($rsTags);


$query_rsPool = "SELECT pool_".$lang_adm."_pl as pool, id_pl FROM properties_pool ORDER BY pool ASC";
$rsPool = $inmoconn->query($query_rsPool); if(!$rsPool) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsPool = mysqli_fetch_assoc($rsPool);
$totalRows_rsPool = mysqli_num_rows($rsPool);


$query_rsParking = "SELECT parking_".$lang_adm."_prk as parking, id_prk FROM properties_parking ORDER BY parking ASC";
$rsParking = $inmoconn->query($query_rsParking); if(!$rsParking) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsParking = mysqli_fetch_assoc($rsParking);
$totalRows_rsParking = mysqli_num_rows($rsParking);

$query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsusuarios = $inmoconn->query($query_rsusuarios); if(!$rsusuarios) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);


$query_rsTeam = "SELECT * FROM teams ORDER BY nombre_tms";
$rsTeam = $inmoconn->query($query_rsTeam); if(!$rsTeam) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTeam = mysqli_fetch_assoc($rsTeam);
$totalRows_rsTeam = mysqli_num_rows($rsTeam);


$query_rscosta = "SELECT id_cst, coast_".$lang_adm."_cst as costa FROM properties_coast WHERE coast_".$lang_adm."_cst IS NOT NULL ORDER BY coast_".$lang_adm."_cst ASC";
$rscosta = $inmoconn->query($query_rscosta); if(!$rscosta) {die("Error en la consulta: " . $inmoconn->error);}
$row_rscosta = mysqli_fetch_assoc($rscosta);
$totalRows_rscosta = mysqli_num_rows($rscosta);

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
$upd_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE", "GET", "id_cli");

// Make an instance of the transaction object
$del_properties_client = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_client);
// Register triggers
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_client->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_client->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_properties_client->setTable("properties_client");
$del_properties_client->setPrimaryKey("id_cli", "NUMERIC_TYPE", "GET", "id_cli");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_client = $tNGs->getRecordset("properties_client");
$row_rsproperties_client = mysqli_fetch_assoc($rsproperties_client);    
$totalRows_rsproperties_client = mysqli_num_rows($rsproperties_client);


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php if(isset($_COOKIE['sidebarComp'])){ echo ($_COOKIE['sidebarComp'] != '')?$_COOKIE['sidebarComp']:'lg'; }?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1 d-none d-md-flex"><i class="fa-regular fa-magnifying-glass"></i> <?php echo __('Búsqueda avanzada'); ?>: <?php __('Propiedades'); ?></h4>
                    <div class="flex-shrink-0">
                        <?php if ($_SESSION['kt_login_level'] == 9): ?>
                        <a href="#" class="btn btn-primary btn-sm downcsv"><i class="fa-regular fa-file-excel me-1"></i> <?php __('Descargar para Excel'); ?> </a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">

                    <?php echo $tNGs->getErrorMsg(); ?>

                    <form method="post" id="formSearch" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">
                        <div id="search-fields">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_sale_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_sale_cli" class="form-label">
                                            <?php __('Operación'); ?>:</label>
                                        <div>
                                            <select name="b_sale_cli[]" id="b_sale_cli" multiple class="select2">
                                                <?php
                                                do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_sale_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_sale_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsSales['id_sta']?>" <?php if (in_array($row_rsSales['id_sta'], $vals)) {echo "selected=\" selected\"";} ?>>
                                                    <?php echo $row_rsSales['status_'.$lang_adm.'_sta']?>
                                                </option>
                                                <?php
                                                } while ($row_rsSales = mysqli_fetch_assoc($rsSales));
                                                  $rows = mysqli_num_rows($rsSales);
                                                  if($rows > 0) {
                                                      mysqli_data_seek($rsSales , 0);
                                                    $row_rsSales = mysqli_fetch_assoc($rsSales );
                                                  }
                                                ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_sale_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_type_cli" ) !='' ) { ?>has-error
                                        <?php } ?>">
                                        <label for="b_type_cli" class="form-label">
                                            <?php __('Tipo'); ?>:</label>
                                        <select name="b_type_cli[]" id="b_type_cli" multiple class="select2">
                                            <?php
                                            do {
                                                $vals = array();
                                                if(isset($row_rsproperties_client['b_type_cli']))
                                                    $vals = explode(',', $row_rsproperties_client['b_type_cli']);
                                            ?>
                                            <option value="<?php echo $row_rsTipos['id_type'] ?>">
                                                <?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?>
                                            </option>
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_beds_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_beds_cli" class="form-label">
                                            <?php __('Habitaciones'); ?>:</label>
                                        <div>
                                            <select name="b_beds_cli" id="b_beds_cli" class="select2">
                                                <option value="" <?php if ((isset($row_rsproperties_client['b_beds_cli'])) && (!(strcmp("", $row_rsproperties_client['b_beds_cli'])))) {echo "selected=\" selected\"";} ?>>
                                                    <?php echo $lang['Todos']; ?>
                                                </option>
                                                <?php
                                                for ($i=1; $i < 100; $i++) {
                                                ?>
                                                <option value="<?php echo $i?>" <?php if ((isset($row_rsproperties_client['b_beds_cli'])) && (!(strcmp($i, $row_rsproperties_client['b_beds_cli'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo $i?>
                                                </option>
                                                <?php
                                                  }
                                                ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_beds_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_baths_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_baths_cli" class="form-label">
                                            <?php __('Aseos'); ?>:</label>
                                        <div>
                                            <select name="b_baths_cli" id="b_baths_cli" class="select2">
                                                <option value="" <?php if((isset($row_rsproperties_client['b_baths_cli'])) && (!(strcmp("", $row_rsproperties_client['b_baths_cli'])))) {echo "selected=\" selected\"";} ?>>
                                                    <?php echo $lang['Todos']; ?>
                                                </option>
                                                <?php
                                                for ($i=1; $i < 100; $i++) {
                                                ?>
                                                <option value="<?php echo $i?>" <?php if ((isset($row_rsproperties_client['b_baths_cli'])) && (!(strcmp($i, $row_rsproperties_client['b_baths_cli'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo $i?>
                                                </option>
                                                <?php
                                                  }
                                                ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_baths_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_loc1_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_loc1_cli" class="form-label">
                                            <?php __('País'); ?>:</label>
                                        <div>
                                            <select name="b_loc1_cli[]" id="b_loc1_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc1_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_loc1_cli']);
                                          ?>
                                                <option value="<?php echo $row_rsparent1['id'] ?>" <?php if (in_array($row_rsparent1['id'], $vals)) {echo "SELECTED" ;} ?>>
                                                    <?php echo $row_rsparent1['name'] ?>
                                                </option>
                                                <?php } while ($row_rsparent1 = mysqli_fetch_assoc($rsparent1)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_loc1_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if ($actCostas == 1): ?>
                                  <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_coast_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_coast_cli" class="form-label">
                                            <?php __('Costa'); ?>:</label>
                                        <div>
                                            <select name="b_coast_cli[]" id="b_coast_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_costa_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_costa_cli']);
                                                ?>
                                                <option value="<?php echo $row_rscosta['id_cst']?>" <?php if (in_array($row_rscosta['id_cst'], $vals)) {echo "SELECTED" ;} ?>>
                                                    <?php echo $row_rscosta['costa'] ?>
                                                </option>
                                                <?php } while ($row_rscosta = mysqli_fetch_assoc($rscosta)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_coast_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                               <?php else:?>
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_loc2_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_loc2_cli" class="form-label">
                                            <?php __('Provincia'); ?>:</label>
                                        <div>
                                            <select name="b_loc2_cli[]" id="b_loc2_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc2_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_loc2_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsparent2['id'] ?>" <?php if (in_array($row_rsparent2['id'], $vals)) {echo "SELECTED" ;} ?>>
                                                    <?php echo $row_rsparent2['name'] ?>
                                                </option>
                                                <?php } while ($row_rsparent2 = mysqli_fetch_assoc($rsparent2)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_loc2_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif ?>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_loc3_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_loc3_cli" class="form-label">
                                            <?php __('Ciudad'); ?>:</label>
                                        <div>
                                            <select name="b_loc3_cli[]" id="b_loc3_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc3_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_loc3_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsparent3['id'] ?>" <?php if (in_array($row_rsparent3['id'], $vals)) {echo "SELECTED" ;} ?>>
                                                    <?php echo $row_rsparent3['name'] ?>
                                                </option>
                                                <?php } while ($row_rsparent3 = mysqli_fetch_assoc($rsparent3)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_loc3_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_loc4_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_loc4_cli" class="form-label">
                                            <?php __('Zona'); ?>:</label>
                                        <div>
                                            <select name="b_loc4_cli[]" id="b_loc4_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_loc4_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_loc4_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsparent4['id'] ?>" <?php if (in_array($row_rsparent4['id'], $vals)) {echo "SELECTED" ;} ?>>
                                                    <?php echo $row_rsparent4['name'] ?>
                                                </option>
                                                <?php } while ($row_rsparent4 = mysqli_fetch_assoc($rsparent4)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_loc4_cli"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_opciones_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_opciones_cli" class="form-label">
                                            <?php __('Opciones'); ?>:</label>
                                        <div>
                                            <select name="b_opciones_cli[]" id="b_opciones_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_opciones_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_opciones_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsOpciones['id'] ?>">
                                                    <?php echo $row_rsOpciones['name'] ?>
                                                </option>
                                                <?php } while ($row_rsOpciones = mysqli_fetch_assoc($rsOpciones)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_opciones_cli"); ?>
                                        </div>
                                    </div>
                                    <?php if($xmlExport == 1) { ?>
                                    <div class="mb-4 <?php if($tNGs->displayFieldError(" properties_client", "b_opciones2_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_opciones2_cli" class="form-label">
                                            <?php __('Características privadas'); ?>:</label>
                                        <div>
                                            <select name="b_opciones2_cli[]" id="b_opciones2_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_opciones2_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_opciones2_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsOpciones2['id'] ?>">
                                                    <?php echo $row_rsOpciones2['name'] ?>
                                                </option>
                                                <?php } while ($row_rsOpciones2 = mysqli_fetch_assoc($rsOpciones2)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_opciones2_cli"); ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "m2ut" ) !='' ) { ?>error
                                                <?php } ?>">
                                                <label for="m2ut" class="form-label">
                                                    <?php __('M2'); ?>:</label>
                                                <div>
                                                    <select name="m2ut" id="m2ut" class="select2">
                                                        <option value="0" <?php if ((isset($row_rsproperties_properties['m2ut']))&&(!(strcmp('0', $row_rsproperties_properties['m2ut'])))) {echo "SELECTED" ;} ?>>
                                                            <?php echo __('Todos') ?>
                                                        </option> 
                                                        <option value="1" <?php if ((isset($row_rsproperties_properties['m2ut']))&&(!(strcmp('1', $row_rsproperties_properties['m2ut'])))) {echo "SELECTED" ;} ?>>0-90 m<sup>2</sup></option>
                                                        <option value="2" <?php if ((isset($row_rsproperties_properties['m2ut']))&&(!(strcmp('2', $row_rsproperties_properties['m2ut'])))) {echo "SELECTED" ;} ?>>90-120 m<sup>2</sup></option>
                                                        <option value="3" <?php if ((isset($row_rsproperties_properties['m2ut']))&&(!(strcmp('3', $row_rsproperties_properties['m2ut'])))) {echo "SELECTED" ;} ?>>120-200 m<sup>2</sup></option>
                                                        <option value="4" <?php if ((isset($row_rsproperties_properties['m2ut']))&&(!(strcmp('4', $row_rsproperties_properties['m2ut'])))) {echo "SELECTED" ;} ?>>+200 m<sup>2</sup></option>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("properties_properties", "m2ut"); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "m2pl" ) !='' ) { ?>error
                                                <?php } ?>">
                                                <label for="m2pl" class="form-label">
                                                    <?php __('M2 Parcela'); ?>:</label>
                                                <div>
                                                    <select name="m2pl" id="m2pl" class="select2">
                                                        <option value="0" <?php if((isset($row_rsproperties_properties['m2pl']))&&(!(strcmp('0', $row_rsproperties_properties['m2pl'])))) {echo "SELECTED" ;} ?>>
                                                            <?php echo __('Todos') ?>
                                                        </option>
                                                        <option value="1" <?php if((isset($row_rsproperties_properties['m2pl']))&&(!(strcmp('1', $row_rsproperties_properties['m2pl'])))) {echo "SELECTED" ;} ?>>0-1.000 m<sup>2</sup></option>
                                                        <option value="2" <?php if((isset($row_rsproperties_properties['m2pl']))&&(!(strcmp('2', $row_rsproperties_properties['m2pl'])))) {echo "SELECTED" ;} ?>>1.000-2.000 m<sup>2</sup></option>
                                                        <option value="3" <?php if((isset($row_rsproperties_properties['m2pl']))&&(!(strcmp('3', $row_rsproperties_properties['m2pl'])))) {echo "SELECTED" ;} ?>>2.000-5.000 m<sup>2</sup></option>
                                                        <option value="4" <?php if((isset($row_rsproperties_properties['m2pl']))&&(!(strcmp('4', $row_rsproperties_properties['m2pl'])))) {echo "SELECTED" ;} ?>>5.000-10.000 m<sup>2</sup></option>
                                                        <option value="5" <?php if((isset($row_rsproperties_properties['m2pl']))&&(!(strcmp('5', $row_rsproperties_properties['m2pl'])))) {echo "SELECTED" ;} ?>>10.000-20.000 m<sup>2</sup></option>
                                                        <option value="6" <?php if((isset($row_rsproperties_properties['m2pl']))&&(!(strcmp('6', $row_rsproperties_properties['m2pl'])))) {echo "SELECTED" ;} ?>>+20.000 m<sup>2</sup></option>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("properties_properties", "m2pl"); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_ref_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_ref_cli" class="form-label">
                                            <?php __('Referencia'); ?>:</label>
                                        <div>
                                            <select name="b_ref_cli[]" id="b_ref_cli" multiple class="select2">
                                                <?php do {
                                                    $vals = array();
                                                    if(isset($row_rsproperties_client['b_ref_cli']))
                                                        $vals = explode(',', $row_rsproperties_client['b_ref_cli']);
                                                ?>
                                                <option value="<?php echo $row_rsReferencias['name'] ?>" <?php if (in_array($row_rsReferencias['name'], $vals)) {echo "SELECTED" ;} ?>>
                                                    <?php echo $row_rsReferencias['name'] ?>
                                                </option>
                                                <?php } while ($row_rsReferencias = mysqli_fetch_assoc($rsReferencias)); ?>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_client", "b_ref_cli"); ?>
                                        </div>
                                    </div>
                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "or" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="or" class="form-label">
                                            <?php __('Orientación'); ?>:</label>
                                        <div>
                                            <select name="or" id="or" class="select2">
                                                <option value="">
                                                    <?php echo __('Todos') ?>
                                                </option>
                                                <option value="o-n" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-n', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-n') ?>
                                                </option>
                                                <option value="o-ne" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-ne', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-ne') ?>
                                                </option>
                                                <option value="o-e" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-e', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-e') ?>
                                                </option>
                                                <option value="o-se" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-se', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-se') ?>
                                                </option>
                                                <option value="o-s" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-s', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-s') ?>
                                                </option>
                                                <option value="o-so" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-so', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-so') ?>
                                                </option>
                                                <option value="o-o" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-o', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-o') ?>
                                                </option>
                                                <option value="o-no" <?php if ((isset($row_rsproperties_properties['or']))&&(!(strcmp('o-no', $row_rsproperties_properties['or'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('o-no') ?>
                                                </option>
                                            </select>
                                            <?php echo $tNGs->displayFieldError("properties_properties", "or"); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "piscina_prop" ) !='' ) { ?>has-error
                                                <?php } ?>">
                                                <label for="piscina_prop" class="form-label">
                                                    <?php __('Piscina'); ?>:</label>
                                                <select name="piscina_prop" id="piscina_prop" class="select2">
                                                    <option value="" <?php if ((isset($row_rsproperties_properties['piscina_prop']))&&(!(strcmp("", $row_rsproperties_properties['piscina_prop'])))) {echo "selected=\" selected\"";} ?>>
                                                        <?php echo __('Todos') ?>
                                                    </option>
                                                    <?php
                                                            do {
                                                            ?>
                                                    <option value="<?php echo $row_rsPool['id_pl']?>" <?php if ((isset($row_rsproperties_properties['piscina_prop']))&&(!(strcmp($row_rsPool['id_pl'], $row_rsproperties_properties['piscina_prop'])))) {echo "selected=\" selected\"";} ?>>
                                                        <?php echo $row_rsPool['pool']?>
                                                    </option>
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
                                        <!--/.col-md-6 -->
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_properties", "parking_prop" ) !='' ) { ?>has-error
                                                <?php } ?>">
                                                <label for="parking_prop" class="form-label">
                                                    <?php __('Parking'); ?>:</label>
                                                <select name="parking_prop" id="parking_prop" class="select2">
                                                    <option value="" <?php if ((isset($row_rsproperties_properties['parking_prop']))&&(!(strcmp("", $row_rsproperties_properties['parking_prop'])))) {echo "selected=\" selected\"";} ?>>
                                                        <?php echo __('Todos') ?>
                                                    </option>
                                                    <?php
                                                            do {
                                                            ?>
                                                    <option value="<?php echo $row_rsParking['id_prk']?>" <?php if ((isset($row_rsproperties_properties['parking_prop']))&&(!(strcmp($row_rsParking['id_prk'], $row_rsproperties_properties['parking_prop'])))) {echo "selected=\" selected\"";} ?>>
                                                        <?php echo $row_rsParking['parking']?>
                                                    </option>
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
                                            <!-- <div class="checkbox">
                                                        <label>
                                                        <input  <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['ascensor_prop']),"1"))) {echo "checked";} ?> type="checkbox" name="ascensor_prop" id="ascensor_prop" value="1" class="onoffbtn" />
                                                        <?php __('Ascensor'); ?>
                                                        <?php echo $tNGs->displayFieldError("properties_properties", "ascensor_prop"); ?>
                                                    </div> -->
                                        </div>
                                        <!--/.col-md-6 -->
                                    </div>
                                    <!--/.row -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_precio_desde_cli" ) !='' ) { ?>error
                                                <?php } ?>">
                                                <label for="b_precio_desde_cli" class="form-label">
                                                    <?php __('Precio desde'); ?>:</label>
                                                <div>
                                                    <input type="text" name="b_precio_desde_cli" id="b_precio_desde_cli" value="<?php if(isset($row_rsproperties_client['b_precio_desde_cli'])){ echo KT_escapeAttribute($row_rsproperties_client['b_precio_desde_cli']); } ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_precio_desde_cli"); ?>
                                                </div>
                                            </div>

                                            <div class="text-muted mt-n4 mb-1"><?php __('Sin puntos ni comas ni símbolos €') ?></div>

                                            <div class="mb-4">
                                                <label for="nw" class="form-label">
                                                    <?php __('Nuevo'); ?>:</label>
                                                <div>
                                                    <select name="nw" id="nw" class="select2">
                                                        <option value="">
                                                            <?php echo $lang['Todos']; ?>
                                                        </option>
                                                        <option value="0">
                                                            <?php echo $lang['No']; ?>
                                                        </option>
                                                        <option value="1">
                                                            <?php echo $lang['Sí']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="res" class="form-label">
                                                    <?php __('Reservado'); ?>:</label>
                                                <div>
                                                    <select name="res" id="res" class="select2">
                                                        <option value="">
                                                            <?php echo $lang['Todos']; ?>
                                                        </option>
                                                        <option value="0">
                                                            <?php echo $lang['No']; ?>
                                                        </option>
                                                        <option value="1">
                                                            <?php echo $lang['Sí']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="b_precio_hasta_cli" class="form-label">
                                                    <?php __('Precio hasta'); ?>:</label>
                                                <div>
                                                    <input type="text" name="b_precio_hasta_cli" id="b_precio_hasta_cli" value="<?php if(isset(($row_rsproperties_client['b_precio_hasta_cli']))){echo KT_escapeAttribute($row_rsproperties_client['b_precio_hasta_cli']);} ?>" size="32" maxlength="255" class="form-control">
                                                    <?php echo $tNGs->displayFieldError("properties_client", "b_precio_hasta_cli"); ?>
                                                </div>
                                            </div>
                                            <!-- <p class="help-block">&nbsp;</p> -->
                                            <div class="mb-4">
                                                <label for="ven" class="form-label">
                                                    <?php __('Vendido'); ?>:</label>
                                                <div>
                                                    <select name="ven" id="ven" class="select2">
                                                        <option value="">
                                                            <?php echo $lang['Todos']; ?>
                                                        </option>
                                                        <option value="0">
                                                            <?php echo $lang['No']; ?>
                                                        </option>
                                                        <option value="1">
                                                            <?php echo $lang['Sí']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="alq" class="form-label">
                                                    <?php __('Alquilado'); ?>:</label>
                                                <div>
                                                    <select name="alq" id="alq" class="select2">
                                                        <option value="">
                                                            <?php echo $lang['Todos']; ?>
                                                        </option>
                                                        <option value="0">
                                                            <?php echo $lang['No']; ?>
                                                        </option>
                                                        <option value="1">
                                                            <?php echo $lang['Sí']; ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="atendido_por_prop" class="form-label"><?php __('Agente'); ?>:</label>
                                        <div class="controls">

                                            <select name="atendido_por_prop" id="atendido_por_prop" class="select2">
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php do { ?>
                                                <option value="<?php if(isset($row_rsTeam)) echo $row_rsTeam['id_tms']?>"><?php if(isset($row_rsTeam)) echo $row_rsTeam['nombre_tms']?></option>
                                                <?php } while ($row_rsTeam = mysqli_fetch_assoc($rsTeam));
                                                  $rows = mysqli_num_rows($rsTeam);
                                                  if($rows > 0) {
                                                      mysqli_data_seek($rsTeam, 0);
                                                    $row_rsTeam = mysqli_fetch_assoc($rsTeam);
                                                  } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <legend style="font-size: 16px; font-weight: bold;">
                                        <?php __('Distancia a la playa'); ?>:</legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="distance_beach_med_prop" class="form-label">&nbsp;</label>
                                            <select name="distance_beach_med_prop" id="distance_beach_med_prop" class="form-select">
                                                <option value="Km" SELECTED>
                                                    <?php echo __('Km') ?>
                                                </option>
                                                <option value="Mts" <?php if ((isset($row_rsproperties_client['distance_beach_med_prop']))&&(!(strcmp('Mts', $row_rsproperties_client['distance_beach_med_prop'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mts') ?>
                                                </option>
                                                <option value="Mins" <?php if ((isset($row_rsproperties_client['distance_beach_med_prop']))&&(!(strcmp('Mins', $row_rsproperties_client['distance_beach_med_prop'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mins') ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_beach_prop_from" class="form-label">
                                                <?php __('Desde'); ?>:</label>
                                            <input type="text" name="distance_beach_prop_from" id="distance_beach_prop_from" value="<?php if(isset($row_rsproperties_client['distance_beach_prop_from'])) {echo KT_escapeAttribute($row_rsproperties_client['distance_beach_prop_from']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_beach_prop_to" class="form-label">
                                                <?php __('Hasta'); ?>:</label> 
                                            <input type="text" name="distance_beach_prop_to" id="distance_beach_prop_to" value="<?php if(isset($row_rsproperties_client['distance_beach_prop_from'])) {echo KT_escapeAttribute($row_rsproperties_client['distance_beach_prop_to']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <legend style="font-size: 16px; font-weight: bold;">
                                        <?php __('Distancia a entretenimientos'); ?>:</legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="distance_amenities_med_prop" class="form-label">&nbsp;</label>
                                            <select name="distance_amenities_med_prop" id="distance_amenities_med_prop" class="form-select">
                                                <option value="Km" SELECTED>
                                                    <?php echo __('Km') ?>
                                                </option>
                                                <option value="Mts" <?php if ((isset($row_rsproperties_client['distance_amenities_med_prop']))&&(!(strcmp('Mts', $row_rsproperties_client['distance_amenities_med_prop'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mts') ?>
                                                </option>
                                                <option value="Mins" <?php if ((isset($row_rsproperties_client['distance_amenities_med_prop']))&&(!(strcmp('Mins', $row_rsproperties_client['distance_amenities_med_prop'])))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mins') ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_amenities_prop_from" class="form-label">
                                                <?php __('Desde'); ?>:</label>
                                            <input type="text" name="distance_amenities_prop_from" id="distance_amenities_prop_from" value="<?php if(isset($row_rsproperties_client['distance_amenities_prop_from'])){ echo KT_escapeAttribute($row_rsproperties_client['distance_amenities_prop_from']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_amenities_prop_to" class="form-label">
                                                <?php __('Hasta'); ?>:</label>
                                            <input type="text" name="distance_amenities_prop_to" id="distance_amenities_prop_to" value="<?php if(isset($row_rsproperties_client['distance_amenities_prop_to'])) {echo KT_escapeAttribute($row_rsproperties_client['distance_amenities_prop_to']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "direccion" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="direccion" class="form-label">
                                            <?php __('Dirección'); ?>:</label>
                                        <div>
                                            <input type="text" name="direccion" id="direccion" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "b_tags_cli" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="b_tags_cli" class="form-label">
                                            <?php __('Etiquetas'); ?>:</label>
                                        <select name="b_tags_cli[]" id="b_tags_cli" multiple class="select2">
                                            <?php do {
                                                $vals = array();
                                                if(isset($row_rsproperties_client['b_tags_cli']))
                                                    $vals = explode(',', $row_rsproperties_client['b_tags_cli']);
                                            ?>
                                            <option value="<?php echo $row_rsTags['id'] ?>">
                                                <?php echo $row_rsTags['name'] ?>
                                            </option>
                                            <?php } while ($row_rsTags = mysqli_fetch_assoc($rsTags)); ?>
                                        </select>
                                        <?php echo $tNGs->displayFieldError("properties_client", "b_tags_cli"); ?>
                                    </div>
                                    <div class="mb-4 <?php if($tNGs->displayFieldError("properties_client", "palabras_clave" ) !='' ) { ?>error
                                        <?php } ?>">
                                        <label for="palabras_clave" class="form-label">
                                            <?php __('Palabras clave'); ?>:</label>
                                        <div>
                                            <input type="text" name="palabras_clave" id="palabras_clave" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="captado_prop" class="form-label"><?php __('Captado por prop'); ?>:</label>
                                        <div class="controls">
                                            <select name="captado_prop" id="captado_prop" class="select2">
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php do { ?>
                                                <option value="<?php echo $row_rsusuarios['id_usr']?>"><?php echo $row_rsusuarios['nombre_usr']?></option>
                                                <?php } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                                  $rows = mysqli_num_rows($rsusuarios);
                                                  if($rows > 0) {
                                                      mysqli_data_seek($rsusuarios, 0);
                                                    $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                                  } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <legend style="font-size: 16px; font-weight: bold; padding-top: 3px; display: inline-block;">
                                        <?php __('Distancia al aereopuerto'); ?>:</legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="distance_airport_med_prop" class="form-label">&nbsp;</label>
                                            <select name="distance_airport_med_prop" id="distance_airport_med_prop" class="form-select">
                                                <option value="Km" SELECTED>
                                                    <?php echo __('Km') ?>
                                                </option>
                                                <option value="Mts" <?php if (isset($row_rsproperties_client['distance_airport_med_prop']) && !(strcmp('Mts', $row_rsproperties_client['distance_airport_med_prop']))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mts') ?>
                                                </option>
                                                <option value="Mins" <?php if (isset($row_rsproperties_client['distance_airport_med_prop']) && !(strcmp('Mins', $row_rsproperties_client['distance_airport_med_prop']))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mins') ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_airport_prop_from" class="form-label">
                                                <?php __('Desde'); ?>:</label>
                                            <input type="text" name="distance_airport_prop_from" id="distance_airport_prop_from" value="<?php if(isset($row_rsproperties_client['distance_airport_prop_from'])){echo KT_escapeAttribute($row_rsproperties_client['distance_airport_prop_from']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_airport_prop_to" class="form-label">
                                                <?php __('Hasta'); ?>:</label>
                                            <input type="text" name="distance_airport_prop_to" id="distance_airport_prop_to" value="<?php if(isset($row_rsproperties_client['distance_airport_prop_to'])){echo KT_escapeAttribute($row_rsproperties_client['distance_airport_prop_to']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <legend style="font-size: 16px; font-weight: bold;">
                                        <?php __('Distancia al campo de golf'); ?>
                                    </legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="distance_golf_med_prop" class="form-label">&nbsp;</label>
                                            <select name="distance_golf_med_prop" id="distance_golf_med_prop" class="form-select">
                                                <option value="Km" SELECTED>
                                                    <?php echo __('Km') ?>
                                                </option>
                                                <option value="Mts" <?php if (isset($row_rsproperties_client['distance_golf_med_prop']) && !(strcmp('Mts', $row_rsproperties_client['distance_golf_med_prop']))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mts') ?>
                                                </option>
                                                <option value="Mins" <?php if (isset($row_rsproperties_client['distance_golf_med_prop']) && !(strcmp('Mins', $row_rsproperties_client['distance_golf_med_prop']))) {echo "SELECTED" ;} ?>>
                                                    <?php echo __('Mins') ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_golf_prop_from" class="form-label">
                                                <?php __('Desde'); ?>:</label>
                                            <input type="text" name="distance_golf_prop_from" id="distance_golf_prop_from" value="<?php if(isset($row_rsproperties_client['distance_golf_prop_from'])){echo KT_escapeAttribute($row_rsproperties_client['distance_golf_prop_from']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="distance_golf_prop_to" class="form-label">
                                                <?php __('Hasta'); ?>:</label>
                                            <input type="text" name="distance_golf_prop_to" id="distance_golf_prop_to" value="<?php if(isset($row_rsproperties_client['distance_golf_prop_to'])){echo KT_escapeAttribute($row_rsproperties_client['distance_golf_prop_to']);} ?>" size="32" maxlength="255" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="query"></div>

                    <hr>

                    <table class="table table-striped table-bordered align-middle" id="records-tables">
                      <thead class="table-light">
                        <tr>
                          <th style="width: 20px">&nbsp;</th>
                          <th><?php __('Imágen'); ?></th>
                          <th><?php __('Referencia'); ?></th>
                          <th><?php __('Operación'); ?></th>
                          <th><?php __('Tipo'); ?></th>
                          <th><?php __('Ciudad'); ?></th>
                          <th><?php __('Zona'); ?></th>
                          <th><?php __('Precio'); ?></th>
                          <th><?php __('Activado'); ?></th>
                          <th id="actionsOrder" style="min-width: 150px !important;">
                              <div class="row">
                                  <div class="col-6" id="col-1">
                                  </div>
                                  <div class="col-6" id="col-2">
                                  </div>
                              </div>
                          </th>
                        </tr>
                        <tr class="search-inputs">
                            <td style="widtd: 20px">&nbsp;</td>
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
                            <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="10" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                        </tr>
                      </tbody>
                    </table>

                    <div style="display: none" id="sendcont">

                        <hr>

                        <div class="mb-4">
                          <label for="email_cli" class="form-label"><?php __('Email'); ?>:</label>
                          <div>
                              <input type="text" name="email_cli" id="email_cli" value="" size="32" maxlength="255" class="form-control">
                              <?php echo $tNGs->displayFieldError("properties_client", "email_cli"); ?>
                          </div>
                        </div>

                        <div class="mb-4">
                          <label for="email_cli" class="form-label"><?php __('Comentario'); ?>:</label>
                          <div>
                          <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
                          </div>
                        </div>

                        <div style="position: relative;">
                              <a href="#" class="btn btn-primary btnsend"><?php echo $lang['Enviar'] ?> <span class="countusers">0</span> <span class="countusers2"><?php echo $lang['Inmueble']  ?></span><span class="countusers3"><?php echo $lang['Inmuebles']  ?></span></a>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var langs = ['<?php echo implode("','", $languages); ?>'];
    var oTable;
    var selected =  new Array();
    var host = '<?php echo $_SERVER['HTTP_HOST'] ?>';

    // CONFIGURACIÓN DE LAS COLUMNAS:
    var numCols = 9;
    var ocultarCols = []; // COLUMNAS OCULTAS POR DEFECTO
    // DEFINIMOS LAS COLUMNAS EXTRA
    var extraColDef = [];
    </script>

    <script src="_js/properties-search.js?id=<?php echo time(); ?>" type="text/javascript" charset="utf-8" async defer></script>

    <script>
    $(document).on('click', '.btn-img-list-carr', function(e) {
        e.preventDefault();
        $elm = $(this);

        $('#myModalImg .modal-body').html('');


        $('#myModalImg').modal('show');
        $('#myModalImg .modal-header h5').html('<i class="fa-regular fa-images me-1"></i> ' + $elm.data('title'));


        $.get('/intramedianet/properties/get-imgs.php?p='+ $elm.data('id')).done(function(data) {
            if (data != '') {
                $('#myModalImg .modal-body').html(data);
            }
        });
    });
    </script>

    <div id="myModalImg" class="modal fade" tabindex="-1" aria-labelledby="myModalImgLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel2"></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                </div>
                <div class="modal-footer bg-soft-primary">
                    <button type="button" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
