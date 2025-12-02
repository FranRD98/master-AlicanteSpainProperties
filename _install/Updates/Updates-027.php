<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 03-09-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Las tareas completadas todavía salen en los informes diarios como tarea del día</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Bloquear ULR Mapas de Propiedades</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Las tareas completadas todavía salen en los informes diarios como tarea del día
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/send-citas.php:111
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE DATE(date_due_tsk) &lt;= DATE(NOW()) AND admin_tsk = &#039;&quot; . $row_rsusuarios[&#039;id_usr&#039;] . &quot;&#039;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
WHERE DATE(date_due_tsk) &lt;= DATE(NOW()) AND admin_tsk = &#039;&quot; . $row_rsusuarios[&#039;id_usr&#039;] . &quot;&#039; AND status_tsk != 2&quot;;
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Bloquear ULR Mapas de Propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/resources/urls.php:51
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$urlStr[&quot;property-map&quot;] = array(
    &#039;da&#039; =&gt; &#039;ejendomme-kort&#039;,
    &#039;de&#039; =&gt; &#039;eigenschaften-karte&#039;,
    &#039;en&#039; =&gt; &#039;properties-map&#039;,
    &#039;es&#039; =&gt; &#039;mapa-de-propiedades&#039;,
    &#039;fi&#039; =&gt; &#039;ominaisuudet-kartta&#039;,
    &#039;fr&#039; =&gt; &#039;carte-des-proprietes&#039;,
    &#039;is&#039; =&gt; &#039;eiginleikar-kort&#039;,
    &#039;nl&#039; =&gt; &#039;eigenschappen-kaart&#039;,
    &#039;no&#039; =&gt; &#039;egenskaper-kart&#039;,
    &#039;ru&#039; =&gt; &#039;svojstva-karty&#039;,
    &#039;se&#039; =&gt; &#039;egenskaper-karta&#039;,
    &#039;zh&#039; =&gt; &#039;properties-map&#039;,
    &#039;mostrar-en-sitemap&#039; =&gt; &#039;0&#039;
);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($actMapaPropiedades == 1) {
    $urlStr[&quot;property-map&quot;] = array(
        &#039;da&#039; =&gt; &#039;ejendomme-kort&#039;,
        &#039;de&#039; =&gt; &#039;eigenschaften-karte&#039;,
        &#039;en&#039; =&gt; &#039;properties-map&#039;,
        &#039;es&#039; =&gt; &#039;mapa-de-propiedades&#039;,
        &#039;fi&#039; =&gt; &#039;ominaisuudet-kartta&#039;,
        &#039;fr&#039; =&gt; &#039;carte-des-proprietes&#039;,
        &#039;is&#039; =&gt; &#039;eiginleikar-kort&#039;,
        &#039;nl&#039; =&gt; &#039;eigenschappen-kaart&#039;,
        &#039;no&#039; =&gt; &#039;egenskaper-kart&#039;,
        &#039;ru&#039; =&gt; &#039;svojstva-karty&#039;,
        &#039;se&#039; =&gt; &#039;egenskaper-karta&#039;,
        &#039;zh&#039; =&gt; &#039;properties-map&#039;,
        &#039;mostrar-en-sitemap&#039; =&gt; &#039;0&#039;
    );
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>