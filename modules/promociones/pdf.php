<?php
error_reporting(E_ALL);
// ini_set("display_errors", 1);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$_GET['lang'].'.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
use Spipu\Html2Pdf\Html2Pdf;

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/modules/promociones/view/pdf/pdf.html');
$html = ob_get_contents();
ob_end_clean();

$_GET['lang'] = simpleSanitize($_GET['lang']);

$property[0]['ref'] = 1;

$promotion = getRecords("

    SELECT news.id_nws,
        news.title_" . $_GET['lang'] . "_nws as titulo,
        news.titulo_prom_" . $_GET['lang'] . "_nws as titulo_prom,
        news.content_" . $_GET['lang'] . "_nws as contenido,
        news.titlew_" . $_GET['lang'] . "_nws as titulow,
        news.description_" . $_GET['lang'] . "_nws as contenidow,
        news.keywords_" . $_GET['lang'] . "_nws as keywords,
        news.tags_" . $_GET['lang'] . "_nws as tags,
        news.date_nws,
        news.quick_location_nws,
        news.quick_type_nws,
        news.quick_status_nws,
        news.quick_town_nws,
        news.quick_province_nws,
        quick_province_nws as provincia,
        quick_town_nws as ciudad,

        quick_price_from_nws,
        quick_price_up_to_nws,
        direccion_gp_prop,
        lat_long_gp_prop,
        zoom_gp_prop,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_" . $_GET['lang'] . "_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE news.title_" . $_GET['lang'] . "_nws  != '' AND news.content_" . $_GET['lang'] . "_nws != '' AND type_nws = 999

    AND id_nws = '" . simpleSanitize($_GET['p']) . "'

    ORDER BY news.date_nws DESC

    LIMIT 1
");

$precioReferencia = getRecords("

SELECT

    MIN(preci_reducidoo_prop) as precio_desde,
    MAX(preci_reducidoo_prop) as precio_hasta,
    MIN(m2_utiles_prop) as m2_min,
    MAX(m2_utiles_prop) as m2_max,
    MIN(m2_prop) as m2b_min,
    MAX(m2_prop) as m2b_max,
    MIN(habitaciones_prop) as beds_min,
    MAX(habitaciones_prop) as beds_max,
    MIN(aseos_prop) as baths_min,
    MAX(aseos_prop) as baths_max,
    (SELECT pool_" . $_GET['lang'] . "_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_" . $_GET['lang'] . "_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    energia_prop,
    lat_long_gp_prop,
    zoom_gp_prop,
    id_prop

    FROM properties_properties

    WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = " . simpleSanitize($_GET['p']) . "

LIMIT 1

");

$features = getRecords("
    SELECT CASE WHEN properties_features_priv.feature_" . $_GET['lang'] . "_feat IS NOT NULL THEN properties_features_priv.feature_" . $_GET['lang'] . "_feat ELSE features.feature_" . $_GET['lang'] . "_feat  END AS feat
    FROM promotions_promotions_feature INNER JOIN properties_features_priv features ON promotions_promotions_feature.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
    WHERE promotions_promotions_feature.promotion = '" . simpleSanitize($_GET['p']) . "' ORDER BY feat ASC LIMIT 10
");

$images = getRecords("
    SELECT id_img,
    imagen_img
    FROM news_fotos
    WHERE noticia_img = '".simpleSanitize($_GET['p'])."' ORDER BY orden_img
");

$properties = getRecords("

SELECT

    properties_loc1.name_" . $_GET['lang'] . "_loc1 AS country,
    CASE WHEN properties_loc2.name_" . $_GET['lang'] . "_loc2 IS NOT NULL THEN properties_loc2.name_" . $_GET['lang'] . "_loc2 ELSE province1.name_" . $_GET['lang'] . "_loc2  END AS province,
    CASE WHEN properties_loc3.name_" . $_GET['lang'] . "_loc3 IS NOT NULL THEN properties_loc3.name_" . $_GET['lang'] . "_loc3 ELSE areas1.name_" . $_GET['lang'] . "_loc3  END AS area,
    CASE WHEN properties_loc4.name_" . $_GET['lang'] . "_loc4 IS NOT NULL THEN properties_loc4.name_" . $_GET['lang'] . "_loc4 ELSE towns.name_" . $_GET['lang'] . "_loc4  END AS town,
    CASE WHEN properties_types.types_" . $_GET['lang'] . "_typ IS NOT NULL THEN properties_types.types_" . $_GET['lang'] . "_typ ELSE types.types_" . $_GET['lang'] . "_typ END AS type,
    properties_properties.lat_long_gp_prop AS lat,
    properties_status.status_" . $_GET['lang'] . "_sta as sale,
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
    alt_" . $_GET['lang'] . "_img as alt,
    properties_properties.descripcion_" . $_GET['lang'] . "_prop as descr,
    title_" . $_GET['lang'] . "_prop as metatitle,
    titulo_" . $_GET['lang'] . "_prop as titulo,
    description_" . $_GET['lang'] . "_prop as metadescription,
    properties_properties.referencia_prop,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_" . $_GET['lang'] . "_pl FROM properties_pool WHERE id_pl = piscina_prop  LIMIT 1) AS piscina_prop,
    (SELECT parking_" . $_GET['lang'] . "_prk FROM properties_parking WHERE id_prk = parking_prop  LIMIT 1) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    (SELECT file_fil FROM properties_files WHERE property_fil = id_prop AND (lang_fil IS NULL OR lang_fil = '' OR lang_fil = '" . $_GET['lang'] . "') LIMIT 1) AS descarga,
    (SELECT image_img FROM properties_planos WHERE property_img = id_prop LIMIT 1) AS descarga,
    (SELECT count(*) FROM properties_images WHERE properties_properties.id_prop = properties_images.property_img) as total_images
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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1 AND promocion_prop = " . simpleSanitize($_GET['p']) . "

GROUP BY id_prop

ORDER BY id_prop

");

// H1
if ($promotion[0]['titulo_prom'] != '') {
    $title = $promotion[0]['titulo_prom'];
} else {
    $title = $promotion[0]['titulo'];
}

$html = preg_replace('/{H1}/', $title , $html);

// H2
$html = preg_replace('/{H2}/', $promotion[0]['provincia'] . '. ' . $promotion[0]['ciudad'] , $html);

// No image
$noimage = $_SERVER["DOCUMENT_ROOT"] . '/media/images/website/no-image.png';
// IMGBIG
if (preg_match('/https?:/', $images[0]['imagen_img'])) {
    if ($images[0]['imagen_img'] != '') {
        $html = preg_replace('/{IMGBIG}/', $images[0]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGBIG}/', $noimage, $html);
    }
} else {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/".$images[0]['imagen_img']) && $images[0]['imagen_img'] != '') {
        $html = preg_replace('/{IMGBIG}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/news/'.$images[0]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGBIG}/', $noimage, $html);
    }
}

// IMGSMALL1
if (preg_match('/https?:/', $images[1]['imagen_img'])) {
    if ($images[1]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL1}/', $images[1]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL1}/', $noimage, $html);
    }
} else {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/".$images[1]['imagen_img']) && $images[1]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL1}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/news/'.$images[1]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL1}/', $noimage, $html);
    }
}

// IMGSMALL2
if (preg_match('/https?:/', $images[2]['imagen_img'])) {
    if ($images[2]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL2}/', $images[2]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL2}/', $noimage, $html);
    }
} else {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/".$images[2]['imagen_img']) && $images[2]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL2}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/news/'.$images[2]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL2}/', $noimage, $html);
    }
}

