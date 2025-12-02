<?php

function decryptIt($encrypted, $encryptionKey = 'DLusjkq6kkzRUbY7TVc7YH2RcT2')
{
    $ciphering = "AES-128-CTR";
    $options = 0;

    $encryption_iv = substr(hash('sha256', $_SERVER['HTTP_HOST']), 0, 16);
    $encryption_key = substr(hash('sha256', $encryptionKey), 0, 16);

    // Revert Base64 URL-safe to standard
    $encrypted = strtr($encrypted, '-_', '+/');
    $encrypted = base64_decode($encrypted);

    return openssl_decrypt($encrypted, $ciphering, $encryption_key, $options, $encryption_iv);
}

$tokens[1] = decryptIt($tokens[1]);

$pages = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.content_".$lang."_nws as contenido,
        news.titlew_".$lang."_nws as titulow,
        news.description_".$lang."_nws as contenidow,
        news.keywords_".$lang."_nws as keywords,
        news.date_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img

    FROM news

    WHERE  type_nws = 2

    AND id_nws IN (".simpleSanitize(($numpag)).")

    ORDER BY news.id_nws ASC
");


if (isset($pages[0]['titulow']) && $pages[0]['titulow'] != '') {
    $title = $pages[0]['titulow'];
} else {
    if(isset($pages[0]['titulo']))
        $title = $pages[0]['titulo'];
}

if (!isset($title) || $title == '') {
    $title = $metaTitleDefault['es'];
}


$title = trim(strip_tags($title));

$smarty->assign("metaTitle", $title);

if (isset($pages[0]['contenidow']) && $pages[0]['contenidow'] != '') {
    $description = $pages[0]['contenidow'];
} else {
    if(isset($pages[0]['contenido']))
        $description = $pages[0]['contenido'];
}

if (!isset($description) || $description == '') {
    $description = $metaDescriptionDefault['es'];
}
$description = trim(strip_tags($description));
$smarty->assign("metaDescription", $description);

if(isset($pages[0]['keywords']))
    $smarty->assign("metaKeywords", trim(strip_tags($pages[0]['keywords'])));

$url = 'https://' . $_SERVER['HTTP_HOST'] . '' . $_SERVER['REQUEST_URI'];

$smarty->assign("metaURL", $url);
if(isset($pages[0]['img'])){
    if (preg_match('/https?:\/\//', $pages[0]['img'])) {
        $img = $pages[0]['img'];
    } else {
        $img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/' . $pages[0]['img'];
    }
}

if (!isset($img) || $img == 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/news/') {
    $img = 'https://' . $_SERVER['HTTP_HOST'] . '/media/images/website/no-image.png';
}

$smarty->assign("metaImage", $img);

foreach ($pages as $key => $page) {
    $text = "";
    $images = "";
    $videos = "";

    $images = getRecords("
        SELECT imagen_img as image_img, alt_".$lang."_img as alt FROM news_fotos WHERE noticia_img = '".$page["id_nws"]."' ORDER BY orden_img
    ");

    $videos = getRecords("
        SELECT video_vid FROM news_videos WHERE news_vid = '".$page["id_nws"]."' ORDER BY order_vid
    ");
    $matches = array();

    preg_match_all('/{image}|{image-left}|{image-right}|{image-pan}/', (string)$page['contenido'], $matches);

    $text = (string)$page['contenido'];


    if(!empty($matches[0])){
        if (count($matches[0]) > 0) {
            for ($i=0; $i < count($matches[0]); $i++) {

                switch ($matches[0][$i]) {
                    case '{image-right}':
                        $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 350, 200, $page['titulo'], 'img-right');
                    break;

                    case '{image-pan}':
                        $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 1170, 350, $page['titulo'], 'img-pan');
                    break;

                    case '{image-left}':
                        $img = showThumbnail($images[($i)]['image_img'], '/media/images/news/', 350, 200, $page['titulo'], 'img-left');
                    break;

                    default:
                        $img = '<img src="/media/images/news/'.$images[($i)]["image_img"].'" class="img-auto" alt="'.$images[($i)]["alt"].'" />';
                    break;
                }

                $text = preg_replace('/'.$matches[0][$i].'/', $img, $text, 1);
            }
        }
    }

    $text = str_replace('table table-striped table-bordered', 'cms-table', $text);

    if($key == 0){
        $smarty->assign("images", $images);
        $smarty->assign("videos", $videos);
        $smarty->assign("pagetext", $text);
    } else {
        $pages[$key]['images'] = $images;
        $pages[$key]['videos'] = $videos;
        $pages[$key]['contenido'] = $text;
    }
}

