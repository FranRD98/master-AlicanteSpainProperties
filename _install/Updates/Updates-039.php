<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 8 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 15-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Fix exportador Ubiflow</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Convertido el exportador de Yaencontré al formato de Kyero</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> La query que envía los similares por email sacan también las propiedades que están ocultas</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Error breadcums introducido por el Fix SQL INJECTION</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Error al ordenar y cambiar número de inmuebles en el listado de la web introducido por el Fix SQL INJECTION</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Error al generar el htaccess para los quicklinks introducido por el Fix SQL INJECTION</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix exportador Ubiflow
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/ubiflow.php:119
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AND reservado_prop = 0
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
AND reservado_prop = 0
AND force_hide_prop = 0
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/ubiflow.php:234
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($ftp-&gt;put($ubiflowFTPuser.&quot;.zip&quot;, $ubiflowFTPuser.&quot;.zip&quot;)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($ftp-&gt;put($ubiflowFTPuser.&quot;.zip&quot;, $ubiflowFTPuser.&quot;.zip&quot;, FTP_BINARY)) {
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Convertido el exportador de Yaencontré al formato de Kyero
    </h6>
    <div class="card-body">
        Sustituir el archivo <code>/xml/yaencontre.php</code> por el de esta versión (Solo actualizar si son webs nuevas, si lo están usandolo mejor no tocarlo)
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> La query que envía los similares por email sacan también las propiedades que están ocultas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/similar-properties.php:62
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE activado_prop = 1 AND force_hide_prop = 0 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error breadcums introducido por el Fix SQL INJECTION
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/view/partials/breadcrumb.tpl
            </code>
        </pre>
        Buscar y remplazar <code>[]</code> por <code>%5B%5D</code>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al ordenar y cambiar número de inmuebles en el listado de la web introducido por el Fix SQL INJECTION
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:41
/modules/properties/properties.php:407
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
header(&quot;Location: $url&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (substr($url, -1) == &#039;?&#039;) {
    $url = str_replace(&quot;?&quot;, &quot;&quot;, $url);
    header(&quot;Location: $url&quot;);
}
header(&quot;Location: $url&quot;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al generar el htaccess para los quicklinks introducido por el Fix SQL INJECTION
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$tw = &#039;&#039;;
if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_town_nws&#039;]);
    foreach ($parts as $part) {
        $tw .= &#039;&amp;loct[]=&#039; . $part;
    }
}

$loc = &#039;&#039;;
if ($row_rsLandings[&#039;quick_location_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_location_nws&#039;]);
    foreach ($parts as $part) {
        $loc .= &#039;&amp;lozn[]=&#039; . $part;
    }
}

$typ = &#039;&#039;;
if ($row_rsLandings[&#039;quick_type_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_type_nws&#039;]);
    foreach ($parts as $part) {
        $typ .= &#039;&amp;tp[]=&#039; . $part;
    }
}

$sta = &#039;&#039;;
if ($row_rsLandings[&#039;quick_status_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_status_nws&#039;]);
    foreach ($parts as $part) {
        $sta .= &#039;&amp;st[]=&#039; . $part;
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$tw = &#039;&#039;;
if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_town_nws&#039;]);
    foreach ($parts as $part) {
        $tw .= &#039;&amp;loct%5B%5D=&#039; . $part;
    }
}

$loc = &#039;&#039;;
if ($row_rsLandings[&#039;quick_location_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_location_nws&#039;]);
    foreach ($parts as $part) {
        $loc .= &#039;&amp;lozn%5B%5D=&#039; . $part;
    }
}

$typ = &#039;&#039;;
if ($row_rsLandings[&#039;quick_type_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_type_nws&#039;]);
    foreach ($parts as $part) {
        $typ .= &#039;&amp;tp%5B%5D=&#039; . $part;
    }
}

$sta = &#039;&#039;;
if ($row_rsLandings[&#039;quick_status_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_status_nws&#039;]);
    foreach ($parts as $part) {
        $sta .= &#039;&amp;st%5B%5D=&#039; . $part;
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>