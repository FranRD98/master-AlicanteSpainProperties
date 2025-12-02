<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 27-05-2021</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Nuevo botón enviar búsqueda</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Nuevo botón enviar búsqueda
    </h6>
    <div class="card-body">
        Añadir los archivos:
        <pre>
            <code class="sql">
/modules/properties/search.php
/modules/properties/view/partials/modal-search.tpl
            </code>
        </pre>

        <hr>
        Añadir el botón en el listado de propiedades:
        <pre>
            <code class="makefile">
&lt;div class=&quot;text-center float-lg-left mb-3&quot;&gt;
    &lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-primary text-white font-weight-normal&quot; data-toggle=&quot;modal&quot; data-target=&quot;#searchPureModal&quot;&gt;&lt;i class=&quot;fas fa-envelope&quot;&gt;&lt;/i&gt; {$lng_searchtxt}&lt;/a&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>

        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
{if $seccion == {$url_properties}}
{include file=&quot;file:modules/properties/view/partials/modal-search.tpl&quot; }
&lt;script&gt;
    $(&#039;#sendSearchForm&#039;).submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

            $.get(&quot;/modules/properties/search.php?&quot; + $(this).serialize()).done(function(data) {
                if (data == &#039;ok&#039;) {

                    $(&#039;#sendSearchForm input[type=text], #sendSearchForm textarea&#039;).val(&#039;&#039;);
                    $(&#039;#sendSearchForm input[type=checkbox]&#039;).removeAttr(&#039;checked&#039;);
                    $(&#039;#sendSearchForm .loading&#039;).remove();
                    swal(&#039;&#039;, okConsult, &#039;success&#039;);
                    $(&#039;#searchPureModal .close&#039;).click();

                }

            });

        }

    });
&lt;/script&gt;
{/if}
            </code>
        </pre>
        <hr>

        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var cookieTxt = &#039;{$lng_cookiestext|escape:&quot;quotes&quot;}&#039;;
var cookiePol = &#039;{$lng_politica_de_cookies|escape:&quot;quotes&quot;}&#039;;
var cookieTxtBtn = &#039;{$lng_continuar|escape:&quot;quotes&quot;}&#039;;
var cookieTxtMoreInfo = &#039;{$lng_mas_informacion|escape:&quot;quotes&quot;}&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var cookieTxt = &#039;{$lng_cookietxt|escape:&quot;quotes&quot;}&#039;;
var cookieTxt2 = &#039;{$lng_cookietxt2|escape:&quot;quotes&quot;}&#039;;
var cookieTxt3 = &#039;{$lng_cookietxt3|escape:&quot;quotes&quot;}&#039;;
var cookieTxt4 = &#039;{$lng_cookietxt4|escape:&quot;quotes&quot;}&#039;;
var cookieTxt5 = &#039;{$lng_cookietxt5|escape:&quot;quotes&quot;}&#039;;
var cookieTxt6 = &#039;{$lng_cookietxt6|escape:&quot;quotes&quot;}&#039;;
var cookieTxt7 = &#039;{$lng_cookietxt7|escape:&quot;quotes&quot;}&#039;;
var cookieTxt8 = &#039;{$lng_cookietxt8|escape:&quot;quotes&quot;}&#039;;
            </code>
        </pre>

        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$langStr[&quot;searchtxt&quot;] = &quot;Receive those properties by EMAIL&quot;;
$langStr[&quot;searchtxt1&quot;] = &quot;The properties of your search&quot;;
$langStr[&quot;searchtxt2&quot;] = &quot;Click the following link to see the properties that your search contained&quot;;
            </code>
        </pre>
        Y hacemos igual con el resto de idiomas.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


