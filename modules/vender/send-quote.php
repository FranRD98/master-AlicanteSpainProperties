<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

$_GET['lang'] = sanitizeInput($_GET['lang']);

$_GET['name'] = sanitizeInput($_GET['name']);
$_GET['email'] = sanitizeAndValidateEmail($_GET['email']);
$_GET['telefono'] = sanitizeInput($_GET['telefono']);
$_GET['tipo'] = sanitizeInput($_GET['tipo']);
$_GET['localizacion'] = sanitizeInput($_GET['localizacion']);
$_GET['caracteristicas'] = sanitizeInput($_GET['caracteristicas']);
$_GET['bd'] = sanitizeInput($_GET['bd']);
$_GET['bt'] = sanitizeInput($_GET['bt']);
$_GET['price'] = sanitizeInput($_GET['price']);
$_GET['comment'] = sanitizeInput($_GET['comment']);



require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$_GET['lang'].'.php');

$antiSpam = "f" . date("dmy");

// echo "<pre>";
// var_dump($_GET);
// echo "</pre>";

$recaptcha = $_GET["g-recaptcha-response"];
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => $google_captcha_privatekey,
    'response' => $recaptcha
);

// Codifica los datos como una cadena de consulta URL
$data = http_build_query($data);

// Configura las opciones del contexto HTTP
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => $data,
    ),
);

// Crea un contexto de transmisión
$context  = stream_context_create($options);

// Realiza la solicitud con el contexto
$verify = file_get_contents($url, false, $context);

if ($verify === FALSE) {
    // Maneja el error en caso de fallo en la solicitud
    echo "Error en la solicitud a reCAPTCHA";
} else {
    // Decodifica la respuesta JSON
    $captcha_success = json_decode($verify);
    if ($captcha_success->success) {

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
                        $body .= 'New property list request: ' . $_SERVER['HTTP_HOST'];
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                        $body .= "<p><strong>Date</strong>: " . date("d-m-Y H:i") . "</p>";
                        $body .= "<p><strong>Name</strong>: " . $_GET['name'] . "</p>";
                        $body .= "<p><strong>Email</strong>: " . $_GET['email'] . "</p>";
                        $body .= "<p><strong>Phone</strong>: " . $_GET['telefono'] . "</p>";
                        $body .= "<p><strong>Type</strong>: " . $_GET['tipo'] . "</p>";
                        $body .= "<p><strong>Location</strong>: " . $_GET['localizacion'] . "</p>";
                        $body .= "<p><strong>Features</strong>: " . $_GET['caracteristicas'] . "</p>";
                        $body .= "<p><strong>Bedrooms</strong>: " . $_GET['bd'] . "</p>";
                        $body .= "<p><strong>Bathrooms</strong>: " . $_GET['bt'] . "</p>";
                        $body .= "<p><strong>Price</strong>: " . $_GET['price'] . "</p>";
                        $body .= "<p>" . nl2br($_GET['comment']) . "</p>";
                    $body .= '</div>';
                $body .= '</div>';
            $body .= '</td>';
        $body .= '</tr>';

        $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
        $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
        $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.';

        $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
        $html = preg_replace('/{CONTENT}/', $body , $html);
        $html = preg_replace('/{FOOTER}/', $footer, $html);
        $html = preg_replace('/{COLOR}/', $mailColor, $html);
        $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

        $subject = 'New property list request: ' . $_SERVER['HTTP_HOST'];

        if (sendAppEmail($fromMail, '', '', array($_GET['email'] => $_GET['name']), $subject, $html)) {

            echo "ok";

        } else {

            echo "Error alenviar el mensaje.";

        }


    }else{
        echo "Error en la validación del captcha";
    }
}

 ?>
