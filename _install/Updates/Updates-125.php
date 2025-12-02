<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-06-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al filtrar en el listado de promociones</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Fix importador Habihub</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Añadido trasteros al expordator de Idealista</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Error en la url por defecto de los quicklinks</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al añadir etiquetas en REDSP v4</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-plus-circle text-success"></i> Actualización a la última versión de Habihub</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al filtrar en el listado de promociones
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:167
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
    $sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:1098
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script src=&quot;/intramedianet/promotions/_js/pages-form.js&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script src=&quot;/intramedianet/promotions/_js/pages-form.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix importador Habihub
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php:146
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query .= &quot;activate_nws = &#039;0, &quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query .= &quot;activate_nws = 0, &quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido trasteros al expordator de Idealista
    </h6>
    <div class="card-body">
        Sustituir el archivo: <code>/intramedianet/properties/idealista/DIC/DIC_Types.php</code>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en la url por defecto de los quicklinks
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/partials/idiomas.tpl:19
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;{if $idm == $lang}{$urlDefault}{else}{if $seccion != &#039;&#039;}{$url{$idm|upper}}{else}{$base_url}/{$idm}/{/if}{/if}&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;{if $idm == $language}{$urlDefault}{else}{if $seccion != &#039;&#039;}{$url{$idm|upper}}{else}{$base_url}/{$idm}/{/if}{/if}&quot;&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al añadir etiquetas en REDSP v4
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils.php:438
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsDeletekPropFeature = &quot;DELETE FROM properties_property_tag WHERE  property = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
$rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
if (!empty($tags)) {
    foreach($tags as $tag) {
        if ((string)$tag &gt; 0) {
            $query = &quot;INSERT INTO properties_property_feature_priv SET &quot;;
            $query .= &quot;property = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
            $query .= &quot;feature = &#039;&quot;.$tag.&quot;&#039;&quot;;
            mysqli_query($inmoconn,$query) or die(mysqli_error());
        }
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsDeletekPropFeature = &quot;DELETE FROM properties_property_tag WHERE  property = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
$rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
if (!empty($tags)) {
    foreach($tags as $tag) {
        if ((string)$tag &gt; 0) {
            $query = &quot;INSERT INTO properties_property_tag SET &quot;;
            $query .= &quot;property = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
            $query .= &quot;tag = &#039;&quot;.$tag.&quot;&#039;&quot;;
            mysqli_query($inmoconn,$query) or die(mysqli_error());
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
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Actualización a la última versión de Habihub
    </h6>
    <div class="card-body">
        <p>Hay que crear estas etiquetas si no están ya en la web (Key ready, Open views, Off plan, Beach, Golf, Village views, Mountain views, Sea views y First line), para poder ajustarlo luego en el importador.</p>
        <p>Hay que asegurarse que en el archivo <code>/intramedianet/xml/importadores/_utils.php</code> ese usa la función <code>savePropertyData</code> modificada en <a href="https://localhost:3000/_install/updates.php?v=Updates-124.php#sec1" target="_blank" class="font-weight-bold"><u>esta actualización de REDSP</u></a></p>
        <p>Hay que añadir este cron:</p>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width: 75px; text-align: center;">Minuto</th>
                    <th style="width: 75px; text-align: center;">Hora</th>
                    <th style="width: 75px; text-align: center;">Día del mes</th>
                    <th style="width: 75px; text-align: center;">Mes</th>
                    <th style="width: 75px; text-align: center;">Día de la semana</th>
                    <th>Archivo</th>
                    <th>Notas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center">*/8</td>
                    <td style="text-align: center">*</td>
                    <td style="text-align: center">*</td>
                    <td style="text-align: center">*</td>
                    <td style="text-align: center">*</td>
                    <td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/_herramientas/generar_planos.php</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <hr>
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_planos` ADD COLUMN `procesada_img` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `id_habihub_prop` INT(11) NULL DEFAULT NULL;
            </code>
        </pre>
        <hr>
        Sobreescribir los archivos:
        <pre>
            <code class="makefile">
/Users/jose/Webs/_Master/public_html/_herramientas/generar_planos.php
/intramedianet/properties/files_list.php
/intramedianet/properties/dfiles_list.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query .= &quot;restr_int_port_prop = &#039;&quot;.(int)$property-&gt;restrictions-&gt;international_portals.&quot;&#039; \n&quot;;
if ($in_database) {
    $query .= &quot;WHERE ref_xml_prop = &#039;&quot;.(string)$property-&gt;ref.&quot;&#039; AND xml_xml_prop = &#039;&quot;.$_GET[&#039;p&#039;].&quot;&#039;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query .= &quot;restr_int_port_prop = &#039;&quot;.(int)$property-&gt;restrictions-&gt;international_portals.&quot;&#039;, \n&quot;;
$query .= &quot;id_habihub_prop = &#039;&quot;.(int)$property-&gt;id.&quot;&#039; \n&quot;;
if ($in_database) {
    $query .= &quot;WHERE ref_xml_prop = &#039;&quot;.(string)$property-&gt;ref.&quot;&#039; AND xml_xml_prop = &#039;&quot;.$_GET[&#039;p&#039;].&quot;&#039;&quot;;
}

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
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:255
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
savePropertyData($query, $in_database, $property-&gt;features, $property-&gt;images, $property-&gt;plans);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
savePropertyData($query, $in_database, $property-&gt;features, $property-&gt;images, $property-&gt;plans, $property-&gt;videos, $property-&gt;views360, $property-&gt;documents, $tagsHabihub);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils.php:420
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (!function_exists(&quot;savePropertyData&quot;)) {
    function savePropertyData($query, $update, $features = array(), $images = array(), $plans = array(), $tags = array()) {
        global $database_inmoconn, $inmoconn, $in_database, $proveedor, $propID, $newFeatArray, $allLanguages, $numInsert, $numUpdated, $refInm, $actionUpdateProp, $autotraduccion;
        set_time_limit(0);
        // A&ntilde;adimos el inmueble

        $rsPropertyInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
        if ($update) {
            $propertyID = $propID;
            logprop(&#039;1&#039;, $propertyID, $refInm, $actionUpdateProp);
            $numUpdated++;
        } else {
            $id = @mysqli_insert_id($inmoconn);
            $propertyID = $id;
            logprop(&#039;1&#039;, $propertyID, $refInm, &#039;1&#039;);
            $numInsert++;
        }

        $query_rsDeletekPropFeature = &quot;DELETE FROM properties_property_tag WHERE  property = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
        $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
        if (!empty($tags)) {
            foreach($tags as $tag) {
                if ((string)$tag &gt; 0) {
                    $query = &quot;INSERT INTO properties_property_feature_priv SET &quot;;
                    $query .= &quot;property = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                    $query .= &quot;feature = &#039;&quot;.$tag.&quot;&#039;&quot;;
                    mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }
        }

        // A&ntilde;adimos las features
        if (!$in_database || $proveedor[&#039;up_caracteristicas_xml&#039;] == 1) {

            $query_rsDeletekPropFeature = &quot;DELETE FROM properties_property_feature_priv WHERE  property = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($features)) {
                foreach($features-&gt;feature as $feature) {
                    set_time_limit(0);
                    $feature = mysqli_real_escape_string($inmoconn,trim((string)$feature));

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
                        array_push($newFeatArray, $feature);
                    } else {
                        $featureID = $row_rsFeature[&#039;id_feat&#039;];
                    }
                    if($featureID != &#039;&#039;){
                        $query = &quot;INSERT INTO properties_property_feature_priv SET &quot;;
                        $query .= &quot;property = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;feature = &#039;&quot;.$featureID.&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    }
                }
            }
        }
        // A&ntilde;adimos las imagenes
        if (!$in_database || $proveedor[&#039;up_imagenes_xml&#039;] == 1) {
            $imgOrd = 1;
            $query = &quot;UPDATE properties_images SET &quot;;
            $query .= &quot;active_img = &#039;0&#039;  WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039;&quot;;

            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $kyeroURLs = array(
                &#039;https://kyero.cloudimg.io/crop/400x300/q82/&#039;,
                &#039;https://kyero.cloudimg.io/s/crop/400x300/&#039;,
                &#039;?NO_CHECKSUM&amp;env=production&#039;,
                &#039;?NO_CHECKSUM&#039;
            );
            if (!empty($images-&gt;image-&gt;url)) {
                foreach($images-&gt;image as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, &#039;&#039;, $image-&gt;url);

                    $query_rsImages = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;
                    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                    $row_rsImages = mysqli_fetch_assoc($rsImages);
                    $totalRows_rsImages = mysqli_num_rows($rsImages);
                    if($totalRows_rsImages == 0){
                        $query = &quot;INSERT INTO properties_images SET &quot;;
                        $query .= &quot;property_img = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;image_img = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;image_img2 = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;active_img = &#039;1&#039;, &quot;;
                        $query .= &quot;procesada_img = &#039;0&#039;, &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                    } else {
                        $query = &quot;UPDATE properties_images SET &quot;;
                        $query .= &quot;active_img = &#039;1&#039;,  &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;
                        $query .= &quot;WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, $row_rsImages[&#039;id_img&#039;]); // /intramedianet/includes/resources/translate.php
                    }
                    $imgOrd++;
                }
            }
            $queryDeleteDisabledImages = &quot;DELETE FROM properties_images WHERE active_img = &#039;0&#039; AND property_img = &#039;&quot;.$propertyID.&quot;&#039; &quot;;
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());

            // PLANOS
            $imgOrd = 1;
            $query = &quot;UPDATE properties_planos SET &quot;;
            $query .= &quot;active_img = &#039;0&#039;  WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039;&quot;;

            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $kyeroURLs = array(
                &#039;https://kyero.cloudimg.io/crop/400x300/q82/&#039;,
                &#039;https://kyero.cloudimg.io/s/crop/400x300/&#039;,
                &#039;?NO_CHECKSUM&amp;env=production&#039;,
                &#039;?NO_CHECKSUM&#039;
            );
            if (!empty($images-&gt;plans-&gt;url)) {
                foreach($images-&gt;plans as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, &#039;&#039;, $image-&gt;url);

                    $query_rsImages = &quot;SELECT * FROM properties_planos WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;
                    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                    $row_rsImages = mysqli_fetch_assoc($rsImages);
                    $totalRows_rsImages = mysqli_num_rows($rsImages);
                    if($totalRows_rsImages == 0){
                        $query = &quot;INSERT INTO properties_planos SET &quot;;
                        $query .= &quot;property_img = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;image_img = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;image_img2 = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;active_img = &#039;1&#039;, &quot;;
                        $query .= &quot;procesada_img = &#039;0&#039;, &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                    } else {
                        $query = &quot;UPDATE properties_planos SET &quot;;
                        $query .= &quot;active_img = &#039;1&#039;,  &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;
                        $query .= &quot;WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, $row_rsImages[&#039;id_img&#039;]); // /intramedianet/includes/resources/translate.php
                    }
                    $imgOrd++;
                }
            }
            $queryDeleteDisabledImages = &quot;DELETE FROM properties_planos WHERE active_img = &#039;0&#039; AND property_img = &#039;&quot;.$propertyID.&quot;&#039; &quot;;
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());


        }
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (!function_exists(&quot;savePropertyData&quot;)) {
    function savePropertyData($query, $update, $features = array(), $images = array(), $plans = array(), $videos = array(), $views360 = array(), $documents = array(), $tags = array()) {
        global $database_inmoconn, $inmoconn, $in_database, $proveedor, $propID, $newFeatArray, $allLanguages, $numInsert, $numUpdated, $refInm, $actionUpdateProp, $autotraduccion;
        set_time_limit(0);
        // A&ntilde;adimos el inmueble

        $rsPropertyInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
        if ($update) {
            $propertyID = $propID;
            logprop(&#039;1&#039;, $propertyID, $refInm, $actionUpdateProp);
            $numUpdated++;
        } else {
            $id = @mysqli_insert_id($inmoconn);
            $propertyID = $id;
            logprop(&#039;1&#039;, $propertyID, $refInm, &#039;1&#039;);
            $numInsert++;
        }

        $query_rsDeletekPropFeature = &quot;DELETE FROM properties_property_tag WHERE  property = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
        $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
        if (!empty($tags)) {
            foreach($tags as $tag) {
                if ((string)$tag &gt; 0) {
                    $query = &quot;INSERT INTO properties_property_tag SET &quot;;
                    $query .= &quot;property = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                    $query .= &quot;tag = &#039;&quot;.$tag.&quot;&#039;&quot;;
                    mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }
        }

        // A&ntilde;adimos las features
        if (!$in_database || $proveedor[&#039;up_caracteristicas_xml&#039;] == 1) {

            $query_rsDeletekPropFeature = &quot;DELETE FROM properties_property_feature_priv WHERE  property = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($features)) {
                foreach($features-&gt;feature as $feature) {
                    set_time_limit(0);
                    $feature = mysqli_real_escape_string($inmoconn,trim((string)$feature));

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
                        array_push($newFeatArray, $feature);
                    } else {
                        $featureID = $row_rsFeature[&#039;id_feat&#039;];
                    }
                    if($featureID != &#039;&#039;){
                        $query = &quot;INSERT INTO properties_property_feature_priv SET &quot;;
                        $query .= &quot;property = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;feature = &#039;&quot;.$featureID.&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    }
                }
            }
        }
        // A&ntilde;adimos las imagenes
        if (!$in_database || $proveedor[&#039;up_imagenes_xml&#039;] == 1) {
            $imgOrd = 1;
            $query = &quot;UPDATE properties_images SET &quot;;
            $query .= &quot;active_img = &#039;0&#039;  WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039;&quot;;

            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $kyeroURLs = array(
                &#039;https://kyero.cloudimg.io/crop/400x300/q82/&#039;,
                &#039;https://kyero.cloudimg.io/s/crop/400x300/&#039;,
                &#039;?NO_CHECKSUM&amp;env=production&#039;,
                &#039;?NO_CHECKSUM&#039;
            );
            if (!empty($images-&gt;image-&gt;url)) {
                foreach($images-&gt;image as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, &#039;&#039;, $image-&gt;url);

                    $query_rsImages = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;
                    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                    $row_rsImages = mysqli_fetch_assoc($rsImages);
                    $totalRows_rsImages = mysqli_num_rows($rsImages);
                    if($totalRows_rsImages == 0){
                        $query = &quot;INSERT INTO properties_images SET &quot;;
                        $query .= &quot;property_img = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;image_img = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;image_img2 = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;active_img = &#039;1&#039;, &quot;;
                        $query .= &quot;procesada_img = &#039;0&#039;, &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                    } else {
                        $query = &quot;UPDATE properties_images SET &quot;;
                        $query .= &quot;active_img = &#039;1&#039;,  &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;
                        $query .= &quot;WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, $row_rsImages[&#039;id_img&#039;]); // /intramedianet/includes/resources/translate.php
                    }
                    $imgOrd++;
                }
            }
            $queryDeleteDisabledImages = &quot;DELETE FROM properties_images WHERE active_img = &#039;0&#039; AND property_img = &#039;&quot;.$propertyID.&quot;&#039; &quot;;
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());

            // PLANOS
            $imgOrd = 1;
            $fileOrd = 1;
            $query = &quot;UPDATE properties_planos SET &quot;;
            $query .= &quot;active_img = &#039;0&#039;  WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039;&quot;;

            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
            $kyeroURLs = array(
                &#039;https://kyero.cloudimg.io/crop/400x300/q82/&#039;,
                &#039;https://kyero.cloudimg.io/s/crop/400x300/&#039;,
                &#039;?NO_CHECKSUM&amp;env=production&#039;,
                &#039;?NO_CHECKSUM&#039;
            );
            if (!empty($plans-&gt;plan-&gt;url)) {
                foreach($images-&gt;plans as $image) {
                    set_time_limit(0);
                    $image = str_replace($kyeroURLs, &#039;&#039;, $image-&gt;url);

                    $query_rsImages = &quot;SELECT * FROM properties_planos WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;
                    $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                    $row_rsImages = mysqli_fetch_assoc($rsImages);
                    $totalRows_rsImages = mysqli_num_rows($rsImages);
                    if($totalRows_rsImages == 0){
                        $query = &quot;INSERT INTO properties_planos SET &quot;;
                        $query .= &quot;property_img = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;image_img = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;image_img2 = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                        $query .= &quot;active_img = &#039;1&#039;, &quot;;
                        $query .= &quot;procesada_img = &#039;0&#039;, &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                    } else {
                        $query = &quot;UPDATE properties_planos SET &quot;;
                        $query .= &quot;active_img = &#039;1&#039;,  &quot;;
                        $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;
                        $query .= &quot;WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;

                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        // generateThumbnails($image, $row_rsImages[&#039;id_img&#039;]); // /intramedianet/includes/resources/translate.php
                    }
                    $imgOrd++;
                }
            }

            $queryDeleteFilePlans = &quot;DELETE FROM properties_files WHERE property_fil = &#039;&quot;.$propertyID.&quot;&#039; AND file_fil LIKE &#039;http%&#039; &quot;;
            mysqli_query($inmoconn,$queryDeleteFilePlans) or die(mysqli_error());

            if (!empty($plans-&gt;plan-&gt;url)) {
                foreach($plans-&gt;plan as $image) {
                    if (!preg_match(&#039;/.pdf/i&#039;, $image-&gt;url)) {
                        set_time_limit(0);
                        $image = str_replace($kyeroURLs, &#039;&#039;, $image-&gt;url);

                        $query_rsImages = &quot;SELECT * FROM properties_planos WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;
                        $rsImages = mysqli_query($inmoconn,$query_rsImages) or die(mysqli_error());
                        $row_rsImages = mysqli_fetch_assoc($rsImages);
                        $totalRows_rsImages = mysqli_num_rows($rsImages);
                        if($totalRows_rsImages == 0){
                            $query = &quot;INSERT INTO properties_planos SET &quot;;
                            $query .= &quot;property_img = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                            $query .= &quot;image_img = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                            $query .= &quot;image_img2 = &#039;&quot;.trim($image).&quot;&#039;, &quot;;
                            $query .= &quot;active_img = &#039;1&#039;, &quot;;
                            $query .= &quot;procesada_img = &#039;0&#039;, &quot;;
                            $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;

                            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                            // generateThumbnails($image, mysqli_insert_id($inmoconn)); // /intramedianet/includes/resources/translate.php
                        } else {
                            $query = &quot;UPDATE properties_planos SET &quot;;
                            $query .= &quot;active_img = &#039;1&#039;,  &quot;;
                            $query .= &quot;order_img = &#039;&quot;.$imgOrd.&quot;&#039;&quot;;
                            $query .= &quot;WHERE property_img = &#039;&quot;.$propertyID.&quot;&#039; AND image_img2 = &#039;&quot;.trim($image).&quot;&#039;&quot;;

                            $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                            // generateThumbnails($image, $row_rsImages[&#039;id_img&#039;]); // /intramedianet/includes/resources/translate.php
                        }
                        $imgOrd++;
                    } else {
                        set_time_limit(0);
                        $query = &quot;INSERT INTO properties_files SET &quot;;
                        $query .= &quot;property_fil = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;file_fil = &#039;&quot;.trim($image-&gt;url).&quot;&#039;, &quot;;
                        $query .= &quot;order_fil = &#039;&quot;.$fileOrd.&quot;&#039;&quot;;
                        $rsPropFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                        $fileOrd++;
                    }
                }
            }
            $queryDeleteDisabledImages = &quot;DELETE FROM properties_planos WHERE active_img = &#039;0&#039; AND property_img = &#039;&quot;.$propertyID.&quot;&#039; &quot;;
            mysqli_query($inmoconn,$queryDeleteDisabledImages) or die(mysqli_error());

            // A&ntilde;adimos las videos
            $query_rsDeletekPropFeature = &quot;DELETE FROM properties_videos WHERE  property_vid = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($videos)) {
                $i = 1;
                foreach($videos-&gt;video_url as $video) {
                    set_time_limit(0);
                    if ($video != &#039;&#039; &amp;&amp; $video != &#039;r&#039;) {
                        $video = explode(&#039;v=&#039;, $video);
                        $video = $video[1];
                        $query = &quot;INSERT INTO properties_videos SET &quot;;
                        $query .= &quot;video_vid = &#039;&lt;iframe width=\&quot;560\&quot; height=\&quot;315\&quot; src=\&quot;https://www.youtube.com/embed/&quot;.$video.&quot;\&quot; frameborder=\&quot;0\&quot; allow=\&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\&quot; referrerpolicy=\&quot;strict-origin-when-cross-origin\&quot; allowfullscreen&gt;&lt;/iframe&gt;&#039;, &quot;;
                        $query .= &quot;order_vid = &#039;&quot;.$i++.&quot;&#039;, &quot;;
                        $query .= &quot;property_vid = &#039;&quot;.$propertyID.&quot;&#039;&quot;;

                        $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    }
                }
            }

            // A&ntilde;adimos las 360
            $query_rsDeletekPropFeature = &quot;DELETE FROM properties_360 WHERE  property_360 = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
            $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
            if (!empty($views360)) {
                $i = 1;
                foreach($views360-&gt;virtual_tour_url as $view360) {
                    set_time_limit(0);
                    $query = &quot;INSERT INTO properties_360 SET &quot;;
                    $query .= &quot;video_360 = &#039;&lt;iframe width=\&quot;560\&quot; height=\&quot;315\&quot; src=\&quot;&quot;.$view360.&quot;\&quot; frameborder=\&quot;0\&quot; allow=\&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\&quot; referrerpolicy=\&quot;strict-origin-when-cross-origin\&quot; allowfullscreen&gt;&lt;/iframe&gt;&#039;, &quot;;
                    $query .= &quot;order_360 = &#039;&quot;.$i++.&quot;&#039;, &quot;;
                    $query .= &quot;property_360 = &#039;&quot;.$propertyID.&quot;&#039;&quot;;

                    $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                }
            }

            // A&ntilde;adimos las archivos
            $docOrd = 1;
            $queryDeleteFiles = &quot;DELETE FROM properties_datos_files WHERE property_fil = &#039;&quot;.$propertyID.&quot;&#039; AND file_fil LIKE &#039;http%&#039; &quot;;
            mysqli_query($inmoconn,$queryDeleteFiles) or die(mysqli_error());
            if (!empty($documents)) {
                foreach($documents-&gt;document as $document) {
                    set_time_limit(0);
                    $query = &quot;INSERT INTO properties_datos_files SET &quot;;
                        $query .= &quot;property_fil = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                        $query .= &quot;file_fil = &#039;&quot;.trim($document-&gt;url).&quot;&#039;&quot;;

                    $rsFeatureInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
                    $docOrd++;
                }
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
/intramedianet/properties/properties-form.php:3393
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot;&gt;
   &lt;div class=&quot;img-thumbnail pull-left&quot;&gt;
       &lt;a href=&quot;/media/files/properties/&lt;?php echo $row_rsFiles[&#039;file_fil&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-large btn-primary w-100 text-truncate&quot;&gt;&lt;?php __(&#039;Ver archivo&#039;); ?&gt;:&lt;br&gt;&lt;small&gt;&lt;?php echo $row_rsFiles[&#039;file_fil&#039;]; ?&gt;&lt;/small&gt;&lt;/a&gt;
       &lt;p class=&quot;text-center&quot;&gt;
       &lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm edit-name&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil&quot;&gt;&lt;/i&gt;&lt;/a&gt;
       &lt;a href=&quot;#&quot; class=&quot;btn btn-info btn-sm edit-lang&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-language&quot;&gt;&lt;/i&gt;&lt;/a&gt;
       &lt;a href=&quot;/intramedianet/properties/files_del.php&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-fil2&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;
       &lt;/p&gt;
   &lt;/div&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if (preg_match(&#039;/https?:/&#039;, $row_rsFiles[&#039;file_fil&#039;])): ?&gt;
    &lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot;&gt;
        &lt;div class=&quot;img-thumbnail pull-left&quot;&gt;
            &lt;a href=&quot;&lt;?php echo $row_rsFiles[&#039;file_fil&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-large btn-primary w-100 text-truncate&quot;&gt;&lt;?php __(&#039;Ver archivo&#039;); ?&gt;:&lt;br&gt;
                &lt;small&gt;
                  &lt;?php
                      $name = basename($row_rsFiles[&#039;file_fil&#039;]);
                      $plans[&#039;0&#039;] = &#039;Planta baja&#039;;
                      $plans[&#039;1&#039;] = &#039;Planta 1&#039;;
                      $plans[&#039;2&#039;] = &#039;Planta 2&#039;;
                      $plans[&#039;3&#039;] = &#039;Planta 3&#039;;
                      $plans[&#039;01&#039;] = &#039;Planta baja + Planta 1&#039;;
                      $plans[&#039;012&#039;] = &#039;Planta baja + Planta 1 + Planta 2&#039;;
                      $plans[&#039;G&#039;] = &#039;S&oacute;tano&#039;;
                      $plans[&#039;G0&#039;] = &#039;S&oacute;tano + Planta baja&#039;;
                      $plans[&#039;G01&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1&#039;;
                      $plans[&#039;G012&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Planta 2&#039;;
                      $plans[&#039;G01S&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Solarium&#039;;
                      $plans[&#039;S&#039;] = &#039;Solarium&#039;;
                      $plans[&#039;0S&#039;] = &#039;Planta baja + Solarium&#039;;
                      $plans[&#039;01S&#039;] = &#039;Planta baja + Planta 1 + Solarium&#039;;
                      $plans[&#039;012S&#039;] = &#039;Planta baja + Planta 1 + Planta 2 + Solarium&#039;;
                      $plans[&#039;P&#039;] = &#039;Parcela&#039;;

                      echo __($plans[preg_replace(&quot;/\.[^.]+$/&quot;, &quot;&quot;, $name)]);
                  ?&gt;
                &lt;/small&gt;
            &lt;/a&gt;
            &lt;p class=&quot;text-center&quot;&gt;
            &lt;!-- &lt;a href=&quot;/intramedianet/properties/files_del.php&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-fil2&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt; --&gt;
            &lt;/p&gt;
        &lt;/div&gt;
    &lt;/li&gt;
&lt;?php else: ?&gt;
    &lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot;&gt;
        &lt;div class=&quot;img-thumbnail pull-left&quot;&gt;
            &lt;a href=&quot;/media/files/properties/&lt;?php echo $row_rsFiles[&#039;file_fil&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-large btn-primary w-100 text-truncate&quot;&gt;&lt;?php __(&#039;Ver archivo&#039;); ?&gt;:&lt;br&gt;&lt;small&gt;&lt;?php echo $row_rsFiles[&#039;file_fil&#039;]; ?&gt;&lt;/small&gt;&lt;/a&gt;
            &lt;p class=&quot;text-center&quot;&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm edit-name&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil&quot;&gt;&lt;/i&gt;&lt;/a&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-info btn-sm edit-lang&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-language&quot;&gt;&lt;/i&gt;&lt;/a&gt;
            &lt;a href=&quot;/intramedianet/properties/files_del.php&quot; data-id=&quot;&lt;?php echo $row_rsFiles[&#039;id_fil&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-fil2&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;
            &lt;/p&gt;
        &lt;/div&gt;
    &lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4027
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot;&gt;
     &lt;div class=&quot;img-thumbnail pull-left&quot;&gt;
         &lt;a href=&quot;/media/files/data/&lt;?php echo $row_rsFiles2[&#039;file_fil&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-large btn-primary w-100 text-truncate&quot;&gt;&lt;?php __(&#039;Ver archivo&#039;); ?&gt;:&lt;br&gt;&lt;small&gt;&lt;?php echo $row_rsFiles2[&#039;file_fil&#039;]; ?&gt;&lt;/small&gt;&lt;/a&gt;
         &lt;p class=&quot;text-center&quot;&gt;
         &lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm edit-name2&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil&quot;&gt;&lt;/i&gt;&lt;/a&gt;
         &lt;a href=&quot;/intramedianet/properties/dfiles_del.php&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-fil2&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;
         &lt;/p&gt;
     &lt;/div&gt;
 &lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if (preg_match(&#039;/https?:/&#039;, $row_rsFiles2[&#039;file_fil&#039;])): ?&gt;
  &lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot;&gt;
      &lt;div class=&quot;img-thumbnail pull-left&quot;&gt;
          &lt;a href=&quot;&lt;?php echo $row_rsFiles2[&#039;file_fil&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-large btn-primary w-100 text-truncate&quot;&gt;&lt;?php __(&#039;Ver archivo&#039;); ?&gt;:&lt;br&gt;
              &lt;small&gt;
                &lt;?php
                    $name = basename($row_rsFiles2[&#039;file_fil&#039;]);
                    $name = explode(&#039;-&#039;, $name);
                    echo __(preg_replace(&quot;/\.[^.]+$/&quot;, &quot;&quot;, $name[0]));
                ?&gt;
              &lt;/small&gt;
          &lt;/a&gt;
          &lt;p class=&quot;text-center&quot;&gt;
          &lt;!-- &lt;a href=&quot;/intramedianet/properties/files_del.php&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-fil2&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt; --&gt;
          &lt;/p&gt;
      &lt;/div&gt;
  &lt;/li&gt;
&lt;?php else: ?&gt;
  &lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot;&gt;
      &lt;div class=&quot;img-thumbnail pull-left&quot;&gt;
          &lt;a href=&quot;/media/files/properties/&lt;?php echo $row_rsFiles2[&#039;file_fil&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-large btn-primary w-100 text-truncate&quot;&gt;&lt;?php __(&#039;Ver archivo&#039;); ?&gt;:&lt;br&gt;&lt;small&gt;&lt;?php echo $row_rsFiles2[&#039;file_fil&#039;]; ?&gt;&lt;/small&gt;&lt;/a&gt;
          &lt;p class=&quot;text-center&quot;&gt;
          &lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm edit-name&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil&quot;&gt;&lt;/i&gt;&lt;/a&gt;
          &lt;a href=&quot;#&quot; class=&quot;btn btn-info btn-sm edit-lang&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-language&quot;&gt;&lt;/i&gt;&lt;/a&gt;
          &lt;a href=&quot;/intramedianet/properties/files_del.php&quot; data-id=&quot;&lt;?php echo $row_rsFiles2[&#039;id_fil&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-fil2&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;
          &lt;/p&gt;
      &lt;/div&gt;
  &lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tab-descargas.tpl:6
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;/media/files/properties/{$files[vid].file_fil}&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary mb-3 px-5&quot;&gt;
    {if $files[vid].name != &#039;&#039;}
        {$files[vid].name}
    {else}
        {$lng_descargar}
    {/if}
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$files[vid].file_fil}
    &lt;a href=&quot;{$files[vid].file_fil}&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary mb-3 px-5&quot;&gt;
        {getDownloadName($files[vid].file_fil)}
    &lt;/a&gt;
{else}
    &lt;a href=&quot;/media/files/properties/{$files[vid].file_fil}&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary mb-3 px-5&quot;&gt;
        {if $files[vid].name != &#039;&#039;}
            {$files[vid].name}
        {else}
            {$lng_descargar}
        {/if}
    &lt;/a&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:100
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;registerPlugin(&#039;modifier&#039;, &#039;propURL&#039;, &#039;propURL&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;registerPlugin(&#039;modifier&#039;, &#039;propURL&#039;, &#039;propURL&#039;);
$smarty-&gt;registerPlugin(&#039;modifier&#039;, &#039;getDownloadName&#039;, &#039;getDownloadName&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
function getDownloadName($text) {
    global $langStr;
    return $langStr[preg_replace(&quot;/\.[^.]+$/&quot;, &quot;&quot;, basename($text))];
}
            </code>
        </pre>
        <hr>
        Añadir a <code>/intramedianet/includes/resources/lang_es.php</code>:
        <pre>
            <code class="php">
$lang[&#039;Planta baja&#039;] = &#039;Planta baja&#039;;
$lang[&#039;Planta 1&#039;] = &#039;Planta 1&#039;;
$lang[&#039;Planta 2&#039;] = &#039;Planta 2&#039;;
$lang[&#039;Planta 3&#039;] = &#039;Planta 3&#039;;
$lang[&#039;Planta baja + Planta 1&#039;] = &#039;Planta baja + Planta 1&#039;;
$lang[&#039;Planta baja + Planta 1 + Planta 2&#039;] = &#039;Planta baja + Planta 1 + Planta 2&#039;;
$lang[&#039;S&oacute;tano&#039;] = &#039;S&oacute;tano&#039;;
$lang[&#039;S&oacute;tano + Planta baja&#039;] = &#039;S&oacute;tano + Planta baja&#039;;
$lang[&#039;S&oacute;tano + Planta baja + Planta 1&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1&#039;;
$lang[&#039;S&oacute;tano + Planta baja + Planta 1 + Planta 2&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Planta 2&#039;;
$lang[&#039;S&oacute;tano + Planta baja + Planta 1 + Solarium&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Solarium&#039;;
$lang[&#039;Solarium&#039;] = &#039;Solarium&#039;;
$lang[&#039;Planta baja + Solarium&#039;] = &#039;Planta baja + Solarium&#039;;
$lang[&#039;Planta baja + Planta 1 + Solarium&#039;] = &#039;Planta baja + Planta 1 + Solarium&#039;;
$lang[&#039;Planta baja + Planta 1 + Planta 2 + Solarium&#039;] = &#039;Planta baja + Planta 1 + Planta 2 + Solarium&#039;;
$lang[&#039;Parcela&#039;] = &#039;Parcela&#039;;

$lang[&#039;buildinglicense&#039;] = &#039;Licencia de obra (promoci&oacute;n)&#039;;
$lang[&#039;basicproject&#039;] = &#039;Proyecto b&aacute;sico (promoci&oacute;n)&#039;;
$lang[&#039;simplenote&#039;] = &#039;Nota simple (promoci&oacute;n)&#039;;
$lang[&#039;bankguarantee&#039;] = &#039;Avales bancarios (promoci&oacute;n)&#039;;
$lang[&#039;dossier&#039;] = &#039;Dossier de ventas (promoci&oacute;n)&#039;;
$lang[&#039;qualitymemory&#039;] = &#039;Memoria de calidades (promoci&oacute;n)&#039;;
$lang[&#039;customization&#039;] = &#039;Personalizaciones (promoci&oacute;n)&#039;;
$lang[&#039;energeticcert&#039;] = &#039;Certificado energ&eacute;tico (promoci&oacute;n)&#039;;
$lang[&#039;touristcert&#039;] = &#039;Certificado de clasificaci&oacute;n tur&iacute;stica (promoci&oacute;n)&#039;;
$lang[&#039;others01&#039;] = &#039;Otros 1 (promoci&oacute;n)&#039;;
$lang[&#039;others02&#039;] = &#039;Otros 2 (promoci&oacute;n)&#039;;
$lang[&#039;others03&#039;] = &#039;Otros 3 (promoci&oacute;n)&#039;;
$lang[&#039;buildinglicense&#039;] = &#039;Licencia de obra (vivienda)&#039;;
$lang[&#039;customization&#039;] = &#039;Personalizaciones (vivienda)&#039;;
$lang[&#039;energeticcert&#039;] = &#039;Certificado energ&eacute;tico (vivienda)&#039;;
$lang[&#039;simplenote&#039;] = &#039;Nota simple (vivienda)&#039;;
            </code>
        </pre>
        <hr>
        Añadir a <code>/intramedianet/includes/resources/lang_en.php</code>:
        <pre>
            <code class="php">
$lang[&#039;Planta baja&#039;] = &#039;Ground floor&#039;;
$lang[&#039;Planta 1&#039;] = &#039;First floor&#039;;
$lang[&#039;Planta 2&#039;] = &#039;Second floor&#039;;
$lang[&#039;Planta 3&#039;] = &#039;Third floor&#039;;
$lang[&#039;Planta baja + Planta 1&#039;] = &#039;Ground floor + First floor&#039;;
$lang[&#039;Planta baja + Planta 1 + Planta 2&#039;] = &#039;Ground floor + First floor + Second floor&#039;;
$lang[&#039;S&oacute;tano&#039;] = &#039;Basement&#039;;
$lang[&#039;S&oacute;tano + Planta baja&#039;] = &#039;Basement + Ground floor&#039;;
$lang[&#039;S&oacute;tano + Planta baja + Planta 1&#039;] = &#039;Basement + Ground floor + First floor&#039;;
$lang[&#039;S&oacute;tano + Planta baja + Planta 1 + Planta 2&#039;] = &#039;Basement + Ground floor + First floor + Second floor&#039;;
$lang[&#039;S&oacute;tano + Planta baja + Planta 1 + Solarium&#039;] = &#039;Basement + Ground floor + First floor + Solarium&#039;;
$lang[&#039;Solarium&#039;] = &#039;Solarium&#039;;
$lang[&#039;Planta baja + Solarium&#039;] = &#039;Ground floor + Solarium&#039;;
$lang[&#039;Planta baja + Planta 1 + Solarium&#039;] = &#039;Ground floor + First floor + Solarium&#039;;
$lang[&#039;Planta baja + Planta 1 + Planta 2 + Solarium&#039;] = &#039;Ground floor + First floor + Second floor + Solarium&#039;;
$lang[&#039;Parcela&#039;] = &#039;Plot&#039;;

$lang[&#039;buildinglicense&#039;] = &#039;Building license (development)&#039;;
$lang[&#039;basicproject&#039;] = &#039;Basic project (development)&#039;;
$lang[&#039;simplenote&#039;] = &#039;Simple note (development)&#039;;
$lang[&#039;bankguarantee&#039;] = &#039;Bank guarantees (development)&#039;;
$lang[&#039;dossier&#039;] = &#039;Sales dossier (development)&#039;;
$lang[&#039;qualitymemory&#039;] = &#039;Specifications report (development)&#039;;
$lang[&#039;customization&#039;] = &#039;Customizations (development)&#039;;
$lang[&#039;energeticcert&#039;] = &#039;Energy certificate (development)&#039;;
$lang[&#039;touristcert&#039;] = &#039;Tourist classification certificate (development)&#039;;
$lang[&#039;others01&#039;] = &#039;Others 1 (development)&#039;;
$lang[&#039;others02&#039;] = &#039;Others 2 (development)&#039;;
$lang[&#039;others03&#039;] = &#039;Others 3 (development)&#039;;
$lang[&#039;buildinglicense&#039;] = &#039;Building license (property)&#039;;
$lang[&#039;customization&#039;] = &#039;Customizations (property)&#039;;
$lang[&#039;energeticcert&#039;] = &#039;Energy certificate (property)&#039;;
$lang[&#039;simplenote&#039;] = &#039;Simple note (property)&#039;;
            </code>
        </pre>
        Añade las raducciones
        <pre>
            <code class="php">

// /resources/lang_ca.php

$langStr[&#039;0&#039;] = &#039;Planta baixa&#039;;
$langStr[&#039;1&#039;] = &#039;Planta 1&#039;;
$langStr[&#039;2&#039;] = &#039;Planta 2&#039;;
$langStr[&#039;3&#039;] = &#039;Planta 3&#039;;
$langStr[&#039;01&#039;] = &#039;Planta baixa + Planta 1&#039;;
$langStr[&#039;012&#039;] = &#039;Planta baixa + Planta 1 + Planta 2&#039;;
$langStr[&#039;G&#039;] = &#039;Soterrani&#039;;
$langStr[&#039;G0&#039;] = &#039;Soterrani + Planta baixa&#039;;
$langStr[&#039;G01&#039;] = &#039;Soterrani + Planta baixa + Planta 1&#039;;
$langStr[&#039;G012&#039;] = &#039;Soterrani + Planta baixa + Planta 1 + Planta 2&#039;;
$langStr[&#039;G01S&#039;] = &#039;Soterrani + Planta baixa + Planta 1 + Sol&agrave;rium&#039;;
$langStr[&#039;S&#039;] = &#039;Sol&agrave;rium&#039;;
$langStr[&#039;0S&#039;] = &#039;Planta baixa + Sol&agrave;rium&#039;;
$langStr[&#039;01S&#039;] = &#039;Planta baixa + Planta 1 + Sol&agrave;rium&#039;;
$langStr[&#039;012S&#039;] = &#039;Planta baixa + Planta 1 + Planta 2 + Sol&agrave;rium&#039;;
$langStr[&#039;P&#039;] = &#039;Parcel&middot;la&#039;;

// /resources/lang_da.php

$langStr[&#039;0&#039;] = &#039;Stueetage&#039;;
$langStr[&#039;1&#039;] = &#039;1. sal&#039;;
$langStr[&#039;2&#039;] = &#039;2. sal&#039;;
$langStr[&#039;3&#039;] = &#039;3. sal&#039;;
$langStr[&#039;01&#039;] = &#039;Stueetage + 1. sal&#039;;
$langStr[&#039;012&#039;] = &#039;Stueetage + 1. sal + 2. sal&#039;;
$langStr[&#039;G&#039;] = &#039;K&aelig;lder&#039;;
$langStr[&#039;G0&#039;] = &#039;K&aelig;lder + Stueetage&#039;;
$langStr[&#039;G01&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal&#039;;
$langStr[&#039;G012&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal + 2. sal&#039;;
$langStr[&#039;G01S&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal + Solterrasse&#039;;
$langStr[&#039;S&#039;] = &#039;Solterrasse&#039;;
$langStr[&#039;0S&#039;] = &#039;Stueetage + Solterrasse&#039;;
$langStr[&#039;01S&#039;] = &#039;Stueetage + 1. sal + Solterrasse&#039;;
$langStr[&#039;012S&#039;] = &#039;Stueetage + 1. sal + 2. sal + Solterrasse&#039;;
$langStr[&#039;P&#039;] = &#039;Grund&#039;;

// /resources/lang_de.php

$langStr[&#039;0&#039;] = &#039;Erdgeschoss&#039;;
$langStr[&#039;1&#039;] = &#039;1. Etage&#039;;
$langStr[&#039;2&#039;] = &#039;2. Etage&#039;;
$langStr[&#039;3&#039;] = &#039;3. Etage&#039;;
$langStr[&#039;01&#039;] = &#039;Erdgeschoss + 1. Etage&#039;;
$langStr[&#039;012&#039;] = &#039;Erdgeschoss + 1. Etage + 2. Etage&#039;;
$langStr[&#039;G&#039;] = &#039;Keller&#039;;
$langStr[&#039;G0&#039;] = &#039;Keller + Erdgeschoss&#039;;
$langStr[&#039;G01&#039;] = &#039;Keller + Erdgeschoss + 1. Etage&#039;;
$langStr[&#039;G012&#039;] = &#039;Keller + Erdgeschoss + 1. Etage + 2. Etage&#039;;
$langStr[&#039;G01S&#039;] = &#039;Keller + Erdgeschoss + 1. Etage + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Erdgeschoss + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Erdgeschoss + 1. Etage + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Erdgeschoss + 1. Etage + 2. Etage + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Grundst&uuml;ck&#039;;

// /resources/lang_en.php

$langStr[&#039;0&#039;] = &#039;Ground floor&#039;;
$langStr[&#039;1&#039;] = &#039;First floor&#039;;
$langStr[&#039;2&#039;] = &#039;Second floor&#039;;
$langStr[&#039;3&#039;] = &#039;Third floor&#039;;
$langStr[&#039;01&#039;] = &#039;Ground floor + First floor&#039;;
$langStr[&#039;012&#039;] = &#039;Ground floor + First floor + Second floor&#039;;
$langStr[&#039;G&#039;] = &#039;Basement&#039;;
$langStr[&#039;G0&#039;] = &#039;Basement + Ground floor&#039;;
$langStr[&#039;G01&#039;] = &#039;Basement + Ground floor + First floor&#039;;
$langStr[&#039;G012&#039;] = &#039;Basement + Ground floor + First floor + Second floor&#039;;
$langStr[&#039;G01S&#039;] = &#039;Basement + Ground floor + First floor + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Ground floor + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Ground floor + First floor + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Ground floor + First floor + Second floor + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Plot&#039;;

// /resources/lang_es.php

$langStr[&#039;0&#039;] = &#039;Planta baja&#039;;
$langStr[&#039;1&#039;] = &#039;Planta 1&#039;;
$langStr[&#039;2&#039;] = &#039;Planta 2&#039;;
$langStr[&#039;3&#039;] = &#039;Planta 3&#039;;
$langStr[&#039;01&#039;] = &#039;Planta baja + Planta 1&#039;;
$langStr[&#039;012&#039;] = &#039;Planta baja + Planta 1 + Planta 2&#039;;
$langStr[&#039;G&#039;] = &#039;S&oacute;tano&#039;;
$langStr[&#039;G0&#039;] = &#039;S&oacute;tano + Planta baja&#039;;
$langStr[&#039;G01&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1&#039;;
$langStr[&#039;G012&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Planta 2&#039;;
$langStr[&#039;G01S&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Planta baja + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Planta baja + Planta 1 + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Planta baja + Planta 1 + Planta 2 + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Parcela&#039;;

// /resources/lang_fi.php

$langStr[&#039;0&#039;] = &#039;Alakerta&#039;;
$langStr[&#039;1&#039;] = &#039;1. kerros&#039;;
$langStr[&#039;2&#039;] = &#039;2. kerros&#039;;
$langStr[&#039;3&#039;] = &#039;3. kerros&#039;;
$langStr[&#039;01&#039;] = &#039;Alakerta + 1. kerros&#039;;
$langStr[&#039;012&#039;] = &#039;Alakerta + 1. + 2. kerros&#039;;
$langStr[&#039;G&#039;] = &#039;Kellari&#039;;
$langStr[&#039;G0&#039;] = &#039;Kellari + Alakerta&#039;;
$langStr[&#039;G01&#039;] = &#039;Kellari + Alakerta + 1. kerros&#039;;
$langStr[&#039;G012&#039;] = &#039;Kellari + Alakerta + 1. + 2. kerros&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kellari + Alakerta + 1. kerros + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Alakerta + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Alakerta + 1. kerros + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Alakerta + 1. + 2. kerros + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Tontti&#039;;

// /resources/lang_fr.php

$langStr[&#039;0&#039;] = &#039;Rez-de-chauss&eacute;e&#039;;
$langStr[&#039;1&#039;] = &#039;1er &eacute;tage&#039;;
$langStr[&#039;2&#039;] = &#039;2e &eacute;tage&#039;;
$langStr[&#039;3&#039;] = &#039;3e &eacute;tage&#039;;
$langStr[&#039;01&#039;] = &#039;Rez-de-chauss&eacute;e + 1er &eacute;tage&#039;;
$langStr[&#039;012&#039;] = &#039;Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage&#039;;
$langStr[&#039;G&#039;] = &#039;Sous-sol&#039;;
$langStr[&#039;G0&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e&#039;;
$langStr[&#039;G01&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er &eacute;tage&#039;;
$langStr[&#039;G012&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage&#039;;
$langStr[&#039;G01S&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er &eacute;tage + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Rez-de-chauss&eacute;e + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Rez-de-chauss&eacute;e + 1er &eacute;tage + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Terrain&#039;;

// /resources/lang_is.php

$langStr[&#039;0&#039;] = &#039;Jar&eth;h&aelig;&eth;&#039;;
$langStr[&#039;1&#039;] = &#039;1. h&aelig;&eth;&#039;;
$langStr[&#039;2&#039;] = &#039;2. h&aelig;&eth;&#039;;
$langStr[&#039;3&#039;] = &#039;3. h&aelig;&eth;&#039;;
$langStr[&#039;01&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth;&#039;;
$langStr[&#039;012&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth;&#039;;
$langStr[&#039;G&#039;] = &#039;Kjallari&#039;;
$langStr[&#039;G0&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth;&#039;;
$langStr[&#039;G01&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth;&#039;;
$langStr[&#039;G012&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth;&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;S&#039;] = &#039;S&oacute;lpallur&#039;;
$langStr[&#039;0S&#039;] = &#039;Jar&eth;h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;01S&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;012S&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;P&#039;] = &#039;L&oacute;&eth;&#039;;

// /resources/lang_nl.php

$langStr[&#039;0&#039;] = &#039;Begane grond&#039;;
$langStr[&#039;1&#039;] = &#039;1e verdieping&#039;;
$langStr[&#039;2&#039;] = &#039;2e verdieping&#039;;
$langStr[&#039;3&#039;] = &#039;3e verdieping&#039;;
$langStr[&#039;01&#039;] = &#039;Begane grond + 1e verdieping&#039;;
$langStr[&#039;012&#039;] = &#039;Begane grond + 1e + 2e verdieping&#039;;
$langStr[&#039;G&#039;] = &#039;Kelder&#039;;
$langStr[&#039;G0&#039;] = &#039;Kelder + Begane grond&#039;;
$langStr[&#039;G01&#039;] = &#039;Kelder + Begane grond + 1e verdieping&#039;;
$langStr[&#039;G012&#039;] = &#039;Kelder + Begane grond + 1e + 2e verdieping&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kelder + Begane grond + 1e verdieping + Dakterras&#039;;
$langStr[&#039;S&#039;] = &#039;Dakterras&#039;;
$langStr[&#039;0S&#039;] = &#039;Begane grond + Dakterras&#039;;
$langStr[&#039;01S&#039;] = &#039;Begane grond + 1e verdieping + Dakterras&#039;;
$langStr[&#039;012S&#039;] = &#039;Begane grond + 1e + 2e verdieping + Dakterras&#039;;
$langStr[&#039;P&#039;] = &#039;Perceel&#039;;

// /resources/lang_no.php

$langStr[&#039;0&#039;] = &#039;F&oslash;rste etasje&#039;;
$langStr[&#039;1&#039;] = &#039;1. etasje&#039;;
$langStr[&#039;2&#039;] = &#039;2. etasje&#039;;
$langStr[&#039;3&#039;] = &#039;3. etasje&#039;;
$langStr[&#039;01&#039;] = &#039;F&oslash;rste etasje + 1. etasje&#039;;
$langStr[&#039;012&#039;] = &#039;F&oslash;rste etasje + 1. + 2. etasje&#039;;
$langStr[&#039;G&#039;] = &#039;Kjeller&#039;;
$langStr[&#039;G0&#039;] = &#039;Kjeller + F&oslash;rste etasje&#039;;
$langStr[&#039;G01&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. etasje&#039;;
$langStr[&#039;G012&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. + 2. etasje&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. etasje + Solterrasse&#039;;
$langStr[&#039;S&#039;] = &#039;Solterrasse&#039;;
$langStr[&#039;0S&#039;] = &#039;F&oslash;rste etasje + Solterrasse&#039;;
$langStr[&#039;01S&#039;] = &#039;F&oslash;rste etasje + 1. etasje + Solterrasse&#039;;
$langStr[&#039;012S&#039;] = &#039;F&oslash;rste etasje + 1. + 2. etasje + Solterrasse&#039;;
$langStr[&#039;P&#039;] = &#039;Tomt&#039;;

// /resources/lang_pl.php

$langStr[&#039;0&#039;] = &#039;Parter&#039;;
$langStr[&#039;1&#039;] = &#039;1. pi&#x119;tro&#039;;
$langStr[&#039;2&#039;] = &#039;2. pi&#x119;tro&#039;;
$langStr[&#039;3&#039;] = &#039;3. pi&#x119;tro&#039;;
$langStr[&#039;01&#039;] = &#039;Parter + 1. pi&#x119;tro&#039;;
$langStr[&#039;012&#039;] = &#039;Parter + 1. + 2. pi&#x119;tro&#039;;
$langStr[&#039;G&#039;] = &#039;Piwnica&#039;;
$langStr[&#039;G0&#039;] = &#039;Piwnica + Parter&#039;;
$langStr[&#039;G01&#039;] = &#039;Piwnica + Parter + 1. pi&#x119;tro&#039;;
$langStr[&#039;G012&#039;] = &#039;Piwnica + Parter + 1. + 2. pi&#x119;tro&#039;;
$langStr[&#039;G01S&#039;] = &#039;Piwnica + Parter + 1. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Parter + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Parter + 1. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Parter + 1. + 2. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Dzia&#x142;ka&#039;;

// /resources/lang_ru.php

$langStr[&#039;0&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;1&#039;] = &#039;2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;2&#039;] = &#039;3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;3&#039;] = &#039;4-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;01&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;012&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b;&#039;;
$langStr[&#039;G0&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G01&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G012&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G01S&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;S&#039;] = &#039;&#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;0S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;01S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;012S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;P&#039;] = &#039;&#x423;&#x447;&#x430;&#x441;&#x442;&#x43e;&#x43a;&#039;;

// /resources/lang_se.php

$langStr[&#039;0&#039;] = &#039;Bottenv&aring;ning&#039;;
$langStr[&#039;1&#039;] = &#039;1:a v&aring;ningen&#039;;
$langStr[&#039;2&#039;] = &#039;2:a v&aring;ningen&#039;;
$langStr[&#039;3&#039;] = &#039;3:e v&aring;ningen&#039;;
$langStr[&#039;01&#039;] = &#039;Bottenv&aring;ning + 1:a v&aring;ningen&#039;;
$langStr[&#039;012&#039;] = &#039;Bottenv&aring;ning + 1:a + 2:a v&aring;ningen&#039;;
$langStr[&#039;G&#039;] = &#039;K&auml;llare&#039;;
$langStr[&#039;G0&#039;] = &#039;K&auml;llare + Bottenv&aring;ning&#039;;
$langStr[&#039;G01&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a v&aring;ningen&#039;;
$langStr[&#039;G012&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a + 2:a v&aring;ningen&#039;;
$langStr[&#039;G01S&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;S&#039;] = &#039;Solterrass&#039;;
$langStr[&#039;0S&#039;] = &#039;Bottenv&aring;ning + Solterrass&#039;;
$langStr[&#039;01S&#039;] = &#039;Bottenv&aring;ning + 1:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;012S&#039;] = &#039;Bottenv&aring;ning + 1:a + 2:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;P&#039;] = &#039;Tomt&#039;;

// /resources/lang_zh.php

$langStr[&#039;0&#039;] = &#039;&#x5e95;&#x5c42;&#039;;
$langStr[&#039;1&#039;] = &#039;&#x4e00;&#x5c42;&#039;;
$langStr[&#039;2&#039;] = &#039;&#x4e8c;&#x5c42;&#039;;
$langStr[&#039;3&#039;] = &#039;&#x4e09;&#x5c42;&#039;;
$langStr[&#039;01&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42;&#039;;
$langStr[&#039;012&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42;&#039;;
$langStr[&#039;G&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4;&#039;;
$langStr[&#039;G0&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42;&#039;;
$langStr[&#039;G01&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42;&#039;;
$langStr[&#039;G012&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42;&#039;;
$langStr[&#039;G01S&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;S&#039;] = &#039;&#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;0S&#039;] = &#039;&#x5e95;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;01S&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;012S&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;P&#039;] = &#039;&#x5730;&#x5757;&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>