<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

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

$op = '';
$opjoin = '';
if( isset($_GET['b_opciones_cli']) && $_GET['b_opciones_cli'][0] != '' ){
    $opciones = implode(',', $_GET['b_opciones_cli']);
    if ($opciones != '') {
        $op = "AND properties_property_feature.feature IN (" . $opciones . ")";
        $opjoin = "INNER JOIN properties_property_feature ON properties_properties.id_prop = properties_property_feature.property";
    }
}

$op2 = '';
$opjoin2 = '';
if( isset($_GET['b_opciones2_cli']) && $_GET['b_opciones2_cli'][0] != '' ){
    $opciones2 = implode(',', $_GET['b_opciones2_cli']);
    if ($opciones2 != '') {
        $op2 = "AND properties_property_feature_priv.feature IN (" . $opciones2 . ")";
        $opjoin2 = "INNER JOIN properties_property_feature_priv ON properties_properties.id_prop = properties_property_feature_priv.property";
    }
}

$tags = '';
$tagjoin = '';
if( isset($_GET['b_tags_cli']) && $_GET['b_tags_cli'][0] != '' ){

    if (count($_GET['b_tags_cli']) == 1) {
        $opciones2 = implode(',', $_GET['b_tags_cli']);
        $tags = "AND properties_property_tag.tag IN (" . $opciones2 . ")";
        $tagjoin = "INNER JOIN properties_property_tag ON properties_properties.id_prop = properties_property_tag.property";
    } else {
      foreach ($_GET['b_tags_cli'] as $tag) {
          $tags .= "AND (SELECT property FROM properties_property_tag WHERE tag = '".$tag."' AND property = id_prop) = id_prop ";
      }
    }
}

$st = '';
if( isset($_GET['b_sale_cli']) && $_GET['b_sale_cli'][0] != '' ){
    $status = implode(',', $_GET['b_sale_cli']);
    if ($status != '') {
        $st = "AND operacion_prop IN (" . $status . ")";
    }
}

$ty = '';
if( isset($_GET['b_type_cli']) && $_GET['b_type_cli'][0] != '' ){
    $type = implode(',', $_GET['b_type_cli']);
    if ($type != '') {
        $ty = "AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . $type . ")";
    }
}

$bd = '';
if( isset($_GET['b_beds_cli']) && $_GET['b_beds_cli'] != '' ){
    $bd = "AND habitaciones_prop >= " . $_GET['b_beds_cli'];
}

$bt = '';
if( isset($_GET['b_baths_cli']) && $_GET['b_baths_cli'] != '' ){
    $bt = "AND aseos_prop >= " . $_GET['b_baths_cli'];
}

$ref = '';
if( isset($_GET['b_ref_cli']) && $_GET['b_ref_cli'][0] != '' ){
    $refs = array();
    foreach ($_GET['b_ref_cli'] as $value) {
      array_push($refs, "'".$value."'");
    }
    $reference = implode(',', $refs);
    if ($reference != '') {
        $ref = "AND referencia_prop IN (" . $reference . ")";
    }
}

$prd = '';
if( isset($_GET['b_precio_desde_cli']) && $_GET['b_precio_desde_cli'] != '' ){
    $prd = "AND preci_reducidoo_prop >= " . $_GET['b_precio_desde_cli'];
}

$prh = '';
if( isset($_GET['b_precio_hasta_cli']) && $_GET['b_precio_hasta_cli'] != '' ){
$prh = "AND preci_reducidoo_prop <= " . $_GET['b_precio_hasta_cli'];
}

$or = '';
if( isset($_GET['or']) && $_GET['or'] != '' ){
$or = "AND orientacion_prop = '" . $_GET['or'] . "'";
}


//  ============================================================================
//  === M2 ÚTILES                                                            ===
//  ============================================================================

