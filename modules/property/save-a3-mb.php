<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$_GET['lang'].'.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php');
use Spipu\Html2Pdf\Html2Pdf; 

$_GET['lang'] = sanitizeInput($_GET['lang']);
$_GET['id'] = sanitizeInput($_GET['id']);


savelogprop($_GET['id'], '7');

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/modules/property/view/pdf/pdf-A3-1-MB.html');
// include($_SERVER["DOCUMENT_ROOT"] . '/modules/property/view/pdf/pdf-A3-2.html');
// include($_SERVER["DOCUMENT_ROOT"] . '/modules/property/view/pdf/pdf-A3-3.html');
$html = ob_get_contents();
ob_end_clean();

$property = getRecords("

SELECT
    properties_loc1.name_".$_GET['lang']."_loc1 AS country,

CASE WHEN properties_loc2.name_".$_GET['lang']."_loc2 IS NOT NULL THEN properties_loc2.name_".$_GET['lang']."_loc2 ELSE province1.name_".$_GET['lang']."_loc2  END AS province,
CASE WHEN properties_loc3.name_".$_GET['lang']."_loc3 IS NOT NULL THEN properties_loc3.name_".$_GET['lang']."_loc3 ELSE areas1.name_".$_GET['lang']."_loc3  END AS area,
CASE WHEN properties_loc4.name_".$_GET['lang']."_loc4 IS NOT NULL THEN properties_loc4.name_".$_GET['lang']."_loc4 ELSE towns.name_".$_GET['lang']."_loc4  END AS town,
properties_properties.lat_long_gp_prop AS lat,
CASE WHEN properties_types.types_".$_GET['lang']."_typ IS NOT NULL THEN properties_types.types_".$_GET['lang']."_typ ELSE types.types_".$_GET['lang']."_typ END AS type,
properties_status.status_".$_GET['lang']."_sta as sale,
properties_properties.m2_prop,
properties_properties.m2_parcela_prop as m2p_prop,
properties_properties.precio_prop as old_precio,
properties_properties.preci_reducidoo_prop as precio,
properties_properties.habitaciones_prop,
properties_properties.aseos_prop,
properties_properties.energia_prop,
id_prop,
image_img,
properties_properties.titulo_".$_GET['lang']."_prop as titulo,
properties_properties.descripcion_".$_GET['lang']."_prop as description,
title_".$_GET['lang']."_prop as metatitle,
description_".$_GET['lang']."_prop as metadescription,
properties_properties.referencia_prop as ref,
properties_properties.vendido_tag_prop,
properties_properties.nuevo_prop,
(SELECT pool_".$_GET['lang']."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
(SELECT parking_".$_GET['lang']."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
properties_properties.orientacion_prop,
properties_properties.reservado_prop,
properties_properties.precio_desde_prop,
properties_properties.alquilado_prop


FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
    INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE activado_prop = 1

AND id_prop = '".simpleSanitize(($_GET['id']))."'

GROUP BY id_prop

");

$images = getRecords("
    SELECT id_img as img,
image_img,
    order_pdf_img
    FROM properties_images
    WHERE property_img = '".simpleSanitize(($_GET['id']))."'  ORDER BY order_pdf_img
");

if ($images[0]['order_pdf_img'] != 1) {
    $images = getRecords("
        SELECT id_img as img
        FROM properties_images
        WHERE property_img = '".simpleSanitize(($_GET['id']))."'  ORDER BY order_img
    ");
}

$features = getRecords("
    SELECT CASE WHEN properties_features.feature_".$_GET['lang']."_feat IS NOT NULL THEN properties_features.feature_".$_GET['lang']."_feat ELSE features.feature_".$_GET['lang']."_feat  END AS feat
    FROM properties_property_feature INNER JOIN properties_features features ON properties_property_feature.feature = features.id_feat LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
    WHERE properties_property_feature.property = '".simpleSanitize(($_GET['id']))."' ORDER BY feat ASC
");

$featuresXML = getRecords("
    SELECT CASE WHEN properties_features_priv.feature_".$_GET['lang']."_feat IS NOT NULL THEN properties_features_priv.feature_".$_GET['lang']."_feat ELSE features.feature_".$_GET['lang']."_feat  END AS feat
    FROM properties_property_feature_priv INNER JOIN properties_features_priv features ON properties_property_feature_priv.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
    WHERE properties_property_feature_priv.property = '".simpleSanitize(($_GET['id']))."' ORDER BY feat ASC
");

$noimage = $_SERVER["DOCUMENT_ROOT"] . '/media/images/website/no-image.png';

/* @group IMAGEN GRANDE */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[0]['img']."_".$tamanyoImgPDF.".jpg")) {
    $html = preg_replace('/{IMGBIG}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[0]['img'].'_'.$tamanyoImgPDF.'.jpg', $html);
} else {
    $html = preg_replace('/{IMGBIG}/', $noimage, $html);
}

/* @group IMAGEN PEQUEÑA 1 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[1]['img']."_xl.jpg")) {
    $html = preg_replace('/{IMGSMALL1}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[1]['img'].'_xl.jpg', $html);
} else {
    $html = preg_replace('/{IMGSMALL1}/', $noimage, $html);
}

/* @group IMAGEN PEQUEÑA 2 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[2]['img']."_".$tamanyoImgPDF.".jpg")) {
    $html = preg_replace('/{IMGSMALL2}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[2]['img'].'_'.$tamanyoImgPDF.'.jpg', $html);
} else {
    $html = preg_replace('/{IMGSMALL2}/', $noimage, $html);
}


/* @group IMAGEN PEQUEÑA 3 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[3]['img']."_".$tamanyoImgPDF.".jpg")) {
    $html = preg_replace('/{IMGSMALL3}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[3]['img'].'_'.$tamanyoImgPDF.'.jpg', $html);
} else {
    $html = preg_replace('/{IMGSMALL3}/', $noimage, $html);
}


/* @group ETIQUETAS */
$tags = '';

if (strtotime($property[0]['nuevo_prop']) >= time()) {
    $tags .= '<div class="label label-success">'.$langStr["Nuevo"].'</div>';
}

if ($property[0]['vendido_tag_prop'] == 1 ) {
    $tags .= '<div class="label label-danger">'.$langStr["Vendido"].'</div>';
}

if ($property[0]['alquilado_prop'] == 1 ) {
    $tags .= '<div class="label label-danger">'.$langStr["Alquilado"].'</div>';
}

if ($property[0]['reservado_prop'] == 1 ) {
    $tags .= '<div class="label label-danger">'.$langStr["Reservado"].'</div>';
}

$tagsDB = getPropTags($property[0]['id_prop'], $_GET['lang']);
foreach ($tagsDB as $tag) {
    if ($tag['tag']  != '') {
        $tags .= '<div class="label2 label-custom" style="color: ' . $tag['text_color_tag'] . '; background-color: ' . $tag['color_tag'] . ';">' . $tag['tag'] . '</div>';
    }
}

$html = preg_replace('/{LABELS}/', $tags , $html);


/* @group ICONOS */
$totTDs = 1;
if ($property[0]['habitaciones_prop'] != '') { $totTDs = $totTDs + 1; }
if ($property[0]['aseos_prop'] != '') { $totTDs = $totTDs + 1; }
if ($property[0]['m2_prop'] != '') { $totTDs = $totTDs + 1; }
if ($property[0]['m2p_prop'] != '') { $totTDs = $totTDs + 1; }
if ($property[0]['piscina_prop'] != '') { $totTDs = $totTDs + 1; }
if ($property[0]['parking_prop'] != '') { $totTDs = $totTDs + 1; }

$porcent = (100/$totTDs);

$txt = '';
if ($property[0]['habitaciones_prop'] != '') {
    $txt = '<td style="text-align: center; width: '.$porcent.'%;">
                <img src="../../media/images/website/icon-beds.png" height="28" alt="">
                <br>
                <b><span>'.$property[0]["habitaciones_prop"].' '.$langStr["Habitaciones"].'</span></b>
            </td>';
}
$html = preg_replace('/{ICONHAB}/', $txt , $html);
$txt = '';
if ($property[0]['aseos_prop'] != '') {
    $txt = '<td style="text-align: center; width: '.$porcent.'%;">
                <img src="../../media/images/website/icon-baths.png" height="28" alt="">
                <br>
                <b><span>'.$property[0]["aseos_prop"].' '.$langStr["Baños"].'</span></b>
            </td>';
}
$html = preg_replace('/{ICONBAN}/', $txt , $html);
$txt = '';
if ($property[0]['m2_prop'] != '') {
    $txt = '<td style="text-align: center; width: '.$porcent.'%;">
                <img src="../../media/images/website/icon-m2.png" height="28" alt="">
                <br>
                <b><span>'.number_format($property[0]["m2_prop"], 0, ',', '.').'m<sup>2</sup></span></b>
            </td>';
}
$html = preg_replace('/{ICONM2}/', $txt , $html);
$txt = '';
if ($property[0]['m2p_prop'] != '') {
    $txt = '<td style="text-align: center; width: '.$porcent.'%;">
                <img src="../../media/images/website/icon-m2p.png" height="28" alt="">
                <br>
                <b><span>'.number_format($property[0]["m2p_prop"], 0, ',', '.').'m<sup>2</sup></span></b>
            </td>';
}
$html = preg_replace('/{ICONM2P}/', $txt , $html);
$txt = '';
if ($property[0]['piscina_prop'] != '') {
    $txt = '<td style="text-align: center; width: '.$porcent.'%;">
                <img src="../../media/images/website/icon-pool.png" height="28" alt="">
                <br>
                <b><span>'.$property[0]['piscina_prop'].'</span></b>
            </td>';
}
$html = preg_replace('/{POOL}/', $txt , $html);
$txt = '';
if ($property[0]['parking_prop'] != '') {
    $txt = '<td style="text-align: center; width: '.$porcent.'%;">
                <img src="../../media/images/website/icon-parking.png" height="28" alt="">
                <br>
                <b><span>'.$property[0]['parking_prop'].'</span></b>
            </td>';
}
$html = preg_replace('/{PARKING}/', $txt , $html);
$txt = '';
if ($property[0]['energia_prop'] != '' && $property[0]['energia_prop'] != '0') {
    $energy = $property[0]['energia_prop'];
} else {
    $energy = $langStr["En proceso"];
}

$txt = '<td style="text-align: center; width: '.$porcent.'%;">
            <img src="../../media/images/website/energia.png" height="28" alt="">
            <br>
            <b><span>'.$energy.'</span></b>
        </td>';
$html = preg_replace('/{ENERGY}/', $txt , $html);

/* @group REFERENCIA */
$html = preg_replace('/{REF}/', $langStr["Ref "] . ' ' . $property[0]['ref'], $html);

/* @group H1 */

if ($property[0]['titulo'] != '')  
{
    $html = preg_replace('/{H1}/', KT_FormatForList($property[0]['titulo'], 70) , $html);
}
else
{
    $html = preg_replace('/{H1}/', $property[0]['sale'] . ' · ' . $property[0]['type'] . '  · ' . $property[0]['area'], $html);
}


/* @group H1 */
$html = preg_replace('/{H2}/', $property[0]['province'] . ' - ' . $property[0]['area'], $html);

/* @group DESCRIPCION */
$html = preg_replace('/{DESCRIPTION}/', KT_FormatForList($property[0]['description'], 495), $html);

/* @group PRECIO */
$oldprc = '';
$oldprc2 = '';
if ($property[0]['precio_desde_prop'] == 1) {
    $oldprc .= '<span>' . $langStr["From"] . '</span> ';
}
if ($property[0]['old_precio'] > 0) {
    $oldprc2 = ' <del>' . number_format($property[0]['old_precio'], 0, ',', '.') . '</del>';
}
$precio = ($property[0]['precio'] != 0)?$oldprc . number_format($property[0]['precio'], 0, ',', '.') . "€" . $oldprc2:$langStr["Consultar"] ;
$html = preg_replace('/{PRECIO}/', $precio, $html);

/* @group FEATURES */
$featurestxt = '';
foreach ($features as $feature) {
    if ($feature['feat'] != '') {
        $featurestxt .= $feature['feat'] . ' - ';
    }
}
foreach ($featuresXML as $feature) {
    if ($feature['feat'] != '') {
        $featurestxt .= $feature['feat'] . ' - ';
    }
}
if ($featurestxt != '') {
    $featurestxt = '- ' . $featurestxt;
}
$html = preg_replace('/{FEATURES}/', $featurestxt, $html);

/* @group QR */
$html = preg_replace('/{URL}/', 'https://' . $_SERVER["HTTP_HOST"] . propUrl($_GET['id'], $_GET['lang']), $html);



$logo = '<img src="../..'.$pdfLogo.'" height="50" alt="">';
$html = preg_replace('/{LOGO}/', $logo , $html);

$email = '<b>Email: </b>'.$correoEmpresa;
$html = preg_replace('/{EMAIL}/', $email , $html);

$phone = '<b>Phone: </b>'.$telefonoEmpresa.'<br>';
$phone .= '<b>Whatsapp: </b>+'.$phoneRespBar;
$html = preg_replace('/{PHONE}/', $phone , $html);

$html = preg_replace('/{WEBSITE}/', $urlwebsite , $html);

$html = preg_replace('/{COLOR}/', $maincolorPDF , $html);
$html = preg_replace('/{SECONDARYCOLOR}/', $secondarycolorPDF , $html);


/* @group PDF */
try
{
    $html2pdf = new HTML2PDF('L','A3','es', true, 'UTF-8', 0);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->setDefaultFont("dejavusans");
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('property-' . clean($property[0]['ref']) . '.pdf', 'I');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}

