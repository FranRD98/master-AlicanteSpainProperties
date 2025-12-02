<?php

session_start();

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

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

$retQRY = '';
$query_RS = "SELECT GROUP_CONCAT(property) as ids FROM cli_prop_int WHERE client = '".$_GET['id_cli']."' GROUP BY client";
$RS = mysqli_query($inmoconn, $query_RS) or die(mysqli_error());
$row_RS = mysqli_fetch_assoc($RS);
$totalRows_RS = mysqli_num_rows($RS);

 if ($row_RS['ids'] != '') {
     $retQRY .= ' AND id_prop IN ('.$row_RS['ids'].') ';
 } else {
     $retQRY .= ' AND id_prop IN (-1) ';
 }

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("7");
if ($isLoggedIn1->Execute()) {

    if($retQRY != '') {
        $retQRY .= ' AND atendido_por_cli = \''.$_SESSION['kt_login_id'].'\' ';
    } else {
        $retQRY .= ' AND user_prop = \''.$_SESSION['kt_login_id'].'\' ';
    }

    $retQRY = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $retQRY);

}



$currentPage = '/intramedianet/properties/properties-client-data-cli-int.php';

$maxRows_rsProperties2 = 5;
$pageNum_rsProperties2 = 0;
if (isset($_GET['pageNum_rsProperties']) && $_GET['pageNum_rsProperties'] != '') {
  $pageNum_rsProperties2 = $_GET['pageNum_rsProperties'];
  $_SESSION['pageNum_rsProperties2' . $_GET['id_cli']] = $_GET['pageNum_rsProperties'];
}
$startRow_rsProperties2 = $pageNum_rsProperties2 * $maxRows_rsProperties2;

$query_rsProperties2 = "

SELECT
    properties_properties.referencia_prop,
    properties_status.status_" .$lang_adm. "_sta,
    CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS types_" .$lang_adm. "_typ,
    CASE WHEN properties_loc2.name_" .$lang_adm. "_loc2 IS NOT NULL THEN properties_loc2.name_" .$lang_adm. "_loc2 ELSE province1.name_" .$lang_adm. "_loc2  END AS name_" .$lang_adm. "_loc2,
    CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS name_" .$lang_adm. "_loc3,
    CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS name_" .$lang_adm. "_loc4,
    preci_reducidoo_prop,
    precio_prop,
    precio_desde_prop,
    case properties_properties.activado_prop
        when '1' then '". __('Sí', true) . "'
        when '0' then '" . __('No', true) . "'
    end as activado_prop,
    properties_properties.id_prop,
    dropbox_prop,
    lat_long_gpp_prop,
    id_img,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    (SELECT rate FROM cli_prop_rate WHERE property = id_prop AND client = '" . $_GET['id_cli'] . "'   LIMIT 1) AS rate,
    (SELECT id FROM cli_prop_rate WHERE property = id_prop AND client = '" . $_GET['id_cli'] . "'   LIMIT 1) AS rateid,
    (SELECT pool_".$lang_adm."_pl FROM properties_pool WHERE id_pl = piscina_prop LIMIT 1 ) AS piscina_prop,
    (SELECT parking_".$lang_adm."_prk FROM properties_parking WHERE id_prk = parking_prop LIMIT 1 ) AS parking_prop,
    (SELECT id_log FROM properties_log_mails WHERE prop_id_log = id_prop AND email_log = '".$_GET['email']."' LIMIT 1) AS email,
    CONCAT_WS(' ', nombre_pro, apellidos_pro) as nombre_pro,
    entraga_date_prop,
    CONCAT_WS('<br>', telefono_fijo_pro, telefono_movil_pro) as telefono_fijo_pro


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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro

WHERE (id_prop IS NOT NULL OR id_prop != '')
$retQRY

GROUP BY id_prop

";
$query_limit_rsProperties2 = sprintf("%s LIMIT %d, %d", $query_rsProperties2, $startRow_rsProperties2, $maxRows_rsProperties2);
$rsProperties2 = mysqli_query($inmoconn, $query_limit_rsProperties2) or die(mysqli_error());
$row_rsProperties2 = mysqli_fetch_assoc($rsProperties2);

