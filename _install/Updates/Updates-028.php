<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 10-09-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Bug en las traducciones que incluyen %s</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Redirección automática al idioma del usuario la primera vez que se entra en la web</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Añadido TeamChat al panel</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug en las traducciones que incluyen %s
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/translate/traducciones.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($_SERVER[&#039;REQUEST_METHOD&#039;] == &quot;POST&quot;) {

    $ret = &#039;&#039;;
    $ret .= &quot;&lt;?php\n&quot;;
    foreach($_POST as $key =&gt; $value) {
        if($key != &#039;update&#039;) {
            $key = str_replace(&#039;_&#039;, &#039; &#039;, $key);
            if (in_array($key, array(&quot;NombreMeses&quot;, &quot;NombreMesesCortos&quot;, &quot;NombreDias&quot;, &quot;NombreDiasCortos&quot;))) {
                $ret .= &#039;$langStr[&quot;&#039;.$key.&#039;&quot;] = \&#039;&#039;. stripslashes($value).&#039;\&#039;;&#039;.&quot;\n&quot;;
            } else {
                $value = str_replace(&#039;&quot;&#039;, &#039;\&quot;&#039;, stripslashes($value));
                $ret .= &#039;$langStr[&quot;&#039;.$key.&#039;&quot;] = &quot;&#039;. $value .&#039;&quot;;&#039;.&quot;\n&quot;;
            }
        }
    }
    $ret .= &quot;?&gt;&quot;;

    $myFile = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/resources/lang_&quot;.$_GET[&#039;lang&#039;].&quot;.php&quot;;
    $fh = fopen($myFile, &#039;w&#039;) or die(&quot;no se puede abrir el archivo de idioma&quot;);
    fwrite($fh, $ret);
    fclose($fh);

    header(&quot;Location: traducciones.php?lang=&quot;.$_GET[&#039;lang&#039;].&quot;&amp;u=ok&quot;);

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($_SERVER[&#039;REQUEST_METHOD&#039;] == &quot;POST&quot;) {

    require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/resources/lang_&quot;.$_GET[&#039;lang&#039;].&quot;.php&quot;);
    $langStr = array_merge($langStr, $_POST);

    $ret = &#039;&#039;;
    $ret .= &quot;&lt;?php\n&quot;;
    foreach($langStr as $key =&gt; $value) {
        if($key != &#039;update&#039;) {
            $key = str_replace(&#039;_&#039;, &#039; &#039;, $key);
            if (in_array($key, array(&quot;NombreMeses&quot;, &quot;NombreMesesCortos&quot;, &quot;NombreDias&quot;, &quot;NombreDiasCortos&quot;))) {
                $ret .= &#039;$langStr[&quot;&#039;.$key.&#039;&quot;] = \&#039;&#039;. stripslashes($value).&#039;\&#039;;&#039;.&quot;\n&quot;;
            } else {
                $value = str_replace(&#039;&quot;&#039;, &#039;\&quot;&#039;, stripslashes($value));
                $ret .= &#039;$langStr[&quot;&#039;.$key.&#039;&quot;] = &quot;&#039;. $value .&#039;&quot;;&#039;.&quot;\n&quot;;
            }
        }
    }
    $ret .= &quot;?&gt;&quot;;

    $myFile = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &quot;/resources/lang_&quot;.$_GET[&#039;lang&#039;].&quot;.php&quot;;
    $fh = fopen($myFile, &#039;w&#039;) or die(&quot;no se puede abrir el archivo de idioma&quot;);
    fwrite($fh, $ret);
    fclose($fh);

    header(&quot;Location: traducciones.php?lang=&quot;.$_GET[&#039;lang&#039;].&quot;&amp;u=ok&quot;);

}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Redirección automática al idioma del usuario la primera vez que se entra en la web
    </h6>
    <div class="card-body">
        Añadir la carpeta <code>/includes/ipinfodb-php</code>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:48
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once(&#039;modules/init.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once(&#039;modules/init.php&#039;);

if ($_COOKIE[&#039;viewlocation&#039;] != &#039;1&#039;) {
    setcookie(&#039;viewlocation&#039;, &#039;1&#039;, mktime(21,00,0,12,31,2030),&quot;/&quot;, &quot;&quot;,0);

    require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/ipinfodb-php/class.IPInfoDB.php&#039; );

    // Load the class
    $ipinfodb = new IPInfoDB(&#039;a5e5ac8ff9078bf8a4cfcb94483f11e517eedc666d6fb6cb8ace70c4e7fc7bb7&#039;);

    $results = $ipinfodb-&gt;getCity($_SERVER[&#039;REMOTE_ADDR&#039;]);

    $lang_location = strtolower($results[&#039;countryCode&#039;]);

    if(in_array($lang_location, $languages) &amp;&amp; $lang != $lang_location &amp;&amp; !preg_match(&#039;/\.html/&#039;, $_SERVER[&#039;REQUEST_URI&#039;])){

        $url_lang_location = ($urlStart == &quot;/&quot; ? &quot;/&quot;.$lang_location.$_SERVER[&#039;REQUEST_URI&#039;] : str_replace(&#039;/&#039; . $lang . &#039;/&#039;, &#039;/&#039; . $lang_location . &#039;/&#039;, $_SERVER[&#039;REQUEST_URI&#039;]));

        if( $urlStr[$urlStr[$seccion][&quot;master&quot;]][$lang] != &quot;&quot; ){
            $url_lang_location = str_replace(&#039;/&#039; . $urlStr[$urlStr[$seccion][&quot;master&quot;]][$lang] . &#039;/&#039;, &#039;/&#039; . $urlStr[$urlStr[$seccion][&quot;master&quot;]][$lang_location] . &#039;/&#039;, $url_lang_location);

            header(&quot;HTTP/1.1 302 Moved Permanently&quot;);
            header(&quot;Location: &quot; . $url_lang_location);
            die();
        }
        else{
            header(&quot;HTTP/1.1 302 Moved Permanently&quot;);
            header(&quot;Location: /&quot;.$lang_location);
            die();
        }

    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido TeamChat al panel
    </h6>
    <div class="card-body">
        En el archivo <code>/intramedianet/includes/inc.footer.php</code> eliminar las líneas 109 y 54 para activarlo.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>