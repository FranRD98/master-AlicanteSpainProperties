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
$restrict->addLevel("6");
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
                <div class="card-header align-items-center d-flex">
                    <div class="flex-grow-1 oveflow-hidden">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-phone"></i> <?php echo __('Llamadas - Demandantes'); ?></h4>
                    </div>
                    <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="clients.php" role="tab" aria-selected="true">
                                    <?php if($totalRows_rsLlamadasDeman > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsLlamadasDeman; ?></span><?php } ?>
                                    <?php __('Clientes'); ?>
                                </a>
                            </li>
                            <?php if ($_SESSION['kt_login_level'] != 7): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="owners.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsLlamadasProp > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsLlamadasProp; ?></span><?php } ?>
                                    <?php __('Propietarios'); ?>
                                </a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>

                <div class="card-body">

                    <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="clients.php" role="tab" aria-selected="true">
                                <?php if($totalRows_rsLlamadasDeman > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsLlamadasDeman; ?></span><?php } ?>
                                <?php __('Clientes'); ?>
                            </a>
                        </li>
                        <?php if ($_SESSION['kt_login_level'] != 7): ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="owners.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php if($totalRows_rsLlamadasProp > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsLlamadasProp; ?></span><?php } ?>
                                <?php __('Propietarios'); ?>
                            </a>
                        </li>
                        <?php endif ?>
                    </ul>

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Teléfono'); ?></th>
                                    <th><?php __('Próxima llamada'); ?></th>
                                    <th><?php __('Responsable'); ?></th>
                                    <th id="actions"><div id="col-1"></div></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="nombre_pro" id="nombre_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="email_pro" id="email_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="next_call_pro" id="next_call_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="responsable" id="responsable" class="form-control form-control-sm"></td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
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
    var numCols = 6;
    </script>

    <script src="_js/clients-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>


</body>
</html>
