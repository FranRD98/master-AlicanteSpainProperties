<?php

/*--------------------------------------------------------------------------
/* @group Tamaño de las miniaturas */
/*--------------------------------------------------------------------------
|
| Array con los tamaños de las miniaturas de la web
| Se pueden añadir si se necesitan más tamaños.
|
*/

$thumbnailsSizes = array(
        'xl' => array('1920', '1280'),
        'lg' => array('1290', '840'),
        'md' => array('560', '380'),
        'sm' => array('200', '160'),
        // 'xx' => array('1280', '1024'),
);

/*--------------------------------------------------------------------------
/* @group Calidad las miniaturas */
/*--------------------------------------------------------------------------
|
| La calidad de las imágenes generadas
|
*/

$thumbnailsQuality = 85;

/*--------------------------------------------------------------------------
/* @group Color fondo de las miniaturas */
/*--------------------------------------------------------------------------
|
| El color de fondo del relleno de las imágenes verticales
|
*/

$thumbnailsBackground = '#ffffff';

/*--------------------------------------------------------------------------
/* @group Marca de agua */
/*--------------------------------------------------------------------------
|
| Activar la marca de agua para las imágenes
| 0 - Desactivado
| 1 - Activado para todas
|
| Se han de borrar todas las miniaturas desde check.php cada vez que se
| cambie esta preferencia
|
*/

$actWatermark = 0;

/*--------------------------------------------------------------------------
/* @group Opacidad de la marca de agua */
/*--------------------------------------------------------------------------
|
| Opacidad de la marca de agua
|
*/

$watermarkOpacity = 0.7;

/*--------------------------------------------------------------------------
/* @group Posición de la marca de agua */
/*--------------------------------------------------------------------------
|
| Posición de la marca de agua, posibles valores:
| center
| top
| bottom
| left
| right
| top left
| top right
| bottom left
| bottom right
|
*/

$watermarkPosition = 'bottom right';

