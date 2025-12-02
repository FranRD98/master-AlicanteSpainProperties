<?php

require_once __DIR__ . '/vendor/autoload.php';

use Smarty\Smarty;
use Smarty\Extension\ExtensionHandler;
use Smarty\Resource\ExtendsAll;
use Smarty\Exception\SmartyException;

if (isset($_GET['debug_error'])) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

if ($_SERVER["HTTP_HOST"] == 'demo.mediaelx.info') {
    header("Location: /intramedianet/");
}

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mobile-detect/Mobile_Detect.php');


/////////////////////////////////////////////////////////////////////////////////////////
// Smarty
/////////////////////////////////////////////////////////////////////////////////////////

require_once('templates/libs/SmartyPaginate.class.php');

$smarty = new Smarty;

//INCLUDE DE LOS PLUGINS PARA SMARTY 5
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.paginate_first.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.paginate_last.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.paginate_prev2.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.paginate_prev.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.paginate_next.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.paginate_next2.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.paginate_middle.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.imagesize.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.imagesize2.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/function.get_timestamp.php');


require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.getFileTime.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.slug.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.urlencode.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.strtotime.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.sprintf.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.preg_match.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.file_exists.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.html_entity_decode.php');


require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.get_status.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.get_type_srch.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.get_coast.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.get_type_prov.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.get_type_town.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.get_type_pool.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.utf8_decode.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/templates/plugins/modifier.mes.php');



// if ($_COOKIE['view'] == '1') {
//     setcookie('cookie', '1', mktime(21,00,0,12,31,2030),"/", "",0);
// }
// setcookie('view', '1', mktime(21,00,0,12,31,2030),"/", "",0);

//require_once('includes/smarty/Smarty.class.php');

$smarty->setTemplateDir('templates/templates')->addTemplateDir('./modules');
$smarty->setCompileDir('templates/templates_c');
$smarty->setCacheDir('templates/cache');
$smarty->setConfigDir('templates/configs');


//SE REGISTRAN LAS FUNCIONES PARA SMARTY 5
$smarty->registerPlugin('function', 'paginate_first', 'smarty_function_paginate_first');
$smarty->registerPlugin('function', 'paginate_last', 'smarty_function_paginate_last');
$smarty->registerPlugin('function', 'paginate_prev2', 'smarty_function_paginate_prev2');
$smarty->registerPlugin('function', 'paginate_prev', 'smarty_function_paginate_prev');
$smarty->registerPlugin('function', 'paginate_next', 'smarty_function_paginate_next');
$smarty->registerPlugin('function', 'paginate_next2', 'smarty_function_paginate_next2');
$smarty->registerPlugin('function', 'paginate_middle', 'smarty_function_paginate_middle');
$smarty->registerPlugin('function', 'imagesize', 'smarty_function_imagesize');
$smarty->registerPlugin('function', 'imagesize2', 'smarty_function_imagesize2');
$smarty->registerPlugin('function', 'getTimestamp', 'smarty_function_get_timestamp');

$smarty->registerPlugin('modifier', 'getFileTime', 'smarty_modifier_getFileTime');
$smarty->registerPlugin('modifier', 'slug', 'smarty_modifier_slug');
$smarty->registerPlugin('modifier', 'urlencode', 'smarty_modifier_urlencode');
$smarty->registerPlugin('modifier', 'strtotime', 'smarty_modifier_strtotime');
$smarty->registerPlugin('modifier', 'file_exists', 'smarty_function_check_file_exists');
$smarty->registerPlugin('modifier', 'propURL', 'propURL');
$smarty->registerPlugin('modifier', 'getFromArray', 'getFromArray');
$smarty->registerPlugin('modifier', 'getPropTags', 'getPropTags');
$smarty->registerPlugin('modifier', 'html_entity_decode', 'smarty_modifier_html_entity_decode');
$smarty->registerPlugin('modifier', 'sprintf', 'smarty_modifier_sprintf');
$smarty->registerPlugin('modifier', 'preg_match', 'smarty_modifier_preg_match');

$smarty->registerPlugin('modifier', 'getStatus', 'smarty_modifier_get_status');
$smarty->registerPlugin('modifier', 'getTypeSRCH', 'smarty_modifier_get_type_srch');
$smarty->registerPlugin('modifier', 'getCoast', 'smarty_modifier_get_coast');
$smarty->registerPlugin('modifier', 'getTypeProv', 'smarty_modifier_get_type_prov');
$smarty->registerPlugin('modifier', 'getTypeTown', 'smarty_modifier_get_type_town');
$smarty->registerPlugin('modifier', 'getTypePool', 'smarty_modifier_get_type_pool');
$smarty->registerPlugin('modifier', 'utf8_decode', 'smarty_modifier_utf8_decode');
$smarty->registerPlugin('modifier', 'mes', 'smarty_modifier_mes');
$smarty->registerPlugin('modifier', 'getDownloadName', 'getDownloadName');

$smarty->force_compile = true;
$smarty->debugging_ctrl = 'URL';
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = -1;
// $smarty->loadFilter('output', 'trimwhitespace');

require_once('modules/init.php');

/////////////////////////////////////////////////////////////////////////////////////////
// CURRENT URL
/////////////////////////////////////////////////////////////////////////////////////////

$current_url = explode("?", $_SERVER['REQUEST_URI']);
$smarty->assign("current_url", "https://" . $_SERVER['HTTP_HOST'] . $current_url[0]);
$smarty->assign("base_url", "https://" . $_SERVER['HTTP_HOST']);

