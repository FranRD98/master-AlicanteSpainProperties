{include file="header.tpl"}

{assign var="titulo" value={$pages[0].titulo}}
{assign var="subtitle" value=''}

{assign var="image_mov" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1280 height=600 class='' } }
{assign var="image" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1920 height=540 class='' } }

{include file="partials/banner-title.tpl" image={$image} image_mov={$image_mov} titulo={$titulo} subtitle={$subtitle} }
{* Dejo un css básico en _custom-mixins  y ya lo adapta cada uno como le venga mejor *}


<div class="page-content">
    <div class="container">
        <div class="row gx-5 mt-5 mx-md-2 mx-lg-4">
                <div class="col-md-12">
                    <h2 class="main-title mt-2">{$pages[0].titulo}</h2>
                </div>
            <div class="row mb-5">
                <div class="col">
                    <form action="{$urlStart}{$url_promociones}/" method="get" id="searchProms" role="form" class="validate">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <select name="coast" id="coast" class="form-control">
                                        <option value="">{$lng_costa}</option>
                                        {section name=lz loop=$coast}
                                            {if isset($coast[lz].coast) && $coast[lz].coast != ''}
                                                <option value="{$coast[lz].id}" {if isset($smarty.get.coast) && in_array($coast[lz].id, $smarty.get.coast)}selected{/if}>{$coast[lz].coast}</option>
                                            {/if}
                                        {/section}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <select name="loct" id="loct" class="form-control">
                                        <option value="">{$lng_ciudad}</option>
                                        {section name=lz loop=$cityPromo}
                                        <option value="{$cityPromo[lz].id}" {if isset($smarty.get.loct) &&  in_array($cityPromo[lz].id, $smarty.get.loct)}selected{/if}>{$cityPromo[lz].area}</option>
                                        {/section}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <select name="tp" id="tp" class="form-control">
                                        <option value="" {if $smarty.get.tp == ''}selected{/if}>{$lng_tipo}</option>
                                        {section name=tp loop=$typePromo}
                                            {if {$typePromo[tp].type} != 'Array'}
                                                <option value="{$typePromo[tp].id_type}" {if $smarty.get.tp == $typePromo[tp].id_type}selected{/if}>{$typePromo[tp].type}</option>
                                            {/if}
                                        {/section}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <select name="prdsp" id="prdsp" class="form-control prdsp">
                                        <option value="" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == ''}selected{/if}>{$lng_precio_desde}</option>
                                        <option value="50000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 50000}selected{/if}>50.000 €</option>
                                        <option value="100000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == '100000'}selected{/if}>100.000€</option>
                                        <option value="150000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 150000}selected{/if}>150.000 €</option>
                                        <option value="200000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 200000}selected{/if}>200.000 €</option>
                                        <option value="250000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 250000}selected{/if}>250.000 €</option>
                                        <option value="300000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 300000}selected{/if}>300.000 €</option>
                                        <option value="350000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 350000}selected{/if}>350.000 €</option>
                                        <option value="400000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 400000}selected{/if}>400.000 €</option>
                                        <option value="450000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 450000}selected{/if}>450.000 €</option>
                                        <option value="500000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 500000}selected{/if}>500.000 €</option>
                                        <option value="550000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 550000}selected{/if}>550.000 €</option>
                                        <option value="600000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 600000}selected{/if}>600.000 €</option>
                                        <option value="650000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 650000}selected{/if}>650.000 €</option>
                                        <option value="700000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 700000}selected{/if}>700.000 €</option>
                                        <option value="800000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 800000}selected{/if}>800.000 €</option>
                                        <option value="900000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 900000}selected{/if}>900.000 €</option>
                                        <option value="1000000" {if isset($smarty.get.prdsp) && $smarty.get.prdsp == 1000000}selected{/if}>1.000.000 €</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <select name="prhsp" id="prhsp" class="form-control prhsp">
                                        <option value="" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == ""}selected{/if}>{$lng_precio_hasta}</option>
                                        <option value="50000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 50000}selected{/if}>50.000 €</option>
                                        <option value="100000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == '100000'}selected{/if}>100.000€</option>
                                        <option value="150000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 150000}selected{/if}>150.000 €</option>
                                        <option value="200000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 200000}selected{/if}>200.000 €</option>
                                        <option value="250000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 250000}selected{/if}>250.000 €</option>
                                        <option value="300000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 300000}selected{/if}>300.000 €</option>
                                        <option value="350000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 350000}selected{/if}>350.000 €</option>
                                        <option value="400000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 400000}selected{/if}>400.000 €</option>
                                        <option value="450000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 450000}selected{/if}>450.000 €</option>
                                        <option value="500000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 500000}selected{/if}>500.000 €</option>
                                        <option value="550000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 550000}selected{/if}>550.000 €</option>
                                        <option value="600000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 600000}selected{/if}>600.000 €</option>
                                        <option value="650000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 650000}selected{/if}>650.000 €</option>
                                        <option value="700000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 700000}selected{/if}>700.000 €</option>
                                        <option value="800000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 800000}selected{/if}>800.000 €</option>
                                        <option value="900000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 900000}selected{/if}>900.000 €</option>
                                        <option value="1000000" {if isset($smarty.get.prhsp) && $smarty.get.prhsp == 1000000}selected{/if}>+1.000.000 €</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <select name="bd" id="bd" class="form-control">
                                        <option value="" {if isset($smarty.get.bd) && $smarty.get.bd == ''}selected{/if}>{$lng_habitaciones}</option>
                                        {for $i=1 to 25}
                                        <option value="{$i}" {if isset($smarty.get.bd) && $smarty.get.bd == $i}selected{/if}>{if $i == 25}+{/if}{$i}</option>
                                        {/for}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3 d-grid">
                                    <button type="submit" class="btn btn-primary">{$lng_buscar}</button>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3 d-grid">
                                  <a href="{$urlStart}{$url_promociones}/" class="btn btn-light">
                                      Reset
                                  </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {if $news[0].titulo != ''}
                {section name=nw loop=$news}
                    <div class="col-md-6 mb-3 mb-md-4">
                        {include file="file:modules/promociones/view/partials/noticia.tpl" resource=$news[nw]}
                    </div>
                {/section}
                {* @group SEC - PAGINACIÓN *}
                <div class="pagination text-center d-flex justify-content-center flex-wrap mb-5">
                    {include file="file:modules/properties/view/partials/pagination.tpl"}
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
        <div class="row justify-content-center">
            <div class="col-10 col-md-4 col-xl-4 d-grid">
                <a href="{$urlStart}{$url_properties}-{slug(getFromArray($status, 2, 'id', 'sale'))}/"
                    class="btn btn-primary">{$lng_ver_toda_la_obra_nueva}</a>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}