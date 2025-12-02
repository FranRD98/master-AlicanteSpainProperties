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

    AND id_nws = '".simpleSanitize(($numpag))."'

    ORDER BY news.date_nws DESC

    LIMIT 1
");

$smarty->assign("pages", $pages);


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
    $description = $metaDescriptionDefault[$lang];
}

$smarty->assign("metaDescription", trim(strip_tags($description)));

$smarty->assign("metaKeywords", trim(strip_tags($pages[0]['keywords'])));

$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$smarty->assign("metaURL", $url);

$img = 'http://' . $_SERVER['HTTP_HOST'] . '/media/images/website/no-image.png';

$smarty->assign("metaImage", $img);


$images = getRecords("

    SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE noticia_img = '".simpleSanitize(($numpag))."' ORDER BY orden_img

");

$smarty->assign("images", $images);

$matches = array();

preg_match_all('/{image-left}|{image-right}|{image-pan}/', (string)$pages[0]['contenido'], $matches);

$text = (string)$pages[0]['contenido'];

if (isset($matches[0]) && is_array($matches[0]) && count($matches[0]) > 0) {

    for ($i=0; $i < count($matches[0]); $i++) {

        switch ($matches[0][$i]) {
            case '{image-right}':
                $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 350, 200, $images[($i)]['alt'], 'img-right');
                break;
            case '{image-pan}':
                $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 930, 200, $images[($i)]['alt'], 'img-pan');
                break;

            default:
                $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 350, 200, $images[($i)]['alt'], 'img-left');
                break;
        }

        $text = preg_replace('/'.$matches[0][$i].'/', $img, $text, 1);

    }
}

$smarty->assign("pagetext", $text);

$properties = getRecords("

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
    properties_properties.piscina_prop,
    id_prop,
    image_img,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    properties_properties.piscina_prop,
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

WHERE activado_prop = 1 AND procesada_img = 1 AND force_hide_prop != 1

GROUP BY id_prop

ORDER BY properties_properties.referencia_prop
");

$smarty->assign("properties", $properties);

$news = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.content_".$lang."_nws as contenido,
        news.titlew_".$lang."_nws as titulow,
        news.date_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img

    FROM news

    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 1 AND activate_nws = 1

    ORDER BY news.date_nws DESC
");

$smarty->assign("news", $news);

$langingPages2 = getRecords("

    SELECT

        news.title_".$lang."_nws as titulo

    FROM news

    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 3 AND activate_nws = 1

    ORDER BY news.date_nws DESC


");

$smarty->assign("langingPages2", $langingPages2);

$quicklinks2 = getRecords("

    SELECT

        news.title_".$lang."_nws as titulo

    FROM news

    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 4 AND activate_nws = 1

    ORDER BY news.date_nws DESC

");

$smarty->assign("quicklinks2", $quicklinks2);
 ?>