<?php

// ini_set('display_errors', 1);
//  error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

function getRecords($sql){

    global $database_inmoconn, $inmoconn, $_GET;

    $query_rsSelect = $sql;
    $rsSelect = mysqli_query($inmoconn,$query_rsSelect) or die(mysqli_error() . '<hr>' . $query_rsSelect);
    $row_rsSelect = mysqli_fetch_assoc($rsSelect);
    $totalRows_rsSelect = mysqli_num_rows($rsSelect);

    $ret = array();
    do {
        array_push($ret, $row_rsSelect);
    } while ($row_rsSelect = mysqli_fetch_assoc($rsSelect));

    mysqli_free_result($rsSelect);
    // mysqli_close($rsSelect);

    return $ret;

}

function file_get_contents_curl($url, $retries=5)
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

$lastNews = getRecords("

SELECT
    properties_images.id_img,
    properties_images.image_img,
    properties_images.image_img2,
    properties_images.property_img
FROM properties_images

WHERE image_img LIKE 'http%'

ORDER BY id_img DESC


");

// echo count($lastNews);
// aa();

$i = 1;

foreach ($lastNews as $key => $value) {


        set_time_limit(0);

    if (preg_match("/^http/i", $value['image_img'])) {

        $namefile = uniqid($value['id_img'] . '_').".jpg";

        $archivo = $value['image_img2'];
        $archivo = str_replace(' ', '%20', $archivo);

        if ($file = file_get_contents_curl($archivo)) {
            if (file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/media/images/properties/".$namefile."", $file)) {

                $query = "UPDATE properties_images SET ";

                $query .= "image_img = '" . $namefile . "' ";

                $query .= "WHERE id_img = '".$value['id_img']."'";

                mysqli_select_db($inmoconn, $database_inmoconn);
                $rsPropFeatureInsert = mysqli_query($inmoconn, $query) or die(mysqli_error($inmoconn));

            }
        }

    }

}


?>
