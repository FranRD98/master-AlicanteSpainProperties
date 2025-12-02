<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );


$query_rsNotes = "SELECT * FROM properties_client WHERE id_cli = '".$_GET['id']."' ";
$rsNotes = mysqli_query($inmoconn, $query_rsNotes) or die(mysqli_error());
$row_rsNotes = mysqli_fetch_assoc($rsNotes);
$totalRows_rsNotes = mysqli_num_rows($rsNotes);

echo nl2br($row_rsNotes['historial_cli']);


 ?>