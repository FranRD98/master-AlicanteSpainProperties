<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

function addRefs($ids) {
    global $database_inmoconn, $inmoconn;
    if ($ids == '') {
        return '';
    }
    if ($ids[0] == ',') {
        $ids = substr($ids, 1);
    }
    
    $query_rsRefs = "SELECT referencia_prop FROM properties_properties WHERE id_prop IN (".$ids.")";
    $rsRefs = mysqli_query($inmoconn, $query_rsRefs) or die(mysqli_error() . '<hr>' . $query_rsRefs);
    $row_rsRefs = mysqli_fetch_assoc($rsRefs);
    $totalRows_rsRefs = mysqli_num_rows($rsRefs);
    $ret = array();
    do {
        array_push($ret, $row_rsRefs['referencia_prop']);
    } while ($row_rsRefs = mysqli_fetch_assoc($rsRefs));
    return implode(', ', $ret);
}

$query_rsusuarios = "SELECT nombre_usr, id_usr, email_usr FROM users WHERE (nivel_usr = 9 OR nivel_usr = 8)";
$rsusuarios = mysqli_query($inmoconn,$query_rsusuarios) or die(mysqli_error());
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);
if ($totalRows_rsusuarios > 0) {
    do {

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
                        $body .= 'Tus tareas para hoy / Your tasks for today';
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                                $query_rsCal = "
                                SELECT
                                    citas.id_ct,
                                    citas.categoria_ct,
                                    citas.user_ct,
                                    citas.users_ct,
                                    citas.property_ct,
                                    citas.inicio_ct,
                                    citas.final_ct,
                                    citas.titulo_ct,
                                    citas.lugar_ct,
                                    citas.notas_ct,
                                    citas_categories.color_ct,
                                    citas_categories.category_es_ct,
                                    citas_categories.category_en_ct,
                                    users.nombre_usr,
                                    properties_client.id_cli,
                                    properties_client.nombre_cli,
                                    properties_client.apellidos_cli
                                FROM citas
                                    LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
                                    LEFT OUTER JOIN users ON citas.user_ct = users.id_usr
                                    LEFT OUTER JOIN properties_client ON citas.users_ct = properties_client.id_cli
                                WHERE DATE(citas.inicio_ct) = DATE(NOW()) AND user_ct = '" . $row_rsusuarios['id_usr'] . "'
                                ORDER BY citas.inicio_ct ASC";
                                $rsCal = mysqli_query($inmoconn,$query_rsCal) or die(mysqli_error());
                                $row_rsCal = mysqli_fetch_assoc($rsCal);
                                $totalRows_rsCal = mysqli_num_rows($rsCal);
                                if ($totalRows_rsCal > 0) {
                                    $body .= "<b style=\"font-size: 16px;\">Calendario / Calendar</b><hr>";
                                    do {
                                        $body .= "<div style=\"padding: 10px; background: #f3f3f3; margin-bottom: 10px; font-size: 14px;\">";
                                            $body .= "" . date("d-m-Y H:i", strtotime($row_rsCal['inicio_ct'])) . " - ";
                                            $body .= "" . date("d-m-Y H:i", strtotime($row_rsCal['final_ct'])) . " | ";
                                            $body .= $row_rsCal['category_es_ct'] . " / " . $row_rsCal['category_en_ct'] . "<br>";
                                            $body .= $row_rsCal['titulo_ct'] . "";
                                            if ($row_rsCal['nombre_cli'] != '' || $row_rsCal['apellidos_cli'] != '') {
                                                $body .= ' | ' . $row_rsCal['nombre_cli'] . ' ' . $row_rsCal['apellidos_cli'];
                                            }
                                            if ($row_rsCal['property_ct'] != '') {
                                                $body .= ' | ' . addRefs($row_rsCal['property_ct']) . '';
                                            }
                                            if ($row_rsCal['lugar_ct'] != '') {
                                                $body .= ' | ' . $row_rsCal['lugar_ct'] . '';
                                            }
                                        $body .= "</div>";
                                    } while ($row_rsCal = mysqli_fetch_assoc($rsCal));
                                }

                                $query_rsTasks = "
                                SELECT SQL_CALC_FOUND_ROWS
                                  admin_tsk,
                                  (SELECT nombre_usr FROM users WHERE id_usr  = admin_tsk) as admin_tsk2,
                                  subject_tsk,
                                  date_due_tsk,
                                  priority_tsk,
                                  (SELECT categorias_en_cat as cat FROM tasks_categories WHERE id_cat = status_tsk) as status_tsk,
                                  case contact_type_tsk
                                      when '1' then (SELECT CONCAT ('- ', nombre_cnt, ' ', apellidos_cnt) FROM contactos WHERE id_cnt = contact_tsk)
                                      when '2' then (SELECT CONCAT ('- ', nombre_cli, ' ', apellidos_cli) FROM properties_client WHERE id_cli = contact_tsk)
                                      when '3' then (SELECT CONCAT ('- ', nombre_pro, ' ', apellidos_pro) FROM properties_owner WHERE id_pro = contact_tsk)
                                      when '' then ''
                                  end as contact_type_tsk,
                                  id_tsk
                                FROM tasks
                                WHERE DATE(date_due_tsk) <= DATE(NOW()) AND admin_tsk = '" . $row_rsusuarios['id_usr'] . "' AND status_tsk != 2";
                                $rsTasks = mysqli_query($inmoconn,$query_rsTasks) or die(mysqli_error());
                                $row_rsTasks = mysqli_fetch_assoc($rsTasks);
                                $totalRows_rsTasks = mysqli_num_rows($rsTasks);
                                if ($totalRows_rsTasks > 0) {
                                    $body .= "<br><b style=\"font-size: 16px;\">Tareas / Tasks</b><hr>";
                                    do {
                                        $body .= "<div style=\"padding: 10px; background: #f3f3f3; margin-bottom: 10px; font-size: 14px;\">";
                                            $body .= "" . date("d-m-y", strtotime($row_rsTasks['date_due_tsk'])) . "<br>";
                                            $body .= $row_rsTasks['subject_tsk'] . "";
                                        $body .= "</div>";
                                    } while ($row_rsTasks = mysqli_fetch_assoc($rsTasks));
                                }

                                $query_rsLlamadasCompra = "
                                SELECT SQL_CALC_FOUND_ROWS
                                 CONCAT(
                                     COALESCE(nombre_cli,''),
                                     IF(LENGTH(apellidos_cli), ' | ', ''),
                                     COALESCE(apellidos_cli,'')
                                 ) AS nombre_cli,
                                 next_call_cli,
                                 email_cli,
                                 CONCAT(
                                     COALESCE(telefono_fijo_cli,''),
                                     IF(LENGTH(telefono_movil_cli), ' | ', ''),
                                     COALESCE(telefono_movil_cli,'')
                                 ) AS telefono_fijo_cli,
                                 (SELECT nombre_usr  FROM users WHERE id_usr = atendido_por_cli LIMIT 1) as atendido_por_cli,
                                 id_cli
                                FROM properties_client
                                WHERE DATE(next_call_cli) = DATE(NOW()) AND atendido_por_cli = '" . $row_rsusuarios['id_usr'] . "'";
                                $rsLlamadasCompra = mysqli_query($inmoconn,$query_rsLlamadasCompra) or die(mysqli_error());
                                $row_rsLlamadasCompra = mysqli_fetch_assoc($rsLlamadasCompra);
                                $totalRows_rsLlamadasCompra = mysqli_num_rows($rsLlamadasCompra);
                                if ($totalRows_rsLlamadasCompra > 0) {
                                    $body .= "<br><b style=\"font-size: 16px;\">LLamadas a compradores / Calls to buyers</b><hr>";
                                    do {
                                        $body .= "<div style=\"padding: 10px; background: #f3f3f3; margin-bottom: 10px; font-size: 14px;\">";
                                            $body .= "" . date("d-m-y", strtotime($row_rsLlamadasCompra['next_call_cli'])) . "<br>";
                                            $body .= $row_rsLlamadasCompra['nombre_cli'] . "";
                                        $body .= "</div>";
                                    } while ($row_rsLlamadasCompra = mysqli_fetch_assoc($rsLlamadasCompra));
                                }

                                $query_rsNewProperties = "
                                SELECT id_prop
                                FROM properties_properties
                                WHERE DATE(inserted_xml_prop) = DATE(NOW()) AND activado_prop = 1 AND activado_prop = 1 AND (xml_xml_prop > 0)";
                                $rsNewProperties = mysqli_query($inmoconn,$query_rsNewProperties) or die(mysqli_error());
                                $row_rsNewProperties = mysqli_fetch_assoc($rsNewProperties);
                                $totalRows_rsNewProperties = mysqli_num_rows($rsNewProperties);
                                if ($totalRows_rsNewProperties > 0) {
                                    $body .= "<br><b style=\"font-size: 16px;\">Nuevos inmuebles importados / New imported properties</b><hr>";
                                    $body .= "<div style=\"padding: 10px; background: #f3f3f3; margin-bottom: 10px; font-size: 14px;\">";
                                        $body .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '/intramedianet/properties/history.php">Ver propeidades / View properties</a>';
                                    $body .= "</div>";
                                }

                                $query_rsRateProps = "
                                SELECT
                                (SELECT nombre_cli FROM properties_client WHERE id_cli = client) AS name,
                                client
                                FROM cli_prop_rate
                                WHERE DATE(`date`) = DATE(CURDATE() - INTERVAL 1 DAY) AND (SELECT atendido_por_cli FROM properties_client WHERE id_cli = client) = '" . $row_rsusuarios['id_usr'] . "' GROUP BY client";
                                $rsRateProps = mysqli_query($inmoconn,$query_rsRateProps) or die(mysqli_error());
                                $row_rsRateProps = mysqli_fetch_assoc($rsRateProps);
                                $totalRows_rsRateProps = mysqli_num_rows($rsRateProps);
                                if ($totalRows_rsRateProps > 0) {
                                    $body .= "<br><b style=\"font-size: 16px;\">Nuevos valoraciones de inmuebles / New property rates</b><hr>";
                                    do {
                                        $body .= "<div style=\"padding: 10px; background: #f3f3f3; margin-bottom: 10px; font-size: 14px;\">";
                                            $body .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '/intramedianet/properties/clients-form.php?id_cli=' . $row_rsRateProps['client'] . '">' . $row_rsRateProps['name'] . '</a>';
                                            $body .= $row_rsRateProps['nombre_cli'] . "";
                                        $body .= "</div>";
                                    } while ($row_rsRateProps = mysqli_fetch_assoc($rsRateProps));
                                }
                    $body .= '</div>';
                $body .= '</div>';
            $body .= '</td>';
        $body .= '</tr>';

        $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
        $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
        $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.';

        if (($totalRows_rsCal*1 + $totalRows_rsTasks*1 + $totalRows_rsNewProperties*1 + $totalRows_rsRateProps*1) > 0) {
            $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
            $html = preg_replace('/{CONTENT}/', $body , $html);
            $html = preg_replace('/{FOOTER}/', $footer, $html);
            $html = preg_replace('/{COLOR}/', $mailColor, $html);
            $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
            $subject = $row_rsusuarios['nombre_usr'] . ' | Tus tareas para hoy / Your tasks for today';

            sendAppEmail(array($row_rsusuarios['email_usr'] => $row_rsusuarios['nombre_usr']), '', '', '', $subject, $html);
        }

    } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
}