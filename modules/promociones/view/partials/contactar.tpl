<div class="mb-4 mb-lg-5">

    <form action="#" id="requestInfoForm2" method="post" class="prop-contact validate row">
        <h3 class="main-title lastword mt-0 mb-4 pb-xl-2">{$lng_make_an_enquiry}</h3>

        {if $actWhatsapp == 1}
            <div class="d-grid mb-3">
                <a target="_blank"
                    href="https://api.whatsapp.com/send?phone={$phoneRespBar}&text={"{$lng_estoy_interesado_en_esta_propiedad}: {$property[0].ref}"|escape:'url'}" class="btn btn-whats" target="_blank">
                    <i class="fab fa-whatsapp fs-2 me-3"></i>
                    {$lng_contactar_por_whatsapp}</a>
            </div>
            <p class="text-center mb-3">{$lng_or_by_email}</p>
        {/if}

        <input type="hidden" name="motivo" value="{$lng_quiero_mas_informacion_sobre_esta_promocion_}">
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm required" name="name" id="name"
                placeholder="{$lng_nombre}*">
        </div>
        <div class="mb-3 col-md-6">
            <input type="text" class="form-control form-control-sm required email" name="email" id="email"
                placeholder="{$lng_email}*">
        </div>
        <div class="mb-3 col-md-6">
            <input type="text" class="form-control form-control-sm " name="phone" id="phone"
                placeholder="{$lng_telefono}">
        </div>
        <div class="mb-3">
            <textarea name="comment" id="comment" class="form-control form-control-sm required pt-2" rows="1"
                placeholder="{$lng_estoy_interesado_en_esta_propiedad}*"></textarea>
        </div>
        <div>
            <label class="checkcontainer mb-4">
                <span
                    class="tag-name">{assign var="urlPPRV" value=sprintf('<a href="%s%s/" target="_blank">', {$urlStart},
                    {$url_privacy})}
                    {$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:'</a>'}*
                </span>
                <input type="checkbox" name="lpd" id="lpd" class="required" />
                <span class="checkmark"></span>
            </label>
        </div>
        <input type="hidden" name="lang" value="{$lang}">
        <input type="hidden" name="id" value="{$property[0].id_prop}">
        <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value="" class="hide">
        <div class="legal">
            {$lng_by_proceeding_i_agree_the_legal_note_eu_law_i_also_agree_that_this_site_may_set_cookies_on_my_browser__learn_about_uses_of_cookies_here}
        </div>
        <div class="boton d-grid col-lg-8 mx-auto mb-3">
            <input type="submit" value="{$lng_solicitar_informacion}" class="btn btn-primary" />
        </div>
        <div class="gdpr">{$texto_formularios_GDPR}</div>
    </form>


</div>