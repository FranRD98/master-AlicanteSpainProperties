{include file="header.tpl"}

<div class="container">

    <div class="page-content my-5">
        
            {$error1}

            <h1 class="main-title text-center">{$lng_tu_cuenta}</h1>

            {if isset($smarty.get.info) && $smarty.get.info == 'UPDATED'}

            <div class="alert alert-success">

                {$lng_tu_cuenta_se_ha_actualizado_correctamente}.

            </div>

            {/if}
            {$pagetext}
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-10 col-xl-8 bg-light">
            
            <form method="post" id="form1" class="validate custom-form my-4 px-2" action="{$urlStart}update/">

                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nombre_usr">{$lng_nombre}</label>
                            <input type="text" class="form-control required" name="nombre_usr" id="nombre_usr" value="{if isset($smarty.post.nombre_usr) && $smarty.post.nombre_usr != ''}{$smarty.post.nombre_usr}{else}{if isset($row_rsusers.nombre_usr)}{$row_rsusers.nombre_usr}{/if}{/if}" placeholder="{$lng_nombre}">
                        </div>
                    </div>
                    <div class="col-6">

                        <div class="mb-3">
                            <label for="apellidos_cli">{$lng_apellidos}</label>
                            <input type="text" class="form-control required" name="apellidos_cli" id="apellidos_cli" value="{if isset($smarty.post.apellidos_cli) && $smarty.post.apellidos_cli != ''}{$smarty.post.apellidos_cli}{else}{if isset($prpos[0].apellidos_cli)}{$prpos[0].apellidos_cli}{/if}{/if}" placeholder="{$lng_apellidos}">
                        </div>

                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email_usr">{$lng_email}</label>
                    <input type="text" class="form-control required email" name="email_usr" id="email_usr" value="{if isset($smarty.post.email_usr) && $smarty.post.email_usr != ''}{$smarty.post.email_usr}{else}{if isset($row_rsusers.email_usr)}{$row_rsusers.email_usr}{/if}{/if}" placeholder="{$lng_email}">
                </div>

                 <div class="mb-3">
                    <label for="telefono_fijo_cli">{$lng_telefono}</label>
                    <input type="text" class="form-control" name="telefono_fijo_cli" id="telefono_fijo_cli" value="{if isset($smarty.post.telefono_fijo_cli) && $smarty.post.telefono_fijo_cli != ''}{$smarty.post.telefono_fijo_cli}{else}{if isset($prpos[0].telefono_fijo_cli)}{$prpos[0].telefono_fijo_cli}{/if}{/if}" placeholder="{$lng_telefono}">
                </div>
                
                <div class="mb-3">
                    <label for="direccion_cli">{$lng_direccion}</label>
                    <input type="text" class="form-control" name="direccion_cli" id="direccion_cli" value="{if isset($smarty.post.direccion_cli) && $smarty.post.direccion_cli != ''}{$smarty.post.direccion_cli}{else}{if isset($prpos[0].direccion_cli)}{$prpos[0].direccion_cli}{/if}{/if}" placeholder="{$lng_direccion}">
                </div>

                <div class="row">
                    <div class="col-md-6">
                         <div class="mb-3">
                            <label for="password_usr">{$lng_contrasena}</label>
                            <input type="password" class="form-control contrasena" name="password_usr" id="password_usr" placeholder="{$lng_contrasena}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="re_password_usr">{$lng_introducela_de_nuevo}</label>
                            <input type="password" class="form-control contrasena" name="re_password_usr" id="re_password_usr" placeholder="{$lng_contrasena}">
                        </div>
                    </div>
                </div>
                
                <input type="submit" name="KT_Update1" id="KT_Update1" class="btn btn-primary w-100" value="{$lng_actualizar_tu_cuenta}" />

            </form>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
    </div>
</div>

{include file="footer.tpl"}