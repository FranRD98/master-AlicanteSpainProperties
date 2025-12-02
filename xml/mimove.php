<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
include( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );


$query_rsXML = "SELECT * FROM xml_export WHERE uid_exp = '".simpleSanitize(($_GET['f']))."'";
$rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error());
$row_rsXML = mysqli_fetch_assoc($rsXML);
$totalRows_rsXML = mysqli_num_rows($rsXML);

// if ($row_rsXML['id_exp'] == '') {
//     die();
// }

$tipo = '';
if ($row_rsXML['type_exp'] != '') {
    $tipo = ' AND tipo_prop IN ('.$row_rsXML['type_exp'].')';
}

$tipox = '';
if ($row_rsXML['type_ex_exp'] != '') {
    $tipox = ' AND tipo_prop NOT IN ('.$row_rsXML['type_ex_exp'].')';
}

$prov = '';
if ($row_rsXML['province_exp'] != '') {
    $prov = ' AND (properties_loc2.parent_loc2 IN ('.$row_rsXML['province_exp'].') OR province1.id_loc2 IN ('.$row_rsXML['province_exp'].'))';
}

$provx = '';
if ($row_rsXML['province_ex_exp'] != '') {
    $provx = ' AND (properties_loc2.parent_loc2 NOT IN ('.$row_rsXML['province_ex_exp'].') OR province1.id_loc2 NOT IN ('.$row_rsXML['province_ex_exp'].'))';
}

$town = '';
if ($row_rsXML['town_exp'] != '') {
    $town = ' AND (properties_loc3.parent_loc3 IN ('.$row_rsXML['town_exp'].') OR areas1.id_loc3 IN ('.$row_rsXML['town_exp'].'))';
}

$townx = '';
if ($row_rsXML['town_ex_exp'] != '') {
    $townx = ' AND (properties_loc3.parent_loc3 NOT IN ('.$row_rsXML['town_ex_exp'].') OR areas1.id_loc3 NOT IN ('.$row_rsXML['town_ex_exp'].'))';
}

$oper = '';
if ($row_rsXML['operation_exp'] != '') {
    $oper = ' AND operacion_prop IN ('.$row_rsXML['operation_exp'].')';
}

$operx = '';
if ($row_rsXML['operation_ex_exp'] != '') {
    $operx = ' AND operacion_prop NOT IN ('.$row_rsXML['operation_ex_exp'].')';
}

$beds = '';
if (isset($row_rsXML['beds_exp']) && $row_rsXML['beds_exp'] != '') {
    $val = explode(';', $row_rsXML['beds_exp']);
    $beds = ' AND habitaciones_prop >= '.$val[0].' AND habitaciones_prop <= '.$val[1].' ';
}

$baths = '';
if (isset($row_rsXML['baths_exp']) && $row_rsXML['baths_exp'] != '') {
    $val = explode(';', $row_rsXML['baths_exp']);
    $baths = ' AND aseos_prop >= '.$val[0].' AND aseos_prop <= '.$val[1].' ';
}

$price = '';
if (isset($row_rsXML['price_exp']) && $row_rsXML['price_exp'] != '') {
    $val = explode(';', $row_rsXML['price_exp']);
    $max = ($val[1] == '1000000')?'1000000000000':$val[1];
    $price = ' AND preci_reducidoo_prop >= '.$val[0].' AND preci_reducidoo_prop <= '.$max.' ';
}

$xml = '';
if ($row_rsXML['xml_exp'] == 0) {
    $xml = ' AND (xml_xml_prop IS NULL OR xml_xml_prop = \'\') ';
}

$kyero = '';
// if ($row_rsXML['kyero_xml'] == 1) {
$kyero = ' AND export_kyero_prop = 1 ';
// }

$limit = '';
if ($row_rsXML['limit_exp'] > 0) {
    $limit = ' LIMIT 0, '.$row_rsXML['limit_exp'].' ';
}


$query_rsProperties = "

