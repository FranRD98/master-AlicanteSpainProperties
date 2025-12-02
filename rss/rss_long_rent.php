<?php
include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
include($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

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
    properties_properties.descripcion_en_prop,
    properties_properties.descripcion_es_prop,
    properties_properties.descripcion_de_prop,
    properties_properties.descripcion_nl_prop,
    properties_properties.descripcion_fr_prop,
    properties_properties.descripcion_da_prop,
    properties_properties.descripcion_ru_prop,
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
AND operacion_prop = 4

GROUP BY id_prop
ORDER BY id_prop DESC
LIMIT 100

";
$rsProperties = mysqli_query($inmoconn, $query_rsProperties) or die(mysqli_error() .'<hr>'.$query_rsProperties);
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);


header('Content-type: text/xml; charset=UTF-8', true);
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/">';

?>

<channel>
    <title>XXXXXXXXXXXXXX</title>
    <atom:link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/rss/rss_long_rent.php" rel="self" type="application/rss+xml" />
    <link>https://<?php echo $_SERVER['HTTP_HOST']; ?></link>
    <description>XXXXXXXXXXXXXX</description>
    <lastBuildDate><?php echo date("D, d M Y h:i:s +0000") ?></lastBuildDate>
    <language>en-GB</language>
    <sy:updatePeriod>hourly</sy:updatePeriod>
    <sy:updateFrequency>1</sy:updateFrequency>
    <generator>https://<?php echo $_SERVER['HTTP_HOST']; ?></generator>
    <image>
        <url>https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/icons/android-icon-144x144.png</url>
        <title>XXXXXXXXXXXXXX</title>
        <link>https://<?php echo $_SERVER['HTTP_HOST']; ?></link>
        <width>144</width>
        <height>144</height>
    </image>
<?php do { ?>
<item>
    <title><![CDATA[<?php echo ($row_rsProperties['partyp'] == null)?$row_rsProperties['types_en_typ']:$row_rsProperties['partyp']; ?> for long term rental in <?php echo $row_rsProperties['partown']; ?>, <?php echo $row_rsProperties['province']; ?>]]></title>
    <link>https://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo propURL($row_rsProperties['id_prop'], 'en') ?></link>
    <pubDate><?php echo date("D, d M Y h:i:s +0000", strtotime($row_rsProperties['updated_prop'])) ?></pubDate>
    <dc:creator>
        <![CDATA[XXXXXXXXXXXXXX]]>
    </dc:creator>
    <category>
        <![CDATA[Properties]]>
    </category>
    <guid isPermaLink="false">https://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo propURL($row_rsProperties['id_prop'], 'en') ?></guid>
    <description>
        <![CDATA[<?php echo strip_tags(str_replace('&nbsp;', ' ', html_entity_decode($row_rsProperties['descripcion_en_prop']))); ?>]]>
    </description>
</item>
<?php
} while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>

</channel>
</rss>

<?php
mysqli_free_result($rsProperties);
?>
