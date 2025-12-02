<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 2 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 12-07-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Problema Google Recaptcha en modals</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Fallo en la alerta del formulario de información inmueble</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Problema Google Recaptcha en modals
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/website.scss:1869
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
.modal {
    .modal-body {
        font-size: 14px;
        .checkbox {
            font-size: 12px;
        }
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
.modal {
    z-index: 2000000000;
    .g-recaptcha iframe {
            transform: scale(.9);
            transform-origin: 0;
        @include media-breakpoint-up(md) {
            transform: none;
            transform-origin: none;
        }
    }
    .modal-body {
        font-size: 14px;
        .checkbox {
            font-size: 12px;
        }
    }
}
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo en la alerta del formulario de información inmueble
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:542
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$('#similares-properties-modal .slides').resize();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$('#similares-properties-modal .slides').resize();
swal('', okConsult, 'success');
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>