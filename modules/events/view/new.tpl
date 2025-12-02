{include file="header.tpl"}

{assign var="titulo" value={$news[0].titulo}}
{assign var="subtitle" value=''}


{* Foto de cabecera responsive (ajustar tamaños al diseño *}
{if $mobile[0].image_img != ''}
    {assign var="image_mov" value={imagesize2 src="/media/images/news/{$mobile[0].image_img}" width=640 height=720 class='' } }
{else if $banner[0].image_img != ''}
    {assign var="image_mov" value={imagesize2 src="/media/images/news/{$banner[0].image_img}" width=640 height=540 class='' } }
{else}
    {assign var="image_mov" value={imagesize2 src="/media/images/news/{$images[0].image_img}" width=640 height=540 class='' } }
{/if}

{* Foto de cabecera escritorio *}
{if $banner[0].image_img != ''}
    {assign var="image" value={imagesize2 src="/media/images/news/{$banner[0].image_img}" width=1920 height=580 class='' } }
{else}
    {assign var="image" value={imagesize2 src="/media/images/news/{$images[0].image_img}" width=1920 height=580 class='' } }
{/if} 

<div class="header-sec" style="min-height: 200px;">

    <img src="{$image}"  class="img-fluid d-none d-md-block" alt="{$titulo}">
    <img src="{$image_mov}"  class="img-fluid d-md-none" alt="{$titulo}">

    <div class="contenido-banner mt-5 mt-md-0" >
        <div class="container">
            <div class="row">
                <div class="offset-lg-7 col-12 col-lg-5">
 
                        <div class="p-4 bg-light rounded mt-5 ">

                            <h4 class="mb-3">{$news[0].titulo}</h4>

                            <div class="labels text-uppercase mb-3">
                                {if $news[0].tipo != 0 || $news[0].tipo != ''}
                                    <div class="badge bg-info">
                                        {if $news[0].tipo == 1}
                                            Online
                                        {else if $news[0].tipo == 2}
                                            {$lng_presencial}
                                        {/if}
                                    </div>
                                {/if}
                                {if $news[0].finalizado == 1}
                                    <div class="badge bg-danger">
                                        {$lng_finalizado}
                                    </div>
                                {/if}
                            </div>

                            <div class="row mb-4">
                                <div class="col-6">
                                    {* @group SEC - FECHA *}
                                    <div class="date">
                                        <strong class="text-uppercase d-block text-primary">
                                            {$lng_fecha}:
                                        </strong>
                                        {$news[0].date_nws|date_format:"%e %b %Y - %H:%M "}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="date location ">
                                        <strong class="text-uppercase d-block text-primary">
                                            {$lng_localizacion}:
                                        </strong>
                                        <span class="d-inline-block me-3">
                                            {$news[0].ubicacion}
                                        </span>

                                        {if $news[0].url != ''}
                                            <a href="{$news[0].url}" target="_blank" class="d-inline-block p-1 px-3 rounded bg-primary text-white">
                                                <i class="far fa-arrow-alt-to-right"></i>
                                            </a>
                                        {/if}
                                        
                                    </div>
                                </div>
                            </div>
                               
                              {* RESUMEN *}  
                              <strong class="text-uppercase d-none d-lg-block text-primary">
                                 {$lng_descripcion_corta}
                              </strong>
                              <p class="d-none d-lg-block">
                                {$news[0].resumen|strip_tags|truncate:250:"..."}
                              </p>

                              <span class="btn btn-primary d-block toEventForm">{$lng_reservar_una_cita}<span>

                    </div>
      
                </div>
            </div>
        </div>
    </div>

</div>


<div class="page-content page-news pt-5">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 pb-4">
                <div class="page-content">
                {* @group SEC - TÍTULO *}
                
                <div class="row align-items-end">
                    <div class="col-lg-7">
                        <h2 class="main-title">{$news[0].titulo}</h2>
                    </div>
                    <div class="col-lg-5 ps-xl-5 d-none d-lg-block">

                            {if $tokens[3] == '' && $tokens[2] != $url_category && $tokens[2] != ''}
                                <div class="d-grid mb-4">
                                    <a href="{$http_referer}" class="btn btn-light">{$lng_volver}</a>
                                </div>
                            {/if}

                    </div>
                </div>
                {* @group SEC - IMAGEN *}
               
                {* @group SEC - TEXTO *}
                {$news[0].contenido}

                {* @group SEC - TAGS *}
                {if isset($news[0].tags)}
                {assign var="tags" value=explode(',', $news[0].tags)}
                <p>
                    {section name=tg loop=$tags}
                        <a href="{$urlStart}{$url_news}/{$tags[tg]}/"><span class="badge badge-secondary text-white font-weight-normal px-2">{$tags[tg]}</span></a>
                    {/section}
                </p>
                {/if}
                {* @group SEC - GALERÍA *}
                {if {$images|count} > 1}
                    <h2 class="main-title mt-4">{$lng_galeria_de_imagenes}</h2>
                    <div class="row">
                        {section name=img loop=$images}

                            {if isset($images[img].image_img) && $images[img].image_img != ''}

                                {if $images[img].contains_http}
                                    {assign var="linkImgSrc" value="{imagesize2 src="{$images[img].image_img}" width=1440 height=900 class=''}"}
                                    {assign var="linkImg" value="{$images[img].image_img}"}
                                {else}
                                    {assign var="linkImgSrc" value="{imagesize2 src="/media/images/news/{$images[img].image_img}" width=1440 height=900 }"}
                                    {assign var="linkImg" value="/media/images/news/{$images[img].image_img}" }
                                {/if}

                               <div class="col-md-4 col-lg-3 col-6">
                                    <a href="http://{$smarty.server.HTTP_HOST}/{$linkImgSrc}" class="mb-3 mb-md-4 gallNews d-inline-block">
                                    {imagesize src="{$linkImg}" width=340 height=280 class='img-fluid' alt="{if isset($images[img].alt)}{$images[img].alt}{else}img{/if}" title="{if isset($images[img].alt)}{$images[img].alt}{else}img{/if}"}
                                    </a>
                               </div>
                            

                            {/if}
                        {/section}
                    </div>
                {/if}
                {* @group SEC - DESCARGAS *}
                {if isset($files[0]) && $files[0].file_fil != ''}
                    <h2 class="main-title mt-4">{$lng_descargas}</h2>
                    <div class="row">
                        {section name=vid loop=$files}
                            {if $files[vid].file_fil != ''}
                                <div class="col-lg-4 col-md-6">
                                    {if $files[vid].name != ''}
                                        <a href="/media/files/news/{$files[vid].file_fil}" target="_blank" class="btn btn-primary ntn-sm">{$files[vid].name}</a>
                                    {else}
                                        <a href="/media/files/news/{$files[vid].file_fil}" target="_blank" class="btn btn-primary ntn-sm">{$lng_descargar}</a>
                                    {/if}
                                </div>
                            {/if}
                        {/section}
                    </div>
                {/if}
                {* @group SEC - VIDEOS *}
                {if isset($videos[0]) && $videos[0].video_vid != ''}
                    <h2 class="main-title mt-4">{$lng_videos}</h2>
                    
                    <div class="row">
                        {section name=vd loop=$videos}
                            {if $videos[vd].video_vid != ''}
                                <div class="col-md-6">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        {$videos[vd].video_vid|replace:'\"':''}
                                    </div>
                                </div>
                            {/if}
                        {/section}
                    </div>

                {/if}

                {if $tokens[3] == '' && $tokens[2] != $url_category && $tokens[2] != ''}
                    <div class="my-4">
                        <a href="{$http_referer}" class="btn btn-light px-5">{$lng_volver}</a>
                    </div>
                {/if}


                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="p-4 bg-light rounded mt-5">

                            <h4 class="mb-3">{$news[0].titulo}</h4>

                            <div class="labels text-uppercase mb-3">
                                {if isset($news[0].tipo) && $news[0].tipo != 0 || $news[0].tipo != ''}
                                    <div class="badge bg-info">
                                        {if $news[0].tipo == 1}
                                            Online
                                        {else if $news[0].tipo == 2}
                                            {$lng_presencial}
                                        {/if}
                                    </div>
                                {/if}
                                {if isset($news[0].finalizado) && $news[0].finalizado == 1}
                                    <div class="badge bg-danger">
                                        {$lng_finalizado}
                                    </div>
                                {/if}
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                        {* @group SEC - FECHA *}
                                        <div class="date">
                                            <strong class="text-uppercase d-block text-primary">
                                                {$lng_fecha}:
                                            </strong>
                                            {$news[0].date_nws|date_format:"%e %b %Y - %H:%M "}
                                        </div>
                                </div>
                                <div class="col-6">
                                    <div class="date location ">
                                        <strong class="text-uppercase d-block text-primary">
                                            {$lng_localizacion}:
                                        </strong>
                                        {$news[0].ubicacion}

                                        {if $news[0].url != ''}
                                            <a href="{$news[0].url}" target="_blank" class=" ms-4 d-inline-block p-1 px-3 rounded bg-primary text-white">
                                                <i class="far fa-arrow-alt-to-right"></i>
                                            </a>
                                        {/if}
                                        
                                    </div>
                                </div>
                            </div>
                               
                              {* RESUMEN *}  
                              <strong class="text-uppercase d-block text-primary">
                                 {$lng_descripcion_corta}
                              </strong>
                              <p>
                                {$news[0].resumen|strip_tags|truncate:250:"..."}
                              </p>

                    </div>
                    </div>
                    <div class="col-lg-7 ps-xl-5">
                            <div id="eventForm" class="contact-form custom-form">

                                {* @group SEC - FORMULARIO *}
                                <h2 class="main-title">{$lng_reservar_una_cita}</h2>
                                <form action="#" id="contactFormEvent" method="post" class="validate">
                                    
                                    <div class="mb-3">
                                        <input type="text" class="form-control required" name="name" id="name"
                                            placeholder="{$lng_nombre} *">
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input type="text" class="form-control required email" name="email" id="email"
                                                    placeholder="{$lng_email} *">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input type="text" class="form-control telefono" name="telefono" id="telefono"
                                                    placeholder="{$lng_telefono}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input type="text" class="form-control " name="when" id="when"
                                                    placeholder="{$lng_when_do_you_plan_to_buy}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input type="text" class="form-control " name="what" id="what"
                                                    placeholder="{$lng_what_is_the_house_for}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input type="text" class="form-control " name="budget" id="budget"
                                                    placeholder="{$lng_approximade_budget}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input type="text" class="form-control " name="tipo" id="tipo"
                                                    placeholder="{$lng_type_of_house}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mb-3">
                             
                                            <input type="text" class="form-control " name="where" id="where"
                                                    placeholder="{$lng_where}">
                                    </div>
                                    <div>
                                        <label class="checkcontainer mb-4">
                                            <span
                                                class="tag-name">{assign var="urlPPRV" value=sprintf('<a href="%s%s/" target="_blank">', {$urlStart},
                                                {$url_privacy})}
                                                {$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:'</a>'}*
                                            </span>
                                            <input type="checkbox" name="lpd" id="lpd" class="required" />
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}"></div>
                                        <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha"
                                            id="hiddenRecaptcha">
                                    </div>
                                    <input type="hidden" name="lang" value="{$lang}">
                                    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}"
                                        value="" class="hide">
                                    <button type="submit" class="btn btn-primary btn-block">Book now</button>
                                    <div class="gdpr">{$texto_formularios_GDPR}</div>
                                </form>
                            </div>
                    </div>
                </div>

               {*  <h2 class="main-title subtitle my-5"> Share </h2>
                <div class="redes mb-4 mb-lg-5">
                  <a class="pe-4 pe-lg-5 d-inline-block facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                      facebook
                  </a>  
                  <a class="pe-4 pe-lg-5 d-inline-block twitter" href="https://www.twitter.com/share?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                       twitter
                  </a>   
                  <a class="pe-4 pe-lg-5 d-inline-block linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&title=&summary=&source=" target="_blank">
                       Linkedin
                  </a>  
                  <a class="pe-4 pe-lg-5 d-inline-block pinterest" href="http://pinterest.com/pin/create/button/?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                      Pinterest
                  </a>
                </div> *}


                </div>
            </div>

        </div>
    </div>
</div>



{include file="footer.tpl"}

