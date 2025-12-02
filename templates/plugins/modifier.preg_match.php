<?php

function smarty_modifier_preg_match($pattern, $subject) {
    return preg_match($pattern, $subject);
}
?>
