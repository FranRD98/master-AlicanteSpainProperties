<?php

$pages = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.content_".$lang."_nws as contenido,
        news.titlew_".$lang."_nws as titulow,
        news.description_".$lang."_nws as contenidow,
        news.keywords_".$lang."_nws as keywords,
        news.date_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img

    FROM news

    WHERE  type_nws = 2

    AND id_nws IN (".simpleSanitize(($numpag)).")

    ORDER BY news.id_nws ASC
");


if (isset($pages[0]['titulow']) && $pages[0]['titulow'] != '') {
    $title = $pages[0]['titulow'];
} else {
    if(isset($pages[0]['titulo']))
        $title = $pages[0]['titulo'];
}

if (!isset($title) || $title == '') {
    $title = $metaTitleDefault['es'];
}


$title = trim(strip_tags($title));

$smarty->assign("metaTitle", $title);

if (isset($pages[0]['contenidow']) && $pages[0]['contenidow'] != '') {
    $description = $pages[0]['contenidow'];
} else {
    if(isset($pages[0]['contenido']))
        $description = $pages[0]['contenido'];
}

if (!isset($description) || $description == '') {
    $description = $metaDescriptionDefault['es'];
}
$description = trim(strip_tags($description));
$smarty->assign("metaDescription", $description);

if(isset($pages[0]['keywords']))
    $smarty->assign("metaKeywords", trim(strip_tags($pages[0]['keywords'])));

$url = 'https://' . $_SERVER['HTTP_HOST'] . '' . $_SERVER['REQUEST_URI'];

$smarty->assign("metaURL", $url);
if(isset($pages[0]['img'])){
    if (preg_match('/https?:\/\//', $pages[0]['img'])) {
        $img = $pages[0]['img'];
    } else {
        $img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/' . $pages[0]['img'];
    }
}
 
if (!isset($img) || $img == 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/') {
    $img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/website/no-image.png';
}

$smarty->assign("metaImage", $img);

foreach ($pages as $key => $page) {
    $text = "";
    $images = "";
    $videos = "";

    $images = getRecords("
        SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE noticia_img = '".$page["id_nws"]."' ORDER BY orden_img
    ");

    $videos = getRecords("
        SELECT video_vid FROM news_videos WHERE news_vid = '".$page["id_nws"]."' ORDER BY order_vid
    ");
    $matches = array();

    preg_match_all('/{image}|{image-left}|{image-right}|{image-pan}/', (string)$page['contenido'], $matches);

    $text = (string)$page['contenido'];


    if(!empty($matches[0])){
        if (count($matches[0]) > 0) {
            for ($i=0; $i < count($matches[0]); $i++) {

                switch ($matches[0][$i]) {
                    case '{image-right}':
                        $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 350, 200, $page['titulo'], 'img-right');
                    break;

                    case '{image-pan}':
                        $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 1170, 350, $page['titulo'], 'img-pan');
                    break;

                    case '{image-left}':
                        $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 350, 200, $page['titulo'], 'img-left');
                    break;

                    default:
                        $img = '<img src="/media/images/news/'.$images[($i)]["image_img"].'" class="img-auto" alt="'.$images[($i)]["alt"].'" />';
                    break;
                }

                $text = preg_replace('/'.$matches[0][$i].'/', $img, $text, 1);
            }
        }
    }
 
    $text = str_replace('table table-striped table-bordered', 'cms-table', $text);

    if($key == 0){
        $smarty->assign("images", $images);
        $smarty->assign("videos", $videos);
        $smarty->assign("pagetext", $text);
    } else {
        $pages[$key]['images'] = $images;
        $pages[$key]['videos'] = $videos;
        $pages[$key]['contenido'] = $text;
    }
}

$smarty->assign("pages", $pages);

if ($showTeam == 1) {
    $teams = getRecords("
        SELECT teams.id_tms,
            teams.nombre_tms as nombre,
            teams.cargo_".$lang."_tms as cargo,
            teams.bio_".$lang."_tms as bio,
            teams.telefono_tms as telefono,
            teams.email_tms as email,
            teams.idiomas_tms as idiomas,
        (SELECT imagen_img FROM teams_fotos WHERE noticia_img = id_tms ORDER BY orden_img LIMIT 1) AS img
        FROM teams
        WHERE  activate_tms = 1
        ORDER BY order_tms ASC
    ");
    $smarty->assign("teams", $teams);
}
?>
