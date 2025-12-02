<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 13-03-2024</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Faltan datos en el PDF</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Icono de cargando al enviar consulta</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-plus-circle text-success"></i> Costas en el front</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-plus-circle text-success"></i> Costas en Intramedianet</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-plus-circle text-success"></i> Eventos </a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadir Costas a Guardar Búsquedas </a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-plus-circle text-success"></i> Toma de datos en ferias </a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-plus-circle text-success"></i> Agencias </a></li>
        <li><a href="#nueve"><i class="fas fz-fw fa-bug text-danger"></i> Botón unsubscribe. Error al darse de baja </a></li>
        <li><a href="#diez"><i class="fas fz-fw fa-plus-circle text-success"></i> Exportador Mediaelx </a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Faltan datos en el PDF
    </h6>
    <div class="card-body">
        <p>
            Sustituir el /property/save_web.php por el nuevo del master.
        </p>
        Añadir en resources/lang_es.php:
        <pre>
            <code class="php">
$langStr[&#039;Gastos&#039;] = &#039;Gastos de comunidad&#039;;
            </code>
        </pre>
        Añadir en resources/lang_en.php:
        <pre>
            <code class="php">
$langStr[&#039;Gastos&#039;] = &#039;Community expenses&#039;;
            </code>
        </pre>

        <p>
            Traducir el resto o copiarlos del máster.
        </p>

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Icono de cargando al enviar consulta
    </h6>
    <div class="card-body">

        <p>Se han solucionado el error que hacía. Que el icono de "cargando" no apareciera en la ficha de propiedad del front al hacer una consulta.</p>
        
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/pages/_miscellaneous.scss:116
            </code>
        </pre>

        Cambiar el position <strong>absolute</strong> por position <strong>Fixed</strong> y volver a compilar el CSS

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Costas en el front
    </h6>
    <div class="card-body">
        <p>Se actualiza y se deja funcionando el módulo de Costas</p>
        
        En 
        <pre>
            <code class="makefile">
/Connections/conf/propiedades.php:186
            </code>
        </pre>

        Eliminar: 
        <pre>
            <code class="php">
$actCostasBuscador = 0;
            </code>
        </pre>

        En el archivo:
        <pre>
            <code class="makefile">
index.php:130
            </code>
        </pre>

        Cambiar:
        <pre>
            <code class="php">
$smarty->assign("actCostasBuscador", $actCostasBuscador);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty->assign("actCostas", $actCostas);
            </code>
        </pre>

        En el archivo:
        <pre>
            <code class="makefile">
index.php:457
            </code>
        </pre>

        Cambiar:
        <pre>
            <code class="sql">
$featuredQuery = "
    SELECT
        properties_loc1.name_".$lang."_loc1 AS country,
        CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
        CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
        CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
        CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
        properties_status.status_".$lang."_sta as sale,
        properties_properties.descripcion_".$lang."_prop  as descr,
        properties_properties.m2_prop,
        properties_properties.precio_prop as old_precio,
        properties_properties.preci_reducidoo_prop as precio,
        properties_properties.habitaciones_prop,
        properties_properties.aseos_prop,
        properties_properties.referencia_prop as ref,
        properties_properties.m2_parcela_prop as m2p_prop,
        id_prop,
        id_img,
        properties_properties.vendido_tag_prop,
        properties_properties.nuevo_prop,
        (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
        properties_properties.alquilado_prop,
        properties_properties.reservado_prop,
        properties_properties.watermark_prop,
        properties_properties.aseos2_prop,
        properties_properties.precio_desde_prop,
        title_".$lang."_prop as metatitle
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
    WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND destacado_prop = 1 AND image_img != '' AND force_hide_prop != 1
    GROUP BY id_prop
    ORDER BY order_img, RAND()
    LIMIT 9
";
            </code>
        </pre>
        Por:
        <pre>
            <code class="sql">
$featuredQuery = "
    SELECT
        properties_loc1.name_".$lang."_loc1 AS country,
        CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
        CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
        CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
        CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
        CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
        (SELECT coast_".$lang."_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
        properties_status.status_".$lang."_sta as sale,
        properties_properties.descripcion_".$lang."_prop  as descr,
        properties_properties.m2_prop,
        properties_properties.precio_prop as old_precio,
        properties_properties.preci_reducidoo_prop as precio,
        properties_properties.habitaciones_prop,
        properties_properties.aseos_prop,
        properties_properties.referencia_prop as ref,
        properties_properties.m2_parcela_prop as m2p_prop,
        id_prop,
        id_img,
        properties_properties.vendido_tag_prop,
        properties_properties.nuevo_prop,
        (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
        properties_properties.alquilado_prop,
        properties_properties.reservado_prop,
        properties_properties.watermark_prop,
        properties_properties.aseos2_prop,
        properties_properties.precio_desde_prop,
        title_".$lang."_prop as metatitle
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
    WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND destacado_prop = 1 AND image_img != '' AND force_hide_prop != 1
    GROUP BY id_prop
    ORDER BY order_img, RAND()
    LIMIT 9
";
            </code>
        </pre>


        En 
        <pre>
            <code class="makefile">
/templates/templates/partials/slider-properties.tpl:55
            </code>
        </pre>

        Cambiar: 
        <pre>
            <code class="htmpl">
{$resource.province}
            </code>
        </pre>
        Por:
        <pre>
            <code class="htmpl">
{if $actCostas == 1 && $resource.costa != ''}  {$resource.costa} {else} {$resource.province} {/if}         
            </code>
        </pre>



        En 
        <pre>
            <code class="makefile">
/templates/templates/partials/buscador.tpl:66
            </code>
        </pre>


        Cambiar:
        <pre>
            <code class="html">

&lt;div class=&quot;col-lg-3&quot;&gt;
    &lt;div class=&quot;form-group mb-3 d-lg-none text-right&quot;&gt;
        {if $seccion != &#039;&#039;}
        &lt;a href=&quot;#&quot; class=&quot;responsive-search-button&quot;&gt;&lt;i class=&quot;fa fa-times&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/a&gt;
        {/if}
    &lt;/div&gt;

    &lt;div class=&quot;form-group mb-3&quot;&gt;
        &lt;select name=&quot;st[]&quot; id=&quot;st{$dupl}&quot; class=&quot;form-control select2&quot; multiple data-placeholder=&quot;{$lng_estado}&quot;&gt;
            {* &lt;option value=&quot;&quot;&gt;{$lng_estado}&lt;/option&gt; *}
            {section name=st loop=$status}
            {if $status[st].visible}
                &lt;option value=&quot;{$status[st].id}&quot; {if in_array($status[st].id, $smarty.get.st)}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
            {/if}
            {/section}
        &lt;/select&gt;

        {if $actCostasBuscador == 1}

            &lt;select name=&quot;coast[]&quot; id=&quot;coast{$dupl}&quot; class=&quot;form-control select2&quot; multiple data-placeholder=&quot;{$lng_costa}&quot;&gt;
                &lt;option value=&quot;&quot;&gt;{$lng_costa}&lt;/option&gt;
                {section name=lz loop=$coast}
                    {if $coast[lz].coast != &#039;&#039;}
                        &lt;option value=&quot;{$coast[lz].id}&quot; {if in_array($coast[lz].id, $smarty.get.coast)}selected{/if}&gt;{$coast[lz].coast}&lt;/option&gt;
                    {/if}
                {/section}
            &lt;/select&gt;

        {/if}
        
    &lt;/div&gt;

&lt;/div&gt;


            </code>
        </pre>
        Añadir:
        <pre>
            <code class="html">

&lt;div class=&quot;col-lg-3&quot;&gt;
    &lt;div class=&quot;form-group mb-3 d-lg-none text-right&quot;&gt;
        {if $seccion != &#039;&#039;}
        &lt;a href=&quot;#&quot; class=&quot;responsive-search-button&quot;&gt;&lt;i class=&quot;fa fa-times&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/a&gt;
        {/if}
    &lt;/div&gt;

    &lt;div class=&quot;form-group mb-3&quot;&gt;
        &lt;select name=&quot;st[]&quot; id=&quot;st{$dupl}&quot; class=&quot;form-control select2&quot; multiple data-placeholder=&quot;{$lng_estado}&quot;&gt;
            {* &lt;option value=&quot;&quot;&gt;{$lng_estado}&lt;/option&gt; *}
            {section name=st loop=$status}
            {if $status[st].visible}
                &lt;option value=&quot;{$status[st].id}&quot; {if in_array($status[st].id, $smarty.get.st)}selected{/if}&gt;{$status[st].sale}&lt;/option&gt;
            {/if}
            {/section}
        &lt;/select&gt;
    &lt;/div&gt;
&lt;/div&gt;
{if $actCostas == 1}
&lt;div class=&quot;col-lg-3&quot;&gt;
    &lt;div class=&quot;form-group mb-3&quot;&gt;        
        &lt;select name=&quot;coast[]&quot; id=&quot;coast{$dupl}&quot; class=&quot;form-control select2&quot; multiple data-placeholder=&quot;{$lng_costa}&quot;&gt;
            &lt;option value=&quot;&quot;&gt;{$lng_costa}&lt;/option&gt;
            {section name=lz loop=$coast}
                {if $coast[lz].coast != &#039;&#039;}
                    &lt;option value=&quot;{$coast[lz].id}&quot; {if in_array($coast[lz].id, $smarty.get.coast)}selected{/if}&gt;{$coast[lz].coast}&lt;/option&gt;
                {/if}
            {/section}
        &lt;/select&gt;
    &lt;/div&gt;
&lt;/div&gt;
{/if}

            </code>
        </pre>


        En 
        <pre>
            <code class="makefile">
/modules/properties/properties.php:487
            </code>
        </pre>

 Cambiar:
        <pre>
            <code class="sql">

$properties = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    properties_properties.descripcion_".$lang."_prop  as descr,
    properties_status.status_".$lang."_sta as sale,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.m2_balcon_prop as m2_balcon_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.aseos2_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.precio_desde_prop,
    title_".$lang."_prop as metatitle,
    (SELECT count(*) FROM properties_images WHERE properties_properties.id_prop = properties_images.property_img) as total_images
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

    $tableTags

WHERE  $secc

$pdh $p $lo $rf $ar $lc $typ $bd $bt $rp $nw $cs $sw $ep $po $cos $inl $rps $st $ven $alq $res $asc $m2ut $m2pl $ctr $lopr $loct $lozn $or $golf $prds $prhs $tags $features  $coast

GROUP BY id_prop

$o

LIMIT $cp, $tp

");

            </code>
        </pre>
        Por:
        <pre>
            <code class="sql">
$properties = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
    (SELECT coast_".$lang."_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
    properties_properties.descripcion_".$lang."_prop  as descr,
    properties_status.status_".$lang."_sta as sale,
    properties_properties.referencia_prop as ref,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.m2_balcon_prop as m2_balcon_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    id_prop,
    id_img,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.aseos2_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.precio_desde_prop,
    title_".$lang."_prop as metatitle,
    (SELECT count(*) FROM properties_images WHERE properties_properties.id_prop = properties_images.property_img) as total_images
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

    $tableTags

WHERE  $secc

$pdh $p $lo $rf $ar $lc $typ $bd $bt $rp $nw $cs $sw $ep $po $cos $inl $rps $st $ven $alq $res $asc $m2ut $m2pl $ctr $lopr $loct $lozn $or $golf $prds $prhs $tags $features  $coast

GROUP BY id_prop

$o

LIMIT $cp, $tp

");
            </code>
        </pre>


        En 
        <pre>
            <code class="makefile">
/modules/properties/partials/property-list.tpl:73
            </code>
        </pre>

        Cambiar: 
        <pre>
            <code class="htmpl">
{$resource.province}
            </code>
        </pre>
        Por:
        <pre>
            <code class="htmpl">
{if $actCostas == 1 && $resource.costa != ''}  {$resource.costa} {else} {$resource.province} {/if}         
            </code>
        </pre>




        En 
        <pre>
            <code class="makefile">
/modules/property/property.php:64
            </code>
        </pre>

 Cambiar:
        <pre>
            <code class="sql">
SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    properties_loc1.id_loc1 AS countryid,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS provinceid,
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS areaid,
    CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END AS townid,
    CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS typeid,
    properties_properties.lat_long_gp_prop AS lat,
    properties_properties.zoom_gp_prop AS zoom,
    properties_status.status_".$lang."_sta as sale,
    properties_status.slug_sta as saleSlug,
    properties_status.id_sta as saleId,
    properties_status.id_sta,
    properties_properties.m2_prop,
    properties_properties.m2_utiles_prop,
    properties_properties.m2_solarium_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.m2_balcon_prop as m2b_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.aseos2_prop,
    properties_properties.cocinas_prop,
    properties_properties.armarios_empotrados_prop,
    properties_properties.coeficiente_ocupacion_prop,
    properties_properties.plazas_garaje_prop,
    properties_properties.construccion_prop,
    properties_properties.ascensor_prop,
    properties_properties.energia_prop,
    properties_properties.user_prop,
    properties_properties.vista360_prop,
    precio_1_prop,
    precio_2_prop,
    precio_3_prop,
    precio_4_prop,
    precio_5_prop,
    precio_6_prop,
    precio_7_prop,
    precio_8_prop,
    precio_9_prop,
    precio_10_prop,
    precio_11_prop,
    precio_12_prop,
    entraga_date_prop,
    id_prop,
    id_img,
    alt_".$lang."_img as alt,
    properties_properties.titulo_".$lang."_prop as titulo,
    properties_properties.descripcion_".$lang."_prop as description,
    title_".$lang."_prop as metatitle,
    description_".$lang."_prop as metadescription,
    keywords_".$lang."_prop as metakeywords,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    (SELECT kitchen_".$lang."_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop ) AS cocinas_prop,
    (SELECT condition_".$lang."_cond FROM properties_condition WHERE id_cond = estado_prop ) AS estado_prop,
    (SELECT planta_".$lang."_plnt FROM properties_planta WHERE id_plnt = planta_prop ) AS planta_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.precio_desde_prop,
    distance_beach_prop,
    distance_airport_prop,
    distance_amenities_prop,
    distance_golf_prop,
    distance_beach_med_prop,
    distance_airport_med_prop,
    distance_amenities_med_prop,
    distance_golf_med_prop,
    suma_prop,
    gastos_prop,
    orientacion_prop,
    direccion_prop,
    show_direccion_prop,
    activado_prop

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

WHERE id_prop = '".simpleSanitize(($tokens[1]))."'

GROUP BY id_prop

            </code>
        </pre>
        Por:
        <pre>
            <code class="sql">
SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    properties_loc1.id_loc1 AS countryid,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS provinceid,
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS areaid,
    CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END AS townid,
    CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS typeid,
     CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
    (SELECT coast_".$lang."_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
    properties_properties.lat_long_gp_prop AS lat,
    properties_properties.zoom_gp_prop AS zoom,
    properties_status.status_".$lang."_sta as sale,
    properties_status.slug_sta as saleSlug,
    properties_status.id_sta as saleId,
    properties_status.id_sta,
    properties_properties.m2_prop,
    properties_properties.m2_utiles_prop,
    properties_properties.m2_solarium_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.m2_balcon_prop as m2b_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.aseos2_prop,
    properties_properties.cocinas_prop,
    properties_properties.armarios_empotrados_prop,
    properties_properties.coeficiente_ocupacion_prop,
    properties_properties.plazas_garaje_prop,
    properties_properties.construccion_prop,
    properties_properties.ascensor_prop,
    properties_properties.energia_prop,
    properties_properties.user_prop,
    properties_properties.vista360_prop,
    precio_1_prop,
    precio_2_prop,
    precio_3_prop,
    precio_4_prop,
    precio_5_prop,
    precio_6_prop,
    precio_7_prop,
    precio_8_prop,
    precio_9_prop,
    precio_10_prop,
    precio_11_prop,
    precio_12_prop,
    entraga_date_prop,
    id_prop,
    id_img,
    alt_".$lang."_img as alt,
    properties_properties.titulo_".$lang."_prop as titulo,
    properties_properties.descripcion_".$lang."_prop as description,
    title_".$lang."_prop as metatitle,
    description_".$lang."_prop as metadescription,
    keywords_".$lang."_prop as metakeywords,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.vendido_tag_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    (SELECT kitchen_".$lang."_kchn FROM properties_kitchen WHERE id_kchn = cocinas_prop ) AS cocinas_prop,
    (SELECT condition_".$lang."_cond FROM properties_condition WHERE id_cond = estado_prop ) AS estado_prop,
    (SELECT planta_".$lang."_plnt FROM properties_planta WHERE id_plnt = planta_prop ) AS planta_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.precio_desde_prop,
    distance_beach_prop,
    distance_airport_prop,
    distance_amenities_prop,
    distance_golf_prop,
    distance_beach_med_prop,
    distance_airport_med_prop,
    distance_amenities_med_prop,
    distance_golf_med_prop,
    suma_prop,
    gastos_prop,
    orientacion_prop,
    direccion_prop,
    show_direccion_prop,
    activado_prop

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

WHERE id_prop = '".simpleSanitize(($tokens[1]))."'

GROUP BY id_prop
            </code>
        </pre>

        Y en la linea 404 cambiar:
        <pre>
            <code class="sql">

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    properties_status.status_".$lang."_sta as sale,
    properties_properties.descripcion_".$lang."_prop  as descr,
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
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.aseos2_prop,
    properties_properties.precio_desde_prop,
    title_".$lang."_prop as metatitle

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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1

%s

AND id_prop != '".simpleSanitize(($tokens[1]))."'

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT 9

            </code>
        </pre>
        Por:
        <pre>
            <code class="sql">
SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
    (SELECT coast_".$lang."_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
    properties_status.status_".$lang."_sta as sale,
    properties_properties.descripcion_".$lang."_prop  as descr,
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
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
    properties_properties.watermark_prop,
    properties_properties.aseos2_prop,
    properties_properties.precio_desde_prop,
    title_".$lang."_prop as metatitle

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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND procesada_img = 1 AND force_hide_prop != 1

%s

AND id_prop != '".simpleSanitize(($tokens[1]))."'

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT 9
            </code>
        </pre>

        En:
        <pre>
            <code class="makefile">
/modules/news/new.php:234
            </code>
        </pre>
        Cambiar:
         <pre>
            <code class="sql">
$news = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.content_".$lang."_nws as contenido,
        news.titlew_".$lang."_nws as titulow,
        news.description_".$lang."_nws as contenidow,
        news.keywords_".$lang."_nws as keywords,
        news.tags_".$lang."_nws as tags,
        news.date_nws,
        news.quick_location_nws,
        news.quick_type_nws,
        news.quick_status_nws,
        news.quick_town_nws,
        news.quick_province_nws,
        quick_price_from_nws,
        quick_price_up_to_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_".$lang."_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 1

    AND id_nws = '".simpleSanitize(($tokens[1]))."'

    ORDER BY news.date_nws DESC

    LIMIT 1
");
            </code>
        </pre>
        Por:
                 <pre>
            <code class="sql">
$news = getRecords("

    SELECT news.id_nws,
        news.title_".$lang."_nws as titulo,
        news.content_".$lang."_nws as contenido,
        news.titlew_".$lang."_nws as titulow,
        news.description_".$lang."_nws as contenidow,
        news.keywords_".$lang."_nws as keywords,
        news.tags_".$lang."_nws as tags,
        news.date_nws,
        news.quick_location_nws,
        news.quick_type_nws,
        news.quick_status_nws,
        news.quick_town_nws,
        news.quick_province_nws,
        quick_costa_nws,
        quick_price_from_nws,
        quick_price_up_to_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
    (SELECT alt_".$lang."_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt

    FROM news

    WHERE news.title_".$lang."_nws  != '' AND news.content_".$lang."_nws != '' AND type_nws = 1

    AND id_nws = '".simpleSanitize(($tokens[1]))."'

    ORDER BY news.date_nws DESC

    LIMIT 1
");
            </code>
        </pre>
        En:
        <pre>
            <code class="makefile">
/modules/news/new.php:387
            </code>
        </pre>
        Añadir 
        <pre>
            <code class="php">
if ($news[0][&#039;quick_costa_nws&#039;] != &#039;&#039;) 
{
    $whereSQL .= &quot;AND (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END) = &#039;&quot;.simpleSanitize(($news[0][&#039;quick_costa_nws&#039;])).&quot;&#039;&quot;;
}
            </code>
        </pre>
        En:
        <pre>
            <code class="makefile">
/modules/news/new.php:394
            </code>
        </pre>

        Cambiar:
        <pre>
            <code class="sql">
$similares = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    properties_properties.lat_long_gp_prop AS lat,
    properties_status.status_".$lang."_sta as sale,
    properties_status.id_sta as saleId,
    properties_status.id_sta,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.construccion_prop,
    properties_properties.ascensor_prop,
    properties_properties.energia_prop,
    precio_1_prop,
    precio_2_prop,
    precio_3_prop,
    precio_4_prop,
    precio_5_prop,
    precio_6_prop,
    precio_7_prop,
    precio_8_prop,
    precio_9_prop,
    precio_10_prop,
    precio_11_prop,
    precio_12_prop,
    id_prop,
    id_img,
    alt_".$lang."_img as alt,
    properties_properties.descripcion_".$lang."_prop as descr,
    title_".$lang."_prop as metatitle,
    description_".$lang."_prop as metadescription,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0

$whereSQL

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT $cp, $tp

");
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$similares = getRecords("

SELECT

    properties_loc1.name_".$lang."_loc1 AS country,
    CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
    CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
    CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,
    CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
    CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id_costa,
    (SELECT coast_".$lang."_cst FROM properties_coast WHERE id_cst = id_costa LIMIT 1 ) AS costa,
    properties_properties.lat_long_gp_prop AS lat,
    properties_status.status_".$lang."_sta as sale,
    properties_status.id_sta as saleId,
    properties_status.id_sta,
    properties_properties.m2_prop,
    properties_properties.m2_parcela_prop as m2p_prop,
    properties_properties.precio_prop as old_precio,
    properties_properties.preci_reducidoo_prop as precio,
    properties_properties.habitaciones_prop,
    properties_properties.aseos_prop,
    properties_properties.construccion_prop,
    properties_properties.ascensor_prop,
    properties_properties.energia_prop,
    precio_1_prop,
    precio_2_prop,
    precio_3_prop,
    precio_4_prop,
    precio_5_prop,
    precio_6_prop,
    precio_7_prop,
    precio_8_prop,
    precio_9_prop,
    precio_10_prop,
    precio_11_prop,
    precio_12_prop,
    id_prop,
    id_img,
    alt_".$lang."_img as alt,
    properties_properties.descripcion_".$lang."_prop as descr,
    title_".$lang."_prop as metatitle,
    description_".$lang."_prop as metadescription,
    properties_properties.referencia_prop as ref,
    properties_properties.vendido_prop,
    properties_properties.nuevo_prop,
    (SELECT pool_".$lang."_pl FROM properties_pool WHERE id_pl = piscina_prop ) AS piscina_prop,
    (SELECT parking_".$lang."_prk FROM properties_parking WHERE id_prk = parking_prop ) AS parking_prop,
    properties_properties.alquilado_prop,
    properties_properties.reservado_prop,
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

WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1

$whereSQL

GROUP BY id_prop

ORDER BY order_img, RAND()

LIMIT $cp, $tp

");
            </code>
        </pre>

        En:
        <pre>
            <code class="makefile">
/modules/news/new.php:502
            </code>
        </pre>

        Cambiar:
        <pre>
            <code class="makefile">
if ($news[0][&#039;quick_location_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_province_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_town_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_type_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_status_nws&#039;] != &#039;&#039;) {
    $showSimils=1;
}
            </code>
        </pre>

        Por:
        <pre>
            <code class="makefile">
if ($news[0][&#039;quick_location_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_province_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_town_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_type_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_status_nws&#039;] != &#039;&#039; || $news[0][&#039;quick_costa_nws&#039;] != &#039;&#039;) {
    $showSimils=1;
}
            </code>
        </pre>

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Costas en Intramedianet
    </h6>
    <div class="card-body">
       
       En 
       <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php:69
/intramedianet/includes/resources/lang_en.php:71
/intramedianet/includes/resources/lang_en.php:595
            </code>
        </pre>
        Cambiar
        <pre>
            <code class="php">
$lang[&#039;Provincia&#039;] = &#039;Province/Coast&#039;;
$lang[&#039;Provincias&#039;] = &#039;Provinces/Coasts&#039;;
$lang[&#039;Mapear provincias&#039;] = &#039;Mapping provinces/coasts&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Provincia&#039;] = &#039;Province&#039;;
$lang[&#039;Provincias&#039;] = &#039;Provinces&#039;;
$lang[&#039;Mapear provincias&#039;] = &#039;Mapping provinces&#039;;
            </code>
        </pre>
        Y hacer lo mismo en 
         <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        En:
        <pre>
            <code class="makefile">
/intramedianet/properties/search-properties.php:232
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rscosta = &quot;SELECT id_cst, coast_&quot;.$lang_adm.&quot;_cst as costa FROM properties_coast WHERE coast_&quot;.$lang_adm.&quot;_cst IS NOT NULL ORDER BY coast_&quot;.$lang_adm.&quot;_cst ASC&quot;;
$rscosta = mysql_query($query_rscosta, $inmoconn) or die(mysql_error() . &#039;&lt;hr&gt;&#039; . $query_rscosta);
$row_rscosta = mysql_fetch_assoc($rscosta);
$totalRows_rscosta = mysql_num_rows($rscosta);
            </code>
        </pre>
         En:
        <pre>
            <code class="makefile">
/intramedianet/properties/search-properties.php:522
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot; properties_client&quot;, &quot;b_loc2_cli&quot; ) !=&#039;&#039; ) { ?&gt;error
        &lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;b_loc2_cli&quot; class=&quot;form-label&quot;&gt;
            &lt;?php __(&#039;Provincia&#039;); ?&gt;:&lt;/label&gt;
        &lt;div&gt;
            &lt;select name=&quot;b_loc2_cli[]&quot; id=&quot;b_loc2_cli&quot; multiple class=&quot;select2&quot;&gt;
                &lt;?php do {
            $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;b_loc2_cli&#039;]);
          ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rsparent2[&#039;id&#039;] ?&gt;&quot; &lt;?php if (in_array($row_rsparent2[&#039;id&#039;], $vals)) {echo &quot;SELECTED&quot; ;} ?&gt;&gt;
                    &lt;?php echo $row_rsparent2[&#039;name&#039;] ?&gt;
                &lt;/option&gt;
                &lt;?php } while ($row_rsparent2 = mysql_fetch_assoc($rsparent2)); ?&gt;
            &lt;/select&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_loc2_cli&quot;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre> 
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actCostas == 1): ?&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot; properties_client&quot;, &quot;b_coast_cli&quot; ) !=&#039;&#039; ) { ?&gt;error
        &lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;b_coast_cli&quot; class=&quot;form-label&quot;&gt;
            &lt;?php __(&#039;Costa&#039;); ?&gt;:&lt;/label&gt;
        &lt;div&gt;
            &lt;select name=&quot;b_coast_cli[]&quot; id=&quot;b_coast_cli&quot; multiple class=&quot;select2&quot;&gt;
                &lt;?php do {
            $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;b_costa_cli&#039;]);
          ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rscosta[&#039;id_cst&#039;]?&gt;&quot; &lt;?php if (in_array($row_rscosta[&#039;id_cst&#039;], $vals)) {echo &quot;SELECTED&quot; ;} ?&gt;&gt;
                    &lt;?php echo $row_rscosta[&#039;costa&#039;] ?&gt;
                &lt;/option&gt;
                &lt;?php } while ($row_rscosta = mysql_fetch_assoc($rscosta)); ?&gt;
            &lt;/select&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_coast_cli&quot;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php else:?&gt;
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot; properties_client&quot;, &quot;b_loc2_cli&quot; ) !=&#039;&#039; ) { ?&gt;error
        &lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;b_loc2_cli&quot; class=&quot;form-label&quot;&gt;
            &lt;?php __(&#039;Provincia&#039;); ?&gt;:&lt;/label&gt;
        &lt;div&gt;
            &lt;select name=&quot;b_loc2_cli[]&quot; id=&quot;b_loc2_cli&quot; multiple class=&quot;select2&quot;&gt;
                &lt;?php do {
            $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;b_loc2_cli&#039;]);
          ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rsparent2[&#039;id&#039;] ?&gt;&quot; &lt;?php if (in_array($row_rsparent2[&#039;id&#039;], $vals)) {echo &quot;SELECTED&quot; ;} ?&gt;&gt;
                    &lt;?php echo $row_rsparent2[&#039;name&#039;] ?&gt;
                &lt;/option&gt;
                &lt;?php } while ($row_rsparent2 = mysql_fetch_assoc($rsparent2)); ?&gt;
            &lt;/select&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_loc2_cli&quot;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php endif ?&gt;
            </code>
        </pre> 

                 
        En:
        <pre>
            <code class="makefile">
/intramedianet/properties/search-client-data-search.php:366
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
  $coast = '';
  if( isset($_GET['b_coast_cli']) && $_GET['b_coast_cli'] != '' )
  {
      $costa = implode(',', $_GET['b_coast_cli']);
      if ($costa != '') 
      {
          $coast = "AND (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END IN (" . $costa . ") ) ";  
      }
  }
            </code>
        </pre>
        En:
        <pre>
            <code class="makefile">
/intramedianet/properties/search-client-data-search.php:558
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
  $nprop = '';
  if( !isset($_GET['b_sale_cli']) && !isset($_GET['b_type_cli']) && $_GET['b_beds_cli'] == '' && $_GET['or'] == '' && $_GET['b_orientacion_cli'] == '' && $_GET['favs'] == '' && $_GET['b_baths_cli'] == ''  && !isset($_GET['b_ref_cli']) && $_GET['b_precio_desde_cli'] == ''  && $_GET['b_precio_hasta_cli'] == ''  && !isset($_GET['b_loc1_cli'])  && !isset($_GET['b_loc2_cli'])  && !isset($_GET['b_loc3_cli'])  && !isset($_GET['b_loc4_cli'])  && !isset($_GET['b_opciones_cli'])  && !isset($_GET['b_opciones2_cli']) && !isset($_GET['b_tags_cli'])  && $_GET['nw'] == '' && $_GET['ven'] == '' && $_GET['alq'] == '' && $_GET['res'] == ''  && $_GET['rp'] == '' && $_GET['cs'] == '' && $_GET['sw'] == '' && $_GET['ep'] == '' && $_GET['po'] == '' && $_GET['rps'] == ''  && $_GET['direccion'] == ''  && $_GET['m2ut'] == ''  && $_GET['m2pl'] == '' && $_GET['palabras_clave'] == '' && $_GET['piscina_prop'] == ''  && $_GET['parking_prop'] == '' && $_GET['atendido_por_prop'] == '' && $_GET['captado_prop'] == '' ){
    $nprop = "AND id_prop = ''";
  }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
  $nprop = '';
  if( !isset($_GET['b_sale_cli']) && !isset($_GET['b_type_cli']) && $_GET['b_beds_cli'] == '' && $_GET['or'] == '' && $_GET['b_orientacion_cli'] == '' && $_GET['favs'] == '' && $_GET['b_baths_cli'] == ''  && !isset($_GET['b_ref_cli']) && $_GET['b_precio_desde_cli'] == ''  && $_GET['b_precio_hasta_cli'] == ''  && !isset($_GET['b_loc1_cli'])  && !isset($_GET['b_loc2_cli'])  && !isset($_GET['b_loc3_cli'])  && !isset($_GET['b_loc4_cli']) && !isset($_GET['b_coast_cli'])  && !isset($_GET['b_opciones_cli'])  && !isset($_GET['b_opciones2_cli']) && !isset($_GET['b_tags_cli'])  && $_GET['nw'] == '' && $_GET['ven'] == '' && $_GET['alq'] == '' && $_GET['res'] == ''  && $_GET['rp'] == '' && $_GET['cs'] == '' && $_GET['sw'] == '' && $_GET['ep'] == '' && $_GET['po'] == '' && $_GET['rps'] == ''  && $_GET['direccion'] == ''  && $_GET['m2ut'] == ''  && $_GET['m2pl'] == '' && $_GET['palabras_clave'] == '' && $_GET['piscina_prop'] == ''  && $_GET['parking_prop'] == '' && $_GET['atendido_por_prop'] == '' && $_GET['captado_prop'] == '' ){
    $nprop = "AND id_prop = ''";
  }
            </code>
        </pre>

        y en:
        <pre>
            <code class="makefile">
/intramedianet/properties/search-client-data-search.php:623
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
$distBeach $distAmenit $distAirport $distGolf $coast
            </code>
        </pre>
        Ejecutar la query:
        <pre>
            <code class="php">
ALTER TABLE `news` ADD `quick_costa_nws` MEDIUMTEXT NULL AFTER `quick_tags_nws`;
            </code>
        </pre>
Reemplazar por el del máster:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-form.php
/intramedianet/news/news-form.php
            </code>
        </pre>

        Ejecutar la SQL:
        <pre>
            <code class="sql">
ALTER TABLE `properties_client` ADD `b_costa_cli` MEDIUMTEXT NULL DEFAULT NULL AFTER `b_loc4_cli`;
            </code>
        </pre>
        En:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:334
            </code>
        </pre>
        Añadir
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rscosta = &quot;SELECT id_cst, coast_&quot;.$lang_adm.&quot;_cst as costa FROM properties_coast WHERE coast_&quot;.$lang_adm.&quot;_cst IS NOT NULL ORDER BY coast_&quot;.$lang_adm.&quot;_cst ASC&quot;;
$rscosta = mysql_query($query_rscosta, $inmoconn) or die(mysql_error() . &#039;&lt;hr&gt;&#039; . $query_rscosta);
$row_rscosta = mysql_fetch_assoc($rscosta);
$totalRows_rscosta = mysql_num_rows($rscosta);
            </code>
        </pre>
        En:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:474
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
if (isset($_POST[&#039;b_costa_cli&#039;]) &amp;&amp; $_POST[&#039;b_costa_cli&#039;] != &#039;&#039; ) {
  $_POST[&#039;b_costa_cli&#039;] = implode(&#039;,&#039;, $_POST[&#039;b_costa_cli&#039;]);
}
            </code>
        </pre>
        En los insert añadir:
        <pre>
            <code class="php"> 
if ($actCostas == 1) 
{
  $ins_properties_client-&gt;addColumn(&quot;b_costa_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_costa_cli&quot;);
}
            </code>
        </pre>
        Y en los updates añadir:
        <pre>
            <code class="php">
if ($actCostas == 1) 
{
    $upd_properties_client-&gt;addColumn(&quot;b_costa_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_costa_cli&quot;);
}
            </code>
        </pre>
        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1759
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="html">
&lt;?php if($actCostas == 1):?&gt;
&lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_costa_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
  &lt;label for=&quot;b_costa_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Costa&#039;); ?&gt;:&lt;/label&gt;
  &lt;select name=&quot;b_costa_cli[]&quot; id=&quot;b_costa_cli&quot; multiple class=&quot;select2&quot;&gt;
    &lt;?php do {
      $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;b_costa_cli&#039;]);
    ?&gt;
    &lt;option value=&quot;&lt;?php echo $row_rscosta[&#039;id_cst&#039;]?&gt;&quot; &lt;?php if (in_array($row_rscosta[&#039;id_cst&#039;], $vals)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;
      &lt;?php echo $row_rscosta[&#039;costa&#039;]?&gt; 
    &lt;/option&gt;
    &lt;?php } while ($row_rscosta = mysql_fetch_assoc($rscosta)); ?&gt;
  &lt;/select&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_costa_cli&quot;); ?&gt;
&lt;/div&gt;
&lt;?php endif?&gt;
            </code>
        </pre>

         En 
        <pre>
            <code class="makefile">
/intramedianet/properties/js/clients-form.js:503
            </code>
        </pre>
        Añadir
        <pre>
            <code class="html">
$(&quot;#b_costa_cli&quot;).change(function(e) {
  var val = $(this).val();
  $.get(&quot;/modules/search/coasts.php?coast=&quot; + val + &quot;&amp;lang=&quot; + appLang, function(data) {
    if(data != &#039;&#039;) {
        $(&#039;#b_loc3_cli&#039;).html(data).change();
    }
  });
});
            </code>
        </pre>

        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:414
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$coast = '';
if( isset($_GET['b_costa_cli']) && $_GET['b_costa_cli'] != '' )
{
  $costa = implode(',', $_GET['b_costa_cli']);
  if ($costa != '') 
  {
      $coast = "AND (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END IN (" . $costa . ") ) ";  
  }
}
            </code>
        </pre>

        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:558
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
  if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] == &#039;&#039;       ){
    $nprop = &quot;AND id_prop = &#039;&#039;&quot;;
  }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
 if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_costa_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] == &#039;&#039;       ){
    $nprop = &quot;AND id_prop = &#039;&#039;&quot;;
  }
            </code>
        </pre>

        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:650
            </code>
        </pre>
        Cambiar 
        <pre>
            <code class="php">
  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.referencia_prop,
      properties_status.status_" .$lang_adm. "_sta,
      CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS types_" .$lang_adm. "_typ,
      CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS name_" .$lang_adm. "_loc3,
      CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS name_" .$lang_adm. "_loc4,
      preci_reducidoo_prop,
      case properties_properties.activado_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as activado_prop,
      properties_properties.id_prop,
      properties_properties.id_prop as id_prop2,
      properties_properties.id_prop as image_img,
      CONCAT_WS(' ', nombre_pro, apellidos_pro) as nombre_pro,
      CONCAT_WS('<br>', telefono_fijo_pro, telefono_movil_pro) as telefono_fijo_pro
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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
      $opjoin
      $opjoin2
      $tagjoin

    $sWhere
    $retQRY
    $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $tags $pool $parking $palabras_clave
    $distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph

      AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

GROUP BY id_prop

    $sOrder
    $sLimit
  ";
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
 $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
      properties_properties.referencia_prop,
      properties_status.status_" .$lang_adm. "_sta,
      CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS types_" .$lang_adm. "_typ,
      CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS name_" .$lang_adm. "_loc3,
      CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS name_" .$lang_adm. "_loc4,
      preci_reducidoo_prop,
      case properties_properties.activado_prop
          when '1' then '". __('Sí', true) . "'
          when '0' then '" . __('No', true) . "'
      end as activado_prop,
      properties_properties.id_prop,
      properties_properties.id_prop as id_prop2,
      properties_properties.id_prop as image_img,
      CONCAT_WS(' ', nombre_pro, apellidos_pro) as nombre_pro,
      CONCAT_WS('<br>', telefono_fijo_pro, telefono_movil_pro) as telefono_fijo_pro
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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
      $opjoin
      $opjoin2
      $tagjoin

    $sWhere
    $retQRY
    $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $tags $pool $parking $palabras_clave
    $distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph $coast

      AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

GROUP BY id_prop

    $sOrder
    $sLimit
  ";
            </code>
        </pre>

        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:387
            </code>
        </pre>
        Añadir
        <pre>
            <code class="php">
$coast = &#039;&#039;;
if( isset($_GET[&#039;b_costa_cli&#039;]) &amp;&amp; $_GET[&#039;b_costa_cli&#039;] != &#039;&#039; )
{
  $costa = implode(&#039;,&#039;, $_GET[&#039;b_costa_cli&#039;]);
  if ($costa != &#039;&#039;) 
  {
      $coast = &quot;AND (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END IN (&quot; . $costa . &quot;) ) &quot;;  
  }
}
            </code>
        </pre>

        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:554
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
  if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_direcc_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_urb_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_piscina_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_garaje_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_vistasmar_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_obranueva_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] == &#039;&#039;){
    $nprop = &quot;AND id_prop = &#039;&#039;&quot;;
  }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
  if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_costa_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_direcc_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_urb_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_piscina_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_garaje_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_vistasmar_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_obranueva_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] == &#039;&#039;){
    $nprop = &quot;AND id_prop = &#039;&#039;&quot;;
  }
            </code>
        </pre>

        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:587
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">

  if( !isset($_GET[&#039;b_sale_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ocultos_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_direcc_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_obranueva_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] == &#039;&#039;){
    $nprop = &quot;AND id_prop = &#039;&#039;&quot;;
  }

            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
  if( !isset($_GET[&#039;b_sale_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ocultos_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_costa_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_direcc_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_obranueva_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2_hasta_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_desde_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_m2p_hasta_cli&#039;] == &#039;&#039;){
    $nprop = &quot;AND id_prop = &#039;&#039;&quot;;
  }
            </code>
        </pre>

        En 
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:658
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
    properties_properties.referencia_prop,
    properties_status.status_" .$lang_adm. "_sta,
    CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS types_" .$lang_adm. "_typ,
    CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS name_" .$lang_adm. "_loc3,
    CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS name_" .$lang_adm. "_loc4,
    preci_reducidoo_prop,
    case properties_properties.activado_prop
        when '1' then '". __('Sí', true) . "'
        when '0' then '" . __('No', true) . "'
    end as activado_prop,
    properties_properties.id_prop,
    properties_properties.id_prop as image_img,
    CONCAT(nombre_pro, ' ', apellidos_pro) as nombre_pro,
    CONCAT(telefono_fijo_pro, '<br>', telefono_movil_pro) as telefono_fijo_pro
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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
      $opjoin
      $opjoin2

    $sWhere
    $retQRY
    $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $dirr $urb $pisc2 $gargg $vismarr $obrnws $pool $parking
    $distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph

AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

GROUP BY id_prop

    $sOrder
    $sLimit
  ";
            </code>
        </pre>

        Por: 

        <pre>
            <code class="php">
  $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS
    properties_properties.referencia_prop,
    properties_status.status_" .$lang_adm. "_sta,
    CASE WHEN properties_types.types_" .$lang_adm. "_typ IS NOT NULL THEN properties_types.types_" .$lang_adm. "_typ ELSE types.types_" .$lang_adm. "_typ END AS types_" .$lang_adm. "_typ,
    CASE WHEN properties_loc3.name_" .$lang_adm. "_loc3 IS NOT NULL THEN properties_loc3.name_" .$lang_adm. "_loc3 ELSE areas1.name_" .$lang_adm. "_loc3  END AS name_" .$lang_adm. "_loc3,
    CASE WHEN properties_loc4.name_" .$lang_adm. "_loc4 IS NOT NULL THEN properties_loc4.name_" .$lang_adm. "_loc4 ELSE towns.name_" .$lang_adm. "_loc4  END AS name_" .$lang_adm. "_loc4,
    preci_reducidoo_prop,
    case properties_properties.activado_prop
        when '1' then '". __('Sí', true) . "'
        when '0' then '" . __('No', true) . "'
    end as activado_prop,
    properties_properties.id_prop,
    properties_properties.id_prop as image_img,
    CONCAT(nombre_pro, ' ', apellidos_pro) as nombre_pro,
    CONCAT(telefono_fijo_pro, '<br>', telefono_movil_pro) as telefono_fijo_pro
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
    LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
    LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
    LEFT OUTER JOIN properties_owner ON properties_properties.owner_prop = properties_owner.id_pro
      $opjoin
      $opjoin2

    $sWhere
    $retQRY
    $st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $dirr $urb $pisc2 $gargg $vismarr $obrnws $pool $parking
    $distBeach $distAmenit $distAirport $distGolf $m2d $m2h $m2pd $m2ph $coast

AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1

GROUP BY id_prop

    $sOrder
    $sLimit
  ";
            </code>
        </pre>

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Eventos
    </h6>
    <div class="card-body">

        Añadir al proyecto las siguientes carpetas del máster:

        <pre>
            <code class="makefile">
/modules/events/
/intramedianet/events/
            </code>
        </pre>
       
        Ejecutar cada query:
        <pre>
            <code class="sql">
ALTER TABLE `news`  ADD `location_ca_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `quick_tags_nws`,  ADD `location_da_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_ca_nws`,  ADD `location_de_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_da_nws`,  ADD `location_en_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_de_nws`,  ADD `location_es_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_en_nws`,  ADD `location_fi_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_es_nws`,  ADD `location_fr_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_fi_nws`,  ADD `location_is_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_fr_nws`,  ADD `location_nl_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_is_nws`,  ADD `location_no_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_nl_nws`,  ADD `location_ru_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_no_nws`,  ADD `location_se_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_ru_nws`,  ADD `location_zh_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_se_nws`,  ADD `location_pl_nws` MEDIUMTEXT NULL DEFAULT NULL  AFTER `location_zh_nws`;
            </code>
        </pre>
        <pre>
            <code class="sql">
ALTER TABLE `news`  ADD `typevent_nws` TINYINT NOT NULL DEFAULT '0'  AFTER `location_pl_nws`;
ALTER TABLE `news` ADD `finished_nws` INT(1) NOT NULL DEFAULT '0' AFTER `typevent_nws`;
            </code>
        </pre>
        <pre>
            <code class="sql">
ALTER TABLE `news_fotos` ADD `destacada_img` INT(1) NOT NULL DEFAULT '0' AFTER `orden_img`;
ALTER TABLE `news_fotos` ADD `mobile_img` INT(1) NOT NULL DEFAULT '0' AFTER `destacada_img`;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/secciones.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Eventos */
/*--------------------------------------------------------------------------
|
| Activar eventos
| 0 - Desactivado
| 1 - Activado
|
*/
$actEventos = 0;

            </code>
        </pre>

        En el archivo:
        <pre>
intramedianet/includes/inc.sidebar.php:592
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
preg_match(&#039;/\/banner\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/team\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/testimonials\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/traducciones/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/news\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
preg_match(&#039;/\/banner\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/team\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/testimonials\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/traducciones/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/news\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || 
preg_match(&#039;/\/events\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
intramedianet/includes/inc.sidebar.php:592
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;?php if ($actTradduccions == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/translate/traducciones.php?lang=&lt;?php echo $language ?&gt;&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/traducciones/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Traducciones&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
&lt;?php if ($actTradduccions == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/translate/traducciones.php?lang=&lt;?php echo $language ?&gt;&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/traducciones/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Traducciones&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
&lt;?php if ($actEventos == 1): ?&gt;
    &lt;li class=&quot;nav-item&quot;&gt;
        &lt;a href=&quot;/intramedianet/events/news.php?lang=&lt;?php echo $language ?&gt;&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/events/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Eventos&#039;); ?&gt;&lt;/a&gt;
    &lt;/li&gt;
 &lt;?php endif ?&gt;
            </code>
        </pre>
        En intramedianet/includes/resources/lang_es.php
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Foto de principal&#039;] = &#039;Foto de principal&#039;;
$lang[&#039;Evento Finalizado&#039;] = &#039;Evento Finalizado&#039;;
$lang[&#039;Tipo de evento&#039;] = &#039;Tipo de evento&#039;;
$lang[&#039;Presencial&#039;] = &#039;Presencial&#039;;
$lang[&#039;Evento&#039;] = &#039;Evento&#039;;
$lang[&#039;Se puede seleccionar una foto principal para el listado y cabecera en la web marc&aacute;ndola con el check de Imagen Principal pinchando el bot&oacute;n de editar&#039;] = &#039;Se puede seleccionar una foto principal para el listado y cabecera en la web marc&aacute;ndola con el check de Imagen Principal pinchando el bot&oacute;n de editar&#039;;
$lang[&#039;En caso contrario se usar&aacute; la primera foto de la galer&iacute;a&#039;] = &#039;En caso contrario se usar&aacute; la primera foto de la galer&iacute;a&#039;;
$lang[&#039;M&oacute;vil&#039;] = &#039;M&oacute;vil&#039;;
            </code>
        </pre>
        y en intramedianet/includes/resources/lang_en.php
        <pre>
            <code class="php">
$lang[&#039;Foto de principal&#039;] = &#039;Main photo&#039;;
$lang[&#039;Evento Finalizado&#039;] = &#039;Event Finished&#039;;
$lang[&#039;Tipo de evento&#039;] = &#039;Type of event&#039;;
$lang[&#039;Presencial&#039;] = &#039;In-Person&#039;;
$lang[&#039;Evento&#039;] = &#039;Event&#039;;
$lang[&#039;Se puede seleccionar una foto principal para el listado y cabecera en la web marc&aacute;ndola con el check de Imagen Principal pinchando el bot&oacute;n de editar&#039;] = &#039;You can select a main photo for the listing and header on the website by marking it with the Main Image check by clicking the edit button&#039;;
$lang[&#039;En caso contrario se usar&aacute; la primera foto de la galer&iacute;a&#039;] = &#039;Otherwise, the first photo of the gallery will be used&#039;;
$lang[&#039;M&oacute;vil&#039;] = &#039;Mobile&#039;;
            </code>
        </pre>
        En resources/urls.php añadir:
        <pre>
            <code class="php">
$urlStr[&quot;events&quot;] = array(
    &#039;ca&#039; =&gt; &#039;esdeveniments&#039;,
    &#039;da&#039; =&gt; &#039;begivenheder&#039;,
    &#039;de&#039; =&gt; &#039;veranstaltungen&#039;,
    &#039;en&#039; =&gt; &#039;events&#039;,
    &#039;es&#039; =&gt; &#039;eventos&#039;,
    &#039;fi&#039; =&gt; &#039;tapahtumat&#039;,
    &#039;fr&#039; =&gt; &#039;evenements&#039;,
    &#039;is&#039; =&gt; &#039;vidburdir&#039;,
    &#039;nl&#039; =&gt; &#039;evenementen&#039;,
    &#039;no&#039; =&gt; &#039;arrangementer&#039;,
    &#039;ru&#039; =&gt; &#039;sobytiya&#039;,
    &#039;se&#039; =&gt; &#039;handelser&#039;,
    &#039;pl&#039; =&gt; &#039;wydarzenia&#039;,
    &#039;ct&#039; =&gt; &#039;esdeveniments&#039;,
    &#039;zh&#039; =&gt; &#039;shi-jian&#039;,
    &#039;mostrar-en-sitemap&#039; =&gt; &#039;0&#039;
);
            </code>
        </pre>
        Añadir página foto-texto para Eventos:
        <pre>
            <code class="sql">
INSERT INTO `news` ( `categoria_nws`, `title_ca_nws`, `title_da_nws`, `title_de_nws`, `title_en_nws`, `title_es_nws`, `title_fi_nws`, `title_fr_nws`, `title_is_nws`, `title_nl_nws`, `title_no_nws`, `title_ru_nws`, `title_se_nws`, `title_zh_nws`, `title_pl_nws`, `content_ca_nws`, `content_da_nws`, `content_de_nws`, `content_en_nws`, `content_es_nws`, `content_fi_nws`, `content_fr_nws`, `content_is_nws`, `content_nl_nws`, `content_no_nws`, `content_ru_nws`, `content_se_nws`, `content_zh_nws`, `content_pl_nws`, `date_nws`, `type_nws`, `titlew_ca_nws`, `titlew_da_nws`, `titlew_de_nws`, `titlew_en_nws`, `titlew_es_nws`, `titlew_fi_nws`, `titlew_fr_nws`, `titlew_is_nws`, `titlew_nl_nws`, `titlew_no_nws`, `titlew_ru_nws`, `titlew_se_nws`, `titlew_zh_nws`, `titlew_pl_nws`, `description_ca_nws`, `description_da_nws`, `description_de_nws`, `description_en_nws`, `description_es_nws`, `description_fi_nws`, `description_fr_nws`, `description_is_nws`, `description_nl_nws`, `description_no_nws`, `description_ru_nws`, `description_se_nws`, `description_zh_nws`, `description_pl_nws`, `keywords_ca_nws`, `keywords_da_nws`, `keywords_de_nws`, `keywords_en_nws`, `keywords_es_nws`, `keywords_fi_nws`, `keywords_fr_nws`, `keywords_is_nws`, `keywords_nl_nws`, `keywords_no_nws`, `keywords_ru_nws`, `keywords_se_nws`, `keywords_zh_nws`, `keywords_pl_nws`, `featured_properties_nws`, `quick_location_nws`, `quick_type_nws`, `quick_status_nws`, `quick_town_nws`, `quick_province_nws`, `direccion_gp_prop`, `lat_long_gp_prop`, `zoom_gp_prop`, `zonas_nws`, `activate_nws`, `destacado_nws`, `tags_ca_nws`, `tags_da_nws`, `tags_de_nws`, `tags_en_nws`, `tags_es_nws`, `tags_fi_nws`, `tags_fr_nws`, `tags_is_nws`, `tags_nl_nws`, `tags_no_nws`, `tags_ru_nws`, `tags_se_nws`, `tags_zh_nws`, `tags_pl_nws`, `quick_price_from_nws`, `quick_price_up_to_nws`, `quick_features_nws`, `quick_tags_nws`, `location_ca_nws`, `location_da_nws`, `location_de_nws`, `location_en_nws`, `location_es_nws`, `location_fi_nws`, `location_fr_nws`, `location_is_nws`, `location_nl_nws`, `location_no_nws`, `location_ru_nws`, `location_se_nws`, `location_zh_nws`, `location_pl_nws`, `typevent_nws`, `finished_nws`)
VALUES
    (0, NULL, NULL, NULL, 'Events', 'Eventos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-06 15:05:08', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
index.php:201
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;texto_formularios_GDPR&quot;, $texto_formularios_GDPR);
            </code>
        </pre>
        Por
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;texto_formularios_GDPR&quot;, $texto_formularios_GDPR);
$smarty-&gt;assign(&quot;actEventos&quot;, $actEventos);
            </code>
        </pre>
        En el switch del index.php añadir:
        <pre>
            <code class="php">
case $urlStr[&#039;events&#039;][&#039;url&#039;]:
    if ($tokens[3] == &#039;&#039; &amp;&amp; $tokens[2] != $urlStr[&#039;category&#039;][&#039;url&#039;] &amp;&amp; $tokens[2] != &#039;&#039;) {
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/events/new.php&#039;);
        $smarty-&gt;display(&#039;modules/events/view/new.tpl&#039;);
    } else {
        $numpag = 31;
        $smarty-&gt;assign(&quot;addCanonical&quot;, 1);
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/pages/pages.php&#039;);
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/events/news.php&#039;);
        $smarty-&gt;display(&#039;modules/events/view/index.tpl&#039;);
    }
break;                
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/menu.tpl :201
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="html">
{if $actEventos == 1}
&lt;li {if $submenu == 1}class=&quot;list-inline-item{if $seccion == {$url_events}} active{/if}&quot;{else}{if $seccion == &#039;&#039;}class=&quot;active&quot;{/if}{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_events}/&quot;&gt;{$lng_eventos}&lt;/a&gt;&lt;/li&gt;
{/if}
            </code>
        </pre>

        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js
            </code>
        </pre>
        Añadir y compilar:
        <pre>
            <code class="php">

//  ================================================================
//  /* @group EVENTOS  */
//  ================================================================

$(&quot;.toEventForm&quot;).click(function() 
{
  $(&#039;html, body&#039;).animate({
      scrollTop: $(&quot;#eventForm&quot;).offset().top - 100
  }, 600);
});


$(&#039;#contactFormEvent&#039;).submit(function(e) {

e.preventDefault();

if ($(this).valid()) {

    $(this).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

    $.get(&quot;/modules/events/send.php?&quot; + $(this).serialize()).done(function(data) {
        if (data == &#039;ok&#039;) {

            $(&#039;#contactFormEvent input[type=text], #contactFormEvent textarea&#039;).val(&#039;&#039;);
            $(&#039;#contactFormEvent input[type=checkbox]&#039;).removeAttr(&#039;checked&#039;);
            $(&#039;#contactFormEvent .loading&#039;).remove();
            swal(&#039;&#039;, okConsult, &#039;success&#039;);
            $(&#039;#quotePureModal .close&#039;).click();
            gtag(&#039;event&#039;, &#039;evento&#039;, { &#039;event_category&#039;: &#039;Contact Form&#039;, &#039;event_action&#039;: &#039;Contact&#039;, &#039;event_label&#039;: &#039;eventos&#039; });
        }
    });
}
});
            </code>
        </pre>
Añadir las traducciones en resources/lang_es.php y lang_en.php (traducir el resto de idiomas o pillarlo directamente del máster 107):
<pre>
    <code class="php">
$langStr[&quot;Presencial&quot;] = &quot;In Person&quot;;
$langStr[&quot;Finalizado&quot;] = &quot;Finished&quot;;
$langStr[&quot;Reservar una cita&quot;] = &quot;Book an appointment&quot;;
$langStr[&quot;Descripci&oacute;n Corta&quot;] = &quot;Short description&quot;;
$langStr[&quot;Eventos&quot;] = &quot;Events&quot;;
$langStr[&quot;When do you plan to buy?&quot;] = &quot;When do you plan to buy?&quot;;
$langStr[&quot;What is the house for?&quot;] = &quot;What is the house for?&quot;;
$langStr[&quot;Approximade Budget&quot;] = &quot;Approximade Budget&quot;;
$langStr[&quot;Type of house&quot;] = &quot;Type of house&quot;;
$langStr[&quot;Where&quot;] = &quot;Where&quot;;
    </code>
</pre>
<pre>
    <code class="php">
$langStr[&quot;Presencial&quot;] = &quot;Presencial&quot;;
$langStr[&quot;Finalizado&quot;] = &quot;Finalizado&quot;;
$langStr[&quot;Reservar una cita&quot;] = &quot;Reservar una cita&quot;;
$langStr[&quot;Descripci&oacute;n Corta&quot;] = &quot;Descripci&oacute;n Corta&quot;;
$langStr[&quot;Reservar ahora&quot;] = &quot;Reservar ahora&quot;;
$langStr[&quot;Eventos&quot;] = &quot;Eventos&quot;;
$langStr[&quot;When do you plan to buy?&quot;] = &quot;&iquest;Cu&aacute;ndo planeas comprar?&quot;;
$langStr[&quot;What is the house for?&quot;] = &quot;&iquest;Para qu&eacute; es la casa?&quot;;
$langStr[&quot;Approximade Budget&quot;] = &quot;Presupuesto aproximado&quot;;
$langStr[&quot;Type of house&quot;] = &quot;Tipo de casa&quot;;
$langStr[&quot;Where&quot;] = &quot;&iquest;D&oacute;nde?&quot;;
    </code>
</pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadir Costas a Guardar Búsquedas
    </h6>
    <div class="card-body">
       
        <p>
             Se ha añadido las costas a Guardar búsquedas
        </p>
        


        <p>
            Reemplazar los archivos por los nuevos:
        </p>
        <pre>
            <code class="makefile">
/modules/login/usr-search.php 
/modules/login/view/usr-search.tpl
            </code>
        </pre>

        En:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:991
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function getTypeProv($id) {
  global $lang_adm;
  $return = getRecords(&quot;
      SELECT
          name_&quot; . $lang_adm . &quot;_loc2 as ret
      FROM properties_loc2
      WHERE id_loc2 = &#039;&quot; . $id . &quot;&#039;
  &quot;);
  return $return[0][&#039;ret&#039;];
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function getTypeProv($id) {
  global $lang_adm;
  $return = getRecords(&quot;
      SELECT
          name_&quot; . $lang_adm . &quot;_loc2 as ret
      FROM properties_loc2
      WHERE id_loc2 = &#039;&quot; . $id . &quot;&#039;
  &quot;);
  return $return[0][&#039;ret&#039;];
}
function getCoast($id) {
      global $lang_adm;
      $return = getRecords(&quot;
          SELECT
              coast_&quot; . $lang_adm . &quot;_cst as ret
          FROM properties_coast
          WHERE id_cst = &#039;&quot; . $id . &quot;&#039;
      &quot;);
      return $return[0][&#039;ret&#039;];
}

            </code>
        </pre>

        En:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2780
            </code>
        </pre>

        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($key == &#039;lopr&#039;): ?&gt;
    &lt;li class=&quot;list-group-item&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Provincia&#039;) ?&gt;:&lt;/b&gt;
      &lt;?php foreach ($value as $k =&gt; $type): ?&gt;&lt;?php if ($k &gt; 0): ?&gt;, &lt;?php endif ?&gt;&lt;?php echo getTypeProv($type) ?&gt;&lt;?php endforeach ?&gt;
    &lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">

&lt;?php if ($key == &#039;lopr&#039;): ?&gt;
    &lt;li class=&quot;list-group-item&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Provincia&#039;) ?&gt;:&lt;/b&gt;
      &lt;?php foreach ($value as $k =&gt; $type): ?&gt;&lt;?php if ($k &gt; 0): ?&gt;, &lt;?php endif ?&gt;&lt;?php echo getTypeProv($type) ?&gt;&lt;?php endforeach ?&gt;
    &lt;/li&gt;
&lt;?php endif ?&gt;
&lt;?php if ($key == &#039;coast&#039;): ?&gt;
    &lt;li class=&quot;list-group-item&quot;&gt;&lt;b&gt;&lt;?php __(&#039;Costa&#039;) ?&gt;:&lt;/b&gt;
      &lt;?php foreach ($value as $k =&gt; $type): ?&gt;&lt;?php if ($k &gt; 0): ?&gt;, &lt;?php endif ?&gt;&lt;?php echo getCoast($type) ?&gt;&lt;?php endforeach ?&gt;
    &lt;/li&gt;
&lt;?php endif ?&gt;

            </code>
        </pre>


    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Toma de datos en Ferias
    </h6>
    <div class="card-body">
        Subir la carpeta 
        <pre>
            <code class="makefile">
/intramedianet/ferias/
            </code>
        </pre>

        Subir el archivo
        <pre>
            <code class="makefile">
/Connections/conf/ferias.php
            </code>
        </pre>
        Añadir en /Connections/conf/index.php:

<pre>
    <code class="makefile">
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/ferias.php');
    </code>
</pre>
        Sustituir el archivo por el del máster:
<pre>
    <code class="makefile">
/intramedianet/includes/inc.header.php
    </code>
</pre>

        En el archivo 
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:756
            </code>
        </pre>
        Antes del cierre del ul añadir:
        <pre>
            <code class="php">
&lt;?php
if(
    preg_match(&#039;/\/ferias/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) 
) {
    $showSecFairs = true;
} else {
    $showSecFairs = false;
}
?&gt;
&lt;?php if ($actFerias == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;

    &lt;a class=&quot;nav-link menu-link &lt;?php if($showSecFairs){ ?&gt;active&lt;?php } ?&gt;&quot; href=&quot;/intramedianet/ferias/clients.php&quot; 
        aria-expanded=&quot;&lt;?php if($showSecFairs){ ?&gt;true&lt;?php } else { ?&gt;false&lt;?php } ?&gt;&quot; aria-controls=&quot;sidebarFairs&quot;&gt;
        &lt;i class=&quot;fal fa-calendar-edit&quot;&gt;&lt;/i&gt; &lt;span&gt;&lt;?php __(&#039;Ferias&#039;); ?&gt;  &lt;/span&gt;
    &lt;/a&gt;

    &lt;?php if ($showSecFairs != &#039;true&#039;): ?&gt;
        &lt;a style=&quot;position: fixed; bottom: 20px; left: 20px&quot; class=&quot;d-xl-none btn btn-success btn-ferias &lt;?php if($showSecFairs){ ?&gt;active&lt;?php } ?&gt;&quot; href=&quot;/intramedianet/ferias/clients.php&quot;&gt;
        &lt;i style=&quot;font-size: 18px&quot; class=&quot;fal fa-calendar-edit me-2&quot;&gt;&lt;/i&gt; &lt;span&gt;&lt;?php __(&#039;Ferias&#039;); ?&gt; &lt;/span&gt;
         &lt;/a&gt; 
    &lt;?php endif ?&gt;
   
&lt;/li&gt; 
&lt;?php endif ?&gt;   
            </code>
        </pre>

        En /intramedianet/includes/resources/lang_xx.php añadir:

        <pre>
            <code class="php">
$lang['Ferias'] = 'Fairs';
            </code>
        </pre>        
        <pre>
            <code class="php">
$lang['Ferias'] = 'Ferias';
            </code>
        </pre>

        Ejecutar las sql

        <pre>
            <code class="sql">
ALTER TABLE `properties_client` ADD `feria_cli` INT(1) NOT NULL DEFAULT &#039;0&#039; AFTER `skype_cli`, ADD `nombre2_cli` VARCHAR(255) NULL DEFAULT NULL AFTER `feria_cli`, ADD `apellidos2_cli` VARCHAR(255) NULL DEFAULT NULL AFTER `nombre2_cli`, ADD `telefono_fijo2_cli` VARCHAR NULL DEFAULT NULL AFTER `apellidos2_cli`, ADD `mortgage_cli` INT(1) NOT NULL DEFAULT &#039;0&#039; AFTER `telefono_fijo2_cli`;
            </code>
        </pre>
        <pre>
            <code class="sql">
ALTER TABLE `properties_client` ADD `birthday_cli` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `mortgage_cli`, ADD `birthday2_cli` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `birthday_cli`, ADD `situation_cli` VARCHAR(255) NULL DEFAULT NULL AFTER `birthday2_cli`, ADD `current_home_cli` INT(11) NULL AFTER `situation_cli`, ADD `financing_cli` INT(1) NOT NULL DEFAULT &#039;0&#039; AFTER `current_home_cli`, ADD `mortgage_location_cli` VARCHAR(255) NULL DEFAULT NULL AFTER `financing_cli`, ADD `percentage_mortgage_cli` INT(11) NULL DEFAULT NULL AFTER `mortgage_location_cli`, ADD `mortgage_amount_cli` INT(11) NULL DEFAULT NULL AFTER `percentage_mortgage_cli`, ADD `current_gross_cli` INT(11) NULL DEFAULT NULL AFTER `mortgage_amount_cli`, ADD `current_partner_cli` INT(11) NULL DEFAULT NULL AFTER `current_gross_cli`, ADD `resources_cli` INT(11) NULL DEFAULT NULL AFTER `current_partner_cli`, ADD `extrainfo_cli` TEXT NULL DEFAULT NULL AFTER `resources_cli`, ADD `email2_cli` VARCHAR(255) NULL DEFAULT NULL AFTER `extrainfo_cli`;
            </code>
        </pre>
        <pre>
            <code class="sql">
ALTER TABLE `properties_client_sources` ADD COLUMN `active_fair_sts` INT(1) NULL DEFAULT 0 AFTER `category_fr_sts`;
            </code>
        </pre>

        Añadir las traducciones a /intramedianet/includes/resources/lang_xx.php:

        <pre>
            <code class="makefile">
$lang['Ferias'] = 'Ferias';
$lang['Cumpleaños'] = 'Fecha de Nacimiento';
$lang['Información adicional'] = 'Información adicional';
$lang['Características Principales'] = 'Características Principales';
$lang['Presupuesto'] = 'Presupuesto';
$lang['Dónde quieres comprar'] = 'Dónde quieres comprar';
$lang['Situación de vivienda actual'] = 'Situación de vivienda actual';
$lang['Value of current home  (in euro)'] = 'Valor de la vivienda actual (en euros)';
$lang['Financing options required?'] = '¿Se requieren opciones de financiación?';
$lang['Mortgage in'] = 'Hipoteca en';
$lang['Amount in percentage of mortgage'] = 'Cantidad en porcentaje de la hipoteca';
$lang['Current mortgage amount in euro  (in euro)'] = 'Cantidad actual de la hipoteca en euros (en euros)';
$lang['Current gross mortgage/rental burden'] = 'Carga bruta actual de la hipoteca/alquiler';
$lang['Gross income partner'] = 'Ingreso bruto de la pareja';
$lang['Available own resources (in euro)'] = 'Recursos propios disponibles (en euros)';
$lang['Owner House'] = 'Casa en propiedad';
$lang['Rental House'] = 'Casa en alquiler';
$lang['Spain'] = 'España';
$lang['Netherlands'] = 'Holanda';
$lang['Partners Birthday'] = "Fecha de nacimiento de la pareja";
            </code>
        </pre>
        <pre>
            <code class="makefile">
$lang['Ferias'] = 'Fairs';
$lang['Cumpleaños'] = 'Date of Birth';
$lang['Información adicional'] = 'Additional information';
$lang['Características Principales'] = 'Main Features';
$lang['Presupuesto'] = 'Budget';
$lang['Dónde quieres comprar'] = 'Where do you want to buy';
$lang['Situación de vivienda actual'] = 'Current living situation';
$lang['Value of current home  (in euro)'] = 'Value of current home  (in euro)';
$lang['Financing options required?'] = 'Financing options required?';
$lang['Mortgage in'] = 'Mortgage in';
$lang['Amount in percentage of mortgage'] = 'Amount in percentage of mortgage';
$lang['Current mortgage amount in euro  (in euro)'] = 'Current mortgage amount in euro  (in euro)';
$lang['Current gross mortgage/rental burden'] = 'Current gross mortgage/rental burden';
$lang['Gross income partner'] = 'Gross income partner';
$lang['Available own resources (in euro)'] = 'Available own resources (in euro)';
$lang['Owner House'] = 'Owner House';
$lang['Rental House'] = 'Rental House';
$lang['Spain'] = 'Spain';
$lang['Netherlands'] = 'Netherlands';
$lang['Partners Birthday'] = "Partner's Date of Birth";
            </code>
        </pre>

        En el archivo 
        <pre>
            <code class="makefile">
/intramedianet/properties/client-form.php:340
            </code>
        </pre>

        Añadir 
        <pre>
            <code class="php">
if ($actFerias == 1) 
{
  //Ferias
  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsFairs = &quot;SELECT feria_cli, id_cli FROM properties_client WHERE id_cli = &#039;&quot; . $_GET[&#039;id_cli&#039;] . &quot;&#039; &quot;;
  $rsFairs = mysql_query($query_rsFairs, $inmoconn) or die(mysql_error());
  $row_rsFairs = mysql_fetch_assoc($rsFairs);
  $totalRows_rsFairs = mysql_num_rows($rsFairs);
}
            </code>
        </pre>

        En el archivo 
        <pre>
            <code class="makefile">
/intramedianet/properties/client-form.php:712
            </code>
        </pre>
        Antes del 
        <pre>
            <code class="makefile">
$ins_properties_client-&gt;setPrimaryKey(&quot;id_cli&quot;, &quot;NUMERIC_TYPE&quot;);
            </code>
        </pre>

         añadir:
         <pre>
            <code class="makefile">
if ($actFerias == 1)
{
  $ins_properties_client-&gt;addColumn(&quot;nombre2_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;nombre2_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;apellidos2_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;apellidos2_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;telefono_fijo2_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;telefono_fijo2_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;birthday_cli&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;birthday_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;birthday2_cli&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;birthday2_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;situation_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;situation_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;mortgage_location_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;mortgage_location_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;percentage_mortgage_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;percentage_mortgage_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;mortgage_amount_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;mortgage_amount_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;current_gross_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;current_gross_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;current_partner_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;current_partner_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;resources_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;resources_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;extrainfo_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;extrainfo_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;current_home_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;current_home_cli&quot;);
  $ins_properties_client-&gt;addColumn(&quot;financing_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;financing_cli&quot;, &quot;0&quot;);
}
            </code>
        </pre>
         En el archivo 
        <pre>
            <code class="makefile">
/intramedianet/properties/client-form.php:834
            </code>
        </pre>
        Antes del 
        <pre>
            <code class="makefile">
$upd_properties_client-&gt;setPrimaryKey(&quot;id_cli&quot;, &quot;NUMERIC_TYPE&quot;, &quot;GET&quot;, &quot;id_cli&quot;);
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
if ($actFerias == 1)
{
  $upd_properties_client-&gt;addColumn(&quot;nombre2_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;nombre2_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;apellidos2_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;apellidos2_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;telefono_fijo2_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;telefono_fijo2_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;birthday_cli&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;birthday_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;birthday2_cli&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;birthday2_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;situation_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;situation_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;mortgage_location_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;mortgage_location_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;percentage_mortgage_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;percentage_mortgage_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;mortgage_amount_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;mortgage_amount_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;current_gross_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;current_gross_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;current_partner_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;current_partner_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;resources_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;resources_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;extrainfo_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;extrainfo_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;current_home_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;current_home_cli&quot;);
  $upd_properties_client-&gt;addColumn(&quot;financing_cli&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;financing_cli&quot;);
}     
            </code>
        </pre>

        En el tab general con los datos del buyer añadir:

        <pre>
            <code class="html">
&lt;div class=&quot;col-md-6 col-lg-3&quot;&gt;
    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;nombre2_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;nombre2_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt; 2:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;nombre2_cli&quot; id=&quot;nombre2_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;nombre2_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;  &gt;
       
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;nombre2_cli&quot;); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;col-md-6 col-lg-3&quot;&gt;
    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;apellidos2_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;apellidos2_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Apellidos&#039;); ?&gt; 2:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;apellidos2_cli&quot; id=&quot;apellidos2_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;apellidos2_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;apellidos2_cli&quot;); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;col-md-6 col-lg-3&quot;&gt;
    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_fijo2_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;telefono_fijo2_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt; 2:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;telefono_fijo2_cli&quot; id=&quot;telefono_fijo2_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_fijo2_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control number&quot;&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;telefono_fijo2_cli&quot;); ?&gt;
        &lt;a href=&quot;https://api.whatsapp.com/send/?phone=&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;telefono_fijo2_cli&#039;]); ?&gt;&quot; class=&quot;btn btn-success btn-sm ms-2 d-inline-block&quot; style=&quot;border-radius: 0 0 5px 5px;&quot; target=&quot;blank&quot;&gt;Whatsapp&lt;/a&gt; &lt;small class=&quot;text-muted&quot;&gt;&lt;?php __(&#039;Sin + con prefijo del pa&iacute;s y sin espacios&#039;); ?&gt;&lt;/small&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>

         En el archivo 
        <pre>
            <code class="makefile">
/intramedianet/properties/client-form.php:1158
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;?php if ($actSaveSearch == 1):?&gt;
 &lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#tabsearches&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
        &lt;?php __(&#039;B&uacute;squedas guardadas&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;?php endif?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
&lt;?php if ($actSaveSearch == 1):?&gt;
 &lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#tabsearches&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
        &lt;?php __(&#039;B&uacute;squedas guardadas&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;?php endif?&gt;
&lt;?php 
//ferias
if ($row_rsFairs[&#039;feria_cli&#039;] == 1): ?&gt;         
&lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#tabferias&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
        &lt;?php __(&#039;Ferias&#039;); ?&gt; &amp; &lt;?php __(&#039;Eventos&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>

        En el archivo 
        <pre>
            <code class="makefile">
/intramedianet/properties/client-form.php:2845
            </code>
        </pre>

        Añadir la nueva tab antes de la "tabsearches":
        <pre>
            <code class="html">
&lt;?php
if ($actFerias == 1) 
{
?&gt;
&lt;!-- Ferias --&gt;
&lt;div class=&quot;tab-pane&quot; id=&quot;tabferias&quot;&gt;

&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;
              &lt;?php __(&#039;Ferias&#039;); ?&gt; &amp; &lt;?php __(&#039;Eventos&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;div class=&quot;row&quot;&gt;
        

            &lt;div class=&quot;col-lg-8&quot;&gt;
              &lt;div class=&quot;row&quot;&gt;

                &lt;div class=&quot;col-md-6&quot;&gt;
                  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;birthday_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                      &lt;label for=&quot;birthday_cli&quot; class=&quot;form-label&quot;&gt;Partner&#039;s &lt;?php __(&#039;Cumplea&ntilde;os&#039;); ?&gt;:&lt;/label&gt;
                      &lt;input type=&quot;text&quot; name=&quot;birthday_cli&quot; id=&quot;birthday_cli&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsproperties_client[&#039;birthday_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepick&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot;&gt;
                      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;birthday_cli&quot;); ?&gt;
                  &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-6&quot;&gt;
                  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;birthday2_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;birthday2_cli&quot; class=&quot;form-label&quot;&gt; &lt;?php __(&#039;Partners Birthday&#039;); ?&gt;:&lt;/label&gt;
                    &lt;input type=&quot;text&quot; name=&quot;birthday2_cli&quot; id=&quot;birthday2_cli&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsproperties_client[&#039;birthday2_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepick&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot;&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;birthday2_cli&quot;); ?&gt;
                  &lt;/div&gt;
              &lt;/div&gt;

                &lt;div class=&quot;col-md-6&quot;&gt;
                    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;situation_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                        &lt;label for=&quot;situation_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Situaci&oacute;n de vivienda actual&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;situation_cli&quot; id=&quot;situation_cli&quot; class=&quot;form-select&quot;&gt;
                            &lt;option value=&quot;Owner House&quot; &lt;?php if (!(strcmp(&#039;Owner House&#039;, $row_rsproperties_client[&#039;situation_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;
                              &lt;?php __(&#039;Owner House&#039;); ?&gt; &lt;/option&gt;
                            &lt;option value=&quot;Rental House&quot; &lt;?php if (!(strcmp(&#039;Rental House&#039;, $row_rsproperties_client[&#039;situation_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;
                              &lt;?php __(&#039;Rental House&#039;); ?&gt; &lt;/option&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                  &lt;/div&gt;
                  &lt;div class=&quot;col-md-6&quot;&gt;
                      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;current_home_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;current_home_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Value of current home  (in euro)&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;current_home_cli&quot; id=&quot;current_home_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;current_home_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;current_home_cli&quot;); ?&gt;
                        &lt;/div&gt;
                        
                  &lt;/div&gt;

                  

                  &lt;div class=&quot;col-md-6&quot;&gt;
                    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;mortgage_location_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;

                        &lt;label for=&quot;mortgage_location_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Mortgage in&#039;); ?&gt;:&lt;/label&gt;

                         &lt;input type=&quot;text&quot; placeholder=&quot;&lt;?php __(&#039;Spain&#039;); ?&gt;, &lt;?php __(&#039;Netherlands&#039;); ?&gt;, ... &quot; name=&quot;mortgage_location_cli&quot; id=&quot;mortgage_location_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;mortgage_location_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;

                    &lt;/div&gt;
                  &lt;/div&gt;

                   &lt;div class=&quot;col-md-6&quot;&gt;
                    &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;percentage_mortgage_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;

                        &lt;label for=&quot;percentage_mortgage_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Amount in percentage of mortgage&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;percentage_mortgage_cli&quot; id=&quot;percentage_mortgage_cli&quot; class=&quot;form-select&quot;&gt;
                            &lt;option value=&quot;40&quot; &lt;?php if (!(strcmp(&#039;40&#039;, $row_rsproperties_client[&#039;percentage_mortgage_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;40% &lt;/option&gt;
                            &lt;option value=&quot;50&quot; &lt;?php if (!(strcmp(&#039;50&#039;, $row_rsproperties_client[&#039;percentage_mortgage_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;50% &lt;/option&gt;
                            &lt;option value=&quot;60&quot; &lt;?php if (!(strcmp(&#039;60&#039;, $row_rsproperties_client[&#039;percentage_mortgage_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;60% &lt;/option&gt;
                            &lt;option value=&quot;70&quot; &lt;?php if (!(strcmp(&#039;70&#039;, $row_rsproperties_client[&#039;percentage_mortgage_cli&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;70% &lt;/option&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                  &lt;/div&gt;
                  &lt;div class=&quot;col-md-6&quot;&gt;
                      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;mortgage_amount_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;mortgage_amount_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Current mortgage amount in euro  (in euro)&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;mortgage_amount_cli&quot; id=&quot;mortgage_amount_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;mortgage_amount_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;mortgage_amount_cli&quot;); ?&gt;
                        &lt;/div&gt;
                  &lt;/div&gt;

                  &lt;div class=&quot;col-md-6&quot;&gt;
                      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;current_gross_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;current_gross_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Current gross mortgage/rental burden&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;current_gross_cli&quot; id=&quot;current_gross_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;current_gross_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;current_gross_cli&quot;); ?&gt;
                        &lt;/div&gt;
                  &lt;/div&gt;
                  
                  &lt;div class=&quot;col-md-6&quot;&gt;
                      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;current_partner_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;current_partner_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Current gross mortgage/rental burden&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;current_partner_cli&quot; id=&quot;current_partner_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;current_partner_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;current_partner_cli&quot;); ?&gt;
                        &lt;/div&gt;
                  &lt;/div&gt;

                  &lt;div class=&quot;col-md-6&quot;&gt;
                      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;resources_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                            &lt;label for=&quot;resources_cli &quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Available own resources (in euro)&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;resources_cli&quot; id=&quot;resources_cli&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;resources_cli&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                              &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;resources_cli&quot;); ?&gt;
                        &lt;/div&gt;
                  &lt;/div&gt;
              &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;col-lg-4&quot;&gt;

                 &lt;div class=&quot;form-check form-switch form-switch-lg pt-0 mt-md-2 mb-4&quot; dir=&quot;ltr&quot;&gt;
                            &lt;input type=&quot;checkbox&quot; name=&quot;financing_cli&quot; id=&quot;financing_cli&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client[&#039;financing_cli&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
                            &lt;label class=&quot;form-check-label&quot; for=&quot;financing_cli&quot;&gt;&lt;?php __(&#039;Financing options required?&#039;); ?&gt;&lt;/label&gt;
                            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;financing_cli&quot;); ?&gt;
                      &lt;/div&gt;

                            
                &lt;label for=&quot;extrainfo_cli&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Informaci&oacute;n adicional&#039;); ?&gt;:&lt;/label&gt;

                &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;extrainfo_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                    &lt;textarea type=&quot;text&quot; name=&quot;extrainfo_cli&quot; id=&quot;extrainfo_cli&quot; cols=&quot;50&quot; rows=&quot;10&quot; class=&quot;form-control&quot;&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_client[&#039;extrainfo_cli&#039;]); ?&gt;&lt;/textarea&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;extrainfo_cli&quot;); ?&gt;
                   
                &lt;/div&gt;

            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;?php
}
?&gt;
            </code>
        </pre>

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>

</div>

<div class="card mb-4">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Agencias
    </h6>
    <div class="card-body">
        <p>
            Subir la carpeta /intramedianet/agencias
        </p>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/secciones.php
            </code>
        </pre>
        Añadir
        <pre>
            <code class="makefile">
/*--------------------------------------------------------------------------
/* @group Agencias */
/*--------------------------------------------------------------------------
|
| Activar la administraci&oacute;n de Agencias de la aplicaci&oacute;n
| 0 - Desactivado
| 1 - Activado
|
*/

$actAgencias = 1;
            </code>
        </pre>

        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:324
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
reg_match(&#039;/\/calendar\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])
            </code>
        </pre>
        Por
        <pre>
            <code class="php">
preg_match(&#039;/\/calendar\//&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ||
preg_match(&#039;/\/agencias\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])
            </code>
        </pre>
        En la linea 494 cambiar:
        <pre>
            <code>
&lt;?php if ($actArchivadoEn == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/properties-archived.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/properties-archived/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Archivado en&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por 
        <pre>
            <code>
&lt;?php if ($actAgencias == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/agencias/owners.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/agencias\/owners/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Agencias&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
&lt;?php if ($actArchivadoEn == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/properties-archived.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/properties-archived/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Archivado en&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;    
            </code>
        </pre>
        Añadir las traducciones a /intramedianet/includes/resources/lang_xx.php
        <pre>
            <code>
$lang[&#039;Agencia&#039;] = &#039;Agencia&#039;;
$lang[&#039;Nombre de agencia&#039;] = &#039;Nombre de agencia&#039;;
$lang[&#039;Agencias&#039;] = &#039;Agencias&#039;;
            </code>
        </pre>
        Y:
        <pre>
            <code>
$lang[&#039;Agencia&#039;] = &#039;Agency&#039;;
$lang[&#039;Nombre de agencia&#039;] = &#039;Agency name&#039;;
$lang[&#039;Agencias&#039;] = &#039;Agencies&#039;;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/newsletter.php
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
$acumbamailIdListaAgency = array(
    &#039;ca&#039; =&gt; &#039;&#039;,
    &#039;da&#039; =&gt; &#039;&#039;,
    &#039;de&#039; =&gt; &#039;&#039;,
    &#039;en&#039; =&gt; &#039;&#039;,
    &#039;es&#039; =&gt; &#039;&#039;,
    &#039;fi&#039; =&gt; &#039;&#039;,
    &#039;pl&#039; =&gt; &#039;&#039;,
    &#039;fr&#039; =&gt; &#039;&#039;,
    &#039;is&#039; =&gt; &#039;&#039;,
    &#039;nl&#039; =&gt; &#039;&#039;,
    &#039;no&#039; =&gt; &#039;&#039;,
    &#039;ru&#039; =&gt; &#039;&#039;,
    &#039;se&#039; =&gt; &#039;&#039;,
    &#039;zh&#039; =&gt; &#039;&#039;
);
            </code>
        </pre>

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="nueve">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Botón unsubscribe. Error al darse de baja 
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email:16
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function encryptIt($stringArray, $key = &quot;DLusjkq6kkzRUbY7TVc7YH2RcT2&quot;) {
 $key = $_SERVER[&#039;HTTP_HOST&#039;];
 $s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), &#039;+/=&#039;, &#039;-_,&#039;);
 return $s;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function encryptIt($idCli, $encryptionKey) 
{
    //encriptamos la id del cliente
    $originalString = $idCli;
    // M&eacute;todo de cifrado
    $method = &#039;AES-128-CBC&#039;;
    // IV - Vector de inicializaci&oacute;n
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    // Cifrado
    $encrypted = openssl_encrypt($originalString, $method, $encryptionKey, 0, $iv);
    // Necesitar&aacute;s el IV para el descifrado, as&iacute; que aseg&uacute;rate de almacenarlo junto con el valor cifrado
    return base64_encode($encrypted . &#039;::&#039; . $iv);
}
            </code>
        </pre>

        En la linea 133 cambiar:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$_GET[&#039;lang&#039;].&#039;/unsubscribe/?id=&#039;.encryptIt($row_rsCli[&#039;id_cli&#039;]), $html);
            </code>
        </pre>
        Por:
        <pre>
            <code>
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$_GET[&#039;lang&#039;].&#039;/unsubscribe/?id=&#039;.encryptIt($row_rsCli[&#039;id_cli&#039;],$nombreEmpresa), $html);                
            </code>
        </pre>

        En el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/unsubscribe.php:18
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function decryptIt($stringArray, $key = &quot;DLusjkq6kkzRUbY7TVc7YH2RcT2&quot;) {
 $s = unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(strtr($stringArray, &#039;-_,&#039;, &#039;+/=&#039;)), MCRYPT_MODE_CBC, md5(md5($key))), &quot;\0&quot;));
 return $s;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function decryptIt($idCli, $encryptionKey) 
{
    $encryptedWithIv = $idCli;
    // M&eacute;todo de cifrado (debe ser el mismo que se us&oacute; para cifrar)
    $method = &#039;AES-128-CBC&#039;;
    // Separar el valor cifrado y el IV
    list($encryptedData, $iv) = explode(&#039;::&#039;, base64_decode($encryptedWithIv), 2);
    // Descifrado
    return openssl_decrypt($encryptedData, $method, $encryptionKey, 0, $iv);
}   
$aviso = 0;
$cli = decryptIt($_GET[&#039;id&#039;]);
            </code>
        </pre>

        En la linea 133 cambiar:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$_GET[&#039;lang&#039;].&#039;/unsubscribe/?id=&#039;.encryptIt($row_rsCli[&#039;id_cli&#039;]), $html);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$_GET[&#039;lang&#039;].&#039;/unsubscribe/?id=&#039;.encryptIt($row_rsCli[&#039;id_cli&#039;],$nombreEmpresa), $html);                
            </code>
        </pre>

        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:14
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function encryptIt($stringArray, $key = &quot;DLusjkq6kkzRUbY7TVc7YH2RcT2&quot;) {
 $key = $_SERVER[&#039;HTTP_HOST&#039;];
 $s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), &#039;+/=&#039;, &#039;-_,&#039;);
 return $s;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function encryptIt($idCli, $encryptionKey) 
{
    //encriptamos la id del cliente
    $originalString = $idCli;
    // M&eacute;todo de cifrado
    $method = &#039;AES-128-CBC&#039;;
    // IV - Vector de inicializaci&oacute;n
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    // Cifrado
    $encrypted = openssl_encrypt($originalString, $method, $encryptionKey, 0, $iv);
    // Necesitar&aacute;s el IV para el descifrado, as&iacute; que aseg&uacute;rate de almacenarlo junto con el valor cifrado
    return base64_encode($encrypted . &#039;::&#039; . $iv);
}
            </code>
        </pre>

 En la linea 410 cambiar:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$langValuage.&#039;/unsubscribe/?id=&#039;.encryptIt($client[&#039;id_cli&#039;]), $html);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$langValuage.&#039;/unsubscribe/?id=&#039;.encryptIt($client[&#039;id_cli&#039;], $nombreEmpresa), $html);              
            </code>
        </pre>

        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send.php:16
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function encryptIt($stringArray, $key = &quot;DLusjkq6kkzRUbY7TVc7YH2RcT2&quot;) {
 $key = $_SERVER[&#039;HTTP_HOST&#039;];
 $s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), &#039;+/=&#039;, &#039;-_,&#039;);
 return $s;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function encryptIt($idCli, $encryptionKey) 
{
    //encriptamos la id del cliente
    $originalString = $idCli;
    // M&eacute;todo de cifrado
    $method = &#039;AES-128-CBC&#039;;
    // IV - Vector de inicializaci&oacute;n
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    // Cifrado
    $encrypted = openssl_encrypt($originalString, $method, $encryptionKey, 0, $iv);
    // Necesitar&aacute;s el IV para el descifrado, as&iacute; que aseg&uacute;rate de almacenarlo junto con el valor cifrado
    return base64_encode($encrypted . &#039;::&#039; . $iv);
}
            </code>
        </pre>
        En la linea 122 cambiar:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$_GET[&#039;lang&#039;].&#039;/unsubscribe/?id=&#039;.encryptIt($row_rsCli[&#039;id_cli&#039;]), $html);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$html = preg_replace(&#039;/{URLBAJA}/&#039;, &#039;https://&#039;.$_SERVER[&#039;HTTP_HOST&#039;].&#039;/&#039;.$_GET[&#039;lang&#039;].&#039;/unsubscribe/?id=&#039;.encryptIt($row_rsCli[&#039;id_cli&#039;],$nombreEmpresa), $html);               
            </code>
        </pre>

    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="diez">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Exportador Mediaelx
    </h6>
    <div class="card-body">

        Subir el archivo del último máster:
        <pre>
            <code class="makefile">
/xml/kyero-mediaelx.php
            </code>
        </pre>


        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/_js/export-list.js:54
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
return &#039;&lt;a href=&quot;https://&#039; + httpHost + &#039;/xml/kyero.php?f=&#039; + data + &#039;&quot; class=&quot;btn btn-soft-primary btn-sm&quot; target=&quot;_blank&quot;&gt;https://&#039; + httpHost + &#039;/xml/kyero.php?f=&#039; + data + &#039;&lt;/a&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$urlXML = &#039;&lt;span class=&quot;badge bg-primary text-bg-primary&quot;&gt;kyero: &lt;/span&gt; &amp;nbsp;&lt;a href=&quot;https://&#039; + httpHost + &#039;/xml/kyero.php?f=&#039; + data + &#039;&quot; class=&quot;btn btn-soft-primary btn-sm mb-1&quot; target=&quot;_blank&quot;&gt;https://&#039; + httpHost + &#039;/xml/kyero.php?f=&#039; + data + &#039;&lt;/a&gt;&lt;br&gt;&#039;;
$urlXML += &#039;&lt;span class=&quot;badge bg-primary text-bg-primary&quot;&gt;XML Mediaelx: &lt;/span&gt;  &amp;nbsp;&lt;a href=&quot;https://&#039; + httpHost + &#039;/xml/kyero-mediaelx.php?f=&#039; + data + &#039;&quot; class=&quot;btn btn-success btn-sm&quot; target=&quot;_blank&quot;&gt;https://&#039; + httpHost + &#039;/xml/kyero-mediaelx.php?f=&#039; + data + &#039;&lt;/a&gt;&#039;;
return $urlXML;
            </code>
        </pre>


    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

