<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
if(isset($_GET['id'])){
$query_rspropiedad = "SELECT * FROM properties_client WHERE id_cli = '".$_GET['id']."' ORDER BY nombre_cli, apellidos_cli ASC";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

if (isset($row_rspropiedad['telefono_fijo_cli']) && $row_rspropiedad['telefono_fijo_cli'] != '') {
    echo ' <i class="fa fa-phone" aria-hidden="true"></i> ' . $row_rspropiedad['telefono_fijo_cli'];
}

if (isset($row_rspropiedad['telefono_movil_cli']) && $row_rspropiedad['telefono_movil_cli'] != '') {
    echo ' <i class="fa fa-phone" aria-hidden="true"></i> ' . $row_rspropiedad['telefono_movil_cli'];
}
}
?>