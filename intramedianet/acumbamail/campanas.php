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

if ($_GET['start'] == '') {
    $_GET['start'] = 0;
}

if ($_GET['end'] == '') {
    $_GET['end'] = 10;
}

function _d($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

$acumba = new AcumbamailAPI($keyAcumbamail);
$campanas = $acumba->getCampaigns();
krsort($campanas);

// _d($campanas);
// die();
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-envelope-open-text"></i> <?php __('Campañas'); ?></h4>
                    <div class="flex-shrink-0">
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('ID'); ?></th>
                                    <th><?php __('Campaña'); ?></th>
                                    <th><?php __('Status'); ?></th>
                                    <th><?php __('Listas'); ?></th>
                                    <th><?php __('Emails'); ?></th>
                                    <th><?php __('Abiertos'); ?></th>
                                    <th><?php __('Clicks'); ?></th>
                                    <th class="actions" id="actions"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($campanas, $_GET['start'], $_GET['end']) as $key => $value) { ?>
                                    <tr>
                                        <?php foreach ($value as $id => $name): ?>
                                        <td ><?php echo $id ?></td>
                                        <?php $info = $acumba->getCampaignBasicInformation($id); ?>
                                        <?php $info2 = $acumba->getCampaignTotalInformation($id); ?>
                                        <td ><?php echo $name ?> - <smnall class="text-muted" style="font-size: 12px;"><?php echo date('d-m-Y H:i', strtotime($info['date'])) . '</small><br><smnall class="text-dark" style="font-size: 14px;">' . $info['subject']; ?></smnall></td>
                                        <td ><?php __($info['status']); ?></td>
                                        <td >
                                            <?php
                                            $nombres = array();
                                            foreach ($info['lists'] as $status) {
                                                $namelist = $acumba->getListStats($status);
                                                if ($namelist['name'] != '') {
                                                    array_push($nombres, '<a href="https://acumbamail.com/list/' . $status . '/" target="_blank" class="btn btn-soft-primary btn-sm">' . $namelist['name'] . '</a>');
                                                }
                                            }
                                            echo implode(' ', $nombres);
                                            ?>
                                        </td>
                                        <td><?php echo number_format($info['total_sent'], 0, ',', '.') ?></td>
                                        <td><?php echo number_format($info2['opened'], 0, ',', '.') ?></td>
                                        <td><?php echo number_format($info2['total_clicks'], 0, ',', '.') ?></td>
                                        <td class="actions">
                                            <div class="dropdown d-inline-block w-100">
                                                <button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-regular fa-ellipsis align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a href="<?php echo $info2['campaign_url'] ?>" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-eye align-bottom me-1"></i> <?php __('Ver newsletter') ?></a></li>
                                                    <?php if ($info['status'] == 'Sent') { ?>
                                                    <li><a href="https://acumbamail.com/report/campaign/<?php echo $id ?>/" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pie-chart align-bottom me-1"></i> <?php __('Ver estadísticas') ?></a></li>
                                                    <?php } else { ?>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </td>
                                        <?php endforeach ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <?php
                                $paginas = count($campanas)/10;

                                echo __('Ir a página:', true) . ' <select name="start" id="start" class="form-select form-select-sm" style="display: inline-block; width: auto;">';
                                for ($i=1; $i <= intval($paginas); $i++) {
                                    $selected = ((($i*10)-10) == $_GET['start'])?'selected':'';
                                    echo '<option value="' . (($i*10)-10) . '" ' . $selected . '>' . $i . '</option>';
                                }
                                if ((count($campanas)/10) >= intval($paginas)) {
                                    $selected = ((($i*10)-10) == $_GET['start'])?'selected':'';
                                    echo '<option value="' . (($i*10)-10) . '" ' . $selected . '>' . ($i) . '</option>';
                                }
                                echo '</select>';
                                ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
        $('#start').change(function() {
            window.location = '/intramedianet/acumbamail/campanas.php?start=' + $(this).val();
        });
    </script>

</body>
</html>
