<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 21-02-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i>  Error Historial Propiedades</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i>  Error Historial Propiedades
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:509
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function logprop($user, $id, $ref, $action) {

    global $database_inmoconn, $inmoconn;

    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsProp = &quot;INSERT INTO `properties_client_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &apos;&quot;.$user.&quot;&apos;, &apos;&quot;.$id.&quot;&apos;, &apos;&quot;.$ref.&quot;&apos;, &apos;&quot;.$action.&quot;&apos;, &apos;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&apos;)&quot;;
    $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());


}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function logprop($user, $id, $ref, $action) {

    global $database_inmoconn, $inmoconn;

    mysql_select_db($database_inmoconn, $inmoconn);
    $query_rsProp = &quot;INSERT INTO `properties_log` (`id_log`, `user_log`, `prop_id_log`, `referencia_log`, `action_log`, `date_log`) VALUES (NULL, &apos;&quot;.$user.&quot;&apos;, &apos;&quot;.$id.&quot;&apos;, &apos;&quot;.$ref.&quot;&apos;, &apos;&quot;.$action.&quot;&apos;, &apos;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&apos;)&quot;;
    $rsProp = mysql_query($query_rsProp, $inmoconn) or die(mysql_error());


}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>