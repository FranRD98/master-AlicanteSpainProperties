{* @group SEC - IMAGEN PRINCIPAL *}
<div class="row py-4">
    <div class="col-md-8">
        <div class="main-photo pb-lg-0 pb-2">

            {if $property[0].vendido_prop == 1 || $property[0].vendido_tag_prop == 1}
                <div class="vendido-tag-big">
                    {$lng_vendido}
                </div>
            {/if}

            {if isset($images[0].alt) && $images[0].alt != ''}
                {assign var="altTitle" value="{$images[0].alt}"}
            {else}
                {assign var="altTitle" value="{$title}"}
            {/if}
            {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$images[0].id_img}_lg.jpg")}
                <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModal" {/if} href="/img/{$altTitle|slug}_{$images[1].id_img}_xl.jpg" class="{if $galeriaModal == 0} gallProp {/if} img-big" >
                    {* <img src="/media/images/properties/thumbnails/{$images[img].id_img}_xl.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                    <img src="/img/{$altTitle|slug}_{$images[0].id_img}_lg.jpg" class='img-fluid big-image' alt="{$altTitle}" title="{$altTitle}">
                </a>
            {else}
                {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['lg'][0]} height={$thumbnailsSizes['lg'][1]} class='img-fluid mt-1' alt="{$altTitle}" title="{$altTitle}" }
            {/if}

            <div class="energia d-inline-block">
                <img class="img-fluid" src="/media/images/website/energia.png" alt="{$lng_calificacion_energetica}">
                <span>{if $property[0].energia_prop != ''}{$property[0].energia_prop}{else}{$lng_en_proceso}{/if}</span>
            </div>
            
        </div>
    </div>

    <div class="col-md-4 d-flex flex-row flex-md-column justify-content-between">
        {* @group SEC - MIMIATURAS *}
        {if $images[1].id_img != ''}

            <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModal" {/if} href="/img/{$altTitle|slug}_{$images[1].id_img}_xl.jpg" class="{if $galeriaModal == 0} gallProp {/if} small-image-link" >
                {if isset($images[1].alt) && $images[1].alt != ''}
                    {assign var="altTitle" value="{$images[1].alt}"}
                {else}
                    {assign var="altTitle" value="{$title}"}
                {/if}
                {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$images[1].id_img}_lg.jpg")}
                    {* <img src="/media/images/properties/thumbnails/{$images[1].id_img}_sm.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                    <img src="/img/{$altTitle|slug}_{$images[1].id_img}_lg.jpg?id=1.0001" class='img-fluid small-image' alt="{$altTitle}" title="{$altTitle}">
                {else}
                    {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['lg'][0]} height={$thumbnailsSizes['lg'][1]} class='img-fluid mt-1' alt="{$altTitle}" title="{$altTitle}" }
                {/if}
            </a>

        {/if}
        {* @group SEC - MIMIATURAS *}
        {if $images[2].id_img != ''}

           <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModal" {/if} href="/img/{$altTitle|slug}_{$images[2].id_img}_xl.jpg" class="{if $galeriaModal == 0} gallProp {/if} small-image-link" >

                {if $images[2].alt != ''}
                    {assign var="altTitle" value="{$images[1].alt}"}
                {else}
                    {assign var="altTitle" value="{$title}"}
                {/if}

                {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$images[2].id_img}_lg.jpg")}
                    {* <img src="/media/images/properties/thumbnails/{$images[1].id_img}_sm.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                    <img src="/img/{$altTitle|slug}_{$images[2].id_img}_lg.jpg?id=1.0001" class='img-fluid small-image' alt="{$altTitle}" title="{$altTitle}">
                {else}

                    {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['lg'][0]} height={$thumbnailsSizes['lg'][1]} class='img-fluid mt-1' alt="{$altTitle}" title="{$altTitle}" }
                {/if}


                <span class="all-img btn btn-dark px-4 mt-0">
                     {$lng_view_all_photos}
                </spam>

            </a>

        {/if}

    </div>
</div>
