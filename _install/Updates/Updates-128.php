<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-09-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Fallo importador RedSP</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Error al guardar en el calendario</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes exportador Idealista</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo importador RedSP
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Redsp.php:289
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
savePropertyData($query, $in_database, $property-&gt;features-&gt;extra_features, $property-&gt;images, $tagsREDSP);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
savePropertyData($query, $in_database, $property-&gt;extra_features, $property-&gt;images, $tagsREDSP);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al guardar en el calendario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/_js/calendar-view.js:340
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(document).on(&#039;click&#039;, &#039;#btn-close-save&#039;, function(e) {
  e.preventDefault();
  tb = $(this);
  // if ($(&quot;#form1&quot;).valid()) {
    var formVals = $(&quot;#form1&quot;).serialize();
    $.get(&quot;calendario-form.php?&quot;+formVals+&quot;&amp;&quot;+$(&#039;.add-cita&#039;).attr(&#039;name&#039;)+&quot;=ok&quot;, function(data) {
      $(&#039;#calendario&#039;).fullCalendar(&#039;refetchEvents&#039;);
      alert(calAddOk);
    });
    $(&#039;#myModal&#039;).modal(&#039;hide&#039;);
    $(&#039;#myModal3&#039;).modal(&#039;hide&#039;)
  // }
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(document).on(&#039;click&#039;, &#039;#btn-close-save&#039;, function(e) {
  e.preventDefault();
  tb = $(this);
  var form = document.getElementById(&#039;form1&#039;);
    if (form.checkValidity()) {
    var formVals = $(&quot;#form1&quot;).serialize();
    $.get(&quot;calendario-form.php?&quot;+formVals+&quot;&amp;&quot;+$(&#039;.add-cita&#039;).attr(&#039;name&#039;)+&quot;=ok&quot;, function(data) {
      $(&#039;#calendario&#039;).fullCalendar(&#039;refetchEvents&#039;);
      alert(calAddOk);
    });
    $(&#039;#myModal&#039;).modal(&#039;hide&#039;);
    $(&#039;#myModal3&#039;).modal(&#039;hide&#039;)
  } else {
    form.reportValidity();
  }
});
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes exportador Idealista
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `exportado_idealista_prop` INT(1) NULL DEFAULT 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:770
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsProp = &quot;UPDATE `properties_properties` SET exportado_rightmove_prop = &#039;0&#039;, exportado_zoopla_prop = &#039;0&#039; WHERE id_prop = &#039;&quot;.$tNG-&gt;getColumnValue(&#039;id_prop&#039;).&quot;&#039;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsProp = &quot;UPDATE `properties_properties` SET exportado_rightmove_prop = &#039;0&#039;, exportado_idealista_prop = &#039;0&#039;, exportado_zoopla_prop = &#039;0&#039; WHERE id_prop = &#039;&quot;.$tNG-&gt;getColumnValue(&#039;id_prop&#039;).&quot;&#039;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_del_mult.php:43
/intramedianet/properties/images_del.php:41
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$prop.&quot; LIMIT 1;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039;, `exportado_idealista_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$prop.&quot; LIMIT 1;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_order.php:166
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$row_rsMax[&#039;property_img&#039;].&quot; LIMIT 1;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039;, `exportado_idealista_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$row_rsMax[&#039;property_img&#039;].&quot; LIMIT 1;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_upload.php:166
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$_GET[&#039;id_prop&#039;].&quot; LIMIT 1;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039;, `exportado_idealista_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$_GET[&#039;id_prop&#039;].&quot; LIMIT 1;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/planos_upload.php:161
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsMax =&quot;SELECT MAX(order_img) + 1  as max FROM properties_planos WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMax = mysqli_query($inmoconn,$query_rsMax) or die(mysqli_error());
$row_rsMax = mysqli_fetch_assoc($rsMax);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsMax =&quot;SELECT MAX(order_img) + 1  as max FROM properties_planos WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMax = mysqli_query($inmoconn,$query_rsMax) or die(mysqli_error());
$row_rsMax = mysqli_fetch_assoc($rsMax);

$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039;, `exportado_idealista_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$_GET[&#039;id_prop&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/planos_order.php:26
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;UPDATE `properties_planos` SET `order_img` = &quot;. $i++ .&quot; WHERE `id_img` = &quot;.$item.&quot; LIMIT 1;&quot;;
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;UPDATE `properties_planos` SET `order_img` = &quot;. $i++ .&quot; WHERE `id_img` = &quot;.$item.&quot; LIMIT 1;&quot;;
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());

$query_rsMax =&quot;SELECT property_img FROM properties_images WHERE id_img = &#039;&quot;.$item.&quot;&#039;&quot;;
$rsMax = mysqli_query($inmoconn, $query_rsMax) or die(mysqli_error());
$row_rsMax = mysqli_fetch_assoc($rsMax);


$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039;, `exportado_idealista_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$row_rsMax[&#039;property_img&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysqli_query($inmoconn, $query_rsImagenes) or die(mysqli_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/planos_del.php:36
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;DELETE FROM `properties_planos` WHERE `properties_planos`.`id_img` = &#039;&quot;.$_GET[&#039;id&#039;].&quot;&#039; LIMIT 1;&quot;;
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsImagenes = &quot;DELETE FROM `properties_planos` WHERE `properties_planos`.`id_img` = &#039;&quot;.$_GET[&#039;id&#039;].&quot;&#039; LIMIT 1;&quot;;
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());

$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039;, `exportado_idealista_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$prop.&quot; LIMIT 1;&quot;;
$rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:31
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_idealista = &quot;

SELECT

    properties_properties.id_prop,
    properties_properties.referencia_prop,
    properties_properties.preci_reducidoo_prop,
    properties_properties.gastos_prop,
    properties_status.id_sta,
    properties_properties.direccion_prop,
    plantas_prop,
    name_en_loc1,
    CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS pararea,
    properties_properties.lat_long_gp_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    types.types_en_typ,
    types.id_typ,
    properties_status.status_en_sta,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS partown,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.construccion_prop,
    properties_properties.orientacion_prop,
    properties_properties.piscina_prop,
    properties_properties.tipo_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.energia_prop,
    properties_properties.updated_prop,
    properties_types.types_en_typ as partyp,
    towns.name_en_loc4,
    operacion_prop,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province,
    areas1.name_en_loc3,
    areas1.id_loc3,
    properties_loc3.id_loc3,
    idealista_fields_prop

    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        INNER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
        INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND idealista_prop = 1 AND

    properties_properties.vendido_prop = 0 AND
    properties_properties.vendido_tag_prop = 0 AND
    properties_properties.reservado_prop = 0 AND
    properties_properties.alquilado_prop = 0 AND
    properties_properties.force_hide_prop != 1

AND (descripcion_en_prop != &#039;&#039; OR descripcion_de_prop != &#039;&#039; OR descripcion_fr_prop != &#039;&#039; OR descripcion_ru_prop != &#039;&#039; OR descripcion_se_prop != &#039;&#039; OR descripcion_nl_prop != &#039;&#039; OR descripcion_es_prop != &#039;&#039;)


 GROUP BY properties_properties.id_prop
&quot;;
$idealista = mysqli_query($inmoconn,$query_idealista) or die(mysqli_error());
$row_idealista = mysqli_fetch_assoc($idealista);
$totalRows_idealista = mysqli_num_rows($idealista);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_idealistaCheck = &quot;

SELECT

    properties_properties.id_prop

    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        INNER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
        INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND idealista_prop = 1 AND

    properties_properties.vendido_prop = 0 AND
    properties_properties.vendido_tag_prop = 0 AND
    properties_properties.reservado_prop = 0 AND
    properties_properties.alquilado_prop = 0 AND
    properties_properties.force_hide_prop != 1 AND
    properties_properties.exportado_idealista_prop = 0

AND (descripcion_en_prop != &#039;&#039; OR descripcion_de_prop != &#039;&#039; OR descripcion_fr_prop != &#039;&#039; OR descripcion_ru_prop != &#039;&#039; OR descripcion_se_prop != &#039;&#039; OR descripcion_nl_prop != &#039;&#039; OR descripcion_es_prop != &#039;&#039;)


 GROUP BY properties_properties.id_prop
&quot;;
$idealistaCheck = mysqli_query($inmoconn,$query_idealistaCheck) or die(mysqli_error());
$row_idealistaCheck = mysqli_fetch_assoc($idealistaCheck);
$totalRows_idealistaCheck = mysqli_num_rows($idealistaCheck);

if ($totalRows_idealistaCheck  == 0) {
    die();
}

$query_idealista = &quot;

SELECT

    properties_properties.id_prop,
    properties_properties.referencia_prop,
    properties_properties.preci_reducidoo_prop,
    properties_properties.gastos_prop,
    properties_status.id_sta,
    properties_properties.direccion_prop,
    plantas_prop,
    name_en_loc1,
    CASE WHEN properties_loc3.name_en_loc3 IS NOT NULL THEN properties_loc3.name_en_loc3 ELSE areas1.name_en_loc3  END AS pararea,
    properties_properties.lat_long_gp_prop,
    CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
    CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
    CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
    CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
    CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
    CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
    CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
    types.types_en_typ,
    types.id_typ,
    properties_status.status_en_sta,
    CASE WHEN properties_loc4.name_en_loc4 IS NOT NULL THEN properties_loc4.name_en_loc4 ELSE towns.name_en_loc4  END AS partown,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.construccion_prop,
    properties_properties.orientacion_prop,
    properties_properties.piscina_prop,
    properties_properties.tipo_prop,
    properties_properties.m2_parcela_prop,
    properties_properties.energia_prop,
    properties_properties.updated_prop,
    properties_types.types_en_typ as partyp,
    towns.name_en_loc4,
    operacion_prop,
    CASE WHEN properties_loc2.name_en_loc2 IS NOT NULL THEN properties_loc2.name_en_loc2 ELSE province1.name_en_loc2  END AS province,
    areas1.name_en_loc3,
    areas1.id_loc3,
    properties_loc3.id_loc3,
    idealista_fields_prop

    FROM properties_loc4 towns INNER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        INNER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        INNER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img
        INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE properties_properties.activado_prop = 1 AND idealista_prop = 1 AND

    properties_properties.vendido_prop = 0 AND
    properties_properties.vendido_tag_prop = 0 AND
    properties_properties.reservado_prop = 0 AND
    properties_properties.alquilado_prop = 0 AND
    properties_properties.force_hide_prop != 1

AND (descripcion_en_prop != &#039;&#039; OR descripcion_de_prop != &#039;&#039; OR descripcion_fr_prop != &#039;&#039; OR descripcion_ru_prop != &#039;&#039; OR descripcion_se_prop != &#039;&#039; OR descripcion_nl_prop != &#039;&#039; OR descripcion_es_prop != &#039;&#039;)


 GROUP BY properties_properties.id_prop
&quot;;
$idealista = mysqli_query($inmoconn,$query_idealista) or die(mysqli_error());
$row_idealista = mysqli_fetch_assoc($idealista);
$totalRows_idealista = mysqli_num_rows($idealista);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:500
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
} while ($row_idealista = mysqli_fetch_assoc($idealista));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
    $query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_idealista_prop` = &#039;1&#039; WHERE `id_prop` = &quot;.$row_idealista[&#039;id_prop&#039;].&quot; LIMIT 1;&quot;;
    $rsImagenes = mysqli_query($inmoconn,$query_rsImagenes) or die(mysqli_error());
} while ($row_idealista = mysqli_fetch_assoc($idealista));
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>