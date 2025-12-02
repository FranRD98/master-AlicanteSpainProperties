<div class="container">
    <div class="row">
        <div class="col-md-8 order-md-12">
            <div class="sidebar-content">
                {include file="file:modules/properties/view/partials/listado.tpl" proparray=$proparray numberprops=$numberprops showshor=$showshor}
            </div>
        </div>
        <div class="col-md-4 order-md-1 d-none d-md-block">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <div class="sidebar-form">
                        {include file="partials/buscador.tpl" dupl=1}
                    </div>
                </div>
            </div>
            {if $viewedproperties[0].id_prop != ''}
            <div class="col-12">
                <h2 class="main-title">{$lng_ultimas_propiedades_vistas}</h2>
            </div>
            {section name=wp loop=$viewedproperties}
                <div class="col-12 viewed-props-full">
                    <a href="{propURL($viewedproperties[wp].id_prop, $lang)}" class="wrapper">
                        <div class="row">
                            <div class="col-5">
                                {assign var="altTitle" value="{$viewedproperties[wp].type} - {$viewedproperties[wp].sale} - {$viewedproperties[wp].area} - {$viewedproperties[wp].ref}"}
                                {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$viewedproperties[wp].id_img}_md.jpg")}
                                    {* <img src="/media/images/properties/thumbnails/{$viewedproperties[wp].id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                                    <img src="/img/{$altTitle|slug}_{$viewedproperties[wp].id_img}_xl.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                                {else}
                                    {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
                                {/if}
                            </div>
                            <div class="col">
                                <h3>{$viewedproperties[wp].type} <small>{$viewedproperties[wp].area}</small></h3>
                                <div class="prices">
                                    {if $viewedproperties[wp].precio_desde_prop == 1}
                                        {$lng_from}
                                    {/if}
                                    {if $viewedproperties[wp].precio > 0}
                                        {* {if $viewedproperties[wp].old_precio > 0}
                                            <del>{$viewedproperties[wp].old_precio|number_format:0:",":"."}€</del>
                                        {/if} *}
                                        {$viewedproperties[wp].precio|number_format:0:",":"."}€
                                    {else}
                                        {$lng_consultar}
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            {/section}
            {/if}
        </div>
    </div>
</div>