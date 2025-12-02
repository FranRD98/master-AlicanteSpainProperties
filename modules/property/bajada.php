<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

// Validar y sanitizar la entrada 'lang' para prevenir ataques de inclusión de archivos
$lang = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['lang']);
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_' . $lang . '.php');

$antiSpam = "f" . date("dmy");
$body = '';

if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {

    $id = sanitizeInput($_GET['id']);
    $lang = sanitizeInput($lang);
    $namebj = sanitizeInput($_GET['namebj']);
    $emailbj = sanitizeAndValidateEmail($_GET['emailbj']);
    $phonebj = sanitizeInput($_GET['phonebj']);
    $code = md5(time());
    // Usar consultas preparadas para prevenir inyección SQL
    $query_rsInsert = "
        INSERT INTO properties_bajada (prop_baj, lang_baj, name_baj, email_baj, phone_baj, date_baj, ran_baj)
        VALUES (?, ?, ?, ?, ?, NOW(), ?)
    ";
    $stmt = $inmoconn->prepare($query_rsInsert);
    $stmt->bind_param(
        'ssssss',
        $id,
        $lang,
        $namebj,
        $emailbj,
        $phonebj,
        $code
    );

    // Ejecutar la consulta y verificar errores
    if ($stmt->execute()) {
        $stmt->close();

        // Obtener la referencia de la propiedad
        $query_rsRef = "SELECT referencia_prop FROM properties_properties WHERE id_prop = ?";
        $stmt = $inmoconn->prepare($query_rsRef);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row_rsRef = $result->fetch_assoc();
        $stmt->close();

        if ($result->num_rows > 0) {
            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
            $html = ob_get_contents();
            ob_end_clean();

            $body .= '<!-- Título -->';
            $body .= '<tr>';
                $body .= '<td align="center-" style="padding: 20px 30px 0 30px;">';
                    $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                        $body .= '<h1 style="color: #222; font-size: 24px;">';
                            $body .= 'Nueva solicitud bajada de precios del inmueble: #' . htmlspecialchars($row_rsRef['referencia_prop']);
                        $body .= '</h1>';
                        $body .= '<div style="color: #555; font-size: 16px;">';
                            $body .= '<p>Enviado: ' . date("d-m-Y H:i") . '</p>';
                            $body .= '<p>Nombre: ' . htmlspecialchars($_GET['namebj']) . '</p>';
                            $body .= '<p>Teléfono: ' . htmlspecialchars($_GET['phonebj']) . '</p>';
                            $body .= '<p>Email: ' . htmlspecialchars($_GET['emailbj']) . '</p>';
                        $body .= '</div>';
                    $body .= '</div>';
                $body .= '</td>';
            $body .= '</tr>';

            $langVal = htmlspecialchars($lang);
            $idVal = htmlspecialchars($_GET['id']);

            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
            $prop_enqu = ob_get_contents();
            ob_end_clean();

            $body .= $prop_enqu;

            $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
            $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
            $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.';

            $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
            $html = preg_replace('/{CONTENT}/', $body, $html);
            $html = preg_replace('/{FOOTER}/', $footer, $html);
            $html = preg_replace('/{COLOR}/', $mailColor, $html);

            $subject = 'Nueva solicitud bajada de precios del inmueble: #' . htmlspecialchars($row_rsRef['referencia_prop']);

            sendAppEmail($fromMail, '', '', array($_GET['emailbj'] => $_GET['namebj']), $subject, $html);

            // Si la opción de propiedades similares está activada
            if ($opcionSimilares == 1) {
                include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/similar-properties.php');
                if ($similaresContent != "") {

                    $body2 = "";
                    $body2 .= '<!-- Título -->';
                    $body2 .= '<tr>';
                        $body2 .= '<td align="center-" style="padding: 20px 30px 0 30px;">';
                            $body2 .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                                $body2 .= '<h1 style="color: #222; font-size: 24px;">';
                                    $body2 .= $subject = $langStr["Propiedad"] . " Ref: " . htmlspecialchars($row_rsRef['referencia_prop']) . " - " . $_SERVER['HTTP_HOST'];
                                $body2 .= '</h1>';
                                $body2 .= '<div style="color: #555; font-size: 16px;">';
                                    $body2 .= "<p>" . $langStr["Gracias por contactarnos"] . ".</p>";
                                    $body2 .= "<p>" . $langStr["We have received a request for a report if you lower the price of the property with the reference"] . ": " . htmlspecialchars($row_rsRef['referencia_prop']) . ".</p>";
                                    $body2 .= $prop_enqu;
                                    // $body2 .= "<p>" . $langStr["Mientras tanto, por favor eche un vistazo a esta selección de propiedades similares, esto puede ser de su interés"] . ".</p>";
                                    // $body2 .= "<h4 style=\"font-weight: 200; padding: 10px; background: " . $mailColor . "; text-align: center; text-transform: uppercase;color: #fff\">" . $langStr["Propiedades similares"] . "</h4>";
                                    $body2 .= $similaresContent;
                                $body2 .= '</div>';
                            $body2 .= '</div>';
                        $body2 .= '</td>';
                    $body2 .= '</tr>';

                    ob_start();
                    include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
                    $html2 = ob_get_contents();
                    ob_end_clean();

                    $footer2 = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
                    $footer2 .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
                    $footer2 .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>';


                    $html2 = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html2);
                    $html2 = preg_replace('/{CONTENT}/', $body2, $html2);
                    $html2 = preg_replace('/{FOOTER}/', $footer2, $html2);
                    $html2 = preg_replace('/{COLOR}/', $mailColor, $html2);
                    $html2 = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html2);

                    if(isset($langStr["Propiedad"]))
                        $subject = $langStr["Propiedad"] . " Ref: " . htmlspecialchars($row_rsRef['referencia_prop']) . " - " . $_SERVER['HTTP_HOST'];
                    else
                        $subject = " Ref: " . htmlspecialchars($row_rsRef['referencia_prop']) . " - " . $_SERVER['HTTP_HOST'];

                    sendAppEmail(array($emailbj => $namebj), '', '', array($fromMail => $fromName), $subject, $html2);
                }
            }

            echo "ok";
        } else {
            echo "no";
        }
    } else {
        echo "no";
    }
}

?>
