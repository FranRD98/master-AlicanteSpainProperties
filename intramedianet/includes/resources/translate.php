<?php


/**
 * Seleccioamos el idioma a cargar segun la cookie o la variable de la url: lang_adm
 */
if(isset($_GET['lang_adm'])){

	$lang_adm = $_GET['lang_adm'];

} else if(isset($_COOKIE['adminlang'])){

	$lang_adm = $_COOKIE['adminlang'];

} else {

	$lang_adm = 'es';

}


/**
 * Carga los textos y crea la cookie para recordar el idioma que se indica.
 * @param string $language Idioma a cargar
 */

	// Declaramos la variable $lang para que pueda utilizarse en toda la aplicación
	global $lang;

	// Creamos la cookie para recordar el idioma en futuras visitas
	setcookie('adminlang', $lang_adm, mktime(21,00,0,12,31,2030),"/","",0 );

	// Cargamos el archivo de idiomas
	include( $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/includes/resources/lang_" . $lang_adm . ".php" );





/**
 * Devuelve la cadena de texto en su correspondiente idioma
 * Si no encuentra la cadena se puestra el valor de la variable $str
 * @param  string  $str identificador del array
 * @param  boolean $return Si es false devuelve la cadena con echo, si es true devuelve la cadena con return
 * @return string  Si $return es true devuelve la cadena con return
 */
function __($str, $return = false) {

	global $lang;

	if(isset($lang[$str]) && $lang[$str] != '') {
		$str = $lang[$str];
		// $str = "♦♦♦♦";
	}

	if($return == false) {
		echo $str;
	} else {
		return $str;
	}

}

/**
 * Agrega o cambiar un parámetro/valor de una cadena de texto.
 * @param string $qstring La url con o sin la URI ((ej. http://www.sitio.com?myvar=1&myvar2=a, ?myvar=1&myvar2=a o myvar=3&myvar2=v))
 * @param string $paramName El nombre de la variable (ej. myvar o othervar)
 * @param string $paramValue El valor de la variable, si es null elimina la variable (ej. myvalue o null)
 * @return string Devuelve la url (ex. ?myvar=myvalue&myvar2=a o ?myvar2=v );
 */
function KT_addReplaceParamLang($qstring, $paramName, $paramValue=null) {

	// extrae el URI si esta presente
	if (strpos($qstring, "?") !== false) {
		$uri = preg_replace("/\?.*$/", "?", $qstring);
		$qstring = preg_replace("/^.*\?/", "", $qstring);
	} else {
		if (strpos($qstring, "=") !== false) {
			$uri = "";
		} else {
			$uri = $qstring;
			if ($paramValue !== null) {
				$uri .= "?";
			}
			$qstring = "";
		}
	}

	// la lista de parámetros
	$arr = explode('&',$qstring);

	// eliminar $paramName de la lista
	foreach($arr as $key=>$value) {
		$tmpArr = explode('=',$value);
		if (urldecode($tmpArr[0]) == $paramName) {
			unset($arr[$key]);
			break;
		} else {
			if (strpos($paramName, "/") === 0) {
				if (preg_match($paramName, urldecode($tmpArr[0]))) {
					unset($arr[$key]);
					break;
				}
			}
		}
	}

	// añade $paramName a la lista
	if ($paramValue !== null) {
		$arr[] = rawurlencode($paramName).'='.rawurlencode($paramValue);
	}

	$ret = implode('&',$arr);
	$ret = preg_replace("/^&/", "", $ret);

	// si no hay parámetros, elimina el ? a partir del URI
	if ($ret == '') {
		$uri = preg_replace("/\?$/", "", $uri);
	}

	// fusiona la URI con la nueva lista de parametros
	$ret = $uri . $ret;

	return $ret;
}

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/phpthumb/ThumbLib.inc.php');

function remoteFileData($f) {
    $h = get_headers($f, 1);
    if (stristr($h[0], '200')) {
        foreach($h as $k=>$v) {
            if(strtolower(trim($k))=="last-modified") return strtotime($v);
        }
    }
}

if(!function_exists("showThumbnail")) {
    function showThumbnail($image, $path, $width, $height, $alt = null, $class = null) {

        $image = preg_replace('/\?.*/', '', $image);

    	$fileName = basename($image);

    	$thumbImg = '';

    	$pathInfo = pathinfo($image);
    	$paths['filePath'] = $pathInfo['dirname'];
    	$paths['fileExt'] = $pathInfo['extension'];
    	$paths['fileBasename'] = $pathInfo['filename'] ? $pathInfo['filename'] : substr($fileName ,0,strrpos($fileName ,'.'));
    	$paths['fileSrc'] = $path . '' . $fileName;
    	$paths['cachePath'] = $path. 'thumbnails/';

    	$rep = array('stream.asp?pic=', '&width=large', ' ', '%');

        $cachedName = str_replace($rep, '', md5($image)) . '_' . $width . 'x' . $height;
        $cachedName .= '.' . str_replace($rep, '', $paths['fileExt']);
        $cachedPath = $paths['cachePath'] . $cachedName;

        $noImagePath = $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/img/no_image.jpg';
        $noImageTime = @filemtime($noImagePath);

        $cacheTime = @filemtime($_SERVER["DOCUMENT_ROOT"] . $cachedPath);

        if (preg_match('/https?:\/\//', $image)) {

        	if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath)) {

        	    if (getImageSize(str_replace(' ', '%20', $image))) {

        	    	$imageTime = @filemtime(remoteFileData(str_replace(' ', '%20', $image)));

        	    	if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath) || $imageTime > $cacheTime) {

        	    	    $thumbImg = str_replace(' ', '%20', $image);

        	    	}

        	    } else {

        	    	if (!is_file($noImagePath) || $noImageTime > $cacheTime) {

        	    	    $thumbImg = $noImagePath;

        	    	}




        	    }

        	}

        } else {

    	    if (file_exists($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc'])) {

    	    	$imageTime = @filemtime($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);

    	    	if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath) || $imageTime > $cacheTime) {

                    $filePath = $_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc'];
                    $fileType = mime_content_type($filePath);
                    $exif = array();
                    if ($fileType == 'image/jpeg' || $fileType == 'image/tiff') {
                        // read EXIF header from uploaded file
                        $exif = exif_read_data($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);
                    }
                    //fix the Orientation if EXIF data exist
                    if(!empty($exif['Orientation'])) {
                        $source = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);
                        switch($exif['Orientation']) {
                            case 8:
                                    $rotate = imagerotate($source,90,0);
                                break;
                            case 3:
                                    $rotate = imagerotate($source,180,0);
                                break;
                            case 6:
                                    $rotate = imagerotate($source,-90,0);
                                break;
                        }
                        if ($rotate != '') {
                            imagejpeg($rotate,$_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);
                        }
                    }

    	    	    $thumbImg = $_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc'];

    	    	}   

    	    } else {

    	    	if (!is_file($noImagePath) || $noImageTime > $cacheTime) {

    	    	    $thumbImg = $noImagePath;

    	    	}

    	    }

        }

        if ($thumbImg != '') {

        	$thumb = PhpThumbFactory::create($thumbImg, array('jpegQuality'=>70));
        	$thumb->adaptiveResize($width, $height);
        	$thumb->save($_SERVER["DOCUMENT_ROOT"] . $cachedPath);

        }

    	return '<img src="'.$cachedPath.'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'"  class="'.$class.'" />';

    }
}

