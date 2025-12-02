<ul class="nav nav-tabs nav-fillx scroll-tabs" id="tabs" role="tablist">

  {if {$images|count} > 1}
    <li class="nav-item col pl-0 pr-0">
      <a href="#pane-photos" class="active nav-link" role="tab" id="tab-photos" data-bs-toggle="tab"
        aria-controls="photos">{$lng_photos}</a>
    </li>
  {/if}

  {if $similares[0].id_prop != ''}
    <li class="nav-item col pl-0 pr-0">
      <a href="#pane-propiedades" class="nav-link {if {$images|count} <= 1} active {/if}" role="tab" id="tab-propiedades"
        data-bs-toggle="tab" aria-controls="propiedades">{$lng_property_listings}</a>
    </li>
  {/if}

  <li class="nav-item col pl-0 pr-0">
    <a href="#pane-descripcion" class="nav-link" role="tab" id="tab-descripcion" data-bs-toggle="tab"
      aria-controls="descripcion">{$lng_descripcion}</a>
  </li>

  {if $features[0].feat != ''}
    <li class="nav-item col pl-0 pr-0">
      <a href="#pane-caracteristicas" class="nav-link" role="tab" id="tab-caracteristicas" data-bs-toggle="tab"
        aria-controls="tags">{$lng_caracteristicas}</a>
    </li>
  {/if}

  {if {$videos|count} > 0}
    <li class="nav-item col pl-0 pr-0">
      <a href="#pane-videos" class="nav-link" role="tab" id="tab-videos" data-bs-toggle="tab"
        aria-controls="videos">{$lng_videos}</a>
    </li>
  {/if}

  {if $news[0].lat_long_gp_prop != ''}
    <li class="nav-item col pl-0 pr-0">
      <a href="#pane-mapa" class="nav-link" role="tab" id="tab-mapa" data-bs-toggle="tab"
        aria-controls="mapa">{$lng_mapa}</a>
    </li>
  {/if}

  {if {$files|count} > 0}
    <li class="nav-item col pl-0 pr-0">
      <a href="#pane-files" class="nav-link" role="tab" id="tab-files" data-bs-toggle="tab"
        aria-controls="files">{$lng_descargas}</a>
    </li>
  {/if}

</ul>