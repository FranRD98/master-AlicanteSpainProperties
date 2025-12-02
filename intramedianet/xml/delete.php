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

$query_rsXML = "SELECT * FROM xml ORDER BY site_xml ASC";
$rsXML = mysqli_query($inmoconn, $query_rsXML) or die(mysqli_error());
$row_rsXML = mysqli_fetch_assoc($rsXML);
$totalRows_rsXML = mysqli_num_rows($rsXML);

function showTipo($tipo) {
    switch ($tipo) {
        case 1:
            return "Kyero";
        break;
        case 2:
            return "Mediaelx";
        break;
        case 3:
            return "Inmovilla";
        break;
        case 5:
            return "Resales";
        break;
    }
}

function logprop($user, $id, $ref, $action) {

    global $database_inmoconn, $inmoconn;

    $query_rsProp = "INSERT INTO `properties_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '".$user."', '".$id."', '".$ref."', '".$action."', '".date("Y-m-d H:i:s")."')";
    $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());

}

if (isset($_GET['xml'])) {

    $query_rsPropsDel = "SELECT id_prop, referencia_prop FROM properties_properties WHERE xml_xml_prop = '".$_GET['xml']."'";
    $rsPropsDel = mysqli_query($inmoconn,$query_rsPropsDel) or die(mysqli_error());
    $row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel);
    $totalRows_rsPropsDel = mysqli_num_rows($rsPropsDel);

    do {

        $query_rsXMLfea = "DELETE FROM properties_property_feature WHERE property = '".$row_rsPropsDel['id_prop']."'";
        $rsXMLfea = mysqli_query($inmoconn, $query_rsXMLfea) or die(mysqli_error());

        logprop('0', $row_rsPropsDel['id_prop'], $row_rsPropsDel['referencia_prop'], '5');

        $query_rsXMLprop = "DELETE FROM properties_properties WHERE id_prop = '".$row_rsPropsDel['id_prop']."'";
        $rsXMLprop = mysqli_query($inmoconn, $query_rsXMLprop) or die(mysqli_error());

        $query_rsXML = "SELECT * FROM properties_images WHERE property_img = '".$row_rsPropsDel['id_prop']."'";
        $rsXML = mysqli_query($inmoconn, $query_rsXML) or die(mysqli_error());
        $row_rsXML = mysqli_fetch_assoc($rsXML);
        $totalRows_rsXML = mysqli_num_rows($rsXML);

        do {

            array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/" . $row_rsXML['id_img'] . "_*"));

            $query_rsDelIMG = "DELETE FROM properties_images WHERE id_img = '".$row_rsXML['id_img']."'";
            $rsDelIMG = mysqli_query($inmoconn, $query_rsDelIMG) or die(mysqli_error());

        } while ($row_rsXML = mysqli_fetch_assoc($rsXML));

    } while ($row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel));

    array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));

    header("Location: delete.php?d=ok");

}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-trash-can"></i> <?php echo __('Eliminar Propiedades de XML'); ?></h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <?php if(isset($_GET['d']) && $_GET['d'] == 'ok') { ?>
                        <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="fa-regular fa-check label-icon"></i> <?php __('Los inmuebles se han eliminado correctamente'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>

                        <div class="input-group">
                            <select name="site_xml" id="site_xml" class="form-select required" required>
                                <option value=""><?php __('Seleccione Proveedor'); ?></option>
                                <?php do { ?>

                                <option value="<?php echo $row_rsXML['id_xml'] ?>"><?php echo $row_rsXML['site_xml'] ?> (<?php echo showTipo($row_rsXML['tipo_xml']); ?>)</option>

                                <?php } while ($row_rsXML = mysqli_fetch_assoc($rsXML)); ?>
                            </select>
                            <button type="button" id="startImport" class="btn btn-primary"><?php __('Eliminar inmuebles'); ?></button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    $(document).ready(function() {

      $('#startImport').click(function (){

        window.location = 'delete.php?xml='+$('#site_xml').val();

      });


    });

    </script>

</body>
</html>
