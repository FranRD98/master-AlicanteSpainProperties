<?php
ini_set('display_errors', 0); // En producción debe estar en 0
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

$lang = sanitizeInput($_GET['lang']);
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_' . $lang . '.php');

$id = sanitizeInput($_GET['id']);
$name = sanitizeInput($_GET['name']);
$femail = sanitizeAndValidateEmail($_GET['femail']);
$fname = sanitizeInput($_GET['fname']);
$email = sanitizeAndValidateEmail($_GET['email']);
$acomment = sanitizeInput($_GET['acomment']);

savelogprop($id, '4');

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
                $body .= htmlspecialchars($name) . ' ' . htmlspecialchars($langStr['te recomienda la siguiente propiedad en']) . ' ' . htmlspecialchars($_SERVER['HTTP_HOST']);
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body  .= '<p>' . htmlspecialchars($langStr['Hola']) . ' <strong>' . htmlspecialchars($name) . '</strong> ' . htmlspecialchars($langStr["soy"]) . ' <strong>' . htmlspecialchars($fname) . '</strong>!</p>';
                $body .= '<p>' . htmlspecialchars($langStr["He encontrado una propiedad en"]) . ' <a style="color: #2662a0"; target="_blank" href="http://' . htmlspecialchars($_SERVER['HTTP_HOST']) . '/' . htmlspecialchars($lang) . '/">' . htmlspecialchars($_SERVER['HTTP_HOST']) . '</a> ' . htmlspecialchars($langStr['y pienso que te pued einteresar']) . ':</p>';
                $body .= '<p>' . nl2br(htmlspecialchars($acomment)) . '</p>';
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

$langVal = $lang;
$idVal = $id;

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
$body .= ob_get_contents();
ob_end_clean();

$footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
$footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
$footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';

// Validar CAPTCHA
$recaptcha = sanitizeInput($_GET['g-recaptcha-response']);
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => $google_captcha_privatekey,
    'response' => $recaptcha
);
$options = array(
    'http' => array (
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

if ($captcha_success->success) {
    $html = str_replace('{SERVER.HTTP_HOST}', htmlspecialchars($_SERVER['HTTP_HOST']), $html);
    $html = str_replace('{CONTENT}', $body, $html);
    $html = str_replace('{FOOTER}', $footer, $html);
    $html = str_replace('{COLOR}', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

    $subject = htmlspecialchars($name) . ' ' . htmlspecialchars($langStr['te recomienda la siguiente propiedad en']) . ' ' . htmlspecialchars($_SERVER['HTTP_HOST']);

    if (sendAppEmail([$femail => $fname], '', [$fromMail => $fromMail], [$email => $name], $subject, $html)) {

        echo "ok";

    } else {
        echo $langStr["Error al enviar el mensaje"];
    }
} else {
    echo $langStr["Error al enviar el mensaje"];
}

// Obtener la IP del usuario
function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

$query_rsInsert2 = "INSERT INTO `properties_mail_rep` (`id_mrep`, `property_mrep`, `ip_mrep`, `date_mrep`) VALUES (NULL, ?, ?, ?)";
$stmt = $inmoconn->prepare($query_rsInsert2);
$date = date("Y-m-d H:i:s");
$ip = getIp();
$stmt->bind_param("iss", $id, $ip, $date);
$stmt->execute();
?>
