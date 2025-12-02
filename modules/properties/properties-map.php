<?php

if (!isset($_GET['p'])) {
    SmartyPaginate::reset();
}

SmartyPaginate::connect();

SmartyPaginate::setLimit(999999);

SmartyPaginate::setPageLimit(6);

SmartyPaginate::setUrl(preg_replace('/[\&?\??]+p=[0-9]*/', '', $_SERVER['REQUEST_URI']));

SmartyPaginate::setUrlVar('p');

@SmartyPaginate::setPrevText('&#8249;');
@SmartyPaginate::setNextText('&#8250;');
@SmartyPaginate::setFirstText('&laquo;');
@SmartyPaginate::setLastText('&raquo;');

$cp = SmartyPaginate::getCurrentIndex();
$tp = SmartyPaginate::getLimit();

function remove_querystring_var($url, $key) {
    $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
    return $url;
}

if (isset($_GET['nu']) && is_numeric($_GET['nu'])) {

    setcookie('nu', $_GET['nu'], mktime(21,00,0,12,31,2100),"/", "",0);
    $url = remove_querystring_var("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "nu");
    header("Location: $url");

}

if (isset($_COOKIE['nu']) && is_numeric($_COOKIE['nu']) && $_COOKIE['nu'] == '12') {

    SmartyPaginate::setLimit(12);
    $cp = SmartyPaginate::getCurrentIndex();
    $tp = SmartyPaginate::getLimit();

}

if (isset($_COOKIE['nu']) && is_numeric($_COOKIE['nu']) && $_COOKIE['nu'] == '24') {

    SmartyPaginate::setLimit(24);
    $cp = SmartyPaginate::getCurrentIndex();
    $tp = SmartyPaginate::getLimit();

}

if (isset($_COOKIE['nu']) && is_numeric($_COOKIE['nu']) && $_COOKIE['nu'] == '48') {

    SmartyPaginate::setLimit(48);
    $cp = SmartyPaginate::getCurrentIndex();
    $tp = SmartyPaginate::getLimit();

}

//  ============================================================================
//  === PRICE -> MINI SEARCH
//  ============================================================================

$prds = '';
if ( isset($_GET['prds']) && $_GET['prds'] != '' ) {
    $prds = "AND preci_reducidoo_prop >= " . simpleSanitize(($_GET['prds']));
}

$prhs = '';
if ( isset($_GET['prhs']) && $_GET['prhs'] != '' && $_GET['prhs'] != '2000000' ) {
    $prhs = "AND preci_reducidoo_prop <= " . simpleSanitize(($_GET['prhs']));
}
if ( isset($_GET['prhs']) && $_GET['prhs'] == '3000' ) {
    $prhs = "AND preci_reducidoo_prop <= 2000000000";
}

//  ============================================================================
//  === M2 ÚTILES
//  ============================================================================

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
else {
    $m2ut = "AND 1=1";
}

//  ============================================================================
//  === M2 PARCELA
//  ============================================================================

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
else {
    $m2pl = "AND 1=1";
}

//  ============================================================================
//  === LOCATION -> MINI SEARCH
//  ============================================================================

$lo = '';
if( isset($_GET['lo']) && $_GET['lo'] != '' ){
    $lo = "AND localidad_prop = " . simpleSanitize(($_GET['lo']));
}

//  ============================================================================
//  === REFERENCE
//  ============================================================================

$rf = '';
if( isset($_GET['rf']) && $_GET['rf'] != '' ){
    $rf = "AND referencia_prop LIKE '%" . simpleSanitize(($_GET['rf'])) . "%'";
}

//  ============================================================================
//  === STATUS
//  ============================================================================

$st = '';
if( isset($_GET['st']) && $_GET['st'][0] != '' ){
    $status = implode(',', $_GET['st']);
    if ($status != '') {
        $st = "AND operacion_prop  IN (" . simpleSanitize($status) . ")";
    }
}

//  ============================================================================
//  === COUNTRY
//  ============================================================================

$ctr = '';
if( isset($_GET['locun']) && $_GET['locun'] != '' ){
    $country = implode(',', $_GET['locun']);
    if ($country != '') {
        $ctr = "AND properties_loc1.id_loc1  IN (" . simpleSanitize($country) . ")";
    }
}

//  ============================================================================
//  === PROVINCE
//  ============================================================================

$lopr = '';
if( isset($_GET['lopr']) && $_GET['lopr'] != '' ){
    $province = implode(',', $_GET['lopr']);
    if ($province != '') {
        $lopr = "AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (" . simpleSanitize($province) . ")";
    }
}

//  ============================================================================
//  === COAST
//  ============================================================================

$coast = '';
if( isset($_GET['coast']) && $_GET['coast'] != '' ){
    $location = implode(',', $_GET['coast']);
    if ($location != '') {
        $coast = "AND CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END IN (" . simpleSanitize($location) . ")";
    }
}

//  ============================================================================
//  === CITY
//  ============================================================================

$loct = '';
if( isset($_GET['loct']) && $_GET['loct'] != '' ){
    $location = implode(',', $_GET['loct']);
    if ($location != '') {
        $loct = "AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (" . simpleSanitize($location) . ")";
    }
}

//  ============================================================================
//  === ZONE
//  ============================================================================

$lozn = '';
if( isset($_GET['lozn']) && $_GET['lozn'] != '' ){
    $zone = implode(',', $_GET['lozn']);
    if ($zone != '') {
        $lozn = "AND CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END IN (" . simpleSanitize($zone) . ")";
    }
}

//  ============================================================================
//  === LOCATION
//  ============================================================================

$lc = '';
if( isset($_GET['lc']) && $_GET['lc'] != '' ){
    $location = implode(',', $_GET['lc']);
    if ($location != '') {
        $lc = "AND CASE WHEN properties_towns.id_twn IS NOT NULL THEN properties_towns.id_twn ELSE towns.id_twn  END IN (" . simpleSanitize($location) . ")";
    }
}

//  ============================================================================
//  === TYPE
//  ============================================================================

$typ = '';
if( isset($_GET['tp']) && $_GET['tp'] != '' ){
    $type = implode(',', $_GET['tp']);
    if ($type  != '') {
        $typ = "AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . simpleSanitize($type) . ")";
    }
}

