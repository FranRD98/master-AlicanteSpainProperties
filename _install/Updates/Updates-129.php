<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 21-10-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Error textos Master</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras importador Habihub</a></li>
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras en el módulo de promociones</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error textos Master
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Este inmueble no se permite mostara en la web&#039;] = &#039;Este inmueble no se permite mostara en la web&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales nacionales&#039;] = &#039;Este inmueble no se permite mostara en portales nacionales&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales internacionales&#039;] = &#039;Este inmueble no se permite mostara en portales internacionales&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Este inmueble no se permite mostara en la web&#039;] = &#039;Este inmueble no se permite mostrar en la web&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales nacionales&#039;] = &#039;Este inmueble no se permite mostrar en portales nacionales&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales internacionales&#039;] = &#039;Este inmueble no se permite mostrar en portales internacionales&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras importador Habihub
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:77
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$promotionID = setPromotionHabihub((string)$property-&gt;development_name, (string)$provinceName, (string)$townName);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$promotionID = setPromotionHabihub((string)$property-&gt;development_name, (string)$provinceName, (string)$townName, $property);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:122
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (!$in_database || $proveedor[&#039;up_descripcion_xml&#039;] == 1)
{
   foreach($allLanguages as $value)
   {
       if ($value == &#039;se&#039;) {
           $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;sv)).&quot;&#039;, \n&quot;;
           if ($property-&gt;title-&gt;$value != &#039;&#039;)
           {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;; //t&iacute;tulos de las propiedades
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;; //t&iacute;tulos de las propiedades
           }
       } else {
           if ((string)$property-&gt;desc-&gt;$value != &#039;&#039;) {
                $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;title-&gt;$value != &#039;&#039;) {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;$value)).&quot;&#039;, \n&quot;; //t&iacute;tulos de las propiedades
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;; //t&iacute;tulos de las propiedades
           }
       }
   }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (!$in_database || $proveedor[&#039;up_descripcion_xml&#039;] == 1)
{
   foreach($allLanguages as $value)
   {
       if ($value == &#039;se&#039;) {
           if ((string)$property-&gt;desc-&gt;sv != &#039;&#039;) {
                $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;metadescription-&gt;sv != &#039;&#039;) {
                $query .= &quot;description_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ($property-&gt;seo-&gt;h1-&gt;sv != &#039;&#039;) {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ($property-&gt;seo-&gt;title-&gt;sv != &#039;&#039;) {
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
           }
       } else {
           if ((string)$property-&gt;desc-&gt;$value != &#039;&#039;) {
                $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;metadescription-&gt;$value != &#039;&#039;) {
                $query .= &quot;description_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;h1-&gt;$value != &#039;&#039;) {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;title-&gt;$value != &#039;&#039;) {
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
           }
       }
   }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php:131
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (!function_exists(&quot;setPromotionHabihub&quot;)) {
    function setPromotionHabihub($promotion, $province, $ciudad) {
        global $database_inmoconn, $inmoconn, $allLanguages, $promotionID, $newTypeArray, $autotraduccion, $language;

        $query_rsPromotion = &quot;SELECT id_nws FROM news WHERE  LOWER(title_en_nws) = &#039;&quot; . mysqli_real_escape_string($inmoconn, trim(strtolower($promotion))) . &quot;&#039; AND type_nws = 999&quot;;
        $rsPromotion = mysqli_query($inmoconn,$query_rsPromotion) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsPromotion);
        $row_rsPromotion = mysqli_fetch_assoc($rsPromotion);
        $totalRows_rsPromotion = mysqli_num_rows($rsPromotion);
        if($totalRows_rsPromotion == 0){
            $query = &quot;INSERT INTO news SET &quot;;
            foreach($allLanguages as $value) {
                $query .= &quot;title_&quot;.$value.&quot;_nws = &#039;&quot; . mysqli_real_escape_string($inmoconn, trim((string)$promotion)) . &quot;&#039;, &quot;;
                $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot; . mysqli_real_escape_string($inmoconn, trim((string)$promotion)) . &quot;&#039;, &quot;;
            }
            $query .= &quot;quick_province_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn, trim((string)$province)).&quot;&#039;, &quot;;
            $query .= &quot;quick_town_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn, trim((string)$ciudad)).&quot;&#039;, &quot;;
            $query .= &quot;activate_nws = 0, &quot;;
            $query .= &quot;type_nws = 999 &quot;;
            $rsPromotionInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query);
            $id = @mysqli_insert_id($inmoconn);
            $promotionID = (int)$id;
            return $promotionID;
        } else{
            $promotionID = (int)$row_rsPromotion[&#039;id_nws&#039;];
            return $promotionID;
        }
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (!function_exists(&quot;setPromotionHabihub&quot;)) {
    function setPromotionHabihub($promotion, $province, $ciudad, $property) {
        global $database_inmoconn, $inmoconn, $allLanguages, $promotionID, $newTypeArray, $autotraduccion, $language;

        $query_rsPromotion = &quot;SELECT id_nws FROM news WHERE  LOWER(title_en_nws) = &#039;&quot; . mysqli_real_escape_string($inmoconn, trim(strtolower($promotion))) . &quot;&#039; AND type_nws = 999&quot;;
        $rsPromotion = mysqli_query($inmoconn,$query_rsPromotion) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsPromotion);
        $row_rsPromotion = mysqli_fetch_assoc($rsPromotion);
        $totalRows_rsPromotion = mysqli_num_rows($rsPromotion);
        if($totalRows_rsPromotion == 0){
            $query = &quot;INSERT INTO news SET &quot;;
            foreach($allLanguages as $value) {
                $query .= &quot;title_&quot;.$value.&quot;_nws = &#039;&quot; . mysqli_real_escape_string($inmoconn, trim((string)$promotion)) . &quot;&#039;, &quot;;
            }
            $query .= &quot;quick_province_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn, trim((string)$province)).&quot;&#039;, &quot;;
            $query .= &quot;quick_town_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn, trim((string)$ciudad)).&quot;&#039;, &quot;;
            $lat = mysqli_real_escape_string($inmoconn,trim((float)$property-&gt;location-&gt;latitude));
            $long = mysqli_real_escape_string($inmoconn,trim((float)$property-&gt;location-&gt;longitude));
            if (($lat != &#039;&#039; &amp;&amp; $lat != 0) &amp;&amp; ($long != &#039;&#039; &amp;&amp; $long != 0)) {
                $query .= &quot;lat_long_gp_prop = &#039;&quot;.$lat.&quot;,&quot;.$long.&quot;&#039;, \n&quot;;
            }
            foreach($allLanguages as $value) {
               if ($value == &#039;se&#039;) {
                   if ((string)$property-&gt;desc-&gt;sv != &#039;&#039;) {
                        $query .= &quot;content_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;sv)).&quot;&#039;, \n&quot;;
                   }
                   if ((string)$property-&gt;seo-&gt;metadescription-&gt;sv != &#039;&#039;) {
                        $query .= &quot;description_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;sv)).&quot;&#039;, \n&quot;;
                   }
                   if ($property-&gt;seo-&gt;h1-&gt;sv != &#039;&#039;) {
                        $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;sv)).&quot;&#039;, \n&quot;;
                   }
                   if ($property-&gt;seo-&gt;title-&gt;sv != &#039;&#039;) {
                        $query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
                   }
               } else {
                   if ((string)$property-&gt;desc-&gt;$value != &#039;&#039;) {
                        $query .= &quot;content_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;$value)).&quot;&#039;, \n&quot;;
                   }
                   if ((string)$property-&gt;seo-&gt;metadescription-&gt;$value != &#039;&#039;) {
                        $query .= &quot;description_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;$value)).&quot;&#039;, \n&quot;;
                   }
                   if ((string)$property-&gt;seo-&gt;h1-&gt;$value != &#039;&#039;) {
                        $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;$value)).&quot;&#039;, \n&quot;;
                   }
                   if ((string)$property-&gt;seo-&gt;title-&gt;$value != &#039;&#039;) {
                        $query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
                   }
                }
            }
            $query .= &quot;activate_nws = 0, &quot;;
            $query .= &quot;type_nws = 999 &quot;;
            $rsPromotionInsert = mysqli_query($inmoconn,$query) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query);
            $id = @mysqli_insert_id($inmoconn);
            $promotionID = (int)$id;

            // IMAGENES
            if (!empty($property-&gt;images-&gt;image-&gt;url)) {
                $imgOrd = 1;
                foreach($property-&gt;images-&gt;image as $image) {
                    set_time_limit(0);
                    $query = &quot;INSERT INTO news_fotos SET &quot;;
                    $query .= &quot;noticia_img = &#039;&quot;.$promotionID.&quot;&#039;,&quot;;
                    $query .= &quot;imagen_img = &#039;&quot;.trim($image-&gt;url).&quot;&#039;, &quot;;
                    $query .= &quot;orden_img = &#039;&quot;.$imgOrd++.&quot;&#039;&quot;;
                    mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }

            // FEATURES
            if (!empty($property-&gt;features)) {
                foreach($property-&gt;features-&gt;feature as $feature) {
                    set_time_limit(0);
                    $feature = mysqli_real_escape_string($inmoconn,trim((string)$feature));

                    if (!preg_match(&#039;/^Private garage:\s*\d+$/i&#039;, $feature) &amp;&amp; !preg_match(&#039;/^Private parking:\s*\d+$/i&#039;, $feature) &amp;&amp; !preg_match(&#039;/^Floor:\s*\d+$/i&#039;, $feature)) {
                        $query_rsFeature = &quot;SELECT id_feat, feature_en_feat FROM properties_features_priv WHERE  LOWER(feature_en_feat) = &#039;&quot;.strtolower($feature).&quot;&#039;&quot;;
                        $rsFeature = mysqli_query($inmoconn,$query_rsFeature) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsFeature );
                        $row_rsFeature = mysqli_fetch_assoc($rsFeature);
                        $totalRows_rsFeature = mysqli_num_rows($rsFeature);
                        if ($totalRows_rsFeature == 0) {
                            $query = &quot;INSERT INTO properties_features_priv SET &quot;;
                            if ($autotraduccion == 1) {
                               $query .= &quot;feature_en_feat = &#039;&quot;.$feature.&quot;&#039;&quot;;
                            } else {
                                $x=0;
                                foreach($allLanguages as $value) {
                                    if($x++ &gt; 0){
                                        $query .= &quot;, &quot;;
                                    }
                                    $query .= &quot;feature_&quot;.$value.&quot;_feat = &#039;&quot;.$feature.&quot;&#039;&quot;;
                                }
                            }

                            $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                            $id = @mysqli_insert_id($inmoconn);
                            $featureID = $id;
                        } else {
                            $featureID = $row_rsFeature[&#039;id_feat&#039;];
                        }
                        if($featureID != &#039;&#039;){
                            $query = &quot;INSERT INTO promotions_promotions_feature SET &quot;;
                            $query .= &quot;promotion = &#039;&quot;.$promotionID.&quot;&#039;,&quot;;
                            $query .= &quot;feature = &#039;&quot;.$featureID.&quot;&#039;&quot;;

                            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        }
                    }
                }

                //  TAGS
                $tagsHabihub = array();
                if (in_array(&#039;Key ready&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 5);}
                if (in_array(&#039;Open views&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 14);}
                if (in_array(&#039;Off plan&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 6);}
                if (in_array(&#039;Beach&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 2);}
                if (in_array(&#039;Golf&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 3);}
                if (in_array(&#039;Village views&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 11);}
                if (in_array(&#039;Mountain views&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 15);}
                if (in_array(&#039;Sea views&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 1);}
                if (in_array(&#039;First line&#039;, (array)$property-&gt;tags-&gt;tag)) {array_push($tagsHabihub, 8);}
                if (!empty($tagsHabihub)) {
                    foreach($tagsHabihub as $tag) {
                        if ((string)$tag &gt; 0) {
                            $query = &quot;INSERT INTO promotions_promotions_tag SET &quot;;
                            $query .= &quot;promotion = &#039;&quot;.$promotionID.&quot;&#039;,&quot;;
                            $query .= &quot;tag = &#039;&quot;.$tag.&quot;&#039;&quot;;
                            mysqli_query($inmoconn,$query) or die(mysqli_error());
                        }
                    }
                }
            }
            return $promotionID;
        } else{
            $promotionID = (int)$row_rsPromotion[&#039;id_nws&#039;];
            return $promotionID;
        }
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras en el módulo de promociones
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="sql">
ALTER TABLE `news` ADD COLUMN `titulo_prom_ca_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_da_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_de_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_en_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_es_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_fi_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_fr_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_is_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_nl_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_no_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_ru_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_se_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_zh_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `titulo_prom_pl_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `destacado_propm_nws` INT(1) NULL DEFAULT 0;
ALTER TABLE `news` ADD COLUMN `order_nws` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD INDEX `idx_promocion_prop` (`promocion_prop`);
CREATE TABLE `promotions_promotions_feature` (`promotion` int(30) NOT NULL DEFAULT '0',`feature` int(30) NOT NULL DEFAULT '0',KEY `inmueble` (`promotion`,`feature`),KEY `opciones` (`feature`),KEY `promotion` (`promotion`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `promotions_promotions_tag` (`promotion` int(30) NOT NULL DEFAULT '0',`tag` int(30) NOT NULL DEFAULT '0',KEY `inmueble` (`promotion`,`tag`),KEY `opciones` (`tag`),KEY `promotion` (`promotion`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            </code>
        </pre>
        <hr>
        Añadir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/promotions/promotions-order.php
/intramedianet/promotions/promotions_order.php
/intramedianet/promotions/_js/promotions-order.js
/modules/promociones/pdf.php
/modules/promociones/view/pdf/pdf.html
intramedianet/promotions/promotions-all-download-csv.php

            </code>
        </pre>
        <hr>
        Sustituir los archivos:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/tab-caracteristicas.tpl
/modules/promociones/view/partials/tab-propiedades.tpl
/templates/plugins/function.imagesize.php
/templates/plugins/function.imagesize2.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:239
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;title_&quot;.$value.&quot;_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;title_&quot;.$value.&quot;_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;title_&quot;.$value.&quot;_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;title_&quot;.$value.&quot;_nws&quot;);
$ins_news-&gt;addColumn(&quot;titulo_prom_&quot;.$value.&quot;_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;titulo_prom_&quot;.$value.&quot;_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:261
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;title_&quot;.$value.&quot;_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;title_&quot;.$value.&quot;_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;title_&quot;.$value.&quot;_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;title_&quot;.$value.&quot;_nws&quot;);
$upd_news-&gt;addColumn(&quot;titulo_prom_&quot;.$value.&quot;_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;titulo_prom_&quot;.$value.&quot;_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:474
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-4&quot;&gt;
    &lt;label for=&quot;title_&lt;?php echo $value; ?&gt;_nws&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Titular&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;title_&lt;?php echo $value; ?&gt;_nws&quot; id=&quot;title_&lt;?php echo $value; ?&gt;_nws&quot; value=&quot;&lt;?php echo KT_escapeAttribute(row_rsnews[&#039;title_&#039;.$value.&#039;_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;title_&quot;.$value.&quot;_nws&quot;); ?&gt;
    &lt;?php if ($traduccion_textos == 1): ?&gt;
        &lt;div class=&quot;float-end mb-4&quot;&gt;
        &lt;?php foreach ($languages as $langx): ?&gt;
            &lt;?php if ($langx != $value): ?&gt;
                &lt;button type=&quot;button&quot; class=&quot;btn btn-soft-primary btn-sm btn-translate mt-1&quot;
                    data-from=&quot;&lt;?php echo $value; ?&gt;&quot;
                    data-to=&quot;&lt;?php echo $langx; ?&gt;&quot;
                    data-fields-pref=&quot;title_&quot;
                    data-fields-suf=&quot;_nws&quot;
                    data-tab=&quot;title&quot;
                 &gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; height=&quot;13&quot;&gt; &lt;i class=&quot;fa-solid fa-caret-rightmx-1&quot;&gt;&lt;/i&gt; &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $langx; ?&gt;.svg&quot; height=&quot;13&quot;&gt;&lt;/button&gt;
            &lt;?php endif ?&gt;
        &lt;?php endforeach ?&gt;
        &lt;/div&gt;
        &lt;br&gt;
    &lt;?php endif ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-4&quot;&gt;
 &lt;label for=&quot;titulo_prom_&lt;?php echo $value; ?&gt;_nws&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Titular&#039;); ?&gt; Website:&lt;/label&gt;
 &lt;input type=&quot;text&quot; name=&quot;titulo_prom_&lt;?php echo $value; ?&gt;_nws&quot; id=&quot;titulo_prom_&lt;?php echo $value; ?&gt;_nws&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;titulo_prom_&#039;.$value.&#039;_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
 &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;titulo_prom_&quot;.$value.&quot;_nws&quot;); ?&gt;
 &lt;?php if ($traduccion_textos == 1): ?&gt;
     &lt;div class=&quot;float-end mb-4&quot;&gt;
     &lt;?php foreach ($languages as $langx): ?&gt;
         &lt;?php if ($langx != $value): ?&gt;
             &lt;button type=&quot;button&quot; class=&quot;btn btn-soft-primary btn-sm btn-translate mt-1&quot;
                 data-from=&quot;&lt;?php echo $value; ?&gt;&quot;
                 data-to=&quot;&lt;?php echo $langx; ?&gt;&quot;
                 data-fields-pref=&quot;titulo_prom_&quot;
                 data-fields-suf=&quot;_nws&quot;
                 data-tab=&quot;titulo_prom&quot;
             &gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; height=&quot;13&quot;&gt; &lt;i class=&quot;fa-solid fa-caret-right mx-1&quot;&gt;&lt;/i&gt; &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $langx; ?&gt;.svg&quot; height=&quot;13&quot;&gt;&lt;/button&gt;
         &lt;?php endif ?&gt;
     &lt;?php endforeach ?&gt;
     &lt;/div&gt;
     &lt;br&gt;
 &lt;?php endif ?&gt;
&lt;/div&gt;

&lt;br class=&quot;d-md-none&quot;&gt;
&lt;br class=&quot;d-md-none&quot;&gt;

&lt;div class=&quot;mb-4&quot;&gt;
 &lt;label for=&quot;title_&lt;?php echo $value; ?&gt;_nws&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Titular&#039;); ?&gt;:&lt;/label&gt;
 &lt;input type=&quot;text&quot; name=&quot;title_&lt;?php echo $value; ?&gt;_nws&quot; id=&quot;title_&lt;?php echo $value; ?&gt;_nws&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;title_&#039;.$value.&#039;_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
 &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;title_&quot;.$value.&quot;_nws&quot;); ?&gt;
 &lt;?php if ($traduccion_textos == 1): ?&gt;
     &lt;div class=&quot;float-end mb-4&quot;&gt;
     &lt;?php foreach ($languages as $langx): ?&gt;
         &lt;?php if ($langx != $value): ?&gt;
             &lt;button type=&quot;button&quot; class=&quot;btn btn-soft-primary btn-sm btn-translate mt-1&quot;
                 data-from=&quot;&lt;?php echo $value; ?&gt;&quot;
                 data-to=&quot;&lt;?php echo $langx; ?&gt;&quot;
                 data-fields-pref=&quot;title_&quot;
                 data-fields-suf=&quot;_nws&quot;
                 data-tab=&quot;title&quot;
             &gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; height=&quot;13&quot;&gt; &lt;i class=&quot;fa-solid fa-caret-right mx-1&quot;&gt;&lt;/i&gt; &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $langx; ?&gt;.svg&quot; height=&quot;13&quot;&gt;&lt;/button&gt;
         &lt;?php endif ?&gt;
     &lt;?php endforeach ?&gt;
     &lt;/div&gt;
     &lt;br&gt;
 &lt;?php endif ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/news.php:287
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
news.title_&quot;.$lang.&quot;_nws as titulo,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
news.title_&quot;.$lang.&quot;_nws as titulo,
news.titulo_prom_&quot;.$lang.&quot;_nws as titulo_prom,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/new.php:246
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
news.title_&quot; . $lang . &quot;_nws as titulo,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
news.title_&quot; . $lang . &quot;_nws as titulo,
news.titulo_prom_&quot; . $lang . &quot;_nws as titulo_prom,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/noticia.tpl:12
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$resource.img}&quot;}
{imagesize src=&quot;{$imgProp}&quot; width=590 height=355 class=&#039;img-fluid w-100&#039; alt=&quot;{$altt}&quot; title=&quot;{$altt}&quot; }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$resource.img}
    {imagesize src=&quot;{$resource.img}&quot; width=590 height=355 class=&#039;img-fluid w-100&#039; alt=&quot;{$altt}&quot; title=&quot;{$altt}&quot; path=&quot;/media/images/news/&quot; }
{else}
    {assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$resource.img}&quot;}
    {imagesize src=&quot;{$imgProp}&quot; width=590 height=355 class=&#039;img-fluid w-100&#039; alt=&quot;{$altt}&quot; title=&quot;{$altt}&quot; }
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/noticia.tpl:28
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;h3&gt;{$resource.titulo}&lt;/h3&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $resource.titulo_prom != &#039;&#039;}
    &lt;h3&gt;{$resource.titulo_prom}&lt;/h3&gt;
{else}
    &lt;h3&gt;{$resource.titulo}&lt;/h3&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/titulo.tpl:7
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;span&gt;{$news[0].titulo}&lt;/span&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $news[0].titulo_prom != &#039;&#039;}
    &lt;span&gt;{$news[0].titulo_prom}&lt;/span&gt;
{else}
    &lt;span&gt;{$news[0].titulo}&lt;/span&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/main-img.tpl:24
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$news[0].img}&quot;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$resource.img}
    {assign var=&quot;imgProp&quot; value=&quot;{$news[0].img}&quot;}
{else}
    {assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$news[0].img}&quot;}
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/tab-photos.tpl:17
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $images.img.image_img|preg_match:&quot;/http:\/\//&quot;}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&#039;&#039;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800
}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}

&lt;div class=&quot;col-md-4 col-lg-3&quot;&gt;
    &lt;a {if $galeriaModal == 1} data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#galleryModalPromo&quot; {/if}
        href=&quot;http://{$smarty.server.HTTP_HOST}/{$linkImgSrc}&quot;
        class=&quot;mb-3 mb-md-4 {if $galeriaModal == 0} gallProp {/if}  d-inline-block&quot;&gt;
        {imagesize src=&quot;{$linkImg}&quot; width=410 height=230 class=&#039;img-fluid&#039; alt=&quot;{$altTitle}&quot;
        title=&quot;{$altTitle}&quot;}
    &lt;/a&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$images[img].image_img}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&quot;&quot; path=&quot;/media/images/news/&quot;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;https://{$smarty.server.HTTP_HOST}/{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800 path=&quot;/media/images/news/&quot; }&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}

&lt;div class=&quot;col-md-4 col-lg-3&quot;&gt;
    &lt;a {if $galeriaModal == 1} data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#galleryModalPromo&quot; {/if}
        href=&quot;{$linkImgSrc}&quot;
        class=&quot;mb-3 mb-md-4 {if $galeriaModal == 0} gallProp {/if}  d-inline-block&quot;&gt;
        {imagesize src=&quot;{$linkImg}&quot; width=410 height=230 class=&#039;img-fluid&#039; alt=&quot;{$altTitle}&quot;
        title=&quot;{$altTitle}&quot;  path=&#039;/media/images/news/&#039;}
    &lt;/a&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/tab-photos.tpl:47
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $images.img.image_img|preg_match:&quot;/http:\/\//&quot;}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&#039;&#039;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800 }&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}

&lt;div class=&quot;col-md-4 col-lg-3&quot;&gt;
    &lt;a {if $galeriaModal == 1} data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#galleryModalPromo&quot; {/if}
        href=&quot;http://{$smarty.server.HTTP_HOST}/{$linkImgSrc}&quot;
        class=&quot;mb-3 mb-md-4 {if $galeriaModal == 0} gallProp {/if} d-inline-block&quot;&gt;
        {imagesize src=&quot;{$linkImg}&quot; width=410 height=230 class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot;
        title=&quot;{$altTitle}&quot;}
    &lt;/a&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$images[img].image_img}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&quot;&quot; path=&quot;/media/images/news/&quot;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;https://{$smarty.server.HTTP_HOST}/{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800 path=&quot;/media/images/news/&quot; }&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}

&lt;div class=&quot;col-md-4 col-lg-3&quot;&gt;
    &lt;a {if $galeriaModal == 1} data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#galleryModalPromo&quot; {/if}
        href=&quot;{$linkImgSrc}&quot;
        class=&quot;mb-3 mb-md-4 {if $galeriaModal == 0} gallProp {/if}  d-inline-block&quot;&gt;
        {imagesize src=&quot;{$linkImg}&quot; width=410 height=230 class=&#039;img-fluid&#039; alt=&quot;{$altTitle}&quot;
        title=&quot;{$altTitle}&quot;  path=&#039;/media/images/news/&#039;}
    &lt;/a&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/modal-gallery.tpl:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;img src=&quot;/media/images/news/{$images[img].image_img}&quot; class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$images[img].image_img}
    &lt;img src=&quot;{$images[img].image_img}&quot; class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;
{else}
    &lt;img src=&quot;/media/images/news/{$images[img].image_img}&quot; class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/main-img.tpl:39
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;h1 class=&quot;main-title my-0&quot;&gt; {$news[0].titulo}
    &lt;small class=&quot;mt-3&quot;&gt; {$news[0].ciudad} &middot; {$news[0].provincia}&lt;/small&gt;
    &lt;span&gt; {$similares|count} {$lng_propiedades}&lt;/span&gt;
&lt;/h1&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $news[0].titulo_prom != &#039;&#039;}
    {$news[0].titulo_prom}
{else}
    {$news[0].titulo}
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:246
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;destacado_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;destacado_nws&quot;, &quot;0&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;destacado_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;destacado_nws&quot;, &quot;0&quot;);
$ins_news-&gt;addColumn(&quot;destacado_propm_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;destacado_propm_nws&quot;, &quot;0&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:269
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;destacado_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;destacado_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;destacado_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;destacado_nws&quot;);
$upd_news-&gt;addColumn(&quot;destacado_propm_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;destacado_propm_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:391
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

 &lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
       &lt;input type=&quot;checkbox&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsnews[&#039;activate_nws&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
       &lt;label class=&quot;form-check-label&quot; for=&quot;activate_nws&quot;&gt;
         &lt;?php __(&#039;Activar la propiedad&#039;); ?&gt;&lt;/label&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;activate_nws&quot;); ?&gt;
   &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

 &lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
       &lt;input type=&quot;checkbox&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsnews[&#039;activate_nws&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
       &lt;label class=&quot;form-check-label&quot; for=&quot;activate_nws&quot;&gt;
         &lt;?php __(&#039;Activar la propiedad&#039;); ?&gt;&lt;/label&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;activate_nws&quot;); ?&gt;
   &lt;/div&gt;

&lt;/div&gt;
&lt;div class=&quot;col-lg-3&quot;&gt;

 &lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
       &lt;input type=&quot;checkbox&quot; name=&quot;destacado_propm_nws&quot; id=&quot;destacado_propm_nws&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsnews[&#039;destacado_propm_nws&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
       &lt;label class=&quot;form-check-label&quot; for=&quot;destacado_propm_nws&quot;&gt;
         &lt;?php __(&#039;Destacar la promoci&oacute;n&#039;); ?&gt;&lt;/label&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;destacado_propm_nws&quot;); ?&gt;
   &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:215
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_Default_ManyToMany trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_Default_ManyToMany trigger

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand
function Trigger_SetOrderColumn(&amp;$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj-&gt;setFieldName(&quot;ordenr_nws&quot;);
  return $orderFieldObj-&gt;Execute();
}
//end Trigger_SetOrderColumn trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:233
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);
$ins_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_SetOrderColumn&quot;, 50);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/news.php:310
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
ORDER BY news.date_nws DESC
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
ORDER BY news.order_nws ASC
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:309
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsnews = mysqli_num_rows($rsnews);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsnews = mysqli_num_rows($rsnews);

function getPromotor($id) {
    global $inmoconn;

    $query_rsProperties = &quot;SELECT * FROM properties_properties WHERE promocion_prop = &#039;&quot;.$id.&quot;&#039; AND promocion_prop &gt; 0&quot;;
    $rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
    $row_rsProperties = mysqli_fetch_assoc($rsProperties);
    $totalRows_rsProperties = mysqli_num_rows($rsProperties);

    if ($row_rsProperties[&#039;owner_prop&#039;] &gt; 0) {
        return $row_rsProperties[&#039;owner_prop&#039;];
    }

    return &#039;&#039;;
}

function getAlerts($id) {
    global $inmoconn;

    $query_rsProperties = &quot;SELECT * FROM properties_properties WHERE promocion_prop = &#039;&quot;.$id.&quot;&#039; AND (restr_web_prop = 1 OR restr_nat_port_prop = 1 OR restr_int_port_prop = 1 OR restr_man_contr_prop = 1 OR restr_social_prop = 1 OR restr_int_cli_prop = 1) AND promocion_prop &gt; 0&quot;;
    $rsProperties = mysqli_query($inmoconn,$query_rsProperties) or die(mysqli_error());
    $row_rsProperties = mysqli_fetch_assoc($rsProperties);
    $totalRows_rsProperties = mysqli_num_rows($rsProperties);

    if ($totalRows_rsProperties &gt; 0) {
        return 1;
    }

    return &#039;&#039;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:373
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#tabprops&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
        &lt;?php __(&#039;Propiedades&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#tabprops&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
        &lt;?php __(&#039;Propiedades&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;?php $promotor = getPromotor($news_id); ?&gt;
&lt;?php if ($promotor &gt; 0): ?&gt;
&lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; href=&quot;/intramedianet/properties/owners-form.php?id_pro=&lt;?php echo $promotor ?&gt;&quot; target=&quot;_blank&quot;&gt;
        &lt;?php __(&#039;Banco&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:406
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php echo $tNGs-&gt;getErrorMsg(); ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col&quot;&gt;
    &lt;?php if (getAlerts($news_id) == 1) { ?&gt;
        &lt;div class=&quot;alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
            &lt;i class=&quot;fa-regular fa-circle-exclamation label-icon&quot;&gt;&lt;/i&gt;
            &lt;p class=&quot;my-1&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Esta promoci&oacute;n tiene inmuebles con restricciones&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
        &lt;/div&gt;
        &lt;?php unset($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
    &lt;?php } ?&gt;
&lt;/div&gt;

&lt;?php echo $tNGs-&gt;getErrorMsg(); ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:53
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Titular&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Titular&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Titular&#039;); ?&gt; Website&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;N&ordm; Casas&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Habitaciones&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:62
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws&quot; id=&quot;title_en_nws&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws&quot; id=&quot;title_en_nws&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws2&quot; id=&quot;title_en_nws2&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws3&quot; id=&quot;title_en_nws3&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws4&quot; id=&quot;title_en_nws4&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws5&quot; id=&quot;title_en_nws5&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:79
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td colspan=&quot;3&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td colspan=&quot;7&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:94
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var numCols = 2;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var numCols = 6;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, &#039;title_&#039; . $lang_adm . &#039;_nws&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, &#039;title_&#039; . $lang_adm . &#039;_nws&#039;);
array_push($aColumns, &#039;titulo_prom_&#039; . $lang_adm . &#039;_nws&#039;);
array_push($aColumns, &#039;number_prop&#039;);
array_push($aColumns, &#039;habitaciones_prop&#039;);
array_push($aColumns, &#039;type_prop&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:174
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($aColumns[$i] == &#039;categoria_nws&#039;) {

$sWhere .= &quot; (SELECT category_en_ct FROM news_categories WHERE id_ct = categoria_nws) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;], $_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
} else {
if($aColumns[$i] == &#039;date_nws&#039;) {
  $sWhere .= &quot;DATE_FORMAT(`&quot; . $aColumns[$i] . &quot;`, &#039;%d-%m-%Y %h:%i&#039;) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
} else {
  if($aColumns[$i] == &#039;activate_nws&#039;) {
    if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;S&iacute;&#039;, true)))) {
        $sWhere .= $aColumns[$i].&quot; = &#039;1&#039; &quot;;
    }
    if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;No&#039;, true)))) {
        $sWhere .= $aColumns[$i].&quot; = &#039;0&#039; &quot;;
    }
  }
  else {
    $sWhere .= &quot;`&quot;.$aColumns[$i].&quot;` LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch&#039;]).&quot;%&#039; OR &quot;;
  }
}
}

if($aColumns[$i] == &#039;activate_nws&#039;) {
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;S&iacute;&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;1&#039; &quot;;
}
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;No&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;0&#039; &quot;;
}
} else {
$sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($aColumns[$i] == &#039;activate_nws&#039;) {
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;S&iacute;&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;1&#039; &quot;;
}
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;No&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;0&#039; &quot;;
}
} else {
if($aColumns[$i] == &#039;number_prop&#039;) {
  $sWhere .= &quot;(SELECT COUNT(id_prop) FROM properties_properties WHERE promocion_prop = id_nws LIMIT 1) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
} else {
  if($aColumns[$i] == &#039;habitaciones_prop&#039;) {
    $sWhere .= &quot; &#039;&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;&#039; BETWEEN (SELECT MIN(habitaciones_prop) FROM properties_properties p3 WHERE promocion_prop = id_nws) AND (SELECT MAX(habitaciones_prop) FROM properties_properties p4 WHERE promocion_prop = id_nws) &quot;;
  } else {
    if($aColumns[$i] == &#039;type_prop&#039;) {
      $sWhere .= &quot;(SELECT (SELECT types_&quot;. $lang_adm .&quot;_typ FROM properties_types WHERE id_typ = tipo_prop LIMIT 1) FROM properties_properties WHERE promocion_prop = id_nws LIMIT 1) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
    } else {
      $sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
    }
  }
}
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:213
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$campos = &#039;title_&#039; . $lang_adm . &#039;_nws, &#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$campos = &#039;title_&#039; . $lang_adm . &#039;_nws, &#039;;
$campos .= &#039;titulo_prom_&#039; . $lang_adm . &#039;_nws, &#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:216
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sQuery = &quot;
    SELECT SQL_CALC_FOUND_ROWS
    &quot; . $campos . &quot;
    case activate_nws
        when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
        when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
    end as activate_nws,
    id_nws
    FROM news
    $sWhere
    $sOrder
    $sLimit
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$sQuery = &quot;
    SELECT SQL_CALC_FOUND_ROWS
    &quot; . $campos . &quot;
    (SELECT COUNT(id_prop) FROM properties_properties WHERE promocion_prop = id_nws LIMIT 1) AS number_prop,
    (SELECT CONCAT(MIN(habitaciones_prop), &#039;-&#039;, MAX(habitaciones_prop)) FROM properties_properties WHERE promocion_prop = id_nws LIMIT 1) AS habitaciones_prop,
    (SELECT (SELECT types_&quot;. $lang_adm .&quot;_typ FROM properties_types WHERE id_typ = tipo_prop LIMIT 1) FROM properties_properties WHERE promocion_prop = id_nws LIMIT 1) AS type_prop,
    case activate_nws
        when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
        when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
    end as activate_nws,
    id_nws
    FROM news
    $sWhere
    $sOrder
    $sLimit
&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:113
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsZonas = mysqli_num_rows($rsZonas);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsZonas = mysqli_num_rows($rsZonas);

$query_rsproperties_features = &quot;SELECT properties_features_priv.id_feat, properties_features_priv.feature_&quot;.$lang_adm.&quot;_feat, properties_features_priv.feature_en_feat AS feat, promotions_promotions_feature.promotion FROM properties_features_priv LEFT JOIN promotions_promotions_feature ON (promotions_promotions_feature.feature=properties_features_priv.id_feat AND promotions_promotions_feature.promotion=0123456789) ORDER BY properties_features_priv.feature_&quot;.$lang_adm.&quot;_feat ASC&quot;;
$rsproperties_features = mysqli_query($inmoconn, $query_rsproperties_features) or die(mysqli_error());
$row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
$totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);

$query_rsTags = &quot;SELECT properties_tags.id_tag, properties_tags.tag_&quot;.$lang_adm.&quot;_tag, properties_property_tag.property FROM properties_tags LEFT JOIN properties_property_tag ON (properties_property_tag.tag=properties_tags.id_tag AND properties_property_tag.property=0123456789) ORDER BY properties_tags.tag_&quot;.$lang_adm.&quot;_tag ASC&quot;;
$rsTags = mysqli_query($inmoconn, $query_rsTags) or die(mysqli_error());
$row_rsTags = mysqli_fetch_assoc($rsTags);
$totalRows_rsTags = mysqli_num_rows($rsTags);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:232
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_SetOrderColumn trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_SetOrderColumn trigger

//start Trigger_Default_ManyToMany2 trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany2($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm-&gt;setTable(&quot;promotions_promotions_feature&quot;);
  $mtm-&gt;setPkName(&quot;promotion&quot;);
  $mtm-&gt;setFkName(&quot;feature&quot;);
  $mtm-&gt;setFkReference(&quot;mtm2&quot;);
  return $mtm-&gt;Execute();
}
//end Trigger_Default_ManyToMany2 trigger

//start Trigger_Default_ManyToMany3 trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany3($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm-&gt;setTable(&quot;promotions_promotions_tag&quot;);
  $mtm-&gt;setPkName(&quot;promotion&quot;);
  $mtm-&gt;setFkName(&quot;tag&quot;);
  $mtm-&gt;setFkReference(&quot;mtm3&quot;);
  return $mtm-&gt;Execute();
}
//end Trigger_Default_ManyToMany3 trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:256
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_Default_ManyToMany3 trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_Default_ManyToMany3 trigger

//start Trigger_DeleteDetail5 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail5($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj-&gt;setTable(&quot;promotions_promotions_feature&quot;);
  $tblDelObj-&gt;setFieldName(&quot;promotion&quot;);
  return $tblDelObj-&gt;Execute();
}
//end Trigger_DeleteDetail5 trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2($tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj-&gt;setTable(&quot;promotions_promotions_tag&quot;);
  $tblDelObj-&gt;setFieldName(&quot;promotion&quot;);
  return $tblDelObj-&gt;Execute();
}
//end Trigger_DeleteDetail2 trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile287/intramedianet/promotions/news-form.php:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// $ins_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Default_ManyToMany&quot;, 50);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Default_ManyToMany2&quot;, 50);
$ins_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Default_ManyToMany3&quot;, 50);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:320
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// $upd_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Default_ManyToMany&quot;, 50);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Default_ManyToMany2&quot;, 50);
$upd_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Default_ManyToMany3&quot;, 50);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:354
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$del_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail3&quot;, 99);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$del_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail3&quot;, 99);
$del_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail2&quot;, 99);
$del_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail5&quot;, 99);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:750
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;

&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Etiquetas&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;div class=&quot;row&quot;&gt;
            &lt;?php
            $cnt3 = 0;
            if ($totalRows_rsnews&gt;0) {
            $nested_query_rsTags = str_replace(&quot;123456789&quot;, $row_rsnews[&#039;id_nws&#039;], $query_rsTags);
            $rsTags = mysqli_query($inmoconn, $nested_query_rsTags) or die(mysqli_error());
            $row_rsTags = mysqli_fetch_assoc($rsTags);
            $totalRows_rsTags = mysqli_num_rows($rsTags);
            $nested_sw = false;
            if (isset($row_rsTags) &amp;&amp; is_array($row_rsTags)) {
              do { //Nested repeat
            ?&gt;
                &lt;div class=&quot;col-md-3&quot;&gt;
                    &lt;div class=&quot;form-check form-switch form-switch-md mt-4&quot; dir=&quot;ltr&quot;&gt;
                         &lt;input type=&quot;checkbox&quot; name=&quot;mtm3_&lt;?php echo $row_rsTags[&#039;id_tag&#039;]; ?&gt;&quot; id=&quot;mtm3_&lt;?php echo $row_rsTags[&#039;id_tag&#039;]; ?&gt;&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (row_rsTags[&#039;promotion&#039;] != &quot;&quot;) {?&gt; checked&lt;?php }?&gt;&gt;
                         &lt;label class=&quot;form-check-label&quot; for=&quot;mtm3_&lt;?php echo $row_rsTags[&#039;id_tag&#039;]; ?&gt;&quot;&lt;?php echo $row_rsTags[&#039;tag_&#039;.$lang_adm.&#039;_tag&#039;]; ?&gt;&lt;/label&gt;
                    &lt;/div&gt;
                &lt;/div&gt; &lt;!--/.col-md-4 --&gt;
                &lt;?php
              $cnt3++;
              if ($cnt3%4 == 0) {
                echo &#039;&lt;/div&gt; &lt;!--/.row --&gt;&lt;div class=&quot;row&quot;&gt;&#039;;
              }
            ?&gt;
                &lt;?php
              } while ($row_rsTags = mysqli_fetch_assoc($rsTags)); //Nested move next
            }
          }
        ?&gt;
        &lt;/div&gt; &lt;!--/.row --&gt;
    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:795
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;

 &lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Caracter&iacute;sticas&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;

        &lt;div class=&quot;row&quot;&gt;

        &lt;?php
            $cnt2 = 0;
            if ($totalRows_rsnews&gt;0) {
            $nested_query_rsproperties_features = str_replace(&quot;123456789&quot;, $row_rsnews[&#039;id_nws&#039;], $query_rsproperties_features);

            $rsproperties_features = mysqli_query($inmoconn, $nested_query_rsproperties_features) or die(mysqli_error());
            $row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features);
            $totalRows_rsproperties_features = mysqli_num_rows($rsproperties_features);
            $nested_sw = false;
            if (isset($row_rsproperties_features) &amp;&amp; is_array($row_rsproperties_features)) {
              do { //Nested repeat
                $fatHab = [&#039;Parking&#039;, &#039;Elevator&#039;, &#039;Community pool&#039;, &#039;Community garage&#039;, &#039;Community gym&#039;, &#039;Community garden&#039;, &#039;Community spa&#039;, &#039;Safe urbanization&#039;, &#039;Playground&#039;, &#039;City views&#039;, &#039;Mountain views&#039;, &#039;Sea views&#039;, &#039;Frontline beach&#039;, &#039;Near sea&#039;, &#039;School&#039;, &#039;Green areas&#039;, &#039;Golf&#039;, &#039;Hospital&#039;, &#039;Solarium&#039;, &#039;Private garage:&#039;, &#039;Private parking:&#039;, &#039;Private pool&#039;, &#039;Gym&#039;, &#039;Spa&#039;, &#039;Kitchen:&#039;, &#039;Air conditioner&#039;, &#039;Pre-air conditioner&#039;, &#039;Home automation&#039;, &#039;Floor heating&#039;, &#039;Alarm&#039;, &#039;Built-in cabinets&#039;, &#039;Garden&#039;, &#039;Basement&#039;, &#039;Storage room&#039;];
                if (in_array($row_rsproperties_features[&#039;feat&#039;], $fatHab)) {
            ?&gt;
                &lt;div class=&quot;col-md-4&quot;&gt;

                    &lt;div class=&quot;form-check form-switch form-switch-md my-2&quot; dir=&quot;ltr&quot;&gt;
                        &lt;input type=&quot;checkbox&quot; name=&quot;mtm2_&lt;?php echo $row_rsproperties_features[&#039;id_feat&#039;]; ?&gt;&quot; id=&quot;mtm2_&lt;?php echo $row_rsproperties_features[&#039;id_feat&#039;]; ?&gt;&quot; value=&quot;1&quot; &lt;?php if ($row_rsproperties_features[&#039;promotion&#039;] != &quot;&quot;) {?&gt; checked&lt;?php }?&gt; class=&quot;form-check-input&quot;&gt;
                        &lt;label class=&quot;form-check-label&quot; for=&quot;mtm2_&lt;?php echo $row_rsproperties_features[&#039;id_feat&#039;]; ?&gt;&quot;&gt;&lt;?php echo $row_rsproperties_features[&#039;feature_&#039;.$lang_adm.&#039;_feat&#039;]; ?&gt;&lt;/label&gt;
                        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;solarium_prop&quot;); ?&gt;
                    &lt;/div&gt;

                &lt;/div&gt; &lt;!--/.col-md-4 --&gt;
                &lt;?php
              $cnt2++;
              if ($cnt2%3 == 0) {
                echo &#039;&lt;/div&gt; &lt;!--/.row --&gt;&lt;div class=&quot;row&quot;&gt;&#039;;
              }
            ?&gt;
                &lt;?php
                }
              } while ($row_rsproperties_features = mysqli_fetch_assoc($rsproperties_features)); //Nested move next
            }
          }
        ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/new.php:367
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;files&quot;, $files);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;files&quot;, $files);

$features = getRecords(&quot;

    SELECT CASE WHEN properties_features.feature_&quot;.$lang.&quot;_feat IS NOT NULL THEN properties_features.feature_&quot;.$lang.&quot;_feat ELSE features.feature_&quot;.$lang.&quot;_feat  END AS feat
    FROM promotions_promotions_feature INNER JOIN properties_features features ON promotions_promotions_feature.feature = features.id_feat LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
    WHERE promotions_promotions_feature.promotion = &#039;&quot;.simpleSanitize(($tokens[1])).&quot;&#039; ORDER BY properties_features.order_feat ASC&quot;);

$smarty-&gt;assign(&quot;features&quot;, $features);

$tagsProm = getRecords(&quot;
    SELECT
    properties_tags.tag_&quot; . $lang . &quot;_tag as tag,
    properties_tags.id_tag,
    properties_tags.color_tag,
    properties_tags.text_color_tag
    FROM
    promotions_promotions_tag
    JOIN properties_tags
    ON promotions_promotions_tag.tag = properties_tags.id_tag
    WHERE
    promotions_promotions_tag.promotion = &#039;&quot; . simpleSanitize(($tokens[1])) . &quot;&#039;
&quot;);

$smarty-&gt;assign(&quot;tags&quot;, $tagsProm);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/new.php:998
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$precioReferencia = getRecords(&quot;

SELECT

    MIN(preci_reducidoo_prop) as precio_desde,
    lat_long_gp_prop,
    zoom_gp_prop,
    id_prop

    FROM properties_properties

    WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = &quot; . simpleSanitize(($tokens[1])) . &quot;

LIMIT 1

&quot;);

if ($precioReferencia[0][&#039;precio_desde&#039;]) {
    $smarty-&gt;assign(&quot;precioReferencia&quot;, $precioReferencia[0][&#039;precio_desde&#039;]);
}

if ($precioReferencia[0][&#039;lat_long_gp_prop&#039;]) {
    $smarty-&gt;assign(&quot;localizacionReferencia&quot;, $precioReferencia[0][&#039;lat_long_gp_prop&#039;]);
}
if ($precioReferencia[0][&#039;zoom_gp_prop&#039;]) {
    $smarty-&gt;assign(&quot;zoomReferencia&quot;, $precioReferencia[0][&#039;zoom_gp_prop&#039;]);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$precioReferencia = getRecords(&quot;

SELECT

    MIN(preci_reducidoo_prop) as precio_desde,
    MIN(m2_utiles_prop) as m2_min,
    MAX(m2_utiles_prop) as m2_max,
    MIN(m2_prop) as m2b_min,
    MAX(m2_prop) as m2b_max,
    MIN(habitaciones_prop) as beds_min,
    MAX(habitaciones_prop) as beds_max,
    MIN(aseos_prop) as baths_min,
    MAX(aseos_prop) as baths_max,
    (SELECT pool_&quot; . $lang . &quot;_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_&quot; . $lang . &quot;_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    lat_long_gp_prop,
    zoom_gp_prop,
    id_prop

    FROM properties_properties

    WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = &quot; . simpleSanitize(($tokens[1])) . &quot;

LIMIT 1

&quot;);

if ($precioReferencia[0][&#039;precio_desde&#039;]) {
    $smarty-&gt;assign(&quot;precioReferencia&quot;, $precioReferencia[0][&#039;precio_desde&#039;]);
}

if ($precioReferencia[0][&#039;lat_long_gp_prop&#039;]) {
    $smarty-&gt;assign(&quot;localizacionReferencia&quot;, $precioReferencia[0][&#039;lat_long_gp_prop&#039;]);
}
if ($precioReferencia[0][&#039;zoom_gp_prop&#039;]) {
    $smarty-&gt;assign(&quot;zoomReferencia&quot;, $precioReferencia[0][&#039;zoom_gp_prop&#039;]);
}

$smarty-&gt;assign(&quot;precioReferenciaVals&quot;, $precioReferencia);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/new.tpl:12
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{* @group SEC - BOTONES *}
{include file=&quot;file:modules/promociones/view/partials/botonera.tpl&quot; }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{section name=tg loop=$tags}
    {if $tags[tg].tag != &#039;&#039;}
        &lt;div class=&quot;badge badge-info label-{$tags[tg].id_tag}&quot;&gt;{$tags[tg].tag}&lt;/div&gt;
    {/if}
{/section}

{* @group SEC - BOTONES *}
{include file=&quot;file:modules/promociones/view/partials/botonera.tpl&quot; }
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/nav-tabs.tpl:22
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $news[0].tags != &#039;&#039;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $features[0].feat != &#039;&#039;}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/tabs-panels.tpl:21
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $news[0].tags != &#039;&#039;}
    &lt;div class=&quot;tab-pane&quot; id=&quot;pane-caracteristicas&quot;&gt;
        {include file=&quot;file:modules/promociones/view/partials/tab-caracteristicas.tpl&quot; }
    &lt;/div&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $features[0].feat != &#039;&#039;}
    &lt;div class=&quot;tab-pane&quot; id=&quot;pane-caracteristicas&quot;&gt;
        {include file=&quot;file:modules/promociones/view/partials/tab-caracteristicas.tpl&quot; }
    &lt;/div&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:648
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
/////////////////////////////////////////////////////////////////////////////////////////
// Zonas
/////////////////////////////////////////////////////////////////////////////////////////
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
/////////////////////////////////////////////////////////////////////////////////////////
// Promociones destacadas
/////////////////////////////////////////////////////////////////////////////////////////

$featProms = getRecords(&quot;

    SELECT news.id_nws,
        news.title_&quot;.$lang.&quot;_nws as titulo,
        news.titulo_prom_&quot;.$lang.&quot;_nws as titulo_prom,
        news.titlew_&quot;.$lang.&quot;_nws as titulometa,
        news.content_&quot;.$lang.&quot;_nws as contenido,
        news.tags_&quot;.$lang.&quot;_nws as tags,
        news.quick_price_from_nws as price,

        quick_province_nws as province,
        quick_town_nws as ciudad,

        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
        (SELECT alt_&quot;.$lang.&quot;_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt,
        (SELECT COUNT(*) FROM properties_properties WHERE promocion_prop = news.id_nws) AS total_properties,
        (SELECT MIN(preci_reducidoo_prop) as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws) AS precio_desde

    FROM news
    WHERE news.title_&quot;.$lang.&quot;_nws  != &#039;&#039; AND news.content_&quot;.$lang.&quot;_nws != &#039;&#039; AND type_nws = 999 AND activate_nws = 1 AND destacado_nws = 0 AND destacado_propm_nws = 1

    ORDER BY news.order_nws DESC

    LIMIT 9
&quot;);

$smarty-&gt;assign(&quot;featProms&quot;, $featProms);

/////////////////////////////////////////////////////////////////////////////////////////
// Zonas
/////////////////////////////////////////////////////////////////////////////////////////
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl
            </code>
        </pre>
        Poner donde queramos que se muestre el carrusel de promociones destacadas:
        <pre>
            <code class="php">
{* @group SEC - PROMOCIONES DESTACADAS *}
{if $seccion == &#039;&#039; &amp;&amp; isset($featProms[0]) &amp;&amp; $featProms[0].id_nws != &#039;&#039;}
&lt;div id=&quot;featProms-properties&quot;&gt;
    &lt;div class=&quot;container&quot;&gt;
        &lt;div class=&quot;row&quot;&gt;
            &lt;div class=&quot;col-md-12&quot;&gt;
                &lt;h2 class=&quot;main-title&quot;&gt;{$lng_promociones_destacadas}&lt;/h2&gt;
            &lt;/div&gt;
            &lt;div class=&quot;col-md-12 px-md-0&quot;&gt;

                &lt;div class=&quot;slides&quot;&gt;
                    {section name=ft loop=$featProms}
                        {include file=&quot;file:modules/promociones/view/partials/noticia.tpl&quot; resource=$featProms[ft]}
                    {/section}
                &lt;/div&gt;

            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class=&quot;text-center mt-5 mb-5&quot;&gt;
            &lt;a href=&quot;{$urlStart}{$url_promociones}/&quot; class=&quot;btn btn-primary&quot;&gt;{$lng_ver_todas_las_promociones}&lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:319
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&quot;#featured-properties .slides, #ofertas-properties .slides, #similares-properties .slides&quot;).slick({
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&quot;#featured-properties .slides, #ofertas-properties .slides, #featProms-properties .slides, #similares-properties .slides&quot;).slick({
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/news.php:284
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$news = getRecords(&quot;

    SELECT news.id_nws,
        news.title_&quot;.$lang.&quot;_nws as titulo,
        news.titulo_prom_&quot;.$lang.&quot;_nws as titulo_prom,
        news.titlew_&quot;.$lang.&quot;_nws as titulometa,
        news.content_&quot;.$lang.&quot;_nws as contenido,
        news.tags_&quot;.$lang.&quot;_nws as tags,
        news.quick_price_from_nws as price,

        quick_province_nws as province,
        quick_town_nws as ciudad,

        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
        (SELECT alt_&quot;.$lang.&quot;_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt,
        (SELECT COUNT(*) FROM properties_properties WHERE promocion_prop = news.id_nws) AS total_properties,
        (SELECT MIN(preci_reducidoo_prop) as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws) AS precio_desde

    FROM news
    WHERE news.title_&quot;.$lang.&quot;_nws  != &#039;&#039; AND news.content_&quot;.$lang.&quot;_nws != &#039;&#039; AND type_nws = 999 AND activate_nws = 1 AND destacado_nws = 0

    $tgs

    $ct

    ORDER BY news.order_nws DESC

    LIMIT $cp, $tp
&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$bd = &#039;&#039;;
if (isset($_GET[&#039;bd&#039;]) &amp;&amp; $_GET[&#039;bd&#039;] != &#039;&#039;) {
    $bd .= &quot; AND &#039;&quot;. simpleSanitize($_GET[&#039;bd&#039;]) .&quot;&#039; BETWEEN (SELECT MIN(habitaciones_prop) FROM properties_properties p3 WHERE promocion_prop = id_nws) AND (SELECT MAX(habitaciones_prop) FROM properties_properties WHERE promocion_prop = id_nws) &quot;;
}

$typ = &#039;&#039;;
if (isset($_GET[&#039;tp&#039;]) &amp;&amp; $_GET[&#039;tp&#039;] != &#039;&#039;) {
   $idType = simpleSanitize($_GET[&#039;tp&#039;]);
   $typ = &quot; AND EXISTS (
       SELECT 1
       FROM properties_properties p
       LEFT JOIN properties_types t ON p.tipo_prop = t.id_typ
       WHERE
           p.promocion_prop = id_nws
           AND p.activado_prop = 1
           AND p.alquilado_prop = 0
           AND p.vendido_prop = 0
           AND p.force_hide_prop != 1
           AND (
               p.tipo_prop = &#039;{$idType}&#039;
               OR t.parent_typ = &#039;{$idType}&#039;
           )
   )&quot;;
}

$prdsp = &#039;&#039;;
if (isset($_GET[&#039;prdsp&#039;]) &amp;&amp; $_GET[&#039;prdsp&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prdsp&#039;] &gt; 0) {
    $prdsp = &quot;AND (SELECT preci_reducidoo_prop as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws LIMIT 1) &gt;= &quot; . simpleSanitize(($_GET[&#039;prdsp&#039;]));
}

$prhsp = &#039;&#039;;
if (isset($_GET[&#039;prhsp&#039;]) &amp;&amp; $_GET[&#039;prhsp&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prhsp&#039;] &gt; 0) {
    $prhsp = &quot;AND (SELECT preci_reducidoo_prop as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws LIMIT 1) &lt;= &quot; . simpleSanitize(($_GET[&#039;prhsp&#039;])) .&quot; AND (SELECT preci_reducidoo_prop as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws LIMIT 1)  &gt; 0&quot;;
}

$coast = &#039;&#039;;
if (isset($_GET[&#039;coast&#039;]) &amp;&amp; $_GET[&#039;coast&#039;] != &#039;&#039;) {
    $coast = &quot; AND (SELECT CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3 WHERE promocion_prop = id_nws LIMIT 1) = &#039;&quot; . simpleSanitize($_GET[&#039;coast&#039;]) . &quot;&#039;&quot;;
}

$ct = &#039;&#039;;
if (isset($_GET[&#039;loct&#039;]) &amp;&amp; $_GET[&#039;loct&#039;] != &#039;&#039;) {
    $ct = &quot; AND (SELECT CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3 WHERE promocion_prop = id_nws LIMIT 1) = &#039;&quot; . simpleSanitize($_GET[&#039;loct&#039;]) . &quot;&#039;&quot;;
}

$news = getRecords(&quot;

    SELECT news.id_nws,
        news.title_&quot;.$lang.&quot;_nws as titulo,
        news.titulo_prom_&quot;.$lang.&quot;_nws as titulo_prom,
        news.titlew_&quot;.$lang.&quot;_nws as titulometa,
        news.content_&quot;.$lang.&quot;_nws as contenido,
        news.tags_&quot;.$lang.&quot;_nws as tags,
        news.quick_price_from_nws as price,

        quick_province_nws as province,
        quick_town_nws as ciudad,

        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
        (SELECT alt_&quot;.$lang.&quot;_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt,
        (SELECT COUNT(*) FROM properties_properties WHERE promocion_prop = news.id_nws) AS total_properties,
        (SELECT MIN(preci_reducidoo_prop) as precio_desde FROM properties_properties WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND promocion_prop = id_nws) AS precio_desde

    FROM news
    WHERE news.title_&quot;.$lang.&quot;_nws  != &#039;&#039; AND news.content_&quot;.$lang.&quot;_nws != &#039;&#039; AND type_nws = 999 AND activate_nws = 1 AND destacado_nws = 0

    $bd $typ $prdsp $prhsp $coast $ct

    $tgs

    $ct

    ORDER BY news.order_nws ASC

    LIMIT $cp, $tp
&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/index.tpl:12
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;page-content&quot;&gt;
    &lt;div class=&quot;container&quot;&gt;
        &lt;div class=&quot;row gx-5 mt-5 mx-md-2 mx-lg-4&quot;&gt;
            {if $news[0].titulo != &#039;&#039;}
                &lt;div class=&quot;col-md-12&quot;&gt;
                    &lt;h2 class=&quot;main-title mt-2&quot;&gt;{$pages[0].titulo}&lt;/h2&gt;
                &lt;/div&gt;
                {section name=nw loop=$news}
                    &lt;div class=&quot;col-md-6 mb-3 mb-md-4&quot;&gt;
                        {include file=&quot;file:modules/promociones/view/partials/noticia.tpl&quot; resource=$news[nw]}
                    &lt;/div&gt;
                {/section}

                {* @group SEC - PAGINACI&Oacute;N *}
                &lt;div class=&quot;pagination text-center d-flex justify-content-center flex-wrap mb-5&quot;&gt;
                    {include file=&quot;file:modules/properties/view/partials/pagination.tpl&quot;}
                &lt;/div&gt;
            {/if}
        &lt;/div&gt;
        &lt;div class=&quot;row justify-content-center&quot;&gt;
            &lt;div class=&quot;col-10 col-md-4 col-xl-4 d-grid&quot;&gt;
                &lt;a href=&quot;{$urlStart}{$url_properties}-{slug(getFromArray($status, 2, &#039;id&#039;, &#039;sale&#039;))}/&quot;
                    class=&quot;btn btn-primary&quot;&gt;{$lng_ver_toda_la_obra_nueva}&lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;page-content&quot;&gt;
    &lt;div class=&quot;container&quot;&gt;
        &lt;div class=&quot;row gx-5 mt-5 mx-md-2 mx-lg-4&quot;&gt;
                &lt;div class=&quot;col-md-12&quot;&gt;
                    &lt;h2 class=&quot;main-title mt-2&quot;&gt;{$pages[0].titulo}&lt;/h2&gt;
                &lt;/div&gt;
            &lt;div class=&quot;row mb-5&quot;&gt;
                &lt;div class=&quot;col&quot;&gt;
                    &lt;form action=&quot;{$urlStart}{$url_promociones}/&quot; method=&quot;get&quot; id=&quot;searchProms&quot; role=&quot;form&quot; class=&quot;validate&quot;&gt;
                        &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3&quot;&gt;
                                    &lt;select name=&quot;coast&quot; id=&quot;coast&quot; class=&quot;form-control&quot;&gt;
                                        &lt;option value=&quot;&quot;&gt;{$lng_costa}&lt;/option&gt;
                                        {section name=lz loop=$coast}
                                            {if isset($coast[lz].coast) &amp;&amp; $coast[lz].coast != &#039;&#039;}
                                                &lt;option value=&quot;{$coast[lz].id}&quot; {if isset($smarty.get.coast) &amp;&amp; in_array($coast[lz].id, $smarty.get.coast)}selected{/if}&gt;{$coast[lz].coast}&lt;/option&gt;
                                            {/if}
                                        {/section}
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3&quot;&gt;
                                    &lt;select name=&quot;loct&quot; id=&quot;loct&quot; class=&quot;form-control&quot;&gt;
                                        &lt;option value=&quot;&quot;&gt;{$lng_ciudad}&lt;/option&gt;
                                        {section name=lz loop=$cityPromo}
                                        &lt;option value=&quot;{$cityPromo[lz].id}&quot; {if isset($smarty.get.loct) &amp;&amp;  in_array($cityPromo[lz].id, $smarty.get.loct)}selected{/if}&gt;{$cityPromo[lz].area}&lt;/option&gt;
                                        {/section}
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3&quot;&gt;
                                    &lt;select name=&quot;tp&quot; id=&quot;tp&quot; class=&quot;form-control&quot;&gt;
                                        &lt;option value=&quot;&quot; {if $smarty.get.tp == &#039;&#039;}selected{/if}&gt;{$lng_tipo}&lt;/option&gt;
                                        {section name=tp loop=$typePromo}
                                            {if {$typePromo[tp].type} != &#039;Array&#039;}
                                                &lt;option value=&quot;{$typePromo[tp].id_type}&quot; {if $smarty.get.tp == $typePromo[tp].id_type}selected{/if}&gt;{$typePromo[tp].type}&lt;/option&gt;
                                            {/if}
                                        {/section}
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3&quot;&gt;
                                    &lt;select name=&quot;prdsp&quot; id=&quot;prdsp&quot; class=&quot;form-control prdsp&quot;&gt;
                                        &lt;option value=&quot;&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == &#039;&#039;}selected{/if}&gt;{$lng_precio_desde}&lt;/option&gt;
                                        &lt;option value=&quot;50000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 50000}selected{/if}&gt;50.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;100000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == &#039;100000&#039;}selected{/if}&gt;100.000&euro;&lt;/option&gt;
                                        &lt;option value=&quot;150000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 150000}selected{/if}&gt;150.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;200000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 200000}selected{/if}&gt;200.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;250000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 250000}selected{/if}&gt;250.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;300000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 300000}selected{/if}&gt;300.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;350000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 350000}selected{/if}&gt;350.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;400000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 400000}selected{/if}&gt;400.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;450000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 450000}selected{/if}&gt;450.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;500000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 500000}selected{/if}&gt;500.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;550000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 550000}selected{/if}&gt;550.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;600000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 600000}selected{/if}&gt;600.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;650000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 650000}selected{/if}&gt;650.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;700000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 700000}selected{/if}&gt;700.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;800000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 800000}selected{/if}&gt;800.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;900000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 900000}selected{/if}&gt;900.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;1000000&quot; {if isset($smarty.get.prdsp) &amp;&amp; $smarty.get.prdsp == 1000000}selected{/if}&gt;1.000.000 &euro;&lt;/option&gt;
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3&quot;&gt;
                                    &lt;select name=&quot;prhsp&quot; id=&quot;prhsp&quot; class=&quot;form-control prhsp&quot;&gt;
                                        &lt;option value=&quot;&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == &quot;&quot;}selected{/if}&gt;{$lng_precio_hasta}&lt;/option&gt;
                                        &lt;option value=&quot;50000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 50000}selected{/if}&gt;50.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;100000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == &#039;100000&#039;}selected{/if}&gt;100.000&euro;&lt;/option&gt;
                                        &lt;option value=&quot;150000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 150000}selected{/if}&gt;150.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;200000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 200000}selected{/if}&gt;200.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;250000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 250000}selected{/if}&gt;250.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;300000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 300000}selected{/if}&gt;300.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;350000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 350000}selected{/if}&gt;350.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;400000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 400000}selected{/if}&gt;400.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;450000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 450000}selected{/if}&gt;450.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;500000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 500000}selected{/if}&gt;500.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;550000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 550000}selected{/if}&gt;550.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;600000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 600000}selected{/if}&gt;600.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;650000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 650000}selected{/if}&gt;650.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;700000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 700000}selected{/if}&gt;700.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;800000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 800000}selected{/if}&gt;800.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;900000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 900000}selected{/if}&gt;900.000 &euro;&lt;/option&gt;
                                        &lt;option value=&quot;1000000&quot; {if isset($smarty.get.prhsp) &amp;&amp; $smarty.get.prhsp == 1000000}selected{/if}&gt;+1.000.000 &euro;&lt;/option&gt;
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3&quot;&gt;
                                    &lt;select name=&quot;bd&quot; id=&quot;bd&quot; class=&quot;form-control&quot;&gt;
                                        &lt;option value=&quot;&quot; {if isset($smarty.get.bd) &amp;&amp; $smarty.get.bd == &#039;&#039;}selected{/if}&gt;{$lng_habitaciones}&lt;/option&gt;
                                        {for $i=1 to 25}
                                        &lt;option value=&quot;{$i}&quot; {if isset($smarty.get.bd) &amp;&amp; $smarty.get.bd == $i}selected{/if}&gt;{if $i == 25}+{/if}{$i}&lt;/option&gt;
                                        {/for}
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3 d-grid&quot;&gt;
                                    &lt;button type=&quot;submit&quot; class=&quot;btn btn-primary&quot;&gt;{$lng_buscar}&lt;/button&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-4&quot;&gt;
                                &lt;div class=&quot;form-group mb-3 d-grid&quot;&gt;
                                  &lt;a href=&quot;{$urlStart}{$url_promociones}/&quot; class=&quot;btn btn-light&quot;&gt;
                                      Reset
                                  &lt;/a&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                    &lt;/form&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            {if $news[0].titulo != &#039;&#039;}
                {section name=nw loop=$news}
                    &lt;div class=&quot;col-md-6 mb-3 mb-md-4&quot;&gt;
                        {include file=&quot;file:modules/promociones/view/partials/noticia.tpl&quot; resource=$news[nw]}
                    &lt;/div&gt;
                {/section}
                {* @group SEC - PAGINACI&Oacute;N *}
                &lt;div class=&quot;pagination text-center d-flex justify-content-center flex-wrap mb-5&quot;&gt;
                    {include file=&quot;file:modules/properties/view/partials/pagination.tpl&quot;}
                &lt;/div&gt;

            {else}
                &lt;br&gt;
                &lt;br&gt;
                &lt;br&gt;
                &lt;p class=&quot;lead text-center&quot;&gt;{$lng_no_se_hean_encontrado_inmuebles_que_coincidan_con_su_busqueda}.&lt;/p&gt;
                &lt;br&gt;
                &lt;br&gt;
                &lt;br&gt;
            {/if}
        &lt;/div&gt;
        &lt;div class=&quot;row justify-content-center&quot;&gt;
            &lt;div class=&quot;col-10 col-md-4 col-xl-4 d-grid&quot;&gt;
                &lt;a href=&quot;{$urlStart}{$url_properties}-{slug(getFromArray($status, 2, &#039;id&#039;, &#039;sale&#039;))}/&quot;
                    class=&quot;btn btn-primary&quot;&gt;{$lng_ver_toda_la_obra_nueva}&lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/_js/pages-form.js:229
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns += &#039;&lt;li&gt;&lt;a href=&quot;properties-form.php?id_prop=&#039; + data + &#039;&amp;amp;KT_back=1&quot; target=&quot;_blank&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + dtEditar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns += &#039;&lt;li&gt;&lt;a href=&quot;../properties/properties-form.php?id_prop=&#039; + data + &#039;&amp;amp;KT_back=1&quot; target=&quot;_blank&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + dtEditar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/_js/pages-form.js:233
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns += &#039;&lt;li&gt;&lt;a href=&quot;properties-form.php?id_prop=&#039; + data + &#039;&amp;amp;KT_back=1&amp;amp;KT_Delete1=1&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns += &#039;&lt;li&gt;&lt;a href=&quot;../properties/properties-form.php?id_prop=&#039; + data + &#039;&amp;amp;KT_back=1&amp;amp;KT_Delete1=1&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:601
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
/////////////////////////////////////////////////////////////////////////////////////////
// Zonas
/////////////////////////////////////////////////////////////////////////////////////////
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
/////////////////////////////////////////////////////////////////////////////////////////
// Buscador promociones
/////////////////////////////////////////////////////////////////////////////////////////

$cityPromoQuery = &quot;
   SELECT DISTINCT
       CASE
           WHEN properties_loc3.name_&quot; . $lang . &quot;_loc3 IS NOT NULL
           THEN properties_loc3.name_&quot; . $lang . &quot;_loc3
           ELSE areas1.name_&quot; . $lang . &quot;_loc3
       END AS area,
       CASE
           WHEN properties_loc3.id_loc3 IS NOT NULL
           THEN properties_loc3.id_loc3
           ELSE areas1.id_loc3
       END AS id
   FROM properties_loc4 towns
   LEFT JOIN properties_properties p ON p.localidad_prop = towns.id_loc4
   LEFT JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
   LEFT JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
   LEFT JOIN news n ON p.promocion_prop = n.id_nws
   WHERE
       p.activado_prop = 1
       AND p.alquilado_prop = 0
       AND p.vendido_prop = 0
       AND p.force_hide_prop != 1
       AND n.activate_nws = 1
       AND n.type_nws = 999
   GROUP BY id
   ORDER BY area ASC
&quot;;
$smarty-&gt;assign(&quot;cityPromo&quot;, getRecordsAndCache($cityPromoQuery, &#039;city-promo-search&#039;));

$typePromoQuery = &quot;
   SELECT DISTINCT
       CASE
           WHEN properties_types.types_&quot; . $lang . &quot;_typ IS NOT NULL
               THEN properties_types.types_&quot; . $lang . &quot;_typ
           ELSE types.types_&quot; . $lang . &quot;_typ
       END AS type,
       CASE
           WHEN properties_types.id_typ IS NOT NULL
               THEN properties_types.id_typ
           ELSE types.id_typ
       END AS id_type
   FROM properties_properties p
   INNER JOIN properties_types types ON p.tipo_prop = types.id_typ
   LEFT JOIN properties_types ON types.parent_typ = properties_types.id_typ
   INNER JOIN news n ON p.promocion_prop = n.id_nws
   WHERE
       p.activado_prop = 1
       AND p.alquilado_prop = 0
       AND p.vendido_prop = 0
       AND p.force_hide_prop != 1
       AND n.activate_nws = 1
       AND n.type_nws = 999
   GROUP BY id_type
   ORDER BY type ASC
&quot;;
$smarty-&gt;assign(&quot;typePromo&quot;, getRecordsAndCache($typePromoQuery, &#039;type-promo-search&#039;));

/////////////////////////////////////////////////////////////////////////////////////////
// Zonas
/////////////////////////////////////////////////////////////////////////////////////////
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/botonera.tpl:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if file_exists(&quot;{$smarty.server.DOCUMENT_ROOT}/media/images/news/{$images[0].image_img}&quot;)}
    &lt;div class=&quot;col-6 col-md-3 col-xl-2&quot;&gt;
        &lt;div class=&quot;d-grid&quot;&gt;
            &lt;a {if $galeriaModal == 1} data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#galleryModalPromo&quot; {/if}
                href=&quot;http://{$smarty.server.HTTP_HOST}/media/images/news/{$images[0].image_img}&quot;
                class=&quot;btn btn-secondary {if $galeriaModal == 0} gallProp {/if}&quot;&gt;
                {$lng_view_all_photos}
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if file_exists(&quot;{$smarty.server.DOCUMENT_ROOT}/media/images/news/{$images[0].image_img}&quot;)}
    &lt;div class=&quot;col-6 col-md-3 col-xl-2&quot;&gt;
        &lt;div class=&quot;d-grid&quot;&gt;
            &lt;a {if $galeriaModal == 1} data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#galleryModalPromo&quot; {/if}
                href=&quot;http://{$smarty.server.HTTP_HOST}/media/images/news/{$images[0].image_img}&quot;
                class=&quot;btn btn-secondary {if $galeriaModal == 0} gallProp {/if}&quot;&gt;
                {$lng_view_all_photos}
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
{/if}

&lt;div class=&quot;col-6 col-md-3 col-xl-2&quot;&gt;
    &lt;div class=&quot;d-grid&quot;&gt;
        &lt;a href=&quot;/modules/promociones/pdf.php?p={$news[0].id_nws}&amp;lang={$lang}&quot; target=&quot;_blank&quot; class=&quot;btn btn-secondary&quot; rel=&quot;nofollow&quot;&gt;{$lng_pdfimprimir}&lt;/a&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:43
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;promotions-order.php&quot; class=&quot;btn btn-primary btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-arrow-up-arrow-down me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ordenar&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;promotions-order.php&quot; class=&quot;btn btn-primary btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-arrow-up-arrow-down me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ordenar&#039;); ?&gt;&lt;/a&gt;
&lt;?php if ($_SESSION[&#039;kt_login_level&#039;] == 9): ?&gt;
&lt;a href=&quot;/intramedianet/promotions/promotions-all-download-csv.php&quot; class=&quot;btn btn-primary btn-sm &quot;&gt;&lt;i class=&quot;fa-regular fa-file-excel me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Descargar para Excel&#039;); ?&gt;&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php:138
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if(!function_exists(&quot;showThumbnail&quot;)) {
    function showThumbnail($image, $path, $width, $height, $alt = null, $class = null) {

        $image = preg_replace(&#039;/\?.*/&#039;, &#039;&#039;, $image);

        $fileName = basename($image);


        $thumbImg = &#039;&#039;;

        $pathInfo = pathinfo($image);
        $paths[&#039;filePath&#039;] = $pathInfo[&#039;dirname&#039;];
        $paths[&#039;fileExt&#039;] = $pathInfo[&#039;extension&#039;];
        $paths[&#039;fileBasename&#039;] = $pathInfo[&#039;filename&#039;] ? $pathInfo[&#039;filename&#039;] : substr($fileName ,0,strrpos($fileName ,&#039;.&#039;));
        $paths[&#039;fileSrc&#039;] = $path . &#039;&#039; . $fileName;
        $paths[&#039;cachePath&#039;] = $path. &#039;thumbnails/&#039;;

        $rep = array(&#039;stream.asp?pic=&#039;, &#039;&amp;width=large&#039;, &#039; &#039;, &#039;%&#039;);

        $cachedName = str_replace($rep, &#039;&#039;, md5($image)) . &#039;_&#039; . $width . &#039;x&#039; . $height;
        $cachedName .= &#039;.&#039; . str_replace($rep, &#039;&#039;, $paths[&#039;fileExt&#039;]);
        $cachedPath = $paths[&#039;cachePath&#039;] . $cachedName;

        $noImagePath = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/includes/assets/img/no_image.jpg&#039;;
        $noImageTime = @filemtime($noImagePath);

        $cacheTime = @filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath);

        if (preg_match(&#039;/http:\/\//&#039;, $image) || preg_match(&#039;/https:\/\//&#039;, $image)) {

            $image = str_replace(&quot;https&quot;, &quot;http&quot;, $image);

            if (!is_file($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath)) {

                if (getImageSize(str_replace(&#039; &#039;, &#039;%20&#039;, $image))) {

                    $imageTime = @filemtime(remoteFileData(str_replace(&#039; &#039;, &#039;%20&#039;, $image)));

                    if (!is_file($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath) || $imageTime &gt; $cacheTime) {

                        $thumbImg = str_replace(&#039; &#039;, &#039;%20&#039;, $image);

                    }

                } else {

                    if (!is_file($noImagePath) || $noImageTime &gt; $cacheTime) {

                        $thumbImg = $noImagePath;

                    }




                }

            }

        } else {

            if (file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;])) {

                $imageTime = @filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);

                if (!is_file($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath) || $imageTime &gt; $cacheTime) {

                    $filePath = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;];
                    $fileType = mime_content_type($filePath);
                    $exif = array();
                    if ($fileType == &#039;image/jpeg&#039; || $fileType == &#039;image/tiff&#039;) {
                        // read EXIF header from uploaded file
                        $exif = exif_read_data($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);
                    }
                    //fix the Orientation if EXIF data exist
                    if(!empty($exif[&#039;Orientation&#039;])) {
                        $source = imagecreatefromjpeg($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);
                        switch($exif[&#039;Orientation&#039;]) {
                            case 8:
                                    $rotate = imagerotate($source,90,0);
                                break;
                            case 3:
                                    $rotate = imagerotate($source,180,0);
                                break;
                            case 6:
                                    $rotate = imagerotate($source,-90,0);
                                break;
                        }
                        if ($rotate != &#039;&#039;) {
                            imagejpeg($rotate,$_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);
                        }
                    }

                    $thumbImg = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;];

                }

            } else {

                if (!is_file($noImagePath) || $noImageTime &gt; $cacheTime) {

                    $thumbImg = $noImagePath;

                }

            }

        }

        if ($thumbImg != &#039;&#039;) {

            $thumb = PhpThumbFactory::create($thumbImg, array(&#039;jpegQuality&#039;=&gt;70));
            $thumb-&gt;adaptiveResize($width, $height);
            $thumb-&gt;save($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath);

        }

        return &#039;&lt;img src=&quot;&#039;.$cachedPath.&#039;&quot; width=&quot;&#039;.$width.&#039;&quot; height=&quot;&#039;.$height.&#039;&quot; alt=&quot;&#039;.$alt.&#039;&quot;  class=&quot;&#039;.$class.&#039;&quot; /&gt;&#039;;

    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if(!function_exists(&quot;showThumbnail&quot;)) {
    function showThumbnail($image, $path, $width, $height, $alt = null, $class = null) {

        $image = preg_replace(&#039;/\?.*/&#039;, &#039;&#039;, $image);

        $fileName = basename($image);

        $thumbImg = &#039;&#039;;

        $pathInfo = pathinfo($image);
        $paths[&#039;filePath&#039;] = $pathInfo[&#039;dirname&#039;];
        $paths[&#039;fileExt&#039;] = $pathInfo[&#039;extension&#039;];
        $paths[&#039;fileBasename&#039;] = $pathInfo[&#039;filename&#039;] ? $pathInfo[&#039;filename&#039;] : substr($fileName ,0,strrpos($fileName ,&#039;.&#039;));
        $paths[&#039;fileSrc&#039;] = $path . &#039;&#039; . $fileName;
        $paths[&#039;cachePath&#039;] = $path. &#039;thumbnails/&#039;;

        $rep = array(&#039;stream.asp?pic=&#039;, &#039;&amp;width=large&#039;, &#039; &#039;, &#039;%&#039;);

        $cachedName = str_replace($rep, &#039;&#039;, md5($image)) . &#039;_&#039; . $width . &#039;x&#039; . $height;
        $cachedName .= &#039;.&#039; . str_replace($rep, &#039;&#039;, $paths[&#039;fileExt&#039;]);
        $cachedPath = $paths[&#039;cachePath&#039;] . $cachedName;

        $noImagePath = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/includes/assets/img/no_image.jpg&#039;;
        $noImageTime = @filemtime($noImagePath);

        $cacheTime = @filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath);

        if (preg_match(&#039;/https?:\/\//&#039;, $image)) {

            if (!is_file($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath)) {

                if (getImageSize(str_replace(&#039; &#039;, &#039;%20&#039;, $image))) {

                    $imageTime = @filemtime(remoteFileData(str_replace(&#039; &#039;, &#039;%20&#039;, $image)));

                    if (!is_file($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath) || $imageTime &gt; $cacheTime) {

                        $thumbImg = str_replace(&#039; &#039;, &#039;%20&#039;, $image);

                    }

                } else {

                    if (!is_file($noImagePath) || $noImageTime &gt; $cacheTime) {

                        $thumbImg = $noImagePath;

                    }




                }

            }

        } else {

            if (file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;])) {

                $imageTime = @filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);

                if (!is_file($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath) || $imageTime &gt; $cacheTime) {

                    $filePath = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;];
                    $fileType = mime_content_type($filePath);
                    $exif = array();
                    if ($fileType == &#039;image/jpeg&#039; || $fileType == &#039;image/tiff&#039;) {
                        // read EXIF header from uploaded file
                        $exif = exif_read_data($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);
                    }
                    //fix the Orientation if EXIF data exist
                    if(!empty($exif[&#039;Orientation&#039;])) {
                        $source = imagecreatefromjpeg($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);
                        switch($exif[&#039;Orientation&#039;]) {
                            case 8:
                                    $rotate = imagerotate($source,90,0);
                                break;
                            case 3:
                                    $rotate = imagerotate($source,180,0);
                                break;
                            case 6:
                                    $rotate = imagerotate($source,-90,0);
                                break;
                        }
                        if ($rotate != &#039;&#039;) {
                            imagejpeg($rotate,$_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;]);
                        }
                    }

                    $thumbImg = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . $paths[&#039;fileSrc&#039;];

                }

            } else {

                if (!is_file($noImagePath) || $noImageTime &gt; $cacheTime) {

                    $thumbImg = $noImagePath;

                }

            }

        }

        if ($thumbImg != &#039;&#039;) {

            $thumb = PhpThumbFactory::create($thumbImg, array(&#039;jpegQuality&#039;=&gt;70));
            $thumb-&gt;adaptiveResize($width, $height);
            $thumb-&gt;save($_SERVER[&quot;DOCUMENT_ROOT&quot;] . $cachedPath);

        }

        return &#039;&lt;img src=&quot;&#039;.$cachedPath.&#039;&quot; width=&quot;&#039;.$width.&#039;&quot; height=&quot;&#039;.$height.&#039;&quot; alt=&quot;&#039;.$alt.&#039;&quot;  class=&quot;&#039;.$class.&#039;&quot; /&gt;&#039;;

    }
}
            </code>
        </pre>
        <hr>
        En la carpeta:
        <pre>
            <code class="makefile">
/resources/
            </code>
        </pre>
        Añadir los textos a los idiomas:
        <pre>
            <code class="php">
// Catal&#xe1;n (ca)
$langStr[&quot;Promociones destacadas&quot;][&quot;ca&quot;] = &quot;Promocions destacades&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;ca&quot;] = &quot;Veure totes les promocions&quot;;

// Dan&#xe9;s (da)
$langStr[&quot;Promociones destacadas&quot;][&quot;da&quot;] = &quot;Fremh&#xe6;vede kampagner&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;da&quot;] = &quot;Se alle kampagner&quot;;

// Alem&#xe1;n (de)
$langStr[&quot;Promociones destacadas&quot;][&quot;de&quot;] = &quot;Hervorgehobene Aktionen&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;de&quot;] = &quot;Alle Aktionen ansehen&quot;;

// Ingl&#xe9;s (en)
$langStr[&quot;Promociones destacadas&quot;][&quot;en&quot;] = &quot;Featured promotions&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;en&quot;] = &quot;View all promotions&quot;;

// Espa&#xf1;ol (es)
$langStr[&quot;Promociones destacadas&quot;][&quot;es&quot;] = &quot;Promociones destacadas&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;es&quot;] = &quot;Ver todas las promociones&quot;;

// Fin&#xe9;s (fi)
$langStr[&quot;Promociones destacadas&quot;][&quot;fi&quot;] = &quot;Suositellut kampanjat&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;fi&quot;] = &quot;N&#xe4;yt&#xe4; kaikki kampanjat&quot;;

// Franc&#xe9;s (fr)
$langStr[&quot;Promociones destacadas&quot;][&quot;fr&quot;] = &quot;Promotions en vedette&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;fr&quot;] = &quot;Voir toutes les promotions&quot;;

// Island&#xe9;s (is)
$langStr[&quot;Promociones destacadas&quot;][&quot;is&quot;] = &quot;Valdar kynningar&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;is&quot;] = &quot;Sj&#xe1; allar kynningar&quot;;

// Neerland&#xe9;s (nl)
$langStr[&quot;Promociones destacadas&quot;][&quot;nl&quot;] = &quot;Uitgelichte promoties&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;nl&quot;] = &quot;Bekijk alle promoties&quot;;

// Noruego (no)
$langStr[&quot;Promociones destacadas&quot;][&quot;no&quot;] = &quot;Fremhevede kampanjer&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;no&quot;] = &quot;Se alle kampanjer&quot;;

// Polaco (pl)
$langStr[&quot;Promociones destacadas&quot;][&quot;pl&quot;] = &quot;Polecane promocje&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;pl&quot;] = &quot;Zobacz wszystkie promocje&quot;;

// Ruso (ru)
$langStr[&quot;Promociones destacadas&quot;][&quot;ru&quot;] = &quot;&#x420;&#x435;&#x43a;&#x43e;&#x43c;&#x435;&#x43d;&#x434;&#x443;&#x435;&#x43c;&#x44b;&#x435; &#x430;&#x43a;&#x446;&#x438;&#x438;&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;ru&quot;] = &quot;&#x41f;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x432;&#x441;&#x435; &#x430;&#x43a;&#x446;&#x438;&#x438;&quot;;

// Sueco (se)
$langStr[&quot;Promociones destacadas&quot;][&quot;se&quot;] = &quot;Utvalda kampanjer&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;se&quot;] = &quot;Visa alla kampanjer&quot;;

// Chino simplificado (zh)
$langStr[&quot;Promociones destacadas&quot;][&quot;zh&quot;] = &quot;&#x7cbe;&#x9009;&#x4f18;&#x60e0;&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;zh&quot;] = &quot;&#x67e5;&#x770b;&#x6240;&#x6709;&#x4f18;&#x60e0;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:66
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
(preg_match(&#039;/\/properties\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/map\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) | preg_match(&#039;/\/hystory.php/&#039;, $_SERVER[&#039;PHP_SELF&#039;]). preg_match(&#039;/\/seg.php/&#039;, $_SERVER[&#039;PHP_SELF&#039;]))
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
(preg_match(&#039;/\/properties\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/map\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/promotions\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) | preg_match(&#039;/\/hystory.php/&#039;, $_SERVER[&#039;PHP_SELF&#039;]). preg_match(&#039;/\/seg.php/&#039;, $_SERVER[&#039;PHP_SELF&#039;]))
            </code>
        </pre>
        <hr>
        Añadir al archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Destacar la promoci&oacute;n&#039;] = &#039;Destacar la promoci&oacute;n&#039;;
$lang[&#039;Esta promoci&oacute;n tiene inmuebles con restricciones&#039;] = &#039;Esta promoci&oacute;n tiene inmuebles con restricciones&#039;;
            </code>
        </pre>
        <hr>
        Añadir al archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Destacar la promoci&oacute;n&#039;] = &#039;Highlight the promotion&#039;;
$lang[&#039;Esta promoci&oacute;n tiene inmuebles con restricciones&#039;] = &#039;This promotion has properties with restrictions.&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>