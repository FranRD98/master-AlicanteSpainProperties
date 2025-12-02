<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

$query_rsXML = "SELECT * FROM xml WHERE activate_xml = 1 ORDER BY site_xml ASC";
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
        case 6:
            return "REDSP";
        break;
        case 7:
            return "Habihub";
        break;
    }
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-file-import"></i> <?php echo __('Importar'); ?></h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <div class="input-group mb-4">
                            <select name="site_xml" id="site_xml" class="form-select required" required>
                                <option value=""><?php __('Seleccione Proveedor'); ?></option>
                                <?php do { ?>

                                <option value="<?php echo $row_rsXML['id_xml'] ?>"><?php echo $row_rsXML['site_xml'] ?> (<?php echo showTipo($row_rsXML['tipo_xml']); ?>)</option>

                                <?php } while ($row_rsXML = mysqli_fetch_assoc($rsXML)); ?>
                            </select>
                            <button type="button" id="startImport" class="btn btn-primary"><?php __('Iniciar la importación'); ?></button>
                        </div>
                        <div class="invalid-feedback">
                            <?php __('Este campo es obligatorio.'); ?>
                        </div>

                        <div id="portaiframe">
                            <iframe src="import-loading.php" frameborder="0" id="importiframe"></iframe>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
        <script src="_js/import.js" type="text/javascript"></script>
    <?php endif ?>
</body>
</html>
