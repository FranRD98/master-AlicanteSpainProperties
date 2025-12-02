<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 22-01-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en el listado de consultas almacenadas desde el formulario de contacto</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Actualización API Fotocasa</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en el listado de consultas almacenadas desde el formulario de contacto
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/consultas-data.php:325
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($aColumns[$i] == &#039;text_con&#039;) {

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsMenu = &quot;SELECT id_prop FROM properties_properties WHERE referencia_prop = &#039;&quot;.$aRow[ $aColumns[$i] ].&quot;&#039; LIMIT 1&quot;;
$rsMenu = mysql_query($query_rsMenu, $inmoconn) or die(mysql_error());
$row_rsMenu = mysql_fetch_assoc($rsMenu);

$row[] = &#039;&lt;div style=&quot;font-size: 12px;&quot;&gt;&#039;  . nl2br($aRow[ $aColumns[$i] ]) . &#039;&lt;/div&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($aColumns[$i] == &#039;text_con&#039;) {

    $row[] = &#039;&lt;div style=&quot;font-size: 12px;&quot;&gt;&#039;  . nl2br($aRow[ $aColumns[$i] ]) . &#039;&lt;/div&gt;&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Actualización API Fotocasa
    </h6>
    <div class="card-body">
        Sustituir la carpeta <code>/intramedianet/properties/fotocasa</code> por la de esta versión
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>