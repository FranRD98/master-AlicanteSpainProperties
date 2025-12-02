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
    properties_status.id_sta,
    properties_status.slug_sta,
    properties_status.status_es_sta,
    CASE WHEN properties_types.types_es_typ IS NOT NULL THEN properties_types.types_es_typ ELSE types.types_es_typ END AS partyp,
    CASE WHEN properties_loc2.name_es_loc2 IS NOT NULL THEN properties_loc2.name_es_loc2 ELSE province1.name_es_loc2  END AS province,
    CASE WHEN properties_loc3.name_es_loc3 IS NOT NULL THEN properties_loc3.name_es_loc3 ELSE areas1.name_es_loc3  END AS partown,
    CASE WHEN properties_loc4.name_es_loc4 IS NOT NULL THEN properties_loc4.name_es_loc4 ELSE towns.name_es_loc4  END AS pararea,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.piscina_prop,
    properties_properties.ascensor_prop,
    properties_properties.cp_prop,
    properties_properties.construccion_prop,
    properties_properties.gastos_prop,
    properties_properties.m2_prop,
    properties_properties.lat_long_gp_prop as maplat,
    properties_properties.m2_parcela_prop,
    CASE WHEN properties_properties.descripcion_xml_en_prop != '' THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != '' THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != '' THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != '' THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != '' THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_da_prop != '' THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != '' THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    CASE WHEN properties_properties.descripcion_xml_no_prop != '' THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS descripcion_no_prop,
    CASE WHEN properties_properties.descripcion_xml_se_prop != '' THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
    CASE WHEN properties_properties.descripcion_xml_fi_prop != '' THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS descripcion_fi_prop,
    title_".$language."_prop as metatitle

    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        INNER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
        INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND export_pisos_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0

GROUP BY id_prop

LIMIT ".$pisosLimit."

";
$rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error() .'<hr>'.$query_rsProperties);
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

// echo $query_rsProperties;
// aa();

header('Content-type: text/xml; charset=UTF-8', true);
echo '<?xml version="1.0" encoding="UTF-8"?'.'>';

