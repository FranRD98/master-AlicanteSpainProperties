<?php

/*--------------------------------------------------------------------------
/* @group Activar xml */
/*--------------------------------------------------------------------------
|
| Activar la importación de xml en la aplicación
| 0 - Desactivado
| 1 - Activado
|
*/

$xmlImport = 1;

If($actLestinmo == 1) {
    $xmlImport = 1;
}

/*--------------------------------------------------------------------------
/* @group Desactivar inmuebles desactivados */
/*--------------------------------------------------------------------------
|
| Desactivar inmuebles desactivados una vez se importe un xml
|
*/

$desactivar_desactivados = 0;  // NO PONER A 1 NUNCA, AHORA HAY OTRO METODO PARA OCULTAR

/*--------------------------------------------------------------------------
/* @group Mapeo */
/*--------------------------------------------------------------------------
|
| Activar el mapeo en localización, tipos y opciones
| 0 - Desactivado
| 1 - Activado
|
*/

$mapeo = 0;
if ($xmlImport == 1) {
    $mapeo = 1;
}
