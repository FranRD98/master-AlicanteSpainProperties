<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 06-05-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Rediseño funcionamiento y diseño de la sección search criteria y rating emails</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> No se muestra el reporte propietario</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Promociones de Habihub</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Recordar contraseña</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> En el archivo de la nota legal</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Descripción propia y descripción para XML</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-bug text-danger"></i> Error al filtrar por categorías de noticias</a></li>
        <li><a href="#sec8"><i class="fas fz-fw fa-bug text-danger"></i> No se pueden crear usuarios de forma manual en una lista vacía de acumba</a></li>
        <li><a href="#sec9"><i class="fas fz-fw fa-bug text-danger"></i> No se pueden añadir citas al calendario en el dashboard</a></li>
        <li><a href="#sec10"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadida frase en la gestión de banner para explicar el funcionamiento</a></li>
        <li><a href="#sec11"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadir calendario por usuarios a añadir a tu programa de correo</a></li>
        <li><a href="#sec12"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido enlaces del calendario del usuario en el formulario de edición de inmuebles</a></li>
        <li><a href="#sec13"><i class="fas fz-fw fa-bug text-danger"></i> Ajuste resumen y descripción exportador Fotocasa</a></li>
        <li><a href="#sec14"><i class="fas fz-fw fa-bug text-danger"></i> Se mezclan los mapas de zonas y ciudades</a></li>
        <li><a href="#sec15"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido CCO a compradores y vendedores</a></li>
        <li><a href="#sec16"><i class="fas fz-fw fa-bug text-danger"></i> El xml de APITS no mestra si es un inmueble de obra nueva</a></li>
        <li><a href="#sec17"><i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras seguimiento emails y newsletter de acumbamail</a></li>
        <li><a href="#sec18"><i class="fas fz-fw fa-bug text-danger"></i> Error al generar urls para inmuebles con metas con emojis</a></li>
        <li><a href="#sec19"><i class="fas fz-fw fa-bug text-danger"></i> Solución scroll lateral en windows</a></li>
        <li><a href="#sec20"><i class="fas fz-fw fa-bug text-danger"></i> Eliminar inmuebles exportados a rightmove al dejar de venir en los xmls</a></li>
        <li><a href="#sec21"><i class="fas fz-fw fa-plus-circle text-success"></i> Template semanal autogestionable</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Rediseño funcionamiento y diseño de la sección search criteria y rating emails
    </h6>
    <div class="card-body">
        Al ser tan complejo no hay tutorial de como actualizarlo.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> No se muestra el reporte propietario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/reporte/reporte.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$pages = getRecords(&quot;

    SELECT news.id_nws,
        news.title_&quot;.$lang.&quot;_nws as titulo,
        news.content_&quot;.$lang.&quot;_nws as contenido,
        news.titlew_&quot;.$lang.&quot;_nws as titulow,
        news.description_&quot;.$lang.&quot;_nws as contenidow,
        news.keywords_&quot;.$lang.&quot;_nws as keywords,
        news.date_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img

    FROM news

    WHERE  type_nws = 2

    AND id_nws = &#039;&quot;.simpleSanitize(($numpag)).&quot;&#039;

    ORDER BY news.date_nws DESC

    LIMIT 1
&quot;);