/////////////////////////////////////////////////////////////////////////////////////////
// Debug
/////////////////////////////////////////////////////////////////////////////////////////

$localhost = ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') ? 1 : 0;
$smarty->assign("localhost", $localhost);

$smarty->assign("debugGET", '<pre>' . print_r(@$_GET, true) . '</pre>');
$smarty->assign("debugPOST", '<pre>' . print_r(@$_POST, true) . '</pre>');
$smarty->assign("debugCOOKIE", '<pre>' . print_r(@$_COOKIE, true) . '</pre>');
$smarty->assign("debugSESSION", '<pre>' . print_r(@$_SESSION, true) . '</pre>');

/////////////////////////////////////////////////////////////////////////////////////////
// INSIGHTS
/////////////////////////////////////////////////////////////////////////////////////////

$isInsights = false;
$isInsights = false;
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Insights') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') !== false) {
    $isInsights = true;
}
$smarty->assign("isInsights", $isInsights);

/////////////////////////////////////////////////////////////////////////////////////////
// Mobile detect -> https://github.com/serbanghita/Mobile-Detect
/////////////////////////////////////////////////////////////////////////////////////////

$detect = new Mobile_Detect;
$smarty->assign("isMobile", $detect->isMobile());
$smarty->assign("isTablet", $detect->isTablet());

/////////////////////////////////////////////////////////////////////////////////////////
// Comprobar navegador
/////////////////////////////////////////////////////////////////////////////////////////

$ua = getBrowser();
$smarty->assign('navegador', $ua['name']);

/////////////////////////////////////////////////////////////////////////////////////////
// Idiomas
/////////////////////////////////////////////////////////////////////////////////////////

$smarty->assign("languages_names", $languages_names);
$smarty->assign("languages", $languages);
$smarty->assign("language", $language);

/////////////////////////////////////////////////////////////////////////////////////////
// Preferencias
/////////////////////////////////////////////////////////////////////////////////////////

$smarty->assign("Activarzonas", $actZonas);
$smarty->assign("actVenderPropiedad", $actVenderPropiedad);
$smarty->assign("actPromociones", $actPromociones);
$smarty->assign("googleMapsApiKey", $googleMapsApiKey);
$smarty->assign("phoneRespBar", $phoneRespBar);
$smarty->assign("thumbnailsSizes", $thumbnailsSizes);
$smarty->assign("actWhatsapp", $actWhatsapp);

if (isset($urlStr[$seccion]["master"]))
    $smarty->assign("seccion_lang", $urlStr[$urlStr[$seccion]["master"]]);
else
    $smarty->assign("seccion_lang", $urlStr[$urlStr['propiedades']["master"]]);

$smarty->assign("opcionSimilares", $opcionSimilares);
$smarty->assign("actTestimonials", $actTestimonials);

//connections/conf/config.php
$smarty->assign("nombreEmpresa", $nombreEmpresa);
if (isset($nombreEmpresaSL))
    $smarty->assign("nombreEmpresaSL", $nombreEmpresaSL);
$smarty->assign("telefonoEmpresa", $telefonoEmpresa);
$smarty->assign("telefonoEmpresa2", $telefonoEmpresa2);
$smarty->assign("correoEmpresa", $correoEmpresa);
$smarty->assign("direccionEmpresa", $direccionEmpresa);
$smarty->assign("tipoGaleria", $tipoGaleria);
$smarty->assign("galeriaModal", $galeriaModal);
if (isset($actMenuBurger))
    $smarty->assign("actMenuBurger", $actMenuBurger);
$smarty->assign("actBuscadorHeader", $actBuscadorHeader);
$smarty->assign("actOnlineViewings", $actOnlineViewings);
$smarty->assign("actSaveSearch", $actSaveSearch);
$smarty->assign("actRegister", $actRegister);
$smarty->assign("actCostas", $actCostas);


/////////////////////////////////////////////////////////////////////////////////////////
// Default Meta
/////////////////////////////////////////////////////////////////////////////////////////

$smarty->assign("metaTitle", $metaTitleDefault);
$smarty->assign("metaDescription", $metaDescriptionDefault);
$smarty->assign("metaKeywords", $metaKeywordsDefault);

/////////////////////////////////////////////////////////////////////////////////////////
// Mailto encode
/////////////////////////////////////////////////////////////////////////////////////////

$encode_values = array('hex');
$random_encode_values = array_rand($encode_values);
$smarty->assign("mailtoencode", $encode_values[$random_encode_values]);

/////////////////////////////////////////////////////////////////////////////////////////
// Level Check
/////////////////////////////////////////////////////////////////////////////////////////

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

$isLevel1 = false;

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("1");
if ($isLoggedIn1->Execute()) {
    $isLevel1 = true;
}

$smarty->assign("isLevel1", $isLevel1);


if ($isLevel1) //BUSQUEDAS -- Usar el nombre del usuario en el header
{

    $queryUser = "
    SELECT
        nombre_usr,
        email_usr
    FROM users
    WHERE id_usr = '" . mysqli_real_escape_string($inmoconn, $_SESSION['kt_login_id']) . "'
    ";

    $usrLogin = getRecords($queryUser);
    $smarty->assign("usrLogin", $usrLogin);
}


/////////////////////////////////////////////////////////////////////////////////////////
// Preferencias
/////////////////////////////////////////////////////////////////////////////////////////

$smarty->assign("actBajadaPrecios", $actBajadaPrecios);
if (isset($responsive))
    $smarty->assign("responsive", $responsive);
