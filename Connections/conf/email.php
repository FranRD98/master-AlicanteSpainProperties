<?php

/*--------------------------------------------------------------------------
/* @group Email de envio por defecto */
/*--------------------------------------------------------------------------
|
| El email por defecto desde donde se envían los emails de la aplicación
| Se pueden ver los correos en http://mediaelx.net/roundcube/
| Usuario: testemail@mediaelx.net
| Contraseña: yz6N4pxf@
|
*/

if ($_SERVER["HTTP_HOST"] == 'demo.mediaelx.info') {
    // SOLO PARA DEMO NO TOCAR
    $smtpUrl ="mail.mediaelx.net";
    $smtpPort ="25";
    $smtpUser ="testemail@mediaelx.net";
    $smtpPass ="vkNWXPQBec";
    $fromMail ="testemail@mediaelx.net";
    $fromName = "Nombre empresa";
} else {
    // ESTE ES DONDE HAY QUE PONERLO
    $smtpUrl ="servidor.media-webs4.com";
    $smtpPort ="465";
    $smtpUser ="testemail@mediaelx.net";
    $smtpPass ="vkNWXPQBec";
    $fromMail ="testemail@mediaelx.net";
    $fromName = "Nombre empresa";
}

/*--------------------------------------------------------------------------
/* @group Email de envio masivo */
/*--------------------------------------------------------------------------
|
| Esta es la configuración del SMTP para enviar correos masivamente
|
*/

    $activarMailWeekly = 0;
    $smtpUrlAlt = "smtp.acumbamail.com";
    $smtpPortAlt = "465";
    $smtpUserAlt = "";
    $smtpPassAlt = "";
    $fromMailAlt = "";
    $fromNameAlt = "Nombre empresa";

/*--------------------------------------------------------------------------
/* @group Acumbamail API key */
/*--------------------------------------------------------------------------
|
| API key de Acumbamail (hay que registrarse en Acumbamail para obtenerla e ir a https://acumbamail.com/apidoc/)
| Solo añadir si el envío se hace con Acumbamail o se usa el en envío automático con acumbamail
|
*/

$keyAcumbamailSMTP = '';

/*
|--------------------------------------------------------------------------
| Email de bienvenida
|--------------------------------------------------------------------------
|
| Aparecerá un botón en la ficha del cliente para poder enviar un correo de bienvenida a los clientes que den de alta
|
*/

$activarWelcomeMail = 0;

/*
|--------------------------------------------------------------------------
| Mail main color
|--------------------------------------------------------------------------
|
| El color principal del template de email
|
*/

$mailColor = "#29bdef";

/*
|--------------------------------------------------------------------------
| Mail secondary color
|--------------------------------------------------------------------------
|
| El color secundario del template de email
|
*/

$mailSecondaryColor = "#000";

/*--------------------------------------------------------------------------
/* @group Texto pie template email */
/*--------------------------------------------------------------------------
|
| El texto del pie del template de email
|
*/

$textMailTempl ="Copyright @ ".date("Y") . "";

/*--------------------------------------------------------------------------
/* @group Email de envio asistencia */
/*--------------------------------------------------------------------------
|
| El email donde se envían los emails de la asistencia, tiene que ser tu email.
|
*/

$asistenciaMail ="clientes@mediaelx.net";

/*--------------------------------------------------------------------------
/* @group Consultas de portales */
/*--------------------------------------------------------------------------
|
| Activar la consultas de portales
| 0 - Desactivado
| 1 - Activado
|
*/

$actPortalsEnquiries = 0;

/*--------------------------------------------------------------------------
/* @group Id portales de la sección origenes de clientes:
/intramedianet/properties/clients-sources.php */
/*--------------------------------------------------------------------------
|
| Añadir las IDs de los portales que use el cliente
|
*/

$idPortalTodopisosalicante = '';
$idPortalVivados = '';
$idPortalMoveagain = '';
$idPortalVentadepisos = '';
$idPortalGranmanzana = '';
$idPortalKyero = '';
$idPortalRightmove = '';
$idPortalThinkSpain = '';
$idPortalgreenAcres = '';
$idPortalIdealista = '';
$idCostaDelHome = '';
$idZoopla = '';
$idYaencontre = '';
$idHabitaclia = '';
$idTrovimap = '';
$idIndomio = '';
$idTucasa = '';
$idPisoscom = '';
$idAPITS = '';

/*--------------------------------------------------------------------------
/* @group Datos email recepción de portales */
/*--------------------------------------------------------------------------
|
| El email donde se reciben los emails de los portales
|
*/

$mailboxPortales = ''; // server.mediawebs14.com
$usernamePortales = '';
$passwordPortales = '';
