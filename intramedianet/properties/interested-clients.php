<?php

// Cargamos la conexión a MySql
include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// Cargamos los idiomas de la administración
include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');

// Load the common classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

// Load the tNG classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

// Load the KT_back class
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

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
$restrict->Execute();
//End Restrict Access To Page

//
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

$sWhere = ' WHERE  archived_cli = 0 ';

$currentPage = '/intramedianet/properties/interested-clients.php';

$maxRows_rsClients = 5;
$pageNum_rsClients = 0;
if (isset($_GET['pageNum_rsClients'])) {
  $pageNum_rsClients = $_GET['pageNum_rsClients'];
}
$startRow_rsClients = $pageNum_rsClients * $maxRows_rsClients;

$query_rsClients = "SELECT * FROM properties_client $sWhere ORDER BY id_cli DESC";
// $query_limit_rsClients = sprintf("%s LIMIT %d, %d", $query_rsClients, $startRow_rsClients, $maxRows_rsClients);
// $rsClients = mysqli_query($query_limit_rsClients) or die(mysqli_error());
$rsClients = mysqli_query($inmoconn, $query_rsClients) or die(mysqli_error());
$row_rsClients = mysqli_fetch_assoc($rsClients);
$totalRows_rsClients = mysqli_num_rows($rsClients);

if (isset($_GET['totalRows_rsClients'])) {
  $totalRows_rsClients = $_GET['totalRows_rsClients'];
} else {
  $all_rsClients = mysqli_query($inmoconn,$query_rsClients);
  $totalRows_rsClients = mysqli_num_rows($all_rsClients);
}
$totalPages_rsClients = ceil($totalRows_rsClients/$maxRows_rsClients)-1;

$queryString_rsClients = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsClients") == false &&
        stristr($param, "totalRows_rsClients") == false &&
        stristr($param, "lang") == false &&
        stristr($param, "pag") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsClients = "&amp;" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsClients .= sprintf("&amp;totalRows_rsClients=%d", $totalRows_rsClients);

$locationGet = ($_GET['loc'] != '')?$_GET['loc']:'0';

$query_rsLocations = "
SELECT
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id_loc3
    FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
WHERE CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END = " . $locationGet . "
";
$rsLocations = mysqli_query($inmoconn, $query_rsLocations) or die(mysqli_error());
$row_rsLocations = mysqli_fetch_assoc($rsLocations);
$totalRows_rsLocations = mysqli_num_rows($rsLocations);

$clients = array();

