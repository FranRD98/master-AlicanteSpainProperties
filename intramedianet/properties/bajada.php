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
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-money-check-dollar-pen"></i> <?php echo __('Bajada de precios'); ?></h4>
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
                                <a class="nav-link active" href="bajada.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsbajadasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?>
                                    <?php __('Bajada de precios'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="consultas.php" role="tab" aria-selected="false" tabindex="-1">
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
                            <a class="nav-link active" href="bajada.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php if($totalRows_rsbajadasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?>
                                <?php __('Bajada de precios'); ?>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="consultas.php" role="tab" aria-selected="false" tabindex="-1">
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

                        <label for="b_ref_cli" class="form-label"><?php __('Referencia'); ?>:</label>
                          <input type="text" class="select2references" id="ref" name="ref" value="" tabindex="-1">
                        <div class="controls">
                          <?php /* ?>
                          <!-- <select name="ref" id="ref" class="select2">
                          <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                            <?php do {
                              $vals = explode(',', $row_rsproperties_client['b_ref_cli']);
                            ?>
                            <option value="<?php echo $row_rsReferencias['id'] ?>"><?php echo $row_rsReferencias['name'] ?></option>
                            <?php } while ($row_rsReferencias = mysqli_fetch_assoc($rsReferencias)); ?>
                          </select> -->
                          <?php */ ?>
                        </div>
                      </div>
                    </div>
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

                        <div class="controls">
                          <br>
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
                                    <th><?php __('Referencia'); ?></th>
                                    <th><?php __('Name'); ?></th>
                                    <th><?php __('Email'); ?></th>
                                    <th><?php __('Phone'); ?></th>
                                    <th><?php __('Idioma'); ?></th>
                                    <th><?php __('Enviado'); ?></th>
                                    <th id="actions" style="min-width: 210px;"><div class="panel-heading"></div></th>
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

    <script src="_js/report-bajada-search.js?id=<?php echo time(); ?>" type="text/javascript"></script>

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

    <script>
        $(document).on('click', '.del-bajada2', function(e) {
            e.preventDefault();

            tb = $(this);
            vid = tb.attr('href');

            Swal.fire({
                title: delRecord,
                text: delRecord2,
                icon: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success w-xs me-2 mt-2',
                cancelButtonClass: 'btn btn-danger w-xs mt-2',
                confirmButtonText: delRecordYes,
                cancelButtonText: delRecordNo,
                buttonsStyling: false,
                showCloseButton: true
            }).then(function (result) {
                if (result.value) {
                    $.get(vid, function(data) {
                        if(data == 'ok') {
                            tb.closest('tr').fadeOut('slow', function() { $(this).remove(); });
                        }
                    });
                }
            });

            return false;

        });
    </script>

</body>
</html>
