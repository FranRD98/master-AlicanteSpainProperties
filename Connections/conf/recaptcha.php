<?php

/*--------------------------------------------------------------------------
/* @group Google captcha "No soy un robot" */
/*--------------------------------------------------------------------------
|
| Entrar a google.com/recaptcha, para generar la clave sitekey, y registrar el/los dominios permitidos.
| Estos datos son para las pruevas del master con dominio: limpieza-master.dev
| $google_captcha_sitekey ="6Ldf2RIUAAAAAPRjg_GCzUmUld78j3lL-frn_TA8";
| $google_captcha_privatekey ="6Ldf2RIUAAAAAIMGviFdNHgmJ7tsV9qReqr0A7L5";
|
*/
if($_SERVER["HTTP_HOST"]=='master.test'){
    //desarrollo
    $google_captcha_sitekey ="6Lf7dTkrAAAAAFkf4snBjip4jWpVDwzS7ynOYGLl";
    $google_captcha_privatekey ="6Lf7dTkrAAAAAKobFEKJpzMyWxcBDZcLapJ--6CD";
} else {
    //pre-produccion
    $google_captcha_sitekey ="";
    $google_captcha_privatekey ="";
}
