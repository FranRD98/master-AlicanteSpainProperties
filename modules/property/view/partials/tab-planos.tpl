
<h3 class="main-title subtitle">{$lng_planos}</h3>

<div class="list-inline">
    {section name=img loop=$planos}
        <li class="list-inline-item">
            {if isset($planos[img].alt) && $planos[img].alt != ''}
                {assign var="altTitle" value="{$planos[img].alt}"}
            {else}
                {assign var="altTitle" value="{$title}"}
            {/if}
            {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/propertiesplanos/thumbnails/{$planos[img].id_img}_xl.jpg")}
                <a href="/media/images/propertiesplanos/thumbnails/{$planos[img].id_img}_xl.jpg" class="gallProp">
                    <img src="/media/images/propertiesplanos/thumbnails/{$planos[img].id_img}_sm.jpg" class='img-responsive' alt="{$altTitle}" title="{$altTitle}">
                </a>
            {else}
                {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['lg'][0]} height={$thumbnailsSizes['lg'][1]} class='img-responsive' alt="{$altTitle}" title="{$altTitle}" }
            {/if}
        </li>
    {/section}
</div>