// if (isset($_GET['totalRows_rsProperties']) && $_GET['totalRows_rsProperties'] != '') {
//   $totalRows_rsProperties2 = $_GET['totalRows_rsProperties'];
//   $_SESSION['totalRows_rsProperties' . $_GET['id_cli']] = $_GET['totalRows_rsProperties'];
// } else {
  $all_rsProperties2 = mysqli_query($inmoconn, $query_rsProperties2) or die(mysqli_error());
  $totalRows_rsProperties2 = mysqli_num_rows($all_rsProperties2);
// }

$totalPages_rsProperties = ceil($totalRows_rsProperties2/$maxRows_rsProperties2)-1;

$queryString_rsProperties = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsProperties") == false &&
        stristr($param, "totalRows_rsProperties") == false /*&&
    stristr($param, "lang") == false &&
    stristr($param, "pag") == false*/) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsProperties = "&amp;" . htmlentities(implode("&", $newParams));
  }
}

$queryString_rsProperties .= sprintf("&amp;totalRows_rsProperties=%d", $totalRows_rsProperties2);

function getRate($id) {
    global $database_inmoconn, $inmoconn, $lang;

    $query_rsRat = "
        SELECT
          location,
          type,
          price,
          bedrooms,
          other
        FROM cli_prop_rate
        WHERE id = '" . $id . "'
    ";
    $rsRat = mysqli_query($inmoconn, $query_rsRat) or die(mysqli_error());
    $row_rsRat = mysqli_fetch_assoc($rsRat);

    echo "<p class=\"mb-0\">";
    if ($row_rsRat['location'] == 1) {
        echo "<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i> " . $lang['Localización'] . "&nbsp;&nbsp;&nbsp;";
    }
    if ($row_rsRat['type'] == 1) {
        echo "<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i> " . $lang['Tipo'] . "&nbsp;&nbsp;&nbsp;";
    }
    if ($row_rsRat['price'] == 1) {
        echo "<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i> " . $lang['Precio'] . "&nbsp;&nbsp;&nbsp;";
    }
    if ($row_rsRat['bedrooms'] == 1) {
        echo "<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i> " . $lang['Habitaciones'] . "&nbsp;&nbsp;&nbsp;";
    }
    if ($row_rsRat['other'] == 1) {
        echo "<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i> " . $lang['Otro'] . "&nbsp;&nbsp;&nbsp;";
    }
    echo "</p>";
}

