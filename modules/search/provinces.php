<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

$_GET['lang'] = sanitizeInput($_GET['lang']);
$_GET['locun'] = sanitizeInput($_GET['locun']);

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$_GET['lang'].'.php');

$ar = '';
if( isset($_GET['locun']) && $_GET['locun'] != '' && $_GET['locun'] != 'null' ){
    $ar = " AND CASE WHEN properties_loc2.loc1_loc2 IS NOT NULL THEN properties_loc2.loc1_loc2 ELSE province1.loc1_loc2  END IN (" . simpleSanitize((ltrim($_GET['locun'])), ',') . ")";
}

$location = getRecords("

SELECT DISTINCT

    CASE WHEN properties_loc2.name_".$_GET['lang']."_loc2 IS NOT NULL THEN properties_loc2.name_".$_GET['lang']."_loc2 ELSE province1.name_".$_GET['lang']."_loc2  END AS province,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id


FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0  AND force_hide_prop != 1 $ar

GROUP BY id

ORDER BY province ASC

");



echo "<option value=\"\">".$langStr["Todos"]."</option>";
foreach ($location as $key => $value) {
	echo ("<option value=\"".$value['id']."\">".$value['province']."</option>");
}

 ?>
