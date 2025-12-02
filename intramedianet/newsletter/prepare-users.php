<?php

session_start();

$_SESSION['newsletter-esers'] = $_GET['u'];

header("Location: index.php?langt=en");

 ?>