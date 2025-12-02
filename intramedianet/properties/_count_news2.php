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
?><?php


  //sleep(2);

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * Easy set variables
   */

  /* Array of database columns which should be read and sent back to DataTables. Use a space where
   * you want to insert a non-database field (for example a counter or static image)
   */

  // echo "<pre>";
  // print_r($_GET);
  // echo "</pre>";


$query_rsCli = "SELECT * FROM properties_client WHERE id_cli = '".$_GET['id_cli']."'";
$rsCli = mysqli_query($inmoconn,$query_rsCli) or die(mysqli_error());
$row_rsCli = mysqli_fetch_assoc($rsCli);
$totalRows_rsCli = mysqli_num_rows($rsCli);

$row_rsCli['b_sale_cli'] = !is_null($row_rsCli['b_sale_cli']) ? explode(',', $row_rsCli['b_sale_cli']) : [];
$row_rsCli['b_beds_cli'] = $row_rsCli['b_beds_cli'];
$row_rsCli['b_baths_cli'] = $row_rsCli['b_baths_cli'];

$row_rsCli['b_type_cli'] = !is_null($row_rsCli['b_type_cli']) ? explode(',', $row_rsCli['b_type_cli']) : [];
$row_rsCli['b_loc1_cli'] = !is_null($row_rsCli['b_loc1_cli']) ? explode(',', $row_rsCli['b_loc1_cli']) : [];
$row_rsCli['b_loc2_cli'] = !is_null($row_rsCli['b_loc2_cli']) ? explode(',', $row_rsCli['b_loc2_cli']) : [];
$row_rsCli['b_loc3_cli'] = !is_null($row_rsCli['b_loc3_cli']) ? explode(',', $row_rsCli['b_loc3_cli']) : [];
$row_rsCli['b_loc4_cli'] = !is_null($row_rsCli['b_loc4_cli']) ? explode(',', $row_rsCli['b_loc4_cli']) : [];

$row_rsCli['b_ref_cli'] = !is_null($row_rsCli['b_ref_cli']) ? explode(',', $row_rsCli['b_ref_cli']) : [];
$row_rsCli['b_opciones_cli'] = !is_null($row_rsCli['b_opciones_cli']) ? explode(',', $row_rsCli['b_opciones_cli']) : [];
$row_rsCli['b_opciones2_cli'] = !is_null($row_rsCli['b_opciones2_cli']) ? explode(',', $row_rsCli['b_opciones2_cli']) : [];
$row_rsCli['b_ocultos_cli'] = !is_null($row_rsCli['b_ocultos_cli']) ? explode(',', $row_rsCli['b_ocultos_cli']) : [];
$row_rsCli['b_pool_cli'] = !is_null($row_rsCli['b_pool_cli']) ? explode(',', $row_rsCli['b_pool_cli']) : [];
$row_rsCli['b_parking_cli'] = !is_null($row_rsCli['b_parking_cli']) ? explode(',', $row_rsCli['b_parking_cli']) : [];
$row_rsCli['b_m2_desde_cli'] = !is_null($row_rsCli['b_m2_desde_cli']) ? explode(',', $row_rsCli['b_m2_desde_cli']) : [];
$row_rsCli['b_m2_hasta_cli'] = !is_null($row_rsCli['b_m2_hasta_cli']) ? explode(',', $row_rsCli['b_m2_hasta_cli']) : [];
$row_rsCli['b_m2p_desde_cli'] = !is_null($row_rsCli['b_m2p_desde_cli']) ? explode(',', $row_rsCli['b_m2p_desde_cli']) : [];
$row_rsCli['b_m2p_hasta_cli'] = !is_null($row_rsCli['b_m2p_hasta_cli']) ? explode(',', $row_rsCli['b_m2p_hasta_cli']) : [];

// if (isset($_GET['debug'])) {
//     echo "<pre>";
//     var_dump($row_rsCli);
//     echo "</pre>";
// }

