<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 01-04-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>  Actualización parseador Kyero</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>  Actualización parseador ThinkSpain</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i>  Ajustes a la hora de borrar tipos</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Actualización parseador Kyero
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/_inc.parse_providers.php:123
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &apos;kyero.com&apos;) {
    $html = preg_replace(&apos;/\s+/&apos;, &quot; &quot;, trim($html));
    $nombreCons = get_string_between($html, &quot;Nombre: &lt;/strong&gt;&quot;, &apos;&lt;/li&gt;&apos;);
    $telefonoCons = get_string_between($html, &apos;Tel&#xe9;fono: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
    $emailCons = get_string_between($html, &apos;Email: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
    $referenciaCons = get_string_between($html, &apos;referencia: &lt;strong&gt;&apos;, &apos;&lt;/strong&gt;&apos;);
    $referenciaCons = strip_tags($referenciaCons);
    $linkCons = get_string_between($html, &apos;referencia: &lt;strong&gt;&lt;a href=&quot;&apos;, &apos;&quot;&gt;&apos;);
    $comentarioCons = get_string_between($html, &apos;Mensaje: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
    $idiomaCons = get_string_between($html, &apos;Idioma: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &apos;kyero.com&apos;) {
    $html = preg_replace(&apos;/\s+/&apos;, &quot; &quot;, trim($html));
    if ( strpos($email-&gt;header-&gt;details-&gt;subject, &apos;Enquiry about property ref/id&apos;) !== false) {
        $nombreCons = get_string_between($html, &quot;Name: &lt;/strong&gt;&quot;, &apos;&lt;/li&gt;&apos;);
        $telefonoCons = get_string_between($html, &apos;Telephone: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
        $emailCons = get_string_between($html, &apos;Email: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
        $referenciaCons = get_string_between($html, &apos;reference: &lt;strong&gt;&apos;, &apos;&lt;/strong&gt;&apos;);
        $referenciaCons = strip_tags($referenciaCons);
        $linkCons = get_string_between($html, &apos;reference: &lt;strong&gt;&lt;a href=&quot;&apos;, &apos;&quot;&gt;&apos;);
        $comentarioCons = get_string_between($html, &apos;Message: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
        $idiomaCons = get_string_between($html, &apos;Language: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
    } else {
        $nombreCons = get_string_between($html, &quot;Nombre: &lt;/strong&gt;&quot;, &apos;&lt;/li&gt;&apos;);
        $telefonoCons = get_string_between($html, &apos;Tel&#xe9;fono: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
        $emailCons = get_string_between($html, &apos;Email: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
        $referenciaCons = get_string_between($html, &apos;referencia: &lt;strong&gt;&apos;, &apos;&lt;/strong&gt;&apos;);
        $referenciaCons = strip_tags($referenciaCons);
        $linkCons = get_string_between($html, &apos;referencia: &lt;strong&gt;&lt;a href=&quot;&apos;, &apos;&quot;&gt;&apos;);
        $comentarioCons = get_string_between($html, &apos;Mensaje: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
        $idiomaCons = get_string_between($html, &apos;Idioma: &lt;/strong&gt;&apos;, &apos;&lt;/li&gt;&apos;);
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Actualización parseador ThinkSpain
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/_inc.parse_providers.php:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &apos;thinkspain.com&apos;) {
    $html = preg_replace(&apos;/\s+/&apos;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    if ( strpos($email-&gt;header-&gt;details-&gt;subject, &apos;Property enquiry Site Reference&apos;) !== false) {
        $nombreCons = get_string_between($html, &quot;Name: &quot;, &apos;&lt;br&gt;&apos;);
        $telefonoCons = get_string_between($html, &quot;Telephone: &quot;, &apos;&lt;br&gt;&apos;);
        $emailCons = get_string_between($html, &quot;Email: &quot;, &apos;&lt;br&gt;&apos;);
        $referenciaCons = get_string_between($html, &quot;Your Reference &quot;, &apos;)&apos;);
        $linkCons = get_string_between($html, &apos;Link: &apos;, &apos;&lt;br&gt;&apos;);
        $comentarioCons = get_string_between($html, &quot;Message:&lt;br&gt;&quot;, &apos;&lt;br&gt;&lt;br&gt;&apos;);
        $idiomaCons = get_string_between($html, &apos;Website Language: &apos;, &apos;&lt;br&gt;&apos;);
    } else {
        $nombreCons = get_string_between($html, &quot;Name: &quot;, &apos;&lt;br&gt;&apos;);
        $telefonoCons = get_string_between($html, &quot;Telephone: &quot;, &apos;&lt;br&gt;&apos;);
        $emailCons = get_string_between($html, &quot;Email: &quot;, &apos;&lt;br&gt;&apos;);
        $referenciaCons = get_string_between($html, &quot;Property Ref. &quot;, &apos; -&apos;);
        $linkCons = get_string_between($html, &apos; - &apos;, &apos;&lt;br&gt;&lt;br&gt;&apos;);
        $comentarioCons = get_string_between($html, &quot;A &quot;, &apos;:&apos;);
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &apos;thinkspain.com&apos;) {
    $html = preg_replace(&apos;/\s+/&apos;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    if ( strpos($email-&gt;header-&gt;details-&gt;subject, &apos;Property enquiry Site Reference&apos;) !== false) {
        $nombreCons = get_string_between($html, &quot;Name: &quot;, &apos;&lt;br&gt;&apos;);
        $telefonoCons = get_string_between($html, &quot;Telephone: &quot;, &apos;&lt;br&gt;&apos;);
        $emailCons = get_string_between($html, &quot;Email: &quot;, &apos;&lt;br&gt;&apos;);
        $referenciaCons = get_string_between($html, &quot;Your Reference &quot;, &apos;)&apos;);
        $linkCons = get_string_between($html, &apos;Link: &apos;, &apos;&lt;br&gt;&apos;);
        $comentarioCons = get_string_between($html, &quot;Message:&lt;br&gt;&quot;, &apos;&lt;br&gt;&lt;br&gt;&apos;);
        $idiomaCons = get_string_between($html, &apos;Website Language: &apos;, &apos;&lt;br&gt;&apos;);
    } else if ( strpos($email-&gt;header-&gt;details-&gt;subject, &apos;Similar Property Search Enquiry&apos;) !== false) {
        $nombreCons = get_string_between($html, &quot;Name: &quot;, &apos;&lt;br&gt;&apos;);
        $telefonoCons = get_string_between($html, &quot;Telephone: &quot;, &apos;&lt;br&gt;&apos;);
        $emailCons = get_string_between($html, &quot;E-mail: &quot;, &apos;&lt;br&gt;&apos;);
        $referenciaCons = get_string_between($html, &quot;Your Reference: &quot;, &apos;&lt;br&gt;&apos;);
        $linkCons = get_string_between($html, &apos;Property Reference: &lt;a href=&quot;&apos;, &apos;&quot;&apos;);
        $comentarioCons = get_string_between($html, &quot;Message:&lt;br&gt;&quot;, &apos;&lt;br&gt;&lt;br&gt;&apos;);
        $idiomaCons = get_string_between($html, &apos;LANGUAGE: &lt;strong&gt;&apos;, &apos; : &apos;);
    } else if ( strpos($email-&gt;header-&gt;details-&gt;subject, &apos;Bitte um Information bez&#xfc;glich des Objekts&apos;) !== false) {
        $nombreCons = get_string_between($html, &quot;Name: &quot;, &apos;&lt;br&gt;&apos;);
        $telefonoCons = get_string_between($html, &quot;Telefon: &quot;, &apos;&lt;br&gt;&apos;);
        $emailCons = get_string_between($html, &quot;E-mail: &quot;, &apos;&lt;br&gt;&apos;);
        $referenciaCons = get_string_between($html, &quot;Ihre Referenz &quot;, &apos;)&apos;);
        $linkCons = get_string_between($html, &apos;Link: &lt;a href=&quot;&apos;, &apos;&quot;&apos;);
        $comentarioCons = get_string_between($html, &quot;Nachricht:&lt;br&gt;&quot;, &apos;&lt;br&gt;&lt;br&gt;&apos;);
        $idiomaCons = get_string_between($html, &apos;SPRACHE: &lt;strong&gt;&apos;, &apos; : &apos;);
    } else {
        $nombreCons = get_string_between($html, &quot;Name: &quot;, &apos;&lt;br&gt;&apos;);
        $telefonoCons = get_string_between($html, &quot;Telephone: &quot;, &apos;&lt;br&gt;&apos;);
        $emailCons = get_string_between($html, &quot;Email: &quot;, &apos;&lt;br&gt;&apos;);
        $referenciaCons = get_string_between($html, &quot;Property Ref. &quot;, &apos; -&apos;);
        $linkCons = get_string_between($html, &apos; - &apos;, &apos;&lt;br&gt;&lt;br&gt;&apos;);
        $comentarioCons = get_string_between($html, &quot;A &quot;, &apos;:&apos;);
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes a la hora de borrar tipos
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/types-form.php:141
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// $del_properties_types-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_CheckDetail&quot;, 40);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$del_properties_types-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_CheckDetail&quot;, 40);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>