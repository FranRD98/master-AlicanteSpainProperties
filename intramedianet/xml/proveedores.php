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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-file-code"></i> <?php echo __('Proveedores'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="proveedores-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Proveedor'); ?></th>
                                    <th><?php __('Prefijo'); ?></th>
                                    <th><?php __('Tipo'); ?></th>
                                    <th><?php __('Activo'); ?></th>
                                    <th><?php __('Última actualización'); ?></th>
                                    <th><?php __('En el XML'); ?></th>
                                    <th><?php __('Procesados'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="site_xml" id="site_xml" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="ref_prefix_xml" id="ref_prefix_xml" class="form-control form-control-sm"></td>
                                      <td><input type="hidden" name="tipo_xml" id="tipo_xml">

                                          <select name="tipo_xml_sel" id="tipo_xml_sel" class="form-select form-select-sm">
                                              <option value=""><?php __('Todos'); ?></option>
                                              <option value="1">Kyero</option>
                                              <option value="2">XML-Mediaelx</option>
                                              <option value="3">Inmovilla</option>
                                              <option value="5">Resales-online</option>
                                              <option value="6">REDSP</option>
                                              <option value="7">Habihub</option>
                                         </select>

                                      </td>
                                      <td><input type="hidden" name="activate_xml" id="activate_xml">

                                          <select name="activate_xml_sel" id="activate_xml_sel" class="form-select form-select-sm">
                                              <option value=""><?php __('Todos'); ?></option>
                                              <option value="<?php __('Sí'); ?>"><?php __('Sí'); ?></option>
                                              <option value="<?php __('No'); ?>"><?php __('No'); ?></option>
                                         </select>

                                      </td>
                                    <td><input type="text" name="updated_xml" id="updated_xml" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="total_xml" id="total_xml" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="total_imp_xml" id="total_imp_xml" class="form-control form-control-sm"></td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="card mt-4  bg-light p-3">
                            
                        <p class="mb-1">
                            <small><i class="fa-regular fa-asterisk text-danger fa-fw"></i><?php __('Disclaimer XML mediaelx Export'); ?></small>
                        </p>
                        <p class="mb-0 ps-lg-3"> 
                            <small><?php __('Disclaimer XML mediaelx Import 2'); ?></small> 
                        </p>
            
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="_js/prov-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