do {
    $fail = false;

    $score = 0;

    if ($row_rsClients['b_sale_cli'] != '') {
        $vals = explode(',', $row_rsClients['b_sale_cli']);
        if (in_array($_GET['ope'], $vals)) {
            $score = $score +1;
        }
    }

    if ($row_rsClients['b_type_cli'] != '') {
        $vals = explode(',', $row_rsClients['b_type_cli']);
        if (in_array($_GET['typ'], $vals)) {
            $score = $score +1;
        }
    }

    // if ($_GET['hab'] >= $row_rsClients['b_beds_cli']) {
    //     $score = $score +1;
    // }

    if (($row_rsClients['b_precio_desde_cli'] != '' && $_GET['pre'] >= $row_rsClients['b_precio_desde_cli']) || ($row_rsClients['b_precio_hasta_cli'] != '' && $_GET['pre'] <= $row_rsClients['b_precio_hasta_cli'])) {
        $score = $score +2;
    }

    if ($row_rsClients['b_precio_desde_cli'] != '' && $row_rsClients['b_precio_hasta_cli'] != '') {
        if ($_GET['pre'] >= $row_rsClients['b_precio_desde_cli'] && $_GET['pre'] <= $row_rsClients['b_precio_hasta_cli']) {
        } else {
            $fail = true;
        }
    }

    if ($row_rsClients['b_precio_desde_cli'] == '' && $row_rsClients['b_precio_hasta_cli'] != '') {
        if ($_GET['pre'] <= $row_rsClients['b_precio_hasta_cli']) {
        } else {
            $fail = true;
        }
    }

    if ($row_rsClients['b_loc3_cli'] != '') {
        $vals = explode(',', $row_rsClients['b_loc3_cli']);
        if (in_array($row_rsLocations['id_loc3'], $vals)) {
            $score = $score +1;
        }
    }

    // if ($row_rsClients['b_loc4_cli'] != '') {
    //  $vals = explode(',', $row_rsClients['b_loc4_cli']);
    //  if (in_array($row_rsLocations['id_loc4'], $vals)) {
    //      $score = $score +1;
    //  }
    // }

    if ($score > 0 && $fail != true) {
        array_push($clients, array('score'=>$score, 'name'=>$row_rsClients['nombre_cli'] . ' ' . $row_rsClients['apellidos_cli'], 'direccion'=>$row_rsClients['direccion_cli'], 'telefono'=>$row_rsClients['telefono_fijo_cli'], 'movil'=>$row_rsClients['telefono_movil_cli'], 'email'=>$row_rsClients['email_cli'], 'skype'=>$row_rsClients['skype_cli'], 'alta'=>$row_rsClients['fecha_alta_cli'], 'id'=>$row_rsClients['id_cli'], 'b_sale_cli'=>$row_rsClients['b_sale_cli'], 'b_beds_cli'=>$row_rsClients['b_beds_cli'], 'b_baths_cli'=>$row_rsClients['b_baths_cli'], 'b_type_cli'=>$row_rsClients['b_type_cli'], 'b_loc1_cli'=>$row_rsClients['b_loc1_cli'], 'b_loc2_cli'=>$row_rsClients['b_loc2_cli'], 'b_loc3_cli'=>$row_rsClients['b_loc3_cli'], 'b_loc4_cli'=>$row_rsClients['b_loc4_cli'], 'b_ref_cli'=>$row_rsClients['b_ref_cli'], 'b_precio_desde_cli'=>$row_rsClients['b_precio_desde_cli'], 'b_precio_hasta_cli'=>$row_rsClients['b_precio_hasta_cli'], 'idioma_cli'=>$row_rsClients['idioma_cli'], 'telefono_fijo_cli'=>$row_rsClients['telefono_fijo_cli']));
    }
} while ($row_rsClients = mysqli_fetch_assoc($rsClients));

arsort($clients);

?>
<?php /* ?>
<div class="paginacion clearfix">
    <?php if ($totalPages_rsClients > 0) { ?>

    <p><?php __('Clientes'); ?> <?php __('del'); ?> <?php echo ($startRow_rsClients + 1) ?> <?php __('al'); ?> <?php echo min($startRow_rsClients + $maxRows_rsClients, $totalRows_rsClients) ?> <?php __('de'); ?> <?php echo $totalRows_rsClients ?></p>

    <ul class="pagination">
        <?php if ($pageNum_rsClients > 0) { // Show if not first page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, 0, $queryString_rsClients); ?>">&lt;&lt; <?php echo $lang['primero'] ?></a></li>
        <?php } // Show if not first page ?>
        <?php if ($pageNum_rsClients > 0) { // Show if not first page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, max(0, $pageNum_rsClients - 1), $queryString_rsClients); ?>">&lt; <?php echo $lang['anterior'] ?></a></li>
        <?php } // Show if not first page ?>
        <?php if ($pageNum_rsClients < $totalPages_rsClients) { // Show if not last page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, min($totalPages_rsClients, $pageNum_rsClients + 1), $queryString_rsClients); ?>"><?php echo $lang['siguiente'] ?> &gt;</a></li>
        <?php } // Show if not last page ?>
        <?php if ($pageNum_rsClients < $totalPages_rsClients) { // Show if not last page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, $totalPages_rsClients, $queryString_rsClients); ?>"><?php echo $lang['ultimo'] ?> &gt;&gt;</a></li>
        <?php } // Show if not last page ?>
    </ul>

    <?php } ?>
</div>
<?php */ ?>
<?php

