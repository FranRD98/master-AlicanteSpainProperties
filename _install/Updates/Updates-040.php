<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 17 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 23-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadidos videos al exportador de Prian</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Fix exportador de Zoopla, id incorrecta de new build, añadida variable con la id para ajustarlo mejor</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Fix features al duplicar inmuebles</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Fix error al mostrar la descripción de los inmuebles que se muestran en una noticia</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Fix popup propiedades similares de un inmueble</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Fix envio de emails sin propiedades en formulario de clientes</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Error Quicklinks URLs con []</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> Fix botones añadir inmuebles, compradores y propietarios desde el menu superior del panel</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadidos videos al exportador de Prian
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/prian.php:327
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;videos&gt;
&lt;video&gt;
  &lt;filename&gt;&lt;/filename&gt;
  &lt;middle_filename&gt;&lt;/middle_filename&gt;
&lt;/video&gt;
&lt;/videos&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;videos&gt;
  &lt;?php
  mysql_select_db($database_appconn, $appconn);
  $query_rsVideos = &quot;SELECT video_vid, id_vid FROM  properties_videos WHERE  property_vid = &#039;&quot;.$row_rsprian[&#039;id&#039;].&quot;&#039; ORDER BY order_vid ASC LIMIT 0, 10&quot;;
  $rsVideos = mysql_query($query_rsVideos, $appconn) or die(mysql_error());
  $row_rsVideos = mysql_fetch_assoc($rsVideos);
  $totalRows_rsVideos = mysql_num_rows($rsVideos);
  $i = 0;
  if($totalRows_rsVideos &gt;0) {
  do {
      if ($row_rsVideos[&#039;video_vid&#039;] != &#039;&#039;) {
          preg_match_all(&#039;/&lt;iframe[^&gt;]+src=([\&#039;&quot;])(?&lt;src&gt;.+?)\1[^&gt;]*&gt;/i&#039;, $row_rsVideos[&#039;video_vid&#039;], $result);
  ?&gt;
          &lt;video&gt;
            &lt;filename&gt;&lt;?php echo str_replace(&quot;embed/&quot;,&quot;watch?v=&quot;, str_replace(&quot;?rel=0&quot;,&quot;&quot;, $result[&#039;src&#039;][0])) ?&gt;&lt;/filename&gt;
            &lt;middle_filename&gt;&lt;/middle_filename&gt;
          &lt;/video&gt;
  &lt;?php
      }
  } while ($row_rsVideos = mysql_fetch_assoc($rsVideos));
  }
  ?&gt;
&lt;/videos&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix exportador de Zoopla, id incorrecta de new build, añadida variable con la id para ajustarlo mejor
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:60
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$zooplaFTPpass = &#039;y2KQpZtcHyAN&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$zooplaFTPpass = &#039;y2KQpZtcHyAN&#039;;
$zooplaNewBuildId = &#039;2&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/zoopla.php:157
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($row_rsProperties[&#039;operacion_prop&#039;] == &#039;16&#039;) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsProperties[&#039;operacion_prop&#039;] == $zooplaNewBuildId) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix features al duplicar inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-dupli.php:301
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($prop != &#039;&#039;) {

  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsRegistros = &quot;SELECT * FROM properties_property_feature WHERE property = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
  $rsRegistros = mysql_query($query_rsRegistros, $inmoconn) or die(mysql_error());
  $row_rsRegistros = mysql_fetch_assoc($rsRegistros);
  $totalRows_rsRegistros = mysql_num_rows($rsRegistros);

  if ($totalRows_rsRegistros &gt; 0) {

    do {

      mysql_select_db($database_inmoconn, $inmoconn);
      $query_rsInsert = &quot;INSERT INTO `properties_property_feature`  (`property`, `feature`) VALUES (&#039;$prop&#039;, &#039;&quot;.$row_rsRegistros[&#039;feature&#039;].&quot;&#039;)&quot;;
      $rsInsert = mysql_query($query_rsInsert, $inmoconn) or die(mysql_error());

    } while ($row_rsRegistros = mysql_fetch_assoc($rsRegistros));

  }

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($prop != &#039;&#039;) {

  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsRegistros = &quot;SELECT * FROM properties_property_feature_priv WHERE property = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
  $rsRegistros = mysql_query($query_rsRegistros, $inmoconn) or die(mysql_error());
  $row_rsRegistros = mysql_fetch_assoc($rsRegistros);
  $totalRows_rsRegistros = mysql_num_rows($rsRegistros);

  if ($totalRows_rsRegistros &gt; 0) {

    do {

      mysql_select_db($database_inmoconn, $inmoconn);
      $query_rsInsert = &quot;INSERT INTO `properties_property_feature_priv`  (`property`, `feature`) VALUES (&#039;$prop&#039;, &#039;&quot;.$row_rsRegistros[&#039;feature&#039;].&quot;&#039;)&quot;;
      $rsInsert = mysql_query($query_rsInsert, $inmoconn) or die(mysql_error());

    } while ($row_rsRegistros = mysql_fetch_assoc($rsRegistros));

  }

}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-dupli.php:258
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
default:
    $sql .= &quot;`&quot;.$colname[$i][0].&quot;`  =  &#039;&quot;.mysql_real_escape_string( $row[$i] ) . &quot;&#039;, \n&quot;;
break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
default:
if(is_null($row[$i])){
  $sql .= &quot;`&quot;.$colname[$i][0].&quot;`  =  NULL, \n&quot;;
} else {
  $sql .= &quot;`&quot;.$colname[$i][0].&quot;`  =  &#039;&quot;.mysql_real_escape_string( $row[$i] ) . &quot;&#039;, \n&quot;;
}
break;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix error al mostrar los inmuebles que se muestran en una noticia
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/new.php:396
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.descripcion_&quot;.$lang.&quot;_prop as description,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_properties.descripcion_&quot;.$lang.&quot;_prop as description,
properties_properties.descripcion_&quot;.$lang.&quot;_prop as descr,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix popup propiedades similares de un inmueble
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/property.php:466
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($similares[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similares = getRecords(sprintf($similaresQuery, &quot; &quot; . $ciudadQuery . &quot; &quot;));
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($similares[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similares = getRecords(sprintf($similaresQuery, &quot; &quot; . $ciudadQuery . &quot; &quot;));
}

if ($similares[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similares = getRecords(sprintf($similaresQuery, &quot;&quot;));
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix envio de emails sin propiedades en formulario de clientes
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:44
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Error Quicklinks URLs con []
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:337
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$tw = &#039;&#039;;
if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_town_nws&#039;]);
    foreach ($parts as $part) {
        $tw .= &#039;&amp;loct%5B%5D=&#039; . $part;
    }
}

$loc = &#039;&#039;;
if ($row_rsLandings[&#039;quick_location_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_location_nws&#039;]);
    foreach ($parts as $part) {
        $loc .= &#039;&amp;lozn%5B%5D=&#039; . $part;
    }
}

$typ = &#039;&#039;;
if ($row_rsLandings[&#039;quick_type_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_type_nws&#039;]);
    foreach ($parts as $part) {
        $typ .= &#039;&amp;tp%5B%5D=&#039; . $part;
    }
}

$sta = &#039;&#039;;
if ($row_rsLandings[&#039;quick_status_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_status_nws&#039;]);
    foreach ($parts as $part) {
        $sta .= &#039;&amp;st%5B%5D=&#039; . $part;
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$tw = &#039;&#039;;
if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_town_nws&#039;]);
    foreach ($parts as $part) {
        $tw .= &#039;&amp;loct\%5B\%5D=&#039; . $part;
    }
}

$loc = &#039;&#039;;
if ($row_rsLandings[&#039;quick_location_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_location_nws&#039;]);
    foreach ($parts as $part) {
        $loc .= &#039;&amp;lozn\%5B\%5D=&#039; . $part;
    }
}

$typ = &#039;&#039;;
if ($row_rsLandings[&#039;quick_type_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_type_nws&#039;]);
    foreach ($parts as $part) {
        $typ .= &#039;&amp;tp\%5B\%5D=&#039; . $part;
    }
}

$sta = &#039;&#039;;
if ($row_rsLandings[&#039;quick_status_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_status_nws&#039;]);
    foreach ($parts as $part) {
        $sta .= &#039;&amp;st\%5B\%5D=&#039; . $part;
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix botones añadir inmuebles, compradores y propietarios desde el menu superior del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalProp&quot;&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:205
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;div class=&quot;modal fade&quot; id=&quot;myModal&quot; tabindex=&quot;-1&quot; role=&quot;dialog&quot; aria-labelledby=&quot;myModalLabel&quot;&gt;
    &lt;div class=&quot;modal-dialog&quot; role=&quot;document&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header&quot;&gt;
                &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;&lt;span aria-hidden=&quot;true&quot;&gt;&amp;times;&lt;/span&gt;&lt;/button&gt;
                &lt;h4 class=&quot;modal-title&quot; id=&quot;myModalLabel&quot;&gt;&lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Inmueble&#039;); ?&gt;&lt;/h4&gt;
            &lt;/div&gt;
            &lt;form id=&quot;form1&quot; action=&quot;/intramedianet/properties/properties-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
                &lt;div class=&quot;modal-body&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;referencia_prop&quot;&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;referencia_prop&quot; id=&quot;referencia_prop&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;modal-footer&quot;&gt;
                    &lt;button type=&quot;button&quot; class=&quot;btn btn-default&quot; data-dismiss=&quot;modal&quot;&gt;&lt;?php __(&#039;Cerrar&#039;); ?&gt;&lt;/button&gt;
                    &lt;input type=&quot;submit&quot; name=&quot;KT_Insert2&quot; value=&quot;&lt;?php echo NXT_getResource(&quot;Insert_FB&quot;); ?&gt;&quot; class=&quot;btn btn-success&quot; /&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalCli&quot;&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:145
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;div class=&quot;modal fade&quot; id=&quot;myModal&quot; tabindex=&quot;-1&quot; role=&quot;dialog&quot; aria-labelledby=&quot;myModalLabel&quot;&gt;
    &lt;div class=&quot;modal-dialog&quot; role=&quot;document&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header&quot;&gt;
                &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;&lt;span aria-hidden=&quot;true&quot;&gt;&amp;times;&lt;/span&gt;&lt;/button&gt;
                &lt;h4 class=&quot;modal-title&quot; id=&quot;myModalLabel&quot;&gt;&lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/h4&gt;
            &lt;/div&gt;
            &lt;form id=&quot;form1&quot; action=&quot;/intramedianet/properties/clients-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
                &lt;div class=&quot;modal-body&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;nombre_cli&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;nombre_cli&quot; id=&quot;nombre_cli&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                    &lt;/div&gt;
                  &lt;div class=&quot;form-group&quot;&gt;
                      &lt;label for=&quot;idioma_cli&quot;&gt;&lt;?php __(&#039;Idioma&#039;); ?&gt;:&lt;/label&gt;
                      &lt;select name=&quot;idioma_cli&quot; id=&quot;idioma_cli&quot; class=&quot;form-control required&quot;&gt;
                          &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                          &lt;?php
                          if ($lang_adm == &#039;es&#039;) {
                              $idiomas = array(&#039;da&#039; =&gt; &#039;Dan&eacute;s&#039;, &#039;de&#039; =&gt; &#039;Alem&aacute;n&#039;, &#039;el&#039; =&gt; &#039;Griego&#039;, &#039;en&#039; =&gt; &#039;Ingl&eacute;s&#039;, &#039;es&#039; =&gt; &#039;Espa&ntilde;ol&#039;, &#039;fi&#039; =&gt; &#039;Finland&eacute;s&#039;, &#039;fr&#039; =&gt; &#039;Franc&eacute;s&#039;, &#039;is&#039; =&gt; &#039;Island&eacute;s&#039;, &#039;it&#039; =&gt; &#039;Italiano&#039;, &#039;nl&#039; =&gt; &#039;Holand&eacute;s&#039;, &#039;no&#039; =&gt; &#039;Noruego&#039;, &#039;pt&#039; =&gt; &#039;Portugu&eacute;s&#039;, &#039;ru&#039; =&gt; &#039;Ruso&#039;, &#039;se&#039; =&gt; &#039;Sueco&#039;, &#039;zh&#039; =&gt; &#039;Chino&#039;);
                          } else {
                              $idiomas = array(&#039;da&#039; =&gt; &#039;Danish&#039;, &#039;de&#039; =&gt; &#039;German&#039;, &#039;el&#039; =&gt; &#039;Greek&#039;, &#039;en&#039; =&gt; &#039;English&#039;, &#039;es&#039; =&gt; &#039;Spanish&#039;, &#039;fi&#039; =&gt; &#039;Finnish&#039;, &#039;fr&#039; =&gt; &#039;French&#039;, &#039;is&#039; =&gt; &#039;Icelandic&#039;, &#039;it&#039; =&gt; &#039;Italian&#039;, &#039;nl&#039; =&gt; &#039;Dutch&#039;, &#039;no&#039; =&gt; &#039;Norwegian&#039;, &#039;pt&#039; =&gt; &#039;Portuguese&#039;, &#039;ru&#039; =&gt; &#039;Russian&#039;, &#039;se&#039; =&gt; &#039;Swedish&#039;, &#039;zh&#039; =&gt; &#039;Chinese&#039;);
                          }
                          foreach ($languages as $value) {
                              $selected = (!(strcmp($value, $row_rsproperties_client[&#039;idioma_cli&#039;])))?&quot; SELECTED&quot;:&quot;&quot;;
                              echo &#039;&lt;option value=&quot;&#039;.$value.&#039;&quot;&#039;.$selected.&#039;&gt;&#039;.$idiomas[$value].&#039;&lt;/option&gt;&#039;;
                          }
                          ?&gt;
                      &lt;/select&gt;
                  &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;modal-footer&quot;&gt;
                    &lt;button type=&quot;button&quot; class=&quot;btn btn-default&quot; data-dismiss=&quot;modal&quot;&gt;&lt;?php __(&#039;Cerrar&#039;); ?&gt;&lt;/button&gt;
                    &lt;input type=&quot;submit&quot; name=&quot;KT_Insert2&quot; value=&quot;&lt;?php echo NXT_getResource(&quot;Insert_FB&quot;); ?&gt;&quot; class=&quot;btn btn-success&quot; /&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalOwn&quot;&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:130
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;div class=&quot;modal fade&quot; id=&quot;myModal&quot; tabindex=&quot;-1&quot; role=&quot;dialog&quot; aria-labelledby=&quot;myModalLabel&quot;&gt;
    &lt;div class=&quot;modal-dialog&quot; role=&quot;document&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header&quot;&gt;
                &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;&lt;span aria-hidden=&quot;true&quot;&gt;&amp;times;&lt;/span&gt;&lt;/button&gt;
                &lt;h4 class=&quot;modal-title&quot; id=&quot;myModalLabel&quot;&gt;&lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Propietario&#039;); ?&gt;&lt;/h4&gt;
            &lt;/div&gt;
            &lt;form id=&quot;form1&quot; action=&quot;/intramedianet/properties/owners-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
                &lt;div class=&quot;modal-body&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;nombre_pro&quot; id=&quot;nameprom&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;modal-footer&quot;&gt;
                    &lt;button type=&quot;button&quot; class=&quot;btn btn-default&quot; data-dismiss=&quot;modal&quot;&gt;&lt;?php __(&#039;Cerrar&#039;); ?&gt;&lt;/button&gt;
                    &lt;input type=&quot;submit&quot; name=&quot;KT_Insert2&quot; value=&quot;&lt;?php echo NXT_getResource(&quot;Insert_FB&quot;); ?&gt;&quot; class=&quot;btn btn-success&quot; /&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.footer.php
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
&lt;?php include( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/modals-add.php&#039; ); ?&gt;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:474
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;ul class=&quot;dropdown-menu animated zoomIn&quot; role=&quot;menu&quot;&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;inmueble&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php if($actClients == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-users&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if($actPropietarios == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-key&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;propietario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actNoticias == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/news/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-newspaper-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Noticia&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actPaginas == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/pages/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-sitemap&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;P&aacute;gina&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actLanding == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/landing/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-file-text-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Landing Page&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actLanding == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/quicklinks/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-link&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Quicklink&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &#039;demo.mediaelx.info&#039; || ($_SERVER[&quot;HTTP_HOST&quot;] == &#039;demo.mediaelx.info&#039; &amp;&amp; $_SESSION[&#039;kt_login_id&#039;] == 47)): ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/users/users-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-user&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Usuario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php endif ?&gt;
&lt;/ul&gt;
            </code>
        Por:
        <pre>
            <code class="php">
&lt;ul class=&quot;dropdown-menu animated zoomIn&quot; role=&quot;menu&quot;&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalProp&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;inmueble&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php if($actClients == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalCli&quot;&gt;&lt;i class=&quot;fa fa-fw fa-users&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if($actPropietarios == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalOwn&quot;&gt;&lt;i class=&quot;fa fa-fw fa-key&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;propietario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actNoticias == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/news/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-newspaper-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Noticia&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actTasks == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/tasks/tasks-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-tasks&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Tarea&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actCalendar == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/calendar/calendario.php?add=ok&quot;&gt;&lt;i class=&quot;fa fa-fw fa-calendar&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &#039;demo.mediaelx.info&#039; || ($_SERVER[&quot;HTTP_HOST&quot;] == &#039;demo.mediaelx.info&#039; &amp;&amp; $_SESSION[&#039;kt_login_id&#039;] == 47)): ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/users/users-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-user&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Usuario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php endif ?&gt;
&lt;/ul&gt;
            </code>
        </pre>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-agente.php:25
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;inmueble&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php if($actClients == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-users&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;?php if($actPropietarios == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-key&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;propietario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalProp&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;inmueble&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php if($actClients == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalCli&quot;&gt;&lt;i class=&quot;fa fa-fw fa-users&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;?php if($actPropietarios == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalOwn&quot;&gt;&lt;i class=&quot;fa fa-fw fa-key&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;propietario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-empleado.php:245
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;ul class=&quot;dropdown-menu animated zoomIn&quot; role=&quot;menu&quot;&gt;
&lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalProp&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;inmueble&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php if($actClients == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-users&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;?php if($actPropietarios == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModal&quot;&gt;&lt;i class=&quot;fa fa-fw fa-key&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;propietario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;?php if ($actNoticias == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;/intramedianet/news/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-newspaper-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Noticia&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;?php if ($actPaginas == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;/intramedianet/pages/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-sitemap&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;P&aacute;gina&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;?php if ($actLanding == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;/intramedianet/landing/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-file-text-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Landing Page&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;?php if ($actLanding == 1) { ?&gt;
    &lt;li&gt;&lt;a href=&quot;/intramedianet/quicklinks/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-link&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Quicklink&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
    &lt;li&gt;&lt;a href=&quot;/intramedianet/users/users-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-user&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Usuario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;ul class=&quot;dropdown-menu animated zoomIn&quot; role=&quot;menu&quot;&gt;
    &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalProp&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;inmueble&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php if($actClients == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalCli&quot;&gt;&lt;i class=&quot;fa fa-fw fa-users&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;  &lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if($actPropietarios == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot; data-toggle=&quot;modal&quot; data-target=&quot;#myModalOwn&quot;&gt;&lt;i class=&quot;fa fa-fw fa-key&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;propietario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actNoticias == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/news/news-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-newspaper-o&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Noticia&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actTasks == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/tasks/tasks-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-tasks&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Tarea&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($actCalendar == 1) { ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/calendar/calendario.php?add=ok&quot;&gt;&lt;i class=&quot;fa fa-fw fa-calendar&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php } ?&gt;
    &lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &#039;demo.mediaelx.info&#039; || ($_SERVER[&quot;HTTP_HOST&quot;] == &#039;demo.mediaelx.info&#039; &amp;&amp; $_SESSION[&#039;kt_login_id&#039;] == 47)): ?&gt;
        &lt;li&gt;&lt;a href=&quot;/intramedianet/users/users-form.php?KT_back=1&quot;&gt;&lt;i class=&quot;fa fa-fw fa-user&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt; &lt;?php __(&#039;Usuario&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
    &lt;?php endif ?&gt;
&lt;/ul&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/calendario.php:444
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
});
&lt;?php if($_GET[&#039;add&#039;] == &#039;ok&#039;) { ?&gt;
$( document ).ready(function() {
    $(&#039;.add-cita&#039;).click();
});
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/intramedianet/properties/modals-add.php</code> de esta versión.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 10 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>