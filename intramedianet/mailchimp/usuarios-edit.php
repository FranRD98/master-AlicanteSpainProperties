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
$listas = $MailChimp->get('lists/' . $_GET['id'] . '/members/' . $_GET['usr'], array(
    // 'sort_field' => 'web'
));

// _d($listas);

if ($_POST['usr-email'] != '') {
    $MailChimp = new MailChimp($keyMailchimp);
    $result = $MailChimp->patch('lists/' . $_GET['id'] . '/members/' . $_GET['usr'], array(
                    'email_address' => $_POST['usr-email'],
                    'status'        => 'subscribed',
                    'merge_fields'    => array('FNAME'=>$_POST['usr-name'], 'LNAME'=>$_POST['usr-surname'])
                ));

    // _d($result);

    header("Location: usuarios.php?id=" . $_GET['id'] . "&name=" . $_GET['name']);
}
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
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm" />
            <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='usuarios.php?id=<?php echo $_GET['id'] ?>'" class="btn btn-sm" />
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Edit User'); ?>: <?php echo $listas['email_address'] ?></h3>
                </div>

                <div class="panel-body">

                    <div class="form-group">
                        <label for="usr-name"><?php __('Nombre'); ?></label>
                        <input type="text" name="usr-name" id="usr-name" value="<?php echo $listas['merge_fields']['FNAME'] ?>" size="32" maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="usr-surname"><?php __('Apellidos'); ?></label>
                        <input type="text" name="usr-surname" id="usr-surname" value="<?php echo $listas['merge_fields']['LNAME'] ?>" size="32" maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="usr-email"><?php __('Email'); ?></label>
                        <input type="text" name="usr-email" id="usr-email" value="<?php echo $listas['email_address'] ?>" size="32" maxlength="255" class="form-control required email">
                    </div>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    </form>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
