<?php

$langQuery = '';

foreach ($languages as $key => $value) {

    $langQuery .= "news_categories.category_".$value."_ct as cat_".$value.", ";

}

$newsURLs = getRecords("

SELECT news_categories.id_ct,
    ".$langQuery."
    news_categories.parent_ct
FROM news_categories
WHERE id_ct = '".simpleSanitize(($tokens[2]))."'
ORDER BY news_categories.orden_ct ASC

");





$urlDefault =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category'][$language] . '/', $urlDefault);
$urlCA =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['ca'] . '/', $urlCA);
$urlDA =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['da'] . '/', $urlDA);
$urlDE =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['de'] . '/', $urlDE);
$urlEL =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['el'] . '/', $urlEL);
$urlEN =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['en'] . '/', $urlEN);
$urlES =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['es'] . '/', $urlES);
$urlFI =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['fi'] . '/', $urlFI);
$urlFR =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['fr'] . '/', $urlFR);
$urlHU =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['hu'] . '/', $urlHU);
$urlIS =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['is'] . '/', $urlIS);
$urlIT =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['it'] . '/', $urlIT);
$urlNL =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['nl'] . '/', $urlNL);
$urlNO =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['no'] . '/', $urlNO);
$urlPT =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['pt'] . '/', $urlPT);
$urlRU =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['ru'] . '/', $urlRU);
$urlSE =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['se'] . '/', $urlSE);
$urlZH =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['zh'] . '/', $urlZH);
$urlPL =  preg_replace('/\/'.$tokens[1].'\//', '/' . $urlStr['category']['pl'] . '/', $urlPL);


$urlDefault =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_' . $language]) . '/', $urlDefault);
$urlCA =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_ca']) . '/', $urlCA);
$urlDA =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_da']) . '/', $urlDA);
$urlDE =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_de']) . '/', $urlDE);
$urlEL =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_el']) . '/', $urlEL);
$urlEN =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_en']) . '/', $urlEN);
$urlES =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_es']) . '/', $urlES);
$urlFI =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_fi']) . '/', $urlFI);
$urlFR =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_fr']) . '/', $urlFR);
$urlHU =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_hu']) . '/', $urlHU);
$urlIS =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_is']) . '/', $urlIS);
$urlIT =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_it']) . '/', $urlIT);
$urlNL =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_nl']) . '/', $urlNL);
$urlNO =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_no']) . '/', $urlNO);
$urlPT =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_pt']) . '/', $urlPT);
$urlRU =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_ru']) . '/', $urlRU);
$urlSE =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_se']) . '/', $urlSE);
$urlZH =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_zh']) . '/', $urlZH);
$urlPL =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_pl']) . '/', $urlPL);

if ($newsURLs[0]['parent_ct'] != '') {
    replaceParet($newsURLs[0]['parent_ct']);
}

