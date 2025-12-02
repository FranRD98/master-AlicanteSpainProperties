<?php

function smarty_modifier_sprintf($string, ...$args)
{
    return vsprintf($string, $args);
}

?>
