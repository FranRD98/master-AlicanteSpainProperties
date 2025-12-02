<?php
// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

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

$theFavs = explode(",",$_COOKIE['favadm']);
$theFavs2 = array();
foreach ($theFavs as $value) {
    array_push($theFavs2, "'".$value."'");
}

$theFavs3 = implode(',', $theFavs2);

// print_r($theFavs2);

$totCols = 12;

if($showprecioReduc == 1) {
    $totCols = $totCols + 1;
}
if ($xmlImport == 1) {
    $totCols = $totCols + 4;
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
        <h1 class="pull-left"><i class="fa fa-building-o"></i> <span><?php __('Inmuebles'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
        <?php if($_SESSION['kt_login_level'] == 9) { ?>
            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModalProp"> <?php __('Añadir'); ?> </a>
            <?php } ?>
            <?php if($theFavs[0] != '') { ?>
            <a href="/<?php echo $lang_adm ?>/favorites-print/" class="btn btn-primary btn-sm" target="_blank"> <?php __('Favoritos'); ?> (<?php echo count($theFavs) ?>)</a>
            <a href="fav-del-all.php" class="btn btn-danger btn-sm"><?php __('Eliminar todos los favoritos'); ?></a>
            <?php }  ?>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <a href="search-properties.php?KT_back=1" class="btn btn-info btn-sm pull-right"> <?php __('Búsqueda avanzada'); ?> </a>
                    <h3 class="panel-title"><?php __('Inmuebles'); ?></h3>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered" id="records-tables" width="100%">
                      <thead>
                        <tr>
                            <th><?php __('Imágen'); ?></th>
                            <th><?php __('Referencia'); ?><?php echo str_repeat("&nbsp;", 6); ?></th>
                            <th><?php __('Operación'); ?></th>
                            <th><?php __('Tipo'); ?></th>
                            <th><?php __('Ciudad'); ?></th>
                            <th><?php __('Zona'); ?></th>
                            <th><?php __('Dirección'); ?></th>
                            <th><?php __('Propietario'); ?></th>
                            <th><?php __('Precio'); ?></th>
                            <th><?php __('Destacado'); ?></th>
                            <th><?php __('Activado'); ?></th>
                            <?php if($showprecioReduc == 1) { ?>
                            <th><?php __('Oferta'); ?></th>
                            <?php } ?>
                            <?php if ($xmlImport == 1) { ?>
                            <th><?php __('Oculto'); ?></th>
                            <th><?php __('Proveedor'); ?></th>
                            <th><?php __('XML Ref.'); ?></th>
                            <th><?php __('Importado'); ?></th>
                            <?php }   ?>
                            <th id="actionsOrder">
                                <div class="row">
                                    <div class="col-xs-8" id="col-1">

                                    </div>
                                    <div class="col-xs-4" id="col-2">

                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="image_img" id="image_img" class="form-control input-sm"></td>
                            <td><input type="text" name="referencia_prop" id="referencia_prop" class="form-control input-sm"></td>
                            <td><input type="text" name="status_en_sta" id="status_en_sta" class="form-control input-sm"></td>
                            <td><input type="text" name="types_en_typ" id="types_en_typ" class="form-control input-sm"></td>
                            <td><input type="text" name="town_en_twn" id="town_en_twn" class="form-control input-sm"></td>
                            <td><input type="text" name="zona_en_twn" id="zona_en_twn" class="form-control input-sm"></td>
                            <td><input type="text" name="direccion_prop" id="direccion_prop" class="form-control input-sm"></td>
                            <td><input type="text" name="owner_prop" id="owner_prop" class="form-control input-sm"></td>
                            <td><input type="text" name="precio" id="precio" class="form-control input-sm"></td>
                            <td><input type="hidden" name="destacado_prop" id="destacado_prop">

                                <select name="destacado_prop_sel" id="destacado_prop_sel" class="form-control input-sm">
                                    <option value=""><?php __('Todos'); ?></option>
                                    <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                    <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                               </select>

                            </td>
                            <td><input type="hidden" name="activado_prop" id="activado_prop">

                                <select name="activado_prop_sel" id="activado_prop_sel" class="form-control input-sm">
                                    <option value=""><?php __('Todos'); ?></option>
                                    <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                    <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                               </select>

                            </td>
                            <?php if($showprecioReduc == 1) { ?>
                            <td><input type="hidden" name="oferta_prop" id="oferta_prop">

                                <select name="oferta_prop_sel" id="oferta_prop_sel" class="form-control input-sm">
                                    <option value=""><?php __('Todos'); ?></option>
                                    <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                    <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                               </select>

                            </td>
                            <?php } ?>
                            <?php if ($xmlImport == 1) { ?>
                            <td><input type="hidden" name="force_hide_prop" id="force_hide_prop">

                                <select name="force_hide_prop_sel" id="force_hide_prop_sel" class="form-control input-sm">
                                    <option value=""><?php __('Todos'); ?></option>
                                    <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                    <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                               </select>

                            </td>
                            <td><input type="text" name="proveedor" id="proveedor" class="form-control input-sm"></td>
                            <td><input type="text" name="ref_xml_prop" id="ref_xml_prop" class="form-control input-sm"></td>
                            <td><input type="text" name="inserted_xml_prop" id="inserted_xml_prop" class="form-control input-sm"></td>
                            <?php }  ?>
                            <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="<?php echo $totCols; ?>" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                        </tr>
                      </tbody>
                    </table>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script type="text/javascript">
        var numCols = <?php echo $totCols - 1 ?>;
        var langs = ['<?php echo implode("','", $languages); ?>'];
        var host = '<?php echo $_SERVER['HTTP_HOST'] ?>';
        var theFavs = Array(<?php echo $theFavs3 ?>);
        var theFavsNum = <?php echo count($theFavs2) ?>;
        var showprecioReduc = <?php echo ($showprecioReduc == 1)?1:0 ?>;
        var xmlImport = <?php echo ($xmlImport == 1)?1:0 ?>;

    </script>

    <script src="_js/properties-list.js?435764545243" type="text/javascript"></script>

</body>
</html>
