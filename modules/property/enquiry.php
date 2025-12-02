<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/propiedades.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_' . htmlspecialchars($_GET['lang']) . '.php');

$antiSpam = "f" . date("dmy");
$body = '';

if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {
    $email = simpleSanitize($_GET['email']);

    $query_rsClientes = "SELECT id_cli, nombre_cli, apellidos_cli, email_cli FROM properties_client WHERE email_cli = ?";

    $stmt = $inmoconn->prepare($query_rsClientes);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row_rsClientes = $result->fetch_assoc();
    $totalRows_rsClientes = $result->num_rows;
    $stmt->close();

    $id = simpleSanitize($_GET['id']);
    $lang = $langVal = simpleSanitize($_GET['lang']);
    $motivo = simpleSanitize($_GET['motivo']);
    $name = simpleSanitize($_GET['name']);
    $phone = simpleSanitize($_GET['phone']);
    $comment = simpleSanitize($_GET['comment']);

    $langVal = $lang;
    $idVal = $id;

    if (isset($row_rsClientes['id_cli']) && $row_rsClientes['id_cli'] != '') {
        $client_id = $row_rsClientes['id_cli'];
        $query_rsInsert = "
            INSERT INTO properties_enquiries (inmueble_cons, idioma_cons, motivo_cons, nombre_cons, telefono_cons, email_cons, comentario_consas, fecha_cons, read_cons, client_cons) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 0, ?)
        ";
        $stmt = $inmoconn->prepare($query_rsInsert);
        $stmt->bind_param("sssssssi", $id, $lang, $motivo, $name, $phone, $email, $comment, $client_id);
    } else {
        $query_rsInsert = "
            INSERT INTO properties_enquiries (inmueble_cons, idioma_cons, motivo_cons, nombre_cons, telefono_cons, email_cons, comentario_consas, fecha_cons, read_cons) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 0)
        ";
        $stmt = $inmoconn->prepare($query_rsInsert);
        $stmt->bind_param("sssssss", $id, $lang, $motivo, $name, $phone, $email, $comment);
    }

    if ($stmt->execute()) {
        savelogprop($_GET['id'], '3');
        $stmt->close();

        $query_rsInsert2 = "INSERT INTO newsletter_users (nombre_usr, email_usr, lang_usr, date_usr) VALUES (?, ?, ?, ?)";
        $date = date("Y-m-d H:i:s");
        $stmt = $inmoconn->prepare($query_rsInsert2);
        $stmt->bind_param("ssss", $name, $email, $lang, $date);
        if ($stmt->execute()) {
            $newsletter_id = $inmoconn->insert_id;
            $stmt->close();

            $query_rsInsert2 = "INSERT INTO newsletter_usr_cat (usr, cat) VALUES (?, ?)";
            $stmt = $inmoconn->prepare($query_rsInsert2);
            $category = simpleSanitize($idCatNewsletter);
            $stmt->bind_param("is", $newsletter_id, $category);
            $stmt->execute();
            $stmt->close();
        }

        $query_rsRef = "SELECT referencia_prop FROM properties_properties WHERE id_prop = ?";
        $stmt = $inmoconn->prepare($query_rsRef);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row_rsRef = $result->fetch_assoc();
        $stmt->close();

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
                        $body .= 'Nueva consulta sobre el inmueble con ref #' . $row_rsRef['referencia_prop'];
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                        $body .= '<p>Enviado: ' . date("d-m-Y H:i") . '</p>';
                        $body .= '<p>Motivo: ' . $motivo . '</p>';
                        $body .= '<p>Nombre: ' . $name . '</p>';
                        $body .= '<p>Teléfono: ' . $phone . '</p>';
                        $body .= '<p>Email: ' . $email . '</p>';
                        $body .= '<p>' . nl2br($comment) . '</p>';
                    $body .= '</div>';
                $body .= '</div>';
            $body .= '</td>';
        $body .= '</tr>';

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
        $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);

        $subject = 'Nueva consulta sobre el inmueble con ref #' . $row_rsRef['referencia_prop'];

        sendAppEmail($fromMail, '', '', [$_GET['email'] => $_GET['name']], $subject, $html);

        $propId = $_GET['id'];
        $refProp = $property[0]['ref'];
        $precio = $property[0]['precio'];
        $precio_limite_inferior = $precio - ($precio * 0.2);
        $precio_limite_superior = $precio + ($precio * 0.2);

        if ($opcionSimilares == 1) {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/similar-properties.php');
            if ($similaresContent != "") {

                $body2 = "";
                $body2 .= '<!-- Título -->';
                $body2 .= '<tr>';
                    $body2 .= '<td align="center-" style="padding: 20px 30px 0 30px;">';
                        $body2 .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                            $body2 .= '<h1 style="color: #222; font-size: 24px;">';
                                $body2 .= $langStr["Gracias por contactarnos"];
                            $body2 .= '</h1>';
                            $body2 .= "<p>" . $langStr["Hemos recibido tu consulta sobre la propiedad con las referencia"] . ": " . $row_rsRef['referencia_prop'] . ". " . $langStr["Uno de nuestros agentes se pondrá en contacto con usted lo antes posible"] . ".</p>";
                            $body2 .= '</div>';
                            $body2 .= $prop_enqu;
                            $body2 .= $similaresContent;
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

                $subject = $langStr["Property"] . " Ref: " . $row_rsRef['referencia_prop'] . " - " . $_SERVER['HTTP_HOST'];

                sendAppEmail([$_GET['email'] => $_GET['name']], '', '', [$fromMail => $fromName], $subject, $html2);
            }
        }
        echo "ok";
    } else {
        echo "no";
    }
}
