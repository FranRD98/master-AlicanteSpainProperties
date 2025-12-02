<?php

$langQuery = '';

foreach ($languages as $key => $value) {

    $langQuery .= "properties_loc1.name_".$value."_loc1 AS country_".$value.", ";
    $langQuery .= "properties_status.status_".$value."_sta as sale_".$value.", ";
    $langQuery .= "CASE WHEN properties_loc2.name_".$value."_loc2 IS NOT NULL THEN properties_loc2.name_".$value."_loc2 ELSE province1.name_".$value."_loc2  END AS province_".$value.", ";
    $langQuery .= "CASE WHEN properties_loc3.name_".$value."_loc3 IS NOT NULL THEN properties_loc3.name_".$value."_loc3 ELSE areas1.name_".$value."_loc3  END AS area_".$value.", ";
    $langQuery .= "CASE WHEN properties_loc4.name_".$value."_loc4 IS NOT NULL THEN properties_loc4.name_".$value."_loc4 ELSE towns.name_".$value."_loc4  END AS town_".$value.", ";
    $langQuery .= "CASE WHEN properties_types.types_".$value."_typ IS NOT NULL THEN properties_types.types_".$value."_typ ELSE types.types_".$value."_typ END AS type_".$value.", ";
    $langQuery .= "title_".$value."_prop as metatitle_".$value.",  ";

}

