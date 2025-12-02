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

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-file-import"></i> <?php echo __('Origenes'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="clients-sources-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Origen'); ?></th>
                                    <?php if($actFerias == 1) { ?>
                                    <th><?php __('Ferias'); ?></th>
                                    <?php } ?>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="<?php echo 'feature_en_feat'; ?>" id="<?php echo 'feature_en_feat'; ?>" class="form-control form-control-sm"></td>
                                    <?php if($actFerias == 1) { ?>
                                    <td>
                                        <input type="hidden" name="active_fair_sts" id="active_fair_sts">
                                        <select name="active_fair_sts_sel" id="active_fair_sts_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                             <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                        </select>
                                    </td>
                                     <?php } ?>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
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
        var totalColumns = <?php echo ($actFerias == 1 ? 3 : 2); ?>;
        var non = '<?php echo $lang['No'] ?>';
    </script>

    <script src="_js/clients-sources-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
