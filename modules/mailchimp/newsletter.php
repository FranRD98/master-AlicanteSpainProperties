<?php

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mailchimp/MailChimp.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/paginator/paginator.class.php' );

$MailChimp = new MailChimp($keyMailchimp);
$result = $MailChimp->post('lists/' . $mailchimpIdListaPrincipal .'/members/', array(
      'email_address' => $_GET['email'],
      'status'        => 'subscribed',
  ));
$MailChimp = new MailChimp($keyMailchimp);
$result = $MailChimp->post('lists/' . $mailchimpIdListaPrincipal .'/segments/' . $mailchimpIdListaWebsite .'/members/', array(
      'email_address' => $_GET['email']
  ));
$MailChimp = new MailChimp($keyMailchimp);
$result = $MailChimp->post('lists/' . $mailchimpIdListaPrincipal .'/segments/' . $mailchimpIdListaIdiomas[$_GET['lang']] .'/members/', array(
      'email_address' => $_GET['email']
  ));

echo "ok";

 ?>