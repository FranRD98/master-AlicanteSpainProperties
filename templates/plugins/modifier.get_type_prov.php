<?php 

/**
 * Smarty get_type_prov modifier plugin
 *
 * Type:     modifier<br>
 * Name:     get_type_prov<br>
 * Purpose:  convert string to get_type_prov
 * @author   Eduardo Bravo
 * @param string
 * @return string
 */

 function smarty_modifier_get_type_prov($id) {
    global $lang;
    $return = getRecords("
        SELECT
            name_" . $lang . "_loc2 as ret
        FROM properties_loc2
        WHERE id_loc2 = '" . $id . "'
    ");
    return $return[0]['ret'];
}


?>