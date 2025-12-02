{include file="header.tpl"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$pages[0].titulo}</h1>
                    {$pagetext}
                </div>
            </div>
        </div>
    </div>
</div>


<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div class="buscador d-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {include file="partials/buscador.tpl"}
            </div>
        </div>
    </div>
</div>

{* @group SEC - DESTACADOS *}
{if $featured[0].id_prop != ''}
<div id="featured-properties">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{$lng_property_of_the_month}</h2>
                <div class="slides">
                    {section name=ft loop=$featured}
                        {include file="partials/slider-properties.tpl" resource=$featured[ft]}
                    {/section}
                </div>
            </div>
        </div>
        <div class="text-center mt-5 mb-5">
            <a href="{$urlStart}{$url_properties}/" class="btn btn-primary btn-lg">{$lng_ver_todas_las_propiedades}</a>
        </div>
    </div>
</div>
{/if}

{include file="footer.tpl"}
