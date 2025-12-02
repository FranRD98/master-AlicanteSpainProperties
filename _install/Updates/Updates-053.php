<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 12-12-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en la query del status en index.php</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Filtrar compradores por idioma en búsqueda avanzada</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Filtrar vendedores por idioma en búsqueda avanzada</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en la query del status en index.php
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SELECT
    properties_status.status_&quot;.$lang.&quot;_sta as sale,
    properties_status.id_sta as id,
    CASE WHEN properties_properties.activado_prop = 1  AND properties_properties.alquilado_prop = 0 AND properties_properties.vendido_prop = 0
    THEN 1
    ELSE 0
    END as visible
FROM  properties_status
    LEFT JOIN properties_properties ON properties_properties.operacion_prop = properties_status.id_sta AND properties_properties.activado_prop = 1
WHERE properties_properties.activado_prop = 1
GROUP BY id_sta
ORDER BY sale
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
SELECT
    properties_status.status_&quot;.$lang.&quot;_sta as sale,
    properties_status.id_sta as id,
    CASE WHEN properties_properties.activado_prop = 1  AND properties_properties.alquilado_prop = 0 AND properties_properties.vendido_prop = 0
    THEN 1
    ELSE 0
    END as visible
FROM  properties_status
LEFT JOIN properties_properties ON properties_properties.operacion_prop = properties_status.id_sta AND properties_properties.activado_prop = 1 AND properties_properties.alquilado_prop = 0 AND properties_properties.vendido_prop = 0
GROUP BY id_sta
ORDER BY sale
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Filtrar compradores por idioma en búsqueda avanzada
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-search.php
            </code>
        </pre>
        Después de este código:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;nacionalidad_cli&quot;) != &apos;&apos;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;nacionalidad_cli&quot;&gt;&lt;?php __(&apos;Nacionalidad&apos;); ?&gt;:&lt;/label&gt;
  &lt;input type=&quot;text&quot; name=&quot;nacionalidad_cli&quot; id=&quot;nacionalidad_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&apos;nacionalidad_cli&apos;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;nacionalidad_cli&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
  &lt;label for=&quot;idioma_cli&quot;&gt;&lt;?php __(&apos;Idioma&apos;); ?&gt;:&lt;/label&gt;
  &lt;select name=&quot;idioma_cli&quot; id=&quot;idioma_cli&quot; class=&quot;form-control&quot;&gt;
      &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
      &lt;?php
      if ($lang_adm == &apos;es&apos;) {
          $idiomas = array(&apos;da&apos; =&gt; &apos;Dan&#xe9;s&apos;, &apos;de&apos; =&gt; &apos;Alem&#xe1;n&apos;, &apos;el&apos; =&gt; &apos;Griego&apos;, &apos;en&apos; =&gt; &apos;Ingl&#xe9;s&apos;, &apos;es&apos; =&gt; &apos;Espa&#xf1;ol&apos;, &apos;fi&apos; =&gt; &apos;Finland&#xe9;s&apos;, &apos;fr&apos; =&gt; &apos;Franc&#xe9;s&apos;, &apos;is&apos; =&gt; &apos;Island&#xe9;s&apos;, &apos;it&apos; =&gt; &apos;Italiano&apos;, &apos;nl&apos; =&gt; &apos;Holand&#xe9;s&apos;, &apos;no&apos; =&gt; &apos;Noruego&apos;, &apos;pt&apos; =&gt; &apos;Portugu&#xe9;s&apos;, &apos;ru&apos; =&gt; &apos;Ruso&apos;, &apos;se&apos; =&gt; &apos;Sueco&apos;, &apos;zh&apos; =&gt; &apos;Chino&apos;);
      } else {
          $idiomas = array(&apos;da&apos; =&gt; &apos;Danish&apos;, &apos;de&apos; =&gt; &apos;German&apos;, &apos;el&apos; =&gt; &apos;Greek&apos;, &apos;en&apos; =&gt; &apos;English&apos;, &apos;es&apos; =&gt; &apos;Spanish&apos;, &apos;fi&apos; =&gt; &apos;Finnish&apos;, &apos;fr&apos; =&gt; &apos;French&apos;, &apos;is&apos; =&gt; &apos;Icelandic&apos;, &apos;it&apos; =&gt; &apos;Italian&apos;, &apos;nl&apos; =&gt; &apos;Dutch&apos;, &apos;no&apos; =&gt; &apos;Norwegian&apos;, &apos;pt&apos; =&gt; &apos;Portuguese&apos;, &apos;ru&apos; =&gt; &apos;Russian&apos;, &apos;se&apos; =&gt; &apos;Swedish&apos;, &apos;zh&apos; =&gt; &apos;Chinese&apos;);
      }
      foreach ($languages as $value) {
          echo &apos;&lt;option value=&quot;&apos;.$value.&apos;&quot;&gt;&apos;.$idiomas[$value].&apos;&lt;/option&gt;&apos;;
      }
      ?&gt;
  &lt;/select&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-search.js:111
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&apos;#puntuacion_cli, #fecha_alta_cli, #status_cli,#b_beds_cli, #b_baths_cli, #b_precio_desde_cli, #b_precio_hasta_cli, #b_orientacion_cli, #captado_por2_cli, #atendido_cli&apos;).change(function(e) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&apos;#puntuacion_cli, #fecha_alta_cli, #status_cli,#b_beds_cli, #b_baths_cli, #b_precio_desde_cli, #b_precio_hasta_cli, #b_orientacion_cli, #captado_por2_cli, #atendido_cli, #idioma_cli&apos;).change(function(e) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-data-adv.php:275
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$nac = &apos;&apos;;
if( isset($_GET[&apos;nacionalidad_cli&apos;]) &amp;&amp; $_GET[&apos;nacionalidad_cli&apos;] != &apos;&apos; ){
  $nac = &quot;AND nacionalidad_cli LIKE &apos;%&quot; . $_GET[&apos;nacionalidad_cli&apos;] . &quot;%&apos;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$nac = &apos;&apos;;
if( isset($_GET[&apos;nacionalidad_cli&apos;]) &amp;&amp; $_GET[&apos;nacionalidad_cli&apos;] != &apos;&apos; ){
  $nac = &quot;AND nacionalidad_cli LIKE &apos;%&quot; . $_GET[&apos;nacionalidad_cli&apos;] . &quot;%&apos;&quot;;
}

$idm = &apos;&apos;;
if( isset($_GET[&apos;idioma_cli&apos;]) &amp;&amp; $_GET[&apos;idioma_cli&apos;] != &apos;&apos; ){
  $idm = &quot;AND idioma_cli LIKE &apos;%&quot; . $_GET[&apos;idioma_cli&apos;] . &quot;%&apos;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-data-adv.php:559
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$pnt $nom $apll $tel1 $tel2 $nie $pas $nac $sta $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $capt2
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$pnt $nom $apll $tel1 $tel2 $nie $pas $nac $sta $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $capt2 $idm
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Filtrar vendedores por idioma en búsqueda avanzada
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-search.php
            </code>
        </pre>
        Después de este código:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;nacionalidad_pro&quot;) != &apos;&apos;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;nacionalidad_pro&quot;&gt;&lt;?php __(&apos;Nacionalidad&apos;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;nacionalidad_pro&quot; id=&quot;nacionalidad_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&apos;nacionalidad_pro&apos;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;nacionalidad_pro&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
    &lt;label for=&quot;idioma_pro&quot;&gt;&lt;?php __(&apos;Idioma&apos;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;idioma_pro&quot; id=&quot;idioma_pro&quot; class=&quot;form-control&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
        &lt;?php
        if ($lang_adm == &apos;es&apos;) {
            $idiomas = array(&apos;da&apos; =&gt; &apos;Dan&#xe9;s&apos;, &apos;de&apos; =&gt; &apos;Alem&#xe1;n&apos;, &apos;el&apos; =&gt; &apos;Griego&apos;, &apos;en&apos; =&gt; &apos;Ingl&#xe9;s&apos;, &apos;es&apos; =&gt; &apos;Espa&#xf1;ol&apos;, &apos;fi&apos; =&gt; &apos;Finland&#xe9;s&apos;, &apos;fr&apos; =&gt; &apos;Franc&#xe9;s&apos;, &apos;is&apos; =&gt; &apos;Island&#xe9;s&apos;, &apos;it&apos; =&gt; &apos;Italiano&apos;, &apos;nl&apos; =&gt; &apos;Holand&#xe9;s&apos;, &apos;no&apos; =&gt; &apos;Noruego&apos;, &apos;pt&apos; =&gt; &apos;Portugu&#xe9;s&apos;, &apos;ru&apos; =&gt; &apos;Ruso&apos;, &apos;se&apos; =&gt; &apos;Sueco&apos;, &apos;zh&apos; =&gt; &apos;Chino&apos;);
        } else {
            $idiomas = array(&apos;da&apos; =&gt; &apos;Danish&apos;, &apos;de&apos; =&gt; &apos;German&apos;, &apos;el&apos; =&gt; &apos;Greek&apos;, &apos;en&apos; =&gt; &apos;English&apos;, &apos;es&apos; =&gt; &apos;Spanish&apos;, &apos;fi&apos; =&gt; &apos;Finnish&apos;, &apos;fr&apos; =&gt; &apos;French&apos;, &apos;is&apos; =&gt; &apos;Icelandic&apos;, &apos;it&apos; =&gt; &apos;Italian&apos;, &apos;nl&apos; =&gt; &apos;Dutch&apos;, &apos;no&apos; =&gt; &apos;Norwegian&apos;, &apos;pt&apos; =&gt; &apos;Portuguese&apos;, &apos;ru&apos; =&gt; &apos;Russian&apos;, &apos;se&apos; =&gt; &apos;Swedish&apos;, &apos;zh&apos; =&gt; &apos;Chinese&apos;);
        }
        foreach ($languages as $value) {
            echo &apos;&lt;option value=&quot;&apos;.$value.&apos;&quot;&gt;&apos;.$idiomas[$value].&apos;&lt;/option&gt;&apos;;
        }
        ?&gt;
    &lt;/select&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-search.js:91
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&quot;.select2&quot;).change(function(e) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&quot;.select2, #idioma_pro&quot;).change(function(e) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data-adv.php:242
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$nac = &apos;&apos;;
if( isset($_GET[&apos;nacionalidad_pro&apos;]) &amp;&amp; $_GET[&apos;nacionalidad_pro&apos;] != &apos;&apos; ){
  $nac = &quot;AND nacionalidad_pro LIKE &apos;%&quot; . $_GET[&apos;nacionalidad_pro&apos;] . &quot;%&apos;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$nac = &apos;&apos;;
if( isset($_GET[&apos;nacionalidad_pro&apos;]) &amp;&amp; $_GET[&apos;nacionalidad_pro&apos;] != &apos;&apos; ){
  $nac = &quot;AND nacionalidad_pro LIKE &apos;%&quot; . $_GET[&apos;nacionalidad_pro&apos;] . &quot;%&apos;&quot;;
}

$idm = &apos;&apos;;
if( isset($_GET[&apos;idioma_pro&apos;]) &amp;&amp; $_GET[&apos;idioma_pro&apos;] != &apos;&apos; ){
  $idm = &quot;AND idioma_pro LIKE &apos;%&quot; . $_GET[&apos;idioma_pro&apos;] . &quot;%&apos;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data-adv.php:360
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$nom $apll $tel1 $tel2 $nie $nie2 $pas $pas2 $nac $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $sta $resfis $enerpro $tipovend
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$nom $apll $tel1 $tel2 $nie $nie2 $pas $pas2 $nac $fech $fech2 $mail $skyp $direc $con $capt $hist $nots $sta $resfis $enerpro $tipovend $idm
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>