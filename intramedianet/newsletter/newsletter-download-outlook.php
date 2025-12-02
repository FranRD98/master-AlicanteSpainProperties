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

  array_push($aColumns, 'nombre_usr');
  array_push($aColumns, 'email_usr');

  array_push($aColumns, 'id_usr');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_usr";

  /* DB table to use */
  $sTable = "newsletter_users";

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
        if ($aColumns[$i] == 'cats') {
         $sWhere .= " (SELECT GROUP_CONCAT(' ', newsletter_categories.category_" .$lang_adm. "_cts) FROM newsletter_usr_cat INNER JOIN newsletter_categories ON newsletter_usr_cat.cat = newsletter_categories.id_cts WHERE newsletter_usr_cat.usr = id_usr ) LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'])."%' OR ";
        } else {
          if($aColumns[$i] == 'date_usr') {
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

      if ($aColumns[$i] == 'cats') {

        $sWhere .= " (SELECT GROUP_CONCAT(' ', newsletter_categories.category_" .$lang_adm. "_cts) FROM newsletter_usr_cat INNER JOIN newsletter_categories ON newsletter_usr_cat.cat = newsletter_categories.id_cts WHERE newsletter_usr_cat.usr = id_usr ) LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'])."%'  ";
      } else {
        if($aColumns[$i] == 'date_usr') {
          $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i])."%' ";
        } else {
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i])."%' ";
        }
      }


    }
  }


  $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);


  /*
   * SQL queries
   * Get data to display
   */
  $campos = '';
  foreach ($languages as $value) {
    $campos .= 'title_' . $value . '_nws, ';
  }



  $sQuery = "
      SELECT SQL_CALC_FOUND_ROWS
      `nombre_usr`,
      `email_usr`
      FROM   $sTable
      $sWhere
      $sOrder
      $sLimit
  ";
  $rResult = mysqli_query( $gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  // echo  $sQuery . '<hr>';

function array_to_txt_download($array, $filename = "export.csv", $delimiter=";") {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachement; filename="'.$filename.'";');

    $return = '';

    foreach ($array as $line) {
        $return .= $line['email_usr'] . ", ";
    }

    print $return;

}

  $return = array();

  while ($row = mysqli_fetch_assoc($rResult)) {
    array_push($return, $row);
  }

  array_to_txt_download($return, time() . ".txt");
?>
