<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);


// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php' );

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

function _d($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

$query_rsEmails = "SELECT * FROM acumbamail ORDER BY datetime_acum";
$rsEmails = mysqli_query($inmoconn,$query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);

// _d($listas);
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-truck-clock"></i> <?php echo __('Mensajes pendientes'); ?></h4>
                    <div class="flex-shrink-0">
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Asunto'); ?></th>
                                    <th><?php __('Fecha de envío'); ?></th>
                                    <th><?php __('Lista'); ?></th>
                                    <th class="actions" id="actions" style="width: 70px !important;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($totalRows_rsEmails > 0) {
                                    do { ?>
                                <tr>
                                    <td ><?php echo $row_rsEmails['subject_acum'] ?></td>
                                    <td ><?php echo date("d-m-Y H:i", strtotime($row_rsEmails['datetime_acum']));?></td>
                                    <td >
                                        <?php foreach (explode(',', $row_rsEmails['lista_acum']) as $lista): ?>

                                          <?php
                                              $acumba = new AcumbamailAPI($keyAcumbamail);
                                              $datos = $acumba->getListStats($lista);
                                              echo $datos['name'] . ' (' .$datos['total_subscribers'] . ')<br>';
                                          ?>
                                        <?php endforeach ?>
                                    </td>
                                    <td class="actions">
                                        <div class="dropdown d-inline-block w-100">
                                            <button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-regular fa-ellipsis align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="pendientes-edit.php?id_acum=<?php echo $row_rsEmails['id_acum'] ?>&KT_back=1" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-eye align-bottom me-1"></i> <?php echo $lang['Previsualizar'] ?></a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a href="pendientes-delete.php?id_acum=<?php echo $row_rsEmails['id_acum'] ?>" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> <?php __('Eliminar') ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails));
                                } ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
