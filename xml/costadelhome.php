<?php
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
if ($row_rsXML['kyero_xml'] == 1) {
	$kyero = ' AND export_kyero_prop = 1 ';
}

$limit = '';
if ($row_rsXML['limit_exp'] > 0) {
	$limit = ' LIMIT 0, '.$row_rsXML['limit_exp'].' ';
}


$query_rsProperties = "

SELECT properties_properties.id_prop,
	properties_properties.updated_prop,
	properties_properties.operacion_prop,
	properties_properties.referencia_prop,
	properties_properties.preci_reducidoo_prop,
	properties_status.slug_sta,
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
	properties_properties.piscina_prop,
	properties_properties.m2_prop,
	properties_properties.m2_parcela_prop,
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
WHERE properties_properties.activado_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

AND expport_CostadelHome_prop = 1

";
$rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error() .'<hr>'.$query_rsProperties);
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

// echo $totalRows_rsProperties."<hr>";
// echo $query_rsProperties."<hr>";
// aa();

header('Content-type: text/xml; charset=UTF-8', true);
echo '<?xml version="1.0" encoding="UTF-8"?'.'>';

?>
<root>

<kyero>
    <feed_version>3</feed_version>
</kyero>

<?php do { ?>

<property>

    <id><?php echo $row_rsProperties['id_prop']; ?></id>

    <date><?php echo $row_rsProperties['updated_prop']; ?></date>

    <ref><?php echo $row_rsProperties['referencia_prop']; ?></ref>

    <price><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></price>

    <currency>EUR</currency>

    <?php if ($row_rsProperties['slug_sta'] == 'new_build') { ?>
    <price_freq>sale</price_freq>
    <new_build>1</new_build>
    <?php } else { ?>
    <price_freq><?php echo $row_rsProperties['slug_sta'] ?></price_freq>
    <?php } ?>

    <type><![CDATA[<?php echo ($row_rsProperties['partyp'] == null)?$row_rsProperties['types_en_typ']:$row_rsProperties['partyp']; ?>]]></type>

    <town><?php echo $row_rsProperties['partown']; ?></town>

    <province><?php echo $row_rsProperties['province']; ?></province>

    <location_detail><?php echo preg_replace('/&/', '&amp;', $row_rsProperties['pararea']); ?></location_detail>

    <beds><?php echo $row_rsProperties['habitaciones_prop']; ?></beds>

    <baths><?php echo $row_rsProperties['aseos_prop']; ?></baths>

    <pool><?php if ($row_rsProperties['piscina_prop'] > 0): ?>1<?php endif ?></pool>
    <?php $latlong = preg_split('/\,/', $row_rsProperties['lat_long_gp_prop']); ?>
    <?php if ($row_rsProperties['lat_long_gp_prop'] != '') { ?>
    <location>
            <latitude><?php echo trim($latlong[0]) ?></latitude>
            <longitude><?php echo trim($latlong[1]) ?></longitude>
    </location>
    <?php } ?>

    <surface_area>
        <?php if ($row_rsProperties['m2_prop'] > 0) { ?>
        <built><?php echo number_format($row_rsProperties['m2_prop'], 0,'',''); ?></built>
        <?php } ?>
        <?php if ($row_rsProperties['m2_parcela_prop'] > 0) { ?>
        <plot><?php echo number_format($row_rsProperties['m2_parcela_prop'], 0,'',''); ?></plot>
        <?php } ?>
    </surface_area>

    <url>
        <en>https://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo propURL($row_rsProperties['id_prop'], 'en') ?></en>
    </url>

    <desc>
        <?php if($row_rsProperties['descripcion_en_prop'] != '') { ?><en><![CDATA[  <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_en_prop'])); ?> ]]></en><?php } ?>
        <?php if($row_rsProperties['descripcion_es_prop'] != '') { ?><es><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])); ?> ]]></es><?php } ?>
        <?php if($row_rsProperties['descripcion_de_prop'] != '') { ?><de><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_de_prop'])); ?> ]]></de><?php } ?>
        <?php if($row_rsProperties['descripcion_nl_prop'] != '') { ?><nl><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_nl_prop'])); ?> ]]></nl><?php } ?>
        <?php if($row_rsProperties['descripcion_fr_prop'] != '') { ?><fr><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_fr_prop'])); ?> ]]></fr><?php } ?>
        <?php if($row_rsProperties['descripcion_da_prop'] != '') { ?><da><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_da_prop'])); ?> ]]></da><?php } ?>
        <?php if($row_rsProperties['descripcion_ru_prop'] != '') { ?><ru><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_ru_prop'])); ?> ]]></ru><?php } ?>
    </desc>

    <?php
    
    $query_rsproperties_features = "SELECT features.feature_en_feat,
    	properties_features.feature_en_feat as parfeat
    FROM properties_property_feature INNER JOIN properties_features features ON properties_property_feature.feature = features.id_feat
    	 LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
    WHERE properties_property_feature.property = '".$row_rsProperties['id_prop']."'
    ";
    $rsproperties_features = mysqli_query($inmoconn,$query_rsproperties_features) or die(mysqli_error());
    $row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
    $totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);
    if($totalRows_rsproperties_features > 0) {
    echo "<features>";
    do {
    if($row_rsproperties_features['parfeat'] != '' || $row_rsproperties_features['feature_en_feat'] != '') {
     ?>
        <feature><?php echo ($row_rsproperties_features['parfeat'] == null)?strip_tags(preg_replace('/&/', '&amp;', $row_rsproperties_features['feature_en_feat'])):strip_tags(preg_replace('/&/', '&amp;', $row_rsproperties_features['parfeat'])); ?></feature>
    <?php } } while ($row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features));
    echo "</features>";
    }
    ?>

    <images>
    <?php
    
    $query_rsImages = "SELECT id_img, image_img FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 50";
    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
    $row_rsImages = mysqli_fetch_assoc($rsImages);
    $totalRows_rsImages = mysqli_num_rows($rsImages);
    $x = 1;
    do {
    ?>
    <?php if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/".$row_rsImages['image_img']."")) { ?>
        <image id="<?php echo $x++ ?>">
            <url>https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/<?php echo $row_rsImages['image_img']; ?></url>
        </image>
    <?php } ?>
    <?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
    </images>

</property>

<?php } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>

</root>

<?php
mysqli_free_result($rsProperties);
?>