function blockMinutesRound($hour, $minutes = '5', $format = "H:i") {
   $seconds = strtotime($hour);
   $rounded = ceil($seconds / ($minutes * 60)) * ($minutes * 60);
   return date($format, $rounded);
}


if ($lang_adm == 'es') {
    function relativeTime($timestamp) {
        $difference = time() - $timestamp;
        $periods = array('segundo', 'minuto', 'hora', 'día', 'semana', 'mes', 'año', 'década');
        $lengths = array('60','60','24','7','4.35','12','10');
        if ($difference > 0) { // this was in the past
        $starting = 'Hace';
        } else { // this was in the future
        $difference = -$difference;
        $starting = 'Falta';
        }
        $j = 0;
        while ($difference >= $lengths[$j] && $j < count($lengths)) {
        $difference /= $lengths[$j];
        $j++;
        }
        $difference = round($difference);
        if($difference != 1) $periods[$j].= ($periods[$j]!="mes")?"s":"es";
        $text = "$starting $difference $periods[$j]";
        return $text;
    }
} else {
    function relativeTime($timestamp){
        $difference = time() - $timestamp;
        $periods = array("sec", "min", "hour", "day", "week", "month", "years", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");
        if ($difference > 0) { // this was in the past
        $starting = 'ago';
        } else { // this was in the future
        $difference = -$difference;
        $starting = 'to go';
        }
        $j = 0;
        while ($difference >= $lengths[$j] && $j < count($lengths)) {
        $difference /= $lengths[$j];
        $j++;
        }
        $difference = round($difference);
        if($difference != 1) $periods[$j].= ($periods[$j]!="mes")?"s":"es";
        $text = "$starting $difference $periods[$j]";
        return $text;
    }
}

function file_get_last_url($url, $retries=2)
{
    $ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36';

    if (extension_loaded('curl') === true)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url); // The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // The number of seconds to wait while trying to connect.
        curl_setopt($ch, CURLOPT_USERAGENT, $ua); // The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); // To fail silently if the HTTP code returned is greater than or equal to 400.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); // To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // The maximum number of redirects

        $result = curl_exec($ch);

        $redirect_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        curl_close($ch);
    }

    else
    {
        $result = file_get_contents($url);
    }

    if (empty($result) === true)
    {
        $result = false;

        if ($retries >= 1)
        {
            sleep(1);
            return file_get_contents_curl($url, --$retries);
        }
    }

    return $redirect_url;
}

