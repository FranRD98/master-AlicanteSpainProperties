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



$query_rsPaises = "UPDATE  `properties_properties` SET  `".$_GET['s']."` =  '".$_GET['v']."' WHERE  `properties_properties`.`id_prop` ='".$_GET['id_prop']."';";


if (mysqli_query($inmoconn,$query_rsPaises)) {
	if($_GET['v'] == 0) {
		echo '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
	} else {
		echo '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
	}
    array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/modules/_cache/*"));
    
    $query_rs360 = "SELECT * FROM properties_properties WHERE id_prop = '".$_GET['id_prop']."' ";
    $rs360 = mysqli_query($inmoconn,$query_rs360) or die(mysqli_error());
    $row_rs360 = mysqli_fetch_assoc($rs360);
    $totalRows_rs360 = mysqli_num_rows($rs360);

    if(isset($row_rs360['referencia_prop'])){
        $query_rsProp = "INSERT INTO `properties_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '".$_SESSION['kt_login_id']."', '".$_GET['id_prop']."', '".$row_rs360['referencia_prop']."', '2', '".date("Y-m-d H:i:s")."')";
        $rsProp = mysqli_query($inmoconn,$query_rsProp) or die(mysqli_error());
    }

    if($_GET['v'] == 0 && ($_GET['s'] == 'activado_prop' || $_GET['s'] == 'vendido_prop' || $_GET['s'] == 'force_hide_prop')) {
        include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/FotocasaAPI.php');

        $result = FotocasaAPI::getPublicationProperty($fotocasaDatos["api_key"]);
        $result = json_decode($result,1);
        foreach ( $result as $key => $prop) {
            if( $prop["ExternalId"] == (int)$_GET['id_prop'] ) {
                $resutl = FotocasaAPI::deletePropertyByPortal( (int)$_GET['id_prop'], 1, $fotocasaDatos["api_key"]);
                $_SESSION['fc_status'] = $result;
            }
        }
    }
} else {
	die(mysqli_error());
}



?>
