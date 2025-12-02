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

    $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string(NULL,$theValue) : mysqli_escape_string($theValue);

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


$query_rsOpciones = "SELECT id_feat as id, feature_".$lang_adm."_feat as name FROM properties_features ORDER BY name ASC";
$rsOpciones = mysqli_query($inmoconn,$query_rsOpciones) or die(mysqli_error());
$row_rsOpciones = mysqli_fetch_assoc($rsOpciones);
$totalRows_rsOpciones = mysqli_num_rows($rsOpciones);

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
if (isset($_POST['b_opciones_cli']) && $_POST['b_opciones_cli'] != '' ) {
  $_POST['b_opciones_cli'] = implode(',', $_POST['b_opciones_cli']);
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
$ins_properties_client->addColumn("fecha_alta_cli", "DATE_TYPE", "POST", "fecha_alta_cli", "{NOW}");
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
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <title><?php echo KT_escapeAttribute($row_rsproperties_client['nombre_cli']); ?> <?php echo KT_escapeAttribute($row_rsproperties_client['apellidos_cli']); ?></title>
  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

<div class="container">

      <hr>

      <div class="row-fluid">

        <div class="span12">

          <h2><?php __('Datos del clientes'); ?></h2>

        </div>

      </div>

      <div class="row-fluid">

        <div class="span6">

          <ul class="unstyled">
            <li><b><?php __('Nombre'); ?>:</b> <?php echo KT_escapeAttribute($row_rsproperties_client['nombre_cli']); ?></li>
            <li><b><?php __('Apellidos'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['apellidos_cli']); ?></li>
            <li><b><?php __('Teléfono'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['telefono_fijo_cli']); ?></li>
            <li><b><?php __('Móvil'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['telefono_movil_cli']); ?></li>
            <li><b><?php __('Dirección'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['direccion_cli']); ?></li>
            <li><b><?php __('Estatus'); ?></b>: <?php

            
            $query_rsXX = "SELECT category_".$lang_adm."_sts as cat  FROM properties_client_states WHERE id_sts = '".$row_rsproperties_client['status_cli']."'";
            $rsXX = mysqli_query($inmoconn,$query_rsXX) or die(mysqli_error());
            $row_rsXX = mysqli_fetch_assoc($rsXX);
            $totalRows_rsXX = mysqli_num_rows($rsXX);


            echo KT_escapeAttribute($row_rsXX['cat']);
             ?></li>
          </ul>

        </div>

        <div class="span6">

           <ul class="unstyled">
            <li><b><?php __('Añadido'); ?></b>: <?php echo KT_formatDate($row_rsproperties_client['fecha_alta_cli']); ?></li>
            <li><b><?php __('Email'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['email_cli']); ?></li>
            <li><b><?php __('Skype'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['skype_cli']); ?></li>
            <li><b><?php __('Cómo nos conoció'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['como_nos_conocio_cli']); ?></li>
            <li><b><?php __('Captado por'); ?></b>: <?php echo KT_escapeAttribute($row_rsproperties_client['captado_por_cli']); ?></li>
          </ul>

        </div>

      </div>

      <hr>

      <div class="row-fluid">

        <div class="span12">

        <h2><?php __('Historial'); ?></h2>

        <p><?php echo nl2br($row_rsproperties_client['historial_cli']); ?></p>

        </div>

      </div>

      <hr>

      <div class="row-fluid">

        <div class="span12">

          <h2><?php __('Interesado en'); ?>:</h2>

        </div>

      </div>

      <div class="row-fluid">

        <div class="span6">

        <ul class="unstyled">
          <li><b><?php __('Operación'); ?></b> <?php
            do {
              $vals = explode(',', $row_rsproperties_client['b_sale_cli']);
            ?>
            <?php if (in_array($row_rsSales['id_sta'], $vals)) { ?>
             - <?php echo $row_rsSales['status_'.$lang_adm.'_sta']?>
            <?php } ?>
            <?php
            } while ($row_rsSales = mysqli_fetch_assoc($rsSales ));
              $rows = mysqli_num_rows($rsSales );
              if($rows > 0) {
                  mysqli_data_seek($rsSales , 0);
                $row_rsSales = mysqli_fetch_assoc($rsSales );
              }
            ?></li>
          <li><b><?php __('Tipo'); ?></b> <?php
            do {
              $vals = explode(',', $row_rsproperties_client['b_type_cli']);
            ?>
            <?php if (in_array($row_rsTipos['id_typ'], $vals)) { ?>
            - <?php echo $row_rsTipos['types_'.$lang_adm.'_typ']?>
            <?php } ?>
            <?php
            } while ($row_rsTipos = mysqli_fetch_assoc($rsTipos));
              $rows = mysqli_num_rows($rsTipos);
              if($rows > 0) {
                  mysqli_data_seek($rsTipos, 0);
                $row_rsTipos = mysqli_fetch_assoc($rsTipos);
              }
            ?></li>
          <li><b><?php __('País'); ?></b> <?php do {
              $vals = explode(',', $row_rsproperties_client['b_loc1_cli']);
            ?>
            <?php if (in_array($row_rsparent1['id'], $vals)) { ?>
            - <?php echo $row_rsparent1['name'] ?>
            <?php } ?>
            <?php } while ($row_rsparent1 = mysqli_fetch_assoc($rsparent1)); ?></li>
          <li><b><?php __('Provincia'); ?></b> <?php do {
              $vals = explode(',', $row_rsproperties_client['b_loc2_cli']);
            ?>
            <?php if (in_array($row_rsparent2['id'], $vals)) { ?>
            - <?php echo $row_rsparent2['name'] ?>
            <?php } ?>
            <?php } while ($row_rsparent2 = mysqli_fetch_assoc($rsparent2)); ?></li>
            <li><b><?php __('Ciudad'); ?></b> <?php do {
              $vals = explode(',', $row_rsproperties_client['b_loc3_cli']);
            ?>
            <?php if (in_array($row_rsparent3['id'], $vals)) { ?>
            - <?php echo $row_rsparent3['name'] ?>
            <?php } ?>
            <?php } while ($row_rsparent3 = mysqli_fetch_assoc($rsparent3)); ?></li>
          <li><b><?php __('Zona'); ?></b> <?php do {
              $vals = explode(',', $row_rsproperties_client['b_loc4_cli']);
            ?>
            <?php if (in_array($row_rsparent4['id'], $vals)) { ?>
            - <?php echo $row_rsparent4['name'] ?>
            <?php } ?>
            <?php } while ($row_rsparent4 = mysqli_fetch_assoc($rsparent4)); ?></li>
        </ul>


        </div>

        <div class="span6">

         <ul class="unstyled">
          <li><b><?php __('Habitaciones'); ?></b> - <?php echo $row_rsproperties_client['b_beds_cli'] ?></li>
          <li><b><?php __('Aseos'); ?></b> - <?php echo $row_rsproperties_client['b_baths_cli'] ?></li>
          <li><b><?php __('Opciones'); ?></b> <?php do {
              $vals = explode(',', $row_rsproperties_client['b_opciones_cli']);
            ?>
            <?php if (in_array($row_rsOpciones['id'], $vals)) { ?>
            - <?php echo $row_rsOpciones['name'] ?>
            <?php } ?>
            <?php } while ($row_rsOpciones = mysqli_fetch_assoc($rsOpciones)); ?></li>
          <li><b><?php __('Referencia'); ?></b> <?php do {
              $vals = explode(',', $row_rsproperties_client['b_ref_cli']);
            ?>
            <?php if (in_array($row_rsReferencias['name'], $vals)) { ?>
            - <?php echo $row_rsReferencias['name'] ?>
            <?php } ?>
            <?php } while ($row_rsReferencias = mysqli_fetch_assoc($rsReferencias)); ?></li>
          <li><b><?php __('Precio desde'); ?></b> - <?php echo $row_rsproperties_client['b_precio_desde_cli'] ?></li>
          <li><b><?php __('Precio hasta'); ?></b> - <?php echo $row_rsproperties_client['b_precio_hasta_cli'] ?></li>
        </ul>

        </div>

      </div>



</div>



</body>
</html>
