<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 1 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 27-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error campo select en buscador avanzado</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error campo select en buscador avanzado
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/search/view/index.tpl:16
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;select name=&quot;st&quot; id=&quot;st&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;st[]&quot; id=&quot;st&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>