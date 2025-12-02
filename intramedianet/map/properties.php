<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
include_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// Cargamos los idiomas de la administración
include_once($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');

// Load the tNG classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

// Load the Navigation classes
require_once('../../includes/nav/NAV.php');

// Load the common classes
require_once('../../includes/common/KT_common.php');

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

require_once('queries-buscador.php');

//  ============================================================================
//  === STATUS
//  ============================================================================

$st = '';
if( isset($_GET['st']) && $_GET['st'][0] != '' ){
    $val = implode(',', $_GET['st']);
    if ($val != '') {
        $st = "AND operacion_prop  IN (" . simpleSanitize($val) . ")";
    }
}

//  ============================================================================
//  === TYPE
//  ============================================================================

$typ = '';
if( isset($_GET['tp']) && $_GET['tp'] != '' ){
    $val = implode(',', $_GET['tp']);
    if ($val  != '') {
        $typ = "AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . simpleSanitize($val) . ")";
    }
}

//  ============================================================================
//  === PROVINCE
//  ============================================================================

$lopr = '';
if( isset($_GET['lopr']) && $_GET['lopr'] != '' ){
    $val = implode(',', $_GET['lopr']);
    if ($val != '') {
        $lopr = "AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (" . simpleSanitize($val) . ")";
    }
}

//  ============================================================================
//  === CITY
//  ============================================================================

$loct = '';
if( isset($_GET['loct']) && $_GET['loct'] != '' ){
    $val = implode(',', $_GET['loct']);
    if ($val != '') {
        $loct = "AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (" . simpleSanitize($val) . ")";
    }
}

//  ============================================================================
//  === ZONE
//  ============================================================================

$lozn = '';
if( isset($_GET['lozn']) && $_GET['lozn'] != '' ){
    $val = implode(',', $_GET['lozn']);
    if ($val != '') {
        $lozn = "AND CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END IN (" . simpleSanitize($val) . ")";
    }
}

//  ============================================================================
//  === PRICE -> MINI SEARCH
//  ============================================================================

$prds = '';
if ( isset($_GET['prds']) && $_GET['prds'] != '' ) {
    $prds = "AND preci_reducidoo_prop >= " . simpleSanitize(($_GET['prds']));
}

$prhs = '';
if ( isset($_GET['prhs']) && $_GET['prhs'] != '' && $_GET['prhs'] != '1000000' ) {
    $prhs = "AND preci_reducidoo_prop <= " . simpleSanitize(($_GET['prhs']));
}
if ( isset($_GET['prhs']) && $_GET['prhs'] == '3000' ) {
    $prhs = "AND preci_reducidoo_prop <= 2000000000";
}

//  ============================================================================
//  === BEDROOMS
//  ============================================================================

$bd = '';
if( isset($_GET['bd']) && $_GET['bd'] != '' ){
    $bd = "AND habitaciones_prop >= " . simpleSanitize(($_GET['bd']));
}

//  ============================================================================
//  === BEDROOMS
//  ============================================================================

$bt = '';
if( isset($_GET['bt']) && $_GET['bt'] != '' ){
    $bt = "AND aseos_prop >= " . simpleSanitize(($_GET['bt']));
}

//  ============================================================================
//  === REFERENCE
//  ============================================================================

$rf = '';
if( isset($_GET['rf']) && $_GET['rf'] != '' ){
    $rf = "AND referencia_prop LIKE '%" . simpleSanitize(($_GET['rf'])) . "%'";
}

$query = "

