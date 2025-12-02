<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-07-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>Poder gestionar plantillas / respuestas desde buyers / email</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i>Quitar cannonical en ficha inmueble</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i>Convertir a propietario en consultas de la web</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i>Vendor: añadir campo "Partner Portal / Dropbox"</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i>Propiedades / Datos privados: añadir campo "Dropbox link"</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i>Propiedades / General - añadir campos  "fecha de entrega" - "delivery date"</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i>Importador resales-online </a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i>Acceso CRM: actualizar logo a digital agency, cambiar banner de grupo Facebook al de acceso MLS </a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Poder gestionar plantillas / respuestas desde buyers / email
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
CREATE TABLE `templates` (
  `id_tmpl` int(11) NOT NULL AUTO_INCREMENT,
  `name_en_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_es_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_ca_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_da_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_de_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_en_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_es_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_fi_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_fr_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_is_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_nl_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_no_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_ru_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_se_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_zh_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_pl_tmpl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_ca_tmpl` text COLLATE utf8_unicode_ci,
  `content_da_tmpl` text COLLATE utf8_unicode_ci,
  `content_de_tmpl` text COLLATE utf8_unicode_ci,
  `content_en_tmpl` text COLLATE utf8_unicode_ci,
  `content_es_tmpl` text COLLATE utf8_unicode_ci,
  `content_fi_tmpl` text COLLATE utf8_unicode_ci,
  `content_fr_tmpl` text COLLATE utf8_unicode_ci,
  `content_is_tmpl` text COLLATE utf8_unicode_ci,
  `content_nl_tmpl` text COLLATE utf8_unicode_ci,
  `content_no_tmpl` text COLLATE utf8_unicode_ci,
  `content_ru_tmpl` text COLLATE utf8_unicode_ci,
  `content_se_tmpl` text COLLATE utf8_unicode_ci,
  `content_zh_tmpl` text COLLATE utf8_unicode_ci,
  `content_pl_tmpl` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id_tmpl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `templates` (`id_tmpl`, `name_en_tmpl`, `name_es_tmpl`, `subject_ca_tmpl`, `subject_da_tmpl`, `subject_de_tmpl`, `subject_en_tmpl`, `subject_es_tmpl`, `subject_fi_tmpl`, `subject_fr_tmpl`, `subject_is_tmpl`, `subject_nl_tmpl`, `subject_no_tmpl`, `subject_ru_tmpl`, `subject_se_tmpl`, `subject_zh_tmpl`, `subject_pl_tmpl`, `content_ca_tmpl`, `content_da_tmpl`, `content_de_tmpl`, `content_en_tmpl`, `content_es_tmpl`, `content_fi_tmpl`, `content_fr_tmpl`, `content_is_tmpl`, `content_nl_tmpl`, `content_no_tmpl`, `content_ru_tmpl`, `content_se_tmpl`, `content_zh_tmpl`, `content_pl_tmpl`) VALUES
    (1,&#039;Initial response without telephone&#039;,&#039;Respuesta Inicial sin tel&eacute;fono&#039;,&#039;Resposta inicial sense tel&egrave;fon&#039;,&#039;F&oslash;rste svar uden telefon&#039;,&#039;Erste Reaktion ohne Telefon&#039;,&#039;Initial response without telephone&#039;,&#039;Respuesta Inicial sin tel&eacute;fono&#039;,&#039;Ensimm&auml;inen vastaus ilman puhelinta&#039;,&#039;R&eacute;ponse initiale sans t&eacute;l&eacute;phone&#039;,&#039;Fyrsta svar &aacute;n s&iacute;ma&#039;,&#039;Eerste reactie zonder telefoon&#039;,&#039;Innledende svar uten telefon&#039;,&#039;&#x41f;&#x435;&#x440;&#x432;&#x438;&#x447;&#x43d;&#x43e;&#x435; &#x440;&#x435;&#x430;&#x433;&#x438;&#x440;&#x43e;&#x432;&#x430;&#x43d;&#x438;&#x435; &#x431;&#x435;&#x437; &#x442;&#x435;&#x43b;&#x435;&#x444;&#x43e;&#x43d;&#x430;&#039;,&#039;F&ouml;rsta svar utan telefon&#039;,&#039;&#x4e0d;&#x4f7f;&#x7528;&#x7535;&#x8bdd;&#x7684;&#x521d;&#x6b65;&#x56de;&#x5e94;&#039;,&#039;Wst&#x119;pna reakcja bez telefonu&#039;,&#039;Gr&agrave;cies per contactar amb la nostra ag&egrave;ncia immobili&agrave;ria.\r\nAqu&iacute; tens la informaci&oacute; que has sol&middot;licitat sobre la seg&uuml;ent propietat.\r\nPodeu fer clic per a m&eacute;s informaci&oacute; i cases similars:\r\n\r\n{{PROPERTY}}\r\n\r\nSi voleu que un dels nostres assessors es posin en contacte amb vosaltres, responeu a aquest correu electr&ograve;nic indicant un n&uacute;mero de tel&egrave;fon i una hora en qu&egrave; us conv&eacute; rebre una trucada o un whatsapp.\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;Tak for din henvendelse til vores ejendomsm&aelig;glerfirma.\r\nHer har du de oplysninger, du har anmodet om om f&oslash;lgende ejendom.\r\nDu kan klikke for mere information og lignende huse:\r\n\r\n{{PROPERTY}}\r\n\r\nHvis du &oslash;nsker, at en af vores r&aring;dgivere kontakter dig, bedes du svare p&aring; denne e-mail og angive et telefonnummer og et tidspunkt, hvor det ville v&aelig;re praktisk for dig atmodtage et opkald eller whatsapp.\r\n\r\nMed venlig hilsen og tak for din tid&#039;,&#039;Vielen Dank, dass Sie unser Immobilienb&uuml;ro kontaktiert haben.\r\nHier finden Sie die von Ihnen gew&uuml;nschten Informationen zu folgender Immobilie.\r\nF&uuml;r weitere Informationen und &auml;hnliche H&auml;user k&ouml;nnen Sie hier klicken:\r\n\r\n{{PROPERTY}}\r\n\r\nWenn Sie m&ouml;chten, dass sich einer unserer Berater mit Ihnen in Verbindung setzt, antworten Sie bitte auf diese E-Mail und geben Sie eine Telefonnummer und einenZeitpunkt an, zu dem Sie einen Anruf oder eine Whatsapp-Nachricht erhalten m&ouml;chten.\r\n\r\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit&#039;,&#039;Thank you for contacting our real estate agency.\r\nHere you have the information you have requested about the following property.\r\nYou can click for more information and similar houses:\r\n\r\n{{PROPERTY}}\r\n\r\nIf you would like one of our advisors to contact you, please reply to this email, indicating a telephone number and a time when it would be convenient for you toreceive a call or whatsapp.\r\n\r\nBest regards and thank you for your time&#039;,&#039;Gracias por contactar con nuestra inmobiliaria.\r\nAqu&iacute; tienes la informaci&oacute;n que nos has solicitado sobre la siguiente propiedad.\r\nPuedes hacer clic para m&aacute;s informaci&oacute;n y casas similares:\r\n\r\n{{PROPERTY}}\r\n\r\nSi quiere que uno de nuestros asesores se ponga en contacto contigo, por favor responde a este mail, indicando un n&uacute;mero de tel&eacute;fono y una hora a la que te viene bienrecibir una llamada o whatsapp.\r\n\r\nUn saludo y gracias por tu tiempo&#039;,&#039;Kiitos, ett&auml; otit yhteytt&auml; kiinteist&ouml;v&auml;litystoimistoomme.\r\nT&auml;ss&auml; on pyyt&auml;m&auml;si tiedot seuraavasta kiinteist&ouml;st&auml;.\r\nVoit klikata lis&auml;tietoja ja samankaltaisia taloja:\r\n\r\n{{PROPERTY}}\r\n\r\nJos haluat, ett&auml; joku neuvonantajistamme ottaa sinuun yhteytt&auml;, vastaa t&auml;h&auml;n s&auml;hk&ouml;postiin ja ilmoita puhelinnumero ja aika, jolloin sinulle sopisi soittaa tai whatsappata.\r\n\r\nYst&auml;v&auml;llisin terveisin ja kiitos ajastanne&#039;,&#039;Merci d\&#039;avoir contact&eacute; notre agence immobili&egrave;re.\r\nVous trouverez ici les informations que vous avez demand&eacute;es concernant le bien suivant.\r\nVous pouvez cliquer pour obtenir plus d\&#039;informations et des maisons similaires :\r\n\r\n{{PROPERTY}}\r\n\r\nSi vous souhaitez que l\&#039;un de nos conseillers vous contacte, veuillez r&eacute;pondre &agrave; cet e-mail en indiquant un num&eacute;ro de t&eacute;l&eacute;phone et une heure &agrave; laquelle il vousconviendrait de recevoir un appel ou un whatsapp.\r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;&THORN;akka &thorn;&eacute;r fyrir a&eth; hafa samband vi&eth; fasteignas&ouml;luna okkar.\r\nH&eacute;r hefur &thorn;&uacute; uppl&yacute;singarnar sem &thorn;&uacute; hefur be&eth;i&eth; um um eftirfarandi eign.\r\n&THORN;&uacute; getur smellt fyrir frekari uppl&yacute;singar og svipu&eth; h&uacute;s:\r\n\r\n{{PROPERTY}}\r\n\r\nEf &thorn;&uacute; vilt a&eth; einn af r&aacute;&eth;gj&ouml;funum okkar hafi samband vi&eth; &thorn;ig, vinsamlegast svara&eth;u &thorn;essum t&ouml;lvup&oacute;sti og tilgreinir s&iacute;man&uacute;mer og hven&aelig;r hentar &thorn;&eacute;r a&eth; f&aacute; s&iacute;mtal e&eth;a whatsapp.\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;mann&#039;,&#039;Dank u voor het contacteren van ons makelaarskantoor.\r\nHier is de informatie die u heeft opgevraagd over het volgende object.\r\nU kunt klikken voor meer informatie en soortgelijke huizen:\r\n\r\n{{PROPERTY}}\r\n\r\nIndien u wenst dat een van onze adviseurs contact met u opneemt, gelieve dan te antwoorden op deze e-mail, met vermelding van een telefoonnummer en een tijdstip waarophet u schikt om een telefoontje of een whatsapp te ontvangen.\r\n\r\nMet vriendelijke groet en dank u voor uw tijd&#039;,&#039;Takk for at du kontakter v&aring;r eiendom.\r\nHer er informasjonen du har bedt om om f&oslash;lgende eiendom.\r\nDu kan klikke for mer informasjon og lignende hus:\r\n\r\n{{PROPERTY}}\r\n\r\nHvis du vil at en av v&aring;re r&aring;dgivere skal kontakte deg, vennligst svar p&aring; denne e-posten, og oppgi et telefonnummer og et tidspunkt det passer for deg &aring; motta en samtaleeller whatsapp.\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x411;&#x43b;&#x430;&#x433;&#x43e;&#x434;&#x430;&#x440;&#x438;&#x43c; &#x432;&#x430;&#x441; &#x437;&#x430; &#x43e;&#x431;&#x440;&#x430;&#x449;&#x435;&#x43d;&#x438;&#x435; &#x432; &#x43d;&#x430;&#x448;&#x435; &#x430;&#x433;&#x435;&#x43d;&#x442;&#x441;&#x442;&#x432;&#x43e; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;.\r\n&#x417;&#x434;&#x435;&#x441;&#x44c; &#x43f;&#x440;&#x435;&#x434;&#x441;&#x442;&#x430;&#x432;&#x43b;&#x435;&#x43d;&#x430; &#x437;&#x430;&#x43f;&#x440;&#x430;&#x448;&#x438;&#x432;&#x430;&#x435;&#x43c;&#x430;&#x44f; &#x432;&#x430;&#x43c;&#x438; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44f; &#x43e; &#x441;&#x43b;&#x435;&#x434;&#x443;&#x44e;&#x449;&#x435;&#x43c; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x435; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;.\r\n&#x412;&#x44b; &#x43c;&#x43e;&#x436;&#x435;&#x442;&#x435; &#x43d;&#x430;&#x436;&#x430;&#x442;&#x44c; &#x434;&#x43b;&#x44f; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x435;&#x43d;&#x438;&#x44f; &#x434;&#x43e;&#x43f;&#x43e;&#x43b;&#x43d;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x43e;&#x439; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x438; &#x438; &#x43f;&#x43e;&#x445;&#x43e;&#x436;&#x438;&#x445; &#x434;&#x43e;&#x43c;&#x43e;&#x432;:\r\n\r\n{{PROPERTY}}\r\n\r\n&#x415;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x445;&#x43e;&#x442;&#x438;&#x442;&#x435;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x43b;&#x441;&#x44f; &#x43e;&#x434;&#x438;&#x43d; &#x438;&#x437; &#x43d;&#x430;&#x448;&#x438;&#x445; &#x43a;&#x43e;&#x43d;&#x441;&#x443;&#x43b;&#x44c;&#x442;&#x430;&#x43d;&#x442;&#x43e;&#x432;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x43e;&#x442;&#x432;&#x435;&#x442;&#x44c;&#x442;&#x435; &#x43d;&#x430; &#x44d;&#x442;&#x43e; &#x43f;&#x438;&#x441;&#x44c;&#x43c;&#x43e;, &#x443;&#x43a;&#x430;&#x437;&#x430;&#x432; &#x43d;&#x43e;&#x43c;&#x435;&#x440; &#x442;&#x435;&#x43b;&#x435;&#x444;&#x43e;&#x43d;&#x430; &#x438; &#x432;&#x440;&#x435;&#x43c;&#x44f;, &#x43a;&#x43e;&#x433;&#x434;&#x430; &#x432;&#x430;&#x43c; &#x431;&#x443;&#x434;&#x435;&#x442; &#x443;&#x434;&#x43e;&#x431;&#x43d;&#x43e; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x442;&#x44c; &#x437;&#x432;&#x43e;&#x43d;&#x43e;&#x43a; &#x438;&#x43b;&#x438; Whatsapp.\r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Tack f&ouml;r att du har kontaktat v&aring;r fastighetsbyr&aring;.\r\nH&auml;r &auml;r den information som du har beg&auml;rt om f&ouml;ljande fastighet.\r\nDu kan klicka f&ouml;r mer information och liknande hus:\r\n\r\n{{PROPERTY}}\r\n\r\nOm du vill att en av v&aring;ra r&aring;dgivare ska kontakta dig, v&auml;nligen svara p&aring; detta e-postmeddelande och ange ett telefonnummer och en tid d&aring; det skulle passa dig att f&aring; ettsamtal eller en whatsapp.\r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x611f;&#x8c22;&#x4f60;&#x4e0e;&#x6211;&#x4eec;&#x7684;&#x623f;&#x5730;&#x4ea7;&#x673a;&#x6784;&#x8054;&#x7cfb;&#x3002;\r\n&#x8fd9;&#x91cc;&#x6709;&#x4f60;&#x6240;&#x8981;&#x6c42;&#x7684;&#x5173;&#x4e8e;&#x4ee5;&#x4e0b;&#x623f;&#x4ea7;&#x7684;&#x4fe1;&#x606f;&#x3002;\r\n&#x60a8;&#x53ef;&#x4ee5;&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x66f4;&#x591a;&#x4fe1;&#x606f;&#x548c;&#x7c7b;&#x4f3c;&#x623f;&#x5c4b;&#x3002;\r\n\r\n{{PROPERTY}}\r\n\r\n&#x5982;&#x679c;&#x60a8;&#x5e0c;&#x671b;&#x6211;&#x4eec;&#x7684;&#x987e;&#x95ee;&#x4e0e;&#x60a8;&#x8054;&#x7cfb;&#xff0c;&#x8bf7;&#x56de;&#x590d;&#x6b64;&#x90ae;&#x4ef6;&#xff0c;&#x6ce8;&#x660e;&#x7535;&#x8bdd;&#x53f7;&#x7801;&#x4ee5;&#x53ca;&#x60a8;&#x65b9;&#x4fbf;&#x63a5;&#x542c;&#x7535;&#x8bdd;&#x6216;Whatsapp&#x7684;&#x65f6;&#x95f4;&#x3002;\r\n\r\n&#x81f4;&#x4ee5;&#x6700;&#x8bda;&#x631a;&#x7684;&#x95ee;&#x5019;&#xff0c;&#x5e76;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Dzi&#x119;kujemy za kontakt z nasz&#x105; agencj&#x105; nieruchomo&#x15b;ci.\r\nTutaj znajdziesz informacje, o kt&oacute;re prosi&#x142;e&#x15b;, dotycz&#x105;ce nast&#x119;puj&#x105;cej nieruchomo&#x15b;ci.\r\nKliknij, aby uzyska&#x107; wi&#x119;cej informacji i zobaczy&#x107; podobne domy:\r\n\r\n{{PROPERTY}}\r\n\r\nJe&#x15b;li chcesz, aby jeden z naszych doradc&oacute;w skontaktowa&#x142; si&#x119; z Tob&#x105;, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, podaj&#x105;c numer telefonu i czas, w kt&oacute;rym by&#x142;by&#x15b; w stanie odebra&#x107; telefonlub wiadomo&#x15b;&#x107; SMS.\r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas&#039;),
    (2,&#039;Initial response with telephone&#039;,&#039;Respuesta Inicial con tel&eacute;fono&#039;,&#039;Resposta inicial amb n&uacute;mero de tel&egrave;fon&#039;,&#039;F&oslash;rste svar med telefonnummer&#039;,&#039;Erste Antwort mit Telefonnummer&#039;,&#039;Initial response with telephone number&#039;,&#039;Respuesta Inicial con tel&eacute;fono&#039;,&#039;Ensimm&auml;inen vastaus ja puhelinnumero&#039;,&#039;R&eacute;ponse initiale avec num&eacute;ro de t&eacute;l&eacute;phone&#039;,&#039;Fyrsta svar me&eth; s&iacute;man&uacute;meri&#039;,&#039;Eerste antwoord met telefoonnummer&#039;,&#039;F&oslash;rste svar med telefon&#039;,&#039;&#x41f;&#x435;&#x440;&#x432;&#x43e;&#x43d;&#x430;&#x447;&#x430;&#x43b;&#x44c;&#x43d;&#x44b;&#x439; &#x43e;&#x442;&#x432;&#x435;&#x442; &#x441; &#x443;&#x43a;&#x430;&#x437;&#x430;&#x43d;&#x438;&#x435;&#x43c; &#x43d;&#x43e;&#x43c;&#x435;&#x440;&#x430; &#x442;&#x435;&#x43b;&#x435;&#x444;&#x43e;&#x43d;&#x430;&#039;,&#039;F&ouml;rsta svar med telefonnummer&#039;,&#039;&#x5e26;&#x7535;&#x8bdd;&#x53f7;&#x7801;&#x7684;&#x521d;&#x6b65;&#x7b54;&#x590d;&#039;,&#039;Wst&#x119;pna odpowied&#x17a; wraz z numerem telefonu&#039;,&#039;Gr&agrave;cies per contactar amb la nostra ag&egrave;ncia immobili&agrave;ria.\r\nAqu&iacute; tens la informaci&oacute; que has sol&middot;licitat sobre la seg&uuml;ent propietat.\r\nPodeu fer clic per a m&eacute;s informaci&oacute; i cases similars:\r\n\r\n{{PROPERTY}}\r\n\r\nSi voleu que un dels nostres assessors es posin en contacte amb vosaltres, responeu a aquest correu electr&ograve;nic indicant una hora en qu&egrave; us convindria rebre una trucada o un whatsapp.\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;Tak for din henvendelse til vores ejendomsm&aelig;glerfirma.\r\nHer har du de oplysninger, du har anmodet om om f&oslash;lgende ejendom.\r\nDu kan klikke for mere information og lignende huse:\r\n\r\n{{PROPERTY}}\r\n\r\nHvis du &oslash;nsker, at en af vores r&aring;dgivere kontakter dig, bedes du svare p&aring; denne e-mail og angive et tidspunkt, hvor det vil v&aelig;re praktisk for dig at modtage et opkald eller whatsapp.\r\n\r\nMed venlig hilsen og tak for din tid&#039;,&#039;Vielen Dank, dass Sie unser Immobilienb&uuml;ro kontaktiert haben.\r\nHier finden Sie die von Ihnen gew&uuml;nschten Informationen zu folgender Immobilie.\r\nF&uuml;r weitere Informationen und &auml;hnliche H&auml;user k&ouml;nnen Sie hier klicken:\r\n\r\n{{PROPERTY}}\r\n\r\nWenn Sie m&ouml;chten, dass sich einer unserer Berater mit Ihnen in Verbindung setzt, antworten Sie bitte auf diese E-Mail und geben Sie eine Zeit an, zu der Sie gerneangerufen oder per Whatsapp kontaktiert werden m&ouml;chten.\r\n\r\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit&#039;,&#039;Thank you for contacting our real estate agency.\r\nHere you have the information you have requested about the following property.\r\nYou can click for more information and similar houses:\r\n\r\n{{PROPERTY}}\r\n\r\nIf you would like one of our advisors to contact you, please reply to this email, indicating a time when it would be convenient for you to receive a call or whatsapp.\r\n\r\nBest regards and thank you for your time&#039;,&#039;Gracias por contactar con nuestra inmobiliaria.\r\nAqu&iacute; tienes la informaci&oacute;n que nos has solicitado sobre la siguiente propiedad.\r\nPuedes hacer clic para m&aacute;s informaci&oacute;n y casas similares:\r\n\r\n{{PROPERTY}}\r\n\r\nSi quiere que uno de nuestros asesores se ponga en contacto contigo, por favor responde a este mail, indicando una hora a la que te viene bien recibir una llamada owhatsapp.\r\n\r\nUn saludo y gracias por tu tiempo\r\n&#039;,&#039;Kiitos, ett&auml; otit yhteytt&auml; kiinteist&ouml;v&auml;litystoimistoomme.\r\nT&auml;ss&auml; on pyyt&auml;m&auml;si tiedot seuraavasta kiinteist&ouml;st&auml;.\r\nVoit klikata lis&auml;tietoja ja samankaltaisia taloja:\r\n\r\n{{PROPERTY}}\r\n\r\nJos haluat, ett&auml; joku neuvonantajistamme ottaa sinuun yhteytt&auml;, vastaa t&auml;h&auml;n s&auml;hk&ouml;postiin ja ilmoita aika, jolloin sinulle sopisi soittaa tai whatsappata.\r\n\r\nYst&auml;v&auml;llisin terveisin ja kiitos ajastasi&#039;,&#039;Merci d\&#039;avoir contact&eacute; notre agence immobili&egrave;re.\r\nVous trouverez ici les informations que vous avez demand&eacute;es concernant le bien suivant.\r\nVous pouvez cliquer pour obtenir plus d\&#039;informations et des maisons similaires :\r\n\r\n{{PROPERTY}}\r\n\r\nSi vous souhaitez que l\&#039;un de nos conseillers vous contacte, veuillez r&eacute;pondre &agrave; cet e-mail en indiquant le moment o&ugrave; il vous conviendrait de recevoir un appel ou unwhatsapp.\r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;&THORN;akka &thorn;&eacute;r fyrir a&eth; hafa samband vi&eth; fasteignas&ouml;luna okkar.\r\nH&eacute;r hefur &thorn;&uacute; uppl&yacute;singarnar sem &thorn;&uacute; hefur be&eth;i&eth; um um eftirfarandi eign.\r\n&THORN;&uacute; getur smellt fyrir frekari uppl&yacute;singar og svipu&eth; h&uacute;s:\r\n\r\n{{PROPERTY}}\r\n\r\nEf &thorn;&uacute; vilt a&eth; einn af r&aacute;&eth;gj&ouml;funum okkar hafi samband vi&eth; &thorn;ig, vinsamlegast svara&eth;u &thorn;essum t&ouml;lvup&oacute;sti og tilgreinir hven&aelig;r hentar &thorn;&eacute;r a&eth; f&aacute; s&iacute;mtal e&eth;a whatsapp.\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;mann&#039;,&#039;Dank u voor het contacteren van ons makelaarskantoor.\r\nHier heeft u de informatie die u heeft opgevraagd over het volgende object.\r\nU kunt klikken voor meer informatie en soortgelijke huizen:\r\n\r\n{{PROPERTY}}\r\n\r\nIndien u wenst dat een van onze adviseurs contact met u opneemt, gelieve deze e-mail te beantwoorden en een tijdstip op te geven dat u schikt om een telefoontje ofwhatsapp te ontvangen.\r\n\r\nMet vriendelijke groet en dank u voor uw tijd&#039;,&#039;Takk for at du kontakter v&aring;r eiendom.\r\nHer er informasjonen du har bedt om om f&oslash;lgende eiendom.\r\nDu kan klikke for mer informasjon og lignende hus:\r\n\r\n{{PROPERTY}}\r\n\r\nHvis du vil at en av v&aring;re r&aring;dgivere skal kontakte deg, vennligst svar p&aring; denne e-posten og angi et tidspunkt det passer for deg &aring; motta en samtale eller whatsapp.\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x411;&#x43b;&#x430;&#x433;&#x43e;&#x434;&#x430;&#x440;&#x438;&#x43c; &#x432;&#x430;&#x441; &#x437;&#x430; &#x43e;&#x431;&#x440;&#x430;&#x449;&#x435;&#x43d;&#x438;&#x435; &#x432; &#x43d;&#x430;&#x448;&#x435; &#x430;&#x433;&#x435;&#x43d;&#x442;&#x441;&#x442;&#x432;&#x43e; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;.\r\n&#x417;&#x434;&#x435;&#x441;&#x44c; &#x43f;&#x440;&#x435;&#x434;&#x441;&#x442;&#x430;&#x432;&#x43b;&#x435;&#x43d;&#x430; &#x437;&#x430;&#x43f;&#x440;&#x430;&#x448;&#x438;&#x432;&#x430;&#x435;&#x43c;&#x430;&#x44f; &#x432;&#x430;&#x43c;&#x438; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44f; &#x43e; &#x441;&#x43b;&#x435;&#x434;&#x443;&#x44e;&#x449;&#x435;&#x43c; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x435; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;.\r\n&#x412;&#x44b; &#x43c;&#x43e;&#x436;&#x435;&#x442;&#x435; &#x43d;&#x430;&#x436;&#x430;&#x442;&#x44c; &#x434;&#x43b;&#x44f; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x435;&#x43d;&#x438;&#x44f; &#x434;&#x43e;&#x43f;&#x43e;&#x43b;&#x43d;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x43e;&#x439; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x438; &#x438; &#x43f;&#x43e;&#x445;&#x43e;&#x436;&#x438;&#x445; &#x434;&#x43e;&#x43c;&#x43e;&#x432;:\r\n\r\n{{PROPERTY}}\r\n\r\n&#x415;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x445;&#x43e;&#x442;&#x438;&#x442;&#x435;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x43b;&#x441;&#x44f; &#x43e;&#x434;&#x438;&#x43d; &#x438;&#x437; &#x43d;&#x430;&#x448;&#x438;&#x445; &#x43a;&#x43e;&#x43d;&#x441;&#x443;&#x43b;&#x44c;&#x442;&#x430;&#x43d;&#x442;&#x43e;&#x432;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x43e;&#x442;&#x432;&#x435;&#x442;&#x44c;&#x442;&#x435; &#x43d;&#x430; &#x44d;&#x442;&#x43e; &#x43f;&#x438;&#x441;&#x44c;&#x43c;&#x43e;, &#x443;&#x43a;&#x430;&#x437;&#x430;&#x432; &#x432;&#x440;&#x435;&#x43c;&#x44f;, &#x43a;&#x43e;&#x433;&#x434;&#x430; &#x432;&#x430;&#x43c; &#x431;&#x443;&#x434;&#x435;&#x442; &#x443;&#x434;&#x43e;&#x431;&#x43d;&#x43e; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x442;&#x44c; &#x437;&#x432;&#x43e;&#x43d;&#x43e;&#x43a; &#x438;&#x43b;&#x438; Whatsapp.\r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Tack f&ouml;r att du har kontaktat v&aring;r fastighetsbyr&aring;.\r\nH&auml;r har du den information som du har beg&auml;rt om f&ouml;ljande fastighet.\r\nDu kan klicka f&ouml;r mer information och liknande hus:\r\n\r\n{{PROPERTY}}\r\n\r\nOm du vill att en av v&aring;ra r&aring;dgivare ska kontakta dig, v&auml;nligen svara p&aring; detta e-postmeddelande och ange en tidpunkt n&auml;r det skulle passa dig att f&aring; ett samtal eller enwhatsapp.\r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x611f;&#x8c22;&#x4f60;&#x4e0e;&#x6211;&#x4eec;&#x7684;&#x623f;&#x5730;&#x4ea7;&#x673a;&#x6784;&#x8054;&#x7cfb;&#x3002;\r\n&#x8fd9;&#x91cc;&#x6709;&#x4f60;&#x6240;&#x8981;&#x6c42;&#x7684;&#x5173;&#x4e8e;&#x4ee5;&#x4e0b;&#x623f;&#x4ea7;&#x7684;&#x4fe1;&#x606f;&#x3002;\r\n&#x60a8;&#x53ef;&#x4ee5;&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x66f4;&#x591a;&#x4fe1;&#x606f;&#x548c;&#x7c7b;&#x4f3c;&#x623f;&#x5c4b;&#x3002;\r\n\r\n{{PROPERTY}}\r\n\r\n&#x5982;&#x679c;&#x60a8;&#x5e0c;&#x671b;&#x6211;&#x4eec;&#x7684;&#x987e;&#x95ee;&#x4e0e;&#x60a8;&#x8054;&#x7cfb;&#xff0c;&#x8bf7;&#x56de;&#x590d;&#x6b64;&#x90ae;&#x4ef6;&#xff0c;&#x8bf4;&#x660e;&#x60a8;&#x65b9;&#x4fbf;&#x63a5;&#x6536;&#x7535;&#x8bdd;&#x6216;Whatsapp&#x7684;&#x65f6;&#x95f4;&#x3002;\r\n\r\n&#x6700;&#x8bda;&#x631a;&#x7684;&#x95ee;&#x5019;&#xff0c;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Dzi&#x119;kujemy za kontakt z nasz&#x105; agencj&#x105; nieruchomo&#x15b;ci.\r\nTutaj znajdziesz informacje, o kt&oacute;re prosi&#x142;e&#x15b;, dotycz&#x105;ce nast&#x119;puj&#x105;cej nieruchomo&#x15b;ci.\r\nKliknij, aby uzyska&#x107; wi&#x119;cej informacji i zobaczy&#x107; podobne domy:\r\n\r\n{{PROPERTY}}\r\n\r\nJe&#x15b;li chcesz, aby jeden z naszych doradc&oacute;w skontaktowa&#x142; si&#x119; z Tob&#x105;, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, podaj&#x105;c czas, w kt&oacute;rym by&#x142;by&#x15b; zainteresowany otrzymaniem telefonu lubwiadomo&#x15b;ci SMS.\r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas&#039;),
    (3,&#039;Response Follow-up&#039;,&#039;Respuesta Seguimiento&#039;,&#039;Seguiment de la resposta&#039;,&#039;Opf&oslash;lgning af svar&#039;,&#039;Antwort Follow-up&#039;,&#039;Response Follow-up&#039;,&#039;Respuesta Seguimiento&#039;,&#039;Vastaus Seuranta&#039;,&#039;Suivi de la r&eacute;ponse&#039;,&#039;Svar Eftirfylgni&#039;,&#039;Antwoord Follow-up&#039;,&#039;Respons Oppf&oslash;lging&#039;,&#039;&#x41e;&#x442;&#x432;&#x435;&#x442; &#x41f;&#x43e;&#x441;&#x43b;&#x435;&#x434;&#x443;&#x44e;&#x449;&#x438;&#x435; &#x434;&#x435;&#x439;&#x441;&#x442;&#x432;&#x438;&#x44f;&#039;,&#039;Uppf&ouml;ljning av svaret&#039;,&#039;&#x54cd;&#x5e94;&#x540e;&#x7eed;&#x884c;&#x52a8;&#039;,&#039;Odpowied&#x17a; Kontynuacja&#039;,&#039;Hola ...........................\r\n\r\nEn primer lloc, gr&agrave;cies per haver dedicat el temps a parlar amb mi.\r\nEm va encantar tenir l\&#039;oportunitat de parlar amb vosaltres sobre la vostra recerca d\&#039;habitatge:\r\n\r\n{{PROPERTY}}\r\n\r\nPer ajudar-nos a mantenir-nos en contacte, trobareu les meves dades de contacte (tel&egrave;fon m&ograve;bil i adre&ccedil;a de correu electr&ograve;nic) a sota de la meva signatura.\r\n\r\nM\&#039;agradaria aprofitar per dir-vos que podeu veure cases amb caracter&iacute;stiques similars a la nostra web,\r\n\r\nQuedo a la vostra disposici&oacute; per a qualsevol aclariment.\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;Hej ...........................\r\n\r\nF&oslash;rst og fremmest tak, fordi du tog dig tid til at tale med mig. \r\nDet var mig en forn&oslash;jelse at f&aring; lejlighed til at tale med dig om din boligs&oslash;gning:\r\n\r\n{{PROPERTY}}\r\n\r\nFor at vi kan holde kontakten, finder du mine kontaktoplysninger (mobiltelefon og e-mailadresse) under min underskrift.\r\n\r\nJeg vil gerne benytte lejligheden til at fort&aelig;lle dig, at du kan se huse med lignende egenskaber p&aring; vores hjemmeside, \r\n\r\nJeg st&aring;r til din r&aring;dighed for eventuelle afklaringer.\r\n\r\nMed venlig hilsen og tak for din tid&#039;,&#039;Hallo ...........................\r\n\r\nZun&auml;chst einmal danke ich Ihnen, dass Sie sich die Zeit genommen haben, mit mir zu sprechen. \r\nIch habe mich sehr gefreut, dass ich mit Ihnen &uuml;ber Ihre Wohnungssuche sprechen konnte:\r\n\r\n{{PROPERTY}}\r\n\r\nDamit wir in Kontakt bleiben k&ouml;nnen, finden Sie meine Kontaktdaten (Mobiltelefon und E-Mail-Adresse) unter meiner Unterschrift.\r\n\r\nBei dieser Gelegenheit m&ouml;chte ich Ihnen mitteilen, dass Sie auf unserer Website H&auml;user mit &auml;hnlichen Merkmalen sehen k&ouml;nnen, \r\n\r\nIch stehe Ihnen f&uuml;r jede Kl&auml;rung zur Verf&uuml;gung.&#039;,&#039;Hello ...........................\r\n\r\nFirstly, thank you for taking the time to speak with me. \r\nI was delighted to have the opportunity to speak with you about your housing search:\r\n\r\n{{PROPERTY}}\r\n\r\nTo help us keep in touch, you will find my contact details (mobile phone and email address) below my signature.\r\n\r\nI would like to take this opportunity to tell you that you can see houses with similar characteristics on our website, \r\n\r\nI remain at your disposal for any clarification.\r\n\r\nBest regards and thank you for your time&#039;,&#039;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\r\n\r\nEn primer lugar, gracias por dedicar su tiempo a hablar conmigo. \r\nMe ha encantado tener la oportunidad de hablar con usted sobre su b&uacute;squeda de vivienda:\r\n\r\n{{PROPERTY}}\r\n\r\nPara ayudarnos a mantener el contacto, encontrar&aacute; mis datos (tel&eacute;fono m&oacute;vil y direcci&oacute;n de correo electr&oacute;nico) debajo de mi firma.\r\n\r\nAprovecho para comentarte, en nuestra web, puedes ver casas con similares caracter&iacute;sticas, \r\n\r\nQuedo a tu disposici&oacute;n para cualquier aclaraci&oacute;n.\r\n\r\nUn saludo  y gracias por tu tiempo&#039;,&#039;Hei ...........................\r\n\r\nEnsinn&auml;kin, kiitos, ett&auml; otit aikaa puhua kanssani. \r\nOli ilo saada puhua kanssanne asuntohakemistanne:\r\n\r\n{{PROPERTY}}\r\n\r\nJotta voisimme pit&auml;&auml; yhteytt&auml;, l&ouml;yd&auml;t yhteystietoni (matkapuhelin ja s&auml;hk&ouml;postiosoite) allekirjoitukseni alapuolelta.\r\n\r\nHaluaisin k&auml;ytt&auml;&auml; tilaisuutta hyv&auml;kseni ja kertoa teille, ett&auml; voitte tutustua ominaisuuksiltaan samankaltaisiin taloihin verkkosivuillamme, \r\n\r\nOlen k&auml;ytett&auml;viss&auml;nne kaikkia selvityksi&auml; varten.\r\n\r\nYst&auml;v&auml;llisin terveisin ja kiitos ajastanne&#039;,&#039;Bonjour ...........................\r\n\r\nTout d\&#039;abord, je vous remercie d\&#039;avoir pris le temps de me parler. \r\nJ\&#039;ai &eacute;t&eacute; ravi d\&#039;avoir l\&#039;occasion de parler avec vous de votre recherche de logement :\r\n\r\n{{PROPERTY}}\r\n\r\nPour nous aider &agrave; rester en contact, vous trouverez mes coordonn&eacute;es (t&eacute;l&eacute;phone portable et adresse &eacute;lectronique) sous ma signature.\r\n\r\nJe profite de l\&#039;occasion pour vous dire que vous pouvez voir des maisons aux caract&eacute;ristiques similaires sur notre site web, \r\n\r\nJe reste &agrave; votre disposition pour toute clarification.\r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;Hall&oacute; ...........................\r\n\r\n&Iacute; fyrsta lagi, takk fyrir a&eth; gefa &thorn;&eacute;r t&iacute;ma til a&eth; tala vi&eth; mig.\r\n&THORN;a&eth; gladdi mig a&eth; f&aacute; t&aelig;kif&aelig;ri til a&eth; r&aelig;&eth;a vi&eth; &thorn;ig um h&uacute;sn&aelig;&eth;isleit &thorn;&iacute;na:\r\n\r\n{{PROPERTY}}\r\n\r\nTil a&eth; hj&aacute;lpa okkur a&eth; halda sambandi finnur&eth;u tengili&eth;auppl&yacute;singarnar m&iacute;nar (fars&iacute;mi og netfang) fyrir ne&eth;an undirskriftina m&iacute;na.\r\n\r\n&Eacute;g vil nota t&aelig;kif&aelig;ri&eth; og segja ykkur a&eth; &thorn;i&eth; geti&eth; s&eacute;&eth; h&uacute;s me&eth; svipa&eth;a eiginleika &aacute; heimas&iacute;&eth;unni okkar,\r\n\r\n&Eacute;g er &aacute;fram til rei&eth;u fyrir allar sk&yacute;ringar.\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;mann&#039;,&#039;Hallo ...........................\r\n\r\nTen eerste, dank u dat u de tijd neemt om met mij te spreken. \r\nIk was verheugd de kans te krijgen met u te spreken over uw zoektocht naar een woning:\r\n\r\n{{PROPERTY}}\r\n\r\nOm ons te helpen contact te houden, vindt u mijn contactgegevens (mobiele telefoon en e-mailadres) onder mijn handtekening.\r\n\r\nIk wil van deze gelegenheid gebruik maken om u te zeggen dat u huizen met soortgelijke kenmerken op onze website kunt bekijken, \r\n\r\nIk blijf tot uw beschikking voor elke verduidelijking.\r\n\r\nMet vriendelijke groet en dank u voor uw tijd&#039;,&#039;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\r\n\r\nF&oslash;rst av alt, takk for at du tok deg tid til &aring; snakke med meg.\r\nJeg har v&aelig;rt glad for &aring; f&aring; muligheten til &aring; snakke med deg om boligs&oslash;ket ditt:\r\n\r\n{{PROPERTY}}\r\n\r\nFor &aring; hjelpe oss med &aring; holde kontakten finner du detaljene mine (mobiltelefon og e-postadresse) under signaturen min.\r\n\r\nJeg benytter anledningen til &aring; fortelle deg at p&aring; nettsiden v&aring;r kan du se hus med lignende egenskaper,\r\n\r\nJeg st&aring;r til din disposisjon for enhver avklaring.\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x417;&#x434;&#x440;&#x430;&#x432;&#x441;&#x442;&#x432;&#x443;&#x439;&#x442;&#x435; ...........................\r\n\r\n&#x412;&#x43e;-&#x43f;&#x435;&#x440;&#x432;&#x44b;&#x445;, &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e;, &#x447;&#x442;&#x43e; &#x43d;&#x430;&#x448;&#x43b;&#x438; &#x432;&#x440;&#x435;&#x43c;&#x44f; &#x43f;&#x43e;&#x433;&#x43e;&#x432;&#x43e;&#x440;&#x438;&#x442;&#x44c; &#x441;&#x43e; &#x43c;&#x43d;&#x43e;&#x439;. \r\n&#x42f; &#x431;&#x44b;&#x43b; &#x440;&#x430;&#x434; &#x432;&#x43e;&#x437;&#x43c;&#x43e;&#x436;&#x43d;&#x43e;&#x441;&#x442;&#x438; &#x43f;&#x43e;&#x433;&#x43e;&#x432;&#x43e;&#x440;&#x438;&#x442;&#x44c; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x43e; &#x432;&#x430;&#x448;&#x435;&#x43c; &#x43f;&#x43e;&#x438;&#x441;&#x43a;&#x435; &#x436;&#x438;&#x43b;&#x44c;&#x44f;:\r\n\r\n{{PROPERTY}}\r\n\r\n&#x427;&#x442;&#x43e;&#x431;&#x44b; &#x43f;&#x43e;&#x43c;&#x43e;&#x447;&#x44c; &#x43d;&#x430;&#x43c; &#x43f;&#x43e;&#x434;&#x434;&#x435;&#x440;&#x436;&#x438;&#x432;&#x430;&#x442;&#x44c; &#x441;&#x432;&#x44f;&#x437;&#x44c;, &#x432;&#x44b; &#x43d;&#x430;&#x439;&#x434;&#x435;&#x442;&#x435; &#x43c;&#x43e;&#x438; &#x43a;&#x43e;&#x43d;&#x442;&#x430;&#x43a;&#x442;&#x43d;&#x44b;&#x435; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x435; (&#x43c;&#x43e;&#x431;&#x438;&#x43b;&#x44c;&#x43d;&#x44b;&#x439; &#x442;&#x435;&#x43b;&#x435;&#x444;&#x43e;&#x43d; &#x438; &#x430;&#x434;&#x440;&#x435;&#x441; &#x44d;&#x43b;&#x435;&#x43a;&#x442;&#x440;&#x43e;&#x43d;&#x43d;&#x43e;&#x439; &#x43f;&#x43e;&#x447;&#x442;&#x44b;) &#x43f;&#x43e;&#x434; &#x43c;&#x43e;&#x435;&#x439; &#x43f;&#x43e;&#x434;&#x43f;&#x438;&#x441;&#x44c;&#x44e;.\r\n\r\n&#x41f;&#x43e;&#x43b;&#x44c;&#x437;&#x443;&#x44f;&#x441;&#x44c; &#x441;&#x43b;&#x443;&#x447;&#x430;&#x435;&#x43c;, &#x445;&#x43e;&#x447;&#x443; &#x441;&#x43e;&#x43e;&#x431;&#x449;&#x438;&#x442;&#x44c; &#x432;&#x430;&#x43c;, &#x447;&#x442;&#x43e; &#x432;&#x44b; &#x43c;&#x43e;&#x436;&#x435;&#x442;&#x435; &#x43f;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x434;&#x43e;&#x43c;&#x430; &#x441; &#x43f;&#x43e;&#x445;&#x43e;&#x436;&#x438;&#x43c;&#x438; &#x445;&#x430;&#x440;&#x430;&#x43a;&#x442;&#x435;&#x440;&#x438;&#x441;&#x442;&#x438;&#x43a;&#x430;&#x43c;&#x438; &#x43d;&#x430; &#x43d;&#x430;&#x448;&#x435;&#x43c; &#x441;&#x430;&#x439;&#x442;&#x435;, \r\n\r\n&#x42f; &#x43e;&#x441;&#x442;&#x430;&#x44e;&#x441;&#x44c; &#x432; &#x432;&#x430;&#x448;&#x435;&#x43c; &#x440;&#x430;&#x441;&#x43f;&#x43e;&#x440;&#x44f;&#x436;&#x435;&#x43d;&#x438;&#x438; &#x434;&#x43b;&#x44f; &#x43b;&#x44e;&#x431;&#x44b;&#x445; &#x443;&#x442;&#x43e;&#x447;&#x43d;&#x435;&#x43d;&#x438;&#x439;.\r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x443;&#x434;&#x435;&#x43b;&#x435;&#x43d;&#x43d;&#x43e;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Hej ...........................\r\n\r\nF&ouml;rst och fr&auml;mst vill jag tacka er f&ouml;r att ni tog er tid att tala med mig. \r\nDet var roligt att f&aring; tillf&auml;lle att tala med dig om din bostadss&ouml;kning:\r\n\r\n{{PROPERTY}}\r\n\r\nF&ouml;r att vi ska kunna h&aring;lla kontakten hittar du mina kontaktuppgifter (mobiltelefon och e-postadress) under min signatur.\r\n\r\nJag vill ta tillf&auml;llet i akt att ber&auml;tta att du kan se hus med liknande egenskaper p&aring; v&aring;r webbplats, \r\n\r\nJag st&aring;r till ert f&ouml;rfogande f&ouml;r eventuella f&ouml;rtydliganden.\r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x4f60;&#x597d;&#xff0c;...........................\r\n\r\n&#x9996;&#x5148;&#xff0c;&#x611f;&#x8c22;&#x60a8;&#x62bd;&#x51fa;&#x65f6;&#x95f4;&#x4e0e;&#x6211;&#x4ea4;&#x8c08;&#x3002;\r\n&#x6211;&#x5f88;&#x9ad8;&#x5174;&#x6709;&#x673a;&#x4f1a;&#x4e0e;&#x60a8;&#x8c08;&#x53ca;&#x60a8;&#x7684;&#x4f4f;&#x623f;&#x641c;&#x7d22;&#x3002;\r\n\r\n{{PROPERTY}}\r\n\r\n&#x4e3a;&#x4e86;&#x5e2e;&#x52a9;&#x6211;&#x4eec;&#x4fdd;&#x6301;&#x8054;&#x7cfb;&#xff0c;&#x4f60;&#x53ef;&#x4ee5;&#x5728;&#x6211;&#x7684;&#x7b7e;&#x540d;&#x4e0b;&#x9762;&#x627e;&#x5230;&#x6211;&#x7684;&#x8be6;&#x7ec6;&#x8054;&#x7cfb;&#x65b9;&#x5f0f;&#xff08;&#x624b;&#x673a;&#x548c;&#x7535;&#x5b50;&#x90ae;&#x4ef6;&#x5730;&#x5740;&#xff09;&#x3002;\r\n\r\n&#x6211;&#x60f3;&#x501f;&#x6b64;&#x673a;&#x4f1a;&#x544a;&#x8bc9;&#x60a8;&#xff0c;&#x60a8;&#x53ef;&#x4ee5;&#x5728;&#x6211;&#x4eec;&#x7684;&#x7f51;&#x7ad9;&#x4e0a;&#x770b;&#x5230;&#x5177;&#x6709;&#x7c7b;&#x4f3c;&#x7279;&#x5f81;&#x7684;&#x623f;&#x5c4b;&#x3002;\r\n\r\n&#x5982;&#x6709;&#x4efb;&#x4f55;&#x7591;&#x95ee;&#xff0c;&#x6211;&#x5c06;&#x968f;&#x65f6;&#x4e3a;&#x60a8;&#x89e3;&#x7b54;&#x3002;\r\n\r\n&#x81f4;&#x4ee5;&#x6700;&#x8bda;&#x631a;&#x7684;&#x95ee;&#x5019;&#xff0c;&#x5e76;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Witaj ...........................\r\n\r\nPo pierwsze, dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cenie czasu na rozmow&#x119; ze mn&#x105;. \r\nCiesz&#x119; si&#x119;, &#x17c;e mia&#x142;am okazj&#x119; porozmawia&#x107; z Pa&#x144;stwem o poszukiwaniu mieszkania:\r\n\r\n{{PROPERTY}}\r\n\r\nAby&#x15b;my mogli pozosta&#x107; w kontakcie, pod moim podpisem znajdziesz moje dane kontaktowe (telefon kom&oacute;rkowy i adres e-mail).\r\n\r\nKorzystaj&#x105;c z okazji, pragn&#x119; poinformowa&#x107;, &#x17c;e na naszej stronie internetowej mo&#x17c;na obejrze&#x107; domy o podobnej charakterystyce, \r\n\r\nPozostaj&#x119; do Pa&#x144;stwa dyspozycji w przypadku jakichkolwiek wyja&#x15b;nie&#x144;.\r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas&#039;),
    (4,&#039;Visit confirmation&#039;,&#039;Confirmaci&oacute;n visita&#039;,&#039;Confirmaci&oacute; de visita&#039;,&#039;Bekr&aelig;ftelse af bes&oslash;g&#039;,&#039;Best&auml;tigung des Besuchs&#039;,&#039;Confirmation of visit&#039;,&#039;Confirmaci&oacute;n visita&#039;,&#039;Vahvistus vierailusta&#039;,&#039;Confirmation de la visite&#039;,&#039;Sta&eth;festing &aacute; heims&oacute;kn&#039;,&#039;Bevestiging van het bezoek&#039;,&#039;Konfirmasjonsbes&oslash;k&#039;,&#039;&#x41f;&#x43e;&#x434;&#x442;&#x432;&#x435;&#x440;&#x436;&#x434;&#x435;&#x43d;&#x438;&#x435; &#x43f;&#x43e;&#x441;&#x435;&#x449;&#x435;&#x43d;&#x438;&#x44f;&#039;,&#039;Bekr&auml;ftelse av bes&ouml;ket&#039;,&#039;&#x8bbf;&#x95ee;&#x7684;&#x786e;&#x8ba4;&#039;,&#039;Potwierdzenie wizyty&#039;,&#039;Hola ...........................\r\nAquesta &eacute;s la confirmaci&oacute; de la cita per visitar la propietat:\r\nData: ......................\r\nTemps: ......................\r\nPunt de trobada: ......................\r\nPropietats per visualitzar:\r\n\r\n{{PROPERTY}} \r\n\r\nConfirmeu-me si les dades s&oacute;n correctes:\r\n......................\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;Hej ...........................\r\nDette er bekr&aelig;ftelsen p&aring; aftalen om besigtigelse af ejendommen:\r\nDato: ......................\r\nTid: ......................\r\nM&oslash;dested: ......................\r\nEjendomme, der skal besigtiges: \r\n\r\n{{PROPERTY}} \r\n\r\nBekr&aelig;ft mig, hvis dataene er korrekte:\r\n......................\r\n\r\nMed venlig hilsen og tak for din tid&#039;,&#039;Hallo ...........................\r\nDies ist die Best&auml;tigung des Termins zur Besichtigung der Immobilie:\r\nDatum: ......................\r\nZeit: ......................\r\nTreffpunkt: ......................\r\nEigenschaften zur Ansicht: \r\n\r\n{{PROPERTY}}\r\n\r\nBest&auml;tigen Sie mir, ob die Daten korrekt sind:\r\n......................\r\n\r\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit&#039;,&#039;Hello ...........................\r\nThis is the confirmation of the appointment to visit the property:\r\nDate: ......................\r\nTime: ......................\r\nMeeting point: ......................\r\nProperties to view: \r\n\r\n{{PROPERTY}} \r\n\r\nConfirm me if the data is correct:\r\n......................\r\n\r\nBest regards and thanks for your time&#039;,&#039;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\r\nEsta es la confirmaci&oacute;n de la cita para visitar la vivienda:\r\nFecha: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nHora: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nPunto de encuentro: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nPropiedades para ver: \r\n\r\n{{PROPERTY}} \r\n\r\nConf&iacute;rmame si los datos son correctos:\r\n&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nUn saludo  y gracias por tu tiempo&#039;,&#039;Hei ...........................\r\nT&auml;m&auml; on vahvistus kiinteist&ouml;&ouml;n tutustumista koskevasta tapaamisesta:\r\nP&auml;iv&auml;m&auml;&auml;r&auml;: ......................\r\nAika: ......................\r\nTapaamispaikka: ......................\r\nTarkasteltavat kiinteist&ouml;t: \r\n\r\n{{PROPERTY}} \r\n\r\nVahvista minulle, ovatko tiedot oikein:\r\n......................\r\n\r\nTerveisin ja kiitos ajastanne&#039;,&#039;Bonjour ...........................\r\nIl s\&#039;agit de la confirmation du rendez-vous pour la visite du bien :\r\nDate : ......................\r\nHeure : ......................\r\nPoint de rencontre : ......................\r\nPropri&eacute;t&eacute;s &agrave; visualiser : \r\n\r\n{{PROPERTY}}\r\n\r\nConfirmez-moi si les donn&eacute;es sont correctes :\r\n......................\r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;Hall&oacute; ...........................\r\n&THORN;etta er sta&eth;festing &aacute; skipun um a&eth; heims&aelig;kja gistista&eth;inn:\r\nDagsetning: ................................\r\nT&iacute;mi: ........................\r\nFundarsta&eth;ur: ........................\r\nEiginleikar til a&eth; sko&eth;a:\r\n\r\n{{PROPERTY}} \r\n\r\nSta&eth;festu mig ef g&ouml;gnin eru r&eacute;tt:\r\n......................\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;ma &thorn;inn&#039;,&#039;Hallo ...........................\r\nDit is de bevestiging van de afspraak om de woning te bezichtigen:\r\nDatum: ......................\r\nTijd: ......................\r\nTrefpunt: ......................\r\nEigenschappen om te bekijken: \r\n\r\n{{PROPERTY}} \r\n\r\nBevestig me of de gegevens juist zijn:\r\n......................\r\n\r\nMet vriendelijke groet en bedankt voor uw tijd&#039;,&#039;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\r\nDette er bekreftelsen p&aring; avtalen om &aring; bes&oslash;ke huset:\r\nDato: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nTime: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nM&oslash;tepunkt: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nEgenskaper &aring; se:\r\n\r\n{{PROPERTY}}\r\n\r\nVennligst bekreft om dataene er korrekte:\r\n&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x417;&#x434;&#x440;&#x430;&#x432;&#x441;&#x442;&#x432;&#x443;&#x439;&#x442;&#x435; ...........................\r\n&#x42d;&#x442;&#x43e; &#x43f;&#x43e;&#x434;&#x442;&#x432;&#x435;&#x440;&#x436;&#x434;&#x435;&#x43d;&#x438;&#x435; &#x437;&#x430;&#x43f;&#x438;&#x441;&#x438; &#x43d;&#x430; &#x43f;&#x43e;&#x441;&#x435;&#x449;&#x435;&#x43d;&#x438;&#x435; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x430;:\r\n&#x414;&#x430;&#x442;&#x430;: ......................\r\n&#x412;&#x440;&#x435;&#x43c;&#x44f;: ......................\r\n&#x41c;&#x435;&#x441;&#x442;&#x43e; &#x432;&#x441;&#x442;&#x440;&#x435;&#x447;&#x438;: ......................\r\n&#x41d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c; &#x434;&#x43b;&#x44f; &#x43f;&#x440;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x430;: \r\n\r\n{{PROPERTY}} \r\n\r\n&#x41f;&#x43e;&#x434;&#x442;&#x432;&#x435;&#x440;&#x434;&#x438;&#x442;&#x435; &#x43f;&#x440;&#x430;&#x432;&#x438;&#x43b;&#x44c;&#x43d;&#x43e;&#x441;&#x442;&#x44c; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x445;:\r\n......................\r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Hej ...........................\r\nDetta &auml;r en bekr&auml;ftelse p&aring; att du har f&aring;tt ett m&ouml;te f&ouml;r att bes&ouml;ka fastigheten:\r\nDatum: ......................\r\nTid: ......................\r\nM&ouml;tesplats: ......................\r\nEgenskaper att visa: \r\n\r\n{{PROPERTY}} \r\n\r\nBekr&auml;fta om uppgifterna &auml;r korrekta:\r\n......................\r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x4f60;&#x597d; ...........................\r\n&#x8fd9;&#x662f;&#x9884;&#x7ea6;&#x53c2;&#x89c2;&#x623f;&#x4ea7;&#x7684;&#x786e;&#x8ba4;&#x51fd;&#x3002;\r\n&#x65e5;&#x671f;&#xff1a;......................\r\n&#x65f6;&#x95f4;&#xff1a;......................\r\n&#x96c6;&#x5408;&#x70b9;&#xff1a;......................\r\n&#x8981;&#x67e5;&#x770b;&#x7684;&#x623f;&#x4ea7;&#x3002;\r\n\r\n{{PROPERTY}} \r\n\r\n&#x8bf7;&#x786e;&#x8ba4;&#x6211;&#x7684;&#x6570;&#x636e;&#x662f;&#x5426;&#x6b63;&#x786e;&#x3002;\r\n......................\r\n\r\n&#x6700;&#x597d;&#x7684;&#x95ee;&#x5019;&#x548c;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Witaj ...........................\r\nJest to potwierdzenie um&oacute;wienia si&#x119; na wizyt&#x119; w obiekcie:\r\nData: ......................\r\nCzas: ......................\r\nMiejsce spotkania: ......................\r\nW&#x142;a&#x15b;ciwo&#x15b;ci do przegl&#x105;dania: \r\n\r\n{{PROPERTY}}\r\n\r\nPotwierd&#x17a;, czy dane s&#x105; poprawne:\r\n......................\r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\r\n&#039;),
    (5,&#039;Confirmation of listing&#039;,&#039;Confirmaci&oacute;n de listado&#039;,&#039;Confirmaci&oacute; de la llista&#039;,&#039;Bekr&aelig;ftelse af notering&#039;,&#039;Best&auml;tigung der Auflistung&#039;,&#039;Listing confirmation&#039;,&#039;Confirmaci&oacute;n de listado&#039;,&#039;Luetteloinnin vahvistus&#039;,&#039;Confirmation de l\&#039;inscription&#039;,&#039;Sta&eth;festing skr&aacute;ningar&#039;,&#039;Bevestiging van de lijst&#039;,&#039;Oppf&oslash;ringsbekreftelse&#039;,&#039;&#x41f;&#x43e;&#x434;&#x442;&#x432;&#x435;&#x440;&#x436;&#x434;&#x435;&#x43d;&#x438;&#x435; &#x43b;&#x438;&#x441;&#x442;&#x438;&#x43d;&#x433;&#x430;&#039;,&#039;Bekr&auml;ftelse av listning&#039;,&#039;&#x4e0a;&#x5e02;&#x786e;&#x8ba4;&#039;,&#039;Potwierdzenie wpisu na list&#x119;&#039;,&#039;Hola ......................\r\n\r\nAquesta &eacute;s una confirmaci&oacute; per con&egrave;ixer la teva propietat i fer la recollida de dades necess&agrave;ries per registrar la teva propietat al nostre sistema i posar-la a la venda:\r\n\r\nData: ......................\r\nTemps: ......................\r\nPersona de contacte: ......................\r\n\r\nLa persona que visitar&agrave; el vostre immoble t&eacute; molta experi&egrave;ncia i coneixement del mercat immobiliari i us podr&agrave; ajudar i assessorar per aconseguir el millor preu possible i respondre les vostres preguntes sobre el proc&eacute;s de venda.\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;Hej ......................\r\n\r\nDette er en bekr&aelig;ftelse p&aring; at m&oslash;de din ejendom og foretage den n&oslash;dvendige dataindsamling for at registrere din ejendom i vores system og s&aelig;tte den til salg: \r\n\r\nDato: ......................\r\nTid: ......................\r\nKontaktperson: ......................\r\n\r\nDen person, der bes&oslash;ger din ejendom, har stor erfaring og viden om ejendomsmarkedet og vil kunne hj&aelig;lpe og r&aring;dgive dig med at opn&aring; den bedst mulige pris og besvare dine sp&oslash;rgsm&aring;l om salgsprocessen. \r\n\r\nMed venlig hilsen og tak for din tid&#039;,&#039;Hallo ......................\r\n\r\nDies ist eine Best&auml;tigung, um Ihre Immobilie kennenzulernen und die notwendigen Daten zu erheben, um Ihre Immobilie in unserem System zu registrieren und zum Verkaufanzubieten: \r\n\r\nDatum: ......................\r\nZeit: ......................\r\nKontaktperson: ......................\r\n\r\nDie Person, die Ihre Immobilie besichtigt, verf&uuml;gt &uuml;ber viel Erfahrung und Wissen &uuml;ber den Immobilienmarkt und kann Ihnen helfen und Sie beraten, um den bestm&ouml;glichenPreis zu erzielen und Ihre Fragen zum Verkaufsprozess zu beantworten. \r\n\r\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit&#039;,&#039;Hello ......................\r\n\r\nThis is a confirmation to meet your property and make the necessary data collection to register your property in our system and put it for sale: \r\n\r\nDate: ......................\r\nTime: ......................\r\nContact person: ......................\r\n\r\nThe person who will visit your property has a lot of experience and knowledge of the property market and will be able to help and advise you to achieve the bestpossible price and answer your questions about the selling process. \r\n\r\nBest regards and thank you for your time&#039;,&#039;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nEsta es una confirmaci&oacute;n para quedar en su propiedad y realizar la toma de datos necesaria para dar de alta su propiedad en nuestro sistema y ponerla en venta: \r\n\r\nFecha: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nHora: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nPersona de contacto: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nLa persona que visitar&aacute; su propiedad tiene mucha experiencia y conocimiento del mercado inmobiliario y podr&aacute; ayudarlo y asesorarlo para lograr el mejor precio posible y responder a sus preguntas sobre proceso de venta. \r\n\r\nUn saludo  y gracias por tu tiempo&#039;,&#039;Hei ......................\r\n\r\nT&auml;m&auml; on vahvistus tapaamaan omaisuuttasi ja suorittamaan tarvittava tiedonkeruu, jotta omaisuutesi voidaan rekister&ouml;id&auml; j&auml;rjestelm&auml;&auml;mme ja laittaa se myyntiin: \r\n\r\nP&auml;iv&auml;ys: ......................\r\nAika: ......................\r\nYhteyshenkil&ouml;: ......................\r\n\r\nHenkil&ouml;ll&auml;, joka k&auml;y kiinteist&ouml;si luona, on paljon kokemusta ja tietoa kiinteist&ouml;markkinoista, ja h&auml;n pystyy auttamaan ja neuvomaan sinua parhaan mahdollisen hinnan saamiseksi ja vastaamaan myyntiprosessia koskeviin kysymyksiisi. \r\n\r\nYst&auml;v&auml;llisin terveisin ja kiitos ajastanne&#039;,&#039;Bonjour ......................\r\n\r\nIl s\&#039;agit d\&#039;une confirmation pour rencontrer votre propri&eacute;t&eacute; et effectuer la collecte des donn&eacute;es n&eacute;cessaires pour enregistrer votre propri&eacute;t&eacute; dans notre syst&egrave;me et lamettre en vente : \r\n\r\nDate : ......................\r\nHeure : ......................\r\nPersonne de contact : ......................\r\n\r\nLa personne qui visitera votre propri&eacute;t&eacute; a beaucoup d\&#039;exp&eacute;rience et de connaissances du march&eacute; immobilier et pourra vous aider et vous conseiller pour obtenir lemeilleur prix possible et r&eacute;pondre &agrave; vos questions sur le processus de vente. \r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;Hall&oacute; ......................\r\n\r\n&THORN;etta er sta&eth;festing til a&eth; m&aelig;ta eign &thorn;inni og gera nau&eth;synlega gagnas&ouml;fnun til a&eth; skr&aacute; eign &thorn;&iacute;na &iacute; kerfi&eth; okkar og setja hana &aacute; s&ouml;lu:\r\n\r\nDagsetning: ................................\r\nT&iacute;mi: ........................\r\nTengili&eth;ur: ........................\r\n\r\nS&aacute; sem mun heims&aelig;kja eignina &thorn;&iacute;na hefur mikla reynslu og &thorn;ekkingu &aacute; fasteignamarka&eth;inum og getur a&eth;sto&eth;a&eth; og r&aacute;&eth;lagt &thorn;&eacute;r til a&eth; n&aacute; besta m&ouml;gulega ver&eth;i og svara&eth; spurningum &thorn;&iacute;num um s&ouml;luferli&eth;.\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;mann&#039;,&#039;Hallo ......................\r\n\r\nDit is een bevestiging om uw eigendom te ontmoeten en de nodige gegevens te verzamelen om uw eigendom in ons systeem te registreren en het te koop aan te bieden: \r\n\r\nDatum: ......................\r\nTijd: ......................\r\nContactpersoon: ......................\r\n\r\nDe persoon die uw eigendom zal bezoeken heeft veel ervaring en kennis van de vastgoedmarkt en zal u kunnen helpen en adviseren om de best mogelijke prijs te bereiken enuw vragen over het verkoopproces te beantwoorden. \r\n\r\nMet vriendelijke groet en dank u voor uw tijd&#039;,&#039;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nDette er en bekreftelse p&aring; &aring; bo i din eiendom og utf&oslash;re n&oslash;dvendig datainnsamling for &aring; registrere din eiendom i v&aring;rt system og legge den ut for salg:\r\n\r\nDato: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nTime: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\nKontaktperson: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nDen som skal bes&oslash;ke din eiendom har mye erfaring og kunnskap om eiendomsmarkedet og vil kunne hjelpe og gi deg r&aring;d for &aring; oppn&aring; best mulig pris og svare p&aring; dine sp&oslash;rsm&aring;lom salgsprosessen.\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x417;&#x434;&#x440;&#x430;&#x432;&#x441;&#x442;&#x432;&#x443;&#x439;&#x442;&#x435; ......................\r\n\r\n&#x42d;&#x442;&#x43e; &#x43f;&#x43e;&#x434;&#x442;&#x432;&#x435;&#x440;&#x436;&#x434;&#x435;&#x43d;&#x438;&#x435; &#x434;&#x43b;&#x44f; &#x432;&#x441;&#x442;&#x440;&#x435;&#x447;&#x438; &#x441; &#x432;&#x430;&#x448;&#x435;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c;&#x44e; &#x438; &#x441;&#x431;&#x43e;&#x440;&#x430; &#x43d;&#x435;&#x43e;&#x431;&#x445;&#x43e;&#x434;&#x438;&#x43c;&#x44b;&#x445; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x445; &#x434;&#x43b;&#x44f; &#x440;&#x435;&#x433;&#x438;&#x441;&#x442;&#x440;&#x430;&#x446;&#x438;&#x438; &#x432;&#x430;&#x448;&#x435;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438; &#x432; &#x43d;&#x430;&#x448;&#x435;&#x439; &#x441;&#x438;&#x441;&#x442;&#x435;&#x43c;&#x435; &#x438; &#x432;&#x44b;&#x441;&#x442;&#x430;&#x432;&#x43b;&#x435;&#x43d;&#x438;&#x44f; &#x435;&#x435; &#x43d;&#x430; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x436;&#x443;: \r\n\r\n&#x414;&#x430;&#x442;&#x430;: ......................\r\n&#x412;&#x440;&#x435;&#x43c;&#x44f;: ......................\r\n&#x41a;&#x43e;&#x43d;&#x442;&#x430;&#x43a;&#x442;&#x43d;&#x43e;&#x435; &#x43b;&#x438;&#x446;&#x43e;: ......................\r\n\r\n&#x427;&#x435;&#x43b;&#x43e;&#x432;&#x435;&#x43a;, &#x43a;&#x43e;&#x442;&#x43e;&#x440;&#x44b;&#x439; &#x43f;&#x43e;&#x441;&#x435;&#x442;&#x438;&#x442; &#x432;&#x430;&#x448;&#x443; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c;, &#x438;&#x43c;&#x435;&#x435;&#x442; &#x431;&#x43e;&#x43b;&#x44c;&#x448;&#x43e;&#x439; &#x43e;&#x43f;&#x44b;&#x442; &#x438; &#x437;&#x43d;&#x430;&#x43d;&#x438;&#x44f; &#x440;&#x44b;&#x43d;&#x43a;&#x430; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438; &#x438; &#x441;&#x43c;&#x43e;&#x436;&#x435;&#x442; &#x43f;&#x43e;&#x43c;&#x43e;&#x447;&#x44c; &#x438; &#x43f;&#x440;&#x43e;&#x43a;&#x43e;&#x43d;&#x441;&#x443;&#x43b;&#x44c;&#x442;&#x438;&#x440;&#x43e;&#x432;&#x430;&#x442;&#x44c; &#x432;&#x430;&#x441;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x434;&#x43e;&#x441;&#x442;&#x438;&#x447;&#x44c; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x435;&#x439; &#x432;&#x43e;&#x437;&#x43c;&#x43e;&#x436;&#x43d;&#x43e;&#x439; &#x446;&#x435;&#x43d;&#x44b; &#x438; &#x43e;&#x442;&#x432;&#x435;&#x442;&#x438;&#x442;&#x44c; &#x43d;&#x430; &#x432;&#x430;&#x448;&#x438; &#x432;&#x43e;&#x43f;&#x440;&#x43e;&#x441;&#x44b; &#x43e; &#x43f;&#x440;&#x43e;&#x446;&#x435;&#x441;&#x441;&#x435; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x436;&#x438;. \r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Hej ......................\r\n\r\nDetta &auml;r en bekr&auml;ftelse p&aring; att vi ska tr&auml;ffa din fastighet och g&ouml;ra den n&ouml;dv&auml;ndiga datainsamlingen f&ouml;r att registrera din fastighet i v&aring;rt system och l&auml;gga ut den tillf&ouml;rs&auml;ljning: \r\n\r\nDatum: ......................\r\nTid: ......................\r\nKontaktperson: ......................\r\n\r\nDen person som bes&ouml;ker din fastighet har stor erfarenhet och kunskap om fastighetsmarknaden och kommer att kunna hj&auml;lpa och ge dig r&aring;d f&ouml;r att uppn&aring; b&auml;sta m&ouml;jliga prisoch svara p&aring; dina fr&aring;gor om f&ouml;rs&auml;ljningsprocessen. \r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x4f60;&#x597d; ......................\r\n\r\n&#x8fd9;&#x662f;&#x4e00;&#x4e2a;&#x786e;&#x8ba4;&#xff0c;&#x4ee5;&#x6ee1;&#x8db3;&#x60a8;&#x7684;&#x8d22;&#x4ea7;&#xff0c;&#x5e76;&#x8fdb;&#x884c;&#x5fc5;&#x8981;&#x7684;&#x6570;&#x636e;&#x6536;&#x96c6;&#xff0c;&#x5728;&#x6211;&#x4eec;&#x7684;&#x7cfb;&#x7edf;&#x4e2d;&#x6ce8;&#x518c;&#x60a8;&#x7684;&#x8d22;&#x4ea7;&#xff0c;&#x628a;&#x5b83;&#x51fa;&#x552e;&#x3002;\r\n\r\n&#x65e5;&#x671f;&#xff1a;......................\r\n&#x65f6;&#x95f4;&#xff1a;......................\r\n&#x8054;&#x7cfb;&#x4eba;&#xff1a;......................\r\n\r\n&#x8bbf;&#x95ee;&#x60a8;&#x7684;&#x623f;&#x4ea7;&#x7684;&#x4eba;&#x5bf9;&#x623f;&#x4ea7;&#x5e02;&#x573a;&#x6709;&#x4e30;&#x5bcc;&#x7684;&#x7ecf;&#x9a8c;&#x548c;&#x77e5;&#x8bc6;&#xff0c;&#x80fd;&#x591f;&#x5e2e;&#x52a9;&#x548c;&#x5efa;&#x8bae;&#x60a8;&#x5b9e;&#x73b0;&#x6700;&#x4f73;&#x7684;&#x4ef7;&#x683c;&#xff0c;&#x5e76;&#x56de;&#x7b54;&#x60a8;&#x5173;&#x4e8e;&#x9500;&#x552e;&#x8fc7;&#x7a0b;&#x7684;&#x95ee;&#x9898;&#x3002;\r\n\r\n&#x81f4;&#x4ee5;&#x6700;&#x8bda;&#x631a;&#x7684;&#x95ee;&#x5019;&#xff0c;&#x5e76;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Witaj ......................\r\n\r\nJest to potwierdzenie spotkania z klientem i zebrania danych niezb&#x119;dnych do zarejestrowania nieruchomo&#x15b;ci w naszym systemie i wystawienia jej na sprzeda&#x17c;: \r\n\r\nData: ......................\r\nCzas: ......................\r\nOsoba kontaktowa: ......................\r\n\r\nOsoba, kt&oacute;ra odwiedzi Pa&#x144;stwa nieruchomo&#x15b;&#x107;, ma du&#x17c;e do&#x15b;wiadczenie i wiedz&#x119; na temat rynku nieruchomo&#x15b;ci i b&#x119;dzie w stanie pom&oacute;c i doradzi&#x107; Pa&#x144;stwu w osi&#x105;gni&#x119;ciu jaknajlepszej ceny oraz odpowiedzie&#x107; na Pa&#x144;stwa pytania dotycz&#x105;ce procesu sprzeda&#x17c;y. \r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas&#039;),
    (6,&#039;Follow-up after visit&#039;,&#039;Seguimiento tras visita&#039;,&#039;Seguiment despr&eacute;s de la visita&#039;,&#039;Opf&oslash;lgning efter bes&oslash;get&#039;,&#039;Follow-up nach dem Besuch&#039;,&#039;Follow up after visit&#039;,&#039;Seguimiento tras visita&#039;,&#039;Seuranta k&auml;ynnin j&auml;lkeen&#039;,&#039;Suivi apr&egrave;s la visite&#039;,&#039;Fylgst me&eth; eftir heims&oacute;kn&#039;,&#039;Follow-up na het bezoek&#039;,&#039;Oppf&oslash;lging etter bes&oslash;k&#039;,&#039;&#x41f;&#x43e;&#x441;&#x43b;&#x435;&#x434;&#x443;&#x44e;&#x449;&#x438;&#x435; &#x434;&#x435;&#x439;&#x441;&#x442;&#x432;&#x438;&#x44f; &#x43f;&#x43e;&#x441;&#x43b;&#x435; &#x43f;&#x43e;&#x441;&#x435;&#x449;&#x435;&#x43d;&#x438;&#x44f;&#039;,&#039;Uppf&ouml;ljning efter bes&ouml;ket&#039;,&#039;&#x8bbf;&#x95ee;&#x540e;&#x7684;&#x8ddf;&#x8fdb;&#x5de5;&#x4f5c;&#039;,&#039;Post&#x119;powanie po wizycie&#039;,&#039;Hola ......................\r\n\r\nEspero que us agradin les propietats que hem anat a visitar recentment.\r\n\r\n{{PROPERTY}} \r\n\r\nUs envio aquest missatge per veure si necessiteu m&eacute;s informaci&oacute; o fins i tot si voleu tornar a visitar la casa.\r\n\r\nVoleu que fem una oferta al venedor o preferiu que visitem altres propietats?\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;Hej ......................\r\n\r\nJeg h&aring;ber, at du kan lide de ejendomme, som vi bes&oslash;gte for nylig. \r\n\r\n{{PROPERTY}} \r\n\r\nJeg sender dig denne besked for at h&oslash;re, om du har brug for yderligere oplysninger eller endda om du gerne vil bes&oslash;ge huset igen.\r\n\r\n&Oslash;nsker du, at vi skal afgive et tilbud til s&aelig;lgeren, eller foretr&aelig;kker du, at vi bes&oslash;ger andre ejendomme?\r\n\r\nMed venlig hilsen og tak for din tid&#039;,&#039;Hallo ......................\r\n\r\nIch hoffe, dass Ihnen die Objekte gefallen, die wir k&uuml;rzlich besucht haben. \r\n\r\n{{PROPERTY}} \r\n\r\nIch sende Ihnen diese Nachricht, um zu erfahren, ob Sie weitere Informationen ben&ouml;tigen oder das Haus noch einmal besichtigen m&ouml;chten.\r\n\r\nM&ouml;chten Sie, dass wir dem Verk&auml;ufer ein Angebot machen, oder m&ouml;chten Sie, dass wir andere Immobilien besichtigen?\r\n\r\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit&#039;,&#039;Hello ......................\r\n\r\nI hope you like the properties we went to visit recently. \r\n\r\n{{PROPERTY}} \r\n\r\nI am sending you this message to see if you need any further information or even if you would like to visit the house again.\r\n\r\nWould you like us to make an offer to the seller or would you prefer us to visit other properties?\r\n\r\nBest regards and thank you for your time&#039;,&#039;Hola  &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nEspero que te gustar&aacute;n las propiedades que fuimos a visitar recientemente. \r\n\r\n{{PROPERTY}} \r\n\r\nTe env&iacute;o este mensaje para ver si necesitas m&aacute;s informaci&oacute;n o incluso si quieres volver a visitar la casa.\r\n\r\n&iquest;Quieres que realicemos una oferta al vendedor o prefieres que visitemos otras viviendas?\r\n\r\nUn saludo y gracias por tu tiempo&#039;,&#039;Hei ......................\r\n\r\nToivottavasti pid&auml;t kiinteist&ouml;ist&auml;, joissa k&auml;vimme hiljattain. \r\n\r\n{{PROPERTY}} \r\n\r\nL&auml;het&auml;n sinulle t&auml;m&auml;n viestin n&auml;hd&auml;kseni, tarvitsetko lis&auml;tietoja tai haluaisitko k&auml;yd&auml; talossa uudelleen.\r\n\r\nHaluaisitko, ett&auml; teemme tarjouksen myyj&auml;lle vai haluaisitko, ett&auml; k&auml;ymme muissa kohteissa?\r\n\r\nYst&auml;v&auml;llisin terveisin ja kiitos ajastanne&#039;,&#039;Bonjour ......................\r\n\r\nJ\&#039;esp&egrave;re que vous aimez les propri&eacute;t&eacute;s que nous sommes all&eacute;s visiter r&eacute;cemment. \r\n\r\n{{PROPERTY}}\r\n\r\nJe vous envoie ce message pour voir si vous avez besoin de plus d\&#039;informations ou m&ecirc;me si vous souhaitez visiter &agrave; nouveau la maison.\r\n\r\nSouhaitez-vous que nous fassions une offre au vendeur ou pr&eacute;f&eacute;rez-vous que nous visitions d\&#039;autres propri&eacute;t&eacute;s ?\r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;Hall&oacute; ......................\r\n\r\n&Eacute;g vona a&eth; &thorn;&eacute;r l&iacute;ki vel vi&eth; eignirnar sem vi&eth; heims&oacute;ttum n&yacute;lega.\r\n\r\n{{PROPERTY}} \r\n\r\n&Eacute;g sendi &thorn;&eacute;r &thorn;essi skilabo&eth; til a&eth; athuga hvort &thorn;&uacute; &thorn;urfir frekari uppl&yacute;singar e&eth;a jafnvel hvort &thorn;&uacute; viljir heims&aelig;kja h&uacute;si&eth; aftur.\r\n\r\nVilt &thorn;&uacute; a&eth; vi&eth; gerum tilbo&eth; til seljanda e&eth;a viltu frekar a&eth; vi&eth; heims&aelig;kjum a&eth;rar eignir?\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;mann&#039;,&#039;Hallo ......................\r\n\r\nIk hoop dat de eigendommen die we onlangs bezochten u bevallen. \r\n\r\n{{PROPERTY}} \r\n\r\nIk stuur u dit bericht om te zien of u nog verdere informatie nodig hebt of zelfs of u het huis nog eens zou willen bezoeken.\r\n\r\nWilt u dat wij een bod doen aan de verkoper of heeft u liever dat wij andere woningen bezichtigen?\r\n\r\nMet vriendelijke groet en dank u voor uw tijd&#039;,&#039;Hallo  &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nJeg h&aring;per du vil like eiendommene vi nylig bes&oslash;kte.\r\n\r\n{{PROPERTY}}\r\n\r\nJeg sender deg denne meldingen for &aring; se om du trenger mer informasjon eller om du &oslash;nsker &aring; bes&oslash;ke huset igjen.\r\n\r\n&Oslash;nsker du at vi skal gi et tilbud til selger eller foretrekker du at vi bes&oslash;ker andre boliger?\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x417;&#x434;&#x440;&#x430;&#x432;&#x441;&#x442;&#x432;&#x443;&#x439;&#x442;&#x435; ......................\r\n\r\n&#x41d;&#x430;&#x434;&#x435;&#x44e;&#x441;&#x44c;, &#x432;&#x430;&#x43c; &#x43f;&#x43e;&#x43d;&#x440;&#x430;&#x432;&#x438;&#x442;&#x441;&#x44f; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c;, &#x43a;&#x43e;&#x442;&#x43e;&#x440;&#x443;&#x44e; &#x43c;&#x44b; &#x43d;&#x435;&#x434;&#x430;&#x432;&#x43d;&#x43e; &#x43f;&#x43e;&#x441;&#x435;&#x442;&#x438;&#x43b;&#x438;. \r\n\r\n{{PROPERTY}} \r\n\r\n&#x42f; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x43b;&#x44f;&#x44e; &#x432;&#x430;&#x43c; &#x44d;&#x442;&#x43e; &#x441;&#x43e;&#x43e;&#x431;&#x449;&#x435;&#x43d;&#x438;&#x435;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x443;&#x437;&#x43d;&#x430;&#x442;&#x44c;, &#x43d;&#x443;&#x436;&#x43d;&#x430; &#x43b;&#x438; &#x432;&#x430;&#x43c; &#x434;&#x43e;&#x43f;&#x43e;&#x43b;&#x43d;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x430;&#x44f; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44f; &#x438;&#x43b;&#x438; &#x432;&#x44b; &#x445;&#x43e;&#x442;&#x435;&#x43b;&#x438; &#x431;&#x44b; &#x43f;&#x43e;&#x441;&#x435;&#x442;&#x438;&#x442;&#x44c; &#x434;&#x43e;&#x43c; &#x435;&#x449;&#x435; &#x440;&#x430;&#x437;.\r\n\r\n&#x425;&#x43e;&#x442;&#x438;&#x442;&#x435; &#x43b;&#x438; &#x432;&#x44b;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43c;&#x44b; &#x441;&#x434;&#x435;&#x43b;&#x430;&#x43b;&#x438; &#x43f;&#x440;&#x435;&#x434;&#x43b;&#x43e;&#x436;&#x435;&#x43d;&#x438;&#x435; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x432;&#x446;&#x443;, &#x438;&#x43b;&#x438; &#x432;&#x44b; &#x43f;&#x440;&#x435;&#x434;&#x43f;&#x43e;&#x447;&#x438;&#x442;&#x430;&#x435;&#x442;&#x435;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43c;&#x44b; &#x43f;&#x43e;&#x441;&#x435;&#x442;&#x438;&#x43b;&#x438; &#x434;&#x440;&#x443;&#x433;&#x438;&#x435; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x44b;?\r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Hej ......................\r\n\r\nJag hoppas att du gillar de fastigheter som vi bes&ouml;kte nyligen. \r\n\r\n{{PROPERTY}} \r\n\r\nJag skickar det h&auml;r meddelandet f&ouml;r att h&ouml;ra om du beh&ouml;ver mer information eller om du vill bes&ouml;ka huset igen.\r\n\r\nVill du att vi ska l&auml;gga ett bud p&aring; s&auml;ljaren eller f&ouml;redrar du att vi bes&ouml;ker andra fastigheter?\r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x4f60;&#x597d; ......................\r\n\r\n&#x6211;&#x5e0c;&#x671b;&#x4f60;&#x559c;&#x6b22;&#x6211;&#x4eec;&#x6700;&#x8fd1;&#x53bb;&#x53c2;&#x89c2;&#x7684;&#x623f;&#x4ea7;&#x3002;\r\n\r\n{{PROPERTY}} \r\n\r\n&#x6211;&#x7ed9;&#x4f60;&#x53d1;&#x8fd9;&#x4e2a;&#x4fe1;&#x606f;&#x662f;&#x60f3;&#x770b;&#x770b;&#x4f60;&#x662f;&#x5426;&#x9700;&#x8981;&#x8fdb;&#x4e00;&#x6b65;&#x7684;&#x4fe1;&#x606f;&#xff0c;&#x751a;&#x81f3;&#x4f60;&#x662f;&#x5426;&#x613f;&#x610f;&#x518d;&#x6b21;&#x53bb;&#x770b;&#x623f;&#x5b50;&#x3002;\r\n\r\n&#x60a8;&#x662f;&#x5e0c;&#x671b;&#x6211;&#x4eec;&#x5411;&#x5356;&#x5bb6;&#x51fa;&#x4ef7;&#xff0c;&#x8fd8;&#x662f;&#x5e0c;&#x671b;&#x6211;&#x4eec;&#x53bb;&#x770b;&#x5176;&#x4ed6;&#x623f;&#x4ea7;&#xff1f;\r\n\r\n&#x81f4;&#x4ee5;&#x6700;&#x8bda;&#x631a;&#x7684;&#x95ee;&#x5019;&#xff0c;&#x5e76;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Witaj ......................\r\n\r\nMam nadziej&#x119;, &#x17c;e spodobaj&#x105; si&#x119; Wam nieruchomo&#x15b;ci, kt&oacute;re ostatnio odwiedzili&#x15b;my. \r\n\r\n{{PROPERTY}} \r\n\r\nWysy&#x142;am t&#x119; wiadomo&#x15b;&#x107;, aby dowiedzie&#x107; si&#x119;, czy potrzebujecie Pa&#x144;stwo dalszych informacji lub czy chcieliby&#x15b;cie ponownie odwiedzi&#x107; dom.\r\n\r\nCzy chcesz, aby&#x15b;my z&#x142;o&#x17c;yli ofert&#x119; sprzedaj&#x105;cemu, czy wolisz, aby&#x15b;my odwiedzili inne nieruchomo&#x15b;ci?\r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas&#039;),
    (7,&#039;No reply&#039;,&#039;No responde&#039;,&#039;Sense resposta&#039;,&#039;Ingen svar&#039;,&#039;Keine Antwort&#039;,&#039;No reply&#039;,&#039;No responde&#039;,&#039;Ei vastausta&#039;,&#039;Pas de r&eacute;ponse&#039;,&#039;Ekkert svar&#039;,&#039;Geen antwoord&#039;,&#039;Svarer ikke&#039;,&#039;&#x41d;&#x435;&#x442; &#x43e;&#x442;&#x432;&#x435;&#x442;&#x430;&#039;,&#039;Inget svar&#039;,&#039;&#x6ca1;&#x6709;&#x56de;&#x590d;&#039;,&#039;Brak odpowiedzi&#039;,&#039;Hola,\r\n\r\nHem rebut la vostra sol&middot;licitud d\&#039;informaci&oacute; sobre aquesta propietat:\r\n\r\n{{PROPERTY}}\r\n\r\nHem intentat contactar amb tu diverses vegades i no ha estat possible.\r\n\r\nSi encara esteu interessats, aviseu-me quan voleu que ens tornem a contactar amb vosaltres.\r\nSi necessiteu m&eacute;s informaci&oacute;, poseu-vos en contacte amb nosaltres.\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;Hej,\r\n\r\nVi har modtaget din anmodning om oplysninger om denne ejendom:\r\n\r\n{{PROPERTY}}\r\n\r\nVi har fors&oslash;gt at kontakte dig flere gange, men det har ikke v&aelig;ret muligt.\r\n\r\nHvis du stadig er interesseret, s&aring; lad mig venligst vide, hvorn&aring;r du &oslash;nsker, at vi skal kontakte dig igen.\r\nHvis du har brug for yderligere oplysninger, bedes du kontakte os.\r\n\r\nMed venlig hilsen og tak for din tid&#039;,&#039;Hallo \r\n\r\nWir haben Ihre Anfrage nach Informationen &uuml;ber diese Immobilie erhalten:\r\n\r\n{{PROPERTY}}\r\n\r\nWir haben mehrmals versucht, Sie zu kontaktieren, aber es war nicht m&ouml;glich.\r\n\r\nWenn Sie immer noch interessiert sind, lassen Sie mich bitte wissen, wann wir Sie wieder kontaktieren sollen.\r\nWenn Sie weitere Informationen ben&ouml;tigen, wenden Sie sich bitte an uns.\r\n\r\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit&#039;,&#039;Hello,\r\n\r\nWe have received your request for information about this property:\r\n\r\n{{PROPERTY}}\r\n\r\nWe have tried to contact you several times and it has not been possible.\r\n\r\nIf you are still interested, please let me know when you would like us to contact you again.\r\nIf you need any further information, please contact us.\r\n\r\nBest regards and thank you for your time&#039;,&#039;Hola \r\n\r\nTras haber recibido tu solicitud de informaci&oacute;n sobre esta propiedad:\r\n\r\n{{PROPERTY}}\r\n\r\nHemos intentado contactar contigo en diferentes ocasiones y no ha sido posible.\r\n\r\nSi a&uacute;n est&aacute;s interesado, ind&iacute;came en que horario quieres que volvamos a contactarte\r\nSi necesitas cualquier tipo de informaci&oacute;n adicional ponte en contacto con nosotros\r\n\r\nUn saludo y gracias por tu tiempo&#039;,&#039;Hei,\r\n\r\nOlemme vastaanottaneet t&auml;t&auml; kiinteist&ouml;&auml; koskevan tietopyynt&ouml;si:\r\n\r\n{{PROPERTY}}\r\n\r\nOlemme yritt&auml;neet ottaa teihin yhteytt&auml; useita kertoja, mutta se ei ole ollut mahdollista.\r\n\r\nJos olet edelleen kiinnostunut, ilmoita minulle, milloin haluat meid&auml;n ottavan sinuun uudelleen yhteytt&auml;.\r\nJos tarvitset lis&auml;tietoja, ota yhteytt&auml;.\r\n\r\nYst&auml;v&auml;llisin terveisin ja kiitos ajastanne&#039;,&#039;Bonjour \r\n\r\nNous avons re&ccedil;u votre demande d\&#039;information sur cette propri&eacute;t&eacute; :\r\n\r\n{{PROPERTY}}\r\n\r\nNous avons essay&eacute; de vous contacter &agrave; plusieurs reprises, mais cela n\&#039;a pas &eacute;t&eacute; possible.\r\n\r\nSi vous &ecirc;tes toujours int&eacute;ress&eacute;, veuillez me faire savoir quand vous souhaitez que nous vous recontactions.\r\nSi vous avez besoin de plus amples informations, veuillez nous contacter.\r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;Hall&oacute;,\r\n\r\nVi&eth; h&ouml;fum m&oacute;tteki&eth; bei&eth;ni &thorn;&iacute;na um uppl&yacute;singar um &thorn;essa eign:\r\n\r\n{{PROPERTY}}\r\n\r\nVi&eth; h&ouml;fum reynt a&eth; hafa samband vi&eth; &thorn;ig nokkrum sinnum og &thorn;a&eth; hefur ekki tekist.\r\n\r\nEf &thorn;&uacute; hefur enn &aacute;huga, vinsamlegast l&aacute;ttu mig vita hven&aelig;r &thorn;&uacute; vilt a&eth; vi&eth; h&ouml;fum samband vi&eth; &thorn;ig aftur.\r\nEf &thorn;ig vantar frekari uppl&yacute;singar, vinsamlegast haf&eth;u samband vi&eth; okkur.\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;mann&#039;,&#039;Hallo \r\n\r\nWij hebben uw verzoek om informatie over deze woning ontvangen:\r\n\r\n{{PROPERTY}}\r\n\r\nWe hebben verschillende keren geprobeerd contact met u op te nemen, maar dat is niet gelukt.\r\n\r\nAls u nog steeds ge&iuml;nteresseerd bent, laat me dan weten wanneer u wilt dat wij weer contact met u opnemen.\r\nIndien u meer informatie wenst, kunt u contact met ons opnemen.\r\n\r\nMet vriendelijke groet en dank u voor uw tijd&#039;,&#039;Hallo\r\n\r\nEtter &aring; ha mottatt din foresp&oslash;rsel om informasjon om denne eiendommen:\r\n\r\n{{PROPERTY}}\r\n\r\nVi har fors&oslash;kt &aring; kontakte deg ved forskjellige anledninger og det har ikke v&aelig;rt mulig.\r\n\r\nHvis du fortsatt er interessert, fortell meg n&aring;r du vil at vi skal kontakte deg igjen\r\nHvis du trenger ytterligere informasjon, vennligst kontakt oss\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x417;&#x434;&#x440;&#x430;&#x432;&#x441;&#x442;&#x432;&#x443;&#x439;&#x442;&#x435;,\r\n\r\n&#x41c;&#x44b; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x43b;&#x438; &#x432;&#x430;&#x448; &#x437;&#x430;&#x43f;&#x440;&#x43e;&#x441; &#x43d;&#x430; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44e; &#x43e;&#x431; &#x44d;&#x442;&#x43e;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;:\r\n\r\n{{PROPERTY}}\r\n\r\n&#x41c;&#x44b; &#x43f;&#x44b;&#x442;&#x430;&#x43b;&#x438;&#x441;&#x44c; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x442;&#x44c;&#x441;&#x44f; &#x441; &#x412;&#x430;&#x43c;&#x438; &#x43d;&#x435;&#x441;&#x43a;&#x43e;&#x43b;&#x44c;&#x43a;&#x43e; &#x440;&#x430;&#x437;, &#x43d;&#x43e; &#x44d;&#x442;&#x43e; &#x43d;&#x435; &#x443;&#x434;&#x430;&#x43b;&#x43e;&#x441;&#x44c;.\r\n\r\n&#x415;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x432;&#x441;&#x435; &#x435;&#x449;&#x435; &#x437;&#x430;&#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43e;&#x432;&#x430;&#x43d;&#x44b;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x441;&#x43e;&#x43e;&#x431;&#x449;&#x438;&#x442;&#x435;, &#x43a;&#x43e;&#x433;&#x434;&#x430; &#x432;&#x44b; &#x445;&#x43e;&#x442;&#x438;&#x442;&#x435;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43c;&#x44b; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x43b;&#x438;&#x441;&#x44c; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x441;&#x43d;&#x43e;&#x432;&#x430;.\r\n&#x415;&#x441;&#x43b;&#x438; &#x432;&#x430;&#x43c; &#x43d;&#x443;&#x436;&#x43d;&#x430; &#x43a;&#x430;&#x43a;&#x430;&#x44f;-&#x43b;&#x438;&#x431;&#x43e; &#x434;&#x43e;&#x43f;&#x43e;&#x43b;&#x43d;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x430;&#x44f; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44f;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x441;&#x432;&#x44f;&#x436;&#x438;&#x442;&#x435;&#x441;&#x44c; &#x441; &#x43d;&#x430;&#x43c;&#x438;.\r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Hej \r\n\r\nVi har mottagit din beg&auml;ran om information om denna fastighet:\r\n\r\n{{PROPERTY}}\r\n\r\nVi har f&ouml;rs&ouml;kt kontakta dig flera g&aring;nger men det har inte varit m&ouml;jligt.\r\n\r\nOm du fortfarande &auml;r intresserad, l&aring;t mig veta n&auml;r du vill att vi kontaktar dig igen.\r\nOm du beh&ouml;ver mer information kan du kontakta oss.\r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x4f60;&#x597d;&#x3002;\r\n\r\n&#x6211;&#x4eec;&#x6536;&#x5230;&#x4e86;&#x60a8;&#x5bf9;&#x8be5;&#x623f;&#x4ea7;&#x4fe1;&#x606f;&#x7684;&#x8bf7;&#x6c42;&#x3002;\r\n\r\n{{PROPERTY}}\r\n\r\n&#x6211;&#x4eec;&#x66fe;&#x591a;&#x6b21;&#x5c1d;&#x8bd5;&#x4e0e;&#x60a8;&#x8054;&#x7cfb;&#xff0c;&#x4f46;&#x90fd;&#x672a;&#x80fd;&#x5982;&#x613f;&#x3002;\r\n\r\n&#x5982;&#x679c;&#x60a8;&#x4ecd;&#x7136;&#x611f;&#x5174;&#x8da3;&#xff0c;&#x8bf7;&#x544a;&#x8bc9;&#x6211;&#x60a8;&#x5e0c;&#x671b;&#x6211;&#x4eec;&#x4f55;&#x65f6;&#x518d;&#x6b21;&#x4e0e;&#x60a8;&#x8054;&#x7cfb;&#x3002;\r\n&#x5982;&#x679c;&#x60a8;&#x9700;&#x8981;&#x4efb;&#x4f55;&#x8fdb;&#x4e00;&#x6b65;&#x7684;&#x4fe1;&#x606f;&#xff0c;&#x8bf7;&#x8054;&#x7cfb;&#x6211;&#x4eec;&#x3002;\r\n\r\n&#x6700;&#x8bda;&#x631a;&#x7684;&#x95ee;&#x5019;&#xff0c;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Witaj \r\n\r\nOtrzymali&#x15b;my Twoj&#x105; pro&#x15b;b&#x119; o informacje na temat tego obiektu:\r\n\r\n{{PROPERTY}}\r\n\r\nKilkakrotnie pr&oacute;bowali&#x15b;my si&#x119; z Tob&#x105; skontaktowa&#x107;, ale nie by&#x142;o to mo&#x17c;liwe.\r\n\r\nJe&#x15b;li nadal jeste&#x15b; zainteresowany, daj mi zna&#x107;, kiedy chcia&#x142;by&#x15b;, aby&#x15b;my skontaktowali si&#x119; z Tob&#x105; ponownie.\r\nJe&#x15b;li potrzebujesz dodatkowych informacji, skontaktuj si&#x119; z nami.\r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas&#039;),
    (8,&#039;No reply 2&#039;,&#039;No responde 2&#039;,&#039;Sense resposta 2&#039;,&#039;Ingen svar 2&#039;,&#039;Keine Antwort 2&#039;,&#039;No reply 2&#039;,&#039;No responde 2&#039;,&#039;Ei vastausta 2&#039;,&#039;Pas de r&eacute;ponse 2&#039;,&#039;Ekkert svar 2&#039;,&#039;Geen antwoord 2&#039;,&#039;ikke noe svar 2&#039;,&#039;&#x41d;&#x435;&#x442; &#x43e;&#x442;&#x432;&#x435;&#x442;&#x430; 2&#039;,&#039;Inget svar 2&#039;,&#039;&#x6ca1;&#x6709;&#x7b54;&#x590d; 2&#039;,&#039;Brak odpowiedzi 2&#039;,&#039;Fa un temps et vas contactar amb nosaltres per demanar m&eacute;s informaci&oacute; sobre les nostres propietats.\r\n\r\nT\&#039;escric per saber si encara est&agrave;s interessat a comprar una propietat i tamb&eacute; per veure si vols que ens tornem a contactar amb tu.\r\n\r\nSi encara esteu interessats, responeu a aquest missatge i em posar&eacute; en contacte amb vosaltres el m&eacute;s aviat possible.\r\n\r\nSi no &eacute;s aix&iacute;, us agrairia que respongueu a aquest missatge indicant \\&quot;No vull rebre cap m&eacute;s informaci&oacute;\\&quot;.\r\n\r\nSalutacions cordials i gr&agrave;cies pel vostre temps&#039;,&#039;For nogen tid siden kontaktede du os og bad om flere oplysninger om vores ejendomme.\r\n\r\nJeg skriver her for at h&oslash;re, om du stadig er interesseret i at k&oslash;be en ejendom, og for at h&oslash;re, om du &oslash;nsker, at vi kontakter dig igen.\r\n\r\nHvis du stadig er interesseret, bedes du svare p&aring; denne besked, s&aring; kontakter jeg dig hurtigst muligt.\r\n\r\nHvis De ikke er interesseret, vil jeg v&aelig;re Dem taknemmelig for at svare p&aring; denne meddelelse med &quot;Jeg &oslash;nsker ikke at modtage yderligere oplysninger&quot;.\r\n\r\nMed venlig hilsen og tak for Deres tid&#039;,&#039;Hallo ......................\r\n\r\nVor einiger Zeit haben Sie uns kontaktiert und um weitere Informationen &uuml;ber unsere Immobilien gebeten.\r\n\r\nIch schreibe Ihnen, um zu erfahren, ob Sie immer noch am Kauf einer Immobilie interessiert sind und ob Sie m&ouml;chten, dass wir Sie erneut kontaktieren.\r\n\r\nWenn Sie immer noch interessiert sind, antworten Sie bitte auf diese Nachricht, und ich werde mich so bald wie m&ouml;glich mit Ihnen in Verbindung setzen.\r\n\r\nFalls nicht, w&auml;re ich Ihnen dankbar, wenn Sie auf diese Nachricht mit dem Vermerk \\&quot;Ich m&ouml;chte keine weiteren Informationen erhalten\\&quot; antworten k&ouml;nnten.\r\n\r\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit&#039;,&#039;Some time ago you contacted us requesting more information about our properties.\r\n\r\nI am writing to see if you are still interested in buying a property and also to see if you would like us to contact you again.\r\n\r\nIf you are still interested, please reply to this message, and I will contact you as soon as possible.\r\n\r\nIf you are not, I would be grateful if you could reply to this message indicating \\&quot;I do not wish to receive any further information\\&quot;.\r\n\r\nBest regards and thank you for your time&#039;,&#039;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nHace un tiempo te pusiste en contacto con nosotros solicitando m&aacute;s informaci&oacute;n sobre nuestras propiedades.\r\n\r\nTe escribo para saber si sigues interesado en la compra de una vivienda y tambi&eacute;n para saber si deseas que te volvamos a contactar.\r\n\r\nSi a&uacute;n est&aacute;s interesado, responde a este mensaje, y me pondr&eacute; en contacto contigo a la mayor brevedad posible\r\n\r\nSi por el contrario, no lo est&aacute;s, te agradecer&iacute;a respondieras este mensaje indicando &ldquo;no deseo recibir m&aacute;s informaci&oacute;n&rdquo;\r\n\r\nUn saludo y gracias por tu tiempo&#039;,&#039;Jokin aika sitten otit meihin yhteytt&auml; ja pyysit lis&auml;tietoja kiinteist&ouml;ist&auml;mme.\r\n\r\nKirjoitan kysy&auml;kseni, oletteko edelleen kiinnostunut kiinteist&ouml;n ostamisesta ja haluaisitteko, ett&auml; otamme teihin uudelleen yhteytt&auml;.\r\n\r\nJos olet edelleen kiinnostunut, vastaa t&auml;h&auml;n viestiin, niin otan sinuun yhteytt&auml; mahdollisimman pian.\r\n\r\nJos ette ole kiinnostunut, olisin kiitollinen, jos voisitte vastata t&auml;h&auml;n viestiin ilmoittamalla \\&quot;En halua saada lis&auml;tietoja\\&quot;.\r\n\r\nYst&auml;v&auml;llisin terveisin ja kiitos ajastanne&#039;,&#039;Bonjour ......................\r\n\r\nIl y a quelque temps, vous nous avez contact&eacute;s pour demander de plus amples informations sur nos propri&eacute;t&eacute;s.\r\n\r\nJe vous &eacute;cris pour savoir si vous &ecirc;tes toujours int&eacute;ress&eacute; par l\&#039;achat d\&#039;une propri&eacute;t&eacute; et aussi pour savoir si vous souhaitez que nous vous recontactions.\r\n\r\nSi vous &ecirc;tes toujours int&eacute;ress&eacute;, veuillez r&eacute;pondre &agrave; ce message, et je vous contacterai d&egrave;s que possible.\r\n\r\nSi vous ne l\&#039;&ecirc;tes pas, je vous serais reconnaissant de r&eacute;pondre &agrave; ce message en indiquant \\&quot;Je ne souhaite pas recevoir d\&#039;autres informations\\&quot;.\r\n\r\nMeilleures salutations et merci pour votre temps&#039;,&#039;Fyrir nokkru s&iacute;&eth;an haf&eth;ir &thorn;&uacute; samband vi&eth; okkur og &oacute;ska&eth;i eftir frekari uppl&yacute;singum um eignir okkar.\r\n\r\n&Eacute;g skrifa til a&eth; athuga hvort &thorn;&uacute; hafir enn &aacute;huga &aacute; a&eth; kaupa eign og einnig til a&eth; athuga hvort &thorn;&uacute; viljir a&eth; vi&eth; h&ouml;fum samband vi&eth; &thorn;ig aftur.\r\n\r\nEf &thorn;&uacute; hefur enn &aacute;huga, vinsamlegast svara&eth;u &thorn;essum skilabo&eth;um og &eacute;g mun hafa samband vi&eth; &thorn;ig eins flj&oacute;tt og au&eth;i&eth; er.\r\n\r\nEf &thorn;&uacute; ert &thorn;a&eth; ekki, v&aelig;ri &eacute;g &thorn;akkl&aacute;tur ef &thorn;&uacute; g&aelig;tir svara&eth; &thorn;essum skilabo&eth;um me&eth; &thorn;v&iacute; a&eth; gefa til kynna &bdquo;&Eacute;g vil ekki f&aacute; frekari uppl&yacute;singar&ldquo;.\r\n\r\nBestu kve&eth;jur og takk fyrir t&iacute;mann&#039;,&#039;Enige tijd geleden nam u contact met ons op om meer informatie te vragen over onze eigendommen.\r\n\r\nIk schrijf u om te zien of u nog steeds ge&iuml;nteresseerd bent in het kopen van een woning en ook om te zien of u wilt dat wij opnieuw contact met u opnemen.\r\n\r\nAls u nog steeds ge&iuml;nteresseerd bent, reageer dan op dit bericht, en ik zal zo spoedig mogelijk contact met u opnemen.\r\n\r\nIndien dit niet het geval is, zou ik u dankbaar zijn indien u op dit bericht zou willen antwoorden met de vermelding \\&quot;ik wens geen verdere informatie te ontvangen\\&quot;.\r\n\r\nMet vriendelijke groet en bedankt voor uw tijd&#039;,&#039;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\r\n\r\nFor en tid siden kontaktet du oss og ba om mer informasjon om eiendommene v&aring;re.\r\n\r\nJeg skriver for &aring; finne ut om du fortsatt er interessert i &aring; kj&oslash;pe bolig og ogs&aring; for &aring; finne ut om du &oslash;nsker at vi skal kontakte deg igjen.\r\n\r\nHvis du fortsatt er interessert, svar p&aring; denne meldingen, s&aring; kontakter jeg deg s&aring; snart som mulig.\r\n\r\nHvis du derimot ikke er det, vil jeg sette pris p&aring; om du vil svare p&aring; denne meldingen med \\&quot;Jeg &oslash;nsker ikke &aring; motta mer informasjon\\&quot;\r\n\r\nHilsen og takk for din tid&#039;,&#039;&#x41d;&#x435;&#x43a;&#x43e;&#x442;&#x43e;&#x440;&#x43e;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f; &#x43d;&#x430;&#x437;&#x430;&#x434; &#x432;&#x44b; &#x43e;&#x431;&#x440;&#x430;&#x442;&#x438;&#x43b;&#x438;&#x441;&#x44c; &#x43a; &#x43d;&#x430;&#x43c; &#x441; &#x43f;&#x440;&#x43e;&#x441;&#x44c;&#x431;&#x43e;&#x439; &#x43f;&#x440;&#x435;&#x434;&#x43e;&#x441;&#x442;&#x430;&#x432;&#x438;&#x442;&#x44c; &#x434;&#x43e;&#x43f;&#x43e;&#x43b;&#x43d;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x443;&#x44e; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44e; &#x43e; &#x43d;&#x430;&#x448;&#x435;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;.\r\n\r\n&#x42f; &#x43f;&#x438;&#x448;&#x443;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x443;&#x437;&#x43d;&#x430;&#x442;&#x44c;, &#x43f;&#x43e;-&#x43f;&#x440;&#x435;&#x436;&#x43d;&#x435;&#x43c;&#x443; &#x43b;&#x438; &#x432;&#x44b; &#x437;&#x430;&#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43e;&#x432;&#x430;&#x43d;&#x44b; &#x432; &#x43f;&#x43e;&#x43a;&#x443;&#x43f;&#x43a;&#x435; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;, &#x430; &#x442;&#x430;&#x43a;&#x436;&#x435; &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x443;&#x437;&#x43d;&#x430;&#x442;&#x44c;, &#x445;&#x43e;&#x442;&#x438;&#x442;&#x435; &#x43b;&#x438; &#x432;&#x44b;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43c;&#x44b; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x43b;&#x438;&#x441;&#x44c; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x441;&#x43d;&#x43e;&#x432;&#x430;.\r\n\r\n&#x415;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x432;&#x441;&#x435; &#x435;&#x449;&#x435; &#x437;&#x430;&#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43e;&#x432;&#x430;&#x43d;&#x44b;, &#x43f;&#x43e;&#x436;&#x430;&#x43b;&#x443;&#x439;&#x441;&#x442;&#x430;, &#x43e;&#x442;&#x432;&#x435;&#x442;&#x44c;&#x442;&#x435; &#x43d;&#x430; &#x44d;&#x442;&#x43e; &#x441;&#x43e;&#x43e;&#x431;&#x449;&#x435;&#x43d;&#x438;&#x435;, &#x438; &#x44f; &#x441;&#x432;&#x44f;&#x436;&#x443;&#x441;&#x44c; &#x441; &#x432;&#x430;&#x43c;&#x438; &#x43a;&#x430;&#x43a; &#x43c;&#x43e;&#x436;&#x43d;&#x43e; &#x441;&#x43a;&#x43e;&#x440;&#x435;&#x435;.\r\n\r\n&#x415;&#x441;&#x43b;&#x438; &#x43d;&#x435;&#x442;, &#x44f; &#x431;&#x443;&#x434;&#x443; &#x431;&#x43b;&#x430;&#x433;&#x43e;&#x434;&#x430;&#x440;&#x435;&#x43d;, &#x435;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x43e;&#x442;&#x432;&#x435;&#x442;&#x438;&#x442;&#x435; &#x43d;&#x430; &#x44d;&#x442;&#x43e; &#x441;&#x43e;&#x43e;&#x431;&#x449;&#x435;&#x43d;&#x438;&#x435;, &#x443;&#x43a;&#x430;&#x437;&#x430;&#x432;:\\ &quot;&#x42f; &#x43d;&#x435; &#x445;&#x43e;&#x447;&#x443; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x430;&#x442;&#x44c; &#x434;&#x430;&#x43b;&#x44c;&#x43d;&#x435;&#x439;&#x448;&#x443;&#x44e; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44e;\\&quot;.\r\n\r\n&#x421; &#x43d;&#x430;&#x438;&#x43b;&#x443;&#x447;&#x448;&#x438;&#x43c;&#x438; &#x43f;&#x43e;&#x436;&#x435;&#x43b;&#x430;&#x43d;&#x438;&#x44f;&#x43c;&#x438; &#x438; &#x441;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x443;&#x434;&#x435;&#x43b;&#x435;&#x43d;&#x43d;&#x43e;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f;&#039;,&#039;Hej ......................\r\n\r\nF&ouml;r en tid sedan kontaktade du oss och bad om mer information om v&aring;ra fastigheter.\r\n\r\nJag skriver f&ouml;r att h&ouml;ra om du fortfarande &auml;r intresserad av att k&ouml;pa en fastighet och f&ouml;r att h&ouml;ra om du vill att vi kontaktar dig igen.\r\n\r\nOm du fortfarande &auml;r intresserad kan du svara p&aring; det h&auml;r meddelandet, s&aring; kontaktar jag dig s&aring; snart som m&ouml;jligt.\r\n\r\nOm du inte &auml;r det skulle jag vara tacksam om du kunde svara p&aring; detta meddelande och ange \\&quot;Jag vill inte f&aring; n&aring;gon ytterligare information\\&quot;.\r\n\r\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.&#039;,&#039;&#x524d;&#x6bb5;&#x65f6;&#x95f4;&#xff0c;&#x60a8;&#x4e0e;&#x6211;&#x4eec;&#x8054;&#x7cfb;&#xff0c;&#x8981;&#x6c42;&#x63d0;&#x4f9b;&#x66f4;&#x591a;&#x5173;&#x4e8e;&#x6211;&#x4eec;&#x623f;&#x4ea7;&#x7684;&#x4fe1;&#x606f;&#x3002;\r\n\r\n&#x6211;&#x5199;&#x4fe1;&#x662f;&#x60f3;&#x77e5;&#x9053;&#x4f60;&#x662f;&#x5426;&#x4ecd;&#x6709;&#x5174;&#x8da3;&#x8d2d;&#x4e70;&#x623f;&#x4ea7;&#xff0c;&#x540c;&#x65f6;&#x4e5f;&#x60f3;&#x77e5;&#x9053;&#x4f60;&#x662f;&#x5426;&#x5e0c;&#x671b;&#x6211;&#x4eec;&#x518d;&#x6b21;&#x4e0e;&#x4f60;&#x8054;&#x7cfb;&#x3002;\r\n\r\n&#x5982;&#x679c;&#x4f60;&#x4ecd;&#x6709;&#x5174;&#x8da3;&#xff0c;&#x8bf7;&#x56de;&#x590d;&#x6b64;&#x4fe1;&#x606f;&#xff0c;&#x6211;&#x5c06;&#x5c3d;&#x5feb;&#x4e0e;&#x4f60;&#x8054;&#x7cfb;&#x3002;\r\n\r\n&#x5982;&#x679c;&#x60a8;&#x4e0d;&#x611f;&#x5174;&#x8da3;&#xff0c;&#x8bf7;&#x60a8;&#x56de;&#x590d;&#x6b64;&#x4fe1;&#x606f;&#xff0c;&#x8868;&#x660e; &quot;&#x6211;&#x4e0d;&#x5e0c;&#x671b;&#x6536;&#x5230;&#x4efb;&#x4f55;&#x8fdb;&#x4e00;&#x6b65;&#x7684;&#x4fe1;&#x606f;&quot;&#xff0c;&#x6211;&#x5c06;&#x975e;&#x5e38;&#x611f;&#x6fc0;&#x3002;\r\n\r\n&#x81f4;&#x4ee5;&#x6700;&#x8bda;&#x631a;&#x7684;&#x95ee;&#x5019;&#xff0c;&#x5e76;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x65f6;&#x95f4;&#039;,&#039;Witaj ......................\r\n\r\nJaki&#x15b; czas temu skontaktowa&#x142;e&#x15b; si&#x119; z nami, prosz&#x105;c o wi&#x119;cej informacji na temat naszych nieruchomo&#x15b;ci.\r\n\r\nPisz&#x119;, aby sprawdzi&#x107;, czy nadal jest Pan/Pani zainteresowany/a zakupem nieruchomo&#x15b;ci, a tak&#x17c;e, czy chcia&#x142;by Pan/Pani, aby&#x15b;my ponownie si&#x119; z Panem/Pani&#x105; skontaktowali.\r\n\r\nJe&#x15b;li nadal jeste&#x15b; zainteresowany, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, a ja skontaktuj&#x119; si&#x119; z Tob&#x105; tak szybko, jak to b&#x119;dzie mo&#x17c;liwe.\r\n\r\nJe&#x15b;li tak nie jest, by&#x142;bym wdzi&#x119;czny, gdyby odpowiedzia&#x142; Pan na t&#x119; wiadomo&#x15b;&#x107;, zaznaczaj&#x105;c \\&quot;Nie chc&#x119; otrzymywa&#x107; &#x17c;adnych dalszych informacji\\&quot;.\r\n\r\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas&#039;);

            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:129
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsColaboradores = &quot;SELECT * FROM properties_collaborators ORDER BY nombre_comercial_col ASC&quot;;
$rsColaboradores = mysql_query($query_rsColaboradores, $inmoconn) or die(mysql_error());
$row_rsColaboradores = mysql_fetch_assoc($rsColaboradores);
$totalRows_rsColaboradores = mysql_num_rows($rsColaboradores);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsColaboradores = &quot;SELECT * FROM properties_collaborators ORDER BY nombre_comercial_col ASC&quot;;
$rsColaboradores = mysql_query($query_rsColaboradores, $inmoconn) or die(mysql_error());
$row_rsColaboradores = mysql_fetch_assoc($rsColaboradores);
$totalRows_rsColaboradores = mysql_num_rows($rsColaboradores);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsTemplates = &quot;SELECT * FROM templates ORDER BY name_&quot;.$lang_adm.&quot;_tmpl ASC&quot;;
$rsTemplates = mysql_query($query_rsTemplates, $inmoconn) or die(mysql_error());
$row_rsTemplates = mysql_fetch_assoc($rsTemplates);
$totalRows_rsTemplates = mysql_num_rows($rsTemplates);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2432
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;select name=&quot;txt&quot; id=&quot;txt&quot; class=&quot;form-control&quot;&gt;
    &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Seleccione uno&#039;); ?&gt;...&lt;/option&gt;
    &lt;option value=&quot;1&quot;&gt;&lt;?php __(&#039;Respuesta Inicial sin tel&eacute;fono&#039;); ?&gt;&lt;/option&gt;
    &lt;option value=&quot;2&quot;&gt;&lt;?php __(&#039;Respuesta Inicial con tel&eacute;fono&#039;); ?&gt;&lt;/option&gt;
    &lt;option value=&quot;3&quot;&gt;&lt;?php __(&#039;Respuesta Seguimiento&#039;); ?&gt;&lt;/option&gt;
    &lt;option value=&quot;4&quot;&gt;&lt;?php __(&#039;Confirmaci&oacute;n visita&#039;); ?&gt;&lt;/option&gt;
    &lt;option value=&quot;5&quot;&gt;&lt;?php __(&#039;Confirmaci&oacute;n de listado&#039;); ?&gt;&lt;/option&gt;
    &lt;option value=&quot;6&quot;&gt;&lt;?php __(&#039;Seguimiento tras visita&#039;); ?&gt;&lt;/option&gt;
    &lt;option value=&quot;7&quot;&gt;&lt;?php __(&#039;No responde&#039;); ?&gt;&lt;/option&gt;
    &lt;option value=&quot;8&quot;&gt;&lt;?php __(&#039;No responde 2&#039;); ?&gt;&lt;/option&gt;
&lt;/select&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;select name=&quot;txt&quot; id=&quot;txt&quot; class=&quot;form-control&quot;&gt;
    &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Seleccione uno&#039;); ?&gt;...&lt;/option&gt;
    &lt;?php do { ?&gt;
    &lt;option value=&quot;&lt;?php echo $row_rsTemplates[&#039;id_tmpl&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsTemplates[&#039;name_&#039;.$lang_adm.&#039;_tmpl&#039;]?&gt;&lt;/option&gt;
    &lt;?php } while ($row_rsTemplates = mysql_fetch_assoc($rsTemplates));
      $rows = mysql_num_rows($rsTemplates);
      if($rows &gt; 0) {
          mysql_data_seek($rsTemplates, 0);
        $row_rsTemplates = mysql_fetch_assoc($rsTemplates);
      } ?&gt;
&lt;/select&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2519
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//intr_sub[&#039;da1&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de1&#039;] = &quot;Erste Reaktion ohne Telefon&quot;;
intr_sub[&#039;en1&#039;] = &quot;Initial response without telephone&quot;;
intr_sub[&#039;es1&#039;] = &quot;Respuesta Inicial sin tel&eacute;fono&quot;;
//intr_sub[&#039;fi1&#039;] = &quot;&quot;;
intr_sub[&#039;fr1&#039;] = &quot;R&eacute;ponse initiale sans t&eacute;l&eacute;phone&quot;;
//intr_sub[&#039;is1&#039;] = &quot;&quot;;
intr_sub[&#039;nl1&#039;] = &quot;Eerste reactie zonder telefoon&quot;;
intr_sub[&#039;no1&#039;] = &quot;Innledende svar uten telefon&quot;;
// intr_sub[&#039;ru1&#039;] = &quot;&quot;;
intr_sub[&#039;se1&#039;] = &quot;F&ouml;rsta svar utan telefon&quot;;
intr_sub[&#039;pl1&#039;] = &quot;Wst&#x119;pna reakcja bez telefonu&quot;;

// intr_txt[&#039;da1&#039;] = &quot;&quot;;
intr_txt[&#039;de1&#039;] = &quot;Vielen Dank, dass Sie unser Immobilienb&uuml;ro kontaktiert haben.\nHier finden Sie die von Ihnen gew&uuml;nschten Informationen zu folgender Immobilie.\nF&uuml;r weitere Informationen und &auml;hnliche H&auml;user k&ouml;nnen Sie hier klicken:\n\n{{PROPERTY}}\n\nWenn Sie m&ouml;chten, dass sich einer unserer Berater mit Ihnen in Verbindung setzt, antworten Sie bitte auf diese E-Mail und geben Sie eine Telefonnummer und einenZeitpunkt an, zu dem Sie einen Anruf oder eine Whatsapp-Nachricht erhalten m&ouml;chten.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en1&#039;] = &quot;Thank you for contacting our real estate agency.\nHere you have the information you have requested about the following property.\nYou can click for more information and similar houses:\n\n{{PROPERTY}}\n\nIf you would like one of our advisors to contact you, please reply to this email, indicating a telephone number and a time when it would be convenient for you toreceive a call or whatsapp.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es1&#039;] = &quot;Gracias por contactar con nuestra inmobiliaria.\nAqu&iacute; tienes la informaci&oacute;n que nos has solicitado sobre la siguiente propiedad.\nPuedes hacer clic para m&aacute;s informaci&oacute;n y casas similares:\n\n{{PROPERTY}}\n\nSi quiere que uno de nuestros asesores se ponga en contacto contigo, por favor responde a este mail, indicando un n&uacute;mero de tel&eacute;fono y una hora a la que te viene bienrecibir una llamada o whatsapp.\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi1&#039;] = &quot;&quot;;
intr_txt[&#039;fr1&#039;] = &quot;Merci d&#039;avoir contact&eacute; notre agence immobili&egrave;re.\nVous trouverez ici les informations que vous avez demand&eacute;es concernant le bien suivant.\nVous pouvez cliquer pour obtenir plus d&#039;informations et des maisons similaires :\n\n{{PROPERTY}}\n\nSi vous souhaitez que l&#039;un de nos conseillers vous contacte, veuillez r&eacute;pondre &agrave; cet e-mail en indiquant un num&eacute;ro de t&eacute;l&eacute;phone et une heure &agrave; laquelle il vousconviendrait de recevoir un appel ou un whatsapp.\n\nMeilleures salutations et merci pour votre temps\n\n&quot;;
// intr_txt[&#039;is1&#039;] = &quot;&quot;;
intr_txt[&#039;nl1&#039;] = &quot;Dank u voor het contacteren van ons makelaarskantoor.\nHier is de informatie die u heeft opgevraagd over het volgende object.\nU kunt klikken voor meer informatie en soortgelijke huizen:\n\n{{PROPERTY}}\n\nIndien u wenst dat een van onze adviseurs contact met u opneemt, gelieve dan te antwoorden op deze e-mail, met vermelding van een telefoonnummer en een tijdstip waarophet u schikt om een telefoontje of een whatsapp te ontvangen.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no1&#039;] = &quot;Takk for at du kontakter v&aring;r eiendom.\nHer er informasjonen du har bedt om om f&oslash;lgende eiendom.\nDu kan klikke for mer informasjon og lignende hus:\n\n{{PROPERTY}}\n\nHvis du vil at en av v&aring;re r&aring;dgivere skal kontakte deg, vennligst svar p&aring; denne e-posten, og oppgi et telefonnummer og et tidspunkt det passer for deg &aring; motta en samtaleeller whatsapp.\n\nHilsen og takk for din tid&quot;;
// intr_txt[&#039;ru1&#039;] = &quot;&quot;;
intr_txt[&#039;se1&#039;] = &quot;Tack f&ouml;r att du har kontaktat v&aring;r fastighetsbyr&aring;.\nH&auml;r &auml;r den information som du har beg&auml;rt om f&ouml;ljande fastighet.\nDu kan klicka f&ouml;r mer information och liknande hus:\n\n{{PROPERTY}}\n\nOm du vill att en av v&aring;ra r&aring;dgivare ska kontakta dig, v&auml;nligen svara p&aring; detta e-postmeddelande och ange ett telefonnummer och en tid d&aring; det skulle passa dig att f&aring; ettsamtal eller en whatsapp.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl1&#039;] = &quot;Dzi&#x119;kujemy za kontakt z nasz&#x105; agencj&#x105; nieruchomo&#x15b;ci.\nTutaj znajdziesz informacje, o kt&oacute;re prosi&#x142;e&#x15b;, dotycz&#x105;ce nast&#x119;puj&#x105;cej nieruchomo&#x15b;ci.\nKliknij, aby uzyska&#x107; wi&#x119;cej informacji i zobaczy&#x107; podobne domy:\n\n{{PROPERTY}}\n\nJe&#x15b;li chcesz, aby jeden z naszych doradc&oacute;w skontaktowa&#x142; si&#x119; z Tob&#x105;, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, podaj&#x105;c numer telefonu i czas, w kt&oacute;rym by&#x142;by&#x15b; w stanie odebra&#x107; telefonlub wiadomo&#x15b;&#x107; SMS.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da2&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de2&#039;] = &quot;Erste Antwort mit Telefonnummer&quot;;
intr_sub[&#039;en2&#039;] = &quot;Initial response with telephone number&quot;;
intr_sub[&#039;es2&#039;] = &quot;Respuesta Inicial con tel&eacute;fono&quot;;
//intr_sub[&#039;fi2&#039;] = &quot;&quot;;
intr_sub[&#039;fr2&#039;] = &quot;R&eacute;ponse initiale avec num&eacute;ro de t&eacute;l&eacute;phone&quot;;
//intr_sub[&#039;is2&#039;] = &quot;&quot;;
intr_sub[&#039;nl2&#039;] = &quot;Eerste antwoord met telefoonnummer&quot;;
intr_sub[&#039;no2&#039;] = &quot;F&oslash;rste svar med telefon&quot;;
// intr_sub[&#039;ru2&#039;] = &quot;&quot;;
intr_sub[&#039;se2&#039;] = &quot;F&ouml;rsta svar med telefonnummer&quot;;
intr_sub[&#039;pl2&#039;] = &quot;Wst&#x119;pna odpowied&#x17a; wraz z numerem telefonu&quot;;

// intr_txt[&#039;da2&#039;] = &quot;&quot;;
intr_txt[&#039;de2&#039;] = &quot;Vielen Dank, dass Sie unser Immobilienb&uuml;ro kontaktiert haben.\nHier finden Sie die von Ihnen gew&uuml;nschten Informationen zu folgender Immobilie.\nF&uuml;r weitere Informationen und &auml;hnliche H&auml;user k&ouml;nnen Sie hier klicken:\n\n{{PROPERTY}}\n\nWenn Sie m&ouml;chten, dass sich einer unserer Berater mit Ihnen in Verbindung setzt, antworten Sie bitte auf diese E-Mail und geben Sie eine Zeit an, zu der Sie gerneangerufen oder per Whatsapp kontaktiert werden m&ouml;chten.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en2&#039;] = &quot;Thank you for contacting our real estate agency.\nHere you have the information you have requested about the following property.\nYou can click for more information and similar houses:\n\n{{PROPERTY}}\n\nIf you would like one of our advisors to contact you, please reply to this email, indicating a time when it would be convenient for you to receive a call or whatsapp.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es2&#039;] = &quot;Gracias por contactar con nuestra inmobiliaria.\nAqu&iacute; tienes la informaci&oacute;n que nos has solicitado sobre la siguiente propiedad.\nPuedes hacer clic para m&aacute;s informaci&oacute;n y casas similares:\n\n{{PROPERTY}}\n\nSi quiere que uno de nuestros asesores se ponga en contacto contigo, por favor responde a este mail, indicando una hora a la que te viene bien recibir una llamada owhatsapp.\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi2&#039;] = &quot;&quot;;
intr_txt[&#039;fr2&#039;] = &quot;Merci d&#039;avoir contact&eacute; notre agence immobili&egrave;re.\nVous trouverez ici les informations que vous avez demand&eacute;es concernant le bien suivant.\nVous pouvez cliquer pour obtenir plus d&#039;informations et des maisons similaires :\n\n{{PROPERTY}}\n\nSi vous souhaitez que l&#039;un de nos conseillers vous contacte, veuillez r&eacute;pondre &agrave; cet e-mail en indiquant le moment o&ugrave; il vous conviendrait de recevoir un appel ou unwhatsapp.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is2&#039;] = &quot;&quot;;
intr_txt[&#039;nl2&#039;] = &quot;Dank u voor het contacteren van ons makelaarskantoor.\nHier heeft u de informatie die u heeft opgevraagd over het volgende object.\nU kunt klikken voor meer informatie en soortgelijke huizen:\n\n{{PROPERTY}}\n\nIndien u wenst dat een van onze adviseurs contact met u opneemt, gelieve deze e-mail te beantwoorden en een tijdstip op te geven dat u schikt om een telefoontje ofwhatsapp te ontvangen.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no2&#039;] = &quot;Takk for at du kontakter v&aring;r eiendom.\nHer er informasjonen du har bedt om om f&oslash;lgende eiendom.\nDu kan klikke for mer informasjon og lignende hus:\n\n{{PROPERTY}}\n\nHvis du vil at en av v&aring;re r&aring;dgivere skal kontakte deg, vennligst svar p&aring; denne e-posten og angi et tidspunkt det passer for deg &aring; motta en samtale eller whatsapp.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru2&#039;] = &quot;&quot;;
intr_txt[&#039;se2&#039;] = &quot;Tack f&ouml;r att du har kontaktat v&aring;r fastighetsbyr&aring;.\nH&auml;r har du den information som du har beg&auml;rt om f&ouml;ljande fastighet.\nDu kan klicka f&ouml;r mer information och liknande hus:\n\n{{PROPERTY}}\n\nOm du vill att en av v&aring;ra r&aring;dgivare ska kontakta dig, v&auml;nligen svara p&aring; detta e-postmeddelande och ange en tidpunkt n&auml;r det skulle passa dig att f&aring; ett samtal eller enwhatsapp.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl2&#039;] = &quot;Dzi&#x119;kujemy za kontakt z nasz&#x105; agencj&#x105; nieruchomo&#x15b;ci.\nTutaj znajdziesz informacje, o kt&oacute;re prosi&#x142;e&#x15b;, dotycz&#x105;ce nast&#x119;puj&#x105;cej nieruchomo&#x15b;ci.\nKliknij, aby uzyska&#x107; wi&#x119;cej informacji i zobaczy&#x107; podobne domy:\n\n{{PROPERTY}}\n\nJe&#x15b;li chcesz, aby jeden z naszych doradc&oacute;w skontaktowa&#x142; si&#x119; z Tob&#x105;, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, podaj&#x105;c czas, w kt&oacute;rym by&#x142;by&#x15b; zainteresowany otrzymaniem telefonu lubwiadomo&#x15b;ci SMS.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da3&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de3&#039;] = &quot;Antwort Follow-up&quot;;
intr_sub[&#039;en3&#039;] = &quot;Response Follow-up&quot;;
intr_sub[&#039;es3&#039;] = &quot;Respuesta Seguimiento&quot;;
//intr_sub[&#039;fi3&#039;] = &quot;&quot;;
intr_sub[&#039;fr3&#039;] = &quot;Suivi de la r&eacute;ponse&quot;;
//intr_sub[&#039;is3&#039;] = &quot;&quot;;
intr_sub[&#039;nl3&#039;] = &quot;Antwoord Follow-up&quot;;
intr_sub[&#039;no3&#039;] = &quot;Respons Oppf&oslash;lging&quot;;
// intr_sub[&#039;ru3&#039;] = &quot;&quot;;
intr_sub[&#039;se3&#039;] = &quot;Uppf&ouml;ljning av svaret&quot;;
intr_sub[&#039;pl3&#039;] = &quot;Odpowied&#x17a; Kontynuacja&quot;;

// intr_txt[&#039;da3&#039;] = &quot;&quot;;
intr_txt[&#039;de3&#039;] = &quot;Hallo ...........................\n\nZun&auml;chst einmal danke ich Ihnen, dass Sie sich die Zeit genommen haben, mit mir zu sprechen. \nIch habe mich sehr gefreut, dass ich mit Ihnen &uuml;ber Ihre Wohnungssuche sprechen konnte:\n\n{{PROPERTY}}\n\nDamit wir in Kontakt bleiben k&ouml;nnen, finden Sie meine Kontaktdaten (Mobiltelefon und E-Mail-Adresse) unter meiner Unterschrift.\n\nBei dieser Gelegenheit m&ouml;chte ich Ihnen mitteilen, dass Sie auf unserer Website H&auml;user mit &auml;hnlichen Merkmalen sehen k&ouml;nnen, \n\nIch stehe Ihnen f&uuml;r jede Kl&auml;rung zur Verf&uuml;gung.\n&quot;;
intr_txt[&#039;en3&#039;] = &quot;Hello ...........................\n\nFirstly, thank you for taking the time to speak with me. \nI was delighted to have the opportunity to speak with you about your housing search:\n\n{{PROPERTY}}\n\nTo help us keep in touch, you will find my contact details (mobile phone and email address) below my signature.\n\nI would like to take this opportunity to tell you that you can see houses with similar characteristics on our website, \n\nI remain at your disposal for any clarification.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es3&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\n\nEn primer lugar, gracias por dedicar su tiempo a hablar conmigo. \nMe ha encantado tener la oportunidad de hablar con usted sobre su b&uacute;squeda de vivienda:\n\n{{PROPERTY}}\n\nPara ayudarnos a mantener el contacto, encontrar&aacute; mis datos (tel&eacute;fono m&oacute;vil y direcci&oacute;n de correo electr&oacute;nico) debajo de mi firma.\n\nAprovecho para comentarte, en nuestra web, puedes ver casas con similares caracter&iacute;sticas, \n\nQuedo a tu disposici&oacute;n para cualquier aclaraci&oacute;n.\n\nUn saludo  y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi3&#039;] = &quot;&quot;;
intr_txt[&#039;fr3&#039;] = &quot;Bonjour ...........................\n\nTout d&#039;abord, je vous remercie d&#039;avoir pris le temps de me parler. \nJ&#039;ai &eacute;t&eacute; ravi d&#039;avoir l&#039;occasion de parler avec vous de votre recherche de logement :\n\n{{PROPERTY}}\n\nPour nous aider &agrave; rester en contact, vous trouverez mes coordonn&eacute;es (t&eacute;l&eacute;phone portable et adresse &eacute;lectronique) sous ma signature.\n\nJe profite de l&#039;occasion pour vous dire que vous pouvez voir des maisons aux caract&eacute;ristiques similaires sur notre site web, \n\nJe reste &agrave; votre disposition pour toute clarification.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is3&#039;] = &quot;&quot;;
intr_txt[&#039;nl3&#039;] = &quot;Hallo ...........................\n\nTen eerste, dank u dat u de tijd neemt om met mij te spreken. \nIk was verheugd de kans te krijgen met u te spreken over uw zoektocht naar een woning:\n\n{{PROPERTY}}\n\nOm ons te helpen contact te houden, vindt u mijn contactgegevens (mobiele telefoon en e-mailadres) onder mijn handtekening.\n\nIk wil van deze gelegenheid gebruik maken om u te zeggen dat u huizen met soortgelijke kenmerken op onze website kunt bekijken, \n\nIk blijf tot uw beschikking voor elke verduidelijking.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no3&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\n\nF&oslash;rst av alt, takk for at du tok deg tid til &aring; snakke med meg.\nJeg har v&aelig;rt glad for &aring; f&aring; muligheten til &aring; snakke med deg om boligs&oslash;ket ditt:\n\n{{PROPERTY}}\n\nFor &aring; hjelpe oss med &aring; holde kontakten finner du detaljene mine (mobiltelefon og e-postadresse) under signaturen min.\n\nJeg benytter anledningen til &aring; fortelle deg at p&aring; nettsiden v&aring;r kan du se hus med lignende egenskaper,\n\nJeg st&aring;r til din disposisjon for enhver avklaring.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru3&#039;] = &quot;&quot;;
intr_txt[&#039;se3&#039;] = &quot;Hej ...........................\n\nF&ouml;rst och fr&auml;mst vill jag tacka er f&ouml;r att ni tog er tid att tala med mig. \nDet var roligt att f&aring; tillf&auml;lle att tala med dig om din bostadss&ouml;kning:\n\n{{PROPERTY}}\n\nF&ouml;r att vi ska kunna h&aring;lla kontakten hittar du mina kontaktuppgifter (mobiltelefon och e-postadress) under min signatur.\n\nJag vill ta tillf&auml;llet i akt att ber&auml;tta att du kan se hus med liknande egenskaper p&aring; v&aring;r webbplats, \n\nJag st&aring;r till ert f&ouml;rfogande f&ouml;r eventuella f&ouml;rtydliganden.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl3&#039;] = &quot;Witaj ...........................\n\nPo pierwsze, dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cenie czasu na rozmow&#x119; ze mn&#x105;. \nCiesz&#x119; si&#x119;, &#x17c;e mia&#x142;am okazj&#x119; porozmawia&#x107; z Pa&#x144;stwem o poszukiwaniu mieszkania:\n\n{{PROPERTY}}\n\nAby&#x15b;my mogli pozosta&#x107; w kontakcie, pod moim podpisem znajdziesz moje dane kontaktowe (telefon kom&oacute;rkowy i adres e-mail).\n\nKorzystaj&#x105;c z okazji, pragn&#x119; poinformowa&#x107;, &#x17c;e na naszej stronie internetowej mo&#x17c;na obejrze&#x107; domy o podobnej charakterystyce, \n\nPozostaj&#x119; do Pa&#x144;stwa dyspozycji w przypadku jakichkolwiek wyja&#x15b;nie&#x144;.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da4&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de4&#039;] = &quot;Best&auml;tigung des Besuchs&quot;;
intr_sub[&#039;en4&#039;] = &quot;Confirmation of visit&quot;;
intr_sub[&#039;es4&#039;] = &quot;Confirmaci&oacute;n visita&quot;;
//intr_sub[&#039;fi4&#039;] = &quot;&quot;;
intr_sub[&#039;fr4&#039;] = &quot;Confirmation de la visite&quot;;
//intr_sub[&#039;is4&#039;] = &quot;&quot;;
intr_sub[&#039;nl4&#039;] = &quot;Bevestiging van het bezoek&quot;;
intr_sub[&#039;no4&#039;] = &quot;Konfirmasjonsbes&oslash;k&quot;;
// intr_sub[&#039;ru4&#039;] = &quot;&quot;;
intr_sub[&#039;se4&#039;] = &quot;Bekr&auml;ftelse av bes&ouml;ket&quot;;
intr_sub[&#039;pl4&#039;] = &quot;Potwierdzenie wizyty&quot;;

// intr_txt[&#039;da4&#039;] = &quot;&quot;;
intr_txt[&#039;de4&#039;] = &quot;Hallo ...........................\nDies ist die Best&auml;tigung des Termins zur Besichtigung der Immobilie:\nDatum: ......................\nZeit: ......................\nTreffpunkt: ......................\nEigenschaften zur Ansicht: \n\n{{PROPERTY}}\n\nBest&auml;tigen Sie mir, ob die Daten korrekt sind:\n......................\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en4&#039;] = &quot;Hello ...........................\nThis is the confirmation of the appointment to visit the property:\nDate: ......................\nTime: ......................\nMeeting point: ......................\nProperties to view: \n\n{{PROPERTY}} \n\nConfirm me if the data is correct:\n......................\n\nBest regards and thanks for your time\n&quot;;
intr_txt[&#039;es4&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\nEsta es la confirmaci&oacute;n de la cita para visitar la vivienda:\nFecha: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nHora: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nPunto de encuentro: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nPropiedades para ver: \n\n{{PROPERTY}} \n\nConf&iacute;rmame si los datos son correctos:\n&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nUn saludo  y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi4&#039;] = &quot;&quot;;
intr_txt[&#039;fr4&#039;] = &quot;Bonjour ...........................\nIl s&#039;agit de la confirmation du rendez-vous pour la visite du bien :\nDate : ......................\nHeure : ......................\nPoint de rencontre : ......................\nPropri&eacute;t&eacute;s &agrave; visualiser : \n\n{{PROPERTY}}\n\nConfirmez-moi si les donn&eacute;es sont correctes :\n......................\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is4&#039;] = &quot;&quot;;
intr_txt[&#039;nl4&#039;] = &quot;Hallo ...........................\nDit is de bevestiging van de afspraak om de woning te bezichtigen:\nDatum: ......................\nTijd: ......................\nTrefpunt: ......................\nEigenschappen om te bekijken: \n\n{{PROPERTY}} \n\nBevestig me of de gegevens juist zijn:\n......................\n\nMet vriendelijke groet en bedankt voor uw tijd\n&quot;;
intr_txt[&#039;no4&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;\nDette er bekreftelsen p&aring; avtalen om &aring; bes&oslash;ke huset:\nDato: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nTime: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nM&oslash;tepunkt: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nEgenskaper &aring; se:\n\n{{PROPERTY}}\n\nVennligst bekreft om dataene er korrekte:\n&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru4&#039;] = &quot;&quot;;
intr_txt[&#039;se4&#039;] = &quot;Hej ...........................\nDetta &auml;r en bekr&auml;ftelse p&aring; att du har f&aring;tt ett m&ouml;te f&ouml;r att bes&ouml;ka fastigheten:\nDatum: ......................\nTid: ......................\nM&ouml;tesplats: ......................\nEgenskaper att visa: \n\n{{PROPERTY}} \n\nBekr&auml;fta om uppgifterna &auml;r korrekta:\n......................\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl4&#039;] = &quot;Witaj ...........................\nJest to potwierdzenie um&oacute;wienia si&#x119; na wizyt&#x119; w obiekcie:\nData: ......................\nCzas: ......................\nMiejsce spotkania: ......................\nW&#x142;a&#x15b;ciwo&#x15b;ci do przegl&#x105;dania: \n\n{{PROPERTY}}\n\nPotwierd&#x17a;, czy dane s&#x105; poprawne:\n......................\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da5&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de5&#039;] = &quot;Best&auml;tigung der Auflistung&quot;;
intr_sub[&#039;en5&#039;] = &quot;Listing confirmation&quot;;
intr_sub[&#039;es5&#039;] = &quot;Confirmaci&oacute;n de listado&quot;;
//intr_sub[&#039;fi5&#039;] = &quot;&quot;;
intr_sub[&#039;fr5&#039;] = &quot;Confirmation de l&#039;inscription&quot;;
//intr_sub[&#039;is5&#039;] = &quot;&quot;;
intr_sub[&#039;nl5&#039;] = &quot;Bevestiging van de lijst&quot;;
intr_sub[&#039;no5&#039;] = &quot;Oppf&oslash;ringsbekreftelse&quot;;
// intr_sub[&#039;ru5&#039;] = &quot;&quot;;
intr_sub[&#039;se5&#039;] = &quot;Bekr&auml;ftelse av listning&quot;;
intr_sub[&#039;pl5&#039;] = &quot;Potwierdzenie wpisu na list&#x119;&quot;;

// intr_txt[&#039;da5&#039;] = &quot;&quot;;
intr_txt[&#039;de5&#039;] = &quot;Hallo ......................\n\nDies ist eine Best&auml;tigung, um Ihre Immobilie kennenzulernen und die notwendigen Daten zu erheben, um Ihre Immobilie in unserem System zu registrieren und zum Verkaufanzubieten: \n\nDatum: ......................\nZeit: ......................\nKontaktperson: ......................\n\nDie Person, die Ihre Immobilie besichtigt, verf&uuml;gt &uuml;ber viel Erfahrung und Wissen &uuml;ber den Immobilienmarkt und kann Ihnen helfen und Sie beraten, um den bestm&ouml;glichenPreis zu erzielen und Ihre Fragen zum Verkaufsprozess zu beantworten. \n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en5&#039;] = &quot;Hello ......................\n\nThis is a confirmation to meet your property and make the necessary data collection to register your property in our system and put it for sale: \n\nDate: ......................\nTime: ......................\nContact person: ......................\n\nThe person who will visit your property has a lot of experience and knowledge of the property market and will be able to help and advise you to achieve the bestpossible price and answer your questions about the selling process. \n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es5&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nEsta es una confirmaci&oacute;n para quedar en su propiedad y realizar la toma de datos necesaria para dar de alta su propiedad en nuestro sistema y ponerla en venta: \n\nFecha: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nHora: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nPersona de contacto: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nLa persona que visitar&aacute; su propiedad tiene mucha experiencia y conocimiento del mercado inmobiliario y podr&aacute; ayudarlo y asesorarlo para lograr el mejor precio posible y responder a sus preguntas sobre proceso de venta. \n\nUn saludo  y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi5&#039;] = &quot;&quot;;
intr_txt[&#039;fr5&#039;] = &quot;Bonjour ......................\n\nIl s&#039;agit d&#039;une confirmation pour rencontrer votre propri&eacute;t&eacute; et effectuer la collecte des donn&eacute;es n&eacute;cessaires pour enregistrer votre propri&eacute;t&eacute; dans notre syst&egrave;me et lamettre en vente : \n\nDate : ......................\nHeure : ......................\nPersonne de contact : ......................\n\nLa personne qui visitera votre propri&eacute;t&eacute; a beaucoup d&#039;exp&eacute;rience et de connaissances du march&eacute; immobilier et pourra vous aider et vous conseiller pour obtenir lemeilleur prix possible et r&eacute;pondre &agrave; vos questions sur le processus de vente. \n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is5&#039;] = &quot;&quot;;
intr_txt[&#039;nl5&#039;] = &quot;Hallo ......................\n\nDit is een bevestiging om uw eigendom te ontmoeten en de nodige gegevens te verzamelen om uw eigendom in ons systeem te registreren en het te koop aan te bieden: \n\nDatum: ......................\nTijd: ......................\nContactpersoon: ......................\n\nDe persoon die uw eigendom zal bezoeken heeft veel ervaring en kennis van de vastgoedmarkt en zal u kunnen helpen en adviseren om de best mogelijke prijs te bereiken enuw vragen over het verkoopproces te beantwoorden. \n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no5&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nDette er en bekreftelse p&aring; &aring; bo i din eiendom og utf&oslash;re n&oslash;dvendig datainnsamling for &aring; registrere din eiendom i v&aring;rt system og legge den ut for salg:\n\nDato: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nTime: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\nKontaktperson: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nDen som skal bes&oslash;ke din eiendom har mye erfaring og kunnskap om eiendomsmarkedet og vil kunne hjelpe og gi deg r&aring;d for &aring; oppn&aring; best mulig pris og svare p&aring; dine sp&oslash;rsm&aring;lom salgsprosessen.\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru5&#039;] = &quot;&quot;;
intr_txt[&#039;se5&#039;] = &quot;Hej ......................\n\nDetta &auml;r en bekr&auml;ftelse p&aring; att vi ska tr&auml;ffa din fastighet och g&ouml;ra den n&ouml;dv&auml;ndiga datainsamlingen f&ouml;r att registrera din fastighet i v&aring;rt system och l&auml;gga ut den tillf&ouml;rs&auml;ljning: \n\nDatum: ......................\nTid: ......................\nKontaktperson: ......................\n\nDen person som bes&ouml;ker din fastighet har stor erfarenhet och kunskap om fastighetsmarknaden och kommer att kunna hj&auml;lpa och ge dig r&aring;d f&ouml;r att uppn&aring; b&auml;sta m&ouml;jliga prisoch svara p&aring; dina fr&aring;gor om f&ouml;rs&auml;ljningsprocessen. \n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl5&#039;] = &quot;Witaj ......................\n\nJest to potwierdzenie spotkania z klientem i zebrania danych niezb&#x119;dnych do zarejestrowania nieruchomo&#x15b;ci w naszym systemie i wystawienia jej na sprzeda&#x17c;: \n\nData: ......................\nCzas: ......................\nOsoba kontaktowa: ......................\n\nOsoba, kt&oacute;ra odwiedzi Pa&#x144;stwa nieruchomo&#x15b;&#x107;, ma du&#x17c;e do&#x15b;wiadczenie i wiedz&#x119; na temat rynku nieruchomo&#x15b;ci i b&#x119;dzie w stanie pom&oacute;c i doradzi&#x107; Pa&#x144;stwu w osi&#x105;gni&#x119;ciu jaknajlepszej ceny oraz odpowiedzie&#x107; na Pa&#x144;stwa pytania dotycz&#x105;ce procesu sprzeda&#x17c;y. \n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da6&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de6&#039;] = &quot;Follow-up nach dem Besuch&quot;;
intr_sub[&#039;en6&#039;] = &quot;Follow up after visit&quot;;
intr_sub[&#039;es6&#039;] = &quot;Seguimiento tras visita&quot;;
//intr_sub[&#039;fi6&#039;] = &quot;&quot;;
intr_sub[&#039;fr6&#039;] = &quot;Suivi apr&egrave;s la visite&quot;;
//intr_sub[&#039;is6&#039;] = &quot;&quot;;
intr_sub[&#039;nl6&#039;] = &quot;Follow-up na het bezoek&quot;;
intr_sub[&#039;no6&#039;] = &quot;Oppf&oslash;lging etter bes&oslash;k&quot;;
// intr_sub[&#039;ru6&#039;] = &quot;&quot;;
intr_sub[&#039;se6&#039;] = &quot;Uppf&ouml;ljning efter bes&ouml;ket&quot;;
intr_sub[&#039;pl6&#039;] = &quot;Post&#x119;powanie po wizycie&quot;;

// intr_txt[&#039;da6&#039;] = &quot;&quot;;
intr_txt[&#039;de6&#039;] = &quot;Hallo ......................\n\nIch hoffe, dass Ihnen die Objekte gefallen, die wir k&uuml;rzlich besucht haben. \n\n{{PROPERTY}} \n\nIch sende Ihnen diese Nachricht, um zu erfahren, ob Sie weitere Informationen ben&ouml;tigen oder das Haus noch einmal besichtigen m&ouml;chten.\n\nM&ouml;chten Sie, dass wir dem Verk&auml;ufer ein Angebot machen, oder m&ouml;chten Sie, dass wir andere Immobilien besichtigen?\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en6&#039;] = &quot;Hello ......................\nI hope you like the properties we went to visit recently. \n{{PROPERTY}} \nI am sending you this message to see if you need any further information or even if you would like to visit the house again.\nWould you like us to make an offer to the seller or would you prefer us to visit other properties?\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es6&#039;] = &quot;Hola  &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nEspero que te gustar&aacute;n las propiedades que fuimos a visitar recientemente. \n\n{{PROPERTY}} \n\nTe env&iacute;o este mensaje para ver si necesitas m&aacute;s informaci&oacute;n o incluso si quieres volver a visitar la casa.\n\n&iquest;Quieres que realicemos una oferta al vendedor o prefieres que visitemos otras viviendas?\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi6&#039;] = &quot;&quot;;
intr_txt[&#039;fr6&#039;] = &quot;Bonjour ......................\n\nJ&#039;esp&egrave;re que vous aimez les propri&eacute;t&eacute;s que nous sommes all&eacute;s visiter r&eacute;cemment. \n\n{{PROPERTY}}\n\nJe vous envoie ce message pour voir si vous avez besoin de plus d&#039;informations ou m&ecirc;me si vous souhaitez visiter &agrave; nouveau la maison.\n\nSouhaitez-vous que nous fassions une offre au vendeur ou pr&eacute;f&eacute;rez-vous que nous visitions d&#039;autres propri&eacute;t&eacute;s ?\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is6&#039;] = &quot;&quot;;
intr_txt[&#039;nl6&#039;] = &quot;Hallo ......................\n\nIk hoop dat de eigendommen die we onlangs bezochten u bevallen. \n\n{{PROPERTY}} \n\nIk stuur u dit bericht om te zien of u nog verdere informatie nodig hebt of zelfs of u het huis nog eens zou willen bezoeken.\n\nWilt u dat wij een bod doen aan de verkoper of heeft u liever dat wij andere woningen bezichtigen?\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no6&#039;] = &quot;Hallo  &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nJeg h&aring;per du vil like eiendommene vi nylig bes&oslash;kte.\n\n{{PROPERTY}}\n\nJeg sender deg denne meldingen for &aring; se om du trenger mer informasjon eller om du &oslash;nsker &aring; bes&oslash;ke huset igjen.\n\n&Oslash;nsker du at vi skal gi et tilbud til selger eller foretrekker du at vi bes&oslash;ker andre boliger?\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru6&#039;] = &quot;&quot;;
intr_txt[&#039;se6&#039;] = &quot;Hej ......................\n\nJag hoppas att du gillar de fastigheter som vi bes&ouml;kte nyligen. \n\n{{PROPERTY}} \n\nJag skickar det h&auml;r meddelandet f&ouml;r att h&ouml;ra om du beh&ouml;ver mer information eller om du vill bes&ouml;ka huset igen.\n\nVill du att vi ska l&auml;gga ett bud p&aring; s&auml;ljaren eller f&ouml;redrar du att vi bes&ouml;ker andra fastigheter?\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl6&#039;] = &quot;Witaj ......................\n\nMam nadziej&#x119;, &#x17c;e spodobaj&#x105; si&#x119; Wam nieruchomo&#x15b;ci, kt&oacute;re ostatnio odwiedzili&#x15b;my. \n\n{{PROPERTY}} \n\nWysy&#x142;am t&#x119; wiadomo&#x15b;&#x107;, aby dowiedzie&#x107; si&#x119;, czy potrzebujecie Pa&#x144;stwo dalszych informacji lub czy chcieliby&#x15b;cie ponownie odwiedzi&#x107; dom.\n\nCzy chcesz, aby&#x15b;my z&#x142;o&#x17c;yli ofert&#x119; sprzedaj&#x105;cemu, czy wolisz, aby&#x15b;my odwiedzili inne nieruchomo&#x15b;ci?\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da7&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de7&#039;] = &quot;Keine Antwort&quot;;
intr_sub[&#039;en7&#039;] = &quot;No reply&quot;;
intr_sub[&#039;es7&#039;] = &quot;No responde&quot;;
//intr_sub[&#039;fi7&#039;] = &quot;&quot;;
intr_sub[&#039;fr7&#039;] = &quot;Pas de r&eacute;ponse&quot;;
//intr_sub[&#039;is7&#039;] = &quot;&quot;;
intr_sub[&#039;nl7&#039;] = &quot;Geen antwoord&quot;;
intr_sub[&#039;no7&#039;] = &quot;Svarer ikke&quot;;
// intr_sub[&#039;ru7&#039;] = &quot;&quot;;
intr_sub[&#039;se7&#039;] = &quot;Inget svar&quot;;
intr_sub[&#039;pl7&#039;] = &quot;Brak odpowiedzi&quot;;

// intr_txt[&#039;da7&#039;] = &quot;&quot;;
intr_txt[&#039;de7&#039;] = &quot;Hallo \n\nWir haben Ihre Anfrage nach Informationen &uuml;ber diese Immobilie erhalten:\n\n{{PROPERTY}}\n\nWir haben mehrmals versucht, Sie zu kontaktieren, aber es war nicht m&ouml;glich.\n\nWenn Sie immer noch interessiert sind, lassen Sie mich bitte wissen, wann wir Sie wieder kontaktieren sollen.\nWenn Sie weitere Informationen ben&ouml;tigen, wenden Sie sich bitte an uns.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en7&#039;] = &quot;We have received your request for information about this property:\n\n{{PROPERTY}}\n\nWe have tried to contact you several times and it has not been possible.\n\nIf you are still interested, please let me know when you would like us to contact you again.\nIf you need any further information, please contact us.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es7&#039;] = &quot;Hola \n\nTras haber recibido tu solicitud de informaci&oacute;n sobre esta propiedad:\n\n{{PROPERTY}}\n\nHemos intentado contactar contigo en diferentes ocasiones y no ha sido posible.\n\nSi a&uacute;n est&aacute;s interesado, ind&iacute;came en que horario quieres que volvamos a contactarte\nSi necesitas cualquier tipo de informaci&oacute;n adicional ponte en contacto con nosotros\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi7&#039;] = &quot;&quot;;
intr_txt[&#039;fr7&#039;] = &quot;Bonjour \n\nNous avons re&ccedil;u votre demande d&#039;information sur cette propri&eacute;t&eacute; :\n\n{{PROPERTY}}\n\nNous avons essay&eacute; de vous contacter &agrave; plusieurs reprises, mais cela n&#039;a pas &eacute;t&eacute; possible.\n\nSi vous &ecirc;tes toujours int&eacute;ress&eacute;, veuillez me faire savoir quand vous souhaitez que nous vous recontactions.\nSi vous avez besoin de plus amples informations, veuillez nous contacter.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is7&#039;] = &quot;&quot;;
intr_txt[&#039;nl7&#039;] = &quot;Hallo \n\nWij hebben uw verzoek om informatie over deze woning ontvangen:\n\n{{PROPERTY}}\n\nWe hebben verschillende keren geprobeerd contact met u op te nemen, maar dat is niet gelukt.\n\nAls u nog steeds ge&iuml;nteresseerd bent, laat me dan weten wanneer u wilt dat wij weer contact met u opnemen.\nIndien u meer informatie wenst, kunt u contact met ons opnemen.\n\nMet vriendelijke groet en dank u voor uw tijd\n&quot;;
intr_txt[&#039;no7&#039;] = &quot;Hallo\n\nEtter &aring; ha mottatt din foresp&oslash;rsel om informasjon om denne eiendommen:\n\n{{PROPERTY}}\n\nVi har fors&oslash;kt &aring; kontakte deg ved forskjellige anledninger og det har ikke v&aelig;rt mulig.\n\nHvis du fortsatt er interessert, fortell meg n&aring;r du vil at vi skal kontakte deg igjen\nHvis du trenger ytterligere informasjon, vennligst kontakt oss\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru7&#039;] = &quot;&quot;;
intr_txt[&#039;se7&#039;] = &quot;Hej \n\nVi har mottagit din beg&auml;ran om information om denna fastighet:\n\n{{PROPERTY}}\n\nVi har f&ouml;rs&ouml;kt kontakta dig flera g&aring;nger men det har inte varit m&ouml;jligt.\n\nOm du fortfarande &auml;r intresserad, l&aring;t mig veta n&auml;r du vill att vi kontaktar dig igen.\nOm du beh&ouml;ver mer information kan du kontakta oss.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl7&#039;] = &quot;Witaj \n\nOtrzymali&#x15b;my Twoj&#x105; pro&#x15b;b&#x119; o informacje na temat tego obiektu:\n\n{{PROPERTY}}\n\nKilkakrotnie pr&oacute;bowali&#x15b;my si&#x119; z Tob&#x105; skontaktowa&#x107;, ale nie by&#x142;o to mo&#x17c;liwe.\n\nJe&#x15b;li nadal jeste&#x15b; zainteresowany, daj mi zna&#x107;, kiedy chcia&#x142;by&#x15b;, aby&#x15b;my skontaktowali si&#x119; z Tob&#x105; ponownie.\nJe&#x15b;li potrzebujesz dodatkowych informacji, skontaktuj si&#x119; z nami.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;


//intr_sub[&#039;da8&#039;] = &quot;Ejendom i Spanien&quot;;
intr_sub[&#039;de8&#039;] = &quot;Keine Antwort 2&quot;;
intr_sub[&#039;en8&#039;] = &quot;No reply 2&quot;;
intr_sub[&#039;es8&#039;] = &quot;No responde 2&quot;;
//intr_sub[&#039;fi8&#039;] = &quot;&quot;;
intr_sub[&#039;fr8&#039;] = &quot;Pas de r&eacute;ponse 2&quot;;
//intr_sub[&#039;is8&#039;] = &quot;&quot;;
intr_sub[&#039;nl8&#039;] = &quot;Geen antwoord 2&quot;;
intr_sub[&#039;no8&#039;] = &quot;ikke noe svar 2&quot;;
// intr_sub[&#039;ru8&#039;] = &quot;&quot;;
intr_sub[&#039;se8&#039;] = &quot;Inget svar 2&quot;;
intr_sub[&#039;pl8&#039;] = &quot;Brak odpowiedzi 2&quot;;

// intr_txt[&#039;da8&#039;] = &quot;&quot;;
intr_txt[&#039;de8&#039;] = &quot;Hallo ......................\n\nVor einiger Zeit haben Sie uns kontaktiert und um weitere Informationen &uuml;ber unsere Immobilien gebeten.\n\nIch schreibe Ihnen, um zu erfahren, ob Sie immer noch am Kauf einer Immobilie interessiert sind und ob Sie m&ouml;chten, dass wir Sie erneut kontaktieren.\n\nWenn Sie immer noch interessiert sind, antworten Sie bitte auf diese Nachricht, und ich werde mich so bald wie m&ouml;glich mit Ihnen in Verbindung setzen.\n\nFalls nicht, w&auml;re ich Ihnen dankbar, wenn Sie auf diese Nachricht mit dem Vermerk \&quot;Ich m&ouml;chte keine weiteren Informationen erhalten\&quot; antworten k&ouml;nnten.\n\nMit freundlichen Gr&uuml;&szlig;en und vielen Dank f&uuml;r Ihre Zeit\n&quot;;
intr_txt[&#039;en8&#039;] = &quot;Some time ago you contacted us requesting more information about our properties.\n\nI am writing to see if you are still interested in buying a property and also to see if you would like us to contact you again.\n\nIf you are still interested, please reply to this message, and I will contact you as soon as possible.\n\nIf you are not, I would be grateful if you could reply to this message indicating \&quot;I do not wish to receive any further information\&quot;.\n\nBest regards and thank you for your time\n&quot;;
intr_txt[&#039;es8&#039;] = &quot;Hola &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nHace un tiempo te pusiste en contacto con nosotros solicitando m&aacute;s informaci&oacute;n sobre nuestras propiedades.\n\nTe escribo para saber si sigues interesado en la compra de una vivienda y tambi&eacute;n para saber si deseas que te volvamos a contactar.\n\nSi a&uacute;n est&aacute;s interesado, responde a este mensaje, y me pondr&eacute; en contacto contigo a la mayor brevedad posible\n\nSi por el contrario, no lo est&aacute;s, te agradecer&iacute;a respondieras este mensaje indicando &ldquo;no deseo recibir m&aacute;s informaci&oacute;n&rdquo;\n\nUn saludo y gracias por tu tiempo\n&quot;;
// intr_txt[&#039;fi8&#039;] = &quot;&quot;;
intr_txt[&#039;fr8&#039;] = &quot;Bonjour ......................\n\nIl y a quelque temps, vous nous avez contact&eacute;s pour demander de plus amples informations sur nos propri&eacute;t&eacute;s.\n\nJe vous &eacute;cris pour savoir si vous &ecirc;tes toujours int&eacute;ress&eacute; par l&#039;achat d&#039;une propri&eacute;t&eacute; et aussi pour savoir si vous souhaitez que nous vous recontactions.\n\nSi vous &ecirc;tes toujours int&eacute;ress&eacute;, veuillez r&eacute;pondre &agrave; ce message, et je vous contacterai d&egrave;s que possible.\n\nSi vous ne l&#039;&ecirc;tes pas, je vous serais reconnaissant de r&eacute;pondre &agrave; ce message en indiquant \&quot;Je ne souhaite pas recevoir d&#039;autres informations\&quot;.\n\nMeilleures salutations et merci pour votre temps\n&quot;;
// intr_txt[&#039;is8&#039;] = &quot;&quot;;
intr_txt[&#039;nl8&#039;] = &quot;Enige tijd geleden nam u contact met ons op om meer informatie te vragen over onze eigendommen.\n\nIk schrijf u om te zien of u nog steeds ge&iuml;nteresseerd bent in het kopen van een woning en ook om te zien of u wilt dat wij opnieuw contact met u opnemen.\n\nAls u nog steeds ge&iuml;nteresseerd bent, reageer dan op dit bericht, en ik zal zo spoedig mogelijk contact met u opnemen.\n\nIndien dit niet het geval is, zou ik u dankbaar zijn indien u op dit bericht zou willen antwoorden met de vermelding \&quot;ik wens geen verdere informatie te ontvangen\&quot;.\n\nMet vriendelijke groet en bedankt voor uw tijd\n&quot;;
intr_txt[&#039;no8&#039;] = &quot;Hallo &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.\n\nFor en tid siden kontaktet du oss og ba om mer informasjon om eiendommene v&aring;re.\n\nJeg skriver for &aring; finne ut om du fortsatt er interessert i &aring; kj&oslash;pe bolig og ogs&aring; for &aring; finne ut om du &oslash;nsker at vi skal kontakte deg igjen.\n\nHvis du fortsatt er interessert, svar p&aring; denne meldingen, s&aring; kontakter jeg deg s&aring; snart som mulig.\n\nHvis du derimot ikke er det, vil jeg sette pris p&aring; om du vil svare p&aring; denne meldingen med \&quot;Jeg &oslash;nsker ikke &aring; motta mer informasjon\&quot;\n\nHilsen og takk for din tid\n&quot;;
// intr_txt[&#039;ru8&#039;] = &quot;&quot;;
intr_txt[&#039;se8&#039;] = &quot;Hej ......................\n\nF&ouml;r en tid sedan kontaktade du oss och bad om mer information om v&aring;ra fastigheter.\n\nJag skriver f&ouml;r att h&ouml;ra om du fortfarande &auml;r intresserad av att k&ouml;pa en fastighet och f&ouml;r att h&ouml;ra om du vill att vi kontaktar dig igen.\n\nOm du fortfarande &auml;r intresserad kan du svara p&aring; det h&auml;r meddelandet, s&aring; kontaktar jag dig s&aring; snart som m&ouml;jligt.\n\nOm du inte &auml;r det skulle jag vara tacksam om du kunde svara p&aring; detta meddelande och ange \&quot;Jag vill inte f&aring; n&aring;gon ytterligare information\&quot;.\n\nMed v&auml;nliga h&auml;lsningar och tack f&ouml;r att du tog dig tid.\n&quot;;
intr_txt[&#039;pl8&#039;] = &quot;Witaj ......................\n\nJaki&#x15b; czas temu skontaktowa&#x142;e&#x15b; si&#x119; z nami, prosz&#x105;c o wi&#x119;cej informacji na temat naszych nieruchomo&#x15b;ci.\n\nPisz&#x119;, aby sprawdzi&#x107;, czy nadal jest Pan/Pani zainteresowany/a zakupem nieruchomo&#x15b;ci, a tak&#x17c;e, czy chcia&#x142;by Pan/Pani, aby&#x15b;my ponownie si&#x119; z Panem/Pani&#x105; skontaktowali.\n\nJe&#x15b;li nadal jeste&#x15b; zainteresowany, odpowiedz na t&#x119; wiadomo&#x15b;&#x107;, a ja skontaktuj&#x119; si&#x119; z Tob&#x105; tak szybko, jak to b&#x119;dzie mo&#x17c;liwe.\n\nJe&#x15b;li tak nie jest, by&#x142;bym wdzi&#x119;czny, gdyby odpowiedzia&#x142; Pan na t&#x119; wiadomo&#x15b;&#x107;, zaznaczaj&#x105;c \&quot;Nie chc&#x119; otrzymywa&#x107; &#x17c;adnych dalszych informacji\&quot;.\n\nPozdrawiam serdecznie i dzi&#x119;kuj&#x119; za po&#x15b;wi&#x119;cony czas\n&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php do { ?&gt;
  &lt;?php foreach ($languages as $langval): ?&gt;
  intr_sub[&#039;&lt;?php echo $langval ?&gt;&lt;?php echo $row_rsTemplates[&#039;id_tmpl&#039;]?&gt;&#039;] = &quot;&lt;?php echo mysql_real_escape_string($row_rsTemplates[&#039;subject_&#039;.$langval.&#039;_tmpl&#039;]); ?&gt;&quot;;
  intr_txt[&#039;&lt;?php echo $langval ?&gt;&lt;?php echo $row_rsTemplates[&#039;id_tmpl&#039;]?&gt;&#039;] = &quot;&lt;?php echo mysql_real_escape_string($row_rsTemplates[&#039;content_&#039;.$langval.&#039;_tmpl&#039;]); ?&gt;&quot;;

  &lt;?php endforeach ?&gt;
&lt;?php } while ($row_rsTemplates = mysql_fetch_assoc($rsTemplates));
$rows = mysql_num_rows($rsTemplates);
if($rows &gt; 0) {
    mysql_data_seek($rsTemplates, 0);
  $row_rsTemplates = mysql_fetch_assoc($rsTemplates);
} ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:179
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/properties/nacionalidades.php&quot; &lt;?php if(preg_match(&#039;/\/nacionalidades/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-flag fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&#039;Nacionalidades&#039;); ?&gt;
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/properties/nacionalidades.php&quot; &lt;?php if(preg_match(&#039;/\/nacionalidades/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-flag fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&#039;Nacionalidades&#039;); ?&gt;
&lt;/a&gt;

&lt;div class=&quot;hor-divider&quot;&gt;&lt;/div&gt;

&lt;a href=&quot;/intramedianet/templates/news.php&quot; &lt;?php if(preg_match(&#039;/\/templates\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-file-text-o fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&#039;Plantillas correo&#039;); ?&gt;
&lt;/a&gt;
            </code>
        </pre>
        <hr>
        Subir la carpeta:
        <pre>
            <code class="makefile">
/intramedianet/templates/
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Plantillas correo&#039;] = &#039;Plantillas correo&#039;;
$lang[&#039;Inserte {{PROPERTY}} para mostrar las propiedad o propiedades&#039;] = &#039;Inserte {{PROPERTY}} para mostrar las propiedad o propiedades&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Plantillas correo&#039;] = &#039;Mail templates&#039;;
$lang[&#039;Inserte {{PROPERTY}} para mostrar las propiedad o propiedades&#039;] = &#039;Insert {{PROPERTY}} to show property(ies)&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Quitar cannonical en ficha inmueble
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/header.tpl:95
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $addDefaultURLCanonical == 1}
    &lt;link rel=&quot;canonical&quot; href=&quot;{if preg_match(&#039;/https?/&#039;,{$url{$lang|upper}}) }{$url{$lang|upper}|replace:&#039;http://&#039;:&#039;https://&#039;}{else}https://{$smarty.server.HTTP_HOST}{$url{$lang|upper}}{/if}&quot; /&gt;
{else }
    {if $seccion == &#039;&#039;}
        &lt;link rel=&quot;canonical&quot; href=&quot;https://{$smarty.server.HTTP_HOST}{$urlStart}{$seccion}&quot; /&gt;
    {else}
        &lt;link rel=&quot;canonical&quot; href=&quot;https://{$smarty.server.HTTP_HOST}{$urlStart}{$seccion}/&quot; /&gt;
    {/if}
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $seccion != $url_property}
    {if $addDefaultURLCanonical == 1}
        &lt;link rel=&quot;canonical&quot; href=&quot;{if preg_match(&#039;/https?/&#039;,{$url{$lang|upper}}) }{$url{$lang|upper}|replace:&#039;http://&#039;:&#039;https://&#039;}{else}https://{$smarty.server.HTTP_HOST}{$url{$lang|upper}}{/if}&quot; /&gt;
    {else }
        {if $seccion == &#039;&#039;}
            &lt;link rel=&quot;canonical&quot; href=&quot;https://{$smarty.server.HTTP_HOST}{$urlStart}{$seccion}&quot; /&gt;
        {else}
            &lt;link rel=&quot;canonical&quot; href=&quot;https://{$smarty.server.HTTP_HOST}{$urlStart}{$seccion}/&quot; /&gt;
        {/if}
    {/if}
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Convertir a propietario en consultas de la web
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/report-consultas-search.js:33
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var convertClientText = ConvertClient;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var convertClientText = ConvertClient;
var convertPropietarioText = ConvertPropietario;
var dataSplit = data.split(&#039;,&#039;);
var idBajClient = dataSplit[0];
var nameBajClient = full[0];
var langBajClient = full[7];
var phoneBajClient = full[2];
var dateBajClient = full[5];
var mailBajClient = full[1];
var notaBajClient = $(full[3]).text();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/report-consultas-search.js:50
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns  = &#039;&lt;a href=&quot;/intramedianet/properties/add_client_from_consulta.php?c=&#039; + idBajClient + &#039;&quot; target=&quot;_blank&quot; class=&quot;btn &#039;+ colorBtn +&#039; btn-sm btn-block&quot;&gt;&#039;+convertClientText+&#039;&lt;/a&gt; &#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns = &#039;&lt;a href=&quot;/intramedianet/properties/add_client_from_consulta.php?c=&#039; + idBajClient + &#039;&quot; target=&quot;_blank&quot; class=&quot;btn &#039; + colorBtn + &#039; btn-sm btn-block&quot;&gt;&#039; + convertClientText + &#039;&lt;/a&gt; &lt;a href=&quot;#&quot; target=&quot;_blank&quot; class=&quot;btn &#039; + colorBtn + &#039; btn-sm btn-block btn-modal-convertir-propietario&quot; data-client-id=&quot;&#039; + idBajClient + &#039;&quot; data-client-name=&quot;&#039; + nameBajClient + &#039;&quot; data-client-lang=&quot;&#039; + langBajClient + &#039;&quot; data-client-mail=&quot;&#039; + mailBajClient + &#039;&quot; data-client-phone=&quot;&#039; + phoneBajClient + &#039;&quot; data-client-nota=\&#039;&#039; + notaBajClient + &#039;\&#039; data-client-date=&quot;&#039; + dateBajClient + &#039;&quot;&gt;&#039; + convertPropietarioText + &#039;&lt;/a&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/report-consultas-search.js
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$(document).on(&#039;click&#039;, &#039;.btn-modal-convertir-propietario&#039;, function (e) {
    e.preventDefault();
    tb = $(this);
    $(&#039;#myModal .btn-convertir-cliente&#039;).attr(&#039;href&#039;, &quot;/intramedianet/properties/add_client_from_consulta.php?c=&quot; + tb.attr(&quot;data-client-id&quot;))
    $(&#039;#myModal #nombre_pro&#039;).val(tb.attr(&quot;data-client-name&quot;));
    $(&#039;#myModal #idioma_pro option[value=&quot;&#039; + tb.attr(&quot;data-client-lang&quot;) + &#039;&quot;]&#039;).attr(&#039;selected&#039;, &#039;selected&#039;);
    $(&#039;#myModal #telefono_fijo_pro&#039;).val(tb.attr(&quot;data-client-phone&quot;));

    var notaDate = tb.attr(&quot;data-client-date&quot;);
    $(&#039;#myModal #historial_pro&#039;).val(&quot;[ &quot; + notaDate + &quot; ] [ &quot; + tb.attr(&quot;data-client-name&quot;) + &quot; ] &rarr; &quot; + tb.attr(&quot;data-client-nota&quot;) + &quot; \n\n&quot; + $(&#039;#historial_pro&#039;).val());

    $(&#039;#myModal&#039;).modal();
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/consultas.php
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal&quot; class=&quot;modal fade&quot;&gt;
    &lt;div class=&quot;modal-dialog&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header&quot;&gt;
                &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot;&gt;&times;&lt;/button&gt;
                &lt;h4&gt;&lt;?php __(&#039;Convertir a propietario&#039;); ?&gt;&lt;/h4&gt;
            &lt;/div&gt;
            &lt;form id=&quot;formOwn&quot; action=&quot;/intramedianet/properties/owners-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
                &lt;div class=&quot;modal-body&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;nombre_pro&quot; id=&quot;nameprom&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;idioma_pro&quot;&gt;&lt;?php __(&#039;Idioma&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;idioma_pro&quot; id=&quot;idioma_pro&quot; class=&quot;form-control required&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            if ($lang_adm == &#039;es&#039;) {
                                $idiomas = array(&#039;ca&#039; =&gt; &#039;Catal&aacute;n&#039;, &#039;da&#039; =&gt; &#039;Dan&eacute;s&#039;, &#039;de&#039; =&gt; &#039;Alem&aacute;n&#039;, &#039;el&#039; =&gt; &#039;Griego&#039;, &#039;en&#039; =&gt; &#039;Ingl&eacute;s&#039;, &#039;es&#039; =&gt; &#039;Espa&ntilde;ol&#039;, &#039;fi&#039; =&gt; &#039;Finland&eacute;s&#039;, &#039;fr&#039; =&gt; &#039;Franc&eacute;s&#039;, &#039;is&#039; =&gt; &#039;Island&eacute;s&#039;, &#039;it&#039; =&gt; &#039;Italiano&#039;, &#039;nl&#039; =&gt; &#039;Holand&eacute;s&#039;, &#039;no&#039; =&gt; &#039;Noruego&#039;, &#039;pt&#039; =&gt; &#039;Portugu&eacute;s&#039;, &#039;ru&#039; =&gt; &#039;Ruso&#039;, &#039;se&#039; =&gt; &#039;Sueco&#039;, &#039;zh&#039; =&gt; &#039;Chino&#039;, &#039;pl&#039; =&gt; &#039;Polaco&#039;);
                            } else {
                                $idiomas = array(&#039;ca&#039; =&gt; &#039;Catalan&#039;, &#039;da&#039; =&gt; &#039;Danish&#039;, &#039;de&#039; =&gt; &#039;German&#039;, &#039;el&#039; =&gt; &#039;Greek&#039;, &#039;en&#039; =&gt; &#039;English&#039;, &#039;es&#039; =&gt; &#039;Spanish&#039;, &#039;fi&#039; =&gt; &#039;Finnish&#039;, &#039;fr&#039; =&gt; &#039;French&#039;, &#039;is&#039; =&gt; &#039;Icelandic&#039;, &#039;it&#039; =&gt; &#039;Italian&#039;, &#039;nl&#039; =&gt; &#039;Dutch&#039;, &#039;no&#039; =&gt; &#039;Norwegian&#039;, &#039;pt&#039; =&gt; &#039;Portuguese&#039;, &#039;ru&#039; =&gt; &#039;Russian&#039;, &#039;se&#039; =&gt; &#039;Swedish&#039;, &#039;zh&#039; =&gt; &#039;Chinese&#039;, &#039;pl&#039; =&gt; &#039;Polish&#039;);
                            }
                            foreach ($languages as $value) {
                                echo &#039;&lt;option value=&quot;&#039; . $value . &#039;&quot;&gt;&#039; . $idiomas[$value] . &#039;&lt;/option&gt;&#039;;
                            }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;type_pro&quot;&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;type_pro&quot; id=&quot;type_pro&quot; class=&quot;form-control required&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;option value=&quot;1&quot;&lt;?php if (!(strcmp(1, $row_rsproperties_owner[&#039;type_pro&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php __(&#039;Particular&#039;); ?&gt;&lt;/option&gt;
                            &lt;option value=&quot;2&quot;&lt;?php if (!(strcmp(2, $row_rsproperties_owner[&#039;type_pro&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php __(&#039;Constructor&#039;); ?&gt;&lt;/option&gt;
                            &lt;option value=&quot;3&quot;&lt;?php if (!(strcmp(3, $row_rsproperties_owner[&#039;type_pro&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php __(&#039;Banco&#039;); ?&gt;&lt;/option&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;input type=&quot;hidden&quot; name=&quot;telefono_fijo_pro&quot; id=&quot;telefono_fijo_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;telefono_fijo_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;input type=&quot;hidden&quot; name=&quot;email_pro&quot; id=&quot;email_pro&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;email_pro&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;textarea type=&quot;text&quot; name=&quot;historial_pro&quot; id=&quot;historial_pro&quot; cols=&quot;50&quot; rows=&quot;20&quot; class=&quot;form-control&quot; style=&quot;display: none&quot;&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_owner[&#039;historial_pro&#039;]); ?&gt;&lt;/textarea&gt;
                &lt;/div&gt;
                &lt;div class=&quot;modal-footer&quot;&gt;
                    &lt;button type=&quot;button&quot; class=&quot;btn btn-default&quot; data-dismiss=&quot;modal&quot;&gt;&lt;?php __(&#039;Cerrar&#039;); ?&gt;&lt;/button&gt;
                    &lt;input type=&quot;hidden&quot; name=&quot;fecha_alta_pro&quot; id=&quot;fecha_alta_pro&quot; value=&quot;&lt;?php echo date(&quot;d-m-Y H:i:s&quot;) ?&gt;&quot;&gt;
                    &lt;input type=&quot;submit&quot; name=&quot;KT_Insert2&quot; value=&quot;&lt;?php echo NXT_getResource(&quot;Insert_FB&quot;); ?&gt;&quot; class=&quot;btn btn-success&quot; /&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        Sobreescribir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/consultas-data.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.js
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
var ConvertPropietario = &#039;Convertir a propietario&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.js
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
var ConvertPropietario = &#039;Convert to vendor&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Vendor: añadir campo "Partner Portal / Dropbox"
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:837
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;label for=&quot;skype_pro&quot;&gt;&lt;?php __(&#039;Skype&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;label for=&quot;skype_pro&quot;&gt;&lt;?php __(&#039;Partner Portal / Dropbox&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-search.php:397
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;label for=&quot;skype_pro&quot;&gt;&lt;?php __(&#039;Skype&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;label for=&quot;skype_pro&quot;&gt;&lt;?php __(&#039;Partner Portal / Dropbox&#039;); ?&gt;:&lt;/label&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Partner Portal / Dropbox&#039;] = &#039;Portal de socios / Dropbox&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Partner Portal / Dropbox&#039;] = &#039;Partner Portal / Dropbox&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Propiedades / Datos privados: añadir campo "Dropbox link"
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `dropbox_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `emisiones_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:928
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;zoom_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gpp_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;zoom_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gpp_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;dropbox_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;dropbox_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1155
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;zoom_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gpp_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;zoom_gpp_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;zoom_gpp_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;dropbox_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;dropbox_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3485
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-12&quot;&gt;

 &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
     &lt;label for=&quot;direccion_prop&quot;&gt;&lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
     &lt;input type=&quot;text&quot; name=&quot;direccion_prop&quot; id=&quot;direccion_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;direccion_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
     &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_prop&quot;); ?&gt;
 &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-12&quot;&gt;

     &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
         &lt;label for=&quot;direccion_prop&quot;&gt;&lt;?php __(&#039;Direcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
         &lt;input type=&quot;text&quot; name=&quot;direccion_prop&quot; id=&quot;direccion_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;direccion_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
         &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;direccion_prop&quot;); ?&gt;
     &lt;/div&gt;

 &lt;/div&gt;
&lt;div class=&quot;col-md-12&quot;&gt;

 &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;dropbox_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
     &lt;label for=&quot;dropbox_prop&quot;&gt;&lt;?php __(&#039;Dropbox&#039;); ?&gt;:&lt;/label&gt;
     &lt;input type=&quot;text&quot; name=&quot;dropbox_prop&quot; id=&quot;dropbox_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;dropbox_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
     &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;dropbox_prop&quot;); ?&gt;
 &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Dropbox&#039;] = &#039;Dropbox&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Dropbox&#039;] = &#039;Dropbox&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Propiedades / General - añadir campos  "fecha de entrega" - "delivery date"
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `entraga_date_prop` DATE NULL DEFAULT NULL AFTER `dropbox_prop`;

            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:873
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;nuevo_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;nuevo_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;nuevo_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;nuevo_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;entraga_date_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;entraga_date_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1102
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;nuevo_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;nuevo_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;nuevo_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;nuevo_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;entraga_date_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;entraga_date_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1784
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;construccion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;construccion_prop&quot;&gt;&lt;?php __(&#039;A&ntilde;o de construcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;construccion_prop&quot; id=&quot;construccion_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;construccion_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;construccion_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;construccion_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;construccion_prop&quot;&gt;&lt;?php __(&#039;A&ntilde;o de construcci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;construccion_prop&quot; id=&quot;construccion_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;construccion_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;construccion_prop&quot;); ?&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;
    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;entraga_date_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;entraga_date_prop&quot;&gt;&lt;?php __(&#039;Fecha de entrega&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;entraga_date_prop&quot; id=&quot;entraga_date_prop&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsproperties_properties[&#039;entraga_date_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepick&quot;&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;entraga_date_prop&quot;); ?&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Fecha de entrega&#039;] = &#039;Fecha de entrega&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Fecha de entrega&#039;] = &#039;Delivery date&#039;;
            </code>
        </pre>
        <hr>
        Añadir a los archivos de idiomas de la carpeta /resources/, en el master están todos los idiomas:
        <pre>
            <code class="makefile">
$langStr[&#039;Fecha de entrega&#039;] = &#039;Delivery date&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/property.php:110
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
precio_12_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
precio_12_prop,
entraga_date_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tab-caracteristicas.tpl:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $property[0].construccion_prop != &#039;&#039;}
    &lt;div class=&quot;col-12 col-sm-6 mb-2&quot;&gt;&lt;i class=&quot;fas fa-check&quot;&gt;&lt;/i&gt; &lt;strong&gt;{$lng_ano_de_construccion}:&lt;/strong&gt; {$property[0].construccion_prop}&lt;/div&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $property[0].construccion_prop != &#039;&#039;}
    &lt;div class=&quot;col-12 col-sm-6 mb-2&quot;&gt;&lt;i class=&quot;fas fa-check&quot;&gt;&lt;/i&gt; &lt;strong&gt;{$lng_ano_de_construccion}:&lt;/strong&gt; {$property[0].construccion_prop}&lt;/div&gt;
{/if}

{if $property[0].entraga_date_prop != &#039;&#039;}
    &lt;div class=&quot;col-12 col-sm-6 mb-2&quot;&gt;&lt;i class=&quot;fas fa-check&quot;&gt;&lt;/i&gt; &lt;strong&gt;{$lng_fecha_de_entrega}:&lt;/strong&gt; {$property[0].entraga_date_prop}&lt;/div&gt;
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Importador resales-online
    </h6>
    <div class="card-body">
        Subir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_resales.php
/intramedianet/xml/importadores/Resales.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/import-cron.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case 3:
    $tipo = &quot;Inmovilla&quot;;
break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case 3:
    $tipo = &quot;Inmovilla&quot;;
break;
case 5:
    $tipo = &quot;Resales&quot;;
break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/delete.php:25
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case 1:
    return &quot;Kyero&quot;;
    break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case 1:
    return &quot;Kyero&quot;;
break;
case 2:
    return &quot;Mediaelx&quot;;
break;
case 3:
    return &quot;Inmovilla&quot;;
break;
case 5:
    return &quot;Resales&quot;;
break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importar.php:22
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case 1:
    return &quot;Kyero&quot;;
    break;
case 2:
    return &quot;Mediaelx&quot;;
    break;
case 3:
    return &quot;Inmovilla&quot;;
    break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case 1:
    return &quot;Kyero&quot;;
break;
case 2:
    return &quot;Mediaelx&quot;;
break;
case 3:
    return &quot;Inmovilla&quot;;
break;
case 5:
    return &quot;Resales&quot;;
break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores-data.php:253
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case 3:
  $row[] = &quot;Inmovilla&quot;;
break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case 3:
  $row[] = &quot;Inmovilla&quot;;
break;
case 5:
  $row[] = &quot;Resales-online&quot;;
break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores.php:77
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;option value=&quot;3&quot;&gt;Inmovilla&lt;/option&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;option value=&quot;3&quot;&gt;Inmovilla&lt;/option&gt;
&lt;option value=&quot;5&quot;&gt;Resales-online&lt;/option&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/proveedores-form.php:274
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;option value=&quot;3&quot; &lt;?php if (!(strcmp(3, $row_rsxml[&#039;tipo_xml&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;Inmovilla&lt;/option&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;option value=&quot;3&quot; &lt;?php if (!(strcmp(3, $row_rsxml[&#039;tipo_xml&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;Inmovilla&lt;/option&gt;
&lt;option value=&quot;5&quot; &lt;?php if (!(strcmp(5, $row_rsxml[&#039;tipo_xml&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;Resales-online&lt;/option&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Acceso CRM: actualizar logo a digital agency, cambiar banner de grupo Facebook al de acceso MLS
    </h6>
    <div class="card-body">
        Sustituir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/feed.php
/intramedianet/forgot_password.php
/intramedianet/index.php
/intramedianet/logout.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