function file_get_contents_curl($url, $retries=2)
{
    $ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.82 Safari/537.36';

    if (extension_loaded('curl') === true)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url); // The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // The number of seconds to wait while trying to connect.
        curl_setopt($ch, CURLOPT_USERAGENT, $ua); // The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); // To fail silently if the HTTP code returned is greater than or equal to 400.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); // To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // The maximum number of redirects

        $result = curl_exec($ch);
        curl_close($ch);
    }

    else
    {
        $result = file_get_contents($url);
    }

    if (empty($result) === true)
    {
        $result = false;

        if ($retries >= 1)
        {
            sleep(1);
            return file_get_contents_curl($url, --$retries);
        }
    }

    return $result;
}

// Genera las miniaturas de las imagenes
function generateThumbnails($image, $id, $folder = 'properties') {
    $noimage = base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/media/images/website/no-image.png'));
    set_time_limit(0);
    global $thumbnailsSizes, $thumbnailsBackground, $thumbnailsQuality, $actWatermark, $watermarkPosition, $watermarkOpacity;
    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/simpleimage/src/abeautifulsite/SimpleImage.php');
    // if (!file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/' . $folder . '/thumbnails/' . $id . '_sm.jpg')) {

        if (preg_match('/resales-online.com/', $image)) {
            $image = (file_get_last_url($image));
        }

        $image = explode('?', $image);
        $image = str_replace('http://', 'https://', $image[0]);
        $image = str_replace(' ', '%20', $image);

        $exif = exif_read_data($image, 0, true);
        // if ($exif['COMPUTED']['Height'] == '') {
        //     list($width, $heigth) = getimgsizeRemote($image);
        //     $exif['COMPUTED']['Height'] = $heigth;
        // }
        // if ($exif['COMPUTED']['Height'] == '0') {
            $exif['COMPUTED']['Width'] = 1920;
            $exif['COMPUTED']['Height'] = 1080;
        // }
        if ($exif['COMPUTED']['Height'] > 0) {
            $options  = array('http' => array('user_agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'));
            $context  = stream_context_create($options);
            $url_image = $image;

            if (preg_match('/https?:\/\//', $image)) {
                $image = base64_encode(file_get_contents_curl($image));
            } else {
                $image = base64_encode(file_get_contents($image, false, $context));
            }

            foreach ($thumbnailsSizes as $key => $value) {
                set_time_limit(0);
                ini_set('memory_limit', '-1');
                $imgLocalURL = $_SERVER["DOCUMENT_ROOT"] . '/media/images/' . $folder . '/thumbnails/' . $id . '_' . $key . '.jpg';
                // if ($actWatermark == 1 && $key != 'sm') {
                //     $imgLocalURL = $_SERVER["DOCUMENT_ROOT"] . '/media/images/' . $folder . '/thumbnails/' . $id . '_w_' . $key . '.jpg';
                // }
                try {
                    $imageTHMB = new \abeautifulsite\SimpleImage();
                    // if(version_compare(PHP_VERSION, '5.4.0') >= 0){
                    //     if ($exif['COMPUTED']['Height'] > $exif['COMPUTED']['Width']) {
                    //         $imageTHMB->create($value[0], $value[1], $thumbnailsBackground);
                    //         $imageTHMB_2 = new \abeautifulsite\SimpleImage();
                    //         $imageTHMB_2->load_base64($image);
                    //         $imageTHMB_2->best_fit($value[0], $value[1]);
                    //         $miniatura = $imageTHMB_2->output_base64('jpeg', $thumbnailsQuality);
                    //         $imageTHMB->overlay($miniatura, 'center', 1);
                    //     } else {
                    //         $imageTHMB->load_base64($image);
                    //         $imageTHMB->auto_orient();
                    //         $imageTHMB->thumbnail($value[0], $value[1]);
                    //     }
                    // } else {
                        if ($exif['COMPUTED']['Height'] > $exif['COMPUTED']['Width']) {
                            $imageTHMB->create($value[0], $value[1], $thumbnailsBackground);
                            $imageTHMB_2 = new \abeautifulsite\SimpleImage();
                            $imageTHMB_2->load($url_image);
                            $imageTHMB_2->best_fit($value[0], $value[1]);
                            $miniatura = $imageTHMB_2->output_base64('jpeg', $thumbnailsQuality);
                            $imageTHMB->overlay($miniatura, 'center', 1);
                        } else {
                            $imageTHMB->load($url_image);
                            $imageTHMB->auto_orient();
                            $imageTHMB->thumbnail($value[0], $value[1]);
                        }
                    // }
                    if ($actWatermark == 1 && $key != 'sm') {
                        $imageTHMB->overlay($_SERVER["DOCUMENT_ROOT"] . '/media/images/website/watermark.png', $watermarkPosition, $watermarkOpacity);
                    }
                    $imageTHMB->save($imgLocalURL, $thumbnailsQuality, 'jpeg');
                } catch(Exception $err) {
                    $imageTHMB = new \abeautifulsite\SimpleImage();
                    $imageTHMB->load_base64($noimage);
                    $imageTHMB->auto_orient();
                    $imageTHMB->thumbnail($value[0], $value[1]);
                    $imageTHMB->save($imgLocalURL, $thumbnailsQuality, 'image/jpeg');
                }
            }
            $options = null;
            $context = null;
            $image = null;
            $imgLocalURL = null;
        }
    // }
}

