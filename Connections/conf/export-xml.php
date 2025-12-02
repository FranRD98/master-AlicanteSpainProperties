<?php

/*--------------------------------------------------------------------------
/* @group Generar xml */
/*--------------------------------------------------------------------------
|
| Activar la generacion de xml en la aplicación
| 0 - Desactivado
| 1 - Activado
|
*/

$xmlExport = 1;

/*--------------------------------------------------------------------------
/* @group Activar portales */
/*--------------------------------------------------------------------------
|
| Activar los inmuebles de la aplicación
|
*/

$expKyero = 1;
$expIdealista = 0;
$expRightmove = 0;
$expZoopla = 0;
$expThinkSpain = 0;
$expHemnet = 0; // NO USAR -> HAN ELIMINADO LA PASARELA
$expUbiflow = 0;
$expGreenAcres = 0;
$expPrian = 0;
$expHabitaclia = 0;
$expPisos = 0;
$expFacilisimo = 0;
$expFotoCasa = 0;
$expTodoPisoAlicante = 0;
$expYaencontre = 0;
$expMimove = 0;
$expAPITS = 0;
$expCostadelHome = 0;
$expSpainHouses = 0;
$expInmoco = 0;
$expMediaelx = 0;
$expFacebook = 0;
$expMLSMediaelx = 0;

If($actLestinmo == 1) {
    $expKyero = 1;
    $expThinkSpain = 1;
    $expMLSMediaelx = 1;
}

/*--------------------------------------------------------------------------
/* @group MLS Mediaelx */
/*--------------------------------------------------------------------------
|
| Id del proveedor del xml de la MLS de Mediaelx para estadísticas
|
*/

$expMLSMediaelxID = 0;

/*--------------------------------------------------------------------------
/* @group Datos portales */
/*--------------------------------------------------------------------------
|
| Los datos necesarios para cada portal en caso de activarse
|
*/

/* @group Datos: Rightmove */
$rightmoveBranchId = '';
$rightmoveNetworkId = '13568';
$rightmove_cert = $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/certs/mediaelxlive.pem';
$rightmove_cert_password = 'zKAEmALZc7';

/* @group Datos: Zoopla */
$zooplaAgentRef = '0000000';
$zooplaBranchId = '000000000';
$zooplaLimit = '200';
$zooplaFTP = 'ftp.zoopla.com';
$zooplaFTPuser = 'mediaelx_int';
$zooplaFTPpass = 'y2KQpZtcHyAN';
$zooplaNewBuildId = '2';

/* @group Datos: Ubiflow */
$ubiflowFTP = 'ftp.zoopla.com';
$ubiflowFTPuser = '000000000';
$ubiflowFTPpass = '000000000';
$ubiflowAddressStreet = '';
$ubiflowAddressCP = '';
$ubiflowAddressVille = '';
$ubiflowAddressCountry = '';
$ubiflowContactName = '';
$ubiflowContactEmail = '';
$ubiflowContactPhone = '';
$ubiflowContactMobilePhone = '';
$ubiflowMostrarDireccion = "false";

/* @group Datos: Pisos.com */
// Hay que ajustar las features de la base de datos
$pisosIdInmobiliariaExterna = '000000000';
$pisosNombreAgencia = '000000000';
$pisosDireccionAgencia = '000000000';
$pisosPoblacionAgencia = '000000000';
$pisosTelefonoAgencia = '000000000';
$pisosFaxAgencia = '000000000';
$pisosEmailAgencia = '000000000';
$pisosWebAgencia = '000000000';
$pisosLimit = '200';

/* @group Datos: Facilisimo */
// Hay que ajustar las features de la base de datos
$facilisimoIdAgencia = '00000000';
$facilisimoIdTipoLocales = array('99999999');

/* @group Datos: Idealista */
$idealistaFTP = 'ftp1.idealista.com';
$idealistaFTPuser = 'tijuanaroad';
$idealistaFTPpass = 'EtDeetAbba';
$idealistaCustomerCountry = 'Spain'; // Requerido
$idealistaCustomerCode = ''; // Requerido (Código ILC proporcionado por el cliente)
$idealistaCustomerReference = '2dbc4d0862404c2b1820f38c26910a028632dd56'; // Requerido (no tocar)
$idealistaContactEmail = ''; // Requerido
$idealistaContactName = ''; // Requerido
$idealistaContactPrimaryPhonePrefix = '34'; // Requerido
$idealistaContactPrimaryPhoneNumber = ''; // Requerido
$idealistaContactSecondaryPhonePrefix = ''; // Opcional
$idealistaContactSecondaryPhoneNumber = ''; // Opcional
$idealistaFILEname = $idealistaCustomerCode;


/* @group Datos: FOTOCASA */
// Fotocasa
// url de fotocasa del cliente: https://www.fotocasa.es/inmobiliarias/victoria-inmobiliaria-9202759852113
$fotocasaDatos = array(
    "api_key" => '', // Contraseña de autenticación de la API de fotocasa
    "agency_id" => '', // ID de la agencia
    "agent_id" => '', // ID del agente o usuario

    // Datos de contacto en FotoCasa
    "contact_info" => array(
        "Email" => "###", // ID: 1
        "Teléfono" => "###", // ID: 2
        "Móvil" => "", // ID: 3
        "Fax" => "", // ID: 4
        "Web" => "###", // ID: 5
        "Skype" => "", // ID: 12
        "Facebook" => "", // ID: 13
        "Twitter" => "", // ID: 14
        "Otros" => "", // ID: 17
    ),
    "contact_type" => 1, // VALORES POSIBLES: 1 => Agencia | 2 => Agente | 3 => Especificado
    "contact_name" => "", // (OPCIONAL) Nombre completo de la persona de contacto

    // Configurar cómo se visualiza la dirección en FOTOCASA
    "address_visibility" => 3, // VALORES POSIBLES: 1 => Mostrar Calle y Número | 2 => Mostrar Calle | 3 => Mostrar Sólo zona

    "promotion" => 0, // Para poder exportar promociones a FOTOCASA hay que contratarlo a parte. Si lo tienen basta con cambiar este valor a 1.
);

/* @group Datos: Habitaclia */
$habitacliaTipo = array(9); // Aquí hay que indicar los IDs de los tipos de propiedad que correspondan a LOCAL

/* @group Datos: Yaencontre */
$numOficina = '00000000';
