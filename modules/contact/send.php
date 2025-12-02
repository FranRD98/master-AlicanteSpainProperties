<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');


$antiSpam = "f" . date("dmy");

if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {

    $name = sanitizeInput($_GET['name']);
    $email = sanitizeInput($_GET['email']);
    $motivo = sanitizeInput($_GET['motivo']);
    $comment = sanitizeInput($_GET['comment']);
    $lang = sanitizeInput($_GET['lang']);
	$recaptcha = $_GET["g-recaptcha-response"];


    if (!sanitizeAndValidateEmail($email)) {
        echo "Invalid email format";
        exit;
    }

	// Verificar reCAPTCHA
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => $google_captcha_privatekey,
		'response' => $recaptcha
	);
	$options = array(
		'http' => array (
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
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

		$mensaHTML = "<p>" . $motivo . "</p>";
		$mensaHTML .= "<p>Date: " . date("d-m-Y H:i") . "</p>";
		$mensaHTML .= "<p>Nombre: " . $name . "</p>";
		$mensaHTML .= "<p>Email: " . $email . "</p>";
		$mensaHTML .= "<p>Consulta:\n" . "</p>";
		$mensaHTML .= "<p>" . nl2br($comment) . "</p>";

		$subject = 'Nueva consulta desde ' . $_SERVER['HTTP_HOST'];

	    $body  = '';
	    $body .= '<!-- Título -->';
	    $body .= '<tr>';
	        $body .= '<td align="center-" style="padding: 30px 30px 30px 30px;">';
	            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
	                $body .= '<h1 style="color: #222; font-size: 24px;">';
	                    $body .= 'Nueva consulta desde ' . $_SERVER['HTTP_HOST'];
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

		if (sendAppEmail($fromMail, '', '', array($email => $name), $subject, $html)) {

			echo "ok";

		} else {
			echo $langStr["Error al enviar el mensaje"];
		}
	} else {
		echo $langStr["Error al enviar el mensaje"];
	}
}else{
	echo $langStr["Error al enviar el mensaje"];
}

?>
