<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 9-06-2023</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Fallo en datepicker calendario</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Fallo ortográfico en categorias de noticias y calendario</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> No se puede traducir los textareas que usan redactor</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido enlace a plantillas de email en formularios donde se usan</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Ocultar atendido por de compradores a Agentes</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al responder consultas desde el crm</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo en datepicker calendario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/_custom/custom.js:57
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#back-top&#039;).click(function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: &#039;smooth&#039; });
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#back-top&#039;).click(function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: &#039;smooth&#039; });
});

//  ============================================================================
//  === Datetimepicker
//  ============================================================================

if (applang == &#039;es&#039;) {
    $(&quot;.datepicktime&quot;).flatpickr({
        enableTime: true,
        time_24hr: true,
        locale: &quot;es&quot;,
        dateFormat: &quot;d-m-Y H:i&quot;
    });
} else {
    $(&quot;.datepicktime&quot;).flatpickr({
        enableTime: true,
        time_24hr: true,
        dateFormat: &quot;d-m-Y H:i&quot;
    });
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2807
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepicktime required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepicktime required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1657
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepicktime required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-2&quot;&gt;
        &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepicktime required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/calendario.php:355
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;

  &lt;div class=&quot;mb-4&quot;&gt;
      &lt;label for=&quot;inicio_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
      &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-md-6&quot;&gt;

  &lt;div class=&quot;mb-4&quot;&gt;
      &lt;label for=&quot;final_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
      &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;

  &lt;div class=&quot;mb-4&quot;&gt;
      &lt;label for=&quot;inicio_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
      &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepicktime required&quot; required&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-md-6&quot;&gt;

  &lt;div class=&quot;mb-4&quot;&gt;
      &lt;label for=&quot;final_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
      &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepicktime required&quot; required&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo ortográfico en categorias de noticias y calendario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/categories-form.php:228
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;label for=&quot;category_&lt;?php echo $value; ?&gt;_ct&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Caregor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;label for=&quot;category_&lt;?php echo $value; ?&gt;_ct&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/categories-form.php:165
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;label for=&quot;category_&lt;?php echo $value; ?&gt;_ct&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Caregor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;label for=&quot;category_&lt;?php echo $value; ?&gt;_ct&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/categories-form.php:213
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;label class=&quot;form-check-label&quot; for=&quot;reporte_ct&quot;&gt;&lt;?php __(&#039;Mostrar en la web&#039;); ?&gt;&lt;/label&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;label class=&quot;form-check-label&quot; for=&quot;reporte_ct&quot;&gt;&lt;?php __(&#039;Mostrar en reporte&#039;); ?&gt;&lt;/label&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> No se puede traducir los textareas que usan redactor
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/_custom/custom.js:105
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
from_field_val = $(from_field).redactor(&#039;code.get&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
from_field_val = $(from_field).redactor(&#039;source.getCode&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/_custom/custom.js:113
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(to_field).redactor(&#039;code.set&#039;, data);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(to_field).redactor(&#039;source.setCode&#039;, data);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido enlace a plantillas de email en formularios donde se usan
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2250
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-2&quot;&gt;
  &lt;div class=&quot;form-group&gt;&quot;&gt;
      &lt;label&gt;&amp;nbsp;&lt;/label&gt;
      &lt;a href=&quot;#&quot; class=&quot;btn btn-info btn-block btn-txt2 mt-4&quot;&gt;&lt;?php __(&#039;Aplicar&#039;); ?&gt;&lt;/a&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6 mt-lg-4&quot;&gt;
  &lt;div class=&quot;form-group&gt;&quot;&gt;
      &lt;label&gt;&amp;nbsp;&lt;/label&gt;
      &lt;a href=&quot;#&quot; class=&quot;btn btn-info btn-block btn-txt2 mt-4d-inline-block &quot;&gt;&lt;?php __(&#039;Aplicar&#039;); ?&gt;&lt;/a&gt;
      &lt;a href=&quot;/intramedianet/templates/news.php&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary d-inline-block ms-2&quot;&gt;&lt;?php __(&#039;Plantillas correo&#039;); ?&gt;&lt;/a&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2314
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-2 mb-3&quot;&gt;
    &lt;div class=&quot;form-group&gt;&quot; class=&quot;form-label&quot;&gt;
        &lt;br&gt;
        &lt;a href=&quot;#&quot; class=&quot;btn btn-primary btn-block btn-txt&quot;&gt;&lt;?php __(&#039;Aplicar&#039;); ?&gt;&lt;/a&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-3 mb-3&quot;&gt;
    &lt;div class=&quot;form-group&quot; class=&quot;form-label&quot;&gt;
        &lt;br&gt;
        &lt;a href=&quot;#&quot; class=&quot;btn btn-info btn-block btn-txt&quot;&gt;&lt;?php __(&#039;Aplicar&#039;); ?&gt;&lt;/a&gt;
        &lt;a href=&quot;/intramedianet/templates/news.php&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary&quot;&gt;&lt;?php __(&#039;Plantillas correo&#039;); ?&gt;&lt;/a&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Ocultar atendido por de compradores a Agentes
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:535
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function addFields(&amp;$tNG) {
  $tNG-&gt;addColumn(&quot;user_cli&quot;, &quot;NUMERIC_TYPE&quot;, &quot;EXPRESSION&quot;, &quot;{SESSION.kt_login_id}&quot;);
  $tNG-&gt;addColumn(&quot;fecha_alta_cli&quot;, &quot;DATE_TYPE&quot;, &quot;EXPRESSION&quot;, date(&quot;d-m-Y H:i:s&quot;));
  return $tNG-&gt;getError();
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function addFields(&amp;$tNG) {
  global $_SESSION;
  $tNG-&gt;addColumn(&quot;user_cli&quot;, &quot;NUMERIC_TYPE&quot;, &quot;EXPRESSION&quot;, &quot;{SESSION.kt_login_id}&quot;);
  $tNG-&gt;addColumn(&quot;fecha_alta_cli&quot;, &quot;DATE_TYPE&quot;, &quot;EXPRESSION&quot;, date(&quot;d-m-Y H:i:s&quot;));
  if ($_SESSION[&#039;kt_login_level&#039;] == 7) {
      $tNG-&gt;addColumn(&quot;atendido_por_cli&quot;, &quot;NUMERIC_TYPE&quot;, &quot;EXPRESSION&quot;, &quot;{SESSION.kt_login_id}&quot;);
  }
  return $tNG-&gt;getError();
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:643
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;atendido_por_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;atendido_por_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($_SESSION[&#039;kt_login_level&#039;] == 7) {
  $ins_properties_client-&gt;addColumn(&quot;atendido_por_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;atendido_por_cli&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:734
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;atendido_por_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;atendido_por_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($_SESSION[&#039;kt_login_level&#039;] == 7) {
  $upd_properties_client-&gt;addColumn(&quot;atendido_por_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;atendido_por_cli&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1240
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;row&quot;&gt;
      &lt;div class=&quot;col-md-12&quot;&gt;

          &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;atendido_por_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
              &lt;label for=&quot;atendido_por_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Atendido por&#039;); ?&gt;:&lt;/label&gt;
              &lt;div class=&quot;controls&quot;&gt;
                  &lt;select name=&quot;atendido_por_cli&quot; id=&quot;atendido_por_cli&quot; class=&quot;select2&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                      &lt;?php do { ?&gt;
                      &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $row_rsproperties_client[&#039;atendido_por_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                      &lt;?php } while ($row_rsusuarios = mysql_fetch_assoc($rsusuarios));
                        $rows = mysql_num_rows($rsusuarios);
                        if($rows &gt; 0) {
                            mysql_data_seek($rsusuarios, 0);
                          $row_rsusuarios = mysql_fetch_assoc($rsusuarios);
                        } ?&gt;
                  &lt;/select&gt;
                  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;atendido_por_cli&quot;); ?&gt;
              &lt;/div&gt;
          &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($_SESSION[&#039;kt_login_level&#039;] != 7): ?&gt;
&lt;div class=&quot;col-md-3&quot;&gt;
    &lt;div class=&quot;row&quot;&gt;
      &lt;div class=&quot;col-md-12&quot;&gt;

          &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;atendido_por_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
              &lt;label for=&quot;atendido_por_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Atendido por&#039;); ?&gt;:&lt;/label&gt;
              &lt;div class=&quot;controls&quot;&gt;
                  &lt;select name=&quot;atendido_por_cli&quot; id=&quot;atendido_por_cli&quot; class=&quot;select2&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                      &lt;?php do { ?&gt;
                      &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $row_rsproperties_client[&#039;atendido_por_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                      &lt;?php } while ($row_rsusuarios = mysql_fetch_assoc($rsusuarios));
                        $rows = mysql_num_rows($rsusuarios);
                        if($rows &gt; 0) {
                            mysql_data_seek($rsusuarios, 0);
                          $row_rsusuarios = mysql_fetch_assoc($rsusuarios);
                        } ?&gt;
                  &lt;/select&gt;
                  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;atendido_por_cli&quot;); ?&gt;
              &lt;/div&gt;
          &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al responder consultas desde el crm
    </h6>
    <div class="card-body">
        Sustituir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/enquiries-form.php
/intramedianet/properties/_js/enquiries-form.js
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
