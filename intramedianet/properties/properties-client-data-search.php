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


  $aColumns = array('id_prop', 'image_img', 'referencia_prop', 'status_' .$lang_adm. '_sta', 'types_' .$lang_adm. '_typ', 'name_' .$lang_adm. '_loc3', 'name_' .$lang_adm. '_loc4', 'preci_reducidoo_prop', 'activado_prop', 'id_prop');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_prop";

  /* DB table to use */
  $sTable = "properties_properties";

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
  //$gaSql['db']
  //@mysqli_query("SET NAMES 'utf8mb4'");
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
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'] )."%' OR ";
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
        if($aColumns[$i] == 'destacado_prop' || $aColumns[$i] == 'activado_prop' || $aColumns[$i] == 'ubiflow_prop' || $aColumns[$i] == 'rightmove_prop' || $aColumns[$i] == 'greenacres_prop' || $aColumns[$i] == 'zoopla_prop' || $aColumns[$i] == 'inmoweb_prop' || $aColumns[$i] == 'trovit_prop') {

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('Sí', true)))) {
              $sWhere .= $aColumns[$i]." = '1' ";
          }

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('No', true)))) {
              $sWhere .= $aColumns[$i]." = '0' ";
          }

        } else {

                if($aColumns[$i] == 'nombre_pro') {
                  $sWhere .= " CONCAT_WS(' ', nombre_pro, apellidos_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                } else {
                  if($aColumns[$i] == 'telefono_fijo_pro') {
                    $sWhere .= " CONCAT_WS(' ', telefono_fijo_pro, telefono_movil_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
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

  if($sWhere != '') {
      $sWhere .= ' AND (id_prop IS NOT NULL OR id_prop != \'\') ';
  } else {
      $sWhere .= ' WHERE (id_prop IS NOT NULL OR id_prop != \'\' )';
  }



  $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);

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

  $coast = '';
  if( isset($_GET['b_coast_cli']) && $_GET['b_coast_cli'] != '' )
  {
      $costa = implode(',', $_GET['b_coast_cli']);
      if ($costa != '') 
      {
          $coast = "AND (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END IN (" . $costa . ") ) ";  
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
  if( isset($_GET['piscina_prop']) && $_GET['piscina_prop'] != '' ){
      $pool = "AND piscina_prop LIKE '%" . $_GET['piscina_prop']."%'";
  }

  $parking = '';
  if( isset($_GET['parking_prop']) && $_GET['parking_prop'] != '' ){
      $parking = "AND parking_prop LIKE '%" . $_GET['parking_prop']."%'";
  }

  $atendido_por_prop = '';
  if( isset($_GET['atendido_por_prop']) && $_GET['atendido_por_prop'] != '' ){
      $atendido_por_prop = "AND atendido_por_prop LIKE '%" . $_GET['atendido_por_prop']."%'";
  }

  $captado_prop = '';
  if( isset($_GET['captado_prop']) && $_GET['captado_prop'] != '' ){
      $captado_prop = "AND captado_prop LIKE '%" . $_GET['captado_prop']."%'";
  }

  $palabras_clave = '';
  if( isset($_GET['palabras_clave']) && $_GET['palabras_clave'] != '' ){
      if(count(explode(" ",mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave']))) == 1)
          $palabras_clave = "AND (properties_properties.descripcion_".$lang_adm."_prop LIKE '%" . mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave'])."%' OR titulo_".$lang_adm."_prop LIKE '%" . mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave'])."%')";
      else
          $palabras_clave = " AND MATCH(properties_properties.descripcion_".$lang_adm."_prop, titulo_".$lang_adm."_prop) AGAINST ('".mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave'])."' IN BOOLEAN MODE)";
  }

  $distBeach = '';
  if($_GET['distance_beach_prop_from'] != '' || $_GET['distance_beach_prop_to'] != '') {
      $distBeach = "AND distance_beach_med_prop = '" . $_GET['distance_beach_med_prop'] . "'";
      if ($_GET['distance_beach_prop_from'] > 0) {
          $distBeach .= " AND distance_beach_prop >= " . $_GET['distance_beach_prop_from'] . "";
      }
      if ($_GET['distance_beach_prop_to'] > 0) {
          $distBeach .= " AND distance_beach_prop <= " . $_GET['distance_beach_prop_to'] . "";
      }
  }

  $distAmenit = '';
  if($_GET['distance_amenities_prop_from'] != '' || $_GET['distance_amenities_prop_to'] != '') {
      $distAmenit = "AND distance_amenities_med_prop = '" . $_GET['distance_amenities_med_prop'] . "'";
      if ($_GET['distance_amenities_prop_from'] > 0) {
          $distAmenit .= " AND distance_amenities_prop >= " . $_GET['distance_amenities_prop_from'] . "";
      }
      if ($_GET['distance_amenities_prop_to'] > 0) {
          $distAmenit .= " AND distance_amenities_prop <= " . $_GET['distance_amenities_prop_to'] . "";
      }
  }

  $distAirport = '';
  if($_GET['distance_airport_prop_from'] != '' || $_GET['distance_airport_prop_to'] != '') {
      $distAirport = "AND distance_airport_med_prop = '" . $_GET['distance_airport_med_prop'] . "'";
      if ($_GET['distance_airport_prop_from'] > 0) {
          $distAirport .= " AND distance_airport_prop >= " . $_GET['distance_airport_prop_from'] . "";
      }
      if ($_GET['distance_airport_prop_to'] > 0) {
          $distAirport .= " AND distance_airport_prop <= " . $_GET['distance_airport_prop_to'] . "";
      }
  }

  $distGolf = '';
  if($_GET['distance_golf_prop_from'] != '' || $_GET['distance_golf_prop_to'] != '') {
      $distGolf = "AND distance_golf_med_prop = '" . $_GET['distance_golf_med_prop'] . "'";
      if ($_GET['distance_golf_prop_from'] > 0) {
          $distGolf .= " AND distance_golf_prop >= " . $_GET['distance_golf_prop_from'] . "";
      }
      if ($_GET['distance_golf_prop_to'] > 0) {
          $distGolf .= " AND distance_golf_prop <= " . $_GET['distance_golf_prop_to'] . "";
      }
  }

  //https://localhost:3000/intramedianet/properties/properties-client-data-search.php?b_beds_cli=&b_baths_cli=&m2ut=0&m2pl=0&or=&piscina_prop=&parking_prop=&b_precio_desde_cli=&nw=&res=&b_precio_hasta_cli=&ven=&alq=&atendido_por_prop=&distance_beach_med_prop=Km&distance_beach_prop_from=&distance_beach_prop_to=&distance_amenities_med_prop=Km&distance_amenities_prop_from=&distance_amenities_prop_to=&direccion=&palabras_clave=&captado_prop=&distance_airport_med_prop=Km&distance_airport_prop_from=&distance_airport_prop_to=&distance_golf_med_prop=Km&distance_golf_prop_from=&distance_golf_prop_to=&sEcho=1&iColumns=10&sColumns=offert_prop%2C%2C%2C%2C%2C%2C%2C%2Cactivado_prop%2C&iDisplayStart=0&iDisplayLength=10&mDataProp_0=0&sSearch_0=&bRegex_0=false&bSearchable_0=false&bSortable_0=false&mDataProp_1=1&sSearch_1=&bRegex_1=false&bSearchable_1=false&bSortable_1=false&mDataProp_2=2&sSearch_2=&bRegex_2=false&bSearchable_2=true&bSortable_2=true&mDataProp_3=3&sSearch_3=&bRegex_3=false&bSearchable_3=true&bSortable_3=true&mDataProp_4=4&sSearch_4=&bRegex_4=false&bSearchable_4=true&bSortable_4=true&mDataProp_5=5&sSearch_5=&bRegex_5=false&bSearchable_5=true&bSortable_5=true&mDataProp_6=6&sSearch_6=&bRegex_6=false&bSearchable_6=true&bSortable_6=true&mDataProp_7=7&sSearch_7=&bRegex_7=false&bSearchable_7=true&bSortable_7=true&mDataProp_8=8&sSearch_8=&bRegex_8=false&bSearchable_8=true&bSortable_8=true&mDataProp_9=9&sSearch_9=&bRegex_9=false&bSearchable_9=false&bSortable_9=false&sSearch=&bRegex=false&iSortCol_0=0&sSortDir_0=asc&iSortingCols=1&_=1718785824356
  $nprop = '';
  if( 
    !isset($_GET['b_sale_cli']) && 
    !isset($_GET['b_type_cli']) && 
    !isset($_GET['b_orientacion_cli']) &&
    !isset($_GET['favs']) &&
    $_GET['b_beds_cli'] == '' && 
    $_GET['or'] == '' && 
    $_GET['b_baths_cli'] == ''  && 
    !isset($_GET['b_ref_cli']) && 
    $_GET['b_precio_desde_cli'] == '' && 
    $_GET['b_precio_hasta_cli'] == '' && 
    !isset($_GET['b_loc1_cli']) && 
    !isset($_GET['b_loc2_cli']) && 
    !isset($_GET['b_loc3_cli']) && 
    !isset($_GET['b_loc4_cli']) && 
    !isset($_GET['b_coast_cli']) && 
    !isset($_GET['b_opciones_cli']) && 
    !isset($_GET['b_opciones2_cli']) && 
    !isset($_GET['b_tags_cli']) && 
    $_GET['nw'] == '' && 
    $_GET['ven'] == '' && 
    $_GET['alq'] == '' && 
    $_GET['res'] == ''  && 
    !isset($_GET['rp']) && 
    !isset($_GET['cs']) && 
    !isset($_GET['sw']) && 
    !isset($_GET['ep']) && 
    !isset($_GET['po']) && 
    !isset($_GET['rps']) && 
    $_GET['direccion'] == '' && 
    $_GET['m2ut'] == '' && 
    $_GET['m2pl'] == '' && 
    $_GET['palabras_clave'] == '' && 
    $_GET['piscina_prop'] == '' && 
    $_GET['parking_prop'] == '' && 
    $_GET['atendido_por_prop'] == '' && 
    $_GET['captado_prop'] == '' 
    ){
    $nprop = "AND id_prop = ''";
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
      CONCAT_WS(' ', nombre_pro, apellidos_pro) as nombre_pro,
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

    $sWhere

    $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $tags $pool $parking $palabras_clave $atendido_por_prop  $captado_prop
    $distBeach $distAmenit $distAirport $distGolf $coast


GROUP BY id_prop

    $sOrder
    $sLimit
  ";

  // echo  $sQuery . '<hr>';

  $rResult = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  /* Data set length after filtering */
  $sQuery = "
    SELECT FOUND_ROWS()
  ";
  $rResultFilterTotal = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
  $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
  $iFilteredTotal = $aResultFilterTotal[0];

  /* Total data set length */
  $sQuery = "
    SELECT COUNT(".$sIndexColumn.")
    FROM   $sTable
  ";
  $rResultTotal = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
  $aResultTotal = mysqli_fetch_array($rResultTotal);
  $iTotal = $aResultTotal[0];


  /*
   * Output
   */
  $output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
  );

  while ( $aRow = mysqli_fetch_array( $rResult ) )
  {
    $row = array();
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
      if($aColumns[$i] == 'inserted_xml_prop') {

          if ($aRow[ $aColumns[$i] ] == null) {
            $row[] = '&nbsp;';
          } else {
            $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
          }
      }
      else if ( $aColumns[$i] != ' ' )
      {
        if ($aColumns[$i] == 'image_img') {
          $sQuery = "SELECT id_img FROM properties_images WHERE property_img = ".$aRow[ $aColumns[$i] ]." ORDER BY order_img LIMIT 1";
          $rImage = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
          $aResul = mysqli_fetch_array($rImage);
          if (isset($aResul['id_img']) && file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$aResul['id_img'].'_md.jpg')) {
                $row[] = '<a href="/media/images/properties/thumbnails/'.$aResul['id_img'].'_md.jpg" class="btn-img-list-carr"
              data-toggle="lightbox-" data-gallery="mnews-gallery-' . $aRow['id_prop'] . '" data-type="image" data-max-width="1500" data-title="' . $aRow['referencia_prop'] . ' - ' . $aRow['name_' .$lang_adm. '_loc3'] . ' - ' . $aRow['types_' .$lang_adm. '_typ'] . '" data-id="' . $aRow['id_prop'] . '"><img src="/media/images/properties/thumbnails/'.$aResul['id_img'].'_sm.jpg" alt="" style="max-height: 150px;"></a>';
            } else {
                $row[] = '<img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="max-height: 70px;">';
            }
        } else {
          if ($aColumns[$i] == 'preci_reducidoo_prop') {
              $row[] = number_format($aRow[ $aColumns[$i] ], 0 , ',', '.');
          } else {
              $row[] = ($aRow[ $aColumns[$i] ]);
          }
        }
      }
    }
    $output['aaData'][] = $row;
  }
  if(isset($_GET['callback']))
    echo $_GET['callback'].''.json_encode( $output ).'';
  else
    echo json_encode( $output ).'';
?>
