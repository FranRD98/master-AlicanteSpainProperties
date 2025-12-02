<?php
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
Global $lang_adm;

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

$colname_rsOwner = "-1";
if (isset($_GET['i'])) {
  $colname_rsOwner = $_GET['i'];
}

$colname_rsOwner = mysqli_real_escape_string($inmoconn, $colname_rsOwner);

$query_rsOwner = sprintf("
SELECT
    status_pro,
    nombre_pro,
    apellidos_pro,
    workers_pro,
    telefono_fijo_pro,
    telefono_movil_pro,
    email_pro,
    skype_pro,
    direccion_pro,
    (SELECT category_".$lang_adm."_cap  FROM properties_owner_captado WHERE id_cap = captado_por_pro) AS captado_por_pro,
    (SELECT category_".$lang_adm."_sts  FROM properties_owner_sources WHERE id_sts = como_nos_conocio_pro) AS como_nos_conocio_pro,
    fecha_alta_pro,
    keyholder_pro,
    keyholder_name_pro,
    keyholder_tel_pro,
    historial_pro
FROM properties_owner WHERE id_pro = %s ", GetSQLValueString($colname_rsOwner, "int"));
$rsOwner = mysqli_query($inmoconn, $query_rsOwner) or die(mysqli_error());
$row_rsOwner = mysqli_fetch_assoc($rsOwner);
$totalRows_rsOwner = mysqli_num_rows($rsOwner);

// sleep(1);

?>

<hr>

<div class="row-fluid">

  <div class="span6">

    <p><b><?php echo $lang['operación'] ?>:</b> <?php

    $colname_rsSatus = "-1";
    if (isset($_GET['i'])) {
      $colname_rsSatus = $_GET['i'];
    }
    
    $query_rsSatus = sprintf("SELECT * FROM properties_owner_states WHERE id_sts = '".$row_rsOwner['status_pro']."' ", GetSQLValueString($colname_rsSatus, "int"));
    $rsSatus = mysqli_query($inmoconn, $query_rsSatus) or die(mysqli_error());
    $row_rsSatus = mysqli_fetch_assoc($rsSatus);
    $totalRows_rsSatus = mysqli_num_rows($rsSatus);


     echo $row_rsSatus['category_'.$lang_adm.'_sts']

     ?></p>
     <p><b><?php echo $lang['Nombre'] ?>:</b> <?php echo $row_rsOwner['nombre_pro'] ?> <?php echo $row_rsOwner['apellidos_pro'] ?></p>
     <?php if ($row_rsOwner['workers_pro'] != ''): ?>
         <p><b><?php echo $lang['Persona de Contacto'] ?>:</b><br><?php echo str_replace('@@@@@@','<br><br>',nl2br($row_rsOwner['workers_pro'])); ?></p>
     <?php endif ?>
    <p><b><?php echo $lang['Teléfono'] ?>:</b> <?php echo $row_rsOwner['telefono_fijo_pro'] ?></p>
    <p><b><?php echo $lang['Móvil'] ?>:</b> <?php echo $row_rsOwner['telefono_movil_pro'] ?></p>
    <p><b><?php echo $lang['Email'] ?>:</b> <?php echo $row_rsOwner['email_pro'] ?></p>
    <p><b><?php echo $lang['Partner Portal / Dropbox'] ?>:</b> <?php echo $row_rsOwner['skype_pro'] ?></p>
    <p><b><?php echo $lang['Dirección'] ?>:</b> <?php echo $row_rsOwner['direccion_pro'] ?></p>
    <p><b><?php echo $lang['Cómo nos conoció'] ?>:</b> <?php echo $row_rsOwner['como_nos_conocio_pro'] ?></p>
    <p><b><?php echo $lang['Captado por'] ?>:</b> <?php echo $row_rsOwner['captado_por_pro'] ?></p>
    <p><b><?php echo $lang['Añadido'] ?>:</b> <?php echo $row_rsOwner['fecha_alta_pro'] ?></p>

  </div>

  <div class="span6">

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

    <h4 class="border-bottom pb-1"><?php echo $lang['Historial'] ?></h4>

    <div id="note-txt"><?php if(isset($row_rsOwner['historial_pro'])) echo nl2br(preg_replace(array('/\[/', '/→/'), array('<b>[', '→</b>',), $row_rsOwner['historial_pro'])); ?></div>

    <hr>

    <a href="#" class="btn btn-success btn-sm addHist add-note"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>

    <br style="clear: both">

    <br>

  </div>

</div>







<?php
mysqli_free_result($rsOwner);
?>
