   <div class="modal fade custom-modal" tabindex="-1" role="dialog" id="galleryModal">
        <div class="modal-dialog modal-full-screen" role="document">
            <div class="modal-content">

                <div class="property-title header-modal pb-0">
                    <div class="container px-3 px-md-4">
                        <div class="row g-4 pt-0 align-items-center">

                            <div class="col-lg-4 text-start d-none d-lg-block pe-lg-0 ">
                                {* @group SEC - TITULO *}
                                {include file="file:modules/property/view/partials/titulo.tpl" }
                            </div>
                            <div class="col-10 px-0 px-md-3 col-md-11 col-lg-7 pe-lg-0">
                                
                                <div class="row align-items-center">

                                    <div class="d-none d-md-block col-12 col-md-4 text-center text-lg-end price-responsive pb-3 pb-md-0">
                                        {* @group SEC - PRECIO *}
                                        {include file="file:modules/property/view/partials/precio.tpl" }
                                    </div>
                                    <div class="col-6 col-md-4 d-grid pe-2 px-lg-2">
                                        <a href="#" data-href="/modules/property/add-fav.php?fav={$property[0].id_prop}" class="btn btn-outline-dark btn-big add-fav {if $isFav == '1'}fav-hide{/if}" title="{$lng_anadir_a_favoritos}" rel="nofollow"><span>{$lng_anadir_a_favoritos}</span></a>

                                        <a href="#" data-href="/modules/property/rem-fav.php?fav={$property[0].id_prop}" class="btn btn-outline-dark btn-big rem-fav {if $isFav == '0'}fav-hide{/if}" title="{$lng_eliminar_de_favoritos}" rel="nofollow"><span>{$lng_eliminar_de_favoritos}</span></a>
                                    </div>
                                    <div class="col-6 col-md-4 d-grid ps-2 ps-md-3 pe-lg-0" >
                                        <a class="btn btn-primary toForm btn-enquiry btn-big" data-bs-dismiss="modal" aria-label="Close">
                                             {$lng_make_an_enquiry}
                                        </a>
                                    </div>

                                </div>


                            </div>  
                            <div class="col-md-1 px-lg-2 px-0 col-2">
                                <div class="d-grid">
                                    <a  class="btn px-0 px-md-3 btn-block close  btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fal fa-times"></i>
                                    </a>
                                </div>
                            </div>     
                        </div>
                   </div>
                </div>

     

                <div class="container">

                    <div class="row justify-content-center mb-lg-2 mt-4">
                        <div class="col-lg-10 col-xl-11 px-xl-3 px-0">
                            {section name=img loop=$images}

                                {if isset($images[img].alt) && $images[img].alt != ''}
                                    {assign var="altTitle" value="{$images[img].alt}"}
                                {else}
                                    {assign var="altTitle" value="{$title}"}
                                {/if}
                                <div class="col-12 px-xl-3 px-0 pb-3">

                                    <img src="/img/{$altTitle|slug}_{$images[img].id_img}_xl.jpg?id=1.0001" class='img-fluid' alt="{$altTitle}" title="{$altTitle}">

                                </div>
                            {/section}
                        </div>
                    </div>

                    <div class="row justify-content-center pb-5">
                        <div class="col-2 text-center">
                            <a type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
