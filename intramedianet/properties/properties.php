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
$theFavs[0] = '';
if(isset($_COOKIE['favadm']))
    $theFavs = explode(",",$_COOKIE['favadm']);
$theFavs2 = array();
foreach ($theFavs as $value) {
    array_push($theFavs2, "'".$value."'");
}

$theFavs3 = implode(',', $theFavs2);

// print_r($theFavs2);

if ($_SESSION['kt_login_level'] == 7) {
    $totCols = 12;
} else {
    $totCols = 14;
}


if ($actPropietarios == 1) {
    $totCols = $totCols+1;
}

if($showprecioReduc == 1) {
    $totCols = $totCols + 1;
}
if ($xmlImport == 1) {
    $totCols = $totCols + 3;
}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php if(isset($_COOKIE['sidebarComp'])){echo ($_COOKIE['sidebarComp'] != '')?$_COOKIE['sidebarComp']:'lg'; } ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1 d-none d-md-block"><i class="fa-regular fa-building"></i> <?php echo __('Inmuebles'); ?></h4>
                    <div class="flex-shrink-0">
                        <?php if($_SESSION['kt_login_level'] == 9) { ?>
                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#myModalProp"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?> <?php __('Inmueble'); ?></a>
                        <?php } ?>
                        <?php if ($_SESSION['kt_login_level'] == 9): ?>
                        <a href="/intramedianet/properties/properties-all-download-csv.php" class="btn btn-primary btn-sm "><i class="fa-regular fa-file-excel me-1"></i> <?php __('Descargar para Excel'); ?></a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">

                    <?php if($theFavs[0] != '') { ?>
                    <div class="float-end">
                        <a href="/<?php echo $lang_adm ?>/favorites-print/" class="btn btn-primary btn-sm" target="_blank"><i class="fa-regular fa-star me-1"></i> <?php __('Imprimir Parte de Visitas'); ?> (<?php echo count($theFavs) ?>)</a>
                        <a href="fav-del-all.php" class="btn btn-danger btn-sm"><i class="fa-regular fa-trash-can me-1"></i> <?php __('Eliminar todos los favoritos'); ?></a>
                    </div>
                     <br>
                     <br>
                    <?php }  ?>

                    <div class="table-responsive clearfix mt-n2">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-truncate"><?php __('Imagen'); ?></th>
                                    <th class="text-truncate"><?php __('Referencia'); ?><?php echo str_repeat("&nbsp;", 6); ?></th>
                                    <th class="text-truncate"><?php __('Operación'); ?></th>
                                    <th class="text-truncate"><?php __('Tipo'); ?></th>
                                    <th class="text-truncate"><?php __('Ciudad'); ?></th>
                                    <th class="text-truncate"><?php __('Zona'); ?></th>
                                    <?php if ($_SESSION['kt_login_level'] != 7): ?>
                                    <th class="text-truncate"><?php __('Dirección'); ?></th>
                                    <?php if ($actPropietarios == 1) { ?><th class="text-truncate"><?php __('Propietario'); ?></th><?php } ?>
                                    <?php endif ?>
                                    <th class="text-truncate"><?php __('Precio'); ?></th>
                                    <th class="text-truncate"><?php __('Destacado'); ?></th>
                                    <th class="text-truncate"><?php __('Activado'); ?></th>
                                    <th class="text-truncate"><?php __('Vendido'); ?></th>
                                    <?php if($showprecioReduc == 1) { ?>
                                    <th class="text-truncate"><?php __('Oferta'); ?></th>
                                    <?php } ?>
                                    <th class="text-truncate"><?php __('Unidades'); ?></th>
                                    <?php if ($xmlImport == 1) { ?>
                                    <th class="text-truncate"><?php __('Oculto'); ?></th>
                                    <th class="text-truncate"><?php __('Proveedor'); ?></th>
                                    <th class="text-truncate"><?php __('XML Ref.'); ?></th>
                                    <?php }   ?>
                                    <th class="text-truncate"><?php __('Añadido'); ?></th>
                                    <th id="actions" style="min-width: 150px !important;">
                                        <div class="row">
                                            <div class="col-6" id="col-1">

                                            </div>
                                            <div class="col-6" id="col-2">

                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="search-inputs">
                                    <td><input type="hidden" name="image_img" id="image_img" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="referencia_prop" id="referencia_prop" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="status_en_sta" id="status_en_sta" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="types_en_typ" id="types_en_typ" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="town_en_twn" id="town_en_twn" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="zona_en_twn" id="zona_en_twn" class="form-control form-control-sm"></td>
                                    <?php if ($_SESSION['kt_login_level'] != 7): ?>
                                    <td><input type="text" name="direccion_prop" id="direccion_prop" class="form-control form-control-sm"></td>
                                        <?php if ($actPropietarios == 1) { ?><td><input type="text" name="owner_prop" id="owner_prop" class="form-control form-control-sm"></td><?php } ?>
                                    <?php endif ?>
                                    <td><input type="text" name="precio" id="precio" class="form-control form-control-sm"></td>
                                    <td><input type="hidden" name="destacado_prop" id="destacado_prop">

                                        <select name="destacado_prop_sel" id="destacado_prop_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>

                                    </td>
                                    <td><input type="hidden" name="activado_prop" id="activado_prop">

                                        <select name="activado_prop_sel" id="activado_prop_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>

                                    </td>
                                    <td><input type="hidden" name="vendido_prop" id="vendido_prop">

                                        <select name="vendido_prop_sel" id="vendido_prop_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>

                                    </td>
                                    <?php if($showprecioReduc == 1) { ?>
                                    <td><input type="hidden" name="oferta_prop" id="oferta_prop">

                                        <select name="oferta_prop_sel" id="oferta_prop_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>

                                    </td>
                                    <?php } ?>
                                    <td><input type="text" name="units_prop" id="units_prop" class="form-control form-control-sm"></td>
                                    <?php if ($xmlImport == 1) { ?>
                                    <td><input type="hidden" name="force_hide_prop" id="force_hide_prop">

                                        <select name="force_hide_prop_sel" id="force_hide_prop_sel" class="form-select form-select-sm">
                                            <option value=""><?php __('Todos'); ?></option>
                                            <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                            <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                       </select>

                                    </td>
                                    <td><input type="text" name="proveedor" id="proveedor" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="ref_xml_prop" id="ref_xml_prop" class="form-control form-control-sm"></td>
                                    <?php }  ?>
                                    <td><input type="text" name="inserted_xml_prop" id="inserted_xml_prop" class="form-control form-control-sm"></td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 search-clear"> <?php __('Limpiar'); ?> </a></th>
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
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script type="text/javascript">
        var numCols = <?php echo $totCols - 1 ?>;
        var langs = ['<?php echo implode("','", $languages); ?>'];
        var host = '<?php echo $_SERVER['HTTP_HOST'] ?>';
        var theFavs = Array(<?php echo $theFavs3 ?>);
        var theFavsNum = <?php echo count($theFavs2) ?>;
        var showprecioReduc = <?php echo ($showprecioReduc == 1)?1:0 ?>;
        var xmlImport = <?php echo ($xmlImport == 1)?1:0 ?>;
        var non = '<?php echo $lang['No'] ?>';

        <?php if ($_SESSION['kt_login_level'] != 7): ?>
            // CONFIGURACIÓN DE LAS COLUMNAS:
            <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
            var ocultarCols = [6]; // COLUMNAS OCULTAS POR DEFECTO
            <?php else: ?>
            var ocultarCols = [5, 12, 13]; // COLUMNAS OCULTAS POR DEFECTO
            <?php endif ?>
            var destacado_propCol = 9; // POSICIÓN DE LA COLUMNA DESTACADO
            var activado_propCol = 10; // POSICIÓN DE LA COLUMNA ACTIVADO
            var vendido_propCol = 11; // POSICIÓN DE LA COLUMNA VENDIDO
            var oferta_propCol = 12; // POSICIÓN DE LA COLUMNA OFERTA
            var force_hide_propCol = showprecioReduc == 1 && xmlImport == 1 ? 14 : 13; // POSICIÓN DE LA COLUMNA OCULTAR
            if (xmlImport == 0) {
                var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
            } else {
                var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
            }
            var sortval = 13;
        <?php else : ?>
            // CONFIGURACIÓN DE LAS COLUMNAS:
            var ocultarCols = []; // COLUMNAS OCULTAS POR DEFECTO
            var destacado_propCol = 7; // POSICIÓN DE LA COLUMNA DESTACADO
            var activado_propCol = 8; // POSICIÓN DE LA COLUMNA ACTIVADO
            var vendido_propCol = 9; // POSICIÓN DE LA COLUMNA VENDIDO
            var oferta_propCol = 10; // POSICIÓN DE LA COLUMNA OFERTA
            var force_hide_propCol = showprecioReduc == 1 && xmlImport == 1 ? 12 : 11; // POSICIÓN DE LA COLUMNA OCULTAR
            if (xmlImport == 0) {
                var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11];
            } else {
                var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14];
            }
            var sortval = 11;
        <?php endif ?>


        // DEFINIMOS LAS COLUMNAS EXTRA
        var extraColDef = [];
        if(showprecioReduc == 1) {
            extraColDef.push({
                "render": function ( data, type, row ) {
                    var changeV = data == non ? 1: 0;
                    var bntImage = data == non ? '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>': '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
                    return '<a href="properties-change.php?s=oferta_prop&v='+changeV+'&id_prop=' +  row[numCols] + '" class="update-status">'+bntImage+'</a>';
                },
                "targets": oferta_propCol
            });
            var sortval = sortval + 1;
        }

        if(xmlImport == 1) {
            extraColDef.push({
                "render": function ( data, type, row ) {
                    var changeV = data == non ? 1: 0;
                    var bntImage = data == non ? '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>': '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
                    return '<a href="properties-change.php?s=force_hide_prop&v='+changeV+'&id_prop=' +  row[numCols] + '" class="update-status">'+bntImage+'</a>';
                },
                "targets": force_hide_propCol
            });
            var sortval = sortval + 3;
        }

    </script>

    <script src="/intramedianet/includes/assets/_custom/vendor/jquery.doubleScroll.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <script src="_js/properties-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
           $('.table-responsiveSCRLL').doubleScroll();
        });
    </script>

    <script>
    $(document).on('click', '.btn-img-list-carr', function(e) {
        e.preventDefault();
        $elm = $(this);

        $('#myModalImg .modal-body').html('');


        $('#myModalImg').modal('show');
        $('#myModalImg .modal-header h5').html('<i class="fa-regular fa-images me-1"></i> ' + $elm.data('title'));


        $.get('/intramedianet/properties/get-imgs.php?p='+ $elm.data('id')).done(function(data) {
            if (data != '') {
                $('#myModalImg .modal-body').html(data);
            }
        });
    });

    $(document).on('click', '.btn-print-prop', function(e) {
        e.preventDefault();
        $elm = $(this);

        $('#idprint').val($elm.data('id'));

        $('#myModalPrint').modal('show');
    });

    $(document).on('click', '.btn-print-modal', function(e) {
        e.preventDefault();
        $elm = $(this);

        var id = $("input[name='idprint']").val();
        var template = $("input[name='template']:checked").val();
        var size = $("input[name='tamano']:checked").val();
        var lang = $("input[name='language']:checked").val();

        url = '/modules/property/save' + size + '' + template + '.php?id=' + id + '&lang=' + lang + '';

        window.open(url);
        $('#myModalPrint').modal('hide');
    });
    </script>

    <div id="myModalImg" class="modal fade" tabindex="-1" aria-labelledby="myModalImgLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel2"><i class="fa-regular fa-print me-1"></i> <?php __('Imprimir') ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light"></div>
                <div class="modal-footer bg-soft-primary">
                    <button type="button" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModalPrint" class="modal fade" tabindex="-1" aria-labelledby="myModalPrintLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel2"><i class="fa-regular fa-print me-1"></i> <?php __('Imprimir') ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                    <form action="#">
                        <input type="hidden" id="idprint" name="idprint">

                        <legend class="fs-5 border-bottom"><?php __('Plantilla') ?></legend>

                        <div class="form-check form-switch form-switch-md mb-3 d-inline-block me-4" dir="ltr">
                            <input type="radio" name="template" id="template1" value="" class="form-check-input" checked>
                            <label class="form-check-label" for="template1">Website</label>
                        </div>

                        <div class="form-check form-switch form-switch-md mb-3 d-inline-block" dir="ltr">
                            <input type="radio" name="template" id="template2" value="-mb" class="form-check-input">
                            <label class="form-check-label" for="template2"><?php __('Marca blanca') ?></label>
                        </div>

                        <br>

                        <legend class="fs-5 border-bottom clearfix"><?php __('Tamaño') ?></legend>

                        <div class="form-check form-switch form-switch-md mb-3 d-inline-block me-4" dir="ltr">
                            <input type="radio" name="tamano" id="tamano1" value="" class="form-check-input" checked>
                            <label class="form-check-label" for="tamano1">A4</label>
                        </div>

                        <div class="form-check form-switch form-switch-md mb-3 d-inline-block" dir="ltr">
                            <input type="radio" name="tamano" id="tamano2" value="-a3" class="form-check-input">
                            <label class="form-check-label" for="tamano2">A3</label>
                        </div>

                        <br>

                        <legend class="fs-5 border-bottom clearfix"><?php __('Idioma') ?></legend>

                        <?php foreach($languages as $value) { ?>
                            <div class="form-check form-switch form-switch-md mb-3 d-inline-block me-3" dir="ltr">
                                <input type="radio" name="language" id="language-<?php echo $value; ?>" value="<?php echo $value; ?>" class="form-check-input" <?php if ($lang_adm == $value): ?>checked<?php endif ?>>
                                <label class="form-check-label" for="language-<?php echo $value; ?>"><img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value; ?>.svg" alt="" class="border rounded-circle" height="20"></label>
                            </div>
                        <?php } ?>
                    </form>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <button type="button" class="btn btn-primary btn-sm mt-4 btn-print-modal" data-dismiss="modal"><i class="fa-regular fa-print"></i> <?php __('Imprimir') ?></button>
                    <button type="button" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
