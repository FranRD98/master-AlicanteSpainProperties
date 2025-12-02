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
                $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['events'][$value] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_' . $value]) . '/';
            } else {
                $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['events'][$value] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_' . $value]) . '/';
            }
        } else {
            $urlDefault = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $urlStr['events'][$value] . '/';
        }

    }
}

if (isset($newsURLs[0]['titulow_ce']) && $newsURLs[0]['titulow_ce'] != '' || isset($newsURLs[0]['titulo_ce']) && $newsURLs[0]['titulo_ce'] != '') {
    if ($newsURLs[0]['titulow_ce'] != '') {
        $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['events']['ca'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_ca']) . '/';
    } else {
        $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['events']['ca'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_ca']) . '/';
    }
} else {
    $urlCA = 'http://' . $_SERVER['HTTP_HOST'] . '/ca/' . $urlStr['events']['ca'] . '/';
}

if (isset($newsURLs[0]['titulow_da']) && $newsURLs[0]['titulow_da'] != '' || isset($newsURLs[0]['titulo_da']) && $newsURLs[0]['titulo_da'] != '') {
    if ($newsURLs[0]['titulow_da'] != '') {
        $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['events']['da'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_da']) . '/';
    } else {
        $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['events']['da'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_da']) . '/';
    }
} else {
    $urlDA = 'http://' . $_SERVER['HTTP_HOST'] . '/da/' . $urlStr['events']['da'] . '/';
}

if (isset($newsURLs[0]['titulow_de']) && $newsURLs[0]['titulow_de'] != '' || isset($newsURLs[0]['titulo_de']) && $newsURLs[0]['titulo_de'] != '') {
    if ($newsURLs[0]['titulow_de'] != '') {
        $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['events']['de'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_de']) . '/';
    } else {
        $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['events']['de'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_de']) . '/';
    }
} else {
    $urlDE = 'http://' . $_SERVER['HTTP_HOST'] . '/de/' . $urlStr['events']['de'] . '/';
}

if (isset($newsURLs[0]['titulow_el']) && $newsURLs[0]['titulow_el'] != '' || isset($newsURLs[0]['titulo_el']) && $newsURLs[0]['titulo_el'] != '') {
    if ($newsURLs[0]['titulow_el'] != '') {
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['events']['el'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_el']) . '/';
    } else {
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['events']['el'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_el']) . '/';
    }
} else {
    if(isset($urlStr['events']['el']))
        $urlEL = 'http://' . $_SERVER['HTTP_HOST'] . '/el/' . $urlStr['events']['el'] . '/';
    else
        $urlEL = '';
}

if (isset($newsURLs[0]['titulow_en']) && $newsURLs[0]['titulow_en'] != '' || isset($newsURLs[0]['titulo_en']) && $newsURLs[0]['titulo_en'] != '') {
    if ($newsURLs[0]['titulow_en'] != '') {
        $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['events']['en'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_en']) . '/';
    } else {
        $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['events']['en'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_en']) . '/';
    }
} else {
    $urlEN = 'http://' . $_SERVER['HTTP_HOST'] . '/en/' . $urlStr['events']['en'] . '/';
}

if (isset($newsURLs[0]['titulow_es']) && $newsURLs[0]['titulow_es'] != '' || isset($newsURLs[0]['titulo_es']) && $newsURLs[0]['titulo_es'] != '') {
    if ($newsURLs[0]['titulow_es'] != '') {
        $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['events']['es'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_es']) . '/';
    } else {
        $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['events']['es'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_es']) . '/';
    }
} else {
    $urlES = 'http://' . $_SERVER['HTTP_HOST'] . '/es/' . $urlStr['events']['es'] . '/';
}

if (isset($newsURLs[0]['titulow_fi']) && $newsURLs[0]['titulow_fi'] != '' || isset($newsURLs[0]['titulo_fi']) && $newsURLs[0]['titulo_fi'] != '') {
    if ($newsURLs[0]['titulow_fi'] != '') {
        $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['events']['fi'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_fi']) . '/';
    } else {
        $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['events']['fi'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_fi']) . '/';
    }
} else {
    $urlFI = 'http://' . $_SERVER['HTTP_HOST'] . '/fi/' . $urlStr['events']['fi'] . '/';
}

if (isset($newsURLs[0]['titulow_fr']) && $newsURLs[0]['titulow_fr'] != '' || isset($newsURLs[0]['titulo_fr']) && $newsURLs[0]['titulo_fr'] != '') {
    if ($newsURLs[0]['titulow_fr'] != '') {
        $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['events']['fr'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_fr']) . '/';
    } else {
        $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['events']['fr'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_fr']) . '/';
    }
} else {
    $urlFR = 'http://' . $_SERVER['HTTP_HOST'] . '/fr/' . $urlStr['events']['fr'] . '/';
}

if (isset($newsURLs[0]['titulow_is']) && $newsURLs[0]['titulow_is'] != '' || isset($newsURLs[0]['titulo_is']) && $newsURLs[0]['titulo_is'] != '') {
    if ($newsURLs[0]['titulow_is'] != '') {
        $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['events']['is'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_is']) . '/';
    } else {
        $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['events']['is'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_is']) . '/';
    }
} else {
    $urlIS = 'http://' . $_SERVER['HTTP_HOST'] . '/is/' . $urlStr['events']['is'] . '/';
}

if (isset($newsURLs[0]['titulow_it']) && $newsURLs[0]['titulow_it'] != '' || isset($newsURLs[0]['titulo_it']) && $newsURLs[0]['titulo_it'] != '') {
    if ($newsURLs[0]['titulow_it'] != '') {
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['events']['it'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_it']) . '/';
    } else {
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['events']['it'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_it']) . '/';
    }
} else {
    if(isset($urlStr['events']['it']))
        $urlIT = 'http://' . $_SERVER['HTTP_HOST'] . '/it/' . $urlStr['events']['it'] . '/';
    else
        $urlIT = '';
}

if (isset($newsURLs[0]['titulow_nl']) && $newsURLs[0]['titulow_nl'] != '' || isset($newsURLs[0]['titulo_nl']) && $newsURLs[0]['titulo_nl'] != '') {
    if ($newsURLs[0]['titulow_nl'] != '') {
        $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['events']['nl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_nl']) . '/';
    } else {
        $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['events']['nl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_nl']) . '/';
    }
} else {
    $urlNL = 'http://' . $_SERVER['HTTP_HOST'] . '/nl/' . $urlStr['events']['nl'] . '/';
}

if (isset($newsURLs[0]['titulow_no']) && $newsURLs[0]['titulow_no'] != '' || isset($newsURLs[0]['titulo_no']) && $newsURLs[0]['titulo_no'] != '') {
    if ($newsURLs[0]['titulow_no'] != '') {
        $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['events']['no'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_no']) . '/';
    } else {
        $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['events']['no'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_no']) . '/';
    }
} else {
    $urlNO = 'http://' . $_SERVER['HTTP_HOST'] . '/no/' . $urlStr['events']['no'] . '/';
}

if (isset($newsURLs[0]['titulow_pt']) && $newsURLs[0]['titulow_pt'] != '' || isset($newsURLs[0]['titulo_pt']) && $newsURLs[0]['titulo_pt'] != '') {
    if ($newsURLs[0]['titulow_pt'] != '') {
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['events']['pt'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_pt']) . '/';
    } else {
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['events']['pt'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_pt']) . '/';
    }
} else {
    if(isset($urlStr['events']['pt']))
        $urlPT = 'http://' . $_SERVER['HTTP_HOST'] . '/pt/' . $urlStr['events']['pt'] . '/';
    else
        $urlPT = '';
}

if (isset($newsURLs[0]['titulow_ru']) && $newsURLs[0]['titulow_ru'] != '' || isset($newsURLs[0]['titulo_ru']) && $newsURLs[0]['titulo_ru'] != '') {
    if ($newsURLs[0]['titulow_ru'] != '') {
        $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['events']['ru'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_ru']) . '/';
    } else {
        $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['events']['ru'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_ru']) . '/';
    }
} else {
    $urlRU = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/' . $urlStr['events']['ru'] . '/';
}

if (isset($newsURLs[0]['titulow_se']) && $newsURLs[0]['titulow_se'] != '' || isset($newsURLs[0]['titulo_se']) && $newsURLs[0]['titulo_se'] != '') {
    if ($newsURLs[0]['titulow_se'] != '') {
        $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['events']['se'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_se']) . '/';
    } else {
        $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['events']['se'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_se']) . '/';
    }
} else {
    $urlSE = 'http://' . $_SERVER['HTTP_HOST'] . '/se/' . $urlStr['events']['se'] . '/';
}

if (isset($newsURLs[0]['titulow_zh']) && $newsURLs[0]['titulow_zh'] != '' || isset($newsURLs[0]['titulo_zh']) && $newsURLs[0]['titulo_zh'] != '') {
    if ($newsURLs[0]['titulow_zh'] != '') {
        $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['events']['zh'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_zh']) . '/';
    } else {
        $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['events']['zh'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_zh']) . '/';
    }
} else {
    $urlZH = 'http://' . $_SERVER['HTTP_HOST'] . '/zh/' . $urlStr['events']['zh'] . '/';
}

if (isset($newsURLs[0]['titulow_pl']) && $newsURLs[0]['titulow_pl'] != '' || isset($newsURLs[0]['titulo_pl']) && $newsURLs[0]['titulo_pl'] != '') {
    if ($newsURLs[0]['titulow_pl'] != '') {
        $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['events']['pl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulow_pl']) . '/';
    } else {
        $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['events']['pl'] . '/' . $newsURLs[0]['id_nws'] . '/' . slug($newsURLs[0]['titulo_pl']) . '/';
    }
} else {
    $urlPL = 'http://' . $_SERVER['HTTP_HOST'] . '/pl/' . $urlStr['events']['pl'] . '/';
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
        news.location_".$lang."_nws as ubicacion,
        news.tags_".$lang."_nws as resumen,
        news.finished_nws as finalizado,
        news.typevent_nws as tipo,
        news.direccion_gp_prop as url,
        news.date_nws,
        news.quick_location_nws,
        news.quick_type_nws,
        news.quick_status_nws,
        news.quick_town_nws,
        news.quick_province_nws,
        quick_price_from_nws,
        quick_price_up_to_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_".$lang."_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE news.title_".$lang."_nws  != ''  AND type_nws = 100

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
    $urlCom = $urlStart . ''. $urlStr['events']['url'] . '/' . $news[0]['id_nws'] . '/' . clean(trim($news[0]['titulow'])) . '/';
} else {
    $urlCom = $urlStart . ''. $urlStr['events']['url'] . '/' . $news[0]['id_nws'] . '/' . slug($news[0]['titulo']) . '/';
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . $urlCom;

$smarty->assign("metaURL", $url);

if ($_SERVER['REQUEST_URI'] != $urlCom && $lang!='zh') {
 header("HTTP/1.1 301 Moved Permanently");
 header("Location: $urlCom");
}

if (preg_match('/https?:\/\//', $news[0]['img'])) {
    $img = $news[0]['img'];
} else {
    $img = 'http://' . $_SERVER['HTTP_HOST'] . '/media/images/news/' . $news[0]['img'];
}

$smarty->assign("metaImage", $img);

$images = getRecords("

    SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE noticia_img = '".simpleSanitize(($tokens[1]))."' AND destacada_img != 1 AND mobile_img != 1 ORDER BY orden_img

");

$banner = getRecords("
        SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE destacada_img = 1 AND noticia_img = '".simpleSanitize(($tokens[1]))."' ORDER BY orden_img LIMIT  1
    ");

$mobile = getRecords("
        SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE mobile_img = 1 AND noticia_img = '".simpleSanitize(($tokens[1]))."' ORDER BY orden_img LIMIT  1
    ");

foreach ($images as &$image) {
    // Añadimos una clave adicional para la comprobación
    $image['contains_http'] = preg_match("/http:\/\//", $image['image_img']);
}

$smarty->assign("images", $images);

if($banner[0]['image_img'] != '')
{
    $smarty->assign("banner", $banner);
}
if($mobile[0]['image_img'] != '')
{
    $smarty->assign("mobile", $mobile);
}

$videos = getRecords("

    SELECT video_vid FROM news_videos WHERE news_vid = '".simpleSanitize(($tokens[1]))."' ORDER BY order_vid

");

$smarty->assign("videos", $videos);

$files = getRecords("

SELECT file_fil, id_fil, name_".$lang."_fil as name FROM  news_files WHERE  news_fil = '".simpleSanitize(($tokens[1]))."'  AND (lang_fil IS NULL OR lang_fil = '' OR lang_fil = '".simpleSanitize(($lang))."') ORDER BY order_fil");

$smarty->assign("files", $files);

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$smarty->assign('http_referer', $referer);

 ?>
