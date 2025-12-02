<?php
setcookie("favadm",'', mktime(21,00,0,12,31,1070),"/","",0);
header("Location: ".$_SERVER['HTTP_REFERER']."");
?>