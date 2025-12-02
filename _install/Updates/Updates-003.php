<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 29 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 22-05-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Mejorada la velocidad al eliminar un inmueble</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Falta el cierre de if en los archivos de menus del panel</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Fallo en las etiquetas hreflang</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido cron para generar las miniaturas</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido checkbox para activar y desactivar las noticias</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejorada la velocidad al eliminar un inmueble
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:424
            </code>
        </pre>
        Cometar:
        <pre>
            <code class="php">
$tblDelObj->addFile("{image_img}", "../../media/images/properties/");
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Falta el cierre de if en los archivos de menus del panel
    </h6>
    <div class="card-body">
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-empleado.php:428
/intramedianet/includes/inc.header-agente.php:54
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;li class=&quot;withtext&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php endif; ?&gt;
&lt;li class=&quot;withtext&quot;&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo en las etiquetas hreflang
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/composer.json:3
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="json">
"stichoza/google-translate-php": "^3.2"
            </code>
        </pre>
        Por:
        <pre>
            <code class="json">
"symfony/console": "^3.3",
"danielstjules/stringy": "~3.1.0",
"stichoza/google-translate-php": "^3.2",
"league/flysystem": "^1.0"
            </code>
        </pre>
        <hr>
        Ejecutar en el terminal en la carpeta: <kbd>/_herramientas</kbd>, el comando:
        <pre>
            <code class="bash">
composer update
            </code>
        </pre>
        <hr>
        Subir el archivo: <kbd>/_herramientas/console</kbd>, a la carpeta: <kbd>/_herramientas</kbd>
        <hr>
        Para userlo ejecutar en el terminal en la carpeta: <kbd>/_herramientas</kbd>, el siguiente comando:
        <pre>
            <code class="bash">
php console t:all "Término a traducir" es
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 5 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido cron para generar las miniaturas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/generar_miniaturas.php:565
            </code>
        </pre>
        Cambiamos todo el contenido por:
        <pre>
            <code class="php">
&lt;?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

$lastUpdateFile = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . '/_herramientas/_cache/last-update.txt';

if (!file_exists($lastUpdateFile) || strtotime('+1 minutes',filemtime($lastUpdateFile)) &lt; strtotime(&quot;now&quot;) || !filesize($lastUpdateFile)) {
    // Cargamos la conexión a MySql
    require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . '/Connections/inmoconn.php' );

    // Cargamos los idiomas de la administración
    require_once( $_SERVER[&quot;DOCUMENT_ROOT&quot;] . '/intramedianet/includes/resources/translate.php' );

    set_time_limit(0);

    global $database_inmoconn, $inmoconn;
    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsImagenes = &quot;SELECT * FROM `properties_images` WHERE procesada_img = 0 ORDER BY id_img DESC&quot;;
    $rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
    $row_rsImagenes = mysql_fetch_assoc($rsImagenes);
    $totalRows_rsImagenes = mysql_num_rows($rsImagenes);

    if ($totalRows_rsImagenes &gt; 0) {
        do {
            if (preg_match('/https?:\/\//', $row_rsImagenes['image_img'])) {
                generateThumbnails($row_rsImagenes['image_img'], $row_rsImagenes['id_img']);
            } else {
                generateThumbnails($_SERVER[&quot;DOCUMENT_ROOT&quot;] . '/media/images/properties/' . $row_rsImagenes['image_img'], $row_rsImagenes['id_img']);
            }
             mysql_select_db($database_inmoconn, $inmoconn);
            $query_rsUserTrad = &quot;
            UPDATE  `properties_images` SET
              `procesada_img` = '1'
              WHERE id_img = '&quot;.$row_rsImagenes['id_img'].&quot;'
            &quot;;
            $rsUserTrad = mysql_query($query_rsUserTrad, $inmoconn) or die(mysql_error());
            file_put_contents($lastUpdateFile, date(&quot;d-m-Y H:i:s&quot;));
        } while ($row_rsImagenes = mysql_fetch_assoc($rsImagenes));
    }
}
            </code>
        </pre>
        <hr>
        Añadimos la carpeta: <kbd>/_herramientas/_cache</kbd>, y le damos permisos de escritura: <kbd>777</kbd>
        <hr>
        En al archivo:  <kbd>/intramedianet/includes/resources/lang_es.php</kbd>, añadimos al final:
        <pre>
            <code class="php">
