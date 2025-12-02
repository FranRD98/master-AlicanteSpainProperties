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

  if ($actUsuarios == 1) {
    $aColumns = array( 'nombre_cli', 'email_cli' );
  } else {
    $aColumns = array( 'nombre_cli', 'email_cli' );
  }

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_cli";

  /* DB table to use */
  $sTable = "properties_client";

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
        if($aColumns[$i] == 'fecha_alta_cli') {
          $sWhere .= "DATE_FORMAT(`fecha_alta_cli`, '%d-%m-%Y') LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'])."%' OR ";
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

      if($aColumns[$i] == 'fecha_alta_cli') {
        $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y') LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i])."%' ";
      } else {
        if ($aColumns[$i] == 'status_cli') {

            $sWhere .= "(SELECT category_".$lang_adm."_sts  FROM properties_client_states WHERE id_sts = status_cli) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";

        } else {
            $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i])."%' ";
        }

      }

    }
  }

  if($sWhere != '') {
      $sWhere .= ' AND 1 = 1';
  } else {
      $sWhere .= ' WHERE 1 = 1 ';
  }

  $pnt = '';
  if( isset($_GET['puntuacion_cli']) && $_GET['puntuacion_cli'] != '' && $_GET['puntuacion_cli'] != '0' ){
      $pnt = "AND puntuacion_cli = " . $_GET['puntuacion_cli'];
  }

  $nom = '';
  if( isset($_GET['nombre_cli']) && $_GET['nombre_cli'] != '' ){
      $nom = "AND nombre_cli LIKE '%" . $_GET['nombre_cli'] . "%'";
  }

  $apll = '';
  if( isset($_GET['apellidos_cli']) && $_GET['apellidos_cli'] != '' ){
      $apll = "AND apellidos_cli LIKE '%" . $_GET['apellidos_cli'] . "%'";
  }

  $tel1 = '';
  if( isset($_GET['telefono_fijo_cli']) && $_GET['telefono_fijo_cli'] != '' ){
      $tel1 = "AND telefono_fijo_cli LIKE '%" . $_GET['telefono_fijo_cli'] . "%'";
  }

  $tel2 = '';
  if( isset($_GET['telefono_movil_cli']) && $_GET['telefono_movil_cli'] != '' ){
      $tel2 = "AND telefono_movil_cli LIKE '%" . $_GET['telefono_movil_cli'] . "%'";
  }

  $nie = '';
  if( isset($_GET['nie_cli']) && $_GET['nie_cli'] != '' ){
      $nie = "AND nie_cli LIKE '%" . $_GET['nie_cli'] . "%'";
  }

  $pas = '';
  if( isset($_GET['pasaporte_cli']) && $_GET['pasaporte_cli'] != '' ){
      $pas = "AND pasaporte_cli LIKE '%" . $_GET['pasaporte_cli'] . "%'";
  }

  $nac = '';
  if( isset($_GET['nacionalidad_cli']) && $_GET['nacionalidad_cli'] != '' ){
      $nac = "AND nacionalidad_cli LIKE '%" . $_GET['nacionalidad_cli'] . "%'";
  }

  $sta = '';
  if( isset($_GET['status_cli']) && $_GET['status_cli'] != '' ){
      $pnt = "AND status_cli = " . $_GET['status_cli'];
  }

  $fech = '';
  if( isset($_GET['fecha_alta_cli']) && $_GET['fecha_alta_cli'] != '' ){
      $fech = "AND fecha_alta_cli >= '" . date("Y-m-d", strtotime($_GET['fecha_alta_cli'])) . "'";
  }

  $fech2 = '';
  if( isset($_GET['fecha_alta_cli_h']) && $_GET['fecha_alta_cli_h'] != '' ){
      $fech2 = "AND fecha_alta_cli <= '" . date("Y-m-d", strtotime($_GET['fecha_alta_cli_h'])) . "'";
  }

  $mail = '';
  if( isset($_GET['email_cli']) && $_GET['email_cli'] != '' ){
      $mail = "AND email_cli LIKE '%" . $_GET['email_cli'] . "%'";
  }

  $skyp = '';
  if( isset($_GET['skype_cli']) && $_GET['skype_cli'] != '' ){
      $skyp = "AND skype_cli LIKE '%" . $_GET['skype_cli'] . "%'";
  }

  $direc = '';
  if( isset($_GET['direccion_cli']) && $_GET['direccion_cli'] != '' ){
      $direc = "AND direccion_cli LIKE '%" . $_GET['direccion_cli'] . "%'";
  }

  $con = '';
  if( isset($_GET['como_nos_conocio_cli']) && $_GET['como_nos_conocio_cli'] != '' ){
      $con = "AND como_nos_conocio_cli LIKE '%" . $_GET['como_nos_conocio_cli'] . "%'";
  }

  $capt = '';
  if( isset($_GET['captado_por_cli']) && $_GET['captado_por_cli'] != '' ){
      $capt = "AND captado_por_cli LIKE '%" . $_GET['captado_por_cli'] . "%'";
  }

  $capt2 = '';
  if( isset($_GET['captado_por2_cli']) && $_GET['captado_por2_cli'] != '' ){
        $opciones = implode(',', $_GET['captado_por2_cli']);
        $capt2 = " AND ( 1=2 ";
        foreach ($_GET['captado_por2_cli'] as $value) {
          if ($value != '') {
            $capt2 .= " OR (FIND_IN_SET('$value', captado_por2_cli) > 0) ";
          }
        }
        $capt2 .= ")";
  }


  $hist = '';
  if( isset($_GET['historial_cli']) && $_GET['historial_cli'] != '' ){
      $hist = "AND historial_cli LIKE '%" . $_GET['historial_cli'] . "%'";
  }

  $nots = '';
  if( isset($_GET['notas_cli']) && $_GET['notas_cli'] != '' ){
      $nots = "AND notas_cli LIKE '%" . $_GET['notas_cli'] . "%'";
  }



  $op = '';
    $opjoin = '';
    if( isset($_GET['b_opciones_cli']) && $_GET['b_opciones_cli'] != '' ){
        $opciones = implode(',', $_GET['b_opciones_cli']);
        $op = " AND ( 1=2 ";
        foreach ($_GET['b_opciones_cli'] as $value) {
          if ($value != '') {
            $op .= " OR (FIND_IN_SET($value, b_opciones_cli) > 0) ";
          }
        }
        $op .= ")";
    }

    $op2 = '';
    $opjoin2 = '';
    if( !empty($_GET['b_opciones2_cli']) && $_GET['b_opciones2_cli'][0] != '' ){
        $opciones2 = implode(',', $_GET['b_opciones2_cli']);
        $op2 = " AND ( 1=2 ";
        foreach ($_GET['b_opciones2_cli'] as $value) {
          if ($value != '') {
            $op2 .= " OR (FIND_IN_SET($value, b_opciones2_cli) > 0) ";
          }
        }
        $op2 .= ")";
    }

    $st = '';
    if( isset($_GET['b_sale_cli']) && $_GET['b_sale_cli'] != '' ){
        $status = implode(',', $_GET['b_sale_cli']);
        $st = " AND ( 1=2 ";
        foreach ($_GET['b_sale_cli'] as $value) {
          if ($value != '') {
            $st .= " OR (FIND_IN_SET($value, b_sale_cli) > 0) ";
          }
        }
        $st .= ")";
    }

    $ty = '';
    if( isset($_GET['b_type_cli']) && $_GET['b_type_cli'] != '' ){
        $type = implode(',', $_GET['b_type_cli']);
        $ty = " AND ( 1=2 ";
        foreach ($_GET['b_type_cli'] as $value) {
          if ($value != '') {
            $ty .= " OR (FIND_IN_SET($value, b_type_cli) > 0) ";
          }
        }
        $ty .= ")";
    }



    $bd = '';
    if( isset($_GET['b_beds_cli']) && $_GET['b_beds_cli'] != '' ){
        $bd = "AND b_beds_cli >= " . $_GET['b_beds_cli'];
    }

    $bt = '';
    if( isset($_GET['b_baths_cli']) && $_GET['b_baths_cli'] != '' ){
        $bt = "AND b_baths_cli >= " . $_GET['b_baths_cli'];
    }

    $ref = '';
    if( isset($_GET['b_ref_cli']) && $_GET['b_ref_cli'] != '' ){
        $refs = array();
        $ref = " AND ( 1=2 ";
        foreach ($_GET['b_ref_cli'] as $value) {
          if ($value != '') {
            $loc4 .= " OR (FIND_IN_SET($value, b_ref_cli) > 0) ";
          }
        }
        $ref .= ")";

    }

    $prd = '';
    if( isset($_GET['b_precio_desde_cli']) && $_GET['b_precio_desde_cli'] != '' ){
        $prd = "AND b_precio_desde_cli >= " . $_GET['b_precio_desde_cli'];
    }

    $prh = '';
    if( isset($_GET['b_precio_hasta_cli']) && $_GET['b_precio_hasta_cli'] != '' ){
        $prh = "AND b_precio_hasta_cli <= " . $_GET['b_precio_hasta_cli'];
    }

    $loc4 = '';
    if( isset($_GET['b_loc4_cli']) && $_GET['b_loc4_cli'] != '' ){
        $location = implode(',', $_GET['b_loc4_cli']);
        $loc4 = " AND ( 1=2 ";
        foreach ($_GET['b_loc4_cli'] as $value) {
          if ($value != '') {
            $loc4 .= " OR (FIND_IN_SET('$value', b_loc4_cli) > 0) ";
          }
        }
        $loc4 .= ")";
    }

    $or = '';
  if( isset($_GET['or']) && $_GET['or'] != '' ){
      $or = "AND b_orientacion_cli = '" . $_GET['or'] . "'";
  }

    $or2 = '';
  if( isset($_GET['b_orientacion_cli']) && $_GET['b_orientacion_cli'] != '' ){
      $or2 = "AND b_orientacion_cli = '" . $_GET['b_orientacion_cli'] . "'";
  }

    $loc3 = '';
    if( isset($_GET['b_loc3_cli']) && $_GET['b_loc3_cli'] != '' ){
        $location = implode(',', $_GET['b_loc3_cli']);
        $loc3 = " AND ( 1=2 ";
        foreach ($_GET['b_loc3_cli'] as $value) {
          if ($value != '') {
            $loc3 .= " OR (FIND_IN_SET($value, b_loc3_cli) > 0) ";
          }
        }
        $loc3 .= ")";
    }

    $loc2 = '';
    if( isset($_GET['b_loc2_cli']) && $_GET['b_loc2_cli'] != '' ){
        $location = implode(',', $_GET['b_loc2_cli']);
        $loc2 = " AND ( 1=2 ";
        foreach ($_GET['b_loc2_cli'] as $value) {
          if ($value != '') {
            $loc2 .= " OR (FIND_IN_SET($value, b_loc2_cli) > 0) ";
          }
        }
        $loc2 .= ")";
    }

    $loc1 = '';
    if( isset($_GET['b_loc1_cli']) && $_GET['b_loc1_cli'] != '' ){
        $location = implode(',', $_GET['b_loc1_cli']);
        $loc1 = " AND ( 1=2 ";
        foreach ($_GET['b_loc1_cli'] as $value) {
          if ($value != '') {
            $loc1 .= " OR (FIND_IN_SET($value, b_loc1_cli) > 0) ";
          }
        }
        $loc1 .= ")";
    }

  $idioma_cli = '';
  if( isset($_GET['idioma_cli']) && $_GET['idioma_cli'] != '' ){
      $idioma_cli = "AND idioma_cli LIKE '%" . $_GET['idioma_cli'] . "%'";
  }



  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
    id_cli AS ID,
    CONCAT_WS(' ', nombre_cli, apellidos_cli) as Name,
    nie_cli AS NIE,
    pasaporte_cli AS Passport,
    nacionalidad_cli AS Nationality,
    idioma_cli AS Language,
    telefono_fijo_cli AS Phone_1,
    telefono_movil_cli AS Phone_2,
    direccion_cli AS Address,
    case residencia_fiscal_cli
        when '1' then 'Yes'
        when '0' then 'No'
    end  AS Tax_resident,
    (SELECT nombre_usr FROM users WHERE user_cli = id_usr) AS Commercial,
    (SELECT category_en_sts FROM properties_client_sources WHERE id_sts = como_nos_conocio_cli) AS Source,
    case atendido_cli
        when '1' then 'Yes'
        when '0' then 'No'
    end AS Attended,
    case newsletter_cli
        when '1' then 'Yes'
        when '0' then 'No'
    end AS Newsletter,
    case send_props_cli
        when '1' then 'Yes'
        when '0' then 'No'
    end AS Weekly_email,
    DATE_FORMAT(next_call_cli, '%d-%m-%Y') AS Next_call,
    email_cli AS Email,
    skype_cli AS Skype,
    (SELECT category_en_sts  FROM properties_client_states WHERE id_sts = status_cli) as Status,
    (SELECT category_en_cap  FROM properties_client_captado WHERE id_cap = captado_por2_cli) as Listed,
    DATE_FORMAT(fecha_alta_cli, '%d-%m-%Y') AS fecha_alta_cli
    FROM   $sTable
    $sWhere

    $pnt $nom $apll $tel1 $tel2 $nie $pas $nac $sta $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $capt2
      $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $op $or $or2 $op2 $idioma_cli

    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query($gaSql['link'], $sQuery) or die('MySQL Error: ' . mysqli_errno($gaSql['link']) . '<hr>' . $sQuery . '<hr>');
  $field_count = mysqli_num_fields($rResult);
  
  $return = array();
  $fila = array();
  
  // Crear una línea con los nombres de los campos
  $fields = mysqli_fetch_fields($rResult);
  foreach ($fields as $field) {
      array_push($fila, $field->name);
  }
  array_push($return, $fila);
  
  // Obtener los valores de cada fila
  while ($row = mysqli_fetch_assoc($rResult)) {
      $fila = array();
      foreach ($fields as $field) {
          array_push($fila, $row[$field->name]);
      }
      array_push($return, $fila);
  }
    
   
// header("Content-type: text/x-csv");
// header("Content-Disposition: attachment; filename=".$csv_filename."");
// echo($csv_export);


function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";") {
  header('Content-type: application/csv; charset=UTF-8', true);
  header('Content-Disposition: attachment; filename="'.$filename.'";');
  echo "\xEF\xBB\xBF";

  $f = fopen('php://output', 'w');

  if (empty($array)) {
      fclose($f);
      return;
  }

  // Write the data
  foreach ($array as $line) {
      if (is_array($line)) {
          fputcsv($f, $line, $delimiter);
      }
  }

  fclose($f);
}

array_to_csv_download($return, time() . ".csv");



    mysqli_free_result($rResult);
    mysqli_close($gaSql['link']);
 

?>
