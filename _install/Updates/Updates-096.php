<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 29-08-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>Error del exportador de fotocasa al enviar videos y 360</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>Unknown column 'properties_properties.coeficiente_ocupacion_prop' in 'field list’</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error del exportador de fotocasa al enviar videos y 360
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaExportProperty.php:490
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$imgArr[&quot;Url&quot;] = echo str_replace(&quot;embed/&quot;,&quot;watch?v=&quot;, str_replace(&quot;?rel=0&quot;,&quot;&quot;, $video[0]));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$imgArr[&quot;Url&quot;] = str_replace(&quot;embed/&quot;,&quot;watch?v=&quot;, str_replace(&quot;?rel=0&quot;,&quot;&quot;, $video[0]));
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaExportProperty.php:509
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$imgArr[&quot;Url&quot;] = echo str_replace(&quot;embed/&quot;,&quot;watch?v=&quot;, str_replace(&quot;?rel=0&quot;,&quot;&quot;, $result[&apos;src&apos;][0]));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$imgArr[&quot;Url&quot;] = str_replace(&quot;embed/&quot;,&quot;watch?v=&quot;, str_replace(&quot;?rel=0&quot;,&quot;&quot;, $result[&apos;src&apos;][0]));
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Unknown column 'properties_properties.coeficiente_ocupacion_prop' in 'field list’
    </h6>
    <div class="card-body">
       Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `coeficiente_ocupacion_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `referencia_catrastal_prop`;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
