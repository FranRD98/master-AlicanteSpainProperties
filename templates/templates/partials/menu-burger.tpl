<div class="mega-menu">
    <div class="bg-color-modal d-flex" style="height: 100vh;">

        <!-- COLUMNA IZQUIERDA CON PADDING -->
        <div class="d-flex flex-column justify-content-between" style="flex: 1; padding: 40px 80px; box-sizing: border-box;">
            
            <!-- Logo + Botón de cierre -->
            <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                <div class="logo-container">
                    <img class="brand img-fluid h-100 w-100" src="/media/images/website/website-logo.svg" alt="{$nombreEmpresa}" title="{$nombreEmpresa}">
                </div>
                
                <a href="javascript:void(0);" class="btn-menu-lateral">
                    {$lng_close} 
                    <img src="/media/images/icons/close-primary.svg" alt="Close Button"/>
                </a>
            </div>

            <!-- Menú -->
            <div class="row">
                <div class="col-xl-12">
                    <ul class="ps-0 pe-4">
                        {include file="partials/menu.tpl" submenu=1 seccmen=ft}
                    </ul>
                </div>
            </div>

            <!-- Información de contacto -->
            <div class="row">
                <div class="col-12">
                    <div class="contat-menu">
                        <h3 class="main-title">{$lng_contacte}</h3>
                        <p>Email: <a href="mailto:{$correoEmpresa}">{$correoEmpresa}</a></p>
                        
                        <div class="social-icons mt-3">
                            <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="me-3"><i class="fab fa-bluesky"></i></a>
                            <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="me-3"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- COLUMNA DERECHA - IMAGEN OCUPANDO TODO -->
        <div style="flex: 0 0 auto; width: auto; height: 100%;">
            <img src="/media/images/website/menu-image.jpg" 
                 alt="Imagen Lateral" 
                 class="img-fluid h-100" 
                 style="object-fit: cover; display: block;">
        </div>

    </div>
</div>