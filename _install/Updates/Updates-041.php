<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 24-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error al cambiar de vista en el lisdato de inmuebles introducido por el Fix SQL INJECTION</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error de la librería PHPTHUMB</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al cambiar de vista en el lisdato de inmuebles introducido por el Fix SQL INJECTION
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/set-view.php:7
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
header(&quot;Location: &quot; . urldecode($_GET[&#039;url&#039;]));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
header(&quot;Location: &quot; . $_GET[&#039;url&#039;]);
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error de la librería PHPTHUMB
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/includes/phpthumb/ThumbBase.inc.php:164
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (stristr($this-&gt;fileName, &#039;http://&#039;) !== false)
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (stristr($this-&gt;fileName, &#039;http://&#039;) !== false || stristr($this-&gt;fileName, &#039;https://&#039;) !== false)
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>