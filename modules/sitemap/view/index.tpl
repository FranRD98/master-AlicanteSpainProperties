{include file="header.tpl"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$pages[0].titulo}</h1>
                    {$pagetext}
                    <div class="row">
                        <div class="col-lg-4">
                            {* @group SEC - MAPA WEB *}
                            <h2 class="main-title">{$lng_mapa_web}</h2>
                            <ul>
                                {include file="partials/menu.tpl" submenu=0}
                            </ul>
                            {if $actQuicklinks == 1 && {$quicklinks2[0].titulo} != ''}
                                <h2 class="main-title">Quicklinks</h2>
                                <ul>
                                    {section name=nw loop=$quicklinks2}
                                        <li><a href="{$urlStart}{$quicklinks2[nw].titulo|slug}.html">{$quicklinks2[nw].titulo}</a></li>
                                    {/section}
                                </ul>
                            {/if}
                            {if $actLanding == 1 && {$langingPages2[0].titulo} != ''}
                                <ul>
                                    {section name=nw loop=$langingPages2}
                                        <li><a href="{$urlStart}{$langingPages2[nw].titulo|slug}.html">{$langingPages2[nw].titulo}</a></li>
                                    {/section}
                                </ul>
                            {/if}
                        </div>
                        <div class=" {if $actNoticias == 1} col-lg-4 {else} col-lg-8 {/if}">
                            {* @group SEC - PROPIEDADES *}
                            <h2 class="main-title">{$lng_propiedades}</h2>
                            <ul>
                                {section name=ft loop=$properties}
                                    <li><a href="{propURL($properties[ft].id_prop, $lang)}">{$lng_ref_}: {$properties[ft].ref} - {$properties[ft].type} - {$properties[ft].sale} - {$properties[ft].area} - {$properties[ft].town}</a></li>
                                {/section}
                            </ul>
                        </div>

                        {if $actNoticias == 1}

                        <div class="col-lg-4">
                            {* @group SEC - NOTICIAS *}
                            <h2 class="main-title">{$lng_noticias}</h2>
                            <ul>
                                {section name=nw loop=$news}
                                    {if {$news[nw].titulometa} != ''}
                                        <li><a href="{$urlStart}{$url_news}/{$news[nw].id_nws}/{$news[nw].titulometa|slug}/">{$news[nw].titulo}</a></li>
                                    {else}
                                        <li><a href="{$urlStart}{$url_news}/{$news[nw].id_nws}/{$news[nw].titulo|slug}/">{$news[nw].titulo}</a></li>
                                    {/if}
                                {/section}
                            </ul>
                        </div>

                        {/if}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}