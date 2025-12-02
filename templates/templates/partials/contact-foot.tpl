<form action="#" id="contactFootForm" method="post" role="form" class="validate">
    <div class="mb-3">
        <input type="text" class="form-control required" name="name" id="name" placeholder="{$lng_nombre} *">
    </div>
    <div class="mb-3">
        <input type="text" class="form-control required email" name="email" id="email" placeholder="{$lng_email} *">
    </div>
    <div class="mb-3">
        <input type="text" class="form-control  telefono" name="telefono" id="telefono" placeholder="{$lng_telefono}">
    </div>
    <div class="mb-3">
        <textarea name="comment" id="comment" class="form-control required" rows="3"
            placeholder="{$lng_consulta} *"></textarea>
    </div>
    <div>
        <label class="checkcontainer mb-4">
            {assign var="urlPPRV" value=sprintf('<a href="%s%s/" target="_blank">', $urlStart, $url_privacy)}
            <span class="tag-name">
                {$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:$urlPPRV:'</a>'}
            </span>
            <input type="checkbox" name="lpd" id="lpd" class="required" />
            <span class="checkmark"></span>
        </label>
    </div>
    <div>
        <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}"></div>
        <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
    </div>
    <input type="hidden" name="lang" value="{$lang}">
    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}">
    <button type="submit" class="btn btn-primary">{$lng_enviar}</button>
    <div class="gdpr">{$texto_formularios_GDPR}</div>
</form>