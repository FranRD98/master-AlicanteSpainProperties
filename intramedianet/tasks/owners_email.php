<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
if(isset($_GET['id'])){
$query_rspropiedad = "SELECT * FROM properties_owner WHERE id_pro = '".$_GET['id']."' ORDER BY nombre_pro, apellidos_pro ASC";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);

if (isset($row_rspropiedad['email_pro']) && $row_rspropiedad['email_pro'] != '') {
    echo '<i style="margin-top: 20px;" class="fa fa-envelope" aria-hidden="true"></i> ' . $row_rspropiedad['email_pro'] . '';
}
}
?>