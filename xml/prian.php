<?php
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );
include( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');
 ?>
<?php
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


$query_rsprian = "SELECT

properties_properties.id_prop AS id,

properties_properties.referencia_prop as ref,

properties_properties.preci_reducidoo_prop AS pr,

properties_properties.precio_prop AS prb,

properties_loc1.name_ru_loc1 AS ctr,

properties_loc1.id_loc1 AS idctr,

(SELECT nombre_ru_cts FROM prian_cities WHERE id_cts = prian_ciudad_prop) AS loc,

CASE WHEN properties_loc2.name_ru_loc2 IS NOT NULL THEN properties_loc2.name_ru_loc2 ELSE province1.name_ru_loc2  END AS reg,

CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS idreg,

CASE WHEN properties_loc3.name_ru_loc3 IS NOT NULL THEN properties_loc3.name_ru_loc3 ELSE areas1.name_ru_loc3  END AS sreg,

CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS idsreg,

CASE WHEN properties_types.types_ru_typ IS NOT NULL THEN properties_types.types_ru_typ ELSE types.types_ru_typ END AS type,

CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS typid,

CONCAT('/media/images/properties/',(SELECT properties_images.image_img FROM properties_images WHERE properties_properties.id_prop = properties_images.property_img ORDER BY properties_images.order_img ASC LIMIT 1)) as img,

properties_properties.title_ru_prop as mtTit,

properties_properties.description_ru_prop as mtDes,

properties_properties.keywords_ru_prop as mtKey,

properties_properties.descripcion_ru_prop as descr,

properties_status.status_ru_sta AS sta,

properties_types.types_ru_typ AS typ,

properties_properties.title_ru_prop as mtTit2,

properties_properties.description_ru_prop as mtDes2,

properties_properties.keywords_ru_prop as mtKey2,

properties_properties.descripcion_ru_prop as descr2,

properties_status.status_ru_sta AS sta2,

properties_types.types_ru_typ AS typ2,

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

m2_prop as floor,

m2_parcela_prop as plot,

habitaciones_prop as bed,

aseos_prop as fbth,

piscina_prop as pisc,

ascensor_prop as ascen,

direccion_gp_prop as mapdir,

lat_long_gp_prop as maplat,

vendido_prop as vend,

alquilado_prop as alq,

reservado_prop as res,

nuevo_prop as new,


prian_tipo_prop,
prian_pais_prop,
prian_region_prop,
prian_ciudad_prop,
operacion_prop,

tipo_prop,

direccion_prop,

construccion_prop


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

    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img

    INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

 WHERE

 properties_properties.activado_prop = 1 AND export_prian_prop = 1 AND vendido_prop = 0 AND vendido_tag_prop = 0

 AND prian_tipo_prop != '0'
 AND prian_pais_prop != '0'
 AND prian_region_prop != '0'
 AND prian_ciudad_prop != '0'







 GROUP BY properties_properties.id_prop


 ";
$rsprian = mysqli_query($inmoconn,$query_rsprian) or die(mysqli_error());
$row_rsprian = mysqli_fetch_assoc($rsprian);
$totalRows_rsprian = mysqli_num_rows($rsprian);




header('Content-type: text/xml; charset=UTF-8', true);
echo '<?xml version="1.0" encoding="UTF-8"?'.'>';
?>
<root>
  <objects>
    <?php
if($totalRows_rsprian >0) {
do { ?>

    <object>
      <id><?php echo $row_rsprian['ref'] ?></id>
      <language_id>1</language_id>
      <object_id><?php echo $row_rsprian['prian_tipo_prop'];?></object_id>
      <type_id><?php if($row_rsprian['operacion_prop']==3 || $row_rsprian['operacion_prop']== 4) {echo '2';} else { echo '1';} ?></type_id>
        <object_status><?php if($row_rsprian['operacion_prop']==3 || $row_rsprian['operacion_prop']== 4) {echo '125';} else {echo '121';} ?></object_status>
      <country_id><?php echo $row_rsprian['prian_pais_prop'] ;?></country_id>
      <region_id><?php echo $row_rsprian['prian_region_prop'] ;?></region_id>
      <district_id><?php echo $row_rsprian['prian_ciudad_prop'] ;?></district_id>
      <district><?php echo $row_rsprian['loc']; ?></district>
      <longitude>
        <?php
        $long = $lat = '';
        if(isset($row_rsprian['maplat']))
          list($long, $lat) = explode(',', $row_rsprian['maplat']);
        echo $lat; 
        ?>
      </longitude>
      <latitude><?php echo $long; ?></latitude>
      <currency_id>2</currency_id>
      <?php if ($row_rsprian['operacion_prop'] == 1 && $row_rsprian['operacion_prop'] == 2) { ?>
            <price><?php echo number_format($row_rsprian['pr'],0,'','') ?></price>
      <?php } else { ?>
            <price><?php echo number_format($row_rsprian['pr'],0,'','') ?></price>
      <?php } ?>
      <price_per_meter></price_per_meter>
      <price_day></price_day>
      <?php if ($row_rsprian['operacion_prop'] == 3) { ?>
      <price_week><?php echo number_format($row_rsprian['pr'],0,'','') ?></price_week>
      <?php } else { ?>
      <price_week></price_week>
      <?php } ?>
      <?php if ($row_rsprian['operacion_prop'] == 4) { ?>
      <price_month><?php echo number_format($row_rsprian['pr'],0,'','') ?></price_month>
      <?php } else { ?>
      <price_month></price_month>
      <?php } ?>
      <not_show_price></not_show_price>
      <rooms><?php if($row_rsprian['bed']==0) {echo '';} else {echo $row_rsprian['bed']+1;} ?></rooms>
      <bedrooms><?php if($row_rsprian['bed']==0) {echo '';} else {echo $row_rsprian['bed'];} ?></bedrooms>
      <bathrooms><?php if($row_rsprian['fbth']==0) {echo '';} else {echo $row_rsprian['fbth'];} ?></bathrooms>
      <square><?php echo number_format($row_rsprian['floor'],0,'','') ?></square>
      <square_land><?php if(number_format($row_rsprian['plot'],0,'','')==0) {echo '';} else {echo number_format($row_rsprian['plot'],0,'','');} ?></square_land>
      <square_land_unit>129</square_land_unit>
      <floor></floor>
      <total_floor></total_floor>
      <building_type>
        <?php
switch ($row_rsprian['vend']) {
    case 1:
        echo "117";
        break;
    default:
       echo "119";
}
?>
      </building_type>
      <building_date><?php echo $row_rsprian['construccion_prop'];?></building_date>
      <specialtxt><?php echo $row_rsprian['type'].' в '.$row_rsprian['loc']; ?></specialtxt>
      <description>
        <![CDATA[ <?php echo strip_tags(preg_replace('/&/', '&amp;', $row_rsprian['descr'])); ?> ]]>
      </description>
      <properties>

        <?php if ($row_rsprian['pisc']){echo "<property>
          <property_id>22</property_id>
          <property_value_enum>24</property_value_enum>
        </property>"; }?>

         <?php if ($row_rsprian['ascen']){echo "<property>
          <property_id>22</property_id>
          <property_value_enum>30</property_value_enum>
        </property>"; }?>
      </properties>
      <images>
        <?php

$query_rsImages = "SELECT  properties_images.image_img as img, alt_ru_img as alt FROM properties_images WHERE property_img = ".$row_rsprian['id']." ORDER BY order_img ASC LIMIT 0, 10";
$rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
$row_rsImages = mysqli_fetch_assoc($rsImages);
$totalRows_rsImages = mysqli_num_rows($rsImages);
$i = 0;
if($totalRows_rsImages >0) {
?>
        <?php do { ?>

<?php if(preg_match('/https?:\/\//', $row_rsImages['img'])) { ?>

<image>
<filename><?php echo $row_rsImages['img']; ?></filename>
<iorder><?php echo $i++; ?></iorder>
</image>

<?php } else { ?>

<image>
<filename>http://<?php echo $_SERVER['HTTP_HOST'] ?>/media/images/properties/<?php echo $row_rsImages['img'] ?></filename>
<iorder><?php echo $i++; ?></iorder>
</image>

<?php } ?>


        <?php
} while ($row_rsImages = mysqli_fetch_assoc($rsImages));
}
?>
      </images>
    <videos>
      <?php
      
      $query_rsVideos = "SELECT video_vid, id_vid FROM  properties_videos WHERE  property_vid = '".$row_rsprian['id']."' ORDER BY order_vid ASC LIMIT 0, 10";
      $rsVideos = mysqli_query($inmoconn,$query_rsVideos) or die(mysqli_error());
      $row_rsVideos = mysqli_fetch_assoc($rsVideos);
      $totalRows_rsVideos = mysqli_num_rows($rsVideos);
      $i = 0;
      if($totalRows_rsVideos >0) {
      do {
          if ($row_rsVideos['video_vid'] != '') {
              preg_match_all('/<iframe[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $row_rsVideos['video_vid'], $result);
      ?>
              <video>
                <filename><?php echo str_replace("embed/","watch?v=", str_replace("?rel=0","", $result['src'][0])) ?></filename>
                <middle_filename></middle_filename>
              </video>
      <?php
          }
      } while ($row_rsVideos = mysqli_fetch_assoc($rsVideos));
      }
      ?>
    </videos>
    </object>
    <?php } while ($row_rsprian = mysqli_fetch_assoc($rsprian));
}?>
  </objects>
</root>
<?php
mysqli_free_result($rsprian);
?>
