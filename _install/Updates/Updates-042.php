<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 3 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 30-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Los desplegables de fechas no respeta el idioma ni el primer día de la semana</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes exportador Ubiflow</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Error log vendedores y compradores</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Los desplegables de fechas no respeta el idioma ni el primer día de la semana
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/_js/calendar-view.js:15
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
jQuery(&#039;.datetimepicker&#039;).datetimepicker({
 lang: AppLang,
 format:&#039;d-m-Y H:i&#039;,
 step: 15,
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
jQuery(&#039;.datetimepicker&#039;).datetimepicker({
  lang: AppLang,
  format:&#039;d-m-Y H:i&#039;,
  step: 15,
  dayOfWeekStart:1,
});
$.datetimepicker.setLocale(AppLang);
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes exportador Ubiflow
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/ubiflow.php:120
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AND descripcion_en_prop != &#039;&#039;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
AND descripcion_en_prop != &#039;&#039;
AND ubiflow_type_prop != &lsquo;&#039;
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Error log vendedores y compradores
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php:10
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsProp = &quot;INSERT INTO `properties_client_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &#039;&quot;.$user.&quot;&#039;, &#039;&quot;.$id.&quot;&#039;, &#039;&quot;.$ref.&quot;&#039;, &#039;&quot;.$action.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;)&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsProp = &quot;INSERT INTO `properties_client_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &#039;&quot;.$user.&quot;&#039;, &#039;&quot;.$id.&quot;&#039;, &#039;&quot;.mysql_real_escape_string($ref).&quot;&#039;, &#039;&quot;.$action.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;)&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mediaelx/functions.php:21
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsProp = &quot;INSERT INTO `properties_owner_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &#039;&quot;.$user.&quot;&#039;, &#039;&quot;.$id.&quot;&#039;, &#039;&quot;.$ref.&quot;&#039;, &#039;&quot;.$action.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;)&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsProp = &quot;INSERT INTO `properties_owner_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &#039;&quot;.$user.&quot;&#039;, &#039;&quot;.$id.&quot;&#039;, &#039;&quot;.mysql_real_escape_string($ref).&quot;&#039;, &#039;&quot;.$action.&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039;)&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>