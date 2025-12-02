<div class="property-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                {* @group SEC - TITULO *}
                {include file="file:modules/property/view/partials/titulo.tpl" }
                {* @group SEC - REFERENCIA *}
                <div class="referencia float-start">
                    {$lng_ref_}:<strong>{$property[0].ref}</strong>
                </div>
                {* @group SEC - ICONOS *}
                {include file="file:modules/property/view/partials/iconos.tpl" }
            </div>
            <div class="col-md-4">
                {* @group SEC - PRECIO *}
                {include file="file:modules/property/view/partials/precio.tpl" }
                {* @group SEC - BOTONES *}
                {* {include file="file:modules/property/view/partials/botonera.tpl" } *}
            </div>
        </div>
    </div>
</div>
<div class="property-gallery">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="property-gal">
                    {* @group SEC - GALERÍA *}
                    {include file="file:modules/property/view/partials/etiquetas.tpl" }
                    <div class="energia">
                        <img class="img-fluid" src="/media/images/website/energia.png" alt="{$lng_calificacion_energetica}">
                        <span>{if $property[0].energia_prop != ''}{$property[0].energia_prop}{else}{$lng_en_proceso}{/if}</span>
                    </div>
                    {include file="file:modules/property/view/partials/galeria.tpl" }
                </div>
            </div>
            <div class="col">
                {* @group SEC - CONTACTAR *}
                {include file="file:modules/property/view/partials/contactar.tpl" }
                {* @group SEC - BOTONES *}
                {include file="file:modules/property/view/partials/botonera.tpl" }
            </div>
        </div>
    </div>
</div>
{* @group SEC - CONTENIDO *}
<div class="property-data">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {* @group SEC - TABS *}
                {include file="file:modules/property/view/partials/tabs.tpl" }
                {* @group SEC - TITULO *}
                {if $property[0].titulo != ''}
                    <h1 class="main-title">
                        {$property[0].titulo}
                    </h1>
                {/if}
                {* @group SEC - TABS PANELS *}
                {include file="file:modules/property/view/partials/tabs-panels.tpl" }
            </div>
        </div>
    </div>
</div>
