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

  array_push($aColumns, 'name_con');
  array_push($aColumns, 'phone_con');
  array_push($aColumns, 'text_con');
  array_push($aColumns, 'lang_con');
  array_push($aColumns, 'date_con');
  array_push($aColumns, 'id_con');
  array_push($aColumns, 'lang_sort');
  array_push($aColumns, 'clientExists');
  array_push($aColumns, 'ownerExists');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_con";

  /* DB table to use */
  $sTable = "whatsapp_log";

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
          $sWhere .= " (SELECT category_en_ct FROM news_categories WHERE id_ct = categoria_nws) LIKE '%".mysqli_real_escape_string( $gaSql['link'], $_GET['sSearch'] )."%' OR ";
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
        if($aColumns[$i] == 'date_con') {
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
      $desde= "AND date_con >= '" . date("Y-m-d", strtotime($_GET['desde']))."'";
  }
$hasta= '';
  if( isset($_GET['hasta']) && $_GET['hasta'] != '' ){
      $hasta= "AND date_con <= '" . date("Y-m-d", strtotime($_GET['hasta']))."'";
  }

$mail = '';
  if( isset($_GET['mails']) && $_GET['mails'] != '' ){
      $mail = "AND email_log = '" . $_GET['mails'] . "'";
  }


  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      whatsapp_log.id_con,
      text_con,
      whatsapp_log.name_con,
      whatsapp_log.phone_con,
      whatsapp_log.lang_con,
      whatsapp_log.date_con,
      whatsapp_log.lang_con as lang_sort,
      (SELECT id_cli FROM properties_client WHERE telefono_fijo_cli = phone_con limit 1) AS clientExists,
      (SELECT id_pro FROM properties_owner WHERE telefono_fijo_pro = phone_con limit 1) AS ownerExists
    FROM whatsapp_log
    $sWhere $ref $tipo $desde $hasta $mail
    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query( $gaSql['link'],$sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  // echo  $sQuery . '<hr>';

  /* Data set length after filtering */
  $sQuery = "
    SELECT FOUND_ROWS()
  ";
  $rResultFilterTotal = mysqli_query( $gaSql['link'], $sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
  $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
  $iFilteredTotal = $aResultFilterTotal[0];

  /* Total data set length */
  $sQuery = "
    SELECT COUNT(".$sIndexColumn.")
    FROM whatsapp_log
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
      if ( $aColumns[$i] == "version" )
      {
        /* Special output formatting for 'version' column */
        $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
      }
      else if ( $aColumns[$i] != ' ' )
      {
        if($aColumns[$i] == 'date_con') {
            $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
        } else {
            if($aColumns[$i] == 'type_log') {
                switch ($aRow[ $aColumns[$i] ]) {
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
                }
            } else {
                if ($aColumns[$i] == 'text_con') {

                $row[] = '<div style="font-size: 12px;">'  . nl2br($aRow[ $aColumns[$i] ]) . '</div>';
                } else {
                      if ($aColumns[$i] == 'lang_con') {
                          $row[] = '<img src="/media/images/website/flags/' . $aRow[ $aColumns[$i] ] . '.png" style="height: 15px">';
                        }
                          else if($aColumns[$i] == 'id_baj'){
                              $query_rsClientConvert = "SELECT * FROM properties_client WHERE email_cli = '".$aRow['email_con']."'";
                              $rsClientConvert = mysqli_query($inmoconn,$query_rsClientConvert) or die(mysqli_error());
                              $row_rsClientConvert = mysqli_fetch_assoc($rsClientConvert);
                              $totalRows_rsClientConvert = mysqli_num_rows($rsClientConvert);

                              $clientExist = 0;
                              if ($totalRows_rsClientConvert > 0) $clientExist = 1;
                              if(isset($aRow[ $aColumns[$i] ]))
                                $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], 'UTF-8', 'ISO-8859-1'). ',' . $clientExist;
                              else
                                $row[] = $clientExist;

                          } else {
                            if(isset($aRow[ $aColumns[$i] ]))
                              $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], 'UTF-8', 'ISO-8859-1');
                            else
                              $row[] ='';
                          }
                }
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
