{* 
{if $galeriaModal == 1}
    
    {assign var="openModal" value="{$images[img].alt}"}

{/if}
 *}
<h3 class="main-title subtitle">{$lng_imagenes}</h3>

<div class="row">

  {* Si se selecciona la galería que usa un slider y queremos usar esta otra galería habrá que ajustar los start  de cada loop. Si la galería en forma de grid usa 4 fotos en lugar de las 3 del máster habrá que sumar +1 al start del section *}

    {section name=img loop=$images max=4 start=3}

        {if isset($images[img].alt) && $images[img].alt != ''}
            {assign var="altTitle" value="{$images[img].alt}"}
        {else}
            {assign var="altTitle" value="{$title}"}
        {/if}

        <div class="col-md-6 col-lg-3">

            {if $isMobile == 1}

                  <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModal" {/if} href="/media/images/properties/thumbnails/{$images[img].id_img}_lg.jpg" class="d-block mb-3 mb-lg-4 {if $galeriaModal == 0} gallProp {/if}">
                      <img src="/media/images/properties/thumbnails/{$images[img].id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                  </a>

            {else}

                  <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModal" {/if} href="/media/images/properties/thumbnails/{$images[img].id_img}_xl.jpg" class="d-block mb-3 mb-lg-4 {if $galeriaModal == 0} gallProp {/if}">
                      <img src="/media/images/properties/thumbnails/{$images[img].id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                  </a>
            {/if}

        </div>

    {/section}

</div>

{if $images[4].id_img}

<a class="btn-collapse" data-bs-toggle="collapse" href="#collapseImg" role="button" aria-expanded="false" aria-controls="collapseImg">
    {$lng_mas_informacion}
</a>

<div class="collapse" id="collapseImg">

    <div class="row">
         {section name=img loop=$images start=6}

            {if $images[img].alt != ''}
                {assign var="altTitle" value="{$images[img].alt}"}
            {else}
                {assign var="altTitle" value="{$title}"}
            {/if}

                <div class="col-md-6 col-lg-3">

                    {if $isMobile == 1}

                              <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModal" {/if} href="/media/images/properties/thumbnails/{$images[img].id_img}_lg.jpg" class="d-block mb-3 mb-lg-4 {if $galeriaModal == 0} gallProp {/if} ">
                                  <img src="/media/images/properties/thumbnails/{$images[img].id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                              </a>

                    {else}
                              <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModal" {/if}  href="/media/images/properties/thumbnails/{$images[img].id_img}_xl.jpg" class="d-block mb-3 mb-lg-4 {if $galeriaModal == 0} gallProp {/if}">
                                  <img src="/media/images/properties/thumbnails/{$images[img].id_img}_md.jpg" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">
                              </a>
                         
                    {/if}

                </div>

          {/section} 
    </div>
</div>

{/if}



 


