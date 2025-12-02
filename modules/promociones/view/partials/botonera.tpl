<div class="botonera pb-lg-5">
    <div class="row">
        <div class="col-6 col-md-3 col-xl-2">
            <div class="d-grid">

                <a href="#" class="btn btn-white" class="dropdown-toggle" role="button" data-bs-toggle="dropdown"
                    id="dropdownRedes" aria-haspopup="true" aria-expanded="false">
                    <img class="me-2" src="/media/images/website/properties/share.svg" alt="{$lng_share}"
                        title="{$lng_share}">
                    {$lng_share}
                </a>

                <ul class="dropdown-menu animated fadeIn bg-light-blue" aria-labelledby="dropdownRedes" style="">

                    <li class="dropdown-item social-links bg-white text-secondary">
                        <a class="facebook"
                            href="https://www.facebook.com/sharer/sharer.php?u=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
                            target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="twitter"
                            href="https://www.twitter.com/share?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
                            target="_blank">
                            <svg style="max-height: 20px; margin-bottom:2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z">
                                </path>
                            </svg>
                        </a>

                        <a class="linkedin"
                            href="https://www.linkedin.com/shareArticle?mini=true&url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&title=&summary=&source="
                            target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a>

                        <a class="btn-whatsapp-property"
                            href="https://api.whatsapp.com/send?text=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
                            target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                        <a class="telegram"
                            href="https://telegram.me/share/url?url={$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
                            target="_blank">
                            <i class="fab fa-telegram-plane"></i>
                        </a>

                        <a class="friend"
                            href="mailto:?subject={$metaTitle}&body={$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
                            target="_blank">
                            <i class="fal fa-envelope"></i>
                        </a>
                        <a class="link" href="javascript:getlink();"><i class="fal fa-link"></i></a>
                    </li>
                </ul>
            </div>
        </div>

        {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/news/{$images[0].image_img}")}
            <div class="col-6 col-md-3 col-xl-2">
                <div class="d-grid">
                    <a {if $galeriaModal == 1} data-bs-toggle="modal" data-bs-target="#galleryModalPromo" {/if}
                        href="http://{$smarty.server.HTTP_HOST}/media/images/news/{$images[0].image_img}"
                        class="btn btn-secondary {if $galeriaModal == 0} gallProp {/if}">
                        {$lng_view_all_photos}
                    </a>
                </div>
            </div>
        {/if}

        <div class="col-6 col-md-3 col-xl-2">
            <div class="d-grid">
                <a href="/modules/promociones/pdf.php?p={$news[0].id_nws}&lang={$lang}" target="_blank" class="btn btn-secondary" rel="nofollow">{$lng_pdfimprimir}</a>
            </div>
        </div>

        <div class="col-6 col-md-3 col-xl-2 ms-auto me-md-0">
            <div class="d-grid">
                <a href="{$smarty.server.HTTP_REFERER}" class="btn btn-back justify-content-end pe-0">
                    <i class="fa fa-caret-left text-primary me-4 pe-lg-1"></i>{$lng_volver}
                </a>
            </div>
        </div>
    </div>
</div>