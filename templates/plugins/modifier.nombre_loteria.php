<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty nombre_loteria modifier plugin
 *
 * Type:     modifier<br>
 * Name:     nombre_loteria<br>
 * Purpose:  convert string to nombre_loteria
 * @author   Jose F. martinez
 * @param string
 * @return string
 */
function smarty_modifier_nombre_loteria($string)
{
	

	if($string == 'Euromillones') {
		$string = '<span class="euromillones">' . $string . '</span>';
	} else if ($string == 'Primitiva') {
		$string = '<span class="primitiva">' . $string . '</span>';
	} else if ($string == 'Bonoloto') {
		$string = '<span class="primitiva">' . $string . '</span>';
	} else if ($string == 'El Gordo') {
		$string = '<span class="el-gordo">' . $string . '</span>';
	} else if ($string == 'La Quiniela') {
		$string = '<span class="la-quiniela">' . $string . '</span>';
	} else if ($string == 'Lotería Nacional') {
		$string = '<span class="loteria-nacional">' . $string . '</span>';
	} else if ($string == 'Once') {
		$string = '<span class="once">' . $string . '</span>';
	} else if ($string == 'Euro Jackpot') {
		$string = '<span class="euro-jackpot">' . $string . '</span>';
	} else {
		$string = '<span>' . $string . '</span>';
	}



	return $string;
}

?>