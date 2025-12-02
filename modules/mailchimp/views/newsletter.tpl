<h2>{$lng_suscribete_a_nuestra_newsletter}</h2>
<form action="/modules/mailchimp/newsletter.php" id="newsletterForm2" method="post" role="form" class="validate">

    <div class="mb-3">
        <label for="nombre">{$lng_nombre} *</label>
        <input type="text" class="form-control required" name="nombre" id="nombrenws" placeholder="{$lng_nombre} *">
    </div>

    <div class="mb-3">
        <label for="email">{$lng_email} *</label>
        <input type="text" class="form-control required email" name="email" id="emailnws" placeholder="{$lng_email} *">
    </div>
    <div>
        <label class="checkcontainer mb-4">
            <span class="tag-name">{assign var="urlPPRV" value=sprintf('<a href="%s%s/" target="_blank">', {$urlStart},
                {$url_privacy})}
                {$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:'</a>'}*
            </span>
            <input type="checkbox" name="lpd" id="lpd" class="required" />
            <span class="checkmark"></span>
        </label>
    </div>
    <input type="hidden" name="lang" value="{$lang}">
    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value="">
    <button type="submit" class="btn btn-outline-light btn-block">{$lng_suscribirse}</button>

</form>