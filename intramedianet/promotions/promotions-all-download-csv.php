<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

// Función de error
function fatal_error($sErrorMessage = '')
{
    header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error');
    die($sErrorMessage);
}

// Conexión MySQL
$gaSql['user']       = $username_inmoconn;
$gaSql['password']   = $password_inmoconn;
$gaSql['db']         = $database_inmoconn;
$gaSql['server']     = $hostname_inmoconn;

if (!$gaSql['link'] = mysqli_connect($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'])) {
    fatal_error('Could not open connection to server');
}

mysqli_query($gaSql['link'], "SET NAMES 'utf8'");

// Consulta de promociones
$sQuery = "
SELECT
    n.id_nws AS ID_Promocion,
    n.title_" . $lang_adm . "_nws AS Titulo,
    CASE WHEN n.activate_nws = 1 THEN '". __('Si', true) ."' ELSE '". __('No', true) ."' END AS Activado,
    COUNT(p.id_prop) AS Numero_Casas,
    GROUP_CONCAT(DISTINCT CASE WHEN pt.types_" . $lang_adm . "_typ IS NOT NULL THEN pt.types_" . $lang_adm . "_typ ELSE t.types_" . $lang_adm . "_typ END SEPARATOR ', ') AS Tipos_Propiedad,
    GROUP_CONCAT(DISTINCT p.habitaciones_prop SEPARATOR ', ') AS Habitaciones,
    GROUP_CONCAT(DISTINCT CASE WHEN l2.name_" . $lang_adm . "_loc2 IS NOT NULL THEN l2.name_" . $lang_adm . "_loc2 ELSE province1.name_" . $lang_adm . "_loc2 END SEPARATOR ', ') AS Provincias,
    GROUP_CONCAT(DISTINCT CASE WHEN l3.name_" . $lang_adm . "_loc3 IS NOT NULL THEN l3.name_" . $lang_adm . "_loc3 ELSE areas1.name_" . $lang_adm . "_loc3 END SEPARATOR ', ') AS Ciudades
FROM news n
LEFT JOIN properties_properties p ON p.promocion_prop = n.id_nws
LEFT JOIN properties_types t ON p.tipo_prop = t.id_typ
LEFT JOIN properties_types pt ON t.parent_typ = pt.id_typ
LEFT JOIN properties_loc4 towns ON p.localidad_prop = towns.id_loc4
LEFT JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
LEFT JOIN properties_loc3 l3 ON areas1.parent_loc3 = l3.id_loc3
LEFT JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
LEFT JOIN properties_loc2 l2 ON province1.parent_loc2 = l2.id_loc2
WHERE n.type_nws = 999
GROUP BY n.id_nws
ORDER BY n.title_" . $lang_adm . "_nws ASC
";

$rResult = mysqli_query($gaSql['link'], $sQuery) or fatal_error('MySQL Error: ' . mysqli_errno($gaSql['link']) . '<hr>' . $sQuery);

// Preparar array para CSV
$return = array();

// Cabeceras
$headers = array('ID Promoción', 'Título', 'Activado', 'Número de Casas', 'Tipos de Propiedad', 'Habitaciones', 'Provincia', 'Ciudad');
array_push($return, $headers);

// Datos
while ($row = mysqli_fetch_assoc($rResult)) {
    $fila = array(
        $row['ID_Promocion'],
        $row['Titulo'],
        $row['Activado'],
        $row['Numero_Casas'],
        $row['Tipos_Propiedad'],
        $row['Habitaciones'],
        $row['Provincias'],
        $row['Ciudades']
    );
    array_push($return, $fila);
}

// Función para descargar CSV
function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";") {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    $f = fopen('php://output', 'w');

    if (!empty($array)) {
        foreach ($array as $line) {
            fputcsv($f, $line, $delimiter);
        }
    }
}

// Descargar CSV
array_to_csv_download($return, "promociones_" . time() . ".csv");

?>