// IMGSMALL3
if (preg_match('/https?:/', $images[3]['imagen_img'])) {
    if ($images[3]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL3}/', $images[3]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL3}/', $noimage, $html);
    }
} else {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/".$images[3]['imagen_img']) && $images[3]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL3}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/news/'.$images[3]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL3}/', $noimage, $html);
    }
}

// PRICE-FROM
$price_from = strtoupper($langStr["Precio desde"]) . '<br><span>€' . number_format($precioReferencia[0]['precio_desde'], 0, ',', '.') . '</span>';
$html = preg_replace('/{PRICE-FROM}/', $price_from , $html);

// PRICE-TO
$price_to = strtoupper($langStr["Precio hasta"]) . '<br><span>€' . number_format($precioReferencia[0]['precio_hasta'], 0, ',', '.') . '</span>';
$html = preg_replace('/{PRICE-TO}/', $price_to , $html);

// ICONOS
$iconos = '<table class="tableIcons" style="width: 100%;border: none;" cellspacing="0" cellpadding="0"><tr>';
$iconos .= '<td style="width:' . 100/7 . '%;"><img src="../../media/images/website/icon-beds.png"><br><span>' . number_format($precioReferencia[0]['beds_min'], 0, ',', '.') . ' → ' . number_format($precioReferencia[0]['beds_max'], 0, ',', '.') . '</span></td>';
$iconos .= '<td style="width:' . 100/7 . '%;"><img src="../../media/images/website/icon-baths.png"><br><span>' . number_format($precioReferencia[0]['baths_min'], 0, ',', '.') . ' → ' . number_format($precioReferencia[0]['baths_max'], 0, ',', '.') . '</span></td>';
$iconos .= '<td style="width:' . 100/7 . '%;"><img src="../../media/images/website/icon-m2.png"><br><span>' . number_format($precioReferencia[0]['m2_min'], 0, ',', '.') . ' → ' . number_format($precioReferencia[0]['m2_max'], 0, ',', '.') . 'm<sup>2</sup></span></td>';
$iconos .= '<td style="width:' . 100/7 . '%;"><img src="../../media/images/website/icon-m2p.png"><br><span>' . number_format($precioReferencia[0]['m2b_min'], 0, ',', '.') . ' → ' . number_format($precioReferencia[0]['m2b_max'], 0, ',', '.') . 'm<sup>2</sup></span></td>';
$iconos .= '<td style="width:' . 100/7 . '%;"><img src="../../media/images/website/icon-pool.png"><br><span>' . $precioReferencia[0]['piscina_prop'] . '</span></td>';
$iconos .= '<td style="width:' . 100/7 . '%;"><img src="../../media/images/website/icon-parking.png"><br><span>' . $precioReferencia[0]['parking_prop'] . '</span></td>';
if ($property[0]['energia_prop'] != '' && $property[0]['energia_prop'] != '0') {
    $energy = $property[0]['energia_prop'];
} else {
    $energy = $langStr["En proceso"];
}
$iconos .= '<td style="width:' . 100/7 . '%;"><img src="../../media/images/website/energia.png"><br><span>' . $energy . '</span></td>';
$iconos .= '</tr></table>';
$html = preg_replace('/{ICONOS}/', $iconos , $html);

