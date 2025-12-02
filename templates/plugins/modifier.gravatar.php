<?php 
# http://www.marvinmarcelo.com/smarty-gravatar-plugin/ 
/** 
 * Gravatar 
 * 
 * @link http://www.marvinmarcelo.com 
 * 
 * @param array $params 
 * @param Smarty $smarty 
 */ 
function smarty_modifier_gravatar($email='') 
{ 
  /** 
   * constant $gravatar_host 
   */ 
  $gravatar_host = "http://www.gravatar.com/avatar/"; 
  
  /** 
   * @link http://en.gravatar.com/site/implement/url 
   */ 
  $hash = strtolower(md5(trim($email))); 
  $src = $gravatar_host . $hash . ".jpg?"; 
    
   $size = 60; 
   $src .= "s={$size}"; 

   $default = "mm"; 
   $src .= "&d={$default}"; 

   $rating = "G"; 
   $src .= "&r={$rating}"; 
    
   $extras = ""; 
    
  return "<img src=\"$src\" class=\"img-polaroid img-rounded\" />"; 
} 

?>