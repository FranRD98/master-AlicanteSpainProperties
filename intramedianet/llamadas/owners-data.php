<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
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
$restrict->addLevel("6");
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
  $aColumns = array( 'nombre_pro','email_pro', 'telefono_fijo_pro', 'next_call_pro', 'captado_por_pro', 'id_pro',  'id_pro2' );

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_pro";

  /* DB table to use */
  $sTable = "properties_owner";

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
        if($aColumns[$i] == 'fecha_alta_pro' || $aColumns[$i] == 'next_call_pro') {
          $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
        }
        else {

            if ($aColumns[$i] == 'nombre_pro') {

                $sWhere .= "CONCAT_WS(' ', nombre_pro, apellidos_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";

            } else {
                if ($aColumns[$i] == 'telefono_fijo_pro') {

                    $sWhere .= "CONCAT_WS(' ', telefono_fijo_pro, telefono_movil_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";

                } else {
                    $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
                }
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

      if($aColumns[$i] == 'fecha_alta_pro' || $aColumns[$i] == 'next_call_pro') {
        $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
      } else {

        if ($aColumns[$i] == 'nombre_pro') {

            $sWhere .= "CONCAT_WS(' ', nombre_pro, apellidos_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";

        } else {
            if ($aColumns[$i] == 'telefono_fijo_pro') {

                $sWhere .= "CONCAT_WS(' ', telefono_fijo_pro, telefono_movil_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";

            } else {
                if ($aColumns[$i] == 'captado_por_pro') {

                    $sWhere .= "(SELECT category_".$lang_adm."_cap FROM properties_owner_captado WHERE id_cap = captado_por_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";

                } else {
                    $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                }
            }
        }


      }

    }
  }


$query_rsLlamadasPropIDSprops = "
SELECT GROUP_CONCAT(id_pro) AS total FROM properties_owner";
$rsLlamadasPropIDSprops = mysqli_query($inmoconn,$query_rsLlamadasPropIDSprops) or die(mysqli_error());
$row_rsLlamadasPropIDSprops = mysqli_fetch_assoc($rsLlamadasPropIDSprops);
$totalRows_rsLlamadasPropIDSprops = mysqli_num_rows($rsLlamadasPropIDSprops);

  // if($sWhere != '') {
  //     $sWhere .= ' AND  next_call_pro != \'\' AND (SELECT COUNT(id_prop) FROM properties_properties WHERE owner_prop = id_pro AND activado_prop = 1) > 0 ';
  // } else {
  //     $sWhere .= '  WHERE  next_call_pro != \'\' AND (SELECT COUNT(id_prop) FROM properties_properties WHERE owner_prop = id_pro AND activado_prop = 1) > 0 ';
  // }

  if ($_SESSION['kt_login_level'] == 9) {
      if($sWhere != '') {
          $sWhere .= ' AND  next_call_pro != \'\'  ';
      } else {
          $sWhere .= '  WHERE  next_call_pro != \'\'  ';
      }
  } else {
    if($sWhere != '') {
        $sWhere .= " AND  next_call_pro != ''  AND captado_por_pro = '" . $_SESSION['kt_login_id'] . "' "; //
    } else {
        $sWhere .= "  WHERE  next_call_pro != ''  AND captado_por_pro = '" . $_SESSION['kt_login_id']. "' "; //
    }
  }

  // echo "<hr>";
  // echo $sWhere;
  // echo "<hr>";

// $comercial = '';
// if( isset($_GET['comercial']) && $_GET['comercial'] != '' ){
//     $comercial = "AND vendedor_pro LIKE '" . $_GET['comercial'] . "'";
// }

  /*
   * SQL queries
   * Get data to display
   */
  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
    CONCAT(
        COALESCE(nombre_pro,''),
        IF(LENGTH(apellidos_pro), ' ', ''),
        COALESCE(apellidos_pro,'')
    ) AS nombre_pro,
    email_pro,
    CONCAT(
        COALESCE(TRIM(telefono_fijo_pro),''),
        IF(LENGTH(telefono_movil_pro), ' | ', ''),
        COALESCE(TRIM(telefono_movil_pro),'')
    ) AS telefono_fijo_pro,
    fecha_alta_pro,
    next_call_pro,
    id_pro,
    (SELECT category_".$lang_adm."_cap FROM properties_owner_captado WHERE id_cap = captado_por_pro) as captado_por_pro,
    id_pro as id_pro2
    FROM   $sTable
    $sWhere
    $sOrder

    $sLimit
  ";
  $rResult = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery . '<hr>');
  // -- CONCAT_WS(' | ', telefono_fijo_pro, telefono_movil_pro, telefono_movil3_prop, telefono_movil4_pro) AS telefono_fijo_pro,
  // -- ORDER BY IF(next_call_pro != '' AND id_pro IN (".$row_rsLlamadasPropIDSprops['total']."),0,1), next_call_pro ASC
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
        if($aColumns[$i] == 'fecha_alta_pro' || $aColumns[$i] == 'next_call_pro') {
            if ($aRow[ $aColumns[$i] ] != '' && $aRow[ $aColumns[$i] ] != '' ) {
                $row[] = date("d-m-Y", strtotime($aRow[ $aColumns[$i] ]));
            } else {
                $row[] = '';
            }
            if($aColumns[$i] == 'next_call_pro') {
                if (strtotime($aRow[ $aColumns[$i] ]) >= time() && $aRow[ $aColumns[$i] ] != '' && $aRow[ $aColumns[$i] ] != '' ) {
                    $row['DT_RowClass'] = '';
                } else {
                    $row['DT_RowClass'] = 'bg-soft-danger';
                }
            }
        } else {
            if (isset($totalRows_rsNumProps) && $aColumns[$i] == 'id_pro2') {
                $row[] = $totalRows_rsNumProps;
            } else {
              if(isset($aRow[ $aColumns[$i] ]))
                $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], 'UTF-8', 'ISO-8859-1');
              else
                $row[] ='';
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
