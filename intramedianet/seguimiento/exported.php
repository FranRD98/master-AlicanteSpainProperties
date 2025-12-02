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


$query_rsReferencias = "SELECT id_prop as id, referencia_prop as name FROM properties_properties ORDER BY referencia_prop ASC";
$rsReferencias = mysqli_query($inmoconn,$query_rsReferencias) or die(mysqli_error());
$row_rsReferencias = mysqli_fetch_assoc($rsReferencias);
$totalRows_rsReferencias = mysqli_num_rows($rsReferencias);


$query_rsPropertiesRightmove = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_rightmove_prop = 1 AND descripcion_en_prop != ''
";
$rsPropertiesRightmove = mysqli_query($inmoconn,$query_rsPropertiesRightmove) or die(mysqli_error());
$row_rsPropertiesRightmove = mysqli_fetch_assoc($rsPropertiesRightmove);
$totalRows_rsPropertiesRightmove = mysqli_num_rows($rsPropertiesRightmove);


$query_rsPropertiesKyero = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_kyero_prop = 1
";
$rsPropertiesKyero = mysqli_query($inmoconn,$query_rsPropertiesKyero) or die(mysqli_error());
$row_rsPropertiesKyero = mysqli_fetch_assoc($rsPropertiesKyero);
$totalRows_rsPropertiesKyero = mysqli_num_rows($rsPropertiesKyero);


$query_rsPropertiesIdealista = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.idealista_prop = 1
";
$rsPropertiesIdealista = mysqli_query($inmoconn,$query_rsPropertiesIdealista) or die(mysqli_error());
$row_rsPropertiesIdealista = mysqli_fetch_assoc($rsPropertiesIdealista);
$totalRows_rsPropertiesIdealista = mysqli_num_rows($rsPropertiesIdealista);


$query_rsPropertiesZoopla = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_zoopla_prop = 1
";
$rsPropertiesZoopla = mysqli_query($inmoconn,$query_rsPropertiesZoopla) or die(mysqli_error());
$row_rsPropertiesZoopla = mysqli_fetch_assoc($rsPropertiesZoopla);
$totalRows_rsPropertiesZoopla = mysqli_num_rows($rsPropertiesZoopla);


$query_rsPropertiesThinkspin = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_thinkspain_prop = 1
";
$rsPropertiesThinkspin = mysqli_query($inmoconn,$query_rsPropertiesThinkspin) or die(mysqli_error());
$row_rsPropertiesThinkspin = mysqli_fetch_assoc($rsPropertiesThinkspin);
$totalRows_rsPropertiesThinkspin = mysqli_num_rows($rsPropertiesThinkspin);


$query_rsPropertiesHemnet = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_hemnet_prop = 1
";
$rsPropertiesHemnet = mysqli_query($inmoconn,$query_rsPropertiesHemnet) or die(mysqli_error());
$row_rsPropertiesHemnet = mysqli_fetch_assoc($rsPropertiesHemnet);
$totalRows_rsPropertiesHemnet = mysqli_num_rows($rsPropertiesHemnet);


$query_rsPropertiesUbiflow = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_ubiflow_prop = 1
";
$rsPropertiesUbiflow = mysqli_query($inmoconn,$query_rsPropertiesUbiflow) or die(mysqli_error());
$row_rsPropertiesUbiflow = mysqli_fetch_assoc($rsPropertiesUbiflow);
$totalRows_rsPropertiesUbiflow = mysqli_num_rows($rsPropertiesUbiflow);


$query_rsPropertiesGreenAcres = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_green_prop = 1
";
$rsPropertiesGreenAcres = mysqli_query($inmoconn,$query_rsPropertiesGreenAcres) or die(mysqli_error());
$row_rsPropertiesGreenAcres = mysqli_fetch_assoc($rsPropertiesGreenAcres);
$totalRows_rsPropertiesGreenAcres = mysqli_num_rows($rsPropertiesGreenAcres);


$query_rsPropertiesPrian = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_prian_prop = 1
";
$rsPropertiesPrian = mysqli_query($inmoconn,$query_rsPropertiesPrian) or die(mysqli_error());
$row_rsPropertiesPrian = mysqli_fetch_assoc($rsPropertiesPrian);
$totalRows_rsPropertiesPrian = mysqli_num_rows($rsPropertiesPrian);


