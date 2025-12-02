<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
include( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

function rip_tags($string) {
    $string = preg_replace ('/<[^>]*>/', ' ', $string);
    $string = str_replace("\r", '', $string);
    $string = str_replace("\n", ' ', $string);
    $string = str_replace("\t", ' ', $string);
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
    return $string;
}

function convertirAnicename($text) {
    $text = str_replace('<p>', ' ', $text);
    $text = str_replace('</p>', ' ', $text);
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);
    $text = str_replace('&', '', $text);
    $text = str_replace('amp;', '', $text);
    $text = str_replace('acute;', '', $text);
    $text = str_replace('ntilde;', 'n', $text);
    $text = str_replace('nbsp;', '', $text);
    $text = str_replace('ordm;', 'o', $text);
    //$text = str_replace(''', '&apos;', $text);
    $text = str_replace('"', '&quot;', $text);
    return ($text);
}

function toSlug($string) {
    if (function_exists('iconv')) {
        $string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    }
    $string = preg_replace("/[^a-zA-Z0-9 -]/", "", $string);
    $string = strtolower($string);
    $string = str_replace(" ", "-", $string);
    return $string;
}


$query_idealista = "SELECT
properties_properties.id_prop AS id,
properties_properties.referencia_prop as ref,
properties_properties.preci_reducidoo_prop AS pr,
properties_properties.precio_prop AS prb,
properties_loc1.name_es_loc1 AS ctr,
CASE WHEN properties_loc2.name_es_loc2 IS NOT NULL THEN properties_loc2.name_es_loc2 ELSE province1.name_es_loc2  END AS reg,
CASE WHEN properties_loc3.name_es_loc3 IS NOT NULL THEN properties_loc3.name_es_loc3 ELSE areas1.name_es_loc3  END AS sreg,
CASE WHEN properties_loc4.name_es_loc4 IS NOT NULL THEN properties_loc4.name_es_loc4 ELSE towns.name_es_loc4  END AS loc,
CONCAT('/media/images/properties/',(SELECT properties_images.image_img FROM properties_images WHERE properties_properties.id_prop = properties_images.property_img ORDER BY properties_images.order_img ASC LIMIT 1)) as img,
properties_properties.title_es_prop as mtTit,
properties_properties.description_es_prop as mtDes,
properties_properties.keywords_es_prop as mtKey,
properties_properties.descripcion_es_prop as descr,
properties_status.status_es_sta AS sta,
properties_types.types_es_typ AS typ,
properties_properties.title_en_prop as mtTit2,
properties_properties.description_en_prop as mtDes2,
properties_properties.keywords_en_prop as mtKey2,
properties_properties.descripcion_en_prop as descr2,
properties_status.status_en_sta AS sta2,
properties_types.types_en_typ AS typ2,
properties_properties.title_de_prop as mtTit3,
properties_properties.description_de_prop as mtDes3,
properties_properties.keywords_de_prop as mtKey3,
properties_properties.descripcion_de_prop as descr3,
properties_status.status_de_sta AS sta3,
properties_types.types_de_typ AS typ3,
properties_properties.title_fr_prop as mtTit4,
properties_properties.description_fr_prop as mtDes4,
properties_properties.keywords_fr_prop as mtKey4,
properties_properties.descripcion_fr_prop as descr4,
properties_status.status_fr_sta AS sta4,
properties_types.types_fr_typ AS typ4,
properties_properties.title_ru_prop as mtTit5,
properties_properties.description_ru_prop as mtDes5,
properties_properties.keywords_ru_prop as mtKey5,
properties_properties.descripcion_ru_prop as descr5,
properties_status.status_ru_sta AS sta5,
properties_types.types_ru_typ AS typ5,
m2_prop as floor,
m2_parcela_prop as plot,
habitaciones_prop as bed,
aseos_prop as fbth,
piscina_prop as pisc,
ascensor_prop as ascen,
m2_balcon_prop,
energia_prop as energ,
direccion_gp_prop as mapdir,
lat_long_gp_prop as maplat,
vendido_prop as vend,
alquilado_prop as alq,
reservado_prop as res,
nuevo_prop as new,
plantas_prop,
operacion_prop,
tipo_prop,
direccion_prop,
direccion_gp_prop,
construccion_prop,
orientacion_prop
 FROM properties_loc4 towns
 LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
 LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    INNER JOIN properties_types ON properties_properties.tipo_prop = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
    INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
 WHERE activado_prop = 1 AND idealista_prop = 1
 GROUP BY properties_properties.id_prop
