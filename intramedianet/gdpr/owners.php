<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );


require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
use Spipu\Html2Pdf\Html2Pdf; 


savelogprop($_GET['id'], '7');

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/gdpr/gdpr.html');
$html = ob_get_contents();
ob_end_clean();

$user = getRecords("
SELECT
    nombre_pro,
    apellidos_pro,
    nie_pro,
    id_pro
FROM properties_owner
WHERE  id_pro = '".simpleSanitize(($_GET['id']))."'
");

$html = preg_replace('/{EMPRESA}/', $empresa_GDPR, $html);
$html = preg_replace('/{CIF}/', $cif_GDPR, $html);
$html = preg_replace('/{DIRECCION}/', $direccion_GDPR, $html);
$html = preg_replace('/{TELEFONO}/', $telefono_GDPR, $html);
$html = preg_replace('/{EMAIL}/', $email_GDPR, $html);
$html = preg_replace('/{CIUDAD}/', $ciudad_GDPR, $html);
$html = preg_replace('/{FECHA}/', date("d-m-Y"), $html);
$html = preg_replace('/{NOMBRE}/', $user[0]['nombre_pro'] . ' ' . $user[0]['apellidos_pro'], $html);
$html = preg_replace('/{NIF}/', $user[0]['nie_pro'], $html);

/* @group PDF */
try
{
    $html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', 0);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->setDefaultFont("dejavusans");
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('gdpr-' . clean($user[0]['nie_pro']) . '.pdf', 'I');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}





