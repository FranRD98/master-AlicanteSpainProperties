<?php
ini_set('display_errors', 1);
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
$restrict->Execute();
//End Restrict Access To Page

if (!isset($_GET['id_col'])) {

  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'properties_collaborators'";
  $rsNextIncrement = mysqli_query($inmoconn,$query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

  $clientId = $row_rsNextIncrement['Auto_increment'];

} else {

  $clientId = $_GET['id_col'];

}

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


$query_rsTipos = "SELECT types_".$lang_adm."_typ, id_typ FROM properties_types ORDER BY types_".$lang_adm."_typ";
$rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsSales = "SELECT * FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsSales = mysqli_query($inmoconn,$query_rsSales) or die(mysqli_error());
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);


$query_rsCategories = "SELECT * FROM properties_collaborators_categories ORDER BY category_".$lang_adm."_cat ASC";
$rsCategories = mysqli_query($inmoconn,$query_rsCategories) or die(mysqli_error());
$row_rsCategories = mysqli_fetch_assoc($rsCategories);
$totalRows_rsCategories = mysqli_num_rows($rsCategories);


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
SELECT properties_loc2.id_loc2 AS id,
  properties_loc2.name_".$lang_adm."_loc2 AS `name`
FROM properties_properties INNER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
INNER JOIN properties_loc3 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3
INNER JOIN properties_loc2 ON properties_loc3.loc2_loc3 = properties_loc2.id_loc2
GROUP BY properties_loc2.id_loc2
ORDER BY `name` ASC
";
$rsparent2 = mysqli_query($inmoconn,$query_rsparent2) or die(mysqli_error() . '<hr>' . $query_rsparent2);
$row_rsparent2 = mysqli_fetch_assoc($rsparent2);
$totalRows_rsparent2 = mysqli_num_rows($rsparent2);


$query_rsparent3 = "
SELECT properties_loc3.id_loc3 AS id,
  properties_loc3.name_".$lang_adm."_loc3 AS `name`
FROM properties_properties INNER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
INNER JOIN properties_loc3 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3
GROUP BY properties_loc3.id_loc3
ORDER BY `name` ASC
";
$rsparent3 = mysqli_query($inmoconn,$query_rsparent3) or die(mysqli_error());
$row_rsparent3 = mysqli_fetch_assoc($rsparent3);
$totalRows_rsparent3 = mysqli_num_rows($rsparent3);


$query_rsparent4 = "
SELECT properties_loc4.id_loc4 AS id,
  CONCAT( properties_loc3.name_" .$lang_adm. "_loc3, ' &raquo;', properties_loc4.name_".$lang_adm."_loc4) AS `name`
FROM properties_properties INNER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
INNER JOIN properties_loc3 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3
GROUP BY properties_loc4.id_loc4
ORDER BY `name` ASC
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


$query_rsConsultasProp = "
SELECT properties_enquiries.id_cons,
  (SELECT referencia_prop FROM properties_properties WHERE id_prop = inmueble_cons) AS inmueble_cons,
  properties_enquiries.comentario_consas,
  properties_enquiries.fecha_cons,
  properties_enquiries.read_cons,
  properties_enquiries.client_cons
FROM properties_enquiries
WHERE properties_enquiries.client_cons = '".$_GET['id_col']."' AND properties_enquiries.client_cons != ''
ORDER BY properties_enquiries.fecha_cons DESC
";
$rsConsultasProp = mysqli_query($inmoconn,$query_rsConsultasProp) or die(mysqli_error());
$row_rsConsultasProp = mysqli_fetch_assoc($rsConsultasProp);
$totalRows_rsConsultasProp = mysqli_num_rows($rsConsultasProp);


$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct FROM citas_categories ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn,$query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);


$query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsusuarios = mysqli_query($inmoconn,$query_rsusuarios) or die(mysqli_error());
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);


$query_rsclientes = "SELECT nombre_comercial_col, persona_contacto_col, id_col FROM properties_collaborators ORDER BY nombre_comercial_col, persona_contacto_col";
$rsclientes = mysqli_query($inmoconn,$query_rsclientes) or die(mysqli_error());
$row_rsclientes = mysqli_fetch_assoc($rsclientes);
$totalRows_rsclientes = mysqli_num_rows($rsclientes);