";


$idealista = mysqli_query($inmoconn,$query_idealista) or die(mysqli_error());
$row_idealista = mysqli_fetch_assoc($idealista);
$totalRows_idealista = mysqli_num_rows($idealista);

//CONVERTIR FECHA ULTIMA ACTUALIZACIÓN A TIMESTAMP
function convert_datetime($str)
{
list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);
$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
return $timestamp;
}

header('Content-type: text/xml; charset=UTF-8', true);
$Content .= '<?xml version="1.0" encoding="UTF-8"?'.'>';
// echo $query_idealista;

 if ($totalRows_idealista > 0) { // Show if recordset not empty

$Content .=
"
<clients>

<client>

<aggregator>2dbc4d0862404c2b1820f38c26910a028632dd56</aggregator>

<code>" . $idealistaCustomerCode. "</code>

<secondhandListing>";

  do {

//SWITCH OPERACIÓN -> ESTATUS
switch($row_idealista['operacion_prop'])
{
  // case 7:
  // $idoperacion ='02';
  // $operacion = "alquiler";
  // $operacion_en = "rent";
  // $operacion_de = "mieten";
  // $operacion_fr = "embaucher";
  // break;
  case 11:
  $idoperacion ='02';
  $operacion = "alquiler";
  $operacion_en = "rent";
  $operacion_de = "mieten";
  $operacion_fr = "embaucher";
  $operacion_ru = "аренда";
  break;
  // case 5:
  // $idoperacion ='01';
  // $operacion = "venta";
  // $operacion_en = "sale";
  // $operacion_de = "verkauf";
  // $operacion_fr = "vente";
  // break;
  default:
  $idoperacion = '01';
  $operacion = "venta";
  $operacion_en = "sale";
  $operacion_de = "verkauf";
  $operacion_fr = "vente";
  $operacion_ru = "продажа";
}

//SWITCH TIPO
switch($row_idealista['tipo_prop']) {
  case 4://Piso/Apartmento
    $Itipo = 'Flat';
    $idtipo = '04';
    $tipo = "piso";
  break;
  case 7://Piso/Apartmento
    $Itipo = 'Flat';
    $idtipo = '04';
    $tipo = "piso";
  break;
  case 6://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 5://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '02';
    $tipo = "chalet";
  break;
  case 15://Casa/Chalet Individual
    $Itipo = 'Flat';
    $idtipo = '02';
    $tipo = "piso";
  break;
  case 8://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 3://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 17://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 10://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 16://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 21://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 22://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 23://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  case 53://Casa/Chalet Individual
  $Itipo = 'Premise';
   $idtipo = '01';
    $tipo = "local";
  break;
  case 12://Casa/Chalet Individual
   $Itipo = 'House';
  $idtipo = '01';
    $tipo = "chalet";
  break;
  // case 35://Casa/Chalet Individual
  //  $Itipo = 'House';
  // $idtipo = '01';
  //   $tipo = "chalet";
  // break;
  // case 46://Local comercial
  // $Itipo = 'Premise';
  //  $idtipo = '01';
  //   $tipo = "local";
  // break;
  case 9://Local comercial
  $Itipo = 'Premise';
   $idtipo = '01';
    $tipo = "local";
  break;
  case 26://Local comercial
  $Itipo = 'Premise';
   $idtipo = '01';
    $tipo = "local";
  break;
  case 20://Local comercial
  $Itipo = 'Premise';
   $idtipo = '01';
    $tipo = "local";
  break;
  // case 6://Local comercial
  // $Itipo = 'Premise';
  //  $idtipo = '01';
  //   $tipo = "local";
  // break;
  case 11://Piso/Apartmento
   $Itipo = 'Flat';
  $idtipo = '03';
    $tipo = "estudio";
  break;
  // case 19://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 2://Casa/Chalet Individual
  //  $Itipo = 'House';
  // $idtipo = '01';
  //   $tipo = "chalet";
  // break;
  // case 8://Casa/Chalet Individual
  //  $Itipo = 'House';
  // $idtipo = '01';
  //   $tipo = "chalet";
  // break;
  // case 20://Casa/Chalet Individual
  //  $Itipo = 'House';
  // $idtipo = '01';
  //   $tipo = "chalet";
  // break;
  // case 13://Casa/Chalet Individual
  //  $Itipo = 'House';
  // $idtipo = '01';
  //   $tipo = "chalet";
  // break;
  case 14://Casa/Chalet Individual
   $Itipo = 'Garage';
  $idtipo = '01';
    $tipo = "garage";
  break;
  // case 40://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 48://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  case 13://Piso/Apartmento
    $Itipo = 'Land';
    $idtipo = '00';
    $tipo = "terreno";
  break;
  // case 31://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 34://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 43://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 50://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 18://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '02';
  //   $tipo = "duplex";
  // break;
  // case 32://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 11://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  // case 41://Piso/Apartmento
  //   $Itipo = 'Flat';
  //   $idtipo = '04';
  //   $tipo = "piso";
  // break;
  default:
  $Itipo = 'Flat';
    $idtipo = '04';
    $tipo = "piso";
}

$lat = explode(',',$row_idealista['maplat']);

$lat1 = str_replace(' ', '', $lat[0]);

$lat2 = str_replace(' ', '', $lat[1]);

$direccion = explode(',',$row_idealista['direccion_prop']);

if($direccion[0]){
$calle = $direccion[0];
$diridealista = explode(',',$calle);
$diridealista1 = $diridealista[0];
$diridealista2 = $diridealista[1];
$diridealista3 = $diridealista[2];
}
else
{
$calle = "";
$diridealista = explode(',',$calle);
$diridealista1 = $diridealista[0];
$diridealista2 =  str_replace(' ', '', $diridealista[1]);
$diridealista3 =  substr(str_replace(' ', '', $diridealista[2]) , 0, 5);
};




$postalCode =  str_replace(' ', '', $direccion[2]);

$streetNumber = str_replace(' ', '', $direccion[1]);

$cityCode = str_replace(' ', '', $direccion[3]);

$cityCodeType = "";

if($row_idealista['energ'] == 'X' or $row_idealista['energ'] == NULL)  { $energyRating = 0;} else { $energyRating = $row_idealista['energ']; }

$energyPerformance;

$elevator = ($row_idealista['ascen'] == '')?'':'t';

$buildingAntiquity = ($row_idealista['construccion_prop'] != '')?$row_idealista['construccion_prop']:'';

if ($row_idealista['vend']==1) {$listado="newbuildListing";} else {$listado="secondhandListing";}



$Content .="

    <property>

        <code>".$row_idealista['id']."</code>

        <reference>".$row_idealista['ref']."</reference>

        <scope>1</scope>

        <address>
            <visibility>3</visibility>
            <country></country>
            <streetName>".str_replace('&', '', $diridealista1)."</streetName>
            <streetNumber></streetNumber>
            <floor>".$row_idealista['plantas_prop']."</floor>
            <block></block>
            <stair></stair>
            <door></door>
            <postalcode>".$diridealista3."</postalcode>
            <cityCode></cityCode>
            <cityName><![CDATA[".$row_idealista['sreg']."]]></cityName>
            <urbanization></urbanization>
            <coordinates>
                <precision>2</precision>
                <latitude>".$lat1."</latitude>
                <longitude>".$lat2."</longitude>
            </coordinates>
        </address>

        <contact>
            <name>".$idealistaContactName."</name>
            <email>".$idealistaContactEmail."</email>
            <phones>
                <phone>
                    <prefix>".$idealistaContactPrimaryPhonePrefix."</prefix>
                    <number>".$idealistaContactPrimaryPhoneNumber."</number>
                    <availabilityHour>7</availabilityHour>
                </phone>
            </phones>

        </contact>

        <features type='".$Itipo."'>

            <rooms>".$row_idealista['bed']."</rooms>
            <bathrooms>".$row_idealista['fbth']."</bathrooms>";

            if($Itipo == 'Land')
            {
                $Content .= "<plotArea>".$row_idealista['plot']."</plotArea>";
                $Content .= "<buildableArea>".$row_idealista['plot']."</buildableArea>";
            }
            else
                $Content .= "<constructedArea>".$row_idealista['floor']."</constructedArea>";

            if ($row_idealista['floor']) {
                  $Content .= "<usableArea>".$row_idealista['floor']."</usableArea>";
            }


            switch ($row_idealista['orientacion_prop']) {
                case 'o-ne':
                    $orientacion = 2;
                break;

                case 'o-e':
                case 'o-eo':
                    $orientacion = 3;
                break;

                case 'o-se':
                    $orientacion = 4;
                break;

                case 'o-s':
                    $orientacion = 5;
                break;

                case 'o-so':
                    $orientacion = 6;
                break;

                case 'o-o':
                    $orientacion = 7;
                break;

                case 'o-no':
                    $orientacion = 8;
                break;

                case 'o-n':
                case 'o-ns':
                    $orientacion = 1;
                break;

                default:
                    $orientacion = 0;
                break;
            }

            $Content .= "<orientation>".$orientacion."</orientation>";

            $foundPool = false;
            if ($row_idealista['pisc']) {
                $foundPool = true;
                $Content .= "<pool>1</pool>";
            }

            if ($row_idealista['ascen']) {
                $Content .= "<elevator>1</elevator>";
            }

            if ($row_idealista['tipo_prop'] == '11') {
                $Content .= "<studio>1</studio>";
            }



            // if ($row_idealista['m2_balcon_prop']) {
            //     $terraza_balcon = $row_idealista['m2_balcon_prop'];
            //     $Content .= "<balconyNumber>".$terraza_balcon."</balconyNumber>";
            // }

            if ($row_idealista['m2_balcon_prop']) {
                $terraza_balcon = $row_idealista['m2_balcon_prop'];
                $Content .= "<terraceArea>".$terraza_balcon."</terraceArea>";
            }

            
            $query_rsproperties_features = "
            SELECT properties_features.id_feat,
                properties_features.feature_es_feat
            FROM properties_property_feature INNER JOIN properties_features ON properties_property_feature.feature = properties_features.id_feat
            WHERE properties_property_feature.property = '".$row_idealista['id']."'
            ";
            $rsproperties_features = mysqli_query($inmoconn,$query_rsproperties_features) or die(mysqli_error());
            $row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
            $totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);
            if($totalRows_rsproperties_features > 0) {
                    $foundParking = false;
                    $foundEstado = false;
                do {
                    if($row_rsproperties_features['id_feat'] == '90') {
                        $Content .= "<handicappedAdapted>1</handicappedAdapted>";
                    }
                    if($row_rsproperties_features['id_feat'] == '62') {
                        $foundEstado = true;
                        $Content .= "<buildingType>2</buildingType>";
                    }
                    if($row_rsproperties_features['id_feat'] == '30') {
                        $Content .= "<conditionedAir>02</conditionedAir>";
                    }
                    if($row_rsproperties_features['id_feat'] == '78') {
                        $Content .= "<wardrobes>1</wardrobes>";
                    }
                    if($row_rsproperties_features['id_feat'] == '121') {
                        $Content .= "<elevator>1</elevator>";
                    }
                    if($row_rsproperties_features['id_feat'] == '13' || $row_rsproperties_features['id_feat'] == '75' || $row_rsproperties_features['id_feat'] == '98' || $row_rsproperties_features['id_feat'] == '36' || $row_rsproperties_features['id_feat'] == '69') {
                        if ($foundParking == false) {
                            $Content .= "<parkingSpacesInPrice>1</parkingSpacesInPrice>";
                        }
                        $foundParking = true;
                    }
                    if($row_rsproperties_features['id_feat'] == '26') {
                        $Content .= "<garden>1</garden>";
                    }
                    if($row_rsproperties_features['id_feat'] == '116' || $row_rsproperties_features['id_feat'] == '27' || $row_rsproperties_features['id_feat'] == '77' || $row_rsproperties_features['id_feat'] == '38') {
                        if ($foundPool == false) {
                            $Content .= "<pool>1</pool>";
                        }
                        $foundPool = true;
                    }
                    if($row_rsproperties_features['id_feat'] == '35') {
                        $Content .= "<storageRoom>1</storageRoom>";
                    }
                } while ($row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features));
                if($foundEstado == false) {
                    $Content .= "<buildingType>3</buildingType>";
                }
            }


