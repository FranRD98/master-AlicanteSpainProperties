<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );
// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->addLevel("1");
// $restrict->Execute();
//End Restrict Access To Page
?><?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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

$colname_rsProp = "-1";
if (isset($_GET['prop'])) {
  $colname_rsProp = $_GET['prop'];
}

$colname_rsProp = mysqli_real_escape_string($inmoconn, $colname_rsProp);

$query_rsProp = sprintf("SELECT * FROM properties_properties WHERE id_prop = %s ", GetSQLValueString($colname_rsProp, "int"));
$rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
$row_rsProp = mysqli_fetch_assoc($rsProp);
$totalRows_rsProp = mysqli_num_rows($rsProp);

$colname_rsOwner = "-1";
if (isset($_GET['propie'])) {
  $colname_rsOwner = $_GET['propie'];
}

$colname_rsOwner = mysqli_real_escape_string($inmoconn, $colname_rsOwner);

$query_rsOwner = sprintf("SELECT * FROM properties_owner WHERE id_pro = %s ", GetSQLValueString($colname_rsOwner, "int"));
$rsOwner = mysqli_query($inmoconn, $query_rsOwner) or die(mysqli_error());
$row_rsOwner = mysqli_fetch_assoc($rsOwner);
$totalRows_rsOwner = mysqli_num_rows($rsOwner);

?>


      <link rel="stylesheet" href="/css/check/css/bootstrap.min.css">

<div class="container">

<h1>Propiedad Referencia: <?php echo $row_rsProp['referencia_prop'] ?></h1>


<?php if($totalRows_rsProp  > 0) { ?>
<legend><?php __('Datos privados'); ?></legend>

<div class="row">

  <div class="col-sm-6">

      <p><b><?php __('Dirección'); ?>:</b> <?php echo ($row_rsProp['direccion_prop']); ?></p>
      <p><b><?php __('Suma/IBI'); ?>:</b> <?php echo ($row_rsProp['suma_prop']); ?></p>
      <p><b><?php __('Gastos de la comunidad'); ?>:</b> <?php echo ($row_rsProp['gastos_prop']); ?></p>
      <div class="well">
      <p><b><?php __('Precio propietario'); ?>:</b> <?php echo ($row_rsProp['precio_propie_prop']); ?></p>
      <p><b><?php __('% Valor comisión'); ?>:</b> <?php echo ($row_rsProp['comision_prop']); ?></p>
      <p><b><?php __('Aplicar'); ?> <?php echo ($row_rsProp['iva_porc_prop']); ?> <?php __('% de iva'); ?>:</b> <?php if($row_rsProp['iva_prop'] == 1) { __('Sí'); } else { __('No'); } ?></p>
      <p><b><?php __('Precio de venta'); ?>:</b> <?php echo ($row_rsProp['precio_venta_prop']); ?></p>
      </div>
      <div class="well">
      <p><b><?php __('Laves'); ?>:</b> <?php if($row_rsProp['llaves_prop'] == 1) { __('Sí'); } else { __('No'); } ?></p>
      <p><b><?php __('Alcayata'); ?>:</b> <?php echo ($row_rsProp['alcayata_prop']); ?></p>
      <p><b><?php __('Texto'); ?>:</b> <?php echo ($row_rsProp['llave_txt_prop']); ?></p>
      </div>

  </div>

  <div class="col-sm-6">

      <div class="well">
      <p><b><?php __('Hipoteca'); ?>:</b> <?php if($row_rsProp['hipoteca_prop'] == 1) { __('Sí'); } else { __('No'); } ?></p>
      <p><b><?php __('Entidad'); ?>:</b> <?php echo ($row_rsProp['entidad_prop']); ?></p>
      <p><b><?php __('Cantidad pendiente'); ?>:</b> <?php echo ($row_rsProp['pendiente_prop']); ?></p>
      <p><b><?php __('Abogado'); ?>:</b> <?php echo ($row_rsProp['bogado_prop']); ?></p>
      <p><b><?php __('Teléfono'); ?>:</b> <?php echo ($row_rsProp['abogado_telefono_prop']); ?></p>
      <p><b><?php __('Cartel'); ?>:</b> <?php if($row_rsProp['cartel_prop'] == 1) { __('Sí'); } else { __('No'); } ?></p>
      <p><b><?php __('Solicitar cita'); ?>:</b> <?php if($row_rsProp['cita_prop'] == 1) { __('Sí'); } else { __('No'); } ?></p>
      </div>
      <div class="well">
      <p><b><?php __('Solicitar llave'); ?>:</b> <?php if($row_rsProp['keyholder_prop'] == 1) { __('Sí'); } else { __('No'); } ?></p>
      <p><b><?php __('Nombre'); ?>:</b> <?php echo ($row_rsProp['keyholder_name_prop']); ?></p>
      <p><b><?php __('Teléfono'); ?>:</b> <?php echo ($row_rsProp['keyholder_tel_prop']); ?></p>
      </div>

  </div>

</div>

<div class="row-fluid">

  <div class="span12">

    <legend><?php echo __('Notas') ?></legend>

    <p><?php echo nl2br(preg_replace(array('/\[/', '/→/'), array('<b>[', '→</b>'), $row_rsProp['notas_prop'])); ?></p>

  </div>

</div>

<?php /* ?>


                          <div class="control-group <?php if($tNGs->displayFieldError("properties_properties", "notas_prop") != '') { ?>error<?php } ?>">
                              <label class="control-label" for="notas_prop"><?php __('Notas'); ?>:</label>
                              <div class="controls">
                                  <textarea name="notas_prop" id="notas_prop" cols="50" rows="10" class="span12"><?php echo ($row_rsProp['notas_prop']); ?></textarea>
                                  <?php echo $tNGs->displayFieldError("properties_properties", "notas_prop"); ?>
                              </div>
                          </div>


<?php */ ?>

<hr>
<?php } ?>