// IMGSMALL4
if (preg_match('/https?:/', $images[4]['imagen_img'])) {
    if ($images[4]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL4}/', $images[4]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL4}/', $noimage, $html);
    }
} else {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/".$images[4]['imagen_img']) && $images[4]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL4}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/news/'.$images[4]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL4}/', $noimage, $html);
    }
}

// IMGSMALL5
if (preg_match('/https?:/', $images[5]['imagen_img'])) {
    if ($images[5]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL5}/', $images[5]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL5}/', $noimage, $html);
    }
} else {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/".$images[5]['imagen_img']) && $images[5]['imagen_img'] != '') {
        $html = preg_replace('/{IMGSMALL5}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/news/'.$images[5]['imagen_img'], $html);
    } else {
        $html = preg_replace('/{IMGSMALL5}/', $noimage, $html);
    }
}

// FEATURES
$featuresTxt = '';
$keyStart = '<tr>';
$keyEnd = '</tr>';
if($features[0]['feat'] != ''){
    $featuresTxt .= '<h2 style="margin-top:15px;">'.$langStr["Características"].'</h2>';
    $featuresTxt .= '<table style="width: 100%;border: none;" cellspacing="0" cellpadding="0"><tbody>';
    foreach ($features as $key => $feature) {
        if ($feature['feat'] != '') {
            if(($key+1) % 2 == 0){
                $featuresTxt .=  '<td style="width:50%;"><img src="../../media/images/website/icon-pdf.png">' . $feature['feat'] . '</td>'.$keyEnd;
            }
            else{
                $featuresTxt .=  $keyStart.'<td style="width:50%;"><img src="../../media/images/website/icon-pdf.png">' . $feature['feat'] . '</td>';
            }
        }
    }
    if(count($features) % 2 == 0){
        $featuresTxt .= '</tbody></table>';
    }
    else{
     $featuresTxt .= '</tr></tbody></table>';
    }
}

/*
$featuresTxt .= '<h2 style="margin-top:15px;">'.$langStr["Descripción"].'</h2>';
// $featuresTxt .= '' . $promotion[0]['contenido'] . '';
$featuresTxt .= '<p>' . preg_replace('/<br\s*\/?>\s*<br\s*\/?>/i', '<br />', nl2br(strip_tags($promotion[0]['contenido']))) . '</p>';
// $featuresTxt .= '<p>' . KT_FormatForList($promotion[0]['contenido'], 1500). '</p>';
*/

