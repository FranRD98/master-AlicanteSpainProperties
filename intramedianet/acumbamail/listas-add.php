<?php
// Cargamos la conexión a MySql
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// Cargamos los idiomas de la administración
require_once($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');

// Load the common classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

// Load the tNG classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

$acumba = new AcumbamailAPI($keyAcumbamail);
$result = $acumba->createList($fromMail, $_POST['name'], $Acumbamail_dc_company, $Acumbamail_dc_country, $Acumbamail_dc_city, $Acumbamail_dc_address1, $Acumbamail_dc_phone);

$acumba->addMergeTag($result['list_id'], "nombre", "text");

header("Location: " . $_SERVER['HTTP_REFERER']);

?>
