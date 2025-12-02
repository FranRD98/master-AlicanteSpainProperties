<div class="modal" tabindex="-1" role="dialog" id="bajadaModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{$lng_informarme_de_bajada_de_precio}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="bajadaPrecioForm" method="post" class="validate">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namebj">{$lng_nombre} *</label>
                        <input type="text" class="form-control required" name="namebj" id="namebj"
                            placeholder="{$lng_nombre}">
                    </div>
                    <div class="mb-3">
                        <label for="phonebj">{$lng_telefono}</label>
                        <input type="text" class="form-control" name="phonebj" id="phonebj"
                            placeholder="{$lng_telefono}">
                    </div>
                    <div class="mb-3">
                        <label for="emailbj">{$lng_email} *</label>
                        <input type="text" class="form-control required email" name="emailbj" id="emailbj"
                            placeholder="{$lng_email}">
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
                    <div class="gdpr">{$texto_formularios_GDPR}</div>
                    <div class="col-md-6">
                        <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}" data-callback="onRecaptchaSuccessBaja"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <input type="hidden" name="lang" value="{$lang}">
                    <input type="hidden" name="id" value="{$property[0].id_prop}">
                    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value=""
                        class="hide">
                    <input type="submit" value="{$lng_informarme_de_bajada_de_precio}" class="btn btn-primary" id="submitBaja" disabled/>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function onRecaptchaSuccessBaja() {
        document.getElementById('submitBaja').disabled = false;
    }
</script>
