<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

// Validar y sanitizar el parámetro 'lang'
$lang = filter_input(INPUT_GET, 'lang', FILTER_SANITIZE_STRING);
if (!$lang || !preg_match('/^[a-zA-Z0-9_-]+$/', $lang)) {
    die('Invalid language parameter.');
}

// Validar si el archivo de idioma existe antes de incluirlo
$langFile = $_SERVER["DOCUMENT_ROOT"] . '/resources/lang_' . $lang . '.php';
if (!file_exists($langFile)) {
    die('Language file not found.');
}
require_once($langFile);


$antiSpam = "f" . date("dmy");

if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {

    $name = sanitizeInput($_GET['name']);
    $email = sanitizeInput($_GET['email']);
    $motivo = isset($_GET['motivo']) ? sanitizeInput($_GET['motivo']) : 'Solicitud de cita';
    $telefono = sanitizeInput($_GET['telefono']);
    $when = sanitizeInput($_GET['when']);
    $what = sanitizeInput($_GET['what']);
    $budget = sanitizeInput($_GET['budget']);
    $tipo = sanitizeInput($_GET['tipo']);
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
		$mensaHTML .= "<p>" . $langStr["Fecha"] . ": " . date("d-m-Y H:i") . "</p>";
		$mensaHTML .= "<p>" . $langStr["Nombre"] . ": " . $name . "</p>";
		$mensaHTML .= "<p>Email: " . $email . "</p>";
		$mensaHTML .= "<p>" . $langStr["Teléfono"] . ": " . $telefono . "</p>";
		$mensaHTML .= "<p>" . $langStr["When do you plan to buy?"] . ": " . $when . "</p>";
		$mensaHTML .= "<p>" . $langStr["What is the house for?"] . ": " . $what . "</p>";
		$mensaHTML .= "<p>" . $langStr["Approximade Budget"] . ": " . $budget . "</p>";
		$mensaHTML .= "<p>" . $langStr["Type of house"] . ": " . $tipo . "</p>";
		$mensaHTML .= "<p>" . $langStr["Where"] . ": " . $email . "</p>";

		$subject = 'Book an appointment. ' . $_SERVER['HTTP_HOST'];

		$body  = '';
		$body .= '<!-- Título -->';
		$body .= '<tr>';
		    $body .= '<td align="center-" style="padding: 30px 30px 30px 30px;">';
		        $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
		            $body .= '<h1 style="color: #222; font-size: 24px;">';
		                $body .= 'Book an appointment. ' . $_SERVER['HTTP_HOST'];
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
		
			// Consulta preparada para insertar en la base de datos
			$stmt = $inmoconn->prepare("
				INSERT INTO newsletter_users (nombre_usr, email_usr, lang_usr, date_usr) 
				VALUES (?, ?, ?, ?)
			");
			$currentDateTime = date("Y-m-d H:i:s");
			$stmt->bind_param('ssss', $name, $email, $lang, $currentDateTime);

			if ($stmt->execute()) {
				$userId = $stmt->insert_id;
				$stmt->close();

				$stmt = $inmoconn->prepare("
					INSERT INTO newsletter_usr_cat (usr, cat) 
					VALUES (?, ?)
				");
				$stmt->bind_param('ii', $userId, $idCatNewsletter);
				$stmt->execute();
				$stmt->close();
			} else {
				echo "Error al insertar en la base de datos.";
			}
			
			echo "ok";

		} else {
			echo $langStr["Error al enviar el mensaje"];
		}
	} else {
		echo $langStr["Error al enviar el mensaje"];
	}	
} else {
	echo $langStr["Error al enviar el mensaje"];
}
?>
