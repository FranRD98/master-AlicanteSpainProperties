<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);


// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );

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

$MailChimp = new MailChimp($keyMailchimp);
$listas = $MailChimp->get('campaigns', array(
    'count' => '50',
    'status' => 'save',
    'sort_field' => 'create_time'
));

// _d($listas);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

	<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

	<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-envelope-o"></i> <span><?php __('Newsletter'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="/intramedianet/mailchimp/listas-add.php" class="btn btn-success btn-sm"><?php __('Añadir'); ?></a>
            <a href="/intramedianet/mailchimp/index.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Mensajes pendientes'); ?></h3>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered dataTable" id="records-tables" width="100%">
        				<thead>
        					<tr>
                                <th><?php __('ID'); ?></th>
        						<th><?php __('Asunto'); ?></th>
        						<th><?php __('Creado'); ?></th>
        						<th><?php __('Fecha de envío'); ?></th>
        						<th><?php __('Lista'); ?></th>
                                <th class="actions" id="actions" style="width: 140px;"></th>
        					</tr>
        				</thead>
        				<tbody>
        					<?php foreach ($listas['campaigns'] as $key => $value) { ?>
        					<tr>
                                <td ><?php echo $value['web_id'] ?></td>
                                <td ><?php echo $value['settings']['subject_line'] ?></td>
                                <td ><?php echo date("d-m-Y H:i", strtotime($value['create_time']));?></td>
                                <td ><?php echo date("d-m-Y H:i", strtotime($value['send_time']));?></td>
                                <td ><?php echo $value['recipients']['list_name'] ?><br><?php

                                foreach ($value['recipients']['segment_opts']['conditions'] as $tags) {
                                    if ($tags['value'] == $mailchimpIdListaClients) {
                                        echo "<span class=\"label label-default\">".__('Cliente', true)."</span> ";
                                    }
                                    if ($tags['value'] == $mailchimpIdListaOwners) {
                                        echo "<span class=\"label label-default\">".__('Propietario', true)."</span> ";
                                    }
                                    if ($tags['value'] == $mailchimpIdListaWebsite) {
                                        echo "<span class=\"label label-default\">".__('Website', true)."</span> ";
                                    }
                                    foreach ($mailchimpIdListaIdiomas as $idm => $idmval) {
                                        if ($tags['value'] == $idmval) {
                                            echo "<span class=\"label label-default\">".$languages_names[$idm]."</span> ";
                                        }
                                    }
                                } ?></td>
        						<td class="actions">
                                    <a href="pendientes-edit.php?id=<?php echo $value['id'] ?>&KT_back=1" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="pendientes-delete.php?id=<?php echo $value['id'] ?>" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash-o"></i></a>
        						</td>
        					</tr>
        					<?php } ?>
        				</tbody>
        			</table>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
