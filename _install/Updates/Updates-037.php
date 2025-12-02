<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 10 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 10-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Ajuste de exportadores xml</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Añadido tipo de vendedor a lista y buscador avanzado del panel</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajuste de exportadores xml
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/greenacres.php:134
/xml/hemnet.php:134
/xml/thinkspain.php:134
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&quot;.$tipo .&quot;
&quot;.$tipox .&quot;
&quot;.$prov .&quot;
&quot;.$provx .&quot;
&quot;.$town .&quot;
&quot;.$townx .&quot;
&quot;.$oper .&quot;
&quot;.$operx .&quot;
&quot;.$beds .&quot;
&quot;.$baths .&quot;
&quot;.$price .&quot;
&quot;.$xml .&quot;
&quot;.$kyero.&quot;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido tipo de vendedor a lista y buscador avanzado del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:65
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;type_pro&quot; id=&quot;type_pro&quot;&gt;
    &lt;select name=&quot;type_pro_sel&quot; id=&quot;type_pro_sel&quot; class=&quot;form-control input-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;1&quot;&gt;&lt;?php __(&#039;Particular&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;2&quot;&gt;&lt;?php __(&#039;Constructor&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;3&quot;&gt;&lt;?php __(&#039;Banco&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;
&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:109
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td colspan=&quot;10&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td colspan=&quot;11&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:125
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var numCols = 9;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var numCols = 10;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data.php:36
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$aColumns = array( &#039;nombre_pro&#039;, &#039;workers_pro&#039;, &#039;email_pro&#039;, &#039;telefono_fijo_pro&#039;, &#039;telefono_movil_pro&#039;, &#039;status_pro&#039;, &#039;captado_por_pro&#039;, &#039;next_call_pro&#039;, &#039;fecha_alta_pro&#039;, &#039;id_pro&#039; );
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$aColumns = array( &#039;type_pro&#039;, &#039;nombre_pro&#039;, &#039;workers_pro&#039;, &#039;email_pro&#039;, &#039;telefono_fijo_pro&#039;, &#039;telefono_movil_pro&#039;, &#039;status_pro&#039;, &#039;captado_por_pro&#039;, &#039;next_call_pro&#039;, &#039;fecha_alta_pro&#039;, &#039;id_pro&#039; );
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data.php:240
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
next_call_pro,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
next_call_pro,
case type_pro
    when '1' then '". __('Particular', true) . "'
    when '2' then '" . __('Constructor', true) . "'
    when '3' then '" . __('Banco', true) . "'
end as type_pro,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-list.js:1
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(document).ready(function() {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(document).ready(function() {

    $(&#039;#type_pro_sel&#039;).change(function(e) {

        $(&#039;#type_pro&#039;).val($(this).val()).trigger(&#039;keyup&#039;);

    });
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-list.js:37
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
oTable.fnDraw();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;select&#039;).prop(&#039;selectedIndex&#039;,0);
oTable.fnDraw();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-list.js:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
toggleScrollBarIcon();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
toggleScrollBarIcon();
if ($(&#039;#type_pro&#039;).val() != &#039;&#039;) {
    $(&#039;#type_pro_sel&#039;).val($(&#039;#type_pro&#039;).val() );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-list.js:69
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
null,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
null,
null,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-search.php:248
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;nombre_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;nombre_pro&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;nombre_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;nombre_pro&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;type_pro&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;type_pro&quot;&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;type_pro&quot; id=&quot;type_pro&quot; class=&quot;form-control&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;1&quot;&gt;&lt;?php __(&#039;Particular&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;2&quot;&gt;&lt;?php __(&#039;Constructor&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;3&quot;&gt;&lt;?php __(&#039;Banco&#039;); ?&gt;&lt;/option&gt;
    &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;type_pro&quot;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;nombre_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;nombre_pro&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;nombre_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;nombre_pro&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data-adv.php:310
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$enerpro = &#039;&#039;;
if( isset($_GET[&#039;energia_pro&#039;]) &amp;&amp; $_GET[&#039;energia_pro&#039;] != &#039;&#039; ){
  $enerpro = &quot;AND energia_pro = &quot; . $_GET[&#039;energia_pro&#039;];
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$enerpro = &#039;&#039;;
if( isset($_GET[&#039;energia_pro&#039;]) &amp;&amp; $_GET[&#039;energia_pro&#039;] != &#039;&#039; ){
  $enerpro = &quot;AND energia_pro = &quot; . $_GET[&#039;energia_pro&#039;];
}

$tipovend = &#039;&#039;;
if( isset($_GET[&#039;type_pro&#039;]) &amp;&amp; $_GET[&#039;type_pro&#039;] != &#039;&#039; ){
  $tipovend = &quot;AND type_pro = &quot; . $_GET[&#039;type_pro&#039;];
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data-adv.php:255
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$nom $apll $tel1 $tel2 $nie $nie2 $pas $pas2 $nac $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $sta $resfis $enerpro
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$nom $apll $tel1 $tel2 $nie $nie2 $pas $pas2 $nac $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $sta $resfis $enerpro $tipovend
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-search.js:67
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#puntuacion_pro, #fecha_alta_pro, #fecha_alta_pro_h, #status_pro, input[type=&quot;checkbox&quot;]&#039;).change(function(e) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#puntuacion_pro, #fecha_alta_pro, #fecha_alta_pro_h, #status_pro, input[type=&quot;checkbox&quot;], #type_pro&#039;).change(function(e) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-download-csv.php:288
/intramedianet/properties/owners-download-outlook.php:290
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sta = &#039;&#039;;
if( isset($_GET[&#039;status_pro&#039;]) &amp;&amp; $_GET[&#039;status_pro&#039;] != &#039;&#039; ){
  $sta = &quot;AND status_pro = &quot; . $_GET[&#039;status_pro&#039;];
}            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$sta = &#039;&#039;;
if( isset($_GET[&#039;status_pro&#039;]) &amp;&amp; $_GET[&#039;status_pro&#039;] != &#039;&#039; ){
  $sta = &quot;AND status_pro = &quot; . $_GET[&#039;status_pro&#039;];
}

$resfis = &#039;&#039;;
if( isset($_GET[&#039;residencia_fiscal_pro&#039;]) &amp;&amp; $_GET[&#039;residencia_fiscal_pro&#039;] != &#039;&#039; ){
  $resfis = &quot;AND residencia_fiscal_pro = &quot; . $_GET[&#039;residencia_fiscal_pro&#039;];
}

$enerpro = &#039;&#039;;
if( isset($_GET[&#039;energia_pro&#039;]) &amp;&amp; $_GET[&#039;energia_pro&#039;] != &#039;&#039; ){
  $enerpro = &quot;AND energia_pro = &quot; . $_GET[&#039;energia_pro&#039;];
}

$tipovend = &#039;&#039;;
if( isset($_GET[&#039;type_pro&#039;]) &amp;&amp; $_GET[&#039;type_pro&#039;] != &#039;&#039; ){
  $tipovend = &quot;AND type_pro = &quot; . $_GET[&#039;type_pro&#039;];
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-download-csv.php:322
/intramedianet/properties/owners-download-outlook.php:329
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$nom $apll $tel1 $tel2 $nie $pas $nac $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $sta
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$nom $apll $tel1 $tel2 $nie $pas $nac $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $sta $resfis $enerpro $tipovend
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 7 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>