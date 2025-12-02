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



  $aColumns = array();

  array_push($aColumns, 'referencia_prop');
  array_push($aColumns, 'inserted_xml_prop');
  array_push($aColumns, 'updated_prop');
  array_push($aColumns, 'listado');
  array_push($aColumns, 'propiedad');
  array_push($aColumns, 'consulta');
  array_push($aColumns, 'amigo');
  array_push($aColumns, 'impreso');
  array_push($aColumns, 'favoritos');

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
        if ($aColumns[$i] == 'categoria_nws') {
          $sWhere .= " (SELECT category_en_ct FROM news_categories WHERE id_ct = categoria_nws) LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'] )."%' OR ";
        } else {
          if($aColumns[$i] == 'date_nws') {
            $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'])."%' OR ";
          }
          else {
            $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'])."%' OR ";
          }
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

      if ($aColumns[$i] == 'categoria_nws') {

        $sWhere .= " (SELECT category_en_ct FROM news_categories WHERE id_ct = categoria_nws) LIKE '%".mysqli_real_escape_string($inmoconn,$_GET['sSearch_'.$i])."%' ";
      } else {
        if($aColumns[$i] == 'date_nws') {
          $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($inmoconn, $_GET['sSearch_'.$i])."%' ";
        } else {
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($inmoconn, $_GET['sSearch_'.$i])."%' ";
        }
      }


    }
  }


  if($sWhere != '') {
      $sWhere .= ' ';
  } else {
      $sWhere .= ' WHERE 1=1';
  }


$ref = '';
  if( isset($_GET['ref']) && $_GET['ref'] != '' ){
      $ref = "AND id_prop = " . $_GET['ref'];
  }


$desde= '';
  if( isset($_GET['desde']) && $_GET['desde'] != '' ){
      $desde= "AND date_log >= '" . date("Y-m-d", strtotime($_GET['desde']))."'";
  }
$hasta= '';
  if( isset($_GET['hasta']) && $_GET['hasta'] != '' ){
      $hasta= "AND date_log <= '" . date("Y-m-d", strtotime($_GET['hasta']))."'";
  }


  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.id_prop,
      properties_properties.referencia_prop,
      properties_properties.inserted_xml_prop,
      properties_properties.updated_prop,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 1  $desde $hasta GROUP BY prop_id_log, action_log), 0) as listado,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 2  $desde $hasta GROUP BY prop_id_log, action_log), 0) as propiedad,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 3  $desde $hasta GROUP BY prop_id_log, action_log), 0) as consulta,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 4  $desde $hasta GROUP BY prop_id_log, action_log), 0) as amigo,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 5  $desde $hasta GROUP BY prop_id_log, action_log), 0) as impreso,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 6  $desde $hasta GROUP BY prop_id_log, action_log), 0) as favoritos
    FROM properties_properties
    $sWhere $ref
    GROUP BY id_prop
    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  // echo  $sQuery . '<hr>';

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
      if ( $aColumns[$i] == "version" )
      {
        /* Special output formatting for 'version' column */
        $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
      }
      else if ( $aColumns[$i] != ' ' )
      {
        if($aColumns[$i] == 'inserted_xml_prop') {
            $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
        } else {
            if($aColumns[$i] == 'updated_prop') {
                $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
            } else {
                if ($aColumns[$i] == 'referencia_prop') {

                  $query_rsMenu = "SELECT id_prop FROM properties_properties WHERE referencia_prop = '".$aRow[ $aColumns[$i] ]."' LIMIT 1";
                  $rsMenu = mysqli_query($inmoconn, $query_rsMenu) or die(mysqli_error());
                  $row_rsMenu = mysqli_fetch_assoc($rsMenu);

                  $row[] = '<a href="/intramedianet/properties/properties-form.php?id_prop='.$row_rsMenu['id_prop'].'" target="_blank" class="btn btn-soft-primary btn-sm">'. $aRow[ $aColumns[$i] ] . '</a>';
                } else {
                  $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], 'UTF-8', 'ISO-8859-1');
                }
            }
        }
      }
    }
    $output['aaData'][] = $row;
  }
  if(isset($_GET['callback']))
    echo $_GET['callback'].''.(json_encode( $output )).'';
  else
    echo json_encode( $output );
?>
