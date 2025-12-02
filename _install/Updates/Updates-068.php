<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 07-03-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadida variable para activar/desactivar el popup y el email de similares</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>  Error duplicados de propiedades</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-plus-circle text-success"></i>  Cambios de mapas del frontend a OpenStreetMap</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadida variable para activar/desactivar el popup y el email de similares
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/propiedades.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Popup y email de similares */
/*--------------------------------------------------------------------------
|
| Gestina si se muestra o no el Popup y se manda el email de similares
| 0 - No duplica los archivos
| 1 - Duplica los archivos
|
*/

$opcionSimilares = 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:106
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;seccion_lang&quot;, $urlStr[$urlStr[$seccion][&quot;master&quot;]]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;seccion_lang&quot;, $urlStr[$urlStr[$seccion][&quot;master&quot;]]);
$smarty-&gt;assign(&quot;opcionSimilares&quot;, $opcionSimilares);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:263
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var delallfavs = &#039;{$lng_seguro_que_desea_eliminar_todos_los_favoritos|escape:&quot;quotes&quot;}&#039;;
var opcionSimilares = {$opcionSimilares};
                </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var opcionSimilares = {$opcionSimilares};
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:543
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#similarModal&#039;).modal(&#039;toggle&#039;);
$(&#039;#similares-properties-modal .slides&#039;).resize();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (opcionSimilares == 0) {
    wal(&#039;&#039;, okConsult, &#039;success&#039;);
} else {
    $(&#039;#similarModal&#039;).modal(&#039;toggle&#039;);
    $(&#039;#similares-properties-modal .slides&#039;).resize();
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:697
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#similarModalBajada&#039;).modal(&#039;toggle&#039;);
$(&#039;#similares-properties-bajada-modal .slides&#039;).resize();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (opcionSimilares == 0) {
    wal(&#039;&#039;, bajPrecio, &#039;success&#039;);
} else {
    $(&#039;#similarModalBajada&#039;).modal(&#039;toggle&#039;);
    $(&#039;#similares-properties-bajada-modal .slides&#039;).resize();
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error duplicados de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-dupli.php:250
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case &#039;inserted_xml_prop&#039;:
  $sql .= &quot;&quot;;
  break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case &#039;inserted_xml_prop&#039;:
  $sql .= &quot;&quot;;
  break;
case &#039;xml_xml_prop&#039;:
  $sql .= &quot;&quot;;
  break;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Cambios de mapas del frontend a OpenStreetMap
    </h6>
    <div class="card-body">
        Subir la carpeta <code>/js/source/OpenStreetMap</code>  a la carpeta <code>/js/source</code>.
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss:24
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
@import &quot;../../js/source/sidr/dist/stylesheets/jquery.sidr.bare&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
@import &quot;../../js/source/sidr/dist/stylesheets/jquery.sidr.bare&quot;;
@import &quot;../../js/source/OpenStreetMap/leaflet.css&quot;;
@import &quot;../../js/source/OpenStreetMap/MarkerCluster.css&quot;;
@import &quot;../../js/source/OpenStreetMap/MarkerCluster.Default.css&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/webpack.mix.js:29
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&#039;js/source/gmap/gmap3.js&#039;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&#039;js/source/OpenStreetMap/leaflet.js&#039;,
&#039;js/source/OpenStreetMap/leaflet.markercluster.js&#039;,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:269
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
{* @group JS - GOOGLE MAPS *}

{if
    $seccion == $url_property
    or $seccion == $url_property_map
    or $seccion == $url_areas
    or ($smarty.get.zon != &#039;&#039; &amp;&amp; $smarty.get.ciu == &#039;&#039;)
    or ($smarty.get.zon != &#039;&#039; &amp;&amp; $smarty.get.ciu != &#039;&#039;)
}
&lt;script src=&quot;https://maps.google.com/maps/api/js?key={$googleMapsApiKey}&amp;language={$lang}&quot;&gt;&lt;/script&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:325
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
!function ($) {
    $(&quot;a[href=&#039;#pane-mapa&#039;]&quot;).on(&#039;shown.bs.tab&#039;, function(){
        {if $property[0].zoom &gt; 0}
            showMapProperty(&#039;.gmap&#039;, [{$property[0].lat}], {$property[0].zoom});
        {else}
            showMapProperty(&#039;.gmap&#039;, [{$property[0].lat}], 16);
        {/if}
    });
    $(document).on(&#039;shown.bs.collapse&#039;, function(){
        showMapProperty(&#039;.gmap&#039;, [{$property[0].lat}], {$property[0].zoom});
    });
}(window.jQuery);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
!function ($) {
    $(&quot;a[href=&#039;#pane-mapa&#039;]&quot;).on(&#039;shown.bs.tab&#039;, function(){
        {if $property[0].zoom &gt; 0}
            showMapProperty(&#039;gmap&#039;, [{$property[0].lat}], {$property[0].zoom - 3});
        {else}
            showMapProperty(&#039;gmap&#039;, [{$property[0].lat}], 13);
        {/if}
    });
    $(document).on(&#039;shown.bs.collapse&#039;, function(){
        showMapProperty(&#039;gmap&#039;, [{$property[0].lat}], {$property[0].zoom - 3});
    });
}(window.jQuery);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tab-mapa.tpl:6
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;gmap&quot;&gt;&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;gmap&quot; id=&quot;gmap&quot;&gt;&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:1078
            </code>
        </pre>
        Cambiar la función showMapProperty por:
        <pre>
            <code class="php">
function showMapProperty(container, latLng, zoom) {
    var map = L.map(container).setView(latLng, zoom);
    map.addLayer(new L.TileLayer(&#039;https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}{r}.png&#039;, {
        maxZoom: 18,
        attribution: &#039;Map data &amp;copy; &lt;a href=&quot;https://www.openstreetmap.org/&quot;&gt;OpenStreetMap&lt;/a&gt; contributors, &#039; +
            &#039;&lt;a href=&quot;https://creativecommons.org/licenses/by-sa/2.0/&quot;&gt;CC-BY-SA&lt;/a&gt;, &#039;
    }));
    var customIcon = L.icon({
        iconUrl: &#039;https://unpkg.com/leaflet@1.4.0/dist/images/marker-icon.png&#039;,
        iconSize:     [25, 41],
        iconAnchor:   [25, 41],
        popupAnchor:  [-12, -42]
    });
    var marker = L.marker(latLng, { icon: customIcon }).addTo(map);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:381
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
showMapProperties(&quot;#mapa_propiedades&quot;, [ {section name=mp loop=$listMap}{ latLng:[{$listMap[mp].maplat}], data:&#039;&lt;div style=&quot;width: 200px; max-width: 200px;&quot;&gt;&lt;div class=&quot;row&quot;&gt;&lt;div class=&quot;col-12&quot;&gt; {assign var=&quot;altTitle&quot; value=&quot;{$listMap[mp].type|escape} - {$listMap[mp].sale|escape} - {$listMap[mp].area|escape} - {$listMap[mp].town|escape}&quot;}{if file_exists(&quot;{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$listMap[mp].id_img}_sm.jpg&quot;)}&lt;img src=&quot;/media/images/properties/thumbnails/{$listMap[mp].id_img}_sm.jpg&quot; class=&quot;img-fluid&quot; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;{else}{imagesize src=&quot;/media/images/website/no-image.png&quot; width={$thumbnailsSizes[&quot;sm&quot;][0]} height={$thumbnailsSizes[&quot;sm&quot;][1]} class=&quot;img-fluid&quot; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot; }{/if}&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;row&quot; style=&quot;margin-top: 10px;&quot;&gt;&lt;div class=&quot;col-12&quot;&gt;&lt;h4 style=&quot;font-size: 12px !important; margin-bottom: 5px !important;&quot;&gt;{$listMap[mp].type|escape} / {$listMap[mp].area|escape} ({$listMap[mp].town|escape})&lt;/h4&gt;{$lng_ref_|escape}: &lt;strong&gt;{$listMap[mp].referencia_prop|escape}&lt;/strong&gt;&lt;br/&gt;&lt;span class=&quot;prices&quot; style=&quot;margin: 5px 0 10px; display: block; font-weight: 600; color: var(--primary);&quot;&gt;{$lng_precio|escape}: &lt;strong&gt;{if $listMap[mp].old_precio &gt; 0}&lt;del style=&quot;display: inline-block; padding: 0 5px; color:var(--red); font-size: 11px; font-weight: 300;&quot;&gt;{$listMap[mp].old_precio|number_format:0:&quot;,&quot;:&quot;.&quot;}&euro;&lt;/del&gt;{/if} {if $listMap[mp].display_from_prop == 1}{$lng_from}{/if}{if {$listMap[mp].precio|number_format:0:&quot;,&quot;:&quot;.&quot;} != 0} {$listMap[mp].precio|number_format:0:&quot;,&quot;:&quot;.&quot;}&euro; {else} {$lng_consult|escape} {/if}&lt;/strong&gt;&lt;/span&gt;&lt;a href=&quot;{propURL($listMap[mp].id_prop, $lang)}&quot; class=&quot;btn btn-primary btn-sm btn-block&quot;&gt;{$lng_ver_propiedad|escape}&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&#039; + &quot;\n&quot;  },{/section}]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var markersLocations = [
{section name=mp loop=$listMap}
    [
        [{$listMap[mp].maplat}],{assign var=&quot;altTitle&quot; value=&quot;{$listMap[mp].type|escape} - {$listMap[mp].sale|escape} - {$listMap[mp].area|escape} - {$listMap[mp].town|escape}&quot;} &#039;{if file_exists(&quot;{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$listMap[mp].id_img}_sm.jpg&quot;)}&lt;img src=&quot;/media/images/properties/thumbnails/{$listMap[mp].id_img}_sm.jpg&quot; class=&quot;img-fluid&quot; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot;&gt;{else}{imagesize src=&quot;/media/images/website/no-image.png&quot; width={$thumbnailsSizes[&quot;sm&quot;][0]} height={$thumbnailsSizes[&quot;sm&quot;][1]} class=&quot;img-fluid&quot; alt=&quot;{$altTitle}&quot; title=&quot;{$altTitle}&quot; }{/if}&#039;,
        &#039;{$listMap[mp].type|escape} / {$listMap[mp].area|escape} ({$listMap[mp].town|escape})&#039;,
        &#039;{$lng_ref_|escape}: &lt;strong&gt;{$listMap[mp].referencia_prop|escape}&#039;,
        &#039;{$lng_precio|escape}: &lt;strong&gt;{if $listMap[mp].old_precio &gt; 0}&lt;del style=&quot;display: inline-block; padding: 0 5px; color:var(--red); font-size: 11px; font-weight: 300;&quot;&gt;{$listMap[mp].old_precio|number_format:0:&quot;,&quot;:&quot;.&quot;}&euro;&lt;/del&gt;{/if} {if $listMap[mp].display_from_prop == 1}{$lng_from}{/if}{if {$listMap[mp].precio|number_format:0:&quot;,&quot;:&quot;.&quot;} != 0} {$listMap[mp].precio|number_format:0:&quot;,&quot;:&quot;.&quot;}&euro; {else} {$lng_consult|escape} {/if}&lt;/strong&gt;&#039;,
        &#039;{propURL($listMap[mp].id_prop, $lang)}&#039;,
        &#039;{$lng_ver_propiedad|escape}&#039;
    ],
{/section}
];
showMapProperties(&quot;mapa_propiedades&quot;, markersLocations);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:1099
            </code>
        </pre>
        Cambiar la función showMapProperties por:
        <pre>
            <code class="php">
function showMapProperties(container, locations) {

    var map = L.map(container).setView([38.3847,-0.680823], 8);
    map.addLayer(new L.TileLayer(&#039;https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}{r}.png&#039;, {
        maxZoom: 18,
        attribution: &#039;Map data &amp;copy; &lt;a href=&quot;https://www.openstreetmap.org/&quot;&gt;OpenStreetMap&lt;/a&gt; contributors, &#039; +
            &#039;&lt;a href=&quot;https://creativecommons.org/licenses/by-sa/2.0/&quot;&gt;CC-BY-SA&lt;/a&gt;, &#039;
    }));
    var customIcon = L.icon({
        iconUrl: &#039;https://unpkg.com/leaflet@1.4.0/dist/images/marker-icon.png&#039;,
        iconSize:     [25, 41],
        iconAnchor:   [28, 41],
        popupAnchor:  [-12, -42]
    });
    var markers = new L.MarkerClusterGroup({
            showCoverageOnHover: false,
            zoomToBoundsOnClick: false,
            spiderfyOnMaxZoom: true
        });
    var markersList = [];
    for (var i = 0; i &lt;= markersLocations.length -1; i++) {
        var marker = L.marker(markersLocations[i][0], { icon: customIcon });
        marker.bindPopup(&#039;&lt;div style=&quot;width: 200px; max-width: 200px;&quot;&gt;&lt;div class=&quot;row&quot;&gt;&lt;div class=&quot;col-12&quot;&gt;&#039;+markersLocations[i][1]+&#039;&lt;/div&gt;&lt;/div&gt;&lt;div class=&quot;row&quot; style=&quot;margin-top: 10px;&quot;&gt;&lt;div class=&quot;col-12&quot;&gt;&lt;h4 style=&quot;font-size: 12px !important; margin-bottom: 5px !important;&quot;&gt;&#039;+markersLocations[i][2]+&#039;&lt;/h4&gt;&#039;+markersLocations[i][3]+&#039;&lt;/strong&gt;&lt;br/&gt;&lt;span class=&quot;prices&quot; style=&quot;margin: 5px 0 10px; display: block; font-weight: 600; color: var(--primary);&quot;&gt;&#039;+markersLocations[i][4]+&#039;&lt;/strong&gt;&lt;/span&gt;&lt;a href=&quot;&#039;+markersLocations[i][5]+&#039;}&quot; class=&quot;btn btn-primary btn-sm btn-block&quot; style=&quot;color:#fff&quot;&gt;&#039;+markersLocations[i][6]+&#039;&lt;/a&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&#039;);

        markersList.push(marker);
        markers.addLayer(marker);
    }
    map.addLayer(markers);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:399
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
{if $seccion == {$url_areas}}
    {section name=ft loop=$zonasmen}
        {if $zonasmen[ft].lat_long_gp_prop != &#039;&#039; &amp;&amp; $zonasmen[ft].lat_long_gp_prop != &#039;0,0&#039;}
            &lt;script&gt;
                alert();
            showMapZones(&#039;.map{$zonasmen[ft].id_ct}&#039;, [{$zonasmen[ft].lat_long_gp_prop}]);
            &lt;/script&gt;
        {/if}
    {/section}
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:401
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
showMapZones(&#039;.gmap&#039;, [{$zonas[0].lat_long_gp_prop}]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
showMapZones(&#039;gmap&#039;, [{$zonas[0].lat_long_gp_prop}]);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:407
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
showMapZones(&#039;.gmap&#039;, [{$news[0].lat_long_gp_prop}]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
showMapZones(&#039;gmap&#039;, [{$news[0].lat_long_gp_prop}]);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/ciudades/view/index.tpl:65
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;porta-gmap&quot;&gt;&lt;div class=&quot;gmap&quot;&gt;&lt;/div&gt;&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;porta-gmap&quot;&gt;&lt;div class=&quot;gmap&quot; id=&quot;gmap&quot;&gt;&lt;/div&gt;&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/zonas/view/index.tpl:68
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;gmap&quot;&gt;&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;gmap&quot; id=&quot;gmap&quot;&gt;&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:1132
            </code>
        </pre>
        Cambiar la función showMapZones por:
        <pre>
            <code class="php">
function showMapZones(container, latLng) {
    var map = L.map(container).setView(latLng, 10);
    map.addLayer(new L.TileLayer(&#039;https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png&#039;, {
        maxZoom: 18,
        attribution: &#039;Map data &amp;copy; &lt;a href=&quot;https://www.openstreetmap.org/&quot;&gt;OpenStreetMap&lt;/a&gt; contributors, &#039; +
            &#039;&lt;a href=&quot;https://creativecommons.org/licenses/by-sa/2.0/&quot;&gt;CC-BY-SA&lt;/a&gt;, &#039;
    }));
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>