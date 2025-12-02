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

$query_rsTasksCats = "SELECT id_cat, categorias_".$lang_adm."_cat as cat FROM tasks_categories ORDER BY categorias_".$lang_adm."_cat";
$rsTasksCats = mysqli_query($inmoconn,$query_rsTasksCats) or die(mysqli_error());
$row_rsTasksCats = mysqli_fetch_assoc($rsTasksCats);
$totalRows_rsTasksCats = mysqli_num_rows($rsTasksCats);

$total = 7;

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-list-check"></i> <?php echo __('Tareas'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="tasks-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Propietario de la tarea'); ?></th>
                                    <th><?php __('Asunto'); ?></th>
                                    <th><?php __('Fecha de vencimiento'); ?></th>
                                    <th><?php __('Prioridad'); ?></th>
                                    <th><?php __('Status'); ?></th>
                                    <th><?php __('Contacto'); ?> / <?php __('Cliente'); ?> / <?php __('Propietario'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="admin_tsk" id="admin_tsk" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="subject_tsk" id="subject_tsk" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="date_due_tsk" id="date_due_tsk" class="form-control form-control-sm"></td>
                                    <td>
                                        <input type="hidden" name="priority_tsk" id="priority_tsk" class="form-control form-control-sm">
                                        <select name="priority_tsk_sel" id="priority_tsk_sel" class="form-select form-select-sm required">
                                            <option value=""><?php __("Todos"); ?></option>
                                            <option value="High"><?php __('High'); ?></option>
                                            <option value="Highest"><?php __('Highest'); ?></option>
                                            <option value="Low"><?php __('Low'); ?></option>
                                            <option value="Lowest"><?php __('Lowest'); ?></option>
                                            <option value="Normal"><?php __('Normal'); ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="status_tsk" id="status_tsk" class="form-control form-control-sm">
                                        <select name="status_tsk_sel" id="status_tsk_sel" class="form-select form-select-sm required">
                                            <option value=""><?php __("Todos"); ?></option>
                                            <?php
                                            do {
                                            ?>
                                            <option value="<?php echo $row_rsTasksCats['id_cat']?>"><?php echo $row_rsTasksCats['cat']?></option>
                                            <?php
                                            } while ($row_rsTasksCats = mysqli_fetch_assoc($rsTasksCats ));
                                              $rows = mysqli_num_rows($rsTasksCats );
                                              if($rows > 0) {
                                                  mysqli_data_seek($rsTasksCats , 0);
                                                $row_rsTasksCats = mysqli_fetch_assoc($rsTasksCats );
                                              }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="contact_type_tsk" id="contact_type_tsk" class="form-control form-control-sm"></td>
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
    var numCols = <?php echo $total - 1; ?>;
    </script>

    <script src="_js/tasks-list.js" type="text/javascript"></script>

</body>
</html>