$smarty->assign("actUsuarios", $actUsuarios);
$smarty->assign("actCalendar", $actCalendar);
$smarty->assign("actLanding", $actLanding);
$smarty->assign("actQuicklinks", $actQuicklinks);
$smarty->assign("google_captcha_sitekey", $google_captcha_sitekey);
$smarty->assign("google_captcha_privatekey", $google_captcha_privatekey);
$smarty->assign("actMailchimp", $actMailchimp);
$smarty->assign("actMapaPropiedades", $actMapaPropiedades);
$smarty->assign("actNoticias", $actNoticias);
$smarty->assign("fromMail", $fromMail);
$smarty->assign("texto_formularios_GDPR", $texto_formularios_GDPR[$lang]);
$smarty->assign("actEventos", $actEventos);

/////////////////////////////////////////////////////////////////////////////////////////
// Banners
/////////////////////////////////////////////////////////////////////////////////////////

$smarty->assign("actBanner", $actBanner);
$smarty->assign("actBannerTxt", $actBannerTxt);
$smarty->assign("actBannerDesc", $actBannerDesc);
$smarty->assign("actBannerUrl", $actBannerUrl);

$bannersQuery = "
    SELECT
        banners.id_ban,
        CONCAT('/media/images/banner/', banners.image_ban) as img,
        banners.caption_" . $lang . "_ban as caption,
        banners.description_" . $lang . "_ban as description,
        banners.url_" . $lang . "_ban as url
    FROM banners
    ORDER BY RAND()
    LIMIT 1
";

$smarty->assign("banners", getRecords($bannersQuery));

/////////////////////////////////////////////////////////////////////////////////////////
// Últimas Noticias
/////////////////////////////////////////////////////////////////////////////////////////

$lastNewsQuery = "
    SELECT
        news.id_nws,
        news.title_" . $lang . "_nws as titulo,
        news.titlew_" . $lang . "_nws as titulometa,
        news.content_" . $lang . "_nws as contenido,
        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img
    FROM news
    WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 1 AND activate_nws = 1
    ORDER BY news.date_nws DESC
    LIMIT 2
";

$smarty->assign("lastNews", getRecordsAndCache($lastNewsQuery, 'last-news'));

/////////////////////////////////////////////////////////////////////////////////////////
// Últimos Testimonios
/////////////////////////////////////////////////////////////////////////////////////////

$lastTestimonialsQuery = "
    SELECT
        news.id_nws,
        news.title_" . $lang . "_nws as titulo,
        news.titlew_" . $lang . "_nws as titulometa,
        news.content_" . $lang . "_nws as contenido,
        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img
    FROM news
    WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 10 AND activate_nws = 1
    ORDER BY news.date_nws DESC
    LIMIT 9
";

$smarty->assign("lastTestimonials", getRecordsAndCache($lastTestimonialsQuery, 'last-testimonials'));

/////////////////////////////////////////////////////////////////////////////////////////
// Landing pages
/////////////////////////////////////////////////////////////////////////////////////////

$langingPagesQuery = "
    SELECT
        news.title_" . $lang . "_nws as titulo
    FROM news
    WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 3 AND activate_nws = 1
    ORDER BY news.date_nws DESC
    LIMIT 4
";

$smarty->assign("langingPages", getRecordsAndCache($langingPagesQuery, 'landing-pages'));

/////////////////////////////////////////////////////////////////////////////////////////
// Landing pages Destacadas
/////////////////////////////////////////////////////////////////////////////////////////

$quicklinksQueryDest = "
    SELECT
        news.title_" . $lang . "_nws as titulo
    FROM news
    WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 4 AND activate_nws = 1 AND destacado_nws = 1
    ORDER BY news.date_nws DESC
    LIMIT 4
";

$smarty->assign("quicklinksdest", getRecordsAndCache($quicklinksQueryDest, 'quick-links-dest'));

/////////////////////////////////////////////////////////////////////////////////////////
// Quicklinks
/////////////////////////////////////////////////////////////////////////////////////////

$quicklinksQuery = "
    SELECT
        news.title_" . $lang . "_nws as titulo
    FROM news
    WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 4 AND activate_nws = 1 AND destacado_nws = 0
    ORDER BY news.date_nws DESC
    LIMIT 4
";

$smarty->assign("quicklinks", getRecordsAndCache($quicklinksQuery, 'quick-links'));

/////////////////////////////////////////////////////////////////////////////////////////
// Labels
/////////////////////////////////////////////////////////////////////////////////////////

$labelsStylesQuery = "
    SELECT
        id_tag,
        color_tag,
        text_color_tag
    FROM properties_tags
";

$smarty->assign("labelsStyles", getRecordsAndCache($labelsStylesQuery, 'labels-styles'));

$smarty->assign("test", array('uno', '2', '3'));

/////////////////////////////////////////////////////////////////////////////////////////
// Home Search
/////////////////////////////////////////////////////////////////////////////////////////

$countryQuery = "
    SELECT DISTINCT
        properties_loc1.name_" . $lang . "_loc1 AS country,
        properties_loc1.id_loc1 AS id
    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        INNER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        INNER JOIN properties_loc1 ON province1.loc1_loc2 = province1.id_loc2
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY properties_loc1.name_" . $lang . "_loc1
    ORDER BY country ASC
";

$smarty->assign("country", getRecordsAndCache($countryQuery, 'countries-search'));

$provinceQuery = "
    SELECT DISTINCT
        CASE WHEN properties_loc2.name_" . $lang . "_loc2 IS NOT NULL THEN properties_loc2.name_" . $lang . "_loc2 ELSE province1.name_" . $lang . "_loc2  END AS province,
        CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY province ASC
";

