<?php

include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

$query_rsBajadas = "DELETE FROM properties_consultas_log WHERE id_con = '" . $_GET['c'] . "'";
$rsBajadas = mysqli_query($inmoconn, $query_rsBajadas) or die(mysqli_error());

header("Location: /intramedianet/properties/consultas.php");

?>
