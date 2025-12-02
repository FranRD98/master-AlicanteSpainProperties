<div class="modal" tabindex="-1" role="dialog" id="favoritesPureModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{$lng_enviar_propiedades}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="sendFavoritesForm" method="post" class="validate">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name">{$lng_nombre}*</label>
                        <input type="text" class="form-control required" name="name" id="name"
                            placeholder="{$lng_nombre}*">
                    </div>
                    <div class="mb-3">
                        <label for="email">{$lng_email}*</label>
                        <input type="text" class="form-control required email" name="email" id="email"
                            placeholder="{$lng_email}*">
                    </div>
                    <div class="mb-3">
                        <label for="comment">{$lng_mensaje}</label>
                        <textarea name="acomment" id="acomment" class="form-control" rows="3"
                            placeholder="{$lng_mensaje}"></textarea>
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
                    <div>
                        <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}" data-callback="onRecaptchaSuccessFav"></div>
                    </div>
                    <div class="gdpr">{$texto_formularios_GDPR}</div>
                </div>
                <div class="modal-footer bg-light">
                    <input type="hidden" name="lang" value="{$lang}">
                    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value=""
                        class="hide">
                    <button type="submit" id="submitFav" class="btn btn-primary btn-sm" disabled>{$lng_enviar}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function onRecaptchaSuccessFav() {
        document.getElementById('submitFav').disabled = false;
    }
</script>