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

$mapeo = 0;

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-list-check"></i> <?php echo __('Características'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="features-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                        <a href="features-order.php" class="btn btn-primary btn-sm"><i class="fa-regular fa-arrow-up-arrow-down me-1"></i> <?php __('Ordenar'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Característica'); ?></th>
                                    <?php if($mapeo == 1) { ?>
                                    <th><?php __('Se muestra en'); ?></th>
                                    <?php } ?>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="<?php echo 'feature_en_feat'; ?>" id="<?php echo 'feature_en_feat'; ?>" class="form-control form-control-sm"></td>
                                    <?php if($mapeo == 1) { ?>
                                    <td><input type="text" name="parent_feat" id="parent_feat" class="form-control form-control-sm"></td>
                                    <?php } ?>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
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
        <h1 class="pull-left"><i class="fa fa-list-ul"></i> <span><?php __('Características'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="features-form.php?KT_back=1" class="btn btn-success btn-sm"> <?php __('Añadir'); ?> </a>
            <a href="features-order.php" class="btn btn-primary btn-sm"><?php __('Ordenar'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Características'); ?></h3>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered" id="records-tables" width="100%">
                      <thead>
                        <tr>
                          <?php foreach($languages as $value) {  ?>
                          <th><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt=""> <?php __('Característica'); ?></th>
                          <?php } ?>
                          <?php if($mapeo == 1) { ?>
                          <th><?php __('Se muestra en'); ?></th>
                          <?php } ?>
                          <th id="actions"></th>
                        </tr>
                        <tr>
                          <?php foreach($languages as $value) {  ?>
                          <td><input type="text" name="<?php echo 'feature_' . $value . '_feat'; ?>" id="<?php echo 'feature_' . $value . '_feat'; ?>"></td>
                          <?php } ?>
                          <?php if($mapeo == 1) { ?>
                          <td><input type="text" name="parent_feat" id="parent_feat"></td>
                          <?php } ?>
                          <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr><?php if($mapeo == 1) { ?>
                          <td colspan="<?php echo count($languages)+2 ?>" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                          <?php } else { ?>
                          <td colspan="<?php echo count($languages)+1 ?>" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                          <?php } ?>

                        </tr>
                      </tbody>
                    </table>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php */ ?>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var numCols = <?php echo ($mapeo == 1)?2:1; ?>;
    </script>

    <script src="_js/features-list.js" type="text/javascript"></script>

</body>
</html>
