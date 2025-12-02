<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-07-2023</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Ocultados mapas en propiedades y zonas</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> En la ficha de propiedad se ha perdido la referencia al check de “vendido (Oculto en listados y exportadores)</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Envío de emails -> no filtra el buscador</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-plus-circle text-success"></i> Fallo en datepichers: en Chrome no muestra la fecha</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Ocultar atendido por de compradores a Agentes</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al responder consultas desde el crm</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo en datepicker calendario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2608
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;: &lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_prop&#039;]); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;

        &lt;div class=&quot;row&quot;&gt;

            &lt;div class=&quot;col-md-12&quot;&gt;
                &lt;label&gt;&amp;nbsp;&lt;/label&gt;
                &lt;div class=&quot;input-group&quot;&gt;
                    &lt;input type=&quot;text&quot; name=&quot;gmap_search&quot; id=&quot;gmap_search&quot; value=&quot;&quot; placeholder=&quot;&lt;?php __(&#039;Buscar la ubicaci&oacute;n en el mapa...&#039;); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; novalidate&gt;
                    &lt;button class=&quot;btn btn-primary&quot; type=&quot;button&quot; id=&quot;search_on_map&quot;&gt;&lt;i class=&quot;fa-regular fa-location-dot&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                &lt;/div&gt;
            &lt;/div&gt; &lt;!--/.col-md-12 --&gt;

        &lt;/div&gt; &lt;!--/.row --&gt;

        &lt;hr&gt;

        &lt;div class=&quot;row-fluid&quot;&gt;
            &lt;div class=&quot;span12&quot;&gt;
                &lt;div class=&quot;well well-sm&quot;&gt;
                    &lt;div id=&quot;g_map&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;

        &lt;hr&gt;

        &lt;div class=&quot;row&quot;&gt;

            &lt;div class=&quot;col-md-7&quot;&gt;

                &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;direccion_gp_prop&quot;&gt;&lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
                    &lt;div class=&quot;input-group&quot;&gt;
                        &lt;input type=&quot;text&quot; name=&quot;direccion_gp_prop&quot; id=&quot;direccion_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;direccion_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_address&quot;&gt;
                        &lt;button class=&quot;btn btn-primary btn-copy-address&quot; type=&quot;button&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                    &lt;/div&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

            &lt;div class=&quot;col-md-3&quot;&gt;

                &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;lat_long_gp_prop&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
                    &lt;div class=&quot;input-group&quot;&gt;
                        &lt;input type=&quot;text&quot; name=&quot;lat_long_gp_prop&quot; id=&quot;lat_long_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;lat_long_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lng&quot; &gt;
                        &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                    &lt;/div&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gp_prop&quot;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

            &lt;div class=&quot;col-md-2&quot;&gt;

                &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;zoom_gp_prop&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
                    &lt;input type=&quot;text&quot; name=&quot;zoom_gp_prop&quot; id=&quot;zoom_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;zoom_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gp_prop&quot;&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gp_prop&quot;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

        &lt;/div&gt; &lt;!--/.row --&gt;

    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;: &lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_prop&#039;]); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;

        &lt;div class=&quot;row&quot;&gt;

            &lt;div class=&quot;col-md-5&quot;&gt;

                &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;direccion_gp_prop&quot;&gt;&amp;nbsp;&lt;/label&gt;
                    &lt;a href=&quot;https://www.google.es/maps&quot; target=&quot;_blank&quot; class=&quot;btn btn-info w-100&quot;&gt;&lt;i class=&quot;fa-regular fa-map-location-dot&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ir a Google Maps&#039;); ?&gt;&lt;/a&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

            &lt;div class=&quot;col-md-4&quot;&gt;

                &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;lat_long_gp_prop&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
                    &lt;div class=&quot;input-group&quot;&gt;
                        &lt;input type=&quot;text&quot; name=&quot;lat_long_gp_prop&quot; id=&quot;lat_long_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;lat_long_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lng&quot; &gt;
                        &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                    &lt;/div&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gp_prop&quot;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

            &lt;div class=&quot;col-md-3&quot;&gt;

                &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;zoom_gp_prop&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
                    &lt;input type=&quot;text&quot; name=&quot;zoom_gp_prop&quot; id=&quot;zoom_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;zoom_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gp_prop&quot;&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gp_prop&quot;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

        &lt;/div&gt; &lt;!--/.row --&gt;

    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3480
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
<legend class="border-bottom mt-4"><?php __('Localización privada'); ?></legend>

&lt;div class=&quot;row&quot;&gt;

 &lt;div class=&quot;col-md-12&quot;&gt;
     &lt;label&gt;&amp;nbsp;&lt;/label&gt;
     &lt;div class=&quot;input-group&quot;&gt;
         &lt;input type=&quot;text&quot; name=&quot;gmap_searchp&quot; id=&quot;gmap_searchp&quot; value=&quot;&quot; placeholder=&quot;&lt;?php __(&#039;Buscar la ubicaci&oacute;n en el mapa...&#039;); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; novalidate&gt;
         &lt;button class=&quot;btn btn-primary&quot; type=&quot;button&quot; id=&quot;search_on_mapp&quot;&gt;&lt;i class=&quot;fa-regular fa-location-dot&quot;&gt;&lt;/i&gt;&lt;/button&gt;
     &lt;/div&gt;
 &lt;/div&gt; &lt;!--/.col-md-12 --&gt;

&lt;/div&gt; &lt;!--/.row --&gt;

&lt;hr&gt;

&lt;div class=&quot;row-fluid&quot;&gt;
 &lt;div class=&quot;span12&quot;&gt;
     &lt;div class=&quot;well well-sm&quot;&gt;
         &lt;div id=&quot;g_mapp&quot;&gt;
         &lt;/div&gt;
     &lt;/div&gt;
 &lt;/div&gt;
&lt;/div&gt;

&lt;hr&gt;

&lt;div class=&quot;row&quot;&gt;

 &lt;div class=&quot;col-md-7&quot;&gt;

     &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
         &lt;label for=&quot;direccion_gpp_prop&quot;&gt;&lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
         &lt;div class=&quot;input-group&quot;&gt;
             &lt;input type=&quot;text&quot; name=&quot;direccion_gpp_prop&quot; id=&quot;direccion_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;direccion_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_addressp&quot; &gt;
             &lt;button class=&quot;btn btn-primary btn-copy-address&quot; type=&quot;button&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
         &lt;/div&gt;
         &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gpp_prop&quot;); ?&gt;
     &lt;/div&gt;

 &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

 &lt;div class=&quot;col-md-3&quot;&gt;

     &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
         &lt;label for=&quot;lat_long_gpp_prop&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
         &lt;div class=&quot;input-group&quot;&gt;
             &lt;input type=&quot;text&quot; name=&quot;lat_long_gpp_prop&quot; id=&quot;lat_long_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;lat_long_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lngp&quot; &gt;
             &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gpp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
         &lt;/div&gt;
         &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;); ?&gt;
     &lt;/div&gt;

 &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

 &lt;div class=&quot;col-md-2&quot;&gt;

     &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
         &lt;label for=&quot;zoom_gpp_prop&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
         &lt;input type=&quot;text&quot; name=&quot;zoom_gpp_prop&quot; id=&quot;zoom_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;zoom_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gpp_prop&quot;&gt;
         &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gpp_prop&quot;); ?&gt;
     &lt;/div&gt;

 &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

