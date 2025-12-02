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

$colname_rsFiles = "-1";
if (isset($_GET['id_cli'])) {
  $colname_rsFiles = $_GET['id_cli'];
}

$colname_rsFiles =  mysqli_real_escape_string($inmoconn,$colname_rsFiles) ;

$query_rsFiles = sprintf("SELECT * FROM properties_client_files WHERE client_fil = %s ", GetSQLValueString($colname_rsFiles, "int"));
$rsFiles = mysqli_query($inmoconn,$query_rsFiles) or die(mysqli_error());
$row_rsFiles = mysqli_fetch_assoc($rsFiles);
$totalRows_rsFiles = mysqli_num_rows($rsFiles);

?>
<?php if($totalRows_rsFiles >=  1) { ?>

     <?php do { ?>

     <li class="pull-left" id="order_<?php echo $row_rsFiles['id_fil'] ?>" data-id="<?php echo $row_rsFiles['id_fil'] ?>">

     <div class="img-thumbnail pull-left">

      <?php 
      $info = pathinfo($row_rsFiles['file_fil']);
      $extension = $info['extension'];

      ?>

        
        <?php 
          if ($info['extension'] == 'jpg' || $info['extension'] == 'jpeg' || $info['extension'] == 'png') 
          {
          ?>
              <a href="/media/files/clients/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="d-inline-block">
                <img class="img-fluid" src="/media/files/clients/<?php echo $row_rsFiles['file_fil']; ?>">
              </a> 
          <?php 
          }
          else
          {
          ?>
              <a href="/media/files/clients/<?php echo $row_rsFiles['file_fil']; ?>" target="_blank" class="btn btn-large btn-primary w-100 text-truncate"><?php __('Ver archivo'); ?>:<br><small>
              <?php echo $row_rsFiles['file_fil']?>
              </a>
          <?php
          }
          ?></small>
        

       <p class="text-center">
         <?php if($row_rsFiles['lang_fil'] != '') { ?>
         <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $row_rsFiles['lang_fil']; ?>.svg" alt="" class="float-start rounded mt-0" style="height: 25px;"/>
         <?php } ?>
         <!-- <a href="#" class="btn btn-success btn-sm edit-name" data-id="<?php echo $row_rsFiles['id_fil'] ?>"><i class="fa-regular fa-pencil"></i></a> -->
         <a href="cfiles_del.php" data-id="<?php echo $row_rsFiles['id_fil'] ?>" class="btn btn-danger btn-sm del-fil"><i class="fa-regular fa-trash-can"></i></a>
       </p>
     </div>

     </li>


     <?php } while ($row_rsFiles = mysqli_fetch_assoc($rsFiles)); ?>


     <?php } else {?>
     <p>&nbsp;</p>
 <?php } ?>


<?php
mysqli_free_result($rsFiles);
?>
