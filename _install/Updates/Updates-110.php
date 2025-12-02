<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 16-09-2024</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Se desactivan las exportaciones al salvar un agente un inmueble</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Al intentar eliminar un consulta desde el listado de consultas de la web da error</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido Letsinmo al panel</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Error con la obra nueva en el exporttador A place in the Sun</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Se desactivan las exportaciones al salvar un agente un inmueble
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1532
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#tabportales&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php __(&apos;Propiedades exportadas&apos;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if($_SESSION[&apos;kt_login_level&apos;] == 9) { ?&gt;
&lt;li class=&quot;nav-item mt-2 mt-md-0&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link px-2 py-1 fw-ligther border ms-2 border-primary&quot; style=&quot;font-size: 12px!important;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#tabportales&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php __(&apos;Propiedades exportadas&apos;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3730
            </code>
        </pre>
        Eliminamos:
        <pre>
            <code class="php">
&lt;?php if($_SESSION[&apos;kt_login_level&apos;] == 9) { ?&gt;p
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4192
            </code>
        </pre>
        Eliminamos:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Al intentar eliminar un consulta desde el listado de consultas de la web da error
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/remove_client_from_consulta.php:6
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$rsBajadas = mysqli_query($inmoconn, $query_rsBajadas) or die(mysqli_error());
$row_rsBajadas = mysqli_fetch_assoc($rsBajadas);
$totalRows_rsBajadas = mysqli_num_rows($rsBajadas);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$rsBajadas = mysqli_query($inmoconn, $query_rsBajadas) or die(mysqli_error());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido Letsinmo al panel
    </h6>
    <div class="card-body">
        Subimos el archivo: /Connections/conf/letsinmo.php
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/inmoconn.php:47
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/Connections/conf/idiomas.php&apos;)
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/Connections/conf/letsinmo.php&apos;);
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/Connections/conf/idiomas.php&apos;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:45
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$expMLSMediaelx = 0;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$expMLSMediaelx = 0;

If($actLestinmo == 1) {
    $expKyero = 1;
    $expThinkSpain = 1;
    $expMLSMediaelx = 1;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/niveles.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$actRegister = 0;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$actRegister = 0;

If($actLestinmo == 1) {
    $$actEmpleados = 0;
    $$actAgente = 0;
    $$actUsuarios = 0;
    $$actRegister = 0;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/import-xml.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$xmlImport = 0;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$xmlImport = 0;

If($actLestinmo == 1) {
    $xmlImport = 1;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:571
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/xml/proveedores.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&apos;/\/xml\/proveedores/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&apos;XML de agencias&apos;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actLestinmo == 0): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/xml/proveedores.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&apos;/\/xml\/proveedores/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&apos;XML de agencias&apos;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/webpack.mix.js:48
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
mix.sass(&apos;intramedianet/includes/assets/_custom/custom.scss&apos;, &apos;intramedianet/includes/assets/css/custom.min.css&apos;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
mix.sass(&apos;intramedianet/includes/assets/_custom/custom.scss&apos;, &apos;intramedianet/includes/assets/css/custom.min.css&apos;);

mix.sass(&apos;intramedianet/includes/assets/scss/config/default/app-letsinmo.scss&apos;, &apos;intramedianet/includes/assets/css/app-letsinmo.min.css&apos;);
mix.sass(&apos;intramedianet/includes/assets/_custom/custom-letsinmo.scss&apos;, &apos;intramedianet/includes/assets/css/custom-letsinmo.min.css&apos;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.head.php:38
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;!-- App Css--&gt;
&lt;link href=&quot;/intramedianet/includes/assets/css/app.min.css?id=&lt;?php echo filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/intramedianet/includes/assets/css/app.min.css&apos;); ?&gt;&quot; id=&quot;app-style&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;
&lt;!-- custom Css--&gt;
&lt;link href=&quot;/intramedianet/includes/assets/css/custom.min.css?id=&lt;?php echo filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/intramedianet/includes/assets/css/custom.min.css&apos;); ?&gt;&quot; id=&quot;app-style&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
    &lt;!-- App Css--&gt;
    &lt;link href=&quot;/intramedianet/includes/assets/css/app.min.css?id=&lt;?php echo filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/intramedianet/includes/assets/css/app.min.css&apos;); ?&gt;&quot; id=&quot;app-style&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;
    &lt;!-- custom Css--&gt;
    &lt;link href=&quot;/intramedianet/includes/assets/css/custom.min.css?id=&lt;?php echo filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/intramedianet/includes/assets/css/custom.min.css&apos;); ?&gt;&quot; id=&quot;app-style&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;
&lt;?php else: ?&gt;
    &lt;!-- App Css--&gt;
    &lt;link href=&quot;/intramedianet/includes/assets/css/app-letsinmo.min.css?id=&lt;?php echo filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/intramedianet/includes/assets/css/app.min.css&apos;); ?&gt;&quot; id=&quot;app-style&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;
    &lt;link href=&quot;/intramedianet/includes/assets/css/custom-letsinmo.min.css?id=&lt;?php echo filemtime($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &apos;/intramedianet/includes/assets/css/custom.min.css&apos;); ?&gt;&quot; id=&quot;app-style&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Subimos los archivos y recompilamos:<br>
