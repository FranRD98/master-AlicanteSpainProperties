<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-house-person-leave"></i> <?php echo __('Propietarios'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#myModalOwn"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('ID'); ?></th>
                                    <th><?php __('Tipo'); ?></th>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('Persona de Contacto'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Teléfono'); ?></th>
                                    <th><?php __('Teléfono'); ?> 2</th>
                                    <th><?php __('Estatus'); ?></th>
                                    <th><?php __('Captado por'); ?></th>
                                    <th><?php __('Próxima llamada'); ?></th>
                                    <th><?php __('Añadido'); ?></th>
                                    <th id="actions" style="min-width: 150px !important;">
                                        <div class="row">
                                            <div class="col-6" id="col-1">

                                            </div>
                                            <div class="col-6" id="col-2">

                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="id_pro" id="id_pro" class="form-control input-sm"></td>
                                    <td><input type="hidden" name="type_pro" id="type_pro">
                                        <select name="type_pro_sel" id="type_pro_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="1"><?php __('Particular'); ?></option>
                                            <option value="2"><?php __('Constructor'); ?></option>
                                            <option value="3"><?php __('Banco'); ?></option>
                                       </select>
                                    </td>
                                    <td><input type="text" name="nombre_pro" id="nombre_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="apellidos_pro" id="apellidos_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="email_pro" id="email_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="telefono_fijo_pro" id="telefono_fijo_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="telefono_movil_pro" id="telefono_movil_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="status_pro" id="status_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="captado_por_pro" id="captado_por_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="fecha_alta_pro" id="fecha_alta_pro" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="next_call_pro" id="next_call_pro" class="form-control form-control-sm"></td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="12" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
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
    var numCols = 10;
    </script>

    <script src="/intramedianet/includes/assets/_custom/vendor/jquery.doubleScroll.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <script src="_js/owners-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
           $('.table-responsiveSCRLL').doubleScroll();
        });
    </script>

</body>
</html>
