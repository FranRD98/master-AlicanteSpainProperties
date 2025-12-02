<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 8 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 02-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Posibilidad de enviar consultas por Whatsapp</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Bug en criterios de búsqueda al filtrar y seleccionar por datatables</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Search criteria: no mostrar nunca propiedades vendidas para enviar</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Campo email en compradores y vendedores eliminar espacios en blanco</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Plantilla de emails: mostrar referencia y niveles 3 - 4 de los inmuebles</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Añadido recaptcha en los formularios de Contacto</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i>  En el listado y búsqueda avanzada de propiedades no se muestra el nombre del propietario ni el teléfono si no esta el segundo campo completado</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i>  La última propiedad en la lista de propiedades no permite ver los Tooltips de los círculos</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Posibilidad de enviar consultas por Whatsapp
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/bar-responsiva.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Activar botones Whatsapp */
/*--------------------------------------------------------------------------
|
| Activar los botones de Whatsapp
| 0 - Desactivado
| 1 - Activado
|
*/

$actWhatsapp = 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:135
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;thumbnailsSizes&quot;, $thumbnailsSizes);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;thumbnailsSizes&quot;, $thumbnailsSizes);
$smarty-&gt;assign(&quot;actWhatsapp&quot;, $actWhatsapp);
            </code>
        </pre>
        <hr>
        Añadir a los archivos de texto: <code>/resources/lang_*.php</code>, los siguientes textos:
        <pre>
            <code class="php">
da -> $langStr["Estoy interesado en esta propiedad"] = "Jeg er interesseret i denne ejendom";
de -> $langStr["Estoy interesado en esta propiedad"] = "Ich bin an dieser Immobilie interessiert";
en -> $langStr["Estoy interesado en esta propiedad"] = "I am interested in this property";
es -> $langStr["Estoy interesado en esta propiedad"] = "Estoy interesado en esta propiedad";
fi -> $langStr["Estoy interesado en esta propiedad"] = "Olen kiinnostunut tästä omaisuudesta";
fr -> $langStr["Estoy interesado en esta propiedad"] = "Je suis intéressé par cette propriété";
is -> $langStr["Estoy interesado en esta propiedad"] = "Ég hef áhuga á þessari eign";
nl -> $langStr["Estoy interesado en esta propiedad"] = "Ik ben geïnteresseerd in deze woning";
no -> $langStr["Estoy interesado en esta propiedad"] = "Jeg er interessert i denne eiendommen";
ru -> $langStr["Estoy interesado en esta propiedad"] = "Я интересуюсь этим свойством";
sv -> $langStr["Estoy interesado en esta propiedad"] = "Jag är intresserad av den här egenskapen";
zh -> $langStr["Estoy interesado en esta propiedad"] = "我对这家酒店感兴趣";
            </code>
        </pre>
        <pre>
            <code class="php">
da -> $langStr["Contactar por Whatsapp"] = "Kontakt af Whatsapp";
de -> $langStr["Contactar por Whatsapp"] = "Kontakt durch WhatsApp";
en -> $langStr["Contactar por Whatsapp"] = "Contact using Whatsapp";
es -> $langStr["Contactar por Whatsapp"] = "Contactar por Whatsapp";
fi -> $langStr["Contactar por Whatsapp"] = "Yhteystiedot Whatsapp";
fr -> $langStr["Contactar por Whatsapp"] = "Contact par Whatsapp";
is -> $langStr["Contactar por Whatsapp"] = "Hafa samband við Whatsapp";
nl -> $langStr["Contactar por Whatsapp"] = "Contact door Whatsapp";
no -> $langStr["Contactar por Whatsapp"] = "Kontakt av Whatsapp";
ru -> $langStr["Contactar por Whatsapp"] = "Как связаться с Whatsapp";
sv -> $langStr["Contactar por Whatsapp"] = "Kontakt av Whatsapp";
zh -> $langStr["Contactar por Whatsapp"] = "由Whatsapp联系";
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/barra-responsiva.tpl:56
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;
    &lt;a href=&quot;#mobile-bottom-social&quot;&gt;
        &lt;i class=&quot;fa fa-share-alt&quot;&gt;&lt;/i&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $actWhatsapp == 1}
    {if $seccion == $url_property}
        &lt;li&gt;
             &lt;a target=&quot;_blank&quot; href=&quot;https://wa.me/{$phoneRespBar}/?text={&quot;{$lng_estoy_interesado_en_esta_propiedad}: {$property[0].ref}&quot;|escape:&#039;url&#039;}&quot;&gt;&lt;i class=&quot;fab fa-whatsapp&quot;&gt;&lt;/i&gt;&lt;/a&gt;
        &lt;/li&gt;
    {else}
        &lt;li&gt;
            &lt;a target=&quot;_blank&quot; href=&quot;https://wa.me/{$phoneRespBar}/&quot;|escape:&#039;url&#039;}&quot;&gt;&lt;i class=&quot;fab fa-whatsapp&quot;&gt;&lt;/i&gt;&lt;/a&gt;
        &lt;/li&gt;
    {/if}
{else}
&lt;li&gt;
    &lt;a href=&quot;#mobile-bottom-social&quot;&gt;
        &lt;i class=&quot;fa fa-share-alt&quot;&gt;&lt;/i&gt;
    &lt;/a&gt;
