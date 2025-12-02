<ul class="nav nav-tabs nav-fillx scroll-tabs" id="tabs" role="tablist">

    <li class="nav-item col pl-0 pr-0"><a href="#pane-caracteristicas" class="nav-link active" role="tab" id="tab-caracteristicas"  data-bs-toggle="tab" aria-controls="caracteristicas">{$lng_caracteristicas}</a></li>

    {if isset($property[0]) && {$property[0].description|strip_tags} != ''}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-descripcion" class="nav-link" role="tab" id="tab-descripcion" data-bs-toggle="tab" aria-controls="descripcion">{$lng_descripcion}</a></li>
    {/if}
    
    {if isset($videos[0]) && $videos[0].video_vid != ''}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-videos"  class="nav-link" role="tab" id="tab-videos" data-bs-toggle="tab" aria-controls="videos">{$lng_videos}</a></li>
    {/if}

    {if isset($images[4]) && $images[4].id_img != ''}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-photos"  class="nav-link" role="tab" id="tab-photos" data-bs-toggle="tab" aria-controls="videos">{$lng_imagenes}</a></li>
    {/if}

    {if isset($view360[0]) && $view360[0].video_360 != ''}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-view360"  class="nav-link" role="tab" id="tab-videos" data-bs-toggle="tab" aria-controls="videos">{$lng_vista_360}</a></li>
    {/if}

    {if isset($property[0]) && ($property[0].lat > 0 || $property[0].show_direccion_prop == '1')}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-mapa"  class="nav-link" role="tab" id="tab-mapa" data-bs-toggle="tab" aria-controls="mapa">{$lng_localizacion}</a></li>
    {/if}

    {if isset($zonas[0]) && $zonas[0].titulo != ''}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-zonas"  class="nav-link" role="tab" id="tab-zonas" data-bs-toggle="tab" aria-controls="zonas">{$lng_zona}</a></li>
    {/if}

    {if isset($planos[0]) && file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/propertiesplanos/thumbnails/{$planos[0].id_img}_lg.jpg")}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-planos"  class="nav-link" role="tab" id="tab-planos" data-bs-toggle="tab" aria-controls="planos">{$lng_planos}</a></li>
    {/if}

    {if isset($property[0]) && {$property[0].precio|number_format:0:",":"."} != 0}
        <li class="nav-item col pl-0 pr-0"><a href="#"  class="nav-link" data-bs-toggle="modal" data-bs-target="#economyModal">{$lng_economia}</a></li>
    {/if}

    {if isset($property[0]) && ($property[0].precio_1_prop != '' || $property[0].precio_2_prop != '' || $property[0].precio_3_prop != '' || $property[0].precio_4_prop != '' || $property[0].precio_5_prop != '' || $property[0].precio_6_prop != '' || $property[0].precio_7_prop != '' || $property[0].precio_8_prop != '' || $property[0].precio_9_prop != '' || $property[0].precio_10_prop != '' || $property[0].precio_11_prop != '' || $property[0].precio_12_prop != '')}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-preciosmes"  class="nav-link" role="tab" id="tab-preciosmes" data-bs-toggle="tab" aria-controls="preciosmes">{$lng_precios_mensuales}</a></li>
    {/if}

    {if isset($precios[0]) && $precios[0].price_prc != ''}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-preciosdia"  class="nav-link" role="tab" id="tab-preciosdia" data-bs-toggle="tab" aria-controls="preciosdia">{$lng_precios_por_dia}</a></li>
    {/if}

    {if isset($property[0]) && ($property[0].saleSlug == 'week' || $property[0].saleSlug == 'month')}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-calendar"  class="nav-link" role="tab" id="tab-calendar" data-bs-toggle="tab" aria-controls="calendar">{$lng_disponibilidad}</a></li>
    {/if}

    {if isset($files[0]) && $files[0].file_fil != ''}
        <li class="nav-item col pl-0 pr-0"><a href="#pane-descargas"  class="nav-link" role="tab" id="tab-descargas" data-bs-toggle="tab" aria-controls="descargas">{$lng_descargas}</a></li>
    {/if}

</ul>
