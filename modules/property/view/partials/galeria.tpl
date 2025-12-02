
{* @group SEC - IMAGEN PRINCIPAL *}
<div class="property-slider">
    <div class="slides">
        {section name=img loop=$images}
        <div>
            {if isset($images[img].alt) && $images[img].alt != ''}
                {assign var="altTitle" value="{$images[img].alt}"}
            {else}
                {assign var="altTitle" value="{$title}"}
            {/if}
             {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$images[img].id_img}_lg.jpg")}
                <a href="/img/{$altTitle|slug}_{$images[img].id_img}_xl.jpg" class="gallProp">
                    {* <img src="/media/images/properties/thumbnails/{$images[img].id_img}_xl.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                    <img src="/img/{$altTitle|slug}_{$images[img].id_img}_lg.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                </a>
            {else}
                {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['lg'][0]} height={$thumbnailsSizes['lg'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
            {/if}
        </div>
        {/section}
    </div>
</div>
{* @group SEC - MIMIATURAS *}
{if $images[0].id_img != ''}
<div class="property-gallery-slider">
    <div class="slides">
        {section name=img loop=$images}
        <div>
            {if isset($images[img].alt) && $images[img].alt != ''}
                {assign var="altTitle" value="{$images[img].alt}"}
            {else}
                {assign var="altTitle" value="{$title}"}
            {/if}
            {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$images[img].id_img}_sm.jpg")}
                {* <img src="/media/images/properties/thumbnails/{$images[img].id_img}_sm.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                <img src="/img/{$altTitle|slug}_{$images[img].id_img}_sm.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
            {else}
                {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['sm'][0]} height={$thumbnailsSizes['sm'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
            {/if}
        </div>
        {/section}
    </div>
</div>
{/if}