//  ============================================================================
//  === BEDROOMS
//  ============================================================================

$bd = '';
if( isset($_GET['bd']) && $_GET['bd'] != '' ){
    $bd = "AND habitaciones_prop >= " . simpleSanitize(($_GET['bd']));
}

//  ============================================================================
//  === BEDROOMS
//  ============================================================================

$bt = '';
if( isset($_GET['bt']) && $_GET['bt'] != '' ){
    $bt = "AND aseos_prop >= " . simpleSanitize(($_GET['bt']));
}

//  ============================================================================
//  === PRICE REDUCED
//  ============================================================================

$rp = '';
if( isset($_GET['rp']) && $_GET['rp'] != '' ){
    $rp = "AND reducido_prop = 1";
}

//  ============================================================================
//  === NEW
//  ============================================================================

$nw = '';
if( isset($_GET['nw']) && $_GET['nw'] == 1 ){
    $nw = "AND nuevo_prop >= CURDATE()";
}

//  ============================================================================
//  === CLOSE TO SEA
//  ============================================================================

$cs = '';
if( isset($_GET['cs']) && $_GET['cs'] != '' ){
    $cs = "AND cerca_mar_prop = " . simpleSanitize(($_GET['cs']));
}

//  ============================================================================
//  === SEAVIEWS
//  ============================================================================

$sw = '';
if( isset($_GET['sw']) && $_GET['sw'] != '' ){
    $sw = "AND vistas_mar_prop = " . simpleSanitize(($_GET['sw']));
}

//  ============================================================================
//  === EXCLUSIVE PROPERTIES
//  ============================================================================

$ep = '';
if( isset($_GET['ep']) && $_GET['ep'] != '' ){
    $ep = "AND exclusivo_prop = " . simpleSanitize(($_GET['ep']));
}

//  ============================================================================
//  === POOL
//  ============================================================================

$po = '';
if( isset($_GET['po']) && $_GET['po'] != '' ){
    $po = "AND piscina_prop = " . simpleSanitize(($_GET['po']));
}

//  ============================================================================
//  === REPOSSESSION
//  ============================================================================

$rps = '';
if( isset($_GET['rps']) && $_GET['rps'] != '' ){
    $rps = "AND embargo_prop = " . simpleSanitize(($_GET['rps']));
}

//  ============================================================================
//  === ORIENTACIÓN
//  ============================================================================

$or = '';
if( isset($_GET['or']) && $_GET['or'] != '' ){
    $or = "AND orientacion_prop = '" . simpleSanitize(($_GET['or'])) . "'";
}

//  ============================================================================
//  === VENDIDO
//  ============================================================================

$ven = '';

