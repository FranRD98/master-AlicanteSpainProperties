<?php require_once('../../Connections/appconn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



$query_rsInmuebles = "SELECT properties_images.image_img, properties.ref_prop, properties.id_prop FROM properties LEFT OUTER JOIN properties_images ON properties.id_prop = properties_images.property_img WHERE id_prop = '".$_GET['id']."' ORDER BY ref_prop ASC";
$rsInmuebles = mysqli_query($appconn, $query_rsInmuebles) or die(mysqli_error());
$row_rsInmuebles = mysqli_fetch_assoc($rsInmuebles);
$totalRows_rsInmuebles = mysqli_num_rows($rsInmuebles);


				require_once('../../includes/phpthumb/ThumbLib.inc.php');

				$url = str_replace(array('fa&amp;ccedil;de', '&ccedil;', '&amp;eacute;', '&eacute;'), array('façade', 'ç', '&eacute;', 'é'), $row_rsInmuebles['image_img']);

				if($row_rsInmuebles['image_img'] != ''){

					if(preg_match('/https?:\/\//', $url)){


							$path = explode('/', $url);
							$filename=$path[count($path)-1];
							$filename= explode('.', $filename);
							$filename= $filename[0].'_50x50.'.$filename[1];

							if(!file_exists('../../media/images/properties/thumbnails/'.$filename)) {
								$thumb = PhpThumbFactory::create( $url , array('jpegQuality'=>70));
								$thumb->adaptiveResize(50, 50);
								$thumb->save('../../media/images/properties/thumbnails/'.$filename);
								$row = '<span class="thumbnail thumbnailIMGPROP"><img src="/media/images/properties/thumbnails/'.$filename.'" alt=""></span>';
							} else {
								$row = '<span class="thumbnail thumbnailIMGPROP"><img src="/media/images/properties/thumbnails/'.$filename.'" alt=""></span>';
							}

					} else {

							$url = '../../media/images/properties/'.$row_rsInmuebles['image_img'] ;
							$path = explode('/', $url);
							$filename=$path[count($path)-1];
							$filename= explode('.', $filename);
							$filename= $filename[0].'_50x50.'.$filename[1];

						if(!file_exists('../../media/images/properties/thumbnails/'.$filename)){
							$thumb = PhpThumbFactory::create($url, array('jpegQuality'=>70));
							$thumb->adaptiveResize(50, 50);
							$thumb->save('../../media/images/properties/thumbnails/'.$filename);
							$row = '<span aria-=""class="thumbnail thumbnailIMGPROP"><img src="/media/images/properties/thumbnails/'.$filename.'" alt=""></span>';
						} else {
							$thumb = PhpThumbFactory::create('../includes/assets/img/no-img.png');
							$thumb->adaptiveResize(50, 50);
							$thumb->save('../../media/images/properties/thumbnails/no-img_50x50.png');
					$row = '<span aria-=""class="thumbnail thumbnailIMGPROP"><img src="/media/images/properties/thumbnails/no-img_50x50.png" alt=""></span>';
						}

					}

				} else {
					$thumb = PhpThumbFactory::create('../includes/assets/img/no-img.png');
					$thumb->adaptiveResize(50, 50);
					$thumb->save('../../media/images/properties/thumbnails/no-img_50x50.png');
					$row = '<span aria-=""class="thumbnail thumbnailIMGPROP"><img src="/media/images/properties/thumbnails/no-img_50x50.png" alt=""></span>';
				}

echo $row;




mysqli_free_result($rsInmuebles);
?>
