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

$query_rsUsuarios = "SELECT email_cli as id, CONCAT_WS(' ', nombre_cli, apellidos_cli) as name FROM properties_client WHERE email_cli != '' ORDER BY name ASC";
$rsUsuarios = mysqli_query($inmoconn,$query_rsUsuarios) or die(mysqli_error());
$row_rsUsuarios = mysqli_fetch_assoc($rsUsuarios);
$totalRows_rsUsuarios = mysqli_num_rows($rsUsuarios);
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

                    <form action="emails_submit" method="get" id="filtermails">
                      <div class="row" id="filter-mails">
                          <div class="col-md-2">
                            <div class="form-group">

                              <label for="b_ref_cli" class="form-label mt-4 mt-md-0"><?php __('Referencia'); ?>:</label>
                                <input type="text" class="select2references" id="ref" name="ref" value="" tabindex="-1">
                              <div class="controls">
                                <!-- <select name="ref" id="ref" class="select2">
                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                  <?php do {
                                    $vals = explode(',', $row_rsproperties_client['b_ref_cli']);
                                  ?>
                                  <option value="<?php echo $row_rsReferencias['id'] ?>"><?php echo $row_rsReferencias['name'] ?></option>
                                  <?php } while ($row_rsReferencias = mysqli_fetch_assoc($rsReferencias)); ?>
                                </select> -->
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">

                            <div class="form-group">
                              <label for="desde" class="form-label mt-4 mt-md-0"><?php __('Fecha desde'); ?>:</label>
                              <div class="controls">
                                  <input type="text" name="desde" id="desde" value="" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                              </div>
                            </div>

                          </div>
                          <div class="col-md-2">

                            <div class="form-group">
                              <label for="hasta" class="form-label mt-4 mt-md-0"><?php __('Fecha hasta'); ?>:</label>
                              <div class="controls">
                                  <input type="text" name="hasta" id="hasta" value="" size="32" maxlength="255" class="form-control datepick" data-provider="flatpickr" data-date-format="d-m-Y">
                              </div>
                            </div>

                          </div>
                          <div class="col-md-2">

                            <div class="form-group">
                              <label for="tipo" class="form-label mt-4 mt-md-0"><?php __('Tipo'); ?>:</label>
                              <div class="controls">
                                  <select name="tipo" id="tipo" class="select2">
                                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                    <option value="1"><?php echo $lang['Ficha clientes']; ?></option>
                                    <option value="2"><?php echo $lang['Búsqueda de inmuebles']; ?></option>
                                    <option value="3"><?php echo $lang['Bajada de precio']; ?></option>
                                    <option value="4"><?php echo $lang['Clientes interesados']; ?></option>
                                    <option value="5"><?php echo $lang['Lista de correo']; ?></option>
                                    <option value="6"><?php echo $lang['Listado de propiedades']; ?></option>
                                  </select>
                              </div>
                            </div>

                          </div>
                          <div class="col-md-2">
                            <div class="form-group">

                              <label for="mails" class="form-label mt-4 mt-md-0"><?php __('Cliente'); ?>:</label>
                              <div class="controls">
                                <select name="mails" id="mails" class="select2">
                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                  <?php do { ?>
                                  <option value="<?php echo $row_rsUsuarios['id'] ?>"><?php echo $row_rsUsuarios['name'] ?></option>
                                  <?php } while ($row_rsUsuarios = mysqli_fetch_assoc($rsUsuarios)); ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">

                            <div class="form-group">
                              <br>
                              <div class="controls">
                                  <a href="#" class="btn btn-danger btn-reset w-100"><?php __('Limpiar'); ?></a>
                              </div>
                            </div>

                          </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-paper-plane"></i> <?php echo __('Envío de emails'); ?></h4>
                    <div class="flex-shrink-0 panel-heading">
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Referencia'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Dónde'); ?></th>
                                    <th><?php __('Estado'); ?></th>
                                    <th><?php __('Enviado'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="_js/report-emails-search.js?id=<?php echo time(); ?>" type="text/javascript"></script>

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
