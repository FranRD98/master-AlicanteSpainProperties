<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 13-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Mejoras SEO quicklinks</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Mejoras SEO noticias</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Problema al duplicar los inmuebles</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejoras SEO quicklinks
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/view/index.tpl:39
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;div class=&quot;container&quot;&gt;
    &lt;div class=&quot;row&quot;&gt;
        &lt;div class=&quot;col-md-12&quot;&gt;
            &lt;div class=&quot;page-content&quot;&gt;
                {$pagetext}
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
{if $smarty.get.idquick == &#039;&#039;}
&lt;div class=&quot;container&quot;&gt;
    &lt;div class=&quot;row&quot;&gt;
        &lt;div class=&quot;col-md-12&quot;&gt;
            &lt;div class=&quot;page-content&quot;&gt;
                {$pagetext}
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
{/if}
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejoras SEO noticias
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/view/index.tpl:8
            </code>
        </pre>
        Eliminar la linea:
        <pre>
            <code class="php">
{$pagetext}
            </code>
        </pre>
        Añadir antes de <code>{include file="footer.tpl"}</code>:
        <pre>
            <code class="html">
&lt;div class=&quot;container&quot;&gt;
    &lt;div class=&quot;row&quot;&gt;
        &lt;div class=&quot;col-md-12&quot;&gt;
            &lt;div class=&quot;page-content&quot;&gt;
                {$pagetext}
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Problema al duplicar los inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-dupli.php:409
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
echo $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$row_rsRegistros[&#039;image_img&#039;];
echo &quot;&lt;br&gt;&quot;;
echo $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$newname;
echo &quot;&lt;hr&gt;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-dupli.php:520
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
header(&quot;Location: /intramedianet/properties/properties-form.php?id_prop=&quot;.$prop);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
header(&quot;Location: /intramedianet/properties/properties-form.php?id_prop=&quot;.$prop.&quot;&amp;u=ok&quot;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
