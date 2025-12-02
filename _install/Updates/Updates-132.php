<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 30-10-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes Habihub</a></li>¡
        <li><a href="#sec34"><i class="fas fz-fw fa-plus-circle text-success"></i> XXXXXXXXXXXXXXXXXXXXX</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes Habihub
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/new.php:293
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$title = $news[0][&#039;titulo&#039;];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$title = $news[0][&#039;titulo_prom&#039;];
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/modal-gallery.tpl:11
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;span&gt;{$news[0].titulo}&lt;/span&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $news[0].titulo_prom != &#039;&#039;}
    &lt;span&gt;{$news[0].titulo_prom}&lt;/span&gt;
{else}
    &lt;span&gt;{$news[0].titulo}&lt;/span&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/noticia.tpl:1
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{assign var=&quot;link&quot; value=&quot;{$urlStart}{$url_promociones}/{$resource.id_nws}/{$resource.titulo|slug}/&quot;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $resource.titulo_prom != &#039;&#039;}
    {assign var=&quot;link&quot; value=&quot;{$urlStart}{$url_promociones}/{$resource.id_nws}/{$resource.titulo_prom|slug}/&quot;}
{else}
    {assign var=&quot;link&quot; value=&quot;{$urlStart}{$url_promociones}/{$resource.id_nws}/{$resource.titulo|slug}/&quot;}
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php:117
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query .= &quot;type_pro = 3, &quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query .= &quot;type_pro = 3, &quot;;
$query .= &quot;fecha_alta_pro = &#039;&quot; . date(&quot;Y-m-d H:i:s&quot;) . &quot;&#039;, &quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php:181
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;$value)).&quot;&#039;, \n&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:122
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (!$in_database || $proveedor[&#039;up_descripcion_xml&#039;] == 1)
{
   foreach($allLanguages as $value)
   {
       if ($value == &#039;se&#039;) {
           if ((string)$property-&gt;desc-&gt;sv != &#039;&#039;) {
                $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;metadescription-&gt;sv != &#039;&#039;) {
                $query .= &quot;description_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ($property-&gt;seo-&gt;h1-&gt;sv != &#039;&#039;) {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ($property-&gt;seo-&gt;title-&gt;sv != &#039;&#039;) {
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
           }
       } else {
           if ((string)$property-&gt;desc-&gt;$value != &#039;&#039;) {
                $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;metadescription-&gt;$value != &#039;&#039;) {
                $query .= &quot;description_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;h1-&gt;$value != &#039;&#039;) {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;title-&gt;$value != &#039;&#039;) {
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
           }
       }
   }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (!$in_database || $proveedor[&#039;up_descripcion_xml&#039;] == 1)
{
   foreach($allLanguages as $value)
   {
       if ($value == &#039;se&#039;) {
           if ((string)$property-&gt;desc-&gt;sv != &#039;&#039;) {
                $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;metadescription-&gt;sv != &#039;&#039;) {
                $query .= &quot;description_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ($property-&gt;seo-&gt;h1-&gt;sv != &#039;&#039;) {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;sv)).&quot;&#039;, \n&quot;;
           } else {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
           }
           if ($property-&gt;seo-&gt;title-&gt;sv != &#039;&#039;) {
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
           }
       } else {
           if ((string)$property-&gt;desc-&gt;$value != &#039;&#039;) {
                $query .= &quot;descripcion_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;metadescription-&gt;$value != &#039;&#039;) {
                $query .= &quot;description_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;h1-&gt;$value != &#039;&#039;) {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;$value)).&quot;&#039;, \n&quot;;
           } else {
                $query .= &quot;titulo_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;$value)).&quot;&#039;, \n&quot;;
           }
           if ((string)$property-&gt;seo-&gt;title-&gt;$value != &#039;&#039;) {
                $query .= &quot;title_&quot;.$value.&quot;_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;$value)).&quot;&#039;, \n&quot;;
           }
       }
   }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/urls.php:314
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&#039;en&#039; =&gt; &quot;promotions&quot;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&#039;en&#039; =&gt; &quot;developments&quot;,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php:370
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Promotions&quot;] = &quot;Promotions&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Promotions&quot;] = &quot;Developments&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php:392
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Featured promotion&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Featured development&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php:412
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;We want you to have all the information about how the sale of your property is progressing.&lt;br&gt;In this report, you can see how many people have viewed your listing, how many have shown interest, and how the promotion is performing.&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;We want you to have all the information about how the sale of your property is progressing.&lt;br&gt;In this report, you can see how many people have viewed your listing, how many have shown interest, and how the development is performing.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php:447
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Promociones destacadas&quot;][&quot;en&quot;] = &quot;Featured promotions&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;en&quot;] = &quot;View all promotions&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Promociones destacadas&quot;][&quot;en&quot;] = &quot;Featured developments&quot;;
$langStr[&quot;Ver todas las promociones&quot;][&quot;en&quot;] = &quot;View all developments&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>