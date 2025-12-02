<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

//agregados a mano para poder seguir
$actMapaPropiedades = 0;
include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );


// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("kt_login_user", true, "text", "", "", "", "");
$formValidation->addField("kt_login_password", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make a login transaction instance
$loginTransaction = new tNG_login($conn_inmoconn);
$tNGs->addTransaction($loginTransaction);

//agrego variable para la redireccion
$kt_login_redirect = 'inicio/inicio.php';
// Register triggers
$loginTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "kt_login1");
$loginTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
//$loginTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "{kt_login_redirect}");
$loginTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, $kt_login_redirect);

// Add columns
$loginTransaction->addColumn("kt_login_user", "STRING_TYPE", "POST", "kt_login_user");
$loginTransaction->addColumn("kt_login_password", "STRING_TYPE", "POST", "kt_login_password");
$loginTransaction->addColumn("kt_login_rememberme", "CHECKBOX_1_0_TYPE", "POST", "kt_login_rememberme", "0");
// End of login transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysqli_fetch_assoc($rscustom);
$totalRows_rscustom = mysqli_num_rows($rscustom);

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mediaelx CRM</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="57x57" href="/intramedianet/includes/assets/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/intramedianet/includes/assets/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/intramedianet/includes/assets/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/intramedianet/includes/assets/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/intramedianet/includes/assets/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/intramedianet/includes/assets/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/intramedianet/includes/assets/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/intramedianet/includes/assets/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/intramedianet/includes/assets/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/intramedianet/includes/assets/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/intramedianet/includes/assets/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/intramedianet/includes/assets/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/intramedianet/includes/assets/favicons/favicon-16x16.png">
        <link rel="manifest" href="/intramedianet/includes/assets/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/intramedianet/includes/assets/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <style>
            body {
                font-family: Poppins !important;
                background: #1a1a1a;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            a {
                text-decoration: none;
            }

            .login-content {
                <?php if ($actLestinmo == 0): ?>
                    background: url(https://mediaelx.net/media/images/banner-rss/login-bg.png) no-repeat center center fixed;
                <?php else: ?>
                    background: url(https://mediaelx.net/media/images/banner-rss/login-bg-letsinmo.png) no-repeat center center fixed;
                <?php endif ?>
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            h2 {
                font-family: Poppins;
                font-size: 30px;
                font-weight: 600;
                font-stretch: normal;
                font-style: normal;
                line-height: 1.53;
                letter-spacing: normal;
                text-align: left;
                color: #fff;
            }

            .feed h3 {
                font-family: Poppins;
                font-size: 14px;
                font-weight: 500;
                font-stretch: normal;
                font-style: normal;
                line-height: 1.71;
                letter-spacing: normal;
                text-align: center;
                text-transform: uppercase;
                color: #fff;
            }

            .langsTop p {
                font-family: Poppins;
                font-size: 12px;
                font-weight: 300;
                font-stretch: normal;
                font-style: normal;
                line-height: 1.5;
                letter-spacing: normal;
                text-align: left;
                color: #fff;
            }

            .langsTop a {
                font-family: Poppins;
                font-size: 18px;
                font-weight: 300;
                font-stretch: normal;
                font-style: normal;
                line-height: 1.5;
                letter-spacing: normal;
                text-align: left;
                color: #fff;
                text-transform: uppercase;
            }

            .btn-dark,
            .btn-success {
                font-family: Poppins;
                font-size: 16px;
                font-weight: bold;
                font-stretch: normal;
                font-style: normal;
                letter-spacing: normal;
                color: #fff;
                border-radius: 8px;
                border: solid 1px #afb8c1;
                padding: .8em var(--bs-btn-padding-x);
            }

            .btn-success {
                color: #1f1f1f;
                <?php if ($actLestinmo == 0): ?>
                    background-color: #2ed9c3;
                    border: solid 1px #2ed9c3;
                <?php else: ?>
                    background-color: #01b5e8;
                    border: solid 1px #01b5e8;
                <?php endif ?>

            }

            .btn-success:hover {
                color: #1f1f1f;
                <?php if ($actLestinmo == 0): ?>
                    background-color: #33f7de;
                    border: solid 1px #33f7de;
                <?php else: ?>
                    background-color: #139dc9;
                    border: solid 1px #139dc9;
                <?php endif ?>
            }

            .form-check label {
                font-size: 14px;
                font-weight: bold;
                font-stretch: normal;
                font-style: normal;
                line-height: 1.5;
                letter-spacing: normal;
                text-align: left;
                color: #fff;
            }

            .form-check-input:checked {
                background-color: #2ed9c3;
                border-color: #2ed9c3;
            }

            .error {
                margin: 0 0 0 20px;
                padding: 5px 20px;
                font-size: 12px;
                font-weight: 600;
                color: #fff;
                background: var(--bs-form-invalid-color);
                border-radius: 0 0 4px 4px;
            }

            .copyrr {
                font-family: Poppins;
                font-size: 14px;
                font-weight: 500;
                font-stretch: normal;
                font-style: normal;
                line-height: 1.5;
                letter-spacing: 0.56px;
                color: #b3b7ba;
            }

        </style>
    </head>
    <body>
        <div class="container-fluid min-vh-100 d-flex flex-column">
            <div class="row flex-grow-1">
                <div class="col-md-9 login-content">

                    <div class="p-5 px-0 px-md-5mt-md-5 ms-md-5 ps-md-5 pt-0 pt-5">
                    <div class="mt-md-5 ms-md-5">


                        <?php if ($actLestinmo == 0): ?>
                            <img src="https://mediaelx.net/media/images/banner-rss/login-logo.svg" alt="Mediaelx" class="mb-5 img-fluid">
                        <?php else: ?>
                            <img src="https://mediaelx.net/media/images/banner-rss/login-logo-letsinmo.svg" alt="Mediaelx" class="mb-5 img-fluid" style="height: 50px;">
                        <?php endif ?>

                        <div class="langsTop mb-4">
                            <p>
                            <?php if ($lang_adm == 'es'): ?>
                                Selecciona idioma
                            <?php else: ?>
                                Select language
                            <?php endif ?>
                            </p>
                            <a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'en'); ?>"><img src="https://mediaelx.net/media/images/banner-rss/flag_en.svg" alt="English" class="me-2"> English</a>
                            <a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'es'); ?>" class="ms-4"><img src="https://mediaelx.net/media/images/banner-rss/flag_es.svg" alt="Español" class="me-2"> Español</a>
                        </div>


                        <form method="post" id="form1" class="validate" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" style="max-width: 660px;">
                          <?php echo $tNGs->getLoginMsg(); ?>
                          <?php echo $tNGs->getErrorMsg(); ?>
                          <div class="form-group <?php if($tNGs->displayFieldError("custom", "kt_login_user") != '') { ?>error<?php } ?>">
                            <div class="controls">
                              <input type="text" name="kt_login_user" id="kt_login_user" value="<?php if(isset($row_rscustom['kt_login_user'])) echo KT_escapeAttribute($row_rscustom['kt_login_user']); ?>" size="32" maxlength="255" class="form-control form-control-lg required email" placeholder="<?php __('Email'); ?>">
                              <?php echo $tNGs->displayFieldError("custom", "kt_login_user"); ?>
                            </div>
                          </div> <!-- /.form-group -->
                          <br>
                          <div class="form-group <?php if($tNGs->displayFieldError("custom", "kt_login_password") != '') { ?>error<?php } ?>">
                            <div class="controls">
                              <input type="password" name="kt_login_password" id="kt_login_password" value="" size="32" maxlength="255" class="form-control form-control-lg required" placeholder="<?php __('Contraseña'); ?>">
                              <?php echo $tNGs->displayFieldError("custom", "kt_login_password"); ?>
                            </div>
                          </div> <!-- /.form-group -->
                          <div class="row">
                            <div class="col-md-6">
                                <input type="submit" name="kt_login1" id="kt_login1" class="btn btn-success btn-lg w-100 mt-4" value="<?php __('Entrar'); ?>" />
                            </div>
                            <div class="col-md-6">
                                <a href="forgot_password.php" class="btn btn-dark btn-lg w-100 mt-4"><?php __('Recordar contraseña'); ?></a>
                            </div>
                          </div>
                          <br>
                          <div class="row mt-2">
                              <div class="col-md-12">
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" <?php if(isset($row_rscustom['kt_login_rememberme'])) if (!(strcmp(KT_escapeAttribute($row_rscustom['kt_login_rememberme']),"1"))) {echo "checked";} ?> name="kt_login_rememberme" id="kt_login_rememberme" value="1">
                                      <label class="form-check-label" for="flexSwitchCheckDefault"><?php __('Recordarme'); ?></label>
                                  </div>
                                  <?php echo $tNGs->displayFieldError("custom", "kt_login_rememberme"); ?>
                              </div>
                          </div>
                        </form>

                    </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <h2 class="text-center mt-md-5 pt-md-5">InmoTips</h2>

                    <div class="feed">
                        <?php include('./feed.php' ); ?>
                    </div>

                    <p class="copyrr text-center">© <?php echo date( "Y"); ?> | Mediaelx Digital Agency</p>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="/intramedianet/includes/resources/lang_<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/lang_' . $lang_adm . '.js'); ?>"></script>
        <script src="/intramedianet/includes/assets/login/plugins.js?id=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/login/plugins.js'); ?>"></script>
        <script>
        $(".validate").each(function () {
            $(this).validate({
                rules: {
                    re_password_usr: {
                        equalTo: "#password_usr"
                    },
                    "lista[]": {
                        required: true,
                        minlength: 1
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                success: function (element) {
                    element.closest('.form-group').removeClass('has-error');
                    element.closest('label').remove();
                },
                errorPlacement: function (error, element) {
                    if ($(element).closest('div').hasClass('input-group')) {
                        $(element).parent().parent().append(error);
                    } else {
                        $(element).closest('div').append(error);
                    }
                }
            });
        });
        </script>
    </body>
</html>
