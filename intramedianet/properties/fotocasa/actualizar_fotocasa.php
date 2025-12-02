<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

global $database_inmoconn, $inmoconn;
$query_rsFotocasaProperty = "SELECT * FROM `properties_properties` WHERE export_fotocasa_prop = 1 AND export_fotocasa_fields_prop IS NOT NULL";
$rsFotocasaProperty = mysqli_query($inmoconn,$query_rsFotocasaProperty) or die(mysqli_error());

echo "<hr />";
// CARGAMOS CLASE PARA LA API
include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/FotocasaAPI.php');
// CARGAMOS LA FUNCIÓN QUE IMPORTA LOS DATOS
include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/fotocasaBulkExportProperty.php');

set_time_limit(0);
while ($row_rsFotocasaProperty = mysqli_fetch_assoc($rsFotocasaProperty)){
    set_time_limit(0);
    // Comprobamos si la propiedad existe ya en Fotocasa
    $method = "insert";
    $result = FotocasaAPI::getPublicationProperty($fotocasaDatos["api_key"]);
    $result = json_decode($result,1);
    foreach ( $result as $key => $prop) {
        if( $prop["ExternalId"] == $row_rsFotocasaProperty['id_prop'] ) {
            $method = "update";
        }
    }

    $result = array();
    $result["Message"] = "Exportar Fotocasa = ".$row_rsFotocasaProperty['export_fotocasa_prop'].
    " | Activado = ".@$row_rsFotocasaProperty['activado_prop'].
    " | Vendido = ".@$row_rsFotocasaProperty['vendido_prop'].
    " | Reservado = ".@$row_rsFotocasaProperty['reservado_prop'].
    " | Alquilado = ".@$row_rsFotocasaProperty['alquilado_prop'];
    $result["StatusCode"] = "001";

    // Si se ha marcado Fotocasa, insertamos/actualizamos.
    if ( $row_rsFotocasaProperty['export_fotocasa_prop'] ==  1 &&
         $row_rsFotocasaProperty['activado_prop'] == 1 &&
         $row_rsFotocasaProperty['vendido_prop'] == 0 &&
         $row_rsFotocasaProperty['reservado_prop'] == 0 &&
         $row_rsFotocasaProperty['alquilado_prop'] == 0
     ) {
        $export_fotocasa_fields_prop = json_decode($row_rsFotocasaProperty['export_fotocasa_fields_prop'], true);
        $result = fotocasaBulkExportProperty();

        if( $result["Code"] == "Error_110"){
            $method = "update";
            $export_fotocasa_fields_prop = json_decode($row_rsFotocasaProperty['export_fotocasa_fields_prop'], true);
            $result = fotocasaBulkExportProperty();
        }
    } else if( $method == "update") { // Si se ha desmarcado, desactivado, vendido o reservado y existe, desactivamos en Fotocasa.
        $result = FotocasaAPI::deletePropertyByPortal( (int)$row_rsFotocasaProperty['id_prop'], 1, $fotocasaDatos["api_key"]);
        $result;
    }

    echo $row_rsFotocasaProperty["id_prop"]." - ".$row_rsFotocasaProperty["referencia_prop"];

    if(isset($result)){
        echo " ------> ". $result["StatusCode"].":: ".$result["Message"];
    } else {
        echo " ------> Faltan datos para importar";
    }
    echo "<br />";
    echo "<hr />";
    // if($result !== NULL){
    //     exit;
    // }

}
