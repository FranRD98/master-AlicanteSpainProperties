<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php';

$antiSpam = "f" . date("jmy");


// Verificar si el parámetro antiSpam está presente y es vacío
if (isset($_GET[$antiSpam]) && $_GET[$antiSpam] === '') {

    // Validar y sanitizar entradas
    $name = sanitizeInput($_GET['name'] ?? '');
    $surname = sanitizeInput($_GET['surname'] ?? '');
    $email = sanitizeAndValidateEmail($_GET['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $telefono = sanitizeInput($_GET['telefono'] ?? '');
    $Type = sanitizeInput($_GET['Type'] ?? '');
    $locun2 = sanitizeInput($_GET['locun2'] ?? '');
    $lopr2 = sanitizeInput($_GET['lopr2'] ?? '');
    $loct2 = sanitizeInput($_GET['loct2'] ?? '');
    $address = sanitizeInput($_GET['address'] ?? '');
    $zip = sanitizeInput($_GET['zip'] ?? '');
    $bd = sanitizeInput($_GET['bd'] ?? '');
    $bt = sanitizeInput($_GET['bt'] ?? '');
    $pool = sanitizeInput($_GET['pool'] ?? '');
    $m2 = sanitizeInput($_GET['m2'] ?? '');
    $m2p = sanitizeInput($_GET['m2p'] ?? '');
    $price = sanitizeInput($_GET['price'] ?? '');
    $description = sanitizeInput($_GET['description'] ?? '');
    $imagesfld = sanitizeInput($_GET['imagesfld'] ?? '');

    // Asegurarse de que la dirección de correo es válida
    if (!$email) {
        echo "Invalid email address.";
        exit;
    }

    // Construcción del mensaje HTML
    $mensaHTML = "<p>Date: " . date("d-m-Y H:i") . "</p>";
    $mensaHTML .= "<p>Name: $name $surname</p>";
    $mensaHTML .= "<p>Email: $email</p>";
    $mensaHTML .= "<p>Telephone: $telefono</p>";
    $mensaHTML .= "<p>Type: $Type</p>";
    $mensaHTML .= "<p>Country: $locun2</p>";
    $mensaHTML .= "<p>Province: $lopr2</p>";
    $mensaHTML .= "<p>Town: $loct2</p>";
    $mensaHTML .= "<p>Address: $address</p>";
    $mensaHTML .= "<p>Zip: $zip</p>";
    $mensaHTML .= "<p>Bedrooms: $bd</p>";
    $mensaHTML .= "<p>Bathrooms: $bt</p>";
    $mensaHTML .= "<p>Pool: $pool</p>";
    $mensaHTML .= "<p>M<sup>2</sup>: $m2</p>";
    $mensaHTML .= "<p>M<sup>2</sup>: $m2p</p>";
    $mensaHTML .= "<p>Price: $price</p>";
    if ($_GET['rp'] == 1) {
        $mensaHTML .= "<p><b>Price reduced</b></p>";
    }
    if ($_GET['cs'] == 1) {
        $mensaHTML .= "<p><b>Close to sea</b></p>";
    }
    if ($_GET['sw'] == 1) {
        $mensaHTML .= "<p><b>Seaviews</b></p>";
    }
    if ($_GET['ep'] == 1) {
        $mensaHTML .= "<p><b>Exclusive property</b></p>";
    }
    if ($_GET['po'] == 1) {
        $mensaHTML .= "<p><b>Pool</b></p>";
    }
    if ($_GET['rps'] == 1) {
        $mensaHTML .= "<p><b>Repossession</b></p>";
    }
    $mensaHTML .= "<p>Description:<br>" . nl2br($description) . "</p>";

    // Manejo de imágenes
    $imgs = explode('@//@', $imagesfld);
    $subject = 'New property list request';
    $message = new Swift_Message($subject);
    $message->setFrom([$fromMail => 'Your Site Name']);
    $message->setTo([$email => $name]);

    foreach ($imgs as $value) {
        if ($value) {
            $thumbnail = showThumbnail($value, $value, '/media/images/list-properties/', 800, 600);
            if (preg_match('/src="([^"]*)"/i', $thumbnail, $matches)) {
                $img = str_replace('"', '', $matches[1]);
                if (file_exists($_SERVER["DOCUMENT_ROOT"].$img)) {
                    $message->attach(Swift_Attachment::fromPath($_SERVER["DOCUMENT_ROOT"].$img));
                }
            }
        }
    }

    if (sendAppEmail($fromMail, '', '', [$email => $name], $subject, $mensaHTML)) {

        echo "ok";

        foreach ($imgs as $value) {
            if ($value) {
                $filePath = $_SERVER["DOCUMENT_ROOT"] . '/media/images/list-properties/' . $value;
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $nameParts = pathinfo($value);
                array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . '/media/images/list-properties/thumbnails/' . $nameParts['filename'] . '*.' . $nameParts['extension']));
            }
        }

        // Consulta preparada para evitar SQL Injection
        $stmt = $inmoconn->prepare("INSERT INTO emails (email) VALUES (?)");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->close();

    } else {
        echo "no";
    }
}
?>
