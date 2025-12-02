{include file="header.tpl"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$zonas[0].titulo}</h1>
                    <img src="/media/images/zonas/{$zonas[0].img}" alt="" class="img-fluid">
                    {$pagetext}

                    {* @group SEC - CIUDADES *}
                    {if $news[0].titulo != ''}
                        <h2 class="main-title">{$lng_ciudades}</h2>
                        <div class="row">
                            {section name=ft loop=$news}
                            <div class="col-md-4">
                                <a href="{$urlStart}{$zonas[0].titulo|slug}/{$news[ft].titulo|slug}.html" class="card">
                                    {if $news[ft].img != ''}
                                        {assign var="imgProp" value="/media/images/news/{$news[ft].img}"}
                                        {imagesize src="{$imgProp}" width=500 height=300 class='card-img-top' alt="{$news[ft].titulo}" title="{$news[ft].titulo}" }
                                    {else}
                                        {imagesize src='/media/images/website/no-image.png' width=500 height=300 class='card-img-top' alt="{$news[ft].titulo}" title="{$news[ft].titulo}" }
                                    {/if}
                                    <div class="card-title">
                                        <h5>{$news[ft].titulo}</h5>
                                    </div>
                                </a>
                            </div>
                            {/section}
                        </div>
                    {/if}

                    {* @group SEC - IMAGENES *}

                    {if count($images) >= 1}
                    <br>
                    <h2 class="main-title">{$lng_galeria_de_imagenes}</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-inline">
                                {section name=img loop=$images}
                                <li class="list-inline-item mb-3">
                                    {if isset($images[img].image_img) && $images[img].image_img != ''}
                                        {assign var="imgProp2" value="/media/images/zonas/{$images[img].image_img}"}
                                        {if isset($images[img].alt) && $images[img].alt != ''}
                                            <a href="http://{$smarty.server.HTTP_HOST}/{if isset($images[img].image_img) && $images[img].image_img != ''}{if $images[img].contains_http}{imagesize2 src="{$images[img].image_img}" width=1000 height=700 watermark="0" class='' }{else}{assign var="imgProp" value="/media/images/zonas/{$images[img].image_img}"}{imagesize2 src="{$imgProp}" width=1000 height=700 watermark="0" class='' }{/if}{/if}" class="gallProp">{imagesize src="{$imgProp2}" width=200 height=100 class='img-fluid' alt="{$images[img].alt}" title="{$images[img].alt}"}</a>
                                        {else}
                                            <a href="http://{$smarty.server.HTTP_HOST}/{if isset($images[img].image_img) && $images[img].image_img != ''}{if $images[img].contains_http}{imagesize2 src="{$images[img].image_img}" width=1000 height=700 watermark="0" class='' }{else}{assign var="imgProp" value="/media/images/zonas/{$images[img].image_img}"}{imagesize2 src="{$imgProp}" width=1000 height=700 watermark="0" class='' }{/if}{/if}" class="gallProp">{imagesize src="{$imgProp2}" width=200 height=100 class='img-fluid' alt="{$news[0].titulo}" title="{$news[0].titulo}"}</a>
                                        {/if}
                                    {else}
                                        {imagesize src='/media/images/website/no-image.png' width=200 height=100 class='img-fluid' title="{$news[0].titulo}" alt="{$news[0].titulo}" }
                                    {/if}
                                </li>
                                {/section}
                             </ul>
                        </div>
                    </div>
                    {/if}

                    {* @group SEC - MAPA *}

                    {if $zonas[0].lat_long_gp_prop != ''}
                        <br>
                        <h2 class="main-title">{$lng_mapa_de_la_zona}</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="porta-gmap">
                                    <div class="gmap" id="gmap"></div>
                                </div>
                            </div>
                        </div>
                    {/if}
                    {if $propertiesx[0].id_prop != ''}
                    <br>
                    <h2 class="main-title">{$lng_propiedades}</h2>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
{if $propertiesx[0].id_prop != ''}
{include file="file:modules/properties/view/layouts/layout-1-col.tpl" proparray=$propertiesx numberprops=3 showshor=0 hidesearch=1}
{/if}
{include file="footer.tpl"}