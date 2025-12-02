<?php
// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

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
$restrict->Execute();
//End Restrict Access To Page


$query_rsReferencias = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias = mysqli_query($inmoconn, $query_rsReferencias) or die(mysqli_error());
$row_rsReferencias = mysqli_fetch_assoc($rsReferencias);
$totalRows_rsReferencias = mysqli_num_rows($rsReferencias);
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-building-circle-check"></i> <?php __('Seguimiento de propiedades'); ?></h4>
                    <div class="flex-shrink-0 panel-heading">
                    </div>
                </div>
                <div class="card-body">

                    <div class="row" id="search-fields">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="b_ref_cli" class="form-label"><?php __('Referencia'); ?>:</label>
                                <select name="ref" id="ref" class="select2">
                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                  <?php do {
                                    if(isset($row_rsproperties_client['b_ref_cli']))
                                        $vals = explode(',', $row_rsproperties_client['b_ref_cli']);
                                    else
                                        $vals = array();
                                  ?>
                                  <option value="<?php echo $row_rsReferencias['id'] ?>"><?php echo $row_rsReferencias['name'] ?></option>
                                  <?php } while ($row_rsReferencias = mysqli_fetch_assoc($rsReferencias)); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <br>
                                <a href="#" class="btn btn-danger btn-reset w-100 mt-0"><i class="fa-regular fa-eraser"></i> <?php __('Limpiar'); ?></a>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <br>
                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-0 py-2" role="alert">
                                <i class="fa-regular fa-circle-info label-icon"></i> <?php echo sprintf(__('Solo se almacenan y se muestran los datos de los últimos %s meses', true), $logDMounths); ?>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Referencia'); ?></th>
                                    <th><?php __('Añadido'); ?></th>
                                    <th><?php __('Modificado'); ?></th>
                                    <th><?php __('Listado'); ?></th>
                                    <th><?php __('Propiedad'); ?></th>
                                    <th><?php __('Consultas'); ?></th>
                                    <th><?php __('Amigo'); ?></th>
                                    <th><?php __('Favoritos'); ?></th>
                                    <th><?php __('Impreso'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="_js/report-seguimiento-search.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <!-- <script>
        $('.select2references').select2({
            ajax: {
                url: '/intramedianet/properties/properties-references-select.php',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        q: params.term
                    }
                    return query;
                },
                results: function (data, params) {
                    return {
                        results: data.results
                    };
                }
            },
            placeholder: '',
            minimumInputLength: 3
        });
    </script> -->

</body>
</html>
