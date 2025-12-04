    {* @group SEC - TEXTO LANDINGS *}
    {if ($seccion == 'landing' && $home != '') || isset($smarty.get.idquick) && $smarty.get.idquick != ''}
    <div class="landing-text">
        <div class="container">
            <div class="row">
                <div class="page-content">
                    <div class="col-md-12">
                        <h2 class="main-title">{$tituloland}</h2>
                        {$home}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/if}


    {* @group SEC - ZONAS *}
    {if $seccion == '' && isset($zonasmen[0])}
<div class="home-zonas my-4 my-lg-5 py-3 py-lg-4">
    <div class="container pt-3">
        <div class="row align-items-center">
            
            <!-- COLUMNA IZQUIERDA -->
            <div class="col-lg-6">

                <!-- Títulos -->
                <div class="banners-ttl pb-3 pb-md-2">
                    <h3 class="title mb-2">{$lng_elige_costa}</h3>
                    <h2 class="title mb-4">{$lng_mediterraneo}</h2>
                </div>

                <!-- PRIMERA ÁREA (ft == 0) -->
                {section name=ft loop=$zonasmen}
                    {if $smarty.section.ft.index == 0}
                        
                        {assign var="imgProp" value="/media/images/zonas/{$zonasmen[ft].img}"}

                        <a href="{$urlStart}{$zonasmen[ft].titulo|slug}.html" 
                        class="zona-card d-flex align-items-start justify-content-start p-4 mb-4"
                        style="background-image:url('{$imgProp}');">

                            <div class="zona-card-content">
                                <h3 class="zona-card-title">{$zonasmen[ft].titulo}</h3>
                                <span class="zona-card-link">{$lng_ver_propiedades}</span>
                            </div>

                            <div class="zona-card-logo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="149.702" height="126.782" viewBox="0 0 149.702 126.782">
                                        <g data-name="Grupo 9624">
                                            <path data-name="Trazado 15789" d="M791.582 573.413A131.774 131.774 0 0 0 686.5 509.307a1.867 1.867 0 0 1-1.525-2.788l34.125-59.507z" transform="translate(-644.235 -447.012)" style="fill:#fff"/>
                                            <path data-name="Trazado 15790" d="M801.213 563.27h-35.2a56.589 56.589 0 0 0-86.646 0h-27.86l24.962-43.528a14.271 14.271 0 0 1 11.409-7.122q4.572-.316 9.227-.319a131.553 131.553 0 0 1 104.1 50.97" transform="translate(-651.511 -436.488)" style="fill:#29bdef"/>
                                        </g>
                                    </svg>
                            </div>
                        </a>

                    {/if}
                {/section}

            </div>

            <!-- COLUMNA DERECHA -->
            <div class="col-lg-6">

                <!-- RESTO DE ÁREAS (ft > 0) -->
                {section name=ft loop=$zonasmen}
                    {if $smarty.section.ft.index > 0}

                        <div class="mb-4">
                            {assign var="imgProp" value="/media/images/zonas/{$zonasmen[ft].img}"}

                            <a href="{$urlStart}{$zonasmen[ft].titulo|slug}.html" 
                            class="zona-card d-flex align-items-start justify-content-start p-4"
                            style="background-image:url('{$imgProp}');">

                                <div class="zona-card-content">
                                    <h3 class="zona-card-title">{$zonasmen[ft].titulo}</h3>
                                    <span class="zona-card-link">{$lng_ver_propiedades}</span>
                                </div>

                                <div class="zona-card-logo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="149.702" height="126.782" viewBox="0 0 149.702 126.782">
                                        <g data-name="Grupo 9624">
                                            <path data-name="Trazado 15789" d="M791.582 573.413A131.774 131.774 0 0 0 686.5 509.307a1.867 1.867 0 0 1-1.525-2.788l34.125-59.507z" transform="translate(-644.235 -447.012)" style="fill:#fff"/>
                                            <path data-name="Trazado 15790" d="M801.213 563.27h-35.2a56.589 56.589 0 0 0-86.646 0h-27.86l24.962-43.528a14.271 14.271 0 0 1 11.409-7.122q4.572-.316 9.227-.319a131.553 131.553 0 0 1 104.1 50.97" transform="translate(-651.511 -436.488)" style="fill:#29bdef"/>
                                        </g>
                                    </svg>
                                </div>
                            </a>
                        </div>

                    {/if}
                {/section}

            </div>

        </div>
    </div>
