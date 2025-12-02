<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

if (!function_exists('sendRightmoveIMPRT')) {
    function sendRightmoveIMPRT($strJSON, $strURL, $strCertFile, $strCertPass, $boolDebug = false) {
        $resCurl = curl_init();

        if($boolDebug){
            curl_setopt($resCurl, CURLOPT_VERBOSE, 1);
        }

        curl_setopt($resCurl, CURLOPT_URL, $strURL);
        curl_setopt($resCurl, CURLOPT_CERTINFO, 1);
        curl_setopt($resCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($resCurl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($resCurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($resCurl, CURLOPT_FAILONERROR, 1);
        curl_setopt($resCurl, CURLOPT_SSLCERT, $strCertFile);
        curl_setopt($resCurl, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($resCurl, CURLOPT_SSLCERTPASSWD, $strCertPass);
        curl_setopt($resCurl, CURLOPT_POST, 1);
        curl_setopt($resCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($resCurl, CURLOPT_POSTFIELDS, $strJSON);
        $strResponse = curl_exec($resCurl);

        return json_decode($strResponse);
    }
}

$jsonRightmove = array();

$jsonRightmove['network']['network_id'] = $rightmoveNetworkId;
$jsonRightmove['branch']['branch_id'] = $rightmoveBranchId;
$jsonRightmove['branch']['channel'] = 1;

$json = json_encode($jsonRightmove);
$result =  sendRightmoveIMPRT($json, 'https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist', $rightmove_cert, $rightmove_cert_password, false);

foreach ($result->property as $property) {

    $query_rsFotocasaProperty = "SELECT * FROM `properties_properties` WHERE referencia_prop = '" . mysqli_real_escape_string($inmoconn, str_replace('_', ' ', $property->agent_ref)) . "' AND activado_prop = 1  AND export_rightmove_prop = 1 AND descripcion_en_prop != '' AND export_rightmove_fields_prop != '' AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop = 0";
    $rsFotocasaProperty = mysqli_query($inmoconn, $query_rsFotocasaProperty) or die(mysqli_error());
    $row_rsFotocasaProperty = mysqli_fetch_assoc($rsFotocasaProperty);
    $totalRows_rsFotocasaProperty = mysqli_num_rows($rsFotocasaProperty);

    if ($totalRows_rsFotocasaProperty == 0) {
        echo $property->agent_ref;
        echo "<hr>";

        $jsonRightmove['network']['network_id'] = $rightmoveNetworkId;
        $jsonRightmove['branch']['branch_id'] = $rightmoveBranchId;
        $jsonRightmove['branch']['channel'] = 1;
        $jsonRightmove['property']['agent_ref'] = $property->agent_ref;
        $jsonRightmove['property']['removal_reason'] = 7;
        $jsonRightmove['property']['transaction_date'] = date('d-m-Y');

        $jsonDel = json_encode($jsonRightmove);

        sendRightmoveIMPRT($jsonDel, 'https://adfapi.rightmove.co.uk/v1/property/removeproperty', $rightmove_cert, $rightmove_cert_password, false);
    }

}

// echo "<pre>";
// print_r($result);
// echo "</pre>";