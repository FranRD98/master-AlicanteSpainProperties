<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

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
$restrict->addLevel("1");
// $restrict->Execute();
//End Restrict Access To Page
?><?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }


  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsImagenes = "-1";
if (isset($_GET['id_nws'])) {
  $colname_rsImagenes = $_GET['id_nws'];
}


$colname_rsImagenes = mysqli_real_escape_string($inmoconn,$colname_rsImagenes);


$query_rsImagenes = sprintf("SELECT * FROM news_fotos WHERE noticia_img = %s ORDER BY orden_img", GetSQLValueString($colname_rsImagenes, "int"));
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
$row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
$totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

?>
 <?php if($totalRows_rsImagenes >=  1) { ?>

                      <?php do { ?>
                      <li class="pull-left" id="order_<?php echo $row_rsImagenes['id_img'] ?>">

                      <div class="img-thumbnail pull-left">
                        <?php echo showThumbnail($row_rsImagenes['imagen_img'], '/media/images/news/', 150, 100); ?>
                        <p class="text-center"><a href="#" class="btn btn-success btn-sm edit-alt" data-id="<?php echo $row_rsImagenes['id_img'] ?>"><i class="fa fa-pencil"></i></a> <a href="images_del.php" data-id="<?php echo $row_rsImagenes['id_img'] ?>" class="btn btn-danger btn-sm del-img"><i class="fa-regular fa-trash-can"></i></a>

                                            <?php $altDisp = false; ?>

                                            <?php

                                              foreach($languages as $value) {

                                                if($row_rsImagenes['alt_'.$value.'_img'] == '') {

                                                  $altDisp = true;

                                                }
                                              }
                                            ?>


                                            <?php if($altDisp == true) { ?>
                                            <i class="fa-regular fa-asterisk text-danger"></i>
                                            <?php } ?></p>
                      </div>

                      </li>
                      <?php } while ($row_rsImagenes = mysqli_fetch_assoc($rsImagenes)); ?>


                      <?php } else {?>
                      <p>&nbsp;</p>
                  <?php } ?>

<?php
mysqli_free_result($rsImagenes);
?>
