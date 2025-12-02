<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 19-12-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en el envío de correos desde clientes interesados</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> En el formulario de la propiedad no se muestran todos los tabs</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error en formulario vender propiedad</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Bug propiedades duplicadas e imágenes sin procesar</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Error al ordenar las tablas por fecha</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el envío de correos desde clientes interesados
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:466
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &quot;clients-send.php?ids=&quot;+values+&#039;&amp;email=&#039;+$(&#039;#email_cli&#039;).val()+&#039;&amp;comment=&#039;+$(&#039;#comment&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;tipo=1&amp;lang=&#039; + sendLang + &#039;&amp;usr=&#039; + idClient,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &quot;clients-send.php?ids=&quot;+values+&#039;&amp;email=&#039;+$(&#039;#email_cli&#039;).val()+&#039;&amp;comment=&#039;+encodeURIComponent($(&#039;#comment&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; ))+&#039;&amp;tipo=1&amp;lang=&#039; + sendLang + &#039;&amp;usr=&#039; + idClient,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> En el formulario de la propiedad no se muestran todos los tabs
    </h6>
    <div class="card-body">
        Sustituir el archivo <code>/intramedianet/includes/assets/css/app.css</code> por el de esta versión.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en formulario vender propiedad
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/vender/send-quote.php:26
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
INSERT INTO `prop_user`(`id_prp`, `name_prp`, `email_prp`, `phone_prp`, `estado_prp`, `tipo_prp`, `pais_prp`, `provincia_prp`, `ciudad_prp`, `zona_prp`, `direccion_prp`, `cp_prp`, `habitaciones_prp`, `banos_prp`, `piscina_prp`, `tiempo_prp`, `m2_prp`, `m2p_prp`, `precio_prp`, `reducido_prp`, `cercamar_prp`, `vistasmar_prp`, `exclusiva_prp`, `imagenes_prp`, `consulta_prp`, `fecha_prp`) VALUES

