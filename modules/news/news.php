<?php

$langQuery = '';

foreach ($languages as $key => $value) {
    $langQuery .= "news_categories.category_" . $value . "_ct as cat_" . $value . ", ";
}

$newsURLs = null;
if (isset($tokens[2])) {
    $newsURLs = getRecords("

SELECT news_categories.id_ct,
    " . $langQuery . "
    news_categories.parent_ct
FROM news_categories
WHERE id_ct = '" . simpleSanitize(($tokens[2])) . "'
ORDER BY news_categories.orden_ct ASC

");
}


$urlDefault =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category'][$language] . '/', $urlDefault);
if (isset($tokens[1]) && isset($urlStr['category']['ca'])) $urlCA =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['ca'] . '/', $urlCA);
if (isset($tokens[1]) && isset($urlStr['category']['da'])) $urlDA =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['da'] . '/', $urlDA);
if (isset($tokens[1]) && isset($urlStr['category']['de'])) $urlDE =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['de'] . '/', $urlDE);
if (isset($tokens[1]) && isset($urlStr['category']['el'])) $urlEL =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['el'] . '/', $urlEL);
if (isset($tokens[1]) && isset($urlStr['category']['en'])) $urlEN =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['en'] . '/', $urlEN);
if (isset($tokens[1]) && isset($urlStr['category']['es'])) $urlES =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['es'] . '/', $urlES);
if (isset($tokens[1]) && isset($urlStr['category']['fi'])) $urlFI =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['fi'] . '/', $urlFI);
if (isset($tokens[1]) && isset($urlStr['category']['fr'])) $urlFR =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['fr'] . '/', $urlFR);
if (isset($tokens[1]) && isset($urlStr['category']['is'])) $urlIS =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['is'] . '/', $urlIS);
if (isset($tokens[1]) && isset($urlStr['category']['it'])) $urlIT =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['it'] . '/', $urlIT);
if (isset($tokens[1]) && isset($urlStr['category']['nl'])) $urlNL =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['nl'] . '/', $urlNL);
if (isset($tokens[1]) && isset($urlStr['category']['no'])) $urlNO =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['no'] . '/', $urlNO);
if (isset($tokens[1]) && isset($urlStr['category']['pt'])) $urlPT =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['pt'] . '/', $urlPT);
if (isset($tokens[1]) && isset($urlStr['category']['ru'])) $urlRU =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['ru'] . '/', $urlRU);
if (isset($tokens[1]) && isset($urlStr['category']['se'])) $urlSE =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['se'] . '/', $urlSE);
if (isset($tokens[1]) && isset($urlStr['category']['zh'])) $urlZH =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['zh'] . '/', $urlZH);
if (isset($tokens[1]) && isset($urlStr['category']['pl'])) $urlPL =  preg_replace('/\/' . $tokens[1] . '\//', '/' . $urlStr['category']['pl'] . '/', $urlPL);


if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_' . $language])) $urlDefault =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_' . $language]) . '/', $urlDefault);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_ca'])) $urlCA =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_ca']) . '/', $urlCA);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_da'])) $urlDA =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_da']) . '/', $urlDA);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_de'])) $urlDE =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_de']) . '/', $urlDE);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_el'])) $urlEL =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_el']) . '/', $urlEL);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_en'])) $urlEN =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_en']) . '/', $urlEN);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_es'])) $urlES =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_es']) . '/', $urlES);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_fi'])) $urlFI =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_fi']) . '/', $urlFI);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_fr'])) $urlFR =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_fr']) . '/', $urlFR);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_is'])) $urlIS =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_is']) . '/', $urlIS);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_it'])) $urlIT =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_it']) . '/', $urlIT);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_nl'])) $urlNL =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_nl']) . '/', $urlNL);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_no'])) $urlNO =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_no']) . '/', $urlNO);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_pt'])) $urlPT =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_pt']) . '/', $urlPT);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_ru'])) $urlRU =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_ru']) . '/', $urlRU);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_se'])) $urlSE =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_se']) . '/', $urlSE);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_zh'])) $urlZH =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_zh']) . '/', $urlZH);
if (isset($newsURLs[0]['cat_' . $lang]) && isset($newsURLs[0]['cat_pl'])) $urlPL =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_pl']) . '/', $urlPL);

