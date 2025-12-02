<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

foreach ($urlStr as $key => $urls) {
    foreach ($urls as $langval => $urlval) {
        if ($langval == $lang) {
            $urlStr[$key]['url'] = $urlval;
            $urlStr[$urlStr[$key][$langval]]['master'] = $key;
        }
    }
}

$urlStart = '/';

if(@isset($_GET['lang']) && $_GET['lang'] != '' && $_GET['lang'] != $language) {
    $urlStart = '/' . $_GET['lang'] . '/';
}

session_start();

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
                $body .= $_GET['subject'];
            $body .= '</h1>';
            $body .= '<div style="color: #555; font-size: 16px;">';
                $body .= $_GET['message'];
            $body .= '</div>';
        $body .= '</div>';
    $body .= '</td>';
$body .= '</tr>';

for ($i=0; $i < 1; $i++) {

       $langVal = $_GET['lang'];
        $idVal = $_GET['propslist1'][$i];

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
        $body .= ob_get_contents();
        ob_end_clean();

}

/*
if (!empty($_GET['propslist1'])) {
    foreach ($_GET['propslist1'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}
if (!empty($_GET['props']) && empty($_GET['propslist1'])) {
    // $body .= "<h2>" . $langStr["propiedades"] . "</h2>";
    foreach ($_GET['props'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property-acumba-one.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}
*/

if (!empty($_GET['propsprom1'])) {
    foreach ($_GET['propsprom1'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/prom-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}

if (!empty($_GET['propsnews1'])) {
    foreach ($_GET['propsnews1'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/news-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}

/*
if (!empty($_GET['propsnews2'])) {
    // $body .= '<div style="background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;">';
    $body  .= "<h2 style=\"margin: 40px 0;\">".$langStr["Noticias"]."</h2>";
    foreach ($_GET['propsnews2'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/news-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= '</div>';
}

if (!empty($_GET['propsnews3'])) {
    // $body .= '<div style="background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;">';
    $body  .= "<h2 style=\"margin: 40px 0;\">".$langStr["Noticias"]."</h2>";
    foreach ($_GET['propsnews3'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/news-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= '</div>';
}
*/
/*
if (!empty($_GET['propsprom2'])) {
    // $body .= '<div style="background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;">';
    $body  .= "<h2 style=\"margin: 40px 0;\">".$langStr["Promotions"]."</h2>";
    foreach ($_GET['propsprom2'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/prom-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= '</div>';
}

if (!empty($_GET['propsprom3'])) {
    // $body .= '<div style="background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;">';
    $body  .= "<h2 style=\"margin: 40px 0;\">".$langStr["Promotions"]."</h2>";
    foreach ($_GET['propsprom3'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/prom-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= '</div>';
}
*/


if ($_GET['propslist1'][1] > 0) {

    $body .= '<tr>';

    $body .= '<td style="padding: 0 30px 20px 30px;">';

    $body .= '<h3 style="font-size: 28px; color: #333; text-align: center;">🔎 ' . $langStr["También te pueden interesar"] . ':</h3>';

    $body .= '<table width="100%" cellpadding="0" cellspacing="0">';

    $body .= '<tr>';

    for ($i=1; $i < count($_GET['propslist1']); $i++) {

        $body .= "<td>";

        $langVal = $_GET['lang'];
        $idVal = $_GET['propslist1'][$i];

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate_mini.php');
        $body .= ob_get_contents();
        ob_end_clean();

        $body .= "</td>";

        if ($i%2 == 0) {
            $body .= '</tr>';
            $body .= '<tr>';
        }

    }

    $body .= '</tr>';

    $body .= '</table>';

    $body .= '</td>';

    $body .= '</tr>';

    $body .= '<tr>';
       $body .= '<td style="padding: 20px 30px;">';
           $body .= '<div style="display: block; border-top: 1px solid #dedede;"></div>';
       $body .= '</td>';
    $body .= '</tr>';

}

if (!empty($_GET['propsciu1'])) {
    foreach ($_GET['propsciu1'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/ciu-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
}
/*
if (!empty($_GET['propsciu2'])) {
    // $body .= '<div style="background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;">';
    $body  .= "<h2 style=\"margin: 40px 0;\">".$langStr["Áreas"]."</h2>";
    foreach ($_GET['propsciu2'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/ciu-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= '</div>';
}

if (!empty($_GET['propsciu3'])) {
    // $body .= '<div style="background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;">';
    $body  .= "<h2 style=\"margin: 40px 0;\">".$langStr["Áreas"]."</h2>";
    foreach ($_GET['propsciu3'] as $value) {
        $langVal = $_GET['lang'];
        $idVal = $value;
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/ciu-acumba.php');
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= '</div>';
}
*/
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
$footer .= '<a href="*|UNSUBSCRIBE_URL|*" style="color: #000; text-decoration: none; font-weight: bold;">' .$langStr["Darme de baja"] . '</a> <br> <a href="*|BROWSER_VIEW|*" style="color: #000; text-decoration: none; font-weight: bold;">{VIEW}</a>';

$body = $body . $signature;

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$html = preg_replace('/{CONTENT}/', $body, $html);
$html = preg_replace('/{FOOTER}/', $footer, $html);
$html = preg_replace('/{COLOR}/', $mailColor, $html);
$html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
$html = preg_replace('/{PHONE}/', $langStr["Teléfono"], $html);
$html = preg_replace('/{PHONENUM}/', $Acumbamail_dc_phone, $html);
$html = preg_replace('/{EMAIL}/', $langStr["Email"], $html);
$html = preg_replace('/{EMAILDIR}/', $fromMail, $html);
$html = preg_replace('/{BAJA}/', $langStr["Darme de baja"] , $html);
$html = preg_replace('/{DATOS}/', $langStr["Actualizar mis datos"], $html);
$html = preg_replace('/{VIEW}/', $langStr["Si no puedes ver bien esta newsletter haz click aquí"], $html);
$html = preg_replace('/{CATALOG}/', $langStr["Encuentra tu propiedad en nuestro extenso catálogo"], $html);
$html = preg_replace('/{FIND}/', $langStr["Encuentra tu propiedad"], $html);
$html = preg_replace('/{URL}/', 'https://' . $_SERVER['HTTP_HOST'] . $urlStart . $urlStr['advanced-search']['url'] . '/', $html);

if ($_GET['lista'][0] == '') {
    echo "lista";
    die();
}

if ($_GET['schedule_ct'] != '') {
    $query_rsInsert2 = "INSERT INTO  `acumbamail` SET subject_acum = '" . mysqli_real_escape_string($inmoconn,$_GET['subject']) . "', company_acum = '" . mysqli_real_escape_string($inmoconn,$Acumbamail_dc_company) . "', frommail_acum = '" . mysqli_real_escape_string($inmoconn,$fromMail) . "', html_acum = '" . mysqli_real_escape_string($inmoconn,$html) . "', lista_acum = '" . implode(',', $_GET['lista']) . "', datetime_acum = '" . date("Y-m-d H:i:s", strtotime($_GET['schedule_ct'])) . "' ";
    mysqli_query($inmoconn,$query_rsInsert2);
} else {
    $acumba = new AcumbamailAPI($keyAcumbamail);
    $acumba->createCampaign($_GET['subject'], $Acumbamail_dc_company, $fromMail, $_GET['subject'], $html, $_GET['lista']);
}

echo 'ok';