$smarty->assign("province", getRecordsAndCache($provinceQuery, 'province-search'));

$cityQuery = "
    SELECT DISTINCT
        CASE WHEN properties_loc3.name_" . $lang . "_loc3 IS NOT NULL THEN properties_loc3.name_" . $lang . "_loc3 ELSE areas1.name_" . $lang . "_loc3  END AS area,
        CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY area ASC
";

$smarty->assign("city", getRecordsAndCache($cityQuery, 'city-search'));

$coastQuery = "
    SELECT DISTINCT
        (SELECT coast_" . $lang . "_cst FROM properties_coast WHERE id_cst = (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END))  AS coast,
        CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY (SELECT coast_" . $lang . "_cst FROM properties_coast WHERE id_cst = (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END)) ASC
";

$smarty->assign("coast", getRecordsAndCache($coastQuery, 'coast-search'));

$localizacionQuery = "
    SELECT DISTINCT
        CASE WHEN properties_loc4.name_" . $lang . "_loc4 IS NOT NULL THEN properties_loc4.name_" . $lang . "_loc4 ELSE towns.name_" . $lang . "_loc4  END AS town,
        CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY town ASC
";

$smarty->assign("localizacion", getRecordsAndCache($localizacionQuery, 'localizacion-search'));

$typeQuery = "
    SELECT
    	CASE WHEN properties_types.types_" . $lang . "_typ IS NOT NULL THEN properties_types.types_" . $lang . "_typ ELSE types.types_" . $lang . "_typ END AS type,
    	CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS id_type
    FROM  properties_properties
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id_type
    ORDER BY type
";

$smarty->assign("type", getRecordsAndCache($typeQuery, 'type-search'));

$statusQuery = "
    SELECT
        properties_status.status_" . $lang . "_sta as sale,
        properties_status.id_sta as id,
        CASE WHEN properties_properties.activado_prop = 1  AND properties_properties.alquilado_prop = 0 AND properties_properties.vendido_prop = 0
        THEN 1
        ELSE 0
        END as visible
    FROM  properties_status
    LEFT JOIN properties_properties ON properties_properties.operacion_prop = properties_status.id_sta AND properties_properties.activado_prop = 1 AND properties_properties.alquilado_prop = 0 AND properties_properties.vendido_prop = 0
    GROUP BY id_sta
    ORDER BY sale
";

$status = getRecordsAndCache($statusQuery, 'status-search');

$smarty->assign("status", $status);

/////////////////////////////////////////////////////////////////////////////////////////
// Featured properties
/////////////////////////////////////////////////////////////////////////////////////////