$Content .= "
            <energyCertification>
                <rating>".$energyRating."</rating>
                <type>0</type>
            </energyCertification>

        </features>

        <operation type='".$operacion_en."'>
            <price>".$row_idealista['pr']."</price>
            <communityCosts>".$row_idealista['gastos_prop']."</communityCosts>
        </operation>

        <descriptions>

            <description>
                <language>1</language>
                <title>".$row_idealista['typ']." en ".$operacion." en ".$row_idealista['loc'].", ".$row_idealista['reg']."</title>
                <comment>".rip_tags(convertirAnicename(str_replace('"', '&quot;', str_replace('\'', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />',' ', str_replace('</p>',' </p>',$row_idealista['descr']))))))))))."</comment>
            </description>

            <description>
                <language>2</language>
                <title>".$row_idealista['typ2']." for ".$operacion_en." in ".$row_idealista['loc'].", ".$row_idealista['reg']."</title>
                <comment>".rip_tags(convertirAnicename(str_replace('"', '&quot;', str_replace('\'', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />',' ', str_replace('</p>',' </p>',$row_idealista['descr2']))))))))))."</comment>
            </description>

            <description>
                <language>3</language>
                <title>".$row_idealista['typ4']." pour ".$operacion_fr." dans ".$row_idealista['loc'].", ".$row_idealista['reg']."</title>
                <comment>".rip_tags(convertirAnicename(str_replace('"', '&quot;', str_replace('\'', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />',' ', str_replace('</p>',' </p>',$row_idealista['descr4']))))))))))."</comment>
            </description>

            <description>
                <language>4</language>
                <title>".$row_idealista['typ3']." zum ".$operacion_de." im ".$row_idealista['loc'].", ".$row_idealista['reg']."</title>
                <comment>".rip_tags(convertirAnicename(str_replace('"', '&quot;', str_replace('\'', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />',' ', str_replace('</p>',' </p>',$row_idealista['descr3']))))))))))."</comment>
            </description>

            <description>
                <language>8</language>
                <title>".$row_idealista['typ5']." для ".$operacion_ru." в ".$row_idealista['loc'].", ".$row_idealista['reg']."</title>
                <comment>".rip_tags(convertirAnicename(str_replace('"', '&quot;', str_replace('\'', '&apos;', str_replace('&', '&amp;', str_replace('>', '&gt;', str_replace('<', '&lt;', strip_tags(str_replace('<br />',' ', str_replace('</p>',' </p>',$row_idealista['descr5']))))))))))."</comment>
            </description>

        </descriptions>

        <links>

            <link>
                <language>1</language>
                <comment>".$row_idealista['typ']." en ".$operacion." en ".$row_idealista['loc'].", ".$row_idealista['reg']."</comment>
                <url>https://". $_SERVER['HTTP_HOST']."". propURL($row_idealista['id'], 'es')."</url>
            </link>

            <link>
                <language>2</language>
                <comment>".$row_idealista['typ2']." for ".$operacion_en." in ".$row_idealista['loc'].", ".$row_idealista['reg']."</comment>
                <url>https://". $_SERVER['HTTP_HOST']."". propURL($row_idealista['id'], 'en')."</url>
            </link>

            <link>
                <language>3</language>
                <comment>".$row_idealista['typ4']." pour ".$operacion_fr." dans ".$row_idealista['loc'].", ".$row_idealista['reg']."</comment>
                <url>https://". $_SERVER['HTTP_HOST']."". propURL($row_idealista['id'], 'fr')."</url>
            </link>

            <link>
                <language>4</language>
                <comment>".$row_idealista['typ3']." zum ".$operacion_de." in ".$row_idealista['loc'].", ".$row_idealista['reg']."</comment>
                <url>https://". $_SERVER['HTTP_HOST']."". propURL($row_idealista['id'], 'de')."</url>
            </link>

            <link>
                <language>8</language>
                <comment>".$row_idealista['typ5']." для ".$operacion_ru." в ".$row_idealista['loc'].", ".$row_idealista['reg']."</comment>
                <url>https://". $_SERVER['HTTP_HOST']."". propURL($row_idealista['id'], 'ru')."</url>
            </link>

        </links>

        <images>";

