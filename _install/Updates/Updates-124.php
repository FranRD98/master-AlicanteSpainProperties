<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-06-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Actualización a REDSP v4</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Añadir al listado de template envio semanal</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i>  Error al filtrar valoraciones por cliente</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Error en envío de bajada de precios</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Error al enviar email en contactar</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Error al enviar email desde clientes</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-bug text-danger"></i> Error en el envío de cambio de datos en reporte</a></li>
        <li><a href="#sec8"><i class="fas fz-fw fa-bug text-danger"></i> Fallo de codificación en listado de páginas</a></li>
        <li><a href="#sec9"><i class="fas fz-fw fa-bug text-danger"></i> Falllo en la url de los correos de registro de un usuario</a></li>
        <li><a href="#sec10"><i class="fas fz-fw fa-bug text-danger"></i> Eliminada la opción de email en el desplegable de gdpr</a></li>
        <li><a href="#sec11"><i class="fas fz-fw fa-bug text-danger"></i> Error en el formato de plantillas al añadirlas al editor</a></li>
        <li><a href="#sec12"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes formulario de inmuebles</a></li>
        <li><a href="#sec13"><i class="fas fz-fw fa-bug text-danger"></i> Errores al eliminar de Fotocasa y Rightmove inmuebles importados</a></li>
        <li><a href="#sec14"><i class="fas fz-fw fa-bug text-danger"></i> Añadido checkbox activar a promociones</a></li>
        <li><a href="#sec16"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al añadir promociones desde el importador de Habihub</a></li>
        <li><a href="#sec17"><i class="fas fz-fw fa-plus-circle text-success"></i> Email diario con casas nuevas y valoracione</a></li>
        <li><a href="#sec18"><i class="fas fz-fw fa-bug text-danger"></i> Fallo registros importados con number_format</a></li>
        <li><a href="#sec19"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido archivo LLMS.txt para las ias</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Actualización a REDSP v4
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `restr_man_contr_prop` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `restr_social_prop` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `restr_int_cli_prop` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `show_house_prop` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `dev_ref_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
            </code>
        </pre>
        <hr>
        Sustituimos el archivo: <code>/intramedianet/xml/importadores/Redsp.php</code>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils.php:421
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function savePropertyData($query, $update, $features = array(), $images = array(), $plans = array()) {
    global $database_inmoconn, $inmoconn, $in_database, $proveedor, $propID, $newFeatArray, $allLanguages, $numInsert, $numUpdated, $refInm, $actionUpdateProp, $autotraduccion;
    set_time_limit(0);
    // A&ntilde;adimos el inmueble

    $rsPropertyInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
    if ($update) {
        $propertyID = $propID;
        logprop(&#039;1&#039;, $propertyID, $refInm, $actionUpdateProp);
        $numUpdated++;
    } else {
        $id = @mysqli_insert_id($inmoconn);
        $propertyID = $id;
        logprop(&#039;1&#039;, $propertyID, $refInm, &#039;1&#039;);
        $numInsert++;
    }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function savePropertyData($query, $update, $features = array(), $images = array(), $plans = array(), $tags = array()) {
    global $database_inmoconn, $inmoconn, $in_database, $proveedor, $propID, $newFeatArray, $allLanguages, $numInsert, $numUpdated, $refInm, $actionUpdateProp, $autotraduccion;
    set_time_limit(0);
    // A&ntilde;adimos el inmueble

    $rsPropertyInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());
    if ($update) {
        $propertyID = $propID;
        logprop(&#039;1&#039;, $propertyID, $refInm, $actionUpdateProp);
        $numUpdated++;
    } else {
        $id = @mysqli_insert_id($inmoconn);
        $propertyID = $id;
        logprop(&#039;1&#039;, $propertyID, $refInm, &#039;1&#039;);
        $numInsert++;
    }

    $query_rsDeletekPropFeature = &quot;DELETE FROM properties_property_tag WHERE  property = &#039;&quot;.$propertyID.&quot;&#039;&quot;;
    $rsDeletekPropFeature = mysqli_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error());
    if (!empty($tags)) {
        foreach($tags as $tag) {
            if ((string)$tag &gt; 0) {
                $query = &quot;INSERT INTO properties_property_feature_priv SET &quot;;
                $query .= &quot;property = &#039;&quot;.$propertyID.&quot;&#039;,&quot;;
                $query .= &quot;feature = &#039;&quot;.$tag.&quot;&#039;&quot;;
                mysqli_query($inmoconn,$query) or die(mysqli_error());
            }
        }
    }
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1626
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsInfoProp = &quot;
SELECT
  site_xml,
  tipo_xml,
  properties_properties.ref_xml_prop,
  properties_properties.inserted_xml_prop,
  properties_properties.updated_prop
FROM properties_properties
LEFT JOIN xml ON properties_properties.xml_xml_prop = id_xml
WHERE properties_properties.id_prop = &#039;&quot; . $_GET[&#039;id_prop&#039;] . &quot;&#039;
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsInfoProp = &quot;
SELECT
  site_xml,
  tipo_xml,
  properties_properties.ref_xml_prop,
  properties_properties.inserted_xml_prop,
  properties_properties.updated_prop,
  restr_man_contr_prop,
  restr_web_prop,
  restr_nat_port_prop,
  restr_int_port_prop,
  restr_social_prop,
restr_int_cli_prop
FROM properties_properties
LEFT JOIN xml ON properties_properties.xml_xml_prop = id_xml
WHERE properties_properties.id_prop = &#039;&quot; . $_GET[&#039;id_prop&#039;] . &quot;&#039;
&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1758
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
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
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($row_rsInfoProp[&#039;restr_man_contr_prop&#039;] == 1 || $row_rsInfoProp[&#039;restr_web_prop&#039;] == 1 || $row_rsInfoProp[&#039;restr_nat_port_prop&#039;] == 1 || $row_rsInfoProp[&#039;restr_int_port_prop&#039;] == 1 || $row_rsInfoProp[&#039;restr_social_prop&#039;] == 1 || $row_rsInfoProp[&#039;restr_int_cli_prop&#039;] == 1) { ?&gt;
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
        &lt;?php if ($row_rsInfoProp[&#039;restr_man_contr_prop&#039;] == 1): ?&gt;
            &lt;p class=&quot;my-1&quot;&gt;&lt;b&gt;&lt;?php __(&#039;mandatory_contract&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
        &lt;?php endif ?&gt;
        &lt;?php if ($row_rsInfoProp[&#039;restr_social_prop&#039;] == 1): ?&gt;
            &lt;p class=&quot;my-1&quot;&gt;&lt;b&gt;&lt;?php __(&#039;social_networks&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
        &lt;?php endif ?&gt;
        &lt;?php if ($row_rsInfoProp[&#039;restr_int_cli_prop&#039;] == 1): ?&gt;
            &lt;p class=&quot;my-1&quot;&gt;&lt;b&gt;&lt;?php __(&#039;only_intl_clients&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
        &lt;?php endif ?&gt;
        &lt;!-- &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt; --&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1268
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;iva_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;iva_prop&quot;, &quot;0&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;show_house_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;show_house_prop&quot;, &quot;0&quot;);
$ins_properties_properties-&gt;addColumn(&quot;iva_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;iva_prop&quot;, &quot;0&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1524
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;iva_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;iva_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;show_house_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;show_house_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;iva_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;iva_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3774
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-check form-switch form-switch-md mb-4&quot; dir=&quot;ltr&quot;&gt;
    &lt;input type=&quot;checkbox&quot; name=&quot;sale_in_progress_prop&quot; id=&quot;sale_in_progress_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;sale_in_progress_prop&#039;]) &amp;&amp; !(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;sale_in_progress_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;sale_in_progress_prop&quot;&gt;&lt;?php __(&#039;Sale in progress&#039;); ?&gt;&lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;sale_in_progress_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-check form-switch form-switch-md mb-4&quot; dir=&quot;ltr&quot;&gt;
    &lt;input type=&quot;checkbox&quot; name=&quot;sale_in_progress_prop&quot; id=&quot;sale_in_progress_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;sale_in_progress_prop&#039;]) &amp;&amp; !(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;sale_in_progress_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;sale_in_progress_prop&quot;&gt;&lt;?php __(&#039;Sale in progress&#039;); ?&gt;&lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;sale_in_progress_prop&quot;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;form-check form-switch form-switch-md mb-4&quot; dir=&quot;ltr&quot;&gt;
    &lt;input type=&quot;checkbox&quot; name=&quot;show_house_prop&quot; id=&quot;show_house_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;show_house_prop&#039;]) &amp;&amp; !(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;show_house_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;show_house_prop&quot;&gt;&lt;?php __(&#039;House Available to View&#039;); ?&gt;&lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;show_house_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3774
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsInfoProp = &quot;
SELECT
  site_xml,
  tipo_xml,
  properties_properties.ref_xml_prop,
  properties_properties.inserted_xml_prop,
  properties_properties.updated_prop,
  restr_man_contr_prop,
  restr_web_prop,
  restr_nat_port_prop,
  restr_int_port_prop,
  restr_social_prop,
restr_int_cli_prop
FROM properties_properties
LEFT JOIN xml ON properties_properties.xml_xml_prop = id_xml
WHERE properties_properties.id_prop = &#039;&quot; . $_GET[&#039;id_prop&#039;] . &quot;&#039;
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsInfoProp = &quot;
SELECT
  site_xml,
  tipo_xml,
  properties_properties.ref_xml_prop,
  properties_properties.inserted_xml_prop,
  properties_properties.updated_prop,
  dev_ref_prop,
  restr_man_contr_prop,
  restr_web_prop,
  restr_nat_port_prop,
  restr_int_port_prop,
  restr_social_prop,
restr_int_cli_prop
FROM properties_properties
LEFT JOIN xml ON properties_properties.xml_xml_prop = id_xml
WHERE properties_properties.id_prop = &#039;&quot; . $_GET[&#039;id_prop&#039;] . &quot;&#039;
&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;planta_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Planta&#039;); ?&gt;:&lt;/label&gt;
  &lt;select name=&quot;planta_prop&quot; id=&quot;planta_prop&quot; class=&quot;select2&quot;&gt;
      &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
      &lt;?php
      do {
      ?&gt;
      &lt;option value=&quot;&lt;?php echo $row_rsPlanta[&#039;id_plnt&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp($row_rsPlanta[&#039;id_plnt&#039;], $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsPlanta[&#039;planta&#039;]?&gt;&lt;/option&gt;
      &lt;?php
      } while ($row_rsPlanta = mysqli_fetch_assoc($rsPlanta ));
        $rows = mysqli_num_rows($rsPlanta );
        if($rows &gt; 0) {
            mysqli_data_seek($rsPlanta , 0);
          $row_rsPlanta = mysqli_fetch_assoc($rsPlanta );
        }
      ?&gt;
  &lt;/select&gt;
  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;planta_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Planta&#039;); ?&gt;:&lt;/label&gt;
  &lt;select name=&quot;planta_prop&quot; id=&quot;planta_prop&quot; class=&quot;select2&quot;&gt;
      &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
      &lt;?php for ($i=0; $i &lt; 100; $i++) {  ?&gt;
          &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php if ($i == 0): ?&gt;&lt;?php __(&#039;Planta Baja&#039;); ?&gt;&lt;?php else: ?&gt;&lt;?php echo $i; ?&gt;&lt;?php endif ?&gt;&lt;/option&gt;
      &lt;?php } ?&gt;
  &lt;/select&gt;
  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1818
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;h4 class=&quot;card-title mb-0 flex-grow-1 d-block&quot;&gt;&lt;?php __(&#039;Propiedad&#039;); ?&gt;: &lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_prop&#039;]); ?&gt;&lt;/h4&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;h4 class=&quot;card-title mb-0 flex-grow-1 d-block&quot;&gt;&lt;?php __(&#039;Propiedad&#039;); ?&gt;: &lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_prop&#039;]); ?&gt;
  &lt;?php if ($row_rsInfoProp[&#039;dev_ref_prop&#039;] != &#039;&#039;): ?&gt;
  &lt;spam class=&quot;float-end&quot;&gt;&lt;?php __(&#039;REDSP development ref&#039;) ?&gt;: &lt;?php echo $row_rsInfoProp[&#039;dev_ref_prop&#039;]; ?&gt;&lt;/spam&gt;
  &lt;?php endif ?&gt;
&lt;/h4&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:183
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/planta.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/planta/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Plantas&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;!-- &lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/planta.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/planta/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Plantas&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt; --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2429
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;estado_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Conditions&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;estado_prop&quot; id=&quot;estado_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsCondition[&#039;id_cond&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp($row_rsCondition[&#039;id_cond&#039;], $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsCondition[&#039;estado&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsCondition = mysqli_fetch_assoc($rsCondition ));
            $rows = mysqli_num_rows($rsCondition );
            if($rows &gt; 0) {
                mysqli_data_seek($rsCondition , 0);
              $row_rsCondition = mysqli_fetch_assoc($rsCondition );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;planta_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Planta&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;planta_prop&quot; id=&quot;planta_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php for ($i=0; $i &lt; 100; $i++) {  ?&gt;
              &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php if ($i == 0): ?&gt;&lt;?php __(&#039;Planta Baja&#039;); ?&gt;&lt;?php else: ?&gt;&lt;?php echo $i; ?&gt;&lt;?php endif ?&gt;&lt;/option&gt;
          &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-2&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;estado_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Conditions&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;estado_prop&quot; id=&quot;estado_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsCondition[&#039;id_cond&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp($row_rsCondition[&#039;id_cond&#039;], $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsCondition[&#039;estado&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsCondition = mysqli_fetch_assoc($rsCondition ));
            $rows = mysqli_num_rows($rsCondition );
            if($rows &gt; 0) {
                mysqli_data_seek($rsCondition , 0);
              $row_rsCondition = mysqli_fetch_assoc($rsCondition );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-2&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;planta_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Planta&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;planta_prop&quot; id=&quot;planta_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php for ($i=0; $i &lt; 100; $i++) {  ?&gt;
              &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php if ($i == 0): ?&gt;&lt;?php __(&#039;Planta Baja&#039;); ?&gt;&lt;?php else: ?&gt;&lt;?php echo $i; ?&gt;&lt;?php endif ?&gt;&lt;/option&gt;
          &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-2&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;plantas_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;plantas_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Plantas del edificio&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;plantas_prop&quot; id=&quot;plantas_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;plantas_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;plantas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php for ($i=1; $i &lt; 100; $i++) {  ?&gt;
              &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;plantas_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;plantas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $i; ?&gt;&lt;/option&gt;
          &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;plantas_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Planta&#039;] = &#039;Planta&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Planta&#039;] = &#039;Planta del inmueble&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Planta&#039;] = &#039;Floor&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Planta&#039;] = &#039;Property floor&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;mandatory_contract&#039;] = &#039;Se requiere contrato con desarrollador&#039;;
$lang[&#039;social_networks&#039;] = &#039;No se permite publicidad en redes sociales&#039;;
$lang[&#039;only_intl_clients&#039;] = &#039;S&oacute;lo clientes internacionales (no residentes en Espa&ntilde;a)&#039;;
$lang[&#039;House Available to View&#039;] = &#039;Casa disponible para ver&#039;;
$lang[&#039;Planta Baja&#039;] = &#039;Planta Baja&#039;;
$lang[&#039;Plantas del edificio&#039;] = &#039;Plantas del edificio&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;mandatory_contract&#039;] = &#039;Contract with Developer Required&#039;;
$lang[&#039;social_networks&#039;] = &#039;Not allowed to advertise on Social Media Networks&#039;;
$lang[&#039;only_intl_clients&#039;] = &#039;International Clients Only (non residents in Spain)&#039;;
$lang[&#039;House Available to View&#039;] = &#039;House Available to View&#039;;
$lang[&#039;Planta Baja&#039;] = &#039;Ground floor&#039;;
$lang[&#039;Plantas del edificio&#039;] = &#039;Building floors&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir al listado de template envio semanal
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/news.php:52
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Email semanal&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/news.php:57
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws&quot; id=&quot;title_en_nws&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws&quot; id=&quot;title_en_nws&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;week_tmpl&quot; id=&quot;week_tmpl&quot;&gt;
    &lt;select name=&quot;week_tmpl_sel&quot; id=&quot;week_tmpl_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;
&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/news.php:70
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td colspan=&quot;2&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td colspan=&quot;3&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/news.php:85
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var numCols = 1;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var numCols = 2;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/news-data.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, &#039;name_&#039; . $lang_adm . &#039;_tmpl&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, &#039;name_&#039; . $lang_adm . &#039;_tmpl&#039;);
array_push($aColumns, &#039;week_tmpl&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/news-data.php:173
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($aColumns[$i] == &#039;activate_nws&#039;) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($aColumns[$i] == &#039;week_tmpl&#039;) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/news-data.php:202
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
name_&quot; . $lang_adm . &quot;_tmpl,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
name_&quot; . $lang_adm . &quot;_tmpl,
case week_tmpl
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as week_tmpl,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/templates/_js/news-list.js:48
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&quot;columnDefs&quot;: [
    {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&quot;columnDefs&quot;: [
    {
        &quot;render&quot;: function ( data, type, row ) {
            var changeV = data == non ? 1: 0;
            var bntImage = data == non ? &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;: &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
            return bntImage;
        },
        &quot;targets&quot;: numCols - 1
    },
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i>  Error al filtrar valoraciones por cliente
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-rates-data.php:183
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($aColumns[$i] == &#039;client&#039;) {
  $sWhere .= &quot;(SELECT CONCAT_WS(&#039; &#039;, nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = client) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
} else {
  $sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
}
if($aColumns[$i] == &#039;id_cli&#039;) {
  $sWhere .= &quot;(SELECT id_cli FROM properties_client WHERE id_cli = client) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
} else {
  $sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($aColumns[$i] == &#039;client&#039;) {
  $sWhere .= &quot;(SELECT CONCAT_WS(&#039; &#039;, nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = client) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
} else {
  if($aColumns[$i] == &#039;id_cli&#039;) {
    $sWhere .= &quot;(SELECT id_cli FROM properties_client WHERE id_cli = client) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
  } else {
    $sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
  }
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
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en envío de bajada de precios
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/bajada.php:141
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
echo $html2;
die();
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al enviar email en contactar
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/contact/send-quote.php:74
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{CONTENT}/&#039;, $body , $html);
$html = preg_replace(&#039;/{FOOTER}/&#039;, $footer, $html);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{SERVER.HTTP_HOST}/&#039;, $_SERVER[&#039;HTTP_HOST&#039;], $html);
$html = preg_replace(&#039;/{CONTENT}/&#039;, $body, $html);
$html = preg_replace(&#039;/{FOOTER}/&#039;, $footer, $html);
$html = preg_replace(&#039;/{COLOR}/&#039;, $mailColor, $html);
$html = preg_replace(&#039;/{COLOR2}/&#039;, $mailSecondaryColor, $html);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al enviar email desde clientes
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/users/users-form.php:19
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/nxt/KT_back.php&#039; );
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/nxt/KT_back.php&#039; );

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/resources/lang_&#039;.$lang_adm.&#039;.php&#039;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el envío de cambio de datos en reporte
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:981
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#solicitarCambio .close&#039;).click();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#solicitarCambio&#039;).modal(&#039;toggle&#039;);
            </code>
        </pre>
        <hr>
        Y compilar el javascript
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec8">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo de codificación en listado de páginas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-data.php:86
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//$rResult = mysqli_query($gaSql[&#039;link&#039;], &quot;SET NAMES &#039;utf8&#039;&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//$rResult = mysqli_query($gaSql[&#039;link&#039;], &quot;SET NAMES &#039;utf8&#039;&quot;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec9">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Falllo en la url de los correos de registro de un usuario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php:152
/includes/mediaelx/functions.php:184
/includes/mediaelx/functions.php:215
/includes/mediaelx/functions.php:247
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{SERVER.HTTP_HOST}/&#039;, $_SERVER[&#039;HTTP_HOST&#039;], $html);
$html = preg_replace(&#039;/{CONTENT}/&#039;, $body , $html);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{CONTENT}/&#039;, $body , $html);
$html = preg_replace(&#039;/{SERVER.HTTP_HOST}/&#039;, $_SERVER[&#039;HTTP_HOST&#039;], $html);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec10">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminada la opción de email en el desplegable de gdpr
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/gdpr.php:216
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if (preg_match(&#039;/\.txt/&#039;, $file)): ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if (preg_match(&#039;/\.txt/&#039;, $file) &amp;&amp; $file !== &#039;texto correos.txt&#039;): ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec11">
        <span class="badge badge-dark">11</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el formato de plantillas al añadirlas al editor
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3731
/intramedianet/properties/owners-form.php:1573
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
intr_txt[&#039;&lt;?php echo $langval ?&gt;&lt;?php echo $row_rsTemplates[&#039;id_tmpl&#039;]?&gt;&#039;] = &quot;&lt;?php echo mysqli_real_escape_string($inmoconn, strip_tags($row_rsTemplates[&#039;content_&#039;.$langval.&#039;_tmpl&#039;])); ?&gt;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
intr_txt[&#039;&lt;?php echo $langval ?&gt;&lt;?php echo $row_rsTemplates[&#039;id_tmpl&#039;]?&gt;&#039;] = &quot;&lt;?php echo mysqli_real_escape_string($inmoconn, $row_rsTemplates[&#039;content_&#039;.$langval.&#039;_tmpl&#039;]); ?&gt;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec12">
        <span class="badge badge-dark">12</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes formulario de inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2429
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-2&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;estado_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Conditions&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;estado_prop&quot; id=&quot;estado_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsCondition[&#039;id_cond&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp($row_rsCondition[&#039;id_cond&#039;], $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsCondition[&#039;estado&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsCondition = mysqli_fetch_assoc($rsCondition ));
            $rows = mysqli_num_rows($rsCondition );
            if($rows &gt; 0) {
                mysqli_data_seek($rsCondition , 0);
              $row_rsCondition = mysqli_fetch_assoc($rsCondition );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-2&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;planta_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Planta&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;planta_prop&quot; id=&quot;planta_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php for ($i=0; $i &lt; 100; $i++) {  ?&gt;
              &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php if ($i == 0): ?&gt;&lt;?php __(&#039;Planta Baja&#039;); ?&gt;&lt;?php else: ?&gt;&lt;?php echo $i; ?&gt;&lt;?php endif ?&gt;&lt;/option&gt;
          &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-2&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;plantas_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;plantas_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Plantas del edificio&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;plantas_prop&quot; id=&quot;plantas_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;plantas_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;plantas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php for ($i=1; $i &lt; 100; $i++) {  ?&gt;
              &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;plantas_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;plantas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $i; ?&gt;&lt;/option&gt;
          &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;plantas_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;planta_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Planta&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;planta_prop&quot; id=&quot;planta_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php for ($i=0; $i &lt; 100; $i++) {  ?&gt;
              &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;planta_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;planta_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php if ($i == 0): ?&gt;&lt;?php __(&#039;Planta Baja&#039;); ?&gt;&lt;?php else: ?&gt;&lt;?php echo $i; ?&gt;&lt;?php endif ?&gt;&lt;/option&gt;
          &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;planta_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;plantas_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;plantas_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Plantas del edificio&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;plantas_prop&quot; id=&quot;plantas_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;plantas_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;plantas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php for ($i=1; $i &lt; 100; $i++) {  ?&gt;
              &lt;option value=&quot;&lt;?php echo $i; ?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;plantas_prop&#039;]) &amp;&amp; !(strcmp($i, $row_rsproperties_properties[&#039;plantas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $i; ?&gt;&lt;/option&gt;
          &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;plantas_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;estado_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Conditions&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;estado_prop&quot; id=&quot;estado_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsCondition[&#039;id_cond&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;estado_prop&#039;]) &amp;&amp; !(strcmp($row_rsCondition[&#039;id_cond&#039;], $row_rsproperties_properties[&#039;estado_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsCondition[&#039;estado&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsCondition = mysqli_fetch_assoc($rsCondition ));
            $rows = mysqli_num_rows($rsCondition );
            if($rows &gt; 0) {
                mysqli_data_seek($rsCondition , 0);
              $row_rsCondition = mysqli_fetch_assoc($rsCondition );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;estado_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

   &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;armarios_empotrados_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;armarios_empotrados_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Armarios empotrados&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-step full-width&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;minus&quot;&gt;&ndash;&lt;/button&gt;
          &lt;input type=&quot;number&quot; name=&quot;armarios_empotrados_prop&quot; id=&quot;armarios_empotrados_prop&quot; value=&quot;&lt;?php if (KT_escapeAttribute($row_rsproperties_properties[&#039;armarios_empotrados_prop&#039;]) == &#039;&#039;): ?&gt;0&lt;?php else: ?&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;armarios_empotrados_prop&#039;]); ?&gt;&lt;?php endif ?&gt;&quot; min=&quot;0&quot; max=&quot;1000&quot; readonly=&quot;&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;plus&quot;&gt;+&lt;/button&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;armarios_empotrados_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;cocinas_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;cocinas_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Cocinas&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;cocinas_prop&quot; id=&quot;cocinas_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;cocinas_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;cocinas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsKitchen[&#039;id_kchn&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;cocinas_prop&#039;]) &amp;&amp; !(strcmp($row_rsKitchen[&#039;id_kchn&#039;], $row_rsproperties_properties[&#039;cocinas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsKitchen[&#039;kitchen&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsKitchen = mysqli_fetch_assoc($rsKitchen ));
            $rows = mysqli_num_rows($rsKitchen );
            if($rows &gt; 0) {
                mysqli_data_seek($rsKitchen , 0);
              $row_rsKitchen = mysqli_fetch_assoc($rsKitchen );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;cocinas_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;orientacion_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Orientaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;orientacion_prop&quot; id=&quot;orientacion_prop&quot; class=&quot;form-select&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-n&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-n&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-n&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-ne&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-ne&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-ne&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-e&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-e&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-e&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-se&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-se&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-se&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-s&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-s&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-s&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-so&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-so&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-so&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-o&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-o&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-o&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;o-no&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-no&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-no&#039;) ?&gt;&lt;/option&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;); ?&gt;
    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2594
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

   &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;armarios_empotrados_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;armarios_empotrados_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Armarios empotrados&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-step full-width&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;minus&quot;&gt;&ndash;&lt;/button&gt;
          &lt;input type=&quot;number&quot; name=&quot;armarios_empotrados_prop&quot; id=&quot;armarios_empotrados_prop&quot; value=&quot;&lt;?php if (KT_escapeAttribute($row_rsproperties_properties[&#039;armarios_empotrados_prop&#039;]) == &#039;&#039;): ?&gt;0&lt;?php else: ?&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;armarios_empotrados_prop&#039;]); ?&gt;&lt;?php endif ?&gt;&quot; min=&quot;0&quot; max=&quot;1000&quot; readonly=&quot;&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;plus&quot;&gt;+&lt;/button&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;armarios_empotrados_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;cocinas_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;cocinas_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Cocinas&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;cocinas_prop&quot; id=&quot;cocinas_prop&quot; class=&quot;select2&quot;&gt;
          &lt;option value=&quot;&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;cocinas_prop&#039;]) &amp;&amp; !(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;cocinas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsKitchen[&#039;id_kchn&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;cocinas_prop&#039;]) &amp;&amp; !(strcmp($row_rsKitchen[&#039;id_kchn&#039;], $row_rsproperties_properties[&#039;cocinas_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsKitchen[&#039;kitchen&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsKitchen = mysqli_fetch_assoc($rsKitchen ));
            $rows = mysqli_num_rows($rsKitchen );
            if($rows &gt; 0) {
                mysqli_data_seek($rsKitchen , 0);
              $row_rsKitchen = mysqli_fetch_assoc($rsKitchen );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;cocinas_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;orientacion_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Orientaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;orientacion_prop&quot; id=&quot;orientacion_prop&quot; class=&quot;form-select&quot;&gt;
          &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-n&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-n&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-n&#039;) ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-ne&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-ne&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-ne&#039;) ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-e&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-e&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-e&#039;) ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-se&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-se&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-se&#039;) ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-s&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-s&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-s&#039;) ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-so&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-so&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-so&#039;) ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-o&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-o&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-o&#039;) ?&gt;&lt;/option&gt;
          &lt;option value=&quot;o-no&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;orientacion_prop&#039;]) &amp;&amp; !(strcmp(&#039;o-no&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-no&#039;) ?&gt;&lt;/option&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2543
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

  &lt;?php if ($showTeam == 1): ?&gt;

  &lt;div class=&quot;col-lg-3&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;atendido_por_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;atendido_por_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Agente&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;

              &lt;select name=&quot;atendido_por_prop&quot; id=&quot;atendido_por_prop&quot; class=&quot;select2&quot;&gt;
                  &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                  &lt;?php do { ?&gt;
                  &lt;option value=&quot;&lt;?php echo $row_rsTeam[&#039;id_tms&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;atendido_por_prop&#039;]) &amp;&amp; isset($row_rsTeam[&#039;id_tms&#039;]) &amp;&amp; !(strcmp($row_rsTeam[&#039;id_tms&#039;], $row_rsproperties_properties[&#039;atendido_por_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsTeam[&#039;nombre_tms&#039;]?&gt;&lt;/option&gt;
                  &lt;?php } while ($row_rsTeam = mysqli_fetch_assoc($rsTeam));
                    $rows = mysqli_num_rows($rsTeam);
                    if($rows &gt; 0) {
                        mysqli_data_seek($rsTeam, 0);
                      $row_rsTeam = mysqli_fetch_assoc($rsTeam);
                    } ?&gt;
              &lt;/select&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;atendido_por_prop&quot;); ?&gt;
          &lt;/div&gt;
      &lt;/div&gt;

  &lt;/div&gt;

  &lt;?php endif ?&gt;

  &lt;div class=&quot;col-lg-3&quot;&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;captado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;captado_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Captado por prop&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;
              &lt;select name=&quot;captado_prop&quot; id=&quot;captado_prop&quot; class=&quot;select2&quot;&gt;
                  &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                  &lt;?php do { ?&gt;
                  &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;captado_prop&#039;]) &amp;&amp; !(strcmp($row_rsusuarios[&#039;id_usr&#039;], $row_rsproperties_properties[&#039;captado_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                  &lt;?php } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                    $rows = mysqli_num_rows($rsusuarios);
                    if($rows &gt; 0) {
                        mysqli_data_seek($rsusuarios, 0);
                      $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                    } ?&gt;
              &lt;/select&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;captado_prop&quot;); ?&gt;
          &lt;/div&gt;
      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;bg-light py-1 pt-4 px-4 mb-4 mt-2 rounded-4&quot; style=&quot;background-color: rgba(10, 179, 156, 0.1) !important;&quot;&gt;

  &lt;div class=&quot;row&quot;&gt;

      &lt;?php if ($showTeam == 1): ?&gt;

      &lt;div class=&quot;col-lg-3&quot;&gt;

          &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;atendido_por_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
              &lt;label for=&quot;atendido_por_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Agente&#039;); ?&gt;:&lt;/label&gt;
              &lt;div class=&quot;controls&quot;&gt;

                  &lt;select name=&quot;atendido_por_prop&quot; id=&quot;atendido_por_prop&quot; class=&quot;select2&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                      &lt;?php do { ?&gt;
                      &lt;option value=&quot;&lt;?php echo $row_rsTeam[&#039;id_tms&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;atendido_por_prop&#039;]) &amp;&amp; isset($row_rsTeam[&#039;id_tms&#039;]) &amp;&amp; !(strcmp($row_rsTeam[&#039;id_tms&#039;], $row_rsproperties_properties[&#039;atendido_por_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsTeam[&#039;nombre_tms&#039;]?&gt;&lt;/option&gt;
                      &lt;?php } while ($row_rsTeam = mysqli_fetch_assoc($rsTeam));
                        $rows = mysqli_num_rows($rsTeam);
                        if($rows &gt; 0) {
                            mysqli_data_seek($rsTeam, 0);
                          $row_rsTeam = mysqli_fetch_assoc($rsTeam);
                        } ?&gt;
                  &lt;/select&gt;
                  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;atendido_por_prop&quot;); ?&gt;
              &lt;/div&gt;
          &lt;/div&gt;

      &lt;/div&gt;

      &lt;?php endif ?&gt;

      &lt;div class=&quot;col-lg-3&quot;&gt;

          &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;captado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
              &lt;label for=&quot;captado_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Captado por prop&#039;); ?&gt;:&lt;/label&gt;
              &lt;div class=&quot;controls&quot;&gt;
                  &lt;select name=&quot;captado_prop&quot; id=&quot;captado_prop&quot; class=&quot;select2&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                      &lt;?php do { ?&gt;
                      &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (isset($row_rsproperties_properties[&#039;captado_prop&#039;]) &amp;&amp; !(strcmp($row_rsusuarios[&#039;id_usr&#039;], $row_rsproperties_properties[&#039;captado_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                      &lt;?php } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                        $rows = mysqli_num_rows($rsusuarios);
                        if($rows &gt; 0) {
                            mysqli_data_seek($rsusuarios, 0);
                          $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                        } ?&gt;
                  &lt;/select&gt;
                  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;captado_prop&quot;); ?&gt;
              &lt;/div&gt;
          &lt;/div&gt;

      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec13">
        <span class="badge badge-dark">13</span> <i class="fas fz-fw fa-bug text-danger"></i> Errores al eliminar de Fotocasa y Rightmove inmuebles importados
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:286
/intramedianet/xml/importadores/Inmovilla.php:433
/intramedianet/xml/importadores/Kyero.php:197
/intramedianet/xml/importadores/Mediaelx.php:292
/intramedianet/xml/importadores/Redsp.php:328
/intramedianet/xml/importadores/Resales.php:269
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/fotocasa/FotocasaAPI.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
include_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/fotocasa/FotocasaAPI.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:313
/intramedianet/xml/importadores/Inmovilla.php:460
/intramedianet/xml/importadores/Kyero.php:224
/intramedianet/xml/importadores/Mediaelx.php:319
/intramedianet/xml/importadores/Redsp.php:355
/intramedianet/xml/importadores/Resales.php:296
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
if ($expRightmove == 1) {

    $_GET[&#039;id_prop&#039;] = $row_rsPropsDel[&#039;id_prop&#039;];

    ob_start();
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-getImport.php&#039;);
    $json = ob_get_contents();
    ob_end_clean();

    $fields = array (
        &#039;json&#039; =&gt; urlencode($json),
        &#039;url&#039; =&gt; urlencode(&#039;https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist&#039;)
    );

    foreach($fields as $key=&gt;$value) {
        $fields_string .= $key.&#039;=&#039;.$value.&#039;&amp;&#039;;
    }
    rtrim($fields_string, &#039;&amp;&#039;);

    $result = getRightmove(&#039;https://curl.mediaelx.info/rightmove.php&#039;, $fields, $fields_string);

    $result = explode(&#039;,&#039;, $result);

    $deleteProp = 0;

    foreach ($result as $value) {
        if ($row_rsPropsDel[&#039;referencia_prop&#039;] == $value) {
            $deleteProp = 1;
        }
    }

    if ($deleteProp == 1) {

        $export_rightmove_fields_prop = json_decode($row_rsPropsDel[&#039;export_rightmove_fields_prop&#039;], true);

        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-removeImport.php&#039;);
        $json = ob_get_contents();
        ob_end_clean();

        $fields = array (
            &#039;json&#039; =&gt; urlencode($json),
            &#039;url&#039; =&gt; urlencode(&#039;https://adfapi.rightmove.co.uk/v1/property/removeproperty&#039;)
        );

        foreach($fields as $key=&gt;$value) {
            $fields_string .= $key.&#039;=&#039;.$value.&#039;&amp;&#039;;
        }
        rtrim($fields_string, &#039;&amp;&#039;);

        $result = getRightmove(&#039;https://curl.mediaelx.info/rightmove.php&#039;, $fields, $fields_string);
    }

}
            </code>
        </pre>
        <hr>
        Añadimos el archivo <code>/intramedianet/properties/rightmove/clean-rightmove.php</code>
        <hr>
        Si se activa la exportación a Rightmove hay que añadir el siguiente cron:
        <table class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th style="width: 75px; text-align: center; font-size: 10px; vertical-align: middle;">Minuto</th>
                    <th style="width: 75px; text-align: center; font-size: 10px; vertical-align: middle;">Hora</th>
                    <th style="width: 75px; text-align: center; font-size: 10px; vertical-align: middle;">Día del mes</th>
                    <th style="width: 75px; text-align: center; font-size: 10px; vertical-align: middle;">Mes</th>
                    <th style="width: 75px; text-align: center; font-size: 10px; vertical-align: middle;">Día de la semana</th>
                    <th style="width: 75px; text-align: center; font-size: 10px; vertical-align: middle;">Archivo</th>
                    <th style="width: 75px; text-align: center; font-size: 10px; vertical-align: middle;">Notas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; vertical-align: middle;">20</td>
                    <td style="text-align: center; vertical-align: middle;">*/2</td>
                    <td style="text-align: center; vertical-align: middle;">*</td>
                    <td style="text-align: center; vertical-align: middle;">*</td>
                    <td style="text-align: center; vertical-align: middle;">*</td>
                    <td style="vertical-align: middle;">https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/properties/rightmove/clean-rightmove.php</td>
                    <td style="vertical-align: middle;">Solo si se activa esta opción</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec14">
        <span class="badge badge-dark">14</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido checkbox activar a promociones
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:52
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Titular&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Titular&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Activado&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:57
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws&quot; id=&quot;title_en_nws&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws&quot; id=&quot;title_en_nws&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot;&gt;
    &lt;select name=&quot;activate_nws_sel&quot; id=&quot;activate_nws_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;
&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:70
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;td colspan=&quot;2&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
&lt;td colspan=&quot;3&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:85
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var numCols = 1;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var numCols = 2;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
/intramedianet/promotions/news-data.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, &#039;title_&#039; . $lang_adm . &#039;_nws&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, &#039;title_&#039; . $lang_adm . &#039;_nws&#039;);
array_push($aColumns, &#039;activate_nws&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:174
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;], $_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($aColumns[$i] == &#039;activate_nws&#039;) {
  if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;S&iacute;&#039;, true)))) {
      $sWhere .= $aColumns[$i].&quot; = &#039;1&#039; &quot;;
  }
  if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;No&#039;, true)))) {
      $sWhere .= $aColumns[$i].&quot; = &#039;0&#039; &quot;;
  }
}
else {
  $sWhere .= &quot;`&quot;.$aColumns[$i].&quot;` LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch&#039;]).&quot;%&#039; OR &quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:210
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&quot; . $campos . &quot;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&quot; . $campos . &quot;
case activate_nws
    when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
    when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as activate_nws,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/_js/pages-list.js:48
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{
    &quot;render&quot;: function ( data, type, row ) {
        var changeV = data == non ? 1: 0;
        var bntImage = data == non ? &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;: &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        return bntImage;
    },
    &quot;targets&quot;: numCols - 1
},
{
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:235
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;zoom_gp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gp_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;zoom_gp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gp_prop&quot;);
$ins_news-&gt;addColumn(&quot;activate_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;activate_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:273
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;zoom_gp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gp_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;zoom_gp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gp_prop&quot;);
$upd_news-&gt;addColumn(&quot;activate_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;activate_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-form.php:341
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;div class=&quot;col-lg-3&quot;&gt;

    &lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
          &lt;input type=&quot;checkbox&quot; name=&quot;destacado_nws&quot; id=&quot;destacado_nws&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsnews[&#039;destacado_nws&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
          &lt;label class=&quot;form-check-label&quot; for=&quot;destacado_nws&quot;&gt;
            &lt;?php __(&#039;Vendido&#039;); ?&gt;&lt;/label&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;destacado_nws&quot;); ?&gt;
      &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
&lt;div class=&quot;col-lg-3&quot;&gt;

    &lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
          &lt;input type=&quot;checkbox&quot; name=&quot;destacado_nws&quot; id=&quot;destacado_nws&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsnews[&#039;destacado_nws&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
          &lt;label class=&quot;form-check-label&quot; for=&quot;destacado_nws&quot;&gt;
            &lt;?php __(&#039;Vendido&#039;); ?&gt;&lt;/label&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;destacado_nws&quot;); ?&gt;
      &lt;/div&gt;

&lt;/div&gt;
&lt;div class=&quot;col-lg-3&quot;&gt;

    &lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
          &lt;input type=&quot;checkbox&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsnews[&#039;activate_nws&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
          &lt;label class=&quot;form-check-label&quot; for=&quot;activate_nws&quot;&gt;
            &lt;?php __(&#039;Activar la propiedad&#039;); ?&gt;&lt;/label&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;activate_nws&quot;); ?&gt;
      &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php:145
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query .= &quot;quick_town_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn, trim((string)$ciudad)).&quot;&#039;, &quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query .= &quot;quick_town_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn, trim((string)$ciudad)).&quot;&#039;, &quot;;
$query .= &quot;activate_nws = &#039;0, &quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec16">
        <span class="badge badge-dark">15</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al añadir promociones desde el importador de Habihub
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:75
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$promotionID = setPromotionHabihub((string)$property-&gt;development_name, (string)$property-&gt;province, (string)$property-&gt;town);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$promotionID = setPromotionHabihub((string)$property-&gt;development_name, (int)$provinceID, (int)$townID);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec17">
        <span class="badge badge-dark">16</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Email diario con casas nuevas y valoracione
    </h6>
    <div class="card-body">
        reemplazar el archivo <code>/intramedianet/calendar/send-citas.php</code>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec18">
        <span class="badge badge-dark">17</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo registros importados con number_format
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_prop` `m2_prop` INT(11) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `constructor_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_utiles_prop` `m2_utiles_prop` INT(11) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `m2_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_parcela_prop` `m2_parcela_prop` INT(11) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `m2_utiles_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_balcon_prop` `m2_balcon_prop` INT NULL DEFAULT NULL  COMMENT &#039;&#039; AFTER `m2_parcela_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_terraza_prop` `m2_terraza_prop` INT NULL DEFAULT NULL  COMMENT &#039;&#039; AFTER `m2_balcon_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_garaje_prop` `m2_garaje_prop` INT NULL DEFAULT NULL  COMMENT &#039;&#039; AFTER `m2_terraza_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_sotano_prop` `m2_sotano_prop` INT NULL DEFAULT NULL  COMMENT &#039;&#039; AFTER `m2_garaje_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_fachada_prop` `m2_fachada_prop` INT NULL DEFAULT NULL  COMMENT &#039;&#039; AFTER `m2_sotano_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `m2_solarium_prop` `m2_solarium_prop` INT NULL DEFAULT NULL  COMMENT &#039;&#039; AFTER `m2_fachada_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `salas_prop` `salas_prop` INT(11) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `planta_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `armarios_empotrados_prop` `armarios_empotrados_prop` INT(11) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `salas_prop`;
ALTER TABLE `properties_properties` CHANGE COLUMN `plazas_garaje_prop` `plazas_garaje_prop` INT(11) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `armarios_empotrados_prop`
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card">
    <h6 class="card-header" id="sec19">
        <span class="badge badge-dark">18</span><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido archivo LLMS.txt para las ias
    </h6>
    <div class="card-body">
        Ejecutamos las queries:
        <pre>
            <code class="sql">
