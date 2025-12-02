<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa fa-rectangle-history-circle-user"></i> <a href="users.php"><?php echo __('Usuarios'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php __('Seguimiento'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="users.php" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-angle-left me-1"></i> <?php __('Volver'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Usuario'); ?></th>
                                    <th><?php __('IP'); ?></th>
                                    <th><?php __('Entrada'); ?></th>
                                    <th><?php __('Salida'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                      <td><input type="text" name="nombre_usr" id="nombre_usr" class="form-control form-control-sm"></td>
                                      <td><input type="text" name="ip_log" id="ip_log" class="form-control form-control-sm"></td>
                                      <td><input type="text" name="datein_log" id="datein_log" class="form-control form-control-sm"></td>
                                      <td><input type="text" name="dateout_log" id="dateout_log" class="form-control form-control-sm"></td>
                                      <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/inc.footer.php"); ?>

    <script src="/intramedianet/users/_js/seg-list.js" type="text/javascript"></script>

    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-user-clock me-2 fs-4"></i> <?php __('Información de acceso'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="loadingfrm">
                        <div class="py-5 text-center">
                            <div class="fa-3x">
                                <i class="fa-solid fa-spinner fa-spin-pulse"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <button type="button" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
