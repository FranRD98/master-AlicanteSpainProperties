<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-10-2020</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Nueva versión aviso cookies</a></li>
    </ol>
</div>

<div class="card mb-4"">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Nueva versión aviso cookies
    </h6>
    <div class="card-body">
        Añadir el archivo:
        <pre>
            <code class="sql">
/js/source/jquery.ihavecookies.js
            </code>
        </pre>

        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/webpack.mix.js
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&#039;js/source/cookieconsent/cookieconsent.js&#039;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&#039;js/source/jquery.ihavecookies.js&#039;,
            </code>
        </pre>
        <hr>

        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
window.addEventListener(&quot;load&quot;, function(){
    window.cookieconsent.initialise({
        &quot;palette&quot;: {
            &quot;popup&quot;: {
                &quot;background&quot;: &quot;#ccc&quot;,
                &quot;text&quot;: &quot;#1C232C&quot;
            },
            &quot;button&quot;: {
                &quot;background&quot;: &quot;#1C232C&quot;
            }
        },
        &quot;content&quot;: {
            &quot;message&quot;: cookieTxt + &quot;.&quot;,
            &quot;dismiss&quot;: cookieTxtBtn,
            &quot;link&quot;: cookieTxtMoreInfo,
            &quot;href&quot;: cookieURL
        },
        law: {
          regionalLaw: false,
        },
        revokable:true,
        revokeBtn:&#039;&lt;div class=&quot;cc-revoke {{classes}}&quot;&gt;&#039; + cookiePol + &#039;&lt;/div&gt;&#039;,
        law: {
          regionalLaw: false,
        },
        location: false,
    })
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var options = {
    title: cookieTxt,
    message: cookieTxt2,
    moreInfoLabel: cookieTxt3,
    acceptBtnLabel: cookieTxt4,
    advancedBtnLabel: cookieTxt5,
    cookieTypesTitle: cookieTxt6,
    fixedCookieTypeLabel: cookieTxt7,
    fixedCookieTypeDesc: cookieTxt8,
    link: &#039;/cookies&#039;
}

$(&#039;body&#039;).ihavecookies(options);
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

        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/public_html/css/source/website.scss
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
//  ============================================================================
//  /* @group COOKIES */
//  ============================================================================

#gdpr-cookie-message {
    position: fixed;
    bottom: 30px;
    left: 10px;
    max-width: 320px;
    background-color: #eaeaea;
    padding: 30px 35px;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.25);
    z-index: 10000;
    font-family: system-ui;

    @include media-breakpoint-up(md)
    {
        right: 30px;
        max-width: 380px;
    }
}

#gdpr-cookie-message h4 {
    color: #000;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 15px;
}
#gdpr-cookie-message h5 {
    color: #000;
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 20px;
}

#gdpr-cookie-message p,
#gdpr-cookie-message ul {
    color: #000;
    font-size: 14px;
    line-height: 1.5em;
}
#gdpr-cookie-message ul {
  padding-left: 10px;
}
#gdpr-cookie-message p:last-child {
    margin-bottom: 0;
    text-align: center;
    padding-left: 0;
}

