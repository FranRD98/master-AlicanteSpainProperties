<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty encrypt modifier plugin
 *
 * Type:     modifier<br>
 * Name:     encrypt<br>
 * Purpose:  encrypt string
 *  
 * @author  Jose F. Martinez
 * @param   string
 * @return  string
 */
function smarty_modifier_encrypt($string)
{
    $key = "QGMpu6QbzmRGbcCvDhLerbWzEJy)wMbcMIFIN7tEHFYkVpjIjk";
    $key = md5($key, true);
    $iv = substr($key, 0, 16); // Ajusta el vector de inicialización

    $encrypted = openssl_encrypt(
        serialize($string),
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    if ($encrypted === false) {
        return false; // La encriptación falló
    }

    $string = strtr(base64_encode($encrypted), '+/=', '-_,');

    return $string;
}


?>