<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 23-05-2023</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al insertar un nuevo cliente</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajustado el sql con el que se crea el master</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al insertar un nuevo cliente
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:536
            </code>
        </pre>
        <pre>
            <code class="php">
$tNG-&gt;addColumn(&quot;fecha_alta_cli&quot;, &quot;DATE_TYPE&quot;, &quot;EXPRESSION&quot;, date(&quot;Y-m-d H:i:s&quot;));
            </code>
        </pre>
        <pre>
            <code class="php">
$tNG-&gt;addColumn(&quot;fecha_alta_cli&quot;, &quot;DATE_TYPE&quot;, &quot;EXPRESSION&quot;, date(&quot;d-m-Y H:i:s&quot;));
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustado el sql con el que se crea el master
    </h6>
    <div class="card-body">
        Ajustado el sql con el que se crea el master
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