if ($pages[0][&#039;titulow&#039;] != &#039;&#039;) {
    $title = $pages[0][&#039;titulow&#039;];
} else {
    $title = $pages[0][&#039;titulo&#039;];
}

if ($title == &#039;&#039;) {
    $title = $metaTitleDefault;
}


$smarty-&gt;assign(&quot;metaTitle&quot;, trim(strip_tags($title)));

if ($pages[0][&#039;contenidow&#039;] != &#039;&#039;) {
    $description = $pages[0][&#039;contenidow&#039;];
} else {
    $description = $pages[0][&#039;contenido&#039;];
}

if ($description == &#039;&#039;) {
    $description = $metaDescriptionDefault;
}

$smarty-&gt;assign(&quot;metaDescription&quot;, trim(strip_tags($description)));

$smarty-&gt;assign(&quot;metaKeywords&quot;, trim(strip_tags($pages[0][&#039;keywords&#039;])));

$url = &#039;http://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . $_SERVER[&#039;REQUEST_URI&#039;];

$smarty-&gt;assign(&quot;metaURL&quot;, $url);

$img = &#039;http://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/website/no-image.png&#039;;

$smarty-&gt;assign(&quot;metaImage&quot;, $img);


$images = getRecords(&quot;

    SELECT imagen_img as image_img, alt_&quot;.$lang.&quot;_img as alt FROM news_fotos WHERE noticia_img = &#039;&quot;.simpleSanitize(($numpag)).&quot;&#039; ORDER BY orden_img

&quot;);

$smarty-&gt;assign(&quot;images&quot;, $images);

$matches = array();

preg_match_all(&#039;/{image-left}|{image-right}|{image-pan}/&#039;, (string)$pages[0][&#039;contenido&#039;], $matches);

$text = (string)$pages[0][&#039;contenido&#039;];

if (count($matches[0] &gt; 0)) {
    for ($i=0; $i &lt; count($matches[0]); $i++) {

        switch ($matches[0][$i]) {
            case &#039;{image-right}&#039;:
                $img = showThumbnail($images[($i)][&#039;image_img&#039;], &#039;/media/images/news/&#039;, 350, 200, $images[($i)][&#039;alt&#039;], &#039;img-right&#039;);
                break;
            case &#039;{image-pan}&#039;:
                $img = showThumbnail($images[($i)][&#039;image_img&#039;], &#039;/media/images/news/&#039;, 930, 200, $images[($i)][&#039;alt&#039;], &#039;img-pan&#039;);
                break;

            default:
                $img = showThumbnail($images[($i)][&#039;image_img&#039;], &#039;/media/images/news/&#039;, 350, 200, $images[($i)][&#039;alt&#039;], &#039;img-left&#039;);
                break;
        }

        $text = preg_replace(&#039;/&#039;.$matches[0][$i].&#039;/&#039;, $img, $text, 1);

    }
}

$smarty-&gt;assign(&quot;pagetext&quot;, $text);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$pages = getRecords(&quot;

    SELECT news.id_nws,
        news.title_&quot;.$lang.&quot;_nws as titulo,
        news.content_&quot;.$lang.&quot;_nws as contenido,
        news.titlew_&quot;.$lang.&quot;_nws as titulow,
        news.description_&quot;.$lang.&quot;_nws as contenidow,
        news.keywords_&quot;.$lang.&quot;_nws as keywords,
        news.date_nws,
    (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img

    FROM news

    WHERE  type_nws = 2

    AND id_nws IN (&quot;.simpleSanitize(($numpag)).&quot;)

    ORDER BY news.id_nws ASC
&quot;);


if (isset($pages[0][&#039;titulow&#039;]) &amp;&amp; $pages[0][&#039;titulow&#039;] != &#039;&#039;) {
    $title = $pages[0][&#039;titulow&#039;];
} else {
    if(isset($pages[0][&#039;titulo&#039;]))
        $title = $pages[0][&#039;titulo&#039;];
}

if (!isset($title) || $title == &#039;&#039;) {
    $title = $metaTitleDefault[&#039;es&#039;];
}


$title = trim(strip_tags($title));

$smarty-&gt;assign(&quot;metaTitle&quot;, $title);

if (isset($pages[0][&#039;contenidow&#039;]) &amp;&amp; $pages[0][&#039;contenidow&#039;] != &#039;&#039;) {
    $description = $pages[0][&#039;contenidow&#039;];
} else {
    if(isset($pages[0][&#039;contenido&#039;]))
        $description = $pages[0][&#039;contenido&#039;];
}

if (!isset($description) || $description == &#039;&#039;) {
    $description = $metaDescriptionDefault[&#039;es&#039;];
}
$description = trim(strip_tags($description));
$smarty-&gt;assign(&quot;metaDescription&quot;, $description);

if(isset($pages[0][&#039;keywords&#039;]))
    $smarty-&gt;assign(&quot;metaKeywords&quot;, trim(strip_tags($pages[0][&#039;keywords&#039;])));

$url = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;&#039; . $_SERVER[&#039;REQUEST_URI&#039;];

$smarty-&gt;assign(&quot;metaURL&quot;, $url);
if(isset($pages[0][&#039;img&#039;])){
    if (preg_match(&#039;/https?:\/\//&#039;, $pages[0][&#039;img&#039;])) {
        $img = $pages[0][&#039;img&#039;];
    } else {
        $img = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/news/&#039; . $pages[0][&#039;img&#039;];
    }
}

if (!isset($img) || $img == &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/news/&#039;) {
    $img = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/website/no-image.png&#039;;
}

$smarty-&gt;assign(&quot;metaImage&quot;, $img);

foreach ($pages as $key =&gt; $page) {
    $text = &quot;&quot;;
    $images = &quot;&quot;;
    $videos = &quot;&quot;;

    $images = getRecords(&quot;
        SELECT imagen_img as image_img, alt_&quot;.$lang.&quot;_img as alt FROM news_fotos WHERE noticia_img = &#039;&quot;.$page[&quot;id_nws&quot;].&quot;&#039; ORDER BY orden_img
    &quot;);

    $videos = getRecords(&quot;
        SELECT video_vid FROM news_videos WHERE news_vid = &#039;&quot;.$page[&quot;id_nws&quot;].&quot;&#039; ORDER BY order_vid
    &quot;);
    $matches = array();

    preg_match_all(&#039;/{image}|{image-left}|{image-right}|{image-pan}/&#039;, (string)$page[&#039;contenido&#039;], $matches);

    $text = (string)$page[&#039;contenido&#039;];


    if(!empty($matches[0])){
        if (count($matches[0]) &gt; 0) {
            for ($i=0; $i &lt; count($matches[0]); $i++) {

                switch ($matches[0][$i]) {
                    case &#039;{image-right}&#039;:
                        $img = showThumbnail($images[($i)][&#039;image_img&#039;], &#039;/media/images/news/&#039;, 350, 200, $page[&#039;titulo&#039;], &#039;img-right&#039;);
                    break;

                    case &#039;{image-pan}&#039;:
                        $img = showThumbnail($images[($i)][&#039;image_img&#039;], &#039;/media/images/news/&#039;, 1170, 350, $page[&#039;titulo&#039;], &#039;img-pan&#039;);
                    break;

                    case &#039;{image-left}&#039;:
                        $img = showThumbnail($images[($i)][&#039;image_img&#039;], &#039;/media/images/news/&#039;, 350, 200, $page[&#039;titulo&#039;], &#039;img-left&#039;);
                    break;

                    default:
                        $img = &#039;&lt;img src=&quot;/media/images/news/&#039;.$images[($i)][&quot;image_img&quot;].&#039;&quot; class=&quot;img-auto&quot; alt=&quot;&#039;.$images[($i)][&quot;alt&quot;].&#039;&quot; /&gt;&#039;;
                    break;
                }

                $text = preg_replace(&#039;/&#039;.$matches[0][$i].&#039;/&#039;, $img, $text, 1);
            }
        }
    }

    $text = str_replace(&#039;table table-striped table-bordered&#039;, &#039;cms-table&#039;, $text);

    if($key == 0){
        $smarty-&gt;assign(&quot;images&quot;, $images);
        $smarty-&gt;assign(&quot;videos&quot;, $videos);
        $smarty-&gt;assign(&quot;pagetext&quot;, $text);
    } else {
        $pages[$key][&#039;images&#039;] = $images;
        $pages[$key][&#039;videos&#039;] = $videos;
        $pages[$key][&#039;contenido&#039;] = $text;
    }
}

$smarty-&gt;assign(&quot;pages&quot;, $pages);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/reporte/reporte.php:447
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;favstot&quot;, $otros);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;otros&quot;, $otros);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/reporte/view/index.tpl:189
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{section name=h loop=$favstot}
&lt;tr&gt;
    &lt;td&gt;{$favstot[h].inicio_ct|date_format:&quot;%d-%m-%Y %H:%M&quot;}&lt;/td&gt;
    &lt;td&gt;{$favstot[h].nombre_usr}&lt;/td&gt;
    &lt;td&gt;#{$favstot[h].id_cli}&lt;/td&gt;
    &lt;td&gt;&lt;span class=&quot;label label-default&quot;&gt;{$favstot[h].cat}&lt;/span&gt;&lt;/td&gt;
&lt;/tr&gt;
{/section}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{section name=h loop=$otros}
&lt;tr&gt;
    &lt;td&gt;{$otros[h].inicio_ct|date_format:&quot;%d-%m-%Y %H:%M&quot;}&lt;/td&gt;
    &lt;td&gt;{$otros[h].nombre_usr}&lt;/td&gt;
    &lt;td&gt;#{$otros[h].id_cli}&lt;/td&gt;
    &lt;td&gt;&lt;span class=&quot;label label-default&quot;&gt;{$otros[h].cat}&lt;/span&gt;&lt;/td&gt;
&lt;/tr&gt;
{/section}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Promociones de Habihub
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php:135
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsPromotion = &quot;SELECT id_nws FROM news WHERE  LOWER(title_&quot; . $language . &quot;_nws) = &#039;&quot; . strtolower($promotion) . &quot;&#039; AND type_nws = 999&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsPromotion = &quot;SELECT id_nws FROM news WHERE  LOWER(title_en_nws) = &#039;&quot; . mysqli_real_escape_string($inmoconn, strtolower($promotion)) . &quot;&#039; AND type_nws = 999&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Recordar contraseña
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/forgot_password.php:15
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/tng/tNG.inc.php&#039; );
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/tng/tNG.inc.php&#039; );

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mediaelx/functions.php&#039;);
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/forgot_password.php:43
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//start Trigger_ForgotPassword_Email trigger
//remove this line if you want to edit the code by hand
function Trigger_ForgotPassword_Email(&amp;$tNG) {

  global $fromMail, $lang_adm;

  $emailObj = new tNG_Email($tNG);
  $emailObj-&gt;setFrom($fromMail);
  $emailObj-&gt;setTo(&quot;{email_usr}&quot;);
  $emailObj-&gt;setCC(&quot;&quot;);
  $emailObj-&gt;setBCC(&quot;&quot;);
  $emailObj-&gt;setSubject(strtolower($_SERVER[&#039;HTTP_HOST&#039;]) . &quot; | &quot; . __(&quot;Tus nuevos datos de acceso&quot;, true));
  //FromFile method
  $emailObj-&gt;setContentFile(&quot;../includes/mailtemplates/forgot_&quot; . $lang_adm . &quot;.html&quot;);
  $emailObj-&gt;setEncoding(&quot;UTF-8&quot;);
  $emailObj-&gt;setFormat(&quot;HTML/Text&quot;);
  $emailObj-&gt;setImportance(&quot;High&quot;);
  return $emailObj-&gt;Execute();
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//start Trigger_ForgotPassword_Email trigger
//remove this line if you want to edit the code by hand
function Trigger_ForgotPassword_Email(&amp;$tNG) {
    global $fromMail, $lang_adm;
    $email_usr = $tNG-&gt;getColumnValue(&quot;email_usr&quot;);
    $pass = $tNG-&gt;getColumnValue(&quot;kt_login_password&quot;);
    $nameTemplate = &quot;forgot_&quot; . $lang_adm . &quot;.html&quot;;
    $link=&quot;https://&quot; . $_SERVER[&#039;HTTP_HOST&#039;] . &quot;/intramedianet/index.php&quot;;
    $html = getBodyNewUser($nameTemplate,$email_usr,$pass,$link);

    // $name_usr = $tNG-&gt;getColumnValue(&quot;nombre_usr&quot;);
    $subject = strtolower($_SERVER[&#039;HTTP_HOST&#039;]) . &quot; | &quot; . __(&quot;Tus nuevos datos de acceso&quot;, true);

    if (sendAppEmail(array($email_usr =&gt; $name_usr), &#039;&#039;, &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
        return true;
    } else {
        return false;
    }
}
//end Trigger_ForgotPassword_Email trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/forgot_password.php:73
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$forgotpass_transaction-&gt;registerTrigger(&quot;END&quot;, &quot;Trigger_Default_Redirect&quot;, 99, &quot;{kt_login_redirect}&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$forgotpass_transaction-&gt;registerTrigger(&quot;END&quot;, &quot;Trigger_Default_Redirect&quot;, 99, &quot;../../intramedianet/?info=FORGOT&quot;);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> En el archivo de la nota legal
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/templates/nota_legal.txt:1
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;p&gt;En cumplimiento del art&iacute;culo 10 de la Ley 34 / 2002, de 11 de julio, de Servicios de la Sociedad de la Informaci&oacute;n y Comercio Electr&oacute;nico, el Titular, &lt;b&gt;@@Denominaci&oacute;n Social||Mediaelx Web Design S.L.L.@@&lt;/b&gt; con NIF: &lt;b&gt;@@CIF / NIF||B00000000@@&lt;/b&gt; domicilio en &lt;b&gt;@@Domicilio Social||Av. Vicente Blasco Ib&aacute;&ntilde;ez, 58, de Elche, Alicante@@&lt;/b&gt;, tel&eacute;fono &lt;p&gt;@@Tel&eacute;fono||600000000@@&lt;/p&gt; y con email: &lt;b&gt;@@Email de la empresa||info@mediaelx.net@@&lt;/b&gt; expone los siguientes datos registrales:&lt;/p&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;p&gt;En cumplimiento del art&iacute;culo 10 de la Ley 34 / 2002, de 11 de julio, de Servicios de la Sociedad de la Informaci&oacute;n y Comercio Electr&oacute;nico, el Titular, &lt;b&gt;@@Denominaci&oacute;n Social||Mediaelx Web Design S.L.L.@@&lt;/b&gt; con NIF: &lt;b&gt;@@CIF / NIF||B00000000@@&lt;/b&gt; domicilio en &lt;b&gt;@@Domicilio Social||Av. Vicente Blasco Ib&aacute;&ntilde;ez, 58, de Elche, Alicante@@&lt;/b&gt;, tel&eacute;fono &lt;b&gt;@@Tel&eacute;fono||600000000@@&lt;/b&gt; y con email: &lt;b&gt;@@Email de la empresa||info@mediaelx.net@@&lt;/b&gt; expone los siguientes datos registrales:&lt;/p&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/gdpr.php:2
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
ini_set(&#039;display_errors&#039;, 0);
error_reporting(E_ALL);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
ini_set(&#039;display_errors&#039;, 0);
error_reporting(E_ALL);

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/idiomas.php&#039;);
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/inmoconn.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/gdpr.php
            </code>
        </pre>
        Añadir al final del archivo:
        <pre>
            <code class="php">
&lt;?php
if ($_SERVER[&#039;REQUEST_METHOD&#039;] === &#039;POST&#039;) {


    if ($_GET[&#039;doc&#039;] != &#039;&#039; &amp;&amp; file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates/&#039; . $_GET[&#039;doc&#039;])) {
        $doc_text_final = file_get_contents($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates/&#039; . $_GET[&#039;doc&#039;]);
        $doc_text_final = htmlentities($doc_text_final);
        $campos = getContents($doc_text_final, &#039;@@&#039;, &#039;@@&#039;);


        foreach (array_unique($campos) as $campo) {
            $parts = explode(&#039;||&#039;, $campo);


            $value = $_POST[clean($parts[0] . &#039;-txt&#039;)];
            $doc_text_final = str_replace(&#039;@@&#039; . $campo . &#039;@@&#039;, $value, $doc_text_final);
        }


        $doc_text_final = html_entity_decode($doc_text_final);


        if ($_GET[&#039;doc&#039;] == &#039;texto correos.txt&#039;) {
            $templates = [
                $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mailtemplates/template_acumba.html&#039;,
                $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mailtemplates/template_semanal.html&#039;,
                $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mailtemplates/template.html&#039;
            ];


            foreach ($templates as $templatePath) {
              if (file_exists($templatePath)) {
                    $templateContent = file_get_contents($templatePath);
                    $updatedContent = str_replace(&#039;{AVISOLEGAL}&#039;, $doc_text_final, $templateContent);
                    file_put_contents($templatePath, $updatedContent);
                }
            }
        } else {


            $selected_document = $_GET[&#039;doc&#039;];
            $document_ids = [
                &#039;nota_legal.txt&#039; =&gt; 10,
                &#039;politica_privacidad.txt&#039; =&gt; 12,
                &#039;politica_cookies.txt&#039; =&gt; 18
            ];


            if (array_key_exists($selected_document, $document_ids)) {
                $escaped_text = mysqli_real_escape_string($inmoconn, $doc_text_final);
                $content_lang_nws = &quot;&quot;;
                foreach ($languages as $lang) {
                    $content_lang_nws .= &quot;content_&quot; . $lang . &quot;_nws = &#039;$escaped_text&#039;, &quot;;
                }


                $content_lang_nws = rtrim($content_lang_nws, &#039;, &#039;);


                $id_nws = $document_ids[$selected_document];
                $query = &quot;UPDATE news SET $content_lang_nws WHERE id_nws = $id_nws&quot;;


                mysqli_select_db($inmoconn, $database_inmoconn);
                $rTextInsert = mysqli_query($inmoconn, $query) or die(mysqli_error($inmoconn));
            }
        }
    }
}
?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Descripción propia y descripción para XML
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/apits.php:116
/xml/costadelhome.php:116
/xml/facilisimo.php:29
/xml/greenacres.php:112
/xml/habitaclia.php:29
/xml/hemnet.php:112
/xml/inmoco.php:32
/xml/kyero_mls.php:34
/xml/mimove.php:133
/xml/spainhome.php:116
/xml/sun.php:151
/xml/thinkspain.php:112
/xml/todopisoalicante.php:112
/xml/yaencontre.php:32
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/facebook.php:33
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_&quot;.$_GET[&#039;lang&#039;].&quot;_prop != &#039;&#039; THEN properties_properties.descripcion_xml_&quot;.$_GET[&#039;lang&#039;].&quot;_prop ELSE properties_properties.descripcion_&quot;.$_GET[&#039;lang&#039;].&quot;_prop END AS properties_properties.descripcion_&quot;.$_GET[&#039;lang&#039;].&quot;_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_&quot;.$_GET[&#039;lang&#039;].&quot;_prop != &#039;&#039; THEN properties_properties.descripcion_xml_&quot;.$_GET[&#039;lang&#039;].&quot;_prop ELSE properties_properties.descripcion_&quot;.$_GET[&#039;lang&#039;].&quot;_prop END AS descripcion_&quot;.$_GET[&#039;lang&#039;].&quot;_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:46
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/kyero.php:136
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/mediaelx.php:142
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN  properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN  properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN  properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN  properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN  properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS properties_properties.descripcion_fi_prop,
CASE WHEN  properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN  properties_properties.descripcion_xml_is_prop != &#039;&#039; THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS properties_properties.descripcion_is_prop,
CASE WHEN  properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN  properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS properties_properties.descripcion_no_prop,
CASE WHEN  properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN  properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN  properties_properties.descripcion_xml_zh_prop != &#039;&#039; THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS properties_properties.descripcion_zh_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN  properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN  properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN  properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN  properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN  properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS descripcion_fi_prop,
CASE WHEN  properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN  properties_properties.descripcion_xml_is_prop != &#039;&#039; THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS descripcion_is_prop,
CASE WHEN  properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN  properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS descripcion_no_prop,
CASE WHEN  properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
CASE WHEN  properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
CASE WHEN  properties_properties.descripcion_xml_zh_prop != &#039;&#039; THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS descripcion_zh_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/openinmo.php:325
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/pisos.php:35
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS properties_properties.descripcion_no_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS properties_properties.descripcion_fi_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS descripcion_no_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS descripcion_fi_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/ubiflow.php:118
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.titulo_xml_da_prop != &#039;&#039; THEN properties_properties.titulo_xml_da_prop ELSE properties_properties.titulo_da_prop END AS properties_properties.titulo_da_prop,
CASE WHEN properties_properties.titulo_xml_de_prop != &#039;&#039; THEN properties_properties.titulo_xml_de_prop ELSE properties_properties.titulo_de_prop END AS properties_properties.titulo_de_prop,
CASE WHEN properties_properties.titulo_xml_en_prop != &#039;&#039; THEN properties_properties.titulo_xml_en_prop ELSE properties_properties.titulo_en_prop END AS properties_properties.titulo_en_prop,
CASE WHEN properties_properties.titulo_xml_es_prop != &#039;&#039; THEN properties_properties.titulo_xml_es_prop ELSE properties_properties.titulo_es_prop END AS properties_properties.titulo_es_prop,
CASE WHEN properties_properties.titulo_xml_fi_prop != &#039;&#039; THEN properties_properties.titulo_xml_fi_prop ELSE properties_properties.titulo_fi_prop END AS properties_properties.titulo_fi_prop,
CASE WHEN properties_properties.titulo_xml_fr_prop != &#039;&#039; THEN properties_properties.titulo_xml_fr_prop ELSE properties_properties.titulo_fr_prop END AS properties_properties.titulo_fr_prop,
CASE WHEN properties_properties.titulo_xml_is_prop != &#039;&#039; THEN properties_properties.titulo_xml_is_prop ELSE properties_properties.titulo_is_prop END AS properties_properties.titulo_is_prop,
CASE WHEN properties_properties.titulo_xml_nl_prop != &#039;&#039; THEN properties_properties.titulo_xml_nl_prop ELSE properties_properties.titulo_nl_prop END AS properties_properties.titulo_nl_prop,
CASE WHEN properties_properties.titulo_xml_no_prop != &#039;&#039; THEN properties_properties.titulo_xml_no_prop ELSE properties_properties.titulo_no_prop END AS properties_properties.titulo_no_prop,
CASE WHEN properties_properties.titulo_xml_ru_prop != &#039;&#039; THEN properties_properties.titulo_xml_ru_prop ELSE properties_properties.titulo_ru_prop END AS properties_properties.titulo_ru_prop,
CASE WHEN properties_properties.titulo_xml_se_prop != &#039;&#039; THEN properties_properties.titulo_xml_se_prop ELSE properties_properties.titulo_se_prop END AS properties_properties.titulo_se_prop,
CASE WHEN properties_properties.titulo_xml_zh_prop != &#039;&#039; THEN properties_properties.titulo_xml_zh_prop ELSE properties_properties.titulo_zh_prop END AS properties_properties.titulo_zh_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.titulo_xml_da_prop != &#039;&#039; THEN properties_properties.titulo_xml_da_prop ELSE properties_properties.titulo_da_prop END AS titulo_da_prop,
CASE WHEN properties_properties.titulo_xml_de_prop != &#039;&#039; THEN properties_properties.titulo_xml_de_prop ELSE properties_properties.titulo_de_prop END AS titulo_de_prop,
CASE WHEN properties_properties.titulo_xml_en_prop != &#039;&#039; THEN properties_properties.titulo_xml_en_prop ELSE properties_properties.titulo_en_prop END AS titulo_en_prop,
CASE WHEN properties_properties.titulo_xml_es_prop != &#039;&#039; THEN properties_properties.titulo_xml_es_prop ELSE properties_properties.titulo_es_prop END AS titulo_es_prop,
CASE WHEN properties_properties.titulo_xml_fi_prop != &#039;&#039; THEN properties_properties.titulo_xml_fi_prop ELSE properties_properties.titulo_fi_prop END AS titulo_fi_prop,
CASE WHEN properties_properties.titulo_xml_fr_prop != &#039;&#039; THEN properties_properties.titulo_xml_fr_prop ELSE properties_properties.titulo_fr_prop END AS titulo_fr_prop,
CASE WHEN properties_properties.titulo_xml_is_prop != &#039;&#039; THEN properties_properties.titulo_xml_is_prop ELSE properties_properties.titulo_is_prop END AS titulo_is_prop,
CASE WHEN properties_properties.titulo_xml_nl_prop != &#039;&#039; THEN properties_properties.titulo_xml_nl_prop ELSE properties_properties.titulo_nl_prop END AS titulo_nl_prop,
CASE WHEN properties_properties.titulo_xml_no_prop != &#039;&#039; THEN properties_properties.titulo_xml_no_prop ELSE properties_properties.titulo_no_prop END AS titulo_no_prop,
CASE WHEN properties_properties.titulo_xml_ru_prop != &#039;&#039; THEN properties_properties.titulo_xml_ru_prop ELSE properties_properties.titulo_ru_prop END AS titulo_ru_prop,
CASE WHEN properties_properties.titulo_xml_se_prop != &#039;&#039; THEN properties_properties.titulo_xml_se_prop ELSE properties_properties.titulo_se_prop END AS titulo_se_prop,
CASE WHEN properties_properties.titulo_xml_zh_prop != &#039;&#039; THEN properties_properties.titulo_xml_zh_prop ELSE properties_properties.titulo_zh_prop END AS titulo_zh_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/xml-mediaelx.php:221
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_ca_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ca_prop ELSE properties_properties.descripcion_ca_prop END AS properties_properties.descripcion_ca_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS properties_properties.descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS properties_properties.descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS properties_properties.descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS properties_properties.descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS properties_properties.descripcion_fi_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS properties_properties.descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_is_prop != &#039;&#039; THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS properties_properties.descripcion_is_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS properties_properties.descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS properties_properties.descripcion_no_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS properties_properties.descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS properties_properties.descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_zh_prop != &#039;&#039; THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS properties_properties.descripcion_zh_prop,
CASE WHEN properties_properties.descripcion_xml_pl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_pl_prop ELSE properties_properties.descripcion_pl_prop END AS properties_properties.descripcion_pl_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CASE WHEN properties_properties.descripcion_xml_ca_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ca_prop ELSE properties_properties.descripcion_ca_prop END AS descripcion_ca_prop,
CASE WHEN properties_properties.descripcion_xml_da_prop != &#039;&#039; THEN properties_properties.descripcion_xml_da_prop ELSE properties_properties.descripcion_da_prop END AS descripcion_da_prop,
CASE WHEN properties_properties.descripcion_xml_de_prop != &#039;&#039; THEN properties_properties.descripcion_xml_de_prop ELSE properties_properties.descripcion_de_prop END AS descripcion_de_prop,
CASE WHEN properties_properties.descripcion_xml_en_prop != &#039;&#039; THEN properties_properties.descripcion_xml_en_prop ELSE properties_properties.descripcion_en_prop END AS descripcion_en_prop,
CASE WHEN properties_properties.descripcion_xml_es_prop != &#039;&#039; THEN properties_properties.descripcion_xml_es_prop ELSE properties_properties.descripcion_es_prop END AS descripcion_es_prop,
CASE WHEN properties_properties.descripcion_xml_fi_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fi_prop ELSE properties_properties.descripcion_fi_prop END AS descripcion_fi_prop,
CASE WHEN properties_properties.descripcion_xml_fr_prop != &#039;&#039; THEN properties_properties.descripcion_xml_fr_prop ELSE properties_properties.descripcion_fr_prop END AS descripcion_fr_prop,
CASE WHEN properties_properties.descripcion_xml_is_prop != &#039;&#039; THEN properties_properties.descripcion_xml_is_prop ELSE properties_properties.descripcion_is_prop END AS descripcion_is_prop,
CASE WHEN properties_properties.descripcion_xml_nl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_nl_prop ELSE properties_properties.descripcion_nl_prop END AS descripcion_nl_prop,
CASE WHEN properties_properties.descripcion_xml_no_prop != &#039;&#039; THEN properties_properties.descripcion_xml_no_prop ELSE properties_properties.descripcion_no_prop END AS descripcion_no_prop,
CASE WHEN properties_properties.descripcion_xml_ru_prop != &#039;&#039; THEN properties_properties.descripcion_xml_ru_prop ELSE properties_properties.descripcion_ru_prop END AS descripcion_ru_prop,
CASE WHEN properties_properties.descripcion_xml_se_prop != &#039;&#039; THEN properties_properties.descripcion_xml_se_prop ELSE properties_properties.descripcion_se_prop END AS descripcion_se_prop,
CASE WHEN properties_properties.descripcion_xml_zh_prop != &#039;&#039; THEN properties_properties.descripcion_xml_zh_prop ELSE properties_properties.descripcion_zh_prop END AS descripcion_zh_prop,
CASE WHEN properties_properties.descripcion_xml_pl_prop != &#039;&#039; THEN properties_properties.descripcion_xml_pl_prop ELSE properties_properties.descripcion_pl_prop END AS descripcion_pl_prop,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al filtrar por categorías de noticias
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/news.php:286
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query = &quot;
    SELECT
        news.id_nws,
        news.title_&quot; . $lang . &quot;_nws as titulo,
        news.titlew_&quot; . $lang . &quot;_nws as titulometa,
        news.content_&quot; . $lang . &quot;_nws as contenido,
        news.tags_&quot; . $lang . &quot;_nws as tags,
        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
        (SELECT alt_&quot; . $lang . &quot;_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt,
        GROUP_CONCAT(news_categories.category_&quot; . $lang . &quot;_ct SEPARATOR &#039;, &#039;) as categorias
    FROM news
    LEFT JOIN news_news_categories
        ON news.id_nws = news_news_categories.new
    LEFT JOIN news_categories
        ON news_news_categories.cat = news_categories.id_ct
    WHERE
        news.title_&quot; . $lang . &quot;_nws  != &#039;&#039;
        AND news.content_&quot; . $lang . &quot;_nws != &#039;&#039;
        AND type_nws = 1
        AND activate_nws = 1
        &quot; . $searchFull . &quot;
    GROUP BY id_nws
    ORDER BY news.date_nws DESC
    LIMIT $cp, $tp;
&ldquo;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query = &quot;
    SELECT
        news.id_nws,
        news.title_&quot; . $lang . &quot;_nws as titulo,
        news.titlew_&quot; . $lang . &quot;_nws as titulometa,
        news.content_&quot; . $lang . &quot;_nws as contenido,
        news.tags_&quot; . $lang . &quot;_nws as tags,
        news.date_nws,
        (SELECT imagen_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS img,
        (SELECT alt_&quot; . $lang . &quot;_img FROM news_fotos WHERE noticia_img = id_nws ORDER BY orden_img LIMIT 1) AS alt,
        GROUP_CONCAT(news_categories.category_&quot; . $lang . &quot;_ct SEPARATOR &#039;, &#039;) as categorias
    FROM news
    LEFT JOIN news_news_categories
        ON news.id_nws = news_news_categories.new
    LEFT JOIN news_categories
        ON news_news_categories.cat = news_categories.id_ct
    WHERE
        news.title_&quot; . $lang . &quot;_nws  != &#039;&#039;
        AND news.content_&quot; . $lang . &quot;_nws != &#039;&#039;
        AND type_nws = 1
        AND activate_nws = 1
        &quot; . $searchFull . &quot;
        $ct
    GROUP BY id_nws
    ORDER BY news.date_nws DESC
    LIMIT $cp, $tp;
&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec8">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> No se pueden crear usuarios de forma manual en una lista vacía de acumba
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/usuarios.php:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php foreach (array_slice($miembros, $_GET[&#039;start&#039;], $_GET[&#039;end&#039;]) as $key =&gt; $value) { ?&gt;
    &lt;tr&gt;
        &lt;td &gt;&lt;?php echo $value[&#039;email&#039;] ?&gt;&lt;/td&gt;
        &lt;td &gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($value[&#039;create_date&#039;])); ?&gt;&lt;/td&gt;
        &lt;td class=&quot;actions&quot;&gt;
            &lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;
                &lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;
                    &lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;
                &lt;/button&gt;
                &lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;
                    &lt;li&gt;&lt;a href=&quot;https://acumbamail.com/list/subscriber/detail/&lt;?php echo $value[&#039;id&#039;] ?&gt;/&quot; target=&quot;_blank&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-eye align-bottom me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ver en acumbamail&#039;) ?&gt;&lt;/a&gt;&lt;/li&gt;
                    &lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;
                    &lt;li&gt;&lt;a href=&quot;usuarios-delete.php?list=&lt;?php echo $_GET[&#039;id&#039;] ?&gt;&amp;id=&lt;?php echo $value[&#039;email&#039;] ?&gt;&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Eliminar&#039;) ?&gt;&lt;/a&gt;&lt;/li&gt;
                &lt;/ul&gt;
            &lt;/div&gt;
        &lt;/td&gt;
    &lt;/tr&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($miembros): ?&gt;
    &lt;?php foreach (array_slice($miembros, $_GET[&#039;start&#039;], $_GET[&#039;end&#039;]) as $key =&gt; $value) { ?&gt;
        &lt;tr&gt;
            &lt;td &gt;&lt;?php echo $value[&#039;email&#039;] ?&gt;&lt;/td&gt;
            &lt;td &gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($value[&#039;create_date&#039;])); ?&gt;&lt;/td&gt;
            &lt;td class=&quot;actions&quot;&gt;
                &lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;
                    &lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;
                        &lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;
                    &lt;/button&gt;
                    &lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;
                        &lt;li&gt;&lt;a href=&quot;https://acumbamail.com/list/subscriber/detail/&lt;?php echo $value[&#039;id&#039;] ?&gt;/&quot; target=&quot;_blank&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-eye align-bottom me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ver en acumbamail&#039;) ?&gt;&lt;/a&gt;&lt;/li&gt;
                        &lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;
                        &lt;li&gt;&lt;a href=&quot;usuarios-delete.php?list=&lt;?php echo $_GET[&#039;id&#039;] ?&gt;&amp;id=&lt;?php echo $value[&#039;email&#039;] ?&gt;&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Eliminar&#039;) ?&gt;&lt;/a&gt;&lt;/li&gt;
                    &lt;/ul&gt;
                &lt;/div&gt;
            &lt;/td&gt;
        &lt;/tr&gt;
    &lt;?php } ?&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec9">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> No se pueden añadir citas al calendario en el dashboard
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/inicio/inicio.php:XXXXX1102XXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal&quot; class=&quot;modal fade&quot; tabindex=&quot;-1&quot; aria-labelledby=&quot;myModalLabel&quot; aria-hidden=&quot;true&quot; style=&quot;display: none;&quot;&gt;
    &lt;div class=&quot;modal-dialog modal-xl&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header bg-primary&quot;&gt;
                &lt;h5 class=&quot;modal-title text-white pb-3&quot; id=&quot;myModalLabel&quot;&gt;&lt;i class=&quot;fa-regular fa-calendar-circle-plus me-2 fs-4&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/h5&gt;
                &lt;button type=&quot;button&quot; class=&quot;btn-close bg-white mb-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt; &lt;/button&gt;
            &lt;/div&gt;
            &lt;div class=&quot;modal-body bg-light&quot;&gt;

                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-7&quot;&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;titulo_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;titulo_ct&quot; id=&quot;titulo_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
                            &lt;input type=&quot;hidden&quot; name=&quot;id_ct&quot; id=&quot;id_ct&quot; value=&quot;&quot;&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;row&quot;&gt;

                          &lt;div class=&quot;col-md-6&quot;&gt;

                              &lt;div class=&quot;mb-4&quot;&gt;
                                  &lt;label for=&quot;inicio_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
                                  &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
                              &lt;/div&gt;

                          &lt;/div&gt;

                          &lt;div class=&quot;col-md-6&quot;&gt;

                              &lt;div class=&quot;mb-4&quot;&gt;
                                  &lt;label for=&quot;final_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
                                  &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
                              &lt;/div&gt;

                          &lt;/div&gt;

                        &lt;/div&gt;

                        &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;categoria_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot; required&gt;
                                        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                                        &lt;?php
                                        do {
                                        ?&gt;
                                        &lt;option value=&quot;&lt;?php echo $row_rscategorias[&#039;id_ct&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rscategorias[&#039;category_&#039;.$lang_adm.&#039;_ct&#039;]?&gt;&lt;/option&gt;
                                        &lt;?php
                                        } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                          $rows = mysqli_num_rows($rscategorias);
                                          if($rows &gt; 0) {
                                              mysqli_data_seek($rscategorias, 0);
                                            $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                          }
                                        ?&gt;
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;user_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot; required&gt;
                                        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                                        &lt;?php
                                        do {
                                        ?&gt;
                                        &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $_SESSION[&#039;kt_login_id&#039;]))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                                        &lt;?php
                                        } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                          $rows = mysqli_num_rows($rsusuarios);
                                          if($rows &gt; 0) {
                                              mysqli_data_seek($rsusuarios, 0);
                                            $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                          }
                                        ?&gt;
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;users_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Clientex&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;input type=&quot;text&quot; class=&quot;select2clientes&quot; id=&quot;users_ct&quot; name=&quot;users_ct&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;users_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Propietario&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;input type=&quot;text&quot; class=&quot;select2vendors&quot; id=&quot;vendedores_ct&quot; name=&quot;vendedores_ct&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;lugar_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;property_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; class=&quot;select2references&quot; id=&quot;property_ct&quot; name=&quot;property_ct[]&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
                        &lt;/div&gt;

                    &lt;/div&gt;

                    &lt;div class=&quot;col-md-5&quot;&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;notas_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Notas&#039;); ?&gt;:&lt;/label&gt;
                            &lt;textarea name=&quot;notas_ct&quot; id=&quot;notas_ct&quot; cols=&quot;40&quot; rows=&quot;19&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                        &lt;/div&gt;

                        &lt;hr&gt;

                        &lt;a href=&quot;#&quot; class=&quot;btn btn-success addHist pull-right&quot;&gt;&lt;?php __(&#039;A&ntilde;adir fecha&#039;); ?&gt;&lt;/a&gt;

                    &lt;/div&gt;

                &lt;/div&gt;

            &lt;/div&gt;
        &lt;/div&gt;&lt;!-- /.modal-content --&gt;
    &lt;/div&gt;&lt;!-- /.modal-dialog --&gt;
&lt;/div&gt;&lt;!-- /.modal --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal&quot; class=&quot;modal fade&quot; tabindex=&quot;-1&quot; aria-labelledby=&quot;myModalLabel&quot; aria-hidden=&quot;true&quot; style=&quot;display: none;&quot;&gt;
    &lt;div class=&quot;modal-dialog modal-xl&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header bg-primary&quot;&gt;
                &lt;h5 class=&quot;modal-title text-white pb-3&quot; id=&quot;myModalLabel&quot;&gt;&lt;i class=&quot;fa-regular fa-calendar-circle-plus me-2 fs-4&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/h5&gt;
                &lt;button type=&quot;button&quot; class=&quot;btn-close bg-white mb-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt; &lt;/button&gt;
            &lt;/div&gt;
            &lt;form method=&quot;post&quot; id=&quot;form1&quot; action=&quot;&lt;?php echo KT_escapeAttribute(KT_getFullUri()); ?&gt;&quot; class=&quot;needs-validation&quot; novalidate&gt;
            &lt;div class=&quot;modal-body bg-light&quot;&gt;


                &lt;div class=&quot;row&quot;&gt;

                    &lt;div class=&quot;col-md-7&quot;&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;titulo_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;titulo_ct&quot; id=&quot;titulo_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control  required&quot; required&gt;
                            &lt;input type=&quot;hidden&quot; name=&quot;id_ct&quot; id=&quot;id_ct&quot; value=&quot;&quot;&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;row&quot;&gt;

                          &lt;div class=&quot;col-md-6&quot;&gt;

                              &lt;div class=&quot;mb-4&quot;&gt;
                                  &lt;label for=&quot;inicio_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
                                  &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datepicktime &quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
                              &lt;/div&gt;

                          &lt;/div&gt;

                          &lt;div class=&quot;col-md-6&quot;&gt;

                              &lt;div class=&quot;mb-4&quot;&gt;
                                  &lt;label for=&quot;final_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
                                  &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datepicktime &quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot; required&gt;
                              &lt;/div&gt;

                          &lt;/div&gt;

                        &lt;/div&gt;

                        &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;categoria_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot; required&gt;
                                        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                                        &lt;?php
                                        do {
                                        ?&gt;
                                        &lt;option value=&quot;&lt;?php echo $row_rscategorias[&#039;id_ct&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rscategorias[&#039;category_&#039;.$lang_adm.&#039;_ct&#039;]?&gt;&lt;/option&gt;
                                        &lt;?php
                                        } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                          $rows = mysqli_num_rows($rscategorias);
                                          if($rows &gt; 0) {
                                              mysqli_data_seek($rscategorias, 0);
                                            $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                          }
                                        ?&gt;
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;user_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot; required&gt;
                                        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                                        &lt;?php
                                        do {
                                        ?&gt;
                                        &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $_SESSION[&#039;kt_login_id&#039;]))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                                        &lt;?php
                                        } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                          $rows = mysqli_num_rows($rsusuarios);
                                          if($rows &gt; 0) {
                                              mysqli_data_seek($rsusuarios, 0);
                                            $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                          }
                                        ?&gt;
                                    &lt;/select&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;users_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Clientex&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;input type=&quot;text&quot; class=&quot;select2clientes&quot; id=&quot;users_ct&quot; name=&quot;users_ct&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-md-6&quot;&gt;
                                &lt;div class=&quot;mb-4&quot;&gt;
                                    &lt;label for=&quot;users_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Propietario&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;input type=&quot;text&quot; class=&quot;select2vendors&quot; id=&quot;vendedores_ct&quot; name=&quot;vendedores_ct&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;lugar_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                        &lt;/div&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;property_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;:&lt;/label&gt;
                            &lt;input type=&quot;text&quot; class=&quot;select2references&quot; id=&quot;property_ct&quot; name=&quot;property_ct[]&quot; value=&quot;&quot; tabindex=&quot;-1&quot;&gt;
                        &lt;/div&gt;

                    &lt;/div&gt;

                    &lt;div class=&quot;col-md-5&quot;&gt;

                        &lt;div class=&quot;mb-4&quot;&gt;
                            &lt;label for=&quot;notas_ct&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Notas&#039;); ?&gt;:&lt;/label&gt;
                            &lt;textarea name=&quot;notas_ct&quot; id=&quot;notas_ct&quot; cols=&quot;40&quot; rows=&quot;19&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                        &lt;/div&gt;

                        &lt;hr&gt;

                        &lt;a href=&quot;#&quot; class=&quot;btn btn-success addHist pull-right&quot;&gt;&lt;?php __(&#039;A&ntilde;adir fecha&#039;); ?&gt;&lt;/a&gt;

                    &lt;/div&gt;

                &lt;/div&gt;

            &lt;/div&gt;
            &lt;div class=&quot;modal-footer bg-soft-primary&quot;&gt;
                &lt;a href=&quot;#&quot; class=&quot;btn btn-success btn-sm mt-4&quot; id=&quot;btn-close-save&quot; name=&quot;KT_Update1&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
                &lt;?php __(&#039;Cerrar y guardar&#039;); ?&gt;
                &lt;/a&gt;
                &lt;a href=&quot;#&quot; class=&quot;btn btn-danger btn-sm mt-4&quot; id=&quot;btn-close&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
                &lt;?php __(&#039;Cerrar&#039;); ?&gt;
                &lt;/a&gt;
            &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;&lt;!-- /.modal-content --&gt;
    &lt;/div&gt;&lt;!-- /.modal-dialog --&gt;
&lt;/div&gt;&lt;!-- /.modal --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/inicio/_js/dashboard.js:265
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(document).on(&#039;click&#039;, &#039;#btn-close-save&#039;, function(e) {
  e.preventDefault();
  tb = $(this);
  if ($(&quot;#form1&quot;).valid()) {
    var formVals = $(&quot;#form1&quot;).serialize();
    $.get(&quot;/intramedianet/calendar/calendario-form.php?&quot;+formVals+&quot;&amp;&quot;+$(&#039;.add-cita&#039;).attr(&#039;name&#039;)+&quot;=ok&quot;, function(data) {
      $(&#039;#calendario&#039;).fullCalendar(&#039;refetchEvents&#039;);
      alert(calAddOk);
    });
    $(&#039;#myModal&#039;).modal(&#039;hide&#039;);
    $(&#039;#myModal3&#039;).modal(&#039;hide&#039;)
  }
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(document).on(&#039;click&#039;, &#039;#btn-close-save&#039;, function(e) {
  e.preventDefault();
  tb = $(this);
  var formVals = $(&quot;#form1&quot;).serialize();
  $.get(&quot;/intramedianet/calendar/calendario-form.php?&quot;+formVals+&quot;&amp;KT_Update1=ok&quot;, function(data) {
    $(&#039;#calendario&#039;).fullCalendar(&#039;refetchEvents&#039;);
    alert(calAddOk);
  });
  $(&#039;#myModal&#039;).modal(&#039;hide&#039;);
  $(&#039;#myModal3&#039;).modal(&#039;hide&#039;)
});
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec10">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadida frase en la gestión de banner para explicar el funcionamiento
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/banner/index.php:43
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;banner-order.php&quot; class=&quot;btn btn-primary btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-arrow-up-arrow-down me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ordenar&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;!-- &lt;a href=&quot;banner-order.php&quot; class=&quot;btn btn-primary btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-arrow-up-arrow-down me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Ordenar&#039;); ?&gt;&lt;/a&gt; --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/banner/index.php:48
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;table-responsive&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-info-circle label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Banner_info&#039;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;table-responsive&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&#039;Banner_info&#039;] = &#039;Para optimizar la velocidad de carga del sitio web y evitar penalizaciones de Google por tiempos de carga lentos, no se utiliza un carrusel de im&aacute;genes en el banner principal. En su lugar, se mostrar&aacute; una &uacute;nica imagen aleatoria distinta en cada visita o recarga de p&aacute;gina.&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&#039;Banner_info&#039;] = &#039;To optimize the website&rsquo;s loading speed and avoid Google penalties for slow performance, a carousel is not used in the main homepage banner. Instead, a single random image will be displayed on each visit or page reload.&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec11">
        <span class="badge badge-dark">11</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadir calendario por usuarios a añadir a tu programa de correo
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/calendario.php:53
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rspropiedad = &quot;SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop&quot;;
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rspropiedad = &quot;SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop&quot;;
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);


$query_rsUsuariosCal = &quot;SELECT nombre_usr, id_usr FROM users WHERE nivel_usr = 9 OR nivel_usr = 8 OR nivel_usr = 7 OR nivel_usr = 10 ORDER BY nombre_usr&quot;;
$rsUsuariosCal = mysqli_query($inmoconn,$query_rsUsuariosCal) or die(mysqli_error());
$row_rsUsuariosCal = mysqli_fetch_assoc($rsUsuariosCal);
$totalRows_rsUsuariosCal = mysqli_num_rows($rsUsuariosCal);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/calendario.php:320
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal2&quot; class=&quot;modal fade&quot; data-bs-focus=&quot;false&quot; tabindex=&quot;-1&quot; aria-labelledby=&quot;myModal2Label&quot; aria-hidden=&quot;true&quot; style=&quot;display: none;&quot;&gt;
    &lt;div class=&quot;modal-dialog&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header bg-primary&quot;&gt;
                &lt;h5 class=&quot;modal-title text-white pb-3&quot; id=&quot;myModal2Label&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil me-2 fs-4&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir a tu programa de correo&#039;); ?&gt;&lt;/h5&gt;
                &lt;button type=&quot;button&quot; class=&quot;btn-close bg-white mb-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt; &lt;/button&gt;
            &lt;/div&gt;
            &lt;div class=&quot;modal-body bg-light&quot;&gt;

                &lt;p class=&quot;lead&quot;&gt;&lt;?php __(&#039;Copia la url para suscribirte en tu programa&#039;) ?&gt;:&lt;/p&gt;

                &lt;p&gt;&lt;b&gt;&lt;i class=&quot;icon icon-calendar&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;ICS Espa&ntilde;ol&#039;); ?&gt;:&lt;/b&gt; &lt;br&gt; https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=es&lt;/p&gt;
                &lt;p&gt;&lt;b&gt;&lt;i class=&quot;icon icon-calendar&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;ICS Ingl&eacute;s&#039;); ?&gt;:&lt;/b&gt; &lt;br&gt; https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=en&lt;/p&gt;

            &lt;/div&gt;
        &lt;/div&gt;&lt;!-- /.modal-content --&gt;
    &lt;/div&gt;&lt;!-- /.modal-dialog --&gt;
&lt;/div&gt;&lt;!-- /.modal --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal2&quot; class=&quot;modal fade&quot; data-bs-focus=&quot;false&quot; tabindex=&quot;-1&quot; aria-labelledby=&quot;myModal2Label&quot; aria-hidden=&quot;true&quot; style=&quot;display: none;&quot;&gt;
    &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;
            &lt;div class=&quot;modal-header bg-primary&quot;&gt;
                &lt;h5 class=&quot;modal-title text-white pb-3&quot; id=&quot;myModal2Label&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-2 fs-4&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir a tu programa de correo&#039;); ?&gt;&lt;/h5&gt;
                &lt;button type=&quot;button&quot; class=&quot;btn-close bg-white mb-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt; &lt;/button&gt;
            &lt;/div&gt;
            &lt;div class=&quot;modal-body&quot;&gt;
                &lt;p class=&quot;lead&quot;&gt;
                    &lt;?php __(&#039;Copia la url para suscribirte en tu programa&#039;) ?&gt;:&lt;/p&gt;
                &lt;p&gt;&lt;b&gt;&lt;i class=&quot;icon icon-calendar&quot;&gt;&lt;/i&gt;
                        &lt;?php __(&#039;ICS Espa&ntilde;ol&#039;); ?&gt;:&lt;/b&gt; &lt;br&gt; http://
                    &lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=es&lt;/p&gt;
                &lt;p&gt;&lt;b&gt;&lt;i class=&quot;icon icon-calendar&quot;&gt;&lt;/i&gt;
                        &lt;?php __(&#039;ICS Ingl&eacute;s&#039;); ?&gt;:&lt;/b&gt; &lt;br&gt; http://
                    &lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=en&lt;/p&gt;
                &lt;div&gt;
                    &lt;hr&gt;
                    &lt;?php do { ?&gt;
                        &lt;?php if($_SESSION[&#039;kt_login_level&#039;] == &#039;9&#039; || $row_rsUsuariosCal[&#039;id_usr&#039;] == $_SESSION[&#039;kt_login_id&#039;]) { ?&gt;
                        &lt;p&gt;
                            &lt;strong&gt;&lt;?php echo $row_rsUsuariosCal[&#039;nombre_usr&#039;]?&gt;:&lt;/strong&gt; &lt;br&gt;
                            &lt;span style=&quot;white-space: nowrap; font-size: 13.5px;&quot;&gt; &lt;b&gt;ES: &lt;/b&gt; https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=es&amp;id_usr=&lt;?php echo $row_rsUsuariosCal[&#039;id_usr&#039;]?&gt;&lt;/span&gt; &lt;br&gt;
                            &lt;span style=&quot;white-space: nowrap; font-size: 13.5px;&quot;&gt; &lt;b&gt;EN: &lt;/b&gt; https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=en&amp;id_usr=&lt;?php echo $row_rsUsuariosCal[&#039;id_usr&#039;]?&gt;&lt;/span&gt;
                        &lt;/p&gt;
                        &lt;?php } ?&gt;
                    &lt;?php } while ($row_rsUsuariosCal = mysqli_fetch_assoc($rsUsuariosCal)); ?&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class=&quot;modal-footer&quot;&gt;
                &lt;a href=&quot;#&quot; class=&quot;btn btn-danger&quot; id=&quot;btn-close&quot; data-dismiss=&quot;modal&quot;&gt;
                    &lt;?php __(&#039;Cerrar&#039;); ?&gt;
                &lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec12">
        <span class="badge badge-dark">12</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido enlaces del calendario del usuario en el formulario de edición de inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/users/users-form.php:523
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
    &lt;/div&gt;
&lt;/div&gt;

&lt;?php if ($_GET[&#039;id_usr&#039;] &gt; 0): ?&gt;
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col&quot;&gt;

        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                &lt;div class=&quot;card-header mb-4&quot;&gt;
                        &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-2&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Calendario&#039;); ?&gt;: &lt;?php __(&#039;A&ntilde;adir a tu programa de correo&#039;); ?&gt;&lt;/h4&gt;
                &lt;/div&gt;
                &lt;p class=&quot;lead&quot;&gt;&lt;?php __(&#039;Copia la url para suscribirte en tu programa&#039;) ?&gt;:&lt;/p&gt;
                &lt;p&gt;
                    &lt;span&gt; &lt;b&gt;ES: &lt;/b&gt; https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=es&amp;id_usr=&lt;?php echo $_GET[&#039;id_usr&#039;]; ?&gt;&lt;/span&gt; &lt;br&gt;&lt;br&gt;
                    &lt;span&gt; &lt;b&gt;EN: &lt;/b&gt; https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;]; ?&gt;/intramedianet/calendar/ical.php?lang=en&amp;id_usr=&lt;?php echo $_GET[&#039;id_usr&#039;]; ?&gt;&lt;/span&gt;
                &lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec13">
        <span class="badge badge-dark">13</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajuste resumen y descripción exportador Fotocasa
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaExportProperty.php:75
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;) != &#039;&#039;) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;)), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;)))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;)), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;)))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;) != &#039;&#039;) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt;  substr(strip_tags(htmlentities($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;))), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; trim(preg_replace(&#039;/\s+/&#039;, &#039; &#039;, strip_tags(htmlentities($tNG-&gt;getColumnValue(&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;))))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt;  substr(strip_tags(htmlentities($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;))), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; trim(preg_replace(&#039;/\s+/&#039;, &#039; &#039;, strip_tags(htmlentities($tNG-&gt;getColumnValue(&#039;descripcion_&#039;.$lg.&#039;_prop&#039;))))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaBulkExportProperty.php:67
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;] != &#039;&#039;) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;]), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;]))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;]), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; str_replace(&#039;&lt;br&gt;&#039;, &#039;&lt;br&gt;&lt;br&gt;&#039;, nl2br(strip_tags($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;]))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;] != &#039;&#039;) {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags(htmlentities($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;])), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; trim(preg_replace(&#039;/\s+/&#039;, &#039; &#039;, strip_tags(htmlentities($row_rsFotocasaProperty[&#039;descripcion_xml_&#039;.$lg.&#039;_prop&#039;])))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
} else {
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N ABREVIADA
        &quot;FeatureId&quot; =&gt; 2,
        &quot;TextValue&quot; =&gt; substr(strip_tags(htmlentities($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;])), 0, 300).&quot;...&quot;,
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
    $export_fotocasa_fields_prop[&quot;PropertyFeature&quot;][] = array( // DESCIPCI&Oacute;N EXTENDIDA
        &quot;FeatureId&quot; =&gt; 3,
        &quot;TextValue&quot; =&gt; trim(preg_replace(&#039;/\s+/&#039;, &#039; &#039;, strip_tags(htmlentities($row_rsFotocasaProperty[&#039;descripcion_&#039;.$lg.&#039;_prop&#039;])))),
        &quot;LanguageId&quot; =&gt; (int)$fotocasaLanguages[$lg],
    );
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec14">
        <span class="badge badge-dark">14</span> <i class="fas fz-fw fa-bug text-danger"></i> Se mezclan los mapas de zonas y ciudades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:453
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
{if isset($zonas[0].lat_long_gp_prop) &amp;&amp; $zonas[0].lat_long_gp_prop !=&#039;&#039;}
&lt;script&gt;
    !function ($) {
            {if $zonas[0].zoom_gp_prop &gt; 0}
                showMapProperty(&#039;gmap&#039;, [{$zonas[0].lat_long_gp_prop}], {$zonas[0].zoom_gp_prop - 3});
            {else}
                showMapProperty(&#039;gmap&#039;, [{$zonas[0].lat_long_gp_prop}], 13);
            {/if}
        $(document).on(&#039;shown.bs.collapse&#039;, function(){
            showMapProperty(&#039;gmap&#039;, [{$zonas[0].lat_long_gp_prop}], {$zonas[0].zoom_gp_prop - 3});
        });
    }(window.jQuery);
    &lt;/script&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:508
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if isset($smarty.get.zon) &amp;&amp; $smarty.get.zon != &#039;&#039; &amp;&amp; isset($smarty.get.ciu) &amp;&amp; $smarty.get.ciu == &#039;&#039;}
    &lt;script&gt;
    showMapZones(&#039;gmap&#039;, [{$zonas[0].lat_long_gp_prop}]);
    &lt;/script&gt;
{/if}

{if isset($smarty.get.zon) &amp;&amp; $smarty.get.zon != &#039;&#039; &amp;&amp; isset($smarty.get.ciu) &amp;&amp; $smarty.get.ciu != &#039;&#039;}
    &lt;script&gt;
    showMapZones(&#039;gmap&#039;, [{$news[0].lat_long_gp_prop}]);
    &lt;/script&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if isset($smarty.get.zon) &amp;&amp; $smarty.get.zon != &#039;&#039; &amp;&amp; $smarty.get.ciu == &#039;&#039;}
    &lt;script&gt;
    showMapZones(&#039;gmap&#039;, [{$zonas[0].lat_long_gp_prop}], {$zonas[0].zoom_gp_prop - 3});
    &lt;/script&gt;
{/if}

{if isset($smarty.get.zon) &amp;&amp; $smarty.get.zon != &#039;&#039; &amp;&amp; isset($smarty.get.ciu) &amp;&amp; $smarty.get.ciu != &#039;&#039;}
    &lt;script&gt;
    showMapZones(&#039;gmap&#039;, [{$news[0].lat_long_gp_prop}], {$zonas[0].zoom_gp_prop});
    &lt;/script&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:1386
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function showMapZones(container, latLng) {
    var map = L.map(container).setView(latLng, 10);
    map.scrollWheelZoom.disable();
    map.addLayer(new L.TileLayer(&#039;https://mt0.google.com/vt/lyrs=m&amp;hl=en&amp;x={x}&amp;y={y}&amp;z={z}&#039;, {
        maxZoom: 18,
        attribution: &#039;Map data &amp;copy; &lt;a href=&quot;https://www.openstreetmap.org/&quot;&gt;OpenStreetMap&lt;/a&gt; contributors, &#039; +
            &#039;&lt;a href=&quot;https://creativecommons.org/licenses/by-sa/2.0/&quot;&gt;CC-BY-SA&lt;/a&gt;, &#039;
    }));
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function showMapZones(container, latLng, zoom) {
    var map = L.map(container).setView(latLng, zoom);
    map.scrollWheelZoom.disable();
    map.addLayer(new L.TileLayer(&#039;https://mt0.google.com/vt/lyrs=m&amp;hl=en&amp;x={x}&amp;y={y}&amp;z={z}&#039;, {
        maxZoom: 18,
        attribution: &#039;Map data &amp;copy; &lt;a href=&quot;https://www.openstreetmap.org/&quot;&gt;OpenStreetMap&lt;/a&gt; contributors, &#039; +
            &#039;&lt;a href=&quot;https://creativecommons.org/licenses/by-sa/2.0/&quot;&gt;CC-BY-SA&lt;/a&gt;, &#039;
    }));
}
            </code>
        </pre>
        Y recompilar <code>/js/source/website.js</code>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec15">
        <span class="badge badge-dark">15</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido CCO a compradores y vendedores
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2804
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsend&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-md-4&quot;&gt;

        &lt;input type=&quot;text&quot; name=&quot;ccoSrch&quot; id=&quot;ccoSrch&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; placeholder=&quot;CCO&quot;&gt;

    &lt;/div&gt;

    &lt;div class=&quot;col-md-8&quot;&gt;

        &lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsend&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;
        &lt;a href=&quot;#&quot; class=&quot;btn btn-success btnsendwhatsapp&quot;&gt;Whatsapp: &lt;?php echo $lang[&#039;Enviar&#039;] ?&gt; &lt;span class=&quot;countusers&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;countusers2&quot;&gt;&lt;?php echo $lang[&#039;Inmueble&#039;]  ?&gt;&lt;/span&gt;&lt;span class=&quot;countusers3&quot;&gt;&lt;?php echo $lang[&#039;Inmuebles&#039;]  ?&gt;&lt;/span&gt;&lt;/a&gt;

    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2951
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;i class=&quot;fa-regular fa-paper-plane me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar Respuesta/Email&#039;] ?&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btnwhatsapp mt-4 mt-md-0&quot; target=&quot;_blank&quot;&gt;&lt;i class=&quot;fa-brands fa-whatsapp me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;: WhatsApp&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-md-4&quot;&gt;

        &lt;input type=&quot;text&quot; name=&quot;ccoEml&quot; id=&quot;ccoEml&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; placeholder=&quot;CCO&quot;&gt;

    &lt;/div&gt;

    &lt;div class=&quot;col-md-8&quot;&gt;

        &lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;i class=&quot;fa-regular fa-paper-plane me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar Respuesta/Email&#039;] ?&gt;&lt;/a&gt;
        &lt;a href=&quot;#&quot; class=&quot;btn btn-success btnwhatsapp mt-4 mt-md-0&quot; target=&quot;_blank&quot;&gt;&lt;i class=&quot;fa-brands fa-whatsapp me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;: WhatsApp&lt;/a&gt;

    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:645
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &quot;clients-send2.php?ids=&quot; + values + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;comment=&#039; + encodeURIComponent($(&#039;#comment&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;)) + &#039;&amp;tipo=1&amp;lang=&#039; + sendLang + &#039;&amp;usr=&#039; + idClient + &#039;&amp;&#039; + $(&#039;#btnsendcont&#039;).find(&#039;select, textarea, input&#039;).serialize(),
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &quot;clients-send2.php?ids=&quot; + values + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;cco=&#039; + $(&#039;#ccoSrch&#039;).val() + &#039;&amp;comment=&#039; + encodeURIComponent($(&#039;#comment&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;)) + &#039;&amp;tipo=1&amp;lang=&#039; + sendLang + &#039;&amp;usr=&#039; + idClient + &#039;&amp;&#039; + $(&#039;#btnsendcont&#039;).find(&#039;select, textarea, input&#039;).serialize(),
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:1128
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &quot;clients-send-email.php?subject=&quot; + $(&#039;#subjectSM&#039;).val() + &#039;&amp;message=&#039; + $(&#039;#messagemail&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;) + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;tipo=7&amp;lang=&#039; + $(&#039;#idioma_cli&#039;).val() + &#039;&amp;usr=&#039; + idClient,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &quot;clients-send-email.php?subject=&quot; + $(&#039;#subjectSM&#039;).val() + &#039;&amp;message=&#039; + $(&#039;#messagemail&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;) + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;cco=&#039; + $(&#039;#ccoEml&#039;).val() + &#039;&amp;tipo=7&amp;lang=&#039; + $(&#039;#idioma_cli&#039;).val() + &#039;&amp;usr=&#039; + idClient,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send2.php:175
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, $_GET[&#039;cco&#039;], array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:139
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, $_GET[&#039;cco&#039;], array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1301
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;i class=&quot;fa-regular fa-paper-plane me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar Respuesta/Email&#039;] ?&gt;&lt;/a&gt;
&lt;a href=&quot;#&quot; class=&quot;btn btn-success btnwhatsapp mt-4 mt-md-0&quot; target=&quot;_blank&quot;&gt;&lt;i class=&quot;fa-brands fa-whatsapp me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;: WhatsApp&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-md-4&quot;&gt;

        &lt;input type=&quot;text&quot; name=&quot;ccoEml&quot; id=&quot;ccoEml&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; placeholder=&quot;CCO&quot;&gt;

    &lt;/div&gt;

    &lt;div class=&quot;col-md-8&quot;&gt;

        &lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;i class=&quot;fa-regular fa-paper-plane me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar Respuesta/Email&#039;] ?&gt;&lt;/a&gt;
        &lt;a href=&quot;#&quot; class=&quot;btn btn-success btnwhatsapp mt-4 mt-md-0&quot; target=&quot;_blank&quot;&gt;&lt;i class=&quot;fa-brands fa-whatsapp me-1&quot;&gt;&lt;/i&gt; &lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;: WhatsApp&lt;/a&gt;

    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-form.js:445
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &quot;owners-send-email.php?subject=&quot;+$(&#039;#subjectSM&#039;).val()+&#039;&amp;message=&#039;+$(&#039;#messagemail&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;email=&#039;+$(&#039;#email_pro&#039;).val()+&#039;&amp;tipo=4&amp;lang=&#039; + $(&#039;#idioma_pro&#039;).val() + &#039;&amp;usr=&#039; + idOwner,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &quot;owners-send-email.php?subject=&quot;+$(&#039;#subjectSM&#039;).val()+&#039;&amp;cco=&#039; + $(&#039;#ccoSrch&#039;).val() + &#039;&amp;message=&#039;+$(&#039;#messagemail&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;email=&#039;+$(&#039;#email_pro&#039;).val()+&#039;&amp;tipo=4&amp;lang=&#039; + $(&#039;#idioma_pro&#039;).val() + &#039;&amp;usr=&#039; + idOwner,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-send-email.php:79
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, $_GET[&#039;cco&#039;], array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec16">
        <span class="badge badge-dark">16</span> <i class="fas fz-fw fa-bug text-danger"></i> El xml de APITS no mestra si es un inmueble de obra nueva
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/sun.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;Currency&gt;EUR&lt;/Currency&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;Currency&gt;EUR&lt;/Currency&gt;
&lt;?php if ($row_rsProperties[&#039;operacion_prop&#039;] == 2): ?&gt;
&lt;new_build&gt;1&lt;/new_build&gt;
&lt;?php else: ?&gt;
&lt;new_build&gt;0&lt;/new_build&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec17">
        <span class="badge badge-dark">17</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras seguimiento emails y newsletter de acumbamail
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_log_mails` ADD COLUMN `key_log` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `date_log`;
ALTER TABLE `properties_log_mails` ADD COLUMN `result_log` VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `key_log`;
            </code>
        </pre>
        <hr>
        Añadimos la carpeta:
        <pre>
            <code class="makefile">
/modules/webhook
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/email.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Acumbamail API key */
/*--------------------------------------------------------------------------
|
| API key de Acumbamail (hay que registrarse en Acumbamail para obtenerla e ir a https://acumbamail.com/apidoc/)
| Solo a&ntilde;adir si el env&iacute;o se hace con Acumbamail
|
*/

$keyAcumbamailSMTP = &#039;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:14
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/acumbamail/acumbamail.class.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:51
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (preg_match(&#039;/{{PROPERTY-([\d|,]+)}}/&#039;, $_GET[&#039;message&#039;], $matches)) {
    $ids = explode(&quot;,&quot;,$matches[1]);
    $langVal = $_GET[&#039;lang&#039;];
    $propertiesContent =&quot;&quot;;
    foreach ($ids as $id) {

        $query_rsInsert2 = &quot;
            INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
            ( NULL ,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.getIp().&quot;&#039;,  &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;, &#039;&quot;.$_GET[&#039;usr&#039;].&quot;&#039; )
        &quot;;
        mysqli_query($inmoconn,$query_rsInsert2);
        $idVal = $id;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/property.php&#039;);
        $property_code = ob_get_contents();
        ob_end_clean();
        $propertiesContent.= $property_code;
        $query_rsInsert3 = &quot;
        INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
        ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
        &quot;;
        mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
    }
    $_GET[&#039;message&#039;] = str_replace($matches[0], &#039;&lt;/p&gt;&#039; . $propertiesContent . &#039;&lt;p&gt;&#039;, $_GET[&#039;message&#039;]);
    $body  = &#039;&#039;;
    // $body  .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 30px 10px 20px 0; color: &quot;.$mailColor.&quot;; font-size: 22px;\&quot;&gt;&quot; . $_GET[&#039;subject&#039;] . &quot;&lt;/h4&gt;&quot;;
    $body .= &#039;&lt;p&gt;&#039;.($_GET[&#039;message&#039;]).&#039;&lt;/p&gt;&#039;;
} else {
    $body  = &#039;&#039;;
    $body  .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 30px 10px 20px 0; color: &quot;.$mailColor.&quot;; font-size: 22px;\&quot;&gt;&quot; . $_GET[&#039;subject&#039;] . &quot;&lt;/h4&gt;&quot;;
    $body .= &#039;&lt;p&gt;&#039;.nl2br($_GET[&#039;message&#039;]).&#039;&lt;/p&gt;&#039;;

    $query_rsInsert3 = &quot;
    INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
    ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  0,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
    &quot;;
    mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (preg_match(&#039;/{{PROPERTY-([\d|,]+)}}/&#039;, $_GET[&#039;message&#039;], $matches)) {
    $ids = explode(&quot;,&quot;,$matches[1]);
    $langVal = $_GET[&#039;lang&#039;];
    $propertiesContent =&quot;&quot;;
    foreach ($ids as $id) {

        $query_rsInsert2 = &quot;
            INSERT INTO  `properties_mail_rep` ( `id_mrep` , `property_mrep`, `ip_mrep`, `date_mrep`, `user_mrep`, `client_mrep` ) VALUES
            ( NULL ,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.getIp().&quot;&#039;,  &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;, &#039;&quot;.$_GET[&#039;usr&#039;].&quot;&#039; )
        &quot;;
        mysqli_query($inmoconn,$query_rsInsert2);
        $idVal = $id;
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/property.php&#039;);
        $property_code = ob_get_contents();
        ob_end_clean();
        $propertiesContent.= $property_code;
        if ($smtpUrl != &#039;smtp.acumbamail.com&#039;) {
            $query_rsInsert3 = &quot;
            INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
            ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
            &quot;;
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }
    }
    $_GET[&#039;message&#039;] = str_replace($matches[0], &#039;&lt;/p&gt;&#039; . $propertiesContent . &#039;&lt;p&gt;&#039;, $_GET[&#039;message&#039;]);
    $body  = &#039;&#039;;
    // $body  .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 30px 10px 20px 0; color: &quot;.$mailColor.&quot;; font-size: 22px;\&quot;&gt;&quot; . $_GET[&#039;subject&#039;] . &quot;&lt;/h4&gt;&quot;;
    $body .= &#039;&lt;p&gt;&#039;.($_GET[&#039;message&#039;]).&#039;&lt;/p&gt;&#039;;
} else {
    $body  = &#039;&#039;;
    $body  .= &quot;&lt;h4 style=\&quot;font-weight: 200; padding: 30px 10px 20px 0; color: &quot;.$mailColor.&quot;; font-size: 22px;\&quot;&gt;&quot; . $_GET[&#039;subject&#039;] . &quot;&lt;/h4&gt;&quot;;
    $body .= &#039;&lt;p&gt;&#039;.nl2br($_GET[&#039;message&#039;]).&#039;&lt;/p&gt;&#039;;
    if ($smtpUrl != &#039;smtp.acumbamail.com&#039;) {
        $query_rsInsert3 = &quot;
        INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
        ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  0,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
        &quot;;
        mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
    }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:137
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if(!isset($_GET[&#039;nombre&#039;]))
$_GET[&#039;nombre&#039;] = &#039;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if(!isset($_GET[&#039;nombre&#039;])) {
    $_GET[&#039;nombre&#039;] = &#039;&#039;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:137
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if(!isset($_GET[&#039;nombre&#039;])) {
    $_GET[&#039;nombre&#039;] = &#039;&#039;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if(!isset($_GET[&#039;nombre&#039;])) {
    $_GET[&#039;nombre&#039;] = &#039;&#039;;
}

if ($smtpUrl == &#039;smtp.acumbamail.com&#039;) {

    $acumba = new AcumbamailAPI($keyAcumbamailSMTP);
    $result = $acumba-&gt;sendOne($fromMail, $_GET[&#039;email&#039;], $html, $subject);

    if ($result[&#039;result&#039;][0][&#039;message_id&#039;] != &#039;&#039;) {

        if (preg_match(&#039;/{{PROPERTY-([\d|,]+)}}/&#039;, $_GET[&#039;message&#039;], $matches)) {
            $ids = explode(&quot;,&quot;,$matches[1]);
            foreach ($ids as $id) {
                $query_rsInsert3 = &quot;
                INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`) VALUES
                ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot; . $result[&#039;result&#039;][0][&#039;message_id&#039;] . &quot;&#039; )
                &quot;;
                mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
            }
        } else {
            $query_rsInsert3 = &quot;
            INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`) VALUES
            ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  0,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot; . $result[&#039;result&#039;][0][&#039;message_id&#039;] . &quot;&#039; )
            &quot;;
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }
        echo &quot;ok&quot;;
    } else {
        echo &quot;no&quot;;
    }

    die();

}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send2.php:14
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/acumbamail/acumbamail.class.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send2.php:82
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsInsert3 = &quot;
    INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
    ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$ids[$i].&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &#039;&quot;.$tipo.&quot;&#039;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;comment&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
&quot;;
mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($smtpUrl != &#039;smtp.acumbamail.com&#039;) {
    $query_rsInsert3 = &quot;
        INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
        ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$ids[$i].&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &#039;&quot;.$tipo.&quot;&#039;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;comment&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
    &quot;;
    mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send2.php:175
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, $_GET[&#039;cco&#039;], array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
    echo &quot;ok&quot;;
    mysqli_query($inmoconn,$query_rsInsert2);
} else {
    echo &quot;no&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($smtpUrl == &#039;smtp.acumbamail.com&#039;) {

    $acumba = new AcumbamailAPI($keyAcumbamailSMTP);
    $result = $acumba-&gt;sendOne($fromMail, $_GET[&#039;email&#039;], $html, $subject);

    if ($result[&#039;result&#039;][0][&#039;message_id&#039;] != &#039;&#039;) {

        for ($i=0; $i &lt; count($ids); $i++) {
            $query_rsInsert3 = &quot;
                INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`) VALUES
                ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&quot;.$ids[$i].&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;email&#039;]).&quot;&#039;,  &#039;&quot;.$tipo.&quot;&#039;, &#039;&quot;.mysqli_real_escape_string($inmoconn,$_GET[&#039;comment&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot; . $result[&#039;result&#039;][0][&#039;message_id&#039;] . &quot;&#039; )
            &quot;;
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        echo &quot;ok&quot;;
    } else {
        echo &quot;no&quot;;
    }

    die();

}

if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, $_GET[&#039;cco&#039;], array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
    echo &quot;ok&quot;;
} else {
    echo &quot;no&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-send-email.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/acumbamail/acumbamail.class.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-send-email.php:39
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsInsert3 = &quot;
    INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
    ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  0,  &#039;&quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
&quot;;
mysqli_query($inmoconn, $query_rsInsert3) or die(mysqli_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($smtpUrl != &#039;smtp.acumbamail.com&#039;) {
    $query_rsInsert3 = &quot;
        INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
        ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  0,  &#039;&quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
    &quot;;
    mysqli_query($inmoconn, $query_rsInsert3) or die(mysqli_error());
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-send-email.php:81
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, $_GET[&#039;cco&#039;], array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
    echo &quot;ok&quot;;
    //mysqli_query($inmoconn, $query_rsInsert2);
} else {
    echo &quot;no&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($smtpUrl == &#039;smtp.acumbamail.com&#039;) {

    $acumba = new AcumbamailAPI($keyAcumbamailSMTP);
    $result = $acumba-&gt;sendOne($fromMail, $_GET[&#039;email&#039;], $html, $subject);

    if ($result[&#039;result&#039;][0][&#039;message_id&#039;] != &#039;&#039;) {

        $query_rsInsert3 = &quot;
            INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`) VALUES
            ( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  0,  &#039;&quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysqli_real_escape_string($inmoconn, $_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysqli_real_escape_string($inmoconn,$_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot; . $result[&#039;result&#039;][0][&#039;message_id&#039;] . &quot;&#039; )
        &quot;;

        echo &quot;ok&quot;;
    } else {
        echo &quot;no&quot;;
    }

    die();

}

if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, $_GET[&#039;cco&#039;], array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
    echo &quot;ok&quot;;
} else {
    echo &quot;no&quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:12
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);

require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/acumbamail/acumbamail.class.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:400
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsInsert3 = &quot; INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`)
VALUES ( NULL, &#039;47&#039;,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$client[&#039;email_cli&#039;]).&quot;&#039;,  &#039;2&#039;, &#039;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; ) &quot;;
mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($smtpUrl != &#039;smtp.acumbamail.com&#039;) {
    $query_rsInsert3 = &quot; INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`)
    VALUES ( NULL, &#039;47&#039;,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$client[&#039;email_cli&#039;]).&quot;&#039;,  &#039;2&#039;, &#039;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; ) &quot;;
    mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:424
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sendAppEmailMandrill(array($client[&#039;email_cli&#039;] =&gt; $client[&#039;nombre_cli&#039;].&quot; &quot;.$client[&#039;apellidos_cli&#039;]), &#039;&#039;, &#039;&#039;, $fromMailAlt, $subject, $html)) {

    $query_emailSent = &quot;UPDATE  `properties_client` SET  last_send_props_cli =  NOW() WHERE  properties_client.id_cli = &#039;&quot;.$client[&#039;id_cli&#039;].&quot;&#039;;&quot;;
    mysqli_query($inmoconn,$query_emailSent, $inmoconn);
    // var_dump($client[&#039;email_cli&#039;].$properties[&quot;ids&quot;]);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($smtpUrl == &#039;smtp.acumbamail.com&#039;) {

    $acumba = new AcumbamailAPI($keyAcumbamailSMTP);
    $result = $acumba-&gt;sendOne($fromMailAlt, $_GET[&#039;email&#039;], $html, $subject);

    if ($result[&#039;result&#039;][0][&#039;message_id&#039;] != &#039;&#039;) {

        for ($i=0; $i &lt; count($ids); $i++) {
            $query_rsInsert3 = &quot; INSERT INTO  `properties_log_mails` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`, `key_log`)
            VALUES ( NULL, &#039;47&#039;,  &#039;&quot;.$id.&quot;&#039;,  &#039;&quot;.mysqli_real_escape_string($inmoconn,$client[&#039;email_cli&#039;]).&quot;&#039;,  &#039;2&#039;, &#039;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;, &#039;&quot; . $result[&#039;result&#039;][0][&#039;message_id&#039;] . &quot;&#039; ) &quot;;
            mysqli_query($inmoconn,$query_rsInsert3) or die(mysqli_error());
        }

        echo &quot;ok&quot;;
    } else {
        echo &quot;no&quot;;
    }

    die();

}

if (sendAppEmailMandrill(array($client[&#039;email_cli&#039;] =&gt; $client[&#039;nombre_cli&#039;].&quot; &quot;.$client[&#039;apellidos_cli&#039;]), &#039;&#039;, &#039;&#039;, $fromMailAlt, $subject, $html)) {
    $query_emailSent = &quot;UPDATE  `properties_client` SET  last_send_props_cli =  NOW() WHERE  properties_client.id_cli = &#039;&quot;.$client[&#039;id_cli&#039;].&quot;&#039;;&quot;;
    mysqli_query($inmoconn,$query_emailSent, $inmoconn);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1128
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="sql">
$query_rsEmails = &quot;
SELECT
properties_log_mails.id_log,
GROUP_CONCAT(properties_properties.id_prop) as id_prop,
GROUP_CONCAT(properties_properties.referencia_prop) as referencia_prop,
properties_log_mails.type_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
LEFT OUTER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
WHERE email_log = &#039;&quot;.$row_rsproperties_client[&#039;email_cli&#039;].&quot;&#039;  AND email_log != &#039;&#039;
GROUP BY date_log
ORDER BY date_log DESC
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="sql">
$query_rsEmails = &quot;
SELECT
properties_log_mails.id_log,
GROUP_CONCAT(properties_properties.id_prop) as id_prop,
GROUP_CONCAT(properties_properties.referencia_prop) as referencia_prop,
properties_log_mails.type_log,
properties_log_mails.result_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
LEFT OUTER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
WHERE email_log = &#039;&quot;.$row_rsproperties_client[&#039;email_cli&#039;].&quot;&#039;  AND email_log != &#039;&#039;
GROUP BY date_log
ORDER BY date_log DESC
&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3176
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($totalRows_rsEmails &gt; 0) { ?&gt;
&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Seguimiento de envios&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;div class=&quot;table-responsive&quot;&gt;
            &lt;table class=&quot;table table-striped table-bordered records-tables-simple2 align-middle&quot; id=&quot;emails-table&quot;&gt;
              &lt;thead class=&quot;table-light&quot;&gt;
                &lt;tr&gt;
                    &lt;th&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Administrador&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;D&oacute;nde&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Enviado&#039;); ?&gt;&lt;/th&gt;
                    &lt;th style=&quot;width: 140px;&quot;&gt;&lt;/th&gt;
                &lt;/tr&gt;
                &lt;/thead&gt;
                &lt;tbody&gt;
                &lt;?php do { ?&gt;
                  &lt;tr&gt;
                      &lt;td&gt;
                        &lt;?php $ids = array(); if(isset($row_rsEmails[&#039;id_prop&#039;])) $ids = explode(&#039;,&#039;, $row_rsEmails[&#039;id_prop&#039;]); ?&gt;
                        &lt;?php $rfs = array(); if(isset($row_rsEmails[&#039;referencia_prop&#039;])) $rfs = explode(&#039;,&#039;, $row_rsEmails[&#039;referencia_prop&#039;]); ?&gt;
                        &lt;?php $x = 0; ?&gt;
                        &lt;?php foreach ($ids as $value): ?&gt;
                            &lt;?php if ($value != &#039;&#039;): ?&gt;
                                &lt;a href=&quot;/intramedianet/properties/properties-form.php?id_prop=&lt;?php echo $value; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-soft-primary btn-sm&quot; style=&quot;margin: 2px&quot;&gt;&lt;?php echo $rfs[$x++]; ?&gt;&lt;/a&gt;
                            &lt;?php endif ?&gt;
                        &lt;?php endforeach ?&gt;
                      &lt;/td&gt;
                      &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;usr_log&#039;]; ?&gt;&lt;/td&gt;
                        &lt;td&gt;&lt;?php
                        switch ($row_rsEmails[&#039;type_log&#039;]) {
                          case &#039;1&#039;:
                            echo $lang[&#039;Ficha clientes&#039;];
                            break;
                          case &#039;2&#039;:
                            echo $lang[&#039;B&uacute;squeda de inmuebles&#039;];
                            break;
                          case &#039;3&#039;:
                            echo $lang[&#039;Bajada de precio&#039;];
                            break;
                          case &#039;4&#039;:
                            echo $lang[&#039;Clientes interesados&#039;];
                            break;
                          case &#039;5&#039;:
                            echo $lang[&#039;Lista de correo&#039;];
                            break;
                          case &#039;6&#039;:
                            echo $lang[&#039;Clientes interesados&#039;];
                            break;
                          case &#039;7&#039;:
                            echo $lang[&#039;Email&#039;];
                            break;
                          case &#039;7&#039;:
                            echo $lang[&#039;Colaborador&#039;];
                            break;
                        }
                        ?&gt;&lt;/td&gt;
                        &lt;td data-sort=&quot;&lt;?php echo $row_rsEmails[&#039;date_log&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEmails[&#039;date_log&#039;])); ?&gt;&lt;/td&gt;
                        &lt;td class=&quot;text-nowrap&quot;&gt;&lt;a href=&quot;&quot; class=&quot;btn btn-primary btn-sm view-mail-cont&quot; data-id=&quot;&lt;?php echo $row_rsEmails[&#039;id_log&#039;]; ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-eye me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;View message&#039;); ?&gt;&lt;/a&gt;&lt;/td&gt;
                  &lt;/tr&gt;
                  &lt;?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails)); ?&gt;
                &lt;/tbody&gt;
            &lt;/table&gt;
        &lt;/div&gt;
    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($totalRows_rsEmails &gt; 0) { ?&gt;
&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Seguimiento de envios&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;div class=&quot;table-responsive&quot;&gt;
            &lt;table class=&quot;table table-striped table-bordered records-tables-simple2 align-middle&quot; id=&quot;emails-table&quot;&gt;
              &lt;thead class=&quot;table-light&quot;&gt;
                &lt;tr&gt;
                    &lt;th&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Administrador&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;D&oacute;nde&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Estado&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Enviado&#039;); ?&gt;&lt;/th&gt;
                    &lt;th style=&quot;width: 140px;&quot;&gt;&lt;/th&gt;
                &lt;/tr&gt;
                &lt;/thead&gt;
                &lt;tbody&gt;
                &lt;?php do { ?&gt;
                  &lt;tr&gt;
                      &lt;td&gt;
                        &lt;?php $ids = array(); if(isset($row_rsEmails[&#039;id_prop&#039;])) $ids = explode(&#039;,&#039;, $row_rsEmails[&#039;id_prop&#039;]); ?&gt;
                        &lt;?php $rfs = array(); if(isset($row_rsEmails[&#039;referencia_prop&#039;])) $rfs = explode(&#039;,&#039;, $row_rsEmails[&#039;referencia_prop&#039;]); ?&gt;
                        &lt;?php $x = 0; ?&gt;
                        &lt;?php foreach ($ids as $value): ?&gt;
                            &lt;?php if ($value != &#039;&#039;): ?&gt;
                                &lt;a href=&quot;/intramedianet/properties/properties-form.php?id_prop=&lt;?php echo $value; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-soft-primary btn-sm&quot; style=&quot;margin: 2px&quot;&gt;&lt;?php echo $rfs[$x++]; ?&gt;&lt;/a&gt;
                            &lt;?php endif ?&gt;
                        &lt;?php endforeach ?&gt;
                      &lt;/td&gt;
                      &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;usr_log&#039;]; ?&gt;&lt;/td&gt;
                      &lt;td&gt;&lt;?php
                      switch ($row_rsEmails[&#039;type_log&#039;]) {
                        case &#039;1&#039;:
                          echo $lang[&#039;Ficha clientes&#039;];
                          break;
                        case &#039;2&#039;:
                          echo $lang[&#039;B&uacute;squeda de inmuebles&#039;];
                          break;
                        case &#039;3&#039;:
                          echo $lang[&#039;Bajada de precio&#039;];
                          break;
                        case &#039;4&#039;:
                          echo $lang[&#039;Clientes interesados&#039;];
                          break;
                        case &#039;5&#039;:
                          echo $lang[&#039;Lista de correo&#039;];
                          break;
                        case &#039;6&#039;:
                          echo $lang[&#039;Clientes interesados&#039;];
                          break;
                        case &#039;7&#039;:
                          echo $lang[&#039;Email&#039;];
                          break;
                        case &#039;7&#039;:
                          echo $lang[&#039;Colaborador&#039;];
                          break;
                      }
                      ?&gt;&lt;/td&gt;
                      &lt;td&gt;&lt;?php
                      switch ($row_rsEmails[&#039;result_log&#039;]) {
                        case &#039;delivered&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-secondary text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;delivered&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;opens&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-success text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;opens&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;clicks&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-secondary text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;clicks&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;hard_bounces&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-danger text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;hard_bounces&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;soft_bounces&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-warning text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;soft_bounces&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;complaints&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-danger text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;complaints&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        default:
                          echo &#039;-&#039;;
                          break;
                      }
                      ?&gt;&lt;/td&gt;
                      &lt;td data-sort=&quot;&lt;?php echo $row_rsEmails[&#039;date_log&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEmails[&#039;date_log&#039;])); ?&gt;&lt;/td&gt;
                      &lt;td class=&quot;text-nowrap&quot;&gt;&lt;a href=&quot;&quot; class=&quot;btn btn-primary btn-sm view-mail-cont&quot; data-id=&quot;&lt;?php echo $row_rsEmails[&#039;id_log&#039;]; ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-eye me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;View message&#039;); ?&gt;&lt;/a&gt;&lt;/td&gt;
                  &lt;/tr&gt;
                  &lt;?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails)); ?&gt;
                &lt;/tbody&gt;
            &lt;/table&gt;
        &lt;/div&gt;
    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1607
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsEmails = &quot;
SELECT
properties_log_mails.id_log,
(SELECT CONCAT_WS(&#039;&#039;, nombre_cli, &#039; &#039;, apellidos_cli, &#039; &lt;br&gt;&lt;small&gt;&#039;, email_cli, &#039;&lt;/small&gt;&#039;) FROM properties_client WHERE email_cli = email_log LIMIT 1) as email_log,
properties_log_mails.type_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log LIMIT 1) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
WHERE prop_id_log = &#039;&quot;.$row_rsproperties_properties[&#039;id_prop&#039;].&quot;&#039;
ORDER BY date_log DESC
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsEmails = &quot;
SELECT
properties_log_mails.id_log,
(SELECT CONCAT_WS(&#039;&#039;, nombre_cli, &#039; &#039;, apellidos_cli, &#039; &lt;br&gt;&lt;small&gt;&#039;, email_cli, &#039;&lt;/small&gt;&#039;) FROM properties_client WHERE email_cli = email_log LIMIT 1) as email_log,
properties_log_mails.type_log,
properties_log_mails.result_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log LIMIT 1) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
WHERE prop_id_log = &#039;&quot;.$row_rsproperties_properties[&#039;id_prop&#039;].&quot;&#039;
ORDER BY date_log DESC
&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4876
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($totalRows_rsEmails &gt; 0) { ?&gt;

&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Env&iacute;o de emails&#039;); ?&gt;: &lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_prop&#039;]); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;div class=&quot;table-responsive&quot;&gt;
            &lt;table class=&quot;table table-striped table-bordered align-middle records-tables-simple2&quot; id=&quot;emails-tables&quot;&gt;
              &lt;thead class=&quot;table-light&quot;&gt;
                  &lt;tr&gt;
                    &lt;th&gt;&lt;?php __(&#039;Administrador&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;D&oacute;nde&#039;); ?&gt;&lt;/th&gt;
                    &lt;th style=&quot;width: 150px;&quot;&gt;&lt;?php __(&#039;Enviado&#039;); ?&gt;&lt;/th&gt;
                    &lt;th style=&quot;width: 140px;&quot;&gt;&lt;/th&gt;
                  &lt;/tr&gt;
                  &lt;/thead&gt;
                  &lt;tbody&gt;
                  &lt;?php do { ?&gt;
                    &lt;tr&gt;
                      &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;usr_log&#039;]; ?&gt;&lt;/td&gt;
                      &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;email_log&#039;]; ?&gt;&lt;/td&gt;
                      &lt;td&gt;&lt;?php
                      switch ($row_rsEmails[&#039;type_log&#039;]) {
                        case &#039;1&#039;:
                          echo __(&#039;Ficha clientes&#039;);
                          break;
                        case &#039;2&#039;:
                          echo __(&#039;B&uacute;squeda de inmuebles&#039;);
                          break;
                        case &#039;3&#039;:
                          echo __(&#039;Bajada de precio&#039;);
                          break;
                        case &#039;4&#039;:
                          echo __(&#039;Clientes interesados&#039;);
                          break;
                        case &#039;5&#039;:
                          echo __(&#039;Lista de correo&#039;);
                          break;
                        case &#039;6&#039;:
                          echo __(&#039;Clientes interesados&#039;);
                          break;
                      }
                      ?&gt;&lt;/td&gt;
                      &lt;td data-sort=&quot;&lt;?php echo $row_rsEmails[&#039;date_log&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEmails[&#039;date_log&#039;])); ?&gt;&lt;/td&gt;
                      &lt;td class=&quot;text-nowrap&quot;&gt;&lt;a href=&quot;&quot; class=&quot;btn btn-primary btn-sm view-mail-cont&quot; data-id=&quot;&lt;?php echo $row_rsEmails[&#039;id_log&#039;]; ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-eye me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;View message&#039;); ?&gt;&lt;/a&gt;&lt;/td&gt;
                    &lt;/tr&gt;
                    &lt;?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails)); ?&gt;
                  &lt;/tbody&gt;
              &lt;/table&gt;
        &lt;/div&gt;

    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;

&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($totalRows_rsEmails &gt; 0) { ?&gt;

&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;Env&iacute;o de emails&#039;); ?&gt;: &lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_prop&#039;]); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;
        &lt;div class=&quot;table-responsive&quot;&gt;
            &lt;table class=&quot;table table-striped table-bordered align-middle records-tables-simple2&quot; id=&quot;emails-tables&quot;&gt;
              &lt;thead class=&quot;table-light&quot;&gt;
                  &lt;tr&gt;
                    &lt;th&gt;&lt;?php __(&#039;Administrador&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Cliente&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;D&oacute;nde&#039;); ?&gt;&lt;/th&gt;
                    &lt;th&gt;&lt;?php __(&#039;Estado&#039;); ?&gt;&lt;/th&gt;
                    &lt;th style=&quot;width: 150px;&quot;&gt;&lt;?php __(&#039;Enviado&#039;); ?&gt;&lt;/th&gt;
                    &lt;th style=&quot;width: 140px;&quot;&gt;&lt;/th&gt;
                  &lt;/tr&gt;
                  &lt;/thead&gt;
                  &lt;tbody&gt;
                  &lt;?php do { ?&gt;
                    &lt;tr&gt;
                      &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;usr_log&#039;]; ?&gt;&lt;/td&gt;
                      &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;email_log&#039;]; ?&gt;&lt;/td&gt;
                      &lt;td&gt;&lt;?php
                      switch ($row_rsEmails[&#039;type_log&#039;]) {
                        case &#039;1&#039;:
                          echo __(&#039;Ficha clientes&#039;);
                          break;
                        case &#039;2&#039;:
                          echo __(&#039;B&uacute;squeda de inmuebles&#039;);
                          break;
                        case &#039;3&#039;:
                          echo __(&#039;Bajada de precio&#039;);
                          break;
                        case &#039;4&#039;:
                          echo __(&#039;Clientes interesados&#039;);
                          break;
                        case &#039;5&#039;:
                          echo __(&#039;Lista de correo&#039;);
                          break;
                        case &#039;6&#039;:
                          echo __(&#039;Clientes interesados&#039;);
                          break;
                      }
                      ?&gt;&lt;/td&gt;
                      &lt;td&gt;&lt;?php
                      switch ($row_rsEmails[&#039;result_log&#039;]) {
                        case &#039;delivered&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-secondary text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;delivered&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;opens&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-success text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;opens&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;clicks&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-secondary text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;clicks&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;hard_bounces&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-danger text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;hard_bounces&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;soft_bounces&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-warning text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;soft_bounces&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        case &#039;complaints&#039;:
                          echo &#039;&lt;span class=&quot;badge text-bg-danger text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;complaints&#039;] . &#039;&lt;/span&gt;&#039;;
                          break;
                        default:
                          echo &#039;-&#039;;
                          break;
                      }
                      ?&gt;&lt;/td&gt;
                      &lt;td data-sort=&quot;&lt;?php echo $row_rsEmails[&#039;date_log&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEmails[&#039;date_log&#039;])); ?&gt;&lt;/td&gt;
                      &lt;td class=&quot;text-nowrap&quot;&gt;&lt;a href=&quot;&quot; class=&quot;btn btn-primary btn-sm view-mail-cont&quot; data-id=&quot;&lt;?php echo $row_rsEmails[&#039;id_log&#039;]; ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-eye me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;View message&#039;); ?&gt;&lt;/a&gt;&lt;/td&gt;
                    &lt;/tr&gt;
                    &lt;?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails)); ?&gt;
                  &lt;/tbody&gt;
              &lt;/table&gt;
        &lt;/div&gt;

    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;

&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/emails.php:160
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;D&oacute;nde&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;D&oacute;nde&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Estado&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/emails-data.php:48
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, &#039;type_log&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, &#039;type_log&#039;);
array_push($aColumns, &#039;result_log&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/emails-data.php:247
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
properties_log_mails.type_log,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
properties_log_mails.type_log,
properties_log_mails.result_log,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/emails-data.php:300
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
} else if ($aColumns[$i] == &#039;type_log&#039;) {
    switch ($aRow[$aColumns[$i]]) {
        case &#039;1&#039;:
            $row[] = $lang[&#039;Ficha clientes&#039;];
            break;
        case &#039;2&#039;:
            $row[] = $lang[&#039;B&uacute;squeda de inmuebles&#039;];
            break;
        case &#039;3&#039;:
            $row[] = $lang[&#039;Bajada de precio&#039;];
            break;
        case &#039;4&#039;:
            $row[] = $lang[&#039;Clientes interesados&#039;];
            break;
        case &#039;5&#039;:
            $row[] = $lang[&#039;Lista de correo&#039;];
            break;
        case &#039;6&#039;:
            $row[] = $lang[&#039;Listado de propiedades&#039;];
            break;
        default:
            $row[] = &#039;&#039;;
            break;
    }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
} else if ($aColumns[$i] == &#039;type_log&#039;) {
    switch ($aRow[$aColumns[$i]]) {
        case &#039;1&#039;:
            $row[] = $lang[&#039;Ficha clientes&#039;];
            break;
        case &#039;2&#039;:
            $row[] = $lang[&#039;B&uacute;squeda de inmuebles&#039;];
            break;
        case &#039;3&#039;:
            $row[] = $lang[&#039;Bajada de precio&#039;];
            break;
        case &#039;4&#039;:
            $row[] = $lang[&#039;Clientes interesados&#039;];
            break;
        case &#039;5&#039;:
            $row[] = $lang[&#039;Lista de correo&#039;];
            break;
        case &#039;6&#039;:
            $row[] = $lang[&#039;Listado de propiedades&#039;];
            break;
        default:
            $row[] = &#039;&#039;;
            break;
    }
} else if ($aColumns[$i] == &#039;result_log&#039;) {
    switch ($aRow[$aColumns[$i]]) {
        case &#039;delivered&#039;:
          $row[] = &#039;&lt;span class=&quot;badge text-bg-secondary text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;delivered&#039;] . &#039;&lt;/span&gt;&#039;;
          break;
        case &#039;opens&#039;:
          $row[] = &#039;&lt;span class=&quot;badge text-bg-success text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;opens&#039;] . &#039;&lt;/span&gt;&#039;;
          break;
        case &#039;clicks&#039;:
          $row[] = &#039;&lt;span class=&quot;badge text-bg-secondary text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;clicks&#039;] . &#039;&lt;/span&gt;&#039;;
          break;
        case &#039;hard_bounces&#039;:
          $row[] = &#039;&lt;span class=&quot;badge text-bg-danger text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;hard_bounces&#039;] . &#039;&lt;/span&gt;&#039;;
          break;
        case &#039;soft_bounces&#039;:
          $row[] = &#039;&lt;span class=&quot;badge text-bg-warning text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;soft_bounces&#039;] . &#039;&lt;/span&gt;&#039;;
          break;
        case &#039;complaints&#039;:
          $row[] = &#039;&lt;span class=&quot;badge text-bg-danger text-uppercase fs-6&quot;&gt;&#039; . $lang[&#039;complaints&#039;] . &#039;&lt;/span&gt;&#039;;
          break;
        default:
          $row[] = &#039;-&#039;;
          break;
    }
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/_js/report-emails-search.js:22
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
null,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
null,
null,
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
$lang[&#039;delivered&#039;] = &#039;Entregado&#039;;
$lang[&#039;opens&#039;] = &#039;Abierto&#039;;
$lang[&#039;clicks&#039;] = &#039;Click&#039;;
$lang[&#039;hard_bounces&#039;] = &#039;Hard bounces&#039;;
$lang[&#039;soft_bounces&#039;] = &#039;Soft bounces&#039;;
$lang[&#039;complaints&#039;] = &#039;Queja&#039;;
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
$lang['delivered'] = 'Delivered';
$lang['opens'] = 'Open';
$lang['clicks'] = 'Click';
$lang['hard_bounces'] = 'Hard bounces';
$lang['soft_bounces'] = 'Soft bounces';
$lang['complaints'] = 'Complaints';
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec18">
        <span class="badge badge-dark">18</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al generar urls para inmuebles con metas con emojis
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php
            </code>
        </pre>
        Añadimos la función:
        <pre>
            <code class="php">
function removeEmojis($string) {
    return preg_replace(&#039;/[\x{1F600}-\x{1F64F}&#039; . // Emoticons
            &#039;\x{1F300}-\x{1F5FF}&#039; . // Symbols &amp; Pictographs
            &#039;\x{1F680}-\x{1F6FF}&#039; . // Transport &amp; Map
            &#039;\x{2600}-\x{26FF}&#039; .   // Misc symbols
            &#039;\x{2700}-\x{27BF}&#039; .   // Dingbats
            &#039;\x{1F900}-\x{1F9FF}&#039; . // Supplemental Symbols
            &#039;\x{1F1E6}-\x{1F1FF}]/u&#039;, &#039;&#039;, $string); // Flags
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php:928
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
return $urlStart . &#039;&#039; . $urlStr[&#039;property&#039;][&#039;url&#039;] . &#039;/&#039; . $property[0][&#039;id_prop&#039;] . &#039;/&#039; . clean(html_entity_decode($property[0][&#039;metatitle&#039;])) . &#039;/&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
return $urlStart . &#039;&#039; . $urlStr[&#039;property&#039;][&#039;url&#039;] . &#039;/&#039; . $property[0][&#039;id_prop&#039;] . &#039;/&#039; . clean(removeEmojis(html_entity_decode($property[0][&#039;metatitle&#039;]))) . &#039;/&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec19">
        <span class="badge badge-dark">19</span> <i class="fas fz-fw fa-bug text-danger"></i> Solución scroll lateral en windows
    </h6>
    <div class="card-body">
        Añadir el archivo: <code>/intramedianet/includes/assets/_custom/vendor/jquery.doubleScroll.js</code>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:292
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script src=&quot;_js/properties-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script src=&quot;/intramedianet/includes/assets/_custom/vendor/jquery.doubleScroll.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;

&lt;script src=&quot;_js/properties-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;

&lt;script type=&quot;text/javascript&quot;&gt;
    $(document).ready(function(){
       $(&#039;.table-responsiveSCRLL&#039;).doubleScroll();
    });
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-list.js:111
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; tr&gt;&gt;&lt;&#039;row&#039;&lt;&#039;col-sm-12 col-md-5&#039;i&gt;&lt;&#039;col-sm-12 col-md-7&#039;p&gt;&gt;lB&quot;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsiveSCRLL&#039; tr&gt;&gt;&lt;&#039;row&#039;&lt;&#039;col-sm-12 col-md-5&#039;i&gt;&lt;&#039;col-sm-12 col-md-7&#039;p&gt;&gt;lB&quot;,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:140
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script src=&quot;_js/clients-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script src=&quot;/intramedianet/includes/assets/_custom/vendor/jquery.doubleScroll.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;

&lt;script src=&quot;_js/clients-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;

&lt;script type=&quot;text/javascript&quot;&gt;
    $(document).ready(function(){
       $(&#039;.table-responsiveSCRLL&#039;).doubleScroll();
    });
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-list.js:45
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; tr&gt;&gt;&lt;&#039;row&#039;&lt;&#039;col-sm-12 col-md-5&#039;i&gt;&lt;&#039;col-sm-12 col-md-7&#039;p&gt;&gt;lB&quot;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsiveSCRLL&#039; tr&gt;&gt;&lt;&#039;row&#039;&lt;&#039;col-sm-12 col-md-5&#039;i&gt;&lt;&#039;col-sm-12 col-md-7&#039;p&gt;&gt;lB&quot;,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:119
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script src=&quot;_js/owners-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script src=&quot;/intramedianet/includes/assets/_custom/vendor/jquery.doubleScroll.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;

&lt;script src=&quot;_js/owners-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;

&lt;script type=&quot;text/javascript&quot;&gt;
    $(document).ready(function(){
       $(&#039;.table-responsiveSCRLL&#039;).doubleScroll();
    });
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
intramedianet/properties/_js/owners-list.js:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsive&#039; tr&gt;&gt;&lt;&#039;row&#039;&lt;&#039;col-sm-12 col-md-5&#039;i&gt;&lt;&#039;col-sm-12 col-md-7&#039;p&gt;&gt;lB&quot;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
dom: &quot;&lt;&#039;row&#039;&lt;&#039;col-sm-12 table-responsiveSCRLL&#039; tr&gt;&gt;&lt;&#039;row&#039;&lt;&#039;col-sm-12 col-md-5&#039;i&gt;&lt;&#039;col-sm-12 col-md-7&#039;p&gt;&gt;lB&quot;,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec20">
        <span class="badge badge-dark">20</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminar inmuebles exportados a rightmove al dejar de venir en los xmls
    </h6>
    <div class="card-body">
        Subir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/rightmove/properties-rightmove-getImport.php
/intramedianet/properties/rightmove/properties-rightmove-removeImport.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Kyero.php:163
/intramedianet/xml/importadores/Resales.php:235
/intramedianet/xml/importadores/Redsp.php:176
/intramedianet/xml/importadores/Mediaelx.php:258
/intramedianet/xml/importadores/Inmovilla.php:396
/intramedianet/xml/importadores/Habihub.php:240
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsPropsDel = &quot;SELECT id_prop, referencia_prop FROM properties_properties WHERE xml_xml_prop = &#039;&quot;.$_GET[&#039;p&#039;].&quot;&#039; AND activado_prop = 0&quot;;
$rsPropsDel = mysqli_query($inmoconn,$query_rsPropsDel) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsPropsDel);
$row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel);
$totalRows_rsPropsDel = mysqli_num_rows($rsPropsDel);

if ($totalRows_rsPropsDel &gt; 0) {

    do {


        $query_rsXMLfea = &quot;DELETE FROM properties_property_feature_priv WHERE property = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLfea);


        $query_rsXMLfea = &quot;DELETE FROM properties_property_tag WHERE property = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLfea);


        $query_rsXMLfea = &quot;DELETE FROM properties_360 WHERE property_360 = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


        $query_rsXMLfea = &quot;DELETE FROM properties_videos WHERE property_vid = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


        $query_rsXMLfea = &quot;DELETE FROM properties_log WHERE prop_id_log = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


        $query_rsXMLfea = &quot;DELETE FROM properties_log_2 WHERE prop_id_log = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());

        // logprop(&#039;0&#039;, $row_rsPropsDel[&#039;id_prop&#039;], $row_rsPropsDel[&#039;referencia_prop&#039;], &#039;5&#039;);


        $query_rsXMLprop = &quot;DELETE FROM properties_properties WHERE id_prop = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLprop = mysqli_query($inmoconn,$query_rsXMLprop) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLprop);

        if ($expFotoCasa == 1) {
            include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/fotocasa/FotocasaAPI.php&#039;);

            $result = FotocasaAPI::getPublicationProperty($fotocasaDatos[&quot;api_key&quot;]);
            $result = json_decode($result,1);
            foreach ( $result as $key =&gt; $prop) {
                if( $prop[&quot;ExternalId&quot;] == $row_rsPropsDel[&#039;id_prop&#039;] ) {
                    $resutl = FotocasaAPI::deletePropertyByPortal( (int)$row_rsPropsDel[&#039;id_prop&#039;], 1, $fotocasaDatos[&quot;api_key&quot;]);
                    $_SESSION[&#039;fc_status&#039;] = $result;
                }
            }
        }

        $query_rsXML = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXML);
        $row_rsXML = mysqli_fetch_assoc($rsXML);
        $totalRows_rsXML = mysqli_num_rows($rsXML);

        do {

            array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/media/images/properties/thumbnails/&quot; . $row_rsXML[&#039;id_img&#039;] . &quot;_*&quot;));


            $query_rsDelIMG = &quot;DELETE FROM properties_images WHERE id_img = &#039;&quot;.$row_rsXML[&#039;id_img&#039;].&quot;&#039;&quot;;
            $rsDelIMG = mysqli_query($inmoconn,$query_rsDelIMG) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsDelIMG);

        } while ($row_rsXML = mysqli_fetch_assoc($rsXML));

    } while ($row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel));

    array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/modules/_cache/*&quot;));

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsPropsDel = &quot;SELECT id_prop, referencia_prop FROM properties_properties WHERE xml_xml_prop = &#039;&quot;.$_GET[&#039;p&#039;].&quot;&#039; AND activado_prop = 0&quot;;
$rsPropsDel = mysqli_query($inmoconn,$query_rsPropsDel) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsPropsDel);
$row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel);
$totalRows_rsPropsDel = mysqli_num_rows($rsPropsDel);

if ($totalRows_rsPropsDel &gt; 0) {

    do {

        $query_rsXMLfea = &quot;DELETE FROM properties_property_feature_priv WHERE property = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLfea);


        $query_rsXMLfea = &quot;DELETE FROM properties_property_tag WHERE property = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLfea);


        $query_rsXMLfea = &quot;DELETE FROM properties_360 WHERE property_360 = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


        $query_rsXMLfea = &quot;DELETE FROM properties_videos WHERE property_vid = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


        $query_rsXMLfea = &quot;DELETE FROM properties_log WHERE prop_id_log = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());


        $query_rsXMLfea = &quot;DELETE FROM properties_log_2 WHERE prop_id_log = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLfea = mysqli_query($inmoconn,$query_rsXMLfea) or die(mysqli_error());

        // logprop(&#039;0&#039;, $row_rsPropsDel[&#039;id_prop&#039;], $row_rsPropsDel[&#039;referencia_prop&#039;], &#039;5&#039;);

        if ($expFotoCasa == 1) {
            include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/fotocasa/FotocasaAPI.php&#039;);

            $result = FotocasaAPI::getPublicationProperty($fotocasaDatos[&quot;api_key&quot;]);
            $result = json_decode($result,1);
            foreach ( $result as $key =&gt; $prop) {
                if( $prop[&quot;ExternalId&quot;] == $row_rsPropsDel[&#039;id_prop&#039;] ) {
                    $resutl = FotocasaAPI::deletePropertyByPortal( (int)$row_rsPropsDel[&#039;id_prop&#039;], 1, $fotocasaDatos[&quot;api_key&quot;]);
                    $_SESSION[&#039;fc_status&#039;] = $result;
                }
            }
        }

        $query_rsXML = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXML = mysqli_query($inmoconn,$query_rsXML) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXML);
        $row_rsXML = mysqli_fetch_assoc($rsXML);
        $totalRows_rsXML = mysqli_num_rows($rsXML);

        do {

            array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/media/images/properties/thumbnails/&quot; . $row_rsXML[&#039;id_img&#039;] . &quot;_*&quot;));


            $query_rsDelIMG = &quot;DELETE FROM properties_images WHERE id_img = &#039;&quot;.$row_rsXML[&#039;id_img&#039;].&quot;&#039;&quot;;
            $rsDelIMG = mysqli_query($inmoconn,$query_rsDelIMG) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsDelIMG);

        } while ($row_rsXML = mysqli_fetch_assoc($rsXML));

        if ($expRightmove == 1) {

            $_GET[&#039;id_prop&#039;] = $row_rsPropsDel[&#039;id_prop&#039;];

            ob_start();
            include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-getImport.php&#039;);
            $json = ob_get_contents();
            ob_end_clean();

            $fields = array (
                &#039;json&#039; =&gt; urlencode($json),
                &#039;url&#039; =&gt; urlencode(&#039;https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist&#039;)
            );

            foreach($fields as $key=&gt;$value) {
                $fields_string .= $key.&#039;=&#039;.$value.&#039;&amp;&#039;;
            }
            rtrim($fields_string, &#039;&amp;&#039;);

            $result = getRightmove(&#039;https://curl.mediaelx.info/rightmove.php&#039;, $fields, $fields_string);

            $result = explode(&#039;,&#039;, $result);

            $deleteProp = 0;

            foreach ($result as $value) {
                if ($row_rsPropsDel[&#039;referencia_prop&#039;] == $value) {
                    $deleteProp = 1;
                }
            }

            if ($deleteProp == 1) {

                $export_rightmove_fields_prop = json_decode($row_rsPropsDel[&#039;export_rightmove_fields_prop&#039;], true);

                ob_start();
                include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-removeImport.php&#039;);
                $json = ob_get_contents();
                ob_end_clean();

                $fields = array (
                    &#039;json&#039; =&gt; urlencode($json),
                    &#039;url&#039; =&gt; urlencode(&#039;https://adfapi.rightmove.co.uk/v1/property/removeproperty&#039;)
                );

                foreach($fields as $key=&gt;$value) {
                    $fields_string .= $key.&#039;=&#039;.$value.&#039;&amp;&#039;;
                }
                rtrim($fields_string, &#039;&amp;&#039;);

                $result = getRightmove(&#039;https://curl.mediaelx.info/rightmove.php&#039;, $fields, $fields_string);
            }

        }

        $query_rsXMLprop = &quot;DELETE FROM properties_properties WHERE id_prop = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
        $rsXMLprop = mysqli_query($inmoconn, $query_rsXMLprop) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLprop);

    } while ($row_rsPropsDel = mysqli_fetch_assoc($rsPropsDel));

    array_map(&#039;unlink&#039;, glob($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/modules/_cache/*&quot;));

}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card">
    <h6 class="card-header" id="sec21">
        <span class="badge badge-dark">21</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Template semanal autogestionable
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `templates` ADD `week_tmpl` INT(1) NOT NULL DEFAULT &#039;0&#039; AFTER `content_pl_tmpl`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/news-form.php:53
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_templates-&gt;addColumn(&quot;name_es_tmpl&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;name_es_tmpl&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_templates-&gt;addColumn(&quot;name_es_tmpl&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;name_es_tmpl&quot;);
$ins_templates-&gt;addColumn(&quot;week_tmpl&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;week_tmpl&quot;, &quot;0&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/news-form.php:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_templates-&gt;addColumn(&quot;name_es_tmpl&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;name_es_tmpl&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_templates-&gt;addColumn(&quot;name_es_tmpl&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;name_es_tmpl&quot;);
$upd_templates-&gt;addColumn(&quot;week_tmpl&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;week_tmpl&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/news-form.php:136
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-12&rdquo;&gt;

    &lt;div class=&quot;card position-relative&quot;&gt;
        &lt;div class=&quot;card-body&quot;&gt;

            &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_collaborators_categories&quot;, &quot;name_en_tmpl&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                &lt;label for=&quot;name_en_tmpl&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                &lt;div class=&quot;input-group&quot;&gt;
                    &lt;span class=&quot;input-group-text&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/en.svg&quot; alt=&quot;&quot; height=&quot;15&quot;&gt;&lt;/span&gt;
                    &lt;input type=&quot;text&quot; name=&quot;name_en_tmpl&quot; id=&quot;name_en_tmpl&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rstemplates[&#039;name_en_tmpl&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
                    &lt;div class=&quot;invalid-feedback&quot;&gt;
                        &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_collaborators_categories&quot;, &quot;name_en_tmpl&quot;); ?&gt;
            &lt;/div&gt;


            &lt;div class=&quot;&lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_collaborators_categories&quot;, &quot;name_es_tmpl&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                &lt;label for=&quot;name_es_tmpl&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                &lt;div class=&quot;input-group&quot;&gt;
                    &lt;span class=&quot;input-group-text&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/es.svg&quot; alt=&quot;&quot; height=&quot;15&quot;&gt;&lt;/span&gt;
                    &lt;input type=&quot;text&quot; name=&quot;name_es_tmpl&quot; id=&quot;name_es_tmpl&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rstemplates[&#039;name_es_tmpl&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
                    &lt;div class=&quot;invalid-feedback&quot;&gt;
                        &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_collaborators_categories&quot;, &quot;name_es_tmpl&quot;); ?&gt;
            &lt;/div&gt;

        &lt;/div&gt;&lt;!-- end card-body --&gt;
    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-lg-9&quot;&gt;
        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot; properties_collaborators_categories&quot;, &quot;name_en_tmpl&quot; ) !=&#039;&#039; ) { ?&gt;has-error
                    &lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;name_en_tmpl&quot; class=&quot;form-label required&quot;&gt;
                        &lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                    &lt;div class=&quot;input-group&quot;&gt;
                        &lt;span class=&quot;input-group-text&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/en.svg&quot; alt=&quot;&quot; height=&quot;15&quot;&gt;&lt;/span&gt;
                        &lt;input type=&quot;text&quot; name=&quot;name_en_tmpl&quot; id=&quot;name_en_tmpl&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rstemplates[&#039;name_en_tmpl&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
                        &lt;div class=&quot;invalid-feedback&quot;&gt;
                            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_collaborators_categories&quot;, &quot;name_en_tmpl&quot;); ?&gt;
                &lt;/div&gt;
                &lt;div class=&quot;&lt;?php if($tNGs-&gt;displayFieldError(&quot; properties_collaborators_categories&quot;, &quot;name_es_tmpl&quot; ) !=&#039;&#039; ) { ?&gt;has-error
                    &lt;?php } ?&gt;&quot;&gt;
                    &lt;label for=&quot;name_es_tmpl&quot; class=&quot;form-label required&quot;&gt;
                        &lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
                    &lt;div class=&quot;input-group&quot;&gt;
                        &lt;span class=&quot;input-group-text&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/es.svg&quot; alt=&quot;&quot; height=&quot;15&quot;&gt;&lt;/span&gt;
                        &lt;input type=&quot;text&quot; name=&quot;name_es_tmpl&quot; id=&quot;name_es_tmpl&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rstemplates[&#039;name_es_tmpl&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
                        &lt;div class=&quot;invalid-feedback&quot;&gt;
                            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_collaborators_categories&quot;, &quot;name_es_tmpl&quot;); ?&gt;
                &lt;/div&gt;
            &lt;/div&gt;&lt;!-- end card-body --&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-lg-3&quot;&gt;
        &lt;div class=&quot;card position-relative&quot;&gt;
            &lt;div class=&quot;card-body&quot;&gt;
                &lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
                    &lt;input type=&quot;checkbox&quot; name=&quot;week_tmpl&quot; id=&quot;week_tmpl&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp(KT_escapeAttribute($row_rstemplates[&#039;week_tmpl&#039;]),&quot;1&quot;))) {echo &quot;checked&quot; ;} ?&gt;&gt;
                    &lt;label class=&quot;form-check-label&quot; for=&quot;week_tmpl&quot;&gt;
                        &lt;?php __(&#039;Email semanal&#039;); ?&gt;&lt;/label&gt;
                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;week_tmpl&quot;); ?&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:364
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
ob_start();
include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mailtemplates/template_semanal.html&#039;);
$html = ob_get_contents();
ob_end_clean();

////////////////////
$body  = &quot;&lt;p&gt;&quot;.$translate[$client[&#039;idioma_cli&#039;]][&#039;Hola&#039;].&quot; &quot; . trim($client[&#039;nombre_cli&#039;]) . &quot;,&lt;/p&gt;&quot;;


$body  .= &quot;&lt;p&gt;&quot;.$translate[$client[&#039;idioma_cli&#039;]][&#039;Newsletter Autom&aacute;tica - Texto - &#039;.rand(1, 3)].&quot;&lt;/p&gt;&quot;;
////////////////////
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
ob_start();
include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mailtemplates/template_semanal.html&#039;);
$html = ob_get_contents();
ob_end_clean();

$templates_Query = &quot;
    SELECT
       subject_&quot;.$client[&#039;idioma_cli&#039;].&quot;_tmpl as asunto,
       content_&quot;.$client[&#039;idioma_cli&#039;].&quot;_tmpl as texto
    FROM templates
    WHERE week_tmpl = 1
        AND subject_&quot;.$client[&#039;idioma_cli&#039;].&quot;_tmpl != &#039;&#039;

    ORDER BY RAND()

    LIMIT 1

&quot;;

$templates = mysqli_query($inmoconn, $templates_Query);
$templates = mysqli_fetch_assoc($templates);

////////////////////

if($templates[&#039;texto&#039;] != &#039;&#039;) {
    $templates[&#039;texto&#039;] = preg_replace(&#039;/{{CLIENT}}/&#039;, $client[&#039;nombre_cli&#039;] , $templates[&#039;texto&#039;]);
    $body  = &#039;&lt;div style=&quot;padding-left:10px&quot;&gt;&#039;.$templates[&#039;texto&#039;].&#039;&lt;/div&gt;&#039;;
}
else {
    $body  = &quot;&lt;p&gt;&quot;.$translate[$client[&#039;idioma_cli&#039;]][&#039;Hola&#039;].&quot; &quot; . trim($client[&#039;nombre_cli&#039;]) . &quot;,&lt;/p&gt;&quot;;
    $body  .= &quot;&lt;p&gt;&quot;.$translate[$client[&#039;idioma_cli&#039;]][&#039;Newsletter Autom&aacute;tica - Texto - &#039;.rand(1, 3)].&quot;&lt;/p&gt;&quot;;
}

////////////////////
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-search-criteria.php:437
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$subject = $translate[$client[&#039;idioma_cli&#039;]][&#039;Newsletter Autom&aacute;tica - Asunto - &#039;.rand(1, 6)].&#039; - &#039;. $_SERVER[&#039;HTTP_HOST&#039;]; // &iquest;Requere un subject personalizado?
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($templates[&#039;asunto&#039;]) {
    $templates[&#039;asunto&#039;] = preg_replace(&#039;/{{CLIENT}}/&#039;, $client[&#039;nombre_cli&#039;] , $templates[&#039;asunto&#039;]);
    $subject = $templates[&#039;asunto&#039;].&#039; - &#039;. $_SERVER[&#039;HTTP_HOST&#039;];
}
else {
    $subject = $translate[$client[&#039;idioma_cli&#039;]][&#039;Newsletter Autom&aacute;tica - Asunto - &#039;.rand(1, 6)].&#039; - &#039;. $_SERVER[&#039;HTTP_HOST&#039;];
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>