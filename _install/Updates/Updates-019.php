<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 20 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 25-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Duplicar inmuebles ya no duplica las imágenes y genera una nueva referencia</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Al importar xml ya no añade la latitud y longitud si vienen vacías o son 0</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Ya no se muestran clientes interesados con menos del 30%</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> En la búsqueda de clientes no funciona los inmuebles visitados</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes varios SEO</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Convertidos algunos select2 a ajax para poder trabajar con miles de registros sin ralentizar la página</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Los quicklinks ahora permiten seleccionar varios tipos, estatus, poblaciones y zonas</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> Nueva forma de ocultar inmuebles importados</a></li>
        <li><a href="#nueve"><i class="fas fz-fw fa-bug text-danger"></i> Popup y email de similares al enviar consultas</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Duplicar inmuebles ya no duplica las imágenes y genera una nueva referencia
    </h6>
    <div class="card-body">
        Reemplazar el archivo <code>/intramedianet/properties/properties-dupli.php</code>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Al importar xml ya no añade la latitud y longitud si vienen vacías o son 0
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Kyero.php:116
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($lat != &#039;&#039; &amp;&amp; $lang != &#039;&#039;) {
    $query .= &quot;lat_long_gp_prop = &#039;&quot;.$lat.&quot;,&quot;.$long.&quot;&#039;, &quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (($lat != &#039;&#039; &amp;&amp; $lat != 0) &amp;&amp; ($long != &#039;&#039; &amp;&amp; $long != 0)) {
    $query .= &quot;lat_long_gp_prop = &#039;&quot;.$lat.&quot;,&quot;.$long.&quot;&#039;, &quot;;
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
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Ya no se muestran clientes interesados con menos del 30%
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/interested-clients.php:146
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
foreach ($clients as $key =&gt; $value) {

    echo &#039;&lt;div class=&quot;row&quot;&gt;&#039;;
        echo &#039;&lt;div class=&quot;col-md-8&quot;&gt;&#039;;

            echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-user&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;name&#039;] . &#039;&lt;/p&gt;&#039;;

            if ($value[&#039;email&#039;] != &#039;&#039;) {
                echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-envelope-o&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;email&#039;] . &#039;&lt;/p&gt;&#039;;
            }

            if ($value[&#039;telefono&#039;] != &#039;&#039;) {
                echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-phone&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;telefono&#039;] . &#039;&lt;/p&gt;&#039;;
            }

            if ($value[&#039;movil&#039;] != &#039;&#039;) {
                echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-mobile&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;movil&#039;] . &#039;&lt;/p&gt;&#039;;
            }

            if ($value[&#039;direccion&#039;] != &#039;&#039;) {
                echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-map-marker&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;direccion&#039;] . &#039;&lt;/p&gt;&#039;;
            }

            if ($value[&#039;skype&#039;] != &#039;&#039;) {
                echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-skype&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;skype&#039;] . &#039;&lt;/p&gt;&#039;;
            }

            if ($value[&#039;alta&#039;] != &#039;&#039;) {
                echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-calendar&quot;&gt;&lt;/i&gt; &#039; . date(&quot;d-m-Y&quot;, strtotime($value[&#039;alta&#039;])) . &#039;&lt;/p&gt;&#039;;
            }

            $ret = &#039;&#039;;

            if ($value[&#039;b_sale_cli&#039;] != &#039;&#039;) {

                mysql_select_db($database_inmoconn, $inmoconn);
                $query_rsValues = &quot;SELECT status_&quot;.$lang_adm.&quot;_sta as name FROM properties_status WHERE id_sta IN (&quot;.$value[&#039;b_sale_cli&#039;].&quot;) ORDER BY status_&quot;.$lang_adm.&quot;_sta ASC&quot;;
                $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                $row_rsValues = mysql_fetch_assoc($rsValues);

                $arrayVals = array();

                do {
                    array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                $ret .= &#039;&#039;.__(&#039;Operaciones&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_type_cli&#039;] != &#039;&#039;) {

                mysql_select_db($database_inmoconn, $inmoconn);
                $query_rsValues = &quot;SELECT types_&quot;.$lang_adm.&quot;_typ as name FROM properties_types WHERE id_typ IN (&quot;.$value[&#039;b_type_cli&#039;].&quot;) ORDER BY types_&quot;.$lang_adm.&quot;_typ ASC&quot;;
                $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                $row_rsValues = mysql_fetch_assoc($rsValues);

                $arrayVals = array();

                do {
                    array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                mysql_free_result($rsValues);

                $ret .= &#039;&#039;.__(&#039;Tipos&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_loc1_cli&#039;] != &#039;&#039;) {

                mysql_select_db($database_inmoconn, $inmoconn);
                $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc1 as name FROM properties_loc1 WHERE id_loc1 IN (&quot;.$value[&#039;b_loc1_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc1 ASC&quot;;
                $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                $row_rsValues = mysql_fetch_assoc($rsValues);

                $arrayVals = array();

                do {
                    array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                mysql_free_result($rsValues);

                $ret .= &#039;&#039;.__(&#039;Pa&iacute;s&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_loc2_cli&#039;] != &#039;&#039;) {

                mysql_select_db($database_inmoconn, $inmoconn);
                $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc2 as name FROM properties_loc2 WHERE id_loc2 IN (&quot;.$value[&#039;b_loc2_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc2 ASC&quot;;
                $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                $row_rsValues = mysql_fetch_assoc($rsValues);

                $arrayVals = array();

                do {
                    array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                mysql_free_result($rsValues);

                $ret .= &#039;&#039;.__(&#039;Provincias&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_loc3_cli&#039;] != &#039;&#039;) {

                mysql_select_db($database_inmoconn, $inmoconn);
                $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc3 as name FROM properties_loc3 WHERE id_loc3 IN (&quot;.$value[&#039;b_loc3_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc3 ASC&quot;;
                $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                $row_rsValues = mysql_fetch_assoc($rsValues);

                $arrayVals = array();

                do {
                    array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                $ret .= &#039;&#039;.__(&#039;Ciudades&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_loc4_cli&#039;] != &#039;&#039;) {

                mysql_select_db($database_inmoconn, $inmoconn);
                $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc4 as name FROM properties_loc4 WHERE id_loc4 IN (&quot;.$value[&#039;b_loc4_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc4 ASC&quot;;
                $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                $row_rsValues = mysql_fetch_assoc($rsValues);

                $arrayVals = array();

                do {
                    array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                mysql_free_result($rsValues);

                $ret .= &#039;&#039;.__(&#039;Zonas&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_beds_cli&#039;] != &#039;&#039;) {
                $ret .= &#039;&#039;.__(&#039;Habitaciones&#039;, true). &#039;: &#039; . $value[&#039;b_beds_cli&#039;] . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_baths_cli&#039;] != &#039;&#039;) {
                $ret .= &#039;&#039;.__(&#039;Aseos&#039;, true). &#039;: &#039; . $value[&#039;b_baths_cli&#039;] . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_precio_desde_cli&#039;] != &#039;&#039;) {
                $ret .= &#039;&#039;.__(&#039;Precio desde&#039;, true). &#039;: &#039; . $value[&#039;b_precio_desde_cli&#039;] . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_precio_hasta_cli&#039;] != &#039;&#039;) {
                $ret .= &#039;&#039;.__(&#039;Precio hasta&#039;, true). &#039;: &#039; . $value[&#039;b_precio_hasta_cli&#039;] . &#039;&lt;br&gt;&#039;;
            }

            if ($value[&#039;b_ref_cli&#039;] != &#039;&#039;) {

                $refArray = explode(&#039;,&#039;, $value[&#039;b_ref_cli&#039;]);
                $refArrayVals = array();

                foreach ($refArray as $key =&gt; $value) {
                    array_push($refArrayVals , &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
                }

                mysql_select_db($database_inmoconn, $inmoconn);
                $query_rsValues = &quot;SELECT referencia_prop as name FROM properties_properties WHERE referencia_prop IN (&quot;.implode(&#039;,&#039;, $refArrayVals).&quot;) ORDER BY referencia_prop ASC&quot;;
                $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                $row_rsValues = mysql_fetch_assoc($rsValues);

                $arrayVals = array();

                do {
                    array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                mysql_free_result($rsValues);

                $ret .= &#039;&#039;.__(&#039;Referencias&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
            }

            echo &#039;&lt;p&gt;&lt;a href=&quot;javascript:void(0);&quot; class=&quot;btn btn-primary popoverbtn&quot; data-toggle=&quot;popover&quot; data-placement=&quot;right&quot; data-html=&quot;true&quot; data-content=&quot;&lt;span&gt;&#039;.$ret.&#039;&lt;/span&gt;&quot; data-original-title=&quot;&#039;.__(&#039;Qu&eacute; esta buscando&#039;, true).&#039;&quot;&gt;&lt;i class=&quot;icon-search&quot;&gt;&lt;/i&gt; &#039;.__(&#039;Qu&eacute; esta buscando&#039;, true).&#039;&lt;/a&gt;&lt;/p&gt;&#039;;

        echo &#039;&lt;/div&gt;&#039;;
        echo &#039;&lt;div class=&quot;col-md-4&quot;&gt;&#039;;

            echo &#039;&lt;p&gt;&#039;.__(&#039;Porcentaje de acierto&#039;, true).&#039;: &#039; . round(($value[&#039;score&#039;]*100)/7) . &#039;%&lt;/p&gt;&#039;;

            echo &#039;&lt;div class=&quot;progress&quot;&gt;&#039;;
                echo &#039;&lt;div class=&quot;progress-bar progress-bar-primary progress-bar-striped active&quot; style=&quot;width: &#039; . round(($value[&#039;score&#039;]*100)/7) . &#039;%;&quot;&gt;&lt;/div&gt;&#039;;
            echo &#039;&lt;/div&gt;&#039;;

            echo &#039;&lt;p&gt;&lt;a href=&quot;/intramedianet/properties/clients-form.php?id_cli=&#039;.$value[&#039;id&#039;].&#039;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-block popoverbtn&quot; data-toggle=&quot;popover&quot; data-placement=&quot;left&quot; data-content=&quot;&#039;.__(&#039;Guarde el inmueble antes de mostrar el cliente. Si no lo hece se pueden perder las modificaciones.&#039;, true).&#039;&quot; data-original-title=&quot;&#039;.__(&#039;Recuerde&#039;, true).&#039;&quot;&gt;&#039;.__(&#039;Mostra cliente&#039;, true).&#039;&lt;/a&gt;&lt;/p&gt;&#039;;

            if ($value[&#039;idioma_cli&#039;] != &#039;&#039;) {
                $langCli = $value[&#039;idioma_cli&#039;];
            } else {
                $langCli = $language;
            }


            echo &#039;&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btn-block btnsend&quot; data-email=&quot;&#039; . $value[&#039;email&#039;] . &#039;&quot; data-lang=&quot;&#039; . $langCli . &#039;&quot;&gt;&#039;.  __(&#039;Enviar&#039;, true) .&#039; &#039;.  __(&#039;Inmueble&#039;, true) .&#039;&lt;/a&gt;&#039;;


        echo &#039;&lt;/div&gt;&#039;;
    echo &#039;&lt;/div&gt;&#039;;

    echo &quot;&lt;hr&gt;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
foreach ($clients as $key =&gt; $value) {

    if (round(($value[&#039;score&#039;]*100)/7) &gt; 30) {

        echo &#039;&lt;div class=&quot;row&quot;&gt;&#039;;
            echo &#039;&lt;div class=&quot;col-md-8&quot;&gt;&#039;;

                echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-user&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;name&#039;] . &#039;&lt;/p&gt;&#039;;

                if ($value[&#039;email&#039;] != &#039;&#039;) {
                    echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-envelope-o&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;email&#039;] . &#039;&lt;/p&gt;&#039;;
                }

                if ($value[&#039;telefono&#039;] != &#039;&#039;) {
                    echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-phone&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;telefono&#039;] . &#039;&lt;/p&gt;&#039;;
                }

                if ($value[&#039;movil&#039;] != &#039;&#039;) {
                    echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-mobile&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;movil&#039;] . &#039;&lt;/p&gt;&#039;;
                }

                if ($value[&#039;direccion&#039;] != &#039;&#039;) {
                    echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-map-marker&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;direccion&#039;] . &#039;&lt;/p&gt;&#039;;
                }

                if ($value[&#039;skype&#039;] != &#039;&#039;) {
                    echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-skype&quot;&gt;&lt;/i&gt; &#039; . $value[&#039;skype&#039;] . &#039;&lt;/p&gt;&#039;;
                }

                if ($value[&#039;alta&#039;] != &#039;&#039;) {
                    echo &#039;&lt;p&gt;&lt;i class=&quot;fa fa-calendar&quot;&gt;&lt;/i&gt; &#039; . date(&quot;d-m-Y&quot;, strtotime($value[&#039;alta&#039;])) . &#039;&lt;/p&gt;&#039;;
                }

                $ret = &#039;&#039;;

                if ($value[&#039;b_sale_cli&#039;] != &#039;&#039;) {

                    mysql_select_db($database_inmoconn, $inmoconn);
                    $query_rsValues = &quot;SELECT status_&quot;.$lang_adm.&quot;_sta as name FROM properties_status WHERE id_sta IN (&quot;.$value[&#039;b_sale_cli&#039;].&quot;) ORDER BY status_&quot;.$lang_adm.&quot;_sta ASC&quot;;
                    $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                    $row_rsValues = mysql_fetch_assoc($rsValues);

                    $arrayVals = array();

                    do {
                        array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                    } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                    $ret .= &#039;&#039;.__(&#039;Operaciones&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_type_cli&#039;] != &#039;&#039;) {

                    mysql_select_db($database_inmoconn, $inmoconn);
                    $query_rsValues = &quot;SELECT types_&quot;.$lang_adm.&quot;_typ as name FROM properties_types WHERE id_typ IN (&quot;.$value[&#039;b_type_cli&#039;].&quot;) ORDER BY types_&quot;.$lang_adm.&quot;_typ ASC&quot;;
                    $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                    $row_rsValues = mysql_fetch_assoc($rsValues);

                    $arrayVals = array();

                    do {
                        array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                    } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                    mysql_free_result($rsValues);

                    $ret .= &#039;&#039;.__(&#039;Tipos&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_loc1_cli&#039;] != &#039;&#039;) {

                    mysql_select_db($database_inmoconn, $inmoconn);
                    $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc1 as name FROM properties_loc1 WHERE id_loc1 IN (&quot;.$value[&#039;b_loc1_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc1 ASC&quot;;
                    $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                    $row_rsValues = mysql_fetch_assoc($rsValues);

                    $arrayVals = array();

                    do {
                        array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                    } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                    mysql_free_result($rsValues);

                    $ret .= &#039;&#039;.__(&#039;Pa&iacute;s&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_loc2_cli&#039;] != &#039;&#039;) {

                    mysql_select_db($database_inmoconn, $inmoconn);
                    $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc2 as name FROM properties_loc2 WHERE id_loc2 IN (&quot;.$value[&#039;b_loc2_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc2 ASC&quot;;
                    $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                    $row_rsValues = mysql_fetch_assoc($rsValues);

                    $arrayVals = array();

                    do {
                        array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                    } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                    mysql_free_result($rsValues);

                    $ret .= &#039;&#039;.__(&#039;Provincias&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_loc3_cli&#039;] != &#039;&#039;) {

                    mysql_select_db($database_inmoconn, $inmoconn);
                    $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc3 as name FROM properties_loc3 WHERE id_loc3 IN (&quot;.$value[&#039;b_loc3_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc3 ASC&quot;;
                    $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                    $row_rsValues = mysql_fetch_assoc($rsValues);

                    $arrayVals = array();

                    do {
                        array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                    } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                    $ret .= &#039;&#039;.__(&#039;Ciudades&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_loc4_cli&#039;] != &#039;&#039;) {

                    mysql_select_db($database_inmoconn, $inmoconn);
                    $query_rsValues = &quot;SELECT name_&quot;.$lang_adm.&quot;_loc4 as name FROM properties_loc4 WHERE id_loc4 IN (&quot;.$value[&#039;b_loc4_cli&#039;].&quot;) ORDER BY name_&quot;.$lang_adm.&quot;_loc4 ASC&quot;;
                    $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                    $row_rsValues = mysql_fetch_assoc($rsValues);

                    $arrayVals = array();

                    do {
                        array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                    } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                    mysql_free_result($rsValues);

                    $ret .= &#039;&#039;.__(&#039;Zonas&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_beds_cli&#039;] != &#039;&#039;) {
                    $ret .= &#039;&#039;.__(&#039;Habitaciones&#039;, true). &#039;: &#039; . $value[&#039;b_beds_cli&#039;] . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_baths_cli&#039;] != &#039;&#039;) {
                    $ret .= &#039;&#039;.__(&#039;Aseos&#039;, true). &#039;: &#039; . $value[&#039;b_baths_cli&#039;] . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_precio_desde_cli&#039;] != &#039;&#039;) {
                    $ret .= &#039;&#039;.__(&#039;Precio desde&#039;, true). &#039;: &#039; . $value[&#039;b_precio_desde_cli&#039;] . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_precio_hasta_cli&#039;] != &#039;&#039;) {
                    $ret .= &#039;&#039;.__(&#039;Precio hasta&#039;, true). &#039;: &#039; . $value[&#039;b_precio_hasta_cli&#039;] . &#039;&lt;br&gt;&#039;;
                }

                if ($value[&#039;b_ref_cli&#039;] != &#039;&#039;) {

                    $refArray = explode(&#039;,&#039;, $value[&#039;b_ref_cli&#039;]);
                    $refArrayVals = array();

                    foreach ($refArray as $key =&gt; $value) {
                        array_push($refArrayVals , &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
                    }

                    mysql_select_db($database_inmoconn, $inmoconn);
                    $query_rsValues = &quot;SELECT referencia_prop as name FROM properties_properties WHERE referencia_prop IN (&quot;.implode(&#039;,&#039;, $refArrayVals).&quot;) ORDER BY referencia_prop ASC&quot;;
                    $rsValues = mysql_query($query_rsValues, $inmoconn) or die(mysql_error());
                    $row_rsValues = mysql_fetch_assoc($rsValues);

                    $arrayVals = array();

                    do {
                        array_push($arrayVals, $row_rsValues[&#039;name&#039;]);
                    } while ($row_rsValues = mysql_fetch_assoc($rsValues));

                    mysql_free_result($rsValues);

                    $ret .= &#039;&#039;.__(&#039;Referencias&#039;, true). &#039;: &#039; . implode(&#039;, &#039;, $arrayVals) . &#039;&lt;br&gt;&#039;;
                }

                echo &#039;&lt;p&gt;&lt;a href=&quot;javascript:void(0);&quot; class=&quot;btn btn-primary popoverbtn&quot; data-toggle=&quot;popover&quot; data-placement=&quot;right&quot; data-html=&quot;true&quot; data-content=&quot;&lt;span&gt;&#039;.$ret.&#039;&lt;/span&gt;&quot; data-original-title=&quot;&#039;.__(&#039;Qu&eacute; esta buscando&#039;, true).&#039;&quot;&gt;&lt;i class=&quot;icon-search&quot;&gt;&lt;/i&gt; &#039;.__(&#039;Qu&eacute; esta buscando&#039;, true).&#039;&lt;/a&gt;&lt;/p&gt;&#039;;

            echo &#039;&lt;/div&gt;&#039;;
            echo &#039;&lt;div class=&quot;col-md-4&quot;&gt;&#039;;

                echo &#039;&lt;p&gt;&#039;.__(&#039;Porcentaje de acierto&#039;, true).&#039;: &#039; . round(($value[&#039;score&#039;]*100)/7) . &#039;%&lt;/p&gt;&#039;;

                echo &#039;&lt;div class=&quot;progress&quot;&gt;&#039;;
                    echo &#039;&lt;div class=&quot;progress-bar progress-bar-primary progress-bar-striped active&quot; style=&quot;width: &#039; . round(($value[&#039;score&#039;]*100)/7) . &#039;%;&quot;&gt;&lt;/div&gt;&#039;;
                echo &#039;&lt;/div&gt;&#039;;

                echo &#039;&lt;p&gt;&lt;a href=&quot;/intramedianet/properties/clients-form.php?id_cli=&#039;.$value[&#039;id&#039;].&#039;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-block popoverbtn&quot; data-toggle=&quot;popover&quot; data-placement=&quot;left&quot; data-content=&quot;&#039;.__(&#039;Guarde el inmueble antes de mostrar el cliente. Si no lo hece se pueden perder las modificaciones.&#039;, true).&#039;&quot; data-original-title=&quot;&#039;.__(&#039;Recuerde&#039;, true).&#039;&quot;&gt;&#039;.__(&#039;Mostra cliente&#039;, true).&#039;&lt;/a&gt;&lt;/p&gt;&#039;;

                if ($value[&#039;idioma_cli&#039;] != &#039;&#039;) {
                    $langCli = $value[&#039;idioma_cli&#039;];
                } else {
                    $langCli = $language;
                }


                echo &#039;&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btn-block btnsend&quot; data-email=&quot;&#039; . $value[&#039;email&#039;] . &#039;&quot; data-lang=&quot;&#039; . $langCli . &#039;&quot;&gt;&#039;.  __(&#039;Enviar&#039;, true) .&#039; &#039;.  __(&#039;Inmueble&#039;, true) .&#039;&lt;/a&gt;&#039;;


            echo &#039;&lt;/div&gt;&#039;;
        echo &#039;&lt;/div&gt;&#039;;

        echo &quot;&lt;hr&gt;&quot;;
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

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> En la búsqueda de clientes no funciona los inmuebles visitados
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-data-adv.php:225
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$pnt = &#039;&#039;;
if( isset($_GET[&#039;puntuacion_cli&#039;]) &amp;&amp; $_GET[&#039;puntuacion_cli&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;puntuacion_cli&#039;] != &#039;0&#039; ){
    $pnt = &quot;AND puntuacion_cli = &quot; . $_GET[&#039;puntuacion_cli&#039;];
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$vstd = &#039;&#039;;
if( isset($_GET[&#039;visited_cli&#039;]) &amp;&amp; $_GET[&#039;visited_cli&#039;] != &#039;&#039; ){
    $type = implode(&#039;,&#039;, $_GET[&#039;visited_cli&#039;]);
    $vstd = &quot; AND ( 1=2 &quot;;
    foreach ($_GET[&#039;visited_cli&#039;] as $value) {
      if ($value != &#039;&#039;) {
        $vstd .= &quot; OR (FIND_IN_SET(&#039;$value&#039;, visited_cli) &gt; 0) &quot;;
      }
    }
    $vstd .= &quot;)&quot;;
}

$pnt = &#039;&#039;;
if( isset($_GET[&#039;puntuacion_cli&#039;]) &amp;&amp; $_GET[&#039;puntuacion_cli&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;puntuacion_cli&#039;] != &#039;0&#039; ){
    $pnt = &quot;AND puntuacion_cli = &quot; . $_GET[&#039;puntuacion_cli&#039;];
}
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-data-adv.php:555
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $op2 $fav $tags $atnd
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $op2 $fav $tags $atnd $vstd
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
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes varios SEO
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:186
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;p&gt;&copy; {$smarty.now|date_format:&quot;%Y&quot;} &#x25cf; {$lng_diseno}: &lt;a href=&quot;https://www.mediaelx.net&quot; target=&quot;_blank&quot; rel=&quot;nofollow&quot;&gt;Mediaelx&lt;/a&gt; &#x25cf; &lt;a href=&quot;{$urlStart}{$url_legal_note}/&quot; rel=&quot;nofollow&quot;&gt;{$lng_nota_legal}&lt;/a&gt; &#x25cf; &lt;a href=&quot;{$urlStart}{$url_privacy}/&quot; rel=&quot;nofollow&quot;&gt;{$lng_privacidad}&lt;/a&gt; &#x25cf; &lt;a href=&quot;{$urlStart}{$url_sitemap}/&quot; {if $seccion == {$url_sitemap}}rel=&quot;canonical&quot;{/if}&gt;{$lng_mapa_web}&lt;/a&gt;&lt;/p&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;p&gt;&copy; {$smarty.now|date_format:&quot;%Y&quot;} &#x25cf; {$lng_diseno}: &lt;a href=&quot;https://www.mediaelx.net&quot; target=&quot;_blank&quot; rel=&quot;nofollow&quot;&gt;Mediaelx&lt;/a&gt; &#x25cf; &lt;a href=&quot;{$urlStart}{$url_legal_note}/&quot; rel=&quot;nofollow&quot;&gt;{$lng_nota_legal}&lt;/a&gt; &#x25cf; &lt;a href=&quot;{$urlStart}{$url_privacy}/&quot; rel=&quot;nofollow&quot;&gt;{$lng_privacidad}&lt;/a&gt; &#x25cf; &lt;a href=&quot;{$urlStart}cookies/&quot; rel=&quot;nofollow&quot;&gt;{$lng_cookies}&lt;/a&gt; &#x25cf; &lt;a href=&quot;{$urlStart}{$url_sitemap}/&quot; {if $seccion == {$url_sitemap}}rel=&quot;canonical&quot;{/if}&gt;{$lng_mapa_web}&lt;/a&gt;&lt;/p&gt;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/resources/lang_da.php
/resources/lang_de.php
/resources/lang_en.php
/resources/lang_es.php
/resources/lang_fi.php
/resources/lang_fr.php
/resources/lang_is.php
/resources/lang_nl.php
/resources/lang_no.php
/resources/lang_ru.php
/resources/lang_se.php
/resources/lang_zh.php
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
$langStr["Cookies"] = "Cookies";
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/menu.tpl:37
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li {if $submenu == 1}class=&quot;list-inline-item{if $seccion == {$url_favorites}} active{/if}&quot;{else}{if $seccion == &#039;&#039;}class=&quot;active&quot;{/if}{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_favorites}/&quot;&gt;&lt;span class=&quot;favor&quot;&gt;&lt;/span&gt; {$lng_favoritos} &lt;span id=&quot;budget-fav&quot;&gt;{if $totalFavs &gt; 0}({$totalFavs}){/if}&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li {if $submenu == 1}class=&quot;list-inline-item{if $seccion == {$url_favorites}} active{/if}&quot;{else}{if $seccion == &#039;&#039;}class=&quot;active&quot;{/if}{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_favorites}/&quot; rel=&quot;nofollow&quot;&gt;&lt;span class=&quot;favor&quot;&gt;&lt;/span&gt; {$lng_favoritos} &lt;span id=&quot;budget-fav&quot;&gt;{if $totalFavs &gt; 0}({$totalFavs}){/if}&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/botonera.tpl:12
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;/modules/property/save.php?id={$property[0].id_prop}&amp;lang={$lang}&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm descargar&quot;&gt;{$lng_pdfimprimir}&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;/modules/property/save.php?id={$property[0].id_prop}&amp;lang={$lang}&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm descargar&quot; rel=&quot;nofollow&quot;&gt;{$lng_pdfimprimir}&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:41
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if count($languages) > 1}
    {foreach from=$languages item=idm}
        {if $idm != $language}
        <link rel="alternate" hreflang="{$idm}" href="{$url{$idm|upper}}" />
        {else}
        <link rel="alternate" hreflang="{$idm}" href="{$urlDefault}" />
        {/if}
    {/foreach}
    {/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if count($languages) > 1}
    {foreach from=$languages item=idm}
        {if $idm != $language}
        <link rel="alternate" hreflang="{$idm}" href={$smarty.server.REQUEST_SCHEME}"://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}" />
        {else}
        <link rel="alternate" hreflang="{$idm}" href="{$smarty.server.REQUEST_SCHEME}"://{$smarty.server.HTTP_HOST}{$urlDefault}" />
        {/if}
    {/foreach}
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Convertidos algunos select2 a ajax para poder trabajar con miles de registros sin ralentizar la página
    </h6>
    <div class="card-body">
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i> En esta actualización, hay tanto que modificar que es mejor sobrreescribie los archivos. Si has modificado alguno de los archivos sobreescribe el resto y pregunta a Jose para que te indique que hay que modificar en los archivos que has modificado.
        </div>
        Subir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-buyers-select-single.php
/intramedianet/properties/properties-buyers-select.php
/intramedianet/properties/properties-owners-select-single.php
/intramedianet/properties/properties-owners-select.php
/intramedianet/properties/properties-references-select-multiple.php
/intramedianet/properties/properties-references-select-single.php
/intramedianet/properties/properties-references-select.php
            </code>
        </pre>
        <hr>
        Sustituir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/calendar/calendario.php
/intramedianet/calendar/_js/calendar-view.js
/intramedianet/inicio/inicio.php
/intramedianet/inicio/_js/dashboard.js
/intramedianet/properties/properties-form.php
/intramedianet/properties/_js/properties-form.js
/intramedianet/properties/clients-form.php
/intramedianet/properties/clients-search.php
            </code>
        </pre>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Los quicklinks ahora permiten seleccionar varios tipos, estatus, poblaciones y zonas
    </h6>
    <div class="card-body">
        Ejecutar las siguientes queries en la base de datos:
        <pre>
            <code class="sql">
ALTER TABLE `news` CHANGE COLUMN `quick_location_nws` `quick_location_nws` TEXT NULL  COMMENT &#039;&#039; AFTER `featured_properties_nws`;
ALTER TABLE `news` CHANGE COLUMN `quick_type_nws` `quick_type_nws` TEXT NULL  COMMENT &#039;&#039; AFTER `quick_location_nws`;
ALTER TABLE `news` CHANGE COLUMN `quick_status_nws` `quick_status_nws` TEXT NULL  COMMENT &#039;&#039; AFTER `quick_type_nws`;
ALTER TABLE `news` CHANGE COLUMN `quick_town_nws` `quick_town_nws` TEXT NULL  COMMENT &#039;&#039; AFTER `quick_status_nws`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:317
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//start Trigger_UpdateHtaccess trigger
//remove this line if you want to edit the code by hand
function Trigger_UpdateHtaccess(&amp;$tNG) {

  include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/resources/urls.php&quot;);

  global $database_inmoconn, $inmoconn, $language, $languages;
  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsLandings = &quot;SELECT * FROM news WHERE type_nws = 4&quot;;
  $rsLandings = mysql_query($query_rsLandings, $inmoconn) or die(mysql_error());
  $row_rsLandings = mysql_fetch_assoc($rsLandings);
  $totalRows_rsLandings = mysql_num_rows($rsLandings);

  $newText = &#039;&#039;;

  do {

    foreach($languages as $value) {
      if ($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;] != &#039;&#039;) {

        $tw = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
          $tw = &#039;&amp;loct[]=&#039; . $row_rsLandings[&#039;quick_town_nws&#039;];
        }

        $loc = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_location_nws&#039;] != &#039;&#039;) {
          $loc = &#039;&amp;lozn[]=&#039; . $row_rsLandings[&#039;quick_location_nws&#039;];
        }

        $typ = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_type_nws&#039;] != &#039;&#039;) {
          $typ = &#039;&amp;tp[]=&#039; . $row_rsLandings[&#039;quick_type_nws&#039;];
        }

        // echo $typ . &#039;&lt;hr&gt;&#039;;

        $sta = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_status_nws&#039;] != &#039;&#039;) {
          $sta = &#039;&amp;st=&#039; . $row_rsLandings[&#039;quick_status_nws&#039;];
        }

        if ($language == $value) {
            $newText .= &quot;\nRewriteRule ^&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
        } else {
            $newText .= &quot;\nRewriteRule ^&quot;.$value.&quot;/&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
        }

      }
    }

  } while ($row_rsLandings = mysql_fetch_assoc($rsLandings));

  // echo $newText;
  // aa();

  $filename = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/.htaccess&#039;;
  $htaccess = file_get_contents($filename);

  $htaccess = replaceTags(&#039;## quicklinks&#039;,&#039;## end quicklinks&#039;, $newText . &quot;\n&quot;, $htaccess);
  file_put_contents($filename, $htaccess);

  return true;
}
//end Trigger_UpdateHtaccess trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//start Trigger_UpdateHtaccess trigger
//remove this line if you want to edit the code by hand
function Trigger_UpdateHtaccess(&amp;$tNG) {

  include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/resources/urls.php&quot;);

  global $database_inmoconn, $inmoconn, $language, $languages;
  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsLandings = &quot;SELECT * FROM news WHERE type_nws = 4&quot;;
  $rsLandings = mysql_query($query_rsLandings, $inmoconn) or die(mysql_error());
  $row_rsLandings = mysql_fetch_assoc($rsLandings);
  $totalRows_rsLandings = mysql_num_rows($rsLandings);

  $newText = &#039;&#039;;

  do {

    foreach($languages as $value) {
      if ($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;] != &#039;&#039;) {

        $tw = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_town_nws&#039;] != &#039;&#039;) {
            $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_town_nws&#039;]);
            foreach ($parts as $part) {
                $tw .= &#039;&amp;loct[]=&#039; . $part;
            }
        }

        $loc = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_location_nws&#039;] != &#039;&#039;) {
            $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_location_nws&#039;]);
            foreach ($parts as $part) {
                $loc .= &#039;&amp;lozn[]=&#039; . $part;
            }
        }

        $typ = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_type_nws&#039;] != &#039;&#039;) {
            $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_type_nws&#039;]);
            foreach ($parts as $part) {
                $typ .= &#039;&amp;tp[]=&#039; . $part;
            }
        }

        $sta = &#039;&#039;;
        if ($row_rsLandings[&#039;quick_status_nws&#039;] != &#039;&#039;) {
            $parts = explode(&#039;,&#039;, $row_rsLandings[&#039;quick_status_nws&#039;]);
            foreach ($parts as $part) {
                $sta .= &#039;&amp;st[]=&#039; . $part;
            }
        }

        if ($language == $value) {
            $newText .= &quot;\nRewriteRule ^&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
        } else {
            $newText .= &quot;\nRewriteRule ^&quot;.$value.&quot;/&quot;.slug($row_rsLandings[&#039;title_&#039;.$value.&#039;_nws&#039;]).&quot;.html$ &quot;.$urlStr[&quot;properties&quot;][$value].&quot;/?lang=&quot;.$value.&quot;&amp;idquick=&quot;.$row_rsLandings[&#039;id_nws&#039;].&quot;&quot;.$loc.&quot;&quot;.$tw.&quot;&quot;.$typ.&quot;&quot;.$sta.&quot; [L,QSA]&quot;;
        }

      }
    }

  } while ($row_rsLandings = mysql_fetch_assoc($rsLandings));

  $filename = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/.htaccess&#039;;
  $htaccess = file_get_contents($filename);

  $htaccess = replaceTags(&#039;## quicklinks&#039;,&#039;## end quicklinks&#039;, $newText . &quot;\n&quot;, $htaccess);
  file_put_contents($filename, $htaccess);

  return true;
}
//end Trigger_UpdateHtaccess trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:390
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache(&amp;$tNG) {
    return array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/modules/_cache/*&quot;));
}
//end removeCache trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//start removeCache trigger
//remove this line if you want to edit the code by hand
function removeCache(&amp;$tNG) {
    return array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/modules/_cache/*&quot;));
}
//end removeCache trigger

if (isset($_POST[&#039;quick_status_nws&#039;]) &amp;&amp; $_POST[&#039;quick_status_nws&#039;] != &#039;&#039; ) {
  $_POST[&#039;quick_status_nws&#039;] = implode(&#039;,&#039;, $_POST[&#039;quick_status_nws&#039;]);
}
if (isset($_POST[&#039;quick_type_nws&#039;]) &amp;&amp; $_POST[&#039;quick_type_nws&#039;] != &#039;&#039; ) {
  $_POST[&#039;quick_type_nws&#039;] = implode(&#039;,&#039;, $_POST[&#039;quick_type_nws&#039;]);
}
if (isset($_POST[&#039;quick_town_nws&#039;]) &amp;&amp; $_POST[&#039;quick_town_nws&#039;] != &#039;&#039; ) {
  $_POST[&#039;quick_town_nws&#039;] = implode(&#039;,&#039;, $_POST[&#039;quick_town_nws&#039;]);
}
if (isset($_POST[&#039;quick_location_nws&#039;]) &amp;&amp; $_POST[&#039;quick_location_nws&#039;] != &#039;&#039; ) {
  $_POST[&#039;quick_location_nws&#039;] = implode(&#039;,&#039;, $_POST[&#039;quick_location_nws&#039;]);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:432
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;quick_location_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_location_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_type_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_type_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_status_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_status_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;quick_location_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_location_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_type_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_type_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_status_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_status_nws&quot;);
$ins_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:459

            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;quick_location_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_location_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_type_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_type_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_status_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_status_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;quick_location_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_location_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_type_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_type_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_status_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_status_nws&quot;);
$upd_news-&gt;addColumn(&quot;quick_town_nws&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;quick_town_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:574
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
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
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
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
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:597
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
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
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
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
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:626
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;control-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_type_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;quick_type_nws&quot;&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;:&lt;/label&gt;
  &lt;div&gt;
      &lt;select name=&quot;quick_type_nws&quot; id=&quot;quick_type_nws&quot; class=&quot;form-control select2&quot;&gt;
          &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsTipos[&#039;id_type&#039;] ?&gt;&quot; &lt;?php if (!(strcmp($row_rsTipos[&#039;id_type&#039;], $row_rsnews[&#039;quick_type_nws&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsTipos[&#039;types_&#039;.$lang_adm.&#039;_typ&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsTipos = mysql_fetch_assoc($rsTipos));
            $rows = mysql_num_rows($rsTipos);
            if($rows &gt; 0) {
                mysql_data_seek($rsTipos, 0);
              $row_rsTipos = mysql_fetch_assoc($rsTipos);
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_type_nws&quot;); ?&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;control-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_type_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;quick_type_nws&quot;&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;:&lt;/label&gt;
    &lt;div&gt;
        &lt;select name=&quot;quick_type_nws[]&quot; id=&quot;quick_type_nws&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
            &lt;?php
            do {
              $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_type_nws&#039;]);
            ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsTipos[&#039;id_type&#039;] ?&gt;&quot; &lt;?php if (in_array($row_rsTipos[&#039;id_type&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsTipos[&#039;types_&#039;.$lang_adm.&#039;_typ&#039;]?&gt;&lt;/option&gt;
            &lt;?php
            } while ($row_rsTipos = mysql_fetch_assoc($rsTipos));
              $rows = mysql_num_rows($rsTipos);
              if($rows &gt; 0) {
                  mysql_data_seek($rsTipos, 0);
                $row_rsTipos = mysql_fetch_assoc($rsTipos);
              }
            ?&gt;
        &lt;/select&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_type_nws&quot;); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:652
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;control-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_status_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;quick_status_nws&quot;&gt;&lt;?php __(&#039;Operaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
  &lt;div&gt;
      &lt;select name=&quot;quick_status_nws&quot; id=&quot;quick_status_nws&quot; class=&quot;form-control select2&quot;&gt;
          &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
          &lt;?php
          do {
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsSales[&#039;id_sta&#039;]?&gt;&quot; &lt;?php if (!(strcmp($row_rsSales[&#039;id_sta&#039;], $row_rsnews[&#039;quick_status_nws&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsSales[&#039;status_&#039;.$lang_adm.&#039;_sta&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsSales = mysql_fetch_assoc($rsSales ));
            $rows = mysql_num_rows($rsSales );
            if($rows &gt; 0) {
                mysql_data_seek($rsSales , 0);
              $row_rsSales = mysql_fetch_assoc($rsSales );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_status_nws&quot;); ?&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;control-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_status_nws&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;quick_status_nws&quot;&gt;&lt;?php __(&#039;Operaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
  &lt;div&gt;
      &lt;select name=&quot;quick_status_nws[]&quot; id=&quot;quick_status_nws&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot; data-placeholder=&quot;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&quot;&gt;
          &lt;?php
          do {
            $vals = explode(&#039;,&#039;, $row_rsnews[&#039;quick_status_nws&#039;]);
          ?&gt;
          &lt;option value=&quot;&lt;?php echo $row_rsSales[&#039;id_sta&#039;]?&gt;&quot; &lt;?php if (in_array($row_rsSales[&#039;id_sta&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsSales[&#039;status_&#039;.$lang_adm.&#039;_sta&#039;]?&gt;&lt;/option&gt;
          &lt;?php
          } while ($row_rsSales = mysql_fetch_assoc($rsSales ));
            $rows = mysql_num_rows($rsSales );
            if($rows &gt; 0) {
                mysql_data_seek($rsSales , 0);
              $row_rsSales = mysql_fetch_assoc($rsSales );
            }
          ?&gt;
      &lt;/select&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;quick_status_nws&quot;); ?&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/init.php:29
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($_GET[&#039;lang&#039;] == $language) {
    header(&quot;HTTP/1.1 301 Moved Permanently&quot;);
    header(&quot;Location: &quot; . str_replace(&#039;/&#039; . $_GET[&#039;lang&#039;] . &#039;/&#039;, &#039;/&#039;, $_SERVER[&#039;REQUEST_URI&#039;]));
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($_GET[&#039;lang&#039;] == $language &amp;&amp; !preg_match(&#039;/\.html/&#039;, $_SERVER[&#039;REQUEST_URI&#039;])) {
    header(&quot;HTTP/1.1 301 Moved Permanently&quot;);
    header(&quot;Location: &quot; . str_replace(&#039;/&#039; . $_GET[&#039;lang&#039;] . &#039;/&#039;, &#039;/&#039;, $_SERVER[&#039;REQUEST_URI&#039;]));
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/buscador.tpl:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
    &lt;select name=&quot;st&quot; id=&quot;st{$dupl}&quot; &gt;
        &lt;option value=&quot;&quot;&gt;{$lng_estado}&lt;/option&gt;
        {section name=st loop=$status}
        {if $status[st].visible}
            &lt;option value=&quot;{$status[st].id}&quot; {if $smarty.get.st == $status[st].id || $smarty.get.st[0] == $status[st].id}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
        {/if}
        {/section}
    &lt;/select&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
    &lt;select name=&quot;st[]&quot; id=&quot;st{$dupl}&quot; class=&quot;form-control select2&quot; multiple data-placeholder=&quot;{$lng_estado}&quot;&gt;
        &lt;option value=&quot;&quot;&gt;{$lng_estado}&lt;/option&gt;
        {section name=st loop=$status}
        {if $status[st].visible}
            &lt;option value=&quot;{$status[st].id}&quot; {if in_array($status[st].id, $smarty.get.st)}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
        {/if}
        {/section}
    &lt;/select&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:160
/modules/properties/properties-map.php:153
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$st = &#039;&#039;;
if( isset($_GET[&#039;st&#039;]) &amp;&amp; $_GET[&#039;st&#039;] != &#039;&#039; ){
    $st = &quot;AND operacion_prop LIKE &#039;&quot; . simpleSanitize(($_GET[&#039;st&#039;])) . &quot;&#039;&quot;;
}

if ($_GET[&#039;st&#039;][0] != &#039;&#039; &amp;&amp; $_GET[&#039;st&#039;][1] != &#039;&#039;) {
    $st = &quot;AND operacion_prop IN(&quot; . simpleSanitize(($_GET[&#039;st&#039;][0])) . &quot;,&quot; . simpleSanitize(($_GET[&#039;st&#039;][1])) . &quot;)&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$st = &#039;&#039;;
if( isset($_GET[&#039;st&#039;]) &amp;&amp; $_GET[&#039;st&#039;][0] != &#039;&#039; ){
    $status = implode(&#039;,&#039;, $_GET[&#039;st&#039;]);
    if ($status != &#039;&#039;) {
        $st = &quot;AND operacion_prop  IN (&quot; . simpleSanitize($status) . &quot;)&quot;;
    }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:638
/modules/properties/properties-map.php:153
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$st = &#039;&#039;;
if( isset($_GET[&#039;st&#039;]) &amp;&amp; $_GET[&#039;st&#039;] != &#039;&#039; ){
    $st = getRecords(&quot;SELECT id_sta, status_&quot;.$lang.&quot;_sta as sale FROM properties_status WHERE id_sta = &quot; . simpleSanitize(($_GET[&#039;st&#039;])));
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$st = &#039;&#039;;
if( isset($_GET[&#039;st&#039;]) &amp;&amp; $_GET[&#039;st&#039;] != &#039;&#039; ){
    $status = implode(&#039;,&#039;, $_GET[&#039;st&#039;]);
    if ($status  != &#039;&#039;) {
        $st = getRecords(&quot;
            SELECT id_sta, status_&quot;.$lang.&quot;_sta as sale
            FROM properties_status
            WHERE id_sta IN (&quot; . simpleSanitize($status) . &quot;)
            GROUP BY id_sta&quot;);
    }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:775
/modules/properties/properties-map.php:660
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$breadcrumb[&#039;sale&#039;] = $st[0];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$breadcrumb[&#039;sale&#039;] = $st;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/total.php:95
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$st = &#039;&#039;;
if( isset($_GET[&#039;st&#039;]) &amp;&amp; $_GET[&#039;st&#039;] != &#039;&#039; ){
    $st = &quot;AND operacion_prop LIKE &#039;&quot; . simpleSanitize(($_GET[&#039;st&#039;])) . &quot;&#039;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$st = &#039;&#039;;
if( isset($_GET[&#039;st&#039;]) &amp;&amp; $_GET[&#039;st&#039;][0] != &#039;&#039; ){
    $status = implode(&#039;,&#039;, $_GET[&#039;st&#039;]);
    if ($status != &#039;&#039;) {
        $st = &quot;AND operacion_prop  IN (&quot; . simpleSanitize($status) . &quot;)&quot;;
    }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/view/partials/breadcrumb.tpl:47
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $breadcrumb[&#039;sale&#039;] != &quot;&quot;}
    &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;{$urlStart}{$url_properties}/?st={$breadcrumb[&#039;sale&#039;].id_sta}&quot;&gt;{$breadcrumb[&#039;sale&#039;].sale}&lt;/a&gt;&lt;/li&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $breadcrumb[&#039;sale&#039;] != &quot;&quot;}
    &lt;li class=&quot;breadcrumb-item&quot;&gt;
        {section name=sts loop=$breadcrumb[&#039;sale&#039;]}
            {if !$smarty.section.sts.first} / {/if}
            &lt;a href=&quot;{$urlStart}{$url_properties}/?st[]={$breadcrumb[&#039;sale&#039;][sts].id_sta}&quot;&gt;{$breadcrumb[&#039;sale&#039;][sts].sale}&lt;/a&gt;
        {/section}
    &lt;/li&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:796
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$_GET[&quot;st&quot;] = $statusValue[&quot;id&quot;];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$_GET[&quot;st&quot;][] = $statusValue[&quot;id&quot;];
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:302
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#st&#039;).change(function (e) {
  if($(&#039;#st&#039;).val() == &#039;&#039;) {
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st&#039;).val() == &#039;3&#039; || $(&#039;#st&#039;).val() == &#039;4&#039;) {  // RENTAL
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 0, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 0, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st&#039;).val() == &#039;1&#039; || $(&#039;#st&#039;).val() == &#039;2&#039;) {  // SALE
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 0, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 0, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
}).change();

$(&#039;#st1&#039;).change(function (e) {
  if($(&#039;#st1&#039;).val() == &#039;&#039;) {
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st1&#039;).val() == &#039;3&#039; || $(&#039;#st1&#039;).val() == &#039;4&#039;) {  // RENTAL
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 0, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 0, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st1&#039;).val() == &#039;1&#039; || $(&#039;#st1&#039;).val() == &#039;2&#039;) {  // SALE
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 0, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 0, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
}).change();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#st&#039;).change(function (e) {
  if($(&#039;#st&#039;).val() == &#039;&#039;) {
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st&#039;).val() == &#039;3&#039; || $(&#039;#st&#039;).val() == &#039;4&#039;) {  // RENTAL
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 0, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 0, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st&#039;).val() == &#039;1&#039; || $(&#039;#st&#039;).val() == &#039;2&#039;) {  // SALE
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 0, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 0, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if (/(,)/.test($(&#039;#st&#039;).val())) {
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
}).change();

$(&#039;#st1&#039;).change(function (e) {
  if($(&#039;#st1&#039;).val() == &#039;&#039;) {
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st1&#039;).val() == &#039;3&#039; || $(&#039;#st1&#039;).val() == &#039;4&#039;) {  // RENTAL
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 0, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 0, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st1&#039;).val() == &#039;1&#039; || $(&#039;#st1&#039;).val() == &#039;2&#039;) {  // SALE
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 0, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 0, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if (/(,)/.test($(&#039;#st1&#039;).val())) {
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
}).change();
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 4 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Nueva forma de ocultar inmuebles importados
    </h6>
    <div class="card-body">
        Ejecutar la siguiente query en la base de datos:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `force_hide_prop` INT(1) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `activado_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:664
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;activado_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;activado_prop&quot;, &quot;1&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;activado_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;activado_prop&quot;, &quot;1&quot;);
$ins_properties_properties-&gt;addColumn(&quot;force_hide_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;force_hide_prop&quot;, &quot;1&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:833
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;activado_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;activado_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;force_hide_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;force_hide_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;force_hide_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;force_hide_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1227
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;checkbox &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;activado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label&gt;
            &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;activado_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;activado_prop&quot; id=&quot;activado_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
            &lt;?php __(&#039;Activar la propiedad&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;activado_prop&quot;); ?&gt;
    &lt;/div&gt;

&lt;/div&gt; &lt;!--/.col-md-4 --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;checkbox &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;activado_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label&gt;
            &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;activado_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;activado_prop&quot; id=&quot;activado_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
            &lt;?php __(&#039;Activar la propiedad&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;activado_prop&quot;); ?&gt;
    &lt;/div&gt;

&lt;/div&gt; &lt;!--/.col-md-4 --&gt;

&lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;checkbox text-danger &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;force_hide_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label&gt;
            &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;force_hide_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;force_hide_prop&quot; id=&quot;force_hide_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
            &lt;?php __(&#039;Ocultar&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;force_hide_prop&quot;); ?&gt;
    &lt;/div&gt;

&lt;/div&gt; &lt;!--/.col-md-4 --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($xmlImport == 1) {
    $totCols = $totCols + 3;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($xmlImport == 1) {
    $totCols = $totCols + 4;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:103
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Proveedor&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Oculto&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Proveedor&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:168
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;proveedor&quot; id=&quot;proveedor&quot; class=&quot;form-control input-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;force_hide_prop&quot; id=&quot;force_hide_prop&quot;&gt;

    &lt;select name=&quot;force_hide_prop_sel&quot; id=&quot;force_hide_prop_sel&quot; class=&quot;form-control input-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;

&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;proveedor&quot; id=&quot;proveedor&quot; class=&quot;form-control input-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:188
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var theFavsNum = &lt;?php echo count($theFavs2) ?&gt;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var theFavsNum = &lt;?php echo count($theFavs2) ?&gt;;
var showprecioReduc = &lt;?php echo ($showprecioReduc == 1)?1:0 ?&gt;;
var xmlImport = &lt;?php echo ($xmlImport == 1)?1:0 ?&gt;;
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
$lang[&#039;Oculto&#039;] = &#039;Oculto&#039;;
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
$lang[&#039;Oculto&#039;] = &#039;Hidden&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-data.php:47
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, &#039;xml_xml_prop&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, &#039;force_hide_prop&#039;);
array_push($aColumns, &#039;xml_xml_prop&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-data.php:178
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($aColumns[$i] == 'destacado_prop' || $aColumns[$i] == 'activado_prop' || $aColumns[$i] == 'ubiflow_prop' || $aColumns[$i] == 'rightmove_prop' || $aColumns[$i] == 'greenacres_prop' || $aColumns[$i] == 'zoopla_prop' || $aColumns[$i] == 'inmoweb_prop' || $aColumns[$i] == 'trovit_prop' || $aColumns[$i] == 'oferta_prop') {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($aColumns[$i] == 'destacado_prop' || $aColumns[$i] == 'activado_prop' || $aColumns[$i] == 'ubiflow_prop' || $aColumns[$i] == 'rightmove_prop' || $aColumns[$i] == 'greenacres_prop' || $aColumns[$i] == 'zoopla_prop' || $aColumns[$i] == 'inmoweb_prop' || $aColumns[$i] == 'trovit_prop' || $aColumns[$i] == 'oferta_prop' || $aColumns[$i] == 'force_hide_prop') {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-data.php:245
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case properties_properties.activado_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as activado_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case properties_properties.activado_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as activado_prop,
case properties_properties.force_hide_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as force_hide_prop,
            </code>
        </pre>
        <hr>
        Sustituir el archivo <code>/intramedianet/properties/_js/properties-list.js</code> por el archivo de esta versión.
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:356
/modules/properties/total.php:291
/modules/properties/properties-map.php:349
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$secc = &#039;activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$secc = &#039;activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1&#039;;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:570
/modules/properties/properties-map.php:462
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE lat_long_gp_prop != &#039;&#039; AND lat_long_gp_prop != &#039;0,0&#039; AND procesada_img = 1
    AND activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE lat_long_gp_prop != &#039;&#039; AND lat_long_gp_prop != &#039;0,0&#039; AND procesada_img = 1
    AND activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/sitemap/sitemap.php:142
/sitemap.php:167
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE activado_prop = 1 AND procesada_img = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE activado_prop = 1 AND procesada_img = 1 AND force_hide_prop != 1
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/kyero.php:132
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE properties_properties.activado_prop = 1 AND vendido_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE properties_properties.activado_prop = 1 AND vendido_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/ids-kyero-tot.php:175
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE properties_properties.activado_prop = 1 AND vendido_prop = 0 AND reservado_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">

            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:260
/index.php:278
/index.php:296
/index.php:314
/index.php:328
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:397
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND destacado_prop = 1 AND image_img != ''
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND destacado_prop = 1 AND image_img != '' AND force_hide_prop != 1
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:449
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND oferta_prop = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND oferta_prop = 1 AND force_hide_prop != 1
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 5 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="nueve">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Popup y email de similares al enviar consultas
    </h6>
    <div class="card-body">
        Sibir los archivos:
        <pre>
            <code>
/modules/property/view/partials/modal-similares.tpl
/modules/mail_partials/similar-properties.php
/modules/property/enquiry.php
        </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:369
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{include file=&quot;file:modules/property/view/partials/modal-bajada.tpl&quot; }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{include file=&quot;file:modules/property/view/partials/modal-bajada.tpl&quot; }
{include file=&quot;file:modules/property/view/partials/modal-similares.tpl&quot; }
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss:570
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
#featured-properties, #ofertas-properties, #similares-properties {

            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
#featured-properties, #ofertas-properties, #similares-properties, #similares-properties-modal {

            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:196
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&quot;#featured-properties .slides, #ofertas-properties .slides, #similares-properties .slides&quot;).slick({
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&quot;#featured-properties .slides, #ofertas-properties .slides, #similares-properties .slides, #similares-properties-modal .slides&quot;).slick({
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:54i
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
swal(&#039;&#039;, okConsult, &#039;success&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#similarModal&#039;).modal(&#039;toggle&#039;);
$(&#039;#similares-properties-modal .slides&#039;).resize();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_da.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Vi har modtaget din foresp&oslash;rgsel om ejendommen med reference&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;En af vores agenter vil kontakte dig hurtigst muligt&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;I mellemtiden kan du kigge p&aring; dette udvalg af lignende egenskaber, dette kan v&aelig;re af interesse for dig&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;En hjertelig hilsen&quot;;
$langStr[&quot;Property&quot;] = &quot;Ejendom&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Tak for at kontakte os&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_de.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Wir haben Ihre Anfrage &uuml;ber die Immobilie mit der Referenz erhalten&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;Einer unserer Agenten wird sich so schnell wie m&ouml;glich mit Ihnen in Verbindung setzen&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;In der Zwischenzeit sehen Sie sich bitte diese Auswahl &auml;hnlicher Objekte an, die f&uuml;r Sie von Interesse sein k&ouml;nnten&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;Ein herzlicher Gru&szlig;&quot;;
$langStr[&quot;Property&quot;] = &quot;Eigentum&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Danke, dass Sie uns kontaktiert haben&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;We have received your inquiry about the property with the reference&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;One of our agents will get in touch with you as soon as possible&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;In the meantime, please take a look at this selection of similar properties, this may be of interest to you&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;A cordial greeting&quot;;
$langStr[&quot;Property&quot;] = &quot;Property&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Thank you for contacting us&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;Un cordial saludo&quot;;
$langStr[&quot;Property&quot;] = &quot;Propiedad&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Gracias por contactarnos&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fiphp
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Olemme saaneet tiedustelun kiinteist&ouml;st&auml; viitteell&auml;&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;Yksi edustajamme ottaa sinuun yhteytt&auml; mahdollisimman pian&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;T&auml;ll&auml; v&auml;lin tutustu t&auml;m&auml;n samanlaisten ominaisuuksien valintaan, t&auml;m&auml; voi olla kiinnostava sinulle&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;Syd&auml;mellinen tervehdys&quot;;
$langStr[&quot;Property&quot;] = &quot;Omaisuus&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Kiitos, ett&auml; otit meihin yhteytt&auml;&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fr.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Nous avons re&ccedil;u votre demande concernant la propri&eacute;t&eacute; avec la r&eacute;f&eacute;rence&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;Un de nos agents prendra contact avec vous d&egrave;s que possible&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;En attendant, jetez un oeil &agrave; cette s&eacute;lection de propri&eacute;t&eacute;s similaires, cela peut vous int&eacute;resser&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;Cordialement&quot;;
$langStr[&quot;Property&quot;] = &quot;Propri&eacute;t&eacute;&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Merci pour nous contacter&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_is.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Vi&eth; h&ouml;fum fengi&eth; fyrirspurn &thorn;&iacute;na um eignina me&eth; tilv&iacute;suninni&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;Einn af umbo&eth;sm&ouml;nnum okkar mun komast &iacute; samband vi&eth; &thorn;ig eins flj&oacute;tt og au&eth;i&eth; er&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;&Iacute; millit&iacute;&eth;inni, vinsamlegast sko&eth;a&eth;u &thorn;etta &uacute;rval af svipu&eth;um eignum, &thorn;etta g&aelig;ti haft &aacute;huga &aacute; &thorn;&eacute;r&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;Hei&eth;arlegur kve&eth;ja&quot;;
$langStr[&quot;Property&quot;] = &quot;Eign&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Takk fyrir a&eth; hafa samband vi&eth; okkur&quot;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_nl.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;We hebben uw vraag over het onroerend goed met de referentie ontvangen&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;Een van onze agenten neemt zo snel mogelijk contact met u op&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;Bekijk in de tussentijd een selectie van vergelijkbare accommodaties, dit kan interessant voor u zijn&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;Een hartelijke groet&quot;;
$langStr[&quot;Property&quot;] = &quot;Eigendom&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Bedankt dat je contact met ons hebt opgenomen&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_no.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Vi har mottatt foresp&oslash;rselen din om eiendommen med referansen&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;En av v&aring;re agenter vil komme i kontakt med deg s&aring; snart som mulig&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;I mellomtiden, ta en titt p&aring; dette valget av lignende egenskaper, dette kan v&aelig;re av interesse for deg&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;En hjertelig hilsen&quot;;
$langStr[&quot;Property&quot;] = &quot;Eiendom&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Takk for at du kontakter oss&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_ru.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;&#x41c;&#x44b; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x43b;&#x438; &#x432;&#x430;&#x448; &#x437;&#x430;&#x43f;&#x440;&#x43e;&#x441; &#x43e; &#x441;&#x43e;&#x431;&#x441;&#x442;&#x432;&#x435;&#x43d;&#x43d;&#x43e;&#x441;&#x442;&#x438; &#x441;&#x43e; &#x441;&#x441;&#x44b;&#x43b;&#x43a;&#x43e;&#x439;&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;&#x41e;&#x434;&#x438;&#x43d; &#x438;&#x437; &#x43d;&#x430;&#x448;&#x438;&#x445; &#x430;&#x433;&#x435;&#x43d;&#x442;&#x43e;&#x432; &#x441;&#x432;&#x44f;&#x436;&#x435;&#x442;&#x441;&#x44f; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x43a;&#x430;&#x43a; &#x43c;&#x43e;&#x436;&#x43d;&#x43e; &#x441;&#x43a;&#x43e;&#x440;&#x435;&#x435;&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;&#x412; &#x442;&#x43e; &#x436;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x432;&#x437;&#x433;&#x43b;&#x44f;&#x43d;&#x438;&#x442;&#x435; &#x43d;&#x430; &#x44d;&#x442;&#x43e;&#x442; &#x432;&#x44b;&#x431;&#x43e;&#x440; &#x43f;&#x43e;&#x445;&#x43e;&#x436;&#x438;&#x445; &#x441;&#x432;&#x43e;&#x439;&#x441;&#x442;&#x432;, &#x44d;&#x442;&#x43e; &#x43c;&#x43e;&#x436;&#x435;&#x442; &#x432;&#x430;&#x441; &#x437;&#x430;&#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43e;&#x432;&#x430;&#x442;&#x44c;&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;&#x421;&#x435;&#x440;&#x434;&#x435;&#x447;&#x43d;&#x43e;&#x435; &#x43f;&#x440;&#x438;&#x432;&#x435;&#x442;&#x441;&#x442;&#x432;&#x438;&#x435;&quot;;
$langStr[&quot;Property&quot;] = &quot;&#x418;&#x43c;&#x443;&#x449;&#x435;&#x441;&#x442;&#x432;&#x43e;&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;&#x421;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e;, &#x447;&#x442;&#x43e; &#x43e;&#x431;&#x440;&#x430;&#x442;&#x438;&#x43b;&#x438;&#x441;&#x44c; &#x43a; &#x43d;&#x430;&#x43c;&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_se.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;Vi har f&aring;tt din f&ouml;rfr&aring;gan om egendomen med referensen&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;En av v&aring;ra agenter kommer i kontakt med dig s&aring; snart som m&ouml;jligt&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;Under tiden, ta en titt p&aring; det h&auml;r urvalet av liknande egenskaper, det kan vara av intresse f&ouml;r dig&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;En hj&auml;rtlig h&auml;lsning&quot;;
$langStr[&quot;Property&quot;] = &quot;Fast egendom&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;Tack f&ouml;r att du kontaktade oss&quot;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_zh.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$langStr[&quot;Hemos recibido tu consulta sobre la propiedad con las referencia&quot;] = &quot;&#x6211;&#x4eec;&#x5df2;&#x6536;&#x5230;&#x60a8;&#x5bf9;&#x8be5;&#x7269;&#x4e1a;&#x7684;&#x67e5;&#x8be2;&#x5e76;&#x63d0;&#x4f9b;&#x53c2;&#x8003;&quot;;
$langStr[&quot;Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible&quot;] = &quot;&#x6211;&#x4eec;&#x7684;&#x4ee3;&#x7406;&#x4eba;&#x4e4b;&#x4e00;&#x5c06;&#x5c3d;&#x5feb;&#x4e0e;&#x60a8;&#x8054;&#x7cfb;&quot;;
$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;] = &quot;&#x540c;&#x65f6;&#xff0c;&#x8bf7;&#x770b;&#x770b;&#x8fd9;&#x4e2a;&#x7c7b;&#x4f3c;&#x7684;&#x5c5e;&#x6027;&#x9009;&#x62e9;&#xff0c;&#x8fd9;&#x53ef;&#x80fd;&#x662f;&#x4f60;&#x611f;&#x5174;&#x8da3;&#x7684;&quot;;
$langStr[&quot;Un cordial saludo&quot;] = &quot;&#x4eb2;&#x5207;&#x7684;&#x95ee;&#x5019;&quot;;
$langStr[&quot;Property&quot;] = &quot;&#x5c5e;&#x6027;&quot;;
$langStr[&quot;Gracias por contactarnos&quot;] = &quot;&#x611f;&#x8c22;&#x60a8;&#x4e0e;&#x6211;&#x4eec;&#x8054;&#x7cfb;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>