#gdpr-cookie-message li {
    width: 49%;
    display: inline-block;
    font-size: 13px;

}
#gdpr-cookie-message a
{
    color: $primary;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease-in;
}
#gdpr-cookie-message a:hover {
    color: #000;
    border-bottom-color: #000;
    transition: all 0.3s ease-in;
}
#gdpr-cookie-message button,
button#ihavecookiesBtn
{
    border: none;
    background: #000;
    color: white;
    font-size: 13px;
    padding: 7px 14px;
    border-radius: 3px;
    margin: 10px 10px 10px 0;
    cursor: pointer;
    transition: all 0.3s ease-in;
}
#gdpr-cookie-message button:hover {
    background: white;
    color: #000;
    transition: all 0.3s ease-in;
}
button#gdpr-cookie-advanced {
    background: white;
    color: #000;
}
#gdpr-cookie-message button:disabled {
    opacity: 0.3;
}
#gdpr-cookie-message input[type=&quot;checkbox&quot;] {
    float: none;
    margin-top: 0;
    margin-right: 5px;
}
            </code>
        </pre>
        <hr>

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
$langStr[&quot;cookieTxt&quot;] = &quot;Cookies &amp; Privacy&#039;&quot;;
$langStr[&quot;cookieTxt2&quot;] = &quot;Cookies enable you to personalize your experience on our site, tell us which parts of our websites people have visited, help us measure the effectiveness of ads and web searches, and give us insights into user behavior so we can improve our communications and products.&quot;;
$langStr[&quot;cookieTxt3&quot;] = &quot;More information&quot;;
$langStr[&quot;cookieTxt4&quot;] = &quot;Accept All Cookies&quot;;
$langStr[&quot;cookieTxt5&quot;] = &quot;Customise Cookies&quot;;
$langStr[&quot;cookieTxt6&quot;] = &quot;Select cookies to accept&quot;;
$langStr[&quot;cookieTxt7&quot;] = &quot;Necessary&quot;;
$langStr[&quot;cookieTxt8&quot;] = &quot;These are cookies that are essential for the website to work correctly&quot;;
            </code>
        </pre>
        Y hacemos igual con el resto de idiomas.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir desusbribirse a emails clientes interesados
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_client` ADD COLUMN `no_molestar_cli` INT(1) NULL DEFAULT 0 AFTER `last_send_props_cli`;
            </code>
        </pre>
        <hr>
        En el archivo
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;div class=&quot;panel-body&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;panel-body&quot;&gt;

    &lt;?php
    $query_rsNomolestar = &quot;SELECT no_molestar_cli FROM properties_client WHERE id_cli = &quot;.$_GET[&#039;id_cli&#039;];
    $rsNomolestar = mysql_query($query_rsNomolestar, $inmoconn) or die(mysql_error());
    $row_rsNomolestar = mysql_fetch_assoc($rsNomolestar);


    if ($row_rsNomolestar[&#039;no_molestar_cli&#039;] == 1) { ?&gt;
      &lt;div class=&quot;alert alert-danger alert-block&quot;&gt;
          &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;alert&quot;&gt;&amp;times;&lt;/button&gt;
          &lt;?php __(&#039;Aviso no email&#039;) ?&gt;
      &lt;/div&gt;

    &lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="html">
$lang[&#039;Aviso no email&#039;] = &quot;Este comprador no quiere recibir m&aacute;s emails&quot;;
            </code>
        </pre>
        <hr>
        En el archivo
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="html">
$lang[&#039;Aviso no email&#039;] = &quot;This buyer doesn&#039;t want to receive any more emails&quot;;
            </code>
        </pre>
        <hr>
        En el archivo
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
$html = preg_replace(&#039;/{COLOR}/&#039;, $mailColor, $html);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{COLOR}/&#039;, $mailColor, $html);
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://vistacasas.com/&#039;.$langValuage.&#039;/unsubscribe/?id=&#039;.encryptIt($client[&#039;id_cli&#039;]), $html);
            </code>
        </pre>
        <hr>
        Copiar el archivo:
        <pre>
            <code class="makefile">
/includes/mailtemplates/template_semanal.html
            </code>
        </pre>
        <hr>
        Copiar el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/unsubscribe.php
            </code>
        </pre>
        <hr>
        Copiar el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/index.tpl
            </code>
        </pre>
        <hr>
        En el archivo
        <pre>
            <code class="makefile">
/index.php
            </code>
        </pre>
        Añadir al switch de urls:
        <pre>
            <code class="html">
case &#039;unsubscribe&#039;:
    $numpag = &quot;0&quot;;
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/unsubscribe.php&#039;);
    $smarty-&gt;assign(&quot;aviso&quot;, $aviso);
    $smarty-&gt;display(&#039;modules/mail_partials/index.tpl&#039;);
break;
            </code>
        </pre>
        <hr>
        En el archivo
        <pre>
            <code class="makefile">
/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="html">
$langStr[&quot;Unsubstxt&quot;] = &#039;Unsubscribe Successful&#039;;
$langStr[&quot;Unsubstxt2&quot;] = &#039;You will no longer receive email marketing from this list.&#039;;
            </code>
        </pre>
        Copiar los textos para el resto de idiomas
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i>  Ajustes exportador Idealista
    </h6>
    <div class="card-body">
        Sustituir el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
