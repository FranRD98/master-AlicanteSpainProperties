<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

// $query_rsparent1 = "SELECT id_loc1, name_".$lang_adm."_loc1 as country FROM properties_loc1 WHERE id_loc1 = ".$_GET['NxT_id_loc1']." ORDER BY name_".$lang_adm."_loc1 ASC";
// $rsparent1 = mysqli_query($inmoconn,$query_rsparent1) or die(mysqli_error());
// $row_rsparent1 = mysqli_fetch_assoc($rsparent1);
// $totalRows_rsparent1 = mysqli_num_rows($rsparent1);

// $query_rsparent2 = "SELECT id_loc2, name_".$lang_adm."_loc2 as province FROM properties_loc2 WHERE id_loc2 = ".$_GET['NxT_id_loc2']." ORDER BY name_".$lang_adm."_loc2 ASC";
// $rsparent2 = mysqli_query($inmoconn,$query_rsparent2) or die(mysqli_error());
// $row_rsparent2 = mysqli_fetch_assoc($rsparent2);
// $totalRows_rsparent2 = mysqli_num_rows($rsparent2);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-earth-europe"></i> <?php echo __('Mapear zonas'); ?></h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('País'); ?></th>
                                    <th><?php __('Provincia'); ?></th>
                                    <th><?php __('Ciudad'); ?></th>
                                    <th><?php __('Zona'); ?></th>
                                    <?php if($mapeo == 1) { ?>
                                    <th><?php __('Se muestra en'); ?></th>
                                    <?php } ?>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="<?php echo 'country'; ?>" id="<?php echo 'country'; ?>" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="<?php echo 'name_en_loc2'; ?>" id="<?php echo 'name_en_loc2'; ?>" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="<?php echo 'zona'; ?>" id="<?php echo 'zona'; ?>" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="<?php echo 'province'; ?>" id="<?php echo 'province'; ?>" class="form-control form-control-sm"></td>
                                    <?php if($mapeo == 1) { ?>
                                    <td><input type="text" name="parent_feat" id="parent_feat" class="form-control form-control-sm"></td>
                                    <?php } ?>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if($mapeo == 1) { ?>
                                    <td colspan="6" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                    <?php } else { ?>
                                    <td colspan="5" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var numCols = 5;
    var NxT_id_loc1 = '';
    var NxT_id_loc2 = '';
    </script>

    <script src="_js/loc4all-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
