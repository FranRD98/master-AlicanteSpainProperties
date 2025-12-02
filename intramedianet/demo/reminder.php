<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

$query_rsUsers = "SELECT * FROM `users` WHERE DATE(registrationdate_usr) = DATE_SUB(CURDATE(), INTERVAL 3 DAY)";
$rsUsers = mysqli_query($inmoconn, $query_rsUsers) or die(mysqli_error() . '<hr>' . $query_rsUsers);
$row_rsUsers = mysqli_fetch_assoc($rsUsers);
$totalRows_rsUsers = mysqli_num_rows($rsUsers);

do {

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
                    $body .= '¿Has probado ya la DEMO del CRM  de Mediaelx para inmobiliarias?/Have you tried the DEMO of Mediaelx\'s Real Estate CRM yet?';
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body  .= '<p>Hola ' . $row_rsUsers['nombre_usr'] . ',</p>';
                    $body  .= '<p>Hace unos días te dimos de alta en la DEMO del CRM Mediaelx. ¿Has podido acceder a ver cómo funciona nuestro CRM Premium para inmobiliarias? Si necesitas información adicional o una visita guiada online, contacta con nosotros. </p>';
                    $body  .= '<p>Para acceder a la DEMO del CRM usa los datos que te enviamos en nuestro email de bienvenida, o haz <a href="https://' . $_SERVER['HTTP_HOST'] . '/intramedianet/forgot_password.php?lang_adm=es">click aquí </a>si no loas recuerdas</p>';
                    $body  .= '<hr>';
                    $body  .= '<p>Hi ' . $row_rsUsers['nombre_usr'] . ',</p>';
                    $body  .= '<p>A few days ago, we registered you for the DEMO of the Mediaelx CRM. Have you had a chance to see how our Premium CRM for real estate works? If you need additional information or an online guided tour, please contact us.</p>';
                    $body  .= '<p>To access the CRM DEMO, use the credentials we sent you in our welcome email, or <a href="https://' . $_SERVER['HTTP_HOST'] . '/intramedianet/forgot_password.php?lang_adm=en">click here</a> if you don\'t remember them.</p>';
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    $body  = '';

    $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
    $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
    $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.';

    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{CONTENT}/', $body , $html);
    $html = preg_replace('/{FOOTER}/', $footer, $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

    $subject = '¿Has probado ya la DEMO del CRM  de Mediaelx para inmobiliarias?/Have you tried the DEMO of Mediaelx\'s Real Estate CRM yet?';


    sendAppEmail(array($row_rsUsers['email_usr'] => $row_rsUsers['nombre_usr']), '', '', '', $subject, $html);

} while ($row_rsUsers = mysqli_fetch_assoc($rsUsers));



