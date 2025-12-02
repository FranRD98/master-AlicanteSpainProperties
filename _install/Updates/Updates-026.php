<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 22 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 07-08-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error codificación en el listado de propietarios</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error en la etiqueta Hreflang del header</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error en los enlaces de los quicklinks del sitemap</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-plus-circle text-success"></i> Multipáginas: Permita cargar varias IDs de páginas a la vez dentro de una página</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> En el panel los botones de descarga de imagenes no están traducidos</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Ajuste en el exportador de Zoopla para mandar el archivo como binario</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Consultas de inmuebles pasar el select de cliente a ajax</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> Las tareas caducadas no muestra el warning</a></li>
        <li><a href="#nueve"><i class="fas fz-fw fa-bug text-danger"></i> Solución error en los dropdowns de los tablets en horizontal</a></li>
        <li><a href="#diez"><i class="fas fz-fw fa-bug text-danger"></i> Texto conversor divisas</a></li>
        <li><a href="#once"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al cambiar de idiomas en los quicklinks</a></li>
        <li><a href="#doce"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido botón borrar todas las imágenes en imágenes e imágenes privadas</a></li>
        <li><a href="#trece"><i class="fas fz-fw fa-bug text-danger"></i> Cambio texto email bajada de precio de una propiedad</a></li>
        <li><a href="#catorce"><i class="fas fz-fw fa-bug text-danger"></i> Error de codificación del desplegable de tipos en el buscador avanzado</a></li>
        <li><a href="#quince"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al guardar un inmueble cuando no se activa Fotocasa</a></li>
        <li><a href="#dieciseis"><i class="fas fz-fw fa-bug text-danger"></i> Mejora en la generación de miniaturas de inmuebles importados, primero se bajan la principal y despues el resto</a></li>
        <li><a href="#diecisiete"><i class="fas fz-fw fa-bug text-danger"></i> El cambio de idiomas de zonas no funciona</a></li>
        <li><a href="#dieciocho"><i class="fas fz-fw fa-bug text-danger"></i> Añadido inmueble de la consulta a email inmuebles similares</a></li>
        <li><a href="#diecinueve"><i class="fas fz-fw fa-bug text-danger"></i> xxxxxxxxxxxxxxxxxxxxx</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error codificación en el listado de propietarios
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-owner-data.php:307
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$row[] = utf8_encode($aRow[ $aColumns[$i] ]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$row[] = $aRow[ $aColumns[$i] ];
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en la etiqueta Hreflang del header
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/En templates/header.tpl:43
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $idm != $language}
&lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href={$smarty.server.REQUEST_SCHEME}&quot;://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}&quot; /&gt;
{else}
&lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{$smarty.server.REQUEST_SCHEME}&quot;://{$smarty.server.HTTP_HOST}{$urlDefault}&quot; /&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $idm != $language}
&lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{$smarty.server.REQUEST_SCHEME}://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}&quot; /&gt;
{else}
&lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{$smarty.server.REQUEST_SCHEME}://{$smarty.server.HTTP_HOST}{$urlDefault}&quot; /&gt;
{/if}
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en los enlaces de los quicklinks del sitemap
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/sitemap/view/index.tpl:21
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;/{$quicklinks2[nw].titulo|slug}.html&quot;&gt;{$quicklinks2[nw].titulo}&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;{$urlStart}{$quicklinks2[nw].titulo|slug}.html&quot;&gt;{$quicklinks2[nw].titulo}&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/sitemap/view/index.tpl:29
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;/{$langingPages2[nw].titulo|slug}.html&quot;&gt;{$langingPages2[nw].titulo}&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;{$urlStart}{$langingPages2[nw].titulo|slug}.html&quot;&gt;{$langingPages2[nw].titulo}&lt;/a&gt;&lt;/li&gt;
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
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Multipáginas: Permita cargar varias IDs de páginas a la vez dentro de una página
    </h6>
    <div class="card-body">
        Sustituir el archivo <code>/modules/pages/pages.php</code> por el de esta versión<hr>
        Ejemplo:<br>
        <pre>
            <code class="php">