ALTER TABLE `news` ADD COLUMN `llms_name_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `llms_url_nws` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `news` ADD COLUMN `llms_descripcion_nws` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
CREATE TABLE `llms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT &#039;&#039;,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `llms` (`id`, `name`, `description`) VALUES (1, &#039;Nombre empresa&#039;, &#039;Descripci&oacute;n de la empresa&#039;);

            </code>
        </pre>
        <hr>
        Añadir los archivos:
        <pre>
            <code class="makefile">
/Connections/conf/llms.php
/llms.php
/llms.txt
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/inmoconn.php:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/gdpr.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/gdpr.php&#039;);
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/llms.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:103
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm-&gt;setTable(&quot;news_news_towns&quot;);
  $mtm-&gt;setPkName(&quot;news&quot;);
  $mtm-&gt;setFkName(&quot;town&quot;);
  $mtm-&gt;setFkReference(&quot;mtm&quot;);
  return $mtm-&gt;Execute();
}
//end Trigger_Default_ManyToMany trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand
function Trigger_Default_ManyToMany($tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm-&gt;setTable(&quot;news_news_towns&quot;);
  $mtm-&gt;setPkName(&quot;news&quot;);
  $mtm-&gt;setFkName(&quot;town&quot;);
  $mtm-&gt;setFkReference(&quot;mtm&quot;);
  return $mtm-&gt;Execute();
}
//end Trigger_Default_ManyToMany trigger

