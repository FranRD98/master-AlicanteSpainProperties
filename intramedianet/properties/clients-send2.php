<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');

function encryptIt($idCli, $encryptionKey = 'DLusjkq6kkzRUbY7TVc7YH2RcT2')
{
    global $_SERVER;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_key = $_SERVER['HTTP_HOST'];
    $encryption_iv = $_SERVER['HTTP_HOST'];

    $encryption = openssl_encrypt($idCli, $ciphering,
            $encryption_key, $options, $encryption_iv);
    return $encryption;
}

session_start();

$show_rate = 1;

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
$html = ob_get_contents();
ob_end_clean();

$body  = '';
$body .= '<!-- Título -->';
$body .= '<tr>';
    $body .= '<td align="center-" style="padding: 20px 30px 0 30px;">';
        $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
            $body .= '<h1 style="color: #222; font-size: 24px;">';
                $body .= $_GET['subject'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body .= $_GET['comment'];
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

$ids = explode(',', $_GET['ids']);

// $body  .= "<h4 style=\"font-weight: 200; padding: 30px 10px 20px 0; color: ".$mailColor."; font-size: 22px;\">" . $langStr['Propiedades'] . "</h4>";

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

$query_rsCli = "SELECT * FROM properties_client WHERE email_cli = '".$_GET['email']."' ";
$rsCli = mysqli_query($inmoconn, $query_rsCli) or die(mysqli_error());
$row_rsCli = mysqli_fetch_assoc($rsCli);

if ($langVal == $language) {
    $urlstart = '/';
} else {
    $urlstart = '/'.$langVal.'/';
}

if ($ids[0] > 0) {
    for ($i=0; $i < 1; $i++) {

           $langVal = $_GET['lang'];
            $idVal = $ids[$i];

            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
            $body .= ob_get_contents();
            ob_end_clean();

        $tipo = 2;

        if ($_GET['tipo'] != '') {
            $tipo = $_GET['tipo'];
        }

        if ($_GET['comment'] == '') {
            $_GET['comment'] = $body;
        }

        if ($smtpUrl != 'smtp.acumbamail.com') {
            $query_rsInsert3 = "
                INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
                ( NULL, '".$_SESSION['kt_login_id']."',  '".$ids[$i]."',  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  '".$tipo."', '".mysqli_real_escape_string($inmoconn,$_GET['comment'])."', '".date("Y-m-d H:i:s")."' )
            ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        $query_rsInsert2 = "

            INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
            ( NULL ,  '".$ids[$i]."',  '".getIp()."',  '".date("Y-m-d H:i:s")."', '".$_SESSION['kt_login_id']."', '".$_GET['usr']."' )

        ";
        mysqli_query($inmoconn,$query_rsInsert2);


    }
}

if (!empty($_GET['propsprom1'])) {
    foreach ($_GET['propsprom1'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/prom-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}

if (!empty($_GET['propsnews1'])) {
    foreach ($_GET['propsnews1'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/news-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}

if ($ids[1] > 0) {

    $body .= '<tr>';

    $body .= '<td style="padding: 0 30px 20px 30px;">';

    $body .= '<h3 style="font-size: 28px; color: #333; text-align: center;">🔎 ' . $langStr["También te pueden interesar"] . ':</h3>';

    $body .= '<table width="100%" cellpadding="0" cellspacing="0">';

    $body .= '<tr>';

    for ($i=1; $i < count($ids); $i++) {

        $body .= "<td>";

        $langVal = $_GET['lang'];
        $idVal = $ids[$i];

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate_mini.php');
        $body .= ob_get_contents();
        ob_end_clean();

        $tipo = 2;

        if ($_GET['tipo'] != '') {
            $tipo = $_GET['tipo'];
        }

        if ($_GET['comment'] == '') {
            $_GET['comment'] = $body;
        }

        if ($smtpUrl != 'smtp.acumbamail.com') {
            $query_rsInsert3 = "
                INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
                ( NULL, '".$_SESSION['kt_login_id']."',  '".$ids[$i]."',  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  '".$tipo."', '".mysqli_real_escape_string($inmoconn,$_GET['comment'])."', '".date("Y-m-d H:i:s")."' )
            ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        $query_rsInsert2 = "

            INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
            ( NULL ,  '".$ids[$i]."',  '".getIp()."',  '".date("Y-m-d H:i:s")."', '".$_SESSION['kt_login_id']."', '".$_GET['usr']."' )

        ";
        mysqli_query($inmoconn,$query_rsInsert2);

        $body .= "</td>";

        if ($i%2 == 0) {
            $body .= '</tr>';
            $body .= '<tr>';
        }

    }

    $body .= '</tr>';

    $body .= '</table>';

    $body .= '</td>';

    $body .= '</tr>';

    $body .= '<tr>';

    $body .= '<td style="padding: 0 30px 20px 30px;">';

    $body .= '<p>';
    $body .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart  . 'rate/?id_cli=' . $row_rsCli['nombre_cli'] . '&id_props=' . $_GET['ids'] . '" style="background-color: ' . $mailColor . '; color: #fff; padding: 15px 20px; text-decoration: none; border-radius: 223px; display: inline-block; border-radius: 23px; display: block; max-width: 100%; text-align: center; font-size: 16px;">📝 ' . $langStr["Valora las casas que te hemos enviado"] . '</a>';
    $body .= '</p>';

    $body .= '<p style="font-size: 14px; text-align: center; font-weight:bold">' . $langStr["Nos ayudas a enviarte solo lo que realmente te interesa"] . '</p>';

    $body .= '</td>';

    $body .= '</tr>';

    $body .= '<tr>';
       $body .= '<td style="padding: 20px 30px;">';
           $body .= '<div style="display: block; border-top: 1px solid #dedede;"></div>';
       $body .= '</td>';
    $body .= '</tr>';

}

if (!empty($_GET['propsciu1'])) {
    foreach ($_GET['propsciu1'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/ciu-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}

if ($ids[0] > 0) {
    $body .= '<!-- CTA final combinado -->';
    $body .= '<tr>';
        $body .= '<td align="center" style="padding: 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: ' . $mailColor . ' ; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<p style="font-size: 28px; color: #fff;"><strong>' . $langStr["¿Quieres ver más opciones?"] . '</strong></p>';
                $body .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['properties'][$_GET['lang']] . '" style="background-color: ' . $mailSecondaryColor . '; color: #fff; padding: 15px 20px; text-decoration: none; border-radius: 223px; display: inline-block; border-radius: 23px; display: block; max-width: 100%; text-align: center; font-size: 16px;">🔍 ' . $langStr["Ver más propiedades"] . '</a>';
                $body .= '<br>';
                $body .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['contact'][$_GET['lang']] . '" style="color: #fff; text-decoration: none; font-size: 16px;">📝 ' . $langStr["Cuéntanos qué estás buscando"] . '</a>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';
}

$signature = '';
if ($_SESSION['kt_login_id']) {
    
    $query_rsAdmin = "SELECT * FROM users WHERE id_usr = '".$_SESSION['kt_login_id']."'";
    $rsAdmin = mysqli_query($inmoconn,$query_rsAdmin) or die(mysqli_error());
    $row_rsAdmin = mysqli_fetch_assoc($rsAdmin);
    $totalRows_rsAdmin = mysqli_num_rows($rsAdmin);

    if ($row_rsAdmin['firma_' . $_GET['lang'] . '_usr'] != '') {

        $body .= '<!-- Firma visual de equipo -->';
        $body .= '<tr>';
        $body .= '<td style="padding: 30px; background-color: #fff; color: #000; font-size: 14px; line-height: 1.6em; border-top: 1px solid #ebebeb">';
        $body .= nl2br($row_rsAdmin['firma_' . $_GET['lang'] . '_usr']);
        $body .= '</td>';
        $body .= '</tr>';
    }
}

$footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
$footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
$footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';
$footer .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['lang'] . '/unsubscribe/?id=' . encryptIt($row_rsCli['id_cli'],$nombreEmpresa) . '" style="color: #000; text-decoration: none; font-weight: bold;">' .$langStr["Darme de baja"] . '</a>';

$body = $body . $signature;

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$body = preg_replace('/{PROPS}/', $_GET['ids'], $body);
$body = preg_replace('/{{CLIENT}}/', $row_rsCli['nombre_cli'], $body);
$body = preg_replace('/{CLIENT}/', $row_rsCli['id_cli'], $body);
$html = preg_replace('/{CONTENT}/', $body , $html);
$html = preg_replace('/{FOOTER}/', $footer, $html);
$html = preg_replace('/{COLOR}/', $mailColor, $html);
$html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

$html = preg_replace('/{RATE}/', $langStr["Rate this property"], $html);
$subject = $langStr['Propiedades recomendadas'] .' - ' . $_SERVER['HTTP_HOST'];

if ($_GET['subject'] != '') {
    $subject = $_GET['subject'];
}

$html = preg_replace('/{URLBAJA}/', 'https://'.$_SERVER['HTTP_HOST'].'/'. $_GET['lang'].'/unsubscribe/?id='.encryptIt($row_rsCli['id_cli'],$nombreEmpresa), $html);

if ($smtpUrl == 'smtp.acumbamail.com') {

    $acumba = new AcumbamailAPI($keyAcumbamailSMTP);
    if ($_GET['cco'] == '') {
        $result = $acumba->sendOne($fromMail, $_GET['email'], $html, $subject);
    } else {
        $result = $acumba->sendOne($fromMail, $_GET['email'], $html, $subject, $_GET['cco'], '');
    }

    if ($result['result'][0]['message_id'] != '') {

        for ($i=0; $i < count($ids); $i++) {
            $query_rsInsert3 = "
                INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`) VALUES
                ( NULL, '".$_SESSION['kt_login_id']."',  '".$ids[$i]."',  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  '".$tipo."', '".mysqli_real_escape_string($inmoconn,$_GET['comment'])."', '".date("Y-m-d H:i:s")."', '" . $result['result'][0]['message_id'] . "' )
            ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        echo "ok";
    } else {
        echo "no";
    }

    die();

}

if (sendAppEmail(array($_GET['email'] => $_GET['nombre']), '', $_GET['cco'], array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), $subject, $html)) {
	echo "ok";
} else {
    echo "no";
}