</div>
{/if}


    {* @group SEC - BANNERS 

     {if $seccion == ''}
        {if $seccion != $url_news}
            <div class="banners">
                <div class="container">
                    {include file="partials/banners.tpl"}
                </div>
            </div>
        {/if}
    {/if}
    *}

    {* @group SEC - DESTACADOS *}
    {if $seccion == '' && isset($featured[0]) && $featured[0].id_prop != ''}
    <div id="featured-properties">
        <div class="container">
            <div class="row align-items-center">

            <!-- Arrow Slides -->
            <div class="col-12 col-lg-3 arrows-slide-dots gap-2 d-none d-lg-flex">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.327" height="12.133" viewBox="0 0 12.327 12.133">
                        <g data-name="Grupo 9618">
                            <g data-name="Icon feather-arrow-right">
                                <path data-name="Trazado 456" d="m18 7.5 5.291 5.549L18 18.6" style="fill:none;stroke:#000;stroke-width:1.5px" transform="rotate(180 12.164 9.558)"/>
                            </g>
                            <path data-name="Línea 1423" transform="rotate(90 3.155 9.173)" style="fill:none;stroke:#000;stroke-width:1.5px" d="M0 8V0"/>
                        </g>
                    </svg>
                </button>

                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.327" height="12.133" viewBox="0 0 12.327 12.133">
                        <g data-name="Grupo 9622">
                            <g data-name="Icon feather-arrow-right">
                                <path data-name="Trazado 456" d="m18 7.5 5.291 5.549L18 18.6" style="fill:none;stroke:#000;stroke-width:1.5px" transform="translate(-12 -6.983)"/>
                            </g>
                            <path data-name="Línea 1423" transform="rotate(-90 3.058 3.057)" style="fill:none;stroke:#000;stroke-width:1.5px" d="M0 8V0"/>
                        </g>
                    </svg>
                </button>
            </div>
                <div class="col-12 col-lg-6 text-center">
                    <h3 class="main-subtitle mb-2">{$lng_propiedades_home_subtitulo}</h3>
                    <h2 class="main-title m-0">{$lng_propiedades_home_titulo}</h2>
                </div>

                <div class="col-12 col-lg-3 justify-content-end d-none d-lg-flex">
                <a href="/es/propiedades/" class="btn-propiedades px-lg-5">Ver todas las propiedades</a>
                </div>
                <div class="col-md-12 px-md-0 mt-4 pt-2 pt-md-3">

                    <div class="slides">
                        {section name=ft loop=$featured}
                            {include file="partials/slider-properties.tpl" resource=$featured[ft]}
                        {/section}
                    </div>

                    
                </div>
            </div>
            {*
            <div class="text-center mt-5 mb-5">
                <a href="{$urlStart}{$url_properties}/" class="btn btn-primary">{$lng_ver_todas_las_propiedades}</a>
            </div>
            *}
        </div>
    </div>
    {/if}

    {* @group SEC - OFERTAS *}

    {if $showprecioReduc == 1}
    {if $seccion == '' && isset($ofertas[0]) && $ofertas[0].id_prop != ''}
    <div id="ofertas-properties">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-title">{$lng_propiedades} <span>{$lng_ofertas}</span></h2>
                </div>
                <div class="col-md-12 px-md-0">
                    <div class="slides">
                        {section name=ft loop=$ofertas}
                            {include file="partials/slider-properties.tpl" resource=$ofertas[ft]}
                        {/section}
                    </div>
                </div>
            </div>
            <div class="text-center mt-5 mb-5">
                <a href="{$urlStart}{$url_properties}/" class="btn btn-primary">{$lng_ver_todas_las_propiedades}</a>
            </div>
        </div>
    </div>
    {/if}
    {/if}

    <!-- PROMOCIONES -->
    <div class="home-promotions">
        <div class="container">
            <div class="content-home-promotions">
                <div class="content-home-promotions-txt">
                    <h3 class="main-title mb-2">{$lng_buscas_algo_nuevo}</h3>
                    <h2 class="main-title mb-3 py-1">{$lng_descubrir_novedades}</h2>
                    <p class="pb-2">{$lng_texto_promociones_home}</p>
                    <a href="/es/promociones/">{$lng_ver_todas_las_promociones}</a>
                </div>
            </div>
        </div>
    </div>

<!-- Porque nosotros -->
<div class="why-us-section mt-4 my-80 mb-lg-5">
    <div class="container-fluid">
        <div class="row align-items-start">

            <!-- Primera imagen a la izquierda -->
            <div class="d-none d-xl-block col-xl-2 px-0 home-img-left">
                <img src="/media/images/website/why-us-1.webp" alt="Alicante Spain Properties" class="img-fluid w-100">
            </div>

            <!-- Segunda imagen -->
            <div class="col-12 col-lg-6 col-xl-4">
                <img src="/media/images/website/why-us-2.webp" class="img-fluid w-100 br20" alt="Alicante Spain Properties">
            </div>

            <!-- Título y texto -->
            <div class="col-12 col-lg-6 col-xl-5 offset-xl-1 ttl-left pt-lg-4 pt-xl-3 pb-4 px-3 px-lg-4">
                
                <!-- Título ligeramente sobre la imagen -->
                <div class="title-offset" style="margin-left: -230px;">
                    <h3 class="main-title mb-2">Why us</h3>
                    <h2 class="main-title mb-4 mb-lg-5">A powerful network for <br><strong>buyers and sellers</strong></h2>
                </div>

                <!-- Texto limitado en ancho -->
                <div class="text-content" style="max-width: 500px;"> 
                    <p>Alicante Spain Properties is a property portal created by Mediaelx to connect international buyers and sellers with trusted real estate agencies on the Costa Blanca, Costa Cálida and Costa del Sol.</p>
                    <p>With over 2,000 properties available—both new builds and resales—and a network of more than 100 professional agents, we offer one of the most complete and up-to-date selections on the market.</p>
                    <p>Whether you’re buying your next home or selling a property, we make the process easier and more reliable by putting you in direct contact with experienced local experts.</p>
                </div>

            </div>

        </div>
    </div>
