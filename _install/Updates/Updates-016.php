<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 14-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Al guardar en mapear todas las Provincias/Ciudades/Zonas no borra la cache de las queries</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al generar las miniaturas de las imagenes verticales</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Al guardar em mapear todas las Provincias/Ciudades/Zonas no borra la cache de las queries
    </h6>
    <div class="card-body">
        Sustituir los archivos por lo de esta versión:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc2all-form.php
/intramedianet/properties/loc3all-form.php
/intramedianet/properties/loc4all-form.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al generar las miniaturas de las imagenes verticales
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php
            </code>
        </pre>
        Sustituir la función <code>generateThumbnails</code> por:
        <pre>
            <code class="php">
function generateThumbnails($image, $id, $folder = &#039;properties&#039;) {
    $noimage = base64_encode(file_get_contents($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/website/no-image.png&#039;));
    set_time_limit(0);
    global $thumbnailsSizes, $thumbnailsBackground, $thumbnailsQuality, $actWatermark, $watermarkPosition, $watermarkOpacity;
    require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/simpleimage/src/abeautifulsite/SimpleImage.php&#039;);
    if (!file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_sm.jpg&#039;)) {
        $exif = exif_read_data($image, 0, true);
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
                            $miniatura = $imageTHMB_2-&gt;output_base64(&#039;jpeg&#039;, $thumbnailsQuality);
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
                            $miniatura = $imageTHMB_2-&gt;output_base64(&#039;jpeg&#039;, $thumbnailsQuality);
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
                    $imageTHMB-&gt;save($imgLocalURL, $thumbnailsQuality, &#039;jpeg&#039;);
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
