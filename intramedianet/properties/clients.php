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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-house-person-return"></i> <?php echo __('Clientes'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#myModalCli"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('ID'); ?></th>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('Apellidos'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Teléfono'); ?></th>
                                    <th><?php __('Teléfono'); ?> 2</th>
                                    <th><?php __('Captado por'); ?></th>
                                    <th><?php __('Puntuación'); ?></th>
                                    <th><?php __('Estatus'); ?></th>
                                    <?php if($actUsuarios == 1) { ?>
                                    <th><?php __('Favoritos'); ?></th>
                                    <?php } ?>
                                    <th><?php __('Atendido'); ?></th>
                                    <th><?php __('Atendido por'); ?></th>
                                    <th><?php __('Próxima llamada'); ?></th>
                                    <th><?php  __('Registrado'); ?></th>
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
                                    <td><input type="text" name="id_cli" id="id_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="nombre_cli" id="nombre_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="apellidos_cli" id="apellidos_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="email_cli" id="email_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="telefono_fijo_cli" id="telefono_fijo_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="telefono_movil_cli" id="telefono_movil_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="fecha_alta_cli" id="fecha_alta_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="puntuacion_cli" id="puntuacion_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="status_cli" id="status_cli" class="form-control input-sm"></td>
                                    <?php if($actUsuarios == 1) { ?>
                                    <td><input type="text" name="total" id="total" class="form-control input-sm"></td>
                                    <?php } ?>
                                    <td><input type="hidden" name="atendido_cli" id="atendido_cli">

                                        <select name="atendido_cli_sel" id="atendido_cli_sel" class="form-control input-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>

                                    </td>
                                    <td><input type="text" name="atendido_por_cli" id="atendido_por_cli" class="form-control input-sm"></td>
                                    <td><input type="text" name="fecha_alta_cli" id="fecha_alta_cli" class="form-control input-sm"></td>
                                    <td><input type="hidden" name="usuario_cli" id="usuario_cli">

                                        <select name="usuario_cli_sel" id="usuario_cli_sel" class="form-control input-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>

                                    </td>
                                    <td><input type="text" name="next_call_cli" id="next_call_cli" class="form-control input-sm"></td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if($actUsuarios == 1) { ?>
                                    <td colspan="15" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                    <?php } else { ?>
                                    <td colspan="14" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                    <?php } ?>
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
    var numCols = <?php echo ($actUsuarios == 1)?15:14; ?>;
    var numColsAtendido = <?php echo ($actUsuarios == 1)?10:9; ?>;
    var numColsRegistrado = <?php echo ($actUsuarios == 1)?13:12; ?>;
    <?php if($actUsuarios == 1) { ?>
    var arrayColVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
    <?php } else { ?>
    var arrayColVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    <?php } ?>
    </script>

    <script src="/intramedianet/includes/assets/_custom/vendor/jquery.doubleScroll.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <script src="_js/clients-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
           $('.table-responsiveSCRLL').doubleScroll();
        });
    </script>

</body>
</html>
