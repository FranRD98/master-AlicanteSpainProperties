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

$query_rscategorias = "SELECT category_en_ct as cat, id_ct, parent_ct FROM news_categories WHERE type_ct = 6 AND parent_ct = 0 ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn, $query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-location-dot"></i> <a href="news.php"><?php echo __('Zonas'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php __('Costas'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="categories-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Costas'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php do { ?>
                                  <tr role="row">
                                    <td><?php echo $row_rscategorias['cat'] ?></td>
                                    <td class="actions" style="width: 81px;">
                                         <a href="categories-form.php?id_ct=<?php echo $row_rscategorias['id_ct'] ?>&amp;KT_back=1" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                         <a href="categories-form.php?id_ct=<?php echo $row_rscategorias['id_ct'] ?>&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa-regular fa-trash-can"></i></a>
                                    </td>
                                  </tr>
                                <?php } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias)); ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
