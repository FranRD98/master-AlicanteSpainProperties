<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$row_rsInt['lang_baj'].'.php');

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
                $body .= $langStr["Aviso de bajada de precio"] . ' - ' . $_SERVER['HTTP_HOST'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body  .= '<p>'.$langStr["Hola"].' <strong>'.@$row_rsInt['name_baj'].'</strong> </p>';
                $body .= '<p>'.$langStr["El"].' '.@$row_rsInt['date_baj'].' '.$langStr["solicitó que le enviaramos un aviso si bajaba el precio de esta propiedad"].':</p>';
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

$langVal = $row_rsInt['lang_baj'];
$idVal = $row_rsInt['prop_baj'];

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
$body .= ob_get_contents();
ob_end_clean();

$footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
$footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
$footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';
$footer .= '<b>'.$langStr["Si no desea recibir más avisos sobre este inmueble"].' <a href="http://'.$_SERVER['HTTP_HOST'] .'/drop/'.$row_rsInt['lang_baj'].'/'.$row_rsInt['ran_baj'].'" style="color: #000">'.$langStr["pulse aquí"].'</a></b>';

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$html = preg_replace('/{CONTENT}/', $body , $html);
$html = preg_replace('/{FOOTER}/', $footer, $html);
$html = preg_replace('/{COLOR}/', $mailColor, $html);

$subject = $langStr["Aviso de bajada de precio"] . ' - ' . $_SERVER['HTTP_HOST'];

sendAppEmail($row_rsInt['email_baj'], '', '', '', $subject, $html);

$query_rsInsert = "
    INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
    ( NULL, '".$_SESSION['kt_login_id']."',  '".$row_rsInt['prop_baj']."',  '".$row_rsInt['email_baj']."', '3', '',  '".date("Y-m-d H:i:s")."' )
";
mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());



 ?>
