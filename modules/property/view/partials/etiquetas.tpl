<div class="labels">
    <div class="badge bg-primary">
        {$lng_ref_}:<strong>{$property[0].ref}</strong>
    </div>

    {if {$property[0].nuevo_prop|strtotime} >= $smarty.now }
        <div class="badge bg-success">{$lng_nuevo}</div>
    {/if}
    {if $property[0].vendido_tag_prop == 1}
        <div class="badge bg-danger">{$lng_vendido}</div>
    {/if}
    {if $property[0].alquilado_prop == 1}
        <div class="badge bg-danger">{$lng_alquilado}</div>
    {/if}
    {if $property[0].reservado_prop == 1}
        <div class="badge bg-danger">{$lng_reservado}</div>
    {/if}
    {assign var=tag value=getPropTags($property[0].id_prop, $lang)}
    {section name=tg loop=$tag}
        {if $tag[tg].tag != ''}
            <div class="badge badge-info label-{$tag[tg].id_tag}">{$tag[tg].tag}</div>
        {/if}
    {/section}
</div>