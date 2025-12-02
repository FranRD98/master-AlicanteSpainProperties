<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 05-11-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras Promociones y Habihub</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras Promociones y Habihub
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
CREATE TABLE `queue_developsments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            </code>
        </pre>
        <hr>
        Añadir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/developments-change.php
/intramedianet/promotions/developments-queue.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:34
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php include( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/includes/inc.header.php&#039; ); ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php include( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/includes/inc.header.php&#039; ); ?&gt;

&lt;div class=&quot;alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-triangle-exclamation label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Development-warning&#039;]; ?&gt;
&lt;/div&gt;

&lt;div class=&quot;alert alert-success alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-check label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Development-warning2&#039;]; ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:64
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Titular&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Titular&#039;); ?&gt; Website&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Titular Habihub (Privado)&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Titular Web (P&uacute;blico)&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:66
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;N&ordm; Casas&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;N&ordm; Casas&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Provincia&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:77
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws3&quot; id=&quot;title_en_nws3&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws3&quot; id=&quot;title_en_nws3&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws6&quot; id=&quot;title_en_nws6&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;title_en_nws7&quot; id=&quot;title_en_nws7&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:83
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot;&gt;
    &lt;select name=&quot;activate_nws_sel&quot; id=&quot;activate_nws_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;
&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot;&gt;
    &lt;select name=&quot;activate_nws_sel&quot; id=&quot;activate_nws_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;2&quot;&gt;&lt;?php __(&#039;Procesando&#039;); ?&gt;&lt;/option&gt;
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
/intramedianet/promotions/news.php:95
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td colspan=&quot;7&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td colspan=&quot;9&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:110
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var numCols = 6;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var numCols = 8;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:44
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, &#039;number_prop&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, &#039;number_prop&#039;);
array_push($aColumns, &#039;quick_province_nws&#039;);
array_push($aColumns, &#039;quick_town_nws&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:176
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;S&iacute;&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;1&#039; &quot;;
}
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;No&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;0&#039; &quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;S&iacute;&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;1&#039; &quot;;
}
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, strtolower(__(&#039;No&#039;, true)))) {
    $sWhere .= $aColumns[$i].&quot; = &#039;0&#039; &quot;;
}
if (preg_match(&#039;/&#039;.strtolower($_GET[&#039;sSearch_&#039;.$i]).&#039;/&#039;, 2)) {
    $sWhere .= $aColumns[$i].&quot; = &#039;2&#039; &quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news-data.php:227
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case activate_nws
    when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
    when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as activate_nws,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case activate_nws
    when &#039;2&#039; then &#039;2&#039;
    when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
    when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as activate_nws,
quick_province_nws,
quick_town_nws,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/_js/pages-list.js:57
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var bntImage = data == non ? &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;: &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var bntImage = data == non ? &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;a href=&quot;developments-change.php?s=activate_nws&amp;v=&#039;+changeV+&#039;&amp;id_prop=&#039; +  row[numCols] + &#039;&quot; class=&quot;update-status&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/a&gt;&lt;/div&gt;&#039;: &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;a href=&quot;developments-change.php?s=activate_nws&amp;v=&#039;+changeV+&#039;&amp;id_prop=&#039; +  row[numCols] + &#039;&quot; class=&quot;update-status&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/a&gt;&lt;/div&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/_js/pages-list.js:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&quot;render&quot;: function ( data, type, row ) {
    btns = &#039;&lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;&#039;;
        btns += &#039;&lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;&#039;;
            btns += &#039;&lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;&#039;;
        btns += &#039;&lt;/button&gt;&#039;;
        btns += &#039;&lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;&#039;;
            btns += &#039;&lt;li&gt;&lt;a href=&quot;news-form.php?id_nws=&#039; + data + &#039;&amp;amp;KT_back=1&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + dtEditar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
            if (canDel == 1) {
                btns += &#039;&lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;&#039;;
                btns += &#039;&lt;li&gt;&lt;a href=&quot;news-form.php?id_nws=&#039; + data + &#039;&amp;amp;KT_back=1&amp;amp;KT_Delete1=1&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
            }
        btns += &#039;&lt;/ul&gt;&#039;;
    btns += &#039;&lt;/div&gt;&#039;;
    return  btns;
},
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&quot;render&quot;: function ( data, type, row ) {
    btns = &#039;&#039;;
    if (row[numCols - 1] != non) {
        btns += &#039;&lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;&#039;;
            btns += &#039;&lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;&#039;;
                btns += &#039;&lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;&#039;;
            btns += &#039;&lt;/button&gt;&#039;;
            btns += &#039;&lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;&#039;;
                btns += &#039;&lt;li&gt;&lt;a href=&quot;news-form.php?id_nws=&#039; + data + &#039;&amp;amp;KT_back=1&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + dtEditar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
                if (canDel == 1) {
                    btns += &#039;&lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;&#039;;
                    btns += &#039;&lt;li&gt;&lt;a href=&quot;news-form.php?id_nws=&#039; + data + &#039;&amp;amp;KT_back=1&amp;amp;KT_Delete1=1&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
                }
            btns += &#039;&lt;/ul&gt;&#039;;
        btns += &#039;&lt;/div&gt;&#039;;
    }
    return  btns;
},
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/noticia.tpl:16
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https&quot; subject=$resource.img}
    {imagesize src=&quot;{$resource.img}&quot; width=590 height=355 class=&#039;img-fluid w-100&#039; alt=&quot;{$altt}&quot; title=&quot;{$altt}&quot; path=&quot;/media/images/news/&quot; }
{else}
    {assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$resource.img}&quot;}
    {imagesize src=&quot;{$imgProp}&quot; width=590 height=355 class=&#039;img-fluid w-100&#039; alt=&quot;{$altt}&quot; title=&quot;{$altt}&quot; }
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $resource.img|regex_replace:&#039;/https?/&#039;:&#039;&#039; != $resource.img}
    {imagesize src=&quot;{$resource.img}&quot; width=590 height=355 class=&#039;img-fluid w-100&#039; alt=&quot;{$altt}&quot; title=&quot;{$altt}&quot; path=&quot;/media/images/news/&quot; }
{else}
    {assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$resource.img}&quot;}
    {imagesize src=&quot;{$imgProp}&quot; width=590 height=355 class=&#039;img-fluid w-100&#039; alt=&quot;{$altt}&quot; title=&quot;{$altt}&quot; }
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/main-img.tpl:24
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$resource.img}
    {assign var=&quot;imgProp&quot; value=&quot;{$news[0].img}&quot;}
{else}
    {assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$news[0].img}&quot;}
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $news[0].img|regex_replace:&#039;/https?/&#039;:&#039;&#039; != $news[0].img}
    {assign var=&quot;imgProp&quot; value=&quot;{$news[0].img}&quot;}
{else}
    {assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$news[0].img}&quot;}
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/tab-photos.tpl:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$images[img].image_img}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&quot;&quot; path=&quot;/media/images/news/&quot;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;https://{$smarty.server.HTTP_HOST}/{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800 path=&quot;/media/images/news/&quot; }&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $images[img].image_img|regex_replace:&#039;/https?/&#039;:&#039;&#039; != $images[img].image_img}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&quot;&quot; path=&quot;/media/images/news/&quot;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;https://{$smarty.server.HTTP_HOST}/{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800 path=&quot;/media/images/news/&quot; }&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/tab-photos.tpl:46
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$images[img].image_img}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&quot;&quot; path=&quot;/media/images/news/&quot;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;https://{$smarty.server.HTTP_HOST}/{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800 path=&quot;/media/images/news/&quot; }&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $images[img].image_img|regex_replace:&#039;/https?/&#039;:&#039;&#039; != $images[img].image_img}
    {assign var=&quot;linkImgSrc&quot; value=&quot;{imagesize2 src=&quot;{$images[img].image_img}&quot; width=1200 height=800 class=&quot;&quot; path=&quot;/media/images/news/&quot;}&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;{$images[img].image_img}&quot;}
{else}
    {assign var=&quot;linkImgSrc&quot; value=&quot;https://{$smarty.server.HTTP_HOST}/{imagesize2 src=&quot;/media/images/news/{$images[img].image_img}&quot; width=1200 height=800 path=&quot;/media/images/news/&quot; }&quot;}
    {assign var=&quot;linkImg&quot; value=&quot;/media/images/news/{$images[img].image_img}&quot; }
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/modal-gallery.tpl:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if preg_match pattern=&quot;https?&quot; subject=$images[img].image_img}
    &lt;img src=&quot;{$images[img].image_img}&quot; class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;
{else}
    &lt;img src=&quot;/media/images/news/{$images[img].image_img}&quot; class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $images[img].image_img|regex_replace:&#039;/https?/&#039;:&#039;&#039; != $images[img].image_img}
    &lt;img src=&quot;{$images[img].image_img}&quot; class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;
{else}
    &lt;img src=&quot;/media/images/news/{$images[img].image_img}&quot; class=&#039;img-fluid w-100&#039; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Users/jose/Webs/_Master/public_html/intramedianet/xml/importadores/_utils_habihub.php:245
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// TAGS
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
// TAGS
$query = &quot;DELETE FROM promotions_promotions_tag WHERE promotion = &#039;&quot;.$promotionID.&quot;&#039;&quot;;
mysqli_query($inmoconn,$query) or die(mysqli_error());
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
$lang[&#039;Titular Habihub (Privado)&#039;] = &#039;Titular Habihub (Privado)&#039;;
$lang[&#039;Titular Web (P&uacute;blico)&#039;] = &#039;Titular Web (P&uacute;blico)&#039;;
$lang[&#039;Development-warning&#039;] = &#039;&lt;strong&gt;La publicaci&oacute;n del proyecto en la web no es inmediata&lt;/strong&gt;: se a&ntilde;ade a una cola de generaci&oacute;n.&lt;br&gt;Si hay muchas unidades o im&aacute;genes pesadas, &lt;strong&gt;tardar&aacute; m&aacute;s tiempo.&lt;/strong&gt;&lt;br&gt;&lt;strong&gt;No vuelvas a activarlo ni a editarlo&lt;/strong&gt; durante el proceso.&lt;br&gt;Cuando est&eacute; activo, aparecer&aacute; un nuevo bot&oacute;n a la derecha de la casilla de activaci&oacute;n.&#039;;
$lang[&#039;Development-warning2&#039;] = &#039;Una vez que el proyecto est&eacute; activo en el CRM, &lt;strong&gt;debes ir a la web p&uacute;blica&lt;/strong&gt; y hacer clic sobre &eacute;l para que se genere la p&aacute;gina del proyecto.&#039;;
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
$lang[&#039;Titular Habihub (Privado)&#039;][&#039;en&#039;] = &#039;Habihub Owner (Private)&#039;;
$lang[&#039;Titular Web (P&uacute;blico)&#039;][&#039;en&#039;] = &#039;Website Owner (Public)&#039;;
$lang[&#039;Development-warning&#039;] = &#039;&lt;strong&gt;Project publication on the website is not immediate&lt;/strong&gt;: it is added to a generation queue.&lt;br&gt;If there are many units or heavy images, &lt;strong&gt;it will take longer.&lt;/strong&gt;&lt;br&gt;&lt;strong&gt;Do not re-activate or edit&lt;/strong&gt; during the process.&lt;br&gt;When it&rsquo;s active, a new button will appear to the right of the activation checkbox.&#039;;
$lang[&#039;Development-warning2&#039;] = &#039;Once the project is active in the CRM, &lt;strong&gt;you must go to the public website&lt;/strong&gt; and click on it so that the project page is generated.&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>