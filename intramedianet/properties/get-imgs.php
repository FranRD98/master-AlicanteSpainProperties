<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Cargamos la conexión a MySql
include_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

$query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$_GET['p']."' ORDER BY order_img";
$rsImages = mysqli_query($inmoconn, $query_rsImages) or die(mysqli_error());
$row_rsImages = mysqli_fetch_assoc($rsImages);
$totalRows_rsImages = mysqli_num_rows($rsImages);
?>
<?php do { ?>

<p><img src="/media/images/properties/thumbnails/<?php echo $row_rsImages['id_img'] ?>_xl.jpg" alt="" style="max-width: 100%;"></p>

<?php } while ($row_rsImages = mysqli_fetch_assoc($rsImages)); ?>
