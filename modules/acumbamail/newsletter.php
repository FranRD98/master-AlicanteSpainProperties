<?php

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');



$acumba = new AcumbamailAPI($keyAcumbamail);
$acumba->addSubscriber($acumbamailIdListaWebsite[$_GET['lang']], array(
    'email'  => $_GET['email'],
    'nombre'  => $_GET['nombre']
));


echo "ok";

 ?>