</div>

    {* @group SEC - PROMOCIONES DESTACADAS *}
    {if $seccion == '' && isset($featProms[0]) && $featProms[0].id_nws != ''}
    <div id="featProms-properties">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-title">{$lng_promociones_destacadas}</h2>
                </div>
                <div class="col-md-12 px-md-0">

                    <div class="slides">
                        {section name=ft loop=$featProms}
                            {include file="file:modules/promociones/view/partials/noticia.tpl" resource=$featProms[ft]}
                        {/section}
                    </div>

                </div>
            </div>
            <div class="text-center mt-5 mb-5">
                <a href="{$urlStart}{$url_promociones}/" class="btn btn-primary">{$lng_ver_todas_las_promociones}</a>
            </div>
        </div>
    </div>
    {/if}

    {* @group SEC - ÚLTIMAS NOTICIAS *}

    {if $seccion == '' && $actNoticias == 1 }

        {if isset($lastNews[0]) && $lastNews[0].id_nws != '' }
        <div id="last-news">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="main-title">{$lng_ultimas} {$lng_noticias}</h2>
                    </div>
                </div>
                <div class="row">
                    {section name=ln loop=$lastNews}
                        {include file="partials/last-news.tpl" resource=$lastNews[ln]}
                    {/section}
                </div>
                <div class="text-center mt-3 mb-5">
                    <a href="{$urlStart}{$url_news}/" class="btn btn-primary">{$lng_ver_todas_las_noticias}</a>
                </div>
            </div>
        </div>
        {/if}

    {/if}

    {* @group SEC - TESTIMONIALS *}

    {if $actTestimonials == 1}
    {if $seccion == '' && isset($lastTestimonials[0]) && $lastTestimonials[0].id_nws != ''}
        <div id="testimonials-home" class="d-flex flex-column justify-content-between">

    <!-- SVG arriba izquierda -->
    <div class="svg-top">
        <svg xmlns="http://www.w3.org/2000/svg" width="120.715" height="112.294" viewBox="0 0 120.715 112.294">
            <path d="M-4.572-132.762-34.431-71.1l-9.087 1.3a13.9 13.9 0 0 1 5.193-7.465q3.895-2.921 10.386-2.921a24.756 24.756 0 0 1 17.2 6.816q7.465 6.816 7.465 17.85a25.14 25.14 0 0 1-8.114 18.824 26.733 26.733 0 0 1-19.148 7.789 24.909 24.909 0 0 1-18.175-7.789A25.646 25.646 0 0 1-56.5-55.519a53 53 0 0 1 1.3-10.71 91.294 91.294 0 0 1 5.84-16.552l29.21-58.419zm67.489 0L33.058-71.1l-9.087 1.3a13.9 13.9 0 0 1 5.193-7.465q3.895-2.921 10.386-2.921a24.756 24.756 0 0 1 17.2 6.816q7.465 6.816 7.465 17.85A25.14 25.14 0 0 1 56.1-36.695a26.733 26.733 0 0 1-19.148 7.789 24.909 24.909 0 0 1-18.175-7.789 25.646 25.646 0 0 1-7.789-18.824 53 53 0 0 1 1.3-10.71 91.293 91.293 0 0 1 5.842-16.552L47.338-141.2z" transform="translate(56.5 141.2)" style="fill:#0e2946"/>
        </svg>
    </div>

    <!-- CONTENIDO CENTRADO -->
    <div class="container flex-grow-1 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <div class="d-flex flex-column align-items-center justify-content-center text-center">
                    <h2 class="main-title">{$lng_testimonials_title}</h2>
                    <h3 class="main-title">{$lng_testimonials_subtitle}</h3>
                </div>

                <div class="wrapper-text">
                    <div class="slides">
                        {section name=ln loop=$lastTestimonials}
                            <div>{include file="partials/last-testimonials.tpl" resource=$lastTestimonials[ln]}</div>
                        {/section}
                    </div>
                </div>

                <div class="text-center mt-60">
                    <a href="{$urlStart}{$url_testimonials}/" class="btn-testimonials">{$lng_see_all_testimonials}</a>
                </div>

            </div>
        </div>
    </div>

    <!-- SVG abajo derecha -->
    <div class="svg-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" width="120.715" height="112.294" viewBox="0 0 120.715 112.294">
            <path d="M-4.572-132.762-34.431-71.1l-9.087 1.3a13.9 13.9 0 0 1 5.193-7.465q3.895-2.921 10.386-2.921a24.756 24.756 0 0 1 17.2 6.816q7.465 6.816 7.465 17.85a25.14 25.14 0 0 1-8.114 18.824 26.733 26.733 0 0 1-19.148 7.789 24.909 24.909 0 0 1-18.175-7.789A25.646 25.646 0 0 1-56.5-55.519a53 53 0 0 1 1.3-10.71 91.294 91.294 0 0 1 5.84-16.552l29.21-58.419zm67.489 0L33.058-71.1l-9.087 1.3a13.9 13.9 0 0 1 5.193-7.465q3.895-2.921 10.386-2.921a24.756 24.756 0 0 1 17.2 6.816q7.465 6.816 7.465 17.85A25.14 25.14 0 0 1 56.1-36.695a26.733 26.733 0 0 1-19.148 7.789 24.909 24.909 0 0 1-18.175-7.789 25.646 25.646 0 0 1-7.789-18.824 53 53 0 0 1 1.3-10.71 91.293 91.293 0 0 1 5.842-16.552L47.338-141.2z" transform="translate(56.5 141.2)" style="fill:#0e2946"/>
        </svg>
    </div>

