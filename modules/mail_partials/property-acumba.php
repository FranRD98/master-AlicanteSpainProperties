<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$langVal.".php");

// Cargamos las urls
include_once($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

$property = getRecords("

SELECT

    properties_loc1.name_".$langVal."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$langVal."_loc2 IS NOT NULL THEN properties_loc2.name_".$langVal."_loc2 ELSE province1.name_".$langVal."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$langVal."_loc3 IS NOT NULL THEN properties_loc3.name_".$langVal."_loc3 ELSE areas1.name_".$langVal."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$langVal."_loc4 IS NOT NULL THEN properties_loc4.name_".$langVal."_loc4 ELSE towns.name_".$langVal."_loc4  END AS town,
    CASE WHEN properties_types.types_".$langVal."_typ IS NOT NULL THEN properties_types.types_".$langVal."_typ ELSE types.types_".$langVal."_typ END AS type,
    properties_properties.descripcion_".$langVal."_prop  as descr,
    properties_status.status_".$langVal."_sta as sale,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.precio_desde_prop,
    properties_properties.watermark_prop,
    (SELECT pool_".$langVal."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop


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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE  id_prop = '".simpleSanitize(($idVal))."'

GROUP BY id_prop

LIMIT 1

");

if (!function_exists('myTruncate')) {
function myTruncate($string, $limit, $break=".", $pad="...")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}
}

if (!function_exists('truncWords')) {
  function truncWords($phrase, $max_words) {
     $phrase_array = explode(' ',$phrase);
     if(count($phrase_array) > $max_words && $max_words > 0)
        $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
     return strip_tags($phrase);
  }
}


if ($langVal == $language) {
    $urlstart = '/';
} else {
    $urlstart = '/'.$langVal.'/';
}

// echo "<pre>";
// print_r($property);
// echo "</pre>";

// header('Content-type: text/html; charset=UTF-8', true);

 ?>
<?php if ($property[0]['id_prop'] != ''): ?>
 <table style="width: 100%; background: #fff;">
     <tr>
         <td style="padding: 1px;">
              <table style="width: 100%; border: 0px solid #fff; background: #fff;">
                  <tr style="border: 0px solid #fff;">
                      <td style="vertical-align: top; width: 100%; text-align: left; overflow-x: hidden">
                          <h2 style="color: #000;font-family: 'Ubuntu', sans-serif;font-size: 24px; font-weight: 400; margin-bottom: 10px; line-height: 1.6; padding: 5px;">
                              <a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo propURL($property[0]['id_prop'], $langVal); ?>" style="display: block;  text-decoration: none; color: #000;">
                                  <?php echo $property[0]['area'] ?> - <?php echo $property[0]['province'] ?>
                              </a>
                            </h2>
                        </td>
                      </tr>
                    </table>
              <table style="width: 100%; border: 0px solid #e5e5e5; background: #fff;">
                  <tr style="border: 1px solid #dfdfdf;">
                      <td style="vertical-align: top; width: 100%; text-align: left; overflow-x: hidden">
                          <a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo propURL($property[0]['id_prop'], $langVal); ?>">
                            <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$property[0]['id_img'] .'_md.jpg')) { ?>
                                <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/media/images/properties/thumbnails/<?php echo $property[0]['id_img'] ?>_md.jpg"  alt="" style="width:574px;" width="574">
                            <?php } else { ?>
                                <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/media/images/website/no-image.png" alt="" style="width:574px;" width="574">
                            <?php } ?>
                          </a>
                        </td>
                      </tr>
                      <tr style="border: 1px solid #dfdfdf;">
                        <td style="padding:30px; color:#222222;border: 0 !important;">
                          <div class="porta-text">
                            <!-- <h2 style="color: {COLOR};font-family: 'Ubuntu', sans-serif;font-size: 24px; font-weight: 400; margin-bottom: 10px; line-height: 1.6;">
                              <a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo propURL($property[0]['id_prop'], $langVal); ?>" style="display: block;  text-decoration: none; color: {COLOR};">
                                  <?php echo $property[0]['area'] ?> - <?php echo $property[0]['town'] ?>
                              </a>
                            </h2> -->
                            <h3 style="color: #777777;font-family: 'Ubuntu', sans-serif; font-size: 16px; font-weight: 400; margin-bottom:10px; line-height: 1.6;">
                                <?php echo $property[0]['type'] ?> - <?php echo $property[0]['sale'] ?>
                            </h3>
                            <p style="color: #000;font-family: 'Ubuntu', sans-serif;font-size: 18px; text-transform:uppercase; margin-top:0; margin-bottom:15px; line-height: 1.5; font-weight: bold;">
                                <?php echo $langStr["Ref "] ?>: <?php echo $property[0]['ref']; ?>
                            </p>
                            <p class="precio" style="color: {COLOR};font-family: 'Ubuntu', sans-serif; font-size: 32px; font-weight: bold; margin: 0 0 20px; line-height: normal; border: 0 !important;">
                                <?php if ($property[0]['precio_desde_prop'] == 1) { echo '<span style="font-size:14px;">' . $langStr["From"] . '</span>';} ?>
                                <?php if($property[0]['precio'] > 0) { ?>
                                    <?php if($property[0]['old_precio'] > 0) { ?>
                                        <del style="font-size: 14px; color: #f3001a; display: inline-block;"><?php echo number_format($property[0]['old_precio'],0, ',', '.'); ?>€</del>
                                    <?php } ?>
                                    <?php echo number_format($property[0]['precio'],0, ',', '.'); ?>€
                                <?php } else{ ?>
                                    <?php echo $langStr["Consultar"] ?>
                                <?php } ?>
                            </p>
                            <div style="margin-bottom: 15px; text-align: center;">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0 auto;">
                                <tr>
                              <?php if(number_format($property[0]['m2_prop'],0, ',', '.') > 0) { ?>
                                <td style="display:block; float:left;; text-align:center; margin-right:25px;">
                                  <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/includes/assets/img/icon-house.png" style="margin-bottom:10px;" alt="">
                                  <div style="text-align:center;"><?php echo number_format($property[0]['m2_prop'],0, ',', '.'); ?></div>
                                </td>
                              <?php } ?>
                              <?php if(number_format($property[0]['m2p_prop'],0, ',', '.') > 0) { ?>
                                <td style="display:block; float:left;; text-align:center; margin-right:25px;">
                                  <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/includes/assets/img/icon-plano.png" style="margin-bottom:10px;" alt="">
                                  <div style="text-align:center;"><?php echo number_format($property[0]['m2p_prop'],0, ',', '.'); ?></div>
                                </td>
                              <?php } ?>
                              <?php if(number_format($property[0]['habitaciones_prop'],0, ',', '.') > 0) { ?>
                                <td style="display:block; float:left;; text-align:center; margin-right:25px;">
                                  <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/includes/assets/img/icon-bed.png" style="margin-bottom:10px;" alt="">
                                  <div style="text-align:center;"><?php echo number_format($property[0]['habitaciones_prop'],0, ',', '.'); ?></div>
                                </td>
                              <?php } ?>
                              <?php if(number_format($property[0]['aseos_prop'],0, ',', '.') > 0) { ?>
                                <td style="display:block; float:left;; text-align:center; margin-right:25px;">
                                  <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/includes/assets/img/icon-bath.png" style="margin-bottom:10px;" alt="">
                                  <div style="text-align:center;"><?php echo number_format($property[0]['aseos_prop'],0, ',', '.'); ?></div>
                                </td>
                              <?php } ?>
                              <?php if(number_format($property[0]['aseos2_prop'],0, ',', '.') > 0) { ?>
                                <td style="display:block; float:left;; text-align:center; margin-right:25px;">
                                  <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/includes/assets/img/icon-toilet.png" style="margin-bottom:10px;" alt="">
                                  <div style="text-align:center;"><?php echo number_format($property[0]['aseos2_prop'],0, ',', '.'); ?></div>
                                </td>
                              <?php } ?>
                              <?php if($property[0]['piscina_prop'] != '') { ?>
                                <td style="display:block; float:left;; text-align:center; margin-right:25px;">
                                  <img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/includes/assets/img/icon-pool.png" style="margin-bottom:10px;" alt="">
                                  <div style="text-align:center;"><?php echo $property[0]['piscina_prop']; ?></div>
                                </td>
                              <?php } ?>
                                </tr>
                              </table>

                            </div>
                            <p style="color: #312c2c;font-family: 'Ubuntu', sans-serif;font-size: 16px;font-weight: 400; margin: 0 !important; padding: 0; line-height: 25px;">
                                <?php echo truncWords($property[0]['descr'],40); ?>
                            </p>
                          </div>
                      </td>
                  </tr>
              </table>
         </td>
     </tr>
 </table>
<!-- <br> -->
<?php endif ?>
