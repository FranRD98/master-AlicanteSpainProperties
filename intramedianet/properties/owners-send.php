<?php

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
    $body .= '<td align="center-" style="padding: 20px 30px 0 30px;">';
        $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
            $body .= '<h1 style="color: #222; font-size: 24px;">';
                $body .= $langStr['Tus propiedades'] .' - ' . $_SERVER['HTTP_HOST'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body .= nl2br($_GET['comment']);
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

$ids = explode(',', $_GET['ids']);

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

for ($i=0; $i < count($ids); $i++) {
	$langVal = $_GET['lang'];
    $idVal = $ids[$i];

    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
    $body .= ob_get_contents();
    ob_end_clean();
}

$footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
$footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
$footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';
$footer .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['lang'] . '/unsubscribe/?id=' . encryptIt($row_rsCli['id_cli'],$nombreEmpresa) . '" style="color: #000; text-decoration: none; font-weight: bold;">' .$langStr["Darme de baja"] . '</a>';

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$html = preg_replace('/{CONTENT}/', $body , $html);
$html = preg_replace('/{FOOTER}/', $footer, $html);
$html = preg_replace('/{COLOR}/', $mailColor, $html);
$html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

$subject = $langStr['Tus propiedades'] .' - ' . $_SERVER['HTTP_HOST'];

if (sendAppEmail(array($_GET['email'] => $_GET['nombre']), '', '', '', $subject, $html)) {
	echo "ok";
	mysqli_query($inmoconn,$query_rsInsert2);
} else {
    echo "no";
}





 ?>