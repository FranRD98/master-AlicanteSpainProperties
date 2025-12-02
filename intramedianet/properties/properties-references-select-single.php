<?php
// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

$results = array();
if( isset($_GET["q"]) && $_GET["q"] != "" ){
    
    $query_rsClient = "SELECT id_prop, referencia_prop FROM properties_properties
    WHERE id_prop = '".mysqli_real_escape_string($inmoconn,$_GET["q"])."'";
    $rsClient = mysqli_query($inmoconn,$query_rsClient) or die(mysqli_error());
    $row_rsClient = mysqli_fetch_assoc($rsClient);
    $totalRows_rsClient = mysqli_num_rows($rsClient);
    if( $totalRows_rsClient != 0){
        do {
            $name = $row_rsClient["referencia_prop"];
            $results = array(
                "id" => $row_rsClient["id_prop"],
                "text" => $name,
            );
        } while ($row_rsClient = mysqli_fetch_assoc($rsClient ));
    }
}
echo json_encode($results);

?>