</div>
    {/if}
    {/if}

    {* @group SEC - NEWSLETTER *}

    {if $actMailchimp == 1}
        {if $seccion == ''}
        <div class="newsletter bg-primary">
            <div class="container">
                <div class="col-md-6 offset-md-3">
                    {include file="modules/acumbamail/views/newsletter.tpl"}
                </div>
            </div>
        </div>
        {/if}
    {/if}

    {* @group SEC - TEXTO INICIO *}
    {if $seccion == '' && $home != ''}
    <div class="home-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {* <h1>{$tituloland}</h1> *}
                    {$home}
                    <p><a href="{$urlStart}{$url_about_us}/" class="btn btn-primary">{$lng_mas_informacion}</a></p>
                </div>
            </div>
        </div>
    </div>
    {/if}

    {* @group SEC - CONTACT FOOTER *}
    {if $seccion == ''}
    <div id="contact-foot">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-form">
                        <h3 class="main-title">{$lng_contacte}</h3>
                        {include file="partials/contact-foot.tpl"}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-map">
                        <h3 class="main-title">{$lng_donde_estamos}</h3>
                        <div class="gmap">
                            {if $isInsights == false}
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25060.473825226298!2d-0.7071917018632411!3d38.26652759905468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd63b42c4ece57a3%3A0xd9a5de7c6be724dd!2sElche%2C+Alicante!5e0!3m2!1ses!2ses!4v1484728130749" frameborder="0" allowfullscreen></iframe>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/if}


    {* @group SEC - FOOTER *}
    <div id="footer">
        <div class="container text-center text-lg-start">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img class="mb-4" src="/media/images/website//website-logo.png" alt="{$nombreEmpresa}" title="{$nombreEmpresa}">

                    <div class="py-3">
                        {include file="partials/bottom-social.tpl"}
                    </div>

                </div>
                <div class="col-lg-4 mb-lg-0 mb-4">
                    <h4 class="custom-title mb-4 text-white">Menu</h4>
                    <ul class="ps-0">
                        {include file="partials/menu.tpl" submenu=1 seccmen=ft}
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="contact-detail">
                        <h4 class="mb-4 custom-title text-white">{$lng_contacte}</h4>
                       <p><span>{$lng_telefono}: </span>
                       <a href="tel:{$telefonoEmpresa|replace:" ":""}">{$telefonoEmpresa}</a>
                       </p>


                       <p><span>E-Mail: </span> <a href="mailto:{$correoEmpresa}">{$correoEmpresa}</a> </p>
                       <p><span>{$lng_direccion}: </span> <a class="no-decoration">{$direccionEmpresa}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="footer-second">
        <div class="container px-lg-4 px-5">
            <div class="row g-lg-4 g-0">
                <div class="col-lg-9">
                    <p>© {$smarty.now|date_format:"%Y"} {$nombreEmpresa} · <a href="{$urlStart}{$url_legal_note}/" rel="nofollow">{$lng_nota_legal}</a> · <a href="{$urlStart}{$url_privacy}/" rel="nofollow">{$lng_privacidad}</a> · <a href="{$urlStart}cookies/" rel="nofollow">{$lng_cookies}</a> · <a href="{$urlStart}{$url_sitemap}/" {if $seccion == {$url_sitemap}}rel="canonical"{/if}>{$lng_mapa_web}</a></p>
                </div>
                <div class="col-lg-3 text-lg-right">
                    <p>{$lng_diseno} &amp; CRM: <a href="https://mediaelx.net" target="_blank" rel="nofollow">Mediaelx</a> </p>
                </div>
            </div>
        </div>
    </div>


    {* @group SEC - QUICKLINKS LINKS DESTACADOS *}

    {if $actQuicklinks == 1 && isset($quicklinks[0]) && {$quicklinks[0].titulo} != ''}
    <div class="quicklinks-links">
        <div class="container">
            <div class="row">
                {section name=ln loop=$quicklinks}
                <div class="col-md-6 text-center"><a href="{$urlStart}{$quicklinks[ln].titulo|slug}.html">{$quicklinks[ln].titulo}</a></div>
                {/section}
            </div>
        </div>
    </div>
    {/if}

    {* @group SEC - QUICKLINKS LINKS *}

    {if $actQuicklinks == 1 && isset($quicklinksdest[0].titulo) && {$quicklinksdest[0].titulo} != ''}
    <div class="quicklinks-links">
        <div class="container">
            <div class="row">
                {section name=ln loop=$quicklinksdest}
                <div class="col-md-6 text-center"><a href="{$urlStart}{$quicklinksdest[ln].titulo|slug}.html">{$quicklinksdest[ln].titulo}</a></div>
                {/section}
            </div>
        </div>
    </div>
    {/if}

    {* @group SEC - LANDINGS LINKS *}

    {if $actLanding == 1 && isset($langingPages[0].titulo) && {$langingPages[0].titulo} != ''}
    <div class="landings-links">
        <div class="container">
            <div class="row">
                {section name=ln loop=$langingPages}
                <div class="col-md-6 text-center"><a href="{$urlStart}{$langingPages[ln].titulo|slug}.html">{$langingPages[ln].titulo}</a></div>
                {/section}
            </div>
        </div>
    </div>
    {/if}


    {* @group SEC - MODAL SEARCH *}
    {if $actBuscadorHeader == 1}
    {include file="partials/modal-search.tpl"}
    {/if}   

    {* @group SEC - MODAL VISITA VIRTUAL *}
    {if $actOnlineViewings == 1}
    {include file="partials/modal-online-viewings.tpl"}
    {/if}

    {* @group SEC - BARRA RESPONSIVA *}
    {include file="partials/barra-responsiva.tpl"}

