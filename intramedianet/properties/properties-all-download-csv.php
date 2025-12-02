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

  // echo "<pre>";
  // print_r($_GET);
  // echo "</pre>";


  $aColumns = array('id_prop', 'image_img', 'referencia_prop', 'status_' .$lang_adm. '_sta', 'types_' .$lang_adm. '_typ', 'name_' .$lang_adm. '_loc3', 'name_' .$lang_adm. '_loc4', 'preci_reducidoo_prop', 'activado_prop', 'nombre_pro', 'telefono_fijo_pro', 'id_prop');

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
   * SQL queries
   * Get data to display
   */

  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.referencia_prop AS Referencia,
      case properties_properties.activado_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Activado,
      properties_status.status_" .$lang_adm. "_sta AS Status,
      CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS Tipo,
      -- CONVERT(properties_loc1.name_" .$lang_adm. "_loc1 USING latin1) AS Pais,
      CASE WHEN properties_loc2.name_" .$lang_adm. "_loc2 IS NOT NULL THEN properties_loc2.name_" .$lang_adm. "_loc2 ELSE province1.name_" .$lang_adm. "_loc2  END AS Provincia,
      CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS Ciudad,
      CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS Zona,
      properties_properties.lat_long_gp_prop as 'Latitud y Longitud',
      SUBSTRING_INDEX(properties_properties.lat_long_gp_prop, ',', 1) as Latitud,
      TRIM(SUBSTRING_INDEX(properties_properties.lat_long_gp_prop, ',', -1)) as Longitud,
      preci_reducidoo_prop AS Precio,
      precio_prop AS Precio_Anterior,
      case properties_properties.vendido_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Vendido,
      case properties_properties.alquilado_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Alquilado,
      case properties_properties.reservado_prop
          when '1' then '". __('Si', true) . "'
          when '0' then '" . __('No', true) . "'
      end as Reservado,
      construccion_prop AS Ano_de_Construccion,
      energia_prop AS Calificacion_energetica,
      habitaciones_prop AS Habitaciones,
      aseos_prop AS Banos,
      aseos2_prop AS Aseos,
      cocinas_prop AS Cocinas,
      m2_prop AS M2,
      m2_parcela_prop AS M2_Parcela,
      m2_balcon_prop AS M2_Terraza,
      CONCAT_WS(' ', nombre_pro, apellidos_pro) as Nombre_Propietario,
      CONCAT_WS(' - ', telefono_fijo_pro, telefono_movil_pro) as Telefono_Propietario,
      email_pro as Email_Propietario
    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
    WHERE properties_properties.lat_long_gp_prop IS NOT NULL
    GROUP BY id_prop

  ";

  // echo  $sQuery . '<hr>';

  $rResult = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() . '<hr>' . $sQuery);

  $field = mysqli_num_fields($rResult);

  $return = array();

  $fila = array();

  // create line with field names
  for ($i = 0; $i < $field; $i++) {
    $field_info = $rResult->fetch_field_direct($i); // Obtener información del campo
    $field_name = $field_info->name; // Obtener el nombre del campo
    array_push($fila, $field_name);
  }
  array_push($return, $fila);
  // newline (seems to work both on Linux & Windows servers)
  // $csv_export.= '
  // ';
  while($row = mysqli_fetch_array($rResult)) {
    // create line with field values
    $fila = array();
    for($i = 0; $i < $field; $i++) {
        $field_info = $rResult->fetch_field_direct($i); // Obtener información del campo
        $field_name = $field_info->name; // Obtener el nombre del campo
        array_push($fila, $row[$field_name]);
        // $csv_export.= '"'.$row[$field_name].'",';
    }
    array_push($return, $fila);
    // $csv_export.= '
    // ';
  }

// header("Content-type: text/x-csv");
// header("Content-Disposition: attachment; filename=".$csv_filename."");
// echo($csv_export);


//   die();

function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";") {
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'";');

  // open the "output" stream
  // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-description
  $f = fopen('php://output', 'w');

  if (!empty($array)) {
      // Get the headers of the first row (assuming all rows have the same keys)
      $headers = array_keys($array[0]);
      fputcsv($f, $headers, $delimiter);

      // Write the data
      foreach ($array as $line) {
          fputcsv($f, $line, $delimiter);
      }
  }
}



    // while ($row = mysqli_fetch_assoc($rResult)) {
    //   array_push($return, $row);
    // }

    // echo "<pre>";
    // print_r($return);
    // echo "</pre>";
    // die();

    array_to_csv_download($return, time() . ".csv");


?>
