<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

$xxx = 1;


require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

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

function sendAppEmailSearchs($to, $cc, $bcc, $replyTo, $subject, $body)
{
    global $smtpUrlAlt, $smtpPortAlt, $smtpUserAlt, $smtpPassAlt, $fromMailAlt, $_SESSION, $_SERVER;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

    $fromMailAltVal = $fromMailAlt;

    $transport = Swift_SmtpTransport::newInstance($smtpUrlAlt, $smtpPortAlt, 'ssl')
        ->setUsername($smtpUserAlt)
        ->setPassword($smtpPassAlt)
    ;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance()
    ->setSubject($subject)
    ->setFrom($fromMailAltVal)
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

$query_rsBusquedas = "
    SELECT
    email_usr, id_usr, nombre_usr, id, `user`, `query`, send, created
    FROM users_searchs JOIN users ON `user` = id_usr
    WHERE send = 1

";
$rsBusquedas = mysqli_query($inmoconn,$query_rsBusquedas) or die(mysqli_error() . '<hr>' . $query_rsBusquedas);
$row_rsBusquedas = mysqli_fetch_assoc($rsBusquedas);
$totalRows_rsBusquedas = mysqli_num_rows($rsBusquedas);

do {

    set_time_limit(0);

    $query = json_decode($row_rsBusquedas['query']);

    include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$query->langx.".php");

    // echo "<pre>";
    // print_r($query);
    // echo "</pre><hr>";

    //  ============================================================================
    //  === STATUS
    //  ============================================================================

    $st = '';
    if (isset($query->st) && $query->st[0] != '') {
        $status = implode(',', $query->st);
        if ($status != '') {
            $st = "AND operacion_prop  IN (" . $status . ")";
        }
    }

    //  ============================================================================
    //  === PRICE -> MINI SEARCH
    //  ============================================================================

    $prds = '';
    if ( isset($query->prds) && $query->prds != '' ) {
        $prds = "AND preci_reducidoo_prop*1 >= " . $query->prds;
    }

    $prhs = '';
    if ( isset($query->prhs) && $query->prhs != '' && $query->prhs != '1000000' ) {
        $prhs = "AND preci_reducidoo_prop*1 <= " . $query->prhs;
    }
    if ( isset($query->prhs) && $query->prhs != '' && $query->prhs == '1000000' && $query->prhs == '3000' ) {
        $prhs = "AND preci_reducidoo_prop*1 <= " . $query->prhs;
    }



    $pricerange = '';
    if ( isset($query->pricerange) && $query->pricerange != '' && $query->pricerange != '0' ) {
        if($query->pricerange == 1){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 0 AND 40000";
        }
        if($query->pricerange == 2){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 40000 AND 60000";
        }
        if($query->pricerange == 3){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 60000 AND 80000";
        }
        if($query->pricerange == 4){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 80000 AND 100000";
        }
        if($query->pricerange == 5){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 100000 AND 125000";
        }
        if($query->pricerange == 6){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 125000 AND 150000";
        }
        if($query->pricerange == 7){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 150000 AND 200000";
        }
        if($query->pricerange == 8){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 200000 AND 250000";
        }
        if($query->pricerange == 9){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 250000 AND 300000";
        }
        if($query->pricerange == 10){
            $pricerange = "AND preci_reducidoo_prop BETWEEN 300000 AND 999999999";
        }
    }

    //  ============================================================================
    //  === TYPE
    //  ============================================================================

    $typ = '';
    if( isset($query->tp) && $query->tp != '' ){
        $type = implode(',', $query->tp);
        if ($type  != '') {
            $typ = "AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . $type . ")";
        }
    }

    //  ============================================================================
    //  === PROVINCE
    //  ============================================================================

    $lopr = '';
    if (isset($query->lopr) && $query->lopr != '') {
        $province = implode(',', $query->lopr);
        if ($province != '') {
            $lopr = "AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (" . ($province) . ")";
        }
    }


    //  ============================================================================
    //  === Zone
    //  ============================================================================

    $lozn = '';
    if (isset($query->lozn) && $query->lozn != '') {
        $zone = implode(',', $query->lozn);
        if ($zone != '') {
            $lozn = "AND CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END IN (" . ($zone) . ")";
        }
    }

    //  ============================================================================
    //  === CITY
    //  ============================================================================

    $loct = '';
    if (isset($query->loct) && $query->loct != '') {
        $location = implode(',', $query->loct);
        if ($location != '') {
            $loct = "AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (" . ($location) . ")";
        }
    }

    //  ============================================================================
    //  === BEDROOMS
    //  ============================================================================

    $bd = '';
    if( isset($query->bd) && $query->bd != '' ){
        $bd = "AND habitaciones_prop >= " . $query->bd;
    }

    //  ============================================================================
    //  === REFERENCE
    //  ============================================================================

    $rf = '';
    if (isset($query->rf) && $query->rf != '') {
        $rf = "AND referencia_prop LIKE '%" . simpleSanitize(($query->rf)) . "%'";
    }

    //  ============================================================================
    //  === POOL
    //  ============================================================================

    $po = '';
    $tableFeaturesWithTags = '';
    $tableFeaturesTemplate = "LEFT OUTER JOIN properties_property_feature ON properties_properties.id_prop = properties_property_feature.property
    LEFT OUTER JOIN properties_property_feature_priv ON properties_properties.id_prop = properties_property_feature_priv.property ";
    if (isset($query->pool) && $query->pool != '') {
        // Se añaden en piscina, las features commnunal pool + private pool
        if ($query->pool == 2) {
            $po = "AND (( piscina_prop = ".$query->pool."))"; //OR properties_property_feature.feature IN(34,59)
        } else {
            $po = "AND (( piscina_prop = ".$query->pool."))";// OR properties_property_feature.feature IN(43,60,35)
        }
        $tableFeaturesWithTags = $tableFeaturesTemplate;
    }


    //  ============================================================================
    //  === TAGS
    //  ============================================================================

    $tags = '';
    $tableTags = '';

    if (isset($query->tags) && $query->tags[0] != '') {
        $tagsValue = implode(',', $query->tags);
        if (count($query->tags) > 1) {
            $queryTags = "SELECT property FROM properties_property_tag  WHERE tag IN(".$tagsValue.") GROUP BY property  HAVING count(property) = ".count($query->tags)."";
            $thetags = getRecords($queryTags);
            $theIdsTags = array();
            foreach ($thetags as $tag) {
                if ($tag['property'] != '') {
                    array_push($theIdsTags, $tag['property']);
                }
            }
            if (count($theIdsTags) > 0) {
                $tags = "AND id_prop IN(".implode(',', $theIdsTags).")";
            } else {
                $tags = "AND id_prop IN(-1)";
            }
        } else {
            $tags = "AND properties_property_tag.tag IN(".$tagsValue.")";
        }

        if ($po != '') {
            if ($query->pool == 2) {
                $tags = "AND ( " . str_replace('AND', ' ', $tags) . " AND (( piscina_prop = ".$query->pool.")))";// OR properties_property_feature.feature IN(34,59))
            } else {
                $tags = "AND ( " . str_replace('AND', ' ', $tags) . " AND (( piscina_prop = ".$query->pool.") ))"; //OR properties_property_feature.feature IN(43,60,35))
            }
            // $tableTags = $tableFeaturesWithTags;
            $po = '';
        }
        $tableTags .= "LEFT OUTER JOIN properties_property_tag ON properties_properties.id_prop = properties_property_tag.property ";
    }


    $query_RS = "SELECT GROUP_CONCAT(property) as ids FROM cli_prop_noint WHERE client = '".$row_rsBusquedas['id_usr']."' GROUP BY client";
    $RS = mysqli_query($inmoconn,$query_RS) or die(mysqli_error());
    $row_RS = mysqli_fetch_assoc($RS);
    $totalRows_RS = mysqli_num_rows($RS);
    $retQRY = "";
    if ($row_RS['ids'] != '') {
        $retQRY .= ' AND id_prop NOT IN ('.$row_RS['ids'].')';
    }







    $propQuery = "

    SELECT

        substring_index(group_concat(properties_properties.id_prop), ',', 6) as ids

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

        $tableTags

        $tableFeatures

    WHERE  activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND reservado_prop = 0 AND vendido_tag_prop = 0 AND properties_images.procesada_img = 1
        AND (SELECT count(*)
                FROM properties_log_mails
                WHERE
                    properties_log_mails.email_log = '".$row_rsBusquedas['email_usr']."' AND
                    properties_log_mails.prop_id_log = properties_properties.id_prop AND
                    properties_log_mails.type_log = 2
                ) <= 0
           $st
           $prds $prhs
           $pricerange
           $typ
           $lopr
           $loct
           $lozn
           $bd
           $rf
           $po
           $tags
           $retQRY


    ORDER BY updated_prop DESC

    ";

    // echo $propQuery . '<hr>';

    $properties = getRecords($propQuery);

    // echo $properties[0]["ids"] . '<hr>';

    $ids = explode(",", $properties[0]["ids"]);
    if (!$ids[0]) {
        continue;
    }

    $show_rate = 1;

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
                        $body .= $subject = $langStr["Hola"] . ' ' . $row_rsBusquedas['nombre_usr'] . ', ' . $langStr['Properties of your search saved on'] . ' ' . date("d-m-Y", strtotime($row_rsBusquedas['created'])) . ' - '. $_SERVER['HTTP_HOST'];
                    $body .= '</h1>';
                    $body .= '<div style="color: #555; font-size: 16px;">';
                        $body .= '<p>' . $langStr["Hola"] . ' ' . $row_rsBusquedas['nombre_usr'] . ', ' . $langStr['Properties of your search saved on'] . ' ' . date("d-m-Y", strtotime($row_rsBusquedas['created'])) . '.</p>';
                    $body .= '</div>';
                $body .= '</div>';
            $body .= '</td>';
        $body .= '</tr>';

        // $body  .= "<h4 style=\"font-weight: 200; padding: 10px; background: ".$mailColor."; text-align: center; text-transform: uppercase;color: #fff\">".$langStr["Propiedades"]."</h4>";

        foreach ($ids as $id) {
            set_time_limit(0);
            $langVal = $query->langx;
            if ($langVal == '') {
                $langVal = 'en';
            }
            $idVal = $id;
            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate.php');
            $body .= ob_get_contents();
            ob_end_clean();

            $query_rsInsert2 = " INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` )
            VALUES ( NULL ,  '".$id."',  '".getIp()."',  '".date("Y-m-d H:i:s")."', '0', '".$row_rsBusquedas['id_usr']."' ) ";
            mysqli_query($inmoconn,$query_rsInsert2);
        }

        foreach ($ids as $id) {
            $query_rsInsert3 = " INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`)
            VALUES ( NULL, '0',  '".$id."',  '".mysqli_real_escape_string($inmoconn,$row_rsBusquedas['email_usr'])."',  '2', '', '".date("Y-m-d H:i:s")."' ) ";
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
        $html = preg_replace('/{CONTENT}/', $body, $html);
        $html = preg_replace('/{FOOTER}/', $textMailTempl, $html);
        $html = preg_replace('/{FOOTCONT}/', '', $html);
        $html = preg_replace('/{COLOR}/', $mailColor, $html);
        $html = preg_replace('/{IMAGEHEADER}/', '<img src="https://casalasdunas.co.uk/media/images/newsletter/banner_13.jpg"  alt="'.$_SERVER["HTTP_HOST"].'" id="headerImage campaign-icon" style="width: 100%;" />', $html);

        $subject = $langStr["Hola"] . ' ' . $row_rsBusquedas['nombre_usr'] . ', ' . $langStr['Properties of your search saved on'] . ' ' . date("d-m-Y", strtotime($row_rsBusquedas['created'])) . ' - '. $_SERVER['HTTP_HOST'];



        // echo $xxx++ . "<br>";
        // echo $row_rsBusquedas['email_usr']++ . "<hr>";
        // echo $html;
        // die();
        // echo "<hr>";
        // echo "<hr>";
        // echo "<hr>";
        // echo "<hr>";
        // echo "<hr>";
        // echo "<hr>";


    // $smtpUrl = $smtpUrlAlt;
    // $smtpPort = $smtpPortAlt;
    // $smtpUser = $smtpUserAlt;
    // $smtpPass = $smtpPassAlt;
    // $fromMail = $fromMailAlt;





        sendAppEmailSearchs(array($row_rsBusquedas['email_usr'] => $row_rsBusquedas['nombre_usr']), '', '', $fromMailAlt, $subject, $html);
        // sendAppEmail(array($row_rsBusquedas['email_usr'] => $row_rsBusquedas['nombre_usr']), '', '', $fromMail, $subject, $html);





    // echo count($properties) . "<hr>";

    // echo "<pre>";
    // echo $propQuery;
    // echo "</pre><hr>";

} while ($row_rsBusquedas = mysqli_fetch_assoc($rsBusquedas));
