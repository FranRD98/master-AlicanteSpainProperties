<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

$transport = Swift_SmtpTransport::newInstance($mailboxPortales, '587')
    ->setUsername($usernamePortales)
    ->setPassword($passwordPortales)
;

$mailer = Swift_Mailer::newInstance($transport);

$message = Swift_Message::newInstance()
    ->setSubject($_POST['subject'])
    ->setFrom('info@promediahomes.com')
    // ->setReplyTo($_POST['from'])
    ->setTo($_POST['to'])
    ->setBody($_POST['message'], 'text/html')
;

if ($mailer->send($message)) {
    echo "ok";
}



?>