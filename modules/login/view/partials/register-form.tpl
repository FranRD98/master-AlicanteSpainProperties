 <div class="row mb-3 g-0">

    <div class="col-6">
         <a class="btn btn-secondary w-100" >
             {$lng_registrate}
         </a>
     </div>
     <div class="col-6">
         <a class="btn btn-light w-100" href="{$urlStart}login/">
             {$lng_login}
         </a>
     </div>
     
 </div>

 <form method="post" id="form1" class="validate px-3" action="{$urlStart}register/">

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <input type="text" class="form-control required" name="nombre_usr" id="nombre_usr"
                    value="{if isset($smarty.post.nombre_usr)}{$smarty.post.nombre_usr}{/if}" placeholder="{$lng_nombre} *">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <input type="text" class="form-control" name="apellidos_cli" id="apellidos_cli"
                    value="{if isset($smarty.post.apellidos_cli)}{$smarty.post.apellidos_cli}{/if}" placeholder="{$lng_apellidos}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <input type="text" class="form-control required email" name="email_usr" id="email_usr"
                    value="{if isset($smarty.post.email_usr)}{$smarty.post.email_usr}{/if}" placeholder="{$lng_email} *">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <input type="text" class="form-control" name="telefono_fijo_cli" id="telefono_fijo_cli"
                    value="{if isset($smarty.post.telefono_fijo_cli)}{$smarty.post.telefono_fijo_cli}{/if}" placeholder="{$lng_telefono}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <input type="password" class="form-control required contrasena" name="password_usr" id="password_usr"
                    placeholder="{$lng_contrasena} *">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <input type="password" class="form-control required contrasena" name="re_password_usr"
                    id="re_password_usr" placeholder="Repeat {$lng_contrasena} *">
            </div>
        </div>
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
        <div class="col-md-6 pt-2">
        <div class="g-recaptcha" data-sitekey="{$google_captcha_sitekey}"></div>
        <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
    </div>
    <input type="submit" name="KT_Insert1" id="KT_Insert1" class="btn btn-primary w-100" value="{$lng_crear_cuenta}" />
    <div class="gdpr">{$texto_formularios_GDPR}</div>
</form>