&lt;/div&gt; &lt;!--/.row --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;legend class=&quot;border-bottom mt-4&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n privada&#039;); ?&gt;&lt;/legend&gt;

 &lt;div class=&quot;row&quot;&gt;

     &lt;div class=&quot;col-md-5&quot;&gt;

         &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;direccion_gp_prop&quot;&gt;&amp;nbsp;&lt;/label&gt;
            &lt;a href=&quot;https://www.google.es/maps&quot; target=&quot;_blank&quot; class=&quot;btn btn-info w-100&quot;&gt;&lt;i class=&quot;fa-regular fa-map-location-dot&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ir a Google Maps&#039;); ?&gt;&lt;/a&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;); ?&gt;
        &lt;/div&gt;

     &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

     &lt;div class=&quot;col-md-4&quot;&gt;

         &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
             &lt;label for=&quot;lat_long_gpp_prop&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
             &lt;div class=&quot;input-group&quot;&gt;
                 &lt;input type=&quot;text&quot; name=&quot;lat_long_gpp_prop&quot; id=&quot;lat_long_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;lat_long_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lngp&quot; &gt;
                 &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gpp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
             &lt;/div&gt;
             &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;); ?&gt;
         &lt;/div&gt;

     &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

     &lt;div class=&quot;col-md-3&quot;&gt;

         &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
             &lt;label for=&quot;zoom_gpp_prop&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
             &lt;input type=&quot;text&quot; name=&quot;zoom_gpp_prop&quot; id=&quot;zoom_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;zoom_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gpp_prop&quot;&gt;
             &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gpp_prop&quot;); ?&gt;
         &lt;/div&gt;

     &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

 &lt;/div&gt; &lt;!--/.row --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/zonas/news-form.php:984
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-lg-12&quot;&gt;

        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
                &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
                    &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Google Maps&#039;); ?&gt;&lt;/h4&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body&quot;&gt;

                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-12&quot;&gt;
                        &lt;label&gt;&amp;nbsp;&lt;/label&gt;
                        &lt;div class=&quot;input-group&quot;&gt;
                            &lt;input type=&quot;text&quot; name=&quot;gmap_search&quot; id=&quot;gmap_search&quot; value=&quot;&quot; placeholder=&quot;&lt;?php __(&#039;Buscar la ubicaci&oacute;n en el mapa...&#039;); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; novalidate&gt;
                            &lt;button class=&quot;btn btn-primary&quot; type=&quot;button&quot; id=&quot;search_on_map&quot;&gt;&lt;i class=&quot;fa-regular fa-location-dot&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                        &lt;/div&gt;
                    &lt;/div&gt; &lt;!--/.col-md-12 --&gt;

                &lt;/div&gt; &lt;!--/.row --&gt;

                &lt;hr&gt;

                &lt;div class=&quot;row-fluid&quot;&gt;
                    &lt;div class=&quot;span12&quot;&gt;
                        &lt;div class=&quot;well well-sm&quot;&gt;
                            &lt;div id=&quot;g_map&quot;&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;

                &lt;hr&gt;

                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-7&quot;&gt;

                        &lt;div class=&quot;mb-4 mb-md-0 &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;direccion_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;direccion_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
                            &lt;div class=&quot;input-group&quot;&gt;
                                &lt;input type=&quot;text&quot; name=&quot;direccion_gp_prop&quot; id=&quot;direccion_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;direccion_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_address&quot; readonly&gt;
                                &lt;button class=&quot;btn btn-primary btn-copy-address&quot; type=&quot;button&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                            &lt;/div&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;direccion_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

                    &lt;div class=&quot;col-md-3&quot;&gt;

                        &lt;div class=&quot;mb-4 mb-md-0 &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;lat_long_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;lat_long_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
                            &lt;div class=&quot;input-group&quot;&gt;
                                &lt;input type=&quot;text&quot; name=&quot;lat_long_gp_prop&quot; id=&quot;lat_long_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;lat_long_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lng&quot; readonly&gt;
                                &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                            &lt;/div&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;lat_long_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

                    &lt;div class=&quot;col-md-2&quot;&gt;

                        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;zoom_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;zoom_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;zoom_gp_prop&quot; id=&quot;zoom_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;zoom_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gp_prop&quot; readonly&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;zoom_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

                &lt;/div&gt; &lt;!--/.row --&gt;

            &lt;/div&gt;&lt;!-- end card-body --&gt;
        &lt;/div&gt;

    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-lg-12&quot;&gt;

        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
                &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
                    &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Google Maps&#039;); ?&gt;&lt;/h4&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body&quot;&gt;

                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-5&quot;&gt;

                        &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                              &lt;label class=&quot;form-label&quot;&gt;&amp;nbsp;&lt;/label&gt;
                              &lt;a href=&quot;https://www.google.es/maps&quot; target=&quot;_blank&quot; class=&quot;btn btn-info w-100&quot;&gt;&lt;i class=&quot;fa-regular fa-map-location-dot&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ir a Google Maps&#039;); ?&gt;&lt;/a&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

                    &lt;div class=&quot;col-md-4&quot;&gt;

                        &lt;div class=&quot;mb-4 mb-md-0 &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;lat_long_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;lat_long_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
                            &lt;div class=&quot;input-group&quot;&gt;
                                &lt;input type=&quot;text&quot; name=&quot;lat_long_gp_prop&quot; id=&quot;lat_long_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;lat_long_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lng&quot; readonly&gt;
                                &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                            &lt;/div&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;lat_long_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

                    &lt;div class=&quot;col-md-3&quot;&gt;

                        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;zoom_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;zoom_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;zoom_gp_prop&quot; id=&quot;zoom_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews[&#039;zoom_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gp_prop&quot; readonly&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;zoom_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

                &lt;/div&gt; &lt;!--/.row --&gt;

            &lt;/div&gt;&lt;!-- end card-body --&gt;
        &lt;/div&gt;

    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/zonas/categories-form.php:xxxxxxxxxxx
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-lg-12&quot;&gt;

        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
                &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
                    &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Google Maps&#039;); ?&gt;&lt;/h4&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body&quot;&gt;

                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-12&quot;&gt;
                        &lt;label&gt;&amp;nbsp;&lt;/label&gt;
                        &lt;div class=&quot;input-group&quot;&gt;
                            &lt;input type=&quot;text&quot; name=&quot;gmap_search&quot; id=&quot;gmap_search&quot; value=&quot;&quot; placeholder=&quot;&lt;?php __(&#039;Buscar la ubicaci&oacute;n en el mapa...&#039;); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; novalidate&gt;
                            &lt;button class=&quot;btn btn-primary&quot; type=&quot;button&quot; id=&quot;search_on_map&quot;&gt;&lt;i class=&quot;fa-regular fa-location-dot&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                        &lt;/div&gt;
                    &lt;/div&gt; &lt;!--/.col-md-12 --&gt;

                &lt;/div&gt; &lt;!--/.row --&gt;

                &lt;hr&gt;

                &lt;div class=&quot;row-fluid&quot;&gt;
                    &lt;div class=&quot;span12&quot;&gt;
                        &lt;div class=&quot;well well-sm&quot;&gt;
                            &lt;div id=&quot;g_map&quot;&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;

                &lt;hr&gt;

                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-7&quot;&gt;

                        &lt;div class=&quot;mb-4 mb-md-0 &lt;?php if($tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;direccion_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;direccion_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
                            &lt;div class=&quot;input-group&quot;&gt;
                                &lt;input type=&quot;text&quot; name=&quot;direccion_gp_prop&quot; id=&quot;direccion_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews_categories[&#039;direccion_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_address&quot; readonly&gt;
                                &lt;button class=&quot;btn btn-primary btn-copy-address&quot; type=&quot;button&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                            &lt;/div&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;direccion_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

                    &lt;div class=&quot;col-md-3&quot;&gt;

                        &lt;div class=&quot;mb-4 mb-md-0 &lt;?php if($tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;lat_long_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;lat_long_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
                            &lt;div class=&quot;input-group&quot;&gt;
                                &lt;input type=&quot;text&quot; name=&quot;lat_long_gp_prop&quot; id=&quot;lat_long_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews_categories[&#039;lat_long_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lng&quot; readonly&gt;
                                &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                            &lt;/div&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;lat_long_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

                    &lt;div class=&quot;col-md-2&quot;&gt;

                        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;zoom_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;zoom_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;zoom_gp_prop&quot; id=&quot;zoom_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews_categories[&#039;zoom_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gp_prop&quot; readonly&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;zoom_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

                &lt;/div&gt; &lt;!--/.row --&gt;

            &lt;/div&gt;&lt;!-- end card-body --&gt;
        &lt;/div&gt;

    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-lg-12&quot;&gt;

        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
                &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
                    &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Google Maps&#039;); ?&gt;&lt;/h4&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;card-body&quot;&gt;

                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-5&quot;&gt;

                      &lt;div class=&quot;pb-md-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                          &lt;label class=&quot;form-label&quot;&gt;&amp;nbsp;&lt;/label&gt;
                          &lt;a href=&quot;https://www.google.es/maps&quot; target=&quot;_blank&quot; class=&quot;btn btn-info w-100&quot;&gt;&lt;i class=&quot;fa-regular fa-map-location-dot&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ir a Google Maps&#039;); ?&gt;&lt;/a&gt;
                      &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

                    &lt;div class=&quot;col-md-4&quot;&gt;

                        &lt;div class=&quot;mb-4 mb-md-0 &lt;?php if($tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;lat_long_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;lat_long_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
                            &lt;div class=&quot;input-group&quot;&gt;
                                &lt;input type=&quot;text&quot; name=&quot;lat_long_gp_prop&quot; id=&quot;lat_long_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews_categories[&#039;lat_long_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lng&quot; readonly&gt;
                                &lt;button class=&quot;btn btn-primary btn-copy-latlong&quot; type=&quot;button&quot; onclick=&quot;copyToClipboard(&#039;#lat_long_gp_prop&#039;)&quot;&gt;&lt;i class=&quot;fa-regular fa-clipboard&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                            &lt;/div&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;lat_long_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

                    &lt;div class=&quot;col-md-3&quot;&gt;

                        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;zoom_gp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;zoom_gp_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;zoom_gp_prop&quot; id=&quot;zoom_gp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsnews_categories[&#039;zoom_gp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gp_prop&quot; readonly&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news_categories&quot;, &quot;zoom_gp_prop&quot;); ?&gt;
                        &lt;/div&gt;

                    &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

                &lt;/div&gt; &lt;!--/.row --&gt;

            &lt;/div&gt;&lt;!-- end card-body --&gt;
        &lt;/div&gt;

    &lt;/div&gt;
&lt;/div&gt;
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
$lang[&#039;Ir a Google Maps&#039;] = &#039;Ir a Google Maps&#039;;
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
$lang[&#039;Ir a Google Maps&#039;] = &#039;Go to Google Maps&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> En la ficha de propiedad se ha perdido la referencia al check de “vendido (Oculto en listados y exportadores)
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Users/jose/Webs/_Master/public_html/intramedianet/properties/properties-form.php:1591
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;label class=&quot;form-check-label&quot; for=&quot;force_hide_prop&quot;&gt;&lt;?php __(&#039;Ocultar (importada de XML&#039;); ?&gt;&lt;/label&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;label class=&quot;form-check-label&quot; for=&quot;force_hide_prop&quot;&gt;&lt;?php __(&#039;Ocultar (importada de XML)&#039;); ?&gt;&lt;/label&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php:674
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Ocultar (importada de XML)&#039;] = &#039;Ocultar (importada de XML)&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Ocultar (importada de XML)&#039;] = &#039;&lt;span class=&quot;text-danger&quot;&gt;Ocultar (importada de XML)&lt;/span&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php:671
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Ocultar (importada de XML)&#039;] = &#039;Hide (Imported from XML)&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Ocultar (importada de XML)&#039;] = &#039;&lt;span class=&quot;text-danger&quot;&gt;Hide (Imported from XML)&lt;/span&gt;&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Envío de emails, no filtra el buscador
    </h6>
    <div class="card-body">
        Sustituir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/emails.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Fallo en datepichers: en Chrome no muestra la fecha
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:477
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;input type=&quot;date&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php:634
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;input type=&quot;date&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/testimonials/news-form.php:439
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;input type=&quot;date&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/landing/news-form.php:386
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;input type=&quot;date&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews[&#039;date_nws&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