$smarty->assign("pages", $pages);


$datos = getRecords("

    SELECT properties_owner.nombre_pro,
        properties_owner.apellidos_pro,
        properties_owner.id_pro,
        properties_owner.telefono_fijo_pro,
        properties_owner.telefono_movil_pro,
        properties_owner.email_pro,
        properties_properties.inserted_xml_prop,
        properties_properties.referencia_prop,
        properties_properties.id_prop,
        properties_properties.num_com_mail_prop
    FROM properties_properties LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
    WHERE (properties_properties.id_prop) = '".simpleSanitize(($tokens[1]))."'

");

$smarty->assign("datosprop", $datos);

function GetDays($startDate, $endDate){

    $date1  = strtotime($startDate." 0:00:00");
    $date2  = strtotime($endDate." 23:59:59");
    $res    =  (int)(($date2-$date1)/86400);

return $res;
}


$smarty->assign("totaldias", GetDays(date("Y-m-d", strtotime($datos[0]['inserted_xml_prop'])), date("Y-m-d")));



$query_rsVisTot = "SELECT * FROM properties_views WHERE (property_vws) = '".simpleSanitize(($tokens[1]))."' ";
$rsVisTot = mysqli_query($inmoconn,$query_rsVisTot) or die(mysqli_error());
$row_rsVisTot = mysqli_fetch_assoc($rsVisTot);
$totalRows_rsVisTot = mysqli_num_rows($rsVisTot);

$smarty->assign("vistot", $totalRows_rsVisTot);


$query_rsVisHoy = "SELECT * FROM properties_views WHERE (property_vws) = '".simpleSanitize(($tokens[1]))."' AND date_vws > DATE_SUB(DATE(NOW()), INTERVAL 1 DAY)";
$rsVisHoy = mysqli_query($inmoconn,$query_rsVisHoy) or die(mysqli_error());
$row_rsVisHoy = mysqli_fetch_assoc($rsVisHoy);
$totalRows_rsVisHoy = mysqli_num_rows($rsVisHoy);


$smarty->assign("vishoy", $totalRows_rsVisHoy);


$query_rsVisSemana = "SELECT * FROM properties_views WHERE (property_vws) = '".simpleSanitize(($tokens[1]))."' AND date_vws > DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK)";
$rsVisSemana = mysqli_query($inmoconn,$query_rsVisSemana) or die(mysqli_error());
$row_rsVisSemana = mysqli_fetch_assoc($rsVisSemana);
$totalRows_rsVisSemana = mysqli_num_rows($rsVisSemana);

$smarty->assign("vissem", $totalRows_rsVisSemana);


$query_rsVisMes = "SELECT * FROM properties_views WHERE (property_vws) = '".simpleSanitize(($tokens[1]))."' AND date_vws > DATE_SUB(DATE(NOW()), INTERVAL 1 MONTH)";
$rsVisMes = mysqli_query($inmoconn,$query_rsVisMes) or die(mysqli_error());
$row_rsVisMes = mysqli_fetch_assoc($rsVisMes);
$totalRows_rsVisMes = mysqli_num_rows($rsVisMes);

$smarty->assign("vismes", $totalRows_rsVisMes);




$query_rsMailsTot = "SELECT * FROM properties_mail_rep WHERE (property_mrep) = '".simpleSanitize(($tokens[1]))."' ";
$rsMailsTot = mysqli_query($inmoconn,$query_rsMailsTot) or die(mysqli_error());
$row_rsMailsTot = mysqli_fetch_assoc($rsMailsTot);
$totalRows_rsMailsTot = mysqli_num_rows($rsMailsTot);

$smarty->assign("mailstot", $totalRows_rsMailsTot);


$query_rsMailsHoy = "SELECT * FROM properties_mail_rep WHERE (property_mrep) = '".simpleSanitize(($tokens[1]))."' AND date_mrep > DATE_SUB(DATE(NOW()), INTERVAL 1 DAY)";
$rsMailsHoy = mysqli_query($inmoconn,$query_rsMailsHoy) or die(mysqli_error());
$row_rsMailsHoy = mysqli_fetch_assoc($rsMailsHoy);
$totalRows_rsMailsHoy = mysqli_num_rows($rsMailsHoy);

$smarty->assign("mailshoy", $totalRows_rsMailsHoy);


$query_rsMailsSemana = "SELECT * FROM properties_mail_rep WHERE (property_mrep) = '".simpleSanitize(($tokens[1]))."' AND date_mrep > DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK)";
$rsMailsSemana = mysqli_query($inmoconn,$query_rsMailsSemana) or die(mysqli_error());
$row_rsMailsSemana = mysqli_fetch_assoc($rsMailsSemana);
$totalRows_rsMailsSemana = mysqli_num_rows($rsMailsSemana);

$smarty->assign("mailssem", $totalRows_rsMailsSemana);


$query_rsMailsMes = "SELECT * FROM properties_mail_rep WHERE (property_mrep) = '".simpleSanitize(($tokens[1]))."' AND date_mrep > DATE_SUB(DATE(NOW()), INTERVAL 1 MONTH)";
$rsMailsMes = mysqli_query($inmoconn,$query_rsMailsMes) or die(mysqli_error());
$row_rsMailsMes = mysqli_fetch_assoc($rsMailsMes);
$totalRows_rsMailsMes = mysqli_num_rows($rsMailsMes);

$smarty->assign("mailsmes", $totalRows_rsMailsMes);





$query_rsFavsTot = "SELECT * FROM properties_fav_rep WHERE (property_frep) = '".simpleSanitize(($tokens[1]))."' ";
$rsFavsTot = mysqli_query($inmoconn,$query_rsFavsTot) or die(mysqli_error());
$row_rsFavsTot = mysqli_fetch_assoc($rsFavsTot);
$totalRows_rsFavsTot = mysqli_num_rows($rsFavsTot);

$smarty->assign("favstot", $totalRows_rsFavsTot);

$query_rsFavsHoy = "SELECT * FROM properties_fav_rep WHERE (property_frep) = '".simpleSanitize(($tokens[1]))."' AND date_frep > DATE_SUB(DATE(NOW()), INTERVAL 1 DAY)";
$rsFavsHoy = mysqli_query($inmoconn,$query_rsFavsHoy) or die(mysqli_error());
$row_rsFavsHoy = mysqli_fetch_assoc($rsFavsHoy);
$totalRows_rsFavsHoy = mysqli_num_rows($rsFavsHoy);

$smarty->assign("favshoy", $totalRows_rsFavsHoy);


$query_rsFavsSemana = "SELECT * FROM properties_fav_rep WHERE (property_frep) = '".simpleSanitize(($tokens[1]))."' AND date_frep > DATE_SUB(DATE(NOW()), INTERVAL 1 WEEK)";
$rsFavsSemana = mysqli_query($inmoconn,$query_rsFavsSemana) or die(mysqli_error());
$row_rsFavsSemana = mysqli_fetch_assoc($rsFavsSemana);
$totalRows_rsFavsSemana = mysqli_num_rows($rsFavsSemana);

$smarty->assign("favssem", $totalRows_rsFavsSemana);


$query_rsFavsMes = "SELECT * FROM properties_fav_rep WHERE (property_frep) = '".simpleSanitize(($tokens[1]))."' AND date_frep > DATE_SUB(DATE(NOW()), INTERVAL 1 MONTH)";
$rsFavsMes = mysqli_query($inmoconn,$query_rsFavsMes) or die(mysqli_error());
$row_rsFavsMes = mysqli_fetch_assoc($rsFavsMes);
$totalRows_rsFavsMes = mysqli_num_rows($rsFavsMes);

$smarty->assign("favsmes", $totalRows_rsFavsMes);


$query_rsViewsChart = "SELECT COUNT(id_vws) AS total, DATE(date_vws) as fecha  FROM properties_views WHERE (property_vws) = '".simpleSanitize(($tokens[1]))."' GROUP BY DATE(date_vws) ORDER BY fecha ASC";
$rsViewsChart = mysqli_query($inmoconn,$query_rsViewsChart) or die(mysqli_error());
$row_rsViewsChart = mysqli_fetch_assoc($rsViewsChart);
$totalRows_rsViewsChart = mysqli_num_rows($rsViewsChart);

do {
    $totalArray[$row_rsViewsChart['fecha']] = $row_rsViewsChart['total'];
} while ($row_rsViewsChart = mysqli_fetch_assoc($rsViewsChart));

$smarty->assign("datesChart1", $totalArray);


function createRange($startDate, $endDate) {
    $tmpDate = new DateTime($startDate);
    $tmpEndDate = new DateTime($endDate);

    $outArray = array();
    do {
        $outArray[] = $tmpDate->format('Y-m-d');
    } while ($tmpDate->modify('+1 day') <= $tmpEndDate);

    return $outArray;
}


$query_rsViewsChartDatesMax = "SELECT MAX(date_vws) AS fecha  FROM properties_views WHERE (property_vws) = '".simpleSanitize(($tokens[1]))."'";
$rsViewsChartDatesMax = mysqli_query($inmoconn,$query_rsViewsChartDatesMax) or die(mysqli_error());
$row_rsViewsChartDatesMax = mysqli_fetch_assoc($rsViewsChartDatesMax);
$totalRows_rsViewsChartDatesMax = mysqli_num_rows($rsViewsChartDatesMax);


$query_rsViewsChartDatesMin = "SELECT MIN(date_vws) AS fecha  FROM properties_views WHERE (property_vws) = '".simpleSanitize(($tokens[1]))."'";
$rsViewsChartDatesMin = mysqli_query($inmoconn,$query_rsViewsChartDatesMin) or die(mysqli_error());
$row_rsViewsChartDatesMin = mysqli_fetch_assoc($rsViewsChartDatesMin);
$totalRows_rsViewsChartDatesMin = mysqli_num_rows($rsViewsChartDatesMin);

$viewsDates = createRange($row_rsViewsChartDatesMin['fecha'], $row_rsViewsChartDatesMax['fecha']);

$smarty->assign("totalChart1", $viewsDates);


$query_rsViewsChart = "SELECT COUNT(id_mrep) AS total, DATE(date_mrep) as fecha  FROM properties_mail_rep WHERE (property_mrep) = '".simpleSanitize(($tokens[1]))."' GROUP BY DATE(date_mrep) ORDER BY fecha ASC";
$rsViewsChart = mysqli_query($inmoconn,$query_rsViewsChart) or die(mysqli_error());
$row_rsViewsChart = mysqli_fetch_assoc($rsViewsChart);
$totalRows_rsViewsChart = mysqli_num_rows($rsViewsChart);

do {
    $totalArray2[$row_rsViewsChart['fecha']] = $row_rsViewsChart['total'];
} while ($row_rsViewsChart = mysqli_fetch_assoc($rsViewsChart));

$smarty->assign("datesChart2", $totalArray2);


$query_rsViewsChartDatesMax = "SELECT MAX(date_mrep) AS fecha  FROM properties_mail_rep WHERE (property_mrep) = '".simpleSanitize(($tokens[1]))."'";
$rsViewsChartDatesMax = mysqli_query($inmoconn,$query_rsViewsChartDatesMax) or die(mysqli_error());
$row_rsViewsChartDatesMax = mysqli_fetch_assoc($rsViewsChartDatesMax);
$totalRows_rsViewsChartDatesMax = mysqli_num_rows($rsViewsChartDatesMax);


$query_rsViewsChartDatesMin = "SELECT MIN(date_mrep) AS fecha  FROM properties_mail_rep WHERE (property_mrep) = '".simpleSanitize(($tokens[1]))."'";
$rsViewsChartDatesMin = mysqli_query($inmoconn,$query_rsViewsChartDatesMin) or die(mysqli_error());
$row_rsViewsChartDatesMin = mysqli_fetch_assoc($rsViewsChartDatesMin);
$totalRows_rsViewsChartDatesMin = mysqli_num_rows($rsViewsChartDatesMin);

$viewsDates = createRange($row_rsViewsChartDatesMin['fecha'], $row_rsViewsChartDatesMax['fecha']);

$smarty->assign("totalChart2", $viewsDates);


$query_rsViewsChart = "SELECT COUNT(id_frep) AS total, DATE(date_frep) as fecha  FROM properties_fav_rep WHERE (property_frep) = '".simpleSanitize(($tokens[1]))."' GROUP BY DATE(date_frep) ORDER BY fecha ASC";
$rsViewsChart = mysqli_query($inmoconn,$query_rsViewsChart) or die(mysqli_error());
$row_rsViewsChart = mysqli_fetch_assoc($rsViewsChart);
$totalRows_rsViewsChart = mysqli_num_rows($rsViewsChart);

do {
    $totalArray3[$row_rsViewsChart['fecha']] = $row_rsViewsChart['total'];
} while ($row_rsViewsChart = mysqli_fetch_assoc($rsViewsChart));

$smarty->assign("datesChart3", $totalArray3);


$query_rsViewsChartDatesMax = "SELECT MAX(date_frep) AS fecha  FROM properties_fav_rep WHERE (property_frep) = '".simpleSanitize(($tokens[1]))."'";
$rsViewsChartDatesMax = mysqli_query($inmoconn,$query_rsViewsChartDatesMax) or die(mysqli_error());
$row_rsViewsChartDatesMax = mysqli_fetch_assoc($rsViewsChartDatesMax);
$totalRows_rsViewsChartDatesMax = mysqli_num_rows($rsViewsChartDatesMax);


$query_rsViewsChartDatesMin = "SELECT MIN(date_frep) AS fecha  FROM properties_fav_rep WHERE (property_frep) = '".simpleSanitize(($tokens[1]))."'";
$rsViewsChartDatesMin = mysqli_query($inmoconn,$query_rsViewsChartDatesMin) or die(mysqli_error());
$row_rsViewsChartDatesMin = mysqli_fetch_assoc($rsViewsChartDatesMin);
$totalRows_rsViewsChartDatesMin = mysqli_num_rows($rsViewsChartDatesMin);

$viewsDates = createRange($row_rsViewsChartDatesMin['fecha'], $row_rsViewsChartDatesMax['fecha']);

$smarty->assign("totalChart3", $viewsDates);




$historia = getRecords("

    SELECT
      users.nombre_usr,
      properties_log.prop_id_log,
      properties_log.action_log,
      properties_log.date_log,
      properties_log.id_log
    FROM properties_log LEFT OUTER JOIN users ON properties_log.user_log = users.id_usr

    WHERE (prop_id_log) = '".simpleSanitize(($tokens[1]))."'

    ORDER BY date_log ASC

");

$smarty->assign("historia", $historia);

$historiam = getRecords("

    SELECT properties_mail_rep.date_mrep,
        users.nombre_usr,
        properties_mail_rep.client_mrep
    FROM properties_mail_rep INNER JOIN users ON properties_mail_rep.user_mrep = users.id_usr
    WHERE properties_mail_rep.user_mrep != 0  AND (properties_mail_rep.property_mrep) = '".simpleSanitize(($tokens[1]))."'

    ORDER BY date_mrep ASC

");

$smarty->assign("historiam", $historiam);

$query_rsOtros = "
SELECT citas.id_ct,
  citas.categoria_ct,
  citas.user_ct,
  citas.users_ct,
  citas.property_ct,
  citas.inicio_ct,
  citas.final_ct,
  citas.titulo_ct,
  citas.lugar_ct,
  citas.notas_ct,
  citas_categories.color_ct,
  citas_categories.category_".$lang."_ct as cat,
  users.nombre_usr,
  properties_client.id_cli,
  properties_client.nombre_cli,
  properties_client.apellidos_cli,
  properties_properties.referencia_prop as ref
FROM citas LEFT OUTER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct
   LEFT OUTER JOIN users ON citas.user_ct = users.id_usr
   LEFT OUTER JOIN properties_client ON citas.users_ct = properties_client.id_cli
   LEFT OUTER JOIN properties_properties ON citas.property_ct = properties_properties.id_prop
   WHERE FIND_IN_SET ('".simpleSanitize(($tokens[1]))."', property_ct) AND reporte_ct = 1
   GROUP BY citas.id_ct
 ORDER BY inicio_ct  ";
$rsOtros = mysqli_query($inmoconn,$query_rsOtros) or die(mysqli_error());
$row_rsOtros = mysqli_fetch_assoc($rsOtros);
$totalRows_rsOtros = mysqli_num_rows($rsOtros);

$otros = Array();
do {
    array_push($otros, $row_rsOtros);
} while ($row_rsOtros = mysqli_fetch_assoc($rsOtros));

$smarty->assign("otros", $otros);

$query_rsSeguimiento = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.id_prop,
      properties_properties.referencia_prop,
      properties_properties.inserted_xml_prop,
      properties_properties.updated_prop,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 1    GROUP BY prop_id_log, action_log), 0) as listado,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 2    GROUP BY prop_id_log, action_log), 0) as propiedad,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 3    GROUP BY prop_id_log, action_log), 0) as consulta,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 4    GROUP BY prop_id_log, action_log), 0) as amigo,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 5    GROUP BY prop_id_log, action_log), 0) as impreso,
      IFNULL((SELECT COUNT(prop_id_log) FROM properties_log_2 WHERE prop_id_log = id_prop AND action_log = 6    GROUP BY prop_id_log, action_log), 0) as favoritos
    FROM properties_properties
     WHERE id_prop = '".simpleSanitize(($tokens[1]))."'
    GROUP BY id_prop
    ORDER BY  `updated_prop` desc
    LIMIT 0, 10
";
$rsSeguimiento = mysqli_query($inmoconn,$query_rsSeguimiento) or die(mysqli_error());
$row_rsSeguimiento = mysqli_fetch_assoc($rsSeguimiento);
$totalRows_rsSeguimiento = mysqli_num_rows($rsSeguimiento);

$smarty->assign("seg", $row_rsSeguimiento);