$nprop = "";
if (
trim($row_rsCli['b_sale_cli'][0]) == ''
&& trim($row_rsCli['b_beds_cli']) == ''
&& trim($row_rsCli['b_baths_cli']) == ''
&& trim($row_rsCli['b_type_cli'][0]) == ''
&& trim($row_rsCli['b_loc1_cli'][0]) == ''
&& trim($row_rsCli['b_loc2_cli'][0]) == ''
&& trim($row_rsCli['b_loc3_cli'][0]) == ''
&& trim($row_rsCli['b_loc4_cli'][0]) == ''
&& trim($row_rsCli['b_ref_cli'][0]) == ''
&& trim($row_rsCli['b_pool_cli'][0]) == ''
&& trim($row_rsCli['b_parking_cli'][0]) == ''
&& trim($row_rsCli['b_m2_desde_cli'][0]) == ''
&& trim($row_rsCli['b_m2_hasta_cli'][0]) == ''
&& trim($row_rsCli['b_m2p_desde_cli'][0]) == ''
&& trim($row_rsCli['b_m2p_hasta_cli'][0]) == ''
&& (trim($row_rsCli['b_precio_desde_cli']) == '' || $row_rsCli['b_precio_desde_cli'] == null)
&& (trim($row_rsCli['b_precio_hasta_cli']) == '' || $row_rsCli['b_precio_hasta_cli'] == null)
&& trim($row_rsCli['b_opciones_cli'][0]) == ''
&& trim($row_rsCli['b_opciones2_cli'][0]) == ''
&& trim($row_rsCli['b_ocultos_cli'][0]) == ''
&& (trim($row_rsCli['b_orientacion_cli']) == '' || $row_rsCli['b_orientacion_cli'] == null)
&& (trim($row_rsCli['b_direcc_cli']) == '' || $row_rsCli['b_direcc_cli'] == null)
&& (trim($row_rsCli['b_urb_cli']) == '' || $row_rsCli['b_urb_cli'] == null)
&& (trim($row_rsCli['b_obranueva_cli']) == '' || $row_rsCli['b_obranueva_cli'] == null)
&& (trim($row_rsCli['b_garaje_cli']) == '' || $row_rsCli['b_garaje_cli'] == null)
&& (trim($row_rsCli['b_vistasmar_cli']) == '' || $row_rsCli['b_vistasmar_cli'] == null)
&& (trim($row_rsCli['b_precio_hasta_cli']) == '' || $row_rsCli['b_precio_hasta_cli'] == null)
&& (trim($row_rsCli['b_piscina_cli']) == '0' || $row_rsCli['b_piscina_cli'] == null)
) {
    $nprop = "AND id_prop = ''";
}

