<div class="col-md-6  {if $smarty.cookies.view == 'list'&& $seccion != $url_favorites }property-list-list{/if}" id="prop{$resource.id_prop}">
    <div class="property-list-box">
        {* @group SEC - FAVORITOS *}

        {* @group SEC - ENLACE *}
        {* <a href="{propURL($resource.id_prop, $lang)}" class="property"> *}
        <div class="property">
            <div class="porta-img">
                {* @group SEC - ETIQUETAS *}
                <div class="labels">

                    <div class="badge bg-primary">
                        {$resource.sale}
                    </div>

                    {if {$resource.nuevo_prop|strtotime} >= $smarty.now }
                        <div class="badge bg-success">{$lng_nuevo}</div>
                    {/if}
                    {if $resource.vendido_tag_prop == 1}
                        <div class="badge bg-danger">{$lng_vendido}</div>
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
                            <div class="badge bg-dark label-{$tag[tg].id_tag}">{$tag[tg].tag}</div>
                        {/if}
                    {/section}

                </div>
                {* @group SEC - IMAGENES *}
                {assign var="altTitle" value="{$resource.type} - {$resource.sale} - {$resource.area} - {$resource.town}"}
                {if $resource.total_images > 1}
                    <div class="slides" data-id-prop="{$resource.id_prop}" data-alt="{$altTitle}" data-width="{$thumbnailsSizes['md'][0]}" data-height="{$thumbnailsSizes['md'][1]}" data-url="{propURL($resource.id_prop, $lang)}">
                {/if}
                <div class="slide">
                    <a target="_blank"  href="{propURL($resource.id_prop, $lang)}">
                    {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$resource.id_img}_lg.jpg")}
                        {* <img src="/media/images/properties/thumbnails/{$resource.id_img}_lg.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                        <img src="/img/{$altTitle|slug}_{$resource.id_img}_lg.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                    {else}
                        {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
                    {/if}
                    </a>
                </div>
                {if $resource.total_images > 1}
                    <div class="slide">
                        <a href="{propURL($resource.id_prop, $lang)}">
                            {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
                        </a>
                    </div>
                </div>
                {/if}
            </div>

            <a target="_blank"  href="{propURL($resource.id_prop, $lang)}" class="textos">
            
                <div class="property-detail">

               {* @group SEC - TITULOS *}
                <h3 title="{$resource.type} · {$resource.sale}"> Ref #{$resource.ref} · {$resource.type} </h3>
                <h4 title="{$resource.area} {if $resource.area == $resource.town} {else} · {$resource.town}{/if}  · {$resource.province}">{$resource.area} {if $resource.area == $resource.town} {else} · {$resource.town}{/if}  · {$resource.province}</h4>

                {* @group SEC - ICONOS *}
                           <div  class="icons px-3">
                                <ul>
                                {if {$resource.m2_prop|number_format:0:",":"."} > 0}
                                    <li class="m-0 pe-3">
                                        <img src="/media/images/website/properties/house.svg">
                                        <span class="p-0"> {$resource.m2_prop|number_format:0:",":"."}m<sup>2</sup></span>
                                        {* {$lng_construido_pr} *}
                                    </li>
                                {/if}
                                {if {$resource.m2p_prop|number_format:0:",":"."} > 0}
                                    <li class="m-0 pe-3">
                                        <img src="/media/images/website/properties/plano.svg">
                                        <strong class="mx-1">·</strong>
                                        <span class="m2p p-0">{$resource.m2p_prop|number_format:0:",":"."}m<sup>2</sup></span>
                                        {* {$lng_parcela} *}
                                    </li>
                                {/if}
                                {if {$resource.habitaciones_prop|number_format:0:",":"."} > 0}
                                    <li class="m-0 pe-3">
                                        <img src="/media/images/website/properties/bed.svg">
                                        <strong class="mx-1">·</strong>
                                        <span class="beds p-0">{$resource.habitaciones_prop|number_format:0:",":"."}</span>
                                        {* {$lng_habitaciones} *}
                                    </li>
                                {/if}
                                {if {$resource.aseos_prop|number_format:0:",":"."} > 0}
                                    <li class="m-0 pe-3">
                                        <img src="/media/images/website/properties/bath.svg">
                                        <strong class="mx-1">·</strong>
                                        <span class="baths p-0">{$resource.aseos_prop|number_format:0:",":"."}</span>
                                        {* {$lng_banos} *}
                                    </li>
                                {/if}
                                {if $resource.piscina_prop != ''}
                                    <li class="m-0 pe-3">
                                        <img src="/media/images/website/properties/pool.svg">
                                        <strong class="mx-1">·</strong>
                                        {* {$lng_piscina} *}
                                    </li>
                                {/if}
                                {if $resource.parking_prop != ''}
                                    <li class="m-0 pe-3">
                                        <img src="/media/images/website/properties/garaje.svg">
                                        <strong class="mx-1">·</strong>
                                        {* {$lng_garaje} *}
                                    </li>
                                {/if}
                                </ul>
                            </div>

      {*           <div class="description">
                    {if $resource.descr !=''}
                        {$resource.descr|html_entity_decode|strip_tags|truncate:200:"..."}
                    {else}
                        {$lng_sin_descripcion|html_entity_decode|strip_tags}
                    {/if}
                </div> *}


                {* @group SEC - PRECIOS *}
                <div class="prices">

                        {if $resource.precio_desde_prop == 1}
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

                        <svg xmlns="http://www.w3.org/2000/svg" width="14.645" height="14.645" viewBox="0 0 14.645 14.645">
                            <g data-name="Icon feather-arrow-up-right">
                                <path class="arrow-top" data-name="Trazado 467" d="M10.5 24.291 24.291 10.5" transform="translate(-10.146 -10)"/>
                                <path class="arrow-bot" data-name="Trazado 468" d="M10.5 10.5h13.791v13.791"  transform="translate(-10.146 -10)"/>
                            </g>
                        </svg>


                </div>

                </div>
            </a>
        </div>
        {* </a> *}
    </div>
</div>

<div class="col-md-6 rounded-5 mb-5 p-5" style="background: #f6f6f6; ">
    <h2 class="mb-4">{$lng_rate_this_property}</h2>
    <div class="ratecont">

        <input type="hidden" name="id_prop_rate" id="id_prop_rate" class="id_prop_rate" value="{$resource.id_prop}">

        <div>
            <input type="radio" class="btn-check check-rate" name="rate{$resource.id_prop}" id="rate1{$resource.id_prop}" value="1" autocomplete="off">
            <label class="btn btn-outline-primary" for="rate1{$resource.id_prop}"><img src="/media/images/website/thumbs-up-solid.svg" style="height: 25px;"></label>

            <input type="radio" class="btn-check check-rate" name="rate{$resource.id_prop}" id="rate0{$resource.id_prop}" value="0" autocomplete="off">
            <label class="btn btn-outline-primary" for="rate0{$resource.id_prop}"><img src="/media/images/website/thumbs-down-solid.svg" style="height: 25px;"></label>
        </div>
        <p class="lead my-4"><strong style="font-weight: 600">{$lng_tell_us_the_reason}:</strong></p>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input locationchck" type="checkbox" role="switch" name="location" id="location{$resource.id_prop}" value="1">
            <label class="form-check-label" for="location{$resource.id_prop}">{$lng_localizacion}</label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input typechck" type="checkbox" role="switch" name="type" id="type{$resource.id_prop}" value="1">
            <label class="form-check-label" for="type{$resource.id_prop}">{$lng_tipo}</label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input pricechck" type="checkbox" role="switch" name="price" id="price{$resource.id_prop}" value="1">
            <label class="form-check-label" for="price{$resource.id_prop}">{$lng_precio}</label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input bedroomschck" type="checkbox" role="switch" name="bedrooms" id="bedrooms{$resource.id_prop}" value="1">
            <label class="form-check-label" for="bedrooms{$resource.id_prop}">{$lng_habitaciones}</label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input otherchck" type="checkbox" role="switch" name="other" id="other{$resource.id_prop}" value="1">
            <label class="form-check-label" for="other{$resource.id_prop}">{$lng_otros}</label>
        </div>

        <a href="#" class="btn btn-primary mt-2 btn-ratecont text-uppercase text-white">{$lng_rate_this_property}</a>

    </div>
</div>