$m2ut = '';
if(isset($_GET['m2ut'])&&$_GET['m2ut']==0){
  $m2ut = "AND 1=1";
}
else if(isset($_GET['m2ut'])&&$_GET['m2ut']==1){
  $m2ut = "AND ((m2_prop <= 90 AND m2_prop != 0))";
}
else if(isset($_GET['m2ut'])&&$_GET['m2ut']==2){
  $m2ut = "AND ((m2_prop >= 90 AND m2_prop <= 120 AND m2_prop != 0))";
}
else if(isset($_GET['m2ut'])&&$_GET['m2ut']==3){
  $m2ut = "AND ((m2_prop >= 120 AND m2_prop <= 200 AND m2_prop != 0))";
}
else if(isset($_GET['m2ut'])&&$_GET['m2ut']==4){
  $m2ut = "AND ((m2_prop >= 200 AND m2_prop != 0))";
}

//  ============================================================================
//  === M2 PARCELA                                                           ===
//  ============================================================================

$m2pl = '';
if(isset($_GET['m2pl'])&&$_GET['m2pl']==0){
  $m2pl = "AND 1=1";
}
else if(isset($_GET['m2pl'])&&$_GET['m2pl']==1){
  $m2pl = "AND ((m2_parcela_prop <= 1000 AND m2_parcela_prop != 0))";
}
else if(isset($_GET['m2pl'])&&$_GET['m2pl']==2){
  $m2pl = "AND ((m2_parcela_prop >= 1000 AND m2_parcela_prop <= 2000))";
}
else if(isset($_GET['m2pl'])&&$_GET['m2pl']==3){
  $m2pl = "AND ((m2_parcela_prop >= 2000 AND m2_parcela_prop <= 5000))";
}
else if(isset($_GET['m2pl'])&&$_GET['m2pl']==4){
  $m2pl = "AND ((m2_parcela_prop >= 5000 AND m2_parcela_prop <= 10000))";
}
else if(isset($_GET['m2pl'])&&$_GET['m2pl']==5){
  $m2pl = "AND ((m2_parcela_prop >= 10000 AND m2_parcela_prop <= 20000))";
}
else if(isset($_GET['m2pl'])&&$_GET['m2pl']==6){
  $m2pl = "AND ((m2_parcela_prop >= 20000))";
}

$or2 = '';
if( isset($_GET['b_orientacion_cli']) && $_GET['b_orientacion_cli'] != '' ){
  $or2 = "AND orientacion_prop = '" . $_GET['b_orientacion_cli'] . "'";
}

$loc4 = '';
if( isset($_GET['b_loc4_cli']) && $_GET['b_loc4_cli'] != '' ){
    $zone = implode(',', $_GET['b_loc4_cli']);
    if ($zone != '') {
        $loc4 = "AND (properties_loc4.id_loc4 IN (" . $zone . ") OR properties_loc4.parent_loc4 IN (" . $zone . ") OR towns.id_loc4 IN (" . $zone . ") OR towns.parent_loc4 IN (" . $zone . ")) ";
 }
}


$loc3 = '';
if( isset($_GET['b_loc3_cli']) && $_GET['b_loc3_cli'] != '' ){
    $location = implode(',', $_GET['b_loc3_cli']);
    if ($location != '') {
        $loc3 = "AND (properties_loc3.id_loc3 IN (" . $location . ") OR properties_loc3.parent_loc3 IN (" . $location . ") OR areas1.id_loc3 IN (" . $location . ") OR areas1.parent_loc3 IN (" . $location . ")) ";
    }
}

$loc2 = '';
if( isset($_GET['b_loc2_cli']) && $_GET['b_loc2_cli'] != '' ){
    $province = implode(',', $_GET['b_loc2_cli']);
    if ($province != '') {
        $loc2 = "AND (properties_loc2.id_loc2 IN (" . $province . ") OR properties_loc2.parent_loc2 IN (" . $province . ") OR province1.id_loc2 IN (" . $province . ") OR province1.parent_loc2 IN (" . $province . ")) ";
    }
}

$loc1 = '';
if( isset($_GET['b_loc1_cli']) && $_GET['b_loc1_cli'] != '' ){
    $location = implode(',', $_GET['b_loc1_cli']);
    if ($location != '') {
        $loc1 = "AND id_loc1 IN (" . $location . ")";
    }
}



