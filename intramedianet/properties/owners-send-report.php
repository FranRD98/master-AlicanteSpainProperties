<?php



require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

session_start();

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

$query_rsOwner = "SELECT

properties_owner.id_pro,
properties_owner.nombre_pro,
properties_owner.email_pro,
properties_owner.reporte_prop,
properties_owner.idioma_pro,
properties_properties.id_prop

FROM properties_properties

INNER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro

WHERE properties_owner.email_pro != '' AND properties_properties.activado_prop = 1 AND properties_owner.reporte_prop = 1 AND vendido_prop = 0 AND force_hide_prop != 1

GROUP BY properties_properties.id_prop";
$rsOwner = mysqli_query($inmoconn, $query_rsOwner) or die(mysqli_error());
$row_rsOwner = mysqli_fetch_assoc($rsOwner);
$totalRows_rsOwner = mysqli_num_rows($rsOwner);


do {
    $_GET['lang'] = $row_rsOwner['idioma_pro'];

    include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

    if ($_GET['lang'] == '') {
        $_GET['lang'] = 'en';
    }


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
                    $body .= $langStr["Reporte Propiedad"] . ' - ' . $_SERVER['HTTP_HOST'];
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body  .= '<p>' . $langStr["Estimado Cliente, deseando ofrecerle un mejor servicio nos ponemos en contacto con usted para enviarle un breve informe sobre su vivienda"] . ':</p>';
                    if ($row_rsOwner['idioma_pro'] == $language) {
                        $body .= '<p style="margin-bottom: 0px"><a href="https://'.$_SERVER['HTTP_HOST'].'/reporte/" style="background-color: {COLOR}; color: #fff; padding: 15px 20px; text-decoration: none; display: inline-block; border-radius: 23px; display: block; max-width: 100%; text-align: center; font-size: 16px;">'.$langStr["Ver reporte"].'</a></p> <br>';
                    } else {
                        $body .= '<p style="margin-bottom: 0px"><a href="https://'.$_SERVER['HTTP_HOST'].'/'.$row_rsOwner['idioma_pro'].'/reporte/'.encryptIt($row_rsOwner['id_prop']).'/" style="background-color: {COLOR}; color: #fff; padding: 15px 20px; text-decoration: none; border-radius: 23px; display: inline-block;  display: block; max-width: 100%; text-align: center; font-size: 16px;">'.$langStr["Ver reporte"].'</a></p> <br>';
                    }
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    $langVal = $_GET['lang'];
    $idVal = $row_rsOwner['id_prop'];

    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
    $body .= ob_get_contents();
    ob_end_clean();


    $subject = $langStr["Reporte Propiedad"] . ' - ' . $_SERVER['HTTP_HOST'];

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
    $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.';

    $body = $body . $signature;

    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{CONTENT}/', $body, $html);
    $html = preg_replace('/{FOOTER}/', $footer, $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

    $html = str_replace($_SERVER['HTTP_HOST'].'/'.$_SERVER['HTTP_HOST'].'/', $_SERVER['HTTP_HOST'].'/', $html);

    if (sendAppEmail([$row_rsOwner['email_pro'] => $row_rsOwner['nombre_pro']], '', '', '', $subject, $html)) {
        echo "ok";
    } else {
        echo "no";
    }
} while ($row_rsOwner = mysqli_fetch_assoc($rsOwner));