function getimgsizeRemote( $url, $referer = '' ) {
    // Set headers
    $headers = array( 'Range: bytes=0-131072' );
    if ( !empty( $referer ) ) { array_push( $headers, 'Referer: ' . $referer ); }

    // Get remote image
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
    $data = curl_exec( $ch );
    $http_status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    $curl_errno = curl_errno( $ch );
    curl_close( $ch );

    // Get network stauts391
    if ( $http_status != 200 ) {
    // echo 'HTTP Status[' . $http_status . '] Errno [' . $curl_errno . ']';
    return array(0,0);
    }

    // Process image
    $image = imagecreatefromstring( $data );
    $dims = array(imagesx( $image ), imagesy( $image ));
    imagedestroy($image);

    return $dims;
}

// Generar Mapping
function generateMapping() {

    generateProvincesMapping();
    generateTownsMapping();
    generateAreasMapping();
    generateTiposMapping();

}

function generateProvincesMapping() {
    global $database_inmoconn, $inmoconn, $languages;
    
    $query_rsData = "SELECT * FROM properties_loc2 WHERE parent_loc2 IS NULL";
    $rsData = mysqli_query($inmoconn,$query_rsData) or die(mysqli_error());
    $row_rsData = mysqli_fetch_assoc($rsData);
    $totalRows_rsData = mysqli_num_rows($rsData);
    $return = array();
    do {
        $returnArray = array();
        $returnWordArray = array();
        array_push($returnArray, $row_rsData['id_loc2']);
        
        $query_rsDataSub = "SELECT id_loc2 FROM properties_loc2 WHERE parent_loc2 = '" . $row_rsData['id_loc2'] . "'";
        $rsDataSub = mysqli_query($inmoconn,$query_rsDataSub) or die(mysqli_error());
        $row_rsDataSub = mysqli_fetch_assoc($rsDataSub);
        $totalRows_rsDataSub = mysqli_num_rows($rsDataSub);
        if ($totalRows_rsDataSub > 0) {
            do {
                array_push($returnArray, $row_rsDataSub['id_loc2']);
            } while ($row_rsDataSub = mysqli_fetch_assoc($rsDataSub));
        }
        foreach ($languages as $language) {
            $returnWordArray[$language] = $row_rsData['name_' . $language . '_loc2'];
        }
        $return[$row_rsData['id_loc2']] = array('ids' => $returnArray, 'names' => $returnWordArray);
    } while ($row_rsData = mysqli_fetch_assoc($rsData));
    $fileCacheProv = $_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/provincias.json';
    $fp = fopen($fileCacheProv , "w");
    fwrite($fp, json_encode($return));
    fclose($fp);
}

