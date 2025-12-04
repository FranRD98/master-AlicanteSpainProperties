{* <div class="col-xl-6"> *}
    <div class="testimonial">
    <div class="row align-items-center">

        {* IMAGEN *}
        <div class="col-xl-3 text-center">
            <div class="imagen">
                <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{($resource.titulometa|default:$resource.titulo)|slug}/">
                    {if $resource.img != ''}
                        {assign var="imgProp" value="/media/images/news/{$resource.img}"}
                        {imagesize src="{$imgProp}" width=400 height=400 class='img-fluid mx-auto' alt="{$resource.titulo}" title="{$resource.titulo}" }
                    {else}
                        {imagesize src='/media/images/website/no-image.png' width=400 height=400 class='img-fluid mx-auto' alt="{$resource.titulo}" title="{$resource.titulo}" }
                    {/if}
                </a>
            </div>
        </div>

        {* TEXTO *}
        <div class="col-xl-9">
            <div class="textos ml-lg-3">

                {* NOMBRE *}
                <h3 class="title-testimonial">
                    <div class="ref-line"></div>
                    <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{($resource.titulometa|default:$resource.titulo)|slug}/" 
                        title="{$resource.titulo}">

                        {$resource.titulo}
                    </a>
                </h3>

                {* DESCRIPCIÓN *}
                <p>{$resource.contenido|strip_tags|truncate:300:"..."}
                    
                    {* LEER MÁS *}
                    <a href="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{($resource.titulometa|default:$resource.titulo)|slug}/" 
                        title="{$resource.titulo}" 
                        class="btn btn-link p-0 leer-mas">
                        {$lng_testimonials_readmore}
                    </a>
                </p>

            </div>
        </div>

    </div>
</div>
{* </div> *}