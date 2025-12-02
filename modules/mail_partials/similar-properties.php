<?php
 require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

 require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

 require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

 require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

 global $propId;

 include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");
 $precio = $property[0]['precio'] ;
 $precio_limite_inferior = $precio-($precio*0.2);
 $precio_limite_superior = $precio+($precio*0.2);

$query = "

SELECT

    properties_loc1.name_".$langVal."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$langVal."_loc2 IS NOT NULL THEN properties_loc2.name_".$langVal."_loc2 ELSE province1.name_".$langVal."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$langVal."_loc3 IS NOT NULL THEN properties_loc3.name_".$langVal."_loc3 ELSE areas1.name_".$langVal."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$langVal."_loc4 IS NOT NULL THEN properties_loc4.name_".$langVal."_loc4 ELSE towns.name_".$langVal."_loc4  END AS town,
    CASE WHEN properties_types.types_".$langVal."_typ IS NOT NULL THEN properties_types.types_".$langVal."_typ ELSE types.types_".$langVal."_typ END AS type,
    properties_status.status_".$langVal."_sta as sale,
    properties_properties.descripcion_".$langVal."_prop  as descr,
    properties_properties.m2_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_parcela_prop as m2p_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$langVal."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$langVal."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.aseos2_prop,
    properties_properties.precio_desde_prop,
    title_".$langVal."_prop as metatitle

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types AS types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1 LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1

AND id_prop != '".simpleSanitize(($property[0]['id_prop']))."'

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT 4

";

$similarPropQuery = ($query);

$precioQuery = "AND preci_reducidoo_prop >= '".simpleSanitize(($precio_limite_inferior))."' AND preci_reducidoo_prop <= '".simpleSanitize(($precio_limite_superior))."'";
$tipoQuery = "AND CASE WHEN properties_types.types_".$langVal."_typ IS NOT NULL THEN properties_types.types_".$langVal."_typ ELSE types.types_".$langVal."_typ END = '".str_replace('\'', '', $property[0]['type'])."'";
$ciudadQuery = "AND CASE WHEN properties_loc3.name_".$langVal."_loc3 IS NOT NULL THEN properties_loc3.name_".$langVal."_loc3 ELSE areas1.name_".$langVal."_loc3  END = '".str_replace('\'', '', $property[0]['area'])."'";
$areaQuery = "AND CASE WHEN properties_loc4.name_".$langVal."_loc4 IS NOT NULL THEN properties_loc4.name_".$langVal."_loc4 ELSE towns.name_".$langVal."_loc4  END = '".str_replace('\'', '', $property[0]['town'])."'";

$similarProp = getRecords(sprintf($similarPropQuery, " " . $tipoQuery . " " . $ciudadQuery . " " . $precioQuery . " " . $areaQuery . ""));

if (isset($similarProp[2]['id_prop']) && $similarProp[2]['id_prop'] == '') {
    $similarProp = getRecords(sprintf($similarPropQuery, " " . $tipoQuery . " " . $ciudadQuery . " " . $precioQuery . " "));
}

if (isset($similarProp[2]['id_prop']) && $similarProp[2]['id_prop'] == '') {
    $similarProp = getRecords(sprintf($similarPropQuery, " " . $ciudadQuery . " " . $precioQuery . " "));
}

if (isset($similarProp[2]['id_prop']) && $similarProp[2]['id_prop'] == '') {
    $similarProp = getRecords(sprintf($similarPropQuery, " " . $precioQuery . " "));
}

//var_dump($similarProp); die;

$idVal = '';

$similaresContent = '<tr>';
    $similaresContent .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
        $similaresContent .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
            $similaresContent .= '<h1 style="color: #222; font-size: 24px;">';
                $similaresContent .= '🔎 ' . $langStr["También te pueden interesar"] . '';
            $similaresContent .= '</h1>';
            $similaresContent .= '<div style="color: #555; font-size: 16px;">';
                $similaresContent .= $langStr["Mientras tanto, por favor eche un vistazo a esta selección de propiedades similares, esto puede ser de su interés"] . ':';
            $similaresContent .= '</div>';
        $similaresContent .= '</div>';
    $similaresContent .= '</td>';
$similaresContent .= '</tr>';

$similaresContent .= '<tr>';

$similaresContent .= '<td style="padding: 0 30px 20px 30px;">';

$similaresContent .= '<table width="100%" cellpadding="0" cellspacing="0">';

$similaresContent .= '<tr>';

$x = 1;
 foreach ($similarProp as $value) {
    if ($value["id_prop"] != '') {
        $langVal = $langVal;
        $idVal = $value["id_prop"];
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . '/modules/mail_partials/property_rate_mini.php');
        $similaresContent .= ob_get_contents();
        ob_end_clean();

        if ($x%2 == 0) {
            $similaresContent .= '</tr>';
            $similaresContent .= '<tr>';
        }

        $x++;
    }
 }

$similaresContent .= '</tr>';

$similaresContent .= '</table>';

$similaresContent .= '</td>';

$similaresContent .= '</tr>';