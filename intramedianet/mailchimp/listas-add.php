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

if ($_POST['list-name'] != '' && $_POST['from-name'] != '' && $_POST['email-name'] != '' && $_POST['email-subject'] != '') {
    $MailChimp = new MailChimp($keyMailchimp);
    $result = $MailChimp->post('lists', array(
                    'name'                => $_POST['list-name'],
                    'permission_reminder' => $Mailchimp_permisions_reminders,
                    'contact'   => array(
                                                'company'   => $Mailchimp_dc_company,
                                                'address1'  => $Mailchimp_dc_address1,
                                                'city'      => $Mailchimp_dc_city,
                                                'state'     => $Mailchimp_dc_state,
                                                'zip'       => $Mailchimp_dc_zip,
                                                'country'   => $Mailchimp_dc_country
                                            ),
                    'campaign_defaults'   => array(
                                                'from_name'   => $_POST['from-name'],
                                                'from_email'  => $_POST['email-name'],
                                                'subject'     => $_POST['email-subject'],
                                                'language'    => 'en'
                                            ),
                    'email_type_option'      => false
                ));

    header("Location: listas.php");
}

// _d($result);
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
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success btn-sm" />
            <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='listas.php'" class="btn btn-sm" />
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Add list'); ?></h3>
                </div>

                <div class="panel-body">

                    <div class="form-group">
                        <label for="list-name"><?php __('Nombre de la lista'); ?></label>
                        <input type="text" name="list-name" id="list-name" value="<?php echo $listas['name'] ?>" size="32" maxlength="255" class="form-control required">
                    </div>

                    <div class="form-group">
                        <label for="from-name"><?php __('Nombre a mostrar'); ?></label>
                        <input type="text" name="from-name" id="from-name" value="<?php echo $listas['campaign_defaults']['from_name'] ?>" size="32" maxlength="255" class="form-control required">
                    </div>

                    <div class="form-group">
                        <label for="email-name"><?php __('Email'); ?></label>
                        <input type="text" name="email-name" id="email-name" value="<?php echo $listas['campaign_defaults']['from_email'] ?>" size="32" maxlength="255" class="form-control required email">
                    </div>

                    <div class="form-group">
                        <label for="email-subject"><?php __('Asunto'); ?></label>
                        <input type="text" name="email-subject" id="email-subject" value="<?php echo $listas['campaign_defaults']['subject'] ?>" size="32" maxlength="255" class="form-control required">
                    </div>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    </form>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