?>
<Publicacion>
  <Table Name="Agencias">
    <Agencia>
      <IdInmobiliariaExterna><?php echo $pisosIdInmobiliariaExterna ?></IdInmobiliariaExterna>
      <NombreAgencia><?php echo $pisosNombreAgencia ?></NombreAgencia>
      <DireccionAgencia><?php echo $pisosDireccionAgencia ?></DireccionAgencia>
      <PoblacionAgencia><?php echo $pisosPoblacionAgencia ?></PoblacionAgencia>
      <TelefonoAgencia><?php echo $pisosTelefonoAgencia ?></TelefonoAgencia>
      <FaxAgencia><?php echo $pisosFaxAgencia ?></FaxAgencia>
      <EmailAgencia><?php echo $pisosEmailAgencia ?></EmailAgencia>
      <WebAgencia><?php echo $pisosWebAgencia ?></WebAgencia>
    </Agencia>
  </Table>
  <Table Name="Inmuebles">
    <?php do {


$lat = explode(',',$row_rsProperties['maplat']);

$lat1 = str_replace(' ', '', $lat[0]);

$lat2 = str_replace(' ', '', $lat[1]);
?>
    <Inmueble>
        <IdInmobiliariaExterna><?php echo $pisosIdInmobiliariaExterna ?></IdInmobiliariaExterna>
        <IdPisoExterno><?php echo $row_rsProperties['referencia_prop']; ?></IdPisoExterno>
        <FechaHoraModificado><?php echo date("d/m/Y h:i:s", strtotime($row_rsProperties['updated_prop'])); ?> </FechaHoraModificado>
        <TipoInmueble><?php echo ($row_rsProperties['partyp'] == null)?$row_rsProperties['types_es_typ']:$row_rsProperties['partyp']; ?></TipoInmueble>
        <TipoOperacion><?php echo ($row_rsProperties['id_sta'] == 1 || $row_rsProperties['id_sta'] == 2)?4:3; ?></TipoOperacion>
        <PrecioEur><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></PrecioEur>
        <NombrePoblacion><?php echo $row_rsProperties['partown']; ?></NombrePoblacion>
        <CodigoPostal><?php echo $row_rsProperties['cp_prop']; ?></CodigoPostal>
        <Situacion1><?php echo $row_rsProperties['pararea']; ?></Situacion1>
        <SuperficieConstruida><?php echo number_format($row_rsProperties['m2_prop'], 0,'',''); ?></SuperficieConstruida>
        <SuperficieUtil><?php echo number_format($row_rsProperties['m2_parcela_prop'], 0,'',''); ?></SuperficieUtil>
        <HabitacionesDobles></HabitacionesDobles>
        <HabitacionesSimples><?php echo $row_rsProperties['habitaciones_prop']; ?></HabitacionesSimples>
        <BanosCompletos><?php echo $row_rsProperties['aseos_prop']; ?></BanosCompletos>
        <BanosAuxiliares></BanosAuxiliares>
        <Expediente><?php echo $row_rsProperties['referencia_prop']; ?></Expediente>
        <Email></Email>
        <Telefono></Telefono>
        <Descripcion><?php if($row_rsProperties['descripcion_es_prop'] != '') { ?><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])); ?> ]]><?php } ?></Descripcion>
        <Descripciones>
            <es><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_es_prop'])); ?> ]]></es>
            <en><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_en_prop'])); ?> ]]></en>
            <de><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_de_prop'])); ?> ]]></de>
            <fr><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_fr_prop'])); ?> ]]></fr>
            <nl><![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsProperties['descripcion_nl_prop'])); ?> ]]></nl>
        </Descripciones>
        <Fotos>
        <?php
        
        $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 200";
        $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
        $row_rsImages = mysqli_fetch_assoc($rsImages);
        $totalRows_rsImages = mysqli_num_rows($rsImages);
        $x = 1;
        $y = 1;
        do {
        ?>
        <Foto<?php echo $x++ ?>><?php if(preg_match('/https?:\/\//', $row_rsImages['image_img'])) { ?><?php echo $row_rsImages['image_img']; ?><?php } else { ?>http://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/<?php echo $row_rsImages['image_img']; ?><?php } ?></Foto<?php echo $y++ ?>>
        <?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
        </Fotos>
        <?php
        
        $query_rsVideos = "SELECT video_vid, id_vid FROM  properties_videos WHERE  property_vid = '".$row_rsProperties['id_prop']."' ORDER BY order_vid ASC";
        $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
        $row_rsVideos = mysqli_fetch_assoc($rsVideos);
        $totalRows_rsVideos = mysqli_num_rows($rsVideos);
        if($totalRows_rsVideos >0) {
            echo "<VideosExternos>";
        do {
            if ($row_rsVideos['video_vid'] != '') {
                preg_match_all('/<iframe[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $row_rsVideos['video_vid'], $result);
                $video = explode('&', $result['src'][0]);
        ?>
                <Video><?php echo str_replace("embed/","watch?v=", str_replace("?rel=0","", $video[0])) ?></Video>
        <?php
            }
        } while ($row_rsVideos = mysqli_fetch_assoc($rsVideos));
            echo "</VideosExternos>";
        }
        ?>
        <EstadoConservacion><?php if ($row_rsProperties['operacion_prop']==2) {echo "A estrenar"; } else {echo'Buen estado';}?></EstadoConservacion>
        <TipoCalle></TipoCalle>
        <NombreCalle></NombreCalle>
        <TipoNumeroCalle></TipoNumeroCalle>
        <NumeroCalle></NumeroCalle>
        <Escalera></Escalera>
        <AlturaPiso></AlturaPiso>
        <MostrarCalle></MostrarCalle>
        <NumeroVecinos></NumeroVecinos>
        <Latitud><?php echo $lat1;?></Latitud>
        <Longitud><?php echo $lat2;?></Longitud>
        <AnoConstruccion_tiene><?php if ($row_rsProperties['construccion_prop']=='') {echo "0";} else {echo "1"; }?></AnoConstruccion_tiene>
        <AnoConstruccion_comentario><?php if ($row_rsProperties['construccion_prop']!='') {echo $row_rsProperties['construccion_prop'];}?></AnoConstruccion_comentario>
        <GastosComunidad_tiene><?php if ($row_rsProperties['gastos_prop']=='') {echo "0";} else {echo "1"; }?></GastosComunidad_tiene>
        <GastosComunidad_comentario><?php if ($row_rsProperties['gastos_prop']!='') {echo $row_rsProperties['gastos_prop'];}?></GastosComunidad_comentario>
        <Piscina_tiene><?php if ($row_rsProperties['piscina_prop'] > 0): ?>1<?php endif ?></Piscina_tiene>
        <Ascensor_tiene><?php echo $row_rsProperties['ascensor_prop']; ?></Ascensor_tiene>
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
        <?php if (in_array(76, $idsFeats)) { ?>
        <Lavadero_tiene>1</Lavadero_tiene>
        <?php } ?>
        <?php if (in_array(29, $idsFeats) || in_array(44, $idsFeats)) { ?>
        <Trastero_tiene>1</Trastero_tiene>
        <?php } ?>
        <?php if (in_array(44, $idsFeats)) { ?>
        <Trastero_comentario>Opcional</Trastero_comentario>
        <?php } ?>
        <?php if (in_array(9, $idsFeats) || in_array(11, $idsFeats)) { ?>
        <Garaje_tiene>1</Garaje_tiene>
        <?php } ?>
        <?php if (in_array(11, $idsFeats)) { ?>
        <Garaje_comentario>Opcional</Garaje_comentario>
        <?php } ?>
        <?php if (in_array(60, $idsFeats)) { ?>
        <Terraza_tiene>1</Terraza_tiene>
        <?php } ?>
        <?php if (in_array(10, $idsFeats) || in_array(5, $idsFeats)) { ?>
        <Jardin_tiene>1</Jardin_tiene>
        <?php } ?>
        <?php if (in_array(5, $idsFeats)) { ?>
        <Jardin_comentario>Comunitario</Jardin_comentario>
        <?php } ?>
        <?php if (in_array(36, $idsFeats)) { ?>
        <ArmariosEmpotrados_tiene>1</ArmariosEmpotrados_tiene>
        <?php } ?>
        <?php if (in_array(52, $idsFeats)) { ?>
        <Calefaccion_tiene>1</Calefaccion_tiene>
        <?php } ?>
        <?php if (in_array(1, $idsFeats) || in_array(72, $idsFeats)) { ?>
        <AireAcondicionado_tiene>1</AireAcondicionado_tiene>
        <?php } ?>
        <?php if (in_array(8, $idsFeats)) { ?>
        <Amueblado_tiene>1</Amueblado_tiene>
        <?php } ?>
        <?php if (in_array(37, $idsFeats)) { ?>
        <PuertaBlindada_tiene>1</PuertaBlindada_tiene>
        <?php } ?>
        <?php if (in_array(64, $idsFeats)) { ?>
        <PorteroAutomatico_tiene>1</PorteroAutomatico_tiene>
        <?php } ?>
        <?php if (in_array(47, $idsFeats)) { ?>
        <Chimenea_tiene>1</Chimenea_tiene>
        <?php } ?>
        <?php if (in_array(75, $idsFeats) || in_array(55, $idsFeats) || in_array(66, $idsFeats) || in_array(71, $idsFeats)) { ?>
        <suelo_tiene>1</suelo_tiene>
        <?php } ?>
        <?php if (in_array(75, $idsFeats)) { ?>
        <suelo_Comentario>Radiente</suelo_Comentario>
        <?php } ?>
        <?php if (in_array(55, $idsFeats)) { ?>
        <suelo_Comentario>Gress</suelo_Comentario>
        <?php } ?>
        <?php if (in_array(66, $idsFeats)) { ?>
        <suelo_Comentario>Mármol</suelo_Comentario>
        <?php } ?>
        <?php if (in_array(71, $idsFeats)) { ?>
        <suelo_Comentario>Porcelánico</suelo_Comentario>
        <?php } ?>
        <?php if (in_array(27, $idsFeats)) { ?>
        <CajaFuerte_tiene>1</CajaFuerte_tiene>
        <?php } ?>
    </Inmueble>
    <?php } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>

  </Table>
</Publicacion>
<?php
mysqli_free_result($rsProperties);
?>
