<?php

// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

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
  $aColumns = array( 'inmueble_cons', 'nombre_cons', 'telefono_cons', 'email_cons', 'fecha_cons', 'read_cons', 'id_cons', 'id_inmueble_cons' );

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_cons";

  /* DB table to use */
  $sTable = "properties_enquiries";

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
        if($aColumns[$i] == 'fecha_cons') {
          $sWhere .= "DATE_FORMAT(`fecha_cons`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
        }
        else {

            if ($aColumns[$i] == 'nivel_usr') {


                        if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Administrador', true)))) {
                            $sWhere .= $aColumns[$i]." = '9' OR ";
                        }

                        if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Editor', true)))) {
                            $sWhere .= $aColumns[$i]." = '8' OR ";
                        }

                        if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Agente', true)))) {
                            $sWhere .= $aColumns[$i]." = '7' OR ";
                        }

                        if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Usuario', true)))) {
                            $sWhere .= $aColumns[$i]." = '1' OR ";
                        }
                    } else {
                        $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
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

      if($aColumns[$i] == 'fecha_cons') {
        $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
      } else {
        if ($aColumns[$i] == 'inmueble_cons') {

            $sWhere .= "(SELECT referencia_prop FROM properties_properties WHERE id_prop = inmueble_cons LIMIT 1) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";

        } else {
            $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
        }

      }

    }
  }

  $conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
  $isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
  $isLoggedIn1->addLevel("7");
  if ($isLoggedIn1->Execute()) {

      if($sWhere != '') {
          $sWhere .= ' AND (SELECT user_prop FROM properties_properties WHERE id_prop = inmueble_cons LIMIT 1) = \''.$_SESSION['kt_login_id'].'\' ';
      } else {
          $sWhere .= ' WHERE (SELECT user_prop FROM properties_properties WHERE id_prop = inmueble_cons LIMIT 1) = \''.$_SESSION['kt_login_id'].'\' ';
      }

      $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);

  }




  /*
   * SQL queries
   * Get data to display
   */
  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS (SELECT referencia_prop FROM properties_properties WHERE id_prop = inmueble_cons LIMIT 1)  AS inmueble_cons,  nombre_cons, telefono_cons, email_cons, fecha_cons, read_cons, id_cons, (SELECT id_prop FROM properties_properties WHERE id_prop = inmueble_cons LIMIT 1)  AS id_inmueble_cons
    FROM   $sTable
    $sWhere
    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery . '<hr>');

  // echo   $sQuery.'<hr>';

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
    FROM   $sTable
  ";
  $rResultTotal = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
  $aResultTotal = mysqli_fetch_array($rResultTotal);
  $iTotal = $aResultTotal[0];


  /*
   * Output
   */
  $output = array(
    "sEcho" => intval(@$_GET['sEcho']),
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
        if($aColumns[$i] == 'fecha_cons') {
            $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
        } else {
            if ($aColumns[$i] == 'nivel_usr') {
                switch ($aRow[ $aColumns[$i] ]) {
                    case 10:
                        $row[] = __('Superadmin', true);
                        break;
                    case 9:
                        $row[] = __('Administrador', true);
                        break;
                    case 8:
                        $row[] = __('Editor', true);
                        break;
                    case 7:
                        $row[] = __('Agente', true);
                        break;
                    case 1:
                        $row[] = __('Usuario', true);
                        break;
                    default:
                        $row[] = '-';
                        break;
                }
            } else {
              if($aRow[ $aColumns[$i] ]!==null)
                $row[] = $aRow[ $aColumns[$i] ];
              else
                $row[] = '';
            }
        }

      }
    }
    $output['aaData'][] = $row;
  }

  if(isset($_GET['callback']))
    echo $_GET['callback'].''.json_encode( $output ).'';
  else
    echo json_encode( $output );
?>