function generateTownsMapping() {
    global $database_inmoconn, $inmoconn, $languages;
    
    $query_rsData = "SELECT * FROM properties_loc3 WHERE parent_loc3 IS NULL";
    $rsData = mysqli_query($inmoconn,$query_rsData) or die(mysqli_error());
    $row_rsData = mysqli_fetch_assoc($rsData);
    $totalRows_rsData = mysqli_num_rows($rsData);
    $return = array();
    do {
        $returnArray = array();
        $returnWordArray = array();
        array_push($returnArray, $row_rsData['id_loc3']);
        
        $query_rsDataSub = "SELECT id_loc3 FROM properties_loc3 WHERE parent_loc3 = '" . $row_rsData['id_loc3'] . "'";
        $rsDataSub = mysqli_query($inmoconn,$query_rsDataSub) or die(mysqli_error());
        $row_rsDataSub = mysqli_fetch_assoc($rsDataSub);
        $totalRows_rsDataSub = mysqli_num_rows($rsDataSub);
        if ($totalRows_rsDataSub > 0) {
            do {
                array_push($returnArray, $row_rsDataSub['id_loc3']);
            } while ($row_rsDataSub = mysqli_fetch_assoc($rsDataSub));
        }
        foreach ($languages as $language) {
            $returnWordArray[$language] = $row_rsData['name_' . $language . '_loc3'];
        }
        $return[$row_rsData['id_loc3']] = array('ids' => $returnArray, 'names' => $returnWordArray);
    } while ($row_rsData = mysqli_fetch_assoc($rsData));
    $fileCacheProv = $_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/ciudades.json';
    $fp = fopen($fileCacheProv , "w");
    fwrite($fp, json_encode($return));
    fclose($fp);
}

