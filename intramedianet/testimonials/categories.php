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

$query_rscategorias = "SELECT category_".$lang_adm."_ct as cat, id_ct, parent_ct FROM news_categories WHERE type_ct = 10 AND parent_ct = 0 ORDER BY orden_ct";
$rscategorias = mysqli_query($inmoconn, $query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);

function getChildsCatsTD($num,$par,$prof=0) {

    global $database_inmoconn, $inmoconn, $lang_adm;

    $query_rsmenuList = "SELECT category_".$lang_adm."_ct as cat, id_ct, parent_ct  FROM news_categories WHERE parent_ct  = ".$num." ORDER BY orden_ct ASC";
    $rsmenuList = mysqli_query($inmoconn, $query_rsmenuList) or die(mysqli_error());
    $row_rsmenuList = mysqli_fetch_assoc($rsmenuList);
    $totalRows_rsmenuList = mysqli_num_rows($rsmenuList);
    $cad = '';
    for($i=0; $i <= $prof; $i++){
        $cad .= '&#8212;&#8212; ';
    }

    $ret = '';
    do {
        if($row_rsmenuList['id_ct']!='') {

            $ret .= '<tr role="row">';
            $ret .= '<td>'.$cad.''.$row_rsmenuList['cat'].'</td>';
            $ret .= '<td class="actions"><a href="categories-form.php?id_ct=' . $row_rsmenuList['id_ct'] . '&amp;KT_back=1" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a> <a href="categories-form.php?id_ct=' . $row_rsmenuList['id_ct'] . '&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash-o"></i></a></td>';
            $ret .= '</tr>';
            $ret .= getChildsCatsTD($row_rsmenuList['id_ct'],$row_rsmenuList['id_ct'],$prof+1);
        }
    } while ($row_rsmenuList = mysqli_fetch_assoc($rsmenuList));
    mysqli_free_result ($rsmenuList);
    return( $ret );

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
        <h1 class="pull-left"><i class="fa fa-commenting-o"></i> <span><?php __('Noticias'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="categories-form.php?KT_back=1" class="btn btn-success btn-sm"> <?php __('Añadir'); ?> </a>
            <a href="categories-order.php" class="btn btn-primary btn-sm"><?php __('Ordenar'); ?>
            <a href="news.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Categorías'); ?></h3>
                </div>

                <div class="panel-body">

                    <div id="records-tables_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">

                                <table class="table table-striped table-bordered dataTable" id="records-tables" width="100%">
                                  <thead>
                                    <tr role="row">
                                      <th><?php __('Categoría'); ?></th>
                                      <th class="actions" id="actions"></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php do { ?>
                                        <tr role="row">
                                          <td><?php echo $row_rscategorias['cat'] ?></td>
                                          <td class="actions">
                                               <a href="categories-form.php?id_ct=<?php echo $row_rscategorias['id_ct'] ?>&amp;KT_back=1" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                               <a href="categories-form.php?id_ct=<?php echo $row_rscategorias['id_ct'] ?>&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash-o"></i></a>
                                          </td>
                                        </tr>
                                        <?php echo getChildsCatsTD($row_rscategorias['id_ct'],$row_rscategorias['parent_ct']); ?>
                                      <?php } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias)); ?>
                                  </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
