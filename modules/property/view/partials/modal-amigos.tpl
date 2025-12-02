<div class="modal" tabindex="-1" role="dialog" id="friendPureModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{$lng_enviar_a_un_amigo}</h5>
                <a class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </a>
            </div>
            <form action="#" id="sendFriendForm" method="post" class="validate">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name">{$lng_tu} {$lng_nombre} *</label>
                        <input type="text" class="form-control required" name="name" id="name"
                            placeholder="{$lng_nombre}">
                    </div>
                    <div class="mb-3">
                        <label for="email">{$lng_tu} {$lng_email} *</label>
                        <input type="text" class="form-control required email" name="email" id="email"
                            placeholder="{$lng_email}">
                    </div>
                    <div class="mb-3">
                        <label for="fname">{$lng_nombre_de_tu_amigo} *</label>
                        <input type="text" class="form-control required" name="fname" id="fname"
                            placeholder="{$lng_nombre}">
                    </div>
                    <div class="mb-3">
                        <label for="femail">{$lng_email_de_tu_amigo} *</label>
                        <input type="text" class="form-control required email" name="femail" id="femail"
                            placeholder="{$lng_email}">
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
                        <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}" data-callback="onRecaptchaSuccessFriend"></div>
                    </div>
                    <div class="gdpr">{$texto_formularios_GDPR}</div>
                </div>
                <div class="modal-footer bg-light">
                    <input type="hidden" name="lang" value="{$lang}">
                    <input type="hidden" name="id" value="{$property[0].id_prop}">
                    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value=""
                        class="hide">
                    <button type="submit" id="submitFriends" class="btn btn-primary" disabled>{$lng_enviar}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function onRecaptchaSuccessFriend() {
        document.getElementById('submitFriends').disabled = false;
    }
</script>