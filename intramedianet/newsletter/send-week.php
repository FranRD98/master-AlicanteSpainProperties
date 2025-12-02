<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );


$language = 'en';

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

$query_rsDelMails = "TRUNCATE mail_queue";
$rsDelMails = mysqli_query($inmoconn, $query_rsDelMails) or die(mysqli_error());

$query_rsClients = "SELECT * FROM properties_client ORDER BY id_cli";
$rsClients = mysqli_query($inmoconn,$query_rsClients) or die(mysqli_error());
$row_rsClients = mysqli_fetch_assoc($rsClients);
$totalRows_rsClients = mysqli_num_rows($rsClients);

$i = 1;




        $sQuery = "
          SELECT
            properties_properties.id_prop
          FROM properties_properties
            INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
            INNER JOIN properties_types ON properties_properties.tipo_prop = properties_types.id_typ
            INNER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
            INNER JOIN properties_loc3 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3
            INNER JOIN properties_loc2 ON properties_loc3.loc2_loc3 = properties_loc2.id_loc2
            INNER JOIN properties_loc1 ON properties_loc2.loc1_loc2 = properties_loc1.id_loc1

          WHERE activado_prop = 1 AND nuevo_prop >= DATE(NOW()) AND vendido_prop = 0 AND alquilado_prop = 0

          ORDER BY id_prop DESC

          LIMIT 30
        ";

        $query_rsProperties = $sQuery;
        $rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
        $row_rsProperties = mysqli_fetch_assoc($rsProperties);
        $totalRows_rsProperties = mysqli_num_rows($rsProperties);


        if($totalRows_rsProperties > 0) {

            $theIDs = array();

            do {

                array_push($theIDs, $row_rsProperties['id_prop']);

            } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));

            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template.html');
            $html = ob_get_contents();
            ob_end_clean();

            $asunto = 'Latest Property Listings from Casas Espania | ' . date("m-d-Y");
            $mensaje = '<p>Dear *|MERGE1|* </p><p>Welcome to our weekly property update.</p><p>Please find below some of our newly listed properties, along with those that have been reduced in price.</p><p>Please do not hesitate to contact our team at Casas Espania for further information, or to arrange a viewing.</p><p>Don´t forget you can keep updated with us on Facebook, Twitter and Youtube</p><p>We look forward to seeing you soon!</p>';

            $body  = "<h1 style=\"font-weight: 200; padding: 0px; color: #ef7a13; font-size: 26px;\">" . $asunto . "</h1>";

            $body .= $mensaje;

         $body  .= "<h1 style=\"font-weight: 200; padding: 0px; color: #ef7a13; font-size: 26px;\">Properties</h1>";
        $casas = 0;

            foreach ($theIDs as $value) {

                $idprop = $value;
                $_GET['lang'] = $language;

                // $body .= "<table width='185' height='260' align='left' class='tabla ecxtabla' style='float:left; height:260px; overflow:hidden; width:185;'><tr><td></td>";



                ob_start();
                include($_SERVER["DOCUMENT_ROOT"] . '/modules/favorites/send-property-3lineas.php');
                $body .= ob_get_contents();
                ob_end_clean();
                // $body .= "</tr></table><td></td>";

                $casas++;
                // if ($casas==3 or $casas==6 or $casas==9 or $casas==12 or $casas==15 or $casas==18 or $casas==21 or $casas==24 or $casas==27 or $casas==30){  $body  .="<table  style='width:100%; clear:both;' height='5'><tr><td></td></tr></table>"; }

            }



            $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);

            $html = preg_replace('/{CONTENT}/', $body , $html);

            $html = preg_replace('/{FOOTER}/', $textMailTempl, $html);

            // $MailChimp = new MailChimp($keyMailchimp);
            // $listas = $MailChimp->get('lists/c543c6dfe4');

            // $MailChimp = new MailChimp($keyMailchimp);
            // $campaign = $MailChimp->post('/campaigns', array(
            //     'type' => 'regular',
            //     'recipients'    => array(
            //                         'list_id'=>'c543c6dfe4'
            //                     ),
            //     'settings'     => array(
            //                         'subject_line'=> 'Latest Property Listings from Casas Espania:' . date("d-m-Y H:i"),
            //                         'from_name'=>$listas['campaign_defaults']['from_name'],
            //                         'reply_to'=>$listas['campaign_defaults']['from_email'],
            //                     )
            // ));

            // $MailChimp = new MailChimp($keyMailchimp);
            // $content = $MailChimp->put('/campaigns/' . $campaign['id'] . '/content' , array(
            //     'html' => $html
            // ));

            // if ($campaign['id'] != '') {
            //     $sendCampaign = $MailChimp->post('/campaigns/' . $campaign['id'] . '/actions/send');
            // }







            // echo "<pre>";
            // print_r($result);
            // echo "</pre>";

        //     if ($result['id'] != '') {

        //             $sendCampaign = $MailChimp->call('/campaigns/send', array(

        //                     'cid' => $result['id'],
        //                     'test_emails' => array(
        //                         'media@casasespania.com'
        //                     )

        //                 ));

        //         }



        }









?>