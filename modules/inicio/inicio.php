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

    WHERE  id_nws = '".simpleSanitize(($numpag))."'

    ORDER BY news.date_nws DESC

    LIMIT 1
");

if ($pages[0]['titulow'] != '') {
    $title = $pages[0]['titulow'];
} else {
    $title = $pages[0]['titulo'];
}

if (isset($_GET['idquick']) && $_GET['idquick'] != '') {
    $smarty->assign("tituloquick", trim(strip_tags($pages[0]['titulo'])));
}

$smarty->assign("metaTitle", trim(strip_tags($title)));

if ($pages[0]['contenidow'] != '') {
    $description = $pages[0]['contenidow'];
} else {
    $description = $pages[0]['contenido'];
}

$smarty->assign("metaDescription", trim(strip_tags($description)));

$smarty->assign("metaKeywords", trim(strip_tags($pages[0]['keywords'])));

$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$smarty->assign("metaURL", $url);

$img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/website/no-image.png';

$smarty->assign("metaImage", $img);

$query = "SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE noticia_img = '".simpleSanitize(($numpag))."' ORDER BY orden_img";
$images = getRecords($query);

//var_dump($query);

$smarty->assign("images", $images);

$matches = array();

preg_match_all('/{image-left}|{image-right}|{image-pan}/', (string)$pages[0]['contenido'], $matches);

$text = str_replace(array('<p>{image-right}</p>'), '{image-right}', (string)$pages[0]['contenido']);
$text = str_replace(array('<p>{image-pan}</p>'), '{image-pan}', (string)$pages[0]['contenido']);
$text = str_replace(array('<p>{image-left}</p>'), '{image-left}', (string)$pages[0]['contenido']);

//var_dump($matches); die;

if(!empty($matches[0])){
   if (count($matches[0]) > 0) {
      for ($i=0; $i < count($matches[0]); $i++) {

         switch ($matches[0][$i]) {
               case '{image-right}':
                  $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 500, 350, $pages[0]['titulo'], 'img-right');
                  break;
               case '{image-pan}':
                  $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 1300, 400, $pages[0]['titulo'], 'img-pan');
                  break;

               default:
                  $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 500, 350, $pages[0]['titulo'], 'img-left');
                  break;
         }

         $text = preg_replace('/'.$matches[0][$i].'/', $img, $text, 1);

      }
   }
}

$smarty->assign("home", $text);
$smarty->assign("tituloland", $pages[0]['titulo']);

