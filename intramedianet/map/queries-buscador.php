<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get recordset
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getRecords($sql){

    global $database_inmoconn, $inmoconn, $_GET;

    $query_rsSelect = $sql;
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
        $rsSelect = mysqli_query($inmoconn, $query_rsSelect) or die(mysqli_error() . '<hr>' . $query_rsSelect);
    } else {
        $rsSelect = mysqli_query($inmoconn, $query_rsSelect) or die(mysqli_error());
    }
    $row_rsSelect = mysqli_fetch_assoc($rsSelect);
    $totalRows_rsSelect = mysqli_num_rows($rsSelect);

    $ret = array();
    do {
        array_push($ret, $row_rsSelect);
    } while ($row_rsSelect = mysqli_fetch_assoc($rsSelect));

    mysqli_free_result($rsSelect);

    return $ret;

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get recordset and cache
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getRecordsAndCache($sql, $name){

    global $lang_adm;

    $fileCache = 'modules/_cache/' . $name . '-'.$lang_adm.'.json';

    if (!file_exists($_SERVER["DOCUMENT_ROOT"] . '/' . $fileCache)) {
        $file = getRecords($sql);
        $fp = fopen($_SERVER["DOCUMENT_ROOT"] . '/' . $fileCache , "w");
        fwrite($fp, json_encode($file));
        fclose($fp);
    }

    $json = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $fileCache);

    return json_decode($json, true);

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Scape string
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function escape($params,$conexion){
    if(!is_null($params))
        return mysqli_escape_string($conexion,$params);
    else
        return '';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Queries
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$countryQuery = "
    SELECT DISTINCT
        properties_loc1.name_".$lang_adm."_loc1 AS country,
        properties_loc1.id_loc1 AS id
    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        INNER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        INNER JOIN properties_loc1 ON province1.loc1_loc2 = province1.id_loc2
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY properties_loc1.name_".$lang_adm."_loc1
    ORDER BY country ASC
";

$country = getRecordsAndCache($countryQuery, 'countries-search');

$provinceQuery = "
    SELECT DISTINCT
        CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS province,
        CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY province ASC
";

$province = getRecordsAndCache($provinceQuery, 'province-search');

$cityQuery = "
    SELECT DISTINCT
        CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS area,
        CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY area ASC
";

$city = getRecordsAndCache($cityQuery, 'city-search');

$localizacionQuery = "
    SELECT DISTINCT
        CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS town,
        CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY town ASC
";

$localizacion = getRecordsAndCache($localizacionQuery, 'localizacion-search');

$typeQuery = "
    SELECT
        CASE WHEN properties_types.types_".$lang_adm."_typ IS NOT NULL THEN properties_types.types_".$lang_adm."_typ ELSE types.types_".$lang_adm."_typ END AS type,
        CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS id_type
    FROM  properties_properties
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id_type
    ORDER BY type
";

$type = getRecordsAndCache($typeQuery, 'type-search');

$statusQuery = "
    SELECT
        properties_status.status_".$lang_adm."_sta as sale,
        properties_status.id_sta as id,
        CASE WHEN properties_properties.activado_prop = 1  AND properties_properties.alquilado_prop = 0 AND properties_properties.vendido_prop = 0
        THEN 1
        ELSE 0
        END as visible
    FROM  properties_status
    LEFT JOIN properties_properties ON properties_properties.operacion_prop = properties_status.id_sta
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id_sta
    ORDER BY sale
";

$status = getRecordsAndCache($statusQuery, 'status-search');
