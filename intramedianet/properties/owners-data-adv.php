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
  $aColumns = array( 'nombre_pro', 'apellidos_pro', 'email_pro', 'telefono_fijo_pro', 'telefono_movil_pro', 'status_pro', 'fecha_alta_pro', 'id_pro' );


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
        if($aColumns[$i] == 'fecha_alta_pro') {
          $sWhere .= "DATE_FORMAT(`fecha_alta_pro`, '%d-%m-%Y') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
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

      if($aColumns[$i] == 'fecha_alta_pro') {
        $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y') LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i])."%' ";
      } else {
         if ($aColumns[$i] == 'status_pro') {

            $sWhere .= "(SELECT category_".$lang_adm."_sts  FROM properties_owner_states WHERE id_sts = status_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";

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

  $nom = '';
  if( isset($_GET['nombre_pro']) && $_GET['nombre_pro'] != '' ){
      $nom = "AND nombre_pro LIKE '%" . $_GET['nombre_pro'] . "%'";
  }

  $apll = '';
  if( isset($_GET['apellidos_pro']) && $_GET['apellidos_pro'] != '' ){
      $apll = "AND apellidos_pro LIKE '%" . $_GET['apellidos_pro'] . "%'";
  }

  $tel1 = '';
  if( isset($_GET['telefono_fijo_pro']) && $_GET['telefono_fijo_pro'] != '' ){
      $tel1 = "AND telefono_fijo_pro LIKE '%" . $_GET['telefono_fijo_pro'] . "%'";
  }

  $tel2 = '';
  if( isset($_GET['telefono_movil_pro']) && $_GET['telefono_movil_pro'] != '' ){
      $tel2 = "AND telefono_movil_pro LIKE '%" . $_GET['telefono_movil_pro'] . "%'";
  }

  $nie = '';
  if( isset($_GET['nie_pro']) && $_GET['nie_pro'] != '' ){
      $nie = "AND nie_pro LIKE '%" . $_GET['nie_pro'] . "%'";
  }

  $nie2 = '';
  if( isset($_GET['nie2_pro']) && $_GET['nie2_pro'] != '' ){
      $nie2 = "AND nie2_pro LIKE '%" . $_GET['nie2_pro'] . "%'";
  }

  $pas = '';
  if( isset($_GET['pasaporte_pro']) && $_GET['pasaporte_pro'] != '' ){
      $pas = "AND pasaporte_pro LIKE '%" . $_GET['pasaporte_pro'] . "%'";
  }

  $pas2 = '';
  if( isset($_GET['pasaporte2_pro']) && $_GET['pasaporte2_pro'] != '' ){
      $pas2 = "AND pasaporte2_pro LIKE '%" . $_GET['pasaporte2_pro'] . "%'";
  }

  $nac = '';
  if( isset($_GET['nacionalidad_pro']) && $_GET['nacionalidad_pro'] != '' ){
      $nac = "AND nacionalidad_pro LIKE '%" . $_GET['nacionalidad_pro'] . "%'";
  }

  $idm = '';
  if( isset($_GET['idioma_pro']) && $_GET['idioma_pro'] != '' ){
      $idm = "AND idioma_pro LIKE '%" . $_GET['idioma_pro'] . "%'";
  }

  // echo "<pre>";
  // print_r($_GET);
  // echo "</pre>";

  $fech = '';
  if( isset($_GET['fecha_alta_pro']) && $_GET['fecha_alta_pro'] != '' ){
      $fech = "AND fecha_alta_pro >= '" . date("Y-m-d", strtotime($_GET['fecha_alta_pro'])) . "'";
  }

  $fech2 = '';
  if( isset($_GET['fecha_alta_pro_h']) && $_GET['fecha_alta_pro_h'] != '' ){
      $fech2 = "AND fecha_alta_pro <= '" . date("Y-m-d", strtotime($_GET['fecha_alta_pro_h'])) . "'";
  }

  $mail = '';
  if( isset($_GET['email_pro']) && $_GET['email_pro'] != '' ){
      $mail = "AND email_pro LIKE '%" . $_GET['email_pro'] . "%'";
  }

  $skyp = '';
  if( isset($_GET['skype_pro']) && $_GET['skype_pro'] != '' ){
      $skyp = "AND skype_pro LIKE '%" . $_GET['skype_pro'] . "%'";
  }

  $direc = '';
  if( isset($_GET['direccion_pro']) && $_GET['direccion_pro'] != '' ){
      $direc = "AND direccion_pro LIKE '%" . $_GET['direccion_pro'] . "%'";
  }

  $con = '';
  if( isset($_GET['como_nos_conocio_pro']) && $_GET['como_nos_conocio_pro'] != '' ){
      $con = "AND como_nos_conocio_pro LIKE '%" . $_GET['como_nos_conocio_pro'] . "%'";
  }

  $capt = '';
  if( isset($_GET['captado_por_pro']) && $_GET['captado_por_pro'] != '' ){
      $capt = "AND captado_por_pro LIKE '%" . $_GET['captado_por_pro'] . "%'";
  }

  $hist = '';
  if( isset($_GET['historial_pro']) && $_GET['historial_pro'] != '' ){
      $hist = "AND historial_pro LIKE '%" . $_GET['historial_pro'] . "%'";
  }

  $nots = '';
  if( isset($_GET['notas_pro']) && $_GET['notas_pro'] != '' ){
      $nots = "AND notas_pro LIKE '%" . $_GET['notas_pro'] . "%'";
  }



  $sta = '';
  if( isset($_GET['status_pro']) && $_GET['status_pro'] != '' ){
      $sta = "AND status_pro = " . $_GET['status_pro'];
  }


  $resfis = '';
  if( isset($_GET['residencia_fiscal_pro']) && $_GET['residencia_fiscal_pro'] != '' ){
      $resfis = "AND residencia_fiscal_pro = " . $_GET['residencia_fiscal_pro'];
  }


  $enerpro = '';
  if( isset($_GET['energia_pro']) && $_GET['energia_pro'] != '' ){
      $enerpro = "AND energia_pro = " . $_GET['energia_pro'];
  }

  $tipovend = '';
  if( isset($_GET['type_pro']) && $_GET['type_pro'] != '' ){
      $tipovend = "AND type_pro = " . $_GET['type_pro'];
  }


  $conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
  $isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
  $isLoggedIn1->addLevel("7");
  if ($isLoggedIn1->Execute()) {

      if($sWhere != '') {
          $sWhere .= ' AND user_pro = \''.$_SESSION['kt_login_id'].'\' ';
      } else {
          $sWhere .= ' WHERE user_pro = \''.$_SESSION['kt_login_id'].'\' ';
      }

      $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);

  }




  /*
   * SQL queries
   * Get data to display
   */
  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS nombre_pro,
    apellidos_pro,
    email_pro,
    telefono_fijo_pro,
    telefono_movil_pro,
    (SELECT category_".$lang_adm."_sts  FROM properties_owner_states WHERE id_sts = status_pro) as status_pro,
    fecha_alta_pro,
    id_pro
    FROM   $sTable
    $sWhere

    $nom $apll $tel1 $tel2 $nie $nie2 $pas $pas2 $nac $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $sta $resfis $enerpro $tipovend $idm

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
        if($aColumns[$i] == 'fecha_alta_pro') {
            $row[] = date("d-m-Y", strtotime($aRow[ $aColumns[$i] ]));
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
                $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], 'UTF-8', 'ISO-8859-1');
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