$propertyURLs = getRecords("

SELECT
    " . $langQuery . "
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
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE id_prop = '".simpleSanitize(($tokens[1]))."'

GROUP BY id_prop


");

foreach ($languages as $value) {

    if ($value == $language) {
        $smarty->assign('urlDefault', 'https://' . $_SERVER['HTTP_HOST'] . propURL(simpleSanitize(($tokens[1])), $language));
    } else {
        $smarty->assign('url' . strtoupper($value), 'https://' . $_SERVER['HTTP_HOST'] . propURL(simpleSanitize(($tokens[1])), $value));
    }
}

////////////

if (isset($_GET['pr']) && $_GET['pr'] == 'ok') {
    $prwv = '(activado_prop = 1 OR  activado_prop = 0)';
} else {
    $prwv = ' activado_prop = 1';

}


require_once($_SERVER["DOCUMENT_ROOT"] . '/modules/property/currencyexchange_class.php');

$property = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    properties_loc1.id_loc1 AS countryid,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS provinceid,
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS areaid,
    CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END AS townid,
    CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS typeid,
     CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
    (SELECT coast_".$lang."_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
    properties_properties.lat_long_gp_prop AS lat,
    properties_properties.zoom_gp_prop AS zoom,
    properties_status.status_".$lang."_sta as sale,
    properties_status.slug_sta as saleSlug,
    properties_status.id_sta as saleId,
    properties_status.id_sta,
    properties_properties.m2_prop,
    properties_properties.m2_utiles_prop,
    properties_properties.m2_solarium_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.m2_balcon_prop as m2b_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.aseos2_prop,
    properties_properties.cocinas_prop,
    properties_properties.armarios_empotrados_prop,
    properties_properties.coeficiente_ocupacion_prop,
    properties_properties.plazas_garaje_prop,
    properties_properties.construccion_prop,
    properties_properties.ascensor_prop,
    properties_properties.energia_prop,
    properties_properties.user_prop,
    properties_properties.vista360_prop,
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
    alt_".$lang."_img as alt,
    properties_properties.titulo_".$lang."_prop as titulo,
    properties_properties.descripcion_".$lang."_prop as description,
    title_".$lang."_prop as metatitle,
    description_".$lang."_prop as metadescription,
    keywords_".$lang."_prop as metakeywords,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    (SELECT kitchen_".$lang."_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop ) AS cocinas_prop,
    (SELECT condition_".$lang."_cond FROM properties_condition WHERE id_cond = estado_prop ) AS estado_prop,
    (SELECT planta_".$lang."_plnt FROM properties_planta WHERE id_plnt = planta_prop ) AS planta_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.precio_desde_prop,
    distance_beach_prop,
    distance_airport_prop,
    distance_amenities_prop,
    distance_golf_prop,
    distance_beach_med_prop,
    distance_airport_med_prop,
    distance_amenities_med_prop,
    distance_golf_med_prop,
    suma_prop,
    gastos_prop,
    orientacion_prop,
    direccion_prop,
    show_direccion_prop,
    activado_prop

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

WHERE id_prop = '".simpleSanitize(($tokens[1]))."'

GROUP BY id_prop


");


$description_has_p = preg_match('/<p>/', $property[0]['description']);
$smarty->assign('description_has_p', $property[0]['description']);

$smarty->assign("property", $property);

if($property[0]['user_prop'] == 0) {
    $property[0]['user_prop'] = 40;
}

if ((int)$property[0]['zoom'] != '') {
    $property[0]['zoom'] = 13;
}

$user = getRecords("

    SELECT

	users.nombre_usr,
	users.bio_es_usr,
	users.image_usr

    FROM users

    WHERE id_usr = '".simpleSanitize(($property[0]['user_prop']))."'

    ORDER BY users.registrationdate_usr DESC

    LIMIT 1
");

$smarty->assign("user", $user);


$nombre_usr = $user[0]['nombre_usr'] ?? '';
$bio_es_usr = $user[0]['bio_es_usr'] ?? '';
$image_usr = $user[0]['image_usr'] ?? '';

$smarty->assign("nombreuser",  $nombre_usr);
$smarty->assign("descruser",  $bio_es_usr);
$smarty->assign("imaguser",  $image_usr);

savelogprop($property[0]['id_prop'], '2');

if ($property[0]['metatitle'] != '') {
    $title = $property[0]['metatitle'];
} else {
    $title = $property[0]['sale'] . ' &raquo; ' . $property[0]['type'] . ' &raquo; ' . $property[0]['area'] . ' &raquo; ' . $property[0]['town'];
}

$smarty->assign("metaTitle", trim(strip_tags($title)));

if ($property[0]['metadescription'] != '') {
    $description = $property[0]['metadescription'];
} else {
    $description = $title . '. ' . $property[0]['description'];
}

$smarty->assign("metaDescription", trim(strip_tags($description)));

$smarty->assign("metaKeywords", trim(strip_tags($property[0]['metakeywords'])));

$urlCom = propURL($property[0]['id_prop'], $lang);

$url = 'https://' . $_SERVER['HTTP_HOST'] . $urlCom;

$smarty->assign("metaURL", $url);


if ($_SERVER['REQUEST_URI'] != $urlCom && $lang!='zh') {
 header("HTTP/1.1 301 Moved Permanently");
 header("Location: $urlCom");
}


$img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/properties/thumbnails/' . $property[0]['id_img'] . '_lg.jpg';

$smarty->assign("metaImage", $img);


$images = getRecords("

SELECT id_img, alt_".$lang."_img as alt FROM  properties_images WHERE  property_img = '".simpleSanitize(($tokens[1]))."' ORDER BY order_img");

$smarty->assign("images", $images);



$planos = getRecords("

SELECT id_img, alt_".$lang."_img as alt FROM  properties_planos WHERE  property_img = '".simpleSanitize(($tokens[1]))."' ORDER BY order_img");

$smarty->assign("planos", $planos);



$files = getRecords("

SELECT file_fil, id_fil, name_".$lang."_fil as name FROM  properties_files WHERE  property_fil = '".simpleSanitize(($tokens[1]))."' AND (lang_fil IS NULL OR lang_fil = '' OR lang_fil = '".$lang."') ORDER BY order_fil");

$smarty->assign("files", $files);

$videos = getRecords("

SELECT video_vid, id_vid FROM  properties_videos WHERE  property_vid = '".simpleSanitize(($tokens[1]))."' ORDER BY order_vid");

$smarty->assign("videos", $videos);

$view360 = getRecords("

SELECT video_360, id_360 FROM  properties_360 WHERE  property_360 = '".simpleSanitize(($tokens[1]))."' ORDER BY order_360");

$smarty->assign("view360", $view360);

$precios = getRecords("
SELECT properties_prices.from_prc,
    properties_prices.to_prc,
    properties_prices.price_prc
FROM properties_prices
WHERE properties_prices.property_prc = '".$tokens[1]."' AND properties_prices.to_prc >= CURDATE()
ORDER BY properties_prices.from_prc ASC, properties_prices.to_prc ASC
");

$smarty->assign("precios", $precios);

$features = getRecords("

    SELECT CASE WHEN properties_features.feature_".$lang."_feat IS NOT NULL THEN properties_features.feature_".$lang."_feat ELSE features.feature_".$lang."_feat  END AS feat
    FROM properties_property_feature INNER JOIN properties_features features ON properties_property_feature.feature = features.id_feat LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
    WHERE properties_property_feature.property = '".simpleSanitize(($tokens[1]))."' ORDER BY properties_features.order_feat ASC");

$smarty->assign("features", $features);


$featuresXML = getRecords("

    SELECT CASE WHEN properties_features_priv.feature_".$lang."_feat IS NOT NULL THEN properties_features_priv.feature_".$lang."_feat ELSE features.feature_".$lang."_feat  END AS feat
    FROM properties_property_feature_priv INNER JOIN properties_features_priv features ON properties_property_feature_priv.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
    WHERE properties_property_feature_priv.property = '".simpleSanitize(($tokens[1]))."' ORDER BY properties_features_priv.order_feat ASC");

$smarty->assign("featuresXML", $featuresXML);

$zonas = getRecords("

    SELECT

	news.id_nws,
	news.title_".$lang."_nws as titulo,
	news.content_".$lang."_nws as contenido,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_".$lang."_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE type_nws = 6 AND quick_town_nws = '".simpleSanitize(($property[0]['areaid']))."'

    ORDER BY news.date_nws DESC

    LIMIT 1
");

$smarty->assign("zonas", $zonas);



$exch=new CurrencyConverter();

$pas = $property[0]['precio'];
$exchange = "<ul class=\"list-exchange list-unstyled\">";
if ($actLibra == 1) {
    $exch->fromTo("EUR", "GBP");
    $exchange  .= "<li><strong class=\"c3\">".$langStr['Pounds'].":</strong> ".number_format($exch->convertAmount($pas),0,',','.')." GBP</li>";
}
if ($actRublo == 1) {
    $exch->fromTo("EUR", "RUB");
    $exchange  .= "<li><strong class=\"c3\">".$langStr['Russian Ruble'].":</strong> ".number_format($exch->convertAmount($pas),0,',','.')." RUB</li>";
}
if ($actFrancoSuizo == 1) {
    $exch->fromTo("EUR", "CHF");
    $exchange  .= "<li><strong class=\"c3\">".$langStr['Switzerland Franc'].":</strong> ".number_format($exch->convertAmount($pas),0,',','.')." CHF</li>";
}
if ($actYuan == 1) {
    $exch->fromTo("EUR", "CNY");
    $exchange  .= "<li><strong class=\"c3\">".$langStr['China Yuan'].":</strong> ".number_format($exch->convertAmount($pas),0,',','.')." CNY</li>";
}
if ($actDolar == 1) {
    $exch->fromTo("EUR", "USD");
    $exchange  .= "<li><strong class=\"c3\">".$langStr['Dollar'].":</strong> ".number_format($exch->convertAmount($pas),0,',','.')." USD</li>";
}
if ($CoronaSueca == 1) {
    $exch->fromTo("EUR", "SEK");
    $exchange  .= "<li><strong class=\"c3\">".$langStr['Corona Sueca'].":</strong> ".number_format($exch->convertAmount($pas),0,',','.')." SEK</li>";
}
if ($CoronaNoruega == 1) {
    $exch->fromTo("EUR", "NOK");
    $exchange  .= "<li><strong class=\"c3\">".$langStr['Corona Noruega'].":</strong> ".number_format($exch->convertAmount($pas),0,',','.')." NOK</li>";
}
$exchange  .= "</ul>";

$smarty->assign("exchange", $exchange);

$theFavsDB = getRecords("
SELECT COUNT(id) AS num_favorites
FROM users_favorites
WHERE user = '".simpleSanitize(($_SESSION['kt_login_id']))."'
AND property = '".simpleSanitize(($tokens[1]))."'
");

$theFavs = array();
if(isset($_COOKIE['fav']))
    $theFavs = explode(",",$_COOKIE['fav']);

if (in_array($property[0]['id_prop'], $theFavs ) || $theFavsDB[0]['num_favorites']==1) {
    $smarty->assign("isFav", '1');
} else {
    $smarty->assign("isFav", '0');
}

if ($property[0]['id_prop'] != '') {
    if(isset($_COOKIE['viewed-props'])){
        $theArray = explode(",",$_COOKIE['viewed-props']);
        $thenewArray = array();
        $i = 0;
        foreach($theArray  as $value){
            if($value != $property[0]['id_prop']){
                if ($i++ < 2) {
                    array_push($thenewArray,$value);
                }
            }
        }
        array_unshift($thenewArray,$property[0]['id_prop']);
        setcookie("viewed-props",implode(',',$thenewArray), mktime(21,00,0,12,31,2030),"/","",0);
    }
    else {
        setcookie("viewed-props",$property[0]['id_prop'], mktime(21,00,0,12,31,2030),"/","",0);
    }
}

$precio = $property[0]['precio'] ;
$precio_limite_inferior = $precio-($precio*0.2);
$precio_limite_superior = $precio+($precio*0.2);

$similaresQuery = ("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
    (SELECT coast_".$lang."_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
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
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1

%s

AND id_prop != '".simpleSanitize(($tokens[1]))."'

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT 9

");

$precioQuery = "AND preci_reducidoo_prop >= '".simpleSanitize(($precio_limite_inferior))."' AND preci_reducidoo_prop <= '".simpleSanitize(($precio_limite_superior))."'";
$tipoQuery = "AND CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END = '".str_replace('\'', '', $property[0]['type'])."'";
$ciudadQuery = "AND CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END = '".str_replace('\'', '', $property[0]['area'])."'";
$areaQuery = "AND CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END = '".str_replace('\'', '', $property[0]['town'])."'";

$similares = getRecords(sprintf($similaresQuery, " " . $tipoQuery . " " . $ciudadQuery . " " . $precioQuery . " " . $areaQuery . ""));

if ( isset($similares[2]['id_prop']) && $similares[2]['id_prop'] == '') {
    $similares = getRecords(sprintf($similaresQuery, " " . $tipoQuery . " " . $ciudadQuery . " " . $precioQuery . ""));
}

if ( isset($similares[2]['id_prop']) && $similares[2]['id_prop'] == '') {
    $similares = getRecords(sprintf($similaresQuery, " " . $ciudadQuery . " " . $precioQuery . ""));
}

if ( isset($similares[2]['id_prop']) && $similares[2]['id_prop'] == '') {
    $similares = getRecords(sprintf($similaresQuery, " " . $precioQuery . " "));
}

$smarty->assign("similares", $similares);

$nombreMeses = preg_replace('/\"/', '', $langStr["NombreMeses"]);

$nombreMeses = explode(',', $nombreMeses);


function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}


$query_rsInsert2 = "

    INSERT INTO  `properties_views` ( `id_vws` , `property_vws`, `ip_vws`, `date_vws` ) VALUES
    ( NULL ,  '".simpleSanitize(($tokens[1]))."',  '".getIp()."',  '".date("Y-m-d H:i:s")."' )

";
mysqli_query($inmoconn,$query_rsInsert2);


$smarty->assign("nombreMeses", $nombreMeses);


$http_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$smarty->assign('http_referer', $http_referer);

?>
