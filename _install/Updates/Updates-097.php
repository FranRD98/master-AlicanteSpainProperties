<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 06-10-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>Añadir m2 casa y m2 parcela en Search Criteria</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>Solución de bugs</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir m2 casa y m2 parcela en Search Criteria
    </h6>
    <div class="card-body">
       Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_client` ADD COLUMN `b_m2_desde_cli` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `b_parking_cli`;

ALTER TABLE `properties_client` ADD COLUMN `b_m2_hasta_cli` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `b_m2_desde_cli`;

ALTER TABLE `properties_client` ADD COLUMN `b_m2p_desde_cli` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `b_m2_hasta_cli`;

ALTER TABLE `properties_client` ADD COLUMN `b_m2p_hasta_cli` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `b_m2p_desde_cli`;


            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:618
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;b_parking_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_parking_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;b_parking_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_parking_cli&quot;);
$ins_properties_client-&gt;addColumn(&quot;b_m2_desde_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2_desde_cli&quot;);
$ins_properties_client-&gt;addColumn(&quot;b_m2_hasta_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2_hasta_cli&quot;);
$ins_properties_client-&gt;addColumn(&quot;b_m2p_desde_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2p_desde_cli&quot;);
$ins_properties_client-&gt;addColumn(&quot;b_m2p_hasta_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2p_hasta_cli&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:704
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;b_parking_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_parking_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;b_parking_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_parking_cli&quot;);
$upd_properties_client-&gt;addColumn(&quot;b_m2_desde_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2_desde_cli&quot;);
$upd_properties_client-&gt;addColumn(&quot;b_m2_hasta_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2_hasta_cli&quot;);
$upd_properties_client-&gt;addColumn(&quot;b_m2p_desde_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2p_desde_cli&quot;);
$upd_properties_client-&gt;addColumn(&quot;b_m2p_hasta_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_m2p_hasta_cli&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1864
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_desde_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_precio_desde_cli&quot;&gt;&lt;?php __(&#039;Precio desde&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_precio_desde_cli&quot; id=&quot;b_precio_desde_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_precio_desde_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_desde_cli&quot;); ?&gt;
      &lt;/div&gt;

      &lt;small class=&quot;help-block&quot;&gt;&lt;?php __(&#039;Sin puntos ni comas ni s&iacute;mbolos &euro;&#039;) ?&gt;&lt;/small&gt;

  &lt;/div&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_hasta_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_precio_hasta_cli&quot;&gt;&lt;?php __(&#039;Precio hasta&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_precio_hasta_cli&quot; id=&quot;b_precio_hasta_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_precio_hasta_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_hasta_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_desde_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_precio_desde_cli&quot;&gt;&lt;?php __(&#039;Precio desde&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_precio_desde_cli&quot; id=&quot;b_precio_desde_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_precio_desde_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_desde_cli&quot;); ?&gt;
      &lt;/div&gt;

      &lt;small class=&quot;help-block&quot;&gt;&lt;?php __(&#039;Sin puntos ni comas ni s&iacute;mbolos &euro;&#039;) ?&gt;&lt;/small&gt;

  &lt;/div&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_hasta_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_precio_hasta_cli&quot;&gt;&lt;?php __(&#039;Precio hasta&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_precio_hasta_cli&quot; id=&quot;b_precio_hasta_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_precio_hasta_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_precio_hasta_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2_desde_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_m2_desde_cli&quot;&gt;&lt;?php __(&#039;M&lt;sup&gt;2&lt;/sup&gt; desde&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_m2_desde_cli&quot; id=&quot;b_m2_desde_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_m2_desde_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2_desde_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2_hasta_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_m2_hasta_cli&quot;&gt;&lt;?php __(&#039;M&lt;sup&gt;2&lt;/sup&gt; hasta&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_m2_hasta_cli&quot; id=&quot;b_m2_hasta_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_m2_hasta_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2_hasta_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:704
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_pool_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;b_pool_cli&quot;&gt;&lt;?php __(&#039;Piscina&#039;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;b_pool_cli[]&quot; id=&quot;b_pool_cli&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot;&gt;
            &lt;?php
            do {
            ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsPool[&#039;id_pl&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsPool[&#039;id_pl&#039;], $row_rsproperties_client[&#039;b_pool_cli&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsPool[&#039;pool&#039;]?&gt;&lt;/option&gt;
            &lt;?php
            } while ($row_rsPool = mysql_fetch_assoc($rsPool ));
              $rows = mysql_num_rows($rsPool );
              if($rows &gt; 0) {
                  mysql_data_seek($rsPool , 0);
                $row_rsPool = mysql_fetch_assoc($rsPool );
              }
            ?&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_pool_cli&quot;); ?&gt;
    &lt;/div&gt;

&lt;/div&gt; &lt;!--/.col-md-6 --&gt;

&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_parking_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;b_parking_cli&quot;&gt;&lt;?php __(&#039;Parking&#039;); ?&gt;:&lt;/label&gt;
        &lt;select name=&quot;b_parking_cli[]&quot; id=&quot;b_parking_cli&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot;&gt;
            &lt;?php
            do {
            ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsParking[&#039;id_prk&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsParking[&#039;id_prk&#039;], $row_rsproperties_client[&#039;b_parking_cli&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsParking[&#039;parking&#039;]?&gt;&lt;/option&gt;
            &lt;?php
            } while ($row_rsParking = mysql_fetch_assoc($rsParking ));
              $rows = mysql_num_rows($rsParking );
              if($rows &gt; 0) {
                  mysql_data_seek($rsParking , 0);
                $row_rsParking = mysql_fetch_assoc($rsParking );
              }
            ?&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_parking_cli&quot;); ?&gt;
    &lt;/div&gt;

&lt;/div&gt; &lt;!--/.col-md-6 --&gt;

&lt;/div&gt; &lt;!--/.row --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_pool_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;b_pool_cli&quot;&gt;&lt;?php __(&#039;Piscina&#039;); ?&gt;:&lt;/label&gt;
            &lt;select name=&quot;b_pool_cli[]&quot; id=&quot;b_pool_cli&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot;&gt;
                &lt;?php
                do {
                ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rsPool[&#039;id_pl&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsPool[&#039;id_pl&#039;], $row_rsproperties_client[&#039;b_pool_cli&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsPool[&#039;pool&#039;]?&gt;&lt;/option&gt;
                &lt;?php
                } while ($row_rsPool = mysql_fetch_assoc($rsPool ));
                  $rows = mysql_num_rows($rsPool );
                  if($rows &gt; 0) {
                      mysql_data_seek($rsPool , 0);
                    $row_rsPool = mysql_fetch_assoc($rsPool );
                  }
                ?&gt;
            &lt;/select&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_pool_cli&quot;); ?&gt;
        &lt;/div&gt;

    &lt;/div&gt; &lt;!--/.col-md-6 --&gt;

    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_parking_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;b_parking_cli&quot;&gt;&lt;?php __(&#039;Parking&#039;); ?&gt;:&lt;/label&gt;
            &lt;select name=&quot;b_parking_cli[]&quot; id=&quot;b_parking_cli&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot;&gt;
                &lt;?php
                do {
                ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rsParking[&#039;id_prk&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsParking[&#039;id_prk&#039;], $row_rsproperties_client[&#039;b_parking_cli&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsParking[&#039;parking&#039;]?&gt;&lt;/option&gt;
                &lt;?php
                } while ($row_rsParking = mysql_fetch_assoc($rsParking ));
                  $rows = mysql_num_rows($rsParking );
                  if($rows &gt; 0) {
                      mysql_data_seek($rsParking , 0);
                    $row_rsParking = mysql_fetch_assoc($rsParking );
                  }
                ?&gt;
            &lt;/select&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_parking_cli&quot;); ?&gt;
        &lt;/div&gt;

    &lt;/div&gt; &lt;!--/.col-md-6 --&gt;

&lt;/div&gt; &lt;!--/.row --&gt;

&lt;div class=&quot;row&quot;&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2p_desde_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_m2p_desde_cli&quot;&gt;&lt;?php __(&#039;M&lt;sup&gt;2&lt;/sup&gt; parcela desde&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_m2p_desde_cli&quot; id=&quot;b_m2p_desde_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_m2p_desde_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2p_desde_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;

      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2p_hasta_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_m2p_hasta_cli&quot;&gt;&lt;?php __(&#039;M&lt;sup&gt;2&lt;/sup&gt; parcela hasta&#039;); ?&gt;:&lt;/label&gt;
          &lt;input type=&quot;text&quot; name=&quot;b_m2p_hasta_cli&quot; id=&quot;b_m2p_hasta_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;b_m2p_hasta_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_m2p_hasta_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:498
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#b_precio_desde_cli, #b_precio_hasta_cli, #b_dist_beach_from_cli, #b_dist_beach_to_cli, #b_dist_amenit_from_cli, #b_dist_amenit_to_cli, #b_dist_airport_from_cli, #b_dist_airport_to_cli, #b_dist_golf_from_cli, #b_dist_golf_to_cli&#039;).keyup(function(e) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#b_precio_desde_cli, #b_precio_hasta_cli, #b_dist_beach_from_cli, #b_dist_beach_to_cli, #b_dist_amenit_from_cli, #b_dist_amenit_to_cli, #b_dist_airport_from_cli, #b_dist_airport_to_cli, #b_dist_golf_from_cli, #b_dist_golf_to_cli, #b_m2_desde_cli, #b_m2_hasta_cli, #b_m2p_desde_cli, #b_m2p_hasta_cli&#039;).keyup(function(e) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:493
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$dir = &#039;&#039;;
if( isset($_GET[&#039;direccion&#039;]) &amp;&amp; $_GET[&#039;direccion&#039;] != &#039;&#039; ){
    $dir = &quot;AND direccion_prop LIKE &#039;%&quot; . $_GET[&#039;direccion&#039;].&quot;%&#039;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$dir = &#039;&#039;;
if( isset($_GET[&#039;direccion&#039;]) &amp;&amp; $_GET[&#039;direccion&#039;] != &#039;&#039; ){
    $dir = &quot;AND direccion_prop LIKE &#039;%&quot; . $_GET[&#039;direccion&#039;].&quot;%&#039;&quot;;
}

$m2d = &#039;&#039;;
if( isset($_GET[&#039;b_m2_desde_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] != &#039;&#039; ){
    $m2d = &quot;AND m2_prop &gt;= &quot; . $_GET[&#039;b_m2_desde_cli&#039;].&quot;&quot;;
}

$m2h = &#039;&#039;;
if( isset($_GET[&#039;b_m2_hasta_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] != &#039;&#039; ){
    $m2h = &quot;AND m2_prop &lt;= &quot; . $_GET[&#039;b_m2_hasta_cli&#039;].&quot;&quot;;
}

$m2pd = &#039;&#039;;
if( isset($_GET[&#039;b_m2p_desde_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] != &#039;&#039; ){
    $m2pd= &quot;AND m2_parcela_prop &gt;= &quot; . $_GET[&#039;b_m2p_desde_cli&#039;].&quot;&quot;;
}

$m2ph = &#039;&#039;;
if( isset($_GET[&#039;b_m2p_hasta_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] != &#039;&#039; ){
    $m2ph= &quot;AND m2_parcela_prop &lt;= &quot; . $_GET[&#039;b_m2p_hasta_cli&#039;].&quot;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:551
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
 if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039;       ){
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] == &#039;&#039;       ){
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:679
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$distBeach $distAmenit $distAirport $distGolf
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:495
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$obrnws = &#039;&#039;;
if( isset($_GET[&#039;b_obranueva_cli&#039;]) &amp;&amp; $_GET[&#039;b_obranueva_cli&#039;] != &#039;&#039; ){
    $obrnws = &quot;AND obra_nueva_prop LIKE &#039;%&quot; . $_GET[&#039;b_obranueva_cli&#039;].&quot;%&#039;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$obrnws = &#039;&#039;;
if( isset($_GET[&#039;b_obranueva_cli&#039;]) &amp;&amp; $_GET[&#039;b_obranueva_cli&#039;] != &#039;&#039; ){
  $obrnws = &quot;AND obra_nueva_prop LIKE &#039;%&quot; . $_GET[&#039;b_obranueva_cli&#039;].&quot;%&#039;&quot;;
}

$m2d = &#039;&#039;;
if( isset($_GET[&#039;b_m2_desde_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] != &#039;&#039; ){
  $m2d = &quot;AND m2_prop &gt;= &quot; . $_GET[&#039;b_m2_desde_cli&#039;].&quot;&quot;;
}

$m2h = &#039;&#039;;
if( isset($_GET[&#039;b_m2_hasta_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] != &#039;&#039; ){
  $m2h = &quot;AND m2_prop &lt;= &quot; . $_GET[&#039;b_m2_hasta_cli&#039;].&quot;&quot;;
}

$m2pd = &#039;&#039;;
if( isset($_GET[&#039;b_m2p_desde_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] != &#039;&#039; ){
  $m2pd= &quot;AND m2_parcela_prop &gt;= &quot; . $_GET[&#039;b_m2p_desde_cli&#039;].&quot;&quot;;
}

$m2ph = &#039;&#039;;
if( isset($_GET[&#039;b_m2p_hasta_cli&#039;]) &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] != &#039;&#039; ){
  $m2ph= &quot;AND m2_parcela_prop &lt;= &quot; . $_GET[&#039;b_m2p_hasta_cli&#039;].&quot;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:546
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if( !isset($_GET[&apos;b_sale_cli&apos;]) &amp;&amp; !isset($_GET[&apos;b_type_cli&apos;]) &amp;&amp; $_GET[&apos;b_beds_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;or&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_orientacion_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;favs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_baths_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_ref_cli&apos;]) &amp;&amp; $_GET[&apos;b_precio_desde_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_precio_hasta_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_loc1_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_loc2_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_loc3_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_loc4_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_opciones_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_opciones2_cli&apos;])  &amp;&amp; $_GET[&apos;nw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ven&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;alq&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;res&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;rp&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;cs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;sw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ep&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;po&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;rps&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;direccion&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2ut&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2pl&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_direcc_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_urb_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_piscina_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_garaje_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_vistasmar_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_obranueva_cli&apos;] == &apos;&apos;){
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if( !isset($_GET[&apos;b_sale_cli&apos;]) &amp;&amp; !isset($_GET[&apos;b_type_cli&apos;]) &amp;&amp; $_GET[&apos;b_beds_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;or&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_orientacion_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;favs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_baths_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_ref_cli&apos;]) &amp;&amp; $_GET[&apos;b_precio_desde_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_precio_hasta_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_loc1_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_loc2_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_loc3_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_loc4_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_opciones_cli&apos;])  &amp;&amp; !isset($_GET[&apos;b_opciones2_cli&apos;])  &amp;&amp; $_GET[&apos;nw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ven&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;alq&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;res&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;rp&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;cs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;sw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ep&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;po&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;rps&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;direccion&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2ut&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2pl&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_direcc_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_urb_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_piscina_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_garaje_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_vistasmar_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_obranueva_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2_desde_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2_hasta_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2p_desde_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2p_hasta_cli&apos;] == &apos;&apos;){
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:546
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if( !isset($_GET[&apos;b_sale_cli&apos;][0]) &amp;&amp; !isset($_GET[&apos;b_type_cli&apos;][0]) &amp;&amp; $_GET[&apos;b_beds_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;or&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_orientacion_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;favs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_baths_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_ref_cli&apos;][0]) &amp;&amp; $_GET[&apos;b_precio_desde_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_precio_hasta_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_ocultos_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc1_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc2_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc3_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc4_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_opciones_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_opciones2_cli&apos;][0]) &amp;&amp; !isset($_GET[&apos;b_tags_cli&apos;])  &amp;&amp; $_GET[&apos;nw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ven&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;alq&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;res&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;rp&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;cs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;sw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ep&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;po&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;rps&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;direccion&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2ut&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2pl&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;palabras_clave&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_pool_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_parking_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_direcc_cli&apos;] == &apos;&apos;       ){
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if( !isset($_GET[&apos;b_sale_cli&apos;][0]) &amp;&amp; !isset($_GET[&apos;b_type_cli&apos;][0]) &amp;&amp; $_GET[&apos;b_beds_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;or&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_orientacion_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;favs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_baths_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_ref_cli&apos;][0]) &amp;&amp; $_GET[&apos;b_precio_desde_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_precio_hasta_cli&apos;] == &apos;&apos;  &amp;&amp; !isset($_GET[&apos;b_ocultos_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc1_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc2_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc3_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_loc4_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_opciones_cli&apos;][0])  &amp;&amp; !isset($_GET[&apos;b_opciones2_cli&apos;][0]) &amp;&amp; !isset($_GET[&apos;b_tags_cli&apos;])  &amp;&amp; $_GET[&apos;nw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ven&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;alq&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;res&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;rp&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;cs&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;sw&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;ep&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;po&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;rps&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;direccion&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2ut&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;m2pl&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;palabras_clave&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_pool_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_parking_cli&apos;] == &apos;&apos;  &amp;&amp; $_GET[&apos;b_direcc_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_obranueva_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2_desde_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2_hasta_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2p_desde_cli&apos;] == &apos;&apos; &amp;&amp; $_GET[&apos;b_m2p_hasta_cli&apos;] == &apos;&apos;){
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:685
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$distBeach $distAmenit $distAirport $distGolf
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$row_rsCli[&apos;b_parking_cli&apos;] = split(&apos;,&apos;, $row_rsCli[&apos;b_parking_cli&apos;]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$row_rsCli[&apos;b_parking_cli&apos;] = split(&apos;,&apos;, $row_rsCli[&apos;b_parking_cli&apos;]);
$row_rsCli[&apos;b_m2_desde_cli&apos;] = split(&apos;,&apos;, $row_rsCli[&apos;b_m2_desde_cli&apos;]);
$row_rsCli[&apos;b_m2_hasta_cli&apos;] = split(&apos;,&apos;, $row_rsCli[&apos;b_m2_hasta_cli&apos;]);
$row_rsCli[&apos;b_m2p_desde_cli&apos;] = split(&apos;,&apos;, $row_rsCli[&apos;b_m2p_desde_cli&apos;]);
$row_rsCli[&apos;b_m2p_hasta_cli&apos;] = split(&apos;,&apos;, $row_rsCli[&apos;b_m2p_hasta_cli&apos;]);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&amp;&amp; trim($row_rsCli[&apos;b_parking_cli&apos;][0]) == &apos;&apos;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&amp;&amp; trim($row_rsCli[&apos;b_parking_cli&apos;][0]) == &apos;&apos;
&amp;&amp; trim($row_rsCli[&apos;b_m2_desde_cli&apos;][0]) == &apos;&apos;
&amp;&amp; trim($row_rsCli[&apos;b_m2_hasta_cli&apos;][0]) == &apos;&apos;
&amp;&amp; trim($row_rsCli[&apos;b_m2p_desde_cli&apos;][0]) == &apos;&apos;
&amp;&amp; trim($row_rsCli[&apos;b_m2p_hasta_cli&apos;][0]) == &apos;&apos;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:568
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$obrnws = &apos;&apos;;
if( isset($row_rsCli[&apos;b_obranueva_cli&apos;]) &amp;&amp; $row_rsCli[&apos;b_obranueva_cli&apos;] != &apos;&apos; ){
    $obrnws = &quot;AND obra_nueva_prop LIKE &apos;%&quot; . $row_rsCli[&apos;b_obranueva_cli&apos;].&quot;%&apos;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$obrnws = &apos;&apos;;
if( isset($row_rsCli[&apos;b_obranueva_cli&apos;]) &amp;&amp; $row_rsCli[&apos;b_obranueva_cli&apos;] != &apos;&apos; ){
    $obrnws = &quot;AND obra_nueva_prop LIKE &apos;%&quot; . $row_rsCli[&apos;b_obranueva_cli&apos;].&quot;%&apos;&quot;;
}

$m2d = &apos;&apos;;
if( isset($row_rsCli[&apos;b_m2_desde_cli&apos;][0]) &amp;&amp; $row_rsCli[&apos;b_m2_desde_cli&apos;][0] != &apos;&apos; ){
  $m2d = &quot;AND m2_prop &gt;= &quot; . $row_rsCli[&apos;b_m2_desde_cli&apos;][0].&quot;&quot;;
}

$m2h = &apos;&apos;;
if( isset($row_rsCli[&apos;b_m2_hasta_cli&apos;][0]) &amp;&amp; $row_rsCli[&apos;b_m2_hasta_cli&apos;][0] != &apos;&apos; ){
  $m2h = &quot;AND m2_prop &lt;= &quot; . $row_rsCli[&apos;b_m2_hasta_cli&apos;][0].&quot;&quot;;
}

$m2pd = &apos;&apos;;
if( isset($row_rsCli[&apos;b_m2p_desde_cli&apos;][0]) &amp;&amp; $row_rsCli[&apos;b_m2p_desde_cli&apos;][0] != &apos;&apos; ){
  $m2pd= &quot;AND m2_parcela_prop &gt;= &quot; . $row_rsCli[&apos;b_m2p_desde_cli&apos;][0].&quot;&quot;;
}

$m2ph = &apos;&apos;;
if( isset($row_rsCli[&apos;b_m2p_hasta_cli&apos;][0]) &amp;&amp; $row_rsCli[&apos;b_m2p_hasta_cli&apos;][0] != &apos;&apos; ){
  $m2ph= &quot;AND m2_parcela_prop &lt;= &quot; . $row_rsCli[&apos;b_m2p_hasta_cli&apos;][0].&quot;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:739
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$distBeach $distAmenit $distAirport $distGolf
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:108
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
b_pool_cli,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
b_pool_cli,
b_m2_desde_cli,
b_m2_hasta_cli,
b_m2p_desde_cli,
b_m2p_hasta_cli,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:131
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($client[&apos;b_sale_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_type_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc1_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc2_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc3_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc4_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_precio_desde_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_precio_hasta_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_beds_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_baths_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_opciones_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_opciones2_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_orientacion_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_pool_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_parking_cli&apos;] == &apos;&apos;) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($client[&apos;b_sale_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_type_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc1_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc2_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc3_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_loc4_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_precio_desde_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_precio_hasta_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_beds_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_baths_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_opciones_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_opciones2_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_orientacion_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_pool_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_parking_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_m2_desde_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_m2_hasta_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_m2p_desde_cli&apos;] == &apos;&apos; &amp;&amp; $client[&apos;b_m2p_hasta_cli&apos;] == &apos;&apos;) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:200
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$or2 = &apos;&apos;;
if (isset($client[&apos;b_orientacion_cli&apos;]) &amp;&amp; $client[&apos;b_orientacion_cli&apos;] != &apos;&apos;) {
    $or2 = &quot;AND orientacion_prop = &apos;&quot; . $client[&apos;b_orientacion_cli&apos;] . &quot;&apos;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$or2 = &apos;&apos;;
if (isset($client[&apos;b_orientacion_cli&apos;]) &amp;&amp; $client[&apos;b_orientacion_cli&apos;] != &apos;&apos;) {
    $or2 = &quot;AND orientacion_prop = &apos;&quot; . $client[&apos;b_orientacion_cli&apos;] . &quot;&apos;&quot;;
}

$m2d = &apos;&apos;;
if( isset($client[&apos;b_m2_desde_cli&apos;][0]) &amp;&amp; $client[&apos;b_m2_desde_cli&apos;][0] != &apos;&apos; ){
  $m2d = &quot;AND m2_prop &gt;= &quot; . $client[&apos;b_m2_desde_cli&apos;][0].&quot;&quot;;
}

$m2h = &apos;&apos;;
if( isset($client[&apos;b_m2_hasta_cli&apos;][0]) &amp;&amp; $client[&apos;b_m2_hasta_cli&apos;][0] != &apos;&apos; ){
  $m2h = &quot;AND m2_prop &lt;= &quot; . $client[&apos;b_m2_hasta_cli&apos;][0].&quot;&quot;;
}

$m2pd = &apos;&apos;;
if( isset($client[&apos;b_m2p_desde_cli&apos;][0]) &amp;&amp; $client[&apos;b_m2p_desde_cli&apos;][0] != &apos;&apos; ){
  $m2pd= &quot;AND m2_parcela_prop &gt;= &quot; . $client[&apos;b_m2p_desde_cli&apos;][0].&quot;&quot;;
}

$m2ph = &apos;&apos;;
if( isset($client[&apos;b_m2p_hasta_cli&apos;][0]) &amp;&amp; $client[&apos;b_m2p_hasta_cli&apos;][0] != &apos;&apos; ){
  $m2ph= &quot;AND m2_parcela_prop &lt;= &quot; . $client[&apos;b_m2p_hasta_cli&apos;][0].&quot;&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:345
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$st $op $op2  $ty $bd $bt $ref $prd $prh $or2 $m2ut $m2pl $loc4 $loc3 $loc2 $loc1 $pool $parking
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$st $op $op2  $ty $bd $bt $ref $prd $prh $or2 $m2ut $m2pl $loc4 $loc3 $loc2 $loc1 $pool $parking $m2d $m2h $m2pd $m2ph
            </code>
        </pre>
        <hr>
        Añadir al archivo /intramedianet/includes/resources/lang_es.php:
        <pre>
            <code class="makefile">
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; desde&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; desde&apos;;
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; hasta&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; hasta&apos;;
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; parcela desde&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; parcela desde&apos;;
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; parcela hasta&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; parcela hasta&apos;;
            </code>
        </pre>
        <hr>
        Añadir al archivo /intramedianet/includes/resources/lang_en.php:
        <pre>
            <code class="makefile">
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; desde&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; from&apos;;
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; hasta&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; to&apos;;
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; parcela desde&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; plot from&apos;;
$lang[&apos;M&lt;sup&gt;2&lt;/sup&gt; parcela hasta&apos;] = &apos;M&lt;sup&gt;2&lt;/sup&gt; plot to&apos;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Solución de bugs
    </h6>
    <div class="card-body">
        Solucionados pequeños bugs del master
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
