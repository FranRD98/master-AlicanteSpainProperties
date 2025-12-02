<?php
// Array definitions
  $tNG_login_config = array();
  $tNG_login_config_redirect_success = array();
  $tNG_login_config_redirect_failed = array();
  $tNG_login_config_session = array();

// Start Variable definitions
  $tNG_login_config["connection"] = "lidonconn";
  $tNG_login_config["table"] = "users";
  $tNG_login_config["pk_field"] = "id_usr";
  $tNG_login_config["pk_type"] = "NUMERIC_TYPE";
  $tNG_login_config["email_field"] = "email_usr";
  $tNG_login_config["user_field"] = "email_usr";
  $tNG_login_config["password_field"] = "password_usr";
  $tNG_login_config["level_field"] = "nivel_usr";
  $tNG_login_config["level_type"] = "NUMERIC_TYPE";
  $tNG_login_config["randomkey_field"] = "random_usr";
  $tNG_login_config["activation_field"] = "activar_usr";
  $tNG_login_config["password_encrypt"] = "true";
  $tNG_login_config["autologin_expires"] = "30";
  $tNG_login_config["redirect_failed"] = "intramedianet/index.php";
  $tNG_login_config["redirect_success"] = "intramedianet/inicio/inicio.php";
  $tNG_login_config["login_page"] = "intramedianet/index.php";
  $tNG_login_config["max_tries"] = "5";
  $tNG_login_config["max_tries_field"] = "ntries_usr";
  $tNG_login_config["max_tries_disableinterval"] = "10";
  $tNG_login_config["max_tries_disabledate_field"] = "disabledate_usr";
  $tNG_login_config["registration_date_field"] = "";
  $tNG_login_config["expiration_interval_field"] = "";
  $tNG_login_config["expiration_interval_default"] = "";
  $tNG_login_config["logger_table"] = "users_log";
  $tNG_login_config["logger_pk"] = "id_log";
  $tNG_login_config["logger_user_id"] = "idusr_log";
  $tNG_login_config["logger_ip"] = "ip_log";
  $tNG_login_config["logger_datein"] = "datein_log";
  $tNG_login_config["logger_datelastactivity"] = "dateout_log";
  $tNG_login_config["logger_session"] = "session_log";
  $tNG_login_config_redirect_success["9"] = "intramedianet/inicio/inicio.php";
  $tNG_login_config_redirect_failed["9"] = "intramedianet/index.php";
  $tNG_login_config_redirect_success["1"] = "favorites-user/";
  if(!isset($urlStr['properties']['url'])){ $urlStr['properties']['url'] = $_SERVER['REQUEST_URI'];}
    $tNG_login_config_redirect_success["1"] = $urlStr['properties']['url'] . "/favorites-user/"; // SIN BUSQUEDA
    //$tNG_login_config_redirect_success["1"] = $urlStr['properties']['url'] . "/saved-searches/"; // CON BUSQUEDA
    $tNG_login_config_redirect_failed["1"] = $urlStr['properties']['url'] . "/login/";
  
  $tNG_login_config_session["kt_login_id"] = "id_usr";
  $tNG_login_config_session["kt_login_user"] = "email_usr";
  $tNG_login_config_session["kt_login_level"] = "nivel_usr";
  $tNG_login_config_session["kt_login_name"] = "nombre_usr";
  $tNG_login_config_session["kt_login_image"] = "image_usr";
  if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    $tNG_debug_mode = "DEVELOPMENT";
  } else {
    $tNG_debug_mode = "PRODUCTION";
  }
  $tNG_debug_log_type = "";
  $tNG_debug_email_to = "";
  $tNG_debug_email_subject = "";
  $tNG_debug_email_from = "";
// End Variable definitions
?>
