<?php

/**
 * Smarty modifier_urlencode modifier plugin
 *
 * Type:     modifier<br>
 * Name:     modifier_urlencode<br>
 * Purpose:  convert string to modifier_urlencode
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

function smarty_modifier_urlencode($string)
{
    return urlencode($string);
}
?>
