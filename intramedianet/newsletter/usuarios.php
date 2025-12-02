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
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-envelope-o"></i> <span><?php __('Newsletter'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="usuarios-form.php?KT_back=1" class="btn btn-success btn-sm"> <?php __('Añadir'); ?> </a>
            <a href="index.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <a href="newsletter-download-outlook.php" target="_blank" class="btn btn-info btn-sm pull-right downoutlook"> <?php __('Descargar para Outlook'); ?> </a>
                    <a href="newsletter-download-csv.php" target="_blank" class="btn btn-info btn-sm pull-right downcsv"> <?php __('Descargar para Excel'); ?> </a>
                    <h3 class="panel-title"><?php __('Usuarios'); ?></h3>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered" id="records-tables" width="100%">
                      <thead>
                        <tr>
                            <th><?php __('Nombre'); ?></th>
                            <th><?php __('Email'); ?></th>
                            <th><?php __('Fecha'); ?></th>
                            <th><?php __('Categorías'); ?></th>
                            <th id="actions"></th>
                        </tr>
                        <tr>
                          <td><input type="text" name="nombre_usr" id="nombre_usr" class="form-control input-sm"></td>
                          <td><input type="text" name="email_usr" id="email_usr" class="form-control input-sm"></td>
                          <td><input type="text" name="date_usr" id="date_usr" class="form-control input-sm"></td>
                          <td><input type="text" name="categoria_nws" id="categoria_nws" class="form-control input-sm"></td>
                          <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm search-clear"> <?php __('Limpiar'); ?> </a></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="<?php echo count($languages)+3 ?>" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                        </tr>
                      </tbody>
                    </table>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="/intramedianet/newsletter/_js/users-list.js" type="text/javascript"></script>

</body>
</html>
