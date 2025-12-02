<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 23-01-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Mejora de velocidad SEO</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> ERROR Exportador Idealista</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error formulario de propiedades</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora de velocidad SEO
    </h6>
    <div class="card-body">
        Añadir al archivo <code>/.htaccess</code>:
        <pre>
            <code class="php">
SetOutputFilter DEFLATE
&lt;FilesMatch &quot;\.(js|css|ico|pdf|jpg|jpeg|png|gif)$&quot;&gt;
Header set Cache-Control &quot;public&quot;
Header set Expires &quot;Thu, 15 Apr 2020 20:00:00 GMT&quot;
&lt;/FilesMatch&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> ERROR Exportador Idealista
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$idealistaContactEmail = &#039;&#039;; // Requerido
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$idealistaContactEmail = &#039;&#039;; // Requerido
$idealistaContactName = &#039;&#039;; // Requerido
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista.php:474
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;prefix&gt;&quot;.$idealistaContactPhonePrefix.&quot;&lt;/prefix&gt;
&lt;number&gt;&quot;.$idealistaContactPhoneNumber.&quot;&lt;/number&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;prefix&gt;&quot;.$idealistaContactPrimaryPhonePrefix.&quot;&lt;/prefix&gt;
&lt;number&gt;&quot;.$idealistaContactPrimaryPhoneNumber.&quot;&lt;/number&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:5024
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script&gt;
// Si cambia el checkbox de idealista muestra el formulario
$(&#039;#idealista_prop&#039;).change(function(e) {
  e.preventDefault();
  if ($(this).is(&#039;:checked&#039;) == true) {
    $(&#039;#basicIdealista&#039;).fadeIn(&#039;slow&#039;);
    var $val1 = $(&#039;#idealistaPropertyStatusId&#039;).val();
    var $val2 = $(&#039;#idealistaTransactionTypeId&#039;).val();
    var $val3 = $(&#039;#idealistaTypeId&#039;).val();
    if ( $val1 != &quot;&quot; &amp;&amp; $val2 != &quot;&quot; &amp;&amp; $val3 != &quot;&quot; ) {
      $(&#039;#featuresIdealista&#039;).fadeIn(&#039;slow&#039;);
    }
  } else{
    $(&#039;#basicIdealista, #featuresIdealista&#039;).fadeOut(&#039;slow&#039;);
  }
});
&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script&gt;
// Si cambia el checkbox de idealista muestra el formulario
// $(&#039;#idealista_prop&#039;).change(function(e) {
//   e.preventDefault();
//   if ($(this).is(&#039;:checked&#039;) == true) {
//     $(&#039;#basicIdealista&#039;).fadeIn(&#039;slow&#039;);
//     var $val1 = $(&#039;#idealistaPropertyStatusId&#039;).val();
//     var $val2 = $(&#039;#idealistaTransactionTypeId&#039;).val();
//     var $val3 = $(&#039;#idealistaTypeId&#039;).val();
//     if ( $val1 != &quot;&quot; &amp;&amp; $val2 != &quot;&quot; &amp;&amp; $val3 != &quot;&quot; ) {
//       $(&#039;#featuresIdealista&#039;).fadeIn(&#039;slow&#039;);
//     }
//   } else{
//     $(&#039;#basicIdealista, #featuresIdealista&#039;).fadeOut(&#039;slow&#039;);
//   }
// });
&lt;/script&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error formulario de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4096
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple&quot; id=&quot;history-table&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple3&quot; id=&quot;history-table&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4150
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple&quot; id=&quot;visits-table&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple4&quot; id=&quot;visits-table&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4186
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
&lt;table class=&quot;table table-striped table-bordered records-tables-simple5&quot; id=&quot;events-table&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$(&#039;.records-tables-simple3&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; ftr&gt;&gt;&quot; +
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

$(&#039;.records-tables-simple4&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; ftr&gt;&gt;&quot; +
  &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-6&#039;i&gt;&lt;&#039;col-sm-6&#039;p&gt;&gt;&quot;,
  &quot;iDisplayStart&quot;: 0,
  &quot;iDisplayLength&quot;: 20,
  &quot;bProcessing&quot;: false,
  &quot;bStateSave&quot;: false,
  &quot;bServerSide&quot;: false
});

$(&#039;.records-tables-simple5&#039;).dataTable({
  dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; ftr&gt;&gt;&quot; +
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
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>