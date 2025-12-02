<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');
global $smtpUrl, $smtpPort, $smtpUser, $smtpPass, $fromMail, $_SESSION, $_SERVER, $fromName;

$antiSpam = "f" . date("dmy");

// Validación y Saneamiento de Entradas
$lang = sanitizeInput($_GET["lang"]);
$name = sanitizeInput($_GET["name"]);
$email = sanitizeAndValidateEmail($_GET["email"]);
$phone = sanitizeInput($_GET["phone"]);
$acomment = sanitizeInput($_GET["acomment"]);
$fecha = sanitizeInput($_GET["fecha"]);
$forma_visita = sanitizeInput($_GET["forma_visita"]);
$link = sanitizeInput($_GET["link"]);
$recaptcha = $_GET["g-recaptcha-response"];

if (!$email) {
    echo 'Error: Correo electrónico no válido'; die();
}

// Verificar reCAPTCHA
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

    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
    $html = ob_get_contents();
    ob_end_clean();

    // Consulta preparada para evitar inyección SQL
    $query_rsInsert = "INSERT INTO `properties_consultas_log` (`lang_con`, `name_con`, `email_con`, `phone_con`, `text_con`, `date_con`) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $inmoconn->prepare($query_rsInsert);
    $stmt->bind_param("sssss", $lang, $name, $email, $phone, $acomment);
    $stmt->execute();

    // Creación del mensaje de correo electrónico
    $mensaHTML .= "<p>Fecha: " . date("d-m-Y H:i") . "</p>";
    $mensaHTML .= "<p>Nombre: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "</p>";
    $mensaHTML .= "<p>Email: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</p>";
    $mensaHTML .= "<p>Teléfono: " . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . "</p>";
    $mensaHTML .= "<p>Dia y hora preferida: " . htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8') . "</p>";
    $mensaHTML .= "<p>Forma de hacer la visita: " . htmlspecialchars($forma_visita, ENT_QUOTES, 'UTF-8') . "</p>";
    $mensaHTML .= "<p>Mensaje:</p>";
    $mensaHTML .= "<p>" . nl2br(htmlspecialchars($acomment, ENT_QUOTES, 'UTF-8')) . "</p><br>";
    $mensaHTML .= "<p>Link: " . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . "</p>";

    $subject = 'Nueva consulta desde ' . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8');

    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 30px 30px 30px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= 'Nuevo viaje de inspección';
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= $mensaHTML;
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
    $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
    $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';

    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{CONTENT}/', $body , $html);
    $html = preg_replace('/{FOOTER}/', $footer, $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

    if (sendAppEmail(array($fromMail => $fromMail), '', '', array($fromMail => $fromMail), $subject, $html)){
        echo "ok";
    }else{
        echo $langStr["Error al enviar el mensaje"];
    }
    }else{
        echo $langStr["Error al enviar el mensaje"];
    }
    die;

 ?>
