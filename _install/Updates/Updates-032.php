<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 6 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 26-09-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Mejora en la query que coge los status</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Actualizado el exportador de Idealista a JSON</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora en la query que coge los status
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:375
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
FROM  properties_status
    LEFT JOIN properties_properties ON properties_properties.operacion_prop = properties_status.id_sta
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
FROM  properties_status
    LEFT JOIN properties_properties ON properties_properties.operacion_prop = properties_status.id_sta AND properties_properties.activado_prop = 1
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Actualizado el exportador de Idealista a JSON
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `idealista_fields_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `idealista_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:635
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_Fotocasa_Fields trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_Fotocasa_Fields trigger

//start Trigger_Idealista_Fields trigger
//remove this line if you want to edit the code by hand
function Trigger_Idealista_Fields(&amp;$tNG) {
    $tNG-&gt;setColumnValue( &#039;idealista_fields_prop&#039;, json_encode( $tNG-&gt;getColumnValue(&#039;idealista_fields_prop&#039;) ) );
}
//end Trigger_Idealista_Fields trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:721
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
    $ins_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
    $ins_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
}
if ($expIdealista == 1) {
    $ins_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Idealista_Fields&quot;, 10);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:870
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;idealista_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;idealista_prop&quot;, &quot;0&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expIdealista == 1) {
$ins_properties_properties-&gt;addColumn(&quot;idealista_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;idealista_prop&quot;, &quot;0&quot;);
$ins_properties_properties-&gt;addColumn(&quot;idealista_fields_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;idealista_fields_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:902
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Fotocasa_Update&quot;, 60);
}
if ($expIdealista == 1) {
    $upd_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Idealista_Fields&quot;, 10);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1053
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;idealista_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;idealista_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expIdealista == 1) {
$upd_properties_properties-&gt;addColumn(&quot;idealista_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;idealista_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;idealista_fields_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;idealista_fields_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3616
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;hr style=&quot;border-top-width: 10px;&quot;&gt;

&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-md-12&quot;&gt;
        &lt;div class=&quot;checkbox&quot; &lt;?php if ($expIdealista == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
            &lt;label&gt;
            &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;idealista_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;idealista_prop&quot; id=&quot;idealista_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expIdealista == 0) { ?&gt;disabled&lt;?php } ?&gt; &gt;
            &lt;?php __(&#039;Exportar a Idealista&#039;); ?&gt;
            &lt;/label&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;idealista_prop&quot;); ?&gt;
        &lt;/div&gt;
        &lt;?php if ($expIdealista == 1) { ?&gt;
        &lt;div class=&quot;checkbox&quot;&gt;
            &lt;b&gt;&lt;?php __(&#039;Campos obligatorios para la exportaci&oacute;n a Idealista&#039;); ?&gt;:&lt;/b&gt; &lt;small class=&quot;text-muted&quot;&gt;(&lt;?php __(&#039;Hacer click en el bot&oacute;n &quot;ACTUALIZAR Y SEGUIR EDITANDO&quot; para ver la informaci&oacute;n actualizada&#039;); ?&gt;)&lt;/small&gt; &lt;br&gt;
            &lt;?php if ($row_rsproperties_properties[&#039;referencia_prop&#039;]) { ?&gt;
                &lt;span class=&quot;text-success&quot;&gt;
                    &lt;i class=&quot;fa fa-check&quot;&gt;&lt;/i&gt;
            &lt;?php } else { ?&gt;
                &lt;span class=&quot;text-danger&quot;&gt;
                    &lt;i class=&quot;fa fa-times&quot;&gt;&lt;/i&gt;
            &lt;?php } ?&gt;
            &lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/span&gt; |

            &lt;?php if ($row_rsproperties_properties[&#039;direccion_prop&#039;]) { ?&gt;
                &lt;span class=&quot;text-success&quot;&gt;
                    &lt;i class=&quot;fa fa-check&quot;&gt;&lt;/i&gt;
            &lt;?php } else { ?&gt;
                &lt;span class=&quot;text-danger&quot;&gt;
                    &lt;i class=&quot;fa fa-times&quot;&gt;&lt;/i&gt;
            &lt;?php } ?&gt;
            &lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;&lt;/span&gt; |

            &lt;?php if ($row_rsproperties_properties[&#039;tipo_prop&#039;]) { ?&gt;
                &lt;span class=&quot;text-success&quot;&gt;
                    &lt;i class=&quot;fa fa-check&quot;&gt;&lt;/i&gt;
            &lt;?php } else { ?&gt;
                &lt;span class=&quot;text-danger&quot;&gt;
                    &lt;i class=&quot;fa fa-times&quot;&gt;&lt;/i&gt;
            &lt;?php } ?&gt;
            &lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/span&gt; |

            &lt;?php if ($row_rsproperties_properties[&#039;preci_reducidoo_prop&#039;]) { ?&gt;
                &lt;span class=&quot;text-success&quot;&gt;
                    &lt;i class=&quot;fa fa-check&quot;&gt;&lt;/i&gt;
            &lt;?php } else { ?&gt;
                &lt;span class=&quot;text-danger&quot;&gt;
                    &lt;i class=&quot;fa fa-times&quot;&gt;&lt;/i&gt;
            &lt;?php } ?&gt;
            &lt;?php __(&#039;Precio&#039;); ?&gt;&lt;/span&gt; |

            &lt;?php if ($row_rsproperties_properties[&#039;habitaciones_prop&#039;]) { ?&gt;
                &lt;span class=&quot;text-success&quot;&gt;
                    &lt;i class=&quot;fa fa-check&quot;&gt;&lt;/i&gt;
            &lt;?php } else { ?&gt;
                &lt;span class=&quot;text-danger&quot;&gt;
                    &lt;i class=&quot;fa fa-times&quot;&gt;&lt;/i&gt;
            &lt;?php } ?&gt;
            &lt;?php __(&#039;Habitaciones&#039;); ?&gt;&lt;/span&gt; |

            &lt;?php if ($row_rsproperties_properties[&#039;aseos_prop&#039;]) { ?&gt;
                &lt;span class=&quot;text-success&quot;&gt;
                    &lt;i class=&quot;fa fa-check&quot;&gt;&lt;/i&gt;
            &lt;?php } else { ?&gt;
                &lt;span class=&quot;text-danger&quot;&gt;
                    &lt;i class=&quot;fa fa-times&quot;&gt;&lt;/i&gt;
            &lt;?php } ?&gt;
            &lt;?php __(&#039;Aseos&#039;); ?&gt;&lt;/span&gt; |

            &lt;?php if ($row_rsproperties_properties[&#039;m2_prop&#039;]) { ?&gt;
                &lt;span class=&quot;text-success&quot;&gt;
                    &lt;i class=&quot;fa fa-check&quot;&gt;&lt;/i&gt;
            &lt;?php } else { ?&gt;
                &lt;span class=&quot;text-danger&quot;&gt;
                    &lt;i class=&quot;fa fa-times&quot;&gt;&lt;/i&gt;
            &lt;?php } ?&gt;
            &lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;&Uacute;tiles&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;&Uacute;tiles&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;&lt;/span&gt;
        &lt;/div&gt;
        &lt;?php } ?&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-12&quot;&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3862
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;!-- Fotocasa --&gt;
&lt;?php require($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/fotocasa/properties-form-fotocasa.php&#039;); ?&gt;
&lt;!-- END Fotocasa --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;!-- Fotocasa --&gt;
&lt;?php require($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/fotocasa/properties-form-fotocasa.php&#039;); ?&gt;
&lt;!-- END Fotocasa --&gt;

&lt;!-- Idealista --&gt;
&lt;?php require($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/idealista/properties-form-idealista.php&#039;); ?&gt;
&lt;!-- END Idealista --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4755
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
</script>

&lt;script&gt;
// Si cambia el checkbox de fotocasa muestra el formulario
$(&#039;#idealista_prop&#039;).change(function(e) {
  e.preventDefault();
  if ($(this).is(&#039;:checked&#039;) == true) {
    $(&#039;#basicIdealista&#039;).fadeIn(&#039;slow&#039;);
    var $val1 = $(&#039;#idealistaPropertyStatusId&#039;).val();
    var $val2 = $(&#039;#idealistaTransactionTypeId&#039;).val();
    var $val3 = $(&#039;#idealistaTypeId&#039;).val();
    if ( $val1 != &quot;&quot; &amp;&amp; $val2 != &quot;&quot; &amp;&amp; $val3 != &quot;&quot; ) {
      $(&#039;#featuresIdealista&#039;).fadeIn(&#039;slow&#039;);
    }
  } else{
    $(&#039;#basicIdealista, #featuresIdealista&#039;).fadeOut(&#039;slow&#039;);
  }
});
&lt;/script&gt;
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
$lang[&#039;Nueva construcci&oacute;n&#039;] = &#039;Nueva construcci&oacute;n&#039;;
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
$lang[&#039;Nueva construcci&oacute;n&#039;] = &#039;New build&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/IsNewConstruction:83
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// Hay que ajustar las estatus de la base de datos
// Hay que ajustar las Tipo de la base de datos
// Hay que ajustar las features de la base de datos
$idealistaFTP = &#039;213.229.163.25&#039;;
$idealistaFTPuser = &#039;mediaelx&#039;;
$idealistaFTPpass = &#039;RucNidCaw&#039;;
$idealistaFILEname = &#039;nombreinmo&#039;;
$idealistaContactName = &#039;nombreinmo&#039;;
$idealistaContactEmail = &#039;nombreinmo@nombreinmo.com&#039;;
$idealistaContactPhonePrefix = &#039;+34&#039;;
$idealistaContactPhoneNumber = &#039;666 666 666&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$idealistaFTP = &#039;213.229.163.25&#039;;
$idealistaFTPuser = &#039;mediaelx&#039;;
$idealistaFTPpass = &#039;RucNidCaw&#039;;
$idealistaFILEname = &#039;nombreinmo&#039;;
$idealistaCustomerCountry = &#039;Spain&#039;; // Requerido
$idealistaCustomerCode = &#039;ilce4d15e7ad7c6658f8cb9a2c79d577ade9778b2b2&#039;; // Requerido
$idealistaCustomerReference = &#039;&#039;; // Requerido
$idealistaContactEmail = &#039;&#039;; // Requerido
$idealistaContactPrimaryPhonePrefix = &#039;34&#039;; // Requerido
$idealistaContactPrimaryPhoneNumber = &#039;&#039;; // Requerido
$idealistaContactSecondaryPhonePrefix = &#039;&#039;; // Opcional
$idealistaContactSecondaryPhoneNumber = &#039;&#039;; // Opcional
            </code>
        </pre>
        <hr>
        Subir la carpeta:<br>
        <code>/intramedianet/properties/idealista/</code>
        <hr>
        Subir el archivo:<br>
        <code>/xml/idealista-json.php</code>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 5 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>