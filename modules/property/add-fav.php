<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    echo "<meta name='robots' content='noindex'>"; exit;
}



$totalFavs = 0;
$isLevel1 = false;

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("1");
if ($isLoggedIn1->Execute()) {
    $isLevel1 = true;
}

$fav = isset($_GET['fav']) ? simpleSanitize($_GET['fav']) : '';

if ($isLevel1 == true) {

    savelogprop($_GET['fav'], '6');

	// Usa consultas preparadas para prevenir inyección SQL
	$stmt = $inmoconn->prepare("
		INSERT INTO `users_favorites` (`id`, `user`, `property`) 
		VALUES (NULL, ?, ?)
	");

	if ($stmt) {
		$stmt->bind_param('ss', $_SESSION['kt_login_id'], $fav);
		$stmt->execute();
		$stmt->close();
	} else {
		echo "Error en la preparación de la consulta: " . $inmoconn->error; exit;
	}

	// Obtiene el total de favoritos
	$stmt = $inmoconn->prepare("
		SELECT COUNT(*) FROM `users_favorites` WHERE `user` = ?
	");

	if ($stmt) {
		$stmt->bind_param('s', $_SESSION['kt_login_id']);
		$stmt->execute();
		$stmt->bind_result($totalFavs);
		$stmt->fetch();
		$stmt->close();
	} else {
		echo "Error en la preparación de la consulta: " . $inmoconn->error; exit;
	}

} else {

	if (isset($_COOKIE['fav'])) {
        $theArray = explode(",", $_COOKIE['fav']);
        $thenewArray = array_filter($theArray, function($value) use ($fav) {
            return $value !== $fav;
        });
        $thenewArray[] = $fav;
        setcookie("fav", implode(',', $thenewArray), strtotime('31 December 2030 21:00:00 GMT'), "/", "", false, true);
        $totalFavs = count($thenewArray);
    } else {
        setcookie("fav", $fav, strtotime('31 December 2030 21:00:00 GMT'), "/", "", false, true);
        $totalFavs = 1;
    }

    savelogprop($fav, '6');

}

$ip = getIp();

$stmt = $inmoconn->prepare("
    INSERT INTO `properties_fav_rep` (`id_frep`, `property_frep`, `ip_frep`, `date_frep`) 
    VALUES (NULL, ?, ?, ?)
");

if ($stmt) {
    $currentDate = date("Y-m-d H:i:s");
    $stmt->bind_param('sss', $fav, $ip, $currentDate);
    $stmt->execute();
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $inmoconn->error; exit; 
}

echo $totalFavs; exit;

?>