$fav = '';
if( isset($_GET['favs']) && $_GET['favs'] != '' ){
    $favs = array();
    foreach ($_GET['favs'] as $value) {
      array_push($favs, "'".$value."'");
    }
    $faverence = implode(',', $favs);
    if ($faverence != '') {
        $fav = "OR referencia_prop IN (" . $faverence . ")";
    }
}

$ocultos = '';
if( isset($_GET['b_ocultos_cli']) && $_GET['b_ocultos_cli'] != '' ){
    $ocultos = array();
    foreach ($_GET['b_ocultos_cli'] as $value) {
      array_push($ocultos, "'".$value."'");
    }
    $faverence = implode(',', $ocultos);
    if ($faverence != '') {
        $ocultos = "AND referencia_prop NOT IN (" . $faverence . ")";
    }
}

$nw = '';
if( isset($_GET['nw']) && $_GET['nw'] == 1 ){
    $nw = "AND nuevo_prop >= CURDATE()";
}
if( isset($_GET['nw']) && $_GET['nw'] == '0' ){
    $nw = "AND (nuevo_prop <= CURDATE() OR nuevo_prop = '' OR nuevo_prop IS NULL)";
}

$ven = '';
if( isset($_GET['ven']) && $_GET['ven'] != '' ){
    $ven = "AND vendido_prop = " . $_GET['ven'];
}

$alq = '';
if( isset($_GET['alq']) && $_GET['alq'] != '' ){
    $alq = "AND alquilado_prop = " . $_GET['alq'];
}

$res = '';
if( isset($_GET['res']) && $_GET['res'] != '' ){
    $res = "AND reservado_prop = " . $_GET['res'];
}

$rp = '';
if( isset($_GET['rp']) && $_GET['rp'] != '' ){
    $rp = "AND reducido_prop = 1";
}

$cs = '';
if( isset($_GET['cs']) && $_GET['cs'] != '' ){
    $cs = "AND cerca_mar_prop = " . $_GET['cs'];
}

$sw = '';
if( isset($_GET['sw']) && $_GET['sw'] != '' ){
    $sw = "AND vistas_mar_prop = " . $_GET['sw'];
}

$ep = '';
if( isset($_GET['ep']) && $_GET['ep'] != '' ){
    $ep = "AND exclusivo_prop = " . $_GET['ep'];
}

$po = '';
if( isset($_GET['po']) && $_GET['po'] != '' ){
    $po = "AND piscina_prop = " . $_GET['po'];
}

$rps = '';
if( isset($_GET['rps']) && $_GET['rps'] != '' ){
    $rps = "AND embargo_prop = " . $_GET['rps'];
}

$dir = '';
if( isset($_GET['direccion']) && $_GET['direccion'] != '' ){
    $dir = "AND direccion_prop LIKE '%" . $_GET['direccion']."%'";
}

$pool = '';
if( isset($_GET['b_pool_cli']) && $_GET['b_pool_cli'][0] != '' ){
  $pools = array();
  foreach ($_GET['b_pool_cli'] as $value) {
    array_push($pools, "'".$value."'");
  }
  $poolsids = implode(',', $pools);
  if ($poolsids != '') {
      $pool = "AND piscina_prop IN (" . $poolsids . ")";
  }
}

$parking = '';
if( isset($_GET['b_parking_cli']) && $_GET['b_parking_cli'][0] != '' ){
  $parkings = array();
  foreach ($_GET['b_parking_cli'] as $value) {
    array_push($parkings, "'".$value."'");
  }
  $parkingsids = implode(',', $parkings);
  if ($parkingsids != '') {
      $parking = "AND parking_prop IN (" . $parkingsids . ")";
  }
}

