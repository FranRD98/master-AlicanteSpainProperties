<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 11-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Problema al generar miniaturas con watermark</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Al seleccionar un proveedor como tipo KyeroV3, la fila de dicho proveedor se rompe</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Problema al generar miniaturas con watermark
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/imagenes.php:28
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$watermarkOpacity = .7;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$watermarkOpacity = 70;
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Al seleccionar un proveedor como tipo KyeroV3, la fila de dicho proveedor se rompe
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores-form.php:261
            </code>
        </pre>
        Eliminar la línea:
        <pre>
            <code class="php">
&lt;option value=&quot;3&quot; &lt;?php if (!(strcmp(3, $row_rsxml[&#039;tipo_xml&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;Kyero V3&lt;/option&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
