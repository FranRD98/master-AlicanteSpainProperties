<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 17-09-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en el buscador con el mapa de propiedades</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Campos Requeridos en properties-form.php</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Añadido archivo para enviar el formulario de vender propiedad en las webs de inmovilla</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el buscador con el mapa de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/buscador.tpl:1
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $seccion == $url_property_map}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $actMapaPropiedades &amp;&amp; $seccion == $url_property_map}
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Campos Requeridos en properties-form.php
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/iintramedianet/properties/properties-form.php:378
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$formValidation-&gt;addField(&quot;referencia_prop&quot;, true, &quot;text&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$formValidation-&gt;addField(&quot;referencia_prop&quot;, true, &quot;text&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;);
if( isset($_GET[&quot;id_prop&quot;]) &amp;&amp; $_GET[&quot;id_prop&quot;] != &quot;&quot; &amp;&amp; $_GET[&quot;id_prop&quot;] != 0 ){
    $formValidation-&gt;addField(&quot;operacion_prop&quot;, true, &quot;text&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;);
    $formValidation-&gt;addField(&quot;tipo_prop&quot;, true, &quot;text&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;);
    $formValidation-&gt;addField(&quot;localidad_prop&quot;, true, &quot;text&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;);
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
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido archivo para enviar el formulario de vender propiedad en las webs de inmovilla
    </h6>
    <div class="card-body">
        Sustituir el archivo <code>/modules/vender/send.php</code> por el de tu versión.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>