$query_rsPropertiesHabitaclia = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_habitaclia_prop = 1
";
$rsPropertiesHabitaclia = mysqli_query($inmoconn,$query_rsPropertiesHabitaclia) or die(mysqli_error());
$row_rsPropertiesHabitaclia = mysqli_fetch_assoc($rsPropertiesHabitaclia);
$totalRows_rsPropertiesHabitaclia = mysqli_num_rows($rsPropertiesHabitaclia);


$query_rsPropertiesPisos = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_pisos_prop = 1
";
$rsPropertiesPisos = mysqli_query($inmoconn,$query_rsPropertiesPisos) or die(mysqli_error());
$row_rsPropertiesPisos = mysqli_fetch_assoc($rsPropertiesPisos);
$totalRows_rsPropertiesPisos = mysqli_num_rows($rsPropertiesPisos);


$query_rsPropertiesFacilisimo = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_facilisimo_prop = 1
";
$rsPropertiesFacilisimo = mysqli_query($inmoconn,$query_rsPropertiesFacilisimo) or die(mysqli_error());
$row_rsPropertiesFacilisimo = mysqli_fetch_assoc($rsPropertiesFacilisimo);
$totalRows_rsPropertiesFacilisimo = mysqli_num_rows($rsPropertiesFacilisimo);

$query_rsPropertiesFotocasa = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_fotocasa_prop = 1
";
$rsPropertiesFotocasa = mysqli_query($inmoconn,$query_rsPropertiesFotocasa) or die(mysqli_error());
$row_rsPropertiesFotocasa = mysqli_fetch_assoc($rsPropertiesFotocasa);
$totalRows_rsPropertiesFotocasa = mysqli_num_rows($rsPropertiesFotocasa);

$query_rsPropertiesTodoPisoAlicante = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_todopisoalicante_prop = 1
";
$rsPropertiesTodoPisoAlicante = mysqli_query($inmoconn,$query_rsPropertiesTodoPisoAlicante) or die(mysqli_error());
$row_rsPropertiesTodoPisoAlicante = mysqli_fetch_assoc($rsPropertiesTodoPisoAlicante);
$totalRows_rsPropertiesTodoPisoAlicante = mysqli_num_rows($rsPropertiesTodoPisoAlicante);

$query_rsPropertiesYaencontre = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_yaencontre_prop = 1
";
$rsPropertiesYaencontre = mysqli_query($inmoconn,$query_rsPropertiesYaencontre) or die(mysqli_error());
$row_rsPropertiesYaencontre = mysqli_fetch_assoc($rsPropertiesYaencontre);
$totalRows_rsPropertiesYaencontre = mysqli_num_rows($rsPropertiesYaencontre);

$query_rsAPITS = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.expport_APITS_prop = 1
";
$rsAPITS = mysqli_query($inmoconn,$query_rsAPITS) or die(mysqli_error());
$row_rsAPITS = mysqli_fetch_assoc($rsAPITS);
$totalRows_rsAPITS = mysqli_num_rows($rsAPITS);

$query_rsCostadelHome = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.expport_CostadelHome_prop = 1
";
$rsCostadelHome = mysqli_query($inmoconn,$query_rsCostadelHome) or die(mysqli_error());
$row_rsCostadelHome = mysqli_fetch_assoc($rsCostadelHome);
$totalRows_rsCostadelHome = mysqli_num_rows($rsCostadelHome);

$query_rsSpainHouses = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.expport_SpainHomes_prop = 1
";
$rsSpainHouses = mysqli_query($inmoconn,$query_rsSpainHouses) or die(mysqli_error());
$row_rsSpainHouses = mysqli_fetch_assoc($rsSpainHouses);
$totalRows_rsSpainHouses = mysqli_num_rows($rsSpainHouses);

$query_rsMiMove = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mimove_prop = 1
";
$rsMiMove = mysqli_query($inmoconn,$query_rsMiMove) or die(mysqli_error());
$row_rsMiMove = mysqli_fetch_assoc($rsMiMove);
$totalRows_rsMiMove = mysqli_num_rows($rsMiMove);

$query_rsInmoco = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_inmoco_prop = 1
";
$rsInmoco = mysqli_query($inmoconn,$query_rsInmoco) or die(mysqli_error());
$row_rsInmoco = mysqli_fetch_assoc($rsInmoco);
$totalRows_rsInmoco = mysqli_num_rows($rsInmoco);

$query_rsMediaelx = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mediaelx_prop = 1
";
$rsMediaelx = mysqli_query($inmoconn,$query_rsMediaelx) or die(mysqli_error());
$row_rsMediaelx = mysqli_fetch_assoc($rsMediaelx);
$totalRows_rsMediaelx = mysqli_num_rows($rsMediaelx);

