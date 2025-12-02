<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

$zonas = getRecords("
    SELECT
        direccion_gp_prop,
        lat_long_gp_prop,
        zoom_gp_prop,
        provinces_ct,
        category_".$lang."_ct as titulo,
        descripcion_".$lang."_ct as contenido,
        title_".$lang."_ct as titulow,
        description_".$lang."_ct as contenidow,
        keywords_".$lang."_ct as keywords,
        (SELECT image_img FROM zonas_images WHERE zona_img = id_ct ORDER BY IF(destacada_img = 1, 0, 1), order_img LIMIT 1) AS img
    FROM news_categories
    WHERE id_ct = '" . simpleSanitize(($_GET['zon'])) . "'
    ");
$smarty->assign("zonas", $zonas);

if(isset($images))
$smarty->assign("images", $images);

$provID = explode(',', $zonas[0]['provinces_ct']);
$i = 0;
foreach ($provID as $key => $value) {
    $_GET['lopr'][$i++] = $value;
}


if ($zonas[0]['titulow'] != '') {
    $title = $zonas[0]['titulow'];
} else {
    $title = $zonas[0]['titulo'];
}

if ($title == '') {
    $title = $metaTitleDefault;
}

$smarty->assign("metaTitle", trim(strip_tags($title)));

if ($zonas[0]['contenidow'] != '') {
    $description = $zonas[0]['contenidow'];
} else {
    $description = $zonas[0]['contenido'];
}

if ($description == '') {
    $description = $metaDescriptionDefault[$lang];
}

$smarty->assign("metaDescription", trim(strip_tags(preg_replace('/{image[-a-z]*}/', '', $description))));

if(isset($zonas[0]['keywords']))
    $smarty->assign("metaKeywords", trim(strip_tags($zonas[0]['keywords'])));

if ($lang == $language) {
     $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . slug($zonas[0]['titulo']) . '.html';
} else {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $urlStart . '' . slug($zonas[0]['titulo']) . '.html';
}

$smarty->assign("metaURL", $url);

if (isset($zonas[0]['img']) && preg_match('/https?:\/\//', $zonas[0]['img'])) {
    $img = $zonas[0]['img'];
} else {
    $img = 'http://' . $_SERVER['HTTP_HOST'] . '/media/images/zonas/' . $zonas[0]['img'];
}

$smarty->assign("metaImage", $img);
$images = getRecords("

    SELECT image_img as image_img, alt_".$lang."_img as alt FROM zonas_images WHERE zona_img = '".simpleSanitize(($_GET['zon']))."' AND destacada_img != 1 ORDER BY order_img

");

foreach ($images as &$image) {
    // Añadimos una clave adicional para la comprobación
    $image['contains_http'] = preg_match("/http:\/\//", $image['image_img']);
}

$smarty->assign("images", $images);


$matches = array();

preg_match_all('/{image-left}|{image-right}|{image-pan}/', (string)$zonas[0]['contenido'], $matches);

$text = (string)$zonas[0]['contenido'];

if (isset($matches[0]) && count($matches[0])>0) {
    for ($i=0; $i < count($matches[0]); $i++) {

        switch ($matches[0][$i]) {
            case '{image-right}':
                $img = showThumbnail($images[($i)]['image_img'], '/media/images/zonas/', 350, 200, $images[($i)]['alt'], 'img-right');
                break;
            case '{image-pan}':
                $img = showThumbnail($images[($i)]['image_img'], '/media/images/zonas/', 930, 200, $images[($i)]['alt'], 'img-pan');
                break;

            default:
                $img = showThumbnail($images[($i)]['image_img'], '/media/images/zonas/', 350, 200, $images[($i)]['alt'], 'img-left');
                break;
        }

        $text = preg_replace('/'.$matches[0][$i].'/', $img, $text, 1);

    }
}

$smarty->assign("pagetext", $text);

$news = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.titlew_".$lang."_nws as titulometa,
        news.content_".$lang."_nws as contenido,
        news.date_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_".$lang."_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE news.title_".$lang."_nws  != '' AND type_nws = 6

    AND categoria_nws = '" . simpleSanitize(($_GET['zon'])) . "'

    ORDER BY news.date_nws DESC

");

$smarty->assign("news", $news);


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

SmartyPaginate::setLimit(9);

SmartyPaginate::setPageLimit(10);

SmartyPaginate::setUrl(preg_replace('/\&?\??p=[0-9]*/', '', $_SERVER['REQUEST_URI']));

SmartyPaginate::setUrlVar('p');

@SmartyPaginate::setPrevText('&#8249;');
@SmartyPaginate::setNextText('&#8250;');
@SmartyPaginate::setFirstText('&laquo;');
@SmartyPaginate::setLastText('&raquo;');

$cp = SmartyPaginate::getCurrentIndex();
$tp = SmartyPaginate::getLimit();

//  ============================================================================
//  === PROVINCE                                                             ===
//  ============================================================================

$lopr = '';
if( isset($_GET['lopr']) && $_GET['lopr'] != '' ){
    $province = implode(',', $_GET['lopr']);
    if ($province != '') {
        $lopr = "AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (" . simpleSanitize($province) . ")";
    }
}

//  ============================================================================
//  === CITY                                                                 ===
//  ============================================================================

$loct = '';
if( isset($_GET['loct']) && $_GET['loct'] != '' ){
    $location = implode(',', $_GET['loct']);
    if ($location != '') {
        $loct = "AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (" . simpleSanitize($location) . ")";
    }
}

//  ============================================================================
//  === ORDER                                                                ===
//  ============================================================================

function remove_querystring_var($url, $key) {
    $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
    return $url;
}

$o = " ORDER BY precio ASC";
if (isset($_GET['o']) && is_numeric($_GET['o'])) {

    setcookie('o', $_GET['o'], mktime(21,00,0,12,31,2100),"/", "",0);
    $url = remove_querystring_var("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "o");
    header("Location: $url");

}


if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '1') {

    $o = " ORDER BY precio ASC";

}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '2') {

    $o = " ORDER BY precio DESC";

}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '3') {

    $o = " ORDER BY id_prop DESC";

}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '4') {

    $o = " ORDER BY id_prop ASC";

}

