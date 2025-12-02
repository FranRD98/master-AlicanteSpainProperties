<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 24-02-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadido enviar por Whatsapp</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes varios y correciones de bugs menores</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido enviar por Whatsapp
    </h6>
    <div class="card-body">

        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/interested-clients.php:16
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/nxt/KT_back.php&apos;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/nxt/KT_back.php&apos;);

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/mediaelx/functions.php&apos;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/interested-clients.php:351
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
echo &#039;&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btn-block btnsend&quot; data-email=&quot;&#039; . $value[&#039;email&#039;] . &#039;&quot; data-lang=&quot;&#039; . $langCli . &#039;&quot;&gt;&#039;.  __(&#039;Enviar&#039;, true) .&#039; &#039;.  __(&#039;Inmueble&#039;, true) .&#039;&lt;/a&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($value[&#039;telefono&#039;] != &#039;&#039;) {

    echo &quot;&lt;div class=\&quot;row\&quot;&gt;&quot;;

    echo &quot;&lt;div class=\&quot;col-md-6\&quot;&gt;&quot;;
}
echo &#039;&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btn-block btnsend&quot; data-email=&quot;&#039; . $value[&#039;email&#039;] . &#039;&quot; data-lang=&quot;&#039; . $langCli . &#039;&quot;&gt;&#039;.  __(&#039;Enviar&#039;, true) .&#039; &#039;.  __(&#039;Inmueble&#039;, true) .&#039;&lt;/a&gt;&#039;;

