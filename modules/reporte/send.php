<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

function encryptIt($idCli, $encryptionKey = 'DLusjkq6kkzRUbY7TVc7YH2RcT2')
{
    global $_SERVER;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_key = $_SERVER['HTTP_HOST'];
    $encryption_iv = $_SERVER['HTTP_HOST'];

    $encryption = openssl_encrypt($idCli, $ciphering,
            $encryption_key, $options, $encryption_iv);
    return $encryption;
}

// Cargamos las urls
include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

foreach ($urlStr as $key => $urls) {
    foreach ($urls as $langval => $urlval) {
        if ($langval == $_GET['lang']) {
            $urlStr[$key]['url'] = $urlval;
            $urlStr[$urlStr[$key][$langval]]['master'] = $key;
        }
    }
}

$antiSpam = "f" . date("dmy");


if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {

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
	                $body .= 'Solicitud de cambio del inmueble ' . $_GET['ref'];
	            $body .= '</h1>';
	            $body .= '<div style="color: #555; font-size: 16px;">';
	                $body .= "<p>Fecha: " . date("d-m-Y H:i") . "</p>";
	                $body .= "<p>Propiedad: <a href=\"http://".$_SERVER['HTTP_HOST']."/".$urlStr['property'][$_GET['lang']]."/" . $_GET['id'] . "/-/-/-/-/-/\">".$_GET['ref']."</a></p>";
	                $body .= "<p>Propietario: <a href=\"http://".$_SERVER['HTTP_HOST']."/intramedianet/properties/owners-form.php?id_pro=" . $_GET['user'] . "\">".$_GET['name']."</a></p>";
	                $body .= "<p>Mensaje:\n" . "</p>";
	                $body .= "<p>" . nl2br($_GET['acomment']) . "</p>";
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

	$subject  = 'Solicitud de cambio del inmueble ' . $_GET['ref'];

	if (sendAppEmail($fromMail, '', '', '', $subject, $html)) {

		echo "ok";

	} else {

	    echo "no";

	}

}

 ?>