SELECT

    lat_long_gpp_prop AS maplat,
    CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang_adm."_typ IS NOT NULL THEN properties_types.types_".$lang_adm."_typ ELSE types.types_".$lang_adm."_typ END AS type,
    properties_status.status_".$lang_adm."_sta as sale,
    properties_properties.m2_prop,
    properties_properties.referencia_prop,
    properties_properties.descripcion_".$lang_adm."_prop as contenido,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
   (SELECT pool_".$lang_adm."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
   (SELECT parking_".$lang_adm."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE lat_long_gpp_prop != '' AND lat_long_gpp_prop != '0,0' AND procesada_img = 1
    AND activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0
    $st $typ $lopr $loct $lozn $prds $prhs $bd $bt $rf
GROUP BY id_prop
";

$listMap = getRecords($query);

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ( (isset($_COOKIE['sidebarComp'])) && ($_COOKIE['sidebarComp'] != '') )?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

  <link rel="stylesheet" href="/js/source/OpenStreetMap/leaflet.css">
  <link rel="stylesheet" href="/js/source/OpenStreetMap/MarkerCluster.css">
  <link rel="stylesheet" href="/js/source/OpenStreetMap/MarkerCluster.Default.css">
  <link rel="stylesheet" href="/intramedianet/includes/assets/_custom/vendor/map-fullscreen/leaflet.fullscreen.css">

  <style>
    #mapa_propiedades
    {
        height: 900px;
    }
    #mapa_propiedades img,
    #mapa img {
        max-width: none;
    }
    .sticky{
        display:none !important;
    }
  </style>

</head>
<body>
    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-magnifying-glass-location"></i> <?php echo __('Buscador'); ?></h4>
                </div>
                <div class="card-body">



                    <form action="properties.php" method="get" id="mapForm" role="form" class="validate">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="st[]" id="st" class="select2" multiple data-placeholder="<?php __('Operaciones'); ?>">
                                        <?php foreach ($status as $statu): ?>
                                            <option value="<?php echo $statu['id'] ?>" <?php if (isset($_GET['st']) && is_array($_GET['st']) && in_array($statu['id'], $_GET['st'])): ?>selected<?php endif ?>><?php echo $statu['sale'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="tp[]" id="tp" class="select2" multiple data-placeholder="<?php __('Tipo'); ?>">
                                        <?php foreach ($type as $typ): ?>
                                            <option value="<?php echo $typ['id_type'] ?>" <?php if (isset($_GET['tp']) && is_array($_GET['tp']) && (in_array($typ['id_type'], $_GET['tp']))): ?>selected<?php endif ?>><?php echo $typ['type'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="lopr[]" id="lopr" class="select2" multiple data-placeholder="<?php __('Provincia'); ?>">
                                        <?php foreach ($province as $prov): ?>
                                            <option value="<?php echo $prov['id'] ?>" <?php if (isset($_GET['lopr']) && is_array($_GET['lopr']) && (in_array($prov['id'], $_GET['lopr']))): ?>selected<?php endif ?>><?php echo $prov['province'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="loct[]" id="loct" class="select2" multiple data-placeholder="<?php __('Ciudad'); ?>">
                                        <?php foreach ($city as $town): ?>
                                            <option value="<?php echo $town['id'] ?>" <?php if (isset($_GET['loct']) && is_array($_GET['loct']) && (in_array($town['id'], $_GET['loct']))): ?>selected<?php endif ?>><?php echo $town['area'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="lozn[]" id="lozn" class="select2" multiple data-placeholder="<?php __('Zona'); ?>">
                                        <?php foreach ($localizacion as $locat): ?>
                                            <option value="<?php echo $locat['id'] ?>" <?php if (isset($_GET['lozn']) && is_array($_GET['lozn']) && (in_array($locat['id'], $_GET['lozn']))): ?>selected<?php endif ?>><?php echo $locat['town'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-none d-md-block">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-block w-100"><i class="fa-regular fa-magnifying-glass-location"></i> <?php __('Buscar'); ?></button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="prds" id="prds" class="form-select">
                                        <option value="" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == '')) { ?>selected<?php } ?>><?php __('Precio desde'); ?></option>
                                        <option value="200" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 200)) { ?>selected<?php } ?>>200 €</option>
                                        <option value="400" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 400)) { ?>selected<?php } ?>>400 €</option>
                                        <option value="600" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 600)) { ?>selected<?php } ?>>600 €</option>
                                        <option value="800" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 800)) { ?>selected<?php } ?>>800 €</option>
                                        <option value="1000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 1000)) { ?>selected<?php } ?>>1.000 €</option>
                                        <option value="1200" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 1200)) { ?>selected<?php } ?>>1.200 €</option>
                                        <option value="1400" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 1400)) { ?>selected<?php } ?>>1.400 €</option>
                                        <option value="1600" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 1600)) { ?>selected<?php } ?>>1.600 €</option>
                                        <option value="1800" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 1800)) { ?>selected<?php } ?>>1.800 €</option>
                                        <option value="2000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 2000)) { ?>selected<?php } ?>>2.000 €</option>
                                        <option value="3000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 3000)) { ?>selected<?php } ?>>+3.000 €</option>
                                        <option value="50000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 50000)) { ?>selected<?php } ?>>50.000 €</option>
                                        <option value="100000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == '100000')) { ?>selected<?php } ?>>100.000€</option>
                                        <option value="150000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 150000)) { ?>selected<?php } ?>>150.000 €</option>
                                        <option value="200000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 200000)) { ?>selected<?php } ?>>200.000 €</option>
                                        <option value="250000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 250000)) { ?>selected<?php } ?>>250.000 €</option>
                                        <option value="300000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 300000)) { ?>selected<?php } ?>>300.000 €</option>
                                        <option value="350000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 350000)) { ?>selected<?php } ?>>350.000 €</option>
                                        <option value="400000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 400000)) { ?>selected<?php } ?>>400.000 €</option>
                                        <option value="450000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 450000)) { ?>selected<?php } ?>>450.000 €</option>
                                        <option value="500000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 500000)) { ?>selected<?php } ?>>500.000 €</option>
                                        <option value="550000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 550000)) { ?>selected<?php } ?>>550.000 €</option>
                                        <option value="600000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 600000)) { ?>selected<?php } ?>>600.000 €</option>
                                        <option value="650000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 650000)) { ?>selected<?php } ?>>650.000 €</option>
                                        <option value="700000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 700000)) { ?>selected<?php } ?>>700.000 €</option>
                                        <option value="1000000" <?php if ((isset($_GET['prds'])) && ($_GET['prds'] == 1000000)) { ?>selected<?php } ?>>+1.000.000 €</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="prhs" id="prhs" class="form-select">
                                        <option value=""        <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == "")     ){ ?>selected<?php } ?>><?php __('Precio hasta'); ?></option>
                                        <option value="200"     <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 200)    ){ ?>selected<?php } ?>>200 €</option>
                                        <option value="400"     <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 400)    )  { ?>selected<?php } ?>>400 €</option>
                                        <option value="600"     <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 600)    )  { ?>selected<?php } ?>>600 €</option>
                                        <option value="800"     <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 800)    )  { ?>selected<?php } ?>>800 €</option>
                                        <option value="1000"    <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 1000)   )  { ?>selected<?php } ?>>1.000 €</option>
                                        <option value="1200"    <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 1200)   )  { ?>selected<?php } ?>>1.200 €</option>
                                        <option value="1400"    <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 1400)   )  { ?>selected<?php } ?>>1.400 €</option>
                                        <option value="1600"    <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 1600)   )  { ?>selected<?php } ?>>1.600 €</option>
                                        <option value="1800"    <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 1800)   )  { ?>selected<?php } ?>>1.800 €</option>
                                        <option value="2000"    <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 2000)   )  { ?>selected<?php } ?>>2.000 €</option>
                                        <option value="3000"    <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 3000)   )  { ?>selected<?php } ?>>+3.000 €</option>
                                        <option value="50000"   <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 50000)  )  { ?>selected<?php } ?>>50.000 €</option>
                                        <option value="100000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == '100000')) { ?>selected<?php } ?>>100.000€</option>
                                        <option value="150000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 150000) )  { ?>selected<?php } ?>>150.000 €</option>
                                        <option value="200000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 200000) )  { ?>selected<?php } ?>>200.000 €</option>
                                        <option value="250000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 250000) )  { ?>selected<?php } ?>>250.000 €</option>
                                        <option value="300000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 300000) )  { ?>selected<?php } ?>>300.000 €</option>
                                        <option value="350000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 350000) )  { ?>selected<?php } ?>>350.000 €</option>
                                        <option value="400000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 400000) )  { ?>selected<?php } ?>>400.000 €</option>
                                        <option value="450000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 450000) )  { ?>selected<?php } ?>>450.000 €</option>
                                        <option value="500000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 500000) )  { ?>selected<?php } ?>>500.000 €</option>
                                        <option value="550000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 550000) )  { ?>selected<?php } ?>>550.000 €</option>
                                        <option value="600000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 600000) )  { ?>selected<?php } ?>>600.000 €</option>
                                        <option value="650000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 650000) )  { ?>selected<?php } ?>>650.000 €</option>
                                        <option value="700000"  <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 700000) )  { ?>selected<?php } ?>>700.000 €</option>
                                        <option value="1000000" <?php if ((isset($_GET['prhs'])) && ($_GET['prhs'] == 1000000))  { ?>selected<?php } ?>>+1.000.000 €</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="bd" id="bd" class="form-select">
                                        <option value="" <?php if ((isset($_GET['bd'])) && ($_GET['bd'] == '')) { ?>selected<?php } ?> ><?php __('Habitaciones'); ?></option>
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <option value="<?php echo $i ?>" <?php if ((isset($_GET['bd'])) && ($_GET['bd'] == $i)) { ?>selected<?php } ?> ><?php if ($i == 5): ?>+<?php endif ?><?php echo $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <select name="bt" id="bt" class="form-select">
                                        <option value="" <?php if ((isset($_GET['bt'])) && ($_GET['bt'] == '') ) { ?>selected<?php } ?> ><?php __('Aseos'); ?></option>
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <option value="<?php echo $i ?>" <?php if ((isset($_GET['bt'])) && ($_GET['bt'] == $i)) { ?>selected<?php } ?> ><?php if ($i == 5): ?>+<?php endif ?><?php echo $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <input type="text" name="rf" id="rf" class="form-control" value="<?php if(isset($_GET['rf'])) echo $_GET['rf'] ?>" placeholder="<?php __('Referencia'); ?>" />
                                </div>
                            </div>
                            <div class="col-md-2 d-md-none">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-block w-100"><i class="fa-regular fa-magnifying-glass-location"></i> <?php __('Buscar'); ?></button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <a href="properties.php" class="btn btn-danger btn-block btn-reset w-100"><i class="fa-regular fa-eraser"></i> <?php __('Limpiar'); ?></a>
                                </div>
                            </div>
                        </div>

                        <small class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show clearfix d-block py-2 mb-0" role="alert">
                            <i class="fa-regular fa-triangle-exclamation label-icon"></i><?php __('Es posible que no aparezca toda oferta de inmuebles en el mapa. Para acceder a la base de datos completa haz click aquí') ?>
                        </small>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-map-location-dot"></i> <?php echo __('Mapa'); ?></h4>
                </div>
                <div class="card-body">

                    <div id="mapa_propiedades"></div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="/js/source/OpenStreetMap/leaflet.js"></script>
    <script src="/js/source/OpenStreetMap/leaflet.markercluster.js"></script>
    <script src="/intramedianet/includes/assets/_custom/vendor/map-fullscreen/Leaflet.fullscreen.js"></script>

    <script>


        function showMapProperties(container, locations) {

            var map = L.map(container).setView([38.3847,-0.680823], 8);
            map.scrollWheelZoom.disable();
            map.addControl(new L.Control.Fullscreen());
            map.addLayer(new L.TileLayer('https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, '
            }));
            var customIcon = L.icon({
                iconUrl: 'https://unpkg.com/leaflet@1.4.0/dist/images/marker-icon.png',
                iconSize:     [25, 41],
                iconAnchor:   [28, 41],
                popupAnchor:  [-12, -42]
            });
            var markers = new L.MarkerClusterGroup({
                    showCoverageOnHover: false,
                    zoomToBoundsOnClick: true,
                    spiderfyOnMaxZoom: true
                });
            var markersList = [];
            for (var i = 0; i <= markersLocations.length -1; i++) {
                var marker = L.marker(markersLocations[i][0], { icon: customIcon });
                marker.bindPopup('<div style="width: 200px; max-width: 200px;"><div class="row"><div class="col-12">'+markersLocations[i][1]+'</div></div><div class="row" style="margin-top: 10px;"><div class="col-12"><h4 style="font-size: 12px !important; margin-bottom: 5px !important;">'+markersLocations[i][2]+'</h4>'+markersLocations[i][3]+'</strong><br/><span class="prices" style="margin: 5px 0 10px; display: block; font-weight: 600; color: var(--primary);">'+markersLocations[i][4]+'</strong></span><div class="row"><div class="col-sm-12"><a href="/intramedianet/properties/properties-form.php?id_prop='+markersLocations[i][5]+'&amp;KT_back=1" class="btn btn-success btn-sm btn-edit-info btn-block" style="color: #fff;"><i class="fa fa-pencil"></i></a><a href="https://www.google.com/maps/search/?api=1&query='+markersLocations[i][0]+'" target="_blank" class="btn btn-info btn-sm btn-edit-info btn-block" style="color: #fff;">Google Maps</i></a></div></div></div></div></div>');

                markersList.push(marker);
                markers.addLayer(marker);
            }
            map.addLayer(markers);
        }
    </script>

