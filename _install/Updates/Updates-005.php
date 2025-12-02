<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 4 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 24-05-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras en la página de login y recordar contraseña</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Eliminado error del panel producido por datepicker</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-plus-circle text-success"></i> Cambiada la vista por defecto a Semana en el calendario del inicio del panel</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras en la página de login y recordar contraseña
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/feed.php:30
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;br&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;br&gt;
&lt;?php if ($lang_adm == &quot;es&quot;): ?&gt;
    &lt;a href=&quot;https://mediaelx.net/contactar/&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;/css/check/imgs/es.jpg&quot; alt=&quot;Contactar&quot; class=&quot;img-fluid&quot;&gt;&lt;/a&gt;
&lt;?php else: ?&gt;
    &lt;a href=&quot;https://english.mediaelx.net/contact/&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;/css/check/imgs/es.jpg&quot; alt=&quot;Contact&quot; class=&quot;img-fluid&quot;&gt;&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/index.php:329
/intramedianet/forgot_password.php:244
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
autoplaySpeed: 10000,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
autoplaySpeed: 10000,
fade: true,
            </code>
        </pre>
        <hr>
        Subir los archivos:
        <pre>
            <code class="makefile">
/css/check/imgs/es.jpg
/css/check/imgs/en.jpg
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminado error del panel producido por datepicker
    </h6>
    <div class="card-body">
        Sustituir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/assets/js/plugins.js
            </code>
        </pre>
        Por el archivo de esta versión localizado en:
        <pre>
            <code class="php">
/intramedianet/includes/assets/js/plugins.js
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Cambiada la vista por defecto a Semana en el calendario del inicio del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/inicio/_js/dashboard.js:49
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
defaultView: "agenda31Days",
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
defaultView: "agendaWeek",
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

