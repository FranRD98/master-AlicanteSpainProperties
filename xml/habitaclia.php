<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
include( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

$query_rsProperties = "

SELECT properties_properties.id_prop,
    properties_properties.updated_prop,
    properties_properties.operacion_prop,
    properties_properties.referencia_prop,
    properties_properties.preci_reducidoo_prop,
    properties_status.id_sta AS saleId,
    properties_status.slug_sta,
    properties_status.status_es_sta,
    CASE WHEN properties_types.types_es_typ IS NOT NULL THEN properties_types.types_es_typ ELSE types.types_es_typ END AS partyp,
    CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS partypID,
    CASE WHEN properties_loc2.name_es_loc2 IS NOT NULL THEN properties_loc2.name_es_loc2 ELSE province1.name_es_loc2  END AS province,
    CASE WHEN properties_loc3.name_es_loc3 IS NOT NULL THEN properties_loc3.name_es_loc3 ELSE areas1.name_es_loc3  END AS partown,
    CASE WHEN properties_loc4.name_es_loc4 IS NOT NULL THEN properties_loc4.name_es_loc4 ELSE towns.name_es_loc4  END AS pararea,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.piscina_prop,
    properties_properties.titulo_es_prop,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    CASE WHEN properties_properties.descripcion_xml_en_prop != '' THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != '' THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != '' THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != '' THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != '' THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_da_prop != '' THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != '' THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    properties_properties.energia_prop,
    title_".$language."_prop as metatitle,
    lat_long_gp_prop

    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND export_habitaclia_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0

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

<producto xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<?php do { ?>

<inmueble>
<id_inmueble><?php echo $row_rsProperties['id_prop']; ?></id_inmueble>
<referencia><![CDATA[<?php echo $row_rsProperties['referencia_prop']; ?>]]></referencia>
<venta_01><?php echo ($row_rsProperties['slug_sta'] == "new_build" || $row_rsProperties['slug_sta'] == "sale")? 1 : 0; ?></venta_01>
<alquiler_01><?php echo ($row_rsProperties['slug_sta'] == "month" || $row_rsProperties['slug_sta'] == "week") ? 1 : 0; ?></alquiler_01>
<alquiler_opcion_venta_01>0</alquiler_opcion_venta_01>
<traspaso_01>0</traspaso_01>
<alquiler_temporada_01>0</alquiler_temporada_01>
<?php if($row_rsProperties['slug_sta'] == "new_build" || $row_rsProperties['slug_sta'] == "sale"):?>
    <precio_venta><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></precio_venta>
<?php else:?>
    <precio_alquiler><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></precio_alquiler>
<?php endif?>
<tipo><?php echo in_array($row_rsProperties['partypID'],  $habitacliaTipo)?'Local':'Vivienda'; ?></tipo>
<subtipo><?php echo ($row_rsProperties['partyp'] == null)?$row_rsProperties['types_es_typ']:$row_rsProperties['partyp']; ?></subtipo>
<provincia><?php echo $row_rsProperties['province'] ?></provincia>
<localidad><?php echo $row_rsProperties['partown'] ?></localidad>
<ubicacion><?php echo $row_rsProperties['pararea'] ?></ubicacion>
<aseos><?php echo $row_rsProperties['aseos_prop']; ?></aseos>
<habitaciones><?php echo $row_rsProperties['habitaciones_prop']; ?></habitaciones>
<m2construidos><?php echo number_format($row_rsProperties['m2_prop'], 0,'',''); ?></m2construidos>
<destacado><?php echo $row_rsProperties['titulo_es_prop'] ?></destacado>
<descripcion><![CDATA[<?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])); ?>]]></descripcion>
<m2_terreno><?php echo number_format($row_rsProperties['m2_parcela_prop'], 0,'',''); ?></m2_terreno>
<?php
    $energia_prop = "ZZ";
    if($row_rsProperties['energia_prop'] != '' && $row_rsProperties['energia_prop'] != 'X' && $row_rsProperties['energia_prop'] != '0') {
        $energia_prop = $row_rsProperties['energia_prop'];
    }
?>
<calif_energetica><?php echo $energia_prop; ?></calif_energetica>
<photos>
<?php
$query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 20";
$rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
$row_rsImages = mysqli_fetch_assoc($rsImages);
$totalRows_rsImages = mysqli_num_rows($rsImages);
$x = 1;
do {
?>
<photo>
<?php if(preg_match('/https?:\/\//', $row_rsImages['image_img'])) { ?>
<url><?php echo $row_rsImages['image_img']; ?></url>
<?php } else { ?>
<url>http://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/<?php echo $row_rsImages['image_img']; ?></url>
<?php } ?>
<numimagen><?php echo $x++ ?></numimagen>
</photo>
<?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
</photos>
<?php if($row_rsProperties['lat_long_gp_prop'] != '') { ?>
<?php $latlong = preg_split('/\,/', $row_rsProperties['lat_long_gp_prop']); ?>
<mapa>
    <latitud><?php echo trim($latlong[0]) ?></latitud>
    <longitud><?php echo trim($latlong[1]) ?></longitud>
    <zoom>17</zoom>
    <puntero>0</puntero>
</mapa>
<?php } ?>
</inmueble>

<?php } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>

 </producto>

<?php
mysqli_free_result($rsProperties);mysqli_close($inmoconn);
?>
