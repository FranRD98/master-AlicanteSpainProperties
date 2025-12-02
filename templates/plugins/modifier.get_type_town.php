<?php 

/**
 * Smarty get_type_town modifier plugin
 *
 * Type:     modifier<br>
 * Name:     get_type_town<br>
 * Purpose:  convert string to get_type_town
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

function smarty_modifier_get_type_town($id) {
    global $lang;
    $return = getRecords("
        SELECT
            name_" . $lang . "_loc3 as ret
        FROM properties_loc3
        WHERE id_loc3 = '" . $id . "'
    ");
    return $return[0]['ret'];
}


?>