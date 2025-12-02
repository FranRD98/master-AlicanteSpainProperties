<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

$query_rsCli = "SELECT * FROM properties_owner WHERE email_pro = '".$_GET['email']."' ";
$rsCli = mysqli_query($inmoconn, $query_rsCli) or die(mysqli_error());
$row_rsCli = mysqli_fetch_assoc($rsCli);

if ($langVal == $language) {
    $urlstart = '/';
} else {
    $urlstart = '/'.$langVal.'/';
}

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
$html = ob_get_contents();
ob_end_clean();

if (preg_match('/{{PROPERTY-([\d|,]+)}}/', $_GET['message'], $matches)) {
    $ids = explode(",",$matches[1]);
    $langVal = $_GET['lang'];
    $propertiesContent ="";
    foreach ($ids as $id) {

        $query_rsInsert2 = "
            INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
            ( NULL ,  '".$id."',  '".getIp()."',  '".date("Y-m-d H:i:s")."', '".$_SESSION['kt_login_id']."', '".$_GET['usr']."' )
        ";
        mysqli_query($inmoconn,$query_rsInsert2);
        $idVal = $id;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
        $property_code = ob_get_contents();
        ob_end_clean();
        $propertiesContent.= $property_code;
        if ($smtpUrl != 'smtp.acumbamail.com') {
            $query_rsInsert3 = "
            INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
            ( NULL, '".$_SESSION['kt_login_id']."',  '".$id."',  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  ".mysqli_real_escape_string($inmoconn,$_GET['tipo']).", '".mysqli_real_escape_string($inmoconn,$_GET['subject']).'<hr>'.mysqli_real_escape_string($inmoconn,$_GET['message'])."', '".date("Y-m-d H:i:s")."' )
            ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }
    }
    $_GET['message'] = str_replace($matches[0], '<table>' . $propertiesContent . '</table>', $_GET['message']);
    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 30px 30px 30px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $_GET['subject'];
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= $_GET['message'];
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';
} else {
    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 30px 30px 30px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $_GET['subject'];
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= $_GET['message'];
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';
    if ($smtpUrl != 'smtp.acumbamail.com') {
        $query_rsInsert3 = "
        INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
        ( NULL, '".$_SESSION['kt_login_id']."',  0,  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  ".mysqli_real_escape_string($inmoconn,$_GET['tipo']).", '".mysqli_real_escape_string($inmoconn,$_GET['subject']).'<hr>'.mysqli_real_escape_string($inmoconn,$_GET['message'])."', '".date("Y-m-d H:i:s")."' )
        ";
        mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
    }
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
// $footer .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['lang'] . '/unsubscribe/?id=' . encryptIt($row_rsCli['id_cli'],$nombreEmpresa) . '" style="color: #000; text-decoration: none; font-weight: bold;">' .$langStr["Darme de baja"] . '</a>';

$body = $body . $signature;

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$body = preg_replace('/{{CLIENT}}/', $row_rsCli['nombre_pro'], $body);
$html = preg_replace('/{CONTENT}/', $body , $html);
$html = preg_replace('/{FOOTER}/', $footer, $html);
$html = preg_replace('/{COLOR}/', $mailColor, $html);
$html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

$subject = $_SERVER['HTTP_HOST'] . ' - ' . $_GET['subject'];

if ($smtpUrl == 'smtp.acumbamail.com') {

    $acumba = new AcumbamailAPI($keyAcumbamailSMTP);
    if ($_GET['cco'] == '') {
        $result = $acumba->sendOne($fromMail, $_GET['email'], $html, $subject);
    } else {
        $result = $acumba->sendOne($fromMail, $_GET['email'], $html, $subject, $_GET['cco'], '');
    }

    if ($result['result'][0]['message_id'] != '') {

        if (preg_match('/{{PROPERTY-([\d|,]+)}}/', $_GET['message'], $matches)) {
            $ids = explode(",",$matches[1]);
            foreach ($ids as $id) {
                $query_rsInsert3 = "
                INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`) VALUES
                ( NULL, '".$_SESSION['kt_login_id']."',  '".$id."',  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  ".mysqli_real_escape_string($inmoconn,$_GET['tipo']).", '".mysqli_real_escape_string($inmoconn,$_GET['subject']).'<hr>'.mysqli_real_escape_string($inmoconn,$body)."', '".date("Y-m-d H:i:s")."', '" . $result['result'][0]['message_id'] . "' )
                ";
                mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
            }
        } else {
            $query_rsInsert3 = "
            INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`) VALUES
            ( NULL, '".$_SESSION['kt_login_id']."',  0,  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  ".mysqli_real_escape_string($inmoconn,$_GET['tipo']).", '".mysqli_real_escape_string($inmoconn,$_GET['subject']).'<hr>'.mysqli_real_escape_string($inmoconn,$body)."', '".date("Y-m-d H:i:s")."', '" . $result['result'][0]['message_id'] . "' )
            ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        echo "ok";
    } else {
        echo "no";
    }

    $query_rsInsert3 = "
        INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
        ( NULL, '".$_SESSION['kt_login_id']."',  0,  '".mysqli_real_escape_string($inmoconn, $_GET['email'])."',  ".mysqli_real_escape_string($inmoconn, $_GET['tipo']).", '".mysqli_real_escape_string($inmoconn, $_GET['subject']).'<hr>'.mysqli_real_escape_string($inmoconn,$body)."', '".date("Y-m-d H:i:s")."' )
    ";
    mysqli_query($inmoconn, $query_rsInsert3) or die(mysqli_error());

    die();

}

if (sendAppEmail(array($_GET['email'] => $_GET['nombre']), '', $_GET['cco'], array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), $subject, $html)) {
    $query_rsInsert3 = "
        INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
        ( NULL, '".$_SESSION['kt_login_id']."',  0,  '".mysqli_real_escape_string($inmoconn, $_GET['email'])."',  ".mysqli_real_escape_string($inmoconn, $_GET['tipo']).", '".mysqli_real_escape_string($inmoconn, $_GET['subject']).'<hr>'.mysqli_real_escape_string($inmoconn,$body)."', '".date("Y-m-d H:i:s")."' )
    ";
    mysqli_query($inmoconn, $query_rsInsert3) or die(mysqli_error());
	echo "ok";
} else {
    echo "no";
}





 ?>
