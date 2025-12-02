<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 4 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 6-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Al acceder a una web con HTTPS a la intramedianet, no se está haciendo la redirección de HTTP a HTTPS</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error al enviar correos desde el archivo clients_send.php</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> En el idioma Francés y en el idioma Danés hay un error en sus respectivos archivos de traducciones de la política de privacidad</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Si la web no dispone de newsletter, el checkbox correspondiente debería de ocultarse</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Al acceder a una web con HTTPS a la intramedianet, no se está haciendo la redirección de HTTP a HTTPS
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/.htaccess
            </code>
        </pre>
        Susutituir todo por:
        <pre>
            <code class="php">
&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine on
    SetEnvIfNoCase User-Agent ^libwww-perl bad_bot
    Order Allow,Deny
    Allow from ALL
    Deny from env=bad_bot
    RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
    RewriteRule ^(.*)$ https://%1/intramedianet/$1 [R=301,L]
    Header set Strict-Transport-Security &quot;max-age=31536000; includeSubDomains; preload&quot; env=HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
&lt;/IfModule&gt;
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al enviar correos desde el archivo clients_send.php
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send.php:65
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsInsert3 = &quot;
    INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
    ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$ids[$i].&quot;&#039;,  &#039;&quot;.$_GET[&#039;email&#039;].&quot;&#039;,  &#039;&quot;.$tipo.&quot;&#039;, &#039;&quot;.$_GET[&#039;comment&#039;].&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsInsert3 = &quot;
    INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
    ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$ids[$i].&quot;&#039;,  &#039;&quot;.mysql_real_escape_string($_GET[&#039;email&#039;]).&quot;&#039;,  &#039;&quot;.$tipo.&quot;&#039;, &#039;&quot;.mysql_real_escape_string($_GET[&#039;comment&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
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
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> En el idioma Francés y en el idioma Danés hay un error en sus respectivos archivos de traducciones de la política de privacidad
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fr.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Cochez la case pour nous contacter et acceptez que vos informations soient utilis&eacute;es conform&eacute;ment &agrave; notre %s politique de confidentialit&eacute; s%  vous serez automatiquement ajout&eacute; &agrave; notre liste de diffusion, mais vous pouvez vous d&eacute;sinscrire &agrave; tout moment&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Cochez la case pour nous contacter et acceptez que vos informations soient utilis&eacute;es conform&eacute;ment &agrave; notre %s politique de confidentialit&eacute; %s  vous serez automatiquement ajout&eacute; &agrave; notre liste de diffusion, mais vous pouvez vous d&eacute;sinscrire &agrave; tout moment&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_da.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Tjek boksen for at kontakte os og acceptere, at dine oplysninger bliver brugt i henhold til vores% s Fortrolighedspolitik% s, du bliver automatisk tilf&oslash;jet til vores mailingliste, men du kan til enhver tid frav&aelig;lge&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Tjek boksen for at kontakte os og acceptere, at dine oplysninger bliver brugt i henhold til vores %s Fortrolighedspolitik %s, du bliver automatisk tilf&oslash;jet til vores mailingliste, men du kan til enhver tid frav&aelig;lge&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Si la web no dispone de newsletter, el checkbox correspondiente debería de ocultarse
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:500
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;newsletter_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_cli&quot;, &quot;1&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($actMailchimp == 1) {
    $ins_properties_client-&gt;addColumn(&quot;newsletter_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_cli&quot;, &quot;1&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:559
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;newsletter_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($actMailchimp == 1) {
    $upd_properties_client-&gt;addColumn(&quot;newsletter_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_cli&quot;);
}
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
&lt;div class=&quot;checkbox&quot;&gt;
  &lt;label&gt;
      &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client[&#039;newsletter_cli&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_cli&quot; id=&quot;newsletter_cli&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
      &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
  &lt;/label&gt;
&lt;/div&gt;
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
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:314
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_owner-&gt;addColumn(&quot;newsletter_pro&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_pro&quot;, &quot;0&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($actMailchimp == 1) {
    $ins_properties_owner-&gt;addColumn(&quot;newsletter_pro&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_pro&quot;, &quot;0&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:362
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_owner-&gt;addColumn(&quot;newsletter_pro&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_pro&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($actMailchimp == 1) {
    $upd_properties_owner-&gt;addColumn(&quot;newsletter_pro&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;newsletter_pro&quot;);
}
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
&lt;div class=&quot;checkbox&quot;&gt;
    &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner[&#039;newsletter_pro&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_pro&quot; id=&quot;newsletter_pro&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
        &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;newsletter_pro&quot;); ?&gt;
&lt;/div&gt;

&lt;hr&gt;
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

&lt;hr&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
