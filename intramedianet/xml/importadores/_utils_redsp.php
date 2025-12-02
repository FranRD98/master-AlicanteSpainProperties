<?php

// Comprobamos si ha cargado el xml correctamente
if (!function_exists("checkXMLREDSP")) {
    function checkXMLREDSP($xml) {
        $redsp_version = $xml->redsp->feed_version;
        $first_id = $xml->property->id;
        if ($redsp_version == '' || $first_id == '') {
            return false;
        }
        return true;
    }
}

// Comprobamos si la propiedad tiene los campos necesarios
if (!function_exists("checkPropertyREDSP")) {
    function checkPropertyREDSP($xml) {
        global $kyero_version;
        $first_id = (string)$xml->id;
        $ref = (string)$xml->ref;
        $price = (string)$xml->price;
        $price_freq = (string)$xml->price_freq;
        $type = (string)$xml->type;
        $town = $xml->address->town;
        $province = $xml->address->province;
        if (
            trim($first_id) == '' ||
            trim($ref) == '' ||
            trim($price) == '' ||
            trim($price_freq) == '' ||
            trim($type) == '' ||
            trim($town) == '' ||
            trim($province) == ''
        ) {
            return false;
        }
        return true;
    }
}

// Obtener el status de la propiedad
if (!function_exists("getStatusKyero")) {
    function getStatusKyero($status, $new_build) {
        global $statusID;
        switch (trim($status)) {
            case 'sale':
                $statusID = "1";
                break;
            case 'new_build':
                $statusID = "2";
                break;
            case 'week':
                $statusID = "3";
                break;
            case 'month':
                $statusID = "4";
                break;
            default:
                $statusID = "1";
                break;
        }
        if ($new_build == '1') {
            $statusID = "2";
        }
        return $statusID;
    }
}




