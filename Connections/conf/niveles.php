<?php

/*--------------------------------------------------------------------------
/* @group Activar los Empleados de la web */
/*--------------------------------------------------------------------------
|
| Activar los Empleados
|
*/

$actEmpleados = 1;

/*--------------------------------------------------------------------------
/* @group Activar los Agente de la web */
/*--------------------------------------------------------------------------
|
| Activar los Agente
|
*/

$actAgente = 1;

/*--------------------------------------------------------------------------
/* @group Activar los Usuarios de la web (usuarios web para el registro desde web) */
/*--------------------------------------------------------------------------
|
| Activar los usuarios
|
*/

$actUsuarios = 1;


/*--------------------------------------------------------------------------
/* @group Activar el login/register para guardar búsquedas en el front  */
/*--------------------------------------------------------------------------
|
| Activar el login/register. Hay que activar también los Usuarios web ($actUsuarios)
|
*/

$actRegister = 1;

If($actLestinmo == 1) {
    $actEmpleados = 0;
    $actAgente = 0;
    $actUsuarios = 0;
    $actRegister = 0;
}
