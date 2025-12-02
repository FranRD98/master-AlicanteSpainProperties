<?php
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
include( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );


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
	(SELECT pool_en_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop,
	properties_properties.m2_prop,
	properties_properties.m2_parcela_prop,
	CASE WHEN properties_properties.descripcion_xml_en_prop != '' THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != '' THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != '' THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != '' THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != '' THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_da_prop != '' THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != '' THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    lat_long_gp_prop,
    commission_prop,
    garden_m2_prop,
    solarium_prop,
    direccion_prop,
    suma_prop,
    gastos_prop,
    construccion_prop,
    distance_beach_prop,
    orientacion_prop,
    planta_prop
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
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_inmoco_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1



GROUP BY id_prop


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
<?php do { ?>

<item>

    <property_id><?php echo $row_rsProperties['referencia_prop']; ?></property_id>

    <province><?php echo $row_rsProperties['province']; ?></province>

    <town><?php echo $row_rsProperties['partown']; ?></town>

    <street><?php echo $row_rsProperties['direccion_prop']; ?></street>

    <price><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></price>

    <price_vat>no</price_vat>

    <suma><?php echo $row_rsProperties['suma_prop']; ?></suma>

    <communal_charge><?php echo $row_rsProperties['gastos_prop']; ?></communal_charge>

    <commission><?php echo $row_rsProperties['commission_prop']; ?></commission>

    <type><?php echo ($row_rsProperties['partyp'] == null)?$row_rsProperties['types_en_typ']:$row_rsProperties['partyp']; ?></type>

    <pool><?php echo $row_rsProperties['piscina_prop']; ?></pool>

    <floor><?php echo $row_rsProperties['planta_prop']; ?></floor>

    <year_of_construction><?php echo $row_rsProperties['construccion_prop']; ?></year_of_construction>

    <bedrooms><?php echo $row_rsProperties['habitaciones_prop']; ?></bedrooms>

    <bathrooms><?php echo $row_rsProperties['aseos_prop']; ?></bathrooms>

    <solarium><?php echo ($row_rsProperties['solarium_prop'] == 1)?1:''; ?></solarium>

    <garden><?php echo $row_rsProperties['garden_m2_prop']; ?></garden>

    <orientation><?php

    if ($row_rsProperties['orientacion_prop'] == 'o-n') {
        echo "North";
    }
    if ($row_rsProperties['orientacion_prop'] == 'o-ne') {
        echo "Northeast";
    }
    if ($row_rsProperties['orientacion_prop'] == 'o-e') {
        echo "East";
    }
    if ($row_rsProperties['orientacion_prop'] == 'o-se') {
        echo "South east";
    }
    if ($row_rsProperties['orientacion_prop'] == 'o-s') {
        echo "South";
    }
    if ($row_rsProperties['orientacion_prop'] == 'o-so') {
        echo "Southwest";
    }
    if ($row_rsProperties['orientacion_prop'] == 'o-o') {
        echo "West";
    }
    if ($row_rsProperties['orientacion_prop'] == 'o-no') {
        echo "Northwest";
    }
    ?></orientation>

    <areas>
        <?php if ($row_rsProperties['m2_prop'] > 0) { ?>
        <covered><?php echo $row_rsProperties['m2_prop']; ?></covered>
        <?php } ?>
        <?php if ($row_rsProperties['m2_parcela_prop'] > 0) { ?>
        <plot><?php echo $row_rsProperties['m2_parcela_prop']; ?></plot>
        <?php } ?>
    </areas>

    <distances>
        <sea><?php echo $row_rsProperties['distance_beach_prop']; ?></sea>
    </distances>

    <descriptions>
        <?php if($row_rsProperties['descripcion_en_prop'] != '') { ?><en><![CDATA[  <?php echo str_replace('<br />', '&#13;&#13;', nl2br(strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_en_prop'])))); ?> ]]></en><?php } ?>
        <?php if($row_rsProperties['descripcion_es_prop'] != '') { ?><es><![CDATA[ <?php echo str_replace('<br />', '&#13;&#13;', nl2br(strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])))); ?> ]]></es><?php } ?>
    </descriptions>

    <images>
    <?php
    
    $query_rsImages = "SELECT id_img, image_img FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img";
    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
    $row_rsImages = mysqli_fetch_assoc($rsImages);
    $totalRows_rsImages = mysqli_num_rows($rsImages);
    do {
    ?>
    <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$row_rsImages['id_img']."_lg.jpg")) {
            ?>
            <?php if(preg_match('/https?:\/\//', $row_rsImages['image_img'])) { ?>
                <image><?php echo $row_rsImages['image_img']; ?></image>
            <?php } else { ?>
                <image>https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/<?php echo $row_rsImages['image_img']; ?></image>
            <?php } ?>
    <?php
        } ?>
    <?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
    </images>

</item>

<?php } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>

</root>

<?php
mysqli_free_result($rsProperties);
?>
