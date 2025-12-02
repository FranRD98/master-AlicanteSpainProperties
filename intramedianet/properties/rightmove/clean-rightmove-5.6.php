<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

if (!function_exists('getRightmove')) {
    function getRightmove($url, $fields, $fields_string) {
        set_time_limit(0);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}

$jsonRightmove = array();

$jsonRightmove['network']['network_id'] = $rightmoveNetworkId;
$jsonRightmove['branch']['branch_id'] = $rightmoveBranchId;
$jsonRightmove['branch']['channel'] = 1;

$json = json_encode($jsonRightmove);

$fields = array (
    'json' => urlencode($json),
    'url' => urlencode('https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist')
);
foreach($fields as $key=>$value) {
    $fields_string .= $key.'='.$value.'&';
}
rtrim($fields_string, '&');

$result = getRightmove('https://curl.mediaelx.info/rightmove.php', $fields, $fields_string);

$result = explode(',', $result);

foreach ($result as $property) {

    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsFotocasaProperty = "SELECT * FROM `properties_properties` WHERE referencia_prop = '" . mysql_real_escape_string(str_replace('_', ' ', $property)) . "' AND activado_prop = 1  AND export_rightmove_prop = 1 AND descripcion_en_prop != '' AND export_rightmove_fields_prop != '' AND vendido_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND alquilado_prop = 0 AND force_hide_prop = 0";
    $rsFotocasaProperty = mysql_query($query_rsFotocasaProperty, $inmoconn) or die(mysql_error());
    $row_rsFotocasaProperty = mysql_fetch_assoc($rsFotocasaProperty);
    $totalRows_rsFotocasaProperty = mysql_num_rows($rsFotocasaProperty);

    if ($totalRows_rsFotocasaProperty == 0) {
        echo $property;
        echo "<hr>";

        $jsonRightmove['network']['network_id'] = $rightmoveNetworkId;
        $jsonRightmove['branch']['branch_id'] = $rightmoveBranchId;
        $jsonRightmove['branch']['channel'] = 1;
        $jsonRightmove['property']['agent_ref'] = $property;
        $jsonRightmove['property']['removal_reason'] = 7;
        $jsonRightmove['property']['transaction_date'] = date('d-m-Y');

        $jsonDel = json_encode($jsonRightmove);

        $fields = array (
            'json' => urlencode($jsonDel),
            'url' => urlencode('https://adfapi.rightmove.co.uk/v1/property/removeproperty')
        );
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');

        getRightmove('https://curl.mediaelx.info/rightmove.php', $fields, $fields_string);

    }

}