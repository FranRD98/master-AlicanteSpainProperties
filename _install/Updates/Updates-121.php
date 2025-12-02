<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-03-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Etiqueta Sold no se muestra grande en listados</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Eliminar aviso de *|NOMBRE|* de newsletter</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Mostrar fotos de las casas en el listado de propiedades exportadas</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Reajuste duplicado de inmuebles</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadida descripción propia y descripción para XML</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido envio de ciudades y promociones a Newsletter</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Etiqueta Sold no se muestra grande en listados
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/view/partials/property-list.tpl:16
/templates/partials/slider-properties.tpl:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{* @group SEC - ETIQUETAS *}
&lt;div class=&quot;labels&quot;&gt;
    {if {$resource.nuevo_prop|strtotime} &gt;= $smarty.now }
        &lt;div class=&quot;badge badge-success&quot;&gt;{$lng_nuevo}&lt;/div&gt;
    {/if}
    {if isset($resource.vendido_tag_prop) &amp;&amp; $resource.vendido_tag_prop == 1}
        &lt;div class=&quot;badge badge-danger&quot;&gt;{$lng_vendido}&lt;/div&gt;
    {/if}
    {if isset($resource.alquilado_prop) &amp;&amp; $resource.alquilado_prop == 1}
        &lt;div class=&quot;badge badge-danger&quot;&gt;{$lng_alquilado}&lt;/div&gt;
    {/if}
    {if $resource.reservado_prop == 1}
        &lt;div class=&quot;badge badge-danger&quot;&gt;{$lng_reservado}&lt;/div&gt;
    {/if}
    {assign var=tag value=getPropTags($resource.id_prop, $lang)}
    {section name=tg loop=$tag}
        {if $tag[tg].tag != &#039;&#039;}
            &lt;div class=&quot;badge badge-info label-{$tag[tg].id_tag}&quot;&gt;{$tag[tg].tag}&lt;/div&gt;
        {/if}
    {/section}
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{* @group SEC - ETIQUETAS *}
{if isset($resource.vendido_tag_prop) &amp;&amp; $resource.vendido_tag_prop == 1}
&lt;div class=&quot;vendido-tag-big&quot;&gt;
    {$lng_vendido}
&lt;/div&gt;
{/if}
&lt;div class=&quot;labels&quot;&gt;

    {if {$resource.nuevo_prop|strtotime} &gt;= $smarty.now }
        &lt;div class=&quot;badge bg-success&quot;&gt;{$lng_nuevo}&lt;/div&gt;
    {/if}
    {if $resource.alquilado_prop == 1}
        &lt;div class=&quot;badge bg-danger&quot;&gt;{$lng_alquilado}&lt;/div&gt;
    {/if}
    {if $resource.reservado_prop == 1}
        &lt;div class=&quot;badge bg-danger&quot;&gt;{$lng_reservado}&lt;/div&gt;
    {/if}
    {assign var=tag value=getPropTags($resource.id_prop, $lang)}
    {section name=tg loop=$tag}
        {if $tag[tg].tag != &#039;&#039;}
            &lt;div class=&quot;badge  label-{$tag[tg].id_tag}&quot;&gt;{$tag[tg].tag}&lt;/div&gt;
        {/if}
    {/section}
&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminar aviso de *|NOMBRE|* de newsletter
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:152
/intramedianet/acumbamail/index.php:315
/intramedianet/acumbamail/index.php:453
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3&quot; role=&quot;alert&quot;&gt;
  &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;insert_client_newslette&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;br&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Mostrar fotos de las casas en el listado de propiedades exportadas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:318
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$tot = 2;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$tot = 3;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:677
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th style=&quot;width: 100px;&quot;&gt;&lt;?php __(&#039;Imagen&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, &#039;referencia_prop&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, &#039;image_img&#039;);
array_push($aColumns, &#039;referencia_prop&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:457
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.referencia_prop
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_properties.referencia_prop,
properties_properties.id_prop as image_img
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:515
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
} else {
    if($aRow[ $aColumns[$i] ]!==null)
        $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], &#039;UTF-8&#039;, &#039;ISO-8859-1&#039;);
    else
        $row[] = &#039;&#039;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
} else {
  if ($aColumns[$i] == &#039;image_img&#039;) {
    $sQuery = &quot;SELECT id_img FROM properties_images WHERE property_img = &quot;.$aRow[ $aColumns[$i] ].&quot; ORDER BY order_img LIMIT 1&quot;;
    $rImage = mysqli_query($gaSql[&#039;link&#039;],$sQuery) or fatal_error( &#039;MySQL Error: &#039; . mysqli_errno() );
    $aResul = mysqli_fetch_array($rImage);
    if (isset($aResul[&#039;id_img&#039;]) &amp;&amp; (file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/thumbnails/&#039;.$aResul[&#039;id_img&#039;].&#039;_md.jpg&#039;))) {
          $row[] = &#039;&lt;img src=&quot;/media/images/properties/thumbnails/&#039;.$aResul[&#039;id_img&#039;].&#039;_sm.jpg&quot; alt=&quot;&quot; style=&quot;max-height: 100px;&quot;&gt;&#039;;
      } else {
          $row[] = &#039;&lt;img src=&quot;/intramedianet/includes/assets/img/no_image.jpg&quot; alt=&quot;&quot; style=&quot;max-height: 70px;&quot;&gt;&#039;;
      }
  } else {
      if($aRow[ $aColumns[$i] ]!==null) {
          $row[] = mb_convert_encoding($aRow[ $aColumns[$i] ], &#039;UTF-8&#039;, &#039;ISO-8859-1&#039;);
      } else {
          $row[] = &#039;&#039;;
      }
  }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/_js/report-export-search.js:15
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
columnas.push(null);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
columnas.push(null);
columnas.push(null);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Reajuste duplicado de inmuebles
    </h6>
    <div class="card-body">
        Susutituir el archivo: <code>/intramedianet/properties/properties-dupli.php</code>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadida descripción propia y descripción para XML
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_ca_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_pl_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_da_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_ca_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_de_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_da_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_en_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_de_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_es_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_en_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_fi_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_es_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_fr_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_fi_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_is_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_fr_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_nl_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_is_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_no_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_nl_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_ru_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_no_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_se_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_ru_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_zh_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_se_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `descripcion_xml_pl_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `descripcion_xml_zh_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1271
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;descripcion_&quot;.$value.&quot;_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;descripcion_&quot;.$value.&quot;_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;descripcion_&quot;.$value.&quot;_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;descripcion_&quot;.$value.&quot;_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;descripcion_xml_&quot;.$value.&quot;_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;descripcion_xml_&quot;.$value.&quot;_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1526
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;descripcion_&quot;.$value.&quot;_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;descripcion_&quot;.$value.&quot;_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;descripcion_&quot;.$value.&quot;_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;descripcion_&quot;.$value.&quot;_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;descripcion_xml_&quot;.$value.&quot;_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;descripcion_xml_&quot;.$value.&quot;_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2742
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;br class=&quot;d-md-none&quot;&gt;
&lt;br class=&quot;d-md-none&quot;&gt;

&lt;textarea name=&quot;descripcion_&lt;?php echo $value; ?&gt;_prop&quot; id=&quot;descripcion_&lt;?php echo $value; ?&gt;_prop&quot; rows=&quot;5&quot; class=&quot;wysiwyg mt-5&quot;&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;descripcion_&#039;.$value.&#039;_prop&#039;]); ?&gt;&lt;/textarea&gt;
&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;descripcion_&quot;.$lang_adm.&quot;__prop&quot;); ?&gt;
&lt;?php if ($traduccion_textos == 1): ?&gt;
    &lt;div class=&quot;float-end&quot;&gt;
    &lt;?php foreach ($languages as $langx): ?&gt;
        &lt;?php if ($langx != $value): ?&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-soft-primary btn-sm btn-translate mt-1&quot;
                data-from=&quot;&lt;?php echo $value; ?&gt;&quot;
                data-to=&quot;&lt;?php echo $langx; ?&gt;&quot;
                data-fields-pref=&quot;descripcion_&quot;
                data-fields-suf=&quot;_prop&quot;
                data-tab=&quot;desc&quot;
            &gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; height=&quot;13&quot;&gt; &lt;i class=&quot;fa-solid fa-caret-right mx-1&quot;&gt;&lt;/i&gt; &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $langx; ?&gt;.svg&quot; height=&quot;13&quot;&gt;&lt;/button&gt;
        &lt;?php endif ?&gt;
    &lt;?php endforeach ?&gt;
    &lt;/div&gt;
    &lt;br&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;br class=&quot;d-md-none&quot;&gt;
&lt;br class=&quot;d-md-none&quot;&gt;

&lt;textarea name=&quot;descripcion_&lt;?php echo $value; ?&gt;_prop&quot; id=&quot;descripcion_&lt;?php echo $value; ?&gt;_prop&quot; rows=&quot;5&quot; class=&quot;wysiwyg mt-5&quot;&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;descripcion_&#039;.$value.&#039;_prop&#039;]); ?&gt;&lt;/textarea&gt;
&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;descripcion_&quot;.$lang_adm.&quot;__prop&quot;); ?&gt;
&lt;?php if ($traduccion_textos == 1): ?&gt;
    &lt;div class=&quot;float-end&quot;&gt;
    &lt;?php foreach ($languages as $langx): ?&gt;
        &lt;?php if ($langx != $value): ?&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-soft-primary btn-sm btn-translate mt-1&quot;
                data-from=&quot;&lt;?php echo $value; ?&gt;&quot;
                data-to=&quot;&lt;?php echo $langx; ?&gt;&quot;
                data-fields-pref=&quot;descripcion_&quot;
                data-fields-suf=&quot;_prop&quot;
                data-tab=&quot;desc&quot;
            &gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; height=&quot;13&quot;&gt; &lt;i class=&quot;fa-solid fa-caret-right mx-1&quot;&gt;&lt;/i&gt; &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $langx; ?&gt;.svg&quot; height=&quot;13&quot;&gt;&lt;/button&gt;
        &lt;?php endif ?&gt;
    &lt;?php endforeach ?&gt;
    &lt;/div&gt;
    &lt;br&gt;
&lt;?php endif ?&gt;

&lt;br class=&quot;d-md-none&quot;&gt;
&lt;br class=&quot;d-md-none&quot;&gt;

&lt;label for=&quot;descripcion_xml_&lt;?php echo $value; ?&gt;_prop&quot; class=&quot;form-label mt-4&quot;&gt;&lt;?php __(&#039;Descipci&oacute;n&#039;); ?&gt; XML:&lt;/label&gt;

&lt;textarea name=&quot;descripcion_xml_&lt;?php echo $value; ?&gt;_prop&quot; id=&quot;descripcion_xml_&lt;?php echo $value; ?&gt;_prop&quot; rows=&quot;5&quot; class=&quot;wysiwyg mt-5&quot;&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;descripcion_xml_&#039;.$value.&#039;_prop&#039;]); ?&gt;&lt;/textarea&gt;
&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;descripcion_xml_&quot;.$lang_adm.&quot;__prop&quot;); ?&gt;
&lt;?php if ($traduccion_textos == 1): ?&gt;
    &lt;div class=&quot;float-end&quot;&gt;
    &lt;?php foreach ($languages as $langx): ?&gt;
        &lt;?php if ($langx != $value): ?&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-soft-primary btn-sm btn-translate mt-1&quot;
                data-from=&quot;&lt;?php echo $value; ?&gt;&quot;
                data-to=&quot;&lt;?php echo $langx; ?&gt;&quot;
                data-fields-pref=&quot;descripcion_xml_&quot;
                data-fields-suf=&quot;_prop&quot;
                data-tab=&quot;desc&quot;
            &gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; height=&quot;13&quot;&gt; &lt;i class=&quot;fa-solid fa-caret-right mx-1&quot;&gt;&lt;/i&gt; &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $langx; ?&gt;.svg&quot; height=&quot;13&quot;&gt;&lt;/button&gt;
        &lt;?php endif ?&gt;
    &lt;?php endforeach ?&gt;
    &lt;/div&gt;
    &lt;br&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:5014
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
    &lt;input class=&quot;form-check-input actgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptAction&quot; id=&quot;gptAction2&quot; value=&quot;descripcion__prop&quot;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;gptAction2&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt;&lt;/label&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
    &lt;input class=&quot;form-check-input actgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptAction&quot; id=&quot;gptAction2&quot; value=&quot;descripcion__prop&quot;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;gptAction2&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt;&lt;/label&gt;
&lt;/div&gt;

&lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
    &lt;input class=&quot;form-check-input actgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptAction&quot; id=&quot;gptAction5&quot; value=&quot;descripcion_xml__prop&quot;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;gptAction5&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt; XML&lt;/label&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:5067
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
    &lt;input class=&quot;form-check-input actransgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptActionTrans&quot; id=&quot;gptActionTrans2&quot; value=&quot;descripcion_&quot;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;gptActionTrans2&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt;&lt;/label&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
    &lt;input class=&quot;form-check-input actransgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptActionTrans&quot; id=&quot;gptActionTrans2&quot; value=&quot;descripcion_&quot;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;gptActionTrans2&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt;&lt;/label&gt;
&lt;/div&gt;

&lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
    &lt;input class=&quot;form-check-input actransgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptActionTrans&quot; id=&quot;gptActionTrans5&quot; value=&quot;descripcion_xml_&quot;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;gptActionTrans5&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt; XML&lt;/label&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:5957
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script&gt;
    $(&#039;.generateTXTgpt&#039;).click(function(e) {
        e.preventDefault();

        $(&#039;#ChatGPTModal .modal-body&#039;).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

        $action = $(&quot;.actgpt:checked&quot;).val();
        $toLng = $(&quot;#toLng option:selected&quot;).text();
        $toLngVal = $(&quot;#toLng option:selected&quot;).val();
        $prompt = $(&quot;#chatgpt_prompt_prop&quot;).val();

        if ($action == &#039;titulo__prop&#039;) { // Titular
            action = &#039;title&#039;;
        }
        if ($action == &#039;descripcion__prop&#039;) { // Descripci&oacute;n
            action = &#039;description&#039;;
        }
        if ($action == &#039;title__prop&#039;) { // Meta Title
            action = &#039;metatit&#039;;
        }
        if ($action == &#039;description__prop&#039;) { // Meta Description
            action = &#039;metades&#039;;
        }

        $.get(&quot;prompt.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;lang=&quot; + $toLngVal +  &quot;&amp;langto=&quot; + $toLng + &quot;&amp;action=&quot; + action + &quot;&amp;prompt=&quot; + $prompt, function(data) {
            $field = &#039;#&#039; + $action.replace(&#039;__&#039;, &#039;_&#039; + $toLngVal + &#039;_&#039;);

            if ($action == &#039;descripcion__prop&#039;) {
                $($field).redactor(&#039;source.setCode&#039;, data);
            } else {
                $($field).val(data).keyup();
            }
            $(&#039;#ChatGPTModal .loading&#039;).remove().keyup();

            const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $toLngVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $toLngVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });
&lt;/script&gt;
&lt;script&gt;
    $(&#039;.generateTXTTradgpt&#039;).click(function(e) {
        e.preventDefault();

        $(&#039;#ChatGPTransModal .modal-body&#039;).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

        $action = $(&quot;.actransgpt:checked&quot;).val();
        $fromtrans = $(&quot;#fromtrans option:selected&quot;).text();
        $fromtransVal = $(&quot;#fromtrans option:selected&quot;).val();
        $totrans = $(&quot;#totrans option:selected&quot;).text();
        $totransVal = $(&quot;#totrans option:selected&quot;).val();

        $.get(&quot;prompt-trans.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;lang=&lt;?php echo $lang_adm; ?&gt;&amp;action=&quot; + $action + &quot;&amp;from=&quot; + $fromtrans + &quot;&amp;to=&quot; + $totrans + &quot;&quot; , function(data) {
            $field = &#039;#&#039; + $action + $totransVal + &#039;_prop&#039;;
            if ($action == &#039;descripcion_&#039;) {
                $($field).redactor(&#039;source.setCode&#039;, data);
            } else {
                $($field).val(data).keyup();
            }
            $(&#039;#ChatGPTransModal .loading&#039;).remove().keyup();

            const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $totransVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $totransVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });

    $(&#039;.tabdescr&#039;).click(function(e) {
        e.preventDefault();
        $(&#039;#toLng option[value=&quot;&#039; + $(this).data(&#039;lang&#039;) + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
        $(&#039;#fromtrans option[value=&quot;&#039; + $(this).data(&#039;lang&#039;) + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });

    $(&#039;#toLng&#039;).change(function(e) {
        const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $( &quot;#toLng option:selected&quot;).val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $( &quot;#toLng option:selected&quot;).val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $(&#039;#fromtrans option[value=&quot;&#039; + $( &quot;#toLng option:selected&quot;).val() + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });

    $(&#039;#fromtrans&#039;).change(function(e) {
        const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $( &quot;#fromtrans option:selected&quot;).val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $( &quot;#fromtrans option:selected&quot;).val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $(&#039;#toLng option[value=&quot;&#039; + $( &quot;#fromtrans option:selected&quot;).val() + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });
&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script&gt;
    $(&#039;.generateTXTgpt&#039;).click(function(e) {
        e.preventDefault();

        $(&#039;#ChatGPTModal .modal-body&#039;).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

        $action = $(&quot;.actgpt:checked&quot;).val();
        $toLng = $(&quot;#toLng option:selected&quot;).text();
        $toLngVal = $(&quot;#toLng option:selected&quot;).val();
        $prompt = $(&quot;#chatgpt_prompt_prop&quot;).val();

        if ($action == &#039;titulo__prop&#039;) { // Titular
            action = &#039;title&#039;;
        }
        if ($action == &#039;descripcion__prop&#039;) { // Descripci&oacute;n
            action = &#039;description&#039;;
        }
        if ($action == &#039;descripcion_xml__prop&#039;) { // Descripci&oacute;n XML
            action = &#039;description&#039;;
        }
        if ($action == &#039;title__prop&#039;) { // Meta Title
            action = &#039;metatit&#039;;
        }
        if ($action == &#039;description__prop&#039;) { // Meta Description
            action = &#039;metades&#039;;
        }

        $.get(&quot;prompt.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;lang=&quot; + $toLngVal +  &quot;&amp;langto=&quot; + $toLng + &quot;&amp;action=&quot; + action + &quot;&amp;prompt=&quot; + $prompt, function(data) {
            $field = &#039;#&#039; + $action.replace(&#039;__&#039;, &#039;_&#039; + $toLngVal + &#039;_&#039;);

            if ($action == &#039;descripcion__prop&#039; || $action == &#039;descripcion_xml__prop&#039;) {
                $($field).redactor(&#039;source.setCode&#039;, data);
            } else {
                $($field).val(data).keyup();
            }
            $(&#039;#ChatGPTModal .loading&#039;).remove().keyup();

            const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $toLngVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $toLngVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });
&lt;/script&gt;
&lt;script&gt;
    $(&#039;.generateTXTTradgpt&#039;).click(function(e) {
        e.preventDefault();

        $(&#039;#ChatGPTransModal .modal-body&#039;).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

        $action = $(&quot;.actransgpt:checked&quot;).val();
        $fromtrans = $(&quot;#fromtrans option:selected&quot;).text();
        $fromtransVal = $(&quot;#fromtrans option:selected&quot;).val();
        $totrans = $(&quot;#totrans option:selected&quot;).text();
        $totransVal = $(&quot;#totrans option:selected&quot;).val();

        $.get(&quot;prompt-trans.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;lang=&lt;?php echo $lang_adm; ?&gt;&amp;action=&quot; + $action + &quot;&amp;from=&quot; + $fromtrans + &quot;&amp;to=&quot; + $totrans + &quot;&quot; , function(data) {
            $field = &#039;#&#039; + $action + $totransVal + &#039;_prop&#039;;
            if ($action == &#039;descripcion_&#039; || $action == &#039;descripcion_xml_&#039;) {
                $($field).redactor(&#039;source.setCode&#039;, data);
            } else {
                $($field).val(data).keyup();
            }
            $(&#039;#ChatGPTransModal .loading&#039;).remove().keyup();

            const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $totransVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $totransVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });

    $(&#039;.tabdescr&#039;).click(function(e) {
        e.preventDefault();
        $(&#039;#toLng option[value=&quot;&#039; + $(this).data(&#039;lang&#039;) + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
        $(&#039;#fromtrans option[value=&quot;&#039; + $(this).data(&#039;lang&#039;) + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });

    $(&#039;#toLng&#039;).change(function(e) {
        const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $( &quot;#toLng option:selected&quot;).val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $( &quot;#toLng option:selected&quot;).val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $(&#039;#fromtrans option[value=&quot;&#039; + $( &quot;#toLng option:selected&quot;).val() + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });

    $(&#039;#fromtrans&#039;).change(function(e) {
        const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $( &quot;#fromtrans option:selected&quot;).val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $( &quot;#fromtrans option:selected&quot;).val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $(&#039;#toLng option[value=&quot;&#039; + $( &quot;#fromtrans option:selected&quot;).val() + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/prompt-trans.php:44
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_&quot;.$langFrom.&quot;_prop as descripcion_&quot;.$langFrom.&quot;_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_properties.descripcion_&quot;.$langFrom.&quot;_prop as descripcion_&quot;.$langFrom.&quot;_prop,
properties_properties.descripcion_xml_&quot;.$langFrom.&quot;_prop as descripcion_xml_&quot;.$langFrom.&quot;_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaBulkExportProperty.php:67
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
    &quot;FeatureId&quot; =&gt; 2,
    &quot;TextValue&quot; =&gt; substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;]), 0, 300).&quot;...&quot;,
    &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
);
$export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
    &quot;FeatureId&quot; =&gt; 3,
    &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;]))),
    &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;] != &#039;&#039;) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;]), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;]))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;]), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;]))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaExportProperty.php:75
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
    &quot;FeatureId&quot; =&gt; 2,
    &quot;TextValue&quot; =&gt; substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;)), 0, 300).&quot;...&quot;,
    &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
);
$export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
    &quot;FeatureId&quot; =&gt; 3,
    &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;)))),
    &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;) != &#039;&#039;) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;)), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;)))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;)), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;)))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/rightmove/properties-rightmove.php:81
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;summary&#039;] = substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_en_prop&#039;)), 0, 300).&quot;...&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($tNG-&gt;getColumnValue(&#039;descripcion_xml_en_prop&#039;) != &#039;&#039;) {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;summary&#039;] = substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_xml_en_prop&#039;)), 0, 300).&quot;...&quot;;
} else {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;summary&#039;] = substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_en_prop&#039;)), 0, 300).&quot;...&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/rightmove/properties-rightmove.php:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;description&#039;] =  strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_en_prop&#039;));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($tNG-&gt;getColumnValue(&#039;descripcion_xml_en_prop&#039;) != &#039;&#039;) {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;description&#039;] =  strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_xml_en_prop&#039;));
} else {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;description&#039;] =  strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_en_prop&#039;));
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/rightmove/properties-rightmove-bulk.php:122
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;summary&#039;] = substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_en_prop&#039;]), 0, 300).&quot;...&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsFotocasaProperty[&#039;descripcion_xml_en_prop&#039;] != &#039;&#039;) {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;summary&#039;] = substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_xml_en_prop&#039;]), 0, 300).&quot;...&quot;;
} else {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;summary&#039;] = substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_en_prop&#039;]), 0, 300).&quot;...&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/rightmove/properties-rightmove-bulk.php:128
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;description&#039;] =  strip_tags($row_rsFotocasaProperty[&#039;descripcion_en_prop&#039;]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsFotocasaProperty[&#039;descripcion_xml_en_prop&#039;] != &#039;&#039;) {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;description&#039;] =  strip_tags($row_rsFotocasaProperty[&#039;descripcion_xml_en_prop&#039;]);
} else {
    $jsonRightmove[&#039;property&#039;][&#039;details&#039;][&#039;description&#039;] =  strip_tags($row_rsFotocasaProperty[&#039;descripcion_en_prop&#039;]);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/apits.php:116
/xml/costadelhome.php:116
/xml/facilisimo.php:29
/xml/greenacres.php:112
/xml/habitaclia.php:29
/xml/hemnet.php:112
/xml/inmoco.php:32
/xml/kyero_mls.php:34
/xml/mimove.php:133
/xml/spainhome.php:116
/xml/sun.php:151
/xml/thinkspain.php:112
/xml/todopisoalicante.php:112
/xml/yaencontre.php:32
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_en_prop,
properties_properties.descripcion_es_prop,
properties_properties.descripcion_de_prop,
properties_properties.descripcion_nl_prop,
properties_properties.descripcion_fr_prop,
properties_properties.descripcion_da_prop,
properties_properties.descripcion_ru_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/facebook.php:33
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_&quot;.$_GET[&#039;lang&#039;].&quot;_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_&quot;.$_GET[&#039;lang&#039;].&quot;_prop != &#039;&#039; THEN properties_properties.descripcion_xml_&quot;.$_GET[&#039;lang&#039;].&quot;_prop ELSE properties_properties.descripcion_&quot;.$_GET[&#039;lang&#039;].&quot;_prop END AS properties_properties.descripcion_&quot;.$_GET[&#039;lang&#039;].&quot;_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:46
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_es_prop,
properties_properties.descripcion_en_prop,
properties_properties.descripcion_de_prop,
properties_properties.descripcion_fr_prop,
properties_properties.descripcion_ru_prop,
properties_properties.descripcion_se_prop,
properties_properties.descripcion_nl_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/kyero.php:136
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_en_prop,
properties_properties.descripcion_es_prop,
properties_properties.descripcion_de_prop,
properties_properties.descripcion_nl_prop,
properties_properties.descripcion_fr_prop,
properties_properties.descripcion_da_prop,
properties_properties.descripcion_ru_prop,
properties_properties.descripcion_se_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/mediaelx.php:142
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_da_prop,
properties_properties.descripcion_de_prop,
properties_properties.descripcion_en_prop,
properties_properties.descripcion_es_prop,
properties_properties.descripcion_fi_prop,
properties_properties.descripcion_fr_prop,
properties_properties.descripcion_is_prop,
properties_properties.descripcion_nl_prop,
properties_properties.descripcion_no_prop,
properties_properties.descripcion_ru_prop,
properties_properties.descripcion_se_prop,
properties_properties.descripcion_zh_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN  properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN  properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN  properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN  properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN  properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS properties_properties.descripcion_fi_prop,
CASE WHEN  properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN  properties_properties.descripcion_xml_is_prop != &#039;&#039; THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS properties_properties.descripcion_is_prop,
CASE WHEN  properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN  properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS properties_properties.descripcion_no_prop,
CASE WHEN  properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN  properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN  properties_properties.descripcion_xml_zh_prop != &#039;&#039; THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS properties_properties.descripcion_zh_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/openinmo.php:325
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_en_prop,
properties_properties.descripcion_es_prop,
properties_properties.descripcion_de_prop,
properties_properties.descripcion_nl_prop,
properties_properties.descripcion_fr_prop,
properties_properties.descripcion_da_prop,
properties_properties.descripcion_ru_prop,
properties_properties.descripcion_it_prop,
properties_properties.descripcion_pt_prop
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/pisos.php:35
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_en_prop,
properties_properties.descripcion_es_prop,
properties_properties.descripcion_de_prop,
properties_properties.descripcion_nl_prop,
properties_properties.descripcion_fr_prop,
properties_properties.descripcion_da_prop,
properties_properties.descripcion_ru_prop,
properties_properties.descripcion_no_prop,
properties_properties.descripcion_se_prop,
properties_properties.descripcion_fi_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS properties_properties.descripcion_no_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS properties_properties.descripcion_fi_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/ubiflow.php:118
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.titulo_da_prop,
properties_properties.titulo_de_prop,
properties_properties.titulo_en_prop,
properties_properties.titulo_es_prop,
properties_properties.titulo_fi_prop,
properties_properties.titulo_fr_prop,
properties_properties.titulo_is_prop,
properties_properties.titulo_nl_prop,
properties_properties.titulo_no_prop,
properties_properties.titulo_ru_prop,
properties_properties.titulo_se_prop,
properties_properties.titulo_zh_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.titulo_xml_da_prop != &#039;&#039; THEN properties_properties.titulo_xml_da_prop ELSE properties_properties.titulo_da_prop END AS properties_properties.titulo_da_prop,
CASE WHEN properties_properties.titulo_xml_de_prop != &#039;&#039; THEN properties_properties.titulo_xml_de_prop ELSE properties_properties.titulo_de_prop END AS properties_properties.titulo_de_prop,
CASE WHEN properties_properties.titulo_xml_en_prop != &#039;&#039; THEN properties_properties.titulo_xml_en_prop ELSE properties_properties.titulo_en_prop END AS properties_properties.titulo_en_prop,
CASE WHEN properties_properties.titulo_xml_es_prop != &#039;&#039; THEN properties_properties.titulo_xml_es_prop ELSE properties_properties.titulo_es_prop END AS properties_properties.titulo_es_prop,
CASE WHEN properties_properties.titulo_xml_fi_prop != &#039;&#039; THEN properties_properties.titulo_xml_fi_prop ELSE properties_properties.titulo_fi_prop END AS properties_properties.titulo_fi_prop,
CASE WHEN properties_properties.titulo_xml_fr_prop != &#039;&#039; THEN properties_properties.titulo_xml_fr_prop ELSE properties_properties.titulo_fr_prop END AS properties_properties.titulo_fr_prop,
CASE WHEN properties_properties.titulo_xml_is_prop != &#039;&#039; THEN properties_properties.titulo_xml_is_prop ELSE properties_properties.titulo_is_prop END AS properties_properties.titulo_is_prop,
CASE WHEN properties_properties.titulo_xml_nl_prop != &#039;&#039; THEN properties_properties.titulo_xml_nl_prop ELSE properties_properties.titulo_nl_prop END AS properties_properties.titulo_nl_prop,
CASE WHEN properties_properties.titulo_xml_no_prop != &#039;&#039; THEN properties_properties.titulo_xml_no_prop ELSE properties_properties.titulo_no_prop END AS properties_properties.titulo_no_prop,
CASE WHEN properties_properties.titulo_xml_ru_prop != &#039;&#039; THEN properties_properties.titulo_xml_ru_prop ELSE properties_properties.titulo_ru_prop END AS properties_properties.titulo_ru_prop,
CASE WHEN properties_properties.titulo_xml_se_prop != &#039;&#039; THEN properties_properties.titulo_xml_se_prop ELSE properties_properties.titulo_se_prop END AS properties_properties.titulo_se_prop,
CASE WHEN properties_properties.titulo_xml_zh_prop != &#039;&#039; THEN properties_properties.titulo_xml_zh_prop ELSE properties_properties.titulo_zh_prop END AS properties_properties.titulo_zh_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/xml-mediaelx.php:221
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_ca_prop,
properties_properties.descripcion_da_prop,
properties_properties.descripcion_de_prop,
properties_properties.descripcion_en_prop,
properties_properties.descripcion_es_prop,
properties_properties.descripcion_fi_prop,
properties_properties.descripcion_fr_prop,
properties_properties.descripcion_is_prop,
properties_properties.descripcion_nl_prop,
properties_properties.descripcion_no_prop,
properties_properties.descripcion_ru_prop,
properties_properties.descripcion_se_prop,
properties_properties.descripcion_zh_prop,
properties_properties.descripcion_pl_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_ca_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ca_prop ELSE properties_properties.descripcion_ca_prop END AS properties_properties.descripcion_ca_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS properties_properties.descripcion_fi_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_is_prop != &#039;&#039; THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS properties_properties.descripcion_is_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS properties_properties.descripcion_no_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_zh_prop != &#039;&#039; THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS properties_properties.descripcion_zh_prop,
CASE WHEN properties_properties.descripcion_xml_pl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_pl_prop ELSE properties_properties.descripcion_pl_prop END AS properties_properties.descripcion_pl_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/zoopla.php:159
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$return .= mysqli_real_escape_string($inmoconn,htmlentities(htmlentities(trim(str_replace([&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;], &quot; &quot;, preg_replace(&#039;/((\b\w+\b.*?){30}).*$/s&#039;, &#039;$1&#039;, strip_tags($row_rsProperties[&#039;descripcion_en_prop&#039;]))))))) . &#039;|&#039;; // Sumario SUMMARY
$return .= mysqli_real_escape_string($inmoconn,strip_tags(str_replace([&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;], &quot; &quot;, $row_rsProperties[&#039;descripcion_en_prop&#039;]))) . &#039;|&#039;; // Descripci&oacute;n DESCRIPTION
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsProperties[&#039;descripcion_xml_en_prop&#039;] != &#039;&#039;) {
    $return .= mysqli_real_escape_string($inmoconn,htmlentities(htmlentities(trim(str_replace([&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;], &quot; &quot;, preg_replace(&#039;/((\b\w+\b.*?){30}).*$/s&#039;, &#039;$1&#039;, strip_tags($row_rsProperties[&#039;descripcion_xml_en_prop&#039;]))))))) . &#039;|&#039;; // Sumario SUMMARY
    $return .= mysqli_real_escape_string($inmoconn,strip_tags(str_replace([&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;], &quot; &quot;, $row_rsProperties[&#039;descripcion_xml_en_prop&#039;]))) . &#039;|&#039;; // Descripci&oacute;n DESCRIPTION
} else {
    $return .= mysqli_real_escape_string($inmoconn,htmlentities(htmlentities(trim(str_replace([&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;], &quot; &quot;, preg_replace(&#039;/((\b\w+\b.*?){30}).*$/s&#039;, &#039;$1&#039;, strip_tags($row_rsProperties[&#039;descripcion_en_prop&#039;]))))))) . &#039;|&#039;; // Sumario SUMMARY
    $return .= mysqli_real_escape_string($inmoconn,strip_tags(str_replace([&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;], &quot; &quot;, $row_rsProperties[&#039;descripcion_en_prop&#039;]))) . &#039;|&#039;; // Descripci&oacute;n DESCRIPTION
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido envio de ciudades y promociones a Newsletter
    </h6>
    <div class="card-body">
        Añadir los archivos:
        <pre>
            <code class="makefile">
/modules/mail_partials/ciu-acumba.php
/modules/mail_partials/prom-acumba.php
            </code>
        </pre>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
foreach ($languages as $idm) {

    $query_rsNews[$idm] = &quot;SELECT title_&quot;.$idm.&quot;_nws, id_nws FROM news WHERE type_nws = 1 AND content_&quot;.$idm.&quot;_nws != &#039;&#039; ORDER BY title_&quot;.$idm.&quot;_nws&quot;;
    $rsNews[$idm] = mysqli_query($inmoconn,$query_rsNews[$idm]) or die(mysqli_error());
    $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
foreach ($languages as $idm) {

    $query_rsNews[$idm] = &quot;SELECT title_&quot;.$idm.&quot;_nws, id_nws FROM news WHERE type_nws = 1 AND content_&quot;.$idm.&quot;_nws != &#039;&#039; ORDER BY title_&quot;.$idm.&quot;_nws&quot;;
    $rsNews[$idm] = mysqli_query($inmoconn,$query_rsNews[$idm]) or die(mysqli_error());
    $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);

    $query_rsProm[$idm] = &quot;SELECT title_&quot;.$idm.&quot;_nws, id_nws FROM news WHERE type_nws = 999 AND content_&quot;.$idm.&quot;_nws != &#039;&#039; ORDER BY title_&quot;.$idm.&quot;_nws&quot;;
    $rsProm[$idm] = mysqli_query($inmoconn,$query_rsProm[$idm]) or die(mysqli_error());
    $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);

    $query_rsCities[$idm] = &quot;SELECT title_&quot;.$idm.&quot;_nws, id_nws FROM news WHERE type_nws = 6 AND content_&quot;.$idm.&quot;_nws != &#039;&#039; ORDER BY title_&quot;.$idm.&quot;_nws&quot;;
    $rsCities[$idm] = mysqli_query($inmoconn,$query_rsCities[$idm]) or die(mysqli_error());
    $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:257
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddn&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
  &lt;/div&gt;
  &lt;?php foreach ($languages as $idm): ?&gt;
  &lt;div class=&quot;row noticias1&quot; id=&quot;news_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;news1_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Noticias&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;news1_&lt;?php echo $idm ?&gt;&quot; id=&quot;news1_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actNoticias == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsNews[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsNews[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                $rows = mysqli_num_rows($rsNews[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsNews[$idm], 0);
                  $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selnews1&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddn&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row noticias1&quot; id=&quot;news_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;news1_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Noticias&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;news1_&lt;?php echo $idm ?&gt;&quot; id=&quot;news1_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actNoticias == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsNews[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsNews[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                $rows = mysqli_num_rows($rsNews[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsNews[$idm], 0);
                  $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selnews1&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php if ($actPromociones == 1): ?&gt;
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddp&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row promociones1&quot; id=&quot;prom_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;prom1_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Promociones&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;prom1_&lt;?php echo $idm ?&gt;&quot; id=&quot;prom1_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actPromociones == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsProm[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsProm[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]));
                $rows = mysqli_num_rows($rsProm[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsProm[$idm], 0);
                  $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selprom1&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php endif ?&gt;
&lt;?php if ($actZonas == 1): ?&gt;
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddc&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row ciudades1&quot; id=&quot;ciu_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;ciu1_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Áreas&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;ciu1_&lt;?php echo $idm ?&gt;&quot; id=&quot;ciu1_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actZonas == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsCities[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsCities[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]));
                $rows = mysqli_num_rows($rsCities[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsCities[$idm], 0);
                  $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selciu1&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:485
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row mt-4&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddn2&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row noticias2&quot; id=&quot;news2_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;news2_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Noticias&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;news2_&lt;?php echo $idm ?&gt;&quot; id=&quot;news2_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actNoticias == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsNews[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsNews[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                $rows = mysqli_num_rows($rsNews[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsNews[$idm], 0);
                  $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selnews2&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row mt-4&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddn2&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row noticias2&quot; id=&quot;news2_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;news2_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Noticias&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;news2_&lt;?php echo $idm ?&gt;&quot; id=&quot;news2_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actNoticias == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsNews[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsNews[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                $rows = mysqli_num_rows($rsNews[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsNews[$idm], 0);
                  $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selnews2&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php if ($actPromociones == 1): ?&gt;
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddp2&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row promociones2&quot; id=&quot;prom2_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;prom2_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Promociones&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;prom2_&lt;?php echo $idm ?&gt;&quot; id=&quot;prom2_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actPromociones == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsProm[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsProm[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]));
                $rows = mysqli_num_rows($rsProm[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsProm[$idm], 0);
                  $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selprom2&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php endif ?&gt;
&lt;?php if ($actZonas == 1): ?&gt;
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddc2&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row ciudades2&quot; id=&quot;ciu2_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;ciu2_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Áreas&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;ciu2_&lt;?php echo $idm ?&gt;&quot; id=&quot;ciu2_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actZonas == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsCities[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsCities[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]));
                $rows = mysqli_num_rows($rsCities[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsCities[$idm], 0);
                  $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selciu2&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:689
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row mt-4&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddn3&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row noticias3&quot; id=&quot;news3_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;news3_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Noticias&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;news3_&lt;?php echo $idm ?&gt;&quot; id=&quot;news3_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actNoticias == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsNews[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsNews[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                $rows = mysqli_num_rows($rsNews[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsNews[$idm], 0);
                  $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selnews3&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row mt-4&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddn3&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row noticias3&quot; id=&quot;news3_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;news3_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Noticias&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;news3_&lt;?php echo $idm ?&gt;&quot; id=&quot;news3_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actNoticias == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsNews[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsNews[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]));
                $rows = mysqli_num_rows($rsNews[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsNews[$idm], 0);
                  $row_rsNews[$idm] = mysqli_fetch_assoc($rsNews[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selnews3&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php if ($actPromociones == 1): ?&gt;
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddp3&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row promociones3&quot; id=&quot;prom3_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;prom3_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Promociones&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;prom3_&lt;?php echo $idm ?&gt;&quot; id=&quot;prom3_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actPromociones == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsProm[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsProm[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]));
                $rows = mysqli_num_rows($rsProm[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsProm[$idm], 0);
                  $row_rsProm[$idm] = mysqli_fetch_assoc($rsProm[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selprom3&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php endif ?&gt;
&lt;?php if ($actZonas == 1): ?&gt;
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;br&gt;
    &lt;div class=&quot;dd ddc3&quot;&gt;
      &lt;ol class=&quot;dd-list&quot;&gt;&lt;/ol&gt;
    &lt;/div&gt;
    &lt;br&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php foreach ($languages as $idm): ?&gt;
&lt;div class=&quot;row ciudades3&quot; id=&quot;ciu3_&lt;?php echo $idm ?&gt;&quot;&gt;
  &lt;div class=&quot;col-md-9&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;ciu3_&lt;?php echo $idm ?&gt;&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Áreas&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;ciu3_&lt;?php echo $idm ?&gt;&quot; id=&quot;ciu3_&lt;?php echo $idm ?&gt;&quot; class=&quot;select2&quot; &lt;?php if ($actZonas == 0): ?&gt;disabled&lt;?php endif ?&gt;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;?php do { ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsCities[$idm][&#039;id_nws&#039;]?&gt;&quot;&gt;
                  &lt;?php echo $row_rsCities[$idm][&#039;title_&#039;.$idm.&#039;_nws&#039;]?&gt;
              &lt;/option&gt;
              &lt;?php
              } while ($row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]));
                $rows = mysqli_num_rows($rsCities[$idm]);
                if($rows &gt; 0) {
                    mysqli_data_seek($rsCities[$idm], 0);
                  $row_rsCities[$idm] = mysqli_fetch_assoc($rsCities[$idm]);
                }
              ?&gt;
          &lt;/select&gt;
      &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;controls&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;br&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;btn btn-primary w-100 selciu3&quot; data-lang=&quot;&lt;?php echo $idm ?&gt;&quot;&gt;&lt;?php __(&#039;Seleccionar&#039;); ?&gt;&lt;/button&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;?php endforeach ?&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:864
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#lang1&#039;).change(function(e) {
    var idm = $(this).val();
    $(&#039;.noticias1&#039;).hide();
    $(&#039;#news_&#039; + idm).show();
    $(&#039;.ddn .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#news1_&#039; + idm).val(null).trigger(&#039;change&#039;);
}).change();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#lang1&#039;).change(function(e) {
    var idm = $(this).val();
    $(&#039;.noticias1&#039;).hide();
    $(&#039;#news_&#039; + idm).show();
    $(&#039;.ddn .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#news1_&#039; + idm).val(null).trigger(&#039;change&#039;);

    $(&#039;.promociones1&#039;).hide();
    $(&#039;#prom_&#039; + idm).show();
    $(&#039;.ddp .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#prom1_&#039; + idm).val(null).trigger(&#039;change&#039;);

    $(&#039;.ciudades1&#039;).hide();
    $(&#039;#ciu_&#039; + idm).show();
    $(&#039;.ddc .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#ciu1_&#039; + idm).val(null).trigger(&#039;change&#039;);
}).change();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:882
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.selnews1&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#news1_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#news1_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddn .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsnews1[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#news1_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddn&#039;).nestable({
    group: 1
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.selnews1&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#news1_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#news1_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddn .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsnews1[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#news1_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddn&#039;).nestable({
    group: 1
});

$(&#039;.selprom1&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#prom1_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#prom1_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddpr .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsprom1[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#prom1_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddpr&#039;).nestable({
    group: 1
});

$(&#039;.selciu1&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#ciu1_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#ciu1_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddc .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsciu1[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#ciu1_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddc&#039;).nestable({
    group: 1
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:940
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#lang2&#039;).change(function(e) {
    var idm = $(this).val();
    $(&#039;.noticias2&#039;).hide();
    $(&#039;#news2_&#039; + idm).show();
    $(&#039;.ddn2 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#news2_&#039; + idm).val(null).trigger(&#039;change&#039;);
}).change();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#lang2&#039;).change(function(e) {
    var idm = $(this).val();
    $(&#039;.noticias2&#039;).hide();
    $(&#039;#news2_&#039; + idm).show();
    $(&#039;.ddn2 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#news2_&#039; + idm).val(null).trigger(&#039;change&#039;);

    $(&#039;.promociones2&#039;).hide();
    $(&#039;#prom2_&#039; + idm).show();
    $(&#039;.ddpr2 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#prom2_&#039; + idm).val(null).trigger(&#039;change&#039;);

    $(&#039;.ciudades2&#039;).hide();
    $(&#039;#ciu2_&#039; + idm).show();
    $(&#039;.ddc2 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#ciu2_&#039; + idm).val(null).trigger(&#039;change&#039;);
}).change();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:958
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.selnews2&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#news2_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#news2_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddn2 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsnews2[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#news2_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddn2&#039;).nestable({
    group: 1
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.selnews2&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#news2_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#news2_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddn2 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsnews2[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#news2_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddn2&#039;).nestable({
    group: 1
});

$(&#039;.selprom2&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#prom2_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#prom2_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddpr2 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsprom2[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#prom2_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddpr2&#039;).nestable({
    group: 1
});

$(&#039;.selciu2&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#ciu2_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#ciu2_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddc2 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsciu2[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#ciu2_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddc2&#039;).nestable({
    group: 1
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:1016
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#lang3&#039;).change(function(e) {
    var idm = $(this).val();
    $(&#039;.noticias3&#039;).hide();
    $(&#039;#news3_&#039; + idm).show();
    $(&#039;.ddn3 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#news3_&#039; + idm).val(null).trigger(&#039;change&#039;);
}).change();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#lang3&#039;).change(function(e) {
    var idm = $(this).val();
    $(&#039;.noticias3&#039;).hide();
    $(&#039;#news3_&#039; + idm).show();
    $(&#039;.ddn3 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#news3_&#039; + idm).val(null).trigger(&#039;change&#039;);

    $(&#039;.promociones3&#039;).hide();
    $(&#039;#prom3_&#039; + idm).show();
    $(&#039;.ddpr3 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#prom3_&#039; + idm).val(null).trigger(&#039;change&#039;);

    $(&#039;.ciudades3&#039;).hide();
    $(&#039;#ciu3_&#039; + idm).show();
    $(&#039;.ddn3 .dd-list&#039;).html(&#039;&#039;);
    $(&#039;#ciu3_&#039; + idm).val(null).trigger(&#039;change&#039;);
}).change();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:1034
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.selnews3&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#news3_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#news3_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddn3 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsnews3[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#news3_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddn3&#039;).nestable({
    group: 1
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.selnews3&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#news3_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#news3_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddn3 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsnews3[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#news3_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddn3&#039;).nestable({
    group: 1
});

$(&#039;.selprom3&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#prom3_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#prom3_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddpr3 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsprom3[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#prom3_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddpr3&#039;).nestable({
    group: 1
});

$(&#039;.selciu3&#039;).click(function(e) {
    var lang = $(this).data(&#039;lang&#039;);
    var val = $(&#039;#ciu3_&#039; + lang).find(&#039;:selected&#039;).val();
    var text = $(&#039;#ciu3_&#039; + lang).find(&#039;:selected&#039;).text();
    if (val != &#039;&#039;) {
        $(&#039;.ddc3 .dd-list&#039;).append(&#039;&lt;li class=&quot;dd-item&quot;&gt;&lt;div class=&quot;dd-handle&quot;&gt;&lt;i class=&quot;fa fa-bars fa-fw&quot;&gt;&lt;/i&gt;&lt;/div&gt;&lt;div class=&quot;dd-content&quot;&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-danger btn-sm float-end delproplist1&quot; style=&quot;margin-top: 7px;&quot;&gt;&lt;i class=&quot;fa fa-trash-can&quot;&gt;&lt;/i&gt;&lt;/a&gt;&#039; + text + &#039;&lt;input type=&quot;hidden&quot; name=&quot;propsciu3[]&quot; value=&quot;&#039; + val + &#039;&quot;&gt;&lt;/div&gt;&lt;/li&gt;&#039;);
        $(&#039;#ciu3_&#039; + lang).val(null).trigger(&#039;change&#039;);
    }
});
$(&#039;.ddc3&#039;).nestable({
    group: 1
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/send.php:71
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (!empty($_GET[&#039;propsnews1&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Noticias&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsnews1&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/news-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsnews2&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Noticias&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsnews2&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/news-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsnews3&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Noticias&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsnews3&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/news-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (!empty($_GET[&#039;propsnews1&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Noticias&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsnews1&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/news-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsnews2&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Noticias&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsnews2&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/news-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsnews3&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Noticias&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsnews3&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/news-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsprom1&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Promotions&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsprom1&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/prom-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsprom2&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Promotions&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsprom2&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/prom-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsprom3&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Promotions&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsprom3&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/prom-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsciu1&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Áreas&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsciu1&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/ciu-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsciu2&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Áreas&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsciu2&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/ciu-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}

if (!empty($_GET[&#039;propsciu3&#039;])) {
    // $body .= &#039;&lt;div style=&quot;background: #f6f6f6; margin: 40px -37px -60px -37px; padding: 1px 37px 30px 37px;&quot;&gt;&#039;;
    $body  .= &quot;&lt;h2 style=\&quot;margin: 40px 0;\&quot;&gt;&quot;.$langStr[&quot;Áreas&quot;].&quot;&lt;/h2&gt;&quot;;
    foreach ($_GET[&#039;propsciu3&#039;] as $value) {
        $langVal = $_GET[&#039;lang&#039;];
        $idVal = $value;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/ciu-acumba.php&#039;);
        $body .= ob_get_contents();
        ob_end_clean();
    }
    // $body .= &#039;&lt;/div&gt;&#039;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>