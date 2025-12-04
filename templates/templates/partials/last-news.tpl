{if {$resource.titulometa} != ''}
    {assign var="link" value="{$urlStart}{$url_news}/{$resource.id_nws}/{$resource.titulometa|slug}/"}
{else}
    {assign var="link" value="{$urlStart}{$url_news}/{$resource.id_nws}/{$resource.titulo|slug}/"}
{/if}

<div class="col-lg-4">

        <div class="noticia">
            {* @group SEC - Imagen *}
            <a href="{$link}">

                <div class="marco-foto">
                    {if $resource.img != ''}
                        {if isset($resource.alt) && $resource.alt != ''}
                            {assign var="altt" value="{$resource.alt}"}
                        {else}
                            {assign var="altt" value="{$resource.titulo}"}
                        {/if}
                        {assign var="imgProp" value="/media/images/news/{$resource.img}"}
                        {imagesize src="{$imgProp}" width=800 height=400 class='img-fluid' alt="{$altt}" title="{$altt}" }
                    {else}
                        {imagesize src='/media/images/website/no-image.png' width=800 height=400 class='img-fluid' alt="{$altt}" title="{$altt}" }
                    {/if}
                </div>

            </a>

            <div class="text-new">

                    {* @group SEC - FECHA 
                    <div class="date">{$resource.date_nws|date_format:"%e %b %Y"}</div>*}

                    {* @group SEC - TITULO *}
                    <h4><a href="{$link}">{$resource.titulo}</a></h4>
                    {* @group SEC - TEXTO 
                    <p>{$resource.contenido|strip_tags|truncate:300:"..."}</p>*}

                    {* @group SEC - BOTÓN *}
                    <a href="{$link}" class="read-more">{$lng_lastnews_readmore}</a>
            </div>
        </div>

</div>