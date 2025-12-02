<?php
$txt ='';

if(isset($_COOKIE['favadm'])){
	$theArray = explode(",",$_COOKIE['favadm']);
	$thenewArray = array();
	foreach($theArray  as $value){
		if($value != $_GET['favadm']){
			array_push($thenewArray,$value);
		}

	}
	setcookie("favadm",implode(',',$thenewArray), mktime(21,00,0,12,31,2030),"/","",0);

	header("Location: ".$_SERVER['HTTP_REFERER']."");
}
else {
	setcookie("favadm",$_GET['favadm'], mktime(21,00,0,12,31,2030),"/","",0);
}

?>
