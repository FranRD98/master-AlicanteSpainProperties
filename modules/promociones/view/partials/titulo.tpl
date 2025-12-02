<div class="property-title">
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
            <div class="col-md-5 col-lg-2 text-center text-xl-end price-responsive my-2 my-lg-0 ms-auto me-0">
                <div class="precio">

                    {if $precioReferencia > 0}
                        <small>{$lng_from}</small> {$precioReferencia|number_format:0:",":"."}€
                    {else}
                        {$lng_consultar}
                    {/if}
                </div>
            </div>
            <div class="col-md-7 col-lg-4">
                <div class="row gx-4">
                    <div class="col-6">
                        <a class="btn btn-primary toForm2 btn-enquiry h-100 px-1">
                            {$lng_solicitar_informacion}
                        </a>
                    </div>
                    {if $actWhatsapp == 1}
                        <div class="col-6">
                            <a href="https://wa.me/{$phoneRespBar}/?text={"{$lng_estoy_interesado_en_esta_promocion}:{$news[0].titulo}"|escape:'url'}" target="_blank" class="btn btn-whats btn-img h-100 px-1">
                                <i class="fs-3 me-2 fab fa-whatsapp"></i>
                                {$lng_contactar}</a>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>