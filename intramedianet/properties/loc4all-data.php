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
  // foreach ($languages as $value) {
  array_push($aColumns, 'country');
  array_push($aColumns, 'province');
  array_push($aColumns, 'town');
  array_push($aColumns, 'loc4.name_'.$lang_adm.'_loc4');
  // }

if ($mapeo == 1) {
  array_push($aColumns, 'properties_loc4.name_'.$lang_adm.'_loc4');
}
  array_push($aColumns, 'id_loc4');

  array_push($aColumns, 'provinceID');
  array_push($aColumns, 'countryID');
  array_push($aColumns, 'townID');
  array_push($aColumns, 'loc4.parent_loc4');


  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_loc4";

  /* DB table to use */
  $sTable = "properties_loc4";

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
        $sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
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
        $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string( $gaSql['link'],$_GET['sSearch'] )."%' OR ";
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

                if($aColumns[$i] == 'country') {
                  $sWhere .= "(SELECT name_".$lang_adm."_loc1 FROM properties_loc1 WHERE id_loc1 = (SELECT loc1_loc2 FROM properties_loc2 WHERE id_loc2 = (SELECT loc2_loc3 FROM properties_loc3 WHERE id_loc3 = loc4.loc3_loc4))) LIKE '".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                } else {
                  if($aColumns[$i] == 'province') {
                    $sWhere .= "(SELECT name_".$lang_adm."_loc2 FROM properties_loc2 WHERE id_loc2 = (SELECT loc2_loc3 FROM properties_loc3 WHERE id_loc3 = loc4.loc3_loc4)) LIKE '".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                  } else {
                    if($aColumns[$i] == 'town') {
                      $sWhere .= "(SELECT name_".$lang_adm."_loc3 FROM properties_loc3 WHERE id_loc3 = loc4.loc3_loc4) LIKE '".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                    } else {
                      $sWhere .= $aColumns[$i]." LIKE '".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                    }
                  }
                }
    }
  }


  /*
   * SQL queries
   * Get data to display
   */
  $campos = '';
  // foreach ($languages as $value) {
    $campos .= 'loc4.name_'.$lang_adm.'_loc4, ';
  // }

  // if($sWhere == '') {
  //   $sWhere .= " WHERE    loc4.loc3_loc4 = '".$_GET['NxT_id_loc4']."' ";
  // } else {
  //   $sWhere .= " AND    loc4.loc3_loc4 = '".$_GET['NxT_id_loc4']."' ";
  // }

// if ($mapeo == 1) {
  $tipo = "properties_loc4.name_".$lang_adm."_loc4 as feat,";
// }

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      " . $campos . "
      (SELECT name_".$lang_adm."_loc3 FROM properties_loc3 WHERE id_loc3 = loc4.loc3_loc4) as town,
      (SELECT id_loc3 FROM properties_loc3 WHERE id_loc3 = loc4.loc3_loc4) as townID,
      (SELECT loc2_loc3 FROM properties_loc3 WHERE id_loc3 = loc4.loc3_loc4) as townPARENT,
      (SELECT name_".$lang_adm."_loc2 FROM properties_loc2 WHERE id_loc2 = townPARENT) as province,
      (SELECT id_loc2 FROM properties_loc2 WHERE id_loc2 = townPARENT) as provinceID,
      (SELECT loc1_loc2 FROM properties_loc2 WHERE id_loc2 = townPARENT) as provincePARENT,
      (SELECT name_".$lang_adm."_loc1 FROM properties_loc1 WHERE id_loc1 = provincePARENT) as country,
      (SELECT id_loc1 FROM properties_loc1 WHERE id_loc1 = provincePARENT) as countryID,
      " . $tipo . "
      loc4.id_loc4,
      loc4.parent_loc4
    FROM properties_loc4 loc4 LEFT OUTER JOIN properties_loc4 ON loc4.parent_loc4 = properties_loc4.id_loc4
    $sWhere
    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query($gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  /*



      (SELECT name_".$lang_adm."_loc1 FROM properties_loc1 WHERE id_loc1 = countryID) as country,
   */

  // echo "<pre>";
  // print_r(mysqli_fetch_assoc( $rResult ));
  // echo "<pre>";

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
  $rResultTotal = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
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
      if ($aColumns[$i] != 'properties_loc4.name_'.$lang_adm.'_loc4') {
        if(preg_match('/loc4\.name_'.$lang_adm.'_loc4/', $aColumns[$i])) {
            $row[] = $aRow[ preg_replace('/loc4\./', '', $aColumns[$i]) ] . ' <span class="badge bg-primary float-end">' . $aRow['id_loc4'] . '</span>';
        } else {
          if(isset($aRow[ $aColumns[$i] ]))
            $row[] = $aRow[ $aColumns[$i] ];
        }
      } else {
        if ($aRow[ preg_replace('/properties_loc4\.name_'.$lang_adm.'_loc4/', 'feat', $aColumns[$i]) ] != '') {
            $row[] = $aRow[ preg_replace('/properties_loc4\.name_'.$lang_adm.'_loc4/', 'feat', $aColumns[$i]) ] . ' <span class="badge bg-primary float-end">' . $aRow['parent_loc4'] . '</span>';
        } else {
            $row[] = $aRow[ preg_replace('/properties_loc4\.name_'.$lang_adm.'_loc4/', 'feat', $aColumns[$i]) ];
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
