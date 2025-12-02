{* <div class="col-xl-6"> *}
    <div class="testimonial">
        <div class="row align-items-center">
            <div class="col-xl-3 text-center order-1">
                <div class="imagen">
                    {if $resource.titulometa != ''}
                        <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulometa|slug}/">
                    {else}
                        <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulo|slug}/">
                    {/if}
                    {if $resource.img != ''}
                        {assign var="imgProp" value="/media/images/news/{$resource.img}"}
                    {imagesize src="{$imgProp}" width=400 height=400 class='img-fluid mx-auto' alt="{$resource.titulo}" title="{$resource.titulo}" }
                    {else}
                        {imagesize src='/media/images/website/no-image.png' width=400 height=400 class='img-fluid mx-auto' alt="{$resource.titulo}" title="{$resource.titulo}" }
                    {/if} </a>
                </div>        
            </div>
            <div class="col-xl-9 order-3 order-xl-2">
                <div class="textos ml-lg-3">
                    {if $resource.titulometa != ''}
                        <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulometa|slug}/">
                    {else}
                        <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulo|slug}/">
                    {/if}
                    {* <span class="date">{$resource.date_nws|date_format:"%e %b %Y"}</span> *}
                    <p>{$resource.contenido|strip_tags|truncate:300:"..."}</p>
                    {* {if $resource.titulometa != ''}
                        <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulometa|slug}/" title="{$resource.titulo}" class="btn">{$lng_leer_mas} <i class="fas fa-long-arrow-right"></i></a>
                    {else}
                        <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulo|slug}/" title="{$resource.titulo}" class="btn">{$lng_leer_mas} <i class="fas fa-long-arrow-right"></i></a>
                    {/if} *}
                    </a>
                </div>  
            </div>
            <div class="col-xl-3 text-center order-2 order-xl-3">
                {if $resource.titulometa != ''}
                        <h3 class="subtitle-testimonial"><a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulometa|slug}/" title="{$resource.titulo}">{$resource.titulo}</a></h3>
                    {else}
                        <h3 class="subtitle-testimonial"><a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulo|slug}/" title="{$resource.titulo}">{$resource.titulo}</a></h3>
                    {/if}
            </div>
        </div>
    </div>
{* </div> *}