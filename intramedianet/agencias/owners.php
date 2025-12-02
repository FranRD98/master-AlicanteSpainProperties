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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-id-card-clip"></i> <?php echo __('Agencias'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="owners-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr class="align-top">
                                    <th><?php __('Nombre de agencia'); ?></th>
                                    <th><?php __('Nombre'); ?></th>
                                    <!-- <th><?php __('Apellidos'); ?></th> -->
                                    <th><?php __('Email'); ?></th>
    <!--                                 <th><?php __('Email'); ?> 2</th>
                                    <th><?php __('Email'); ?> 3</th> -->
                                    <th><?php __('Teléfono'); ?></th>
                                    <th><?php __('Móvil'); ?></th>
                                    <!-- <th><?php __('Teléfono'); ?> 3</th> -->
                                    
                                    <th><?php __('CIF'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input class="form-control form-control-sm" type="text" name="referencia_cnt" id="referencia_cnt"></td>
                                    <td><input class="form-control form-control-sm" type="text" name="nombre_pro" id="nombre_pro"></td>
                                    <!-- <td><input class="form-control form-control-sm" type="text" name="apellidos_pro" id="apellidos_pro"></td> -->
                                    <td><input class="form-control form-control-sm" type="text" name="email_pro" id="email_pro"></td>
    <!--                            <td><input class="form-control form-control-sm" type="text" name="email2_pro" id="email2_pro"></td>
                                    <td><input class="form-control form-control-sm" type="text" name="email3_pro" id="email3_pro"></td> -->
                                    <td><input class="form-control form-control-sm" type="text" name="telefono_fijo_pro" id="telefono_fijo_pro"></td>
                                    <td><input class="form-control form-control-sm" type="text" name="telefono_movil_pro" id="telefono_movil_pro"></td>
                                    <!-- <td><input class="form-control form-control-sm" type="text" name="telefono_movil2_pro" id="telefono_movil2_pro"></td> -->
                                    
                                    <td><input class="form-control form-control-sm" type="text" name="fecha_alta_pro" id="fecha_alta_pro"></td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
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
    var numCols = 5;
    </script>

    <script src="_js/owners-list.js?id=<?php echo time();?>" type="text/javascript"></script>

</body>
</html>
