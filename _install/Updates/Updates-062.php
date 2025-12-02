<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 31-01-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Tamaño máximo de imágenes de propiedades</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error ordenar por fecha tablas del formulario de cliente</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error internet explorer</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Tamaño máximo de imágenes de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js:177
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
max_file_size : &#039;100mb&#039;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
max_file_size : &#039;5mb&#039;,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error ordenar por fecha tablas del formulario de cliente
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1518
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple&quot; id=&quot;events-table&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple3&quot; id=&quot;events-table&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1561
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
<table class="table table-striped table-bordered records-tables-simple" id="tasks-table">
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
<table class="table table-striped table-bordered records-tables-simple4" id="tasks-table">
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.records-tables-simple&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039;tr&gt;&gt;&quot; +
  &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-6&#039;i&gt;&lt;&#039;col-sm-6&#039;p&gt;&gt;&quot;,
  &quot;iDisplayStart&quot;: 0,
  &quot;iDisplayLength&quot;: 20,
  &quot;bProcessing&quot;: false,
  &quot;bStateSave&quot;: false,
  &quot;bServerSide&quot;: false
});

$(&#039;.records-tables-simple2&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; ftr&gt;&gt;&quot; +
  &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-6&#039;i&gt;&lt;&#039;col-sm-6&#039;p&gt;&gt;&quot;,
  &quot;iDisplayStart&quot;: 0,
  &quot;iDisplayLength&quot;: 20,
  &quot;bProcessing&quot;: false,
  &quot;bStateSave&quot;: false,
  &quot;bServerSide&quot;: false,
  language: {
      searchPlaceholder: strSearch
  }
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.records-tables-simple&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039;tr&gt;&gt;&quot; +
  &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-6&#039;i&gt;&lt;&#039;col-sm-6&#039;p&gt;&gt;&quot;,
  &quot;iDisplayStart&quot;: 0,
  &quot;iDisplayLength&quot;: 20,
  &quot;bProcessing&quot;: false,
  &quot;bStateSave&quot;: false,
  &quot;bServerSide&quot;: false,
  &quot;columnDefs&quot;: [
      { &quot;type&quot;: &quot;date-euro&quot;, targets: 2 }
  ]
});

$(&#039;.records-tables-simple2&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; ftr&gt;&gt;&quot; +
  &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-6&#039;i&gt;&lt;&#039;col-sm-6&#039;p&gt;&gt;&quot;,
  &quot;iDisplayStart&quot;: 0,
  &quot;iDisplayLength&quot;: 20,
  &quot;bProcessing&quot;: false,
  &quot;bStateSave&quot;: false,
  &quot;bServerSide&quot;: false,
  language: {
      searchPlaceholder: strSearch
  },
  &quot;columnDefs&quot;: [
      { &quot;type&quot;: &quot;date-euro&quot;, targets: 4 }
  ]
});

$(&#039;.records-tables-simple3&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039;tr&gt;&gt;&quot; +
  &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-6&#039;i&gt;&lt;&#039;col-sm-6&#039;p&gt;&gt;&quot;,
  &quot;iDisplayStart&quot;: 0,
  &quot;iDisplayLength&quot;: 20,
  &quot;bProcessing&quot;: false,
  &quot;bStateSave&quot;: false,
  &quot;bServerSide&quot;: false,
  &quot;columnDefs&quot;: [
      { &quot;type&quot;: &quot;date-euro&quot;, targets: 2 },
      { &quot;type&quot;: &quot;date-euro&quot;, targets: 3 }
  ]
});

$(&#039;.records-tables-simple4&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039;tr&gt;&gt;&quot; +
  &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-6&#039;i&gt;&lt;&#039;col-sm-6&#039;p&gt;&gt;&quot;,
  &quot;iDisplayStart&quot;: 0,
  &quot;iDisplayLength&quot;: 20,
  &quot;bProcessing&quot;: false,
  &quot;bStateSave&quot;: false,
  &quot;bServerSide&quot;: false,
  &quot;columnDefs&quot;: [
      { &quot;type&quot;: &quot;date-euro&quot;, targets: 3 }
  ]
});
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error internet explorer
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/precios.js:39
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function printOptionSelect (optionText, selectSelected, optionValue = &quot;&quot;){
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function printOptionSelect (optionText, selectSelected, optionValue){
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/precios.js:50
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var returnStr = printOptionSelect(texto, seleccionado);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var returnStr = printOptionSelect(texto, seleccionado, &quot;&quot;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>