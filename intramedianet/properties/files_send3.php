<?php

$_GET['lang'] = 'en';

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

session_start();

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template.html');
$html = ob_get_contents();
ob_end_clean();

$body  = '';
// $body .= '<p>I send you properties that cant interest you:</p>';
// $body .= '<p>'.nl2br($_GET['comment']).'</p>';

$ids = explode(',', $_GET['ids']);

$query_rsCliente = "SELECT * FROM properties_properties WHERE `id_prop` = '".$_GET['id_prop']."'";
$rsCliente = mysqli_query($inmoconn,$query_rsCliente) or die(mysqli_error());
$row_rsCliente = mysqli_fetch_assoc($rsCliente);

// $body  .= "<h4 style=\"font-weight: 200; padding: 10px; background: #39AC9E; text-transform: uppercase;color: #fff\">Archvos de cliente</h4>";
$body  .= "<p><b>Propiedad/Property:</b> " . $row_rsCliente['referencia_prop'] . "</p>";

for ($i=0; $i < count($ids); $i++) {

    $_GET['id'] =  $ids[$i];

    $query_rsFiles = "SELECT * FROM properties_datos_files WHERE id_fil = " . $ids[$i];
    $rsFiles = mysqli_query($inmoconn, $query_rsFiles) or die(mysqli_error());
    $row_rsFiles = mysqli_fetch_assoc($rsFiles);
    $totalRows_rsFiles = mysqli_num_rows($rsFiles);
    do {
        $body  .= '<hr><a href="https://' . $_SERVER['HTTP_HOST'] . '/media/files/data/' . $row_rsFiles['file_fil'] . '" target="_blank" style="display: inline-block; padding: 5px 10px 3px 10px; background: #319F8D; text-decoration: none; color: #fff; text-transform: uppercase; border-radius: 4px; font-size: 12px;">Descargar: ' . $row_rsFiles['file_fil'] . '</a>';
    } while ($row_rsFiles = mysqli_fetch_assoc($rsFiles));

}


    $body  .= "<hr>";

// $body  .= "<h4 style=\"font-weight: 200; padding: 10px; background: #39AC9E; text-transform: uppercase;color: #fff\">" . $langStr['Propiedades recomendadas'] . "</h4>";

// ob_start();
// include($_SERVER["DOCUMENT_ROOT"] . '/modules/favorites/recommended-props.php');
// $body .= ob_get_contents();
// ob_end_clean();


if(isset($_GET['usrid']) && $_GET['usrid'] != 0){
    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/users/send-user.php');
    $body .= ob_get_contents();
    ob_end_clean();
    if(isset($user[0]["email_usr"]) && $user[0]["email_usr"] != ""){
        $fromMail = $user[0]["email_usr"];
    }
}


// $body .= '<p>Regards,</p>';

$html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
$html = preg_replace('/{CONTENT}/', $body , $html);
$html = preg_replace('/{FOOTER}/', $textMailTempl, $html);





    $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance()
                  ->setSubject('Files/Archivos - ' . $_SERVER['HTTP_HOST'])
                  ->setFrom(array($fromMail => $_SERVER['HTTP_HOST']))
                  ->setTo(array($_GET['email'] => $_GET['email']))
                  // ->setBody($mensa)
                  ->addPart($html, 'text/html');


    if ($mailer->send($message)) {
        echo "ok";
        mysqli_query($inmoconn, $query_rsInsert2);
    } else {
        echo "no";
    }





 ?>
