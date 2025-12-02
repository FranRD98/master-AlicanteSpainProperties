<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 13-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Si una web tiene un status con propiedades y en cualquier momento deja de tenerlas, la página de ese status daría un 404</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Si envias el formulario de recomendar o el de favoritos sin haberle dado al captcha se queda la rueda dando vueltas</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Si una web tiene un status con propiedades y en cualquier momento deja de tenerlas, la página de ese status daría un 404
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:336
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
SELECT
    properties_status.status_&quot;.$lang.&quot;_sta as sale,
    properties_status.id_sta as id
FROM  properties_properties
    LEFT OUTER  JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0
GROUP BY id_sta
ORDER BY sale
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
SELECT
    properties_status.status_&quot;.$lang.&quot;_sta as sale,
    properties_status.id_sta as id,
    CASE WHEN properties_properties.activado_prop = 1  AND properties_properties.alquilado_prop = 0 AND properties_properties.vendido_prop = 0
    THEN 1
    ELSE 0
    END as visible
FROM  properties_status
    LEFT JOIN properties_properties ON properties_properties.operacion_prop = properties_status.id_sta
GROUP BY id_sta
ORDER BY sale
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/buscador.tpl:17
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;option value=&quot;{$status[st].id}&quot; {if $smarty.get.st == $status[st].id || $smarty.get.st[0] == $status[st].id}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
{if $status[st].visible}
    &lt;option value=&quot;{$status[st].id}&quot; {if $smarty.get.st == $status[st].id || $smarty.get.st[0] == $status[st].id}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/search/view/index.tpl:19
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;option value=&quot;{$status[st].id}&quot; {if $smarty.get.st == $status[st].id}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
{if $status[st].visible}
    &lt;option value=&quot;{$status[st].id}&quot; {if $smarty.get.st == $status[st].id}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/menu.tpl:10
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;li {if $submenu == 1}class=&quot;dropdown-item&quot;{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_properties}-{$status[st].sale|lower|slug}/&quot;&gt;{$status[st].sale}&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
{if $status[st].visible}
    &lt;li {if $submenu == 1}class=&quot;dropdown-item&quot;{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_properties}-{$status[st].sale|lower|slug}/&quot;&gt;{$status[st].sale}&lt;/a&gt;&lt;/li&gt;
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Si envias el formulario de recomendar o el de favoritos sin haberle dado al captcha se queda la rueda dando vueltas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:58
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
$(&quot;.validate&quot;).each(function() {

    $(this).validate({
        onkeyup: false,
        errorClass: &quot;help-block error&quot;,
        validClass: &#039;valid&#039;,
        highlight: function(element, errorClass, validClas) {
            $(element).parents(&quot;div.form-group&quot;).addClass(&quot;error&quot;);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(&quot;div.error&quot;).removeClass(&quot;error&quot;);
        },
        errorPlacement: function(error, element) {
            $(element).closest(&#039;div&#039;).append(error);
        },
        errorElement: &#039;div&#039;
    });

});
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
$(&quot;.validate&quot;).each(function() {

    $(this).validate({
        ignore: &quot;&quot;,
        rules: {
            hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == &#039;&#039;) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        },
        onkeyup: false,
        errorClass: &quot;help-block error&quot;,
        validClass: &#039;valid&#039;,
        highlight: function(element, errorClass, validClas) {
            $(element).parents(&quot;div.form-group&quot;).addClass(&quot;error&quot;);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(&quot;div.error&quot;).removeClass(&quot;error&quot;);
        },
        errorPlacement: function(error, element) {
            $(element).closest(&#039;div&#039;).append(error);
        },
        errorElement: &#039;div&#039;
    });

});
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/property/view/partials/modal-amigos.tpl:39
/modules/favorites/view/partials/modal-send.tpl:31
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;div class=&quot;g-recaptcha&quot; data-sitekey=&quot;{$google_captcha_sitekey}&quot;&gt;&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
&lt;div&gt;
    &lt;div class=&quot;g-recaptcha&quot; data-sitekey=&quot;{$google_captcha_sitekey}&quot;&gt;&lt;/div&gt;
    &lt;input type=&quot;hidden&quot; class=&quot;hiddenRecaptcha required&quot; name=&quot;hiddenRecaptcha&quot; id=&quot;hiddenRecaptcha&quot;&gt;
&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
