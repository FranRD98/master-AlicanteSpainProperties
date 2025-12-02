<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 22 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 24-09-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Llamadas comprodores/Vendedores añadir responsable y busueda por campos independientes</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al duplicar inmuebles, no duplica imagenes, archivos,...</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Fix desplegable PDF banderas del panel</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Añadido envio de emails sin inmuebles a compradores</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Añadido envio de emails a propietarios</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> El fromemail del envio de emails desde el panel es ahora el del usuario logueado</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Añadido seguimiento de compradores</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> Añadido seguimiento de vendedores</a></li>
        <li><a href="#nueve"><i class="fas fz-fw fa-bug text-danger"></i> Añadido equipo autoadministrado</a></li>
        <li><a href="#diez"><i class="fas fz-fw fa-bug text-danger"></i> Añadida piscina y parking a los criterios de búsqueda de un comprador</a></li>
        <li><a href="#once"><i class="fas fz-fw fa-bug text-danger"></i> Añadido precios por días</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Llamadas comprodores/Vendedores añadir responsable y busueda por campos independientess
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:101
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$usrlogin = &#039;&#039;;
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsLlamadasPropIDSprops = &quot;
SELECT GROUP_CONCAT(owner_prop) AS total FROM properties_properties&quot;;
$rsLlamadasPropIDSprops = mysql_query($query_rsLlamadasPropIDSprops, $inmoconn) or die(mysql_error());
$row_rsLlamadasPropIDSprops = mysql_fetch_assoc($rsLlamadasPropIDSprops);
$totalRows_rsLlamadasPropIDSprops = mysql_num_rows($rsLlamadasPropIDSprops);

