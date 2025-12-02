<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/vendor/autoload.php' );

use Stichoza\GoogleTranslate\TranslateClient;

$tr = new TranslateClient();

set_time_limit(0);

// Tipos

$fields = '';
$where = array();
foreach ($languages as $lang) {
    $fields .= 'types_' . $lang . '_typ, ';
    if ($lang != $autotraduccion_from) {
        array_push($where, ' types_' . $lang . '_typ = \'\' OR types_' . $lang . '_typ IS NULL');
    }
}


$query_rsTipos = "SELECT " . $fields. " id_typ FROM properties_types WHERE  " . implode(" OR ", $where). "";
$rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);

do {
    set_time_limit(0);
    if ($row_rsTipos['types_' . $autotraduccion_from . '_typ'] != '') {
        foreach ($languages as $lang) {
            $langtrad= ($lang == 'se')?'sv':$lang;
            if ($lang != $autotraduccion_from) {
                if ($row_rsTipos['types_' . $lang . '_typ'] == '') {
                    
                    $query_rsUpdate = "UPDATE `properties_types` SET `types_" . $lang . "_typ` = '" . str_replace('& amp;', '&amp;', ucfirst(mysqli_real_escape_string($inmoconn,$tr->setSource($autotraduccion_from)->setTarget($langtrad)->translate(html_entity_decode($row_rsTipos['types_' . $autotraduccion_from . '_typ']))))) . "' WHERE `id_typ` = ".$row_rsTipos['id_typ']."";
                    $rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());
                }
            }
        }
    }
} while ($row_rsTipos = mysqli_fetch_assoc($rsTipos));

// CARACTERISTICAS

$fields = '';
$where = array();
foreach ($languages as $lang) {
    $fields .= 'feature_' . $lang . '_feat, ';
    if ($lang != $autotraduccion_from) {
        array_push($where, ' feature_' . $lang . '_feat = \'\' OR feature_' . $lang . '_feat IS NULL');
    }
}


$query_rsFeatures = "SELECT " . $fields. " id_feat FROM `properties_features_priv` WHERE " . implode(" OR ", $where). "";
$rsFeatures = mysqli_query($inmoconn,$query_rsFeatures) or die(mysqli_error());
$row_rsFeatures = mysqli_fetch_assoc($rsFeatures);
$totalRows_rsFeatures = mysqli_num_rows($rsFeatures);

do {
    set_time_limit(0);
    if ($row_rsFeatures['feature_' . $autotraduccion_from . '_feat'] != '') {
        foreach ($languages as $lang) {
            $langtrad= ($lang == 'se')?'sv':$lang;
            if ($lang != $autotraduccion_from) {
                if ($row_rsFeatures['feature_' . $lang . '_feat'] == '') {
                    
                    $query_rsUpdate = "UPDATE `properties_features_priv` SET `feature_" . $lang . "_feat` = '" . str_replace('& amp;', '&amp;', ucfirst(mysqli_real_escape_string($inmoconn,$tr->setSource($autotraduccion_from)->setTarget($langtrad)->translate(html_entity_decode($row_rsFeatures['feature_' . $autotraduccion_from . '_feat']))))) . "' WHERE `id_feat` = ".$row_rsFeatures['id_feat']."";
                    $rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());
                }
            }
        }
    }
} while ($row_rsFeatures = mysqli_fetch_assoc($rsFeatures));

$fields = '';
$where = array();
foreach ($languages as $lang) {
    $fields .= 'descripcion_' . $lang . '_prop, ';
    if ($lang != $autotraduccion_from) {
        array_push($where, ' descripcion_' . $lang . '_prop = \'\' OR descripcion_' . $lang . '_prop IS NULL');
    }
}

// INMUEBLES


$query_rsInmuebles = "SELECT " . $fields. " id_prop FROM `properties_properties` WHERE " . implode(" OR ", $where). " ORDER BY id_prop DESC";
$rsInmuebles = mysqli_query($inmoconn,$query_rsInmuebles) or die(mysqli_error());
$row_rsInmuebles = mysqli_fetch_assoc($rsInmuebles);
$totalRows_rsInmuebles = mysqli_num_rows($rsInmuebles);

do {
    set_time_limit(0);
    if (strlen($row_rsInmuebles['descripcion_' . $autotraduccion_from . '_prop']) <= 4900) {
        if ($row_rsInmuebles['descripcion_' . $autotraduccion_from . '_prop'] != '') {
            foreach ($languages as $lang) {
                $langtrad= ($lang == 'se')?'sv':$lang;
                if ($lang != $autotraduccion_from) {
                    if ($row_rsInmuebles['descripcion_' . $lang . '_prop'] == '') {
                        
                        $query_rsUpdate = "UPDATE `properties_properties` SET `descripcion_" . $lang . "_prop` = '" . str_replace('& amp;', '&amp;', ucfirst(mysqli_real_escape_string($inmoconn,$tr->setSource($autotraduccion_from)->setTarget($langtrad)->translate(html_entity_decode($row_rsInmuebles['descripcion_' . $autotraduccion_from . '_prop']))))) . "' WHERE `id_prop` = ".$row_rsInmuebles['id_prop']."";
                        $rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());
                    }
                }
            }
        }
    }
} while ($row_rsInmuebles = mysqli_fetch_assoc($rsInmuebles));

?>