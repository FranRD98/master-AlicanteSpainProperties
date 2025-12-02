{* {if $actWhatsapp == 1}
    <a target="_blank"
        href="https://api.whatsapp.com/send?phone={$phoneRespBar}&text={"{$lng_estoy_interesado_en_esta_propiedad}: {$property[0].ref}"|escape:'url'}" class="d-block d-md-none"><i class="fab fa-whatsapp"></i> {$lng_contactar_por_whatsapp}</a>
{/if} *}

<div class="property-form mb-4 mb-lg-5">

    <form action="#" id="requestInfoForm" method="post" class="prop-contact validate">

        <h3 class="main-title">
            {$lng_solicitar_informacion}
        </h3>
        <input type="hidden" name="motivo" value="{$lng_tengo_una_pregunta_sobre_esta_propiedad}">
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm required" name="name" id="name"
                placeholder="{$lng_nombre}  *">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm required email" name="email" id="email"
                placeholder="{$lng_email}  *">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control form-control-sm " name="phone" id="phone"
                placeholder="{$lng_telefono}">
        </div>
        <div class="mb-3">
            <textarea name="comment" id="comment" class="form-control form-control-sm required" rows="8"
                placeholder="{$lng_consulta} *"></textarea>
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
        <div class="boton d-grid">
            <input type="submit" value="{$lng_solicitar_informacion}" class="btn btn-primary" />
        </div>
        <div class="gdpr">{$texto_formularios_GDPR}</div>
    </form>
    <script>
    var opcionSimilares = {$opcionSimilares};
    </script>
</div>