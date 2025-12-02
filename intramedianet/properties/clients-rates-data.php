<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

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
array_push($aColumns, "client");
array_push($aColumns, "property");
array_push($aColumns, "rate");
array_push($aColumns, "location");
array_push($aColumns, "type");
array_push($aColumns, "price");
array_push($aColumns, "bedrooms");
array_push($aColumns, "other");
array_push($aColumns, "date");
array_push($aColumns, "id_cli");


  array_push($aColumns, 'id');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id";

  /* DB table to use */
  $sTable = "cli_prop_rate";

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
    header( $_SERVER['SERVER_cliTOCOL'] .' 500 Internal Server Error' );
    die( $sErrorMessage );
  }


  /*
   * MySQL connection
   */
  if ( ! $gaSql['link'] = mysqli_connect( $gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db']) )
  {
    fatal_error( 'Could not open connection to server' );
  }

  //$rResult = mysqli_query($gaSql['link'], "SET NAMES 'utf8'");

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

        if($aColumns[$i] == 'id_cli') {
          $sWhere .= "(SELECT id_cli FROM properties_client WHERE id_cli = client) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
        } else {
          $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
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

        if($aColumns[$i] == 'rate' || $aColumns[$i] == 'location' || $aColumns[$i] == 'type' || $aColumns[$i] == 'price' || $aColumns[$i] == 'bedrooms' || $aColumns[$i] == 'other') {
              if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('Sí', true)))) {
                  $sWhere .= $aColumns[$i]." = '1' ";
              }

              if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('No', true)))) {
                  $sWhere .= $aColumns[$i]." = '0' ";
              }
        } else {
              if($aColumns[$i] == 'date') {
                $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
              } else {
                if($aColumns[$i] == 'property') {
                  $sWhere .= "(SELECT referencia_prop FROM properties_properties WHERE id_prop = property) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                } else {
                    if($aColumns[$i] == 'client') {
                      $sWhere .= "(SELECT CONCAT_WS(' ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = client) LIKE '%" . mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i]) . "%' ";
                    } else {
                      if($aColumns[$i] == 'id_cli') {
                        $sWhere .= "(SELECT id_cli FROM properties_client WHERE id_cli = client) LIKE '%" . mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i]) . "%' ";
                      } else {
                        $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                      }
                    }
                }
              }
        }
    }
  }

  if($sWhere != '') {
      $sWhere .= ' ';
  } else {
      $sWhere .= ' WHERE 1=1';
  }

  $isCLI = '';
  // if( isset($_GET['id_cli']) && $_GET['id_cli'] != '' ){
  //     $isCLI = "AND (SELECT id_cli FROM properties_client WHERE id_cli = client) = '" . $_GET['id_cli'] . "'";
  // }


  /*
   * SQL queries
   * Get data to display
   */

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      (SELECT id_cli FROM properties_client WHERE id_cli = client) AS id_cli,
      (SELECT CONCAT_WS(' ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = client) AS client,
      (SELECT referencia_prop FROM properties_properties WHERE id_prop = property) AS property,
      case rate
          when '1' then '<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"color: green\"></i>'
          when '0' then '<i class=\"fa fa-thumbs-down\" aria-hidden=\"true\" style=\"color: red\"></i>'
      end as rate,
      case location
          when '1' then '<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i>'
          when '0' then '<i class=\"fa-regular fa-square\" aria-hidden=\"true\"></i>'
      end as location,
      case type
          when '1' then '<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i>'
          when '0' then '<i class=\"fa-regular fa-square\" aria-hidden=\"true\"></i>'
      end as type,
      case price
          when '1' then '<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i>'
          when '0' then '<i class=\"fa-regular fa-square\" aria-hidden=\"true\"></i>'
      end as price,
      case bedrooms
          when '1' then '<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i>'
          when '0' then '<i class=\"fa-regular fa-square\" aria-hidden=\"true\"></i>'
      end as bedrooms,
      case other
          when '1' then '<i class=\"fa fa-check-square\" aria-hidden=\"true\"></i>'
          when '0' then '<i class=\"fa-regular fa-square\" aria-hidden=\"true\"></i>'
      end as other,
      date
    FROM cli_prop_rate
    $sWhere $isCLI
    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery . '<hr>');

  // echo  $sQuery . '<hr>';

  /* Data set length after filtering */
  $sQuery = "
    SELECT FOUND_ROWS()
  ";
  $rResultFilterTotal = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
  $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
  $iFilteredTotal = $aResultFilterTotal[0];

  /* Total data set length */
  $sQuery = "
    SELECT COUNT(".$sIndexColumn.")
    FROM   $sTable WHERE 1 = 1 $isCLI
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
      if($aColumns[$i] == 'date') {

          if ($aRow[ $aColumns[$i] ] == null) {
            $row[] = '&nbsp;';
          } else {
            $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
          }
      } else {
          $row[] = utf8_encode($aRow[ $aColumns[$i] ]);
      }
    }
    $output['aaData'][] = $row;
  }

  echo $_GET['callback'].''.json_encode( $output ).'';
?>