$i=0;

$query_idealista_galeria = "SELECT properties_images.image_img FROM properties_images WHERE properties_images.property_img=".$row_idealista['id']." ORDER BY properties_images.order_img ASC";
$idealista_galeria = mysqli_query($inmoconn,$query_idealista_galeria) or die(mysqli_error());
$row_idealista_galeria = mysqli_fetch_assoc($idealista_galeria);
$totalRows_idealista_galeria = mysqli_num_rows($idealista_galeria);
if ($totalRows_idealista_galeria > 0) { do {


if ($row_idealista_galeria['image_img']) { $i++;

if(preg_match('/https?:\/\//', $row_idealista_galeria['image_img'])) {

            $Content .= "
            <image>
                <code>0</code>
                <url><![CDATA[".$row_idealista_galeria['image_img']."]]></url>
            </image>";

}
else {
            $Content .= "
            <image>
                <code>0</code>
                <url>https://".$_SERVER['HTTP_HOST']."/media/images/properties/".$row_idealista_galeria['image_img']."</url>
            </image>";
    }
} else {

             $Content .= "";

}

} while (($row_idealista_galeria = mysqli_fetch_assoc($idealista_galeria)) && ($i<20));


}

$resto = 20-$totalRows_idealista_galeria;

$k = 1;

while ( $k <= $resto) {
            $Content .= "";
$k++;
}

mysqli_free_result($idealista_galeria);

$Content .="</images>

    </property>


";

} while ($row_idealista = mysqli_fetch_assoc($idealista));
} // Show if recordset not empty
mysqli_free_result($idealista);

$Content .="</secondhandListing></client></clients>";

echo $Content;
// die();

$newfile=$idealistaFILEname . ".xml";
$file = fopen ($newfile, "w");
fwrite($file, $Content);
fclose ($file);

include "inc/SFTP.php";

$ftp = new SFTP($idealistaFTP, $idealistaFTPuser, $idealistaFTPpass);

if($ftp->connect()) {

  if($ftp->put($idealistaFILEname . ".xml", $idealistaFILEname . ".xml")) {

    $ftp->chmod(0777, $idealistaFILEname . ".xml");

    // echo "ok";

  }
}
?>
