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

if ($_SESSION['kt_login_level'] == 7) {
  $aColumns = array('image_img', 'referencia_prop', 'status_' .$lang_adm. '_sta', 'types_' .$lang_adm. '_typ', 'name_' .$lang_adm. '_loc3', 'name_' .$lang_adm. '_loc4',  'preci_reducidoo_prop', 'destacado_prop');
} else {
  $aColumns = array('image_img', 'referencia_prop', 'status_' .$lang_adm. '_sta', 'types_' .$lang_adm. '_typ', 'name_' .$lang_adm. '_loc3', 'name_' .$lang_adm. '_loc4', 'direccion_prop', 'owner_prop', 'preci_reducidoo_prop', 'destacado_prop');
}

array_push($aColumns, 'activado_prop');
array_push($aColumns, 'vendido_prop');
if($showprecioReduc == 1) {
array_push($aColumns, 'oferta_prop');
}
array_push($aColumns, 'units_prop');
if ($xmlImport == 1) {
array_push($aColumns, 'force_hide_prop');
array_push($aColumns, 'xml_xml_prop');
array_push($aColumns, 'ref_xml_prop');
}
array_push($aColumns, 'inserted_xml_prop');
array_push($aColumns, 'id_prop');


$aColumns = array_values($aColumns);


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
  //$gaSql['db']

  /*
  if ( ! mysqli_select_db( , $gaSql['link'] ) )
  {
    fatal_error( 'Could not select database ' );
  }
  */

  //@mysqli_query("SET NAMES 'utf8mb4'");
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

        if($aColumns[$i] == 'inserted_xml_prop') {
          $sWhere .= "DATE_FORMAT(`inserted_xml_prop`, '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'])."%' OR ";
        } else {
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch'] )."%' OR ";
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
      if($aColumns[$i] == 'inserted_xml_prop') {
        $sWhere .= "DATE_FORMAT(".$aColumns[$i].", '%d-%m-%Y %h:%i') LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
      } else {
        if($aColumns[$i] == 'destacado_prop' || $aColumns[$i] == 'activado_prop' || $aColumns[$i] == 'ubiflow_prop' || $aColumns[$i] == 'rightmove_prop' || $aColumns[$i] == 'greenacres_prop' || $aColumns[$i] == 'zoopla_prop' || $aColumns[$i] == 'inmoweb_prop' || $aColumns[$i] == 'trovit_prop' || $aColumns[$i] == 'oferta_prop' || $aColumns[$i] == 'force_hide_prop' || $aColumns[$i] == 'vendido_prop') {

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('Sí', true)))) {
              $sWhere .= $aColumns[$i]." = '1' ";
          }

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('No', true)))) {
              $sWhere .= $aColumns[$i]." = '0' ";
          }

        } else {
          if($aColumns[$i] == 'owner_prop') {
            $sWhere .= "CONCAT_WS(' ' , properties_owner.nombre_pro,  properties_owner.apellidos_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch_'.$i])."%' ";
          } else {
            if($aColumns[$i] == 'xml_xml_prop') {
              $sWhere .= "(SELECT site_xml FROM xml WHERE id_xml = xml_xml_prop) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
            } else {
              $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
            }
          }

        }
      }

    }
  }

  // $conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
  // $isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
  // $isLoggedIn1->addLevel("7");
  // if ($isLoggedIn1->Execute()) {

  //     if($sWhere != '') {
  //         $sWhere .= ' AND user_prop = \''.$_SESSION['kt_login_id'].'\' ';
  //     } else {
  //         $sWhere .= ' WHERE user_prop = \''.$_SESSION['kt_login_id'].'\' ';
  //     }

  //     $sWhere = preg_replace('/WHERE[ \t]+AND/', 'WHERE', $sWhere);

  // }


  /*
   * SQL queries
   * Get data to display
   */
  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      (SELECT site_xml FROM xml WHERE id_xml = xml_xml_prop) AS xml_xml_prop,
      properties_properties.referencia_prop,
      properties_properties.inserted_xml_prop,
      properties_status.status_" .$lang_adm. "_sta,
      properties_types.types_" .$lang_adm. "_typ,
      properties_loc3.name_" .$lang_adm. "_loc3,
      properties_loc4.name_" .$lang_adm. "_loc4,
      preci_reducidoo_prop,
      direccion_prop,
      CONCAT_WS(' ' , properties_owner.nombre_pro, properties_owner.apellidos_pro) as owner_prop,
      case properties_properties.destacado_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as destacado_prop,
      case properties_properties.oferta_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as oferta_prop,
      case properties_properties.activado_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as activado_prop,
      case properties_properties.force_hide_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as force_hide_prop,
      case properties_properties.vendido_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as vendido_prop,
      properties_properties.ref_xml_prop,
      properties_properties.id_prop,
      properties_properties.id_prop as image_img,
      units_prop
    FROM properties_properties
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
      LEFT OUTER JOIN properties_types ON properties_properties.tipo_prop = properties_types.id_typ
      LEFT OUTER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
      LEFT OUTER JOIN properties_loc3 ON properties_loc3.id_loc3 = properties_loc4.loc3_loc4
      LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
    $sWhere
    $sOrder
    $sLimit
  ";

  $rResult = mysqli_query($gaSql['link'], $sQuery);
  if (!$rResult) {
      // Si mysqli_query falla, obtenemos el número de error y mostramos un mensaje de error personalizado
      $errorMessage = 'MySQL Error: ' . mysqli_errno($gaSql['link']) . '<hr>' . mysqli_error($gaSql['link']) . '<hr>' . $sQuery;
      fatal_error($errorMessage);
  }
  // echo  $sQuery . '<hr>';

  /* Data set length after filtering */
  $sQuery = "
    SELECT FOUND_ROWS()
  ";
  $rResultFilterTotal = mysqli_query($gaSql['link'],$sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
  $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
  $iFilteredTotal = $aResultFilterTotal[0];

  /* Total data set length */
  $sQuery = "
    SELECT COUNT(".$sIndexColumn.")
    FROM   $sTable
  ";
  $rResultTotal = mysqli_query($gaSql['link'],$sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
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
      if($aColumns[$i] == 'inserted_xml_prop') {

          if ($aRow[ $aColumns[$i] ] == null) {
            $row[] = '&nbsp;';
          } else {
            $row[] = date("d-m-Y H:i", strtotime($aRow[ $aColumns[$i] ]));
          }
      }
      else if ( $aColumns[$i] != ' ' )
      {
        if ($aColumns[$i] == 'image_img') {
          $sQuery = "SELECT id_img FROM properties_images WHERE property_img = ".$aRow[ $aColumns[$i] ]." ORDER BY order_img LIMIT 1";
          $rImage = mysqli_query($gaSql['link'],$sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
          $aResul = mysqli_fetch_array($rImage);
          if (isset($aResul['id_img']) && (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$aResul['id_img'].'_md.jpg'))) {
                $row[] = '<a href="/media/images/properties/thumbnails/'.$aResul['id_img'].'_md.jpg" class="btn-img-list-carr"
              data-toggle="lightbox-" data-gallery="mnews-gallery-' . $aRow['id_prop'] . '" data-type="image" data-max-width="1500" data-title="' . $aRow['referencia_prop'] . ' - ' . $aRow['name_' .$lang_adm. '_loc3'] . ' - ' . $aRow['types_' .$lang_adm. '_typ'] . '" data-id="' . $aRow['id_prop'] . '"><img src="/media/images/properties/thumbnails/'.$aResul['id_img'].'_sm.jpg" alt="" style="max-height: 150px;"></a>';
            } else {
                $row[] = '<img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" style="max-height: 70px;">';
            }
        } else {
          if ($aColumns[$i] == 'preci_reducidoo_prop') {
              if(isset($aRow[ $aColumns[$i] ])) {
                  $row[] = number_format($aRow[ $aColumns[$i] ], 0 , ',', '.');
              }
              else {
                  $row[] = "";
              }
          } else {
              if ($aColumns[$i] == 'referencia_prop') {

                  /*
                  mysqli_select_db($database_inmoconn, $inmoconn);
                  $query_rsMetas = "SELECT * FROM properties_properties WHERE referencia_prop = '".$aRow[ $aColumns[$i] ]."' LIMIT 1";
                  $rsMetas = mysqli_query($query_rsMetas, $inmoconn) or die(mysqli_error());
                  $row_rsMetas = mysqli_fetch_assoc($rsMetas);

                  mysqli_select_db($database_inmoconn, $inmoconn);
                  $sQuery = "SELECT image_img FROM properties_images WHERE property_img = ".$aRow[ 'id_prop' ]." ORDER BY order_img LIMIT 1";
                  $rImage = mysqli_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
                  $aResul = mysqli_fetch_array($rImage);

                  $classImgs = 'style="display: inline; margin: 0 0px 0 0; width: 10px; height: 10px;"';

                  $titlesScore = 0;
                  $descriptionScore = 0;
                  $keywordsScore = 0;
                  $countLangs = count($languages);
                  $imgTitles = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="' . __('Title', true) . '" title="' . __('Title', true) . '"> ';
                  $imgDescription = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="' . __('Description', true) . '" title="' . __('Description', true) . '"> ';
                  $imgKeywords = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="' . __('Keywords', true) . '" title="' . __('Keywords', true) . '"> ';
                  $imgIMG = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="'.__('Details & Images ready',true).'" title="'.__('Details & Images ready',true).'"> ';
                  $imgACT = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="'.__('Publish on the website', true).'" title="'.__('Publish on the website', true).'"> ';
                  $imgPort = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="'.__('Publish on portals', true).'" title="'.__('Publish on portals', true).'"> ';
                  $imgCHK1 = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="'.__('Viewing arrange', true).'" title="'.__('Viewing arrange', true).'"> ';
                  $imgCHK2 = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="'.__('Applicant interested no meeting', true).'" title="'.__('Applicant interested no meeting', true).'"> ';
                  $imgCHK3 = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/0.png" data-toggle="tooltip" data-placement="top" alt="'.__('Sale in progress', true).'" title="'.__('Sale in progress', true).'"> ';

                  foreach ($languages as $key => $value) {
                      if($row_rsMetas['title_' . $value . '_prop'] != '') {
                          $titlesScore = $titlesScore + 1;
                      }
                      if($row_rsMetas['description_' . $value . '_prop'] != '') {
                          $descriptionScore = $descriptionScore + 1;
                      }
                      if($row_rsMetas['keywords_' . $value . '_prop'] != '') {
                          $keywordsScore = $keywordsScore + 1;
                      }
                  }

                  if ($titlesScore == $countLangs) {
                    $imgTitles = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/1.png" data-toggle="tooltip" data-placement="top" alt="' . __('Title', true) . '" title="' . __('Title', true) . '"> ';
                  }

                  if ($descriptionScore == $countLangs) {
                    $imgDescription = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/1.png" data-toggle="tooltip" data-placement="top" alt="' . __('Description', true) . '" title="' . __('Description', true) . '"> ';
                  }

                  if ($keywordsScore == $countLangs) {
                    $imgKeywords = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/1.png" data-toggle="tooltip" data-placement="top" alt="' . __('Keywords', true) . '" title="' . __('Keywords', true) . '"> ';
                  }

                  if ($aResul['image_img'] != '' && $row_rsMetas['descripcion_en_prop'] != '')  {
                    $imgIMG = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/2.png" data-toggle="tooltip" data-placement="top" alt="'.__('Details & Images ready',true).'" title="'.__('Details & Images ready',true).'"> ';
                  }

                  if ($row_rsMetas['activado_prop'] == '1')  {
                    $imgACT = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/3.png" data-toggle="tooltip" data-placement="top" alt="'.__('Publish on the website', true).'" title="'.__('Publish on the website', true).'"> ';
                  }

                  if ($row_rsMetas['export_kyero_prop'] == '1' || $row_rsMetas['export_thinkspain_prop'] == '1' || $row_rsMetas['export_green_prop'] == '1' || $row_rsMetas['export_habitaclia_prop'] == '1' || $row_rsMetas['export_pisos_prop'] == '1' || $row_rsMetas['export_todopisoalicante_prop'] == '1' || $row_rsMetas['expport_APITS_prop'] == '1' || $row_rsMetas['expport_CostadelHome_prop'] == '1' || $row_rsMetas['expport_SpainHomes_prop'] == '1' || $row_rsMetas['export_huis_prop'] == '1' || $row_rsMetas['export_zoopla_prop'] == '1' || $row_rsMetas['export_rightmove_prop'] == '1' || $row_rsMetas['export_fotocasa_prop'] == '1' || $row_rsMetas['idealista_prop'] == '1')  {
                    $imgPort = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/4.png?3425234534534" data-toggle="tooltip" data-placement="top" alt="'.__('Publish on portals', true).'" title="'.__('Publish on portals', true).'"> ';
                  }

                  if ($row_rsMetas['viewing_arrange_prop'] == '1')  {
                    $imgCHK1 = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/5.png" data-toggle="tooltip" data-placement="top" alt="'.__('Viewing arrange', true).'" title="'.__('Viewing arrange', true).'"> ';
                  }

                  if ($row_rsMetas['applicant_interested_no_meeting_prop'] == '1')  {
                    $imgCHK2 = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/6.png" data-toggle="tooltip" data-placement="top" alt="'.__('Applicant interested no meeting', true).'" title="'.__('Applicant interested no meeting', true).'"> ';
                  }

                  if ($row_rsMetas['sale_in_progress_prop'] == '1')  {
                    $imgCHK3 = '<img ' . $classImgs . ' src="/intramedianet/includes/assets/img/7.png" data-toggle="tooltip" data-placement="top" alt="'.__('Sale in progress', true).'" title="'.__('Sale in progress', true).'"> ';
                  }


                  $row[] = '<span style="display: block; width: 100%; white-space: nowrap !important;">' . ($aRow[ $aColumns[$i] ]) . '<hr style="margin: 1px 0 5px;">' . $imgTitles . '&nbsp;' . $imgDescription . '&nbsp;' . $imgKeywords . '<br>' . $imgIMG . '&nbsp;' . $imgACT . '&nbsp;' . $imgPort . '&nbsp;' . $imgCHK1 . '&nbsp;' . $imgCHK2 . '&nbsp;' . $imgCHK3 . '</span>';

                  */

                 $row[] = '<div class="text-center"><b>' . $aRow[ $aColumns[$i] ] . '</b><a href="properties-form.php?id_prop=' . $aRow['id_prop'] . '&KT_back=1" class="btn btn-success btn-sm w-100 mt-2"><i class="fa-regular fa-pencil"></i> ' . __('Editar', true) . '</a></div>';

              } else {
                  $row[] = ($aRow[ $aColumns[$i] ]);
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
