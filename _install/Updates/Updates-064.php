<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 20-02-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error codificación en actualizar fotocasa</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error codificación en actualizar fotocasa
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaBulkExportProperty.php:66
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
foreach ($languages as $lg) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&#xd3;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; utf8_encode(substr(strip_tags($row_rsFotocasaProperty[&apos;descripcion_&apos;.$lg.&apos;_prop&apos;]), 0, 300).&quot;...&quot;),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&#xd3;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; utf8_encode(strip_tags($row_rsFotocasaProperty[&apos;descripcion_&apos;.$lg.&apos;_prop&apos;])),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
foreach ($languages as $lg) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&#xd3;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($row_rsFotocasaProperty[&apos;descripcion_&apos;.$lg.&apos;_prop&apos;]), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&#xd3;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; strip_tags($row_rsFotocasaProperty[&apos;descripcion_&apos;.$lg.&apos;_prop&apos;]),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>