<?php if($totalRows_rsOwner  > 0) { ?>
<legend><?php __('Propietario'); ?></legend>



<div class="row">

  <div class="col-sm-6">

    <p><b><?php echo $lang['Nombre'] ?>:</b> <?php echo $row_rsOwner['nombre_pro'] ?> <?php echo $row_rsOwner['apellidos_pro'] ?></p>
    <?php if ($row_rsOwner['workers_pro'] != ''): ?>
        <p><b><?php echo $lang['Persona de Contacto'] ?>:</b><br><?php echo str_replace('@@@@@@','<br><br>',nl2br($row_rsOwner['workers_pro'])); ?></p>
    <?php endif ?>
    <p><b><?php echo $lang['Teléfono'] ?>:</b> <?php echo $row_rsOwner['telefono_fijo_pro'] ?></p>
    <p><b><?php echo $lang['Móvil'] ?>:</b> <?php echo $row_rsOwner['telefono_movil_pro'] ?></p>
    <p><b><?php echo $lang['Email'] ?>:</b> <?php echo $row_rsOwner['email_pro'] ?></p>
    <p><b><?php echo $lang['Skype'] ?>:</b> <?php echo $row_rsOwner['skype_pro'] ?></p>
    <p><b><?php echo $lang['Dirección'] ?>:</b> <?php echo $row_rsOwner['direccion_pro'] ?></p>
    <p><b><?php echo $lang['Cómo nos conoció'] ?>:</b> <?php echo $row_rsOwner['como_nos_conocio_pro'] ?></p>
    <p><b><?php echo $lang['Captado por'] ?>:</b> <?php echo $row_rsOwner['captado_por_pro'] ?></p>
    <p><b><?php echo $lang['Añadido'] ?>:</b> <?php echo $row_rsOwner['fecha_alta_pro'] ?></p>

  </div>

  <div class="col-sm-6">

    <?php if($row_rsOwner['keyholder_pro'] == 1) { ?>
    <div class="well">
      <b style="margin: 0; padding: 0; font-size: 16px"><?php echo $lang['Solicitar llave'] ?></b>
      <hr style="margin: 5px 0;">
      <p><b><?php echo $lang['Nombre'] ?>:</b> <?php echo $row_rsOwner['keyholder_name_pro'] ?></p>
      <p><b><?php echo $lang['Teléfono'] ?>:</b> <?php echo $row_rsOwner['keyholder_tel_pro'] ?></p>
    </div>
    <?php } ?>

  </div>

</div>

<div class="row-fluid">

  <div class="span12">

    <legend><?php echo $lang['Historial'] ?></legend>

    <p><?php echo nl2br(preg_replace(array('/\[/', '/→/'), array('<b>[', '→</b>'), $row_rsOwner['historial_pro'])); ?></p>

  </div>

</div>

<?php } ?>

<hr>

<div>

  <?php echo $textMailTempl ?>

    <br>    <br>

</div>

</div>


<?php
mysqli_free_result($rsOwner);
?>
