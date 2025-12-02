{include file="header.tpl"}

<div class="page-content page-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$pages[0].titulo}</h1>
                    {$pagetext}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-form">

                                {* @group SEC - FORMULARIO *}
                                <h2 class="main-title">{$lng_formulario_de_contacto}</h2>
                                <form action="#" id="contactForm2" method="post" class="validate">
                                    <div class="mb-3">
                                        <input type="text" class="form-control required" name="name" id="name"
                                            placeholder="{$lng_nombre} *">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control required email" name="email" id="email"
                                            placeholder="{$lng_email} *">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control telefono" name="telefono" id="telefono"
                                            placeholder="{$lng_telefono}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="comment" id="comment" class="form-control required" rows="4"
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
                                    <div>
                                        <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}"></div>
                                        <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha"
                                            id="hiddenRecaptcha">
                                    </div>
                                    <input type="hidden" name="lang" value="{$lang}">
                                    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}"
                                        value="" class="hide">
                                    <button type="submit" class="btn btn-primary btn-block">{$lng_enviar}</button>
                                    <div class="gdpr">{$texto_formularios_GDPR}</div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {* @group SEC - MAPA *}
                            <h2 class="main-title">{$lng_donde_estamos}</h2>
                            <div class="contact-map">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25060.473825226298!2d-0.7071917018632411!3d38.26652759905468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd63b42c4ece57a3%3A0xd9a5de7c6be724dd!2sElche%2C+Alicante!5e0!3m2!1ses!2ses!4v1484728130749"
                                    frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}