<!-- JS
  ================================================== -->
{if $isInsights != true}
{* @group JS - JQUERY *}

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write(unescape('%3Cscript src="/js/source/jquery-1.10.2.js"%3E%3C/script%3E'))</script>

{* @group JS - SELECT2 *}

{if $navegador=='Internet Explorer'}
	<script src="/js/select2/dist/js/select2.full.ie.{getFileTime('js/select2/dist/js/select2.full.ie.js')}.js"></script>
{else}
	<script src="/js/select2/dist/js/select2.full.min.{getFileTime('js/select2/dist/js/select2.full.min.js')}.js"></script>
{/if}
{assign var="urljs" value="js/select2/dist/js/i18n/{$lang}.js"}
<script src="/js/select2/dist/js/i18n/{$lang}.{getFileTime($urljs)}.js"></script>
{/if}

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
    var cookieTxt = '{$lng_cookietxt|escape:"quotes"}';
    var cookieTxt2 = '{$lng_cookietxt2|escape:"quotes"}';
    var cookieTxt3 = '{$lng_cookietxt3|escape:"quotes"}';
    var cookieTxt4 = '{$lng_cookietxt4|escape:"quotes"}';
    var cookieTxt5 = '{$lng_cookietxt5|escape:"quotes"}';
    var cookieTxt6 = '{$lng_cookietxt6|escape:"quotes"}';
    var cookieTxt7 = '{$lng_cookietxt7|escape:"quotes"}';
    var cookieTxt8 = '{$lng_cookietxt8|escape:"quotes"}';
    var cookieTxt9 = '{$lng_cookietxt9|escape:"quotes"}';
    var cookieURL = '{$urlStart}cookies/';
    var todotxt = '{$lng_todo|escape:"quotes"}';
    var delallfavs = '{$lng_seguro_que_desea_eliminar_todos_los_favoritos|escape:"quotes"}';
    var opcionSimilares = {$opcionSimilares};
    var copiado = '{$lng_url_copied_to_clipboard}';
    var okSearch = '{$lng_the_search_has_been_successfully_saved|escape:"quotes"}'; // BUSQUEDAS
    var delSearch = '{$lng_are_you_sure_you_want_to_delete_the_search|escape:"quotes"}'; // BUSQUEDAS
</script>

{* @group JS - PLUGINS JS *}
{if $isInsights != true}
<script src="/js/plugins.{getFileTime('js/plugins.js')}.js"></script>
{/if}

{* @group JS - IDIOMA VALIDACIÓN *}

