<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$_GET['lang'].'.php');
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
                        $body .= $langStr["Las propiedades de tu búsqueda"];
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                        $body .= '<p>'.$langStr["searchtxt2"].':</p>';
                        $body .= '<p>'.$_GET['url'].'</p>';
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

        $subject = $langStr["Las propiedades de tu búsqueda"];

		sendAppEmail(array($_GET['email'] => $_GET['name']), '', '', '', $subject, $html);

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
        $html = ob_get_contents();
        ob_end_clean();

        $body  = '';
        $body .= '<tr>';
            $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
                $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                    $body .= '<h1 style="color: #222; font-size: 24px;">';
                        $body .= $langStr["searchtxt1"];
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                        $body .= '<p>Enviado: '.date("d-m-Y H:i").'</p>';
                        $body .= '<p>URL: '.$_GET['url'].'</p>';
                        $body .= '<p>Nombre: '.$_GET['name'].'</p>';
                        $body .= '<p>Email: '.$_GET['email'].'</p>';
                    $body .= '</div>';
                $body .= '</div>';
            $body .= '</td>';
        $body .= '</tr>';

        $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
        $html = preg_replace('/{CONTENT}/', $body , $html);
        $html = preg_replace('/{FOOTER}/', $footer, $html);
        $html = preg_replace('/{COLOR}/', $mailColor, $html);
        $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

        $subject = $langStr["searchtxt1"];

        if(sendAppEmail($fromMail, '', '', array($_GET['email'] => $_GET['name']), $subject, $html))
        {
		    echo "ok";
        }else{
            echo "Error al enviar el email";
        }

}

 ?>
