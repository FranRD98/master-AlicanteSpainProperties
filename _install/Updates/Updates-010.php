<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 5-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Bug de Bootstrap que hace que se visualice mal el contador de propiedades del cambio de vistas</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Aparece la pestaña “Location” aunque no tenga latitud ni longitud</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Faltan dos variables (actNoticias y fromMail) para poder usarlas en los .tpl</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug de Bootstrap que hace que se visualice mal el contador de propiedades del cambio de vistas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss
            </code>
        </pre>
        Añañdir a @group PROPIADEDES VISTAS:
        <pre>
            <code class="css">
.vistas-prop {
    .btn .badge{
        position: absolute;
        top: 5px;
        right: 15px;
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

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Aparece la pestaña “Location” aunque no tenga latitud ni longitud
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tabs.tpl:9
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $property[0].lat != &#039;&#039; || $property[0].show_direccion_prop == &#039;1&rsquo;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $property[0].lat &gt; 0 || $property[0].show_direccion_prop == &#039;1&#039;}
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Faltan dos variables (actNoticias y fromMail) para poder usarlas en los .tpl
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:153
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;actMapaPropiedades&quot;, $actMapaPropiedades);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;actMapaPropiedades&quot;, $actMapaPropiedades);
$smarty-&gt;assign(&quot;actNoticias&quot;, $actNoticias);
$smarty-&gt;assign(&quot;fromMail&quot;, $fromMail);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
