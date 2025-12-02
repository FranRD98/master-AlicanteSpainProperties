<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

$isLevel1 = false;

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("1");
if ($isLoggedIn1->Execute()) {
    $isLevel1 = true;
}

if ($isLevel1 == true) {
    $query_rsInsert2 = "
    DELETE FROM  `users_favorites` WHERE `user` = '".simpleSanitize(($_SESSION['kt_login_id']))."'
    ";
    mysqli_query($inmoconn, $query_rsInsert2);
	header("Location: ".$_SERVER['HTTP_REFERER']."");
} else {
	setcookie("fav",'', mktime(21,00,0,12,31,2030),"/","",0);
	header("Location: ".$_SERVER['HTTP_REFERER']."");
}

?>
