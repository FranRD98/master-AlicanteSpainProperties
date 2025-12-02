<?php 

/**
 * Smarty get_coast modifier plugin
 *
 * Type:     modifier<br>
 * Name:     get_coast<br>
 * Purpose:  convert string to get_coast
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

function smarty_modifier_get_coast($id) {
    global $lang;
    $return = getRecords("
        SELECT
            coast_" . $lang . "_cst as ret
        FROM properties_coast
        WHERE id_cst = '" . $id . "'
    ");
    return $return[0]['ret'];
}

?>