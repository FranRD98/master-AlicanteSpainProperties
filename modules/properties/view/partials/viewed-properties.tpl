<a href="{propURL($viewedproperties[wp].id_prop, $lang)}" class="wrapper">
    <div class="row">

        <div class="col-6">
            {assign var="altTitle" value="{$viewedproperties[wp].type} - {$viewedproperties[wp].sale} - {$viewedproperties[wp].area} - {$viewedproperties[wp].ref}"}
            {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$viewedproperties[wp].id_img}_md.jpg")}
                {* <img src="/media/images/properties/thumbnails/{$viewedproperties[wp].id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                <img src="/img/{$altTitle|slug}_{$viewedproperties[wp].id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
            {else}
                {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
            {/if}
        </div>

        <div class="col-6 ps-0">

            <h3> {$viewedproperties[wp].type} <small>{$viewedproperties[wp].area}</small></h3>

            <div class="prices">
                
                {if $viewedproperties[wp].precio > 0}

                    {$viewedproperties[wp].precio|number_format:0:",":"."} €

                {else}
                    {$lng_consultar}
                {/if}
            </div>
        </div>
    </div>
</a>
