<?php 

/**
 * Smarty get_type_pool modifier plugin
 *
 * Type:     modifier<br>
 * Name:     get_type_pool<br>
 * Purpose:  convert string to get_type_pool
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

function smarty_modifier_get_type_pool($id) {
    global $lang;
    $return = getRecords("
        SELECT
            pool_" . $lang . "_pl as ret
        FROM properties_pool
        WHERE id_pl = '" . $id . "'
    ");
    return $return[0]['ret'];
}

?>