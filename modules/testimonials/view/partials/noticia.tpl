    
{assign var="link" value="{$urlStart}{$url_testimonials}/{$resource.id_nws}/{$resource.titulo|slug}/"}

<a href="{$link}" class="testimonial text-decoration-none">

    <div class="row align-items-start">
        
        {if $resource.img != ''}
            <div class="col-md-4">
                <div class="imagen">

                    {if isset($resource.alt) && $resource.alt != ''}
                        {assign var="altt" value="{$resource.alt}"}
                    {else}
                        {assign var="altt" value="{$resource.titulo}"}
                    {/if}

                    {assign var="imgProp" value="/media/images/news/{$resource.img}"}
                    {imagesize src="{$imgProp}" width=320 height=320 class='img-fluid rounded-circle' alt="{$altt}" title="{$altt}" }

                </div>
            </div>    
        {/if}
        
        <div class="{if $resource.img != ''} col-md-8 {else} col-12 {/if}">

            <div class="contenido-testimonio">
                {* @group SEC - TITULO *}
                <h3>{$resource.titulo}</h3>
                {* @group SEC - TEXTO *}
                <p class="description">{$resource.contenido|html_entity_decode|strip_tags|truncate:280:"..."}</p>
            </div>

        </div>

    </div>
  
</a>