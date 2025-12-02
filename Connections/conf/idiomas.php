<?php

/*--------------------------------------------------------------------------
/* @group Idioma por defecto la aplicación */
/*--------------------------------------------------------------------------
|
| El idioma por defecto de la aplicación. Este idioma será utilizado como
| el idioma por defecto al traducir una cadena de texto.
|
*/

$language = 'en';

/*--------------------------------------------------------------------------
/* @group Idiomas de la la aplicación */
/*--------------------------------------------------------------------------
|
| Idiomas de la aplicación. Si una solicitud entra en su aplicación con una
| URI que comienza con uno de estos valores, el idioma por defecto se
| establecerá automáticamente en el idioma elegido. El orden de los idiomas
| marcará la posición en que salga en la web y la administración
| Idiomas soportados:
| da - Danés
| de - Alemán
| en - Inglés
| es - Español
| fi - Finlandés
| fr - Francés
| is - Islandés
| nl - Holandés
| no - Noruego
| pl - Polaco
| ru - Ruso
| se - Sueco
| zh - Chino
|
*/

$languages = array('en', 'nl', 'es');

/*--------------------------------------------------------------------------
/* @group Nombres de los idiomas en su propio idioma */
/*--------------------------------------------------------------------------
|
| Nombres de los idiomas en su propio idioma para el menu del cambio de idiomas
|
*/

$languages_names = array(
    'ca' => 'Català',
    'da' => 'Dansk',
    'de' => 'Deutsch',
    'en' => 'English',
    'es' => 'Español',
    'fi' => 'Suomi',
    'fr' => 'Français',
    'is' => 'Íslenska',
    'nl' => 'Nederlands',
    'no' => 'Norsk',
    'pl' => 'Polski',
    'ru' => 'Русский',
    'se' => 'Svenska',
    'zh' => '中文'
);

/*--------------------------------------------------------------------------
/* @group Todos los posibles idiomas de la aplicación */
/*--------------------------------------------------------------------------
|
| El listado de todos los idiomas para la traducción automática
|
*/

$allLanguages = array('ca', 'da', 'de', 'en', 'es', 'fi', 'fr', 'is', 'nl', 'no', 'pl', 'ru', 'se', 'zh');
