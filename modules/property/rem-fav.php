<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    echo "<meta name='robots' content='noindex'>";
}

$totalFavs = 0;
$isLevel1 = false;

$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);
$isLoggedIn1 = new tNG_UserLoggedIn($conn_inmoconn);
$isLoggedIn1->addLevel("1");
if ($isLoggedIn1->Execute()) {
    $isLevel1 = true;
}

if ($isLevel1 == true) {

    // Sanitizar la entrada para evitar SQL Injection
    $userId = $_SESSION['kt_login_id'];
    $favId = $_GET['fav'] ?? '';

    // Preparar y ejecutar la consulta para eliminar favorito
    $stmt = $inmoconn->prepare("DELETE FROM `users_favorites` WHERE `user` = ? AND `property` = ?");
    $stmt->bind_param('ss', $userId, $favId);
    $stmt->execute();
    $stmt->close();

    // Preparar y ejecutar la consulta para contar favoritos
    $stmt = $inmoconn->prepare("SELECT property FROM `users_favorites` WHERE `user` = ?");
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalFavs = $result->num_rows;
    $stmt->close();

} else {
    $txt ='';

    if(isset($_COOKIE['fav'])){
        $theArray = explode(",",$_COOKIE['fav']);
        $thenewArray = array();
        foreach($theArray  as $value){
            if($value != $_GET['fav']){
                array_push($thenewArray,$value);
            }

        }
        setcookie("fav",implode(',',$thenewArray), mktime(21,00,0,12,31,2030),"/","",0);
        $totalFavs = count($thenewArray);
    }
    else {
        setcookie("fav",$_GET['fav'], mktime(21,00,0,12,31,2030),"/","",0);
        $totalFavs = 0;
    }
}

echo $totalFavs;
?>