<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 10-11-2024</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Error al mapear ciudades</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Error en el listado de propiedades</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Error de sintaxis en zonas</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Error al ordenar imágenes de inmuebles</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Eliminar inmuebles importados de Fotocasa</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Añadida corta estancia a exportador de idealista</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-bug text-danger"></i> Actualizado las funciones de en/descriptado</a></li>
        <li><a href="#sec8"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes en el importador XML Mediaelx</a></li>
        <li><a href="#sec9"><i class="fas fz-fw fa-bug text-danger"></i> Bug url inmueblews en en el mapa web</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al mapear ciudades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc3all-data.php:273
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if(isset($aRow[ $aColumns[$i] ]))
    $row[] = $aRow[ $aColumns[$i] ];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (isset($aRow[$aColumns[$i]])) {
     $row[] = $aRow[$aColumns[$i]];
} else {
     $row[] = &#039;&#039;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el listado de propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intamedianet/properties/properties-data.php:344
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if(isset($aRow[ $aColumns[$i] ]))
    $row[] = number_format($aRow[ $aColumns[$i] ], 0 , &#039;,&#039;, &#039;.&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if(isset($aRow[ $aColumns[$i] ])) {
    $row[] = number_format($aRow[ $aColumns[$i] ], 0 , ',', '.');
}
else {
    $row[] = "";
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error de sintaxis en zonas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/zonas/properties.php:238
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$secc = &quot;activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0AND image_img != &#039;&#039; AND force_hide_prop != 1&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$secc = &quot;activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND image_img != &#039;&#039; AND force_hide_prop != 1&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/ciudades/properties.php:120
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (count($matches[0] &gt; 0)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (count($matches[0]) &gt; 0) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/ciudades/properties.php:215
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$secc = &quot;activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0AND image_img != &#039;&#039; AND force_hide_prop != 1&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$secc = &quot;activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND image_img != &#039;&#039; AND force_hide_prop != 1&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al ordenar imágenes de inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_list.php:74
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsImagenes[&#039;id_img&#039;] ?&gt;&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsImagenes[&#039;id_img&#039;] ?&gt;&quot; data-id=&quot;&lt;?php echo $row_rsImagenes[&#039;id_img&#039;] ?&gt;&quot;&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminar inmuebles importados de Fotocasa
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Kyero.php:195
/intramedianet/xml/importadores/Inmovilla.php:427
/intramedianet/xml/importadores/Mediaelx.php:285
/intramedianet/xml/importadores/Redsp.php:209
/intramedianet/xml/importadores/Resales.php:263
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsXMLprop = &quot;DELETE FROM properties_properties WHERE id_prop = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsXMLprop = mysqli_query($inmoconn,$query_rsXMLprop) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLprop);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsXMLprop = &quot;DELETE FROM properties_properties WHERE id_prop = &#039;&quot;.$row_rsPropsDel[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsXMLprop = mysqli_query($inmoconn,$query_rsXMLprop) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsXMLprop);

include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/fotocasa/FotocasaAPI.php&#039;);

$result = FotocasaAPI::getPublicationProperty($fotocasaDatos[&quot;api_key&quot;]);
$result = json_decode($result,1);
foreach ( $result as $key =&gt; $prop) {
    if( $prop[&quot;ExternalId&quot;] == $row_rsPropsDel[&#039;id_prop&#039;] ) {
        $resutl = FotocasaAPI::deletePropertyByPortal( (int)$row_rsPropsDel[&#039;id_prop&#039;], 1, $fotocasaDatos[&quot;api_key&quot;]);
        $_SESSION[&#039;fc_status&#039;] = $result;
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadida corta estancia a exportador de idealista
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:69
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
towns.name_en_loc4,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
towns.name_en_loc4,
operacion_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista-json.php:337
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($fieldsJSN-&gt;featuresConservation != &#039;&#039;) {
    $Content .= &#039;&quot;featuresConservation&quot;: &quot;&#039; . $fieldsJSN-&gt;featuresConservation . &#039;&quot;,&#039;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($fieldsJSN-&gt;featuresConservation != &#039;&#039;) {
    $Content .= &#039;&quot;featuresConservation&quot;: &quot;&#039; . $fieldsJSN-&gt;featuresConservation . &#039;&quot;,&#039;;
}
if ($row_idealista[&#039;operacion_prop&#039;] == 3) {
    $Content .= &#039;&quot;featuresSeasonalRental&quot;: true, &#039;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Actualizado las funciones de en/descriptado
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:17
/intramedianet/properties/clients-send-search-criteria.php:14
/intramedianet/properties/clients-send.php:16
/intramedianet/properties/clients-whatsapp.php:16
/intramedianet/properties/owners-send-report.php:15
/intramedianet/properties/properties-form.php:79
/intramedianet/properties/properties-owner-data.php:27
            </code>
        </pre>
        Sustituir la función encryptIt por:
        <pre>
            <code class="php">
function encryptIt($idCli, $encryptionKey = &#039;DLusjkq6kkzRUbY7TVc7YH2RcT2&#039;)
{
    global $_SERVER;
    $ciphering = &quot;AES-128-CTR&quot;;
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_key = $_SERVER[&#039;HTTP_HOST&#039;];
    $encryption_iv = $_SERVER[&#039;HTTP_HOST&#039;];

    $encryption = openssl_encrypt($idCli, $ciphering,
            $encryption_key, $options, $encryption_iv);
    return $encryption;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/mail_partials/unsubscribe.php:18
            </code>
        </pre>
        Sustituir la función decryptIt por:
        <pre>
            <code class="php">
function decryptIt($encryption, $key = &quot;DLusjkq6kkzRUbY7TVc7YH2RcT2&quot;) {
    global $_SERVER;
    $ciphering = &quot;AES-128-CTR&quot;;
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $decryption_key = $_SERVER[&apos;HTTP_HOST&apos;];
    $decryption_iv = $_SERVER[&apos;HTTP_HOST&apos;];

    $decryption=openssl_decrypt ($encryption, $ciphering,
        $decryption_key, $options, $decryption_iv);

    return $decryption;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec8">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes en el importador XML Mediaelx
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/importadores/Mediaelx.php:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$poolID = setPoolProp((array)$property-&gt;pool);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (isset($property-&gt;pool) &amp;&amp; !empty(trim((string)$property-&gt;pool)))  {
    $poolID = setPoolProp((array)$property-&gt;pool);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_mediaelx.php:316
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
query_rsPool = &quot;SELECT id_feat, feature_en_feat FROM properties_features_priv WHERE LOWER(feature_en_feat) = &apos;&quot; . strtolower(trim((string)$feature-&gt;en)) . &quot;&apos;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsPool = &quot;SELECT id_feat, feature_en_feat FROM properties_features_priv WHERE LOWER(feature_en_feat) = &apos;&quot; . mysqli_real_escape_string($inmoconn, strtolower(trim((string)$feature-&gt;en))) . &quot;&apos;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec9">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug url inmueblews en en el mapa web
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/sitemap/view/index.tpl:38
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;{$urlStart}{$url_property}/{$properties[ft].id_prop}/{$properties[ft].type|slug}/{$properties[ft].sale|slug}/{$properties[ft].country|slug}/{$properties[ft].area|slug}/{$properties[ft].town|slug}/&quot;&gt;{$lng_ref_}: {$properties[ft].ref} - {$properties[ft].type} - {$properties[ft].sale} - {$properties[ft].area} - {$properties[ft].town}&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;{propURL($properties[ft].id_prop, $lang)}&quot;&gt;{$lng_ref_}: {$properties[ft].ref} - {$properties[ft].type} - {$properties[ft].sale} - {$properties[ft].area} - {$properties[ft].town}&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>