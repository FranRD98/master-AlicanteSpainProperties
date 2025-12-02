<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_' . $_GET['lang'] . '.php');

$antiSpam = "f" . date("dmy");

if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] == '') {

	$comment = 'Whtsapp: Chatea con nosotros ahora.';

	$query_rsInsert = "
    INSERT INTO `whatsapp_log` (`id_con`, `lang_con`, `name_con`, `phone_con`, `text_con`, `date_con`) VALUES
    (NULL, '" . simpleSanitize(($_GET['lang'])) . "', '" . simpleSanitize(($_GET['name'])) . "', '" . simpleSanitize(($_GET['telefono'])) . "', '" . simpleSanitize(($comment)) . "', NOW())
    ";
	mysqli_query($inmoconn, $query_rsInsert);

	$mensaHTML = "<p>Date: " . date("d-m-Y H:i") . "</p>";
	$mensaHTML .= "<p>Nombre: " . $_GET['name'] . "</p>";
	$mensaHTML .= "<p>Idioma: " . $_GET['lang'] . "</p>";
	$mensaHTML .= "<p>Teléfono: " . $_GET['telefono'] . "</p>";

	$subject = 'Whtsapp: Chatea con nosotros ahora ' . $_SERVER['HTTP_HOST'];

	if (sendAppEmail($fromMail, '', '', array($_GET['email'] => $_GET['name']), $subject, $mensaHTML)) 
	{

		echo "ok";

	} else {

		echo "no";
	}
}
