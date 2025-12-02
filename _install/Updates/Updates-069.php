<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 27-03-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>  Ajustes a las propiedades similares</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>  Añadido recaptcha a formulario de vender</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i>  Error con las imágenes en la importación</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i>  Error en la vista de propiedades Duplicadas</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i>  Añadidos nuevos parseadores de consultas: Think Spain, Green Acres, Idealista y Costa del Home</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes a las propiedades similares
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/property.php:470
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
if ($similares[2][&apos;id_prop&apos;] == &apos;&apos;) {
    $similares = getRecords(sprintf($similaresQuery, &quot;&quot;));
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/similar-properties.php:95
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
if ($similarProp[2][&apos;id_prop&apos;] == &apos;&apos;) {
    $similarProp = getRecords(sprintf($similarPropQuery, &quot; &quot;));
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/enquiry.php:101
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/modules/mail_partials/similar-properties.php&apos;);
if($similaresContent != &quot;&quot;){
    $body2 = &quot;&quot;;
    $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Gracias por contactarnos&quot;].&quot;.&lt;/p&gt;&quot;;
    $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;].&quot;: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot;. &quot;.$langStr[&quot;Uno de nuestros agentes se pondr&#xe1; en contacto con usted lo antes posible&quot;].&quot;.&lt;/p&gt;&quot;;

    $body2 .= $prop_enqu;
    $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&#xf3;n de propiedades similares, esto puede ser de su inter&#xe9;s&quot;].&quot;.&lt;/p&gt;&quot;;
    $body2 .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 10px; background: &quot;.$mailColor.&quot;; text-align: center; text-transform: uppercase;color: #fff\&quot;&gt;&quot;.$langStr[&quot;Propiedades similares&quot;].&quot;&lt;/h4&gt;&quot;;
    $body2 .= $similaresContent;

    ob_start();
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/mailtemplates/template.html&apos;);
    $html2 = ob_get_contents();
    ob_end_clean();

    $html2 = preg_replace(&apos;/{SERVER.HTTP_HOST}/&apos;, $_SERVER[&apos;HTTP_HOST&apos;], $html2);
    $html2 = preg_replace(&apos;/{CONTENT}/&apos;, $body2 , $html2);
    $html2 = preg_replace(&apos;/{FOOTER}/&apos;, $textMailTempl, $html2);
    $html2 = preg_replace(&apos;/{COLOR}/&apos;, $mailColor, $html2);

    $subject = $langStr[&quot;Propiedad&quot;].&quot; Ref: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot; - &quot; . $_SERVER[&apos;HTTP_HOST&apos;];

    sendAppEmail(array($_GET[&apos;email&apos;] =&gt; $_GET[&apos;name&apos;]), &apos;&apos;, &apos;&apos;, array($fromMail =&gt; $fromName), $subject, $html2);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($opcionSimilares == 1) {
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/modules/mail_partials/similar-properties.php&apos;);
    if($similaresContent != &quot;&quot;){
        $body2 = &quot;&quot;;
        $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Gracias por contactarnos&quot;].&quot;.&lt;/p&gt;&quot;;
        $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;].&quot;: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot;. &quot;.$langStr[&quot;Uno de nuestros agentes se pondr&#xe1; en contacto con usted lo antes posible&quot;].&quot;.&lt;/p&gt;&quot;;

        $body2 .= $prop_enqu;
        $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&#xf3;n de propiedades similares, esto puede ser de su inter&#xe9;s&quot;].&quot;.&lt;/p&gt;&quot;;
        $body2 .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 10px; background: &quot;.$mailColor.&quot;; text-align: center; text-transform: uppercase;color: #fff\&quot;&gt;&quot;.$langStr[&quot;Propiedades similares&quot;].&quot;&lt;/h4&gt;&quot;;
        $body2 .= $similaresContent;

        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/mailtemplates/template.html&apos;);
        $html2 = ob_get_contents();
        ob_end_clean();

        $html2 = preg_replace(&apos;/{SERVER.HTTP_HOST}/&apos;, $_SERVER[&apos;HTTP_HOST&apos;], $html2);
        $html2 = preg_replace(&apos;/{CONTENT}/&apos;, $body2 , $html2);
        $html2 = preg_replace(&apos;/{FOOTER}/&apos;, $textMailTempl, $html2);
        $html2 = preg_replace(&apos;/{COLOR}/&apos;, $mailColor, $html2);

        $subject = $langStr[&quot;Propiedad&quot;].&quot; Ref: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot; - &quot; . $_SERVER[&apos;HTTP_HOST&apos;];

        sendAppEmail(array($_GET[&apos;email&apos;] =&gt; $_GET[&apos;name&apos;]), &apos;&apos;, &apos;&apos;, array($fromMail =&gt; $fromName), $subject, $html2);
    }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/bajada.php:71
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/modules/mail_partials/similar-properties.php&apos;);
if($similaresContent != &quot;&quot;){
    $body2 = &quot;&quot;;
    $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Gracias por contactarnos&quot;].&quot;.&lt;/p&gt;&quot;;
    $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;].&quot;: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot;.&lt;/p&gt;&quot;;

    $body2 .= $prop_enqu;
    $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&#xf3;n de propiedades similares, esto puede ser de su inter&#xe9;s&quot;].&quot;.&lt;/p&gt;&quot;;
    $body2 .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 10px; background: &quot;.$mailColor.&quot;; text-align: center; text-transform: uppercase;color: #fff\&quot;&gt;&quot;.$langStr[&quot;Propiedades similares&quot;].&quot;&lt;/h4&gt;&quot;;
    $body2 .= $similaresContent;

    ob_start();
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/mailtemplates/template.html&apos;);
    $html2 = ob_get_contents();
    ob_end_clean();

    $html2 = preg_replace(&apos;/{SERVER.HTTP_HOST}/&apos;, $_SERVER[&apos;HTTP_HOST&apos;], $html2);
    $html2 = preg_replace(&apos;/{CONTENT}/&apos;, $body2 , $html2);
    $html2 = preg_replace(&apos;/{FOOTER}/&apos;, $textMailTempl, $html2);
    $html2 = preg_replace(&apos;/{COLOR}/&apos;, $mailColor, $html2);

    $subject = $langStr[&quot;Propiedad&quot;].&quot; Ref: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot; - &quot; . $_SERVER[&apos;HTTP_HOST&apos;];

    sendAppEmail(array($_GET[&apos;emailbj&apos;] =&gt; $_GET[&apos;namebj&apos;]), &apos;&apos;, &apos;&apos;, array($fromMail =&gt; $fromName), $subject, $html2);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($opcionSimilares == 1) {
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/modules/mail_partials/similar-properties.php&apos;);
    if($similaresContent != &quot;&quot;){
        $body2 = &quot;&quot;;
        $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Gracias por contactarnos&quot;].&quot;.&lt;/p&gt;&quot;;
        $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;].&quot;: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot;.&lt;/p&gt;&quot;;

        $body2 .= $prop_enqu;
        $body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&#xf3;n de propiedades similares, esto puede ser de su inter&#xe9;s&quot;].&quot;.&lt;/p&gt;&quot;;
        $body2 .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 10px; background: &quot;.$mailColor.&quot;; text-align: center; text-transform: uppercase;color: #fff\&quot;&gt;&quot;.$langStr[&quot;Propiedades similares&quot;].&quot;&lt;/h4&gt;&quot;;
        $body2 .= $similaresContent;

        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/mailtemplates/template.html&apos;);
        $html2 = ob_get_contents();
        ob_end_clean();

        $html2 = preg_replace(&apos;/{SERVER.HTTP_HOST}/&apos;, $_SERVER[&apos;HTTP_HOST&apos;], $html2);
        $html2 = preg_replace(&apos;/{CONTENT}/&apos;, $body2 , $html2);
        $html2 = preg_replace(&apos;/{FOOTER}/&apos;, $textMailTempl, $html2);
        $html2 = preg_replace(&apos;/{COLOR}/&apos;, $mailColor, $html2);

        $subject = $langStr[&quot;Propiedad&quot;].&quot; Ref: &quot;.$row_rsRef[&apos;referencia_prop&apos;].&quot; - &quot; . $_SERVER[&apos;HTTP_HOST&apos;];

        sendAppEmail(array($_GET[&apos;emailbj&apos;] =&gt; $_GET[&apos;namebj&apos;]), &apos;&apos;, &apos;&apos;, array($fromMail =&gt; $fromName), $subject, $html2);
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido recaptcha a formulario de vender
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/vender/view/index.tpl:232
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
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
/modules/vender/send-quote.php:19
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (isset($_GET[$antiSpam]) &amp;&amp; $_GET[$antiSpam] == &apos;&apos;) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$recaptcha = $_GET[&quot;g-recaptcha-response&quot;];
$url = &apos;https://www.google.com/recaptcha/api/siteverify&apos;;
$data = array(
    &apos;secret&apos; =&gt; $google_captcha_privatekey,
    &apos;response&apos; =&gt; $recaptcha
);
$options = array(
    &apos;http&apos; =&gt; array (
        &apos;method&apos; =&gt; &apos;POST&apos;,
        &apos;content&apos; =&gt; http_build_query($data)
    )
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

if ($captcha_success-&gt;success) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error con las imágenes en la importación
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils.php:448
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
$queryDeleteDisabledImages = &quot;DELETE FROM properties_images WHERE active_img = &apos;0&apos; AND property_img = &apos;&quot;.$propertyID.&quot;&apos; &quot;;
mysql_query($queryDeleteDisabledImages, $inmoconn) or die(mysql_error());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en la vista de propiedades Duplicadas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/duplicates.php:54
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE activado_prop = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE activado_prop = 1 AND force_hide_prop = 0
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadidos nuevos parseadores de consultas: Think Spain, Green Acres, Idealista y Costa del Home
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/email.php:91
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$idPortalThinkSpain = &apos;&apos;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$idPortalThinkSpain = &apos;&apos;;
$idPortalgreenAcres = &apos;&apos;;
$idPortalIdealista = &apos;&apos;;
$idCostaDelHome = &apos;&apos;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/_inc.parse_providers.php:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$providers = array(&apos;todopisosalicante.com&apos;, &apos;envios.ventadepisos.com&apos;, &apos;granmanzana.es&apos;, &apos;moveagain.co.uk&apos;, &apos;vivados.es&apos;, &apos;kyero.com&apos;, &apos;rightmove.co.uk&apos;, &apos;thinkspain.com&apos;, &apos;email.green-acres.com&apos;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$providers = array(&apos;todopisosalicante.com&apos;, &apos;envios.ventadepisos.com&apos;, &apos;granmanzana.es&apos;, &apos;moveagain.co.uk&apos;, &apos;vivados.es&apos;, &apos;kyero.com&apos;, &apos;rightmove.co.uk&apos;, &apos;thinkspain.com&apos;, &apos;email.green-acres.com&apos;, &apos;idealista.com&apos;, &apos;costadelhome.com&apos;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/_inc.parse_providers.php:135
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$nombreCons = trim($nombreCons);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &apos;email.green-acres.com&apos;) {
    $html = preg_replace(&apos;/\s+/&apos;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, &quot;Contact name&lt;/td&gt; &lt;td class=\&quot;data-value\&quot; style=\&quot;text-align: left;padding: 10px;background-color: #ffffff;\&quot;&gt;&quot;, &apos;&lt;/td&gt;&apos;);
    $telefonoCons = get_string_between($html, &apos;Phone&lt;/td&gt; &lt;td style=&quot;text-align: left;padding: 10px;background-color: #ffffff;&quot;&gt;&apos;, &apos;&lt;/td&gt;&apos;);
    $emailCons = get_string_between($html, &apos;E-mail&lt;/td&gt; &lt;td class=&quot;data-value&quot; style=&quot;text-align: left;padding: 10px;background-color: #ffffff;&quot;&gt;&apos;, &apos;&lt;/td&gt;&apos;);
    $referenciaCons = str_replace(&apos;43453a-&apos;, &apos;&apos;, get_string_between($html, &apos;R&amp;#233;f. &apos;, &apos;&lt;/td&gt;&apos;));
    $referenciaCons = strip_tags($referenciaCons);
    $linkCons = get_string_between($html, &apos;has seen your property &lt;a href=\&apos;&apos;, &apos;\&apos;&gt;&apos;);
    $comentarioCons = get_string_between($html, &apos;Message&lt;/td&gt; &lt;td class=&quot;data-value&quot; style=&quot;text-align: left;padding: 10px;background-color: #ffffff;&quot;&gt;&apos;, &apos;&lt;/td&gt;&apos;);
    $idiomaCons = get_string_between($html, &apos;Idioma: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
}

if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &apos;idealista.com&apos;) {
    $html = preg_replace(&apos;/\s+/&apos;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, &quot;&lt;p style=\&quot;margin:0;color:#474744;\&quot;&gt; &lt;strong&gt;&quot;, &apos;&lt;/strong&gt;&apos;);
    $emailCons = get_string_between($html, &apos; href=&quot;mailto:&apos;, &apos;&quot;&apos;);
    $referenciaCons = get_string_between($html, &apos;(Ref. &apos;, &apos;&lt;/span&gt;&apos;);
    $linkCons = get_string_between($html, &apos;decoration: none !important;&quot; href=&quot;&apos;, &apos;&quot;&gt;&apos;);
    $comentarioCons = get_string_between($html, &apos;&lt;div style=&quot;font-size:18px;background-color:white;display:inline-block;margin-top:0;padding: 10px;&quot;&gt; &apos;, &apos;&lt;/div&gt;&apos;);
}

if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &apos;costadelhome.com&apos;) {
    $html = preg_replace(&apos;/\s+/&apos;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, &quot;Name: &lt;/td&gt; &lt;td class=\&quot;value\&quot; style=&apos;font-family: \&quot;Helvetica Neue\&quot;, Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;&apos; valign=\&quot;top\&quot;&gt; &quot;, &apos; &lt;/td&gt;&apos;);
    $telefonoCons = get_string_between($html, &apos;Phone: &lt;/td&gt; &lt;td class=&quot;value&quot; style=\&apos;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;\&apos; valign=&quot;top&quot;&gt; &apos;, &apos; &lt;/td&gt;&apos;);
    $emailCons = get_string_between($html, &apos;Email: &lt;/td&gt; &lt;td class=&quot;value&quot; style=\&apos;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;\&apos; valign=&quot;top&quot;&gt; &apos;, &apos; &lt;/td&gt;&apos;);
    $referenciaCons = get_string_between($html, &apos;style=&quot;color: #0088CC; text-decoration: underline;&quot;&gt;&apos;, &apos;&lt;/a&gt;&apos;);
    $linkCons = get_string_between($html, &apos;reference: &lt;a target=&quot;_blank&quot; href=&quot;&apos;, &apos;&quot;&apos;);
    $comentarioCons = get_string_between($html, &apos;Message: &lt;/td&gt; &lt;td class=&quot;value message&quot; style=\&apos;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 7px 0;\&apos; valign=&quot;top&quot;&gt; &lt;p style=&quot;line-height: 1.5; color: #151515; margin: 0 0 8px;&quot;&gt;&apos;, &apos;&lt;/p&gt; &lt;/td&gt;&apos;);
    $idiomaCons = get_string_between($html, &apos;Language: &lt;/td&gt; &lt;td class=&quot;value&quot; style=\&apos;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;\&apos; valign=&quot;top&quot;&gt; &apos;, &apos; &lt;/td&gt;&apos;);
}

$nombreCons = trim($nombreCons);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/add-client.php:27
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case &apos;thinkspain.com&apos;:
    $source = $idPortalThinkSpain;
    break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case &apos;thinkspain.com&apos;:
    $source = $idPortalThinkSpain;
    break;
case &apos;email.green-acres.com&apos;:
    $source = $idPortalgreenAcres;
    break;
case &apos;idealista.com&apos;:
    $source = $idPortalIdealista;
    break;
case &apos;costadelhome.com&apos;:
    $source = $idCostaDelHome;
    break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/update-client.php:33
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case &apos;thinkspain.com&apos;:
        $source = $idPortalThinkSpain;
        break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case &apos;thinkspain.com&apos;:
    $source = $idPortalThinkSpain;
    break;
case &apos;email.green-acres.com&apos;:
    $source = $idPortalgreenAcres;
    break;
case &apos;idealista.com&apos;:
    $source = $idPortalIdealista;
    break;
case &apos;costadelhome.com&apos;:
    $source = $idCostaDelHome;
    break;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>