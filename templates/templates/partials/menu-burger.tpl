<div class="mega-menu">    
    <div class="bg-color-modal">
        <div class="container px-0">
            <a href="javascript:void(0);" class="btn-menu-lateral btn mb-xxl-5 mb-4 mt-2">
                <i class="fal fa-times"></i> 
                {* {$lng_close} *}
            </a>

            <div class="row">
                <div class="col-xl-12">

                    <ul class="ps-0 pe-4">
                        {include file="partials/menu.tpl" submenu=1 seccmen=ft}
                    </ul>

                </div>

                <div class="col-12">
                    <div class="contat-menu p-3">
                        <h3 class="main-title">{$lng_contacte}</h3>
                        <p><a href="tel:{$telefonoEmpresa}">{$telefonoEmpresa}</a></p>
                        <p><a href="mailto:{$correoEmpresa}">{$correoEmpresa}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>