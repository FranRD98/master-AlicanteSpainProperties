<?php
$langQuery = '';

foreach ($languages as $key => $value) {

    $langQuery .= "news.title_" . $value . "_nws as titulo_" . $value . ", ";
    $langQuery .= "news.titlew_" . $value . "_nws as titulow_" . $value . ", ";
}

$newsURLs = getRecords("

SELECT
    " . $langQuery . "
    news.id_nws
FROM news

WHERE id_nws = '" . simpleSanitize(($tokens[1])) . "'

LIMIT 1


");

foreach ($languages as $value) {

    if ($value == $language) {

        if ($newsURLs[0]['titulow_' . $value] != '' || $newsURLs[0]['titulo_' . $value] != '') {
            if ($newsURLs[0]['titulow_' . $value] != '') {
                $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['promociones'][$value] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_' . $value]) . '/';
            } else {
                $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['promociones'][$value] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_' . $value]) . '/';
            }
        } else {
            $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['promociones'][$value] . '/';
        }
    }
}

if ($newsURLs[0]['titulow_ce'] != '' || $newsURLs[0]['titulo_ce'] != '') {
    if ($newsURLs[0]['titulow_ce'] != '') {
        $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['promociones']['ca'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_ca']) . '/';
    } else {
        $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['promociones']['ca'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_ca']) . '/';
    }
} else {
    $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['promociones']['ca'] . '/';
}

if ($newsURLs[0]['titulow_da'] != '' || $newsURLs[0]['titulo_da'] != '') {
    if ($newsURLs[0]['titulow_da'] != '') {
        $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['promociones']['da'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_da']) . '/';
    } else {
        $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['promociones']['da'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_da']) . '/';
    }
} else {
    $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['promociones']['da'] . '/';
}

if ($newsURLs[0]['titulow_de'] != '' || $newsURLs[0]['titulo_de'] != '') {
    if ($newsURLs[0]['titulow_de'] != '') {
        $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['promociones']['de'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_de']) . '/';
    } else {
        $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['promociones']['de'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_de']) . '/';
    }
} else {
    $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['promociones']['de'] . '/';
}

if ($newsURLs[0]['titulow_el'] != '' || $newsURLs[0]['titulo_el'] != '') {
    if ($newsURLs[0]['titulow_el'] != '') {
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['promociones']['el'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_el']) . '/';
    } else {
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['promociones']['el'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_el']) . '/';
    }
} else {
    $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['promociones']['el'] . '/';
}

if ($newsURLs[0]['titulow_en'] != '' || $newsURLs[0]['titulo_en'] != '') {
    if ($newsURLs[0]['titulow_en'] != '') {
        $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['promociones']['en'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_en']) . '/';
    } else {
        $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['promociones']['en'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_en']) . '/';
    }
} else {
    $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['promociones']['en'] . '/';
}

if ($newsURLs[0]['titulow_es'] != '' || $newsURLs[0]['titulo_es'] != '') {
    if ($newsURLs[0]['titulow_es'] != '') {
        $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['promociones']['es'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_es']) . '/';
    } else {
        $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['promociones']['es'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_es']) . '/';
    }
} else {
    $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['promociones']['es'] . '/';
}

if ($newsURLs[0]['titulow_fi'] != '' || $newsURLs[0]['titulo_fi'] != '') {
    if ($newsURLs[0]['titulow_fi'] != '') {
        $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['promociones']['fi'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_fi']) . '/';
    } else {
        $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['promociones']['fi'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_fi']) . '/';
    }
} else {
    $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['promociones']['fi'] . '/';
}

if ($newsURLs[0]['titulow_fr'] != '' || $newsURLs[0]['titulo_fr'] != '') {
    if ($newsURLs[0]['titulow_fr'] != '') {
        $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['promociones']['fr'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_fr']) . '/';
    } else {
        $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['promociones']['fr'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_fr']) . '/';
    }
} else {
    $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['promociones']['fr'] . '/';
}

if ($newsURLs[0]['titulow_hu'] != '' || $newsURLs[0]['titulo_hu'] != '') {
    if ($newsURLs[0]['titulow_hu'] != '') {
        $urlHU = 'http://' . $_SERVER['HTTP_HOST'] . '/hu/' . $urlStr['promociones']['hu'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_hu']) . '/';
    } else {
        $urlHU = 'http://' . $_SERVER['HTTP_HOST'] . '/hu/' . $urlStr['promociones']['hu'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_hu']) . '/';
    }
} else {
    $urlHU = 'http://' . $_SERVER['HTTP_HOST'] . '/hu/' . $urlStr['promociones']['hu'] . '/';
}

if ($newsURLs[0]['titulow_is'] != '' || $newsURLs[0]['titulo_is'] != '') {
    if ($newsURLs[0]['titulow_is'] != '') {
        $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['promociones']['is'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_is']) . '/';
    } else {
        $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['promociones']['is'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_is']) . '/';
    }
} else {
    $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['promociones']['is'] . '/';
}

if ($newsURLs[0]['titulow_it'] != '' || $newsURLs[0]['titulo_it'] != '') {
    if ($newsURLs[0]['titulow_it'] != '') {
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['promociones']['it'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_it']) . '/';
    } else {
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['promociones']['it'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_it']) . '/';
    }
} else {
    $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['promociones']['it'] . '/';
}

if ($newsURLs[0]['titulow_nl'] != '' || $newsURLs[0]['titulo_nl'] != '') {
    if ($newsURLs[0]['titulow_nl'] != '') {
        $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['promociones']['nl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_nl']) . '/';
    } else {
        $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['promociones']['nl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_nl']) . '/';
    }
} else {
    $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['promociones']['nl'] . '/';
}

if ($newsURLs[0]['titulow_no'] != '' || $newsURLs[0]['titulo_no'] != '') {
    if ($newsURLs[0]['titulow_no'] != '') {
        $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['promociones']['no'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_no']) . '/';
    } else {
        $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['promociones']['no'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_no']) . '/';
    }
} else {
    $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['promociones']['no'] . '/';
}

if ($newsURLs[0]['titulow_pt'] != '' || $newsURLs[0]['titulo_pt'] != '') {
    if ($newsURLs[0]['titulow_pt'] != '') {
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['promociones']['pt'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_pt']) . '/';
    } else {
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['promociones']['pt'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_pt']) . '/';
    }
} else {
    $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['promociones']['pt'] . '/';
}

if ($newsURLs[0]['titulow_ru'] != '' || $newsURLs[0]['titulo_ru'] != '') {
    if ($newsURLs[0]['titulow_ru'] != '') {
        $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['promociones']['ru'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_ru']) . '/';
    } else {
        $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['promociones']['ru'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_ru']) . '/';
    }
} else {
    $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['promociones']['ru'] . '/';
}

if ($newsURLs[0]['titulow_se'] != '' || $newsURLs[0]['titulo_se'] != '') {
    if ($newsURLs[0]['titulow_se'] != '') {
        $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['promociones']['se'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_se']) . '/';
    } else {
        $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['promociones']['se'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_se']) . '/';
    }
} else {
    $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['promociones']['se'] . '/';
}

if ($newsURLs[0]['titulow_zh'] != '' || $newsURLs[0]['titulo_zh'] != '') {
    if ($newsURLs[0]['titulow_zh'] != '') {
        $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['promociones']['zh'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_zh']) . '/';
    } else {
        $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['promociones']['zh'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_zh']) . '/';
    }
} else {
    $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['promociones']['zh'] . '/';
}

if ($newsURLs[0]['titulow_pl'] != '' || $newsURLs[0]['titulo_pl'] != '') {
    if ($newsURLs[0]['titulow_pl'] != '') {
        $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['promociones']['pl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_pl']) . '/';
    } else {
        $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['promociones']['pl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_pl']) . '/';
    }
} else {
    $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['promociones']['pl'] . '/';
}

$smarty->assign('urlDefault', $urlDefault);

$smarty->assign('urlCA', $urlCA);
$smarty->assign('urlDA', $urlDA);
$smarty->assign('urlDE', $urlDE);
$smarty->assign('urlEL', $urlEL);
$smarty->assign('urlEN', $urlEN);
$smarty->assign('urlES', $urlES);
$smarty->assign('urlFI', $urlFI);
$smarty->assign('urlFR', $urlFR);
$smarty->assign('urlHU', $urlHU);
$smarty->assign('urlIS', $urlIS);
$smarty->assign('urlIT', $urlIT);
$smarty->assign('urlNL', $urlNL);
$smarty->assign('urlNO', $urlNO);
$smarty->assign('urlPT', $urlPT);
$smarty->assign('urlRU', $urlRU);
$smarty->assign('urlSE', $urlSE);
$smarty->assign('urlZH', $urlZH);
$smarty->assign('urlPL', $urlPL);



$news = getRecords("

    SELECT news.id_nws,
        news.title_" . $lang . "_nws as titulo,
        news.titulo_prom_" . $lang . "_nws as titulo_prom,
        news.content_" . $lang . "_nws as contenido,
        news.titlew_" . $lang . "_nws as titulow,
        news.description_" . $lang . "_nws as contenidow,
        news.keywords_" . $lang . "_nws as keywords,
        news.tags_" . $lang . "_nws as tags,
        news.date_nws,
        news.quick_location_nws,
        news.quick_type_nws,
        news.quick_status_nws,
        news.quick_town_nws,
        news.quick_province_nws,

        quick_province_nws as provincia,
        quick_town_nws as ciudad,

        quick_price_from_nws,
        quick_price_up_to_nws,
        direccion_gp_prop,
        lat_long_gp_prop,
        zoom_gp_prop,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_" . $lang . "_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 999

    AND id_nws = '" . simpleSanitize(($tokens[1])) . "'

    ORDER BY news.date_nws DESC

    LIMIT 1
");



/**
 * Si no existe la noticia mostrar 404
 */

if ($news[0]['id_nws'] == '') {

    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    header("Status: 404 Not Found");
    $_SERVER['REDIRECT_STATUS'] = 404;
    $numpag = 11;
    include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
    $smarty->display('modules/404/view/index.tpl');
}

$smarty->assign("news", $news);

if ($news[0]['titulow'] != '') {
    $title = $news[0]['titulow'];
} else {
    $title = $news[0]['titulo'];
}

$smarty->assign("metaTitle", trim(strip_tags($title)));

if ($news[0]['contenidow'] != '') {
    $description = $news[0]['contenidow'];
} else {
    $description = $news[0]['contenido'];
}

$smarty->assign("metaDescription", trim(strip_tags($description)));

$smarty->assign("metaKeywords", trim(strip_tags($news[0]['keywords'])));


if (trim($news[0]['titulow']) != '') {
    $urlCom = $urlStart . '' . $urlStr['promociones']['url'] . '/' . $news[0]['id_nws'] . '/' . clean(trim($news[0]['titulow'])) . '/';
} else {
    $urlCom = $urlStart . '' . $urlStr['promociones']['url'] . '/' . $news[0]['id_nws'] . '/' . slug($news[0]['titulo']) . '/';
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . $urlCom;

$smarty->assign("metaURL", $url);


// REDIRECT NOTICIAS (COMENTAR PARA QUE EN LA URL SE VEA EL GET)
// if ($_SERVER['REQUEST_URI'] != $urlCom && $lang!='zh') {
//  header("HTTP/1.1 301 Moved Permanently");
//  header("Location: $urlCom");
// }

if (preg_match('/https?:\/\//', $news[0]['img'])) {
    $img = $news[0]['img'];
} else {
    $img = 'http://' . $_SERVER['HTTP_HOST'] . '/media/images/news/' . $news[0]['img'];
}

$smarty->assign("metaImage", $img);

$images = getRecords("

    SELECT id_img,
    imagen_img as image_img,
    alt_" . $lang . "_img as alt
    FROM news_fotos
    WHERE noticia_img = '" . simpleSanitize(($tokens[1])) . "' ORDER BY orden_img

");

$smarty->assign("images", $images);
$videos = getRecords("

    SELECT video_vid FROM news_videos WHERE news_vid = '" . simpleSanitize(($tokens[1])) . "' ORDER BY order_vid

");

$smarty->assign("videos", $videos);

$files = getRecords("

SELECT file_fil, id_fil, name_" . $lang . "_fil as name FROM  news_files WHERE  news_fil = '" . simpleSanitize(($tokens[1])) . "'  AND (lang_fil IS NULL OR lang_fil = '' OR lang_fil = '" . simpleSanitize(($lang)) . "') ORDER BY order_fil");

$smarty->assign("files", $files);

$features = getRecords("
SELECT CASE WHEN properties_features_priv.feature_".$lang."_feat IS NOT NULL THEN properties_features_priv.feature_".$lang."_feat ELSE features.feature_".$lang."_feat  END AS feat
   FROM promotions_promotions_feature INNER JOIN properties_features_priv features ON promotions_promotions_feature.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
   WHERE promotions_promotions_feature.promotion = '".simpleSanitize(($tokens[1]))."' ORDER BY feat ASC");

$smarty->assign("features", $features);

$tagsProm = getRecords("
    SELECT
    properties_tags.tag_" . $lang . "_tag as tag,
    properties_tags.id_tag,
    properties_tags.color_tag,
    properties_tags.text_color_tag
    FROM
    promotions_promotions_tag
    JOIN properties_tags
    ON promotions_promotions_tag.tag = properties_tags.id_tag
    WHERE
    promotions_promotions_tag.promotion = '" . simpleSanitize(($tokens[1])) . "'
");

$smarty->assign("tags", $tagsProm);

if (isset($_GET['date'])) {
    if ($_SESSION['formdate'] != $_GET['date']) {
        SmartyPaginate::reset();
    }
    $_SESSION['formdate'] = $_GET['date'];
}

if (!isset($_GET['p'])) {
    SmartyPaginate::reset();
}

SmartyPaginate::connect();

SmartyPaginate::setLimit(10);

SmartyPaginate::setPageLimit(4);

SmartyPaginate::setUrl(preg_replace('/[\&?\??]+p=[0-9]*/', '', $_SERVER['REQUEST_URI']));

SmartyPaginate::setUrlVar('p');

// @SmartyPaginate::setPrevText('&#8249;');
// @SmartyPaginate::setNextText('&#8250;');
@SmartyPaginate::setPrevText('<img src="/media/images/website/properties/pag-prev.svg" alt="Arrow Prev">');
@SmartyPaginate::setNextText('<img src="/media/images/website/properties/pag-next.svg" alt="Arrow Prev">');
@SmartyPaginate::setFirstText('&laquo;');
@SmartyPaginate::setLastText('&raquo;');

$cp = SmartyPaginate::getCurrentIndex();
$tp = SmartyPaginate::getLimit();

// ========= GET PROMOCIONES
function remove_querystring_var($url, $key)
{
    $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
    return $url;
}

if (isset($_GET['nu']) && is_numeric($_GET['nu'])) {

    setcookie('nu', $_GET['nu'], mktime(21, 00, 0, 12, 31, 2100), "/", "", 0);
    $url = remove_querystring_var("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "nu");
    if (substr($url, -1) == '?') {
        $url = str_replace("?", "", $url);
        header("Location: $url");
    }
    header("Location: $url");
}

if (isset($_COOKIE['nu']) && is_numeric($_COOKIE['nu']) && $_COOKIE['nu'] == '12') {

    SmartyPaginate::setLimit(12);
    $cp = SmartyPaginate::getCurrentIndex();
    $tp = SmartyPaginate::getLimit();
}

if (isset($_COOKIE['nu']) && is_numeric($_COOKIE['nu']) && $_COOKIE['nu'] == '24') {

    SmartyPaginate::setLimit(24);
    $cp = SmartyPaginate::getCurrentIndex();
    $tp = SmartyPaginate::getLimit();
}

if (isset($_COOKIE['nu']) && is_numeric($_COOKIE['nu']) && $_COOKIE['nu'] == '48') {

    SmartyPaginate::setLimit(48);
    $cp = SmartyPaginate::getCurrentIndex();
    $tp = SmartyPaginate::getLimit();
}

//  ============================================================================
//  === PRICE -> MINI SEARCH
//  ============================================================================

$prds = '';
if (isset($_GET['prds']) && $_GET['prds'] != '' && $_GET['prds'] != '0') {
    $prds = "AND preci_reducidoo_prop >= " . simpleSanitize(($_GET['prds']));
}

$prhs = '';
if (isset($_GET['prhs']) && $_GET['prhs'] != '' && $_GET['prhs'] != '0' && $_GET['prhs'] != '1000000') {
    $prhs = "AND preci_reducidoo_prop <= " . simpleSanitize(($_GET['prhs']));
}
if (isset($_GET['prhs']) && $_GET['prhs'] == '3000') {
    $prhs = "AND preci_reducidoo_prop <= 2000000000";
}

//  ============================================================================
//  === M2 PARCELA
//  ============================================================================

if (isset($_GET['m2pl']) && $_GET['m2pl'] == 0) {
    $m2pl = "AND 1=1";
} else if (isset($_GET['m2pl']) && $_GET['m2pl'] == 1) {
    $m2pl = "AND ((m2_parcela_prop <= 1000 AND m2_parcela_prop != 0))";
} else if (isset($_GET['m2pl']) && $_GET['m2pl'] == 2) {
    $m2pl = "AND ((m2_parcela_prop >= 1000 AND m2_parcela_prop <= 2000))";
} else if (isset($_GET['m2pl']) && $_GET['m2pl'] == 3) {
    $m2pl = "AND ((m2_parcela_prop >= 2000 AND m2_parcela_prop <= 5000))";
} else if (isset($_GET['m2pl']) && $_GET['m2pl'] == 4) {
    $m2pl = "AND ((m2_parcela_prop >= 5000 AND m2_parcela_prop <= 10000))";
} else if (isset($_GET['m2pl']) && $_GET['m2pl'] == 5) {
    $m2pl = "AND ((m2_parcela_prop >= 10000 AND m2_parcela_prop <= 20000))";
} else if (isset($_GET['m2pl']) && $_GET['m2pl'] == 6) {
    $m2pl = "AND ((m2_parcela_prop >= 20000))";
} else {
    $m2pl = "AND 1=1";
}

//  ============================================================================
//  === LOCATION -> MINI SEARCH
//  ============================================================================

$lo = '';
if (isset($_GET['lo']) && $_GET['lo'] != '') {
    $lo = "AND localidad_prop = " . simpleSanitize(($_GET['lo']));
}

//  ============================================================================
//  === REFERENCE
//  ============================================================================

$rf = '';
if (isset($_GET['rf']) && $_GET['rf'] != '') {
    $rf = "AND referencia_prop LIKE '%" . simpleSanitize(($_GET['rf'])) . "%'";
}

//  ============================================================================
//  === STATUS
//  ============================================================================

$st = '';
if (isset($_GET['st']) && $_GET['st'][0] != '') {
    $status = implode(',', $_GET['st']);
    if ($status != '') {
        $st = "AND operacion_prop  IN (" . simpleSanitize($status) . ")";
    }
}

//  ============================================================================
//  === COUNTRY
//  ============================================================================

$ctr = '';
if (isset($_GET['locun']) && $_GET['locun'] != '') {
    $country = implode(',', $_GET['locun']);
    if ($country != '') {
        $ctr = "AND properties_loc1.id_loc1  IN (" . simpleSanitize($country) . ")";
    }
}

//  ============================================================================
//  === PROVINCE
//  ============================================================================

$lopr = '';
if (isset($_GET['lopr']) && $_GET['lopr'] != '') {
    $province = implode(',', $_GET['lopr']);
    if ($province != '') {
        $lopr = "AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (" . simpleSanitize($province) . ")";
    }
}

//  ============================================================================
//  === COAST
//  ============================================================================

$coast = '';
if (isset($_GET['coast']) && $_GET['coast'] != '') {
    $location = implode(',', $_GET['coast']);
    if ($location != '') {
        $coast = "AND CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END IN (" . simpleSanitize($location) . ")";
    }
}

//  ============================================================================
//  === CITY
//  ============================================================================

$loct = '';
if (isset($_GET['loct']) && $_GET['loct'] != '') {
    $location = implode(',', $_GET['loct']);
    if ($location != '') {
        $loct = "AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (" . simpleSanitize($location) . ")";
    }
}

//  ============================================================================
//  === ZONE
//  ============================================================================

$lozn = '';
if (isset($_GET['lozn']) && $_GET['lozn'] != '') {
    $zone = implode(',', $_GET['lozn']);
    if ($zone != '') {
        $lozn = "AND CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END IN (" . simpleSanitize($zone) . ")";
    }
}

//  ============================================================================
//  === LOCATION
//  ============================================================================

$lc = '';
if (isset($_GET['lc']) && $_GET['lc'] != '') {
    $location = implode(',', $_GET['lc']);
    if ($location != '') {
        $lc = "AND CASE WHEN properties_towns.id_twn IS NOT NULL THEN properties_towns.id_twn ELSE towns.id_twn  END IN (" . simpleSanitize($location) . ")";
    }
}

//  ============================================================================
//  === TYPE
//  ============================================================================

$typ = '';
if (isset($_GET['tp']) && $_GET['tp'] != '') {
    $type = implode(',', $_GET['tp']);
    if ($type  != '') {
        $typ = "AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . simpleSanitize($type) . ")";
    }
}

//  ============================================================================
//  === BEDROOMS
//  ============================================================================

$bd = '';
if (isset($_GET['bd']) && $_GET['bd'] != '') {
    $bd = "AND habitaciones_prop >= " . simpleSanitize(($_GET['bd']));
}

//  ============================================================================
//  === BEDROOMS
//  ============================================================================

$bt = '';
if (isset($_GET['bt']) && $_GET['bt'] != '') {
    $bt = "AND aseos_prop >= " . simpleSanitize(($_GET['bt']));
}

//  ============================================================================
//  === PRICE REDUCED
//  ============================================================================

$rp = '';
if (isset($_GET['rp']) && $_GET['rp'] != '') {
    $rp = "AND reducido_prop = 1";
}

//  ============================================================================
//  === NEW
//  ============================================================================

$nw = '';
if (isset($_GET['nw']) && $_GET['nw'] == 1) {
    $nw = "AND nuevo_prop >= CURDATE()";
}

//  ============================================================================
//  === CLOSE TO SEA
//  ============================================================================

$cs = '';
if (isset($_GET['cs']) && $_GET['cs'] != '') {
    $cs = "AND cerca_mar_prop = " . simpleSanitize(($_GET['cs']));
}

//  ============================================================================
//  === SEAVIEWS
//  ============================================================================

$sw = '';
if (isset($_GET['sw']) && $_GET['sw'] != '') {
    $sw = "AND vistas_mar_prop = " . simpleSanitize(($_GET['sw']));
}

//  ============================================================================
//  === EXCLUSIVE PROPERTIES
//  ============================================================================

$ep = '';
if (isset($_GET['ep']) && $_GET['ep'] != '') {
    $ep = "AND exclusivo_prop = " . simpleSanitize(($_GET['ep']));
}

//  ============================================================================
//  === POOL
//  ============================================================================

$po = '';
if (isset($_GET['pool']) && $_GET['pool'] == 1) {
    // Se añaden en piscina, las features commnunal pool + private pool
    $po = "AND (piscina_prop IS NOT NULL AND piscina_prop != 0)";
}

//  ============================================================================
//  === REPOSSESSION
//  ============================================================================

$rps = '';
if (isset($_GET['rps']) && $_GET['rps'] != '') {
    $rps = "AND embargo_prop = " . simpleSanitize(($_GET['rps']));
}

//  ============================================================================
//  === ORIENTACIÓN
//  ============================================================================

$or = '';
if (isset($_GET['or']) && $_GET['or'] != '') {
    $or = "AND orientacion_prop = '" . simpleSanitize(($_GET['or'])) . "'";
}

//  ============================================================================
//  === VENDIDO
//  ============================================================================

$ven = '';

if (isset($_GET['ven']) && $_GET['ven'] != '' || $url_ven) {
    if (!$url_ven) {
        $url_ven = simpleSanitize(($_GET['ven']));
    }

    $ven = "AND vendido_prop = " . $url_ven . "";
}
//  ============================================================================
//  === ACTIVADO
//  ============================================================================

$secc = 'activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1';

//  ============================================================================
//  === FEATURES
//  ============================================================================

$features = '';
if (isset($_GET['features']) && $_GET['features'][0] != '') {

    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsfeats = "SELECT GROUP_CONCAT(property) AS ids FROM properties_property_feature WHERE feature IN (" . implode(',', $_GET['features']) . ")";
    $rsfeats = mysql_query($query_rsfeats, $inmoconn) or die(mysql_error());
    $row_rsfeats = mysql_fetch_assoc($rsfeats);
    $totalRows_rsfeats = mysql_num_rows($rsfeats);

    if ($totalRows_rsfeats > 0) {
        $features = "AND id_prop IN (" . $row_rsfeats['ids'] . ")";
    }
}

//  ============================================================================
//  === ORDER
//  ============================================================================

$o = " ORDER BY IF (precio = 0, 1, 0), precio ASC";
if (isset($_GET['o']) && is_numeric($_GET['o'])) {

    setcookie('o', $_GET['o'], mktime(21, 00, 0, 12, 31, 2100), "/", "", 0);
    $url = remove_querystring_var("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "o");
    if (substr($url, -1) == '?') {
        $url = str_replace("?", "", $url);
        header("Location: $url");
    }
    header("Location: $url");
}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '1') {

    $o = " ORDER BY IF (precio = 0, 1, 0), precio ASC";
}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '2') {

    $o = " ORDER BY precio DESC";
}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '3') {

    $o = " ORDER BY id_prop DESC";
}

// ========= FIN GET PROMOCIONES

$whereSQL = "";

// if ($news[0]['quick_location_nws'] != '') {
//     $whereSQL .= "AND (CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END) = '".simpleSanitize(($news[0]['quick_location_nws']))."'";
// }

// if ($news[0]['quick_town_nws'] != '') {
//     $whereSQL .= "AND (CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END) = '".simpleSanitize(($news[0]['quick_town_nws']))."'";
// }

// if ($news[0]['quick_province_nws'] != '') {
//     $whereSQL .= "AND (CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END) = '".simpleSanitize(($news[0]['quick_province_nws']))."'";
// }

// if ($news[0]['quick_type_nws'] != '') {
//     $whereSQL .= "AND (CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END) = '".simpleSanitize(($news[0]['quick_type_nws']))."'";
// }

// if ($news[0]['quick_status_nws'] != '') {
//     $whereSQL .= "AND (operacion_prop) = '".simpleSanitize(($news[0]['quick_status_nws']))."'";
// }


$similares = getRecords("

SELECT

    properties_loc1.name_" . $lang . "_loc1 AS country,
    CASE WHEN properties_loc2.name_" . $lang . "_loc2 IS NOT NULL THEN properties_loc2.name_" . $lang . "_loc2 ELSE province1.name_" . $lang . "_loc2  END AS province,
    CASE WHEN properties_loc3.name_" . $lang . "_loc3 IS NOT NULL THEN properties_loc3.name_" . $lang . "_loc3 ELSE areas1.name_" . $lang . "_loc3  END AS area,
    CASE WHEN properties_loc4.name_" . $lang . "_loc4 IS NOT NULL THEN properties_loc4.name_" . $lang . "_loc4 ELSE towns.name_" . $lang . "_loc4  END AS town,
    CASE WHEN properties_types.types_" . $lang . "_typ IS NOT NULL THEN properties_types.types_" . $lang . "_typ ELSE types.types_" . $lang . "_typ END AS type,
    properties_properties.lat_long_gp_prop AS lat,
    properties_status.status_" . $lang . "_sta as sale,
    properties_status.id_sta as saleId,
    properties_status.id_sta,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.construccion_prop,
    properties_properties.ascensor_prop,
    properties_properties.energia_prop,
    precio_1_prop,
    precio_2_prop,
    precio_3_prop,
    precio_4_prop,
    precio_5_prop,
    precio_6_prop,
    precio_7_prop,
    precio_8_prop,
    precio_9_prop,
    precio_10_prop,
    precio_11_prop,
    precio_12_prop,
    entraga_date_prop,
    id_prop,
    id_img,
    alt_" . $lang . "_img as alt,
    properties_properties.descripcion_" . $lang . "_prop as descr,
    title_" . $lang . "_prop as metatitle,
    titulo_" . $lang . "_prop as titulo,
    description_" . $lang . "_prop as metadescription,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_" . $lang . "_pl FROM properties_pool WHERE id_pl = piscina_prop  LIMIT 1) AS piscina_prop,
    (SELECT parking_" . $lang . "_prk FROM properties_parking WHERE id_prk = parking_prop  LIMIT 1) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    (SELECT file_fil FROM properties_files WHERE property_fil = id_prop AND (lang_fil IS NULL OR lang_fil = '' OR lang_fil = '" . $lang . "') LIMIT 1) AS descarga,
    (SELECT image_img FROM properties_planos WHERE property_img = id_prop LIMIT 1) AS descarga,
    (SELECT count(*) FROM properties_images WHERE properties_properties.id_prop = properties_images.property_img) as total_images
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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1 AND promocion_prop = " . simpleSanitize(($tokens[1])) . "

$whereSQL

AND

$secc

$pdh $p $lo $rf $ar $lc $typ $bd $bt $rp $nw $cs $sw $ep $po $cos $inl $rps $st $ven $alq $res $asc $m2ut $m2pl $ctr $lopr $loct $lozn $or $golf $prds $prhs  $features  $coast

GROUP BY id_prop

ORDER BY id_prop

LIMIT $cp, $tp

");

foreach ($similares as $key => $value) {

    if (!$value) {
        continue;
    }

    $theFavsDB = getRecords("
    SELECT COUNT(id) AS num_favorites
    FROM users_favorites
    WHERE user = '" . stripslashes(mysqli_real_escape_string($inmoconn, $_SESSION['kt_login_id'])) . "'
    AND property = '" . stripslashes(mysqli_real_escape_string($inmoconn, $similares[$key]['id_prop'])) . "'
    ");

    $theFavs = explode(",", $_COOKIE['fav']);

    if (in_array($similares[$key]['id_prop'], $theFavs) || $theFavsDB[0]['num_favorites'] == 1) {
        $favVal = 1;
    } else {
        $favVal = 0;
    }

    array_push($similares[$key], array('favorito' => $favVal));

    savelogprop($similares[$key]['id_prop'], '1');
}

foreach ($similares as $key => $value) {

    if (!$value) {
        continue;
    }
    
    $planos = getRecords("
    SELECT
    id_img,
    image_img
    FROM properties_planos
    LEFT JOIN properties_properties ON id_prop = property_img
    WHERE id_prop = " . stripslashes(mysqli_real_escape_string($inmoconn, $similares[$key]['id_prop'])) . "
    ORDER BY order_img;
    ");

    if ($planos[0]['image_img'] != '') {
        array_push($similares[$key], array('planos' => $planos));
    }
}

$smarty->assign("similares", $similares);

$showSimils = 0;
if ($news[0]['quick_location_nws'] != '' || $news[0]['quick_province_nws'] != '' || $news[0]['quick_town_nws'] != '' || $news[0]['quick_type_nws'] != '' || $news[0]['quick_status_nws'] != '') {
    $showSimils = 1;
}
$smarty->assign("showSimils", $showSimils);


$_query = "

SELECT

    id_prop


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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = " . simpleSanitize(($tokens[1])) . "

$whereSQL

AND

$secc

$pdh $p $lo $rf $ar $lc $typ $bd $bt $rp $nw $cs $sw $ep $po $cos $inl $rps $st $ven $alq $res $asc $m2ut $m2pl $ctr $lopr $loct $lozn $or $golf $prds $prhs $tags $features  $coast


GROUP BY id_prop

";


$_result = mysqli_query($inmoconn, $_query);
$_row = mysqli_fetch_array($_result, MYSQLI_ASSOC);
$totalRows = mysqli_num_rows($_result);

SmartyPaginate::setTotal($totalRows);

mysqli_free_result($_result);

$smarty->assign("totalprops", $totalRows);

SmartyPaginate::assign($smarty);


$precioReferencia = getRecords("

SELECT

    MIN(preci_reducidoo_prop) as precio_desde,
    MIN(m2_utiles_prop) as m2_min,
    MAX(m2_utiles_prop) as m2_max,
    MIN(m2_prop) as m2b_min,
    MAX(m2_prop) as m2b_max,
    MIN(habitaciones_prop) as beds_min,
    MAX(habitaciones_prop) as beds_max,
    MIN(aseos_prop) as baths_min,
    MAX(aseos_prop) as baths_max,
    (SELECT pool_" . $lang . "_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_" . $lang . "_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    lat_long_gp_prop,
    zoom_gp_prop,
    id_prop

    FROM properties_properties

    WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = " . simpleSanitize(($tokens[1])) . "

LIMIT 1

");

if ($precioReferencia[0]['precio_desde']) {
    $smarty->assign("precioReferencia", $precioReferencia[0]['precio_desde']);
}

if ($precioReferencia[0]['lat_long_gp_prop']) {
    $smarty->assign("localizacionReferencia", $precioReferencia[0]['lat_long_gp_prop']);
}
if ($precioReferencia[0]['zoom_gp_prop']) {
    $smarty->assign("zoomReferencia", $precioReferencia[0]['zoom_gp_prop']);
}

$smarty->assign("precioReferenciaVals", $precioReferencia);