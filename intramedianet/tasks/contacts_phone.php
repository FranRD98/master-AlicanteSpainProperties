<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
if(isset($_GET['id'])){
$query_rspropiedad = "SELECT * FROM properties_collaborators WHERE id_col = '".$_GET['id']."' ORDER BY nombre_comercial_col ASC";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

if (isset($row_rspropiedad['telefono_fijo_col']) && $row_rspropiedad['telefono_fijo_col'] != '') {
    echo ' <i class="fa fa-phone" aria-hidden="true"></i> ' . $row_rspropiedad['telefono_fijo_col'];
}

if (isset($row_rspropiedad['telefono_contacto_col']) && $row_rspropiedad['telefono_contacto_col'] != '') {
    echo ' <i class="fa fa-phone" aria-hidden="true"></i> ' . $row_rspropiedad['telefono_contacto_col'];
}
}
?>
