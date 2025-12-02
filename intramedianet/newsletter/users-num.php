<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

$cats = '';
if ($_GET['cats'] != '') {

	$cats = " AND newsletter_usr_cat.cat IN (" . $_GET['cats'] .") ";

}

$query_rsNews = "SELECT newsletter_users.id_usr FROM newsletter_usr_cat INNER JOIN newsletter_users ON newsletter_usr_cat.usr = newsletter_users.id_usr WHERE lang_usr = '".$_GET['lang']."'  ".$cats." GROUP BY email_usr";
$rsNews = mysqli_query($inmoconn, $query_rsNews) or die(mysqli_error());
$row_rsNews = mysqli_fetch_assoc($rsNews);
$totalRows_rsNews = mysqli_num_rows($rsNews);

echo $totalRows_rsNews;

?>