foreach ($clients as $key => $value) {
    if (round(($value['score']*100)/5) > 30) {

        echo '<div class="alert bg-light py-2 mt-2" role="alert">';

            echo '<div class="row">';

                echo '<div class="col-md-6">';

                    echo '<p><i class="fa-regular fa-user me-1"></i> ' . $value['name'] . '</p>';

                    if ($value['email'] != '') {
                        echo '<p class="mt-3"><i class="fa-regular fa-envelope me-1"></i> ' . $value['email'] . '</p>';
                    }

                    if ($value['telefono'] != '') {
                        echo '<p class="mt-3"><i class="fa-regular fa-phone me-1"></i> ' . $value['telefono'] . '</p>';
                    }

                    if ($value['movil'] != '') {
                        echo '<p class="mt-3"><i class="fa-regular fa-phone me-1"></i> ' . $value['movil'] . '</p>';
                    }

                    if ($value['direccion'] != '') {
                        echo '<p class="mt-3"><i class="fa-regular fa-location-dot me-1"></i> ' . $value['direccion'] . '</p>';
                    }

                    if ($value['skype'] != '') {
                        echo '<p class="mt-3"><i class="fa-brands fa-skype me-1"></i> ' . $value['skype'] . '</p>';
                    }

                    if ($value['alta'] != '') {
                        echo '<p class="mt-3"><i class="fa-regular fa-calendar-circle-plus me-1"></i> ' . date("d-m-Y", strtotime($value['alta'])) . '</p>';
                    }

                    $ret = '';

                    if ($value['b_sale_cli'] != '') {
                        
                        $query_rsValues = "SELECT status_".$lang_adm."_sta as name FROM properties_status WHERE id_sta IN (".$value['b_sale_cli'].") ORDER BY status_".$lang_adm."_sta ASC";
                        $rsValues = mysqli_query($inmoconn,$query_rsValues) or die(mysqli_error());
                        $row_rsValues = mysqli_fetch_assoc($rsValues);

                        $arrayVals = array();

                        do {
                            array_push($arrayVals, $row_rsValues['name']);
                        } while ($row_rsValues = mysqli_fetch_assoc($rsValues));

                        $ret .= ' <b>'.__('Operaciones', true). ':</b> ' . implode(', ', $arrayVals) . '';
                    }

                    if ($value['b_type_cli'] != '') {
                        
                        $query_rsValues = "SELECT types_".$lang_adm."_typ as name FROM properties_types WHERE id_typ IN (".$value['b_type_cli'].") ORDER BY types_".$lang_adm."_typ ASC";
                        $rsValues = mysqli_query($inmoconn,$query_rsValues) or die(mysqli_error());
                        $row_rsValues = mysqli_fetch_assoc($rsValues);

                        $arrayVals = array();

                        do {
                            array_push($arrayVals, $row_rsValues['name']);
                        } while ($row_rsValues = mysqli_fetch_assoc($rsValues));

                        mysqli_free_result($rsValues);

                        $ret .= ' | <b>'.__('Tipos', true). ':</b> ' . implode(', ', $arrayVals) . '';
                    }

                    if ($value['b_loc1_cli'] != '') {
                        
                        $query_rsValues = "SELECT name_".$lang_adm."_loc1 as name FROM properties_loc1 WHERE id_loc1 IN (".$value['b_loc1_cli'].") ORDER BY name_".$lang_adm."_loc1 ASC";
                        $rsValues = mysqli_query($inmoconn,$query_rsValues) or die(mysqli_error());
                        $row_rsValues = mysqli_fetch_assoc($rsValues);

                        $arrayVals = array();

                        do {
                            array_push($arrayVals, $row_rsValues['name']);
                        } while ($row_rsValues = mysqli_fetch_assoc($rsValues));

                        mysqli_free_result($rsValues);

                        $ret .= ' | <b>'.__('País', true). ':</b> ' . implode(', ', $arrayVals) . '';
                    }

                    if ($value['b_loc2_cli'] != '') {
                        
                        $query_rsValues = "SELECT name_".$lang_adm."_loc2 as name FROM properties_loc2 WHERE id_loc2 IN (".$value['b_loc2_cli'].") ORDER BY name_".$lang_adm."_loc2 ASC";
                        $rsValues = mysqli_query($inmoconn,$query_rsValues) or die(mysqli_error());
                        $row_rsValues = mysqli_fetch_assoc($rsValues);

                        $arrayVals = array();

                        do {
                            array_push($arrayVals, $row_rsValues['name']);
                        } while ($row_rsValues = mysqli_fetch_assoc($rsValues));

                        mysqli_free_result($rsValues);

                        $ret .= ' | <b>'.__('Provincias', true). ':</b> ' . implode(', ', $arrayVals) . '';
                    }

                    if ($value['b_loc3_cli'] != '') {
                        
                        $query_rsValues = "SELECT name_".$lang_adm."_loc3 as name FROM properties_loc3 WHERE id_loc3 IN (".$value['b_loc3_cli'].") ORDER BY name_".$lang_adm."_loc3 ASC";
                        $rsValues = mysqli_query($inmoconn,$query_rsValues) or die(mysqli_error());
                        $row_rsValues = mysqli_fetch_assoc($rsValues);

                        $arrayVals = array();

                        do {
                            array_push($arrayVals, $row_rsValues['name']);
                        } while ($row_rsValues = mysqli_fetch_assoc($rsValues));

                        $ret .= ' | <b>'.__('Ciudades', true). ':</b> ' . implode(', ', $arrayVals) . '';
                    }

                    if ($value['b_loc4_cli'] != '') {
                        
                        $query_rsValues = "SELECT name_".$lang_adm."_loc4 as name FROM properties_loc4 WHERE id_loc4 IN (".$value['b_loc4_cli'].") ORDER BY name_".$lang_adm."_loc4 ASC";
                        $rsValues = mysqli_query($inmoconn,$query_rsValues) or die(mysqli_error());
                        $row_rsValues = mysqli_fetch_assoc($rsValues);

                        $arrayVals = array();

                        do {
                            array_push($arrayVals, $row_rsValues['name']);
                        } while ($row_rsValues = mysqli_fetch_assoc($rsValues));

                        mysqli_free_result($rsValues);

                        $ret .= ' | <b>'.__('Zonas', true). ':</b> ' . implode(', ', $arrayVals) . '';
                    }

                    if ($value['b_beds_cli'] != '') {
                        $ret .= ' | <b>'.__('Habitaciones', true). ':</b> ' . $value['b_beds_cli'] . '';
                    }

                    if ($value['b_baths_cli'] != '') {
                        $ret .= ' | <b>'.__('Aseos', true). ':</b> ' . $value['b_baths_cli'] . '';
                    }

                    if ($value['b_precio_desde_cli'] != '') {
                        $ret .= ' | <b>'.__('Precio desde', true). ':</b> ' . $value['b_precio_desde_cli'] . '';
                    }

                    if ($value['b_precio_hasta_cli'] != '') {
                        $ret .= ' | <b>'.__('Precio hasta', true). ':</b> ' . $value['b_precio_hasta_cli'] . '';
                    }

                    if ($value['b_ref_cli'] != '') {
                        $refArray = explode(',', $value['b_ref_cli']);
                        $refArrayVals = array();

                        foreach ($refArray as $key => $value) {
                            array_push($refArrayVals, "'".$refElement."'");
                        }

                        
                        $query_rsValues = "SELECT referencia_prop as name FROM properties_properties WHERE referencia_prop IN (".implode(',', $refArrayVals).") ORDER BY referencia_prop ASC";
                        $rsValues = mysqli_query($inmoconn,$query_rsValues) or die(mysqli_error());
                        $row_rsValues = mysqli_fetch_assoc($rsValues);

                        $arrayVals = array();

                        do {
                            array_push($arrayVals, $row_rsValues['name']);
                        } while ($row_rsValues = mysqli_fetch_assoc($rsValues));

                        mysqli_free_result($rsValues);

                        $ret .= ' | <b>'.__('Referencias', true). ':</b> ' . implode(', ', $arrayVals) . '<br>';
                    }

                echo '</div>';

                echo '<div class="col-md-6">';

                    echo '<div class="border rounded bg-white mt-1 p-3"><p class="m-0"><i class="fa-regular fa-magnifying-glass me-1"></i> ' . $ret . '</p></div><br>';

                    // echo '<p class="m-0 text-uppercase"><b>'.__('Porcentaje de acierto', true).': ' . round(($value['score']*100)/5) . '%</b></p>';

                    echo '<div class="d-flex align-items-center pb-4 mt-1">';
                        echo '<div class="flex-grow-1">';
                            echo '<div class="progress animated-progress custom-progress progress-label bg-white" style="height: 20px;">';
                                echo '<div class="progress-bar bg-primary" role="progressbar" style="width: ' . round(($value['score']*100)/5) . '%; height: 10px;" aria-valuenow="' . round(($value['score']*100)/5) . '" aria-valuemin="0" aria-valuemax="100">';
                                    echo '<div class="label">' . round(($value['score']*100)/5) . '%</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                    echo '<p class="mb-4"><a href="/intramedianet/properties/clients-form.php?id_cli='.$value['id'].'&KT_back=1" target="_blank" class="btn btn-success w-100"><i class="fa-regular fa-eye me-1"></i> '.__('Mostra cliente', true).'</a></p>';

                    if ($value['idioma_cli'] != '') {
                        $langCli = $value['idioma_cli'];
                    } else {
                        $langCli = $language;
                    }

                    if ($value['telefono_fijo_cli'] != '') {

                    echo "<div class=\"row\">";

                    echo "<div class=\"col-md-6\">";
                    }
                        echo '<a href="#" class="btn btn-primary w-100 btnsend" data-email="' . $value['email'] . '" data-lang="' . $langCli . '"><i class="fa-regular fa-paper-plane me-1"></i> '.  __('Enviar', true) .' '.  __('Inmueble', true) .'</a>';

                    if ($value['telefono_fijo_cli'] != '') {
                    echo "</div>";

                    echo "<div class=\"col-md-6\">";
                        echo '<a href="https://wa.me/' . $value['telefono_fijo_cli'] . '/?text=https://' . $_SERVER['HTTP_HOST'] . propURL($_GET['idpr'], $lang_adm) . '" class="btn btn-success w-100 mt-4 mt-md-0" target="blank"><i class="fa-brands fa-whatsapp me-1"></i> '.  __('Whatsapp', true) .'</a>';
                    echo "</div>";

                    echo "</div>";
                    }

                echo '</div>';

            echo '</div>';

        echo '</div>';
    }
}

