<?php

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );


$query_rsBajadas = "SELECT * FROM properties_consultas_log WHERE id_con = '".$_GET['c']."'";
$rsBajadas = mysqli_query($inmoconn,$query_rsBajadas) or die(mysqli_error());
$row_rsBajadas = mysqli_fetch_assoc($rsBajadas);
$totalRows_rsBajadas = mysqli_num_rows($rsBajadas);

function limpiarTelefono($telefono) {
    $telefono = str_replace('+', '', $telefono); // Elimina el signo de suma
    $telefono = str_replace(' ', '', $telefono); // Elimina todos los espacios en blanco
    return $telefono;
}


$query_rsExisteEmail = "
SELECT id_cli FROM properties_client
WHERE email_cli = '".$row_rsConsulta['email_cons']."'
";
$rsExisteEmail = mysqli_query($inmoconn,$query_rsExisteEmail) or die(mysqli_error());
$row_rsExisteEmail = mysqli_fetch_assoc($rsExisteEmail);

if ($totalRows_rsExisteEmail == 0) {

    $telefonoCli = limpiarTelefono(mysqli_real_escape_string($inmoconn,$row_rsBajadas['phone_con']));
    
    
    $query_rsInsert = "
    INSERT INTO `properties_client` SET
        `nombre_cli` = '".mysqli_real_escape_string($inmoconn,$row_rsBajadas['name_con'])."',
        `telefono_fijo_cli` = '".$telefonoCli."',
        `fecha_alta_cli` = '" . $row_rsBajadas['date_con'] . "',
        `idioma_cli` = '" . $row_rsBajadas['lang_con'] . "',
        `como_nos_conocio_cli` = '3',
        `historial_cli` = 'Property reference: " . mysqli_real_escape_string($inmoconn,$row_rsBajadas['text_con']) . "'
    ";

    // die($query_rsInsert);

    $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    $id = mysqli_insert_id($inmoconn);

    header("Location: /intramedianet/properties/clients-form.php?id_cli=" . $id);

} else {
    header("Location: /intramedianet/properties/clients-form.php?id_cli=" . $row_rsExisteEmail['id_cli']);
}

?>
