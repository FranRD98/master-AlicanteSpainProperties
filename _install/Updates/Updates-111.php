<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 07-10-2024</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Rangos de precio en buscador:  añadir puntos para separar los miles</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-plus-circle text-success"></i> Mostrar ID de vendedores en el listado compradores</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-plus-circle text-success"></i> Exportar por CSV buyers y Vendors que venga esa ID</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido poder eliminar consultas de inmuebles, bajada de precio y consulta general</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadida A place in the sun al parseador de consultas portales</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Fallo en noticias del front</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-bug text-danger"></i> Faltan carpetas en el master</a></li>
        <li><a href="#sec8"><i class="fas fz-fw fa-bug text-danger"></i> Al enviar un mail desde cruces con una plantilla, no se remplaza {{CLIENT}}</a></li>
        <li><a href="#sec9"><i class="fas fz-fw fa-bug text-danger"></i> Fix errores al activar Letsinmo</a></li>
        <li><a href="#sec10"><i class="fas fz-fw fa-bug text-danger"></i> Error en enviar emails a clientes desde el CRM</a></li>
        <li><a href="#sec11"><i class="fas fz-fw fa-bug text-danger"></i> Fallo ortográfico en imagen</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Rangos de precio en buscador:  añadir puntos para separar los miles
    </h6>
    <div class="card-body">
        Susutituimos el archivo /js/source/precios.js y recompilamos, si no recompilamos, susutituimos el archivo /js/plugins.js.
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties.php:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ( isset($_GET[&#039;prhs&#039;]) &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;0&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;1000000&#039; ) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ( isset($_GET[&#039;prhs&#039;]) &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;0&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;2000000&#039; ) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/properties-map.php:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ( isset($_GET[&#039;prhs&#039;]) &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;1000000&#039; ) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ( isset($_GET[&#039;prhs&#039;]) &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;2000000&#039; ) {
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/total.php:14
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ( isset($_GET[&#039;prhs&#039;]) &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;1000000&#039; ) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ( isset($_GET[&#039;prhs&#039;]) &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;&#039; &amp;&amp; $_GET[&#039;prhs&#039;] != &#039;2000000&#039; ) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Mostrar ID de vendedores en el listado compradores
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:55
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;ID&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:78
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;type_pro&quot; id=&quot;type_pro&quot;&gt;
    &lt;select name=&quot;type_pro_sel&quot; id=&quot;type_pro_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;1&quot;&gt;&lt;?php __(&#039;Particular&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;2&quot;&gt;&lt;?php __(&#039;Constructor&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;3&quot;&gt;&lt;?php __(&#039;Banco&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;
&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;id_pro&quot; id=&quot;id_pro&quot; class=&quot;form-control input-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;type_pro&quot; id=&quot;type_pro&quot;&gt;
    &lt;select name=&quot;type_pro_sel&quot; id=&quot;type_pro_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;1&quot;&gt;&lt;?php __(&#039;Particular&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;2&quot;&gt;&lt;?php __(&#039;Constructor&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;3&quot;&gt;&lt;?php __(&#039;Banco&#039;); ?&gt;&lt;/option&gt;
   &lt;/select&gt;
&lt;/td&gt;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:101
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td colspan=&quot;11&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td colspan=&quot;12&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:116
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var numCols = 10;
            </code>
        </pre>
        Por:
        <pre>
var numCols = 11;
            <code class="php">
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data.php:36
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$aColumns = array( &#039;type_pro&#039;, &#039;nombre_pro&#039;, &#039;workers_pro&#039;, &#039;email_pro&#039;, &#039;telefono_fijo_pro&#039;, &#039;telefono_movil_pro&#039;, &#039;status_pro&#039;, &#039;captado_por_pro&#039;, &#039;next_call_pro&#039;, &#039;fecha_alta_pro&#039;, &#039;id_pro&#039; );
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$aColumns = array( &#039;id2_pro&#039;, &#039;type_pro&#039;, &#039;nombre_pro&#039;, &#039;workers_pro&#039;, &#039;email_pro&#039;, &#039;telefono_fijo_pro&#039;, &#039;telefono_movil_pro&#039;, &#039;status_pro&#039;, &#039;captado_por_pro&#039;, &#039;next_call_pro&#039;, &#039;fecha_alta_pro&#039;, &#039;id_pro&#039; );
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data.php:194
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($aColumns[$i] == &#039;id2_pro&#039;) {
    $sWhere .= &quot;id_pro LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
} else {
    $sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
}
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-data.php:247
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
id_pro
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
id_pro AS id2_pro,
id_pro
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-list.js:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
null
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
null,
null,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Exportar por CSV buyers y Vendors que venga esa ID
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-download-csv.php:459
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SELECT SQL_CALC_FOUND_ROWS
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
SELECT SQL_CALC_FOUND_ROWS
id_cli AS ID,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-download-csv.php:311
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SELECT SQL_CALC_FOUND_ROWS
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
SELECT SQL_CALC_FOUND_ROWS
id_pro AS ID,
case type_pro
    when &#039;1&#039; then &#039;&quot;. __(&#039;Particular&#039;, true) . &quot;&#039;
    when &#039;2&#039; then &#039;&quot; . __(&#039;Constructor&#039;, true) . &quot;&#039;
    when &#039;3&#039; then &#039;&quot; . __(&#039;Banco&#039;, true) . &quot;&#039;
end as Type,
REPLACE(workers_pro, &#039;@@@@@@&#039;, &#039;\n&#039;) AS Contact Persons,
email_pro AS Email,
telefono_fijo_pro AS Phone,
telefono_movil_pro AS Phone_2,
CONCAT_WS(&#039; &#039;, nombre_pro, apellidos_pro) AS Name,
(SELECT category_&quot;.$lang_adm.&quot;_sts  FROM properties_owner_states WHERE id_sts = status_pro) as Status,
(SELECTCT category_&quot;.$lang_adm.&quot;_cap  FROM properties_owner_captado WHERE id_cap = captado_por_pro) as Collaborator
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido poder eliminar consultas de inmuebles, bajada de precio y consulta general
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/report-bajada-search.js:43
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns  = &#039;&lt;a href=&quot;/intramedianet/properties/add_client_from_bajada.php?c=&#039; + idBajClient + &#039;&quot; target=&quot;_blank&quot; class=&quot;btn &#039;+ colorBtn +&#039; btn-sm w-100&quot;&gt;&#039;+convertClientText+&#039;&lt;/a&gt; &#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns  = &#039;&lt;a href=&quot;/intramedianet/properties/add_client_from_bajada.php?c=&#039; + idBajClient + &#039;&quot; target=&quot;_blank&quot; class=&quot;btn &#039;+ colorBtn +&#039; btn-sm&quot;&gt;&#039;+convertClientText+&#039;&lt;/a&gt; &#039;;
btns  += &#039;&lt;a href=&quot;/intramedianet/properties/del-bajada.php?id=&#039; + data + &#039;&quot; class=&quot;btn btn-danger btn-sm del-bajada2&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039;+ dtEliminar +&#039;&lt;/a&gt; &#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/bajada.php:178
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th id=&quot;actions&quot;&gt;&lt;div class=&quot;panel-heading&quot;&gt;&lt;/div&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th id=&quot;actions&quot; style=&quot;min-width: 210px;&quot;&gt;&lt;div class=&quot;panel-heading&quot;&gt;&lt;/div&gt;&lt;/th&gt;
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/bajada.php:218
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/script&gt;

&lt;script&gt;
    $(document).on(&#039;click&#039;, &#039;.del-bajada2&#039;, function(e) {
        e.preventDefault();

        tb = $(this);
        vid = tb.attr(&#039;href&#039;);

        Swal.fire({
            title: delRecord,
            text: delRecord2,
            icon: &quot;warning&quot;,
            showCancelButton: true,
            confirmButtonClass: &#039;btn btn-success w-xs me-2 mt-2&#039;,
            cancelButtonClass: &#039;btn btn-danger w-xs mt-2&#039;,
            confirmButtonText: delRecordYes,
            cancelButtonText: delRecordNo,
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                $.get(vid, function(data) {
                    if(data == &#039;ok&#039;) {
                        tb.closest(&#039;tr&#039;).fadeOut(&#039;slow&#039;, function() { $(this).remove(); });
                    }
                });
            }
        });

        return false;

    });
&lt;/script&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadida A place in the sun al parseador de consultas portales
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/email.php:129
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$idPisoscom = &#039;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$idPisoscom = &#039;&#039;;
$idAPITS = &#039;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/_inc.php:25
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
preg_match_all(&#039;/&lt;img[^&gt;]+&gt;/i&#039;,$html_string, $result);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
preg_match_all(&#039;/&lt;img[^&gt;]+&gt;/i&#039;,(string)$html_string, $result);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/update-client.php:73
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case &#039;pisos.com&#039;:
    $source = $idPisoscom;
    break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case &#039;pisos.com&#039;:
    $source = $idPisoscom;
    break;
case &#039;aplaceinthesun.com&#039;:
    $source = $idAPITS;
    break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/add-client.php:68
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case &#039;pisos.com&#039;:
    $source = $idPisoscom;
    break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case &#039;pisos.com&#039;:
    $source = $idPisoscom;
    break;
case &#039;aplaceinthesun.com&#039;:
    $source = $idAPITS;
    break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/_inc.parse_providers.php:10
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$providers = array('todopisosalicante.com', 'envios.ventadepisos.com', 'granmanzana.es', 'moveagain.co.uk', 'vivados.es', 'kyero.com', 'rightmove.co.uk', 'thinkspain.com', 'email.green-acres.com', 'idealista.com', 'costadelhome.com', 'zpg.co.uk'/*ZOOPLA*/, 'yaencontre.com', 'envios.habitaclia.com', 'trovimap.com', 'indomio.es', 'tucasa.com', 'todopisospain.com', 'messaging.fotocasa.es','fotocasa.es','listglobally.com'/*Properstar Concierge*/, 'broker.outbound.trovimap.com', 'pisos.com');
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$providers = array(&#039;todopisosalicante.com&#039;, &#039;envios.ventadepisos.com&#039;, &#039;granmanzana.es&#039;, &#039;moveagain.co.uk&#039;, &#039;vivados.es&#039;, &#039;kyero.com&#039;, &#039;rightmove.co.uk&#039;, &#039;thinkspain.com&#039;, &#039;email.green-acres.com&#039;, &#039;idealista.com&#039;, &#039;costadelhome.com&#039;, &#039;zpg.co.uk&#039;/*ZOOPLA*/, &#039;yaencontre.com&#039;, &#039;envios.habitaclia.com&#039;, &#039;trovimap.com&#039;, &#039;indomio.es&#039;, &#039;tucasa.com&#039;, &#039;todopisospain.com&#039;, &#039;messaging.fotocasa.es&#039;,&#039;fotocasa.es&#039;,&#039;listglobally.com&#039;/*Properstar Concierge*/, &#039;broker.outbound.trovimap.com&#039;, &#039;pisos.com&#039;, &#039;aplaceinthesun.com&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/_inc.parse_providers.php:437
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &#039;pisos.com&#039;) {
    $html = preg_replace(&#039;/\s+/&#039;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, &#039;Nombre&lt;/b&gt;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
    $telefonoCons = get_string_between($html, &#039;Tel&eacute;fono&lt;/b&gt;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
    $emailCons = get_string_between($html, &#039;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt; &lt;a href=&quot;mailto:&#039;, &#039;&quot;&#039;);
    $referenciaCons = get_string_between($html, &#039;Referencia: &#039;, &#039; &lt;/td&gt;&#039;);
    $linkCons = get_string_between($html, &#039;Una persona est&aacute; interesada en tu &lt;a href=&quot;&#039;, &#039;&quot;&#039;);
    $comentarioCons = get_string_between($html, &#039;Comentarios&lt;/b&gt;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &#039;pisos.com&#039;) {
    $html = preg_replace(&#039;/\s+/&#039;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, &#039;Nombre&lt;/b&gt;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
    $telefonoCons = get_string_between($html, &#039;Tel&eacute;fono&lt;/b&gt;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
    $emailCons = get_string_between($html, &#039;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt; &lt;a href=&quot;mailto:&#039;, &#039;&quot;&#039;);
    $referenciaCons = get_string_between($html, &#039;Referencia: &#039;, &#039; &lt;/td&gt;&#039;);
    $linkCons = get_string_between($html, &#039;Una persona est&aacute; interesada en tu &lt;a href=&quot;&#039;, &#039;&quot;&#039;);
    $comentarioCons = get_string_between($html, &#039;Comentarios&lt;/b&gt;&lt;/td&gt; &lt;td style=&quot;text-align:left;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
}

if ($email-&gt;header-&gt;details-&gt;from[0]-&gt;host == &#039;aplaceinthesun.com&#039;) {
    $html = preg_replace(&#039;/\s+/&#039;, &quot; &quot;, trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, &#039;Name:&lt;/td&gt; &lt;td width=&quot;529&quot; bgcolor=&quot;#FFFFFF&quot; style=&quot;font-family: Arial, Georgia, \&#039;Times New Roman\&#039;, Times, serif; font-size: 12px; color: #000;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
    $telefonoCons = get_string_between($html, &#039;Telephone:&lt;/td&gt; &lt;td bgcolor=&quot;#FFFFFF&quot; style=&quot;font-family: Arial, Georgia, \&#039;Times New Roman\&#039;, Times, serif; font-size: 12px; color: #000;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
    $emailCons = get_string_between($html, &#039;&lt;a style=\&#039;color:#00008B;\&#039; href=&quot;mailto:&#039;, &#039;&quot;&#039;);
    $referenciaCons = get_string_between($html, &#039;Your Reference:&lt;/strong&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#FFFFFF&quot; style=&quot;font-family: Arial, Georgia, \&#039;Times New Roman\&#039;, Times, serif; font-size: 12px; color: #000;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
    $linkCons = get_string_between($html, &#039;View Property:&lt;/strong&gt;&lt;/td&gt; &lt;td bgcolor=&quot;#FFFFFF&quot; style=&quot;font-family: Arial, Georgia, \&#039;Times New Roman\&#039;, Times, serif; font-size: 12px; color: #000;&quot;&gt;&lt;a href=&quot;&#039;, &#039;&quot;&#039;);
    $comentarioCons = get_string_between($html, &#039;Comments:&lt;/td&gt; &lt;td bgcolor=&quot;#FFFFFF&quot; style=&quot;font-family: Arial, Georgia, \&#039;Times New Roman\&#039;, Times, serif; font-size: 12px; color: #000;&quot;&gt;&#039;, &#039;&lt;/td&gt;&#039;);
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
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo en noticias del front
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/new.php:348
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
/modules/news/new.php:365
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$img = &#039;&lt;img src=&quot;/media/images/news/&#039;.$images[($i)][&quot;image_img&quot;].&#039;&quot; class=&quot;img-auto&quot; alt=&quot;&#039;.$images[($i)][&quot;alt&quot;].&#039;&quot; /&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$img = &#039;&lt;img src=&quot;/media/images/news/&#039;.$images[($i)][&quot;image_img&quot;].&#039;&quot; class=&quot;mg-fluid&quot; alt=&quot;&#039;.$images[($i)][&quot;alt&quot;].&#039;&quot; /&gt;&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Faltan carpetas en el master
    </h6>
    <div class="card-body">
        Añadir las siguientes capteas al master:
        <pre>
            <code class="makefile">
/media/files/data
/media/files/owners
/media/files/properties
/intramedianet/properties/upload/
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec8">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Al enviar un mail desde cruces con una plantilla, no se remplaza {{CLIENT}}
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send.php:114
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsCli = &quot;SELECT * FROM properties_client WHERE email_cli = &#039;&quot;.$_GET[&#039;email&#039;].&quot;&#039; &quot;;
$rsCli = mysqli_query($inmoconn, $query_rsCli) or die(mysqli_error());
$row_rsCli = mysqli_fetch_assoc($rsCli);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsCli = &quot;SELECT * FROM properties_client WHERE email_cli = &#039;&quot;.$_GET[&#039;email&#039;].&quot;&#039; &quot;;
$rsCli = mysql_query($query_rsCli, $inmoconn) or die(mysql_error());
$row_rsCli = mysql_fetch_assoc($rsCli);

mysql_select_db($database_inmoconn, $inmoconn);
$query_rsClienMail = &quot;SELECT * FROM properties_client WHERE email_cli = &#039;&quot;.$_GET[&#039;email&#039;].&quot;&#039;&quot;;
$rsClienMail = mysql_query($query_rsClienMail, $inmoconn) or die(mysql_error());
$row_rsClienMail = mysql_fetch_assoc($rsClienMail);
$totalRows_rsClienMail = mysql_num_rows($rsClienMail);

if ($totalRows_rsClienMail &gt; 0) {
    $body = str_replace(&#039;{{CLIENT}}&#039;, $row_rsClienMail[&#039;nombre_cli&#039;], $body);
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec9">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix errores al activar Letsinmo
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:5
/intramedianet/includes/inc.sidebar.php:592
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actLestinmo == 0): ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/forgot_password.php:122
/intramedianet/forgot_password.php:211
/intramedianet/forgot_password.php:223
/intramedianet/forgot_password.php:279
/intramedianet/index.php:104
/intramedianet/index.php:181
/intramedianet/index.php:193
/intramedianet/index.php:250
/intramedianet/includes/inc.head.php:38
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actLestinmo == 0): ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec10">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en enviar emails a clientes desde el CRM
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
ini_set(&#039;display_errors&#039;, 1);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
ini_set(&#039;display_errors&#039;, 0);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec11">
        <span class="badge badge-dark">11</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo ortográfico en imagen
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:100
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th class=&quot;text-truncate&quot;&gt;&lt;?php __(&#039;Im&aacute;gen&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th class=&quot;text-truncate&quot;&gt;&lt;?php __(&#039;Imagen&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
