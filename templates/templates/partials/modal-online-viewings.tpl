<a href="#" class="boton-lateral-fijo d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#online_viewing_trip">
    ONLINE VIEWINGS
</a>


<div class="modal" tabindex="-1" role="dialog" id="online_viewing_trip">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Online <strong>Viewing</strong></h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="sendFriendFormTrips" method="post" class="validate">
                <div class="modal-body">
                    <p style="font-size: 14px;">
                        <a style="text-decoration: none; font-weight: 500; color: #000;"
                            href="{$urlStart}{$url_contact}/">Book your viewings Today!</a>
                    </p>
                    <div class="row">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control required" name="name" id="name"
                                placeholder="{$lng_nombre}*">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <input type="text" class="form-control required email" name="email" id="email"
                                placeholder="{$lng_email}*">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <input type="text" class="form-control " name="phone" id="phone" placeholder="{$lng_telefono}">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <input type="text" class="form-control fecha" name="fecha" id="fecha"
                                placeholder="Preferred day and time">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <select name="forma_visita" class="form-control required">
                                <option value="Sin elegir">Way of doing virtual visit</option>
                                <option value="Skype">Skype</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="FaceTime">FaceTime</option>
                                <option value="Zoom">Zoom</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="acomment" id="acomment" class="form-control" rows="2"
                                placeholder="{$lng_mensaje}"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="checkcontainer mb-6">
                                <input type="checkbox" name="lpd" id="lpd" class="required" />
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-md-6">
                            <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}" data-callback="onRecaptchaSuccessWin"></div>
                        </div>
                    </div>
                    
                    <button type="submit" id="submitWin" class="btn btn-primary btn-block" disabled>{$lng_enviar}</button>

                    <div class="gdpr">{$texto_formularios_GDPR}</div>
                    <input type="hidden" name="lang" value="{$lang}">
                    <input type="hidden" name="link"
                        value="https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}">
                    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value=""
                        class="hide">
                </div>
            </form>
        </div>
    </div>
</div>
 
<script>
    function onRecaptchaSuccessWin() {
        document.getElementById('submitWin').disabled = false;
    }
</script>        