{include file="header.tpl"}


{if isset($news[0].titulo)}
    {assign var="titulo" value={$news[0].titulo}}
{else}  
    {assign var="titulo" value={$pages[0].titulo}}
{/if}

{assign var="subtitle" value=''}

{assign var="image_mov" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1280 height=600 class='' } }
{assign var="image" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1920 height=540 class='' } }

{include file="partials/banner-title.tpl" image={$image} image_mov={$image_mov} titulo={$titulo} subtitle={$subtitle} }
{* Dejo un css básico en _custom-mixins  y ya lo adapta cada uno como le venga mejor *}


<div class="page-content pt-5">
    <div class="container">
        
        <div class="row">
            <div class="col-12">
                 {* @group SEC - TÍTULO *}
                <h1 class="main-title text-center">{if isset($news[0].titulo) && $news[0].titulo!=''}{$news[0].titulo}{/if}</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                 <div class="page-content">
                    {* @group SEC - IMAGEN *}
                    {if isset($news[0].alt) && $news[0].alt != ''}
                        {assign var="altt" value="{$news[0].alt}"}
                    {else}
                        {if isset($news[0].titulo)}
                            {assign var="altt" value="{$news[0].titulo}"}
                        {else}
                            {assign var="altt" value=""}
                        {/if}        
                    {/if}
                    {if isset($images[0].image_img) && $images[0].image_img != ''}
                        {assign var="imgProp" value="/media/images/news/{$news[0].img}"}
                        {imagesize src="{$imgProp}" width=400 height=400 class='img-fluid d-block mx-auto mb-32 br-100' alt="{$altt}" title="{$altt}" }
                    {else}
                        {imagesize src='/media/images/website/no-image.png' width=400 height=400 class='img-fluid d-block mx-auto mb-32 br-100' alt="{$altt}" title="{$altt}" }
                    {/if}
                    {* @group SEC - FECHA *}
                    {* <div class="date mb-2">{$news[0].date_nws|date_format:"%e %b %Y"}</div> *}
                    {* @group SEC - TEXTO *}
                    <div class="text">
                    {if isset($news[0].contenido) && $news[0].contenido != ''}
                        {$news[0].contenido}
                    {/if}
                    </div>
                    {* @group SEC - GALERÍA *}
                    {if {$images|count} > 1}
                        <h2 class="subtitle-test">{$lng_galeria_de_imagenes}</h2>
                        <ul class="list-inline mb-24">
                            {section name=img loop=$images}
                                <li class="list-inline-item mb-3">
                                    {if isset($images[img].image_img) && $images[img].image_img != ''}
                                        {if $images[img].contains_http}
                                            {assign var="linkImgSrc" value="{imagesize2 src="{$images[img].image_img}" width=1200 height=800 class=''}"}
                                            {assign var="linkImg" value="{$images[img].image_img}"}
                                        {else}
                                            {assign var="linkImgSrc" value="{imagesize2 src="/media/images/news/{$images[img].image_img}" width=1200 height=800 }"}
                                            {assign var="linkImg" value="/media/images/news/{$images[img].image_img}" }
                                        {/if}
                                        <a href="http://{$smarty.server.HTTP_HOST}/{$linkImgSrc}" class="gallNews">
                                            {imagesize src="{$linkImg}" width=75 height=75 class='' alt="{$images[img].alt}" title="{$images[img].alt}"}
                                        </a>
                                    {else}
                                        {imagesize src='/media/images/website/no-image.png' width=67 height=67 class='' title="{$news[0].titulo}" alt="{$news[0].titulo}" }
                                    {/if}
                                </li>
                            {/section}
                        </ul>
                    {/if}
                    {* @group SEC - DESCARGAS *}
                    {if isset($files[0].file_fil) && $files[0].file_fil != ''}
                        <h2 class="subtitle-test">{$lng_descargas}</h2>
                        <div class="w-downloads mb-40">
                            <div class="row">
                        {section name=vid loop=$files}
                            {if $files[vid].file_fil != ''}
                                <div class="col-sm-6">
                                {if $files[vid].name != ''}
                                    <a href="/media/files/news/{$files[vid].file_fil}" target="_blank" class="btn btn-primary ntn-sm mb-2 mb-lg-0 rounded-0 btn-block">{$files[vid].name}</a>
                                {else}
                                    <a href="/media/files/news/{$files[vid].file_fil}" target="_blank" class="btn btn-primary ntn-sm mb-2 mb-lg-0 rounded-0 btn-block">{$lng_descargar}</a>
                                {/if}
                                </div>
                            {/if}
                        {/section}
                            </div>
                        </div>
                    {/if}
                    {* @group SEC - VIDEOS *}
                    {if isset($videos[0].video_vid) && $videos[0].video_vid != ''}
                        <h2 class="subtitle-test">{$lng_videos}</h2>
                        <div class="w-videos">
                            {section name=vd loop=$videos}
                                {if $videos[vd].video_vid != ''}
                                    <div class="embed-responsive embed-responsive-16by9{if !$smarty.section.vd.last} mb-3{/if}">
                                        {$videos[vd].video_vid|replace:'\"':''}
                                    </div>
                                {/if}
                            {/section}
                        </div>
                    {/if}
                    </div>
            </div>
            <div class="col-lg-10">
                {if isset($tokens[3]) && $tokens[3] == '' && $tokens[2] != $url_category && isset($tokens[2]) && $tokens[2] != ''}
                     <a href="{$http_referer}" class="btn btn-danger btn-block">{$lng_volver}</a> 
                {/if}

            </div>
        </div>
    </div>
</div>

{* @group SEC - PROPIEDADES *}
{if $showSimils == 1}
    {if isset($similares[0].id_prop) && $similares[0].id_prop != ''}
    <div class="container">
        <row>
            <div class="col-md-12">
                <br>
                <h2 class="main-title">{if isset($lng_propiedades)}{$lng_propiedades}{/if}</h2>
            </div>
        </row>
    </div>
    <div class="container">

        {include file="file:modules/properties/view/partials/listado.tpl" proparray=$similares numberprops=3 showshor=0}
    </div>
    {/if}
{/if}

{include file="footer.tpl"}