if (isset($newsURLs[0]['parent_ct']) && $newsURLs[0]['parent_ct'] != '') {
    replaceParet($newsURLs[0]['parent_ct']);
}

function replaceParet($parent)
{

    global $languages, $language, $lang, $urlDefault, $urlDA, $urlDE, $urlEL, $urlEN, $urlES, $urlFI, $urlFR, $urlIS, $urlIT, $urlNL, $urlNO, $urlPT, $urlRU, $urlSE, $urlZH;

    $langQuery = '';

    foreach ($languages as $key => $value) {

        $langQuery .= "news_categories.category_" . $value . "_ct as cat_" . $value . ", ";
    }

    $newsURLs = getRecords("

    SELECT news_categories.id_ct,
        " . $langQuery . "
        news_categories.parent_ct
    FROM news_categories
    WHERE id_ct = '" . simpleSanitize(($parent)) . "'
    ORDER BY news_categories.orden_ct ASC

    ");

    $urlDefault =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_' . $language]) . '/', $urlDefault);
    $urlCA =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_ca']) . '/', $urlCA);
    $urlDA =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_da']) . '/', $urlDA);
    $urlDE =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_de']) . '/', $urlDE);
    $urlEL =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_el']) . '/', $urlEL);
    $urlEN =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_en']) . '/', $urlEN);
    $urlES =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_es']) . '/', $urlES);
    $urlFI =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_fi']) . '/', $urlFI);
    $urlFR =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_fr']) . '/', $urlFR);
    $urlIS =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_is']) . '/', $urlIS);
    $urlIT =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_it']) . '/', $urlIT);
    $urlNL =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_nl']) . '/', $urlNL);
    $urlNO =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_no']) . '/', $urlNO);
    $urlPT =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_pt']) . '/', $urlPT);
    $urlRU =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_ru']) . '/', $urlRU);
    $urlSE =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_se']) . '/', $urlSE);
    $urlZH =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_zh']) . '/', $urlZH);
    $urlPL =  preg_replace('/\/' . slug($newsURLs[0]['cat_' . $lang]) . '\//', '/' . slug($newsURLs[0]['cat_pl']) . '/', $urlPL);

    if ($newsURLs[0]['parent_ct'] != '') {
        replaceParet($newsURLs[0]['parent_ct']);
    }
}

$smarty->assign('urlDefault', $urlDefault);
$smarty->assign('urlCA', $urlCA);
$smarty->assign('urlDA', $urlDA);
$smarty->assign('urlDE', $urlDE);
if (isset($urlEL))
    $smarty->assign('urlEL', $urlEL);
$smarty->assign('urlEN', $urlEN);
$smarty->assign('urlES', $urlES);
$smarty->assign('urlFI', $urlFI);
$smarty->assign('urlFR', $urlFR);
$smarty->assign('urlIS', $urlIS);
if (isset($urlIT))
    $smarty->assign('urlIT', $urlIT);
$smarty->assign('urlNL', $urlNL);
$smarty->assign('urlNO', $urlNO);
if (isset($urlPT))
    $smarty->assign('urlPT', $urlPT);
$smarty->assign('urlRU', $urlRU);
$smarty->assign('urlSE', $urlSE);
$smarty->assign('urlZH', $urlZH);
$smarty->assign('urlPL', $urlPL);

$url = preg_replace('/\&?\??p=[0-9]*/', '', $_SERVER['REQUEST_URI']);

SmartyPaginate::connect();
if (!isset($_GET['p'])) {
    SmartyPaginate::reset();
}
SmartyPaginate::setLimit(5);
SmartyPaginate::setPageLimit(10);
SmartyPaginate::setUrl($url);
SmartyPaginate::setUrlVar('p');

@SmartyPaginate::setPrevText('&#8249;');
@SmartyPaginate::setNextText('&#8250;');
@SmartyPaginate::setFirstText('&laquo;');
@SmartyPaginate::setLastText('&raquo;');

$cp = SmartyPaginate::getCurrentIndex();
$tp = SmartyPaginate::getLimit();

function GetChildsIds($par)
{

    if ($par != '') {
        $ret = '';

        $categories = getRecords("
        SELECT news_categories.id_ct
        FROM news_categories
        WHERE type_ct = 1  AND parent_ct = '" . simpleSanitize(($par)) . "'
        ORDER BY news_categories.orden_ct ASC
        ");

        if (isset($categories[0]['id_ct']) && $categories[0]['id_ct'] != '') {
            foreach ($categories as $value) {
                $ret .= $value['id_ct'] . ',';
                $ret .= GetChildsIds($value['id_ct']);
            }
        }
    }

    return $ret;
}


$ct = '';
if (isset($tokens[2]) && $tokens[2] != '') {

    $news = getRecords("
    SELECT new
    FROM news_news_categories
    WHERE cat IN (" . GetChildsIds($tokens[2]) . simpleSanitize(($tokens[2])) . ")
    ");

    $ret = array();

    if ($news[0]['new'] != '') {
        foreach ($news as $value) {
            array_push($ret, $value['new']);
        }
    }

    if (!empty($ret)) {
        $ct = 'AND id_nws IN(' . implode(',', $ret) . ')';
    } else {
        $ct = 'AND id_nws IN(-1)';
    }

    $category = getRecords("
    SELECT
    descripcion_" . $lang . "_ct AS desccat,
    title_" . $lang . "_ct AS titseo,
    description_" . $lang . "_ct AS descseo,
    keywords_" . $lang . "_ct AS keyseo
    FROM news_categories
    WHERE id_ct = '" . simpleSanitize(($tokens[2])) . "'
    ");

    if ($category[0]['desccat']) {
        $smarty->assign("pagetext", $category[0]['desccat']);
    }

    if ($category[0]['titseo']) {
        $smarty->assign("metaTitle", trim(strip_tags($category[0]['titseo'])));
    }

    if ($category[0]['descseo']) {
        $smarty->assign("metaDescription", trim(strip_tags($category[0]['descseo'])));
    }

    if ($category[0]['keyseo']) {
        $smarty->assign("metaKeywords", trim(strip_tags($category[0]['keyseo'])));
    }
}

$tgs = '';
if ($tokens[1] != '' && $tokens[2] == '') {
    $str_tag = str_replace("-", " ", $tokens[1]);

    $tgs = " AND FIND_IN_SET('" . $str_tag . "', tags_" . $lang . "_nws)";

    $urlDefault =  $urlStart . $urlStr['news']['url'];
    $urlCA =  $urlStart . $urlStr['news']['url'];
    $urlDA =  $urlStart . $urlStr['news']['url'];
    $urlDE =  $urlStart . $urlStr['news']['url'];
    $urlEL =  $urlStart . $urlStr['news']['url'];
    $urlEN =  $urlStart . $urlStr['news']['url'];
    $urlES =  $urlStart . $urlStr['news']['url'];
    $urlFI =  $urlStart . $urlStr['news']['url'];
    $urlFR =  $urlStart . $urlStr['news']['url'];
    $urlIS =  $urlStart . $urlStr['news']['url'];
    $urlIT =  $urlStart . $urlStr['news']['url'];
    $urlNL =  $urlStart . $urlStr['news']['url'];
    $urlNO =  $urlStart . $urlStr['news']['url'];
    $urlPT =  $urlStart . $urlStr['news']['url'];
    $urlRU =  $urlStart . $urlStr['news']['url'];
    $urlSE =  $urlStart . $urlStr['news']['url'];
    $urlZH =  $urlStart . $urlStr['news']['url'];
    $urlPL =  $urlStart . $urlStr['news']['url'];

    $smarty->assign('urlDefault', $urlDefault);
    $smarty->assign('urlCA', $urlCA);
    $smarty->assign('urlDA', $urlDA);
    $smarty->assign('urlDE', $urlDE);
    $smarty->assign('urlEL', $urlEL);
    $smarty->assign('urlEN', $urlEN);
    $smarty->assign('urlES', $urlES);
    $smarty->assign('urlFI', $urlFI);
    $smarty->assign('urlFR', $urlFR);
    $smarty->assign('urlIS', $urlIS);
    $smarty->assign('urlIT', $urlIT);
    $smarty->assign('urlNL', $urlNL);
    $smarty->assign('urlNO', $urlNO);
    $smarty->assign('urlPT', $urlPT);
    $smarty->assign('urlRU', $urlRU);
    $smarty->assign('urlSE', $urlSE);
    $smarty->assign('urlZH', $urlZH);
    $smarty->assign('urlPL', $urlPL);
}


$searchFull = '';
$titleNews = '';
if ((isset($_GET['ter'])) && ($_GET['ter'] != '')) {
    $searchTerm = $_GET['ter'];
    $titleNews = $langStr["Resultado de busqueda"] . ' "' . $searchTerm . '"';
    // Asegúrate de escapar la variable antes de usarla en la consulta
    $searchTerm = mysqli_real_escape_string($inmoconn, simpleSanitize($searchTerm));
    $searchFull = " AND MATCH(news.title_" . $lang . "_nws, news.content_" . $lang . "_nws, news.tags_" . $lang . "_nws) AGAINST(' $searchTerm ' IN NATURAL LANGUAGE MODE)";
}

$query = "
    SELECT 
        news.id_nws,
        news.title_" . $lang . "_nws as titulo,
        news.titlew_" . $lang . "_nws as titulometa,
        news.content_" . $lang . "_nws as contenido,
        news.tags_" . $lang . "_nws as tags,
        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
        (SELECT alt_" . $lang . "_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt,
        GROUP_CONCAT(news_categories.category_" . $lang . "_ct SEPARATOR ', ') as categorias
    FROM news
    LEFT JOIN news_news_categories
        ON news.id_nws = news_news_categories.new
    LEFT JOIN news_categories
        ON news_news_categories.cat = news_categories.id_ct
    WHERE 
        news.title_" . $lang . "_nws  != '' 
        AND news.content_" . $lang . "_nws != '' 
        AND type_nws = 1 
        AND activate_nws = 1
        " . $searchFull . "
        $ct
    GROUP BY id_nws
    ORDER BY news.date_nws DESC
    LIMIT $cp, $tp;
";

$news = getRecords($query);

$smarty->assign("titleNews", $titleNews);
$smarty->assign("news", $news);

if (preg_match('/https?:\/\//', $pages[0]['img'])) {
    $img = $pages[0]['img'];
} else {
    $img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/' . $pages[0]['img'];
}
if ($img == 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/') {
    $img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/website/no-image.png';
}
$smarty->assign("metaImage", $img);

$_query = "

        SELECT news.id_nws

        FROM news

         LEFT JOIN news_news_categories
            ON news.id_nws = news_news_categories.new
        LEFT JOIN news_categories
            ON news_news_categories.cat = news_categories.id_ct

        WHERE news.title_" . $lang . "_nws  != '' AND news.content_" . $lang . "_nws != '' AND type_nws = 1 AND activate_nws = 1
        " . $searchFull . "
        $tgs

        $ct
";
$_result = mysqli_query($inmoconn, $_query);
$_row = mysqli_fetch_array($_result, MYSQLI_ASSOC);
$totalRows = mysqli_num_rows($_result);

SmartyPaginate::setTotal($totalRows);

mysqli_free_result($_result);

$smarty->assign("totalprops", $totalRows);

SmartyPaginate::assign($smarty);
