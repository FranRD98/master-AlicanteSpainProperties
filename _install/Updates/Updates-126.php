<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 22-07-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Error en Tab-descargas</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Error en clients-send-search-criteria</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Fix borra traducciones al salvar</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> XML Kyero con todos los idiomas</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Falta la columna de registrado en el listado de clientes</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en Tab-descargas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
public_html/index.php:114
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;registerPlugin(&#039;modifier&#039;, &#039;mes&#039;, &#039;smarty_modifier_mes&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;registerPlugin(&#039;modifier&#039;, &#039;mes&#039;, &#039;smarty_modifier_mes&#039;);
$smarty-&gt;registerPlugin(&#039;modifier&#039;, &#039;getDownloadName&#039;, &#039;getDownloadName&#039;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en clients-send-search-criteria
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:12
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);

require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/acumbamail/acumbamail.class.php&#039; );
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:594
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$result = $acumba-&gt;sendOne($fromMailAlt, $_GET[&#039;email&#039;], $html, $subject);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$result = $acumba-&gt;sendOne($fromMailAlt, $client[&apos;email_cli&apos;], $html, $subject);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:609
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
die();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:612
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysqli_query($inmoconn,$query_emailSent, $inmoconn);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysqli_query($inmoconn,$query_emailSent);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix borra traducciones al salvar
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php:1090
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
return $langStr[preg_replace(&quot;/\.[^.]+$/&quot;, &quot;&quot;, basename($text))];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
return $langStr[&#039;pl&#039; . preg_replace(&quot;/\.[^.]+$/&quot;, &quot;&quot;, basename($text))];
            </code>
        </pre>
        <hr>
        Susutituir las traducciones:
        <pre>
            <code class="php">

// /resources/lang_ca.php

$langStr[&#039;0&#039;] = &#039;Planta baixa&#039;;
$langStr[&#039;1&#039;] = &#039;Planta 1&#039;;
$langStr[&#039;2&#039;] = &#039;Planta 2&#039;;
$langStr[&#039;3&#039;] = &#039;Planta 3&#039;;
$langStr[&#039;01&#039;] = &#039;Planta baixa + Planta 1&#039;;
$langStr[&#039;012&#039;] = &#039;Planta baixa + Planta 1 + Planta 2&#039;;
$langStr[&#039;G&#039;] = &#039;Soterrani&#039;;
$langStr[&#039;G0&#039;] = &#039;Soterrani + Planta baixa&#039;;
$langStr[&#039;G01&#039;] = &#039;Soterrani + Planta baixa + Planta 1&#039;;
$langStr[&#039;G012&#039;] = &#039;Soterrani + Planta baixa + Planta 1 + Planta 2&#039;;
$langStr[&#039;G01S&#039;] = &#039;Soterrani + Planta baixa + Planta 1 + Sol&agrave;rium&#039;;
$langStr[&#039;S&#039;] = &#039;Sol&agrave;rium&#039;;
$langStr[&#039;0S&#039;] = &#039;Planta baixa + Sol&agrave;rium&#039;;
$langStr[&#039;01S&#039;] = &#039;Planta baixa + Planta 1 + Sol&agrave;rium&#039;;
$langStr[&#039;012S&#039;] = &#039;Planta baixa + Planta 1 + Planta 2 + Sol&agrave;rium&#039;;
$langStr[&#039;P&#039;] = &#039;Parcel&middot;la&#039;;

// /resources/lang_da.php

$langStr[&#039;0&#039;] = &#039;Stueetage&#039;;
$langStr[&#039;1&#039;] = &#039;1. sal&#039;;
$langStr[&#039;2&#039;] = &#039;2. sal&#039;;
$langStr[&#039;3&#039;] = &#039;3. sal&#039;;
$langStr[&#039;01&#039;] = &#039;Stueetage + 1. sal&#039;;
$langStr[&#039;012&#039;] = &#039;Stueetage + 1. sal + 2. sal&#039;;
$langStr[&#039;G&#039;] = &#039;K&aelig;lder&#039;;
$langStr[&#039;G0&#039;] = &#039;K&aelig;lder + Stueetage&#039;;
$langStr[&#039;G01&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal&#039;;
$langStr[&#039;G012&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal + 2. sal&#039;;
$langStr[&#039;G01S&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal + Solterrasse&#039;;
$langStr[&#039;S&#039;] = &#039;Solterrasse&#039;;
$langStr[&#039;0S&#039;] = &#039;Stueetage + Solterrasse&#039;;
$langStr[&#039;01S&#039;] = &#039;Stueetage + 1. sal + Solterrasse&#039;;
$langStr[&#039;012S&#039;] = &#039;Stueetage + 1. sal + 2. sal + Solterrasse&#039;;
$langStr[&#039;P&#039;] = &#039;Grund&#039;;

// /resources/lang_de.php

$langStr[&#039;0&#039;] = &#039;Erdgeschoss&#039;;
$langStr[&#039;1&#039;] = &#039;1. Etage&#039;;
$langStr[&#039;2&#039;] = &#039;2. Etage&#039;;
$langStr[&#039;3&#039;] = &#039;3. Etage&#039;;
$langStr[&#039;01&#039;] = &#039;Erdgeschoss + 1. Etage&#039;;
$langStr[&#039;012&#039;] = &#039;Erdgeschoss + 1. Etage + 2. Etage&#039;;
$langStr[&#039;G&#039;] = &#039;Keller&#039;;
$langStr[&#039;G0&#039;] = &#039;Keller + Erdgeschoss&#039;;
$langStr[&#039;G01&#039;] = &#039;Keller + Erdgeschoss + 1. Etage&#039;;
$langStr[&#039;G012&#039;] = &#039;Keller + Erdgeschoss + 1. Etage + 2. Etage&#039;;
$langStr[&#039;G01S&#039;] = &#039;Keller + Erdgeschoss + 1. Etage + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Erdgeschoss + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Erdgeschoss + 1. Etage + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Erdgeschoss + 1. Etage + 2. Etage + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Grundst&uuml;ck&#039;;

// /resources/lang_en.php

$langStr[&#039;0&#039;] = &#039;Ground floor&#039;;
$langStr[&#039;1&#039;] = &#039;First floor&#039;;
$langStr[&#039;2&#039;] = &#039;Second floor&#039;;
$langStr[&#039;3&#039;] = &#039;Third floor&#039;;
$langStr[&#039;01&#039;] = &#039;Ground floor + First floor&#039;;
$langStr[&#039;012&#039;] = &#039;Ground floor + First floor + Second floor&#039;;
$langStr[&#039;G&#039;] = &#039;Basement&#039;;
$langStr[&#039;G0&#039;] = &#039;Basement + Ground floor&#039;;
$langStr[&#039;G01&#039;] = &#039;Basement + Ground floor + First floor&#039;;
$langStr[&#039;G012&#039;] = &#039;Basement + Ground floor + First floor + Second floor&#039;;
$langStr[&#039;G01S&#039;] = &#039;Basement + Ground floor + First floor + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Ground floor + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Ground floor + First floor + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Ground floor + First floor + Second floor + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Plot&#039;;

// /resources/lang_es.php

$langStr[&#039;0&#039;] = &#039;Planta baja&#039;;
$langStr[&#039;1&#039;] = &#039;Planta 1&#039;;
$langStr[&#039;2&#039;] = &#039;Planta 2&#039;;
$langStr[&#039;3&#039;] = &#039;Planta 3&#039;;
$langStr[&#039;01&#039;] = &#039;Planta baja + Planta 1&#039;;
$langStr[&#039;012&#039;] = &#039;Planta baja + Planta 1 + Planta 2&#039;;
$langStr[&#039;G&#039;] = &#039;S&oacute;tano&#039;;
$langStr[&#039;G0&#039;] = &#039;S&oacute;tano + Planta baja&#039;;
$langStr[&#039;G01&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1&#039;;
$langStr[&#039;G012&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Planta 2&#039;;
$langStr[&#039;G01S&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Planta baja + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Planta baja + Planta 1 + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Planta baja + Planta 1 + Planta 2 + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Parcela&#039;;

// /resources/lang_fi.php

$langStr[&#039;0&#039;] = &#039;Alakerta&#039;;
$langStr[&#039;1&#039;] = &#039;1. kerros&#039;;
$langStr[&#039;2&#039;] = &#039;2. kerros&#039;;
$langStr[&#039;3&#039;] = &#039;3. kerros&#039;;
$langStr[&#039;01&#039;] = &#039;Alakerta + 1. kerros&#039;;
$langStr[&#039;012&#039;] = &#039;Alakerta + 1. + 2. kerros&#039;;
$langStr[&#039;G&#039;] = &#039;Kellari&#039;;
$langStr[&#039;G0&#039;] = &#039;Kellari + Alakerta&#039;;
$langStr[&#039;G01&#039;] = &#039;Kellari + Alakerta + 1. kerros&#039;;
$langStr[&#039;G012&#039;] = &#039;Kellari + Alakerta + 1. + 2. kerros&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kellari + Alakerta + 1. kerros + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Alakerta + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Alakerta + 1. kerros + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Alakerta + 1. + 2. kerros + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Tontti&#039;;

// /resources/lang_fr.php

$langStr[&#039;0&#039;] = &#039;Rez-de-chauss&eacute;e&#039;;
$langStr[&#039;1&#039;] = &#039;1er &eacute;tage&#039;;
$langStr[&#039;2&#039;] = &#039;2e &eacute;tage&#039;;
$langStr[&#039;3&#039;] = &#039;3e &eacute;tage&#039;;
$langStr[&#039;01&#039;] = &#039;Rez-de-chauss&eacute;e + 1er &eacute;tage&#039;;
$langStr[&#039;012&#039;] = &#039;Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage&#039;;
$langStr[&#039;G&#039;] = &#039;Sous-sol&#039;;
$langStr[&#039;G0&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e&#039;;
$langStr[&#039;G01&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er &eacute;tage&#039;;
$langStr[&#039;G012&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage&#039;;
$langStr[&#039;G01S&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er &eacute;tage + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Rez-de-chauss&eacute;e + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Rez-de-chauss&eacute;e + 1er &eacute;tage + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Terrain&#039;;

// /resources/lang_is.php

$langStr[&#039;0&#039;] = &#039;Jar&eth;h&aelig;&eth;&#039;;
$langStr[&#039;1&#039;] = &#039;1. h&aelig;&eth;&#039;;
$langStr[&#039;2&#039;] = &#039;2. h&aelig;&eth;&#039;;
$langStr[&#039;3&#039;] = &#039;3. h&aelig;&eth;&#039;;
$langStr[&#039;01&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth;&#039;;
$langStr[&#039;012&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth;&#039;;
$langStr[&#039;G&#039;] = &#039;Kjallari&#039;;
$langStr[&#039;G0&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth;&#039;;
$langStr[&#039;G01&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth;&#039;;
$langStr[&#039;G012&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth;&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;S&#039;] = &#039;S&oacute;lpallur&#039;;
$langStr[&#039;0S&#039;] = &#039;Jar&eth;h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;01S&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;012S&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;P&#039;] = &#039;L&oacute;&eth;&#039;;

// /resources/lang_nl.php

$langStr[&#039;0&#039;] = &#039;Begane grond&#039;;
$langStr[&#039;1&#039;] = &#039;1e verdieping&#039;;
$langStr[&#039;2&#039;] = &#039;2e verdieping&#039;;
$langStr[&#039;3&#039;] = &#039;3e verdieping&#039;;
$langStr[&#039;01&#039;] = &#039;Begane grond + 1e verdieping&#039;;
$langStr[&#039;012&#039;] = &#039;Begane grond + 1e + 2e verdieping&#039;;
$langStr[&#039;G&#039;] = &#039;Kelder&#039;;
$langStr[&#039;G0&#039;] = &#039;Kelder + Begane grond&#039;;
$langStr[&#039;G01&#039;] = &#039;Kelder + Begane grond + 1e verdieping&#039;;
$langStr[&#039;G012&#039;] = &#039;Kelder + Begane grond + 1e + 2e verdieping&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kelder + Begane grond + 1e verdieping + Dakterras&#039;;
$langStr[&#039;S&#039;] = &#039;Dakterras&#039;;
$langStr[&#039;0S&#039;] = &#039;Begane grond + Dakterras&#039;;
$langStr[&#039;01S&#039;] = &#039;Begane grond + 1e verdieping + Dakterras&#039;;
$langStr[&#039;012S&#039;] = &#039;Begane grond + 1e + 2e verdieping + Dakterras&#039;;
$langStr[&#039;P&#039;] = &#039;Perceel&#039;;

// /resources/lang_no.php

$langStr[&#039;0&#039;] = &#039;F&oslash;rste etasje&#039;;
$langStr[&#039;1&#039;] = &#039;1. etasje&#039;;
$langStr[&#039;2&#039;] = &#039;2. etasje&#039;;
$langStr[&#039;3&#039;] = &#039;3. etasje&#039;;
$langStr[&#039;01&#039;] = &#039;F&oslash;rste etasje + 1. etasje&#039;;
$langStr[&#039;012&#039;] = &#039;F&oslash;rste etasje + 1. + 2. etasje&#039;;
$langStr[&#039;G&#039;] = &#039;Kjeller&#039;;
$langStr[&#039;G0&#039;] = &#039;Kjeller + F&oslash;rste etasje&#039;;
$langStr[&#039;G01&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. etasje&#039;;
$langStr[&#039;G012&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. + 2. etasje&#039;;
$langStr[&#039;G01S&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. etasje + Solterrasse&#039;;
$langStr[&#039;S&#039;] = &#039;Solterrasse&#039;;
$langStr[&#039;0S&#039;] = &#039;F&oslash;rste etasje + Solterrasse&#039;;
$langStr[&#039;01S&#039;] = &#039;F&oslash;rste etasje + 1. etasje + Solterrasse&#039;;
$langStr[&#039;012S&#039;] = &#039;F&oslash;rste etasje + 1. + 2. etasje + Solterrasse&#039;;
$langStr[&#039;P&#039;] = &#039;Tomt&#039;;

// /resources/lang_pl.php

$langStr[&#039;0&#039;] = &#039;Parter&#039;;
$langStr[&#039;1&#039;] = &#039;1. pi&#x119;tro&#039;;
$langStr[&#039;2&#039;] = &#039;2. pi&#x119;tro&#039;;
$langStr[&#039;3&#039;] = &#039;3. pi&#x119;tro&#039;;
$langStr[&#039;01&#039;] = &#039;Parter + 1. pi&#x119;tro&#039;;
$langStr[&#039;012&#039;] = &#039;Parter + 1. + 2. pi&#x119;tro&#039;;
$langStr[&#039;G&#039;] = &#039;Piwnica&#039;;
$langStr[&#039;G0&#039;] = &#039;Piwnica + Parter&#039;;
$langStr[&#039;G01&#039;] = &#039;Piwnica + Parter + 1. pi&#x119;tro&#039;;
$langStr[&#039;G012&#039;] = &#039;Piwnica + Parter + 1. + 2. pi&#x119;tro&#039;;
$langStr[&#039;G01S&#039;] = &#039;Piwnica + Parter + 1. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;S&#039;] = &#039;Solarium&#039;;
$langStr[&#039;0S&#039;] = &#039;Parter + Solarium&#039;;
$langStr[&#039;01S&#039;] = &#039;Parter + 1. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;012S&#039;] = &#039;Parter + 1. + 2. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;P&#039;] = &#039;Dzia&#x142;ka&#039;;

// /resources/lang_ru.php

$langStr[&#039;0&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;1&#039;] = &#039;2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;2&#039;] = &#039;3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;3&#039;] = &#039;4-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;01&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;012&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b;&#039;;
$langStr[&#039;G0&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G01&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G012&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;G01S&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;S&#039;] = &#039;&#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;0S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;01S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;012S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;P&#039;] = &#039;&#x423;&#x447;&#x430;&#x441;&#x442;&#x43e;&#x43a;&#039;;

// /resources/lang_se.php

$langStr[&#039;0&#039;] = &#039;Bottenv&aring;ning&#039;;
$langStr[&#039;1&#039;] = &#039;1:a v&aring;ningen&#039;;
$langStr[&#039;2&#039;] = &#039;2:a v&aring;ningen&#039;;
$langStr[&#039;3&#039;] = &#039;3:e v&aring;ningen&#039;;
$langStr[&#039;01&#039;] = &#039;Bottenv&aring;ning + 1:a v&aring;ningen&#039;;
$langStr[&#039;012&#039;] = &#039;Bottenv&aring;ning + 1:a + 2:a v&aring;ningen&#039;;
$langStr[&#039;G&#039;] = &#039;K&auml;llare&#039;;
$langStr[&#039;G0&#039;] = &#039;K&auml;llare + Bottenv&aring;ning&#039;;
$langStr[&#039;G01&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a v&aring;ningen&#039;;
$langStr[&#039;G012&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a + 2:a v&aring;ningen&#039;;
$langStr[&#039;G01S&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;S&#039;] = &#039;Solterrass&#039;;
$langStr[&#039;0S&#039;] = &#039;Bottenv&aring;ning + Solterrass&#039;;
$langStr[&#039;01S&#039;] = &#039;Bottenv&aring;ning + 1:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;012S&#039;] = &#039;Bottenv&aring;ning + 1:a + 2:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;P&#039;] = &#039;Tomt&#039;;

// /resources/lang_zh.php

$langStr[&#039;0&#039;] = &#039;&#x5e95;&#x5c42;&#039;;
$langStr[&#039;1&#039;] = &#039;&#x4e00;&#x5c42;&#039;;
$langStr[&#039;2&#039;] = &#039;&#x4e8c;&#x5c42;&#039;;
$langStr[&#039;3&#039;] = &#039;&#x4e09;&#x5c42;&#039;;
$langStr[&#039;01&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42;&#039;;
$langStr[&#039;012&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42;&#039;;
$langStr[&#039;G&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4;&#039;;
$langStr[&#039;G0&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42;&#039;;
$langStr[&#039;G01&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42;&#039;;
$langStr[&#039;G012&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42;&#039;;
$langStr[&#039;G01S&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;S&#039;] = &#039;&#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;0S&#039;] = &#039;&#x5e95;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;01S&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;012S&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;P&#039;] = &#039;&#x5730;&#x5757;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">


// /resources/lang_ca.php

$langStr[&#039;pl0&#039;] = &#039;Planta baixa&#039;;
$langStr[&#039;pl1&#039;] = &#039;Planta 1&#039;;
$langStr[&#039;pl2&#039;] = &#039;Planta 2&#039;;
$langStr[&#039;pl3&#039;] = &#039;Planta 3&#039;;
$langStr[&#039;pl01&#039;] = &#039;Planta baixa + Planta 1&#039;;
$langStr[&#039;pl012&#039;] = &#039;Planta baixa + Planta 1 + Planta 2&#039;;
$langStr[&#039;plG&#039;] = &#039;Soterrani&#039;;
$langStr[&#039;plG0&#039;] = &#039;Soterrani + Planta baixa&#039;;
$langStr[&#039;plG01&#039;] = &#039;Soterrani + Planta baixa + Planta 1&#039;;
$langStr[&#039;plG012&#039;] = &#039;Soterrani + Planta baixa + Planta 1 + Planta 2&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Soterrani + Planta baixa + Planta 1 + Sol&agrave;rium&#039;;
$langStr[&#039;plS&#039;] = &#039;Sol&agrave;rium&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Planta baixa + Sol&agrave;rium&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Planta baixa + Planta 1 + Sol&agrave;rium&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Planta baixa + Planta 1 + Planta 2 + Sol&agrave;rium&#039;;
$langStr[&#039;plP&#039;] = &#039;Parcel&middot;la&#039;;

// /resources/lang_da.php

$langStr[&#039;pl0&#039;] = &#039;Stueetage&#039;;
$langStr[&#039;pl1&#039;] = &#039;1. sal&#039;;
$langStr[&#039;pl2&#039;] = &#039;2. sal&#039;;
$langStr[&#039;pl3&#039;] = &#039;3. sal&#039;;
$langStr[&#039;pl01&#039;] = &#039;Stueetage + 1. sal&#039;;
$langStr[&#039;pl012&#039;] = &#039;Stueetage + 1. sal + 2. sal&#039;;
$langStr[&#039;plG&#039;] = &#039;K&aelig;lder&#039;;
$langStr[&#039;plG0&#039;] = &#039;K&aelig;lder + Stueetage&#039;;
$langStr[&#039;plG01&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal&#039;;
$langStr[&#039;plG012&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal + 2. sal&#039;;
$langStr[&#039;plG01S&#039;] = &#039;K&aelig;lder + Stueetage + 1. sal + Solterrasse&#039;;
$langStr[&#039;plS&#039;] = &#039;Solterrasse&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Stueetage + Solterrasse&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Stueetage + 1. sal + Solterrasse&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Stueetage + 1. sal + 2. sal + Solterrasse&#039;;
$langStr[&#039;plP&#039;] = &#039;Grund&#039;;

// /resources/lang_de.php

$langStr[&#039;pl0&#039;] = &#039;Erdgeschoss&#039;;
$langStr[&#039;pl1&#039;] = &#039;1. Etage&#039;;
$langStr[&#039;pl2&#039;] = &#039;2. Etage&#039;;
$langStr[&#039;pl3&#039;] = &#039;3. Etage&#039;;
$langStr[&#039;pl01&#039;] = &#039;Erdgeschoss + 1. Etage&#039;;
$langStr[&#039;pl012&#039;] = &#039;Erdgeschoss + 1. Etage + 2. Etage&#039;;
$langStr[&#039;plG&#039;] = &#039;Keller&#039;;
$langStr[&#039;plG0&#039;] = &#039;Keller + Erdgeschoss&#039;;
$langStr[&#039;plG01&#039;] = &#039;Keller + Erdgeschoss + 1. Etage&#039;;
$langStr[&#039;plG012&#039;] = &#039;Keller + Erdgeschoss + 1. Etage + 2. Etage&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Keller + Erdgeschoss + 1. Etage + Solarium&#039;;
$langStr[&#039;plS&#039;] = &#039;Solarium&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Erdgeschoss + Solarium&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Erdgeschoss + 1. Etage + Solarium&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Erdgeschoss + 1. Etage + 2. Etage + Solarium&#039;;
$langStr[&#039;plP&#039;] = &#039;Grundst&uuml;ck&#039;;

// /resources/lang_en.php

$langStr[&#039;pl0&#039;] = &#039;Ground floor&#039;;
$langStr[&#039;pl1&#039;] = &#039;First floor&#039;;
$langStr[&#039;pl2&#039;] = &#039;Second floor&#039;;
$langStr[&#039;pl3&#039;] = &#039;Third floor&#039;;
$langStr[&#039;pl01&#039;] = &#039;Ground floor + First floor&#039;;
$langStr[&#039;pl012&#039;] = &#039;Ground floor + First floor + Second floor&#039;;
$langStr[&#039;plG&#039;] = &#039;Basement&#039;;
$langStr[&#039;plG0&#039;] = &#039;Basement + Ground floor&#039;;
$langStr[&#039;plG01&#039;] = &#039;Basement + Ground floor + First floor&#039;;
$langStr[&#039;plG012&#039;] = &#039;Basement + Ground floor + First floor + Second floor&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Basement + Ground floor + First floor + Solarium&#039;;
$langStr[&#039;plS&#039;] = &#039;Solarium&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Ground floor + Solarium&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Ground floor + First floor + Solarium&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Ground floor + First floor + Second floor + Solarium&#039;;
$langStr[&#039;plP&#039;] = &#039;Plot&#039;;

// /resources/lang_es.php

$langStr[&#039;pl0&#039;] = &#039;Planta baja&#039;;
$langStr[&#039;pl1&#039;] = &#039;Planta 1&#039;;
$langStr[&#039;pl2&#039;] = &#039;Planta 2&#039;;
$langStr[&#039;pl3&#039;] = &#039;Planta 3&#039;;
$langStr[&#039;pl01&#039;] = &#039;Planta baja + Planta 1&#039;;
$langStr[&#039;pl012&#039;] = &#039;Planta baja + Planta 1 + Planta 2&#039;;
$langStr[&#039;plG&#039;] = &#039;S&oacute;tano&#039;;
$langStr[&#039;plG0&#039;] = &#039;S&oacute;tano + Planta baja&#039;;
$langStr[&#039;plG01&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1&#039;;
$langStr[&#039;plG012&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Planta 2&#039;;
$langStr[&#039;plG01S&#039;] = &#039;S&oacute;tano + Planta baja + Planta 1 + Solarium&#039;;
$langStr[&#039;plS&#039;] = &#039;Solarium&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Planta baja + Solarium&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Planta baja + Planta 1 + Solarium&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Planta baja + Planta 1 + Planta 2 + Solarium&#039;;
$langStr[&#039;plP&#039;] = &#039;Parcela&#039;;

// /resources/lang_fi.php

$langStr[&#039;pl0&#039;] = &#039;Alakerta&#039;;
$langStr[&#039;pl1&#039;] = &#039;1. kerros&#039;;
$langStr[&#039;pl2&#039;] = &#039;2. kerros&#039;;
$langStr[&#039;pl3&#039;] = &#039;3. kerros&#039;;
$langStr[&#039;pl01&#039;] = &#039;Alakerta + 1. kerros&#039;;
$langStr[&#039;pl012&#039;] = &#039;Alakerta + 1. + 2. kerros&#039;;
$langStr[&#039;plG&#039;] = &#039;Kellari&#039;;
$langStr[&#039;plG0&#039;] = &#039;Kellari + Alakerta&#039;;
$langStr[&#039;plG01&#039;] = &#039;Kellari + Alakerta + 1. kerros&#039;;
$langStr[&#039;plG012&#039;] = &#039;Kellari + Alakerta + 1. + 2. kerros&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Kellari + Alakerta + 1. kerros + Solarium&#039;;
$langStr[&#039;plS&#039;] = &#039;Solarium&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Alakerta + Solarium&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Alakerta + 1. kerros + Solarium&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Alakerta + 1. + 2. kerros + Solarium&#039;;
$langStr[&#039;plP&#039;] = &#039;Tontti&#039;;

// /resources/lang_fr.php

$langStr[&#039;pl0&#039;] = &#039;Rez-de-chauss&eacute;e&#039;;
$langStr[&#039;pl1&#039;] = &#039;1er &eacute;tage&#039;;
$langStr[&#039;pl2&#039;] = &#039;2e &eacute;tage&#039;;
$langStr[&#039;pl3&#039;] = &#039;3e &eacute;tage&#039;;
$langStr[&#039;pl01&#039;] = &#039;Rez-de-chauss&eacute;e + 1er &eacute;tage&#039;;
$langStr[&#039;pl012&#039;] = &#039;Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage&#039;;
$langStr[&#039;plG&#039;] = &#039;Sous-sol&#039;;
$langStr[&#039;plG0&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e&#039;;
$langStr[&#039;plG01&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er &eacute;tage&#039;;
$langStr[&#039;plG012&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Sous-sol + Rez-de-chauss&eacute;e + 1er &eacute;tage + Solarium&#039;;
$langStr[&#039;plS&#039;] = &#039;Solarium&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Rez-de-chauss&eacute;e + Solarium&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Rez-de-chauss&eacute;e + 1er &eacute;tage + Solarium&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Rez-de-chauss&eacute;e + 1er + 2e &eacute;tage + Solarium&#039;;
$langStr[&#039;plP&#039;] = &#039;Terrain&#039;;

// /resources/lang_is.php

$langStr[&#039;pl0&#039;] = &#039;Jar&eth;h&aelig;&eth;&#039;;
$langStr[&#039;pl1&#039;] = &#039;1. h&aelig;&eth;&#039;;
$langStr[&#039;pl2&#039;] = &#039;2. h&aelig;&eth;&#039;;
$langStr[&#039;pl3&#039;] = &#039;3. h&aelig;&eth;&#039;;
$langStr[&#039;pl01&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth;&#039;;
$langStr[&#039;pl012&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth;&#039;;
$langStr[&#039;plG&#039;] = &#039;Kjallari&#039;;
$langStr[&#039;plG0&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth;&#039;;
$langStr[&#039;plG01&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth;&#039;;
$langStr[&#039;plG012&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth;&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Kjallari + Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;plS&#039;] = &#039;S&oacute;lpallur&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Jar&eth;h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Jar&eth;h&aelig;&eth; + 1. + 2. h&aelig;&eth; + S&oacute;lpallur&#039;;
$langStr[&#039;plP&#039;] = &#039;L&oacute;&eth;&#039;;

// /resources/lang_nl.php

$langStr[&#039;pl0&#039;] = &#039;Begane grond&#039;;
$langStr[&#039;pl1&#039;] = &#039;1e verdieping&#039;;
$langStr[&#039;pl2&#039;] = &#039;2e verdieping&#039;;
$langStr[&#039;pl3&#039;] = &#039;3e verdieping&#039;;
$langStr[&#039;pl01&#039;] = &#039;Begane grond + 1e verdieping&#039;;
$langStr[&#039;pl012&#039;] = &#039;Begane grond + 1e + 2e verdieping&#039;;
$langStr[&#039;plG&#039;] = &#039;Kelder&#039;;
$langStr[&#039;plG0&#039;] = &#039;Kelder + Begane grond&#039;;
$langStr[&#039;plG01&#039;] = &#039;Kelder + Begane grond + 1e verdieping&#039;;
$langStr[&#039;plG012&#039;] = &#039;Kelder + Begane grond + 1e + 2e verdieping&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Kelder + Begane grond + 1e verdieping + Dakterras&#039;;
$langStr[&#039;plS&#039;] = &#039;Dakterras&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Begane grond + Dakterras&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Begane grond + 1e verdieping + Dakterras&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Begane grond + 1e + 2e verdieping + Dakterras&#039;;
$langStr[&#039;plP&#039;] = &#039;Perceel&#039;;

// /resources/lang_no.php

$langStr[&#039;pl0&#039;] = &#039;F&oslash;rste etasje&#039;;
$langStr[&#039;pl1&#039;] = &#039;1. etasje&#039;;
$langStr[&#039;pl2&#039;] = &#039;2. etasje&#039;;
$langStr[&#039;pl3&#039;] = &#039;3. etasje&#039;;
$langStr[&#039;pl01&#039;] = &#039;F&oslash;rste etasje + 1. etasje&#039;;
$langStr[&#039;pl012&#039;] = &#039;F&oslash;rste etasje + 1. + 2. etasje&#039;;
$langStr[&#039;plG&#039;] = &#039;Kjeller&#039;;
$langStr[&#039;plG0&#039;] = &#039;Kjeller + F&oslash;rste etasje&#039;;
$langStr[&#039;plG01&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. etasje&#039;;
$langStr[&#039;plG012&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. + 2. etasje&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Kjeller + F&oslash;rste etasje + 1. etasje + Solterrasse&#039;;
$langStr[&#039;plS&#039;] = &#039;Solterrasse&#039;;
$langStr[&#039;pl0S&#039;] = &#039;F&oslash;rste etasje + Solterrasse&#039;;
$langStr[&#039;pl01S&#039;] = &#039;F&oslash;rste etasje + 1. etasje + Solterrasse&#039;;
$langStr[&#039;pl012S&#039;] = &#039;F&oslash;rste etasje + 1. + 2. etasje + Solterrasse&#039;;
$langStr[&#039;plP&#039;] = &#039;Tomt&#039;;

// /resources/lang_pl.php

$langStr[&#039;pl0&#039;] = &#039;Parter&#039;;
$langStr[&#039;pl1&#039;] = &#039;1. pi&#x119;tro&#039;;
$langStr[&#039;pl2&#039;] = &#039;2. pi&#x119;tro&#039;;
$langStr[&#039;pl3&#039;] = &#039;3. pi&#x119;tro&#039;;
$langStr[&#039;pl01&#039;] = &#039;Parter + 1. pi&#x119;tro&#039;;
$langStr[&#039;pl012&#039;] = &#039;Parter + 1. + 2. pi&#x119;tro&#039;;
$langStr[&#039;plG&#039;] = &#039;Piwnica&#039;;
$langStr[&#039;plG0&#039;] = &#039;Piwnica + Parter&#039;;
$langStr[&#039;plG01&#039;] = &#039;Piwnica + Parter + 1. pi&#x119;tro&#039;;
$langStr[&#039;plG012&#039;] = &#039;Piwnica + Parter + 1. + 2. pi&#x119;tro&#039;;
$langStr[&#039;plG01S&#039;] = &#039;Piwnica + Parter + 1. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;plS&#039;] = &#039;Solarium&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Parter + Solarium&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Parter + 1. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Parter + 1. + 2. pi&#x119;tro + Solarium&#039;;
$langStr[&#039;plP&#039;] = &#039;Dzia&#x142;ka&#039;;

// /resources/lang_ru.php

$langStr[&#039;pl0&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;pl1&#039;] = &#039;2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;pl2&#039;] = &#039;3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;pl3&#039;] = &#039;4-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;pl01&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;pl012&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;plG&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b;&#039;;
$langStr[&#039;plG0&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;plG01&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;plG012&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436;&#039;;
$langStr[&#039;plG01S&#039;] = &#039;&#x41f;&#x43e;&#x434;&#x432;&#x430;&#x43b; + &#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;plS&#039;] = &#039;&#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;pl0S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;pl01S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;pl012S&#039;] = &#039;&#x41f;&#x435;&#x440;&#x432;&#x44b;&#x439; + 2-&#x439; + 3-&#x439; &#x44d;&#x442;&#x430;&#x436; + &#x421;&#x43e;&#x43b;&#x44f;&#x440;&#x438;&#x439;&#039;;
$langStr[&#039;plP&#039;] = &#039;&#x423;&#x447;&#x430;&#x441;&#x442;&#x43e;&#x43a;&#039;;

// /resources/lang_se.php

$langStr[&#039;pl0&#039;] = &#039;Bottenv&aring;ning&#039;;
$langStr[&#039;pl1&#039;] = &#039;1:a v&aring;ningen&#039;;
$langStr[&#039;pl2&#039;] = &#039;2:a v&aring;ningen&#039;;
$langStr[&#039;pl3&#039;] = &#039;3:e v&aring;ningen&#039;;
$langStr[&#039;pl01&#039;] = &#039;Bottenv&aring;ning + 1:a v&aring;ningen&#039;;
$langStr[&#039;pl012&#039;] = &#039;Bottenv&aring;ning + 1:a + 2:a v&aring;ningen&#039;;
$langStr[&#039;plG&#039;] = &#039;K&auml;llare&#039;;
$langStr[&#039;plG0&#039;] = &#039;K&auml;llare + Bottenv&aring;ning&#039;;
$langStr[&#039;plG01&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a v&aring;ningen&#039;;
$langStr[&#039;plG012&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a + 2:a v&aring;ningen&#039;;
$langStr[&#039;plG01S&#039;] = &#039;K&auml;llare + Bottenv&aring;ning + 1:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;plS&#039;] = &#039;Solterrass&#039;;
$langStr[&#039;pl0S&#039;] = &#039;Bottenv&aring;ning + Solterrass&#039;;
$langStr[&#039;pl01S&#039;] = &#039;Bottenv&aring;ning + 1:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;pl012S&#039;] = &#039;Bottenv&aring;ning + 1:a + 2:a v&aring;ningen + Solterrass&#039;;
$langStr[&#039;plP&#039;] = &#039;Tomt&#039;;

// /resources/lang_zh.php

$langStr[&#039;pl0&#039;] = &#039;&#x5e95;&#x5c42;&#039;;
$langStr[&#039;pl1&#039;] = &#039;&#x4e00;&#x5c42;&#039;;
$langStr[&#039;pl2&#039;] = &#039;&#x4e8c;&#x5c42;&#039;;
$langStr[&#039;pl3&#039;] = &#039;&#x4e09;&#x5c42;&#039;;
$langStr[&#039;pl01&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42;&#039;;
$langStr[&#039;pl012&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42;&#039;;
$langStr[&#039;plG&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4;&#039;;
$langStr[&#039;plG0&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42;&#039;;
$langStr[&#039;plG01&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42;&#039;;
$langStr[&#039;plG012&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42;&#039;;
$langStr[&#039;plG01S&#039;] = &#039;&#x5730;&#x4e0b;&#x5ba4; + &#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;plS&#039;] = &#039;&#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;pl0S&#039;] = &#039;&#x5e95;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;pl01S&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;pl012S&#039;] = &#039;&#x5e95;&#x5c42; + &#x4e00;&#x5c42; + &#x4e8c;&#x5c42; + &#x65e5;&#x5149;&#x6d74;&#x5ba4;&#039;;
$langStr[&#039;plP&#039;] = &#039;&#x5730;&#x5757;&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> XML Kyero con todos los idiomas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/kyero.php:34
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_ca_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ca_prop ELSE properties_properties.descripcion_ca_prop END AS descripcion_ca_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS descripcion_fi_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_is_prop != &#039;&#039; THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS descripcion_is_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS descripcion_no_prop,
CASE WHEN properties_properties.descripcion_xml_pl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_pl_prop ELSE properties_properties.descripcion_pl_prop END AS descripcion_pl_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_zh_prop != &#039;&#039; THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS descripcion_zh_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/kyero.php:148
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if($row_rsProperties[&#039;descripcion_en_prop&#039;] != &#039;&#039;) { ?&gt;&lt;en&gt;&lt;![CDATA[  &lt;?php echo str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;), &quot; &quot;, $row_rsProperties[&#039;descripcion_en_prop&#039;]); ?&gt; ]]&gt;&lt;/en&gt;&lt;?php } ?&gt;
&lt;?php if($row_rsProperties[&#039;descripcion_es_prop&#039;] != &#039;&#039;) { ?&gt;&lt;es&gt;&lt;![CDATA[ &lt;?php echo str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;), &quot; &quot;, $row_rsProperties[&#039;descripcion_es_prop&#039;]); ?&gt; ]]&gt;&lt;/es&gt;&lt;?php } ?&gt;
&lt;?php if($row_rsProperties[&#039;descripcion_de_prop&#039;] != &#039;&#039;) { ?&gt;&lt;de&gt;&lt;![CDATA[ &lt;?php echo str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;), &quot; &quot;, $row_rsProperties[&#039;descripcion_de_prop&#039;]); ?&gt; ]]&gt;&lt;/de&gt;&lt;?php } ?&gt;
&lt;?php if($row_rsProperties[&#039;descripcion_nl_prop&#039;] != &#039;&#039;) { ?&gt;&lt;nl&gt;&lt;![CDATA[ &lt;?php echo str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;), &quot; &quot;, $row_rsProperties[&#039;descripcion_nl_prop&#039;]); ?&gt; ]]&gt;&lt;/nl&gt;&lt;?php } ?&gt;
&lt;?php if($row_rsProperties[&#039;descripcion_fr_prop&#039;] != &#039;&#039;) { ?&gt;&lt;fr&gt;&lt;![CDATA[ &lt;?php echo str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;), &quot; &quot;, $row_rsProperties[&#039;descripcion_fr_prop&#039;]); ?&gt; ]]&gt;&lt;/fr&gt;&lt;?php } ?&gt;
&lt;?php if($row_rsProperties[&#039;descripcion_da_prop&#039;] != &#039;&#039;) { ?&gt;&lt;da&gt;&lt;![CDATA[ &lt;?php echo str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;), &quot; &quot;, $row_rsProperties[&#039;descripcion_da_prop&#039;]); ?&gt; ]]&gt;&lt;/da&gt;&lt;?php } ?&gt;
&lt;?php if($row_rsProperties[&#039;descripcion_ru_prop&#039;] != &#039;&#039;) { ?&gt;&lt;ru&gt;&lt;![CDATA[ &lt;?php echo str_replace(array(&quot;\r\n&quot;, &quot;\r&quot;, &quot;&#x2da;&quot;), &quot; &quot;, $row_rsProperties[&#039;descripcion_ru_prop&#039;]); ?&gt; ]]&gt;&lt;/ru&gt;&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if(isset($row_rsProperties[&#039;descripcion_ca_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_ca_prop&#039;] != &#039;&#039;) { ?&gt;&lt;ca&gt;&lt;![CDATA[  &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_ca_prop&#039;])))); ?&gt; ]]&gt;&lt;/ca&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_da_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_da_prop&#039;] != &#039;&#039;) { ?&gt;&lt;da&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_da_prop&#039;])))); ?&gt; ]]&gt;&lt;/da&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_de_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_de_prop&#039;] != &#039;&#039;) { ?&gt;&lt;de&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_de_prop&#039;])))); ?&gt; ]]&gt;&lt;/de&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_en_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_en_prop&#039;] != &#039;&#039;) { ?&gt;&lt;en&gt;&lt;![CDATA[  &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_en_prop&#039;])))); ?&gt; ]]&gt;&lt;/en&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_es_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_es_prop&#039;] != &#039;&#039;) { ?&gt;&lt;es&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_es_prop&#039;])))); ?&gt; ]]&gt;&lt;/es&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_fi_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_fi_prop&#039;] != &#039;&#039;) { ?&gt;&lt;fi&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_fi_prop&#039;])))); ?&gt; ]]&gt;&lt;/fi&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_fr_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_fr_prop&#039;] != &#039;&#039;) { ?&gt;&lt;fr&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_fr_prop&#039;])))); ?&gt; ]]&gt;&lt;/fr&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_is_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_is_prop&#039;] != &#039;&#039;) { ?&gt;&lt;is&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_is_prop&#039;])))); ?&gt; ]]&gt;&lt;/is&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_nl_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_nl_prop&#039;] != &#039;&#039;) { ?&gt;&lt;nl&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_nl_prop&#039;])))); ?&gt; ]]&gt;&lt;/nl&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_no_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_no_prop&#039;] != &#039;&#039;) { ?&gt;&lt;no&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_no_prop&#039;])))); ?&gt; ]]&gt;&lt;/no&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_pl_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_pl_prop&#039;] != &#039;&#039;) { ?&gt;&lt;pl&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_pl_prop&#039;])))); ?&gt; ]]&gt;&lt;/pl&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_ru_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_ru_prop&#039;] != &#039;&#039;) { ?&gt;&lt;ru&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_ru_prop&#039;])))); ?&gt; ]]&gt;&lt;/ru&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_se_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_se_prop&#039;] != &#039;&#039;) { ?&gt;&lt;sv&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_se_prop&#039;])))); ?&gt; ]]&gt;&lt;/sv&gt;&lt;?php } ?&gt;
&lt;?php if(isset($row_rsProperties[&#039;descripcion_zh_prop&#039;]) &amp;&amp; $row_rsProperties[&#039;descripcion_zh_prop&#039;] != &#039;&#039;) { ?&gt;&lt;zh&gt;&lt;![CDATA[ &lt;?php echo str_replace(&#039;&lt;br /&gt;&#039;, &#039;&amp;#13;&amp;#13;&#039;, nl2br(strip_tags(preg_replace(&#039;/&amp;/&#039;, &#039;&amp;amp;&#039;, $row_rsProperties[&#039;descripcion_zh_prop&#039;])))); ?&gt; ]]&gt;&lt;/zh&gt;&lt;?php } ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Falta la columna de registrado en el listado de clientes
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:69
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Pr&oacute;xima llamada&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Pr&oacute;xima llamada&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php  __(&#039;Registrado&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:106
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;fecha_alta_cli&quot; id=&quot;fecha_alta_cli&quot; class=&quot;form-control input-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;fecha_alta_cli&quot; id=&quot;fecha_alta_cli&quot; class=&quot;form-control input-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;usuario_cli&quot; id=&quot;usuario_cli&quot;&gt;

    &lt;select name=&quot;usuario_cli_sel&quot; id=&quot;usuario_cli_sel&quot; class=&quot;form-control input-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;

&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:122
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if($actUsuarios == 1) { ?&gt;
&lt;td colspan=&quot;14&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
&lt;?php } else { ?&gt;
&lt;td colspan=&quot;13&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
<?php if($actUsuarios == 1) { ?>
<td colspan="15" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
<?php } else { ?>
<td colspan="14" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
<?php } ?>
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:140
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script&gt;
var numCols = &lt;?php echo ($actUsuarios == 1)?14:13; ?&gt;;
var numColsAtendido = &lt;?php echo ($actUsuarios == 1)?10:9; ?&gt;;
&lt;?php if($actUsuarios == 1) { ?&gt;
var arrayColVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
&lt;?php } else { ?&gt;
var arrayColVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
&lt;?php } ?&gt;
&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script&gt;
var numCols = &lt;?php echo ($actUsuarios == 1)?15:14; ?&gt;;
var numColsAtendido = &lt;?php echo ($actUsuarios == 1)?10:9; ?&gt;;
var numColsRegistrado = &lt;?php echo ($actUsuarios == 1)?13:12; ?&gt;;
&lt;?php if($actUsuarios == 1) { ?&gt;
var arrayColVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
&lt;?php } else { ?&gt;
var arrayColVis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
&lt;?php } ?&gt;
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-data.php:37
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($actUsuarios == 1) {
    $aColumns = array( &#039;id2_cli&#039;, &#039;nombre_cli&#039;, &#039;apellidos_cli&#039;, &#039;email_cli&#039;, &#039;telefono_fijo_cli&#039;, &#039;telefono_movil_cli&#039;, &#039;captado_por2_cli&#039;, &#039;puntuacion_cli&#039;, &#039;status_cli&#039;, &#039;total&#039;, &#039;atendido_cli&#039;, &#039;atendido_por_cli&#039;, &#039;next_call_cli&#039;, &#039;fecha_alta_cli&#039;, &#039;id_cli&#039; );
} else {
    $aColumns = array( &#039;id2_cli&#039;, &#039;nombre_cli&#039;, &#039;apellidos_cli&#039;, &#039;email_cli&#039;, &#039;telefono_fijo_cli&#039;, &#039;telefono_movil_cli&#039;, &#039;captado_por2_cli&#039;, &#039;puntuacion_cli&#039;, &#039;status_cli&#039;, &#039;atendido_cli&#039;, &#039;atendido_por_cli&#039;, &#039;next_call_cli&#039;, &#039;fecha_alta_cli&#039;, &#039;id_cli&#039; );
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($actUsuarios == 1) {
    $aColumns = array( &#039;id2_cli&#039;, &#039;nombre_cli&#039;, &#039;apellidos_cli&#039;, &#039;email_cli&#039;, &#039;telefono_fijo_cli&#039;, &#039;telefono_movil_cli&#039;, &#039;captado_por2_cli&#039;, &#039;puntuacion_cli&#039;, &#039;status_cli&#039;, &#039;total&#039;, &#039;atendido_cli&#039;, &#039;atendido_por_cli&#039;, &#039;next_call_cli&#039;, &#039;usuario_cli&#039;, &#039;fecha_alta_cli&#039;, &#039;id_cli&#039; );
} else {
    $aColumns = array( &#039;id2_cli&#039;, &#039;nombre_cli&#039;, &#039;apellidos_cli&#039;, &#039;email_cli&#039;, &#039;telefono_fijo_cli&#039;, &#039;telefono_movil_cli&#039;, &#039;captado_por2_cli&#039;, &#039;puntuacion_cli&#039;, &#039;status_cli&#039;, &#039;atendido_cli&#039;, &#039;atendido_por_cli&#039;, &#039;next_call_cli&#039;, &#039;usuario_cli&#039;, &#039;fecha_alta_cli&#039;, &#039;id_cli&#039; );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-data.php:199
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
 if($aColumns[$i] == &#039;atendido_cli&#039;) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($aColumns[$i] == &#039;atendido_cli&#039; || $aColumns[$i] == &#039;usuario_cli&#039;) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-data.php:280
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
end as atendido_cli,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
end as atendido_cli,
case usuario_cli
    when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
    when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as usuario_cli,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-list.js:3
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#atendido_cli_sel&#039;).change(function(e) {

    $(&#039;#atendido_cli&#039;).val($(this).val()).trigger(&#039;keyup&#039;);

});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#atendido_cli_sel&#039;).change(function(e) {

    $(&#039;#atendido_cli&#039;).val($(this).val()).trigger(&#039;keyup&#039;);

});

$(&#039;#usuario_cli_sel&#039;).change(function(e) {

    $(&#039;#usuario_cli&#039;).val($(this).val()).trigger(&#039;keyup&#039;);

});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-list.js:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($(&#039;#atendido_cli&#039;).val() != &#039;&#039;) {

    $(&#039;#atendido_cli_sel&#039;).val($(&#039;#atendido_cli&#039;).val() );

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($(&#039;#atendido_cli&#039;).val() != &#039;&#039;) {

    $(&#039;#atendido_cli_sel&#039;).val($(&#039;#atendido_cli&#039;).val() );

}
if ($(&#039;#usuario_cli&#039;).val() != &#039;&#039;) {

    $(&#039;#usuario_cli_sel&#039;).val($(&#039;#usuario_cli&#039;).val() );

}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-list.js:88
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{
    &quot;render&quot;: function ( data, type, row ) {
        if (data == &#039;No&#039;) {
            btns  = &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        } else{
            btns  = &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        }
        return  btns;
    },
    &quot;targets&quot;: numColsAtendido
},
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{
    &quot;render&quot;: function ( data, type, row ) {
        if (data == &#039;No&#039;) {
            btns  = &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        } else{
            btns  = &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        }
        return  btns;
    },
    &quot;targets&quot;: numColsAtendido
},
{
    &quot;render&quot;: function ( data, type, row ) {
        if (data == &#039;No&#039;) {
            btns  = &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        } else{
            btns  = &#039;&lt;div class=&quot;text-center mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        }
        return  btns;
    },
    &quot;targets&quot;: numColsRegistrado
},
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>