<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 3-12-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en Search Criteria - Formulario de Compradores</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Error traducción</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en Search Criteria - Formulario de Compradores
    </h6>
    <div class="card-body">
        Sustituir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli-int.php
/intramedianet/properties/properties-client-data-cli-noint.php
/intramedianet/properties/_js/clients-form.js
            </code>
        </pre>
        Por los de esta versión.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error traducción
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php:371
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;Distancia al aereopuerto&#039;] = &#039;Distancia al aereopuerto&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang[&#039;Distancia al aereopuerto&#039;] = &#039;Distancia al aeropuerto&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>