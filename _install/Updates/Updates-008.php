<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 3-06-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Falta texto de eliminar favoritos en inglés</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Al compartir una propiedad en redes sociales no se muestra la foto</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> La selección de idiomas en la versión iPad landscape no funciona</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Falta texto de eliminar favoritos en inglés
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php:255
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Eliminar todos los favoritos&quot;] = &quot;Remove all favorites&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Eliminar todos los favoritos&quot;] = &quot;Remove all favorites&quot;;
$langStr[&quot;&iquest;Seguro que desea eliminar todos los favoritos?&quot;] = &quot;&iquest;Seguro que desea eliminar todos los favoritos?&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Al compartir una propiedad en redes sociales no se muestra la foto
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/property.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (preg_match(&#039;/http:\/\//&#039;, $property[0][&#039;image_img&#039;])) {
    $img = $property[0][&#039;image_img&#039;];
} else {
    $img = &#039;http://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/properties/&#039; . $property[0][&#039;image_img&#039;];
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$img = &#039;https://&#039; . $_SERVER[&#039;HTTP_HOST&#039;] . &#039;/media/images/properties/thumbnails/&#039; . $property[0][&#039;id_img&#039;] . &#039;_lg.jpg&#039;;
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> La selección de idiomas en la versión iPad landscape no funciona
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:52
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$('#main-nav [data-toggle="dropdown"], .main-header-top [data-toggle="dropdown"], #footer [data-toggle="dropdown"]').bootstrapDropdownHover();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$('#main-nav [data-toggle="dropdown"], #footer [data-toggle="dropdown"]').bootstrapDropdownHover();
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
