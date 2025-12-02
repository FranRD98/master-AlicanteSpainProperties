<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 5 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 21-05-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadida el número de versión del master al pie del panel</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> En el listado de inmuebles de la ficha de un propietario no muestra el teléfono si el segundo esta vacío</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadida el número de versión del master al pie del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.footer.php:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;p&gt;© &lt;?php echo date( &quot;Y&quot;); ?&gt; | Mediaelx Web Design&lt;/p&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;p&gt;© &lt;?php echo date( &quot;Y&quot;); ?&gt; | Mediaelx Web Design &lt;br&gt; &lt;small style=&quot;font-size: 70%;&quot;&gt;VER.: &lt;?php echo file_get_contents($_SERVER[&quot;DOCUMENT_ROOT&quot;] . '/version.md'); ?&gt;&lt;/small&gt;&lt;/p&gt;
            </code>
        </pre>
        <hr>
        Añadir el archivo: `/versions.md`, con el texto `002`.
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> En el listado de inmuebles de la ficha de un propietario no muestra el teléfono si el segundo esta vacío
    </h6>
    <div class="card-body">
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli-int.php:565
/intramedianet/properties/properties-client-data-cli-intno.php:565
/intramedianet/properties/properties-client-data-cli.php:574
/intramedianet/properties/properties-client-data.php:529
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
CONCAT(nombre_pro, ' ', apellidos_pro) as nombre_pro,
CONCAT(telefono_fijo_pro, '&lt;br&gt;', telefono_movil_pro) as telefono_fijo_pro
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
CONCAT_WS(' ', nombre_pro, apellidos_pro) as nombre_pro,
CONCAT_WS('&lt;br&gt;', telefono_fijo_pro, telefono_movil_pro) as telefono_fijo_pro
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 4 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>