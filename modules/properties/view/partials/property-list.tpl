<div class="col-md-6 col-xl-4 {if isset($smarty.cookies.view) && $smarty.cookies.view == 'list' && $seccion != $url_favorites }property-list-list{/if}">
    <div class="property-list-box">
        {* @group SEC - FAVORITOS *}
        {if $favdos == ''}
            <a href="#" data-href="/modules/property/add-fav.php?fav={$resource.id_prop}" class="add-fav btn {if isset($resource[0]['favorito']) && $resource[0]['favorito'] == '1'}fav-hide{/if}" title="{$lng_anadir_a_favoritos}" rel="nofollow">
                <img src="/media/images/website/properties/icon-favorites.svg" alt="{$lng_anadir_a_favoritos}">
            </a>
        {/if}
        <a href="#" data-href="/modules/property/rem-fav.php?fav={$resource.id_prop}" class="rem-fav{$favdos} btn {if isset($resource[0]['favorito']) && $resource[0]['favorito'] == '0'}fav-hide{/if}" title="{$lng_eliminar_de_favoritos}" rel="nofollow">
            <img src="/media/images/website/properties/icon-favorites-full.svg" alt="{$lng_eliminar_de_favoritos}">
        </a> 
        {* @group SEC - ENLACE *}
        {* <a href="{propURL($resource.id_prop, $lang)}" class="property"> *}
        <div class="property">
            <div class="porta-img">
                {* @group SEC - ETIQUETAS *}
                {if isset($resource.vendido_tag_prop) && $resource.vendido_tag_prop == 1}
                <div class="vendido-tag-big">
                    {$lng_vendido}
                </div>
                {/if}
                <div class="labels">

                    {if {$resource.nuevo_prop|strtotime} >= $smarty.now }
                        <div class="badge bg-success">{$lng_nuevo}</div>
                    {/if}
                    {if $resource.alquilado_prop == 1}
                        <div class="badge bg-danger">{$lng_alquilado}</div>
                    {/if}
                    {if $resource.reservado_prop == 1}
                        <div class="badge bg-danger">{$lng_reservado}</div>
                    {/if}
                    {assign var=tag value=getPropTags($resource.id_prop, $lang)}
                    {section name=tg loop=$tag}
                        {if $tag[tg].tag != ''}
                            <div class="badge  label-{$tag[tg].id_tag}">{$tag[tg].tag}</div>
                        {/if}
                    {/section}
                </div>
                {* @group SEC - IMAGENES *}
                {assign var="altTitle" value="{$resource.type} - {$resource.sale} - {$resource.area} - {$resource.town}"}
                {if isset($resource.total_images) && $resource.total_images > 1}
                    <div class="slides" data-id-prop="{$resource.id_prop}" data-alt="{$altTitle}" data-width="{$thumbnailsSizes['md'][0]}" data-height="{$thumbnailsSizes['md'][1]}" data-url="{propURL($resource.id_prop, $lang)}">
                {/if}
                <div class="slide">
                    <a href="{propURL($resource.id_prop, $lang)}">
                    {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$resource.id_img}_md.jpg")}
                        {* <img src="/media/images/properties/thumbnails/{$resource.id_img}_lg.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                        <img src="/img/{$altTitle|slug}_{$resource.id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                    {else}
                        {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
                    {/if}
                    </a>
                </div>
                {if isset($resource.total_images) && $resource.total_images > 1}
                    <div class="slide">
                        <a href="{propURL($resource.id_prop, $lang)}">
                            {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
                        </a>
                    </div>
                </div>
                {/if}
            </div>

            <a href="{propURL($resource.id_prop, $lang)}" class="textos">
            
                <div class="property-detail">
                
                {* @group SEC - REFERENCIA *}
                <div class="ref">
                    Ref: <strong>{$resource.ref}</strong>
                </div>

               {* @group SEC - TITULOS *}
                <h3 title="{$resource.type} · {$resource.sale}"><strong>{$resource.type}</strong> · {$resource.sale}</h3>
                <h4 title="{$resource.area} {if $resource.area == $resource.town} {else} · {$resource.town}{/if}  · {$resource.province}">{$resource.area} {if $resource.area == $resource.town} {else} · {$resource.town}{/if}  · {if $actCostas == 1 && isset($resource.costa) && $resource.costa != ''}  {$resource.costa} {else} {$resource.province} {/if} </h4>

                        {* @group SEC - ICONOS *}
                        <div  class="icons">
                            <ul>
                                {if {$resource.m2_prop|number_format:0:",":"."} > 0}
                                    <li>
                                        <img src="/media/images/website/properties/house.svg">
                                        <span> {$resource.m2_prop|number_format:0:",":"."}m<sup>2</sup></span>
                                    </li>
                                {/if}
                                {if {$resource.m2p_prop|number_format:0:",":"."} > 0}
                                    <li>
                                        <img src="/media/images/website/properties/plano.svg">
                                        <span class="m2p">{$resource.m2p_prop|number_format:0:",":"."}m<sup>2</sup></span>
                                    </li>
                                {/if}
                                {if {$resource.habitaciones_prop|number_format:0:",":"."} > 0}
                                    <li>
                                        <img src="/media/images/website/properties/bed.svg"> 
                                        <span class="beds">{$resource.habitaciones_prop|number_format:0:",":"."}</span>
                                    </li>
                                {/if}
                                {if {$resource.aseos_prop|number_format:0:",":"."} > 0}
                                    <li>
                                        <img src="/media/images/website/properties/bath.svg">
                                        <span class="baths">{$resource.aseos_prop|number_format:0:",":"."}</span>
                                    </li>
                                {/if}
                                {if $resource.piscina_prop != ''}
                                    <li>
                                         <img src="/media/images/website/properties/pool.svg">
                                         <span>&nbsp;</span>
                                    </li>
                                {/if}
                                {if $resource.parking_prop != ''}
                                    <li>
                                         <img src="/media/images/website/properties/garaje.svg">
                                         <span>&nbsp;</span>
                                    </li>
                                {/if}
                            </ul>
                        </div>


                        <div class="description">
                            {if $resource.descr !=''}
                                {$resource.descr|html_entity_decode|strip_tags|truncate:200:"..."}
                            {else}
                                {$lng_sin_descripcion|html_entity_decode|strip_tags}
                            {/if}
                        </div>
                            

                        {* @group SEC - PRECIOS *}
                        <div class="prices">

                            {if isset($resource.precio_desde_prop) && $resource.precio_desde_prop == 1}
                                <span>{$lng_from}</span> 
                            {/if}
                            {if $resource.precio > 0}
                                {if $resource.old_precio > 0}
                                    <del>{$resource.old_precio|number_format:0:",":"."}€</del>
                                {/if}
                                {$resource.precio|number_format:0:",":"."} €
                            {else}
                                {$lng_consultar}
                            {/if}

                        </div>

                    </div>


                    <span class="view-more">{$lng_mas_informacion}</span>
            </a>
        </div>
        {* </a> *}
    </div>
</div>

