<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 10-09-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>  Cambios varios</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>  Búsqueda avanzada propietarios, captado por y origen tiene que ser un desplegable</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Cambios varios
    </h6>
    <div class="card-body">
        Cambios realizados:
        <pre>
            <code class="makefile pt-3">
- Solución de pequeños errores realizados durante los últimos meses<br>
- Actualizado Font Awesome a la versión 5.10.2<br>
- Substituidas la base de datos las localizaciones, tipos, opciones por las de www.qualitycostablanca.com<br>
- Actualizadas las fotos de los inmuebles<br>
- Arreglado fallo Safari con selects con fuentes de Google<br>
- Cambios en la versión responsiva<br>
- Cambio de diseño en el PDF por defecto<br>
- Ahora el vídeo de las propiedades esta a full width<br>
- Añadir la exportación de planos y videos a las pasarelas de Zoopla y Rightmove<br>
- Quicklinks destacados fijos en el Footer<br>
- reordenadas tabs en formulario de inmuebles<br>
- Añadida nueva version de la newsletter de Mailchimp<br>
- Actualizados los parseadores de las consultas de los portales<br>
- Añadido envio antumático de emails a comproadores<br>
- Fallo al mostrar inmuebles en una noticia, falta provincia<br>
- El xml de Kyero ya no incluye marcas de agua<br>
- Ajustes en el exportador de Idealista<br>
- Nuevo orden checkboxes de exportar propiedades<br>
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Búsqueda avanzada propietarios, captado por y origen tiene que ser un desplegable
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-search.php:96
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsStatus = mysql_num_rows($rsStatus);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsStatus = mysql_num_rows($rsStatus);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsCaptado = &quot;SELECT * FROM properties_owner_captado ORDER BY category_&quot;.$lang_adm.&quot;_cap ASC&quot;;
$rsCaptado = mysql_query($query_rsCaptado, $inmoconn) or die(mysql_error());
$row_rsCaptado = mysql_fetch_assoc($rsCaptado);
$totalRows_rsCaptado = mysql_num_rows($rsCaptado);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsSources = &quot;SELECT * FROM properties_owner_sources ORDER BY category_&quot;.$lang_adm.&quot;_sts ASC&quot;;
$rsSources = mysql_query($query_rsSources, $inmoconn) or die(mysql_error());
$row_rsSources = mysql_fetch_assoc($rsSources);
$totalRows_rsSources = mysql_num_rows($rsSources);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-search.php:400
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;como_nos_conocio_pro&quot; id=&quot;como_nos_conocio_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;como_nos_conocio_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;como_nos_conocio_pro&quot; id=&quot;como_nos_conocio_pro&quot; class=&quot;form-control select2&quot;&gt;
    &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
    &lt;?php do { ?&gt;
    &lt;option value=&quot;&lt;?php echo $row_rsSources[&#039;id_sts&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsSources[&#039;category_&#039;.$lang_adm.&#039;_sts&#039;]?&gt;&lt;/option&gt;
    &lt;?php } while ($row_rsSources = mysql_fetch_assoc($rsSources));
    $rows = mysql_num_rows($rsSources);
    if($rows &gt; 0) {
        mysql_data_seek($rsSources, 0);
      $row_rsSources = mysql_fetch_assoc($rsSources);
    } ?&gt;
&lt;/select&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-search.php:416
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if($_SESSION[&#039;kt_login_level&#039;] != 8) { ?&gt;
&lt;input type=&quot;text&quot; name=&quot;captado_por_pro&quot; id=&quot;captado_por_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;captado_por_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
&lt;?php } else { ?&gt;
&lt;input type=&quot;hidden&quot; name=&quot;captado_por_pro&quot; id=&quot;captado_por_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;captado_por_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;captado_por_pro&#039;]); ?&gt;
&lt;?php } ?&gt;
&lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;captado_por_pro&quot;); ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;captado_por_pro&quot; id=&quot;captado_por_pro&quot; class=&quot;form-control select2&quot;&gt;
    &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
    &lt;?php do { ?&gt;
    &lt;option value=&quot;&lt;?php echo $row_rsCaptado [&#039;id_cap&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsCaptado [&#039;category_&#039;.$lang_adm.&#039;_cap&#039;]?&gt;&lt;/option&gt;
    &lt;?php } while ($row_rsCaptado  = mysql_fetch_assoc($rsCaptado ));
      $rows = mysql_num_rows($rsCaptado );
      if($rows &gt; 0) {
          mysql_data_seek($rsCaptado , 0);
        $row_rsCaptado  = mysql_fetch_assoc($rsCaptado );
      } ?&gt;
&lt;/select&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>