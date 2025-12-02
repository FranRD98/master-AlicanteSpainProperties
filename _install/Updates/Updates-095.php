<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 28-07-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>Solucionado bug al crear propietario desde ficha de inmuebles</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>Poder seleccionar plantillas de emails desde criterios de búsqueda de un cliente</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Solucionado bug al crear propietario desde ficha de inmuebles
    </h6>
    <div class="card-body">
        Sobreescribir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form-ajax.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Poder seleccionar plantillas de emails desde criterios de búsqueda de un cliente
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2383
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
  &lt;label for=&quot;email_cli&quot;&gt;&lt;?php __(&apos;Comentario&apos;); ?&gt;:&lt;/label&gt;
  &lt;div class=&quot;controls&quot;&gt;
  &lt;textarea name=&quot;comment&quot; id=&quot;comment&quot; cols=&quot;30&quot; rows=&quot;5&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
  &lt;label for=&quot;email_cli&quot;&gt;&lt;?php __(&apos;Comentario&apos;); ?&gt;:&lt;/label&gt;
  &lt;div class=&quot;controls&quot;&gt;
  &lt;textarea name=&quot;comment&quot; id=&quot;comment&quot; cols=&quot;30&quot; rows=&quot;5&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;
    &lt;div class=&quot;form-group&gt;&quot;&gt;
        &lt;label for=&quot;txt2&quot;&gt;&lt;?php __(&apos;Texto&apos;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;txt2&quot; id=&quot;txt2&quot; class=&quot;form-control&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php __(&apos;Seleccione uno&apos;); ?&gt;...&lt;/option&gt;
            &lt;?php do { ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsTemplates[&apos;id_tmpl&apos;]?&gt;&quot;&gt;&lt;?php echo $row_rsTemplates[&apos;name_&apos;.$lang_adm.&apos;_tmpl&apos;]?&gt;&lt;/option&gt;
            &lt;?php } while ($row_rsTemplates = mysql_fetch_assoc($rsTemplates));
              $rows = mysql_num_rows($rsTemplates);
              if($rows &gt; 0) {
                  mysql_data_seek($rsTemplates, 0);
                $row_rsTemplates = mysql_fetch_assoc($rsTemplates);
              } ?&gt;
        &lt;/select&gt;
    &lt;/div&gt;
  &lt;/div&gt;
    &lt;div class=&quot;col-md-2&quot;&gt;
        &lt;div class=&quot;form-group&gt;&quot;&gt;
            &lt;label&gt;&amp;nbsp;&lt;/label&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-info btn-block btn-txt2&quot;&gt;&lt;?php __(&apos;Aplicar&apos;); ?&gt;&lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2557
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&apos;.btn-txt&apos;).click(function(e) {
    e.preventDefault();
    if ($(&apos;#txt&apos;).val() == &apos;&apos;) {
        alert(&apos;&lt;?php __(&apos;Seleccione un texto&apos;); ?&gt;&apos;);
        $(&apos;#txt&apos;).focus();
        return false;
    }
    if ($(&apos;#ref&apos;).val() == &apos;&apos;) {
        alert(&apos;&lt;?php __(&apos;Seleccione una referencia&apos;); ?&gt;&apos;);
        $(&apos;#ref&apos;).focus();
        return false;
    }
    $(&apos;#subjectSM&apos;).val(intr_sub[$(&apos;#idioma_cli&apos;).val()+$(&apos;#txt&apos;).val()]);
    var txt = intr_txt[$(&apos;#idioma_cli&apos;).val()+$(&apos;#txt&apos;).val()];
    $(&apos;#messagemail&apos;).val(txt.replace(&apos;{{PROPERTY}}&apos;, &apos;{{PROPERTY-&apos; + $(&apos;#ref&apos;).val() + &apos;}}&apos;));
    return false;
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.btn-txt&#039;).click(function(e) {
    e.preventDefault();
    if ($(&#039;#txt&#039;).val() == &#039;&#039;) {
        alert(&#039;&lt;?php __(&#039;Seleccione un texto&#039;); ?&gt;&#039;);
        $(&#039;#txt&#039;).focus();
        return false;
    }
    if ($(&#039;#ref&#039;).val() == &#039;&#039;) {
        alert(&#039;&lt;?php __(&#039;Seleccione una referencia&#039;); ?&gt;&#039;);
        $(&#039;#ref&#039;).focus();
        return false;
    }
    $(&#039;#subjectSM&#039;).val(intr_sub[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt&#039;).val()]);
    var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt&#039;).val()];
    $(&#039;#messagemail&#039;).val(txt.replace(&#039;{{PROPERTY}}&#039;, &#039;{{PROPERTY-&#039; + $(&#039;#ref&#039;).val() + &#039;}}&#039;));
    return false;
});

$(&#039;.btn-txt2&#039;).click(function(e) {
    e.preventDefault();
    if ($(&#039;#txt2&#039;).val() == &#039;&#039;) {
        alert(&#039;&lt;?php __(&#039;Seleccione un texto&#039;); ?&gt;&#039;);
        $(&#039;#txt2&#039;).focus();
        return false;
    }
    var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt2&#039;).val()].replace(&#039;{{PROPERTY}}&#039;, &#039;&#039;);
    $(&#039;#comment&#039;).val(txt);
    return false;
});
            </code>
        </pre>
        <hr>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