&lt;/li&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss:1756
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
.fab {
    padding: 10px;
    display: block;
    font-size: 20px;
    cursor: pointer;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss:1730
            </code>
        </pre>
        Eliminar y compilar:
        <pre>
            <code class="php">
.fab {
    padding: 10px;
    display: block;
    font-size: 20px;
    cursor: pointer;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/contactar.tpl
            </code>
        </pre>
        Añañdir al inicio y maquetar:
        <pre>
            <code class="php">
{if $actWhatsapp == 1}
    &lt;a target=&quot;_blank&quot; href=&quot;https://wa.me/{$phoneRespBar}/?text={&quot;{$lng_estoy_interesado_en_esta_propiedad}: {$property[0].ref}&quot;|escape:&#039;url&#039;}&quot;&gt;&lt;i class=&quot;fab fa-whatsapp&quot;&gt;&lt;/i&gt; {$lng_contactar_por_whatsapp}&lt;/a&gt;
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
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug en criterios de búsqueda al filtrar y eleccionar por datatables
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:442
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.btnsend&#039;).click(function(e) {
  e.preventDefault();
  if (!isValidEmailAddress($(&#039;#email_cli&#039;).val())) {
      alert(cliMailNo);
      return false;
  }
  if (!confirm(cliMailConf)) {
    return false;
  }
  var values = Array();
  var priceRegex = /([0-9]+)/;
  for (var i = 0; i &lt; selected.length; i++) {
      // var match = selected[i].match(priceRegex);
      // values.push(match[1]);
      values.push(selected[i]);
  }
  $(this).append(&#039;&lt;div class=&quot;loadingMail&quot;&gt;&#039;);
  values = values.join(&#039;,&#039;);
  $.ajax({
    type: &quot;GET&quot;,
    url: &quot;clients-send.php?ids=&quot;+values+&#039;&amp;email=&#039;+$(&#039;#email_cli&#039;).val()+&#039;&amp;comment=&#039;+$(&#039;#comment&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;tipo=1&amp;lang=&#039; + $(&#039;#idioma_cli&#039;).val() + &#039;&amp;usr=&#039; + idClient,
      cache: false
  }).done(function( data ) {
        if(data == &#039;ok&#039;) {
          alert(mensaSend);
          $(&#039;#form1 .loadingMail&#039;).remove();
        }
  });
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.btnsend&#039;).click(function(e) {
  e.preventDefault();
  if (!isValidEmailAddress($(&#039;#email_cli&#039;).val())) {
      alert(cliMailNo);
      return false;
  }
  if (!confirm(cliMailConf)) {
    return false;
  }
  sendLang = &#039;en&#039;;
  if ($(&#039;#idioma_cli&#039;).val() != &#039;&#039;) {
    sendLang = $(&#039;#idioma_cli&#039;).val();
  }
  var values = Array();
  var priceRegex = /([0-9]+)/;
  for (var i = 0; i &lt; selected.length; i++) {
      // var match = selected[i].match(priceRegex);
      // values.push(match[1]);
      values.push(selected[i]);
  }
  $(this).append(&#039;&lt;div class=&quot;loadingMail&quot;&gt;&#039;);
  values = values.join(&#039;,&#039;);
  $.ajax({
    type: &quot;GET&quot;,
    url: &quot;clients-send.php?ids=&quot;+values+&#039;&amp;email=&#039;+$(&#039;#email_cli&#039;).val()+&#039;&amp;comment=&#039;+$(&#039;#comment&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;tipo=1&amp;lang=&#039; + sendLang + &#039;&amp;usr=&#039; + idClient,
      cache: false
  }).done(function( data ) {
        if(data == &#039;ok&#039;) {
          alert(mensaSend);
          $(&#039;#form1 .loadingMail&#039;).remove();
        }
  });
});
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Search criteria: no mostrar nunca propiedades vendidas para enviar
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:611
/intramedianet/properties/properties-client-data-cli-intno.php:600
/intramedianet/properties/properties-client-data-cli-int.php:599
/intramedianet/properties/_count_news.php:621
/intramedianet/properties/_count_news2.php:668
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AND activado_prop = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0
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
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Campo email en compradores y vendedores eliminar espacios en blanco
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1106
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;email_cli&quot; id=&quot;email_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;email_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;email_cli&quot; id=&quot;email_cli&quot; value=&quot;&lt;?php echo trim(KT_escapeAttribute($row_rsproperties_client[&#039;email_cli&#039;])); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;email_pro&quot; id=&quot;email_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;email_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;email_pro&quot; id=&quot;email_pro&quot; value=&quot;&lt;?php echo trim(KT_escapeAttribute($row_rsproperties_owner[&#039;email_pro&#039;])); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
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
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Plantilla de emails: mostrar referencia y niveles 3 - 4 de los inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/property.php:101
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php echo $property[0][&#039;town&#039;] ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php echo $property[0][&#039;area&#039;] ?&gt; &middot; &lt;?php echo $property[0][&#039;town&#039;] ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/property.php:108
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php echo number_format($property[0][&#039;habitaciones_prop&#039;],0, &#039;,&#039;, &#039;.&#039;); ?&gt; &lt;?php echo $langStr[&quot;Habitaciones&quot;] ?&gt; // &lt;?php echo number_format($property[0][&#039;aseos_prop&#039;],0, &#039;,&#039;, &#039;.&#039;); ?&gt; &lt;?php echo $langStr[&quot;Ba&ntilde;os&quot;] ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php echo number_format($property[0][&#039;habitaciones_prop&#039;],0, &#039;,&#039;, &#039;.&#039;); ?&gt; &lt;?php echo $langStr[&quot;Habitaciones&quot;] ?&gt; // &lt;?php echo number_format($property[0][&#039;aseos_prop&#039;],0, &#039;,&#039;, &#039;.&#039;); ?&gt; &lt;?php echo $langStr[&quot;Ba&ntilde;os&quot;] ?&gt; // &lt;?php echo $langStr[&quot;Ref &quot;] ?&gt;.: &lt;?php echo $property[0][&#039;ref&#039;]; ?&gt;
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
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido recaptcha en los formularios de Contacto
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
{if $seccion == $url_property || $seccion == $url_favorites}
    &lt;script src=&#039;https://www.google.com/recaptcha/api.js?hl={$lang}&quot;&#039;&gt;&lt;/script&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script src=&#039;https://www.google.com/recaptcha/api.js?hl={$lang}&quot;&#039;&gt;&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/contact/view/index.tpl:35
templates/templates/partials/contact-foot.tpl:20
modules/property/view/partials/contactar.tpl:27
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;
&lt;div&gt;
    &lt;div class=&quot;g-recaptcha&quot; data-sitekey=&quot;{$google_captcha_sitekey}&quot;&gt;&lt;/div&gt;
    &lt;input type=&quot;hidden&quot; class=&quot;hiddenRecaptcha required&quot; name=&quot;hiddenRecaptcha&quot; id=&quot;hiddenRecaptcha&quot;&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/contact/send-quote.php:15
modules/property/enquiry.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$antiSpam = &quot;f&quot; . date(&quot;dmy&quot;);

if (isset($_GET[$antiSpam]) &amp;&amp; $_GET[$antiSpam] == &#039;&#039;) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$recaptcha = $_GET[&quot;g-recaptcha-response&quot;];
$url = &#039;https://www.google.com/recaptcha/api/siteverify&#039;;
$data = array(
    &#039;secret&#039; =&gt; $google_captcha_privatekey,
    &#039;response&#039; =&gt; $recaptcha
);
$options = array(
    &#039;http&#039; =&gt; array (
        &#039;method&#039; =&gt; &#039;POST&#039;,
        &#039;content&#039; =&gt; http_build_query($data)
    )
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

if ($captcha_success-&gt;success) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss
            </code>
        </pre>
        Añadir y compilar:
        <pre>
            <code class="php">
//  ============================================================================
//  /* @group reCAPTCHA */
//  ============================================================================

.g-recaptcha {
    width: 100px;
    height: 70px;
    max-width: 100%;
    transform:scale(0.7);
    transform-origin:0 0;
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
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> En el listado y búsqueda avanzada de propiedades no se muestra el nombre del propietario ni el teléfono si no esta el segundo campo completado
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data.php:529
/intramedianet/properties/properties-client-data-cli.php:589
/intramedianet/properties/properties-client-data-cli-intno.php:579
/intramedianet/properties/properties-client-data-cli-int.php:578
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CONCAT(nombre_pro, &#039; &#039;, apellidos_pro) as nombre_pro,
CONCAT(telefono_fijo_pro, &#039;&lt;br&gt;&#039;, telefono_movil_pro) as telefono_fijo_pro
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CONCAT_WS(&#039; &#039;, nombre_pro, apellidos_pro) as nombre_pro,
CONCAT_WS(&#039;&lt;br&gt;&#039;, telefono_fijo_pro, telefono_movil_pro) as telefono_fijo_pro
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-data.php:236
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CONCAT(properties_owner.nombre_pro, &#039; &#039; ,  properties_owner.apellidos_pro) as owner_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CONCAT_WS(&#039; &#039; , properties_owner.nombre_pro, properties_owner.apellidos_pro) as owner_prop,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> La última propiedad en la lista de propiedades no permite ver los Tooltips de los círculos
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data.php
            </code>
        </pre>
        Buscar y remplazar:
        <pre>
            <code class="php">
data-placement="bottom"
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
data-placement="top"
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>