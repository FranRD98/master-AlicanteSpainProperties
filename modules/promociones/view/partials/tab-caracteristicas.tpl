<div class="row">

    <div class="col-12">
        <h3 class="main-title subtitle">{$lng_caracteristicas}</h3>
    </div>

    <div class="col-12">
        {section name=tg loop=$tags}
            {if $tags[tg].tag != ''}
                <div class="badge badge-info label-{$tags[tg].id_tag}">{$tags[tg].tag}</div>
            {/if}
        {/section}
    </div>

    <div class="row mb-5">
        {if $precioReferenciaVals[0].m2_min > 0}
        <div class="col">
            {$lng_meters}
            <br>
            {$precioReferenciaVals[0].m2_min}-{$precioReferenciaVals[0].m2_max} m<sup>2</sup>
        </div>
        {/if}
        {if $precioReferenciaVals[0].m2b_min > 0}
        <div class="col">
            {$lng_construidos}
            <br>
            {$precioReferenciaVals[0].m2b_min}-{$precioReferenciaVals[0].m2b_max} m<sup>2</sup>
        </div>
        {/if}
        {if $precioReferenciaVals[0].beds_min > 0}
        <div class="col">
            {$lng_habitaciones}
            <br>
            {$precioReferenciaVals[0].beds_min}-{$precioReferenciaVals[0].beds_max} m<sup>2</sup>
        </div>
        {/if}
        {if $precioReferenciaVals[0].baths_min > 0}
        <div class="col">
            {$lng_banos}
            <br>
            {$precioReferenciaVals[0].baths_min}-{$precioReferenciaVals[0].baths_max} m<sup>2</sup>
        </div>
        {/if}
        {if $precioReferenciaVals[0].parking_prop != ''}
        <div class="col">
            {$lng_garaje}
            <br>
            {$precioReferenciaVals[0].parking_prop}
        </div>
        {/if}
        {if $precioReferenciaVals[0].piscina_prop != ''}
        <div class="col">
            {$lng_piscina}
            <br>
            {$precioReferenciaVals[0].piscina_prop}
        </div>
        {/if}
    </div>

    {if $similares[0].entraga_date_prop != ''}
    <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i><strong>{$lng_fecha_de_entrega}:</strong> {$similares[0].entraga_date_prop}</div>
    {/if}
    {section name=ft loop=$features}
        {if {$features[ft].feat} != ''}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> {$features[ft].feat}</div>
        {/if}
    {/section}
</div>