$lang['Las imagenes se van a  descargar en segundo plano, los inmuebles irán apareciendo en la web una vez se generen las miniaturas. Esto puede llevar bastante tiempo.'] = 'Las imagenes se van a  descargar en segundo plano, los inmuebles irán apareciendo en la web una vez se generen las miniaturas. Esto puede llevar bastante tiempo.';
            </code>
        </pre>
        <hr>
        En al archivo:  <kbd>/intramedianet/includes/resources/lang_en.php</kbd>, añadimos al final:
        <pre>
            <code class="php">
$lang['Las imagenes se van a  descargar en segundo plano, los inmuebles irán apareciendo en la web una vez se generen las miniaturas. Esto puede llevar bastante tiempo.'] = 'The images will be downloaded in the background, the properties will appear on the web once the thumbnails are generated. This can take a long time.';
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils.php:505
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ret .= '&lt;/ul&gt;';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ret .= '&lt;/ul&gt;';
$ret .= '&lt;div style=&quot;clear: both; display: block; padding: 10px 0;font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: bold;&quot;&gt;';
$ret .= __('Las imagenes se van a  descargar en segundo plano, los inmuebles irán apareciendo en la web una vez se generen las miniaturas. Esto puede llevar bastante tiempo.', true);
$ret .= '&lt;/div&gt;';
            </code>
        </pre>
        <hr>
        Añadimos el cron:
        <pre>
            <code class="bash">
*/15 * * * * curl https://dominio/_herramientas/generar_miniaturas.php > /dev/null 2>&1
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/xml/import-start.php:170
/intramedianet/xml/import-cron.php:50
            </code>
        </pre>
        Eliminamos:
        <pre>
            <code class="php">
global $database_inmoconn, $inmoconn;
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagenes = &quot;SELECT * FROM `properties_images` ORDER BY id_img ASC&quot;;
$rsImagenes = mysql_query($query_rsImagenes, $inmoconn) or die(mysql_error());
$row_rsImagenes = mysql_fetch_assoc($rsImagenes);
$totalRows_rsImagenes = mysql_num_rows($rsImagenes);

