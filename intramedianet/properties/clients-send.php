<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

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

session_start();

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
                $body .= $langStr['Propiedades recomendadas'] .' - ' . $_SERVER['HTTP_HOST'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body .= $langStr["Te envío propiedades que pueden interesarte"] . ':';
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

$body  = '';
// $body .= '<p>I send you properties that cant interest you:</p>';

$ids = explode(',', $_GET['ids']);

// $body  .= "<h4 style=\"font-weight: 200; padding: 30px 10px 20px 0; color: ".$mailColor."; font-size: 22px;\">" . $langStr['Propiedades'] . "</h4>";


function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

for ($i=0; $i < count($ids); $i++) {

	   $langVal = $_GET['lang'];
        $idVal = $ids[$i];

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
        $body .= ob_get_contents();
        ob_end_clean();

    $tipo = 2;

    if ($_GET['tipo'] != '') {
        $tipo = $_GET['tipo'];
    }

    if ($_GET['comment'] == '') {
        $_GET['comment'] = $body;
    }


$query_rsInsert3 = "
    INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
    ( NULL, '".$_SESSION['kt_login_id']."',  '".$ids[$i]."',  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  '".$tipo."', '".mysqli_real_escape_string($inmoconn,$_GET['comment'])."', '".date("Y-m-d H:i:s")."' )
";
mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());




$query_rsInsert2 = "

    INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
    ( NULL ,  '".$ids[$i]."',  '".getIp()."',  '".date("Y-m-d H:i:s")."', '".$_SESSION['kt_login_id']."', '".$_GET['usr']."' )

";
mysqli_query($inmoconn,$query_rsInsert2);


}

$signature = '';
if ($_SESSION['kt_login_id']) {
    
    $query_rsAdmin = "SELECT * FROM users WHERE id_usr = '".$_SESSION['kt_login_id']."'";
    $rsAdmin = mysqli_query($inmoconn,$query_rsAdmin) or die(mysqli_error());
    $row_rsAdmin = mysqli_fetch_assoc($rsAdmin);
    $totalRows_rsAdmin = mysqli_num_rows($rsAdmin);

    if ($row_rsAdmin['firma_' . $_GET['lang'] . '_usr'] != '') {

        $body .= '<!-- Firma visual de equipo -->';
        $body .= '<tr>';
        $body .= '<td style="padding: 30px; background-color: #fff; color: #000; font-size: 14px; line-height: 1.6em; border-top: 1px solid #ebebeb">';
        $body .= nl2br($row_rsAdmin['firma_' . $_GET['lang'] . '_usr']);
        $body .= '</td>';
        $body .= '</tr>';
    }
}

$footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
$footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
$footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';
$footer .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['lang'] . '/unsubscribe/?id=' . encryptIt($row_rsCli['id_cli'],$nombreEmpresa) . '" style="color: #000; text-decoration: none; font-weight: bold;">' .$langStr["Darme de baja"] . '</a>';

$query_rsCli = "SELECT * FROM properties_client WHERE email_cli = '".$_GET['email']."' ";
$rsCli = mysqli_query($inmoconn, $query_rsCli) or die(mysqli_error());
$row_rsCli = mysqli_fetch_assoc($rsCli);

mysqli_select_db($inmoconn, $database_inmoconn);
$query_rsClienMail = "SELECT * FROM properties_client WHERE email_cli = '".$_GET['email']."'";
$rsClienMail = mysqli_query($inmoconn, $query_rsClienMail) or die(mysqli_error());
$row_rsClienMail = mysqli_fetch_assoc($rsClienMail);
$totalRows_rsClienMail = mysqli_num_rows($rsClienMail);

if ($totalRows_rsClienMail > 0) {
    $body = str_replace('{{CLIENT}}', $row_rsClienMail['nombre_cli'], $body);
}

$body = $body . $signature;

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$html = preg_replace('/{CONTENT}/', $body , $html);
$html = preg_replace('/{FOOTER}/', $footer, $html);
$html = preg_replace('/{COLOR}/', $mailColor, $html);
$html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

$subject = $langStr['Propiedades recomendadas'] .' - ' . $_SERVER['HTTP_HOST'];

$html = preg_replace('/{URLBAJA}/', 'https://'.$_SERVER['HTTP_HOST'].'/'.$_GET['lang'].'/unsubscribe/?id='.encryptIt($row_rsCli['id_cli'],$nombreEmpresa), $html);

if (sendAppEmail(array($_GET['email'] => $_GET['nombre']), '', '', array($_SESSION['kt_login_user'] => $_SESSION['kt_login_user']), $subject, $html)) {
	echo "ok";
	mysqli_query($inmoconn,$query_rsInsert2);
} else {
    echo "no";
}





 ?>