SELECT properties_properties.id_prop,
    properties_properties.export_mimove_parking_prop,
    properties_properties.export_mimove_type_prop,
    properties_properties.direccion_gp_prop,
    properties_properties.cp_prop,
    properties_properties.inserted_xml_prop,
    properties_properties.updated_prop,
    properties_properties.operacion_prop,
    properties_properties.referencia_prop,
    properties_properties.preci_reducidoo_prop,
    properties_status.slug_sta,
    CASE WHEN properties_types.types_en_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS idtyp,
    CASE WHEN properties_types.types_en_typ IS NOT NULL THEN properties_types.types_en_typ ELSE types.types_en_typ END AS partyp,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province,
    CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS partown,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS pararea,
    CASE WHEN properties_types.types_en_typ IS NOT NULL THEN properties_types.types_en_typ ELSE types.types_en_typ END AS partyp_en,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province_en,
    CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS partown_en,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS pararea_en,
    title_en_prop as metatitle_en,
    properties_status.status_en_sta as status_en,
    properties_loc1.name_en_loc1 AS country,
    title_en_prop as metatitle,
    properties_status.status_en_sta,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.construccion_prop,
    properties_properties.piscina_prop,
    properties_properties.suma_prop,
    properties_properties.gastos_prop,
    properties_properties.plazas_garaje_prop,
    properties_properties.comision_prop,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.m2_balcon_prop,
    properties_properties.titulo_en_prop,
    CASE WHEN properties_properties.descripcion_xml_en_prop != '' THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != '' THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != '' THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != '' THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != '' THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_da_prop != '' THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != '' THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    lat_long_gp_prop
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
WHERE properties_properties.activado_prop = 1 AND vendido_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

AND properties_properties.export_mimove_prop = 1
AND properties_properties.export_mimove_type_prop IS NOT NULL



GROUP BY id_prop


";

// Poner en el WHERE cuando terminemos

// VERSIONES SUPERIORES DEL MASTER USARÃN ESTE WHERE
// WHERE properties_properties.activado_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

$rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error() .'<hr>'.$query_rsProperties);
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

// echo $totalRows_rsProperties."<hr>";
// echo $query_rsProperties."<hr>";
// aa();

header('Content-type: text/xml; charset=UTF-8', true);
echo '<?xml version="1.0" encoding="UTF-8"?'.'>';

