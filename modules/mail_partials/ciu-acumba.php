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
         categoria_nws,
         (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img

     FROM news

     WHERE id_nws = ".simpleSanitize(($idVal))."

     LIMIT 1

 ");

 $zonas = getRecords("
     SELECT
         category_".$langVal."_ct as titulo
     FROM news_categories
     WHERE id_ct = '" . simpleSanitize(($property[0]['categoria_nws'])) . "'
     ");


if ($langVal == $language) {
    $urlstart = '/';
} else {
    $urlstart = '/'.$langVal.'/';
}

$url = 'https://'.$_SERVER['HTTP_HOST'].''.$urlstart.''.clean($zonas[0]['titulo']).'/'.clean($property[0]['titulo']).'.html';

?>


<tr>
    <td style="padding: 20px 30px;">
        <h3 style="font-size: 28px; color: #000; text-align: center;">📍 <?php echo $langStr["¿Conoces esta zona?"]; ?></h3>
        <?php if ($property[0]['img'] != ''): ?>
            <?php echo showThumbnail($property[0]['img'], '/media/images/news/', 574, 250, $property[0]['titulo'], 'img-news', 'width: 100%;  max-width: 100%; border-radius: 8px; margin-top: 10px;'); ?>
        <?php endif ?>
        <h4 style="font-size: 16px; color: #333; margin-top: 15px; text-align: center; line-height: 1.6em;"><?php echo $property[0]['titulo'] ?></h4>
        <p style="font-size: 16px; color: #555; margin: 5px 0 10px; text-align: center;">
            <?php echo preg_replace('/((\b\w+\b.*?){30}).*$/s','$1',strip_tags($property[0]['contenido'])); ?>
        </p>
        <p style="text-align: center;">
            <a href="<?php echo $url  ?>" style="text-align: center; color: #000; font-size: 16px; text-decoration: none;">👉 <?php echo $langStr["Ver más sobre"] ?> <?php echo $property[0]['titulo'] ?></a>
        </p>
    </td>
</tr>