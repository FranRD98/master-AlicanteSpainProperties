<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );



$query_rspropiedad = "SELECT * FROM properties_client ORDER BY nombre_cli, apellidos_cli ASC";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

$selected = '';

if ($_GET['tip'] == 2 && $_GET['sel'] != '') {
    $selected = $_GET['sel'];
}

echo '<option value="">Select one...</option>';

do {

$seleccionado = ($row_rspropiedad['id_cli'] == $selected)?' selected':'';

echo '<option value="'.$row_rspropiedad['id_cli'].'" '.$seleccionado.'>'.$row_rspropiedad['nombre_cli'].' '.$row_rspropiedad['apellidos_cli'].'</option>';

} while ($row_rspropiedad = mysqli_fetch_assoc($rspropiedad));




?>