<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

// Cargamos las urls
include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

$url_staticas = array();

// foreach ($urlStr as $key => $urls) {
//     foreach ($urls as $langval => $urlval) {
//         if ($langval == $lang) {
//             $urlStr[$key]['url'] = $urlval;

//             if (is_array($urlStr[$key]) && isset($urlStr[$key][$langval])) {
//                 $urlStr[$urlStr[$key][$langval]]['master'] = $key;
//             }
//         }
//     }

//     if (isset($urlval['mostrar-en-sitemap']) && $urlval['mostrar-en-sitemap'] == 1) {
//         if ($key == 'sell-your-property') {
//             if (isset($actVenderPropiedad) && $actVenderPropiedad == 1) {
//                 array_push($url_staticas, $key);
//             }
//         } else {
//             array_push($url_staticas, $key);
//         }
//     }
// }

foreach ($urlStr as $key => $urls) {
    foreach ($urls as $langval => $urlval) {
        if ($langval == 'mostrar-en-sitemap') {
            if ($urlval == 1) {
                array_push($url_staticas, $key);
            }
        }
    }
}

// ini_set('display_errors', 1);
//  error_reporting(E_ALL);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php

        $sql0 = '';

         foreach ($languages as $langs) {

            $sql0 .= 'news.title_'.$langs.'_nws as titulo_'.$langs.','."\n";
            $sql0 .= 'news.titlew_'.$langs.'_nws as titulow_'.$langs.','."\n";

        }

		$noticias = getRecords("
		    SELECT
                ".$sql0."
				news.id_nws
		    FROM news
		    WHERE type_nws = 1 AND activate_nws = 1
		    ORDER BY news.date_nws DESC
		");

        $langingPages = getRecords("

            SELECT

                ".$sql0."
                news.id_nws

            FROM news

            WHERE type_nws = 3 AND activate_nws = 1

            ORDER BY news.date_nws DESC

        ");

        $quicklinks = getRecords("

            SELECT

                ".$sql0."
                news.id_nws

            FROM news

            WHERE type_nws = 4 AND activate_nws = 1

            ORDER BY news.date_nws DESC

        ");

        if ($actZonas == 1) {

            $sql1 = '';

            foreach ($languages as $langs) {

                $sql1 .= 'category_' . $langs . '_ct as titulo_'.$langs.','."\n";

            }

            $zonas = getRecords("
                SELECT
                " . $sql1 . "
                id_ct
                FROM news_categories
                WHERE type_ct = 6
                ");

            function getCities($zona, $lang) {

                $sql2 = '';

                $ciudades = getRecords("

                    SELECT news.id_nws,
                        title_" . $lang . "_nws as titulo_".$lang.",
                        id_nws

                    FROM news

                    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 6

                    ORDER BY news.date_nws DESC

                ");

                return $ciudades;
            }

        }

        $sql = '';

         foreach ($languages as $langs) {

            $sql .= 'properties_loc1.name_'.$langs.'_loc1 AS country_'.$langs.','."\n";
            $sql .= 'CASE WHEN properties_loc3.name_'.$langs.'_loc3 IS NOT NULL THEN properties_loc3.name_'.$langs.'_loc3 ELSE areas1.name_'.$langs.'_loc3 END AS area_'.$langs.','."\n";
            $sql .= 'CASE WHEN properties_loc4.name_'.$langs.'_loc4 IS NOT NULL THEN properties_loc4.name_'.$langs.'_loc4 ELSE towns.name_'.$langs.'_loc4 END AS town_'.$langs.','."\n";
            $sql .= 'CASE WHEN properties_types.types_'.$langs.'_typ IS NOT NULL THEN properties_types.types_'.$langs.'_typ ELSE types.types_'.$langs.'_typ END AS type_'.$langs.','."\n";
            $sql .= 'properties_status.status_'.$langs.'_sta as sale_'.$langs.','."\n";
            $sql .= 'title_'.$langs.'_prop as metatitle_'.$langs.','."\n";

        }

		$inmuebles = getRecords("
			SELECT
				".$sql."
				properties_properties.habitaciones_prop,
				id_prop,
				properties_properties.referencia_prop AS ref
    		FROM
				properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
		        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
		        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
		        LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
		        INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
			WHERE activado_prop = 1 AND procesada_img = 1 AND force_hide_prop != 1
			GROUP BY id_prop
		");

        // include class
        include 'SitemapGenerator.php';

        // ini_set('display_errors', 1);
        // error_reporting(E_ALL);

        // create object
        $sitemap = new SitemapGenerator("https://".$_SERVER['HTTP_HOST']."/");

        $sitemap->robotsFileName = "robots.txt";

        // sitemap file name
        $sitemap->sitemapFileName = "sitemap.xml";

        unset($languages[0]);

        $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/", date('c'),  'daily',    '1');
        foreach ($languages as $langs) {
            $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/", date('c'),  'daily',    '1');
        }

        if ($actMapaPropiedades == 1) {
            array_push($url_staticas, "property-map");
        }

        $secciones = $url_staticas;

        foreach ($secciones as $secc) {
            $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$urlStr[$secc][$language]."/", date('c'),  'daily',    '1');
            foreach ($languages as $langs) {
                if ($langs != $language) {
                    $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".$urlStr[$secc][$langs]."/", date('c'),  'daily',    '1');
                }

            }
        }

        if($inmuebles[0]['id_prop'] != '') {
            $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$urlStr['properties'][$language]."/", date('c'),  'daily',    '0.5');
            foreach ($languages as $langs) {
                $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".$urlStr['properties'][$langs]."/", date('c'),  'daily',    '0.5');
            }

            foreach ($inmuebles as $key => $value) {

                $sitemap->addUrl("https://".$_SERVER['HTTP_HOST'].propURL(stripslashes(mysqli_real_escape_string($inmoconn,$value['id_prop'])), $language), date('c'),  'daily',    '0.5');

                foreach ($languages as $langs) {
                    $sitemap->addUrl("https://".$_SERVER['HTTP_HOST'].propURL(stripslashes(mysqli_real_escape_string($inmoconn,$value['id_prop'])), $langs), date('c'),  'daily',    '0.5');
                }
            }
        }

        if ($actNoticias==1) {
	        $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$urlStr['news'][$language]."/", date('c'),  'daily',    '0.5');
	        foreach ($languages as $langs) {
	            $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".$urlStr['news'][$langs]."/", date('c'),  'daily',    '0.5');
	        }
	        foreach ($noticias as $key => $value) {
	            if ($value['titulow_'.$language] != '') {
	                $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$urlStr['news'][$language]."/".$value['id_nws']."/".clean($value['titulow_'.$language])."/", date('c'),  'daily',    '0.5');
	            } else {
	                $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$urlStr['news'][$language]."/".$value['id_nws']."/".clean($value['titulo_'.$language])."/", date('c'),  'daily',    '0.5');
	            }
	            foreach ($languages as $langs) {
	                if ($value['titulow_'.$langs] != '') {
	                    $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".$urlStr['news'][$langs]."/".$value['id_nws']."/".clean($value['titulow_'.$langs])."/", date('c'),  'daily',    '0.5');
	                } else {
	                    if ($value['titulo_'.$langs] != '') {
	                        $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".$urlStr['news'][$langs]."/".$value['id_nws']."/".clean($value['titulo_'.$langs])."/", date('c'),  'daily',    '0.5');
	                    }
	                }
	            }
	        }
	     }

        if ($actLanding == 1) {
            if($langingPages[0]['id_nws'] != '') {
                foreach ($langingPages as $key => $value) {
                    if ($value['titulo_'.$language] != '') {
                        $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".clean($value['titulo_'.$language]).".html", date('c'),  'daily',    '0.5');
                    }
                    foreach ($languages as $langs) {

                        if ($value['titulo_'.$langs] != '') {
                           $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".clean($value['titulo_'.$langs]).".html", date('c'),  'daily',    '0.5');
                       }
                    }
                }
            }
        }

        if ($actQuicklinks == 1) {
            if($quicklinks[0]['id_nws'] != '') {
                foreach ($quicklinks as $key => $value) {
                    if ($value['titulo_'.$language] != '') {
                        $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".clean($value['titulo_'.$language]).".html", date('c'),  'daily',    '0.5');
                    }
                    foreach ($languages as $langs) {
                        if ($value['titulo_'.$langs] != '') {
                           $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".clean($value['titulo_'.$langs]).".html", date('c'),  'daily',    '0.5');
                       }
                    }
                }
            }
        }

         if ($actZonas == 1) {
            if($zonas[0]['id_ct'] != '') {
                foreach ($zonas as $key => $value) {
                    if ($value['titulo_'.$language] != '') {
                        $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".clean($value['titulo_'.$language]).".html", date('c'),  'daily',    '0.5');
                        $ciudades = getCities($value['id_ct'], $language);
                        if($ciudades[0]['id_nws'] != '') {
                            foreach ($ciudades as $key2 => $value2) {
                                $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".clean($value['titulo_'.$language])."/".clean($value2['titulo_'.$language]).".html", date('c'),  'daily',    '0.5');
                            }
                        }
                    }
                    foreach ($languages as $langs) {
                        if ($value['titulo_'.$langs] != '') {
                           $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".clean($value['titulo_'.$langs]).".html", date('c'),  'daily',    '0.5');
                            $ciudades = getCities($value['id_ct'], $langs);
                            if($ciudades[0]['id_nws'] != '') {
                                foreach ($ciudades as $key2 => $value2) {
                                    $sitemap->addUrl("https://".$_SERVER['HTTP_HOST']."/".$langs."/".clean($value['titulo_'.$langs])."/".clean($value2['titulo_'.$langs]).".html", date('c'),  'daily',    '0.5');
                                }
                            }
                       }
                    }
                }
            }
         }

        // create sitemap
        echo $sitemap->createSitemap();

        // write sitemap as file
        $sitemap->writeSitemap();

        // update robots.txt file
        $sitemap->updateRobots();

        // submit sitemaps to search engines
        $result = $sitemap->submitSitemap();
        // shows each search engine submitting status
        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";
        ?>
    </body>
</html>