// echo "<pre>";
// print_r($clients);
// echo "</pre>";

?>
<?php /* ?>
<div class="paginacion clearfix">
    <?php if ($totalPages_rsClients > 0) { ?>
    <ul class="pagination">
        <?php if ($pageNum_rsClients > 0) { // Show if not first page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, 0, $queryString_rsClients); ?>">&lt;&lt; <?php echo $lang['primero'] ?></a></li>
        <?php } // Show if not first page ?>
        <?php if ($pageNum_rsClients > 0) { // Show if not first page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, max(0, $pageNum_rsClients - 1), $queryString_rsClients); ?>">&lt; <?php echo $lang['anterior'] ?></a></li>
        <?php } // Show if not first page ?>
        <?php if ($pageNum_rsClients < $totalPages_rsClients) { // Show if not last page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, min($totalPages_rsClients, $pageNum_rsClients + 1), $queryString_rsClients); ?>"><?php echo $lang['siguiente'] ?> &gt;</a></li>
        <?php } // Show if not last page ?>
        <?php if ($pageNum_rsClients < $totalPages_rsClients) { // Show if not last page ?>
            <li class="page-item"><a class="page-link cruce-nav" href="<?php printf("%s?pageNum_rsClients=%d%s", $currentPage, $totalPages_rsClients, $queryString_rsClients); ?>"><?php echo $lang['ultimo'] ?> &gt;&gt;</a></li>
        <?php } // Show if not last page ?>
    </ul>

    <p><?php __('Clientes'); ?> <?php __('del'); ?> <?php echo ($startRow_rsClients + 1) ?> <?php __('al'); ?> <?php echo min($startRow_rsClients + $maxRows_rsClients, $totalRows_rsClients) ?> <?php __('de'); ?> <?php echo $totalRows_rsClients ?></p>

    <?php } ?>
</div>
<?php */ ?>
