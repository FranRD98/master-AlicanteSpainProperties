<div class="property-title">
    <div class="container">
            <div class="row g-4 pt-0 align-items-center">
                <div class="col-lg-6 text-start d-none d-lg-block">
                    {* @group SEC - TITULO *}
                    {include file="file:modules/property/view/partials/titulo.tpl" }
                </div>
                <div class="col-lg-6">
                    
                    <div class="row align-items-center">

                        <div class="col-12 col-md-4 text-center text-lg-end price-responsive">
                            {* @group SEC - PRECIO *}
                            {include file="file:modules/property/view/partials/precio.tpl" }
                        </div>

                        <div class="col-6 col-md-4 d-grid">
                            <a href="#" data-href="/modules/property/add-fav.php?fav={$property[0].id_prop}" class="btn btn-outline-primary add-fav {if $isFav == '1'}fav-hide{/if}" title="{$lng_anadir_a_favoritos}" rel="nofollow"><i class="far fa-heart"></i><span>{$lng_anadir_a_favoritos}</span></a>

                             <a href="#" data-href="/modules/property/rem-fav.php?fav={$property[0].id_prop}" class="btn btn-outline-primary rem-fav {if $isFav == '0'}fav-hide{/if}" title="{$lng_eliminar_de_favoritos}" rel="nofollow"><i class="fa fa-heart"></i><span>{$lng_eliminar_de_favoritos}</span></a>
                        </div>
                        <div class="col-6 col-md-4 d-grid">
                            <a class="btn btn-primary toForm btn-enquiry">
                                {$lng_make_an_enquiry}
                            </a>
                        </div>

                    </div>

                </div>       
            </div>
       </div>
</div>

{* @group SEC - GALERÍA FULL *}

<div class="property-gallery">

   {if $tipoGaleria == 1}

   <div class="property-gal">
        <div class="container">
            {include file="file:modules/property/view/partials/etiquetas.tpl" }
             {include file="file:modules/property/view/partials/galeria.tpl" }
        </div>
    </div>

    {else if $tipoGaleria == 2}

        <div class="gallery-full">

            <div class="container-fluid px-0">
                <div class="row g-0 ">
                    <div class="col-md-12">
                        <div class="property-gal">
                            {include file="file:modules/property/view/partials/etiquetas.tpl" }
                        </div>
                    </div>
                </div>

                {include file="file:modules/property/view/partials/galeria2.tpl"}
            </div>

        </div> 

    {else}

        {*  Galería en forma de grid. Foto grande y 2 fotos pequeñas. Habría que ajustarla al diseño  *}

        <div class="gallery-grid">
            <div class="container">

                <div class="property-gal">
                    {include file="file:modules/property/view/partials/etiquetas.tpl" }
                </div>

                {include file="file:modules/property/view/partials/galeria3.tpl"}
            </div>
        </div> 

    {/if}

    {if $galeriaModal == 1}

         {include file="file:modules/property/view/partials/modal-gallery.tpl" }

    {/if}


</div>

{* @group SEC - CONTENIDO *}
<div class="property-data">
    <div class="container">
        <div class="row">
            <div class="col-12">

                {* @group SEC - TABS *}
                {include file="file:modules/property/view/partials/tabs.tpl" }

                <div class="d-lg-none">
                    {* @group SEC - TITULO PARA RESPONSIVE *}
                    {include file="file:modules/property/view/partials/titulo.tpl" }
                </div>

                {* @group SEC - BOTONES *}
                {include file="file:modules/property/view/partials/botonera.tpl" }

                {* @group SEC - TITULO H1 CUSTOM *}
                {if $property[0].titulo != ''}
                    <h1 class="main-title">
                        {$property[0].titulo}
                    </h1>
                {/if}

                {* @group SEC - ICONOS *}
                {include file="file:modules/property/view/partials/iconos.tpl" }

                {* @group SEC - TABS PANELS *}
                {include file="file:modules/property/view/partials/tabs-panels.tpl" }

            </div>

        </div>
    </div>
</div>


<div class="container">
        {* @group SEC - CONTACTAR *}
        {include file="file:modules/property/view/partials/contactar.tpl" }
</div>