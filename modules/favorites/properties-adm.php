<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

//session_start();

SmartyPaginate::connect();

SmartyPaginate::setLimit(9999);

SmartyPaginate::setPageLimit(10);

SmartyPaginate::setUrl(preg_replace('/\&?\??p=[0-9]*/', '', $_SERVER['REQUEST_URI']));

SmartyPaginate::setUrlVar('p');

@SmartyPaginate::setPrevText('&#8249;');
@SmartyPaginate::setNextText('&#8250;');
@SmartyPaginate::setFirstText('&laquo;');
@SmartyPaginate::setLastText('&raquo;');

$cp = SmartyPaginate::getCurrentIndex();
$tp = SmartyPaginate::getLimit();

if (!isset($_GET['p'])) {
    SmartyPaginate::setCurrentItem(1);
}

$favs = 'AND id_prop = 0';
if( isset($_COOKIE['favadm']) && $_COOKIE['favadm'] != '' ){
    $favs = "AND id_prop IN (".$_COOKIE['favadm'].")";
}

 // echo "<pre>";
 // print_r($_COOKIE);
 // echo "</pre>";

$properties = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    properties_properties.descripcion_".$lang."_prop  as descr,
    properties_status.status_".$lang."_sta as sale,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    nombre_pro,
    apellidos_pro,
    telefono_fijo_pro,
    telefono_movil_pro,
    workers_pro,
    direccion_pro,
    llaves_prop,
    alcayata_prop,
    llave_txt_prop,
    keyholder_prop,
    keyholder_name_prop,
    keyholder_tel_prop,
    alarm_prop,
    alarm_code_prop,
    direccion_pro

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
    LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro

WHERE 1 = 1

$favs

GROUP BY id_prop

LIMIT $cp, $tp

");

$smarty->assign("properties", $properties);


$_query = "SELECT id_prop

FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
    INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

     WHERE activado_prop = 1 $favs

     GROUP BY id_prop";
$_result = mysqli_query($inmoconn, $_query);
$_row = mysqli_fetch_array($_result, MYSQLI_ASSOC);
$totalRows = mysqli_num_rows($_result);

SmartyPaginate::setTotal($totalRows);

mysqli_free_result($_result);

$smarty->assign("totalprops", $totalRows);

SmartyPaginate::assign($smarty);


 ?>