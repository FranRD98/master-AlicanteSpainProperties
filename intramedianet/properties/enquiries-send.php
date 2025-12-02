<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$_GET['lang'].'.php');


$query_rsConsulta = "SELECT * FROM `properties_enquiries` WHERE `properties_enquiries`.`id_cons` = '".$_GET['cons']."'";
$rsConsulta = mysqli_query($inmoconn, $query_rsConsulta) or die(mysqli_error() . '<hr>' . $query_rsConsulta);
$row_rsConsulta = mysqli_fetch_assoc($rsConsulta);

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
                $body .= $langStr["Respuesta a su consulta en"] . ' ' . $_SERVER['HTTP_HOST'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body  .= '<p>'.$langStr["Hola"].' <strong>'.@$_GET['nombre'].'</strong> </p>';
                $body .= '<p>'.$langStr["El"].' '.@$_GET['fecha'].' '.$langStr["nos envió una consulta sobre esta propiedad"].':</p>';
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

$langVal = $_GET['lang'];
$idVal = $row_rsConsulta['inmueble_cons'];

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
$body .= ob_get_contents();
ob_end_clean();

$body .= '<tr>';
    $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
        $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body .= '<br><p><b>'.$langStr["Este es el mensaje que nos envió"].':</b></p><br>';
                $body .= nl2br($_GET['comentario']);
                $body .= '<br><br><p><b>'.$langStr["Nuestra respuesta"].':</b></p>';
                $body .= nl2br($_GET['comment']);
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

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

$subject = $langStr["Respuesta a su consulta en"] . ' ' . $_SERVER['HTTP_HOST'];

if (sendAppEmail(array($_GET['email'] => $_GET['nombre']), '', '', '', $subject, $html)) {
	echo "ok";
	
	$query_rsUpdate = "

	UPDATE `properties_enquiries` SET `respuesta_cons` = '".date("d-m-Y H:i")." -> ".preg_replace('/\'/', "\\\'", $_GET['comment'])."<hr>".$row_rsConsulta['respuesta_cons']."' WHERE `properties_enquiries`.`id_cons` = ".$_GET['cons'].";

	";
	mysqli_query($inmoconn, $query_rsUpdate);

} else {
    echo "no";
}



 ?>