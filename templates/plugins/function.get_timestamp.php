<?php 

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {preg_match} function plugin
 *
 * Type:     function<br>
 * Name:     preg_match<br>
 * Purpose:  offers php preg_match function inside a template
 * @author Eduardo Bravo
 * @param array parameters
 * @param object $template template object
 * @return boolean, matches array in template
 */


function smarty_function_get_timestamp($params) {

    $month = isset($params['month']) ? (int)$params['month'] : 1;
    $day = isset($params['day']) ? (int)$params['day'] : 1;
    $year = isset($params['year']) ? (int)$params['year'] : date('Y');

    return mktime(0, 0, 0, $month, $day, $year);
}

?>