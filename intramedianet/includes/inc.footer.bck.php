    <footer role="contentinfo" id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <img src="https://mediaelx.net/media/images/banner-rss/mediaelxda.svg" alt="" style="height: 30px; margin-bottom: 20px;">
                    <p>© <?php echo date( "Y"); ?> | Mediaelx Digital Agency <br> <small style="font-size: 70%;">VER.: <?php echo file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/version.md'); ?></small></p>
                    <!-- <br> -->
                    <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
                        <!-- <?php if ($fromMail == 'testemail@mediaelx.net'): ?>
                        <div class="alert alert-danger" role="alert"><b>Se esta utilizando el correo por defecto</b></div>
                        <?php endif ?>
                        <?php if ($phoneRespBar == "000000000000000"): ?>
                        <div class="alert alert-danger" role="alert"><b>Se esta utilizando el teléfono de la barra responsiva por defecto</b></div>
                        <?php endif ?>
                        <?php if ($googleMapsApiKey == 'AIzaSyBKCtBDcP_0NZl644M4c-adpWRResyFp9o'): ?>
                        <div class="alert alert-danger" role="alert"><b>Se esta utilizando la api key de google maps por defecto</b></div>
                        <?php endif ?>
                        <?php if ($keyMailchimp == '349f2edac3d9b5c2d6b36663a0c4288f-us12'): ?>
                        <div class="alert alert-danger" role="alert"><b>Se esta utilizando la api key de mailchimp por defecto</b></div>
                        <?php endif ?>
                        <?php if ($google_captcha_sitekey == '6Ldf2RIUAAAAAPRjg_GCzUmUld78j3lL-frn_TA8'): ?>
                        <div class="alert alert-danger" role="alert"><b>Se esta utilizando la api key de recaptcha por defecto</b></div>
                        <?php endif ?> -->
                    <?php endif ?>
                </div>
            </div>
        </div>
        <!--/.container-fluid -->
    </footer>

</div>  <!-- /#wrapper -->

<!-- JS -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/intramedianet/includes/assets/js/jquery.dirty.js"></script>

<script>
	var appLang = '<?php echo $lang_adm ?>';
</script>

<script src="/intramedianet/includes/resources/lang_<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/lang_' . $lang_adm . '.js'); ?>"></script>

<script src="/intramedianet/includes/assets/js/plugins.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/js/plugins.js'); ?>"></script>

<script src="/intramedianet/includes/assets/js/source/redactor/langs/<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/js/source/redactor/langs/' . $lang_adm . '.js'); ?>"></script>

<?php if($lang_adm != 'en') { ?>
<script src="/intramedianet/includes/resources/messages_<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/messages_' . $lang_adm . '.js'); ?>"></script>
<script src="/intramedianet/includes/resources/plupload_<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/plupload_' . $lang_adm . '.js'); ?>"></script>
<script src="/intramedianet/includes/resources/bootstrap-datepicker.<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/bootstrap-datepicker.' . $lang_adm . '.js'); ?>"></script>
<script src="/intramedianet/includes/resources/select2_locale_<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/select2_locale_' . $lang_adm . '.js'); ?>"></script>
<?php } ?>

<script src="/intramedianet/includes/assets/js/app.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/js/app.js'); ?>"></script>


<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/modals-add.php' ); ?>

<?php /* ?>
<?php
// Tendrías que crear la cuenta en: https://maqpie.com/signup
// Una vez hagáis login, la misma web os pedirá seguir unos pasos para configurar el widget.
// Sobra con que copiéis el “appId” y lo sustituyáis en el código que os pego más abajo.
// Hay que añadir el código en el archivo: intramedianet/includes/inc.footer.php
// Tenéis que darle a siguiente en los pasos que os va marcando.
// Os saldrá “Setup Email Notifications”, ahí podéis modificar el nombre de la Compañía, la URL de la web y subir su logo.
// Aparecerá también la configuración por si el cliente quiere aplicación de Móvil, esto imagino que dependerá de lo que contrate el cliente.
// Se pueden crear grupos y añadir los usuarios a diferentes compañías. En la configuración recordar cambiar los valores de:
// groupId: Yo pondría company por defecto.
// company: Podéis poner el nombre de la Inmobiliaria como id y como name.
// El string de userHash debería ser único por panel, pero si no lo fuera tampoco da error.
?>
<script>
  var MP = {
    data: {
      appId: "5b8d41d6e0b15e00280f9311", // your app id. it's same for each user. required
      user: {
        <?php if ($_SESSION['kt_login_id'] == "47") {  ?>
        username: "Master <?php echo $_SESSION['kt_login_name'] ?>", // required
        firstName: "Master", // not required
        lastName: "<?php echo $_SESSION['kt_login_name'] ?>", // not required
            email: "test<?php echo $_SESSION['kt_login_user'] ?>", // required
            userId: "Mediaelx<?php echo $_SESSION['kt_login_id']  ?>", // unique user id. required
        <?php } else { ?>
            username: "<?php echo $_SESSION['kt_login_name'] ?>", // required
            firstName: "<?php echo $_SESSION['kt_login_name'] ?>", // not required
            lastName: "<?php echo $_SESSION['kt_login_name'] ?>", // not required
            email: "<?php echo $_SESSION['kt_login_user'] ?>", // required
            userId: "<?php echo $_SESSION['kt_login_id']  ?>", // unique user id. required
        <?php } ?>
        groupId: "company", // same for users who are in same group; NOTE: can't be changed. required
        company: {
          id: "mediaelx", // same for users who are in same company. required
          name: "Mediaelx", // same for users who are in same company. required
        }
    },
    <?php if ($_SESSION['kt_login_id'] == "47") {  ?>
      userHash: "<?php echo hash_hmac('sha256', "Mediaelx".$_SESSION['kt_login_id'], '486ab1a27f0a87ae7a4d18b5c42715eda79bc813d26866eb4d4d333d634d5f3e1a1d7a98f3e86278b0cbf6197c02c3c1'); ?>" // required
      <?php } else { ?>
          userHash: "<?php echo hash_hmac('sha256', $_SESSION['kt_login_id'], '486ab1a27f0a87ae7a4d18b5c42715eda79bc813d26866eb4d4d333d634d5f3e1a1d7a98f3e86278b0cbf6197c02c3c1'); ?>" // required
          <?php } ?>
    },
    settings: {
        styles: {
            headerColor: "#0c3b83", // a primary chat color
            scrollColor: "#0c3b83", // a color of the chat scroll
            headerTextColor: "#ffffff", // a color of the header text and icons
            headerSelectedIconColor: "#dddddd", // a color of the hovered header icon
        },
    },
  }
</script>
<script>(function(){var l=function(){var d=document;var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.maqpie.com/widget/v1.0';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};var w=window;w.MP._queue=w.MP._queue || [];var m=['renderLargeView','showLargeView','destroyLargeView','subscribe','unsubscribe'];var f=function(method){return function(){var args = Array.prototype.slice.call(arguments);args.unshift(method);w.MP._queue.push(args);}};for(var i = 0;i < m.length;i += 1){w.MP[m[i]] = f(m[i]);} if(w.attachEvent){w.attachEvent('onload', l)}else{w.addEventListener('load', l, false)}}())</script>
<?php */ ?>
