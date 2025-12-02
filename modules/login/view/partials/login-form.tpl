 <div class="row mb-3 g-0">

    <div class="col-6">
         <a class="btn btn-light w-100"  href="{$urlStart}register/" >
             {$lng_registrate}
         </a>
     </div>
     <div class="col-6">
         <span class="btn btn-secondary w-100">
             {$lng_login}
         </span>
     </div>
     
 </div>

<form method="post" id="form1" class="validate px-3" action="{$urlStart}login/">
    <div class="mb-3">
        {* <label for="kt_login_user">{$lng_email}</label> *}
        <input type="text" class="form-control required email" name="kt_login_user" id="kt_login_user" placeholder="{$lng_email}">
    </div>
    <div class="mb-3">
        {* <label for="kt_login_password">{$lng_contrasena}</label> *}
        <input type="password" class="form-control required" name="kt_login_password" id="kt_login_password" placeholder="{$lng_contrasena}">
    </div>
    <div class="mb-3">
        <input type="submit" name="kt_login1" id="kt_login1" class="btn btn-primary w-100" value="{$lng_entrar}" />
    </div>
    <div class="gdpr">{$texto_formularios_GDPR}</div>

    <div class="row justify-content-end pt-4">
        <div class="col-md-6">
            <a href="{$urlStart}forgot/" class="btn w-100 px-0 text-end">{$lng_recordar_contrasena}</a>
        </div>
    </div>
</form>