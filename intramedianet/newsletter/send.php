<?php


// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

// Cargamos los idiomas de la administración
// require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

session_start();

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template.html');
$html = ob_get_contents();
ob_end_clean();

$body  = "<h1 style=\"font-weight: 200; padding: 10px; background: ".$mailColor."; text-align: center; text-transform: uppercase;color: #fff; font-size: 22px;\">" . $_GET['subject'] . "</h1>";

$body .= $_GET['message'];

if (!empty($_GET['props'])) {

    $body  .= "<h4 style=\"font-weight: 200; padding: 10px; background: ".$mailColor."; text-align: center; text-transform: uppercase;color: #fff\">".$langStr["Propiedades"]."</h4>";

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

    $body  .= "<h4 style=\"font-weight: 200; padding: 10px; background: ".$mailColor."; text-align: center; text-transform: uppercase;color: #fff\">".$langStr["Noticias"]."</h4>";

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

$query_rsUsers = "

SELECT  email_usr
FROM newsletter_users
 WHERE  lang_usr = '".$_GET['langs']."'  AND id_usr IN(
SELECT usr
FROM newsletter_usr_cat
WHERE cat
IN (".implode(',', $_GET['cats']).")

)

GROUP BY email_usr
";


$rsUsers = mysqli_query($inmoconn, $query_rsUsers ) or die(mysqli_error());
$row_rsUsers = mysqli_fetch_assoc($rsUsers);
$totalRows_rsUsers = mysqli_num_rows($rsUsers);

do {

if($row_rsUsers['email_usr'] != '') {

	$query_rsInsert = "

	INSERT INTO `mail_queue` (`id`, `fromm`, `tom`, `subject`, `message`, `files`, `date`) VALUES ('0', '".$fromMail."', '".$row_rsUsers['email_usr']."',  '".utf8_decode(mysqli_real_escape_string($inmoconn,$_GET['subject']))."', '".mysqli_real_escape_string($inmoconn, $html)."', '', CURRENT_TIMESTAMP);

	";
	$rsInsert = mysqli_query($inmoconn, $query_rsInsert) or die(mysqli_error());

	if (!empty($_GET['props'])) {


		foreach ($_GET['props'] as $value) {

			$idprop = $value;

			$query_rsInsert3 = "
			    INSERT INTO  `properties_log_mails` ( `id_log` , `prop_id_log`, `email_log`, `type_log`, `date_log`) VALUES
			    ( NULL ,  '".$value."',  '".$row_rsUsers['email_usr']."',  '5', '".date("Y-m-d H:i:s")."' )
			";
			mysqli_query($inmoconn ,$query_rsInsert3) or die(mysqli_error());

		}

	}


}

} while ($row_rsUsers = mysqli_fetch_assoc($rsUsers));

echo 'ok';


// echo "<pre>";
// print_r($_GET);
// echo "</pre>";









?>