<?php

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );


$query_rsNotes = "SELECT * FROM properties_properties WHERE id_prop = '".$_POST['id']."' ";
$rsNotes = mysqli_query($inmoconn,$query_rsNotes) or die(mysqli_error());
$row_rsNotes = mysqli_fetch_assoc($rsNotes);
$totalRows_rsNotes = mysqli_num_rows($rsNotes);

if($_POST['h'] != '') {
	
	$query_rsUpdate = "UPDATE `properties_properties` SET `notas_prop` = '[ ".date("d-m-Y H:i")." ] → ".mysqli_real_escape_string($inmoconn, $_POST['h'])." \n\n ".mysqli_real_escape_string($inmoconn,$row_rsNotes['notas_prop'])."'  WHERE id_prop = '".$_POST['id']."' ";
	$rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());
}

 ?>