<?php
// Cargamos la conexión a MySql
include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// Cargamos los idiomas de la administración
include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');

// Load the tNG classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

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

  array_push($aColumns, 'image_img');
  array_push($aColumns, 'referencia_prop');
  array_push($aColumns, 'activado_prop');
  if ($expKyero == 1) {
      array_push($aColumns, 'export_kyero_prop');
  }
  if ($expIdealista == 1) {
      array_push($aColumns, 'idealista_prop');
  }
  if ($expRightmove == 1) {
      array_push($aColumns, 'export_rightmove_prop');
  }
  if ($expZoopla == 1) {
      array_push($aColumns, 'export_zoopla_prop');
  }
  if ($expThinkSpain == 1) {
      array_push($aColumns, 'export_thinkspain_prop');
  }
  if ($expHemnet == 1) {
      array_push($aColumns, 'export_hemnet_prop');
  }
  if ($expUbiflow == 1) {
      array_push($aColumns, 'export_ubiflow_prop');
  }
  if ($expGreenAcres == 1) {
      array_push($aColumns, 'export_green_prop');
  }
  if ($expPrian == 1) {
      array_push($aColumns, 'export_prian_prop');
  }
  if ($expHabitaclia == 1) {
      array_push($aColumns, 'export_habitaclia_prop');
  }
  if ($expPisos == 1) {
      array_push($aColumns, 'export_pisos_prop');
  }
  if ($expFacilisimo == 1) {
      array_push($aColumns, 'export_facilisimo_prop');
  }
  if ($expFotoCasa == 1) {
      array_push($aColumns, 'export_fotocasa_prop');
  }
  if ($expTodoPisoAlicante == 1) {
      array_push($aColumns, 'export_todopisoalicante_prop');
  }
  if ($expYaencontre == 1) {
      array_push($aColumns, 'export_yaencontre_prop');
  }
  if ($expAPITS == 1) {
      array_push($aColumns, 'expport_APITS_prop');
  }
  if ($expCostadelHome == 1) {
      array_push($aColumns, 'expport_CostadelHome_prop');
  }
  if ($expSpainHouses == 1) {
      array_push($aColumns, 'expport_SpainHomes_prop');
  }
  if ($expMimove == 1) {
      array_push($aColumns, 'export_mimove_prop');
  }
  if ($expInmoco == 1) {
    array_push($aColumns, 'export_inmoco_prop');
  }
  if ($expMediaelx == 1) {
    array_push($aColumns, 'export_mediaelx_prop');
  }
  if ($expFacebook == 1) {
    array_push($aColumns, 'export_facebook_prop');
  }
  if ($expMLSMediaelx == 1) {
    array_push($aColumns, 'export_mlsmediaelx_prop');
  }
  array_push($aColumns, 'id_prop');

  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id_prop";

  /* DB table to use */
  $sTable = "properties_properties";

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
  function fatal_error($sErrorMessage = '')
  {
      header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error');
      die($sErrorMessage);
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
  if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
      $sLimit = "LIMIT ".intval($_GET['iDisplayStart']).", ".
      intval($_GET['iDisplayLength']);
  }


  /*
   * Ordering
   */
  $sOrder = "";
  if (isset($_GET['iSortCol_0'])) {
      $sOrder = "ORDER BY  ";
      for ($i=0 ; $i<intval($_GET['iSortingCols']) ; $i++) {
          if ($_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true") {
              $sOrder .= "`".$aColumns[ intval($_GET['iSortCol_'.$i]) ]."` ".
          ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
          }
      }

      $sOrder = substr_replace($sOrder, "", -2);
      if ($sOrder == "ORDER BY") {
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
  if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
      $sWhere = "WHERE (";
      for ($i=0 ; $i<count($aColumns) ; $i++) {
          if (isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true") {
              if ($aColumns[$i] == 'categoria_nws') {
                  $sWhere .= " (SELECT category_en_ct FROM news_categories WHERE id_ct = categoria_nws) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
              } else {
                  if ($aColumns[$i] == 'date_nws') {
                      $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
                  } else {
                      $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
                  }
              }
          }
      }
      $sWhere = substr_replace($sWhere, "", -3);
      $sWhere .= ')';
  }

  /* Individual column filtering */
  for ($i=0 ; $i<count($aColumns) ; $i++) {
      if (isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '') {
          if ($sWhere == "") {
              $sWhere = "WHERE ";
          } else {
              $sWhere .= " AND ";
          }

          if ($aColumns[$i] == 'categoria_nws') {
              $sWhere .= " (SELECT category_en_ct FROM news_categories WHERE id_ct = categoria_nws) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          } else {
              if ($aColumns[$i] == 'date_nws') {
                  $sWhere .= "DATE_FORMAT(`" . $aColumns[$i] . "`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
              } else {
                  $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
              }
          }
      }
  }


  if ($sWhere != '') {
      $sWhere .= '  ';
  } else {
      $sWhere .= ' WHERE 1=1 ';
  }


$ref = '';
  if (isset($_GET['ref']) && $_GET['ref'] != '') {
      $ref = "AND id_prop = " . $_GET['ref'];
  }


$desde= '';
  if (isset($_GET['desde']) && $_GET['desde'] != '') {
      $desde= "AND date_log >= '" . date("Y-m-d", strtotime($_GET['desde']))."'";
  }
$hasta= '';
  if (isset($_GET['hasta']) && $_GET['hasta'] != '') {
      $hasta= "AND date_log <= '" . date("Y-m-d", strtotime($_GET['hasta']))."'";
  }

$kyero = '';
if (isset($_GET['kyero']) && $_GET['kyero'] != '') {
    $kyero = "AND export_kyero_prop = " . $_GET['kyero'];
}

$idealista = '';
if (isset($_GET['idealista']) && $_GET['idealista'] != '') {
    $idealista = "AND idealista_prop = " . $_GET['idealista'];
}

$rightmove = '';
if (isset($_GET['rightmove']) && $_GET['rightmove'] != '') {
    $rightmove = "AND export_rightmove_prop = " . $_GET['rightmove'];
}

$zoopla = '';
if (isset($_GET['zoopla']) && $_GET['zoopla'] != '') {
    $zoopla = "AND export_zoopla_prop = " . $_GET['zoopla'];
}

$thinkspain = '';
if (isset($_GET['thinkspain']) && $_GET['thinkspain'] != '') {
    $thinkspain = "AND export_thinkspain_prop = " . $_GET['thinkspain'];
}

$hemnet = '';
if (isset($_GET['hemnet']) && $_GET['hemnet'] != '') {
    $hemnet = "AND export_hemnet_prop = " . $_GET['hemnet'];
}

$ubiflow = '';
if (isset($_GET['ubiflow']) && $_GET['ubiflow'] != '') {
    $ubiflow = "AND export_ubiflow_prop = " . $_GET['ubiflow'];
}

$green = '';
if (isset($_GET['green']) && $_GET['green'] != '') {
    $green = "AND export_green_prop = " . $_GET['green'];
}

$prian = '';
if (isset($_GET['prian']) && $_GET['prian'] != '') {
    $prian = "AND export_prian_prop = " . $_GET['prian'];
}

$habitaclia = '';
if (isset($_GET['habitaclia']) && $_GET['habitaclia'] != '') {
    $habitaclia = "AND export_habitaclia_prop = " . $_GET['habitaclia'];
}

$pisos = '';
if (isset($_GET['pisos']) && $_GET['pisos'] != '') {
    $pisos = "AND export_pisos_prop = " . $_GET['pisos'];
}

$facilisimo = '';
if (isset($_GET['facilisimo']) && $_GET['facilisimo'] != '') {
    $facilisimo = "AND export_facilisimo_prop = " . $_GET['facilisimo'];
}
$fotocasa = '';
if (isset($_GET['fotocasa']) && $_GET['fotocasa'] != '') {
    $fotocasa = "AND export_fotocasa_prop = " . $_GET['fotocasa'];
}
$todopiso = '';
if (isset($_GET['todopiso']) && $_GET['todopiso'] != '') {
    $todopiso = "AND export_todopisoalicante_prop = " . $_GET['todopiso'];
}
$yaencontre = '';
if (isset($_GET['yaencontre']) && $_GET['yaencontre'] != '') {
    $yaencontre = "AND export_yaencontre_prop = " . $_GET['yaencontre'];
}
$apits = '';
if (isset($_GET['expport_APITS_prop']) && $_GET['expport_APITS_prop'] != '') {
    $apits = "AND expport_APITS_prop = " . $_GET['expport_APITS_prop'];
}
$costadelhome = '';
if (isset($_GET['expport_CostadelHome_prop']) && $_GET['expport_CostadelHome_prop'] != '') {
    $costadelhome = "AND expport_CostadelHome_prop = " . $_GET['expport_CostadelHome_prop'];
}
$spainhomes = '';
if (isset($_GET['expport_SpainHomes_prop']) && $_GET['expport_SpainHomes_prop'] != '') {
    $spainhomes = "AND expport_SpainHomes_prop = " . $_GET['expport_SpainHomes_prop'];
}
$mimove = '';
if (isset($_GET['export_mimove_prop']) && $_GET['export_mimove_prop'] != '') {
    $mimove = "AND export_mimove_prop = " . $_GET['export_mimove_prop'];
}
$export_inmoco_prop = '';
if( isset($_GET['export_inmoco_prop']) && $_GET['export_inmoco_prop'] != '' ){
    $export_inmoco_prop = "AND export_inmoco_prop = " . $_GET['export_inmoco_prop'];
}
$export_mediaelx_prop = '';
if( isset($_GET['export_mediaelx_prop']) && $_GET['export_mediaelx_prop'] != '' ){
    $export_mediaelx_prop = "AND export_mediaelx_prop = " . $_GET['export_mediaelx_prop'];
}
$export_facebook_prop = '';
if( isset($_GET['export_facebook_prop']) && $_GET['export_facebook_prop'] != '' ){
    $export_facebook_prop = "AND export_facebook_prop = " . $_GET['export_facebook_prop'];
}
$export_mlsmediaelx_prop = '';
if( isset($_GET['export_mlsmediaelx_prop']) && $_GET['export_mlsmediaelx_prop'] != '' ){
    $export_mlsmediaelx_prop = "AND export_mlsmediaelx_prop = " . $_GET['export_mlsmediaelx_prop'];
}

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.id_prop,
      case properties_properties.activado_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as activado_prop,
      case properties_properties.export_kyero_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_kyero_prop,
      case properties_properties.export_mediaelx_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_mediaelx_prop,
      case properties_properties.export_facebook_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_facebook_prop,
      case properties_properties.export_mlsmediaelx_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_mlsmediaelx_prop,
      case properties_properties.idealista_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as idealista_prop,
      case properties_properties.export_rightmove_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_rightmove_prop,
      case properties_properties.export_zoopla_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_zoopla_prop,
      case properties_properties.export_thinkspain_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_thinkspain_prop,
      case properties_properties.export_hemnet_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_hemnet_prop,
      case properties_properties.export_ubiflow_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_ubiflow_prop,
      case properties_properties.export_green_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_green_prop,
      case properties_properties.export_prian_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_prian_prop,
      case properties_properties.export_habitaclia_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_habitaclia_prop,
      case properties_properties.export_pisos_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_pisos_prop,
      case properties_properties.export_facilisimo_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_facilisimo_prop,
      case properties_properties.export_fotocasa_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_fotocasa_prop,
      case properties_properties.export_todopisoalicante_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_todopisoalicante_prop,
      case properties_properties.export_yaencontre_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_yaencontre_prop,
      case properties_properties.expport_APITS_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as expport_APITS_prop,
      case properties_properties.expport_CostadelHome_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as expport_CostadelHome_prop,
      case properties_properties.expport_SpainHomes_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as expport_SpainHomes_prop,
      case properties_properties.export_mimove_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_mimove_prop,
      case properties_properties.export_inmoco_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as export_inmoco_prop,
      properties_properties.referencia_prop,
      properties_properties.id_prop as image_img
    FROM properties_properties
    $sWhere $ref $kyero $idealista $rightmove $zoopla $thinkspain $hemnet $ubiflow $green $prian $habitaclia $pisos $facilisimo $fotocasa $todopiso $yaencontre $apits $costadelhome $spainhomes $mimove $export_inmoco_prop $export_mediaelx_prop $export_facebook_prop $export_mlsmediaelx_prop
    GROUP BY id_prop
    $sOrder
    $sLimit
  ";
  $rResult = mysqli_query($gaSql['link'],$sQuery) or fatal_error('MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  // echo  $sQuery . '<hr>';

  /* Data set length after filtering */
  $sQuery = "
    SELECT FOUND_ROWS()
  ";
  $rResultFilterTotal = mysqli_query($gaSql['link'],$sQuery) or fatal_error('MySQL Error: ' . mysqli_errno());
  $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
  $iFilteredTotal = $aResultFilterTotal[0];

  /* Total data set length */
  $sQuery = "
    SELECT COUNT(".$sIndexColumn.")
    FROM   $sTable
  ";
  $rResultTotal = mysqli_query($gaSql['link'],$sQuery) or fatal_error('MySQL Error: ' . mysqli_errno());
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
      for ($i=0 ; $i<count($aColumns) ; $i++) {
          if ($aColumns[$i] == "version") {
              /* Special output formatting for 'version' column */
              $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
          } elseif ($aColumns[$i] != ' ') {
              if ($aColumns[$i] == 'inserted_xml_prop') {
                  $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
              } else {
                  if ($aColumns[$i] == 'updated_prop') {
                      $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
                  } else {
                      if ($aColumns[$i] == 'referencia_prop') {
                          $query_rsMenu = "SELECT id_prop FROM properties_properties WHERE referencia_prop = '".$aRow[ $aColumns[$i] ]."' LIMIT 1";
                          $rsMenu = mysqli_query($inmoconn,$query_rsMenu) or die(mysqli_error());
                          $row_rsMenu = mysqli_fetch_assoc($rsMenu);

                          $row[] = '<a href="/intramedianet/properties/properties-form.php?id_prop='.$row_rsMenu['id_prop'].'" target="_blank" class="btn btn-default btn-xs">'. $aRow[ $aColumns[$i] ] . '</a>';
                      } else {
                          if ($aColumns[$i] == 'image_img') {
                            $sQuery = "SELECT id_img FROM properties_images WHERE property_img = ".$aRow[ $aColumns[$i] ]." ORDER BY order_img LIMIT 1";
                            $rImage = mysqli_query($gaSql['link'],$sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
                            $aResul = mysqli_fetch_array($rImage);
                            if (isset($aResul['id_img']) && (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$aResul['id_img'].'_md.jpg'))) {
                                  $row[] = '<img src="/media/images/properties/thumbnails/'.$aResul['id_img'].'_sm.jpg" alt="" style="max-height: 100px;">';
                              } else {
                                  $row[] = '<img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="max-height: 70px;">';
                              }
                          } else {
                              if($aRow[ $aColumns[$i] ]!==null) {
                                  $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], 'UTF-8', 'ISO-8859-1');
                              } else {
                                  $row[] = '';
                              }
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