// echo "<pre>";
// print_r($row_rsCli);
// echo "</pre>";



  $aColumns = array('id_prop', 'image_img', 'referencia_prop', 'status_' .$lang_adm. '_sta', 'types_' .$lang_adm. '_typ', 'name_' .$lang_adm. '_loc3', 'name_' .$lang_adm. '_loc4', 'preci_reducidoo_prop', 'activado_prop', 'nombre_pro', 'telefono_fijo_pro', 'id_prop');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_prop";

  /* DB table to use */

  /* Database connection information */
  $gaSql['user']       = $username_inmoconn;
  $gaSql['password']   = $password_inmoconn;
  $gaSql['db']         = $database_inmoconn;
  $gaSql['server']     = $hostname_inmoconn;

  /* REMOVE THIS LINE (it just includes my SQL connection user/pass) */


  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * If you just want to use the basic configuration for DataTables with PHP server-side, there is
   * no need to edit below this line
   */

  /*
   * Local functions
   */
  function fatal_error ( $sErrorMessage = '' )
  {
    header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
    die( $sErrorMessage );
  }


  /*
   * MySQL connection
   */
  if ( ! $gaSql['link'] = mysqli_connect( $gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db']) )
  {
    fatal_error( 'Could not open connection to server' );
  }

  $rResult = mysqli_query($gaSql['link'], "SET NAMES 'utf8'");

  /*
   * Paging
   */
  $sLimit = "";
  if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
  {
    $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
      intval( $_GET['iDisplayLength'] );
  }


  /*
   * Ordering
   */
  $sOrder = "";
  if ( isset( $_GET['iSortCol_0'] ) )
  {
    $sOrder = "ORDER BY  ";
    for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
    {
      if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
      {
        $sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
          ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
      }
    }

    $sOrder = substr_replace( $sOrder, "", -2 );
    if ( $sOrder == "ORDER BY" )
    {
      $sOrder = "";
    }
  }


  /*
   * Filtering
   * NOTE this does not match the built-in DataTables filtering which does it
   * word by word on any field. It's possible to do here, but concerned about efficiency
   * on very large tables, and MySQL's regex functionality is very limited
   */
  $sWhere = "";
  if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
  {
    $sWhere = "WHERE (";
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
      if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
      {

        if($aColumns[$i] == 'inserted_xml_prop') {
          $sWhere .= "DATE_FORMAT(`inserted_xml_prop`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
        } else {
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string( $gaSql['link'],$_GET['sSearch'] )."%' OR ";
        }
      }
    }
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
  }

  /* Individual column filtering */
  for ( $i=0 ; $i<count($aColumns) ; $i++ )
  {
    if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
    {
      if ( $sWhere == "" )
      {
        $sWhere = "WHERE ";
      }
      else
      {
        $sWhere .= " AND ";
      }
      if($aColumns[$i] == 'inserted_xml_prop') {
        $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
      } else {
        if($aColumns[$i] == 'destacado_prop' || $aColumns[$i] == 'activado_prop' || $aColumns[$i] == 'show_web1_prop' || $aColumns[$i] == 'ubiflow_prop' || $aColumns[$i] == 'rightmove_prop' || $aColumns[$i] == 'greenacres_prop' || $aColumns[$i] == 'zoopla_prop' || $aColumns[$i] == 'inmoweb_prop' || $aColumns[$i] == 'trovit_prop') {

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('Sí', true)))) {
              $sWhere .= $aColumns[$i]." = '1' ";
          }

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('No', true)))) {
              $sWhere .= $aColumns[$i]." = '0' ";
          }

        } else {

                if($aColumns[$i] == 'owner_prop') {
                  $sWhere .= " CONCAT(nombre_pro, ' ', apellidos_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                } else {
                  if($aColumns[$i] == 'telefono_fijo_pro') {
                    $sWhere .= " CONCAT(telefono_fijo_pro, ' ', telefono_movil_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                  } else {
                    switch ($aColumns[$i]) {
                      case 'types_' .$lang_adm. '_typ':
                        $sWhere .= "CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                        break;
                      case 'name_' .$lang_adm. '_loc3':
                        $sWhere .= "CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                        break;
                      case 'name_' .$lang_adm. '_loc4':
                        $sWhere .= "CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                        break;

                      default:
                        $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                        break;
                    }
                  }
                }

        }
      }

    }
  }
