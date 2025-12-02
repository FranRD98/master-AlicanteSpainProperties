<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');


$query_rsEmails = "SELECT * FROM acumbamail WHERE datetime_acum <= NOW()";
$rsEmails = mysqli_query($inmoconn,$query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);

if ($totalRows_rsEmails > 0) {
    do {
        $acumba = new AcumbamailAPI($keyAcumbamail);
        $acumba->createCampaign($row_rsEmails['subject_acum'], $row_rsEmails['company_acum'], $row_rsEmails['frommail_acum'], $row_rsEmails['subject_acum'], $row_rsEmails['html_acum'], explode(',', $row_rsEmails['lista_acum']));
        $query_rsDelete = "DELETE FROM `acumbamail` WHERE `id_acum` = '".$row_rsEmails['id_acum']."' LIMIT 1";
        $rsDelete = mysqli_query($inmoconn,$query_rsDelete) or die(mysqli_error());
    } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails));
}

die();
