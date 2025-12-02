<?php 

/**
 * Smarty get_type_srch modifier plugin
 *
 * Type:     modifier<br>
 * Name:     get_type_srch<br>
 * Purpose:  convert string to get_type_srch
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

function smarty_modifier_get_type_srch($id) {
    global $lang;
    $return = getRecords("
        SELECT
            types_" . $lang . "_typ as ret
        FROM properties_types
        WHERE id_typ = '" . $id . "'
    ");
    return $return[0]['ret'];
}

?>