{if $lang != 'en'}
{assign var="urljs" value="js/source/jquery.validate.messages.{$lang}.js"}
<script src="/js/source/jquery.validate.messages.{$lang}.{getFileTime($urljs)}.js"></script>
{/if}

{* @group JS - PRECIOS *}

{assign var="prDesd" value=$lng_precio_desde}
{assign var="prHast" value=$lng_precio_hasta}

{if $seccion == $url_advanced_search}
    {assign var="prDesd" value=$lng_todos}
    {assign var="prHast" value=$lng_todos}
{/if}

<script>
$('#st, #st1').change(function (e) {
    if( Array.isArray( $(this).val() ) ){
        var $rental = ($.inArray('3',$(this).val()) != -1 || $.inArray('4',$(this).val()) != -1 ) ? 1: 0, // RENTAL
            $resale = ($.inArray('1',$(this).val()) != -1 || $.inArray('2',$(this).val()) != -1) ? 1: 0; // SALE
    } else {
        var $rental = ($(this).val() == 3 || $(this).val() == 4 ) ? 1: 0, // RENTAL
            $resale = ($(this).val() == 1 || $(this).val() == 2) ? 1: 0; // SALE
    }
    $('#prds, #prds1').html(returnPrices($('.prds').val(), $rental, $resale, '{$prDesd|escape:"quotes"}', 0)).change();
    $('#prhs, #prhs1').html(returnPrices($('.prhs').val(), $rental, $resale, '{$prHast|escape:"quotes"}', 1)).change();
}).change();


var idprop = '{if isset($property[0])}{$property[0].id_prop}{/if}';

</script>

{* @group JS - MWEBSITE JS *}

{if $isInsights != true}
<script src="/js/website.{getFileTime('js/website.js')}.js"></script>

{/if}
{* @group JS - MAPA PROPIEDAD *}

{if $seccion == {$url_properties}}
{include file="file:modules/properties/view/partials/modal-search.tpl" }
<script>
    $('#sendSearchForm').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/properties/search.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#sendSearchForm input[type=text], #sendSearchForm textarea').val('');
                    $('#sendSearchForm input[type=checkbox]').removeAttr('checked');
                    $('#sendSearchForm .loading').remove();
                    swal('', okConsult, 'success');
                    $('#searchPureModal .close').click();

                }else{
                    alert(data);
                    $('#sendSearchForm .loading').remove();
                }

            });

        }

    });
</script>
{/if}
{* @group JS - MAPA PROPIEDAD *}

{if $seccion == {$url_property}}
    <script src="/js/source/fullcalendar.min.{getFileTime('js/source/fullcalendar.min.js')}.js"></script>
    {if $lang != 'en'}
    {assign var="urljs" value="js/source/fullcalendar-lang/{$lang}.js"}
    <script src="/js/source/fullcalendar-lang/{$lang}.{getFileTime($urljs)}.js"></script>
    {/if}
	<script>
	!function ($) {
            {if $property[0].zoom > 0}
                showMapProperty('gmap', [{$property[0].lat}], {$property[0].zoom - 3});
            {else}
                showMapProperty('gmap', [{$property[0].lat}], 13);
            {/if}
        $(document).on('shown.bs.collapse', function(){
            showMapProperty('gmap', [{$property[0].lat}], {$property[0].zoom - 3});
        });
	}(window.jQuery);
	</script>

    {include file="file:modules/property/view/partials/modal-amigos.tpl" }
    {include file="file:modules/property/view/partials/modal-bajada.tpl" }
    {include file="file:modules/property/view/partials/modal-similares.tpl" }
    {include file="file:modules/property/view/partials/modal-similares-bajada.tpl" }
{/if}

{* @group JS - FAVORITOS *}

{if $seccion == $url_favorites}
    {include file="file:modules/favorites/view/partials/modal-send.tpl" }
{/if}

{* @group JS - REPORTE *}

{if $seccion == 'reporte'}
<script src="/js/source/highstock/highstock.{getFileTime('js/source/highstock/highstock.js')}.js"></script>
<script>
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
            {if $lang_adm  != 'en'}
            ,lang: {
              months: [{$lng_nombremeses}],
              shortMonths: [{$lng_nombremesescortos}],
              weekdays: [{$lng_nombredias}]
            }
            {/if}
        });
        showChart('#chart-container', '{$lng_visiualizaciones}', { showInLegend: false,name: '{$lng_visiualizaciones}',pointInterval: 100 * 24 * 3600000,data: [{foreach from=$totalChart1 key=key item=item}{if $datesChart1[$item] != ''}{assign var="totVal" value="{$datesChart1[$item]}"}{else}{assign var="totVal" value="0"}{/if}[new Date('{$item}').getTime(), {$totVal}],{/foreach}] });
        showChart('#chart-container2', '{$lng_emails}', { showInLegend: false,name: '{$lng_emails}',pointInterval: 100 * 24 * 3600000,data: [{foreach from=$totalChart2 key=key item=item}{if $datesChart2[$item] != ''}{assign var="totVal" value="{$datesChart2[$item]}"}{else}{assign var="totVal" value="0"}{/if}[new Date('{$item}').getTime(), {$totVal}],{/foreach}] });
        showChart('#chart-container3', '{$lng_favoritos}', { showInLegend: false,name: '{$lng_favoritos}',pointInterval: 100 * 24 * 3600000,data: [{foreach from=$totalChart3 key=key item=item}{if $datesChart3[$item] != ''}{assign var="totVal" value="{$datesChart3[$item]}"}{else}{assign var="totVal" value="0"}{/if}[new Date('{$item}').getTime(), {$totVal}],{/foreach}] });
    });
