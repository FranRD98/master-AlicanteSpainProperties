    <div class="tab-content" id="pn-content" role="tablist">

        {if $features[0].feat != ''}
            <div class="tab-pane" id="pane-caracteristicas">
                {include file="file:modules/promociones/view/partials/tab-caracteristicas.tpl" }
            </div>
        {/if}

{*         {if $news[0].tags != ''}
            <div class="tab-pane" id="pane-caracteristicas">
                {include file="file:modules/promociones/view/partials/tab-caracteristicas.tpl" }
            </div>
        {/if} *}

        {if {$images|count} > 1}
            <div class="tab-pane" id="pane-photos">
                {include file="file:modules/promociones/view/partials/tab-photos.tpl" }
            </div>
        {/if}

        {if $similares[0].id_prop != ''}
            <div class="tab-pane" id="pane-propiedades">
                {include file="file:modules/promociones/view/partials/tab-propiedades.tpl" propiedades=$similares }
            </div>
        {/if}

        {if $news[0].contenido != ''}
            <div class="tab-pane" id="pane-descripcion">
                {include file="file:modules/promociones/view/partials/tab-descripcion.tpl" }
            </div>
        {/if}

        {if {$videos|count} > 0}
            <div class="tab-pane" id="pane-videos">
                {include file="file:modules/promociones/view/partials/tab-videos.tpl" }
            </div>
        {/if}

        {if $news[0].lat_long_gp_prop != '' || $localizacionReferencia != ''}
            <div class="tab-pane" id="pane-mapa">
                <h3 class="main-title">{$lng_mapa}</h3>
                <div class="porta-gmap">
                    <div class="gmap" id="gmap"></div>
                </div>
            </div>
        {/if}

        {if {$files|count} > 0}
            <div class="tab-pane" id="pane-files">
                {include file="file:modules/promociones/view/partials/tab-files.tpl" }
            </div>
        {/if}


</div>