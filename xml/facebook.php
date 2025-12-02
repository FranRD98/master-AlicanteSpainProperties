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
    CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS idtyp,
    CASE WHEN properties_types.types_".$_GET['lang']."_typ IS NOT NULL THEN properties_types.types_".$_GET['lang']."_typ ELSE types.types_".$_GET['lang']."_typ END AS partyp,
    CASE WHEN properties_loc2.name_".$_GET['lang']."_loc2 IS NOT NULL THEN properties_loc2.name_".$_GET['lang']."_loc2 ELSE province1.name_".$_GET['lang']."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$_GET['lang']."_loc3 IS NOT NULL THEN properties_loc3.name_".$_GET['lang']."_loc3 ELSE areas1.name_".$_GET['lang']."_loc3  END AS partown,
    CASE WHEN properties_loc4.name_".$_GET['lang']."_loc4 IS NOT NULL THEN properties_loc4.name_".$_GET['lang']."_loc4 ELSE towns.name_".$_GET['lang']."_loc4  END AS pararea,
    CASE WHEN properties_types.types_".$_GET['lang']."_typ IS NOT NULL THEN properties_types.types_".$_GET['lang']."_typ ELSE types.types_".$_GET['lang']."_typ END AS partyp_en,
    CASE WHEN properties_loc2.name_".$_GET['lang']."_loc2 IS NOT NULL THEN properties_loc2.name_".$_GET['lang']."_loc2 ELSE province1.name_".$_GET['lang']."_loc2  END AS province_en,
    CASE WHEN properties_loc3.name_".$_GET['lang']."_loc3 IS NOT NULL THEN properties_loc3.name_".$_GET['lang']."_loc3 ELSE areas1.name_".$_GET['lang']."_loc3  END AS partown_en,
    CASE WHEN properties_loc4.name_".$_GET['lang']."_loc4 IS NOT NULL THEN properties_loc4.name_".$_GET['lang']."_loc4 ELSE towns.name_".$_GET['lang']."_loc4  END AS pararea_en,
    title_".$_GET['lang']."_prop as metatitle_en,
    properties_status.status_".$_GET['lang']."_sta as status_en,
    properties_loc1.name_".$_GET['lang']."_loc1 AS country,
    title_".$_GET['lang']."_prop as metatitle,
    properties_status.status_".$_GET['lang']."_sta,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.piscina_prop,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    CASE WHEN properties_properties.descripcion_xml_".$_GET['lang']."_prop != '' THEN properties_properties.descripcion_xml_".$_GET['lang']."_prop ELSE properties_properties.descripcion_".$_GET['lang']."_prop END AS descripcion_".$_GET['lang']."_prop,
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
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_facebook_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

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
<listings>

    <title><?php echo $_SERVER['HTTP_HOST']; ?> Feed</title>
    <link rel="self" href="http://<?php echo $_SERVER['HTTP_HOST'] ?><?php echo $_SERVER['REQUEST_URI'] ?>"/>

<?php do {
    ?>

<listing>

    <home_listing_id><?php echo $row_rsProperties['id_prop']; ?></home_listing_id>
    <name><?php echo $row_rsProperties['referencia_prop']; ?></name>
    <availability><?php
    if ($row_rsProperties['slug_sta'] == 'month') {
        echo "for_rent";
    }
    if ($row_rsProperties['slug_sta'] == 'week') {
        echo "for_rent";
    }
    if ($row_rsProperties['slug_sta'] == 'new_build') {
        echo "for_sale";
    }
    if ($row_rsProperties['slug_sta'] == 'sale') {
        echo "for_sale";
    } ?></availability>
    <description><![CDATA[  <?php echo substr((preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_'.$_GET['lang'].'_prop'])), 5000); ?> ]]></description>
    <address format="simple">
        <component name="city"><?php echo $row_rsProperties['partown']; ?></component>
        <component name="region"><?php echo $row_rsProperties['province']; ?></component>
        <component name="country"><?php echo $row_rsProperties['country']; ?></component>
    </address>
    <?php $latlong = preg_split('/\,/', $row_rsProperties['lat_long_gp_prop']); ?>
    <?php if ($row_rsProperties['lat_long_gp_prop'] != '') { ?>
    <latitude><?php echo trim($latlong[0]) ?></latitude>
    <longitude><?php echo trim($latlong[1]) ?></longitude>
    <?php } ?>
    <neighborhood><![CDATA[<?php echo $row_rsProperties['pararea']; ?>]]></neighborhood>
    <image>
    <?php
    
    $query_rsImages = "SELECT id_img, image_img FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 1";
    $rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
    $row_rsImages = mysqli_fetch_assoc($rsImages);
    $totalRows_rsImages = mysqli_num_rows($rsImages);
    $x = 1;
    do {
        ?>
     <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$row_rsImages['id_img']."_lg.jpg")) {
            ?>
            <url>https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/thumbnails/<?php echo $row_rsImages['id_img']; ?>_lg.jpg</url>
    <?php
        } ?>
    <?php
    } while ($row_rsImages  = mysqli_fetch_assoc($rsImages)); ?>
    </image>
    <listing_type><?php
    if ($row_rsProperties['slug_sta'] == 'month') {
        echo "for_rent_by_agent";
    }
    if ($row_rsProperties['slug_sta'] == 'week') {
        echo "for_rent_by_agent";
    }
    if ($row_rsProperties['slug_sta'] == 'new_build') {
        echo "new_construction";
    }
    if ($row_rsProperties['slug_sta'] == 'sale') {
        echo "for_sale_by_agent";
    } ?></listing_type>
    <num_baths><?php echo $row_rsProperties['aseos_prop']; ?></num_baths>
    <num_beds><?php echo $row_rsProperties['habitaciones_prop']; ?></num_beds>
    <price><?php echo $row_rsProperties['preci_reducidoo_prop']; ?> EUR</price>
    <property_type><?php
    switch ($row_rsProperties['idtyp']) {
        case 1:
        case 259:
            echo "apartment";
            break;
        case 256:
        case 184:
            echo "house";
            break;
        case 65:
        case 49:
        case 261:
        case 33:
        case 262:
        case 4:
            echo "townhouse";
            break;
        case 51:
            echo "land";
            break;
        default:
            echo "other";
            break;
    } ?></property_type>
    <url>https://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo propURL($row_rsProperties['id_prop'], $_GET['lang']) ?></url>
    <?php if ($row_rsProperties['slug_sta'] == 'month' || $row_rsProperties['slug_sta'] == 'week'): ?>
    <available_dates_price_config>
        <start_date><?php echo date("Y"); ?>-01-01</start_date>
        <end_date><?php echo date("Y"); ?>-12-31</end_date>
        <rate><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></rate>
        <currency>EUR</currency>
        <interval><?php
        if ($row_rsProperties['slug_sta'] == 'month') {
            echo "monthly";
        }
    if ($row_rsProperties['slug_sta'] == 'week') {
        echo "weekly";
    } ?></interval>
    </available_dates_price_config>
    <?php endif ?>
</listing>

<?php
} while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>

</listings>

<?php
mysqli_free_result($rsProperties);
?>
