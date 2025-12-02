<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 26-07-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en el formulario de inmuebles</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Añadido checkbox para marcar si ha comprado una casa en clientes</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el formulario de inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1096
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE FIND_IN_SET('".$row_rsproperties_properties['referencia_prop']."', visited_cli)
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE FIND_IN_SET('".$row_rsproperties_properties['id_prop']."', visited_cli)
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido checkbox para marcar si ha comprado una casa en clientes
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_client` ADD COLUMN `ha_comprado_cli` INT(1) NULL DEFAULT 0 AFTER `b_tags_cli`;
ALTER TABLE `properties_client` ADD COLUMN `ref_comprado_cli` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `ha_comprado_cli`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:499
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;residencia_fiscal_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;residencia_fiscal_cli&quot;, &quot;0&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;residencia_fiscal_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;residencia_fiscal_cli&quot;, &quot;0&quot;);
$ins_properties_client-&gt;addColumn(&quot;ha_comprado_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;ha_comprado_cli&quot;, &quot;0&quot;);
$ins_properties_client-&gt;addColumn(&quot;ref_comprado_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;ref_comprado_cli&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:560
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;residencia_fiscal_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;residencia_fiscal_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;residencia_fiscal_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;residencia_fiscal_cli&quot;);
$upd_properties_client-&gt;addColumn(&quot;ha_comprado_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;ha_comprado_cli&quot;, &quot;0&quot;);
$upd_properties_client-&gt;addColumn(&quot;ref_comprado_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;ref_comprado_cli&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php: 888
            </code>
        </pre>
        Añadir despues del <code>&lt;/div&gt;</code>:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;
      &lt;div class=&quot;checkbox&quot;&gt;
        &lt;label&gt;
            &lt;br&gt;
            &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client[&#039;ha_comprado_cli&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;ha_comprado_cli&quot; id=&quot;ha_comprado_cli&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
            &lt;?php __(&#039;Ha comprado&#039;); ?&gt;
        &lt;/label&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;ref_comprado_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;ref_comprado_cli&quot;&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;:&lt;/label&gt;
            &lt;input type=&quot;text&quot; class=&quot;form-control select2references2&quot; id=&quot;ref_comprado_cli&quot; name=&quot;ref_comprado_cli&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
            &lt;!-- &lt;select name=&quot;ref_comprado_cli[]&quot; id=&quot;ref_comprado_cli&quot; multiple class=&quot;form-control select2&quot;&gt;
              &lt;?php do {
                $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;ref_comprado_cli&#039;]);
              ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsReferencias[&#039;name&#039;] ?&gt;&quot; &lt;?php if (in_array($row_rsReferencias[&#039;name&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsReferencias[&#039;name&#039;] ?&gt;&lt;/option&gt;
              &lt;?php } while ($row_rsReferencias = mysql_fetch_assoc($rsReferencias));
              $rows = mysql_num_rows($rsReferencias );
              if($rows &gt; 0) {
                  mysql_data_seek($rsReferencias , 0);
                $row_rsReferencias = mysql_fetch_assoc($rsReferencias );
              } ?&gt;
            &lt;/select&gt; --&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;ref_comprado_cli&quot;); ?&gt;
        &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2189
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.select2references&#039;).select2({
    multiple:true,
    ajax: {
    url: function (params) {
        return &#039;/intramedianet/properties/properties-references-select.php?q=&#039; + params;
    },
    dataType: &#039;json&#039;,
    delay: 250,
    results: function (data, params) {
        return {
            results: data.results
        };
    },
    // cache: true,
    },
    placeholder: &#039;&#039;,
    minimumInputLength: 3,
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.select2references&#039;).select2({
    multiple:true,
    ajax: {
    url: function (params) {
        return &#039;/intramedianet/properties/properties-references-select.php?q=&#039; + params;
    },
    dataType: &#039;json&#039;,
    delay: 250,
    results: function (data, params) {
        return {
            results: data.results
        };
    },
    // cache: true,
    },
    placeholder: &#039;&#039;,
    minimumInputLength: 3,
});
$(&#039;.select2references2&#039;).select2({
    multiple:true,
    ajax: {
    url: function (params) {
        return &#039;/intramedianet/properties/properties-references-select.php?q=&#039; + params;
    },
    dataType: &#039;json&#039;,
    delay: 250,
    results: function (data, params) {
        return {
            results: data.results
        };
    },
    // cache: true,
    },
    placeholder: &#039;&#039;,
    minimumInputLength: 3,
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2225
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($row_rsproperties_client[&#039;visited_cli&#039;] != &#039;&#039;): ?&gt;
$.ajax({
    type: &#039;GET&#039;,
    dataType: &#039;json&#039;,
    url: &#039;/intramedianet/properties/properties-references-select-multiple.php?q=&lt;?php echo $row_rsproperties_client[&#039;visited_cli&#039;] ?&gt;&#039;
}).done(function (data) {
    $(&quot;.select2references&quot;).select2(&#039;data&#039;, data);
});
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($row_rsproperties_client[&#039;visited_cli&#039;] != &#039;&#039;): ?&gt;
$.ajax({
    type: &#039;GET&#039;,
    dataType: &#039;json&#039;,
    url: &#039;/intramedianet/properties/properties-references-select-multiple.php?q=&lt;?php echo $row_rsproperties_client[&#039;visited_cli&#039;] ?&gt;&#039;
}).done(function (data) {
    $(&quot;.select2references&quot;).select2(&#039;data&#039;, data);
});
&lt;?php endif ?&gt;
&lt;?php if ($row_rsproperties_client[&#039;ref_comprado_cli&#039;] != &#039;&#039;): ?&gt;
$.ajax({
    type: &#039;GET&#039;,
    dataType: &#039;json&#039;,
    url: &#039;/intramedianet/properties/properties-references-select-multiple.php?q=&lt;?php echo $row_rsproperties_client[&#039;ref_comprado_cli&#039;] ?&gt;&#039;
}).done(function (data) {
    $(&quot;.select2references2&quot;).select2(&#039;data&#039;, data);
});
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Ha comprado&#039;] = &#039;Ha comprado&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Ha comprado&#039;] = &#039;Has bought&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
