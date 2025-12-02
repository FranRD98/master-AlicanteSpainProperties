<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

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
                $body .= $langStr['Propiedades encontradas en'] . ' ' . $_SERVER['HTTP_HOST'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body .= $_GET['acomment'];
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

$isLevel1 = false;

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("1");
if ($isLoggedIn1->Execute()) {
    $isLevel1 = true;
}

if ($isLevel1 == true) {
	$propertiesFav = getRecords("

        SELECT * FROM users_favorites WHERE user= '".stripslashes(mysqli_real_escape_string($inmoconn, $_SESSION['kt_login_id']))."' GROUP BY user, property ORDER BY id

    ");

    $theFavs = array();

    foreach ($propertiesFav as $key => $value) {
        array_push($theFavs, $value['property']);
    }
} else {
    $theFavs = explode(",",$_COOKIE['fav']);
}

foreach ($theFavs as $value) {
	$langVal = $_GET['lang'];
    $idVal = $value;
    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
    $body .= ob_get_contents();
    ob_end_clean();
}

if ($google_captcha_privatekey != '') {
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$google_captcha_privatekey.'&response='.$_GET['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($verifyResponse);
    if (isset($data->success) AND $data->success==true) {
        $valid = true;
    } else {
        $valid = false;
    }
} else {
    if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {
        $valid = true;
    } else {
        $valid = false;
    }
}

if ($valid == true || $google_captcha_privatekey == '') {

    $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
    $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
    $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';

    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{CONTENT}/', $body , $html);
    $html = preg_replace('/{FOOTER}/', $footer, $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
    $antiSpam = "f" . date("dmy");

    if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {

        $name = sanitizeInput($_GET['name']);
        $lang = sanitizeInput($_GET['lang']);
        $email = sanitizeAndValidateEmail($_GET['email'], FILTER_SANITIZE_EMAIL);

        $subject = $langStr['Propiedades encontradas en'] . ' ' . $_SERVER['HTTP_HOST'];

        if (sendAppEmail(array($_GET['email'] => $_GET['name']), '', array($fromMail => $fromMail), '', $subject, $html)) {
    		
    		$stmt = $inmoconn->prepare("INSERT INTO newsletter_users (nombre_usr, email_usr, lang_usr, date_usr) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $name, $email, $lang, date("Y-m-d H:i:s"));
            $stmt->execute();

            $newUserId = $stmt->insert_id;
            $stmt->close();

            $stmt = $inmoconn->prepare("INSERT INTO newsletter_usr_cat (usr, cat) VALUES (?, ?)");
            $stmt->bind_param('ii', $newUserId, $idCatNewsletter);
            $stmt->execute();
            $stmt->close();

            echo "ok";
    	} else {
    	    echo "Error al enviar el formulario.";
    	}

    }
} else {
    echo "Error al enviar el formulario.";
}

die();
