<h3 class="main-title">{$lng_descripcion}</h3>

<div class="row justify-content-center pb-3">
    <div class="col-lg-12">
        <div class="bloque-texto">

            <div class="collapse collapsed-text" id="collapseText" aria-expanded="false">

                {if {$news[0].contenido|strip_tags} != ''}

                    <div class="property-description">
                        {if $news[0].contenido|preg_match:"/<p>/"}
                            {$news[0].contenido|html_entity_decode}
                        {else}
                            <p>{$news[0].contenido|html_entity_decode}</p>
                        {/if}
                    </div>

                {/if}

            </div>

            <div class="mt-4 ps-lg-0">
                <a class="btn-collapse collapsed" data-bs-toggle="collapse" href="#collapseText"
                    aria-expanded="false" aria-controls="collapseText">
                    {$lng_more_info}<span class="btn-button ms-3 text-primary"></span>
                </a>
            </div>
        </div>
    </div>
</div>