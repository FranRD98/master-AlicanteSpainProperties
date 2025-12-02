<?php 
// En algún archivo PHP incluido en tu entorno de Smarty
function smarty_modifier_getFromArray($array, $index, $key1, $key2) {
    // Lógica para obtener el valor del array
    // Ejemplo básico:
    return isset($array[$index][$key1][$key2]) ? $array[$index][$key1][$key2] : '';
}

?>