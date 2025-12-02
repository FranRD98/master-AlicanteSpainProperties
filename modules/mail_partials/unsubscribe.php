<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$langVal.".php");

// Cargamos las urls
include_once($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

$smarty->assign("metaTitle", 'Unsubscribe');

function decryptIt($encryption, $key = "DLusjkq6kkzRUbY7TVc7YH2RcT2") {
    global $_SERVER;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $decryption_key = $_SERVER['HTTP_HOST'];
    $decryption_iv = $_SERVER['HTTP_HOST'];

    $decryption=openssl_decrypt ($encryption, $ciphering,
        $decryption_key, $options, $decryption_iv);

    return $decryption;
}

$aviso = 0;
$cli = decryptIt($_GET['id'], $nombreEmpresa);

    if($cli != '')
    {
        $query_baja = "UPDATE  `properties_client` SET  send_props_cli = 0, no_molestar_cli = 1 WHERE id_cli = '".$cli."';";
        mysqli_query($inmoconn, $query_baja);


        $query_rsCli = "SELECT * FROM properties_client WHERE id_cli = '".$cli."' ";
      	$rsCli = mysqli_query($inmoconn, $query_rsCli) or die(mysqli_error());
      	$row_rsCli = mysqli_fetch_assoc($rsCli);

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
                        $body .= 'Unsubscribe form ' . $_SERVER['HTTP_HOST'];
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                        $body .= "<p>Date: " . date("d-m-Y H:i") . "</p>";
                        $body .= "<p>This buyer doesn't want to receive any more emails:</p>";
                        $body .= "<p>Name: " . $row_rsCli['nombre_cli'] . ' '. $row_rsCli['apellidos_cli'] ."</p>";
                        $body .= "<p>Email: " . $row_rsCli['email_cli'] . "</p>";
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


	    $subject =  'Unsubscribe form ' . $_SERVER['HTTP_HOST'];

		if (sendAppEmail($fromMail, '', '', array($row_rsCli['email_cli'] => $row_rsCli['nombre_cli']), $subject, $html))
		{
			$aviso = 1;
		}
    }

 ?>



