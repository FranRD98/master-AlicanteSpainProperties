<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty decrypt modifier plugin
 *
 * Type:     modifier<br>
 * Name:     decrypt<br>
 * Purpose:  decrypt string
 *  
 * @author  Jose F. Martinez
 * @param   string
 * @return  string
 */
function smarty_modifier_decrypt($string)
{
    $key = "QGMpu6QbzmRGbcCvDhLerbWzEJy)wMbcMIFIN7tEHFYkVpjIjk";
    $key = md5($key, true);
    $iv = substr($key, 0, 16); // Ajusta el vector de inicialización

    $decrypted = openssl_decrypt(
        base64_decode(strtr($string, '-_,', '+/=')),
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    if ($decrypted === false) {
        return false; // La desencriptación falló
    }

    $string = unserialize(rtrim($decrypted, "\0"));

    return $string;
}


?>