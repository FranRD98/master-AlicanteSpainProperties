<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 4-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> En listado de noticias no añade la imagen para redes sociales</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error z-index popups se muestran debajo del menu principal</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Fallo en la generación de miniaturas por la versión del PHP del servidor menor de la 5.6</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> En listado de noticias no añade la imagen para redes sociales
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/news.php:249
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;news&quot;, $news);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;news&quot;, $news);

if (preg_match(&#039;/https?:\/\//&#039;, $pages[0][&#039;img&#039;])) {
    $img = $pages[0][&#039;img&#039;];
} else {
    $img = &#039;http://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/news/&#039; . $pages[0][&#039;img&#039;];
}
if ($img == &#039;http://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/news/&#039;) {
    $img = &#039;http://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/website/no-image.png&#039;;
}
$smarty-&gt;assign(&quot;metaImage&quot;, $img);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error z-index popups se muestran debajo del menu principal
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss
            </code>
        </pre>
        Añadir al inicio:
        <pre>
            <code class="php">
$zindex-modal-backdrop: 999999999;
$zindex-modal: 99999999999;
$zindex-popover: 999999999999;
$zindex-tooltip: 9999999999999;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo en la generación de miniaturas por la versión del PHP del servidor menor de la 5.6
    </h6>
    <div class="card-body">
        Sustituir la carpeta  el archivo por la de esta versión:
        <pre>
            <code class="makefile">
/includes/simpleimage
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php:309
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// Genera las miniaturas de las imagenes
$noimage = file_get_contents($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/website/no-image.png&#039;);
function generateThumbnails($image, $id, $folder = &#039;properties&#039;) {
    set_time_limit(0);
    global $thumbnailsSizes, $thumbnailsBackground, $thumbnailsQuality, $actWatermark, $watermarkPosition, $watermarkOpacity;
    require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/simpleimage/src/claviska/SimpleImage.php&#039;);
    if (!file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_sm.jpg&#039;)) {
        $exif = exif_read_data($image, 0, true);
        if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] == &#039;&#039;) {
            list($width, $heigth) = getimgsizeRemote($image);
            $exif[&#039;COMPUTED&#039;][&#039;Height&#039;] = $heigth;
        }
        if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] &gt; 0) {
            $options  = array(&#039;http&#039; =&gt; array(&#039;user_agent&#039; =&gt; &#039;Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36&#039;));
            $context  = stream_context_create($options);
            $image = file_get_contents($image, false, $context);
            foreach ($thumbnailsSizes as $key =&gt; $value) {
                set_time_limit(0);
                ini_set(&#039;memory_limit&#039;, &#039;-1&#039;);
                $imgLocalURL = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_&#039; . $key . &#039;.jpg&#039;;
                if ($actWatermark == 1 &amp;&amp; $key != &#039;sm&#039;) {
                    $imgLocalURL = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_w_&#039; . $key . &#039;.jpg&#039;;
                }
                try {
                    $imageTHMB = new \claviska\SimpleImage();
                    if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] &gt; $exif[&#039;COMPUTED&#039;][&#039;Width&#039;]) {
                        $imageTHMB-&gt;fromNew($value[0], $value[1], $thumbnailsBackground);
                        $imageTHMB_2 = new \claviska\SimpleImage();
                        $imageTHMB_2-&gt;fromString($image);
                        $imageTHMB_2-&gt;bestFit($value[0], $value[1]);
                        $miniatura = $imageTHMB_2-&gt;toDataUri(&#039;image/jpeg&#039;, $thumbnailsQuality);
                        $imageTHMB-&gt;overlay($miniatura, &#039;center&#039;, 1);
                    } else {
                        $imageTHMB-&gt;fromString($image);
                        $imageTHMB-&gt;autoOrient();
                        $imageTHMB-&gt;thumbnail($value[0], $value[1]);
                    }
                    if ($actWatermark == 1 &amp;&amp; $key != &#039;sm&#039;) {
                        $imageTHMB-&gt;overlay($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/website/watermark.png&#039;, $watermarkPosition, $watermarkOpacity);
                    }
                    $imageTHMB-&gt;toFile($imgLocalURL, &#039;image/jpeg&#039;, $thumbnailsQuality);
                    //  mysql_select_db($database_inmoconn, $inmoconn);
                    // $query_rsUserTrad = &quot;
                    // UPDATE  `properties_images` SET
                    //   `procesada_img` = &#039;1&#039;
                    //   WHERE id_img = &#039;&quot;.$id.&quot;&#039;
                    // &quot;;
                    // $rsUserTrad = mysql_query($query_rsUserTrad, $inmoconn) or die(mysql_error());
                } catch(Exception $err) {
                    $imageTHMB = new \claviska\SimpleImage();
                    $imageTHMB-&gt;fromString($noimage);
                    $imageTHMB-&gt;autoOrient();
                    $imageTHMB-&gt;thumbnail($value[0], $value[1]);
                    $imageTHMB-&gt;toFile($imgLocalURL, &#039;image/jpeg&#039;);
                }
            }
            $options = null;
            $context = null;
            $image = null;
            $imgLocalURL = null;
        }
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
// Genera las miniaturas de las imagenes
function generateThumbnails($image, $id, $folder = &#039;properties&#039;) {
    $noimage = base64_encode(file_get_contents($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/website/no-image.png&#039;));
    set_time_limit(0);
    global $thumbnailsSizes, $thumbnailsBackground, $thumbnailsQuality, $actWatermark, $watermarkPosition, $watermarkOpacity;
    require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/simpleimage/src/abeautifulsite/SimpleImage.php&#039;);
    if (!file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_sm.jpg&#039;)) {
        $exif = exif_read_data($image, 0, true);
        var_dump($exif);
        if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] == &#039;&#039;) {
            list($width, $heigth) = getimgsizeRemote($image);
            $exif[&#039;COMPUTED&#039;][&#039;Height&#039;] = $heigth;
        }
        if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] &gt; 0) {
            $options  = array(&#039;http&#039; =&gt; array(&#039;user_agent&#039; =&gt; &#039;Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36&#039;));
            $context  = stream_context_create($options);
            $url_image = $image;
            $image = base64_encode(file_get_contents($image, false, $context));
            foreach ($thumbnailsSizes as $key =&gt; $value) {
                set_time_limit(0);
                ini_set(&#039;memory_limit&#039;, &#039;-1&#039;);
                $imgLocalURL = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_&#039; . $key . &#039;.jpg&#039;;
                if ($actWatermark == 1 &amp;&amp; $key != &#039;sm&#039;) {
                    $imgLocalURL = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_w_&#039; . $key . &#039;.jpg&#039;;
                }
                try {
                    $imageTHMB = new \abeautifulsite\SimpleImage();
                    if(version_compare(PHP_VERSION, &#039;5.4.0&#039;) &gt;= 0){
                        if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] &gt; $exif[&#039;COMPUTED&#039;][&#039;Width&#039;]) {
                            $imageTHMB-&gt;create($value[0], $value[1], $thumbnailsBackground);
                            $imageTHMB_2 = new \abeautifulsite\SimpleImage();
                            $imageTHMB_2-&gt;load_base64($image);
                            $imageTHMB_2-&gt;best_fit($value[0], $value[1]);
                            $miniatura = $imageTHMB_2-&gt;output_base64(&#039;image/jpeg&#039;, $thumbnailsQuality);
                            $imageTHMB-&gt;overlay($miniatura, &#039;center&#039;, 1);
                        } else {
                            $imageTHMB-&gt;load_base64($image);
                            $imageTHMB-&gt;auto_orient();
                            $imageTHMB-&gt;thumbnail($value[0], $value[1]);
                        }
                    } else {
                        if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] &gt; $exif[&#039;COMPUTED&#039;][&#039;Width&#039;]) {
                            $imageTHMB-&gt;create($value[0], $value[1], $thumbnailsBackground);
                            $imageTHMB_2 = new \abeautifulsite\SimpleImage();
                            $imageTHMB_2-&gt;load($url_image);
                            $imageTHMB_2-&gt;best_fit($value[0], $value[1]);
                            $miniatura = $imageTHMB_2-&gt;output_base64(&#039;image/jpeg&#039;, $thumbnailsQuality);
                            $imageTHMB-&gt;overlay($miniatura, &#039;center&#039;, 1);
                        } else {
                            $imageTHMB-&gt;load($url_image);
                            $imageTHMB-&gt;auto_orient();
                            $imageTHMB-&gt;thumbnail($value[0], $value[1]);
                        }
                    }
                    if ($actWatermark == 1 &amp;&amp; $key != &#039;sm&#039;) {
                        $imageTHMB-&gt;overlay($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/website/watermark.png&#039;, $watermarkPosition, $watermarkOpacity);
                    }
                    $imageTHMB-&gt;save($imgLocalURL, $thumbnailsQuality, &#039;image/jpeg&#039;);
                    //  mysql_select_db($database_inmoconn, $inmoconn);
                    // $query_rsUserTrad = &quot;
                    // UPDATE  `properties_images` SET
                    //   `procesada_img` = &#039;1&#039;
                    //   WHERE id_img = &#039;&quot;.$id.&quot;&#039;
                    // &quot;;
                    // $rsUserTrad = mysql_query($query_rsUserTrad, $inmoconn) or die(mysql_error());
                } catch(Exception $err) {
                    $imageTHMB = new \abeautifulsite\SimpleImage();
                    $imageTHMB-&gt;load_base64($noimage);
                    $imageTHMB-&gt;auto_orient();
                    $imageTHMB-&gt;thumbnail($value[0], $value[1]);
                    $imageTHMB-&gt;save($imgLocalURL, $thumbnailsQuality, &#039;image/jpeg&#039;);
                }
            }
            $options = null;
            $context = null;
            $image = null;
            $imgLocalURL = null;
        }
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
