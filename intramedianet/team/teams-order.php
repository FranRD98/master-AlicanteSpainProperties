<?php


// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->addLevel("6");
$restrict->addLevel("5");
$restrict->Execute();
//End Restrict Access To Page

$query_rsTeam = "SELECT * FROM teams ORDER BY order_tms";
$rsTeam = mysqli_query($inmoconn, $query_rsTeam) or die(mysqli_error());
$row_rsTeam = mysqli_fetch_assoc($rsTeam);
$totalRows_rsTeam = mysqli_num_rows($rsTeam);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-arrow-up-arrow-down"></i> <a href="teams.php"><?php echo __('Equipo'); ?></a> <i class="fa-regular fa-angle-right"></i> <?php __('Ordenar'); ?></h4>
                    <div class="flex-shrink-0">
                        <div class="loading-ord d-inline-block fs-5 me-3"></div>
                        <a href="teams.php" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-angle-left me-1"></i> <?php __('Volver'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="list-group nested-list nested-sortable-handle">
                        <?php $i = 1; ?>
                        <?php do { ?>
                        <div class="list-group-item nested-2" data-id="<?php echo $row_rsTeam['id_tms']; ?>">
                            <i class="fa-regular fa-bars align-bottom handle text-muted opacity-25 fs-2"></i>
                            <?php echo $row_rsTeam['nombre_tms']; ?>
                        </div>
                        <?php } while ($row_rsTeam = mysqli_fetch_assoc($rsTeam)); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php /* ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate" enctype="multipart/form-data">

        <div id="second-nav">
            <h1 class="pull-left"><i class="fa fa-id-card-o"></i> <span><?php __('Equipo'); ?></span></h1>
            <div class="btn-toolbar pull-right" role="toolbar">
                <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='teams.php'" class="btn btn-sm" />
            </div>
        </div>

        <div id="main-content">

            <div class="container-fluid">

                <?php echo $tNGs->getErrorMsg(); ?>

                <div class="panel panel-primary">

                  <div class="panel-heading"><h3 class="panel-title"><?php __('Ordenar'); ?> -  <?php __('Equipo'); ?></h3></div>

                  <div class="panel-body">

                    <div class="loading-ord"></div>

                    <div class="dd">
                      <ol class="dd-list">
                          <?php do { ?>
                            <li class="dd-item" data-id="order_<?php echo $row_rsTeam['id_tms'] ?>">
                              <div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div>
                              <div class="dd-content">
                                <?php echo $row_rsTeam['nombre_tms'] ?>
                              </div>
                            </li>

                          <?php } while ($row_rsTeam = mysqli_fetch_assoc($rsTeam)); ?>
                      </ol>
                    </div>

                </div>
            </div>


        </div>


    </div>

    <input type="hidden" name="kt_pk_teams" class="id_field" value="<?php echo KT_escapeAttribute($row_rsteams['kt_pk_teams']); ?>" />

</form>

</div> <!--/.container-fluid -->

</div> <!--#main-content -->

<?php */ ?>

<?php include("../includes/inc.footer.php"); ?>

<script>
  var nestedSortablesHandles = [].slice.call(document.querySelectorAll('.nested-sortable-handle'));
  if (nestedSortablesHandles) {
      Array.from(nestedSortablesHandles).forEach(function (nestedSortHandle){
          sortable = new Sortable(nestedSortHandle, {
              // handle: '.handle',
              group: 'nested',
              animation: 150,
              fallbackOnBody: true,
              swapThreshold: 0.65,
              onUpdate: function (evt) {
                  var order = sortable.toArray();
                  $('.loading-ord').html('<i class="fa-solid fa-hourglass-end text-muted fa-flip" style="--fa-flip-x: 1; --fa-flip-y: 0;"></i>');
                  $.get("categories_order.php?order="+order, function(data) {
                      $('.loading-ord').html('<i class="fa-solid fa-check text-success"></i>');
                      setTimeout(function(){$('.loading-ord').html('');}, 5000);
                  });
              }
          });
      });
  }
</script>

<!-- <script>
  $(document).ready(function() {

      $('.dd').nestable({
          group: 1
      }).on('change', function() {
          var order = window.JSON.stringify($('.dd').nestable('serialize'));
          $('.loading-ord').show();
          $.get("categories_order.php?json="+order, function(data) {
              $('.loading-ord').fadeOut();
          });
      });

  });
</script> -->

</body>
</html>