?>
<listings>
    <?php do { ?>

        <listing>

            <realtor_id><?php echo $row_rsProperties['id_prop']; ?></realtor_id>
            <ref_id><?php echo preg_replace('/&/', '&amp;',$row_rsProperties['referencia_prop']); ?></ref_id>

            <insertion_date><?php echo date("Y-m-d",strtotime($row_rsProperties['inserted_xml_prop'])); ?></insertion_date>
            <update_date><?php echo date("Y-m-d",strtotime($row_rsProperties['updated_prop'])); ?></update_date>

            <hidden_address>1</hidden_address>
            <city><?php echo $row_rsProperties['partown']; ?></city>

            <?php // <street_number>36</street_number> ?>
            <?php if( isset($row_rsProperties['direccion_gp_prop']) && $row_rsProperties['direccion_gp_prop'] != ""){ ?>
                <street><![CDATA[<?php echo $row_rsProperties['direccion_gp_prop']; ?>]]></street>
            <?php } ?>
            <?php if( isset($row_rsProperties['cp_prop']) && $row_rsProperties['cp_prop'] != "" && $row_rsProperties['cp_prop'] != 0){ ?>
                <zipcode><?php echo $row_rsProperties['cp_prop']; ?></zipcode>
            <?php } ?>

            <?php $latlong = preg_split('/\,/', $row_rsProperties['lat_long_gp_prop']); ?>
            <?php if ($row_rsProperties['lat_long_gp_prop'] != '') { ?>
                <lat><?php echo trim($latlong[0]) ?></lat>
                <lng><?php echo trim(str_replace("-", "",$latlong[1])) ?></lng>
            <?php } ?>

            <type><?php echo $row_rsProperties['export_mimove_type_prop']? : "apartment"; ?></type>
            <condition>good</condition>

            <price><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></price>
            <bedrooms><?php echo $row_rsProperties['habitaciones_prop']; ?></bedrooms>
            <bathrooms><?php echo $row_rsProperties['aseos_prop']; ?></bathrooms>

            <?php if( isset($row_rsProperties['construccion_prop']) && $row_rsProperties['construccion_prop'] != ""){ ?>
                <built><?php echo $row_rsProperties['construccion_prop']; ?></built>
            <?php } ?>

            <?php if ($row_rsProperties['m2_prop'] > 0) { ?>
                <built_area><?php echo number_format($row_rsProperties['m2_prop'], 0,'',''); ?></built_area>
            <?php } ?>
            <?php if ($row_rsProperties['m2_parcela_prop'] > 0) { ?>
                <gross_floor_area><?php echo number_format($row_rsProperties['m2_parcela_prop'], 0,'',''); ?></gross_floor_area>
            <?php } ?>

            <?php if ($row_rsProperties['m2_balcon_prop'] > 0) { ?>
                <terrace_size><built_area><?php echo number_format($row_rsProperties['m2_balcon_prop'], 0,'',''); ?></built_area></terrace_size>
                <Terrace>1</Terrace>
            <?php } ?>

            <?php if ( isset($row_rsProperties['export_mimove_parking_prop']) && $row_rsProperties['export_mimove_parking_prop'] != "") {?>
                <parkings>
                    <parking>
                        <type><?php echo $row_rsProperties['export_mimove_parking_prop'] ? : "garage"; ?></type>
                        <?php if ($row_rsProperties['plazas_garaje_prop'] > 0) { ?>
                            <places><?php echo $row_rsProperties['plazas_garaje_prop']; ?></places>
                        <?php } ?>
                    </parking>
                </parkings>
            <?php }?>

            <?php if ($row_rsProperties['piscina_prop'] > 0) {?>
                <Pool>1</Pool>
            <?php }?>
            <?php /*
                <Pool_child_friendly>1</Pool_child_friendly>
                <Pool_heated>1</Pool_heated>
                <Pool_sea_water_pool>1</Pool_sea_water_pool>
                <Pool_space_for_pool>1</Pool_space_for_pool>
                <Pool_splash_pool>1</Pool_splash_pool>
                <Shared_pool>1</Shared_pool>
                <Shared_pool_heated>1</Shared_pool_heated>
                <Shared_pool_supervised>1</Shared_pool_supervised>
                <Shared_splash_pool>1</Shared_splash_pool>
            */ ?>

            <?php if ( isset($row_rsProperties['suma_prop']) && $row_rsProperties['suma_prop'] != "") { ?>
                <property_tax><?php echo $row_rsProperties['suma_prop']; ?></property_tax>
            <?php } ?>
            <?php if ( isset($row_rsProperties['gastos_prop']) && $row_rsProperties['gastos_prop'] != "") { ?>
                <community_fee><?php echo $row_rsProperties['gastos_prop']; ?></community_fee>
            <?php } ?>
            <?php // <garbage_tax>57</garbage_tax> ?>

            <?php if ( isset($row_rsProperties['comision_prop']) && (int)$row_rsProperties['comision_prop'] > 0) { ?>
                <commision_percent><?php echo number_format($row_rsProperties['comision_prop'], 1,'.',','); ?></commision_percent>
            <?php } ?>

            <?php $tags = getPropTags($row_rsProperties['id_prop'], "en"); ?>
            <?php foreach ($tags as $keyTag => $valueTag) { ?>
                <?php if ( $valueTag['id_tag'] == 1 ){ ?>
                    <Sea_view>1</Sea_view>
                <?php } else if ( $valueTag['id_tag'] == 2 ){ ?>
                    <Beach>1</Beach>
                    <Beach_side>1</Beach_side>
                <?php } else if ( $valueTag['id_tag'] == 3 ){ ?>
                    <Bay>1</Bay>
                <?php } ?>
            <?php } ?>

            <?php if($row_rsProperties['titulo_en_prop'] != '') { ?>
                <sales_text><![CDATA[<?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['titulo_en_prop'])); ?>]]></sales_text>
            <?php } ?>

            <?php // <district_description>Some text</district_description> ?>

            <descriptions>
                <?php if($row_rsProperties['descripcion_en_prop'] != '') { ?><description xml:lang="en"><![CDATA[<?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_en_prop'])); ?>]]></description><?php } ?>
                <?php if($row_rsProperties['descripcion_es_prop'] != '') { ?><description xml:lang="es"><![CDATA[<?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])); ?>]]></description><?php } ?>
            </descriptions>
            <descriptions_short>
                <?php if($row_rsProperties['descripcion_en_prop'] != '') { ?><description_short xml:lang="en"><![CDATA[<?php echo substr(strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_en_prop'])), 0, 160); ?>]]></description_short><?php } ?>
                <?php if($row_rsProperties['descripcion_es_prop'] != '') { ?><description_short xml:lang="es"><![CDATA[<?php echo substr(strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])), 0, 160); ?>]]></description_short><?php } ?>
            </descriptions_short>

            <custom_url>https://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo propURL($row_rsProperties['id_prop'], 'en') ?></custom_url>

            <images>
                <?php
                
                $query_rsImages = "SELECT id_img FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 50";
                $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                $row_rsImages = mysqli_fetch_assoc($rsImages);
                $totalRows_rsImages = mysqli_num_rows($rsImages);
                do {
                    ?>
                    <?php if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$row_rsImages['id_img']."_lg.jpg")) { ?>
                        <url><![CDATA[https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/thumbnails/<?php echo $row_rsImages['id_img']; ?>_lg.jpg]]></url>
                    <?php } ?>
                <?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
            </images>

        </listing>

    <?php } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>
</listings>



<?php
mysqli_free_result($rsProperties);
?>