(NULL,&#039;&quot;.simpleSanitize(($_GET[&#039;name&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;email&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;telefono&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;sts&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;Type&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;locun2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lopr2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;loct2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lozn2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;address&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;zip&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bd&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bt&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;pool&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;timing&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2p&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;price&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;rp&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;cs&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;sw&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;ep&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;imagesinput&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;comment&#039;])).&quot;&#039;,&#039;&quot;.mysql_real_escape_string(date(&quot;Y-m-d H:i:s&quot;)).&quot;&#039;)
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
INSERT INTO `prop_user`(`id_prp`, `name_prp`, `email_prp`, `phone_prp`, `estado_prp`, `tipo_prp`, `pais_prp`, `provincia_prp`, `ciudad_prp`, `zona_prp`, `direccion_prp`, `cp_prp`, `habitaciones_prp`, `banos_prp`, `piscina_prp`, `tiempo_prp`, `m2_prp`, `m2p_prp`,  `exclusiva_prp`, `imagenes_prp`, `consulta_prp`, `fecha_prp`) VALUES

(NULL,&#039;&quot;.simpleSanitize(($_GET[&#039;name&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;email&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;telefono&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;sts&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;Type&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;locun2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lopr2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;loct2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;lozn2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;address&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;zip&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bd&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;bt&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;pool&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;timing&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;m2p&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;price&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;ep&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;imagesinput&#039;])).&quot;&#039;,&#039;&quot;.simpleSanitize(($_GET[&#039;comment&#039;])).&quot;&#039;,&#039;&quot;.mysql_real_escape_string(date(&quot;Y-m-d H:i:s&quot;)).&quot;&#039;)
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug propiedades duplicadas e imágenes sin procesar
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:497
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
foreach ($properties as $key =&gt; $value) {

    $theFavsDB = getRecords(&quot;
    SELECT COUNT(id) AS num_favorites
    FROM users_favorites
    WHERE user = &#039;&quot;.stripslashes(mysql_real_escape_string($_SESSION[&#039;kt_login_id&#039;])).&quot;&#039;
    AND property = &#039;&quot;.stripslashes(mysql_real_escape_string($properties[$key][&#039;id_prop&#039;])).&quot;&#039;
    &quot;);

    $theFavs = explode(&quot;,&quot;,$_COOKIE[&#039;fav&#039;]);

    if (in_array($properties[$key][&#039;id_prop&#039;], $theFavs ) || $theFavsDB[0][&#039;num_favorites&#039;]==1) {
        $favVal = 1;
    } else {
        $favVal = 0;
    }

    array_push($properties[$key], array(&#039;favorito&#039; =&gt; $favVal));

    savelogprop($properties[$key][&#039;id_prop&#039;], &#039;1&#039;);

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
foreach ($properties as $key =&gt; $value) {

    if(!$value){
        continue;
    }

    $theFavsDB = getRecords(&quot;
    SELECT COUNT(id) AS num_favorites
    FROM users_favorites
    WHERE user = &#039;&quot;.stripslashes(mysql_real_escape_string($_SESSION[&#039;kt_login_id&#039;])).&quot;&#039;
    AND property = &#039;&quot;.stripslashes(mysql_real_escape_string($properties[$key][&#039;id_prop&#039;])).&quot;&#039;
    &quot;);

    $theFavs = explode(&quot;,&quot;,$_COOKIE[&#039;fav&#039;]);

    if (in_array($properties[$key][&#039;id_prop&#039;], $theFavs ) || $theFavsDB[0][&#039;num_favorites&#039;]==1) {
        $favVal = 1;
    } else {
        $favVal = 0;
    }

    array_push($properties[$key], array(&#039;favorito&#039; =&gt; $favVal));

    savelogprop($properties[$key][&#039;id_prop&#039;], &#039;1&#039;);

}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-dupli.php:403
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (preg_match(&#039;/https?:\/\//&#039;, $row_rsRegistros[&#039;image_img&#039;])) {
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsInsert = &quot;INSERT INTO `properties_images`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, &#039;$prop&#039;, &#039;&quot;.$row_rsRegistros[&#039;image_img&#039;].&quot;&#039;, &#039;&quot;.$row_rsRegistros[&#039;order_img&#039;].&quot;&#039;)&quot;;
    $rsInsert = mysql_query($query_rsInsert, $inmoconn) or die(mysql_error());
    generateThumbnails($row_rsRegistros[&#039;image_img&#039;], mysql_insert_id());
} else {
    $ext = pathinfo($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$row_rsRegistros[&#039;image_img&#039;], PATHINFO_EXTENSION);
    $newname = uniqid(&#039;d&#039;).&#039;&#039;. uniqid().&#039;.&#039;.$ext;
    copy($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$row_rsRegistros[&#039;image_img&#039;], $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$newname);
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsInsert = &quot;INSERT INTO `properties_images`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, &#039;$prop&#039;, &#039;&quot;.$newname.&quot;&#039;, &#039;&quot;.$row_rsRegistros[&#039;order_img&#039;].&quot;&#039;)&quot;;
    $rsInsert = mysql_query($query_rsInsert, $inmoconn) or die(mysql_error());
    generateThumbnails($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039; . $newname, mysql_insert_id(), &#039;properties&#039;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (preg_match(&#039;/https?:\/\//&#039;, $row_rsRegistros[&#039;image_img&#039;])) {
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsInsert = &quot;INSERT INTO `properties_images`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, &#039;$prop&#039;, &#039;&quot;.$row_rsRegistros[&#039;image_img&#039;].&quot;&#039;, &#039;&quot;.$row_rsRegistros[&#039;order_img&#039;].&quot;&#039;)&quot;;
    $rsInsert = mysql_query($query_rsInsert, $inmoconn) or die(mysql_error());
    generateThumbnails($row_rsRegistros[&#039;image_img&#039;], mysql_insert_id());
} else {
    $ext = pathinfo($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$row_rsRegistros[&#039;image_img&#039;], PATHINFO_EXTENSION);
    $newname = uniqid(&#039;d&#039;).&#039;&#039;. uniqid().&#039;.&#039;.$ext;
    copy($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$row_rsRegistros[&#039;image_img&#039;], $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039;.$newname);
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsInsert = &quot;INSERT INTO `properties_images`  (`id_img`, `property_img`, `image_img`, `order_img`) VALUES (NULL, &#039;$prop&#039;, &#039;&quot;.$newname.&quot;&#039;, &#039;&quot;.$row_rsRegistros[&#039;order_img&#039;].&quot;&#039;)&quot;;
    $rsInsert = mysql_query($query_rsInsert, $inmoconn) or die(mysql_error());
    generateThumbnails($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/&#039; . $newname, mysql_insert_id(), &#039;properties&#039;);
}
$query_rsUpdate = &quot;UPDATE `properties_images` SET procesada_img = 1 WHERE id_img = &quot;.mysql_insert_id().&quot;;&quot;;
$rsUpdate = mysql_query($query_rsUpdate, $inmoconn) or die(mysql_error());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al ordenar las tablas por fecha
    </h6>
    <div class="card-body">
        Sustituir el archivo <code>/intramedianet/includes/assets/js/app.js</code> por el de esta versión.
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js:936
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&quot;bServerSide&quot;: false,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&quot;bServerSide&quot;: false,
&quot;columnDefs&quot;: [
  { &quot;type&quot;: &quot;date-euro&quot;, targets: 3 }
]
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js:949
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&quot;bServerSide&quot;: false,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&quot;bServerSide&quot;: false,
&quot;columnDefs&quot;: [
  { &quot;type&quot;: &quot;date-euro&quot;, targets: 4 }
]
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>