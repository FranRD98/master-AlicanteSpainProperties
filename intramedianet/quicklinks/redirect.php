<?php

// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

$query_rsRedirect = "SELECT title_".$_GET['lang']."_nws as titulo FROM news WHERE id_nws = '".$_GET['id_nws']."'";
$rsRedirect = mysqli_query($inmoconn, $query_rsRedirect) or die(mysqli_error());
$row_rsRedirect = mysqli_fetch_assoc($rsRedirect);
$totalRows_rsRedirect = mysqli_num_rows($rsRedirect);

if ($_GET['lang'] == $language) {
    $urlstart = '/';
} else {
    $urlstart = '/'.$_GET['lang'].'/';
}

header("Location: https://".$_SERVER['HTTP_HOST']."".$urlstart."".clean($row_rsRedirect['titulo']).".html");



?>