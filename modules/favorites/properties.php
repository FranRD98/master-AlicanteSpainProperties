<?php
SmartyPaginate::connect();

SmartyPaginate::setLimit(12);

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

if ($isLevel1 == true) {

    $propertiesFav = getRecords("

        SELECT * FROM users_favorites WHERE user= '".stripslashes(mysqli_real_escape_string($inmoconn, $_SESSION['kt_login_id']))."' GROUP BY user, property ORDER BY id

    ");

    $prpos = array();
    if (isset($propertiesFav[0])) {
        foreach ($propertiesFav as $key => $value) {
            array_push($prpos, $value['property']);
        }
    }
    $favs = "AND id_prop IN (".implode(",", $prpos).")";

} else {

    if( isset($_COOKIE['fav']) && $_COOKIE['fav'] != '' ){
        $favs = "AND id_prop IN (".$_COOKIE['fav'].")";
    }

}



if (preg_match('/IN \(\)/', $favs)) {
    $favs = 'AND id_prop = 0';
}

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
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.precio_desde_prop,
    properties_properties.watermark_prop


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

WHERE activado_prop = 1

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

$_result = $inmoconn->query($_query);
if ($_result === false) {
    die("Error en la consulta: " . $inmoconn->error);
}
$_row = $_result->fetch_assoc();
$totalRows = $_result->num_rows;

SmartyPaginate::setTotal($totalRows);

$_result->free();

$smarty->assign("totalprops", $totalRows);

SmartyPaginate::assign($smarty);


 ?>