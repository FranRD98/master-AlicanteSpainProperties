<?php

/*--------------------------------------------------------------------------
/* @group Newsletter */
/*--------------------------------------------------------------------------
|
| Activar la newsletter de la aplicación
| 0 - Desactivado
| 1 - Activado
|
*/

$actNewsletter = 0; // NO USAR!!!!

/*--------------------------------------------------------------------------
/* @group Categoría nesletter */
/*--------------------------------------------------------------------------
|
| ID de la categoría que se añade por defecto cuando se apuntan a la newsletter desde la web
|
*/

$idCatNewsletter = 0; // NO USAR!!!!

/*--------------------------------------------------------------------------
/* @group Newsletter Mailchimp */
/*--------------------------------------------------------------------------
|
| Activar la newsletter de Mailchimp de la aplicación
| 0 - Desactivado
| 1 - Activado
|
*/

$actMailchimp = 0;

/*--------------------------------------------------------------------------
/* @group Mailchimp API key */
/*--------------------------------------------------------------------------
|
| API key de Mailchimp (hay que registrarse en Mailchimp para obtenerla)
|
| IMPORTANTE:
| - Hay que verificar el dominio desde el panel de Mailchimp (Account > Settings > Verify domain)
| - El email ha de ser el mismo con el que se han creado las listas
|
*/

// $keyMailchimp = '';

/*
|--------------------------------------------------------------------------
| Datos para crear las listas de correo
|--------------------------------------------------------------------------
|
| Añadir las de los idiomas de la web
|
| IMPORTANTE:
| - Hay listas en Mailchimp, hay que crear una por idioma para clientes
|
*/

// Permissions reminder
// $Mailchimp_permisions_reminders = 'Está recibiendo este correo electrónico porque se apunto a nuestra newsletter / You are receiving this email because you signed up to our newsletter';
// Mailchimp default contact
// $Mailchimp_dc_company = '';
// $Mailchimp_dc_address1 = '';
// $Mailchimp_dc_city = '';
// $Mailchimp_dc_state = '';
// $Mailchimp_dc_zip = '';
// $Mailchimp_dc_country = '';

/*
|--------------------------------------------------------------------------
| ID principal de la lista de correo de Mailchimp
|--------------------------------------------------------------------------
|
| Añadir las de los idiomas de la web
|
| IMPORTANTE:
| - Hay listas en Mailchimp, hay que crear una por idioma para clientes
|
*/

// $mailchimpIdListaPrincipal = '5cba978059';

/*
|--------------------------------------------------------------------------
| IDs de las listas de clientes de Mailchimp
|--------------------------------------------------------------------------
|
| Añadir las de los idiomas de la web
|
| IMPORTANTE:
| - Hay listas en Mailchimp, hay que crear una por idioma para clientes
|
*/

// $mailchimpIdListaIdiomas= array(
//     'ca' => '103225',
//     'da' => '103225',
//     'de' => '103229',
//     'en' => '103233',
//     'es' => '103237',
//     'fi' => '103241',
//     'fr' => '103245',
//     'is' => '103249',
//     'nl' => '103253',
//     'no' => '103257',
//     'ru' => '103261',
//     'se' => '103265',
//     'zh' => '103269'
// );

// $mailchimpIdListaClients = '103273';

// $mailchimpIdListaOwners = '103277';

// $mailchimpIdListaWebsite = '103281';

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| ACUMBAMAIL
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------|
*/

/*--------------------------------------------------------------------------
/* @group Newsletter Acumbamail */
/*--------------------------------------------------------------------------
|
| Activar la newsletter de Acumbamail de la aplicación
| 0 - Desactivado
| 1 - Activado
|
*/

$actAcumbamail = 0;

if ($actAcumbamail) {
    $actMailchimp = 1;
}

/*--------------------------------------------------------------------------
/* @group Acumbamail API key */
/*--------------------------------------------------------------------------
|
| API key de Acumbamail (hay que registrarse en Acumbamail para obtenerla e ir a https://acumbamail.com/apidoc/)
|
*/

$keyAcumbamail = '';

/*
|--------------------------------------------------------------------------
| Datos para crear las listas de correo
|--------------------------------------------------------------------------
|
| Añadir las datos de la empresa para crear las listas
|
| IMPORTANTE:
| - Hay listas en Acumbamail, hay que crear una por idioma para clientes
|
*/

$Acumbamail_dc_company = '';
$Acumbamail_dc_address1 = '';
$Acumbamail_dc_city = '';
$Acumbamail_dc_country = '';
$Acumbamail_dc_phone = '';

/*
|--------------------------------------------------------------------------
| IDs de las listas de clientes de Acumbamail
|--------------------------------------------------------------------------
|
| Añadir las de los idiomas de la web
|
| IMPORTANTE:
| - Hay listas en Acumbamail, hay que crear una por idioma para clientes
|
*/

$acumbamailIdListaClients = array(
    'ca' => '',
    'da' => '',
    'de' => '',
    'en' => '',
    'es' => '',
    'fi' => '',
    'pl' => '',
    'fr' => '',
    'is' => '',
    'nl' => '',
    'no' => '',
    'ru' => '',
    'se' => '',
    'zh' => ''
);

$acumbamailIdListaOwners = array(
    'ca' => '',
    'da' => '',
    'de' => '',
    'en' => '',
    'es' => '',
    'fi' => '',
    'fr' => '',
    'pl' => '',
    'is' => '',
    'nl' => '',
    'no' => '',
    'ru' => '',
    'se' => '',
    'zh' => ''
);

$acumbamailIdListaWebsite = array(
    'ca' => '',
    'da' => '',
    'de' => '',
    'en' => '',
    'es' => '',
    'fi' => '',
    'fr' => '',
    'pl' => '',
    'is' => '',
    'nl' => '',
    'no' => '',
    'ru' => '',
    'se' => '',
    'zh' => ''
);

$acumbamailIdListaAgency = array(
    'ca' => '',
    'da' => '',
    'de' => '',
    'en' => '',
    'es' => '',
    'fi' => '',
    'pl' => '',
    'fr' => '',
    'is' => '',
    'nl' => '',
    'no' => '',
    'ru' => '',
    'se' => '',
    'zh' => ''
);
