<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty social modifier plugin
 *
 * Type:     modifier<br>
 * Name:     social<br>
 * Purpose:  social string
 *
 * @author  Jose F. Martinez
 * @param   string
 * @return  string
 */

use COI\Social;

function smarty_modifier_social($url, $ttle, &$smarty)
{

    global $usrTwitter;

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/socializer/include.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/socializer/require.php');




$socialManager = new Social\Manager(array(
    'facebook' => new Social\Facebook(),
    'linkedIn' => new Social\LinkedIn(),
    'twitter' => new Social\Twitter(array(
        'username' => $usrTwitter,
    )),
    'googleplus' => new Social\GooglePlus(array(
        'size' => 'medium'
    )),
    // 'stumbleUpon' => new Social\StumbleUpon(),
    // 'pinterest' => new Social\Pinterest()
), array(
    'fadeIn' => 1000
));



//$smarty->assign("socialjs", COI\Social\Manager::combinedJavaScript());

echo COI\Social\Manager::combinedJavaScript();

/* Where the buttons should be displayed */
return $socialManager->render(array(
    // These options override those used in the manager initialisation above
    'url' => $url,
    'title' => $title,
));


}

?>