case $urlStr[&#039;services&#039;][&#039;url&#039;]:
$numpag = &quot;96,97,98,99,100&rdquo;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> En el panel los botones de descarga de imagenes no están traducidos
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Download selected images&#039;] = &#039;Download selected images&#039;;
$lang[&#039;Download all images&#039;] = &#039;Download all images&#039;;
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
$lang[&#039;Download selected images&#039;] = &#039;Descargar im&aacute;genes seleccionadas&#039;;
$lang[&#039;Download all images&#039;] = &#039;Descargar todas las im&aacute;genes&#039;;
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
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajuste en el exportador de Zoopla para mandar el archivo como binario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/zoopla.php:258
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($ftp-&gt;put($zooplaAgentRef.&quot;_&quot;.date(&quot;Y&quot;).&quot;&quot;.date(&quot;m&quot;).&quot;&quot;.date(&quot;d&quot;).&quot;01.zip&quot;, $zooplaAgentRef.&quot;_&quot;.date(&quot;Y&quot;).&quot;&quot;.date(&quot;m&quot;).&quot;&quot;.date(&quot;d&quot;).&quot;01.zip&quot;)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($ftp-&gt;put($zooplaAgentRef.&quot;_&quot;.date(&quot;Y&quot;).&quot;&quot;.date(&quot;m&quot;).&quot;&quot;.date(&quot;d&quot;).&quot;01.zip&quot;, $zooplaAgentRef.&quot;_&quot;.date(&quot;Y&quot;).&quot;&quot;.date(&quot;m&quot;).&quot;&quot;.date(&quot;d&quot;).&quot;01.zip&quot;, FTP_BINARY)) {
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
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Consultas de inmuebles pasar el select de cliente a ajax
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/enquiries-form.php:179
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;select name=&quot;client_cons&quot; id=&quot;client_cons&quot; class=&quot;form-control select2&quot;&gt;
    &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
    &lt;?php
    do {
    ?&gt;
    &lt;option value=&quot;&lt;?php echo $row_rsClientes [&#039;id_cli&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsClientes [&#039;id_cli&#039;], $row_rsproperties_enquiries[&#039;client_cons&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsClientes [&#039;nombre_cli&#039;]?&gt; &lt;?php echo $row_rsClientes [&#039;apellidos_cli&#039;]?&gt;&lt;/option&gt;
    &lt;?php
    } while ($row_rsClientes  = mysql_fetch_assoc($rsClientes ));
      $rows = mysql_num_rows($rsClientes );
      if($rows &gt; 0) {
          mysql_data_seek($rsClientes , 0);
        $row_rsClientes  = mysql_fetch_assoc($rsClientes );
      }
    ?&gt;
&lt;/select&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; class=&quot;form-control select2clientes&quot; id=&quot;client_cons&quot; name=&quot;client_cons&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/enquiries-form.php:289
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script src=&quot;_js/enquiries-form.js&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script src=&quot;_js/enquiries-form.js&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
&lt;script type=&quot;text/javascript&quot;&gt;
    $(&#039;.select2clientes&#039;).select2({
      ajax: {
        url: function (params) {
            return &#039;/intramedianet/properties/properties-buyers-select.php?q=&#039; + params;
        },
        dataType: &#039;json&#039;,
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        cache: true,
        },
        placeholder: &#039;&#039;,
        minimumInputLength: 3,
    });
&lt;/script&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Las tareas caducadas no muestra el warning
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:525
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sWhere = &#039; WHERE DATE(date_due_tsk) &lt;= CURRENT_DATE() AND status_tsk != 2 &#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$sWhere = &#039; WHERE DATE(date_due_tsk) &lt;= CURRENT_DATE() AND status_tsk != 2 OR status_tsk IS NULL&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="nueve">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Solución error en los dropdowns de los tablets en horizontal
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:52
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#main-nav [data-toggle=&quot;dropdown&quot;], #footer [data-toggle=&quot;dropdown&quot;]&#039;).bootstrapDropdownHover();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (!(&quot;ontouchstart&quot; in document.documentElement)) {
    $(&#039;#main-nav [data-toggle=&quot;dropdown&quot;]:not(.idiomas-drop), #footer [data-toggle=&quot;dropdown&quot;]&#039;).bootstrapDropdownHover();
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="diez">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-bug text-danger"></i> Texto conversor divisas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tab-economia.tpl:1
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-12&quot;&gt;
        &lt;p class=&quot;mb-3&quot;&gt;&lt;small&gt;{$lng_texto_conversor_divisas}&lt;/small&gt;&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;row&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_da.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;Denne information givet her er genstand for fejl og udg&oslash;r ikke en del af nogen kontrakt. Tilbuddet kan &aelig;ndres eller tilbagekaldes uden varsel. Priserne inkluderer ikke k&oslash;bsomkostninger.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_de.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;Diese hier angegebenen Informationen unterliegen Fehlern und sind nicht Bestandteil eines Vertrages. Das Angebot kann ohne vorherige Ank&uuml;ndigung ge&auml;ndert oder zur&uuml;ckgezogen werden. Die Preise beinhalten keine Einkaufskosten.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;This info given here is subject to errors and do not form part of any contract.  The offer can be changed or withdrawn without notice. Prices do not include purchase costs.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;Esta informaci&oacute;n que se proporciona aqu&iacute; est&aacute; sujeta a errores y no forma parte de ning&uacute;n contrato. La oferta se puede cambiar o retirar sin previo aviso. Los precios no incluyen los costes de compra&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fi.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;T&auml;h&auml;n annettu tieto on virheellinen, eik&auml; se ole osa sopimusta. Tarjousta voidaan muuttaa tai peruuttaa ilman erillist&auml; ilmoitusta. Hinnat eiv&auml;t sis&auml;ll&auml; ostokustannuksia.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fr.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;Cette information donn&eacute;e ici est sujette &agrave; des erreurs et ne fait partie d&#039;aucun contrat. L&#039;offre peut &ecirc;tre modifi&eacute;e ou retir&eacute;e sans pr&eacute;avis. Les prix n&#039;incluent pas les co&ucirc;ts d&#039;achat&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_is.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;&THORN;essar uppl&yacute;singar sem h&eacute;r eru gefnar eru fyrir hendi og &thorn;&aelig;r eru ekki hluti af samningi. Tilbo&eth;i&eth; er h&aelig;gt a&eth; breyta e&eth;a afturkalla&eth; &aacute;n fyrirvara. Ver&eth; er ekki me&eth; kaupver&eth;.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_nl.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;Deze informatie is hier onderhevig aan fouten en maakt geen deel uit van een contract. De aanbieding kan zonder kennisgeving worden gewijzigd of ingetrokken. Prijzen zijn exclusief aankoopkosten.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_no.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;Denne informasjonen gitt her er underlagt feil og inng&aring;r ikke i noen kontrakt. Tilbudet kan endres eller trekkes tilbake uten varsel. Prisene inkluderer ikke andre kostnader&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_ru.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;&#x42d;&#x442;&#x430; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44f; &#x43c;&#x43e;&#x436;&#x435;&#x442; &#x43f;&#x43e;&#x434;&#x432;&#x435;&#x433;&#x440;&#x430;&#x442;&#x44c;&#x441;&#x44f; &#x438;&#x437;&#x43c;&#x435;&#x43d;&#x435;&#x43d;&#x438;&#x44f;&#x43c; &#x438; &#x43d;&#x435; &#x44f;&#x432;&#x43b;&#x44f;&#x435;&#x442;&#x441;&#x44f; &#x447;&#x430;&#x441;&#x442;&#x44c;&#x44e; &#x431;&#x443;&#x434;&#x443;&#x449;&#x435;&#x433;&#x43e; &#x43a;&#x43e;&#x43d;&#x442;&#x440;&#x430;&#x43a;&#x442;&#x430;. &#x41f;&#x440;&#x435;&#x434;&#x43b;&#x43e;&#x436;&#x435;&#x43d;&#x438;&#x435; &#x43c;&#x43e;&#x436;&#x435;&#x442; &#x431;&#x44b;&#x442;&#x44c; &#x438;&#x437;&#x43c;&#x435;&#x43d;&#x435;&#x43d;&#x43e; &#x438;&#x43b;&#x438; &#x43e;&#x442;&#x43e;&#x437;&#x432;&#x430;&#x43d;&#x43e; &#x431;&#x435;&#x437; &#x43f;&#x440;&#x435;&#x434;&#x432;&#x430;&#x440;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x43e;&#x433;&#x43e; &#x443;&#x432;&#x435;&#x434;&#x43e;&#x43c;&#x43b;&#x435;&#x43d;&#x438;&#x44f;. &#x420;&#x430;&#x441;&#x445;&#x43e;&#x434;&#x44b; &#x43d;&#x430; &#x43f;&#x43e;&#x43a;&#x443;&#x43f;&#x43a;&#x443; &#x43d;&#x435; &#x432;&#x43a;&#x43b;&#x44e;&#x447;&#x435;&#x43d;&#x44b; &#x432; &#x446;&#x435;&#x43d;&#x443; &#x43e;&#x431;&#x44c;&#x435;&#x43a;&#x442;&#x430;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_se.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;Informationen som ges h&auml;r &auml;r f&ouml;rem&aring;l f&ouml;r felskrivningar och utg&ouml;r inte en del av n&aring;got kontrakt. Erbjudandet kan &auml;ndras eller dras tillbaka utan f&ouml;rvarning. Priserna inkluderar inte &ouml;vriga omkostnader.&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_zh.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Texto conversor divisas&quot;] = &quot;&#x6b64;&#x5904;&#x63d0;&#x4f9b;&#x7684;&#x4fe1;&#x606f;&#x53ef;&#x80fd;&#x5b58;&#x5728;&#x9519;&#x8bef;&#xff0c;&#x4e0d;&#x6784;&#x6210;&#x4efb;&#x4f55;&#x5408;&#x540c;&#x7684;&#x4e00;&#x90e8;&#x5206;&#x3002; &#x4f18;&#x60e0;&#x53ef;&#x4ee5;&#x66f4;&#x6539;&#x6216;&#x64a4;&#x9500;&#xff0c;&#x6055;&#x4e0d;&#x53e6;&#x884c;&#x901a;&#x77e5;&#x3002; &#x4ef7;&#x683c;&#x4e0d;&#x5305;&#x62ec;&#x8d2d;&#x4e70;&#x6210;&#x672c;&#x3002;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="once">
        <span class="badge badge-dark">11</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al cambiar de idiomas en los quicklinks
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/inicio/inicio.php:119
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
foreach ($languages as $value) {

    if ($value == $language) {

        if ($newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039;) {
            $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039; . slug($newsURLs[0][&#039;titulo_&#039; . $value]) . &#039;.html&#039;;
        } else {
            $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039;;
        }

    }
}

if ($newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039;) {
    $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039; . slug($newsURLs[0][&#039;titulo_da&#039;]) . &#039;.html&#039;;
} else {
    $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039;;
}

if ($newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039;) {
    $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039; . slug($newsURLs[0][&#039;titulo_de&#039;]) . &#039;.html&#039;;
} else {
    $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039;;
}

if ($newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039;) {
    $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039; . slug($newsURLs[0][&#039;titulo_el&#039;]) . &#039;.html&#039;;
} else {
    $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039;;
}

if ($newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039;) {
    $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039; . slug($newsURLs[0][&#039;titulo_en&#039;]) . &#039;.html&#039;;
} else {
    $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039;;
}

if ($newsURLs[0][&#039;titulo_es&#039;] != &#039;&#039;) {
    $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039; . slug($newsURLs[0][&#039;titulo_es&#039;]) . &#039;.html&#039;;
} else {
    $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039;;
}

if ($newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039;) {
    $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039; . slug($newsURLs[0][&#039;titulo_fi&#039;]) . &#039;.html&#039;;
} else {
    $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039;;
}

if ($newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039;) {
    $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039; . slug($newsURLs[0][&#039;titulo_fr&#039;]) . &#039;.html&#039;;
} else {
    $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039;;
}

if ($newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039;) {
    $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039; . slug($newsURLs[0][&#039;titulo_is&#039;]) . &#039;.html&#039;;
} else {
    $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039;;
}

if ($newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039;) {
    $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039; . slug($newsURLs[0][&#039;titulo_it&#039;]) . &#039;.html&#039;;
} else {
    $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039;;
}

if ($newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039;) {
    $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039; . slug($newsURLs[0][&#039;titulo_nl&#039;]) . &#039;.html&#039;;
} else {
    $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039;;
}

if ($newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039;) {
    $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039; . slug($newsURLs[0][&#039;titulo_no&#039;]) . &#039;.html&#039;;
} else {
    $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039;;
}

if ($newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039;) {
    $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039; . slug($newsURLs[0][&#039;titulo_pt&#039;]) . &#039;.html&#039;;
} else {
    $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039;;
}

if ($newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039;) {
    $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039; . slug($newsURLs[0][&#039;titulo_ru&#039;]) . &#039;.html&#039;;
} else {
    $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039;;
}

if ($newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039;) {
    $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039; . slug($newsURLs[0][&#039;titulo_se&#039;]) . &#039;.html&#039;;
} else {
    $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039;;
}

if ($newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039;) {
    $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039; . slug($newsURLs[0][&#039;titulo_zh&#039;]) . &#039;.html&#039;;
} else {
    $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
foreach ($languages as $value) {

   if ($value == $language) {

       if ($newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039;) {
           $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039; . slug($newsURLs[0][&#039;titulo_&#039; . $value]) . &#039;.html&#039;;
       } else {
           $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039;;
       }

   }
}

if ($newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039;) {
   $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039; . slug($newsURLs[0][&#039;titulo_da&#039;]) . &#039;.html&#039;;
} else {
   $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039;;
}

if ($newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039;) {
   $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039; . slug($newsURLs[0][&#039;titulo_de&#039;]) . &#039;.html&#039;;
} else {
   $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039;;
}

if ($newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039;) {
   $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039; . slug($newsURLs[0][&#039;titulo_el&#039;]) . &#039;.html&#039;;
} else {
   $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039;;
}

if ($newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039;) {
   $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039; . slug($newsURLs[0][&#039;titulo_en&#039;]) . &#039;.html&#039;;
} else {
   $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039;;
}

if ($newsURLs[0][&#039;titulo_es&#039;] != &#039;&#039;) {
   $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039; . slug($newsURLs[0][&#039;titulo_es&#039;]) . &#039;.html&#039;;
} else {
   $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039;;
}

if ($newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039;) {
   $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039; . slug($newsURLs[0][&#039;titulo_fi&#039;]) . &#039;.html&#039;;
} else {
   $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039;;
}

if ($newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039;) {
   $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039; . slug($newsURLs[0][&#039;titulo_fr&#039;]) . &#039;.html&#039;;
} else {
   $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039;;
}

if ($newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039;) {
   $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039; . slug($newsURLs[0][&#039;titulo_is&#039;]) . &#039;.html&#039;;
} else {
   $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039;;
}

if ($newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039;) {
   $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039; . slug($newsURLs[0][&#039;titulo_it&#039;]) . &#039;.html&#039;;
} else {
   $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039;;
}

if ($newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039;) {
   $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039; . slug($newsURLs[0][&#039;titulo_nl&#039;]) . &#039;.html&#039;;
} else {
   $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039;;
}

if ($newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039;) {
   $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039; . slug($newsURLs[0][&#039;titulo_no&#039;]) . &#039;.html&#039;;
} else {
   $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039;;
}

if ($newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039;) {
   $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039; . slug($newsURLs[0][&#039;titulo_pt&#039;]) . &#039;.html&#039;;
} else {
   $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039;;
}

if ($newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039;) {
   $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039; . slug($newsURLs[0][&#039;titulo_ru&#039;]) . &#039;.html&#039;;
} else {
   $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039;;
}

if ($newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039;) {
   $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039; . slug($newsURLs[0][&#039;titulo_se&#039;]) . &#039;.html&#039;;
} else {
   $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039;;
}

if ($newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039;) {
   $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039; . slug($newsURLs[0][&#039;titulo_zh&#039;]) . &#039;.html&#039;;
} else {
   $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="doce">
        <span class="badge badge-dark">12</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido botón borrar todas las imágenes en imágenes e imágenes privadas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2109
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-danger delimgsvar&quot;&gt;&lt;?php __(&#039;Delete selected images&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-danger delimgsvar&quot;&gt;&lt;?php __(&#039;Delete selected images&#039;); ?&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-danger delallimgsvar&quot;&gt;&lt;?php __(&#039;Delete all images&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2177
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-danger delimgsvarp&quot;&gt;&lt;?php __(&#039;Delete selected images&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-danger delimgsvarp&quot;&gt;&lt;?php __(&#039;Delete selected images&#039;); ?&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-danger delallimgsvarp&quot;&gt;&lt;?php __(&#039;Delete all images&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4251
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
&lt;script&gt;
  $(document).on(&#039;click&#039;, &#039;.delallimgsvar&#039;, function(e) {
      e.preventDefault();
      if (confirm(&#039;&lt;?php __(&#039;Are you sure want to delete the selected images?&#039;); ?&gt;&#039;)) {
          var ids = [];
          $(&#039;.delimgv&#039;).each(function( index ) {
              ids.push($( this ).val());
          });
          if (ids.toString() != &#039;&#039;) {
              $.get(&#039;images_del_mult.php?ids=&#039; + ids.toString(), function(data) {
                  if (data != &#039;&#039;) {
                      $.get(&quot;images_list.php?id_prop=&quot; + idProperty, function(data) {
                          if(data != &#039;&#039;) {
                              $(&#039;#images-list&#039;).html(data);
                          }
                      });
                  }
              });
          }
      }
  });
  $(document).on(&#039;click&#039;, &#039;.delallimgsvarp&#039;, function(e) {
      e.preventDefault();
      if (confirm(&#039;&lt;?php __(&#039;Are you sure want to delete the selected images?&#039;); ?&gt;&#039;)) {
          var ids = [];
          $(&#039;.delimgvp&#039;).each(function( index ) {
              ids.push($( this ).val());
          });
          if (ids.toString() != &#039;&#039;) {
              $.get(&#039;images_del_multp.php?ids=&#039; + ids.toString(), function(data) {
                  if (data != &#039;&#039;) {
                      $.get(&quot;images_listp.php?id_prop=&quot; + idProperty, function(data) {
                          if(data != &#039;&#039;) {
                              $(&#039;#images-listp&#039;).html(data);
                          }
                      });
                  }
              });
          }
      }
  });
&lt;/script&gt;
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
$lang[&#039;Delete all images&#039;] = &#039;Delete all images&#039;;
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
$lang[&#039;Delete all images&#039;] = &#039;Eliminar todas las im&aacute;genes&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="trece">
        <span class="badge badge-dark">13</span> <i class="fas fz-fw fa-bug text-danger"></i> Cambio texto email bajada de precio de una propiedad
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_da.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Han&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;Anmodet om, at vi sender dig en meddelelse, hvis prisen p&aring; dette hotel blev s&aelig;nket&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;P&aring;&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;du sendte os en email for at informere dig, n&aring;r prisen p&aring; denne ejendom ville falde. Skynd dig! Denne egenskabs pris har lige tabt prisen!&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_de.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&#039;Tu&#039;] = &#039;Ihre&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;Wir bitten um eine Benachrichtigung, wenn der Preis f&uuml;r diese Immobilie gesenkt wurde&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Am&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;haben Sie uns eine E-Mail geschickt, um Sie zu informieren, wenn der Preis dieser Immobilie niedriger sein w&uuml;rde. Der Preiss is niedriger geworden.&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;El&quot;] = &quot;He&quot;;
$langStr[&quot;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&quot;] = &quot;Requested that we send you a notice if the price of this property was lowered&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;El&quot;] = &quot;On&quot;;
$langStr[&quot;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&quot;] = &quot;you sent us an email to inform you when the price of this property would drop. Hurry up! This property&acute;s price has just dropped the price!&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_es.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&quot;] = &quot;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&quot;] = &quot;nos solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad. &iexcl;Darse prisa! &iexcl;El precio de esta propiedad acaba de bajar!&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fi.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;H&auml;n&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;Pyysi, ett&auml; l&auml;het&auml;mme sinulle ilmoituksen, jos hinta t&auml;m&auml;n omaisuutta alennettiin&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;P&auml;&auml;ll&auml;&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;l&auml;hetit meille s&auml;hk&ouml;postia, joka ilmoittaa sinulle, kun t&auml;m&auml;n kiinteist&ouml;n hinta laskee. Kiirehdi! T&auml;m&auml;n kiinteist&ouml;n hinta on juuri laskenut!&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fr.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Il&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;A demand&eacute; que nous vous envoyions un avis si le prix de cette propri&eacute;t&eacute; a &eacute;t&eacute; abaiss&eacute;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Le&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;vous nous avez envoy&eacute; un e-mail pour vous informer quand le prix de cette propri&eacute;t&eacute; baisserait. D&eacute;p&ecirc;chez-vous! Le prix de cette propri&eacute;t&eacute; vient de chuter&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_is.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['El'] = 'Hann';
$langStr['solicitó que le enviaramos un aviso si bajaba el precio de esta propiedad'] = 'Bað um að senda þér tilkynningu ef verðið Gististaðurinn var lækkaður';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr['El'] = 'Á';
$langStr['solicitó que le enviaramos un aviso si bajaba el precio de esta propiedad'] = 'Þú sendir okkur tölvupóst til að tilkynna þér hvenær verð á þessari eign myndi falla. Flýttu þér! Verð þessa eignar hefur bara lækkað verð!';
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_nl.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Hij&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;Gevraagd dat wij sturen u een bericht als de prijs van deze accommodatie werd verlaagd&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Op&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;u heeft ons een e-mail gestuurd om u te informeren wanneer de prijs van deze woning zou dalen. Haast je! De prijs van deze accommodatie is net gedaald!&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_no.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Tu&quot;] = &quot;Din&quot;;
$langStr[&quot;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&quot;] = &quot;Ba oss sende deg et varsel dersom prisen p&aring; dette hotellet ble senket&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Den&#039;;
$langStr[&quot;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&quot;] = &quot;sendte du oss en e-post for &aring; informere deg n&aring;r prisen p&aring; denne eiendommen ville falle. Skynd deg! Denne eiendommens pris har droppet!&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_ru.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;&#x417;&#x430;&#x43f;&#x440;&#x43e;&#x448;&#x435;&#x43d;&#x43e;, &#x447;&#x442;&#x43e; &#x43c;&#x44b; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x438;&#x43c; &#x432;&#x430;&#x43c; &#x443;&#x432;&#x435;&#x434;&#x43e;&#x43c;&#x43b;&#x435;&#x43d;&#x438;&#x435;, &#x435;&#x441;&#x43b;&#x438; &#x446;&#x435;&#x43d;&#x430; &#x44d;&#x442;&#x43e;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438; &#x431;&#x44b;&#x43b;&#x430; &#x441;&#x43d;&#x438;&#x436;&#x435;&#x43d;&#x430;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;&#x412;&#x44b; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x438;&#x43b;&#x438; &#x43d;&#x430;&#x43c; &#x44d;&#x43b;&#x435;&#x43a;&#x442;&#x440;&#x43e;&#x43d;&#x43d;&#x43e;&#x435; &#x43f;&#x438;&#x441;&#x44c;&#x43c;&#x43e;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x441;&#x43e;&#x43e;&#x431;&#x449;&#x438;&#x442;&#x44c; &#x412;&#x430;&#x43c;, &#x43a;&#x43e;&#x433;&#x434;&#x430; &#x446;&#x435;&#x43d;&#x430; &#x44d;&#x442;&#x43e;&#x433;&#x43e; &#x438;&#x43c;&#x443;&#x449;&#x435;&#x441;&#x442;&#x432;&#x430; c&#x43d;&#x438;&#x437;&#x438;&#x442;&#x441;&#x44f;. &#x41f;&#x43e;&#x441;&#x43a;&#x43e;&#x440;&#x435;&#x435;! &#x426;&#x435;&#x43d;&#x430; &#x44d;&#x442;&#x43e;&#x433;&#x43e; &#x438;&#x43c;&#x443;&#x449;&#x435;&#x441;&#x442;&#x432;&#x430; &#x442;&#x43e;&#x43b;&#x44c;&#x43a;&#x43e; &#x447;&#x442;&#x43e; &#x443;&#x43f;&#x430;&#x43b;&#x430;!&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_se.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Han&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;Beg&auml;rde att vi skickar dig ett meddelande om priset p&aring; den h&auml;r egenskapen s&auml;nktes&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&#039;El&#039;] = &#039;Den&#039;;
$langStr[&#039;solicit&oacute; que le enviaramos un aviso si bajaba el precio de esta propiedad&#039;] = &#039;skickade du oss ett mail f&ouml;r att bli informerad n&auml;r priset p&aring; denna fastighet skulle s&auml;nkas. Skynda dig! Priset p&aring; denna fastighet har precis s&auml;nkts!&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_zh.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['El'] = '他';
$langStr['solicitó que le enviaramos un aviso si bajaba el precio de esta propiedad'] = '要求我们在此物业的价格降低时向您发送通知';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr['El'] = '上';
$langStr['solicitó que le enviaramos un aviso si bajaba el precio de esta propiedad'] = '您发送了一封电子邮件，通知您此房产的价格何时会下降。 赶快！ 这个属性的价格刚刚降价！';
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="catorce">
        <span class="badge badge-dark">14</span> <i class="fas fz-fw fa-bug text-danger"></i> Error de codificación del desplegable de tipos en el buscador avanzado
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/search/view/index.tpl:43
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;option value=&quot;{$type[tp].id_type}&quot; {if $smarty.get.tp == $type[tp].id_type}selected{/if}&gt;{$type[tp].type|utf8_decode}&lt;/option&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;option value=&quot;{$type[tp].id_type}&quot; {if $smarty.get.tp == $type[tp].id_type}selected{/if}&gt;{$type[tp].type}&lt;/option&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="quince">
        <span class="badge badge-dark">15</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al guardar un inmueble cuando no se activa Fotocasa
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:706
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Fotocasa_Fields&quot;, 10);
$ins_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expFotoCasa == 1) {
    $ins_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Fotocasa_Fields&quot;, 10);
    $ins_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:882
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Fotocasa_Fields&quot;, 10);
$upd_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expFotoCasa == 1) {
    $upd_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Fotocasa_Fields&quot;, 10);
    $upd_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1062
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$del_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Delete&quot;, 10);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expFotoCasa == 1) {
    $del_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Delete&quot;, 10);
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dieciseis">
        <span class="badge badge-dark">16</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora en la generación de miniaturas de inmuebles importados, primero se bajan la principal y despues el resto
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/generar_miniaturas.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;SELECT * FROM `properties_images` WHERE procesada_img = 0 ORDER BY id_img DESC&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;
    SELECT
        properties_images.id_img,
        TRIM(REPLACE(REPLACE(image_img, &#039;\r&#039;, &#039;&#039;), &#039;\n&#039;, &#039;&#039;)) as image_img,
        TRIM(REPLACE(REPLACE(image_img2, &#039;\r&#039;, &#039;&#039;), &#039;\n&#039;, &#039;&#039;)) as image_img2,
        properties_images.property_img
    FROM `properties_images`
    WHERE procesada_img = 0
    ORDER BY IF(order_img = 1, 0, 1), id_img DESC
&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="diecisiete">
        <span class="badge badge-dark">17</span> <i class="fas fz-fw fa-bug text-danger"></i> El cambio de idiomas de zonas no funciona
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/zonas/properties.php:356
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SmartyPaginate::assign($smarty);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langQuery = &#039;&#039;;

foreach ($languages as $key =&gt; $value) {
    $langQuery .= &quot;category_&quot;.$value.&quot;_ct as titulo_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;descripcion_&quot;.$value.&quot;_ct as contenido_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;title_&quot;.$value.&quot;_ct as titulow_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;description_&quot;.$value.&quot;_ct as contenidow_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;keywords_&quot;.$value.&quot;_ct as keywords_&quot;.$value.&quot;, &quot;;
}

$newsURLs = getRecords(&quot;
SELECT
    direccion_gp_prop,
    lat_long_gp_prop,
    zoom_gp_prop,
    provinces_ct,
    &quot; . $langQuery . &quot;
    (SELECT image_img FROM zonas_images WHERE zona_img = id_ct ORDER BY order_img LIMIT 1) AS img
FROM news_categories
WHERE id_ct = &#039;&quot; . simpleSanitize(($_GET[&#039;zon&#039;])) . &quot;&#039;
LIMIT 1

&quot;);

// echo $newsURLs[0][&#039;titulo_es&#039;];

foreach ($languages as $value) {

    if ($value == $language) {

        if ($newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039; || $newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039;) {
            if ($newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039;) {
                $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039; . slug($newsURLs[0][&#039;titulo_&#039; . $value]) . &#039;.html&#039;;
            } else {
                $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039; . slug($newsURLs[0][&#039;titulo_&#039; . $value]) . &#039;.html&#039;;
            }
        } else {
            $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039;;
        }

    }
}

if ($newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039;) {
        $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039; . slug($newsURLs[0][&#039;titulo_da&#039;]) . &#039;.html&#039;;
    } else {
        $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039; . slug($newsURLs[0][&#039;titulo_da&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039;;
}

if ($newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039;) {
        $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039; . slug($newsURLs[0][&#039;titulo_de&#039;]) . &#039;.html&#039;;
    } else {
        $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039; . slug($newsURLs[0][&#039;titulo_de&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039;;
}

if ($newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039;) {
        $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039; . slug($newsURLs[0][&#039;titulo_el&#039;]) . &#039;.html&#039;;
    } else {
        $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039; . slug($newsURLs[0][&#039;titulo_el&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039;;
}

if ($newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039;) {
        $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039; . slug($newsURLs[0][&#039;titulo_en&#039;]) . &#039;.html&#039;;
    } else {
        $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039; . slug($newsURLs[0][&#039;titulo_en&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039;;
}

if ($newsURLs[0][&#039;titulo_es&#039;] != &#039;&#039;) {
    $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039; . slug($newsURLs[0][&#039;titulo_es&#039;]) . &#039;.html&#039;;
} else {
    $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039;;
}

if ($newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039;) {
        $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039; . slug($newsURLs[0][&#039;titulo_fi&#039;]) . &#039;.html&#039;;
    } else {
        $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039; . slug($newsURLs[0][&#039;titulo_fi&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039;;
}

if ($newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039;) {
        $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039; . slug($newsURLs[0][&#039;titulo_fr&#039;]) . &#039;.html&#039;;
    } else {
        $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039; . slug($newsURLs[0][&#039;titulo_fr&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039;;
}

if ($newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039;) {
        $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039; . slug($newsURLs[0][&#039;titulo_is&#039;]) . &#039;.html&#039;;
    } else {
        $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039; . slug($newsURLs[0][&#039;titulo_is&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039;;
}

if ($newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039;) {
        $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039; . slug($newsURLs[0][&#039;titulo_it&#039;]) . &#039;.html&#039;;
    } else {
        $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039; . slug($newsURLs[0][&#039;titulo_it&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039;;
}

if ($newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039;) {
        $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039; . slug($newsURLs[0][&#039;titulo_nl&#039;]) . &#039;.html&#039;;
    } else {
        $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039; . slug($newsURLs[0][&#039;titulo_nl&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039;;
}

if ($newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039;) {
        $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039; . slug($newsURLs[0][&#039;titulo_no&#039;]) . &#039;.html&#039;;
    } else {
        $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039; . slug($newsURLs[0][&#039;titulo_no&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039;;
}

if ($newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039;) {
        $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039; . slug($newsURLs[0][&#039;titulo_pt&#039;]) . &#039;.html&#039;;
    } else {
        $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039; . slug($newsURLs[0][&#039;titulo_pt&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039;;
}

if ($newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039;) {
        $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039; . slug($newsURLs[0][&#039;titulo_ru&#039;]) . &#039;.html&#039;;
    } else {
        $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039; . slug($newsURLs[0][&#039;titulo_ru&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039;;
}

if ($newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039;) {
        $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039; . slug($newsURLs[0][&#039;titulo_se&#039;]) . &#039;.html&#039;;
    } else {
        $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039; . slug($newsURLs[0][&#039;titulo_se&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039;;
}

if ($newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039;) {
        $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039; . slug($newsURLs[0][&#039;titulo_zh&#039;]) . &#039;.html&#039;;
    } else {
        $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039; . slug($newsURLs[0][&#039;titulo_zh&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039;;
}

$smarty-&gt;assign(&#039;urlDefault&#039;, $urlDefault);

$smarty-&gt;assign(&#039;urlDA&#039;, $urlDA);
$smarty-&gt;assign(&#039;urlDE&#039;, $urlDE);
$smarty-&gt;assign(&#039;urlEL&#039;, $urlEL);
$smarty-&gt;assign(&#039;urlEN&#039;, $urlEN);
$smarty-&gt;assign(&#039;urlES&#039;, $urlES);
$smarty-&gt;assign(&#039;urlFI&#039;, $urlFI);
$smarty-&gt;assign(&#039;urlFR&#039;, $urlFR);
$smarty-&gt;assign(&#039;urlIS&#039;, $urlIS);
$smarty-&gt;assign(&#039;urlIT&#039;, $urlIT);
$smarty-&gt;assign(&#039;urlNL&#039;, $urlNL);
$smarty-&gt;assign(&#039;urlNO&#039;, $urlNO);
$smarty-&gt;assign(&#039;urlPT&#039;, $urlPT);
$smarty-&gt;assign(&#039;urlRU&#039;, $urlRU);
$smarty-&gt;assign(&#039;urlSE&#039;, $urlSE);
$smarty-&gt;assign(&#039;urlZH&#039;, $urlZH);

SmartyPaginate::assign($smarty);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/ciudades/properties.php:359
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SmartyPaginate::assign($smarty);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langQuery = &#039;&#039;;
$langQuery2 = &#039;&#039;;

foreach ($languages as $key =&gt; $value) {
    $langQuery .= &quot;category_&quot;.$value.&quot;_ct as titulo_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;descripcion_&quot;.$value.&quot;_ct as contenido_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;title_&quot;.$value.&quot;_ct as titulow_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;description_&quot;.$value.&quot;_ct as contenidow_&quot;.$value.&quot;, &quot;;
    $langQuery .= &quot;keywords_&quot;.$value.&quot;_ct as keywords_&quot;.$value.&quot;, &quot;;
    $langQuery2 .= &quot;news.title_&quot;.$value.&quot;_nws as titulo_&quot;.$value.&quot;, &quot;;
    $langQuery2 .= &quot;news.titlew_&quot;.$value.&quot;_nws as titulometa_&quot;.$value.&quot;, &quot;;
    $langQuery2 .= &quot;news.content_&quot;.$value.&quot;_nws as contenido_&quot;.$value.&quot;, &quot;;
}

$newsURLs = getRecords(&quot;
SELECT
    direccion_gp_prop,
    lat_long_gp_prop,
    zoom_gp_prop,
    provinces_ct,
    &quot; . $langQuery . &quot;
    (SELECT image_img FROM zonas_images WHERE zona_img = id_ct ORDER BY order_img LIMIT 1) AS img
FROM news_categories
WHERE id_ct = &#039;&quot; . simpleSanitize(($_GET[&#039;zon&#039;])) . &quot;&#039;
LIMIT 1

&quot;);

$newsURLS2 = getRecords(&quot;

    SELECT news.id_nws,
        &quot; . $langQuery2 . &quot;
        news.date_nws,
        news.quick_location_nws,
        news.quick_type_nws,
        news.quick_status_nws,
        news.quick_town_nws,
        news.lat_long_gp_prop,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img
    FROM news

    WHERE id_nws = &#039;&quot; . simpleSanitize(($_GET[&#039;ciu&#039;])) . &quot;&#039;

LIMIT 1

&quot;);



// echo $newsURLs[0][&#039;titulo_es&#039;];

foreach ($languages as $value) {

    if ($value == $language) {

        if ($newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039; || $newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039;) {
            if ($newsURLs[0][&#039;titulo_&#039; . $value] != &#039;&#039;) {
                $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039; . slug($newsURLs[0][&#039;titulo_&#039; . $value]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_&#039; . $value]) . &#039;.html&#039;;
            } else {
                $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039; . slug($newsURLs[0][&#039;titulo_&#039; . $value]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_&#039; . $value]) . &#039;.html&#039;;
            }
        } else {
            $urlDefault = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039;;
        }

    }
}

if ($newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_da&#039;] != &#039;&#039;) {
        $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039; . slug($newsURLs[0][&#039;titulo_da&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_da&#039;]) . &#039;.html&#039;;
    } else {
        $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039; . slug($newsURLs[0][&#039;titulo_da&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_da&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlDA = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/da/&#039;;
}

if ($newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_de&#039;] != &#039;&#039;) {
        $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039; . slug($newsURLs[0][&#039;titulo_de&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_de&#039;]) . &#039;.html&#039;;
    } else {
        $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039; . slug($newsURLs[0][&#039;titulo_de&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_de&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlDE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/de/&#039;;
}

if ($newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_el&#039;] != &#039;&#039;) {
        $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039; . slug($newsURLs[0][&#039;titulo_el&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_el&#039;]) . &#039;.html&#039;;
    } else {
        $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039; . slug($newsURLs[0][&#039;titulo_el&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_el&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlEL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/el/&#039;;
}

if ($newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_en&#039;] != &#039;&#039;) {
        $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039; . slug($newsURLs[0][&#039;titulo_en&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_en&#039;]) . &#039;.html&#039;;
    } else {
        $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039; . slug($newsURLs[0][&#039;titulo_en&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_en&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039;;
}

if ($newsURLs[0][&#039;titulo_es&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_es&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_es&#039;] != &#039;&#039;) {
        $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039; . slug($newsURLs[0][&#039;titulo_es&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_es&#039;]) . &#039;.html&#039;;
    } else {
        $urlES = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/es/&#039; . slug($newsURLs[0][&#039;titulo_es&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_es&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlEN = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/en/&#039;;
}

if ($newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_fi&#039;] != &#039;&#039;) {
        $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039; . slug($newsURLs[0][&#039;titulo_fi&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_fi&#039;]) . &#039;.html&#039;;
    } else {
        $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039; . slug($newsURLs[0][&#039;titulo_fi&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_fi&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlFI = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fi/&#039;;
}

if ($newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_fr&#039;] != &#039;&#039;) {
        $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039; . slug($newsURLs[0][&#039;titulo_fr&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_fr&#039;]) . &#039;.html&#039;;
    } else {
        $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039; . slug($newsURLs[0][&#039;titulo_fr&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_fr&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlFR = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/fr/&#039;;
}

if ($newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_is&#039;] != &#039;&#039;) {
        $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039; . slug($newsURLs[0][&#039;titulo_is&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_is&#039;]) . &#039;.html&#039;;
    } else {
        $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039; . slug($newsURLs[0][&#039;titulo_is&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_is&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlIS = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/is/&#039;;
}

if ($newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_it&#039;] != &#039;&#039;) {
        $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039; . slug($newsURLs[0][&#039;titulo_it&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_it&#039;]) . &#039;.html&#039;;
    } else {
        $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039; . slug($newsURLs[0][&#039;titulo_it&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_it&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlIT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/it/&#039;;
}

if ($newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_nl&#039;] != &#039;&#039;) {
        $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039; . slug($newsURLs[0][&#039;titulo_nl&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_nl&#039;]) . &#039;.html&#039;;
    } else {
        $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039; . slug($newsURLs[0][&#039;titulo_nl&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_nl&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlNL = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/nl/&#039;;
}

if ($newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_no&#039;] != &#039;&#039;) {
        $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039; . slug($newsURLs[0][&#039;titulo_no&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_no&#039;]) . &#039;.html&#039;;
    } else {
        $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039; . slug($newsURLs[0][&#039;titulo_no&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_no&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlNO = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/no/&#039;;
}

if ($newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_pt&#039;] != &#039;&#039;) {
        $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039; . slug($newsURLs[0][&#039;titulo_pt&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_pt&#039;]) . &#039;.html&#039;;
    } else {
        $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039; . slug($newsURLs[0][&#039;titulo_pt&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_pt&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlPT = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/pt/&#039;;
}

if ($newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_ru&#039;] != &#039;&#039;) {
        $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039; . slug($newsURLs[0][&#039;titulo_ru&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_ru&#039;]) . &#039;.html&#039;;
    } else {
        $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039; . slug($newsURLs[0][&#039;titulo_ru&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_ru&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlRU = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/ru/&#039;;
}

if ($newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_se&#039;] != &#039;&#039;) {
        $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039; . slug($newsURLs[0][&#039;titulo_se&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_se&#039;]) . &#039;.html&#039;;
    } else {
        $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039; . slug($newsURLs[0][&#039;titulo_se&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_se&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlSE = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/se/&#039;;
}

if ($newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039; || $newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039;) {
    if ($newsURLs[0][&#039;titulo_zh&#039;] != &#039;&#039;) {
        $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039; . slug($newsURLs[0][&#039;titulo_zh&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_zh&#039;]) . &#039;.html&#039;;
    } else {
        $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039; . slug($newsURLs[0][&#039;titulo_zh&#039;]) . &#039;/&#039; . slug($newsURLS2[0][&#039;titulo_zh&#039;]) . &#039;.html&#039;;
    }
} else {
    $urlZH = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/zh/&#039;;
}

$smarty-&gt;assign(&#039;urlDefault&#039;, $urlDefault);

$smarty-&gt;assign(&#039;urlDA&#039;, $urlDA);
$smarty-&gt;assign(&#039;urlDE&#039;, $urlDE);
$smarty-&gt;assign(&#039;urlEL&#039;, $urlEL);
$smarty-&gt;assign(&#039;urlEN&#039;, $urlEN);
$smarty-&gt;assign(&#039;urlES&#039;, $urlES);
$smarty-&gt;assign(&#039;urlFI&#039;, $urlFI);
$smarty-&gt;assign(&#039;urlFR&#039;, $urlFR);
$smarty-&gt;assign(&#039;urlIS&#039;, $urlIS);
$smarty-&gt;assign(&#039;urlIT&#039;, $urlIT);
$smarty-&gt;assign(&#039;urlNL&#039;, $urlNL);
$smarty-&gt;assign(&#039;urlNO&#039;, $urlNO);
$smarty-&gt;assign(&#039;urlPT&#039;, $urlPT);
$smarty-&gt;assign(&#039;urlRU&#039;, $urlRU);
$smarty-&gt;assign(&#039;urlSE&#039;, $urlSE);
$smarty-&gt;assign(&#039;urlZH&#039;, $urlZH);

SmartyPaginate::assign($smarty);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dieciocho">
        <span class="badge badge-dark">18</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido inmueble de la consulta a email inmuebles similares
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/enquiry.php:107
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$body2 .= &quot;&lt;p&gt;&quot;. $langStr[&quot;Un cordial saludo&quot;].&quot;.&lt;/p&gt;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$body2 .= &quot;&lt;p&gt;&quot;. $langStr[&quot;Un cordial saludo&quot;].&quot;.&lt;/p&gt;&quot;;
ob_start();
include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/property.php&#039;);
$body2 .= ob_get_contents();
ob_end_clean();
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
