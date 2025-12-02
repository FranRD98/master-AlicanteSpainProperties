{include file="header.tpl"}

{* <div class="page-content d-none d-md-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {include file="file:modules/properties/view/partials/breadcrumb.tpl"}
            </div>
        </div>
    </div>
</div>
 *}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-content my-3 mt-lg-6">
            {if $smarty.get.idquick == ''} {* Este if es para SEO *}
                
                <h1 class="main-title subtitle text-center mb-3">
                    <span class="num-props">{$totalprops|number_format:0:",":"."}</span>  <em>{$pages[0].titulo}</em>
                </h1>
            {else}
                <h1 class="main-title text-center">
                    {$tituloquick}
                    {* <small>{$lng_se_han_encontrado} <span class="num-props">{$totalprops|number_format:0:",":"."}</span> {$lng_propiedades}</small> *}
                </h1>
            {/if}
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">


        <div class="col-md-12 order-last">
            <div class="sidebar-content-full">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3 vistas-prop">
                        <div class="{if $actMapaPropiedades == 0}d-none d-lg-block{/if}">
                            {* @group SEC - VISTAS *}
                            {include file="file:modules/properties/view/partials/views.tpl"}
                        </div>
                    </div>
                    <div class="col mb-3"></div>
                </div>
                <div id="mapa_propiedades"></div>
            </div>
        </div>
        <div class="col-md-12 order-md-1 d-none d-md-block">
            <div class="buscador b-properties">
                    {include file="partials/buscador.tpl" dupl=1}
                </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}