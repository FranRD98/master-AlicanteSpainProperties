<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 20-12-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error en el &lt;head&gt;</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:37
            </code>
        </pre>
        Cambiar:
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
        Por:
        <pre>
            <code class="php">
{if count($languages) &gt; 1}
    {foreach from=$languages item=idm}
        {if $idm != $language}
            {if {$url{$idm|upper}} != &quot;&quot; &amp;&amp; {$url{$idm|upper}} != &quot;https://{$smarty.server.HTTP_HOST}/{$idm}/{$seccion_lang[$idm]}/&quot; &amp;&amp; {$url{$idm|upper}} != &quot;http://{$smarty.server.HTTP_HOST}/{$idm}/{$seccion_lang[$idm]}/&quot;  }
            &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{if {preg_match pattern=&apos;http&apos; subject={$url{$idm|upper}}}}{{$url{$idm|upper}}|replace:&apos;http:&apos;:&apos;https:&apos;}{else}https://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}{/if}&quot; /&gt;
            {/if}
        {else}
            {if {$urlDefault} != &quot;&quot; }
                &lt;link rel=&quot;alternate&quot; hreflang=&quot;{$idm}&quot; href=&quot;{if {preg_match pattern=&apos;http&apos; subject=$urlDefault}}{$urlDefault|replace:&apos;http:&apos;:&apos;https:&apos;}{else}https://{$smarty.server.HTTP_HOST}{$urlDefault|replace:&apos;http:&apos;:&apos;https:&apos;}{/if}&quot; /&gt;
            {/if}
        {/if}
    {/foreach}
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:104
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;actWhatsapp&quot;, $actWhatsapp);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;actWhatsapp&quot;, $actWhatsapp);
$smarty-&gt;assign(&quot;seccion_lang&quot;, $urlStr[$urlStr[$seccion][&quot;master&quot;]]);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el &lt;head&gt;
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:78
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $noIndex == 1}
    &lt;meta name=&quot;GOOGLEBOT&quot; content=&ldquo;NOINDEX&quot; &gt;
    &lt;meta name=&ldquo;ROBOTS&quot; content=&#039;NOINDEX&#039;&gt;
{else}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $noIndex == 1}
    &lt;meta name=&quot;GOOGLEBOT&quot; content=&quot;NOINDEX&quot; &gt;
    &lt;meta name=&quot;ROBOTS&quot; content=&ldquo;NOINDEX&quot;&gt;
{else}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>