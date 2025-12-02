<?php

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

switch ($_POST['provider']) {
    case 'todopisosalicante.com':
    case 'todopisospain.com':
        $source = $idPortalTodopisosalicante;
        break;
    case 'vivados.es':
        $source = $idPortalVivados;
        break;
    case 'moveagain.co.uk':
        $source = $idPortalMoveagain;
        break;
    case 'envios.ventadepisos.com':
        $source = $idPortalVentadepisos;
        break;
    case 'granmanzana.es':
        $source = $idPortalGranmanzana;
        break;
    case 'kyero.com':
        $source = $idPortalKyero;
        break;
    case 'rightmove.co.uk':
        $source = $idPortalRightmove;
        break;
    case 'thinkspain.com':
        $source = $idPortalThinkSpain;
        break;
    case 'email.green-acres.com':
        $source = $idPortalgreenAcres;
        break;
    case 'idealista.com':
        $source = $idPortalIdealista;
        break;
    case 'costadelhome.com':
        $source = $idCostaDelHome;
        break;
    case 'zpg.co.uk':
        $source = $idZoopla;
        break;
    case 'yaencontre.com':
        $source = $idYaencontre;
        break;
    case 'envios.habitaclia.com':
        $source = $idHabitaclia;
        break;
    case 'trovimap.com':
        $source = $idTrovimap;
        break;
    case 'indomio.es':
        $source = $idIndomio;
        break;
    case 'tucasa.com':
        $source = $idTucasa;
        break;
    case 'messaging.fotocasa.es':
    case 'fotocasa.es':
        $source = $idFotocasa;
        break;
    case 'listglobally.com':
        $source = $idProperstarConcierge;
        break;
    case 'broker.outbound.trovimap.com':
        $source = $idTrovimap;
        break;
    case 'pisos.com':
        $source = $idPisoscom;
        break;
    case 'aplaceinthesun.com':
        $source = $idAPITS;
        break;
    default:
        $source = 'NULL';
        break;
}

$idm = '';

if ($_POST['idioma'] != '') {
    $idm = ' - Idioma: ' . $_POST['idioma'];
}

if ($_POST['link'] != '') {
    $history = "[ " . date("d-m-Y H:i", strtotime($_POST['date'])) . " ] [ " . $_POST['provider'] . " ] → Inmueble/Property: " . $_POST['referencia'] . " (" . $_POST['link'] . ")\n\n" . $_POST['comentario'] . "" . $idm;
} else {
    $history = "[ " . date("d-m-Y H:i", strtotime($_POST['date'])) . " ] [ " . $_POST['provider'] . " ] → Inmueble/Property: " . $_POST['referencia'] . "\n\n" . $_POST['comentario'] . "" . $idm;
}

$query_rsInsert = "
INSERT INTO `properties_client` SET
    `nombre_cli` = '".mysqli_real_escape_string($inmoconn,$_POST['nombre'])."',
    `telefono_fijo_cli` = '".mysqli_real_escape_string($inmoconn,$_POST['telefono'])."',
    `email_cli` = '".mysqli_real_escape_string($inmoconn,$_POST['email'])."',
    `fecha_alta_cli` = CURRENT_TIMESTAMP,
    `como_nos_conocio_cli` = '".mysqli_real_escape_string($inmoconn,$source)."',
    `historial_cli` = '".mysqli_real_escape_string($inmoconn,$history)."'
";
$rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

$id = mysqli_insert_id($inmoconn);

header("Location: /intramedianet/properties/clients-form.php?id_cli=" . $id);
?>
