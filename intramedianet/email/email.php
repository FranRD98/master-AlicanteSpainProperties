<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

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


// ------ EMAIL --------------------------------------------------------------------------

require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/ImapClientException.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/ImapConnect.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/ImapClient.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/IncomingMessage.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/IncomingMessageAttachment.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/TypeAttachments.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/TypeBody.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/Section.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/SubtypeBody.php";

require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.php";


use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;

$encryptionPortales = Imap::ENCRYPT_SSL;

try{
    $imap = new Imap($mailboxPortales, $usernamePortales, $passwordPortales, $encryptionPortales);

}catch (ImapClientException $error){
    echo $error->getMessage().PHP_EOL;
    die();
}

$fixedFolders = array('INBOX', 'Drafts', 'Sent', 'Trash');

if ($lang_adm == 'es') {
    setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
}

if ($_GET['id'] != '') {
    $imap->selectFolder($_GET['box']);
    $imap->setSeenMessage((int)$_GET['id']);
    $email = $imap->getMessage((int)$_GET['id']);
}

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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-envelope"></i> <?php echo __('Portales'); ?></h4>
                    <div class="flex-shrink-0 ms-2 d-none d-md-flex">
                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="/intramedianet/properties/enquiries.php" role="tab" aria-selected="true">
                                    <?php if($totalRows_rsConsultas > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultas; ?></span><?php } ?>
                                    <?php __('Consultas'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="/intramedianet/properties/bajada.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsbajadasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsbajadasCount; ?></span><?php } ?>
                                    <?php __('Bajada de precios'); ?>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="/intramedianet/properties/consultas.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php if($totalRows_rsConsultasCount > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultasCount; ?></span><?php } ?>
                                    <?php __('Formulario de contacto'); ?>
                                </a>
                            </li>
                            <?php if ($actPortalsEnquiries == 1): ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="/intramedianet/email/email.php" role="tab" aria-selected="false" tabindex="-1">
                                    <?php __('Portales'); ?>
                                </a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
                <div class="card-body bg-light">

                    <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="/intramedianet/properties/enquiries.php" role="tab" aria-selected="true">
                                <?php if($totalRows_rsConsultas > 0) { ?><span class="badge bg-danger ms-2 float-end"><?php echo $totalRows_rsConsultas; ?></span><?php } ?>
                                <?php __('Consultas'); ?>
                            </a>
                        </li>
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link" href="/intramedianet/properties/bajada.php" role="tab" aria-selected="false" tabindex="-1">
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
                        <li class="nav-item w-100" role="presentation">
                            <a class="nav-link active" href="/intramedianet/email/email.php" role="tab" aria-selected="false" tabindex="-1">
                                <?php __('Portales'); ?>
                            </a>
                        </li>
                        <?php endif ?>
                    </ul>

                    <div class="container-fluid" style="margin-top: 12px;">
                        <div class="email-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                            <div class="email-menu-sidebar">
                                <div class="p-4 d-flex flex-column h-100 mt-n2">
                                    <div class="mx-n4 px-4 email-menu-sidebar-scroll" data-simplebar="init">
                                        <div class="simplebar-wrapper" style="margin: 0px -24px;">
                                            <div class="simplebar-height-auto-observer-wrapper">
                                                <div class="simplebar-height-auto-observer"></div>
                                            </div>
                                            <div class="simplebar-mask">
                                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden;">
                                                        <div class="simplebar-content" style="padding: 0px 24px;">
                                                            <div class="mail-list mt-3">
                                                                <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.folders.php"; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="simplebar-placeholder" style="width: auto; height: 702px;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end email-menu-sidebar -->
                            <?php if (@$_GET['id'] == ''): ?>
                                <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.messages.php"; ?>
                            <?php else: ?>
                                <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.message.php"; ?>
                            <?php endif ?>
                        </div>
                        <!-- end email wrapper -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php /* ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-envelope"></i> <span><?php __('Email'); ?></span></h1>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="row-fix-fluid">

                <div class="mail-lat">
                    <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.folders.php"; ?>
                </div>

                <div class="mail-cont">

                    <div class="panel panel-default">

                        <?php if (@$_GET['id'] == ''): ?>
                            <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.messages.php"; ?>
                        <?php else: ?>
                            <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.message.php"; ?>
                        <?php endif ?>


                    </div>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php */ ?>

    <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.movemodal.php"; ?>

    <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.sendmodal.php"; ?>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var AppLang = '<?php echo $lang_adm ?>';
    </script>

    <script>
    $('#moveModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var mail_id = button.data('mail-id');
        var modal = $(this)
        modal.find('.modal-body #mail-id').val(mail_id)
    });
    $('#moveModal #movebtn').click(function(e) {
        if ($('#moveModal #folder').val() == '') {
            alert('<?php __('Seleccione una carpeta'); ?>');
            return false;
        }
        $(this).html($(this).data('loading-text'));
        $.get("move.php?id="+$('#moveModal #mail-id').val()+"&b=<?php echo $_GET['box'] ?>&f="+$('#moveModal #folder').val(), function(data) {
            <?php if ($_GET['id'] != ''): ?>
                window.location.href = '/intramedianet/email/email.php?box=' + $('#moveModal #folder').val();
            <?php else: ?>
                location.reload();
            <?php endif ?>
        });
    });
    $('.btn-delete-mail').click(function(event) {
        if (!confirm('<?php __('¿Seguro que desea borrar este mensaje?'); ?>')) {
            return false;
        }
        $.get("move.php?id="+$(this).data('mail-id')+"&b=<?php echo $_GET['box'] ?>&f=Trash", function(data) {
            <?php if ($_GET['id'] != ''): ?>
                window.location.href = '/intramedianet/email/email.php?box=<?php echo $_GET['box'] ?>';
            <?php else: ?>
                location.reload();
            <?php endif ?>
        });
    });
    $('#sendModal #sendbtn').click(function(e) {
        var emailCheck=/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;
        if ($('#sendModal #tosend').val() == '') {
            alert('<?php __('Introduzca un email de destino'); ?>');
            $('#sendModal #tosend').focus();
            return false;
        }
        if (!emailCheck.test($('#sendModal #tosend').val())) {
            alert('<?php __('Introduzca un email de destino'); ?>');
            $('#sendModal #tosend').focus();
            return false;
        }
        if ($('#sendModal #subjectsend').val() == '') {
            alert('<?php __('Introduzca un asunto'); ?>');
            $('#sendModal #subjectsend').focus();
            return false;
        }
        if ($('#sendModal #mensasend').val() == '') {
            alert('<?php __('Introduzca un mensaje'); ?>');
            return false;
        }
        $(this).html($(this).data('loading-text'));
        $.post("send.php", {from: "<?php echo $_SESSION['kt_login_user'] ?>", to: $('#sendModal #tosend').val(), subject: $('#sendModal #subjectsend').val(), message: $('#sendModal #mensasend').val()}, function(data) {
            if (data == 'ok') {
                alert('<?php __('El mensaje se ha enviado correctamente'); ?>');
                location.reload();
            }
        });
    });

    var isShowMenu = false;
    var emailMenuSidebar = document.getElementsByClassName('email-menu-sidebar');
    Array.from(document.querySelectorAll(".email-menu-btn")).forEach(function (item) {
        item.addEventListener("click", function () {
            Array.from(emailMenuSidebar).forEach(function (elm) {
                elm.classList.add("menubar-show");
                isShowMenu = true;
            });
        });
    });

    window.addEventListener('click', function (e) {
        if (document.querySelector(".email-menu-sidebar").classList.contains('menubar-show')) {
            if (!isShowMenu) {
                document.querySelector(".email-menu-sidebar").classList.remove("menubar-show");
            }
            isShowMenu = false;
        }
    });
    </script>


</body>
</html>
