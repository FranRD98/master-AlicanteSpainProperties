<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Buyers log
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function logBuyer($user, $id, $ref, $action) {
    global $database_inmoconn, $inmoconn;
    $query_rsProp = "INSERT INTO `properties_client_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '".$user."', '".$id."', '".mysqli_real_escape_string($inmoconn,$ref)."', '".$action."', '".date("Y-m-d H:i:s")."')";
    $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vendors log
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function logVendor($user, $id, $ref, $action) {
    global $database_inmoconn, $inmoconn;
    $query_rsProp = "INSERT INTO `properties_owner_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, '".$user."', '".$id."', '".mysqli_real_escape_string($inmoconn,$ref)."', '".$action."', '".date("Y-m-d H:i:s")."')";
    $rsProp = mysqli_query($inmoconn, $query_rsProp) or die(mysqli_error());
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Lightens/darkens a given colour
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function color_luminance( $hex, $percent ) {

    // validate hex string

    $hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
    $new_hex = '#';

    if ( strlen( $hex ) < 6 ) {
        $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
    }

    // convert to decimal and change luminosity
    for ($i = 0; $i < 3; $i++) {
        $dec = hexdec( substr( $hex, $i*2, 2 ) );
        $dec = min( max( 0, $dec + $dec * $percent ), 255 );
        $new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
    }

    return $new_hex;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// get from Array
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getFromArray($array, $id, $fieldId, $field) {
    foreach ($array as $value) {
        if ($value[$fieldId] == $id) {
            return $value[$field];
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get file creation time
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getFileTime($file) {
    return filemtime($file);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send Email
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function sendAppEmail($to, $cc, $bcc, $replyTo, $subject, $body)
{
    global $smtpUrl, $smtpPort, $smtpUser, $smtpPass, $fromMail, $_SESSION, $_SERVER, $fromName;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

    $fromMailVal = $fromMail;
    if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info') {
        $hostval = '/' . $_SERVER['HTTP_HOST'] . '/';
        if (isset($_SESSION['kt_login_user']) && $_SESSION['kt_login_user'] != '' && preg_match($hostval, strtolower($_SESSION['kt_login_user']))) {
            $fromMailVal = $_SESSION['kt_login_user'];
        }
    }

    $transport = Swift_SmtpTransport::newInstance($smtpUrl, $smtpPort, 'ssl')
        ->setUsername($smtpUser)
        ->setPassword($smtpPass)
    ;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance()
        ->setSubject($subject)
        ->setFrom(array($fromMailVal => $fromName))
        ->setTo($to)
        ->setBody($body, 'text/html')
    ;

    if ($cc != '') { $message->setCc($cc); }

    if ($bcc != '') { $message->setBcc($bcc); }

    if ($replyTo != '') { $message->setReplyTo($replyTo); }

    $result = $mailer->send($message);

    return $fromMail;

}

function getBodyTemplate($template){
    global $langStr, $mailColor, $mailSecondaryColor;
    ob_start();
    include($_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/'.$template);
    $html = ob_get_contents();
    ob_end_clean();

    $footer = $langStr["Estás recibiendo este email porque solicitaste información o te suscribiste voluntariamente a nuestras comunicaciones comerciales."] . '<br>';
    $footer .= $langStr["Responsable"] . ': <strong>' . $nombreEmpresa . '</strong> | ' . $direccionEmpresa . '.<br>';
    $footer .= $langStr["Consulta aquí nuestra"] . ' <a href="https://' . $_SERVER['HTTP_HOST'] . '' . $urlstart . '' . $urlStr['privacy'][$_GET['lang']] . '" style="color: #000; text-decoration: none; font-weight: bold;">' . $langStr["Política de Privacidad"] . '</a>.<br>';

    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{FOOTER}/', $footer, $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
    return $html;
}

function getBodyWelcome($template,$name){
    global $langStr, $mailColor, $mailSecondaryColor;
    $html = getBodyTemplate($template); 

    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $langStr["Estos son sus datos de acceso a la zona privada"] . ' - {SERVER.HTTP_HOST}';
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= '<p>' . $langStr["Estimado"] . ' {NAMECLI} </p>';
                    $body .= '<p>' . $langStr["Hemos registrado correctamente sus datos.<br>¡Gracias de antemano por su interés!"] . ':</p>';
                    $body .= '<br><p>' . $langStr["Saludos cordiales."]  . ':</p>';

                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    $html = preg_replace('/{CONTENT}/', $body , $html);
    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
    $html = preg_replace('/{NAMECLI}/', $name , $html);

    return $html;
}

function getBodyNewUser($template,$user,$passs,$url){
    global $langStr, $mailColor, $mailSecondaryColor;
    $html = getBodyTemplate($template);

    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $langStr["Estos son sus datos de acceso a la zona privada"] . ' - {SERVER.HTTP_HOST}';
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= '<p>' . $langStr["Confirmamos sus datos de acceso"] . ':</p>';
                    $body .= '<p><b>' . $langStr["Email"]  . ':</b> {kt_login_user}</p>';
                    $body .= '<p><b>' . $langStr["Contraseña"] . ':</b> {kt_login_password}</p>';
                    $body .= '<p>' . $langStr["Para acceder a la zona privada de la web, haga clic en el siguiente enlace"] . ':</p>';
                    $body .= '<p> <a href="{kt_login_page}" style="background-color: {COLOR}; color: #fff; padding: 15px 20px; text-decoration: none; border-radius: 223px; display: inline-block; border-radius: 23px; display: block; max-width: 100%; text-align: center; font-size: 16px;">' . $langStr["Acceder a la zona privada del sitio web"] . '</a></p>';
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    $html = preg_replace('/{CONTENT}/', $body , $html);
    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
    $html = preg_replace('/{kt_login_user}/', $user , $html);
    $html = preg_replace('/{kt_login_password}/', $passs , $html);
    $html = preg_replace('/{kt_login_page}/', $url , $html);
    return $html;
}

function getBodyNewUserCopy($template,$user,$name){
    global $langStr, $mailColor, $mailSecondaryColor;
    $html = getBodyTemplate($template);

    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $langStr["Nuevo usuario web"] . ' - {SERVER.HTTP_HOST}';
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= '<p>' . $langStr["Datos de acceso"] . ':</p>';
                    $body .= '<p><b>' . $langStr["Nombre"]  . ':</b> {nombre_usr}</p>';
                    $body .= '<p><b>' . $langStr["Email"] . ':</b> {kt_login_user}</p>';
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    $html = preg_replace('/{CONTENT}/', $body , $html);
    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
    $html = preg_replace('/{kt_login_user}/', $user , $html);
    $html = preg_replace('/{nombre_usr}/', $name , $html);
    return $html;
}

function getBodyForgotUser($template,$user,$pass,$url){
    global $langStr, $mailColor, $mailSecondaryColor;
    $html = getBodyTemplate($template);

    $body  = '';
    $body .= '<!-- Título -->';
    $body .= '<tr>';
        $body .= '<td align="center-" style="padding: 20px 30px 20px 30px;">';
            $body .= '<div style="border-radius: 14px; background-color: #efefef; padding: 10px 30px 17px; text-align: center-;">';
                $body .= '<h1 style="color: #222; font-size: 24px;">';
                    $body .= $langStr["Estos son sus datos de acceso a la zona privada"] . ' - {SERVER.HTTP_HOST}';
                $body .= '</h1>';
                $body .= '<div style="color: #555; font-size: 16px;">';
                    $body .= '<p>' . $langStr["Confirmamos sus datos de acceso"] . ':</p>';
                    $body .= '<p><b>' . $langStr["Email"]  . ':</b> {kt_login_user}</p>';
                    $body .= '<p><b>' . $langStr["Contraseña"] . ':</b> {kt_login_password}</p>';
                    $body .= '<p>' . $langStr["Para acceder a la zona privada de la web, haga clic en el siguiente enlace"] . ':</p>';
                    $body .= '<p> <a href="{kt_login_page}" style="background-color: {COLOR}; color: #fff; padding: 15px 20px; text-decoration: none; border-radius: 223px; display: inline-block; border-radius: 23px; display: block; max-width: 100%; text-align: center; font-size: 16px;">' . $langStr["Acceder a la zona privada del sitio web"] . '</a></p>';
                $body .= '</div>';
            $body .= '</div>';
        $body .= '</td>';
    $body .= '</tr>';

    $html = preg_replace('/{CONTENT}/', $body , $html);
    $html = preg_replace('/{SERVER.HTTP_HOST}/', $_SERVER['HTTP_HOST'], $html);
    $html = preg_replace('/{COLOR}/', $mailColor, $html);
    $html = preg_replace('/{COLOR2}/', $mailSecondaryColor, $html);
    $html = preg_replace('/{kt_login_user}/', $user , $html);
    $html = preg_replace('/{kt_login_password}/', $pass , $html);
    $html = preg_replace('/{kt_login_page}/', $url , $html);
    return $html;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Obtener datos del navegador
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Trident/i', $u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "Trident";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }

    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Save log
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function crawlerDetect() {

	global $_SERVER;
	$bots = array ( 0 => 'Ezooms', 1 => 'bingbot', 2 => 'Googlebot', 3 => 'GrapeshotCrawler', 4 => 'MJ12bot', 5 => 'YandexBot',
				6 => 'proximic', 7 => 'magpie-crawler', 8 => 'Daumoa', 9 => 'ChangeDetection', 10 => 'ia_archiver', 11 => 'Genieo Web filter',
				12 => 'NaverBot', 13 => 'MetaJobBot', 14 => 'Baiduspider', 15 => 'SeznamBot', 16 => 'Exabot', 17 => 'sogou spider',
				18 => 'Woko', 19 => '360Spider', 20 => 'coccoc', 21 => 'TurnitinBot', 22 => 'archive.org_bot', 23 => 'ShopWiki',
				24 => 'ExB Language Crawler', 25 => 'Vagabondo', 26 => 'ZumBot', 27 => 'Spinn3r', 28 => 'Mail.Ru bot', 29 => 'bixocrawler',
				30 => 'AddThis.com', 31 => 'netEstate Crawler', 32 => 'Netseer', 33 => 'CareerBot', 34 => 'sistrix', 35 => 'linkdexbot',
				36 => 'Nuhk', 37 => 'Qualidator.com Bot', 38 => 'bitlybot', 39 => 'spbot', 40 => 'aiHitBot', 41 => 'BingPreview',
				42 => 'A6-Indexer', 43 => '80legs', 44 => 'uMBot', 45 => 'AhrefsBot', 46 => 'Cliqzbot', 47 => 'SeoCheckBot', 48 => 'psbot',
				49 => 'VoilaBot', 50 => 'SearchmetricsBot', 51 => 'rogerbot', 52 => 'ShowyouBot', 53 => 'Yahoo!', 54 => 'Butterfly',
				55 => 'URLAppendBot', 56 => 'Plukkie', 57 => 'yacybot', 58 => 'thumbshots-de-Bot', 59 => 'Jyxobot', 60 => 'Aboundexbot',
				61 => 'UnisterBot', 62 => 'BUbiNG', 63 => 'trendictionbot', 64 => 'CMS Crawler', 65 => 'immediatenet thumbnails',
				66 => 'UASlinkChecker', 67 => 'Blekkobot', 68 => 'NetcraftSurveyAgent', 69 => 'Wotbox', 70 => 'CompSpyBot', 71 => 'YioopBot',
				72 => 'Qualidator.com SiteAnalyzer 1.0', 73 => 'Najdi.si', 74 => 'meanpathbot', 75 => 'TinEye', 76 => 'Qirina Hurdler',
				77 => 'BegunAdvertising', 78 => 'LuminateBot', 79 => 'FyberSpider', 80 => 'Infohelfer', 81 => 'linkdex.com',
				82 => 'Curious George', 83 => 'adressendeutschland.de', 84 => 'Fetch-Guess', 85 => 'ichiro', 86 => 'MojeekBot',
				87 => 'SBSearch', 88 => 'WebThumbnail', 89 => 'socialbm_bot', 90 => 'SemrushBot', 91 => 'Vedma', 92 => 'alexa site audit',
				93 => 'SEOkicks-Robot', 94 => 'Browsershots', 95 => 'HubSpot Connect', 96 => 'BLEXBot', 97 => 'woriobot',
				98 => 'search.KumKie.com', 99 => 'SEOENGBot', 100 => 'AraBot', 101 => 'AMZNKAssocBot', 102 => 'Speedy', 103 => 'parsijoo',
				104 => 'oBot', 105 => 'HostTracker', 106 => 'OpenWebSpider', 107 => 'WBSearchBot', 108 => 'FacebookExternalHit',
				109 => 'KrOWLer', 110 => 'iCjobs', 111 => 'IstellaBot', 112 => 'CliqzBot', 113 => 'findlinks', 114 => 'IntegromeDB',
				115 => 'FlipboardProxy', 116 => 'Nigma.ru', 117 => 'BacklinkCrawler', 118 => 'Peeplo Screenshot Bot',
				119 => 'Panscient web crawler', 120 => 'CCResearchBot', 121 => 'Semantifire', 122 => 'LinkAider', 123 => 'Zookabot',
				124 => 'Crawler4j', 125 => 'ScreenerBot Crawler', 126 => 'CloudServerMarketSpider', 127 => 'webmastercoffee',
				128 => 'PaperLiBot', 129 => 'QuerySeekerSpider', 130 => 'Crowsnest', 131 => 'UnwindFetchor', 132 => 'MetaURI API',
				133 => 'MiaDev', 134 => 'AcoonBot', 135 => 'Steeler', 136 => 'Gigabot', 137 => 'firmilybot', 138 => 'Sosospider',
				139 => 'OpenindexSpider', 140 => 'MetaHeadersBot', 141 => 'Strokebot', 142 => 'GeliyooBot', 143 => 'CCBot',
				144 => 'bot-pge.chlooe.com', 145 => 'ownCloud Server Crawler', 146 => 'CirrusExplorer', 147 => 'ProCogSEOBot',
				148 => 'Falconsbot', 149 => 'Dlvr.it/1.0', 150 => '200PleaseBot', 151 => 'discoverybot', 152 => 'R6 bot',
				153 => 'bl.uk_lddc_bot', 154 => 'SolomonoBot', 155 => 'Grahambot', 156 => 'Automattic Analytics Crawler', 157 => 'emefgebot',
				158 => 'YoudaoBot', 159 => 'PiplBot', 160 => 'FlightDeckReportsBot', 161 => 'fastbot crawler', 162 => '4seohuntBot',
				163 => 'Updownerbot', 164 => 'JikeSpider', 165 => 'NLNZ_IAHarvester2013', 166 => 'wsAnalyzer', 167 => 'YodaoBot',
				168 => 'SpiderLing', 169 => 'Esribot', 170 => 'Thumbshots.ru', 171 => 'BlogPulse', 172 => 'NextGenSearchBot',
				173 => 'bot.wsowner.com', 174 => 'wscheck.com', 175 => 'Qseero', 176 => 'drupact', 177 => 'HuaweiSymantecSpider',
				178 => 'PagePeeker', 179 => 'HomeTags', 180 => 'facebookplatform', 181 => 'Pixray-Seeker', 182 => 'BDFetch',
				183 => 'MeMoNewsBot', 184 => 'ProCogBot', 185 => 'WillyBot', 186 => 'peerindex', 187 => 'Job Roboter Spider', 188 => 'MLBot',
				189 => 'WebNL', 190 => 'Peepowbot', 191 => 'Semager', 192 => 'MIA Bot', 193 => 'heritrix', 194 => 'Eurobot',
				195 => 'DripfeedBot', 196 => 'webinatorbot', 197 => 'Whoismindbot', 198 => 'Bad-Neighborhood', 199 => 'Hailoobot',
				200 => 'akula', 201 => 'MetamojiCrawler', 202 => 'Page2RSS', 203 => 'EasyBib AutoCite', 204 => 'suggybot',
				205 => 'NerdByNature.Bot', 206 => 'EventGuruBot', 207 => 'quickobot', 208 => 'gonzo', 209 => 'bnf.fr_bot',
				210 => 'UptimeRobot', 211 => 'Influencebot', 212 => 'MSRBOT', 213 => 'KeywordDensityRobot', 214 => 'Ronzoobot',
				215 => 'RyzeCrawler', 216 => 'ScoutJet', 217 => 'Twikle', 218 => 'SWEBot', 219 => 'RADaR-Bot', 220 => 'DCPbot',
				221 => 'Castabot', 222 => 'percbotspider', 223 => 'WeSEE:Search', 224 => 'CatchBot', 225 => 'imbot', 226 => 'EdisterBot',
				227 => 'WASALive-Bot', 228 => 'Accelobot', 229 => 'PostPost', 230 => 'factbot', 231 => 'Setoozbot', 232 => 'biwec',
				233 => 'GarlikCrawler', 234 => 'Search17Bot', 235 => 'Lijit', 236 => 'MetaGeneratorCrawler', 237 => 'Robots_Tester',
				238 => 'JUST-CRAWLER', 239 => 'Apercite', 240 => 'pmoz.info ODP link checker', 241 => 'LemurWebCrawler', 242 => 'Covario-IDS',
				243 => 'Holmes', 244 => 'RankurBot', 245 => 'DotBot', 246 => 'AdsBot-Google', 247 => 'envolk', 248 => 'Ask Jeeves/Teoma',
				249 => 'LexxeBot', 250 => 'StackRambler', 251 => 'Abrave Spider', 252 => 'EvriNid', 253 => 'arachnode.net',
				254 => 'CamontSpider', 255 => 'wikiwix-bot', 256 => 'Nymesis', 257 => 'trendictionbot', 258 => 'Sitedomain-Bot',
				259 => 'SEODat', 260 => 'SygolBot', 261 => 'Snapbot', 262 => 'OpenCalaisSemanticProxy', 263 => 'ZookaBot',
				264 => 'CligooRobot', 265 => 'cityreview', 266 => 'nworm', 267 => 'AboutUsBot', 268 => 'ICC-Crawler', 269 => 'SBIder',
				270 => 'TwengaBot', 271 => 'Dot TK - spider', 272 => 'EuripBot', 273 => 'ParchBot', 274 => 'Peew', 275 => 'AntBot',
				276 => 'YRSpider', 277 => 'Urlfilebot (Urlbot)', 278 => 'Gaisbot', 279 => 'WatchMouse', 280 => 'Tagoobot',
				281 => 'Motoricerca-Robots.txt-Checker', 282 => 'WebWatch/Robot_txtChecker', 283 => 'urlfan-bot', 284 => 'StatoolsBot',
				285 => 'page_verifier', 286 => 'SSLBot', 287 => 'SAI Crawler', 288 => 'DomainDB', 289 => 'LinkWalker', 290 => 'WMCAI_robot',
				291 => 'voyager', 292 => 'copyright sheriff', 293 => 'Ocelli', 294 => 'Twiceler', 295 => 'amibot', 296 => 'abby',
				297 => 'NetResearchServer', 298 => 'VideoSurf_bot', 299 => 'XML Sitemaps Generator', 300 => 'BlinkaCrawler',
				301 => 'nodestackbot', 302 => 'Pompos', 303 => 'taptubot', 304 => 'BabalooSpider', 305 => 'Yaanb', 306 => 'Girafabot',
				307 => 'livedoor ScreenShot', 308 => 'eCairn-Grabber', 309 => 'FauBot', 310 => 'Toread-Crawler', 311 => 'Setoozbot',
				312 => 'MetaURI', 313 => 'L.webis', 314 => 'Web-sniffer', 315 => 'FairShare', 316 => 'Ruky-Roboter', 317 => 'ThumbShots-Bot',
				318 => 'BotOnParade', 319 => 'Amagit.COM', 320 => 'HatenaScreenshot', 321 => 'HolmesBot', 322 => 'dotSemantic',
				323 => 'Karneval-Bot', 324 => 'HostTracker.com', 325 => 'AportWorm', 326 => 'XmarksFetch', 327 => 'FeedFinder/bloggz.se',
				328 => 'CorpusCrawler', 329 => 'Willow Internet Crawler', 330 => 'OrgbyBot', 331 => 'GingerCrawler', 332 => 'pingdom.com_bot',
				333 => 'Nutch', 334 => 'baypup', 335 => 'Linguee Bot', 336 => 'Mp3Bot', 337 => '192.comAgent', 338 => 'Surphace Scout',
				339 => 'WikioFeedBot', 340 => 'Szukacz', 341 => 'DBLBot', 342 => 'Thumbnail.CZ robot', 343 => 'LinguaBot', 344 => 'GurujiBot',
				345 => 'Charlotte', 346 => '50.nu', 347 => 'SanszBot', 348 => 'moba-crawler', 349 => 'HeartRails_Capture', 350 => 'SurveyBot',
				351 => 'MnoGoSearch', 352 => 'smart.apnoti.com Robot', 353 => 'Topicbot', 354 => 'JadynAveBot', 355 => 'OsObot',
				356 => 'WebImages', 357 => 'WinWebBot', 358 => 'Scooter', 359 => 'Scarlett', 360 => 'GOFORITBOT', 361 => 'DKIMRepBot',
				362 => 'Yanga', 363 => 'DNS-Digger-Explorer', 364 => 'Robozilla', 365 => 'YowedoBot', 366 => 'botmobi',
				367 => 'Fooooo_Web_Video_Crawl', 368 => 'UptimeDog', 369 => 'Nail', 370 => 'Metaspinner/0.01', 371 => 'Touche',
				372 => 'RSSMicro.com RSS/Atom Feed Robot', 373 => 'SniffRSS', 374 => 'Kalooga', 375 => 'FeedCatBot', 376 => 'WebRankSpider',
				377 => 'Flatland Industries Web Spider', 378 => 'DealGates Bot', 379 => 'Link Valet Online', 380 => 'Shelob',
				381 => 'Technoratibot', 382 => 'Flocke bot', 383 => 'FollowSite Bot', 384 => 'Visbot', 385 => 'MSNBot', 386 => 'Twitterbot', 387 => 'LinkedInBot');

	$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	if (!empty($bots)) {
		foreach($bots as $bot) {
			if(stripos($USER_AGENT, $bot) !== false) {
				return true;
			}
		}
	}
	return false;
}

function savelogprop($id, $action) {

    global $database_inmoconn, $inmoconn, $_SERVER;

    if (!crawlerDetect() && $_SERVER['HTTP_USER_AGENT'] != '') {

    	$query_rsProp = "INSERT INTO `properties_log_2` (`id_log`, `prop_id_log`, `action_log`, `date_log`, `agent_log`) VALUES (NULL, '".$id."', '".$action."', '".date("Y-m-d H:i:s")."', '')";
    	$rsProp = mysqli_query($inmoconn, $query_rsProp);
        if ($stmt = $inmoconn->prepare($query_rsProp)) {
            
            // Ejecutar la declaración
            $stmt->execute();

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Manejar errores de preparación
            die("Error al preparar la consulta: " . $inmoconn->error);
        }

    }

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Hash string
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function encryptStringArray ($stringArray, $key = "QGMpu6QbzmRGbcCvDhLerbWzEJy)wMbcMIFIN7tEHFYkVpjIjk") {
 //$s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), '+/=', '-_,');
 return $s;
}

function decryptStringArray ($stringArray, $key = "QGMpu6QbzmRGbcCvDhLerbWzEJy)wMbcMIFIN7tEHFYkVpjIjk") {
 //$s = unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(strtr($stringArray, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5($key))), "\0"));
 return $s;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get recordset
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getRecords($sql) {
    global $inmoconn;

    // Ejecutar la consulta
    $rsSelect = mysqli_query($inmoconn, $sql);

    // Verificar si la consulta fue exitosa
    if (!$rsSelect) {
        die("Error en la consulta: " . mysqli_error($inmoconn));
    }

    $ret = array();

    // Obtener los resultados de la consulta
    while ($row_rsSelect = mysqli_fetch_assoc($rsSelect)) {
        $ret[] = $row_rsSelect;
    }

    // Liberar los resultados
    mysqli_free_result($rsSelect);

    return $ret;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get recordset and cache
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getRecordsAndCache($sql, $name){

	global $lang;

    $fileCache = 'modules/_cache/' . $name . '-'.$lang.'.json';

    if (!file_exists($fileCache)) {
        $file = getRecords($sql);
        $fp = fopen($fileCache , "w");
        fwrite($fp, json_encode($file));
        fclose($fp);
    }

    $json = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/' . $fileCache);

    return json_decode($json, true);

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Show Thumbnail
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/phpthumb/ThumbLib.inc.php');

function remoteFileData3($f) {
    $h = get_headers($f, 1);
    if (stristr($h[0], '200')) {
        foreach($h as $k=>$v) {
            if(strtolower(trim($k))=="last-modified") return strtotime($v);
        }
    }
}

if(!function_exists("showThumbnail")) {
    function showThumbnail($image, $path, $width, $height, $alt = null, $class = null) {

        $image = preg_replace('/\?.*/', '', $image);

    	$fileName = basename($image);


    	$thumbImg = '';

    	$pathInfo = pathinfo($image);
    	$paths['filePath'] = $pathInfo['dirname'];
    	$paths['fileExt'] = $pathInfo['extension'];
    	$paths['fileBasename'] = $pathInfo['filename'] ? $pathInfo['filename'] : substr($fileName ,0,strrpos($fileName ,'.'));
    	$paths['fileSrc'] = $path . '' . $fileName;
    	$paths['cachePath'] = $path. 'thumbnails/';

    	$rep = array('stream.asp?pic=', '&width=large', ' ', '%');

        $cachedName = str_replace($rep, '', md5($image)) . '_' . $width . 'x' . $height;
        $cachedName .= '.' . str_replace($rep, '', $paths['fileExt']);
        $cachedPath = $paths['cachePath'] . $cachedName;

        $noImagePath = $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/img/no_image.jpg';
        $noImageTime = @filemtime($noImagePath);

        $cacheTime = @filemtime($_SERVER["DOCUMENT_ROOT"] . $cachedPath);



        if (preg_match('/http:\/\//', $image) || preg_match('/https:\/\//', $image)) {

        	if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath)) {

        	    if (getImageSize($image)) {

        	    	$imageTime = @filemtime(remoteFileData3($image));

        	    	if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath) || $imageTime > $cacheTime) {

        	    	    $thumbImg = $image;

        	    	}

        	    } else {

        	    	if (!is_file($noImagePath) || $noImageTime > $cacheTime) {


        	    	    $thumbImg = $noImagePath;

        	    	}




        	    }

        	}

        } else {

    	    if (file_exists($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc'])) {

    	    	$imageTime = @filemtime($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);

    	    	if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath) || $imageTime > $cacheTime) {

                    // read EXIF header from uploaded file
                    $exif = exif_read_data($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);

                    //fix the Orientation if EXIF data exist
                    if(!empty($exif['Orientation'])) {
                        $source = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);
                        switch($exif['Orientation']) {
                            case 8:
                                    $rotate = imagerotate($source,90,0);
                                break;
                            case 3:
                                    $rotate = imagerotate($source,180,0);
                                break;
                            case 6:
                                    $rotate = imagerotate($source,-90,0);
                                break;
                        }
                        if ($rotate != '') {
                            imagejpeg($rotate,$_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);
                        }
                    }

    	    	    $thumbImg = $_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc'];

    	    	}

    	    } else {

    	    	if (!is_file($noImagePath) || $noImageTime > $cacheTime) {

    	    	    $thumbImg = $noImagePath;

    	    	}

    	    }

        }

        if ($thumbImg != '') {

        	$thumb = PhpThumbFactory::create($thumbImg, array('jpegQuality'=>70));
        	$thumb->adaptiveResize($width, $height);
        	$thumb->save($_SERVER["DOCUMENT_ROOT"] . $cachedPath);

        }

    	return '<img src="https://'.$_SERVER['HTTP_HOST'].''.$cachedPath.'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" title="'.$alt.'"  class="'.$class.'" />';

    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Slug
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function clean($str, $options = array())
{

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
  $str = str_replace('ª', '', $str);

  // Remove duplicate delimiters
  $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

  // Truncate slug to max. characters
  $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

  // Remove delimiter from ends
  $str = trim($str, $options['delimiter']);

  return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;

}

function cleanTrad($title) {
    $title = strip_tags($title);
    $title = remove_accents($title);


    $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);

    $title = str_replace('%', '', $title);

    $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

    if (seems_utf8($title)) {
        if (function_exists('mb_strtolower')) {
            $title = mb_strtolower($title, 'UTF-8');
        }

    }

    $title = strtolower($title);
    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = str_replace('.', '_', $title);
    $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', '_', $title);
    $title = preg_replace('|-+|', '_', $title);
    $title = trim($title, '-');

    return $title;
}

function seems_utf8($str) {
    $length = strlen($str);
    for ($i=0; $i < $length; $i++) {
        $c = ord($str[$i]);
        if ($c < 0x80) $n = 0; # 0bbbbbbb
        elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
        elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
        elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
        elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
        elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
        else return false; # Does not match any model
        for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                return false;
        }
    }
    return true;
}

function remove_accents($string) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    if (seems_utf8($string)) {
        $chars = array(
        // Decompositions for Latin-1 Supplement
        chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
        chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
        chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
        chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
        chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
        chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
        chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
        chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
        chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
        chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
        chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
        chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
        chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
        chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
        chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
        chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
        chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
        chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
        chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
        chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
        chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
        chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
        chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
        chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
        chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
        chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
        chr(195).chr(182) => 'o', chr(195).chr(182) => 'o',
        chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
        chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
        chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
        chr(195).chr(191) => 'y',
        // Decompositions for Latin Extended-A
        chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
        chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
        chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
        chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
        chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
        chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
        chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
        chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
        chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
        chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
        chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
        chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
        chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
        chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
        chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
        chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
        chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
        chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
        chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
        chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
        chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
        chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
        chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
        chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
        chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
        chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
        chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
        chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
        chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
        chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
        chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
        chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
        chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
        chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
        chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
        chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
        chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
        chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
        chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
        chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
        chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
        chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
        chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
        chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
        chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
        chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
        chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
        chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
        chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
        chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
        chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
        chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
        chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
        chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
        chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
        chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
        chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
        chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
        chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
        chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
        chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
        chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
        chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
        chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
        // Decompositions for Latin Extended-B
        chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
        chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
        // Euro Sign
        chr(226).chr(130).chr(172) => 'E',
        // GBP (Pound) Sign
        chr(194).chr(163) => '');

        $string = strtr($string, $chars);
    } else {
        // Assume ISO-8859-1 if not UTF-8
        $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
            .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
            .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
            .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
            .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
            .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
            .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
            .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
            .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
            .chr(252).chr(253).chr(255);

        $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

        $string = strtr($string, $chars['in'], $chars['out']);
        $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
        $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
        $string = str_replace($double_chars['in'], $double_chars['out'], $string);
    }

    return $string;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Enlace propiedad
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function propURL($id, $lang) {

    global $language, $urlStr;

    $langurl = $lang;

    $query = " SELECT

        title_".$lang."_prop as metatitle,
        id_prop,
        CASE WHEN properties_types.types_".$lang."_typ IS NOT NULL THEN properties_types.types_".$lang."_typ ELSE types.types_".$lang."_typ END AS type,
        properties_status.status_".$lang."_sta as sale,
        properties_loc1.name_".$lang."_loc1 AS country,
        CASE WHEN properties_loc2.name_".$lang."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang."_loc2 ELSE province1.name_".$lang."_loc2  END AS province,
        CASE WHEN properties_loc3.name_".$lang."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang."_loc3 ELSE areas1.name_".$lang."_loc3  END AS area,
        CASE WHEN properties_loc4.name_".$lang."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang."_loc4 ELSE towns.name_".$lang."_loc4  END AS town,

        properties_loc1.id_loc1 AS countryid,
        CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS provinceid,
        CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS areaid,
        CASE WHEN properties_loc4.id_loc4 IS NOT NULL THEN properties_loc4.id_loc4 ELSE towns.id_loc4  END AS townid,
        CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS typeid,
        properties_properties.lat_long_gp_prop AS lat,
        properties_status.slug_sta as saleSlug,
        properties_status.id_sta as saleId,
        properties_status.id_sta,
        activado_prop

        FROM properties_loc4 towns
        LEFT OUTER JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
        LEFT OUTER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
        LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
        LEFT OUTER JOIN properties_images ON properties_properties.id_prop = properties_images.property_img AND order_img = 1
        LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta

    WHERE id_prop = '".stripslashes(($id))."'

    GROUP BY id_prop

    ";

    $property = getRecords($query);

    // Cargamos las urls
    include($_SERVER["DOCUMENT_ROOT"] . "/resources/urls.php");

    foreach ($urlStr as $key => $urls) {
        foreach ($urls as $langval => $urlval) {
            if ($langval == $lang) {
                $urlStr[$key]['url'] = $urlval;
                $urlStr[$urlStr[$key][$langval]]['master'] = $key;
            }
        }
    }

    $urlStart = '/';

    if(@isset($langurl) && $langurl != '' && $langurl != $language) {
        $urlStart =   '/' . $langurl . '/';
    }

    if(isset($property[0])){
        if ( $property[0]['metatitle'] != '') {
            return $urlStart . '' . $urlStr['property']['url'] . '/' . $property[0]['id_prop'] . '/' . clean(removeEmojis(html_entity_decode($property[0]['metatitle']))) . '/';
        } else {
            return $urlStart . '' . $urlStr['property']['url'] . '/' . $property[0]['id_prop'] . '/' . clean(html_entity_decode($property[0]['type'])) . '/' . clean(html_entity_decode($property[0]['sale'])) . '/' . clean(html_entity_decode($property[0]['country'])) . '/' . clean(html_entity_decode($property[0]['province'])) . '/' . clean(html_entity_decode($property[0]['area'])) . '/' . clean(html_entity_decode($property[0]['town'])) . '/';
        }
    } else {
        return '';
    }

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Enlace propiedad
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getPropTags($id, $lang) {

    global $language, $urlStr;

    $tags = getRecords("
        SELECT
        properties_tags.tag_" . $lang . "_tag as tag,
        properties_tags.id_tag,
        properties_tags.color_tag,
        properties_tags.text_color_tag
        FROM
        properties_property_tag
        JOIN properties_tags
        ON properties_property_tag.tag = properties_tags.id_tag
        WHERE
        properties_property_tag.property = '" . $id . "'
    ");

    return $tags;

}


function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function sanitizeAndValidateEmail($email) {
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}


function removeEmojis($string) {
    return preg_replace('/[\x{1F600}-\x{1F64F}' . // Emoticons
            '\x{1F300}-\x{1F5FF}' . // Symbols & Pictographs
            '\x{1F680}-\x{1F6FF}' . // Transport & Map
            '\x{2600}-\x{26FF}' .   // Misc symbols
            '\x{2700}-\x{27BF}' .   // Dingbats
            '\x{1F900}-\x{1F9FF}' . // Supplemental Symbols
            '\x{1F1E6}-\x{1F1FF}]/u', '', $string); // Flags
}

function getDownloadName($text) {
    global $langStr;
    return $langStr['pl' . preg_replace("/\.[^.]+$/", "", basename($text))];
}