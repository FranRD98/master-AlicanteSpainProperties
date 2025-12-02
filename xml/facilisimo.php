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
    properties_properties.cp_prop,
    title_".$language."_prop as metatitle,
    lat_long_gp_prop,
    gastos_prop,
    m2_balcon_prop

	FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
	    INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
	    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
	    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
	    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND export_facilisimo_prop = 1 AND cp_prop > 0 AND vendido_prop = 0 AND vendido_tag_prop = 0
GROUP BY id_prop
";
$rsProperties = mysqli_query($inmoconn, $query_rsProperties) or die(mysqli_error() .'<hr>'.$query_rsProperties);
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

// echo $totalRows_rsProperties."<hr>";
// echo $query_rsProperties."<hr>";
// aa();

header('Content-type: text/xml; charset=UTF-8', true);
echo '<?xml version="1.0" encoding="UTF-8"?'.'>';

?>

<Inmuebles>
<?php do { ?>

<inmueble>

<Agencia id="<?php echo $facilisimoIdAgencia; ?>" />
<Referencia><?php echo $row_rsProperties['referencia_prop']; ?></Referencia>
<Tipo id="<?php echo (in_array($row_rsProperties['partypID'], $facilisimoIdTipoLocales))?'Local':'Vivienda'; ?>" />
<SubTipo id="<?php echo ($row_rsProperties['partyp'] == null)?$row_rsProperties['types_es_typ']:$row_rsProperties['partyp']; ?>" />
<Superficie><?php echo number_format($row_rsProperties['m2_prop'], 0,'',''); ?></Superficie>
<Habitaciones><?php echo $row_rsProperties['habitaciones_prop']; ?></Habitaciones>
<Baqos><?php echo $row_rsProperties['aseos_prop']; ?></Baqos>
<Observaciones_descripcion><![CDATA[<?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])); ?>]]></Observaciones_descripcion>
<Zona><?php echo $row_rsProperties['pararea'] ?></Zona>
<coordenadas><?php echo $row_rsProperties['lat_long_gp_prop'] ?></coordenadas>
<Gastos_comunidad>
    <Valor><?php echo $row_rsProperties['gastos_prop'] ?></Valor>
</Gastos_comunidad>
<Metros_terraza>
    <Valor><?php echo $row_rsProperties['m2_balcon_prop'] ?></Valor>
</Metros_terraza>
<Direccion>
    <CP><?php echo $row_rsProperties['cp_prop'] ?></CP>
    <Provincia id="<?php echo $row_rsProperties['province'] ?>" />
    <Poblacion id="<?php echo $row_rsProperties['partown'] ?>" />
</Direccion>
<Modalidades>
    <Venta>
        <Cuantia><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></Cuantia>
    </Venta>
</Modalidades>
<Caracteristicas>
<?php
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// ESTO HAY QUE AJUSTARLO A MANO CON LAS FEATURES DE LA BASE DE DATOS
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
$idsFeats = array();

$query_rsproperties_features = "SELECT feature FROM properties_property_feature  WHERE properties_property_feature.property = '".$row_rsProperties['id_prop']."'";
$rsproperties_features = mysqli_query($inmoconn,$query_rsproperties_features) or die(mysqli_error());
$row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
$totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);
if($totalRows_rsproperties_features > 0) {
    do {
        if($row_rsproperties_features['feature'] != '') {
            array_push($idsFeats, $row_rsproperties_features['feature']);
        }
    } while ($row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features));
}
?>
<?php if (in_array(52, $idsFeats)) { ?>
<Calefaccion_individual>
<Valor>si</Valor>
</Calefaccion_individual>
<?php } ?>
<?php if (in_array(8, $idsFeats)) { ?>
<Amueblado>
<Valor>si</Valor>
</Amueblado>
<?php } ?>
<?php if (in_array(29, $idsFeats)) { ?>
<Trastero>
<Valor>si</Valor>
</Trastero>
<?php } ?>
<?php if (in_array(40, $idsFeats) || in_array(16, $idsFeats)) { ?>
<Tenis_padel>
<Valor>si</Valor>
</Tenis_padel>
<?php } ?>
<?php if (in_array(2, $idsFeats)) { ?>
<Alarma>
<Valor>si</Valor>
</Alarma>
<?php } ?>
<?php if (in_array(62, $idsFeats)) { ?>
<vigilancia_portero>
<Valor>si</Valor>
</vigilancia_portero>
<?php } ?>
<?php if (in_array(1, $idsFeats) || in_array(72, $idsFeats)) { ?>
<aire_acondicionado>
<Valor>si</Valor>
</aire_acondicionado>
<?php } ?>
<?php if (in_array(59, $idsFeats)) { ?>
<ascensor>
<Valor>si</Valor>
</ascensor>
<?php } ?>
<?php if (in_array(9, $idsFeats)) { ?>
<Garaje>
<Valor>si</Valor>
</Garaje>
<?php } ?>
<?php if (in_array(39, $idsFeats)) { ?>
<area_infantil>
<Valor>si</Valor>
</area_infantil>
<?php } ?>
<?php if (in_array(15, $idsFeats) || in_array(6, $idsFeats)) { ?>
<Piscina>
<Valor>si</Valor>
</Piscina>
<?php } ?>
<?php if (in_array(66, $idsFeats)) { ?>
<carpinteria_ventanas>
<Valor>Aluminio</Valor>
</carpinteria_ventanas>
<?php } ?>
<?php if (in_array(68, $idsFeats)) { ?>
<carpinteria_ventanas>
<Valor>Madera</Valor>
</carpinteria_ventanas>
<?php } ?>
<?php if (in_array(57, $idsFeats)) { ?>
<carpinteria_ventanas>
<Valor>Pvc</Valor>
</carpinteria_ventanas>
<?php } ?>
<?php if (in_array(66, $idsFeats)) { ?>
<suelos>
<Valor>marmol</Valor>
</suelos>
<?php } ?>
<?php if (in_array(55, $idsFeats)) { ?>
<suelos>
<Valor>gres</Valor>
</suelos>
<?php } ?>
<?php if (in_array(71, $idsFeats)) { ?>
<suelos>
<Valor>porcelanico</Valor>
</suelos>
<?php } ?>
</Caracteristicas>
<Fotografias>
<?php

$query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 28";
$rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
$row_rsImages = mysqli_fetch_assoc($rsImages);
$totalRows_rsImages = mysqli_num_rows($rsImages);
$x = 1;
do {
?>
<fotografia>
<?php if(preg_match('/https?:\/\//', $row_rsImages['image_img'])) { ?>
<?php echo $row_rsImages['image_img']; ?>
<?php } else { ?>
http://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/<?php echo $row_rsImages['image_img']; ?>
<?php } ?>
</fotografia>
<?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
</Fotografias>
<FechaActualizacion><?php echo date("d-m-Y H:i", strtotime($row_rsProperties['updated_prop'])); ?></FechaActualizacion>

</inmueble>

<?php } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>

 </Inmuebles>

<?php
mysqli_free_result($rsProperties);mysqli_close($inmoconn);
?>
