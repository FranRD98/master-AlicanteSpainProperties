<?php
// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/paginator/paginator.class.php' );

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


$offset = 0;
$count = 20;

if ($_GET['page'] > 0) {
    $offset = $_GET['page']-1;
}

$MailChimp = new MailChimp($keyMailchimp);
$miembros = $MailChimp->get('lists/' . $mailchimpIdListaPrincipal . '/segments/' . $_GET['id'] . '/members', array(
            'count' => $count,
            'interest_ids' => $_GET['id'],
            'status' => 'subscribed',
            'offset' => $offset*$count
		));

// echo "<br><br><br><br><br><br><br><br>";
// _d($miembros);

// _d($miembros);

function _d($var) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}
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
            <!-- <a href="/intramedianet/mailchimp/usuarios-add.php?id=<?php echo $_GET['id'] ?>&name=<?php echo $_GET['name'] ?>" class="btn btn-success btn-sm"><?php __('Añadir'); ?></a> -->
            <a href="segments.php" class="btn btn-default btn-sm"><?php __('Volver'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $_GET['name'] ?> &raquo; <?php echo number_format($miembros['total_items'], 0, ',', '.'); ?> <?php __('Usuarios'); ?></h3>
                </div>

                <div class="panel-body">

					<div class="table-responsive">

                        <form method="get" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">
                        <!-- <div class="well">
                            <div class="input-group">
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                                <input type="hidden" name="name" value="<?php echo $_GET['name'] ?>">
                                <input type="text" class="form-control" name="q" id="q" placeholder="Search for..." value="<?php echo $_GET['q'] ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                    <a href="usuarios.php?id=<?php echo $_GET['id'] ?>&name=<?php echo $_GET['name'] ?>" class="btn btn-danger">Clear</a>
                                </span>
                            </div>
                        </div> -->
                        </form>

						<table class="table table-striped table-bordered dataTable" id="records-tables" width="100%">
							<thead>
								<tr>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('Email'); ?></th>
									<th><?php __('Añadido'); ?></th>
									<th><?php __('Actualizado'); ?></th>
							        <th id="actions"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($miembros['members'] as $key => $value) { ?>
								<tr>
                                    <td ><?php echo $value['merge_fields']['FNAME'] ?> <?php echo $value['merge_fields']['LNAME'] ?></td>
									<td ><?php echo $value['email_address'] ?></td>
									<td ><?php echo date("d-m-Y H:i", strtotime($value['timestamp_opt'])); ?></td>
									<td ><?php echo date("d-m-Y H:i", strtotime($value['last_changed'])); ?></td>
									<td class="actions">
                                        <!-- <a href="usuarios-edit.php?id=<?php echo $_GET['id'] ?>&name=<?php echo $_GET['name'] ?>&usr=<?php echo $value['id'] ?>&KT_back=1" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a> -->
                                        <a href="usuarios-delete.php?id=<?php echo $_GET['id'] ?>&name=<?php echo $_GET['name'] ?>&usr=<?php echo $value['id'] ?>" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>

						<ul class="pagination pagination-sm pull-right">
							<?php
							$pages = new Paginator;
							$pages->items_total = $miembros['total_items'];
                            $pages->mid_range = $count;
                            $pages->default_ipp = $count;
							$pages->paginate();
							echo $pages->display_pages();
							?>
						</ul>

                    </div>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var listID = '<?php echo $_GET['id']; ?>';
    </script>

    <script src="_js/users-list.js" type="text/javascript"></script>

</body>
</html>
