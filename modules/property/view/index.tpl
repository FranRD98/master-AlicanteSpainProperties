{include file="header.tpl"}

{assign var="title" value="{$property[0].sale} - {$property[0].type} - {$property[0].area}{if $property[0].area != $property[0].town} - {$property[0].town}{/if}"}

<div class="container">
    <div class="row">
        <div class="col">
            {* @group SEC - ALERTAS *}
            {include file="file:modules/property/view/partials/alertas.tpl" }
        </div>
    </div>
</div>

{* {include file="file:modules/property/view/layouts/layout-sidebar.tpl" property=$property} *}
{include file="file:modules/property/view/layouts/layout-full.tpl" property=$property}

{if isset($similares[0].area) && $similares[0].area != ''}

    <div id="similares-properties" class="bg-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-title">{$lng_propiedades_similares}</h2>
                </div>
                <div class="col-md-12 px-lg-0">
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

{include file="footer.tpl"}
