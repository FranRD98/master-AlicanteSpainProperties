<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-08-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Fix cambio estatus del buscador y el precio</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Error en el Correo de Recomendar a un amigo</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Fix errores importador REDSP</a></li>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix cambio estatus del buscador y el precio
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/buscador.tpl:100
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;select name=&quot;prds&quot; id=&quot;prds{$dupl}&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;prds&quot; id=&quot;prds{$dupl}&quot; class=&quot;form-control prds&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/buscador.tpl:135
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;select name=&quot;prhs&quot; id=&quot;prhs{$dupl}&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;prhs&quot; id=&quot;prhs{$dupl}&quot; class=&quot;form-control prhs&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/search/view/index.tpl:110
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;select name=&quot;prds&quot; id=&quot;prds&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;prds&quot; id=&quot;prds&quot; class=&quot;form-control prds&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/search/view/index.tpl::143
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;select name=&quot;prhs&quot; id=&quot;prhs&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;prhs&quot; id=&quot;prhs&quot; class=&quot;form-control prhs&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:377
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#prds, #prds1&#039;).html(returnPrices(&#039;{if isset($smarty.get.prds)}{$smarty.get.prds}{else} {/if}&#039;, $rental, $resale, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;, 0)).change();
$(&#039;#prhs, #prhs1&#039;).html(returnPrices(&#039;{if isset($smarty.get.prhs)}{$smarty.get.prhs}{else} {/if}&#039;, $rental, $resale, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;, 1)).change();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#prds, #prds1&#039;).html(returnPrices($(&#039;.prds&#039;).val(), $rental, $resale, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;, 0)).change();
$(&#039;#prhs, #prhs1&#039;).html(returnPrices($(&#039;.prhs&#039;).val(), $rental, $resale, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;, 1)).change();
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el Correo de Recomendar a un amigo
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/send-friend.php:86
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$body  .= &#039;&lt;p&gt;&#039; . htmlspecialchars($langStr[&#039;Hola&#039;]) . &#039; &lt;strong&gt;&#039; . htmlspecialchars($name) . &#039;&lt;/strong&gt; &#039; . htmlspecialchars($langStr[&quot;soy&quot;]) . &#039; &lt;strong&gt;&#039; . htmlspecialchars($name) . &#039;&lt;/strong&gt;!&lt;/p&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$body  .= &#039;&lt;p&gt;&#039; . htmlspecialchars($langStr[&#039;Hola&#039;]) . &#039; &lt;strong&gt;&#039; . htmlspecialchars($name) . &#039;&lt;/strong&gt; &#039; . htmlspecialchars($langStr[&quot;soy&quot;]) . &#039; &lt;strong&gt;&#039; . htmlspecialchars($fname) . &#039;&lt;/strong&gt;!&lt;/p&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_nl.php:74
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;y pienso que te pued einteresar&quot;] = &quot;En ik denk dat je misschien ge&iuml;nteresseerd&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;y pienso que te pued einteresar&quot;] = &quot;En ik denk dat dit u misschien kan intereseren&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_nl.php:75
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&amp;quot;y pienso que te pued einteresar&amp;quot;] = &amp;quot;En ik denk dat je misschien ge&amp;iuml;nteresseerd&amp;quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;te recomienda la siguiente propiedad en&quot;] = &quot;stelt de volgende woning voor&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix errores importador REDSP
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Redsp.php:333
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if( $prop[&quot;ExternalId&quot;] == $row_rsPropsDel[&#039;id_prop&#039;] ) {328
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if( $prop[&quot;ExternalId&quot;] == $row_rsPropsDel[&#039;id_prop&#039;] ) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Redsp.php:334
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$resutl = FotocasaAPI::deletePropertyByPortal( (int)$row_rsPropsDel[&#039;id_prop&#039;], 1, $fotocasaDatos[&quot;api_key&quot;]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$result = FotocasaAPI::deletePropertyByPortal( (int)$row_rsPropsDel[&#039;id_prop&#039;], 1, $fotocasaDatos[&quot;api_key&quot;]);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Redsp.php:61
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$provinceName = setProvince((string)$property-&gt;province, $countryID);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$provinceName = setProvince((string)$property-&gt;address-&gt;province, $countryID);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>