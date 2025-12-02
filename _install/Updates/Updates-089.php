<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 09-05-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadido emisiones a las propiedades</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido emisiones a las propiedades
    </h6>
    <div class="card-body">

        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `emisiones_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:878
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;energia_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;energia_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;energia_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;energia_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;emisiones_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;emisiones_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1106
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;energia_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;energia_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;energia_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;energia_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;emisiones_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;emisiones_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1751
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;energia_prop&quot;) != &apos;&apos;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;energia_prop&quot;&gt;&lt;?php __(&apos;Calificaci&#xf3;n energ&#xe9;tica&apos;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;energia_prop&quot; id=&quot;energia_prop&quot; class=&quot;form-control select2&quot;&gt;
        &lt;option value=&quot;&quot;&lt;?php if (!(strcmp(&apos;&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php __(&apos;En proceso&apos;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;A&quot;&lt;?php if (!(strcmp(&apos;A&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;A&lt;/option&gt;
        &lt;option value=&quot;B&quot;&lt;?php if (!(strcmp(&apos;B&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;B&lt;/option&gt;
        &lt;option value=&quot;C&quot;&lt;?php if (!(strcmp(&apos;C&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;C&lt;/option&gt;
        &lt;option value=&quot;D&quot;&lt;?php if (!(strcmp(&apos;D&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;D&lt;/option&gt;
        &lt;option value=&quot;E&quot;&lt;?php if (!(strcmp(&apos;E&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;E&lt;/option&gt;
        &lt;option value=&quot;F&quot;&lt;?php if (!(strcmp(&apos;F&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;F&lt;/option&gt;
        &lt;option value=&quot;G&quot;&lt;?php if (!(strcmp(&apos;G&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;G&lt;/option&gt;
    &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;energia_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;energia_prop&quot;) != &apos;&apos;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;energia_prop&quot;&gt;&lt;?php __(&apos;Calificaci&#xf3;n energ&#xe9;tica&apos;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;energia_prop&quot; id=&quot;energia_prop&quot; class=&quot;form-control select2&quot;&gt;
        &lt;option value=&quot;&quot;&lt;?php if (!(strcmp(&apos;&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php __(&apos;En proceso&apos;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;A&quot;&lt;?php if (!(strcmp(&apos;A&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;A&lt;/option&gt;
        &lt;option value=&quot;B&quot;&lt;?php if (!(strcmp(&apos;B&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;B&lt;/option&gt;
        &lt;option value=&quot;C&quot;&lt;?php if (!(strcmp(&apos;C&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;C&lt;/option&gt;
        &lt;option value=&quot;D&quot;&lt;?php if (!(strcmp(&apos;D&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;D&lt;/option&gt;
        &lt;option value=&quot;E&quot;&lt;?php if (!(strcmp(&apos;E&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;E&lt;/option&gt;
        &lt;option value=&quot;F&quot;&lt;?php if (!(strcmp(&apos;F&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;F&lt;/option&gt;
        &lt;option value=&quot;G&quot;&lt;?php if (!(strcmp(&apos;G&apos;, $row_rsproperties_properties[&apos;energia_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;G&lt;/option&gt;
    &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;energia_prop&quot;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;emisiones_prop&quot;) != &apos;&apos;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;emisiones_prop&quot;&gt;&lt;?php __(&apos;Emisiones&apos;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;emisiones_prop&quot; id=&quot;emisiones_prop&quot; class=&quot;form-control select2&quot;&gt;
        &lt;option value=&quot;&quot;&lt;?php if (!(strcmp(&apos;&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php __(&apos;En proceso&apos;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;A&quot;&lt;?php if (!(strcmp(&apos;A&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;A&lt;/option&gt;
        &lt;option value=&quot;B&quot;&lt;?php if (!(strcmp(&apos;B&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;B&lt;/option&gt;
        &lt;option value=&quot;C&quot;&lt;?php if (!(strcmp(&apos;C&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;C&lt;/option&gt;
        &lt;option value=&quot;D&quot;&lt;?php if (!(strcmp(&apos;D&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;D&lt;/option&gt;
        &lt;option value=&quot;E&quot;&lt;?php if (!(strcmp(&apos;E&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;E&lt;/option&gt;
        &lt;option value=&quot;F&quot;&lt;?php if (!(strcmp(&apos;F&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;F&lt;/option&gt;
        &lt;option value=&quot;G&quot;&lt;?php if (!(strcmp(&apos;G&apos;, $row_rsproperties_properties[&apos;emisiones_prop&apos;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;G&lt;/option&gt;
    &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;emisiones_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.energia_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_properties.energia_prop,
properties_properties.emisiones_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:309
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($row_idealista[&apos;energia_prop&apos;] != 0 &amp;&amp; $row_idealista[&apos;energia_prop&apos;] != &apos;&apos;) {
    $Content .= &apos;&quot;featuresEnergyCertificateRating&quot;: &quot;&apos; . $row_idealista[&apos;energia_prop&apos;] . &apos;&quot;,&apos;;
} else {
    $Content .= &apos;&quot;featuresEnergyCertificateRating&quot;: &quot;inProcess&quot;,&apos;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_idealista[&apos;energia_prop&apos;] != 0 &amp;&amp; $row_idealista[&apos;energia_prop&apos;] != &apos;&apos;) {
    $Content .= &apos;&quot;featuresEnergyCertificateRating&quot;: &quot;&apos; . $row_idealista[&apos;energia_prop&apos;] . &apos;&quot;,&apos;;
} else {
    $Content .= &apos;&quot;featuresEnergyCertificateRating&quot;: &quot;inProcess&quot;,&apos;;
}
if ($row_idealista[&apos;emisiones_prop&apos;] != 0 &amp;&amp; $row_idealista[&apos;emisiones_prop&apos;] != &apos;&apos;) {
    $Content .= &apos;&quot;featuresEnergyCertificateEmissionsRating&quot;: &quot;&apos; . $row_idealista[&apos;emisiones_prop&apos;] . &apos;&quot;,&apos;;
} else {
    $Content .= &apos;&quot;featuresEnergyCertificateEmissionsRating&quot;: &quot;inProcess&quot;,&apos;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaExportProperty.php:98
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if( $tNG-&gt;getColumnValue(&apos;energia_prop&apos;) &amp;&amp; $tNG-&gt;getColumnValue(&apos;energia_prop&apos;) != &quot;&quot;){
    switch ($tNG-&gt;getColumnValue(&apos;energia_prop&apos;)) {
        case &apos;A&apos;:
            $calEnerg = 1;
            break;
        case &apos;B&apos;:
            $calEnerg = 2;
            break;
        case &apos;C&apos;:
            $calEnerg = 3;
            break;
        case &apos;D&apos;:
            $calEnerg = 4;
            break;
        case &apos;E&apos;:
            $calEnerg = 5;
            break;
        case &apos;F&apos;:
            $calEnerg = 6;
            break;
        case &apos;G&apos;:
            $calEnerg = 7;
            break;
        default:
            $calEnerg = 8;
            break;
    }
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // CALIFICACI&#xd3;N ENERG&#xc9;TICA
        &quot;FeatureId&quot; =&gt; 317,
        &quot;DecimalValue&quot; =&gt; (int)$calEnerg,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[&quot;es&quot;],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // CALIFICACI&#xd3;N ENERG&#xc9;TICA
        &quot;FeatureId&quot; =&gt; 317,
        &quot;DecimalValue&quot; =&gt; 8,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[&quot;es&quot;],
    );
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if( $tNG-&gt;getColumnValue(&apos;energia_prop&apos;) &amp;&amp; $tNG-&gt;getColumnValue(&apos;energia_prop&apos;) != &quot;&quot;){
    switch ($tNG-&gt;getColumnValue(&apos;energia_prop&apos;)) {
        case &apos;A&apos;:
            $calEnerg = 1;
            break;
        case &apos;B&apos;:
            $calEnerg = 2;
            break;
        case &apos;C&apos;:
            $calEnerg = 3;
            break;
        case &apos;D&apos;:
            $calEnerg = 4;
            break;
        case &apos;E&apos;:
            $calEnerg = 5;
            break;
        case &apos;F&apos;:
            $calEnerg = 6;
            break;
        case &apos;G&apos;:
            $calEnerg = 7;
            break;
        default:
            $calEnerg = 8;
            break;
    }
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // CALIFICACI&#xd3;N ENERG&#xc9;TICA
        &quot;FeatureId&quot; =&gt; 317,
        &quot;DecimalValue&quot; =&gt; (int)$calEnerg,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[&quot;es&quot;],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // CALIFICACI&#xd3;N ENERG&#xc9;TICA
        &quot;FeatureId&quot; =&gt; 317,
        &quot;DecimalValue&quot; =&gt; 8,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[&quot;es&quot;],
    );
}
if( $tNG-&gt;getColumnValue(&apos;emisiones_prop&apos;) &amp;&amp; $tNG-&gt;getColumnValue(&apos;emisiones_prop&apos;) != &quot;&quot;){
    switch ($tNG-&gt;getColumnValue(&apos;emisiones_prop&apos;)) {
        case &apos;A&apos;:
            $calEnerg = 1;
            break;
        case &apos;B&apos;:
            $calEnerg = 2;
            break;
        case &apos;C&apos;:
            $calEnerg = 3;
            break;
        case &apos;D&apos;:
            $calEnerg = 4;
            break;
        case &apos;E&apos;:
            $calEnerg = 5;
            break;
        case &apos;F&apos;:
            $calEnerg = 6;
            break;
        case &apos;G&apos;:
            $calEnerg = 7;
            break;
        default:
            $calEnerg = 8;
            break;
    }
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // CALIFICACI&#xd3;N ENERG&#xc9;TICA
        &quot;FeatureId&quot; =&gt; 324,
        &quot;DecimalValue&quot; =&gt; (int)$calEnerg,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[&quot;es&quot;],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // CALIFICACI&#xd3;N ENERG&#xc9;TICA
        &quot;FeatureId&quot; =&gt; 324,
        &quot;DecimalValue&quot; =&gt; 8,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[&quot;es&quot;],
    );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&apos;Emisiones&apos;] = &apos;Emisiones&apos;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&apos;Emisiones&apos;] = &apos;Emissions&apos;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
