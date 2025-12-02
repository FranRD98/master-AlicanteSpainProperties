<h3 class="main-title">{$lng_photos}</h3>

<div class="row">

    {section name=img loop=$images start=1 max=4}

        {if $images[img].alt != ''}
            {assign var="altTitle" value="{$images[img].alt}"}
        {else}
            {assign var="altTitle" value="{$title}"}
        {/if}

        {if $images[img].image_img|regex_replace:'/https?/':'' != $images[img].image_img}
            {assign var="linkImgSrc" value="{imagesize2 src="{$images[img].image_img}" width=1200 height=800 class="" path="/media/images/news/"}"}
            {assign var="linkImg" value="{$images[img].image_img}"}
        {else}
            {assign var="linkImgSrc" value="https://{$smarty.server.HTTP_HOST}/{imagesize2 src="/media/images/news/{$images[img].image_img}" width=1200 height=800 path="/media/images/news/" }"}
            {assign var="linkImg" value="/media/images/news/{$images[img].image_img}" }
        {/if}

        <div class="col-md-4 col-lg-3">
            <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModalPromo" {/if}
                href="{$linkImgSrc}"
                class="mb-3 mb-md-4 {if $galeriaModal == 0} gallProp {/if}  d-inline-block">
                {imagesize src="{$linkImg}" width=410 height=230 class='img-fluid' alt="{$altTitle}"
                title="{$altTitle}"  path='/media/images/news/'}
            </a>
        </div>

    {/section}


</div>

{if $images[3].image_img}
    <a class="btn-collapse" data-bs-toggle="collapse" href="#collapseImg" role="button" aria-expanded="false"
        aria-controls="collapseImg">
        {$lng_more_info}<span class="btn-button ms-3 text-primary"></span>
    </a>

    <div class="collapse mt-3 mt-lg-4" id="collapseImg">

        <div class="row">
            {section name=img loop=$images start=3}

                {if $images[img].image_img|regex_replace:'/https?/':'' != $images[img].image_img}
                    {assign var="linkImgSrc" value="{imagesize2 src="{$images[img].image_img}" width=1200 height=800 class="" path="/media/images/news/"}"}
                    {assign var="linkImg" value="{$images[img].image_img}"}
                {else}
                    {assign var="linkImgSrc" value="https://{$smarty.server.HTTP_HOST}/{imagesize2 src="/media/images/news/{$images[img].image_img}" width=1200 height=800 path="/media/images/news/" }"}
                    {assign var="linkImg" value="/media/images/news/{$images[img].image_img}" }
                {/if}

                <div class="col-md-4 col-lg-3">
                    <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModalPromo" {/if}
                        href="{$linkImgSrc}"
                        class="mb-3 mb-md-4 {if $galeriaModal == 0} gallProp {/if}  d-inline-block">
                        {imagesize src="{$linkImg}" width=410 height=230 class='img-fluid' alt="{$altTitle}"
                        title="{$altTitle}"  path='/media/images/news/'}
                    </a>
                </div>

            {/section}
        </div>
    </div>
{/if}