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
{* @group SEC - TITULO *}

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-content my-3 mt-lg-6">
            {if isset($smarty.get.idquick) && $smarty.get.idquick == ''} {* Este if es para SEO *}
                
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

{include file="file:modules/properties/view/layouts/layout-1-col.tpl" proparray=$properties numberprops=6 showshor=1}
{* {include file="file:modules/properties/view/layouts/layout-1-col.tpl" proparray=$properties numberprops=3 showshor=1} *}
{* {include file="file:modules/properties/view/layouts/layout-2-col-left.tpl" proparray=$properties numberprops=2 showshor=1} *}
{* {include file="file:modules/properties/view/layouts/layout-2-col-right.tpl" proparray=$properties numberprops=2 showshor=1} *}

{if isset($pagetext) && $pagetext != ''}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    {$pagetext}
                </div>
            </div>
        </div>
    </div>
{/if}

<div class="search-btn-props d-block d-lg-none">
    <a class="responsive-search-button" href="javascript:;"><img src="/media/images/website/lupa.svg"></a>
</div>

{include file="footer.tpl"}