$featuredQuery = "
    SELECT
        properties_loc1.name_" . $lang . "_loc1 AS country,
        CASE WHEN properties_loc2.name_" . $lang . "_loc2 IS NOT NULL THEN properties_loc2.name_" . $lang . "_loc2 ELSE province1.name_" . $lang . "_loc2  END AS province,
        CASE WHEN properties_loc3.name_" . $lang . "_loc3 IS NOT NULL THEN properties_loc3.name_" . $lang . "_loc3 ELSE areas1.name_" . $lang . "_loc3  END AS area,
        CASE WHEN properties_loc4.name_" . $lang . "_loc4 IS NOT NULL THEN properties_loc4.name_" . $lang . "_loc4 ELSE towns.name_" . $lang . "_loc4  END AS town,
        CASE WHEN properties_types.types_" . $lang . "_typ IS NOT NULL THEN properties_types.types_" . $lang . "_typ ELSE types.types_" . $lang . "_typ END AS type,
        CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
        (SELECT coast_" . $lang . "_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
        properties_status.status_" . $lang . "_sta as sale,
        properties_properties.descripcion_" . $lang . "_prop  as descr,
        properties_properties.m2_prop,
        properties_properties.precio_prop as old_precio,
        properties_properties.preci_reducidoo_prop as precio,
        properties_properties.habitaciones_prop,
        properties_properties.aseos_prop,
        properties_properties.referencia_prop as ref,
    	properties_properties.m2_parcela_prop as m2p_prop,
        id_prop,
        id_img,
        properties_properties.vendido_tag_prop,
        properties_properties.nuevo_prop,
        (SELECT pool_" . $lang . "_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_" . $lang . "_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
        properties_properties.alquilado_prop,
        properties_properties.reservado_prop,
        properties_properties.watermark_prop,
        properties_properties.aseos2_prop,
        properties_properties.precio_desde_prop,
        title_" . $lang . "_prop as metatitle
    FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
        LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND destacado_prop = 1 AND image_img != '' AND force_hide_prop != 1
    GROUP BY id_prop
    ORDER BY order_img, RAND()
    LIMIT 9
";

$smarty->assign("featured", getRecordsAndCache($featuredQuery, 'featured-props'));

$smarty->assign("showprecioReduc", $showprecioReduc);

if ($showprecioReduc == 1) {

    $ofertasQuery = "
        SELECT
            properties_loc1.name_" . $lang . "_loc1 AS country,
            CASE WHEN properties_loc2.name_" . $lang . "_loc2 IS NOT NULL THEN properties_loc2.name_" . $lang . "_loc2 ELSE province1.name_" . $lang . "_loc2  END AS province,
            CASE WHEN properties_loc3.name_" . $lang . "_loc3 IS NOT NULL THEN properties_loc3.name_" . $lang . "_loc3 ELSE areas1.name_" . $lang . "_loc3  END AS area,
            CASE WHEN properties_loc4.name_" . $lang . "_loc4 IS NOT NULL THEN properties_loc4.name_" . $lang . "_loc4 ELSE towns.name_" . $lang . "_loc4  END AS town,
            CASE WHEN properties_types.types_" . $lang . "_typ IS NOT NULL THEN properties_types.types_" . $lang . "_typ ELSE types.types_" . $lang . "_typ END AS type,
            properties_status.status_" . $lang . "_sta as sale,
            properties_properties.descripcion_" . $lang . "_prop  as descr,
            properties_properties.m2_prop,
            properties_properties.precio_prop as old_precio,
            properties_properties.preci_reducidoo_prop as precio,
            properties_properties.habitaciones_prop,
            properties_properties.aseos_prop,
            properties_properties.referencia_prop as ref,
            properties_properties.m2_parcela_prop as m2p_prop,
            id_prop,
            id_img,
            properties_properties.vendido_tag_prop,
            properties_properties.nuevo_prop,
            (SELECT pool_" . $lang . "_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_" . $lang . "_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
            properties_properties.alquilado_prop,
            properties_properties.reservado_prop,
            properties_properties.watermark_prop,
            properties_properties.aseos2_prop,
            properties_properties.precio_desde_prop,
            title_" . $lang . "_prop as metatitle
        FROM properties_loc4 towns
            LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
            LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
            LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
            LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
            LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
            LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
            LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
            LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
            LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
            LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND order_img = 1
            LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
        WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND oferta_prop = 1
        GROUP BY id_prop
        ORDER BY order_img, RAND()
        LIMIT 9
    ";

    $smarty->assign("ofertas", getRecordsAndCache($ofertasQuery, 'ofertas-props'));
}

/////////////////////////////////////////////////////////////////////////////////////////
// Promociones destacadas
/////////////////////////////////////////////////////////////////////////////////////////

$featProms = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.titulo_prom_".$lang."_nws as titulo_prom,
        news.titlew_".$lang."_nws as titulometa,
        news.content_".$lang."_nws as contenido,
        news.tags_".$lang."_nws as tags,
        news.quick_price_from_nws as price,

        quick_province_nws as province,
        quick_town_nws as ciudad,

        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
        (SELECT alt_".$lang."_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt,
        (SELECT COUNT(*) FROM properties_properties WHERE promocion_prop = news.id_nws) AS total_properties,
        (SELECT MIN(preci_reducidoo_prop) as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws) AS precio_desde

    FROM news
    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 999 AND activate_nws = 1 AND destacado_nws = 0 AND destacado_propm_nws = 1

    ORDER BY news.order_nws DESC

    LIMIT 9
");

$smarty->assign("featProms", $featProms);

/////////////////////////////////////////////////////////////////////////////////////////
// Buscador promociones
/////////////////////////////////////////////////////////////////////////////////////////

$cityPromoQuery = "
   SELECT DISTINCT
       CASE
           WHEN properties_loc3.name_" . $lang . "_loc3 IS NOT NULL
           THEN properties_loc3.name_" . $lang . "_loc3
           ELSE areas1.name_" . $lang . "_loc3
       END AS area,
       CASE
           WHEN properties_loc3.id_loc3 IS NOT NULL
           THEN properties_loc3.id_loc3
           ELSE areas1.id_loc3
       END AS id
   FROM properties_loc4 towns
   LEFT JOIN properties_properties p ON p.localidad_prop = towns.id_loc4
   LEFT JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
   LEFT JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
   LEFT JOIN news n ON p.promocion_prop = n.id_nws
   WHERE
       p.activado_prop = 1
       AND p.alquilado_prop = 0
       AND p.vendido_prop = 0
       AND p.force_hide_prop != 1
       AND n.activate_nws = 1
       AND n.type_nws = 999
   GROUP BY id
   ORDER BY area ASC
";
$smarty->assign("cityPromo", getRecordsAndCache($cityPromoQuery, 'city-promo-search'));

$typePromoQuery = "
   SELECT DISTINCT
       CASE
           WHEN properties_types.types_" . $lang . "_typ IS NOT NULL
               THEN properties_types.types_" . $lang . "_typ
           ELSE types.types_" . $lang . "_typ
       END AS type,
       CASE
           WHEN properties_types.id_typ IS NOT NULL
               THEN properties_types.id_typ
           ELSE types.id_typ
       END AS id_type
   FROM properties_properties p
   INNER JOIN properties_types types ON p.tipo_prop = types.id_typ
   LEFT JOIN properties_types ON types.parent_typ = properties_types.id_typ
   INNER JOIN news n ON p.promocion_prop = n.id_nws
   WHERE
       p.activado_prop = 1
       AND p.alquilado_prop = 0
       AND p.vendido_prop = 0
       AND p.force_hide_prop != 1
       AND n.activate_nws = 1
       AND n.type_nws = 999
   GROUP BY id_type
   ORDER BY type ASC
";
$smarty->assign("typePromo", getRecordsAndCache($typePromoQuery, 'type-promo-search'));

/////////////////////////////////////////////////////////////////////////////////////////
// Zonas
/////////////////////////////////////////////////////////////////////////////////////////

if ($actZonas == 1) {

    $zonasmenQuery = "
        SELECT
            direccion_gp_prop,
            lat_long_gp_prop,
            zoom_gp_prop,
            provinces_ct,
            id_ct,
            category_" . $lang . "_ct as titulo,
            descripcion_" . $lang . "_ct as contenido,
            title_" . $lang . "_ct as titulow,
            description_" . $lang . "_ct as contenidow,
            keywords_" . $lang . "_ct as keywords,
            (SELECT image_img FROM zonas_images WHERE zona_img = id_ct ORDER BY order_img LIMIT 1) AS img,
            (SELECT video_vid FROM news_videos WHERE news_vid = id_ct ORDER BY order_vid) as id_ct
        FROM news_categories
        WHERE type_ct = 6
        ORDER BY category_" . $lang . "_ct
        ";
    $smarty->assign("zonasmen", getRecordsAndCache($zonasmenQuery, 'zonas-menu'));

    $ciudassrQuery = "
        SELECT
            news.id_nws,
            news.title_" . $lang . "_nws as titulo,
            news.titlew_" . $lang . "_nws as titulometa,
            news.content_" . $lang . "_nws as contenido,
            news.date_nws,
            news.zonas_nws,
            news.categoria_nws,
            news.lat_long_gp_prop,
            (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
            (SELECT alt_" . $lang . "_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt
        FROM news
        WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 6
        ORDER BY news.title_" . $lang . "_nws
    ";

    $smarty->assign("ciudassr", getRecordsAndCache($ciudassrQuery, 'ciudades-menu'));
}

/////////////////////////////////////////////////////////////////////////////////////////
// Favorites
/////////////////////////////////////////////////////////////////////////////////////////
$totalFavs = 0;
$theFavs = array();
if ($isLevel1) //FAVORITOS -- Usuario
{

    $stmt = $inmoconn->prepare("SELECT COUNT(*) FROM `users_favorites` WHERE `user` = ?");

    if ($stmt) {
        $stmt->bind_param('s', $_SESSION['kt_login_id']);
        $stmt->execute();
        $stmt->bind_result($totalFavs);
        $stmt->fetch();
        $stmt->close();
    }
} else {

    //si no esta logeado verifico las cookies
    if (isset($_COOKIE['fav'])) {
        $theFavs = explode(",", $_COOKIE['fav']);
        $totalFavs = (isset($_COOKIE['fav']) ? count($theFavs) : 0);
    }
}

$smarty->assign("theFavs", $theFavs);
$smarty->assign("totalFavs", $totalFavs);

/////////////////////////////////////////////////////////////////////////////////////////
// Wheather
/////////////////////////////////////////////////////////////////////////////////////////

// $weatherCities = array('Alicante' => 'EUR|ES|SP016|ALICANTE');

// foreach ($weatherCities as $key => $value) {

//     $name = "weather_".clean($key).".xml";
//     $xml  = "weather/".$name;

//     if ( !file_exists($xml) || strtotime('+15 minutes',filemtime($xml)) < strtotime("now") || !filesize($xml) ) {


//         $ch = file_get_contents('http://forecastfox.accuweather.com/adcbin/forecastfox/weather_data.asp?partner=forecastfox&location='.$value.'&metric=17');
//         $fp = fopen($xml , "w");
//         fwrite($fp, $ch);
//         fclose($fp);

//     }

//     $theXML = simplexml_load_string(mb_convert_encoding(file_get_contents($xml),'UTF-8','UTF-8'));

//     $iconW = (string)$theXML->currentconditions->weathericon;
//     $cityW = (string)$key;
//     $temperatureW = (string)$theXML->currentconditions->temperature;
//     $hightemperatureW = (string)$theXML->forecast->day[0]->daytime->hightemperature;
//     $lowtemperatureW = (string)$theXML->forecast->day[0]->daytime->lowtemperature;

//     $weather[] = array($iconW, $cityW, $temperatureW, $hightemperatureW, $lowtemperatureW);

// }

// $smarty->assign("weather", $weather);

/////////////////////////////////////////////////////////////////////////////////////////
// Cambio vistas propiedades
/////////////////////////////////////////////////////////////////////////////////////////
$urlBox = '';
$urlList = '';
$urlMap = '';
if (isset($urlStr['property-map']['url'])) {
    $urlBox = str_replace($urlStr['property-map']['url'], $urlStr['properties']['url'], $_SERVER['REQUEST_URI']);
    $urlList = str_replace($urlStr['property-map']['url'], $urlStr['properties']['url'], $_SERVER['REQUEST_URI']);

    foreach ($status as $stat) {
        if ($seccion == $urlStr['properties']['url'] . '-' . slug(getFromArray($status, $stat['id'], 'id', 'sale'))) {
            $urlMap = str_replace($urlStr['properties']['url'] . '-' . slug(getFromArray($status, $stat['id'], 'id', 'sale')), $urlStr['property-map']['url'], $_SERVER['REQUEST_URI']);
            $urlMap = KT_addReplaceParam($urlMap, 'st[]', $stat['id']);
        }
    }

    if ($seccion == $urlStr['properties']['url']) {
        $urlMap = str_replace($urlStr['properties']['url'], $urlStr['property-map']['url'], $_SERVER['REQUEST_URI']);
    }
}

$smarty->assign("urlBox", $urlBox);
$smarty->assign("urlList", $urlList);
$smarty->assign("urlMap", $urlMap);

/////////////////////////////////////////////////////////////////////////////////////////
// Secciones
/////////////////////////////////////////////////////////////////////////////////////////

if (isset($_GET['zon']) && $_GET['zon'] != '' && isset($_GET['ciu']) && $_GET['ciu'] != '') {
    include($_SERVER["DOCUMENT_ROOT"] . '/modules/ciudades/properties.php');
    $smarty->display('modules/ciudades/view/index.tpl');
    die();
}


if (isset($_GET['zon']) && $_GET['zon'] != '') {
    include($_SERVER["DOCUMENT_ROOT"] . '/modules/zonas/properties.php');
    $smarty->display('modules/zonas/view/index.tpl');
    die();
}

switch ($seccion) {

    case '':
        $numpag = 1;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/inicio/inicio.php');
        $smarty->assign("addCanonical", 1);
        $smarty->display('modules/inicio/view/index.tpl');
        break;

    case 'landing':
        $numpag = $tokens[1];
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/inicio/inicio.php');
        $smarty->display('modules/inicio/view/index.tpl');
        break;

    case $urlStr['about-us']['url']:
        $numpag = 2;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/pages/view/index.tpl');
        break;

    case $urlStr['advanced-search']['url']:
        $numpag = 3;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/search/search.php');
        $smarty->display('modules/search/view/index.tpl');
        break;

    case $urlStr['properties']['url']:
        $numpag = 4;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        if (isset($_GET['idquick']) && $_GET['idquick'] != '') {
            $numpag = $_GET['idquick'];
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/inicio/inicio.php');
        } else {
            $smarty->assign("addCanonical", 1);
        }
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/properties/properties.php');
        $smarty->display('modules/properties/view/index.tpl');
        break;

    case $urlStr['areas']['url']:
        $numpag = 5;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/pages/view/index.tpl');
        break;

    case $urlStr['property-map']['url'] ?? null:
        $numpag = 6;
        $smarty->assign("addCanonical", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/properties/properties-map.php');
        $smarty->display('modules/properties/view/map.tpl');
        break;

    case $urlStr['property']['url']:
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/property/property.php');
        if ($property[0]['id_prop'] == '') {
            if ($property[0]['id_prop'] == '') {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: " . $urlStart . "" . $urlStr['properties']['url']);
                die();
            } else {
                $smarty->display('modules/property/view/index.tpl');
            }
        } else {
            $smarty->display('modules/property/view/index.tpl');
        }
        break;

    case $urlStr['favorites']['url']:
        $numpag = 7;
        if ($tokens[1] == 'print') {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/favorites/print.php');
            $smarty->display('modules/favorites/view/print.tpl');
        } else {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/favorites/properties.php');
            $smarty->display('modules/favorites/view/index.tpl');
        }
        break;

    case 'favorites-print':
        $numpag = 7;
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/favorites/properties-adm.php');
        $smarty->display('modules/favorites/view/index-adm.tpl');
        break;

    case $urlStr['promociones']['url']:
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/promociones/sidebar.php');
        $numpag = 416;
        $actWatermark = 0;
        if (isset($tokens[3]) && $tokens[3] == '' && isset($tokens[2]) && $tokens[2] != $urlStr['category']['url'] && $tokens[2] != '') {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/promociones/new.php');
            $smarty->display('modules/promociones/view/new.tpl');
        } else {
            $smarty->assign("addCanonical", 1);
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/promociones/news.php');
            $smarty->display('modules/promociones/view/index.tpl');
        }
        break;

    case $urlStr['news']['url']:
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/news/sidebar.php');
        if (isset($tokens[3]) && $tokens[3] == '' && isset($tokens[2]) && $tokens[2] != $urlStr['category']['url'] && $tokens[2] != '') {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/news/new.php');
            $smarty->display('modules/news/view/new.tpl');
        } else {
            $numpag = 21;
            $smarty->assign("addCanonical", 1);
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/news/news.php');
            $smarty->display('modules/news/view/index.tpl');
        }
        break;

    case $urlStr['testimonials']['url']:
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/testimonials/sidebar.php');
        $actWatermark = 0;
        $smarty->assign("pageBreadcrumb", $langStr["Testimonials"]);
        if (isset($tokens[3]) && $tokens[3] == '' && $tokens[2] != $urlStr['category']['url'] && $tokens[2] != '') {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/testimonials/new.php');
            $smarty->display('modules/testimonials/view/new.tpl');
        } else {
            $numpag = 20;
            $smarty->assign("addCanonical", 1);
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/testimonials/news.php');
            $smarty->display('modules/testimonials/view/index.tpl');
        }
        break;

    case $urlStr['events']['url']:
        if (isset($tokens[3]) && $tokens[3] == '' && $tokens[2] != $urlStr['category']['url'] && $tokens[2] != '') {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/events/new.php');
            $smarty->display('modules/events/view/new.tpl');
        } else {
            $numpag = 30;
            $smarty->assign("addCanonical", 1);
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/events/news.php');
            $smarty->display('modules/events/view/index.tpl');
        }
        break;

    case $urlStr['contact']['url']:
        $numpag = 8;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/contact/view/index.tpl');
        break;

    case $urlStr['sell-your-property']['url']:
        $numpag = 9;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/vender/view/index.tpl');
        break;

    case $urlStr['legal-note']['url']:
        $numpag = 10;
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/pages/view/index.tpl');
        break;

    case $urlStr['sitemap']['url']:
        $numpag = 11;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/sitemap/sitemap.php');
        $smarty->display('modules/sitemap/view/index.tpl');
        break;

    case $urlStr['privacy']['url']:
        $numpag = 12;
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/pages/view/index.tpl');
        break;

    case 'login':
        $numpag = 13;
        $smarty->assign("noIndex", 1);
        if ($actRegister == 1 && $actUsuarios == 1) {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/login/login.php');
            $smarty->display('modules/login/view/index.tpl');
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $urlStart);
        }
        break;

    case 'drop':
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/drop/drop.php');
        $smarty->display('modules/drop/view/index.tpl');
        break;

    case 'forgot':
        $numpag = 14;
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/login/forgot.php');
        $smarty->display('modules/login/view/forgot.tpl');
        break;

    case 'register':
        $numpag = 15;
        $smarty->assign("noIndex", 1);

        if ($actRegister == 1 && $actUsuarios == 1) {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/login/register.php');
            $smarty->display('modules/login/view/register.tpl');
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $urlStart);
        }

        break;

    case 'update':
        $numpag = 16;
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/login/update.php');
        $smarty->display('modules/login/view/update.tpl');
        break;

    case 'saved-searches': // BUSQUEDAS
        $numpag = 0;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/login/usr-search.php');
        $smarty->display('modules/login/view/usr-search.tpl');
        break;

    case 'tv':
        $numpag = "0";
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/tv.php');
        $smarty->display('modules/pages/view/tv.tpl');
        break;

    case 'unsubscribe':
        $numpag = "0";
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/unsubscribe.php');
        $smarty->assign("aviso", $aviso);
        $smarty->display('modules/mail_partials/index.tpl');
        break;

    case 'favorites-user':
        $numpag = 7;
        if ($tokens[1] == 'print') {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/favorites/print.php');
            $smarty->display('modules/favorites/view/print.tpl');
        } else {
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
            include($_SERVER["DOCUMENT_ROOT"] . '/modules/favorites/properties.php');
            $smarty->display('modules/favorites/view/index.tpl');
        }
        break;

    case 'logout':
        $smarty->assign("noIndex", 1);
        $tNGs = new tNG_dispatcher("../");
        $conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
        $logoutTransaction = new tNG_logoutTransaction($conn_inmoconn);
        $tNGs->addTransaction($logoutTransaction);
        $logoutTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", "true");
        $logoutTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "/login/?info=LOGOUT");
        $tNGs->executeTransactions();
        $rscustom = $tNGs->getRecordset("custom");
        $row_rscustom = mysqli_fetch_assoc($rscustom);
        $totalRows_rscustom = mysqli_num_rows($rscustom);
        break;

    case 'reporte':
        $numpag = 17;
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/reporte/reporte.php');
        $smarty->display('modules/reporte/view/index.tpl');
        break;

    case 'cookies':
        $numpag = 18;
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/pages/view/index.tpl');
        break;

    case 'rate':
        $numpag = "29, 33";
        $smarty->assign("noIndex", 1);
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/rate.php');
        $smarty->display('modules/mail_partials/view/index.tpl');
    break;

    default:

        foreach (getRecordsAndCache($statusQuery, 'status-search') as $key => $value) {
            $statusValue = $value;
            if ($seccion == $urlStr['properties']['url'] . "-" . slug($statusValue["sale"])) {
                $numpag = 5;
                if ($statusValue["id"] == 1) {
                    $numpag = 22;
                }
                if ($statusValue["id"] == 2) {
                    $numpag = 23;
                }
                if ($statusValue["id"] == 3) {
                    $numpag = 24;
                }
                if ($statusValue["id"] == 4) {
                    $numpag = 25;
                }
                $statusLink = 1;
                $_GET["st"][] = $statusValue["id"];
                include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
                include($_SERVER["DOCUMENT_ROOT"] . '/modules/properties/properties.php');
                $langQuery = "";
                foreach ($languages as $key => $lan) {
                    $langQuery .= "properties_status.status_" . $lan . "_sta as sale_" . $lan . ", ";
                }
                $remoteProp = '';
                $statusUrl = getRecords("
                    SELECT
                        " . $langQuery . "
                        properties_status.id_sta as id
                    FROM  properties_properties
                        LEFT OUTER  JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
                    WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND properties_status.id_sta = '" . simpleSanitize(($statusValue["id"])) . "' " . simpleSanitize(($remoteProp)) . "
                    GROUP BY id_sta
                    ORDER BY sale_" . $language . "
                    LIMIT 1
                ");
                foreach ($languages as $lan) {
                    if ($lan == $language) {
                        if ($statusUrl[0]['sale_' . $lan] != '') {
                            $urlDefault = '/' . $urlStr["properties"][$lan] . "-" . slug($statusUrl[0]['sale_' . $lan]) . '/';
                        } else {
                            $urlDefault = '/';
                        }
                        $smarty->assign('urlDefault', $urlDefault);
                    } else {
                        $langUpper = strtoupper($lan);
                        if ($statusUrl[0]['sale_' . $lan] != '') {
                            $urlLang = '/' . $lan . '/' . $urlStr["properties"][$lan] . "-" . slug($statusUrl[0]['sale_' . $lan]) . '/';
                        } else {
                            $urlLang =  '/' . $lan . '/';
                        }
                        $smarty->assign('url' . $langUpper, $urlLang);
                    }
                }
                $smarty->assign("addCanonical", 1);
                $smarty->assign("seccion", $urlStr['properties']['url']);
                $smarty->display('modules/properties/view/index.tpl');
                die();
            }
        }

        $urlFullList = array();
        foreach ($urlStr as $u => $l) {
            foreach ($l as $ll => $uu) {
                if ($ll != "master" && $uu != "") {
                    $urlFullList[$uu] = $l;
                }
            }
        }
        if (isset($urlFullList[$seccion][$lang])) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $urlStart . "" . $urlFullList[$seccion][$lang] . "/");
            exit;
        }

        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        header("Status: 404 Not Found");
        $_SERVER['REDIRECT_STATUS'] = 404;
        $numpag = 19;
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
        $smarty->display('modules/404/view/index.tpl');
}

if (isset($_GET['debug_time'])) {
    $executionEndTime = microtime(true);
    $seconds = $executionEndTime - $executionStartTime;
    echo "<div class=\"well lead\" role=\"alert\">Se ha ejecutado en " . round($seconds, 5) . " segundos.</div>";
}