</script>
{/if}

{* @group JS - MAPA DE PROPIEDADES *}
{if $actMapaPropiedades == 1 }
{if $seccion == $url_property_map}
<script>
    var idprop = '';
    var markersLocations = [
    {section name=mp loop=$listMap}
        [
            [{$listMap[mp].maplat}],{assign var="altTitle" value="{$listMap[mp].type|escape} - {$listMap[mp].sale|escape} - {$listMap[mp].area|escape} - {$listMap[mp].town|escape}"} '{if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$listMap[mp].id_img}_sm.jpg")}<img src="/media/images/properties/thumbnails/{$listMap[mp].id_img}_sm.jpg" class="img-fluid" alt="{$altTitle}" title="{$altTitle}">{else}{imagesize src="/media/images/website/no-image.png" width={$thumbnailsSizes["sm"][0]} height={$thumbnailsSizes["sm"][1]} class="img-fluid" alt="{$altTitle}" title="{$altTitle}" }{/if}',
            '{$listMap[mp].type|escape} / {$listMap[mp].area|escape} ({$listMap[mp].town|escape})',
            '{$lng_ref_|escape}: <strong>{$listMap[mp].referencia_prop|escape}',
            '{$lng_precio|escape}: <strong>{if $listMap[mp].old_precio > 0}<del style="display: inline-block; padding: 0 5px; color:var(--red); font-size: 11px; font-weight: 300;">{$listMap[mp].old_precio|number_format:0:",":"."}€</del>{/if} {if $listMap[mp].display_from_prop == 1}{$lng_from}{/if}{if {$listMap[mp].precio|number_format:0:",":"."} != 0} {$listMap[mp].precio|number_format:0:",":"."}€ {else} {$lng_consult|escape} {/if}</strong>',
            '{propURL($listMap[mp].id_prop, $lang)}',
            '{$lng_ver_propiedad|escape}'
        ],
    {/section}
    ];
    showMapProperties("mapa_propiedades", markersLocations);
</script>
{/if}
{/if}

{* @group JS - MAPAS ZONAS *}

{if isset($smarty.get.zon) && $smarty.get.zon != '' && $smarty.get.ciu == ''}
    <script>
    showMapZones('gmap', [{$zonas[0].lat_long_gp_prop}], {$zonas[0].zoom_gp_prop - 3});
    </script>
{/if}

{if isset($smarty.get.zon) && $smarty.get.zon != '' && isset($smarty.get.ciu) && $smarty.get.ciu != ''}
    <script>
    showMapZones('gmap', [{$news[0].lat_long_gp_prop}], {$zonas[0].zoom_gp_prop});
    </script>
{/if}

{if $isInsights == true}
    {include file="partials/css.insights.tpl"}
{/if}

<script>
$('.cookiebtnalert').click(function(e) {
    e.preventDefault();
    $('body').ihavecookies({
        title: cookieTxt,
        message: cookieTxt2,
        moreInfoLabel: cookieTxt3,
        acceptBtnLabel: cookieTxt4,
        advancedBtnLabel: cookieTxt5,
        cookieTypesTitle: cookieTxt6,
        fixedCookieTypeLabel: cookieTxt7,
        fixedCookieTypeDesc: cookieTxt8,
        link: cookieURL
    }, 'reinit');
});
</script>


{if $actSaveSearch == 1}




{include file="partials/modal-save.tpl"}

<script src="/js/jquery.serializejson.js"></script>

<script>
    $('.save-search').click(function(e) {
        e.preventDefault();
        {if $seccion == ''}
            var form = '#searchHomeForm';
        {else}
            var form = '#searchHomeForm';
        {/if}
        if (confirm('{$lng_you_sure_want_to_save_this_search_}')) {
            $.get('/modules/properties/save-search.php?u=' + $('#usrSS').val() + '&q=' + encodeURIComponent(JSON.stringify($(form).serializeJSON())), function(data) {
                alert(okSearch);
            });
        }
    });
    $('.sendMailSrch').change(function(e) {
        e.preventDefault();
        srch = $(this);
        checked = (srch.is(":checked") == true)?1:0;
        id = srch.data('id');
        $.get('/modules/properties/send-search.php?id=' + id + '&s=' + checked, function(data) {});
    });
    $('.btn-del-search').click(function(e) {
        e.preventDefault();
        srch = $(this);
        if (confirm(delSearch)) {
            $.get('/modules/properties/del-search.php?id=' + srch.data('id'), function(data) {
                srch.parent().parent().fadeOut('slow', function() { $(this).remove(); });
            });
        }
    });
