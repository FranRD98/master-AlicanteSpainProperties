<div class="slides-item">
    {* @group SEC - FAVORITOS *}
    <a href="#" data-href="/modules/property/add-fav.php?fav={$resource.id_prop}" class="add-fav btn {if in_array($resource.id_prop, $theFavs)}fav-hide{/if}" title="{$lng_anadir_a_favoritos}" rel="nofollow">
        <img height="22" width="22" src="/media/images/website/properties/heart.svg" alt="{$lng_anadir_a_favoritos}">
    </a>
    <a href="#" data-href="/modules/property/rem-fav.php?fav={$resource.id_prop}" class="rem-fav btn {if empty($theFavs) || !in_array($resource.id_prop, $theFavs)}fav-hide{/if}" title="{$lng_eliminar_de_favoritos}" rel="nofollow">
        <img height="22" width="22" src="/media/images/website/properties/heart-full.svg" alt="{$lng_eliminar_de_favoritos}">
    </a>
    {* @group SEC - PROPIDAD *}
    <a href="{propURL($resource.id_prop, $lang)}" class="property-featured">

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
                {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$resource.id_img}_md.jpg")}
                    <img width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} src="/img/{$altTitle|slug}_{$resource.id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                    {* <img height="22" width="" src="/media/images/properties/thumbnails/{$resource.id_img}_lg.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}"> *}
                {else}
                    {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' alt="{$altTitle}" title="{$altTitle}" }
                {/if}
        </div>


        <div class="property-detail">

        {* @group SEC - ICONOS *}
            <div  class="icons">
                <ul>
                    {if {$resource.m2_prop|number_format:0:",":"."} > 0}
                        <li>
                            <img alt="Meters" height="27" width="27" src="/media/images/website/properties/house.svg">
                            <span> {$resource.m2_prop|number_format:0:",":"."}m<sup>2</sup></span>
                        </li>
                    {/if}
                    {if {$resource.m2p_prop|number_format:0:",":"."} > 0}
                        <li>
                            <img alt="{$lng_parcela}" height="26" width="28" src="/media/images/website/properties/plano.svg">
                            <span class="m2p">{$resource.m2p_prop|number_format:0:",":"."}m<sup>2</sup></span>
                        </li>
                    {/if}
                    {if {$resource.habitaciones_prop|number_format:0:",":"."} > 0}
                        <li>
                            <img alt="{$lng_habitaciones}" height="29" width="26" src="/media/images/website/properties/bed.svg"> 
                            <span class="beds">{$resource.habitaciones_prop|number_format:0:",":"."}</span>
                        </li>
                    {/if}
                    {if {$resource.aseos_prop|number_format:0:",":"."} > 0}
                        <li>
                            <img alt="{$lng_banos}" height="31" width="28" src="/media/images/website/properties/bath.svg">
                            <span class="baths">{$resource.aseos_prop|number_format:0:",":"."}</span>
                        </li>
                    {/if}
                    {if $resource.parking_prop != ''}
                        <li>
                             <img alt="{$lng_garaje}" height="28" width="27" src="/media/images/website/properties/garaje.svg">
                             <span>&nbsp;</span>
                        </li>
                    {/if}
                    {if $resource.piscina_prop != ''}
                        <li>
                             <img alt="{$lng_piscina}" height="25" width="27" src="/media/images/website/properties/pool.svg">
                             <span>&nbsp;</span>
                        </li>
                    {/if}

                </ul>
            </div>

    {* @group SEC - TITULOS *}
    {*<h4 title="{$resource.area} {if $resource.area == $resource.town} {else} · {$resource.town}{/if}  · {$resource.province}">*}
    <h4 title="{$resource.area} · {$resource.province}">

        <svg xmlns="http://www.w3.org/2000/svg" width="22.504" height="26.109" viewBox="0 0 22.504 26.109">
            <g data-name="Grupo 9619">
                <g data-name="Unión 1" style="fill:none">
                    <path d="M0 16.106a5.08 5.08 0 0 1 3.482-4.823v-8.5A3.62 3.62 0 0 1 2.176 0H14.51a3.621 3.621 0 0 1-1.31 2.788v8.5a5.081 5.081 0 0 1 3.483 4.823z" style="stroke:none" transform="rotate(30 4.026 15.028)"/>
                    <path d="M14.86 14.606a3.571 3.571 0 0 0-2.127-1.898l-1.03-.34V2.085l.54-.45c.052-.043.101-.089.148-.136H4.295c.047.047.096.092.148.135l.54.45v10.282l-1.03.34a3.57 3.57 0 0 0-2.125 1.9h13.031m1.828 1.5H0a5.08 5.08 0 0 1 3.482-4.823V2.787A3.62 3.62 0 0 1 2.176 0H14.51a3.62 3.62 0 0 1-1.306 2.788v8.496a5.081 5.081 0 0 1 3.483 4.822z" style="fill:#29bdef;stroke:none" transform="rotate(30 4.026 15.028)"/>
                </g>
                <path data-name="Trazado 15788" d="M-19514 13012v8.75" transform="rotate(30 14493.49 42942.3)" style="stroke:#29bdef;stroke-width:1.5px;fill:none"/>
            </g>
        </svg>
            {*{if $resource.area == $resource.town} {else} · {$resource.town}{/if} · {if $actCostas == 1 && $resource.costa != ''}  {$resource.costa} {else} {$resource.province} {/if} *}
            <span class="area">{$resource.area}.</span> 

            <span class="provincia">{$resource.province}</span>
    
            <h3 title="{$resource.type} · {$resource.sale}">{$resource.type} · {$resource.sale}</h3>

        </h4>
            
            {* @group SEC - REFERENCIA *}
            <div class="ref">
                <div class="ref-line"></div>
                Ref: {$resource.ref}
            </div>




            

            {*  Lista en texto.           
        
                div  class="icons">
                    <ul>
                        {if {$resource.m2_prop|number_format:0:",":"."} > 0}

                            <li>
                                <span> {$lng_meters}: <strong>{$resource.m2_prop|number_format:0:",":"."} m<sup>2</sup></strong></span>
                            </li>
                        {/if}
                        {if {$resource.m2p_prop|number_format:0:",":"."} > 0}

                            <li>
                                <span class="m2p">  {$lng_parcela}:  <strong>{$resource.m2p_prop|number_format:0:",":"."}m<sup>2</sup></strong> </span>
                            </li>
                            
                        {/if}
                        {if {$resource.habitaciones_prop|number_format:0:",":"."} > 0}
                            <li>
                                <span class="beds"> {$lng_habitaciones}: <strong>{$resource.habitaciones_prop|number_format:0:",":"."}</strong> </span>
                            </li>
                        {/if}
                        {if {$resource.aseos_prop|number_format:0:",":"."} > 0}
                            <li>
                              <span class="baths"> {$lng_banos}: <strong>{$resource.aseos_prop|number_format:0:",":"."}</strong> 
                            </li>
                        {/if}
                        {if $resource.piscina_prop != ''}
                            <li>
                              <span> <strong>{$lng_piscina}</strong></span>
                            </li>
                        {/if}
                        {if $resource.parking_prop != ''}
                            <li>
                              <span><strong>{$lng_garaje}</strong></span>
                            </li>
                        {/if}
                    </ul>
                </div> *}


            {* @group SEC - PRECIOS *}
            <div class="prices">

                {if $resource.precio_desde_prop == 1}
                    <span>{$lng_from}</span> 
                {/if}
                {if $resource.precio > 0}
                    {if $resource.old_precio > 0}
                        <del>€{$resource.old_precio|number_format:0:",":"."}</del>
                    {/if}
                    <span>€</span>{$resource.precio|number_format:0:",":"."} 
                {else}
                    {$lng_consultar}
                {/if}

            </div>

        </div>


        <span class="view-more">+</span>

    </a>
</div>
