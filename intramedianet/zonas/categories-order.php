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


$query_rsCategories = "SELECT category_".$lang_adm."_ct as feat, id_ct as id, orden_ct FROM `news_categories` WHERE type_ct = 6 AND parent_ct = 0 ORDER BY orden_ct ASC";
$rsCategories = mysqli_query($inmoconn, $query_rsCategories) or die(mysqli_error());
$row_rsCategories = mysqli_fetch_assoc($rsCategories);

function getChilds($parent) {

    global $database_inmoconn, $inmoconn, $lang_adm;

    
    $query_rsChilds = "SELECT category_".$lang_adm."_ct as feat, id_ct as id, orden_ct FROM `news_categories` WHERE type_ct = 6 AND parent_ct = '" . $parent . "' ORDER BY orden_ct ASC";
    $rsChilds = mysqli_query($inmoconn, $query_rsChilds) or die(mysqli_error());
    $row_rsChilds = mysqli_fetch_assoc($rsChilds);
    $totalRows_rsChilds = mysqli_num_rows($rsChilds);

    if ($totalRows_rsChilds > 0) {
        echo '<ol class="dd-list">';
        do {
            echo '<li class="dd-item" data-id="' . $row_rsChilds['id'] . '">';
            echo '<div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div>';
            echo '<div class="dd-content">';
            echo '<a href="categories-form.php?id_ct=' . $row_rsChilds['id'] . '&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm pull-right delrow"><i class="fa fa-trash-o"></i></a>';
            echo '<a href="categories-form.php?id_ct=' . $row_rsChilds['id'] . '&amp;KT_back=1" class="btn btn-success btn-sm pull-right"><i class="fa fa-pencil"></i></a>';
            echo $row_rsChilds['feat'];
            echo '</div>';
            getChilds($row_rsChilds['id']);
            echo '</li>';
        } while ($row_rsChilds = mysqli_fetch_assoc($rsChilds));
        echo '</ol>';
    }

}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-newspaper-o"></i> <span><?php __('Zonas'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="categories-form.php?KT_back=1" class="btn btn-success btn-sm"> <?php __('Añadir'); ?> </a>
            <a href="/intramedianet/zonas/news.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Categorías'); ?></h3>
                </div>

                <div class="panel-body">

                    <div class="loading-ord"></div>

                    <div class="dd">
                        <ol class="dd-list">
                            <?php do { ?>
                            <li class="dd-item" data-id="<?php echo $row_rsCategories['id']; ?>">
                                <div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div>
                                <div class="dd-content">
                                    <a href="categories-form.php?id_ct=<?php echo $row_rsCategories['id'] ?>&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm pull-right delrow"><i class="fa fa-trash-o"></i></a>
                                    <a href="categories-form.php?id_ct=<?php echo $row_rsCategories['id'] ?>&amp;KT_back=1" class="btn btn-success btn-sm pull-right"><i class="fa fa-pencil"></i></a>
                                    <?php echo $row_rsCategories['feat']; ?>
                                </div>
                                <?php getChilds($row_rsCategories['id']); ?>
                            </li>
                            <?php } while ($row_rsCategories = mysqli_fetch_assoc($rsCategories)); ?>
                        </ol>
                    </div>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="/intramedianet/zonas/_js/categories-order.js" type="text/javascript"></script>

</body>
</html>
