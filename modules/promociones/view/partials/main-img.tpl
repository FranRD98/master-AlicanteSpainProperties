{assign var="titulo" value={$news[0].titulo}}
{assign var="subtitle" value="{$news[0].ciudad} · {$news[0].tipo}"}

{if $news[0].alt != ''}
    {assign var="altt" value="{$news[0].alt}"}
{else}
    {assign var="altt" value="{$news[0].titulo}"}
{/if}
{if $images[0].image_img != ''}
    {assign var="imgProp" value="/media/images/news/{$news[0].img}"}
    {assign var="image_mov" value={imagesize2 src="{$imgProp}" width=1280 height=600 } }
    {assign var="image" value={imagesize2 src="{$imgProp}" width=1920 height=660 } }
{else}
    {assign var="banner" value='banner-promocion.jpg'}
    {assign var="image_mov" value={imagesize2 src="/media/images/banner/{$banner}" width=1280 height=600
    class='img-fluid
w-100' } }
    {assign var="image" value={imagesize2 src="/media/images/banner/{$banner}" width=1920 height=800 class='img-fluid
w-100'
    } }
{/if}

{if $images[0].image_img != ''}
    {if $news[0].img|regex_replace:'/https?/':'' != $news[0].img}
        {assign var=&quot;imgProp&quot; value=&quot;{$news[0].img}&quot;}
    {else}
        {assign var=&quot;imgProp&quot; value=&quot;/media/images/news/{$news[0].img}&quot;}
    {/if}
{else}
    {assign var="imgProp" value="/media/images/banner/banner-promocion.jpg"}
{/if}

<div class="header-sec main-img-promo" style="background-image: url({$imgProp});" >

    <div class="contenido-parallax text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-lg-5">
                    <h1 class="main-title my-0">
                        {if $news[0].titulo_prom != ''}
                            {$news[0].titulo_prom}
                        {else}
                            {$news[0].titulo}
                        {/if}
                        <small class="mt-3"> {$news[0].ciudad} · {$news[0].provincia}</small>
                        <span> {$similares|count} {$lng_propiedades}</span>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>