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
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ($_COOKIE['sidebarComp'] != '')?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-thumbs-up"></i> <?php echo __('Valoraciones'); ?></h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                            <tr>
                              <th><?php __('Cliente'); ?></th>
                              <th><?php __('Propiedad'); ?></th>
                              <th><?php __('Valoración'); ?></th>
                              <th><?php __('Localización'); ?></th>
                              <th><?php __('Tipo'); ?></th>
                              <th><?php __('Precio'); ?></th>
                              <th><?php __('Habitaciones'); ?></th>
                              <th><?php __('Otros'); ?></th>
                              <th><?php __('Fecha'); ?></th>
                              <th id="actions"></th>
                            </tr>
                            <tr>
                              <td><input type="text" name="cli" id="cli" class="form-control form-select-sm"></td>
                              <td><input type="text" name="prop" id="prop" class="form-control form-select-sm"></td>
                              <td><input type="hidden" name="rate" id="rate">

                                  <select name="rate_sel" id="rate_sel" class="form-select form-select-sm">
                                      <option value=""><?php __('Todos'); ?></option>
                                      <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                      <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                 </select>

                              </td>
                              <td><input type="hidden" name="loc" id="loc">

                                  <select name="loc_sel" id="loc_sel" class="form-select form-select-sm">
                                      <option value=""><?php __('Todos'); ?></option>
                                      <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                      <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                 </select>

                              </td>
                              <td><input type="hidden" name="tp" id="tp">

                                  <select name="tp_sel" id="tp_sel" class="form-select form-select-sm">
                                      <option value=""><?php __('Todos'); ?></option>
                                      <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                      <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                 </select>

                              </td>
                              <td><input type="hidden" name="pr" id="pr">

                                  <select name="pr_sel" id="pr_sel" class="form-select form-select-sm">
                                      <option value=""><?php __('Todos'); ?></option>
                                      <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                      <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                 </select>

                              </td>
                              <td><input type="hidden" name="bd" id="bd">

                                  <select name="bd_sel" id="bd_sel" class="form-select form-select-sm">
                                      <option value=""><?php __('Todos'); ?></option>
                                      <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                      <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                 </select>

                              </td>
                              <td><input type="hidden" name="od" id="od">

                                  <select name="od_sel" id="od_sel" class="form-select form-select-sm">
                                      <option value=""><?php __('Todos'); ?></option>
                                      <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                      <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                 </select>

                              </td>
                              <td><input type="text" name="datef" id="datef" class="form-control form-select-sm"></td>
                              <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                            <tr>
                              <td colspan="10" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
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
    var numCols = 9;
    </script>

    <script src="_js/clients-rates-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