if (isset($_GET['ven']) && $_GET['ven'] != '' || $url_ven) {
    if (!$url_ven) {
        $url_ven = simpleSanitize(($_GET['ven']));
    }

    $ven = "AND vendido_prop = ".$url_ven."";
}

// if ($_GET['secc'] == 'ven') {
//     $secc = 'activado_prop = 0 AND vendido_prop = 1 ';
// } elseif ($_GET['secc'] == 'alq') {
//     $secc = 'activado_prop = 0 AND alquilado_prop = 1 ';
// } else {
//
// }

//  ============================================================================
//  === ACTIVADO
//  ============================================================================

$secc = 'activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1';

//  ============================================================================
//  === ALQUILADO
//  ============================================================================

$alq = '';
if( isset($_GET['alq']) && $_GET['alq'] != '' ){
    $alq = "AND alquilado_prop = " . simpleSanitize(($_GET['alq']));
}

//  ============================================================================
//  === RESERVADO
//  ============================================================================

$res = '';
if( isset($_GET['res']) && $_GET['res'] != '' ){
    $res = "AND reservado_prop = " . simpleSanitize(($_GET['res']));
}

//  ============================================================================
//  === ASCENSOR
//  ============================================================================

$asc = '';
if( isset($_GET['asc']) && $_GET['asc'] != '' ){
    $asc = "AND ascensor_prop = " . simpleSanitize(($_GET['asc']));
}

//  ============================================================================
//  === GOLF
//  ============================================================================

$golf = '';
if( isset($_GET['glf']) && $_GET['glf'] != '' ){
    $golf = "AND golf_prop = " . simpleSanitize(($_GET['glf']));
}

//  ============================================================================
//  === FEATURES
//  ============================================================================

$features = '';
if( isset($_GET['features']) && $_GET['features'][0] != '' ){

  $query_rsfeats = "SELECT GROUP_CONCAT(property) AS ids FROM properties_property_feature WHERE feature IN (".implode(',', $_GET['features']).")";
  $rsfeats = mysqli_query($inmoconn, $query_rsfeats) or die(mysqli_error());
  $row_rsfeats = mysqli_fetch_assoc($rsfeats);
$totalRows_rsfeats = mysqli_num_rows($rsfeats);

if ($totalRows_rsfeats > 0) {
      $features = "AND id_prop IN (" . $row_rsfeats['ids'] .")";
  }
}

//  ============================================================================
//  === ORDER
//  ============================================================================

$o = " ORDER BY IF (precio = 0, 1, 0), precio ASC";
if (isset($_GET['o']) && is_numeric($_GET['o'])) {

    setcookie('o', $_GET['o'], mktime(21,00,0,12,31,2100),"/", "",0);
    $url = remove_querystring_var("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "o");
    header("Location: $url");

}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '1') {

    $o = " ORDER BY IF (precio = 0, 1, 0), precio ASC";

}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '2') {

    $o = " ORDER BY precio DESC";

}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '3') {

    $o = " ORDER BY id_prop DESC";

}

if (isset($_COOKIE['o']) && is_numeric($_COOKIE['o']) && $_COOKIE['o'] == '4') {

    $o = " ORDER BY id_prop ASC";

}

