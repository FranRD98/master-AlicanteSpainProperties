<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 25-01-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en el header.tpl</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Mejora Listado propiedades del panel</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el header.tpl
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;meta name=&quot;ROBOTS&quot; content=&ldquo;NOINDEX&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;meta name=&quot;ROBOTS&quot; content=&quot;NOINDEX&quot;&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora Listado propiedades del panel
    </h6>
    <div class="card-body">
        Sobreescribe .os archivos <code>/intramedianet/properties/properties.php</code>, <code>/intramedianet/properties/search-properties.php</code> y <code>/intramedianet/properties/_js/properties-list.js</code> por los de esta versión.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>