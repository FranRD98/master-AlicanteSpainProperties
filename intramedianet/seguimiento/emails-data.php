<?php


ini_set('display_errors', 1);
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

  array_push($aColumns, 'prop_id_log');
  array_push($aColumns, 'email_log');
  array_push($aColumns, 'type_log');
  array_push($aColumns, 'result_log');
  array_push($aColumns, 'date_log');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_log";

  /* DB table to use */
  $sTable = "properties_log_mails";

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
        if ($aColumns[$i] == 'categoria_nws') {
          $sWhere .= " (SELECT category_en_ct FROM news_categories WHERE id_ct = categoria_nws) LIKE '%".mysqli_real_escape_string( $gaSql['link'],$_GET['sSearch'] )."%' OR ";
        } else {
          if($aColumns[$i] == 'date_nws') {
            $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
          }
          else {
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

      if ($aColumns[$i] == 'type_log') {

          if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Ficha clientes', true)))) {
              $sWhere .= $aColumns[$i]." = '1'";
          }

          if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Búsqueda de inmuebles', true)))) {
              $sWhere .= $aColumns[$i]." = '2'";
          }

          if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Bajada de precio', true)))) {
              $sWhere .= $aColumns[$i]." = '3'";
          }

          if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Clientes interesados', true)))) {
              $sWhere .= $aColumns[$i]." = '4'";
          }

          if (preg_match('/'.strtolower($_GET['sSearch']).'/', strtolower(__('Lista de correo', true)))) {
              $sWhere .= $aColumns[$i]." = '5'";
          }

      } else {
        if($aColumns[$i] == 'date_log') {
          $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
        } else {
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
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

$tipo = '';
  if( isset($_GET['tipo']) && $_GET['tipo'] != '' ){
      $tipo = "AND type_log = " . $_GET['tipo'];
  }


$desde= '';
  if( isset($_GET['desde']) && $_GET['desde'] != '' ){
      $desde= "AND date_log >= '" . date("Y-m-d", strtotime($_GET['desde']))."'";
  }
$hasta= '';
  if( isset($_GET['hasta']) && $_GET['hasta'] != '' ){
      $hasta= "AND date_log <= '" . date("Y-m-d", strtotime($_GET['hasta']))."'";
  }

$mail = '';
  if( isset($_GET['mails']) && $_GET['mails'] != '' ){
      $mail = "AND email_log = '" . $_GET['mails'] . "'";
  }


  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_log_mails.id_log,
      properties_properties.referencia_prop as prop_id_log,
      properties_log_mails.email_log,
      properties_log_mails.type_log,
      properties_log_mails.result_log,
      properties_log_mails.date_log
    FROM properties_log_mails
      INNER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
    $sWhere $ref $tipo $desde $hasta $mail
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
    FROM properties_log_mails
      INNER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
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

while ($aRow = mysqli_fetch_array($rResult)) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        if ($aColumns[$i] == "version") {
            /* Special output formatting for 'version' column */
            $row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
        } else if ($aColumns[$i] != ' ') {
            if ($aColumns[$i] == 'date_log') {
                $row[] = date("d-m-Y H:i", strtotime($aRow[$aColumns[$i]]));
            } else if ($aColumns[$i] == 'type_log') {
                switch ($aRow[$aColumns[$i]]) {
                    case '1':
                        $row[] = $lang['Ficha clientes'];
                        break;
                    case '2':
                        $row[] = $lang['Búsqueda de inmuebles'];
                        break;
                    case '3':
                        $row[] = $lang['Bajada de precio'];
                        break;
                    case '4':
                        $row[] = $lang['Clientes interesados'];
                        break;
                    case '5':
                        $row[] = $lang['Lista de correo'];
                        break;
                    case '6':
                        $row[] = $lang['Listado de propiedades'];
                        break;
                    default:
                        $row[] = '';
                        break;
                }
            } else if ($aColumns[$i] == 'result_log') {
                switch ($aRow[$aColumns[$i]]) {
                    case 'delivered':
                      $row[] = '<span class="badge text-bg-secondary text-uppercase">' . $lang['delivered'] . '</span>';
                      break;
                    case 'opens':
                      $row[] = '<span class="badge text-bg-success text-uppercase">' . $lang['opens'] . '</span>';
                      break;
                    case 'clicks':
                      $row[] = '<span class="badge text-bg-secondary text-uppercase">' . $lang['clicks'] . '</span>';
                      break;
                    case 'hard_bounces':
                      $row[] = '<span class="badge text-bg-danger text-uppercase">' . $lang['hard_bounces'] . '</span>';
                      break;
                    case 'soft_bounces':
                      $row[] = '<span class="badge text-bg-warning text-uppercase">' . $lang['soft_bounces'] . '</span>';
                      break;
                    case 'complaints':
                      $row[] = '<span class="badge text-bg-danger text-uppercase">' . $lang['complaints'] . '</span>';
                      break;
                    default:
                      $row[] = '-';
                      break;
                }
            } else if ($aColumns[$i] == 'prop_id_log') {
                $query_rsMenu = "SELECT id_prop FROM properties_properties WHERE referencia_prop = '" . $aRow[$aColumns[$i]] . "' LIMIT 1";
                $rsMenu = mysqli_query($inmoconn, $query_rsMenu) or die(mysqli_error($inmoconn));
                $row_rsMenu = mysqli_fetch_assoc($rsMenu);
                $row[] = '<a href="/intramedianet/properties/properties-form.php?id_prop=' . $row_rsMenu['id_prop'] . '" target="_blank" class="btn btn-default btn-xs">' . $aRow[$aColumns[$i]] . '</a>';
            } else {
                if ($aRow[$aColumns[$i]] !== null)
                    $row[] = mb_convert_encoding($aRow[$aColumns[$i]], 'UTF-8', 'ISO-8859-1');
                else
                    $row[] = '';
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