$listMap = getRecords("

SELECT

    lat_long_gp_prop AS maplat,
	CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    properties_status.status_".$lang."_sta as sale,
    properties_properties.m2_prop,
    properties_properties.referencia_prop,
    properties_properties.descripcion_".$lang."_prop as contenido,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
   (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
   (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop

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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE lat_long_gp_prop != '' AND lat_long_gp_prop != '0,0' AND procesada_img = 1
	AND activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1

$pdh $p $lo $rf $ar $lc $typ $bd $bt $rp $nw $cs $sw $ep $po $cos $inl $rps $st $ven $alq $res $asc $m2ut $m2pl $ctr $lopr $loct $lozn $or $golf $prds $prhs $features $coast

GROUP BY id_prop

");

$smarty->assign("listMap", $listMap);

if ($listMap[0]['id_prop'] != '') {
    $smarty->assign("totalprops", count($listMap));
    $smarty->assign("totalPropsMap", count($listMap));
} else {
    $smarty->assign("totalprops", 0);
    $smarty->assign("totalPropsMap", 0);
}

$_query = "SELECT id_prop

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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE  $secc

$pdh $p $lo $rf $ar $lc $typ $bd $bt $rp $nw $cs $sw $ep $po $cos $inl $rps $st $ven $alq $res $asc $m2ut $m2pl $ctr $lopr $loct $lozn $or $golf $prds $prhs $features $coast


     GROUP BY id_prop";
$_result = mysqli_query($inmoconn, $_query);
$_row = mysqli_fetch_array($_result, MYSQLI_ASSOC);
$totalRows = mysqli_num_rows($_result);
$smarty->assign("totalPropsList", $totalRows);

SmartyPaginate::assign($smarty);

//////////////////////////////////////////////////////////
////
//// @BREADCRUMB
////
//////////////////////////////////////////////////////////

//  ============================================================================
//  === STATUS
//  ============================================================================

$st = '';
if( isset($_GET['st']) && $_GET['st'] != '' ){
    $status = implode(',', $_GET['st']);
    if ($status  != '') {
        $st = getRecords("
            SELECT id_sta, status_".$lang."_sta as sale
            FROM properties_status
            WHERE id_sta IN (" . simpleSanitize($status) . ")
            GROUP BY id_sta");
    }
}

//  ============================================================================
//  === TYPE
//  ============================================================================

$typ = '';
if( isset($_GET['tp']) && $_GET['tp'] != '' ){
    $type = implode(',', $_GET['tp']);
    if ($type  != '') {
        $typ = getRecords("SELECT types.id_typ, CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type
        FROM properties_types types
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        WHERE CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . $type . ")");
    }
}

//  ============================================================================
//  === COUNTRY
//  ============================================================================

$ctr = '';
if( isset($_GET['locun']) && $_GET['locun'] != '' ){
    $country = implode(',', $_GET['locun']);
    if ($country != '') {
        $ctr = "AND properties_loc1.id_loc1  IN (" . $country . ")";
    }
}

//  ============================================================================
//  === PROVINCE
//  ============================================================================

$lopr = '';
if( isset($_GET['lopr']) && $_GET['lopr'] != '' ){
    $province = implode(',', $_GET['lopr']);
    if ($province != '') {
        $lopr = "AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (" . $province . ")";
    }
}

//  ============================================================================
//  === CITY
//  ============================================================================

$loct = '';
if( isset($_GET['loct']) && $_GET['loct'] != '' ){
    $location = implode(',', $_GET['loct']);
    if ($location != '') {
        $loct = "AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (" . $location . ")";
    }
}

//  ============================================================================
//  === ZONE
//  ============================================================================

$lozn = '';
if( isset($_GET['lozn']) && $_GET['lozn'] != '' ){
    $zone = implode(',', $_GET['lozn']);
    if ($zone != '') {
        $lozn = "AND CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END IN (" . $zone . ")";
    }
}

//  ============================================================================
//  === LOCATION
//  ============================================================================

$lc = '';
if( isset($_GET['lc']) && $_GET['lc'] != '' ){
    $location = implode(',', $_GET['lc']);
    if ($location != '') {
        $lc = "AND CASE WHEN properties_towns.id_twn IS NOT NULL THEN properties_towns.id_twn ELSE towns.id_twn  END IN (" . $location . ")";
    }
}

$breadcrumb = array('sale' => "",
                    'type' => "",
                    'country' => "",
                    'province' => "",
                    'area' => "",
                    'town' => "");

if($ctr != '' || $lopr != '' || $loct != '' || $lozn != '' || $lc != ''){
    $loc_brc = getRecords("SELECT
        properties_loc1.id_loc1 AS countryid,
        CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS provinceid,
        CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS areaid,
    CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END AS townid,
        properties_loc1.name_".$lang."_loc1 AS country,
        CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
        CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
        CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town
        FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

    WHERE 1=1 $ctr $lopr $loct $lozn $lc");

    foreach($loc_brc as $auxLoc){

        if(!in_array($auxLoc['countryid'], $breadcrumb['country'])){
            $breadcrumb['country'][$auxLoc['countryid']] = $auxLoc['country'];
        }

        if(!in_array($auxLoc['provinceid'], $breadcrumb['province'])){
            $breadcrumb['province'][$auxLoc['provinceid']] = $auxLoc['province'];
        }

        if($loct != '' && !in_array($auxLoc['areaid'], $breadcrumb['area'])){
            $breadcrumb['area'][$auxLoc['areaid']] = $auxLoc['area'];
        }

        if($lozn != '' && !in_array($auxLoc['townid'], $breadcrumb['town'])){
            $breadcrumb['town'][$auxLoc['townid']] = $auxLoc['town'];
        }
    }
}

if($st != ''){
    $breadcrumb['sale'] = $st;
}

if($typ != ''){
    $breadcrumb['type'] = $typ;
}

$smarty->assign("breadcrumb", $breadcrumb);

?>
