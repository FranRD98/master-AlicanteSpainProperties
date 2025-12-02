{include file="header.tpl"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$news[0].titulo}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{$urlStart}{$zonas[0].titulo|slug}.html">{$zonas[0].titulo}</a></li>
                        <li class="breadcrumb-item active">{$news[0].titulo}</li>
                    </ol>
                    <img src="/media/images/news/{$news[0].img}" alt="" class="img-fluid">
                    {$pagetext}

                    {* @group SEC - IMAGENES *}

                    {if count($images) >= 1}
                    <br>
                    <h2 class="main-title">{$lng_galeria_de_imagenes}</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-inline">
                                {* {section name=img loop=$images}
                                <li class="list-inline-item mb-3">
                                    {if $images[img].image_img != ''}
                                        {assign var="imgProp2" value="/media/images/news/{$images[img].image_img}"}
                                        {if isset($images[img].alt) && $images[img].alt != ''}
                                            <a href="https://{$smarty.server.HTTP_HOST}/{if $images[img].image_img != ''}{if {preg_match pattern="https:\/\/" subject=$images[img].image_img}}{imagesize2 src="{$images[img].image_img}" width=1000 height=700 watermark="1" class='' }{else}{assign var="imgProp" value="/media/images/news/{$images[img].image_img}"}{imagesize2 src="{$imgProp}" width=1000 height=700 watermark="1" class='' }{/if}{/if}" class="gallProp">{imagesize src="{$imgProp2}" width=200 height=100 class='' alt="{$images[img].alt}" title="{$images[img].alt}"}</a>
                                        {else}
                                            <a href="https://{$smarty.server.HTTP_HOST}/{if $images[img].image_img != ''}{if {preg_match pattern="https:\/\/" subject=$images[img].image_img}}{imagesize2 src="{$images[img].image_img}" width=1000 height=700 watermark="1" class='' }{else}{assign var="imgProp" value="/media/images/news/{$images[img].image_img}"}{imagesize2 src="{$imgProp}" width=1000 height=700 watermark="1" class='' }{/if}{/if}" class="gallProp">{imagesize src="{$imgProp2}" width=200 height=100 class='' alt="{$news[0].titulo}" title="{$news[0].titulo}"}</a>
                                        {/if}
                                    {else}
                                        {imagesize src='/media/images/website/no-image.png' width=200 height=100 class='' title="{$news[0].titulo}" alt="{$news[0].titulo}" }
                                    {/if}
                                </li>
                                {/section} *}
                                {section name=img loop=$images}
                                <li class="list-inline-item mb-3">
                                    {if isset($images[img].image_img) && $images[img].image_img != ''}
                                        {assign var="imgProp2" value="/media/images/news/{$images[img].image_img}"}
                                        {if isset($images[img].alt) && $images[img].alt != ''}
                                            <a href="http://{$smarty.server.HTTP_HOST}/{if isset($images[img].image_img) && $images[img].image_img != ''}{if $images[img].contains_http}{imagesize2 src="{$images[img].image_img}" width=1000 height=700 watermark="0" class='' }{else}{assign var="imgProp" value="/media/images/news/{$images[img].image_img}"}{imagesize2 src="{$imgProp}" width=1000 height=700 watermark="0" class='' }{/if}{/if}" class="gallProp">{imagesize src="{$imgProp2}" width=200 height=100 class='img-fluid' alt="{$images[img].alt}" title="{$images[img].alt}"}</a>
                                        {else}
                                            <a href="http://{$smarty.server.HTTP_HOST}/{if isset($images[img].image_img) && $images[img].image_img != ''}{if $images[img].contains_http}{imagesize2 src="{$images[img].image_img}" width=1000 height=700 watermark="0" class='' }{else}{assign var="imgProp" value="/media/images/news/{$images[img].image_img}"}{imagesize2 src="{$imgProp}" width=1000 height=700 watermark="0" class='' }{/if}{/if}" class="gallProp">{imagesize src="{$imgProp2}" width=200 height=100 class='img-fluid' alt="{$news[0].titulo}" title="{$news[0].titulo}"}</a>
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

                    {* @group SEC - VIDEOS *}

                    {if $videos[0].video_vid != ''}
                        <br>
                        <h2 class="main-title">{$lng_videos}</h2>
                        <div class="row">
                        {section name=vd loop=$videos}
                            {if $videos[vd].video_vid != ''}
                                <div class="col-md-6">
                                    <div class="embed-responsive embed-responsive-16by9">{$videos[vd].video_vid|replace:'\"':''}</div>
                                </div>
                            {/if}
                        {/section}
                        </div>
                    {/if}

                    {* @group SEC - MAPA *}

                    {if $zonas[0].lat_long_gp_prop != ''}
                        <br>
                        <h2 class="main-title">{$lng_mapa_de_la_ciudad}</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="porta-gmap"><div class="gmap" id="gmap"></div></div>
                            </div>
                        </div>
                    {/if}
                    {if $properties[0].id_prop != ''}
                        <br>
                        <h2 class="main-title">{$lng_propiedades}</h2>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
{if $properties[0].id_prop != ''}
{include file="file:modules/properties/view/layouts/layout-1-col.tpl" proparray=$properties numberprops=3 showshor=0 hidesearch=1}
{/if}
{include file="footer.tpl"}