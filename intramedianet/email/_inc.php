<?php

function getTotalUnreadEmails($imap, $box) {
    $ret = '';
    $imap->selectFolder($box);
    $unreadMessages = $imap->countUnreadMessages();
    if ($unreadMessages > 0) {
        $ret = '<span class="badge badge-soft-primary ms-auto">';
        $ret .= number_format($unreadMessages, 0, ',', '.');
        $ret .= '</span>';
    }
    return $ret;
}

function get_images_from_email($attachments) {
    $images = array();
    foreach ($attachments as $attachment) {
        array_push($images, '<img src="data:image/png;base64, ' . $attachment->info . '" class="img-responsive" />');
    }
    return $images;
}

function get_images($html_string) {
    $images = array();
    preg_match_all('/<img[^>]+>/i',(string)$html_string, $result);
    foreach ($result[0] as $img) {
        array_push($images, $img);
    }
    return $images;
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function getURL($url) {
    set_time_limit(0);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, trim($url));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, '');
    curl_setopt($ch, CURLOPT_COOKIEFILE, '');
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
