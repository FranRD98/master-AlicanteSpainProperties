<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/lang_'.$tokens[1].'.php');

$tokens = explode('/', htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8'));

$query_rsInt = "DELETE FROM  `properties_bajada` WHERE ran_baj = '".simpleSanitize(($tokens[2]))."'";

if( mysqli_query($inmoconn, $query_rsInt) ) {

    $smarty->assign('mensaDrop', $langStr["Su aviso se ha borrado correctamente"]);

} else {

    $smarty->assign('mensaDrop', $langStr["Su aviso no se ha borrado, por favor, intentelo de nuevo"]);

}

?>