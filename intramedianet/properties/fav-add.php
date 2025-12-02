<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if(isset($_COOKIE['favadm'])){
	$theArray = explode(",",$_COOKIE['favadm']);
	$thenewArray = array();
	foreach($theArray  as $value){
		if($value != $_GET['favadm']){
			array_push($thenewArray,$value);
		}

	}
	array_push($thenewArray,$_GET['favadm']);

	if(setcookie("favadm",implode(',',$thenewArray), mktime(21,00,0,12,31,2030),"/","",0)) {


	}
}
else {
	setcookie("favadm",$_GET['favadm'], mktime(21,00,0,12,31,2030),"/","",0);
}

		header("Location: properties.php");

?>