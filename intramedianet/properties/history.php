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
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ( (isset($_COOKIE['sidebarComp'])) && ($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-landmark"></i> <?php echo __('Historialpropiedades'); ?></h4>
                    <div class="flex-shrink-0 panel-heading">
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Usuario'); ?></th>
                                    <th><?php __('Referencia'); ?></th>
                                    <th><?php __('Acción'); ?></th>
                                    <th><?php __('Fecha'); ?></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="usuario" id="usuario" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="referencia" id="referencia" class="form-control form-control-sm"></td>
                                    <td><input type="hidden" name="accion" id="accion">
                                    <select name="accion_sel" id="accion_sel" class="form-control form-control-sm">
                                        <option value=""><?php __('Todos'); ?></option>
                                        <option value="1"><?php __('Añadido'); ?></option>
                                        <option value="2"><?php __('Editado'); ?></option>
                                        <option value="3"><?php __('Editado: Bajada de precio'); ?></option>
                                        <option value="4"><?php __('Editado: Subida de precio'); ?></option>
                                        <option value="5"><?php __('Borrado'); ?></option>
                                    </select></td>
                                    <td><input type="text" name="fecha" id="fecha" class="form-control form-control-sm"></td>
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

    <?php /* ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-history"></i> <span><?php __('Historialpropiedades'); ?></span></h1>

    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Historialpropiedades'); ?></h3>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered" id="records-tables" width="100%">
                        <thead>
                        <tr>
                          <th><?php __('Usuario'); ?></th>
                          <th><?php __('Referencia'); ?></th>
                          <th><?php __('Acción'); ?></th>
                          <th><?php __('Fecha'); ?></th>
                        </tr>
                        <tr>
                          <td><input type="text" name="usuario" id="usuario" class="form-control"></td>
                          <td><input type="text" name="referencia" id="referencia" class="form-control"></td>
                          <td><input type="hidden" name="accion" id="accion">
                                <select name="accion_sel" id="accion_sel" class="form-control">
                                    <option value=""><?php __('Todos'); ?></option>
                                    <option value="1"><?php __('Añadido'); ?></option>
                                    <option value="2"><?php __('Editado'); ?></option>
                                    <option value="3"><?php __('Editado: Bajada de precio'); ?></option>
                                    <option value="4"><?php __('Editado: Subida de precio'); ?></option>
                                    <option value="5"><?php __('Borrado'); ?></option>
                                </select></td>
                          <td><input type="text" name="fecha" id="fecha" class="form-control"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <tr>
                          <td colspan="4" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php */ ?>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="_js/report-history-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
