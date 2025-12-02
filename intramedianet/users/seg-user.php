<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

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
$restrict->Execute();
//End Restrict Access To Page

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

$colname_rsTime = "-1";
if (isset($_GET['id_usr'])) {
  $colname_rsTime = $_GET['id_usr'];
}

$colname_rsTime = mysqli_real_escape_string($inmoconn, $colname_rsTime);

$query_rsTime = sprintf("SELECT  idusr_log, TIME_TO_SEC(TIMEDIFF(dateout_log, datein_log)) AS avg_time FROM users_log  WHERE idusr_log = %s ORDER BY dateout_log DESC", GetSQLValueString($colname_rsTime, "int"));
$rsTime = mysqli_query($inmoconn, $query_rsTime) or die(mysqli_error());
$row_rsTime = mysqli_fetch_assoc($rsTime);
$totalRows_rsTime = mysqli_num_rows($rsTime);

$colname_rsTotalVisitas = "-1";
if (isset($_GET['id_usr'])) {
  $colname_rsTotalVisitas = $_GET['id_usr'];
}
$query_rsTotalVisitas = sprintf("SELECT * FROM users_log WHERE idusr_log = %s", GetSQLValueString($colname_rsTotalVisitas, "int"));
$rsTotalVisitas = mysqli_query($inmoconn, $query_rsTotalVisitas) or die(mysqli_error());
$row_rsTotalVisitas = mysqli_fetch_assoc($rsTotalVisitas);
$totalRows_rsTotalVisitas = mysqli_num_rows($rsTotalVisitas);

$colname_rsHoy = "-1";
if (isset($_GET['id_usr'])) {
  $colname_rsHoy = $_GET['id_usr'];
}
$query_rsHoy = sprintf("SELECT * FROM users_log WHERE idusr_log = %s AND DATE(users_log.datein_log) = CURDATE()", GetSQLValueString($colname_rsHoy, "int"));
$rsHoy = mysqli_query($inmoconn,$query_rsHoy) or die(mysqli_error());
$row_rsHoy = mysqli_fetch_assoc($rsHoy);
$totalRows_rsHoy = mysqli_num_rows($rsHoy);

$colname_rsUser = "-1";
if (isset($_GET['id_usr'])) {
  $colname_rsUser = $_GET['id_usr'];
}
$query_rsUser = sprintf("SELECT * FROM users WHERE id_usr = %s ", GetSQLValueString($colname_rsUser, "int"));
$rsUser = mysqli_query($inmoconn,$query_rsUser) or die(mysqli_error());
$row_rsUser = mysqli_fetch_assoc($rsUser);
$totalRows_rsUser = mysqli_num_rows($rsUser);

$colname_rsVisita = "-1";
if (isset($_GET['id_log'])) {
  $colname_rsVisita = $_GET['id_log'];
}

$query_rsVisita = sprintf("SELECT * FROM users_log WHERE id_log = %s", GetSQLValueString($colname_rsVisita, "int"));
$rsVisita = mysqli_query($inmoconn,$query_rsVisita) or die(mysqli_error());
$row_rsVisita = mysqli_fetch_assoc($rsVisita);
$totalRows_rsVisita = mysqli_num_rows($rsVisita);

$colname_rsOnline = "-1";
if (isset($_GET['id_usr'])) {
  $colname_rsOnline = $_GET['id_usr'];
}

$query_rsOnline = sprintf("SELECT users.id_usr FROM users_log INNER JOIN users ON users_log.idusr_log = users.id_usr WHERE users_log.dateout_log > SUBTIME(NOW(),'00:10:00') AND id_usr = %s GROUP BY users.id_usr  ORDER BY users_log.dateout_log DESC ", GetSQLValueString($colname_rsOnline, "int"));
$rsOnline = mysqli_query($inmoconn,$query_rsOnline) or die(mysqli_error());
$row_rsOnline = mysqli_fetch_assoc($rsOnline);
$totalRows_rsOnline = mysqli_num_rows($rsOnline);

$sum = 0;
do {
  $sum = $sum + $row_rsTime['avg_time'];
} while ($row_rsTime = mysqli_fetch_assoc($rsTime));
$media = $sum/$totalRows_rsTime;

$visitasData =array();

