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

 if ($langVal == 'da') {
  setlocale(LC_ALL, 'da_DK.UTF-8');
 }
 if ($langVal == 'de') {
  setlocale(LC_ALL, 'de_DE.UTF-8');
 }
 if ($langVal == 'el') {
  setlocale(LC_ALL, 'el_GR.UTF-8');
 }
 if ($langVal == 'en') {
  setlocale(LC_ALL, 'en_GB.UTF-8');
 }
 if ($langVal == 'es') {
  setlocale(LC_ALL, 'es_ES.UTF-8');
 }
 if ($langVal == 'fi') {
  setlocale(LC_ALL, 'fi_FI.UTF-8');
 }
 if ($langVal == 'fr') {
  setlocale(LC_ALL, 'fr_FR.UTF-8');
 }
 if ($langVal == 'is') {
  setlocale(LC_ALL, 'is_IS.UTF-8');
 }
 if ($langVal == 'it') {
  setlocale(LC_ALL, 'it_IT.UTF-8');
 }
 if ($langVal == 'nl') {
  setlocale(LC_ALL, 'nl_NL.UTF-8');
 }
 if ($langVal == 'no') {
  setlocale(LC_ALL, 'no_NO.UTF-8');
 }
 if ($langVal == 'pt') {
  setlocale(LC_ALL, 'pt_PT.UTF-8');
 }
 if ($langVal == 'ru') {
  setlocale(LC_ALL, 'ru_RU.UTF-8');
 }
 if ($langVal == 'se') {
  setlocale(LC_ALL, 'de_CH.UTF-8');
 }
 if ($langVal == 'zh') {
  setlocale(LC_ALL, 'zh_CN.UTF-8');
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


if ($langVal == $language) {
    $urlstart = '/';
} else {
    $urlstart = '/'.$langVal.'/';
}


$url = 'https://'.$_SERVER['HTTP_HOST'].''.$urlstart.''.$urlStr['promociones'][$_GET['lang']].'/'.$property[0]['id_nws'].'/'.clean($property[0]['titulo']).'/';

  ?>

<tr>
    <td style="padding: 0px 30px 20px;">
        <h3 style="font-size: 28px; color: #222; text-align: center;">🏗️ <?php echo $langStr["Promoción destacada"]; ?></h3>
        <?php if ($property[0]['img'] != ''): ?>
            <?php echo showThumbnail($property[0]['img'], '/media/images/news/', 574, 250, $property[0]['titulo'], 'img-news', 'width: 100%;  max-width: 100%; border-radius: 8px; margin-bottom: 10px;'); ?>
        <?php endif ?>
        <h4 style="font-size: 16px; color: #000; text-align: center; margin-top: 10px;">🌴 <?php echo $property[0]['titulo'] ?></h4>
        <p style="font-size: 16px; color: #555; margin: 10px 0; line-height: 1.6em;">
            <?php echo preg_replace('/((\b\w+\b.*?){38}).*$/s','$1',strip_tags($property[0]['contenido'])); ?>
        </p>
        <p style="margin-top: 30px;">
            <a href="<?php echo $url  ?>" style="background-color: {COLOR}; color: #fff; padding: 15px 20px; text-decoration: none; border-radius: 223px; display: inline-block; border-radius: 23px; display: block; max-width: 100%; text-align: center; font-size: 16px;">🔍 <?php echo $langStr["Ver viviendas de la promoción"]; ?></a>
        </p>
    </td>
</tr>