if ($totalRows_rsImagenes &gt; 0) {
    do {
        set_time_limit(0);
        if (preg_match('/https?:\/\//', $row_rsImagenes['image_img'])) {
            generateThumbnails($row_rsImagenes['image_img'], $row_rsImagenes['id_img']);
        } else {
            generateThumbnails($_SERVER[&quot;DOCUMENT_ROOT&quot;] . '/media/images/properties/' . $row_rsImagenes['image_img'], $row_rsImagenes['id_img']);
        }
         mysql_select_db($database_inmoconn, $inmoconn);
        $query_rsUserTrad = &quot;
        UPDATE  `properties_images` SET
          `procesada_img` = '1'
          WHERE id_img = '&quot;.$row_rsImagenes['id_img'].&quot;'
        &quot;;
        $rsUserTrad = mysql_query($query_rsUserTrad, $inmoconn) or die(mysql_error());
    } while ($row_rsImagenes = mysql_fetch_assoc($rsImagenes));
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 10 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido checkbox para activar y desactivar las noticias
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:309
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;date_nws&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;date_nws&quot;, &quot;&quot;.date(&quot;d-m-Y&quot;).&quot;&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_news-&gt;addColumn(&quot;date_nws&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;date_nws&quot;, &quot;&quot;.date(&quot;d-m-Y&quot;).&quot;&quot;);
$ins_news-&gt;addColumn(&quot;activate_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;activate_nws&quot;, &quot;1&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:336
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;date_nws&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;date_nws&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_news-&gt;addColumn(&quot;date_nws&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;date_nws&quot;);
$upd_news-&gt;addColumn(&quot;activate_nws&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;activate_nws&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news-form.php:435
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;

    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;date_nws&quot;) != '') { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;date_nws&quot;&gt;&lt;?php __('Fecha'); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews['date_nws']); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datepick&quot;&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;date_nws&quot;); ?&gt;
    &lt;/div&gt;

  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-4&quot;&gt;

    &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;date_nws&quot;) != '') { ?&gt;error&lt;?php } ?&gt;&quot;&gt;
        &lt;label for=&quot;date_nws&quot;&gt;&lt;?php __('Fecha'); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsnews['date_nws']); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datepick&quot;&gt;
        &lt;?php echo $tNGs-&gt;displayFieldError(&quot;news&quot;, &quot;date_nws&quot;); ?&gt;
    &lt;/div&gt;

  &lt;/div&gt;
  &lt;div class=&quot;col-md-6&quot;&gt;
      &lt;div class=&quot;checkbox&quot;&gt;
        &lt;br&gt;
        &lt;label&gt;
            &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsnews['activate_nws']),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
            &lt;?php __('Mostrar en la web'); ?&gt;
        &lt;/label&gt;
      &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-data.php:44
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($aColumns, 'date_nws');
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($aColumns, 'activate_nws');
array_push($aColumns, 'date_nws');
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-data.php:182
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sWhere .= $aColumns[$i].&quot; LIKE '%&quot;.mysql_real_escape_string($_GET['sSearch_'.$i]).&quot;%' &quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($aColumns[$i] == 'activate_nws') {
  if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('Sí', true)))) {
      $sWhere .= $aColumns[$i].&quot; = '1' &quot;;
  }
  if (preg_match('/'.strtolower($_GET['sSearch_'.$i]).'/', strtolower(__('No', true)))) {
      $sWhere .= $aColumns[$i].&quot; = '0' &quot;;
  }
} else {
  $sWhere .= $aColumns[$i].&quot; LIKE '%&quot;.mysql_real_escape_string($_GET['sSearch_'.$i]).&quot;%' &quot;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/quicklinks/news-data.php:225
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="sql">
date_nws,
            </code>
        </pre>
        Por:
        <pre>
            <code class="sql">
case activate_nws
    when '1' then '&quot;. __('Sí', true) . &quot;'
    when '0' then '&quot; . __('No', true) . &quot;'
end as activate_nws,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news.php:62
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __('Fecha'); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __('Activado'); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __('Fecha'); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news.php:70
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="html">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; class=&quot;form-control input-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="html">
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;activate_nws&quot; id=&quot;activate_nws&quot;&gt;
    &lt;select name=&quot;activate_nws_sel&quot; id=&quot;activate_nws_sel&quot; class=&quot;form-control input-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __('Todos'); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __('Sí'); ?&gt;&quot;&gt;&lt;?php __('Sí'); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __('No'); ?&gt;&quot;&gt;&lt;?php __('No'); ?&gt;&lt;/option&gt;
   &lt;/select&gt;
&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;date_nws&quot; id=&quot;date_nws&quot; class=&quot;form-control input-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news.php:83
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td colspan=&quot;&lt;?php echo count($languages) + 2 ?&gt;&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __('Cargando datos del servidor'); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td colspan=&quot;&lt;?php echo count($languages)+3 ?&gt;&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __('Cargando datos del servidor'); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/news.php:99
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="javascript">
var numCols = &lt;?javascript echo count($languages)+ 1; ?&gt;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var numCols = &lt;?php echo count($languages)+2; ?&gt;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/_js/news-list.js:3
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="javascript">
var oTable, asInitVals = [];
            </code>
        </pre>
        Por:
        <pre>
            <code class="javascript">
$('#activate_nws_sel').change(function(e) {
    $('#activate_nws').val($(this).val()).trigger('keyup');
});
var oTable, asInitVals = [];
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/_js/news-list.js:36
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="javascript">
oTable.fnDraw();
            </code>
        </pre>
        Por:
        <pre>
            <code class="javascript">
oTable.fnDraw();
$('select').prop('selectedIndex',0);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/_js/news-list.js:50
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="javascript">
toggleScrollBarIcon();
            </code>
        </pre>
        Por:
        <pre>
            <code class="javascript">
toggleScrollBarIcon();
if ($('#activate_nws').val() != '') {
    $('#activate_nws_sel').val($('#activate_nws').val() );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/_js/news-list.js:55
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&quot;columnDefs&quot;: [
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&quot;columnDefs&quot;: [
    {
        &quot;render&quot;: function ( data, type, row ) {
            if (data == 'No') {
                btns  = '&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;';
            } else{
                btns  = '&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;';
            }
            return  btns;
        },
        &quot;targets&quot;: numCols - 2
    },
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/index.php:191
/modules/news/news.php:239
/modules/news/news.php:258
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE news.title_&quot;.$lang.&quot;_nws  != '' AND news.content_&quot;.$lang.&quot;_nws != '' AND type_nws = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE news.title_&quot;.$lang.&quot;_nws  != '' AND news.content_&quot;.$lang.&quot;_nws != '' AND type_nws = 1 AND activate_nws = 1
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/sitemap.php:61
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE type_nws = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE type_nws = 1 AND activate_nws = 1
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/sitemap/sitemap.php:162
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE news.title_&quot;.$lang.&quot;_nws  != '' AND news.content_&quot;.$lang.&quot;_nws != '' AND type_nws = 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE news.title_&quot;.$lang.&quot;_nws  != '' AND news.content_&quot;.$lang.&quot;_nws != '' AND type_nws = 1 AND activate_nws = 1
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 10 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>