{include file="header.tpl"}


    <div class="container py-5 mb-5">
        
        <h1 class="main-title text-center">{$lng_recordar_contrasena}</h1>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">

                {$error1}
                {$pagetext}

                <form method="post" id="form1" class="validate custom-form bg-light p-4" action="{$urlStart}forgot/">

                    <div class="mb-3">
                        <label for="email_usr"></label>
                        <input type="text" class="form-control required email" name="email_usr" id="email_usr" placeholder="{$lng_email}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <input type="submit" name="KT_Update1" id="KT_Update1" class="btn btn-primary w-100" value="{$lng_recordar_contrasena}" />
                        </div>
                        <div class="col-md-6">
                            <a href="{$urlStart}login/" class="btn w-100">{$lng_volver}</a>
                        </div>
                    </div>


                </form>

            </div>
        </div>

    </div>




{include file="footer.tpl"}