function generateAreasMapping() {
    global $database_inmoconn, $inmoconn, $languages;
    
    $query_rsData = "SELECT * FROM properties_loc4 WHERE parent_loc4 IS NULL";
    $rsData = mysqli_query($inmoconn,$query_rsData) or die(mysqli_error());
    $row_rsData = mysqli_fetch_assoc($rsData);
    $totalRows_rsData = mysqli_num_rows($rsData);
    $return = array();
    do {
        $returnArray = array();
        $returnWordArray = array();
        array_push($returnArray, $row_rsData['id_loc4']);
        
        $query_rsDataSub = "SELECT id_loc4 FROM properties_loc4 WHERE parent_loc4 = '" . $row_rsData['id_loc4'] . "'";
        $rsDataSub = mysqli_query($inmoconn,$query_rsDataSub) or die(mysqli_error());
        $row_rsDataSub = mysqli_fetch_assoc($rsDataSub);
        $totalRows_rsDataSub = mysqli_num_rows($rsDataSub);
        if ($totalRows_rsDataSub > 0) {
            do {
                array_push($returnArray, $row_rsDataSub['id_loc4']);
            } while ($row_rsDataSub = mysqli_fetch_assoc($rsDataSub));
        }
        foreach ($languages as $language) {
            $returnWordArray[$language] = $row_rsData['name_' . $language . '_loc4'];
        }
        $return[$row_rsData['id_loc4']] = array('ids' => $returnArray, 'names' => $returnWordArray);
    } while ($row_rsData = mysqli_fetch_assoc($rsData));
    $fileCacheProv = $_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/areas.json';
    $fp = fopen($fileCacheProv , "w");
    fwrite($fp, json_encode($return));
    fclose($fp);
}

function generateTiposMapping() {
    global $database_inmoconn, $inmoconn, $languages;
    
    $query_rsData = "SELECT * FROM properties_types WHERE parent_typ IS NULL";
    $rsData = mysqli_query($inmoconn,$query_rsData) or die(mysqli_error());
    $row_rsData = mysqli_fetch_assoc($rsData);
    $totalRows_rsData = mysqli_num_rows($rsData);
    $return = array();
    do {
        $returnArray = array();
        $returnWordArray = array();
        array_push($returnArray, $row_rsData['id_typ']);
        
        $query_rsDataSub = "SELECT id_typ FROM properties_types WHERE parent_typ = '" . $row_rsData['id_typ'] . "'";
        $rsDataSub = mysqli_query($inmoconn,$query_rsDataSub) or die(mysqli_error());
        $row_rsDataSub = mysqli_fetch_assoc($rsDataSub);
        $totalRows_rsDataSub = mysqli_num_rows($rsDataSub);
        if ($totalRows_rsDataSub > 0) {
            do {
                array_push($returnArray, $row_rsDataSub['id_typ']);
            } while ($row_rsDataSub = mysqli_fetch_assoc($rsDataSub));
        }
        foreach ($languages as $language) {
            $returnWordArray[$language] = $row_rsData['types_' . $language . '_typ'];
        }
        $return[$row_rsData['id_typ']] = array('ids' => $returnArray, 'names' => $returnWordArray);
    } while ($row_rsData = mysqli_fetch_assoc($rsData));
    $fileCacheProv = $_SERVER["DOCUMENT_ROOT"] . '/modules/_mapping/tipos.json';
    $fp = fopen($fileCacheProv , "w");
    fwrite($fp, json_encode($return));
    fclose($fp);
}

function closetags($html) {
  preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
  $openedtags = $result[1];
  preg_match_all('#</([a-z]+)>#iU', $html, $result);
  $closedtags = $result[1];
  $len_opened = count($openedtags);
  if (count($closedtags) == $len_opened) {
      return $html;
  }
  $openedtags = array_reverse($openedtags);
  for ($i=0; $i < $len_opened; $i++) {
      if (!in_array($openedtags[$i], $closedtags)) {
          $html .= '</'.$openedtags[$i].'>';
      } else {
          unset($closedtags[array_search($openedtags[$i], $closedtags)]);
      }
  }
  return $html;
}

?>
