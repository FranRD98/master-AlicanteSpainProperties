<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_' . htmlspecialchars($_GET['lang']) . '.php');


// Validar y sanitizar las entradas
$lang = sanitizeInput($_GET['lang']);
$name = sanitizeInput($_GET['name']);
$email = sanitizeAndValidateEmail($_GET['email']);
$telefono = sanitizeInput($_GET['telefono']);
$comment = sanitizeInput($_GET['comment']);
$recaptcha = $_GET["g-recaptcha-response"];

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

    // Insertar en la base de datos
    $stmt = $inmoconn->prepare("INSERT INTO `properties_consultas_log` (`lang_con`, `name_con`, `email_con`, `phone_con`, `text_con`, `date_con`) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $lang, $name, $email, $telefono, $comment);
    $stmt->execute();

    $mensaHTML = "<p>Date: " . date("d-m-Y H:i") . "</p>";
    $mensaHTML .= "<p>Nombre: " . $name . "</p>";
    $mensaHTML .= "<p>Email: " . $email . "</p>";
    $mensaHTML .= "<p>Teléfono: " . $telefono . "</p>";
    $mensaHTML .= "<p>Consulta:</p>";
    $mensaHTML .= "<p>" . nl2br($comment) . "</p>";

    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 30px 30px 30px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $langStr["Nueva consulta desde"];
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
    $html = preg_replace('/{CONTENT}/', $body, $html);
    $html = preg_replace('/{FOOTER}/', $footer, $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

    $subject = $langStr["Nueva consulta desde"] . ' ' . $_SERVER['HTTP_HOST'];

    if (sendAppEmail($fromMail, '', '', array($email => $name), $subject, $html)) {
        echo "ok";

        $stmt = $inmoconn->prepare("INSERT INTO `newsletter_users` (`nombre_usr`, `email_usr`, `lang_usr`, `date_usr`) VALUES (?, ?, ?, ?)");
        $date_now = date("Y-m-d H:i:s");
        $stmt->bind_param("ssss", $name, $email, $lang, $date_now);
        $stmt->execute();
        $newUserId = $stmt->insert_id;

        $stmt = $inmoconn->prepare("INSERT INTO `newsletter_usr_cat` (`usr`, `cat`) VALUES (?, ?)");
        $stmt->bind_param("ii", $newUserId, $idCatNewsletter);
        $stmt->execute();
    } else {
        echo "no";
    }

    $stmt->close();
}

$inmoconn->close();
?>
