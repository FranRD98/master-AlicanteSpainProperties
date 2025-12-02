
{* @group SEC - IMAGEN PRINCIPAL *}
<div class="property-slider-center">
    <div class="slides">
        {section name=img loop=$images}
        <div>
            {if isset($images[img].alt) && $images[img].alt != ''}
                {assign var="altTitle" value="{$images[img].alt}"}
            {else}
                {assign var="altTitle" value="{$title}"}
            {/if}
            {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$images[img].id_img}_lg.jpg")}
                <a href="/media/images/properties/thumbnails/{$images[img].id_img}_xl.jpg" class="gallProp">
                    <img src="/media/images/properties/thumbnails/{$images[img].id_img}_lg.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                </a>
            {else}
                {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['lg'][0]} height={$thumbnailsSizes['lg'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
            {/if}
        </div>
        {/section}
    </div>
    <div class="energia d-none d-lg-inline-block">
        <img class="img-fluid" src="/media/images/website/energia.png" alt="{$lng_calificacion_energetica}">
        <span>{if $property[0].energia_prop != ''}{$property[0].energia_prop}{else}{$lng_en_proceso}{/if}</span>
    </div>
</div>
