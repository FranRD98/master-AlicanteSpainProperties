{include file="header.tpl"}

{assign var="titulo" value={$pages[0].titulo}}
{assign var="subtitle" value=''}

{assign var="image_mov" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1280 height=600 class='' } }
{assign var="image" value={imagesize2 src="/media/images/banner/banner_1.jpg" width=1920 height=540 class='' } }

{include file="partials/banner-title.tpl" image={$image} image_mov={$image_mov} titulo={$titulo} subtitle={$subtitle} }
{* Dejo un css básico en _custom-mixins  y ya lo adapta cada uno como le venga mejor *}



<div class="page-content pt-5">
    <div class="container">
        

        <div class="row">
            <div class="col-lg-12">
                <div class="page-content page-testimonials">
                    {if isset($news[0].titulo) && $news[0].titulo != ''}
                        {* @group SEC - NOTICIAS *}
                        <div class="row">
                            {section name=nw loop=$news}
                                <div class="col-lg-6">
                                    {include file="file:modules/testimonials/view/partials/noticia.tpl" resource=$news[nw]}
                                </div>
                            {/section}
                        </div>
                        {* @group SEC - PAGINACIÓN *}
                        <div class="pagination justify-content-center">
                            {include file="file:modules/properties/view/partials/pagination.tpl"}
                        </div>

                    {else}
                        <br>
                        <br>
                        <br>
                        <p class="lead text-center">{$lng_no_se_han_encontrado_noticias_en_esta_categoria_}</p>
                        <br>
                        <br>
                        <br>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-content">
                {$pagetext}
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}