$query_rsFacebook = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_facebook_prop = 1
";
$rsFacebook = mysqli_query($inmoconn,$query_rsFacebook) or die(mysqli_error());
$row_rsFacebook = mysqli_fetch_assoc($rsFacebook);
$totalRows_rsFacebook = mysqli_num_rows($rsFacebook);

$query_rsMLSMediaelx = "
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mlsmediaelx_prop = 1
";
$rsMLSMediaelx = mysqli_query($inmoconn,$query_rsMLSMediaelx) or die(mysqli_error());
$row_rsMLSMediaelx = mysqli_fetch_assoc($rsMLSMediaelx);
$totalRows_rsMLSMediaelx = mysqli_num_rows($rsMLSMediaelx);

$tot = 3;

if ($expKyero) {$tot = $tot + 1;}
if ($expIdealista) {$tot = $tot + 1;}
if ($expRightmove) {$tot = $tot + 1;}
if ($expZoopla) {$tot = $tot + 1;}
if ($expThinkSpain) {$tot = $tot + 1;}
if ($expHemnet) {$tot = $tot + 1;}
if ($expUbiflow) {$tot = $tot + 1;}
if ($expGreenAcres) {$tot = $tot + 1;}
if ($expPrian) {$tot = $tot + 1;}
if ($expHabitaclia) {$tot = $tot + 1;}
if ($expPisos) {$tot = $tot + 1;}
if ($expFacilisimo) {$tot = $tot + 1;}
if ($expFotoCasa) {$tot = $tot + 1;}
if ($expTodoPisoAlicante) {$tot = $tot + 1;}
if ($expYaencontre) {$tot = $tot + 1;}
if ($expAPITS) {$tot = $tot + 1;}
if ($expCostadelHome) {$tot = $tot + 1;}
if ($expSpainHouses) {$tot = $tot + 1;}
if ($expMimove) {$tot = $tot + 1;}
if ($expInmoco) {$tot = $tot + 1;}
if ($expMediaelx) {$tot = $tot + 1;}
if ($expFacebook) {$tot = $tot + 1;}
if ($expMLSMediaelx) {$tot = $tot + 1;}
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-magnifying-glass-location"></i> <?php echo __('Buscador'); ?></h4>
                </div>
                <div class="card-body">

                      <div class="row" id="search-fields">
                        <?php if ($expKyero) { ?>
                              <div class="col-md-2">
                              <div class="mb-4">
                                  <label for="kyero" class="form-label"><?php __('Kyero'); ?>:</label>
                                  <select name="kyero" id="kyero" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                </select>
                              </div>
                              </div>
                        <?php } ?>
                        <?php if ($expMediaelx) { ?>
                          <div class="col-md-2">
                                <div class="mb-4">
                                  <label for="export_mediaelx_prop" class="form-label"><?php __('Mediaelx'); ?>:</label>
                                    <select name="export_mediaelx_prop" id="export_mediaelx_prop" class="form-select">
                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                        <option value="0"><?php echo __('No') ?></option>
                                        <option value="1"><?php echo __('Sí') ?></option>
                                    </select>
                                </div>
                          </div>
                        <?php } ?>
                        <?php if ($expFacebook) { ?>
                          <div class="col-md-2">
                                <div class="mb-4">
                                  <label for="export_facebook_prop" class="form-label"><?php __('Facebook'); ?>:</label>
                                    <select name="export_facebook_prop" id="export_facebook_prop" class="form-select">
                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                        <option value="0"><?php echo __('No') ?></option>
                                        <option value="1"><?php echo __('Sí') ?></option>
                                    </select>
                                </div>
                          </div>
                        <?php } ?>
                        <?php if ($expMLSMediaelx) { ?>
                          <div class="col-md-2">
                                <div class="mb-4">
                                  <label for="export_mlsmediaelx_prop" class="form-label"><?php __('MLS Mediaelx'); ?>:</label>
                                    <select name="export_mlsmediaelx_prop" id="export_mlsmediaelx_prop" class="form-select">
                                        <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                        <option value="0"><?php echo __('No') ?></option>
                                        <option value="1"><?php echo __('Sí') ?></option>
                                    </select>
                                </div>
                          </div>
                        <?php } ?>
                        <?php if ($expIdealista) { ?>
                              <div class="col-md-2">
                              <div class="mb-4">
                                <label for="idealista" class="form-label"><?php __('Idealista'); ?>:</label>
                                  <select name="idealista" id="idealista" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expRightmove) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="rightmove" class="form-label"><?php __('Rightmove'); ?>:</label>
                                  <select name="rightmove" id="rightmove" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expZoopla) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="zoopla" class="form-label"><?php __('Zoopla'); ?>:</label>
                                  <select name="zoopla" id="zoopla" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expThinkSpain) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="thinkspain" class="form-label"><?php __('Think Spain'); ?>:</label>
                                  <select name="thinkspain" id="thinkspain" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expHemnet) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="hemnet" class="form-label"><?php __('Hemnet'); ?>:</label>
                                  <select name="hemnet" id="hemnet" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expUbiflow) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="ubiflow" class="form-label"><?php __('Ubiflow'); ?>:</label>
                                  <select name="ubiflow" id="ubiflow" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expGreenAcres) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="green" class="form-label"><?php __('Ubiflow'); ?>:</label>
                                  <select name="green" id="green" class="form-select m-0" style="height: 37px;">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expPrian) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="prian" class="form-label"><?php __('Prian'); ?>:</label>
                                  <select name="prian" id="prian" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expHabitaclia) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="habitaclia" class="form-label"><?php __('Habitaclia'); ?>:</label>
                                  <select name="habitaclia" id="habitaclia" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expPisos) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="pisos" class="form-label"><?php __('Pisos.com'); ?>:</label>
                                  <select name="pisos" id="pisos" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expFacilisimo) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="facilisimo" class="form-label"><?php __('Facilisimo'); ?>:</label>
                                  <select name="facilisimo" id="facilisimo" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expFotoCasa) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="fotocasa" class="form-label"><?php __('Fotocasa'); ?>:</label>
                                  <select name="fotocasa" id="fotocasa" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expTodoPisoAlicante) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="todopiso" class="form-label"><?php __('Todo Piso Alicante'); ?>:</label>
                                  <select name="todopiso" id="todopiso" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expYaencontre) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="yaencontre" class="form-label"><?php __('Yaencontre'); ?>:</label>
                                  <select name="yaencontre" id="yaencontre" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expAPITS) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="expport_APITS_prop" class="form-label"><?php __('A Place in the Sun'); ?>:</label>
                                  <select name="expport_APITS_prop" id="expport_APITS_prop" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expCostadelHome) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="expport_CostadelHome_prop" class="form-label"><?php __('Costa del Home'); ?>:</label>
                                  <select name="expport_CostadelHome_prop" id="expport_CostadelHome_prop" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expSpainHouses) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="expport_SpainHomes_prop" class="form-label"><?php __('Spain Homes'); ?>:</label>
                                  <select name="expport_SpainHomes_prop" id="expport_SpainHomes_prop" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expMimove) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="export_mimove_prop" class="form-label"><?php __('Mi Move'); ?>:</label>
                                  <select name="export_mimove_prop" id="export_mimove_prop" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>
                        <?php if ($expInmoco) { ?>
                          <div class="col-md-2">
                              <div class="mb-4">
                                <label for="export_inmoco_prop" class="form-label"><?php __('Inmoco'); ?>:</label>
                                  <select name="export_inmoco_prop" id="export_inmoco_prop" class="form-select">
                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                      <option value="0"><?php echo __('No') ?></option>
                                      <option value="1"><?php echo __('Sí') ?></option>
                                  </select>
                              </div>
                          </div>
                        <?php } ?>

                        <div class="col-md-2">
                          <div class="mb-4">
                            <label for="b_ref_cli" class="form-label"><?php __('Referencia'); ?>:</label>
                              <input type="text" class="select2references" id="ref" name="ref" value="" tabindex="-1">
                              <!-- <select class="select2references" id="ref" name="ref"></select> -->
                          </div>
                        </div>

                        <div class="col-md-2">

                          <div class="mt-3">
                                <a href="#" class="btn btn-danger btn-reset w-100"><?php __('Limpiar'); ?></a>
                          </div>

                        </div>
                      </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-server"></i> <?php echo __('Propiedades exportadas'); ?></h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr class="align-middle">
                                    <th style="width: 100px;"><?php __('Imagen'); ?></th>
                                    <th><?php __('Referencia'); ?></th>
                                    <th><?php __('Activado'); ?></th>
                                    <?php if ($expKyero == 1) { ?>
                                    <th><?php __('Kyero'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesKyero,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expIdealista == 1) { ?>
                                    <th><?php __('Idealista'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesIdealista,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expRightmove == 1) { ?>
                                    <th><?php __('Rightmove'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesRightmove,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expZoopla == 1) { ?>
                                    <th><?php __('Zoopla'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesZoopla,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expThinkSpain == 1) { ?>
                                    <th><?php __('Think Spain'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesThinkspin,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expHemnet == 1) { ?>
                                    <th><?php __('Hemnet'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesHemnet,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expUbiflow == 1) { ?>
                                    <th><?php __('Ubiflow'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesUbiflow,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expGreenAcres == 1) { ?>
                                    <th><?php __('Green Acres'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesGreenAcres,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expPrian == 1) { ?>
                                    <th><?php __('Prian'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesPrian,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expHabitaclia == 1) { ?>
                                    <th><?php __('Habitaclia'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesHabitaclia,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expPisos == 1) { ?>
                                    <th><?php __('Pisos.com'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesPisos,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expFacilisimo == 1) { ?>
                                    <th><?php __('Facilisimo'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesFacilisimo,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expFotoCasa == 1) { ?>
                                    <th><?php __('Fotocasa'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesFotocasa,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expTodoPisoAlicante == 1) { ?>
                                    <th><?php __('Todo Piso Alicante'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesTodoPisoAlicante,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expYaencontre == 1) { ?>
                                    <th><?php __('Yaencontre'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsPropertiesYaencontre,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expAPITS == 1) { ?>
                                    <th><?php __('A Place in the Sun'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsAPITS,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expCostadelHome == 1) { ?>
                                    <th><?php __('Costa del Home'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsCostadelHome,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expSpainHouses == 1) { ?>
                                    <th><?php __('Spain Homes'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsSpainHouses,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expMimove == 1) { ?>
                                    <th><?php __('Mi Move'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsMiMove,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expInmoco == 1) { ?>
                                    <th><?php __('Inmoco'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsInmoco,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expMediaelx == 1) { ?>
                                    <th><?php __('Mediaelx'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsMediaelx,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expFacebook == 1) { ?>
                                    <th><?php __('Facebook'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsFacebook,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                    <?php if ($expMLSMediaelx == 1) { ?>
                                    <th><?php __('MLS Mediaelx'); ?><span class="badge bg-soft-primary"><?php echo number_format($totalRows_rsMLSMediaelx,0, ',', '.'); ?></span></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="<?php echo $tot; ?>" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
        var totalFLDS = <?php echo $tot ?>;
        var showKyero = <?php echo $expKyero ?>;
        var showIdealista = <?php echo $expIdealista ?>;
        var showRightmove = <?php echo $expRightmove ?>;
        var showZoopla = <?php echo $expZoopla ?>;
        var showThinkSpain = <?php echo $expThinkSpain ?>;
        var showHemnet = <?php echo $expHemnet ?>;
        var showUbiflow = <?php echo $expUbiflow ?>;
        var showGreenAcres = <?php echo $expGreenAcres ?>;
        var showPrian = <?php echo $expPrian ?>;
        var showHabitaclia = <?php echo $expHabitaclia ?>;
        var showPisos = <?php echo $expPisos ?>;
        var showFacilisimo = <?php echo $expFacilisimo ?>;
        var showFotocasa = <?php echo $expFotoCasa ?>;
        var showTodoPisoAlicante = <?php echo $expTodoPisoAlicante ?>;
        var showYaencontre = <?php echo $expYaencontre ?>;
        var showAPITS = <?php echo $expAPITS ?>;
        var showCostadelHome = <?php echo $expCostadelHome ?>;
        var showSpainHouses = <?php echo $expSpainHouses ?>;
        var showMimove = <?php echo $expMimove ?>;
        var showInmoco = <?php echo $expInmoco ?>;
        var showMediaelx = <?php echo $expMediaelx ?>;
        var showFacebook = <?php echo $expFacebook ?>;
        var showMLSMediaelx = <?php echo $expMLSMediaelx ?>;
        var titleExtraAction = '<?php __('Este portal requiere de acciones adicionales, acceda a la propiedad para ello') ?>';
    </script>

    <script src="_js/report-export-search.js?<?php echo time(); ?>" type="text/javascript"></script>

    <script>
        $('.select2references').select2({
            // multiple:true,
            ajax: {
            url: function (params) {
                return '/intramedianet/properties/properties-references-select.php?q=' + params;
            },
            dataType: 'json',
            delay: 250,
            results: function (data, params) {
                return {
                    results: data.results
                };
            },
            // cache: true,
            },
            placeholder: '',
            minimumInputLength: 3,
        });
    </script>

</body>
</html>