</script>

{if isset($searchs[0].id) && $searchs[0].id != ''}
{section name=ss loop=$searchs}
<script>
    $.get("/modules/properties/total.php?{strip}{foreach from=$searchs[ss].0 item=item key=key}{if $key != 'q' && $key != 'lang' && $key != 'date' && $key != 'langx'}{if $key == 'tp' || $key == 'lopr' || $key == 'loct' || $key == 'st' || $key == 'tags'}{foreach from=$item item=type key=k}{$key}[]={$type}&{/foreach}{else}{$key}={$item}&{/if}{/if}{/foreach}{/strip}").done(function(data) {
        if (data != '') {
            $('.resultc{$searchs[ss].id} span').text(data);
        }
    });
</script>
{/section}
{/if}


{if $isLevel1 == false}
    {if $seccion == $url_properties}
    <script type="text/javascript">
        function setCookie(c_name, value, exdays) { var exdate = new Date(); exdate.setDate(exdate.getDate() + exdays); var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString())+"; path=/"; document.cookie = c_name + "=" + c_value; } function getCookie(c_name) { var i, x, y, ARRcookies = document.cookie.split(";"); for (i = 0; i < ARRcookies.length; i++) { x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("=")); y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1); x = x.replace(/^\s+|\s+$/g, ""); if (x == c_name) { return unescape(y); } } }
    </script>
        <script type="text/javascript">

            if(getCookie("newsNotice1234") != 1)
            {
                var myModal = new bootstrap.Modal(document.getElementById("saveSearchModal"), {});
                document.onreadystatechange = function ()
                {
                    myModal.show();
                    setCookie("newsNotice1234", 1, 7);
                };
            }

        </script>
    {/if}
{/if}

{if isset($smarty.get.info) && $smarty.get.info == 'search'}
<script>
    if(getCookie("newsNotice1234") != 1) {
        alert('{$lng_ahora_puedes_realizar_tus_busquedas_y_guardarlas|escape:"quotes"}');
        setCookie("newsNotice1234", 1, 7);
    }
</script>
{/if}


{/if}

{if $seccion == 'rate'}
<script>
$('.btn-ratecont').click(function(e) {
    e.preventDefault();
    var $parent = $(this).parent('.ratecont');

    if ($parent.find('.check-rate').is(':checked')) {} else {
        alert('{$lng_select_a_rating|escape}');
        return false;
    }

    $client = '{$smarty.get.id_cli}';
    $id_prop = $parent.find(".id_prop_rate").val();
    $rate = $parent.find(".check-rate:checked").val();
    $location = ($parent.find(".locationchck").is(':checked'))?1:0;
    $type = ($parent.find(".typechck").is(':checked'))?1:0;
    $price = ($parent.find(".pricechck").is(':checked'))?1:0;
    $bedrooms = ($parent.find(".bedroomschck").is(':checked'))?1:0;
    $other = ($parent.find(".otherchck").is(':checked'))?1:0;

    $.get("/modules/mail_partials/ratesave.php?id_cli=" + $client + "&id_prop=" + $id_prop + "&rate=" + $rate + "&location=" + $location + "&type=" + $type + "&price=" + $price + "&bedrooms=" + $bedrooms + "&other=" + $other, function(data) {
      if(data != '') {
          $parent.parent().html('<h2>{$lng_thank_you_for_your_review|escape}</h2><br><br><p>{$lng_we_will_adjust_your_purchase_criteria_to_offer_you_the_best_service|escape}</p>');
      }
    });

});
</script>
{/if}

<script type="text/javascript">
    $('#contactFootFormWhatsapp').submit(function (e) {
        e.preventDefault();
        if ($(this).valid()) {
              $(this).append('<div class="loading">');
              $.get("/modules/contact/send-quote-nocaptcha-whatsapp.php?" + $(this).serialize()).done(function (data) {
                    if (data == 'ok'){
                        $('#contactFootFormWhatsapp input[type=text], #contactFootFormWhatsapp textarea').val('');
                        $('#contactFootFormWhatsapp input[type=checkbox]').removeAttr('checked');
                        $('#contactFootFormWhatsapp .loading').remove();
                        $('#contactFootFormWhatsappModal').modal('hide');
                        setTimeout(function() {
                            var modalElement = document.getElementById("respuesta");
                            var modal = new bootstrap.Modal(modalElement);
                            modal.show();
                        }, 100);
                    }
              });
        }
      });
</script>

</body>
</html>


