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


if ($_GET['email'] != '') {
    $acumba = new AcumbamailAPI($keyAcumbamail);
    $miembros = $acumba->searchSubscriber($_GET['email']);
}

// _d($miembros);
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-user-magnifying-glass"></i> <?php __('Buscar usuarios'); ?></h4>
                    <div class="flex-shrink-0">
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <form action="usuarios-search.php" method="get">
                                <div class="input-group">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="<?php __('Email'); ?>..." value="<?php echo $_GET['email'] ?>">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                        <a href="usuarios-search.php" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                </div>
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3 mb-0" role="alert">
                                    <i class="fa-regular fa-circle-info label-icon"></i> <?php __('La búsqueda ha de contener el email completo'); ?>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php if ($_GET['email'] != ''): ?>

                    <hr>

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Lista'); ?></th>
                                    <th><?php __('Creado'); ?></th>
                                    <th id="actions" style="width: 70px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($miembros as $key => $value) { ?>
                                <tr>
                                    <td ><?php echo $value['email'] ?></td>
                                    <?php $info = $acumba->getListStats($value['list_id']); ?>
                                    <td ><a href="https://acumbamail.com/list/<?php echo $value['list_id'] ?>/" target="_blank" class="btn btn-soft-primary btn-sm"><?php echo $info['name'] ?></a></td>
                                    <td ><?php echo date("d-m-Y H:i", strtotime($value['create_date'])); ?></td>
                                    <td class="actions">
                                        <div class="dropdown d-inline-block w-100">
                                            <button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-regular fa-ellipsis align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="https://acumbamail.com/list/subscriber/detail/<?php echo $value['id'] ?>/" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-eye align-bottom me-1"></i> <?php __('Ver en acumbamail') ?></a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a href="usuarios-delete.php?list=<?php echo $value['list_id'] ?>&id=<?php echo $value['email'] ?>" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> <?php __('Eliminar') ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>

                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
