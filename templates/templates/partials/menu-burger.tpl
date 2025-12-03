<div class="mega-menu">
    <div class="bg-color-modal d-flex">

        <!-- COLUMNA IZQUIERDA CON PADDING -->
        <div class="content-menu-burger d-flex flex-column">
            
            <!-- Logo + Botón de cierre -->
            <div class="col-12 d-none d-md-flex justify-content-between align-items-center mb-4">
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
                <div class="col-12 content-menu-burger-list mt-4 mt-md-5 pt-2">
                    <ul class="px-0 mt-4 menu-burguer">
                        {include file="partials/menu.tpl" submenu=1 seccmen=ft}
                    </ul>
                </div>
            </div>

            <!-- Información de contacto -->
            <div class="row">
                <div class="col-12 p-0">
                    <div class="contat-menu">
                        <h3 class="main-title">{$lng_contacte}</h3>
                        <p class="mt-4">Email: <a href="mailto:{$correoEmpresa}">{$correoEmpresa}</a></p>
                        
                        <div class="social-icons mt-4 pt-2">
                            <a href="https://www.facebook.com/alicantespainproperties"><img src="/media/images/website/icons/facebook.svg"/></a>
                            <a href="https://bsky.app/profile/alicantesp.bsky.social"><img src="/media/images/website/icons/blue.svg"/></a>
                            <a href="https://www.instagram.com/alicantespainproperties/"><img src="/media/images/website/icons/instagram.svg"/></a>
                            <a href="https://www.linkedin.com/company/alicante-spain-properties/"><img src="/media/images/website/icons/linkedin.svg"/></a>
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