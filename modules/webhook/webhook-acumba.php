<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

$json = json_decode(file_get_contents("php://input"), true);

foreach ($json as $mail_update) {
    if ($mail_update['email_key'] != '') {
        $query_rsInsert3 = "
        UPDATE  `properties_log_mails` SET
            result_log = '" . $mail_update['event'] . "'
        WHERE
            key_log = '" . $mail_update['email_key'] . "'
    ";
        mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
    }
}