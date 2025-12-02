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
            <a href="categories-form.php?KT_back=1" class="btn btn-success btn-sm"> <?php __('Añadir'); ?> </a>
            <a href="index.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Categorías'); ?></h3>
                </div>

                <div class="panel-body">

                <table class="table table-striped table-bordered" id="records-tables" width="100%">
                  <thead>
                    <tr>
                      <?php foreach($languages as $value) {  ?>
                      <th><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt=""> <?php __('Categoría'); ?></th>
                      <?php } ?>
                      <th id="actions"></th>
                    </tr>
                    <tr>
                      <?php foreach($languages as $value) {  ?>
                      <td><input type="text" name="<?php echo 'category_' . $value . '_cts'; ?>" id="<?php echo 'category_' . $value . '_cts'; ?>" class="form-control input-sm"></td>
                      <?php } ?>
                      <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm search-clear"> <?php __('Limpiar'); ?> </a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="<?php echo count($languages)+1 ?>" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var numCols = <?php echo count($languages); ?>;
    </script>

    <script src="/intramedianet/newsletter/_js/categories-list.js" type="text/javascript"></script>

</body>
</html>