$html = preg_replace('/{FEATURES}/', $featuresTxt, $html);


$propertiesTxt .= '<h2 style="margin-top:15px;">'.$langStr["Property listings"].'</h2><br>';

$propertiesTxt .= '<table style="width: 100%;border: none;" cellspacing="0" cellpadding="0">';
$propertiesTxt .= '<thead>';
$propertiesTxt .= '<tr>';
$propertiesTxt .= '<th style="width: 15%;"></th>';
$propertiesTxt .= '<th style="width: 10%;">REF</th>';
$propertiesTxt .= '<th style="width: 35%;">' . $langStr["Nombre"] . '</th>';
$propertiesTxt .= '<th style="width: 10%;">' . $langStr["Habitaciones"] . '</th>';
$propertiesTxt .= '<th style="width: 10%;">' . $langStr["Baños"] . '</th>';
$propertiesTxt .= '<th style="width: 10%;">' . $langStr["Meters"] . '</th>';
$propertiesTxt .= '<th style="width: 10%;">' . $langStr["Precio"] . '</th>';
$propertiesTxt .= '</tr>';
$propertiesTxt .= '</thead>';
$propertiesTxt .= '<tbody>';
foreach ($properties as $property) {
    $propertiesTxt .= '<tr>';
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$property['id_img']."_md.jpg") && $property['id_img'] != '') {
        $propertiesTxt .= '<td style="width: 15%;"><img src="../../media/images/properties/thumbnails/'.$property['id_img'].'_md.jpg"></td>';
    } else {
        $propertiesTxt .= '<td style="width: 15%;"></td>';
    }
    $propertiesTxt .= '<td style="width: 10%;">' . $property['referencia_prop'] . '</td>';
    $propertiesTxt .= '<td style="width: 35%;">' . $property['titulo'] . '</td>';
    $propertiesTxt .= '<td style="width: 10%;">' . number_format($property['habitaciones_prop'], 0, ',', '.') . '</td>';
    $propertiesTxt .= '<td style="width: 10%;">' . number_format($property['aseos_prop'], 0, ',', '.') . '</td>';
    $propertiesTxt .= '<td style="width: 10%;">' . number_format($property['m2_prop'], 0, ',', '.') . 'm<sup>2</sup></td>';
    if ($property['precio'] == 0) {
        $propertiesTxt .= '<td style="width: 10%;">' . $langStr["Consultar"] . '</td>';
    } else {
        $propertiesTxt .= '<td style="width: 10%;">€' . number_format($property['precio'], 0, ',', '.') . '</td>';
    }
    $propertiesTxt .= '</tr>';
}
$propertiesTxt .= '</tbody></table>';

$html = preg_replace('/{PROPERTIES}/', $propertiesTxt, $html);

include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

foreach ($urlStr as $key => $urls) {
    foreach ($urls as $langval => $urlval) {
        if ($langval == $lang) {
            $urlStr[$key]['url'] = $urlval;
            $urlStr[$urlStr[$key][$langval]]['master'] = $key;
        }
    }
}

$urlStart = '/';

if(@isset($_GET['lang']) && $_GET['lang'] != '' && $_GET['lang'] != $language) {
    $urlStart =   '/' . $_GET['lang'] . '/';
}

$html = preg_replace('/{URL}/', 'https://' . $_SERVER["HTTP_HOST"] . $urlStart . '' . $urlStr["promociones"][$_GET['lang']]. '/' . $_GET['p'] . '/' . clean(html_entity_decode($promotion[0]['titulo'])) . '/', $html);

$logo = '<img src="../..'.$pdfLogo.'" height="62" alt="">';
$html = preg_replace('/{LOGO}/', $logo , $html);

$email = '<b>Email: </b><br>'.$correoEmpresa;
$html = preg_replace('/{EMAIL}/', $email , $html);

$html = preg_replace('/{WEBSITE}/', $urlwebsite , $html);

$html = preg_replace('/{COLOR}/', $maincolorPDF , $html);
$html = preg_replace('/{SECONDARYCOLOR}/', $secondarycolorPDF , $html);

try
{
    $html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', 0);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->setDefaultFont("dejavusans");
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('promotion-' . clean($property[0]['ref']) . '.pdf', 'I');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}