if ($row_rsLlamadasPropIDSprops[&#039;total&#039;] != &#039;&#039;) {
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsLlamadasProp = &quot;
    SELECT
        id_pro
        FROM properties_owner
        WHERE next_call_pro != &#039;0000-00-00&#039;  AND next_call_pro &lt;= NOW() AND id_pro IN (&quot;.trim($row_rsLlamadasPropIDSprops[&#039;total&#039;],&#039;,&#039;).&quot;)
        ORDER BY next_call_pro ASC
    &quot;;
    $rsLlamadasProp = mysql_query($query_rsLlamadasProp, $inmoconn) or die(mysql_error());
    $row_rsLlamadasProp = mysql_fetch_assoc($rsLlamadasProp);
    $totalRows_rsLlamadasProp = mysql_num_rows($rsLlamadasProp);
    ?&gt;
    &lt;?php if($totalRows_rsLlamadasDeman &gt; 0 || $totalRows_rsLlamadasProp &gt; 0) { ?&gt;&lt;span class=&quot;label label-danger&quot;&gt;&lt;?php echo $totalRows_rsLlamadasDeman + $totalRows_rsLlamadasProp; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsLlamadasProp = &quot;
SELECT
    id_pro
    FROM properties_owner
    WHERE next_call_pro != &#039;0000-00-00&#039;  AND next_call_pro &lt;= NOW()
    ORDER BY next_call_pro ASC
&quot;;
$rsLlamadasProp = mysql_query($query_rsLlamadasProp, $inmoconn) or die(mysql_error());
$row_rsLlamadasProp = mysql_fetch_assoc($rsLlamadasProp);
$totalRows_rsLlamadasProp = mysql_num_rows($rsLlamadasProp);
?&gt;
&lt;?php if($totalRows_rsLlamadasDeman &gt; 0 || $totalRows_rsLlamadasProp &gt; 0) { ?&gt;&lt;span class=&quot;label label-danger&quot;&gt;&lt;?php echo $totalRows_rsLlamadasDeman + $totalRows_rsLlamadasProp; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        Sustituir los archivos:<br>
        <code>/intramedianet/llamadas/clients.php</code><br>
        <code>/intramedianet/llamadas/clients-data.php</code><br>
        <code>/intramedianet/llamadas/_js/clients-list.js</code><br>
        <code>/intramedianet/llamadas/owners.php</code><br>
        <code>/intramedianet/llamadas/owners-data.php</code><br>
        <code>/intramedianet/llamadas/_js/owners-list.js</code><br>
        por el del master de esta versión
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al duplicar inmuebles, no duplica imagenes, archivos,...
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/propiedades.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Duplicar archivos */
/*--------------------------------------------------------------------------
|
| Gestina si se duplican o no los archivos, imagenes, de los inmuebles al duplicarlos
| 0 - No duplica los archivos
| 1 - Duplica los archivos
|
*/

$duplicaFilesPros = 1;
            </code>
        </pre>
        <hr>
        Sustituir el archivo <code>/intramedianet/properties/properties-dupli.php</code> por el del master de esta versión
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix desplegable PDF banderas del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/css/app.css
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
.dataTables_wrapper .table-striped&gt;tbody&gt;tr:first-child .dropup .dropdown-menu {
    top: 100%;
    bottom: auto;
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
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido envio de emails sin inmuebles a compradores
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:773
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#busqueda&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Criterios de b&uacute;squeda&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-danger countlistnews2&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;label label-info countlistint2&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;label label-default countlistintno2&quot;&gt;0&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#busqueda&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Criterios de b&uacute;squeda&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-danger countlistnews2&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;label label-info countlistint2&quot;&gt;0&lt;/span&gt; &lt;span class=&quot;label label-default countlistintno2&quot;&gt;0&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;&lt;li&gt;&lt;a href=&quot;#email&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Enviar&#039;); ?&gt; &lt;?php __(&#039;Email&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1094
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#busqueda --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#busqueda --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;email&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Enviar&#039;); ?&gt; &lt;?php __(&#039;Email&#039;); ?&gt;&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-12&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                      &lt;label for=&quot;subjectSM&quot;&gt;&lt;?php __(&#039;Asunto&#039;); ?&gt;:&lt;/label&gt;
                      &lt;div class=&quot;controls&quot;&gt;
                      &lt;input type=&quot;text&quot; name=&quot;subjectSM&quot; id=&quot;subjectSM&quot; class=&quot;form-control&quot;&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                      &lt;label for=&quot;email_cli&quot;&gt;&lt;?php __(&#039;Mensaje&#039;); ?&gt;:&lt;/label&gt;
                      &lt;div class=&quot;controls&quot;&gt;
                      &lt;textarea name=&quot;messagemail&quot; id=&quot;messagemail&quot; cols=&quot;30&quot; rows=&quot;15&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;hr&gt;
                    &lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;&lt;/a&gt;
                &lt;/div&gt;
            &lt;/div&gt;

        &lt;/div&gt;

    &lt;/div&gt;

&lt;/div&gt; &lt;!--/#email --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1958
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var strSearch = &#039;&lt;?php __(&#039;Buscar&#039;) ?&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var strSearch = &#039;&lt;?php __(&#039;Buscar&#039;) ?&gt;&#039;;
var strFieldSubject = &#039;&lt;?php __(&#039;El campo asunto es requerido&#039;) ?&gt;&#039;;
var strFieldMessage = &#039;&lt;?php __(&#039;El campo mensaje es requerido&#039;) ?&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:600
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="sql">
SELECT
properties_log_mails.id_log,
GROUP_CONCAT(properties_properties.id_prop) as id_prop,
GROUP_CONCAT(properties_properties.referencia_prop) as referencia_prop,
properties_log_mails.type_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
INNER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
WHERE email_log = &#039;&quot;.$row_rsproperties_client[&#039;email_cli&#039;].&quot;&#039; AND referencia_prop != &#039;&#039; AND email_log != &#039;&#039;
GROUP BY date_log
ORDER BY date_log DESC
            </code>
        </pre>
        Por:
        <pre>
            <code class="sql">
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
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$(&#039;.btnsendemail&#039;).click(function(e) {
  e.preventDefault();
  if (!isValidEmailAddress($(&#039;#email_cli&#039;).val())) {
      alert(cliMailNo);
      return false;
  }
  if ($(&#039;#subjectSM&#039;).val() == &#039;&#039;) {
      alert(strFieldSubject);
      return false;
  }
  if ($(&#039;#messagemail&#039;).val() == &#039;&#039;) {
      alert(strFieldMessage);
      return false;
  }
  if (!confirm(cliMailConf)) {
    return false;
  }
  $.ajax({
    type: &quot;GET&quot;,
    url: &quot;clients-send-email.php?subject=&quot;+$(&#039;#subjectSM&#039;).val()+&#039;&amp;message=&#039;+$(&#039;#messagemail&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;email=&#039;+$(&#039;#email_cli&#039;).val()+&#039;&amp;tipo=7&amp;lang=&#039; + $(&#039;#idioma_cli&#039;).val() + &#039;&amp;usr=&#039; + idClient,
      cache: false
  }).done(function( data ) {
        if(data == &#039;ok&#039;) {
          alert(mensaSend);
          $(&#039;#subjectSM&#039;).val(&#039;&#039;);
          $(&#039;#messagemail&#039;).val(&#039;&#039;);
          $(&#039;#form1 .loadingMail&#039;).remove();
        }
  });
});
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
$lang[&#039;Nombre de la lista&#039;] = &#039;Nombre de la lista&#039;;
$lang[&#039;Nombre a mostrar&#039;] = &#039;Nombre a mostrar&#039;;
$lang[&#039;El campo asunto es requerido&#039;] = &#039;El campo asunto es requerido&#039;;
$lang[&#039;El campo mensaje es requerido&#039;] = &#039;El campo mensaje es requerido&#039;;
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
$lang[&#039;Nombre de la lista&#039;] = &#039;List name&#039;;
$lang[&#039;Nombname to showar&#039;] = &#039;Name to show&#039;;
$lang[&#039;El campo asunto es requerido&#039;] = &#039;The subject field is required&#039;;
$lang[&#039;El campo mensaje es requerido&#039;] = &#039;The message field is required&#039;;
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/intramedianet/properties/clients-send-email.php</code> del master de esta versión.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido envio de emails a propietarios
    </h6>
    <div class="card-body">
        Ejecutar el SQL:
        <pre>
            <code class="sql">
CREATE TABLE `properties_log_mails_props` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `usr_log` int(11) DEFAULT &#039;0&#039;,
  `prop_id_log` int(11) DEFAULT &#039;0&#039;,
  `email_log` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `send_id_log` int(11) DEFAULT &#039;0&#039;,
  `type_log` int(11) DEFAULT &#039;0&#039;,
  `text_log` text COLLATE utf8_unicode_ci,
  `date_log` datetime NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `prop_id_log` (`prop_id_log`),
  KEY `email_log` (`email_log`),
  KEY `type_log` (`type_log`),
  KEY `date_log` (`date_log`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/propeties/owners-form.php:471
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($totalRows_rsEmails &gt; 0) { ?&gt;
&lt;li&gt;&lt;a href=&quot;#emails&quot; data-toggle=&quot;tab&quot; id=&quot;emails-tab&quot;&gt;&lt;?php __(&#039;Seguimiento de envios&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($totalRows_rsEmails &gt; 0) { ?&gt;
&lt;li&gt;&lt;a href=&quot;#emails&quot; data-toggle=&quot;tab&quot; id=&quot;emails-tab&quot;&gt;&lt;?php __(&#039;Seguimiento de envios&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
&lt;li&gt;&lt;a href=&quot;#email&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Enviar&#039;); ?&gt; &lt;?php __(&#039;Email&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:392
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsproperties_owner = mysql_num_rows($rsproperties_owner);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsproperties_owner = mysql_num_rows($rsproperties_owner);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsEmails = &quot;
SELECT
properties_log_mails_props.id_log,
GROUP_CONCAT(properties_properties.id_prop) as id_prop,
GROUP_CONCAT(properties_properties.referencia_prop) as referencia_prop,
properties_log_mails_props.type_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log) AS usr_log,
properties_log_mails_props.text_log,
properties_log_mails_props.date_log
FROM properties_log_mails_props
LEFT OUTER JOIN properties_properties ON properties_log_mails_props.prop_id_log = properties_properties.id_prop
WHERE email_log = &#039;&quot;.$row_rsproperties_owner[&#039;email_pro&#039;].&quot;&#039; AND email_log != &#039;&#039;
GROUP BY date_log
ORDER BY date_log DESC
&quot;;
$rsEmails = mysql_query($query_rsEmails, $inmoconn) or die(mysql_error());
$row_rsEmails = mysql_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysql_num_rows($rsEmails);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1060
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#busqueda --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#busqueda --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;emails&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Env&iacute;o de emails&#039;); ?&gt;&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;table class=&quot;table table-striped table-bordered records-tables-simple2&quot; id=&quot;emails-table&quot;&gt;
                &lt;thead&gt;
                &lt;tr&gt;
                  &lt;th&gt;&lt;?php __(&#039;Administrador&#039;); ?&gt;&lt;/th&gt;
                  &lt;th&gt;&lt;?php __(&#039;Mensaje&#039;); ?&gt;&lt;/th&gt;
                  &lt;th&gt;&lt;?php __(&#039;Enviado&#039;); ?&gt;&lt;/th&gt;
                &lt;/tr&gt;
                &lt;/thead&gt;
                &lt;tbody&gt;
                &lt;?php do { ?&gt;
                  &lt;tr&gt;
                  &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;usr_log&#039;]; ?&gt;&lt;/td&gt;
                  &lt;td&gt;&lt;?php echo $row_rsEmails[&#039;text_log&#039;]; ?&gt;&lt;/td&gt;
                  &lt;td&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEmails[&#039;date_log&#039;])); ?&gt;&lt;/td&gt;
                  &lt;/tr&gt;
                  &lt;?php } while ($row_rsEmails = mysql_fetch_assoc($rsEmails)); ?&gt;
                &lt;/tbody&gt;
            &lt;/table&gt;

        &lt;/div&gt; &lt;!--/.panel-body --&gt;

    &lt;/div&gt; &lt;!--/.panel --&gt;

&lt;/div&gt; &lt;!--/.emails --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;email&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Enviar&#039;); ?&gt; &lt;?php __(&#039;Email&#039;); ?&gt;&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-12&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                      &lt;label for=&quot;subjectSM&quot;&gt;&lt;?php __(&#039;Asunto&#039;); ?&gt;:&lt;/label&gt;
                      &lt;div class=&quot;controls&quot;&gt;
                      &lt;input type=&quot;text&quot; name=&quot;subjectSM&quot; id=&quot;subjectSM&quot; class=&quot;form-control&quot;&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                      &lt;label for=&quot;email_cli&quot;&gt;&lt;?php __(&#039;Mensaje&#039;); ?&gt;:&lt;/label&gt;
                      &lt;div class=&quot;controls&quot;&gt;
                      &lt;textarea name=&quot;messagemail&quot; id=&quot;messagemail&quot; cols=&quot;30&quot; rows=&quot;15&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;hr&gt;
                    &lt;a href=&quot;#&quot; class=&quot;btn btn-primary btnsendemail&quot;&gt;&lt;?php echo $lang[&#039;Enviar&#039;] ?&gt;&lt;/a&gt;
                &lt;/div&gt;
            &lt;/div&gt;

        &lt;/div&gt;

    &lt;/div&gt;

&lt;/div&gt; &lt;!--/#email --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1183
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var selected =  new Array();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var selected =  new Array();
var strFieldSubject = &#039;&lt;?php __(&#039;El campo asunto es requerido&#039;) ?&gt;&#039;;
var strFieldMessage = &#039;&lt;?php __(&#039;El campo mensaje es requerido&#039;) ?&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:538
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#busqueda&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#busqueda&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php if ($totalRows_rsEmails &gt; 0) { ?&gt;
&lt;li&gt;&lt;a href=&quot;#emails&quot; data-toggle=&quot;tab&quot; id=&quot;emails-tab&quot;&gt;&lt;?php __(&#039;Seguimiento de envios&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-form.js
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$(&#039;.btnsendemail&#039;).click(function(e) {
  e.preventDefault();
  if (!isValidEmailAddress($(&#039;#email_pro&#039;).val())) {
      alert(cliMailNo);
      return false;
  }
  if ($(&#039;#subjectSM&#039;).val() == &#039;&#039;) {
      alert(strFieldSubject);
      return false;
  }
  if ($(&#039;#messagemail&#039;).val() == &#039;&#039;) {
      alert(strFieldMessage);
      return false;
  }
  if (!confirm(cliMailConf)) {
    return false;
  }
  $.ajax({
    type: &quot;GET&quot;,
    url: &quot;owners-send-email.php?subject=&quot;+$(&#039;#subjectSM&#039;).val()+&#039;&amp;message=&#039;+$(&#039;#messagemail&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;email=&#039;+$(&#039;#email_pro&#039;).val()+&#039;&amp;tipo=4&amp;lang=&#039; + $(&#039;#idioma_cli&#039;).val() + &#039;&amp;usr=&#039; + idOwner,
      cache: false
  }).done(function( data ) {
        if(data == &#039;ok&#039;) {
          alert(mensaSend);
          $(&#039;#subjectSM&#039;).val(&#039;&#039;);
          $(&#039;#messagemail&#039;).val(&#039;&#039;);
          $(&#039;#form1 .loadingMail&#039;).remove();
        }
  });
});
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/intramedianet/properties/owners-send-email.php</code> del master de esta versión.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> El fromemail del envio de emails desde el panel es ahora el del usuario logueado
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php
            </code>
        </pre>
        Sustituir la función <code>sendAppEmail</code> por la siguiente:
        <pre>
            <code class="php">
function sendAppEmail($to, $cc, $bcc, $replyTo, $subject, $body)
{
    global $smtpUrl, $smtpPort, $smtpUser, $smtpPass, $fromMail, $_SESSION, $_SERVER;

    require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/swift/lib/swift_required.php&#039;);

    $fromMailVal = $fromMail;
    if ($_SERVER[&quot;HTTP_HOST&quot;] != &#039;demo.mediaelx.info&#039;) {
        $hostval = &#039;/&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/&#039;;
        if ($_SESSION[&#039;kt_login_user&#039;] != &#039;&#039; &amp;&amp; preg_match($hostval, strtolower($_SESSION[&#039;kt_login_user&#039;]))) {
            $fromMailVal = $_SESSION[&#039;kt_login_user&#039;];
        }
    }

    $transport = Swift_SmtpTransport::newInstance($smtpUrl, $smtpPort)
        -&gt;setUsername($smtpUser)
        -&gt;setPassword($smtpPass)
    ;

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance()
        -&gt;setSubject($subject)
        -&gt;setFrom($fromMailVal)
        -&gt;setTo($to)
        -&gt;setBody($body, &#039;text/html&#039;)
    ;

    if ($cc != &#039;&#039;) { $message-&gt;setCc($cc); }

    if ($bcc != &#039;&#039;) { $message-&gt;setBcc($bcc); }

    if ($replyTo != &#039;&#039;) { $message-&gt;setReplyTo($replyTo); }

    return $mailer-&gt;send($message);

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
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido seguimiento de compradores
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
CREATE TABLE `properties_client_log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `user_log` int(11) NOT NULL DEFAULT &#039;0&#039;,
  `prop_id_log` int(11) DEFAULT &#039;0&#039;,
  `referencia_log` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action_log` int(11) NOT NULL,
  `date_log` datetime NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `user_log` (`user_log`),
  KEY `prop_id_log` (`prop_id_log`),
  KEY `referencia_log` (`referencia_log`),
  KEY `action_log` (`action_log`),
  KEY `date_log` (`date_log`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php
            </code>
        </pre>
        Añadir la función:
        <pre>
            <code class="php">
function logBuyer($user, $id, $ref, $action) {
    global $database_inmoconn, $inmoconn;
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsProp = &quot;INSERT INTO `properties_client_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &#039;&quot;.$user.&quot;&#039;, &#039;&quot;.$id.&quot;&#039;, &#039;&quot;.$ref.&quot;&#039;, &#039;&quot;.$action.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;)&quot;;
    $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:19
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mediaelx/functions.php&#039; );
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:462
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog(&amp;$tNG) {

  global $_SESSION;

  logBuyer($_SESSION[&#039;kt_login_id&#039;], $tNG-&gt;getColumnValue(&#039;id_cli&#039;), $tNG-&gt;getColumnValue(&#039;nombre_cli&#039;) . &#039; &#039; . $tNG-&gt;getColumnValue(&#039;apellidos_cli&#039;), &#039;1&#039;);

}
//end addLog trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog(&amp;$tNG) {

  global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsProp = &quot;SELECT * FROM properties_client WHERE id_cli = &quot;.$_GET[&#039;id_cli&#039;];
  $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());
  $row_rsProp = mysql_fetch_assoc($rsProp);
  $totalRows_rsProp = mysql_num_rows($rsProp);


  logBuyer($_SESSION[&#039;kt_login_id&#039;], $row_rsProp[&#039;id_cli&#039;], $row_rsProp[&#039;nombre_cli&#039;] . &#039; &#039; . $row_rsProp[&#039;apellidos_cli&#039;], 2);

}
//end editLog trigger

//start deleteLog trigger
//remove this line if you want to edit the code by hand
function deleteLog(&amp;$tNG) {

  global $_SESSION, $_GET, $database_inmoconn, $inmoconn;

  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsProp = &quot;SELECT * FROM properties_client WHERE id_cli = &quot;.$_GET[&#039;id_cli&#039;];
  $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());
  $row_rsProp = mysql_fetch_assoc($rsProp);
  $totalRows_rsProp = mysql_num_rows($rsProp);

  logBuyer($_SESSION[&#039;kt_login_id&#039;], $row_rsProp[&#039;id_cli&#039;], $row_rsProp[&#039;nombre_cli&#039;] . &#039; &#039; . $row_rsProp[&#039;apellidos_cli&#039;], &#039;5&#039;);

}
//end deleteLog trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:522
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);

            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);
$ins_properties_client-&gt;registerTrigger(&quot;AFTER&quot;, &quot;addLog&quot;, 10);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:581
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_CheckUnique&quot;, 30);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_CheckUnique&quot;, 30);
$upd_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;editLog&quot;, 10);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:643
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$del_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeletFromNewsletter&quot;, 10);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$del_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeletFromNewsletter&quot;, 10);
$del_properties_client-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;deleteLog&quot;, 99);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:729
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsTasks = mysql_num_rows($rsTasks);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsTasks = mysql_num_rows($rsTasks);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsHistorial = &quot;
SELECT
users.nombre_usr,
properties_client_log.referencia_log,
properties_client_log.action_log,
properties_client_log.date_log,
properties_client_log.id_log
FROM properties_client_log LEFT OUTER JOIN users ON properties_client_log.user_log = users.id_usr
WHERE prop_id_log = &#039;&quot;.$_GET[&#039;id_cli&#039;].&quot;&#039;
ORDER BY date_log DESC
&quot;;
$rsHistorial = mysql_query($query_rsHistorial, $inmoconn) or die(mysql_error());
$row_rsHistorial = mysql_fetch_assoc($rsHistorial);
$totalRows_rsHistorial = mysql_num_rows($rsHistorial);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:835
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#historial&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Historial&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#historial&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Historial&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php if ($totalRows_rsHistorial &gt; 0) { ?&gt;
&lt;li&gt;&lt;a href=&quot;#seguimiento&quot; data-toggle=&quot;tab&quot; id=&quot;seguimiento-tab&quot;&gt;&lt;?php __(&#039;Seguimiento&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1235
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#historial --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#historial --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;seguimiento&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;span class=&quot;ref_prop&quot;&gt;&lt;/span&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Seguimiento&#039;); ?&gt;&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;table class=&quot;table table-striped table-bordered records-tables-simple&quot; id=&quot;history-table&quot;&gt;
                &lt;thead&gt;
                &lt;tr&gt;
                  &lt;th&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;&lt;/th&gt;
                  &lt;th&gt;&lt;?php __(&#039;Acci&oacute;n&#039;); ?&gt;&lt;/th&gt;
                  &lt;th&gt;&lt;?php __(&#039;Fecha&#039;); ?&gt;&lt;/th&gt;
                &lt;/tr&gt;
                &lt;/thead&gt;
                &lt;tbody&gt;
                  &lt;?php do { ?&gt;
                  &lt;tr&gt;
                    &lt;td&gt;&lt;?php echo $row_rsHistorial[&#039;nombre_usr&#039;]; ?&gt;&lt;/td&gt;
                    &lt;td&gt;&lt;?php
                    switch ($row_rsHistorial[&#039;action_log&#039;]) {
                      case &#039;1&#039;:
                        echo &#039;&lt;span class=&quot;label label-success&quot;&gt;&#039;.__(&#039;A&ntilde;adido&#039;, true) . &#039;&lt;/span&gt;&#039;;
                        break;
                      case &#039;2&#039;:
                        echo &#039;&lt;span class=&quot;label label-info&quot;&gt;&#039;.__(&#039;Editado&#039;, true) . &#039;&lt;/span&gt;&#039;;
                        break;
                      case &#039;5&#039;:
                        echo &#039;&lt;span class=&quot;label label-danger&quot;&gt;&#039;.__(&#039;Borrado&#039;, true) . &#039;&lt;/span&gt;&#039;;
                        break;
                    }
                    ?&gt;&lt;/td&gt;
                    &lt;td&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsHistorial[&#039;date_log&#039;])); ?&gt;&lt;/td&gt;
                  &lt;/tr&gt;
                  &lt;?php } while ($row_rsHistorial = mysql_fetch_assoc($rsHistorial)); ?&gt;
                &lt;/tbody&gt;
            &lt;/table&gt;

        &lt;/div&gt; &lt;!--/.panel-body --&gt;

    &lt;/div&gt; &lt;!--/.panel --&gt;

&lt;/div&gt; &lt;!--/.seguimiento --&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>



<div class="card mb-4">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido seguimiento de vendedores
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
CREATE TABLE `properties_owner_log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `user_log` int(11) NOT NULL DEFAULT '0',
  `prop_id_log` int(11) DEFAULT '0',
  `referencia_log` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action_log` int(11) NOT NULL,
  `date_log` datetime NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `user_log` (`user_log`),
  KEY `prop_id_log` (`prop_id_log`),
  KEY `referencia_log` (`referencia_log`),
  KEY `action_log` (`action_log`),
  KEY `date_log` (`date_log`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php
            </code>
        </pre>
        Añadir la función:
        <pre>
            <code class="php">
function logVendor($user, $id, $ref, $action) {
    global $database_inmoconn, $inmoconn;
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsProp = &quot;INSERT INTO `properties_owner_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &#039;&quot;.$user.&quot;&#039;, &#039;&quot;.$id.&quot;&#039;, &#039;&quot;.$ref.&quot;&#039;, &#039;&quot;.$action.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;)&quot;;
    $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:16
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/includes/mediaelx/functions.php&#039; );
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:273
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
//start addLog trigger
//remove this line if you want to edit the code by hand
function addLog(&amp;$tNG) {

  global $_SESSION;

  logVendor($_SESSION[&#039;kt_login_id&#039;], $tNG-&gt;getColumnValue(&#039;id_pro&#039;), $tNG-&gt;getColumnValue(&#039;nombre_pro&#039;) . &#039; &#039; . $tNG-&gt;getColumnValue(&#039;apellidos_pro&#039;), &#039;1&#039;);

}
//end addLog trigger

//start editLog trigger
//remove this line if you want to edit the code by hand
function editLog(&amp;$tNG) {

  global $_SESSION, $_POST, $_GET, $database_inmoconn, $inmoconn;

  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsProp = &quot;SELECT * FROM properties_owner WHERE id_pro = &quot;.$_GET[&#039;id_pro&#039;];
  $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());
  $row_rsProp = mysql_fetch_assoc($rsProp);
  $totalRows_rsProp = mysql_num_rows($rsProp);


  logVendor($_SESSION[&#039;kt_login_id&#039;], $row_rsProp[&#039;id_pro&#039;], $row_rsProp[&#039;nombre_pro&#039;] . &#039; &#039; . $row_rsProp[&#039;apellidos_pro&#039;], 2);

}
//end editLog trigger

//start deleteLog trigger
//remove this line if you want to edit the code by hand
function deleteLog(&amp;$tNG) {

  global $_SESSION, $_GET, $database_inmoconn, $inmoconn;

  mysql_select_db($database_inmoconn, $inmoconn);
  $query_rsProp = &quot;SELECT * FROM properties_owner WHERE id_pro = &quot;.$_GET[&#039;id_pro&#039;];
  $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());
  $row_rsProp = mysql_fetch_assoc($rsProp);
  $totalRows_rsProp = mysql_num_rows($rsProp);

  logVendor($_SESSION[&#039;kt_login_id&#039;], $row_rsProp[&#039;id_pro&#039;], $row_rsProp[&#039;nombre_pro&#039;] . &#039; &#039; . $row_rsProp[&#039;apellidos_pro&#039;], &#039;5&#039;);

}
//end deleteLog trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:330
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);

            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;addFields&quot;, 10);
$ins_properties_owner-&gt;registerTrigger(&quot;AFTER&quot;, &quot;addLog&quot;, 10);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:379
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_CheckUnique&quot;, 30);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_CheckUnique&quot;, 30);
$upd_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;editLog&quot;, 10);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:426
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$del_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail2&quot;, 99);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$del_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_DeleteDetail2&quot;, 99);
$del_properties_owner-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;deleteLog&quot;, 99);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:461
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsEmails = mysql_num_rows($rsEmails);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsEmails = mysql_num_rows($rsEmails);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsHistorial = &quot;
SELECT
users.nombre_usr,
properties_owner_log.referencia_log,
properties_owner_log.action_log,
properties_owner_log.date_log,
properties_owner_log.id_log
FROM properties_owner_log LEFT OUTER JOIN users ON properties_owner_log.user_log = users.id_usr
WHERE prop_id_log = &#039;&quot;.$_GET[&#039;id_pro&#039;].&quot;&#039;
ORDER BY date_log DESC
&quot;;
$rsHistorial = mysql_query($query_rsHistorial, $inmoconn) or die(mysql_error());
$row_rsHistorial = mysql_fetch_assoc($rsHistorial);
$totalRows_rsHistorial = mysql_num_rows($rsHistorial);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:529
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#historial&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Historial&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#historial&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Historial&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php if ($totalRows_rsHistorial &gt; 0) { ?&gt;
&lt;li&gt;&lt;a href=&quot;#seguimiento&quot; data-toggle=&quot;tab&quot; id=&quot;seguimiento-tab&quot;&gt;&lt;?php __(&#039;Seguimiento&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:935
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#historial --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/#historial --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;seguimiento&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;span class=&quot;ref_prop&quot;&gt;&lt;/span&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Seguimiento&#039;); ?&gt;&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;table class=&quot;table table-striped table-bordered records-tables-simple&quot; id=&quot;history-table&quot;&gt;
                &lt;thead&gt;
                &lt;tr&gt;
                  &lt;th&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;&lt;/th&gt;
                  &lt;th&gt;&lt;?php __(&#039;Acci&oacute;n&#039;); ?&gt;&lt;/th&gt;
                  &lt;th&gt;&lt;?php __(&#039;Fecha&#039;); ?&gt;&lt;/th&gt;
                &lt;/tr&gt;
                &lt;/thead&gt;
                &lt;tbody&gt;
                  &lt;?php do { ?&gt;
                  &lt;tr&gt;
                    &lt;td&gt;&lt;?php echo $row_rsHistorial[&#039;nombre_usr&#039;]; ?&gt;&lt;/td&gt;
                    &lt;td&gt;&lt;?php
                    switch ($row_rsHistorial[&#039;action_log&#039;]) {
                      case &#039;1&#039;:
                        echo &#039;&lt;span class=&quot;label label-success&quot;&gt;&#039;.__(&#039;A&ntilde;adido&#039;, true) . &#039;&lt;/span&gt;&#039;;
                        break;
                      case &#039;2&#039;:
                        echo &#039;&lt;span class=&quot;label label-info&quot;&gt;&#039;.__(&#039;Editado&#039;, true) . &#039;&lt;/span&gt;&#039;;
                        break;
                      case &#039;5&#039;:
                        echo &#039;&lt;span class=&quot;label label-danger&quot;&gt;&#039;.__(&#039;Borrado&#039;, true) . &#039;&lt;/span&gt;&#039;;
                        break;
                    }
                    ?&gt;&lt;/td&gt;
                    &lt;td&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsHistorial[&#039;date_log&#039;])); ?&gt;&lt;/td&gt;
                  &lt;/tr&gt;
                  &lt;?php } while ($row_rsHistorial = mysql_fetch_assoc($rsHistorial)); ?&gt;
                &lt;/tbody&gt;
            &lt;/table&gt;

        &lt;/div&gt; &lt;!--/.panel-body --&gt;

    &lt;/div&gt; &lt;!--/.panel --&gt;

&lt;/div&gt; &lt;!--/.seguimiento --&gt;
            </code>
        </pre>
        <hr>
        Sustituir los archivos:<br>
        <code>/intramedianet/properties/owners-form-ajax.php</code><br>
        <code>/intramedianet/properties/owners-form-update-ajax.php</code><br>
        por el del master de esta versión
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="nueve">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido equipo autoadministrado
    </h6>
    <div class="card-body">
        Subimos la carpetas <code>/intramedianet/team/</code> y <code>/media/images/teams</code> de este master.
        <hr>
        Ejecutar la query:
        <pre>
            <code class="sql">
CREATE TABLE IF NOT EXISTS `teams` (
  `id_tms` int(11) NOT NULL AUTO_INCREMENT,
  `cargo_da_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_de_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_en_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_es_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_fi_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_fr_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_is_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_nl_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_no_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_ru_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_se_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo_zh_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activate_tms` int(1) DEFAULT '1',
  `cargo_be_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idiomas_tms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_tms`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `teams_fotos` (
  `id_img` int(11) NOT NULL AUTO_INCREMENT,
  `noticia_img` int(11) NOT NULL,
  `imagen_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt_da_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_de_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_en_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_es_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_fi_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_fr_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_is_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_nl_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_no_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_ru_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_se_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alt_zh_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden_img` int(11) NOT NULL,
  `alt_be_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/secciones.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Equipo */
/*--------------------------------------------------------------------------
|
| Activar equipo autogestionable, para que aparezvca en sobre nosotros
| 0 - Desactivado
| 1 - Activado
|
*/

$showTeam = 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:391
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php } ?&gt;

&lt;?php if ($showTeam == 1) { ?&gt;
    &lt;a href=&quot;/intramedianet/team/teams.php&quot; &lt;?php if(preg_match(&#039;/\/team\//&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
        &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
            &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
            &lt;i class=&quot;fa fa-id-card-o fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
        &lt;/span&gt;
        &lt;?php __(&#039;Equipo&#039;); ?&gt;
    &lt;/a&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/pages/pages.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
if ($showTeam == 1) {
    $teams = getRecords(&quot;
        SELECT teams.id_tms,
            teams.nombre_tms as nombre,
            teams.cargo_&quot;.$lang.&quot;_tms as cargo,
            teams.telefono_tms as telefono,
            teams.email_tms as email,
            teams.idiomas_tms as idiomas,
        (SELECT imagen_img FROM teams_fotos WHERE noticia_img = id_tms ORDER BY orden_img LIMIT 1) AS img
        FROM teams
        WHERE  activate_tms = 1
        ORDER BY id_tms ASC
    &quot;);
    $smarty-&gt;assign(&quot;teams&quot;, $teams);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/pages/view/index.tpl:17
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;
{if $teams[0].nombre != &#039;&#039;}
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-12&quot;&gt;
        &lt;h3 class=&quot;mb-5&quot;&gt;&lt;strong&gt;{$lng_our_team}&lt;/strong&gt;&lt;/h3&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;row&quot;&gt;
    {section name=tm loop=$teams}
        &lt;div class=&quot;col-12 col-md-6 col-lg-3 mb-lg-4&quot;&gt;
            &lt;div class=&quot;card mb-5 mb-lg-0&quot;&gt;
                &lt;img class=&quot;card-img-top mw-100&quot; src=&quot;/media/images/teams/{$teams[tm].img}&quot;&gt;
                &lt;div class=&quot;card-body text-center&quot;&gt;
                    &lt;h5 class=&quot;mb-0&quot;&gt;{$teams[tm].nombre}&lt;/h5&gt;
                    &lt;span&gt;{$teams[tm].cargo}&lt;/span&gt;&lt;br&gt;
                    &lt;a href=&quot;tel:{$teams[tm].telefono|replace:&#039; &#039;:&#039;&#039;}&quot; class=&quot;mb-0&quot;&gt;&lt;i class=&quot;fa fa-phone&quot;&gt;&lt;/i&gt; {$teams[tm].telefono}&lt;/a&gt;&lt;br&gt;
                    &lt;a href=&quot;mailto:{$teams[tm].email}&quot; class=&quot;mb-0&quot;&gt;&lt;i class=&quot;fa fa-envelope&quot;&gt;&lt;/i&gt; {$teams[tm].email}&lt;/a&gt;
                &lt;/div&gt;
                &lt;div class=&quot;card-footer text-center text-muted p-2 p-lg-3&quot;&gt;
                    &lt;ul class=&quot;list-inline m-0&quot;&gt;
                        {foreach from=&#039;,&#039;|explode:$teams[tm].idiomas item=idio_team}
                            &lt;li class=&quot;list-inline-item&quot;&gt;
                                &lt;img src=&quot;/media/images/website/flags/{$idio_team}.png&quot;&gt;
                            &lt;/li&gt;
                        {/foreach}
                    &lt;/ul&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    {/section}
&lt;/div&gt;
{/if}
            </code>
        </pre>
        <hr>
        Añadir a los archivos de texto: <code>/resources/lang_*.php</code>, los siguientes textos:
        <pre>
            <code class="php">
da -&gt; $langStr[&quot;Our team&quot;] = &quot;Vores hold&quot;;
de -&gt; $langStr[&quot;Our team&quot;] = &quot;Unser Team&quot;;
en -&gt; $langStr[&quot;Our team&quot;] = &quot;Our team&quot;;
es -&gt; $langStr[&quot;Our team&quot;] = &quot;Nuestro equipo&quot;;
fi -&gt; $langStr[&quot;Our team&quot;] = &quot;Tiimimme&quot;;
fr -&gt; $langStr[&quot;Our team&quot;] = &quot;Notre &eacute;quipe&quot;;
is -&gt; $langStr[&quot;Our team&quot;] = &quot;Okkar li&eth;&quot;;
nl -&gt; $langStr[&quot;Our team&quot;] = &quot;Ons team&quot;;
no -&gt; $langStr[&quot;Our team&quot;] = &quot;V&aring;rt team&quot;;
ru -&gt; $langStr[&quot;Our team&quot;] = &quot;&#x41d;&#x430;&#x448;&#x430; &#x43a;&#x43e;&#x43c;&#x430;&#x43d;&#x434;&#x430;&quot;;
se -&gt; $langStr[&quot;Our team&quot;] = &quot;V&aring;rt lag&quot;;
zh -&gt; $langStr[&quot;Our team&quot;] = &quot;&#x6211;&#x4eec;&#x7684;&#x961f;&#x4f0d;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="diez">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadida piscina y parking a los criterios de búsqueda de un comprador
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_client` ADD COLUMN `b_pool_cli` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `b_tags_cli`;
ALTER TABLE `properties_client` ADD COLUMN `b_parking_cli` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `b_pool_cli`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:291
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsclientes = mysql_num_rows($rsclientes);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsclientes = mysql_num_rows($rsclientes);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsPool = &quot;SELECT pool_&quot;.$lang_adm.&quot;_pl as pool, id_pl FROM properties_pool ORDER BY pool ASC&quot;;
$rsPool = mysql_query($query_rsPool, $inmoconn) or die(mysql_error());
$row_rsPool = mysql_fetch_assoc($rsPool);
$totalRows_rsPool = mysql_num_rows($rsPool);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsParking = &quot;SELECT parking_&quot;.$lang_adm.&quot;_prk as parking, id_prk FROM properties_parking ORDER BY parking ASC&quot;;
$rsParking = mysql_query($query_rsParking, $inmoconn) or die(mysql_error());
$row_rsParking = mysql_fetch_assoc($rsParking);
$totalRows_rsParking = mysql_num_rows($rsParking);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:421
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (isset($_POST[&#039;visited_cli&#039;]) &amp;&amp; $_POST[&#039;visited_cli&#039;] != &#039;&#039; ) {
  $_POST[&#039;visited_cli&#039;] = implode(&#039;,&#039;, $_POST[&#039;visited_cli&#039;]);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (isset($_POST[&#039;visited_cli&#039;]) &amp;&amp; $_POST[&#039;visited_cli&#039;] != &#039;&#039; ) {
  $_POST[&#039;visited_cli&#039;] = implode(&#039;,&#039;, $_POST[&#039;visited_cli&#039;]);
}
if (isset($_POST[&#039;b_pool_cli&#039;]) &amp;&amp; $_POST[&#039;b_pool_cli&#039;] != &#039;&#039; ) {
  $_POST[&#039;b_pool_cli&#039;] = implode(&#039;,&#039;, $_POST[&#039;b_pool_cli&#039;]);
}
if (isset($_POST[&#039;b_parking_cli&#039;]) &amp;&amp; $_POST[&#039;b_parking_cli&#039;] != &#039;&#039; ) {
  $_POST[&#039;b_parking_cli&#039;] = implode(&#039;,&#039;, $_POST[&#039;b_parking_cli&#039;]);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:572
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;b_tags_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_tags_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_client-&gt;addColumn(&quot;b_tags_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_tags_cli&quot;);
$ins_properties_client-&gt;addColumn(&quot;b_pool_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_pool_cli&quot;);
$ins_properties_client-&gt;addColumn(&quot;b_parking_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_parking_cli&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:636
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;b_tags_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_tags_cli&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_client-&gt;addColumn(&quot;b_tags_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_tags_cli&quot;);
$upd_properties_client-&gt;addColumn(&quot;b_pool_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_pool_cli&quot;);
$upd_properties_client-&gt;addColumn(&quot;b_parking_cli&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;b_parking_cli&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:1782
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;
      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_pool_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_pool_cli&quot;&gt;&lt;?php __(&#039;Piscina&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;b_pool_cli[]&quot; id=&quot;b_pool_cli&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot;&gt;
              &lt;?php
              do {
              ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsPool[&#039;id_pl&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsPool[&#039;id_pl&#039;], $row_rsproperties_client[&#039;b_pool_cli&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsPool[&#039;pool&#039;]?&gt;&lt;/option&gt;
              &lt;?php
              } while ($row_rsPool = mysql_fetch_assoc($rsPool ));
                $rows = mysql_num_rows($rsPool );
                if($rows &gt; 0) {
                    mysql_data_seek($rsPool , 0);
                  $row_rsPool = mysql_fetch_assoc($rsPool );
                }
              ?&gt;
          &lt;/select&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_pool_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt; &lt;!--/.col-md-6 --&gt;

  &lt;div class=&quot;col-md-6&quot;&gt;
      &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_parking_cli&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;b_parking_cli&quot;&gt;&lt;?php __(&#039;Parking&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;b_parking_cli[]&quot; id=&quot;b_parking_cli&quot; class=&quot;form-control select2&quot; multiple=&quot;multiple&quot;&gt;
              &lt;?php
              do {
              ?&gt;
              &lt;option value=&quot;&lt;?php echo $row_rsParking[&#039;id_prk&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsParking[&#039;id_prk&#039;], $row_rsproperties_client[&#039;b_parking_cli&#039;]))) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rsParking[&#039;parking&#039;]?&gt;&lt;/option&gt;
              &lt;?php
              } while ($row_rsParking = mysql_fetch_assoc($rsParking ));
                $rows = mysql_num_rows($rsParking );
                if($rows &gt; 0) {
                    mysql_data_seek($rsParking , 0);
                  $row_rsParking = mysql_fetch_assoc($rsParking );
                }
              ?&gt;
          &lt;/select&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;b_parking_cli&quot;); ?&gt;
      &lt;/div&gt;

  &lt;/div&gt; &lt;!--/.col-md-6 --&gt;

&lt;/div&gt; &lt;!--/.row --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:493
/intramedianet/properties/properties-client-data-cli-int.php:493
/intramedianet/properties/properties-client-data-cli-intno.php:493
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$pool = &#039;&#039;;
if( isset($_GET[&#039;piscina_prop&#039;]) &amp;&amp; $_GET[&#039;piscina_prop&#039;] != &#039;&#039; ){
  $pool = &quot;AND piscina_prop LIKE &#039;%&quot; . $_GET[&#039;piscina_prop&#039;].&quot;%&#039;&quot;;
}

$parking = &#039;&#039;;
if( isset($_GET[&#039;parking_prop&#039;]) &amp;&amp; $_GET[&#039;parking_prop&#039;] != &#039;&#039; ){
  $parking = &quot;AND parking_prop LIKE &#039;%&quot; . $_GET[&#039;parking_prop&#039;].&quot;%&#039;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$pool = &#039;&#039;;
  if( isset($_GET[&#039;b_pool_cli&#039;]) &amp;&amp; $_GET[&#039;b_pool_cli&#039;][0] != &#039;&#039; ){
    $pools = array();
    foreach ($_GET[&#039;b_pool_cli&#039;] as $value) {
      array_push($pools, &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
    }
    $poolsids = implode(&#039;,&#039;, $pools);
    if ($poolsids != &#039;&#039;) {
        $pool = &quot;AND piscina_prop IN (&quot; . $poolsids . &quot;)&quot;;
    }
  }

  $parking = &#039;&#039;;
  if( isset($_GET[&#039;b_parking_cli&#039;]) &amp;&amp; $_GET[&#039;b_parking_cli&#039;][0] != &#039;&#039; ){
    $parkings = array();
    foreach ($_GET[&#039;b_parking_cli&#039;] as $value) {
      array_push($parkings, &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
    }
    $parkingsids = implode(&#039;,&#039;, $parkings);
    if ($parkingsids != &#039;&#039;) {
        $parking = &quot;AND parking_prop IN (&quot; . $parkingsids . &quot;)&quot;;
    }
  }
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:526
/intramedianet/properties/properties-client-data-cli-int.php:525
/intramedianet/properties/properties-client-data-cli-intno.php:526
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;piscina_prop&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;parking_prop&#039;] == &#039;&#039;       ){
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if( !isset($_GET[&#039;b_sale_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039;       ){
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:495
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$obrnws = '';
if( isset($_GET['b_obranueva_cli']) && $_GET['b_obranueva_cli'] != '' ){
  $obrnws = "AND obra_nueva_prop LIKE '%" . $_GET['b_obranueva_cli']."%'";
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$obrnws = &#039;&#039;;
if( isset($_GET[&#039;b_obranueva_cli&#039;]) &amp;&amp; $_GET[&#039;b_obranueva_cli&#039;] != &#039;&#039; ){
  $obrnws = &quot;AND obra_nueva_prop LIKE &#039;%&quot; . $_GET[&#039;b_obranueva_cli&#039;].&quot;%&#039;&quot;;
}

$pool = &#039;&#039;;
if( isset($_GET[&#039;b_pool_cli&#039;]) &amp;&amp; $_GET[&#039;b_pool_cli&#039;][0] != &#039;&#039; ){
$pools = array();
foreach ($_GET[&#039;b_pool_cli&#039;] as $value) {
  array_push($pools, &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
}
$poolsids = implode(&#039;,&#039;, $pools);
if ($poolsids != &#039;&#039;) {
    $pool = &quot;AND piscina_prop IN (&quot; . $poolsids . &quot;)&quot;;
}
}

$parking = &#039;&#039;;
if( isset($_GET[&#039;b_parking_cli&#039;]) &amp;&amp; $_GET[&#039;b_parking_cli&#039;][0] != &#039;&#039; ){
$parkings = array();
foreach ($_GET[&#039;b_parking_cli&#039;] as $value) {
  array_push($parkings, &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
}
$parkingsids = implode(&#039;,&#039;, $parkings);
if ($parkingsids != &#039;&#039;) {
    $parking = &quot;AND parking_prop IN (&quot; . $parkingsids . &quot;)&quot;;
}
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:558
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if( !isset($_GET[&#039;b_sale_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ocultos_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;piscina_prop&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;parking_prop&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_direcc_cli&#039;] == &#039;&#039;       ){
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if( !isset($_GET[&#039;b_sale_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_type_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_beds_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;or&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_orientacion_cli&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;favs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_baths_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ref_cli&#039;][0]) &amp;&amp; $_GET[&#039;b_precio_desde_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_precio_hasta_cli&#039;] == &#039;&#039;  &amp;&amp; !isset($_GET[&#039;b_ocultos_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc1_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc2_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc3_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_loc4_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones_cli&#039;][0])  &amp;&amp; !isset($_GET[&#039;b_opciones2_cli&#039;][0]) &amp;&amp; !isset($_GET[&#039;b_tags_cli&#039;])  &amp;&amp; $_GET[&#039;nw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ven&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;alq&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;res&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;rp&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;cs&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;sw&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;ep&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;po&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;rps&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;direccion&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2ut&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;m2pl&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;palabras_clave&#039;] == &#039;&#039; &amp;&amp; $_GET[&#039;b_pool_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_parking_cli&#039;] == &#039;&#039;  &amp;&amp; $_GET[&#039;b_direcc_cli&#039;] == &#039;&#039;       ){
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:619
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $dirr $urb $pisc2 $gargg $vismarr $obrnws
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $dirr $urb $pisc2 $gargg $vismarr $obrnws $pool $parking
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:61
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$row_rsCli[&#039;b_ocultos_cli&#039;] = split(&#039;,&#039;, $row_rsCli[&#039;b_ocultos_cli&#039;]);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$row_rsCli[&#039;b_ocultos_cli&#039;] = split(&#039;,&#039;, $row_rsCli[&#039;b_ocultos_cli&#039;]);
$row_rsCli[&#039;b_pool_cli&#039;] = split(&#039;,&#039;, $row_rsCli[&#039;b_pool_cli&#039;]);
$row_rsCli[&#039;b_parking_cli&#039;] = split(&#039;,&#039;, $row_rsCli[&#039;b_parking_cli&#039;]);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:81
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&amp;&amp; trim($row_rsCli[&#039;b_ref_cli&#039;][0]) == &#039;&#039;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&amp;&amp; trim($row_rsCli[&#039;b_ref_cli&#039;][0]) == &#039;&#039;
&amp;&amp; trim($row_rsCli[&#039;b_pool_cli&#039;][0]) == &#039;&#039;
&amp;&amp; trim($row_rsCli[&#039;b_parking_cli&#039;][0]) == &#039;&#039;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:560
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$obrnws = &#039;&#039;;
if( isset($row_rsCli[&#039;b_obranueva_cli&#039;]) &amp;&amp; $row_rsCli[&#039;b_obranueva_cli&#039;] != &#039;&#039; ){
  $obrnws = &quot;AND obra_nueva_prop LIKE &#039;%&quot; . $row_rsCli[&#039;b_obranueva_cli&#039;].&quot;%&#039;&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$obrnws = &#039;&#039;;
if( isset($row_rsCli[&#039;b_obranueva_cli&#039;]) &amp;&amp; $row_rsCli[&#039;b_obranueva_cli&#039;] != &#039;&#039; ){
  $obrnws = &quot;AND obra_nueva_prop LIKE &#039;%&quot; . $row_rsCli[&#039;b_obranueva_cli&#039;].&quot;%&#039;&quot;;
}

$pool = &#039;&#039;;
if( isset($row_rsCli[&#039;b_pool_cli&#039;]) &amp;&amp; $row_rsCli[&#039;b_pool_cli&#039;][0] != &#039;&#039; ){
$pools = array();
foreach ($row_rsCli[&#039;b_pool_cli&#039;] as $value) {
  array_push($pools, &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
}
$poolsids = implode(&#039;,&#039;, $pools);
if ($poolsids != &#039;&#039;) {
    $pool = &quot;AND piscina_prop IN (&quot; . $poolsids . &quot;)&quot;;
}
}

$parking = &#039;&#039;;
if( isset($row_rsCli[&#039;b_parking_cli&#039;]) &amp;&amp; $row_rsCli[&#039;b_parking_cli&#039;][0] != &#039;&#039; ){
$parkings = array();
foreach ($row_rsCli[&#039;b_parking_cli&#039;] as $value) {
  array_push($parkings, &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
}
$parkingsids = implode(&#039;,&#039;, $parkings);
if ($parkingsids != &#039;&#039;) {
    $parking = &quot;AND parking_prop IN (&quot; . $parkingsids . &quot;)&quot;;
}
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news2.php:666
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $dirr $urb $pisc2 $gargg $vismarr $obrnws
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$st $ty $bd $bt $ref $prd $prh $loc4 $loc3 $loc2 $loc1 $nprop $op  $ocultos $nw $ven $alq $res $rp $cs $sw $ep $po $rps $or $or2 $m2ut $m2pl $op2 $fav $dir $dirr $urb $pisc2 $gargg $vismarr $obrnws $pool $parking
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:495
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#b_beds_cli, #b_baths_cli, #b_precio_desde_cli, #b_precio_hasta_cli, #b_orientacion_cli).change(function(e) {
  getProps();
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#b_beds_cli, #b_baths_cli, #b_precio_desde_cli, #b_precio_hasta_cli, #b_orientacion_cli, #b_pool_cli, #b_parking_cli&#039;).change(function(e) {
  getProps();
});
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="once">
        <span class="badge badge-dark">11</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido precios por días
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
CREATE TABLE `properties_prices` (
  `id_prc` int(11) NOT NULL AUTO_INCREMENT,
  `property_prc` int(11) NOT NULL,
  `from_prc` date NOT NULL,
  `to_prc` date NOT NULL,
  `price_prc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_prc`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
$lang[&#039;Precios por d&iacute;as&#039;] = &#039;Precios por d&iacute;as&#039;;
$lang[&#039;No se han a&ntilde;dido precios&#039;] = &#039;No se han a&ntilde;adido precios&#039;;
$lang[&#039;Introduzca la fecha inicio&#039;] = &#039;Introduzca la fecha inicio&#039;;
$lang[&#039;Introduzca la fecha final&#039;] = &#039;Introduzca la fecha final&#039;;
$lang[&#039;La fecha de inicio ha de ser anterior a la fecha final&#039;] = &#039;La fecha de inicio ha de ser anterior a la fecha final&#039;;
$lang[&#039;Introduzca el precio&#039;] = &#039;Introduzca el precio&#039;;
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
$lang[&#039;Precios por d&iacute;as&#039;] = &#039;Prices per day&#039;;
$lang[&#039;No se han a&ntilde;dido precios&#039;] = &#039;No prices have been added&#039;;
$lang[&#039;Introduzca la fecha inicio&#039;] = &#039;Enter the start date&#039;;
$lang[&#039;Introduzca la fecha final&#039;] = &#039;Enter the end date&#039;;
$lang[&#039;La fecha de inicio ha de ser anterior a la fecha final&#039;] = &#039;The start date must be before the final date&#039;;
$lang[&#039;Introduzca el precio&#039;] = &#039;Enter the price&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1248
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#preciosm&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Precios mensuales&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#preciosm&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Precios mensuales&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;li&gt;&lt;a href=&quot;#preciod&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Precios por d&iacute;as&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2841
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.preciosm --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.preciosm --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;preciod&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;span class=&quot;ref_prop&quot;&gt;&lt;/span&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Precios por d&iacute;as&#039;); ?&gt;&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-3&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;from_prc&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;from_prc&quot; id=&quot;from_prc&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepick&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-3&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;to_prc&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;to_prc&quot; id=&quot;to_prc&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control datepick&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-3&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;price_prc&quot;&gt;&lt;?php __(&#039;Precio&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;price_prc&quot; id=&quot;price_prc&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;/div&gt;
                    &lt;small class=&quot;help-block&quot;&gt;&lt;?php __(&#039;Sin puntos ni comas 1.000 = 1000 | 0 = Consultar&#039;); ?&gt;&lt;/small&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-3&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;br&gt;
                        &lt;input type=&quot;hidden&quot; id=&quot;prcid&quot; name=&quot;prcid&quot;&gt;
                        &lt;button type=&quot;button&quot; id=&quot;addBtn&quot; class=&quot;btn btn-success&quot;&gt;&lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/button&gt;
                        &lt;button type=&quot;button&quot; id=&quot;updBtn&quot; class=&quot;btn btn-success&quot; style=&quot;display: none;&quot;&gt;&lt;?php __(&#039;Actualizar&#039;); ?&gt;&lt;/button&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;

            &lt;hr&gt;

            &lt;div id=&quot;precios-tbl&quot;&gt;&lt;/div&gt;

        &lt;/div&gt; &lt;!--/.panel-body --&gt;

    &lt;/div&gt; &lt;!--/.panel --&gt;

&lt;/div&gt; &lt;!--/.preciod --&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4150
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var confirmDupli = &#039;&lt;?php __(&#039;&iquest;Seguro que desea duplicar este inmueble?&#039;); ?&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var confirmDupli = &#039;&lt;?php __(&#039;&iquest;Seguro que desea duplicar este inmueble?&#039;); ?&gt;&#039;;
var alertFinicio = &#039;&lt;?php __(&#039;Introduzca la fecha inicio&#039;); ?&gt;&#039;;
var alertFfinal = &#039;&lt;?php __(&#039;Introduzca la fecha final&#039;); ?&gt;&#039;;
var alertFmenor = &#039;&lt;?php __(&#039;La fecha de inicio ha de ser anterior a la fecha final&#039;); ?&gt;&#039;;
var alertFprice = &#039;&lt;?php __(&#039;Introduzca el precio&#039;); ?&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
function reloadPrices() {
    $.get(&#039;prec-list.php&#039;, { id_prop: idProperty, lang: appLang }, function(data) {
        $(&#039;#precios-tbl&#039;).html(data);
    });
}

reloadPrices();

$(document).on(&#039;click&#039;, &#039;#addBtn&#039;, function(e) {

    e.preventDefault();

    if($(&#039;#from_prc&#039;).val() == &#039;&#039;) {
        alert(alertFinicio);
        return false;
    }

    if($(&#039;#to_prc&#039;).val() == &#039;&#039;) {
        alert(alertFfinal);
        return false;
    }

    if(new Date($(&#039;#from_prc&#039;).val()).getTime() &gt; new Date($(&#039;#to_prc&#039;).val()).getTime()) {
        alert(alertFmenor);
        return false;
    }

    if($(&#039;#price_prc&#039;).val() == &#039;&#039;) {
        alert(alertFprice);
        return false;
    }

    $.get(&#039;prec-save.php&#039;, { from_prc: $(&#039;#from_prc&#039;).val(), to_prc: $(&#039;#to_prc&#039;).val(), price_prc: $(&#039;#price_prc&#039;).val(), KT_Insert1: &#039;1&#039;, id_prop: idProperty, lang: appLang }, function(data) {
        if(data == &#039;ok&#039;) {
              $(&#039;#from_prc&#039;).val(&#039;&#039;);
              $(&#039;#to_prc&#039;).val(&#039;&#039;);
              $(&#039;#price_prc&#039;).val(&#039;&#039;);
              reloadPrices();
        }
    });

});

$(document).on(&#039;click&#039;, &#039;#updBtn&#039;, function(e) {

    e.preventDefault();

    if($(&#039;#from_prc&#039;).val() == &#039;&#039;) {
        alert(alertFinicio);
        return false;
    }

    if($(&#039;#to_prc&#039;).val() == &#039;&#039;) {
        alert(alertFfinal);
        return false;
    }

    if(new Date($(&#039;#from_prc&#039;).val()).getTime() &gt; new Date($(&#039;#to_prc&#039;).val()).getTime()) {
        alert(alertFmenor);
        return false;
    }

    if($(&#039;#price_prc&#039;).val() == &#039;&#039;) {
        alert(alertFprice);
        return false;
    }

    $.get(&#039;prec-save.php&#039;, { id: $(&#039;#prcid&#039;).val(), from_prc: $(&#039;#from_prc&#039;).val(), to_prc: $(&#039;#to_prc&#039;).val(), price_prc: $(&#039;#price_prc&#039;).val(), KT_Update1: &#039;1&#039;, id_prop: idProperty, lang: appLang }, function(data) {
        if(data == &#039;ok&#039;) {
            $(&#039;#from_prc&#039;).val(&#039;&#039;);
            $(&#039;#to_prc&#039;).val(&#039;&#039;);
            $(&#039;#price_prc&#039;).val(&#039;&#039;);
            $(&#039;#addBtn&#039;).show();
            $(&#039;#updBtn&#039;).hide();
            reloadPrices();
        }
    });

});

$(document).on(&#039;click&#039;, &#039;.editprec&#039;, function(e) {
    e.preventDefault();
    btn = $(this);
    $.get(&#039;prec-get.php&#039;, { id: btn.data(&#039;id&#039;), id_prop: idProperty, lang: appLang, KT_Delete1: &#039;1&#039; }, function(data) {
        if(data != &#039;&#039;) {
        n=data.split(&quot;@&quot;);
            $(&#039;#from_prc&#039;).val(n[0]);
            $(&#039;#to_prc&#039;).val(n[1]);
            $(&#039;#price_prc&#039;).val(n[2]);
            $(&#039;#prcid&#039;).val(n[3]);
            $(&#039;#addBtn&#039;).hide();
            $(&#039;#updBtn&#039;).show();
            reloadPrices();
        }
    });
});

$(document).on(&#039;click&#039;, &#039;.delprec&#039;, function(e) {
    e.preventDefault();
    btn = $(this);
    if (confirm(&quot;&iquest;Seguro que desea borrar este registro?&quot;)) {
        $.get(&#039;prec-save.php&#039;, { id: btn.data(&#039;id&#039;), id_prop: idProperty, lang: appLang, KT_Delete1: &#039;1&#039; }, function(data) {
            if(data == &#039;ok&#039;) {
                reloadPrices();
            }
        });
    }
});
            </code>
        </pre>
        <hr>
        Subir los archivos:<br>
        <code>/intramedianet/properties/prec-get.php</code><br>
        <code>/intramedianet/properties/prec-list.php</code><br>
        <code>/intramedianet/properties/prec-save.php</code>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/property.php:261
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;view360&quot;, $view360);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;view360&quot;, $view360);

$precios = getRecords(&quot;
SELECT properties_prices.from_prc,
    properties_prices.to_prc,
    properties_prices.price_prc
FROM properties_prices
WHERE properties_prices.property_prc = &#039;&quot;.$tokens[1].&quot;&#039; AND properties_prices.to_prc &gt;= CURDATE()
ORDER BY properties_prices.from_prc ASC, properties_prices.to_prc ASC
&quot;);

$smarty-&gt;assign(&quot;precios&quot;, $precios);
            </code>
        </pre>
        <hr>
        Añadir a los archivos de texto: <code>/resources/lang_*.php</code>, los siguientes textos:
        <pre>
            <code class="php">
da -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Priser pr. Dag&quot;;
de -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Preise pro Tag&quot;;
en -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Prices per day&quot;;
es -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Precios por d&iacute;a&quot;;
fi -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Hinnat p&auml;iv&auml;ss&auml;&quot;;
fr -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Prix &#x200b;&#x200b;par jour&quot;;
is -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Ver&eth; &aacute; dag&quot;;
nl -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Prijzen per dag&quot;;
no -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Priser per dag&quot;;
ru -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;&#x426;&#x435;&#x43d;&#x44b; &#x432; &#x434;&#x435;&#x43d;&#x44c;&quot;;
se -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;Priser per dag&quot;;
zh -&gt; $langStr[&quot;Precios por d&iacute;a&quot;] = &quot;&#x6bcf;&#x5929;&#x7684;&#x4ef7;&#x683c;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tabs.tpl:33
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $property[0].precio_1_prop != &#039;&#039; || $property[0].precio_2_prop != &#039;&#039; || $property[0].precio_3_prop != &#039;&#039; || $property[0].precio_4_prop != &#039;&#039; || $property[0].precio_5_prop != &#039;&#039; || $property[0].precio_6_prop != &#039;&#039; || $property[0].precio_7_prop != &#039;&#039; || $property[0].precio_8_prop != &#039;&#039; || $property[0].precio_9_prop != &#039;&#039; || $property[0].precio_10_prop != &#039;&#039; || $property[0].precio_11_prop != &#039;&#039; || $property[0].precio_12_prop != &#039;&#039;}
    &lt;li class=&quot;nav-item&quot;&gt;&lt;a href=&quot;#pane-preciosmes&quot;  class=&quot;nav-link&quot; role=&quot;tab&quot; id=&quot;tab-preciosmes&quot; data-toggle=&quot;tab&quot; aria-controls=&quot;preciosmes&quot;&gt;{$lng_precios_mensuales}&lt;/a&gt;&lt;/li&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $property[0].precio_1_prop != &#039;&#039; || $property[0].precio_2_prop != &#039;&#039; || $property[0].precio_3_prop != &#039;&#039; || $property[0].precio_4_prop != &#039;&#039; || $property[0].precio_5_prop != &#039;&#039; || $property[0].precio_6_prop != &#039;&#039; || $property[0].precio_7_prop != &#039;&#039; || $property[0].precio_8_prop != &#039;&#039; || $property[0].precio_9_prop != &#039;&#039; || $property[0].precio_10_prop != &#039;&#039; || $property[0].precio_11_prop != &#039;&#039; || $property[0].precio_12_prop != &#039;&#039;}
    &lt;li class=&quot;nav-item&quot;&gt;&lt;a href=&quot;#pane-preciosmes&quot;  class=&quot;nav-link&quot; role=&quot;tab&quot; id=&quot;tab-preciosmes&quot; data-toggle=&quot;tab&quot; aria-controls=&quot;preciosmes&quot;&gt;{$lng_precios_mensuales}&lt;/a&gt;&lt;/li&gt;
{/if}

{if $precios[0].price_prc != &#039;&#039;}
    &lt;li class=&quot;nav-item&quot;&gt;&lt;a href=&quot;#pane-preciosdia&quot;  class=&quot;nav-link&quot; role=&quot;tab&quot; id=&quot;tab-preciosdia&quot; data-toggle=&quot;tab&quot; aria-controls=&quot;preciosdia&quot;&gt;{$lng_precios_por_dia}&lt;/a&gt;&lt;/li&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tabs-panels.tpl:136
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $property[0].precio_1_prop != &#039;&#039; || $property[0].precio_2_prop != &#039;&#039; || $property[0].precio_3_prop != &#039;&#039; || $property[0].precio_4_prop != &#039;&#039; || $property[0].precio_5_prop != &#039;&#039; || $property[0].precio_6_prop != &#039;&#039; || $property[0].precio_7_prop != &#039;&#039; || $property[0].precio_8_prop != &#039;&#039; || $property[0].precio_9_prop != &#039;&#039; || $property[0].precio_10_prop != &#039;&#039; || $property[0].precio_11_prop != &#039;&#039; || $property[0].precio_12_prop != &#039;&#039;}
&lt;div id=&quot;pane-preciosmes&quot; class=&quot;cardx tab-pane fade&quot; role=&quot;tabpanel&quot; aria-labelledby=&quot;tab-preciosmes&quot;&gt;
  &lt;div class=&quot;card-header p-0&quot; role=&quot;tab&quot; id=&quot;heading-preciosmes&quot;&gt;
    &lt;h5 class=&quot;mb-0&quot;&gt;
      &lt;a class=&quot;collapsed&quot; data-toggle=&quot;collapse&quot; href=&quot;#collapse-preciosmes&quot; aria-expanded=&quot;false&quot; data-target=&quot;#collapse-preciosmes&quot;&gt;
        {$lng_precios_mensuales}
      &lt;/a&gt;
    &lt;/h5&gt;
  &lt;/div&gt;
  &lt;div id=&quot;collapse-preciosmes&quot; class=&quot;collapse&quot; role=&quot;tabpanel&quot; data-parent=&quot;#pn-content&quot; aria-labelledby=&quot;heading-preciosmes&quot;&gt;
    &lt;div class=&quot;card-body&quot;&gt;
      {include file=&quot;file:modules/property/view/partials/tab-preciosmes.tpl&quot; }
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $property[0].precio_1_prop != &#039;&#039; || $property[0].precio_2_prop != &#039;&#039; || $property[0].precio_3_prop != &#039;&#039; || $property[0].precio_4_prop != &#039;&#039; || $property[0].precio_5_prop != &#039;&#039; || $property[0].precio_6_prop != &#039;&#039; || $property[0].precio_7_prop != &#039;&#039; || $property[0].precio_8_prop != &#039;&#039; || $property[0].precio_9_prop != &#039;&#039; || $property[0].precio_10_prop != &#039;&#039; || $property[0].precio_11_prop != &#039;&#039; || $property[0].precio_12_prop != &#039;&#039;}
&lt;div id=&quot;pane-preciosmes&quot; class=&quot;cardx tab-pane fade&quot; role=&quot;tabpanel&quot; aria-labelledby=&quot;tab-preciosmes&quot;&gt;
  &lt;div class=&quot;card-header p-0&quot; role=&quot;tab&quot; id=&quot;heading-preciosmes&quot;&gt;
    &lt;h5 class=&quot;mb-0&quot;&gt;
      &lt;a class=&quot;collapsed&quot; data-toggle=&quot;collapse&quot; href=&quot;#collapse-preciosmes&quot; aria-expanded=&quot;false&quot; data-target=&quot;#collapse-preciosmes&quot;&gt;
        {$lng_precios_mensuales}
      &lt;/a&gt;
    &lt;/h5&gt;
  &lt;/div&gt;
  &lt;div id=&quot;collapse-preciosmes&quot; class=&quot;collapse&quot; role=&quot;tabpanel&quot; data-parent=&quot;#pn-content&quot; aria-labelledby=&quot;heading-preciosmes&quot;&gt;
    &lt;div class=&quot;card-body&quot;&gt;
      {include file=&quot;file:modules/property/view/partials/tab-preciosmes.tpl&quot; }
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
{/if}

{if $precios[0].price_prc != &#039;&#039;}
&lt;div id=&quot;pane-preciosdia&quot; class=&quot;cardx tab-pane fade&quot; role=&quot;tabpanel&quot; aria-labelledby=&quot;tab-preciosdia&quot;&gt;
  &lt;div class=&quot;card-header p-0&quot; role=&quot;tab&quot; id=&quot;heading-preciosdia&quot;&gt;
    &lt;h5 class=&quot;mb-0&quot;&gt;
      &lt;a class=&quot;collapsed&quot; data-toggle=&quot;collapse&quot; href=&quot;#collapse-preciosdia&quot; aria-expanded=&quot;false&quot; data-target=&quot;#collapse-preciosdia&quot;&gt;
        {$lng_precios_por_dia}
      &lt;/a&gt;
    &lt;/h5&gt;
  &lt;/div&gt;
  &lt;div id=&quot;collapse-preciosdia&quot; class=&quot;collapse&quot; role=&quot;tabpanel&quot; data-parent=&quot;#pn-content&quot; aria-labelledby=&quot;heading-preciosdia&quot;&gt;
    &lt;div class=&quot;card-body&quot;&gt;
      {include file=&quot;file:modules/property/view/partials/tab-preciosdia.tpl&quot; }
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
{/if}
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/modules/property/view/partials/tab-preciosdia.tpl</code> del master de esta versión.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>