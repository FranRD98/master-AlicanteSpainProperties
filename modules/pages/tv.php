<?php


$tvQuery = "
    SELECT
        properties_loc1.name_".$lang."_loc1 AS country,
        CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
        CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
        CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
        CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
        properties_status.status_".$lang."_sta as sale,
        properties_properties.descripcion_".$lang."_prop  as descr,
        properties_properties.m2_prop,
        properties_properties.precio_prop as old_precio,
        properties_properties.preci_reducidoo_prop as precio,
        properties_properties.habitaciones_prop,
        properties_properties.aseos_prop,
        properties_properties.referencia_prop as ref,
        properties_properties.m2_parcela_prop as m2p_prop,
        id_prop,
        id_img,
        image_img,
        properties_properties.vendido_prop,
        properties_properties.nuevo_prop,
        (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
(SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
        properties_properties.alquilado_prop,
        properties_properties.reservado_prop,
        properties_properties.watermark_prop,
        properties_properties.aseos2_prop,
        properties_properties.precio_desde_prop,
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
        LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND order_img = 1
        LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND tv_prop = 1
    GROUP BY id_prop
    ORDER BY id_prop
";
$tvProps = getRecordsAndCache($tvQuery, 'tv-props');

foreach ($tvProps as $key => $prop) {
    if ( isset($prop["id_prop"]) && $prop["id_prop"] != 0) {
        $tvImagesQuery = "
        SELECT
        image_img
        FROM properties_images
        WHERE properties_images.property_img = ".$prop["id_prop"]."
        ORDER BY order_img, RAND()
        LIMIT 1, 3
        ";
        $tvProps[$key]["images"] = getRecords($tvImagesQuery);
    }
}

$smarty->assign("tv", $tvProps);

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


if ($pages[0]['titulow'] != '') {
    $title = $pages[0]['titulow'];
} else {
    $title = $pages[0]['titulo'];
}

if ($title == '') {
    $title = $metaTitleDefault;
}

$smarty->assign("metaTitle", trim(strip_tags($title)));

if ($pages[0]['contenidow'] != '') {
    $description = $pages[0]['contenidow'];
} else {
    $description = $pages[0]['contenido'];
}

if ($description == '') {
    $description = $metaDescriptionDefault;
}

$smarty->assign("metaDescription", trim(strip_tags($description)));

$smarty->assign("metaKeywords", trim(strip_tags($pages[0]['keywords'])));

$url = 'https://' . $_SERVER['HTTP_HOST'] . '' . $_SERVER['REQUEST_URI'];

$smarty->assign("metaURL", $url);

if (preg_match('/https?:\/\//', $pages[0]['img'])) {
    $img = $pages[0]['img'];
} else {
    $img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/' . $pages[0]['img'];
}
if ($img == 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/') {
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

    if (count($matches[0] > 0)) {
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

?>