do {
?>
<?php if ($row_rsProperties2['id_prop'] != ''): ?>
<div class="card">
    <div class="card-header bg-primary text-white pt-3 pb-2">
        <div class="card-title">
            <input type="checkbox" name="user" id="name<?php echo $row_rsProperties2['id_prop'] ?>" class="chklist" value="<?php echo $row_rsProperties2['id_prop'] ?>">
            &nbsp;
            <?php if ($row_rsProperties2['email'] != ''): ?>
            <i class="fa fa-envelope float-end" style="font-size: 24px;" aria-hidden="true"></i>
            <?php endif ?>
            ID: <?php echo $row_rsProperties2['id_prop'] ?> | <?php __('Ref.') ?>: <?php echo $row_rsProperties2['referencia_prop'] ?>
        </div>
    </div>
    <div class="panel-body p-3" style="<?php if ($row_rsProperties2['rate'] == 1 && $row_rsProperties2['rate'] != ''): ?>background-color: #bff6c2;<?php endif ?><?php if ($row_rsProperties2['rate'] == 0 && $row_rsProperties2['rate'] != ''): ?>background-color: #fceeee;<?php endif ?>">

        <?php if ($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsProperties2['id_img'].'_md.jpg'): ?>
            <a href="/media/images/properties/thumbnails/<?php echo $row_rsProperties2['id_img'] ?>_lg.jpg" data-toggle="lightbox"><img src="/media/images/properties/thumbnails/<?php echo $row_rsProperties2['id_img'] ?>_sm.jpg" alt="" style="max-height: 190px; float: right;" class="rounded"></a>
        <?php else: ?>
            <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="max-height: 190px; float: right;" class="rounded">
        <?php endif ?>

        <!-- <h2 style="margin: 0px; font-weight: 900;"><?php echo $row_rsProperties2['promotion_prop']; ?></h2> -->

        <h4 style="margin: 0px; font-weight: 600;"><?php echo $row_rsProperties2['name_' . $lang_adm . '_loc2']; ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $row_rsProperties2['name_' . $lang_adm . '_loc3']; ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $row_rsProperties2['name_' . $lang_adm . '_loc4']; ?></h4>

        <h5 style="margin: 10px 0 0; font-weight: 600;">
            <?php if ($row_rsProperties2['precio_desde_prop'] == 1): ?>
                <?php echo ucfirst(__('desde', true)); ?>:
            <?php endif ?>
            <?php if ($row_rsProperties2['precio_prop'] > 0): ?>
                <del class="text-danger"><?php echo number_format((int)$row_rsProperties2['precio_prop'], 0, ',', '.'); ?> €</del> |
            <?php endif ?>
            <div style="display: inline;">
                <?php echo number_format((int)$row_rsProperties2['preci_reducidoo_prop'], 0, ',', '.'); ?> €
            </div>
        </h5>

        <table class="mt-3">
          <tr>
            <?php if ($row_rsProperties2['habitaciones_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-baths.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties2['habitaciones_prop'], 0, ',', '.'); ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties2['aseos_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-beds.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties2['aseos_prop'], 0, ',', '.'); ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties2['m2_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-m2.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties2['m2_prop'], 0, ',', '.'); ?> m<sup>2</sup></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties2['m2_parcela_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-m2p.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties2['m2_parcela_prop'], 0, ',', '.'); ?> m<sup>2</sup></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties2['piscina_prop'] != ''): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-pool.png" alt="" style="height: 20px;">
                    <div><?php echo $row_rsProperties2['piscina_prop']; ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties2['parking_prop'] != ''): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-parking.png" alt="" style="height: 20px;">
                    <div><?php echo $row_rsProperties2['parking_prop']; ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties2['entraga_date_prop'] != ''): ?>
                <td class="text-center pe-5">
                    <i class="fa fa-calendar" aria-hidden="true" style="font-style: 20px;"></i>
                    <div><?php echo date('d-m-Y', strtotime($row_rsProperties2['entraga_date_prop'])); ?></div>
                </td>
            <?php endif ?>
          </tr>
        </table>

        <?php if (trim($row_rsProperties2['nombre_pro']) != ''): ?>
        <p class="mt-3"><?php __('Propietario') ?>: <strong style="font-weight: 900;"><?php echo $row_rsProperties2['nombre_pro']; ?></strong></p>
        <?php endif ?>

        <?php if ($row_rsProperties2['rateid'] > 0): ?>
            <?php getRate($row_rsProperties2['rateid']) ?>
        <?php endif ?>

    </div>
    <div class="card-footer bg-light">
        <a href="properties-form.php?id_prop=<?php echo $row_rsProperties2['id_prop'] ?>" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-fw fa-pencil"></i></a>
        <a href="<?php echo propURL($row_rsProperties2['id_prop'], $lang_adm); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-fw fa-eye"></i></a>
        <?php if ($row_rsProperties2['dropbox_prop'] != ''): ?>
        <a href="<?php echo $row_rsProperties2['dropbox_prop']; ?>" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-dropbox"></i></a>
        <?php endif ?>
        <?php if ($row_rsProperties2['lat_long_gpp_prop'] != ''): ?>
        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row_rsProperties2['lat_long_gpp_prop']; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-map-marker"></i></a>
        <?php endif ?>


        <a href="_update-client-props.php?act=add&sec=no&id_prop=<?php echo $row_rsProperties2['id_prop'] ?>&id_cli=<?php echo $_GET['id_cli'] ?>" target="_blank" class="btn btn-danger btn-sm float-end btn-clnt" style="margin: 0 0 0 10px;"><i class="fa fa-fw fa-times"></i></a>

        <a href="_update-client-props.php?act=pur&sec=si&id_prop=<?php echo $row_rsProperties2['id_prop'] ?>&id_cli=<?php echo $_GET['id_cli'] ?>" target="_blank" class="btn btn-info btn-sm float-end btn-clnt" style="margin: 0 0 0 10px;"><i class="fa fa-fw fa-eye"></i></a>
    </div>