$palabras_clave = '';
if( isset($_GET['palabras_clave']) && $_GET['palabras_clave'] != '' ){
    if(count(explode(" ",mysql_real_escape_string($_GET['palabras_clave']))) == 1)
        $palabras_clave = "AND (properties_properties.descripcion_nl_prop LIKE '%" . mysql_real_escape_string($_GET['palabras_clave'])."%' OR titulo_nl_prop LIKE '%" . mysql_real_escape_string($_GET['palabras_clave'])."%')";
    else
        $palabras_clave = " AND MATCH(properties_properties.descripcion_nl_prop, titulo_nl_prop) AGAINST ('".mysql_real_escape_string($_GET['palabras_clave'])."' IN BOOLEAN MODE)";
}

$nprop = '';
if( !isset($_GET['b_sale_cli']) && !isset($_GET['b_type_cli']) && $_GET['b_beds_cli'] == '' && $_GET['or'] == '' && $_GET['b_orientacion_cli'] == '' && $_GET['favs'] == '' && $_GET['b_baths_cli'] == ''  && !isset($_GET['b_ref_cli']) && $_GET['b_precio_desde_cli'] == ''  && $_GET['b_precio_hasta_cli'] == ''  && !isset($_GET['b_loc1_cli'])  && !isset($_GET['b_loc2_cli'])  && !isset($_GET['b_loc3_cli'])  && !isset($_GET['b_loc4_cli'])  && !isset($_GET['b_opciones_cli'])  && !isset($_GET['b_opciones2_cli']) && !isset($_GET['b_tags_cli'])  && $_GET['nw'] == '' && $_GET['ven'] == '' && $_GET['alq'] == '' && $_GET['res'] == ''  && $_GET['rp'] == '' && $_GET['cs'] == '' && $_GET['sw'] == '' && $_GET['ep'] == '' && $_GET['po'] == '' && $_GET['rps'] == ''  && $_GET['direccion'] == ''  && $_GET['m2ut'] == ''  && $_GET['m2pl'] == '' && $_GET['palabras_clave'] == '' && $_GET['b_pool_cli'] == ''  && $_GET['b_parking_cli'] == '' && $_GET['b_m2_desde_cli'] == '' && $_GET['b_m2_hasta_cli'] == '' && $_GET['b_m2_par_desde_cli'] == '' && $_GET['b_m2_par_hasta_cli'] == '' && $_GET['b_promocion_cli'] == ''       ){
  $nprop = "AND id_prop = ''";
}


$query_RS = "SELECT GROUP_CONCAT(property) as ids FROM cli_prop_int WHERE client = '".$_GET['id_cli']."' GROUP BY client";
$RS = mysqli_query($inmoconn, $query_RS) or die(mysqli_error());
$row_RS = mysqli_fetch_assoc($RS);
$totalRows_RS = mysqli_num_rows($RS);

$retQRY = '';
if ($row_RS['ids'] != '') {
    $retQRY .= ' AND id_prop NOT IN ('.trim($row_RS['ids'], ',').')';
}

$query_RS = "SELECT GROUP_CONCAT(property) as ids FROM cli_prop_noint WHERE client = '".$_GET['id_cli']."' GROUP BY client";
$RS = mysqli_query($inmoconn, $query_RS) or die(mysqli_error());
$row_RS = mysqli_fetch_assoc($RS);
$totalRows_RS = mysqli_num_rows($RS);

if ($row_RS['ids'] != '') {
    $retQRY .= ' AND id_prop NOT IN ('.trim($row_RS['ids'], ',').')';
}

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("7");
if ($isLoggedIn1->Execute()) {

    if($retQRY != '') {
        $retQRY .= ' AND user_prop = \''.$_SESSION['kt_login_id'].'\' ';
    } else {
        $retQRY .= ' AND user_prop = \''.$_SESSION['kt_login_id'].'\' ';
    }

    $retQRY = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $retQRY);

}

