<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// URL
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if((isset($_GET['q'])) && ($_GET['q']!='')){ 
    $tokens = explode('/', $_GET['q']);
    $smarty->assign('tokens', $tokens);
    $seccion = $tokens[0];
    $smarty->assign('seccion', $seccion);
}

// echo '<pre>';
// print_r($tokens);
// echo '</pre>';

// echo $tokens[0];

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Idiomas
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ( (isset($_GET['lang'])) && ($_GET['lang'] != '') && (!in_array($_GET['lang'], $languages))) {
	    die("Idioma no permitido");
	}

	if ( (isset($_GET['lang'])) && ($_GET['lang'] == $language) && (!preg_match('/\.html/', $_SERVER['REQUEST_URI']))) {
	    header("HTTP/1.1 301 Moved Permanently");
	    header("Location: " . str_replace('/' . $_GET['lang'] . '/', '/', $_SERVER['REQUEST_URI']));
	}

    // mysqli_real_escape_string();

	// URL helper
	$urlStart = '/';

	if(@isset($_GET['lang']) && $_GET['lang'] != '' && $_GET['lang'] != $language) {
		$urlStart = '/' . $_GET['lang'] . '/';
	}

	$smarty->assign("urlStart", $urlStart);

	// if (isset($_COOKIE['lang']) && !isset($_GET['lang'])) {
	// 	setcookie('lang',$_COOKIE['lang'], mktime(21,00,0,12,31,2030),"/","",0);
	// 	header ('HTTP/1.1 301 Moved Permanently');
	// 	header("Location: /".$_COOKIE['lang'].'/');
	// }

	// Declaramos variables
	if(!isset($_GET['lang'])) {
		$lang = $language;
		setcookie('lang','', mktime(21,00,0,12,31,2000),"/", "",0);
	} else {
		$lang = ($_GET['lang']).'';
		setcookie('lang',$lang, mktime(21,00,0,12,31,2030),"/", "",0);
	}

	$smarty->assign("lang", $lang);

    // Cargamos las urls
    include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

    foreach ($urlStr as $key => $urls) {
        foreach ($urls as $langval => $urlval) {
            $smarty->assign('url_' . cleanTrad($key) .'_' . $langval, $urlval);
            if ($langval == $lang) {
                $smarty->assign('url_' . cleanTrad($key) .'', $urlval);
                $urlStr[$key]['url'] = $urlval;
                $urlStr[$urlStr[$key][$langval]]['master'] = $key;
                // $smarty->assign('url_key', $key);

            }
        }
    }

    

    // $urlStr['key'] = $urlStr[$seccion][$lang];

    // Cargamos los textos
    include($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$lang.".php");

    foreach ($langStr as $key => $value) {
        $smarty->assign('lng_' . cleanTrad($key), $value);
    }

	//echo $_SERVER['REQUEST_URI'];

	if (!strpos($_SERVER['REQUEST_URI'],'.html')) {

        // echo $_SERVER['REQUEST_URI'] . '<hr>';

        // echo "<hr>";
        // echo $urlStr[$seccion]['master'];
        // echo "<hr>";
        // echo $urlStr[$urlStr[$seccion]['master']][$lang];
        // echo "<hr>";
        // echo '$urlStr[\''.$urlStr[$seccion]['master'].'\'][\''.$lang.'\']';
        // echo "<hr>";

        //var_dump($urlStr); die;

        if(isset($seccion) && isset($urlStr[$seccion]))
		    $smarty->assign('seccion_master', $urlStr[$seccion]['master']);

		if ($urlStart == '/' && isset($urlStr[$seccion]) && isset($urlStr[$urlStr[$seccion]['master']])) {

            $urlDefault = '' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']][$language] . '/', $_SERVER['REQUEST_URI']);
            

            $urlCA = '/ca' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['ca'] . '/', $_SERVER['REQUEST_URI']);
            $urlDA = '/da' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['da'] . '/', $_SERVER['REQUEST_URI']);
            $urlDE = '/de' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['de'] . '/', $_SERVER['REQUEST_URI']);
            //$urlEL = '/el' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['el'] . '/', $_SERVER['REQUEST_URI']);
            $urlEN = '/en' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['en'] . '/', $_SERVER['REQUEST_URI']);
            $urlES = '/es' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['es'] . '/', $_SERVER['REQUEST_URI']);
            $urlFI = '/fi' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['fi'] . '/', $_SERVER['REQUEST_URI']);
            $urlFR = '/fr' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['fr'] . '/', $_SERVER['REQUEST_URI']);
            $urlIS = '/is' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['is'] . '/', $_SERVER['REQUEST_URI']);
            //$urlIT = '/it' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['it'] . '/', $_SERVER['REQUEST_URI']);
            $urlNL = '/nl' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['nl'] . '/', $_SERVER['REQUEST_URI']);
            $urlNO = '/no' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['no'] . '/', $_SERVER['REQUEST_URI']);
            //$urlPT = '/pt' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['pt'] . '/', $_SERVER['REQUEST_URI']);
            $urlRU = '/ru' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['ru'] . '/', $_SERVER['REQUEST_URI']);
            $urlSE = '/se' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['se'] . '/', $_SERVER['REQUEST_URI']);
            $urlZH = '/zh' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['zh'] . '/', $_SERVER['REQUEST_URI']);
            $urlPL = '/pl' . preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['pl'] . '/', $_SERVER['REQUEST_URI']);

		} else {

            if(isset($urlStr[$seccion])){
                $urlDefault = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']][$language] . '/', $_SERVER['REQUEST_URI']));

                $urlCA = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/ca/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['ca'] . '/', $_SERVER['REQUEST_URI']));
                $urlDA = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/da/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['da'] . '/', $_SERVER['REQUEST_URI']));
                $urlDE = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/de/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['de'] . '/', $_SERVER['REQUEST_URI']));
                
                //$urlEL = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/el/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['el'] . '/', $_SERVER['REQUEST_URI']));
                
                $urlEN = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/en/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['en'] . '/', $_SERVER['REQUEST_URI']));
                $urlES = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/es/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['es'] . '/', $_SERVER['REQUEST_URI']));
                $urlFI = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/fi/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['fi'] . '/', $_SERVER['REQUEST_URI']));
                $urlFR = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/fr/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['fr'] . '/', $_SERVER['REQUEST_URI']));
                $urlIS = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/is/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['is'] . '/', $_SERVER['REQUEST_URI']));
                //$urlIT = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/it/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['it'] . '/', $_SERVER['REQUEST_URI']));
                $urlNL = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/nl/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['nl'] . '/', $_SERVER['REQUEST_URI']));
                $urlNO = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/no/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['no'] . '/', $_SERVER['REQUEST_URI']));
                //$urlPT = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/pt/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['pt'] . '/', $_SERVER['REQUEST_URI']));
                $urlRU = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/ru/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['ru'] . '/', $_SERVER['REQUEST_URI']));
                $urlSE = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/se/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['se'] . '/', $_SERVER['REQUEST_URI']));
                $urlZH = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/zh/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['zh'] . '/', $_SERVER['REQUEST_URI']));
                $urlPL = preg_replace('/\/(ca|da|de|el|en|es|fi|fr|is|it|nl|no|pt|ru|se|zh|pl)\//', '/pl/', preg_replace('/\/'.$urlStr[$urlStr[$seccion]['master']][$lang].'\//', '/' . $urlStr[$urlStr[$seccion]['master']]['pl'] . '/', $_SERVER['REQUEST_URI']));
            }else{
                $urlDefault = $seccion;
                $urlCA = '';
                $urlDA = '';
                $urlDE = '';
                $urlEL = '';
                $urlEN = '';
                $urlES = '';
                $urlFI = '';
                $urlFR = '';
                $urlIS = '';
                $urlIT = '';
                $urlNL = '';
                $urlNO = '';
                $urlPT = '';
                $urlRU = '';
                $urlSE = '';
                $urlZH = '';
                $urlPL ='';
            }
		}

	} else {

		$urlDefault = '/';
		$urlCA = '/ca';
		$urlDA = '/da';
		$urlDE = '/de';
		$urlEL = '/el';
		$urlEN = '/en';
		$urlES = '/es';
		$urlFI = '/fi';
		$urlFR = '/fr';
		$urlIS = '/is';
		$urlIT = '/it';
		$urlNL = '/nl';
		$urlNO = '/no';
		$urlPT = '/pt';
		$urlRU = '/ru';
		$urlSE = '/se';
		$urlZH = '/zh';
		$urlPL = '/pl';

	}





    $smarty->assign('urlDefault', $urlDefault);
    $smarty->assign('urlCA', $urlCA);
    $smarty->assign('urlDA', $urlDA);
    $smarty->assign('urlDE', $urlDE);
    //$smarty->assign('urlEL', $urlEL);
    $smarty->assign('urlEN', $urlEN);
    $smarty->assign('urlES', $urlES);
    $smarty->assign('urlFI', $urlFI);
    $smarty->assign('urlFR', $urlFR);
    $smarty->assign('urlIS', $urlIS);
    //$smarty->assign('urlIT', $urlIT);
    $smarty->assign('urlNL', $urlNL);
    $smarty->assign('urlNO', $urlNO);
    //$smarty->assign('urlPT', $urlPT);
    $smarty->assign('urlRU', $urlRU);
    $smarty->assign('urlSE', $urlSE);
    $smarty->assign('urlZH', $urlZH);
    $smarty->assign('urlPL', $urlPL);

    if ($lang == 'ca') {
		setlocale(LC_ALL, 'ca_ES.UTF-8');
	}
	if ($lang == 'da') {
		setlocale(LC_ALL, 'da_DK.UTF-8');
	}
	if ($lang == 'de') {
		setlocale(LC_ALL, 'de_DE.UTF-8');
	}
	if ($lang == 'el') {
		setlocale(LC_ALL, 'el_GR.UTF-8');
	}
	if ($lang == 'en') {
		setlocale(LC_ALL, 'en_GB.UTF-8');
	}
	if ($lang == 'es') {
		setlocale(LC_ALL, 'es_ES.UTF-8');
	}
	if ($lang == 'fi') {
		setlocale(LC_ALL, 'fi_FI.UTF-8');
	}
	if ($lang == 'fr') {
		setlocale(LC_ALL, 'fr_FR.UTF-8');
	}
	if ($lang == 'is') {
		setlocale(LC_ALL, 'is_IS.UTF-8');
	}
	if ($lang == 'it') {
		setlocale(LC_ALL, 'it_IT.UTF-8');
	}
	if ($lang == 'nl') {
		setlocale(LC_ALL, 'nl_NL.UTF-8');
	}
	if ($lang == 'no') {
		setlocale(LC_ALL, 'no_NO.UTF-8');
	}
	if ($lang == 'pt') {
		setlocale(LC_ALL, 'pt_PT.UTF-8');
	}
	if ($lang == 'ru') {
		setlocale(LC_ALL, 'ru_RU.UTF-8');
	}
	if ($lang == 'se') {
		setlocale(LC_ALL, 'de_CH.UTF-8');
	}
	if ($lang == 'zh') {
		setlocale(LC_ALL, 'zh_CN.UTF-8');
	}
	if ($lang == 'pl') {
		setlocale(LC_ALL, 'pl_PL.UTF-8');
	}

	$seoCA = 'ca';
	$seoDA = 'da';
	$seoDE = 'de';
	$seoEL = 'el';
	$seoEN = 'en';
	$seoES = 'es';
	$seoFI = 'fi';
	$seoFR = 'fr';
	$seoIS = 'is';
	$seoIT = 'it';
	$seoNL = 'nl';
	$seoNO = 'no';
	$seoPT = 'pt';
	$seoRU = 'ru';
	$seoSE = 'se';
	$seoZH = 'zh';
	$seoPL = 'pl';

	$smarty->assign('seoCA', $seoCA);
	$smarty->assign('seoDA', $seoDA);
	$smarty->assign('seoDE', $seoDE);
	$smarty->assign('seoEL', $seoEL);
	$smarty->assign('seoEN', $seoEN);
	$smarty->assign('seoES', $seoES);
	$smarty->assign('seoFI', $seoFI);
	$smarty->assign('seoFR', $seoFR);
	$smarty->assign('seoIS', $seoIS);
	$smarty->assign('seoIT', $seoIT);
	$smarty->assign('seoNL', $seoNL);
	$smarty->assign('seoNO', $seoNO);
	$smarty->assign('seoPT', $seoPT);
	$smarty->assign('seoRU', $seoRU);
	$smarty->assign('seoSE', $seoSE);
	$smarty->assign('seoZH', $seoZH);
	$smarty->assign('seoPL', $seoPL);



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Slug
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function slug($str, $options = array())
{

  $str = preg_replace('/[\x{1F600}-\x{1F64F}' . // Emoticons
              '\x{1F300}-\x{1F5FF}' . // Symbols & Pictographs
              '\x{1F680}-\x{1F6FF}' . // Transport & Map
              '\x{2600}-\x{26FF}' .   // Misc symbols
              '\x{2700}-\x{27BF}' .   // Dingbats
              '\x{1F900}-\x{1F9FF}' . // Supplemental Symbols
              '\x{1F1E6}-\x{1F1FF}' . // Flags
              '\x{25B7}]/u', '', $str); //  White Right-Pointing Triang
      // Make sure string is in UTF-8 and strip invalid UTF-8 characters
  $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

  $defaults = array(
    'delimiter' => '-',
    'limit' => null,
    'lowercase' => true,
    'replacements' => array(),
    'transliterate' => true,
  );

  // Merge options
  $options = array_merge($defaults, $options);

  $char_map = array(
    // Latin
    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
    'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
    'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
    'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
    'ß' => 'ss',
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
    'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
    'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
    'ÿ' => 'y',

    // Latin symbols
    '©' => '(c)',
    //'▷' => '->',
    '笆ｷ' => '▷',

    // Greek
    'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
    'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
    'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
    'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
    'Ϋ' => 'Y',
    'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
    'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
    'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
    'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
    'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

    // Turkish
    'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
    'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

    // Russian
    'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
    'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
    'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
    'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
    'Я' => 'Ya',
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
    'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
    'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
    'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
    'я' => 'ya',

    // Ukrainian
    'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
    'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

    // Czech
    'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
    'Ž' => 'Z',
    'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
    'ž' => 'z',

    // Polish
    'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
    'Ż' => 'Z',
    'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
    'ż' => 'z',

    // Latvian
    'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
    'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
    'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
    'š' => 's', 'ū' => 'u', 'ž' => 'z'
  );

  // Make custom replacements
  $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

  // Transliterate characters to ASCII
  if ($options['transliterate']) {
    $str = str_replace(array_keys($char_map), $char_map, $str);
  }

  // Replace non-alphanumeric characters with our delimiter
  $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

  $str = str_replace('º', '', $str);

  // Remove duplicate delimiters
  $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

  // Truncate slug to max. characters
  $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

  // Remove delimiter from ends
  $str = trim($str, $options['delimiter']);

  return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;

}
