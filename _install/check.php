<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

function checkMysql() {
    global $hostname_inmoconn, $username_inmoconn, $password_inmoconn, $database_inmoconn;

    $link = @mysqli_connect($hostname_inmoconn, $username_inmoconn, $password_inmoconn);

    if (!$link) {
        return '<li class="list-group-item text-danger"><span class="glyphicon glyphicon-remove"></span> &nbsp;&nbsp;&nbsp; <b>Conexión a MySQL</b></li>';
    } else {
        mysqli_close($link);
        return '<li class="list-group-item text-success"><span class="glyphicon glyphicon-ok"></span> &nbsp;&nbsp;&nbsp; <b>Conexión a MySQL</b></li>';
    }
}


function checkDatabase() {
    global $hostname_inmoconn, $username_inmoconn, $password_inmoconn, $database_inmoconn;

    $link = @mysqli_connect($hostname_inmoconn, $username_inmoconn, $password_inmoconn, $database_inmoconn);

    if (!$link) {
        return '<li class="list-group-item text-danger"><span class="glyphicon glyphicon-remove"></span> &nbsp;&nbsp;&nbsp; Conexión a la base de datos: <b>' . $database_inmoconn . '</b></li>';
    } else {
        mysqli_close($link);
        return '<li class="list-group-item text-success"><span class="glyphicon glyphicon-ok"></span> &nbsp;&nbsp;&nbsp; Conexión a la base de datos: <b>' . $database_inmoconn . '</b></li>';
    }
}

function checkPermissions() {

	$files = array(
        '/_herramientas/_cache',
		'/intramedianet/xml/backup',
		'/intramedianet/newsletter/uploads',
		'/intramedianet/translate/textos.txt',
		'/intramedianet/properties/upload',
		'/media/files/clients',
		'/media/files/data',
		'/media/files/owners',
		'/media/files/news',
		'/media/files/properties',
		'/media/images/banner',
		'/media/images/news',
		'/media/images/news/thumbnails',
        '/media/images/properties',
        '/media/images/properties/thumbnails',
        '/media/images/propertiesprv',
        '/media/images/propertiesprv/thumbnails',
		'/media/images/propertiesplanos',
		'/media/images/propertiesplanos/thumbnails',
        '/media/images/teams',
        '/media/images/teams/thumbnails',
		'/media/images/users',
		'/media/images/users/thumbnails',
		'/media/images/website/thumbnails',
        '/modules/_cache',
		'/modules/property/currencyFeed.xml',
        '/resources/lang_da.php',
		'/resources/lang_de.php',
		'/resources/lang_en.php',
		'/resources/lang_es.php',
        '/resources/lang_fi.php',
		'/resources/lang_fr.php',
        '/resources/lang_is.php',
        '/resources/lang_nl.php',
        '/resources/lang_no.php',
		'/resources/lang_ru.php',
        '/resources/lang_se.php',
		'/resources/lang_zh.php',
		'/templates/cache',
		'/templates/templates_c',
		'/weather',
		'/xml/rightmove',
		'/.htaccess',
		'/robots.txt'//,
		// '/sitemap.xml'
	);

	$ret = '';

	foreach ($files as $value) {

		if(substr(sprintf('%o', fileperms($_SERVER["DOCUMENT_ROOT"] . $value)), -3) == '777') {

			$ret .= '<li class="list-group-item text-success"><span class="glyphicon glyphicon-ok"></span><span class="badge">'.substr(sprintf('%o', fileperms($_SERVER["DOCUMENT_ROOT"] . $value)), -3).'</span>  &nbsp;&nbsp;&nbsp; Permisos de escritura: <b>' . $value . '</b></li>';

		} else {

			$ret .= '<li class="list-group-item text-danger"><span class="glyphicon glyphicon-remove"></span><span class="badge">'.substr(sprintf('%o', fileperms($_SERVER["DOCUMENT_ROOT"] . $value)), -3).'</span> &nbsp;&nbsp;&nbsp; Permisos de escritura: <b>' . $value . '</b></li>';

		}

	}

	return $ret;

}


