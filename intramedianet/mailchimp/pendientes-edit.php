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
$listas = $MailChimp->get('campaigns/' . $_GET['id'], array(
    // 'sort_field' => 'web'
));
$content = $MailChimp->get('campaigns/' . $_GET['id'] . '/content', array(
    // 'sort_field' => 'web'
));

// _d($content);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

	<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

	<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-envelope-o"></i> <span><?php __('Newsletter'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <!-- <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm" /> -->
            <input type="button" name="KT_Cancel1" value="<?php __("Volver"); ?>" onClick="window.location='pendientes.php'" class="btn btn-sm" />
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Ver mensaje'); ?>: <?php echo $listas['settings']['subject_line'] ?></h3>
                </div>

                <div class="panel-body">

                    <p class="lead"><b><?php __('Fecha de envío'); ?>:</b> <?php echo date("d-m-Y H:i", strtotime($listas['send_time']));?></p>

                    <hr>

                    <?php echo $content['html'] ?>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    </form>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
