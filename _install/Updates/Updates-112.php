<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 08-10-2024</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Fallo emisiones Kyero</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Fallo buscador áreas</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Fix error saltos de líneas idealista</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Fix envío cruce clientes whatsapp</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Error en el límite de inmuebles en el mapa de propiedades</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> En cruce de propiedades en clientes solo mostar las viviendas que estén activas que se puedan vender</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo emisiones Kyero
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/kyero.php:144
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
/xml/kyero.php:251
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;energy_rating&gt;
    &lt;consumption&gt;&lt;?php if(isset($row_rsProperties)) echo $row_rsProperties[&#039;energia_prop&#039;]; ?&gt;&lt;/consumption&gt;
    &lt;emissions&gt;&lt;/emissions&gt;
&lt;/energy_rating&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;energy_rating&gt;
    &lt;consumption&gt;
    &lt;?php
        if (!isset($row_rsProperties[&#039;energia_prop&#039;]) || $row_rsProperties[&#039;energia_prop&#039;] == NULL || $row_rsProperties[&#039;energia_prop&#039;] == &#039;En tr&aacute;mite&#039; || $row_rsProperties[&#039;energia_prop&#039;] == &#039;Processing&#039; || $row_rsProperties[&#039;energia_prop&#039;] == &#039;In process&#039;)
        {
            echo &quot;X&quot;;
        } else {
            echo $row_rsProperties[&#039;energia_prop&#039;];
        }
    ?&gt;
    &lt;/consumption&gt;
    &lt;emissions&gt;
        &lt;?php
            if (!isset($row_rsProperties[&#039;emisiones_prop&#039;]) || $row_rsProperties[&#039;emisiones_prop&#039;] == NULL || $row_rsProperties[&#039;emisiones_prop&#039;] == &#039;En tr&aacute;mite&#039; || $row_rsProperties[&#039;emisiones_prop&#039;] == &#039;Processing&#039; || $row_rsProperties[&#039;emisiones_prop&#039;] == &#039;In process&#039;)
            {
                echo &quot;X&quot;;
            } else {
                echo $row_rsProperties[&#039;emisiones_prop&#039;];
            }
        ?&gt;
    &lt;/emissions&gt;
&lt;/energy_rating&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo buscador áreas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/search/areas.php:15
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ar = &#039;&#039;;
if( isset($_GET[&#039;loct&#039;]) &amp;&amp; $_GET[&#039;loct&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;loct&#039;] != &#039;null&#039; ){
    $ar = &quot; AND CASE WHEN properties_loc4.loc3_loc4 IS NOT NULL THEN properties_loc4.loc3_loc4 ELSE towns.loc3_loc4 END IN (&quot; . simpleSanitize((ltrim($_GET[&#039;loct&#039;])), &#039;,&#039;) . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ar = &#039;&#039;;
if( isset($_GET[&#039;loct&#039;]) &amp;&amp; $_GET[&#039;loct&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;loct&#039;] != &#039;null&#039; ){
    $ar = &quot; AND (CASE WHEN areas1.parent_loc3 IS NOT NULL THEN areas1.parent_loc3 ELSE properties_loc3.id_loc3 END IN (&quot; . simpleSanitize((ltrim($_GET[&#039;loct&#039;])), &#039;,&#039;) . &quot;) OR CASE WHEN properties_loc3.parent_loc3 IS NOT NULL THEN properties_loc3.parent_loc3 ELSE areas1.id_loc3 END IN (&quot; . simpleSanitize((ltrim($_GET[&#039;loct&#039;])), &#039;,&#039;) . &quot;))&quot;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix error saltos de líneas idealista
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$Content .= &#039;&quot;propertyDescriptions&quot;: [&#039;;
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_es_prop&#039;]))))))))) != &#039;&#039;) {
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;spanish&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_es_prop&#039;]))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
    $foundDesc = 1;
}
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_en_prop&#039;]))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;english&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_en_prop&#039;]))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_de_prop&#039;]))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;german&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_de_prop&#039;]))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_fr_prop&#039;]))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;french&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_fr_prop&#039;]))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if ((rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_ru_prop&#039;])))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;russian&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_ru_prop&#039;]))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if ((rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_se_prop&#039;])))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;swedish&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_se_prop&#039;]))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if ((rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_nl_prop&#039;])))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;dutch&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_nl_prop&#039;]))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$Content .= &#039;&quot;propertyDescriptions&quot;: [&#039;;
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_es_prop&#039;]))))))))) != &#039;&#039;) {
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;spanish&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;\n&quot;), &quot;&quot;, rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; \n&#039;, nl2br((string)$row_idealista[&#039;descripcion_es_prop&#039;])))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
    $foundDesc = 1;
}
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_en_prop&#039;]))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;english&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;\n&quot;), &quot;&quot;, rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; \n&#039;, nl2br((string)$row_idealista[&#039;descripcion_en_prop&#039;])))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_de_prop&#039;]))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;german&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;\n&quot;), &quot;&quot;, rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; \n&#039;, nl2br((string)$row_idealista[&#039;descripcion_de_prop&#039;])))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if (rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_fr_prop&#039;]))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;french&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;\n&quot;), &quot;&quot;, rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; \n&#039;, nl2br((string)$row_idealista[&#039;descripcion_fr_prop&#039;])))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if ((rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_ru_prop&#039;])))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;russian&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;\n&quot;), &quot;&quot;, rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; \n&#039;, nl2br((string)$row_idealista[&#039;descripcion_ru_prop&#039;])))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if ((rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_se_prop&#039;])))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;swedish&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;\n&quot;), &quot;&quot;, rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; \n&#039;, nl2br((string)$row_idealista[&#039;descripcion_se_prop&#039;])))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
if ((rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;\\&#039;, &#039;&amp;apos;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; &lt;/p&gt;&#039;, (string)$row_idealista[&#039;descripcion_nl_prop&#039;])))))))))) != &#039;&#039;) {
    if ($foundDesc == 1) {
        $Content .= &#039;,&#039;;
    } else {
        $foundDesc = 1;
    }
    $Content .= &#039;{&#039;;
    $Content .= &#039;&quot;descriptionLanguage&quot;: &quot;dutch&quot;,&#039;;
    $Content .= &#039;&quot;descriptionText&quot;: &quot;&#039; . str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;\n&quot;), &quot;&quot;, rip_tags(str_replace(&#039;&quot;&#039;, &#039;&amp;quot;&#039;, str_replace(&#039;&amp;&#039;, &#039;&amp;amp;&#039;, str_replace(&#039;&gt;&#039;, &#039;&amp;gt;&#039;, str_replace(&#039;&lt;&#039;, &#039;&amp;lt;&#039;, strip_tags(str_replace(&#039;&lt;br /&gt;&#039;, &#039; &#039;, str_replace(&#039;&lt;/p&gt;&#039;, &#039; \n&#039;, nl2br((string)$row_idealista[&#039;descripcion_nl_prop&#039;])))))))))) . &#039;&quot;&#039;;
    $Content .= &#039;}&#039;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix envío cruce clientes whatsapp
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3832
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
text = text.replace(/(&lt;([^&gt;]+)&gt;)/gi, &quot;&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
text = text.replace(/(&lt;([^&gt;]+)&gt;)/gi, &quot;&quot;);
text = text.replace( / /g, &quot; &quot; );
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el límite de inmuebles en el mapa de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:498
            </code>
        </pre>
        Eliminamos:
        <pre>
            <code class="php">
$o

LIMIT $cp, $tp
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> En cruce de propiedades en clientes solo mostar las viviendas que estén activas que se puedan vender
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:684
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>