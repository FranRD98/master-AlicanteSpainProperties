{include file="header.tpl"}



{assign var="titulo" value={$pages[0].titulo}}
{assign var="subtitle" value=''}

{assign var="image_mov" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1280 height=600 class='' } }
{assign var="image" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1920 height=540 class='' } }

{include file="partials/banner-title.tpl" image={$image} image_mov={$image_mov} titulo={$titulo} subtitle={$subtitle} }
{* Dejo un css básico en _custom-mixins  y ya lo adapta cada uno como le venga mejor *}


<div class="container pt-5">
    <div class="row">
        <div class="col-md-12">
            {if $seccion != {$url_areas}}
                <div class="page-content">

                    {* <h1 class="main-title">{$pages[0].titulo}</h1> *}

                    {$pagetext}
                    {section name=vd loop=$videos}
                        {if $videos[vd].video_vid != ''}
                            <div class="embed-responsive embed-responsive-16by9">
                                {$videos[vd].video_vid|replace:'\"':''}
                            </div>
                        {/if}
                    {/section}
                </div>
                {if isset($teams[0]) && $teams[0].nombre != ''}
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-5"><strong>{$lng_our_team}</strong></h3>
                        </div>
                    </div>
                    <div class="row">
                        {section name=tm loop=$teams}
                            <div class="col-12 col-md-6 col-lg-3 mb-lg-4">
                                <div class="card mb-5 mb-lg-0">
                                    {if isset($teams[tm].img) && $teams[tm].img!='' }
                                        <img class="card-img-top mw-100" src="/media/images/teams/{$teams[tm].img}">
                                    {else}
                                        <img style="width: 66% !important; margin-left: 16% !important;" src="/media/images/teams/avatar.png">
                                    {/if}
                                    <div class="card-body text-center">
                                        <h5 class="mb-0">{$teams[tm].nombre}</h5>
                                        <span>{$teams[tm].cargo}</span><br>
                                        <span>{$teams[tm].bio}</span><br>
                                        <a href="tel:{$teams[tm].telefono|replace:' ':''}" class="mb-0"><i class="fa fa-phone"></i> {$teams[tm].telefono}</a><br>
                                        <a href="mailto:{$teams[tm].email}" class="mb-0"><i class="fa fa-envelope"></i> {$teams[tm].email}</a>
                                    </div>
                                    <div class="card-footer text-center text-muted p-2 p-lg-3">
                                        <ul class="list-inline m-0">
                                            {foreach from=','|explode:$teams[tm].idiomas item=idio_team}
                                                <li class="list-inline-item">
                                                    <img src="/media/images/website/flags/{$idio_team}.png">
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        {/section}
                    </div>
                {/if}
            {else}
                {* @group SEC - AREAS *}
                <div class="page-content">

                    {* <h1 class="main-title">{$pages[0].titulo}</h1> *}

                    {$pagetext}
                    <hr>
                    {section name=ft loop=$zonasmen}
                        <div class="row">
                            <div class="col-md-6">
                                {assign var="imgProp" value="/media/images/zonas/{$zonasmen[ft].img}"}
                                {imagesize src="{$imgProp}" width=600 height=300 watermark='0' class='img-fluid' alt="{$news[ft].titulo}" title="{$news[ft].titulo}" }
                            </div>
                            <div class="col-md-6">
                                <h2 style="margin-top: 0">{$zonasmen[ft].titulo}</h2>
                                <hr>
                                <p>
                                {if isset($zonasmen[ft].contenido) }
                                    {$zonasmen[ft].contenido|strip_tags|truncate:350:"..."}
                                {/if}
                                </p>
                                <hr>
                                <a href="{$urlStart}{$zonasmen[ft].titulo|slug}.html" class="btn btn-primary">{$lng_mas_informacion} <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <hr>
                    {/section}
                </div>
            {/if}
        </div>
    </div>
</div>

{include file="footer.tpl"}