function checkDangerous() {

	if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {

		$files = array(
			'/_install'
		);

		$ret = '';

		foreach ($files as $value) {

			if(!file_exists($_SERVER["DOCUMENT_ROOT"] . $value)) {

				$ret .= '<li class="list-group-item text-success"><span class="glyphicon glyphicon-ok"></span> &nbsp;&nbsp;&nbsp; Archivo eliminado: <b>' . $value . '</b></li>';

			} else {

				$ret .= '<li class="list-group-item text-danger"><span class="glyphicon glyphicon-remove"></span> &nbsp;&nbsp;&nbsp; Eliminar archivo: <b>' . $value . '</b></li>';

			}

		}

	}

	return $ret;

}

function checkVar($var) {

	if($var == 1) {

		return '<span class="glyphicon glyphicon-ok text-success pull-right"></span>';

	} else {

		return '<span class="glyphicon glyphicon-remove text-danger pull-right"></span>';

	}

}

if ($_GET['delCache'] == 'ok') {

	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/templates/cache/*"));
	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/templates/templates_c/*"));
	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/weather/*.xml"));

	header("Location: /_install/check.php?delCacheOk=ok");

}

if ($_GET['delCacheOk'] == 'ok') {

	$mensaje = '<div class="alert alert-success fade in"><a href="/check.php" class="close">×</a><h4>Se han borrado correctamente la cache de los siguientes directorios</h4> <ul>	<li>/templates/cache/</li><li>/templates/templates_c/</li><li>/weather/</li></ul></div>';

}

if ($_GET['delMinia'] == 'ok') {

	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/news/thumbnails/*"));
	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/thumbnails/*"));
	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/users/thumbnails/*"));
    array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/website/thumbnails/*"));
	array_map('unlink', glob($_SERVER["DOCUMENT_ROOT"] . "/media/images/zonas/thumbnails/*"));

	header("Location: /_install/check.php?delMiniaOk=ok");

}

if ($_GET['delMiniaOk'] == 'ok') {

	$mensaje = '<div class="alert alert-success fade in"><a href="/check.php" class="close">×</a><h4>Se han borrado correctamente las miniaturas de los siguientes directorios</h4> <ul>	<li>/media/images/news/thumbnails/</li><li>/media/images/properties/thumbnails/</li><li>/media/images/users/thumbnails/</li><li>/media/images/website/thumbnails/</li><li>/media/images/zonas/thumbnails/</li></ul></div>';

}

function format_size($size) {
    $mod = 1024;
    $units = explode(' ','B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }
    return round($size, 2) . ' ' . $units[$i];
}

?>
<!DOCTYPE html>
	<html>
	<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>Setup Check</title>
			<link rel="stylesheet" href="/css/check/css/bootstrap.min.css">
	</head>
	<body>

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<div class="page-header">

					<h1 id="type">Check <small>Instalación</small></h1>

				</div>

				<?php echo $mensaje; ?>

				<div class="row">

					<div class="col-md-3">

						<ul id="myTab" class="nav nav-pills nav-stacked">

							<li class="active"><a href="#permisos" data-toggle="tab">Conexión y Permisos</a></li>
							<!-- <li><a href="#configuracion" data-toggle="tab">Configuración</a></li> -->
							<li><a href="#imagenes" data-toggle="tab">Imágenes</a></li>
							<!-- <li><a href="#cssjs" data-toggle="tab">CSS & JS</a></li> -->
							<li><a href="#cron" data-toggle="tab">Cron</a></li>
							<!-- <li><a href="#respnsive" data-toggle="tab">Diseño Responsivo</a></li> -->

						</ul>

						<hr>

						<div class="alert alert-danger">

							<h4>Eliminar cache</h4>

							<small>Al pulsar el botón se eliminarán los archvos de la cache de las plantillas y del tiempo.</small>

							<hr>

							<a href="?delCache=ok" id="delCache" class="btn btn-danger btn-block">Eliminar Cache</a>

						</div>

						<hr>

						<div class="alert alert-danger">

							<h4>Eliminar miniaturas</h4>

							<small>Al pulsar el botón se eliminarán las miniaturas de las imágenes.</small>

							<hr>

							<a href="?delMinia=ok" id="delMinia" class="btn btn-danger btn-block">Eliminar Miniaturas</a>

						</div>

					</div>

					<div class="col-md-9">

						<div id="myTabContent" class="tab-content">

							<div class="tab-pane fade in active" id="permisos">

								<ul class="list-group">
									<?php echo checkMysql(); ?>
									<?php echo checkDatabase(); ?>
									<?php echo checkPermissions(); ?>
									<?php echo checkDangerous(); ?>
								</ul>

							</div>

							<div class="tab-pane fade" id="configuracion">

								<ul class="list-group">

									<li class="list-group-item"><b>Idiomas principal:</b> <span class="pull-right"><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $language; ?>.png" alt="" style="margin-top: -4px"></span></li>
									<li class="list-group-item"><b>Idiomas de la aplicación:</b> <span class="pull-right"><?php foreach ($languages as $value) { ?><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt="" style="margin-top: -4px"> <?php } ?></span></li>
									<li class="list-group-item"><b>XML</b> <?php echo checkVar($xmlImport); ?></li>
									<li class="list-group-item"><b>Administrar XML exportación</b> <?php echo checkVar($xmlExport); ?></li>
									<li class="list-group-item"><b>Mapeo</b> <?php echo checkVar($mapeo); ?></li>
									<li class="list-group-item"><b>Exportar a Kyero</b> <?php echo checkVar($expKyero); ?></li>
									<li class="list-group-item"><b>Exportar a Rightmove</b> <?php echo checkVar($expRightmove); ?></li>
									<li class="list-group-item"><b>Nº agente de Rightmove</b> <span class="pull-right"><b><?php echo $rightmoveAgentRef; ?></b></span></li>
									<li class="list-group-item"><b>Branch ID de Rightmove</b> <span class="pull-right"><b><?php echo $rightmoveBranchId; ?></b></span></li>
									<li class="list-group-item"><b>Buscador de propiedades</b> <?php echo checkVar($propSearch); ?></li>
									<li class="list-group-item"><b>Calendario</b> <?php echo checkVar($actCalendar); ?></li>
									<li class="list-group-item"><b>Newsletter</b> <?php echo checkVar($actNewsletter); ?></li>
									<li class="list-group-item"><b>Newsletter Mailchimp</b> <?php echo checkVar($actMailchimp); ?></li>
									<li class="list-group-item"><b>Mailchimp key</b> <span class="pull-right"><?php echo $keyMailchimp; ?></span></li>
									<li class="list-group-item"><b>Categoría por defecto newsletter:</b> <span class="pull-right"><b><?php echo $idCatNewsletter; ?></b></span></li>
									<li class="list-group-item"><?php echo checkVar($actRemoteWeb1); ?> <b>Activar sitio web remoto nº 1</b> <?php if($actRemoteWeb1 == 1) { ?><br> <?php echo $remoteWebName1; ?><?php } ?></li>
									<li class="list-group-item"><?php echo checkVar($actRemoteWeb2); ?> <b>Activar sitio web remoto nº 2</b> <?php if($actRemoteWeb2 == 1) { ?><br> <?php echo $remoteWebName2; ?><?php } ?></li>
									<li class="list-group-item"><b>Clientes</b> <?php echo checkVar($actClients); ?></li>
									<li class="list-group-item"><b>Propietarios</b> <?php echo checkVar($actPropietarios); ?></li>
									<li class="list-group-item"><b>Aviso bajada precio</b> <?php echo checkVar($actBajadaPrecios); ?></li>
									<li class="list-group-item"><b>Opciones XML</b> <?php echo checkVar($xmlExport); ?></li>
									<li class="list-group-item"><b>Archivado en</b> <?php echo checkVar($actArchivadoEn); ?></li>
									<li class="list-group-item"><b>Noticias</b> <?php echo checkVar($actNoticias); ?></li>
									<li class="list-group-item"><b>Páginas</b> <?php echo checkVar($actPaginas); ?></li>
									<li class="list-group-item"><b>Landing pages</b> <?php echo checkVar($actLanding); ?></li>
									<li class="list-group-item"><b>Quicklinks</b> <?php echo checkVar($actQuicklinks); ?></li>
									<li class="list-group-item"><b>Marca de agua</b> <?php
										if ($actWatermark == 0) {
											echo '<span class="glyphicon glyphicon-remove text-danger pull-right"></span>';
										}
										if ($actWatermark == 1) {
											echo '<span class="pull-right">Activado para todas</span>';
										}
										if ($actWatermark == 2) {
											echo '<span class="pull-right">Activado par inmuebles individuales</span>';
										}
									?>
									</li>
									<li class="list-group-item"><b>Usuarios: Referencia automática</b> <?php echo checkVar($showRef); ?></li>
									<li class="list-group-item"><b>Usuarios: Imágen</b> <?php echo checkVar($showImagen); ?></li>
									<li class="list-group-item"><b>Usuarios: Biografía</b> <?php echo checkVar($showBio); ?></li>
									<li class="list-group-item"><b>Precio reducido</b> <?php echo checkVar($showprecioReduc); ?></li>
									<li class="list-group-item"><b>Banner</b> <?php echo checkVar($actBanner); ?></li>
									<li class="list-group-item"><b>Banner: Ancho</b> <span class="pull-right"><?php echo $actBannerWidht; ?></span></li>
									<li class="list-group-item"><b>Banner: Alto</b> <span class="pull-right"><?php echo $actBannerHeight; ?></span></li>
									<li class="list-group-item"><b>Banner: Texto</b> <?php echo checkVar($actBannerTxt); ?></li>
									<li class="list-group-item"><b>Banner: Descripción</b> <?php echo checkVar($actBannerDesc); ?></li>
									<li class="list-group-item"><b>Banner: URL</b> <?php echo checkVar($actBannerUrl); ?></li>
									<li class="list-group-item"><b>Usuarios</b> <?php echo checkVar($actUsuarios); ?></li>
									<li class="list-group-item"><b>Traducciones</b> <?php echo checkVar($actTradduccions); ?></li>
									<li class="list-group-item"><b>Usuario Twitter</b> <span class="pull-right"><?php echo $usrTwitter; ?></span></li>
									<li class="list-group-item"><b>Email envio</b> <span class="pull-right"><?php echo $fromMail; ?></span></li>
									<li class="list-group-item"><b>Email soporte</b> <span class="pull-right"><?php echo $asistenciaMail; ?></span></li>
									<li class="list-group-item"><b>Meta Title:</b> <hr> <?php foreach ($languages as $key => $value) {?><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt="" style="margin-top: -4px"> <?php echo $metaTitleDefault[$value]; ?><br><?php } ?></li>
									<li class="list-group-item"><b>Meta Description:</b> <hr> <?php foreach ($languages as $key => $value) {?><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt="" style="margin-top: -4px"> <?php echo $metaDescriptionDefault[$value]; ?><br><?php } ?></li>
									<li class="list-group-item"><b>Meta Keywords:</b> <hr> <?php foreach ($languages as $key => $value) {?><img src="/intramedianet/includes/assets/img/flags-langs/<?php echo $value; ?>.png" alt="" style="margin-top: -4px"> <?php echo $metaKeywordsDefault[$value]; ?><br><?php } ?></li>
									<li class="list-group-item"><b>Texto footer template email</b> <hr> <?php echo $textMailTempl; ?></li>

								</ul>

							</div>

							<div class="tab-pane fade" id="imagenes">

								<h4>Favicons</h4>

								<hr>

								<img src="/media/images/icons/apple-touch-icon-144.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">
								<img src="/media/images/icons/apple-touch-icon-114.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">
								<img src="/media/images/icons/apple-touch-icon-72.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">
								<img src="/media/images/icons/apple-touch-icon-57.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">
								<img src="/media/images/icons/favicon.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">

								<br><br>

								<h4>No imagen (WEB)</h4>

								<p><b>IMPORTANTE:</b> para que no se pixele, la imagen debe ser suficientemente grande (por ejemplo 1200x600 pixeles)</p>

								<img src="/media/images/website/no-image.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd; max-width: 100%">

								<h4>No imagen (EMAILS)</h4>

								<img src="/intramedianet/includes/assets/img/no_image.jpg?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd; max-width: 100%">

								<br><br>

								<br><br>

                                <h4>Cabecera plantilla emails</h4>

                                <hr>

                                <img src="/intramedianet/includes/assets/img/logomail.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">

                                <br><br>

								<h4>Banner plantilla emails</h4>

								<hr>

								<img src="/intramedianet/includes/assets/img/header.jpg?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">

								<br><br>

                                <h4>PDF - Cabecera</h4>

                                <hr>

                                <img src="/media/images/website/pdf-top.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">

                                <br><br>

                                <h4>PDF - Pie</h4>

                                <hr>

                                <img src="/media/images/website/pdf-foot.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd;">

                                <br><br>

								<h4>Marca de agua</h4>

								<hr>

								<img src="/media/images/website/watermark.png?<?php echo time(); ?>" alt="" style="border: 2px solid #ddd; background: #eee">

							</div>

							<div class="tab-pane fade" id="cssjs">

								<h4>Archivos incluidos en: <b>/intramedianet/includes/assets/js/plugins.js</b></h4>

								<hr>

								<ul class="list-group">

									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-transition.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-dropdown.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/datatables/jquery.dataTables.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/datatables/jquery.ZeroClipboard.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/datatables/jquery.TableTools.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/datatables/jquery.dataTables.bootstrap.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-modal.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootbox/bootbox.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/chosen/chosen/chosen.jquery.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/jquery-ui/jquery-ui-1.10.3.custom.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/datepicker/js/bootstrap-datepicker.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/switch/js/bootstrapSwitch.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-alert.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/validation/jquery.validate.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/sparkline/jquery.sparkline.min.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/gravatar/jquery.gravatar.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-tab.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/jQRangeSlider/jQRangeSlider-min.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/reveal/jquery.reveal.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/redactor/redactor.min.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/redactor/fullscreen.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/redactor/fontcolor.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/redactor/fontfamily.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/redactor/fontsize.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-button.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-tooltip.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/bootstrap/bootstrap-popover.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/zclip/jquery.zclip.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/fullcalendar/fullcalendar.min.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/prettyPhoto/js/jquery.prettyPhoto.js </li>

								<lu>

								<br>

								<h4>Archivos incluidos en: <b>/intramedianet/includes/assets/css/app.css</b></h4>

								<hr>

								<ul class="list-group">

									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/css/source/app.less </li>
									<li class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/css/source/bootstrap/bootstrap.less </li>
									<li class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/datepicker/less/datepicker.less </li>
									<li class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-arrow-right"></i> /intramedianet/includes/assets/js/source/switch/less/bootstrapSwitch.less </li>

								<lu>

								<br>

								<h4>Archivos incluidos en: <b>/js/plugins.js</b></h4>

								<hr>

								<ul class="list-group">

									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/jquery.validate.min.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/transition.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/carousel.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/jquery.customSelect.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/jquery.reveal.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/fullcalendar.min.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/jquery.bxslider.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/jquery.prettyPhoto.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/collapse.js </li>
									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/jquery.mobilemenu.min.js </li>

								<lu>

								<br>

								<h4>Archivos incluidos en: <b>/js/website.js</b></h4>

								<hr>

								<ul class="list-group">

									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /js/source/website.js </li>

								<lu>

								<br>

								<h4>Archivos incluidos en: <b>/css/website.css</b></h4>

								<hr>

								<ul class="list-group">

									<li class="list-group-item"><i class="glyphicon glyphicon-arrow-right"></i> /css/source/website.less </li>
									<li class="list-group-item"> &nbsp;&nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-arrow-right"></i> /css/source/bootstrap/bootstrap.less <samll class="text-muted">(No se incluyen todos los @imports)</samll> </li>

								<lu>

							</div>

							<div class="tab-pane fade" id="cron">

								<h4>Diseño Responsivo</h4>

								<p>En los servidores Plesk hay que seleccionar: Activa, Obtener una URL y No notificar.</p>

								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th style="width: 75px; text-align: center;">Minuto</th>
											<th style="width: 75px; text-align: center;">Hora</th>
											<th style="width: 75px; text-align: center;">Día del mes</th>
											<th style="width: 75px; text-align: center;">Mes</th>
											<th style="width: 75px; text-align: center;">Día de la semana</th>
											<th>Archivo</th>
											<th>Notas</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="text-align: center">0</td>
											<td style="text-align: center">7</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/sitemap.php</td>
											<td></td>
										</tr>
										<tr>
											<td style="text-align: center">0</td>
											<td style="text-align: center">*/2</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/xml/import-cron.php</td>
											<td></td>
										</tr>
										<tr>
											<td style="text-align: center">0</td>
											<td style="text-align: center">5</td>
											<td style="text-align: center">1</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/properties/owners-send-report.php</td>
											<td></td>
										</tr>
                                        <tr>
                                            <td style="text-align: center">20</td>
                                            <td style="text-align: center">*/2</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/properties/rightmove/clean-rightmove.php</td>
											<td>Solo si se activa esta opción</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center">20</td>
                                            <td style="text-align: center">6</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/idealista-json.php</td>
											<td>Solo si se activa esta opción</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center">1</td>
                                            <td style="text-align: center">7</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/seguimiento/clean_logs.php</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center">1</td>
                                            <td style="text-align: center">7</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td style="text-align: center">*</td>
                                            <td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/calendar/send-citas.php</td>
                                            <td></td>
                                        </tr>
										<tr>
											<td style="text-align: center">*/15</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/_herramientas/generar_miniaturas.php</td>
											<td></td>
										</tr>
										<tr>
											<td style="text-align: center">*/8</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/_herramientas/generar_planos.php</td>
											<td></td>
										</tr>
										<tr>
											<td style="text-align: center">0</td>
											<td style="text-align: center">18</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">5</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/properties/clients-send-search-criteria.php</td>
											<td>Solo si se activa esta opción</td>
										</tr>
										<tr>
											<td style="text-align: center">*/5</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/acumbamail/send-cron.php</td>
											<td></td>
										</tr>
										<tr>
											<td style="text-align: center">*/2</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td style="text-align: center">*</td>
											<td>https://<?php echo $_SERVER['HTTP_HOST'] ?>/intramedianet/promotions/developments-queue.php</td>
											<td></td>
										</tr>
									</tbody>
								</table>

							</div>

							<div class="tab-pane fade" id="respnsive">

								<h4>Diseño Responsivo</h4>

								<hr>

								<p>Por defecto el diseño responsivo viene activado, para eliminar el diseño responsivo hay que hacer los siguientes cambios:</p>

								<h5>En <b>/templates/templates/header.tpl</b>:</h5>

								<p>Comentar:</p>

								<pre><?php echo htmlentities('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">') ?></pre>

								<p>Descomentar:</p>

								<pre><?php echo htmlentities('<link rel="stylesheet" href="/css/no-responsive.css">') ?></pre>

								<h5>En <b>/templates/templates/footer.tpl</b>:</h5>

								<h5>En todos los archivos <b>*.tpl</b>:</h5>

								<p>Sustituir las cleses del grid <code>.col-sm-*</code>	<code>.col-md-*</code>	<code>.col-lg-*</code> por <code>.col-xs-*</code>.</p>

							</div>

							<div class="tab-pane fade" id="imagenesx">

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

	<br><br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="/css/check/js/bootstrap.min.js"></script>

	<script>

	jQuery(document).ready(function($) {

		$('#delMinia').click(function(e) {

			return (confirm('¿Seguro que deseas eliminar las miniaturas de la aplicación?'))?true:false;

		});

		$('#delCache').click(function(e) {

			return (confirm('¿Seguro que deseas eliminar la cache de la aplicación?'))?true:false;

		});

		$('#myTab a').click(function (e) {

			e.preventDefault();
			$(this).tab('show');

		});

	});

	</script>

	</body>

</html>
