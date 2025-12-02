
<div class="tab-content" id="pn-content" role="tablist">

    <div class="tab-pane" id="pane-caracteristicas">
        {include file="file:modules/property/view/partials/tab-caracteristicas.tpl" }
    </div>
            

   {if isset($property[0].description) && {$property[0].description|strip_tags} != ''}

        <div class="tab-pane" id="pane-descripcion">
          {include file="file:modules/property/view/partials/tab-descripcion.tpl" }
        </div>

    {/if}
    
                
    {if isset($videos[0].video_vid) && $videos[0].video_vid != ''}

        <div class="tab-pane" id="pane-videos">
          {include file="file:modules/property/view/partials/tab-videos.tpl" }
        </div>

    {/if}


    {if isset($images[4].id_img) && $images[4].id_img != ''}

        <div class="tab-pane" id="pane-photos">
          {include file="file:modules/property/view/partials/tab-photos.tpl" }
        </div>

    {/if}
  
    {if isset($view360[0].video_360) && $view360[0].video_360 != ''}

        <div class="tab-pane" id="pane-view360">
          {include file="file:modules/property/view/partials/tab-360.tpl" }
        </div>

    {/if}


    {if isset($property[0].lat) && $property[0].lat != '' || isset($property[0].show_direccion_prop) && $property[0].show_direccion_prop == '1'}

        <div class="tab-pane" id="pane-mapa">
          {include file="file:modules/property/view/partials/tab-mapa.tpl" }
        </div>

    {/if}

    {if isset($zonas[0].titulo) && $zonas[0].titulo != ''}

        <div class="tab-pane" id="pane-zonas">
          {include file="file:modules/property/view/partials/tab-zonas.tpl" }
        </div>

    {/if}

    {if isset($planos[0].id_img) && file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/propertiesplanos/thumbnails/{$planos[0].id_img}_lg.jpg")}

        <div class="tab-pane" id="pane-planos">
          {include file="file:modules/property/view/partials/tab-planos.tpl" }
        </div>

    {/if}

    {if isset($property[0].precio) && {$property[0].precio|number_format:0:",":"."} != 0}

        <div class="tab-pane" id="pane-economia">
          {include file="file:modules/property/view/partials/tab-economia.tpl" }
        </div>

    {/if}

    {if isset($property[0].precio_1_prop) && $property[0].precio_1_prop != '' || isset($property[0].precio_2_prop) && $property[0].precio_2_prop != '' || isset($property[0].precio_3_prop) && $property[0].precio_3_prop != '' || isset($property[0].precio_4_prop) && $property[0].precio_4_prop != '' || isset($property[0].precio_5_prop) && $property[0].precio_5_prop != '' || isset($property[0].precio_6_prop) && $property[0].precio_6_prop != '' || isset($property[0].precio_7_prop) && $property[0].precio_7_prop != '' || isset($property[0].precio_8_prop) && $property[0].precio_8_prop != '' || isset($property[0].precio_9_prop) && $property[0].precio_9_prop != '' || isset($property[0].precio_10_prop) && $property[0].precio_10_prop != '' || isset($property[0].precio_11_prop) && $property[0].precio_11_prop != '' || isset($property[0].precio_12_prop) && $property[0].precio_12_prop != ''}

        <div class="tab-pane" id="pane-preciosmes">
          {include file="file:modules/property/view/partials/tab-preciosmes.tpl" }
        </div>

    {/if}

    {if isset($precios[0].price_prc) && $precios[0].price_prc != ''}

        <div class="tab-pane" id="pane-preciosdia">
          {include file="file:modules/property/view/partials/tab-preciosdia.tpl" }
        </div>

    {/if}

    {if isset($property[0].saleSlug) && ($property[0].saleSlug == 'week' || $property[0].saleSlug == 'month')}

        <div class="tab-pane" id="pane-calendar">
          {include file="file:modules/property/view/partials/tab-calendar.tpl" }
        </div>

    {/if}

    {if isset($files[0].file_fil) && $files[0].file_fil != ''}

        <div class="tab-pane" id="pane-descargas">
          {include file="file:modules/property/view/partials/tab-descargas.tpl" }
        </div>

    {/if}
</div>
