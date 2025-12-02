<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 25-07-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>Ajustes de diseño y remodelación del dashboard</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>Añadida referencia catastral a inmuebles</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i>Separados usuarios de usuarios web</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes de diseño y remodelación del dashboard
    </h6>
    <div class="card-body">
        Sobreescribir las carpetas:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets
/intramedianet/inicio
            </code>
        </pre>
        <hr>
        Sobreescribir el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Activados&#039;] = &#039;Activados&#039;;
$lang[&#039;Bajada de precios&#039;] = &#039;Bajada de precios&#039;;
$lang[&#039;Propias&#039;] = &#039;Propias&#039;;
$lang[&#039;Importadas&#039;] = &#039;Importadas&#039;;
$lang[&#039;Vencidas&#039;] = &#039;Pendientes&#039;;
$lang[&#039;Pr&oacute;ximas&#039;] = &#039;Pr&oacute;ximas&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Activados&#039;] = &#039;Activated&#039;;
$lang[&#039;Bajada de precios&#039;] = &#039;Price reductions&#039;;
$lang[&#039;Propias&#039;] = &#039;Own&#039;;
$lang[&#039;Importadas&#039;] = &#039;Imported&#039;;
$lang[&#039;Vencidas&#039;] = &#039;Pending&#039;;
$lang[&#039;Pr&oacute;ximas&#039;] = &#039;Next&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadida referencia catastral a inmuebles
    </h6>
    <div class="card-body">
        Ejecutar query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `referencia_catrastal_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:894
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;comision_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;comision_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;comision_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;comision_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;referencia_catrastal_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;referencia_catrastal_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1124
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;comision_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;comision_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;comision_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;comision_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;referencia_catrastal_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;referencia_catrastal_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3661
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
   &lt;label for=&quot;commission_prop&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n&#039;); ?&gt;:&lt;/label&gt;
   &lt;div class=&quot;controls&quot;&gt;
       &lt;input type=&quot;text&quot; name=&quot;commission_prop&quot; id=&quot;commission_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;commission_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;); ?&gt;
   &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
   &lt;label for=&quot;commission_prop&quot;&gt;&lt;?php __(&#039;Comisi&oacute;n&#039;); ?&gt;:&lt;/label&gt;
   &lt;div class=&quot;controls&quot;&gt;
       &lt;input type=&quot;text&quot; name=&quot;commission_prop&quot; id=&quot;commission_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;commission_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;commission_prop&quot;); ?&gt;
   &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;referencia_catrastal_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
   &lt;label for=&quot;referencia_catrastal_prop&quot;&gt;&lt;?php __(&#039;Referencia catastral&#039;); ?&gt;:&lt;/label&gt;
   &lt;div class=&quot;controls&quot;&gt;
       &lt;input type=&quot;text&quot; name=&quot;referencia_catrastal_prop&quot; id=&quot;referencia_catrastal_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_catrastal_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
       &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;referencia_catrastal_prop&quot;); ?&gt;
   &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Referencia catastral&#039;] = &#039;Referencia catastral&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Referencia catastral&#039;] = &#039;Cadastral reference&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Separados usuarios de usuarios web
    </h6>
    <div class="card-body">
        Reemplazamos las carpetas:
        <pre>
            <code class="makefile">
/intramedianet/users
/intramedianet/webuser
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:51
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &apos;demo.mediaelx.info&apos; || ($_SERVER[&quot;HTTP_HOST&quot;] == &apos;demo.mediaelx.info&apos; &amp;&amp; $_SESSION[&apos;kt_login_id&apos;] == 47)): ?&gt;
&lt;a &lt;?php if(preg_match(&apos;/\/users/&apos;, $_SERVER[&apos;PHP_SELF&apos;]) || preg_match(&apos;/\/seg/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt; href=&quot;/intramedianet/users/users.php&quot;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-user fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Usuarios&apos;); ?&gt;
&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &apos;demo.mediaelx.info&apos; || ($_SERVER[&quot;HTTP_HOST&quot;] == &apos;demo.mediaelx.info&apos; &amp;&amp; $_SESSION[&apos;kt_login_id&apos;] == 47)): ?&gt;
&lt;a &lt;?php if(preg_match(&apos;/\/users\//&apos;, $_SERVER[&apos;PHP_SELF&apos;]) || preg_match(&apos;/\/seg/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt; href=&quot;/intramedianet/users/users.php&quot;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-user fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Usuarios&apos;); ?&gt;
&lt;/a&gt;

&lt;?php if ($actUsuarios == 1): ?&gt;
&lt;a &lt;?php if(preg_match(&apos;/\/webuser/&apos;, $_SERVER[&apos;PHP_SELF&apos;]) ){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt; href=&quot;/intramedianet/webuser/users.php&quot;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-users fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    Website &lt;br&gt; &lt;?php __(&apos;Usuarios&apos;); ?&gt;
&lt;/a&gt;
&lt;?php endif ?&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