$secc = "activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND image_img != '' AND force_hide_prop != 1";

$propertiesx = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    properties_properties.descripcion_".$lang."_prop  as descr,
    properties_status.status_".$lang."_sta as sale,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
        title_".$lang."_prop as metatitle



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

WHERE  $secc

$lopr $loct

GROUP BY id_prop

$o

LIMIT $cp, $tp

");



foreach ($propertiesx as $key => $value) {

    $theFavsDB = getRecords("
    SELECT COUNT(id) AS num_favorites
    FROM users_favorites
    WHERE user = '".simpleSanitize(($_SESSION['kt_login_id']))."'
    AND property = '".simpleSanitize(($propertiesx[$key]['id_prop']))."'
    ");

    $theFavs = array();
    if(isset($_COOKIE['fav']))
        $theFavs = explode(",",$_COOKIE['fav']);

    if (in_array($propertiesx[$key]['id_prop'], $theFavs ) || $theFavsDB[0]['num_favorites']==1) {
        $favVal = 1;
    } else {
        $favVal = 0;
    }

    array_push($propertiesx[$key], array('favorito' => $favVal));

    savelogprop($propertiesx[$key]['id_prop'], '1');

}

// echo "<pre>";
// print_r($propertiesx);
// echo "</pre>";

$smarty->assign("propertiesx", $propertiesx);

$_query = "SELECT id_prop

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

WHERE  $secc

$lopr $loct


     GROUP BY id_prop";
$_result = mysqli_query($inmoconn,$_query);
$_row = mysqli_fetch_array($_result, MYSQLI_ASSOC);
$totalRows = mysqli_num_rows($_result);


SmartyPaginate::setTotal($totalRows);

mysqli_free_result($_result);

$smarty->assign("totalprops", $totalRows);

$langQuery = '';

foreach ($languages as $key => $value) {
    $langQuery .= "category_".$value."_ct as titulo_".$value.", ";
    $langQuery .= "descripcion_".$value."_ct as contenido_".$value.", ";
    $langQuery .= "title_".$value."_ct as titulow_".$value.", ";
    $langQuery .= "description_".$value."_ct as contenidow_".$value.", ";
    $langQuery .= "keywords_".$value."_ct as keywords_".$value.", ";
}

$newsURLs = getRecords("
SELECT
    direccion_gp_prop,
    lat_long_gp_prop,
    zoom_gp_prop,
    provinces_ct,
    " . $langQuery . "
    (SELECT image_img FROM zonas_images WHERE zona_img = id_ct ORDER BY order_img LIMIT 1) AS img
FROM news_categories
WHERE id_ct = '" . simpleSanitize(($_GET['zon'])) . "'
LIMIT 1

");

// echo $newsURLs[0]['titulo_es'];

foreach ($languages as $value) {

    if ($value == $language) {

        if ($newsURLs[0]['titulo_' . $value] != '' || $newsURLs[0]['titulo_' . $value] != '') {
            if ($newsURLs[0]['titulo_' . $value] != '') {
                $urlDefault = 'https://' . $_SERVER['HTTP_HOST'] . '/' . slug($newsURLs[0]['titulo_' . $value]) . '.html';
            } else {
                $urlDefault = 'https://' . $_SERVER['HTTP_HOST'] . '/' . slug($newsURLs[0]['titulo_' . $value]) . '.html';
            }
        } else {
            $urlDefault = 'https://' . $_SERVER['HTTP_HOST'] . '/';
        }

    }
}

if (isset($newsURLs[0]['titulo_ca']) && ($newsURLs[0]['titulo_ca'] != '' || $newsURLs[0]['titulo_ca'] != '')) {
    if ($newsURLs[0]['titulo_ca'] != '') {
        $urlCA = 'https://' . $_SERVER['HTTP_HOST'] . '/ca/' . slug($newsURLs[0]['titulo_ca']) . '.html';
    } else {
        $urlCA = 'https://' . $_SERVER['HTTP_HOST'] . '/ca/' . slug($newsURLs[0]['titulo_ca']) . '.html';
    }
} else {
    $urlCA = 'https://' . $_SERVER['HTTP_HOST'] . '/ca/';
}

if (isset($newsURLs[0]['titulo_da']) && ($newsURLs[0]['titulo_da'] != '' || $newsURLs[0]['titulo_da'] != '')) {
    if ($newsURLs[0]['titulo_da'] != '') {
        $urlDA = 'https://' . $_SERVER['HTTP_HOST'] . '/da/' . slug($newsURLs[0]['titulo_da']) . '.html';
    } else {
        $urlDA = 'https://' . $_SERVER['HTTP_HOST'] . '/da/' . slug($newsURLs[0]['titulo_da']) . '.html';
    }
} else {
    $urlDA = 'https://' . $_SERVER['HTTP_HOST'] . '/da/';
}

if (isset($newsURLs[0]['titulo_de']) && ($newsURLs[0]['titulo_de'] != '' || $newsURLs[0]['titulo_de'] != '')) {
    if ($newsURLs[0]['titulo_de'] != '') {
        $urlDE = 'https://' . $_SERVER['HTTP_HOST'] . '/de/' . slug($newsURLs[0]['titulo_de']) . '.html';
    } else {
        $urlDE = 'https://' . $_SERVER['HTTP_HOST'] . '/de/' . slug($newsURLs[0]['titulo_de']) . '.html';
    }
} else {
    $urlDE = 'https://' . $_SERVER['HTTP_HOST'] . '/de/';
}

if (isset($newsURLs[0]['titulo_el']) && ($newsURLs[0]['titulo_el'] != '' || $newsURLs[0]['titulo_el'] != '')) {
    if ($newsURLs[0]['titulo_el'] != '') {
        $urlEL = 'https://' . $_SERVER['HTTP_HOST'] . '/el/' . slug($newsURLs[0]['titulo_el']) . '.html';
    } else {
        $urlEL = 'https://' . $_SERVER['HTTP_HOST'] . '/el/' . slug($newsURLs[0]['titulo_el']) . '.html';
    }
} else {
    $urlEL = 'https://' . $_SERVER['HTTP_HOST'] . '/el/';
}

if (isset($newsURLs[0]['titulo_en']) && ($newsURLs[0]['titulo_en'] != '' || $newsURLs[0]['titulo_en'] != '')) {
    if ($newsURLs[0]['titulo_en'] != '') {
        $urlEN = 'https://' . $_SERVER['HTTP_HOST'] . '/en/' . slug($newsURLs[0]['titulo_en']) . '.html';
    } else {
        $urlEN = 'https://' . $_SERVER['HTTP_HOST'] . '/en/' . slug($newsURLs[0]['titulo_en']) . '.html';
    }
} else {
    $urlEN = 'https://' . $_SERVER['HTTP_HOST'] . '/en/';
}

if (isset($newsURLs[0]['titulo_es']) && $newsURLs[0]['titulo_es'] != '') {
    $urlES = 'https://' . $_SERVER['HTTP_HOST'] . '/es/' . slug($newsURLs[0]['titulo_es']) . '.html';
} else {
    $urlES = 'https://' . $_SERVER['HTTP_HOST'] . '/es/';
}

if (isset($newsURLs[0]['titulo_fi']) && ($newsURLs[0]['titulo_fi'] != '' || $newsURLs[0]['titulo_fi'] != '')) {
    if ($newsURLs[0]['titulo_fi'] != '') {
        $urlFI = 'https://' . $_SERVER['HTTP_HOST'] . '/fi/' . slug($newsURLs[0]['titulo_fi']) . '.html';
    } else {
        $urlFI = 'https://' . $_SERVER['HTTP_HOST'] . '/fi/' . slug($newsURLs[0]['titulo_fi']) . '.html';
    }
} else {
    $urlFI = 'https://' . $_SERVER['HTTP_HOST'] . '/fi/';
}

if (isset($newsURLs[0]['titulo_fr']) && ($newsURLs[0]['titulo_fr'] != '' || $newsURLs[0]['titulo_fr'] != '')) {
    if ($newsURLs[0]['titulo_fr'] != '') {
        $urlFR = 'https://' . $_SERVER['HTTP_HOST'] . '/fr/' . slug($newsURLs[0]['titulo_fr']) . '.html';
    } else {
        $urlFR = 'https://' . $_SERVER['HTTP_HOST'] . '/fr/' . slug($newsURLs[0]['titulo_fr']) . '.html';
    }
} else {
    $urlFR = 'https://' . $_SERVER['HTTP_HOST'] . '/fr/';
}

if (isset($newsURLs[0]['titulo_is']) && ($newsURLs[0]['titulo_is'] != '' || $newsURLs[0]['titulo_is'] != '')) {
    if ($newsURLs[0]['titulo_is'] != '') {
        $urlIS = 'https://' . $_SERVER['HTTP_HOST'] . '/is/' . slug($newsURLs[0]['titulo_is']) . '.html';
    } else {
        $urlIS = 'https://' . $_SERVER['HTTP_HOST'] . '/is/' . slug($newsURLs[0]['titulo_is']) . '.html';
    }
} else {
    $urlIS = 'https://' . $_SERVER['HTTP_HOST'] . '/is/';
}

if (isset($newsURLs[0]['titulo_it']) && ($newsURLs[0]['titulo_it'] != '' || $newsURLs[0]['titulo_it'] != '')) {
    if ($newsURLs[0]['titulo_it'] != '') {
        $urlIT = 'https://' . $_SERVER['HTTP_HOST'] . '/it/' . slug($newsURLs[0]['titulo_it']) . '.html';
    } else {
        $urlIT = 'https://' . $_SERVER['HTTP_HOST'] . '/it/' . slug($newsURLs[0]['titulo_it']) . '.html';
    }
} else {
    $urlIT = 'https://' . $_SERVER['HTTP_HOST'] . '/it/';
}

if (isset($newsURLs[0]['titulo_nl']) && ($newsURLs[0]['titulo_nl'] != '' || $newsURLs[0]['titulo_nl'] != '')) {
    if ($newsURLs[0]['titulo_nl'] != '') {
        $urlNL = 'https://' . $_SERVER['HTTP_HOST'] . '/nl/' . slug($newsURLs[0]['titulo_nl']) . '.html';
    } else {
        $urlNL = 'https://' . $_SERVER['HTTP_HOST'] . '/nl/' . slug($newsURLs[0]['titulo_nl']) . '.html';
    }
} else {
    $urlNL = 'https://' . $_SERVER['HTTP_HOST'] . '/nl/';
}

if (isset($newsURLs[0]['titulo_no']) && ($newsURLs[0]['titulo_no'] != '' || $newsURLs[0]['titulo_no'] != '')) {
    if ($newsURLs[0]['titulo_no'] != '') {
        $urlNO = 'https://' . $_SERVER['HTTP_HOST'] . '/no/' . slug($newsURLs[0]['titulo_no']) . '.html';
    } else {
        $urlNO = 'https://' . $_SERVER['HTTP_HOST'] . '/no/' . slug($newsURLs[0]['titulo_no']) . '.html';
    }
} else {
    $urlNO = 'https://' . $_SERVER['HTTP_HOST'] . '/no/';
}

if (isset($newsURLs[0]['titulo_pt']) && ($newsURLs[0]['titulo_pt'] != '' || $newsURLs[0]['titulo_pt'] != '')) {
    if ($newsURLs[0]['titulo_pt'] != '') {
        $urlPT = 'https://' . $_SERVER['HTTP_HOST'] . '/pt/' . slug($newsURLs[0]['titulo_pt']) . '.html';
    } else {
        $urlPT = 'https://' . $_SERVER['HTTP_HOST'] . '/pt/' . slug($newsURLs[0]['titulo_pt']) . '.html';
    }
} else {
    $urlPT = 'https://' . $_SERVER['HTTP_HOST'] . '/pt/';
}

if (isset($newsURLs[0]['titulo_ru']) && ($newsURLs[0]['titulo_ru'] != '' || $newsURLs[0]['titulo_ru'] != '')) {
    if ($newsURLs[0]['titulo_ru'] != '') {
        $urlRU = 'https://' . $_SERVER['HTTP_HOST'] . '/ru/' . slug($newsURLs[0]['titulo_ru']) . '.html';
    } else {
        $urlRU = 'https://' . $_SERVER['HTTP_HOST'] . '/ru/' . slug($newsURLs[0]['titulo_ru']) . '.html';
    }
} else {
    $urlRU = 'https://' . $_SERVER['HTTP_HOST'] . '/ru/';
}

if (isset($newsURLs[0]['titulo_se']) && ($newsURLs[0]['titulo_se'] != '' || $newsURLs[0]['titulo_se'] != '')) {
    if ($newsURLs[0]['titulo_se'] != '') {
        $urlSE = 'https://' . $_SERVER['HTTP_HOST'] . '/se/' . slug($newsURLs[0]['titulo_se']) . '.html';
    } else {
        $urlSE = 'https://' . $_SERVER['HTTP_HOST'] . '/se/' . slug($newsURLs[0]['titulo_se']) . '.html';
    }
} else {
    $urlSE = 'https://' . $_SERVER['HTTP_HOST'] . '/se/';
}

if (isset($newsURLs[0]['titulo_zh']) && ($newsURLs[0]['titulo_zh'] != '' || $newsURLs[0]['titulo_zh'] != '')) {
    if ($newsURLs[0]['titulo_zh'] != '') {
        $urlZH = 'https://' . $_SERVER['HTTP_HOST'] . '/zh/' . slug($newsURLs[0]['titulo_zh']) . '.html';
    } else {
        $urlZH = 'https://' . $_SERVER['HTTP_HOST'] . '/zh/' . slug($newsURLs[0]['titulo_zh']) . '.html';
    }
} else {
    $urlZH = 'https://' . $_SERVER['HTTP_HOST'] . '/zh/';
}

if (isset($newsURLs[0]['titulo_pl']) && ($newsURLs[0]['titulo_pl'] != '' || $newsURLs[0]['titulo_pl'] != '')) {
    if ($newsURLs[0]['titulo_pl'] != '') {
        $urlPL = 'https://' . $_SERVER['HTTP_HOST'] . '/pl/' . slug($newsURLs[0]['titulo_pl']) . '.html';
    } else {
        $urlPL = 'https://' . $_SERVER['HTTP_HOST'] . '/pl/' . slug($newsURLs[0]['titulo_pl']) . '.html';
    }
} else {
    $urlPL = 'https://' . $_SERVER['HTTP_HOST'] . '/pl/';
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
$smarty->assign('urlIS', $urlIS);
$smarty->assign('urlIT', $urlIT);
$smarty->assign('urlNL', $urlNL);
$smarty->assign('urlNO', $urlNO);
$smarty->assign('urlPT', $urlPT);
$smarty->assign('urlRU', $urlRU);
$smarty->assign('urlSE', $urlSE);
$smarty->assign('urlZH', $urlZH);
$smarty->assign('urlPL', $urlPL);

SmartyPaginate::assign($smarty);

 ?>
