{include file="header.tpl"}

<div class="page-content page-news">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-7">
                <div class="page-content">
                {* @group SEC - TÍTULO *}
                <h1 class="main-title">{$news[0].titulo}</h1>
                {* @group SEC - IMAGEN *}
                {if isset($news[0].alt) && $news[0].alt != ''}
                    {assign var="altt" value="{$news[0].alt}"}
                {else}
                    {assign var="altt" value="{$news[0].titulo}"}
                {/if}
                {if isset($images[0].image_img) && $images[0].image_img != ''}
                    {assign var="imgProp" value="/media/images/news/{$news[0].img}"}
                    {imagesize src="{$imgProp}" width=800 height=400 class='img-fluid mb-3' alt="{$altt}" title="{$altt}" }
                {else}
                    {imagesize src='/media/images/website/no-image.png' width=800 height=400 class='img-fluid mb-3' alt="{$altt}" title="{$altt}" }
                {/if}
                {* @group SEC - FECHA *}
                <div class="date mb-2">{$news[0].date_nws|date_format:"%e %b %Y"}</div>
                {* @group SEC - TEXTO *}
                {$news[0].contenido}
                {* @group SEC - TAGS *}
                {assign var="tags" value=explode(',', $news[0].tags)}
                <p>
                    {section name=tg loop=$tags}
                        <a href="{$urlStart}{$url_news}/{$tags[tg]}/"><span class="badge badge-secondary text-white font-weight-normal px-2">{$tags[tg]}</span></a>
                    {/section}
                </p>
                {* @group SEC - GALERÍA *}
                {if {$images|count} > 1}
                    <h2 class="main-title mt-4">{$lng_galeria_de_imagenes}</h2>
                    <div class="row">
                        {section name=img loop=$images}
                            {if $images[img].image_img != ''}

                                {if $images.img.image_img|preg_match:"/http:\/\//"}
                                    {assign var="linkImgSrc" value="{imagesize2 src="{$images[img].image_img}" width=1200 height=800 class=''}"}
                                    {assign var="linkImg" value="{$images[img].image_img}"}
                                {else}
                                    {assign var="linkImgSrc" value="{imagesize2 src="/media/images/news/{$images[img].image_img}" width=1200 height=800 }"}
                                    {assign var="linkImg" value="/media/images/news/{$images[img].image_img}" }
                                {/if}

                               <div class="col-md-4 col-lg-3 col-6">
                                    <a href="http://{$smarty.server.HTTP_HOST}/{$linkImgSrc}" class="mb-3 mb-md-4 gallNews d-inline-block">
                                    {imagesize src="{$linkImg}" width=220 height=180 class='img-fluid' alt="{if isset($images[img].alt)}{$images[img].alt}{else}img{/if}" title="{if isset($images[img].alt)}{$images[img].alt}{else}img{/if}"}
                                    </a>
                               </div>
                            

                            {/if}
                        {/section}
                    </div>
                {/if}
                {* @group SEC - DESCARGAS *}
                {if isset($files[0].file_fil) && $files[0].file_fil != ''}
                    <h2 class="main-title mt-4">{$lng_descargas}</h2>
                    {section name=vid loop=$files}
                        {if $files[vid].file_fil != ''}
                            {if $files[vid].name != ''}
                                <a href="/media/files/news/{$files[vid].file_fil}" target="_blank" class="btn btn-primary ntn-sm">{$files[vid].name}</a>
                            {else}
                                <a href="/media/files/news/{$files[vid].file_fil}" target="_blank" class="btn btn-primary ntn-sm">{$lng_descargar}</a>
                            {/if}
                        {/if}
                    {/section}
                {/if}
                {* @group SEC - VIDEOS *}
                {if isset($videos[0].video_vid) && $videos[0].video_vid != ''}
                    <h2 class="main-title mt-4">{$lng_videos}</h2>
                    {section name=vd loop=$videos}
                        {if $videos[vd].video_vid != ''}
                            <div class="embed-responsive embed-responsive-16by9">
                                {$videos[vd].video_vid|replace:'\"':''}
                            </div>
                        {/if}
                    {/section}
                {/if}


                <h2 class="main-title subtitle my-5"> Share </h2>
                <div class="redes mb-4 mb-lg-5">
                    <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="twitter" href="https://www.twitter.com/share?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&title=&summary=&source=" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a  class="btn-whatsapp-property" href="https://api.whatsapp.com/send?text=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a  class="telegram" href="https://telegram.me/share/url?url={$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                </div>


                </div>
            </div>
            <div class="col-lg-4 offset-xl-1 sidebar-news">
                {* @group SEC - SIDEBAR *}
                {include file="file:modules/news/view/partials/sidebar.tpl"}
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
            <h2 class="main-title">{$lng_propiedades}</h2>
        </div>
    </row>
</div>
<div class="container">

    {include file="file:modules/properties/view/partials/listado.tpl" proparray=$similares numberprops=3 showshor=0}
</div>
{/if}
{/if}

{include file="footer.tpl"}
