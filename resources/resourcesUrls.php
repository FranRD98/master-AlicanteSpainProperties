<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');
include("lang_".$language.".php");
include("urls.php");
?>
 <!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
	<title>Mediaelx</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<style>
	body {
		padding: 20px 0;
	}
	</style>
</head>
<body id="body">

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="col-xs-12">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="resourcesUrls.php">Urls</a></li>
					<li><a href="resourcesHelper.php" aria-controls="texts">Textos</a></li>
				</ul>

				<?php
				$langsNames = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino');
				echo '<br><ul class="nav nav-pills">';
				foreach ($urlStr as $key => $urls) {
					echo '<li><a href="#url' . $key . '">' . ucfirst($key) . '</a></li>';
				}
				echo '</ul><hr>';
				foreach ($urlStr as $key => $urls) {
                    unset($urls['mostrar-en-sitemap']);
					echo '<table class="table table-striped table-bordered">';
						echo '<legend id="url' . $key . '">' . ucfirst($key) . '</legend>';
						echo '<thead>';
							echo '<tr>';
								echo '<th>Nombre</th>';
								echo '<th>Smarty</th>';
								echo '<th>PHP</th>';
								echo '<th>Valor</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						foreach ($urls as $langval => $urlval) {
							if ($langval == $language) {
								$urlStr[$key]['url'] = $urlStr[$key][$langval] ;
								echo '<tr class="success">';
									echo '<th>URL actual</th>';
									echo '<td>{$url_' . cleanTrad($key) .'}</td>';
									echo '<td>$urlStr[\'' . $key . '\'][\'url\']</td>';
									echo '<td>' . $urlStr[$key]['url'] . '</td>';
								echo '</tr>';
							}
						}
						foreach ($urls as $langval => $urlval) {
							if ($urlStr[$key][$langval] != '') {
								echo '<tr>';
									echo '<th>URL Key ' . $langsNames[$langval] . '</th>';
									echo '<td>{$url_' . cleanTrad($key) .'_' . $langval.'_master}}</td>';
									echo '<td>$urlStr[\'' . $urlStr[$key][$langval] . '\'][\'master\']</td>';
									echo '<td>' . $key . '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<th>URL ' . $langsNames[$langval] . '</th>';
									echo '<td>{$url_' . cleanTrad($key) .'_' . $langval .'}</td>';
									echo '<td>$urlStr[\'' . $key . '\'][\'' . $langval . '\']</td>';
									echo '<td>' . $urlStr[$key][$langval] . '</td>';
								echo '</tr>';
							}
						}
						echo '</tbody>';
					echo '</table>';
					echo '<hr><a href="#body" class="btn btn-primary btn-sm">Subir</a><hr>';
				}echo '</div>';
				?>
			</div>
		</div>
	</div>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function(){
		$(document).on('click','a[href^="#"]',function (e) {
		    e.preventDefault();

		    var target = this.hash;
		    var $target = $(target);

		    $('html, body').stop().animate({
		        'scrollTop': $target.offset().top
		    }, 900, 'swing', function () {
		        window.location.hash = target;
		    });
		});
	});
	</script>
</body>
</html>