/intramedianet/includes/assets/scss/config/default/_theme-light-letsinmo.scss<br>
/intramedianet/includes/assets/scss/config/default/_variables-letsinmo.scss<br>
/intramedianet/includes/assets/scss/config/default/app-letsinmo.scss<br>
/intramedianet/includes/assets/_custom/custom-letsinmo.scss
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;!-- Dark Logo--&gt;
&lt;a href=&quot;/intramedianet/inicio/inicio.php&quot; class=&quot;logo logo-dark&quot;&gt;
    &lt;span class=&quot;logo-sm&quot;&gt;
        &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm.svg&quot; alt=&quot;&quot; height=&quot;22&quot;&gt;
    &lt;/span&gt;
    &lt;span class=&quot;logo-lg&quot;&gt;
        &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg.svg&quot; alt=&quot;&quot; height=&quot;17&quot;&gt;
    &lt;/span&gt;
&lt;/a&gt;
&lt;!-- Light Logo--&gt;
&lt;a href=&quot;/intramedianet/inicio/inicio.php&quot; class=&quot;logo logo-light&quot;&gt;
    &lt;span class=&quot;logo-sm&quot;&gt;
        &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm.svg&quot; alt=&quot;&quot; height=&quot;22&quot;&gt;
    &lt;/span&gt;
    &lt;span class=&quot;logo-lg&quot;&gt;
        &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg.svg&quot; alt=&quot;&quot; height=&quot;17&quot;&gt;
    &lt;/span&gt;
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
    &lt;!-- Dark Logo--&gt;
    &lt;a href=&quot;/intramedianet/inicio/inicio.php&quot; class=&quot;logo logo-dark&quot;&gt;
        &lt;span class=&quot;logo-sm&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm.svg&quot; alt=&quot;&quot; height=&quot;22&quot;&gt;
        &lt;/span&gt;
        &lt;span class=&quot;logo-lg&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg.svg&quot; alt=&quot;&quot; height=&quot;17&quot;&gt;
        &lt;/span&gt;
    &lt;/a&gt;
    &lt;!-- Light Logo--&gt;
    &lt;a href=&quot;/intramedianet/inicio/inicio.php&quot; class=&quot;logo logo-light&quot;&gt;
        &lt;span class=&quot;logo-sm&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm.svg&quot; alt=&quot;&quot; height=&quot;22&quot;&gt;
        &lt;/span&gt;
        &lt;span class=&quot;logo-lg&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg.svg&quot; alt=&quot;&quot; height=&quot;17&quot;&gt;
        &lt;/span&gt;
    &lt;/a&gt;