function replaceParet($parent) {

    global $languages, $language, $lang, $urlDefault, $urlDA, $urlDE, $urlEL, $urlEN, $urlES, $urlFI, $urlFR, $urlHU, $urlIS, $urlIT, $urlNL, $urlNO, $urlPT, $urlRU, $urlSE, $urlZH;

    $langQuery = '';

    foreach ($languages as $key => $value) {

        $langQuery .= "news_categories.category_".$value."_ct as cat_".$value.", ";

    }

    $newsURLs = getRecords("

    SELECT news_categories.id_ct,
        ".$langQuery."
        news_categories.parent_ct
    FROM news_categories
    WHERE id_ct = '".simpleSanitize(($parent))."'
    ORDER BY news_categories.orden_ct ASC

    ");

    $urlDefault =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_' . $language]) . '/', $urlDefault);
    $urlCA =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_ca']) . '/', $urlCA);
    $urlDA =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_da']) . '/', $urlDA);
    $urlDE =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_de']) . '/', $urlDE);
    $urlEL =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_el']) . '/', $urlEL);
    $urlEN =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_en']) . '/', $urlEN);
    $urlES =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_es']) . '/', $urlES);
    $urlFI =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_fi']) . '/', $urlFI);
    $urlFR =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_fr']) . '/', $urlFR);
    $urlHU =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_hu']) . '/', $urlHU);
    $urlIS =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_is']) . '/', $urlIS);
    $urlIT =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_it']) . '/', $urlIT);
    $urlNL =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_nl']) . '/', $urlNL);
    $urlNO =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_no']) . '/', $urlNO);
    $urlPT =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_pt']) . '/', $urlPT);
    $urlRU =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_ru']) . '/', $urlRU);
    $urlSE =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_se']) . '/', $urlSE);
    $urlZH =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_zh']) . '/', $urlZH);
    $urlPL =  preg_replace('/\/'.slug($newsURLs[0]['cat_' . $lang]).'\//', '/' . slug($newsURLs[0]['cat_pl']) . '/', $urlPL);

    if ($newsURLs[0]['parent_ct'] != '') {
        replaceParet($newsURLs[0]['parent_ct']);
    }

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


SmartyPaginate::connect();

if (!isset($_GET['p'])) {
    SmartyPaginate::reset();
}
SmartyPaginate::setLimit(6);

SmartyPaginate::setPageLimit(10);

SmartyPaginate::setUrl(preg_replace('/\&?\??p=[0-9]*/', '', $_SERVER['REQUEST_URI']));

SmartyPaginate::setUrlVar('p');


@SmartyPaginate::setPrevText('<i class="fa fa-caret-left"></i>');
@SmartyPaginate::setNextText('<i class="fa fa-caret-right"></i>');
@SmartyPaginate::setFirstText('&laquo;');
@SmartyPaginate::setLastText('&raquo;');

$cp = SmartyPaginate::getCurrentIndex();
$tp = SmartyPaginate::getLimit();

function GetChildsIds($par) {

    if ($par != '') {
        $ret = '';

        $categories = getRecords("
        SELECT news_categories.id_ct
        FROM news_categories
        WHERE type_ct = 1  AND parent_ct = '" . simpleSanitize(($par)) . "'
        ORDER BY news_categories.orden_ct ASC
        ");

        if ($categories[0]['id_ct'] != '') {
            foreach ($categories as $value) {
                $ret .= $value['id_ct'] . ',';
                $ret .= GetChildsIds($value['id_ct']);
            }
        }
    }

    return $ret;

}


$ct = '';
if( isset($tokens[2]) && $tokens[2] != '' ){

    $news = getRecords("
    SELECT new
    FROM news_news_categories
    WHERE cat IN (" . GetChildsIds($tokens[2]) . simpleSanitize(($tokens[2])) . ")
    ");

    $ret = array();

    if ($news[0]['new'] != '') {
        foreach ($news as $value) {
            array_push($ret, $value['new'] );
        }
    }

    if (!empty($ret)) {
        $ct = 'AND id_nws IN(' . implode(',', $ret) . ')';
    } else {
        $ct = 'AND id_nws IN(-1)';
    }

    $category = getRecords("
    SELECT
    descripcion_".$lang."_ct AS desccat,
    title_".$lang."_ct AS titseo,
    description_".$lang."_ct AS descseo,
    keywords_".$lang."_ct AS keyseo
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
    $tgs = " AND FIND_IN_SET('" . $tokens[1] . "', tags_".$lang."_nws)";

    $urlDefault =  $urlStart. $urlStr['news']['url'];
    $urlCA =  $urlStart. $urlStr['news']['url'];
    $urlDA =  $urlStart. $urlStr['news']['url'];
    $urlDE =  $urlStart. $urlStr['news']['url'];
    $urlEL =  $urlStart. $urlStr['news']['url'];
    $urlEN =  $urlStart. $urlStr['news']['url'];
    $urlES =  $urlStart. $urlStr['news']['url'];
    $urlFI =  $urlStart. $urlStr['news']['url'];
    $urlFR =  $urlStart. $urlStr['news']['url'];
    $urlHU =  $urlStart. $urlStr['news']['url'];
    $urlIS =  $urlStart. $urlStr['news']['url'];
    $urlIT =  $urlStart. $urlStr['news']['url'];
    $urlNL =  $urlStart. $urlStr['news']['url'];
    $urlNO =  $urlStart. $urlStr['news']['url'];
    $urlPT =  $urlStart. $urlStr['news']['url'];
    $urlRU =  $urlStart. $urlStr['news']['url'];
    $urlSE =  $urlStart. $urlStr['news']['url'];
    $urlZH =  $urlStart. $urlStr['news']['url'];
    $urlPL =  $urlStart. $urlStr['news']['url'];

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
}

$bd = '';
if (isset($_GET['bd']) && $_GET['bd'] != '') {
    $bd .= " AND '". simpleSanitize($_GET['bd']) ."' BETWEEN (SELECT MIN(habitaciones_prop) FROM properties_properties p3 WHERE promocion_prop = id_nws) AND (SELECT MAX(habitaciones_prop) FROM properties_properties WHERE promocion_prop = id_nws) ";
}

$typ = '';
if (isset($_GET['tp']) && $_GET['tp'] != '') {
   $idType = simpleSanitize($_GET['tp']);
   $typ = " AND EXISTS (
       SELECT 1
       FROM properties_properties p
       LEFT JOIN properties_types t ON p.tipo_prop = t.id_typ
       WHERE
           p.promocion_prop = id_nws
           AND p.activado_prop = 1
           AND p.alquilado_prop = 0
           AND p.vendido_prop = 0
           AND p.force_hide_prop != 1
           AND (
               p.tipo_prop = '{$idType}'
               OR t.parent_typ = '{$idType}'
           )
   )";
}

$prdsp = '';
if (isset($_GET['prdsp']) && $_GET['prdsp'] != '' && $_GET['prdsp'] > 0) {
    $prdsp = "AND (SELECT preci_reducidoo_prop as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws LIMIT 1) >= " . simpleSanitize(($_GET['prdsp']));
}

$prhsp = '';
if (isset($_GET['prhsp']) && $_GET['prhsp'] != '' && $_GET['prhsp'] > 0) {
    $prhsp = "AND (SELECT preci_reducidoo_prop as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws LIMIT 1) <= " . simpleSanitize(($_GET['prhsp'])) ." AND (SELECT preci_reducidoo_prop as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws LIMIT 1)  > 0";
}

$coast = '';
if (isset($_GET['coast']) && $_GET['coast'] != '') {
    $coast = " AND (SELECT CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3 WHERE promocion_prop = id_nws LIMIT 1) = '" . simpleSanitize($_GET['coast']) . "'";
}

$ct = '';
if (isset($_GET['loct']) && $_GET['loct'] != '') {
    $ct = " AND (SELECT CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3 WHERE promocion_prop = id_nws LIMIT 1) = '" . simpleSanitize($_GET['loct']) . "'";
}

$news = getRecords("

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
    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 999 AND activate_nws = 1 AND destacado_nws = 0

    $bd $typ $prdsp $prhsp $coast $ct

    $tgs

    $ct

    ORDER BY news.order_nws ASC

    LIMIT $cp, $tp
");

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

    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 999 AND activate_nws = 1 AND destacado_nws = 0

 AND news.content_".$lang."_nws != '' AND type_nws = 999

    $ct
";
$_result = mysqli_query($inmoconn, $_query);
$_row = mysqli_fetch_array($_result, MYSQLI_ASSOC);
$totalRows = mysqli_num_rows($_result);

SmartyPaginate::setTotal($totalRows);

mysqli_free_result($_result);

$smarty->assign("totalprops", $totalRows);

SmartyPaginate::assign($smarty);

?>
