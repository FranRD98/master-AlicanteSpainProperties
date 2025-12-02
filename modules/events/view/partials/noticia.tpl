{assign var="link" value="{$urlStart}{$url_events}/{$resource.id_nws}/{$resource.titulo|slug}/"}

<div class="col-md-6">
    <div class="noticia">
        {* @group SEC - Imagen *}
        <a href="{$link}">

            <div class="marco-foto mb-3 rounded">


                {if $resource.img != ''}


                    {if $resource.banner != '' }

                        {assign var="imgProp" value="/media/images/news/{$resource.banner}"}
                        
                        {if isset($resource.alt) && $resource.alt != ''}
                            {assign var="altt" value="{$resource.altbanner}"}
                        {else}
                            {assign var="altt" value="{$resource.titulo}"}
                        {/if}

                    {else}    

                        {assign var="imgProp" value="/media/images/news/{$resource.img}"}

                        {if isset($resource.alt) && $resource.alt != ''}
                            {assign var="altt" value="{$resource.alt}"}
                        {else}
                            {assign var="altt" value="{$resource.titulo}"}
                        {/if}

                    {/if}

                    {imagesize src="{$imgProp}" width=720 height=340 class='img-fluid d-none d-md-block' alt="{$altt}" title="{$altt}" }


                    {if $resource.mobile != '' }
                        {assign var="imgPropResp" value="/media/images/news/{$resource.mobile}"}
                    {else}
                        {assign var="imgPropResp" value="/media/images/news/{$resource.img}"}
                    {/if}

                     {imagesize src="{$imgPropResp}" width=640 height=640 class='img-fluid d-md-none' alt="{$altt}" title="{$altt}" }

                {else}
                    {imagesize src='/media/images/website/no-image.png' width=720 height=340 class='img-fluid' alt="{$altt}" title="{$altt}" }
                {/if}

            </div>

        </a>

        <a href="{$link}" class="text-new p-4 bg-light rounded d-block">

                <h4 class="mb-3">{$resource.titulo}</h4>

                <div class="labels text-uppercase mb-3">
                    {if $resource.tipo != 0 || $resource.tipo != ''}
                        <div class="badge bg-info">
                            {if $resource.tipo == 1}
                                Online
                            {else if $resource.tipo == 2}
                                {$lng_presencial}
                            {/if}
                        </div>
                    {/if}
                    {if $resource.finalizado == 1}
                        <div class="badge bg-danger">
                            {$lng_finalizado}
                        </div>
                    {/if}
                </div>
                 {* @group SEC - FECHA *}
                    <div class="date">
                        <strong class="text-uppercase d-block text-primary">
                            {$lng_fecha}:
                        </strong>
                        {$resource.date_nws|date_format:"%e %b %Y - %H:%M"}
                    </div>
                    <div class="date location">
                        <strong class="text-uppercase d-block text-primary">
                            {$lng_localizacion}:
                        </strong>
                        {$resource.ubicacion}
                    </div>
                   

                  {* RESUMEN *}  
                  <p>
                    {$resource.resumen|strip_tags|truncate:250:"..."}
                  </p>

                   <span class="btn btn-primary d-block">{$lng_mas_informacion}</span>

        </a>
    </div>
</div>