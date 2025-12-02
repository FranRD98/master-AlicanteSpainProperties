<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

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

$query_rsDuplicates = "
SELECT
    COUNT(*),
    tipo_prop,
    operacion_prop,
    preci_reducidoo_prop,
    habitaciones_prop,
    aseos_prop,
    m2_prop,
    m2_parcela_prop,
    localidad_prop,
    GROUP_CONCAT(CONCAT(id_prop, '@@@', referencia_prop)) as ids,
    properties_loc3.id_loc3 as a,
    areas1.parent_loc3 as b,
    CASE WHEN areas1.parent_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END as loc
FROM properties_loc4 towns
LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
WHERE activado_prop = 1
GROUP BY
    CASE WHEN types.parent_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END,
    operacion_prop,
    preci_reducidoo_prop,
    habitaciones_prop,
    aseos_prop,
    m2_prop,
    m2_parcela_prop,
    CASE WHEN areas1.parent_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END
HAVING COUNT(*)>1
";
$rsDuplicates = mysqli_query($inmoconn,$query_rsDuplicates) or die(mysqli_error());
$row_rsDuplicates = mysqli_fetch_assoc($rsDuplicates);
$totalRows_rsDuplicates = mysqli_num_rows($rsDuplicates);


// SELECT COUNT(*), tipo_prop, operacion_prop, preci_reducidoo_prop, habitaciones_prop, aseos_prop, m2_prop, m2_parcela_prop, localidad_prop, GROUP_CONCAT(CONCAT(id_prop, '@@@', referencia_prop)) as ids
// FROM properties_properties
// WHERE activado_prop = 1
// GROUP BY tipo_prop, operacion_prop, preci_reducidoo_prop, habitaciones_prop, aseos_prop, m2_prop, m2_parcela_prop, localidad_prop
// HAVING COUNT(*)>1;
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
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-clone"></i> <?php echo __('Inmuebles duplicados'); ?></h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Inmuebles'); ?></th>
                                    <th><?php __('Tipo'); ?></th>
                                    <th><?php __('Operación'); ?></th>
                                    <th><?php __('Precio'); ?></th>
                                    <th><?php __('Habitaciones'); ?></th>
                                    <th><?php __('Aseos'); ?></th>
                                    <th><?php __('m2'); ?></th>
                                    <th><?php __('m2'); ?></th>
                                    <th><?php __('Ciudad'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    if ($totalRows_rsDuplicates > 0) {
                                    do { ?>
                                    <tr>
                                      <td><?php
                                      $ids = explode(',', $row_rsDuplicates['ids']);

                                      $i = 1;

                                      foreach ($ids as $id) {
                                          $theProp = explode('@@@', $id);
                                          mysqli_select_db($inmoconn,$database_inmoconn);
                                          $query_rsImage = "SELECT id_img FROM  properties_images WHERE  property_img = '".$theProp[0]."' ORDER BY order_img";
                                          $rsImage = mysqli_query($inmoconn,$query_rsImage) or die(mysqli_error());
                                          $row_rsImage = mysqli_fetch_assoc($rsImage);
                                          echo '<a href="/intramedianet/properties/properties-form.php?id_prop=' . $theProp[0] . '&KT_back=1" class="btn btn-soft-primary btn-sm float-end"><i class="fa fa-pencil"></i> ' . $theProp[1] . '</a>';
                                          if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsImage['id_img'].'_md.jpg')) {
                                              echo '<img src="/media/images/properties/thumbnails/'.$row_rsImage['id_img'].'_sm.jpg" alt="" style="height: 70px;">';
                                          } else {
                                              echo '<img src="/intramedianet/includes/assets/imgs/no_image.jpg" alt="" style="height: 70px;">';
                                          }
                                          if ($i++ < count($ids)) {
                                              echo "<hr>";
                                          }
                                      }

                                      ?></td>
                                      <td><?php
                                          $query_rsType = "SELECT types_" . $lang_adm . "_typ as type FROM  properties_types WHERE  id_typ = '".$row_rsDuplicates['tipo_prop']."'";
                                          $rsType = mysqli_query($inmoconn, $query_rsType) or die(mysqli_error());
                                          $row_rsType = mysqli_fetch_assoc($rsType);
                                          echo $row_rsType['type'] ?></td>
                                      <td><?php
                                          $query_rsStatus = "SELECT status_" . $lang_adm . "_sta as status FROM  properties_status WHERE  id_sta = '".$row_rsDuplicates['operacion_prop']."'";
                                          $rsStatus = mysqli_query($inmoconn,$query_rsStatus) or die(mysqli_error());
                                          $row_rsStatus = mysqli_fetch_assoc($rsStatus);
                                          echo $row_rsStatus['status'] ?></td>
                                      <td><?php echo number_format($row_rsDuplicates['preci_reducidoo_prop'], 0 , ',', '.') ?></td>
                                      <td><?php echo number_format($row_rsDuplicates['habitaciones_prop'], 0 , ',', '.') ?></td>
                                      <td><?php echo number_format($row_rsDuplicates['aseos_prop'], 0 , ',', '.') ?></td>
                                      <td><?php echo number_format($row_rsDuplicates['m2_prop'], 0 , ',', '.') ?></td>
                                      <td><?php echo number_format($row_rsDuplicates['m2_parcela_prop'], 0 , ',', '.') ?></td>
                                      <td><?php echo $row_rsDuplicates['loc']; ?></td>
                                    </tr>
                                    <?php } while ($row_rsDuplicates = mysqli_fetch_assoc($rsDuplicates));
                                        } ?>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
