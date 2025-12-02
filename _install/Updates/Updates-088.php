<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 16-03-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadido mapa al panel</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Añadidas nuevas respuestas al enviar emails desde formulario de clientes</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Añadido exportar a Facebook y MLS Mediaelx</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido mapa al panel
    </h6>
    <div class="card-body">

        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `direccion_gpp_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `zoom_gp_prop`;

ALTER TABLE `properties_properties` ADD COLUMN `lat_long_gpp_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `direccion_gpp_prop`;

ALTER TABLE `properties_properties` ADD COLUMN `zoom_gpp_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `lat_long_gpp_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:79
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/properties/properties.php?KT_back=1&quot; &lt;?php if(preg_match(&apos;/\/properties\/properties/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-building-o fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Inmuebles&apos;); ?&gt;
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/properties/properties.php?KT_back=1&quot; &lt;?php if(preg_match(&apos;/\/properties\/properties/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-building-o fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Inmuebles&apos;); ?&gt;
&lt;/a&gt;

&lt;a href=&quot;/intramedianet/map/properties.php?KT_back=1&quot; &lt;?php if(preg_match(&apos;/\/map\/properties/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-map fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Mapa&apos;); ?&gt;
&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-empleado.php:61
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/properties/properties.php?KT_back=1&quot; &lt;?php if(preg_match(&apos;/\/properties\/properties/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-building-o fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Inmuebles&apos;); ?&gt;
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/properties/properties.php?KT_back=1&quot; &lt;?php if(preg_match(&apos;/\/properties\/properties/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-building-o fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Inmuebles&apos;); ?&gt;
&lt;/a&gt;

&lt;a href=&quot;/intramedianet/map/properties.php?KT_back=1&quot; &lt;?php if(preg_match(&apos;/\/map\/properties/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-map fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Mapa&apos;); ?&gt;
&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-agente.php:10
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;withtext&quot;&gt;&lt;a href=&quot;/intramedianet/properties/properties.php?KT_back=1&quot; class=&quot;hidden-xs&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&apos;Inmuebles&apos;); ?&gt;&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt;&lt;span class=&quot;text-mt hidden-xs hidden-sm&quot;&gt;&lt;?php __(&apos;Inmuebles&apos;); ?&gt;&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;withtext&quot;&gt;&lt;a href=&quot;/intramedianet/properties/properties.php?KT_back=1&quot; class=&quot;hidden-xs&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&apos;Inmuebles&apos;); ?&gt;&quot;&gt;&lt;i class=&quot;fa fa-fw fa-building-o&quot;&gt;&lt;/i&gt;&lt;span class=&quot;text-mt hidden-xs hidden-sm&quot;&gt;&lt;?php __(&apos;Inmuebles&apos;); ?&gt;&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
&lt;li class=&quot;withtext&quot;&gt;&lt;a href=&quot;/intramedianet/map/properties.php?KT_back=1&quot; class=&quot;hidden-xs&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&apos;Mapa&apos;); ?&gt;&quot;&gt;&lt;i class=&quot;fa fa-fw fa-map&quot;&gt;&lt;/i&gt;&lt;span class=&quot;text-mt hidden-xs hidden-sm&quot;&gt;&lt;?php __(&apos;Mapa&apos;); ?&gt;&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:924
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;coeficiente_ocupacion_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;coeficiente_ocupacion_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;coeficiente_ocupacion_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;coeficiente_ocupacion_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;direccion_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;direccion_gpp_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;lat_long_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;lat_long_gpp_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;zoom_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gpp_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1144
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;coeficiente_ocupacion_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;coeficiente_ocupacion_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;coeficiente_ocupacion_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;coeficiente_ocupacion_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;direccion_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;direccion_gpp_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;lat_long_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;lat_long_gpp_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;zoom_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gpp_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1439
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#googlemaps&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#googlemaps&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;li&gt;&lt;a href=&quot;#googlemapspr&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n privada&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2855
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.googlemaps --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.googlemaps --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;googlemapspr&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;span class=&quot;ref_prop&quot;&gt;&lt;/span&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n privada&#039;); ?&gt;: &lt;?php __(&#039;Google Maps&#039;); ?&gt;&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;div id=&quot;msgSMp&quot;&gt;&lt;/div&gt;

            &lt;div class=&quot;row&quot;&gt;

                &lt;div class=&quot;col-md-8&quot;&gt;
                    &lt;label&gt;&amp;nbsp;&lt;/label&gt;
                    &lt;div class=&quot;input-group&quot;&gt;
                        &lt;input type=&quot;text&quot; name=&quot;gmap_searchp&quot; id=&quot;gmap_searchp&quot; value=&quot;&quot; placeholder=&quot;&lt;?php __(&#039;Buscar la ubicaci&oacute;n en el mapa...&#039;); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; novalidate&gt;
                        &lt;div class=&quot;input-group-btn&quot;&gt;
                            &lt;button class=&quot;btn btn-primay&quot; type=&quot;button&quot; id=&quot;search_on_mapp&quot;&gt;&lt;i class=&quot;fa fa-map-marker&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt; &lt;!--/.col-md-8 --&gt;

                &lt;div class=&quot;col-md-4&quot;&gt;
                    &lt;label&gt;&amp;nbsp;&lt;/label&gt;
                    &lt;div class=&quot;input-group&quot;&gt;
                        &lt;a href=&quot;#&quot; id=&quot;copyp&quot; class=&quot;btn btn-primary btn-block&quot;&gt;&lt;?php __(&#039;Copiar&#039;); ?&gt; &lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;&lt;/a&gt;
                    &lt;/div&gt;
                &lt;/div&gt; &lt;!--/.col-md-4 --&gt;

            &lt;/div&gt; &lt;!--/.row --&gt;

            &lt;hr&gt;

            &lt;div class=&quot;row-fluid&quot;&gt;
                &lt;div class=&quot;span12&quot;&gt;
                    &lt;div class=&quot;well well-sm&quot;&gt;
                        &lt;div id=&quot;g_mapp&quot; style=&quot;height: 500px;&quot;&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;

            &lt;hr&gt;
            &lt;fieldset class=&quot;disabled&quot;&gt;

            &lt;div class=&quot;row&quot;&gt;

                &lt;div class=&quot;col-md-7&quot;&gt;

                    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                        &lt;label for=&quot;direccion_gpp_prop&quot;&gt;&lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;direccion_gpp_prop&quot; id=&quot;direccion_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;direccion_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_addressp&quot; &gt;
                        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_gpp_prop&quot;); ?&gt;
                    &lt;/div&gt;

                &lt;/div&gt; &lt;!--/.col-md-7 --&gt;

                &lt;div class=&quot;col-md-3&quot;&gt;

                    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                        &lt;label for=&quot;lat_long_gpp_prop&quot;&gt;&lt;?php __(&#039;Latitud y longitud&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;lat_long_gpp_prop&quot; id=&quot;lat_long_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;lat_long_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control comp_lat_lngp&quot; &gt;
                        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;lat_long_gpp_prop&quot;); ?&gt;
                    &lt;/div&gt;

                &lt;/div&gt; &lt;!--/.col-md-3 --&gt;

                &lt;div class=&quot;col-md-2&quot;&gt;

                    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gpp_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                        &lt;label for=&quot;zoom_gpp_prop&quot;&gt;&lt;?php __(&#039;Zoom&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;zoom_gpp_prop&quot; id=&quot;zoom_gpp_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;zoom_gpp_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control zoom_gpp_prop&quot; &gt;
                        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;zoom_gpp_prop&quot;); ?&gt;
                    &lt;/div&gt;

                &lt;/div&gt; &lt;!--/.col-md-2 --&gt;

            &lt;/div&gt; &lt;!--/.row --&gt;

            &lt;/fieldset&gt;

        &lt;/div&gt; &lt;!--/.panel-body --&gt;

    &lt;/div&gt; &lt;!--/.panel --&gt;

&lt;/div&gt; &lt;!--/.googlemapspr --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Añadir al final del archivo, antes del &lt;/body&gt;:
        <pre>
            <code class="php">
&lt;style&gt;
  .g_map iframe img,
  .g_mapp iframe img {
    max-width: auto;
  }
&lt;/style&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js:323
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;a[data-toggle=&quot;tab&quot;]&#039;).on(&#039;shown.bs.tab&#039;, function (e) {
m = g_Map.gmap3(&#039;get&#039;);
x = m.getZoom();
  c = m.getCenter();
google.maps.event.trigger(m, &#039;resize&#039;);
 m.setZoom(x);
  m.setCenter(c);
$(&#039;#calendar&#039;).fullCalendar(&#039;render&#039;);

uploader.splice();


});

g_Map = $(&#039;#g_map&#039;);

if($(&#039;.comp_lat_lng&#039;).val()  == &#039;&#039;) {
  g_Map.gmap3({
    action: &#039;init&#039;,
    options:{
      center  : [40.463667, -3.749220],
      zoom    : 6
    },
    events: {
      zoom_changed: function(marker){
        $(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom());
      }
    },
    callback: function(){
      $(&#039;#search_on_map&#039;).click(function(){
        $(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom());
        // $(&#039;#gmap_search&#039;).val(&#039;&#039;);
         drop_marker_search();
         return false;
      })
    }
  });
} else {
  var latLng_array = $(&#039;.comp_lat_lng&#039;).val().split(&#039;,&#039;);
  var zoomVal = ($(&#039;.zoom_gp_prop&#039;).val() == &#039;&#039;)?16:$(&#039;.zoom_gp_prop&#039;).val()*1;
  g_Map.gmap3({
    action: &#039;init&#039;,
        options:{
          center  : latLng_array,
          zoom    : zoomVal
        },
        events: {
          zoom_changed: function(marker){
            $(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom()).focus();
          }
        }
    },
    {
      action: &#039;clear&#039;,
      name:&#039;marker&#039;
    },
    {
      action: &#039;addMarker&#039;,
      latLng: latLng_array,
      marker: {
        events: {
        dragend: function(marker){
          marker_callback(marker);
          g_Map.gmap3(&#039;get&#039;).panTo(marker.position);
        }
      },
      options: { draggable: true },
      callback: function(){
        $(&#039;#search_on_map&#039;).click(function(){
          drop_marker_search();
          return false;
          });
        }
      }
    }
  );
}

function marker_callback(marker) {
$(&#039;.comp_lat_lng&#039;).val(marker.position.lat().toFixed(6)+&#039;, &#039;+marker.position.lng().toFixed(6));

$(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom());
g_Map.gmap3({
    action: &#039;getAddress&#039;,
    latLng: marker.getPosition(),
    callback: function(results){
        $(&#039;.comp_address&#039;).val(results[0].formatted_address);
    }
});

};

function drop_marker_search() {
var search_query = $(&#039;#gmap_search&#039;).val();
if(search_query != &#039;&#039;){
  g_Map.gmap3(
    {
      action: &#039;clear&#039;,
      name: &#039;marker&#039;
    },
    {   action: &#039;addMarker&#039;,
      address: search_query,
      map: {
        center:true,
        zoom: 15
      },
      marker: {
        events: {
          dragend: function(marker){
            marker_callback(marker);
            g_Map.gmap3(&#039;get&#039;).panTo(marker.position);
          }
        },
        callback: function(marker){
          if(marker){
            $(&#039;#msgSM&#039;).html(&#039;&lt;div class=&quot;alert alert-info&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmArras + &#039;&lt;/div&gt;&#039;);
            marker_callback(marker);
          } else {
            $(&#039;#msgSM&#039;).html(&#039;&lt;div class=&quot;alert alert-warning&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmNoFound + &#039;&lt;/div&gt;&#039;);

          }
        },
        options: { draggable: true }
      }
    }
  )
} else {
  $(&#039;#msgSM&#039;).html(&#039;&lt;div class=&quot;alert alert-danger&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmIntrud + &#039;&lt;/div&gt;&#039;);
}
}

ZeroClipboard.config( { swfPath: &quot;/intramedianet/includes/assets/swf/ZeroClipboard.swf&quot; } );
var clip = new ZeroClipboard( $(&quot;a#copy&quot;) );
clip.on( &#039;ready&#039;, function(event) {
clip.on( &#039;copy&#039;, function(event) {
    event.clipboardData.setData(&#039;text/plain&#039;, $(&#039;#lat_long_gp_prop&#039;).val());
});
clip.on( &#039;aftercopy&#039;, function(event) {
    alert(textCopy + &quot;: &quot; + event.data[&#039;text/plain&#039;] );
});
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;a[data-toggle=&quot;tab&quot;]&#039;).on(&#039;shown.bs.tab&#039;, function (e) {
m = g_Map.gmap3(&#039;get&#039;);
x = m.getZoom();
  c = m.getCenter();
google.maps.event.trigger(m, &#039;resize&#039;);
 m.setZoom(x);
  m.setCenter(c);

  mp = g_Mapp.gmap3(&#039;get&#039;);
  xp = mp.getZoom();
    cp = mp.getCenter();
  google.maps.event.trigger(mp, &#039;resize&#039;);
   mp.setZoom(xp);
    mp.setCenter(cp);
$(&#039;#calendar&#039;).fullCalendar(&#039;render&#039;);

uploader.splice();


});

g_Map = $(&#039;#g_map&#039;);

if($(&#039;.comp_lat_lng&#039;).val()  == &#039;&#039;) {
  g_Map.gmap3({
    action: &#039;init&#039;,
    options:{
      center  : [40.463667, -3.749220],
      zoom    : 6
    },
    events: {
      zoom_changed: function(marker){
        $(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom());
      }
    },
    callback: function(){
      $(&#039;#search_on_map&#039;).click(function(){
        $(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom());
        // $(&#039;#gmap_search&#039;).val(&#039;&#039;);
         drop_marker_search();
         return false;
      })
    }
  });
} else {
  var latLng_array = $(&#039;.comp_lat_lng&#039;).val().split(&#039;,&#039;);
  var zoomVal = ($(&#039;.zoom_gp_prop&#039;).val() == &#039;&#039;)?16:$(&#039;.zoom_gp_prop&#039;).val()*1;
  g_Map.gmap3({
    action: &#039;init&#039;,
        options:{
          center  : latLng_array,
          zoom    : zoomVal
        },
        events: {
          zoom_changed: function(marker){
            $(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom()).focus();
          }
        }
    },
    {
      action: &#039;clear&#039;,
      name:&#039;marker&#039;
    },
    {
      action: &#039;addMarker&#039;,
      latLng: latLng_array,
      marker: {
        events: {
        dragend: function(marker){
          marker_callback(marker);
          g_Map.gmap3(&#039;get&#039;).panTo(marker.position);
        }
      },
      options: { draggable: true },
      callback: function(){
        $(&#039;#search_on_map&#039;).click(function(){
          drop_marker_search();
          return false;
          });
        }
      }
    }
  );
}

function marker_callback(marker) {
$(&#039;.comp_lat_lng&#039;).val(marker.position.lat().toFixed(6)+&#039;, &#039;+marker.position.lng().toFixed(6));

$(&#039;.zoom_gp_prop&#039;).val(g_Map.gmap3(&#039;get&#039;).getZoom());
g_Map.gmap3({
    action: &#039;getAddress&#039;,
    latLng: marker.getPosition(),
    callback: function(results){
        $(&#039;.comp_address&#039;).val(results[0].formatted_address);
    }
});

};

function drop_marker_search() {
var search_query = $(&#039;#gmap_search&#039;).val();
if(search_query != &#039;&#039;){
  g_Map.gmap3(
    {
      action: &#039;clear&#039;,
      name: &#039;marker&#039;
    },
    {   action: &#039;addMarker&#039;,
      address: search_query,
      map: {
        center:true,
        zoom: 15
      },
      marker: {
        events: {
          dragend: function(marker){
            marker_callback(marker);
            g_Map.gmap3(&#039;get&#039;).panTo(marker.position);
          }
        },
        callback: function(marker){
          if(marker){
            $(&#039;#msgSM&#039;).html(&#039;&lt;div class=&quot;alert alert-info&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmArras + &#039;&lt;/div&gt;&#039;);
            marker_callback(marker);
          } else {
            $(&#039;#msgSM&#039;).html(&#039;&lt;div class=&quot;alert alert-warning&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmNoFound + &#039;&lt;/div&gt;&#039;);

          }
        },
        options: { draggable: true }
      }
    }
  )
} else {
  $(&#039;#msgSM&#039;).html(&#039;&lt;div class=&quot;alert alert-danger&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmIntrud + &#039;&lt;/div&gt;&#039;);
}
}

ZeroClipboard.config( { swfPath: &quot;/intramedianet/includes/assets/swf/ZeroClipboard.swf&quot; } );
var clip = new ZeroClipboard( $(&quot;a#copy&quot;) );
clip.on( &#039;ready&#039;, function(event) {
clip.on( &#039;copy&#039;, function(event) {
    event.clipboardData.setData(&#039;text/plain&#039;, $(&#039;#lat_long_gp_prop&#039;).val());
});
clip.on( &#039;aftercopy&#039;, function(event) {
    alert(textCopy + &quot;: &quot; + event.data[&#039;text/plain&#039;] );
});
});

g_Mapp = $(&#039;#g_mapp&#039;);

if($(&#039;.comp_lat_lngp&#039;).val()  == &#039;&#039;) {
  g_Mapp.gmap3({
    action: &#039;init&#039;,
    options:{
      center  : [40.463667, -3.749220],
      zoom    : 6
    },
    events: {
      zoom_changed: function(marker){
        $(&#039;.zoom_gpp_prop&#039;).val(g_Mapp.gmap3(&#039;get&#039;).getZoom());
      }
    },
    callback: function(){
      $(&#039;#search_on_mapp&#039;).click(function(){
        $(&#039;.zoom_gpp_prop&#039;).val(g_Mapp.gmap3(&#039;get&#039;).getZoom());
        // $(&#039;#gmap_searchp&#039;).val(&#039;&#039;);
         drop_marker_searchp();
         return false;
      })
    }
  });
} else {
  var latLng_array = $(&#039;.comp_lat_lngp&#039;).val().split(&#039;,&#039;);
  var zoomVal = ($(&#039;.zoom_gpp_prop&#039;).val() == &#039;&#039;)?16:$(&#039;.zoom_gpp_prop&#039;).val()*1;
  g_Mapp.gmap3({
    action: &#039;init&#039;,
        options:{
          center  : latLng_array,
          zoom    : zoomVal
        },
        events: {
          zoom_changed: function(marker){
            $(&#039;.zoom_gpp_prop&#039;).val(g_Mapp.gmap3(&#039;get&#039;).getZoom()).focus();
          }
        }
    },
    {
      action: &#039;clear&#039;,
      name:&#039;marker&#039;
    },
    {
      action: &#039;addMarker&#039;,
      latLng: latLng_array,
      marker: {
        events: {
        dragend: function(marker){
          marker_callbackp(marker);
          g_Mapp.gmap3(&#039;get&#039;).panTo(marker.position);
        }
      },
      options: { draggable: true },
      callback: function(){
        $(&#039;#search_on_mapp&#039;).click(function(){
          drop_marker_searchp();
          return false;
          });
        }
      }
    }
  );
}

function marker_callbackp(marker) {
$(&#039;.comp_lat_lngp&#039;).val(marker.position.lat().toFixed(6)+&#039;, &#039;+marker.position.lng().toFixed(6));

$(&#039;.zoom_gpp_prop&#039;).val(g_Mapp.gmap3(&#039;get&#039;).getZoom());
g_Mapp.gmap3({
    action: &#039;getAddress&#039;,
    latLng: marker.getPosition(),
    callback: function(results){
        $(&#039;.comp_addressp&#039;).val(results[0].formatted_address);
    }
});

};

function drop_marker_searchp() {
var search_query = $(&#039;#gmap_searchp&#039;).val();
if(search_query != &#039;&#039;){
  g_Mapp.gmap3(
    {
      action: &#039;clear&#039;,
      name: &#039;marker&#039;
    },
    {   action: &#039;addMarker&#039;,
      address: search_query,
      map: {
        center:true,
        zoom: 15
      },
      marker: {
        events: {
          dragend: function(marker){
            marker_callbackp(marker);
            g_Mapp.gmap3(&#039;get&#039;).panTo(marker.position);
          }
        },
        callback: function(marker){
          if(marker){
            $(&#039;#msgSMp&#039;).html(&#039;&lt;div class=&quot;alert alert-info&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmArras + &#039;&lt;/div&gt;&#039;);
            marker_callbackp(marker);
          } else {
            $(&#039;#msgSMp&#039;).html(&#039;&lt;div class=&quot;alert alert-warning&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmNoFound + &#039;&lt;/div&gt;&#039;);

          }
        },
        options: { draggable: true }
      }
    }
  )
} else {
  $(&#039;#msgSMp&#039;).html(&#039;&lt;div class=&quot;alert alert-danger&quot;&gt;&lt;a class=&quot;close&quot; data-dismiss=&quot;alert&quot; href=&quot;#&quot;&gt;&amp;times;&lt;/a&gt; &#039; + gmIntrud + &#039;&lt;/div&gt;&#039;);
}
}

ZeroClipboard.config( { swfPath: &quot;/intramedianet/includes/assets/swf/ZeroClipboard.swf&quot; } );
var clip = new ZeroClipboard( $(&quot;a#copyp&quot;) );
clip.on( &#039;ready&#039;, function(event) {
clip.on( &#039;copy&#039;, function(event) {
    event.clipboardData.setData(&#039;text/plain&#039;, $(&#039;#lat_long_gpp_prop&#039;).val());
});
clip.on( &#039;aftercopy&#039;, function(event) {
    alert(textCopy + &quot;: &quot; + event.data[&#039;text/plain&#039;] );
});
});
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
$lang[&apos;Mapa&apos;] = &apos;Mapa&apos;;
$lang[&#039;Localizaci&oacute;n privada&#039;] = &#039;Localizaci&oacute;n privada&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_em.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&apos;Mapa&apos;] = &apos;Map&apos;;
$lang[&#039;Localizaci&oacute;n privada&#039;] = &#039;Private location&#039;;
            </code>
        </pre>
        <hr>
        Añadir la carpeta:
        <pre>
            <code class="makefile">
/intramedianet/map/
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadidas nuevas respuestas al enviar emails desde formulario de clientes
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:247
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;option value=&quot;intr&quot;&gt;&lt;?php __(&#039;Respuesta&#039;); ?&gt;&lt;/option&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;option value=&quot;1&quot;&gt;&lt;?php __(&#039;Respuesta Inicial sin tel&eacute;fono&#039;); ?&gt;&lt;/option&gt;
&lt;option value=&quot;2&quot;&gt;&lt;?php __(&#039;Respuesta Inicial con tel&eacute;fono&#039;); ?&gt;&lt;/option&gt;
&lt;option value=&quot;3&quot;&gt;&lt;?php __(&#039;Respuesta Seguimiento&#039;); ?&gt;&lt;/option&gt;
&lt;option value=&quot;4&quot;&gt;&lt;?php __(&#039;Confirmaci&oacute;n visita&#039;); ?&gt;&lt;/option&gt;
&lt;option value=&quot;5&quot;&gt;&lt;?php __(&#039;Confirmaci&oacute;n de listado&#039;); ?&gt;&lt;/option&gt;
&lt;option value=&quot;6&quot;&gt;&lt;?php __(&#039;Seguimiento tras visita&#039;); ?&gt;&lt;/option&gt;
&lt;option value=&quot;7&quot;&gt;&lt;?php __(&#039;No responde&#039;); ?&gt;&lt;/option&gt;
&lt;option value=&quot;8&quot;&gt;&lt;?php __(&#039;No responde 2&#039;); ?&gt;&lt;/option&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2488
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var intr_sub = new Array ();
intr_sub[&#039;da&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de&#039;] = &quot;Espanjan asunto&quot;;
intr_sub[&#039;en&#039;] = &quot;Property in Spain&quot;;
intr_sub[&#039;es&#039;] = &quot;Propiedad en Espa&ntilde;a&quot;;
intr_sub[&#039;fi&#039;] = &quot;Kiinteist&ouml; Espanjassa&quot;;
intr_sub[&#039;fr&#039;] = &quot;Propri&eacute;t&eacute; en Espagne&quot;;
intr_sub[&#039;is&#039;] = &quot;Eign &aacute; Sp&aacute;ni&quot;;
intr_sub[&#039;nl&#039;] = &quot;Onroerend goed in Spanje&quot;;
intr_sub[&#039;no&#039;] = &quot;Bolig i Spania&quot;;
intr_sub[&#039;ru&#039;] = &quot;&#x41d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c; &#x432; &#x418;&#x441;&#x43f;&#x430;&#x43d;&#x438;&#x438;&quot;;
intr_sub[&#039;se&#039;] = &quot;Bostad i Spanien&quot;;
intr_sub[&#039;zh&#039;] = &quot;&#x897f;&#x73ed;&#x7259;&#x623f;&#x4ea7;&quot;;

var intr_txt = new Array ();
intr_txt[&#039;da&#039;] = &quot;Tak for din interesse i vores ejendom. For mere information og billeder, skal du klikke p&aring; billedet.\n{{PROPERTY}} \nHvis du vil blive kontaktet af en af vores undervisningskoder, skal du lade dit telefonnummer ligge og et tidspunkt, hvor det passer dig at modtage et telefonopkald .\nMed venlig hilsen.&quot;;
intr_txt[&#039;de&#039;] = &quot;Vielen Dank f&uuml;r Ihr Interesse an unserer Immobilie. F&uuml;r weitere Informationen und Bilder klicken Sie bitte auf das Foto.\n{{PROPERTY}}\nWenn Sie von einem unserer Werbespots kontaktiert werden m&ouml;chten, hinterlassen Sie bitte Ihre Telefonnummer und einen Zeitpunkt, zu dem Sie einen Anruf erhalten m&ouml;chten.\nFreundliche Gr&uuml;&szlig;e.&quot;;
intr_txt[&#039;en&#039;] = &quot;Thank you for your interest in our property. For more information and images, please click on the photo.\n{{PROPERTY}}\nIf you want to be contacted by one of our comercials, please leave your phone number, and a time when it suits you to recive a phone call.\nBest regards.&quot;;
intr_txt[&#039;es&#039;] = &quot;Gracias por su inter&eacute;s en nuestra propiedad. Haz click en la foto para m&aacute;s informaci&oacute;n e im&aacute;genes.\n{{PROPERTY}}\nSi quiere que uno de nuestros comerciales se ponga en contacto con Usted, por favor deje su n&uacute;mero de tel&eacute;fono y una hora cuando le va bien recibir una llamada.\nUn saludo cordial.&quot;;
intr_txt[&#039;fi&#039;] = &quot;Kiitos kiinnostuksestasi meid&auml;n Espanjan asuntoon, Klikkaa kuvaa niin saat lis&auml;tietoa, sek&auml; lis&auml;&auml; kuvia.\n{{PROPERTY}}\nJas haluatte ett&auml; otamme teihin yhteytt&auml;, niin yst&auml;v&auml;llisesti l&auml;hett&auml;k&auml;&auml; puhelinnumeronne sek&auml; ajan milloin teille sopii vastaanottaa puhelu.\nYst&auml;v&auml;llisin terveisin&quot;;
intr_txt[&#039;fr&#039;] = &quot;Merci de votre int&eacute;r&ecirc;t pour notre propri&eacute;t&eacute;. Pour plus d&#039;informations et d&#039;images, veuillez cliquer sur la photo.\n{{PROPERTY}}\nSi vous souhaitez &ecirc;tre contact&eacute; par l&#039;une de nos publicit&eacute;s, veuillez laisser votre num&eacute;ro de t&eacute;l&eacute;phone et l&#039;heure &agrave; laquelle vous souhaitez recevoir un appel.\nMeilleures salutations&quot;;
intr_txt[&#039;is&#039;] = &quot;&THORN;akka &thorn;&eacute;r fyrir &aacute;huga &thorn;inn &aacute; eignum okkar. Til a&eth; f&aacute; frekari uppl&yacute;singar og myndir, vinsamlegast smelltu &aacute; myndina.\n{{PROPERTY}}\nEf &thorn;&uacute; vilt hafa samband vi&eth; einn af &thorn;vingunara&eth;ger&eth;um okkar, vinsamlegast l&aacute;ttu s&iacute;man&uacute;meri&eth; &thorn;itt og &thorn;egar &thorn;a&eth; hentar &thorn;&eacute;r a&eth; f&aacute; s&iacute;mtal.\nBestu kve&eth;jur.&quot;;
intr_txt[&#039;nl&#039;] = &quot;Bedankt voor uw interesse in ons eigendom. Klik op de foto voor meer informatie en afbeeldingen.\n{{PROPERTY}}\nAls u gecontacteerd wilt worden door een van onze reclames, laat dan uw telefoonnummer achter en een tijdstip waarop het u uitkomt om een &#x200b;&#x200b;telefoontje te ontvangen.\nVriendelijke groeten.&quot;;
intr_txt[&#039;no&#039;] = &quot;Takk for interessen i v&aring;rt hjem. For mer informasjon og bilder, Klikka bildet nedenfor.\n{{PROPERTY}}\nHvis du &oslash;nsker en av v&aring;re meglere til &aring; kontakte deg, kan du legge igjen et telefonnummer og en tid det passer deg &aring; motta en samtale.\nMed vennlig hilsen&quot;;
intr_txt[&#039;ru&#039;] = &quot;&#x421;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448; &#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441; &#x43a; &#x43d;&#x430;&#x448;&#x435;&#x439; &#x441;&#x43e;&#x431;&#x441;&#x442;&#x432;&#x435;&#x43d;&#x43d;&#x43e;&#x441;&#x442;&#x438;. &#x414;&#x43b;&#x44f; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x435;&#x43d;&#x438;&#x44f; &#x434;&#x43e;&#x43f;&#x43e;&#x43b;&#x43d;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x43e;&#x439; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x438; &#x438; &#x438;&#x437;&#x43e;&#x431;&#x440;&#x430;&#x436;&#x435;&#x43d;&#x438;&#x439;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x43d;&#x430;&#x436;&#x43c;&#x438;&#x442;&#x435; &#x43d;&#x430; &#x444;&#x43e;&#x442;&#x43e;.\n{{PROPERTY}}\n&#x415;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x445;&#x43e;&#x442;&#x438;&#x442;&#x435;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x43b;&#x441;&#x44f; &#x43e;&#x434;&#x438;&#x43d; &#x438;&#x437; &#x43d;&#x430;&#x448;&#x438;&#x445; &#x440;&#x435;&#x43a;&#x43b;&#x430;&#x43c;&#x43d;&#x44b;&#x445; &#x440;&#x43e;&#x43b;&#x438;&#x43a;&#x43e;&#x432;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x43e;&#x441;&#x442;&#x430;&#x432;&#x44c;&#x442;&#x435; &#x441;&#x432;&#x43e;&#x439; &#x43d;&#x43e;&#x43c;&#x435;&#x440; &#x442;&#x435;&#x43b;&#x435;&#x444;&#x43e;&#x43d;&#x430; &#x438; &#x432;&#x440;&#x435;&#x43c;&#x44f;, &#x43a;&#x43e;&#x433;&#x434;&#x430; &#x432;&#x430;&#x43c; &#x43f;&#x43e;&#x434;&#x445;&#x43e;&#x434;&#x438;&#x442; &#x437;&#x432;&#x43e;&#x43d;&#x43e;&#x43a;.\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438;&quot;;
intr_txt[&#039;se&#039;] = &quot;Tack f&ouml;r ert intresse i v&aring;r bostad. F&ouml;r mer information och bilder, klikka p&aring; bilden nedan.\n{{PROPERTY}}\nOm ni vill att en av v&aring;ra m&auml;klare kontaktar er, s&aring; v&auml;nligen l&auml;mna ett telefonnummer, samt en tid det passar er att motta ett samtal.\nMed v&auml;nlig h&auml;lsning.&quot;;
intr_txt[&#039;zh&#039;] = &quot;&#x611f;&#x8c22;&#x60a8;&#x5bf9;&#x6211;&#x4eec;&#x9152;&#x5e97;&#x7684;&#x5173;&#x6ce8;&#x3002; &#x6b32;&#x4e86;&#x89e3;&#x66f4;&#x591a;&#x4fe1;&#x606f;&#x548c;&#x56fe;&#x7247;&#xff0c;&#x8bf7;&#x70b9;&#x51fb;&#x7167;&#x7247;\n{{PROPERTY}}\n&#x5982;&#x679c;&#x60a8;&#x5e0c;&#x671b;&#x6211;&#x4eec;&#x7684;&#x67d0;&#x5546;&#x4e1a;&#x8054;&#x7cfb;&#x4eba;&#x8054;&#x7cfb;&#x60a8;&#xff0c;&#x8bf7;&#x7559;&#x4e0b;&#x60a8;&#x7684;&#x7535;&#x8bdd;&#x53f7;&#x7801;&#x4ee5;&#x53ca;&#x9002;&#x5408;&#x60a8;&#x63a5;&#x542c;&#x7535;&#x8bdd;&#x7684;&#x65f6;&#x95f4;\n&#x6700;&#x597d;&#x7684;&#x95ee;&#x5019;&#x3002;&quot;;




$(&#039;.btn-txt&#039;).click(function(e) {
    e.preventDefault();
    if ($(&#039;#txt&#039;).val() == &#039;&#039;) {
        alert(&#039;Seleccione un texto&#039;);
        $(&#039;#txt&#039;).focus();
        return false;
    }
    if ($(&#039;#ref&#039;).val() == &#039;&#039;) {
        alert(&#039;Seleccione una referencia&#039;);
        $(&#039;#ref&#039;).focus();
        return false;
    }
    $(&#039;#subjectSM&#039;).val(intr_sub[$(&#039;#idioma_cli&#039;).val()]);
    var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()];
    $(&#039;#messagemail&#039;).val(txt.replace(&#039;{{PROPERTY}}&#039;, &#039;{{PROPERTY-&#039; + $(&#039;#ref&#039;).val() + &#039;}}&#039;));
    return false;
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var intr_sub = new Array();
var intr_txt = new Array();


//intr_sub[&#039;da1&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de1&#039;] = &quot;Erste Reaktion ohne Telefon&quot;;
intr_sub[&#039;en1&#039;] = &quot;Initial response without telephone&quot;;
intr_sub[&#039;es1&#039;] = &quot;Respuesta Inicial sin tel&eacute;fono&quot;;
//intr_sub[&#039;fi1&#039;] = &quot;&quot;;
intr_sub[&#039;fr1&#039;] = &quot;R&eacute;ponse initiale sans t&eacute;l&eacute;phone&quot;;
//intr_sub[&#039;is1&#039;] = &quot;&quot;;
intr_sub[&#039;nl1&#039;] = &quot;Eerste reactie zonder telefoon&quot;;
intr_sub[&#039;no1&#039;] = &quot;Innledende svar uten telefon&quot;;
// intr_sub[&#039;ru1&#039;] = &quot;&quot;;
intr_sub[&#039;se1&#039;] = &quot;F&ouml;rsta svar utan telefon&quot;;
intr_sub[&#039;pl1&#039;] = &quot;Wst&#x119;pna reakcja bez telefonu&quot;;

// intr_txt[&#039;da1&#039;] = &quot;&quot;;
intr_txt[&#039;de1&#039;] = &quot;Vielen Dank, dass Sie unser Immobilienb&uuml;ro kontaktiert haben.\nHier finden Sie die von Ihnen gew&uuml;nschten Informationen zu folgender Immobilie.\nF&uuml;r weitere Informationen und &auml;hnliche H&auml;user k&ouml;nnen Sie hier klicken:\n\n{{PROPERTY}}\n\nWenn Sie m&ouml;chten, dass sich einer unserer Berater mit Ihnen in Verbindung setzt, antworten Sie bitte auf diese E-Mail und geben Sie eine Telefonnummer und einenZeitpunkt an, zu dem Sie einen Anruf oder eine Whatsapp-Nachricht erhalten m&ouml;chten.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en1&#039;] = &quot;Thank you for contacting our real estate agency.\nHere you have the information you have requested about the following property.\nYou can click for more information and similar houses:\n\n{{PROPERTY}}\n\nIf you would like one of our advisors to contact you, please reply to this email, indicating a telephone number and a time when it would be convenient for you toreceive a call or whatsapp.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es1&#039;] = &quot;Gracias por contactar con nuestra inmobiliaria.\nAqu&iacute; tienes la informaci&oacute;n que nos has solicitado sobre la siguiente propiedad.\nPuedes hacer clic para m&aacute;s informaci&oacute;n y casas similares:\n\n{{PROPERTY}}\n\nSi quiere que uno de nuestros asesores se ponga en contacto contigo, por favor responde a este mail, indicando un n&uacute;mero de tel&eacute;fono y una hora a la que te viene bienrecibir una llamada o whatsapp.\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi1&#039;] = &quot;&quot;;
intr_txt[&#039;fr1&#039;] = &quot;Merci d&#039;avoir contact&eacute; notre agence immobili&egrave;re.\nVous trouverez ici les informations que vous avez demand&eacute;es concernant le bien suivant.\nVous pouvez cliquer pour obtenir plus d&#039;informations et des maisons similaires :\n\n{{PROPERTY}}\n\nSi vous souhaitez que l&#039;un de nos conseillers vous contacte, veuillez r&eacute;pondre &agrave; cet e-mail en indiquant un num&eacute;ro de t&eacute;l&eacute;phone et une heure &agrave; laquelle il vousconviendrait de recevoir un appel ou un whatsapp.\n\nMeilleures salutations et merci pour votre temps\n\n&quot;;
// intr_txt[&#039;is1&#039;] = &quot;&quot;;
intr_txt[&#039;nl1&#039;] = &quot;Dank u voor het contacteren van ons makelaarskantoor.\nHier is de informatie die u heeft opgevraagd over het volgende object.\nU kunt klikken voor meer informatie en soortgelijke huizen:\n\n{{PROPERTY}}\n\nIndien u wenst dat een van onze adviseurs contact met u opneemt, gelieve dan te antwoorden op deze e-mail, met vermelding van een telefoonnummer en een tijdstip waarophet u schikt om een telefoontje of een whatsapp te ontvangen.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no1&#039;] = &quot;Takk for at du kontakter v&aring;r eiendom.\nHer er informasjonen du har bedt om om f&oslash;lgende eiendom.\nDu kan klikke for mer informasjon og lignende hus:\n\n{{PROPERTY}}\n\nHvis du vil at en av v&aring;re r&aring;dgivere skal kontakte deg, vennligst svar p&aring; denne e-posten, og oppgi et telefonnummer og et tidspunkt det passer for deg &aring; motta en samtaleeller whatsapp.\n\nHilsen og takk for din tid&quot;;
// intr_txt[&#039;ru1&#039;] = &quot;&quot;;
intr_txt[&#039;se1&#039;] = &quot;Tack f&ouml;r att du har kontaktat v&aring;r fastighetsbyr&aring;.\nH&auml;r &auml;r den information som du har beg&auml;rt om f&ouml;ljande fastighet.\nDu kan klicka f&ouml;r mer information och liknande hus:\n\n{{PROPERTY}}\n\nOm du vill att en av v&aring;ra r&aring;dgivare ska kontakta dig, v&auml;nligen svara p&aring; detta e-postmeddelande och ange ett telefonnummer och en tid d&aring; det skulle passa dig att f&aring; ettsamtal eller en whatsapp.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl1&#039;] = &quot;Dzi&#x119;kujemy za kontakt z nasz&#x105; agencj&#x105; nieruchomo&#x15b;ci.\nTutaj znajdziesz informacje, o kt&oacute;re prosi&#x142;e&#x15b;, dotycz&#x105;ce nast&#x119;puj&#x105;cej nieruchomo&#x15b;ci.\nKliknij, aby uzyska&#x107; wi&#x119;cej informacji i zobaczy&#x107; podobne domy:\n\n{{PROPERTY}}\n\nJe&#x15b;li chcesz, aby jeden z naszych doradc&oacute;w skontaktowa&#x142; si&#x119; z Tob&#x105;, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, podaj&#x105;c numer telefonu i czas, w kt&oacute;rym by&#x142;by&#x15b; w stanie odebra&#x107; telefonlub wiadomo&#x15b;&#x107; SMS.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da2&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de2&#039;] = &quot;Erste Antwort mit Telefonnummer&quot;;
intr_sub[&#039;en2&#039;] = &quot;Initial response with telephone number&quot;;
intr_sub[&#039;es2&#039;] = &quot;Respuesta Inicial con tel&eacute;fono&quot;;
//intr_sub[&#039;fi2&#039;] = &quot;&quot;;
intr_sub[&#039;fr2&#039;] = &quot;R&eacute;ponse initiale avec num&eacute;ro de t&eacute;l&eacute;phone&quot;;
//intr_sub[&#039;is2&#039;] = &quot;&quot;;
intr_sub[&#039;nl2&#039;] = &quot;Eerste antwoord met telefoonnummer&quot;;
intr_sub[&#039;no2&#039;] = &quot;F&oslash;rste svar med telefon&quot;;
// intr_sub[&#039;ru2&#039;] = &quot;&quot;;
intr_sub[&#039;se2&#039;] = &quot;F&ouml;rsta svar med telefonnummer&quot;;
intr_sub[&#039;pl2&#039;] = &quot;Wst&#x119;pna odpowied&#x17a; wraz z numerem telefonu&quot;;

// intr_txt[&#039;da2&#039;] = &quot;&quot;;
intr_txt[&#039;de2&#039;] = &quot;Vielen Dank, dass Sie unser Immobilienb&uuml;ro kontaktiert haben.\nHier finden Sie die von Ihnen gew&uuml;nschten Informationen zu folgender Immobilie.\nF&uuml;r weitere Informationen und &auml;hnliche H&auml;user k&ouml;nnen Sie hier klicken:\n\n{{PROPERTY}}\n\nWenn Sie m&ouml;chten, dass sich einer unserer Berater mit Ihnen in Verbindung setzt, antworten Sie bitte auf diese E-Mail und geben Sie eine Zeit an, zu der Sie gerneangerufen oder per Whatsapp kontaktiert werden m&ouml;chten.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en2&#039;] = &quot;Thank you for contacting our real estate agency.\nHere you have the information you have requested about the following property.\nYou can click for more information and similar houses:\n\n{{PROPERTY}}\n\nIf you would like one of our advisors to contact you, please reply to this email, indicating a time when it would be convenient for you to receive a call or whatsapp.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es2&#039;] = &quot;Gracias por contactar con nuestra inmobiliaria.\nAqu&iacute; tienes la informaci&oacute;n que nos has solicitado sobre la siguiente propiedad.\nPuedes hacer clic para m&aacute;s informaci&oacute;n y casas similares:\n\n{{PROPERTY}}\n\nSi quiere que uno de nuestros asesores se ponga en contacto contigo, por favor responde a este mail, indicando una hora a la que te viene bien recibir una llamada owhatsapp.\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi2&#039;] = &quot;&quot;;
intr_txt[&#039;fr2&#039;] = &quot;Merci d&#039;avoir contact&eacute; notre agence immobili&egrave;re.\nVous trouverez ici les informations que vous avez demand&eacute;es concernant le bien suivant.\nVous pouvez cliquer pour obtenir plus d&#039;informations et des maisons similaires :\n\n{{PROPERTY}}\n\nSi vous souhaitez que l&#039;un de nos conseillers vous contacte, veuillez r&eacute;pondre &agrave; cet e-mail en indiquant le moment o&ugrave; il vous conviendrait de recevoir un appel ou unwhatsapp.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is2&#039;] = &quot;&quot;;
intr_txt[&#039;nl2&#039;] = &quot;Dank u voor het contacteren van ons makelaarskantoor.\nHier heeft u de informatie die u heeft opgevraagd over het volgende object.\nU kunt klikken voor meer informatie en soortgelijke huizen:\n\n{{PROPERTY}}\n\nIndien u wenst dat een van onze adviseurs contact met u opneemt, gelieve deze e-mail te beantwoorden en een tijdstip op te geven dat u schikt om een telefoontje ofwhatsapp te ontvangen.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no2&#039;] = &quot;Takk for at du kontakter v&aring;r eiendom.\nHer er informasjonen du har bedt om om f&oslash;lgende eiendom.\nDu kan klikke for mer informasjon og lignende hus:\n\n{{PROPERTY}}\n\nHvis du vil at en av v&aring;re r&aring;dgivere skal kontakte deg, vennligst svar p&aring; denne e-posten og angi et tidspunkt det passer for deg &aring; motta en samtale eller whatsapp.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru2&#039;] = &quot;&quot;;
intr_txt[&#039;se2&#039;] = &quot;Tack f&ouml;r att du har kontaktat v&aring;r fastighetsbyr&aring;.\nH&auml;r har du den information som du har beg&auml;rt om f&ouml;ljande fastighet.\nDu kan klicka f&ouml;r mer information och liknande hus:\n\n{{PROPERTY}}\n\nOm du vill att en av v&aring;ra r&aring;dgivare ska kontakta dig, v&auml;nligen svara p&aring; detta e-postmeddelande och ange en tidpunkt n&auml;r det skulle passa dig att f&aring; ett samtal eller enwhatsapp.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl2&#039;] = &quot;Dzi&#x119;kujemy za kontakt z nasz&#x105; agencj&#x105; nieruchomo&#x15b;ci.\nTutaj znajdziesz informacje, o kt&oacute;re prosi&#x142;e&#x15b;, dotycz&#x105;ce nast&#x119;puj&#x105;cej nieruchomo&#x15b;ci.\nKliknij, aby uzyska&#x107; wi&#x119;cej informacji i zobaczy&#x107; podobne domy:\n\n{{PROPERTY}}\n\nJe&#x15b;li chcesz, aby jeden z naszych doradc&oacute;w skontaktowa&#x142; si&#x119; z Tob&#x105;, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, podaj&#x105;c czas, w kt&oacute;rym by&#x142;by&#x15b; zainteresowany otrzymaniem telefonu lubwiadomo&#x15b;ci SMS.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da3&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de3&#039;] = &quot;Antwort Follow-up&quot;;
intr_sub[&#039;en3&#039;] = &quot;Response Follow-up&quot;;
intr_sub[&#039;es3&#039;] = &quot;Respuesta Seguimiento&quot;;
//intr_sub[&#039;fi3&#039;] = &quot;&quot;;
intr_sub[&#039;fr3&#039;] = &quot;Suivi de la r&eacute;ponse&quot;;
//intr_sub[&#039;is3&#039;] = &quot;&quot;;
intr_sub[&#039;nl3&#039;] = &quot;Antwoord Follow-up&quot;;
intr_sub[&#039;no3&#039;] = &quot;Respons Oppf&oslash;lging&quot;;
// intr_sub[&#039;ru3&#039;] = &quot;&quot;;
intr_sub[&#039;se3&#039;] = &quot;Uppf&ouml;ljning av svaret&quot;;
intr_sub[&#039;pl3&#039;] = &quot;Odpowied&#x17a; Kontynuacja&quot;;

// intr_txt[&#039;da3&#039;] = &quot;&quot;;
intr_txt[&#039;de3&#039;] = &quot;Hallo ...........................\n\nZun&auml;chst einmal danke ich Ihnen, dass Sie sich die Zeit genommen haben, mit mir zu sprechen. \nIch habe mich sehr gefreut, dass ich mit Ihnen &uuml;ber Ihre Wohnungssuche sprechen konnte:\n\n{{PROPERTY}}\n\nDamit wir in Kontakt bleiben k&ouml;nnen, finden Sie meine Kontaktdaten (Mobiltelefon und E-Mail-Adresse) unter meiner Unterschrift.\n\nBei dieser Gelegenheit m&ouml;chte ich Ihnen mitteilen, dass Sie auf unserer Website H&auml;user mit &auml;hnlichen Merkmalen sehen k&ouml;nnen, \n\nIch stehe Ihnen f&uuml;r jede Kl&auml;rung zur Verf&uuml;gung.\n&quot;;
intr_txt[&#039;en3&#039;] = &quot;Hello ...........................\n\nFirstly, thank you for taking the time to speak with me. \nI was delighted to have the opportunity to speak with you about your housing search:\n\n{{PROPERTY}}\n\nTo help us keep in touch, you will find my contact details (mobile phone and email address) below my signature.\n\nI would like to take this opportunity to tell you that you can see houses with similar characteristics on our website, \n\nI remain at your disposal for any clarification.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es3&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\n\nEn primer lugar, gracias por dedicar su tiempo a hablar conmigo. \nMe ha encantado tener la oportunidad de hablar con usted sobre su b&uacute;squeda de vivienda:\n\n{{PROPERTY}}\n\nPara ayudarnos a mantener el contacto, encontrar&aacute; mis datos (tel&eacute;fono m&oacute;vil y direcci&oacute;n de correo electr&oacute;nico) debajo de mi firma.\n\nAprovecho para comentarte, en nuestra web, puedes ver casas con similares caracter&iacute;sticas, \n\nQuedo a tu disposici&oacute;n para cualquier aclaraci&oacute;n.\n\nUn saludo  y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi3&#039;] = &quot;&quot;;
intr_txt[&#039;fr3&#039;] = &quot;Bonjour ...........................\n\nTout d&#039;abord, je vous remercie d&#039;avoir pris le temps de me parler. \nJ&#039;ai &eacute;t&eacute; ravi d&#039;avoir l&#039;occasion de parler avec vous de votre recherche de logement :\n\n{{PROPERTY}}\n\nPour nous aider &agrave; rester en contact, vous trouverez mes coordonn&eacute;es (t&eacute;l&eacute;phone portable et adresse &eacute;lectronique) sous ma signature.\n\nJe profite de l&#039;occasion pour vous dire que vous pouvez voir des maisons aux caract&eacute;ristiques similaires sur notre site web, \n\nJe reste &agrave; votre disposition pour toute clarification.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is3&#039;] = &quot;&quot;;
intr_txt[&#039;nl3&#039;] = &quot;Hallo ...........................\n\nTen eerste, dank u dat u de tijd neemt om met mij te spreken. \nIk was verheugd de kans te krijgen met u te spreken over uw zoektocht naar een woning:\n\n{{PROPERTY}}\n\nOm ons te helpen contact te houden, vindt u mijn contactgegevens (mobiele telefoon en e-mailadres) onder mijn handtekening.\n\nIk wil van deze gelegenheid gebruik maken om u te zeggen dat u huizen met soortgelijke kenmerken op onze website kunt bekijken, \n\nIk blijf tot uw beschikking voor elke verduidelijking.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no3&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\n\nF&oslash;rst av alt, takk for at du tok deg tid til &aring; snakke med meg.\nJeg har v&aelig;rt glad for &aring; f&aring; muligheten til &aring; snakke med deg om boligs&oslash;ket ditt:\n\n{{PROPERTY}}\n\nFor &aring; hjelpe oss med &aring; holde kontakten finner du detaljene mine (mobiltelefon og e-postadresse) under signaturen min.\n\nJeg benytter anledningen til &aring; fortelle deg at p&aring; nettsiden v&aring;r kan du se hus med lignende egenskaper,\n\nJeg st&aring;r til din disposisjon for enhver avklaring.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru3&#039;] = &quot;&quot;;
intr_txt[&#039;se3&#039;] = &quot;Hej ...........................\n\nF&ouml;rst och fr&auml;mst vill jag tacka er f&ouml;r att ni tog er tid att tala med mig. \nDet var roligt att f&aring; tillf&auml;lle att tala med dig om din bostadss&ouml;kning:\n\n{{PROPERTY}}\n\nF&ouml;r att vi ska kunna h&aring;lla kontakten hittar du mina kontaktuppgifter (mobiltelefon och e-postadress) under min signatur.\n\nJag vill ta tillf&auml;llet i akt att ber&auml;tta att du kan se hus med liknande egenskaper p&aring; v&aring;r webbplats, \n\nJag st&aring;r till ert f&ouml;rfogande f&ouml;r eventuella f&ouml;rtydliganden.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl3&#039;] = &quot;Witaj ...........................\n\nPo pierwsze, dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cenie czasu na rozmow&#x119; ze mn&#x105;. \nCiesz&#x119; si&#x119;, &#x17c;e mia&#x142;am okazj&#x119; porozmawia&#x107; z Pa&#x144;stwem o poszukiwaniu mieszkania:\n\n{{PROPERTY}}\n\nAby&#x15b;my mogli pozosta&#x107; w kontakcie, pod moim podpisem znajdziesz moje dane kontaktowe (telefon kom&oacute;rkowy i adres e-mail).\n\nKorzystaj&#x105;c z okazji, pragn&#x119; poinformowa&#x107;, &#x17c;e na naszej stronie internetowej mo&#x17c;na obejrze&#x107; domy o podobnej charakterystyce, \n\nPozostaj&#x119; do Pa&#x144;stwa dyspozycji w przypadku jakichkolwiek wyja&#x15b;nie&#x144;.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da4&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de4&#039;] = &quot;Best&auml;tigung des Besuchs&quot;;
intr_sub[&#039;en4&#039;] = &quot;Confirmation of visit&quot;;
intr_sub[&#039;es4&#039;] = &quot;Confirmaci&oacute;n visita&quot;;
//intr_sub[&#039;fi4&#039;] = &quot;&quot;;
intr_sub[&#039;fr4&#039;] = &quot;Confirmation de la visite&quot;;
//intr_sub[&#039;is4&#039;] = &quot;&quot;;
intr_sub[&#039;nl4&#039;] = &quot;Bevestiging van het bezoek&quot;;
intr_sub[&#039;no4&#039;] = &quot;Konfirmasjonsbes&oslash;k&quot;;
// intr_sub[&#039;ru4&#039;] = &quot;&quot;;
intr_sub[&#039;se4&#039;] = &quot;Bekr&auml;ftelse av bes&ouml;ket&quot;;
intr_sub[&#039;pl4&#039;] = &quot;Potwierdzenie wizyty&quot;;

// intr_txt[&#039;da4&#039;] = &quot;&quot;;
intr_txt[&#039;de4&#039;] = &quot;Hallo ...........................\nDies ist die Best&auml;tigung des Termins zur Besichtigung der Immobilie:\nDatum: ......................\nZeit: ......................\nTreffpunkt: ......................\nEigenschaften zur Ansicht: \n\n{{PROPERTY}}\n\nBest&auml;tigen Sie mir, ob die Daten korrekt sind:\n......................\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en4&#039;] = &quot;Hello ...........................\nThis is the confirmation of the appointment to visit the property:\nDate: ......................\nTime: ......................\nMeeting point: ......................\nProperties to view: \n\n{{PROPERTY}} \n\nConfirm me if the data is correct:\n......................\n\nBest regards and thanks for your time\n&quot;;
intr_txt[&#039;es4&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\nEsta es la confirmaci&oacute;n de la cita para visitar la vivienda:\nFecha: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nHora: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nPunto de encuentro: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nPropiedades para ver: \n\n{{PROPERTY}} \n\nConf&iacute;rmame si los datos son correctos:\n&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nUn saludo  y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi4&#039;] = &quot;&quot;;
intr_txt[&#039;fr4&#039;] = &quot;Bonjour ...........................\nIl s&#039;agit de la confirmation du rendez-vous pour la visite du bien :\nDate : ......................\nHeure : ......................\nPoint de rencontre : ......................\nPropri&eacute;t&eacute;s &agrave; visualiser : \n\n{{PROPERTY}}\n\nConfirmez-moi si les donn&eacute;es sont correctes :\n......................\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is4&#039;] = &quot;&quot;;
intr_txt[&#039;nl4&#039;] = &quot;Hallo ...........................\nDit is de bevestiging van de afspraak om de woning te bezichtigen:\nDatum: ......................\nTijd: ......................\nTrefpunt: ......................\nEigenschappen om te bekijken: \n\n{{PROPERTY}} \n\nBevestig me of de gegevens juist zijn:\n......................\n\nMet vriendelijke groet en bedankt voor uw tijd\n&quot;;
intr_txt[&#039;no4&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\nDette er bekreftelsen p&aring; avtalen om &aring; bes&oslash;ke huset:\nDato: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nTime: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nM&oslash;tepunkt: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nEgenskaper &aring; se:\n\n{{PROPERTY}}\n\nVennligst bekreft om dataene er korrekte:\n&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru4&#039;] = &quot;&quot;;
intr_txt[&#039;se4&#039;] = &quot;Hej ...........................\nDetta &auml;r en bekr&auml;ftelse p&aring; att du har f&aring;tt ett m&ouml;te f&ouml;r att bes&ouml;ka fastigheten:\nDatum: ......................\nTid: ......................\nM&ouml;tesplats: ......................\nEgenskaper att visa: \n\n{{PROPERTY}} \n\nBekr&auml;fta om uppgifterna &auml;r korrekta:\n......................\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl4&#039;] = &quot;Witaj ...........................\nJest to potwierdzenie um&oacute;wienia si&#x119; na wizyt&#x119; w obiekcie:\nData: ......................\nCzas: ......................\nMiejsce spotkania: ......................\nW&#x142;a&#x15b;ciwo&#x15b;ci do przegl&#x105;dania: \n\n{{PROPERTY}}\n\nPotwierd&#x17a;, czy dane s&#x105; poprawne:\n......................\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da5&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de5&#039;] = &quot;Best&auml;tigung der Auflistung&quot;;
intr_sub[&#039;en5&#039;] = &quot;Listing confirmation&quot;;
intr_sub[&#039;es5&#039;] = &quot;Confirmaci&oacute;n de listado&quot;;
//intr_sub[&#039;fi5&#039;] = &quot;&quot;;
intr_sub[&#039;fr5&#039;] = &quot;Confirmation de l&#039;inscription&quot;;
//intr_sub[&#039;is5&#039;] = &quot;&quot;;
intr_sub[&#039;nl5&#039;] = &quot;Bevestiging van de lijst&quot;;
intr_sub[&#039;no5&#039;] = &quot;Oppf&oslash;ringsbekreftelse&quot;;
// intr_sub[&#039;ru5&#039;] = &quot;&quot;;
intr_sub[&#039;se5&#039;] = &quot;Bekr&auml;ftelse av listning&quot;;
intr_sub[&#039;pl5&#039;] = &quot;Potwierdzenie wpisu na list&#x119;&quot;;

// intr_txt[&#039;da5&#039;] = &quot;&quot;;
intr_txt[&#039;de5&#039;] = &quot;Hallo ......................\n\nDies ist eine Best&auml;tigung, um Ihre Immobilie kennenzulernen und die notwendigen Daten zu erheben, um Ihre Immobilie in unserem System zu registrieren und zum Verkaufanzubieten: \n\nDatum: ......................\nZeit: ......................\nKontaktperson: ......................\n\nDie Person, die Ihre Immobilie besichtigt, verf&uuml;gt &uuml;ber viel Erfahrung und Wissen &uuml;ber den Immobilienmarkt und kann Ihnen helfen und Sie beraten, um den bestm&ouml;glichenPreis zu erzielen und Ihre Fragen zum Verkaufsprozess zu beantworten. \n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en5&#039;] = &quot;Hello ......................\n\nThis is a confirmation to meet your property and make the necessary data collection to register your property in our system and put it for sale: \n\nDate: ......................\nTime: ......................\nContact person: ......................\n\nThe person who will visit your property has a lot of experience and knowledge of the property market and will be able to help and advise you to achieve the bestpossible price and answer your questions about the selling process. \n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es5&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nEsta es una confirmaci&oacute;n para quedar en su propiedad y realizar la toma de datos necesaria para dar de alta su propiedad en nuestro sistema y ponerla en venta: \n\nFecha: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nHora: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nPersona de contacto: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nLa persona que visitar&aacute; su propiedad tiene mucha experiencia y conocimiento del mercado inmobiliario y podr&aacute; ayudarlo y asesorarlo para lograr el mejor precio posible y responder a sus preguntas sobre proceso de venta. \n\nUn saludo  y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi5&#039;] = &quot;&quot;;
intr_txt[&#039;fr5&#039;] = &quot;Bonjour ......................\n\nIl s&#039;agit d&#039;une confirmation pour rencontrer votre propri&eacute;t&eacute; et effectuer la collecte des donn&eacute;es n&eacute;cessaires pour enregistrer votre propri&eacute;t&eacute; dans notre syst&egrave;me et lamettre en vente : \n\nDate : ......................\nHeure : ......................\nPersonne de contact : ......................\n\nLa personne qui visitera votre propri&eacute;t&eacute; a beaucoup d&#039;exp&eacute;rience et de connaissances du march&eacute; immobilier et pourra vous aider et vous conseiller pour obtenir lemeilleur prix possible et r&eacute;pondre &agrave; vos questions sur le processus de vente. \n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is5&#039;] = &quot;&quot;;
intr_txt[&#039;nl5&#039;] = &quot;Hallo ......................\n\nDit is een bevestiging om uw eigendom te ontmoeten en de nodige gegevens te verzamelen om uw eigendom in ons systeem te registreren en het te koop aan te bieden: \n\nDatum: ......................\nTijd: ......................\nContactpersoon: ......................\n\nDe persoon die uw eigendom zal bezoeken heeft veel ervaring en kennis van de vastgoedmarkt en zal u kunnen helpen en adviseren om de best mogelijke prijs te bereiken enuw vragen over het verkoopproces te beantwoorden. \n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no5&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nDette er en bekreftelse p&aring; &aring; bo i din eiendom og utf&oslash;re n&oslash;dvendig datainnsamling for &aring; registrere din eiendom i v&aring;rt system og legge den ut for salg:\n\nDato: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nTime: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nKontaktperson: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nDen som skal bes&oslash;ke din eiendom har mye erfaring og kunnskap om eiendomsmarkedet og vil kunne hjelpe og gi deg r&aring;d for &aring; oppn&aring; best mulig pris og svare p&aring; dine sp&oslash;rsm&aring;lom salgsprosessen.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru5&#039;] = &quot;&quot;;
intr_txt[&#039;se5&#039;] = &quot;Hej ......................\n\nDetta &auml;r en bekr&auml;ftelse p&aring; att vi ska tr&auml;ffa din fastighet och g&ouml;ra den n&ouml;dv&auml;ndiga datainsamlingen f&ouml;r att registrera din fastighet i v&aring;rt system och l&auml;gga ut den tillf&ouml;rs&auml;ljning: \n\nDatum: ......................\nTid: ......................\nKontaktperson: ......................\n\nDen person som bes&ouml;ker din fastighet har stor erfarenhet och kunskap om fastighetsmarknaden och kommer att kunna hj&auml;lpa och ge dig r&aring;d f&ouml;r att uppn&aring; b&auml;sta m&ouml;jliga prisoch svara p&aring; dina fr&aring;gor om f&ouml;rs&auml;ljningsprocessen. \n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl5&#039;] = &quot;Witaj ......................\n\nJest to potwierdzenie spotkania z klientem i zebrania danych niezb&#x119;dnych do zarejestrowania nieruchomo&#x15b;ci w naszym systemie i wystawienia jej na sprzeda&#x17c;: \n\nData: ......................\nCzas: ......................\nOsoba kontaktowa: ......................\n\nOsoba, kt&oacute;ra odwiedzi Pa&#x144;stwa nieruchomo&#x15b;&#x107;, ma du&#x17c;e do&#x15b;wiadczenie i wiedz&#x119; na temat rynku nieruchomo&#x15b;ci i b&#x119;dzie w stanie pom&oacute;c i doradzi&#x107; Pa&#x144;stwu w osi&#x105;gni&#x119;ciu jaknajlepszej ceny oraz odpowiedzie&#x107; na Pa&#x144;stwa pytania dotycz&#x105;ce procesu sprzeda&#x17c;y. \n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da6&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de6&#039;] = &quot;Follow-up nach dem Besuch&quot;;
intr_sub[&#039;en6&#039;] = &quot;Follow up after visit&quot;;
intr_sub[&#039;es6&#039;] = &quot;Seguimiento tras visita&quot;;
//intr_sub[&#039;fi6&#039;] = &quot;&quot;;
intr_sub[&#039;fr6&#039;] = &quot;Suivi apr&egrave;s la visite&quot;;
//intr_sub[&#039;is6&#039;] = &quot;&quot;;
intr_sub[&#039;nl6&#039;] = &quot;Follow-up na het bezoek&quot;;
intr_sub[&#039;no6&#039;] = &quot;Oppf&oslash;lging etter bes&oslash;k&quot;;
// intr_sub[&#039;ru6&#039;] = &quot;&quot;;
intr_sub[&#039;se6&#039;] = &quot;Uppf&ouml;ljning efter bes&ouml;ket&quot;;
intr_sub[&#039;pl6&#039;] = &quot;Post&#x119;powanie po wizycie&quot;;

// intr_txt[&#039;da6&#039;] = &quot;&quot;;
intr_txt[&#039;de6&#039;] = &quot;Hallo ......................\n\nIch hoffe, dass Ihnen die Objekte gefallen, die wir k&uuml;rzlich besucht haben. \n\n{{PROPERTY}} \n\nIch sende Ihnen diese Nachricht, um zu erfahren, ob Sie weitere Informationen ben&ouml;tigen oder das Haus noch einmal besichtigen m&ouml;chten.\n\nM&ouml;chten Sie, dass wir dem Verk&auml;ufer ein Angebot machen, oder m&ouml;chten Sie, dass wir andere Immobilien besichtigen?\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en6&#039;] = &quot;Hello ......................\nI hope you like the properties we went to visit recently. \n{{PROPERTY}} \nI am sending you this message to see if you need any further information or even if you would like to visit the house again.\nWould you like us to make an offer to the seller or would you prefer us to visit other properties?\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es6&#039;] = &quot;Hola  &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nEspero que te gustar&aacute;n las propiedades que fuimos a visitar recientemente. \n\n{{PROPERTY}} \n\nTe env&iacute;o este mensaje para ver si necesitas m&aacute;s informaci&oacute;n o incluso si quieres volver a visitar la casa.\n\n&iquest;Quieres que realicemos una oferta al vendedor o prefieres que visitemos otras viviendas?\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi6&#039;] = &quot;&quot;;
intr_txt[&#039;fr6&#039;] = &quot;Bonjour ......................\n\nJ&#039;esp&egrave;re que vous aimez les propri&eacute;t&eacute;s que nous sommes all&eacute;s visiter r&eacute;cemment. \n\n{{PROPERTY}}\n\nJe vous envoie ce message pour voir si vous avez besoin de plus d&#039;informations ou m&ecirc;me si vous souhaitez visiter &agrave; nouveau la maison.\n\nSouhaitez-vous que nous fassions une offre au vendeur ou pr&eacute;f&eacute;rez-vous que nous visitions d&#039;autres propri&eacute;t&eacute;s ?\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is6&#039;] = &quot;&quot;;
intr_txt[&#039;nl6&#039;] = &quot;Hallo ......................\n\nIk hoop dat de eigendommen die we onlangs bezochten u bevallen. \n\n{{PROPERTY}} \n\nIk stuur u dit bericht om te zien of u nog verdere informatie nodig hebt of zelfs of u het huis nog eens zou willen bezoeken.\n\nWilt u dat wij een bod doen aan de verkoper of heeft u liever dat wij andere woningen bezichtigen?\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no6&#039;] = &quot;Hallo  &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nJeg h&aring;per du vil like eiendommene vi nylig bes&oslash;kte.\n\n{{PROPERTY}}\n\nJeg sender deg denne meldingen for &aring; se om du trenger mer informasjon eller om du &oslash;nsker &aring; bes&oslash;ke huset igjen.\n\n&Oslash;nsker du at vi skal gi et tilbud til selger eller foretrekker du at vi bes&oslash;ker andre boliger?\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru6&#039;] = &quot;&quot;;
intr_txt[&#039;se6&#039;] = &quot;Hej ......................\n\nJag hoppas att du gillar de fastigheter som vi bes&ouml;kte nyligen. \n\n{{PROPERTY}} \n\nJag skickar det h&auml;r meddelandet f&ouml;r att h&ouml;ra om du beh&ouml;ver mer information eller om du vill bes&ouml;ka huset igen.\n\nVill du att vi ska l&auml;gga ett bud p&aring; s&auml;ljaren eller f&ouml;redrar du att vi bes&ouml;ker andra fastigheter?\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl6&#039;] = &quot;Witaj ......................\n\nMam nadziej&#x119;, &#x17c;e spodobaj&#x105; si&#x119; Wam nieruchomo&#x15b;ci, kt&oacute;re ostatnio odwiedzili&#x15b;my. \n\n{{PROPERTY}} \n\nWysy&#x142;am t&#x119; wiadomo&#x15b;&#x107;, aby dowiedzie&#x107; si&#x119;, czy potrzebujecie Pa&#x144;stwo dalszych informacji lub czy chcieliby&#x15b;cie ponownie odwiedzi&#x107; dom.\n\nCzy chcesz, aby&#x15b;my z&#x142;o&#x17c;yli ofert&#x119; sprzedaj&#x105;cemu, czy wolisz, aby&#x15b;my odwiedzili inne nieruchomo&#x15b;ci?\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da7&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de7&#039;] = &quot;Keine Antwort&quot;;
intr_sub[&#039;en7&#039;] = &quot;No reply&quot;;
intr_sub[&#039;es7&#039;] = &quot;No responde&quot;;
//intr_sub[&#039;fi7&#039;] = &quot;&quot;;
intr_sub[&#039;fr7&#039;] = &quot;Pas de r&eacute;ponse&quot;;
//intr_sub[&#039;is7&#039;] = &quot;&quot;;
intr_sub[&#039;nl7&#039;] = &quot;Geen antwoord&quot;;
intr_sub[&#039;no7&#039;] = &quot;Svarer ikke&quot;;
// intr_sub[&#039;ru7&#039;] = &quot;&quot;;
intr_sub[&#039;se7&#039;] = &quot;Inget svar&quot;;
intr_sub[&#039;pl7&#039;] = &quot;Brak odpowiedzi&quot;;

// intr_txt[&#039;da7&#039;] = &quot;&quot;;
intr_txt[&#039;de7&#039;] = &quot;Hallo \n\nWir haben Ihre Anfrage nach Informationen &uuml;ber diese Immobilie erhalten:\n\n{{PROPERTY}}\n\nWir haben mehrmals versucht, Sie zu kontaktieren, aber es war nicht m&ouml;glich.\n\nWenn Sie immer noch interessiert sind, lassen Sie mich bitte wissen, wann wir Sie wieder kontaktieren sollen.\nWenn Sie weitere Informationen ben&ouml;tigen, wenden Sie sich bitte an uns.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en7&#039;] = &quot;We have received your request for information about this property:\n\n{{PROPERTY}}\n\nWe have tried to contact you several times and it has not been possible.\n\nIf you are still interested, please let me know when you would like us to contact you again.\nIf you need any further information, please contact us.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es7&#039;] = &quot;Hola \n\nTras haber recibido tu solicitud de informaci&oacute;n sobre esta propiedad:\n\n{{PROPERTY}}\n\nHemos intentado contactar contigo en diferentes ocasiones y no ha sido posible.\n\nSi a&uacute;n est&aacute;s interesado, ind&iacute;came en que horario quieres que volvamos a contactarte\nSi necesitas cualquier tipo de informaci&oacute;n adicional ponte en contacto con nosotros\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi7&#039;] = &quot;&quot;;
intr_txt[&#039;fr7&#039;] = &quot;Bonjour \n\nNous avons re&ccedil;u votre demande d&#039;information sur cette propri&eacute;t&eacute; :\n\n{{PROPERTY}}\n\nNous avons essay&eacute; de vous contacter &agrave; plusieurs reprises, mais cela n&#039;a pas &eacute;t&eacute; possible.\n\nSi vous &ecirc;tes toujours int&eacute;ress&eacute;, veuillez me faire savoir quand vous souhaitez que nous vous recontactions.\nSi vous avez besoin de plus amples informations, veuillez nous contacter.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is7&#039;] = &quot;&quot;;
intr_txt[&#039;nl7&#039;] = &quot;Hallo \n\nWij hebben uw verzoek om informatie over deze woning ontvangen:\n\n{{PROPERTY}}\n\nWe hebben verschillende keren geprobeerd contact met u op te nemen, maar dat is niet gelukt.\n\nAls u nog steeds ge&iuml;nteresseerd bent, laat me dan weten wanneer u wilt dat wij weer contact met u opnemen.\nIndien u meer informatie wenst, kunt u contact met ons opnemen.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no7&#039;] = &quot;Hallo\n\nEtter &aring; ha mottatt din foresp&oslash;rsel om informasjon om denne eiendommen:\n\n{{PROPERTY}}\n\nVi har fors&oslash;kt &aring; kontakte deg ved forskjellige anledninger og det har ikke v&aelig;rt mulig.\n\nHvis du fortsatt er interessert, fortell meg n&aring;r du vil at vi skal kontakte deg igjen\nHvis du trenger ytterligere informasjon, vennligst kontakt oss\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru7&#039;] = &quot;&quot;;
intr_txt[&#039;se7&#039;] = &quot;Hej \n\nVi har mottagit din beg&auml;ran om information om denna fastighet:\n\n{{PROPERTY}}\n\nVi har f&ouml;rs&ouml;kt kontakta dig flera g&aring;nger men det har inte varit m&ouml;jligt.\n\nOm du fortfarande &auml;r intresserad, l&aring;t mig veta n&auml;r du vill att vi kontaktar dig igen.\nOm du beh&ouml;ver mer information kan du kontakta oss.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl7&#039;] = &quot;Witaj \n\nOtrzymali&#x15b;my Twoj&#x105; pro&#x15b;b&#x119; o informacje na temat tego obiektu:\n\n{{PROPERTY}}\n\nKilkakrotnie pr&oacute;bowali&#x15b;my si&#x119; z Tob&#x105; skontaktowa&#x107;, ale nie by&#x142;o to mo&#x17c;liwe.\n\nJe&#x15b;li nadal jeste&#x15b; zainteresowany, daj mi zna&#x107;, kiedy chcia&#x142;by&#x15b;, aby&#x15b;my skontaktowali si&#x119; z Tob&#x105; ponownie.\nJe&#x15b;li potrzebujesz dodatkowych informacji, skontaktuj si&#x119; z nami.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da8&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de8&#039;] = &quot;Keine Antwort 2&quot;;
intr_sub[&#039;en8&#039;] = &quot;No reply 2&quot;;
intr_sub[&#039;es8&#039;] = &quot;No responde 2&quot;;
//intr_sub[&#039;fi8&#039;] = &quot;&quot;;
intr_sub[&#039;fr8&#039;] = &quot;Pas de r&eacute;ponse 2&quot;;
//intr_sub[&#039;is8&#039;] = &quot;&quot;;
intr_sub[&#039;nl8&#039;] = &quot;Geen antwoord 2&quot;;
intr_sub[&#039;no8&#039;] = &quot;ikke noe svar 2&quot;;
// intr_sub[&#039;ru8&#039;] = &quot;&quot;;
intr_sub[&#039;se8&#039;] = &quot;Inget svar 2&quot;;
intr_sub[&#039;pl8&#039;] = &quot;Brak odpowiedzi 2&quot;;

// intr_txt[&#039;da8&#039;] = &quot;&quot;;
intr_txt[&#039;de8&#039;] = &quot;Hallo ......................\n\nVor einiger Zeit haben Sie uns kontaktiert und um weitere Informationen &uuml;ber unsere Immobilien gebeten.\n\nIch schreibe Ihnen, um zu erfahren, ob Sie immer noch am Kauf einer Immobilie interessiert sind und ob Sie m&ouml;chten, dass wir Sie erneut kontaktieren.\n\nWenn Sie immer noch interessiert sind, antworten Sie bitte auf diese Nachricht, und ich werde mich so bald wie m&ouml;glich mit Ihnen in Verbindung setzen.\n\nFalls nicht, w&auml;re ich Ihnen dankbar, wenn Sie auf diese Nachricht mit dem Vermerk \&quot;Ich m&ouml;chte keine weiteren Informationen erhalten\&quot; antworten k&ouml;nnten.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en8&#039;] = &quot;Some time ago you contacted us requesting more information about our properties.\n\nI am writing to see if you are still interested in buying a property and also to see if you would like us to contact you again.\n\nIf you are still interested, please reply to this message, and I will contact you as soon as possible.\n\nIf you are not, I would be grateful if you could reply to this message indicating \&quot;I do not wish to receive any further information\&quot;.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es8&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nHace un tiempo te pusiste en contacto con nosotros solicitando m&aacute;s informaci&oacute;n sobre nuestras propiedades.\n\nTe escribo para saber si sigues interesado en la compra de una vivienda y tambi&eacute;n para saber si deseas que te volvamos a contactar.\n\nSi a&uacute;n est&aacute;s interesado, responde a este mensaje, y me pondr&eacute; en contacto contigo a la mayor brevedad posible\n\nSi por el contrario, no lo est&aacute;s, te agradecer&iacute;a respondieras este mensaje indicando &ldquo;no deseo recibir m&aacute;s informaci&oacute;n&rdquo;\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi8&#039;] = &quot;&quot;;
intr_txt[&#039;fr8&#039;] = &quot;Bonjour ......................\n\nIl y a quelque temps, vous nous avez contact&eacute;s pour demander de plus amples informations sur nos propri&eacute;t&eacute;s.\n\nJe vous &eacute;cris pour savoir si vous &ecirc;tes toujours int&eacute;ress&eacute; par l&#039;achat d&#039;une propri&eacute;t&eacute; et aussi pour savoir si vous souhaitez que nous vous recontactions.\n\nSi vous &ecirc;tes toujours int&eacute;ress&eacute;, veuillez r&eacute;pondre &agrave; ce message, et je vous contacterai d&egrave;s que possible.\n\nSi vous ne l&#039;&ecirc;tes pas, je vous serais reconnaissant de r&eacute;pondre &agrave; ce message en indiquant \&quot;Je ne souhaite pas recevoir d&#039;autres informations\&quot;.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is8&#039;] = &quot;&quot;;
intr_txt[&#039;nl8&#039;] = &quot;Enige tijd geleden nam u contact met ons op om meer informatie te vragen over onze eigendommen.\n\nIk schrijf u om te zien of u nog steeds ge&iuml;nteresseerd bent in het kopen van een woning en ook om te zien of u wilt dat wij opnieuw contact met u opnemen.\n\nAls u nog steeds ge&iuml;nteresseerd bent, reageer dan op dit bericht, en ik zal zo spoedig mogelijk contact met u opnemen.\n\nIndien dit niet het geval is, zou ik u dankbaar zijn indien u op dit bericht zou willen antwoorden met de vermelding \&quot;ik wens geen verdere informatie te ontvangen\&quot;.\n\nMet vriendelijke groet en bedankt voor uw tijd\n&quot;;
intr_txt[&#039;no8&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nFor en tid siden kontaktet du oss og ba om mer informasjon om eiendommene v&aring;re.\n\nJeg skriver for &aring; finne ut om du fortsatt er interessert i &aring; kj&oslash;pe bolig og ogs&aring; for &aring; finne ut om du &oslash;nsker at vi skal kontakte deg igjen.\n\nHvis du fortsatt er interessert, svar p&aring; denne meldingen, s&aring; kontakter jeg deg s&aring; snart som mulig.\n\nHvis du derimot ikke er det, vil jeg sette pris p&aring; om du vil svare p&aring; denne meldingen med \&quot;Jeg &oslash;nsker ikke &aring; motta mer informasjon\&quot;\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru8&#039;] = &quot;&quot;;
intr_txt[&#039;se8&#039;] = &quot;Hej ......................\n\nF&ouml;r en tid sedan kontaktade du oss och bad om mer information om v&aring;ra fastigheter.\n\nJag skriver f&ouml;r att h&ouml;ra om du fortfarande &auml;r intresserad av att k&ouml;pa en fastighet och f&ouml;r att h&ouml;ra om du vill att vi kontaktar dig igen.\n\nOm du fortfarande &auml;r intresserad kan du svara p&aring; det h&auml;r meddelandet, s&aring; kontaktar jag dig s&aring; snart som m&ouml;jligt.\n\nOm du inte &auml;r det skulle jag vara tacksam om du kunde svara p&aring; detta meddelande och ange \&quot;Jag vill inte f&aring; n&aring;gon ytterligare information\&quot;.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl8&#039;] = &quot;Witaj ......................\n\nJaki&#x15b; czas temu skontaktowa&#x142;e&#x15b; si&#x119; z nami, prosz&#x105;c o wi&#x119;cej informacji na temat naszych nieruchomo&#x15b;ci.\n\nPisz&#x119;, aby sprawdzi&#x107;, czy nadal jest Pan/Pani zainteresowany/a zakupem nieruchomo&#x15b;ci, a tak&#x17c;e, czy chcia&#x142;by Pan/Pani, aby&#x15b;my ponownie si&#x119; z Panem/Pani&#x105; skontaktowali.\n\nJe&#x15b;li nadal jeste&#x15b; zainteresowany, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, a ja skontaktuj&#x119; si&#x119; z Tob&#x105; tak szybko, jak to b&#x119;dzie mo&#x17c;liwe.\n\nJe&#x15b;li tak nie jest, by&#x142;bym wdzi&#x119;czny, gdyby odpowiedzia&#x142; Pan na t&#x119; wiadomo&#x15b;&#x107;, zaznaczaj&#x105;c \&quot;Nie chc&#x119; otrzymywa&#x107; &#x17c;adnych dalszych informacji\&quot;.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


$(&#039;.btn-txt&#039;).click(function(e) {
    e.preventDefault();
    if ($(&#039;#txt&#039;).val() == &#039;&#039;) {
        alert(&#039;&lt;?php __(&#039;Seleccione un texto&#039;); ?&gt;&#039;);
        $(&#039;#txt&#039;).focus();
        return false;
    }
    if ($(&#039;#ref&#039;).val() == &#039;&#039;) {
        alert(&#039;&lt;?php __(&#039;Seleccione una referencia&#039;); ?&gt;&#039;);
        $(&#039;#ref&#039;).focus();
        return false;
    }
    $(&#039;#subjectSM&#039;).val(intr_sub[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt&#039;).val()]);
    var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt&#039;).val()];
    $(&#039;#messagemail&#039;).val(txt.replace(&#039;{{PROPERTY}}&#039;, &#039;{{PROPERTY-&#039; + $(&#039;#ref&#039;).val() + &#039;}}&#039;));
    return false;
});
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
$lang[&#039;Respuesta Inicial sin tel&eacute;fono&#039;] = &#039;Respuesta Inicial sin tel&eacute;fono&#039;;
$lang[&#039;Respuesta Inicial con tel&eacute;fono&#039;] = &#039;Respuesta Inicial con tel&eacute;fono&#039;;
$lang[&#039;Respuesta Seguimiento&#039;] = &#039;Respuesta Seguimiento&#039;;
$lang[&#039;Confirmaci&oacute;n visita&#039;] = &#039;Confirmaci&oacute;n visita&#039;;
$lang[&#039;Confirmaci&oacute;n de listado&#039;] = &#039;Confirmaci&oacute;n de listado&#039;;
$lang[&#039;Seguimiento tras visita&#039;] = &#039;Seguimiento tras visita&#039;;
$lang[&#039;No responde&#039;] = &#039;No responde&#039;;
$lang[&#039;No responde 2&#039;] = &#039;No responde 2&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_em.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Respuesta Inicial sin tel&eacute;fono&#039;] = &#039;Initial response without telephone&#039;;
$lang[&#039;Respuesta Inicial con tel&eacute;fono&#039;] = &#039;Initial response with telephone number&#039;;
$lang[&#039;Respuesta Seguimiento&#039;] = &#039;Response Follow-up&#039;;
$lang[&#039;Confirmaci&oacute;n visita&#039;] = &#039;Confirmation of visit&#039;;
$lang[&#039;Confirmaci&oacute;n de listado&#039;] = &#039;Listing confirmation&#039;;
$lang[&#039;Seguimiento tras visita&#039;] = &#039;Follow up after visit&#039;;
$lang[&#039;No responde&#039;] = &#039;No reply&#039;;
$lang[&#039;No responde 2&#039;] = &#039;No reply 2&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido exportar a Facebook y MLS Mediaelx
    </h6>
    <div class="card-body">

        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `export_facebook_prop` INT(1) NULL DEFAULT 0 AFTER `export_mediaelx_prop`;

ALTER TABLE `properties_properties` ADD COLUMN `export_mlsmediaelx_prop` INT(1) NULL DEFAULT 0 AFTER `export_facebook_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:43
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$expMediaelx= 0;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$expMediaelx= 0;
$expFacebook= 0;
$expMLSMediaelx= 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1002
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expMediaelx == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_mediaelx_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mediaelx_prop&quot;, &quot;0&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expMediaelx == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_mediaelx_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mediaelx_prop&quot;, &quot;0&quot;);
}
if ($expFacebook == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_facebook_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_facebook_prop&quot;, &quot;0&quot;);
}
if ($expMLSMediaelx == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_mlsmediaelx_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mlsmediaelx_prop&quot;, &quot;0&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1228
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expMediaelx == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_mediaelx_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mediaelx_prop&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expMediaelx == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_mediaelx_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mediaelx_prop&quot;);
}
if ($expFacebook == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_facebook_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_facebook_prop&quot;);
}
if ($expMLSMediaelx == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_mlsmediaelx_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_mlsmediaelx_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4018
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;checkbox&quot; &lt;?php if ($expMediaelx == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
        &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_mediaelx_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;export_mediaelx_prop&quot; id=&quot;export_mediaelx_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expMediaelx == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
        &lt;?php __(&#039;Exportar a Mediaelx&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_mediaelx_prop&quot;); ?&gt;
        &lt;hr&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;checkbox&quot; &lt;?php if ($expMediaelx == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
        &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_mediaelx_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;export_mediaelx_prop&quot; id=&quot;export_mediaelx_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expMediaelx == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
        &lt;?php __(&#039;Exportar a Mediaelx&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_mediaelx_prop&quot;); ?&gt;
        &lt;hr&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;checkbox&quot; &lt;?php if ($expFacebook == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
        &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_facebook_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;export_facebook_prop&quot; id=&quot;export_facebook_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expFacebook == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
        &lt;?php __(&#039;Exportar a Facebook&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_facebook_prop&quot;); ?&gt;
        &lt;hr&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;checkbox&quot; &lt;?php if ($expMLSMediaelx == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
        &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_mlsmediaelx_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;export_mlsmediaelx_prop&quot; id=&quot;export_mlsmediaelx_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; &lt;?php if ($expMLSMediaelx == 0) { ?&gt;disabled&lt;?php } ?&gt; /&gt;
        &lt;?php __(&#039;Exportar a MLS Mediaelx&#039;); ?&gt;
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_mlsmediaelx_prop&quot;); ?&gt;
        &lt;p class=&quot;help-block&quot;&gt;&lt;?php __(&#039;Es importante rellenar los campos de piscina, parking y localizaci&oacute;n en mapa&#039;); ?&gt;&lt;/p&gt;
        &lt;hr&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:282
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsMediaelx = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mediaelx_prop = 1
&quot;;
$rsMediaelx = mysql_query($query_rsMediaelx, $inmoconn) or die(mysql_error());
$row_rsMediaelx = mysql_fetch_assoc($rsMediaelx);
$totalRows_rsMediaelx = mysql_num_rows($rsMediaelx);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsMediaelx = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mediaelx_prop = 1
&quot;;
$rsMediaelx = mysql_query($query_rsMediaelx, $inmoconn) or die(mysql_error());
$row_rsMediaelx = mysql_fetch_assoc($rsMediaelx);
$totalRows_rsMediaelx = mysql_num_rows($rsMediaelx);

$query_rsFacebook = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_facebook_prop = 1
&quot;;
$rsFacebook = mysql_query($query_rsFacebook, $inmoconn) or die(mysql_error());
$row_rsFacebook = mysql_fetch_assoc($rsFacebook);
$totalRows_rsFacebook = mysql_num_rows($rsFacebook);

$query_rsMLSMediaelx = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_mlsmediaelx_prop = 1
&quot;;
$rsMLSMediaelx = mysql_query($query_rsMLSMediaelx, $inmoconn) or die(mysql_error());
$row_rsMLSMediaelx = mysql_fetch_assoc($rsMLSMediaelx);
$totalRows_rsMLSMediaelx = mysql_num_rows($rsMLSMediaelx);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:340
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expMediaelx) {$tot = $tot + 1;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expMediaelx) {$tot = $tot + 1;}
if ($expFacebook) {$tot = $tot + 1;}
if ($expMLSMediaelx) {$tot = $tot + 1;}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:388
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expMediaelx) { ?&gt;
  &lt;div class=&quot;col-md-2&quot;&gt;
        &lt;div class=&quot;form-group&quot;&gt;
          &lt;label for=&quot;export_mediaelx_prop&quot;&gt;&lt;?php __(&#039;Mediaelx&#039;); ?&gt;:&lt;/label&gt;
          &lt;div class=&quot;controls&quot;&gt;
            &lt;select name=&quot;export_mediaelx_prop&quot; id=&quot;export_mediaelx_prop&quot; class=&quot;form-control&quot;&gt;
                &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
                &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
            &lt;/select&gt;
          &lt;/div&gt;
        &lt;/div&gt;
  &lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expMediaelx) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;label for=&quot;export_mediaelx_prop&quot;&gt;&lt;?php __(&#039;Mediaelx&#039;); ?&gt;:&lt;/label&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;select name=&quot;export_mediaelx_prop&quot; id=&quot;export_mediaelx_prop&quot; class=&quot;form-control&quot;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
              &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
          &lt;/select&gt;
        &lt;/div&gt;
      &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
&lt;?php if ($expFacebook) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;label for=&quot;export_facebook_prop&quot;&gt;&lt;?php __(&#039;Facebook&#039;); ?&gt;:&lt;/label&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;select name=&quot;export_facebook_prop&quot; id=&quot;export_facebook_prop&quot; class=&quot;form-control&quot;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
              &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
          &lt;/select&gt;
        &lt;/div&gt;
      &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
&lt;?php if ($expMLSMediaelx) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
      &lt;div class=&quot;form-group&quot;&gt;
        &lt;label for=&quot;export_mlsmediaelx_prop&quot;&gt;&lt;?php __(&#039;MLS Mediaelx&#039;); ?&gt;:&lt;/label&gt;
        &lt;div class=&quot;controls&quot;&gt;
          &lt;select name=&quot;export_mlsmediaelx_prop&quot; id=&quot;export_mlsmediaelx_prop&quot; class=&quot;form-control&quot;&gt;
              &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
              &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
              &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
          &lt;/select&gt;
        &lt;/div&gt;
      &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:796
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expMediaelx == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Mediaelx&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsMediaelx,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expMediaelx == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Mediaelx&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsMediaelx,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
&lt;?php if ($expFacebook == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Facebook&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsFacebook,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
&lt;?php if ($expMLSMediaelx == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;MLS Mediaelx&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsMLSMediaelx,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:846
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var showMediaelx = &lt;?php echo $expMediaelx ?&gt;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var showMediaelx = &lt;?php echo $expMediaelx ?&gt;;
var showFacebook = &lt;?php echo $expFacebook ?&gt;;
var showMLSMediaelx = &lt;?php echo $expMLSMediaelx ?&gt;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:102
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expMediaelx == 1) {
  array_push($aColumns, &#039;export_mediaelx_prop&#039;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expMediaelx == 1) {
  array_push($aColumns, &#039;export_mediaelx_prop&#039;);
}
if ($expFacebook == 1) {
  array_push($aColumns, &#039;export_facebook_prop&#039;);
}
if ($expMLSMediaelx == 1) {
  array_push($aColumns, &#039;export_mlsmediaelx_prop&#039;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:345
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$export_mediaelx_prop = &#039;&#039;;
if( isset($_GET[&#039;export_mediaelx_prop&#039;]) &amp;&amp; $_GET[&#039;export_mediaelx_prop&#039;] != &#039;&#039; ){
    $export_mediaelx_prop = &quot;AND export_mediaelx_prop = &quot; . $_GET[&#039;export_mediaelx_prop&#039;];
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$export_mediaelx_prop = &#039;&#039;;
if( isset($_GET[&#039;export_mediaelx_prop&#039;]) &amp;&amp; $_GET[&#039;export_mediaelx_prop&#039;] != &#039;&#039; ){
    $export_mediaelx_prop = &quot;AND export_mediaelx_prop = &quot; . $_GET[&#039;export_mediaelx_prop&#039;];
}
$export_facebook_prop = &#039;&#039;;
if( isset($_GET[&#039;export_facebook_prop&#039;]) &amp;&amp; $_GET[&#039;export_facebook_prop&#039;] != &#039;&#039; ){
    $export_facebook_prop = &quot;AND export_facebook_prop = &quot; . $_GET[&#039;export_facebook_prop&#039;];
}
$export_mediaelx_prop = &#039;&#039;;
if( isset($_GET[&#039;export_mlsmediaelx_prop&#039;]) &amp;&amp; $_GET[&#039;export_mlsmediaelx_prop&#039;] != &#039;&#039; ){
    $export_mlsmediaelx_prop = &quot;AND export_mlsmediaelx_prop = &quot; . $_GET[&#039;export_mlsmediaelx_prop&#039;];
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:369
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case properties_properties.export_mediaelx_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_mediaelx_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case properties_properties.export_mediaelx_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_mediaelx_prop,
case properties_properties.export_facebook_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_facebook_prop,
case properties_properties.export_mlsmediaelx_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_mlsmediaelx_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:459
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$export_mediaelx_prop
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$export_mediaelx_prop $export_facebook_prop $export_mlsmediaelx_prop
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/_js/report-export-search.js:99
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (showMediaelx == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_mediaelx_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mediaelx_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mediaelx_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (showMediaelx == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_mediaelx_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mediaelx_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mediaelx_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}

if (showFacebook == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_facebook_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_facebook_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_facebook_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}

if (showMLSMediaelx == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_mlsmediaelx_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mlsmediaelx_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_mlsmediaelx_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php:xxxxxxxxxxxxxx
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expInmoco == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/inmoco.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/inmoco.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expInmoco == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/inmoco.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/inmoco.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
&lt;?php if ($expFacebook == 1): ?&gt;
    &lt;?php foreach ($languages as $language): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/facebook.php?lang=&lt;?php echo $language ?&gt;&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/facebook.php?lang=&lt;?php echo $language ?&gt;&lt;/a&gt;&lt;/p&gt;
    &lt;?php endforeach ?&gt;
&lt;?php endif ?&gt;
&lt;?php if ($expMLSMediaelx == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/kyero_mls.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/kyero_mls.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Añadir los archivos:
        <pre>
            <code class="makefile">
/xml/facebook.php
/xml/kyero_mls.php
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
$lang[&#039;Exportar a Facebook&#039;] = &#039;Exportar a Facebook&#039;;
$lang[&#039;Exportar a MLS Mediaelx&#039;] = &#039;Exportar a MLS Mediaelx&#039;;
$lang[&#039;Es importante rellenar los campos de piscina, parking y localizaci&oacute;n en mapa&#039;] = &#039;Es importante rellenar los campos de piscina, parking y localizaci&oacute;n en mapa&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_em.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Exportar a Facebook&#039;] = &#039;Export to Facebook&#039;;
$lang[&#039;Exportar a MLS Mediaelx&#039;] = &#039;Export to MLS Mediaelx&#039;;
$lang[&#039;Es importante rellenar los campos de piscina, parking y localizaci&oacute;n en mapa&#039;] = &#039;It is important to fill in the swimming pool, parking and map location fields.&#039;;
            </code>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

