<?php
$langQuery = '';

foreach ($languages as $key => $value) {

    $langQuery .= "news.title_".$value."_nws as titulo_".$value.", ";
    $langQuery .= "news.titlew_".$value."_nws as titulow_".$value.", ";

}

$newsURLs = getRecords("

SELECT
    " . $langQuery . "
    news.id_nws
FROM news

WHERE id_nws = '".simpleSanitize(($tokens[1]))."'

LIMIT 1


");

foreach ($languages as $value) {

    if ($value == $language) {

        if ($newsURLs[0]['titulow_' . $value] != '' || $newsURLs[0]['titulo_' . $value] != '') {
            if ($newsURLs[0]['titulow_' . $value] != '') {
                $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['testimonials'][$value] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_' . $value]) . '/';
            } else {
                $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['testimonials'][$value] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_' . $value]) . '/';
            }
        } else {
            $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['testimonials'][$value] . '/';
        }

    }
}

if ( (isset($newsURLs[0]['titulow_ca']) && $newsURLs[0]['titulow_ca'] != '') || (isset($newsURLs[0]['titulo_ca']) && $newsURLs[0]['titulo_ca'] != '')) {
    if ($newsURLs[0]['titulow_ca'] != '') {
        $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['testimonials']['ca'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_ca']) . '/';
    } else {
        $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['testimonials']['ca'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_ca']) . '/';
    }
} else {
    $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['testimonials']['ca'] . '/';
}

if ((isset($newsURLs[0]['titulow_da']) && $newsURLs[0]['titulow_da'] != '') || (isset($newsURLs[0]['titulo_da']) && $newsURLs[0]['titulo_da'] != '')) {
    if ($newsURLs[0]['titulow_da'] != '') {
        $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['testimonials']['da'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_da']) . '/';
    } else {
        $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['testimonials']['da'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_da']) . '/';
    }
} else {
    $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['testimonials']['da'] . '/';
}

if ( (isset($newsURLs[0]['titulow_de']) && $newsURLs[0]['titulow_de'] != '') || (isset($newsURLs[0]['titulo_de']) && $newsURLs[0]['titulo_de'] != '')) {
    if ($newsURLs[0]['titulow_de'] != '') {
        $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['testimonials']['de'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_de']) . '/';
    } else {
        $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['testimonials']['de'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_de']) . '/';
    }
} else {
    $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['testimonials']['de'] . '/';
}

if ( (isset($newsURLs[0]['titulow_el']) && $newsURLs[0]['titulow_el']) != '' || (isset($newsURLs[0]['titulo_el']) && $newsURLs[0]['titulo_el'] != '')) {
    if ($newsURLs[0]['titulow_el'] != '') {
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['testimonials']['el'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_el']) . '/';
    } else {
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['testimonials']['el'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_el']) . '/';
    }
} else {
    if(isset($urlStr['testimonials']['el']))
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['testimonials']['el'] . '/';
    else
        $urlEL = '';
}

if ((isset($newsURLs[0]['titulow_en']) && $newsURLs[0]['titulow_en'] != '') || (isset($newsURLs[0]['titulo_en']) && $newsURLs[0]['titulo_en'] != '')) {
    if ($newsURLs[0]['titulow_en'] != '') {
        $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['testimonials']['en'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_en']) . '/';
    } else {
        $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['testimonials']['en'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_en']) . '/';
    }
} else {
    $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['testimonials']['en'] . '/';
}

if ((isset($newsURLs[0]['titulow_es']) && $newsURLs[0]['titulow_es'] != '') || (isset($newsURLs[0]['titulo_es']) && $newsURLs[0]['titulo_es'] != '')) {
    if ($newsURLs[0]['titulow_es'] != '') {
        $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['testimonials']['es'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_es']) . '/';
    } else {
        $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['testimonials']['es'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_es']) . '/';
    }
} else {
    $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['testimonials']['es'] . '/';
}

if ((isset($newsURLs[0]['titulow_fi']) && $newsURLs[0]['titulow_fi'] != '') || (isset($newsURLs[0]['titulo_fi']) && $newsURLs[0]['titulo_fi'] != '')) {
    if ($newsURLs[0]['titulow_fi'] != '') {
        $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['testimonials']['fi'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_fi']) . '/';
    } else {
        $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['testimonials']['fi'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_fi']) . '/';
    }
} else {
    $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['testimonials']['fi'] . '/';
}

if ((isset($newsURLs[0]['titulow_fr']) && $newsURLs[0]['titulow_fr'] != '') || (isset($newsURLs[0]['titulo_fr']) && $newsURLs[0]['titulo_fr'] != '')) {
    if ($newsURLs[0]['titulow_fr'] != '') {
        $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['testimonials']['fr'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_fr']) . '/';
    } else {
        $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['testimonials']['fr'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_fr']) . '/';
    }
} else {
    $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['testimonials']['fr'] . '/';
}

if ((isset($newsURLs[0]['titulow_is']) && $newsURLs[0]['titulow_is'] != '') || (isset($newsURLs[0]['titulo_is']) && $newsURLs[0]['titulo_is'] != '')) {
    if ($newsURLs[0]['titulow_is'] != '') {
        $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['testimonials']['is'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_is']) . '/';
    } else {
        $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['testimonials']['is'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_is']) . '/';
    }
} else {
    $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['testimonials']['is'] . '/';
}

if ((isset($newsURLs[0]['titulow_it']) && $newsURLs[0]['titulow_it'] != '') || (isset($newsURLs[0]['titulo_it']) && $newsURLs[0]['titulo_it'] != '')) {
    if ($newsURLs[0]['titulow_it'] != '') {
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['testimonials']['it'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_it']) . '/';
    } else {
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['testimonials']['it'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_it']) . '/';
    }
} else {
    if(isset($urlStr['testimonials']['it']))
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['testimonials']['it'] . '/';
    else
        $urlIT = '';
}

if ((isset($newsURLs[0]['titulow_nl']) && $newsURLs[0]['titulow_nl'] != '') || (isset($newsURLs[0]['titulow_nl']) && $newsURLs[0]['titulo_nl'] != '')) {
    if ($newsURLs[0]['titulow_nl'] != '') {
        $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['testimonials']['nl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_nl']) . '/';
    } else {
        $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['testimonials']['nl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_nl']) . '/';
    }
} else {
    $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['testimonials']['nl'] . '/';
}

if ((isset($newsURLs[0]['titulow_no']) && $newsURLs[0]['titulow_no'] != '') || (isset($newsURLs[0]['titulo_no']) && $newsURLs[0]['titulo_no'] != '')) {
    if ($newsURLs[0]['titulow_no'] != '') {
        $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['testimonials']['no'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_no']) . '/';
    } else {
        $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['testimonials']['no'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_no']) . '/';
    }
} else {
    $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['testimonials']['no'] . '/';
}

if ((isset($newsURLs[0]['titulow_pt']) && $newsURLs[0]['titulow_pt'] != '') || (isset($newsURLs[0]['titulo_pt']) && $newsURLs[0]['titulo_pt'] != '')) {
    if ($newsURLs[0]['titulow_pt'] != '') {
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['testimonials']['pt'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_pt']) . '/';
    } else {
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['testimonials']['pt'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_pt']) . '/';
    }
} else {
    if(isset($urlStr['testimonials']['pt']))
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['testimonials']['pt'] . '/';
    else
        $urlPT = '';
}

if ((isset($newsURLs[0]['titulow_ru']) && $newsURLs[0]['titulow_ru'] != '') || (isset($newsURLs[0]['titulo_ru']) && $newsURLs[0]['titulo_ru'] != '')) {
    if ($newsURLs[0]['titulow_ru'] != '') {
        $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['testimonials']['ru'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_ru']) . '/';
    } else {
        $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['testimonials']['ru'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_ru']) . '/';
    }
} else {
    $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['testimonials']['ru'] . '/';
}

if ((isset($newsURLs[0]['titulow_se']) && $newsURLs[0]['titulow_se'] != '') || (isset($newsURLs[0]['titulo_se']) && $newsURLs[0]['titulo_se'] != '')) {
    if ($newsURLs[0]['titulow_se'] != '') {
        $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['testimonials']['se'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_se']) . '/';
    } else {
        $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['testimonials']['se'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_se']) . '/';
    }
} else {
    $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['testimonials']['se'] . '/';
}

if ((isset($newsURLs[0]['titulow_zh']) && $newsURLs[0]['titulow_zh'] != '') || (isset($newsURLs[0]['titulo_zh']) && $newsURLs[0]['titulo_zh'] != '')) {
    if ($newsURLs[0]['titulow_zh'] != '') {
        $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['testimonials']['zh'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_zh']) . '/';
    } else {
        $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['testimonials']['zh'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_zh']) . '/';
    }
} else {
    $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['testimonials']['zh'] . '/';
}

if ((isset($newsURLs[0]['titulow_pl']) && $newsURLs[0]['titulow_pl'] != '') || (isset($newsURLs[0]['titulo_pl']) && $newsURLs[0]['titulo_pl'] != '')) {
    if ($newsURLs[0]['titulow_pl'] != '') {
        $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['testimonials']['pl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_pl']) . '/';
    } else {
        $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['testimonials']['pl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_pl']) . '/';
    }
} else {
    $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['testimonials']['pl'] . '/';
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



$news = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.content_".$lang."_nws as contenido,
        news.titlew_".$lang."_nws as titulow,
        news.description_".$lang."_nws as contenidow,
        news.keywords_".$lang."_nws as keywords,
        news.date_nws,
        news.quick_location_nws,
        news.quick_type_nws,
        news.quick_status_nws,
        news.quick_town_nws,
        news.quick_province_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_".$lang."_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 10

    AND id_nws = '".simpleSanitize(($tokens[1]))."'

    ORDER BY news.date_nws DESC

    LIMIT 1
");

/**
 * Si no existe la noticia mostrar 404
 */

if ($news[0]['id_nws'] == '') {

    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    header("Status: 404 Not Found");
    $_SERVER['REDIRECT_STATUS'] = 404;
    $numpag = 11;
    include($_SERVER["DOCUMENT_ROOT"] . '/modules/pages/pages.php');
    $smarty->display('modules/404/view/index.tpl');

}

$smarty->assign("news", $news);


if (isset($news[0]['titulow']) && $news[0]['titulow'] != '') {
    $title = $news[0]['titulow'];
} else {
    $title = $news[0]['titulo'];
}

$smarty->assign("metaTitle", trim(strip_tags($title)));

if (isset($news[0]['contenidow']) && $news[0]['contenidow'] != '') {
    $description = $news[0]['contenidow'];
} else {
    $description = $news[0]['contenido'];
}

$smarty->assign("metaDescription", trim(strip_tags($description)));

$smarty->assign("metaKeywords", trim(strip_tags($news[0]['keywords'])));



if (isset($news[0]['titulow']) && trim($news[0]['titulow']) != '') {
    $urlCom = $urlStart . ''. $urlStr['testimonials']['url'] . '/' . $news[0]['id_nws'] . '/' . clean(trim($news[0]['titulow'])) . '/';
} else {
    $urlCom = $urlStart . ''. $urlStr['testimonials']['url'] . '/' . $news[0]['id_nws'] . '/' . slug($news[0]['titulo']) . '/';
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . $urlCom;

$smarty->assign("metaURL", $url);

if ($_SERVER['REQUEST_URI'] != $urlCom && $lang!='zh') {
 header("HTTP/1.1 301 Moved Permanently");
 header("Location: $urlCom");
}

if (isset($news[0]['img']) && preg_match('/https?:\/\//', $news[0]['img'])) {
    $img = $news[0]['img'];
} else {
    $img = 'http://' . $_SERVER['HTTP_HOST'] . '/media/images/news/' . $news[0]['img'];
}

$smarty->assign("metaImage", $img);

$images = getRecords("

    SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE noticia_img = '".simpleSanitize(($tokens[1]))."' ORDER BY orden_img

");

foreach ($images as &$image) {
    // Añadimos una clave adicional para la comprobación
    $image['contains_http'] = preg_match("/http:\/\//", $image['image_img']);
}

$smarty->assign("images", $images);

$videos = getRecords("

    SELECT video_vid FROM news_videos WHERE news_vid = '".simpleSanitize(($tokens[1]))."' ORDER BY order_vid

");

$smarty->assign("videos", $videos);

$files = getRecords("

SELECT file_fil, id_fil, name_".$lang."_fil as name FROM  news_files WHERE  news_fil = '".simpleSanitize(($tokens[1]))."'  AND (lang_fil IS NULL OR lang_fil = '' OR lang_fil = '".simpleSanitize(($lang))."') ORDER BY order_fil");

$smarty->assign("files", $files);

SmartyPaginate::connect();

SmartyPaginate::setLimit(9);

SmartyPaginate::setPageLimit(6);

SmartyPaginate::setUrl(preg_replace('/[\&?\??]+p=[0-9]*/', '', $_SERVER['REQUEST_URI']));

SmartyPaginate::setUrlVar('p');

@SmartyPaginate::setPrevText('&#8249;');
@SmartyPaginate::setNextText('&#8250;');
@SmartyPaginate::setFirstText('&laquo;');
@SmartyPaginate::setLastText('&raquo;');

$cp = SmartyPaginate::getCurrentIndex();
$tp = SmartyPaginate::getLimit();

$whereSQL = "";

if (isset($news[0]['quick_location_nws']) && $news[0]['quick_location_nws'] != '') {
    $whereSQL .= "AND (CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END) = '".simpleSanitize(($news[0]['quick_location_nws']))."'";
}

if (isset($news[0]['quick_town_nws']) && $news[0]['quick_town_nws'] != '') {
    $whereSQL .= "AND (CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END) = '".simpleSanitize(($news[0]['quick_town_nws']))."'";
}

if (isset($news[0]['quick_province_nws']) && $news[0]['quick_province_nws'] != '') {
    $whereSQL .= "AND (CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END) = '".simpleSanitize(($news[0]['quick_province_nws']))."'";
}

if (isset($news[0]['quick_type_nws']) && $news[0]['quick_type_nws'] != '') {
    $whereSQL .= "AND (CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END) = '".simpleSanitize(($news[0]['quick_type_nws']))."'";
}

if (isset($news[0]['quick_status_nws']) && $news[0]['quick_status_nws'] != '') {
    $whereSQL .= "AND (operacion_prop) = '".simpleSanitize(($news[0]['quick_status_nws']))."'";
}


$similares = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    properties_properties.lat_long_gp_prop AS lat,
    properties_status.status_".$lang."_sta as sale,
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
    id_prop,
    id_img,
    alt_".$lang."_img as alt,
    properties_properties.descripcion_".$lang."_prop as descr,
    title_".$lang."_prop as metatitle,
    description_".$lang."_prop as metadescription,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop


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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0

$whereSQL

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT $cp, $tp

");

$smarty->assign("similares", $similares);

$showSimils=0;
if ($news[0]['quick_location_nws'] != '' || $news[0]['quick_province_nws'] != '' || $news[0]['quick_town_nws'] != '' || $news[0]['quick_type_nws'] != '' || $news[0]['quick_status_nws'] != '') {
    $showSimils=1;
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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0

$whereSQL


GROUP BY id_prop

";


$_result = mysqli_query($inmoconn, $_query);
$_row = mysqli_fetch_array($_result, MYSQLI_ASSOC);
$totalRows = mysqli_num_rows($_result);

SmartyPaginate::setTotal($totalRows);

mysqli_free_result($_result);

$smarty->assign("totalprops", $totalRows);

SmartyPaginate::assign($smarty);


$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$smarty->assign('http_referer', $referer);

 ?>
