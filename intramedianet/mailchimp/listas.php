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
$listas = $MailChimp->get('lists', array(
    'count' => 100,
    'sort_field' => 'date_created',
    'sort_dir' => 'ASC'
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
            <a href="/intramedianet/mailchimp/segments-add.php" class="btn btn-success btn-sm"><?php __('Añadir'); ?></a>
            <a href="/intramedianet/mailchimp/index.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Listas'); ?></h3>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered dataTable" id="records-tables" width="100%">
        				<thead>
        					<tr>
                                <th><?php __('ID'); ?></th>
        						<th><?php __('Nombre'); ?></th>
        						<th><?php __('De'); ?></th>
        						<th><?php __('Asunto'); ?></th>
        						<th><?php __('Usuarios'); ?></th>
                                <th class="actions" id="actions" style="width: 140px;"></th>
        					</tr>
        				</thead>
        				<tbody>
        					<?php foreach ($listas['lists'] as $key => $value) { ?>
                                <?php if ($value['id'] != '19e6bae365' && $value['id'] != '5c3867e968' && $value['id'] != 'cb3d62d8b9'): ?>
                					<tr>
                                        <td ><?php echo $value['id'] ?></td>
                						<td ><?php echo $value['name'] ?></td>
                						<td ><?php echo $value['campaign_defaults']['from_name'] ?> &lt;<?php echo $value['campaign_defaults']['from_email'] ?>&gt;</td>
                						<td ><?php echo $value['campaign_defaults']['subject'] ?></td>
                						<td ><?php echo number_format($value['stats']['member_count'], 0, ',', '.'); ?></td>
                						<td class="actions">
                                            <a href="listas-edit.php?id=<?php echo $value['id'] ?>&KT_back=1" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                            <a href="listas-delete.php?id=<?php echo $value['id'] ?>" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash-o"></i></a>
                							<a href="usuarios.php?id=<?php echo $value['id'] ?>&name=<?php echo $value['name'] ?>" class="btn btn-info btn-sm"><i class="fa fa-users"></i></a>
                						</td>
                					</tr>
                                <?php endif ?>
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