<script>
    var idprop = '';
    var markersLocations = [
    <?php foreach ($listMap as $prop): ?>
        <?php
        $altTitle = (isset($prop['type']) ? escape($prop['type'], $inmoconn) : '') . ' - ' . (isset($prop['sale']) ? escape($prop['sale'], $inmoconn) : '') . ' - ' .(isset($prop['area']) ? escape($prop['area'], $inmoconn) : '') . ' - ' .(isset($prop['town']) ? escape($prop['town'], $inmoconn) : '');
        ?>
        [
            [<?php echo isset($prop['maplat']) ? $prop['maplat'] : 0; ?>],
            <?php if (isset($prop['id_img']) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/media/images/properties/thumbnails/" . $prop['id_img'] . "_sm.jpg")) { ?>'<img src="/media/images/properties/thumbnails/<?php echo $prop['id_img']; ?>_sm.jpg" class="img-fluid" alt="<?php echo $altTitle; ?>" title="<?php echo $altTitle; ?>">',
            <?php } else { ?>'<img src="/media/images/website/no-image.png" class="img-fluid" alt="<?php echo $altTitle; ?>" title="<?php echo $altTitle; ?>" style="<?php echo $thumbnailsSizes["sm"][1] ?>">',<?php } ?>
            '<?php echo isset($prop['type']) ? escape($prop['type'], $inmoconn) : ''; ?> / <?php echo isset($prop['area']) ? escape($prop['area'], $inmoconn) : ''; ?> (<?php echo isset($prop['town']) ? escape($prop['town'], $inmoconn) : ''; ?>)',
            '<?php echo escape(__('Referencia', true), $inmoconn); ?>: <strong><?php echo isset($prop['referencia_prop']) ? escape($prop['referencia_prop'], $inmoconn) : ''; ?></strong>',
            '<?php echo escape(__('Precio', true), $inmoconn); ?>: <strong><?php if (isset($prop['old_precio']) && $prop['old_precio'] > 0) { ?><del style="display: inline-block; padding: 0 5px; color:var(--red); font-size: 11px; font-weight: 300;"><?php echo number_format($prop['old_precio'], 0, ',', '.'); ?>€</del> <?php } ?><?php if (isset($prop['precio']) && $prop['precio'] != '') { ?><?php echo number_format($prop['precio'], 0, ',', '.'); ?>€<?php } else { ?><?php echo escape(__('Consultar', true), $inmoconn); ?><?php } ?></strong>',
            '<?php echo isset($prop['id_prop']) ? $prop['id_prop'] : ''; ?>',
            '<?php echo escape(__('Ver propiedad', true), $inmoconn); ?>'
        ],
    <?php endforeach ?>
    ];
    showMapProperties("mapa_propiedades", markersLocations);
</script>



</body>
</html>