if ( $seccion == 'landing' || (isset($_GET['idquick']) && $_GET['idquick'] != '') ) {

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

        WHERE id_nws = '".simpleSanitize(($numpag))."'

        LIMIT 1


        ");

        foreach ($languages as $value) {

           if ($value == $language) {

               if ($newsURLs[0]['titulo_' . $value] != '') {
                   $urlDefault = 'https://' . $_SERVER['HTTP_HOST'] . '/' . slug($newsURLs[0]['titulo_' . $value]) . '.html';
               } else {
                   $urlDefault = 'https://' . $_SERVER['HTTP_HOST'] . '/';
               }

           }
        }

        if ($newsURLs[0]['titulo_ca'] != '') {
            $urlCA = 'https://' . $_SERVER['HTTP_HOST'] . '/ca/' . slug($newsURLs[0]['titulo_ca']) . '.html';
         } else {
            $urlCA = 'https://' . $_SERVER['HTTP_HOST'] . '/ca/';
         }

        if ($newsURLs[0]['titulo_da'] != '') {
           $urlDA = 'https://' . $_SERVER['HTTP_HOST'] . '/da/' . slug($newsURLs[0]['titulo_da']) . '.html';
        } else {
           $urlDA = 'https://' . $_SERVER['HTTP_HOST'] . '/da/';
        }

        if ($newsURLs[0]['titulo_de'] != '') {
           $urlDE = 'https://' . $_SERVER['HTTP_HOST'] . '/de/' . slug($newsURLs[0]['titulo_de']) . '.html';
        } else {
           $urlDE = 'https://' . $_SERVER['HTTP_HOST'] . '/de/';
        }

        if ($newsURLs[0]['titulo_el'] != '') {
           $urlEL = 'https://' . $_SERVER['HTTP_HOST'] . '/el/' . slug($newsURLs[0]['titulo_el']) . '.html';
        } else {
           $urlEL = 'https://' . $_SERVER['HTTP_HOST'] . '/el/';
        }

        if ($newsURLs[0]['titulo_en'] != '') {
           $urlEN = 'https://' . $_SERVER['HTTP_HOST'] . '/en/' . slug($newsURLs[0]['titulo_en']) . '.html';
        } else {
           $urlEN = 'https://' . $_SERVER['HTTP_HOST'] . '/en/';
        }

        if ($newsURLs[0]['titulo_es'] != '') {
           $urlES = 'https://' . $_SERVER['HTTP_HOST'] . '/es/' . slug($newsURLs[0]['titulo_es']) . '.html';
        } else {
           $urlES = 'https://' . $_SERVER['HTTP_HOST'] . '/es/';
        }

        if ($newsURLs[0]['titulo_fi'] != '') {
           $urlFI = 'https://' . $_SERVER['HTTP_HOST'] . '/fi/' . slug($newsURLs[0]['titulo_fi']) . '.html';
        } else {
           $urlFI = 'https://' . $_SERVER['HTTP_HOST'] . '/fi/';
        }

        if ($newsURLs[0]['titulo_fr'] != '') {
           $urlFR = 'https://' . $_SERVER['HTTP_HOST'] . '/fr/' . slug($newsURLs[0]['titulo_fr']) . '.html';
        } else {
           $urlFR = 'https://' . $_SERVER['HTTP_HOST'] . '/fr/';
        }

        if ($newsURLs[0]['titulo_is'] != '') {
           $urlIS = 'https://' . $_SERVER['HTTP_HOST'] . '/is/' . slug($newsURLs[0]['titulo_is']) . '.html';
        } else {
           $urlIS = 'https://' . $_SERVER['HTTP_HOST'] . '/is/';
        }

        if ($newsURLs[0]['titulo_it'] != '') {
           $urlIT = 'https://' . $_SERVER['HTTP_HOST'] . '/it/' . slug($newsURLs[0]['titulo_it']) . '.html';
        } else {
           $urlIT = 'https://' . $_SERVER['HTTP_HOST'] . '/it/';
        }

        if ($newsURLs[0]['titulo_nl'] != '') {
           $urlNL = 'https://' . $_SERVER['HTTP_HOST'] . '/nl/' . slug($newsURLs[0]['titulo_nl']) . '.html';
        } else {
           $urlNL = 'https://' . $_SERVER['HTTP_HOST'] . '/nl/';
        }

        if ($newsURLs[0]['titulo_no'] != '') {
           $urlNO = 'https://' . $_SERVER['HTTP_HOST'] . '/no/' . slug($newsURLs[0]['titulo_no']) . '.html';
        } else {
           $urlNO = 'https://' . $_SERVER['HTTP_HOST'] . '/no/';
        }

        if ($newsURLs[0]['titulo_pt'] != '') {
           $urlPT = 'https://' . $_SERVER['HTTP_HOST'] . '/pt/' . slug($newsURLs[0]['titulo_pt']) . '.html';
        } else {
           $urlPT = 'https://' . $_SERVER['HTTP_HOST'] . '/pt/';
        }

        if ($newsURLs[0]['titulo_ru'] != '') {
           $urlRU = 'https://' . $_SERVER['HTTP_HOST'] . '/ru/' . slug($newsURLs[0]['titulo_ru']) . '.html';
        } else {
           $urlRU = 'https://' . $_SERVER['HTTP_HOST'] . '/ru/';
        }

        if ($newsURLs[0]['titulo_se'] != '') {
           $urlSE = 'https://' . $_SERVER['HTTP_HOST'] . '/se/' . slug($newsURLs[0]['titulo_se']) . '.html';
        } else {
           $urlSE = 'https://' . $_SERVER['HTTP_HOST'] . '/se/';
        }

        if ($newsURLs[0]['titulo_zh'] != '') {
           $urlZH = 'https://' . $_SERVER['HTTP_HOST'] . '/zh/' . slug($newsURLs[0]['titulo_zh']) . '.html';
        } else {
           $urlZH = 'https://' . $_SERVER['HTTP_HOST'] . '/zh/';
        }

        if ($newsURLs[0]['titulo_pl'] != '') {
           $urlPL = 'https://' . $_SERVER['HTTP_HOST'] . '/pl/' . slug($newsURLs[0]['titulo_pl']) . '.html';
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
}

 ?>
