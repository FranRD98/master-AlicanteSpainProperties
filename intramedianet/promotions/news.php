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
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
        <i class="fa-regular fa-triangle-exclamation label-icon"></i> <?php echo $lang['Development-warning']; ?>
    </div>

    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
        <i class="fa-regular fa-circle-check label-icon"></i> <?php echo $lang['Development-warning2']; ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-memo"></i> <?php echo __('Promociones'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="news-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                        <a href="promotions-order.php" class="btn btn-primary btn-sm"><i class="fa-regular fa-arrow-up-arrow-down me-1"></i> <?php __('Ordenar'); ?></a>
                        <?php if ($_SESSION['kt_login_level'] == 9): ?>
                        <a href="/intramedianet/promotions/promotions-all-download-csv.php" class="btn btn-primary btn-sm "><i class="fa-regular fa-file-excel me-1"></i> <?php __('Descargar para Excel'); ?></a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Titular Habihub (Privado)'); ?></th>
                                    <th><?php __('Titular Web (Público)'); ?></th>
                                    <th><?php __('Nº Casas'); ?></th>
                                    <th><?php __('Provincia'); ?></th>
                                    <th><?php __('Ciudad'); ?></th>
                                    <th><?php __('Habitaciones'); ?></th>
                                    <th><?php __('Tipo'); ?></th>
                                    <th><?php __('Activado'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="title_en_nws" id="title_en_nws" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="title_en_nws2" id="title_en_nws2" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="title_en_nws3" id="title_en_nws3" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="title_en_nws6" id="title_en_nws6" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="title_en_nws7" id="title_en_nws7" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="title_en_nws4" id="title_en_nws4" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="title_en_nws5" id="title_en_nws5" class="form-control form-control-sm"></td>
                                    <td><input type="hidden" name="activate_nws" id="activate_nws">
                                        <select name="activate_nws_sel" id="activate_nws_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="2"><?php __('Procesando'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>
                                    </td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
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

    <script>
    var numCols = 8;
    </script>

    <script src="/intramedianet/promotions/_js/pages-list.js" type="text/javascript"></script>

</body>
</html>