$distBeach = '';
if($_GET['b_dist_beach_from_cli'] != '' || $_GET['b_dist_beach_to_cli'] != '') {
    $distBeach = "AND distance_beach_med_prop = '" . $_GET['b_dist_beach_val_cli'] . "'";
    if ($_GET['b_dist_beach_from_cli'] > 0) {
        $distBeach .= " AND distance_beach_prop >= " . $_GET['b_dist_beach_from_cli'] . "";
    }
    if ($_GET['b_dist_beach_to_cli'] > 0) {
        $distBeach .= " AND distance_beach_prop <= " . $_GET['b_dist_beach_to_cli'] . "";
    }
}

$distAmenit = '';
if($_GET['b_dist_amenit_from_cli'] != '' || $_GET['b_dist_amenit_to_cli'] != '') {
    $distAmenit = "AND distance_amenities_med_prop = '" . $_GET['b_dist_amenit_val_cli'] . "'";
    if ($_GET['b_dist_amenit_from_cli'] > 0) {
        $distAmenit .= " AND distance_amenities_prop >= " . $_GET['b_dist_amenit_from_cli'] . "";
    }
    if ($_GET['b_dist_amenit_to_cli'] > 0) {
        $distAmenit .= " AND distance_amenities_prop <= " . $_GET['b_dist_amenit_to_cli'] . "";
    }
}

$distAirport = '';
if($_GET['b_dist_airport_from_cli'] != '' || $_GET['b_dist_airport_to_cli'] != '') {
    $distAirport = "AND distance_airport_med_prop = '" . $_GET['b_dist_airport_val_cli'] . "'";
    if ($_GET['b_dist_airport_from_cli'] > 0) {
        $distAirport .= " AND distance_airport_prop >= " . $_GET['b_dist_airport_from_cli'] . "";
    }
    if ($_GET['b_dist_airport_to_cli'] > 0) {
        $distAirport .= " AND distance_airport_prop <= " . $_GET['b_dist_airport_to_cli'] . "";
    }
}

$distGolf = '';
if($_GET['b_dist_golf_from_cli'] != '' || $_GET['b_dist_golf_to_cli'] != '') {
    $distGolf = "AND distance_golf_med_prop = '" . $_GET['b_dist_golf_val_cli'] . "'";
    if ($_GET['b_dist_golf_from_cli'] > 0) {
        $distGolf .= " AND distance_golf_prop >= " . $_GET['b_dist_golf_from_cli'] . "";
    }
    if ($_GET['b_dist_golf_to_cli'] > 0) {
        $distGolf .= " AND distance_golf_prop <= " . $_GET['b_dist_golf_to_cli'] . "";
    }
}

$m2d = '';
if( isset($_GET['b_m2_desde_cli']) && $_GET['b_m2_desde_cli'] != '' ){
    $m2d = "AND m2_prop >= " . $_GET['b_m2_desde_cli'];
}

$m2ph = '';
if( isset($_GET['b_m2_hasta_cli']) && $_GET['b_m2_hasta_cli'] != '' ){
    $m2ph = "AND m2_prop <= " . $_GET['b_m2_hasta_cli'];
}

$m2rpd = '';
if( isset($_GET['b_m2_par_desde_cli']) && $_GET['b_m2_par_desde_cli'] != '' ){
    $m2rpd = "AND m2_parcela_prop >= " . $_GET['b_m2_par_desde_cli'];
}

$m2rph = '';
if( isset($_GET['b_m2_par_hasta_cli']) && $_GET['b_m2_par_hasta_cli'] != '' ){
    $m2rph = "AND m2_parcela_prop <= " . $_GET['b_m2_par_hasta_cli'];
}

$promo = '';
if( isset($_GET['b_promocion_cli']) && $_GET['b_promocion_cli'][0] != '' ){
    $promo = implode(',', $_GET['b_promocion_cli']);
    if ($promo != '') {
        $promo = "AND promotion_prop IN (" . $promo . ")";
    }
}

$currentPage = '/intramedianet/properties/properties-client-data-cli.php';

$maxRows_rsProperties = 5;
$pageNum_rsProperties = 0;
if (isset($_GET['pageNum_rsProperties']) && $_GET['pageNum_rsProperties'] != '') {
  $pageNum_rsProperties = $_GET['pageNum_rsProperties'];
  $_SESSION['pageNum_rsProperties' . $_GET['id_cli']] = $_GET['pageNum_rsProperties'];
}
$startRow_rsProperties = $pageNum_rsProperties * $maxRows_rsProperties;

