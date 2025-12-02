<?php

session_start();

setcookie("view", $_GET['v'], mktime(21,00,0,12,31,2030),"/","",0);

header("Location: " . $_GET['url']);

