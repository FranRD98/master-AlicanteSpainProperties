<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 15-01-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido importador Habihub</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido importador Habihub
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `units_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `properties_properties` ADD COLUMN `dev_commission_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `properties_properties` ADD COLUMN `restr_web_prop` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `restr_nat_port_prop` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `restr_int_port_prop` INT(1) NULL DEFAULT 0;
            </code>
        </pre>
        <hr>
        Sustituimos la carpeta: <code>/intramedianet/xml</code>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:39
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($_SESSION[&#039;kt_login_level&#039;] == 7) {
    $totCols = 11;
} else {
    $totCols = 13;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($_SESSION[&#039;kt_login_level&#039;] == 7) {
    $totCols = 12;
} else {
    $totCols = 14;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:114
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if($showprecioReduc == 1) { ?&gt;
&lt;th class=&quot;text-truncate&quot;&gt;&lt;?php __(&#039;Oferta&#039;); ?&gt;&lt;/th&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if($showprecioReduc == 1) { ?&gt;
&lt;th class=&quot;text-truncate&quot;&gt;&lt;?php __(&#039;Oferta&#039;); ?&gt;&lt;/th&gt;
&lt;?php } ?&gt;
&lt;th class=&quot;text-truncate&quot;&gt;&lt;?php __(&#039;Unidades&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:184
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;units_prop&quot; id=&quot;units_prop&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:219
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script type=&quot;text/javascript&quot;&gt;
    var numCols = &lt;?php echo $totCols - 1 ?&gt;;
    var langs = [&#039;&lt;?php echo implode(&quot;&#039;,&#039;&quot;, $languages); ?&gt;&#039;];
    var host = &#039;&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;&#039;;
    var theFavs = Array(&lt;?php echo $theFavs3 ?&gt;);
    var theFavsNum = &lt;?php echo count($theFavs2) ?&gt;;
    var showprecioReduc = &lt;?php echo ($showprecioReduc == 1)?1:0 ?&gt;;
    var xmlImport = &lt;?php echo ($xmlImport == 1)?1:0 ?&gt;;
    var non = &#039;&lt;?php echo $lang[&#039;No&#039;] ?&gt;&#039;;

    &lt;?php if ($_SESSION[&#039;kt_login_level&#039;] != 7): ?&gt;
        // CONFIGURACI&Oacute;N DE LAS COLUMNAS:
        &lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &#039;demo.mediaelx.info&#039;): ?&gt;
        var ocultarCols = [6]; // COLUMNAS OCULTAS POR DEFECTO
        &lt;?php else: ?&gt;
        var ocultarCols = [5, 12, 13]; // COLUMNAS OCULTAS POR DEFECTO
        &lt;?php endif ?&gt;
        var destacado_propCol = 9; // POSICI&Oacute;N DE LA COLUMNA DESTACADO
        var activado_propCol = 10; // POSICI&Oacute;N DE LA COLUMNA ACTIVADO
        var vendido_propCol = 11; // POSICI&Oacute;N DE LA COLUMNA VENDIDO
        var oferta_propCol = 12; // POSICI&Oacute;N DE LA COLUMNA OFERTA
        var force_hide_propCol = showprecioReduc == 1 &amp;&amp; xmlImport == 1 ? 13 : 12; // POSICI&Oacute;N DE LA COLUMNA OCULTAR
        if (xmlImport == 0) {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
        } else {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
        }
        var sortval = 12;
    &lt;?php else : ?&gt;
        // CONFIGURACI&Oacute;N DE LAS COLUMNAS:
        var ocultarCols = []; // COLUMNAS OCULTAS POR DEFECTO
        var destacado_propCol = 7; // POSICI&Oacute;N DE LA COLUMNA DESTACADO
        var activado_propCol = 8; // POSICI&Oacute;N DE LA COLUMNA ACTIVADO
        var vendido_propCol = 9; // POSICI&Oacute;N DE LA COLUMNA VENDIDO
        var oferta_propCol = 10; // POSICI&Oacute;N DE LA COLUMNA OFERTA
        var force_hide_propCol = showprecioReduc == 1 &amp;&amp; xmlImport == 1 ? 11 : 10; // POSICI&Oacute;N DE LA COLUMNA OCULTAR
        if (xmlImport == 0) {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,];
        } else {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,];
        }
        var sortval = 11;
    &lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script type=&quot;text/javascript&quot;&gt;
    var numCols = &lt;?php echo $totCols - 1 ?&gt;;
    var langs = [&#039;&lt;?php echo implode(&quot;&#039;,&#039;&quot;, $languages); ?&gt;&#039;];
    var host = &#039;&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;&#039;;
    var theFavs = Array(&lt;?php echo $theFavs3 ?&gt;);
    var theFavsNum = &lt;?php echo count($theFavs2) ?&gt;;
    var showprecioReduc = &lt;?php echo ($showprecioReduc == 1)?1:0 ?&gt;;
    var xmlImport = &lt;?php echo ($xmlImport == 1)?1:0 ?&gt;;
    var non = &#039;&lt;?php echo $lang[&#039;No&#039;] ?&gt;&#039;;

    &lt;?php if ($_SESSION[&#039;kt_login_level&#039;] != 7): ?&gt;
        // CONFIGURACI&Oacute;N DE LAS COLUMNAS:
        &lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &#039;demo.mediaelx.info&#039;): ?&gt;
        var ocultarCols = [6]; // COLUMNAS OCULTAS POR DEFECTO
        &lt;?php else: ?&gt;
        var ocultarCols = [5, 12, 13]; // COLUMNAS OCULTAS POR DEFECTO
        &lt;?php endif ?&gt;
        var destacado_propCol = 9; // POSICI&Oacute;N DE LA COLUMNA DESTACADO
        var activado_propCol = 10; // POSICI&Oacute;N DE LA COLUMNA ACTIVADO
        var vendido_propCol = 11; // POSICI&Oacute;N DE LA COLUMNA VENDIDO
        var oferta_propCol = 12; // POSICI&Oacute;N DE LA COLUMNA OFERTA
        var force_hide_propCol = showprecioReduc == 1 &amp;&amp; xmlImport == 1 ? 14 : 13; // POSICI&Oacute;N DE LA COLUMNA OCULTAR
        if (xmlImport == 0) {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
        } else {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
        }
        var sortval = 13;
    &lt;?php else : ?&gt;
        // CONFIGURACI&Oacute;N DE LAS COLUMNAS:
        var ocultarCols = []; // COLUMNAS OCULTAS POR DEFECTO
        var destacado_propCol = 7; // POSICI&Oacute;N DE LA COLUMNA DESTACADO
        var activado_propCol = 8; // POSICI&Oacute;N DE LA COLUMNA ACTIVADO
        var vendido_propCol = 9; // POSICI&Oacute;N DE LA COLUMNA VENDIDO
        var oferta_propCol = 10; // POSICI&Oacute;N DE LA COLUMNA OFERTA
        var force_hide_propCol = showprecioReduc == 1 &amp;&amp; xmlImport == 1 ? 12 : 11; // POSICI&Oacute;N DE LA COLUMNA OCULTAR
        if (xmlImport == 0) {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11];
        } else {
            var columVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14];
        }
        var sortval = 13;
    &lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-data.php:45
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($showprecioReduc == 1) {
array_push($aColumns, &#039;oferta_prop&#039;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($showprecioReduc == 1) {
array_push($aColumns, &#039;oferta_prop&#039;);
}
array_push($aColumns, &#039;units_prop&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-data.php:269
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.id_prop as image_img
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_properties.id_prop as image_img,
units_prop
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1090
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;preci_reducidoo_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;preci_reducidoo_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;preci_reducidoo_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;preci_reducidoo_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;units_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;units_prop&quot;, &quot;0&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1128
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;commission_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;commission_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;dev_commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;dev_commission_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1340
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;preci_reducidoo_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;preci_reducidoo_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;preci_reducidoo_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;preci_reducidoo_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;units_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;units_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1379
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;commission_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;commission_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;dev_commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;dev_commission_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1741
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;!-- RESPUESTA FOTOCASA --&gt;
&lt;?php if (isset($_SESSION[&#039;fc_status&#039;]) &amp;&amp; $_SESSION[&#039;fc_status&#039;] != &#039;&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;danger&quot;;}else{ echo &quot;success&quot;;} ?&gt; alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;exclamation&quot;;}else{ echo &quot;check&quot;;} ?&gt; label-icon&quot;&gt;&lt;/i&gt; Fotocasa: &lt;?php echo __($_SESSION[&#039;fc_status&#039;][&quot;Message&quot;],1) ?&gt;
        &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_status&#039;]); ?&gt;
&lt;?php } ?&gt;

&lt;!-- RESPUESTA RIGHTMOVE --&gt;
&lt;?php if ($_SESSION[&#039;fc_statusRightmove&#039;] != &#039;&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-success alert-block&quot;&gt;
        &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;alert&quot;&gt;&amp;times;&lt;/button&gt;
        Rightmove: &lt;?php echo __($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
&lt;?php } ?&gt;

&lt;?php if (isset($_GET[&#039;u&#039;]) &amp;&amp; $_GET[&#039;u&#039;] == &#039;ok&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-check label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;El inmueble se ha guardado correctamente&#039;] ?&gt;
        &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt;
    &lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;!-- ALERTAS HABIHUB --&gt;
&lt;?php if ($row_rsInfoProp[&#039;restr_web_prop&#039;] == 1 || $row_rsInfoProp[&#039;restr_nat_port_prop&#039;] == 1 || $row_rsInfoProp[&#039;restr_int_port_prop&#039;] == 1) { ?&gt;
    &lt;div class=&quot;alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-exclamation label-icon&quot;&gt;&lt;/i&gt;
        &lt;?php if ($row_rsInfoProp[&#039;restr_web_prop&#039;] == 1): ?&gt;
            &lt;p class=&quot;my-1&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Este inmueble no se permite mostara en la web&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
        &lt;?php endif ?&gt;
        &lt;?php if ($row_rsInfoProp[&#039;restr_nat_port_prop&#039;] == 1): ?&gt;
            &lt;p class=&quot;my-1&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Este inmueble no se permite mostara en portales nacionales&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
        &lt;?php endif ?&gt;
        &lt;?php if ($row_rsInfoProp[&#039;restr_int_port_prop&#039;] == 1): ?&gt;
            &lt;p class=&quot;my-1&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Este inmueble no se permite mostara en portales internacionales&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
        &lt;?php endif ?&gt;
        &lt;!-- &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt; --&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
&lt;?php } ?&gt;

&lt;!-- RESPUESTA FOTOCASA --&gt;
&lt;?php if (isset($_SESSION[&#039;fc_status&#039;]) &amp;&amp; $_SESSION[&#039;fc_status&#039;] != &#039;&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;danger&quot;;}else{ echo &quot;success&quot;;} ?&gt; alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;exclamation&quot;;}else{ echo &quot;check&quot;;} ?&gt; label-icon&quot;&gt;&lt;/i&gt; Fotocasa: &lt;?php echo __($_SESSION[&#039;fc_status&#039;][&quot;Message&quot;],1) ?&gt;
        &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_status&#039;]); ?&gt;
&lt;?php } ?&gt;

&lt;!-- RESPUESTA RIGHTMOVE --&gt;
&lt;?php if ($_SESSION[&#039;fc_statusRightmove&#039;] != &#039;&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-check label-icon&quot;&gt;&lt;/i&gt; Rightmove: &lt;?php echo __($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
        &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
&lt;?php } ?&gt;

&lt;?php if (isset($_GET[&#039;u&#039;]) &amp;&amp; $_GET[&#039;u&#039;] == &#039;ok&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-check label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;El inmueble se ha guardado correctamente&#039;] ?&gt;
        &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt;
    &lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1939
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;form-check form-switch form-switch-lg mt-md-4 mb-4 mb-md-0&quot; dir=&quot;ltr&quot;&gt;
      &lt;input type=&quot;checkbox&quot; name=&quot;precio_desde_prop&quot; id=&quot;precio_desde_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;precio_desde_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
      &lt;label class=&quot;form-check-label&quot; for=&quot;precio_desde_prop&quot;&gt;&lt;?php __(&#039;Mostrar desde&#039;); ?&gt;&lt;/label&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;precio_desde_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-1&quot;&gt;

  &lt;div class=&quot;form-check form-switch form-switch-sm mt-md-4 mb-4 mb-md-0&quot; dir=&quot;ltr&quot;&gt;
      &lt;input type=&quot;checkbox&quot; name=&quot;precio_desde_prop&quot; id=&quot;precio_desde_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;precio_desde_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
      &lt;label class=&quot;form-check-label&quot; for=&quot;precio_desde_prop&quot; style=&quot;line-height: 1em;&quot;&gt;&lt;?php echo str_replace(&#039;: &#039;, &#039;:&lt;br&gt;&#039;, __(&#039;Mostrar desde&#039;, true)); ?&gt;&lt;/label&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;precio_desde_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-2&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;units_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;units_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Unidades&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-step full-width&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;minus&quot;&gt;&ndash;&lt;/button&gt;
          &lt;input type=&quot;number&quot; name=&quot;units_prop&quot; id=&quot;units_prop&quot; value=&quot;&lt;?php if (KT_escapeAttribute($row_rsproperties_properties[&#039;units_prop&#039;]) == &#039;&#039;): ?&gt;0&lt;?php else: ?&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;units_prop&#039;]); ?&gt;&lt;?php endif ?&gt;&quot; min=&quot;0&quot; max=&quot;1000&quot; readonly=&quot;&quot; class=&quot;required&quot; required&gt;
          &lt;button type=&quot;button&quot; class=&quot;plus&quot;&gt;+&lt;/button&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;units_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3431
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-4&quot;&gt;
&lt;div class=&quot;row&quot;&gt;
&lt;div class=&quot;col-6&quot;&gt;

    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;commission_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n Real&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;
              &lt;input type=&quot;text&quot; name=&quot;commission_prop&quot; id=&quot;commission_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;commission_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;); ?&gt;
          &lt;/div&gt;
      &lt;/div&gt;

&lt;/div&gt;
&lt;div class=&quot;col-6&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;comision_agent_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;comision_agent_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n Agente&#039;); ?&gt;:&lt;/label&gt;
            &lt;div class=&quot;controls&quot;&gt;
                &lt;input type=&quot;text&quot; name=&quot;comision_agent_prop&quot; id=&quot;comision_agent_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;comision_agent_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;comision_agent_prop&quot;); ?&gt;
            &lt;/div&gt;
    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-4&quot;&gt;

&lt;div class=&quot;row&quot;&gt;
&lt;div class=&quot;col-lg-6&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;suma_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;suma_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Suma/IBI&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;controls&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;suma_prop&quot; id=&quot;suma_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;suma_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;suma_prop&quot;); ?&gt;
      &lt;/div&gt;
  &lt;/div&gt;

&lt;/div&gt;
&lt;div class=&quot;col-lg-6&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;gastos_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Gastos de la comunidad&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;controls&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;gastos_prop&quot; id=&quot;gastos_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;gastos_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;); ?&gt;
      &lt;/div&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3600
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-lg-6&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;suma_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;suma_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Suma/IBI&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;
              &lt;input type=&quot;text&quot; name=&quot;suma_prop&quot; id=&quot;suma_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;suma_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;suma_prop&quot;); ?&gt;
          &lt;/div&gt;
      &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-lg-6&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;gastos_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Gastos de la comunidad&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;
              &lt;input type=&quot;text&quot; name=&quot;gastos_prop&quot; id=&quot;gastos_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;gastos_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;); ?&gt;
          &lt;/div&gt;
      &lt;/div&gt;

  &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;


  &lt;div class=&quot;col-lg-12&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;referencia_catrastal_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;referencia_catrastal_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Referencia catastral&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;
              &lt;input type=&quot;text&quot; name=&quot;referencia_catrastal_prop&quot; id=&quot;referencia_catrastal_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_catrastal_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;referencia_catrastal_prop&quot;); ?&gt;
          &lt;/div&gt;
      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-6&quot;&gt;

        &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
              &lt;label for=&quot;commission_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n Real&#039;); ?&gt;:&lt;/label&gt;
              &lt;div class=&quot;controls&quot;&gt;
                  &lt;input type=&quot;text&quot; name=&quot;commission_prop&quot; id=&quot;commission_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;commission_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;); ?&gt;
              &lt;/div&gt;
          &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-6&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;comision_agent_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                &lt;label for=&quot;comision_agent_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n Agente&#039;); ?&gt;:&lt;/label&gt;
                &lt;div class=&quot;controls&quot;&gt;
                    &lt;input type=&quot;text&quot; name=&quot;comision_agent_prop&quot; id=&quot;comision_agent_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;comision_agent_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;comision_agent_prop&quot;); ?&gt;
                &lt;/div&gt;
        &lt;/div&gt;

  &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;


  &lt;div class=&quot;col-lg-6&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;dev_commission_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                &lt;label for=&quot;dev_commission_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n del contrucctor&#039;); ?&gt;:&lt;/label&gt;
                &lt;div class=&quot;controls&quot;&gt;
                    &lt;input type=&quot;text&quot; name=&quot;dev_commission_prop&quot; id=&quot;dev_commission_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;dev_commission_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;dev_commission_prop&quot;); ?&gt;
                &lt;/div&gt;
        &lt;/div&gt;

  &lt;/div&gt;

  &lt;div class=&quot;col-lg-6&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;referencia_catrastal_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;referencia_catrastal_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Referencia catastral&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;
              &lt;input type=&quot;text&quot; name=&quot;referencia_catrastal_prop&quot; id=&quot;referencia_catrastal_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_catrastal_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;referencia_catrastal_prop&quot;); ?&gt;
          &lt;/div&gt;
      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php:372
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Distancia a entretenimientos&#039;] = &#039;Distancia a ocio&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Distancia a entretenimientos&#039;] = &#039;Distancia a ocio/Zonas verdes&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php:344
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Distancia a entretenimientos&#039;] = &#039;Distance to amenities&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Distancia a entretenimientos&#039;] = &#039;Distance to amenities/Green areas&#039;;
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
$lang[&#039;Unidades&#039;] = &#039;Unidades&#039;;
$lang[&#039;Comisi&oacute;n del contrucctor&#039;] = &#039;Comisi&oacute;n del contrucctor&#039;;
$lang[&#039;Este inmueble no se permite mostara en la web&#039;] = &#039;Este inmueble no se permite mostara en la web&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales nacionales&#039;] = &#039;Este inmueble no se permite mostara en portales nacionales&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales internacionales&#039;] = &#039;Este inmueble no se permite mostara en portales internacionales&#039;;
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
$lang[&#039;Unidades&#039;] = &#039;Units&#039;;
$lang[&#039;Comisi&oacute;n del contrucctor&#039;] = &quot;Developer&#039;s Commission&quot;;
$lang[&#039;Este inmueble no se permite mostara en la web&#039;] = &#039;This property is not allowed to be shown on the website.&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales nacionales&#039;] = &#039;This property is not allowed to be shown on national portals.&#039;;
$lang[&#039;Este inmueble no se permite mostara en portales internacionales&#039;] = &#039;This property is not allowed to be shown on international portals.&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>