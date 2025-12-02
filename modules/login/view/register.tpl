{include file="header.tpl"}


<div class="page-content my-5 py-5">

    <div class="container">
        <div class="row g-0">

            <div class="col-lg-6 px-4">
                
                <h1>{$lng_registrate}</h1>
                {$pagetext}

            </div>
            <div class="col-lg-6 custom-form bg-light pb-3">
                
                {$error1}

                {if isset($smarty.get.info) && $smarty.get.info == 'REGISTER'}
                <div class="alert alert-success fadeIn" role="alert">
                    <strong>{$lng_registro_completo}</strong> <br> {$lng_accede_al_area_privado_con_tus_datos_de_acceso}.
                </div>
                {/if}

                {include file="file:modules/login/view/partials/register-form.tpl"}

            </div>

        </div>
    </div>

</div>




{include file="footer.tpl"}