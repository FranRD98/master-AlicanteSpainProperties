<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 23-09-2020</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador Inmoco</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador Inmoco
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `export_inmoco_prop` INT(1) NULL DEFAULT 0;
ALTER TABLE `properties_properties` ADD COLUMN `commission_prop` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `properties_properties` ADD COLUMN `garden_m2_prop` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `properties_properties` ADD COLUMN `solarium_prop` INT(1) NULL DEFAULT 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$expInmoco= 1;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;suma_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;suma_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;suma_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;suma_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;export_inmoco_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_inmoco_prop&quot;, &quot;0&quot;);
$ins_properties_properties-&gt;addColumn(&quot;commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;commission_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;garden_m2_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;garden_m2_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;solarium_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;solarium_prop&quot;, &quot;0&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;suma_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;suma_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;suma_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;suma_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;export_inmoco_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_inmoco_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;commission_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;commission_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;garden_m2_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;garden_m2_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;solarium_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;solarium_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;orientacion_prop&quot;&gt;&lt;?php __(&#039;Orientaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;orientacion_prop&quot; id=&quot;orientacion_prop&quot; class=&quot;form-control&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-n&quot;&lt;?php if (!(strcmp(&#039;o-n&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-n&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-ne&quot;&lt;?php if (!(strcmp(&#039;o-ne&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-ne&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-e&quot;&lt;?php if (!(strcmp(&#039;o-e&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-e&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-se&quot;&lt;?php if (!(strcmp(&#039;o-se&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-se&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-s&quot;&lt;?php if (!(strcmp(&#039;o-s&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-s&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-so&quot;&lt;?php if (!(strcmp(&#039;o-so&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-so&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-o&quot;&lt;?php if (!(strcmp(&#039;o-o&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-o&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-no&quot;&lt;?php if (!(strcmp(&#039;o-no&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-no&#039;) ?&gt;&lt;/option&gt;
    &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;garden_m2_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;garden_m2_prop&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Jard&iacute;n&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Jard&iacute;n&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;input-group&quot;&gt;
        &lt;input type=&quot;text&quot; name=&quot;garden_m2_prop&quot; id=&quot;garden_m2_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;garden_m2_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
        &lt;span class=&quot;input-group-addon&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
    &lt;/div&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;garden_m2_prop&quot;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;orientacion_prop&quot;&gt;&lt;?php __(&#039;Orientaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;orientacion_prop&quot; id=&quot;orientacion_prop&quot; class=&quot;form-control&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-n&quot;&lt;?php if (!(strcmp(&#039;o-n&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-n&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-ne&quot;&lt;?php if (!(strcmp(&#039;o-ne&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-ne&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-e&quot;&lt;?php if (!(strcmp(&#039;o-e&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-e&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-se&quot;&lt;?php if (!(strcmp(&#039;o-se&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-se&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-s&quot;&lt;?php if (!(strcmp(&#039;o-s&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-s&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-so&quot;&lt;?php if (!(strcmp(&#039;o-so&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-so&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-o&quot;&lt;?php if (!(strcmp(&#039;o-o&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-o&#039;) ?&gt;&lt;/option&gt;
        &lt;option value=&quot;o-no&quot;&lt;?php if (!(strcmp(&#039;o-no&#039;, $row_rsproperties_properties[&#039;orientacion_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo __(&#039;o-no&#039;) ?&gt;&lt;/option&gt;
    &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;orientacion_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;m2_balcon_prop&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Balc&oacute;n&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Balc&oacute;n&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;input-group&quot;&gt;
        &lt;input type=&quot;text&quot; name=&quot;m2_balcon_prop&quot; id=&quot;m2_balcon_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_balcon_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
        &lt;span class=&quot;input-group-addon&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
    &lt;/div&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;m2_balcon_prop&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Balc&oacute;n&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Balc&oacute;n&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;input-group&quot;&gt;
        &lt;input type=&quot;text&quot; name=&quot;m2_balcon_prop&quot; id=&quot;m2_balcon_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_balcon_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
        &lt;span class=&quot;input-group-addon&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
    &lt;/div&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;); ?&gt;
&lt;/div&gt;
&lt;br&gt;

&lt;div class=&quot;checkbox &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;solarium_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;solarium_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;solarium_prop&quot; id=&quot;solarium_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
        &lt;?php __(&#039;Solarium&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;solarium_prop&quot;); ?&gt;
&lt;/div&gt;
&lt;br&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;gastos_prop&quot;&gt;&lt;?php __(&#039;Gastos de la comunidad&#039;); ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;controls&quot;&gt;
        &lt;input type=&quot;text&quot; name=&quot;gastos_prop&quot; id=&quot;gastos_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;gastos_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
   &lt;label for=&quot;gastos_prop&quot;&gt;&lt;?php __(&#039;Gastos de la comunidad&#039;); ?&gt;:&lt;/label&gt;
   &lt;div class=&quot;controls&quot;&gt;
       &lt;input type=&quot;text&quot; name=&quot;gastos_prop&quot; id=&quot;gastos_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;gastos_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;gastos_prop&quot;); ?&gt;
   &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
   &lt;label for=&quot;commission_prop&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n&#039;); ?&gt;:&lt;/label&gt;
   &lt;div class=&quot;controls&quot;&gt;
       &lt;input type=&quot;text&quot; name=&quot;commission_prop&quot; id=&quot;commission_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;commission_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;); ?&gt;
   &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;checkbox&quot; &lt;?php if ($expSpainHouses == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
        &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;expport_SpainHomes_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;expport_SpainHomes_prop&quot; id=&quot;expport_SpainHomes_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expSpainHouses == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
        &lt;?php __(&#039;Exportar a Spain Homes&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;expport_SpainHomes_prop&quot;); ?&gt;
        &lt;hr&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;checkbox&quot; &lt;?php if ($expSpainHouses == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
        &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;expport_SpainHomes_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;expport_SpainHomes_prop&quot; id=&quot;expport_SpainHomes_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expSpainHouses == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
        &lt;?php __(&#039;Exportar a Spain Homes&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;expport_SpainHomes_prop&quot;); ?&gt;
        &lt;hr&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;/div&gt;

&lt;hr style=&quot;border-top-width: 10px;&quot;&gt;

&lt;div class=&quot;checkbox&quot; &lt;?php if ($expInmoco == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
&lt;label&gt;
&lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_inmoco_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;export_inmoco_prop&quot; id=&quot;export_inmoco_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expInmoco == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
&lt;?php __(&#039;Exportar a Inmoco&#039;); ?&gt;
&lt;/label&gt;
&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_inmoco_prop&quot;); ?&gt;
&lt;?php if ($expInmoco == 1) { ?&gt;
&lt;br&gt;
&lt;br&gt;
&lt;p class=&quot;help&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Remember: properties must have a commission field complete.&#039;); ?&gt;&lt;/b&gt;&lt;/p&gt;
&lt;?php } ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsMiMove = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mimove_prop = 1
&quot;;
$rsMiMove = mysql_query($query_rsMiMove, $inmoconn) or die(mysql_error());
$row_rsMiMove = mysql_fetch_assoc($rsMiMove);
$totalRows_rsMiMove = mysql_num_rows($rsMiMove);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsMiMove = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mimove_prop = 1
&quot;;
$rsMiMove = mysql_query($query_rsMiMove, $inmoconn) or die(mysql_error());
$row_rsMiMove = mysql_fetch_assoc($rsMiMove);
$totalRows_rsMiMove = mysql_num_rows($rsMiMove);

$query_rsInmoco = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_inmoco_prop = 1
&quot;;
$rsInmoco = mysql_query($query_rsInmoco, $inmoconn) or die(mysql_error());
$row_rsInmoco = mysql_fetch_assoc($rsInmoco);
$totalRows_rsInmoco = mysql_num_rows($rsInmoco);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expMimove) {$tot = $tot + 1;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expMimove) {$tot = $tot + 1;}
if ($expInmoco) {$tot = $tot + 1;}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expMimove) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
      &lt;label for=&quot;export_mimove_prop&quot;&gt;&lt;?php __(&#039;Mi Move&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;controls&quot;&gt;
        &lt;select name=&quot;export_mimove_prop&quot; id=&quot;export_mimove_prop&quot; class=&quot;form-control&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
        &lt;/select&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expMimove) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
      &lt;label for=&quot;export_mimove_prop&quot;&gt;&lt;?php __(&#039;Mi Move&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;controls&quot;&gt;
        &lt;select name=&quot;export_mimove_prop&quot; id=&quot;export_mimove_prop&quot; class=&quot;form-control&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
        &lt;/select&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
&lt;?php if ($expInmoco) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
      &lt;label for=&quot;export_inmoco_prop&quot;&gt;&lt;?php __(&#039;Inmoco&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;controls&quot;&gt;
        &lt;select name=&quot;export_inmoco_prop&quot; id=&quot;export_inmoco_prop&quot; class=&quot;form-control&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
        &lt;/select&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expMimove == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Mi Move&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsMiMove,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expMimove == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Mi Move&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsMiMove,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
&lt;?php if ($expInmoco == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Inmoco&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsInmoco,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var showMimove = &lt;?php echo $expMimove ?&gt;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var showMimove = &lt;?php echo $expMimove ?&gt;;
var showInmoco = &lt;?php echo $expInmoco ?&gt;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expMimove == 1) {
    array_push($aColumns, &#039;export_mimove_prop&#039;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expMimove == 1) {
    array_push($aColumns, &#039;export_mimove_prop&#039;);
}
if ($expInmoco == 1) {
  array_push($aColumns, &#039;export_inmoco_prop&#039;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$mimove = &#039;&#039;;
if (isset($_GET[&#039;export_mimove_prop&#039;]) &amp;&amp; $_GET[&#039;export_mimove_prop&#039;] != &#039;&#039;) {
    $mimove = &quot;AND export_mimove_prop = &quot; . $_GET[&#039;export_mimove_prop&#039;];
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$mimove = &#039;&#039;;
if (isset($_GET[&#039;export_mimove_prop&#039;]) &amp;&amp; $_GET[&#039;export_mimove_prop&#039;] != &#039;&#039;) {
    $mimove = &quot;AND export_mimove_prop = &quot; . $_GET[&#039;export_mimove_prop&#039;];
}
$export_inmoco_prop = &#039;&#039;;
if( isset($_GET[&#039;export_inmoco_prop&#039;]) &amp;&amp; $_GET[&#039;export_inmoco_prop&#039;] != &#039;&#039; ){
    $export_inmoco_prop = &quot;AND export_inmoco_prop = &quot; . $_GET[&#039;export_inmoco_prop&#039;];
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sWhere $ref $kyero $idealista $rightmove $zoopla $thinkspain $hemnet $ubiflow $green $prian $habitaclia $pisos $facilisimo $fotocasa $todopiso $yaencontre $apits $costadelhome $spainhomes $mimove
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$sWhere $ref $kyero $idealista $rightmove $zoopla $thinkspain $hemnet $ubiflow $green $prian $habitaclia $pisos $facilisimo $fotocasa $todopiso $yaencontre $apits $costadelhome $spainhomes $mimove $export_inmoco_prop
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/_js/report-export-search.js
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case properties_properties.export_mimove_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_mimove_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case properties_properties.export_mimove_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_mimove_prop,
case properties_properties.export_inmoco_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_inmoco_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/_js/report-export-search.js
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (showMimove == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_mimove_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mimove_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mimove_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (showMimove == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_mimove_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mimove_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mimove_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}

if (showInmoco == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_inmoco_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_inmoco_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_inmoco_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
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
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Comisi&oacute;n&#039;] = &#039;Commissi&oacute;n&#039;;
$lang[&#039;Exportar a Inmoco&#039;] = &#039;Exportar a Inmoco&#039;;
$lang[&#039;Remember: properties must have a commission field complete.&#039;] = &#039;Recuerde: las propiedades deben tener el campo de comisi&oacute;n completo.&#039;;
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
$lang[&#039;Comisi&oacute;n&#039;] = &#039;Comission&#039;;
$lang[&#039;Exportar a Inmoco&#039;] = &#039;Export to Inmoco&#039;;
$lang[&#039;Remember: properties must have a commission field complete.&#039;] = &#039;Remember: properties must have a commission field complete.&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expSpainHouses == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/spainhome.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/spainhome.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expSpainHouses == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/spainhome.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/spainhome.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
&lt;?php if ($expInmoco == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/inmoco.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/inmoco.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Subir el archivo:
        <pre>
            <code class="makefile">
/xml/inmoco.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
