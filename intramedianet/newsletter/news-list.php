<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

$query_rsNews = "SELECT title_".$_GET['lang']."_nws, id_nws FROM news WHERE title_".$_GET['lang']."_nws != ''  AND content_".$_GET['lang']."_nws != '' AND type_nws = 1 ORDER BY title_".$_GET['lang']."_nws";
$rsNews = mysqli_query($inmoconn, $query_rsNews) or die(mysqli_error());
$row_rsNews = mysqli_fetch_assoc($rsNews);
$totalRows_rsNews = mysqli_num_rows($rsNews);


do {
?>
<option value="<?php echo $row_rsNews['id_nws']?>"><?php echo $row_rsNews['title_'.$_GET['lang'].'_nws']?></option>
<?php
} while ($row_rsNews = mysqli_fetch_assoc($rsNews));
  $rows = mysqli_num_rows($rsNews);
  if($rows > 0) {
      mysqli_data_seek($rsNews, 0);
    $row_rsNews = mysqli_fetch_assoc($rsNews);
  }
?>