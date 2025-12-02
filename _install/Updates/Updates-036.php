<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 7 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 08-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Etiqueta vendido y vendido web</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Fix envio emails similares al solicitar información de uun inmueble, mejora para que envie y muestre al menos tres similares y ajustes de diseño</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Añadido popup y email de similares a bajada de precio</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Error en la cabecera de los administradores</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Añadido seguimiento de contactos y bajada de precio</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Etiqueta vendido y vendido web
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `vendido_tag_prop` INT(1) NULL DEFAULT 0  COMMENT '' AFTER `vendido_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:772
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;vendido_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;vendido_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;vendido_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;vendido_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;vendido_tag_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;vendido_tag_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:966
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;vendido_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;vendido_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;vendido_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;vendido_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;vendido_tag_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;vendido_tag_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1397
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.col-md-4 --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.col-md-4 --&gt;

&lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;checkbox&quot;&gt;
        &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;vendido_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;vendido_prop&quot; id=&quot;vendido_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
        &lt;?php __(&#039;Vendido&#039;); ?&gt; (&lt;?php __(&#039;Ocultar en listados y exportadores&#039;); ?&gt;)
        &lt;/label&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;vendido_prop&quot;); ?&gt;
    &lt;/div&gt;

&lt;/div&gt; &lt;!--/.col-md-4 --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2431
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;checkbox&quot;&gt;
    &lt;label&gt;
    &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;vendido_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;vendido_prop&quot; id=&quot;vendido_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
    &lt;?php __(&#039;Vendido&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;vendido_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;checkbox&quot;&gt;
    &lt;label&gt;
    &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;vendido_tag_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;vendido_tag_prop&quot; id=&quot;vendido_tag_prop&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
    &lt;?php __(&#039;Vendido&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;vendido_tag_prop&quot;); ?&gt;
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
$lang[&#039;Ocultar en listados y exportadores&#039;] = &#039;Oculto en listados y exportadores&#039;;
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
$lang[&#039;Ocultar en listados y exportadores&#039;] = &#039;Hidden on listings and exporters&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/facilisimo.php:53
/xml/greenacres.php:132
/xml/habitaclia.php:51
/xml/hemnet.php:132
/xml/idealistajson.php:80
/xml/kyero.php:132
/xml/openinmo.php:346
/xml/pisos.php:58
/xml/prian.php:189
/xml/rightmove.php:88
/xml/thinkspain.php:132
/xml/todopisoalicante.php:132
/xml/ubiflow.php:117
/xml/yaencontre.php:139
/xml/zoopla.php:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AND vendido_prop = 0
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
AND vendido_prop = 0 AND vendido_tag_prop = 0
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/slider-properties.tpl:13
/modules/properties/view/partials/property-list.tpl:17
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $resource.vendido_prop == 1}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $resource.vendido_tag_prop == 1}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/etiquetas.tpl:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $property[0].vendido_prop == 1}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $property[0].vendido_tag_prop == 1}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:408
/index.php:460
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.vendido_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_properties.vendido_tag_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:452
/modules/property/property.php:120
/modules/property/property.php:413
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_properties.vendido_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_properties.vendido_prop,
properties_properties.vendido_tag_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/save-a3-mb.php
/modules/property/save-a3.php
/modules/property/save-mb.php
/modules/property/save.php
            </code>
        </pre>
        Buscar y remplazar:
        <pre>
            <code class="php">
vendido_prop
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
vendido_tag_prop
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix envio emails similares al solicitar información de uun inmueble, mejora para que envie y muestre al menos tres similares y ajustes de diseño
    </h6>
    <div class="card-body">
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/enquiry.php:77
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$body .= ob_get_contents();
ob_end_clean();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$prop_enqu = ob_get_contents();
ob_end_clean();

$body .= $prop_enqu;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/enquiry.php:108
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$body2 .= &quot;&lt;p&gt;&quot;. $langStr[&quot;Un cordial saludo&quot;].&quot;.&lt;/p&gt;&quot;;
ob_start();
include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/property.php&#039;);
$body2 .= ob_get_contents();
ob_end_clean();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$body2 .= &quot;&lt;p&gt;&quot;. $langStr[&quot;Un cordial saludo&quot;].&quot;.&lt;/p&gt;&quot;;
$body2 .= $prop_enqu;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/property.php:392
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$similares = getRecords(&quot;

SELECT

    properties_loc1.name_&quot;.$lang.&quot;_loc1 AS country,
    CASE WHEN properties_loc2.name_&quot;.$lang.&quot;_loc2 IS NOT NULL THEN properties_loc2.name_&quot;.$lang.&quot;_loc2 ELSE province1.name_&quot;.$lang.&quot;_loc2  END AS province,
    CASE WHEN properties_loc3.name_&quot;.$lang.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang.&quot;_loc3 ELSE areas1.name_&quot;.$lang.&quot;_loc3  END AS area,
    CASE WHEN properties_loc4.name_&quot;.$lang.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$lang.&quot;_loc4 ELSE towns.name_&quot;.$lang.&quot;_loc4  END AS town,
    CASE WHEN properties_types.types_&quot;.$lang.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$lang.&quot;_typ ELSE types.types_&quot;.$lang.&quot;_typ END AS type,
    properties_status.status_&quot;.$lang.&quot;_sta as sale,
    properties_properties.descripcion_&quot;.$lang.&quot;_prop  as descr,
    properties_properties.m2_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_parcela_prop as m2p_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_&quot;.$lang.&quot;_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_&quot;.$lang.&quot;_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.aseos2_prop,
    properties_properties.precio_desde_prop,
    title_&quot;.$lang.&quot;_prop as metatitle

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1

AND preci_reducidoo_prop &gt;= &#039;&quot;.simpleSanitize(($precio_limite_inferior)).&quot;&#039; AND preci_reducidoo_prop &lt;= &#039;&quot;.simpleSanitize(($precio_limite_superior)).&quot;&#039;

AND CASE WHEN properties_types.types_&quot;.$lang.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$lang.&quot;_typ ELSE types.types_&quot;.$lang.&quot;_typ END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;type&#039;]).&quot;&#039;

AND CASE WHEN properties_loc3.name_&quot;.$lang.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang.&quot;_loc3 ELSE areas1.name_&quot;.$lang.&quot;_loc3  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;area&#039;]).&quot;&#039;

AND CASE WHEN properties_loc4.name_&quot;.$lang.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$lang.&quot;_loc4 ELSE towns.name_&quot;.$lang.&quot;_loc4  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;town&#039;]).&quot;&#039;

AND id_prop != &#039;&quot;.simpleSanitize(($tokens[1])).&quot;&#039;

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT 9

&quot;);

$smarty-&gt;assign(&quot;similares&quot;, $similares);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$similaresQuery = (&quot;

SELECT

    properties_loc1.name_&quot;.$lang.&quot;_loc1 AS country,
    CASE WHEN properties_loc2.name_&quot;.$lang.&quot;_loc2 IS NOT NULL THEN properties_loc2.name_&quot;.$lang.&quot;_loc2 ELSE province1.name_&quot;.$lang.&quot;_loc2  END AS province,
    CASE WHEN properties_loc3.name_&quot;.$lang.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang.&quot;_loc3 ELSE areas1.name_&quot;.$lang.&quot;_loc3  END AS area,
    CASE WHEN properties_loc4.name_&quot;.$lang.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$lang.&quot;_loc4 ELSE towns.name_&quot;.$lang.&quot;_loc4  END AS town,
    CASE WHEN properties_types.types_&quot;.$lang.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$lang.&quot;_typ ELSE types.types_&quot;.$lang.&quot;_typ END AS type,
    properties_status.status_&quot;.$lang.&quot;_sta as sale,
    properties_properties.descripcion_&quot;.$lang.&quot;_prop  as descr,
    properties_properties.m2_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_parcela_prop as m2p_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_&quot;.$lang.&quot;_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_&quot;.$lang.&quot;_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.aseos2_prop,
    properties_properties.precio_desde_prop,
    title_&quot;.$lang.&quot;_prop as metatitle

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1

%s

AND id_prop != &#039;&quot;.simpleSanitize(($tokens[1])).&quot;&#039;

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT 9

&quot;);

$precioQuery = &quot;AND preci_reducidoo_prop &gt;= &#039;&quot;.simpleSanitize(($precio_limite_inferior)).&quot;&#039; AND preci_reducidoo_prop &lt;= &#039;&quot;.simpleSanitize(($precio_limite_superior)).&quot;&#039;&quot;;
$tipoQuery = &quot;AND CASE WHEN properties_types.types_&quot;.$lang.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$lang.&quot;_typ ELSE types.types_&quot;.$lang.&quot;_typ END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;type&#039;]).&quot;&#039;&quot;;
$ciudadQuery = &quot;AND CASE WHEN properties_loc3.name_&quot;.$lang.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang.&quot;_loc3 ELSE areas1.name_&quot;.$lang.&quot;_loc3  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;area&#039;]).&quot;&#039;&quot;;
$areaQuery = &quot;AND CASE WHEN properties_loc4.name_&quot;.$lang.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$lang.&quot;_loc4 ELSE towns.name_&quot;.$lang.&quot;_loc4  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;town&#039;]).&quot;&#039;&quot;;

$similares = getRecords(sprintf($similaresQuery, &quot; &quot; . $tipoQuery . &quot; &quot; . $ciudadQuery . &quot; &quot; . $precioQuery . &quot; &quot; . $areaQuery . &quot;&quot;));

if ($similares[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similares = getRecords(sprintf($similaresQuery, &quot; &quot; . $ciudadQuery . &quot; &quot; . $precioQuery . &quot; &quot; . $areaQuery . &quot;&quot;));
}

if ($similares[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similares = getRecords(sprintf($similaresQuery, &quot; &quot; . $ciudadQuery . &quot; &quot; . $areaQuery . &quot;&quot;));
}

if ($similares[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similares = getRecords(sprintf($similaresQuery, &quot; &quot; . $ciudadQuery . &quot; &quot;));
}

$smarty-&gt;assign(&quot;similares&quot;, $similares);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/similar-properties.php:17
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$similarProp = getRecords(&quot;
    SELECT

        properties_loc1.name_&quot;.$langVal.&quot;_loc1 AS country,
        CASE WHEN properties_loc2.name_&quot;.$langVal.&quot;_loc2 IS NOT NULL THEN properties_loc2.name_&quot;.$langVal.&quot;_loc2 ELSE province1.name_&quot;.$langVal.&quot;_loc2  END AS province,
        CASE WHEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 ELSE areas1.name_&quot;.$langVal.&quot;_loc3  END AS area,
        CASE WHEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 ELSE towns.name_&quot;.$langVal.&quot;_loc4  END AS town,
        CASE WHEN properties_types.types_&quot;.$langVal.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$langVal.&quot;_typ ELSE types.types_&quot;.$langVal.&quot;_typ END AS type,
        properties_properties.descripcion_&quot;.$langVal.&quot;_prop  as descr,
        properties_status.status_&quot;.$langVal.&quot;_sta as sale,
        properties_properties.referencia_prop as ref,
        properties_properties.m2_prop,
        properties_properties.m2_parcela_prop as m2p_prop,
        properties_properties.precio_prop as old_precio,
        properties_properties.preci_reducidoo_prop as precio,
        properties_properties.habitaciones_prop,
        properties_properties.aseos_prop,
        id_prop,
        id_img,
        properties_properties.vendido_prop,
        properties_properties.nuevo_prop,
        properties_properties.alquilado_prop,
        properties_properties.reservado_prop,
        properties_properties.precio_desde_prop,
        properties_properties.watermark_prop


        FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
        LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

 WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 &quot;.$remoteProp.&quot; &quot;.$vend_hasta_prop.&quot;
 AND preci_reducidoo_prop &gt;= &#039;&quot;.$precio_limite_inferior.&quot;&#039; AND preci_reducidoo_prop &lt;= &#039;&quot;.$precio_limite_superior.&quot;&#039;

 AND CASE WHEN properties_types.types_&quot;.$langVal.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$langVal.&quot;_typ ELSE types.types_&quot;.$langVal.&quot;_typ END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;type&#039;]).&quot;&#039;

 AND CASE WHEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 ELSE areas1.name_&quot;.$langVal.&quot;_loc3  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;area&#039;]).&quot;&#039;

 AND CASE WHEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 ELSE towns.name_&quot;.$langVal.&quot;_loc4  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;town&#039;]).&quot;&#039;

 AND id_prop != &#039;&quot;.$propId.&quot;&#039;

 GROUP BY id_prop

 ORDER BY order_img, RAND()

 LIMIT 4

 &quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$similarPropQuery = (&quot;

SELECT

    properties_loc1.name_&quot;.$langVal.&quot;_loc1 AS country,
    CASE WHEN properties_loc2.name_&quot;.$langVal.&quot;_loc2 IS NOT NULL THEN properties_loc2.name_&quot;.$langVal.&quot;_loc2 ELSE province1.name_&quot;.$langVal.&quot;_loc2  END AS province,
    CASE WHEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 ELSE areas1.name_&quot;.$langVal.&quot;_loc3  END AS area,
    CASE WHEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 ELSE towns.name_&quot;.$langVal.&quot;_loc4  END AS town,
    CASE WHEN properties_types.types_&quot;.$langVal.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$langVal.&quot;_typ ELSE types.types_&quot;.$langVal.&quot;_typ END AS type,
    properties_status.status_&quot;.$langVal.&quot;_sta as sale,
    properties_properties.descripcion_&quot;.$langVal.&quot;_prop  as descr,
    properties_properties.m2_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_parcela_prop as m2p_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_&quot;.$langVal.&quot;_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_&quot;.$langVal.&quot;_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.aseos2_prop,
    properties_properties.precio_desde_prop,
    title_&quot;.$langVal.&quot;_prop as metatitle

    FROM properties_loc4 towns
    LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
    LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
    LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1 AND procesada_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1

%s

AND id_prop != &#039;&quot;.simpleSanitize(($property[0][&#039;id_prop&#039;])).&quot;&#039;

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT 4

&quot;);

$precioQuery = &quot;AND preci_reducidoo_prop &gt;= &#039;&quot;.simpleSanitize(($precio_limite_inferior)).&quot;&#039; AND preci_reducidoo_prop &lt;= &#039;&quot;.simpleSanitize(($precio_limite_superior)).&quot;&#039;&quot;;
$tipoQuery = &quot;AND CASE WHEN properties_types.types_&quot;.$langVal.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$langVal.&quot;_typ ELSE types.types_&quot;.$langVal.&quot;_typ END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;type&#039;]).&quot;&#039;&quot;;
$ciudadQuery = &quot;AND CASE WHEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$langVal.&quot;_loc3 ELSE areas1.name_&quot;.$langVal.&quot;_loc3  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;area&#039;]).&quot;&#039;&quot;;
$areaQuery = &quot;AND CASE WHEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 IS NOT NULL THEN properties_loc4.name_&quot;.$langVal.&quot;_loc4 ELSE towns.name_&quot;.$langVal.&quot;_loc4  END = &#039;&quot;.str_replace(&#039;\&#039;&#039;, &#039;&#039;, $property[0][&#039;town&#039;]).&quot;&#039;&quot;;

$similarProp = getRecords(sprintf($similarPropQuery, &quot; &quot; . $tipoQuery . &quot; &quot; . $ciudadQuery . &quot; &quot; . $precioQuery . &quot; &quot; . $areaQuery . &quot;&quot;));

if ($similarProp[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similarProp = getRecords(sprintf($similarPropQuery, &quot; &quot; . $ciudadQuery . &quot; &quot; . $precioQuery . &quot; &quot; . $areaQuery . &quot;&quot;));
}

if ($similarProp[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similarProp = getRecords(sprintf($similarPropQuery, &quot; &quot; . $ciudadQuery . &quot; &quot; . $areaQuery . &quot;&quot;));
}

if ($similarProp[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similarProp = getRecords(sprintf($similarPropQuery, &quot; &quot; . $ciudadQuery . &quot; &quot;));
}

if ($similarProp[2][&#039;id_prop&#039;] == &#039;&#039;) {
    $similarProp = getRecords(sprintf($similarPropQuery, &quot; &quot;));
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/modal-similares.tpl:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $similares[0].id_prop != &quot;&quot;}
    &lt;h5 class=&quot;modal-title&quot;&gt;{$lng_propiedades_similares}&lt;/h5&gt;
{else}
    &lt;h5 class=&quot;modal-title&quot;&gt;{$lng_solicitar_informacion}&lt;/h5&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;h5 class=&quot;modal-title&quot;&gt;{$lng_gracias_por_contactarnos}&lt;/h5&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/modal-similares.tpl:11
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;p class=&quot;lead&quot;&gt;{$lng_el_mensaje_se_ha_enviado_correctamente_}&lt;/p&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $similares[0].id_prop != &quot;&quot;}
    &lt;p&gt;{$lng_first_of_all_thanks_for_contacting_us_}&lt;/p&gt;
    &lt;p&gt;{$lng_we_have_received_your_request_regarding_the_property_reference_s__one_of_our_agents_will_contact_you_as_soon_as_possible_|sprintf:$property[0].ref}&lt;/p&gt;
{else}
    &lt;p class=&quot;lead&quot;&gt;{$lng_el_mensaje_se_ha_enviado_correctamente_}&lt;/p&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/enquiry.php:107
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
$body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;].&quot;.&lt;/p&gt;&quot;;
$body2 .= &quot;&lt;p&gt;&quot;. $langStr[&quot;Un cordial saludo&quot;].&quot;.&lt;/p&gt;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/enquiry.php:108
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$body2 .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 10px; background: &quot;.$mailColor.&quot;; text-align: center; text-transform: uppercase;color: #fff\&quot;&gt;&quot;.$langStr[&quot;Propiedades similares&quot;].&quot;&lt;/h4&gt;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$body2 .= &quot;&lt;p&gt;&quot;.$langStr[&quot;Mientras tanto, por favor eche un vistazo a esta selecci&oacute;n de propiedades similares, esto puede ser de su inter&eacute;s&quot;].&quot;.&lt;/p&gt;&quot;;
$body2 .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 10px; background: &quot;.$mailColor.&quot;; text-align: center; text-transform: uppercase;color: #fff\&quot;&gt;&quot;.$langStr[&quot;Propiedades similares&quot;].&quot;&lt;/h4&gt;&quot;;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/resources/lang_*.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
da -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;F&oslash;rst og fremmest tak fordi du kontakter os.&quot;;
de -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;Zun&auml;chst einmal, vielen Dank f&uuml;r Ihre Kontaktaufnahme.&quot;;
en -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;First of all, thanks for contacting us.&quot;;
es -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;En primer lugar, gracias por contactarnos.&quot;;
fi -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;Ensinn&auml;kin, kiitos, ett&auml; otit meihin yhteytt&auml;.&quot;;
fr -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;Tout d&rsquo;abord, merci de nous contacter.&quot;;
is -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;Fyrst af &ouml;llu, takk fyrir a&eth; hafa samband vi&eth; okkur.&quot;;
nl -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;Allereerst bedankt dat je contact met ons hebt opgenomen.&quot;;
no -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;F&oslash;rst av alt, takk for at du kontakter oss.&quot;;
ru -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;&#x41f;&#x440;&#x435;&#x436;&#x434;&#x435; &#x432;&#x441;&#x435;&#x433;&#x43e;, &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x43e;&#x431;&#x440;&#x430;&#x449;&#x435;&#x43d;&#x438;&#x435; &#x43a; &#x43d;&#x430;&#x43c;.&quot;;
se -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;F&ouml;rst och fr&auml;mst tack f&ouml;r att du kontaktade oss.&quot;;
zh -&gt; $langStr[&quot;First of all, thanks for contacting us.&quot;] = &quot;&#x9996;&#x5148;&#xff0c;&#x611f;&#x8c22;&#x60a8;&#x4e0e;&#x6211;&#x4eec;&#x8054;&#x7cfb;&#x3002;&quot;;
            </code>
        </pre>
        <pre>
            <code class="php">
da -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Vi har modtaget din anmodning vedr&oslash;rende ejendomsreferencen:%s. En af vores agenter vil kontakte dig s&aring; hurtigt som muligt.&quot;;
de -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Wir haben Ihre Anfrage bez&uuml;glich des Eigentumsverweises erhalten:%s. Einer unserer Mitarbeiter wird sich so schnell wie m&ouml;glich mit Ihnen in Verbindung setzen.&quot;;
en -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;;
es -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Hemos recibido su solicitud con respecto a la referencia de propiedad:%s. Uno de nuestros agentes se pondr&aacute; en contacto con usted lo antes posible.&quot;;
fi -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Olemme vastaanottaneet pyynt&ouml;si kiinteist&ouml;vertailusta:%s. Yksi edustajamme ottaa sinuun yhteytt&auml; mahdollisimman pian.&quot;;
fr -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Nous avons re&ccedil;u votre demande concernant la r&eacute;f&eacute;rence du bien:%s. Un de nos agents vous contactera dans les meilleurs d&eacute;lais.&quot;;
is -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Vi&eth; h&ouml;fum m&oacute;tteki&eth; bei&eth;ni &thorn;&iacute;na um eignarvi&eth;mi&eth;unina:%s. Einn af lyfjum okkar mun hafa samband vi&eth; &thorn;ig eins flj&oacute;tt og au&eth;i&eth; er.&quot;;
nl -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;We hebben uw verzoek met betrekking tot de eigenschap referentie ontvangen:%s. Een van onze agenten neemt zo snel mogelijk contact met u op.&quot;;
no -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Vi har mottatt foresp&oslash;rselen din om egenskapsreferansen:%s. En av v&aring;re agenter vil kontakte deg s&aring; snart som mulig.&quot;;
ru -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;&#x41c;&#x44b; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x43b;&#x438; &#x432;&#x430;&#x448; &#x437;&#x430;&#x43f;&#x440;&#x43e;&#x441; &#x43e;&#x442;&#x43d;&#x43e;&#x441;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x43e; &#x441;&#x441;&#x44b;&#x43b;&#x43a;&#x438; &#x43d;&#x430; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c;:%s. &#x41e;&#x434;&#x438;&#x43d; &#x438;&#x437; &#x43d;&#x430;&#x448;&#x438;&#x445; &#x430;&#x433;&#x435;&#x43d;&#x442;&#x43e;&#x432; &#x441;&#x432;&#x44f;&#x436;&#x435;&#x442;&#x441;&#x44f; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x43a;&#x430;&#x43a; &#x43c;&#x43e;&#x436;&#x43d;&#x43e; &#x441;&#x43a;&#x43e;&#x440;&#x435;&#x435;.&quot;;
se -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;Vi har mottagit din beg&auml;ran om egenskapsreferensen:%s. En av v&aring;ra agenter kommer att kontakta dig s&aring; snart som m&ouml;jligt.&quot;;
zh -&gt; $langStr[&quot;We have received your request regarding the property reference: %s. One of our agents will contact you as soon as possible.&quot;] = &quot;&#x6211;&#x4eec;&#x5df2;&#x6536;&#x5230;&#x60a8;&#x6709;&#x5173;&#x623f;&#x4ea7;&#x53c2;&#x8003;&#x7684;&#x8bf7;&#x6c42;&#xff1a;&#xff05;s&#x3002;&#x6211;&#x4eec;&#x7684;&#x4ee3;&#x7406;&#x5546;&#x5c06;&#x5c3d;&#x5feb;&#x4e0e;&#x60a8;&#x8054;&#x7cfb;&#x3002;&quot;;
            </code>
        </pre>
        <pre>
            <code class="php">
da -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;I mellemtiden kan du kigge p&aring; dette udvalg af lignende egenskaber, som kan v&aelig;re af interesse for dig:&quot;;
de -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;In der Zwischenzeit sehen Sie sich bitte diese Auswahl &auml;hnlicher Objekte an, die f&uuml;r Sie von Interesse sein k&ouml;nnten:&quot;;
en -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;;
es -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;Mientras tanto, eche un vistazo a esta selecci&oacute;n de propiedades similares que podr&iacute;an ser de su inter&eacute;s:&quot;;
fi -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;Selvitt&auml;k&auml;&auml; t&auml;ll&auml; v&auml;lin samanlaisia &#x200b;&#x200b;vastaavia ominaisuuksia, jotka saattavat kiinnostaa sinua:&quot;;
fr -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;En attendant, jetez un &oelig;il &agrave; cette s&eacute;lection de propri&eacute;t&eacute;s similaires qui pourraient vous int&eacute;resser:&quot;;
is -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;&Iacute; millit&iacute;&eth;inni skaltu sko&eth;a &thorn;etta &uacute;rval af svipu&eth;um eignum, sem g&aelig;tu haft &aacute;huga &aacute; &thorn;&eacute;r:&quot;;
nl -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;Bekijk in de tussentijd eens een selectie van vergelijkbare woningen die voor u van belang kunnen zijn:&quot;;
no -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;I mellomtiden, ta en titt p&aring; dette valget av lignende egenskaper, som kan v&aelig;re av interesse for deg:&quot;;
ru -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;&#x412; &#x442;&#x43e; &#x436;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x432;&#x437;&#x433;&#x43b;&#x44f;&#x43d;&#x438;&#x442;&#x435; &#x43d;&#x430; &#x44d;&#x442;&#x43e;&#x442; &#x432;&#x44b;&#x431;&#x43e;&#x440; &#x43f;&#x43e;&#x445;&#x43e;&#x436;&#x438;&#x445; &#x441;&#x432;&#x43e;&#x439;&#x441;&#x442;&#x432;, &#x43a;&#x43e;&#x442;&#x43e;&#x440;&#x44b;&#x435; &#x43c;&#x43e;&#x433;&#x443;&#x442; &#x432;&#x430;&#x441; &#x437;&#x430;&#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43e;&#x432;&#x430;&#x442;&#x44c;:&quot;;
se -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;Under tiden kan du titta p&aring; det h&auml;r urvalet av liknande egenskaper som kan vara av intresse f&ouml;r dig:&quot;;
zh -&gt; $langStr[&quot;In the meantime, please have a look at this selection of similar properties, that might be of interest to you:&quot;] = &quot;&#x5728;&#x6b64;&#x671f;&#x95f4;&#xff0c;&#x8bf7;&#x67e5;&#x770b;&#x60a8;&#x53ef;&#x80fd;&#x611f;&#x5174;&#x8da3;&#x7684;&#x7c7b;&#x4f3c;&#x5c5e;&#x6027;&#x9009;&#x62e9;&#xff1a;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido popup y email de similares a bajada de precio
    </h6>
    <div class="card-body">
        En los archivos:
        <pre>
            <code class="makefile">
/resources/lang_*.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
da -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Vi har modtaget en anmodning om en rapport, hvis du s&aelig;nker ejendomsprisen med referencen&quot;;
de -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Wir haben eine Anfrage f&uuml;r einen Bericht erhalten, wenn Sie den Preis der Immobilie mit der Referenz senken&quot;;
en -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;We have received a request for a report if you lower the price of the property with the reference&quot;;
es -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Hemos recibido una solicitud de informe si baja el precio de la propiedad con la referencia&quot;;
fi -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Olemme saaneet raportin pyynn&ouml;n, jos alennat kiinteist&ouml;n hintaa viittauksella&quot;;
fr -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Nous avons re&ccedil;u une demande de rapport si vous abaissez le prix de la propri&eacute;t&eacute; avec la r&eacute;f&eacute;rence&quot;;
is -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Vi&eth; h&ouml;fum fengi&eth; bei&eth;ni um sk&yacute;rslu ef &thorn;&uacute; l&aelig;kkar ver&eth; &aacute; eigninni me&eth; tilv&iacute;suninni&quot;;
nl -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;We hebben een aanvraag voor een rapport ontvangen als u de prijs van het onroerend goed met de referentie verlaagt&quot;;
no -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Vi har mottatt en foresp&oslash;rsel om en rapport hvis du senker prisen p&aring; eiendommen med referansen&quot;;
ru -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;&#x41c;&#x44b; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x43b;&#x438; &#x437;&#x430;&#x43f;&#x440;&#x43e;&#x441; &#x43d;&#x430; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x435;&#x43d;&#x438;&#x435; &#x43e;&#x442;&#x447;&#x435;&#x442;&#x430;, &#x435;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x441;&#x43d;&#x438;&#x436;&#x430;&#x435;&#x442;&#x435; &#x441;&#x442;&#x43e;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c; &#x438;&#x43c;&#x443;&#x449;&#x435;&#x441;&#x442;&#x432;&#x430; &#x441;&#x43e; &#x441;&#x441;&#x44b;&#x43b;&#x43a;&#x43e;&#x439;&quot;;
se -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;Vi har f&aring;tt en beg&auml;ran om en rapport om du s&auml;nker priset p&aring; fastigheten med referensen&quot;;
zh -&gt; $langStr[&quot;We have received a request for a report if you lower the price of the property with the reference&quot;] = &quot;&#x5982;&#x679c;&#x60a8;&#x4f7f;&#x7528;&#x53c2;&#x8003;&#x4ef7;&#x683c;&#x964d;&#x4f4e;&#x623f;&#x4ea7;&#x4ef7;&#x683c;&#xff0c;&#x6211;&#x4eec;&#x5df2;&#x6536;&#x5230;&#x62a5;&#x544a;&#x8bf7;&#x6c42;&quot;;
            </code>
        </pre>
        <hr>
        Sobreescribir el archivo <code>/modules/property/bajada.php</code> por el de esta versión.
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:378
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{include file=&quot;file:modules/property/view/partials/modal-similares.tpl&quot; }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{include file=&quot;file:modules/property/view/partials/modal-similares.tpl&quot; }
{include file=&quot;file:modules/property/view/partials/modal-similares-bajada.tpl&quot; }
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
#featured-properties, #ofertas-properties, #similares-properties, #similares-properties-modal {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
#featured-properties, #ofertas-properties, #similares-properties, #similares-properties-modal, #similares-properties-bajada-modal {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:198
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&quot;#featured-properties .slides, #ofertas-properties .slides, #similares-properties .slides, #similares-properties-modal .slides&quot;).slick({
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&quot;#featured-properties .slides, #ofertas-properties .slides, #similares-properties .slides, #similares-properties-modal .slides, #similares-properties-bajada-modal .slides&quot;).slick({
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:721
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
swal(&#039;&#039;, bajPrecio, &#039;success&#039;);
$(&#039;#bajadaModal .close&#039;).click();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#similarModalBajada&#039;).modal(&#039;toggle&#039;);
$(&#039;#similares-properties-bajada-modal .slides&#039;).resize();
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/modules/property/view/partials/modal-similares-bajada.tpl</code> de esta versión.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en la cabecera de los administradores
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:526
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($_SESSION[&#039;kt_login_id&#039;] &lt; 9) {
  $sWhere = &#039; AND admin_tsk = &#039; . $_SESSION[&#039;kt_login_id&#039;];
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($_SESSION[&#039;kt_login_id&#039;] &lt; 9) {
    $sWhere .= &#039; AND admin_tsk = &#039; . $_SESSION[&#039;kt_login_id&#039;];
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
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido seguimiento de contactos y bajada de precio
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Formulario de contacto&#039;] = &#039;Formulario de contacto&#039;;
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
$lang[&#039;Formulario de contacto&#039;] = &#039;Contact form&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/enquiries.php:62
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered&quot; id=&quot;records-tables&quot; width=&quot;100%&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;ul class=&quot;nav nav-tabs&quot;&gt;
  &lt;li class=&quot;active&quot;&gt;&lt;a href=&quot;enquiries.php&quot;&gt;&lt;?php __(&#039;Consultas&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
  &lt;li&gt;&lt;a href=&quot;bajada.php&quot;&gt;&lt;?php __(&#039;Bajada de precios&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
  &lt;li&gt;&lt;a href=&quot;consultas.php&quot;&gt;&lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;

&lt;br&gt;

&lt;table class=&quot;table table-striped table-bordered&quot; id=&quot;records-tables&quot; width=&quot;100%&quot;&gt;
            </code>
        </pre>
        <hr>
        Ejeutar la query:
        <pre>
            <code class="sql">
CREATE TABLE `properties_consultas_log` (
  `id_con` int(11) NOT NULL AUTO_INCREMENT,
  `lang_con` varchar(128) NOT NULL DEFAULT &#039;&#039;,
  `name_con` varchar(255) NOT NULL DEFAULT &#039;&#039;,
  `email_con` varchar(255) NOT NULL DEFAULT &#039;&#039;,
  `phone_con` varchar(128) DEFAULT NULL,
  `text_con` text NOT NULL,
  `date_con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_con`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/contact/send-quote.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($captcha_success-&gt;success) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($captcha_success-&gt;success) {

    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsInsert = &quot;
    INSERT INTO `properties_consultas_log` (`id_con`, `lang_con`, `name_con`, `email_con`, `phone_con`, `text_con`, `date_con`) VALUES
    (NULL, &#039;&quot;.simpleSanitize(($_GET[&#039;lang&#039;])).&quot;&#039;, &#039;&quot;.simpleSanitize(($_GET[&#039;name&#039;])).&quot;&#039;, &#039;&quot;.simpleSanitize(($_GET[&#039;email&#039;])).&quot;&#039;, &#039;&quot;.simpleSanitize(($_GET[&#039;telefono&#039;])).&quot;&#039;, &#039;&quot;.simpleSanitize(($_GET[&#039;comment&#039;])).&quot;&#039;, NOW())
    &quot;;
    mysql_query($query_rsInsert, $inmoconn);
            </code>
        </pre>
        <hr>
        En los archivos:<br>
        <code>/intramedianet/properties/bajada-data.php</code><br>
        <code>/intramedianet/properties/bajada.php</code><br>
        <code>/intramedianet/properties/_js/report-bajada-search.js</code><br>
        <code>/intramedianet/properties/consultas-data.php</code><br>
        <code>/intramedianet/properties/consultas.php</code><br>
        <code>/intramedianet/properties/_js/report-consultas-search.js</code>
        <hr>
        <b class="text-danger">Hay un error en este cambio que se resuelve en la <a href="/_install/updates.php?v=Updates-059.php#uno">versión 59</a> del master</b>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>