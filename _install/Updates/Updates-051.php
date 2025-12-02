<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 10-12-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Envío de correos en clientes interesados con copia oculta</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Envío de correos en clientes interesados con copia oculta
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send.php:112
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (sendAppEmail(array($_GET[&#039;email&#039;] =&gt; $_GET[&#039;nombre&#039;]), &#039;&#039;, &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>