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

$query_rsConsulta = "SELECT image_ban as img, id_ban as id FROM `banners`  ORDER BY orden_ban ASC";
$rsConsulta = mysqli_query($inmoconn, $query_rsConsulta) or die(mysqli_error());
$row_rsConsulta = mysqli_fetch_assoc($rsConsulta);

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-arrow-up-arrow-down"></i> <a href="index.php"><?php echo __('Banner'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php __('Ordenar'); ?></h4>
                    <div class="flex-shrink-0">
                        <div class="loading-ord d-inline-block fs-5 me-3"></div>
                        <a href="index.php" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-angle-left me-1"></i> <?php __('Volver'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="list-group nested-list nested-sortable-handle">
                        <?php $i = 1; ?>
                        <?php do { ?>
                        <div class="list-group-item nested-2" data-id="<?php echo $row_rsConsulta['id']; ?>">
                            <i class="fa-regular fa-bars align-bottom handle text-muted opacity-25 mt-4 fs-2"></i>
                            <img src="<?php echo "/media/images/banner/" . $row_rsConsulta['img']; ?>" alt="" class="rounded" height="70">
                        </div>
                        <?php } while ($row_rsConsulta = mysqli_fetch_assoc($rsConsulta)); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="/intramedianet/banner/_js/banner-order.js" type="text/javascript"></script>

</body>
</html>
