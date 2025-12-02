<?php 

/**
 * Smarty utf8_decode modifier plugin
 *
 * Type:     modifier<br>
 * Name:     utf8_decode<br>
 * Purpose:  convert string to utf8_decode
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

function smarty_modifier_mes($timestamp){
    //var_dump($timestamp);
    setlocale(LC_TIME, 'es_ES.UTF-8'); 
    return ucfirst(strftime('%B', $timestamp));
    //return date("F", $timestamp);
    //$mes = date("F", $timestamp);
    //var_dump($mes);
    //return $mes;
}
?>