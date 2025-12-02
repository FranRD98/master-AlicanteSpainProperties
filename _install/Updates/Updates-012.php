<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 6 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 8-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-plus-circle text-success"></i> Añañdido botón para generar PDF para el consentimiento GDPR</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadida herramienta para generar los textos de GDPR</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido texto GDPR para los formularios</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añañdido botón para generar PDF para el consentimiento GDPR
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/inmoconn.php:51
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/secciones.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/secciones.php&#039;);
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/gdpr.php&#039;);
            </code>
        </pre>
        <hr>
        Subir el archivo y completar los datos:
        <pre>
            <code class="makefile">
/Connections/conf/gdpr.php
            </code>
        </pre>
        A la carpeta:
        <pre>
            <code class="php">
/Connections/conf/
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
$lang[&#039;Recuerde guardar el cliente para ver los ultimos datos&#039;] = &#039;Recuerde guardar el cliente para ver los ultimos datos&#039;;
$lang[&#039;Recuerde guardar el propietario para ver los ultimos datos&#039;] = &#039;Recuerde guardar el propietario para ver los ultimos datos&#039;;
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
$lang[&#039;Recuerde guardar el cliente para ver los ultimos datos&#039;] = &#039;Remember to save the client to see the latest data&#039;;
$lang[&#039;Recuerde guardar el propietario para ver los ultimos datos&#039;] = &#039;Remember to save the owner to see the latest data&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:899
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($actMailchimp == 1): ?&gt;
&lt;div class=&quot;checkbox&quot;&gt;
  &lt;label&gt;
      &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client[&#039;newsletter_cli&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_cli&quot; id=&quot;newsletter_cli&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
      &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
  &lt;/label&gt;
&lt;/div&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actMailchimp == 1): ?&gt;
&lt;div class=&quot;checkbox&quot;&gt;
  &lt;label&gt;
      &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client[&#039;newsletter_cli&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_cli&quot; id=&quot;newsletter_cli&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
      &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
  &lt;/label&gt;
&lt;/div&gt;
&lt;?php if ($_GET[&#039;id_cli&#039;] != &#039;&#039;): ?&gt;
&lt;a href=&quot;/intramedianet/gdpr/clients.php?id=&lt;?php echo $_GET[&#039;id_cli&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm&quot;  data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&#039;Recuerde guardar el cliente para ver los ultimos datos&#039;); ?&gt;&quot;&gt;GDPR&lt;/a&gt;
&lt;?php endif ?&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:603
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($actMailchimp == 1): ?&gt;
&lt;div class=&quot;checkbox&quot;&gt;
    &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner[&#039;newsletter_pro&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_pro&quot; id=&quot;newsletter_pro&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
        &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;newsletter_pro&quot;); ?&gt;
&lt;/div&gt;

&lt;hr&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actMailchimp == 1): ?&gt;
&lt;div class=&quot;checkbox&quot;&gt;
    &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner[&#039;newsletter_pro&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_pro&quot; id=&quot;newsletter_pro&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
        &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;newsletter_pro&quot;); ?&gt;
&lt;/div&gt;
&lt;?php if ($_GET[&#039;id_pro&#039;] != &#039;&#039;): ?&gt;
&lt;a href=&quot;/intramedianet/gdpr/owners.php?id=&lt;?php echo $_GET[&#039;id_pro&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm&quot;  data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&#039;Recuerde guardar el propietario para ver los ultimos datos&#039;); ?&gt;&quot;&gt;GDPR&lt;/a&gt;
&lt;?php endif ?&gt;

&lt;hr&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido herramienta para generar los textos de GDPR
    </h6>
    <div class="card-body">
        Se puede acceder en: <code>https://demo.mediaelx.info/_herramientas/gdpr.php=</code> o en la ruta de la web que se esta desarrollando: <code>/_herramientas/gdpr.php=</code>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 0 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido texto GDPR para los formularios
    </h6>
    <div class="card-body">
        En los archivos:
        <pre>
            <code class="makefile">
/modules/contact/view/index.tpl
/templates/templates/partials/contact-foot.tpl
/modules/favorites/view/partials/modal-send.tpl
/modules/property/view/partials/contactar.tpl
/modules/property/view/partials/modal-amigos.tpl
/modules/property/view/partials/modal-bajada.tpl
/modules/vender/view/index.tpl
            </code>
        </pre>
        Añadir al final del formulario, despues del botón, en los modals antes.
        <pre>
            <code class="php">
&lt;div class=&quot;gdpr&quot;&gt;{$texto_formularios_GDPR}&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:155
            </code>
        </pre>
        Cambiar.
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;fromMail&quot;, $fromMail);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;fromMail&quot;, $fromMail);
$smarty-&gt;assign(&quot;texto_formularios_GDPR&quot;, $texto_formularios_GDPR);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/gdpr.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$url_privacidad_GDPR = &quot;&quot;; // https://mediaelx.net/privacidad.html
$texto_formularios_GDPR = &quot;
&lt;b&gt;Responsable del tratamiento:&lt;/b&gt; $empresa_GDPR,
&lt;b&gt;Finalidad del tratamiento:&lt;/b&gt; Gesti&oacute;n y control de los servicios ofrecidos a trav&eacute;s de la p&aacute;gina Web de Servicios inmobiliarios, Env&iacute;o de informaci&oacute;n a traves de newsletter y otros,
 &lt;b&gt;Legitimaci&oacute;n:&lt;/b&gt; Por consentimiento,
 &lt;b&gt;Destinatarios:&lt;/b&gt; No se cederan los datos, salvo para elaborar contabilidad,
 &lt;b&gt;Derechos de las personas interesadas:&lt;/b&gt; Acceder, rectificar y suprimir los datos, solicitar la portabilidad de los mismos, oponerse altratamiento y solicitar la limitaci&oacute;n de &eacute;ste,
 &lt;b&gt;Procedencia de los datos: &lt;/b&gt; El Propio interesado,
 &lt;b&gt;Informaci&oacute;n Adicional: &lt;/b&gt; Puede consultarse la informaci&oacute;n adicional y detallada sobre protecci&oacute;n de datos &lt;a href=\&quot;$url_privacidad_GDPR\&quot; target=\&quot;_blank\&quot;&gt;Aqu&iacute;&lt;/a&gt;.
&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss:1621
            </code>
        </pre>
        Añadir en el grupo @group CONTACTAR:
        <pre>
            <code class="css">
.gdpr {
    display: block;
    margin: 10px 0 0;
    font-size: 9px;
    line-height: 14px;
    height: 40px;
    overflow: scroll;
    b {
        font-weight: 800;
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
