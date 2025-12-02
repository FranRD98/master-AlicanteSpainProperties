<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="{$lang}"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="{$lang}"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="{$lang}"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="{$lang}">
<!--<![endif]-->
<head>

    {if $isInsights == false}
    {include file="partials/analytics.tpl"}
    {/if}

    <meta charset="utf-8">
    <title>{$metaTitle|strip_tags|strip|truncate:55:'':true}</title>
    <meta name="description" content="{$metaDescription|strip_tags|strip|truncate:155:'':true}" >
    <meta name="keywords" content="{$metaKeywords|strip_tags}" >
    <meta property="og:site_name" content="{$smarty.server.HTTP_HOST}">
    <meta property="og:title" content="{$metaTitle}">
    {if $metaURL != ''}
        <meta property="og:url" content="{$metaURL}">
    {/if}
    <meta property="og:type" content="website">
    <meta property="og:description" content="{$metaDescription|strip_tags|strip|truncate:170:'':true}">
    {if $metaImage != ''}
        <meta property="og:image" content="{$metaImage}">
    {/if}
    <meta name="revisit-after" content="7 DAYS" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">

    <!-- CSS Y JS
    ================================================== -->
    {if $isInsights == false}
        {include file="partials/css.insights.tpl"}
    {/if}

    {if $isInsights == false}
    <script src='https://www.google.com/recaptcha/api.js?hl={$lang}"'></script>
    {/if}

    <!-- SEO
    ================================================== -->
    {if count($languages) > 1}
       {foreach from=$languages item=idm}
           {if $idm != $language}{* // SI NO ES EL IDIOMA PRINCIPAL // *}
               {assign var="alternateURL" value={$url{$idm|upper}|replace:'http:':'https:'} }
               {* // SI NO DISPONE DE TRADUCCIÓN // *}
               {if ($seccion != "" && {$alternateURL} == "https://{$smarty.server.HTTP_HOST}/{$idm}/") || {$alternateURL} == "" || {$alternateURL} == "https://{$smarty.server.HTTP_HOST}/{$idm}/{$seccion_lang[$idm]}/" }
                   {assign var="alternateURL" value="" }
               {/if}
           {else if {$urlDefault} != "" && {$urlDefault|replace:'http:':'https:'} != "https://{$smarty.server.HTTP_HOST}/{$seccion_lang[$idm]}/" } {* // SI ES EL IDIOMA PRINCIPAL Y DISPONE DE TRADUCCIÓN // *}
               {assign var="alternateURL" value={$urlDefault}|replace:'http:':'https:'}
           {/if}
           {* // SI LA URL ES CORRECT Y NO TIENE EL DOMINIO, SE LO AÑADIMOS // *}
           {if $alternateURL != "" && !preg_match pattern='http' subject=$alternateURL }
               {assign var="alternateURL" value="https://{$smarty.server.HTTP_HOST}{$alternateURL}" }
           {/if}
           {if {$alternateURL} != "" } {* // SI DISPONE DE TRADUCCIÓN AÑADIMOS EL HREFLANG // *}
               <link rel="alternate" hreflang="{$idm}" href="{$alternateURL}" />
           {/if}
       {/foreach}
    {/if}

    {if $totalprops > 0}
        {paginate_prev2}
        {paginate_next2}
    {/if}

    {if $noIndex == 1}
        <meta name="GOOGLEBOT" content="NOINDEX" >
        <meta name="ROBOTS" content="NOINDEX">
    {else}
        <meta name="GOOGLEBOT" content="INDEX,FOLLOW,ALL" >
        <meta name="ROBOTS" content="INDEX,FOLLOW,ALL" >
    {/if}

    {if $addDefaultURLCanonical == 1}
        <link rel="canonical" href="{$current_url}" />
    {else }
        {if $seccion == ''}
            <link rel="canonical" href="{$current_url}" />
        {else}
            <link rel="canonical" href="{$current_url}" />
        {/if}
    {/if}

    <!-- Favicons
    ================================================== -->

    <link rel="shortcut icon" href="/media/images/icons/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="/media/images/icons/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="/media/images/icons/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/media/images/icons/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="/media/images/icons/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/media/images/icons/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="/media/images/icons/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/media/images/icons/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/media/images/icons/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/media/images/icons/apple-icon-180x180.png" />
    <link rel="icon" type="image/png" sizes="192x192"  href="/media/images/icons/android-icon-192x192.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/media/images/icons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="96x96" href="/media/images/icons/favicon-96x96.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/media/images/icons/favicon-16x16.png" />
    <link rel="manifest" href="/media/images/icons/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="/media/images/icons/ms-icon-144x144.png" />
    <meta name="theme-color" content="#ffffff" />


</head>

<body class="{$lang} {$seccion_master} {if $seccion != ''}interior{else}home{/if}">

    {* @group SEC - TOP CABECERA DESKTOP *}

    <div class="main-header-top d-none d-xl-block">
        <div class="container">
            <div class="row">
                <div class="col text-end">
                    {* @group SEC - EMAIL *}
                    <div class="d-inline-block pe-3">
                        {* Datos de contacto en connections/conf/config.php *}
                        <a href="mailto:{$correoEmpresa}">{$correoEmpresa}</a>
                    </div>
                    {* @group SEC - TELEFONO *}
                    <div class="d-inline-block pe-3">
                        <a href="tel:{$telefonoEmpresa}">{$telefonoEmpresa}</a>
                    </div>
                    {* @group SEC - IDIOMAS *}
                    <div class="d-inline-block pe-3">
                        {* 
                           url_flags = "flags" -> Iconos por defecto; 
                           url_flags = "flags-rounded" -> iconos en forma de circulo
                        *}
                        {include file="partials/idiomas.tpl" url_flags="flags-rounded"} 
                    </div>
                    {* @group SEC - TIEMPO *}
                    <div class="d-none d-lg-inline-block pe-3">
                        {include file="partials/weather.tpl"}
                    </div>
                </div>
            </div>
        </div>
    </div>



    {* @group SEC - CABECERA DESKTOP *}

    <div class="main-header">
        <div class="container h-100">
            <div class="row align-items-center h-100">

                <div class="col-6 col-md-3">
                    <a class="d-inline-block" href="{$urlStart}">
                        <img class="brand img-fluid" src="/media/images/website/website-logo.png" alt="{$nombreEmpresa}" title="{$nombreEmpresa}">
                    </a>
                </div>
                <div class="col-6 col-md-9 text-end">

                    <nav id="main-nav" class="d-inline-block">


                        {*
                            buscador header en escritorio (por defecto desactivado)
                            Activar en connections -> conf -> config.php
                        *}

                        {if $actBuscadorHeader == 1}
                            <a href="javascript:void(0);" data-toggle="modal" data-target="" class="float-end d-inline-block ms-3 btn-top-search">
                                  <img src="/media/images/website/lupa.svg">
                           </a>
                        {/if}


                        {* @group SEC - MENU *}
                        <ul class="list-inline d-none d-xl-inline-block mb-0">
                            {include file="partials/menu.tpl" submenu=1}
                        </ul>

                    </nav>

                    <div class="d-inline-block">
                        {*
                           url_flags = "flags" -> Iconos por defecto;
                           url_flags = "flags-rounded" -> iconos en forma de circulo
                        *}
                        {include file="partials/idiomas.tpl" button="1" url_flags="flags-rounded"}
                    </div>


                    <div class="d-inline-block d-lg-none">
                        {if $seccion == $url_advanced_search || $seccion == ''}
                            <a class="responsive-search-button btn" href="{$urlStart}{$url_properties}/">
                                <i class="fa fa-search text-dark" aria-hidden="true"></i>
                            </a>
                        {else}
                            <a class="responsive-search-button btn" href="#">
                                <i class="fa fa-search text-dark" aria-hidden="true"></i>
                            </a>
                        {/if}
                    </div>


                    <a class="btn-menu-lateral  ms-3 d-inline-block" href="javascript:void(0);">
                        <img src="/media/images/website/bars.svg">
                    </a>

                </div>

            </div>
        </div>
    </div>


    {* center-form -> centra el buscador y el caption dentro de la foto. Quitandolo el formulario queda bajo la foto principal *}

    <div class="wrapper-slider-search center-form">

    {* @group SEC - SLIDER *}

    {if $seccion == ''}

        <div class="main-slider" >

            {if $actBannerUrl == 1 && $banners[0].url != ''}<a href="{$banners[0].url}">{/if}
            
                <div class="caption text-center">

                    {if $actBannerTxt == 1}

                        {$banners[0].caption} {if $actBannerDesc == 1}
                            <small>{$banners[0].description}</small>
                        {/if}
                    {/if}
                    
                </div>
            {if $actBannerUrl == 1 && $banners[0].url != ''}</a>{/if}

        </div>

    {/if}

    {* @group SEC - BUSCADOR *}

    {if $seccion != $url_advanced_search}

    <div class="buscador {if $seccion == ''} b-home {/if} ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {include file="partials/buscador.tpl"}
                </div>
            </div>
        </div>
    </div>
    
    {/if}

    </div>

    {include file="partials/menu-burger.tpl"}

