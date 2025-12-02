<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="{$lang}"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="{$lang}"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="{$lang}"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="{$lang}">
<!--<![endif]-->
<head>
    
    {include file="partials/analytics.tpl"}

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

    <script src='https://www.google.com/recaptcha/api.js?hl={$lang}"'></script>

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
           {if {$alternateURL} != "" && !{preg_match pattern='http' subject=$alternateURL} }
               {assign var="alternateURL" value="https://{$smarty.server.HTTP_HOST}{$alternateURL}" }
           {/if}
           {if {$alternateURL} != "" } {* // SI DISPONE DE TRADUCCIÓN AÑADIMOS EL HREFLANG // *}
               <link rel="alternate" hreflang="{$idm}" href="{$alternateURL}" />
           {/if}
       {/foreach}
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

    {if $noIndex == 1}
        <meta name="GOOGLEBOT" content="NOINDEX" >
        <meta name="ROBOTS" content="NOINDEX">
    {else}
        <meta name="GOOGLEBOT" content="INDEX,FOLLOW,ALL" >
        <meta name="ROBOTS" content="INDEX,FOLLOW,ALL" >
    {/if}

    {if $addDefaultURLCanonical == 1}
        <link rel="canonical" href="{if preg_match('/https?/',{$url{$lang|upper}}) }{$url{$lang|upper}|replace:'http://':'https://'}{else}https://{$smarty.server.HTTP_HOST}{$url{$lang|upper}}{/if}" />
    {else }
        {if $seccion == ''}
            <link rel="canonical" href="https://{$smarty.server.HTTP_HOST}{$urlStart}{$seccion}" />
        {else}
            <link rel="canonical" href="https://{$smarty.server.HTTP_HOST}{$urlStart}{$seccion}/" />
        {/if}
    {/if}

</head>
<body class="{$lang} {$seccion_master} {if $seccion != ''}interior{else}home{/if}">


<div>
	
</div>

</body>
    