$query_rsProperties = "

SELECT
    properties_properties.referencia_prop,
    properties_status.status_nl_sta,
    CASE WHEN properties_types.types_nl_typ IS NOT NULL THEN properties_types.types_nl_typ ELSE types.types_nl_typ END AS types_nl_typ,
    CASE WHEN properties_loc2.name_nl_loc2 IS NOT NULL THEN properties_loc2.name_nl_loc2 ELSE province1.name_nl_loc2  END AS name_nl_loc2,
    CASE WHEN properties_loc3.name_nl_loc3 IS NOT NULL THEN properties_loc3.name_nl_loc3 ELSE areas1.name_nl_loc3  END AS name_nl_loc3,
    CASE WHEN properties_loc4.name_nl_loc4 IS NOT NULL THEN properties_loc4.name_nl_loc4 ELSE towns.name_nl_loc4  END AS name_nl_loc4,
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
    (SELECT pool_nl_pl FROM properties_pool WHERE id_pl = piscina_prop LIMIT 1 ) AS piscina_prop,
    (SELECT parking_nl_prk FROM properties_parking WHERE id_prk = parking_prop LIMIT 1 ) AS parking_prop,
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
    $opjoin
    $opjoin2
    $tagjoin

WHERE (id_prop IS NOT NULL OR id_prop != '')
$retQRY
$st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $tags $pool $parking $palabras_clave $m2d $m2ph $m2pd $m2ph $promo
$distBeach $distAmenit $distAirport $distGolf

AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

GROUP BY id_prop

";
$query_limit_rsProperties = sprintf("%s LIMIT %d, %d", $query_rsProperties, $startRow_rsProperties, $maxRows_rsProperties);
$rsProperties = mysqli_query($inmoconn, $query_limit_rsProperties) or die(mysqli_error());
$row_rsProperties = mysqli_fetch_assoc($rsProperties);

// if (isset($_GET['totalRows_rsProperties']) && $_GET['totalRows_rsProperties'] != '') {
//   $totalRows_rsProperties = $_GET['totalRows_rsProperties'];
//   $_SESSION['totalRows_rsProperties' . $_GET['id_cli']] = $_GET['totalRows_rsProperties'];
// } else {
  $all_rsProperties = mysqli_query($inmoconn, $query_rsProperties) or die(mysqli_error());
  $totalRows_rsProperties = mysqli_num_rows($all_rsProperties);
// }

$totalPages_rsProperties = ceil($totalRows_rsProperties/$maxRows_rsProperties)-1;

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