if ((isset($_GET['propssearch']))&&($_GET['propssearch'] == 'ok')) {
    if($sWhere != '') {
        $sWhere .= ' AND (id_prop IS NOT NULL OR id_prop != \'\')  ';
    } else {
        $sWhere .= ' WHERE (id_prop IS NOT NULL OR id_prop != \'\' ) ';
    }
} else {
    if($sWhere != '') {
        $sWhere .= ' AND (id_prop IS NOT NULL OR id_prop != \'\') ';
    } else {
        $sWhere .= ' WHERE (id_prop IS NOT NULL OR id_prop != \'\' ) ';
    }
}




  $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);

  $op = '';
  $opjoin = '';
  if( isset($row_rsCli['b_opciones_cli'][0]) && $row_rsCli['b_opciones_cli'][0] != '' ){
      $opciones = implode(',', $row_rsCli['b_opciones_cli']);
      if ($opciones != '') {
          $op = "AND properties_property_feature.feature IN (" . $opciones . ")";
          $opjoin = "INNER JOIN properties_property_feature ON properties_properties.id_prop = properties_property_feature.property";
      }
  }

  $op2 = '';
  $opjoin2 = '';
  if( isset($row_rsCli['b_opciones2_cli'][0]) && $row_rsCli['b_opciones2_cli'][0] != '' ){
      $opciones2 = implode(',', $row_rsCli['b_opciones2_cli']);
      if ($opciones2 != '') {
          $op2 = "AND properties_property_feature_priv.feature IN (" . $opciones2 . ")";
          $opjoin2 = "INNER JOIN properties_property_feature_priv ON properties_properties.id_prop = properties_property_feature_priv.property";
      }
  }

  $st = '';
  if( isset($row_rsCli['b_sale_cli'][0]) && $row_rsCli['b_sale_cli'][0] != '' ){
      $status = implode(',', $row_rsCli['b_sale_cli']);
      if ($status != '') {
           $st = "AND (operacion_prop IN (" . $status . ") OR operacion_prop LIKE '14')";
      }
  }

  $ty = '';
  if( isset($row_rsCli['b_type_cli'][0]) && $row_rsCli['b_type_cli'][0] != '' ){
      $type = implode(',', $row_rsCli['b_type_cli']);
      if ($type != '') {
          $ty = "AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (" . $type . ")";
      }
  }



  $bd = '';
  if( isset($row_rsCli['b_beds_cli']) && $row_rsCli['b_beds_cli'] != '' ){
      $bd = "AND habitaciones_prop >= " . $row_rsCli['b_beds_cli'];
  }

  $bt = '';
  if( isset($row_rsCli['b_baths_cli']) && $row_rsCli['b_baths_cli'] != '' ){
      $bt = "AND aseos_prop >= " . $row_rsCli['b_baths_cli'];
  }

  $ref = '';
  if( !empty($row_rsCli['b_ref_cli']) && $row_rsCli['b_ref_cli'][0] != '' ){
      $refs = array();
      foreach ($row_rsCli['b_ref_cli'] as $value) {
        if (trim($value) != '') {
          array_push($refs, "'".$value."'");
        }
      }
      $reference = implode(',', $refs);
      if (trim($reference) != '') {
          $ref = "AND referencia_prop IN (" . $reference . ")";
      }
  }



  $prd = '';
  if( isset($row_rsCli['b_precio_desde_cli']) && $row_rsCli['b_precio_desde_cli'] != '' ){
      $prd = "AND preci_reducidoo_prop >= " . $row_rsCli['b_precio_desde_cli'];
  }

  $prh = '';
  if( isset($row_rsCli['b_precio_hasta_cli']) && $row_rsCli['b_precio_hasta_cli'] != '' ){
      $prh = "AND preci_reducidoo_prop <= " . $row_rsCli['b_precio_hasta_cli'];
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
if( isset($row_rsCli['b_orientacion_cli']) && $row_rsCli['b_orientacion_cli'] != '' ){
    $or2 = "AND orientacion_prop = '" . $row_rsCli['b_orientacion_cli'] . "'";
}

  $loc4 = '';
  if( isset($row_rsCli['b_loc4_cli']) && $row_rsCli['b_loc4_cli'] != '' ){
      $zone = implode(',', $row_rsCli['b_loc4_cli']);
      if ($zone != '') {
          $loc4 = "AND (properties_loc4.id_loc4 IN (" . $zone . ") OR properties_loc4.parent_loc4 IN (" . $zone . ") OR towns.id_loc4 IN (" . $zone . ") OR towns.parent_loc4 IN (" . $zone . ")) ";
   }
  }


  $loc3 = '';
  if( isset($row_rsCli['b_loc3_cli']) && $row_rsCli['b_loc3_cli'] != '' ){
      $location = implode(',', $row_rsCli['b_loc3_cli']);
      if ($location != '') {
          $loc3 = "AND (properties_loc3.id_loc3 IN (" . $location . ") OR properties_loc3.parent_loc3 IN (" . $location . ") OR areas1.id_loc3 IN (" . $location . ") OR areas1.parent_loc3 IN (" . $location . ")) ";
      }
  }

  $loc2 = '';
  if( isset($row_rsCli['b_loc2_cli']) && $row_rsCli['b_loc2_cli'] != '' ){
      $province = implode(',', $row_rsCli['b_loc2_cli']);
      if ($province != '') {
          $loc2 = "AND (properties_loc2.id_loc2 IN (" . $province . ") OR properties_loc2.parent_loc2 IN (" . $province . ") OR province1.id_loc2 IN (" . $province . ") OR province1.parent_loc2 IN (" . $province . ")) ";
      }
  }

  $loc1 = '';
  if( isset($row_rsCli['b_loc1_cli']) && $row_rsCli['b_loc1_cli'] != '' ){
      $location = implode(',', $row_rsCli['b_loc1_cli']);
      if ($location != '') {
          $loc1 = "AND id_loc1 IN (" . $location . ")";
      }
  }



  $query_rsFavs = "SELECT
  (SELECT referencia_prop FROM properties_properties WHERE id_prop = property) AS property
   FROM users_favorites WHERE user= '".$row_rsCli['user_cli']."' GROUP BY user, property ORDER BY id";
  $rsFavs = mysqli_query($inmoconn,$query_rsFavs) or die(mysqli_error());
  $row_rsFavs = mysqli_fetch_assoc($rsFavs);
  $totalRows_rsFavs = mysqli_num_rows($rsFavs);

  $favs = array();
  do {
    if ($favs !== null && $row_rsFavs !== null && $row_rsFavs['property'] !== null)
      array_push($favs, $row_rsFavs['property']);
  } while ($row_rsFavs = mysqli_fetch_assoc($rsFavs));

  $fav = '';
  if( count($favs) > 0 ){
      $favs2 = array();
      foreach ($favs as $value) {
        if (trim($value) != '') {
          array_push($favs2, "'".$value."'");
        }
      }
      $faverence = implode(',', $favs2);
      if (trim($faverence) != '') {
          $fav = "OR referencia_prop IN (" . $faverence . ")";
      }
  }

  $ocultos = '';
  if( isset($row_rsCli['b_ocultos_cli'][0]) && $row_rsCli['b_ocultos_cli'][0] != '' ){
      $ocultos = array();
      foreach ($row_rsCli['b_ocultos_cli'] as $value) {
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
  if (isset($_GET['po']) && $_GET['po'] != '') {
      $po = "AND FIND_IN_SET(" . intval($_GET['po']) . ", piscina_prop)";
  }

  $rps = '';
  if( isset($_GET['rps']) && $_GET['rps'] != '' ){
      $rps = "AND embargo_prop = " . $_GET['rps'];
  }

  $dir = '';
  if( isset($_GET['direccion']) && $_GET['direccion'] != '' ){
      $dir = "AND direccion_prop LIKE '%" . $_GET['direccion']."%'";
  }

  $dirr = '';
  if( isset($row_rsCli['b_direcc_cli']) && $row_rsCli['b_direcc_cli'] != '' ){
      $dirr = "AND direccion_prop LIKE '%" . $row_rsCli['b_direcc_cli']."%'";
  }

  $urb = '';
  if( isset($row_rsCli['b_urb_cli']) && $row_rsCli['b_urb_cli'] != '' ){
      $urb = "AND urbanizacion_prop LIKE '%" . $row_rsCli['b_urb_cli']."%'";
  }

  $pisc2 = '';
  if (isset($_GET['b_piscina_cli']) && $_GET['b_piscina_cli'] != '' && $_GET['b_piscina_cli'] != '0') {
      $pisc2 = "AND FIND_IN_SET(" . intval($_GET['b_piscina_cli']) . ", piscina_prop)";
  }

  $gargg = '';
  if( isset($row_rsCli['b_garaje_cli']) && $row_rsCli['b_garaje_cli'] != '' ){
      $gargg = "AND parking_prop LIKE '%" . $row_rsCli['b_garaje_cli']."%'";
  }

  $vismarr = '';
  if( isset($row_rsCli['b_vistasmar_cli']) && $row_rsCli['b_vistasmar_cli'] != '' ){
      $vismarr = "AND vistas_mar_prop LIKE '%" . $row_rsCli['b_vistasmar_cli']."%'";
  }

  $obrnws = '';
  if( isset($row_rsCli['b_obranueva_cli']) && $row_rsCli['b_obranueva_cli'] != '' ){
      $obrnws = "AND obra_nueva_prop LIKE '%" . $row_rsCli['b_obranueva_cli']."%'";
  }

  $m2d = '';
  if( isset($row_rsCli['b_m2_desde_cli'][0]) && $row_rsCli['b_m2_desde_cli'][0] != '' ){
    $m2d = "AND m2_prop >= " . $row_rsCli['b_m2_desde_cli'][0]."";
  }

  $m2h = '';
  if( isset($row_rsCli['b_m2_hasta_cli'][0]) && $row_rsCli['b_m2_hasta_cli'][0] != '' ){
    $m2h = "AND m2_prop <= " . $row_rsCli['b_m2_hasta_cli'][0]."";
  }

  $m2pd = '';
  if( isset($row_rsCli['b_m2p_desde_cli'][0]) && $row_rsCli['b_m2p_desde_cli'][0] != '' ){
    $m2pd= "AND m2_parcela_prop >= " . $row_rsCli['b_m2p_desde_cli'][0]."";
  }

  $m2ph = '';
  if( isset($row_rsCli['b_m2p_hasta_cli'][0]) && $row_rsCli['b_m2p_hasta_cli'][0] != '' ){
    $m2ph= "AND m2_parcela_prop <= " . $row_rsCli['b_m2p_hasta_cli'][0]."";
  }

  $pool = '';
  if (isset($_GET['b_pool_cli']) && !empty($_GET['b_pool_cli'][0])) {
      $pools = array_map('intval', $_GET['b_pool_cli']);
      $conditions = array();
      foreach ($pools as $value) {
          $conditions[] = "FIND_IN_SET(" . $value . ", piscina_prop)";
      }
      if (!empty($conditions)) {
          $pool = "AND (" . implode(' OR ', $conditions) . ")";
      }
  }

  $parking = '';
  if( isset($row_rsCli['b_parking_cli'][0]) && $row_rsCli['b_parking_cli'][0] != '' ){
    $parkings = array();
    foreach ($row_rsCli['b_parking_cli'] as $value) {
      array_push($parkings, "'".$value."'");
    }
    $parkingsids = implode(',', $parkings);
    if ($parkingsids != '') {
        $parking = "AND parking_prop IN (" . $parkingsids . ")";
    }
  }

  // $query_RS = "SELECT GROUP_CONCAT(property) as ids FROM cli_prop_int WHERE client = '".$_GET['id_cli']."' GROUP BY client";
  // $RS = mysqli_query($inmoconn,$query_RS) or die(mysqli_error());
  // $row_RS = mysqli_fetch_assoc($RS);
  // $totalRows_RS = mysqli_num_rows($RS);

  $retQRY = '';
  // if ($row_RS !== null && $row_RS['ids']!== null && $row_RS['ids'] != '') {
  //     $retQRY .= ' AND id_prop NOT IN ('.$row_RS['ids'].')';
  // }

  
  $query_RS = "SELECT GROUP_CONCAT(property) as ids FROM cli_prop_noint WHERE client = '".$_GET['id_cli']."' GROUP BY client";
  $RS = mysqli_query($inmoconn,$query_RS) or die(mysqli_error());
  $row_RS = mysqli_fetch_assoc($RS);
  $totalRows_RS = mysqli_num_rows($RS);

  if ( $row_RS!==null && $row_RS['ids']!== null && $row_RS['ids'] != '') {
      $retQRY .= ' AND id_prop NOT IN ('.$row_RS['ids'].')';
  }

  $conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
  $isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
  $isLoggedIn1->addLevel("7");
  if ($isLoggedIn1->Execute()) {

      if($sWhere != '') {
          $sWhere .= ' AND user_prop = \''.$_SESSION['kt_login_id'].'\' ';
      } else {
          $sWhere .= ' WHERE user_prop = \''.$_SESSION['kt_login_id'].'\' ';
      }

      $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);

  }

  $distBeach = '';
  if($row_rsCli['b_dist_beach_from_cli'] != '' || $row_rsCli['b_dist_beach_to_cli'] != '') {
      $distBeach = "AND distance_beach_med_prop = '" . $row_rsCli['b_dist_beach_val_cli'] . "'";
      if ($row_rsCli['b_dist_beach_from_cli'] > 0) {
          $distBeach .= " AND distance_beach_prop >= " . $row_rsCli['b_dist_beach_from_cli'] . "";
      }
      if ($row_rsCli['b_dist_beach_to_cli'] > 0) {
          $distBeach .= " AND distance_beach_prop <= " . $row_rsCli['b_dist_beach_to_cli'] . "";
      }
  }

  $distAmenit = '';
  if($row_rsCli['b_dist_amenit_from_cli'] != '' || $row_rsCli['b_dist_amenit_to_cli'] != '') {
      $distAmenit = "AND distance_amenities_med_prop = '" . $row_rsCli['b_dist_amenit_val_cli'] . "'";
      if ($row_rsCli['b_dist_amenit_from_cli'] > 0) {
          $distAmenit .= " AND distance_amenities_prop >= " . $row_rsCli['b_dist_amenit_from_cli'] . "";
      }
      if ($row_rsCli['b_dist_amenit_to_cli'] > 0) {
          $distAmenit .= " AND distance_amenities_prop <= " . $row_rsCli['b_dist_amenit_to_cli'] . "";
      }
  }

  $distAirport = '';
  if($row_rsCli['b_dist_airport_from_cli'] != '' || $row_rsCli['b_dist_airport_to_cli'] != '') {
      $distAirport = "AND distance_airport_med_prop = '" . $row_rsCli['b_dist_airport_val_cli'] . "'";
      if ($row_rsCli['b_dist_airport_from_cli'] > 0) {
          $distAirport .= " AND distance_airport_prop >= " . $row_rsCli['b_dist_airport_from_cli'] . "";
      }
      if ($row_rsCli['b_dist_airport_to_cli'] > 0) {
          $distAirport .= " AND distance_airport_prop <= " . $row_rsCli['b_dist_airport_to_cli'] . "";
      }
  }

  $distGolf = '';
  if($row_rsCli['b_dist_golf_from_cli'] != '' || $row_rsCli['b_dist_golf_to_cli'] != '') {
      $distGolf = "AND distance_golf_med_prop = '" . $row_rsCli['b_dist_golf_val_cli'] . "'";
      if ($row_rsCli['b_dist_golf_from_cli'] > 0) {
          $distGolf .= " AND distance_golf_prop >= " . $row_rsCli['b_dist_golf_from_cli'] . "";
      }
      if ($row_rsCli['b_dist_golf_to_cli'] > 0) {
          $distGolf .= " AND distance_golf_prop <= " . $row_rsCli['b_dist_golf_to_cli'] . "";
      }
  }



  /*
   * SQL queries
   * Get data to display
   */

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.referencia_prop,
      properties_status.status_" .$lang_adm. "_sta,
      CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS types_" .$lang_adm. "_typ,
      CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS name_" .$lang_adm. "_loc3,
      CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS name_" .$lang_adm. "_loc4,
      preci_reducidoo_prop,
      case properties_properties.activado_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as activado_prop,
      properties_properties.id_prop,
      properties_properties.id_prop as image_img,
      CONCAT(nombre_pro, ' ', apellidos_pro) as nombre_pro,
      CONCAT(telefono_fijo_pro, '<br>', telefono_movil_pro) as telefono_fijo_pro
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

    $sWhere
    $retQRY
    $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $dirr $urb $pisc2 $gargg $vismarr $obrnws $pool $parking
    $distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph

AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND force_hide_prop != 1

GROUP BY id_prop

    $sOrder
    $sLimit
  ";

if (isset($_GET['debug'])) {
  echo  $sQuery . '<hr>';
}

  $rResult = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  /* Data set length after filtering */
  $sQuery = "
    SELECT FOUND_ROWS()
  ";
  $rResultFilterTotal = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
  $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
  $iFilteredTotal = $aResultFilterTotal[0];

  echo '<b>' . $iFilteredTotal . '</b>';
?>
