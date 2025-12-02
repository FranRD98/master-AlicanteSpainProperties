<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 07-01-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Mejora 404</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error Whatsapp</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Error al exportar PRIAN</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> No dejar borrar un proveedor de xml al tener inmuebles</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador de Mimove</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora 404
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:855
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
header($_SERVER[&quot;SERVER_PROTOCOL&quot;].&quot; 404 Not Found&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$urlFullList = array();
foreach ($urlStr as $u =&gt; $l) {
    foreach ($l as $ll =&gt; $uu) {
        if($ll != &quot;master&quot; &amp;&amp; $uu != &quot;&quot;){
            $urlFullList[$uu] = $l;
        }
    }
}
if(  isset($urlFullList[$seccion][$lang]) ) {
    header(&quot;HTTP/1.1 301 Moved Permanently&quot;);
    header(&quot;Location: &quot;.$urlStart.&quot;&quot; . $urlFullList[$seccion][$lang].&quot;/&quot;);
    exit;
}

header($_SERVER[&quot;SERVER_PROTOCOL&quot;].&quot; 404 Not Found&quot;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:35
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;!-- SEO
================================================== --&gt;
{if count($languages) &gt; 1}
    {foreach from=$languages item=idm}
        {if $idm != $language}
            {if {$url{$idm|upper}} != &quot;&quot; &amp;&amp; {$url{$idm|upper}} != &quot;https://{$smarty.server.HTTP_HOST}/{$idm}/{$seccion_lang[$idm]}/&quot; &amp;&amp; {$url{$idm|upper}} != &quot;http://{$smarty.server.HTTP_HOST}/{$idm}/{$seccion_lang[$idm]}/&quot;  }
            &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{if {preg_match pattern=&#039;http&#039; subject={$url{$idm|upper}}}}{{$url{$idm|upper}}|replace:&#039;http:&#039;:&#039;https:&#039;}{else}https://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}{/if}&quot; /&gt;
            {/if}
        {else}
            {if {$urlDefault} != &quot;&quot; }
                &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{if {preg_match pattern=&#039;http&#039; subject=$urlDefault}}{$urlDefault|replace:&#039;http:&#039;:&#039;https:&#039;}{else}https://{$smarty.server.HTTP_HOST}{$urlDefault|replace:&#039;http:&#039;:&#039;https:&#039;}{/if}&quot; /&gt;
            {/if}
        {/if}
    {/foreach}
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;!-- SEO
================================================== --&gt;
{if count($languages) &gt; 1}
    {foreach from=$languages item=idm}
        {if $idm != $language}{* // SI NO ES EL DOMINIO PRINCIPAL // *}
            {assign var=&quot;alternateURL&quot; value={$url{$idm|upper}|replace:&#039;http:&#039;:&#039;https:&#039;} }
            {* // SI NO DISPONE DE TRADUCCI&Oacute;N // *}
            {if ($seccion != &quot;&quot; &amp;&amp; {$alternateURL} == &quot;https://{$smarty.server.HTTP_HOST}/{$idm}/&quot;) || {$alternateURL} == &quot;&quot; || {$alternateURL} == &quot;https://{$smarty.server.HTTP_HOST}/{$idm}/{$seccion_lang[$idm]}/&quot; }
                {assign var=&quot;alternateURL&quot; value=&quot;&quot; }
            {/if}
        {else if {$urlDefault} != &quot;&quot; } {* // SI ES EL IDIOMA PRINCIPAL // *}
            {assign var=&quot;alternateURL&quot; value={$urlDefault}|replace:&#039;http:&#039;:&#039;https:&#039;}
        {/if}
        {* // SI LA URL ES CORRECT Y NO TIENE EL DOMINIO, SE LO A&Ntilde;ADIMOS // *}
        {if {$alternateURL} != &quot;&quot; &amp;&amp; !{preg_match pattern=&#039;http&#039; subject=$alternateURL} }
            {assign var=&quot;alternateURL&quot; value=&quot;https://{$smarty.server.HTTP_HOST}{$alternateURL}&quot; }
        {/if}
        {if {$alternateURL} != &quot;&quot; } {* // SI DISPONE DE TRADUCCI&Oacute;N A&Ntilde;ADIMOS EL HREFLANG // *}
            &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{$alternateURL}&quot; /&gt;
        {/if}
    {/foreach}
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error Whatsapp
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/barra-responsiva.tpl:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a target=&quot;_blank&quot; href=&quot;https://wa.me/{$phoneRespBar}/&quot;|escape:&#039;url&#039;}&quot;&gt;&lt;i class=&quot;fab fa-whatsapp&quot;&gt;&lt;/i&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a target=&quot;_blank&quot; href=&quot;https://wa.me/{$phoneRespBar}/?text={&quot;&quot;|escape:&#039;url&#039;}&quot;&gt;&lt;i class=&quot;fab fa-whatsapp&quot;&gt;&lt;/i&gt;&lt;/a&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al exportar PRIAN
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/prian.php:239
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($row_rsprian[&#039;operacion_prop&#039;] == 1 &amp;&amp; $row_rsprian[&#039;operacion_prop&#039;] == 2) { ?&gt;
&lt;price&gt;&lt;?php echo number_format($row_rsprian[&#039;pr&#039;],0,&#039;&#039;,&#039;&#039;) ?&gt;&lt;/price&gt;
&lt;?php } else { ?&gt;
&lt;price&gt;&lt;/price&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($row_rsprian[&#039;operacion_prop&#039;] == 1 &amp;&amp; $row_rsprian[&#039;operacion_prop&#039;] == 2) { ?&gt;
      &lt;price&gt;&lt;?php echo number_format($row_rsprian[&#039;pr&#039;],0,&#039;&#039;,&#039;&#039;) ?&gt;&lt;/price&gt;
&lt;?php } else { ?&gt;
      &lt;price&gt;&lt;?php echo number_format($row_rsprian[&#039;pr&#039;],0,&#039;&#039;,&#039;&#039;) ?&gt;&lt;/price&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> No dejar borrar un proveedor de xml al tener inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores-form.php:100
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// End trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&amp;$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj-&gt;setTable(&quot;properties_properties&quot;);
  $tblFldObj-&gt;setFieldName(&quot;xml_xml_prop&quot;);
  $tblFldObj-&gt;setErrorMsg(__(&#039;No se puede borrar, hay inmuebles que usan este registro&#039;, true));
  return $tblFldObj-&gt;Execute();
}
//end Trigger_CheckDetail trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores-form.php:177
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$del_xml-&gt;registerTrigger(&quot;END&quot;, &quot;Trigger_Default_Redirect&quot;, 99, &quot;../../includes/nxt/back.php&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$del_xml-&gt;registerTrigger(&quot;END&quot;, &quot;Trigger_Default_Redirect&quot;, 99, &quot;../../includes/nxt/back.php&quot;);
$del_xml-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_CheckDetail&quot;, 40);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card ">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador de Mimove
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties`
ADD `export_mimove_prop` INT(1) NULL DEFAULT &#039;0&#039; AFTER `export_kyero_prop`,
ADD `export_mimove_type_prop` VARCHAR(255) NULL DEFAULT NULL AFTER `export_mimove_prop`,
ADD `export_mimove_parking_prop` VARCHAR(255) NULL DEFAULT NULL AFTER `export_mimove_type_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:37
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$expYaencontre= 0;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$expYaencontre= 0;
$expMimove= 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:868
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expKyero == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_kyero_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_kyero_prop&quot;, &quot;0&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expKyero == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_kyero_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_kyero_prop&quot;, &quot;0&quot;);
}
if ($expMimove == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_mimove_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mimove_prop&quot;, &quot;0&quot;);
$ins_properties_properties-&gt;addColumn(&quot;export_mimove_type_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_mimove_type_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;export_mimove_parking_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_mimove_parking_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1067
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expKyero == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_kyero_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_kyero_prop&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expKyero == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_kyero_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_kyero_prop&quot;);
}
if ($expMimove == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_mimove_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mimove_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;export_mimove_type_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_mimove_type_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;export_mimove_parking_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_mimove_parking_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3777
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;checkbox&quot; &lt;?php if ($expMimove == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
            &lt;label&gt;
            &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_mimove_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;export_mimove_prop&quot; id=&quot;export_mimove_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expMimove == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
            &lt;?php __(&#039;Exportar a Mimove&#039;); ?&gt;
            &lt;/label&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_mimove_prop&quot;); ?&gt;
            &lt;hr&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-3&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_mimove_type_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot; &lt;?php if ($expMimove == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
            &lt;label for=&quot;export_mimove_type_prop&quot;&gt;&lt;?php __(&#039;Tipo de propiedad&#039;); ?&gt; &lt;small&gt;(&lt;?php __(&#039;Requerido para Mimove&#039;); ?&gt;)&lt;/small&gt;:&lt;/label&gt;
            &lt;div class=&quot;controls&quot;&gt;
                &lt;select name=&quot;export_mimove_type_prop&quot; id=&quot;export_mimove_type_prop&quot; class=&quot;form-control&quot; &lt;?php if ($expMimove == 0) { ?&gt;disabled&lt;?php } ?&gt;&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;export_mimove_type_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;apartment&quot;, $row_rsproperties_properties[&#039;export_mimove_type_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;apartment&quot;&gt;&lt;?php __(&#039;Apartment&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;finca&quot;, $row_rsproperties_properties[&#039;export_mimove_type_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;finca&quot;&gt;&lt;?php __(&#039;Finca&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;penthouse&quot;, $row_rsproperties_properties[&#039;export_mimove_type_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;penthouse&quot;&gt;&lt;?php __(&#039;Penthouse&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;plot&quot;, $row_rsproperties_properties[&#039;export_mimove_type_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;plot&quot;&gt;&lt;?php __(&#039;Plot&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;townhouse&quot;, $row_rsproperties_properties[&#039;export_mimove_type_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;townhouse&quot;&gt;&lt;?php __(&#039;Townhouse&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;villa&quot;, $row_rsproperties_properties[&#039;export_mimove_type_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;villa&quot;&gt;&lt;?php __(&#039;Villa&#039;); ?&gt;&lt;/option&gt;
                &lt;/select&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-3&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_mimove_parking_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot; &lt;?php if ($expMimove == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
            &lt;label for=&quot;export_mimove_parking_prop&quot;&gt;&lt;?php __(&#039;Tipo de Garaje&#039;); ?&gt; &lt;small&gt;(&lt;?php __(&#039;Opcional para Mimove&#039;); ?&gt;)&lt;/small&gt;:&lt;/label&gt;
            &lt;div class=&quot;controls&quot;&gt;
                &lt;select name=&quot;export_mimove_parking_prop&quot; id=&quot;export_mimove_parking_prop&quot; class=&quot;form-control&quot; &lt;?php if ($expMimove == 0) { ?&gt;disabled&lt;?php } ?&gt;&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;&quot;, $row_rsproperties_properties[&#039;export_mimove_parking_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;garage&quot;, $row_rsproperties_properties[&#039;export_mimove_parking_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;garage&quot;&gt;&lt;?php __(&#039;Garage&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;street&quot;, $row_rsproperties_properties[&#039;export_mimove_parking_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;street&quot;&gt;&lt;?php __(&#039;Street&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;carport&quot;, $row_rsproperties_properties[&#039;export_mimove_parking_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;carport&quot;&gt;&lt;?php __(&#039;Carport&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;private_land&quot;, $row_rsproperties_properties[&#039;export_mimove_parking_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;private_land&quot;&gt;&lt;?php __(&#039;Private Land&#039;); ?&gt;&lt;/option&gt;
                    &lt;option &lt;?php if (!(strcmp(&quot;community_parking&quot;, $row_rsproperties_properties[&#039;export_mimove_parking_prop&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt; value=&quot;community_parking&quot;&gt;&lt;?php __(&#039;Community Parking&#039;); ?&gt;&lt;/option&gt;
                &lt;/select&gt;
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
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Opcional para Mimove&#039;] = &#039;Opcional para Mimove&#039;;
$lang[&#039;Exportar a Mimove&#039;] = &#039;Exportar a Mimove&#039;;
$lang[&#039;Requerido para Mimove&#039;] = &#039;Requerido para Mimove&#039;;
$lang[&#039;Tipo de propiedad&#039;] = &#039;Tipo de propiedad&#039;;
$lang[&#039;Tipo de Garaje&#039;] = &#039;Tipo de Garaje&#039;;
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
$lang[&#039;Opcional para Mimove&#039;] = &#039;Mimove optional&#039;;
$lang[&#039;Exportar a Mimove&#039;] = &#039;Export to Mimove&#039;;
$lang[&#039;Requerido para Mimove&#039;] = &#039;Mimove required&#039;;
$lang[&#039;Tipo de propiedad&#039;] = &#039;Property Type&#039;;
$lang[&#039;Tipo de Garaje&#039;] = &#039;Garage Type&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1 || $expTodoPisoAlicante == 1 || $expYaencontre == 1): ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1 || $expTodoPisoAlicante == 1 || $expYaencontre == 1 || $expMimove == 1): ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php:105
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
&lt;?php if ($expMimove == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/mimove.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/mimove.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/xml/mimove.php</code> de esta versión.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>