<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 18-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Errores en las etiquetas hreflang</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Mejorada la velocidad al borrar inmuebles</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Errores en las etiquetas hreflang
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/init.php:25
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ( $_GET[&#039;lang&#039;] != &#039;&#039; &amp;&amp; !in_array($_GET[&#039;lang&#039;], $languages)) {
    die(&quot;Idioma no permitido&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ( $_GET[&#039;lang&#039;] != &#039;&#039; &amp;&amp; !in_array($_GET[&#039;lang&#039;], $languages)) {
    die(&quot;Idioma no permitido&quot;);
}

if ($_GET[&#039;lang&#039;] == $language) {
    header(&quot;HTTP/1.1 301 Moved Permanently&quot;);
    header(&quot;Location: &quot; . str_replace(&#039;/&#039; . $_GET[&#039;lang&#039;] . &#039;/&#039;, &#039;/&#039;, $_SERVER[&#039;REQUEST_URI&#039;]));
}
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejorada la velocidad al borrar inmuebles
    </h6>
    <div class="card-body">
        En el archivo <code>/intramedianet/properties/properties-form.php</code> comentar las lineas:
        <pre>
            <code class="php">
/intramedianet/properties/properties-form.php:437 -> <code>$tblDelObj-&gt;addFile(&quot;{file_fil}&quot;, &quot;../../media/files/properties/&quot;);</code>
/intramedianet/properties/properties-form.php:446 -> <code>$tblDelObj-&gt;addFile(&quot;{file_fil}&quot;, &quot;../../media/files/data/&quot;);</code>
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
