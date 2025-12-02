<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');
// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');
// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/lang_' . $_GET['lang'] . '.php');

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

$colname_rsPrecios = "-1";
if (isset($_GET['id_prop'])) {
  $colname_rsPrecios = $_GET['id_prop'];
}

$colname_rsPrecios = mysqli_real_escape_string($inmoconn, $colname_rsPrecios);

$query_rsPrecios = sprintf("SELECT * FROM properties_prices WHERE property_prc = %s ORDER BY from_prc DESC", GetSQLValueString($colname_rsPrecios, "int"));
$rsPrecios = mysqli_query($inmoconn, $query_rsPrecios) or die(mysqli_error());
$row_rsPrecios = mysqli_fetch_assoc($rsPrecios);
$totalRows_rsPrecios = mysqli_num_rows($rsPrecios);
?>

<table class="display table table-bordered align-middle align-middle" width="100%">
    <thead class="table-light">
    <tr>
      <th><?php echo $lang['Fecha inicio']; ?></th>
      <th><?php echo $lang['Fecha final']; ?></th>
      <th><?php echo $lang['Precio']; ?></th>
      <th style="width: 85px;">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($totalRows_rsPrecios == 0) { // Show if recordset empty ?>
      <tr>
        <td colspan="4"><?php echo $lang['No se han añdido precios']; ?></td>
      </tr>
      <?php } // Show if recordset empty ?>
    <?php if ($totalRows_rsPrecios > 0) { // Show if recordset not empty ?>
        <?php do { ?>
  <tr>
    <td><?php echo KT_formatDate($row_rsPrecios['from_prc']); ?></td>
    <td><?php echo KT_formatDate($row_rsPrecios['to_prc']); ?></td>
    <td><?php echo number_format($row_rsPrecios['price_prc'],0,',','.'); ?> €</td>
    <td>

      <a href="prec-save.php?id=<?php echo $row_rsPrecios['id_prc']; ?>" data-id="<?php echo $row_rsPrecios['id_prc']; ?>" class="editprec btn btn-sm btn-success"><i class="fa-regular fa-pencil"></i></a>
      <a href="prec-save.php?id=<?php echo $row_rsPrecios['id_prc']; ?>" data-id="<?php echo $row_rsPrecios['id_prc']; ?>" class="delprec btn btn-sm btn-danger"><i class="fa-regular fa-trash-can"></i></a>

    </td>
  </tr>
  <?php } while ($row_rsPrecios = mysqli_fetch_assoc($rsPrecios)); ?>
<?php } // Show if recordset not empty ?>
  </tbody>
</table>
<?php
mysqli_free_result($rsPrecios);
?>
