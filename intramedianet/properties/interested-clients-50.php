<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$sWhere = ' WHERE archived_cli = 0 ';

$query_rsClients = "SELECT * FROM properties_client  $sWhere  ORDER BY id_cli DESC";
$rsClients = mysqli_query($inmoconn, $query_rsClients) or die(mysqli_error());
$row_rsClients = mysqli_fetch_assoc($rsClients);
$totalRows_rsClients = mysqli_num_rows($rsClients);

$locationGet = ($_GET['loc'] != '')?$_GET['loc']:'0';

$query_rsLocations = "
SELECT
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id_loc3
    FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
WHERE CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END = " . $locationGet . "
";
$rsLocations = mysqli_query($inmoconn, $query_rsLocations) or die(mysqli_error());
$row_rsLocations = mysqli_fetch_assoc($rsLocations);
$totalRows_rsLocations = mysqli_num_rows($rsLocations);

$clients = array();

do {

    $fail = false;

	$score = 0;

	if ($row_rsClients['b_sale_cli'] != '') {
		$vals = explode(',', $row_rsClients['b_sale_cli']);
		if (in_array($_GET['ope'], $vals)) {
			$score = $score +1;
        }
	}

	if ($row_rsClients['b_type_cli'] != '') {
		$vals = explode(',', $row_rsClients['b_type_cli']);
		if (in_array($_GET['typ'], $vals)) {
			$score = $score +1;
        }
	}

	// if ($_GET['hab'] >= $row_rsClients['b_beds_cli']) {
	// 	$score = $score +1;
	// }



    if (($row_rsClients['b_precio_desde_cli'] != '' && $_GET['pre'] >= $row_rsClients['b_precio_desde_cli']) || ($row_rsClients['b_precio_hasta_cli'] != '' && $_GET['pre'] <= $row_rsClients['b_precio_hasta_cli'])) {
        $score = $score +2;
    }

    if ($row_rsClients['b_precio_desde_cli'] != '' && $row_rsClients['b_precio_hasta_cli'] != '') {
        if ($_GET['pre'] >= $row_rsClients['b_precio_desde_cli'] && $_GET['pre'] <= $row_rsClients['b_precio_hasta_cli']) {
        } else {
            $fail = true;
        }
    }

    if ($row_rsClients['b_precio_desde_cli'] == '' && $row_rsClients['b_precio_hasta_cli'] != '') {
        if ($_GET['pre'] <= $row_rsClients['b_precio_hasta_cli']) {
        } else {
            $fail = true;
        }
    }

	if ($row_rsClients['b_loc3_cli'] != '') {
		$vals = explode(',', $row_rsClients['b_loc3_cli']);
		if (in_array($row_rsLocations['id_loc3'], $vals)) {
			$score = $score +1;
		}
	}

	// if ($row_rsClients['b_loc4_cli'] != '') {
	// 	$vals = explode(',', $row_rsClients['b_loc4_cli']);
	// 	if (in_array($row_rsLocations['id_loc4'], $vals)) {
	// 		$score = $score +1;
	// 	}
	// }

	if ((round($score*100)/5) >= $_GET['porcen'] && $fail != true) {
		array_push($clients, array('score'=>$score, 'name'=>$row_rsClients['nombre_cli'] . ' ' . $row_rsClients['apellidos_cli'], 'direccion'=>$row_rsClients['direccion_cli'], 'telefono'=>$row_rsClients['telefono_fijo_cli'], 'movil'=>$row_rsClients['telefono_movil_cli'], 'email'=>$row_rsClients['email_cli'], 'skype'=>$row_rsClients['skype_cli'], 'alta'=>$row_rsClients['fecha_alta_cli'], 'id'=>$row_rsClients['id_cli'], 'b_sale_cli'=>$row_rsClients['b_sale_cli'], 'b_beds_cli'=>$row_rsClients['b_beds_cli'], 'b_baths_cli'=>$row_rsClients['b_baths_cli'], 'b_type_cli'=>$row_rsClients['b_type_cli'], 'b_loc1_cli'=>$row_rsClients['b_loc1_cli'], 'b_loc2_cli'=>$row_rsClients['b_loc2_cli'], 'b_loc3_cli'=>$row_rsClients['b_loc3_cli'], 'b_loc4_cli'=>$row_rsClients['b_loc4_cli'], 'b_ref_cli'=>$row_rsClients['b_ref_cli'], 'b_precio_desde_cli'=>$row_rsClients['b_precio_desde_cli'], 'b_precio_hasta_cli'=>$row_rsClients['b_precio_hasta_cli'], 'idioma_cli'=>$row_rsClients['idioma_cli'], 'porcentaje' => ($_GET['porcen']*1)/5  ));
	}

} while ($row_rsClients = mysqli_fetch_assoc($rsClients));




arsort($clients);

foreach ($clients as $key => $value) {

            if ($value['idioma_cli'] != '') {
                $lanfsend = $value['idioma_cli'];
            } else {
                $lanfsend = $language;
            }


			if ($value['email'] != '') {
				echo $value['id'] . '@@@@' . $value['email'] . '@@@@' . $lanfsend . '####';
			}
}

?>
