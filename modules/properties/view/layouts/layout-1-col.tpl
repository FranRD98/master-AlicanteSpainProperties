<!-- Contenedor ancho para el fondo -->
<div class="buscador-wrapper full-width">
    <!-- Contenido limitado centrado -->
    <div class="container">
        <div class="buscador b-properties">
            {include file="partials/buscador.tpl" dupl=1}
        </div>
    </div>
</div>

<div class="container">
    <div class="row" style="background-color: #f8f8f8;">
        <div class="col-md-12 order-md-2">
            <div class="sidebar-content-full">
                {include file="file:modules/properties/view/partials/listado.tpl" proparray=$proparray numberprops=$numberprops showshor=$showshor}
            </div>
        </div>
        {if $hidesearch != '1'}


        {/if}
        
        {if isset($viewedproperties[0]) && $viewedproperties[0].id_prop != ''}
        <div class="col-12 order-last">
            <h2 class="main-title text-center mt-3 mb-4">
                
                {$lng_ultimas_propiedades_vistas}

            </h2>
        </div>

        <div class="col-12 order-last">
              <div class="row justify-content-center">
                  {section name=wp loop=$viewedproperties}
                      <div class="col-12 col-lg-4 order-md-12 viewed-props-full">
                          {include file="file:modules/properties/view/partials/viewed-properties.tpl"}
                      </div>
                  {/section}
              </div>
          </div>

        {/if}
    </div>
</div>
