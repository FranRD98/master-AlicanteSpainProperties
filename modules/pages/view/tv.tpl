<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="{$lang}"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="{$lang}"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="{$lang}"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="{$lang}">
<!--<![endif]-->
<head>
    

    <meta charset="utf-8">
    <title>{$metaTitle|strip_tags|strip|truncate:55:'':true}</title>
    <meta name="description" content="{$metaDescription|strip_tags|strip|truncate:155:'':true}" >
    <meta name="keywords" content="{$metaKeywords|strip_tags}" >
    <meta property="og:site_name" content="{$smarty.server.HTTP_HOST}">
    <meta property="og:title" content="{$metaTitle}">
    {if $metaURL != ''}
        <meta property="og:url" content="{$metaURL}">
    {/if}
    <meta property="og:type" content="blog">
    <meta property="og:description" content="{$metaDescription|strip_tags|strip|truncate:170:'':true}">
    {if $metaImage != ''}
        <meta property="og:image" content="{$metaImage}">
    {/if}
    <meta name="GOOGLEBOT" content="INDEX,FOLLOW,ALL" >
    <meta name="ROBOTS" content="INDEX,FOLLOW,ALL" >
    <meta name="revisit-after" content="7 DAYS" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">

    <!-- CSS Y JS
    ================================================== -->
    {if $isInsights == false}
        {include file="partials/css.insights.tpl"}
    {/if}

    {if $seccion == $url_property || $seccion == $url_favorites}
        <script src='https://www.google.com/recaptcha/api.js?hl={$lang}"'></script>
    {/if}

    <!-- SEO
    ================================================== -->
    {if count($languages) > 1}
        {foreach from=$languages item=idm}
            {if $idm != $language}
            <link rel="alternate" hreflang="{$idm}" href="{$smarty.server.REQUEST_SCHEME}://{$smarty.server.HTTP_HOST}{$url{$idm|upper}}" />
            {else}
            <link rel="alternate" hreflang="{$idm}" href="{$smarty.server.REQUEST_SCHEME}://{$smarty.server.HTTP_HOST}{$urlDefault}" />
            {/if}
        {/foreach}
    {/if}

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="/media/images/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/media/images/icons/apple-touch-icon-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/media/images/icons/apple-touch-icon-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/media/images/icons/apple-touch-icon-72.png">
    <link rel="apple-touch-icon-precomposed" href="/media/images/icons/apple-touch-icon-57.png">


    <style>


    .logo 
    {
        width: 80%;
        max-width: 420px;
        margin-left: auto;
        margin-right: auto;

    }

    .logo span
    {
        display: block;
        text-align: right;
        margin-left: auto;
        margin-top: -10px;
    }

    body.tv-page 
    {
        padding: 0;
        margin: 0;
    }
    .img-list 
    {
        height: 25vh;
    }
    .img-big 
    {
        height: 75vh;
        position: relative;
        z-index: 1;
    }
    .labels 
    {
        position: absolute;
        z-index: 2;
        top: 15px;
        left: 15px;
        
    }
    .badge 
    {
        border-radius: 0;
        font-size: 19px;
        font-weight: bold;
        text-transform: uppercase;
        display: block;
        width: fit-content;
        margin-bottom: 4px;
        letter-spacing: 2.28px;
        font-family: "Space Grotesk", sans-serif !important;
    }
    .referencia 
    {
        position: absolute;
        z-index: 2;
        top: 15px;
        right: -15px;
    }
    .referencia:after 
    {
        content: "";
        display: block;
        position: absolute;
        border-right: 7.5px solid transparent;
        border-top: 7.5px solid #222;
        border-left: 7.5px solid #222;
        border-bottom: 7.5px solid transparent;
        bottom: -15px;
        right: 0;
    } 
    .img-background 
    {
        background-size: cover;
        background-position: center;
        background-color: #f0f0f0;
    }
    .main-title small
    {
        font-size: 18px;
        font-weight: normal;
        letter-spacing: 1.44px;
        color: #5c5c5c;
    }
    .precio 
    {
        font-size: 33px;
        font-weight: bold;
    }
    .precio small, .precio del 
    {
        font-size: 18px;
        font-weight: normal;
    }
    .property-tab
    {
        border-radius: 11px;
        overflow: hidden;
        min-height: 260px;
    }
    .iconos 
    {
        font-size: 18px;
        font-weight: bold;
    }
    .iconos img
    {
        margin-right: 18px;
    }
    
    @media (min-width: 1441px) 
    {
        .iconos 
        {
            font-size: 20px;
        }
    }

    #qrcode span
    { 
      font-size: 16px;
      font-weight: 500;
      letter-spacing: 0.32px;
    }

    #qrcode
    {
        overflow: hidden;
        width: fit-content;
        border-radius: 10px;
        border: 1px solid #ece81a;
    }
    .contact-detail p
    {
         font-family: "Space Grotesk", sans-serif !important;
    }

    .contact-detail p img 
    {
        display: inline-block;
    }

    .contact-detail .icon
    {
        height: 34px;
        width: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .contact-detail span
    {
        font-size: 16px;
        font-weight: 500;
        text-transform: uppercase;
        display: block;
        margin-bottom: 14px;
    }
    .col-5.ajustar
    {
        max-width: 260px !important;
    }

    /* solamente pantalla 4k */
    @media (min-width: 3800px) and (min-height: 1900px) 
    {
        .slides 
        {
            padding-left: 30px !important;
        }
        .logo 
        {
            max-width: 520px;
        }
        .logo img
        {
            max-width: none;
            width: 100%;
            height: auto;
        }

        .contact-detail
        {
            font-size: 24px;
        }
        .main-title small
        {
            font-size: 24px;
        }
        .precio 
        {
            font-size: 36px;
        }
        .precio small, .precio del 
        {
            font-size: 20px;
        }
        .iconos 
        {
            font-size: 26px;
            padding-top: 60px !important;
            padding-bottom: 40px !important;
        }
        .iconos .col-6 
        {
            margin-bottom: 30px !important;
        }
        .iconos img 
        {
            height: 38px;
        }
        .contact-detail span
        {
            font-size: 24px;
        }
        #featured-properties .main-title
        {
            font-size: 40px;
        }
        .col-right
        {
            padding-left: 80px !important;
            padding-right: 80px !important;
        }
        #qrcode span
        { 
          font-size: 24px;
        }
        #qrcode img 
        {
            width: 260px;
            height: 260px;
        }
        .col-5.ajustar
        {
            max-width: 320px !important;
        }
    }

</style>


</head>

<body class="{$lang} {$seccion_master} tv-page">
    <div id="featured-properties" class="slides bg-white py-0">
        {section name=ft loop=$tv}
            <div class="container-fluid slide px-4">
                <div class="row">
                    <div class="col-8">
                        <div class="img-big w-100">

                            <div class="pt-xxl-5 pt-4 h-100 w-100">

                                <div class="referencia badge bg-dark text-white mt-4 mt-xxl-5">
                                    Ref: {$tv[ft].ref}
                                </div>

                                <div class="labels mt-4 mt-xxl-5">

                                    {if {$tv[ft].nuevo_prop|strtotime} >= $smarty.now }
                                        <div class="badge bg-success">{$lng_nuevo}</div>
                                    {/if}
                                    {if $tv[ft].vendido_tag_prop == 1}
                                        <div class="badge bg-danger">{$lng_vendido}</div>
                                    {/if}
                                    {if $tv[ft].alquilado_prop == 1}
                                        <div class="badge bg-danger">{$lng_alquilado}</div>
                                    {/if}
                                    {if $tv[ft].reservado_prop == 1}
                                        <div class="badge bg-danger">{$lng_reservado}</div>
                                    {/if}
                                    {assign var=tag value=getPropTags($tv[ft].id_prop, $lang)}
                                    {section name=tg loop=$tag}
                                        {if $tag[tg].tag != ''}
                                            <div class="badge badge-info label-{$tag[tg].id_tag}">{$tag[tg].tag}</div>
                                        {/if}
                                    {/section}

                                </div>


                                {if {preg_match pattern="https?" subject=$tv[ft].image_img}}
                                    <div class="img-background h-100 w-100" style="background-image: url('{$tv[ft].image_img}')">
                                    </div>
                                {else}
                                    <div class="img-background h-100 w-100" style="background-image: url(/media/images/properties/{$tv[ft].image_img})">
                                    </div>
                                {/if}
                            </div>
                        </div>
                        {if $tv[ft].images|count >= 1}
                            <div class="img-list">
                                <div class="row pt-3 pb-xl-4 pb-xxl-5 pl-xxl-5 h-100">
                                    {foreach from=$tv[ft].images item=img}
                                        <div class="col-4">
                                            {if {preg_match pattern="https?" subject=$img.image_img}}
                                                <div class="w-100 h-100 img-background" style="background-image: url('{$img.image_img}')"></div>
                                            {else}
                                                <div class="w-100 h-100 img-background" style="background-image: url(/media/images/properties/{$img.image_img})">
                                                </div>
                                            {/if}
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                        {/if}
                    </div>
                    <div class="col-4 col-right pt-4 pt-xxl-5 px-4">

                        <div class="h-100 w-100">

                            <div class="logo">
                                <img src="/media/images/website/website-logo.svg" height="92" class="img-fluid mx-auto">
                            </div>

                            <div class="row justify-content-center py-4">
                                
                                <div class="col-8">
                                    <h2 class="main-title d-flex align-items-center justify-content-center text-dark text-capitalize my-0 pt-xxl-3" >
                               
                                            <img src="/media/images/website/tv/icon-location-property.svg" class="me-3">
                                            <div>
                                                {if $tv[ft].titulo != ''}
                                                    {$tv[ft].titulo}
                                                {else}

                                                    {$tv[ft].town} {if $tv[ft].area != $tv[ft].town} · {$tv[ft].area}{/if}

                                                    <small class="text-uppercase d-block">
                                                        {$tv[ft].type} · {$tv[ft].sale}
                                                    </small>

                                                {/if}
                                            </div>
                                  
                                    </h2>
                                </div>
                            </div>
  
                            <div class="property-tab bg-light my-4 mb-xxl-5">
                              
                                {* @group SEC - PRECIO *}
                                <div class="bg-primary text-dark text-center py-3 py-xxl-4">
                                    <div class="precio">
                                        {if $tv[ft].precio_desde_prop == 1}
                                            <small>{$lng_from}</small>
                                        {else}
                                            {if $tv[ft].old_precio > 0}
                                                <del>
                                                    {$tv[ft].old_precio|number_format:0:",":"."}€
                                                </del>
                                            {/if}
                                        {/if}
                                        
                                        {if {$tv[ft].precio|number_format:0:",":"."} != 0}
                                            {$tv[ft].precio|number_format:0:",":"."}<small>€</small>
                                        {else}
                                            {$lng_consultar}
                                        {/if}
                                    </div>
                                </div>

                                {* @group SEC - ICONOS *}
                                <div class="row g-4 iconos p-4">
                                                
                                    {if {$tv[ft].m2_prop|number_format:0:",":"."} > 0}

                                    <div class="col-6 d-flex align-items-center justify-content-start px-xxl-5 px-xl-4">
                                        <img src="/media/images/website/tv/house.svg">
                                        <span> 
                                            {$tv[ft].m2_prop|number_format:0:",":"."}m<sup>2</sup>
                                        </span>
                                    </div>

                                    {/if}
                                    {if {$tv[ft].m2p_prop|number_format:0:",":"."} > 0}
                                    <div class="col-6 d-flex align-items-center justify-content-start px-xxl-5 px-xl-4">
                                        <img src="/media/images/website/tv/plano.svg">
                                        <span>{$tv[ft].m2p_prop|number_format:0:",":"."}m<sup>2</sup></span>
                                    </div>
                                    {/if}

                                     {if {$tv[ft].habitaciones_prop|number_format:0:",":"."} > 0}
                                    <div class="col-6 d-flex align-items-center justify-content-start px-xxl-5 px-xl-4">
                                        <img src="/media/images/website/tv/bed.svg">
                                        <span>{$tv[ft].habitaciones_prop|number_format:0:",":"."}</span>
                                    </div>
                                    {/if}
                                    {if {$tv[ft].aseos_prop|number_format:0:",":"."} > 0}
                                    <div class="col-6 d-flex align-items-center justify-content-start px-xxl-5 px-xl-4">
                                        <img src="/media/images/website/tv/bath.svg">
                                        <span>{$tv[ft].aseos_prop|number_format:0:",":"."}</span>
                                    </div>
                                    {/if}

                                    {if $tv[ft].piscina_prop != ''}
                                    <div class="col-6 d-flex align-items-center justify-content-start px-xxl-5 px-xl-4">
                                        <img src="/media/images/website/tv/pool.svg">
                                        <span>{$tv[ft].piscina_prop}</span>
                                    </div>
                                    {/if}
                                    {if $tv[ft].parking_prop != ''}
                                    <div class="col-6 d-flex align-items-center justify-content-start px-xxl-5 px-xl-4">
                                        <img src="/media/images/website/tv/garaje.svg">
                                        <span>{$tv[ft].parking_prop}</span>
                                    </div>
                                    {/if}
                                </div>
                                
                            </div>


                            <div class="row mt-4 mt-xxl-5">
                                <div class="col-5 pe-xxl-0 ajustar">

                                    <div id="qrcode">

                                        <span class="bg-primary w-100 text-dark text-center text-uppercase d-block py-1">
                                            {$lng_mas_informacion}
                                        </span>

                                        <div class="p-2">
                                            <img class="d-none d-xxl-block" src="http://api.qrserver.com/v1/create-qr-code/?size=190x190&data=https://{$smarty.server.HTTP_HOST}/{propURL($tv[ft].id_prop, $lang)}">
                                            <img class="d-xxl-none" src="http://api.qrserver.com/v1/create-qr-code/?size=160x160&data=https://{$smarty.server.HTTP_HOST}/{propURL($tv[ft].id_prop, $lang)}">
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="col ps-xl-5 ps-xxl-3">

                                    <div class="contact-detail  ">
                                        <span>
                                            {$lng_contactar}
                                        </span>

                                        <p class="d-flex w-100 align-items-center justify-content-start">
                                           <img class="me-2" src="/media/images/website/tv/icon-whatsapp.svg">  {$telefonoEmpresa2}
                                        </p>
                                        <p class="d-flex w-100 align-items-center justify-content-start">
                                           <span class="icon bg-light rounded-circle me-2 mb-0">
                                               <img src="/media/images/website/tv/icon-phone.svg">
                                           </span>  {$telefonoEmpresa}
                                        </p>

                                        <span>
                                            {$lng_siguenos}
                                        </span>

                                        <img class="img-fluid mt-3 mt-xxl-4" src="/media/images/website/tv/icons-social.svg">

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {/section}
    </div>

<!-- JS
  ================================================== -->

{* @group JS - JQUERY *}
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write(unescape('%3Cscript src="/js/source/jquery-1.10.2.js"%3E%3C/script%3E'))</script>

{* @group JS - TEXTOS *}
<script>
    var appLang  = "{$lang}";
    // Envio formularios
    var okConsult = '{$lng_el_mensaje_se_ha_enviado_correctamente_|escape:"quotes"}';
    var okRecomen = '{$lng_la_recomendacion_se_ha_enviado_|escape:"quotes"}';
    var okPropert = '{$lng_las_propiedades_se_han_enviado_|escape:"quotes"}';
    var okNewslet = '{$lng_se_ha_anadido_a_la_lista_de_correo_correctamente_|escape:"quotes"}';
    var yaNewslet = '{$lng_este_email_ya_se_encuentra_en_lista_de_correo_|escape:"quotes"}';
    var bajPrecio = '{$lng_su_solicitud_de_alta_se_ha_finalizado_correctamente|escape:"quotes"}';
    var cookieTxt = '{$lng_cookiestext|escape:"quotes"}';
    var cookiePol = '{$lng_politica_de_cookies|escape:"quotes"}';
    var cookieTxtBtn = '{$lng_continuar|escape:"quotes"|upper}';
    var cookieTxtMoreInfo = '{$lng_mas_informacion|escape:"quotes"}';
    var cookieURL = '{$urlStart}cookies/';
    var todotxt = '{$lng_todo|escape:"quotes"}';
    var delallfavs = '{$lng_seguro_que_desea_eliminar_todos_los_favoritos|escape:"quotes"}';
</script>

{* @group JS - PLUGINS JS *}
{if $isInsights != true}
<script src="/js/plugins.{getFileTime('js/plugins.js')}.js"></script>
{/if}
{* @group JS - MWEBSITE JS *}
{if $isInsights != true}
{* <script src="/js/website.{getFileTime('js/website.js')}.js"></script> *}
{/if}

{if $isInsights == true}
    {include file="partials/css.insights.tpl"}
{/if}

{literal}
<script>
    !function ($) {
        $('.tv-page .slides').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            mobileFirst: true,
            zIndex: -1,
            dots: false,
            arrows: false,
            fade: true,
            cssEase: 'linear',
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 15000
        });
    }(window.jQuery);
</script>
{/literal}

</body>
</html>
