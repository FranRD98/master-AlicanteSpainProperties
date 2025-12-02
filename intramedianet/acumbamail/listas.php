<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);


// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php' );

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

function _d($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

$acumba = new AcumbamailAPI($keyAcumbamail);
$listas = $acumba->getLists();
krsort($listas);

// _d($listas);
// die();
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-rectangle-list"></i> <?php echo __('Listas'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('ID'); ?></th>
                                    <th><?php __('Lista'); ?></th>
                                    <th><?php __('Usuarios'); ?></th>
                                    <th class="actions" id="actions" style="width: 140px !important;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listas as $key => $value) { ?>
                                    <tr>
                                        <td ><?php echo $key ?></td>
                                        <td ><?php echo $value['name'] ?></td>
                                        <?php $datos = $acumba->getListStats($key); ?>
                                        <td ><?php echo number_format($datos['total_subscribers'] - $datos['unsubscribed_subscribers'] - $datos['hard_bounced_subscribers'] - $datos['spam_subscribers'], 0, ',', '.'); ?></td>
                                        <td class="actions">
                                            <div class="dropdown d-inline-block w-100">
                                                <button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-regular fa-ellipsis align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a href="https://acumbamail.com/list/<?php echo $key ?>/edit/" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-eye align-bottom me-1"></i> <?php __('Ver en acumbamail') ?></a></li>
                                                    <li><a href="usuarios.php?id=<?php echo $key ?>&name=<?php echo $value['name'] ?>" class="dropdown-item edit-item-btn"><i class="fa-regular fa-users align-bottom me-1"></i> <?php __('Usuarios') ?></a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a href="listas-delete.php?id=<?php echo $key ?>" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> <?php __('Eliminar') ?></a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="listas-add.php" method="post">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Add list'); ?></h5>
                        <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="name" class="form-label"><?php __('Name'); ?>:</label>
                                <input type="text" name="name" id="name" value="" size="32" maxlength="255" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-soft-primary">
                        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php __('Guardar'); ?>" class="btn btn-success btn-sm mt-4" />
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
