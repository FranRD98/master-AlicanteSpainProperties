<?php
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
include( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );


$query_rsXML = "SELECT * FROM xml_export WHERE uid_exp = '".simpleSanitize(($_GET['f']))."'";
$rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error());
$row_rsXML = mysqli_fetch_assoc($rsXML);
$totalRows_rsXML = mysqli_num_rows($rsXML);

if ($row_rsXML['id_exp'] == '') {
    die();
}

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
if ($row_rsXML['beds_exp'] != '') {
    $val = explode(';', $row_rsXML['beds_exp']);
    $beds = ' AND habitaciones_prop >= '.$val[0].' AND habitaciones_prop <= '.$val[1].' ';
}

$baths = '';
if ($row_rsXML['baths_exp'] != '') {
    $val = explode(';', $row_rsXML['baths_exp']);
    $baths = ' AND aseos_prop >= '.$val[0].' AND aseos_prop <= '.$val[1].' ';
}

$price = '';
if ($row_rsXML['price_exp'] != '') {
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

$refs = '';
if ($row_rsXML['kyero_xml'] == 1 || $row_rsXML['xml_exp'] == 1) {
    if ($row_rsXML['ref_exp'] != '') {
        $refs .= ' OR id_prop IN ('.$row_rsXML['ref_exp'].')';
    }
} else {
    if ($row_rsXML['ref_exp'] != '') {
        $refs .= ' AND id_prop IN ('.$row_rsXML['ref_exp'].')';
        $xml = '';
    }
}

if ($row_rsXML['ref_ex_exp'] != '') {
    $refs .= ' AND id_prop NOT IN ('.$row_rsXML['ref_ex_exp'].')';
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
    CASE WHEN properties_types.types_ca_typ IS NOT NULL THEN properties_types.types_ca_typ ELSE types.types_ca_typ END AS partyp_ca,
    CASE WHEN properties_types.types_da_typ IS NOT NULL THEN properties_types.types_da_typ ELSE types.types_da_typ END AS partyp_da,
    CASE WHEN properties_types.types_de_typ IS NOT NULL THEN properties_types.types_de_typ ELSE types.types_de_typ END AS partyp_de,
    CASE WHEN properties_types.types_en_typ IS NOT NULL THEN properties_types.types_en_typ ELSE types.types_en_typ END AS partyp_en,
    CASE WHEN properties_types.types_es_typ IS NOT NULL THEN properties_types.types_es_typ ELSE types.types_es_typ END AS partyp_es,
    CASE WHEN properties_types.types_fi_typ IS NOT NULL THEN properties_types.types_fi_typ ELSE types.types_fi_typ END AS partyp_fi,
    CASE WHEN properties_types.types_fr_typ IS NOT NULL THEN properties_types.types_fr_typ ELSE types.types_fr_typ END AS partyp_fr,
    CASE WHEN properties_types.types_is_typ IS NOT NULL THEN properties_types.types_is_typ ELSE types.types_is_typ END AS partyp_is,
    CASE WHEN properties_types.types_nl_typ IS NOT NULL THEN properties_types.types_nl_typ ELSE types.types_nl_typ END AS partyp_nl,
    CASE WHEN properties_types.types_no_typ IS NOT NULL THEN properties_types.types_no_typ ELSE types.types_no_typ END AS partyp_no,
    CASE WHEN properties_types.types_ru_typ IS NOT NULL THEN properties_types.types_ru_typ ELSE types.types_ru_typ END AS partyp_ru,
    CASE WHEN properties_types.types_se_typ IS NOT NULL THEN properties_types.types_se_typ ELSE types.types_se_typ END AS partyp_se,
    CASE WHEN properties_types.types_zh_typ IS NOT NULL THEN properties_types.types_zh_typ ELSE types.types_zh_typ END AS partyp_zh,
    CASE WHEN properties_types.types_pl_typ IS NOT NULL THEN properties_types.types_pl_typ ELSE types.types_pl_typ END AS partyp_pl,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province,
    CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS partown,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS pararea,
    CASE WHEN properties_types.types_en_typ IS NOT NULL THEN properties_types.types_en_typ ELSE types.types_en_typ END AS partyp_en,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province_en,
    CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS partown_en,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS pararea_en,
    CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
        (SELECT coast_en_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
    title_en_prop as metatitle_en,
    properties_status.status_en_sta as status_en,
    properties_loc1.name_en_loc1 AS country,
    title_en_prop as metatitle,
    properties_status.status_en_sta,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.aseos2_prop,
    (SELECT pool_ca_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_ca,
    (SELECT pool_da_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_da,
    (SELECT pool_de_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_de,
    (SELECT pool_en_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_en,
    (SELECT pool_es_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_es,
    (SELECT pool_fi_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_fi,
    (SELECT pool_fr_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_fr,
    (SELECT pool_is_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_is,
    (SELECT pool_nl_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_nl,
    (SELECT pool_no_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_no,
    (SELECT pool_ru_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_ru,
    (SELECT pool_se_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_se,
    (SELECT pool_zh_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_zh,
    (SELECT pool_pl_pl FROM properties_pool WHERE id_pl = piscina_prop) AS piscina_prop_pl,
    (SELECT parking_ca_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_ca,
    (SELECT parking_da_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_da,
    (SELECT parking_de_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_de,
    (SELECT parking_en_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_en,
    (SELECT parking_es_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_es,
    (SELECT parking_fi_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_fi,
    (SELECT parking_fr_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_fr,
    (SELECT parking_is_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_is,
    (SELECT parking_nl_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_nl,
    (SELECT parking_no_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_no,
    (SELECT parking_ru_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_ru,
    (SELECT parking_se_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_se,
    (SELECT parking_zh_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_zh,
    (SELECT parking_pl_prk FROM properties_parking WHERE id_prk = parking_prop) AS parking_prop_pl,
    (SELECT kitchen_ca_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_ca,
    (SELECT kitchen_da_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_da,
    (SELECT kitchen_de_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_de,
    (SELECT kitchen_en_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_en,
    (SELECT kitchen_es_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_es,
    (SELECT kitchen_fi_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_fi,
    (SELECT kitchen_fr_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_fr,
    (SELECT kitchen_is_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_is,
    (SELECT kitchen_nl_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_nl,
    (SELECT kitchen_no_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_no,
    (SELECT kitchen_ru_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_ru,
    (SELECT kitchen_se_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_se,
    (SELECT kitchen_zh_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_zh,
    (SELECT kitchen_pl_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop) AS cocinas_prop_pl,
    (SELECT condition_ca_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_ca,
    (SELECT condition_da_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_da,
    (SELECT condition_de_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_de,
    (SELECT condition_en_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_en,
    (SELECT condition_es_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_es,
    (SELECT condition_fi_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_fi,
    (SELECT condition_fr_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_fr,
    (SELECT condition_is_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_is,
    (SELECT condition_nl_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_nl,
    (SELECT condition_no_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_no,
    (SELECT condition_ru_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_ru,
    (SELECT condition_se_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_se,
    (SELECT condition_zh_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_zh,
    (SELECT condition_pl_cond FROM properties_condition WHERE id_cond = estado_prop) AS estado_prop_pl,
    (SELECT planta_ca_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_ca,
    (SELECT planta_da_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_da,
    (SELECT planta_de_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_de,
    (SELECT planta_en_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_en,
    (SELECT planta_es_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_es,
    (SELECT planta_fi_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_fi,
    (SELECT planta_fr_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_fr,
    (SELECT planta_is_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_is,
    (SELECT planta_nl_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_nl,
    (SELECT planta_no_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_no,
    (SELECT planta_ru_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_ru,
    (SELECT planta_se_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_se,
    (SELECT planta_zh_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_zh,
    (SELECT planta_pl_plnt FROM properties_planta WHERE id_plnt = planta_prop) AS planta_prop_pl,
    properties_properties.vista360_prop,
    properties_properties.orientacion_prop,
    properties_properties.solarium_prop,
    properties_properties.m2_prop,
    properties_properties.m2_utiles_prop,
    properties_properties.m2_parcela_prop,
    CASE WHEN properties_properties.descripcion_xml_ca_prop != '' THEN properties_properties.descripcion_xml_ca_prop ELSE properties_properties.descripcion_ca_prop END AS descripcion_ca_prop,
    CASE WHEN properties_properties.descripcion_xml_da_prop != '' THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != '' THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_en_prop != '' THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != '' THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_fi_prop != '' THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS descripcion_fi_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != '' THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_is_prop != '' THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS descripcion_is_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != '' THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    CASE WHEN properties_properties.descripcion_xml_no_prop != '' THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS descripcion_no_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != '' THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    CASE WHEN properties_properties.descripcion_xml_se_prop != '' THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
    CASE WHEN properties_properties.descripcion_xml_zh_prop != '' THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS descripcion_zh_prop,
    CASE WHEN properties_properties.descripcion_xml_pl_prop != '' THEN properties_properties.descripcion_xml_pl_prop ELSE properties_properties.descripcion_pl_prop END AS descripcion_pl_prop,
    properties_properties.titulo_ca_prop,
    properties_properties.titulo_da_prop,
    properties_properties.titulo_de_prop,
    properties_properties.titulo_en_prop,
    properties_properties.titulo_es_prop,
    properties_properties.titulo_fi_prop,
    properties_properties.titulo_fr_prop,
    properties_properties.titulo_is_prop,
    properties_properties.titulo_nl_prop,
    properties_properties.titulo_no_prop,
    properties_properties.titulo_ru_prop,
    properties_properties.titulo_se_prop,
    properties_properties.titulo_zh_prop,
    properties_properties.titulo_pl_prop,
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
    distance_beach_prop,
    distance_beach_med_prop,
    distance_airport_prop,
    distance_airport_med_prop,
    distance_golf_prop,
    distance_golf_med_prop,
    distance_amenities_prop,
    distance_amenities_med_prop,
    m2_balcon_prop,
    garden_m2_prop,
    m2_solarium_prop,
    energia_prop,
    construccion_prop,
    lat_long_gp_prop,
    comision_agent_prop,
    suma_prop,
    gastos_prop,
    referencia_catrastal_prop,
    armarios_empotrados_prop,
    plazas_garaje_prop,
    precio_desde_prop,
    zoom_gp_prop,
    entraga_date_prop,
    direccion_agen_prop
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
WHERE 
    properties_properties.activado_prop = 1 AND 
    vendido_prop = 0 AND 
    vendido_tag_prop = 0 AND 
    reservado_prop = 0 AND 
    alquilado_prop = 0 AND 
    force_hide_prop != 1

".$tipo ."
".$tipox ."
".$prov ."
".$provx ."
".$town ."
".$townx ."
".$oper ."
".$operx ."
".$beds ."
".$baths ."
".$price ."
".$xml ."
".$kyero."
".$refs."

GROUP BY id_prop

".$limit ."

";
$rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error() .'<hr>'.$query_rsProperties);
$row_rsProperties = mysqli_fetch_assoc($rsProperties);
$totalRows_rsProperties = mysqli_num_rows($rsProperties);

// echo $totalRows_rsProperties."<hr>";
// echo $query_rsProperties."<hr>";

//var_dump($row_rsProperties);  die();

header('Content-type: text/xml; charset=UTF-8', true);
echo '<?xml version="1.0" encoding="UTF-8"?'.'>';

?>
<root>

<xml_mediaelx>
    <feed_version>1</feed_version>
</xml_mediaelx>
<?php if(!is_null($row_rsProperties)){ ?>
<?php do { ?>

<property>

    <id><?php echo $row_rsProperties['id_prop']; ?></id>

    <date><?php echo $row_rsProperties['updated_prop']; ?></date>

    <ref><?php echo $row_rsProperties['referencia_prop']; ?></ref>

    <price><?php echo $row_rsProperties['preci_reducidoo_prop']; ?></price>

    <price_old><?php if(isset($row_rsProperties['precio_prop'])) echo $row_rsProperties['precio_prop']; ?></price_old>

    <price_from><?php echo ($row_rsProperties['precio_desde_prop'] == '1')?1:0; ?></price_from>

    <comision><?php echo $row_rsProperties['comision_agent_prop']; ?></comision>

    <suma><?php echo $row_rsProperties['suma_prop']; ?></suma>

    <community><?php echo $row_rsProperties['gastos_prop']; ?></community>

    <catrastal_reference><?php echo $row_rsProperties['referencia_catrastal_prop']; ?></catrastal_reference>

    <price_m_1><?php echo $row_rsProperties['precio_1_prop']; ?></price_m_1>
    <price_m_2><?php echo $row_rsProperties['precio_2_prop']; ?></price_m_2>
    <price_m_3><?php echo $row_rsProperties['precio_3_prop']; ?></price_m_3>
    <price_m_4><?php echo $row_rsProperties['precio_4_prop']; ?></price_m_4>
    <price_m_5><?php echo $row_rsProperties['precio_5_prop']; ?></price_m_5>
    <price_m_6><?php echo $row_rsProperties['precio_6_prop']; ?></price_m_6>
    <price_m_7><?php echo $row_rsProperties['precio_7_prop']; ?></price_m_7>
    <price_m_8><?php echo $row_rsProperties['precio_8_prop']; ?></price_m_8>
    <price_m_9><?php echo $row_rsProperties['precio_9_prop']; ?></price_m_9>
    <price_m_10><?php echo $row_rsProperties['precio_10_prop']; ?></price_m_10>
    <price_m_11><?php echo $row_rsProperties['precio_11_prop']; ?></price_m_11>
    <price_m_12><?php echo $row_rsProperties['precio_12_prop']; ?></price_m_12>

    <prices_days>
    <?php
    
    $query_rsImages = "SELECT * FROM properties_prices WHERE property_prc = '".$row_rsProperties['id_prop']."' ORDER BY from_prc ";
    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
    $row_rsImages = mysqli_fetch_assoc($rsImages);
    $totalRows_rsImages = mysqli_num_rows($rsImages);
    $x = 1;
    do {
    ?>
    <?php if (isset($row_rsImages['from_prc']) && $row_rsImages['from_prc'] != '') { ?>
        <price_day id="<?php echo $x++ ?>">
             <from><?php echo $row_rsImages['from_prc'] ?></from>
             <to><?php echo $row_rsImages['to_prc'] ?></to>
             <price><?php echo $row_rsImages['price_prc'] ?></price>
        </price_day>
    <?php
        } ?>
    <?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
    </prices_days>

    <availabity>
    <?php
    
    $query_rsImages = "SELECT * FROM properties_disponibilidad WHERE property_disp = '".$row_rsProperties['id_prop']."' ORDER BY inicio_disp ";
    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
    $row_rsImages = mysqli_fetch_assoc($rsImages);
    $totalRows_rsImages = mysqli_num_rows($rsImages);
    $x = 1;
    do {
    ?>
    <?php if (isset($row_rsImages['inicio_disp']) && $row_rsImages['inicio_disp'] != '') { ?>
        <availabity_reg id="<?php echo $x++ ?>">
             <from><?php echo $row_rsImages['inicio_disp'] ?></from>
             <to><?php echo $row_rsImages['final_disp'] ?></to>
             <private><?php echo $row_rsImages['privado_disp'] ?></private>
        </availabity_reg>
    <?php
        } ?>
    <?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));  ?>
    </availabity>

    <currency>EUR</currency>

    <?php if ($row_rsProperties['slug_sta'] == 'new_build') { ?>
    <price_freq>sale</price_freq>
    <new_build>1</new_build>
    <?php } else { ?>
    <price_freq><?php echo $row_rsProperties['slug_sta'] ?></price_freq>
    <?php } ?>

    <type>
        <?php if(isset($row_rsProperties['partyp_ca']) && $row_rsProperties['partyp_ca'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['partyp_ca']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['partyp_da']) && $row_rsProperties['partyp_da'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['partyp_da']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['partyp_de']) && $row_rsProperties['partyp_de'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['partyp_de']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['partyp_en']) && $row_rsProperties['partyp_en'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['partyp_en']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['partyp_es']) && $row_rsProperties['partyp_es'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['partyp_es']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['partyp_fi']) && $row_rsProperties['partyp_fi'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['partyp_fi']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['partyp_fr']) && $row_rsProperties['partyp_fr'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['partyp_fr']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['partyp_is']) && $row_rsProperties['partyp_is'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['partyp_is']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['partyp_nl']) && $row_rsProperties['partyp_nl'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['partyp_nl']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['partyp_no']) && $row_rsProperties['partyp_no'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['partyp_no']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['partyp_ru']) && $row_rsProperties['partyp_ru'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['partyp_ru']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['partyp_se']) && $row_rsProperties['partyp_se'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['partyp_se']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['partyp_zh']) && $row_rsProperties['partyp_zh'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['partyp_zh']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['partyp_pl']) && $row_rsProperties['partyp_pl'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['partyp_pl']; ?> ]]></pl><?php } ?>
        <?php if(isset($row_rsProperties['partyp_cs']) && $row_rsProperties['partyp_cs'] != '') { ?><cs><![CDATA[ <?php echo $row_rsProperties['partyp_cs']; ?> ]]></cs><?php } ?>
    </type>

    <town><?php echo $row_rsProperties['partown']; ?></town>

    <province><?php echo $row_rsProperties['province']; ?></province>

    <costa><?php echo $row_rsProperties['costa']; ?></costa>

    <location_detail><?php echo preg_replace('/&/', '&amp;', $row_rsProperties['pararea']); ?></location_detail>

    <beds><?php echo $row_rsProperties['habitaciones_prop']; ?></beds>

    <baths><?php echo $row_rsProperties['aseos_prop']; ?></baths>

    <wc><?php echo $row_rsProperties['aseos2_prop']; ?></wc>

    <energy><?php echo $row_rsProperties['energia_prop']; ?></energy>

    <year_build><?php echo $row_rsProperties['construccion_prop']; ?></year_build>

    <pool>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_ca'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['piscina_prop_ca']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_da'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['piscina_prop_da']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_de'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['piscina_prop_de']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_en'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['piscina_prop_en']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_es'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['piscina_prop_es']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_fi'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['piscina_prop_fi']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_fr'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['piscina_prop_fr']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_is'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['piscina_prop_is']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_nl'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['piscina_prop_nl']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_no'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['piscina_prop_no']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_ru'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['piscina_prop_ru']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_se'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['piscina_prop_se']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_zh'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['piscina_prop_zh']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['piscina_prop_ca']) && $row_rsProperties['piscina_prop_pl'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['piscina_prop_pl']; ?> ]]></pl><?php } ?>
    </pool>

    <parking>
        <?php if(isset($row_rsProperties['parking_prop_ca']) && $row_rsProperties['parking_prop_ca'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['parking_prop_ca']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_da']) && $row_rsProperties['parking_prop_da'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['parking_prop_da']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_de']) && $row_rsProperties['parking_prop_de'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['parking_prop_de']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_en']) && $row_rsProperties['parking_prop_en'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['parking_prop_en']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_es']) && $row_rsProperties['parking_prop_es'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['parking_prop_es']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_fi']) && $row_rsProperties['parking_prop_fi'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['parking_prop_fi']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_fr']) && $row_rsProperties['parking_prop_fr'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['parking_prop_fr']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_is']) && $row_rsProperties['parking_prop_is'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['parking_prop_is']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_nl']) && $row_rsProperties['parking_prop_nl'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['parking_prop_nl']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_no']) && $row_rsProperties['parking_prop_no'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['parking_prop_no']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_ru']) && $row_rsProperties['parking_prop_ru'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['parking_prop_ru']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_se']) && $row_rsProperties['parking_prop_se'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['parking_prop_se']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_zh']) && $row_rsProperties['parking_prop_zh'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['parking_prop_zh']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['parking_prop_pl']) && $row_rsProperties['parking_prop_pl'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['parking_prop_pl']; ?> ]]></pl><?php } ?>
    </parking>

    <parking_places><?php echo $row_rsProperties['plazas_garaje_prop']; ?></parking_places>

    <wardrobes><?php echo $row_rsProperties['armarios_empotrados_prop']; ?></wardrobes>

    <kitchens>
        <?php if(isset($row_rsProperties['cocinas_prop_ca']) && $row_rsProperties['cocinas_prop_ca'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_ca']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_da']) && $row_rsProperties['cocinas_prop_da'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_da']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_de']) && $row_rsProperties['cocinas_prop_de'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_de']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_en']) && $row_rsProperties['cocinas_prop_en'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_en']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_es']) && $row_rsProperties['cocinas_prop_es'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_es']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_fi']) && $row_rsProperties['cocinas_prop_fi'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_fi']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_fr']) && $row_rsProperties['cocinas_prop_fr'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_fr']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_is']) && $row_rsProperties['cocinas_prop_is'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_is']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_nl']) && $row_rsProperties['cocinas_prop_nl'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_nl']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_no']) && $row_rsProperties['cocinas_prop_no'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_no']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_ru']) && $row_rsProperties['cocinas_prop_ru'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_ru']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_se']) && $row_rsProperties['cocinas_prop_se'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_se']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_zh']) && $row_rsProperties['cocinas_prop_zh'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_zh']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['cocinas_prop_pl']) && $row_rsProperties['cocinas_prop_pl'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['cocinas_prop_pl']; ?> ]]></pl><?php } ?>
    </kitchens>

    <condition>
        <?php if(isset($row_rsProperties['estado_prop_ca']) && $row_rsProperties['estado_prop_ca'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['estado_prop_ca']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_da']) && $row_rsProperties['estado_prop_da'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['estado_prop_da']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_de']) && $row_rsProperties['estado_prop_de'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['estado_prop_de']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_en']) && $row_rsProperties['estado_prop_en'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['estado_prop_en']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_es']) && $row_rsProperties['estado_prop_es'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['estado_prop_es']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_fi']) && $row_rsProperties['estado_prop_fi'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['estado_prop_fi']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_fr']) && $row_rsProperties['estado_prop_fr'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['estado_prop_fr']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_is']) && $row_rsProperties['estado_prop_is'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['estado_prop_is']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_nl']) && $row_rsProperties['estado_prop_nl'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['estado_prop_nl']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_no']) && $row_rsProperties['estado_prop_no'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['estado_prop_no']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_ru']) && $row_rsProperties['estado_prop_ru'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['estado_prop_ru']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_se']) && $row_rsProperties['estado_prop_se'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['estado_prop_se']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_zh']) && $row_rsProperties['estado_prop_zh'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['estado_prop_zh']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['estado_prop_pl']) && $row_rsProperties['estado_prop_pl'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['estado_prop_pl']; ?> ]]></pl><?php } ?>
    </condition>

    <floor>
        <?php if(isset($row_rsProperties['planta_prop_ca']) && $row_rsProperties['planta_prop_ca'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['planta_prop_ca']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_da']) && $row_rsProperties['planta_prop_da'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['planta_prop_da']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_de']) && $row_rsProperties['planta_prop_de'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['planta_prop_de']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_en']) && $row_rsProperties['planta_prop_en'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['planta_prop_en']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_es']) && $row_rsProperties['planta_prop_es'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['planta_prop_es']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_fi']) && $row_rsProperties['planta_prop_fi'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['planta_prop_fi']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_fr']) && $row_rsProperties['planta_prop_fr'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['planta_prop_fr']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_is']) && $row_rsProperties['planta_prop_is'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['planta_prop_is']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_nl']) && $row_rsProperties['planta_prop_nl'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['planta_prop_nl']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_no']) && $row_rsProperties['planta_prop_no'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['planta_prop_no']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_ru']) && $row_rsProperties['planta_prop_ru'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['planta_prop_ru']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_se']) && $row_rsProperties['planta_prop_se'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['planta_prop_se']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_zh']) && $row_rsProperties['planta_prop_zh'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['planta_prop_zh']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['planta_prop_pl']) && $row_rsProperties['planta_prop_pl'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['planta_prop_pl']; ?> ]]></pl><?php } ?>
    </floor>

    <v360><?php echo $row_rsProperties['vista360_prop']; ?></v360>

    <orientation><?php echo str_replace('o-', '', $row_rsProperties['orientacion_prop']); ?></orientation>

    <distance_beach><?php echo $row_rsProperties['distance_beach_prop']; ?></distance_beach>
    <distance_beach_med><?php echo $row_rsProperties['distance_beach_med_prop']; ?></distance_beach_med>

    <distance_airport><?php echo $row_rsProperties['distance_airport_prop']; ?></distance_airport>
    <distance_airport_med><?php echo $row_rsProperties['distance_airport_med_prop']; ?></distance_airport_med>

    <distance_golf><?php echo $row_rsProperties['distance_golf_prop']; ?></distance_golf>
    <distance_golf_med><?php echo $row_rsProperties['distance_golf_med_prop']; ?></distance_golf_med>

    <distance_amenities><?php echo $row_rsProperties['distance_amenities_prop']; ?></distance_amenities>
    <distance_amenities_med><?php echo $row_rsProperties['distance_amenities_med_prop']; ?></distance_amenities_med>

    <solarium><?php echo ($row_rsProperties['solarium_prop'] == '1')?1:0; ?></solarium>

    <?php $latlong = preg_split('/\,/', $row_rsProperties['lat_long_gp_prop']); ?>
    <?php if ($row_rsProperties['lat_long_gp_prop'] != '') { ?>
    <location>
            <latitude><?php echo trim($latlong[0]) ?></latitude>
            <longitude><?php echo trim($latlong[1]) ?></longitude>
            <address><?php echo trim($row_rsProperties['direccion_agen_prop']) ?></address>
            <zoom><?php echo trim($row_rsProperties['zoom_gp_prop']) ?></zoom>
    </location>
    <?php } ?>

    <surface_area>
        <?php if ($row_rsProperties['m2_prop'] > 0) { ?>
        <built><?php echo number_format((int)$row_rsProperties['m2_prop'], 0,'',''); ?></built>
        <?php } ?>
        <?php if ($row_rsProperties['m2_utiles_prop'] > 0) { ?>
        <usable><?php echo number_format((int)$row_rsProperties['m2_utiles_prop'], 0,'',''); ?></usable>
        <?php } ?>
        <?php if ($row_rsProperties['m2_parcela_prop'] > 0) { ?>
        <plot><?php echo number_format((int)$row_rsProperties['m2_parcela_prop'], 0,'',''); ?></plot>
        <?php } ?>
        <?php if ($row_rsProperties['m2_balcon_prop'] > 0) { ?>
        <terrace><?php echo number_format((int)$row_rsProperties['m2_balcon_prop'], 0,'',''); ?></terrace>
        <?php } ?>
        <?php if ($row_rsProperties['garden_m2_prop'] > 0) { ?>
        <garden><?php echo number_format((int)$row_rsProperties['garden_m2_prop'], 0,'',''); ?></garden>
        <?php } ?>
        <?php if ($row_rsProperties['m2_solarium_prop'] > 0) { ?>
        <solarium><?php echo number_format((int)$row_rsProperties['m2_solarium_prop'], 0,'',''); ?></solarium>
        <?php } ?>
    </surface_area>


    <url>
        <en>https://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo propURL($row_rsProperties['id_prop'], 'en') ?></en>
    </url>

    <title>
        <?php if(isset($row_rsProperties['titulo_ca_prop']) && $row_rsProperties['titulo_ca_prop'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['titulo_ca_prop']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['titulo_da_prop']) && $row_rsProperties['titulo_da_prop'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['titulo_da_prop']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['titulo_de_prop']) && $row_rsProperties['titulo_de_prop'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['titulo_de_prop']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['titulo_en_prop']) && $row_rsProperties['titulo_en_prop'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['titulo_en_prop']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['titulo_es_prop']) && $row_rsProperties['titulo_es_prop'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['titulo_es_prop']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['titulo_fi_prop']) && $row_rsProperties['titulo_fi_prop'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['titulo_fi_prop']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['titulo_fr_prop']) && $row_rsProperties['titulo_fr_prop'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['titulo_fr_prop']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['titulo_is_prop']) && $row_rsProperties['titulo_is_prop'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['titulo_is_prop']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['titulo_nl_prop']) && $row_rsProperties['titulo_nl_prop'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['titulo_nl_prop']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['titulo_no_prop']) && $row_rsProperties['titulo_no_prop'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['titulo_no_prop']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['titulo_ru_prop']) && $row_rsProperties['titulo_ru_prop'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['titulo_ru_prop']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['titulo_se_prop']) && $row_rsProperties['titulo_se_prop'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['titulo_se_prop']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['titulo_zh_prop']) && $row_rsProperties['titulo_zh_prop'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['titulo_zh_prop']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['titulo_pl_prop']) && $row_rsProperties['titulo_pl_prop'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['titulo_pl_prop']; ?> ]]></pl><?php } ?>
    </title>

    <desc>
        <?php if(isset($row_rsProperties['descripcion_ca_prop']) && $row_rsProperties['descripcion_ca_prop'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProperties['descripcion_ca_prop']; ?> ]]></ca><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_da_prop']) && $row_rsProperties['descripcion_da_prop'] != '') { ?><da><![CDATA[ <?php echo $row_rsProperties['descripcion_da_prop']; ?> ]]></da><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_de_prop']) && $row_rsProperties['descripcion_de_prop'] != '') { ?><de><![CDATA[ <?php echo $row_rsProperties['descripcion_de_prop']; ?> ]]></de><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_en_prop']) && $row_rsProperties['descripcion_en_prop'] != '') { ?><en><![CDATA[ <?php echo $row_rsProperties['descripcion_en_prop']; ?> ]]></en><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_es_prop']) && $row_rsProperties['descripcion_es_prop'] != '') { ?><es><![CDATA[ <?php echo $row_rsProperties['descripcion_es_prop']; ?> ]]></es><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_fi_prop']) && $row_rsProperties['descripcion_fi_prop'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProperties['descripcion_fi_prop']; ?> ]]></fi><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_fr_prop']) && $row_rsProperties['descripcion_fr_prop'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProperties['descripcion_fr_prop']; ?> ]]></fr><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_is_prop']) && $row_rsProperties['descripcion_is_prop'] != '') { ?><is><![CDATA[ <?php echo $row_rsProperties['descripcion_is_prop']; ?> ]]></is><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_nl_prop']) && $row_rsProperties['descripcion_nl_prop'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProperties['descripcion_nl_prop']; ?> ]]></nl><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_no_prop']) && $row_rsProperties['descripcion_no_prop'] != '') { ?><no><![CDATA[ <?php echo $row_rsProperties['descripcion_no_prop']; ?> ]]></no><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_ru_prop']) && $row_rsProperties['descripcion_ru_prop'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProperties['descripcion_ru_prop']; ?> ]]></ru><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_se_prop']) && $row_rsProperties['descripcion_se_prop'] != '') { ?><se><![CDATA[ <?php echo $row_rsProperties['descripcion_se_prop']; ?> ]]></se><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_zh_prop']) && $row_rsProperties['descripcion_zh_prop'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProperties['descripcion_zh_prop']; ?> ]]></zh><?php } ?>
        <?php if(isset($row_rsProperties['descripcion_pl_prop']) && $row_rsProperties['descripcion_pl_prop'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProperties['descripcion_pl_prop']; ?> ]]></pl><?php } ?>
    </desc>

    <?php
    
    $query_rsProps_features = "
    SELECT
        features.feature_ca_feat,
        features.feature_da_feat,
        features.feature_de_feat,
        features.feature_en_feat,
        features.feature_es_feat,
        features.feature_fi_feat,
        features.feature_is_feat,
        features.feature_fr_feat,
        features.feature_nl_feat,
        features.feature_no_feat,
        features.feature_ru_feat,
        features.feature_se_feat,
        features.feature_zh_feat,
        features.feature_pl_feat
    FROM properties_property_feature
        LEFT OUTER JOIN properties_features features ON properties_property_feature.feature = features.id_feat
        LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
    WHERE properties_property_feature.property = '".$row_rsProperties['id_prop']."'

    UNION

    SELECT
        features.feature_ca_feat,
        features.feature_da_feat,
        features.feature_de_feat,
        features.feature_en_feat,
        features.feature_es_feat,
        features.feature_fi_feat,
        features.feature_is_feat,
        features.feature_fr_feat,
        features.feature_nl_feat,
        features.feature_no_feat,
        features.feature_ru_feat,
        features.feature_se_feat,
        features.feature_zh_feat,
        features.feature_pl_feat
    FROM properties_property_feature_priv
        LEFT OUTER JOIN properties_features_priv features ON properties_property_feature_priv.feature = features.id_feat
        LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
    WHERE properties_property_feature_priv.property = '".$row_rsProperties['id_prop']."'
    ";
    $rsProps_features = mysqli_query($inmoconn,$query_rsProps_features) or die(mysqli_error());
    $row_rsProps_features = mysqli_fetch_assoc($rsProps_features);
    $totalRows_rsProps_features = mysqli_num_rows($rsProps_features);

    if($totalRows_rsProps_features > 0) {
    echo "<features>";
    do {
     ?>
        <feature>
            <?php if(isset($row_rsProps_features['feature_ca_feat']) && $row_rsProps_features['feature_ca_feat'] != '') { ?><ca><![CDATA[ <?php echo $row_rsProps_features['feature_ca_feat']; ?> ]]></ca><?php } ?>
            <?php if(isset($row_rsProps_features['feature_da_feat']) && $row_rsProps_features['feature_da_feat'] != '') { ?><da><![CDATA[ <?php echo $row_rsProps_features['feature_da_feat']; ?> ]]></da><?php } ?>
            <?php if(isset($row_rsProps_features['feature_de_feat']) && $row_rsProps_features['feature_de_feat'] != '') { ?><de><![CDATA[ <?php echo $row_rsProps_features['feature_de_feat']; ?> ]]></de><?php } ?>
            <?php if(isset($row_rsProps_features['feature_en_feat']) && $row_rsProps_features['feature_en_feat'] != '') { ?><en><![CDATA[ <?php echo $row_rsProps_features['feature_en_feat']; ?> ]]></en><?php } ?>
            <?php if(isset($row_rsProps_features['feature_es_feat']) && $row_rsProps_features['feature_es_feat'] != '') { ?><es><![CDATA[ <?php echo $row_rsProps_features['feature_es_feat']; ?> ]]></es><?php } ?>
            <?php if(isset($row_rsProps_features['feature_fi_feat']) && $row_rsProps_features['feature_fi_feat'] != '') { ?><fi><![CDATA[ <?php echo $row_rsProps_features['feature_fi_feat']; ?> ]]></fi><?php } ?>
            <?php if(isset($row_rsProps_features['feature_is_feat']) && $row_rsProps_features['feature_is_feat'] != '') { ?><fr><![CDATA[ <?php echo $row_rsProps_features['feature_is_feat']; ?> ]]></fr><?php } ?>
            <?php if(isset($row_rsProps_features['feature_fr_feat']) && $row_rsProps_features['feature_fr_feat'] != '') { ?><is><![CDATA[ <?php echo $row_rsProps_features['feature_fr_feat']; ?> ]]></is><?php } ?>
            <?php if(isset($row_rsProps_features['feature_nl_feat']) && $row_rsProps_features['feature_nl_feat'] != '') { ?><nl><![CDATA[ <?php echo $row_rsProps_features['feature_nl_feat']; ?> ]]></nl><?php } ?>
            <?php if(isset($row_rsProps_features['feature_no_feat']) && $row_rsProps_features['feature_no_feat'] != '') { ?><no><![CDATA[ <?php echo $row_rsProps_features['feature_no_feat']; ?> ]]></no><?php } ?>
            <?php if(isset($row_rsProps_features['feature_ru_feat']) && $row_rsProps_features['feature_ru_feat'] != '') { ?><ru><![CDATA[ <?php echo $row_rsProps_features['feature_ru_feat']; ?> ]]></ru><?php } ?>
            <?php if(isset($row_rsProps_features['feature_se_feat']) && $row_rsProps_features['feature_se_feat'] != '') { ?><se><![CDATA[ <?php echo $row_rsProps_features['feature_se_feat']; ?> ]]></se><?php } ?>
            <?php if(isset($row_rsProps_features['feature_zh_feat']) && $row_rsProps_features['feature_zh_feat'] != '') { ?><zh><![CDATA[ <?php echo $row_rsProps_features['feature_zh_feat']; ?> ]]></zh><?php } ?>
            <?php if(isset($row_rsProps_features['feature_pl_feat']) && $row_rsProps_features['feature_pl_feat'] != '') { ?><pl><![CDATA[ <?php echo $row_rsProps_features['feature_pl_feat']; ?> ]]></pl><?php } ?>
        </feature>
    <?php } while ($row_rsProps_features = mysqli_fetch_assoc($rsProps_features));
    mysqli_free_result($rsProps_features); ?>
    <?php
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
    <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/".$row_rsImages['id_img']."_lg.jpg")) {
            ?>
        <image id="<?php echo $x++ ?>">
            <?php if ($row_rsXML['watermark_exp'] == 1): ?>
                    <url>https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/thumbnails/<?php echo $row_rsImages['id_img']; ?>_xl.jpg</url>
            <?php else: ?>
                <?php if(preg_match('/https?:\/\//', $row_rsImages['image_img'])) { ?>
                    <url><?php echo $row_rsImages['image_img']; ?></url>
                <?php } else { ?>
                    <url>https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/properties/<?php echo $row_rsImages['image_img']; ?></url>
                <?php } ?>
            <?php endif ?>
        </image>
    <?php
        } ?>
    <?php } while ($row_rsImages  = mysqli_fetch_assoc($rsImages ));
    mysqli_free_result($rsImages);  ?>
    </images>

    <plans>
    <?php
    
    $query_rsImages = "SELECT id_img, image_img FROM properties_planos WHERE property_img = '".$row_rsProperties['id_prop']."' ORDER BY order_img LIMIT 0, 50";
    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
    $row_rsImages = mysqli_fetch_assoc($rsImages);
    $totalRows_rsImages = mysqli_num_rows($rsImages);
    $x = 1;
    do {
        if (isset($row_rsImages['image_img']) && $row_rsImages['image_img'] != '') {
            # code...
    ?>
        <plan id="<?php echo $x++ ?>">
                <?php if(preg_match('/https?:\/\//', $row_rsImages['image_img'])) { ?>
                    <url><?php echo $row_rsImages['image_img']; ?></url>
                <?php } else { ?>
                    <url>https://<?php echo $_SERVER['HTTP_HOST']; ?>/media/images/propertiesplanos/<?php echo $row_rsImages['image_img']; ?></url>
                <?php } ?>
        </plan>
    <?php } } while ($row_rsImages  = mysqli_fetch_assoc($rsImages));
    mysqli_free_result($rsImages);
      ?>

    </plans>

    <videos>
    <?php
    
    $query_rsVideos = "SELECT video_vid, id_vid FROM  properties_videos WHERE  property_vid = '".$row_rsProperties['id_prop']."' ORDER BY order_vid ASC ";
    $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
    $row_rsVideos = mysqli_fetch_assoc($rsVideos);
    $totalRows_rsVideos = mysqli_num_rows($rsVideos);
    if($totalRows_rsVideos >0) {
    do {
        if ($row_rsVideos['video_vid'] != '') {
            preg_match_all('/<iframe[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $row_rsVideos['video_vid'], $result);
            $video = explode('&', $result['src'][0]);
    ?>
            <video_url><![CDATA[<?php echo (string)$video[0] ?>]]></video_url>
    <?php
        }
    } while ($row_rsVideos = mysqli_fetch_assoc($rsVideos));
    mysqli_free_result($rsVideos);
    }
    ?>
    </videos>

    <views360>
    <?php
    
    $query_rsVideos = "SELECT video_360, id_360 FROM  properties_360 WHERE  property_360 = '".$row_rsProperties['id_prop']."' ORDER BY order_360 ASC ";
    $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
    $row_rsVideos = mysqli_fetch_assoc($rsVideos);
    $totalRows_rsVideos = mysqli_num_rows($rsVideos);
    if($totalRows_rsVideos >0) {
    do {
        if ($row_rsVideos['video_360'] != '')
        {
            preg_match_all('/<iframe[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $row_rsVideos['video_360'], $result);
            $video = explode('&', $result['src'][0]);
        ?>
            <virtual_tour_url><![CDATA[<?php echo (string)$video[0] ?>]]></virtual_tour_url>
        <?php
        }
    } while ($row_rsVideos = mysqli_fetch_assoc($rsVideos));
    mysqli_free_result($rsVideos);
    }
    ?>
    </views360>

    <tags>
    <?php
    
    $query_rsTags = "
    SELECT
    properties_tags.tag_da_tag,
    properties_tags.tag_de_tag,
    properties_tags.tag_en_tag,
    properties_tags.tag_es_tag,
    properties_tags.tag_fi_tag,
    properties_tags.tag_fr_tag,
    properties_tags.tag_is_tag,
    properties_tags.tag_nl_tag,
    properties_tags.tag_no_tag,
    properties_tags.tag_ru_tag,
    properties_tags.tag_se_tag,
    properties_tags.tag_zh_tag,
    properties_tags.tag_pl_tag,
    properties_tags.id_tag,
    properties_tags.color_tag,
    properties_tags.text_color_tag
    FROM
    properties_property_tag
    JOIN properties_tags
    ON properties_property_tag.tag = properties_tags.id_tag
    WHERE
    properties_property_tag.property = '" . $row_rsProperties['id_prop'] . "'
    ";
    $rsTags = mysqli_query($inmoconn,$query_rsTags) or die(mysqli_error());
    $row_rsTags = mysqli_fetch_assoc($rsTags);
    $totalRows_rsTags = mysqli_num_rows($rsTags);
    if($totalRows_rsTags >0) {
    do {
    ?>
        <tag>
            <?php if(isset($row_rsTags['tag_da_tag']) && $row_rsTags['tag_da_tag'] != '') { ?><da><![CDATA[ <?php echo $row_rsTags['tag_da_tag']; ?> ]]></da><?php } ?>
            <?php if(isset($row_rsTags['tag_de_tag']) && $row_rsTags['tag_de_tag'] != '') { ?><de><![CDATA[ <?php echo $row_rsTags['tag_de_tag']; ?> ]]></de><?php } ?>
            <?php if(isset($row_rsTags['tag_en_tag']) && $row_rsTags['tag_en_tag'] != '') { ?><en><![CDATA[ <?php echo $row_rsTags['tag_en_tag']; ?> ]]></en><?php } ?>
            <?php if(isset($row_rsTags['tag_es_tag']) && $row_rsTags['tag_es_tag'] != '') { ?><es><![CDATA[ <?php echo $row_rsTags['tag_es_tag']; ?> ]]></es><?php } ?>
            <?php if(isset($row_rsTags['tag_fi_tag']) && $row_rsTags['tag_fi_tag'] != '') { ?><fi><![CDATA[ <?php echo $row_rsTags['tag_fi_tag']; ?> ]]></fi><?php } ?>
            <?php if(isset($row_rsTags['tag_fr_tag']) && $row_rsTags['tag_fr_tag'] != '') { ?><fr><![CDATA[ <?php echo $row_rsTags['tag_fr_tag']; ?> ]]></fr><?php } ?>
            <?php if(isset($row_rsTags['tag_is_tag']) && $row_rsTags['tag_is_tag'] != '') { ?><is><![CDATA[ <?php echo $row_rsTags['tag_is_tag']; ?> ]]></is><?php } ?>
            <?php if(isset($row_rsTags['tag_nl_tag']) && $row_rsTags['tag_nl_tag'] != '') { ?><nl><![CDATA[ <?php echo $row_rsTags['tag_nl_tag']; ?> ]]></nl><?php } ?>
            <?php if(isset($row_rsTags['tag_no_tag']) && $row_rsTags['tag_no_tag'] != '') { ?><no><![CDATA[ <?php echo $row_rsTags['tag_no_tag']; ?> ]]></no><?php } ?>
            <?php if(isset($row_rsTags['tag_ru_tag']) && $row_rsTags['tag_ru_tag'] != '') { ?><ru><![CDATA[ <?php echo $row_rsTags['tag_ru_tag']; ?> ]]></ru><?php } ?>
            <?php if(isset($row_rsTags['tag_se_tag']) && $row_rsTags['tag_se_tag'] != '') { ?><se><![CDATA[ <?php echo $row_rsTags['tag_se_tag']; ?> ]]></se><?php } ?>
            <?php if(isset($row_rsTags['tag_zh_tag']) && $row_rsTags['tag_zh_tag'] != '') { ?><zh><![CDATA[ <?php echo $row_rsTags['tag_zh_tag']; ?> ]]></zh><?php } ?>
            <?php if(isset($row_rsTags['tag_pl_tag']) && $row_rsTags['tag_pl_tag'] != '') { ?><pl><![CDATA[ <?php echo $row_rsTags['tag_pl_tag']; ?> ]]></pl><?php } ?>
        </tag>
    <?php
    } while ($row_rsTags = mysqli_fetch_assoc($rsTags));
    mysqli_free_result($rsTags);
    }
    ?>
    </tags>

</property>
<?php flush(); ?>
<?php } while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));  ?>
<?php } ?>
</root>

<?php
mysqli_free_result($rsProperties);
?>
