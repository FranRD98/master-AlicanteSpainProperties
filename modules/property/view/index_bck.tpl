{include file="header.tpl"}

{assign var="title" value="{$property[0].sale} - {$property[0].type} - {$property[0].area}{if $property[0].area != $property[0].town} - {$property[0].town}{/if}"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    {* @group SEC - BREADCRUMBS *}
                    {include file="file:modules/property/view/partials/breadcum.tpl" }
                </div>
                {* @group SEC - VOLVER *}
                <a href="{$smarty.server.HTTP_REFERER}" class="btn btn-default btn-volver">{$lng_volver_a_resultados_de_busqueda}</a>
                {* @group SEC - ALERTAS *}
                {include file="file:modules/property/view/partials/alertas.tpl" }
                <div class="row">
                    <div class="col-md-9">
                        {* @group SEC - TITULO *}
                        {include file="file:modules/property/view/partials/titulo.tpl" }
                        {* @group SEC - ICONOS *}
                        {include file="file:modules/property/view/partials/iconos.tpl" }
                    </div>
                    <div class="col-md-3">
                        {* @group SEC - PRECIO *}
                        {include file="file:modules/property/view/partials/precio.tpl" }
                        {* @group SEC - REFERENCIA *}
                        <div class="referencia">
                            {$lng_ref_}:<strong>{$property[0].ref}</strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="property-gal">
                            {* @group SEC - ETIQUETAS *}
                            {include file="file:modules/property/view/partials/etiquetas.tpl" }
                            {* @group SEC - GALERÍA *}
                            {include file="file:modules/property/view/partials/galeria.tpl" }
                        </div>
                    </div>
                    <div class="col-md-3">
                        {* @group SEC - CONTACTAR *}
                        {include file="file:modules/property/view/partials/contactar.tpl" }
                        {* @group SEC - BOTONES *}
                        {include file="file:modules/property/view/partials/botonera.tpl" }
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {* @group SEC - TABS *}
                        {include file="file:modules/property/view/partials/tabs.tpl" }
                        {* @group SEC - TABS PANELS *}
                        {include file="file:modules/property/view/partials/tabs-panels.tpl" }
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{if $similares[0].area != ''}

    <div id="similares-properties">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{$lng_propiedades_similares}</h2>
                    <div class="slides">
                        {section name=ft loop=$similares}
                            {include file="partials/slider-properties.tpl" resource=$similares[ft]}
                        {/section}
                    </div>
                </div>
            </div>
        </div>
    </div>

{/if}

{include file="file:modules/property/view/partials/modal-amigos.tpl" }

{include file="file:modules/property/view/partials/modal-bajada.tpl" }

{include file="footer.tpl"}