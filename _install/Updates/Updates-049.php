<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 29-11-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en el inicio de la intramedianet</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error en el formulario de la newsletter</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el inicio de la intramedianet
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/inicio/inicio.php:194
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sWhere = &#039; AND admin_tsk = &#039; . $_SESSION[&#039;kt_login_id&#039;];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$sWhere .= &#039; AND admin_tsk = &#039; . $_SESSION[&#039;kt_login_id&#039;];
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el formulario de la newsletter
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/mailchimp/views/newsletter.tpl
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;{$urlStart}{$url_privacy}/&quot; target=&quot;_blank&quot;&gt;
{assign var=&quot;urlPPRV&quot; value=sprintf(&#039;&lt;a href=&quot;%s%s/&quot; target=&quot;_blank&quot;&gt;&#039;, {$urlStart}, {$url_privacy})}
{$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:&#039;&lt;/a&gt;&#039;}
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{assign var=&quot;urlPPRV&quot; value=sprintf(&#039;&lt;a href=&quot;%s%s/&quot; target=&quot;_blank&quot;&gt;&#039;, {$urlStart}, {$url_privacy})}
{$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:&#039;&lt;/a&gt;&#039;}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>