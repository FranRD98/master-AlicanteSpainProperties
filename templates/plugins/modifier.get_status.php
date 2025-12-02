<?php

/**
 * Smarty get_status modifier plugin
 *
 * Type:     modifier<br>
 * Name:     get_status<br>
 * Purpose:  convert string to get_status
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

function smarty_modifier_get_status($id) {
    global $lang;
    if(!isset($lang)) $lang='es';
    $return = getRecords("
        SELECT
            status_" . $lang . "_sta as ret
        FROM properties_status
        WHERE id_sta = '" . $id . "'
    ");
    if(isset($return[0]['ret']))
        return $return[0]['ret'];
    else
        return false;
}
?>