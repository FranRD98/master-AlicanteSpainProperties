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
<body>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="col-xs-12">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs">
					<li><a href="resourcesUrls.php">Urls</a></li>
					<li class="active"><a href="resourcesHelper.php" aria-controls="texts">Textos</a></li>
				</ul>
				<br>
				<?php
				foreach (array_reverse($langStr) as $key => $value) {
				    // echo '<input type="text" value=""><br><hr>';
					echo '<hr><div class="form-group">';
					echo '<label for="exampleInputEmail1">' . preg_replace('/\\\/', '', $value) . '</label>';
					echo '<input type="text" class="form-control" id="exampleInputEmail1" value="{$lng_'.cleanTrad($key).'}" readonly>';
					echo '</div>';
				}
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