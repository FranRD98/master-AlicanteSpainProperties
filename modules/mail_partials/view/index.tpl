{include file="header.tpl"}



{assign var="titulo" value={$pages[0].titulo}}
{assign var="subtitle" value=''}

{assign var="image_mov" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=820 height=320 class='' } }
{assign var="image" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1920 height=540 class='' } }

{* {include file="partials/banner-title.tpl" image={$image} image_mov={$image_mov} titulo={$titulo} subtitle={$subtitle} }  *}
{* Dejo un css básico en _custom-mixins  y ya lo adapta cada uno como le venga mejor *}

{if $pagetext != ''}
    <div class="page-content page-rate mb-3">
        <div class="bg-light py-3 mb-3">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        {$pages[0].contenido}
                    </div>
                </div>
            </div>
        </div>
        <div class="container position-relative pt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    {$pages[1].contenido}
                </div>
            </div>
        </div>
    </div>
{/if}

<div class="container">
    {if $properties[0].id_prop != ''}
        <div class="row">
            {section name=ft loop=$properties}
                {assign var="numeroInmueblesFila" value="3"}
                {assign var="numCol" value="12"}
                {include file="file:modules/properties/view/partials/property-list-rate.tpl" resource=$properties[ft]}
                {* {if ($smarty.section.ft.index + 1) % $numeroInmueblesFila == 0 }</div><div class="row">{/if} *}
            {/section}
        </div>
    {/if}
</div>

{* <div class="container">
    <div class="row">
        <div class="col-md-12 order-md-2">
            <div class="sidebar-content-full">
                {include file="file:modules/properties/view/partials/listado.tpl" proparray=$properties}
            </div>
        </div>
    </div>
</div> *}


{include file="footer.tpl"}
