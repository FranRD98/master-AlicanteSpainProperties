{include file="header.tpl"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$pages[0].titulo}</h1>
                    {$pagetext}
                    <form action="#" id="contactForm4" method="post" class="validate">
                        {* @group SEC - DATOS *}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <legend>{$lng_your_details}</legend>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="{$lng_nombre}">{$lng_nombre}*</label>
                                    <input type="text" class="form-control required" name="name" id="name" placeholder="{$lng_nombre}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="{$lng_nombre}">{$lng_email}*</label>
                                    <input type="text" class="form-control required email" name="email" id="email" placeholder="{$lng_email}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="{$lng_nombre}">{$lng_telefono}</label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" placeholder="{$lng_telefono}">
                                </div>
                            </div>
                        </div>
                        {* @group SEC - PROPIEDAD *}
                        <div class="row">
                            <div class="col-md-12 my-3">
                                <legend>{$lng_property_details}</legend>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {* @group SEC - TIPO *}
                                <div class="mb-3">
                                <label for="tipo">{$lng_tipo}*</label>
                                    <input type="text" name="tipo" id="tipo" placeholder="{$lng_tipo}" class=" form-control">
                                </div>
                                {* @group SEC - LOCALIZACIÓN *}
                                <div class="mb-3">
                                <label for="localizacion">{$lng_localizacion}*</label>
                                    <input type="text" name="localizacion" id="localizacion" placeholder="{$lng_localizacion}" class=" form-control">
                                </div>
                                {* @group SEC - CARACTERÍSTICAS *}
                                <div class="mb-3">
                                <label for="caracteristicas">{$lng_caracteristicas}*</label>
                                    <input type="text" name="caracteristicas" id="caracteristicas" placeholder="{$lng_caracteristicas}" class=" form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                {* @group SEC - HABITACIONES *}
                                <div class="mb-3">
                                    <label for="bd">{$lng_habitaciones}*</label>
                                    <input type="text" name="bd" id="bd" placeholder="{$lng_habitaciones}" class=" form-control">
                                </div>
                                {* @group SEC - BAÑOS *}
                                <div class="mb-3">
                                    <label for="bt">{$lng_banos}*</label>
                                    <input type="text" name="bt" id="bt" placeholder="{$lng_banos}" class=" form-control">
                                </div>
                                {* @group SEC - PRECIO *}
                                <div class="mb-3">
                                    <label for="price">{$lng_precio}*</label>
                                    <input type="text" name="price" id="price" placeholder="{$lng_precio}" class="required form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                {* @group SEC - CONSULTA *}
                                <div class="mb-3">
                                    <label for="{$lng_nombre}">{$lng_consulta}</label>
                                    <textarea name="comment" id="comment" class="form-control " rows="8" placeholder="{$lng_consulta}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox my-3">
                            <label>
                                <input type="checkbox" name="lpd" id="lpd" class="required ">
                                {assign var="urlPPRV" value=sprintf('<a href="%s%s/" target="_blank">', {$urlStart}, {$url_privacy})}
                                {$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:'</a>'}
                            </label>
                        </div>
                                {* @group SEC - BOTONERA *}
                        <div class="mb-3">
                            <div>
                                <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}"></div>
                                <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                            </div>
                            <input type="hidden" name="lang" value="{$lang}">
                            <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value="" class="hide">
                            <input type="hidden" name="lang" id="lang" value="{$lang}">
                            <button type="submit" class="btn btn-primary">{$lng_enviar}</button>
                        </div>
                        <div class="gdpr">{$texto_formularios_GDPR}</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}
