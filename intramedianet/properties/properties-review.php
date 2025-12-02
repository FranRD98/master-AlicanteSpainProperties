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

$query_rsReviewPropsUsrs = "SELECT * FROM prop_user WHERE id_prp = '".$_GET['id_prp']."' ORDER BY fecha_prp";
$rsReviewPropsUsrs = mysqli_query($inmoconn,$query_rsReviewPropsUsrs) or die(mysqli_error());
$row_rsReviewPropsUsrs = mysqli_fetch_assoc($rsReviewPropsUsrs);
$totalRows_rsReviewPropsUsrs = mysqli_num_rows($rsReviewPropsUsrs);

if ($totalRows_rsReviewPropsUsrs == 0) {
    header("Location: ../inicio/inicio.php");
}

function showField($return, $table, $idfirld, $id) {

    global $database_inmoconn, $inmoconn;

    $query_rsReturn = "SELECT $return FROM ".$table." WHERE ".$idfirld." = '".$id."'";
    $rsReturn = mysqli_query($inmoconn,$query_rsReturn) or die(mysqli_error());
    $row_rsReturn = mysqli_fetch_assoc($rsReturn);
    $totalRows_rsReturn = mysqli_num_rows($rsReturn);

    return $row_rsReturn[$return];
}


if ($_GET['KT_Delete1'] == 1) {

    $images = explode(',', $row_rsReviewPropsUsrs['imagenes_prp']);
    foreach ($images as $value) {
        unlink($_SERVER["DOCUMENT_ROOT"] . "/media/images/list-properties/" . $value);
    }

    $query_rsReviewPropsUsrs = "DELETE FROM `prop_user` WHERE id_prp = '".$_GET['id_prp']."'";
    $rsReviewPropsUsrs = mysqli_query($inmoconn,$query_rsReviewPropsUsrs) or die(mysqli_error());

    header("Location: ../inicio/inicio.php");
}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-building-o"></i> <span><?php __('Propiedades de usuarios para revisar'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="properties-review-add.php?id_prp=<?php echo $row_rsReviewPropsUsrs['id_prp'] ?>" class="btn btn-success btn-sm"><?php echo NXT_getResource("Insert_FB"); ?></a>
            <a href="#" class="delrow2 btn btn-danger btn-sm"><?php echo NXT_getResource("Delete_FB"); ?></a>
            <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-default btn-sm" />
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Propiedades de usuarios para revisar'); ?></h3>
                </div>

                <div class="panel-body">

                   <div class="row">
                       <div class="col-md-6">
                            <ul class="list-group">
                              <li class="list-group-item"><b><?php __('Fecha'); ?>:</b> <?php echo date("d-m-Y H:i", strtotime($row_rsReviewPropsUsrs['fecha_prp'])) ?></li>
                              <li class="list-group-item"><b><?php __('Nombre'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['name_prp'] ?></li>
                              <li class="list-group-item"><b><?php __('Email'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['email_prp'] ?></li>
                              <li class="list-group-item"><b><?php __('Teléfono'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['phone_prp'] ?></li>
                              <li class="list-group-item"><b><?php __('Estatus'); ?>:</b> <?php echo showField('status_'.$lang_adm.'_sta', 'properties_status', 'id_sta', $row_rsReviewPropsUsrs['estado_prp']); ?></li>
                              <li class="list-group-item"><b><?php __('Tipo'); ?>:</b> <?php echo showField('types_'.$lang_adm.'_typ', 'properties_types', 'id_typ', $row_rsReviewPropsUsrs['tipo_prp']); ?></li>
                              <li class="list-group-item"><b><?php __('País'); ?>:</b> <?php echo showField('name_'.$lang_adm.'_loc1', 'properties_loc1', 'id_loc1', $row_rsReviewPropsUsrs['pais_prp']); ?></li>
                              <li class="list-group-item"><b><?php __('Provincia'); ?>:</b> <?php echo showField('name_'.$lang_adm.'_loc2', 'properties_loc2', 'id_loc2', $row_rsReviewPropsUsrs['provincia_prp']); ?></li>
                              <li class="list-group-item"><b><?php __('Ciudad'); ?>:</b> <?php echo showField('name_'.$lang_adm.'_loc3', 'properties_loc3', 'id_loc3', $row_rsReviewPropsUsrs['ciudad_prp']); ?></li>
                              <li class="list-group-item"><b><?php __('Zona'); ?>:</b> <?php echo showField('name_'.$lang_adm.'_loc4', 'properties_loc4', 'id_loc4', $row_rsReviewPropsUsrs['zona_prp']); ?></li>
                              <li class="list-group-item"><b><?php __('Dirección'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['direccion_prp'] ?></li>
                              <li class="list-group-item"><b><?php __('Código Postal'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['cp_prp'] ?></li>
                              <li class="list-group-item"><b><?php __('M2'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['m2_prp'] ?></li>
                              <li class="list-group-item"><b><?php __('M2'); ?>  <?php __('Parcela'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['m2p_prp'] ?></li>
                            </ul>
                       </div>
                       <div class="col-md-6">
                            <ul class="list-group">
                              <li class="list-group-item"><b><?php __('Precio'); ?>:</b> <?php echo number_format($row_rsReviewPropsUsrs['precio_prp'], 0, ',', '.') ?> €</li>
                              <li class="list-group-item"><b><?php __('Habitaciones'); ?>:</b> <?php echo number_format($row_rsReviewPropsUsrs['habitaciones_prp'], 0, ',', '.') ?></li>
                              <li class="list-group-item"><b><?php __('Aseos'); ?>:</b> <?php echo number_format($row_rsReviewPropsUsrs['banos_prp'], 0, ',', '.') ?></li>
                              <li class="list-group-item"><b><?php __('Piscina'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['piscina_prp'] ?></li>
                              <!-- <li class="list-group-item"><b><?php __('Tiempo para la venta'); ?>:</b> <?php echo $row_rsReviewPropsUsrs['tiempo_prp'] ?></li>
                              <li class="list-group-item"><b><?php __('Precio reducido'); ?>:</b> <?php ($row_rsReviewPropsUsrs['reducido_prp'] == 1)?__('Sí'):__('No'); ?></li>
                              <li class="list-group-item"><b><?php __('Cerca del mar'); ?>:</b> <?php ($row_rsReviewPropsUsrs['cercamar_prp'] == 1)?__('Sí'):__('No'); ?></li>
                              <li class="list-group-item"><b><?php __('Vistas al mar'); ?>:</b> <?php ($row_rsReviewPropsUsrs['vistasmar_prp'] == 1)?__('Sí'):__('No'); ?></li>
                              <li class="list-group-item"><b><?php __('Propiedad exclusiva'); ?>:</b> <?php ($row_rsReviewPropsUsrs['exclusiva_prp'] == 1)?__('Sí'):__('No'); ?></li> -->
                              <li class="list-group-item"><b><?php __('Comentario'); ?>:</b> <br> <?php echo $row_rsReviewPropsUsrs['consulta_prp'] ?></li>
                            </ul>
                       </div>
                   </div>

                   <!-- <legend><?php __('Imágenes'); ?></legend>

                   <?php $images = explode(',', $row_rsReviewPropsUsrs['imagenes_prp']); ?>

                   <ul class="list-inline">

                    <?php foreach ($images as $value) { ?>

                        <li><img src="/media/images/list-properties/<?php echo $value ?>" style="height: 100px; margin-boton: 20px; display: block" alt=""> </li>

                    <?php } ?> -->

                   </ul>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <input type="hidden" name="kt_pk_properties_status" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproperties_status['kt_pk_properties_status']); ?>" />

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
