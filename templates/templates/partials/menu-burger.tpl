<div class="mega-menu">    
    <div class="bg-color-modal">
        <div class="container">
            <div class="row">
                
                <!-- COLUMNA IZQUIERDA -->
                <div class="col-lg-8 col-xl-9">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo-container">
                            <img class="brand img-fluid h-100 w-100" src="/media/images/website/website-logo.svg" alt="{$nombreEmpresa}" title="{$nombreEmpresa}">
                        </div>
                        
                        <a href="javascript:void(0);" class="btn-sidebar-cerrar">
                        Cerrar
                            <i class="fal fa-times"></i> 
                            {* {$lng_close} *}
                        </a>
                    </div>

                    <!-- Menú de dos columnas -->
                    <div class="row">
                        <div class="col-xl-12">
                            <ul class="ps-0 pe-4">
                                {include file="partials/menu.tpl" submenu=1 seccmen=ft}
                            </ul>
                        </div>
                    </div>

                    <!-- Información de contacto -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="contat-menu p-3">
                                <h3 class="main-title">{$lng_contacte}</h3>
                                <p><a href="tel:{$telefonoEmpresa}">{$telefonoEmpresa}</a></p>
                                <p><a href="mailto:{$correoEmpresa}">{$correoEmpresa}</a></p>
                                
                                <!-- Iconos sociales (añade según necesites) -->
                                <div class="social-icons mt-3">
                                    <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                                    <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="me-3"><i class="fab fa-linkedin"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA - IMAGEN -->
                <div class="col-lg-4 col-xl-3">
                    <div class="h-100">
                        <img src="/media/images/website/menu-image.jpg" 
                             alt="Imagen Lateral" 
                             class="img-fluid h-100 w-100 object-fit-cover">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>