$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

function addRefs($ids) {

  global $database_inmoconn, $inmoconn;

  if ($ids == '') {
    return '';
  }

  
  $query_rsRefs = "SELECT referencia_prop, id_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
  $rsRefs = mysqli_query($inmoconn,$query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
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
$formValidation->addField("nombre_comercial_col", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect(&$tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("collaborators-form.php?id_col=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_collaborators_files");
  $tblDelObj->setFieldName("client_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/clients/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  global $lang;
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("properties_collaborators");
  $tblFldObj->addFieldName("email_col");
  $tblFldObj->setErrorMsg($lang['Registro duplicado'] . ": {email_col}");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger



  require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );

//start Trigger_AddToNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_AddToNewsletter(&$tNG) {

  global $database_inmoconn, $inmoconn, $lang_adm, $_POST, $keyMailchimp;

  $lista = 'cdebec7490';

  if ($_POST['email_col'] != '') {

        $MailChimp = new MailChimp($keyMailchimp);
        $result = $MailChimp->call('lists/subscribe', array(
                  'id'                => $lista,
                  'email'             => array('email'=>$_POST['email_col']),
                  'merge_vars'        => array('FNAME'=>$_POST['nombre_comercial_col'], 'LNAME'=>$_POST['persona_contacto_col']),
                  'double_optin'      => false,
                  'update_existing'   => true,
                  'replace_interests' => false,
                  'send_welcome'      => false,
              ));

  }

}
//end Trigger_AddToNewsletter trigger

// Make an insert transaction instance
$ins_properties_collaborators = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_collaborators);
// Register triggers
$ins_properties_collaborators->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_collaborators->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_properties_collaborators->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_collaborators->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_properties_collaborators->registerConditionalTrigger("{POST.KT_Insert2} != \"\"", "AFTER", "Trigger_Redirect", 90);
$ins_properties_collaborators->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// $ins_properties_collaborators->registerTrigger("AFTER", "Trigger_AddToNewsletter", 10);
// Add columns
$ins_properties_collaborators->setTable("properties_collaborators");
$ins_properties_collaborators->addColumn("nombre_comercial_col", "STRING_TYPE", "POST", "nombre_comercial_col");
$ins_properties_collaborators->addColumn("persona_contacto_col", "STRING_TYPE", "POST", "persona_contacto_col");
$ins_properties_collaborators->addColumn("category_col", "STRING_TYPE", "POST", "category_col");
$ins_properties_collaborators->addColumn("telefono_fijo_col", "STRING_TYPE", "POST", "telefono_fijo_col");
$ins_properties_collaborators->addColumn("email_col", "STRING_TYPE", "POST", "email_col");
$ins_properties_collaborators->addColumn("telefono_contacto_col", "STRING_TYPE", "POST", "telefono_contacto_col");
$ins_properties_collaborators->addColumn("email_contacto_col", "STRING_TYPE", "POST", "email_contacto_col");
$ins_properties_collaborators->addColumn("direccion_col", "STRING_TYPE", "POST", "direccion_col");
$ins_properties_collaborators->addColumn("web_col", "STRING_TYPE", "POST", "web_col");
$ins_properties_collaborators->addColumn("notas_col", "STRING_TYPE", "POST", "notas_col");
$ins_properties_collaborators->setPrimaryKey("id_col", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_collaborators = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_collaborators);
// Register triggers
$upd_properties_collaborators->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_collaborators->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_properties_collaborators->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_collaborators->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_properties_collaborators->registerConditionalTrigger("{POST.KT_Update2} != \"\"", "END", "Trigger_Redirect", 90);
// $upd_properties_collaborators->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$upd_properties_collaborators->setTable("properties_collaborators");
$upd_properties_collaborators->addColumn("nombre_comercial_col", "STRING_TYPE", "POST", "nombre_comercial_col");
$upd_properties_collaborators->addColumn("persona_contacto_col", "STRING_TYPE", "POST", "persona_contacto_col");
$upd_properties_collaborators->addColumn("category_col", "STRING_TYPE", "POST", "category_col");
$upd_properties_collaborators->addColumn("telefono_fijo_col", "STRING_TYPE", "POST", "telefono_fijo_col");
$upd_properties_collaborators->addColumn("email_col", "STRING_TYPE", "POST", "email_col");
$upd_properties_collaborators->addColumn("telefono_contacto_col", "STRING_TYPE", "POST", "telefono_contacto_col");
$upd_properties_collaborators->addColumn("email_contacto_col", "STRING_TYPE", "POST", "email_contacto_col");
$upd_properties_collaborators->addColumn("direccion_col", "STRING_TYPE", "POST", "direccion_col");
$upd_properties_collaborators->addColumn("web_col", "STRING_TYPE", "POST", "web_col");
$upd_properties_collaborators->addColumn("notas_col", "STRING_TYPE", "POST", "notas_col");
$upd_properties_collaborators->setPrimaryKey("id_col", "NUMERIC_TYPE", "GET", "id_col");

// Make an instance of the transaction object
$del_properties_collaborators = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_collaborators);
// Register triggers
$del_properties_collaborators->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_collaborators->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_collaborators->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// $del_properties_collaborators->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
// Add columns
$del_properties_collaborators->setTable("properties_collaborators");
$del_properties_collaborators->setPrimaryKey("id_col", "NUMERIC_TYPE", "GET", "id_col");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_collaborators = $tNGs->getRecordset("properties_collaborators");
$row_rsproperties_collaborators = mysqli_fetch_assoc($rsproperties_collaborators);
$totalRows_rsproperties_collaborators = mysqli_num_rows($rsproperties_collaborators);


$query_rsEmails = "
SELECT
properties_log_mails.id_log,
properties_properties.id_prop,
properties_properties.referencia_prop,
properties_log_mails.type_log,
properties_log_mails.date_log
FROM properties_log_mails
INNER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
WHERE email_log = '".$row_rsproperties_collaborators['email_col']."'
ORDER BY date_log DESC
";
$rsEmails = mysqli_query($inmoconn,$query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);


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
  properties_collaborators.nombre_comercial_col,
  properties_collaborators.persona_contacto_col
FROM citas LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
   LEFT OUTER JOIN users ON citas.user_ct = users.id_usr
   LEFT OUTER JOIN properties_collaborators ON citas.users_ct = properties_collaborators.id_col
WHERE users_ct = '".$_GET['id_col']."'
 ORDER BY inicio_ct DESC
";
$rsEvents = mysqli_query($inmoconn,$query_rsEvents) or die(mysqli_error());
$row_rsEvents = mysqli_fetch_assoc($rsEvents);
$totalRows_rsEvents = mysqli_num_rows($rsEvents);

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-id-card"></i> <?php if (@$_GET['id_col'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Contacto'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_col'] == "") { ?>
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
                                    <div class="col-lg-12">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("properties_collaborators", "category_col") != '') { ?>has-error<?php } ?>">
                                            <label for="category_col" class="form-label"><?php __('Categoría'); ?>:</label>
                                            <select name="category_col" id="category_col" class="form-select required" required>
                                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                <?php do { ?>
                                                <option value="<?php echo $row_rsCategories ['id_cat']?>"<?php if (!(strcmp($row_rsCategories ['id_cat'], $row_rsproperties_collaborators['category_col']))) {echo "SELECTED";} ?>><?php echo $row_rsCategories ['category_'.$lang_adm.'_cat']?></option>
                                                <?php } while ($row_rsCategories  = mysqli_fetch_assoc($rsCategories ));
                                                  $rows = mysqli_num_rows($rsCategories );
                                                  if($rows > 0) {
                                                      mysqli_data_seek($rsCategories , 0);
                                                    $row_rsCategories  = mysqli_fetch_assoc($rsCategories );
                                                  } ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "category_col"); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "nombre_comercial_col") != '') { ?>has-error<?php } ?>">
                                            <label for="nombre_comercial_col" class="form-label"><?php __('Nombre comercial'); ?></label>
                                            <input type="text" name="nombre_comercial_col" id="nombre_comercial_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['nombre_comercial_col']); ?>" size="32" maxlength="255" class="form-control required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "nombre_comercial_col"); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "telefono_fijo_col") != '') { ?>has-error<?php } ?>">
                                            <label for="telefono_fijo_col" class="form-label"><?php __('Teléfono principal'); ?></label>
                                            <input type="tel" name="telefono_fijo_col" id="telefono_fijo_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['telefono_fijo_col']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "telefono_fijo_col"); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "email_col") != '') { ?>has-error<?php } ?>">
                                            <label for="email_col" class="form-label"><?php __('Email principal'); ?></label>
                                            <input type="email" name="email_col" id="email_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['email_col']); ?>" size="32" maxlength="255" class="form-control">
                                            <div class="invalid-feedback">
                                                <?php __('Por favor, escribe una dirección de correo válida.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "email_col"); ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "persona_contacto_col") != '') { ?>has-error<?php } ?>">
                                            <label for="persona_contacto_col" class="form-label"><?php __('Persona de contacto'); ?></label>
                                            <input type="text" name="persona_contacto_col" id="persona_contacto_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['persona_contacto_col']); ?>" size="32" maxlength="255" class="form-control required">
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "persona_contacto_col"); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "telefono_contacto_col") != '') { ?>has-error<?php } ?>">
                                            <label for="telefono_contacto_col" class="form-label"><?php __('Teléfono contacto'); ?></label>
                                            <input type="tel" name="telefono_contacto_col" id="telefono_contacto_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['telefono_contacto_col']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "telefono_contacto_col"); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "email_contacto_col") != '') { ?>has-error<?php } ?>">
                                            <label for="email_contacto_col" class="form-label"><?php __('Email contacto'); ?></label>
                                            <input type="email" name="email_contacto_col" id="email_contacto_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['email_contacto_col']); ?>" size="32" maxlength="255" class="form-control">
                                            <div class="invalid-feedback">
                                                <?php __('Por favor, escribe una dirección de correo válida.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "email_contacto_col"); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "direccion_col") != '') { ?>has-error<?php } ?>">
                                            <label for="direccion_col" class="form-label"><?php __('Dirección'); ?></label>
                                            <input type="text" name="direccion_col" id="direccion_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['direccion_col']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "direccion_col"); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <div class="mb-3 <?php if($tNGs->displayFieldError("properties_collaborators", "web_col") != '') { ?>has-error<?php } ?>">
                                          <label for="web_col" class="form-label"><?php __('Website'); ?></label>
                                          <input type="text" name="web_col" id="web_col" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['web_col']); ?>" size="32" maxlength="255" class="form-control url" placeholder="https://">
                                          <?php echo $tNGs->displayFieldError("properties_collaborators", "web_col"); ?>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_collaborators", "notas_col") != '') { ?>has-error<?php } ?>">
                                            <label for="notas_col" class="form-label"><?php __('Notas'); ?>:</label>
                                            <textarea type="text" name="notas_col" id="notas_col" cols="50" rows="20" class="form-control"><?php echo KT_escapeAttribute($row_rsproperties_collaborators['notas_col']); ?></textarea>
                                            <?php echo $tNGs->displayFieldError("properties_collaborators", "notas_col"); ?>
                                            <a href="#" class="btn btn-success addNot btn-sm float-end me-2" style="border-radius: 0 0 5px 5px;"><i class="fa-regular fa-calendar-plus"></i> <?php __('Añadir fecha'); ?></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="kt_pk_properties_collaborators" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproperties_collaborators['kt_pk_properties_collaborators']); ?>" />

    </form>

    <?php include("../includes/inc.footer.php"); ?>
    <script>
    var userId = '<?php echo $_SESSION['kt_login_id']; ?>';
    var idClient = '<?php echo $clientId; ?>';
    var oTable;
    var selected =  new Array();
    </script>

    <script src="_js/collaborators-form.js" type="text/javascript"></script>



</body>
</html>
