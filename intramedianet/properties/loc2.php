<?php
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

$query_rsparent1 = "SELECT id_loc1, name_".$lang_adm."_loc1 as country FROM properties_loc1 WHERE id_loc1 = ".$_GET['NxT_id_loc1']." ORDER BY name_".$lang_adm."_loc1 ASC";
$rsparent1 = mysqli_query($inmoconn,$query_rsparent1) or die(mysqli_error());
$row_rsparent1 = mysqli_fetch_assoc($rsparent1);
$totalRows_rsparent1 = mysqli_num_rows($rsparent1);
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-earth-europe"></i> <?php echo __('Localización'); ?></h4>
                    <div class="flex-shrink-0">
                        <?php if ($_SESSION['kt_login_user'] == 'crm@mediaelx.net'): ?>
                        <a href="loc2-form.php?NxT_id_loc1=<?php echo $_GET['NxT_id_loc1'] ?>&KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                        <?php endif ?>
                        <a href="loc1.php" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-angle-left me-1"></i> <?php __('Volver'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb p-3 py-2 bg-light">
                          <li class="breadcrumb-item"><a href="/intramedianet/properties/loc1.php"><i class="fa-regular fa-earth-europe"></i> <?php echo $row_rsparent1['country'] ?></a></li>
                          <li class="breadcrumb-item active" aria-current="page"><?php __('Provincias'); ?></li>
                      </ol>
                  </nav>

                    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix" role="alert">
                        <i class="fa-regular fa-circle-info label-icon"></i>
                        <?php __('text_hide_locations'); ?>
                    </div>

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Provincia'); ?></th>
                                    <?php if($mapeo == 1) { ?>
                                    <th><?php __('Se muestra en'); ?></th>
                                    <?php } ?>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="<?php echo 'feature_en_feat'; ?>" id="<?php echo 'feature_en_feat'; ?>" class="form-control form-control-sm"></td>
                                    <?php if($mapeo == 1) { ?>
                                    <td style="width: 200px;"><input type="text" name="<?php echo 'feature_es_feat'; ?>" id="<?php echo 'feature_es_feat'; ?>" class="form-control form-control-sm"></td>
                                    <?php } ?>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if($mapeo == 1) { ?>
                                    <td colspan="2" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                    <?php } else { ?>
                                    <td colspan="1" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
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
    var numCols = <?php echo ($mapeo == 1)?2:1; ?>;
    var NxT_id_loc1 = <?php echo $_GET['NxT_id_loc1']; ?>;
    </script>

    <script src="_js/loc2-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
