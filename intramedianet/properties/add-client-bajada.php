<?php

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );


$query_rsBajadas = "SELECT * FROM properties_bajada WHERE id_baj = '".$_GET['id']."'";
$rsBajadas = mysqli_query($inmoconn,$query_rsBajadas) or die(mysqli_error());
$row_rsBajadas = mysqli_fetch_assoc($rsBajadas);
$totalRows_rsBajadas = mysqli_num_rows($rsBajadas);





$query_rsInsert = "
INSERT INTO `properties_client` SET
    `nombre_cli` = '".mysqli_real_escape_string($inmoconn,$row_rsBajadas['name_baj'])."',
    `telefono_fijo_cli` = '".mysqli_real_escape_string($inmoconn,$row_rsBajadas['phone_baj'])."',
    `email_cli` = '".mysqli_real_escape_string($inmoconn,$row_rsBajadas['email_baj'])."',
    `fecha_alta_cli` = '" . $row_rsBajadas['date_baj'] . "',
    `idioma_cli` = '" . $row_rsBajadas['lang_baj'] . "',
    `como_nos_conocio_cli` = '19',
    `historial_cli` = 'Property reference: " . $_GET['r'] . "'
";

// die($query_rsInsert);

$rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

$id = mysqli_insert_id($inmoconn);

header("Location: /intramedianet/properties/clients-form.php?id_cli=" . $id);
?>
