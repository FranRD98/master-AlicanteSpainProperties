<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 16-11-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error enviar propiedades a cliente</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes SEO varios</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Corregido error HTACCESS provocado por FIX SQL INJECTION</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Añadir Canonial en el HEAD</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Error Metatítulo Zonas-Ciudades</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Error en HREFLANG</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Error feed Kyero</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error enviar propiedades a cliente
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:444
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
alert($(&apos;#idioma_cli&apos;).val());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes SEO varios
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:671
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 6;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 6;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:705
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 9;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 9;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:717
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 10;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 10;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:724
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 15;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 15;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:737
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 16;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 16;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:745
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 17;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 17;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:753
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 18;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 18;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:773
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case &apos;logout&apos;:
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case &apos;logout&apos;:
        $smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:788
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 23;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 23;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:795
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 78;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 78;
$smarty-&gt;assign(&quot;noIndex&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;meta name=&quot;theme-color&quot; content=&quot;#ffffff&quot; /&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;meta name=&quot;theme-color&quot; content=&quot;#ffffff&quot; /&gt;

{if $noIndex == 1}&lt;meta name=&apos;robots&apos; content=&apos;noindex&apos;&gt;{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/add-fav.php:8
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/tng/tNG.inc.php&apos;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/tng/tNG.inc.php&apos;);

if(empty($_SERVER[&apos;HTTP_X_REQUESTED_WITH&apos;]) || strtolower($_SERVER[&apos;HTTP_X_REQUESTED_WITH&apos;]) != &apos;xmlhttprequest&apos;) {
    echo &quot;&lt;meta name=&apos;robots&apos; content=&apos;noindex&apos;&gt;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/rem-fav.php:6
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/tng/tNG.inc.php&apos;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/tng/tNG.inc.php&apos;);

if(empty($_SERVER[&apos;HTTP_X_REQUESTED_WITH&apos;]) || strtolower($_SERVER[&apos;HTTP_X_REQUESTED_WITH&apos;]) != &apos;xmlhttprequest&apos;) {
    echo &quot;&lt;meta name=&apos;robots&apos; content=&apos;noindex&apos;&gt;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/rem-fav2.php:8
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/tng/tNG.inc.php&apos;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/includes/tng/tNG.inc.php&apos;);

if(empty($_SERVER[&apos;HTTP_X_REQUESTED_WITH&apos;]) || strtolower($_SERVER[&apos;HTTP_X_REQUESTED_WITH&apos;]) != &apos;xmlhttprequest&apos;) {
    echo &quot;&lt;meta name=&apos;robots&apos; content=&apos;noindex&apos;&gt;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/robots.txt
            </code>
        </pre>
        Sustituir todo por:
        <pre>
            <code class="php">
User-agent: *
Disallow: /Connections
Disallow: /includes
Disallow: /intramedianet
Disallow: /wheather
Disallow: /resources
Disallow: /media/files
Disallow: /xml
Disallow: /templates
Disallow: /modules
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Corregido error HTACCESS provocado por FIX SQL INJECTION
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/.htaccess:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
ServerSignature Off
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
RewriteCond %{QUERY_STRING} ^(.*)(\[\])(.*) [NC]
RewriteRule ^(.*)$ $1?%1\%5B\%5D%3 [NE,L,R=301]

ServerSignature Off
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir Canonial en el HEAD
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:621
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($_GET[&apos;idquick&apos;] != &apos;&apos;) {
    $numpag = $_GET[&apos;idquick&apos;];
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/modules/inicio/inicio.php&apos;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($_GET[&apos;idquick&apos;] != &apos;&apos;) {
    $numpag = $_GET[&apos;idquick&apos;];
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/modules/inicio/inicio.php&apos;);
} else {
    $smarty-&gt;assign(&quot;addCanonical&quot;, 1);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:638
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 85;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 85;
$smarty-&gt;assign(&quot;addCanonical&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:687
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$numpag = 7;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$numpag = 7;
$smarty-&gt;assign(&quot;addCanonical&quot;, 1);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:848
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;seccion&quot;, $urlStr[&apos;properties&apos;][&apos;url&apos;]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;addCanonical&quot;, 1);
$smarty-&gt;assign(&quot;seccion&quot;, $urlStr[&apos;properties&apos;][&apos;url&apos;]);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $noIndex == 1}&lt;meta name=&apos;robots&apos; content=&apos;noindex&apos;&gt;{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $noIndex == 1}&lt;meta name=&apos;robots&apos; content=&apos;noindex&apos;&gt;{/if}

{if $addDefaultURLCanonical == 1}
    &lt;link rel=&quot;canonical&quot; href=&quot;{if preg_match(&apos;/https?/&apos;,{$url{$lang|upper}}) }{$url{$lang|upper}|replace:&apos;http://&apos;:&apos;https://&apos;}{else}https://{$smarty.server.HTTP_HOST}{$url{$lang|upper}}{/if}&quot; /&gt;
{else if $addCanonical == 1 }
    &lt;link rel=&quot;canonical&quot; href=&quot;https://{$smarty.server.HTTP_HOST}{$urlStart}{$seccion}/&quot; /&gt;
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Error Metatítulo Zonas-Ciudades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/ciudades/properties.php:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($news[0][&apos;titulow&apos;] != &apos;&apos;) {
    $title = $news[0][&apos;titulow&apos;];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($news[0][&apos;titulometa&apos;] != &apos;&apos;) {
    $title = $news[0][&apos;titulometa&apos;];
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="Seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en HREFLANG
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:39
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if count($languages) &gt; 1}
    {foreach from=$languages item=idm}
        {if $idm != $language}
        &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{$smarty.server.REQUEST_SCHEME}://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}&quot; /&gt;
        {else}
        &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{$smarty.server.REQUEST_SCHEME}://{$smarty.server.HTTP_HOST}{$urlDefault}&quot; /&gt;
        {/if}
    {/foreach}
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if count($languages) &gt; 1}
    {foreach from=$languages item=idm}
        {if $idm != $language}
            &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{if {preg_match pattern=&apos;http&apos; subject={$url{$idm|upper}}}}{{$url{$idm|upper}}|replace:&apos;http:&apos;:&apos;https:&apos;}{else}https://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}{/if}&quot; /&gt;
        {else}
            &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{if {preg_match pattern=&apos;http&apos; subject=$urlDefault}}{$urlDefault|replace:&apos;http:&apos;:&apos;https:&apos;}{else}https://{$smarty.server.HTTP_HOST}{$urlDefault|replace:&apos;http:&apos;:&apos;https:&apos;}{/if}&quot; /&gt;
        {/if}
    {/foreach}
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Error feed Kyero
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/kyero.php:9
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsXML = mysql_num_rows($rsXML);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsXML = mysql_num_rows($rsXML);

if ($row_rsXML[&apos;id_exp&apos;] == &apos;&apos;) {
    die();
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>