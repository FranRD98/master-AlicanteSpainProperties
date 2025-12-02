<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php' );

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

$show_rate = 1;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
set_time_limit(0);

$translate = array();
foreach ($languages as $lang) {
    include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$lang.".php");
    $translate[$lang] = $langStr;
}

function getIp()
{
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

function dd($val)
{
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}

function sendAppEmailMandrill($to, $cc, $bcc, $replyTo, $subject, $body)
{
    global $smtpUrlAlt, $smtpPortAlt, $smtpUserAlt, $smtpPassAlt, $fromMailAlt, $_SESSION, $_SERVER, $fromNameAlt;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

    $fromMailAltVal = $fromMailAlt;

    $transport = Swift_SmtpTransport::newInstance($smtpUrlAlt, $smtpPortAlt, 'ssl')
        ->setUsername($smtpUserAlt)
        ->setPassword($smtpPassAlt)
    ;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance()
    ->setSubject($subject)
    ->setFrom(array($fromMailAltVal => $fromNameAlt))
    ->setTo($to)
    ->setBody($body, 'text/html');

    if ($cc != '') {
        $message->setCc($cc);
    }

    if ($bcc != '') {
        $message->setBcc($bcc);
    }

    if ($replyTo != '') {
        $message->setReplyTo($replyTo);
    }

    return $mailer->send($message);
}

$clientes = getRecords("
    SELECT
        id_cli,
        idioma_cli,
        nombre_cli,
        apellidos_cli,
        email_cli,
        b_sale_cli,
        b_type_cli,
        b_loc1_cli,
        b_loc2_cli,
        b_loc3_cli,
        b_loc4_cli,
        b_precio_desde_cli,
        b_precio_hasta_cli,
        b_beds_cli,
        b_baths_cli,
        b_opciones_cli,
        b_opciones2_cli,
        b_tags_cli,
        b_orientacion_cli,
        b_pool_cli,
        b_m2_desde_cli,
        b_m2_hasta_cli,
        b_m2p_desde_cli,
        b_m2p_hasta_cli,
        b_parking_cli
    FROM properties_client
    WHERE send_props_cli = 1
    AND (last_send_props_cli IS NULL OR last_send_props_cli < NOW() - INTERVAL 1 WEEK)
    AND email_cli IS NOT NULL
    AND idioma_cli IS NOT NULL
    AND archived_cli != 1
    ORDER BY id_cli DESC


");

foreach ($clientes as $client) {
    if (!$client) {
        continue;
    }

    if ($client['b_sale_cli'] == '' && $client['b_type_cli'] == '' && $client['b_loc1_cli'] == '' && $client['b_loc2_cli'] == '' && $client['b_loc3_cli'] == '' && $client['b_loc4_cli'] == '' && $client['b_precio_desde_cli'] == '' && $client['b_precio_hasta_cli'] == '' && $client['b_beds_cli'] == '' && $client['b_baths_cli'] == '' && $client['b_opciones_cli'] == '' && $client['b_opciones2_cli'] == '' && $client['b_orientacion_cli'] == '' && $client['b_pool_cli'] == '' && $client['b_parking_cli'] == '' && $client['b_m2_desde_cli'] == '' && $client['b_m2_hasta_cli'] == '' && $client['b_m2p_desde_cli'] == '' && $client['b_m2p_hasta_cli'] == '') {
        continue;
    }

    $op = '';
    $opjoin = '';
    if (isset($client['b_opciones_cli']) && $client['b_opciones_cli'] != '') {
        $opciones = $client['b_opciones_cli'];
        if ($opciones != '') {
            $op = "AND properties_property_feature.feature IN (" . $opciones . ")";
            $opjoin = "INNER JOIN properties_property_feature ON properties_properties.id_prop = properties_property_feature.property";
        }
    }

    $op2 = '';
    $opjoin2 = '';
    if (isset($client['b_opciones2_cli']) && $client['b_opciones2_cli'] != '') {
        $opciones2 = $client['b_opciones2_cli'];
        if ($opciones2 != '') {
            $op2 = "AND properties_property_feature_priv.feature IN (" . $opciones2 . ")";
            $opjoin2 = "INNER JOIN properties_property_feature_priv ON properties_properties.id_prop = properties_property_feature_priv.property";
        }
    }


    $st = '';
    if (isset($client['b_sale_cli']) && $client['b_sale_cli'] != '') {
        $status = $client['b_sale_cli'];
        if ($status != '') {
            $st = "AND (operacion_prop IN (" . $status . ") OR operacion_prop LIKE '14')";
        }
    }

    $ty = '';
    if (isset($client['b_type_cli']) && $client['b_type_cli'] != '') {
        $type = $client['b_type_cli'];
        if ($type != '') {
            $ty = "AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . $type . ")";
        }
    }

    $bd = '';
    if (isset($client['b_beds_cli']) && $client['b_beds_cli'] != '') {
        $bd = "AND habitaciones_prop >= " . $client['b_beds_cli'];
    }

    $bt = '';
    if (isset($client['b_baths_cli']) && $client['b_baths_cli'] != '') {
        $bt = "AND aseos_prop >= " . $client['b_baths_cli'];
    }

    $ref = '';
    if (isset($client['b_ref_cli']) && $client['b_ref_cli'] != '') {
        $reference = $client['b_ref_cli'];
        if ($reference != '') {
            $ref = "AND referencia_prop IN (" . $reference . ")";
        }
    }

    $prd = '';
    if (isset($client['b_precio_desde_cli']) && $client['b_precio_desde_cli'] != '') {
        $prd = "AND preci_reducidoo_prop >= " . $client['b_precio_desde_cli'];
    }

    $prh = '';
    if (isset($client['b_precio_hasta_cli']) && $client['b_precio_hasta_cli'] != '') {
        $prh = "AND preci_reducidoo_prop <= " . $client['b_precio_hasta_cli'];
    }

    $or2 = '';
    if (isset($client['b_orientacion_cli']) && $client['b_orientacion_cli'] != '') {
        $or2 = "AND orientacion_prop = '" . $client['b_orientacion_cli'] . "'";
    }

    $m2d = '';
    if( isset($client['b_m2_desde_cli'][0]) && $client['b_m2_desde_cli'][0] != '' ){
      $m2d = "AND m2_prop >= " . $client['b_m2_desde_cli'][0]."";
    }

    $m2h = '';
    if( isset($client['b_m2_hasta_cli'][0]) && $client['b_m2_hasta_cli'][0] != '' ){
      $m2h = "AND m2_prop <= " . $client['b_m2_hasta_cli'][0]."";
    }

    $m2pd = '';
    if( isset($client['b_m2p_desde_cli'][0]) && $client['b_m2p_desde_cli'][0] != '' ){
      $m2pd= "AND m2_parcela_prop >= " . $client['b_m2p_desde_cli'][0]."";
    }

    $m2ph = '';
    if( isset($client['b_m2p_hasta_cli'][0]) && $client['b_m2p_hasta_cli'][0] != '' ){
      $m2ph= "AND m2_parcela_prop <= " . $client['b_m2p_hasta_cli'][0]."";
    }

    $m2ut = '';
    if (isset($client['m2ut'])&&$client['m2ut']==1) {
        $m2ut = "AND ((m2_prop <= 90 AND m2_prop != 0))";
    } elseif (isset($client['m2ut'])&&$client['m2ut']==2) {
        $m2ut = "AND ((m2_prop >= 90 AND m2_prop <= 120 AND m2_prop != 0))";
    } elseif (isset($client['m2ut'])&&$client['m2ut']==3) {
        $m2ut = "AND ((m2_prop >= 120 AND m2_prop <= 200 AND m2_prop != 0))";
    } elseif (isset($client['m2ut'])&&$client['m2ut']==4) {
        $m2ut = "AND ((m2_prop >= 200 AND m2_prop != 0))";
    }

    $m2pl = '';
    if (isset($client['m2pl'])&&$client['m2pl']==1) {
        $m2pl = "AND ((m2_parcela_prop <= 1000 AND m2_parcela_prop != 0))";
    } elseif (isset($client['m2pl'])&&$client['m2pl']==2) {
        $m2pl = "AND ((m2_parcela_prop >= 1000 AND m2_parcela_prop <= 2000))";
    } elseif (isset($client['m2pl'])&&$client['m2pl']==3) {
        $m2pl = "AND ((m2_parcela_prop >= 2000 AND m2_parcela_prop <= 5000))";
    } elseif (isset($client['m2pl'])&&$client['m2pl']==4) {
        $m2pl = "AND ((m2_parcela_prop >= 5000 AND m2_parcela_prop <= 10000))";
    } elseif (isset($client['m2pl'])&&$client['m2pl']==5) {
        $m2pl = "AND ((m2_parcela_prop >= 10000 AND m2_parcela_prop <= 20000))";
    } elseif (isset($client['m2pl'])&&$client['m2pl']==6) {
        $m2pl = "AND ((m2_parcela_prop >= 20000))";
    }


    $loc4 = '';
    if (isset($client['b_loc4_cli']) && $client['b_loc4_cli'] != '') {
        $zone = $client['b_loc4_cli'];
        if ($zone != '') {
            $loc4 = "AND (properties_loc4.id_loc4 IN (" . $zone . ") OR properties_loc4.parent_loc4 IN (" . $zone . ") OR towns.id_loc4 IN (" . $zone . ") OR towns.parent_loc4 IN (" . $zone . ")) ";
        }
    }


    $loc3 = '';
    if (isset($client['b_loc3_cli']) && $client['b_loc3_cli'] != '') {
        $location = $client['b_loc3_cli'];
        if ($location != '') {
            $loc3 = "AND (properties_loc3.id_loc3 IN (" . $location . ") OR properties_loc3.parent_loc3 IN (" . $location . ") OR areas1.id_loc3 IN (" . $location . ") OR areas1.parent_loc3 IN (" . $location . ")) ";
        }
    }

    $loc2 = '';
    if (isset($client['b_loc2_cli']) && $client['b_loc2_cli'] != '') {
        $province = $client['b_loc2_cli'];
        if ($province != '') {
            $loc2 = "AND (properties_loc2.id_loc2 IN (" . $province . ") OR properties_loc2.parent_loc2 IN (" . $province . ") OR province1.id_loc2 IN (" . $province . ") OR province1.parent_loc2 IN (" . $province . ")) ";
        }
    }

    $loc1 = '';
    if (isset($client['b_loc1_cli']) && $client['b_loc1_cli'] != '') {
        $location = $client['b_loc1_cli'];
        if ($location != '') {
            $loc1 = "AND id_loc1 IN (" . $location . ")";
        }
    }

    $pool = '';
    if (isset($client['b_pool_cli']) && $client['b_pool_cli'] != '') {
        $poolsids = $client['b_pool_cli'];
        if ($poolsids != '') {
            $pool = "AND piscina_prop IN (" . $poolsids . ")";
        }
    }

    $parking = '';
    if (isset($client['b_parking_cli']) && $client['b_parking_cli'] != '') {
        $parkingsids = $client['b_parking_cli'];
        if ($parkingsids != '') {
            $parking = "AND parking_prop IN (" . $parkingsids . ")";
        }
    }

    $query_RS = "SELECT GROUP_CONCAT(property) as ids FROM cli_prop_noint WHERE client = '".$client['id_cli']."' GROUP BY client";
    $RS = mysqli_query($inmoconn, $query_RS) or die(mysqli_error());
    $row_RS = mysqli_fetch_assoc($RS);
    $totalRows_RS = mysqli_num_rows($RS);
    $retQRY = "";
    if ($row_RS['ids'] != '') {
        $retQRY .= ' AND id_prop NOT IN ('.$row_RS['ids'].')';
    }

    $properties_Query = "
        SELECT
            substring_index(group_concat(DISTINCT properties_properties.id_prop), ',', 7) as ids
        FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
        LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
        LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
          $opjoin
          $opjoin2
        WHERE activado_prop = 1
            AND id_prop IS NOT NULL
            AND vendido_prop = 0
            AND alquilado_prop = 0
            AND reservado_prop = 0
            AND vendido_tag_prop = 0
             AND force_hide_prop != 1
            AND properties_images.procesada_img = 1
            AND (SELECT count(*)
                FROM properties_log_mails
                WHERE
                    properties_log_mails.email_log = '".$client['email_cli']."' AND
                    properties_log_mails.prop_id_log = properties_properties.id_prop AND
                    properties_log_mails.type_log = 2
                ) <= 0
        $retQRY
        $st $op $op2  $ty $bd $bt $ref $prd $prh $or2 $m2ut $m2pl $loc4 $loc3 $loc2 $loc1 $pool $parking $m2d $m2h $m2pd $m2ph
    ";


    $properties = mysqli_query($inmoconn, $properties_Query) or die(mysqli_error());
    $properties = mysqli_fetch_assoc($properties);

    $ids = explode(",", $properties["ids"]);
    if (!$ids[0]) {
        continue;
    }

    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html');
    $html = ob_get_contents();
    ob_end_clean();

    $templates_Query = "
        SELECT
           subject_".$client['idioma_cli']."_tmpl as asunto,
           content_".$client['idioma_cli']."_tmpl as texto
        FROM templates
        WHERE week_tmpl = 1
            AND subject_".$client['idioma_cli']."_tmpl != ''

        ORDER BY RAND()

        LIMIT 1

    ";

    $templates = mysqli_query($inmoconn, $templates_Query);
    $templates = mysqli_fetch_assoc($templates);

    ////////////////////

    if($templates['texto'] != '') {
        $templates['texto'] = preg_replace('/{{CLIENT}}/', $client['nombre_cli'] , $templates['texto']);
        $bodyTXT  = '<div style="padding-left:10px">'.$templates['texto'].'</div>';
    }
    else {
        $bodyTXT  = "<p>".$translate[$client['idioma_cli']]['Hola']." " . trim($client['nombre_cli']) . ",</p>";
        $bodyTXT  .= "<p>".$translate[$client['idioma_cli']]['Newsletter Automática - Texto - '.rand(1, 3)]."</p>";
    }

    if($templates['asunto']) {
        $templates['asunto'] = preg_replace('/{{CLIENT}}/', $client['nombre_cli'] , $templates['asunto']);
        $subject = $templates['asunto'];
    }
    else {
        $subject = $translate[$client['idioma_cli']]['Newsletter Automática - Asunto - '.rand(1, 6)];
    }

    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 20px 30px 0 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $subject;
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= $bodyTXT;
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    ////////////////////

    for ($i=0; $i < 1; $i++) {

        $client['idioma_cli'] = ($client['idioma_cli'] == 'sw')?'se':$client['idioma_cli'];

        $langVal = $client['idioma_cli'];
        $langValuage = $client['idioma_cli'];
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

        if ($smtpPortAlt != 'smtp.acumbamail.com') {
            $query_rsInsert3 = "
                INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
                ( NULL, '47',  '".$ids[$i]."',  '".mysqli_real_escape_string($inmoconn, $client['email_cli'])."',  '2', '', '".date("Y-m-d H:i:s")."' )
            ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        $query_rsInsert2 = "

            INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
            ( NULL ,  '".$ids[$i]."',  '".getIp()."',  '".date("Y-m-d H:i:s")."', '".$_SESSION['kt_login_id']."', '".$client['id_cli']."' )

        ";
        mysqli_query($inmoconn,$query_rsInsert2);


    }

    if ($ids[1] > 0) {

        $body .= '<tr>';

        $body .= '<td style="padding: 0 30px 20px 30px;">';

        $body .= '<h3 style="font-size: 28px; color: #333; text-align: center;">🔎 ' . $langStr["También te pueden interesar"] . ':</h3>';

        $body .= '<table width="100%" cellpadding="0" cellspacing="0">';

        $body .= '<tr>';

        for ($i=1; $i < count($ids); $i++) {

            $body .= "<td>";

            $langVal = $client['idioma_cli'];
            $idVal = $ids[$i];

            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate_mini.php');
            $body .= ob_get_contents();
            ob_end_clean();

            $tipo = 2;

            if ($_GET['tipo'] != '') {
                $tipo = $_GET['tipo'];
            }

            if ($_GET['comment'] == '') {
                $_GET['comment'] = $body;
            }

            if ($smtpPortAlt != 'smtp.acumbamail.com') {
                $query_rsInsert3 = "
                    INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
                    ( NULL, '".$_SESSION['kt_login_id']."',  '".$ids[$i]."',  '".mysqli_real_escape_string($inmoconn,$_GET['email'])."',  '".$tipo."', '".mysqli_real_escape_string($inmoconn,$_GET['comment'])."', '".date("Y-m-d H:i:s")."' )
                ";
                mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
            }

            $query_rsInsert2 = "

                INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
                ( NULL ,  '".$ids[$i]."',  '".getIp()."',  '".date("Y-m-d H:i:s")."', '".$_SESSION['kt_login_id']."', '".$_GET['usr']."' )

            ";
            mysqli_query($inmoconn,$query_rsInsert2);

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

        $body .= '<td style="padding: 0 30px 20px 30px;">';

        $body .= '<p>';
        $body .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart  . 'rate/?id_cli=' . $row_rsCli['nombre_cli'] . '&id_props=' . $_GET['ids'] . '" style="background-color: ' . $mailColor . '; color: #fff; padding: 15px 20px; text-decoration: none; border-radius: 223px; display: inline-block; border-radius: 23px; display: block; max-width: 100%; text-align: center; font-size: 16px;">📝 ' . $langStr["Valora las casas que te hemos enviado"] . '</a>';
        $body .= '</p>';

        $body .= '<p style="font-size: 14px; text-align: center; font-weight:bold">' . $langStr["Nos ayudas a enviarte solo lo que realmente te interesa"] . '</p>';

        $body .= '</td>';

        $body .= '</tr>';

        $body .= '<tr>';
           $body .= '<td style="padding: 20px 30px;">';
               $body .= '<div style="display: block; border-top: 1px solid #dedede;"></div>';
           $body .= '</td>';
        $body .= '</tr>';

    }

    foreach ($ids as $id) {
        if ($smtpPortAlt != 'smtp.acumbamail.com') {
            $query_rsInsert3 = " INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`)
            VALUES ( NULL, '47',  '".$id."',  '".mysqli_real_escape_string($inmoconn,$client['email_cli'])."',  '2', '', '".date("Y-m-d H:i:s")."' ) ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }
    }

    $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
    $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
    $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';
    $footer .= '<a href="https://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['lang'] . '/unsubscribe/?id=' . encryptIt($row_rsCli['id_cli'],$nombreEmpresa) . '" style="color: #000; text-decoration: none; font-weight: bold;">' .$langStr["Darme de baja"] . '</a>';

    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $body = preg_replace('/{PROPS}/', $_GET['ids'], $body);
    $body = preg_replace('/{CLIENT}/', $row_rsCli['id_cli'], $body);
    $body = preg_replace('/{{CLIENT}}/', $row_rsCli['nombre_cli'], $body);
    $html = preg_replace('/{CONTENT}/', $body, $html);
    $html = preg_replace('/{FOOTER}/', $footer, $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{RATE}/', $langStr["Rate this property"], $html);
    $html = preg_replace('/{URLBAJA}/', 'https://'.$_SERVER['HTTP_HOST'].'/'.$langValuage.'/unsubscribe/?id='.encryptIt($client['id_cli'], $nombreEmpresa), $html);

    if($templates['asunto']) {
        $templates['asunto'] = preg_replace('/{{CLIENT}}/', $client['nombre_cli'] , $templates['asunto']);
        $subject = $templates['asunto'].' - '. $_SERVER['HTTP_HOST'];
    }
    else {
        $subject = $translate[$client['idioma_cli']]['Newsletter Automática - Asunto - '.rand(1, 6)].' - '. $_SERVER['HTTP_HOST'];
    }

    // echo $html;
    // die();

    if ($smtpPortAlt == 'smtp.acumbamail.com') {

        $acumba = new AcumbamailAPI($keyAcumbamailSMTP);
        $result = $acumba->sendOne($fromMailAlt, $client['email_cli'], $html, $subject);

        if ($result['result'][0]['message_id'] != '') {

            for ($i=0; $i < count($ids); $i++) {
                $query_rsInsert3 = " INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`)
                VALUES ( NULL, '47',  '".$id."',  '".mysqli_real_escape_string($inmoconn,$client['email_cli'])."',  '2', '', '".date("Y-m-d H:i:s")."', '" . $result['result'][0]['message_id'] . "' ) ";
                mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
            }

            echo "ok";
        } else {
            echo "no";
        }

    } else {
        if (sendAppEmailMandrill(array($client['email_cli'] => $client['nombre_cli']." ".$client['apellidos_cli']), '', '', $fromMailAlt, $subject, $html)) {
            $query_emailSent = "UPDATE  `properties_client` SET  last_send_props_cli =  NOW() WHERE  properties_client.id_cli = '".$client['id_cli']."';";
            mysqli_query($inmoconn,$query_emailSent);
        }
    }

}
die();
