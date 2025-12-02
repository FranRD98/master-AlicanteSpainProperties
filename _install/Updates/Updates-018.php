<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-plus-circle text-success"></i> Restaurada la posibilidad de no actualizar las características al actualizar inmuebles importados</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadidas las opciones eliminar y descargar en las imágenes privadas de los inmuebles</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Restaurada la posibilidad de no actualizar las características al actualizar inmuebles importados
    </h6>
    <div class="card-body">
        En el archivo <code>/intramedianet/xml/proveedores-form.php</code> descomentar las líneas:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores-form.php:124 -> $ins_xml-&gt;addColumn(&quot;up_caracteristicas_xml&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;up_caracteristicas_xml&quot;, &quot;1&quot;);
/intramedianet/xml/proveedores-form.php:152 -> $upd_xml-&gt;addColumn(&quot;up_caracteristicas_xml&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;up_caracteristicas_xml&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores-form.php:277
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php
// &quot;up_tipo_xml&quot;, &quot;up_operacion_xml&quot;, &quot;up_ciudad_xml&quot;, &quot;up_m2_xml&quot;, &quot;up_m2_t_xml&quot;, &quot;up_habitaciones_xml&quot;, &quot;up_aseos_xml&quot;, &quot;up_imagenes_xml&quot;, &quot;up_caracteristicas_xml&quot;, &quot;up_pool_t_xml&quot;,
$campos = array(&quot;up_descripcion_xml&quot;, &quot;up_precio_xml&quot;);
// __(&#039;Tipos&#039;, true), __(&#039;Operaci&oacute;n&#039;, true), __(&#039;Ciudades&#039;, true), __(&#039;M2&#039;, true), __(&#039;M2 Parcela&#039;, true), __(&#039;Habitaciones&#039;, true), __(&#039;Aseos&#039;, true), __(&#039;Im&aacute;genes&#039;, true), __(&#039;Caracter&iacute;sticas&#039;, true), __(&#039;Piscina&#039;, true),
$textos = array(__(&#039;Descripciones&#039;, true), __(&#039;Precio&#039;, true));
?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php
// &quot;up_tipo_xml&quot;, &quot;up_operacion_xml&quot;, &quot;up_ciudad_xml&quot;, &quot;up_m2_xml&quot;, &quot;up_m2_t_xml&quot;, &quot;up_habitaciones_xml&quot;, &quot;up_aseos_xml&quot;, &quot;up_imagenes_xml&quot;, &quot;up_pool_t_xml&quot;,
$campos = array(&quot;up_descripcion_xml&quot;, &quot;up_precio_xml&quot;, &quot;up_caracteristicas_xml&quot;);
// __(&#039;Tipos&#039;, true), __(&#039;Operaci&oacute;n&#039;, true), __(&#039;Ciudades&#039;, true), __(&#039;M2&#039;, true), __(&#039;M2 Parcela&#039;, true), __(&#039;Habitaciones&#039;, true), __(&#039;Aseos&#039;, true), __(&#039;Im&aacute;genes&#039;, true), __(&#039;Piscina&#039;, true),
$textos = array(__(&#039;Descripciones&#039;, true), __(&#039;Precio&#039;, true), __(&#039;Caracter&iacute;sticas&#039;, true));
?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadidas las opciones eliminar y descargar en las imágenes privadas de los inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2058
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;p class=&quot;text-center&quot;&gt;&lt;a href=&quot;/intramedianet/properties/images_delp.php&quot; data-id=&quot;&lt;?php echo $row_rsImagesp[&#039;id_img&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-imgp&quot;&gt;&lt;i class=&quot;fa fa-trash-o&quot;&gt;&lt;/i&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;p class=&quot;text-center&quot;&gt;&lt;a href=&quot;/intramedianet/properties/images_delp.php&quot; data-id=&quot;&lt;?php echo $row_rsImagesp[&#039;id_img&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-imgp&quot;&gt;&lt;i class=&quot;fa fa-trash-o&quot;&gt;&lt;/i&gt;&lt;/a&gt; &lt;input type=&quot;checkbox&quot; name=&quot;delp[]&quot; class=&quot;delimgvp&quot; id=&quot;ckp&lt;?php echo $row_rsImagesp[&#039;id_img&#039;] ?&gt;&quot; value=&quot;&lt;?php echo $row_rsImagesp[&#039;id_img&#039;] ?&gt;&quot;&gt;&lt;/p&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2069
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;ul&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/ul&gt;&lt;hr&gt;

&lt;a href=&quot;#&quot; class=&quot;btn btn-danger delimgsvarp&quot;&gt;&lt;?php __(&#039;Delete selected images&#039;); ?&gt;&lt;/a&gt;

&lt;div class=&quot;pull-right&quot;&gt;
    &lt;a href=&quot;#&quot; class=&quot;btn btn-success downloadimgsvarp&quot;&gt;&lt;?php __(&#039;Download selected images&#039;); ?&gt;&lt;/a&gt;
    &lt;a href=&quot;#&quot; class=&quot;btn btn-success downloadallimgsvarp&quot;&gt;&lt;?php __(&#039;Download all images&#039;); ?&gt;&lt;/a&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4066
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(document).on(&#039;click&#039;, &#039;.delimgsvarp&#039;, function(e) {

e.preventDefault();

if (confirm(&#039;&lt;?php __(&#039;Are you sure want to delete the selected images?&#039;); ?&gt;&#039;)) {
var ids = [];

$(&#039;.delimgvp&#039;).each(function( index ) {
  if ($( this ).is(&quot;:checked&quot;)) {
    ids.push($( this ).val());
  }
});

if (ids.toString() != &#039;&#039;) {
  $.get(&#039;images_del_multp.php?ids=&#039; + ids.toString(), function(data) {
      if (data != &#039;&#039;) {
          $.get(&quot;images_listp.php?id_prop=&quot; + idProperty, function(data) {
            if(data != &#039;&#039;) {
                $(&#039;#images-listp&#039;).html(data);
            }
          });
      }
  });
}

}
});

$(document).on(&#039;click&#039;, &#039;.downloadimgsvarp&#039;, function(e) {
  e.preventDefault();

  var ids = [];

  $(&#039;.delimgvp&#039;).each(function( index ) {
      if ($( this ).is(&quot;:checked&quot;)) {
      ids.push($( this ).val());
      }
  });

  if (ids.toString() != &#039;&#039;) {
      $.get(&#039;images_download_multp.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;ids=&#039; + ids.toString(), function(data) {
          if (data != &#039;&#039;) {
              top.location.href = data;
          }
      });
  }else{
      alert(&#039;&lt;?php echo __(&#039;Please select some images&#039;); ?&gt;&#039;);
  }
});
$(document).on(&#039;click&#039;, &#039;.downloadallimgsvarp&#039;, function(e) {
  e.preventDefault();

  var ids = [];

  $(&#039;.delimgvp&#039;).each(function( index ) {
      ids.push($( this ).val());
  });

  if (ids.toString() != &#039;&#039;) {
      $.get(&#039;images_download_multp.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;ids=&#039; + ids.toString(), function(data) {
          if (data != &#039;&#039;) {
              top.location.href = data;
          }
      });
  }else{
      alert(&#039;&lt;?php echo __(&#039;There are no images&#039;); ?&gt;&#039;);
  }
});
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_listp.php:82
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;p class=&quot;text-center&quot;&gt;&lt;a href=&quot;/intramedianet/properties/images_delp.php&quot; data-id=&quot;&lt;?php echo $row_rsImagenes[&#039;id_img&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-imgp&quot;&gt;&lt;i class=&quot;fa fa-trash-o&quot;&gt;&lt;/i&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;p class=&quot;text-center&quot;&gt;&lt;a href=&quot;/intramedianet/properties/images_delp.php&quot; data-id=&quot;&lt;?php echo $row_rsImagenes[&#039;id_img&#039;] ?&gt;&quot; class=&quot;btn btn-danger btn-sm del-imgp&quot;&gt;&lt;i class=&quot;fa fa-trash-o&quot;&gt;&lt;/i&gt;&lt;/a&gt; &lt;input type=&quot;checkbox&quot; name=&quot;delp[]&quot; class=&quot;delimgvp&quot; id=&quot;ckp&lt;?php echo $row_rsImagenes[&#039;id_img&#039;] ?&gt;&quot; value=&quot;&lt;?php echo $row_rsImagenes[&#039;id_img&#039;] ?&gt;&quot;&gt;&lt;/p&gt;
            </code>
        </pre>
        <hr>
        Subir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_download_multp.php
/intramedianet/properties/images_del_multp.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>