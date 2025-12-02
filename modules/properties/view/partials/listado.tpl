{if isset($titleNewsSearch) && $titleNewsSearch != ''}
<div class="row">
    <div class="col-12 mb-lg-2">
        <h2 class="main-title mt-3 mb-4">
            {$titleNewsSearch}
        </h2>
    </div>
</div>
{/if}

{* @group SEC - NAVEGACIÓN TOP *}
{if $showshor == 1}
    <div class="row g-3 pb-4 mb-lg-2 pt-4 pt-lg-0">

        <div class="col-12 col-md-4 col-xl-6 vistas-prop {if $actMapaPropiedades == 0} d-xl-block d-none {/if} ">
            <div class="{if $actMapaPropiedades == 0}d-none d-lg-block{/if}">
                {* @group SEC - VISTAS *}
                {include file="file:modules/properties/view/partials/views.tpl"}
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-8 col-xl-6">

            <div class="row no-gutters align-items-center">
                <div class="col-6 col-xl-5">
                    {* @group SEC - NÚMERO *}
                    <div class="porta-num">
                          <select name="nu" id="nu" class="form-control">
                              {include file="file:modules/properties/view/partials/porta-num.tpl"}
                          </select>
                    </div>
                </div>
                <div class="col-xl-2 text-center d-none d-xl-block">
                    <strong class="porta-label  d-inline-block"> {$lng_order_by}: </strong>
                </div>
                <div class="col-6 col-xl-5">
                    {* @group SEC - ORDEN *}
                    <div class="porta-order">
                          <select name="o" id="o" class="form-control">
                              {include file="file:modules/properties/view/partials/porta-order.tpl"}
                          </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
{/if}

{* @group SEC - PROPIEDADES *}
<div class="row">
    <div class="col-md-12">
        {if isset($proparray[0]) && $proparray[0].id_prop != ''}
            <div class="row">
            {section name=ft loop=$proparray}
                {assign var="numeroInmueblesFila" value="{$numberprops}"}
                {assign var="numCol" value="{12/$numeroInmueblesFila}"}
                {include file="file:modules/properties/view/partials/property-list.tpl" resource=$proparray[ft]}
                {* {if ($smarty.section.ft.index + 1) % $numeroInmueblesFila == 0 }</div><div class="row">{/if} *}
            {/section}
            </div>
        {else}
            <br>
            <br>
            <br>
            <p class="lead text-center">{$lng_no_se_hean_encontrado_inmuebles_que_coincidan_con_su_busqueda}.</p>
            <br>
            <br>
            <br>
        {/if}
    </div>
</div>

{* @group SEC - NAVEGACIÓN BOTTOM *}
<div class="row">
    <div class="col mb-5">
        {* @group SEC - PAGINACIÓN *}
        <div class="pagination text-center d-flex justify-content-center">
        {include file="file:modules/properties/view/partials/pagination.tpl"}
        </div>
    </div>
</div>
