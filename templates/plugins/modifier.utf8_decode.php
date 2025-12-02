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

function smarty_modifier_utf8_decode($string) {
    return utf8_decode($string);
}

?>