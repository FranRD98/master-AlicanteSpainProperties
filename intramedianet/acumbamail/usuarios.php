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

if ($_GET['start'] == '') {
    $_GET['start'] = 0;
}

if ($_GET['end'] == '') {
    $_GET['end'] = 20;
}

$acumba = new AcumbamailAPI($keyAcumbamail);
$miembros = $acumba->getSubscribers($_GET['id'], "0", "2");

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-rectangle-list"></i> <a href="listas.php"><?php echo $_GET['name'] ?></a> <i class="fa-regular fa-chevron-right"></i> <?php if($miembros) { echo number_format(count($miembros), 0, ',', '.');  } ?> <?php __('Usuarios'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#myModalUSR"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                        <a href="listas.php" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-angle-left me-1"></i> <?php __('Volver'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Creado'); ?></th>
                                    <th class="actions" id="actions"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($miembros)): ?>
                                    <?php if ($miembros): ?>
                                        <?php foreach (array_slice($miembros, $_GET['start'], $_GET['end']) as $key => $value) { ?>
                                            <tr>
                                                <td ><?php echo $value['nombre'] ?></td>
                                                <td ><?php echo $value['email'] ?></td>
                                                <td ><?php echo date("d-m-Y H:i", strtotime($value['create_date'])); ?></td>
                                                <td class="actions">
                                                    <div class="dropdown d-inline-block w-100">
                                                        <button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-regular fa-ellipsis align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a href="https://acumbamail.com/list/subscriber/detail/<?php echo $value['id'] ?>/" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-eye align-bottom me-1"></i> <?php __('Ver en acumbamail') ?></a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a href="usuarios-delete.php?list=<?php echo $_GET['id'] ?>&id=<?php echo $value['email'] ?>" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> <?php __('Eliminar') ?></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php endif ?>
                                <?php endif ?>
                            </tbody>
                        </table>

                        <?php if($miembros) {  ?>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <?php
                                $paginas = count($miembros)/20;

                                echo __('Ir a página:', true) . ' <select name="start" id="start" class="form-select form-select-sm" style="display: inline-block; width: auto;">';
                                for ($i=1; $i <= intval($paginas); $i++) {
                                    $selected = ((($i*20)-20) == $_GET['start'])?'selected':'';
                                    echo '<option value="' . (($i*20)-20) . '" ' . $selected . '>' . $i . '</option>';
                                }
                                if ((count($miembros)/20) >= intval($paginas)) {
                                    $selected = ((($i*20)-20) == $_GET['start'])?'selected':'';
                                    echo '<option value="' . (($i*20)-20) . '" ' . $selected . '>' . ($i) . '</option>';
                                }
                                echo '</select>';
                                ?>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
        $('#start').change(function() {
            window.location = '/intramedianet/acumbamail/usuarios.php?name=<?php echo $_GET['name'] ?>&id=<?php echo $_GET['id'] ?>&start=' + $(this).val();
        });
    </script>

    <div id="myModalUSR" class="modal fade" tabindex="-1" aria-labelledby="myModalUSRLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="usuarios-add.php" method="post">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white pb-3" id="myModalUSRLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Add User'); ?></h5>
                        <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="form-group mb-4">
                            <div class="form-group">
                                <label for="nombre" class="form-label"><?php __('Nombre'); ?>:</label>
                                <input type="text" name="nombre" id="nombre" value="" size="32" maxlength="255" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="email" class="form-label"><?php __('Email'); ?>:</label>
                                <input type="email" name="email" id="email" value="" size="32" maxlength="255" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-soft-primary">
                        <input type="hidden" name="list" value="<?php echo $_GET['id'] ?>">
                        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php __('Guardar'); ?>" class="btn btn-success btn-sm mt-4" />
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
