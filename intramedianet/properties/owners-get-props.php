<?php

// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );


$query_rsOwner = "SELECT * FROM properties_owner ORDER BY nombre_pro, apellidos_pro ASC";
$rsOwner = mysqli_query($inmoconn, $query_rsOwner) or die(mysqli_error());
$row_rsOwner = mysqli_fetch_assoc($rsOwner);
$totalRows_rsOwner = mysqli_num_rows($rsOwner);


?>

<option value=""><?php echo NXT_getResource("Select one..."); ?></option>
  <?php
  do {
  ?>
  <option value="<?php echo $row_rsOwner['id_pro']?>"<?php if (!(strcmp($row_rsOwner['id_pro'], $_GET['s']))) {echo "SELECTED";} ?>><?php echo $row_rsOwner['nombre_pro']?> <?php echo $row_rsOwner['apellidos_pro']?></option>
  <?php
  } while ($row_rsOwner = mysqli_fetch_assoc($rsOwner));
    $rows = mysqli_num_rows($rsOwner);
    if($rows > 0) {
        mysqli_data_seek($rsOwner, 0);
      $row_rsOwner = mysqli_fetch_assoc($rsOwner);
    }
  ?>