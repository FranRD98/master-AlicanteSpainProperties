<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 17-11-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>Mostrar google maps en localizaciones privadas y mapa de propiedades</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>Eliminar inmuebles importados al realizar importaciones</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i>Nuevo diseño de PDFs de la web</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i>Solución de bugs</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Mostrar google maps en localizaciones privadas y mapa de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/map/properties.php:453
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
marker.bindPopup(&#039;&lt;div style=&quot;width: 200px; max-width: 200px;&quot;&gt;&lt;div class=&quot;row&quot;&gt;&lt;div class=&quot;col-12&quot;&gt;&#039;+markersLocations[i][1]+&#039;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;row&quot; style=&quot;margin-top: 10px;&quot;&gt;&lt;div class=&quot;col-12&quot;&gt;&lt;h4 style=&quot;font-size: 12px !important; margin-bottom: 5px !important;&quot;&gt;&#039;+markersLocations[i][2]+&#039;&lt;/h4&gt;&#039;+markersLocations[i][3]+&#039;&lt;/strong&gt;&lt;br/&gt;&lt;span class=&quot;prices&quot; style=&quot;margin: 5px 0 10px; display: block; font-weight: 600; color: var(--primary);&quot;&gt;&#039;+markersLocations[i][4]+&#039;&lt;/strong&gt;&lt;/span&gt;&lt;div class=&quot;row&quot;&gt;&lt;div class=&quot;col-sm-12&quot;&gt;&lt;a href=&quot;/intramedianet/properties/properties-form.php?id_prop=&#039;+markersLocations[i][5]+&#039;&amp;amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm btn-edit-info btn-block&quot; style=&quot;color: #fff;&quot;&gt;&lt;i class=&quot;fa fa-pencil&quot;&gt;&lt;/i&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
marker.bindPopup(&#039;&lt;div style=&quot;width: 200px; max-width: 200px;&quot;&gt;&lt;div class=&quot;row&quot;&gt;&lt;div class=&quot;col-12&quot;&gt;&#039;+markersLocations[i][1]+&#039;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;row&quot; style=&quot;margin-top: 10px;&quot;&gt;&lt;div class=&quot;col-12&quot;&gt;&lt;h4 style=&quot;font-size: 12px !important; margin-bottom: 5px !important;&quot;&gt;&#039;+markersLocations[i][2]+&#039;&lt;/h4&gt;&#039;+markersLocations[i][3]+&#039;&lt;/strong&gt;&lt;br/&gt;&lt;span class=&quot;prices&quot; style=&quot;margin: 5px 0 10px; display: block; font-weight: 600; color: var(--primary);&quot;&gt;&#039;+markersLocations[i][4]+&#039;&lt;/strong&gt;&lt;/span&gt;&lt;div class=&quot;row&quot;&gt;&lt;div class=&quot;col-sm-12&quot;&gt;&lt;a href=&quot;/intramedianet/properties/properties-form.php?id_prop=&#039;+markersLocations[i][5]+&#039;&amp;amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm btn-edit-info btn-block&quot; style=&quot;color: #fff;&quot;&gt;&lt;i class=&quot;fa fa-pencil&quot;&gt;&lt;/i&gt;&lt;/a&gt;&lt;a href=&quot;https://www.google.com/maps/search/?api=1&amp;query=&#039;+markersLocations[i][0]+&#039;&quot; target=&quot;_blank&quot; class=&quot;btn btn-info btn-sm btn-edit-info btn-block&quot; style=&quot;color: #fff;&quot;&gt;Google Maps&lt;/i&gt;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2977
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;lat_long_gpp_prop&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;lat_long_gpp_prop&quot; id=&quot;lat_long_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;lat_long_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lngp&quot; &gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;lat_long_gpp_prop&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;input-group&quot;&gt;
        &lt;input type=&quot;text&quot; name=&quot;lat_long_gpp_prop&quot; id=&quot;lat_long_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;lat_long_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lngp&quot; &gt;
        &lt;span class=&quot;input-group-btn&quot;&gt;
        &lt;button class=&quot;btn btn-primary&quot; type=&quot;button&quot; onclick=&quot;if($(&#039;#lat_long_gpp_prop&#039;).val() != &#039;&#039;){window.open(&#039;https://www.google.com/maps/search/?api=1&amp;query=&#039; + $(&#039;#lat_long_gpp_prop&#039;).val())}&quot;&gt;Google Maps&lt;/button&gt;
        &lt;/span&gt;
    &lt;/div&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;); ?&gt;
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminar inmuebles importados al realizar importaciones
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Inmovilla.php
/intramedianet/xml/importadores/Kyero.php
/intramedianet/xml/importadores/Resales.php
            </code>
        </pre>
        Añadir despues de <code>sendMappingData();</code>:
        <pre>
            <code class="php">
if ($totalRows_rsPropsDel &gt; 0) {

    do {

        mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsXMLfea = &quot;DELETE FROM properties_property_feature_priv WHERE property = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysql_query($query_rsXMLfea, $inmoconn) or die(mysql_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLfea);

        mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsXMLfea = &quot;DELETE FROM properties_360 WHERE property_360 = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysql_query($query_rsXMLfea, $inmoconn) or die(mysql_error());

        mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsXMLfea = &quot;DELETE FROM properties_videos WHERE property_vid = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysql_query($query_rsXMLfea, $inmoconn) or die(mysql_error());

        mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsXMLfea = &quot;DELETE FROM properties_log WHERE prop_id_log = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysql_query($query_rsXMLfea, $inmoconn) or die(mysql_error());

        mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsXMLfea = &quot;DELETE FROM properties_log_2 WHERE prop_id_log = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysql_query($query_rsXMLfea, $inmoconn) or die(mysql_error());

        // logprop(&#039;0&#039;, $row_rsPropsDel[&#039;id_prop&#039;], $row_rsPropsDel[&#039;referencia_prop&#039;], &#039;5&#039;);

        mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsXMLprop = &quot;DELETE FROM properties_properties WHERE id_prop = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLprop = mysql_query($query_rsXMLprop, $inmoconn) or die(mysql_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLprop);

        mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsXML = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXML = mysql_query($query_rsXML, $inmoconn) or die(mysql_error() . &#039;&lt;hr&gt;&#039; . $query_rsXML);
        $row_rsXML = mysql_fetch_assoc($rsXML);
        $totalRows_rsXML = mysql_num_rows($rsXML);

        do {

            array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/media/images/properties/thumbnails/&quot; . $row_rsXML[&#039;id_img&#039;] . &quot;_*&quot;));

            mysql_select_db($database_inmoconn, $inmoconn);
            $query_rsDelIMG = &quot;DELETE FROM properties_images WHERE id_img = &#039;&quot;.$row_rsXML[&#039;id_img&#039;].&quot;&#039;&quot;;
            $rsDelIMG = mysql_query($query_rsDelIMG, $inmoconn) or die(mysql_error() . &#039;&lt;hr&gt;&#039; . $query_rsDelIMG);

        } while ($row_rsXML = mysql_fetch_assoc($rsXML));

    } while ($row_rsPropsDel = mysql_fetch_assoc($rsPropsDel));

    array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/modules/_cache/*&quot;));

}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Solución de bugs
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/config.php:
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*******************************
**  Configuraci&#xf3;n del PDF  **
******************************/

$urlwebsite = &quot;www.website.immo&quot;; //para los pdf (as&#xed; evitamos que aparezca la url de test en el pdf)

//ajustar los colores usando los de la web (el secondary se usa especialmente para el texto del footer)
$maincolorPDF = &quot;#004484&quot;;
$secondarycolorPDF = &quot;#fff&quot;;


// Tel&#xe9;fonos:
// Se usar&#xe1; el $telefonoEmpresa para mostrar el tel&#xe9;fono en el PDF
// El tel&#xe9;fono que se usa para whatsapp es el $phoneRespBar. Tenerlo en cuenta.

//seleccionar entre LG y XL el que se ajuste seg&#xfa;n las proporciones de las fotos del dise&#xf1;o
$tamanyoImgPDF = &quot;xl&quot;;
//el logo que se va a usar en el header del pdf. Seg&#xfa;n el tama&#xf1;o del logotipo y la relaci&#xf3;n de aspecto que tenga tocar&#xe1; mover un poco a izquierda o derecha la cabecera
$pdfLogo = &apos;/media/images/website/website-logo.png&apos;;
            </code>
        </pre>
        <hr>
        Sustituir los archivos:
        <pre>
            <code class="php">
/modules/property/save_web.php
/modules/property/save-a3-mb.php
/modules/property/save-a3.php
/modules/property/save-mb.php
/modules/property/save.php
            </code>
        </pre>
        <hr>
        Sustituir los archivos:
        <pre>
            <code class="php">
/modules/property/view/pdf/pdf-A3-1-MB.html
/modules/property/view/pdf/pdf-A3-1.html
/modules/property/view/pdf/pdf-A4-1_web.html
/modules/property/view/pdf/pdf-A4-1-MB.html
/modules/property/view/pdf/pdf-A4-1.html
            </code>
        </pre>    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Solución de bugs
    </h6>
    <div class="card-body">
        Solución de bugs
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