</div>
<?php else: ?>
<br><br><br>
<p class="lead text-center"><?php __('No hay registros que mostrar'); ?></p>
<br><br>
<?php endif ?>
<?php
} while ($row_rsProperties2 = mysqli_fetch_assoc($rsProperties2));

if ($totalRows_rsProperties2 > 0) {

    echo '<div class="row">';
        // echo '<div class="col-md-1">';
        // if ($totalPages_rsProperties > 1) {
        //     echo '<select name="unprocessedsel" id="unprocessedsel" class="form-control" style="display: inline-block !important;">';
        //     for ($i=1; $i <= ($totalPages_rsProperties+1); $i++) {
        //       $sel = (($i-1) == $_GET['pageNum_rsProperties'])?' selected':'';
        //         echo '<option value="' . $currentPage . '?pageNum_rsProperties=' . ($i-1) . '' . $queryString_rsProperties . '"' . $sel . '>' . $i . '</option>';
        //     }
        //     echo '</select>';
        // }
        // echo '</div>';
        echo '<div class="col-md-7">';
            if ($totalPages_rsProperties > 0) {
                echo "<ul class=\"pagination pagination-sm\" style=\"margin-top: 0!important; pading-top: 0!important;\">";
                  if ($pageNum_rsProperties2 > 0) { // Show if not first page
                      echo '<li class="page-item"><a class="page-link unprocessed-links-int" href="' . $currentPage . '?pageNum_rsProperties=0' . $queryString_rsProperties . '"><i class="fa fa-angle-double-left" aria-hidden="true"></i> ' . $lang['Primero'] . '</a></li>';
                  } // Show if not first page
                  if ($pageNum_rsProperties2 > 0) { // Show if not first page
                      echo '<li class="page-item"><a class="page-link unprocessed-links-int" href="' . $currentPage . '?pageNum_rsProperties=' . max(0, $pageNum_rsProperties2 - 1) . '' . $queryString_rsProperties . '"><i class="fa fa-angle-left" aria-hidden="true"></i> ' . $lang['Anterior'] . '</a></li>';
                  } // Show if not first page
                  if ($pageNum_rsProperties2 < $totalPages_rsProperties) { // Show if not last page
                      echo '<li class="page-item"><a class="page-link unprocessed-links-int" href="' . $currentPage . '?pageNum_rsProperties=' . min($totalPages_rsProperties, $pageNum_rsProperties2 + 1) . '' . $queryString_rsProperties . '">' . $lang['Siguiente'] . ' <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
                  } // Show if not last page
                  if ($pageNum_rsProperties2 < $totalPages_rsProperties) { // Show if not last page
                      echo '<li class="page-item"><a class="page-link unprocessed-links-int" href="' . $currentPage . '?pageNum_rsProperties=' . ''. $totalPages_rsProperties . '' . $queryString_rsProperties . '">' . $lang['Último'] . ' <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
                  } // Show if not last page
                echo "</ul>";
            }
        echo '</div>';
        echo '<div class="col-md-5">';
            echo '<div class="text-end">' . $lang['Inmuebles'] . ' ' .$lang['de_a_de_totales'][1] . ' ' .($startRow_rsProperties2 + 1) . ' ' .$lang['de_a_de_totales'][2] . ' ' .min($startRow_rsProperties2 + $maxRows_rsProperties2, $totalRows_rsProperties2) . ' ' .$lang['de_a_de_totales'][3] . ' ' .$totalRows_rsProperties2 . ' ' .$lang['de_a_de_totales'][4] . '</div>';
        echo '</div>';
    echo '</div>';

    ?>
    <script>
        var $pageNum_rsProperties2 = '<?php echo $_SESSION['pageNum_rsProperties2' . $_GET['id_cli']] ?>';
        var $totalRows_rsProperties2 = '<?php echo $_SESSION['totalRows_rsProperties2' . $_GET['id_cli']] ?>';
    </script>
    <?php

}


