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

savelogprop($_GET['id'], '7');

ob_start();
include($_SERVER["DOCUMENT_ROOT"] . '/modules/property/view/pdf/pdf-A4-1_web.html');
// include($_SERVER["DOCUMENT_ROOT"] . '/modules/property/view/pdf/pdf-A4-2.html');
// include($_SERVER["DOCUMENT_ROOT"] . '/modules/property/view/pdf/pdf-A4-3.html');
$html = ob_get_contents();
ob_end_clean();

$property = getRecords("

SELECT
    properties_loc1.name_".$_GET['lang']."_loc1 AS country,
    properties_loc1.id_loc1 AS countryid,
    CASE WHEN properties_loc2.name_".$_GET['lang']."_loc2 IS NOT NULL THEN properties_loc2.name_".$_GET['lang']."_loc2 ELSE province1.name_".$_GET['lang']."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$_GET['lang']."_loc3 IS NOT NULL THEN properties_loc3.name_".$_GET['lang']."_loc3 ELSE areas1.name_".$_GET['lang']."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$_GET['lang']."_loc4 IS NOT NULL THEN properties_loc4.name_".$_GET['lang']."_loc4 ELSE towns.name_".$_GET['lang']."_loc4  END AS town,
    CASE WHEN properties_types.types_".$_GET['lang']."_typ IS NOT NULL THEN properties_types.types_".$_GET['lang']."_typ ELSE types.types_".$_GET['lang']."_typ END AS type,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS provinceid,
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS areaid,
    CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END AS townid,
    CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS typeid,
    properties_properties.lat_long_gp_prop AS lat,
    properties_properties.zoom_gp_prop AS zoom,
    properties_status.status_".$_GET['lang']."_sta as sale,
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
    properties_properties.m2_solarium_prop,
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
    id_prop,
    id_img,
    alt_".$_GET['lang']."_img as alt,
    properties_properties.titulo_".$_GET['lang']."_prop as titulo,
    properties_properties.descripcion_".$_GET['lang']."_prop as description,
    title_".$_GET['lang']."_prop as metatitle,
    description_".$_GET['lang']."_prop as metadescription,
    keywords_".$_GET['lang']."_prop as metakeywords,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$_GET['lang']."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$_GET['lang']."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    (SELECT kitchen_".$_GET['lang']."_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop ) AS cocinas_prop,
    (SELECT condition_".$_GET['lang']."_cond FROM properties_condition WHERE id_cond = estado_prop ) AS estado_prop,
    (SELECT planta_".$_GET['lang']."_plnt FROM properties_planta WHERE id_plnt = planta_prop ) AS planta_prop,
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
    orientacion_prop,
    direccion_prop,
    show_direccion_prop,
    activado_prop,
    gastos_prop,
    suma_prop

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

WHERE activado_prop = 1

AND id_prop = '".simpleSanitize(($_GET['id']))."'

GROUP BY id_prop

");

$images = getRecords("
    SELECT id_img as img,
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

$featuresComb = getRecords("
    SELECT CASE WHEN properties_features.feature_".$_GET['lang']."_feat IS NOT NULL THEN properties_features.feature_".$_GET['lang']."_feat ELSE features.feature_".$_GET['lang']."_feat  END AS feat
    FROM properties_property_feature INNER JOIN properties_features features ON properties_property_feature.feature = features.id_feat LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
    WHERE properties_property_feature.property = '".simpleSanitize(($_GET['id']))."'
    UNION
    SELECT CASE WHEN properties_features_priv.feature_".$_GET['lang']."_feat IS NOT NULL THEN properties_features_priv.feature_".$_GET['lang']."_feat ELSE features.feature_".$_GET['lang']."_feat  END AS feat
    FROM properties_property_feature_priv INNER JOIN properties_features_priv features ON properties_property_feature_priv.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
    WHERE properties_property_feature_priv.property = '".simpleSanitize(($_GET['id']))."'
    ORDER BY feat ASC
    LIMIT 16
");


$noimage = $_SERVER["DOCUMENT_ROOT"] . '/media/images/website/no-image.png';


/* @group IMAGEN GRANDE */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[0]['img']."_".$tamanyoImgPDF.".jpg")) {
    $html = preg_replace('/{IMGBIG}/', $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[0]['img'].'_'.$tamanyoImgPDF.'.jpg', $html);
} else {
    $html = preg_replace('/{IMGBIG}/', $noimage, $html);
}

/* @group IMAGEN PEQUEÑA 1 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[1]['img']."_".$tamanyoImgPDF.".jpg")) {
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

if (isset($property[0]['nuevo_prop']) && strtotime($property[0]['nuevo_prop']) >= time()) {
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
    $html = preg_replace('/{H1}/', KT_FormatForList($property[0]['titulo'], 72) , $html);
}
else
{
    $html = preg_replace('/{H1}/', $property[0]['sale'] . ' · ' . $property[0]['type'] . '  · ' . $property[0]['area'], $html);
}

/* @group H2 */
$locPDF = $property[0]['province'] . ' - ' . $property[0]['area'];
if($property[0]['province'] == $property[0]['area']) $locPDF = $property[0]['province'];

$html = preg_replace('/{H2}/', $locPDF, $html);

/* @group PRECIO */
$oldprc = '';
$oldprc2 = '';

if ($property[0]['precio_desde_prop'] == 1) {
    $oldprc .= '<span>' . $langStr["From"] . '</span> ';
}
if ($property[0]['old_precio'] > 0) {
    $oldprc2 = ' <del>' . number_format($property[0]['old_precio'], 0, ',', '.') . '</del> ';
}
$precio = ($property[0]['precio'] != 0)?$oldprc . $oldprc2. number_format($property[0]['precio'], 0, ',', '.') . "€":$langStr["Consultar"];

$html = preg_replace('/{PRECIO}/', $precio, $html);


$html = preg_replace('/{LABELPRECIO}/', $langStr["Precio"], $html);

/* @group PRIVATE */
$private = $separator ='';
$suma = $property[0]['suma_prop'];
$gastos = $property[0]['gastos_prop'];
if($suma != ''){
    $private .= '<strong>IBI:</strong> '.$suma;
    $separator = ' - ';
}
if($gastos != ''){
    $private .= $separator.'<strong>'.$langStr["Community costs"].':</strong> '.$gastos;
}
$html = preg_replace('/{PRIVATE}/', $private, $html);

/* @group FEATURES */


$keyInformationCount = 0;
$keyInformationPorc = 100 / 2;
$keyInformationTotal = 12;
$keyStart = '<tr>';
$keyEnd = '</tr>';
$keyInformation = '<table style="width: 100%;border: none;" cellspacing="0" cellpadding="0"><tbody>';

if (isset($property[0]["habitaciones_prop"]) && number_format($property[0]["habitaciones_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Habitaciones"].': '.number_format($property[0]["habitaciones_prop"], 0, ',', '.').'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Habitaciones"].': '.number_format($property[0]["habitaciones_prop"], 0, ',', '.').'</td>';
    }
}

if (isset($property[0]["aseos_prop"]) && number_format($property[0]["aseos_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Baños"].': '.number_format($property[0]["aseos_prop"], 0, ',', '.').'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Baños"].': '.number_format($property[0]["aseos_prop"], 0, ',', '.').'</td>';
    }
}

if (isset($property[0]["m2_prop"]) && number_format($property[0]["m2_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Construidos"].': '.number_format($property[0]["m2_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Construidos"].': '.number_format($property[0]["m2_prop"], 0, ',', '.').'m<sup>2</sup></td>';
    }
}

if (isset($property[0]["m2_utiles_prop"]) && number_format($property[0]["m2_utiles_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Útiles"].': '.number_format($property[0]["m2_utiles_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Útiles"].': '.number_format($property[0]["m2_utiles_prop"], 0, ',', '.').'m<sup>2</sup></td>';
    }
}

if (isset($property[0]["m2p_prop"],) && is_numeric($property[0]["m2p_prop"]) && number_format((float)$property[0]["m2p_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Parcela"].': '.number_format($property[0]["m2p_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Parcela"].': '.number_format($property[0]["m2p_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["terraza_prop"],) && is_numeric($property[0]["terraza_prop"]) && number_format((float)$property[0]["terraza_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Terraza"].': '.number_format($property[0]["terraza_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Terraza"].': '.number_format($property[0]["terraza_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["garaje_prop"]) && is_numeric($property[0]["garaje_prop"]) && number_format((float)$property[0]["garaje_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Garaje"].': '.number_format($property[0]["garaje_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Garaje"].': '.number_format($property[0]["garaje_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["sotano_prop"]) && is_numeric($property[0]["sotano_prop"]) && number_format((float)$property[0]["sotano_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Sótano"].': '.number_format($property[0]["sotano_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Sótano"].': '.number_format($property[0]["sotano_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["fachada_prop"]) && is_numeric($property[0]["fachada_prop"]) && number_format((float)$property[0]["fachada_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {

    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Fachada"].': '.number_format($property[0]["fachada_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Fachada"].': '.number_format($property[0]["fachada_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["cocinas_prop"]) && is_numeric($property[0]["cocinas_prop"]) && number_format((float)$property[0]["cocinas_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Cocinas"].': '.number_format($property[0]["cocinas_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Cocinas"].': '.number_format($property[0]["cocinas_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["m2_solarium_prop"]) && is_numeric($property[0]["m2_solarium_prop"]) && number_format((float)$property[0]["m2_solarium_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {

    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Solarium"].': '.number_format($property[0]["m2_solarium_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Solarium"].': '.number_format($property[0]["m2_solarium_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["aseos2_prop"]) && number_format($property[0]["aseos2_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Aseos"].': '.number_format($property[0]["aseos2_prop"], 0, ',', '.').'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Aseos"].': '.number_format($property[0]["aseos2_prop"], 0, ',', '.').'</td>';
    }
}

if (isset($property[0]["terrazas_prop"]) && number_format($property[0]["terrazas_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Terrazas"].': '.number_format($property[0]["terrazas_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Terrazas"].': '.number_format($property[0]["terrazas_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["salones_prop"]) && number_format($property[0]["salones_prop"], 0, ',', '.') > 0  && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Salones"].': '.number_format($property[0]["salones_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Salones"].': '.number_format($property[0]["salones_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (isset($property[0]["salas_prop"]) && number_format($property[0]["salas_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Salas"].': '.number_format($property[0]["salas_prop"], 0, ',', '.').'m<sup>2</sup></td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Salas"].': '.number_format($property[0]["salas_prop"], 0, ',', '.').'m<sup>2</sup></td>';

    }
}

if (number_format($property[0]["armarios_empotrados_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Armarios empotrados"].': '.number_format($property[0]["armarios_empotrados_prop"], 0, ',', '.').'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Armarios empotrados"].': '.number_format($property[0]["armarios_empotrados_prop"], 0, ',', '.').'</td>';
    }
}

if (number_format($property[0]["plazas_garaje_prop"], 0, ',', '.') > 0 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Plazas de garaje"].': '.number_format($property[0]["plazas_garaje_prop"], 0, ',', '.').'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Plazas de garaje"].': '.number_format($property[0]["plazas_garaje_prop"], 0, ',', '.').'</td>';
    }
}

if ($property[0]['energia_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Calificación energética"].': '.$property[0]["energia_prop"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Calificación energética"].': '.$property[0]["energia_prop"].'</td>';
    }
}
elseif($keyInformationCount < $keyInformationTotal){
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Calificación energética"].': '.$langStr["En proceso"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Calificación energética"].': '.$langStr["En proceso"].'</td>';
    }
}

if ($property[0]['construccion_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Año de construcción"].': '.$property[0]["construccion_prop"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Año de construcción"].': '.$property[0]["construccion_prop"].'</td>';
    }
}

if ($property[0]['orientacion_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    $valorOrientation = '';
    switch ($property[0]['orientacion_prop']) {
        case 'o-n':
             $valorOrientation = $langStr["o-n"];
             break;
        case 'o-ne':
             $valorOrientation = $langStr["o-ne"];
             break;
        case 'o-e':
             $valorOrientation = $langStr["o-e"];
             break;
        case 'o-se':
             $valorOrientation = $langStr["o-se"];
             break;
        case 'o-s':
             $valorOrientation = $langStr["o-s"];
             break;
        case 'o-so':
             $valorOrientation = $langStr["o-so"];
             break;
        case 'o-o':
             $valorOrientation = $langStr["o-o"];
             break;
         default:
             $valorOrientation = $langStr["o-no"];
             break;
     }
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Orientación"].': '.$valorOrientation.'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Orientación"].': '.$valorOrientation.'</td>';
    }
}

if ($property[0]['piscina_prop'] == 1 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Piscina"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Piscina"].'</td>';
    }
}

if ($property[0]['ascensor_prop'] == 1 && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Ascensor"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Ascensor"].'</td>';

    }
}

if ($property[0]['parking_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Garaje"].': '.$property[0]["parking_prop"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Garaje"].': '.$property[0]["parking_prop"].'</td>';

    }
}

if ($property[0]['suma_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">Suma/IBI: '.$property[0]["suma_prop"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">Suma/IBI: '.$property[0]["suma_prop"].'</td>';

    }
}

if ($property[0]['gastos_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Gastos"].': '.$property[0]["gastos_prop"].'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Gastos"].': '.$property[0]["gastos_prop"].'</td>';

    }
}

if ($property[0]['distance_beach_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    $valueDistance = '';
    switch ($property[0]['distance_beach_med_prop']) {
        case 'Km':
            $valueDistance = $langStr["km "];
            break;
        case 'Mts':
            $valueDistance = $langStr["mts "];
            break;

        default:
            $valueDistance = $langStr["Mins "];
            break;
    }
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia a la playa"].': '.$property[0]["distance_beach_prop"].$valueDistance.'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia a la playa"].': '.$property[0]["distance_beach_prop"].$valueDistance.'</td>';

    }
}

if ($property[0]['distance_airport_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    $valueDistance = '';
    switch ($property[0]['distance_airport_med_prop']) {
        case 'Km':
            $valueDistance = $langStr["km "];
            break;
        case 'Mts':
            $valueDistance = $langStr["mts "];
            break;

        default:
            $valueDistance = $langStr["Mins "];
            break;
    }
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia al aereopuerto"].': '.$property[0]["distance_airport_prop"].$valueDistance.'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia al aereopuerto"].': '.$property[0]["distance_airport_prop"].$valueDistance.'</td>';

    }
}

if ($property[0]['distance_amenities_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    $valueDistance = '';
    switch ($property[0]["distance_amenities_med_prop"]) {
        case 'Km':
            $valueDistance = $langStr["km "];
            break;
        case 'Mts':
            $valueDistance = $langStr["mts "];
            break;

        default:
            $valueDistance = $langStr["Mins "];
            break;
    }
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia a entretenimientos"].': '.$property[0]["distance_amenities_prop"].$valueDistance.'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia a entretenimientos"].': '.$property[0]["distance_amenities_prop"].$valueDistance.'</td>';

    }
}

if ($property[0]['distance_golf_prop'] != '' && $keyInformationCount < $keyInformationTotal) {
    $valueDistance = '';
    switch ($property[0]["distance_golf_med_prop"]) {
        case 'Km':
            $valueDistance = $langStr["km "];
            break;
        case 'Mts':
            $valueDistance = $langStr["mts "];
            break;

        default:
            $valueDistance = $langStr["Mins "];
            break;
    }
    ++$keyInformationCount;
    if($keyInformationCount % 2 == 0){
        $keyInformation .= '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia al campo de golf"].': '.$property[0]["distance_golf_prop"].$valueDistance.'</td>'.$keyEnd;
    }
    else{
        $keyInformation .= $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">'.$langStr["Distancia al campo de golf"].': '.$property[0]["distance_golf_prop"].$valueDistance.'</td>';

    }
}

if($keyInformationCount % 2 == 0){
    $keyInformation .= '</tbody></table>';
}
else{
    $keyInformation .= '</tr></tbody></table>';
}
// die($keyInformation);


$featurestxt = '';
if ($property[0]['description'] != '') {
    $featurestxt .= '<p>' . KT_FormatForList($property[0]['description'], 960). '</p>';
}

$featurestxt .= '<h2>'.$langStr["Información clave"].'</h2>';
$featurestxt .= $keyInformation;
$featuresCombTxt = '';
if($featuresComb[0]['feat'] != ''){
    $featuresCombTxt .= '<h2 style="margin-top:15px;">'.$langStr["Características"].'</h2>';
    $featuresCombTxt .= '<table style="width: 100%;border: none;" cellspacing="0" cellpadding="0"><tbody>';
    foreach ($featuresComb as $key => $featureComb) {
        if ($featureComb['feat'] != '') {
            if(($key+1) % 2 == 0){
                $featuresCombTxt .=  '<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">' . $featureComb['feat'] . '</td>'.$keyEnd;
            }
            else{
                $featuresCombTxt .=  $keyStart.'<td style="width:'.$keyInformationPorc.'%;"><img src="../../media/images/website/icon-pdf.png">' . $featureComb['feat'] . '</td>';
            }
        }
    }
    if(count($featuresComb) % 2 == 0){
        $featuresCombTxt .= '</tbody></table>';
    }
    else{
     $featuresCombTxt .= '</tr></tbody></table>';
    }
}

// die($featuresCombTxt);

$featurestxt .= $featuresCombTxt;

// foreach ($features as $feature) {
//     if ($feature['feat'] != '') {
//         $featurestxt .=  '' . $feature['feat'] . ' - ';
//     }
// }
// foreach ($featuresXML as $feature) {
//     if ($feature['feat'] != '') {
//         $featurestxt .= '' . $feature['feat'] . ' - ';
//     }
// }

if ($featurestxt != '') {
    $featurestxt = $featurestxt;
}

$html = preg_replace('/{FEATURES}/', $featurestxt, $html);

/* @group QR */
$html = preg_replace('/{URL}/', 'https://' . $_SERVER["HTTP_HOST"] . propUrl($_GET['id'], $_GET['lang']), $html);

/* @group IMAGEN PEQUEÑA 4 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[4]['img']."_lg.jpg")) {
    $html = preg_replace('/{IMGGALL1}/', '<img src="' . $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[4]['img'].'_lg.jpg" style="width: 100%; height: 100%;">', $html);
} else {
    $html = preg_replace('/{IMGGALL1}/', '', $html);
}

/* @group IMAGEN PEQUEÑA 5 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[5]['img']."_lg.jpg")) {
    $html = preg_replace('/{IMGGALL2}/', '<img src="' . $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[5]['img'].'_lg.jpg" style="width: 100%; height: 100%;">', $html);
} else {
    $html = preg_replace('/{IMGGALL2}/', '', $html);
}

/* @group IMAGEN PEQUEÑA 6 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$images[6]['img']."_lg.jpg")) {
    $html = preg_replace('/{IMGGALL3}/', '<img src="' . $_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$images[6]['img'].'_lg.jpg" style="width: 100%; height: 100%;">', $html);
} else {
    $html = preg_replace('/{IMGGALL3}/', '', $html);
}


$logo = '<img src="../..'.$pdfLogo.'" height="86" alt="">';
$html = preg_replace('/{LOGO}/', $logo , $html);

$email = '<b>Email: </b><br>'.$correoEmpresa;
$html = preg_replace('/{EMAIL}/', $email , $html);

$phone = '<b>'.$langStr["Teléfono"].': </b>'.$telefonoEmpresa.'<br>';
if ($phoneRespBar != '')
{
    $phone .= '<b>Whatsapp: </b>+'.$phoneRespBar;
}
$html = preg_replace('/{PHONE}/', $phone , $html);

$html = preg_replace('/{WEBSITE}/', $urlwebsite , $html);

$html = preg_replace('/{COLOR}/', $maincolorPDF , $html);
$html = preg_replace('/{SECONDARYCOLOR}/', $secondarycolorPDF , $html);

/* @group PDF */
try
{
    $html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', 0);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->setDefaultFont("dejavusans");
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('property-' . clean($property[0]['ref']) . '.pdf', 'I');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}





