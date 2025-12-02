<?php
function smarty_modifier_getFileTime($file)
{
    if (file_exists($file)) {
        return filemtime($file);
    }
    return '0';
}
?>
