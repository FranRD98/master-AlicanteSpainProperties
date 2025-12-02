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

$query_rsCategories = "SELECT title_".$lang_adm."_nws as feat, id_nws as id, order_nws FROM `news` WHERE type_nws = 999 AND activate_nws = 1 ORDER BY order_nws ASC";
$rsCategories = mysqli_query($inmoconn, $query_rsCategories) or die(mysqli_error());
$row_rsCategories = mysqli_fetch_assoc($rsCategories);

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-newspaper"></i> <a href="news.php"><?php echo __('Promociones'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php __('Ordenar'); ?></h4>
                    <div class="flex-shrink-0">
                        <div class="loading-ord d-inline-block fs-5 me-3"></div>
                        <a href="news.php" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-angle-left me-1"></i> <?php __('Volver'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="list-group nested-list nested-sortable-handle">
                        <?php $i = 1; ?>
                        <?php do { ?>
                        <div class="list-group-item nested-2" data-id="<?php echo $row_rsCategories['id']; ?>">
                            <i class="fa-regular fa-bars align-bottom handle text-muted opacity-25 mt-0 fs-2"></i>
                            <?php echo $row_rsCategories['feat']; ?>
                        </div>
                        <?php } while ($row_rsCategories = mysqli_fetch_assoc($rsCategories)); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="/intramedianet/promotions/_js/promotions-order.js" type="text/javascript"></script>

</body>
</html>
