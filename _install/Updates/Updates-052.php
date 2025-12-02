<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 11-12-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error al registrar un propietario desde formulario de propiedades</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al registrar un propietario desde formulario de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form-ajax.php:15
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/nxt/KT_back.php&#039; );
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/nxt/KT_back.php&#039; );

require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mediaelx/functions.php&#039; );
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4846
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
&lt;label for=&quot;como_nos_conocio_pro&quot;&gt;&lt;?php __(&#039;C&oacute;mo nos conoci&oacute;&#039;); ?&gt;:&lt;/label&gt;
&lt;div class=&quot;controls&quot;&gt;
    &lt;input type=&quot;text&quot; name=&quot;como_nos_conocio_pro&quot; id=&quot;como_nos_conocio_pro&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
&lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group&quot;&gt;
&lt;label for=&quot;captado_por_pro&quot;&gt;&lt;?php __(&#039;Captado por&#039;); ?&gt;:&lt;/label&gt;
&lt;div class=&quot;controls&quot;&gt;
    &lt;input type=&quot;text&quot; name=&quot;captado_por_pro&quot; id=&quot;captado_por_pro&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
&lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
  &lt;label for=&quot;como_nos_conocio_pro&quot;&gt;&lt;?php __(&#039;C&oacute;mo nos conoci&oacute;&#039;); ?&gt;:&lt;/label&gt;
  &lt;div class=&quot;controls&quot;&gt;
      &lt;select name=&quot;como_nos_conocio_pro&quot; id=&quot;como_nos_conocio_pro&quot; class=&quot;form-control select2&quot;&gt;
          &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          mysql_select_db($database_inmoconn, $inmoconn);
          $query_rsSources = &quot;SELECT * FROM properties_owner_sources ORDER BY category_&quot;.$lang_adm.&quot;_sts ASC&quot;;
          $rsSources = mysql_query($query_rsSources, $inmoconn) or die(mysql_error());
          $row_rsSources = mysql_fetch_assoc($rsSources);
          $totalRows_rsSources = mysql_num_rows($rsSources);
          do { ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsSources[&#039;id_sts&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsSources[&#039;category_&#039;.$lang_adm.&#039;_sts&#039;]?&gt;&lt;/option&gt;
          &lt;?php } while ($row_rsSources = mysql_fetch_assoc($rsSources));
            $rows = mysql_num_rows($rsSources);
            if($rows &gt; 0) {
                mysql_data_seek($rsSources, 0);
              $row_rsSources = mysql_fetch_assoc($rsSources);
            } ?&gt;
      &lt;/select&gt;
  &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group&quot;&gt;
    &lt;label for=&quot;captado_por_pro&quot;&gt;&lt;?php __(&#039;Captado por&#039;); ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;controls&quot;&gt;
        &lt;select name=&quot;captado_por_pro&quot; id=&quot;captado_por_pro&quot; class=&quot;form-control select2&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;?php
            mysql_select_db($database_inmoconn, $inmoconn);
            $query_rsCaptado = &quot;SELECT * FROM properties_owner_captado ORDER BY category_&quot;.$lang_adm.&quot;_cap ASC&quot;;
            $rsCaptado = mysql_query($query_rsCaptado, $inmoconn) or die(mysql_error());
            $row_rsCaptado = mysql_fetch_assoc($rsCaptado);
            $totalRows_rsCaptado = mysql_num_rows($rsCaptado);
            do { ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsCaptado [&#039;id_cap&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsCaptado [&#039;id_cap&#039;], $row_rsproperties_owner[&#039;captado_por_pro&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsCaptado [&#039;category_&#039;.$lang_adm.&#039;_cap&#039;]?&gt;&lt;/option&gt;
            &lt;?php } while ($row_rsCaptado  = mysql_fetch_assoc($rsCaptado ));
              $rows = mysql_num_rows($rsCaptado );
              if($rows &gt; 0) {
                  mysql_data_seek($rsCaptado , 0);
                $row_rsCaptado  = mysql_fetch_assoc($rsCaptado );
              } ?&gt;
        &lt;/select&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form-update-ajax.php:410
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;como_nos_conocio_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
&lt;label for=&quot;como_nos_conocio_pro&quot;&gt;&lt;?php __(&#039;C&oacute;mo nos conoci&oacute;&#039;); ?&gt;:&lt;/label&gt;
&lt;div class=&quot;controls&quot;&gt;
    &lt;input type=&quot;text&quot; name=&quot;como_nos_conocio_pro&quot; id=&quot;como_nos_conocio_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;como_nos_conocio_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;como_nos_conocio_pro&quot;); ?&gt;
&lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;captado_por_pro&quot;) != &#039;&#039;) { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
&lt;label for=&quot;captado_por_pro&quot;&gt;&lt;?php __(&#039;Captado por&#039;); ?&gt;:&lt;/label&gt;
&lt;div class=&quot;controls&quot;&gt;
    &lt;input type=&quot;text&quot; name=&quot;captado_por_pro&quot; id=&quot;captado_por_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;captado_por_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;captado_por_pro&quot;); ?&gt;
&lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;como_nos_conocio_pro&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
&lt;label for=&quot;como_nos_conocio_pro&quot;&gt;&lt;?php __(&#039;C&oacute;mo nos conoci&oacute;&#039;); ?&gt;:&lt;/label&gt;
&lt;div class=&quot;controls&quot;&gt;
  &lt;select name=&quot;como_nos_conocio_pro&quot; id=&quot;como_nos_conocio_pro&quot; class=&quot;form-control select2&quot;&gt;
      &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
      &lt;?php
      mysql_select_db($database_inmoconn, $inmoconn);
      $query_rsSources = &quot;SELECT * FROM properties_owner_sources ORDER BY category_&quot;.$lang_adm.&quot;_sts ASC&quot;;
      $rsSources = mysql_query($query_rsSources, $inmoconn) or die(mysql_error());
      $row_rsSources = mysql_fetch_assoc($rsSources);
      $totalRows_rsSources = mysql_num_rows($rsSources);
      do { ?&gt;
      &lt;option value=&quot;&lt;?php echo $row_rsSources[&#039;id_sts&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsSources[&#039;id_sts&#039;], $row_rsproperties_owner[&#039;como_nos_conocio_pro&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsSources[&#039;category_&#039;.$lang_adm.&#039;_sts&#039;]?&gt;&lt;/option&gt;
      &lt;?php } while ($row_rsSources = mysql_fetch_assoc($rsSources));
        $rows = mysql_num_rows($rsSources);
        if($rows &gt; 0) {
            mysql_data_seek($rsSources, 0);
          $row_rsSources = mysql_fetch_assoc($rsSources);
        } ?&gt;
  &lt;/select&gt;
  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;como_nos_conocio_pro&quot;); ?&gt;
&lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;captado_por_pro&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
&lt;label for=&quot;captado_por_pro&quot;&gt;&lt;?php __(&#039;Captado por&#039;); ?&gt;:&lt;/label&gt;
&lt;select name=&quot;captado_por_pro&quot; id=&quot;captado_por_pro&quot; class=&quot;form-control select2&quot;&gt;
  &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
  &lt;?php
  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsCaptado = &quot;SELECT * FROM properties_owner_captado ORDER BY category_&quot;.$lang_adm.&quot;_cap ASC&quot;;
  $rsCaptado = mysql_query($query_rsCaptado, $inmoconn) or die(mysql_error());
  $row_rsCaptado = mysql_fetch_assoc($rsCaptado);
  $totalRows_rsCaptado = mysql_num_rows($rsCaptado);
  do { ?&gt;
  &lt;option value=&quot;&lt;?php echo $row_rsCaptado [&#039;id_cap&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsCaptado [&#039;id_cap&#039;], $row_rsproperties_owner[&#039;captado_por_pro&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsCaptado [&#039;category_&#039;.$lang_adm.&#039;_cap&#039;]?&gt;&lt;/option&gt;
  &lt;?php } while ($row_rsCaptado  = mysql_fetch_assoc($rsCaptado ));
    $rows = mysql_num_rows($rsCaptado );
    if($rows &gt; 0) {
        mysql_data_seek($rsCaptado , 0);
      $row_rsCaptado  = mysql_fetch_assoc($rsCaptado );
    } ?&gt;
&lt;/select&gt;
&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;captado_por_pro&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owner-data.php:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
(SELECT category_&quot;.$lang_adm.&quot;_sts  FROM properties_owner_sources WHERE id_sts = captado_por_pro) AS como_nos_conocio_pro,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
SELECT category_&quot;.$lang_adm.&quot;_sts  FROM properties_owner_sources WHERE id_sts = como_nos_conocio_pro) AS como_nos_conocio_pro,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form-update-ajax.php:494
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;script&gt;
  var elems = Array.prototype.slice.call(document.querySelectorAll(&#039;.onoffbtn&#039;));

    elems.forEach(function(html) {
        var switchery = new Switchery(html, { size: &#039;small&#039; });
    });
&lt;/script&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>