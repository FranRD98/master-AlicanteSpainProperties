<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 17-01-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error al subir imágenes, introducido por cambios exportador Rightmove y Zoopla</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error al borrar imágenes, introducido por cambios exportador Rightmove y Zoopla</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO HREFLANG</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Error formulario vender propiedad</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al subir imágenes, introducido por cambios exportador Rightmove y Zoopla
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_upload.php:156
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsMax =&quot;SELECT MAX(order_img) + 1  as max, property_img FROM properties_images WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMax = mysql_query($query_rsMax, $inmoconn) or die (mysql_error());
$row_rsMax = mysql_fetch_assoc($rsMax);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$row_rsMax[&#039;property_img&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn)
or die(mysql_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsMax =&quot;SELECT MAX(order_img) + 1  as max FROM properties_images WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMax = mysql_query($query_rsMax, $inmoconn) or die (mysql_error());
$row_rsMax = mysql_fetch_assoc($rsMax);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$_GET[&#039;id_prop&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn)
or die(mysql_error());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al borrar imágenes, introducido por cambios exportador Rightmove y Zoopla
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_del.php:52
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;SELECT * FROM `properties_images` WHERE property_img = &quot;.$prop.&quot; ORDER BY order_img ASC&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
$row_rsImagenes = mysql_fetch_assoc($rsImagenes);
$totalRows_rsImagenes = mysql_num_rows($rsImagenes);

do {
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsUpdate1 = &quot;UPDATE `properties_images` SET `order_img` = &#039;&quot;.$ord++.&quot;&#039; WHERE `id_img` = &quot;.$row_rsImagenes[&#039;id_img&#039;].&quot;&quot;;
    $rsUpdate1 = mysql_query($query_rsUpdate1, $inmoconn) or die(mysql_error());
} while ($row_rsImagenes = mysql_fetch_assoc($rsImagenes));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;SELECT * FROM `properties_images` WHERE property_img = &quot;.$prop.&quot; ORDER BY order_img ASC&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
$totalRows_rsImagenes = mysql_num_rows($rsImagenes);

while ($row_rsImagenes = mysql_fetch_assoc($rsImagenes)) {
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsUpdate1 = &quot;UPDATE `properties_images` SET `order_img` = &#039;&quot;.$ord++.&quot;&#039; WHERE `id_img` = &quot;.$row_rsImagenes[&#039;id_img&#039;].&quot;&quot;;
    $rsUpdate1 = mysql_query($query_rsUpdate1, $inmoconn) or die(mysql_error());
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO HREFLANG
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
        Por:
        <pre>
            <code class="php">
&lt;!-- SEO
================================================== --&gt;
{if count($languages) &gt; 1}
   {foreach from=$languages item=idm}
       {if $idm != $language}{* // SI NO ES EL IDIOMA PRINCIPAL // *}
           {assign var=&quot;alternateURL&quot; value={$url{$idm|upper}|replace:&#039;http:&#039;:&#039;https:&#039;} }
           {* // SI NO DISPONE DE TRADUCCI&Oacute;N // *}
           {if ($seccion != &quot;&quot; &amp;&amp; {$alternateURL} == &quot;https://{$smarty.server.HTTP_HOST}/{$idm}/&quot;) || {$alternateURL} == &quot;&quot; || {$alternateURL} == &quot;https://{$smarty.server.HTTP_HOST}/{$idm}/{$seccion_lang[$idm]}/&quot; }
               {assign var=&quot;alternateURL&quot; value=&quot;&quot; }
           {/if}
       {else if {$urlDefault} != &quot;&quot; &amp;&amp; {$urlDefault|replace:&#039;http:&#039;:&#039;https:&#039;} != &quot;https://{$smarty.server.HTTP_HOST}/{$seccion_lang[$idm]}/&quot; } {* // SI ES EL IDIOMA PRINCIPAL Y DISPONE DE TRADUCCI&Oacute;N // *}
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

<div class="card">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error formulario vender propiedad
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/vender/send-quote.php:26
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
INSERT INTO `prop_user`(`id_prp`, `name_prp`, `email_prp`, `phone_prp`, `estado_prp`, `tipo_prp`, `pais_prp`, `provincia_prp`, `ciudad_prp`, `zona_prp`, `direccion_prp`, `cp_prp`, `habitaciones_prp`, `banos_prp`, `piscina_prp`, `tiempo_prp`, `m2_prp`, `m2p_prp`, `precio_prp`, `consulta_prp`, `fecha_prp`) VALUES

(NULL,&#039;&quot;.simpleSanitize(($_GET[&#039;name&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;email&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;telefono&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;sts&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;Type&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;locun2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lopr2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;loct2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lozn2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;address&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;zip&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bd&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bt&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;pool&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;timing&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2p&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;price&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;comment&#039;])).&quot;&#039;,&#039;&quot;.mysql_real_escape_string(date(&quot;Y-m-d H:i:s&quot;)).&quot;&#039;)
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
INSERT INTO `prop_user`(`id_prp`, `name_prp`, `email_prp`, `phone_prp`, `estado_prp`, `tipo_prp`, `pais_prp`, `provincia_prp`, `ciudad_prp`, `zona_prp`, `direccion_prp`, `cp_prp`, `habitaciones_prp`, `banos_prp`, `piscina_prp`, `m2_prp`, `m2p_prp`, `precio_prp`, `consulta_prp`, `fecha_prp`) VALUES

(NULL,&#039;&quot;.simpleSanitize(($_GET[&#039;name&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;email&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;telefono&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;sts&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;Type&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;locun2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lopr2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;loct2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lozn2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;address&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;zip&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bd&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bt&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;pool&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2p&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;price&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;comment&#039;])).&quot;&#039;,&#039;&quot;.mysql_real_escape_string(date(&quot;Y-m-d H:i:s&quot;)).&quot;&#039;)
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>