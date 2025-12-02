{if $resource.titulo_prom != ''}
    {assign var="link" value="{$urlStart}{$url_promociones}/{$resource.id_nws}/{$resource.titulo_prom|slug}/"}
{else}
    {assign var="link" value="{$urlStart}{$url_promociones}/{$resource.id_nws}/{$resource.titulo|slug}/"}
{/if}

<a class="" href="{$link}">
    {* @group SEC - Imagen *}
    <div class="">
        {if $resource.img != ''}
            {if $resource.alt != ''}
                {assign var="altt" value="{$resource.alt}"}
            {else}
                {assign var="altt" value="{$resource.titulo}"}
            {/if}
            {if $resource.img|regex_replace:'/https?/':'' != $resource.img}
                {imagesize src="{$resource.img}" width=590 height=355 class='img-fluid w-100' alt="{$altt}" title="{$altt}" path="/media/images/news/" }
            {else}
                {assign var="imgProp" value="/media/images/news/{$resource.img}"}
                {imagesize src="{$imgProp}" width=590 height=355 class='img-fluid w-100' alt="{$altt}" title="{$altt}" }
            {/if}
        {else}
            {imagesize src='/media/images/website/no-image.png' width=590 height=355 class='img-fluid' alt="{$altt}"
            title="{$altt}" }
        {/if}
    </div>


    <div class="promo-view">
        {* @group SEC - TEXTOS *}
        <div class="">
            {if $resource.titulo_prom != ''}
                <h3>{$resource.titulo_prom}</h3>
            {else}
                <h3>{$resource.titulo}</h3>
            {/if}
            <h4>{$resource.province} · {$resource.ciudad}</h4>
            <h5>{$resource.total_properties} {$lng_propiedades}</h5>
            <h6>{$lng_from} {$resource.precio_desde} €</h6>
            {$lng_mas_informacion}
        </div>
    </div>
</a>