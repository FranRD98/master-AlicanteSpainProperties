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

  array_push($aColumns, 'admin_tsk');
  array_push($aColumns, 'subject_tsk');
  array_push($aColumns, 'date_due_tsk');
  array_push($aColumns, 'priority_tsk');
  array_push($aColumns, 'status_tsk');
  array_push($aColumns, 'contact_type_tsk');

  array_push($aColumns, 'id_tsk');
  array_push($aColumns, 'status_tsk2');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_tsk";

  /* DB table to use */
  $sTable = "tasks";

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
        if ($aColumns[$i] == 'categoria_tsk') {
          $sWhere .= " (SELECT category_" .$lang_adm. "_ct FROM tasks_categories WHERE id_ct = categoria_tsk) LIKE '%".mysqli_real_escape_string( $gaSql['link'],$_GET['sSearch'] )."%' OR ";
        } else {
          if($aColumns[$i] == 'date_due_tsk') {
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

      if ($aColumns[$i] == 'admin_tsk') {

        $sWhere .= " (SELECT nombre_usr FROM users WHERE id_usr  = admin_tsk) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
      } else {
        if($aColumns[$i] == 'date_due_tsk') {
          $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
        } else {

              if($aColumns[$i] == 'contact_type_tsk') {
                $sWhere .= "(SELECT nombre_comercial_col FROM properties_collaborators WHERE id_col = contact_tsk) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                $sWhere .= " OR (SELECT CONCAT_WS(' ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = contact_tsk) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
                $sWhere .= "OR (SELECT CONCAT_WS(' ', nombre_pro, apellidos_pro) FROM properties_owner WHERE id_pro = contact_tsk) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
              } else {
                $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
              }

        }
      }


    }
  }

if ($_SESSION['kt_login_level'] < 9) {
  if($sWhere != '') {
      $sWhere .= ' AND admin_tsk = ' . $_SESSION['kt_login_id'];
  } else {
      $sWhere .= ' WHERE admin_tsk = ' . $_SESSION['kt_login_id'];
  }
  $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);
}


  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      (SELECT nombre_usr FROM users WHERE id_usr  = admin_tsk) as admin_tsk,
      subject_tsk,
      date_due_tsk,
      priority_tsk,
      (SELECT categorias_".$lang_adm."_cat as cat FROM tasks_categories WHERE id_cat = status_tsk) as status_tsk,
      status_tsk as status_tsk2,
      case contact_type_tsk
          when '1' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-male\"></i> ', nombre_comercial_col) FROM properties_collaborators WHERE id_col = contact_tsk)
          when '2' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-users\"></i> ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = contact_tsk)
          when '3' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-key\"></i> ', nombre_pro, apellidos_pro) FROM properties_owner WHERE id_pro = contact_tsk)
          when '' then ''
      end as contact_type_tsk,
      id_tsk
    FROM tasks
    $sWhere
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
      if ( $aColumns[$i] == "version" )
      {
        /* Special output formatting for 'version' column */
        $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
      }
      else if ( $aColumns[$i] != ' ' )
      {
        if($aColumns[$i] == 'date_due_tsk') {
            if ($aRow[ $aColumns[$i] ] != '') {
                $row[] = date("d-m-Y", strtotime($aRow[ $aColumns[$i] ]));
            } else {
                $row[] = '';
            }
            if($aColumns[$i] == 'date_due_tsk') {
                if (strtotime($aRow[ $aColumns[$i] ]) < time() && $aRow[ $aColumns[$i] ] != '' && $aRow['status_tsk2'] != 2) {
                    $row['DT_RowClass'] = 'bg-soft-danger';
                } else {
                    $row['DT_RowClass'] = '';
                }
            }
        } else {
            if($aColumns[$i] == 'priority_tsk') {
                $row[] = __($aRow[ $aColumns[$i] ], true);
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
