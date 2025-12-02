<?php
// Cargamos la conexión a MySql
// include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );


function Trigger_Add_Favoritos(){
  global $inmoconn, $conn_inmoconn;

  $isLevel1 = false;

  //$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
  $isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
  $isLoggedIn1->addLevel("1");
  if ($isLoggedIn1->Execute()) {
      $isLevel1 = true;
  }

  //verifico que el usuario no tenga favoritos en las cookies
  if($isLevel1 && isset($_COOKIE['fav'])){//en el caso que tenga favoritos en las cookies las agrego a sus registros
    $theFavs = explode(",",$_COOKIE['fav']);
    $totalFavs = (isset($_COOKIE['fav']) ? count($theFavs) : 0);
    $user = $_SESSION['kt_login_id'];
    foreach($theFavs as $fav){
        // Usa una consulta preparada para insertar solo si no existe ya el registro
        $query = "
            INSERT INTO `users_favorites` (`user`, `property`)
            SELECT ?, ?
            FROM DUAL
            WHERE NOT EXISTS (
                SELECT 1 FROM `users_favorites` WHERE `user` = ? AND `property` = ?
            )
        ";
        $stmt = $inmoconn->prepare($query);
        if ($stmt) {
            $stmt->bind_param('ssss', $user, $fav, $user, $fav);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $inmoconn->error;
        }
    }
    //vaciar las cookies
    setcookie('fav', '', time() - 3600, "/"); // Set cookie with past expiration date
    unset($_COOKIE['fav']);
  }
}


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
// Register triggers
$kt_login_redirect = '../update'; 
$loginTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "kt_login1");
$loginTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$loginTransaction->registerTrigger("AFTER", "Trigger_Add_Favoritos", 50, "Trigger_Add_Favoritos"); // Register custom trigger

//$loginTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "{kt_login_redirect}");
$loginTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, $kt_login_redirect);
// Add columns
$loginTransaction->addColumn("kt_login_user", "STRING_TYPE", "POST", "kt_login_user");
$loginTransaction->addColumn("kt_login_password", "STRING_TYPE", "POST", "kt_login_password");
// $loginTransaction->addColumn("kt_login_rememberme", "CHECKBOX_1_0_TYPE", "POST", "kt_login_rememberme", "0");
// End of login transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysqli_fetch_assoc($rscustom);
$totalRows_rscustom = mysqli_num_rows($rscustom);


if ($tNGs->getLoginMsg() != '') {
  $text = 'error';
  $smarty->assign("error", ''.$tNGs->getLoginMsg().'');
}

if ($tNGs->getErrorMsg() != '') {
  $text = 'error';
  $smarty->assign("error1", ''.$tNGs->getErrorMsg().'');
}


?>