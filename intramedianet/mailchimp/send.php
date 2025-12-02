<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );

session_start();

function _d($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template2.html');
$html = ob_get_contents();
ob_end_clean();

$body  = "<h1 style=\"font-weight: 200; padding: 30px 10px 30px 0; color: ".$mailColor."; font-size: 22px;\">" . $_GET['subject'] . "</h1>";

$body .= $_GET['message'];

if (!empty($_GET['props'])) {

    $body  .= "<h4 style=\"font-weight: 200; padding: 30px 10px 20px 0; color: ".$mailColor."; font-size: 22px;\">".$langStr["Propiedades"]."</h4>";

	foreach ($_GET['props'] as $value) {

        $langVal = $_GET['lang'];
        $idVal = $value;

        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property.php');
        $body .= ob_get_contents();
        ob_end_clean();

	}

}

if (!empty($_GET['news'])) {

    $body  .= "<h4 style=\"font-weight: 200; padding: 20px 10px 20px 0; color: ".$mailColor."; font-size: 22px;\">".$langStr["Noticias"]."</h4>";

	foreach ($_GET['news'] as $value) {

        $langVal = $_GET['lang'];
        $idVal = $value;

		ob_start();
		include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/news.php');
		$body .= ob_get_contents();
		ob_end_clean();

	}

}

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);

$html = preg_replace('/{CONTENT}/', $body , $html);

$html = preg_replace('/{FOOTER}/', $textMailTempl, $html);

$html = preg_replace('/{COLOR}/', $mailColor, $html);

$MailChimp = new MailChimp($keyMailchimp);
$listas = $MailChimp->get('lists/' . $mailchimpIdListaPrincipal);

$MailChimp = new MailChimp($keyMailchimp);
$campaign = $MailChimp->post('/campaigns', array(
	'type' => 'regular',
    'recipients'    => array(
                        'list_id'=> $mailchimpIdListaPrincipal,
                        'segment_opts' => array(
                            'match' => 'all',
                            'conditions' => array(
                                array(
                                    'condition_type' => 'StaticSegment',
                                    'op' => 'static_is',
                                    'field' => 'static_segment',
                                    'value' => $_GET['lista']
                                ),
                                array(
                                    'condition_type' => 'StaticSegment',
                                    'op' => 'static_is',
                                    'field' => 'static_segment',
                                    'value' => $mailchimpIdListaIdiomas[$_GET['lang']]
                                )
                            )
                        ),
                    ),
    'settings'     => array(
                        'subject_line'=>$_GET['subject'],
                        'from_name'=>$listas['campaign_defaults']['from_name'],
                        'reply_to'=>$listas['campaign_defaults']['from_email'],
                        // 'title' => 'Newsletter:' . date("d-m-Y H:i"),
                    )
));

$MailChimp = new MailChimp($keyMailchimp);
$content = $MailChimp->put('/campaigns/' . $campaign['id'] . '/content' , array(
    'html' => $html
));



if ($campaign['id'] != '') {

	if ($_GET['test'] == '1') {

		$MailChimp = new MailChimp($keyMailchimp);
        $sendCampaign = $MailChimp->post('/campaigns/' . $campaign['id'] . '/actions/test', array(
				'send_type' => 'html',
				'test_emails' => array(
					$_GET['testmail']
				)
        ));

        $MailChimp = new MailChimp($keyMailchimp);
        $result = $MailChimp->delete('/campaigns/' . $campaign['id']);

	} else {
        if ($_GET['schedule'] == '1') {
            // Para poder programar el envío desde Mailchimp necesitamos enviar la fecha en formato UTC.

            $schedule_time = gmdate('Y-m-d H:i:s', strtotime($_GET['schedule_ct']));

            $sendCampaign = $MailChimp->post('/campaigns/' . $campaign['id'] . '/actions/schedule',array(
                    'schedule_time' => $schedule_time,
                    'timewarp'      => false,
                    'batch_delivery'=> false
            ));

            // _d($sendCampaign);
        } else {
            $sendCampaign = $MailChimp->post('/campaigns/' . $campaign['id'] . '/actions/send');
            // _d($sendCampaign);
        }

	}

}

echo 'ok';

?>