$queryString_rsProperties .= sprintf("&amp;totalRows_rsProperties=%d", $totalRows_rsProperties);

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
<?php if ($row_rsProperties['id_prop'] != ''): ?>
<div class="card">
    <div class="card-header bg-primary text-white pt-3 pb-2">
        <div class="card-title">
            <input type="checkbox" name="user" id="name<?php echo $row_rsProperties['id_prop'] ?>" class="chklist" value="<?php echo $row_rsProperties['id_prop'] ?>">
            &nbsp;
            <?php if ($row_rsProperties['email'] != ''): ?>
            <i class="fa fa-envelope float-end" style="font-size: 24px;" aria-hidden="true"></i>
            <?php endif ?>
            ID: <?php echo $row_rsProperties['id_prop'] ?> | <?php __('Ref.') ?>: <?php echo $row_rsProperties['referencia_prop'] ?>
        </div>
    </div>
    <div class="panel-body p-3" style="<?php if ($row_rsProperties['rate'] == 1 && $row_rsProperties['rate'] != ''): ?>background-color: #e4feeb;<?php endif ?><?php if ($row_rsProperties['rate'] == 0 && $row_rsProperties['rate'] != ''): ?>background-color: #fceeee;<?php endif ?>">

        <?php if ($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsProperties['id_img'].'_md.jpg'): ?>
            <a href="/media/images/properties/thumbnails/<?php echo $row_rsProperties['id_img'] ?>_lg.jpg" data-toggle="lightbox"><img src="/media/images/properties/thumbnails/<?php echo $row_rsProperties['id_img'] ?>_sm.jpg" alt="" style="max-height: 190px; float: right;" class="rounded"></a>
        <?php else: ?>
            <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="max-height: 190px; float: right;" class="rounded">
        <?php endif ?>

        <!-- <h2 style="margin: 0px; font-weight: 900;"><?php echo $row_rsProperties['promotion_prop']; ?></h2> -->

        <h4 style="margin: 0px; font-weight: 600;"><?php echo $row_rsProperties['name_nl_loc2']; ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $row_rsProperties['name_nl_loc3']; ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $row_rsProperties['name_nl_loc4']; ?></h4>

        <h5 style="margin: 10px 0 0; font-weight: 600;">
            <?php if ($row_rsProperties['precio_desde_prop'] == 1): ?>
                <?php echo ucfirst(__('desde', true)); ?>:
            <?php endif ?>
            <?php if ($row_rsProperties['precio_prop'] > 0): ?>
                <del class="text-danger"><?php echo number_format((int)$row_rsProperties['precio_prop'], 0, ',', '.'); ?> €</del> |
            <?php endif ?>
            <div style="display: inline;">
                <?php echo number_format((int)$row_rsProperties['preci_reducidoo_prop'], 0, ',', '.'); ?> €
            </div>
        </h5>

        <table class="mt-3">
          <tr>
            <?php if ($row_rsProperties['habitaciones_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-baths.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties['habitaciones_prop'], 0, ',', '.'); ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties['aseos_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-beds.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties['aseos_prop'], 0, ',', '.'); ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties['m2_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-m2.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties['m2_prop'], 0, ',', '.'); ?> m<sup>2</sup></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties['m2_parcela_prop'] > 0): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-m2p.png" alt="" style="height: 20px;">
                    <div><?php echo number_format((int)$row_rsProperties['m2_parcela_prop'], 0, ',', '.'); ?> m<sup>2</sup></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties['piscina_prop'] != ''): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-pool.png" alt="" style="height: 20px;">
                    <div><?php echo $row_rsProperties['piscina_prop']; ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties['parking_prop'] != ''): ?>
                <td class="text-center pe-5">
                    <img src="/media/images/website/icon-parking.png" alt="" style="height: 20px;">
                    <div><?php echo $row_rsProperties['parking_prop']; ?></div>
                </td>
            <?php endif ?>
            <?php if ($row_rsProperties['entraga_date_prop'] != ''): ?>
                <td class="text-center pe-5">
                    <i class="fa fa-calendar" aria-hidden="true" style="font-style: 20px;"></i>
                    <div><?php echo date('d-m-Y', strtotime($row_rsProperties['entraga_date_prop'])); ?></div>
                </td>
            <?php endif ?>
          </tr>
        </table>

        <?php if (trim($row_rsProperties['nombre_pro']) != ''): ?>
        <p class="mt-3"><?php __('Propietario') ?>: <strong style="font-weight: 900;"><?php echo $row_rsProperties['nombre_pro']; ?></strong></p>
        <?php endif ?>

        <?php if ($row_rsProperties['rateid'] > 0): ?>
            <?php getRate($row_rsProperties['rateid']) ?>
        <?php endif ?>

    </div>
    <div class="card-footer bg-light p-3 py-2">
        <a href="properties-form.php?id_prop=<?php echo $row_rsProperties['id_prop'] ?>" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-fw fa-pencil"></i></a>
        <a href="<?php echo propURL($row_rsProperties['id_prop'], 'nl'); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-fw fa-eye"></i></a>
        <?php if ($row_rsProperties['dropbox_prop'] != ''): ?>
        <a href="<?php echo $row_rsProperties['dropbox_prop']; ?>" target="_blank" class="btn btn-warning btn-sm"><i class="fa-brands fa-fw fa-dropbox"></i></a>
        <?php endif ?>
        <?php if ($row_rsProperties['lat_long_gpp_prop'] != ''): ?>
        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row_rsProperties['lat_long_gpp_prop']; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-map-marker"></i></a>
        <?php endif ?>
        <a href="_update-client-props.php?act=add&sec=no&id_prop=<?php echo $row_rsProperties['id_prop'] ?>&id_cli=<?php echo $_GET['id_cli'] ?>" target="_blank" class="btn btn-danger btn-sm float-end btn-clnt" style="margin: 0 0 0 10px;"><i class="fa fa-fw fa-times"></i></a>
        <a href="_update-client-props.php?act=add&sec=si&id_prop=<?php echo $row_rsProperties['id_prop'] ?>&id_cli=<?php echo $_GET['id_cli'] ?>" target="_blank" class="btn btn-success btn-sm float-end btn-clnt" style="margin: 0 0 0 10px;"><i class="fa fa-fw fa-check"></i></a>
    </div>
