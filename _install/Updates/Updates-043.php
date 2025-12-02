<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 30-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error al añadir citas al calendario</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajeste de la longitud máxima de la dirección de los inmuebles en el exportardor de Rightmove</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error al compartir en Facebook</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Bug al ocultar columnas en listado de propietatrios y compradores</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al añadir citas al calendario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/modals-add.php:8
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;form id=&quot;form1&quot; action=&quot;/intramedianet/properties/properties-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;form id=&quot;formProp&quot; action=&quot;/intramedianet/properties/properties-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/modals-add.php:31
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;form id=&quot;form1&quot; action=&quot;/intramedianet/properties/clients-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;form id=&quot;formCli&quot; action=&quot;/intramedianet/properties/clients-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/modals-add.php:71
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;form id=&quot;form1&quot; action=&quot;/intramedianet/properties/owners-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;form id=&quot;formOwn&quot; action=&quot;/intramedianet/properties/owners-form.php&quot; method=&quot;post&quot; class=&quot;validate&quot;&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajeste de la longitud máxima de la dirección de los inmuebles en el exportardor de Rightmove
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/rightmove.php:123
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$return .= $calle . &#039;|&#039;; // Calle STREET_NAME
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$return .= substr($calle, 0, 100) . &#039;|&#039;; // Calle STREET_NAME
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al compartir en Facebook
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:50
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
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
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug al ocultar columnas en listado de propietatrios y compradores
    </h6>
    <div class="card-body">
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-list.js:58
/intramedianet/properties/_js/clients-list.js:59
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var oSettings = $(&#039;#records-tables&#039;).dataTable().fnSettings();
for ( var i=0 ; i&lt;oSettings.aoPreSearchCols.length ; i++ ){
    if(oSettings.aoPreSearchCols[i].sSearch.length&gt;0){
        $(&quot;thead input&quot;)[i].value = oSettings.aoPreSearchCols[i].sSearch;
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var oSettings = $(&#039;#records-tables&#039;).dataTable().fnSettings();
var x= 0;
for ( var i=0 ; i&lt;oSettings.aoPreSearchCols.length ; i++ ){
    if (oSettings.aoColumns[i].bVisible == false) {
        x++;
    }
    if(oSettings.aoPreSearchCols[i].sSearch.length&gt;0){

        $(&quot;thead input&quot;)[i-x].value = oSettings.aoPreSearchCols[i].sSearch;
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>