<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
if(isset($_GET['id'])){
$query_rspropiedad = "SELECT * FROM properties_owner WHERE id_pro = '".$_GET['id']."' ORDER BY nombre_pro, apellidos_pro ASC";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

if (isset($row_rspropiedad['telefono_fijo_pro']) && $row_rspropiedad['telefono_fijo_pro'] != '') {
    echo '<i style="margin-top: 10px; margin-bottom: 10px;" class="fa fa-phone" aria-hidden="true"></i> ' . $row_rspropiedad['telefono_fijo_pro'];
}

if (isset($row_rspropiedad['telefono_movil_pro']) && $row_rspropiedad['telefono_movil_pro'] != '') {
    echo ' <i style="margin-top: 10px; margin-bottom: 10px;" class="fa fa-phone" aria-hidden="true"></i> ' . $row_rspropiedad['telefono_movil_pro'];
}
}
?>