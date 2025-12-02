<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 13 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 31-05-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Ajustado diseño de la firma de los emails</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> En listado de propiedades, el cambio de propiedades por página o el orden no funciona si no hay ninguna query</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Arreglado los arrays de PHP para que funcione en todas las versiones de PHP</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> No filtran los select multipres del frontent</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Problema al generar miniaturas con watermark</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Error en la caja de consultas dentro de la cabecera de la intramedianet</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al contar los inmuebles exportados en la lista de exportadores a Kyero</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> Problema en los enlaces de los teléfonos</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustado diseño de la firma de los emails
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send.php:94
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$signature = '&lt;hr&gt;&lt;div style=&quot;background: ' . $mailColor . '; padding: 10px; color: ' . color_luminance($mailColor, '50') . '; font-size: 12px;&quot;&gt;';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
 $signature = '&lt;hr&gt;&lt;div style=&quot;font-size: 14px;&quot;&gt;';
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> En listado de propiedades, el cambio de propiedades por página o el orden no funciona si no hay ninguna query
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:393
/js/source/website.js:418
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if(tempArray[1] != null) {
    if(tempArray2[1] != null) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if(tempArray[1] != null &amp;&amp; tempArray[1] != undefined) {
    if(tempArray2[1] != null &amp;&amp; tempArray2[1] != undefined) {
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Arreglado los arrays de PHP para que funcione en todas las versiones de PHP
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php:391
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
return [0,0];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
return array(0,0);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php:396
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$dims = [ imagesx( $image ), imagesy( $image ) ];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$dims = array(imagesx( $image ), imagesy( $image ));
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
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> No filtran los select multipres del frontent
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/news.php:194
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ct = &#039;AND id_nws IN(&#039; . implode(&#039;,&#039;, simpleSanitize(($ret))) . &#039;)&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ct = &#039;AND id_nws IN(&#039; . implode(&#039;,&#039;, $ret) . &#039;)&#039;;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:168
/modules/properties/properties.php:175
/modules/properties/properties.php:665
/modules/properties/total.php:106
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$country = implode(&#039;,&#039;, simpleSanitize(($_GET[&#039;locun&#039;])));
if ($country != &#039;&#039;) {
    $ctr = &quot;AND properties_loc1.id_loc1  IN (&quot; . $country . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$country = implode(&#039;,&#039;, $_GET[&#039;locun&#039;]);
if ($country != &#039;&#039;) {
    $ctr = &quot;AND properties_loc1.id_loc1  IN (&quot; . simpleSanitize($country) . &quot;)&quot;;
}
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:180
/modules/properties/properties.php:187
/modules/properties/properties.php:667
/modules/properties/total.php:118
/modules/zonas/properties.php:168
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$province = implode(&#039;,&#039;, simpleSanitize(($_GET[&#039;lopr&#039;])));
if ($province != &#039;&#039;) {
    $lopr = &quot;AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (&quot; . $province . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$province = implode(&#039;,&#039;, $_GET[&#039;lopr&#039;]);
if ($province != &#039;&#039;) {
    $lopr = &quot;AND CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END  IN (&quot; . simpleSanitize($province) . &quot;)&quot;;
}
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:192
/modules/properties/properties.php:199
/modules/properties/properties.php:689
/modules/properties/total.php:130
/modules/zonas/properties.php:180
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$location = implode(&#039;,&#039;, simpleSanitize(($_GET[&#039;loct&#039;])));
if ($location != &#039;&#039;) {
    $loct = &quot;AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (&quot; . $location . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$location = implode(&#039;,&#039;, $_GET[&#039;loct&#039;]);
if ($location != &#039;&#039;) {
    $loct = &quot;AND CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END IN (&quot; . simpleSanitize($location) . &quot;)&quot;;
}
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:204
/modules/properties/properties.php:211
/modules/properties/properties.php:701
/modules/properties/total.php:142
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$zone = implode(&#039;,&#039;, simpleSanitize(($_GET[&#039;lozn&#039;])));
if ($zone != &#039;&#039;) {
    $lozn = &quot;AND CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END IN (&quot; . $zone . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$zone = implode(&#039;,&#039;, $_GET[&#039;lozn&#039;]);
if ($zone != &#039;&#039;) {
    $lozn = &quot;AND CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4 END IN (&quot; . simpleSanitize($zone) . &quot;)&quot;;
}
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:216
/modules/properties/properties.php:223
/modules/properties/properties.php:713
/modules/properties/total.php:154
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$location = implode(&#039;,&#039;, simpleSanitize(($_GET[&#039;lc&#039;])));
if ($location != &#039;&#039;) {
    $lc = &quot;AND CASE WHEN properties_towns.id_twn IS NOT NULL THEN properties_towns.id_twn ELSE towns.id_twn  END IN (&quot; . $location . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$location = implode(&#039;,&#039;, $_GET[&#039;lc&#039;]);
if ($location != &#039;&#039;) {
    $lc = &quot;AND CASE WHEN properties_towns.id_twn IS NOT NULL THEN properties_towns.id_twn ELSE towns.id_twn  END IN (&quot; . simpleSanitize($location) . &quot;)&quot;;
}
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:228
/modules/properties/properties.php:235
/modules/properties/total.php:166
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$type = implode(&#039;,&#039;, simpleSanitize(($_GET[&#039;tp&#039;])));
if ($type  != &#039;&#039;) {
    $typ = &quot;AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (&quot; . $type . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$type = implode(&#039;,&#039;, $_GET[&#039;tp&#039;]);
if ($type  != &#039;&#039;) {
    $typ = &quot;AND CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (&quot; . simpleSanitize($type) . &quot;)&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:650
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$type = implode(&#039;,&#039;, simpleSanitize(($_GET[&#039;tp&#039;])));
if ($type  != &#039;&#039;) {
    $typ = getRecords(&quot;SELECT types.id_typ, CASE WHEN properties_types.types_&quot;.$lang.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$lang.&quot;_typ ELSE types.types_&quot;.$lang.&quot;_typ END AS type
    FROM properties_types types
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    WHERE CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END IN (&quot; . $type . &quot;)&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$type = implode(&#039;,&#039;, $_GET[&#039;tp&#039;]);
if ($type  != &#039;&#039;) {
    $typ = getRecords(&quot;
        SELECT properties_types.id_typ, properties_types.types_&quot;.$lang.&quot;_typ AS type
        FROM properties_types
        WHERE properties_types.id_typ IN (&quot; . simpleSanitize($type) . &quot;)
        GROUP BY properties_types.id_typ&quot;);
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 6 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Problema al generar miniaturas con watermark
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/imagenes.php:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$watermarkOpacity = .7;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$watermarkOpacity = 0.7;
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
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en la caja de consultas dentro de la cabecera de la intramedianet
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:614
/intramedianet/includes/inc.header-empleado.php:399
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div&gt;&lt;?php if($row_rsConsultasMenu[&#039;read_cons&#039;] == 0) { ?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;span class=&quot;label label-danger&quot;&gt;&lt;?php __(&#039;Nuevo&#039;); ?&gt;&lt;/span&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php } else { ?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;span class=&quot;label label-default&quot;&gt;&lt;?php __(&#039;Leido&#039;); ?&gt;&lt;/span&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php } ?&gt;&lt;/div&gt;
&lt;i class=&quot;fa fa-arrow-circle-o-right&quot;&gt;&lt;/i&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div&gt;&lt;?php if($row_rsConsultasMenu[&#039;read_cons&#039;] == 0) { ?&gt;
&lt;span class=&quot;label label-danger&quot;&gt;&lt;?php __(&#039;Nuevo&#039;); ?&gt;&lt;/span&gt;
&lt;?php } else { ?&gt;
&lt;span class=&quot;label label-default&quot;&gt;&lt;?php __(&#039;Leido&#039;); ?&gt;&lt;/span&gt;
&lt;?php } ?&gt;&lt;/div&gt;
&lt;i class=&quot;fa fa-arrow-circle-o-right&quot;&gt;&lt;/i&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al contar los inmuebles exportados en la lista de exportadores a Kyero
    </h6>
    <div class="card-body">
        Sustituir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/ids-kyero-tot.php
            </code>
        </pre>
        Por el archivo de esta versión localizado en:
        <pre>
            <code class="php">
/intramedianet/properties/ids-kyero-tot.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Problema en los enlaces de los teléfonos
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:163
/templates/templates/header.tpl:81
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;tef:+00000000000&quot;&gt;&lt;i class=&quot;fas fa-phone&quot;&gt;&lt;/i&gt; (+00) 000 000 000&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;tel:+00000000000&quot;&gt;&lt;i class=&quot;fas fa-phone&quot;&gt;&lt;/i&gt; (+00) 000 000 000&lt;/a&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
