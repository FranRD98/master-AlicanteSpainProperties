<?php
function smarty_function_check_file_exists($params) {
    if (!isset($params['file'])) {
        if(isset($params)){
            $file = $params;
        }else{
            return false;
        }
    }else{
        $file = $params['file'];
    }
    
    if (file_exists($file)) {
        return true;
    } else {
        return false;
    }
}
?>
