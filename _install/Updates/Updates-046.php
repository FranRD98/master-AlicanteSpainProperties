<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 21-11-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> El pop up de similares y lo quitas te vuelve a salir el form de notify if price drops vacío</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes etiquetas GOOGLEBOT y ROBOTS del head</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Ajusteas al añadir inmuebles, añade 0 a habitaciones, coinas, aseos,...</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> El pop up de similares y lo quitas te vuelve a salir el form de notify if price drops vacío
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:728
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&apos;#bajadaPrecioForm .loading&apos;).remove();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&apos;#bajadaPrecioForm .loading&apos;).remove();
$(&apos;#bajadaModal .close&apos;).click();
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes etiquetas GOOGLEBOT y ROBOTS del head
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:24
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;meta name=&quot;GOOGLEBOT&quot; content=&quot;INDEX,FOLLOW,ALL&quot; &gt;
&lt;meta name=&quot;ROBOTS&quot; content=&quot;INDEX,FOLLOW,ALL&quot; &gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:74
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
{if $noIndex == 1}
    &lt;meta name=&quot;GOOGLEBOT&quot; content=&#x201c;NOINDEX&quot; &gt;
    &lt;meta name=&#x201c;ROBOTS&quot; content=&apos;NOINDEX&apos;&gt;
{else}
    &lt;meta name=&quot;GOOGLEBOT&quot; content=&quot;INDEX,FOLLOW,ALL&quot; &gt;
    &lt;meta name=&quot;ROBOTS&quot; content=&quot;INDEX,FOLLOW,ALL&quot; &gt;
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajusteas al añadir inmuebles, añade 0 a habitaciones, coinas, aseos,...
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:719
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_Fotocasa_Delete trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_Fotocasa_Delete trigger

if ($_POST[&apos;habitaciones_prop&apos;] == &apos;&apos;) {
    $_POST[&apos;habitaciones_prop&apos;] = 0;
}

if ($_POST[&apos;aseos_prop&apos;] == &apos;&apos;) {
    $_POST[&apos;aseos_prop&apos;] = 0;
}

if ($_POST[&apos;aseos2_prop&apos;] == &apos;&apos;) {
    $_POST[&apos;aseos2_prop&apos;] = 0;
}

if ($_POST[&apos;cocinas_prop&apos;] == &apos;&apos;) {
    $_POST[&apos;cocinas_prop&apos;] = 0;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>