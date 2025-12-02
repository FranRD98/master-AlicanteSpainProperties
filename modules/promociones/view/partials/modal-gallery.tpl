<div class="modal fade custom-modal" tabindex="-1" role="dialog" id="galleryModalPromo">
    <div class="modal-dialog modal-full-screen" role="document">
        <div class="modal-content">

            <div class="property-title header-modal pb-0 border-0">
                <div class="container">
                    <div class="row pt-0 align-items-center">
                        <div class="col-lg-5 text-start d-none d-lg-block ps-lg-3 mt-lg-1">
                            <h2 class="main-title">
                                <span class="text-muted">
                                    {if $news[0].titulo_prom != ''}
                                        <span>{$news[0].titulo_prom}</span>
                                    {else}
                                        <span>{$news[0].titulo}</span>
                                    {/if}
                                </span>

                                <small>
                                    {$news[0].ciudad} · {$news[0].provincia}
                                </small>
                            </h2>
                        </div>
                        <div
                            class="col-md-4 col-lg-2 text-center text-xl-end price-responsive d-none d-md-inline my-2 my-lg-0 ms-auto me-0">
                            <div class="precio">

                                {if $news[0].quick_price_from_nws !=''}
                                    <small>{$lng_from}</small> {$news[0].quick_price_from_nws|number_format:0:",":"."}€
                                {else if $precioReferencia == 0}
                                    {$lng_consultar}
                                {else}
                                    <small>{$lng_from}</small> {$precioReferencia|number_format:0:",":"."}€
                                {/if}
                            </div>
                        </div>
                        <div class="col-10 col-md-7 col-lg-4">
                            <div class="row gx-4">
                                <div class="col-6">
                                    <a class="btn btn-primary toForm2 btn-enquiry h-100 px-1">
                                        {$lng_solicitar_informacion}
                                    </a>
                                </div>
                                {if $actWhatsapp == 1}
                                    <div class="col-6">
                                        <a href="https://wa.me/{$phoneRespBar}/?text={"{$lng_estoy_interesado_en_esta_promocion}:{$news[0].titulo}"|escape:'url'}" target="_blank" class="btn btn-whats btn-img h-100  px-1">
                                            <i class="fs-3 me-2 fab fa-whatsapp"></i>
                                            {$lng_contactar}</a>
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="col-2 col-md-1 px-0 px-lg-2">
                            <div class="d-grid">
                                <a class="btn px-0 btn-block close btn-close-modal justify-content-center"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <img src="/media/images/website/properties/icon-close.svg" alt="Close">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">

                <div class="row justify-content-center mb-lg-2 mt-2">
                    <div class="col-lg-10">
                        {section name=img loop=$images}

                            {if $images[img].alt != ''}
                                {assign var="altTitle" value="{$images[img].alt}"}
                            {else}
                                {assign var="altTitle" value="{$title}"}
                            {/if}
                            <div class="col-12 pb-3 pb-xl-4 px-xl-2">
                                {if $images[img].image_img|regex_replace:'/https?/':'' != $images[img].image_img}
                                    <img src="{$images[img].image_img}" class='img-fluid w-100' alt="{$altTitle}" title="{$altTitle}">
                                {else}
                                    <img src="/media/images/news/{$images[img].image_img}" class='img-fluid w-100' alt="{$altTitle}" title="{$altTitle}">
                                {/if}

                            </div>
                        {/section}
                    </div>
                </div>

                <div class="row justify-content-center pb-5">
                    <div class="col-2 text-center">
                        <a type="button" class="close btn btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <img src="/media/images/website/properties/icon-close-dark.svg" alt="Close" title="Close">
                            <span class="ms-2">{$lng_close}</span>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>