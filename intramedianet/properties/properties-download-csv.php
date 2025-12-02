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


  $aColumns = array('id_prop', 'image_img', 'referencia_prop', 'status_' .$lang_adm. '_sta', 'types_' .$lang_adm. '_typ', 'name_' .$lang_adm. '_loc3', 'name_' .$lang_adm. '_loc4', 'preci_reducidoo_prop', 'activado_prop', 'nombre_pro', 'telefono_fijo_pro', 'id_prop');

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
          $sWhere .= "DATE_FORMAT(`inserted_xml_prop`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'])."%' OR ";
        } else {
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string( $gaSql['link'], $_GET['sSearch'] )."%' OR ";
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

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('Si', true)))) {
              $sWhere .= $aColumns[$i]." = '1' ";
          }

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('No', true)))) {
              $sWhere .= $aColumns[$i]." = '0' ";
          }

        } else {

                if($aColumns[$i] == 'nombre_pro') {
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
      $opciones2 = implode(',', $_GET['b_tags_cli']);
      if ($opciones2 != '') {
          $tags = "AND properties_property_tag.tag IN (" . $opciones2 . ")";
          $tagjoin = "INNER JOIN properties_property_tag ON properties_properties.id_prop = properties_property_tag.property";
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
  if( isset($_GET['piscina_prop']) && $_GET['piscina_prop'] != '' ){
      $pool = "AND piscina_prop LIKE '%" . $_GET['piscina_prop']."%'";
  }

  $parking = '';
  if( isset($_GET['parking_prop']) && $_GET['parking_prop'] != '' ){
      $parking = "AND parking_prop LIKE '%" . $_GET['parking_prop']."%'";
  }

  $palabras_clave = '';
  if( isset($_GET['palabras_clave']) && $_GET['palabras_clave'] != '' ){
      if(count(explode(" ",mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave']))) == 1)
          $palabras_clave = "AND (properties_properties.descripcion_".$lang_adm."_prop LIKE '%" . mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave'])."%' OR titulo_".$lang_adm."_prop LIKE '%" . mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave'])."%')";
      else
          $palabras_clave = " AND MATCH(properties_properties.descripcion_".$lang_adm."_prop, titulo_".$lang_adm."_prop) AGAINST ('".mysqli_real_escape_string($gaSql['link'],$_GET['palabras_clave'])."')";
  }

  $nprop = '';
  if( 
    !isset($_GET['b_sale_cli']) && 
    !isset($_GET['b_type_cli']) &&
    (isset($_GET['b_beds_cli']) && $_GET['b_beds_cli'] == '') && 
    $_GET['or'] == '' && 
    (isset($_GET['b_orientacion_cli']) && $_GET['b_orientacion_cli'] == '') && 
    (isset($_GET['favs']) && $_GET['favs'] == '') && 
    (isset($_GET['favs']) && $_GET['b_baths_cli'] == '')  && 
    !isset($_GET['b_ref_cli']) && 
    $_GET['b_precio_desde_cli'] == '' && 
    $_GET['b_precio_hasta_cli'] == '' && 
    !isset($_GET['b_loc1_cli']) && 
    !isset($_GET['b_loc2_cli']) && 
    !isset($_GET['b_loc3_cli']) && 
    !isset($_GET['b_loc4_cli']) && 
    !isset($_GET['b_opciones_cli']) && 
    !isset($_GET['b_opciones2_cli']) && 
    !isset($_GET['b_tags_cli']) && 
    $_GET['nw'] == '' && 
    $_GET['ven'] == '' && $_GET['alq'] == '' && $_GET['res'] == ''  && $_GET['rp'] == '' && $_GET['cs'] == '' && $_GET['sw'] == '' && $_GET['ep'] == '' && $_GET['po'] == '' && $_GET['rps'] == ''  && $_GET['direccion'] == ''  && $_GET['m2ut'] == ''  && $_GET['m2pl'] == '' && $_GET['palabras_clave'] == '' && $_GET['piscina_prop'] == ''  && $_GET['parking_prop'] == ''       ){
    $nprop = "AND id_prop = ''";
  }





  /*
   * SQL queries
   * Get data to display
   */

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.referencia_prop AS Referencia,
      case properties_properties.activado_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Activado,
      case properties_properties.destacado_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Destacado,
      properties_status.status_" .$lang_adm. "_sta AS Status,
      CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS Tipo,
      -- CONVERT(properties_loc1.name_" .$lang_adm. "_loc1 USING latin1) AS Pais,
      CASE WHEN properties_loc2.name_" .$lang_adm. "_loc2 IS NOT NULL THEN properties_loc2.name_" .$lang_adm. "_loc2 ELSE province1.name_" .$lang_adm. "_loc2  END AS Provincia,
      CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS Ciudad,
      CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS Zona,
      preci_reducidoo_prop AS Precio,
      precio_prop AS Precio_Anterior,
      case properties_properties.vendido_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Vendido,
      case properties_properties.alquilado_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Alquilado,
      case properties_properties.reservado_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Reservado,
      construccion_prop AS Ano_de_Construccion,
      energia_prop AS Calificacion_energetica,
      habitaciones_prop AS Habitaciones,
      aseos_prop AS Banos,
      aseos2_prop AS Aseos,
      cocinas_prop AS Cocinas,
      m2_prop AS M2,
      m2_parcela_prop AS M2_Parcela,
      m2_balcon_prop AS M2_Terraza,
      case properties_properties.export_kyero_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Kyero,
      case properties_properties.export_rightmove_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Rightmove,
      case properties_properties.idealista_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Idealista,
      case properties_properties.export_zoopla_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Zoopla,
      case properties_properties.export_thinkspain_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Thinkspain,
      case properties_properties.export_hemnet_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Hemnet,
      case properties_properties.export_ubiflow_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Ubiflow,
      case properties_properties.export_green_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_GreenAcress,
      case properties_properties.export_prian_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Prian,
      case properties_properties.export_habitaclia_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Habitaclia,
      case properties_properties.export_pisos_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Pisos_com,
      case properties_properties.export_facilisimo_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Exportar_Facilisimo,
      CONCAT_WS(' ', nombre_pro, apellidos_pro) as Nombre_Propietario,
      CONCAT_WS(' - ', telefono_fijo_pro, telefono_movil_pro) as Telefono_Propietario,
      email_pro as Email_Propietario
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

    $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $tags $pool $parking $palabras_clave


GROUP BY id_prop

    $sOrder
    $sLimit
  ";

  // echo  $sQuery . '<hr>';

  $rResult = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  $field = mysqli_num_fields($rResult);

  $return = array();

  $fila = array();

  // create line with field names
  for ($i = 0; $i < $field; $i++) {
    $field_info = $rResult->fetch_field_direct($i); // Obtener información del campo
    $field_name = $field_info->name; // Obtener el nombre del campo
    array_push($fila, $field_name);
  }
  array_push($return, $fila);
  // newline (seems to work both on Linux & Windows servers)
  // $csv_export.= '
  // ';
  while ($row = mysqli_fetch_array($rResult)) {
    // create line with field values
    $fila = array();
    for ($i = 0; $i < $field; $i++) {
        $field_info = $rResult->fetch_field_direct($i); // Obtener información del campo
        $field_name = $field_info->name; // Obtener el nombre del campo
        array_push($fila, $row[$field_name]);
        // $csv_export.= '"'.$row[$field_name].'",';
    }
    array_push($return, $fila);
    // $csv_export.= '
    // ';
}

// header("Content-type: text/x-csv");
// header("Content-Disposition: attachment; filename=".$csv_filename."");
// echo($csv_export);


//   die();

function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";") {
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'";');

  // open the "output" stream
  // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-description
  $f = fopen('php://output', 'w');

  if (!empty($array)) {
      // Get the headers of the first row (assuming all rows have the same keys)
      //$headers = array_keys($array[0]);
      //fputcsv($f, $headers, $delimiter);

      // Write the data
      foreach ($array as $line) {
          fputcsv($f, $line, $delimiter);
      }
  }

  fclose($f);
}



    // while ($row = mysqli_fetch_assoc($rResult)) {
    //   array_push($return, $row);
    // }

    // echo "<pre>";
    // print_r($return);
    // echo "</pre>";
    // die();

    array_to_csv_download($return, time() . ".csv");


?>
