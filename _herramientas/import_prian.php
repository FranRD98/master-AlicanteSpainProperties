<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

$xml = simplexml_load_file('http://prian.ru/files/xml/districts.xml');


$query_rsTipos = "TRUNCATE prian_cities";
$rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());

foreach ($xml as $district) {
    if ($district->country_id == 43) {
        
        $query_rsTipos = "INSERT INTO prian_cities SET ";
        $query_rsTipos .= "id_cts = '".$district->district_id."', ";
        $query_rsTipos .= "pais_cts = '".$district->country_id."', ";
        $query_rsTipos .= "region_cts = '".$district->region_id."', ";
        $query_rsTipos .= "nombre_cts = '".mysqli_real_escape_string($inmoconn,$district->name_eng)."', ";
        $query_rsTipos .= "nombre_ru_cts = '".mysqli_real_escape_string($inmoconn,$district->name_rus)."' ";
        $rsTipos = mysqli_query($inmoconn,$query_rsTipos) or die(mysqli_error());
        echo "<pre>";
        print_r($district);
        echo "</pre><hr>";
    }
}

// echo "<pre>";
// print_r($xml->district);
// echo "</pre>";