function replaceTags($startPoint, $endPoint, $newText, $source) {
    return preg_replace(&#039;@(&#039;.preg_quote($startPoint).&#039;)(.*)(&#039;.preg_quote($endPoint).&#039;)@si&#039;, &#039;$1&#039;.$newText.&#039;$3&#039;, $source);
}

//start Trigger_UpdateLLMS trigger
//remove this line if you want to edit the code by hand
function Trigger_UpdateLLMS(&amp;$tNG) {

  include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/resources/urls.php&quot;);

  global $database_inmoconn, $inmoconn, $language, $languages, $actCostas;

  $query_rsPages = &quot;SELECT * FROM news WHERE type_nws = 2 AND llms_name_nws != &#039;&#039; AND llms_url_nws != &#039;&#039; AND llms_descripcion_nws != &#039;&#039;&quot;;
  $rsPages = mysqli_query($inmoconn,$query_rsPages) or die(mysqli_error());
  $row_rsPages = mysqli_fetch_assoc($rsPages);
  $totalRows_rsPages = mysqli_num_rows($rsPages);

  $newText = &quot;&quot;;

  if ($totalRows_rsPages &gt; 0) {
      do {

        $newText .= &quot;\n- [&quot; . $row_rsPages[&#039;llms_name_nws&#039;] . &quot;](&quot; . $row_rsPages[&#039;llms_url_nws&#039;] . &quot;): \n&quot;;
        $newText .= $row_rsPages[&#039;llms_descripcion_nws&#039;];

      } while ($row_rsPages = mysqli_fetch_assoc($rsPages));
  }

  $filename = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/llms.txt&#039;;
  $llms = file_get_contents($filename);

  $llms = replaceTags(&#039;## P&aacute;ginas&#039;,&#039;---&#039;, $newText . &quot;\n&quot;, $llms);
  file_put_contents($filename, $llms);

  return true;
}
//end Trigger_UpdateLLMS trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:160
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);
$ins_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_UpdateLLMS&quot;, 97);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:164
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;setTable(&quot;news&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;setTable(&quot;news&quot;);
$ins_news-&gt;addColumn(&quot;llms_name_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;llms_name_nws&quot;);
$ins_news-&gt;addColumn(&quot;llms_url_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;llms_url_nws&quot;);
$ins_news-&gt;addColumn(&quot;llms_descripcion_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;llms_descripcion_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:184
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;registerTrigger(&quot;END&quot;, &quot;Trigger_Default_Redirect&quot;, 99, &quot;../../includes/nxt/back.php&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;registerTrigger(&quot;END&quot;, &quot;Trigger_Default_Redirect&quot;, 99, &quot;../../includes/nxt/back.php&quot;);
$upd_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_UpdateLLMS&quot;, 97);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:188
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;setTable(&quot;news&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;setTable(&quot;news&quot;);
$upd_news-&gt;addColumn(&quot;llms_name_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;llms_name_nws&quot;);
$upd_news-&gt;addColumn(&quot;llms_url_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;llms_url_nws&quot;);
$upd_news-&gt;addColumn(&quot;llms_descripcion_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;llms_descripcion_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:210
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$del_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail3&quot;, 99);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$del_news-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail3&quot;, 99);
$del_news-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_UpdateLLMS&quot;, 97);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:370
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-lg-12&quot;&gt;

        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
                &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
                    &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Indexaci&oacute;n para inteligencia artificial&#039;); ?&gt; &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $languageLLMS; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;&lt;/h4&gt;
                &lt;/div&gt;
                &lt;div class=&quot;flex-shrink-0 ms-2 d-none d-md-flex&quot;&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body&quot;&gt;

                &lt;div class=&quot;mb-4&quot;&gt;
                    &lt;label for=&quot;llms_name_nws&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                    &lt;input type=&quot;text&quot; name=&quot;llms_name_nws&quot; id=&quot;llms_name_nws&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;llms_name_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;llms_name_nws&quot;); ?&gt;
                &lt;/div&gt;

                &lt;div class=&quot;mb-4&quot;&gt;
                    &lt;label for=&quot;llms_url_nws&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;URL&#039;); ?&gt;:&lt;/label&gt;
                    &lt;input type=&quot;url&quot; name=&quot;llms_url_nws&quot; id=&quot;llms_url_nws&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;llms_url_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control url&quot; placeholder=&quot;https://&quot;&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;llms_url_nws&quot;); ?&gt;
                &lt;/div&gt;

                &lt;div class=&quot;&lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;llms_descripcion_nws&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
                  &lt;label for=&quot;llms_descripcion_nws&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
                      &lt;textarea name=&quot;llms_descripcion_nws&quot; id=&quot;llms_descripcion_nws&quot; cols=&quot;50&quot; rows=&quot;5&quot; class=&quot;form-control&quot;&gt;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;llms_descripcion_nws&#039;]); ?&gt;&lt;/textarea&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;llms_descripcion_nws&quot;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt;&lt;!-- end card-body --&gt;
        &lt;/div&gt;

    &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;
            </code>
        </pre>
        <hr>
        Añadir la carpeta <code>/intramedianet/llms</code>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:768
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
preg_match(&#039;/\/quicklinks\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
preg_match(&#039;/\/quicklinks\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/llms\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:768
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($actPaginas == 1) { ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/pages/news.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/pages\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;Metas/&lt;?php __(&#039;P&aacute;ginas&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actPaginas == 1) { ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/pages/news.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/pages\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;Metas/&lt;?php __(&#039;P&aacute;ginas&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php } ?&gt;

&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/llms/llms.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/llms\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;Metas/&lt;?php __(&#039;Info IA&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/.htaccess:22
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
RewriteRule ^google95b9582a26f99026.html$ google95b9582a26f99026.html [L,QSA]
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
RewriteRule ^google95b9582a26f99026.html$ google95b9582a26f99026.html [L,QSA]
RewriteRule ^llms.txt$ llms.txt [L,QSA]
RewriteRule ^llms.php$ llms.php [L,QSA]
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
$lang[&#039;Indexaci&oacute;n para inteligencia artificial&#039;] = &#039;Indexaci&oacute;n para inteligencia artificial&#039;;
$lang[&#039;Info IA&#039;] = &#039;Info IA&#039;;
$lang[&#039;Nombre de la inmobiliaria&#039;] = &#039;Nombre de la inmobiliaria&#039;;
$lang[&#039;Descripcion de la empresa&#039;] = &#039;Descripcion de la empresa&#039;;
$lang[&#039;Los datos se ha guardado correctamente&#039;] = &#039;Los datos se ha guardado correctamente&#039;;
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
$lang[&#039;Indexaci&oacute;n para inteligencia artificial&#039;] = &#039;Indexing for artificial intelligence&#039;;
$lang[&#039;Info IA&#039;] = &#039;Info IA&#039;;
$lang[&#039;Nombre de la inmobiliaria&#039;] = &#039;Name of the real estate company&#039;;
$lang[&#039;Descripcion de la empresa&#039;] = &#039;Company description&#039;;
$lang[&#039;Los datos se ha guardado correctamente&#039;] = &#039;The data has been saved correctly&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>