<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 5 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 26-07-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Error en interested-buyers</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> No se muestra el botón GDPR en la intramendianet si no se activa Mailchimp</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error al añadir tareas sin seleccionar estado</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> No se generan miniaturas de png y gifs</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Cuando se generan las miniaturas el frontend no muestra las imágenes con watermark</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en interested-buyers
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/interested-clients.php:307
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
array_push($refArrayVals , &quot;&#039;&quot;.$value.&quot;&#039;&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
array_push($refArrayVals , &quot;&#039;&quot;.$refElement.&quot;&#039;&quot;);
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> No se muestra el botón GDPR en la intramendianet si no se activa Mailchimp
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:900
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;?php if ($actMailchimp == 1): ?&gt;
    &lt;div class=&quot;checkbox&quot;&gt;
      &lt;label&gt;
          &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client[&#039;newsletter_cli&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_cli&quot; id=&quot;newsletter_cli&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
          &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
      &lt;/label&gt;
    &lt;/div&gt;
    &lt;?php if ($_GET[&#039;id_cli&#039;] != &#039;&#039;): ?&gt;
    &lt;a href=&quot;/intramedianet/gdpr/clients.php?id=&lt;?php echo $_GET[&#039;id_cli&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm&quot;  data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&#039;Recuerde guardar el cliente para ver los ultimos datos&#039;); ?&gt;&quot;&gt;GDPR&lt;/a&gt;
    &lt;?php endif ?&gt;
    &lt;?php endif ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-md-6&quot;&gt;
    &lt;?php if ($actMailchimp == 1): ?&gt;
    &lt;div class=&quot;checkbox&quot;&gt;
      &lt;label&gt;
          &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_client[&#039;newsletter_cli&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_cli&quot; id=&quot;newsletter_cli&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
          &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
      &lt;/label&gt;
    &lt;/div&gt;
    &lt;?php endif ?&gt;
    &lt;?php if ($_GET[&#039;id_cli&#039;] != &#039;&#039;): ?&gt;
    &lt;a href=&quot;/intramedianet/gdpr/clients.php?id=&lt;?php echo $_GET[&#039;id_cli&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm&quot;  data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&#039;Recuerde guardar el cliente para ver los ultimos datos&#039;); ?&gt;&quot;&gt;GDPR&lt;/a&gt;
    &lt;?php endif ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:603
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($actMailchimp == 1): ?&gt;
&lt;div class=&quot;checkbox&quot;&gt;
    &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner[&#039;newsletter_pro&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_pro&quot; id=&quot;newsletter_pro&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
        &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;newsletter_pro&quot;); ?&gt;
&lt;/div&gt;
&lt;?php if ($_GET[&#039;id_pro&#039;] != &#039;&#039;): ?&gt;
&lt;a href=&quot;/intramedianet/gdpr/owners.php?id=&lt;?php echo $_GET[&#039;id_pro&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm&quot;  data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&#039;Recuerde guardar el propietario para ver los ultimos datos&#039;); ?&gt;&quot;&gt;GDPR&lt;/a&gt;
&lt;?php endif ?&gt;

&lt;hr&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($actMailchimp == 1): ?&gt;
&lt;div class=&quot;checkbox&quot;&gt;
    &lt;label&gt;
        &lt;input  &lt;?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_owner[&#039;newsletter_pro&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; type=&quot;checkbox&quot; name=&quot;newsletter_pro&quot; id=&quot;newsletter_pro&quot; value=&quot;1&quot; class=&quot;onoffbtn&quot; /&gt;
        &lt;?php __(&#039;A&ntilde;adir a la newsletter&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_owner&quot;, &quot;newsletter_pro&quot;); ?&gt;
&lt;/div&gt;
&lt;?php endif ?&gt;
&lt;?php if ($_GET[&#039;id_pro&#039;] != &#039;&#039;): ?&gt;
&lt;a href=&quot;/intramedianet/gdpr/owners.php?id=&lt;?php echo $_GET[&#039;id_pro&#039;]; ?&gt;&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary btn-sm&quot;  data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot;  title=&quot;&lt;?php __(&#039;Recuerde guardar el propietario para ver los ultimos datos&#039;); ?&gt;&quot;&gt;GDPR&lt;/a&gt;
&lt;?php endif ?&gt;

&lt;hr&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al añadir tareas sin seleccionar estado
    </h6>
    <div class="card-body">
        Ejecutar la siguiente query en la base de datos:
        <pre>
            <code class="sql">
ALTER TABLE `tasks` CHANGE COLUMN `status_tsk` `status_tsk` INT(11) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `priority_tsk`;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> No se generan miniaturas de png y gifs
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php:317
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] == &#039;&#039;) {
    list($width, $heigth) = getimgsizeRemote($image);
    $exif[&#039;COMPUTED&#039;][&#039;Height&#039;] = $heigth;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] == &#039;&#039;) {
    list($width, $heigth) = getimgsizeRemote($image);
    $exif[&#039;COMPUTED&#039;][&#039;Height&#039;] = $heigth;
}
if ($exif[&#039;COMPUTED&#039;][&#039;Height&#039;] == &#039;0&#039;) {
    $exif[&#039;COMPUTED&#039;][&#039;Width&#039;] = 400;
    $exif[&#039;COMPUTED&#039;][&#039;Height&#039;] = 800;
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
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Cuando se generan las miniaturas el frontend no muestra las imágenes con watermark
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php:334
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
if ($actWatermark == 1 &amp;&amp; $key != &#039;sm&#039;) {
    $imgLocalURL = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/media/images/&#039; . $folder . &#039;/thumbnails/&#039; . $id . &#039;_w_&#039; . $key . &#039;.jpg&#039;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>