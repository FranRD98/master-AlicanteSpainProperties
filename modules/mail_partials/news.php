<?php
 require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

 require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

 require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/xml-manager/class.xml.php');

 require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

 include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

 foreach ($urlStr as $key => $urls) {
     foreach ($urls as $langval => $urlval) {
         if ($langval == $_GET['lang']) {
             $urlStr[$key]['url'] = $urlval;
             $urlStr[$urlStr[$key][$langval]]['master'] = $key;
         }
     }
 }

 // error_reporting(E_ALL);
 // ini_set("display_errors", 1);


 $property = getRecords("

     SELECT

         news.id_nws,
         news.title_".$langVal."_nws as titulo,
         news.content_".$langVal."_nws as contenido,
         news.date_nws,
         (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img

     FROM news

     WHERE id_nws = ".simpleSanitize(($idVal))."

     LIMIT 1

 ");


if ($langVal == $langValuage) {
    $urlstart = '/';
} else {
    $urlstart = '/'.$langVal.'/';
}

  ?>



  <table style="width: 100%">
      <tr>
          <td style="background: #ccc; padding: 1px;">
               <table style="background: #fff; width: 100%;">
                   <tr>
                       <?php if ($property[0]['img'] != '') { ?>
                       <td style="padding: 5px; vertical-align: top; width: 40%;">
                             <a style="display: block;  text-decoration: none;" href="http://<?php echo $_SERVER['HTTP_HOST'] ?><?php echo $urlstart; ?><?php echo $urlStr['news'][$_GET['lang']] ?>/<?php echo $property[0]['id_nws'] ?>/<?php echo clean($property[0]['titulo']); ?>/">
                                <?php echo showThumbnail($property[0]['img'], '/media/images/news/', 250, 180); ?>
                             </a>
                       </td>
                       <?php } ?>
                       <td style="padding:5px; vertical-align: top; text-align: left;">
                         <h2 style="color: {COLOR};font-family: Arial;font-size: 18px;font-weight: 600; margin: 0 0 10px; padding: 0;">
                             <a style="display: block;  text-decoration: none; font-style: 18px;" href="http://<?php echo $_SERVER['HTTP_HOST'] ?><?php echo $urlstart; ?><?php echo $urlStr['news'][$_GET['lang']] ?>/<?php echo $property[0]['id_nws'] ?>/<?php echo clean($property[0]['titulo']); ?>/">
                                <?php echo $property[0]['titulo'] ?>
                             </a>
                         </h2>
                         <p style="color: #7b7a7a;font-family: Arial;font-size: 12px;font-weight: 300; margin: 0;"><?php echo preg_replace('/((\b\w+\b.*?){38}).*$/s','$1',strip_tags($property[0]['contenido'])); ?>...</p>
                       </td>
                   </tr>
               </table>
          </td>
      </tr>
  </table>
