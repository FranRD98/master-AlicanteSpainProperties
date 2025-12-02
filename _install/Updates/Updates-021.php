<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 6 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 10-07-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error al generar los sitemaps, ahora siempre los añade a un archivo gz</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Eliminada errata en el texto de gdpr para los formularios</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error al insertar en la página vender propiedad</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Errror en el menu llamadas en la cabecera de la administración</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Bug zoom maps propiedades importadas</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Error en el desplegable de imprimir propiedad del panel</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido traducciones de pago de google</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al generar los sitemaps, ahora siempre los añade a un archivo gz
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/SitemapGenerator.php:204
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sizeof($this-&gt;sitemaps) &gt; 1) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (sizeof($this-&gt;sitemaps) &gt; 0) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminada errata en el texto de gdpr para los formularios
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/gdpr.php:11
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;b&gt;Responsable del tramineto:&lt;/b&gt; $empresa_GDPR,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;b&gt;Responsable del tratamiento:&lt;/b&gt; $empresa_GDPR,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al insertar en la página vender propiedad
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-review-add.php:80
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsInserProperty = &quot;
INSERT INTO properties_properties (referencia_prop, operacion_prop, tipo_prop, localidad_prop, owner_prop, direccion_prop, habitaciones_prop, aseos_prop, m2_prop, m2_parcela_prop, preci_reducidoo_prop, reducido_prop, cerca_mar_prop, vistas_mar_prop, exclusivo_prop, notas_prop, inserted_xml_prop, updated_prop)
VALUES (&#039;&quot;.$referencia.&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;estado_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;tipo_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;zona_prp&#039;].&quot;&#039;, &#039;&quot;.$owner_id.&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;direccion_prp&#039;].&quot;, &quot;.$row_rsReviewPropsUsrs[&#039;cp_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;habitaciones_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;banos_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;m2_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;m2p_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;precio_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;reducido_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;cercamar_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;vistasmar_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;exclusiva_prp&#039;].&quot;&#039;, &#039;&quot;.$notas.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;);
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsInserProperty = &quot;
INSERT INTO properties_properties (referencia_prop, operacion_prop, tipo_prop, localidad_prop, owner_prop, direccion_prop, cp_prop, habitaciones_prop, aseos_prop, m2_prop, m2_parcela_prop, preci_reducidoo_prop, notas_prop, inserted_xml_prop, updated_prop)
VALUES (&#039;&quot;.$referencia.&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;estado_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;tipo_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;zona_prp&#039;].&quot;&#039;, &#039;&quot;.$owner_id.&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;direccion_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;cp_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;habitaciones_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;banos_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;m2_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;m2p_prp&#039;].&quot;&#039;, &#039;&quot;.$row_rsReviewPropsUsrs[&#039;precio_prp&#039;].&quot;&#039;, &#039;&quot;.$notas.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;);
&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Errror en el menu llamadas en la cabecera de la administración
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:115
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE next_call_pro != &#039;0000-00-00&#039;  AND next_call_pro &lt;= NOW() AND id_pro IN (&quot;.$row_rsLlamadasPropIDSprops[&#039;total&#039;].&quot;)
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE next_call_pro != &#039;0000-00-00&#039;  AND next_call_pro &lt;= NOW() AND id_pro IN (&quot;.trim($row_rsLlamadasPropIDSprops[&#039;total&#039;],&#039;,&#039;).&quot;)
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug zoom maps propiedades importadas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:360
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
showMapProperty(&#039;.gmap&#039;, [{$property[0].lat}], {$property[0].zoom});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $property[0].zoom &gt; 0}
    showMapProperty(&#039;.gmap&#039;, [{$property[0].lat}], {$property[0].zoom});
{else}
    showMapProperty(&#039;.gmap&#039;, [{$property[0].lat}], 16);
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el desplegable de imprimir propiedad del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-list.js:201
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4 W&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3 W&lt;/a&gt; &#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns += &#039;&lt;li class=&quot;clearfix&quot;&gt;&#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4 W&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3 W&lt;/a&gt; &#039;;
btns += &#039;&lt;/li&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-list.js:280
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4 W&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3 W&lt;/a&gt; &#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns += &#039;&lt;li class=&quot;clearfix&quot;&gt;&#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4 W&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3 W&lt;/a&gt; &#039;;
btns += &#039;&lt;/li&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-list.js:370
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4 W&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3&lt;/a&gt; &#039;;
btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3 W&lt;/a&gt; &#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns += &#039;&lt;li class=&quot;clearfix&quot;&gt;&#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A4 W&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3&lt;/a&gt; &#039;;
    btns += &#039;&lt;a href=&quot;http://&#039;+host+&#039;/modules/property/save-a3-mb.php?id=&#039; + row[numCols] + &#039;&amp;lang=&#039; + langs[i] + &#039;&quot; target=&quot;_blank&quot; style=&quot;float:left;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/flags-langs/&#039; + langs[i] + &#039;.png&quot; alt=&quot;&quot;&gt; A3 W&lt;/a&gt; &#039;;
btns += &#039;&lt;/li&gt;&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido traducciones de pago de google
    </h6>
    <div class="card-body">
        Reemplazar la carpeta <code>/_herramientas/vendor</code> por la de esta versión.
        <hr>
        Subir el archivo <code>/_herramientas/translate_paid.php</code> de esta versión.<br>
        Si se va a utilizar renombrar a translate.php.
        <hr>
        Subir el archivo <code>/intramedianet/translate/auto-translate_paid.php</code> de esta versión.<br>
        Si se va a utilizar renombrar a auto-translate.php.
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/traducciones.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group API key de Google */
/*--------------------------------------------------------------------------
|
| API key de Google para las traducciones
|
*/

$translateApiKey = &#039;&#039;;
            </code>
        </pre>
        Y añadir la clave del API.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>