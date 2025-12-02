{* @group SEC - DESACTIVADO *}
{if $property[0].activado_prop == 0}
    <div class="alert alert-danger mt-4 py-2" role="alert">

        <div class="row justify-content-center align-items-center g-4">
            <div class="col-lg-4 col-md-6">
                 {$lng_propiedad_no_disponible_pulse_aqui_para_buscar_propiedades_similares_}
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{$urlStart}{$url_properties}/" class="btn btn-danger w-100">{$lng_ver_otras_propiedades}</a>
            </div>
        </div>

    </div>
{/if}
{* @group SEC - VENDIDO *}
{if $property[0].vendido_prop == 1 || $property[0].vendido_tag_prop == 1}
    <div class="alert alert-danger mt-4 py-2" role="alert">
        <div class="row justify-content-center align-items-center g-4">
            <div class="col-lg-4 col-md-6">
                {$lng_este_inmueble_se_ha_vendido_pulse_aqui_para_buscar_propiedades_similares_}
            </div>
            <div class="col-lg-4 col-md-6">
                 <a href="{$urlStart}{$url_properties}/" class="btn btn-danger w-100">{$lng_ver_otras_propiedades}</a>
            </div>
        </div>
    </div>
{/if}
{* @group SEC - ALQUILADO *}
{if $property[0].alquilado_prop == 1}
    <div class="alert alert-danger mt-4 py-2" role="alert">
        <div class="row justify-content-center align-items-center g-4">
            <div class="col-lg-4 col-md-6">
                {$lng_este_inmueble_se_ha_alquilado_pulse_aqui_para_buscar_propiedades_similares_}
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{$urlStart}{$url_properties}/" class="btn btn-danger w-100">{$lng_ver_otras_propiedades}</a>
            </div>
        </div>
    </div>
{/if}