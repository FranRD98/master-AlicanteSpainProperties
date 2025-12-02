<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

session_start();

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
$html = ob_get_contents();
ob_end_clean();

$body  = '';
$body .= '<!-- Título -->';
$body .= '<tr>';
    $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
        $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
            $body .= '<h1 style="color: #222; font-size: 24px;">';
                $body .= $langStr["Bienvenido a"]  . ' - ' . $_SERVER['HTTP_HOST'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body .= '<p>' . $langStr["Estimado"] . ' ' . $_GET['nombrecli'] . ',</p>';
                $body .= '<p>' . $langStr["Hemos registrado con éxito sus datos.<br>¡Gracias de antemano por su interés!"] . '</p>';
                $body .= '<p>' . $langStr["Saludos cordiales."] . '</p>';
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
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
$footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.';

$body = $body . $signature;

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$html = preg_replace('/{CONTENT}/', $body , $html);
$html = preg_replace('/{FOOTER}/', $footer, $html);
$html = preg_replace('/{COLOR}/', $mailColor, $html);
$html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

$subject = $langStr["Bienvenido a"]  . '  ' . $_SERVER['HTTP_HOST'];

if (sendAppEmail(array($_GET['email'] => $_GET['nombrecli']), '', '', array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), $subject, $html)) {
	   
        $query_rsInsert3 = " UPDATE  properties_client set send_welcome_cli = 1 where id_cli = '".$_GET['usr']."'  ";
        mysqli_query($inmoconn,$query_rsInsert3); 
        echo "ok";

} else {
    echo "no";
}





 ?>