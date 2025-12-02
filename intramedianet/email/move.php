<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/ImapClientException.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/ImapConnect.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/ImapClient.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/IncomingMessage.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/IncomingMessageAttachment.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/TypeAttachments.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/TypeBody.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/Section.php";
require_once  $_SERVER["DOCUMENT_ROOT"] . "/includes/ImapClient/SubtypeBody.php";

use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;

$encryptionPortales = Imap::ENCRYPT_SSL;

try{
    $imap = new Imap($mailboxPortales, $usernamePortales, $passwordPortales, $encryptionPortales);

}catch (ImapClientException $error){
    echo $error->getMessage().PHP_EOL;
    die();
}

if ($_GET['b'] == '') {
    $_GET['b'] = 'INBOX';
}

($imap->selectFolder($_GET['b']));
$imap->getMessages();

if ($_GET['f'] == 'INBOX' || $_GET['f'] == '') {
    $imap->moveMessage($_GET['id'], $_GET['f']);
} else {
    $imap->moveMessage($_GET['id'], 'INBOX.' . $_GET['f']);
}



?>
