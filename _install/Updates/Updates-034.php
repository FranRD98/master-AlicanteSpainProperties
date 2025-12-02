<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 5 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 03-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en clientes interesados, no busca bien las habitaciones</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Nueva pestaña para seleccionar las imagenes de los pdf</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en clientes interesados, no busca bien las habitaciones
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/interested-clients-50.php:117
/intramedianet/properties/interested-clients.php:116
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($row_rsClients[&#039;b_beds_cli&#039;] &gt;= $_GET[&#039;hab&#039;]) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($_GET[&#039;hab&#039;] &gt;= $row_rsClients[&#039;b_beds_cli&#039;]) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Nueva pestaña para seleccionar las imagenes de los pdf
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_images` ADD COLUMN `order_pdf_img` INT NULL DEFAULT 0 AFTER `order_img`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:194
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImages = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$property_id.&quot;&#039; ORDER BY order_img&quot;;
$rsImages = mysql_query($query_rsImages, $inmoconn) or die(mysql_error());
$row_rsImages = mysql_fetch_assoc($rsImages);
$totalRows_rsImages = mysql_num_rows($rsImages);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImages = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$property_id.&quot;&#039; ORDER BY order_img&quot;;
$rsImages = mysql_query($query_rsImages, $inmoconn) or die(mysql_error());
$row_rsImages = mysql_fetch_assoc($rsImages);
$totalRows_rsImages = mysql_num_rows($rsImages);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsImagesPDF = &quot;SELECT * FROM properties_images WHERE property_img = &#039;&quot;.$property_id.&quot;&#039; ORDER BY order_pdf_img&quot;;
$rsImagesPDF = mysql_query($query_rsImagesPDF, $inmoconn) or die(mysql_error());
$row_rsImagesPDF = mysql_fetch_assoc($rsImagesPDF);
$totalRows_rsImagesPDF = mysql_num_rows($rsImagesPDF);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1263
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#imagenes&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Im&aacute;genes&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li&gt;&lt;a href=&quot;#imagenes&quot; data-toggle=&quot;tab&quot;&gt;&lt;?php __(&#039;Im&aacute;genes&#039;); ?&gt;&lt;/a&gt;&lt;/li&gt;
&lt;li&gt;&lt;a href=&quot;#imagenesPDF&quot; data-toggle=&quot;tab&quot; id=&quot;imgsPDF&quot;&gt;&lt;?php __(&#039;Im&aacute;genes&#039;); ?&gt; PDF&lt;/a&gt;&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2165
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.imagenes --&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt; &lt;!--/.imagenes --&gt;

&lt;div class=&quot;tab-pane&quot; id=&quot;imagenesPDF&quot;&gt;

    &lt;div class=&quot;panel panel-primary&quot;&gt;

        &lt;div class=&quot;panel-heading&quot;&gt;
            &lt;span class=&quot;ref_prop&quot;&gt;&lt;/span&gt;
            &lt;h3 class=&quot;panel-title&quot;&gt;&lt;?php __(&#039;Im&aacute;genes&#039;); ?&gt; PDF&lt;/h3&gt;
        &lt;/div&gt;

        &lt;div class=&quot;panel-body&quot;&gt;

            &lt;small&gt;&lt;i class=&quot;fa fa-arrows-alt&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Para cambiar el orden de las fotos, arrastre y suelte la fotos en la ubicaci&oacute;n deseada&#039;); ?&gt;.&lt;/small&gt;

            &lt;hr&gt;

            &lt;div id=&quot;img-order-loadingPDF&quot;&gt;&lt;/div&gt;

            &lt;ul class=&quot;thumbnails clearfix&quot; id=&quot;images-listPDF&quot;&gt;

            &lt;?php if($totalRows_rsImagesPDF &gt; 0) { ?&gt;

            &lt;?php do { ?&gt;

            &lt;?php if($row_rsImagesPDF[&#039;image_img&#039;] != &#039;&#039;) { ?&gt;

            &lt;li class=&quot;pull-left&quot; id=&quot;order_&lt;?php echo $row_rsImagesPDF[&#039;id_img&#039;] ?&gt;&quot;&gt;

            &lt;div class=&quot;img-thumbnail pull-left&quot;&gt;
                &lt;?php if (file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/properties/thumbnails/&#039;.$row_rsImagesPDF[&#039;id_img&#039;].&#039;_md.jpg&#039;)) { ?&gt;
                    &lt;a href=&quot;/media/images/properties/thumbnails/&lt;?php echo $row_rsImagesPDF[&#039;id_img&#039;] ?&gt;_md.jpg&quot; data-toggle=&quot;lightbox&quot;&gt;&lt;img src=&quot;/media/images/properties/thumbnails/&lt;?php echo $row_rsImagesPDF[&#039;id_img&#039;] ?&gt;_sm.jpg&quot; alt=&quot;&quot; style=&quot;height: 100px;&quot;&gt;&lt;/a&gt;
                &lt;?php } else { ?&gt;
                    &lt;img src=&quot;/intramedianet/includes/assets/img/no_image.jpg&quot; alt=&quot;&quot; style=&quot;height: 100px;&quot;&gt;
                &lt;?php } ?&gt;
            &lt;/div&gt;

            &lt;/li&gt;

            &lt;?php } ?&gt;

            &lt;?php } while ($row_rsImagesPDF = mysql_fetch_assoc($rsImagesPDF)); ?&gt;

            &lt;?php } ?&gt;

            &lt;/ul&gt;

        &lt;/div&gt; &lt;!--/.panel-body --&gt;

    &lt;/div&gt; &lt;!--/.panel --&gt;

&lt;/div&gt; &lt;!--/.imagenesPDF --&gt;
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
$(&quot;#images-listPDF&quot;).sortable({
    forcePlaceholderSize: true,
    placeholder: &quot;sortable-highlight&quot;,
    update : function () {
    var order = $(&#039;#images-listPDF&#039;).sortable(&#039;serialize&#039;);
    $(&#039;#img-order-loadingPDF&#039;).css({ width: $(&#039;#images-listPDF&#039;).outerWidth(), height: $(&#039;#images-listPDF&#039;).outerHeight() + 5 }).fadeIn();
    $.get(&quot;images_order_pdf.php?&quot;+order, function(data) {
        $(&#039;#img-order-loadingPDF&#039;).fadeOut();
    });
    }
}).disableSelection();

$(document).on(&#039;click&#039;, &#039;#imgsPDF&#039;, function(e) {
    $.get(&quot;images_list_pdf.php?id_prop=&quot; + idProperty, function(data) {
        if(data != &#039;&#039;) {
            $(&#039;#images-listPDF&#039;).html(data);
        }
    });
});
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
$query_rsMax =&quot;SELECT MAX(order_img) + 1  as max FROM properties_images WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMax = mysql_query($query_rsMax, $inmoconn) or die(mysql_error());
$row_rsMax = mysql_fetch_assoc($rsMax);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsMaxPDF =&quot;SELECT MAX(order_pdf_img) + 1  as max FROM properties_images WHERE property_img = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;&quot;;
$rsMaxPDF = mysql_query($query_rsMaxPDF, $inmoconn) or die(mysql_error());
$row_rsMaxPDF = mysql_fetch_assoc($rsMaxPDF);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_upload.php:171
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$row_rsMax[&#039;max&#039;] = ($row_rsMax[&#039;max&#039;] &gt; 0)?$row_rsMax[&#039;max&#039;]:1;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$row_rsMax[&#039;max&#039;] = ($row_rsMax[&#039;max&#039;] &gt; 0)?$row_rsMax[&#039;max&#039;]:1;
$row_rsMaxPDF[&#039;max&#039;] = ($row_rsMaxPDF[&#039;max&#039;] &gt; 1)?$row_rsMaxPDF[&#039;max&#039;]:0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_upload.php:177
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsUserTrad = &quot;INSERT INTO  `properties_images` SET
`property_img`  = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;,
`image_img` = &#039;&quot;.$fileName.&quot;&#039;,
`procesada_img` = &#039;1&#039;,
`order_img`= &quot;.$row_rsMax[&#039;max&#039;].&quot;
&quot;;
$rsUserTrad = mysql_query($query_rsUserTrad, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mysql_select_db($database_inmoconn, $inmoconn);
$query_rsUserTrad = &quot;INSERT INTO  `properties_images` SET
`property_img`  = &#039;&quot;.$_GET[&#039;id_prop&#039;].&quot;&#039;,
`image_img` = &#039;&quot;.$fileName.&quot;&#039;,
`procesada_img` = &#039;1&#039;,
`order_img`= &quot;.$row_rsMax[&#039;max&#039;].&quot;,
`order_pdf_img`= &quot;.$row_rsMaxPDF[&#039;max&#039;].&quot;
&quot;;
$rsUserTrad = mysql_query($query_rsUserTrad, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/vendor/less/app.less:876
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
#images-list, #images-listp, #planos-list, #imagesz-list {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
#images-list, #images-listp, #planos-list, #imagesz-list, #images-listPDF {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/vendor/less/app.less:913
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
#img-order-loading, #planos-order-loading  {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
#img-order-loading, #planos-order-loading, #img-order-loadingPDF  {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/vendor/less/app.less:922
            </code>
        </pre>
        Añadir y compilar:
        <pre>
            <code class="php">
#images-listPDF {
    li .img-thumbnail {
        padding: 10px;
    }
    li:nth-child(1) .img-thumbnail {
        background: #59973E;
    }
    li:nth-child(2) .img-thumbnail {
        background: #A7D6E1;
    }
    li:nth-child(3) .img-thumbnail {
        background: #A7D6E1;
    }
    li:nth-child(4) .img-thumbnail {
        background: #A7D6E1;
    }
}
            </code>
        </pre>
        <div class="alert alert-info" role="alert">
          También se puede subir el archivo que ya esta compilado: <code>/intramedianet/includes/assets/css/app.css</code>
        </div>
        <hr>
        Subir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/images_list_pdf.php
/intramedianet/properties/images_order_pdf.php
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/modules/property/save.php:81
/modules/property/save-mb.php:81
/modules/property/save-a3.php:81
/modules/property/save-a3-mb.php:81
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$images = getRecords(&quot;
    SELECT id_img as img
    FROM properties_images
    WHERE property_img = &#039;&quot;.simpleSanitize(($_GET[&#039;id&#039;])).&quot;&#039;  ORDER BY order_img
&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$images = getRecords(&quot;
    SELECT id_img as img,
    order_pdf_img
    FROM properties_images
    WHERE property_img = &#039;&quot;.simpleSanitize(($_GET[&#039;id&#039;])).&quot;&#039;  ORDER BY order_pdf_img
&quot;);

if ($images[0][&#039;order_pdf_img&#039;] != 1) {
    $images = getRecords(&quot;
        SELECT id_img as img
        FROM properties_images
        WHERE property_img = &#039;&quot;.simpleSanitize(($_GET[&#039;id&#039;])).&quot;&#039;  ORDER BY order_img
    &quot;);
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 4 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>