</div>
<?php else: ?>
<br><br><br>
<p class="lead text-center"><?php __('No hay registros que mostrar'); ?></p>
<br><br>
<?php endif ?>
<?php
} while ($row_rsProperties = mysqli_fetch_assoc($rsProperties));

if ($totalRows_rsProperties > 0) {

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
                  if ($pageNum_rsProperties > 0) { // Show if not first page
                      echo '<li class="page-item"><a class="page-link unprocessed-links" href="' . $currentPage . '?pageNum_rsProperties=0' . $queryString_rsProperties . '"><i class="fa fa-angle-double-left" aria-hidden="true"></i> ' . $lang['Primero'] . '</a></li>';
                  } // Show if not first page
                  if ($pageNum_rsProperties > 0) { // Show if not first page
                      echo '<li class="page-item"><a class="page-link unprocessed-links" href="' . $currentPage . '?pageNum_rsProperties=' . max(0, $pageNum_rsProperties - 1) . '' . $queryString_rsProperties . '"><i class="fa fa-angle-left" aria-hidden="true"></i> ' . $lang['Anterior'] . '</a></li>';
                  } // Show if not first page
                  if ($pageNum_rsProperties < $totalPages_rsProperties) { // Show if not last page
                      echo '<li class="page-item"><a class="page-link unprocessed-links" href="' . $currentPage . '?pageNum_rsProperties=' . min($totalPages_rsProperties, $pageNum_rsProperties + 1) . '' . $queryString_rsProperties . '">' . $lang['Siguiente'] . ' <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
                  } // Show if not last page
                  if ($pageNum_rsProperties < $totalPages_rsProperties) { // Show if not last page
                      echo '<li class="page-item"><a class="page-link unprocessed-links" href="' . $currentPage . '?pageNum_rsProperties=' . ''. $totalPages_rsProperties . '' . $queryString_rsProperties . '">' . $lang['Último'] . ' <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
                  } // Show if not last page
                echo "</ul>";
            }
        echo '</div>';
        echo '<div class="col-md-5">';
            echo '<div class="text-end">' . $lang['Inmuebles'] . ' ' .$lang['de_a_de_totales'][1] . ' ' .($startRow_rsProperties + 1) . ' ' .$lang['de_a_de_totales'][2] . ' ' .min($startRow_rsProperties + $maxRows_rsProperties, $totalRows_rsProperties) . ' ' .$lang['de_a_de_totales'][3] . ' ' .$totalRows_rsProperties . ' ' .$lang['de_a_de_totales'][4] . '</div>';
        echo '</div>';
    echo '</div>';

    ?>
    <script>
        var $pageNum_rsProperties = '<?php echo $_SESSION['pageNum_rsProperties' . $_GET['id_cli']] ?>';
        var $totalRows_rsProperties = '<?php echo $_SESSION['totalRows_rsProperties' . $_GET['id_cli']] ?>';
    </script>
    <?php

}


