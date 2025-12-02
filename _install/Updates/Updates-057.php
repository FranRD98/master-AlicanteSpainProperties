<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 14-01-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> No remplaza el snipet {COLOR} cuando se envía el email de bajada de precio</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error exportador de Habitaclia</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error en el exportador de idealista</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Añadidos nuevos campos al exportador de Ubiflow</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO - PageSpeed</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Bug Seguimiento de envíos en Clientes</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Error en cambio de precio al elegir Status</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> Mejora requerida por Rightmove y Zoopla por el número de imágenes</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> No remplaza el snipet {COLOR} cuando se envía el email de bajada de precio
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:595
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
global $_POST, $_SESSION, $oldprice, $database_inmoconn, $inmoconn;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
global $_POST, $_SESSION, $oldprice, $database_inmoconn, $inmoconn, $mailColor;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error exportador de Habitaclia
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/habitaclia.php:91
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if($row_rsProperties[&#039;energia_prop&#039;] != &#039;&#039; &amp;&amp; $row_rsProperties[&#039;energia_prop&#039;] != &#039;X&#039; &amp;&amp; $row_rsProperties[&#039;energia_prop&#039;] != &#039;0&#039;) { ?&gt;
&lt;calif_energetica&gt;&lt;?php echo $row_rsProperties[&#039;energia_prop&#039;] ?&gt;&lt;/calif_energetica&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php
    $energia_prop = &quot;ZZ&quot;;
    if($row_rsProperties[&#039;energia_prop&#039;] != &#039;&#039; &amp;&amp; $row_rsProperties[&#039;energia_prop&#039;] != &#039;X&#039; &amp;&amp; $row_rsProperties[&#039;energia_prop&#039;] != &#039;0&#039;) {
        $energia_prop = $row_rsProperties[&#039;energia_prop&#039;];
    }
?&gt;
&lt;calif_energetica&gt;&lt;?php echo $energia_prop; ?&gt;&lt;/calif_energetica&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el exportador de idealista
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/idealista.php:149
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;code&gt;&lt;/code&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;code&gt;&quot; . $idealistaCustomerCode. &quot;&lt;/code&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadidos nuevos campos al exportador de Ubiflow
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:65
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ubiflowFTP = &#039;ftp.zoopla.com&#039;;
$ubiflowFTPuser = &#039;000000000&#039;;
$ubiflowFTPpass = &#039;000000000&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ubiflowFTP = &#039;ftp.zoopla.com&#039;;
$ubiflowFTPuser = &#039;000000000&#039;;
$ubiflowFTPpass = &#039;000000000&#039;;
$ubiflowAddressStreet = &#039;&#039;;
$ubiflowAddressCP = &#039;&#039;;
$ubiflowAddressVille = &#039;&#039;;
$ubiflowAddressCountry = &#039;&#039;;
$ubiflowContactName = &#039;&#039;;
$ubiflowContactEmail = &#039;&#039;;
$ubiflowContactPhone = &#039;&#039;;
$ubiflowContactMobilePhone = &#039;&#039;;
$ubiflowMostrarDireccion = &quot;false&quot;;
            </code>
        </pre>
        <hr>
        Susutituir el archivo <code>/xml/ubiflow.php</code> por el de esta versión.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora SEO - PageSpeed
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$isInsights = false;
if (strpos($_SERVER [&#039;HTTP_USER_AGENT&#039;], &#039;Insights&#039;) !== false) {
    $isInsights = true;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$isInsights = false;
if (strpos($_SERVER [&#039;HTTP_USER_AGENT&#039;], &#039;Insights&#039;) !== false || strpos($_SERVER [&#039;HTTP_USER_AGENT&#039;], &#039;Chrome-Lighthouse&#039;) !== false) {
    $isInsights = true;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug Seguimiento de envíos en Clientes
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
function closetags($html) {
  preg_match_all(&#039;#&lt;([a-z]+)(?: .*)?(?&lt;![/|/ ])&gt;#iU&#039;, $html, $result);
  $openedtags = $result[1];
  preg_match_all(&#039;#&lt;/([a-z]+)&gt;#iU&#039;, $html, $result);
  $closedtags = $result[1];
  $len_opened = count($openedtags);
  if (count($closedtags) == $len_opened) {
      return $html;
  }
  $openedtags = array_reverse($openedtags);
  for ($i=0; $i &lt; $len_opened; $i++) {
      if (!in_array($openedtags[$i], $closedtags)) {
          $html .= &#039;&lt;/&#039;.$openedtags[$i].&#039;&gt;&#039;;
      } else {
          unset($closedtags[array_search($openedtags[$i], $closedtags)]);
      }
  }
  return $html;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1467
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;?php echo $row_rsEmails[&#039;text_log&#039;]; ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;?php echo closetags($row_rsEmails[&#039;text_log&#039;]); ?&gt;&lt;/td&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en cambio de precio al elegir Status
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:300
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script&gt;

$(&#039;#st&#039;).change(function (e) {
  if($(&#039;#st&#039;).val() == &#039;&#039;) {
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st&#039;).val() == &#039;3&#039; || $(&#039;#st&#039;).val() == &#039;4&#039;) {  // RENTAL
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 0, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 0, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st&#039;).val() == &#039;1&#039; || $(&#039;#st&#039;).val() == &#039;2&#039;) {  // SALE
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 0, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 0, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if (/(,)/.test($(&#039;#st&#039;).val())) {
      $(&#039;#prds&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
}).change();

$(&#039;#st1&#039;).change(function (e) {
  if($(&#039;#st1&#039;).val() == &#039;&#039;) {
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st1&#039;).val() == &#039;3&#039; || $(&#039;#st1&#039;).val() == &#039;4&#039;) {  // RENTAL
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 0, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 0, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if($(&#039;#st1&#039;).val() == &#039;1&#039; || $(&#039;#st1&#039;).val() == &#039;2&#039;) {  // SALE
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 0, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 0, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
  if (/(,)/.test($(&#039;#st1&#039;).val())) {
      $(&#039;#prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, 1, 1, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
      $(&#039;#prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, 1, 1, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
  }
}).change();
var idprop = &#039;{$property[0].id_prop}&#039;;

&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script&gt;
$(&#039;#st, #st1&#039;).change(function (e) {
    if( Array.isArray( $(this).val() ) ){
        var $rental = ($.inArray(&#039;3&#039;,$(this).val()) != -1 || $.inArray(&#039;4&#039;,$(this).val()) != -1 ) ? 1: 0, // RENTAL
            $resale = ($.inArray(&#039;1&#039;,$(this).val()) != -1 || $.inArray(&#039;2&#039;,$(this).val()) != -1) ? 1: 0; // SALE
    } else {
        var $rental = ($(this).val() == 3 || $(this).val() == 4 ) ? 1: 0, // RENTAL
            $resale = ($(this).val() == 1 || $(this).val() == 2) ? 1: 0; // SALE
    }
    $(&#039;#prds, #prds1&#039;).html(returnPrices(&#039;{$smarty.get.prds}&#039;, $rental, $resale, &#039;{$prDesd|escape:&quot;quotes&quot;}&#039;)).change();
    $(&#039;#prhs, #prhs1&#039;).html(returnPrices(&#039;{$smarty.get.prhs}&#039;, $rental, $resale, &#039;{$prHast|escape:&quot;quotes&quot;}&#039;)).change();
}).change();

var idprop = &#039;{$property[0].id_prop}&#039;;

&lt;/script&gt;
            </code>
        </pre>
        <hr>
        Susutituir el archivo <code>/js/source/precios.js</code> por el de esta versión y recompilar.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card ">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora requerida por Rightmove y Zoopla por el número de imágenes
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `exportado_rightmove_prop` INT(1) NULL DEFAULT 0 AFTER `vista360_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `exportado_zoopla_prop` INT(1) NULL DEFAULT 0 AFTER `exportado_rightmove_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_upload.php:160
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsMax =&quot;SELECT MAX(order_img) + 1  as max FROM properties_images WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMax = mysql_query($query_rsMax, $inmoconn) or die(mysql_error());
$row_rsMax = mysql_fetch_assoc($rsMax);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsMax =&quot;SELECT MAX(order_img) + 1  as max, property_img FROM properties_images WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMax = mysql_query($query_rsMax, $inmoconn) or die(mysql_error());
$row_rsMax = mysql_fetch_assoc($rsMax);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$row_rsMax[&#039;property_img&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_order.php:27
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_images` SET `order_img` = &quot;. ($position + 1) .&quot; WHERE `id_img` = &quot;.$item.&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_images` SET `order_img` = &quot;. ($position + 1) .&quot; WHERE `id_img` = &quot;.$item.&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsMax =&quot;SELECT property_img FROM properties_images WHERE id_img = &#039;&quot;.$item.&quot;&#039;&quot;;
$rsMax = mysql_query($query_rsMax, $inmoconn) or die(mysql_error());
$row_rsMax = mysql_fetch_assoc($rsMax);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$row_rsMax[&#039;property_img&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_del.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;DELETE FROM `properties_images` WHERE `properties_images`.`id_img` = &#039;&quot;.$_GET[&#039;id&#039;].&quot;&#039; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;DELETE FROM `properties_images` WHERE `properties_images`.`id_img` = &#039;&quot;.$_GET[&#039;id&#039;].&quot;&#039; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$prop.&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_del_mult.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;DELETE FROM `properties_images` WHERE `properties_images`.`id_img` = &#039;&quot;.$id.&quot;&#039; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;DELETE FROM `properties_images` WHERE `properties_images`.`id_img` = &#039;&quot;.$id.&quot;&#039; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;0&#039;, `exportado_zoopla_prop` = &#039;0&#039; WHERE `id_prop` = &quot;.$prop.&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/rightmove.php:194
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$remote_file_contents = file_get_contents($row_rsImages[&#039;image_img&#039;]);

$local_file_path = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/xml/rightmove/&#039; . $imgName;

file_put_contents($local_file_path, $remote_file_contents);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsProperties[&#039;exportado_rightmove_prop&#039;] == 0) {
    $remote_file_contents = file_get_contents($row_rsImages[&#039;image_img&#039;]);

    $local_file_path = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/xml/rightmove/&#039; . $imgName;

    file_put_contents($local_file_path, $remote_file_contents);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/rightmove.php:194
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AddWatermarkImage($row_rsImages[&#039;image_img&#039;], $imgName);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsProperties[&#039;exportado_rightmove_prop&#039;] == 0) {
    AddWatermarkImage($row_rsImages[&#039;image_img&#039;], $imgName);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/rightmove.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$return .= &quot;~\n&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$return .= &quot;~\n&quot;;

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_rightmove_prop` = &#039;1&#039; WHERE `id_prop` = &quot;.$row_rsProperties[&#039;id_prop&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/zoopla.php:191
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$remote_file_contents = file_get_contents($row_rsImages[&#039;image_img&#039;]);

$local_file_path = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/xml/zoopla/&#039; . $imgName;

file_put_contents($local_file_path, $remote_file_contents);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsProperties[&#039;exportado_zoopla_prop&#039;] == 0) {
    $remote_file_contents = file_get_contents($row_rsImages[&#039;image_img&#039;]);

    $local_file_path = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/xml/zoopla/&#039; . $imgName;

    file_put_contents($local_file_path, $remote_file_contents);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/zoopla.php:201
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AddWatermarkImage($row_rsImages[&#039;image_img&#039;], $imgName);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($row_rsProperties[&#039;exportado_zoopla_prop&#039;] == 0) {
    AddWatermarkImage($row_rsImages[&#039;image_img&#039;], $imgName);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/zoopla.php:220
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$return .= &quot;~\n&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$return .= &quot;~\n&quot;;

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;UPDATE `properties_properties` SET `exportado_zoopla_prop` = &#039;1&#039; WHERE `id_prop` = &quot;.$row_rsProperties[&#039;id_prop&#039;].&quot; LIMIT 1;&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>