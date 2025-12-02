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
                <div class="card-header align-items-center d-flex">
                    <div class="flex-grow-1 oveflow-hidden">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-comment-question"></i> <?php echo __('Consultas'); ?></h4>
                    </div>
                    <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="enquiries.php" role="tab" aria-selected="true">
                                    <?php if($totalRows_rsConsultas > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultas; ?></span><?php } ?>
                                    <?php __('Consultas'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="bajada.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsbajadasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?>
                                    <?php __('Bajada de precios'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="consultas.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsConsultasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultasCount; ?></span><?php } ?>
                                    <?php __('Formulario de contacto'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="whatsapp.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsConsultasWhatsapp > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultasWhatsapp; ?></span><?php } ?>
                                    <?php __('Whatsapp'); ?>
                                </a>
                            </li>
                            <?php if ($actPortalsEnquiries == 1): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="/intramedianet/email/email.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php __('Portales'); ?>
                                </a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>

                <div class="card-body">

                    <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link active" href="enquiries.php" role="tab" aria-selected="true">
                                <?php if($totalRows_rsConsultas > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultas; ?></span><?php } ?>
                                <?php __('Consultas'); ?>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="bajada.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php if($totalRows_rsbajadasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?>
                                <?php __('Bajada de precios'); ?>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="consultas.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php if($totalRows_rsConsultasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultasCount; ?></span><?php } ?>
                                <?php __('Formulario de contacto'); ?>
                            </a>
                        </li>
                        <?php if ($actPortalsEnquiries == 1): ?>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="/intramedianet/email/email.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php __('Portales'); ?>
                            </a>
                        </li>
                        <?php endif ?>
                    </ul>

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Inmueble'); ?></th>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('Teléfono'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Enviado'); ?></th>
                                    <th><?php __('Respondido'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="inmueble_cons" id="inmueble_cons" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="nombre_cons" id="nombre_cons" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="telefono_cons" id="telefono_cons" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="email_cons" id="email_cons" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="fecha_cons" id="fecha_cons" class="form-control form-control-sm"></td>
                                    <td><input type="hidden" name="read_cons" id="read_cons">
                                        <select name="read_cons_sel" id="read_cons_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="1"><?php __('Sí'); ?></option>
                                            <option value="0"><?php __('No'); ?></option>
                                        </select>
                                    </td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
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

    <?php /* ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-envelope-o"></i> <span><?php __('Consultas'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Consultas'); ?></h3>
                </div>

                <div class="panel-body">

                    <ul class="nav nav-tabs">
                      <li class="active"><a href="enquiries.php"><?php __('Consultas'); ?> <?php if($totalRows_rsConsultas > 0) { ?><span class="label label-danger"><?php echo $totalRows_rsConsultas; ?></span><?php } ?></a></li>
                      <li><a href="bajada.php"><?php __('Bajada de precios'); ?> <?php if($totalRows_rsbajadasCount > 0) { ?><span class="label label-danger"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?></a></li>
                      <li><a href="consultas.php"><?php __('Formulario de contacto'); ?> <?php if($totalRows_rsConsultasCount > 0) { ?><span class="label label-danger"><?php echo $totalRows_rsConsultasCount; ?></span><?php } ?></a></li>
                    </ul>

                    <br>

                    <table class="table table-striped table-bordered" id="records-tables" width="100%">
                        <thead>
                            <tr>
                                <th><?php __('Inmueble'); ?></th>
                                <th><?php __('Nombre'); ?></th>
                                <th><?php __('Teléfono'); ?></th>
                                <th><?php __('Email'); ?></th>
                                <th><?php __('Enviado'); ?></th>
                                <th><?php __('Respondido'); ?></th>
                                <th id="actions"></th>
                            </tr>
                            <tr>
                                <td><input type="text" name="inmueble_cons" id="inmueble_cons" class="form-control input-sm"></td>
                                <td><input type="text" name="nombre_cons" id="nombre_cons" class="form-control input-sm"></td>
                                <td><input type="text" name="telefono_cons" id="telefono_cons" class="form-control input-sm"></td>
                                <td><input type="text" name="email_cons" id="email_cons" class="form-control input-sm"></td>
                                <td><input type="text" name="fecha_cons" id="fecha_cons" class="form-control input-sm"></td>
                                <td><input type="hidden" name="read_cons" id="read_cons">
                                    <select name="read_cons_sel" id="read_cons_sel" class="form-control input-sm">
                                        <option value=""><?php __('Todos'); ?></option>
                                        <option value="1"><?php __('Sí'); ?></option>
                                        <option value="0"><?php __('No'); ?></option>
                                    </select>
                                </td>
                                <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
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

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php */ ?>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="_js/enquiries-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