if ($value[&#039;telefono&#039;] != &#039;&#039;) {
    echo &quot;&lt;/div&gt;&quot;;

    echo &quot;&lt;div class=\&quot;col-md-6\&quot;&gt;&quot;;
    echo &#039;&lt;a href=&quot;https://wa.me/&#039; . $value[&#039;telefono&#039;] . &#039;/?text=https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . propURL($_GET[&#039;idpr&#039;], $lang_adm) . &#039;&quot; class=&quot;btn btn-success btn-block&quot; target=&quot;blank&quot;&gt;&#039;.  __(&#039;Whatsapp&#039;, true) .&#039;&lt;/a&gt;&#039;;
    echo &quot;&lt;/div&gt;&quot;;

    echo &quot;&lt;/div&gt;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js:787
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$.get(&#039;interested-clients.php?ref=&#039; + ref + &#039;&amp;pre=&#039; + pre + &#039;&amp;ope=&#039; + ope + &#039;&amp;typ=&#039; + typ + &#039;&amp;hab=&#039; + hab + &#039;&amp;ase=&#039; + ase + &#039;&amp;loc=&#039; + loc, function(data) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$.get(&#039;interested-clients.php?ref=&#039; + ref + &#039;&amp;pre=&#039; + pre + &#039;&amp;ope=&#039; + ope + &#039;&amp;typ=&#039; + typ + &#039;&amp;hab=&#039; + hab + &#039;&amp;ase=&#039; + ase + &#039;&amp;loc=&#039; + loc + &#039;&amp;idpr=&#039; + idProperty, function(data) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1045
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_fijo_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;telefono_fijo_cli&quot;&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;telefono_fijo_cli&quot; id=&quot;telefono_fijo_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_fijo_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_fijo_cli&quot;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_movil_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;telefono_movil_cli&quot;&gt;&lt;?php __(&#039;M&oacute;vil&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;telefono_movil_cli&quot; id=&quot;telefono_movil_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_movil_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_movil_cli&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_fijo_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;telefono_fijo_cli&quot;&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt;:&lt;/label&gt;
  &lt;input type=&quot;text&quot; name=&quot;telefono_fijo_cli&quot; id=&quot;telefono_fijo_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_fijo_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control number&quot;&gt;
  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_fijo_cli&quot;); ?&gt;
  &lt;a href=&quot;https://api.whatsapp.com/send/?phone=&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_fijo_cli&#039;]); ?&gt;&quot; class=&quot;btn btn-success btn-sm&quot; target=&quot;blank&quot;&gt;Whatsapp&lt;/a&gt; &lt;small style=&quot;display: inline-block&quot; class=&quot;help-block&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;?php __(&#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;); ?&gt;&lt;/small style=&quot;display: inline-block&quot;&gt;
&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_movil_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;telefono_movil_cli&quot;&gt;&lt;?php __(&#039;M&oacute;vil&#039;); ?&gt;:&lt;/label&gt;
  &lt;input type=&quot;text&quot; name=&quot;telefono_movil_cli&quot; id=&quot;telefono_movil_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_movil_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control number&quot;&gt;
  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_movil_cli&quot;); ?&gt;
  &lt;a href=&quot;https://api.whatsapp.com/send/?phone=&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_movil_cli&#039;]); ?&gt;&quot; class=&quot;btn btn-success btn-sm&quot; target=&quot;blank&quot;&gt;Whatsapp&lt;/a&gt; &lt;small style=&quot;display: inline-block&quot; class=&quot;help-block&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;?php __(&#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;); ?&gt;&lt;/small style=&quot;display: inline-block&quot;&gt;
&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2363
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsend&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsend&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btnsendwhatsapp&quot;&gt;Whatsapp: &lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2425
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btnwhatsapp&quot; target=&quot;_blank&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;: WhatsApp&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php
            </code>
        </pre>
        Añadir al final del archivo:
        <pre>
            <code class="php">
&lt;script&gt;
  $(&#039;.btnsendwhatsapp&#039;).click(function(e) {
      e.preventDefault();
      if ($(&#039;#telefono_fijo_cli&#039;).val() == &#039;&#039;) {
          alert(Nophone);
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
      values = values.join(&#039;,&#039;);

      var url =  &quot;clients-whatsapp.php?ids=&quot;+values+&#039;&amp;phone=&#039;+$(&#039;#telefono_fijo_cli&#039;).val()+&#039;&amp;comment=&#039;+encodeURIComponent($(&#039;#comment&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; ))+&#039;&amp;lang=&#039; + sendLang;

      window.open(url, &quot;whatsapp&quot;);
  });
  $(&#039;.btnwhatsapp&#039;).click(function(e) {
    e.preventDefault();
    if (!$(&#039;#telefono_fijo_cli&#039;).val()) {
        alert(Nophone);
        return false;
    }
    if ($(&#039;#messagemail&#039;).val() == &#039;&#039;) {
        alert(strFieldMessage);
        return false;
    }
    sendLang = &#039;en&#039;;
    if ($(&#039;#idioma_cli&#039;).val() != &#039;&#039;) {
      sendLang = $(&#039;#idioma_cli&#039;).val();
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
    values = values.join(&#039;,&#039;);

    var url =  &quot;get-links2.php?ids=&quot;+values+&#039;&amp;phone=&#039;+$(&#039;#telefono_fijo_cli&#039;).val()+&#039;&amp;comment=&#039;+encodeURIComponent($(&#039;#messagemail&#039;).val())+&#039;&amp;lang=&#039; + sendLang;

    window.open(url, &quot;whatsapp&quot;);
  });
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:666
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_fijo_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;telefono_fijo_pro&quot;&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;telefono_fijo_pro&quot; id=&quot;telefono_fijo_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;telefono_fijo_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_fijo_pro&quot;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_movil_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;telefono_movil_pro&quot;&gt;&lt;?php __(&#039;M&oacute;vil&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;telefono_movil_pro&quot; id=&quot;telefono_movil_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;telefono_movil_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_movil_pro&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_fijo_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;telefono_fijo_pro&quot;&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;telefono_fijo_pro&quot; id=&quot;telefono_fijo_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;telefono_fijo_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control number&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_fijo_pro&quot;); ?&gt;
     &lt;a href=&quot;https://api.whatsapp.com/send/?phone=&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;telefono_fijo_pro&#039;]); ?&gt;&quot; class=&quot;btn btn-success btn-sm&quot; target=&quot;blank&quot;&gt;Whatsapp&lt;/a&gt; &lt;small style=&quot;display: inline-block&quot; class=&quot;help-block&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;?php __(&#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;); ?&gt;&lt;/small style=&quot;display: inline-block&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_movil_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;telefono_movil_pro&quot;&gt;&lt;?php __(&#039;M&oacute;vil&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;telefono_movil_pro&quot; id=&quot;telefono_movil_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;telefono_movil_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control number&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;telefono_movil_pro&quot;); ?&gt;
     &lt;a href=&quot;https://api.whatsapp.com/send/?phone=&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;telefono_movil_pro&#039;]); ?&gt;&quot; class=&quot;btn btn-success btn-sm&quot; target=&quot;blank&quot;&gt;Whatsapp&lt;/a&gt; &lt;small style=&quot;display: inline-block&quot; class=&quot;help-block&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;?php __(&#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;); ?&gt;&lt;/small style=&quot;display: inline-block&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1320
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsend&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsend&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btnsendwhatsapp&quot;&gt;Whatsapp: &lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1391
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btnwhatsapp&quot; target=&quot;_blank&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;: WhatsApp&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php
            </code>
        </pre>
        Añadir al final del archivo:
        <pre>
            <code class="php">
&lt;script&gt;
  $(&#039;.btnsendwhatsapp&#039;).click(function(e) {
      e.preventDefault();
      if ($(&#039;#telefono_fijo_pro&#039;).val() == &#039;&#039;) {
          alert(Nophone);
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
      values = values.join(&#039;,&#039;);

      var url =  &quot;clients-whatsapp.php?ids=&quot;+values+&#039;&amp;phone=&#039;+$(&#039;#telefono_fijo_pro&#039;).val()+&#039;&amp;comment=&#039;+encodeURIComponent($(&#039;#comment&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; ))+&#039;&amp;lang=&#039; + sendLang;

      window.open(url, &quot;whatsapp&quot;);
  });
  $(&#039;.btnwhatsapp&#039;).click(function(e) {
    e.preventDefault();
    if (!$(&#039;#telefono_fijo_pro&#039;).val()) {
        alert(Nophone);
        return false;
    }
    if ($(&#039;#messagemail&#039;).val() == &#039;&#039;) {
        alert(strFieldMessage);
        return false;
    }
    sendLang = &#039;en&#039;;
    if ($(&#039;#idioma_cli&#039;).val() != &#039;&#039;) {
      sendLang = $(&#039;#idioma_cli&#039;).val();
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
    values = values.join(&#039;,&#039;);

    var url =  &quot;get-links2.php?ids=&quot;+values+&#039;&amp;phone=&#039;+$(&#039;#telefono_fijo_pro&#039;).val()+&#039;&amp;comment=&#039;+encodeURIComponent($(&#039;#messagemail&#039;).val())+&#039;&amp;lang=&#039; + sendLang;

    window.open(url, &quot;whatsapp&quot;);
  });
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        Añadir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-whatsapp.php
            </code>
        </pre>
        <hr>
        Añadir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/get-links2.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añade:
        <pre>
            <code class="php">
$lang[&#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;] = &#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añade:
        <pre>
            <code class="php">
$lang[&#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;] = &#039;Without + with country prefix and without spaces&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.js
            </code>
        </pre>
        Añade:
        <pre>
            <code class="php">
var Nophone = &#039;A&ntilde;ada un tel&eacute;fono v&aacute;lido&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.js
            </code>
        </pre>
        Añade:
        <pre>
            <code class="php">
var Nophone = &#039;Add a valid phone&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes varios y correciones de bugs menores</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes varios y correciones de bugs menores
    </h6>
    <div class="card-body">

        Ajustes varios y correciones de bugs menores

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


