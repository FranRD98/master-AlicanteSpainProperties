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


function encryptIt($idCli, $encryptionKey = 'DLusjkq6kkzRUbY7TVc7YH2RcT2')
{
    global $_SERVER;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_key = $_SERVER['HTTP_HOST'];
    $encryption_iv = $_SERVER['HTTP_HOST'];

    $encryption = openssl_encrypt($idCli, $ciphering,
            $encryption_key, $options, $encryption_iv);
    return $encryption;
}

  //sleep(2);

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * Easy set variables
   */

  /* Array of database columns which should be read and sent back to DataTables. Use a space where
   * you want to insert a non-database field (for example a counter or static image)
   */


  $aColumns = array('image_img', 'referencia_prop', 'status_' .$lang_adm. '_sta', 'types_' .$lang_adm. '_typ', 'name_' .$lang_adm. '_loc3', 'name_' .$lang_adm. '_loc4', 'preci_reducidoo_prop', 'activado_prop', 'nombre_pro', 'telefono_fijo_pro', 'id_prop', 'id_encript');

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
          $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'], $_GET['sSearch'] )."%' OR ";
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
        if($aColumns[$i] == 'destacado_prop' || $aColumns[$i] == 'activado_prop' || $aColumns[$i] == 'ubiflow_prop' || $aColumns[$i] == 'rightmove_prop' || $aColumns[$i] == 'greenacres_prop' || $aColumns[$i] == 'zoopla_prop' || $aColumns[$i] == 'inmoweb_prop' || $aColumns[$i] == 'trovit_prop') {

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('Sí', true)))) {
              $sWhere .= $aColumns[$i]." = '1' ";
          }

          if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('No', true)))) {
              $sWhere .= $aColumns[$i]." = '0' ";
          }

        } else {
          if($aColumns[$i] == 'nombre_pro') {
            $sWhere .= " CONCAT(nombre_pro, ' ', apellidos_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
          } else {
            if($aColumns[$i] == 'telefono_fijo_pro') {
              $sWhere .= " CONCAT(telefono_fijo_pro, ' ', telefono_movil_pro) LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
            } else {
              $sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
            }
          }
        }
      }

    }
  }

  if($sWhere != '') {
      $sWhere .= ' AND owner_prop = \''.$_GET['p'].'\' AND owner_prop != \'\'';
  } else {
      $sWhere .= ' WHERE owner_prop = \''.$_GET['p'].'\' AND owner_prop != \'\'';
  }


  /*
   * SQL queries
   * Get data to display
   */

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.referencia_prop,
      properties_status.status_" .$lang_adm. "_sta,
      properties_types.types_" .$lang_adm. "_typ,
      properties_loc3.name_" .$lang_adm. "_loc3,
      properties_loc4.name_" .$lang_adm. "_loc4,
      preci_reducidoo_prop,
      case properties_properties.activado_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as activado_prop,
      properties_properties.id_prop,
      properties_properties.id_prop AS id_encript,
      properties_properties.id_prop as image_img,
      CONCAT(nombre_pro, ' ', apellidos_pro) as nombre_pro,
      CONCAT(telefono_fijo_pro, '<br>', telefono_movil_pro) as telefono_fijo_pro
    FROM properties_properties
      INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
      INNER JOIN properties_types ON properties_properties.tipo_prop = properties_types.id_typ
      INNER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
      INNER JOIN properties_loc3 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3
      INNER JOIN properties_loc2 ON properties_loc3.loc2_loc3 = properties_loc2.id_loc2
      INNER JOIN properties_loc1 ON properties_loc2.loc1_loc2 = properties_loc1.id_loc1
      LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
    $sWhere
    GROUP BY id_prop
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
    FROM   $sTable WHERE owner_prop = '".$_GET['p']."'
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
          $rImage = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
          $aResul = mysqli_fetch_array($rImage);
          if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$aResul['id_img'].'_md.jpg')) {
              $row[] = '<img src="/media/images/properties/thumbnails/'.$aResul['id_img'].'_sm.jpg" alt="" style="height: 100px;">';
              // $row[] = '<a href="/media/images/properties/thumbnails/'.$aResul['id_img'].'_md.jpg" data-toggle="lightbox"><img src="/media/images/properties/thumbnails/'.$aResul['id_img'].'_sm.jpg" alt="" style="height: 100px;"></a>';
          } else {
              $row[] = '<img src="/intramedianet/includes/assets/img/no_image.jpg" alt="">';
          }
        } else {
          if ($aColumns[$i] == 'preci_reducidoo_prop') {
              $row[] = number_format($aRow[ $aColumns[$i] ], 0 , ',', '.');
          } else {
              if ($aColumns[$i] == 'referencia_prop') {
                if (isset($appLang) && $appLang == 'es') {
                    if ($language == 'es') {
                        $urlStart = '/';
                    } else {
                        $urlStart = '/es/';
                    }
                    $row[] = '<a href="/intramedianet/properties/properties-form.php?id_prop='.$aRow['id_prop'].'&KT_back=1" class="btn btn-soft-primary btn-sm" target="_blank">' . $aRow[ $aColumns[$i] ] . '</a>';
                } else {
                    if ($language == 'en') {
                        $urlStart = '/';
                    } else {
                        $urlStart = '/en/';
                    }
                    $row[] = '<a href="/intramedianet/properties/properties-form.php?id_prop='.$aRow['id_prop'].'&KT_back=1" class="btn btn-soft-primary btn-sm" target="_blank">' . $aRow[ $aColumns[$i] ] . '</a>';
                }
              } else {
                  if ($aColumns[$i] == 'id_encript') {
                      $row[] = encryptIt($aRow[$aColumns[$i]]);
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
