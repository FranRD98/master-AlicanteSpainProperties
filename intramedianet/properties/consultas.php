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
                <div class="card-header align-items-center d-flex">
                    <div class="flex-grow-1 oveflow-hidden">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-sim-cards"></i> <?php echo __('Formulario de contacto'); ?></h4>
                    </div>
                    <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="enquiries.php" role="tab" aria-selected="true">
                                    <?php if($totalRows_rsConsultas > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultas; ?></span><?php } ?>
                                    <?php __('Consultas'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="bajada.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsbajadasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?>
                                    <?php __('Bajada de precios'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="consultas.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsConsultasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultasCount; ?></span><?php } ?>
                                    <?php __('Formulario de contacto'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="whatsapp.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsConsultasWhatsapp > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultasWhatsapp; ?></span><?php } ?>
                                    <?php __('Whatsapp'); ?>
                                </a>
                            </li>
                            <?php if ($actPortalsEnquiries == 1): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="/intramedianet/email/email.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php __('Portales'); ?>
                                </a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>

                <div class="card-body">

                    <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="enquiries.php" role="tab" aria-selected="true">
                                <?php if($totalRows_rsConsultas > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultas; ?></span><?php } ?>
                                <?php __('Consultas'); ?>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="bajada.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php if($totalRows_rsbajadasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?>
                                <?php __('Bajada de precios'); ?>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link active" href="consultas.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php if($totalRows_rsConsultasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultasCount; ?></span><?php } ?>
                                <?php __('Formulario de contacto'); ?>
                            </a>
                        </li>
                        <?php if ($actPortalsEnquiries == 1): ?>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="/intramedianet/email/email.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php __('Portales'); ?>
                            </a>
                        </li>
                        <?php endif ?>
                    </ul>

                    <form action="emails_submit" method="get" id="filtermails" class="mb-4">

                        <div class="row" id="search-fields">
                            <div class="col-md-2">

                                <div class="form-group">
                                    <label for="desde" class="form-label"><?php __('Fecha desde'); ?>:</label>
                                    <div class="controls">
                                        <input type="text" name="desde" id="desde" value="" size="32" maxlength="255" data-provider="flatpickr" data-date-format="d-m-Y" class="form-control datepick">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-2">

                                <div class="form-group">
                                    <label for="hasta" class="form-label"><?php __('Fecha hasta'); ?>:</label>
                                    <div class="controls">
                                        <input type="text" name="hasta" id="hasta" value="" size="32" maxlength="255" data-provider="flatpickr" data-date-format="d-m-Y" class="form-control datepick">
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

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Name'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Phone'); ?></th>
                                    <th><?php __('Consulta'); ?></th>
                                    <th><?php __('Idioma'); ?></th>
                                    <th><?php __('Enviado'); ?></th>
                                    <th id="actions"><div class="panel-heading"></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script src="_js/report-consultas-search.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-user-plus me-2 fs-4"></i> <?php __('Convertir a propietario'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form id="formOwn" action="/intramedianet/properties/owners-form.php" method="post" class="needs-validation" novalidate>
                    <div class="modal-body bg-light">
                        <div class="mb-4">
                            <label for="nombre_pro" id="nameprom" class="form-label"><?php __('Nombre'); ?>:</label>
                            <input type="text" name="nombre_pro" id="nombre_pro" value="" size="32" maxlength="255" class="form-control required" required>
                            <div class="invalid-feedback">
                                <?php __('Este campo es obligatorio.'); ?>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="idioma_pro" class="form-label"><?php __('Idioma'); ?>:</label>
                            <select name="idioma_pro" id="idioma_pro" class="form-control required" required>
                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                <?php
                                if ($lang_adm == 'es') {
                                    $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                } else {
                                    $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                }
                                foreach ($languages as $value) {
                                    echo '<option value="' . $value . '">' . $idiomas[$value] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                <?php __('Este campo es obligatorio.'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type_pro" class="form-label"><?php __('Tipo'); ?>:</label>
                            <select name="type_pro" id="type_pro" class="form-control required" required>
                                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                <option value="1"<?php if (!(strcmp(1, $row_rsproperties_owner['type_pro']))) {echo "SELECTED";} ?>><?php __('Particular'); ?></option>
                                <option value="2"<?php if (!(strcmp(2, $row_rsproperties_owner['type_pro']))) {echo "SELECTED";} ?>><?php __('Constructor'); ?></option>
                                <option value="3"<?php if (!(strcmp(3, $row_rsproperties_owner['type_pro']))) {echo "SELECTED";} ?>><?php __('Banco'); ?></option>
                            </select>
                            <div class="invalid-feedback">
                                <?php __('Este campo es obligatorio.'); ?>
                            </div>
                        </div>
                        <input type="hidden" name="telefono_fijo_pro" id="telefono_fijo_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['telefono_fijo_pro']); ?>" size="32" maxlength="255" class="form-control">
                        <input type="hidden" name="email_pro" id="email_pro" value="<?php echo KT_escapeAttribute($row_rsproperties_owner['email_pro']); ?>" size="32" maxlength="255" class="form-control">
                        <textarea type="text" name="historial_pro" id="historial_pro" cols="50" rows="20" class="form-control" style="display: none"><?php echo KT_escapeAttribute($row_rsproperties_owner['historial_pro']); ?></textarea>
                    </div>
                    <div class="modal-footer bg-soft-primary">
                        <input type="hidden" name="fecha_alta_pro" id="fecha_alta_pro" value="<?php echo date("d-m-Y H:i:s") ?>">
                        <input type="submit" name="KT_Insert2" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success mt-4" />
                        <button type="button" class="btn btn-danger mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
