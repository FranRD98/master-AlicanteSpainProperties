<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

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
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

global $_GET;

	function escape($string, $connection = 'default') {
		if (is_numeric($string) || $string === null || is_bool($string)) {
			return $string;
		}
		$string = substr($string, 0, -1);
		return $string;
	}


$query_rsMax ="SELECT MAX(order_360) + 1  as max FROM properties_360 WHERE property_360 = '".$_GET['p']."'";
$rsMax = mysqli_query($inmoconn, $query_rsMax) or die(mysqli_error());
$row_rsMax = mysqli_fetch_assoc($rsMax);


   $row_rsMax['max'] = ($row_rsMax['max'] > 0)?$row_rsMax['max']:1;



$query_rsVideos = "INSERT INTO `properties_360` SET `properties_360`.`property_360` = '".$_GET['p']."'  , `properties_360`.`video_360` = '".mysqli_real_escape_string($inmoconn, $_GET['vid'])."',  `properties_360`.`order_360` = '".$row_rsMax['max']."';";
$rsVideos = mysqli_query($inmoconn, $query_rsVideos) or die(mysqli_error());

$id = mysqli_insert_id($inmoconn);
?>
<li class="pull-left" id="order_<?php echo $id; ?>" data-id="<?php echo $id; ?>">
    <div class="img-thumbnail pull-left" style="width: 250px;">
        <?php
        $youtube = str_replace("\\\"", "\"", $_GET['vid']) ;
        $ancho = 300;

        preg_match('/width="([0-9]+)%?"/', $youtube, $coincidencias);
        $proporcion = $coincidencias[1] / $ancho;

        if ($proporcion) {
          preg_match('/height="([0-9]+)"/', $youtube, $coincidencias);
          $height = round($coincidencias[1] / $proporcion);

          $youtube = preg_replace('/width="([0-9]+)"/', 'width="100%"', $youtube);
          $youtube = preg_replace('/height="([0-9]+)"/', '', $youtube);
        } else {
          $youtube = 'ERROR';
        } ?>
        <?php echo $youtube; ?>
        <p class="text-center"><a href="/intramedianet/properties/360_del.php" data-id="<?php echo $_GET['p'] ?>" class="btn btn-danger btn-sm del-vid"><i class="fa-regular fa-trash-can"></i></a></p>
    </div>
</li>
