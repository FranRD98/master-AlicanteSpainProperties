<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$lang.".php");

// Cargamos las urls
include_once($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");
// error_reporting(E_ALL);
// ini_set("display_errors", 1);


function decryptIt($encryption, $key = "DLusjkq6kkzRUbY7TVc7YH2RcT2") {
    global $_SERVER;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $decryption_key = $_SERVER['HTTP_HOST'];
    $decryption_iv = $_SERVER['HTTP_HOST'];

    $decryption=openssl_decrypt ($encryption, $ciphering,
        $decryption_key, $options, $decryption_iv);

    return $decryption;
}

$id = decryptIt($_GET['id_cli']);
$smarty->assign("idClientRate", $id);
$props = $_GET['id_props'];

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
    properties_properties.m2_balcon_prop as m2_balcon_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.aseos2_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.precio_desde_prop,
    title_".$lang."_prop as metatitle,
    (SELECT count(*) FROM properties_images WHERE properties_properties.id_prop = properties_images.property_img) as total_images
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


WHERE  id_prop IN (" . $props . ")


GROUP BY id_prop

");

$smarty->assign("properties", $properties);

?>
