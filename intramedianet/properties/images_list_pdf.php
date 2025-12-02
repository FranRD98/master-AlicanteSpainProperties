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
if (isset($_GET['id_prop'])) {
  $colname_rsImagenes = $_GET['id_prop'];
}

$colname_rsImagenes = mysqli_real_escape_string($inmoconn, $colname_rsImagenes);
$query_rsImagenes = sprintf("SELECT * FROM properties_images WHERE property_img = %s ORDER BY order_pdf_img", GetSQLValueString($colname_rsImagenes, "int"));
$rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());
$row_rsImagenes = mysqli_fetch_assoc($rsImagenes);
$totalRows_rsImagenes = mysqli_num_rows($rsImagenes);

?>
 <?php if($totalRows_rsImagenes >=  1) { ?>


                      <?php do { ?>
                      <li class="pull-left" id="orderpdf_<?php echo $row_rsImagenes['id_img'] ?>">

                      <div class="img-thumbnail pull-left">
                        <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsImagenes['id_img'].'_md.jpg')) { ?>
                            <a href="/media/images/properties/thumbnails/<?php echo $row_rsImagenes['id_img'] ?>_md.jpg" data-toggle="lightbox"><img src="/media/images/properties/thumbnails/<?php echo $row_rsImagenes['id_img'] ?>_sm.jpg" alt="" style="height: 100px;"></a>
                        <?php } else { ?>
                            <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="height: 100px;">
                        <?php } ?>


                      </div>

                      </li>
                      <?php } while ($row_rsImagenes = mysqli_fetch_assoc($rsImagenes)); ?>


                      <?php } else {?>
                      <p>&nbsp;</p>
                  <?php } ?>



<?php
mysqli_free_result($rsImagenes);
?>