&lt;?php else: ?&gt;
    &lt;!-- Dark Logo--&gt;
    &lt;a href=&quot;/intramedianet/inicio/inicio.php&quot; class=&quot;logo logo-dark&quot;&gt;
        &lt;span class=&quot;logo-sm&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm-letsinmo.svg&quot; alt=&quot;&quot; height=&quot;22&quot;&gt;
        &lt;/span&gt;
        &lt;span class=&quot;logo-lg&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-letsinmo.svg&quot; alt=&quot;&quot; height=&quot;17&quot;&gt;
        &lt;/span&gt;
    &lt;/a&gt;
    &lt;!-- Light Logo--&gt;
    &lt;a href=&quot;/intramedianet/inicio/inicio.php&quot; class=&quot;logo logo-light&quot;&gt;
        &lt;span class=&quot;logo-sm&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm-letsinmo.svg&quot; alt=&quot;&quot; height=&quot;22&quot;&gt;
        &lt;/span&gt;
        &lt;span class=&quot;logo-lg&quot;&gt;
            &lt;img src=&quot;/intramedianet/includes/assets/imgs/mediaelx-1l-wg-letsinmo.svg&quot; alt=&quot;&quot; height=&quot;17&quot;&gt;
        &lt;/span&gt;
    &lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/index.php:104
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
background: url(https://mediaelx.net/media/images/banner-rss/login-bg.png) no-repeat center center fixed;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
    background: url(https://mediaelx.net/media/images/banner-rss/login-bg.png) no-repeat center center fixed;
&lt;?php else: ?&gt;
    background: url(https://mediaelx.net/media/images/banner-rss/login-bg-letsinmo.png) no-repeat center center fixed;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/index.php:179
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
.btn-success {
    color: #1f1f1f;
    background-color: #2ed9c3;
    border: solid 1px #2ed9c3;

}

.btn-success:hover {
    color: #1f1f1f;
    background-color: #33f7de;

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
.btn-success {
    color: #1f1f1f;
    &lt;?php if ($xmlImport == 0): ?&gt;
        background-color: #2ed9c3;
        border: solid 1px #2ed9c3;
    &lt;?php else: ?&gt;
        background-color: #01b5e8;
        border: solid 1px #01b5e8;
    &lt;?php endif ?&gt;

}

.btn-success:hover {
    color: #1f1f1f;
    &lt;?php if ($xmlImport == 0): ?&gt;
        background-color: #33f7de;
        border: solid 1px #33f7de;
    &lt;?php else: ?&gt;
        background-color: #139dc9;
        border: solid 1px #139dc9;
    &lt;?php endif ?&gt;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/forgot_password.php:240
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;img src=&quot;https://mediaelx.net/media/images/banner-rss/login-logo.svg&quot; alt=&quot;Mediaelx&quot; class=&quot;mb-5 img-fluid&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
    &lt;img src=&quot;https://mediaelx.net/media/images/banner-rss/login-logo.svg&quot; alt=&quot;Mediaelx&quot; class=&quot;mb-5 img-fluid&quot;&gt;
&lt;?php else: ?&gt;
    &lt;img src=&quot;https://mediaelx.net/media/images/banner-rss/login-logo-letsinmo.svg&quot; alt=&quot;Mediaelx&quot; class=&quot;mb-5 img-fluid&quot;&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/forgot_password.php:122
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
background: url(https://mediaelx.net/media/images/banner-rss/login-bg.png) no-repeat center center fixed;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
    background: url(https://mediaelx.net/media/images/banner-rss/login-bg.png) no-repeat center center fixed;
&lt;?php else: ?&gt;
    background: url(https://mediaelx.net/media/images/banner-rss/login-bg-letsinmo.png) no-repeat center center fixed;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/forgot_password.php:209
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
.btn-success {
    color: #1f1f1f;
    background-color: #2ed9c3;
    border: solid 1px #2ed9c3;

}

.btn-success:hover {
    color: #1f1f1f;
    background-color: #33f7de;

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
.btn-success {
    color: #1f1f1f;
    &lt;?php if ($xmlImport == 0): ?&gt;
        background-color: #2ed9c3;
        border: solid 1px #2ed9c3;
    &lt;?php else: ?&gt;
        background-color: #01b5e8;
        border: solid 1px #01b5e8;
    &lt;?php endif ?&gt;

}

.btn-success:hover {
    color: #1f1f1f;
    &lt;?php if ($xmlImport == 0): ?&gt;
        background-color: #33f7de;
        border: solid 1px #33f7de;
    &lt;?php else: ?&gt;
        background-color: #139dc9;
        border: solid 1px #139dc9;
    &lt;?php endif ?&gt;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/index.php:270
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;img src=&quot;https://mediaelx.net/media/images/banner-rss/login-logo.svg&quot; alt=&quot;Mediaelx&quot; class=&quot;mb-5 img-fluid&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($xmlImport == 0): ?&gt;
    &lt;img src=&quot;https://mediaelx.net/media/images/banner-rss/login-logo.svg&quot; alt=&quot;Mediaelx&quot; class=&quot;mb-5 img-fluid&quot;&gt;
&lt;?php else: ?&gt;
    &lt;img src=&quot;https://mediaelx.net/media/images/banner-rss/login-logo-letsinmo.svg&quot; alt=&quot;Mediaelx&quot; class=&quot;mb-5 img-fluid&quot;&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Subimos los archivos:<br>
/intramedianet/includes/assets/imgs/mediaelx-1l-wg-letsinmo-sm.svg<br>
/intramedianet/includes/assets/imgs/mediaelx-1l-wg-letsinmo.svg
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.footer.php:10
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php echo date(&#039;Y&#039;); ?&gt; &copy; Mediaelx Digital Agency
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php echo date(&#039;Y&#039;); ?&gt; &copy;
&lt;?php if ($xmlImport == 0): ?&gt;
    Mediaelx Digital Agency
&lt;?php else: ?&gt;
    Mediaelx Let&#039;s Inmo
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Error con la obra nueva en el exporttador A place in the Sun
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/apits.php:173
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($row_rsProperties[&apos;slug_sta&apos;] == &apos;new_build&apos;) { ?&gt;
&lt;price_freq&gt;sale&lt;/price_freq&gt;
&lt;new_build&gt;1&lt;/new_build&gt;
&lt;?php } else { ?&gt;
&lt;price_freq&gt;&lt;?php echo $row_rsProperties[&apos;slug_sta&apos;] ?&gt;&lt;/price_freq&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($row_rsProperties[&apos;slug_sta&apos;] == &apos;new_build&apos;) { ?&gt;
&lt;price_freq&gt;sale&lt;/price_freq&gt;
&lt;new_build&gt;1&lt;/new_build&gt;
&lt;?php } else { ?&gt;
&lt;price_freq&gt;&lt;?php echo $row_rsProperties[&apos;slug_sta&apos;] ?&gt;&lt;/price_freq&gt;
&lt;new_build&gt;0&lt;/new_build&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

