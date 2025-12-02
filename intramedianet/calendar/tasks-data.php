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


// error_reporting(E_ALL);
// ini_set("display_errors", 1);

  //sleep(2);

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * Easy set variables
   */

  /* Array of database columns which should be read and sent back to DataTables. Use a space where
   * you want to insert a non-database field (for example a counter or static image)
   */


  $aColumns = array();

  array_push($aColumns, 'titulo_ct');
  array_push($aColumns, 'categoria_ct');
  array_push($aColumns, 'inicio_ct');
  array_push($aColumns, 'final_ct');
  array_push($aColumns, 'property_ct');
  array_push($aColumns, 'users_ct');
  array_push($aColumns, 'lugar_ct');


  array_push($aColumns, 'id_ct');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_ct";

  /* DB table to use */
  $sTable = "citas";

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

      switch ($aColumns[$i]) {
        case 'categoria_ct':
          $sWhere .= "citas_categories.category_" .$lang_adm. "_ct LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          break;

        case 'inicio_ct':
          $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          break;

        case 'final_ct':
          $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          break;

        case 'property_ct':
          $sWhere .= "properties_properties.referencia_prop LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          break;

        case 'users_ct':
          $sWhere .= "CONCAT(properties_client.nombre_cli, ' ', properties_client.apellidos_cli) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          break;

        default:
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          break;
      }

    }
  }


  // if($sWhere != '') {
  //     $sWhere .= " AND citas.user_ct = '".$_SESSION['kt_login_id']."'";
  // } else {
  //     $sWhere .= " WHERE citas.user_ct = '".$_SESSION['kt_login_id']."'";
  // }


  if($sWhere != '') {
      $sWhere .= " AND inicio_ct >= NOW()";
  } else {
      $sWhere .= " WHERE inicio_ct >= NOW()";
  }

  $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);

  /*
   * SQL queries
   * Get data to display
   */


  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
 citas.titulo_ct,
  citas_categories.category_" .$lang_adm. "_ct AS categoria_ct,
  citas.inicio_ct,
  citas.final_ct,
  GROUP_CONCAT(properties_properties.referencia_prop) AS property_ct,
  CONCAT(properties_client.nombre_cli, ' ', properties_client.apellidos_cli) AS users_ct,
  citas.lugar_ct,
  citas.id_ct
FROM citas
    LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
   LEFT OUTER JOIN properties_properties ON  FIND_IN_SET (properties_properties.id_prop, citas.property_ct)
   LEFT OUTER JOIN properties_client ON citas.users_ct = properties_client.id_cli
    $sWhere
    GROUP BY titulo_ct
    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

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
    FROM   $sTable WHERE citas.user_ct = '".$_SESSION['kt_login_id']."'
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
      if ( $aColumns[$i] == "inicio_ct" || $aColumns[$i] == "final_ct" )
      {
        /* Special output formatting for 'version' column */
        $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
      }
      else
      {
        /* General output */
        if($aRow[ $aColumns[$i] ]!==null)
          $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], 'UTF-8', 'ISO-8859-1');
        else
          $row[] = '';
      }
    }
    $output['aaData'][] = $row;
  }

  // echo "<pre>";
  // print_r($output);
  // echo "</pre>";

  if(isset($_GET['callback']))
    echo $_GET['callback'].''.(json_encode( $output )).'';
  else
    echo (json_encode( $output )).'';
  
?>
