<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty ultimos_resultados modifier plugin
 *
 * Type:     modifier<br>
 * Name:     ultimos_resultados<br>
 * Purpose:  convert string to ultimos_resultados
 * @author   Jose F. martinez
 * @param string
 * @return string
 */
function smarty_modifier_ultimos_resultados($file)
{

	$file = 'media/files/resultados/' . $file;

	if (($handle = fopen($file, "r")) !== FALSE) { 
	  $i = 0; 
	  while (($lineArray = fgetcsv($handle, 4000, ";")) !== FALSE) { 
	    for ($j=0; $j<count($lineArray); $j++) { 
	      $data2DArray[$i][$j] = $lineArray[$j]; 
	    } 
	    $i++; 
	  } 
	  fclose($handle); 
	}

	if ($data2DArray[1][0] == 'La Quiniela') {
		$string = '<strong>' . preg_replace('/ /', ', ', $data2DArray[1][10]) . '</strong>';
	}

	if ($data2DArray[1][0] == 'El Gordo') { 
		$string = '<strong>' . preg_replace('/ /', ', ', $data2DArray[1][10]) . '</strong> | <span class="primitiva">' . $data2DArray[1][11] . '</span>';
	}

	if ($data2DArray[1][0] == 'BonoLoto') {
		$string = '<strong>' . preg_replace('/ /', ', ', $data2DArray[1][10]) . '</strong>  | <span class="primitiva">' . $data2DArray[1][12] . '</span> | ' . ' <span class="el-gordo">' . $data2DArray[1][11] . '</span>';
	}

	if ($data2DArray[1][0] == 'Euromillones') {
		$string = '<strong>' . preg_replace('/ /', ', ', $data2DArray[1][10]) . '</strong> | <span class="primitiva">' . preg_replace('/[[:space:]]+/', ', ', $data2DArray[1][14]) . '</span>';
	}

	if ($data2DArray[1][0] == 'La Primitiva') {
		$string = '<strong>' . preg_replace('/ /', ', ', $data2DArray[1][10]) . '</strong> | <span class="primitiva">' . $data2DArray[1][12] . '</span>' . ' |  <span class="el-gordo">' . $data2DArray[1][11] . '</span>' . ' <br>  <span class="loteria-nacional">' . substr($data2DArray[1][20], 0, 1) . " " . substr($data2DArray[1][20], 1, 3) . " " . substr($data2DArray[1][20], 4) . '</span>';
	}

	if (mb_convert_encoding($data2DArray[1][0], 'UTF-8', 'ISO-8859-1') == 'Lotería Nacional') {
		$string = 'Primer premio: <strong>' . $data2DArray[1][16] . '</strong> <br> Especial: Fracción ' .  $data2DArray[1][18] . ' - Serie ' . $data2DArray[1][17];
		$string .= '<br>Segundo premio: ' . $data2DArray[1][19] . ' <br> Reintegros' .  $data2DArray[1][11];
	}




	return $string;
}

?>