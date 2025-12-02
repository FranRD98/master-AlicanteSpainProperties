<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->addLevel("6");
$restrict->Execute();
//End Restrict Access To Page


$query_rsConsulta = "
SELECT *
FROM properties_bajada
WHERE id_baj = '".$_GET['c']."'
";
$rsConsulta = mysqli_query($inmoconn,$query_rsConsulta) or die(mysqli_error());
$row_rsConsulta = mysqli_fetch_assoc($rsConsulta);
$totalRows_rsConsulta = mysqli_num_rows($rsConsulta);


$query_rsExisteEmail = "
SELECT id_cli FROM properties_client
WHERE email_cli = '".$row_rsConsulta['email_baj']."'
";
$rsExisteEmail = mysqli_query($inmoconn,$query_rsExisteEmail) or die(mysqli_error());
$row_rsExisteEmail = mysqli_fetch_assoc($rsExisteEmail);
$totalRows_rsExisteEmail = mysqli_num_rows($rsExisteEmail);

if ($totalRows_rsExisteEmail == 0) {

    
    $query_rsInsert = "
    INSERT INTO `properties_client` (`id_cli`, `user_cli`, `nombre_cli`, `apellidos_cli`, `direccion_cli`, `telefono_fijo_cli`, `telefono_movil_cli`, `email_cli`, `skype_cli`, `como_nos_conocio_cli`, `captado_por_cli`, `fecha_alta_cli`, `historial_cli`, `nie_cli`, `pasaporte_cli`, `residencia_fiscal_cli`, `nacionalidad_cli`, `idioma_cli`, `notas_cli`, `puntuacion_cli`, `status_cli`, `b_sale_cli`, `b_beds_cli`, `b_baths_cli`, `b_type_cli`, `b_loc1_cli`, `b_loc2_cli`, `b_loc3_cli`, `b_loc4_cli`, `b_ref_cli`, `b_precio_desde_cli`, `b_precio_hasta_cli`, `b_opciones_cli`, `b_opciones2_cli`, `b_ocultos_cli`, `b_orientacion_cli`) VALUES
    (NULL, '0', '".$row_rsConsulta['name_baj']."', '', NULL, '".$row_rsConsulta['phone_baj']."', NULL, '".$row_rsConsulta['email_baj']."', NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, NULL, NULL, '0', NULL, '".$row_rsConsulta['lang_baj']."', NULL, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
    ";
    $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    $id = mysqli_insert_id($inmoconn);

    // 
    // $query_rsInsert = "
    // UPDATE properties_enquiries SET client_baj  = '".$id."' WHERE id_baj = '".$row_rsConsulta['id_baj']."'
    // ";
    // $rsInsert = mysqli_query($inmoconn,$query_rsInsert) or die(mysqli_error());

    header("Location: /intramedianet/properties/clients-form.php?id_cli=" . $id);

} else {
    header("Location: /intramedianet/properties/clients-form.php?id_cli=" . $row_rsExisteEmail['id_cli']);
}










 ?>
