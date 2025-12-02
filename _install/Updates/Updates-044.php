<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 06-11-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en exportador de Prian</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido provincia a quicklinks</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido provincia a noticias</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en exportador de Prian
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/prian.php:226
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;type_id&gt;&lt;?php if($row_rsprian[&#039;operacion_prop&#039;]==7 || $row_rsprian[&#039;operacion_prop&#039;]== 12) {echo &#039;2&#039;;} else { echo &#039;1&#039;;} ?&gt;&lt;/type_id&gt;
&lt;object_status&gt;&lt;?php if($row_rsprian[&#039;operacion_prop&#039;]==7 || $row_rsprian[&#039;operacion_prop&#039;]== 12) {echo &#039;125&#039;;} else {echo &#039;121&#039;;} ?&gt;&lt;/object_status&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;type_id&gt;&lt;?php if($row_rsprian[&#039;operacion_prop&#039;]==3 || $row_rsprian[&#039;operacion_prop&#039;]== 4) {echo &#039;2&#039;;} else { echo &#039;1&#039;;} ?&gt;&lt;/type_id&gt;
&lt;object_status&gt;&lt;?php if($row_rsprian[&#039;operacion_prop&#039;]==3 || $row_rsprian[&#039;operacion_prop&#039;]== 4) {echo &#039;125&#039;;} else {echo &#039;121&#039;;} ?&gt;&lt;/object_status&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/prian.php:239
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($row_rsprian[&#039;operacion_prop&#039;] == 1 &amp;&amp; $row_rsprian[&#039;operacion_prop&#039;] == 2) { ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
 &lt;?php if ($row_rsprian[&#039;operacion_prop&#039;] == 1 || $row_rsprian[&#039;operacion_prop&#039;] == 2) { ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido provincia a quicklinks
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `news` ADD COLUMN `quick_province_nws` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `quick_town_nws`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:153
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsZonas = mysql_num_rows($rsZonas);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsZonas = mysql_num_rows($rsZonas);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsProvincias = &quot;
 SELECT DISTINCT

    properties_loc1.name_&quot;.$lang_adm.&quot;_loc1 ,
    CASE WHEN properties_loc2.name_&quot;.$lang_adm.&quot;_loc2 IS NOT NULL THEN properties_loc2.name_&quot;.$lang_adm.&quot;_loc2 ELSE province1.name_&quot;.$lang_adm.&quot;_loc2  END AS name_&quot;.$lang_adm.&quot;_loc2,
    CASE WHEN properties_loc3.name_&quot;.$lang_adm.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang_adm.&quot;_loc3 ELSE areas1.name_&quot;.$lang_adm.&quot;_loc3  END AS name_&quot;.$lang_adm.&quot;_loc3,
    CASE WHEN properties_loc4.name_&quot;.$lang_adm.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$lang_adm.&quot;_loc4 ELSE towns.name_&quot;.$lang_adm.&quot;_loc4  END AS name_&quot;.$lang_adm.&quot;_loc4,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id_loc2

FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

GROUP BY id_loc2

ORDER BY name_&quot;.$lang_adm.&quot;_loc1, name_&quot;.$lang_adm.&quot;_loc2 ASC
&quot;;
$rsProvincias = mysql_query($query_rsProvincias, $inmoconn) or die(mysql_error());
$row_rsProvincias = mysql_fetch_assoc($rsProvincias);
$totalRows_rsProvincias = mysql_num_rows($rsProvincias);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:368
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$tw = &#039;&#039;;
if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_town_nws&#039;]);
    foreach ($parts as $part) {
        $tw .= &#039;&amp;loct\%5B\%5D=&#039; . $part;
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$prov = &#039;&#039;;
if ($row_rsLandings[&#039;quick_province_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_province_nws&#039;]);
    foreach ($parts as $part) {
        $prov .= &#039;&amp;lopr\%5B\%5D=&#039; . $part;
    }
}

$tw = &#039;&#039;;
if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_town_nws&#039;]);
    foreach ($parts as $part) {
        $tw .= &#039;&amp;loct\%5B\%5D=&#039; . $part;
    }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:408
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($language == $value) {
    $newText .= &quot;\nRewriteRule ^&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
} else {
    $newText .= &quot;\nRewriteRule ^&quot;.$value.&quot;/&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($language == $value) {
    $newText .= &quot;\nRewriteRule ^&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$prov.&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
} else {
    $newText .= &quot;\nRewriteRule ^&quot;.$value.&quot;/&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$prov.&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:445
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (isset($_POST[&#039;quick_location_nws&#039;]) &amp;&amp; $_POST[&#039;quick_location_nws&#039;] != &#039;&#039; ) {
  $_POST[&#039;quick_location_nws&#039;] = implode(&#039;,&#039;, $_POST[&#039;quick_location_nws&#039;]);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (isset($_POST[&#039;quick_location_nws&#039;]) &amp;&amp; $_POST[&#039;quick_location_nws&#039;] != &#039;&#039; ) {
  $_POST[&#039;quick_location_nws&#039;] = implode(&#039;,&#039;, $_POST[&#039;quick_location_nws&#039;]);
}
if (isset($_POST[&#039;quick_province_nws&#039;]) &amp;&amp; $_POST[&#039;quick_province_nws&#039;] != &#039;&#039; ) {
  $_POST[&#039;quick_province_nws&#039;] = implode(&#039;,&#039;, $_POST[&#039;quick_province_nws&#039;]);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:477
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_province_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_province_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:505
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_province_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_province_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:615
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;

    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;quick_town_nws&quot;&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;quick_town_nws[]&quot; id=&quot;quick_town_nws&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
            &lt;?php
            do {
              $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_town_nws&#039;]);
            ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsZonas[&#039;id_loc3&#039;]?&gt;&quot;&lt;?php if (in_array($row_rsZonas[&#039;id_loc3&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt;&lt;/option&gt;
            &lt;?php
            } while ($row_rsZonas = mysql_fetch_assoc($rsZonas ));
            $rows = mysql_num_rows($rsZonas );
            if($rows &gt; 0) {
            mysql_data_seek($rsZonas , 0);
            $row_rsZonas = mysql_fetch_assoc($rsZonas );
            }
            ?&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;); ?&gt;
    &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;quick_location_nws&quot;&gt;&lt;?php __(&#039;Zona&#039;); ?&gt;:&lt;/label&gt;
              &lt;select name=&quot;quick_location_nws[]&quot; id=&quot;quick_location_nws&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
                &lt;?php
                do {
                    $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_location_nws&#039;]);
                ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_Recordset2[&#039;id_loc4&#039;]?&gt;&quot; &lt;?php if (in_array($row_Recordset2[&#039;id_loc4&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc4&#039;]; ?&gt;&lt;/option&gt;
                &lt;?php
                } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
                $rows = mysql_num_rows($Recordset2);
                if($rows &gt; 0) {
                mysql_data_seek($Recordset2, 0);
                $row_Recordset2 = mysql_fetch_assoc($Recordset2);
                }
                ?&gt;
            &lt;/select&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;

  &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_province_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;quick_province_nws&quot;&gt;&lt;?php __(&#039;Provincia&#039;); ?&gt;:&lt;/label&gt;
      &lt;select name=&quot;quick_province_nws[]&quot; id=&quot;quick_province_nws&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
          &lt;?php
          do {
            $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_province_nws&#039;]);
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsProvincias[&#039;id_loc2&#039;]?&gt;&quot;&lt;?php if (in_array($row_rsProvincias[&#039;id_loc2&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsProvincias[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsProvincias[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsProvincias = mysql_fetch_assoc($rsProvincias ));
          $rows = mysql_num_rows($rsProvincias );
          if($rows &gt; 0) {
          mysql_data_seek($rsProvincias , 0);
          $row_rsProvincias = mysql_fetch_assoc($rsProvincias );
          }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_province_nws&quot;); ?&gt;
  &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;quick_town_nws&quot;&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;quick_town_nws[]&quot; id=&quot;quick_town_nws&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
            &lt;?php
            do {
              $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_town_nws&#039;]);
            ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsZonas[&#039;id_loc3&#039;]?&gt;&quot;&lt;?php if (in_array($row_rsZonas[&#039;id_loc3&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt;&lt;/option&gt;
            &lt;?php
            } while ($row_rsZonas = mysql_fetch_assoc($rsZonas ));
            $rows = mysql_num_rows($rsZonas );
            if($rows &gt; 0) {
            mysql_data_seek($rsZonas , 0);
            $row_rsZonas = mysql_fetch_assoc($rsZonas );
            }
            ?&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;); ?&gt;
    &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;quick_location_nws&quot;&gt;&lt;?php __(&#039;Zona&#039;); ?&gt;:&lt;/label&gt;
              &lt;select name=&quot;quick_location_nws[]&quot; id=&quot;quick_location_nws&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
                &lt;?php
                do {
                    $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_location_nws&#039;]);
                ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_Recordset2[&#039;id_loc4&#039;]?&gt;&quot; &lt;?php if (in_array($row_Recordset2[&#039;id_loc4&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc4&#039;]; ?&gt;&lt;/option&gt;
                &lt;?php
                } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
                $rows = mysql_num_rows($Recordset2);
                if($rows &gt; 0) {
                mysql_data_seek($Recordset2, 0);
                $row_Recordset2 = mysql_fetch_assoc($Recordset2);
                }
                ?&gt;
            &lt;/select&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido provincia a noticias
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:134
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsZonas = mysql_num_rows($rsZonas);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsZonas = mysql_num_rows($rsZonas);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsProvincias = &quot;
 SELECT DISTINCT

    properties_loc1.name_&quot;.$lang_adm.&quot;_loc1 ,
    CASE WHEN properties_loc2.name_&quot;.$lang_adm.&quot;_loc2 IS NOT NULL THEN properties_loc2.name_&quot;.$lang_adm.&quot;_loc2 ELSE province1.name_&quot;.$lang_adm.&quot;_loc2  END AS name_&quot;.$lang_adm.&quot;_loc2,
    CASE WHEN properties_loc3.name_&quot;.$lang_adm.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang_adm.&quot;_loc3 ELSE areas1.name_&quot;.$lang_adm.&quot;_loc3  END AS name_&quot;.$lang_adm.&quot;_loc3,
    CASE WHEN properties_loc4.name_&quot;.$lang_adm.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$lang_adm.&quot;_loc4 ELSE towns.name_&quot;.$lang_adm.&quot;_loc4  END AS name_&quot;.$lang_adm.&quot;_loc4,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id_loc2

FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

GROUP BY id_loc2

ORDER BY name_&quot;.$lang_adm.&quot;_loc1, name_&quot;.$lang_adm.&quot;_loc2 ASC
&quot;;
$rsProvincias = mysql_query($query_rsProvincias, $inmoconn) or die(mysql_error());
$row_rsProvincias = mysql_fetch_assoc($rsProvincias);
$totalRows_rsProvincias = mysql_num_rows($rsProvincias);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:339
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_province_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_province_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_province_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_province_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:489
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
                <div class="row">
&lt;div class=&quot;col-md-6&quot;&gt;

&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;quick_town_nws&quot;&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;quick_town_nws&quot; id=&quot;quick_town_nws&quot; class=&quot;form-control select2&quot;&gt;
        &lt;option value=&quot;&quot; &lt;?php if (!(strcmp(&quot;&quot;, $row_rsnews[&#039;quick_town_nws&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
        &lt;?php
        do {
        ?&gt;
        &lt;option value=&quot;&lt;?php echo $row_rsZonas[&#039;id_loc3&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsZonas[&#039;id_loc3&#039;], $row_rsnews[&#039;quick_town_nws&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt;&lt;/option&gt;
        &lt;?php
        } while ($row_rsZonas = mysql_fetch_assoc($rsZonas ));
        $rows = mysql_num_rows($rsZonas );
        if($rows &gt; 0) {
        mysql_data_seek($rsZonas , 0);
        $row_rsZonas = mysql_fetch_assoc($rsZonas );
        }
        ?&gt;
    &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;); ?&gt;
&lt;/div&gt;

&lt;/div&gt;
&lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;quick_location_nws&quot;&gt;&lt;?php __(&#039;Zona&#039;); ?&gt;:&lt;/label&gt;
                &lt;select name=&quot;quick_location_nws&quot; id=&quot;quick_location_nws&quot; class=&quot;form-control select2&quot;&gt;
                  &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                  &lt;?php
        do {
        ?&gt;
                  &lt;option value=&quot;&lt;?php echo $row_Recordset2[&#039;id_loc4&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_Recordset2[&#039;id_loc4&#039;], $row_rsnews[&#039;quick_location_nws&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc4&#039;]; ?&gt;&lt;/option&gt;
                  &lt;?php
        } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
        $rows = mysql_num_rows($Recordset2);
        if($rows &gt; 0) {
        mysql_data_seek($Recordset2, 0);
        $row_Recordset2 = mysql_fetch_assoc($Recordset2);
        }
        ?&gt;
              &lt;/select&gt;
              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;); ?&gt;
      &lt;/div&gt;

&lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_province_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;quick_province_nws&quot;&gt;&lt;?php __(&#039;Provincia&#039;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;quick_province_nws&quot; id=&quot;quick_province_nws&quot; class=&quot;form-control select2&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
            &lt;option value=&quot;&quot; &lt;?php if (!(strcmp(&quot;&quot;, $row_rsnews[&#039;quick_province_nws&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;?php
            do {
              $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_province_nws&#039;]);
            ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsProvincias[&#039;id_loc2&#039;]?&gt;&quot;&lt;?php if (in_array($row_rsProvincias[&#039;id_loc2&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsProvincias[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsProvincias[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt;&lt;/option&gt;
            &lt;?php
            } while ($row_rsProvincias = mysql_fetch_assoc($rsProvincias ));
            $rows = mysql_num_rows($rsProvincias );
            if($rows &gt; 0) {
            mysql_data_seek($rsProvincias , 0);
            $row_rsProvincias = mysql_fetch_assoc($rsProvincias );
            }
            ?&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_province_nws&quot;); ?&gt;
    &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;quick_town_nws&quot;&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;quick_town_nws&quot; id=&quot;quick_town_nws&quot; class=&quot;form-control select2&quot;&gt;
            &lt;option value=&quot;&quot; &lt;?php if (!(strcmp(&quot;&quot;, $row_rsnews[&#039;quick_town_nws&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;?php
            do {
            ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsZonas[&#039;id_loc3&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsZonas[&#039;id_loc3&#039;], $row_rsnews[&#039;quick_town_nws&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsZonas[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt;&lt;/option&gt;
            &lt;?php
            } while ($row_rsZonas = mysql_fetch_assoc($rsZonas ));
            $rows = mysql_num_rows($rsZonas );
            if($rows &gt; 0) {
            mysql_data_seek($rsZonas , 0);
            $row_rsZonas = mysql_fetch_assoc($rsZonas );
            }
            ?&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_town_nws&quot;); ?&gt;
    &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;

          &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
              &lt;label for=&quot;quick_location_nws&quot;&gt;&lt;?php __(&#039;Zona&#039;); ?&gt;:&lt;/label&gt;
                    &lt;select name=&quot;quick_location_nws&quot; id=&quot;quick_location_nws&quot; class=&quot;form-control select2&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                      &lt;?php
            do {
            ?&gt;
                      &lt;option value=&quot;&lt;?php echo $row_Recordset2[&#039;id_loc4&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_Recordset2[&#039;id_loc4&#039;], $row_rsnews[&#039;quick_location_nws&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc1&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc2&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc3&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_Recordset2[&#039;name_&#039;.$lang_adm.&#039;_loc4&#039;]; ?&gt;&lt;/option&gt;
                      &lt;?php
            } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
            $rows = mysql_num_rows($Recordset2);
            if($rows &gt; 0) {
            mysql_data_seek($Recordset2, 0);
            $row_Recordset2 = mysql_fetch_assoc($Recordset2);
            }
            ?&gt;
                  &lt;/select&gt;
                  &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_location_nws&quot;); ?&gt;
          &lt;/div&gt;

  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/new.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
news.quick_town_nws,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
news.quick_town_nws,
news.quick_province_nws,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/new.php:347
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($news[0][&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $whereSQL .= &quot;AND (CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END) = &#039;&quot;.simpleSanitize(($news[0][&#039;quick_town_nws&#039;])).&quot;&#039;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($news[0][&#039;quick_town_nws&#039;] != &#039;&#039;) {
    $whereSQL .= &quot;AND (CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END) = &#039;&quot;.simpleSanitize(($news[0][&#039;quick_town_nws&#039;])).&quot;&#039;&quot;;
}

if ($news[0][&#039;quick_province_nws&#039;] != &#039;&#039;) {
    $whereSQL .= &quot;AND (CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END) = &#039;&quot;.simpleSanitize(($news[0][&#039;quick_province_nws&#039;])).&quot;&#039;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/new.php:442
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($news[0][&#039;quick_location_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_town_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_type_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_status_nws&#039;] != &#039;&#039;) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($news[0][&#039;quick_location_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_province_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_town_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_type_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_status_nws&#039;] != &#039;&#039;) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/new.php:470
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AND (properties_loc4.id_loc4 = &#039;&quot;.$news[0][&#039;featured_properties_nws&#039;].&quot;&#039; OR properties_loc4.parent_loc4 = &#039;&quot;.$news[0][&#039;featured_properties_nws&#039;].&quot;&#039; OR towns.id_loc4 = &#039;&quot;.$news[0][&#039;featured_properties_nws&#039;].&quot;&#039; OR towns.parent_loc4 = &#039;&quot;.$news[0][&#039;featured_properties_nws&#039;].&quot;&#039;)
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$whereSQL
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>