{include file="header.tpl"}

{* @group SEC - TITULO *}

<div class="page-content pt-4 pt-lg-5">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="page-content">
                    <h1 class="main-title">
                        {$lng_favoritos}
                        <small class="custom-title">{$lng_se_han_encontrado} <span class="num-props">{$totalprops|number_format:0:",":"."}</span> {$lng_propiedades}</small>
                    </h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="page-content mb-0">
                        <div class="row g-3 justify-content-center pb-4">
                            <div class="col-md-6 col-lg-3">
                                <a href="/modules/property/rem-fav-all.php" class="btn btn-outline-danger btn-rem-all-favs mb-2 d-block w-100">{$lng_eliminar_todos_los_favoritos}</a>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <a href="/" class="btn btn-primary btn-send-props mb-2 d-block w-100" data-bs-toggle="modal" data-bs-target="#favoritesPureModal">{$lng_enviar_propiedades}</a>                      
                            </div>
                        </div>
                        {$pagetext}
                </div>
            </div>
        </div>
    </div>
</div>

{include file="file:modules/properties/view/layouts/layout-1-col.tpl" proparray=$properties numberprops=3 showshor=0 favdos=2 hidesearch=1}


{include file="footer.tpl"}