for ($i=20; $i >= 0; $i--) {
  $date = new DateTime(date("Y-m-d"));
  $date->modify('-'.$i.' day');

  
  $query_rsHoy = "SELECT * FROM users_log WHERE idusr_log = ".$_GET['id_usr']." AND DATE(users_log.datein_log) = '".$date->format('Y-m-d')."'";
  $rsHoy = mysqli_query($inmoconn,$query_rsHoy) or die(mysqli_error());
  $row_rsHoy = mysqli_fetch_assoc($rsHoy);
  $totalRows_rsHoy = mysqli_num_rows($rsHoy);
  array_push($visitasData, $totalRows_rsHoy);

}

?>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-md-3 row-cols-1">
                    <div class="col col-lg">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('Acceso'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-right-to-bracket display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="#<?php echo $_GET['id_log']; ?>">#<?php echo $_GET['id_log']; ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-md-6">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-md-3 row-cols-1">
                    <div class="col col-lg">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php if ($totalRows_rsOnline > 0) { ?>
                                <div class="badge bg-success user-status">ONLINE</div>
                                <?php } else { ?>
                                <div class="badge bg-danger user-status">OFFLINE</div>
                                <?php } ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <?php if (tNG_fileExists("../../media/images/users/", "{rsUser.image_usr}")): ?>
                                        <img src="/media/images/users/<?php echo $row_rsUser['image_usr'] ?>?id=<?php echo time(); ?>" style="width: 38px; height: 38px;" class="avatar-sm rounded-circle" />
                                    <?php else: ?>
                                        <img src="/intramedianet/includes/assets/imgs/user-dummy-img.jpg" id="product-img" style="width: 38px; height: 38px;" class="avatar-sm rounded-circle">
                                    <?php endif ?>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="<?php echo $row_rsUser['nombre_usr']; ?> <?php if(isset($row_rsUser['apellidos_usr'])) echo $row_rsUser['apellidos_usr']; ?>"><?php echo $row_rsUser['nombre_usr']; ?> <?php if(isset($row_rsUser['apellidos_usr'])) echo $row_rsUser['apellidos_usr']; ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>

<div class="row mb-2">
    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-md-3 row-cols-1">
                    <div class="col col-lg border-end">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('IP'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-server display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="<?php echo $row_rsVisita['ip_log']; ?>"><?php echo $row_rsVisita['ip_log']; ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col col-lg border-end">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('Entrada a la web'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-calendar-check display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="<?php echo date("d-m-Y H:i", strtotime($row_rsVisita['datein_log'])); ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsVisita['datein_log'])); ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col col-lg">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('Salida de la web'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-calendar-xmark display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="<?php echo date("d-m-Y H:i", strtotime($row_rsVisita['dateout_log'])); ?>"><?php echo date("d-m-Y H:i", strtotime($row_rsVisita['dateout_log'])); ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>

<div class="row mb-2">
    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-md-3 row-cols-1">
                    <div class="col col-lg border-end">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('Historial'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-chart-pie-simple display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><div id="sparkline" class="sparkline w-100"></div></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col col-lg border-end">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('Accesos hoy'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-calendar-day display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="<?php echo number_format($totalRows_rsHoy, 0, ',','.') ?>"><?php echo number_format($totalRows_rsHoy, 0, ',','.') ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col col-lg border-end">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('Total de accesos'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-calendar-days display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="<?php echo number_format($totalRows_rsTotalVisitas, 0, ',','.'); ?>"><?php echo number_format($totalRows_rsTotalVisitas, 0, ',','.'); ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col col-lg">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">
                                <?php __('Tiempo medio accesos'); ?>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-calendar-clock display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0 fz-6"><span class="counter-value" data-target="<?php echo gmdate('H:i:s',round($media)); ?>"><?php echo gmdate('H:i:s',round($media)); ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>

<script src="/intramedianet/includes/assets/_custom/vendor/jquery.sparkline.js"></script>

<script type="text/javascript">

$("#sparkline").sparkline([<?php echo implode(',', $visitasData); ?>], {
    type: 'line',
    width: '100',
    height: '32',
    lineColor: '#666',
    fillColor: '#eee',
    lineWidth: 2,
    spotColor: false,
    minSpotColor: false,
    maxSpotColor: false,
    highlightSpotColor: false,
    highlightLineColor: false
});

</script>
<?php
mysqli_free_result($rsTime);

mysqli_free_result($rsTotalVisitas);

mysqli_free_result($rsHoy);

mysqli_free_result($rsOnline);

mysqli_free_result($rsVisita);
?>
