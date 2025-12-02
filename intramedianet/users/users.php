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
// $restrict->addLevel("7");
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-users"></i> <?php echo __('Usuarios'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="users-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                        <a href="seg-index.php" class="btn btn-primary btn-sm"><i class="fa-regular fa-rectangle-history-circle-user me-1"></i> <?php __('Seguimiento'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Nivel'); ?></th>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Activado'); ?></th>
                                    <th><?php __('Creado'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="hidden" name="nivel_usr" id="nivel_usr">
                                        <select name="nivel_usr_sel" id="nivel_usr_sel" class="form-select form-select-sm">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php if($actAgente == 1) { ?>
                                            <option value="7"><?php __('Agente'); ?></option>
                                            <?php } ?>
                                            <?php if($actEmpleados == 1) { ?>
                                            <option value="8"><?php __('Empleado'); ?></option>
                                            <?php } ?>
                                            <option value="9"><?php __('Administrador'); ?></option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control form-control-sm" name="nombre_usr" id="nombre_usr"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="email_usr" id="email_usr"></td>
                                    <td><input type="hidden" name="activar_usr" id="activar_usr">
                                      <select name="activar_usr_sel" id="activar_usr_sel" class="form-select form-select-sm">
                                          <option value=""><?php __('Todos'); ?></option>
                                          <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                          <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                     </select>
                                    </td>
                                    <td><input type="text" class="form-control form-control-sm" name="registrationdate_usr" id="registrationdate_usr"></td>
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

    <script src="/intramedianet/users/_js/user-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
